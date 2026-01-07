<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat data settings awal aplikasi
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'setting_key' => 'app_name',
                'setting_value' => 'SIMSISWA - Sistem Informasi Management Siswa',
                'setting_type' => 'text',
                'setting_group' => 'general',
                'label' => 'Nama Aplikasi',
                'description' => 'Nama aplikasi yang ditampilkan di header',
                'is_public' => true,
            ],
            [
                'setting_key' => 'app_logo',
                'setting_value' => null,
                'setting_type' => 'text',
                'setting_group' => 'general',
                'label' => 'Logo Aplikasi',
                'description' => 'Path ke file logo aplikasi',
                'is_public' => true,
            ],
            [
                'setting_key' => 'app_favicon',
                'setting_value' => null,
                'setting_type' => 'text',
                'setting_group' => 'general',
                'label' => 'Favicon',
                'description' => 'Path ke file favicon',
                'is_public' => true,
            ],
            
            // School Settings
            [
                'setting_key' => 'school_name',
                'setting_value' => 'SMA Negeri 1 Contoh',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'Nama Sekolah',
                'description' => 'Nama resmi sekolah',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_address',
                'setting_value' => 'Jl. Pendidikan No. 1, Kota Contoh',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'Alamat Sekolah',
                'description' => 'Alamat lengkap sekolah',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_phone',
                'setting_value' => '(021) 1234567',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'Telepon Sekolah',
                'description' => 'Nomor telepon sekolah',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_email',
                'setting_value' => 'info@sekolah.sch.id',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'Email Sekolah',
                'description' => 'Email resmi sekolah',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_website',
                'setting_value' => 'https://sekolah.sch.id',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'Website Sekolah',
                'description' => 'URL website sekolah',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_npsn',
                'setting_value' => '12345678',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'NPSN',
                'description' => 'Nomor Pokok Sekolah Nasional',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_principal',
                'setting_value' => 'Dr. H. Kepala Sekolah, M.Pd',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'Kepala Sekolah',
                'description' => 'Nama Kepala Sekolah',
                'is_public' => true,
            ],
            [
                'setting_key' => 'school_principal_nip',
                'setting_value' => '196501011990011001',
                'setting_type' => 'text',
                'setting_group' => 'school',
                'label' => 'NIP Kepala Sekolah',
                'description' => 'NIP Kepala Sekolah',
                'is_public' => false,
            ],
            
            // Attendance Settings
            [
                'setting_key' => 'attendance_late_tolerance',
                'setting_value' => '15',
                'setting_type' => 'number',
                'setting_group' => 'attendance',
                'label' => 'Toleransi Keterlambatan (menit)',
                'description' => 'Batas waktu toleransi keterlambatan dalam menit',
                'is_public' => false,
            ],
            [
                'setting_key' => 'attendance_start_time',
                'setting_value' => '07:00',
                'setting_type' => 'time',
                'setting_group' => 'attendance',
                'label' => 'Jam Masuk',
                'description' => 'Jam mulai pelajaran',
                'is_public' => false,
            ],
            [
                'setting_key' => 'attendance_end_time',
                'setting_value' => '15:30',
                'setting_type' => 'time',
                'setting_group' => 'attendance',
                'label' => 'Jam Pulang',
                'description' => 'Jam selesai pelajaran',
                'is_public' => false,
            ],
            
            // Academic Settings
            [
                'setting_key' => 'current_tahun_ajaran',
                'setting_value' => '2025/2026',
                'setting_type' => 'text',
                'setting_group' => 'academic',
                'label' => 'Tahun Ajaran Aktif',
                'description' => 'Tahun ajaran yang sedang berjalan',
                'is_public' => true,
            ],
            [
                'setting_key' => 'current_semester',
                'setting_value' => 'ganjil',
                'setting_type' => 'text',
                'setting_group' => 'academic',
                'label' => 'Semester Aktif',
                'description' => 'Semester yang sedang berjalan',
                'is_public' => true,
            ],
            
            // Points Settings
            [
                'setting_key' => 'points_warning_threshold',
                'setting_value' => '50',
                'setting_type' => 'number',
                'setting_group' => 'points',
                'label' => 'Batas Peringatan Poin Pelanggaran',
                'description' => 'Jumlah poin pelanggaran untuk trigger peringatan',
                'is_public' => false,
            ],
            [
                'setting_key' => 'points_sp1_threshold',
                'setting_value' => '75',
                'setting_type' => 'number',
                'setting_group' => 'points',
                'label' => 'Batas SP1',
                'description' => 'Jumlah poin untuk Surat Peringatan 1',
                'is_public' => false,
            ],
            [
                'setting_key' => 'points_sp2_threshold',
                'setting_value' => '100',
                'setting_type' => 'number',
                'setting_group' => 'points',
                'label' => 'Batas SP2',
                'description' => 'Jumlah poin untuk Surat Peringatan 2',
                'is_public' => false,
            ],
            [
                'setting_key' => 'points_sp3_threshold',
                'setting_value' => '125',
                'setting_type' => 'number',
                'setting_group' => 'points',
                'label' => 'Batas SP3',
                'description' => 'Jumlah poin untuk Surat Peringatan 3',
                'is_public' => false,
            ],
            [
                'setting_key' => 'points_dropout_threshold',
                'setting_value' => '150',
                'setting_type' => 'number',
                'setting_group' => 'points',
                'label' => 'Batas Dikeluarkan',
                'description' => 'Jumlah poin untuk dikembalikan ke orang tua',
                'is_public' => false,
            ],
            
            // System Settings
            [
                'setting_key' => 'pagination_limit',
                'setting_value' => '25',
                'setting_type' => 'number',
                'setting_group' => 'system',
                'label' => 'Jumlah Data Per Halaman',
                'description' => 'Jumlah data yang ditampilkan per halaman',
                'is_public' => false,
            ],
            [
                'setting_key' => 'upload_max_size',
                'setting_value' => '2048',
                'setting_type' => 'number',
                'setting_group' => 'system',
                'label' => 'Ukuran Upload Maksimal (KB)',
                'description' => 'Ukuran maksimal file yang bisa diupload',
                'is_public' => false,
            ],
            [
                'setting_key' => 'session_lifetime',
                'setting_value' => '120',
                'setting_type' => 'number',
                'setting_group' => 'system',
                'label' => 'Session Lifetime (menit)',
                'description' => 'Durasi session sebelum expired',
                'is_public' => false,
            ],
            [
                'setting_key' => 'maintenance_mode',
                'setting_value' => 'false',
                'setting_type' => 'boolean',
                'setting_group' => 'system',
                'label' => 'Mode Maintenance',
                'description' => 'Aktifkan mode maintenance untuk menonaktifkan akses sementara',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
