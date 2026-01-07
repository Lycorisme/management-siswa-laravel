<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasSiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung
     */
    protected $table = 'aktivitas_siswa';

    /**
     * Field yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'siswa_id',
        'jenis_aktivitas',
        'deskripsi',
        'data_lama',
        'data_baru',
        'created_by',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    /**
     * Daftar jenis aktivitas yang valid
     */
    public const JENIS_AKTIVITAS = [
        'absensi',
        'prestasi',
        'pelanggaran',
        'perubahan_data',
        'lainnya',
    ];

    /**
     * Relasi ke tabel siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Relasi ke tabel users (created_by)
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
