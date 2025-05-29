<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-3">
                <div class="p-6 text-gray-900">
                    {{ __("Selamat datang di aplikasi kami!") }}
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Kegiatan yang Tersedia</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($activeEvents as $item)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <!-- Gambar Lokasi -->
                                <div class="relative h-48 bg-gray-200">
                                    @if($item->gambar_lokasi)
                                        <img src="{{ asset('storage/' . $item->gambar_lokasi) }}" 
                                            alt="Lokasi {{ $item->judul }}" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">
                                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badge Jenis Kegiatan -->
                                    <div class="absolute top-3 left-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($item->jenis_kegiatan == 'Workshop')
                                                bg-blue-100 text-blue-800
                                            @elseif($item->jenis_kegiatan == 'Seminar')
                                                bg-green-100 text-green-800
                                            @elseif($item->jenis_kegiatan == 'Pelatihan')
                                                bg-purple-100 text-purple-800
                                            @elseif($item->jenis_kegiatan == 'Kompetisi')
                                                bg-red-100 text-red-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $item->jenis_kegiatan }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-5">
                                    <!-- Judul -->
                                    <h4 class="font-bold text-lg text-gray-900 mb-3 line-clamp-2 leading-tight">
                                        {{ str($item->judul)->limit(25, '...') }}
                                    </h4>

                                    <!-- Lokasi -->
                                    @if($item->lokasi)
                                    <div class="flex items-center text-gray-600 mb-2">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">{{ $item->lokasi }}</span>
                                    </div>
                                    @endif

                                    <!-- Tanggal -->
                                    <div class="flex items-center text-gray-600 mb-3">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-sm">
                                            {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                            @if($item->tanggal_selesai && $item->tanggal_selesai != $item->tanggal_mulai)
                                                - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                            @endif
                                        </span>
                                    </div>

                                    <!-- Batas Pendaftar -->
                                    @if($item->batas_pendaftar)
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center text-gray-600">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                            </svg>
                                            <span class="text-sm">Maks. {{ $item->batas_pendaftar }} peserta</span>
                                        </div>
                                        
                                        <!-- Status ketersediaan -->
                                        @php
                                            $pendaftar_saat_ini = $item->pendaftaran_count ?? 0;
                                            $persentase = ($pendaftar_saat_ini / $item->batas_pendaftar) * 100;
                                        @endphp
                                        
                                        <div class="text-right">
                                            <span class="text-xs font-medium
                                                @if($persentase >= 90)
                                                    text-red-600
                                                @elseif($persentase >= 70)
                                                    text-yellow-600
                                                @else
                                                    text-green-600
                                                @endif">
                                                {{ $pendaftar_saat_ini }}/{{ $item->batas_pendaftar }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                                        <div class="h-2 rounded-full transition-all duration-300
                                            @if($persentase >= 90)
                                                bg-red-500
                                            @elseif($persentase >= 70)
                                                bg-yellow-500
                                            @else
                                                bg-green-500
                                            @endif" 
                                            style="width: {{ min($persentase, 100) }}%">
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="flex justify-between items-center pt-2">
                                        @if(!isset($item->batas_pendaftar) || $persentase < 100)
                                            <a 
                                                href="{{ route('public.kegiatan.show', $item->id) }}"
                                                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium transition-colors duration-200">
                                                Daftar
                                            </a>
                                        @else
                                            <span class="bg-gray-400 text-white py-2 px-4 rounded-md text-sm font-medium cursor-not-allowed">
                                                Penuh
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($registrationActivities as $item)
                                
                            @endforeach
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kegiatan->judul }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->kegiatan->tanggal_mulai)->format('d m Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $item->kegiatan->lokasi }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($item->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $item->status }}
                                        </span>
                                    @elseif ($item->status == 'diterima')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $item->status }}
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            {{ $item->status }}
                                        </span>                                        
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
