<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3 mb-4">
        <form action="{{ route('member.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Anggota..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="division_id" class="form-select">
                        <option value="">Pilih Divisi</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div->id }}" @selected(request('division_id') == $div->id)>{{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="position_id" class="form-select">
                        <option value="">Pilih Jabatan</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" @selected(request('position_id') == $pos->id)>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Pilih Status</option>
                        <option value="Aktif" @selected(request('status') == 'Aktif')>Aktif</option>
                        <option value="Pasif" @selected(request('status') == 'Pasif')>Pasif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search"></i> CARI</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Nomor Telepon</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Divisi</th>
                        <th scope="col">Jabatan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Tanggal Bergabung</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr>
                            <td>{{ $loop->iteration + $members->firstItem() - 1 }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->user->email ?? '-' }}</td>
                            <td>{{ $member->user->role ?? '-' }}</td>
                            <td>{{ $member->division?->name ?? '-' }}</td>
                            <td>{{ $member->position?->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $member->status == 'Aktif' ? 'success' : ($member->status == 'Pasif' ? 'warning' : 'secondary') }}">{{ $member->status }}</span></td>
                            <td>{{ $member->join_date ? \Carbon\Carbon::parse($member->join_date)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <a href="{{ route('member.show', $member) }}" class="btn btn-info btn-sm" title="Lihat Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                                @can('update-members')
                                <a href="{{ route('member.edit', $member) }}" class="btn btn-warning btn-sm" title="Edit Profil">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $members->links() }}
        </div>
    </div>
</x-app>
