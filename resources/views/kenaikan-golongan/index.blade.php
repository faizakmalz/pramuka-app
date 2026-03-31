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

                @if (session('warning'))
                    <div class="text-yellow-700 mb-4 p-4 bg-yellow-100 rounded-md flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('warning') }}
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

                        <!-- Nama Anggota (Custom Dropdown) -->
                        <div x-data="{
                            open: false,
                            selected: '',
                            selectedName: '',
                            anggotaList: @js($anggota->map(fn($a) => [
                                'nomor' => $a->nomor_anggota,
                                'nama' => $a->nama,
                                'golongan' => $a->golongan_pramuka
                            ])),
                            selectAnggota(item) {
                                this.selected = item.nomor;
                                this.selectedName = item.nama + ' (' + item.nomor + ')';
                                this.open = false;
                                document.getElementById('golonganSekarang').value = item.golongan;
                            }
                        }">
                            <label class="block text-gray-600 font-bold mb-2">Nama Anggota <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <button type="button" @click="open = !open"
                                    class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08]">
                                    <span x-text="selectedName || '-- Pilih Anggota --'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false"
                                    class="absolute mt-1 w-full bg-white border border-gray-400 rounded shadow-lg max-h-60 overflow-y-auto z-10">
                                    <template x-for="item in anggotaList" :key="item.nomor">
                                        <button type="button" @click="selectAnggota(item)"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                            x-text="item.nama + ' (' + item.nomor + ')'"></button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="nomor_anggota" :value="selected">
                            @error('nomor_anggota')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Golongan Sekarang (readonly, auto-fill) -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">Golongan Sekarang</label>
                            <input id="golonganSekarang" type="text" name="golongan_awal"
                                   class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-gray-100 cursor-not-allowed"
                                   placeholder="Otomatis terisi saat memilih anggota"
                                   readonly>
                            <p class="text-xs text-gray-400 mt-1">Terisi otomatis dari data anggota yang dipilih</p>
                        </div>

                        <!-- Golongan Tujuan + Tingkatan -->
                        <div x-data="{
                            openGol: false,
                            openTingkat: false,
                            golongan: '{{ old('golongan_tujuan') }}',
                            tingkat: '{{ old('tingkatan_tujuan') }}',
                            golonganOptions: {
                                'Siaga':      ['Mula', 'Bantu', 'Tata'],
                                'Penggalang': ['Ramu', 'Rakit', 'Terap'],
                                'Penegak':    ['Bantara', 'Laksana'],
                                'Pandega':    [],
                                'Pembina':    []
                            },
                            get tingkatOptions() {
                                return this.golonganOptions[this.golongan] || [];
                            },
                            selectGolongan(val) {
                                this.golongan = val;
                                this.tingkat = '';
                                this.openGol = false;
                            },
                            get previewLabel() {
                                if (!this.golongan) return '';
                                return this.tingkat ? this.golongan + ' ' + this.tingkat : this.golongan;
                            }
                        }">
                            <label class="block text-gray-600 font-bold mb-2">Golongan Tujuan <span class="text-red-500">*</span></label>

                            <!-- Dropdown Golongan -->
                            <div class="relative mb-3">
                                <button type="button" @click="openGol = !openGol"
                                    class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('golongan_tujuan') border-red-500 @enderror">
                                    <span x-text="golongan || '-- Pilih Golongan --'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="openGol" @click.away="openGol = false"
                                    class="absolute mt-1 w-full bg-white border border-gray-400 rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                    <template x-for="(opts, gol) in golonganOptions" :key="gol">
                                        <button type="button" @click="selectGolongan(gol)"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                            x-text="gol"></button>
                                    </template>
                                </div>
                            </div>
                            @error('golongan_tujuan')
                                <p class="text-red-500 text-sm -mt-2 mb-2">{{ $message }}</p>
                            @enderror

                            <!-- Dropdown Tingkatan — hanya muncul jika golongan punya tingkatan -->
                            <div x-show="tingkatOptions.length > 0" x-cloak>
                                <label class="block text-gray-600 font-bold mb-2">Tingkat Tujuan</label>
                                <div class="relative">
                                    <button type="button" @click="openTingkat = !openTingkat"
                                        class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08]">
                                        <span
                                            x-text="tingkat || 'Belum bertingkat (baru masuk golongan)'"
                                            :class="!tingkat ? 'text-gray-400 italic' : 'text-gray-600'">
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openTingkat" @click.away="openTingkat = false"
                                        class="absolute mt-1 w-full bg-white border border-gray-400 rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <!-- Opsi kosong: baru masuk golongan -->
                                        <button type="button" @click="tingkat = ''; openTingkat = false"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-400 hover:bg-gray-100 italic">
                                            — Belum bertingkat (baru masuk golongan)
                                        </button>
                                        <template x-for="opt in tingkatOptions" :key="opt">
                                            <button type="button" @click="tingkat = opt; openTingkat = false"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                                x-text="opt"></button>
                                        </template>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Kosongkan jika anggota baru naik golongan dan belum memiliki tingkatan</p>
                            </div>

                            <!-- Preview hasil gabungan -->
                            <div x-show="golongan" x-cloak class="mt-2 text-xs text-gray-500">
                                Akan disimpan sebagai:
                                <span class="font-semibold text-green-700" x-text="previewLabel"></span>
                            </div>

                            <!-- Hidden inputs yang dikirim ke controller -->
                            <input type="hidden" name="golongan_tujuan" :value="golongan">
                            <input type="hidden" name="tingkatan_tujuan" :value="tingkat">
                        </div>

                        <!-- Tanggal Kenaikan -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">Tanggal Kenaikan <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_kenaikan"
                                   class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('tanggal_kenaikan') border-red-500 @enderror"
                                   value="{{ old('tanggal_kenaikan') }}">
                            @error('tanggal_kenaikan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tempat Penetapan -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">Tempat Penetapan <span class="text-red-500">*</span></label>
                            <input type="text" name="tempat_penetapan"
                                class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('tempat_penetapan') border-red-500 @enderror"
                                placeholder="Contoh: Surabaya"
                                value="{{ old('tempat_penetapan', 'Surabaya') }}">
                            @error('tempat_penetapan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dropdown Pembina -->
                        <div x-data="{
                            openPembina: false,
                            selectedPembinaName: '',
                            selectedPembinaNip: '',
                            pembinaList: @js($settings->pembina ?? []),
                            selectPembina(item) {
                                this.selectedPembinaName = item.nama;
                                this.selectedPembinaNip = item.nip || '';
                                this.openPembina = false;
                            }
                        }">
                            <label class="block text-gray-600 font-bold mb-2">Pembina (TTD Sertifikat)</label>
                            <div class="relative">
                                <button type="button" @click="openPembina = !openPembina"
                                    class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08]">
                                    <span x-text="selectedPembinaName || '-- Pilih Pembina --'"></span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="openPembina" @click.away="openPembina = false"
                                    class="absolute mt-1 w-full bg-white border border-gray-400 rounded shadow-lg max-h-60 overflow-y-auto z-10">
                                    <template x-for="item in pembinaList" :key="item.nama">
                                        <button type="button" @click="selectPembina(item)"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 flex items-center gap-2">
                                            <span x-text="item.nama"></span>
                                            <span x-show="item.is_ketua" class="text-[10px] bg-amber-100 text-amber-700 px-1.5 py-0.5 rounded">Ketua</span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="nama_pembina" :value="selectedPembinaName">
                            <input type="hidden" name="nip_pembina" :value="selectedPembinaNip">
                            <p class="text-xs text-gray-400 mt-1">Kosongkan untuk otomatis menggunakan Ketua Pembina dari pengaturan</p>
                        </div>

                        <!-- Nomor Sertifikat -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">
                                Nomor Sertifikat
                                <span class="text-gray-400 font-normal text-xs ml-1">(kosongkan untuk generate otomatis)</span>
                            </label>
                            <input type="text" name="nomor_sertifikat"
                                   class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] font-mono @error('nomor_sertifikat') border-red-500 @enderror"
                                   placeholder="Contoh: SERT-2025-0001"
                                   value="{{ old('nomor_sertifikat') }}">
                            @error('nomor_sertifikat')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 mt-1">Format otomatis: SERT-{TAHUN}-{URUTAN}</p>
                        </div>

                        <!-- Catatan -->
                        <div class="md:col-span-2">
                            <label class="block text-gray-600 font-bold mb-2">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea name="catatan" rows="3"
                                      class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
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
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-gray-700">Nama</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">No. Anggota</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Dari</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Ke</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Tanggal</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">No. Sertifikat</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Tempat</th>
                                <th class="px-4 py-3 font-semibold text-gray-700">Catatan</th>
                                <th class="px-4 py-3 font-semibold text-gray-700 text-center">Sertifikat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $item)
                                <tr class="border-t hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-800">{{ $item->anggota->nama }}</td>
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
                                    <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kenaikan)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($item->nomor_sertifikat)
                                            <span class="font-mono text-xs text-gray-700">{{ $item->nomor_sertifikat }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs italic">—</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 text-xs">
                                        {{ $item->tempat_penetapan ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 text-xs max-w-xs truncate">
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
                            @empty
                                <tr>
                                    <td colspan="9" class="px-4 py-8 text-center text-gray-400 text-sm italic">
                                        Belum ada riwayat kenaikan golongan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>