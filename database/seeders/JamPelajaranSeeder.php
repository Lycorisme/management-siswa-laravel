<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JamPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data jam pelajaran standar
     */
    public function run(): void
    {
        $jamPelajaran = [
            ['sesi' => 0, 'jam_mulai' => '06:30:00', 'jam_selesai' => '07:00:00', 'keterangan' => 'Upacara/Apel Pagi', 'jenis' => 'upacara'],
            ['sesi' => 1, 'jam_mulai' => '07:00:00', 'jam_selesai' => '07:45:00', 'keterangan' => 'Jam ke-1', 'jenis' => 'normal'],
            ['sesi' => 2, 'jam_mulai' => '07:45:00', 'jam_selesai' => '08:30:00', 'keterangan' => 'Jam ke-2', 'jenis' => 'normal'],
            ['sesi' => 3, 'jam_mulai' => '08:30:00', 'jam_selesai' => '09:15:00', 'keterangan' => 'Jam ke-3', 'jenis' => 'normal'],
            ['sesi' => 4, 'jam_mulai' => '09:15:00', 'jam_selesai' => '09:30:00', 'keterangan' => 'Istirahat 1', 'jenis' => 'istirahat'],
            ['sesi' => 5, 'jam_mulai' => '09:30:00', 'jam_selesai' => '10:15:00', 'keterangan' => 'Jam ke-4', 'jenis' => 'normal'],
            ['sesi' => 6, 'jam_mulai' => '10:15:00', 'jam_selesai' => '11:00:00', 'keterangan' => 'Jam ke-5', 'jenis' => 'normal'],
            ['sesi' => 7, 'jam_mulai' => '11:00:00', 'jam_selesai' => '11:45:00', 'keterangan' => 'Jam ke-6', 'jenis' => 'normal'],
            ['sesi' => 8, 'jam_mulai' => '11:45:00', 'jam_selesai' => '12:30:00', 'keterangan' => 'Istirahat 2 / Sholat', 'jenis' => 'istirahat'],
            ['sesi' => 9, 'jam_mulai' => '12:30:00', 'jam_selesai' => '13:15:00', 'keterangan' => 'Jam ke-7', 'jenis' => 'normal'],
            ['sesi' => 10, 'jam_mulai' => '13:15:00', 'jam_selesai' => '14:00:00', 'keterangan' => 'Jam ke-8', 'jenis' => 'normal'],
            ['sesi' => 11, 'jam_mulai' => '14:00:00', 'jam_selesai' => '14:45:00', 'keterangan' => 'Jam ke-9', 'jenis' => 'normal'],
            ['sesi' => 12, 'jam_mulai' => '14:45:00', 'jam_selesai' => '15:30:00', 'keterangan' => 'Jam ke-10', 'jenis' => 'normal'],
        ];

        foreach ($jamPelajaran as $jam) {
            DB::table('jam_pelajaran')->insert([
                'sesi' => $jam['sesi'],
                'jam_mulai' => $jam['jam_mulai'],
                'jam_selesai' => $jam['jam_selesai'],
                'keterangan' => $jam['keterangan'],
                'jenis' => $jam['jenis'],
                'hari' => 'semua',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
