<x-admin-layout>
    <x-slot name="header">
        Daftar Pendaftar Kegiatan
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto">

            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-100 text-green-700 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 rounded-md bg-red-100 text-red-700 border border-red-300">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-x-auto">
                @if (request('nama_kegiatan'))
                    <div class="m-4 flex justify-between items-center">
                        <!-- Tombol Jalankan Seleksi Otomatis -->
                        <form method="POST" action="{{ route('pendaftaran.auto-approve', request('nama_kegiatan')) }}"
                            onsubmit="return confirm('Anda yakin ingin menjalankan proses seleksi otomatis? Semua pendaftar yang \'pending\' untuk kegiatan ini akan Diterima atau Ditolak berdasarkan ranking TOPSIS dan kuota yang tersedia.')">
                            @csrf
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                                Seleksi Otomatis (TOPSIS)
                            </button>
                        </form>

                        <!-- Filter Kegiatan -->
                        <form method="GET" action="{{ route('pendaftaran.index') }}" class="flex items-center gap-4">
                            <div>
                                <select name="nama_kegiatan"
                                    class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                                    <option value="">Semua Kegiatan</option>
                                    @foreach ($kegiatanOptions as $kegiatan)
                                        <option value="{{ $kegiatan->id }}"
                                            {{ request('nama_kegiatan') == $kegiatan->id ? 'selected' : '' }}>
                                            {{ $kegiatan->nama_kegiatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Filter</button>
                                <a href="{{ route('pendaftaran.index') }}"
                                    class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Reset</a>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Jika belum memilih kegiatan, hanya tampilkan form filter -->
                    <div class="m-4 flex justify-end items-center">
                        <form method="GET" action="{{ route('pendaftaran.index') }}" class="flex items-center gap-4">
                            <div>
                                <select name="nama_kegiatan"
                                    class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                                    <option value="">Semua Kegiatan</option>
                                    @foreach ($kegiatanOptions as $kegiatan)
                                        <option value="{{ $kegiatan->id }}"
                                            {{ request('nama_kegiatan') == $kegiatan->id ? 'selected' : '' }}>
                                            {{ $kegiatan->nama_kegiatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Filter</button>
                                <a href="{{ route('pendaftaran.index') }}"
                                    class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Reset</a>
                            </div>
                        </form>
                    </div>
                @endif

                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Nama Peserta</th>
                            <th class="px-6 py-3">Kegiatan</th>
                            <th class="px-6 py-3">Skor TOPSIS</th>
                            <th class="px-6 py-3">Tanggal Daftar</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftaran as $index => $daftar)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $pendaftaran->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $daftar['pendaftar']->user->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $daftar['pendaftar']->user->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">
                                        {{ $daftar['pendaftar']->kegiatan->nama_kegiatan ?? 'Kegiatan tidak ditemukan' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $daftar['score'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="wita-time"
                                        data-time="{{ $daftar['pendaftar']->tanggal_daftar->toISOString() }}">
                                        {{ $daftar['pendaftar']->tanggal_daftar->format('d M Y, H:i') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($daftar['pendaftar']->status == 'pending')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif ($daftar['pendaftar']->status == 'diterima')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Diterima
                                        </span>
                                    @elseif ($daftar['pendaftar']->status == 'ditolak')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('pendaftaran.show', $daftar['pendaftar']->id) }}"
                                        class="text-indigo-600 hover:underline text-xs">
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data pendaftaran yang cocok dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $pendaftaran->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.wita-time').forEach(el => {
                const utcTime = new Date(el.dataset.time);

                // The toLocaleDateString with timeZone option is more reliable
                // for converting time zones than manual offset.
                const options = {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false,
                    timeZone: 'Asia/Makassar' // WITA
                };

                el.textContent = new Intl.DateTimeFormat('id-ID', options).format(utcTime) + ' WITA';
            });
        });
    </script>
</x-admin-layout>
