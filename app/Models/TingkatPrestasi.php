<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TingkatPrestasi extends Model
{
    protected $table = 'tingkat_prestasis';

    protected $fillable = [
        'nama_tingkat',
        'deskripsi',
    ];

    public function prestasis(): HasMany
    {
        return $this->hasMany(Prestasi::class, 'tingkat_id');
    }
}