<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Donasi - {{ $donasi->judul }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css') <!-- Jika pakai Vite -->
</head>

<body class="bg-gray-50">

    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('welcome') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                @if ($donasi->gambar)
                    <div class="w-full h-64 md:h-80">
                        <img src="{{ asset('storage/' . $donasi->gambar) }}" alt="{{ $donasi->judul }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 md:mb-0">
                            {{ $donasi->judul }}
                        </h1>
                        <span
                            class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                        {{ $donasi->status === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($donasi->status) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-blue-600">
                                    Rp {{ number_format($donasi->terkumpul, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-600">Terkumpul</div>
                            </div>

                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-800">
                                    Rp {{ number_format($donasi->target_donasi, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-600">Target</div>
                            </div>

                            <div class="text-center">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ number_format($progress, 1) }}%
                                </div>
                                <div class="text-sm text-gray-600">Tercapai</div>
                            </div>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-300"
                                style="width: {{ min($progress, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Program</h2>
                        <div class="prose max-w-none text-gray-700 leading-relaxed">
                            {!! nl2br(e($donasi->deskripsi)) !!}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="bg-blue-50 p-4 rounded-lg flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">Tanggal Mulai</div>
                                <div class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_mulai)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <div>
                                <div class="font-medium text-gray-900">Tanggal Berakhir</div>
                                <div class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($donasi->tanggal_berakhir)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($donasi->status === 'aktif')
                        <div class="text-center">
                            <a href="#" onclick="showDonationModal()"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-green-600 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                                Donasi Sekarang
                            </a>
                        </div>
                    @else
                        <div class="text-center">
                            <div
                                class="inline-flex items-center px-8 py-4 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                Program Donasi Tidak Aktif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="donationModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Berdonasi untuk {{ $donasi->judul }}</h3>
                <button onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form action="#" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="donasi_id" value="{{ $donasi->id }}">
                <!-- Input fields as before -->
                <!-- ... -->
                <div class="flex space-x-3 pt-4">
                    <button type="button" onclick="closeDonationModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Lanjutkan Donasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDonationModal() {
            document.getElementById('donationModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        document.getElementById('donationModal').addEventListener('click', function(e) {
            if (e.target === this) closeDonationModal();
        });
        document.getElementById('jumlah_donasi')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });
    </script>

</body>

</html>
