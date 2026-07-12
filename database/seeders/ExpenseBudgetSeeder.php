<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ExpenseBudget;
use Illuminate\Database\Seeder;

class ExpenseBudgetSeeder extends Seeder
{
    public function run(): void
    {
        $activities = Activity::all();

        if ($activities->isEmpty()) return;

        foreach ($activities as $activity) {
            $hasActual = rand(0, 1); // Randomize if they have realized the budget

            ExpenseBudget::create([
                'activity_id' => $activity->id,
                'item_name' => 'Konsumsi Peserta & Panitia',
                'planned_amount' => 500000,
                'actual_amount' => $hasActual ? 520000 : null,
                'receipt_url' => null,
            ]);

            ExpenseBudget::create([
                'activity_id' => $activity->id,
                'item_name' => 'Sewa Peralatan & Sound System',
                'planned_amount' => 300000,
                'actual_amount' => $hasActual ? 280000 : null,
                'receipt_url' => null,
            ]);
            
            ExpenseBudget::create([
                'activity_id' => $activity->id,
                'item_name' => 'Cetak Spanduk & Sertifikat',
                'planned_amount' => 150000,
                'actual_amount' => $hasActual ? 150000 : null,
                'receipt_url' => null,
            ]);
        }
    }
}
