<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BomController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user = auth()->user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'manajer':
                return redirect()->route('manajer.dashboard');
            case 'kasir':
            default:
                return redirect()->route('kasir.dashboard');
        }
    });
});

Auth::routes();

// ==========================================
// ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'can:access-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // Route::get('/', function () {
        //     return 'Admin Dashboard';
        // })->name('dashboard');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Nanti route master data (users, satuan, supplier, kategori_menu, menu) ditaruh di sini
        // dengan format AJAX CRUD

        // CRUD Standar (index, store, dll)
        Route::resource('kategori-menu', KategoriMenuController::class);
        // Rute khusus AJAX
        Route::post('ajax/kategori-menu/getEditForm', [KategoriMenuController::class, 'getEditForm'])->name('kategori-menu.getEditForm');
        Route::post('ajax/kategori-menu/saveDataUpdate', [KategoriMenuController::class, 'saveDataUpdate'])->name('kategori-menu.saveDataUpdate');
        Route::post('ajax/kategori-menu/deleteData', [KategoriMenuController::class, 'deleteData'])->name('kategori-menu.deleteData');

        Route::resource('menu', MenuController::class);
        // Rute khusus AJAX
        Route::post('ajax/menu/getEditForm', [MenuController::class, 'getEditForm'])->name('menu.getEditForm');
        Route::post('ajax/menu/saveDataUpdate', [MenuController::class, 'saveDataUpdate'])->name('menu.saveDataUpdate');
        Route::post('ajax/menu/deleteData', [MenuController::class, 'deleteData'])->name('menu.deleteData');

        Route::resource('satuan', SatuanController::class);
        // Rute khusus AJAX
        Route::post('ajax/satuan/getEditForm', [SatuanController::class, 'getEditForm'])->name('satuan.getEditForm');
        Route::post('ajax/satuan/saveDataUpdate', [SatuanController::class, 'saveDataUpdate'])->name('satuan.saveDataUpdate');
        Route::post('ajax/satuan/deleteData', [SatuanController::class, 'deleteData'])->name('satuan.deleteData');

        Route::resource('bahan-baku', BahanBakuController::class);
        // Rute khusus AJAX
        Route::post('ajax/bahan-baku/getEditForm', [BahanBakuController::class, 'getEditForm'])->name('bahan-baku.getEditForm');
        Route::post('ajax/bahan-baku/saveDataUpdate', [BahanBakuController::class, 'saveDataUpdate'])->name('bahan-baku.saveDataUpdate');
        Route::post('ajax/bahan-baku/deleteData', [BahanBakuController::class, 'deleteData'])->name('bahan-baku.deleteData');

        Route::resource('supplier', SupplierController::class);
        // Rute khusus AJAX
        Route::post('ajax/supplier/getEditForm', [SupplierController::class, 'getEditForm'])->name('supplier.getEditForm');
        Route::post('ajax/supplier/saveDataUpdate', [SupplierController::class, 'saveDataUpdate'])->name('supplier.saveDataUpdate');
        Route::post('ajax/supplier/deleteData', [SupplierController::class, 'deleteData'])->name('supplier.deleteData');

        Route::resource('user', UserController::class);
        // Rute khusus AJAX
        Route::post('ajax/user/getEditForm', [UserController::class, 'getEditForm'])->name('user.getEditForm');
        Route::post('ajax/user/saveDataUpdate', [UserController::class, 'saveDataUpdate'])->name('user.saveDataUpdate');
        Route::post('ajax/user/deleteData', [UserController::class, 'deleteData'])->name('user.deleteData');

        Route::resource('bom', BomController::class);
        Route::get('bom/{id}', [BomController::class, 'show'])->name('bom.show');
        // Rute khusus AJAX
        Route::post('ajax/bom/getEditForm', [BomController::class, 'getEditForm'])->name('bom.getEditForm');
        Route::post('ajax/bom/saveDataUpdate', [BomController::class, 'saveDataUpdate'])->name('bom.saveDataUpdate');
        Route::post('ajax/bom/deleteData', [BomController::class, 'deleteData'])->name('bom.deleteData');
    });

// ==========================================
// MANAJER ROUTES
// ==========================================
Route::middleware(['auth', 'can:access-manajer'])
    ->prefix('manajer')
    ->name('manajer.')
    ->group(function () {
        // Route::get('dashboard', [ManajerDashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', function () {
            return 'Manajer Dashboard';
        })->name('dashboard');

        // Nanti route BOM, Pembelian, Penerimaan, Prediksi ditaruh di sini
    });

// ==========================================
// KASIR ROUTES
// ==========================================
Route::middleware(['auth', 'can:access-kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {
        // Route::get('dashboard', [KasirDashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard', function () {
            return 'Kasir Dashboard';
        })->name('dashboard');

        // Nanti route Kasir (Input Penjualan) ditaruh di sini
    });

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
