<x-admin-layout>
    <x-slot name="header">
        Tambah Donasi Bencana
    </x-slot>

    <div class="py-4">
        <form action="{{ route('donasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
            @csrf

            <div>
                <label class="block font-medium text-sm text-gray-700">Nama Bencana</label>
                <input type="text" name="nama_bencana" class="mt-1 block w-full border-gray-300 rounded shadow-sm" value="{{ old('nama_bencana') }}" required>
                @error('nama_bencana') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 rounded shadow-sm" required>{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700">Target Dana</label>
                    <input type="number" name="target_dana" class="mt-1 block w-full border-gray-300 rounded shadow-sm" value="{{ old('target_dana') }}" required>
                    @error('target_dana') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700">Dana Terkumpul</label>
                    <input type="number" name="dana_terkumpul" class="mt-1 block w-full border-gray-300 rounded shadow-sm" value="{{ old('dana_terkumpul', 0) }}">
                    @error('dana_terkumpul') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="mt-1 block w-full border-gray-300 rounded shadow-sm" value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block font-medium text-sm text-gray-700">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="mt-1 block w-full border-gray-300 rounded shadow-sm" value="{{ old('tanggal_selesai') }}" required>
                    @error('tanggal_selesai') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Status</label>
                <select name="status" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-sm text-gray-700">Gambar</label>
                <input type="file" name="gambar" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('gambar') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
                <a href="{{ route('donasi.index') }}" class="ml-2 text-gray-600 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</x-admin-layout>
