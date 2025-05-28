<!-- resources/views/components/navbar.blade.php -->
<nav class="bg-white border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="{{ asset('logo.png') }}" class="h-8" alt="Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-gray-900">Darikita</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-4">
            @guest
                <!-- Tombol Masuk -->
                <a href="{{ route('login') }}"
                    class="text-blue-600 border border-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Masuk
                </a>
                <!-- Tombol Daftar -->
                <a href="{{ route('register') }}"
                    class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                    Daftar
                </a>
            @else
                <!-- Dropdown Profil User -->
                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                    id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full"
                        src="{{ Auth::user()->profile_photo_url ?? asset('images/default-avatar.jpg') }}" alt="user photo">
                </button>
                <!-- Dropdown Menu -->
                <div id="user-dropdown"
                    class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-gray-900">{{ Auth::user()->name }}</span>
                        <span class="block text-sm text-gray-500 truncate">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest

            <!-- Toggle Hamburger -->
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <!-- Menu Utama -->
        <div class="items-center justify-between hidden md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                <li>
                    <a href="{{ url('/') }}"
                        class="block py-2 px-3 {{ request()->is('/') ? 'text-blue-700' : 'text-gray-700 hover:text-blue-700' }} md:p-0"
                        @if (request()->is('/')) aria-current="page" @endif>
                        Beranda
                    </a>
                </li>
                <li>
                    <a href="{{ url('/#program') }}"
                        class="block py-2 px-3 text-gray-700 hover:text-blue-700 md:p-0">Program</a>
                </li>
                <li>
                    <a href="{{ url('/#impact') }}"
                        class="block py-2 px-3 text-gray-700 hover:text-blue-700 md:p-0">Impact</a>
                </li>
                <li>
                    <a href="{{ url('/#testimonials') }}"
                        class="block py-2 px-3 text-gray-700 hover:text-blue-700 md:p-0">Testimoni</a>
                </li>
                <li>
                    <a href="{{ url('/#faq') }}"
                        class="block py-2 px-3 text-gray-700 hover:text-blue-700 md:p-0">FAQ</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
