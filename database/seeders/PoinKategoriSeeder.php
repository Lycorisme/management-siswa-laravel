<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoinKategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data kategori poin prestasi dan pelanggaran
     */
    public function run(): void
    {
        // Kategori Prestasi
        $prestasi = [
            ['kode' => 'P-AKD', 'nama' => 'Prestasi Akademik', 'poin_min' => 5, 'poin_max' => 100, 'warna' => '#28a745'],
            ['kode' => 'P-NON', 'nama' => 'Prestasi Non-Akademik', 'poin_min' => 5, 'poin_max' => 100, 'warna' => '#17a2b8'],
            ['kode' => 'P-OLR', 'nama' => 'Prestasi Olahraga', 'poin_min' => 5, 'poin_max' => 100, 'warna' => '#6f42c1'],
            ['kode' => 'P-SNI', 'nama' => 'Prestasi Seni', 'poin_min' => 5, 'poin_max' => 100, 'warna' => '#e83e8c'],
            ['kode' => 'P-SOS', 'nama' => 'Prestasi Sosial', 'poin_min' => 5, 'poin_max' => 50, 'warna' => '#fd7e14'],
        ];

        foreach ($prestasi as $p) {
            DB::table('poin_kategori')->insert([
                'jenis' => 'prestasi',
                'kode' => $p['kode'],
                'nama' => $p['nama'],
                'deskripsi' => 'Kategori ' . $p['nama'],
                'poin_min' => $p['poin_min'],
                'poin_max' => $p['poin_max'],
                'warna' => $p['warna'],
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Kategori Pelanggaran
        $pelanggaran = [
            ['kode' => 'V-RNG', 'nama' => 'Pelanggaran Ringan', 'poin_min' => 1, 'poin_max' => 10, 'warna' => '#ffc107'],
            ['kode' => 'V-SDG', 'nama' => 'Pelanggaran Sedang', 'poin_min' => 11, 'poin_max' => 25, 'warna' => '#fd7e14'],
            ['kode' => 'V-BRT', 'nama' => 'Pelanggaran Berat', 'poin_min' => 26, 'poin_max' => 100, 'warna' => '#dc3545'],
        ];

        foreach ($pelanggaran as $v) {
            DB::table('poin_kategori')->insert([
                'jenis' => 'pelanggaran',
                'kode' => $v['kode'],
                'nama' => $v['nama'],
                'deskripsi' => 'Kategori ' . $v['nama'],
                'poin_min' => $v['poin_min'],
                'poin_max' => $v['poin_max'],
                'warna' => $v['warna'],
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
