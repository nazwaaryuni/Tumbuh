<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Nama Jabatan</div>
            <div class="col-sm-9">: {{ $position->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Level Jabatan</div>
            <div class="col-sm-9">: {{ $position->level ?? '-' }}</div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('position.edit', $position) }}" class="btn btn-warning">Edit Jabatan</a>
            <a href="{{ route('position.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</x-app>
