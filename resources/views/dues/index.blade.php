<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3 mb-4">
        <form action="{{ route('dues.index') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-4">
                    <label class="form-label mb-0 fw-bold">Pilih Bulan & Tahun</label>
                </div>
                <div class="col-md-5">
                    <input type="month" name="month_year" class="form-control" value="{{ request('month_year', $month_year) }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100"><i class="bx bx-filter"></i> Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100 align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col" width="5%">No</th>
                        <th scope="col" width="30%">Nama Anggota</th>
                        <th scope="col" width="20%">Divisi</th>
                        <th scope="col" width="15%">Nominal Iuran</th>
                        <th scope="col" width="15%">Status</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        @php
                            $due = $member->dues->first();
                            $status = $due ? $due->status : 'Belum Lunas';
                            $amount = $due ? $due->amount : 20000;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $member->full_name }}</td>
                            <td>{{ $member->division->name ?? '-' }}</td>
                            <td>Rp {{ number_format($amount, 0, ',', '.') }}</td>
                            <td>
                                @if($status == 'Lunas')
                                    <span class="badge bg-success"><i class="bx bx-check"></i> Lunas</span>
                                    <br><small class="text-muted">{{ $due->paid_at->format('d M Y') }}</small>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                            <td>
                                @can('manage-dues')
                                    <button type="button" class="btn btn-sm btn-{{ $status == 'Lunas' ? 'warning' : 'primary' }}" data-bs-toggle="modal" data-bs-target="#dueModal{{ $member->id }}">
                                        {{ $status == 'Lunas' ? 'Edit' : 'Bayar' }}
                                    </button>

                                    <!-- Modal Form -->
                                    <div class="modal fade" id="dueModal{{ $member->id }}" tabindex="-1" aria-labelledby="dueModalLabel{{ $member->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('dues.store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="dueModalLabel{{ $member->id }}">Catat Iuran - {{ $member->full_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                                                        <input type="hidden" name="month_year" value="{{ $month_year }}">
                                                        
                                                        <div class="mb-3">
                                                            <label class="form-label">Bulan Iuran</label>
                                                            <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($month_year . '-01')->translatedFormat('F Y') }}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Nominal (Rp)</label>
                                                            <input type="number" class="form-control" name="amount" value="{{ $amount }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Status</label>
                                                            <select name="status" class="form-select" required>
                                                                <option value="Lunas" {{ $status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                                                                <option value="Belum Lunas" {{ $status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data anggota belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app>
