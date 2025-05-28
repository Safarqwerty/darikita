<x-admin-layout>
    <x-slot name="header">
        Admin Dashboard
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Pengguna -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-600 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" viewBox="0 0 28 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Icon path ... (sama seperti yang kamu tulis) -->
                        <path d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z" fill="currentColor"></path>
                        <!-- (cut for brevity) -->
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Pengguna
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        120
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Kegiatan -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Shopping cart icon -->
                        <path d="M4.2 1.4C3.4 1.4 2.8 2 2.8 2.8C2.8 3.6 3.4 4.2 4.2 4.2H5.9L6.3 5.9L8.2 13.6L7 14.8C5.2 16.6 6.5 19.6 9 19.6H21C21.8 19.6 22.4 19 22.4 18.2C22.4 17.4 21.8 16.8 21 16.8H9L10.4 15.4H19.6C20.1 15.4 20.6 15.1 20.9 14.6L25.1 6.2C25.3 5.8 25.2 5.3 25 4.9C24.7 4.5 24.3 4.2 23.8 4.2H8.8L8.4 2.5C8.2 1.8 7.6 1.4 7 1.4H4.2Z" fill="currentColor"/>
                        <circle cx="20.3" cy="23.1" r="2.1" stroke="currentColor" stroke-width="1.5" />
                        <circle cx="9.1" cy="23.1" r="2.1" stroke="currentColor" stroke-width="1.5" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Kegiatan
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        32
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Donasi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2s-3 1.343-3 3 1.343 3 3 3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 22s1-4 8-4 8 4 8 4H4z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Donasi
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        Rp 18.250.000
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Pendaftar -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 11a3 3 0 10-6 0 3 3 0 006 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Pendaftar
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        75
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
