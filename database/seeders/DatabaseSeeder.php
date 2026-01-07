<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Urutan seeder penting karena ada dependensi antar tabel
     */
    public function run(): void
    {
        $this->call([
            // 1. Users harus pertama karena banyak tabel yang reference ke users
            UsersSeeder::class,
            
            // 2. Tahun Ajaran dan Semester
            TahunAjaranSeeder::class,
            
            // 3. Kelas (references users untuk wali_kelas)
            KelasSeeder::class,
            
            // 4. Jam Pelajaran (tidak ada dependency)
            JamPelajaranSeeder::class,
            
            // 5. Mata Pelajaran (references users dan kelas)
            MataPelajaranSeeder::class,
            
            // 6. Kategori Poin
            PoinKategoriSeeder::class,
            
            // 7. Settings
            SettingsSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Default Login Credentials:');
        $this->command->info('   Admin: admin / password');
        $this->command->info('   Guru:  guru1 / password');
        $this->command->info('');
    }
}
