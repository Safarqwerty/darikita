<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Add enctype for file uploads --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Tempat Lahir --}}
        <div>
            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
            <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full"
                :value="old('tempat_lahir', $user->tempat_lahir)" />
            <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
        </div>

        {{-- Tanggal Lahir --}}
        <div>
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full"
                :value="old('tanggal_lahir', $user->tanggal_lahir)" />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        </div>

        {{-- Alamat --}}
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <textarea id="alamat" name="alamat"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ old('alamat', $user->alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        {{-- Agama --}}
        <div>
            <x-input-label for="agama" :value="__('Agama')" />
            <select id="agama" name="agama"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                <option value="">Pilih Agama</option>
                <option value="Islam" @selected(old('agama', $user->agama) == 'Islam')>Islam</option>
                <option value="Kristen Protestan" @selected(old('agama', $user->agama) == 'Kristen Protestan')>Kristen Protestan</option>
                <option value="Kristen Katolik" @selected(old('agama', $user->agama) == 'Kristen Katolik')>Kristen Katolik</option>
                <option value="Hindu" @selected(old('agama', $user->agama) == 'Hindu')>Hindu</option>
                <option value="Buddha" @selected(old('agama', $user->agama) == 'Buddha')>Buddha</option>
                <option value="Khonghucu" @selected(old('agama', $user->agama) == 'Khonghucu')>Khonghucu</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('agama')" />
        </div>

        {{-- Jenis Kelamin --}}
        <div>
            <x-input-label :value="__('Jenis Kelamin')" />
            <div class="mt-2 space-y-2">
                <label for="laki-laki" class="inline-flex items-center">
                    <input id="laki-laki" type="radio" name="jenis_kelamin" value="Laki-laki"
                        @checked(old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki')
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Laki-laki') }}</span>
                </label>
                <label for="perempuan" class="inline-flex items-center ml-6">
                    <input id="perempuan" type="radio" name="jenis_kelamin" value="Perempuan"
                        @checked(old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan')
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Perempuan') }}</span>
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('jenis_kelamin')" />
        </div>

        {{-- Nomor WA --}}
        <div>
            <x-input-label for="nomor_wa" :value="__('Nomor WhatsApp')" />
            <x-text-input id="nomor_wa" name="nomor_wa" type="text" class="mt-1 block w-full" :value="old('nomor_wa', $user->nomor_wa)"
                placeholder="Contoh: 081234567890" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_wa')" />
        </div>

        {{-- Link Instagram --}}
        <div>
            <x-input-label for="link_instagram" :value="__('Link Profil Instagram')" />
            <x-text-input id="link_instagram" name="link_instagram" type="url" class="mt-1 block w-full"
                :value="old('link_instagram', $user->link_instagram)" placeholder="https://instagram.com/username" />
            <x-input-error class="mt-2" :messages="$errors->get('link_instagram')" />
        </div>

        {{-- Foto --}}
        <div>
            <x-input-label for="foto" :value="__('Foto Profil')" />
            <div class="mt-2 flex items-center gap-x-3">
                <img id="foto-preview" class="h-20 w-20 rounded-full object-cover"
                    src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                    alt="Current profile photo" />
                <input id="foto" name="foto" type="file"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    onchange="previewImage(event)" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('foto')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('foto-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
