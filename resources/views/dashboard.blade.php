<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    {{ __('Selamat datang kembali, ') }} <span class="font-bold">{{ $user->name }}</span>!
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            onclick="this.parentElement.parentElement.style.display='none'">
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                        </svg>
                    </span>
                </div>
            @endif

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex flex-col items-center text-center">
                            <img class="h-24 w-24 rounded-full object-cover mb-4"
                                src="{{ $user->foto ? asset('storage/' . $user->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random' }}"
                                alt="Foto Profil">
                            <h3 class="text-xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                            <a href="{{ route('profile.edit') }}"
                                class="w-full text-center bg-[#01577e] hover:bg-[#01567eee] text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                                Edit Profil
                            </a>
                        </div>

                        <div class="border-t border-gray-200 mt-6 pt-6">
                            <dl>
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $user->tempat_lahir ?? 'Belum diisi' }},
                                        {{ $user->tanggal_lahir ? \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diisi' }}
                                    </dd>
                                </div>
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $user->jenis_kelamin ?? 'Belum diisi' }}</dd>
                                </div>
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Agama</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $user->agama ?? 'Belum diisi' }}</dd>
                                </div>
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $user->alamat ?? 'Belum diisi' }}</dd>
                                </div>
                                <!-- WhatsApp -->
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">WhatsApp</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @if ($user->nomor_wa)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->nomor_wa) }}"
                                                target="_blank" class="text-blue-500 hover:underline flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-whatsapp mr-2" viewBox="0 0 16 16">
                                                    <path
                                                        d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                                </svg>
                                                {{ $user->nomor_wa }}
                                            </a>
                                        @else
                                            Belum diisi
                                        @endif
                                    </dd>
                                </div>
                                <!-- Instagram -->
                                <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                    <dt class="text-sm font-medium text-gray-500">Instagram</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        @if ($user->link_instagram)
                                            <a href="{{ Str::startsWith($user->link_instagram, 'http') ? $user->link_instagram : 'https://' . $user->link_instagram }}"
                                                target="_blank" class="text-blue-500 hover:underline flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-instagram mr-2"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.703.01 5.556 0 5.829 0 8s.01 2.444.048 3.297c.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.556 15.99 5.829 16 8 16s2.444-.01 3.297-.048c.852-.04 1.433-.174 1.942-.372.526-.205.972-.478 1.417-.923.445-.444.719-.891.923-1.417.198-.51.333-1.09.372-1.942C15.99 10.444 16 10.171 16 8s-.01-2.444-.048-3.297c-.04-.852-.174-1.433-.372-1.942a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.09-.333-1.942-.372C10.444.01 10.171 0 8 0zm0 1.442c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.282.24.705.275 1.486.039.843.047 1.096.047 3.232s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.486a2.5 2.5 0 0 1-.598.92 2.5 2.5 0 0 1-.92.599c-.282.11-.705.24-1.486.275-.843.039-1.096.047-3.232.047s-2.389-.008-3.232-.047c-.78-.035-1.203-.166-1.486-.275a2.5 2.5 0 0 1-.92-.599 2.5 2.5 0 0 1-.598-.92c-.11-.282-.24-.705-.275-1.486-.039-.843-.047-1.096-.047-3.232s.008-2.389.047-3.232c.035-.78.166-1.204.275-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.486-.275.843-.039 1.096-.047 3.232-.047zM8 4.865a3.135 3.135 0 1 0 0 6.27 3.135 3.135 0 0 0 0-6.27M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m4.885-6.42a1.144 1.144 0 1 0 0-2.288 1.144 1.144 0 0 0 0 2.288z" />
                                                </svg>
                                                Kunjungi Profil
                                            </a>
                                        @else
                                            Belum diisi
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Registered Activities -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-medium mb-4">Kegiatan yang Telah Didaftar</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Kegiatan</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Tanggal</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Lokasi</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Kontribusi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($registrationActivities as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $item->kegiatan->nama_kegiatan }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($item->kegiatan->tanggal_mulai_kegiatan)->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    {{ $item->kegiatan->kabupaten_kota }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($item->status == 'pending')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            {{ $item->status }}
                                                        </span>
                                                    @elseif ($item->status == 'diterima')
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            {{ $item->status }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            {{ $item->status }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($item->status == 'diterima')
                                                        @if (!$item->bukti_kontribusi)
                                                            <!-- Form upload bukti kontribusi -->
                                                            <form
                                                                action="{{ route('upload.bukti.kontribusi', $item->id) }}"
                                                                method="POST" enctype="multipart/form-data"
                                                                class="inline">
                                                                @csrf
                                                                <div class="flex items-center space-x-2">
                                                                    <input type="file" name="bukti_kontribusi"
                                                                        accept=".pdf,.jpg,.jpeg,.png"
                                                                        class="text-xs border border-gray-300 rounded px-2 py-1"
                                                                        required>
                                                                    <button type="submit"
                                                                        class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                                                        Upload
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <!-- Jika sudah upload, tampilkan status dan link download -->
                                                            <div class="flex items-center space-x-2">
                                                                <span class="text-xs text-green-600">✓ Sudah
                                                                    Upload</span>
                                                                <a href="{{ asset('storage/' . $item->bukti_kontribusi) }}"
                                                                    target="_blank"
                                                                    class="text-xs text-blue-600 hover:text-blue-800">
                                                                    Lihat
                                                                </a>
                                                                <!-- Opsi untuk upload ulang -->
                                                                <form
                                                                    action="{{ route('upload.bukti.kontribusi', $item->id) }}"
                                                                    method="POST" enctype="multipart/form-data"
                                                                    class="inline">
                                                                    @csrf
                                                                    <div class="flex items-center space-x-1">
                                                                        <input type="file" name="bukti_kontribusi"
                                                                            accept=".pdf,.jpg,.jpeg,.png"
                                                                            class="text-xs border border-gray-300 rounded px-1 py-1"
                                                                            style="width: 120px;">
                                                                        <button type="submit"
                                                                            class="bg-green-500 hover:bg-green-700 text-white text-xs px-2 py-1 rounded">
                                                                            Update
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                                    Anda belum mendaftar kegiatan apapun.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
