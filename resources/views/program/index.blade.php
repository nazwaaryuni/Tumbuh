<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3 mb-4">
        <form action="{{ route('program.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari Nama Program Kerja..." value="{{ request('search') }}">
                </div>
                @if(!$isKoordinator)
                <div class="col-md-3">
                    <select name="division_id" class="form-select">
                        <option value="">Semua Divisi</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div->id }}" @selected(request('division_id') == $div->id)>{{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-md-3">
                    <input type="number" name="year" class="form-control" placeholder="Tahun (contoh: {{ date('Y') }})" value="{{ request('year') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="bx bx-search"></i> Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="card shadow-lg p-3">
        @can('create-programs')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('program.create') }}" role="button">Tambah Program Kerja</a>
        </div>
        @endcan

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Program</th>
                        <th scope="col">Divisi</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programs as $program)
                        <tr>
                            <td>{{ $loop->iteration + $programs->firstItem() - 1 }}</td>
                            <td>{{ $program->name }}</td>
                            <td>{{ $program->division->name ?? '-' }}</td>
                            <td>{{ $program->year }}</td>
                            <td>{{ Str::limit($program->description, 50) }}</td>
                            <td>
                                <a href="{{ route('program.show', $program) }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-show'></i>
                                </a>
                                @can('update-programs', $program)
                                <a href="{{ route('program.edit', $program) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                @endcan
                                @can('delete-programs', $program)
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('program.destroy', $program) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $programs->links() }}
        </div>
    </div>
</x-app>
