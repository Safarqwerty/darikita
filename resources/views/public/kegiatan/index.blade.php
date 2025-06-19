<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kegiatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Kegiatan</h1>
            <p class="mt-2 text-gray-600">Temukan berbagai kegiatan menarik yang tersedia</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-8">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kegiatan</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari berdasarkan nama atau deskripsi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Jenis Kegiatan Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kegiatan</label>
                        <select name="jenis_kegiatan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisKegiatanOptions as $jenis)
                                <option value="{{ $jenis }}"
                                    {{ request('jenis_kegiatan') == $jenis ? 'selected' : '' }}>
                                    {{ ucfirst($jenis) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                        <div class="relative">
                            <input type="text" name="provinsi" value="{{ request('provinsi') }}"
                                placeholder="Cari berdasarkan provinsi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-map-marker-alt absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2 pt-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ url()->current() }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        <i class="fas fa-times mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="mb-6">
            <p class="text-gray-600">
                <span class="font-medium">{{ $kegiatans->total() }} kegiatan</span> ditemukan
            </p>
        </div>

        @if ($kegiatans->count() > 0)
            <!-- Kegiatan Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach ($kegiatans as $kegiatan)
                    <div
                        class="bg-white rounded-lg shadow-sm border overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <div class="relative">
                            @if ($kegiatan->gambar_sampul)
                                <img src="{{ asset('storage/' . $kegiatan->gambar_sampul) }}"
                                    alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif

                            <div class="absolute top-4 right-4">
                                @php
                                    $now = now();
                                    $tanggalMulai = \Carbon\Carbon::parse($kegiatan->tanggal_mulai_kegiatan);
                                    $tanggalSelesai = \Carbon\Carbon::parse($kegiatan->tanggal_selesai_kegiatan);

                                    if ($now->lt($tanggalMulai)) {
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                        $statusText = 'Akan Datang';
                                    } elseif ($now->between($tanggalMulai, $tanggalSelesai)) {
                                        $statusClass = 'bg-green-100 text-green-800';
                                        $statusText = 'Sedang Berlangsung';
                                    } else {
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                        $statusText = 'Selesai';
                                    }
                                @endphp
                                <span class="{{ $statusClass }} px-3 py-1 rounded-full text-xs font-medium">
                                    {{ $statusText }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $kegiatan->nama_kegiatan }}</h3>
                                @php
                                    $jenisColors = [
                                        'seminar' => 'bg-purple-100 text-purple-800',
                                        'workshop' => 'bg-orange-100 text-orange-800',
                                        'pelatihan' => 'bg-blue-100 text-blue-800',
                                        'konferensi' => 'bg-indigo-100 text-indigo-800',
                                        'expo' => 'bg-green-100 text-green-800',
                                        'pendidikan' => 'bg-yellow-100 text-yellow-800',
                                        'bencana' => 'bg-red-100 text-red-800',
                                        'sosial' => 'bg-pink-100 text-pink-800',
                                    ];
                                    $colorClass =
                                        $jenisColors[$kegiatan->jenis_kegiatan] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="text-xs {{ $colorClass }} px-2 py-1 rounded-full">
                                    {{ ucfirst($kegiatan->jenis_kegiatan) }}
                                </span>
                            </div>

                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit($kegiatan->deskripsi_kegiatan, 120) }}
                            </p>

                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    <span>
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai_kegiatan)->format('d M Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai_kegiatan)->format('d M Y') }}
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    <span>{{ $kegiatan->provinsi }}, {{ $kegiatan->kabupaten_kota }}</span>
                                </div>
                                @if ($kegiatan->batas_pendaftar)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-users mr-2 text-gray-400"></i>
                                        <span>Maks. {{ $kegiatan->batas_pendaftar }} peserta</span>
                                    </div>
                                @endif
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar-plus mr-2 text-gray-400"></i>
                                    <span>
                                        Daftar:
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai_daftar)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai_daftar)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>

                            @php
                                $now = now();
                                $tanggalMulai = \Carbon\Carbon::parse($kegiatan->tanggal_mulai_kegiatan);
                                $tanggalSelesai = \Carbon\Carbon::parse($kegiatan->tanggal_selesai_kegiatan);
                                $tanggalSelesaiDaftar = \Carbon\Carbon::parse($kegiatan->tanggal_selesai_daftar);
                            @endphp

                            @if ($now->gt($tanggalSelesai))
                                <button class="w-full bg-gray-400 text-white py-2 px-4 rounded-lg cursor-not-allowed"
                                    disabled>
                                    Kegiatan Selesai
                                </button>
                            @elseif($now->between($tanggalMulai, $tanggalSelesai))
                                <button
                                    class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors duration-200">
                                    Sedang Berlangsung
                                </button>
                            @elseif($now->gt($tanggalSelesaiDaftar))
                                <button class="w-full bg-red-400 text-white py-2 px-4 rounded-lg cursor-not-allowed"
                                    disabled>
                                    Pendaftaran Ditutup
                                </button>
                            @else
                                <a href="{{ route('kegiatan.show', $kegiatan->id) }}"
                                    class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors duration-200 text-center">
                                    Lihat Detail
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white rounded-lg shadow-sm border p-4">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $kegiatans->firstItem() }}</span> sampai
                        <span class="font-medium">{{ $kegiatans->lastItem() }}</span> dari
                        <span class="font-medium">{{ $kegiatans->total() }}</span> hasil
                    </div>

                    {{ $kegiatans->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto text-center py-12">
                <div class="bg-white rounded-lg shadow-sm border p-8">
                    <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Kegiatan Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Coba ubah kriteria pencarian atau filter untuk melihat hasil yang
                        berbeda.</p>
                    <a href="{{ url()->current() }}"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif
    </div>
</body>

</html>
