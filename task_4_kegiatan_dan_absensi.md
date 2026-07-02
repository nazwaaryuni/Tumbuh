# Task 4: Kegiatan dan Absensi Anggota

## Deskripsi Task
Membuat fitur manajemen kegiatan operasional yang bersumber dari program kerja, serta sistem untuk merekam tingkat partisipasi (kehadiran/absensi) anggota pada kegiatan tersebut.

## Spesifikasi Teknis
1. **Migration & Relasi Database**:
   - Buat tabel `activities` (id, program_id, name, start_date, end_date, location, status).
   - Buat tabel pivot `attendances` (id, activity_id, member_id, time, status).
2. **Model**:
   - Buat model `Activity` dan `Attendance`.
   - Definisikan relasi: `Activity` belongsTo `Program`, `Activity` hasMany `Attendance`, `Member` hasMany `Attendance`.
3. **Seeder**:
   - Buat `ActivitySeeder` dan `AttendanceSeeder` untuk menyimulasikan data absensi beberapa anggota pada kegiatan tertentu.
4. **CRUD Logic**:
   - Modul manajemen kegiatan yang terhubung dengan program kerja.
   - Modul input absensi (Hadir/Izin/Sakit) untuk anggota terhadap suatu kegiatan.

## Kriteria Penerimaan (Acceptance Criteria)
- [ ] Kegiatan bisa dibuat, diedit, dan dihapus dengan berinduk pada sebuah program kerja.
- [ ] Pengurus/Admin dapat mencatat atau mengubah status kehadiran anggota pada sebuah kegiatan.
- [ ] Data seeder absensi dapat divisualisasikan dengan benar.
