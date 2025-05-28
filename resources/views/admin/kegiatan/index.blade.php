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
                        <th class="px-6 py-3">Lokasi Umum</th>
                        <th class="px-6 py-3">Alamat Lengkap</th>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Kuota</th>
                        <th class="px-6 py-3">Tanggal Mulai</th>
                        <th class="px-6 py-3">Tanggal Selesai</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Admin</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $kegiatan)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $kegiatan->judul }}</td>
                            <td class="px-6 py-4">{{ $kegiatan->jenis_kegiatan }}</td>
                            <td class="px-6 py-4">{{ $kegiatan->lokasi }}</td>
                            <td class="px-6 py-4">{{ $kegiatan->lokasi_kegiatan }}</td>
                            <td class="px-6 py-4">
                                @if ($kegiatan->gambar_lokasi)
                                    <img src="{{ asset('storage/' . $kegiatan->gambar_lokasi) }}" alt="Gambar Lokasi"
                                        class="w-20 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $kegiatan->batas_pendaftar ?? 'Tak terbatas' }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded
                                    @if ($kegiatan->status === 'publish') bg-green-100 text-green-800
                                    @elseif ($kegiatan->status === 'draft') bg-yellow-100 text-yellow-800
                                    @else bg-gray-200 text-gray-600 @endif">
                                    {{ ucfirst($kegiatan->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $kegiatan->creator->name ?? '-' }}</td>
                            <td class="px-6 py-4 space-x-2">
                                {{-- Aksi --}}
                                @can('manage kegiatans')
                                    <a href="{{ route('kegiatan.edit', $kegiatan->id) }}"
                                        class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin hapus kegiatan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                @elsecan('kegiatan.register')
                                    <form action="{{ route('kegiatan.daftar', $kegiatan->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700">Daftar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">Belum ada kegiatan.</td>
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
