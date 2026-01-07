<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Membuat user admin dan beberapa guru sebagai data awal
     */
    public function run(): void
    {
        // Admin utama
        DB::table('users')->insert([
            'username' => 'admin',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'jenis_kelamin' => 'L',
            'nip' => '1234567890',
            'role' => 'admin',
            'jabatan' => 'Administrator Sistem',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Guru 1
        DB::table('users')->insert([
            'username' => 'guru1',
            'nama_lengkap' => 'Budi Santoso, S.Pd',
            'email' => 'budi@sekolah.sch.id',
            'password' => Hash::make('password'),
            'jenis_kelamin' => 'L',
            'nip' => '1987090120102001',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1987-09-01',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'no_telepon' => '081234567890',
            'role' => 'guru',
            'jabatan' => 'Guru Mata Pelajaran',
            'bidang_studi' => 'Matematika',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Guru 2
        DB::table('users')->insert([
            'username' => 'guru2',
            'nama_lengkap' => 'Siti Rahayu, S.Pd',
            'email' => 'siti@sekolah.sch.id',
            'password' => Hash::make('password'),
            'jenis_kelamin' => 'P',
            'nip' => '1990050520152001',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '1990-05-05',
            'alamat' => 'Jl. Asia Afrika No. 25, Bandung',
            'no_telepon' => '081234567891',
            'role' => 'guru',
            'jabatan' => 'Guru Mata Pelajaran',
            'bidang_studi' => 'Bahasa Indonesia',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Guru 3
        DB::table('users')->insert([
            'username' => 'guru3',
            'nama_lengkap' => 'Ahmad Fauzi, S.Kom',
            'email' => 'ahmad@sekolah.sch.id',
            'password' => Hash::make('password'),
            'jenis_kelamin' => 'L',
            'nip' => '1988121220182001',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1988-12-12',
            'alamat' => 'Jl. Pemuda No. 50, Surabaya',
            'no_telepon' => '081234567892',
            'role' => 'guru',
            'jabatan' => 'Guru Mata Pelajaran',
            'bidang_studi' => 'Informatika',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
