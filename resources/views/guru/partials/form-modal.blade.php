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
                <h2 class="text-xl font-bold" x-text="isEditMode ? 'Edit Data Guru/Staff' : 'Tambah Guru/Staff Baru'"></h2>
                <p class="text-sm text-indigo-200" x-text="isEditMode ? 'Perbarui informasi profil guru/staff' : 'Isi formulir untuk mendaftarkan guru/staff baru'"></p>
            </div>
            <button @click="closeFormModal()" class="p-2 rounded-lg hover:bg-white/20 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto p-8">
            <form @submit.prevent="submitForm()" id="guruForm">
                {{-- Tab Navigation --}}
                <div class="flex items-center gap-2 mb-8 p-1 bg-gray-100 rounded-2xl w-fit">
                    <button type="button" @click="activeTab = 'akun'"
                            :class="activeTab === 'akun' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Akun & Role
                    </button>
                    <button type="button" @click="activeTab = 'pribadi'"
                            :class="activeTab === 'pribadi' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Data Pribadi
                    </button>
                    <button type="button" @click="activeTab = 'profesional'"
                            :class="activeTab === 'profesional' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Data Profesional
                    </button>
                    <button type="button" @click="activeTab = 'kontak'"
                            :class="activeTab === 'kontak' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-600 hover:text-gray-900'"
                            class="px-4 py-2 rounded-xl font-medium text-sm transition-all">
                        Kontak & Alamat
                    </button>
                </div>

                {{-- TAB 1: Akun & Role --}}
                <div x-show="activeTab === 'akun'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Foto Upload --}}
                        <div class="lg:row-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profil</label>
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

                        {{-- Username --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                            <input type="text" x-model="formData.username" maxlength="50"
                                   :class="formErrors.username ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Masukkan username">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.username" x-text="formErrors.username"></p>
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" x-model="formData.email" maxlength="100"
                                   :class="formErrors.email ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="email@example.com">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.email" x-text="formErrors.email"></p>
                        </div>

                        {{-- Password (only required on create) --}}
                        <div x-show="!isEditMode">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                            <input type="password" x-model="formData.password" maxlength="100"
                                   :class="formErrors.password ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Minimal 6 karakter">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.password" x-text="formErrors.password"></p>
                        </div>

                        {{-- Role --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                            <div class="flex gap-4">
                                <label class="flex-1 relative cursor-pointer">
                                    <input type="radio" x-model="formData.role" value="admin" class="peer sr-only">
                                    <div class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all text-center">
                                        <span class="font-medium text-gray-700 peer-checked:text-indigo-600">Admin</span>
                                    </div>
                                </label>
                                <label class="flex-1 relative cursor-pointer">
                                    <input type="radio" x-model="formData.role" value="guru" class="peer sr-only">
                                    <div class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all text-center">
                                        <span class="font-medium text-gray-700 peer-checked:text-emerald-600">Guru</span>
                                    </div>
                                </label>
                            </div>
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.role" x-text="formErrors.role"></p>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                            <select x-model="formData.status"
                                    :class="formErrors.status ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                    class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                                <option value="pensiun">Pensiun</option>
                                <option value="pindah">Pindah</option>
                            </select>
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.status" x-text="formErrors.status"></p>
                        </div>
                    </div>
                </div>

                {{-- TAB 2: Data Pribadi --}}
                <div x-show="activeTab === 'pribadi'" x-transition style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                    </div>
                </div>

                {{-- TAB 3: Data Profesional --}}
                <div x-show="activeTab === 'profesional'" x-transition style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- NIP --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIP</label>
                            <input type="text" x-model="formData.nip" maxlength="30"
                                   :class="formErrors.nip ? 'border-red-400 focus:ring-red-500' : 'border-gray-200 focus:ring-indigo-500'"
                                   class="w-full px-4 py-3 rounded-xl border-2 focus:ring-2 focus:border-transparent transition-all"
                                   placeholder="Masukkan NIP">
                            <p class="text-xs text-red-500 mt-1" x-show="formErrors.nip" x-text="formErrors.nip"></p>
                        </div>

                        {{-- Jabatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jabatan</label>
                            <input type="text" x-model="formData.jabatan" maxlength="100"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Masukkan jabatan">
                        </div>

                        {{-- Bidang Studi --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bidang Studi</label>
                            <input type="text" x-model="formData.bidang_studi" maxlength="100" list="bidangStudiOptions"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="Contoh: Matematika, Bahasa Indonesia">
                            <datalist id="bidangStudiOptions">
                                <option value="Matematika">
                                <option value="Bahasa Indonesia">
                                <option value="Bahasa Inggris">
                                <option value="Fisika">
                                <option value="Kimia">
                                <option value="Biologi">
                                <option value="Informatika">
                                <option value="Sejarah">
                                <option value="Geografi">
                                <option value="Ekonomi">
                                <option value="Sosiologi">
                                <option value="PKN">
                                <option value="Seni Budaya">
                                <option value="Pendidikan Agama">
                                <option value="Pendidikan Jasmani">
                            </datalist>
                        </div>
                    </div>
                </div>

                {{-- TAB 4: Kontak & Alamat --}}
                <div x-show="activeTab === 'kontak'" x-transition style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- No Telepon --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                            <input type="tel" x-model="formData.no_telepon" maxlength="15"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                                   placeholder="08xxxxxxxxxx">
                        </div>

                        {{-- Empty div for layout --}}
                        <div></div>

                        {{-- Alamat --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea x-model="formData.alamat" rows="3"
                                      class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none"
                                      placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
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
            <button type="submit" form="guruForm"
                    :disabled="isSubmitting"
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:scale-[1.02] transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                <span x-show="!isSubmitting" x-text="isEditMode ? 'Simpan Perubahan' : 'Tambah Staf'"></span>
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
