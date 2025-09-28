<x-admin-layout>
    <x-slot name="header">
        Edit Kegiatan
    </x-slot>

    <div class="py-6">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6 max-w-4xl mx-auto">
            <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" class="w-full border rounded px-3 py-2"
                        value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
                    @error('nama_kegiatan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Jenis Kegiatan</label>
                    <select name="jenis_kegiatan" class="w-full border rounded px-3 py-2" required>
                        <option value="">Pilih Jenis Kegiatan</option>
                        <option value="pendidikan"
                            {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == 'pendidikan' ? 'selected' : '' }}>
                            Pendidikan</option>
                        <option value="bencana"
                            {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == 'bencana' ? 'selected' : '' }}>
                            Bencana</option>
                        <option value="sosial"
                            {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == 'sosial' ? 'selected' : '' }}>Sosial
                        </option>
                        <option value="lingkungan"
                            {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == 'lingkungan' ? 'selected' : '' }}>
                            Lingkungan</option>
                        <option value="kesehatan"
                            {{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) == 'kesehatan' ? 'selected' : '' }}>
                            Kesehatan</option>
                    </select>
                    @error('jenis_kegiatan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Deskripsi Kegiatan</label>
                    <textarea name="deskripsi_kegiatan" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('deskripsi_kegiatan', $kegiatan->deskripsi_kegiatan) }}</textarea>
                    @error('deskripsi_kegiatan')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Syarat & Ketentuan (opsional)</label>
                    <textarea name="syarat_ketentuan" class="w-full border rounded px-3 py-2" rows="3">{{ old('syarat_ketentuan', $kegiatan->syarat_ketentuan) }}</textarea>
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
                                value="{{ old('provinsi', $kegiatan->provinsi) }}" required>
                            @error('provinsi')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kabupaten/Kota</label>
                            <input type="text" name="kabupaten_kota" class="w-full border rounded px-3 py-2"
                                value="{{ old('kabupaten_kota', $kegiatan->kabupaten_kota) }}" required>
                            @error('kabupaten_kota')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kecamatan</label>
                            <input type="text" name="kecamatan" class="w-full border rounded px-3 py-2"
                                value="{{ old('kecamatan', $kegiatan->kecamatan) }}" required>
                            @error('kecamatan')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Kelurahan/Desa</label>
                            <input type="text" name="kelurahan_desa" class="w-full border rounded px-3 py-2"
                                value="{{ old('kelurahan_desa', $kegiatan->kelurahan_desa) }}" required>
                            @error('kelurahan_desa')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Batas Pendaftar (opsional)</label>
                    <input type="number" name="batas_pendaftar" class="w-full border rounded px-3 py-2" min="1"
                        value="{{ old('batas_pendaftar', $kegiatan->batas_pendaftar) }}"
                        placeholder="Kosongkan jika tidak ada batas">
                    @error('batas_pendaftar')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Gambar Kegiatan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-semibold mb-1">Gambar Sampul</label>
                            @if ($kegiatan->gambar_sampul)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $kegiatan->gambar_sampul) }}" alt="Gambar Sampul"
                                        class="h-32 w-48 object-cover rounded border">
                                    <p class="text-sm text-gray-600 mt-1">Gambar sampul saat ini</p>
                                </div>
                            @endif
                            <input type="file" name="gambar_sampul" class="w-full border rounded px-3 py-2"
                                accept="image/jpeg,image/png,image/jpg">
                            <p class="text-sm text-gray-600 mt-1">Upload gambar baru untuk mengganti (JPG, PNG, max 2MB)
                            </p>
                            @error('gambar_sampul')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Gambar Lokasi</label>
                            @if ($kegiatan->gambar_lokasi && is_array($kegiatan->gambar_lokasi) && count($kegiatan->gambar_lokasi) > 0)
                                <div class="mb-2">
                                    <p class="text-sm text-gray-600 mb-2">Gambar lokasi saat ini
                                        ({{ count($kegiatan->gambar_lokasi) }} gambar):</p>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($kegiatan->gambar_lokasi as $gambar)
                                            <img src="{{ asset('storage/' . $gambar) }}" alt="Gambar Lokasi"
                                                class="h-20 w-full object-cover rounded border">
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="gambar_lokasi[]" class="w-full border rounded px-3 py-2"
                                accept="image/jpeg,image/png,image/jpg" multiple>
                            <p class="text-sm text-gray-600 mt-1">Upload gambar baru untuk mengganti (maksimal 10
                                gambar, JPG/PNG, max 2MB per gambar)</p>
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
                                value="{{ old('tanggal_mulai_daftar', $kegiatan->tanggal_mulai_daftar?->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_mulai_daftar')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Selesai Pendaftaran</label>
                            <input type="date" name="tanggal_selesai_daftar"
                                class="w-full border rounded px-3 py-2"
                                value="{{ old('tanggal_selesai_daftar', $kegiatan->tanggal_selesai_daftar?->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_selesai_daftar')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Mulai Kegiatan</label>
                            <input type="date" name="tanggal_mulai_kegiatan"
                                class="w-full border rounded px-3 py-2"
                                value="{{ old('tanggal_mulai_kegiatan', $kegiatan->tanggal_mulai_kegiatan?->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_mulai_kegiatan')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">Tanggal Selesai Kegiatan</label>
                            <input type="date" name="tanggal_selesai_kegiatan"
                                class="w-full border rounded px-3 py-2"
                                value="{{ old('tanggal_selesai_kegiatan', $kegiatan->tanggal_selesai_kegiatan?->format('Y-m-d')) }}"
                                required>
                            @error('tanggal_selesai_kegiatan')
                                <p class="text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-1">Link Grup (WhatsApp/Telegram)</label>
                    <input type="url" name="link_grup" class="w-full border rounded px-3 py-2"
                        placeholder="https://chat.whatsapp.com/..."
                        value="{{ old('link_grup', $kegiatan->link_grup) }}">
                    <p class="text-sm text-gray-600 mt-1">Masukkan link grup komunikasi untuk kegiatan ini</p>
                    @error('link_grup')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2" required>
                        <option value="draft" {{ old('status', $kegiatan->status) == 'draft' ? 'selected' : '' }}>
                            Draft</option>
                        <option value="publish" {{ old('status', $kegiatan->status) == 'publish' ? 'selected' : '' }}>
                            Publish</option>
                        <option value="selesai" {{ old('status', $kegiatan->status) == 'selesai' ? 'selected' : '' }}>
                            Selesai</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('kegiatan.index') }}"
                        class="px-4 py-2 mr-2 border rounded text-gray-600 hover:bg-gray-100">Batal</a>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
