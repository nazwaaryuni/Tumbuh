<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = \App\Models\Member::all();

        if ($members->count() > 0) {
            \App\Models\Achievement::create([
                'member_id' => $members->first()->id,
                'title' => 'Juara 1 Lomba Web Design',
                'level' => 'Nasional',
                'date_achieved' => '2025-08-15',
                'description' => 'Diselenggarakan oleh Universitas Indonesia.'
            ]);

            \App\Models\Achievement::create([
                'member_id' => $members->first()->id,
                'title' => 'Peserta Terbaik Pelatihan Kepemimpinan',
                'level' => 'Lokal',
                'date_achieved' => '2024-10-10',
                'description' => 'Pelatihan kepemimpinan tingkat universitas.'
            ]);
        }
    }
}
