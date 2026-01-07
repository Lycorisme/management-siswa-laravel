---
description: Setup fresh database dengan migration dan seeder
---
# Database Setup Workflow

## Fresh Database Setup

// turbo-all

1. Drop semua tabel dan jalankan ulang semua migration dengan seeder:
```bash
php artisan migrate:fresh --seed
```

2. Jika hanya ingin jalankan migration tanpa seeder:
```bash
php artisan migrate:fresh
```

3. Jika ingin jalankan seeder saja (database sudah ada):
```bash
php artisan db:seed
```

## Login Credentials Default

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | password |
| Guru | guru1 | password |
| Guru | guru2 | password |
| Guru | guru3 | password |

## Struktur Tabel Database

1. **users** - Data admin dan guru
2. **tahun_ajaran** - Data tahun ajaran
3. **semester** - Data semester per tahun ajaran
4. **kelas** - Data kelas
5. **siswa** - Data siswa
6. **mata_pelajaran** - Data mata pelajaran
7. **jam_pelajaran** - Data jam pelajaran (sesi)
8. **jadwal_kelas** - Jadwal pelajaran per kelas
9. **absensi** - Data absensi siswa
10. **poin_kategori** - Kategori poin prestasi/pelanggaran
11. **poin_prestasi** - Data prestasi siswa
12. **poin_pelanggaran** - Data pelanggaran siswa
13. **aktivitas_siswa** - Log aktivitas siswa
14. **settings** - Pengaturan aplikasi
15. **activity_logs** - Log aktivitas user
16. **notifications** - Notifikasi user
