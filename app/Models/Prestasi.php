<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prestasi extends Model
{
    protected $table = 'prestasis';

    protected $fillable = [
        'kategori_id',
        'tingkat_id',
        'nama_prestasi',
        'jenis_prestasi',
        'peringkat',
        'tahun',
        'penyelenggara',
        'deskripsi',
        'status',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriPrestasi::class, 'kategori_id');
    }

    public function tingkat(): BelongsTo
    {
        return $this->belongsTo(TingkatPrestasi::class, 'tingkat_id');
    }

    public function anggota(): HasMany
    {
        return $this->hasMany(AnggotaPrestasi::class, 'prestasi_id');
    }

    public function bukti(): HasMany
    {
        return $this->hasMany(BuktiPrestasi::class, 'prestasi_id');
    }

    public function verifikasi(): HasMany
    {
        return $this->hasMany(Verifikasi::class, 'prestasi_id');
    }
}