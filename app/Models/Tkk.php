<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tkk extends Model
{
    use HasFactory;

    protected $table = 'tkks';

    protected $fillable = [
        'nomor_anggota',
        'golongan_sekarang',
        'nama_tkk',
        'tingkat',
        'nama_penguji',
        'penguji_is_pembina',
        'nomor_sertifikat',
        'tanggal_penetapan',
        'tempat_penetapan',
        'catatan',
    ];

    protected $casts = [
        'tanggal_penetapan' => 'date',
        'penguji_is_pembina' => 'boolean',
        'nomor_anggota' => 'integer',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'nomor_anggota', 'nomor_anggota');
    }

    /**
     * Generate nomor sertifikat otomatis
     * Format: TKK-{YEAR}-{4 digit urutan}
     */
    public static function generateNomorSertifikat(): string
    {
        $year = now()->year;
        $prefix = "TKK-{$year}-";

        $last = self::where('nomor_sertifikat', 'like', "{$prefix}%")
            ->orderByDesc('nomor_sertifikat')
            ->value('nomor_sertifikat');

        $lastNumber = $last ? (int) substr($last, strlen($prefix)) : 0;
        $next = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$next}";
    }
}