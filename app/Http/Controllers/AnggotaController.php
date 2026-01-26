<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Imports\AnggotaImport;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\alert;

class AnggotaController extends Controller
{
    public function index()
    {
        return view('anggota.index');
    }

    public function getAnggotas(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Anggota::query())
                ->filter(function ($q) use ($request) {
                    if ($request->golongan_pramuka) {
                        $q->where('golongan_pramuka', $request->golongan_pramuka);
                    }

                    if (!empty($request->search['value'])) {
                        $search = $request->search['value'];
                        $q->where(function ($sub) use ($search) {
                            $sub->where('nama', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('no_telp', 'like', "%{$search}%");
                        });
                    }
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d-m-Y H:i') : '';
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at ? $row->updated_at->format('d-m-Y H:i') : '';
                })
                ->make(true);
        }
    }

    public function getGolonganPramuka()
    {
        $golonganpramuka = Anggota::select('golongan_pramuka')
            ->whereNotNull('golongan_pramuka')
            ->distinct()
            ->pluck('golongan_pramuka');

        return response()->json($golonganpramuka);
    }

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_anggota' => 'required|string',
            'nik' => 'required|string',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'golongan_pramuka' => 'required|string',
            'golongan_darah' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $anggota = Anggota::create($request->all());

        // Generate PDF
        $pdf = PDF::loadView('cards.member-card', compact('anggota'))
            ->setPaper('a5', 'landscape');

        // Save ke R2
        $filename = "cards/card-{$anggota->nomor_anggota}.pdf";
        Storage::disk('r2')->put($filename, $pdf->output());

        return redirect()->route('anggota')->with('success', 'Data anggota berhasil ditambahkan.');
}

    public function showKta($nomor_anggota)
    {
        $filename = "cards/card-{$nomor_anggota}.pdf";
        
        if (Storage::disk('r2')->exists($filename)) {
            return response()->make(
                Storage::disk('r2')->get($filename),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="card-'.$nomor_anggota.'.pdf"'
                ]
            );
        } else {
            alert('KTA not found in storage.');
            return redirect()->route('anggota')->with('error', 'KTA not found.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();

        $importer = new AnggotaImport();
        $importer->import($path);

        return redirect()->back()->with('success', 'Data anggota berhasil diimport.');
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
            'nomor_anggota' => 'required|string',
            'nik' => 'required|string',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'agama' => 'required|string',
            'golongan_pramuka' => 'required|string',
            'golongan_darah' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|string',
            'email' => 'required|email',
            'alamat' => 'required|string',
            'no_telp' => 'nullable|string|max:20',
        ]);

        $anggota->update($request->all());

        return redirect()->route('anggota')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function generateCard(Anggota $anggota)
    {
        $pdf = PDF::loadView('cards.member-card', compact('anggota'))
                ->setPaper('a7', 'landscape'); // small card size

        return $pdf->download("member-card-{$anggota->id}.pdf");
    }


    public function destroy($nomor_anggota)
    {
        $anggota = Anggota::where('nomor_anggota', $nomor_anggota)->first();

        if ($anggota) {
            $anggota->delete();
            return redirect()->route('anggota')->with('success', 'Data Berhasip Dihapus');
        }

        return response()->json(['success' => false, 'message' => 'Data anggota tidak ditemukan.']);
    }
}
