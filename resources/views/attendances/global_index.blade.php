<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Kegiatan</th>
                        <th scope="col">Program Induk</th>
                        <th scope="col">Tanggal</th>
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
                            <td>{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</td>
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
                                <a href="{{ route('activities.attendances.index', $activity) }}" class="btn btn-primary btn-sm">
                                    <i class='bx bx-check-square'></i> Kelola Absensi
                                </a>
                                @else
                                <a href="{{ route('activities.attendances.index', $activity) }}" class="btn btn-info btn-sm text-white">
                                    <i class='bx bx-show'></i> Lihat Absensi
                                </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data kegiatan belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
