<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('mahasiswas', 'ipk')) {
                $table->decimal('ipk', 3, 2)->nullable()->after('email');
            }
            if (!Schema::hasColumn('mahasiswas', 'english_type')) {
                $table->string('english_type', 20)->nullable()->after('ipk'); // IELTS, TOEFL_IBT, TOEFL_ITP, CEFR
            }
            if (!Schema::hasColumn('mahasiswas', 'english_score')) {
                $table->decimal('english_score', 6, 2)->nullable()->after('english_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('mahasiswas', 'english_score')) {
                $table->dropColumn('english_score');
            }
            if (Schema::hasColumn('mahasiswas', 'english_type')) {
                $table->dropColumn('english_type');
            }
            if (Schema::hasColumn('mahasiswas', 'ipk')) {
                $table->dropColumn('ipk');
            }
        });
    }
};

