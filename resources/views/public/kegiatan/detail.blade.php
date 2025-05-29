<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Kegiatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Form -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Form Pendaftaran Kegiatan</h3>
                        <p class="text-sm text-gray-600">Silakan lengkapi data berikut untuk mendaftar kegiatan</p>
                    </div>

                    <!-- Form -->
                  <form action="{{ route('public.kegiatan.daftar', $kegiatan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                      @csrf
                      @method('PUT')
                      
                      <!-- Display general error messages -->
                      @if ($errors->any())
                          <div class="bg-red-50 border border-red-200 rounded-md p-4">
                              <div class="flex">
                                  <div class="flex-shrink-0">
                                      <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                      </svg>
                                  </div>
                                  <div class="ml-3">
                                      <h3 class="text-sm font-medium text-red-800">
                                          Terdapat {{ $errors->count() }} kesalahan pada form:
                                      </h3>
                                      <div class="mt-2 text-sm text-red-700">
                                          <ul role="list" class="list-disc pl-5 space-y-1">
                                              @foreach ($errors->all() as $error)
                                                  <li>{{ $error }}</li>
                                              @endforeach
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endif

                      <!-- Latar Belakang -->
                      <div>
                          <label for="latar_belakang" class="block text-sm font-medium text-gray-700 mb-2">
                              Latar Belakang <span class="text-red-500">*</span>
                          </label>
                          <input type="text" name="latar_belakang" id="latar_belakang" 
                                value="{{ old('latar_belakang') }}"
                                placeholder="Sebutkan latar belakang Anda..."
                                class="w-full px-3 py-2 border {{ $errors->has('latar_belakang') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                          @error('latar_belakang')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                          @enderror
                      </div>

                      <!-- Pernah Relawan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Pernah Menjadi Relawan? <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="pernah_relawan_pernah" name="pernah_relawan" value="1" 
                                    {{ old('pernah_relawan') == '1' ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                    onchange="toggleNamaKegiatan()" required>
                                <label for="pernah_relawan_pernah" class="ml-2 text-sm text-gray-700">Pernah</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="pernah_relawan_belum" name="pernah_relawan" value="0" 
                                    {{ old('pernah_relawan') == '0' ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300"
                                    onchange="toggleNamaKegiatan()" required>
                                <label for="pernah_relawan_belum" class="ml-2 text-sm text-gray-700">Belum Pernah</label>
                            </div>
                        </div>
                        @error('pernah_relawan')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                      <!-- Nama Kegiatan Sebelumnya -->
                      <div id="nama_kegiatan_field" style="display: {{ old('pernah_relawan') == 'pernah' ? 'block' : 'none' }};">
                          <label for="nama_kegiatan_sebelumnya" class="block text-sm font-medium text-gray-700 mb-2">
                              Nama Kegiatan Sebelumnya
                          </label>
                          <textarea name="nama_kegiatan_sebelumnya" id="nama_kegiatan_sebelumnya" rows="3"
                                    placeholder="Sebutkan nama kegiatan yang pernah diikuti sebelumnya..."
                                    class="w-full px-3 py-2 border {{ $errors->has('nama_kegiatan_sebelumnya') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('nama_kegiatan_sebelumnya') }}</textarea>
                          @error('nama_kegiatan_sebelumnya')
                              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                          @enderror
                      </div>

                      <!-- Informasi Kendaraan -->
                      <div class="bg-gray-50 p-4 rounded-lg">
                          <h4 class="text-md font-medium text-gray-900 mb-4">Informasi Kendaraan</h4>
                          
                          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                              <!-- Jenis Kendaraan -->
                              <div>
                                  <label for="jenis_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                      Jenis Kendaraan <span class="text-red-500">*</span>
                                  </label>
                                  <select name="jenis_kendaraan" id="jenis_kendaraan" required 
                                          class="w-full px-3 py-2 border {{ $errors->has('jenis_kendaraan') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                      <option value="">Pilih Jenis Kendaraan</option>
                                      <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                                      <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                                      <option value="tidak_ada" {{ old('jenis_kendaraan') == 'tidak_ada' ? 'selected' : '' }}>Tidak Ada Kendaraan</option>
                                  </select>
                                  @error('jenis_kendaraan')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <!-- Merk Kendaraan -->
                              <div>
                                  <label for="merk_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                      Merk Kendaraan
                                  </label>
                                  <input type="text" name="merk_kendaraan" id="merk_kendaraan" 
                                        value="{{ old('merk_kendaraan') }}"
                                        placeholder="Contoh: Honda, Toyota, Yamaha"
                                        class="w-full px-3 py-2 border {{ $errors->has('merk_kendaraan') ? 'border-red-500' : 'border-gray-300' }} rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                  @error('merk_kendaraan')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                     <!-- Siap Kontribusi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Siap Berkontribusi? <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="radio" id="siap_kontribusi_ya" name="siap_kontribusi" value="1" 
                                    {{ old('siap_kontribusi') == '1' ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                <label for="siap_kontribusi_ya" class="ml-2 text-sm text-gray-700">Ya, siap berkontribusi</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="siap_kontribusi_tidak" name="siap_kontribusi" value="0" 
                                    {{ old('siap_kontribusi') == '0' ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" required>
                                <label for="siap_kontribusi_tidak" class="ml-2 text-sm text-gray-700">Belum siap</label>
                            </div>
                        </div>
                        @error('siap_kontribusi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                      <!-- Upload Files -->
                      <div class="bg-blue-50 p-4 rounded-lg">
                          <h4 class="text-md font-medium text-gray-900 mb-4">Upload Bukti</h4>
                          
                          <div class="space-y-4">
                              <!-- Bukti Follow -->
                              <div>
                                  <label for="bukti_follow" class="block text-sm font-medium text-gray-700 mb-2">
                                      Bukti Follow Social Media <span class="text-red-500">*</span>
                                  </label>
                                  <div class="flex items-center justify-center w-full">
                                      <label for="bukti_follow" class="flex flex-col items-center justify-center w-full h-32 border-2 {{ $errors->has('bukti_follow') ? 'border-red-500' : 'border-gray-300' }} border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                          <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                              <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                              </svg>
                                              <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> bukti follow</p>
                                              <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                          </div>
                                          <input id="bukti_follow" name="bukti_follow" type="file" class="hidden" accept="image/*" required />
                                      </label>
                                  </div>
                                  @error('bukti_follow')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>

                              <!-- Bukti Repost -->
                              <div>
                                  <label for="bukti_repost" class="block text-sm font-medium text-gray-700 mb-2">
                                      Bukti Repost/Share <span class="text-red-500">*</span>
                                  </label>
                                  <div class="flex items-center justify-center w-full">
                                      <label for="bukti_repost" class="flex flex-col items-center justify-center w-full h-32 border-2 {{ $errors->has('bukti_repost') ? 'border-red-500' : 'border-gray-300' }} border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                          <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                              <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                              </svg>
                                              <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> bukti repost</p>
                                              <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
                                          </div>
                                          <input id="bukti_repost" name="bukti_repost" type="file" class="hidden" accept="image/*" required />
                                      </label>
                                  </div>
                                  @error('bukti_repost')
                                      <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                  @enderror
                              </div>
                          </div>
                      </div>

                      <!-- Submit Buttons -->
                      <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                          <a href="{{ route('dashboard') }}" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                              Batal
                          </a>
                          <button type="submit" 
                                  class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                              Daftar Sekarang
                          </button>
                      </div>
                  </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function toggleNamaKegiatan() {
            const pernahRadio = document.getElementById('pernah_relawan_pernah');
            const namaKegiatanField = document.getElementById('nama_kegiatan_field');
            const namaKegiatanInput = document.getElementById('nama_kegiatan_sebelumnya');
            
            if (pernahRadio.checked) {
                namaKegiatanField.style.display = 'block';
                namaKegiatanInput.required = true;
            } else {
                namaKegiatanField.style.display = 'none';
                namaKegiatanInput.required = false;
                namaKegiatanInput.value = '';
            }
        }

        // File upload preview
        function handleFileUpload(inputId) {
            const input = document.getElementById(inputId);
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const label = input.parentNode;
                    const fileName = file.name;
                    label.querySelector('p').innerHTML = `<span class="font-semibold text-green-600">File dipilih:</span> ${fileName}`;
                }
            });
        }

        // Initialize file upload handlers
        document.addEventListener('DOMContentLoaded', function() {
            handleFileUpload('bukti_follow');
            handleFileUpload('bukti_repost');
        });
    </script>
</x-app-layout>