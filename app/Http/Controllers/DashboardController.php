<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    //
    // public function index()
    // {
    //     return view('dashboard');
    // }

    public function index() {
    dd('Masuk Controller');
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

        // Extract kata pertama sebelum " - " di query
        $counts = Anggota::selectRaw("
                SUBSTRING_INDEX(golongan_pramuka, ' - ', 1) as golongan_base,
                COUNT(*) as total
            ")
            ->groupBy('golongan_base')
            ->pluck('total', 'golongan_base')
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
       $events = DB::table('events')
        ->select('event', 'lokasi', 'tanggal_awal', 'tanggal_akhir')
        ->get();

        $formatted = $events->map(function ($event) {
            // Cukup ubah string dikit, jangan buat objek Carbon kalau gak perlu
            $start = date('Y-m-d', strtotime($event->tanggal_awal));
            $end = date('Y-m-d', strtotime($event->tanggal_akhir));

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
