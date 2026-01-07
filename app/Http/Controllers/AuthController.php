<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        // Cek apakah user ada dan aktif
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar dalam sistem'
            ], 401);
        }

        if ($user->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'
            ], 401);
        }

        // Attempt login
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Update last_login
            DB::table('users')
                ->where('id', Auth::id())
                ->update(['last_login' => now()]);

            // Log activity
            DB::table('activity_logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'login',
                'module' => 'auth',
                'description' => 'User berhasil login',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil! Mengalihkan ke dashboard...',
                'redirect' => route('dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Password yang Anda masukkan salah'
        ], 401);
    }

    /**
     * Proses logout
     */
    public function logout(Request $request)
    {
        // Log activity sebelum logout
        if (Auth::check()) {
            DB::table('activity_logs')->insert([
                'user_id' => Auth::id(),
                'action' => 'logout',
                'module' => 'auth',
                'description' => 'User logout dari sistem',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }
}
