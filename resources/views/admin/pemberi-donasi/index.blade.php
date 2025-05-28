<x-admin-layout>
    <x-slot name="header">
        Daftar Donatur
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <!-- Header Section -->
                <div class="px-6 py-4 flex justify-between items-center border-b">
                    <h2 class="text-2xl font-semibold text-gray-800">Daftar Donatur</h2>
                    <a href="{{ route('pemberi-donasi.create') }}"
                        class="btn btn-primary py-2 px-4 rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-300">
                        Donasi Baru
                    </a>
                </div>

                <!-- Flash Messages Section -->
                <div class="px-6 py-4">
                    @if (session('success'))
                        <div
                            class="alert alert-success mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="alert alert-danger mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Donasi Table -->
                    @if ($pemberiDonasis->count())
                        <div class="overflow-x-auto rounded-lg shadow-sm">
                            <table class="min-w-full text-sm table-auto">
                                <thead class="bg-gray-200 text-gray-700">
                                    <tr>
                                        <th class="py-3 px-6 text-left">No</th>
                                        @if (Auth::user()->hasRole('admin'))
                                            <th class="py-3 px-6 text-left">Donatur</th>
                                        @endif
                                        <th class="py-3 px-6 text-left">Program Donasi</th>
                                        <th class="py-3 px-6 text-left">Jumlah</th>
                                        <th class="py-3 px-6 text-left">Tanggal</th>
                                        <th class="py-3 px-6 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pemberiDonasis as $index => $donasi)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-2 px-6">{{ $index + $pemberiDonasis->firstItem() }}</td>
                                            @if (Auth::user()->hasRole('admin'))
                                                <td class="py-2 px-6">{{ $donasi->user->name }}</td>
                                            @endif
                                            <td class="py-2 px-6">
                                                {{ $donasi->donasi->nama_bencana ?? 'Program tidak ditemukan' }}</td>
                                            <td class="py-2 px-6">Rp {{ number_format($donasi->jumlah, 0, ',', '.') }}
                                            </td>
                                            <td class="py-2 px-6">{{ $donasi->tanggal_donasi->format('d M Y') }}</td>
                                            <td class="py-2 px-6">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('pemberi-donasi.show', $donasi->id) }}"
                                                        class="btn btn-sm btn-info text-white bg-blue-500 hover:bg-blue-600 rounded-lg px-4 py-2">
                                                        Detail
                                                    </a>

                                                    @if (Auth::user()->hasRole('admin'))
                                                        <a href="{{ route('pemberi-donasi.edit', $donasi->id) }}"
                                                            class="btn btn-sm btn-warning text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg px-4 py-2">
                                                            Edit
                                                        </a>

                                                        <form
                                                            action="{{ route('pemberi-donasi.destroy', $donasi->id) }}"
                                                            method="POST" class="inline-block"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-danger text-white bg-red-500 hover:bg-red-600 rounded-lg px-4 py-2">
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
                        <div class="alert alert-info bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded">
                            Belum ada data donasi.
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
        </div>
    </div>
</x-admin-layout>
