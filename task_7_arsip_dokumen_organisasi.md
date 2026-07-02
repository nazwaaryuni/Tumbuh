# Task 7: Arsip Dokumen Organisasi

## Deskripsi Task
Menyediakan modul penyimpanan digital (repositori) untuk dokumen penting seperti surat masuk/keluar, proposal, LPJ, dan notulensi.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `documents` (id, title, type, file_url, uploaded_at).
2. **Model**:
   - Buat model `Document`.
3. **Seeder**:
   - Buat `DocumentSeeder` yang men-generate data dummy dokumen (Surat Keputusan, Notulensi Rapat, dll) tanpa harus menyediakan file aslinya (cukup URL dummy).
4. **CRUD Logic**:
   - Form upload dokumen dengan kategori (type) tertentu.
   - Halaman daftar dokumen dengan fitur pencarian dan filter berdasarkan tipe dokumen.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Sistem mampu mengelola metadata dokumen.
- [ ] Seeder menyediakan variasi jenis arsip dokumen untuk divisualisasikan.
