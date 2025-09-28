<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Darikita</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        {{-- FIXED: Changed to be fixed on all screen sizes for consistent full height --}}
        <aside id="sidebar"
            class="w-64 bg-white shadow-md transform -translate-x-full md:translate-x-0 transition-transform duration-300 fixed z-50 h-screen">
            <div class="p-6 border-b flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('logo.png') }}" class="h-8" alt="Logo" />
                    <h1 class="font-bold text-lg">Darikita</h1>
                </div>
                <button id="close-sidebar" class="md:hidden text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="mt-6">
                @foreach (config('admin-sidebar') as $sidebar)
                    <ul>
                        <li class="px-6 py-2 hover:bg-gray-200">
                            <a
                                href="{{ isset($sidebar['route']) && $sidebar['route'] ? route($sidebar['route']) : '#' }}">
                                {{ $sidebar['title'] }}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 flex flex-col md:ml-64">
            {{-- Header --}}
            <header class="bg-white shadow p-6 flex justify-between items-center">
                <div class="flex items-center">
                    <button id="toggle-sidebar" class="mr-4 text-gray-500 hover:text-gray-700 md:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-xl font-semibold">
                        {{ $header ?? 'Dashboard' }}
                    </h1>
                </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const closeBtn = document.getElementById('close-sidebar');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }

            // Toggle sidebar with the hamburger icon
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent the click from bubbling up to the document
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            // Close sidebar with the 'X' button
            closeBtn.addEventListener('click', function() {
                closeSidebar();
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                // Check if the screen is mobile-sized and the sidebar is open
                if (window.innerWidth < 768 && !sidebar.classList.contains('-translate-x-full')) {
                    // Check if the click was outside the sidebar and not on the toggle button itself
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        closeSidebar();
                    }
                }
            });
        });
    </script>
</body>

</html>
