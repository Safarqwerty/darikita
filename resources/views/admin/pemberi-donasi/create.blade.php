<x-admin-layout>
    <x-slot name="header">
        Buat Donasi Baru
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl p-6">

                <!-- Error Message -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg border-l-4 border-red-500">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Form Start -->
                <form action="{{ route('pemberi-donasi.store') }}" method="POST">
                    @csrf

                    <!-- Program Donasi -->
                    <div class="mb-6">
                        <label for="donasi_id" class="block text-gray-700 font-semibold mb-2">Program Donasi</label>
                        <select id="donasi_id" name="donasi_id"
                            class="form-select @error('donasi_id') border-red-500 @enderror w-full p-3 border rounded-lg"
                            required>
                            <option value="">-- Pilih Program Donasi --</option>
                            @foreach ($donasis as $donasi)
                                <option value="{{ $donasi->id }}"
                                    {{ old('donasi_id') == $donasi->id ? 'selected' : '' }}>
                                    {{ $donasi->nama_bencana }}
                                </option>
                            @endforeach
                        </select>
                        @error('donasi_id')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jumlah Donasi -->
                    <div class="mb-6">
                        <label for="jumlah" class="block text-gray-700 font-semibold mb-2">Jumlah Donasi (Rp)</label>
                        <input type="number" id="jumlah" name="jumlah" min="1000" value="{{ old('jumlah') }}"
                            class="form-control @error('jumlah') border-red-500 @enderror w-full p-3 border rounded-lg"
                            required>
                        <small class="text-gray-500">Minimal donasi adalah Rp 1.000</small>
                        @error('jumlah')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal Donasi -->
                    <div class="mb-6">
                        <label for="tanggal_donasi" class="block text-gray-700 font-semibold mb-2">Tanggal
                            Donasi</label>
                        <input type="date" id="tanggal_donasi" name="tanggal_donasi"
                            value="{{ old('tanggal_donasi', date('Y-m-d')) }}"
                            class="form-control @error('tanggal_donasi') border-red-500 @enderror w-full p-3 border rounded-lg"
                            required>
                        @error('tanggal_donasi')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Button Section -->
                    <div class="flex justify-between items-center">
                        <a href="{{ route('pemberi-donasi.index') }}"
                            class="btn btn-secondary px-6 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-200">
                            Kembali
                        </a>
                        <button type="submit"
                            class="btn btn-primary px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-200">
                            Kirim Donasi
                        </button>
                    </div>
                </form>
                <!-- End Form -->

            </div>
        </div>
    </div>
</x-admin-layout>
