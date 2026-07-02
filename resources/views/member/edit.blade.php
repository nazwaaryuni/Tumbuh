<x-app>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('member.update', $member) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" value="{{ old('full_name', $member->full_name) }}" required>
                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="division_id" class="form-label">Divisi</label>
                    <select class="form-select @error('division_id') is-invalid @enderror" id="division_id" name="division_id">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div->id }}" @selected(old('division_id', $member->division_id) == $div->id)>{{ $div->name }}</option>
                        @endforeach
                    </select>
                    @error('division_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="position_id" class="form-label">Jabatan</label>
                    <select class="form-select @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" @selected(old('position_id', $member->position_id) == $pos->id)>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                    @error('position_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="join_date" class="form-label">Tanggal Bergabung</label>
                    <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ old('join_date', $member->join_date ? \Carbon\Carbon::parse($member->join_date)->format('Y-m-d') : '') }}">
                    @error('join_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status Keanggotaan</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="Aktif" @selected(old('status', $member->status) == 'Aktif')>Aktif</option>
                        <option value="Pasif" @selected(old('status', $member->status) == 'Pasif')>Pasif</option>
                        <option value="Alumni" @selected(old('status', $member->status) == 'Alumni')>Alumni</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Profil</button>
            <a href="{{ route('member.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</x-app>
