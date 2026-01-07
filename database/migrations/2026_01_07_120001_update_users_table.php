<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom tambahan untuk tabel users (Admin & Guru)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename name to nama_lengkap for consistency
            $table->renameColumn('name', 'nama_lengkap');
        });

        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom username setelah id
            $table->string('username', 50)->unique()->after('id');
            
            // Kolom data personal
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L')->after('nama_lengkap');
            $table->string('nip', 30)->unique()->nullable()->after('jenis_kelamin');
            $table->string('tempat_lahir', 50)->nullable()->after('nip');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('no_telepon', 15)->nullable()->after('alamat');
            
            // Kolom role dan jabatan
            $table->enum('role', ['admin', 'guru'])->default('guru')->after('password');
            $table->string('jabatan', 100)->nullable()->after('role');
            $table->string('bidang_studi', 100)->nullable()->after('jabatan');
            
            // Kolom foto dan status
            $table->string('foto', 255)->nullable()->after('bidang_studi');
            $table->enum('status', ['aktif', 'nonaktif', 'pensiun', 'pindah'])->default('aktif')->after('foto');
            
            // Kolom tracking
            $table->timestamp('last_login')->nullable()->after('status');
            
            // Index untuk performansi
            $table->index('role', 'idx_users_role');
            $table->index('status', 'idx_users_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex('idx_users_role');
            $table->dropIndex('idx_users_status');
            
            // Drop columns
            $table->dropColumn([
                'username',
                'jenis_kelamin',
                'nip',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'no_telepon',
                'role',
                'jabatan',
                'bidang_studi',
                'foto',
                'status',
                'last_login'
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('nama_lengkap', 'name');
        });
    }
};
