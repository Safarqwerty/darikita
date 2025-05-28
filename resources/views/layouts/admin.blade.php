<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="flex">
            <div class="w-64 bg-gray-800 text-white min-h-screen p-4">
                <div class="text-2xl font-bold mb-6">Admin Panel</div>
                <nav>
                    <ul>
                        <li class="mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
                        </li>
                        @can('manage kegiatans')
                        <li class="mb-2">
                            <a href="{{ route('kegiatan.index') }}" class="block p-2 rounded hover:bg-gray-700">Kegiatan</a>
                        </li>
                        @endcan
                        @can('manage donasis')
                        <li class="mb-2">
                            <a href="{{ route('donasi.index') }}" class="block p-2 rounded hover:bg-gray-700">Donasi</a>
                        </li>
                        @endcan
                        @can('manage pendaftarans')
                        <li class="mb-2">
                            <a href="{{ route('pendaftaran.index') }}" class="block p-2 rounded hover:bg-gray-700">Pendaftaran</a>
                        </li>
                        @endcan
                        @can('manage users')
                        <li class="mb-2">
                            <a href="{{ route('users.index') }}" class="block p-2 rounded hover:bg-gray-700">Users</a>
                        </li>
                        @endcan
                        <li class="mb-2">
                            <a href="{{ route('profile.edit') }}" class="block p-2 rounded hover:bg-gray-700">Profil</a>
                        </li>
                        <li class="mb-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left p-2 rounded hover:bg-gray-700">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Content -->
            <div class="flex-1">
                <!-- Header -->
                <header class="bg-white shadow">
                    <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>
                </header>

                <!-- Main Content -->
                <main class="p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</body>
</html>
