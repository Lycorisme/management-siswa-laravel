<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel semester untuk mengelola periode semester
     */
    public function up(): void
    {
        Schema::create('semester', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'selesai', 'akan_datang'])->default('akan_datang');
            $table->timestamps();
            
            // Index
            $table->index('status', 'idx_semester_status');
            
            // Unique constraint untuk kombinasi tahun_ajaran dan semester
            $table->unique(['tahun_ajaran_id', 'semester'], 'unique_tahun_semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester');
    }
};
