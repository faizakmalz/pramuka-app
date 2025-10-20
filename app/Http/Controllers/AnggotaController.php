<?php

namespace App\Http\Controllers;

use App\Imports\AnggotaImport;
use App\Models\Anggota;
use Illuminate\Http\Request;
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

        Anggota::create($request->all());

        return redirect()->route('anggota')->with('success', 'Data anggota berhasil ditambahkan.');
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
