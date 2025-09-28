    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Padding diubah untuk layar besar --}}
            <div class="lg:px-32 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="md:col-span-2 lg:col-span-1">
                    <div class="flex items-center space-x-2 mb-6">
                        <img src="{{ asset('logo.png') }}" class="h-8" alt="Logo"
                            onerror="this.style.display='none'">
                        <span class="font-bold text-xl text-white">Darikita</span>
                    </div>
                    <p class="text-gray-400 mb-6">Platform relawan terpercaya yang menghubungkan jiwa-jiwa peduli untuk
                        membuat perubahan nyata di Indonesia.</p>
                    <div class="flex space-x-4">
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/darikitaindonesia?igsh=MXBxbGlhaWhkYnMxbw==" target="_blank"
                            class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>

                        <!-- TikTok -->
                        <a href="https://www.tiktok.com/@darikitaindonesia_?_t=ZS-8yKE8svzJek&_r=1" target="_blank"
                            class="text-gray-400 hover:text-white transition">
                            <i class="fab fa-tiktok text-xl"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6">Program</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Relawan Pendidikan</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Bantuan Bencana</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Donasi & Dukungan</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6">Tentang Kami</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Profil Organisasi</a>
                        </li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tim Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Laporan Tahunan</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start"><i class="fas fa-map-marker-alt text-white mt-1 mr-3"></i><span
                                class="text-gray-400">Makassar</span></li>
                        <li class="flex items-start"><i class="fas fa-phone text-white mt-1 mr-3"></i><span
                                class="text-gray-400">+62859-1962-63098</span></li>
                        <li class="flex items-start"><i class="fas fa-envelope text-white mt-1 mr-3"></i><span
                                class="text-gray-400">darikitaindonesia@gmail.com</span></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8">
                {{-- Padding diubah untuk layar besar --}}
                <div class="lg:px-32 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-500 text-sm mb-4 md:mb-0">&copy; {{ date('Y') }} Darikita. Hak Cipta
                        Dilindungi.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-white text-sm transition">Kebijakan
                            Privasi</a>
                        <a href="#" class="text-gray-500 hover:text-white text-sm transition">Syarat &
                            Ketentuan</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
