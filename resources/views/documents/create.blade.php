<x-app>
    <x-slot:title>Tambah Dokumen</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Judul Dokumen</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Jenis Dokumen</label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="" disabled selected>Pilih Jenis...</option>
                    <option value="Surat Masuk" {{ old('type') == 'Surat Masuk' ? 'selected' : '' }}>Surat Masuk</option>
                    <option value="Surat Keluar" {{ old('type') == 'Surat Keluar' ? 'selected' : '' }}>Surat Keluar</option>
                    <option value="Proposal" {{ old('type') == 'Proposal' ? 'selected' : '' }}>Proposal</option>
                    <option value="LPJ" {{ old('type') == 'LPJ' ? 'selected' : '' }}>LPJ</option>
                    <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">File Dokumen</label>
                <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file" required>
                <div class="form-text">Format yang didukung: pdf, doc, docx, xls, xlsx, jpg, png. Max: 10MB</div>
                @error('file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-app>
