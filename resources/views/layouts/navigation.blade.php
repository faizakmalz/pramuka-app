<nav x-data="{ open: false }" class="fixed bg-white border-b border-gray-100 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="w-7xl mx-auto px-4 sm:px-10 lg:px-10">
        <div class="flex flex-col py-10 h-screen">
            <div class="flex flex-col items-center">
                <!-- Logo -->
                <div class="shrink-0 flex">
                    <a href="{{ route('dashboard') }}">
                        <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200" alt="" class="w-20">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex pt-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <div x-data="{ openAnggota: true }" class="hidden sm:flex flex-col w-full pt-5">
                    <button 
                        @click="openAnggota = ! openAnggota"
                        class="flex items-center justify-between w-full text-left text-gray-700 font-semibold px-4 py-2 hover:bg-gray-100 rounded-lg transition"
                    >
                        <span class="text-sm pl-5">Data Anggota</span>
                        <svg :class="{'rotate-180': openAnggota}" class="ml-2 h-5 w-5 text-gray-500 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div 
                        x-show="openAnggota" 
                        x-transition 
                        class="mt-2 pl-8 flex flex-col space-y-2 overflow-hidden"
                    >
                        <x-nav-link class="w-[110px]" :href="route('anggota')" :active="request()->routeIs('anggota')">
                                                  Daftar Anggota
                        </x-nav-link>
                        <x-nav-link class="w-[120px]" :href="route('anggota.create')" :active="request()->routeIs('anggota.create')">
                                   Tambah Anggota
                        </x-nav-link>
                        <x-nav-link class="w-[120px]" :href="route('kenaikan')" :active="request()->routeIs('kenaikan')">
                                   Kenaikan Gol.
                        </x-nav-link>
                    </div>
                </div>

                <div x-data="{ openEvent: true }" class="hidden sm:flex flex-col w-full pt-10">
                    <button 
                        @click="openEvent = ! openEvent"
                        class="flex items-center justify-between w-full text-left text-gray-700 font-semibold px-4 py-2 hover:bg-gray-100 rounded-lg transition"
                    >
                        <span class="text-sm pl-5">Jadwal Event</span>
                        <svg :class="{'rotate-180': openEvent}" class="ml-2 h-5 w-5 text-gray-500 transform transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div 
                        x-show="openEvent" 
                        x-transition 
                        class="mt-2 pl-8 flex flex-col space-y-2 overflow-hidden"
                    >
                        <x-nav-link class="w-[110px]" :href="route('jadwal-event')" :active="request()->routeIs('jadwal-event')">
                                Kalender Event
                        </x-nav-link>
                        <x-nav-link class="w-[100px]" :href="route('event.create')" :active="request()->routeIs('event.create')">
                                   Buat Event
                        </x-nav-link>
                    </div>
                </div>

                <div class="mt-20">
                    <x-nav-link class="mt-6 pl-5 text-left text-gray-700 font-semibold w-[100px]" :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        Profile
                    </x-nav-link>

                    <div class="text-left text-gray-700 font-semibold w-[100px]">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                    </div>
                </div>
                
                <!-- <div class="hidden sm:flex pt-10">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('')">
                        {{ __('Absensi') }}
                    </x-nav-link>
                </div>
                <div class="hidden sm:flex pt-10">
                    <x-nav-link :href="route(name: 'dashboard')" :active="request()->routeIs('')">
                        {{ __('Settings') }}
                    </x-nav-link>
                </div> -->
            </div>

            <!-- Settings Dropdown -->
            

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
