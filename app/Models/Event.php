<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'event',
        'deskripsi',
        'tanggal_awal',
        'tanggal_akhir',
        'lokasi',
        'peserta',
    ];
}
