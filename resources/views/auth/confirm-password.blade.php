<div class="flex justify-center">
    <div class="flex-1 bg-no-repeat bg-cover flex justify-center items-center" style="background-image: url('{{ asset('bg-auth.png') }}');">
        <img src="https://awsimages.detik.net.id/community/media/visual/2022/08/04/siapa-pencetus-lambang-tunas-kelapa-ini-profil-dan-sejarahnya_11.png?w=1200" alt="" class="w-48">
    </div>
    <div  class="flex-1 bg-blue-500">
        <x-guest-layout>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </x-guest-layout>
    </div>
</div>
