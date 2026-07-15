# Task 8: Prestasi dan Penghargaan

## Deskripsi Task
Membangun fitur portofolio untuk mencatat prestasi dan pencapaian yang diperoleh oleh anggota organisasi.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `achievements` (id, member_id, title, level, date_achieved, description).
2. **Model**:
   - Buat model `Achievement`.
   - Definisikan relasi: `Achievement` belongsTo `Member` dan `Member` hasMany `Achievement`.
3. **Seeder**:
   - Buat `AchievementSeeder` berisi pencapaian dummy (Juara Lomba Nasional, dll) milik anggota tertentu.
4. **CRUD Logic**:
   - Modul penambahan prestasi bagi seorang anggota.
   - Menampilkan daftar prestasi pada halaman profil anggota.

## Kriteria Penerimaan (Acceptance Criteria)
- [x] Profil anggota memuat riwayat prestasi jika ada.
- [x] CRUD untuk tabel prestasi berfungsi penuh dengan seeder data yang tersedia.
