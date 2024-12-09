<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\InvoicePurchaseController;
use App\Http\Controllers\ManufacturingController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SalesQuotationController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InvoiceSalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

//Product
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::post('/product-store', [ProductController::class, 'store'])->name('product.store');
Route::post('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

//Ingredients
Route::get('/ingredients', [IngredientsController::class, 'index'])->name('ingredients');
Route::post('/ingredients-store', [IngredientsController::class, 'store'])->name('ingredients.store');
Route::post('/ingredients/{id}', [IngredientsController::class, 'update'])->name('ingredients.update');
Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy'])->name('ingredients.destroy');

//Materials
Route::get('/materials', [MaterialsController::class, 'index'])->name('materials');
Route::post('/materials-store', [MaterialsController::class, 'store'])->name('materials.store');
Route::post('/materials/{id}', [MaterialsController::class, 'update'])->name('materials.update');
Route::delete('/materials/{id}', [MaterialsController::class, 'destroy'])->name('materials.destroy');
Route::get('/materials/report', [MaterialsController::class, 'report'] )->name('materials.report');

//Manufacturing
Route::get('/manufacturing', [ManufacturingController::class, 'index'])->name('manufacturing');
Route::post('/manufacturing-store', [ManufacturingController::class, 'store'])->name('manufacturing.store');
Route::post('/manufacturing/{id}', [ManufacturingController::class, 'update'])->name('manufacturing.update');
Route::delete('/manufacturing/{id}', [ManufacturingController::class, 'destroy'])->name('manufacturing.destroy');

Route::get('vendor', [VendorController::class, 'index'])->name('vendor');

Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation');

Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment');

Route::get('/customer', [CustomerController::class, 'index'])->name('customer');

Route::get('/sales-quotation', [SalesQuotationController::class, 'index'])->name('sales-quotation');

Route::get('/sales-order', [SalesOrderController::class, 'index'])->name('sales-order');

Route::get('/delivery', [SalesController::class, 'delivery'])->name('delivery');
Route::get('/validate', action: [SalesController::class, 'index'])->name('validate');

Route::get('/invoice-sales', [InvoiceSalesController::class, 'index'])->name('invoice-sales');
Route::get('/invoice-purchase', [InvoicePurchaseController::class, 'index'])->name('invoice-purchase');


