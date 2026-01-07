<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Modern - Management Siswa Praktikum</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at top left, #4f46e5, transparent),
                        radial-gradient(circle at bottom right, #7c3aed, transparent),
                        linear-gradient(to bottom, #f3f4f6, #e5e7eb);
            min-height: 100vh;
        }
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        .input-glass:focus {
            background: white;
            transform: translateY(-1px);
        }
        
        /* Loading spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Blob Animation */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="flex items-center justify-center p-6" x-data="loginApp()">

    <div class="absolute top-20 left-20 w-32 h-32 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute bottom-20 right-20 w-48 h-48 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>

    <div class="w-full max-w-[1000px] grid lg:grid-cols-2 glass rounded-[2.5rem] overflow-hidden">
        
        <div class="p-12 flex flex-col justify-between bg-indigo-600/10 border-r border-white/20">
            <div>
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight text-indigo-950">SIPRAKTIKUM</span>
                </div>
                
                <h1 class="text-4xl font-extrabold text-indigo-950 leading-tight mb-4">
                    Pantau Progres <br> <span class="text-indigo-600">Siswa Praktikum</span> Dalam Satu Genggaman.
                </h1>
                <p class="text-indigo-900/60 leading-relaxed">
                    Akses data absensi, poin prestasi, dan jadwal kelas secara efisien dengan sistem keamanan terpadu.
                </p>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-3 text-sm font-medium text-indigo-900/70">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    System Online: Academic Year {{ date('Y') }}/{{ date('Y') + 1 }}
                </div>
            </div>
        </div>

        <div class="p-12 bg-white/40">
            <div class="mb-10 text-center lg:text-left">
                <h2 class="text-2xl font-bold text-gray-900">Sign In</h2>
                <p class="text-gray-500 mt-1">Gunakan role Admin atau Guru untuk login.</p>
            </div>

            <form @submit.prevent="handleLogin" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                    <input type="email" x-model="form.email" placeholder="admin@gmail.com"
                        class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 input-glass transition-all"
                        :class="{'border-red-500 bg-red-50': errors.email}">
                    <p x-show="errors.email" x-text="errors.email" class="mt-2 text-sm text-red-600"></p>
                </div>

                <div>
                    <div class="flex justify-between mb-2">
                        <label class="text-sm font-semibold text-gray-700">Password</label>
                        <a href="#" class="text-sm font-bold text-indigo-600 hover:text-indigo-500">Forgot?</a>
                    </div>
                    <input type="password" x-model="form.password" placeholder="••••••••"
                        class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 input-glass transition-all"
                        :class="{'border-red-500 bg-red-50': errors.password}">
                    <p x-show="errors.password" x-text="errors.password" class="mt-2 text-sm text-red-600"></p>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="rem" x-model="form.remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="rem" class="text-sm text-gray-600">Ingat sesi saya di browser ini</label>
                </div>

                <button type="submit" 
                    :disabled="isLoading"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-2xl shadow-xl shadow-indigo-200 transition-all active:scale-[0.98] mt-4 flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    
                    <span x-show="!isLoading">Masuk Sekarang</span>
                    <svg x-show="!isLoading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    
                    <div x-show="isLoading" x-cloak class="flex items-center space-x-2">
                        <div class="spinner"></div>
                        <span>Memproses...</span>
                    </div>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-gray-200/50 flex justify-between items-center text-xs text-gray-400">
                <p>© {{ date('Y') }} Admin Panel</p>
                <div class="flex gap-4">
                    <span>Privacy</span>
                    <span>Help Center</span>
                </div>
            </div>
        </div>
    </div>

<script>
function loginApp() {
    return {
        form: {
            email: '',
            password: '',
            remember: false
        },
        errors: {},
        isLoading: false,

        async handleLogin() {
            this.isLoading = true;
            this.errors = {};

            // Client-side validation
            if (!this.form.email) {
                this.errors.email = 'Email wajib diisi';
                this.isLoading = false;
                return;
            }

            if (!this.form.password) {
                this.errors.password = 'Password wajib diisi';
                this.isLoading = false;
                return;
            }

            try {
                const response = await fetch('{{ route("login.post") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.form)
                });

                if (response.status === 422) {
                    const errorData = await response.json();
                    if (errorData.errors) {
                        this.errors = {};
                        Object.keys(errorData.errors).forEach(key => {
                            this.errors[key] = errorData.errors[key][0];
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validasi Gagal',
                            text: errorData.message || 'Periksa input Anda',
                            confirmButtonColor: '#4f46e5'
                        });
                    }
                    return; // Stop here
                }

                const data = await response.json();

                if (data.success) {
                    // Success notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1000,
                        showConfirmButton: false,
                        allowOutsideClick: false
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    // Error notification (for non-validation errors like wrong password)
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Login',
                        text: data.message || 'Periksa kembali kredensial Anda.',
                        confirmButtonColor: '#4f46e5'
                    });
                }
            } catch (error) {
                console.error('Login error:', error);
                
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tidak dapat terhubung ke server. Silakan coba lagi.',
                    confirmButtonColor: '#4f46e5'
                });
            } finally {
                this.isLoading = false;
            }
        }
    }
}
</script>
</body>
</html>
