<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Register Button -->
        <div class="mt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <!-- Divider -->
        <div
            class="my-4 flex items-center before:mt-0.5 before:flex-1 before:border-t before:border-gray-300 after:mt-0.5 after:flex-1 after:border-t after:border-gray-300">
            <p class="mx-4 mb-0 text-center font-semibold text-gray-500">
                ATAU
            </p>
        </div>

        <!-- Google Register Button -->
        <div>
            <a href="{{ route('google.login') }}"
                class="w-full inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo"
                    class="w-4 h-4 mr-2">
                Daftar dengan Google
            </a>
        </div>

        <!-- Already Registered Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                {{ __('Sudah daftar?') }}
                <a class="underline text-indigo-600 hover:text-indigo-800 font-medium" href="{{ route('login') }}">
                    {{ __('Masuk di sini') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
