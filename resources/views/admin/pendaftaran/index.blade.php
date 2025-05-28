<x-admin-layout>
    <x-slot name="header">
        Daftar Pendaftar Kegiatan
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 rounded-md bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">No</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tanggal Daftar
                                    </th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Peserta</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Kegiatan</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Status</th>
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($pendaftaran as $index => $daftar)
                                    <tr>
                                        <td class="px-4 py-2">{{ $index + $pendaftaran->firstItem() }}</td>
                                        <td class="px-4 py-2">{{ $daftar->tanggal_daftar->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-2">{{ $daftar->user->name }}</td>
                                        <td class="px-4 py-2">{{ $daftar->kegiatan->judul }}</td>
                                        <td class="px-4 py-2">
                                            @if ($daftar->status == 'pending')
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @elseif ($daftar->status == 'diterima')
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Diterima
                                                </span>
                                            @elseif ($daftar->status == 'ditolak')
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 space-x-1">
                                            <a href="{{ route('pendaftaran.show', $daftar->id) }}"
                                                class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                                                <i class="fa fa-eye mr-1"></i>Lihat
                                            </a>

                                            @if ($daftar->status == 'pending')
                                                <form action="{{ route('pendaftaran.approve', $daftar->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                                                        <i class="fa fa-check mr-1"></i>Terima
                                                    </button>
                                                </form>

                                                <form action="{{ route('pendaftaran.reject', $daftar->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                                        <i class="fa fa-times mr-1"></i>Tolak
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                            Tidak ada data pendaftaran.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pendaftaran->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
