<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex flex-col gap-4">
        <div class="pt-12">            
            <div class="flex flex-col gap-4 mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4">
                    <h1 class="font-bold text-[24px] pl-2">Dashboard SIMP</h1>
                    {{-- === Rekomendasi Kegiatan Hari Ini === --}}
                    <div class="relative bg-gradient-to-br from-[#7D2A26] via-[#8B3A2A] to-[#B45B3E] text-white rounded-2xl shadow-md overflow-hidden">
                        {{-- Overlay Pattern --}}
                        <div class="absolute inset-0 opacity-10 bg-[url('https://www.toptal.com/designers/subtlepatterns/uploads/patternpad.png')]"></div>

                        <div class="p-6 relative z-10 flex flex-col gap-3">
                            <h3 class="text-lg font-bold uppercase tracking-wide">Rekomendasi Kegiatan Hari Ini</h3>
                            <p class="text-sm text-gray-100 leading-relaxed">
                                Untuk menjaga semangat pramuka, berikut kegiatan yang bisa dilakukan hari ini:
                            </p>

                            <ul class="mt-3 space-y-2 text-sm">
                                <li class="flex items-center gap-2">
                                    <span class="bg-white/20 p-2 rounded-lg"><i class="fa-solid fa-person-hiking"></i></span>
                                    <span><span class="font-semibold">Latihan Baris-Berbaris</span> — 30 menit pemanasan pagi.</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="bg-white/20 p-2 rounded-lg"><i class="fa-solid fa-tree"></i></span>
                                    <span><span class="font-semibold">Menanam Pohon</span> — tanam 1 pohon di lingkungan sekitar sekolah.</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="bg-white/20 p-2 rounded-lg"><i class="fa-solid fa-handshake-angle"></i></span>
                                    <span><span class="font-semibold">Gotong Royong</span> — bantu teman membersihkan area tenda.</span>
                                </li>
                            </ul>

                            <p class="mt-4 text-xs text-gray-200 italic">
                                "Kedisiplinan dimulai dari tindakan kecil setiap hari."
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <h1 class="font-bold text-lg pl-2">Jumlah Anggota</h1>
                        <p class="text-sm text-gray-600 mb-1 pl-2">Berdasarkan Golongan Pramuka</p>

                        <div id="golonganLoading" class="flex justify-center items-center py-6 text-gray-500">
                            <div class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5 text-[#7D2A26]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4l-3 3 3 3H4z">
                                    </path>
                                </svg>
                                <span>Memuat data golongan...</span>
                            </div>
                        </div>
                        
                        <div id="golonganContainer" class="flex flex-wrap gap-4 w-full mb-2 hidden">
                        </div>
                    </div>
                    <!-- <div class="flex flex-col gap-1">
                        <h1 class="font-bold text-lg">Abensi Siswa</h1>
                        <div class="flex gap-4 w-full">
                            <div class="flex flex-col flex-1 justify-center p-6 bg-white shadow-sm sm:rounded-lg">
                                <p class="text-[30px] font-black text-gray-900 w-full">
                                101 
                                </p>
                                <p>Hadir</p>
                            </div>
                            <div class="flex flex-col flex-1 justify-center p-6 bg-white shadow-sm sm:rounded-lg">
                                <p class="text-[30px] font-black text-gray-900 w-full">
                                101 
                                </p>
                                <p>Tidak Hadir</p>
                            </div>
                            <div class="flex flex-col flex-1 justify-center p-6 bg-white shadow-sm sm:rounded-lg">
                                <p class="text-[30px] font-black text-gray-900 w-full">
                                60 
                                </p>
                                <p>Izin</p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

        <!-- Anggota -->
        <div class="sm:px-6 lg:px-8 mb-10">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg p-6 flex flex-col">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl w-[300px] text-gray-800 leading-tight">Data Anggota</h2>
                    <x-primary-button class="max-w-48" onclick="window.location='{{ route('anggota') }}'"> Semua anggota </x-primary-button>
                </div>
               <div class="custom-datatable-wrapper">
                    <div id="anggotaLoading" class="flex justify-center items-center py-6 text-gray-500">
                        <div class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-[#7D2A26]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4l-3 3 3 3H4z">
                                </path>
                            </svg>
                            <span>Memuat data anggota...</span>
                        </div>
                    </div>
                    <table id="guruTable" class="custom-datatable w-full text-left hidden">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Nomor Anggota <span class="dt-sort-icon ml-2 text-left inline-block"></span></th>
                                <th class="px-4 py-2">Nama <span class="dt-sort-icon ml-2 inline-block"></span></th>
                                <th class="px-4 py-2">Jenis Kelamin <span class="dt-sort-icon ml-2 inline-block"></span></th>
                                <th class="px-4 py-2">Agama <span class="dt-sort-icon ml-2 inline-block"></span></th>
                                <th class="px-4 py-2">Golongan Pramuka <span class="dt-sort-icon ml-2 inline-block"></span></th>
                                <th class="px-4 py-2">Golongan Darah <span class="dt-sort-icon ml-2 inline-block"></span></th>
                                <th class="px-4 py-2">Alamat <span class="dt-sort-icon ml-2 inline-block"></span></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col pl-2 my-4">
                <h1 class="font-bold text-lg">Kalender Kegiatan Pramuka</h1>
                <p class="text-sm text-gray-600 mb-4">Lihat kegiatan pramuka bulan ini</p>

                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl p-6">
                    <div id="dashboardCalendar"></div>
                </div>
            </div>
        </div>

        <!-- Siswas -->
        <!-- <div class="sm:px-6 lg:px-8 mb-10">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Siswa</h2>
                </div>
                <div class="custom-datatable-wrapper">
                    <table id="siswaTable" class="custom-datatable w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 w-40">
                                    Nama 
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                                <th class="px-4 py-2 w-56">
                                    Email 
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                                <th class="px-4 py-2 w-40">
                                    Umur 
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                                <th class="px-4 py-2 w-48">
                                    Tanggal Lahir 
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                                <th class="px-4 py-2 w-40">
                                    Alamat
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                                <th class="px-4 py-2 w-40">
                                    No. Hp 
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                                <th class="px-4 py-2 w-24 text-center">
                                    Kelas 
                                    <span class="dt-sort-icon ml-2 inline-block"></span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
    </div>
    @push('scripts')
     {{-- FullCalendar & DataTables --}}
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabelAnggota = $('#guruTable');
            const anggotaLoading = document.getElementById('anggotaLoading');
            const guruTable = tabelAnggota.DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ url('/dashboard/anggota') }}',
                    dataSrc: function (json) {
                        anggotaLoading.style.display = 'none';
                        tabelAnggota.removeClass('hidden');
                        return json.data;
                    },
                    error: function () {
                        anggotaLoading.innerHTML = '<span class="text-red-500">Gagal memuat data anggota.</span>';
                    }
                },
                language: {
                processing: "",
                },
                preDrawCallback: function() {
                    // sembunyikan loading default (yang biasanya muncul di tengah)
                    $('.dataTables_processing').hide();
                },
                columns: [
                    { data: 'nomor_anggota', orderable:false, className: 'text-center w-[20px]',  render: data => `<span class="font-mono text-sm text-center">${data}</span>` },
                    { data: 'nama', orderable:false, render: data => `<span class="font-medium text-gray-900">${data}</span>` },
                    { data: 'jenis_kelamin', orderable:false, render: data => `<span class="text-gray-700">${data || '-'}</span>` },
                    { data: 'agama', orderable:false, render: data => `<span class="font-medium text-gray-90">${data || '-'}</span>` },
                    { data: 'golongan_pramuka', orderable:false, render: data => `<span class="px-2 py-1 text-xs bg-red-500 text-red-100 rounded">${data}</span>` },
                    { data: 'golongan_darah', orderable:false, render: data => `<span class="px-2 py-1 text-xs bg-red-100 text-red-500 rounded">${data}</span>` },
                    { data: 'alamat', orderable:false, render: data => `<span class="font-mono text-sm">${data}</span>` },
                ],
                // paging: true,
                lengthChange: false,
                searching: false,
                pageLength: 10,
                dom: 'rt',
            });

            fetch('{{ url('/dashboard/golongan-counts') }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('golonganContainer');
                container.innerHTML = '';
                document.getElementById('golonganLoading').style.display = 'none';
                container.classList.remove('hidden');

                const allGolongan = ['Siaga', 'Penggalang', 'Penegak', 'Pandega', 'Pembina'];
                const colors = {
                    'Siaga': { bg: '#F4E4E2', text: '#610A08' },
                    'Penggalang': { bg: '#D9A19C', text: '#3C0604' },
                    'Penegak': { bg: '#A44D47', text: '#FFF1F0' },
                    'Pandega': { bg: '#7D2A26', text: '#FFF7F6' },
                    'Pembina': { bg: '#610A08', text: '#FDE8E7' },
                };

                const countMap = {};
                data.forEach(item => {
                    countMap[item.golongan_pramuka] = item.total;
                });

                allGolongan.forEach(gol => {
                    const total = countMap[gol] || 0;
                    const color = colors[gol];

                    const card = document.createElement('div');
                    card.className = "flex flex-col flex-1 min-w-[120px] mt-2 justify-center p-6 sm:rounded-2xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1";
                    card.style.backgroundColor = color.bg;
                    card.style.color = color.text;

                    const numberEl = document.createElement('p');
                    numberEl.className = "text-[32px] font-black text-center";
                    numberEl.textContent = "0";

                    const labelEl = document.createElement('p');
                    labelEl.className = "text-center font-semibold";
                    labelEl.textContent = gol;

                    card.appendChild(numberEl);
                    card.appendChild(labelEl);
                    container.appendChild(card);

                    let current = 0;
                    const increment = Math.ceil(total / 40);
                    const interval = setInterval(() => {
                        current += increment;
                        if (current >= total) {
                            current = total;
                            clearInterval(interval);
                        }
                        numberEl.textContent = current;
                    }, 30);
                });
            })
            .catch(err => {
                console.error('Error fetching golongan counts:', err);
            });
            
            const calendarEl = document.getElementById('dashboardCalendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 450,
                themeSystem: 'standard',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                displayEventTime: false,
                events: '{{ url('/dashboard/events') }}',
                eventColor: '#610A08',
                eventTextColor: '#FDE8E7',
                eventDisplay: 'block',
                eventDidMount: function(info) {
                    info.el.style.borderRadius = '8px';
                    info.el.style.fontWeight = '600';
                }
            });
            calendar.render();

            document.getElementById('guruSearch').addEventListener('keyup', function () {
                guruTable.search(this.value).draw();
            });
        });
    </script>
    @endpush
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
    </style>
</x-app-layout>
