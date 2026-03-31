<?php

namespace App\Http\Controllers;

use App\Models\Tkk;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TkkController extends Controller
{
    public function index()
    {
        $anggota = Anggota::orderBy('nama')->get();
        $riwayat = Tkk::with('anggota')->orderByDesc('tanggal_penetapan')->get();

        return view('tkk.index', compact('anggota', 'riwayat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_anggota' => 'required|exists:anggotas,nomor_anggota',
            'golongan_sekarang' => 'required|string',
            'nama_tkk' => 'required|string|max:255',
            'tingkat' => 'nullable|string|in:Purwa,Madya,Utama',
            'nama_penguji' => 'required|string|max:255',
            'penguji_is_pembina' => 'boolean',
            'tanggal_penetapan' => 'required|date',
            'tempat_penetapan' => 'required|string|max:255',
            'nomor_sertifikat' => 'nullable|string|unique:tkks,nomor_sertifikat',
            'catatan' => 'nullable|string',
        ]);

        // Auto-generate nomor sertifikat jika kosong
        if (empty($validated['nomor_sertifikat'])) {
            $validated['nomor_sertifikat'] = Tkk::generateNomorSertifikat();
        }

        $validated['penguji_is_pembina'] = $request->has('penguji_is_pembina');

        // Simpan TKK
        $tkk = Tkk::create($validated);

        // Generate PDF Sertifikat
        try {
            $this->generateSertifikat($tkk);
            return redirect()->route('tkk')->with('success', 'Data TKK berhasil disimpan dan sertifikat dibuat!');
        } catch (\Exception $e) {
            Log::error('TKK PDF generation failed: ' . $e->getMessage());
            return redirect()->route('tkk')->with('warning', 'Data TKK tersimpan, namun PDF gagal dibuat. Coba regenerasi dari tombol "Lihat Sertifikat".');
        }
    }

    private function generateSertifikat(Tkk $tkk)
    {
        $settings = \App\Models\Setting::get();
        $pdf = Pdf::loadView('tkk.sertifikat', ['tkk' => $tkk, 'settings' => $settings,])
            ->setPaper('a4', 'portrait');

        $filename = "sertifikat-tkk-{$tkk->nomor_sertifikat}.pdf";
        $path = "sertifikat/tkk/{$filename}";

        Storage::disk('public')->put($path, $pdf->output());
    }

    public function showSertifikat($nomor_sertifikat)
    {
        $tkk = Tkk::where('nomor_sertifikat', $nomor_sertifikat)->with('anggota')->firstOrFail();
        $filename = "sertifikat-tkk-{$nomor_sertifikat}.pdf";
        $path = "sertifikat/tkk/{$filename}";

        // Jika file tidak ada, regenerate
        if (!Storage::disk('public')->exists($path)) {
            try {
                $this->generateSertifikat($tkk);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal membuat sertifikat: ' . $e->getMessage()], 500);
            }
        }

        return response()->file(storage_path("app/public/{$path}"));
    }

    public function downloadSertifikat($nomor_sertifikat)
    {
        $tkk = Tkk::where('nomor_sertifikat', $nomor_sertifikat)->with('anggota')->firstOrFail();
        $filename = "sertifikat-tkk-{$nomor_sertifikat}.pdf";
        $path = "sertifikat/tkk/{$filename}";

        if (!Storage::disk('public')->exists($path)) {
            try {
                $this->generateSertifikat($tkk);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal membuat sertifikat: ' . $e->getMessage()], 500);
            }
        }

        return Storage::disk('public')->download($path, "Sertifikat-TKK-{$tkk->anggota->nama}.pdf");
    }
}