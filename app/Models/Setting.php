<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'nama_gugus_depan',
        'nomor_gugus_depan',
        'alamat',
        'pembina',
        'nama_kepala_sekolah',
        'nip_kepala_sekolah',
    ];

    protected $casts = [
        'pembina' => 'array',
    ];

    /**
     * Get singleton settings record
     */
    public static function get()
    {
        return self::first() ?? self::create([
            'nama_gugus_depan' => 'Gugus Depan 11.021-11.022',
            'nomor_gugus_depan' => '11.021-11.022',
            'alamat' => 'Surabaya, Jawa Timur',
            'pembina' => [
                ['nama' => 'Drs. Bambang Sudirman, M.Pd.', 'nip' => '196512151990031004', 'is_ketua' => true],
            ],
        ]);
    }

    /**
     * Get ketua pembina (untuk TTD sertifikat)
     */
    public function getKetuaPembina()
    {
        if (!$this->pembina) return null;

        foreach ($this->pembina as $p) {
            if (isset($p['is_ketua']) && $p['is_ketua']) {
                return $p;
            }
        }

        // Fallback: return first pembina
        return $this->pembina[0] ?? null;
    }
}