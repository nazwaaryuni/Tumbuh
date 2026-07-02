<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class DivisionController extends Controller
{
    public function index()
    {
        Gate::authorize('view-divisions');
        return view('division.index', [
            'title' => 'Divisi',
            'divisions' => Division::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        Gate::authorize('create-divisions');
        return view('division.create', [
            'title' => 'Tambah Divisi',
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create-divisions');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:divisions,name'],
            'description' => 'nullable|string',
        ]);

        Division::create($validated);
        return redirect()->route('division.index')->with('success', 'Divisi berhasil ditambahkan');
    }

    public function show(Division $division)
    {
        Gate::authorize('view-divisions');
        return view('division.show', [
            'title' => 'Detail Divisi',
            'division' => $division,
        ]);
    }

    public function edit(Division $division)
    {
        Gate::authorize('update-divisions');
        return view('division.edit', [
            'title' => 'Edit Divisi',
            'division' => $division,
        ]);
    }

    public function update(Request $request, Division $division)
    {
        Gate::authorize('update-divisions');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('divisions')->ignore($division->id)],
            'description' => 'nullable|string',
        ]);

        $division->update($validated);
        return redirect()->route('division.index')->with('success', 'Divisi berhasil diperbarui');
    }

    public function destroy(Division $division)
    {
        Gate::authorize('delete-divisions');
        
        if ($division->members()->count() > 0) {
            return redirect()->route('division.index')->with('error', 'Divisi tidak dapat dihapus karena masih digunakan oleh anggota.');
        }

        $division->delete();
        return redirect()->route('division.index')->with('success', 'Divisi berhasil dihapus');
    }
}
