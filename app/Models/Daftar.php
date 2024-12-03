<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Daftar extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal_daftar',
        'pasien_id',
        'poli_id',
        'keluhan',
        'diagnosis',
        'tindakan',
    ];
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    public function getPasienNameAttribute()
    {
        return optional($this->pasien)->nama;
    }
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class)->withDefault();
    }
}
