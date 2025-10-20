<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Event
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <form method="POST" action="{{ route('event.update', $event->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul Kegiatan</label>
                            <input type="text" name="event" value="{{ old('event', $event->event) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                            @error('event') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" rows="3"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>{{ old('deskripsi', $event->deskripsi) }}</textarea>
                            @error('deskripsi') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Awal</label>
                                <input type="date" name="tanggal_awal"
                                       value="{{ old('tanggal_awal', \Carbon\Carbon::createFromFormat('d-m-Y', $event->tanggal_awal)->format('Y-m-d')) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir"
                                       value="{{ old('tanggal_akhir', \Carbon\Carbon::createFromFormat('d-m-Y', $event->tanggal_akhir)->format('Y-m-d')) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $event->lokasi) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peserta</label>
                            <input type="text" name="peserta" value="{{ old('peserta', $event->peserta) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-8">
                        <a href="{{ route('jadwal-event') }}" class="px-4 py-2 bg-gray-200 rounded-md text-gray-700 hover:bg-gray-300">
                            Batal
                        </a>
                        <x-primary-button>
                            Update Event
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
