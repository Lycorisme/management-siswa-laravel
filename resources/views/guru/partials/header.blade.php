{{-- Header Section with Statistics --}}
<div class="mb-8">
    {{-- Page Title & Breadcrumb --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Data Guru/Staff</h1>
            <nav class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" 
                   class="group flex items-center justify-center w-8 h-8 bg-white/50 backdrop-blur-sm rounded-lg border border-gray-100 text-gray-500 hover:bg-white hover:text-indigo-600 hover:shadow-md transition-all duration-300"
                   title="Dashboard">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </a>
                
                <span class="text-gray-300">/</span>
                
                <div class="flex items-center gap-2 px-3 py-1.5 bg-white rounded-lg border border-indigo-100 shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-sm font-semibold text-indigo-700">Data Guru/Staff</span>
                </div>
            </nav>
        </div>
        
        {{-- Add New Staff Button --}}
        <button @click="openCreateModal()" 
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-2xl font-semibold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:scale-[1.02] transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Guru/Staff
        </button>
    </div>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        {{-- Total Staff --}}
        <div class="glass-card rounded-2xl p-4 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Total Staf</p>
                <p class="text-2xl font-bold text-gray-900" x-text="stats.total || 0"></p>
            </div>
        </div>

        {{-- Administrator --}}
        <div class="glass-card rounded-2xl p-4 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Administrator</p>
                <p class="text-2xl font-bold text-indigo-600" x-text="stats.admin || 0"></p>
            </div>
        </div>

        {{-- Guru Aktif --}}
        <div class="glass-card rounded-2xl p-4 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-green-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Guru Aktif</p>
                <p class="text-2xl font-bold text-emerald-600" x-text="stats.guru || 0"></p>
            </div>
        </div>

        {{-- Non-Aktif --}}
        <div class="glass-card rounded-2xl p-4 relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-gray-400/10 to-gray-500/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow-lg shadow-gray-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Non-Aktif</p>
                <p class="text-2xl font-bold text-gray-600" x-text="stats.nonaktif || 0"></p>
            </div>
        </div>
    </div>
</div>
