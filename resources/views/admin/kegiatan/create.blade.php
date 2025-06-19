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
                    <input type="text" name="nama_kegiatan" class="w-full border rounded px-3 py-2"
                        value="{{ old('nama_kegiatan') }}" required>
                    @error('nama_kegiatan')
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
                    <label class="block font-semibold mb-1">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('deskripsi_kegiatan') }}</textarea>
                    @error('deskripsi_kegiatan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Syarat & Ketentuan (opsional)</label>
                    <textarea name="syarat_ketentuan" class="w-full border rounded px-3 py-2" rows="3">{{ old('syarat_ketentuan') }}</textarea>
                    @error('syarat_ketentuan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Lokasi Kegiatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Provinsi</label>
                            <input type="text" name="provinsi" class="w-full border rounded px-3 py-2"
                                value="{{ old('provinsi') }}" required>
                            @error('provinsi')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kabupaten/Kota</label>
                            <input type="text" name="kabupaten_kota" class="w-full border rounded px-3 py-2"
                                value="{{ old('kabupaten_kota') }}" required>
                            @error('kabupaten_kota')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kecamatan</label>
                            <input type="text" name="kecamatan" class="w-full border rounded px-3 py-2"
                                value="{{ old('kecamatan') }}" required>
                            @error('kecamatan')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kelurahan/Desa</label>
                            <input type="text" name="kelurahan_desa" class="w-full border rounded px-3 py-2"
                                value="{{ old('kelurahan_desa') }}" required>
                            @error('kelurahan_desa')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Batas Pendaftar (opsional)</label>
                    <input type="number" name="batas_pendaftar" class="w-full border rounded px-3 py-2"
                        value="{{ old('batas_pendaftar') }}">
                    @error('batas_pendaftar')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Gambar Kegiatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Gambar Sampul (opsional)</label>
                            <input type="file" name="gambar_sampul" class="w-full border rounded px-3 py-2"
                                accept="image/*">
                            <p class="text-sm text-gray-600 mt-1">Upload 1 gambar untuk sampul kegiatan</p>
                            @error('gambar_sampul')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Gambar Lokasi (opsional)</label>
                            <input type="file" name="gambar_lokasi[]" class="w-full border rounded px-3 py-2"
                                accept="image/*" multiple>
                            <p class="text-sm text-gray-600 mt-1">Upload maksimal 10 gambar lokasi kegiatan</p>
                            @error('gambar_lokasi')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                            @error('gambar_lokasi.*')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tanggal Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Jadwal Kegiatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Mulai Pendaftaran</label>
                            <input type="date" name="tanggal_mulai_daftar" class="w-full border rounded px-3 py-2"
                                value="{{ old('tanggal_mulai_daftar') }}" required>
                            @error('tanggal_mulai_daftar')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Selesai Pendaftaran</label>
                            <input type="date" name="tanggal_selesai_daftar" class="w-full border rounded px-3 py-2"
                                value="{{ old('tanggal_selesai_daftar') }}" required>
                            @error('tanggal_selesai_daftar')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Mulai Kegiatan</label>
                            <input type="date" name="tanggal_mulai_kegiatan"
                                class="w-full border rounded px-3 py-2" value="{{ old('tanggal_mulai_kegiatan') }}"
                                required>
                            @error('tanggal_mulai_kegiatan')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Selesai Kegiatan</label>
                            <input type="date" name="tanggal_selesai_kegiatan"
                                class="w-full border rounded px-3 py-2" value="{{ old('tanggal_selesai_kegiatan') }}"
                                required>
                            @error('tanggal_selesai_kegiatan')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
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
