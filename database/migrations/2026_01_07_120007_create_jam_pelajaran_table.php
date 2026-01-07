<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel jam_pelajaran untuk mengelola sesi jam pelajaran
     */
    public function up(): void
    {
        Schema::create('jam_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->integer('sesi');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('keterangan', 50)->nullable();
            $table->enum('jenis', ['normal', 'istirahat', 'upacara', 'khusus'])->default('normal');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu', 'semua'])->default('semua');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index('jenis', 'idx_jam_jenis');
            $table->index('hari', 'idx_jam_hari');
            $table->index('status', 'idx_jam_status');
            
            // Unique constraint untuk sesi per hari
            $table->unique(['sesi', 'hari'], 'unique_sesi_hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jam_pelajaran');
    }
};
