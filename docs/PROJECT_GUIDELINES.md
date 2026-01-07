# 📚 PROJECT GUIDELINES - Management Siswa Praktikum

## 📋 Daftar Isi
1. [Informasi Project](#informasi-project)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Arsitektur Database](#arsitektur-database)
4. [Fitur Utama](#fitur-utama)
5. [Keamanan](#keamanan)
6. [Panduan Pengembangan](#panduan-pengembangan)
7. [Konvensi Kode](#konvensi-kode)

---

## 📌 Informasi Project

| Item | Detail |
|------|--------|
| **Nama Project** | Management Siswa Praktikum |
| **Framework** | Laravel 12 |
| **PHP Version** | 8.2+ |
| **Database** | MySQL / MariaDB |
| **Frontend** | Bootstrap 5, Chart.js, DataTables, Select2, Flatpickr, Toastr |

---

## 🛠️ Teknologi yang Digunakan

### Backend
- **Laravel 12** - PHP Framework
- **MySQL/MariaDB** - Database
- **Eloquent ORM** - Database Abstraction

### Frontend
- **Bootstrap 5** - CSS Framework untuk Responsive Design
- **Chart.js** - Visualisasi Data/Chart
- **DataTables** - Sorting & Pagination tabel
- **Select2** - Dropdown yang lebih baik
- **Flatpickr** - Date/Time Picker
- **Toastr** - Notifikasi Toast
- **AJAX/Fetch** - Live Search dan interaksi dinamis

---

## 🗄️ Arsitektur Database

### Diagram Entity Relationship (ERD)

```
┌─────────────┐     ┌─────────────┐     ┌─────────────────┐
│    USERS    │     │    KELAS    │     │ MATA_PELAJARAN  │
│ (Admin/Guru)│◄────│             │◄────│                 │
└──────┬──────┘     └──────┬──────┘     └────────┬────────┘
       │                   │                      │
       │                   │                      │
       ▼                   ▼                      ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────────┐
│   JADWAL    │     │    SISWA    │     │  JAM_PELAJARAN  │
│   KELAS     │     │             │     │                 │
└─────────────┘     └──────┬──────┘     └─────────────────┘
                           │
       ┌───────────────────┼───────────────────┐
       ▼                   ▼                   ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────────┐
│   ABSENSI   │     │    POIN     │     │      POIN       │
│             │     │  PRESTASI   │     │  PELANGGARAN    │
└─────────────┘     └─────────────┘     └─────────────────┘
```

### Tabel Database

#### 1. USERS (Admin & Guru)
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| username | VARCHAR(50) | Username login | UNIQUE, NOT NULL |
| password | VARCHAR(255) | Password hash | NOT NULL |
| nama_lengkap | VARCHAR(100) | Nama lengkap | NOT NULL |
| jenis_kelamin | ENUM('L','P') | Jenis kelamin | DEFAULT 'L' |
| nip | VARCHAR(30) | NIP guru | UNIQUE |
| tempat_lahir | VARCHAR(50) | Tempat lahir | - |
| tanggal_lahir | DATE | Tanggal lahir | - |
| alamat | TEXT | Alamat lengkap | - |
| no_telepon | VARCHAR(15) | No. telepon | - |
| email | VARCHAR(100) | Email | UNIQUE |
| role | ENUM('admin','guru') | Role pengguna | DEFAULT 'guru' |
| jabatan | VARCHAR(100) | Jabatan | - |
| bidang_studi | VARCHAR(100) | Bidang studi | - |
| foto | VARCHAR(255) | Path foto | - |
| status | ENUM('aktif','nonaktif','pensiun','pindah') | Status | DEFAULT 'aktif' |
| last_login | TIMESTAMP | Login terakhir | NULL |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 2. SISWA
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| nis | VARCHAR(20) | Nomor Induk Siswa | UNIQUE, NOT NULL |
| nisn | VARCHAR(20) | Nomor Induk Nasional | UNIQUE, NOT NULL |
| nama_lengkap | VARCHAR(100) | Nama lengkap siswa | NOT NULL |
| jenis_kelamin | ENUM('L','P') | Jenis kelamin | NOT NULL |
| tempat_lahir | VARCHAR(50) | Tempat lahir | - |
| tanggal_lahir | DATE | Tanggal lahir | - |
| agama | VARCHAR(20) | Agama | - |
| alamat | TEXT | Alamat lengkap | - |
| rt_rw | VARCHAR(10) | RT/RW | - |
| kelurahan | VARCHAR(50) | Kelurahan | - |
| kecamatan | VARCHAR(50) | Kecamatan | - |
| kota | VARCHAR(50) | Kota | - |
| provinsi | VARCHAR(50) | Provinsi | - |
| kode_pos | VARCHAR(10) | Kode pos | - |
| no_telepon | VARCHAR(15) | No. telepon | - |
| email | VARCHAR(100) | Email | - |
| nama_ayah | VARCHAR(100) | Nama ayah | - |
| nama_ibu | VARCHAR(100) | Nama ibu | - |
| pekerjaan_ayah | VARCHAR(100) | Pekerjaan ayah | - |
| pekerjaan_ibu | VARCHAR(100) | Pekerjaan ibu | - |
| no_telepon_ortu | VARCHAR(15) | No. telepon ortu | - |
| kelas_id | INT | Foreign ke kelas | FOREIGN KEY |
| foto | VARCHAR(255) | Path foto siswa | - |
| status | ENUM('aktif','alumni','pindah','keluar','dropout') | Status siswa | DEFAULT 'aktif' |
| tahun_masuk | YEAR | Tahun masuk | - |
| tahun_keluar | YEAR | Tahun keluar | - |
| total_poin_prestasi | INT | Total poin prestasi | DEFAULT 0 |
| total_poin_pelanggaran | INT | Total poin pelanggaran | DEFAULT 0 |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 3. KELAS
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| kode_kelas | VARCHAR(10) | Kode kelas | UNIQUE, NOT NULL |
| nama_kelas | VARCHAR(50) | Nama kelas | NOT NULL |
| tingkat | ENUM('X','XI','XII') | Tingkat kelas | NOT NULL |
| jurusan | VARCHAR(50) | Jurusan | - |
| wali_kelas_id | INT | Foreign ke users | FOREIGN KEY, NULL |
| kapasitas | INT | Kapasitas siswa | DEFAULT 30 |
| ruangan | VARCHAR(20) | Ruangan kelas | - |
| tahun_ajaran | VARCHAR(9) | Tahun ajaran | - |
| semester | ENUM('ganjil','genap') | Semester | DEFAULT 'ganjil' |
| status | ENUM('aktif','nonaktif') | Status kelas | DEFAULT 'aktif' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 4. MATA_PELAJARAN
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| kode_mapel | VARCHAR(10) | Kode mata pelajaran | UNIQUE, NOT NULL |
| nama_mapel | VARCHAR(100) | Nama mata pelajaran | NOT NULL |
| kategori | ENUM('umum','jurusan','peminatan','ekstrakurikuler') | Kategori | DEFAULT 'umum' |
| tingkat | ENUM('X','XI','XII','semua') | Tingkat berlaku | DEFAULT 'semua' |
| jurusan | VARCHAR(50) | Jurusan | - |
| guru_id | INT | FK ke users (guru pengampu) | FOREIGN KEY, NULL |
| kelas_id | INT | Foreign ke kelas | FOREIGN KEY, NULL |
| semester | ENUM('ganjil','genap','tahunan') | Semester | DEFAULT 'tahunan' |
| tahun_ajaran | VARCHAR(9) | Tahun ajaran | - |
| jam_per_minggu | INT | Jam per minggu | DEFAULT 2 |
| deskripsi | TEXT | Deskripsi mata pelajaran | - |
| status | ENUM('aktif','nonaktif') | Status mapel | DEFAULT 'aktif' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 5. JAM_PELAJARAN
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| sesi | INT | Nomor sesi | NOT NULL |
| jam_mulai | TIME | Jam mulai pelajaran | NOT NULL |
| jam_selesai | TIME | Jam selesai pelajaran | NOT NULL |
| keterangan | VARCHAR(50) | Keterangan sesi | - |
| jenis | ENUM('normal','istirahat','upacara','khusus') | Jenis sesi | DEFAULT 'normal' |
| hari | ENUM('senin','selasa','rabu','kamis','jumat','sabtu','minggu','semua') | Hari berlaku | DEFAULT 'semua' |
| status | ENUM('aktif','nonaktif') | Status jam | DEFAULT 'aktif' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 6. JADWAL_KELAS
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| hari | ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') | Hari pelajaran | NOT NULL |
| sesi | INT | Sesi pelajaran | NOT NULL |
| mapel_id | INT | FK ke mata_pelajaran | FOREIGN KEY |
| kelas_id | INT | Foreign ke kelas | FOREIGN KEY |
| guru_id | INT | Foreign ke users (guru) | FOREIGN KEY |
| ruangan | VARCHAR(20) | Ruangan kelas | - |
| tahun_ajaran | VARCHAR(9) | Tahun ajaran | - |
| semester | ENUM('ganjil','genap') | Semester | DEFAULT 'ganjil' |
| status | ENUM('aktif','nonaktif') | Status jadwal | DEFAULT 'aktif' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 7. ABSENSI
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| siswa_id | INT | FK ke siswa | FOREIGN KEY |
| mapel_id | INT | FK ke mata_pelajaran | FOREIGN KEY |
| guru_id | INT | FK ke users | FOREIGN KEY |
| tanggal | DATE | Tanggal absensi | NOT NULL |
| sesi | INT | Sesi pelajaran | - |
| status | ENUM('hadir','sakit','izin','alfa','terlambat','dinas','cuti') | Status absensi | DEFAULT 'hadir' |
| jam_masuk | TIME | Jam masuk | - |
| jam_keluar | TIME | Jam keluar | - |
| keterangan | TEXT | Keterangan | - |
| file_bukti | VARCHAR(255) | File bukti | - |
| metode_absen | ENUM('manual','qr_code','fingerprint','face_recognition') | Metode absen | DEFAULT 'manual' |
| latitude | DECIMAL(10,8) | Latitude lokasi | - |
| longitude | DECIMAL(11,8) | Longitude lokasi | - |
| verified_by | INT | Diverifikasi oleh | FOREIGN KEY |
| verified_at | TIMESTAMP | Waktu verifikasi | - |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 8. POIN_PRESTASI
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| siswa_id | INT | FK ke siswa | FOREIGN KEY |
| tanggal | DATE | Tanggal prestasi | NOT NULL |
| jenis_prestasi | ENUM('akademik','non-akademik','sosial','olahraga','seni','lainnya') | Jenis | NOT NULL |
| kategori | ENUM('prestasi','penghargaan','lomba','kejuaraan') | Kategori | DEFAULT 'prestasi' |
| nama_prestasi | VARCHAR(200) | Nama prestasi | NOT NULL |
| deskripsi | TEXT | Deskripsi prestasi | - |
| tingkat | ENUM('sekolah','kecamatan','kabupaten','provinsi','nasional','internasional') | Tingkat | DEFAULT 'sekolah' |
| peringkat | ENUM('juara_1','juara_2','juara_3','harapan','partisipasi') | Peringkat | DEFAULT 'partisipasi' |
| poin | INT | Jumlah poin | DEFAULT 0 |
| penyelenggara | VARCHAR(200) | Penyelenggara | - |
| tempat | VARCHAR(200) | Tempat | - |
| file_bukti | VARCHAR(255) | File bukti | - |
| file_sertifikat | VARCHAR(255) | File sertifikat | - |
| status | ENUM('pending','approved','rejected') | Status | DEFAULT 'pending' |
| catatan | TEXT | Catatan | - |
| created_by | INT | Dibuat oleh | FOREIGN KEY |
| approved_by | INT | Disetujui oleh | FOREIGN KEY |
| approved_at | TIMESTAMP | Waktu persetujuan | - |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 9. POIN_PELANGGARAN
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| siswa_id | INT | FK ke siswa | FOREIGN KEY |
| tanggal | DATE | Tanggal pelanggaran | NOT NULL |
| jenis_pelanggaran | ENUM('ringan','sedang','berat') | Jenis | NOT NULL |
| nama_pelanggaran | VARCHAR(200) | Nama pelanggaran | NOT NULL |
| deskripsi | TEXT | Deskripsi | - |
| poin | INT | Jumlah poin | DEFAULT 0 |
| sanksi | TEXT | Sanksi | - |
| status | ENUM('pending','ditindak','selesai') | Status | DEFAULT 'pending' |
| ditindak_oleh | INT | Ditindak oleh | FOREIGN KEY |
| tindakan | TEXT | Tindakan | - |
| tanggal_tindakan | DATE | Tanggal tindakan | - |
| follow_up | TEXT | Follow up | - |
| follow_up_by | INT | Follow up oleh | FOREIGN KEY |
| file_bukti | VARCHAR(255) | File bukti | - |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 10. POIN_KATEGORI
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| jenis | ENUM('prestasi','pelanggaran') | Jenis kategori | NOT NULL |
| kode | VARCHAR(10) | Kode kategori | UNIQUE, NOT NULL |
| nama | VARCHAR(100) | Nama kategori | NOT NULL |
| deskripsi | TEXT | Deskripsi | - |
| poin_min | INT | Poin minimum | DEFAULT 0 |
| poin_max | INT | Poin maksimum | DEFAULT 0 |
| warna | VARCHAR(7) | Warna HEX | - |
| status | ENUM('aktif','nonaktif') | Status | DEFAULT 'aktif' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 11. SEMESTER
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| tahun_ajaran_id | INT | FK ke tahun_ajaran | FOREIGN KEY |
| semester | ENUM('ganjil','genap') | Semester | NOT NULL |
| tanggal_mulai | DATE | Tanggal mulai | NOT NULL |
| tanggal_selesai | DATE | Tanggal selesai | NOT NULL |
| status | ENUM('aktif','selesai','akan_datang') | Status | DEFAULT 'akan_datang' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 12. TAHUN_AJARAN
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| nama | VARCHAR(9) | Nama tahun ajaran (2024/2025) | UNIQUE, NOT NULL |
| tanggal_mulai | DATE | Tanggal mulai | NOT NULL |
| tanggal_selesai | DATE | Tanggal selesai | NOT NULL |
| status | ENUM('aktif','selesai','akan_datang') | Status | DEFAULT 'akan_datang' |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 13. AKTIVITAS_SISWA
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| siswa_id | INT | FK ke siswa | FOREIGN KEY |
| jenis_aktivitas | ENUM('absensi','prestasi','pelanggaran','perubahan_data','lainnya') | Jenis | NOT NULL |
| deskripsi | TEXT | Deskripsi aktivitas | - |
| data_lama | JSON | Data sebelum perubahan | - |
| data_baru | JSON | Data sesudah perubahan | - |
| created_by | INT | Dibuat oleh | FOREIGN KEY |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 14. SETTINGS
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| setting_key | VARCHAR(100) | Key setting | UNIQUE, NOT NULL |
| setting_value | TEXT | Value setting | - |
| setting_type | ENUM('text','number','boolean','json','date','time') | Tipe | DEFAULT 'text' |
| setting_group | VARCHAR(50) | Group setting | - |
| label | VARCHAR(100) | Label untuk UI | - |
| description | TEXT | Deskripsi | - |
| is_public | BOOLEAN | Publik atau tidak | DEFAULT FALSE |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |
| updated_at | TIMESTAMP | Waktu update | ON UPDATE CURRENT_TIMESTAMP |

#### 15. ACTIVITY_LOGS
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| user_id | INT | FK ke users | FOREIGN KEY |
| action | VARCHAR(50) | Aksi yang dilakukan | NOT NULL |
| module | VARCHAR(50) | Modul yang diakses | NOT NULL |
| description | TEXT | Deskripsi aksi | - |
| ip_address | VARCHAR(45) | IP Address | - |
| user_agent | TEXT | User Agent | - |
| old_values | JSON | Nilai lama | - |
| new_values | JSON | Nilai baru | - |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |

#### 16. NOTIFICATIONS
| Field | Tipe Data | Keterangan | Constraint |
|-------|-----------|------------|------------|
| id | INT | Primary Key | AUTO_INCREMENT, PRIMARY KEY |
| user_id | INT | FK ke users | FOREIGN KEY |
| type | ENUM('info','warning','success','danger') | Tipe notifikasi | DEFAULT 'info' |
| title | VARCHAR(200) | Judul notifikasi | NOT NULL |
| message | TEXT | Isi notifikasi | - |
| is_read | BOOLEAN | Sudah dibaca | DEFAULT FALSE |
| read_at | TIMESTAMP | Waktu dibaca | NULL |
| data | JSON | Data tambahan | - |
| created_at | TIMESTAMP | Waktu dibuat | DEFAULT CURRENT_TIMESTAMP |

---

## 🔗 Relasi Antar Tabel (Foreign Keys)

| Tabel | Field | References | Tabel Target | On Delete |
|-------|-------|------------|--------------|-----------|
| kelas | wali_kelas_id | users(id) | users | SET NULL |
| siswa | kelas_id | kelas(id) | kelas | SET NULL |
| mata_pelajaran | guru_id | users(id) | users | SET NULL |
| mata_pelajaran | kelas_id | kelas(id) | kelas | CASCADE |
| jadwal_kelas | mapel_id | mata_pelajaran(id) | mata_pelajaran | CASCADE |
| jadwal_kelas | kelas_id | kelas(id) | kelas | CASCADE |
| jadwal_kelas | guru_id | users(id) | users | CASCADE |
| absensi | siswa_id | siswa(id) | siswa | CASCADE |
| absensi | mapel_id | mata_pelajaran(id) | mata_pelajaran | CASCADE |
| absensi | guru_id | users(id) | users | SET NULL |
| absensi | verified_by | users(id) | users | SET NULL |
| poin_prestasi | siswa_id | siswa(id) | siswa | CASCADE |
| poin_prestasi | created_by | users(id) | users | SET NULL |
| poin_prestasi | approved_by | users(id) | users | SET NULL |
| poin_pelanggaran | siswa_id | siswa(id) | siswa | CASCADE |
| poin_pelanggaran | ditindak_oleh | users(id) | users | SET NULL |
| poin_pelanggaran | follow_up_by | users(id) | users | SET NULL |
| aktivitas_siswa | siswa_id | siswa(id) | siswa | CASCADE |
| aktivitas_siswa | created_by | users(id) | users | SET NULL |
| activity_logs | user_id | users(id) | users | CASCADE |
| notifications | user_id | users(id) | users | CASCADE |

---

## 📊 Index untuk Performansi

| Tabel | Nama Index | Kolom | Tipe | Keterangan |
|-------|------------|-------|------|------------|
| siswa | idx_siswa_nis | nis | UNIQUE | Pencarian NIS |
| siswa | idx_siswa_nisn | nisn | UNIQUE | Pencarian NISN |
| siswa | idx_siswa_kelas | kelas_id | INDEX | Filter kelas |
| siswa | idx_siswa_status | status | INDEX | Filter status |
| absensi | idx_absensi_tanggal | tanggal | INDEX | Filter tanggal |
| absensi | idx_absensi_siswa | siswa_id | INDEX | Filter siswa |
| absensi | idx_absensi_mapel | mapel_id | INDEX | Filter mapel |
| absensi | idx_absensi_status | status | INDEX | Filter status |
| absensi | idx_absensi_guru | guru_id | INDEX | Filter guru |
| absensi | idx_absensi_siswa_tanggal | siswa_id, tanggal | COMPOSITE | Query rekap |
| users | idx_users_username | username | UNIQUE | Login |
| users | idx_users_role | role | INDEX | Filter role |
| users | idx_users_status | status | INDEX | Filter status |
| jadwal_kelas | idx_jadwal_kelas_hari | hari | INDEX | Filter hari |
| jadwal_kelas | idx_jadwal_kelas_kelas | kelas_id | INDEX | Filter kelas |
| jadwal_kelas | idx_jadwal_kelas_guru | guru_id | INDEX | Filter guru |
| poin_prestasi | idx_poin_prestasi_siswa | siswa_id | INDEX | Filter siswa |
| poin_prestasi | idx_poin_prestasi_tanggal | tanggal | INDEX | Filter tanggal |
| poin_prestasi | idx_poin_prestasi_status | status | INDEX | Filter status |
| poin_pelanggaran | idx_poin_pelanggaran_siswa | siswa_id | INDEX | Filter siswa |
| poin_pelanggaran | idx_poin_pelanggaran_tanggal | tanggal | INDEX | Filter tanggal |
| poin_pelanggaran | idx_poin_pelanggaran_status | status | INDEX | Filter status |

---

## 🎯 Fitur Utama

### 1. Manajemen Siswa
- [x] CRUD data siswa lengkap
- [x] Upload foto siswa dengan validasi
- [x] Filter dan pencarian (Live Search dengan AJAX)
- [x] Pagination dengan DataTables
- [x] Export/Import data (Excel, CSV, PDF)

### 2. Manajemen Kelas
- [x] Pengelolaan kelas (CRUD)
- [x] Assignasi wali kelas
- [x] Kapasitas kelas dan ruangan
- [x] Status kelas (aktif/nonaktif)

### 3. Manajemen Mata Pelajaran
- [x] Data mata pelajaran
- [x] Guru pengampu (assignment)
- [x] Kategori mata pelajaran
- [x] Jam per minggu

### 4. Manajemen Guru/Staff
- [x] Data guru lengkap
- [x] Role admin/guru
- [x] Bidang studi dan jabatan
- [x] Status kepegawaian

### 5. Pengaturan Jam Pelajaran
- [x] Setting jam masuk/keluar
- [x] Sesi pelajaran
- [x] Jenis sesi (normal, istirahat, upacara, khusus)

### 6. Jadwal Kelas
- [x] Penjadwalan per hari
- [x] Ruangan
- [x] Guru pengajar
- [x] Tahun ajaran dan semester

### 7. Sistem Absensi
- [x] Absensi per mata pelajaran
- [x] Multiple status (hadir, sakit, izin, alfa, terlambat)
- [x] Metode absen (manual, QR, fingerprint, face recognition)
- [x] Upload bukti (surat izin/sakit)
- [x] Verifikasi oleh guru

### 8. Poin Prestasi & Pelanggaran
- [x] Sistem poin prestasi (akademik/non-akademik)
- [x] Sistem poin pelanggaran dengan sanksi
- [x] Approval workflow
- [x] Tingkat prestasi (sekolah sampai internasional)
- [x] Follow up pelanggaran

### 9. Dashboard & Laporan
- [x] Statistik real-time
- [x] Chart visualisasi (Chart.js)
- [x] Laporan absensi
- [x] Laporan poin prestasi/pelanggaran
- [x] Export data (Excel, PDF)

---

## 🔒 Keamanan

### SQL Injection Protection
```php
// ✅ BENAR - Gunakan Prepared Statements
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

// ✅ BENAR - Gunakan real_escape_string (legacy)
$username = mysqli_real_escape_string($conn, $_POST['username']);

// ✅ BENAR - Gunakan Eloquent ORM
User::where('username', $username)->first();
```

### XSS Protection
```php
// ✅ BENAR - Gunakan htmlspecialchars untuk output
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

// ✅ BENAR - Gunakan Blade escaping
{{ $variable }}

// ❌ SALAH - Unescaped output (hindari)
{!! $variable !!}
```

### File Upload Validation
```php
// Validasi tipe file
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

// Validasi ukuran file (max 2MB)
$maxSize = 2 * 1024 * 1024;

// Sanitasi nama file
$fileName = preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
```

### Session Management
```php
// Regenerate session ID setelah login
session_regenerate_id(true);

// Set session timeout
ini_set('session.gc_maxlifetime', 3600);

// Secure session cookie
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);
```

### CSRF Protection
```php
// Di form
<input type="hidden" name="_token" value="{{ csrf_token() }}">

// Atau gunakan directive
@csrf

// Validasi di controller
if (!hash_equals($_SESSION['csrf_token'], $_POST['_token'])) {
    abort(403);
}
```

### Role-based Access Control (RBAC)
```php
// Middleware untuk role check
if (Auth::user()->role !== 'admin') {
    abort(403, 'Unauthorized');
}

// Atau gunakan Gate
Gate::define('manage-users', function ($user) {
    return $user->role === 'admin';
});
```

---

## 💻 Panduan Pengembangan

### Struktur Folder
```
management-siswa-praktikum/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── SiswaController.php
│   │   │   ├── KelasController.php
│   │   │   ├── GuruController.php
│   │   │   ├── MapelController.php
│   │   │   ├── JadwalController.php
│   │   │   ├── AbsensiController.php
│   │   │   ├── PoinPrestasiController.php
│   │   │   ├── PoinPelanggaranController.php
│   │   │   └── LaporanController.php
│   │   ├── Middleware/
│   │   │   ├── AuthMiddleware.php
│   │   │   ├── RoleMiddleware.php
│   │   │   └── CsrfMiddleware.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Siswa.php
│   │   ├── Kelas.php
│   │   ├── MataPelajaran.php
│   │   ├── JamPelajaran.php
│   │   ├── JadwalKelas.php
│   │   ├── Absensi.php
│   │   ├── PoinPrestasi.php
│   │   └── PoinPelanggaran.php
│   └── Services/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/
│       ├── siswa/
│       ├── guru/
│       └── bukti/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       ├── dashboard/
│       ├── siswa/
│       ├── kelas/
│       ├── guru/
│       ├── mapel/
│       ├── jadwal/
│       ├── absensi/
│       ├── poin/
│       └── laporan/
├── routes/
│   └── web.php
└── docs/
    └── PROJECT_GUIDELINES.md
```

### Command Artisan yang Sering Digunakan
```bash
# Membuat migration
php artisan make:migration create_nama_table

# Menjalankan migration
php artisan migrate

# Rollback migration
php artisan migrate:rollback

# Membuat model dengan migration
php artisan make:model NamaModel -m

# Membuat controller
php artisan make:controller NamaController --resource

# Membuat seeder
php artisan make:seeder NamaSeeder

# Menjalankan seeder
php artisan db:seed

# Fresh migration dengan seeder
php artisan migrate:fresh --seed
```

---

## 📝 Konvensi Kode

### Naming Conventions

| Type | Convention | Contoh |
|------|------------|--------|
| Controller | PascalCase + Controller | `SiswaController` |
| Model | PascalCase (singular) | `Siswa`, `User` |
| Migration | snake_case | `create_siswa_table` |
| Tabel | snake_case (plural) | `siswa`, `mata_pelajaran` |
| Kolom | snake_case | `nama_lengkap`, `tanggal_lahir` |
| Route | kebab-case | `/data-siswa`, `/mata-pelajaran` |
| View | kebab-case | `siswa/create.blade.php` |
| CSS Class | kebab-case | `.btn-primary`, `.card-header` |
| JS Function | camelCase | `loadSiswaData()`, `handleSubmit()` |

### PHP Code Style
```php
<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $siswa = Siswa::with('kelas')
            ->orderBy('nama_lengkap')
            ->paginate(10);
            
        return view('siswa.index', compact('siswa'));
    }
    
    /**
     * Menyimpan data siswa baru
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nisn' => 'required|unique:siswa,nisn',
            'nama_lengkap' => 'required|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        
        Siswa::create($validated);
        
        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }
}
```

---

## 📋 Checklist Development

### Phase 1: Database & Authentication
- [ ] Setup database connection
- [ ] Jalankan semua migration
- [ ] Buat seeder untuk data awal
- [ ] Implementasi sistem login/logout
- [ ] Implementasi role-based access

### Phase 2: Core Features
- [ ] CRUD Siswa
- [ ] CRUD Kelas
- [ ] CRUD Guru/Staff
- [ ] CRUD Mata Pelajaran
- [ ] CRUD Jam Pelajaran
- [ ] CRUD Jadwal Kelas

### Phase 3: Advanced Features
- [ ] Sistem Absensi
- [ ] Poin Prestasi
- [ ] Poin Pelanggaran
- [ ] Dashboard dengan Chart

### Phase 4: Reports & Export
- [ ] Laporan Absensi
- [ ] Laporan Poin
- [ ] Export Excel/PDF
- [ ] Print-friendly views

### Phase 5: Polish & Security
- [ ] Live Search (AJAX)
- [ ] DataTables integration
- [ ] Security hardening
- [ ] Activity logging
- [ ] Responsive testing

---

## 📦 Library & Dependencies

### Backend (composer.json)
```json
{
    "require": {
        "php": "^8.2",
        "laravel/framework": "^12.0",
        "maatwebsite/excel": "^3.1",
        "barryvdh/laravel-dompdf": "^2.0"
    }
}
```

### Frontend (CDN)
```html
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.0/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.0/js/dataTables.bootstrap5.min.js"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- Flatpickr -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Toastr -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
```

---

## 🚀 Installation Wizard

Sistem ini akan dilengkapi dengan Installation Wizard untuk memudahkan setup awal:

1. **Step 1**: System Requirements Check
   - PHP Version
   - Extensions (PDO, Mbstring, OpenSSL, etc)
   - Write permissions

2. **Step 2**: Database Configuration
   - Host, Port
   - Database name
   - Username, Password

3. **Step 3**: Admin Account Setup
   - Username
   - Email
   - Password

4. **Step 4**: School Information
   - Nama Sekolah
   - Alamat
   - Logo

5. **Step 5**: Initial Settings
   - Tahun Ajaran
   - Semester
   - Jam Pelajaran Default

---

**Last Updated**: 2026-01-07  
**Version**: 1.0.0
