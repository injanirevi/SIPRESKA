<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sivitas extends Model
{
    protected $table = 'sivitas';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'jenis_sivitas',
        'program_studi',
        'fakultas',
        'no_hp',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function anggotaPrestasi(): HasMany
    {
        return $this->hasMany(AnggotaPrestasi::class, 'sivitas_id');
    }
}
