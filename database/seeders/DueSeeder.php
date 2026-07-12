<?php

namespace Database\Seeders;

use App\Models\Due;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DueSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::all();
        if ($members->isEmpty()) return;

        $amount = 20000; // Contoh iuran per bulan 20.000

        // Buat data untuk 3 bulan terakhir
        $months = [
            now()->subMonths(2)->format('Y-m'),
            now()->subMonth()->format('Y-m'),
            now()->format('Y-m'),
        ];

        foreach ($members as $member) {
            foreach ($months as $month_year) {
                $isPaid = rand(0, 100) > 30; // 70% lunas

                Due::create([
                    'member_id' => $member->id,
                    'month_year' => $month_year,
                    'amount' => $amount,
                    'status' => $isPaid ? 'Lunas' : 'Belum Lunas',
                    'paid_at' => $isPaid ? Carbon::parse($month_year . '-05')->addDays(rand(0, 20)) : null,
                ]);
            }
        }
    }
}
