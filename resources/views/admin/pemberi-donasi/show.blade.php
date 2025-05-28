<x-admin-layout>
    <x-slot name="header">
        Detail Donasi
    </x-slot>

    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-2">Informasi Program Donasi</h2>
                    <div class="bg-gray-100 p-4 rounded">
                        <h3 class="text-lg font-bold">
                            {{ $pemberiDonasi->donasi->nama_bencana ?? 'Program tidak ditemukan' }}
                        </h3>
                        <p class="text-gray-700">{{ $pemberiDonasi->donasi->deskripsi ?? '-' }}</p>
                        @if ($pemberiDonasi->donasi)
                            <div class="flex justify-between mt-2 text-sm text-gray-600">
                                <span>Target: Rp
                                    {{ number_format($pemberiDonasi->donasi->target_dana, 0, ',', '.') }}</span>
                                <span>Status: {{ ucfirst($pemberiDonasi->donasi->status) }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Informasi Donasi</h2>
                        <table class="table-auto w-full text-sm">
                            <tr>
                                <th class="text-left pr-4 py-1">ID Donasi</th>
                                <td>{{ $pemberiDonasi->id }}</td>
                            </tr>
                            <tr>
                                <th class="text-left pr-4 py-1">Jumlah</th>
                                <td>Rp {{ number_format($pemberiDonasi->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th class="text-left pr-4 py-1">Tanggal Donasi</th>
                                <td>{{ $pemberiDonasi->tanggal_donasi->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold mb-2">Informasi Donatur</h2>
                        <table class="table-auto w-full text-sm">
                            <tr>
                                <th class="text-left pr-4 py-1">Nama</th>
                                <td>{{ $pemberiDonasi->user->name }}</td>
                            </tr>
                            <tr>
                                <th class="text-left pr-4 py-1">Email</th>
                                <td>{{ $pemberiDonasi->user->email }}</td>
                            </tr>
                            <tr>
                                <th class="text-left pr-4 py-1">Bergabung Sejak</th>
                                <td>{{ $pemberiDonasi->user->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('pemberi-donasi.index') }}" class="btn btn-secondary">Kembali</a>

                    @if (Auth::user()->hasRole('admin'))
                        <div class="flex gap-2">
                            <a href="{{ route('pemberi-donasi.edit', $pemberiDonasi->id) }}"
                                class="btn btn-warning">Edit</a>
                            <form action="{{ route('pemberi-donasi.destroy', $pemberiDonasi->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
