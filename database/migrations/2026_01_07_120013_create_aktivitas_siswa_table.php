<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel aktivitas_siswa untuk tracking perubahan data siswa
     */
    public function up(): void
    {
        Schema::create('aktivitas_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->enum('jenis_aktivitas', ['absensi', 'prestasi', 'pelanggaran', 'perubahan_data', 'lainnya']);
            $table->text('deskripsi')->nullable();
            $table->json('data_lama')->nullable()->comment('Data sebelum perubahan');
            $table->json('data_baru')->nullable()->comment('Data sesudah perubahan');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Indexes
            $table->index('siswa_id', 'idx_aktivitas_siswa');
            $table->index('jenis_aktivitas', 'idx_aktivitas_jenis');
            $table->index('created_at', 'idx_aktivitas_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivitas_siswa');
    }
};
