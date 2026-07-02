<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $humas = \App\Models\Division::where('name', 'Humas')->first();
        $psdm = \App\Models\Division::where('name', 'PSDM')->first();

        if ($humas) {
            \App\Models\Program::firstOrCreate(
                ['division_id' => $humas->id, 'name' => 'Studi Banding', 'year' => date('Y')],
                ['description' => 'Kunjungan kerja ke organisasi sejenis untuk bertukar pikiran.']
            );
            \App\Models\Program::firstOrCreate(
                ['division_id' => $humas->id, 'name' => 'Seminar Public Relations', 'year' => date('Y')],
                ['description' => 'Seminar terbuka mengenai ilmu komunikasi dan PR.']
            );
        }

        if ($psdm) {
            \App\Models\Program::firstOrCreate(
                ['division_id' => $psdm->id, 'name' => 'Diklat Anggota Baru', 'year' => date('Y')],
                ['description' => 'Pendidikan dan Pelatihan Dasar untuk anggota baru.']
            );
            \App\Models\Program::firstOrCreate(
                ['division_id' => $psdm->id, 'name' => 'Upgrading Pengurus', 'year' => date('Y')],
                ['description' => 'Kegiatan peningkatan kapasitas untuk jajaran pengurus.']
            );
        }
    }
}
