<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung
     */
    protected $table = 'activity_logs';

    /**
     * Menonaktifkan updated_at karena hanya ada created_at
     */
    public $timestamps = false;

    /**
     * Field yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'user_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
        'created_at',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Static method untuk mencatat aktivitas
     */
    public static function log(
        string $action,
        string $module,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null
    ) {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'created_at' => now(),
        ]);
    }
}
