<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PetugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('/login', 'loginForm')->name('login');
    });
});

Route::post('/authenticate', [AuthController::class, 'login'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'multirole:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');
        Route::get('/admin/dashboard/form_area', 'form_area')->name('admin.form_area');
        Route::get('/admin/dashboard/form_kendaraan', 'form_kendaraan')->name('admin.form_kendaraan');

        Route::get('/admin/dashboard/tarif', 'tarif')->name('admin.tarif');
        Route::put('/admin/dashboard/tarif/edit', 'editTarif')->name('admin.editTarif');

        Route::post('/admin/dashboard/form_area/tambah', 'tambahArea')->name('tambah.area');
        Route::get('/admin/dashboard/area/detail_area/{id}', 'detail_area')->name('admin.detail_area');
        Route::put('/admin/dashboard/area/detail_area/edit', 'editArea')->name('admin.editArea');
        Route::delete('/admin/dashboard/area/detail_area/destroy/{id}', 'hapusArea')->name('admin.hapus_area');


        Route::get('/admin/users', 'users')->name('admin.users');
        Route::post('/admin/users/tambah', 'tambahUser')->name('admin.tambahUser');
        Route::get('/admin/users/formEditUser/{id}', 'formEditUser')->name('admin.editUser');
        Route::put('/admin/users/formEditUser/Edit', 'editUser')->name('admin.editUserPost');
        Route::delete('/admin/users/destroy', 'hapusUser')->name('admin.hapusUser');

        Route::get('/admin/log_aktifitas/detail/{id}', 'detailLog')->name('admin.detail_log');
    });
});

Route::middleware(['auth', 'multirole:petugas'])->group(function () {
    Route::controller(PetugasController::class)->group(function () {
        Route::get('/petugas/dashboard', 'dashboard')->name('petugas.dashboard');

        Route::get('/petugas/dashboard/area/detail_area/{id}', 'detail_area')->name('petugas.detail_area');

        Route::get('/petugas/dashboard/customer/tambah', 'tambahCustomer')->name('petugas.tambahCustomer');
        Route::post('/petugas/dashboard/customer/tambah/post', 'tambahCustomerPost')->name('petugas.tambahCustomer.post');

        Route::get('/petugas/dashboard/customers/list', 'customerList')->name('petugas.customerList');
        Route::get('/petugas/dashboard/customers/list/selesai/{id}', 'pelangganFormSelesai')->name('petugas.customerSelesai');
        Route::post('/petugas/dashboard/customers/post', 'pelangganSelesaiPost')->name('petugas.pelangganSelesaiPost');
        Route::get('/petugas/dashboard/customer/struk/{id}', 'struk')->name('petugas.struk');
    });
});


Route::middleware(['auth', 'multirole:owner'])->group(function () {
    Route::controller(OwnerController::class)->group(function () {
        Route::get('/owner/dashboard', 'dashboard')->name('owner.dashboard');
        Route::get('/transaksi/data', 'dataTransaksi');

        Route::get('/owner/dashboard/data_transaksi', 'data_transaksi')->name('owner.dataTransaksi');
        Route::post('/owner/dashboard/data_transaksi/PDFXPOR', 'pdfExport')->name('owner.pdfExport');
        Route::post('/owner/dashboard/data_transaksi/EXCXPOR', 'excelExport')->name('owner.excelExport');
    });
});
