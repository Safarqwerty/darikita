<!-- Navbar -->
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="{{ asset('logo.png') }}" class="h-8" alt="Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-gray-900">Darikita</span>
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex md:items-center md:space-x-8">
            <ul class="flex space-x-8">
                @foreach (config('welcome-navbar') as $nav)
                    <li>
                        <a href="{{ $nav['route'] }}"
                            class="@if(url($nav['route']) == url()->current()) text-blue-600 @else text-grey-700 @endif font-medium hover:text-blue-800 transition-colors duration-200">
                            {{ $nav['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Auth Buttons & Profile -->
        <div class="hidden md:flex items-center space-x-4">
            @guest
                <!-- Login Button -->
                <a href="{{ route('login') }}"
                    class="text-blue-600 border border-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Masuk
                </a>
                <!-- Register Button -->
                <a href="{{ route('register') }}"
                    class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200">
                    Daftar
                </a>
            @endguest

            @auth
                <!-- Profile Dropdown -->
                <div class="relative">
                    <button type="button"
                        class="flex items-center space-x-2 text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 p-0.5"
                        id="user-menu-button">
                        <img class="w-8 h-8 rounded-full"
                            src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=User' }}"
                            alt="Profile">
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 hidden">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'User' }}</p>
                            <p class="text-sm text-gray-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                            <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 21l4-7 4 7">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">
                                <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <button type="button"
            class="md:hidden inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
            id="mobile-menu-button">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden hidden" id="mobile-menu">
        <div class="px-4 pt-2 pb-3 space-y-1 bg-white border-t border-gray-200">
            @foreach (config('welcome-navbar') as $nav)
                <a href="{{ $nav['route'] }}"
                    class="@if(url($nav['route']) == url()->current()) text-blue-600 @else text-grey-700 @endif block px-3 py-2 rounded-md font-medium hover:text-blue-800 transition-colors duration-200">
                    {{ $nav['title'] }}
                </a>
            @endforeach
            
            <!-- Auth Section -->
            <div class="pt-4 border-t border-gray-200">
                @guest
                    <div class="space-y-2">
                        <a href="{{ route('login') }}"
                            class="block w-full text-center px-3 py-2 text-blue-600 border border-blue-600 rounded-md hover:bg-blue-50 transition-colors duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="block w-full text-center px-3 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Daftar
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="space-y-2">
                        <div class="flex items-center px-3 py-2 space-x-3">
                            <img class="w-8 h-8 rounded-full"
                                src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=User' }}"
                                alt="Profile">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-200">
                            <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 21l4-7 4 7"></path>
                            </svg>
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full text-left px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-200">
                                <svg class="mr-3 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>