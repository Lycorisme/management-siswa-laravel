<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel settings untuk menyimpan konfigurasi aplikasi
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value')->nullable();
            $table->enum('setting_type', ['text', 'number', 'boolean', 'json', 'date', 'time'])->default('text');
            $table->string('setting_group', 50)->nullable()->comment('Grup setting: general, school, attendance, etc');
            $table->string('label', 100)->nullable()->comment('Label untuk UI');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false)->comment('Apakah bisa diakses tanpa login');
            $table->timestamps();
            
            // Index
            $table->index('setting_group', 'idx_settings_group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
