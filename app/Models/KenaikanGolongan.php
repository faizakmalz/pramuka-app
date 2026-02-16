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
        'nomor_sertifikat',
        'catatan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'nomor_anggota', 'nomor_anggota');
    }

    /**
     * Generate nomor sertifikat otomatis jika tidak diisi.
     * Format: SERT-{YEAR}-{4 digit urutan}
     */
    public static function generateNomorSertifikat(): string
    {
        $year = now()->year;
        $prefix = "SERT-{$year}-";

        $last = self::where('nomor_sertifikat', 'like', "{$prefix}%")
            ->orderByDesc('nomor_sertifikat')
            ->value('nomor_sertifikat');

        $lastNumber = $last ? (int) substr($last, strlen($prefix)) : 0;
        $next = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$next}";
    }
}
