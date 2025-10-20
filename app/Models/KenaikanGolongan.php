<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KenaikanGolongan extends Model
{
    use HasFactory;

    protected $table = 'kenaikan_golongan';

    protected $fillable = [
        'nomor_anggota',
        'golongan_awal',
        'golongan_tujuan',
        'tanggal_kenaikan',
        'catatan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'nomor_anggota', 'nomor_anggota');
    }
}
