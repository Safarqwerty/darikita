<x-admin-layout>
    <x-slot name="header">
        Daftar Kegiatan
    </x-slot>

    <div class="py-4">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-6">
            @can('manage kegiatans')
                <a href="{{ route('kegiatan.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Tambah Kegiatan
                </a>
            @endcan
        </div>
        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3">Nama Kegiatan</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Lokasi</th>
                        <th class="px-6 py-3">Kuota</th>
                        <th class="px-6 py-3">Pendaftaran</th>
                        <th class="px-6 py-3">Pelaksanaan</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $kegiatan)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $kegiatan->nama_kegiatan }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ Str::limit($kegiatan->deskripsi_kegiatan, 50) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                                    {{ ucfirst($kegiatan->jenis_kegiatan) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-medium">{{ $kegiatan->kabupaten_kota }}</div>
                                    <div class="text-xs text-gray-500">{{ $kegiatan->provinsi }}</div>
                                    <div class="text-xs text-gray-400">
                                        {{ $kegiatan->kecamatan }}, {{ $kegiatan->kelurahan_desa }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ $kegiatan->batas_pendaftar ?? 'Tak terbatas' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs">
                                    <div class="text-gray-600">Mulai:</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai_daftar)->format('d M Y') }}
                                    </div>
                                    <div class="text-gray-600 mt-1">Selesai:</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai_daftar)->format('d M Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs">
                                    <div class="text-gray-600">Mulai:</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai_kegiatan)->format('d M Y') }}
                                    </div>
                                    <div class="text-gray-600 mt-1">Selesai:</div>
                                    <div class="font-medium">
                                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai_kegiatan)->format('d M Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded
                                    @if ($kegiatan->status === 'publish') text-green-800
                                    @elseif ($kegiatan->status === 'draft') text-yellow-800
                                    @else text-gray-600 @endif">
                                    {{ ucfirst($kegiatan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col space-y-2">
                                    {{-- Aksi untuk Admin --}}
                                    @can('manage kegiatans')
                                        <a href="{{ route('kegiatan.edit', $kegiatan->id) }}"
                                            class="text-blue-600 hover:underline text-xs">Edit</a>
                                        <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-600 hover:underline text-xs">Hapus</button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-4 text-center text-gray-500">Belum ada kegiatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $kegiatans->links() }}
        </div>
    </div>
</x-admin-layout>
