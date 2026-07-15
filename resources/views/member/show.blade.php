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

    <!-- Bagian Prestasi & Penghargaan -->
    <div class="card shadow-lg p-4 mt-4">
        <h5 class="fw-bold mb-3">Prestasi & Penghargaan</h5>

        @if($member->achievements->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Prestasi</th>
                        <th>Tingkat</th>
                        <th>Tanggal Diraih</th>
                        <th>Deskripsi</th>
                        @can('manage-achievements')
                        <th>Aksi</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach($member->achievements as $achievement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $achievement->title }}</td>
                        <td>{{ $achievement->level }}</td>
                        <td>{{ \Carbon\Carbon::parse($achievement->date_achieved)->isoFormat('D MMMM YYYY') }}</td>
                        <td>{{ $achievement->description ?? '-' }}</td>
                        @can('manage-achievements')
                        <td>
                            <form action="{{ route('achievements.destroy', $achievement) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus prestasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class='bx bx-trash'></i></button>
                            </form>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted">Belum ada riwayat prestasi.</p>
        @endif

        @can('manage-achievements')
        <div class="mt-3">
            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#formTambahPrestasi" aria-expanded="false" aria-controls="formTambahPrestasi">
                + Tambah Prestasi
            </button>
            <div class="collapse mt-3" id="formTambahPrestasi">
                <div class="card card-body">
                    <form action="{{ route('achievements.store', $member) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label required">Judul Prestasi</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Tingkat</label>
                                <select name="level" class="form-select" required>
                                    <option value="" disabled selected>Pilih Tingkat</option>
                                    <option value="Lokal">Lokal</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Internasional">Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label required">Tanggal Diraih</label>
                                <input type="date" name="date_achieved" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi (Opsional)</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Prestasi</button>
                    </form>
                </div>
            </div>
        </div>
        @endcan
    </div>
</x-app>
