<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengaturan Profil Organisasi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">

                @if (session('success'))
                    <div class="text-green-700 mb-4 p-4 bg-green-100 rounded-md flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="text-red-700 mb-4 p-4 bg-red-100 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h1 class="text-lg font-bold mb-1">Profil Organisasi Pramuka</h1>
                <p class="text-sm text-gray-600 mb-6">Kelola informasi organisasi, gugus depan, dan data pembina.</p>

                <form action="{{ route('settings.update') }}" method="POST" 
                      x-data="{
                          pembina: {{ json_encode($settings->pembina ?? []) }}
                      }">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">

                        <!-- Nama Gugus Depan -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">Nama Gugus Depan</label>
                            <input type="text" name="nama_gugus_depan"
                                class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                value="{{ old('nama_gugus_depan', $settings->nama_gugus_depan) }}"
                                placeholder="Contoh: Gugus Depan 11.021-11.022">
                        </div>

                        <!-- Nomor Gugus Depan -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">Nomor Gugus Depan</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">
                                        Putra (Pa)
                                    </label>
                                    <input type="text" name="nomor_gugus_depan_pa"
                                        class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                        value="{{ old('nomor_gugus_depan_pa', $nomorPa) }}"
                                        placeholder="Contoh: 11.021">
                                </div>
                                <div>
                                    <label class="block text-gray-600 text-sm mb-1">
                                        Putri (Pi)
                                    </label>
                                    <input type="text" name="nomor_gugus_depan_pi"
                                        class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                        value="{{ old('nomor_gugus_depan_pi', $nomorPi) }}"
                                        placeholder="Contoh: 11.022">
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">
                                Akan disimpan sebagai: 
                                <span class="font-mono text-gray-600">{{ $nomorPa }}-{{ $nomorPi }}</span>
                            </p>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-gray-600 font-bold mb-2">Alamat</label>
                            <textarea name="alamat" rows="2"
                                class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                placeholder="Alamat lengkap gugus depan">{{ old('alamat', $settings->alamat) }}</textarea>
                        </div>

                        <!-- PEMBINA (Dynamic) -->
                        <div class="border-t pt-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <label class="block text-gray-600 font-bold mb-1">Data Pembina</label>
                                    <p class="text-sm text-gray-500">Tambahkan satu atau lebih pembina. Tandai salah satu sebagai Ketua untuk TTD sertifikat.</p>
                                </div>
                                <button type="button" @click="pembina.push({nama: '', nip: '', is_ketua: false})"
                                    class="px-3 py-1.5 bg-[#610a08] text-white text-sm rounded hover:bg-[#7D2A26] transition">
                                    + Tambah Pembina
                                </button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(p, index) in pembina" :key="index">
                                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <!-- Nama Pembina -->
                                                <div>
                                                    <label class="block text-gray-600 font-semibold text-sm mb-1">Nama Pembina</label>
                                                    <input type="text" :name="'pembina['+index+'][nama]'" x-model="p.nama"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 text-sm text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                                        placeholder="Contoh: Drs. Bambang Sudirman, M.Pd.">
                                                </div>

                                                <!-- NIP Pembina -->
                                                <div>
                                                    <label class="block text-gray-600 font-semibold text-sm mb-1">NIP <span class="text-gray-400 font-normal">(opsional)</span></label>
                                                    <input type="text" :name="'pembina['+index+'][nip]'" x-model="p.nip"
                                                        class="w-full border border-gray-400 rounded px-3 py-2 text-sm text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                                        placeholder="Contoh: 196512151990031004">
                                                </div>
                                            </div>

                                            <!-- Delete Button -->
                                            <button type="button" @click="pembina.splice(index, 1)"
                                                x-show="pembina.length > 1"
                                                class="mt-6 p-2 text-red-600 hover:bg-red-50 rounded transition"
                                                title="Hapus pembina">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Ketua Checkbox -->
                                        <div class="mt-3 flex items-center">
                                            <input type="checkbox" :id="'ketua_'+index" :name="'pembina['+index+'][is_ketua]'"
                                                x-model="p.is_ketua"
                                                @change="if(p.is_ketua) { pembina.forEach((item, i) => { if(i !== index) item.is_ketua = false; }); }"
                                                class="w-4 h-4 text-[#610a08] border-gray-400 rounded focus:ring-[#610a08]"
                                                value="1">
                                            <label :for="'ketua_'+index" class="ml-2 text-sm text-gray-600">
                                                <span class="font-semibold">Ketua Gugus Depan</span>
                                                <span class="text-gray-400">(untuk TTD sertifikat)</span>
                                            </label>
                                        </div>
                                    </div>
                                </template>

                                <div x-show="pembina.length === 0" class="text-center py-6 text-gray-400 text-sm">
                                    Belum ada pembina. Klik "Tambah Pembina" untuk menambahkan.
                                </div>
                            </div>
                        </div>

                        <!-- Kepala Sekolah -->
                        <div class="border-t pt-6">
                            <label class="block text-gray-600 font-bold mb-1">Nama Kepala Sekolah</label>
                            <p class="text-sm text-gray-500 mb-3">Data kepala sekolah yang bertanggung jawab atas gugus depan.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-600 font-semibold text-sm mb-1">Nama</label>
                                    <input type="text" name="nama_kepala_sekolah"
                                        class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                        value="{{ old('nama_kepala_sekolah', $settings->nama_kepala_sekolah) }}"
                                        placeholder="Contoh: Dr. Siti Nurhaliza, S.Pd., M.Pd.">
                                </div>
                                <div>
                                    <label class="block text-gray-600 font-semibold text-sm mb-1">NIP <span class="text-gray-400 font-normal">(opsional)</span></label>
                                    <input type="text" name="nip_kepala_sekolah"
                                        class="w-full border border-gray-400 rounded px-3 py-2 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-[#610a08]"
                                        value="{{ old('nip_kepala_sekolah', $settings->nip_kepala_sekolah) }}"
                                        placeholder="Contoh: 197803122005012001">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}" 
                           class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                            Batal
                        </a>
                        <x-primary-button type="submit">
                            Simpan Pengaturan
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>