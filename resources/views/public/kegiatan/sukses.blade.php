<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <title>Pendaftaran Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-3xl w-full bg-white p-8 md:p-10 rounded-xl shadow-lg m-4 text-gray-800">

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif


        <div class="text-left space-y-4">
            <p class="font-medium">Assalamualaikum Warahmatullahi Wabarakatuh.</p>
            <p>Dengan hormat,<br>
                Perkenalkan saya <strong>Aqilah Nurul Fauziah (60900121054)</strong>, mahasiswi tingkat akhir Jurusan
                Sistem Informasi, Fakultas Sains dan Teknologi, UIN Alauddin Makassar.</p>
            <p>Saat ini, saya sedang dalam tahap penyelesaian skripsi dan membutuhkan bantuan Bapak/Ibu/Rekan-rekan
                untuk
                berpartisipasi dalam pengujian aplikasi "Darikita Indonesia" dengan mengisi kuesioner User Acceptance
                Testing (UAT).</p>
            <p>Tujuan dari pengujian ini adalah untuk mengevaluasi secara langsung dari sisi pengguna, apakah
                fungsionalitas dan kemudahan penggunaan (usability) aplikasi telah sesuai dengan kebutuhan dan dapat
                diterima dengan baik. Masukan yang diberikan akan menjadi data utama untuk analisis dan penyempurnaan
                aplikasi pada penelitian saya.</p>
            <p>Partisipasi Anda akan sangat berharga untuk kelancaran penelitian ini. Pengisian kuesioner diperkirakan
                hanya membutuhkan waktu 5-10 menit.</p>
            <p>Berikut adalah tautan kuesioner:<br>
                <a href="https://bit.ly/darikitaindonesiaa" target="_blank"
                    class="text-blue-600 hover:text-blue-800 underline font-semibold break-all">
                    🔗 https://bit.ly/darikitaindonesiaa
                </a>
            </p>
            <p>Atas perhatian, waktu, dan kesediaan Bapak/Ibu/Rekan-rekan untuk berkontribusi dalam penelitian ini, saya
                ucapkan terima kasih yang sebesar-besarnya.</p>
            <div>
                <p>Hormat saya,</p>
                <p class="font-semibold">Aqilah Nurul Fauziah</p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t text-center">
            <a href="{{ route('dashboard') }}"
                class="inline-block bg-[#01577e] hover:bg-opacity-90 text-white font-bold py-3 px-8 rounded-lg transition-transform transform hover:scale-105 duration-300 shadow-md">
                Lanjutkan ke Dashboard
            </a>
        </div>
    </div>
</body>

</html>
