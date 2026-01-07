# 📚 Manajemen Kelas

## Deskripsi
Halaman Manajemen Kelas berfungsi sebagai pusat pengaturan struktur organisasi siswa di sekolah. Di sini, Anda mengelola identitas fisik (ruangan) dan identitas akademik (wali kelas dan tingkat) setiap rombongan belajar.

## Fitur Utama

### 1. Statistik Ringkas (Dashboard Cards)
- **Total Kelas Aktif**: Menampilkan jumlah total kelas yang berstatus aktif
- **Kelas per Tingkat**: Breakdown jumlah kelas untuk tingkat X, XI, dan XII
- **Rata-rata Kapasitas**: Menampilkan rata-rata kapasitas per kelas

### 2. Filter & Pencarian
- **Filter Tingkat**: Menyaring kelas berdasarkan jenjang (X, XI, atau XII)
- **Filter Tahun Ajaran**: Memfilter berdasarkan periode akademik
- **Filter Semester**: Memilih semester ganjil atau genap
- **Pencarian**: Mencari kelas berdasarkan kode_kelas, nama_kelas, atau jurusan

### 3. Tabel Data Kelas
Menampilkan informasi lengkap setiap kelas:
- **Kode Kelas**: Identitas unik kelas (contoh: X-IPA-1)
- **Nama Kelas**: Nama lengkap kelas (contoh: X IPA 1)
- **Tingkat**: Badge visual menunjukkan tingkat kelas
- **Wali Kelas**: Nama guru yang menjadi wali kelas (dengan avatar)
- **Ruangan**: Lokasi fisik kelas
- **Kapasitas**: Progress bar menunjukkan jumlah siswa vs kapasitas maksimal
- **Status**: Aktif atau Nonaktif
- **Aksi**: Tombol Detail, Edit, dan Hapus

### 4. Form CRUD (Modal)

#### Tambah/Edit Kelas
Form mencakup field berikut:
- **Kode Kelas** (required): Maksimal 10 karakter, harus unik
- **Nama Kelas** (required): Maksimal 50 karakter
- **Tingkat** (required): Pilihan X, XI, atau XII
- **Jurusan** (optional): Contoh: IPA, IPS, Bahasa
- **Wali Kelas** (optional): Dropdown guru aktif
- **Ruangan** (optional): Maksimal 20 karakter
- **Kapasitas** (required): 1-50 siswa, default 30
- **Tahun Ajaran** (optional): Format 2024/2025
- **Semester** (required): Ganjil atau Genap
- **Status** (required): Aktif atau Nonaktif

#### Detail Kelas
Modal detail menampilkan:
- Informasi Dasar (kode, nama, tingkat, jurusan)
- Wali Kelas & Ruangan (nama wali kelas, NIP, ruangan)
- Kapasitas & Status (kapasitas maksimal, jumlah siswa, sisa kuota, status)
- Periode Akademik (tahun ajaran, semester, tanggal dibuat/update)

### 5. Validasi & Aturan Bisnis

#### Validasi Input
- Kode kelas harus unik dalam sistem
- Kapasitas minimal 1, maksimal 50 siswa
- Wali kelas harus user dengan role 'guru'

#### Aturan Penghapusan
- Kelas tidak dapat dihapus jika masih memiliki siswa aktif
- Sistem akan menampilkan pesan error dengan jumlah siswa aktif

#### Relasi Database
- **Foreign Key**: `wali_kelas_id` → `users.id` (ON DELETE SET NULL)
- **Unique Constraint**: `kode_kelas` harus unik
- **Index**: Pada kolom `tingkat`, `status`, dan `tahun_ajaran` untuk performa query

## Struktur File

```
app/
├── Http/Controllers/
│   └── KelasController.php          # Controller utama (270 baris)
├── Models/
│   └── Kelas.php                    # Model dengan relasi

resources/views/kelas/
├── index.blade.php                  # View utama
└── partials/
    ├── header.blade.php             # Header & statistik cards
    ├── filter.blade.php             # Form filter & search
    ├── table.blade.php              # Tabel data kelas
    ├── pagination.blade.php         # Pagination
    ├── form-modal.blade.php         # Modal create/edit
    ├── detail-modal.blade.php       # Modal detail
    ├── delete-modal.blade.php       # Modal konfirmasi hapus
    └── scripts.blade.php            # Alpine.js scripts

database/
└── seeders/
    └── KelasSeeder.php              # Sample data kelas
```

## API Endpoints

### View Routes
- `GET /kelas` - Halaman index manajemen kelas

### API Routes
- `GET /api/kelas` - Get all kelas (dengan filter)
- `GET /api/kelas/{id}` - Get detail kelas
- `POST /api/kelas` - Create kelas baru
- `PUT /api/kelas/{id}` - Update kelas
- `DELETE /api/kelas/{id}` - Delete kelas

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Frontend**: Blade Templates + Alpine.js
- **Styling**: Tailwind CSS dengan glass morphism effect
- **Icons**: Heroicons
- **Notifications**: SweetAlert2
- **AJAX**: Fetch API

## Activity Logging

Setiap aksi CRUD akan tercatat di tabel `activity_logs`:
- **Create**: Mencatat penambahan kelas baru
- **Update**: Mencatat perubahan data (old_values & new_values)
- **Delete**: Mencatat penghapusan kelas

## Cara Menggunakan

### Menambah Kelas Baru
1. Klik tombol "Tambah Kelas" di pojok kanan atas
2. Isi form dengan data kelas
3. Klik "Simpan"

### Mengedit Kelas
1. Klik icon pensil (Edit) pada baris kelas
2. Ubah data yang diperlukan
3. Klik "Update"

### Melihat Detail Kelas
1. Klik icon mata (Detail) pada baris kelas
2. Modal akan menampilkan informasi lengkap
3. Bisa langsung edit dari modal detail

### Menghapus Kelas
1. Klik icon tempat sampah (Hapus) pada baris kelas
2. Konfirmasi penghapusan
3. Kelas akan dihapus jika tidak ada siswa aktif

## Catatan Penting

- Setiap file partial maksimal 300-400 baris untuk maintainability
- Desain konsisten dengan halaman Guru yang sudah ada
- Menggunakan glass morphism effect untuk UI modern
- Responsive design untuk mobile, tablet, dan desktop
- Real-time validation dengan Alpine.js
- Activity logging untuk audit trail

## Seeder

Untuk menambahkan data sample kelas:

```bash
php artisan db:seed --class=KelasSeeder
```

Seeder akan membuat 9 kelas sample (3 kelas per tingkat) dengan wali kelas yang sudah ada di database.
