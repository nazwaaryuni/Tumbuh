# Task 2: Data Anggota dan Struktur Organisasi

## Deskripsi Task
Mengembangkan modul untuk mengelola data detail keanggotaan dan pemetaan struktur organisasi. Modul ini mencakup tiga entitas utama: `members`, `divisions`, dan `positions`.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `divisions` (id, name, description).
   - Buat tabel `positions` (id, name, level).
   - Buat tabel `members` (id, user_id, division_id, position_id, full_name, phone, join_date, status).
2. **Model**:
   - Buat model `Division`, `Position`, dan `Member`.
   - Definisikan relasi Eloquent: `User` hasOne `Member`, `Member` belongsTo `Division`, `Member` belongsTo `Position`.
3. **Seeder**:
   - Buat `DivisionSeeder`, `PositionSeeder`, dan `MemberSeeder` berisi data dummy untuk visualisasi.
4. **CRUD Logic**:
   - Buat modul untuk mengelola master data Divisi dan Jabatan.
   - Buat modul untuk melengkapi profil Anggota (Member) yang terikat dengan User.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tersedia halaman/API CRUD untuk Divisi, Jabatan, dan Anggota.
- [ ] Seeder berhasil memasukkan data divisi, jabatan, dan minimal 5 anggota dummy.
- [ ] Relasi antar tabel berfungsi dengan baik di level database maupun ORM.
