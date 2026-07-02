<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="w-25">Nama Program</th>
                    <td>{{ $program->name }}</td>
                </tr>
                <tr>
                    <th>Divisi</th>
                    <td>{{ $program->division->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tahun</th>
                    <td>{{ $program->year }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $program->description }}</td>
                </tr>
                <tr>
                    <th>Jumlah Activity</th>
                    <td>{{ $program->activities()->count() }}</td>
                </tr>
            </table>
        </div>

        <div class="mt-3">
            <a href="{{ route('program.index') }}" class="btn btn-secondary">Kembali</a>
            @can('update-programs', $program)
            <a href="{{ route('program.edit', $program) }}" class="btn btn-warning">Edit Program</a>
            @endcan
        </div>
    </div>
</x-app>
