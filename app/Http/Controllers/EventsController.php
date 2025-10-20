<?php

namespace App\Http\Controllers;

use \Carbon\Carbon;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    //
    public function index()
    {
        $events = Event::all();
        return view('event.index', compact('events'));
    }

    public function create()
    {
        return view('event.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event' => 'required|string',
            'deskripsi' => 'required|string',
            'tanggal_awal' => 'required|string',
            'tanggal_akhir' => 'required|string',
            'lokasi' => 'required|string',
            'peserta' => 'required|string'
        ]);

        $validated['tanggal_awal'] = Carbon::parse($validated['tanggal_awal'])->format('d-m-Y');
        $validated['tanggal_akhir'] = Carbon::parse($validated['tanggal_akhir'])->format('d-m-Y');

        Event::create($validated);
        return redirect()->route('jadwal-event');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('event.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'peserta' => 'required|string|max:255',
        ]);

        $event = Event::findOrFail($id);

        $validated['tanggal_awal'] = Carbon::parse($validated['tanggal_awal'])->format('d-m-Y');
        $validated['tanggal_akhir'] = Carbon::parse($validated['tanggal_akhir'])->format('d-m-Y');

        $event->update($validated);

        return redirect()->route('jadwal-event')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return response()->json(['success' => true]);
    }

    public function getEvents()
    {
        $events = Event::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->event,
                'start' => Carbon::createFromFormat('d-m-Y', $event->tanggal_awal)->format('Y-m-d'),
                'end'   => Carbon::createFromFormat('d-m-Y', $event->tanggal_akhir)->addDay()->format('Y-m-d'),
                'description' => $event->deskripsi,
                'lokasi' => $event->lokasi,
                'peserta' => $event->peserta,
            ];
        });

        return response()->json($events);
    }

}
