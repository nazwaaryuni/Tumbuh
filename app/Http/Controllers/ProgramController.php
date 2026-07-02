<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('view-programs');

        $query = Program::with('division');
        $user = auth()->user();
        $position = $user->member?->position?->name;

        // Jika Koordinator Divisi, paksa filter hanya divisinya saja
        if ($position === 'Koordinator Divisi') {
            $query->where('division_id', $user->member->division_id);
        } else {
            $query->when($request->division_id, function ($q, $division_id) {
                $q->where('division_id', $division_id);
            });
        }

        $query->when($request->search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%");
        });

        $query->when($request->year, function ($q, $year) {
            $q->where('year', $year);
        });

        $programs = $query->orderBy('year', 'desc')->orderBy('name', 'asc')->paginate(10)->withQueryString();
        
        // Divisions untuk dropdown filter (kecuali untuk koordinator divisi, dropdown bisa disembunyikan di blade)
        $divisions = Division::all();

        return view('program.index', [
            'title' => 'Program Kerja',
            'programs' => $programs,
            'divisions' => $divisions,
            'isKoordinator' => $position === 'Koordinator Divisi',
        ]);
    }

    public function create()
    {
        Gate::authorize('create-programs');
        $user = auth()->user();
        $position = $user->member?->position?->name;
        
        return view('program.create', [
            'title' => 'Tambah Program Kerja',
            'divisions' => Division::all(),
            'isKoordinator' => $position === 'Koordinator Divisi',
            'userDivisionId' => $user->member?->division_id,
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create-programs');
        
        $user = auth()->user();
        $position = $user->member?->position?->name;
        
        // Paksa division_id jika Koordinator Divisi
        if ($position === 'Koordinator Divisi') {
            $request->merge(['division_id' => $user->member->division_id]);
        }

        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('programs')->where(fn ($query) => $query->where('division_id', $request->division_id)->where('year', $request->year))
            ],
            'description' => 'nullable|string',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        Program::create($validated);
        return redirect()->route('program.index')->with('success', 'Program Kerja berhasil ditambahkan');
    }

    public function show(Program $program)
    {
        Gate::authorize('view-programs');
        return view('program.show', [
            'title' => 'Detail Program Kerja',
            'program' => $program,
        ]);
    }

    public function edit(Program $program)
    {
        Gate::authorize('update-programs', $program);
        $user = auth()->user();
        $position = $user->member?->position?->name;
        
        return view('program.edit', [
            'title' => 'Edit Program Kerja',
            'program' => $program,
            'divisions' => Division::all(),
            'isKoordinator' => $position === 'Koordinator Divisi',
        ]);
    }

    public function update(Request $request, Program $program)
    {
        Gate::authorize('update-programs', $program);

        $user = auth()->user();
        $position = $user->member?->position?->name;
        
        // Paksa division_id jika Koordinator Divisi
        if ($position === 'Koordinator Divisi') {
            $request->merge(['division_id' => $user->member->division_id]);
        }

        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('programs')->where(fn ($query) => $query->where('division_id', $request->division_id)->where('year', $request->year))->ignore($program->id)
            ],
            'description' => 'nullable|string',
            'year' => 'required|integer|min:2000|max:2100',
        ]);

        $program->update($validated);
        return redirect()->route('program.index')->with('success', 'Program Kerja berhasil diperbarui');
    }

    public function destroy(Program $program)
    {
        Gate::authorize('delete-programs', $program);

        if ($program->activities()->count() > 0) {
            return redirect()->route('program.index')->with('error', 'Program tidak dapat dihapus karena masih memiliki Activities yang terkait.');
        }

        $program->delete();
        return redirect()->route('program.index')->with('success', 'Program Kerja berhasil dihapus');
    }
}
