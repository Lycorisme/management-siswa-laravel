<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel poin_prestasi untuk mengelola prestasi siswa
     */
    public function up(): void
    {
        Schema::create('poin_prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->date('tanggal');
            $table->enum('jenis_prestasi', ['akademik', 'non-akademik', 'sosial', 'olahraga', 'seni', 'lainnya']);
            $table->enum('kategori', ['prestasi', 'penghargaan', 'lomba', 'kejuaraan'])->default('prestasi');
            $table->string('nama_prestasi', 200);
            $table->text('deskripsi')->nullable();
            $table->enum('tingkat', ['sekolah', 'kecamatan', 'kabupaten', 'provinsi', 'nasional', 'internasional'])->default('sekolah');
            $table->enum('peringkat', ['juara_1', 'juara_2', 'juara_3', 'harapan', 'partisipasi'])->default('partisipasi');
            $table->integer('poin')->default(0);
            $table->string('penyelenggara', 200)->nullable();
            $table->string('tempat', 200)->nullable();
            $table->string('file_bukti', 255)->nullable();
            $table->string('file_sertifikat', 255)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('siswa_id', 'idx_poin_prestasi_siswa');
            $table->index('tanggal', 'idx_poin_prestasi_tanggal');
            $table->index('status', 'idx_poin_prestasi_status');
            $table->index('jenis_prestasi', 'idx_poin_prestasi_jenis');
            $table->index('tingkat', 'idx_poin_prestasi_tingkat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poin_prestasi');
    }
};
