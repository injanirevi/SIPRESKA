<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaPrestasi extends Model
{
    protected $table = 'anggota_prestasis';

    protected $fillable = [
        'prestasi_id',
        'sivitas_id',
        'nama',
        'nim_nip',
        'peran',
        'keterangan',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }

    public function sivitas(): BelongsTo
    {
        return $this->belongsTo(Sivitas::class, 'sivitas_id');
    }
}