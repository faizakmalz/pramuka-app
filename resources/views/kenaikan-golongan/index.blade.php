<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kenaikan Golongan Pramuka
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 mt-6">

                <h1 class="text-lg font-bold mb-4">Form Kenaikan Golongan</h1>
                <p class="text-sm text-gray-600 mb-6">Pilih anggota yang akan dinaikkan golongannya dan isi detailnya.</p>

                <form id="formKenaikan" action="{{ route('kenaikan.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Nama Anggota -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota</label>
                            <select id="anggotaSelect" name="nomor_anggota" class="border-gray-300 rounded-md shadow-sm w-full">
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($anggota as $a)
                                    <option value="{{ $a->nomor_anggota }}" data-golongan="{{ $a->golongan_pramuka }}">
                                        {{ $a->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Golongan Sekarang -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Golongan Sekarang</label>
                            <input id="golonganSekarang" type="text" name="golongan_awal" class="border-gray-300 rounded-md shadow-sm w-full bg-gray-100" readonly>
                        </div>

                        <!-- Golongan Tujuan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Naik Ke Golongan</label>
                            <select id="golonganTujuan" name="golongan_tujuan" class="border-gray-300 rounded-md shadow-sm w-full">
                                <option value="">-- Pilih Golongan Tujuan --</option>
                                <option value="Siaga">Siaga</option>
                                <option value="Penggalang">Penggalang</option>
                                <option value="Penegak">Penegak</option>
                                <option value="Pandega">Pandega</option>
                                <option value="Pembina">Pembina</option>
                            </select>
                        </div>

                        <!-- Tanggal Kenaikan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kenaikan</label>
                            <input type="date" name="tanggal_kenaikan" class="border-gray-300 rounded-md shadow-sm w-full">
                        </div>

                        <!-- Catatan -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                            <textarea name="catatan" rows="3" class="border-gray-300 rounded-md shadow-sm w-full"></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button type="submit">
                            Simpan
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Riwayat Kenaikan -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mt-8 p-6">
                <h2 class="font-bold text-lg mb-4">Riwayat Kenaikan Golongan</h2>
                <table id="kenaikanTable" class="custom-datatable w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Dari</th>
                            <th class="px-4 py-2">Ke</th>
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat as $item)
                            <tr>
                                <td class="px-4 py-2">{{ $item->anggota->nama }}</td>
                                <td class="px-4 py-2">{{ $item->golongan_awal }}</td>
                                <td class="px-4 py-2">{{ $item->golongan_tujuan }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_kenaikan)->format('d-m-Y') }}</td>
                                <td class="px-4 py-2">{{ $item->catatan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Autofill golongan sekarang saat anggota dipilih
            const anggotaSelect = document.getElementById('anggotaSelect');
            const golonganSekarang = document.getElementById('golonganSekarang');
            anggotaSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                golonganSekarang.value = selected.getAttribute('data-golongan') || '';
            });
        });

        document.querySelector("#formKenaikan").addEventListener("submit", function() {
            console.log("Form submitted!");
        });
    </script>
    @endpush
</x-app-layout>
