<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;

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
    });
});

