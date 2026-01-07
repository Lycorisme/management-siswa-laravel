{{-- Form Modal (Create/Edit) --}}
<div x-show="showFormModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
     @click.self="closeFormModal()"
     style="display: none;">
    
    <div x-show="showFormModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="w-full max-w-5xl max-h-[90vh] bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">
        
        {{-- Modal Header --}}
        <div class="flex items-center justify-between px-8 py-5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
            <div>
                <h2 class="text-xl font-bold" x-text="isEditMode ? 'Edit Data Siswa' : 'Tambah Siswa Baru'"></h2>
                <p class="text-sm text-indigo-200" x-text="isEditMode ? 'Perbarui informasi profil siswa' : 'Isi formulir untuk mendaftarkan siswa baru'"></p>
            </div>
            <button @click="closeFormModal()" class="p-2 rounded-lg hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto p-8">
            <form @submit.prevent="submitForm()" id="siswaForm">
                {{-- Tab Navigation --}}
                <div class="flex items-center gap-2 mb-8 p-1 bg-gray-100 rounded-2xl w-fit">
                    <button type="button" @click="activeTab = 'pribadi'"
                            :class="activeTab === 'pribadi' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Data Pribadi
                    </button>
                    <button type="button" @click="activeTab = 'alamat'"
                            :class="activeTab === 'alamat' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Alamat
                    </button>
                    <button type="button" @click="activeTab = 'ortu'"
                            :class="activeTab === 'ortu' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Data Orang Tua
                    </button>
                    <button type="button" @click="activeTab = 'akademik'"
                            :class="activeTab === 'akademik' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Info Akademik
                    </button>
                </div>

                {{-- TAB 1: Data Pribadi --}}
                <div x-show="activeTab === 'pribadi'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Foto Upload --}}
                        <div class="lg:row-span-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Siswa</label>
                            <div class="relative">
                                <div class="w-full aspect-square rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden border-2 border-dashed border-gray-300 hover:border-indigo-400 transition-colors cursor-pointer group"
                                     @click="$refs.fotoInput.click()">
                                    <template x-if="fotoPreview">
                                        <img :src="fotoPreview" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!fotoPreview">
                                        <div class="w-full h-full flex flex-col items-center justify-center p-6">
                                            <svg class="w-16 h-16 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mt-3 text-sm text-gray-500 text-center">Klik untuk upload foto</p>
                                            <p class="text-xs text-gray-400 mt-1">JPG, PNG max 2MB</p>
                                        </div>
                                    </template>
                                </div>
                                <input type="file" 
                                       x-ref="fotoInput" 
                                       @change="handleFotoChange($event)"
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="hidden">
                                <template x-if="fotoPreview">
                                    <button type="button" @click.stop="removeFoto()" 
                                            class="absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.foto" x-text="formErrors.foto"></p>
                        </div>

                        {{-- NIS --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIS <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.nis" maxlength="20"
                                   :class="formErrors.nis ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Masukkan NIS">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.nis" x-text="formErrors.nis"></p>
                        </div>

                        {{-- NISN --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NISN <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.nisn" maxlength="20"
                                   :class="formErrors.nisn ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Masukkan NISN">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.nisn" x-text="formErrors.nisn"></p>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.nama_lengkap" maxlength="100"
                                   :class="formErrors.nama_lengkap ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Masukkan nama lengkap">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.nama_lengkap" x-text="formErrors.nama_lengkap"></p>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex-1 relative cursor-pointer">
                                    <input type="radio" x-model="formData.jenis_kelamin" value="L" class="peer sr-only">
                                    <div class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all text-center">
                                        <span class="font-medium text-gray-700 peer-checked:text-blue-600">Laki-laki</span>
                                    </div>
                                </label>
                                <label class="flex-1 relative cursor-pointer">
                                    <input type="radio" x-model="formData.jenis_kelamin" value="P" class="peer sr-only">
                                    <div class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-pink-500 peer-checked:bg-pink-50 transition-all text-center">
                                        <span class="font-medium text-gray-700 peer-checked:text-pink-600">Perempuan</span>
                                    </div>
                                </label>
                            </div>
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.jenis_kelamin" x-text="formErrors.jenis_kelamin"></p>
                        </div>

                        {{-- Tempat Lahir --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Lahir</label>
                            <input type="text" x-model="formData.tempat_lahir" maxlength="50"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan tempat lahir">
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Lahir</label>
                            <input type="date" x-model="formData.tanggal_lahir"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>

                        {{-- Agama --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Agama</label>
                            <select x-model="formData.agama"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Pilih Agama</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>

                        {{-- No Telepon --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" x-model="formData.no_telepon" maxlength="15"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" x-model="formData.email" maxlength="100"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="email@example.com">
                        </div>
                    </div>
                </div>

                {{-- TAB 2: Alamat --}}
                <div x-show="activeTab === 'alamat'" x-transition style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Alamat --}}
                        <div class="md:col-span-2 lg:col-span-3">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea x-model="formData.alamat" rows="3"
                                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none"
                                      placeholder="Masukkan alamat lengkap"></textarea>
                        </div>

                        {{-- RT/RW --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">RT/RW</label>
                            <input type="text" x-model="formData.rt_rw" maxlength="10"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="001/002">
                        </div>

                        {{-- Kelurahan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kelurahan/Desa</label>
                            <input type="text" x-model="formData.kelurahan" maxlength="50"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan kelurahan">
                        </div>

                        {{-- Kecamatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kecamatan</label>
                            <input type="text" x-model="formData.kecamatan" maxlength="50"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan kecamatan">
                        </div>

                        {{-- Kota --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kota/Kabupaten</label>
                            <input type="text" x-model="formData.kota" maxlength="50"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan kota">
                        </div>

                        {{-- Provinsi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Provinsi</label>
                            <input type="text" x-model="formData.provinsi" maxlength="50"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan provinsi">
                        </div>

                        {{-- Kode Pos --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Pos</label>
                            <input type="text" x-model="formData.kode_pos" maxlength="10"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="12345">
                        </div>
                    </div>
                </div>

                {{-- TAB 3: Data Orang Tua --}}
                <div x-show="activeTab === 'ortu'" x-transition style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Section Ayah --}}
                        <div class="p-6 bg-blue-50 rounded-2xl">
                            <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data Ayah
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                                    <input type="text" x-model="formData.nama_ayah" maxlength="100"
                                           class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="Masukkan nama ayah">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                                    <input type="text" x-model="formData.pekerjaan_ayah" maxlength="100"
                                           class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                           placeholder="Masukkan pekerjaan">
                                </div>
                            </div>
                        </div>

                        {{-- Section Ibu --}}
                        <div class="p-6 bg-pink-50 rounded-2xl">
                            <h3 class="text-lg font-bold text-pink-900 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Data Ibu
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                                    <input type="text" x-model="formData.nama_ibu" maxlength="100"
                                           class="w-full px-4 py-3 rounded-xl border-2 border-pink-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                                           placeholder="Masukkan nama ibu">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                                    <input type="text" x-model="formData.pekerjaan_ibu" maxlength="100"
                                           class="w-full px-4 py-3 rounded-xl border-2 border-pink-200 focus:ring-2 focus:ring-pink-500 focus:border-transparent transition-all"
                                           placeholder="Masukkan pekerjaan">
                                </div>
                            </div>
                        </div>

                        {{-- No Telepon Orang Tua --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon Orang Tua</label>
                            <input type="tel" x-model="formData.no_telepon_ortu" maxlength="15"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                {{-- TAB 4: Info Akademik --}}
                <div x-show="activeTab === 'akademik'" x-transition style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Kelas --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                            <select x-model="formData.kelas_id"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Pilih Kelas</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} ({{ $kelas->tingkat }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select x-model="formData.status"
                                    :class="formErrors.status ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                    class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all">
                                <option value="aktif">Aktif</option>
                                <option value="alumni">Alumni</option>
                                <option value="pindah">Pindah</option>
                                <option value="keluar">Keluar</option>
                                <option value="dropout">Dropout</option>
                            </select>
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.status" x-text="formErrors.status"></p>
                        </div>

                        {{-- Tahun Masuk --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Masuk</label>
                            <select x-model="formData.tahun_masuk"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Pilih Tahun</option>
                                @for($year = date('Y'); $year >= 2000; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Tahun Keluar (shown only when status is alumni/pindah/keluar/dropout) --}}
                        <div x-show="['alumni', 'pindah', 'keluar', 'dropout'].includes(formData.status)" x-transition>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Keluar</label>
                            <select x-model="formData.tahun_keluar"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                                <option value="">Pilih Tahun</option>
                                @for($year = date('Y') + 1; $year >= 2000; $year--)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Poin Info (Read-only, only in edit mode) --}}
                        <template x-if="isEditMode">
                            <div class="md:col-span-2 lg:col-span-3 p-6 bg-gradient-to-r from-green-50 to-red-50 rounded-2xl">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Poin</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 bg-white rounded-xl text-center">
                                        <p class="text-sm text-gray-500">Poin Prestasi</p>
                                        <p class="text-3xl font-bold text-green-600" x-text="formData.total_poin_prestasi || 0"></p>
                                    </div>
                                    <div class="p-4 bg-white rounded-xl text-center">
                                        <p class="text-sm text-gray-500">Poin Pelanggaran</p>
                                        <p class="text-3xl font-bold text-red-600" x-text="formData.total_poin_pelanggaran || 0"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="flex items-center justify-end gap-3 px-8 py-5 border-t border-gray-100 bg-gray-50">
            <button type="button" @click="closeFormModal()" 
                    class="px-6 py-3 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors">
                Batal
            </button>
            <button type="submit" form="siswaForm"
                    :disabled="isSubmitting"
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:scale-[1.02] transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                <span x-show="!isSubmitting" x-text="isEditMode ? 'Simpan Perubahan' : 'Tambah Siswa'"></span>
                <span x-show="isSubmitting" class="flex items-center gap-2">
                    <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menyimpan...
                </span>
            </button>
        </div>
    </div>
</div>
