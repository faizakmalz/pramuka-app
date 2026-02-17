<?php

namespace App\Http\Controllers;

use App\Exports\AnggotaExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\AnggotaImport;
use App\Models\Anggota;
use App\Models\KenaikanGolongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class AnggotaController extends Controller
{
    public function index()
    {
        return view('anggota.index');
    }

    public function getAnggotas(Request $request)
    {
        \DB::connection()->enableQueryLog();
        if ($request->ajax()) {
            // OPTIMASI 1: Pilih kolom tertentu saja (jangan select *)
            $query = Anggota::query()->select([
                'nomor_anggota', 
                'nama', 
                'nik',
                'jenis_kelamin',
                'golongan_darah',
                'tempat_lahir',
                'tanggal_lahir',
                'alamat',
                'email', 
                'no_telp', 
                'golongan_pramuka', 
                'created_at'
            ])->with('kenaikanTerbaru'); // Eager load kenaikan terbaru untuk menghindari N+1

            \Log::info(\DB::getQueryLog());

           return DataTables::of($query)
        // Tambahkan kolom virtual untuk Sertifikat
            ->addColumn('sertifikat_link', function($row) {
                $kenaikan = $row->kenaikanTerbaru;
                if (!$kenaikan) return null;
                
                return [
                    'nomor' => $kenaikan->nomor_sertifikat,
                    'url_show' => route('kenaikan.sertifikat.show', $kenaikan->nomor_sertifikat),
                    'url_download' => route('kenaikan.sertifikat.download', $kenaikan->nomor_sertifikat)
                ];
            })
            ->make(true);
        }
    }

    public function getGolonganPramuka()
    {
        // Simpan hasil query di cache selama 60 menit
        $golonganpramuka = cache()->remember('list_golongan_pramuka', 3600, function () {
            return Anggota::whereNotNull('golongan_pramuka')
                ->distinct()
                ->pluck('golongan_pramuka');
        });

        return response()->json($golonganpramuka);
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_anggota'   => 'required|string',
            'nik'             => 'required|string',
            'nama'            => 'required|string|max:255',
            'jenis_kelamin'   => 'required|string',
            'agama'           => 'required|string',
            'golongan_pramuka'=> 'required|string',
            'golongan_darah'  => 'required|string',
            'tempat_lahir'    => 'required|string',
            'tanggal_lahir'   => 'required|string',
            'email'           => 'required|email',
            'alamat'          => 'required|string',
            'no_telp'         => 'nullable|string|max:20',
        ]);

        $anggota = Anggota::create($request->all());

        // Generate PDF kartu anggota
        $pdf = Pdf::loadView('cards.member-card', compact('anggota'))
            ->setPaper('a5', 'landscape');

        $filename = "cards/card-{$anggota->nomor_anggota}.pdf";
        Storage::disk('public')->put($filename, $pdf->output());

        return redirect()->route('anggota')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function showKta($nomor_anggota)
    {
        $filename = "cards/card-{$nomor_anggota}.pdf";

        if (!Storage::disk('public')->exists('cards')) {
            Storage::disk('public')->makeDirectory('cards');
        }

        if (Storage::disk('public')->exists($filename)) {
        // Cara ini jauh lebih hemat RAM (streaming)
            return Storage::disk('public')->response($filename, "card-{$nomor_anggota}.pdf", [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline'
            ]);
        }

        return redirect()->route('anggota')->with('error', 'KTA not found.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Excel::import(new AnggotaImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data anggota berhasil diimport.');
    }

    public function export(Request $request)
    {
        $golongan = $request->get('golongan_pramuka');

        return (new AnggotaExport($golongan))->download();
    }

    public function edit($nomor_anggota)
    {
        $anggota = Anggota::where('nomor_anggota', $nomor_anggota)->firstOrFail();
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $nomor_anggota)
    {
        $anggota = Anggota::where('nomor_anggota', $nomor_anggota)->firstOrFail();

        $request->validate([
            'nomor_anggota'   => 'required|string',
            'nik'             => 'required|string',
            'nama'            => 'required|string|max:255',
            'jenis_kelamin'   => 'required|string',
            'agama'           => 'required|string',
            'golongan_pramuka'=> 'required|string',
            'golongan_darah'  => 'required|string',
            'tempat_lahir'    => 'required|string',
            'tanggal_lahir'   => 'required|string',
            'email'           => 'required|email',
            'alamat'          => 'required|string',
            'no_telp'         => 'nullable|string|max:20',
        ]);

        $anggota->update($request->all());

        return redirect()->route('anggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function generateCard(Anggota $anggota)
    {
        $pdf = Pdf::loadView('cards.member-card', compact('anggota'))
            ->setPaper('a7', 'landscape');

        return $pdf->download("member-card-{$anggota->id}.pdf");
    }

    public function destroy($nomor_anggota)
    {
        $anggota = Anggota::where('nomor_anggota', $nomor_anggota)->first();

        if ($anggota) {
            $filename = "cards/card-{$nomor_anggota}.pdf";
            if (Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);
            }

            $anggota->delete();

            return redirect()->route('anggota')->with('success', 'Data berhasil dihapus.');
        }

        return response()->json([
            'success' => false,
            'message' => 'Data anggota tidak ditemukan.',
        ]);
    }
}