<x-app>
    <x-slot:title>Arsip Dokumen</x-slot:title>

    <div class="card shadow-lg p-3">
        @can('manage-documents')
        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('documents.create') }}" role="button">Tambah Dokumen</a>
        </div>
        @endcan

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Judul Dokumen</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">File</th>
                        <th scope="col">Waktu Unggah</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $document->title }}</td>
                            <td>{{ $document->type }}</td>
                            <td>
                                <a href="{{ Storage::url($document->file_url) }}" target="_blank" class="btn btn-sm btn-info">Unduh/Lihat</a>
                            </td>
                            <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @can('manage-documents')
                                <a href="{{ route('documents.edit', $document) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-muted">Hanya lihat</span>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app>
