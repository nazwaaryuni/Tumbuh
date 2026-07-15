<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        @can('create-positions')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('position.create') }}" role="button">Tambah Jabatan</a>
        </div>
        @endcan

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Jabatan</th>
                        <th scope="col">Level</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($positions as $position)
                        <tr>
                            <td>{{ $loop->iteration + $positions->firstItem() - 1 }}</td>
                            <td>{{ $position->name }}</td>
                            <td>{{ $position->level }}</td>
                            <td>
                                <a href="{{ route('position.show', $position) }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-show'></i>
                                </a>
                                @can('update-positions')
                                <a href="{{ route('position.edit', $position) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                @endcan
                                @can('delete-positions')
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('position.destroy', $position) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $positions->links() }}
        </div>
    </div>
</x-app>
