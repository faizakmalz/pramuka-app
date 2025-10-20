<?php

namespace App\Http\Controllers;

use App\Models\KenaikanGolongan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class KenaikanGolonganController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        $riwayat = KenaikanGolongan::with('anggota')->latest()->get();
        return view('kenaikan-golongan.index', compact('anggota', 'riwayat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_anggota' => 'required|exists:anggotas,nomor_anggota',
            'golongan_awal' => 'required|string',
            'golongan_tujuan' => 'required|string|different:golongan_awal',
            'tanggal_kenaikan' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        $kenaikan = KenaikanGolongan::create($validated);

        $anggota = Anggota::where('nomor_anggota', $request->nomor_anggota)->first();
        if ($anggota) {
            $anggota->update(['golongan_pramuka' => $request->golongan_tujuan]);
        }

        return redirect()->back()->with('success', 'Kenaikan golongan berhasil disimpan.');
    }

}
