<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::all();
        if ($programs->isEmpty()) return;

        foreach ($programs as $program) {
            Activity::create([
                'program_id' => $program->id,
                'name' => 'Persiapan ' . $program->name,
                'start_date' => now()->addDays(rand(1, 10))->format('Y-m-d'),
                'end_date' => now()->addDays(rand(11, 15))->format('Y-m-d'),
                'location' => 'Sekretariat',
                'status' => 'planned',
            ]);

            Activity::create([
                'program_id' => $program->id,
                'name' => 'Pelaksanaan ' . $program->name,
                'start_date' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                'end_date' => now()->subDays(rand(1, 10))->format('Y-m-d'),
                'location' => 'Gedung Serbaguna',
                'status' => 'completed',
            ]);
        }
    }
}
