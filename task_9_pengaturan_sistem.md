# Task 9: Pengaturan Sistem (Settings)

## Deskripsi Task
Membuat modul konfigurasi dinamis yang mengatur aspek visual dan global pada sistem, seperti logo, nama organisasi, dan preferensi lainnya.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `settings` (id, key_name, value).
2. **Model**:
   - Buat model `Setting`.
3. **Seeder**:
   - Buat `SettingSeeder` yang men-generate data kunci seperti `app_name` dan `logo` beserta nilai defaultnya.
4. **CRUD Logic**:
   - Halaman khusus (khusus Admin) untuk mengubah nilai dari *settings*.
   - Integrasikan pengambilan data `settings` secara global untuk keperluan View (misal: memanggil logo pada Navbar/Login).

## Kriteria Penerimaan (Acceptance Criteria)
- [x] Seeder membuat konfigurasi standar.
- [x] Perubahan logo/nama dari menu pengaturan langsung memengaruhi tampilan utama organisasi tanpa hardcode.
