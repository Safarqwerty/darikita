<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>Darikita - Donasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <style>
        .btn-primary {
            background: linear-gradient(90deg, #01577e, #198fbf);
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

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .progress-bar {
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #34d399);
            transition: width 0.3s ease;
        }

        .donation-status {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 10;
        }

        .status-open {
            background: #10b981;
        }

        .status-closed {
            background: #ef4444;
        }

        .deadline-warning {
            background: #f59e0b;
        }

        .deadline-urgent {
            background: #ef4444;
        }
    </style>
</head>

<body>
    @include('partials.nav.welcome')

    <!-- Header Section -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Berikan Bantuan Melalui Donasi</h1>
            <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">Salurkan kebaikan Anda untuk membantu sesama melalui
                berbagai program donasi yang transparan dan terpercaya.</p>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filter Section -->
        <div class="lg:mx-32 bg-white rounded-xl shadow-md border p-6 mb-8">
            <form method="GET" action="{{ route('donasi') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Search Input -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Donasi</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Nama donasi..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Jenis Donasi Filter -->
                    <div>
                        <label for="jenis_donasi" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                            Donasi</label>
                        <select id="jenis_donasi" name="jenis_donasi"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisDonasiOptions as $jenis)
                                <option value="{{ $jenis }}" @selected(request('jenis_donasi') == $jenis)>
                                    {{ ucfirst($jenis) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="open" @selected(request('status') == 'open')>Masih Dibuka</option>
                            <option value="closed" @selected(request('status') == 'closed')>Ditutup</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap justify-end gap-4 pt-4 border-t border-gray-200 mt-4">
                    <a href="{{ route('donasi') }}"
                        class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                        Reset
                    </a>
                    <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg font-medium">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        @if ($donasis->count() > 0)
            <!-- Donasi Grid -->
            <div class="lg:px-32 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                @foreach ($donasis as $donasi)
                    @php
                        $progress =
                            $donasi->target_dana > 0 ? ($donasi->dana_terkumpul / $donasi->target_dana) * 100 : 0;
                        $daysLeft = \Carbon\Carbon::now()->diffInDays(
                            \Carbon\Carbon::parse($donasi->tanggal_selesai),
                            false,
                        );
                        $isExpired = $daysLeft < 0;
                        $isUrgent = $daysLeft <= 7 && $daysLeft >= 0;
                        $isWarning = $daysLeft <= 14 && $daysLeft > 7;
                    @endphp

                    <div
                        class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2 border border-gray-100 flex flex-col">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $donasi->gambar ? asset('storage/' . $donasi->gambar) : 'https://placehold.co/600x400/1b3866/FFFFFF?text=Donasi' }}"
                                alt="{{ $donasi->nama_donasi }}" class="w-full h-full object-cover">
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex items-center justify-between mb-2 mt-1">
                                <!-- Kategori Donasi -->
                                <span class="bg-[#01577e] text-white text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst($donasi->jenis_donasi) }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2">
                                {{ $donasi->nama_donasi }}
                            </h3>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>Terkumpul</span>
                                    <span>{{ number_format($progress, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-[#01577e] h-2.5 rounded-full"
                                        style="width: {{ min($progress, 100) }}%"></div>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <span class="font-semibold text-[#01577e]">
                                        Rp {{ number_format($donasi->dana_terkumpul, 0, ',', '.') }}
                                    </span>
                                    <span class="text-gray-500">
                                        Rp {{ number_format($donasi->target_dana, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Periode Donasi -->
                            <div class="flex items-center text-gray-600 text-sm mb-4">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span>{{ \Carbon\Carbon::parse($donasi->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_selesai)->format('d M Y') }}</span>
                            </div>

                            <div class="mt-auto pt-4">
                                @if ($donasi->status == 'closed' || $isExpired)
                                    <button disabled
                                        class="w-full block text-center bg-gray-400 py-2.5 text-white rounded-lg font-medium cursor-not-allowed">
                                        Donasi Ditutup
                                    </button>
                                @else
                                    <a href="{{ route('donasi.detail', $donasi->id) }}"
                                        class="w-full block text-center bg-[#01577e] hover:bg-[#01567eea] py-2.5 text-white rounded-lg font-medium transition-all">
                                        Donasi Sekarang
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="lg:mx-32 max-w-2xl mx-auto text-center py-12">
                <div class="bg-white rounded-lg shadow-sm border p-8">
                    <i class="fas fa-heart text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Donasi Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Coba ubah kriteria pencarian atau filter untuk melihat hasil yang
                        berbeda.</p>
                    <a href="{{ route('donasi') }}"
                        class="bg-[#01577e] hover:bg-[#142a4dee] text-white px-6 py-2 rounded-lg transition-all">
                        Reset Filter
                    </a>
                </div>
            </div>
        @endif

        <!-- Statistics Section -->
        @php
            $totalDonasi = $donasis->sum('dana_terkumpul');
            $totalProgram = $donasis->count();
            $programAktif = $donasis->where('status', 'open')->count();
        @endphp

        <!-- Pagination -->
        <div class="lg:mx-32 bg-white rounded-lg shadow-sm border p-4">
            {{ $donasis->appends(request()->query())->links() }}
        </div>
    </main>

    @include('partials.nav.footer')

    <!-- Scripts -->
    <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>

</html>
