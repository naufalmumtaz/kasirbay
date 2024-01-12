<?php

use App\Http\Controllers\ProductCategoryController;
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
    Route::get('/kategori-produk', [ProductCategoryController::class, 'Aindex'])->name('admin.product_category.index');
    Route::post('/kategori-produk', [ProductCategoryController::class, 'Astore'])->name('admin.product_category.store');
    Route::get('/kategori-produk/edit/{id}', [ProductCategoryController::class, 'Aedit'])->name('admin.product_category.edit');
    Route::put('/kategori-produk/update/{id}', [ProductCategoryController::class, 'Aupdate'])->name('admin.product_category.update');
    Route::delete('/kategori-produk/{id}', [ProductCategoryController::class, 'Adestroy'])->name('admin.product_category.destroy');
});
// Route::get('/product-category', [ProductCategoryController::class, 'AGetDataIndex']);
