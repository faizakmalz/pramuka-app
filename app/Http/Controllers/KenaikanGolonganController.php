<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\KenaikanGolongan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KenaikanGolonganController extends Controller
{
    public function index()
    {
        $anggota = Anggota::orderBy('nama')->get();
        $riwayat = KenaikanGolongan::with('anggota')->latest()->get();

        return view('kenaikan-golongan.index', compact('anggota', 'riwayat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_anggota'      => 'required|exists:anggotas,nomor_anggota',
            'nomor_sertifikat'   => 'nullable|string|unique:kenaikan_golongan,nomor_sertifikat',
            'golongan_awal'      => 'required|string',
            'golongan_tujuan'    => 'required|string|different:golongan_awal',
            'tanggal_kenaikan'   => 'required|date',
            'tempat_penetapan'  => 'required|string',
            'catatan'            => 'nullable|string',
        ]);

        // Auto-generate nomor sertifikat jika tidak diisi
        if (empty($validated['nomor_sertifikat'])) {
            $validated['nomor_sertifikat'] = KenaikanGolongan::generateNomorSertifikat();
        }

        try {
            $kenaikan = KenaikanGolongan::create($validated);

            $anggota = Anggota::where('nomor_anggota', $request->nomor_anggota)->first();
            if ($anggota) {
                $anggota->update(['golongan_pramuka' => $request->golongan_tujuan]);
            }

            // Generate sertifikat PDF
            $this->generateSertifikatPdf($kenaikan);
            
            return redirect()->back()->with('success', 'Kenaikan golongan berhasil disimpan dan sertifikat telah dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function showSertifikat($nomor_sertifikat)
    {
        $filename = "sertifikat/sertifikat-{$nomor_sertifikat}.pdf";

        if (!Storage::disk('public')->exists($filename)) {
            $kenaikan = KenaikanGolongan::where('nomor_sertifikat', $nomor_sertifikat)
                ->with('anggota')
                ->firstOrFail();

            $this->generateSertifikatPdf($kenaikan);
        }

        if (Storage::disk('public')->exists($filename)) {
            return Storage::disk('public')->response($filename);
        }

        return redirect()->route('kenaikan.index')->with('error', 'Sertifikat tidak ditemukan.');
    }

    public function downloadSertifikat($nomor_sertifikat)
    {
        $filename = "sertifikat/sertifikat-{$nomor_sertifikat}.pdf";

        if (!Storage::disk('public')->exists($filename)) {
            $kenaikan = KenaikanGolongan::where('nomor_sertifikat', $nomor_sertifikat)
                ->with('anggota')
                ->firstOrFail();

            $this->generateSertifikatPdf($kenaikan);
        }

        return Storage::disk('public')->download($filename, "Sertifikat-{$nomor_sertifikat}.pdf");
    }

    private function generateSertifikatPdf(KenaikanGolongan $kenaikan): void
    {
        if (!$kenaikan->relationLoaded('anggota')) {
            $kenaikan->load('anggota');
        }

        if (!Storage::disk('public')->exists('sertifikat')) {
            Storage::disk('public')->makeDirectory('sertifikat');
        }

        $pdf = Pdf::loadView('kenaikan-golongan.sertifikat', compact('kenaikan'))
            ->setPaper('a4', 'portrait');

        $filename = "sertifikat/sertifikat-{$kenaikan->nomor_sertifikat}.pdf";
        Storage::disk('public')->put($filename, $pdf->output());
    }
}