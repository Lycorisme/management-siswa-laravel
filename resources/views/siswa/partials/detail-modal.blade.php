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

            {{-- Quick Actions --}}
            <div class="absolute bottom-4 right-8 flex items-center gap-2">
                <button @click="showDetailModal = false; openEditModal(detailData.id)" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-xl text-sm font-medium transition-colors backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </button>
            </div>
        </div>

        {{-- Modal Body (Scrollable) --}}
        <div class="flex-1 overflow-y-auto pt-20 pb-8 px-8">
            {{-- Header Info --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900" x-text="detailData.nama_lengkap"></h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium"
                          :class="detailData.jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'"
                          x-text="detailData.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'"></span>
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium capitalize"
                          :class="{
                              'bg-green-100 text-green-700': detailData.status === 'aktif',
                              'bg-blue-100 text-blue-700': detailData.status === 'alumni',
                              'bg-yellow-100 text-yellow-700': detailData.status === 'pindah',
                              'bg-orange-100 text-orange-700': detailData.status === 'keluar',
                              'bg-red-100 text-red-700': detailData.status === 'dropout'
                          }"
                          x-text="detailData.status"></span>
                </div>
            </div>

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Data Identitas --}}
                <div class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-indigo-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                        Data Identitas
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">NIS</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.nis || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">NISN</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.nisn || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tempat, Tgl Lahir</span>
                            <span class="font-semibold text-gray-900" x-text="(detailData.tempat_lahir || '') + (detailData.tempat_lahir && detailData.tanggal_lahir_formatted ? ', ' : '') + (detailData.tanggal_lahir_formatted || '-')"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Umur</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.umur ? detailData.umur + ' tahun' : '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Agama</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.agama || '-'"></span>
                        </div>
                    </div>
                </div>

                {{-- Data Akademik --}}
                <div class="p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-green-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Data Akademik
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kelas</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.kelas || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tingkat</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.tingkat || '-'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tahun Masuk</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.tahun_masuk || '-'"></span>
                        </div>
                        <div class="flex justify-between" x-show="detailData.tahun_keluar">
                            <span class="text-gray-600">Tahun Keluar</span>
                            <span class="font-semibold text-gray-900" x-text="detailData.tahun_keluar"></span>
                        </div>
                    </div>
                    {{-- Poin --}}
                    <div class="mt-4 pt-4 border-t border-green-200 grid grid-cols-2 gap-3">
                        <div class="p-3 bg-white rounded-xl text-center">
                            <p class="text-xs text-gray-500">Prestasi</p>
                            <p class="text-xl font-bold text-green-600" x-text="detailData.total_poin_prestasi || 0"></p>
                        </div>
                        <div class="p-3 bg-white rounded-xl text-center">
                            <p class="text-xs text-gray-500">Pelanggaran</p>
                            <p class="text-xl font-bold text-red-600" x-text="detailData.total_poin_pelanggaran || 0"></p>
                        </div>
                    </div>
                </div>

                {{-- Data Alamat --}}
                <div class="p-6 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Alamat
                    </h3>
                    <div class="space-y-2">
                        <p class="text-gray-900" x-text="detailData.alamat || '-'"></p>
                        <p class="text-sm text-gray-600" x-show="detailData.rt_rw" x-text="'RT/RW: ' + detailData.rt_rw"></p>
                        <p class="text-sm text-gray-600" x-text="[detailData.kelurahan, detailData.kecamatan, detailData.kota].filter(Boolean).join(', ') || '-'"></p>
                        <p class="text-sm text-gray-600" x-text="[detailData.provinsi, detailData.kode_pos].filter(Boolean).join(' ') || ''"></p>
                    </div>
                    <div class="mt-4 pt-4 border-t border-amber-200 space-y-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-900" x-text="detailData.no_telepon || '-'"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-900" x-text="detailData.email || '-'"></span>
                        </div>
                    </div>
                </div>

                {{-- Data Orang Tua --}}
                <div class="p-6 bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl">
                    <h3 class="text-lg font-bold text-pink-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Data Orang Tua
                    </h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-blue-50 rounded-xl">
                            <p class="text-xs text-gray-500 mb-1">Ayah</p>
                            <p class="font-semibold text-gray-900" x-text="detailData.nama_ayah || '-'"></p>
                            <p class="text-sm text-gray-600" x-text="detailData.pekerjaan_ayah || '-'"></p>
                        </div>
                        <div class="p-3 bg-pink-100 rounded-xl">
                            <p class="text-xs text-gray-500 mb-1">Ibu</p>
                            <p class="font-semibold text-gray-900" x-text="detailData.nama_ibu || '-'"></p>
                            <p class="text-sm text-gray-600" x-text="detailData.pekerjaan_ibu || '-'"></p>
                        </div>
                        <div class="flex items-center gap-2 pt-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-gray-900" x-text="detailData.no_telepon_ortu || '-'"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timestamps --}}
            <div class="mt-8 pt-4 border-t border-gray-200 flex items-center justify-between text-sm text-gray-500">
                <span x-text="'Dibuat: ' + (detailData.created_at || '-')"></span>
                <span x-text="'Terakhir diubah: ' + (detailData.updated_at || '-')"></span>
            </div>
        </div>
    </div>
</div>
