<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        @can('manage-programs-activities')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('activities.create') }}" role="button"><i class="bx bx-plus"></i> Tambah Kegiatan</a>
        </div>
        @endcan

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Program Kerja</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $activity->name }}</td>
                            <td>{{ $activity->program->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
                                @if($activity->end_date && $activity->start_date !== $activity->end_date)
                                    - {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
                                @endif
                            </td>
                            <td>{{ $activity->location }}</td>
                            <td>
                                @if($activity->status == 'planned')
                                    <span class="badge bg-secondary">Direncanakan</span>
                                @elseif($activity->status == 'ongoing')
                                    <span class="badge bg-primary">Berlangsung</span>
                                @elseif($activity->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                @can('fill-attendance')
                                <a href="{{ route('activities.attendances.index', $activity) }}" class="btn btn-info btn-sm" title="Kelola Absensi">
                                    <i class='bx bx-user-check'></i>
                                </a>
                                @endcan

                                <a href="{{ route('activities.budgets.index', $activity) }}" class="btn btn-success btn-sm" title="Kelola Anggaran">
                                    <i class='bx bx-money'></i>
                                </a>

                                @can('manage-programs-activities', $activity)
                                <a href="{{ route('activities.edit', $activity) }}" class="btn btn-warning btn-sm" title="Edit Kegiatan">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Kegiatan">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data kegiatan belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
