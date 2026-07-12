<x-app>
    <x-slot:title>Edit Dokumen</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="title" class="form-label">Judul Dokumen</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $document->title) }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Jenis Dokumen</label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="Surat Masuk" {{ old('type', $document->type) == 'Surat Masuk' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="Surat Keluar" {{ old('type', $document->type) == 'Surat Keluar' ? 'selected' : '' }}>Surat Keluar</option>
                    <option value="Proposal" {{ old('type', $document->type) == 'Proposal' ? 'selected' : '' }}>Proposal</option>
                    <option value="LPJ" {{ old('type', $document->type) == 'LPJ' ? 'selected' : '' }}>LPJ</option>
                    <option value="Lainnya" {{ old('type', $document->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File Dokumen (Opsional)</label>
                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file">
                <div class="form-text">Biarkan kosong jika tidak ingin mengubah file. Format yang didukung: pdf, doc, docx, xls, xlsx, jpg, png. Max: 10MB</div>
                @if($document->file_url)
                    <div class="mt-2">File saat ini: <a href="{{ Storage::url($document->file_url) }}" target="_blank">Lihat File</a></div>
                @endif
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app>
