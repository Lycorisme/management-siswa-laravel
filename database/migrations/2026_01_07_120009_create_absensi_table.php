<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel absensi untuk mengelola data kehadiran siswa
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
            $table->foreignId('mapel_id')->nullable()->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal');
            $table->integer('sesi')->nullable();
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alfa', 'terlambat', 'dinas', 'cuti'])->default('hadir');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('file_bukti', 255)->nullable()->comment('Surat izin/sakit');
            $table->enum('metode_absen', ['manual', 'qr_code', 'fingerprint', 'face_recognition'])->default('manual');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Indexes untuk performansi
            $table->index('tanggal', 'idx_absensi_tanggal');
            $table->index('siswa_id', 'idx_absensi_siswa');
            $table->index('mapel_id', 'idx_absensi_mapel');
            $table->index('status', 'idx_absensi_status');
            $table->index('guru_id', 'idx_absensi_guru');
            
            // Composite index untuk rekap absensi
            $table->index(['siswa_id', 'tanggal'], 'idx_absensi_siswa_tanggal');
            $table->index(['mapel_id', 'tanggal'], 'idx_absensi_mapel_tanggal');
            
            // Unique constraint untuk mencegah duplikasi absensi
            $table->unique(['siswa_id', 'tanggal', 'mapel_id', 'sesi'], 'unique_absensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
