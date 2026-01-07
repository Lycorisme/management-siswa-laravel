<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel poin_kategori untuk mengelola kategori poin
     */
    public function up(): void
    {
        Schema::create('poin_kategori', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis', ['prestasi', 'pelanggaran']);
            $table->string('kode', 10)->unique();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('poin_min')->default(0);
            $table->integer('poin_max')->default(0);
            $table->string('warna', 7)->nullable()->comment('HEX color code');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes
            $table->index('jenis', 'idx_poin_kategori_jenis');
            $table->index('status', 'idx_poin_kategori_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_kategori');
    }
};
