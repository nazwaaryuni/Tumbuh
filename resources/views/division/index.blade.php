<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        @can('create-divisions')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('division.create') }}" role="button">Tambah Divisi</a>
        </div>
        @endcan

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Divisi</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($divisions as $division)
                        <tr>
                            <td>{{ $loop->iteration + $divisions->firstItem() - 1 }}</td>
                            <td>{{ $division->name }}</td>
                            <td>{{ $division->description }}</td>
                            <td>
                                <a href="{{ route('division.show', $division) }}" class="btn btn-info btn-sm">
                                    <i class='bx bx-show'></i>
                                </a>
                                @can('update-divisions')
                                <a href="{{ route('division.edit', $division) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                @endcan
                                @can('delete-divisions')
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('division.destroy', $division) }}">
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
            {{ $divisions->links() }}
        </div>
    </div>
</x-app>
