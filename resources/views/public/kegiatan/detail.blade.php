<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darikita</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            overflow-x: hidden;
            /* Mencegah scroll horizontal */
        }

        .hero-pattern {
            background-color: #f9fafb;
            background-image: url("data:image/svg+xml,%3Csvg width='90' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ddd' fill-opacity='0.35' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .stats-item {
            transition: all 0.3s ease;
        }

        .stats-item:hover {
            transform: translateY(-5px);
        }

        .category-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-10px);
        }

        .category-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3B82F6, #60A5FA);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.5s ease;
        }

        .category-card:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }

        .testimonial-card {
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: scale(1.03);
        }

        .btn-primary {
            background: linear-gradient(90deg, #3B82F6, #60A5FA);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        .btn-secondary {
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .impact-number {
            font-weight: 700;
            background: linear-gradient(90deg, #3B82F6, #60A5FA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cta-section {
            background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
        }

        .section-title::after {
            content: "";
            display: block;
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, #3B82F6, #60A5FA);
            margin: 0.75rem auto 0;
            border-radius: 2px;
        }
    </style>
</head>

<body>
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

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Form -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            {{ $kegiatan->nama_kegiatan ?? 'Kegiatan' }}
                        </h3>
                        <p class="text-sm text-gray-600">Silakan lengkapi data berikut untuk mendaftar kegiatan</p>
                    </div>

                    <!-- Gambar Kegiatan -->
                    @if ($kegiatan->gambar_lokasi)
                        <div class="mb-6">
                            <!-- Main Image Display -->
                            <div class="relative rounded-lg overflow-hidden shadow-lg mb-4">
                                <div id="mainImageContainer" class="relative h-96">
                                    @foreach ($kegiatan->gambar_lokasi as $index => $gambar)
                                        <img src="{{ asset('storage/' . $gambar) }}"
                                            alt="Lokasi Kegiatan {{ $index + 1 }}"
                                            class="main-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                                            data-index="{{ $index }}">
                                    @endforeach

                                    <!-- Image Counter -->
                                    <div
                                        class="absolute top-6 right-6 bg-black/50 backdrop-blur-sm rounded-full px-3 py-1 text-white text-sm">
                                        <span id="currentImage">1</span> / {{ count($kegiatan->gambar_lokasi) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Thumbnails -->
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                @foreach ($kegiatan->gambar_lokasi as $index => $gambar)
                                    <button
                                        class="thumbnail flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-all duration-200 {{ $index === 0 ? 'border-blue-500 opacity-100' : 'border-transparent opacity-70 hover:opacity-100' }}"
                                        data-index="{{ $index }}">
                                        <img src="{{ asset('storage/' . $gambar) }}"
                                            alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('public.kegiatan.daftar', $kegiatan->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Display general error messages -->
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            Terdapat {{ $errors->count() }} kesalahan pada form:
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul role="list" class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Latar Belakang -->
                        <div>
                            <label for="latar_belakang" class="block text-sm font-medium text-gray-700 mb-2">
                                Latar Belakang <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="latar_belakang" id="latar_belakang"
                                value="{{ old('latar_belakang') }}" placeholder="Sebutkan latar belakang Anda..."
                                class="w-full px-3 py-2 border {{ $errors->has('latar_belakang') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            @error('latar_belakang')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pernah Relawan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Pernah Menjadi Relawan? <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" id="pernah_relawan_pernah" name="pernah_relawan"
                                        value="1" {{ old('pernah_relawan') == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                        onchange="toggleNamaKegiatan()" required>
                                    <label for="pernah_relawan_pernah"
                                        class="ml-2 text-sm text-gray-700">Pernah</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="pernah_relawan_belum" name="pernah_relawan"
                                        value="0" {{ old('pernah_relawan') == '0' ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                        onchange="toggleNamaKegiatan()" required>
                                    <label for="pernah_relawan_belum" class="ml-2 text-sm text-gray-700">Belum
                                        Pernah</label>
                                </div>
                            </div>
                            @error('pernah_relawan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Kegiatan Sebelumnya -->
                        <div id="nama_kegiatan_field"
                            style="display: {{ old('pernah_relawan') == 'pernah' ? 'block' : 'none' }};">
                            <label for="nama_kegiatan_sebelumnya"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Kegiatan Sebelumnya
                            </label>
                            <textarea name="nama_kegiatan_sebelumnya" id="nama_kegiatan_sebelumnya" rows="3"
                                placeholder="Sebutkan nama kegiatan yang pernah diikuti sebelumnya..."
                                class="w-full px-3 py-2 border {{ $errors->has('nama_kegiatan_sebelumnya') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('nama_kegiatan_sebelumnya') }}</textarea>
                            @error('nama_kegiatan_sebelumnya')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Informasi Kendaraan -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Informasi Kendaraan</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Jenis Kendaraan -->
                                <div>
                                    <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Kendaraan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenis_kendaraan" id="jenis_kendaraan" required
                                        class="w-full px-3 py-2 border {{ $errors->has('jenis_kendaraan') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Pilih Jenis Kendaraan</option>
                                        <option value="motor"
                                            {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                                        <option value="mobil"
                                            {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                                        <option value="tidak_ada"
                                            {{ old('jenis_kendaraan') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada
                                            Kendaraan</option>
                                    </select>
                                    @error('jenis_kendaraan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Merk Kendaraan -->
                                <div>
                                    <label for="merk_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                        Merk Kendaraan
                                    </label>
                                    <input type="text" name="merk_kendaraan" id="merk_kendaraan"
                                        value="{{ old('merk_kendaraan') }}"
                                        placeholder="Contoh: Honda, Toyota, Yamaha"
                                        class="w-full px-3 py-2 border {{ $errors->has('merk_kendaraan') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('merk_kendaraan')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Siap Kontribusi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Siap Berkontribusi? <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="radio" id="siap_kontribusi_ya" name="siap_kontribusi"
                                        value="1" {{ old('siap_kontribusi') == '1' ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                    <label for="siap_kontribusi_ya" class="ml-2 text-sm text-gray-700">Ya, siap
                                        berkontribusi</label>
                                </div>
                                <div class="flex items-center">
                                    <input type="radio" id="siap_kontribusi_tidak" name="siap_kontribusi"
                                        value="0" {{ old('siap_kontribusi') == '0' ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                    <label for="siap_kontribusi_tidak" class="ml-2 text-sm text-gray-700">Belum
                                        siap</label>
                                </div>
                            </div>
                            @error('siap_kontribusi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Upload Files -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Upload Bukti</h4>

                            <div class="space-y-4">
                                <!-- Bukti Follow -->
                                <div>
                                    <label for="bukti_follow" class="block text-sm font-medium text-gray-700 mb-2">
                                        Bukti Follow Social Media <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="bukti_follow"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 {{ $errors->has('bukti_follow') ? 'border-red-500' : 'border-gray-300' }} border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik
                                                        untuk upload</span> bukti follow</p>
                                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                            </div>
                                            <input id="bukti_follow" name="bukti_follow" type="file"
                                                class="hidden" accept="image/*" required />
                                        </label>
                                    </div>
                                    @error('bukti_follow')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bukti Repost -->
                                <div>
                                    <label for="bukti_repost" class="block text-sm font-medium text-gray-700 mb-2">
                                        Bukti Repost/Share <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="bukti_repost"
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 {{ $errors->has('bukti_repost') ? 'border-red-500' : 'border-gray-300' }} border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik
                                                        untuk upload</span> bukti repost</p>
                                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                            </div>
                                            <input id="bukti_repost" name="bukti_repost" type="file"
                                                class="hidden" accept="image/*" required />
                                        </label>
                                    </div>
                                    @error('bukti_repost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('welcome') }}"
                                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleNamaKegiatan() {
            const pernahRadio = document.getElementById('pernah_relawan_pernah');
            const namaKegiatanField = document.getElementById('nama_kegiatan_field');
            const namaKegiatanInput = document.getElementById('nama_kegiatan_sebelumnya');

            if (pernahRadio.checked) {
                namaKegiatanField.style.display = 'block';
                namaKegiatanInput.required = true;
            } else {
                namaKegiatanField.style.display = 'none';
                namaKegiatanInput.required = false;
                namaKegiatanInput.value = '';
            }
        }

        // File upload preview
        function handleFileUpload(inputId) {
            const input = document.getElementById(inputId);
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const label = input.parentNode;
                    const fileName = file.name;
                    label.querySelector('p').innerHTML =
                        `<span class="font-semibold text-green-600">File dipilih:</span> ${fileName}`;
                }
            });
        }

        // Initialize file upload handlers
        document.addEventListener('DOMContentLoaded', function() {
            handleFileUpload('bukti_follow');
            handleFileUpload('bukti_repost');
        });

        // JavaScript untuk Carousel Gambar
        document.addEventListener('DOMContentLoaded', function() {
            const mainImages = document.querySelectorAll('.main-image');
            const thumbnails = document.querySelectorAll('.thumbnail');
            const currentImageSpan = document.getElementById('currentImage');

            let currentIndex = 0;
            const totalImages = mainImages.length;

            function showImage(index) {
                // Hide all images
                mainImages.forEach(img => img.classList.remove('opacity-100'));
                mainImages.forEach(img => img.classList.add('opacity-0'));

                // Show current image
                mainImages[index].classList.remove('opacity-0');
                mainImages[index].classList.add('opacity-100');

                // Update thumbnails
                thumbnails.forEach(thumb => {
                    thumb.classList.remove('border-blue-500', 'opacity-100');
                    thumb.classList.add('border-transparent', 'opacity-70');
                });
                thumbnails[index].classList.remove('border-transparent', 'opacity-70');
                thumbnails[index].classList.add('border-blue-500', 'opacity-100');

                // Update counter
                if (currentImageSpan) {
                    currentImageSpan.textContent = index + 1;
                }

                currentIndex = index;
            }

            // Thumbnail clicks
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener('click', () => {
                    showImage(index);
                });
            });
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
