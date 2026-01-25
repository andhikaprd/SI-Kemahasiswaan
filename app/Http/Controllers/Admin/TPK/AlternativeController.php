<?php

namespace App\Http\Controllers\Admin\TPK;

use App\Http\Controllers\Controller;
use App\Models\TpkAlternative;
use App\Models\TpkCriterion;
use App\Models\TpkScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AlternativeController extends Controller
{
    private function nextAlternativeIndex(): int
    {
        $max = TpkAlternative::where('code', 'like', 'A%')->get()
            ->map(function ($alt) {
                if (preg_match('/^A(\\d+)$/', $alt->code, $m)) {
                    return (int) $m[1];
                }
                return 0;
            })
            ->max();

        return ($max ?? 0) + 1;
    }

    public function index()
    {
        $needs_migration = false;
        $criteria = collect();
        $items = collect();
        $scores = [];
        if (Schema::hasTable('tpk_criteria') && Schema::hasTable('tpk_alternatives') && Schema::hasTable('tpk_scores')) {
            $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
            $items = TpkAlternative::orderBy('code')->get();
            foreach ($items as $alt) {
                $row = [];
                foreach ($criteria as $c) {
                    $row[$c->id] = optional(TpkScore::where('alternative_id', $alt->id)->where('criterion_id', $c->id)->first())->value ?? null;
                }
                $scores[$alt->id] = $row;
            }
        } else {
            $needs_migration = true;
        }
        return view('Admin.tpk.alternatives.index', compact('criteria','items','scores','needs_migration'));
    }

    public function create()
    {
        $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
        return view('Admin.tpk.alternatives.create', compact('criteria'));
    }

    public function store(Request $r)
    {
        $criteria = TpkCriterion::pluck('id');
        $nextCodeIndex = $this->nextAlternativeIndex();

        // Bulk input: multiple alternatives in one request
        if (is_array($r->input('alts'))) {
            $r->validate([
                'alts' => ['required', 'array', 'min:1'],
                'alts.*.code' => ['nullable', 'string', 'max:50', 'distinct'],
                'alts.*.name' => ['required', 'string', 'max:150'],
                'scores' => ['required', 'array'],
            ]);

            $created = 0;
            foreach ((array) $r->input('alts') as $idx => $row) {
                $name = trim((string) ($row['name'] ?? ''));
                if ($name === '') {
                    continue;
                }
                $code = trim((string) ($row['code'] ?? ''));
                if ($code === '') {
                    $code = 'A' . $nextCodeIndex;
                    $nextCodeIndex++;
                }
                if (TpkAlternative::where('code', $code)->exists()) {
                    $code = $code . '-' . uniqid();
                }

                $alt = TpkAlternative::create([
                    'code' => $code,
                    'name' => $name,
                    'note' => null,
                ]);
                $created++;

                foreach ($criteria as $cid) {
                    $val = $r->input("scores.$idx.$cid");
                    if ($val !== null && $val !== '') {
                        TpkScore::updateOrCreate(
                            ['alternative_id' => $alt->id, 'criterion_id' => $cid],
                            ['value' => (float) $val]
                        );
                    }
                }
            }

            return redirect()->route('admin.tpk.alternatives.index')
                ->with('success', "Alternatif ditambahkan ({$created} data).");
        }

        // Single input (legacy)
        $data = $r->validate([
            'code' => 'required|string|max:50|unique:tpk_alternatives,code',
            'name' => 'required|string|max:150',
            'note' => 'nullable|string',
        ]);
        $alt = TpkAlternative::create($data);
        foreach ($criteria as $cid) {
            $val = $r->input('crit.'.$cid);
            if ($val !== null && $val !== '') {
                TpkScore::updateOrCreate(
                    ['alternative_id'=>$alt->id,'criterion_id'=>$cid],
                    ['value'=>(float)$val]
                );
            }
        }
        return redirect()->route('admin.tpk.alternatives.index')->with('success','Alternatif ditambahkan.');
    }

    public function edit(TpkAlternative $alternative)
    {
        $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
        $values = TpkScore::where('alternative_id',$alternative->id)->pluck('value','criterion_id');
        return view('Admin.tpk.alternatives.edit', compact('alternative','criteria','values'));
    }

    public function update(Request $r, TpkAlternative $alternative)
    {
        $criteria = TpkCriterion::pluck('id');
        $data = $r->validate([
            'code' => 'required|string|max:50|unique:tpk_alternatives,code,'.$alternative->id,
            'name' => 'required|string|max:150',
            'note' => 'nullable|string',
        ]);
        $alternative->update($data);
        foreach ($criteria as $cid) {
            $val = $r->input('crit.'.$cid);
            if ($val === null || $val === '') {
                // remove if exists
                TpkScore::where('alternative_id',$alternative->id)->where('criterion_id',$cid)->delete();
                continue;
            }
            TpkScore::updateOrCreate(
                ['alternative_id'=>$alternative->id,'criterion_id'=>$cid],
                ['value'=>(float)$val]
            );
        }
        return redirect()->route('admin.tpk.alternatives.index')->with('success','Alternatif diperbarui.');
    }

    public function destroy(TpkAlternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('admin.tpk.alternatives.index')->with('success','Alternatif dihapus.');
    }
}
