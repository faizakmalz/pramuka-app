<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Event Pramuka</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        .fc-event { cursor: pointer; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-br from-[#7D2A26] via-[#8B3A2A] to-[#B45B3E] text-white shadow-md">
            <div class="max-w-6xl mx-auto px-6 py-6">
                <div class="flex items-center gap-4">
                    <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200"
                         alt="Logo Pramuka" class="w-16 h-16 object-contain bg-white rounded-full p-2">
                    <div>
                        <h1 class="text-2xl font-bold">Kalender Event Pramuka</h1>
                        <p class="text-sm text-gray-200 mt-1">Lihat jadwal kegiatan pramuka bulan ini</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div id="calendar"></div>
            </div>

            <!-- Back to Login -->
            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#610a08] text-white rounded-lg hover:bg-[#7D2A26] transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    Kembali ke Halaman Login
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    list: 'Daftar'
                },
                locale: 'id',
                displayEventTime: true,
                events: '{{ url('/events/data') }}',
                eventColor: '#610A08',
                eventTextColor: '#FDE8E7',
                eventDisplay: 'block',
                eventDidMount: function(info) {
                    info.el.style.borderRadius = '6px';
                    info.el.style.fontWeight = '600';
                },
                eventClick: function(info) {
                    const event = info.event;
                    const desc = event.extendedProps.description || 'Tidak ada deskripsi';
                    const loc = event.extendedProps.location || 'Tidak ada lokasi';
                    
                    alert(
                        `📅 ${event.title}\n\n` +
                        `📍 Lokasi: ${loc}\n` +
                        `📝 Deskripsi: ${desc}\n\n` +
                        `🕒 Mulai: ${event.start.toLocaleString('id-ID')}\n` +
                        (event.end ? `🕒 Selesai: ${event.end.toLocaleString('id-ID')}` : '')
                    );
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>