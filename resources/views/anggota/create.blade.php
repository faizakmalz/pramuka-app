<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Anggota') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mt-4 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-auto">
                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf
                    <div class="flex gap-8">
                        <div class="flex-1 px-16 bg-white shadow-md sm:rounded-lg p-6">

                            <!-- NIK -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">NIK</label>
                                <input type="text" name="nik" value="{{ old('nik') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('nik') border-red-500 @enderror">
                                @error('nik')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Nomor Anggota -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">Nomor Anggota (KTA)</label>
                                <input type="text" name="nomor_anggota" value="{{ old('nomor_anggota') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('nomor_anggota') border-red-500 @enderror">
                                @error('nomor_anggota')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Nama -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">Nama</label>
                                <input type="text" name="nama" value="{{ old('nama') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('nama') border-red-500 @enderror">
                                @error('nama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-4" x-data="{ open: false, selected: '{{ old('jenis_kelamin') }}', options: ['Laki-laki', 'Perempuan'] }">
                                <label class="block text-gray-600 font-bold mb-2">Jenis Kelamin</label>
                                <div class="relative">
                                    <button type="button" @click="open = !open"
                                        class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('jenis_kelamin') border-red-500 @enderror">
                                        <span x-text="selected || '-- Pilih Jenis Kelamin --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute mt-1 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="opt in options" :key="opt">
                                            <button type="button" @click="selected = opt; open = false"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                                x-text="opt"></button>
                                        </template>
                                    </div>
                                </div>
                                <input type="hidden" name="jenis_kelamin" :value="selected">
                                @error('jenis_kelamin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Agama -->
                            <div class="mb-4" x-data="{ open: false, selected: '{{ old('agama') }}', options: ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] }">
                                <label class="block text-gray-600 font-bold mb-2">Agama</label>
                                <div class="relative">
                                    <button type="button" @click="open = !open"
                                        class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('agama') border-red-500 @enderror">
                                        <span x-text="selected || '-- Pilih Agama --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute mt-1 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="opt in options" :key="opt">
                                            <button type="button" @click="selected = opt; open = false"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                                x-text="opt"></button>
                                        </template>
                                    </div>
                                </div>
                                <input type="hidden" name="agama" :value="selected">
                                @error('agama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Golongan Pramuka & Tingkat -->
                            <div class="mb-4" x-data="{
                                openGol: false,
                                openTingkat: false,
                                golongan: '{{ old('golongan_pramuka') }}',
                                tingkat: '',
                                golonganOptions: {
                                    'Siaga': ['Mula', 'Bantu', 'Tata'],
                                    'Penggalang': ['Ramu', 'Rakit', 'Terap'],
                                    'Penegak': ['Bantara', 'Laksana'],
                                    'Pandega': ['Pandega'],
                                    'Pembina': ['Pembina']
                                },
                                get tingkatOptions() {
                                    return this.golonganOptions[this.golongan] || [];
                                },
                                selectGolongan(val) {
                                    this.golongan = val;
                                    this.tingkat = '';
                                    this.openGol = false;
                                },
                                get combined() {
                                    return this.golongan && this.tingkat ? `${this.golongan} - ${this.tingkat}` : '';
                                }
                            }">
                                <!-- Golongan -->
                                <label class="block text-gray-600 font-bold mb-2">Golongan Pramuka</label>
                                <div class="relative mb-4">
                                    <button type="button" @click="openGol = !openGol"
                                        class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('golongan_pramuka') border-red-500 @enderror">
                                        <span x-text="golongan || '-- Pilih Golongan --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openGol" @click.away="openGol = false"
                                        class="absolute mt-1 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="(opts, gol) in golonganOptions" :key="gol">
                                            <button type="button" @click="selectGolongan(gol)"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                                x-text="gol"></button>
                                        </template>
                                    </div>
                                </div>
                                @error('golongan_pramuka')<p class="text-red-500 text-sm -mt-3 mb-2">{{ $message }}</p>@enderror

                                <!-- Tingkat -->
                                <label class="block text-gray-600 font-bold mb-2">Tingkat</label>
                                <div class="relative">
                                    <button type="button" @click="if(tingkatOptions.length) openTingkat = !openTingkat"
                                        :class="tingkatOptions.length ? 'cursor-pointer' : 'cursor-not-allowed opacity-60'"
                                        class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08]">
                                        <span x-text="tingkat || '-- Pilih Tingkat --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="openTingkat" @click.away="openTingkat = false"
                                        class="absolute mt-1 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="opt in tingkatOptions" :key="opt">
                                            <button type="button" @click="tingkat = opt; openTingkat = false"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                                x-text="opt"></button>
                                        </template>
                                    </div>
                                </div>
                                @error('tingkat_pramuka')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror

                                <input type="hidden" name="golongan_pramuka" :value="combined">
                                <input type="hidden" name="tingkat_pramuka" :value="tingkat">
                            </div>

                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="flex-1 px-16 bg-white shadow-md sm:rounded-lg p-6">

                            <!-- Golongan Darah -->
                            <div class="mb-4" x-data="{ open: false, selected: '{{ old('golongan_darah') }}', options: ['A', 'B', 'AB', 'O'] }">
                                <label class="block text-gray-600 font-bold mb-2">Golongan Darah</label>
                                <div class="relative">
                                    <button type="button" @click="open = !open"
                                        class="w-full border border-gray-400 rounded px-3 py-2 flex justify-between items-center bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('golongan_darah') border-red-500 @enderror">
                                        <span x-text="selected || '-- Pilih Golongan Darah --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false"
                                        class="absolute mt-1 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="opt in options" :key="opt">
                                            <button type="button" @click="selected = opt; open = false"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-600 hover:bg-gray-100"
                                                x-text="opt"></button>
                                        </template>
                                    </div>
                                </div>
                                <input type="hidden" name="golongan_darah" :value="selected">
                                @error('golongan_darah')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">Alamat</label>
                                <input type="text" name="alamat" value="{{ old('alamat') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('alamat') border-red-500 @enderror">
                                @error('alamat')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('tempat_lahir') border-red-500 @enderror">
                                @error('tempat_lahir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('email') border-red-500 @enderror">
                                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- No Telp -->
                            <div class="mb-4">
                                <label class="block text-gray-600 font-bold mb-2">No Telp</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                                    class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08] @error('no_telp') border-red-500 @enderror">
                                @error('no_telp')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Tombol -->
                            <div class="flex justify-end">
                                <x-primary-button type="submit">Simpan</x-primary-button>
                                <a href="{{ route('anggota') }}" class="ml-3 inline-block bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                                    Batal
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>