<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attendance;
use App\Models\Member;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function globalIndex()
    {
        $title = 'Pilih Kegiatan untuk Absensi';
        $activities = Activity::with('program')->get();
        return view('attendances.global_index', compact('activities', 'title'));
    }

    public function index(Activity $activity)
    {
        $title = 'Absensi Kegiatan';
        $members = Member::all();
        $attendances = $activity->attendances()->get()->keyBy('member_id');

        return view('attendances.index', compact('activity', 'members', 'attendances', 'title'));
    }

    public function store(Request $request, Activity $activity)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        foreach ($request->attendances as $memberId => $data) {
            Attendance::updateOrCreate(
                ['activity_id' => $activity->id, 'member_id' => $memberId],
                ['status' => $data['status'], 'time' => now()]
            );
        }

        return redirect()->route('activities.attendances.index', $activity)->with('success', 'Data absensi berhasil disimpan.');
    }
}
