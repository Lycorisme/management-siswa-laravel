<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        // Get some guru IDs for wali kelas
        $guruIds = DB::table('users')->where('role', 'guru')->pluck('id')->toArray();
        
        $kelas = [
            // Kelas X
            [
                'kode_kelas' => 'X-IPA-1',
                'nama_kelas' => 'X IPA 1',
                'tingkat' => 'X',
                'jurusan' => 'IPA',
                'wali_kelas_id' => $guruIds[0] ?? null,
                'kapasitas' => 32,
                'ruangan' => 'R.101',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode_kelas' => 'X-IPA-2',
                'nama_kelas' => 'X IPA 2',
                'tingkat' => 'X',
                'jurusan' => 'IPA',
                'wali_kelas_id' => $guruIds[1] ?? null,
                'kapasitas' => 32,
                'ruangan' => 'R.102',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode_kelas' => 'X-IPS-1',
                'nama_kelas' => 'X IPS 1',
                'tingkat' => 'X',
                'jurusan' => 'IPS',
                'wali_kelas_id' => $guruIds[2] ?? null,
                'kapasitas' => 30,
                'ruangan' => 'R.103',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Kelas XI
            [
                'kode_kelas' => 'XI-IPA-1',
                'nama_kelas' => 'XI IPA 1',
                'tingkat' => 'XI',
                'jurusan' => 'IPA',
                'wali_kelas_id' => $guruIds[3] ?? null,
                'kapasitas' => 30,
                'ruangan' => 'R.201',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode_kelas' => 'XI-IPA-2',
                'nama_kelas' => 'XI IPA 2',
                'tingkat' => 'XI',
                'jurusan' => 'IPA',
                'wali_kelas_id' => $guruIds[4] ?? null,
                'kapasitas' => 30,
                'ruangan' => 'R.202',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode_kelas' => 'XI-IPS-1',
                'nama_kelas' => 'XI IPS 1',
                'tingkat' => 'XI',
                'jurusan' => 'IPS',
                'wali_kelas_id' => $guruIds[5] ?? null,
                'kapasitas' => 28,
                'ruangan' => 'R.203',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            // Kelas XII
            [
                'kode_kelas' => 'XII-IPA-1',
                'nama_kelas' => 'XII IPA 1',
                'tingkat' => 'XII',
                'jurusan' => 'IPA',
                'wali_kelas_id' => $guruIds[6] ?? null,
                'kapasitas' => 28,
                'ruangan' => 'R.301',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode_kelas' => 'XII-IPA-2',
                'nama_kelas' => 'XII IPA 2',
                'tingkat' => 'XII',
                'jurusan' => 'IPA',
                'wali_kelas_id' => $guruIds[7] ?? null,
                'kapasitas' => 28,
                'ruangan' => 'R.302',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kode_kelas' => 'XII-IPS-1',
                'nama_kelas' => 'XII IPS 1',
                'tingkat' => 'XII',
                'jurusan' => 'IPS',
                'wali_kelas_id' => $guruIds[8] ?? null,
                'kapasitas' => 26,
                'ruangan' => 'R.303',
                'tahun_ajaran' => '2025/2026',
                'semester' => 'genap',
                'status' => 'aktif',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('kelas')->insert($kelas);
        
        $this->command->info('✓ Berhasil menambahkan ' . count($kelas) . ' data kelas');
    }
}
