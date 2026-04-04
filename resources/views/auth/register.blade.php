<div class="flex justify-center">
    <div class="flex-1 bg-no-repeat bg-cover flex justify-center items-center" style="background-image: url('{{ asset('bg-auth.png') }}');">
        <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200" alt="" class="w-48">
    </div>
    <div  class="flex-1 bg-blue-500">
        <x-guest-layout>
            <div class="text-center mb-4">
                <h2 class="font-bold text-[30px]">SIMP</h2>
                <h3 class="font-semibold">Sistem Informasi Pramuka</h3>
                <div class="text-gray-600">
                    Welcome Back! Please enter your details
                </div>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4 mb-3">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                </a>

                <div class="flex items-center justify-end mt-4">

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout>
    </div>
</div>
