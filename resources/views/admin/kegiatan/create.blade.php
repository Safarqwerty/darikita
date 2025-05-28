<x-admin-layout>
    <x-slot name="header">
        Tambah Kegiatan
    </x-slot>

    <div class="py-6">
        <div class="bg-white shadow rounded p-6 max-w-4xl mx-auto">
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nama Kegiatan</label>
                    <input type="text" name="judul" class="w-full border rounded px-3 py-2"
                        value="{{ old('judul') }}" required>
                    @error('judul')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Jenis Kegiatan</label>
                    <input type="text" name="jenis_kegiatan" class="w-full border rounded px-3 py-2"
                        value="{{ old('jenis_kegiatan') }}" required>
                    @error('jenis_kegiatan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Lokasi (Umum)</label>
                    <input type="text" name="lokasi" class="w-full border rounded px-3 py-2"
                        value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Alamat Lengkap</label>
                    <textarea name="lokasi_kegiatan" class="w-full border rounded px-3 py-2" required>{{ old('lokasi_kegiatan') }}</textarea>
                    @error('lokasi_kegiatan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Batas Pendaftar (opsional)</label>
                    <input type="number" name="batas_pendaftar" class="w-full border rounded px-3 py-2"
                        value="{{ old('batas_pendaftar') }}">
                    @error('batas_pendaftar')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Gambar Lokasi (opsional)</label>
                    <input type="file" name="gambar_lokasi" class="w-full border rounded px-3 py-2">
                    @error('gambar_lokasi')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-semibold mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="w-full border rounded px-3 py-2"
                            value="{{ old('tanggal_mulai') }}" required>
                        @error('tanggal_mulai')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="w-full border rounded px-3 py-2"
                            value="{{ old('tanggal_selesai') }}" required>
                        @error('tanggal_selesai')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('kegiatan.index') }}"
                        class="px-4 py-2 mr-2 border rounded text-gray-600 hover:bg-gray-100">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
