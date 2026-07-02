# Task 5: Kas dan Iuran Anggota

## Deskripsi Task
Mengembangkan modul pelacakan keuangan masuk berupa kewajiban iuran bulanan dari masing-masing anggota.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `dues` (id, member_id, month_year, amount, paid_at, status).
2. **Model**:
   - Buat model `Due`.
   - Definisikan relasi: `Due` belongsTo `Member` dan `Member` hasMany `Due`.
3. **Seeder**:
   - Buat `DueSeeder` berisi riwayat pembayaran iuran dummy (baik yang berstatus Lunas maupun Belum Lunas) untuk beberapa anggota.
4. **CRUD Logic**:
   - Form untuk mencatat pembayaran iuran anggota.
   - List/Tabel rekapitulasi pembayaran iuran per bulan.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Admin/Pengurus keuangan dapat melihat riwayat pembayaran tiap anggota.
- [ ] Data seeder memunculkan visualisasi anggota yang sudah lunas dan menunggak.
