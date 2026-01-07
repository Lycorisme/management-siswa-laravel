<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel jadwal_kelas untuk mengelola jadwal pelajaran per kelas
     */
    public function up(): void
    {
        Schema::create('jadwal_kelas', function (Blueprint $table) {
            $table->id();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
            $table->integer('sesi');
            $table->foreignId('mapel_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->string('ruangan', 20)->nullable();
            $table->string('tahun_ajaran', 9)->nullable();
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index('hari', 'idx_jadwal_kelas_hari');
            $table->index('kelas_id', 'idx_jadwal_kelas_kelas');
            $table->index('guru_id', 'idx_jadwal_kelas_guru');
            $table->index('mapel_id', 'idx_jadwal_kelas_mapel');
            $table->index('status', 'idx_jadwal_kelas_status');
            
            // Unique constraint untuk mencegah jadwal bentrok
            $table->unique(['hari', 'sesi', 'kelas_id', 'tahun_ajaran', 'semester'], 'unique_jadwal_kelas');
            $table->unique(['hari', 'sesi', 'guru_id', 'tahun_ajaran', 'semester'], 'unique_jadwal_guru');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kelas');
    }
};
