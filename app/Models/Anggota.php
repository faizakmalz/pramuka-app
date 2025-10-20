<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    //
     use HasFactory;

    protected $table = 'anggotas';
    protected $primaryKey = 'nomor_anggota'; 
    public $incrementing = false;           
    protected $keyType = 'string'; 

    protected $fillable = [
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
}
