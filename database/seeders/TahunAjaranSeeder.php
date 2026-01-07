<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data tahun ajaran dan semester
     */
    public function run(): void
    {
        // Tahun Ajaran 2024/2025
        $tahunAjaran1 = DB::table('tahun_ajaran')->insertGetId([
            'nama' => '2024/2025',
            'tanggal_mulai' => '2024-07-15',
            'tanggal_selesai' => '2025-06-30',
            'status' => 'selesai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tahun Ajaran 2025/2026
        $tahunAjaran2 = DB::table('tahun_ajaran')->insertGetId([
            'nama' => '2025/2026',
            'tanggal_mulai' => '2025-07-14',
            'tanggal_selesai' => '2026-06-30',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Semester untuk Tahun Ajaran 2024/2025
        DB::table('semester')->insert([
            [
                'tahun_ajaran_id' => $tahunAjaran1,
                'semester' => 'ganjil',
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
                'status' => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran_id' => $tahunAjaran1,
                'semester' => 'genap',
                'tanggal_mulai' => '2025-01-06',
                'tanggal_selesai' => '2025-06-30',
                'status' => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Semester untuk Tahun Ajaran 2025/2026
        DB::table('semester')->insert([
            [
                'tahun_ajaran_id' => $tahunAjaran2,
                'semester' => 'ganjil',
                'tanggal_mulai' => '2025-07-14',
                'tanggal_selesai' => '2025-12-19',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'tahun_ajaran_id' => $tahunAjaran2,
                'semester' => 'genap',
                'tanggal_mulai' => '2026-01-05',
                'tanggal_selesai' => '2026-06-30',
                'status' => 'akan_datang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
