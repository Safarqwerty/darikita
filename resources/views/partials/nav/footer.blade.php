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
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i
                                class="fab fa-youtube"></i></a>
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
                        <li class="flex items-start"><i
                                class="fas fa-map-marker-alt text-blue-400 mt-1 mr-3"></i><span
                                class="text-gray-400">Jl. Relawan No. 123, Jakarta</span></li>
                        <li class="flex items-start"><i class="fas fa-phone text-blue-400 mt-1 mr-3"></i><span
                                class="text-gray-400">+62 21 1234 5678</span></li>
                        <li class="flex items-start"><i class="fas fa-envelope text-blue-400 mt-1 mr-3"></i><span
                                class="text-gray-400">info@darikita.id</span></li>
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
