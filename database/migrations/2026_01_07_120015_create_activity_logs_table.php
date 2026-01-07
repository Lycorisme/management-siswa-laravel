<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel activity_logs untuk tracking aktivitas user
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('action', 50)->comment('create, update, delete, login, logout, etc');
            $table->string('module', 50)->comment('siswa, kelas, guru, mapel, etc');
            $table->text('description')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('old_values')->nullable()->comment('Nilai sebelum perubahan');
            $table->json('new_values')->nullable()->comment('Nilai sesudah perubahan');
            $table->timestamp('created_at')->useCurrent();
            
            // Indexes
            $table->index('user_id', 'idx_activity_logs_user');
            $table->index('action', 'idx_activity_logs_action');
            $table->index('module', 'idx_activity_logs_module');
            $table->index('created_at', 'idx_activity_logs_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
