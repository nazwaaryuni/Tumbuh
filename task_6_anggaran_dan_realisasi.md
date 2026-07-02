# Task 6: Anggaran dan Realisasi Kegiatan

## Deskripsi Task
Membangun fitur manajemen keuangan keluar (budgeting) untuk setiap kegiatan organisasi, dari tahap rencana (RAB) hingga realisasi pengeluaran.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `expense_budgets` (id, activity_id, item_name, planned_amount, actual_amount, receipt_url).
2. **Model**:
   - Buat model `ExpenseBudget`.
   - Definisikan relasi: `ExpenseBudget` belongsTo `Activity` dan `Activity` hasMany `ExpenseBudget`.
3. **Seeder**:
   - Buat `ExpenseBudgetSeeder` dengan data dummy rincian biaya suatu kegiatan (contoh: Biaya Konsumsi, Biaya Perlengkapan).
4. **CRUD Logic**:
   - Modul untuk memasukkan item Rencana Anggaran.
   - Fitur update item tersebut untuk mengisi Realisasi beserta upload bukti nota (jika diperlukan).

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Admin/Pengurus dapat memantau estimasi vs realisasi dana pada tiap kegiatan.
- [ ] Data seeder anggaran tampil sempurna di list kegiatan.
