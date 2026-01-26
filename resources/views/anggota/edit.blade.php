<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Anggota') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form action="{{ route('anggota.update', ['nomor_anggota' => $anggota->nomor_anggota]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex gap-8">
                        <div class="flex-1 px-16 bg-white shadow-md sm:rounded-lg p-6">
                            <div class="mb-4">
                                <label for="nik" class="block text-gray-700 font-bold mb-2">NIK</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik', $anggota->nik) }}"
                                    class="w-full border rounded px-3 py-2 @error('nik') border-red-500 @enderror">
                                @error('nik')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="nomor_anggota" class="block text-gray-700 font-bold mb-2">Nomor Anggota (KTA)</label>
                                <input type="text" name="nomor_anggota" id="nomor_anggota" value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}"
                                    class="w-full border rounded px-3 py-2 @error('nomor_anggota') border-red-500 @enderror">
                                @error('nomor_anggota')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $anggota->nama) }}"
                                    class="w-full border rounded px-3 py-2 @error('nama') border-red-500 @enderror">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="jenis_kelamin" class="block text-gray-700 font-bold mb-2">Jenis Kelamin</label>
                                <input type="text" name="jenis_kelamin" id="jenis_kelamin" value="{{ old('jenis_kelamin', $anggota->jenis_kelamin) }}"
                                    class="w-full border rounded px-3 py-2 @error('jenis_kelamin') border-red-500 @enderror">
                                @error('jenis_kelamin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="agama" class="block text-gray-700 font-bold mb-2">Agama</label>
                                <input type="text" name="agama" id="agama" value="{{ old('agama', $anggota->agama) }}"
                                    class="w-full border rounded px-3 py-2 @error('agama') border-red-500 @enderror">
                                @error('agama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="golongan_pramuka" class="block text-gray-700 font-bold mb-2">Golongan Pramuka</label>
                                <input disabled type="text" name="golongan_pramuka" id="golongan_pramuka" value="{{ old('golongan_pramuka', $anggota->golongan_pramuka) }}"
                                    class="w-full border text-gray-800 bg-gray-200 rounded px-3 py-2 @error('golongan_pramuka') border-red-500 @enderror">
                                @error('golongan_pramuka')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex-1 px-16 bg-white shadow-md sm:rounded-lg p-6">
                            <div class="mb-4">
                                <label for="golongan_darah" class="block text-gray-700 font-bold mb-2">Golongan Darah</label>
                                <input type="text" name="golongan_darah" id="golongan_darah" value="{{ old('golongan_darah', $anggota->golongan_darah) }}"
                                    class="w-full border rounded px-3 py-2 @error('golongan_darah') border-red-500 @enderror">
                                @error('golongan_darah')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat</label>
                                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $anggota->alamat) }}"
                                    class="w-full border rounded px-3 py-2 @error('alamat') border-red-500 @enderror">
                                @error('alamat')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tempat_lahir" class="block text-gray-700 font-bold mb-2">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir', $anggota->tempat_lahir) }}"
                                    class="w-full border rounded px-3 py-2 @error('tempat_lahir') border-red-500 @enderror">
                                @error('tempat_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="tanggal_lahir" class="block text-gray-700 font-bold mb-2">Tanggal Lahir</label>
                                <input type="text" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}"
                                    class="w-full border rounded px-3 py-2 @error('tanggal_lahir') border-red-500 @enderror">
                                @error('tanggal_lahir')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $anggota->email) }}"
                                    class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="no_telp" class="block text-gray-700 font-bold mb-2">No Telp</label>
                                <input type="no_telp" name="no_telp" id="no_telp" value="{{ old('no_telp', $anggota->no_telp) }}"
                                    class="w-full border rounded px-3 py-2 @error('no_telp') border-red-500 @enderror">
                                @error('no_telp')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end">
                                <x-primary-button type="submit">Update</x-primary-button>
                                <a href="{{ route('anggota') }}" class="ml-3 inline-block bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>              
                </form>
        </div>
    </div>
</x-app-layout>
