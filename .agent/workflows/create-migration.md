---
description: Panduan membuat migration baru
---
# Create Migration Workflow

## Membuat Migration Baru

1. Buat migration untuk tabel baru:
```bash
php artisan make:migration create_nama_tabel_table
```

2. Buat migration untuk update tabel existing:
```bash
php artisan make:migration update_nama_tabel_table
```

3. Buat migration dengan model sekaligus:
```bash
php artisan make:model NamaModel -m
```

## Naming Conventions

- Nama tabel: snake_case, plural (kecuali sudah jelas singular seperti "siswa")
- Nama kolom: snake_case
- Foreign key: nama_tabel_singular_id (contoh: kelas_id, guru_id)
- Index: idx_nama_tabel_kolom
- Unique constraint: unique_deskripsi

## Contoh Migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nama_tabel', function (Blueprint $table) {
            $table->id();
            // Kolom lainnya
            $table->timestamps();
            
            // Foreign keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Indexes
            $table->index('kolom', 'idx_nama_tabel_kolom');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nama_tabel');
    }
};
```

## Menjalankan Migration

```bash
# Jalankan migration pending
php artisan migrate

# Rollback migration terakhir
php artisan migrate:rollback

# Rollback semua dan migrate ulang
php artisan migrate:refresh

# Drop semua tabel dan migrate ulang
php artisan migrate:fresh
```
