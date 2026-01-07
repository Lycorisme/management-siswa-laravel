<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Indonesian locale
        
        // Get all active kelas
        $kelasList = Kelas::where('status', 'aktif')->get();
        
        if ($kelasList->isEmpty()) {
            $this->command->warn('No active classes found. Please run KelasSeeder first.');
            return;
        }

        $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
        $pekerjaanList = ['PNS', 'Wiraswasta', 'Karyawan Swasta', 'Guru', 'Dokter', 'Petani', 'Pedagang', 'Buruh', 'TNI/Polri', 'Tidak Bekerja'];

        // Generate 50 students
        for ($i = 0; $i < 50; $i++) {
            $jenisKelamin = $faker->randomElement(['L', 'P']);
            $kelas = $kelasList->random();
            $tahunMasuk = $faker->numberBetween(2022, 2024);

            Siswa::create([
                'nis' => '2024' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nisn' => $faker->unique()->numerify('##########'),
                'nama_lengkap' => $jenisKelamin === 'L' ? $faker->firstNameMale() . ' ' . $faker->lastName() : $faker->firstNameFemale() . ' ' . $faker->lastName(),
                'jenis_kelamin' => $jenisKelamin,
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-18 years', '-15 years')->format('Y-m-d'),
                'agama' => $faker->randomElement($agamaList),
                'alamat' => $faker->streetAddress(),
                'rt_rw' => str_pad($faker->numberBetween(1, 20), 3, '0', STR_PAD_LEFT) . '/' . str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'kelurahan' => $faker->citySuffix() . ' ' . $faker->lastName(),
                'kecamatan' => 'Kec. ' . $faker->city(),
                'kota' => $faker->city(),
                'provinsi' => $faker->state(),
                'kode_pos' => $faker->postcode(),
                'no_telepon' => '08' . $faker->numerify('#########'),
                'email' => $faker->unique()->safeEmail(),
                'nama_ayah' => $faker->firstNameMale() . ' ' . $faker->lastName(),
                'nama_ibu' => $faker->firstNameFemale() . ' ' . $faker->lastName(),
                'pekerjaan_ayah' => $faker->randomElement($pekerjaanList),
                'pekerjaan_ibu' => $faker->randomElement($pekerjaanList),
                'no_telepon_ortu' => '08' . $faker->numerify('#########'),
                'kelas_id' => $kelas->id,
                'foto' => null,
                'status' => 'aktif',
                'tahun_masuk' => $tahunMasuk,
                'tahun_keluar' => null,
                'total_poin_prestasi' => $faker->numberBetween(0, 50),
                'total_poin_pelanggaran' => $faker->numberBetween(0, 20),
            ]);
        }

        // Add some alumni students
        for ($i = 0; $i < 10; $i++) {
            $jenisKelamin = $faker->randomElement(['L', 'P']);

            Siswa::create([
                'nis' => '2021' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nisn' => $faker->unique()->numerify('##########'),
                'nama_lengkap' => $jenisKelamin === 'L' ? $faker->firstNameMale() . ' ' . $faker->lastName() : $faker->firstNameFemale() . ' ' . $faker->lastName(),
                'jenis_kelamin' => $jenisKelamin,
                'tempat_lahir' => $faker->city(),
                'tanggal_lahir' => $faker->dateTimeBetween('-21 years', '-18 years')->format('Y-m-d'),
                'agama' => $faker->randomElement($agamaList),
                'alamat' => $faker->streetAddress(),
                'rt_rw' => str_pad($faker->numberBetween(1, 20), 3, '0', STR_PAD_LEFT) . '/' . str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'kelurahan' => $faker->citySuffix() . ' ' . $faker->lastName(),
                'kecamatan' => 'Kec. ' . $faker->city(),
                'kota' => $faker->city(),
                'provinsi' => $faker->state(),
                'kode_pos' => $faker->postcode(),
                'no_telepon' => '08' . $faker->numerify('#########'),
                'email' => $faker->unique()->safeEmail(),
                'nama_ayah' => $faker->firstNameMale() . ' ' . $faker->lastName(),
                'nama_ibu' => $faker->firstNameFemale() . ' ' . $faker->lastName(),
                'pekerjaan_ayah' => $faker->randomElement($pekerjaanList),
                'pekerjaan_ibu' => $faker->randomElement($pekerjaanList),
                'no_telepon_ortu' => '08' . $faker->numerify('#########'),
                'kelas_id' => null, // Alumni tidak punya kelas aktif
                'foto' => null,
                'status' => 'alumni',
                'tahun_masuk' => 2021,
                'tahun_keluar' => 2024,
                'total_poin_prestasi' => $faker->numberBetween(20, 100),
                'total_poin_pelanggaran' => $faker->numberBetween(0, 30),
            ]);
        }

        $this->command->info('Successfully seeded 60 students (50 active + 10 alumni)');
    }
}
