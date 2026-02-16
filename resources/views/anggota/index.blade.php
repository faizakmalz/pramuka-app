<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Anggota') }}
        </h2>
    </x-slot>

    <div class="pt-6 flex flex-col">
        <div class="flex items-center justify-end gap-3 pr-8 pb-4 w-full">
            <div x-data="{ open: false }" class="flex gap-3">
                <div class="flex flex-wrap items-center justify-end gap-3">
                    <x-primary-button class="w-[300px] block text-center" onclick="window.location='{{ route('anggota.create') }}'">
                    {{ __('+ Tambah Anggota') }}
                    </x-primary-button>
                    <x-primary-button class="w-[300px] block text-center" @click="open = true">
                        {{ __('Import XLSX') }}
                    </x-primary-button>
                    <div x-data="{ openExport: false }">
                    <x-primary-button class="w-[300px] block text-center" @click="openExport = true">
                        {{ __('Export Excel') }}
                    </x-primary-button>
                </div>

                {{-- Modal Export --}}
                <div
                    x-show="openExport"
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50"
                    x-cloak
                >
                    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
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
                                    {{-- Opsi golongan di-populate via JS dari data yang sudah ada --}}
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

                <div 
                    x-show="open"
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50"
                    x-cloak
                >
                    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
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
        </div>

        <div class="sm:px-6 lg:px-8 mb-10">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input type="text" id="searchGuru" placeholder="Search..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#610a08] focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <select id="filterMapel" class="w-[250px] text-gray-300 border rounded-lg px-3 py-2 border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Golongan Pramuka</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="custom-datatable-wrapper">
                    <table id="guruTable" class="custom-datatable w-full text-left">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Nomor Anggota</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">NIK</th>
                            <th class="px-4 py-3">Jenis Kelamin</th>
                            <th class="px-4 py-3">Agama</th>
                            <th class="px-4 py-3">Golongan Pramuka</th>
                            <th class="px-4 py-3">Golongan Darah</th>
                            <th class="px-4 py-3">Alamat</th>
                            <th class="px-4 py-3">Tempat Lahir</th>
                            <th class="px-4 py-3">Tanggal Lahir</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">No. Telp</th>
                            <th class="px-4 py-3">Created At</th>
                            <th class="px-4 py-3">Updated At</th>
                            <th class="px-4 py-3 text-center">KTA</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                        <tbody></tbody>
                    </table>
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

    <div 
        x-data="{ openKta: false, pdfUrl: '' }" 
        x-show="openKta"
        x-cloak
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg shadow-xl w-[90%] max-w-3xl p-4 relative">
            <button @click="openKta = false" class="absolute top-2 right-2 px-3 py-1 bg-red-600 text-white rounded">✕</button>
            <iframe :src="pdfUrl" class="w-full h-[600px] border rounded"></iframe>
        </div>
    </div>

</div>


    <style>
        .custom-datatable-wrapper {
            background: white;
            border-radius: 8px;
            /* Kuncinya di sini: pastikan lebar maksimal adalah 100% dari sisa layar */
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border: 1px solid #e5e7eb;
        }

        /* Pastikan tabel tidak memaksa lebar container */
        .custom-datatable {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            /* min-width supaya kolom tidak terlalu sempit saat discroll */
            min-width: 1100px;
        }

        .custom-datatable thead tr {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
        }

        .custom-datatable thead th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #374151;
            white-space: nowrap;
            /* ✅ Sticky header opsional — uncomment kalau mau header ikut scroll vertikal */
            /* position: sticky; top: 0; background: #f8fafc; z-index: 1; */
        }

        .custom-datatable tbody tr {
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.15s ease;
        }
        /* Tambahan agar dropdown aksi tidak terpotong saat di ujung kanan */
        .custom-datatable tbody td:last-child {
            position: relative;
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

        /* ✅ Override dataTables default scroll wrapper supaya tidak clash */
        .dataTables_wrapper {
            overflow: visible !important;
        }

        .dataTables_scrollBody {
            overflow-x: auto !important;
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

        #guruTable th,
        #guruTable td {
            text-align: left !important;
        }

        #guruTable thead th.sorting:after,
        #guruTable thead th.sorting_asc:after,
        #guruTable thead th.sorting_desc:after {
            display: none !important;
        }

        /* Dropdown menu di dalam tabel tidak terpotong overflow */
        .custom-datatable tbody td {
            overflow: visible;
            position: relative;
        }
    </style>

    @vite(['resources/js/anggota.js'])
</x-app-layout>
