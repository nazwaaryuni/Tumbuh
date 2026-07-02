<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('position.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Jabatan</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-3">
                <label for="level" class="form-label">Level</label>
                <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                    <option value="">Pilih Level</option>
                    <option value="Inti" @selected(old('level') == 'Inti')>Inti</option>
                    <option value="Kadiv" @selected(old('level') == 'Kadiv')>Kadiv</option>
                    <option value="Staf" @selected(old('level') == 'Staf')>Staf</option>
                    <option value="Member" @selected(old('level') == 'Member')>Member</option>
                </select>
                @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('position.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</x-app>
