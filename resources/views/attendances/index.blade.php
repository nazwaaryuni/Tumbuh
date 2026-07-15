<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3 mb-4">
        <div class="card-body pb-0">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Detail Kegiatan</h5>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <strong>Nama Kegiatan:</strong> {{ $activity->name }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Program Induk:</strong> {{ $activity->program->name ?? '-' }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
                </div>
                <div class="col-md-6 mb-2">
                    <strong>Lokasi:</strong> {{ $activity->location ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-lg p-3">
        <form action="{{ route('activities.attendances.store', $activity) }}" method="POST">
            @csrf
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped w-100 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" width="5%">No</th>
                            <th scope="col" width="30%">Nama Anggota</th>
                            <th scope="col" width="25%">Divisi</th>
                            <th scope="col" width="40%">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($members as $member)
                            @php
                                $attendance = $attendances->get($member->id);
                                $status = $attendance ? $attendance->status : 'Alpha';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->full_name }}</td>
                                <td>{{ $member->division->name ?? '-' }}</td>
                                <td>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="attendances[{{ $member->id }}][status]" id="hadir_{{ $member->id }}" value="Hadir" {{ $status == 'Hadir' ? 'checked' : '' }} @cannot('fill-attendance') disabled @endcannot>
                                            <label class="form-check-label text-success" for="hadir_{{ $member->id }}">Hadir</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="attendances[{{ $member->id }}][status]" id="izin_{{ $member->id }}" value="Izin" {{ $status == 'Izin' ? 'checked' : '' }} @cannot('fill-attendance') disabled @endcannot>
                                            <label class="form-check-label text-warning" for="izin_{{ $member->id }}">Izin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="attendances[{{ $member->id }}][status]" id="sakit_{{ $member->id }}" value="Sakit" {{ $status == 'Sakit' ? 'checked' : '' }} @cannot('fill-attendance') disabled @endcannot>
                                            <label class="form-check-label text-info" for="sakit_{{ $member->id }}">Sakit</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="attendances[{{ $member->id }}][status]" id="alpha_{{ $member->id }}" value="Alpha" {{ $status == 'Alpha' ? 'checked' : '' }} @cannot('fill-attendance') disabled @endcannot>
                                            <label class="form-check-label text-danger" for="alpha_{{ $member->id }}">Alpha</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Data anggota belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 text-end">
                <a href="{{ route('attendances.index') }}" class="btn btn-secondary me-2">Kembali</a>
                @can('fill-attendance')
                <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan Absensi</button>
                @endcan
            </div>
        </form>
    </div>
</x-app>
