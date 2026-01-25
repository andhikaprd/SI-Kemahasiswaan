<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tpk_alternatives')) {
            return;
        }

        $rows = DB::table('tpk_alternatives')->orderBy('id')->get(['id']);
        $i = 1;
        foreach ($rows as $row) {
            DB::table('tpk_alternatives')
                ->where('id', $row->id)
                ->update(['code' => 'A' . $i]);
            $i++;
        }
    }

    public function down(): void
    {
        // no-op
    }
};
