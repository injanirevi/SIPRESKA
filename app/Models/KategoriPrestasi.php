<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriPrestasi extends Model
{
    protected $table = 'kategori_prestasis';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'kategori_id');
    }
}