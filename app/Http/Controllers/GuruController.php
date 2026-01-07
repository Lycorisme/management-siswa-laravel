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
        // Get unique bidang studi for filter
        $bidangStudiList = User::whereNotNull('bidang_studi')
            ->where('bidang_studi', '!=', '')
            ->distinct()
            ->pluck('bidang_studi');

        return view('guru.index', compact('bidangStudiList'));
    }

    /**
     * Get data guru/staff untuk API (AJAX)
     */
    public function getData(Request $request)
    {
        // Statistik
        $stats = [
            'total' => User::whereIn('role', ['admin', 'guru'])->count(),
            'admin' => User::where('role', 'admin')->where('status', 'aktif')->count(),
            'guru' => User::where('role', 'guru')->where('status', 'aktif')->count(),
            'nonaktif' => User::whereIn('role', ['admin', 'guru'])->where('status', '!=', 'aktif')->count(),
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
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'nama_lengkap');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Get data with pagination
        $perPage = $request->input('per_page', 10);
        $guru = $query->paginate($perPage);

        // Transform data
        $guru->getCollection()->transform(function ($item) {
            $item->foto_url = ($item->foto && Storage::disk('public')->exists($item->foto))
                ? asset('storage/' . $item->foto) 
                : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'%23e5e7eb\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\'/%3E%3C/svg%3E';
            return $item;
        });

        // Get unique bidang studi for filter
        $bidangStudiList = User::whereNotNull('bidang_studi')
            ->where('bidang_studi', '!=', '')
            ->distinct()
            ->pluck('bidang_studi');

        return response()->json([
            'success' => true,
            'data' => $guru,
            'stats' => $stats,
            'bidang_studi_list' => $bidangStudiList
        ]);
    }

    /**
     * Get single guru data
     */
    public function show($id)
    {
        $guru = User::findOrFail($id);
        
        // Add formatted data
        $guru->foto_url = ($guru->foto && Storage::disk('public')->exists($guru->foto))
            ? asset('storage/' . $guru->foto) 
            : 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'%23e5e7eb\' viewBox=\'0 0 24 24\'%3E%3Cpath d=\'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z\'/%3E%3C/svg%3E';
        
        $guru->tanggal_lahir_formatted = $guru->tanggal_lahir 
            ? $guru->tanggal_lahir->format('d F Y') 
            : null;
        
        $guru->last_login_formatted = $guru->last_login 
            ? $guru->last_login->format('d M Y H:i') 
            : null;
        
        $guru->created_at_formatted = $guru->created_at 
            ? $guru->created_at->format('d M Y H:i') 
            : null;
        
        $guru->updated_at_formatted = $guru->updated_at 
            ? $guru->updated_at->format('d M Y H:i') 
            : null;

        return response()->json([
            'success' => true,
            'data' => $guru
        ]);
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
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('guru', $filename, 'public');
            $validated['foto'] = $path;
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

        return response()->json([
            'success' => true,
            'message' => 'Data guru/staff berhasil ditambahkan',
            'data' => $user
        ]);
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
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.min' => 'Password minimal 6 karakter',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.unique' => 'Email sudah digunakan',
            'nip.unique' => 'NIP sudah digunakan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB',
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
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('guru', $filename, 'public');
            $validated['foto'] = $path;
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

        return response()->json([
            'success' => true,
            'message' => 'Data guru/staff berhasil diperbarui',
            'data' => $guru
        ]);
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
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        // Delete user
        $guru->delete();

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'guru',
            'description' => 'Menghapus data guru/staff: ' . $oldValues['nama_lengkap'],
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
     * Bulk delete guru
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:users,id'
        ]);

        $ids = $request->ids;
        
        // Remove current user from deletion list
        $ids = array_filter($ids, fn($id) => $id !== auth()->id());
        
        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data yang dapat dihapus'
            ], 400);
        }

        $guru = User::whereIn('id', $ids)->get();
        $deletedNames = $guru->pluck('nama_lengkap')->toArray();

        // Delete photos
        foreach ($guru as $g) {
            if ($g->foto && Storage::disk('public')->exists($g->foto)) {
                Storage::disk('public')->delete($g->foto);
            }
        }

        // Delete users
        User::whereIn('id', $ids)->delete();

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'bulk_delete',
            'module' => 'guru',
            'description' => 'Menghapus ' . count($ids) . ' data guru/staff: ' . implode(', ', $deletedNames),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => json_encode(['ids' => $ids, 'names' => $deletedNames]),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' data guru/staff berhasil dihapus'
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
