<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Division;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view-members');

        $query = Member::with(['user', 'division', 'position']);

        $query->when($request->search, function ($q, $search) {
            $q->where('full_name', 'like', "%{$search}%");
        });

        $query->when($request->division_id, function ($q, $division_id) {
            $q->where('division_id', $division_id);
        });

        $query->when($request->position_id, function ($q, $position_id) {
            $q->where('position_id', $position_id);
        });

        $query->when($request->status, function ($q, $status) {
            $q->where('status', $status);
        });

        return view('member.index', [
            'title' => 'Data Anggota',
            'members' => $query->latest()->paginate(10)->withQueryString(),
            'divisions' => Division::all(),
            'positions' => Position::all(),
        ]);
    }

    public function show(Member $member)
    {
        Gate::authorize('view-members');
        return view('member.show', [
            'title' => 'Detail Anggota',
            'member' => $member,
        ]);
    }

    public function edit(Member $member)
    {
        Gate::authorize('update-members');
        return view('member.edit', [
            'title' => 'Edit Data Anggota',
            'member' => $member,
            'divisions' => Division::all(),
            'positions' => Position::all(),
        ]);
    }

    public function update(Request $request, Member $member)
    {
        Gate::authorize('update-members');
        $validated = $request->validate([
            'division_id' => 'nullable|exists:divisions,id',
            'position_id' => 'nullable|exists:positions,id',
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'join_date' => 'nullable|date',
            'status' => 'required|in:Aktif,Pasif',
        ]);

        $member->update($validated);
        return redirect()->route('member.index')->with('success', 'Data Anggota berhasil diperbarui');
    }
}
