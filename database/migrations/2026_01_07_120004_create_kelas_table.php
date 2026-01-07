<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel kelas untuk mengelola data kelas
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kelas', 10)->unique();
            $table->string('nama_kelas', 50);
            $table->enum('tingkat', ['X', 'XI', 'XII']);
            $table->string('jurusan', 50)->nullable();
            $table->foreignId('wali_kelas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('kapasitas')->default(30);
            $table->string('ruangan', 20)->nullable();
            $table->string('tahun_ajaran', 9)->nullable()->comment('Format: 2024/2025');
            $table->enum('semester', ['ganjil', 'genap'])->default('ganjil');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index('tingkat', 'idx_kelas_tingkat');
            $table->index('status', 'idx_kelas_status');
            $table->index('tahun_ajaran', 'idx_kelas_tahun_ajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
