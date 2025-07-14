<x-admin-layout>
    <x-slot name="header">
        Daftar Open Donasi
    </x-slot>

    <div class="py-4">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-300 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('donasi.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Tambah Donasi
            </a>
        </div>

        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3">Nama Donasi</th>
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Target Dana</th>
                        <th class="px-6 py-3">Terkumpul</th>
                        <th class="px-6 py-3">Periode</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donasis as $donasi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $donasi->nama_donasi }}</td>
                            <td class="px-6 py-4">{{ $donasi->jenis_donasi }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($donasi->target_dana, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($donasi->dana_terkumpul, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($donasi->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($donasi->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-block px-2 py-1 text-xs font-semibold rounded
                                    @if ($donasi->status === 'open') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($donasi->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('donasi.edit', $donasi->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('donasi.destroy', $donasi->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin hapus donasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Belum ada donasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $donasis->links() }}
        </div>
    </div>
</x-admin-layout>
