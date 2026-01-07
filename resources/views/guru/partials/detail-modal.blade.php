{{-- Detail Modal --}}
<div x-show="showDetailModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm"
     @click.self="showDetailModal = false"
     style="display: none;">
    
    <div x-show="showDetailModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95 translate-y-4"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-4"
         class="w-full max-w-4xl max-h-[90vh] bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">
        
        {{-- Modal Header with Photo --}}
        <div class="relative h-48 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">
            {{-- Pattern Overlay --}}
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%239C92AC\" fill-opacity=\"0.1\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
            
            {{-- Close Button --}}
            <button @click="showDetailModal = false" 
                    class="absolute top-4 right-4 p-2 rounded-lg bg-white/20 hover:bg-white/30 text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Profile Photo --}}
            <div class="absolute -bottom-16 left-8">
                <div class="w-32 h-32 rounded-2xl overflow-hidden border-4 border-white shadow-xl bg-white">
                    <img :src="detailData.foto_url" 
                         :alt="detailData.nama_lengkap"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'%23e5e7eb\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\'/%3E%3C/svg%3E'">
                </div>
            </div>


        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto pt-20 pb-8 px-8">
            {{-- Header Info --}}
            <div class="mb-8">
                <div class="flex items-start justify-between">
                    <h2 class="text-2xl font-bold text-gray-900" x-text="detailData.nama_lengkap"></h2>
                    <div class="flex items-center gap-2">
                        <button @click="showDetailModal = false; openEditModal(detailData.id)" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </button>
                        <button @click="showDetailModal = false; openResetPasswordModal(detailData)" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                            Reset Password
                        </button>
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium capitalize"
                          :class="detailData.role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700'"
                          x-text="detailData.role"></span>
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium capitalize"
                          :class="{
                              'bg-green-100 text-green-700': detailData.status === 'aktif',
                              'bg-gray-100 text-gray-700': detailData.status === 'nonaktif',
                              'bg-amber-100 text-amber-700': detailData.status === 'pensiun',
                              'bg-orange-100 text-orange-700': detailData.status === 'pindah'
                          }"
                          x-text="detailData.status"></span>
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium"
                          :class="detailData.jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'"
                          x-text="detailData.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'"></span>
                </div>
            </div>

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Data Akun --}}
                <div class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Data Akun
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Username</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.username || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.email || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Login Terakhir</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.last_login_formatted || 'Belum pernah'"></span>
                        </div>
                    </div>
                </div>

                {{-- Data Profesional --}}
                <div class="p-6 bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-emerald-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Data Profesional
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">NIP</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.nip || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jabatan</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.jabatan || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bidang Studi</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.bidang_studi || '-'"></span>
                        </div>
                    </div>
                </div>

                {{-- Data Pribadi --}}
                <div class="p-6 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Data Pribadi
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tempat, Tgl Lahir</span>
                            <span class="font-semibold text-gray-900" x-text="(detailData.tempat_lahir || '') + (detailData.tempat_lahir && detailData.tanggal_lahir_formatted ? ', ' : '') + (detailData.tanggal_lahir_formatted || '-')"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jenis Kelamin</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'"></span>
                        </div>
                    </div>
                </div>

                {{-- Kontak & Alamat --}}
                <div class="p-6 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Kontak & Alamat
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-900" x-text="detailData.no_telepon || '-'"></span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            <span class="text-gray-900" x-text="detailData.alamat || '-'"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timestamps --}}
            <div class="mt-8 pt-4 border-t border-gray-200 flex items-center justify-between text-sm text-gray-500">
                <span x-text="'Dibuat: ' + (detailData.created_at_formatted || '-')"></span>
                <span x-text="'Terakhir diubah: ' + (detailData.updated_at_formatted || '-')"></span>
            </div>
        </div>
    </div>
</div>
