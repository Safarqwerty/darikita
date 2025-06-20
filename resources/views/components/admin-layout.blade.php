<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Darikita</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white shadow-md hidden md:block">
            <div class="p-6 font-bold text-lg border-b">
                <h1>Darikita</h1>
            </div>
            <nav class="mt-6">
                @foreach (config('sidebar') as $sidebar)
                    <ul>
                        <li class="px-6 py-2 hover:bg-gray-200">
                            <a href="{{ route($sidebar['route']) }}">{{ $sidebar['title'] }}</a>
                        </li>
                    </ul>
                @endforeach
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col">
            {{-- Header --}}
            <header class="bg-white shadow p-6 flex justify-between items-center">
                <h1 class="text-xl font-semibold">
                    {{ $header ?? 'Dashboard' }}
                </h1>
                <div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-red-500 hover:underline">Logout</button>
                    </form>
                </div>
            </header>

            {{-- Content --}}
            <main class="p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
