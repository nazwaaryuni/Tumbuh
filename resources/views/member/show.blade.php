<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-4">
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Nama Lengkap</div>
            <div class="col-sm-9">: {{ $member->full_name }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Email Akun</div>
            <div class="col-sm-9">: {{ $member->user->email ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Nomor Telepon</div>
            <div class="col-sm-9">: {{ $member->phone ?? '-' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Divisi</div>
            <div class="col-sm-9">: {{ $member->division?->name ?? 'Tanpa Divisi' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Jabatan</div>
            <div class="col-sm-9">: {{ $member->position?->name ?? 'Belum Ditentukan' }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Status</div>
            <div class="col-sm-9">: <span class="badge bg-{{ $member->status == 'Aktif' ? 'success' : ($member->status == 'Pasif' ? 'warning' : 'secondary') }}">{{ $member->status }}</span></div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-3 fw-bold">Bergabung Pada</div>
            <div class="col-sm-9">: {{ $member->join_date ? \Carbon\Carbon::parse($member->join_date)->isoFormat('D MMMM YYYY') : '-' }}</div>
        </div>

        <div class="mt-4">
            <a href="{{ route('member.edit', $member) }}" class="btn btn-warning">Edit Profil</a>
            <a href="{{ route('member.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</x-app>
