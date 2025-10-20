<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Event Baru
        </h2>
    </x-slot>

    <div class="px-10 mt-10">
        <div class="flex gap-4">                
            <div class="bg-white p-6 rounded-lg shadow-md flex-1">
                <h3 class="font-semibold text-lg mb-3">Kalender Kegiatan</h3>
                <p class="text-sm text-gray-500 mb-4">Klik atau pilih tanggal di kalender untuk mengisi tanggal mulai & selesai secara otomatis.</p>
                <div id="calendar"></div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md w-full flex-1">
                <form method="POST" action="{{ route('event.store') }}" id="eventForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Nama Kegiatan</label>
                        <input type="text" name="event" class="w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Deskripsi</label>
                        <textarea name="deskripsi" class="w-full border-gray-300 rounded-md" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_awal" id="tanggal_awal" class="w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Lokasi</label>
                        <input type="text" name="lokasi" class="w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold mb-1">Peserta</label>
                        <input type="text" name="peserta" class="w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('jadwal-event') }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300">
                            Batal
                        </a>
                        <x-primary-button>
                            Simpan Event
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>

    {{-- FullCalendar script --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const startInput = document.getElementById('start');
            const endInput = document.getElementById('end');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 550,
                selectable: true,
                events: '/events',
                eventColor: '#610A08',
                eventTextColor: '#FDE8E7',
                eventDisplay: 'block',
                select: function(info) {
                    startInput.value = info.startStr;
                    endInput.value = info.endStr;
                },
                eventClick: function(info) {
                    alert(`Event: ${info.event.title}\nTanggal: ${info.event.start.toISOString().slice(0,10)}`);
                },
            });

            calendar.render();
        });
    </script>
</x-app-layout>
