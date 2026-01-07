<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data mata pelajaran
     */
    public function run(): void
    {
        $mataPelajaran = [
            // Mata Pelajaran Umum
            ['kode' => 'MTK', 'nama' => 'Matematika', 'kategori' => 'umum', 'jam' => 4],
            ['kode' => 'BIN', 'nama' => 'Bahasa Indonesia', 'kategori' => 'umum', 'jam' => 4],
            ['kode' => 'BIG', 'nama' => 'Bahasa Inggris', 'kategori' => 'umum', 'jam' => 3],
            ['kode' => 'PKN', 'nama' => 'Pendidikan Kewarganegaraan', 'kategori' => 'umum', 'jam' => 2],
            ['kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'kategori' => 'umum', 'jam' => 3],
            ['kode' => 'PJJ', 'nama' => 'Penjaskes', 'kategori' => 'umum', 'jam' => 3],
            ['kode' => 'SNI', 'nama' => 'Seni Budaya', 'kategori' => 'umum', 'jam' => 2],
            ['kode' => 'SEJ', 'nama' => 'Sejarah Indonesia', 'kategori' => 'umum', 'jam' => 2],
            
            // Mata Pelajaran Jurusan IPA
            ['kode' => 'FIS', 'nama' => 'Fisika', 'kategori' => 'jurusan', 'jam' => 4],
            ['kode' => 'KIM', 'nama' => 'Kimia', 'kategori' => 'jurusan', 'jam' => 4],
            ['kode' => 'BIO', 'nama' => 'Biologi', 'kategori' => 'jurusan', 'jam' => 4],
            
            // Mata Pelajaran Jurusan IPS
            ['kode' => 'EKO', 'nama' => 'Ekonomi', 'kategori' => 'jurusan', 'jam' => 4],
            ['kode' => 'GEO', 'nama' => 'Geografi', 'kategori' => 'jurusan', 'jam' => 3],
            ['kode' => 'SOS', 'nama' => 'Sosiologi', 'kategori' => 'jurusan', 'jam' => 3],
            
            // Mata Pelajaran Peminatan
            ['kode' => 'INF', 'nama' => 'Informatika', 'kategori' => 'peminatan', 'jam' => 3],
            ['kode' => 'BJP', 'nama' => 'Bahasa Jepang', 'kategori' => 'peminatan', 'jam' => 2],
            ['kode' => 'BMN', 'nama' => 'Bahasa Mandarin', 'kategori' => 'peminatan', 'jam' => 2],
            
            // Ekstrakurikuler
            ['kode' => 'PMR', 'nama' => 'Palang Merah Remaja', 'kategori' => 'ekstrakurikuler', 'jam' => 2],
            ['kode' => 'PRK', 'nama' => 'Pramuka', 'kategori' => 'ekstrakurikuler', 'jam' => 2],
            ['kode' => 'PAS', 'nama' => 'Paskibra', 'kategori' => 'ekstrakurikuler', 'jam' => 2],
        ];

        foreach ($mataPelajaran as $mapel) {
            DB::table('mata_pelajaran')->insert([
                'kode_mapel' => $mapel['kode'],
                'nama_mapel' => $mapel['nama'],
                'kategori' => $mapel['kategori'],
                'tingkat' => 'semua',
                'jurusan' => null,
                'guru_id' => null,
                'kelas_id' => null,
                'semester' => 'tahunan',
                'tahun_ajaran' => '2025/2026',
                'jam_per_minggu' => $mapel['jam'],
                'deskripsi' => 'Mata pelajaran ' . $mapel['nama'],
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
