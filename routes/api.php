<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiPeralatanController;

// API
Route::middleware('api_token')->group(function () {
  
        Route::get('/ping', function () {
            return 'pong';
        });

        Route::get('/peralatan', [ApiPeralatanController::class, 'index']);
        Route::get('/peralatan/get-by-kode/{kode}', [ApiPeralatanController::class, 'getByKode']);
        Route::put('/peralatan/update-kondisi/{kode}', [ApiPeralatanController::class, 'updateKondisi']);
        Route::put('/peralatan/update-kondisi-bulk', [ApiPeralatanController::class, 'updateKondisiBulk']);
        Route::get('/peralatan/metadata/{kode}', [ApiPeralatanController::class, 'getMetadata']);
        Route::get('/peralatan/networkdata/{kode}', [ApiPeralatanController::class, 'getNetworkData']);
        Route::get('peralatan/pemeliharaan/{kode}', [ApiPeralatanController::class, 'getPemeliharaanByKode']);


        // Route::get('/peralatan/{id}', [ApiPeralatanController::class, 'show']);
        // Route::post('/peralatan', [ApiPeralatanController::class, 'store']);
        // Route::put('/peralatan/{id}', [ApiPeralatanController::class, 'update']);
        // Route::delete('/peralatan/{id}', [ApiPeralatanController::class, 'destroy']);

        // Route::put('/peralatan/{id}/metadata', [ApiPeralatanController::class, 'updateMetadata']);
});