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
                    <div class="text-green-500 mb-4 p-4 bg-green-100 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Notifikasi Error -->
                @if ($errors->any())
                    <div class="text-red-500 mb-4 p-4 bg-red-100 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                            <label for="golongan_pramuka" class="block text-sm font-medium text-gray-700 mb-1">Golongan Tujuan</label>
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

                            <label for="tingkat_pramuka" class="block text-sm font-medium text-gray-700 mb-1 mt-4">Tingkat Tujuan</label>
                            <select name="tingkat_pramuka" id="tingkat_pramuka" x-model="tingkat"
                                    class="w-full border rounded px-3 py-2 @error('tingkat_pramuka') border-red-500 @enderror focus:ring-2 focus:ring-[#610a08]">
                                <option value="">-- Pilih Tingkat --</option>
                                <template x-for="tingkat in tingkatOptions" :key="tingkat">
                                    <option :value="tingkat" x-text="tingkat"></option>
                                </template>
                            </select>
                            @error('tingkat_pramuka')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <!-- Hidden input for combined value -->
                            <input type="hidden" name="golongan_tujuan" :value="combineGolonganTingkat()">
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
        document.addEventListener("alpine:init", () => {

            window.golonganPramuka = {
                "Siaga": ["Mula", "Bantu", "Tata"],
                "Penggalang": ["Ramu", "Rakit", "Terap"],
                "Penegak": ["Bantara", "Laksana"],
                "Pandega": ["Pandega"],
                "Pembina": ["Pembina"]
            };

            Alpine.data("customGolonganDropdown", ({ golData }) => ({
                open: false,
                selectedLabel: "",
                selectedValue: "",
                options: [],
                flatList: [],

                init() {
                    Object.entries(golData).forEach(([gol, tingkatanList]) => {
                        tingkatanList.forEach(t => {
                            this.flatList.push({
                                value: `${gol} - ${t}`,
                                label: `${gol} - ${t}`
                            });
                        });
                    });

                    this.options = this.flatList;
                },

                toggle() {
                    this.open = !this.open;
                },

                select(option) {
                    this.selectedLabel = option.label;
                    this.selectedValue = option.value;
                    this.open = false;
                },

                updateBasedOnCurrent(current) {
                    if (!current) {
                        this.options = this.flatList;
                        return;
                    }

                    const currentIndex = this.flatList.findIndex(o => o.value === current);
                    this.options = this.flatList.filter((o, i) => i > currentIndex);
                }
            }));
        });

        document.addEventListener("DOMContentLoaded", function () {
            const anggotaSelect = document.getElementById('anggotaSelect');
            const golonganSekarang = document.getElementById('golonganSekarang');

            anggotaSelect.addEventListener('change', function () {
                const selected = this.options[this.selectedIndex];
                const current = selected.getAttribute('data-golongan') || "";

                golonganSekarang.value = current;

                const alpineCmp = document.querySelector("#dropdownGolonganWrapper")._x_dataStack[0];
                alpineCmp.updateBasedOnCurrent(current);
            });
        });
    </script>
    @endpush
</x-app-layout>
