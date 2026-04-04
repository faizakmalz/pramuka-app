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
      if (!$request->ajax()) return;

    // Gunakan query builder yang lebih ringan
    $query = Anggota::query()
        // Gunakan Left Join ke KenaikanGolongan yang hanya mengambil record terbaru saja
        ->leftJoin('kenaikan_golongan as kg1', function($join) {
            $join->on('anggotas.nomor_anggota', '=', 'kg1.nomor_anggota')
                 ->whereRaw('kg1.id = (SELECT MAX(id) FROM kenaikan_golongan WHERE nomor_anggota = kg1.nomor_anggota)');
        })
        ->select([
            'anggotas.nomor_anggota', 
            'anggotas.nama', 
            'anggotas.nik', 
            'anggotas.jenis_kelamin',
            'anggotas.golongan_pramuka',
            'anggotas.golongan_darah',
            'anggotas.tempat_lahir',
            'anggotas.tanggal_lahir',
            'anggotas.no_telp',
            'kg1.nomor_sertifikat', 
        ]);

    return DataTables::of($query)
        // Tambahkan ini agar DataTables tidak pusing dengan kolom hasil join
        ->setRowId('nomor_anggota')
        ->filter(function ($query) use ($request) {
            if ($request->has('search') && !empty($request->get('search')['value'])) {
                $keyword = $request->get('search')['value'];
                // Gunakan prefix tabel 'anggotas.' agar tidak ambiguous
                $query->where(function($q) use ($keyword) {
                    $q->where('anggotas.nama', 'like', "%$keyword%")
                      ->orWhere('anggotas.nomor_anggota', 'like', "%$keyword%")
                      ->orWhere('anggotas.nik', 'like', "%$keyword%");
                });
            }
            
            if ($request->filled('golongan_pramuka')) {
                $query->where('anggotas.golongan_pramuka', $request->golongan_pramuka);
            }
        }, true) 
        ->addColumn('sertifikat_link', function($row) {
            if (!$row->nomor_sertifikat) return null;
            
            return [
                'nomor' => $row->nomor_sertifikat,
                'url_show' => route('kenaikan.sertifikat.show', $row->nomor_sertifikat),
                'url_download' => route('kenaikan.sertifikat.download', $row->nomor_sertifikat)
            ];
        })
        ->rawColumns(['sertifikat_link'])
        ->make(true);
    }

    public function getGolonganPramuka()
    {
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
            'golongan_darah'  => 'nullable|string',
            'tempat_lahir'    => 'required|string',
            'tanggal_lahir'   => 'required|string',
            'email'           => 'required|email',
            'alamat'          => 'required|string',
            'no_telp'         => 'required|string|max:20',
        ]);

        // ✅ 1. SIMPAN ANGGOTA DULU (ini prioritas utama)
        $anggota = Anggota::create($request->all());

        // ✅ 2. TRY GENERATE PDF - tapi jangan sampai block proses create
        try {
            // Pastikan folder cards ada
            if (!Storage::disk('public')->exists('cards')) {
                Storage::disk('public')->makeDirectory('cards');
            }

            $pdf = Pdf::loadView('cards.member-card', compact('anggota'))
                ->setPaper('a5', 'landscape');

            $filename = "cards/card-{$anggota->nomor_anggota}.pdf";
            Storage::disk('public')->put($filename, $pdf->output());
            
            \Log::info('KTA PDF generated', ['anggota' => $anggota->nomor_anggota]);
            
        } catch (\Exception $e) {
            // ✅ LOG ERROR tapi JANGAN rollback anggota
            \Log::error('Failed to generate KTA PDF', [
                'anggota' => $anggota->nomor_anggota,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // ✅ Beri warning ke user bahwa PDF gagal
            return redirect()->route('anggota')
                ->with('warning', 'Data anggota berhasil ditambahkan, namun kartu belum bisa digenerate. Silakan generate ulang dari menu.');
        }

        return redirect()->route('anggota')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function showKta($nomor_anggota)
    {
        $filename = "cards/card-{$nomor_anggota}.pdf";

        // ✅ GENERATE ON-DEMAND kalau file belum ada
        if (!Storage::disk('public')->exists($filename)) {
            \Log::info('KTA not found, generating on-demand', ['anggota' => $nomor_anggota]);
            
            try {
                $anggota = Anggota::where('nomor_anggota', $nomor_anggota)->firstOrFail();
                
                // Pastikan folder ada
                if (!Storage::disk('public')->exists('cards')) {
                    Storage::disk('public')->makeDirectory('cards');
                }

                $pdf = Pdf::loadView('cards.member-card', compact('anggota'))
                    ->setPaper('a5', 'landscape');

                Storage::disk('public')->put($filename, $pdf->output());
                
                \Log::info('KTA generated on-demand successfully', ['anggota' => $nomor_anggota]);
                
            } catch (\Exception $e) {
                \Log::error('Failed to generate KTA on-demand', [
                    'anggota' => $nomor_anggota,
                    'error' => $e->getMessage()
                ]);
                
                return redirect()->route('anggota')
                    ->with('error', 'Gagal generate KTA: ' . $e->getMessage());
            }
        }

        // ✅ Serve PDF kalau sudah ada
        if (Storage::disk('public')->exists($filename)) {
            return Storage::disk('public')->response($filename, "card-{$nomor_anggota}.pdf", [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline'
            ]);
        }

        return redirect()->route('anggota')->with('error', 'KTA tidak ditemukan.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

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
            ->setPaper('a5', 'landscape');

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
    
    // ✅ BONUS: Method untuk regenerate KTA manual kalau perlu
    public function regenerateKta($nomor_anggota)
    {
        try {
            $anggota = Anggota::where('nomor_anggota', $nomor_anggota)->firstOrFail();
            
            if (!Storage::disk('public')->exists('cards')) {
                Storage::disk('public')->makeDirectory('cards');
            }

            $pdf = Pdf::loadView('cards.member-card', compact('anggota'))
                ->setPaper('a5', 'landscape');

            $filename = "cards/card-{$anggota->nomor_anggota}.pdf";
            Storage::disk('public')->put($filename, $pdf->output());
            
            \Log::info('KTA regenerated manually', ['anggota' => $nomor_anggota]);
            
            return redirect()->back()
                ->with('success', 'KTA berhasil digenerate ulang.');
                
        } catch (\Exception $e) {
            \Log::error('Failed to regenerate KTA', [
                'anggota' => $nomor_anggota,
                'error' => $e->getMessage()
            ]);
            
            return redirect()->back()
                ->with('error', 'Gagal generate KTA: ' . $e->getMessage());
        }
    }
}