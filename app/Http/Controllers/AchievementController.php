<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AchievementController extends Controller
{
    public function store(Request $request, Member $member)
    {
        Gate::authorize('manage-achievements');

        $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'date_achieved' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $member->achievements()->create($request->all());

        return back()->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function destroy(Achievement $achievement)
    {
        Gate::authorize('manage-achievements');
        
        $achievement->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}
