<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Darikita</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Jika Anda memiliki file CSS kustom, pastikan path-nya benar --}}
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>

<body>
    @include('partials.nav.welcome')

    <!-- Hero Section -->
    <section class="hero-pattern pt-20 pb-16 w-full overflow-hidden">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center">
                {{-- Padding diubah untuk layar besar --}}
                <div class="lg:w-1/2 text-center lg:text-left mb-10 lg:mb-0 lg:pl-24" data-aos="fade-right">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 leading-tight mb-6">
                        Jadilah Bagian dari <span class="text-blue-600">Perubahan</span> di Indonesia
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-lg mx-auto lg:mx-0">
                        Bersama kita bisa membantu pendidikan & respon bencana di seluruh Indonesia.
                        Satu langkah kecilmu, dampak besar bagi mereka.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                            class="btn-primary px-8 py-3 text-white rounded-xl font-medium">
                            Mulai Bergerak
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="#program"
                            class="btn-secondary px-8 py-3 bg-white text-gray-700 rounded-xl font-medium border border-gray-200">
                            Jelajahi Program
                        </a>
                    </div>
                </div>
                <div class="lg:w-1/2" data-aos="fade-left">
                    <div class="relative px-4">
                        <div
                            class="absolute -top-6 -left-0 w-24 h-24 bg-blue-100 rounded-full opacity-70 hidden lg:block">
                        </div>
                        <div
                            class="absolute -bottom-6 -right-0 w-32 h-32 bg-blue-100 rounded-full opacity-70 hidden lg:block">
                        </div>
                        <img src="https://blog.maukuliah.id/wp-content/uploads/2023/07/relawan.jpg"
                            alt="Relawan di Indonesia"
                            class="relative z-10 rounded-2xl shadow-xl mx-auto w-full max-w-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="stats-item p-4" data-aos="fade-up" data-aos-delay="100">
                    <p class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">2,500+</p>
                    <p class="text-gray-600 font-medium">Relawan Aktif</p>
                </div>
                <div class="stats-item p-4" data-aos="fade-up" data-aos-delay="200">
                    <p class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">150+</p>
                    <p class="text-gray-600 font-medium">Program Selesai</p>
                </div>
                <div class="stats-item p-4" data-aos="fade-up" data-aos-delay="300">
                    <p class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">34</p>
                    <p class="text-gray-600 font-medium">Provinsi Terjangkau</p>
                </div>
                <div class="stats-item p-4" data-aos="fade-up" data-aos-delay="400">
                    <p class="text-3xl md:text-4xl font-bold text-blue-600 mb-2">50,000+</p>
                    <p class="text-gray-600 font-medium">Penerima Manfaat</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Activities Section -->
    <section id="upcoming-activities" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 section-title">Kegiatan Mendatang</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Bergabunglah dengan berbagai kegiatan sosial,
                    pendidikan, dan bantuan bencana untuk membuat dampak positif di masyarakat.</p>
            </div>

            {{-- Padding diubah untuk layar besar --}}
            <div class="lg:px-32 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($upcomingKegiatans as $kegiatan)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2 border border-gray-100 flex flex-col"
                        data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $kegiatan->gambar_sampul ? asset('storage/' . $kegiatan->gambar_sampul) : 'https://placehold.co/600x400/3B82F6/FFFFFF?text=Kegiatan' }}"
                                alt="{{ $kegiatan->nama_kegiatan }}" class="w-full h-full object-cover">
                            <div
                                class="absolute top-4 right-4 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                {{ ucfirst($kegiatan->jenis_kegiatan) }}
                            </div>
                            <div
                                class="absolute top-4 left-4 bg-white bg-opacity-90 text-gray-800 text-xs font-bold px-3 py-1 rounded-full">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai_kegiatan)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 flex-grow">
                                {{ $kegiatan->nama_kegiatan }}
                            </h3>
                            <div class="flex items-center text-gray-600 text-sm mb-3">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span class="line-clamp-1">{{ $kegiatan->kabupaten_kota }},
                                    {{ $kegiatan->provinsi }}</span>
                            </div>
                            <div class="mt-auto pt-4">
                                <a href="{{ route('public.kegiatan.show', $kegiatan->id) }}"
                                    class="w-full block text-center bg-green-600 hover:bg-green-700 py-2.5 text-white rounded-lg font-medium transition-all">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('kegiatan') }}"
                    class="btn-secondary px-8 py-3 bg-white text-gray-700 rounded-xl font-medium border border-gray-200 hover:bg-gray-50">
                    Lihat Semua Kegiatan <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Open Donations Section -->
    <section id="open-donations" class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 section-title">Program Donasi Terbuka</h2>
                <p class="text-gray-600 mt-4 max-w-2xl mx-auto">Pilih program donasi yang sesuai dengan kepedulianmu dan
                    jadilah bagian dari perubahan positif.</p>
            </div>

            {{-- Padding diubah untuk layar besar --}}
            <div class="lg:px-32 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($openDonations as $donasi)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform duration-300 hover:-translate-y-2 flex flex-col"
                        data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $donasi->gambar ? asset('storage/' . $donasi->gambar) : 'https://placehold.co/600x400/3B82F6/FFFFFF?text=Donasi' }}"
                                alt="{{ $donasi->nama_donasi }}" class="w-full h-full object-cover">
                            <div
                                class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                {{ ucfirst($donasi->jenis_donasi ?? 'Umum') }}
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-2 line-clamp-2 flex-grow">
                                {{ $donasi->nama_donasi }}</h3>
                            <div class="mb-4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full"
                                        style="width: {{ $donasi->target_dana > 0 ? min(100, ($donasi->dana_terkumpul / $donasi->target_dana) * 100) : 0 }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between mt-2 text-sm">
                                    <span class="font-medium text-blue-600">Rp
                                        {{ number_format($donasi->dana_terkumpul, 0, ',', '.') }}</span>
                                    <span class="text-gray-500">Target: Rp
                                        {{ number_format($donasi->target_dana, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-auto pt-4">
                                <a href="{{ route('donasi.detail', $donasi->id) }}"
                                    class="w-full block text-center btn-primary py-2.5 text-white rounded-lg font-medium transition-all">
                                    Donasi Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('donasi') }}"
                    class="btn-secondary px-8 py-3 bg-white text-gray-700 rounded-xl font-medium border border-gray-200 hover:bg-gray-50">
                    Lihat Semua Program <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Program Categories Section -->
    <section id="program" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 section-title mb-12">
                Program Relawan Unggulan
            </h2>
            <div class="px-32 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="category-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="bg-blue-50 h-3"></div>
                    <div class="p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-book text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-blue-700 mb-3">Relawan Pendidikan</h3>
                        <p class="text-gray-600 mb-4">
                            Berperan aktif dalam mendukung pendidikan anak-anak di pelosok negeri melalui kegiatan
                            mengajar, membangun perpustakaan, dan berbagai program edukasi.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-full">Mengajar</span>
                            <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-full">Literasi</span>
                            <span class="bg-blue-50 text-blue-700 text-xs px-2 py-1 rounded-full">Keterampilan</span>
                        </div>
                        <a href="#"
                            class="text-blue-600 font-medium hover:text-blue-800 transition flex items-center">
                            Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="category-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-aos="fade-up"
                    data-aos-delay="200">
                    <div class="bg-red-50 h-3"></div>
                    <div class="p-6">
                        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-hands-helping text-red-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-red-700 mb-3">Bantuan Bencana</h3>
                        <p class="text-gray-600 mb-4">
                            Turut serta dalam aksi tanggap darurat dan bantuan kemanusiaan, termasuk pelatihan
                            kesiapsiagaan dan bantuan pemulihan pasca bencana.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-red-50 text-red-700 text-xs px-2 py-1 rounded-full">Tanggap Darurat</span>
                            <span class="bg-red-50 text-red-700 text-xs px-2 py-1 rounded-full">Distribusi</span>
                            <span class="bg-red-50 text-red-700 text-xs px-2 py-1 rounded-full">Evakuasi</span>
                        </div>
                        <a href="#"
                            class="text-red-600 font-medium hover:text-red-800 transition flex items-center">
                            Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <div class="category-card bg-white rounded-2xl shadow-lg overflow-hidden relative" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="bg-yellow-50 h-3"></div>
                    <div class="p-6">
                        <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mb-4">
                            <i class="fas fa-hand-holding-heart text-yellow-600 text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-yellow-700 mb-3">Donasi & Dukungan</h3>
                        <p class="text-gray-600 mb-4">
                            Dukung gerakan kami dengan donasi atau menjadi mitra sosial untuk memberikan dampak
                            berkelanjutan bagi masyarakat yang membutuhkan.
                        </p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <span class="bg-yellow-50 text-yellow-700 text-xs px-2 py-1 rounded-full">Donasi</span>
                            <span class="bg-yellow-50 text-yellow-700 text-xs px-2 py-1 rounded-full">Kemitraan</span>
                            <span class="bg-yellow-50 text-yellow-700 text-xs px-2 py-1 rounded-full">Kampanye</span>
                        </div>
                        <a href="#"
                            class="text-yellow-600 font-medium hover:text-yellow-800 transition flex items-center">
                            Pelajari lebih lanjut <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section id="impact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 section-title mb-8">
                Dampak yang Kita Berikan
            </h2>
            <p class="text-gray-600 text-center max-w-2xl mx-auto mb-12">
                Setiap aksi kecil, jika dilakukan bersama-sama, dapat menciptakan gelombang perubahan yang besar.
                Lihat bagaimana kontribusi para relawan telah membawa perubahan nyata.
            </p>

            <div class="px-32 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16 items-center">
                <div data-aos="fade-right">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRSWZICHPc6Un8mzowfp2T8p4hsD9Geg9xATA&s"
                        alt="Dampak pendidikan" class="rounded-xl shadow-lg mx-auto">
                </div>
                <div data-aos="fade-left">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Pendidikan untuk Semua</h3>
                    <p class="text-gray-600 mb-6">
                        Melalui program relawan pendidikan, kami telah membantu meningkatkan angka literasi di 120+ desa
                        terpencil di Indonesia.
                        Para relawan mengajar lebih dari 15.000 anak dengan kurikulum yang disesuaikan dengan kebutuhan
                        lokal.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-gray-700">85% peningkatan keterampilan membaca pada anak-anak peserta
                                program</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-gray-700">32 perpustakaan desa telah dibangun dengan koleksi >1000
                                buku</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-gray-700">200+ guru lokal telah dilatih dengan metode pengajaran
                                modern</span>
                        </li>
                    </ul>
                </div>

                <div class="md:order-2" data-aos="fade-left">
                    <img src="data:image/jpeg;base64,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"
                        alt="Dampak bantuan bencana" class="rounded-xl shadow-lg mx-auto">
                </div>
                <div class="md:order-1" data-aos="fade-right">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Respon Cepat saat Bencana</h3>
                    <p class="text-gray-600 mb-6">
                        Tim tanggap bencana kami selalu siap 24/7 untuk memberikan bantuan tepat waktu pada korban
                        bencana.
                        Dengan jaringan relawan yang tersebar di seluruh Indonesia, kami bisa bergerak cepat ke lokasi
                        yang membutuhkan.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-gray-700">Respon rata-rata kurang dari 24 jam ke lokasi bencana</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-gray-700">25.000+ paket bantuan telah didistribusikan sepanjang tahun
                                lalu</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-green-500 mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-gray-700">50+ pelatihan kesiapsiagaan bencana telah diadakan di daerah
                                rawan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 section-title mb-12">
                Didukung Oleh
            </h2>

            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                <div class="grayscale hover:grayscale-0 transition opacity-70 hover:opacity-100" data-aos="fade-up">
                    <div class="w-32 h-16 bg-gray-100 rounded flex items-center justify-center">
                        <span class="font-bold text-gray-400">Partner 1</span>
                    </div>
                </div>
                <div class="grayscale hover:grayscale-0 transition opacity-70 hover:opacity-100" data-aos="fade-up"
                    data-aos-delay="100">
                    <div class="w-32 h-16 bg-gray-100 rounded flex items-center justify-center">
                        <span class="font-bold text-gray-400">Partner 2</span>
                    </div>
                </div>
                <div class="grayscale hover:grayscale-0 transition opacity-70 hover:opacity-100" data-aos="fade-up"
                    data-aos-delay="200">
                    <div class="w-32 h-16 bg-gray-100 rounded flex items-center justify-center">
                        <span class="font-bold text-gray-400">Partner 3</span>
                    </div>
                </div>
                <div class="grayscale hover:grayscale-0 transition opacity-70 hover:opacity-100" data-aos="fade-up"
                    data-aos-delay="300">
                    <div class="w-32 h-16 bg-gray-100 rounded flex items-center justify-center">
                        <span class="font-bold text-gray-400">Partner 4</span>
                    </div>
                </div>
                <div class="grayscale hover:grayscale-0 transition opacity-70 hover:opacity-100" data-aos="fade-up"
                    data-aos-delay="400">
                    <div class="w-32 h-16 bg-gray-100 rounded flex items-center justify-center">
                        <span class="font-bold text-gray-400">Partner 5</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.nav.footer')

    <!-- Back to top button -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg opacity-0 invisible transition-all duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Scripts -->
    <!-- Tailwind (pastikan ini sudah ada) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flowbite JS -->
    <script src="https://unpkg.com/flowbite@2.3.0/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.onscroll = function() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        };
        backToTopButton.onclick = function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        };
    </script>
</body>

</html>
