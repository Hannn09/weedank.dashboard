<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/ingredients', [IngredientsController::class, 'index'])->name('ingredients');

Route::get('/materials', [MaterialsController::class, 'index'])->name('materials');

Route::get('/materials/report', [MaterialsController::class, 'report'] )->name('materials.report');

Route::get('/manufacturing', [ManufacturingController::class, 'index'])->name('manufacturing');

Route::get('vendor', [VendorController::class, 'index'])->name('vendor');

Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation');

Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
