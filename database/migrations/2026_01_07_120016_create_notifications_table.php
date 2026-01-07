<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel notifications untuk sistem notifikasi
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['info', 'warning', 'success', 'danger'])->default('info');
            $table->string('title', 200);
            $table->text('message')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->json('data')->nullable()->comment('Data tambahan dalam format JSON');
            $table->timestamp('created_at')->useCurrent();
            
            // Indexes
            $table->index('user_id', 'idx_notifications_user');
            $table->index('is_read', 'idx_notifications_read');
            $table->index('type', 'idx_notifications_type');
            $table->index('created_at', 'idx_notifications_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
