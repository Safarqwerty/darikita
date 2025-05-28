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

        <form action="{{ route('kegiatan.update', $kegiatan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-medium text-sm">Nama Kegiatan</label>
                <input type="text" name="judul" value="{{ old('judul', $kegiatan->judul) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium text-sm">Jenis Kegiatan</label>
                <input type="text" name="jenis_kegiatan" value="{{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium text-sm">Lokasi Umum</label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium text-sm">Alamat Lengkap</label>
                <textarea name="lokasi_kegiatan" rows="3" class="w-full border rounded px-3 py-2" required>{{ old('lokasi_kegiatan', $kegiatan->lokasi_kegiatan) }}</textarea>
            </div>

            <div>
                <label class="block font-medium text-sm">Batas Pendaftar</label>
                <input type="number" name="batas_pendaftar" value="{{ old('batas_pendaftar', $kegiatan->batas_pendaftar) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium text-sm">Gambar Lokasi</label>
                @if ($kegiatan->gambar_lokasi)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $kegiatan->gambar_lokasi) }}" alt="Gambar Lokasi" class="h-24 rounded">
                    </div>
                @endif
                <input type="file" name="gambar_lokasi" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block font-medium text-sm">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai->format('Y-m-d')) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium text-sm">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai->format('Y-m-d')) }}"
                    class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block font-medium text-sm">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="draft" {{ $kegiatan->status == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="publish" {{ $kegiatan->status == 'publish' ? 'selected' : '' }}>Publish</option>
                    <option value="selesai" {{ $kegiatan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="text-right">
                <a href="{{ route('kegiatan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</x-admin-layout>
