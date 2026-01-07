<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Menampilkan halaman data guru/staff
     */
    public function index(Request $request)
    {
        // Statistik
        $stats = [
            'total' => User::whereIn('role', ['admin', 'guru'])->count(),
            'admin' => User::where('role', 'admin')->where('status', 'aktif')->count(),
            'guru' => User::where('role', 'guru')->where('status', 'aktif')->count(),
        ];

        // Query builder
        $query = User::whereIn('role', ['admin', 'guru']);

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by bidang studi
        if ($request->filled('bidang_studi')) {
            $query->where('bidang_studi', $request->bidang_studi);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get data with pagination
        $guru = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get unique bidang studi for filter
        $bidangStudiList = User::whereNotNull('bidang_studi')
            ->distinct()
            ->pluck('bidang_studi');

        return view('guru.index', compact('guru', 'stats', 'bidangStudiList'));
    }

    /**
     * Menampilkan form tambah guru
     */
    public function create()
    {
        return view('guru.create');
    }

    /**
     * Menyimpan data guru baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'jenis_kelamin' => 'required|in:L,P',
            'nip' => 'nullable|string|max:30|unique:users,nip',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'role' => 'required|in:admin,guru',
            'jabatan' => 'nullable|string|max:100',
            'bidang_studi' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif,pensiun,pindah',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'nip.unique' => 'NIP sudah digunakan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/guru'), $filename);
            $validated['foto'] = 'uploads/guru/' . $filename;
        }

        // Create user
        $user = User::create($validated);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'guru',
            'description' => 'Menambahkan data guru/staff: ' . $user->nama_lengkap,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'new_values' => json_encode($validated),
            'created_at' => now(),
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru/staff berhasil ditambahkan');
    }

    /**
     * Menampilkan form edit guru
     */
    public function edit($id)
    {
        $guru = User::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    /**
     * Update data guru
     */
    public function update(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($id)],
            'password' => 'nullable|string|min:6',
            'nama_lengkap' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'jenis_kelamin' => 'required|in:L,P',
            'nip' => ['nullable', 'string', 'max:30', Rule::unique('users')->ignore($id)],
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:15',
            'role' => 'required|in:admin,guru',
            'jabatan' => 'nullable|string|max:100',
            'bidang_studi' => 'nullable|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,nonaktif,pensiun,pindah',
        ]);

        // Store old values for logging
        $oldValues = $guru->toArray();

        // Update password only if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($guru->foto && file_exists(public_path($guru->foto))) {
                unlink(public_path($guru->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/guru'), $filename);
            $validated['foto'] = 'uploads/guru/' . $filename;
        }

        // Update user
        $guru->update($validated);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'guru',
            'description' => 'Mengubah data guru/staff: ' . $guru->nama_lengkap,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($validated),
            'created_at' => now(),
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru/staff berhasil diperbarui');
    }

    /**
     * Hapus data guru
     */
    public function destroy(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        // Prevent deleting own account
        if ($guru->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri'
            ], 403);
        }

        // Store data for logging
        $oldValues = $guru->toArray();

        // Delete foto
        if ($guru->foto && file_exists(public_path($guru->foto))) {
            unlink(public_path($guru->foto));
        }

        // Delete user
        $guru->delete();

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'guru',
            'description' => 'Menghapus data guru/staff: ' . $guru->nama_lengkap,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => json_encode($oldValues),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data guru/staff berhasil dihapus'
        ]);
    }

    /**
     * Reset password guru
     */
    public function resetPassword(Request $request, $id)
    {
        $guru = User::findOrFail($id);

        $validated = $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password minimal 6 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Update password
        $guru->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'reset_password',
            'module' => 'guru',
            'description' => 'Mereset password guru/staff: ' . $guru->nama_lengkap,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset'
        ]);
    }
}
