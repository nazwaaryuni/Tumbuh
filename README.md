# Tumbuh - Sistem Manajemen Organisasi

Sistem Manajemen Organisasi (Tumbuh) adalah platform digital terpadu yang dirancang untuk mengelola seluruh aspek operasional organisasi secara efisien. Sistem ini menyediakan solusi sentralisasi data untuk pengelolaan keanggotaan, struktur hierarki, program kerja, keuangan (iuran dan anggaran), pengarsipan dokumen, hingga pencatatan prestasi.

Dibangun dengan **Laravel 13** dan **Bootstrap 5 (NiceAdmin Template)**.

## 🚀 Fitur Utama

- **Data Anggota dan Struktur Organisasi**: Pengelolaan biodata lengkap anggota beserta pemetaan struktur organisasi berdasarkan divisi dan jabatan.
- **Program Kerja per Divisi**: Perencanaan, penyusunan, dan pemantauan program kerja yang menjadi tanggung jawab masing-masing divisi.
- **Kegiatan dan Absensi Anggota**: Penjadwalan kegiatan organisasi yang terhubung langsung dengan sistem absensi/kehadiran anggota untuk mengukur partisipasi.
- **Kas dan Iuran Anggota**: Pencatatan kewajiban dan pembayaran iuran bulanan/kas dari anggota.
- **Anggaran dan Realisasi Kegiatan**: Manajemen pengajuan anggaran (budgeting) untuk setiap kegiatan beserta pencatatan pengeluaran aktual (realisasi).
- **Arsip Dokumen Organisasi**: Repositori penyimpanan dokumen resmi, surat masuk/keluar, notulensi, dan proposal/LPJ.
- **Prestasi dan Penghargaan**: Pencatatan portofolio prestasi atau penghargaan yang diraih oleh anggota maupun organisasi secara keseluruhan.
- **Hak Akses dan Otorisasi (Gate)**: Sistem menggunakan pembatasan akses berbasis *Role* (Admin & Pengurus) serta *Jabatan* (Ketua Umum, Sekretaris Umum, dll) untuk menjaga keamanan data.
- **Pengaturan Sistem (Settings)**: Konfigurasi nama aplikasi, logo, *copyright*, dan deskripsi web secara dinamis melalui dashboard (khusus Ketua Umum).

## 🎨 Kustomisasi Tema (Warna)

Template ini telah dimodifikasi agar warna tema utamanya sangat mudah diganti. Anda hanya perlu mengubah **CSS Variables** di satu tempat saja, dan seluruh elemen (Header, Footer, Tombol Primary, Sidebar Aktif, dll.) akan otomatis menyesuaikan.

1. Buka file `resources/views/layouts/app.blade.php`.
2. Cari bagian `<style>` di dalam tag `<head>`.
3. Ubah kode Hex warna pada blok `:root`:

```css
:root {
    /* ====== UBAH WARNA TEMA DI SINI ====== */
    --theme-bg: #FFC0CB; /* soft pink */
    --theme-hover: #FFB6C1; /* sedikit lebih gelap untuk hover */
    --theme-text: #2E8B57; /* soft green untuk tulisan */
    
    --main-bg: #FFF0F5; /* background utama halaman */
    /* ===================================== */
}
```

## 🔑 Kredensial Default

Setelah menjalankan seeder, Anda dapat login menggunakan akun berikut:

| Nama             | Email                 | Password   | Role     | Jabatan (Level) |
| ---------------- | --------------------- | ---------- | -------- | --------------- |
| Ketua Umum       | `ketua@gmail.com`     | `password` | Admin    | Ketua (Inti)    |
| Sekretaris Umum  | `sekretaris@gmail.com`| `password` | Admin    | Sekretaris (Inti)|
| Bendahara Umum   | `bendahara@gmail.com` | `password` | Admin    | Bendahara (Inti)|
| Koord Humas      | `koord.humas@gmail.com` | `password` | Admin    | Koordinator Divisi (Kadiv) |
| Pengurus Humas 1 | `pengurus1@gmail.com` | `password` | Pengurus | Pengurus (Staf) |

## 🛠️ Stack Teknologi

- **Backend**: PHP 8.3 & Laravel 13.0
- **Frontend**: Bootstrap 5 (NiceAdmin Template)
- **Database**: MySQL
- **Library Penting**:
    - `barryvdh/laravel-dompdf` (Ekspor PDF)

## 💻 Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di mesin lokal Anda:

1. **Clone Repositori**:

    ```bash
    git clone <repository-url>
    cd Tumbuh
    ```

2. **Instal Dependensi PHP & JavaScript**:

    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi Lingkungan**:
   Salin file `.env.example` menjadi `.env` dan generate key:

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Setup Database (MySQL)**:
   Pastikan Anda sudah membuat database MySQL dengan nama `tumbuh`, dan sesuaikan konfigurasi pada file `.env` Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tumbuh
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Lalu jalankan migrasi beserta seeder:

    ```bash
    php artisan migrate:fresh --seed
    ```

5. **Symlink Storage**:
   Buat tautan agar file (seperti dokumen dan logo) dapat diakses publik:
   
    ```bash
    php artisan storage:link
    ```

6. **Jalankan Aplikasi**:
   
    ```bash
    php artisan serve
    npm run dev
    ```

## 📝 Script Tambahan

- `composer run setup`: Menjalankan instalasi lengkap (composer, npm, migrate, build).
- `composer run test`: Menjalankan unit testing menggunakan Pest.

## 📄 Lisensi

Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).
