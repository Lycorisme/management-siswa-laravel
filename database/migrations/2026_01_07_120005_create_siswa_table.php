<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel siswa untuk mengelola data siswa
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            
            // Data identitas
            $table->string('nis', 20)->unique();
            $table->string('nisn', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            
            // Data lahir
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            
            // Data alamat
            $table->text('alamat')->nullable();
            $table->string('rt_rw', 10)->nullable();
            $table->string('kelurahan', 50)->nullable();
            $table->string('kecamatan', 50)->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('provinsi', 50)->nullable();
            $table->string('kode_pos', 10)->nullable();
            
            // Data kontak
            $table->string('no_telepon', 15)->nullable();
            $table->string('email', 100)->nullable();
            
            // Data orang tua
            $table->string('nama_ayah', 100)->nullable();
            $table->string('nama_ibu', 100)->nullable();
            $table->string('pekerjaan_ayah', 100)->nullable();
            $table->string('pekerjaan_ibu', 100)->nullable();
            $table->string('no_telepon_ortu', 15)->nullable();
            
            // Data akademik
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->string('foto', 255)->nullable();
            $table->enum('status', ['aktif', 'alumni', 'pindah', 'keluar', 'dropout'])->default('aktif');
            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_keluar')->nullable();
            
            // Data poin
            $table->integer('total_poin_prestasi')->default(0);
            $table->integer('total_poin_pelanggaran')->default(0);
            
            $table->timestamps();
            
            // Indexes untuk performansi
            $table->index('kelas_id', 'idx_siswa_kelas');
            $table->index('status', 'idx_siswa_status');
            $table->index('tahun_masuk', 'idx_siswa_tahun_masuk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
