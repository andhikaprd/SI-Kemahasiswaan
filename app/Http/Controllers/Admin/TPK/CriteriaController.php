<?php

namespace App\Http\Controllers\Admin\TPK;

use App\Http\Controllers\Controller;
use App\Models\TpkCriterion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CriteriaController extends Controller
{
    public function index()
    {
        $needs_migration = false;
        $items = collect();
        if (Schema::hasTable('tpk_criteria')) {
            $items = TpkCriterion::orderBy('order')->orderBy('id')->get();
        } else {
            $needs_migration = true;
        }
        return view('Admin.tpk.criteria.index', compact('items','needs_migration'));
    }

    public function create()
    {
        return view('Admin.tpk.criteria.create');
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'code' => 'required|string|max:20|unique:tpk_criteria,code',
            'name' => 'required|string|max:150',
            'weight' => 'required|numeric',
            'type' => 'required|in:benefit,cost',
            'order' => 'nullable|integer|min:0',
        ]);
        TpkCriterion::create($data);
        return redirect()->route('admin.tpk.criteria.index')->with('success', 'Kriteria ditambahkan.');
    }

    public function edit(TpkCriterion $criterion)
    {
        return view('Admin.tpk.criteria.edit', compact('criterion'));
    }

    public function update(Request $r, TpkCriterion $criterion)
    {
        $data = $r->validate([
            'code' => 'required|string|max:20|unique:tpk_criteria,code,'.$criterion->id,
            'name' => 'required|string|max:150',
            'weight' => 'required|numeric',
            'type' => 'required|in:benefit,cost',
            'order' => 'nullable|integer|min:0',
        ]);
        $criterion->update($data);
        return redirect()->route('admin.tpk.criteria.index')->with('success', 'Kriteria diperbarui.');
    }

    public function destroy(TpkCriterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('admin.tpk.criteria.index')->with('success', 'Kriteria dihapus.');
    }
}
