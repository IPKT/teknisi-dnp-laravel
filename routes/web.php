<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemeliharaanController;
use App\Http\Controllers\PeralatanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| ROUTES UNTUK TAMU (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| ROUTES UNTUK USER YANG SUDAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard default → langsung redirect ke halaman peralatan
    // Route::get('/', fn() => redirect()->route('peralatan.index'))->name('home');
    Route::get('/',  [PeralatanController::class, 'index'])->name('home');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // CRUD utama
    // peralatan kecuali destroy
    Route::resource('peralatan', PeralatanController::class)->except(['destroy']);
    // untuk keperluan pilihan site di pemeliharaan
    // Route::get('/get-peralatan-by-jenis', [PeralatanController::class, 'getByJenis'])->name('peralatan.getByJenis');
    Route::get('/peralatan/get-by-jenis/{jenis}', [PeralatanController::class, 'getByJenis'])->name('peralatan.getByJenis');
    // untuk enampilkan seluruh peralatan berdasarkan jenisnya
    Route::get('/peralatan/jenis/{jenis}', [PeralatanController::class, 'filterByJenis'])->name('peralatan.jenis');



    Route::resource('pemeliharaan', PemeliharaanController::class);
    // Route::resource('hardware', HardwareController::class)->except(['destroy']);

    Route::resource('hardware', HardwareController::class);
    Route::get('/hardware/peralatan/{id}/{kode}', [HardwareController::class, 'hardwarePeralatan'])->name('hardware.peralatan');
    Route::resource('dokumen', DokumenController::class)->parameters(['dokumen' => 'dokumen']);
    Route::resource('sparepart', SparepartController::class);
    Route::get('sparepart/list', [SparepartController::class, 'list'])->name('sparepart.list');
    Route::get('/hardware/status/{status}', [HardwareController::class, 'filterByStatus'])->name('hardware.status');
    Route::get('/hardware/rekap-pengadaan/{tahun}', [HardwareController::class, 'rekapPengadaan'])->name('hardware.rekap_pengadaan');
    Route::get('/hardware/detail-pengadaan/{tahun}', [HardwareController::class, 'detailPengadaan'])->name('hardware.detail_pengadaan');
    Route::post('/hardware/import', [HardwareController::class, 'import'])->name('hardware.import');
    Route::get('hardware/download/{peralatanId}', [HardwareController::class, 'download'])->name('hardware.download');







    // Profile user
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/akun-setting', [ProfileController::class, 'akunSetting'])->name('profile.akun_setting');
    Route::put('/update_password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');

    

    // Hanya admin bisa akses halaman register user baru
    Route::middleware(['role:admin,teknisi'])->group(function () {
        Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
        // Route untuk delete peralatan
        Route::delete('/peralatan/{peralatan}', [PeralatanController::class, 'destroy'])->name('peralatan.destroy');
        // Route::delete('/hardware/{hardware}', [HardwareController::class, 'destroy'])->name('hardware.destroy');
        // User manage
        Route::get('/manage-user', [UserController::class, 'index'])->name('manage.user');
        Route::put('/manage-user/{id}', [UserController::class, 'updateRole'])->name('manage.user.update');
    });
});

// Route::get('/test-user', fn() => auth()->user());