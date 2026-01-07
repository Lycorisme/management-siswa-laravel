<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung
     */
    protected $table = 'kelas';

    /**
     * Field yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'kode_kelas',
        'nama_kelas',
        'tingkat',
        'jurusan',
        'wali_kelas_id',
        'kapasitas',
        'ruangan',
        'tahun_ajaran',
        'semester',
        'status',
    ];

    /**
     * Daftar tingkat yang valid
     */
    public const TINGKAT = ['X', 'XI', 'XII'];

    /**
     * Relasi ke tabel users (wali kelas)
     */
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    /**
     * Relasi ke tabel siswa
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }

    /**
     * Get jumlah siswa dalam kelas
     */
    public function getJumlahSiswaAttribute()
    {
        return $this->siswa()->where('status', 'aktif')->count();
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk filter berdasarkan tingkat
     */
    public function scopeTingkat($query, $tingkat)
    {
        if ($tingkat) {
            return $query->where('tingkat', $tingkat);
        }
        return $query;
    }
}
