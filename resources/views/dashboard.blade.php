@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section (Transparent to show bg) -->
    <div class="mb-4 lg:flex items-end justify-between">
        <div>
            <h1 class="text-4xl font-extrabold text-white drop-shadow-sm leading-tight">Selamat Datang, Admin! <span class="animate-pulse">👋</span></h1>
            <p class="text-indigo-100 mt-2 font-medium text-lg drop-shadow-sm">Berikut adalah ringkasan aktivitas praktikum hari ini.</p>
        </div>
        <div class="mt-4 lg:mt-0 flex gap-2">
            <button class="px-4 py-2 glass-panel rounded-xl text-sm font-semibold text-indigo-700 hover:bg-white active:scale-95 transition-all"> unduh Laporan</button>
            <button class="px-4 py-2 bg-indigo-600 rounded-xl text-sm font-semibold text-white shadow-lg shadow-indigo-500/40 hover:bg-indigo-700 active:scale-95 transition-all"> + Input Nilai</button>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-8">
        <!-- Stat Card 1 -->
        <div class="glass-card p-6 rounded-3xl flex items-center gap-5 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-indigo-400/20 rounded-full blur-2xl group-hover:bg-indigo-400/30 transition-all"></div>
            
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 transform group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Total Siswa</p>
                <h3 class="text-3xl font-extrabold text-gray-800">124</h3>
                <p class="text-xs font-bold text-green-600 bg-green-100/50 px-2 py-0.5 rounded-full inline-flex items-center gap-1 mt-1 border border-green-200/50">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +12%
                </p>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="glass-card p-6 rounded-2xl flex items-center gap-5 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-green-400/20 rounded-full blur-2xl group-hover:bg-green-400/30 transition-all"></div>
            
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-green-500/30 transform group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Hadir Hari Ini</p>
                <h3 class="text-3xl font-extrabold text-gray-800">118</h3>
                <p class="text-xs font-bold text-green-600 mt-1">95% Kehadiran</p>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="glass-card p-6 rounded-2xl flex items-center gap-5 relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-400/20 rounded-full blur-2xl group-hover:bg-yellow-400/30 transition-all"></div>
            
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white shadow-lg shadow-yellow-500/30 transform group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Izin / Sakit</p>
                <h3 class="text-3xl font-extrabold text-gray-800">4</h3>
                <p class="text-xs font-bold text-gray-400 mt-1">Perlu konfirmasi</p>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="glass-card p-6 rounded-2xl flex items-center gap-5 relative overflow-hidden group">
             <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-400/20 rounded-full blur-2xl group-hover:bg-red-400/30 transition-all"></div>
             
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-red-500 to-pink-600 flex items-center justify-center text-white shadow-lg shadow-red-500/30 transform group-hover:scale-110 transition-transform duration-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Alpha</p>
                <h3 class="text-3xl font-extrabold text-gray-800">2</h3>
                <p class="text-xs font-bold text-red-500 bg-red-100/50 px-2 py-0.5 rounded-full inline-flex mt-1 border border-red-200/50">+1 dari kemarin</p>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Chart Section -->
        <div class="lg:col-span-2 glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between mb-8">
                <div>
                     <h3 class="text-lg font-bold text-indigo-950">Statistik Kehadiran</h3>
                     <p class="text-sm text-gray-500">Performa kehadiran siswa minggu ini</p>
                </div>
               
                <select class="glass-input px-4 py-2 rounded-xl text-sm font-semibold text-indigo-700 border-none outline-none cursor-pointer">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
            
            <div class="h-64 flex items-end justify-between gap-4 px-4 pb-4 border-b border-gray-200/50">
                <!-- Bar 1 -->
                <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="relative w-full bg-indigo-50/50 rounded-t-xl h-[60%] overflow-hidden">
                        <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-xl h-0 group-hover:h-full transition-all duration-700 ease-out" style="height: 60%"></div>
                         <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>
                </div>
                 <!-- Bar 2 -->
                <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="relative w-full bg-indigo-50/50 rounded-t-xl h-[80%] overflow-hidden">
                        <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-xl h-0 group-hover:h-full transition-all duration-700 ease-out delay-75" style="height: 85%"></div>
                    </div>
                </div>
                 <!-- Bar 3 -->
                <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="relative w-full bg-indigo-50/50 rounded-t-xl h-[40%] overflow-hidden">
                        <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-xl h-0 group-hover:h-full transition-all duration-700 ease-out delay-100" style="height: 45%"></div>
                    </div>
                </div>
                 <!-- Bar 4 (High) -->
                <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                     <div class="relative w-full bg-indigo-50/50 rounded-t-xl h-[90%] overflow-hidden shadow-lg shadow-indigo-500/20">
                        <div class="absolute bottom-0 w-full bg-indigo-600 rounded-t-xl h-0 group-hover:h-full transition-all duration-700 ease-out delay-150" style="height: 95%"></div>
                    </div>
                    <!-- Tooltip approximation -->
                     <div class="opacity-0 group-hover:opacity-100 absolute -mt-8 bg-indigo-900 text-white text-xs py-1 px-2 rounded transition-opacity">95%</div>
                </div>
                 <!-- Bar 5 -->
                <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="relative w-full bg-indigo-50/50 rounded-t-xl h-[70%] overflow-hidden">
                        <div class="absolute bottom-0 w-full bg-indigo-500 rounded-t-xl h-0 group-hover:h-full transition-all duration-700 ease-out delay-200" style="height: 75%"></div>
                    </div>
                </div>
                 <!-- Bar 6 (Low) -->
                 <div class="w-full flex flex-col items-center gap-2 group h-full justify-end">
                    <div class="relative w-full bg-indigo-50/50 rounded-t-xl h-[30%] overflow-hidden">
                        <div class="absolute bottom-0 w-full bg-pink-500 rounded-t-xl h-0 group-hover:h-full transition-all duration-700 ease-out delay-300" style="height: 40%"></div>
                    </div>
                </div>
            </div>
             <div class="flex justify-between text-xs font-semibold text-gray-400 mt-4 px-2">
                <span>Senin</span>
                <span>Selasa</span>
                <span>Rabu</span>
                <span>Kamis</span>
                <span>Jumat</span>
                <span>Sabtu</span>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="glass-card rounded-2xl p-6 flex flex-col">
            <h3 class="text-lg font-bold text-indigo-950 mb-6 flex items-center justify-between">
                Aktivitas Terbaru
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
            </h3>
            
            <div class="space-y-6 flex-1 overflow-y-auto pr-2 custom-scrollbar max-h-[300px]">
                
                <!-- Activity Item -->
                <div class="relative pl-8 pb-2 border-l-2 border-indigo-100 last:border-0 hover:pl-9 transition-all">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-indigo-100 border-2 border-white flex items-center justify-center">
                         <div class="w-1.5 h-1.5 rounded-full bg-indigo-600"></div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-800 font-bold">Budi Santoso</p>
                        <p class="text-xs text-gray-500 mb-1">Login ke sistem</p>
                        <span class="text-[10px] font-semibold text-indigo-400">2 menit yang lalu</span>
                    </div>
                </div>

                 <!-- Activity Item -->
                <div class="relative pl-8 pb-2 border-l-2 border-green-100 last:border-0 hover:pl-9 transition-all">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-green-100 border-2 border-white flex items-center justify-center">
                         <div class="w-1.5 h-1.5 rounded-full bg-green-600"></div>
                    </div>
                    <div>
                         <p class="text-sm text-gray-800 font-bold">Siti Aminah</p>
                        <p class="text-xs text-gray-500 mb-1">Melakukan presensi masuk</p>
                        <span class="text-[10px] font-semibold text-green-400">10 menit yang lalu</span>
                    </div>
                </div>

                 <!-- Activity Item -->
                <div class="relative pl-8 pb-2 border-l-2 border-purple-100 last:border-0 hover:pl-9 transition-all">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-purple-100 border-2 border-white flex items-center justify-center">
                         <div class="w-1.5 h-1.5 rounded-full bg-purple-600"></div>
                    </div>
                    <div>
                         <p class="text-sm text-gray-800 font-bold">Pak Guru</p>
                        <p class="text-xs text-gray-500 mb-1">Menginput nilai Kelas XII</p>
                        <span class="text-[10px] font-semibold text-purple-400">1 jam yang lalu</span>
                    </div>
                </div>

                <!-- Activity Item -->
                <div class="relative pl-8 pb-2 border-l-2 border-yellow-100 last:border-0 hover:pl-9 transition-all">
                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-yellow-100 border-2 border-white flex items-center justify-center">
                         <div class="w-1.5 h-1.5 rounded-full bg-yellow-600"></div>
                    </div>
                    <div>
                         <p class="text-sm text-gray-800 font-bold">Rina Wati</p>
                        <p class="text-xs text-gray-500 mb-1">Mengajukan ijin sakit</p>
                        <span class="text-[10px] font-semibold text-yellow-400">3 jam yang lalu</span>
                    </div>
                </div>

            </div>
            <button class="w-full mt-4 py-3 rounded-xl border border-indigo-100 text-indigo-600 text-sm font-bold hover:bg-indigo-50 hover:border-indigo-200 transition-colors">
                Lihat Semua Log
            </button>
        </div>

    </div>

    <!-- Student Table Summary -->
    <div class="mt-8 glass-card rounded-2xl p-6 overflow-hidden">
        <div class="flex items-center justify-between mb-6">
            <div>
                 <h3 class="text-lg font-bold text-indigo-950">Siswa Berprestasi</h3>
                 <p class="text-sm text-gray-500">Top 5 siswa dengan nilai tertinggi</p>
            </div>
             <button class="px-4 py-2 rounded-lg text-indigo-600 text-sm font-bold bg-indigo-50 hover:bg-indigo-100 transition-colors">Lihat Semua</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                        <th class="pb-4 pl-4">Siswa</th>
                        <th class="pb-4">Kelas</th>
                        <th class="pb-4">Progress Kehadiran</th>
                        <th class="pb-4">Nilai Rata-rata</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="group hover:bg-indigo-50/50 transition-colors border-b border-gray-50/50">
                        <td class="py-4 pl-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-yellow-400 to-indigo-500">
                                 <img src="https://ui-avatars.com/api/?name=Ahmad+R&background=fff" class="w-full h-full rounded-full border-2 border-white object-cover">
                            </div>
                            <div>
                                <span class="block font-bold text-gray-900">Ahmad Rizky</span>
                                <span class="text-xs text-gray-500">NIS: 2023001</span>
                            </div>
                        </td>
                        <td class="text-gray-600 font-medium">XII RPL 1</td>
                        <td class="text-gray-600 w-48 align-middle">
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-indigo-500 h-2 rounded-full shadow-sm shadow-indigo-300" style="width: 100%"></div>
                            </div>
                            <span class="text-xs text-gray-400 mt-1 inline-block">20/20 Pertemuan</span>
                        </td>
                        <td>
                            <span class="text-base font-extrabold text-indigo-900">95.00</span>
                        </td>
                        <td>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">Excellent</span>
                        </td>
                        <td>
                            <button class="text-gray-400 hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg></button>
                        </td>
                    </tr>
                   
                    <tr class="group hover:bg-indigo-50/50 transition-colors border-b border-gray-50/50">
                        <td class="py-4 pl-4 flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full p-0.5 bg-gradient-to-tr from-gray-200 to-gray-400">
                                 <img src="https://ui-avatars.com/api/?name=Sarah+P&background=fff" class="w-full h-full rounded-full border-2 border-white object-cover">
                            </div>
                            <div>
                                <span class="block font-bold text-gray-900">Sarah Putri</span>
                                <span class="text-xs text-gray-500">NIS: 2023045</span>
                            </div>
                        </td>
                        <td class="text-gray-600 font-medium">XI TKJ 2</td>
                        <td class="text-gray-600 w-48 align-middle">
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full shadow-sm shadow-blue-300" style="width: 92%"></div>
                            </div>
                             <span class="text-xs text-gray-400 mt-1 inline-block">18/20 Pertemuan</span>
                        </td>
                        <td>
                            <span class="text-base font-extrabold text-indigo-900">92.50</span>
                        </td>
                        <td>
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">Good</span>
                        </td>
                        <td>
                             <button class="text-gray-400 hover:text-indigo-600 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
