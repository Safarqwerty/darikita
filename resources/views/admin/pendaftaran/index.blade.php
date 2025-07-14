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

            <div class="bg-white shadow rounded-lg overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Nama Peserta</th>
                            <th class="px-6 py-3">Kegiatan</th>
                            <th class="px-6 py-3">Tanggal Daftar</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftaran as $index => $daftar)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $index + $pendaftaran->firstItem() }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $daftar->user->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $daftar->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">
                                        {{ $daftar->kegiatan->nama_kegiatan ?? 'Kegiatan tidak ditemukan' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $daftar->tanggal_daftar->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($daftar->status == 'pending')
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Menunggu
                                        </span>
                                    @elseif ($daftar->status == 'diterima')
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Diterima
                                        </span>
                                    @else
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('pendaftaran.show', $daftar->id) }}"
                                            class="text-indigo-600 hover:underline text-xs">
                                            Detail
                                        </a>
                                        @if ($daftar->status == 'pending')
                                            <form action="{{ route('pendaftaran.approve', $daftar->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-green-600 hover:underline text-xs text-left">Terima</button>
                                            </form>
                                            <form action="{{ route('pendaftaran.reject', $daftar->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-red-600 hover:underline text-xs text-left">Tolak</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data pendaftaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $pendaftaran->links() }}
            </div>

        </div>
    </div>
</x-admin-layout>
