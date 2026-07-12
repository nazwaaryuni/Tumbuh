<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <form action="{{ route('activities.update', $activity) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $activity->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="program_id" class="form-label">Program Induk <span class="text-danger">*</span></label>
                <select class="form-select @error('program_id') is-invalid @enderror" id="program_id" name="program_id" required>
                    <option value="">Pilih Program Kerja</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program_id', $activity->program_id) == $program->id ? 'selected' : '' }}>
                            {{ $program->name }} ({{ $program->division->name ?? 'Semua Divisi' }})
                        </option>
                    @endforeach
                </select>
                @error('program_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $activity->start_date) }}" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">Tanggal Selesai (Opsional)</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $activity->end_date) }}">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Lokasi</label>
                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $activity->location) }}">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="planned" {{ old('status', $activity->status) == 'planned' ? 'selected' : '' }}>Direncanakan</option>
                    <option value="ongoing" {{ old('status', $activity->status) == 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="completed" {{ old('status', $activity->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="canceled" {{ old('status', $activity->status) == 'canceled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('activities.index') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Perbarui Kegiatan</button>
            </div>
        </form>
    </div>
</x-app>
