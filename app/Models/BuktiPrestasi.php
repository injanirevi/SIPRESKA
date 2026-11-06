<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiPrestasi extends Model
{
    protected $table = 'bukti_prestasis';

    protected $fillable = [
        'prestasi_id',
        'jenis_bukti',
        'nama_file',
        'file_path',
        'tanggal_upload',
        'keterangan',
    ];

    public function prestasi(): BelongsTo
    {
        return $this->belongsTo(Prestasi::class, 'prestasi_id');
    }
}