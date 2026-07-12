<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $activities = Activity::where('status', 'completed')->get();
        $members = Member::all();

        if ($activities->isEmpty() || $members->isEmpty()) return;

        $statuses = ['Hadir', 'Hadir', 'Hadir', 'Izin', 'Sakit', 'Alpha'];

        foreach ($activities as $activity) {
            foreach ($members as $member) {
                // Randomly assign attendance for members in completed activities
                Attendance::create([
                    'activity_id' => $activity->id,
                    'member_id' => $member->id,
                    'time' => $activity->end_date . ' ' . str_pad(rand(8, 16), 2, '0', STR_PAD_LEFT) . ':00:00',
                    'status' => $statuses[array_rand($statuses)],
                ]);
            }
        }
    }
}
