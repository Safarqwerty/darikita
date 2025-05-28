<x-admin-layout>
    <x-slot name="header">
        Detail Pendaftaran Kegiatan
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pendaftar</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4 text-sm text-gray-600">
                        <div>
                            <dt class="font-semibold text-gray-700">Nama Peserta</dt>
                            <dd>{{ $daftarKegiatan->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Email</dt>
                            <dd>{{ $daftarKegiatan->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Nama Kegiatan</dt>
                            <dd>{{ $daftarKegiatan->kegiatan->judul }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Tanggal Daftar</dt>
                            <dd>{{ $daftarKegiatan->tanggal_daftar->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Status</dt>
                            <dd>
                                @if ($daftarKegiatan->status === 'pending')
                                    <span class="text-yellow-600 font-medium">Menunggu</span>
                                @elseif ($daftarKegiatan->status === 'diterima')
                                    <span class="text-green-600 font-medium">Diterima</span>
                                @else
                                    <span class="text-red-600 font-medium">Ditolak</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Latar Belakang</dt>
                            <dd>{{ $daftarKegiatan->latar_belakang }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Pernah Jadi Relawan?</dt>
                            <dd>{{ ucfirst($daftarKegiatan->pernah_relawan) }}</dd>
                        </div>
                        @if ($daftarKegiatan->pernah_relawan === 'pernah')
                            <div>
                                <dt class="font-semibold text-gray-700">Nama Kegiatan Sebelumnya</dt>
                                <dd>{{ $daftarKegiatan->nama_kegiatan_sebelumnya }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="font-semibold text-gray-700">Jenis Kendaraan</dt>
                            <dd>{{ $daftarKegiatan->jenis_kendaraan }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Merk Kendaraan</dt>
                            <dd>{{ $daftarKegiatan->merk_kendaraan }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Siap Berkontribusi?</dt>
                            <dd>{{ $daftarKegiatan->siap_kontribusi ? 'Ya' : 'Tidak' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Bukti Follow</dt>
                            <dd>
                                @if ($daftarKegiatan->bukti_follow)
                                    <img src="{{ asset('storage/' . $daftarKegiatan->bukti_follow) }}"
                                        class="h-32 mt-2 border rounded" alt="Bukti Follow">
                                @else
                                    <span class="text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Bukti Repost</dt>
                            <dd>
                                @if ($daftarKegiatan->bukti_repost)
                                    <img src="{{ asset('storage/' . $daftarKegiatan->bukti_repost) }}"
                                        class="h-32 mt-2 border rounded" alt="Bukti Repost">
                                @else
                                    <span class="text-gray-400 italic">Tidak tersedia</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
                <div class="px-6 py-4 border-t flex justify-end space-x-2">
                    <a href="{{ route('pendaftaran.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded hover:bg-gray-700">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
