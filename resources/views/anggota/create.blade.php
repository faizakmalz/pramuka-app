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
                                <label for="nik" class="block text-gray-700 font-bold mb-2">NIK</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                                    class="w-full border rounded px-3 py-2 @error('nik') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('nik')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nomor Anggota -->
                            <div class="mb-4">
                                <label for="nomor_anggota" class="block text-gray-700 font-bold mb-2">Nomor Anggota (KTA)</label>
                                <input type="text" name="nomor_anggota" id="nomor_anggota" value="{{ old('nomor_anggota') }}"
                                    class="w-full border rounded px-3 py-2 @error('nomor_anggota') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('nomor_anggota')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nama -->
                            <div class="mb-4">
                                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                    class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-4" x-data="{ open: false, selected: '{{ old('jenis_kelamin') }}', options: ['Laki-laki', 'Perempuan'] }">
                                <label for="jenis_kelamin" class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                                <div class="relative">
                                    <button @click="open = !open" class="w-full border rounded px-3 py-2 flex justify-between items-center bg-white text-gray-700 focus:ring-2 focus:ring-[#610a08]">
                                        <span x-text="selected || '-- Pilih Jenis Kelamin --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute mt-2 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="opt in options" :key="opt">
                                            <button @click="selected = opt; open = false" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <span x-text="opt"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <input type="hidden" name="jenis_kelamin" :value="selected">
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Agama -->
                            <div class="mb-4" x-data="{ open: false, selected: '{{ old('agama') }}', options: ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] }">
                                <label for="agama" class="block text-gray-700 font-bold mb-2">Agama</label>
                                <div class="relative">
                                    <button @click="open = !open" class="w-full border rounded px-3 py-2 flex justify-between items-center bg-white text-gray-700 focus:ring-2 focus:ring-[#610a08]">
                                        <span x-text="selected || '-- Pilih Agama --'"></span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" @click.away="open = false" class="absolute mt-2 w-full bg-white border rounded shadow-lg max-h-40 overflow-y-auto z-10">
                                        <template x-for="opt in options" :key="opt">
                                            <button @click="selected = opt; open = false" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <span x-text="opt"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                                <input type="hidden" name="agama" :value="selected">
                                @error('agama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Golongan Pramuka and Tingkat -->
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
                                    this.tingkat = ''; // Reset tingkat when golongan changes
                                },
                                combineGolonganTingkat() {
                                    return this.golongan && this.tingkat ? `${this.golongan} - ${this.tingkat}` : '';
                                }
                            }">
                                <label for="golongan_pramuka" class="block text-gray-700 font-bold mb-2">Golongan Pramuka</label>
                                <select name="golongan_pramuka" id="golongan_pramuka" x-model="golongan" @change="updateTingkatOptions()"
                                        class="w-full border rounded px-3 py-2 @error('golongan_pramuka') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                    <option value="">-- Pilih Golongan --</option>
                                    <template x-for="(tingkatList, golongan) in golonganOptions" :key="golongan">
                                        <option :value="golongan" x-text="golongan"></option>
                                    </template>
                                </select>
                                @error('golongan_pramuka')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <label for="tingkat_pramuka" class="block text-gray-700 font-bold mb-2 mt-4">Tingkat</label>
                                <select name="tingkat_pramuka" id="tingkat_pramuka" x-model="tingkat"
                                        class="w-full border rounded px-3 py-2 @error('golongan_pramuka') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                    <option value="">-- Pilih Tingkat --</option>
                                    <template x-for="tingkat in tingkatOptions" :key="tingkat">
                                        <option :value="tingkat" x-text="tingkat"></option>
                                    </template>
                                </select>
                                @error('tingkat_pramuka')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror

                                <input type="hidden" name="golongan_pramuka" :value="combineGolonganTingkat()">
                            </div>

                        </div>
                        
                        <div class="flex-1 px-16 bg-white shadow-md sm:rounded-lg p-6">
                            <!-- Golongan Darah -->
                            <div class="mb-4">
                                <label for="golongan_darah" class="block text-gray-700 font-bold mb-2">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah"
                                    class="w-full border rounded px-3 py-2 @error('golongan_darah') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                    <option value="">-- Pilih Golongan Darah --</option>
                                    <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                </select>
                                @error('golongan_darah')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="mb-4">
                                <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat</label>
                                <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                                    class="w-full border rounded px-3 py-2 @error('alamat') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat Lahir -->
                            <div class="mb-4">
                                <label for="tempat_lahir" class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                    class="w-full border rounded px-3 py-2 @error('tempat_lahir') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('tempat_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div class="mb-4">
                                <label for="tanggal_lahir" class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                    class="w-full border rounded px-3 py-2 @error('tanggal_lahir') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('tanggal_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telp -->
                            <div class="mb-4">
                                <label for="no_telp" class="block text-gray-700 font-bold mb-2">No Telp</label>
                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                                    class="w-full border rounded px-3 py-2 @error('telepon') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                @error('no_telp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
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

    @push('scripts')
    <script>
        window.golonganPramuka = {
            "Siaga": ["Mula", "Bantu", "Tata"],
            "Penggalang": ["Ramu", "Rakit", "Terap"],
            "Penegak": ["Bantara", "Laksana"],
            "Pandega": ["Pandega"],
            "Pembina": ["Pembina"]
        };
    </script>
    @endpush
</x-app-layout>
