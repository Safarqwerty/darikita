<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Donasi - {{ $donasi->nama_bencana }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Jika pakai Vite -->
</head>

<body class="bg-gray-50">

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
                    <li>
                        <a href="{{ url('/') }}"
                            class="text-blue-600 font-medium hover:text-blue-800 transition-colors duration-200">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="#program"
                            class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Program
                        </a>
                    </li>
                    <li>
                        <a href="#impact"
                            class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Impact
                        </a>
                    </li>
                    <li>
                        <a href="#testimonials"
                            class="text-gray-700 hover:text-blue-600 font-medium transition-colors duration-200">
                            Testimoni
                        </a>
                    </li>
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
                                                            src="https://ui-avatars.com/api/?name=User"

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
                <!-- Navigation Links -->
                <a href="{{ url('/') }}" class="block px-3 py-2 text-blue-600 font-medium rounded-md">
                    Beranda
                </a>
                <a href="#program"
                    class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    Program
                </a>
                <a href="#impact"
                    class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    Impact
                </a>
                <a href="#testimonials"
                    class="block px-3 py-2 text-gray-700 hover:text-blue-600 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    Testimoni
                </a>

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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if ($donasi->gambar)
                <div class="w-full h-64 md:h-80">
                    <img src="{{ asset('storage/' . $donasi->gambar) }}" alt="{{ $donasi->judul }}"
                        class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-0">
                        {{ $donasi->nama_bencana }}
                    </h1>
                    <span
                        class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                        {{ $donasi->status === 'aktif' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ ucfirst($donasi->status) }}
                    </span>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">
                                Rp {{ number_format($donasi->dana_terkumpul, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Terkumpul</div>
                        </div>

                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-800">
                                Rp {{ number_format($donasi->target_dana, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Target</div>
                        </div>

                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                {{ number_format($progress, 1) }}%
                            </div>
                            <div class="text-sm text-gray-600">Tercapai</div>
                        </div>
                    </div>

                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-300"
                            style="width: {{ min($progress, 100) }}%"></div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Program</h2>
                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        {!! nl2br(e($donasi->deskripsi)) !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <div class="bg-blue-50 p-4 rounded-lg flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">Tanggal Mulai</div>
                            <div class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($donasi->tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 p-4 rounded-lg flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <div>
                            <div class="font-medium text-gray-900">Tanggal Berakhir</div>
                            <div class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                            </div>
                        </div>
                    </div>
                </div>

                @if ($donasi->status === 'aktif')
                    <div class="text-center">
                        <a href="#" onclick="showDonationModal()"
                            class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                            Donasi Sekarang
                        </a>
                    </div>
                @else
                    <div class="text-center">
                        <div
                            class="inline-flex items-center px-8 py-4 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            Program Donasi Tidak Aktif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="donationModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Berdonasi untuk {{ $donasi->judul }}</h3>
                <button onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="donasi_id" value="{{ $donasi->id }}">
                <!-- Input fields as before -->
                <!-- ... -->
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeDonationModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Lanjutkan Donasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDonationModal() {
            document.getElementById('donationModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        document.getElementById('donationModal').addEventListener('click', function(e) {
            if (e.target === this) closeDonationModal();
        });
        document.getElementById('jumlah_donasi')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');

                    // Update button icon
                    const svg = mobileMenuButton.querySelector('svg');
                    if (mobileMenu.classList.contains('hidden')) {
                        svg.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                    } else {
                        svg.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                    }
                });
            }

            // Profile dropdown toggle (desktop)
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');

            if (userMenuButton && userDropdown) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }

            // Close mobile menu when clicking on links
            const mobileLinks = mobileMenu?.querySelectorAll('a');
            if (mobileLinks) {
                mobileLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                        const svg = mobileMenuButton.querySelector('svg');
                        svg.innerHTML =
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                    });
                });
            }
        });
    </script>

</body>

</html>
