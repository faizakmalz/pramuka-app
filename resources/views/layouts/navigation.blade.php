<!-- Sidebar Desktop + Top Bar Mobile -->
<div x-data="{ sidebarOpen: false }">

    <!-- ===== TOP BAR (Mobile only) ===== -->
    <div class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200 shadow-sm sm:hidden">
        <a href="{{ route('dashboard') }}">
            <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200"
                 alt="Logo" class="w-10 h-10 mr-3 object-contain">
        </a>
        <span class="text-sm font-bold text-[#610a08]">Pramuka Management</span>
        <!-- Hamburger -->
        <button @click="sidebarOpen = true" class="p-2 rounded-md text-gray-500 hover:bg-gray-100 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- ===== OVERLAY (Mobile) ===== -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/40 sm:hidden"
         style="display: none;">
    </div>

    <!-- ===== SIDEBAR ===== -->
    <nav x-data="{ openAnggota: true, openEvent: true }"
         :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
         class="fixed top-0 left-0 z-50 h-screen w-72 bg-white border-r border-gray-100 shadow-md
                flex flex-col py-8 pl-14 pr-8 overflow-y-auto
                transform transition-transform duration-200 ease-in-out
                sm:translate-x-0">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-8">
            <!-- Close button (mobile) -->
            <button @click="sidebarOpen = false" class="self-end mb-2 p-1 text-gray-400 hover:text-gray-600 sm:hidden">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <a href="{{ route('dashboard') }}">
                <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200"
                     alt="Logo" class="w-20 mr-8 object-contain">
            </a>
        </div>

        <!-- Dashboard -->
        <div class="mb-2 ml-7 mt-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-[100px]">
                {{ __('Dashboard') }}
            </x-nav-link>
        </div>

        <!-- Data Anggota -->
        <div class="mt-4">
            <button @click="openAnggota = !openAnggota"
                class="flex items-center justify-between w-full text-left text-gray-700 font-semibold px-4 py-2 hover:bg-gray-100 rounded-lg transition">
                <span class="text-sm">Data Anggota</span>
                <svg :class="{'rotate-180': openAnggota}" class="h-4 w-4 text-gray-500 transform transition-transform duration-200"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="openAnggota" x-transition class="mt-1 pl-3 flex flex-col space-y-1">
                <x-nav-link :href="route('anggota')" :active="request()->routeIs('anggota')" class="w-[110px]">
                    Daftar Anggota
                </x-nav-link>
                <x-nav-link :href="route('anggota.create')" :active="request()->routeIs('anggota.create')" class="w-[120px]">
                    Tambah Anggota
                </x-nav-link>
                <x-nav-link :href="route('kenaikan')" :active="request()->routeIs('kenaikan')" class="w-[120px]">
                    Kenaikan Gol.
                </x-nav-link>
            </div>
        </div>

        <!-- Jadwal Event -->
        <div class="mt-4">
            <button @click="openEvent = !openEvent"
                class="flex items-center justify-between w-full text-left text-gray-700 font-semibold px-4 py-2 hover:bg-gray-100 rounded-lg transition">
                <span class="text-sm">Jadwal Event</span>
                <svg :class="{'rotate-180': openEvent}" class="h-4 w-4 text-gray-500 transform transition-transform duration-200"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="openEvent" x-transition class="mt-1 pl-3 flex flex-col space-y-1">
                <x-nav-link :href="route('jadwal-event')" :active="request()->routeIs('jadwal-event')" class="w-[110px]">
                    Kalender Event
                </x-nav-link>
                <x-nav-link :href="route('event.create')" :active="request()->routeIs('event.create')" class="w-[100px]">
                    Buat Event
                </x-nav-link>
            </div>
        </div>

        <!-- Bottom: Profile & Logout -->
        <div class="mt-auto pt-6 border-t border-gray-100 flex flex-col space-y-1">
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="w-[100px]">
                Profile
            </x-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();"
                    class="w-full text-left mr-3">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </div>
    </nav>
</div>