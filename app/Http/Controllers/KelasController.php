<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Menampilkan halaman data kelas
     */
    /**
     * Menampilkan halaman data kelas
     */
    public function index()
    {
        // Get unique tahun ajaran for filter
        $tahunAjaranList = Kelas::distinct()->pluck('tahun_ajaran')->filter();

        // Get guru list for wali kelas dropdown
        $guruList = User::where('role', 'guru')
                       ->where('status', 'aktif')
                       ->orderBy('nama_lengkap', 'asc')
                       ->get();

        return view('kelas.index', compact('tahunAjaranList', 'guruList'));
    }

    /**
     * API: Mengambil data kelas dengan filter dan pagination
     */
    public function getData(Request $request)
    {
        // Statistik
        $stats = [
            'total' => Kelas::count(),
            'tingkat_x' => Kelas::where('status', 'aktif')->where('tingkat', 'X')->count(),
            'tingkat_xi' => Kelas::where('status', 'aktif')->where('tingkat', 'XI')->count(),
            'tingkat_xii' => Kelas::where('status', 'aktif')->where('tingkat', 'XII')->count(),
            'rata_kapasitas' => round(Kelas::where('status', 'aktif')->avg('kapasitas'), 0),
        ];

        // Query builder
        $query = Kelas::with(['waliKelas', 'siswa' => function($q) {
            $q->where('status', 'aktif');
        }]);

        // Filter by tingkat
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        // Filter by tahun ajaran
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_kelas', 'like', "%{$search}%")
                  ->orWhere('nama_kelas', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%");
            });
        }

        // Filter by per_page
        $perPage = $request->input('per_page', 10);

        // Get data with pagination
        $kelas = $query->orderBy('tingkat', 'asc')
                      ->orderBy('nama_kelas', 'asc')
                      ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $kelas,
            'stats' => $stats
        ]);
    }

    /**
     * Menyimpan data kelas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_kelas' => 'required|string|max:10|unique:kelas,kode_kelas',
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan' => 'nullable|string|max:50',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'kapasitas' => 'required|integer|min:1|max:50',
            'ruangan' => 'nullable|string|max:20',
            'tahun_ajaran' => 'nullable|string|max:9',
            'semester' => 'required|in:ganjil,genap',
            'status' => 'required|in:aktif,nonaktif',
        ], [
            'kode_kelas.required' => 'Kode kelas wajib diisi',
            'kode_kelas.unique' => 'Kode kelas sudah digunakan',
            'nama_kelas.required' => 'Nama kelas wajib diisi',
            'tingkat.required' => 'Tingkat wajib dipilih',
            'kapasitas.required' => 'Kapasitas wajib diisi',
            'kapasitas.min' => 'Kapasitas minimal 1',
            'kapasitas.max' => 'Kapasitas maksimal 50',
            'semester.required' => 'Semester wajib dipilih',
            'status.required' => 'Status wajib dipilih',
        ]);

        // Create kelas
        $kelas = Kelas::create($validated);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'create',
            'module' => 'kelas',
            'description' => 'Menambahkan data kelas: ' . $kelas->nama_kelas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'new_values' => json_encode($validated),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data kelas berhasil ditambahkan',
            'data' => $kelas->load('waliKelas')
        ]);
    }

    /**
     * Menampilkan detail kelas
     */
    public function show($id)
    {
        $kelas = Kelas::with(['waliKelas', 'siswa' => function($q) {
            $q->where('status', 'aktif');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $kelas
        ]);
    }

    /**
     * Update data kelas
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated = $request->validate([
            'kode_kelas' => ['required', 'string', 'max:10', Rule::unique('kelas')->ignore($id)],
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan' => 'nullable|string|max:50',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'kapasitas' => 'required|integer|min:1|max:50',
            'ruangan' => 'nullable|string|max:20',
            'tahun_ajaran' => 'nullable|string|max:9',
            'semester' => 'required|in:ganjil,genap',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Store old values for logging
        $oldValues = $kelas->toArray();

        // Update kelas
        $kelas->update($validated);

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'update',
            'module' => 'kelas',
            'description' => 'Mengubah data kelas: ' . $kelas->nama_kelas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => json_encode($oldValues),
            'new_values' => json_encode($validated),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data kelas berhasil diperbarui',
            'data' => $kelas->load('waliKelas')
        ]);
    }

    /**
     * Hapus data kelas
     */
    public function destroy(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        // Check if kelas has active students
        $jumlahSiswa = $kelas->siswa()->where('status', 'aktif')->count();
        if ($jumlahSiswa > 0) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat menghapus kelas karena masih memiliki {$jumlahSiswa} siswa aktif"
            ], 422);
        }

        // Store data for logging
        $oldValues = $kelas->toArray();

        // Delete kelas
        $kelas->delete();

        // Log activity
        DB::table('activity_logs')->insert([
            'user_id' => auth()->id(),
            'action' => 'delete',
            'module' => 'kelas',
            'description' => 'Menghapus data kelas: ' . $kelas->nama_kelas,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'old_values' => json_encode($oldValues),
            'created_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data kelas berhasil dihapus'
        ]);
    }


    /**
     * API: Bulk delete kelas
     */
    public function bulkDelete(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:kelas,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $kelasList = Kelas::whereIn('id', $request->ids)->get();
            
            // Check connections first
            foreach ($kelasList as $kelas) {
                $jumlahSiswa = $kelas->siswa()->where('status', 'aktif')->count();
                if ($jumlahSiswa > 0) {
                    throw new \Exception("Kelas {$kelas->nama_kelas} tidak dapat dihapus karena masih memiliki {$jumlahSiswa} siswa aktif");
                }
            }

            $deletedNames = $kelasList->pluck('nama_kelas')->toArray();

            Kelas::whereIn('id', $request->ids)->delete();

            // Log activity
            DB::table('activity_logs')->insert([
                'user_id' => auth()->id(),
                'action' => 'bulk_delete',
                'module' => 'kelas',
                'description' => "Menghapus " . count($request->ids) . " kelas: " . implode(', ', $deletedNames),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'old_values' => json_encode(['ids' => $request->ids, 'names' => $deletedNames]),
                'created_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' kelas berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kelas: ' . $e->getMessage(),
            ], 500);
        }
    }
}
