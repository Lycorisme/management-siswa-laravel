<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data kelas untuk semua tingkat dan jurusan
     */
    public function run(): void
    {
        $jurusan = ['IPA', 'IPS', 'Bahasa'];
        $tingkat = ['X', 'XI', 'XII'];
        
        foreach ($tingkat as $t) {
            foreach ($jurusan as $index => $j) {
                // 2 kelas per jurusan
                for ($i = 1; $i <= 2; $i++) {
                    DB::table('kelas')->insert([
                        'kode_kelas' => $t . '-' . substr($j, 0, 3) . '-' . $i,
                        'nama_kelas' => $t . ' ' . $j . ' ' . $i,
                        'tingkat' => $t,
                        'jurusan' => $j,
                        'wali_kelas_id' => null, // Akan diassign kemudian
                        'kapasitas' => 36,
                        'ruangan' => 'R.' . ($tingkat == 'X' ? '1' : ($tingkat == 'XI' ? '2' : '3')) . (($index * 2) + $i),
                        'tahun_ajaran' => '2025/2026',
                        'semester' => 'ganjil',
                        'status' => 'aktif',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
