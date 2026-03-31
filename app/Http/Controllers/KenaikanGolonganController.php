<?php

namespace App\Http\Controllers;

use App\Models\KenaikanGolongan;
use App\Models\Anggota;
use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KenaikanGolonganController extends Controller
{
    public function index()
    {
        $anggota = Anggota::orderBy('nama')->get();
        $riwayat = KenaikanGolongan::with('anggota')->orderByDesc('tanggal_kenaikan')->get();
        $settings = Setting::get();

        return view('kenaikan-golongan.index', compact('anggota', 'riwayat', 'settings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_anggota'    => 'required|exists:anggotas,nomor_anggota',
            'golongan_awal'    => 'required|string',
            'golongan_tujuan'  => 'required|string',
            'tingkatan_tujuan' => 'nullable|string|in:Mula,Bantu,Tata,Ramu,Rakit,Terap,Bantara,Laksana',
            'tanggal_kenaikan' => 'required|date',
            'tempat_penetapan' => 'required|string|max:255',
            'nama_pembina'     => 'nullable|string|max:255',
            'nip_pembina'      => 'nullable|string|max:100',
            'nomor_sertifikat' => 'nullable|string|unique:kenaikan_golongan,nomor_sertifikat',
            'catatan'          => 'nullable|string',
        ]);

        // Gabungkan golongan + tingkatan → satu string ke DB
        // Contoh: "Penggalang" + "Ramu" → "Penggalang Ramu"
        // Contoh: "Penggalang" + null  → "Penggalang" (baru masuk golongan, belum bertingkat)
        $tingkatan = $validated['tingkatan_tujuan'] ?? null;
        $validated['golongan_tujuan'] = $tingkatan
            ? "{$validated['golongan_tujuan']} {$tingkatan}"
            : $validated['golongan_tujuan'];

        unset($validated['tingkatan_tujuan']);

        // Auto-generate nomor sertifikat jika kosong
        if (empty($validated['nomor_sertifikat'])) {
            $validated['nomor_sertifikat'] = KenaikanGolongan::generateNomorSertifikat();
        }

        // Jika pembina tidak dipilih, gunakan ketua dari settings
        if (empty($validated['nama_pembina'])) {
            $settings = Setting::get();
            $ketua = $settings->getKetuaPembina();
            if ($ketua) {
                $validated['nama_pembina'] = $ketua['nama'];
                $validated['nip_pembina']  = $ketua['nip'] ?? null;
            }
        }

        // Simpan kenaikan golongan
        $kenaikan = KenaikanGolongan::create($validated);

        // Update golongan di tabel anggota
        $anggota = Anggota::where('nomor_anggota', $validated['nomor_anggota'])->first();
        if ($anggota) {
            $anggota->update(['golongan_pramuka' => $validated['golongan_tujuan']]);

            Log::info('Golongan anggota updated', [
                'nomor_anggota' => $anggota->nomor_anggota,
                'golongan_baru' => $validated['golongan_tujuan'],
            ]);
        }

        // Generate PDF sertifikat
        try {
            $this->generateSertifikat($kenaikan);
            return redirect()->route('kenaikan')->with('success', 'Data kenaikan golongan berhasil disimpan, golongan anggota telah diperbarui, dan sertifikat dibuat!');
        } catch (\Exception $e) {
            Log::error('Kenaikan Golongan PDF generation failed: ' . $e->getMessage());
            return redirect()->route('kenaikan')->with('warning', 'Data kenaikan golongan tersimpan dan golongan anggota telah diperbarui, namun PDF gagal dibuat. Coba regenerasi dari tombol "Lihat Sertifikat".');
        }
    }

    private function generateSertifikat(KenaikanGolongan $kenaikan)
    {
        $settings = Setting::get();

        $pdf = Pdf::loadView('kenaikan-golongan.sertifikat', [
            'kenaikan' => $kenaikan,
            'settings' => $settings,
        ])->setPaper('a4', 'portrait');

        $filename = "sertifikat-{$kenaikan->nomor_sertifikat}.pdf";
        $path     = "sertifikat/kenaikan/{$filename}";

        Storage::disk('public')->put($path, $pdf->output());
    }

    public function showSertifikat($nomor_sertifikat)
    {
        $kenaikan = KenaikanGolongan::where('nomor_sertifikat', $nomor_sertifikat)
            ->with('anggota')
            ->firstOrFail();

        $filename = "sertifikat-{$nomor_sertifikat}.pdf";
        $path     = "sertifikat/kenaikan/{$filename}";

        if (!Storage::disk('public')->exists($path)) {
            try {
                $this->generateSertifikat($kenaikan);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal membuat sertifikat: ' . $e->getMessage()], 500);
            }
        }

        return response()->file(storage_path("app/public/{$path}"));
    }

    public function downloadSertifikat($nomor_sertifikat)
    {
        $kenaikan = KenaikanGolongan::where('nomor_sertifikat', $nomor_sertifikat)
            ->with('anggota')
            ->firstOrFail();

        $filename = "sertifikat-{$nomor_sertifikat}.pdf";
        $path     = "sertifikat/kenaikan/{$filename}";

        if (!Storage::disk('public')->exists($path)) {
            try {
                $this->generateSertifikat($kenaikan);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Gagal membuat sertifikat: ' . $e->getMessage()], 500);
            }
        }

        return Storage::disk('public')->download($path, "Sertifikat-Kenaikan-{$kenaikan->anggota->nama}.pdf");
    }
}