<?php

namespace App\Http\Controllers\Admin\TPK;

use App\Http\Controllers\Controller;
use App\Models\TpkAlternative;
use App\Models\TpkCriterion;
use App\Models\TpkScore;
use Illuminate\Support\Facades\Schema;

class ComputeController extends Controller
{
    public function index()
    {
        $needs_migration = false;
        if (!Schema::hasTable('tpk_criteria') || !Schema::hasTable('tpk_alternatives') || !Schema::hasTable('tpk_scores')) {
            $needs_migration = true;
            $criteria = collect(); $alts = collect();
            $weights = collect(); $values = $normalized = []; $rows = [];
            return view('Admin.tpk.compute.index', compact('criteria','alts','weights','values','normalized','rows','needs_migration'));
        }

        $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
        $alts = TpkAlternative::orderBy('code')->get();

        $weightsRaw = $criteria->pluck('weight','id')->map(fn($v)=>(float)$v);
        $wSum = max(1e-9, $weightsRaw->sum());
        $weights = $weightsRaw->map(fn($v)=>$v/$wSum); // normalisasi ke jumlah 1

        // matrix nilai
        $values = [];
        foreach ($criteria as $c) {
            $col = [];
            foreach ($alts as $a) {
                $col[$a->id] = (float)(TpkScore::where('alternative_id',$a->id)->where('criterion_id',$c->id)->value('value') ?? 0);
            }
            $values[$c->id] = $col;
        }

        // normalisasi SAW
        $normalized = [];
        foreach ($criteria as $c) {
            $col = $values[$c->id];
            // Jika belum ada alternatif / kolom kosong, lewati saja
            if (empty($col)) {
                foreach ($alts as $a) {
                    $normalized[$c->id][$a->id] = 0;
                }
                continue;
            }
            $max = max(1e-9, max($col));
            $min = min($col);
            foreach ($alts as $a) {
                $x = $col[$a->id];
                if ($c->type === 'benefit') {
                    $r = $max > 0 ? ($x / $max) : 0;
                } else {
                    $r = ($x > 0) ? (($min <= 0 ? 0 : ($min / $x))) : 0; // cost
                }
                $normalized[$c->id][$a->id] = $r;
            }
        }

        // skor akhir
        $scores = [];
        foreach ($alts as $a) {
            $s = 0.0;
            foreach ($criteria as $c) {
                $s += $weights[$c->id] * ($normalized[$c->id][$a->id] ?? 0);
            }
            $scores[$a->id] = $s;
        }

        // ranking
        $rows = [];
        foreach ($alts as $a) {
            $rows[] = [
                'alt' => $a,
                'score' => round($scores[$a->id] ?? 0, 6),
            ];
        }
        usort($rows, fn($x,$y)=>$y['score']<=>$x['score']);
        foreach ($rows as $i=>&$r) { $r['rank']=$i+1; }
        unset($r);

        return view('Admin.tpk.compute.index', compact('criteria','alts','weights','values','normalized','rows','needs_migration'));
    }

    public function exportCsv()
    {
        $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
        $alts = TpkAlternative::orderBy('code')->get();
        $weightsRaw = $criteria->pluck('weight','id')->map(fn($v)=>(float)$v);
        $wSum = max(1e-9, $weightsRaw->sum());
        $weights = $weightsRaw->map(fn($v)=>$v/$wSum);

        // compute quickly (reuse logic)
        $values = [];$normalized=[];$scores=[];
        foreach ($criteria as $c) {
            $col = [];
            foreach ($alts as $a) { $col[$a->id]=(float)(TpkScore::where('alternative_id',$a->id)->where('criterion_id',$c->id)->value('value') ?? 0); }
            $values[$c->id]=$col;
            if (empty($col)) {
                foreach ($alts as $a) {
                    $normalized[$c->id][$a->id] = 0;
                }
                continue;
            }
            $max=max(1e-9,max($col)); $min=min($col);
            foreach ($alts as $a) {
                $x=$col[$a->id];
                $normalized[$c->id][$a->id] = $c->type==='benefit' ? ($x/$max) : (($x>0)?(($min<=0?0:($min/$x))):0);
            }
        }
        foreach ($alts as $a) {
            $s=0; foreach ($criteria as $c) { $s += $weights[$c->id]*($normalized[$c->id][$a->id]??0); }
            $scores[$a->id]=$s;
        }
        $rows=[]; foreach ($alts as $a){ $rows[]=['alt'=>$a,'score'=>round($scores[$a->id]??0,6)]; }
        usort($rows, fn($x,$y)=>$y['score']<=>$x['score']); foreach ($rows as $i=>&$r){$r['rank']=$i+1;} unset($r);

        $out = fopen('php://temp','w+'); fwrite($out, "\xEF\xBB\xBF");
        // header
        $head = ['Rank','Kode','Nama'];
        foreach ($criteria as $c) { $head[] = $c->code; }
        $head[] = 'Skor';
        fputcsv($out, $head);
        foreach ($rows as $r) {
            $alt = $r['alt'];
            $row = [$r['rank'],$alt->code,$alt->name];
            foreach ($criteria as $c) { $row[] = (string)($values[$c->id][$alt->id] ?? 0); }
            $row[] = $r['score'];
            fputcsv($out, $row);
        }
        rewind($out); $csv = stream_get_contents($out); fclose($out);
        return response($csv, 200, [
            'Content-Type'=>'text/csv; charset=UTF-8',
            'Content-Disposition'=>'attachment; filename="tpk_compute.csv"',
        ]);
    }
}
