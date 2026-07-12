<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Program;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $title = 'Daftar Kegiatan';
        $activities = Activity::with('program')->get();
        return view('activities.index', compact('activities', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Kegiatan';
        $programs = Program::all();
        return view('activities.create', compact('programs', 'title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:planned,ongoing,completed,canceled',
        ]);

        Activity::create($request->all());

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    public function edit(Activity $activity)
    {
        $title = 'Edit Kegiatan';
        $programs = Program::all();
        return view('activities.edit', compact('activity', 'programs', 'title'));
    }

    public function update(Request $request, Activity $activity)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:planned,ongoing,completed,canceled',
        ]);

        $activity->update($request->all());

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
