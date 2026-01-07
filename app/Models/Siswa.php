<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Siswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung
     */
    protected $table = 'siswa';

    /**
     * Field yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        // Data identitas
        'nis',
        'nisn',
        'nama_lengkap',
        'jenis_kelamin',
        
        // Data lahir
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        
        // Data alamat
        'alamat',
        'rt_rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_pos',
        
        // Data kontak
        'no_telepon',
        'email',
        
        // Data orang tua
        'nama_ayah',
        'nama_ibu',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'no_telepon_ortu',
        
        // Data akademik
        'kelas_id',
        'foto',
        'status',
        'tahun_masuk',
        'tahun_keluar',
        
        // Data poin
        'total_poin_prestasi',
        'total_poin_pelanggaran',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tahun_masuk' => 'integer',
        'tahun_keluar' => 'integer',
        'total_poin_prestasi' => 'integer',
        'total_poin_pelanggaran' => 'integer',
    ];

    /**
     * Daftar agama yang valid
     */
    public const AGAMA = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

    /**
     * Daftar status yang valid
     */
    public const STATUS = ['aktif', 'alumni', 'pindah', 'keluar', 'dropout'];

    /**
     * Relasi ke tabel kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke aktivitas siswa
     */
    public function aktivitasSiswa()
    {
        return $this->hasMany(AktivitasSiswa::class, 'siswa_id');
    }

    /**
     * Accessor untuk mendapatkan nama kelas lengkap
     */
    public function getNamaKelasAttribute()
    {
        return $this->kelas ? $this->kelas->nama_kelas : '-';
    }

    /**
     * Accessor untuk mendapatkan URL foto
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto && Storage::disk('public')->exists('siswa/' . $this->foto)) {
            return asset('storage/siswa/' . $this->foto);
        }
        return null;
    }

    /**
     * Accessor untuk umur siswa
     */
    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return $this->tanggal_lahir->age;
        }
        return null;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeStatus($query, $status)
    {
        if ($status && $status !== 'semua') {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan kelas
     */
    public function scopeKelasId($query, $kelasId)
    {
        if ($kelasId) {
            return $query->where('kelas_id', $kelasId);
        }
        return $query;
    }

    /**
     * Scope untuk filter berdasarkan jenis kelamin
     */
    public function scopeJenisKelamin($query, $jk)
    {
        if ($jk && $jk !== 'semua') {
            return $query->where('jenis_kelamin', $jk);
        }
        return $query;
    }

    /**
     * Scope untuk pencarian
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('nis', 'LIKE', "%{$search}%")
                  ->orWhere('nisn', 'LIKE', "%{$search}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$search}%");
            });
        }
        return $query;
    }
}
