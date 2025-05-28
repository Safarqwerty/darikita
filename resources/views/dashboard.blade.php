<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang di aplikasi kami!") }}
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Kegiatan yang Tersedia</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Di sini bisa ditambahkan loop untuk menampilkan daftar kegiatan -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold">Contoh Kegiatan 1</h4>
                            <p class="text-sm text-gray-600">Tanggal: 10 Mei 2025</p>
                            <p class="mt-2">Deskripsi singkat tentang kegiatan ini...</p>
                            <button class="mt-3 bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded">
                                Daftar
                            </button>
                        </div>

                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold">Contoh Kegiatan 2</h4>
                            <p class="text-sm text-gray-600">Tanggal: 15 Mei 2025</p>
                            <p class="mt-2">Deskripsi singkat tentang kegiatan ini...</p>
                            <button class="mt-3 bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded">
                                Daftar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Kegiatan yang Telah Didaftar</h3>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kegiatan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Kegiatan A</td>
                                <td class="px-6 py-4 whitespace-nowrap">20 April 2025</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Disetujui
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Kegiatan B</td>
                                <td class="px-6 py-4 whitespace-nowrap">1 Mei 2025</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Menunggu
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
