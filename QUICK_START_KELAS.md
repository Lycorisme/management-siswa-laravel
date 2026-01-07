# 🚀 Quick Start - Manajemen Kelas

## Langkah-langkah Testing

### 1. Persiapan Database (Opsional)

Jika ingin menambahkan data sample kelas:

```bash
php artisan db:seed --class=KelasSeeder
```

Ini akan membuat 9 kelas sample:
- 3 kelas tingkat X (IPA 1, IPA 2, IPS 1)
- 3 kelas tingkat XI (IPA 1, IPA 2, IPS 1)
- 3 kelas tingkat XII (IPA 1, IPA 2, IPS 1)

### 2. Akses Halaman

Buka browser dan akses:
```
http://localhost/kelas
```

atau sesuai dengan URL aplikasi Anda.

### 3. Fitur yang Bisa Dicoba

#### A. Lihat Statistik Dashboard
- Total Kelas Aktif
- Jumlah Kelas X, XI, XII
- Rata-rata Kapasitas

#### B. Filter Data
1. **Filter by Tingkat**: Pilih X, XI, atau XII
2. **Filter by Tahun Ajaran**: Pilih tahun ajaran
3. **Filter by Semester**: Pilih Ganjil atau Genap
4. Klik tombol "Filter"
5. Klik "Reset" untuk menghapus filter

#### C. Search
1. Ketik di search box: kode kelas, nama kelas, atau jurusan
2. Klik "Filter" atau tekan Enter

#### D. Tambah Kelas Baru
1. Klik tombol "Tambah Kelas" (pojok kanan atas)
2. Isi form:
   - **Kode Kelas**: Contoh: X-IPA-3
   - **Nama Kelas**: Contoh: X IPA 3
   - **Tingkat**: Pilih X, XI, atau XII
   - **Jurusan**: Contoh: IPA
   - **Wali Kelas**: Pilih dari dropdown guru
   - **Ruangan**: Contoh: R.104
   - **Kapasitas**: Contoh: 30
   - **Tahun Ajaran**: Contoh: 2025/2026
   - **Semester**: Pilih Ganjil atau Genap
   - **Status**: Pilih Aktif atau Nonaktif
3. Klik "Simpan"
4. Akan muncul notifikasi sukses dan halaman refresh

#### E. Lihat Detail Kelas
1. Klik icon mata (👁️) pada baris kelas
2. Modal akan menampilkan:
   - Informasi Dasar
   - Wali Kelas & Ruangan
   - Kapasitas & Status
   - Periode Akademik
3. Bisa langsung klik "Edit Kelas" dari modal detail

#### F. Edit Kelas
1. Klik icon pensil (✏️) pada baris kelas
2. Form akan terisi dengan data existing
3. Ubah data yang diperlukan
4. Klik "Update"

#### G. Hapus Kelas
1. Klik icon tempat sampah (🗑️) pada baris kelas
2. Konfirmasi penghapusan
3. **Note**: Kelas tidak bisa dihapus jika masih ada siswa aktif

### 4. Fitur Visual yang Perlu Diperhatikan

#### Progress Bar Kapasitas
- **Hijau**: < 75% terisi
- **Kuning**: 75-89% terisi
- **Merah**: ≥ 90% terisi

Contoh: 25/30 (83%) akan berwarna kuning

#### Badge Tingkat
- **Kelas X**: Badge hijau
- **Kelas XI**: Badge kuning
- **Kelas XII**: Badge merah

#### Status Badge
- **Aktif**: Badge hijau
- **Nonaktif**: Badge abu-abu

### 5. Testing Validasi

#### Test Validasi Create/Edit:
1. Coba submit form kosong → Error validation
2. Coba kode kelas yang sudah ada → Error "Kode kelas sudah digunakan"
3. Coba kapasitas > 50 → Error "Kapasitas maksimal 50"
4. Coba kapasitas < 1 → Error "Kapasitas minimal 1"

#### Test Validasi Delete:
1. Buat kelas baru tanpa siswa → Bisa dihapus
2. Coba hapus kelas yang ada siswanya → Error "Tidak dapat menghapus kelas karena masih memiliki X siswa aktif"

### 6. Responsive Testing

Test di berbagai ukuran layar:
- **Desktop**: Full layout dengan sidebar
- **Tablet**: Sidebar collapsible
- **Mobile**: Tabel scrollable horizontal

### 7. Check Activity Logs

Setelah melakukan CRUD operations, check tabel `activity_logs`:

```sql
SELECT * FROM activity_logs 
WHERE module = 'kelas' 
ORDER BY created_at DESC 
LIMIT 10;
```

Setiap aksi (create, update, delete) akan tercatat dengan:
- user_id (siapa yang melakukan)
- action (create/update/delete)
- description (deskripsi aksi)
- old_values & new_values (untuk update)
- ip_address & user_agent

### 8. Troubleshooting

#### Jika halaman tidak muncul:
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

#### Jika error 404:
- Pastikan sudah login
- Check route dengan: `php artisan route:list --name=kelas`

#### Jika dropdown Wali Kelas kosong:
- Pastikan ada user dengan role 'guru' di database
- Check dengan: `SELECT * FROM users WHERE role = 'guru'`

#### Jika error saat delete:
- Normal jika kelas masih punya siswa aktif
- Check dengan: `SELECT COUNT(*) FROM siswa WHERE kelas_id = X AND status = 'aktif'`

### 9. Expected Results

✅ **Halaman Load**: < 2 detik
✅ **Filter**: Instant response
✅ **Search**: Real-time filtering
✅ **Create**: Success notification + refresh
✅ **Update**: Success notification + refresh
✅ **Delete**: Success notification + refresh (jika valid)
✅ **Validation**: Error messages muncul
✅ **Responsive**: Berfungsi di semua device

### 10. Demo Data

Jika sudah run seeder, Anda akan punya:
- 9 kelas (3 per tingkat)
- Setiap kelas punya wali kelas
- Kapasitas bervariasi (26-32 siswa)
- Semua status aktif
- Tahun ajaran: 2025/2026
- Semester: Genap

## Tips Testing

1. **Test Filter Kombinasi**: Coba filter tingkat + semester
2. **Test Search**: Coba search dengan partial text
3. **Test Pagination**: Jika data > 10, test navigasi halaman
4. **Test Modal**: Coba buka-tutup modal berkali-kali
5. **Test Validation**: Coba berbagai input invalid
6. **Test Responsive**: Resize browser window
7. **Test Performance**: Buka Network tab di DevTools

## Success Indicators

✅ Semua statistik cards menampilkan angka yang benar
✅ Filter berfungsi dan mengupdate tabel
✅ Search berfungsi real-time
✅ Create kelas berhasil dan muncul di tabel
✅ Edit kelas berhasil dan data terupdate
✅ Detail modal menampilkan info lengkap
✅ Delete kelas berhasil (jika tidak ada siswa)
✅ Validation error muncul dengan jelas
✅ Progress bar kapasitas akurat
✅ Activity logs tercatat

## Next Actions

Setelah testing berhasil:
1. ✅ Integrate dengan halaman Data Siswa (link ke kelas)
2. ✅ Tambahkan export Excel untuk data kelas
3. ✅ Buat laporan kapasitas kelas
4. ✅ Tambahkan bulk operations
5. ✅ Implementasi notifications untuk wali kelas

---

**Happy Testing! 🎉**

Jika menemukan bug atau ada pertanyaan, check:
- `docs/MANAJEMEN_KELAS.md` untuk dokumentasi lengkap
- `MANAJEMEN_KELAS_SUMMARY.md` untuk overview implementasi
