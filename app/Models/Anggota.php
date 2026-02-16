<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Anggota extends Model
{
    //
     use HasFactory;

    protected $table = 'anggotas';
    protected $primaryKey = 'nomor_anggota'; 
    public $incrementing = false;           
    protected $keyType = 'string'; 

    protected $fillable = [
        'nomor_anggota',
        'nik',
        'nama',
        'jenis_kelamin',
        'agama',
        'golongan_pramuka',
        'golongan_darah',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'email',
        'no_telp',
    ];

    public function kenaikanGolongans()
    {
        return $this->hasMany(KenaikanGolongan::class, 'nomor_anggota', 'nomor_anggota');
    }

    public function kenaikanTerbaru(): HasOne
    {
        return $this->hasOne(KenaikanGolongan::class, 'nomor_anggota', 'nomor_anggota')
            ->whereNotNull('nomor_sertifikat')
            ->latestOfMany('tanggal_kenaikan');
    }
}
