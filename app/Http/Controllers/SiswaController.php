<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\ActivityLog;
use App\Models\AktivitasSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Menampilkan halaman daftar siswa
     */
    public function index()
    {
        $kelasList = Kelas::aktif()->orderBy('tingkat')->orderBy('nama_kelas')->get();
        
        return view('siswa.index', compact('kelasList'));
    }

    /**
     * API: Mengambil data siswa dengan filter dan pagination
     */
    public function getData(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $kelasId = $request->input('kelas_id', '');
        $status = $request->input('status', '');
        $jenisKelamin = $request->input('jenis_kelamin', '');
        $sortBy = $request->input('sort_by', 'nama_lengkap');
        $sortOrder = $request->input('sort_order', 'asc');

        $query = Siswa::with('kelas')
            ->search($search)
            ->kelasId($kelasId)
            ->status($status)
            ->jenisKelamin($jenisKelamin)
            ->orderBy($sortBy, $sortOrder);

        $siswa = $query->paginate($perPage);

        // Format data untuk response
        $siswa->getCollection()->transform(function ($item) {
            return [
                'id' => $item->id,
                'nis' => $item->nis,
                'nisn' => $item->nisn,
                'nama_lengkap' => $item->nama_lengkap,
                'jenis_kelamin' => $item->jenis_kelamin,
                'jenis_kelamin_label' => $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
                'kelas' => $item->kelas ? $item->kelas->nama_kelas : '-',
                'kelas_id' => $item->kelas_id,
                'tingkat' => $item->kelas ? $item->kelas->tingkat : '-',
                'status' => $item->status,
                'status_badge' => $this->getStatusBadge($item->status),
                'foto_url' => $item->foto_url,
                'total_poin_prestasi' => $item->total_poin_prestasi,
                'total_poin_pelanggaran' => $item->total_poin_pelanggaran,
                'created_at' => $item->created_at->format('d M Y'),
            ];
        });

        // Statistik untuk header
        $stats = $this->getStatistics();

        return response()->json([
            'success' => true,
            'data' => $siswa,
            'stats' => $stats,
        ]);
    }

    /**
     * API: Mengambil detail siswa
     */
    public function show($id)
    {
        $siswa = Siswa::with('kelas')->find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $siswa->id,
                'nis' => $siswa->nis,
                'nisn' => $siswa->nisn,
                'nama_lengkap' => $siswa->nama_lengkap,
                'jenis_kelamin' => $siswa->jenis_kelamin,
                'tempat_lahir' => $siswa->tempat_lahir,
                'tanggal_lahir' => $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : null,
                'tanggal_lahir_formatted' => $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d F Y') : '-',
                'agama' => $siswa->agama,
                'alamat' => $siswa->alamat,
                'rt_rw' => $siswa->rt_rw,
                'kelurahan' => $siswa->kelurahan,
                'kecamatan' => $siswa->kecamatan,
                'kota' => $siswa->kota,
                'provinsi' => $siswa->provinsi,
                'kode_pos' => $siswa->kode_pos,
                'no_telepon' => $siswa->no_telepon,
                'email' => $siswa->email,
                'nama_ayah' => $siswa->nama_ayah,
                'nama_ibu' => $siswa->nama_ibu,
                'pekerjaan_ayah' => $siswa->pekerjaan_ayah,
                'pekerjaan_ibu' => $siswa->pekerjaan_ibu,
                'no_telepon_ortu' => $siswa->no_telepon_ortu,
                'kelas_id' => $siswa->kelas_id,
                'kelas' => $siswa->kelas ? $siswa->kelas->nama_kelas : '-',
                'tingkat' => $siswa->kelas ? $siswa->kelas->tingkat : '-',
                'foto' => $siswa->foto,
                'foto_url' => $siswa->foto_url,
                'status' => $siswa->status,
                'tahun_masuk' => $siswa->tahun_masuk,
                'tahun_keluar' => $siswa->tahun_keluar,
                'total_poin_prestasi' => $siswa->total_poin_prestasi,
                'total_poin_pelanggaran' => $siswa->total_poin_pelanggaran,
                'umur' => $siswa->umur,
                'created_at' => $siswa->created_at->format('d M Y H:i'),
                'updated_at' => $siswa->updated_at->format('d M Y H:i'),
            ],
        ]);
    }

    /**
     * API: Menyimpan siswa baru
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $data = $request->except('foto');

            // Handle foto upload
            if ($request->hasFile('foto')) {
                $data['foto'] = $this->uploadFoto($request->file('foto'));
            }

            $siswa = Siswa::create($data);

            // Log aktivitas
            ActivityLog::log(
                'create',
                'siswa',
                "Menambahkan siswa baru: {$siswa->nama_lengkap} (NIS: {$siswa->nis})",
                null,
                $siswa->toArray()
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil ditambahkan',
                'data' => $siswa,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Mengupdate data siswa
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), $this->validationRules($id));

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();
        try {
            $oldData = $siswa->toArray();
            $data = $request->except('foto');

            // Handle foto upload
            if ($request->hasFile('foto')) {
                // Hapus foto lama jika ada
                if ($siswa->foto) {
                    $this->deleteFoto($siswa->foto);
                }
                $data['foto'] = $this->uploadFoto($request->file('foto'));
            }

            // Cek perubahan status
            $statusChanged = isset($data['status']) && $data['status'] !== $siswa->status;
            $oldStatus = $siswa->status;

            $siswa->update($data);

            // Jika status berubah, catat di aktivitas_siswa
            if ($statusChanged) {
                AktivitasSiswa::create([
                    'siswa_id' => $siswa->id,
                    'jenis_aktivitas' => 'perubahan_data',
                    'deskripsi' => "Status diubah dari '{$oldStatus}' menjadi '{$data['status']}'",
                    'data_lama' => ['status' => $oldStatus],
                    'data_baru' => ['status' => $data['status']],
                    'created_by' => auth()->id(),
                ]);
            }

            // Log aktivitas
            ActivityLog::log(
                'update',
                'siswa',
                "Mengupdate data siswa: {$siswa->nama_lengkap} (NIS: {$siswa->nis})",
                $oldData,
                $siswa->fresh()->toArray()
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil diperbarui',
                'data' => $siswa->fresh(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Menghapus siswa
     */
    public function destroy($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        DB::beginTransaction();
        try {
            $oldData = $siswa->toArray();

            // Hapus foto jika ada
            if ($siswa->foto) {
                $this->deleteFoto($siswa->foto);
            }

            // Log aktivitas sebelum hapus
            ActivityLog::log(
                'delete',
                'siswa',
                "Menghapus siswa: {$siswa->nama_lengkap} (NIS: {$siswa->nis})",
                $oldData,
                null
            );

            $siswa->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Siswa berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Upload foto siswa
     */
    public function uploadPhoto(Request $request, $id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Hapus foto lama jika ada
            if ($siswa->foto) {
                $this->deleteFoto($siswa->foto);
            }

            // Upload foto baru
            $fotoName = $this->uploadFoto($request->file('foto'));
            $siswa->update(['foto' => $fotoName]);

            // Log aktivitas
            ActivityLog::log(
                'update',
                'siswa',
                "Mengupload foto siswa: {$siswa->nama_lengkap}",
                null,
                ['foto' => $fotoName]
            );

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diupload',
                'data' => [
                    'foto' => $fotoName,
                    'foto_url' => $siswa->fresh()->foto_url,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal upload foto: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Hapus foto siswa
     */
    public function deletePhoto($id)
    {
        $siswa = Siswa::find($id);

        if (!$siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak ditemukan',
            ], 404);
        }

        if (!$siswa->foto) {
            return response()->json([
                'success' => false,
                'message' => 'Siswa tidak memiliki foto',
            ], 400);
        }

        try {
            $this->deleteFoto($siswa->foto);
            $siswa->update(['foto' => null]);

            // Log aktivitas
            ActivityLog::log(
                'update',
                'siswa',
                "Menghapus foto siswa: {$siswa->nama_lengkap}",
                null,
                null
            );

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Bulk delete siswa
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array|min:1',
            'ids.*' => 'exists:siswa,id',
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
            $siswaList = Siswa::whereIn('id', $request->ids)->get();
            $deletedNames = [];

            foreach ($siswaList as $siswa) {
                // Hapus foto jika ada
                if ($siswa->foto) {
                    $this->deleteFoto($siswa->foto);
                }
                $deletedNames[] = $siswa->nama_lengkap;
            }

            Siswa::whereIn('id', $request->ids)->delete();

            // Log aktivitas
            ActivityLog::log(
                'bulk_delete',
                'siswa',
                "Menghapus " . count($request->ids) . " siswa: " . implode(', ', $deletedNames),
                ['ids' => $request->ids, 'names' => $deletedNames],
                null
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' siswa berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus siswa: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * API: Export data siswa
     */
    public function export(Request $request)
    {
        $kelasId = $request->input('kelas_id', '');
        $status = $request->input('status', '');

        $query = Siswa::with('kelas')
            ->kelasId($kelasId)
            ->status($status)
            ->orderBy('nama_lengkap');

        $siswa = $query->get();

        // Log aktivitas
        ActivityLog::log(
            'export',
            'siswa',
            "Mengekspor data " . $siswa->count() . " siswa",
            null,
            ['kelas_id' => $kelasId, 'status' => $status]
        );

        return response()->json([
            'success' => true,
            'data' => $siswa,
        ]);
    }

    /**
     * Helper: Mendapatkan statistik siswa
     */
    private function getStatistics()
    {
        return [
            'total' => Siswa::count(),
            'aktif' => Siswa::where('status', 'aktif')->count(),
            'laki_laki' => Siswa::where('status', 'aktif')->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Siswa::where('status', 'aktif')->where('jenis_kelamin', 'P')->count(),
            'alumni' => Siswa::where('status', 'alumni')->count(),
            'pindah' => Siswa::where('status', 'pindah')->count(),
        ];
    }

    /**
     * Helper: Mendapatkan badge status
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'aktif' => ['color' => 'green', 'bg' => 'bg-green-100', 'text' => 'text-green-800'],
            'alumni' => ['color' => 'blue', 'bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
            'pindah' => ['color' => 'yellow', 'bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
            'keluar' => ['color' => 'orange', 'bg' => 'bg-orange-100', 'text' => 'text-orange-800'],
            'dropout' => ['color' => 'red', 'bg' => 'bg-red-100', 'text' => 'text-red-800'],
        ];

        return $badges[$status] ?? $badges['aktif'];
    }

    /**
     * Helper: Aturan validasi
     */
    private function validationRules($id = null)
    {
        return [
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nis')->ignore($id)],
            'nisn' => ['required', 'string', 'max:20', Rule::unique('siswa', 'nisn')->ignore($id)],
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'agama' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'rt_rw' => 'nullable|string|max:10',
            'kelurahan' => 'nullable|string|max:50',
            'kecamatan' => 'nullable|string|max:50',
            'kota' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:50',
            'kode_pos' => 'nullable|string|max:10',
            'no_telepon' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:100',
            'nama_ayah' => 'nullable|string|max:100',
            'nama_ibu' => 'nullable|string|max:100',
            'pekerjaan_ayah' => 'nullable|string|max:100',
            'pekerjaan_ibu' => 'nullable|string|max:100',
            'no_telepon_ortu' => 'nullable|string|max:15',
            'kelas_id' => 'nullable|exists:kelas,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,alumni,pindah,keluar,dropout',
            'tahun_masuk' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'tahun_keluar' => 'nullable|integer|min:2000|max:' . (date('Y') + 10),
        ];
    }

    /**
     * Helper: Upload foto
     */
    private function uploadFoto($file)
    {
        $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
        $file->storeAs('siswa', $filename, 'public');
        return $filename;
    }

    /**
     * Helper: Hapus foto
     */
    private function deleteFoto($filename)
    {
        if (Storage::disk('public')->exists('siswa/' . $filename)) {
            Storage::disk('public')->delete('siswa/' . $filename);
        }
    }
}
