<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventsController extends Controller
{
    public function index()
    {
        return view('public.events');
    }

    public function getEvents()
    {
        $events = Event::all();

        $formattedEvents = $events->map(function ($event) {
            return [
                'title' => $event->name,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'color' => '#610A08',
                'extendedProps' => [
                    'description' => $event->description,
                    'location' => $event->location ?? 'Tidak ada lokasi',
                ],
            ];
        });

        return response()->json($formattedEvents);
    }
}