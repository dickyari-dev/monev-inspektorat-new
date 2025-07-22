<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DesaController;
use App\Http\Controllers\DesaDataController;
use App\Http\Controllers\InspektoratController;
use App\Http\Controllers\JadwalMonevController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\JenisDokumenController;
use App\Http\Controllers\JenisLaporanController;
use App\Http\Controllers\KategoriLaporanController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KecamatanDataController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\StrukturDesaController;
use App\Http\Controllers\StrukturInspektoratController;
use App\Http\Controllers\StrukturKecamatanController;
use App\Http\Controllers\WaktuMonevController;
use App\Models\Desa;
use App\Models\StrukturDesa;
use Illuminate\Support\Facades\Route;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->name('index');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/loginPost', [AuthController::class, 'loginPost'])->name('loginPost');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Struktur Inspektorat
Route::post('/inspektorat/struktur-inspektorat/store', [StrukturInspektoratController::class, 'store'])->name('inspektorat.struktur-inspektorat.store');
Route::get('/struktur-inspektorat/edit/{id}', [StrukturInspektoratController::class, 'edit'])->name('struktur-inspektorat.edit');
Route::put('/struktur-inspektorat/update/{id}', [StrukturInspektoratController::class, 'update'])->name('struktur-inspektorat.update');
Route::get('/struktur-inspektorat/delete/{id}', [StrukturInspektoratController::class, 'store'])->name('struktur-inspektorat.destroy');


// Struktur kecamatan
Route::post('/struktur-kecamatan/store', [StrukturKecamatanController::class, 'store'])->name('struktur-kecamatan.store');
Route::get('/struktur-kecamatan/edit/{id}', [StrukturKecamatanController::class, 'edit'])->name('struktur-kecamatan.edit');
Route::put('/struktur-kecamatan/update/{id}', [StrukturKecamatanController::class, 'update'])->name('struktur-kecamatan.update');
Route::get('/struktur-kecamatan/delete/{id}', [StrukturKecamatanController::class, 'store'])->name('struktur-kecamatan.destroy');

// Struktur Desa
Route::post('/struktur-desa/store', [StrukturDesaController::class, 'store'])->name('struktur-desa.store');
Route::get('/struktur-desa/edit/{id}', [StrukturDesaController::class, 'edit'])->name('struktur-desa.edit');
Route::put('/struktur-desa/update/{id}', [StrukturDesaController::class, 'update'])->name('struktur-desa.update');
Route::get('/struktur-desa/delete/{id}', [StrukturDesaController::class, 'destroy'])->name('struktur-desa.destroy');

// Kecamatan 
Route::post('/kecamatan/store', [KecamatanDataController::class, 'store'])->name('kecamatan.store');
Route::get('/kecamatan/edit/{id}', [KecamatanDataController::class, 'edit'])->name('kecamatan.edit');
Route::put('/kecamatan/update/{id}', [KecamatanDataController::class, 'update'])->name('kecamatan.update');
Route::get('/kecamatan/delete/{id}', [KecamatanDataController::class, 'destroy'])->name('kecamatan.destroy');

// Desa
Route::post('/desa/store', [DesaDataController::class, 'store'])->name('desa.store');
Route::get('/desa/edit/{id}', [DesaDataController::class, 'edit'])->name('desa.edit');
Route::put('/desa/update/{id}', [DesaDataController::class, 'update'])->name('desa.update');
Route::get('/desa/delete/{id}', [DesaDataController::class, 'destroy'])->name('desa.destroy');


// Kategori Laporan
Route::post('/kategori-laporan/store', [KategoriLaporanController::class, 'store'])->name('kategori-laporan.store');
Route::get('/kategori-laporan/{id}/edit', [KategoriLaporanController::class, 'edit'])->name('kategori-laporan.edit');
Route::put('/kategori-laporan/update/{id}', [KategoriLaporanController::class, 'update'])->name('kategori-laporan.update');
Route::delete('/kategori-laporan/{id}', [KategoriLaporanController::class, 'destroy'])->name('kategori-laporan.destroy');

// Jenis Laporan
Route::post('/jenis-laporan/store', [JenisLaporanController::class, 'store'])->name('jenis-laporan.store');
Route::get('/jenis-laporan/{id}/edit', [JenisLaporanController::class, 'edit'])->name('jenis-laporan.edit');
Route::put('/jenis-laporan/update/{id}', [JenisLaporanController::class, 'update'])->name('jenis-laporan.update');
Route::delete('/jenis-laporan/{id}', [JenisLaporanController::class, 'destroy'])->name('jenis-laporan.destroy');

// Jenis Dokumen
Route::post('/jenis-dokumen/store', [JenisDokumenController::class, 'store'])->name('jenis-dokumen.store');
Route::get('/jenis-dokumen/{id}/edit', [JenisDokumenController::class, 'edit'])->name('jenis-dokumen.edit');
Route::put('/jenis-dokumen/update/{id}', [JenisDokumenController::class, 'update'])->name('jenis-dokumen.update');
Route::delete('/jenis-dokumen/{id}', [JenisDokumenController::class, 'destroy'])->name('jenis-dokumen.destroy');

// Waktu Monev
Route::post('/waktu-monev/store', [WaktuMonevController::class, 'store'])->name('waktu-monev.store');
Route::post('/waktu-monev/filter', [WaktuMonevController::class, 'filter'])->name('waktu-monev.filter');
Route::get('/waktu-monev/{id}/edit', [WaktuMonevController::class, 'edit'])->name('waktu-monev.edit');
Route::put('/waktu-monev/update/{id}', [WaktuMonevController::class, 'update'])->name('waktu-monev.update');
Route::get('/waktu-monev/{id}', [WaktuMonevController::class, 'destroy'])->name('waktu-monev.destroy');

// Petugas
Route::post('/data-petugas/store', [PetugasController::class, 'store'])->name('data-petugas.store');
Route::post('/data-petugas/filter', [PetugasController::class, 'filter'])->name('data-petugas.filter');
Route::get('/data-petugas/{id}/edit', [PetugasController::class, 'edit'])->name('data-petugas.edit');
Route::put('/data-petugas/update/{id}', [PetugasController::class, 'update'])->name('data-petugas.update');
Route::get('/data-petugas/{id}', [PetugasController::class, 'destroy'])->name('data-petugas.destroy');


Route::post('/pertanyaan/store', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
Route::get('/pertanyaan/{id}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
Route::put('/pertanyaan/update/{id}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
Route::delete('/pertanyaan/{id}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

Route::post('/jadwal-monev/store', [JadwalMonevController::class, 'store'])->name('jadwal-monev.store');
Route::get('/jadwal-monev/{id}', [JadwalMonevController::class, 'destroy'])->name('jadwal-monev.destroy');



Route::post('/kirim-pertanyaan', [JawabanController::class, 'store'])->name('kirim-pertanyaan');
Route::get('/pertanyaan-by-jenis/{jenisId}', [PertanyaanController::class, 'getByJenis']);




Route::group(['middleware' => ['auth.check:inspektorat']], function () {
    Route::get('/inspektorat/dashboard', [InspektoratController::class, 'dashboard'])->name('inspektorat.dashboard');

    Route::get('/inspektorat/struktur-inspektorat', [InspektoratController::class, 'strukturInspektorat'])->name('inspektorat.struktur-inspektorat');

    Route::get('/inspektorat/struktur-kecamatan', [InspektoratController::class, 'strukturKecamatan'])->name('inspektorat.struktur-kecamatan');

    Route::get('/inspektorat/struktur-desa', [InspektoratController::class, 'strukturDesa'])->name('inspektorat.struktur-desa');

    Route::post('/inspektorat/data-petugas/store', [InspektoratController::class, 'dataPetugasStore'])->name('inspektorat.data-petugas.store');


    // Setting laporan
    Route::get('/inspektorat/setting-laporan', [InspektoratController::class, 'settingLaporan'])->name('inspektorat.setting-laporan');
    Route::post('/inspektorat/kategori-laporan/store', [InspektoratController::class, 'kategoriLaporanPost'])->name('inspektorat.kategori-laporan.store');


    Route::get('/inspektorat/setting-wilayah', [InspektoratController::class, 'settingWilayah'])->name('inspektorat.setting-wilayah');
    Route::post('/inspektorat/setting-wilayah/store', [InspektoratController::class, 'settingWilayahPost'])->name('inspektorat.setting-wilayah.store');


    Route::get('/inspektorat/jadwal-monev', [InspektoratController::class, 'jadwalMonev'])->name('inspektorat.jadwal-monev');
    Route::get('/inspektorat/jadwal-monev/{waktu}/kecamatan/{kecamatan}', [InspektoratController::class, 'detailJadwal'])->name('jadwal-monev.detail');
    Route::get('/inspektorat/jadwal-monev', [InspektoratController::class, 'jadwalMonev'])->name('inspektorat.jadwal-monev');

    // Waktu Monev
    Route::get('/inspektorat/waktu-monev', [InspektoratController::class, 'waktuMonev'])->name('inspektorat.waktu-monev');

    // Petugas 
    Route::get('/inspektorat/data-petugas', [InspektoratController::class, 'dataPetugas'])->name('inspektorat.data-petugas');

    // Monitoring Desa
    Route::get('/inspektorat/monitoring-desa', [InspektoratController::class, 'monitoringDesa'])->name('inspektorat.monitoring-desa');
});
Route::group(['middleware' => ['auth.check:kecamatan']], function () {
    Route::get('/kecamatan/dashboard', [KecamatanController::class, 'dashboard'])->name('kecamatan.dashboard');

    Route::get('/kecamatan/struktur-kecamatan', [KecamatanController::class, 'strukturKecamatan'])->name('kecamatan.struktur-kecamatan');

    Route::get('/kecamatan/struktur-desa', [KecamatanController::class, 'strukturDesa'])->name('kecamatan.struktur-desa');


    Route::get('/kecamatan/data-petugas', [KecamatanController::class, 'dataPetugas'])->name('kecamatan.data-petugas');

    Route::get('/kecamatan/waktu-monev', [KecamatanController::class, 'waktuMonev'])->name('kecamatan.waktu-monev');

    Route::get('/inspektorat/jadwal-monev/{waktu}/kecamatan/{kecamatan}', [KecamatanController::class, 'monitoringDetail'])->name('monitoring.detail');

    Route::get('/kecamatan/monitoring-desa', [KecamatanController::class, 'monitoringDesa'])->name('kecamatan.monitoring-desa');
});
Route::group(['middleware' => ['auth.check:desa']], function () {
    Route::get('/desa/dashboard', [DesaController::class, 'dashboard'])->name('desa.dashboard');

    Route::get('/desa/struktur-desa', [DesaController::class, 'strukturDesa'])->name('desa.struktur-desa');

    Route::get('/desa/data-petugas', [DesaController::class, 'dataPetugas'])->name('desa.data-petugas');

    Route::get('/desa/waktu-monev', [DesaController::class, 'waktuMonev'])->name('desa.waktu-monev');
    Route::get('/desa/monitoring-desa', [DesaController::class, 'monitoringDesa'])->name('desa.monitoring-desa');
});
