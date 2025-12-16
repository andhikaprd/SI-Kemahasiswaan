<?php

namespace Database\Seeders;

use App\Models\TpkAlternative;
use App\Models\TpkCriterion;
use App\Models\TpkScore;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class TpkSeeder extends Seeder
{
    /**
     * Seed data dasar TPK (kriteria, alternatif, dan skor contoh).
     */
    public function run(): void
    {
        if (
            !Schema::hasTable('tpk_criteria') ||
            !Schema::hasTable('tpk_alternatives') ||
            !Schema::hasTable('tpk_scores')
        ) {
            // Lewati bila modul TPK belum dimigrasikan.
            return;
        }

        $criteria = [
            ['code' => 'C1', 'name' => 'IPK', 'weight' => 0.35, 'type' => 'benefit', 'order' => 1],
            ['code' => 'C2', 'name' => 'Portofolio & Sertifikasi', 'weight' => 0.25, 'type' => 'benefit', 'order' => 2],
            ['code' => 'C3', 'name' => 'Pengalaman Organisasi', 'weight' => 0.20, 'type' => 'benefit', 'order' => 3],
            ['code' => 'C4', 'name' => 'Prestasi & Lomba', 'weight' => 0.10, 'type' => 'benefit', 'order' => 4],
            ['code' => 'C5', 'name' => 'Kedisiplinan & Kehadiran', 'weight' => 0.10, 'type' => 'benefit', 'order' => 5],
        ];

        $criteriaMap = [];
        foreach ($criteria as $c) {
            $saved = TpkCriterion::updateOrCreate(
                ['code' => $c['code']],
                [
                    'name' => $c['name'],
                    'weight' => $c['weight'],
                    'type' => $c['type'],
                    'order' => $c['order'],
                ]
            );
            $criteriaMap[$saved->code] = $saved->id;
        }

        $alternatives = [
            ['code' => 'ALT-01', 'name' => 'Mahasiswa A', 'note' => 'Aktif lomba bidang TI & kepanitiaan.'],
            ['code' => 'ALT-02', 'name' => 'Mahasiswa B', 'note' => 'Fokus akademik dengan portofolio publikasi.'],
            ['code' => 'ALT-03', 'name' => 'Mahasiswa C', 'note' => 'Kepemimpinan organisasi, disiplin tinggi.'],
        ];

        $altMap = [];
        foreach ($alternatives as $alt) {
            $saved = TpkAlternative::updateOrCreate(
                ['code' => $alt['code']],
                [
                    'name' => $alt['name'],
                    'note' => $alt['note'],
                ]
            );
            $altMap[$saved->code] = $saved->id;
        }

        // Skor contoh untuk memudahkan QA (skala bebas).
        $scores = [
            'ALT-01' => ['C1' => 3.6, 'C2' => 85, 'C3' => 80, 'C4' => 90, 'C5' => 75],
            'ALT-02' => ['C1' => 3.9, 'C2' => 92, 'C3' => 60, 'C4' => 70, 'C5' => 80],
            'ALT-03' => ['C1' => 3.4, 'C2' => 78, 'C3' => 95, 'C4' => 65, 'C5' => 90],
        ];

        foreach ($scores as $altCode => $critScores) {
            $altId = $altMap[$altCode] ?? null;
            if (!$altId) {
                continue;
            }
            foreach ($critScores as $critCode => $value) {
                $critId = $criteriaMap[$critCode] ?? null;
                if (!$critId) {
                    continue;
                }
                TpkScore::updateOrCreate(
                    ['alternative_id' => $altId, 'criterion_id' => $critId],
                    ['value' => $value]
                );
            }
        }
    }
}
