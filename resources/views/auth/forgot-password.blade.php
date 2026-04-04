<div class="flex justify-center">
    <div class="flex-1 bg-no-repeat bg-cover flex justify-center items-center" style="background-image: url('{{ asset('bg-auth.png') }}');">
        <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200" alt="" class="w-48">
    </div>
    <div  class="flex-1 bg-blue-500">      
        <x-guest-layout>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout>
    </div>
</div>
