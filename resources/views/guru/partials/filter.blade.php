{{-- Filter & Search Bar --}}
<div class="p-6 border-b border-gray-100">
    <div class="flex flex-col lg:flex-row gap-4">
        
        {{-- Search Input --}}
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" 
                   x-model="filters.search"
                   @input.debounce.400ms="fetchData()"
                   placeholder="Cari berdasarkan NIP, nama, atau email..."
                   class="w-full pl-12 pr-4 py-3 glass-input rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
        </div>

        {{-- Filter Role --}}
        <div class="w-full lg:w-40">
            <select x-model="filters.role" 
                    @change="fetchData()"
                    class="w-full px-4 py-3 glass-input rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer">
                <option value="">Semua Role</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
            </select>
        </div>

        {{-- Filter Bidang Studi --}}
        <div class="w-full lg:w-48">
            <select x-model="filters.bidang_studi" 
                    @change="fetchData()"
                    class="w-full px-4 py-3 glass-input rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer">
                <option value="">Semua Bidang</option>
                <template x-for="bidang in bidangStudiList" :key="bidang">
                    <option :value="bidang" x-text="bidang"></option>
                </template>
            </select>
        </div>

        {{-- Filter Status --}}
        <div class="w-full lg:w-40">
            <select x-model="filters.status" 
                    @change="fetchData()"
                    class="w-full px-4 py-3 glass-input rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
                <option value="pensiun">Pensiun</option>
                <option value="pindah">Pindah</option>
            </select>
        </div>

        {{-- Per Page --}}
        <div class="w-full lg:w-28">
            <select x-model="filters.per_page" 
                    @change="fetchData()"
                    class="w-full px-4 py-3 glass-input rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>

    {{-- Bulk Actions (shown when items selected) --}}
    <div x-show="selectedItems.length > 0" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mt-4 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl flex items-center justify-between">
        <span class="text-sm font-medium text-indigo-700">
            <span x-text="selectedItems.length"></span> staf dipilih
        </span>
        <div class="flex items-center gap-2">
            <button @click="confirmBulkDelete()" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Hapus Terpilih
            </button>
            <button @click="selectedItems = []; selectAll = false" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition-colors">
                Batal
            </button>
        </div>
    </div>
</div>
