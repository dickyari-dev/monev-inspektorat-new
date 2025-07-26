<?php

use App\Http\Controllers\DesaController;
use App\Http\Controllers\DokumenJawabanController;
use App\Http\Controllers\JadwalMonevController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\JenisLaporanController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\StrukturDesaController;
use App\Models\Desa;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/desa-by-kecamatan/{id}', [StrukturDesaController::class, 'getByKecamatan']);
Route::get('/jenis-by-kategori/{id}', [JenisLaporanController::class, 'getByKategori']);
Route::get('/jadwal-by-desa/{desa_id}', [JadwalMonevController::class, 'getJadwalByDesa']);

Route::get('/dokumen-pertanyaan/{pertanyaan_id}/{desa_id}', [PertanyaanController::class, 'getDokumenPertanyaan']);

Route::get('/dokumen-by-id/{id}', [JenisDokumenController::class, 'getDokumenById']);

Route::get('/dokumen-pertanyaan/{desaId}', [JenisDokumenController::class, 'getWithDesa']);
Route::get('/pertanyaan-by-jenis/{jenisId}/{desaId}', [PertanyaanController::class, 'getByJenis']);
Route::get('/ambil-jenis-dokumen-all/{desaId}', [DokumenJawabanController::class, 'ambilSemua']);

Route::post('/upload-dokumen-jawaban', [DokumenJawabanController::class, 'upload'])->name('upload-dokumen-jawaban');
Route::post('/upload-dokumen-jawaban-inspektorat', [DokumenJawabanController::class, 'uploadInspektorat'])->name('upload-dokumen-jawaban-inspektorat');

Route::get('/desa-by-kecamatan/{kecamatanId}', [DesaController::class, 'getByKecamatan']);







