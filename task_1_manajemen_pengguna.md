# Task 1: Manajemen Pengguna dan Autentikasi (User Management)

## Deskripsi Task
Menyesuaikan sistem autentikasi dan manajemen pengguna (user management) yang sudah ada di Laravel agar selaras dengan PRD.md, khususnya terkait peran pengguna (user role). 

## Spesifikasi Teknis
1. **Migration & Struktur Tabel**: 
   - Modifikasi tabel `users` agar memiliki field `role` (Admin, Pengurus, Anggota) sesuai spesifikasi PRD.
2. **Model**:
   - Sesuaikan model `User` yang ada agar mendukung perubahan atribut baru tersebut.
3. **Seeder**:
   - Perbarui atau buat seeder (`UserSeeder`) untuk meng-generate data dummy bagi setiap role (contoh: 1 Superadmin/Admin, 2 Pengurus, 5 Anggota).
4. **CRUD Logic**:
   - Sesuaikan logika Create, Read, Update, dan Delete di controller (seperti `UserController`) agar dapat memproses role pengguna baru.
   - Wajib mengikuti standar coding style, pola arsitektur, dan konvensi penamaan modul user saat ini tanpa membuat pola baru.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Tabel `users` memiliki field `role`.
- [ ] Dummy data ter-generate sukses melalui perintah seeder.
- [ ] Admin dapat melakukan CRUD pada user dan mengatur role mereka menggunakan existing UI/Architecture.
