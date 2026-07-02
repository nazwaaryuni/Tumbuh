# Task 3: Program Kerja per Divisi

## Deskripsi Task
Mengembangkan modul bagi setiap divisi untuk dapat merencanakan dan mendata program kerja (proker) mereka.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `programs` (id, division_id, name, description, year).
2. **Model**:
   - Buat model `Program`.
   - Definisikan relasi Eloquent: `Program` belongsTo `Division` dan `Division` hasMany `Program`.
3. **Seeder**:
   - Buat `ProgramSeeder` yang berisi data dummy program kerja untuk setiap divisi yang ada.
4. **CRUD Logic**:
   - Buat modul pengelolaan Program Kerja. Data program kerja harus terikat pada satu divisi.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Sistem dapat melakukan CRUD untuk entitas program kerja.
- [ ] Data dummy program kerja dapat divisualisasikan untuk masing-masing divisi.
- [ ] Filter program kerja berdasarkan tahun dan divisi berjalan dengan baik.
