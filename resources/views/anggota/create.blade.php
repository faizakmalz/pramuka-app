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
                            <div class="mb-4">
                                <label for="nik" class="block text-gray-700 font-bold mb-2">NIK</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}"
                                    class="w-full border rounded px-3 py-2 @error('nik') border-red-500 @enderror">
                                @error('nik')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                                    class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jenis_kelamin" class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin"
                                    class="w-full border rounded px-3 py-2 @error('jenis_kelamin') border-red-500 @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="agama" class="block text-gray-700 font-bold mb-2">Agama</label>
                                <select name="agama" id="agama"
                                    class="w-full border rounded px-3 py-2 @error('agama') border-red-500 @enderror">
                                    <option value="">-- Pilih Agama --</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                </select>
                                @error('agama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="golongan_pramuka" class="block text-gray-700 font-bold mb-2">Golongan Pramuka</label>
                                <select name="golongan_pramuka" id="golongan_pramuka"
                                    class="w-full border rounded px-3 py-2 @error('golongan_pramuka') border-red-500 @enderror">
                                    <option value="">-- Pilih Golongan Pramuka --</option>
                                    <option value="Siaga" {{ old('golongan_pramuka') == 'Siaga' ? 'selected' : '' }}>Siaga</option>
                                    <option value="Penggalang" {{ old('golongan_pramuka') == 'Penggalang' ? 'selected' : '' }}>Penggalang</option>
                                    <option value="Penegak" {{ old('golongan_pramuka') == 'Penegak' ? 'selected' : '' }}>Penegak</option>
                                    <option value="Pandega" {{ old('golongan_pramuka') == 'Pandega' ? 'selected' : '' }}>Pandega</option>
                                    <option value="Pembina" {{ old('golongan_pramuka') == 'Pembina' ? 'selected' : '' }}>Pembina</option>
                                </select>
                                @error('golongan_pramuka')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex-1 px-16 bg-white shadow-md sm:rounded-lg p-6">
                            <div class="mb-4">
                                <label for="golongan_darah" class="block text-gray-700 font-bold mb-2">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah"
                                    class="w-full border rounded px-3 py-2 @error('golongan_darah') border-red-500 @enderror">
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

                            <div class="mb-4">
                                <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat</label>
                                <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}"
                                    class="w-full border rounded px-3 py-2 @error('alamat') border-red-500 @enderror">
                                @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tempat_lahir" class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                    class="w-full border rounded px-3 py-2 @error('tempat_lahir') border-red-500 @enderror">
                                @error('tempat_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_lahir" class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                    class="w-full border rounded px-3 py-2 @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                                <input type="text" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="no_telp" class="block text-gray-700 font-bold mb-2">No Telp</label>
                                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}"
                                    class="w-full border rounded px-3 py-2 @error('telepon') border-red-500 @enderror">
                                @error('no_telp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>


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
