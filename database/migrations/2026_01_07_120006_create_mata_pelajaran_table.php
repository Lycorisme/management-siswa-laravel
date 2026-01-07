<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel mata_pelajaran untuk mengelola data mata pelajaran
     */
    public function up(): void
    {
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mapel', 10)->unique();
            $table->string('nama_mapel', 100);
            $table->enum('kategori', ['umum', 'jurusan', 'peminatan', 'ekstrakurikuler'])->default('umum');
            $table->enum('tingkat', ['X', 'XI', 'XII', 'semua'])->default('semua');
            $table->string('jurusan', 50)->nullable();
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('cascade');
            $table->enum('semester', ['ganjil', 'genap', 'tahunan'])->default('tahunan');
            $table->string('tahun_ajaran', 9)->nullable();
            $table->integer('jam_per_minggu')->default(2);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index('kategori', 'idx_mapel_kategori');
            $table->index('tingkat', 'idx_mapel_tingkat');
            $table->index('guru_id', 'idx_mapel_guru');
            $table->index('status', 'idx_mapel_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
