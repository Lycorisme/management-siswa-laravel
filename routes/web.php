<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Protected Routes (Auth Required)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Data Siswa (View)
    Route::get('/students', [SiswaController::class, 'index'])->name('students.index');
    
    // Data Guru/Staff (View)
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    
    // Data Kelas (View)
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');

    // API Routes for Siswa (AJAX)
    Route::prefix('api')->group(function () {
        // Siswa CRUD
        Route::get('/siswa', [SiswaController::class, 'getData'])->name('api.siswa.index');
        Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('api.siswa.show');
        Route::post('/siswa', [SiswaController::class, 'store'])->name('api.siswa.store');
        Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('api.siswa.update');
        Route::delete('/siswa/{id}', [SiswaController::class, 'destroy'])->name('api.siswa.destroy');
        
        // Siswa Additional Routes
        Route::post('/siswa/{id}/upload-photo', [SiswaController::class, 'uploadPhoto'])->name('api.siswa.upload-photo');
        Route::delete('/siswa/{id}/delete-photo', [SiswaController::class, 'deletePhoto'])->name('api.siswa.delete-photo');
        Route::post('/siswa/bulk-delete', [SiswaController::class, 'bulkDelete'])->name('api.siswa.bulk-delete');
        Route::get('/siswa-export', [SiswaController::class, 'export'])->name('api.siswa.export');
        
        // Kelas CRUD
        Route::get('/kelas', [KelasController::class, 'getData'])->name('api.kelas.index');
        Route::get('/kelas/{id}', [KelasController::class, 'show'])->name('api.kelas.show');
        Route::post('/kelas', [KelasController::class, 'store'])->name('api.kelas.store');
        Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('api.kelas.update');
        Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('api.kelas.destroy');

        // Guru/Staff CRUD
        Route::get('/guru', [GuruController::class, 'getData'])->name('api.guru.index');
        Route::get('/guru/{id}', [GuruController::class, 'show'])->name('api.guru.show');
        Route::post('/guru', [GuruController::class, 'store'])->name('api.guru.store');
        Route::put('/guru/{id}', [GuruController::class, 'update'])->name('api.guru.update');
        Route::delete('/guru/{id}', [GuruController::class, 'destroy'])->name('api.guru.destroy');
        
        // Guru Additional Routes
        Route::post('/guru/bulk-delete', [GuruController::class, 'bulkDelete'])->name('api.guru.bulk-delete');
        Route::post('/guru/{id}/reset-password', [GuruController::class, 'resetPassword'])->name('api.guru.reset-password');
    });
});

