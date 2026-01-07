<aside 
    class="fixed inset-y-0 left-0 zs-30 transition-all duration-300 ease-in-out glass-sidebar flex flex-col
           lg:static lg:translate-x-0"
    :class="sidebarOpen ? 'w-72 translate-x-0' : '-translate-x-full lg:w-20 lg:translate-x-0 lg:hover:w-72 group'"
    style="z-index: 50;"
    x-data="{ 
        openMenu: null,
        toggleMenu(menu) {
            this.openMenu = this.openMenu === menu ? null : menu;
        }
    }"
>
    <!-- Logo Area -->
    <div class="h-24 flex items-center justify-center border-b border-white/20">
        <div class="flex items-center gap-4 px-6 w-full">
            <div class="relative w-12 h-12 flex-shrink-0">
                <div class="absolute inset-0 bg-indigo-500 rounded-xl rotate-6 opacity-20"></div>
                <div class="absolute inset-0 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 text-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            
            <div class="overflow-hidden transition-all duration-300"
                 :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                <h1 class="font-bold text-xl text-indigo-950 tracking-tight leading-none">SISWA PRAKTIKUM</h1>
                <p class="text-[10px] uppercase font-bold text-indigo-500 tracking-widest mt-1">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
        
        {{-- ============================================= --}}
        {{-- 1. DASHBOARD & MONITORING --}}
        {{-- ============================================= --}}
        <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 transition-opacity duration-300"
           :class="sidebarOpen ? 'opacity-100' : 'opacity-0 lg:group-hover:opacity-100'">Dashboard & Monitoring</p>

        <!-- Dashboard Utama -->
        <a href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            <span class="font-semibold whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Dashboard Utama
            </span>
        </a>

        <!-- Activity Logs -->
        <a href="{{ Route::has('activity-logs.index') ? route('activity-logs.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('activity-logs.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Activity Logs
            </span>
            @unless(Route::has('activity-logs.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Notifikasi -->
        <a href="{{ Route::has('notifications.index') ? route('notifications.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('notifications.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Notifikasi
            </span>
            @unless(Route::has('notifications.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        {{-- ============================================= --}}
        {{-- 2. MANAJEMEN DATA MASTER --}}
        {{-- ============================================= --}}
        <p class="px-4 pt-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 transition-opacity duration-300"
           :class="sidebarOpen ? 'opacity-100' : 'opacity-0 lg:group-hover:opacity-100'">Manajemen Data Master</p>

        <!-- Data Siswa -->
        <a href="{{ Route::has('students.index') ? route('students.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('students.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Data Siswa
            </span>
            @unless(Route::has('students.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Data Guru/Staff -->
        <a href="{{ Route::has('guru.index') ? route('guru.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('guru.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Data Guru/Staff
            </span>
        </a>

        <!-- Manajemen Kelas -->
        <a href="{{ Route::has('kelas.index') ? route('kelas.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('kelas.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Manajemen Kelas
            </span>
        </a>

        <!-- Mata Pelajaran -->
        <a href="{{ Route::has('subjects.index') ? route('subjects.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('subjects.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Mata Pelajaran
            </span>
            @unless(Route::has('subjects.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        {{-- ============================================= --}}
        {{-- 3. AKADEMIK & OPERASIONAL --}}
        {{-- ============================================= --}}
        <p class="px-4 pt-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 transition-opacity duration-300"
           :class="sidebarOpen ? 'opacity-100' : 'opacity-0 lg:group-hover:opacity-100'">Akademik & Operasional</p>

        <!-- Jadwal Pelajaran -->
        <a href="{{ Route::has('schedules.index') ? route('schedules.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('schedules.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Jadwal Pelajaran
            </span>
            @unless(Route::has('schedules.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Presensi & Absensi -->
        <a href="{{ Route::has('attendances.index') ? route('attendances.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('attendances.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Presensi & Absensi
            </span>
            @unless(Route::has('attendances.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Jam Pelajaran -->
        <a href="{{ Route::has('lesson-hours.index') ? route('lesson-hours.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('lesson-hours.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Jam Pelajaran
            </span>
            @unless(Route::has('lesson-hours.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        {{-- ============================================= --}}
        {{-- 4. KEDISIPLINAN & POIN --}}
        {{-- ============================================= --}}
        <p class="px-4 pt-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 transition-opacity duration-300"
           :class="sidebarOpen ? 'opacity-100' : 'opacity-0 lg:group-hover:opacity-100'">Kedisiplinan & Poin</p>

        <!-- Poin Prestasi -->
        <a href="{{ Route::has('achievements.index') ? route('achievements.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('achievements.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Poin Prestasi
            </span>
            @unless(Route::has('achievements.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Poin Pelanggaran -->
        <a href="{{ Route::has('violations.index') ? route('violations.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('violations.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Poin Pelanggaran
            </span>
            @unless(Route::has('violations.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Kategori Poin -->
        <a href="{{ Route::has('point-categories.index') ? route('point-categories.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('point-categories.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Kategori Poin
            </span>
            @unless(Route::has('point-categories.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        {{-- ============================================= --}}
        {{-- 5. LAPORAN & SISTEM --}}
        {{-- ============================================= --}}
        <p class="px-4 pt-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 transition-opacity duration-300"
           :class="sidebarOpen ? 'opacity-100' : 'opacity-0 lg:group-hover:opacity-100'">Laporan & Sistem</p>

        <!-- Laporan Terpadu -->
        <a href="{{ Route::has('reports.index') ? route('reports.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Laporan Terpadu
            </span>
            @unless(Route::has('reports.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

        <!-- Pengaturan Sistem -->
        <a href="{{ Route::has('settings.index') ? route('settings.index') : '#' }}" 
           class="flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 group/item
                  {{ request()->routeIs('settings.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 hover:scale-[1.02]' : 'text-gray-600 hover:bg-white/50 hover:text-indigo-700' }}">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                  :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                Pengaturan Sistem
            </span>
            @unless(Route::has('settings.index'))
            <span class="ml-auto px-2 py-0.5 text-[10px] font-bold bg-amber-100 text-amber-600 rounded-full"
                  :class="sidebarOpen ? 'block' : 'hidden lg:group-hover:block'">Soon</span>
            @endunless
        </a>

    </nav>

    <!-- Bottom Actions -->
    <div class="p-4 border-t border-white/20 bg-white/10 backdrop-blur-md">
        <div class="pt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-red-600 hover:bg-red-50 hover:text-red-700 transition-all duration-200">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="font-medium whitespace-nowrap overflow-hidden transition-all duration-300"
                        :class="sidebarOpen ? 'w-auto opacity-100' : 'w-0 opacity-0 lg:group-hover:w-auto lg:group-hover:opacity-100'">
                        Logout
                    </span>
                </button>
            </form>
        </div>
    </div>
</aside>
