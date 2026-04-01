<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::get();

        $nomorParts = explode('-', $settings->nomor_gugus_depan ?? '-');
        $nomorPa = $nomorParts[0] ?? '';
        $nomorPi = $nomorParts[1] ?? '';
        return view('settings.index', compact('settings', 'nomorPa', 'nomorPi'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_gugus_depan'      => 'required|string|max:255',
            'nomor_gugus_depan_pa'  => 'required|string|max:50',  // field baru
            'nomor_gugus_depan_pi'  => 'required|string|max:50',  // field baru
            'alamat'                => 'nullable|string|max:500',
            'nama_kepala_sekolah'   => 'nullable|string|max:255',
            'nip_kepala_sekolah'    => 'nullable|string|max:100',
            'pembina'               => 'nullable|array',
            'pembina.*.nama'        => 'required|string|max:255',
            'pembina.*.nip'         => 'nullable|string|max:100',
            'pembina.*.is_ketua'    => 'boolean',
        ]);

         $validated['nomor_gugus_depan'] = $validated['nomor_gugus_depan_pa']
            . '-'
            . $validated['nomor_gugus_depan_pi'];

        unset($validated['nomor_gugus_depan_pa'], $validated['nomor_gugus_depan_pi']);

        // Ensure only one ketua
        if (isset($validated['pembina'])) {
            $ketuaCount = 0;
            foreach ($validated['pembina'] as &$p) {
                if (isset($p['is_ketua']) && $p['is_ketua']) {
                    if ($ketuaCount > 0) {
                        $p['is_ketua'] = false; // Only first ketua allowed
                    }
                    $ketuaCount++;
                }
            }
        }

        $settings = Setting::first();
        $settings->update($validated);

        return redirect()->route('settings')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}   