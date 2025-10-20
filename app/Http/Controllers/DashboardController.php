<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Event;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard');
    }

    public function anggotaData(Request $request)
    {
        if($request->ajax()){
            $data = Anggota::select(['nomor_anggota', 'nama', 'jenis_kelamin', 'agama', 'golongan_pramuka', 'golongan_darah', 'alamat']);
            return Datatables::of($data)->make(true);
        }
    }

    public function golonganCounts()
    {
        $allGolongan = [
            'Siaga',
            'Penggalang',
            'Penegak',
            'Pandega',
            'Pembina'
        ];

        $counts = Anggota::select('golongan_pramuka', \DB::raw('COUNT(*) as total'))
            ->groupBy('golongan_pramuka')
            ->pluck('total', 'golongan_pramuka')
            ->toArray();

        $result = [];
        foreach ($allGolongan as $golongan) {
            $result[] = [
                'golongan_pramuka' => $golongan,
                'total' => $counts[$golongan] ?? 0,
            ];
        }

        return response()->json($result);
    }

    public function dashboardEvents()
    {
        $events = \DB::table('events')->select('event', 'tanggal_awal', 'tanggal_akhir', 'lokasi')->get();

        $formatted = $events->map(function ($event) {
            $start = \Carbon\Carbon::createFromFormat('d-m-Y', $event->tanggal_awal)->format('Y-m-d');
            $end = \Carbon\Carbon::createFromFormat('d-m-Y', $event->tanggal_akhir)->format('Y-m-d');

            return [
                'title' => $event->event . ' (' . $event->lokasi . ')',
                'start' => $start,
                'end' => $end,
                'color' => '#7D2A26',
            ];
        });

        return response()->json($formatted);
    }


    // public function siswaData(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = Siswa::select(['id', 'nama', 'tanggal_lahir', 'umur', 'alamat', 'email', 'no_telp', 'kelas']);
    //         return DataTables::of($data)->make(true);
    //     }
    // }
}
