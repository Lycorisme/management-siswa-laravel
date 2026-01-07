<header class="glass-header sticky top-0 z-20 mb-6 rounded-2xl mx-1 mt-1">
    <div class="px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl text-indigo-900 hover:bg-white/50 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/20 active:scale-95">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
            </button>
            <h2 class="text-xl font-bold text-indigo-950/80 tracking-tight">
                @if(isset($header))
                    {{ $header }}
                @else
                    Dashboard
                @endif
            </h2>
        </div>

        <div class="flex items-center gap-4 lg:gap-6">
            <!-- Search -->
            <div class="hidden md:flex items-center relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-indigo-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Search..." 
                    class="block w-full pl-10 pr-3 py-2.5 rounded-xl leading-5 glass-input placeholder-indigo-300 text-indigo-900 focus:placeholder-indigo-400 sm:text-sm transition duration-150 ease-in-out w-64">
            </div>

            <!-- Notifications -->
            <button class="relative p-2.5 text-indigo-900 hover:bg-white/50 rounded-xl transition-all active:scale-95 focus:outline-none ring-offset-2 focus:ring-2 ring-indigo-500/20">
                <span class="absolute top-2.5 right-2.5 flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500"></span>
                </span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-3 focus:outline-none p-1 pr-3 rounded-xl hover:bg-white/40 transition-colors">
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=6366f1&color=fff&bold=true" alt="Admin" 
                         class="w-10 h-10 rounded-xl shadow-md border-2 border-white ring-2 ring-indigo-500/10">
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-bold text-gray-800 leading-tight">Admin User</p>
                        <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-widest leading-tight">Admin</p>
                    </div>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" @click.away="open = false" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="transform opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="transform opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 mt-2 w-56 glass-panel rounded-2xl py-2 z-50 origin-top-right">
                    
                    <div class="px-4 py-3 border-b border-gray-100/50 mb-2">
                        <p class="text-sm text-gray-500">Signed in as</p>
                        <p class="text-sm font-bold text-gray-900 truncate">admin@sipraktikum.com</p>
                    </div>

                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50/50 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Your Profile
                    </a>
                    <a href="#" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-indigo-50/50 hover:text-indigo-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </a>
                    
                    <div class="border-t border-gray-100/50 my-2"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50/50 hover:text-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
