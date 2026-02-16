<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Anggota') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Tombol Actions -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 mb-4">
                <x-primary-button class="w-full sm:w-auto justify-center" onclick="window.location='{{ route('anggota.create') }}'">
                    {{ __('+ Tambah Anggota') }}
                </x-primary-button>
                
                <div x-data="{ open: false }">
                    <x-primary-button class="w-full sm:w-auto justify-center" @click="open = true">
                        {{ __('Import XLSX') }}
                    </x-primary-button>

                    {{-- Modal Import --}}
                    <div 
                        x-show="open"
                        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 p-4"
                        x-cloak
                        @click.self="open = false"
                    >
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h2 class="text-lg font-semibold mb-4">Import Anggota dari Excel</h2>

                            <form action="{{ route('anggota.import') }}" method="POST" enctype="multipart/form-data" x-data="{ fileName: '' }">
                                @csrf
                                <label for="file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6h.1a5 5 0 010 10h-1"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag & drop</p>
                                        <p class="text-xs text-gray-400">XLSX, XLS, or CSV</p>
                                    </div>
                                    <input id="file" type="file" name="file" class="hidden" @change="fileName = $event.target.files[0]?.name" required />
                                </label>

                                <template x-if="fileName">
                                    <p class="mt-2 text-sm text-gray-600">File selected: <span class="font-medium" x-text="fileName"></span></p>
                                </template>

                                <div class="flex justify-end gap-2 mt-4">
                                    <x-secondary-button type="button" @click="open = false">Batal</x-secondary-button>
                                    <x-primary-button type="submit">Import Anggota</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div x-data="{ openExport: false }">
                    <x-primary-button class="w-full sm:w-auto justify-center" @click="openExport = true">
                        {{ __('Export Excel') }}
                    </x-primary-button>

                    {{-- Modal Export --}}
                    <div
                        x-show="openExport"
                        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 p-4"
                        x-cloak
                        @click.self="openExport = false"
                    >
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h2 class="text-lg font-semibold mb-1">Export Data Anggota</h2>
                            <p class="text-sm text-gray-500 mb-4">Data akan diunduh dalam format .xlsx</p>

                            <form id="formExport" action="{{ route('anggota.export') }}" method="GET">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Filter Golongan Pramuka
                                        <span class="text-gray-400 font-normal">(opsional)</span>
                                    </label>
                                    <select name="golongan_pramuka"
                                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#610a08] focus:border-transparent">
                                        <option value="">Semua Golongan</option>
                                        <option value="Siaga - Mula">Siaga - Mula</option>
                                        <option value="Siaga - Bantu">Siaga - Bantu</option>
                                        <option value="Siaga - Tata">Siaga - Tata</option>
                                        <option value="Penggalang - Ramu">Penggalang - Ramu</option>
                                        <option value="Penggalang - Rakit">Penggalang - Rakit</option>
                                        <option value="Penggalang - Terap">Penggalang - Terap</option>
                                        <option value="Penegak - Bantara">Penegak - Bantara</option>
                                        <option value="Penegak - Laksana">Penegak - Laksana</option>
                                        <option value="Pandega - Pandega">Pandega - Pandega</option>
                                        <option value="Pembina - Pembina">Pembina - Pembina</option>
                                    </select>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <x-secondary-button type="button" @click="openExport = false">
                                        Batal
                                    </x-secondary-button>
                                    <x-primary-button type="submit" @click="openExport = false">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download Excel
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6">
                    <!-- Search & Filter -->
                    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                            <div class="relative w-full sm:w-auto">
                                <input type="text" id="searchGuru" placeholder="Search..." 
                                       class="w-full sm:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#610a08] focus:border-transparent">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <select id="filterMapel" 
                                    class="w-full sm:w-64 border rounded-lg px-3 py-2 border-gray-300 focus:ring-2 focus:ring-[#610a08] focus:border-transparent">
                                <option value="">Semua Golongan Pramuka</option>
                            </select>
                        </div>
                    </div>

                    <!-- Table Wrapper dengan Scroll Horizontal -->
                    <div class="custom-datatable-wrapper">
                        <table id="guruTable" class="custom-datatable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Nomor Anggota</th>
                                    <th class="px-4 py-3">Nama</th>
                                    <th class="px-4 py-3">NIK</th>
                                    <th class="px-4 py-3">Jenis Kelamin</th>
                                    <th class="px-4 py-3">Golongan Pramuka</th>
                                    <th class="px-4 py-3">Golongan Darah</th>
                                    <th class="px-4 py-3">Tempat/Tgl Lahir</th>
                                    <th class="px-4 py-3">No. Telp</th>
                                    <th class="px-4 py-3 text-center">KTA</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        
                        <!-- Loading Indicator -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }

        .custom-datatable-wrapper {
            background: white;
            border-radius: 8px;
            width: 100%;
            overflow-x: auto;
            overflow-y: visible;
            -webkit-overflow-scrolling: touch;
            border: 1px solid #e5e7eb;
            position: relative;
        }

        /* Indicator scroll shadow */
        .custom-datatable-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            width: 30px;
            background: linear-gradient(to left, rgba(255,255,255,0.9), transparent);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .custom-datatable-wrapper:not(.scrolled-end)::after {
            opacity: 1;
        }

        .custom-datatable {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 900px;
        }

        .custom-datatable thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e5e7eb;
        }

        .custom-datatable thead th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #374151;
            white-space: nowrap;
            position: sticky;
            top: 0;
            background: #f8fafc;
            z-index: 10;
        }

        .custom-datatable tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.15s ease;
        }

        .custom-datatable tbody tr:hover {
            background-color: #f9fafb;
        }

        .custom-datatable tbody td {
            padding: 12px 16px;
            font-size: 13px;
            color: #111827;
            vertical-align: middle;
        }

        /* Kolom aksi & KTA - sticky di kanan */
        .custom-datatable thead th:nth-last-child(-n+2),
        .custom-datatable tbody td:nth-last-child(-n+2) {
            position: sticky;
            right: 0;
            background: white;
            z-index: 5;
            box-shadow: -2px 0 5px rgba(0,0,0,0.05);
        }

        .custom-datatable thead th:nth-last-child(-n+2) {
            background: #f8fafc;
            z-index: 15;
        }

        .custom-datatable tbody tr:hover td:nth-last-child(-n+2) {
            background-color: #f9fafb;
        }

        /* Dropdown positioning fix */
        .custom-datatable tbody td:last-child {
            overflow: visible;
        }

        /* DataTables overrides */
        .dataTables_wrapper {
            overflow: visible !important;
        }

        .dataTables_scrollBody {
            overflow: visible !important;
        }

        .dataTables_length,
        .dataTables_filter,
        .dataTables_info {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            margin-top: 20px;
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: none !important;
            background: #f3f4f6;
            color: #374151 !important;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #610a08 !important;
            color: white !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #7D2A26 !important;
            color: white !important;
            font-weight: 600;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        #guruTable th,
        #guruTable td {
            text-align: left !important;
        }

        #guruTable thead th.sorting:after,
        #guruTable thead th.sorting_asc:after,
        #guruTable thead th.sorting_desc:after {
            display: none !important;
        }

        /* Responsive: pada mobile, hint untuk scroll */
        @media (max-width: 768px) {
            .custom-datatable-wrapper::before {
                content: '← Geser untuk melihat lebih banyak →';
                display: block;
                text-align: center;
                padding: 8px;
                background: #fef3c7;
                color: #92400e;
                font-size: 12px;
                border-bottom: 1px solid #fde68a;
            }
        }
    </style>

    @vite(['resources/js/anggota.js'])
</x-app-layout>