<?php

namespace App\Http\Controllers\Admin\TPK;

use App\Http\Controllers\Controller;
use App\Models\TpkCriterion;
use App\Models\TpkPairwise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class PairwiseController extends Controller
{
    public function index()
    {
        $needs_migration = false;
        if (!Schema::hasTable('tpk_criteria') || !Schema::hasTable('tpk_pairwise')) {
            $needs_migration = true;
            $criteria = collect();
            $matrix = $normalized = $weights = $colSums = [];
            $consistency = [];
            $needs_criteria = true;
            return view('Admin.tpk.pairwise.index', compact('criteria', 'matrix', 'normalized', 'weights', 'colSums', 'consistency', 'needs_migration', 'needs_criteria'));
        }

        $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
        [$matrix, $normalized, $weights, $colSums, $consistency] = $this->buildAHP($criteria);
        $needs_criteria = $criteria->isEmpty();

        return view('Admin.tpk.pairwise.index', compact('criteria', 'matrix', 'normalized', 'weights', 'colSums', 'consistency', 'needs_migration', 'needs_criteria'));
    }

    public function store(Request $request)
    {
        $criteria = TpkCriterion::orderBy('order')->orderBy('id')->get();
        $ids = $criteria->pluck('id')->all();

        $rules = [];
        foreach ($ids as $idA) {
            foreach ($ids as $idB) {
                if ($idA === $idB) {
                    continue;
                }
                $rules["pairwise.$idA.$idB"] = ['required', 'numeric', 'min:0.1111', 'max:9'];
            }
        }
        $data = $request->validate($rules);

        foreach ($ids as $idA) {
            foreach ($ids as $idB) {
                if ($idA === $idB) {
                    continue;
                }
                $val = (float) data_get($data, "pairwise.$idA.$idB");
                if ($val <= 0) {
                    continue;
                }
                TpkPairwise::updateOrCreate(
                    ['criterion_id_a' => $idA, 'criterion_id_b' => $idB],
                    ['value' => $val]
                );
            }
        }

        return redirect()->route('admin.tpk.pairwise.index')->with('success', 'Perbandingan berpasangan disimpan.');
    }

    public function storeCriteria(Request $request)
    {
        if (!Schema::hasTable('tpk_criteria')) {
            return redirect()->route('admin.tpk.pairwise.index')->withErrors(['criteria' => 'Tabel kriteria belum tersedia.']);
        }

        $data = $request->validate([
            'criteria' => ['required', 'array', 'min:1'],
            'criteria.*.code' => ['required', 'string', 'max:20'],
            'criteria.*.name' => ['required', 'string', 'max:150'],
            'criteria.*.type' => ['required', Rule::in(['benefit','cost'])],
            'criteria.*.order' => ['nullable', 'integer', 'min:0'],
        ]);

        foreach ($data['criteria'] as $row) {
            $code = strtoupper(trim($row['code']));
            $name = trim($row['name']);
            if ($code === '' || $name === '') {
                continue;
            }
            TpkCriterion::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'type' => $row['type'],
                    'order' => (int) ($row['order'] ?? 0),
                    'weight' => 0,
                ]
            );
        }

        return redirect()->route('admin.tpk.pairwise.index')->with('success', 'Kriteria berhasil disimpan.');
    }

    private function buildAHP($criteria): array
    {
        $ids = $criteria->pluck('id')->all();
        $pairs = TpkPairwise::whereIn('criterion_id_a', $ids)
            ->whereIn('criterion_id_b', $ids)
            ->get();

        $pairMap = [];
        foreach ($pairs as $p) {
            $a = (int) $p->criterion_id_a;
            $b = (int) $p->criterion_id_b;
            if ($a === $b) {
                continue;
            }
            $pairMap[$a][$b] = (float) $p->value;
        }

        $matrix = [];
        $missing = false;
        foreach ($criteria as $ci) {
            foreach ($criteria as $cj) {
                if ($ci->id === $cj->id) {
                    $matrix[$ci->id][$cj->id] = 1.0;
                    continue;
                }
                $val = $pairMap[$ci->id][$cj->id] ?? null;
                if ($val === null) {
                    $reverse = $pairMap[$cj->id][$ci->id] ?? null;
                    if ($reverse !== null && $reverse > 0) {
                        $val = 1 / $reverse;
                    }
                }
                if ($val === null || $val <= 0) {
                    $missing = true;
                    $matrix[$ci->id][$cj->id] = null;
                    continue;
                }
                $matrix[$ci->id][$cj->id] = $val;
            }
        }

        $normalized = [];
        $weights = [];
        $colSums = [];
        $consistency = [];
        if ($missing || count($criteria) === 0) {
            return [$matrix, $normalized, $weights, $colSums, $consistency];
        }

        $colSums = [];
        foreach ($criteria as $cj) {
            $sum = 0.0;
            foreach ($criteria as $ci) {
                $sum += (float) ($matrix[$ci->id][$cj->id] ?? 0);
            }
            $colSums[$cj->id] = max(1e-9, $sum);
        }

        foreach ($criteria as $ci) {
            $rowSum = 0.0;
            foreach ($criteria as $cj) {
                $val = (float) ($matrix[$ci->id][$cj->id] ?? 0);
                $norm = $val / $colSums[$cj->id];
                $normalized[$ci->id][$cj->id] = $norm;
                $rowSum += $norm;
            }
            $weights[$ci->id] = $rowSum / max(1, count($criteria));
        }

        $consistency = $this->computeConsistency($criteria, $matrix, $weights);

        return [$matrix, $normalized, $weights, $colSums, $consistency];
    }

    private function computeConsistency($criteria, array $matrix, array $weights): array
    {
        $n = count($criteria);
        if ($n < 2) {
            return [];
        }

        $weightVec = [];
        foreach ($criteria as $c) {
            $weightVec[$c->id] = (float) ($weights[$c->id] ?? 0);
        }

        $aw = [];
        $ratios = [];
        foreach ($criteria as $row) {
            $sum = 0.0;
            foreach ($criteria as $col) {
                $sum += (float) ($matrix[$row->id][$col->id] ?? 0) * ($weightVec[$col->id] ?? 0);
            }
            $aw[$row->id] = $sum;
            $w = $weightVec[$row->id] ?? 0.0;
            $ratios[$row->id] = $w > 0 ? ($sum / $w) : 0.0;
        }

        $lambdaMax = array_sum($ratios) / max(1, $n);
        $ci = ($lambdaMax - $n) / max(1, ($n - 1));

        $riTable = [
            1 => 0.00,
            2 => 0.00,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49,
        ];
        $ri = $riTable[$n] ?? 1.49;
        $cr = $ri > 0 ? ($ci / $ri) : 0.0;

        return [
            'aw' => $aw,
            'ratios' => $ratios,
            'lambda_max' => $lambdaMax,
            'ci' => $ci,
            'ri' => $ri,
            'cr' => $cr,
            'is_consistent' => $cr <= 0.10,
        ];
    }
}
