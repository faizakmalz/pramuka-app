<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kenaikan Golongan Pramuka
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6 mt-6">

                <!-- Notifikasi Success -->
                @if (session('success'))
                    <div class="text-green-700 mb-4 p-4 bg-green-100 rounded-md flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Notifikasi Error -->
                @if ($errors->any())
                    <div class="text-red-700 mb-4 p-4 bg-red-100 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h1 class="text-lg font-bold mb-1">Form Kenaikan Golongan</h1>
                <p class="text-sm text-gray-600 mb-6">Pilih anggota yang akan dinaikkan golongannya dan isi detailnya. Sertifikat akan otomatis dibuat setelah disimpan.</p>

                <form id="formKenaikan" action="{{ route('kenaikan.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Nama Anggota -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota</label>
                            <select id="anggotaSelect" name="nomor_anggota"
                                    class="border-gray-300 rounded-md shadow-sm w-full focus:ring-2 focus:ring-[#610a08]">
                                <option value="">-- Pilih Anggota --</option>
                                @foreach($anggota as $a)
                                    <option value="{{ $a->nomor_anggota }}"
                                            data-golongan="{{ $a->golongan_pramuka }}">
                                        {{ $a->nama }} ({{ $a->nomor_anggota }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Golongan Sekarang -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Golongan Sekarang</label>
                            <input id="golonganSekarang" type="text" name="golongan_awal"
                                   class="border-gray-300 rounded-md shadow-sm w-full bg-gray-100 cursor-not-allowed"
                                   placeholder="Otomatis terisi saat memilih anggota"
                                   readonly>
                        </div>

                        <!-- Golongan Tujuan -->
                        <div class="mb-4" x-data="{
                            golongan: '{{ old('golongan_pramuka') }}',
                            tingkat: '',
                            tingkatOptions: [],
                            golonganOptions: {
                                'Siaga': ['Mula', 'Bantu', 'Tata'],
                                'Penggalang': ['Ramu', 'Rakit', 'Terap'],
                                'Penegak': ['Bantara', 'Laksana'],
                                'Pandega': ['Pandega'],
                                'Pembina': ['Pembina']
                            },
                            init() {
                                this.updateTingkatOptions();
                            },
                            updateTingkatOptions() {
                                this.tingkatOptions = this.golonganOptions[this.golongan] || [];
                                this.tingkat = '';
                            },
                            combineGolonganTingkat() {
                                return this.golongan && this.tingkat ? `${this.golongan} - ${this.tingkat}` : '';
                            }
                        }">
                            <label for="golongan_pramuka" class="block text-sm font-medium text-gray-700 mb-1">Golongan Tujuan</label>
                            <select name="golongan_pramuka" id="golongan_pramuka"
                                    x-model="golongan" @change="updateTingkatOptions()"
                                    class="w-full border rounded px-3 py-2 @error('golongan_pramuka') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                <option value="">-- Pilih Golongan --</option>
                                <template x-for="(tingkatList, golongan) in golonganOptions" :key="golongan">
                                    <option :value="golongan" x-text="golongan"></option>
                                </template>
                            </select>
                            @error('golongan_pramuka')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <label for="tingkat_pramuka" class="block text-sm font-medium text-gray-700 mb-1 mt-4">Tingkat Tujuan</label>
                            <select name="tingkat_pramuka" id="tingkat_pramuka"
                                    x-model="tingkat"
                                    class="w-full border rounded px-3 py-2 @error('tingkat_pramuka') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                <option value="">-- Pilih Tingkat --</option>
                                <template x-for="tingkat in tingkatOptions" :key="tingkat">
                                    <option :value="tingkat" x-text="tingkat"></option>
                                </template>
                            </select>
                            @error('tingkat_pramuka')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <input type="hidden" name="golongan_tujuan" :value="combineGolonganTingkat()">
                        </div>

                        <!-- Tanggal Kenaikan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kenaikan</label>
                            <input type="date" name="tanggal_kenaikan"
                                   class="border-gray-300 rounded-md shadow-sm w-full focus:ring-2 focus:ring-[#610a08]"
                                   value="{{ old('tanggal_kenaikan') }}">
                        </div>

                        <!-- Nomor Sertifikat -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor Sertifikat
                                <span class="text-gray-400 font-normal text-xs ml-1">(kosongkan untuk generate otomatis)</span>
                            </label>
                            <div class="flex gap-2">
                                <input type="text" name="nomor_sertifikat" id="nomorSertifikat"
                                       class="border-gray-300 rounded-md shadow-sm w-full focus:ring-2 focus:ring-[#610a08] font-mono @error('nomor_sertifikat') border-red-500 @enderror"
                                       placeholder="Contoh: SERT-2025-0001"
                                       value="{{ old('nomor_sertifikat') }}">
                            </div>
                            @error('nomor_sertifikat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 mt-1">Format otomatis: SERT-{TAHUN}-{URUTAN}</p>
                        </div>

                        <!-- Catatan -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea name="catatan" rows="3"
                                      class="border-gray-300 rounded-md shadow-sm w-full focus:ring-2 focus:ring-[#610a08]"
                                      placeholder="Catatan tambahan mengenai kenaikan golongan ini...">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-[#C5922B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Sertifikat PDF akan otomatis dibuat saat menyimpan
                        </div>
                        <x-primary-button type="submit">
                            Simpan & Buat Sertifikat
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Riwayat Kenaikan -->
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg mt-8 p-6">
                <h2 class="font-bold text-lg mb-4">Riwayat Kenaikan Golongan</h2>
                <div class="overflow-x-auto">
                    <table id="kenaikanTable" class="custom-datatable w-full text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">No. Anggota</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Dari</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Ke</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">No. Sertifikat</th>
                                <th class="px-4 py-3 font-semibold text-gray-600">Catatan</th>
                                <th class="px-4 py-3 font-semibold text-gray-600 text-center">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $item)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium">{{ $item->anggota->nama }}</td>
                                    <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $item->nomor_anggota }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 text-xs font-medium">
                                            {{ $item->golongan_awal }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
                                            {{ $item->golongan_tujuan }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kenaikan)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->nomor_sertifikat)
                                            <span class="font-mono text-xs text-gray-700">{{ $item->nomor_sertifikat }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 max-w-xs truncate">
                                        {{ $item->catatan ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($item->nomor_sertifikat)
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="{{ route('kenaikan.sertifikat.show', $item->nomor_sertifikat) }}"
                                                   target="_blank"
                                                   title="Lihat Sertifikat"
                                                   class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-blue-50 text-blue-700 hover:bg-blue-100 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    Lihat
                                                </a>
                                                <a href="{{ route('kenaikan.sertifikat.download', $item->nomor_sertifikat) }}"
                                                   title="Download Sertifikat"
                                                   class="inline-flex items-center gap-1 px-2 py-1 text-xs rounded bg-green-50 text-green-700 hover:bg-green-100 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Unduh
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const anggotaSelect = document.getElementById('anggotaSelect');
            const golonganSekarang = document.getElementById('golonganSekarang');

            anggotaSelect.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                golonganSekarang.value = selected.getAttribute('data-golongan') || '';
            });
        });
    </script>
    @endpush
</x-app-layout>