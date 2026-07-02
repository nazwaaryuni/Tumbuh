<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{
    public function index()
    {
        Gate::authorize('view-positions');
        return view('position.index', [
            'title' => 'Jabatan',
            'positions' => Position::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        Gate::authorize('create-positions');
        return view('position.create', [
            'title' => 'Tambah Jabatan',
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create-positions');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:positions,name'],
            'level' => 'required|string|max:255',
        ]);

        Position::create($validated);
        return redirect()->route('position.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function show(Position $position)
    {
        Gate::authorize('view-positions');
        return view('position.show', [
            'title' => 'Detail Jabatan',
            'position' => $position,
        ]);
    }

    public function edit(Position $position)
    {
        Gate::authorize('update-positions');
        return view('position.edit', [
            'title' => 'Edit Jabatan',
            'position' => $position,
        ]);
    }

    public function update(Request $request, Position $position)
    {
        Gate::authorize('update-positions');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('positions')->ignore($position->id)],
            'level' => 'required|string|max:255',
        ]);

        $position->update($validated);
        return redirect()->route('position.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(Position $position)
    {
        Gate::authorize('delete-positions');
        
        if ($position->members()->count() > 0) {
            return redirect()->route('position.index')->with('error', 'Jabatan tidak dapat dihapus karena masih digunakan oleh anggota.');
        }

        $position->delete();
        return redirect()->route('position.index')->with('success', 'Jabatan berhasil dihapus');
    }
}
