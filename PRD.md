# Product Requirements Document (PRD)
## Sistem Manajemen Organisasi

### 1. Ringkasan Eksekutif (Executive Summary)
Sistem Manajemen Organisasi adalah platform digital terpadu yang dirancang untuk mengelola seluruh aspek operasional organisasi secara efisien. Sistem ini menyediakan solusi sentralisasi data untuk pengelolaan keanggotaan, struktur hierarki, program kerja, keuangan (iuran dan anggaran), pengarsipan dokumen, hingga pencatatan prestasi.

### 2. Tujuan dan Sasaran
- **Penyimpanan Terpusat:** Mengelola seluruh data anggota, kegiatan, arsip, dan keuangan dalam satu platform (Single Source of Truth).
- **Efisiensi Kinerja:** Memudahkan setiap divisi dalam merencanakan program kerja, mengelola anggaran, dan melacak tingkat partisipasi (absensi) anggota.
- **Transparansi Keuangan:** Memantau pemasukan dari iuran anggota serta pengeluaran untuk realisasi kegiatan secara jelas dan terukur.
- **Digitalisasi Dokumen:** Mengurangi penggunaan kertas melalui pengarsipan digital untuk dokumen dan surat menyurat organisasi.

### 3. Tujuh (7) Fitur Utama
1. **Data Anggota dan Struktur Organisasi:** Pengelolaan biodata lengkap anggota beserta pemetaan struktur organisasi berdasarkan divisi dan jabatan.
2. **Program Kerja per Divisi:** Perencanaan, penyusunan, dan pemantauan program kerja yang menjadi tanggung jawab masing-masing divisi.
3. **Kegiatan dan Absensi Anggota:** Penjadwalan kegiatan organisasi yang terhubung langsung dengan sistem absensi/kehadiran anggota untuk mengukur partisipasi.
4. **Kas dan Iuran Anggota:** Pencatatan kewajiban dan pembayaran iuran bulanan/kas dari anggota.
5. **Anggaran dan Realisasi Kegiatan:** Manajemen pengajuan anggaran (budgeting) untuk setiap kegiatan beserta pencatatan pengeluaran aktual (realisasi).
6. **Arsip Dokumen Organisasi:** Repositori penyimpanan dokumen resmi, surat masuk/keluar, notulensi, dan proposal/LPJ.
7. **Prestasi dan Penghargaan:** Pencatatan portofolio prestasi atau penghargaan yang diraih oleh anggota maupun organisasi secara keseluruhan.

### 4. Arsitektur & Skema Data (Data Schema)

#### 4.1 Daftar Tabel Database
1. **`users`**: Tabel otentikasi (login, kredensial, dan hak akses/role sistem).
2. **`members`**: Profil detail anggota (NIM/NIK, nama, kontak, dll), berelasi langsung dengan akun `users`.
3. **`divisions`**: Daftar divisi atau bidang dalam organisasi (misal: Humas, R&D, dll).
4. **`positions`**: Daftar jabatan (misal: Ketua, Sekretaris, Koordinator, Staf).
5. **`programs`**: Daftar program kerja yang dirancang, di mana setiap program dimiliki oleh sebuah divisi.
6. **`activities`**: Kegiatan-kegiatan turunan dari sebuah program kerja, lengkap dengan jadwal pelaksanaannya.
7. **`attendances`**: Data presensi anggota untuk setiap kegiatan yang diselenggarakan.
8. **`dues`**: Catatan pembayaran iuran kas oleh anggota organisasi.
9. **`expense_budgets`**: Rincian rencana anggaran biaya (RAB) dan realisasi pengeluaran untuk suatu kegiatan.
10. **`documents`**: Penyimpanan arsip dokumen (proposal, surat, LPJ, dll).
11. **`achievements`**: Rekam jejak prestasi yang diperoleh anggota.
12. **`settings`**: Konfigurasi global sistem organisasi (logo, nama, dll).

#### 4.2 Penjelasan Relasi (Naratif)
- Setiap **User** terhubung (One-to-One) ke satu **Member**.
- Seorang **Member** menempati sebuah posisi (**Position**) dan ditugaskan di sebuah divisi (**Division**).
- Setiap **Division** menaungi banyak **Programs** (One-to-Many).
- Sebuah **Program** dapat terdiri dari banyak **Activities** (One-to-Many).
- Setiap **Activity** memiliki catatan kehadiran (**Attendances**) yang mereferensikan **Member** yang hadir (Many-to-Many via tabel Attendance).
- Setiap **Activity** memiliki rincian **Expense Budgets** untuk memantau dana yang diajukan dan dikeluarkan.
- Setiap **Member** memiliki riwayat pembayaran **Dues** (iuran kas) dan riwayat pencapaian **Achievements**.
- Tabel **Documents** dapat bersifat umum (milik organisasi) atau direferensikan ke tabel spesifik (misal: LPJ terkait dengan Activity).

#### 4.3 Visualisasi ERD (Mermaid)

```mermaid
erDiagram
    USERS ||--|| MEMBERS : "berelasi dengan"
    DIVISIONS ||--o{ MEMBERS : "memiliki"
    POSITIONS ||--o{ MEMBERS : "dijabat oleh"
    
    DIVISIONS ||--o{ PROGRAMS : "menjalankan"
    PROGRAMS ||--o{ ACTIVITIES : "memiliki"
    
    ACTIVITIES ||--o{ ATTENDANCES : "mencatat absensi"
    MEMBERS ||--o{ ATTENDANCES : "menghadiri"
    
    ACTIVITIES ||--o{ EXPENSE_BUDGETS : "membutuhkan"
    
    MEMBERS ||--o{ DUES : "membayar"
    MEMBERS ||--o{ ACHIEVEMENTS : "meraih"
    
    USERS {
        int id PK
        string name
        string email
        string password
        string role "Admin, Pengurus"
    }

    DIVISIONS {
        int id PK
        string name
        string description
    }

    POSITIONS {
        int id PK
        string name
        string level "Ketua, Staf, dll"
    }

    MEMBERS {
        int id PK
        int user_id FK
        int division_id FK
        int position_id FK
        string full_name
        string phone
        date join_date
        string status "Aktif, Pasif"
    }

    PROGRAMS {
        int id PK
        int division_id FK
        string name
        string description
        int year
    }

    ACTIVITIES {
        int id PK
        int program_id FK
        string name
        date start_date
        date end_date
        string location
        string status "planned, ongoing, completed, canceled"
    }

    ATTENDANCES {
        int id PK
        int activity_id FK
        int member_id FK
        datetime time
        string status "Hadir, Izin, Sakit, Alpha"
    }

    EXPENSE_BUDGETS {
        int id PK
        int activity_id FK
        string item_name
        decimal planned_amount "Rencana Anggaran"
        decimal actual_amount "Realisasi"
        string receipt_url "Bukti Nota"
    }

    DUES {
        int id PK
        int member_id FK
        string month_year
        decimal amount
        datetime paid_at
        string status "Lunas, Belum Lunas"
    }

    DOCUMENTS {
        int id PK
        string title
        string type "Surat Masuk, Surat Keluar, Proposal, LPJ"
        string file_url
        datetime created_at
    }

    ACHIEVEMENTS {
        int id PK
        int member_id FK
        string title
        string level "Lokal, Nasional, Internasional"
        date date_achieved
        text description
    }

    SETTINGS {
        int id PK
        string app_name
        string copyright
        string login_title
        string keywords
        string description
        string logo
    }
```
