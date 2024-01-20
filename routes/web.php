<?php

use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
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

Route::prefix('admin')->group(function() {
    // supplier
    Route::get('/supplier', [SupplierController::class, 'Aindex'])->name('admin.supplier.index');
    Route::post('/supplier', [SupplierController::class, 'Astore'])->name('admin.supplier.store');
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'Aedit'])->name('admin.supplier.edit');
    Route::put('/supplier/update/{id}', [SupplierController::class, 'Aupdate'])->name('admin.supplier.update');
    Route::delete('/supplier/{id}', [SupplierController::class, 'Adestroy'])->name('admin.supplier.destroy');

    // category product
    Route::get('/kategori-produk', [ProductCategoryController::class, 'Aindex'])->name('admin.product_category.index');
    Route::post('/kategori-produk', [ProductCategoryController::class, 'Astore'])->name('admin.product_category.store');
    Route::get('/kategori-produk/edit/{id}', [ProductCategoryController::class, 'Aedit'])->name('admin.product_category.edit');
    Route::put('/kategori-produk/update/{id}', [ProductCategoryController::class, 'Aupdate'])->name('admin.product_category.update');
    Route::delete('/kategori-produk/{id}', [ProductCategoryController::class, 'Adestroy'])->name('admin.product_category.destroy');

    // product
    Route::get('/produk', [ProductController::class, 'Aindex'])->name('admin.product.index');
    Route::get('/produk/tambah', [ProductController::class, 'Aadd'])->name('admin.product.add');
    Route::post('/produk', [ProductController::class, 'Astore'])->name('admin.product.store');
    Route::get('/produk/edit/{id}', [ProductController::class, 'Aedit'])->name('admin.product.edit');
    Route::put('/produk/update/{id}', [ProductController::class, 'Aupdate'])->name('admin.product.update');
    Route::delete('/produk/{id}', [ProductController::class, 'Adestroy'])->name('admin.product.destroy');

});
// Route::get('/product-category', [ProductCategoryController::class, 'AGetDataIndex']);
