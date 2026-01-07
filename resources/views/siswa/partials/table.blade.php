{{-- Data Table --}}
<div class="overflow-x-auto">
    <table class="w-full">
        <thead>
            <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                <th class="px-6 py-4 text-left">
                    <input type="checkbox" 
                           x-model="selectAll" 
                           @change="toggleSelectAll()"
                           class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                </th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Foto</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition-colors"
                    @click="sortBy('nis')">
                    <div class="flex items-center gap-1">
                        NIS
                        <svg class="w-4 h-4" :class="{ 'rotate-180': filters.sort_by === 'nis' && filters.sort_order === 'desc' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider cursor-pointer hover:text-indigo-600 transition-colors"
                    @click="sortBy('nama_lengkap')">
                    <div class="flex items-center gap-1">
                        Nama Lengkap
                        <svg class="w-4 h-4" :class="{ 'rotate-180': filters.sort_by === 'nama_lengkap' && filters.sort_order === 'desc' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </div>
                </th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Kelas</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">JK</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Poin</th>
                <th class="px-6 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            {{-- Loading State --}}
            <template x-if="loading">
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="w-10 h-10 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                            <p class="text-gray-500">Memuat data...</p>
                        </div>
                    </td>
                </tr>
            </template>

            {{-- Empty State --}}
            <template x-if="!loading && siswaList.length === 0">
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="text-center">
                                <p class="text-gray-900 font-semibold">Tidak ada data siswa</p>
                                <p class="text-gray-500 text-sm mt-1">Tambahkan siswa baru untuk memulai</p>
                            </div>
                            <button @click="openCreateModal()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Siswa
                            </button>
                        </div>
                    </td>
                </tr>
            </template>

            {{-- Data Rows --}}
            <template x-for="siswa in siswaList" :key="siswa.id">
                <tr class="hover:bg-indigo-50/50 transition-colors group">
                    {{-- Checkbox --}}
                    <td class="px-6 py-4">
                        <input type="checkbox" 
                               :value="siswa.id"
                               x-model="selectedItems"
                               class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                    </td>

                    {{-- Foto --}}
                    <td class="px-6 py-4">
                        <div class="relative w-12 h-12 rounded-xl overflow-hidden shadow-md group-hover:shadow-lg transition-shadow">
                            <img :src="siswa.foto_url" 
                                 :alt="siswa.nama_lengkap"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'%23e5e7eb\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\'/%3E%3C/svg%3E'">
                        </div>
                    </td>

                    {{-- NIS --}}
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-semibold text-gray-900" x-text="siswa.nis"></p>
                            <p class="text-xs text-gray-500" x-text="'NISN: ' + siswa.nisn"></p>
                        </div>
                    </td>

                    {{-- Nama Lengkap --}}
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900 group-hover:text-indigo-600 transition-colors" x-text="siswa.nama_lengkap"></p>
                    </td>

                    {{-- Kelas --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-100 text-indigo-700" x-text="siswa.kelas"></span>
                    </td>

                    {{-- Jenis Kelamin --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium"
                              :class="siswa.jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700'"
                              x-text="siswa.jenis_kelamin_label"></span>
                    </td>

                    {{-- Status --}}
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium capitalize"
                              :class="siswa.status_badge.bg + ' ' + siswa.status_badge.text"
                              x-text="siswa.status"></span>
                    </td>

                    {{-- Poin --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium bg-green-100 text-green-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                <span x-text="siswa.total_poin_prestasi"></span>
                            </span>
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span x-text="siswa.total_poin_pelanggaran"></span>
                            </span>
                        </div>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-1">
                            <button @click="viewDetail(siswa.id)" 
                                    class="p-2 rounded-lg text-gray-500 hover:bg-indigo-100 hover:text-indigo-600 transition-colors"
                                    title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button @click="openEditModal(siswa.id)" 
                                    class="p-2 rounded-lg text-gray-500 hover:bg-amber-100 hover:text-amber-600 transition-colors"
                                    title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button @click="confirmDelete(siswa)" 
                                    class="p-2 rounded-lg text-gray-500 hover:bg-red-100 hover:text-red-600 transition-colors"
                                    title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
