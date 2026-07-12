<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="row">
        <!-- Rincian Kegiatan -->
        <div class="col-md-4">
            <div class="card shadow-lg mb-4">
                <div class="card-header bg-white">
                    <h6 class="fw-bold mb-0">Informasi Kegiatan</h6>
                </div>
                <div class="card-body pt-3">
                    <p class="mb-1 text-muted small">Nama Kegiatan</p>
                    <p class="fw-bold">{{ $activity->name }}</p>
                    
                    <p class="mb-1 text-muted small mt-3">Program Induk</p>
                    <p class="fw-bold">{{ $activity->program->name ?? '-' }}</p>

                    <p class="mb-1 text-muted small mt-3">Total RAB (Rencana)</p>
                    <h5 class="fw-bold text-primary">Rp {{ number_format($totalPlanned, 0, ',', '.') }}</h5>

                    <p class="mb-1 text-muted small mt-3">Total Realisasi (Aktual)</p>
                    <h5 class="fw-bold text-success">Rp {{ number_format($totalActual, 0, ',', '.') }}</h5>
                    
                    @php
                        $selisih = $totalPlanned - $totalActual;
                    @endphp
                    <p class="mb-1 text-muted small mt-3">Sisa / Selisih</p>
                    <h5 class="fw-bold {{ $selisih < 0 ? 'text-danger' : 'text-info' }}">Rp {{ number_format($selisih, 0, ',', '.') }}</h5>

                    <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary w-100 mt-4"><i class="bx bx-arrow-back"></i> Kembali</a>
                </div>
            </div>
        </div>

        <!-- Tabel RAB & Realisasi -->
        <div class="col-md-8">
            <div class="card shadow-lg p-3">
                @can('manage-budgets')
                <form action="{{ route('activities.budgets.store', $activity) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="item_name" class="form-control" placeholder="Nama Item / Kebutuhan" required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="planned_amount" class="form-control" placeholder="Rencana Anggaran (Rp)" required min="0">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="bx bx-plus"></i> Tambah</button>
                        </div>
                    </div>
                </form>
                @endcan

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="35%">Item Kebutuhan</th>
                                <th scope="col" width="20%">Rencana (Rp)</th>
                                <th scope="col" width="20%">Realisasi (Rp)</th>
                                <th scope="col" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($budgets as $budget)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $budget->item_name }}
                                        @if($budget->receipt_url)
                                            <br>
                                            <a href="{{ asset('storage/' . $budget->receipt_url) }}" target="_blank" class="badge bg-info mt-1 text-decoration-none"><i class="bx bx-receipt"></i> Lihat Bukti Nota</a>
                                        @endif
                                    </td>
                                    <td class="text-end">{{ number_format($budget->planned_amount, 0, ',', '.') }}</td>
                                    <td class="text-end">
                                        @if($budget->actual_amount !== null)
                                            <span class="text-success">{{ number_format($budget->actual_amount, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('manage-budgets')
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#budgetModal{{ $budget->id }}" title="Input Realisasi & Nota">
                                            <i class="bx bx-edit"></i>
                                        </button>

                                        <form action="{{ route('activities.budgets.destroy', [$activity, $budget]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus item ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Item">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Modal Form -->
                                        <div class="modal fade" id="budgetModal{{ $budget->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('activities.budgets.update', [$activity, $budget]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Input Realisasi - {{ $budget->item_name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            <div class="mb-3">
                                                                <label class="form-label">Rencana Anggaran</label>
                                                                <input type="text" class="form-control" value="Rp {{ number_format($budget->planned_amount, 0, ',', '.') }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Total Realisasi (Rp)</label>
                                                                <input type="number" name="actual_amount" class="form-control" value="{{ $budget->actual_amount }}" min="0" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Upload Bukti Nota (Opsional)</label>
                                                                <input type="file" name="receipt" class="form-control" accept="image/*">
                                                                <small class="text-muted">Format: JPG, PNG maksimal 2MB.</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Simpan Realisasi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada item anggaran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app>
