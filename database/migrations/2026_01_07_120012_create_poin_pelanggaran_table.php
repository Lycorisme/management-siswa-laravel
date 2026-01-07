<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel poin_pelanggaran untuk mengelola pelanggaran siswa
     */
    public function up(): void
    {
        Schema::create('poin_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('jenis_pelanggaran', ['ringan', 'sedang', 'berat']);
            $table->string('nama_pelanggaran', 200);
            $table->text('deskripsi')->nullable();
            $table->integer('poin')->default(0);
            $table->text('sanksi')->nullable();
            $table->enum('status', ['pending', 'ditindak', 'selesai'])->default('pending');
            $table->foreignId('ditindak_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->text('tindakan')->nullable();
            $table->date('tanggal_tindakan')->nullable();
            $table->text('follow_up')->nullable();
            $table->foreignId('follow_up_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('file_bukti', 255)->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('siswa_id', 'idx_poin_pelanggaran_siswa');
            $table->index('tanggal', 'idx_poin_pelanggaran_tanggal');
            $table->index('status', 'idx_poin_pelanggaran_status');
            $table->index('jenis_pelanggaran', 'idx_poin_pelanggaran_jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_pelanggaran');
    }
};
