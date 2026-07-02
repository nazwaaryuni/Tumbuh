<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Nama Divisi</div>
            <div class="col-sm-9">: {{ $division->name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Deskripsi</div>
            <div class="col-sm-9">: {{ $division->description ?? '-' }}</div>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('division.edit', $division) }}" class="btn btn-warning">Edit Divisi</a>
            <a href="{{ route('division.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</x-app>
