<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kalender & Data Event Pramuka
        </h2>
    </x-slot>

    <div class="pt-6 flex flex-col">
        <div class="sm:px-6 lg:px-8 mb-10">
            <div class="pl-2 h-32 flex justify-between items-center">
                <div>
                    <h1 class="font-bold text-lg">Kalender Kegiatan Pramuka</h1>
                    <p>Jadwal Keseluruhan Kegiatan Pramuka</p>
                </div>
                <div>
                    <x-primary-button onclick="window.location='{{ route('event.create') }}'" class="w-[300px] block text-center">
                        {{ __('+ Buat Event Baru') }}
                    </x-primary-button>
                </div>
            </div>

            {{-- Kalender --}}
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 mb-10">
                <div id="calendar"></div>
            </div>

            {{-- DataTable Event --}}
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" id="searchEvent" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#610a08] focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="custom-datatable-wrapper">
                    <table id="eventTable" class="custom-datatable w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Nama Event</th>
                                <th class="px-4 py-2">Deskripsi</th>
                                <th class="px-4 py-2">Tanggal Awal</th>
                                <th class="px-4 py-2">Tanggal Akhir</th>
                                <th class="px-4 py-2">Lokasi</th>
                                <th class="px-4 py-2">Peserta</th>
                                <th class="px-4 py-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- FullCalendar & DataTables --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    @vite(['resources/js/event.js'])

    <style>
        .custom-datatable-wrapper { background: white; border-radius: 8px; overflow: hidden; }
        .custom-datatable { width: 100% !important; border-collapse: separate; border-spacing: 0; }
        .custom-datatable thead tr { background: #f8fafc; border-bottom: 1px solid #e5e7eb; }
        .custom-datatable thead th { padding: 16px 20px; text-align: left; font-weight: 600; font-size: 14px; color: #374151; white-space: nowrap; }
        .custom-datatable tbody tr { border-bottom: 1px solid #f3f4f6; transition: background-color 0.15s ease; }
        .custom-datatable tbody tr:hover { background-color: #f9fafb; }
        .custom-datatable tbody td { padding: 16px 20px; font-size: 14px; color: #111827; vertical-align: middle; }
        .dataTables_length, .dataTables_filter, .dataTables_info { display: none !important; }
        .dataTables_wrapper .dataTables_paginate { margin-top: 20px; text-align: center; }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: none !important;
            background: #f3f4f6;
            color: #374151 !important;
            border-radius: 9999px;
            padding: 0.5rem 0.9rem;
            margin: 0 0.2rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #3b82f6 !important;
            color: white !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #2563eb !important;
            color: white !important;
            font-weight: 600;
        }
        #eventTable th, #guruTable td { text-align: left !important; }
        #eventTable thead th.sorting:after, #eventTable thead th.sorting_asc:after, #eventTable thead th.sorting_desc:after { display: none !important; }
    </style>
</x-app-layout>
