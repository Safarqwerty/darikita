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
                            <dd>{{ $daftarKegiatan->kegiatan->nama_kegiatan }}</dd>
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
                            <dd>{{ $daftarKegiatan->latar_belakang_pendidikan }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-gray-700">Pernah Jadi Relawan?</dt>
                            <dd>{{ $daftarKegiatan->pernah_relawan ? 'Ya' : 'Tidak' }}</dd>
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
                            <dd>{{ $daftarKegiatan->tipe_kendaraan }}</dd>
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

                        <!-- [FIXED] Corrected logic for Bukti Kontribusi -->
                        @if ($daftarKegiatan->status === 'diterima')
                            <div class="md:col-span-2 border-t pt-4 mt-4">
                                <h4 class="text-md font-semibold text-gray-800 mb-3">Bukti Kontribusi</h4>

                                <!-- Status and Upload Date -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="font-semibold text-gray-700">Status Upload</dt>
                                        <dd>
                                            @if ($daftarKegiatan->bukti_kontribusi)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Sudah Upload
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Belum Upload
                                                </span>
                                            @endif
                                        </dd>
                                    </div>
                                    @if ($daftarKegiatan->tanggal_upload_bukti)
                                        <div>
                                            <dt class="font-semibold text-gray-700">Tanggal Upload</dt>
                                            <dd>{{ $daftarKegiatan->tanggal_upload_bukti->format('d/m/Y H:i') }}</dd>
                                        </div>
                                    @endif
                                </div>

                                <!-- File Preview and Actions -->
                                @if ($daftarKegiatan->bukti_kontribusi)
                                    <div class="mt-4">
                                        <dt class="font-semibold text-gray-700 mb-2">File Bukti Kontribusi</dt>
                                        <dd>
                                            @php
                                                $fileExtension = pathinfo(
                                                    $daftarKegiatan->bukti_kontribusi,
                                                    PATHINFO_EXTENSION,
                                                );
                                                $isImage = in_array(strtolower($fileExtension), [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                ]);
                                            @endphp

                                            @if ($isImage)
                                                <!-- Jika file adalah gambar -->
                                                <div class="flex items-start space-x-4">
                                                    <img src="{{ asset('storage/' . $daftarKegiatan->bukti_kontribusi) }}"
                                                        class="h-32 w-auto border rounded shadow-sm"
                                                        alt="Bukti Kontribusi">
                                                    <div class="flex flex-col space-y-2">
                                                        <a href="{{ asset('storage/' . $daftarKegiatan->bukti_kontribusi) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                            <svg class="w-4 h-4 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                            Lihat Gambar
                                                        </a>
                                                        <a href="{{ asset('storage/' . $daftarKegiatan->bukti_kontribusi) }}"
                                                            download
                                                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                            <svg class="w-4 h-4 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            Download
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Jika file adalah PDF atau dokumen lain -->
                                                <div
                                                    class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg bg-gray-50">
                                                    <div class="flex-shrink-0">
                                                        <svg class="w-10 h-10 text-red-600" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900">Bukti Kontribusi
                                                            ({{ strtoupper($fileExtension) }})</p>
                                                        <p class="text-sm text-gray-500">Klik tombol untuk melihat atau
                                                            mendownload file</p>
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ asset('storage/' . $daftarKegiatan->bukti_kontribusi) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                            <svg class="w-4 h-4 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                                </path>
                                                            </svg>
                                                            Lihat
                                                        </a>
                                                        <a href="{{ asset('storage/' . $daftarKegiatan->bukti_kontribusi) }}"
                                                            download
                                                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                            <svg class="w-4 h-4 mr-2" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                                </path>
                                                            </svg>
                                                            Download
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Tombol Kirim ke WhatsApp -->
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <button
                                                    onclick="kirimKeWhatsApp('{{ $daftarKegiatan->user->name }}', '{{ $daftarKegiatan->kegiatan->nama_kegiatan }}', '{{ $daftarKegiatan->user->nomor_wa ?? '' }}', '{{ $daftarKegiatan->kegiatan->link_grup ?? '#' }}')"
                                                    class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                                    </svg>
                                                    Kirim Pesan WA
                                                </button>
                                            </div>
                                        </dd>
                                    </div>
                                @else
                                    <!-- Bukti Kontribusi Belum Diupload -->
                                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-yellow-800">Bukti Kontribusi Belum
                                                    Diupload</h3>
                                                <div class="mt-2 text-sm text-yellow-700">
                                                    <p>Peserta yang sudah diterima belum mengupload bukti kontribusi.
                                                        Silakan hubungi peserta untuk mengingatkan upload bukti
                                                        kontribusi.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
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

<script>
function kirimKeWhatsApp(name, namaKegiatan, nomorTelpon, linkGrup) {
    const pesanTemplate = `Assalamu'alaikum Warahmatullahi Wabarakatuh,

Selamat! ${name}

Kami mengucapkan selamat atas diterimanya kamu sebagai anggota ${namaKegiatan} Darikita Indonesia. Terima kasih telah bersedia menjadi bagian dari gerakan kebaikan ini.

Untuk langkah selanjutnya, silakan bergabung ke grup WhatsApp melalui link berikut:
${linkGrup}

Pastikan kamu segera join agar tidak ketinggalan info penting seputar kegiatan yang akan datang.

"Bersama kita wujudkan mimpi"

Wassalamu'alaikum Warahmatullahi Wabarakatuh.

Salam hangat,
Tim Darikita Indonesia`;

    const pesanEncoded = encodeURIComponent(pesanTemplate);
    let nomorBersih = nomorTelpon.replace(/\D/g, '');

    if (nomorBersih.startsWith('08')) {
        nomorBersih = '62' + nomorBersih.substring(1);
    } else if (nomorBersih.startsWith('8')) {
        nomorBersih = '62' + nomorBersih;
    } else if (!nomorBersih.startsWith('62')) {
        nomorBersih = '62' + nomorBersih;
    }

    // Validasi panjang nomor
    if (nomorBersih.length < 10 || nomorBersih.length > 15) {
        alert('Nomor WhatsApp tidak valid.');
        return;
    }

    const urlWA = `https://wa.me/${nomorBersih}?text=${pesanEncoded}`;
    window.open(urlWA, '_blank');
}
</script>
