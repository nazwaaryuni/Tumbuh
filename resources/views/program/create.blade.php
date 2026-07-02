<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('program.store') }}" method="post" class="form">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Program <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="year" name="year" value="{{ old('year', date('Y')) }}" min="2000" max="2100" required>
            </div>

            <div class="mb-3">
                <label for="division_id" class="form-label">Divisi <span class="text-danger">*</span></label>
                @if($isKoordinator)
                    <!-- Koordinator hanya bisa melihat divisinya sendiri (terkunci via server) -->
                    @php $myDivision = $divisions->firstWhere('id', $userDivisionId); @endphp
                    <input type="text" class="form-control bg-light" value="{{ $myDivision->name ?? '' }}" readonly>
                    <!-- Walau readonly, kita biarkan kosong name-nya, karena akan ditimpa di controller dengan merge() -->
                    <input type="hidden" name="division_id" value="{{ $userDivisionId }}">
                @else
                    <select class="form-select select2-default" id="division_id" name="division_id" required>
                        <option value="">Pilih Divisi</option>
                        @foreach ($divisions as $division)
                            <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                {{ $division->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('program.index') }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-app>
