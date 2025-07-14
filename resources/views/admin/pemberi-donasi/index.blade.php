<x-admin-layout>
    <x-slot name="header">
        Daftar Donatur
    </x-slot>

    <div class="py-4">
        <!-- Flash Messages Section -->
        <div class="">
            @if (session('success'))
                <div
                    class="alert alert-success mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6">
                <a href="{{ route('pemberi-donasi.create') }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Donatur Baru
                </a>
            </div>

            <!-- Donasi Table -->
            @if ($pemberiDonasis->count())
                <div class="bg-white shadow rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3">No</th>
                                @if (Auth::user()->hasRole('admin'))
                                    <th class="px-6 py-3">Donatur</th>
                                @endif
                                <th class="px-6 py-3">Program Donasi</th>
                                <th class="px-6 py-3">Jumlah</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemberiDonasis as $index => $donasi)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $index + $pemberiDonasis->firstItem() }}</td>

                                    @if (Auth::user()->hasRole('admin'))
                                        <td class="px-6 py-4">
                                            <div class="font-medium">{{ $donasi->user->name ?? 'Anonim' }}</div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $donasi->user->email ?? '' }}</div>
                                        </td>
                                    @endif

                                    <td class="px-6 py-4">
                                        <div class="font-medium">
                                            {{ $donasi->donasi->nama_bencana ?? 'Program tidak ditemukan' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="font-medium">Rp
                                            {{ number_format($donasi->jumlah, 0, ',', '.') }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $donasi->tanggal_donasi->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-col space-y-2">
                                            <a href="{{ route('pemberi-donasi.show', $donasi->id) }}"
                                                class="text-indigo-600 hover:underline text-xs">
                                                Detail
                                            </a>

                                            @if (Auth::user()->hasRole('admin'))
                                                <a href="{{ route('pemberi-donasi.edit', $donasi->id) }}"
                                                    class="text-blue-600 hover:underline text-xs">
                                                    Edit
                                                </a>

                                                <form action="{{ route('pemberi-donasi.destroy', $donasi->id) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:underline text-xs text-left">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                <div class="mt-6">
                    {{ $pemberiDonasis->links() }}
                </div>
            @else
                <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 p-4 rounded-md shadow-sm">
                    <p>Belum ada data donasi yang tercatat.</p>
                </div>
            @endif

            <!-- Admin-only Report Section -->
            @if (Auth::user()->hasRole('admin'))
                <div class="mt-6">
                    <a href="{{ route('pemberi-donasi.report') }}"
                        class="btn btn-secondary py-2 px-4 rounded-lg text-white bg-gray-600 hover:bg-gray-700 transition duration-300">
                        Lihat Laporan Donasi
                    </a>
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>
