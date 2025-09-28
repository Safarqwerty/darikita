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
                        <path
                            d="M18.2 9.08889C18.2 11.5373 16.3196 13.5222 14 13.5222C11.6804 13.5222 9.79999 11.5373 9.79999 9.08889C9.79999 6.64043 11.6804 4.65556 14 4.65556C16.3196 4.65556 18.2 6.64043 18.2 9.08889Z"
                            fill="currentColor"></path>
                        <path
                            d="M25.2 12.0444C25.2 13.6768 23.9464 15 22.4 15C20.8536 15 19.6 13.6768 19.6 12.0444C19.6 10.4121 20.8536 9.08889 22.4 9.08889C23.9464 9.08889 25.2 10.4121 25.2 12.0444Z"
                            fill="currentColor"></path>
                        <path
                            d="M19.6 20.1333C19.6 19.2222 19.2814 18.3556 18.8 17.6222C17.4 15.6333 14.9 14.3778 12.6 14.3778C10.3 14.3778 7.79999 15.6333 6.39999 17.6222C5.91857 18.3556 5.59999 19.2222 5.59999 20.1333V26.8222H19.6V20.1333Z"
                            fill="currentColor"></path>
                        <path
                            d="M8.4 12.0444C8.4 13.6768 7.14639 15 5.59999 15C4.05359 15 2.79999 13.6768 2.79999 12.0444C2.79999 10.4121 4.05359 9.08889 5.59999 9.08889C7.14639 9.08889 8.4 10.4121 8.4 12.0444Z"
                            fill="currentColor"></path>
                        <path
                            d="M22.4 26.8222V20.1333C22.4 19.2222 22.7186 18.3556 23.2 17.6222C24.6 15.6333 27.1 14.3778 29.4 14.3778C31.7 14.3778 34.2 15.6333 35.6 17.6222C36.0814 18.3556 36.4 19.2222 36.4 20.1333V26.8222H22.4Z"
                            fill="currentColor"></path>
                        <path
                            d="M6.39999 17.6222C7.79999 15.6333 10.3 14.3778 12.6 14.3778C14.9 14.3778 17.4 15.6333 18.8 17.6222C19.2814 18.3556 19.6 19.2222 19.6 20.1333V26.8222H5.59999V20.1333C5.59999 19.2222 5.91857 18.3556 6.39999 17.6222Z"
                            fill="currentColor"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Pengguna
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        {{ $totalUsers }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Kegiatan -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Kegiatan
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        {{ $totalKegiatan }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Donasi -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2s-3 1.343-3 3 1.343 3 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 22s1-4 8-4 8 4 8 4H4z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Donasi
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        Rp {{ number_format($totalDanaTerkumpul, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Pendaftar -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-500 bg-opacity-75">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M15 11a3 3 0 10-6 0 3 3 0 006 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="mb-2 text-sm font-medium text-gray-600">
                        Total Pendaftar
                    </p>
                    <p class="text-lg font-semibold text-gray-700">
                        {{ $totalPendaftar }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Daftar Pengguna</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jenis Kelamin
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nomor WA
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Daftar
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">
                                    {{ $user->jenis_kelamin }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $user->nomor_wa ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
