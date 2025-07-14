<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan - Darikita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    {{-- Jika Anda memiliki file CSS kustom, pastikan path-nya benar --}}
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .btn-primary {
            background: linear-gradient(90deg, #3B82F6, #60A5FA);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
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

        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body>
    @include('partials.nav.welcome')

    <!-- Header Section -->
    <header class="bg-white shadow-sm">
        <!-- Konsisten dengan welcome page: container mx-auto px-4 sm:px-6 lg:px-8 -->
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Temukan Peluang Beraksi</h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Jelajahi berbagai kegiatan sosial, pendidikan, dan
                bantuan bencana untuk membuat dampak positif di masyarakat.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Section dengan padding konsisten -->
        <div class="lg:mx-32 bg-white rounded-xl shadow-md border p-6 mb-8">
            <form method="GET" action="{{ route('kegiatan') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Nama kegiatan..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Jenis Kegiatan Filter -->
                    <div>
                        <label for="jenis_kegiatan" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                            Kegiatan</label>
                        <select id="jenis_kegiatan" name="jenis_kegiatan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisKegiatanOptions as $jenis)
                                <option value="{{ $jenis }}" @selected(request('jenis_kegiatan') == $jenis)>
                                    {{ ucfirst($jenis) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                        <div class="relative">
                            <input type="text" id="provinsi" name="provinsi" value="{{ request('provinsi') }}"
                                placeholder="Contoh: Jawa Barat"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-200 mt-4">
                    <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('kegiatan') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @if ($kegiatans->count() > 0)
            <!-- Kegiatan Grid dengan padding konsisten seperti welcome page -->
            <div class="lg:px-32 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                @foreach ($kegiatans as $kegiatan)
                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2 border border-gray-100 flex flex-col">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $kegiatan->gambar_sampul ? asset('storage/' . $kegiatan->gambar_sampul) : 'https://placehold.co/600x400/3B82F6/FFFFFF?text=Kegiatan' }}"
                                alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-full object-cover">
                            <div
                                class="absolute top-4 right-4 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                {{ ucfirst($kegiatan->jenis_kegiatan) }}
                            </div>
                            <div
                                class="absolute top-4 left-4 bg-white bg-opacity-90 text-gray-800 text-xs font-bold px-3 py-1 rounded-full">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai_kegiatan)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 flex-grow">
                                {{ $kegiatan->nama_kegiatan }}
                            </h3>
                            <div class="flex items-center text-gray-600 text-sm mb-3">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="line-clamp-1">{{ $kegiatan->kabupaten_kota }},
                                    {{ $kegiatan->provinsi }}</span>
                            </div>
                            <div class="mt-auto pt-4">
                                <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}"
                                    class="w-full block text-center bg-green-600 hover:bg-green-700 py-2.5 text-white rounded-lg font-medium transition-all">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="lg:mx-32 max-w-2xl mx-auto text-center py-12">
                <div class="bg-white rounded-lg shadow-sm border p-8">
                    <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Kegiatan Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Coba ubah kriteria pencarian atau filter untuk melihat hasil yang
                        berbeda.</p>
                    <a href="{{ route('kegiatan') }}" class="btn-primary text-white px-6 py-2 rounded-lg">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif

        <!-- Pagination dengan padding konsisten -->
        <div class="lg:mx-32 bg-white rounded-lg shadow-sm border p-4">
            {{ $kegiatans->appends(request()->query())->links() }}
        </div>
    </main>

    <!-- Flowbite JS -->
    <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>

</html>
