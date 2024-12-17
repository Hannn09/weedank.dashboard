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

//Vendor
Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
Route::post('/vendor-store', [VendorController::class, 'store'])->name('vendor.store');
Route::post('/vendor/{id}', [VendorController::class, 'update'])->name('vendor.update');
Route::delete('/vendor/{id}', [VendorController::class, 'destroy'])->name('vendor.destroy');

//Quotation
Route::get('/quotation', [QuotationController::class, 'index'])->name('quotation');
Route::post('/quotation-store', [QuotationController::class, 'store'])->name('quotation.store');
Route::post('/quotation/{id}', [QuotationController::class, 'update'])->name('quotation.update');
Route::delete('/quotation/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');

//Purchase
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase');
Route::post('/purchase-store', [PurchaseController::class, 'store'])->name('purchase.store');
Route::post('/purchase/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
Route::delete('/purchase/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');

//Payment
Route::get('/payment', [PaymentController::class, 'index'])->name('payment');
Route::post('/payment-store', [PaymentController::class, 'store'])->name('payment.store');
Route::post('/payment/{id}', [PaymentController::class, 'update'])->name('payment.update');
Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');

//Customer
Route::get('/customer', [CustomerController::class, 'index'])->name('customer');
Route::post('/customer-store', [CustomerController::class, 'store'])->name('customer.store');
Route::post('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

Route::get('/sales-quotation', [SalesQuotationController::class, 'index'])->name('sales-quotation');
Route::post('/sales-quotation-store', [SalesQuotationController::class, 'store'])->name('sales-quotation.store');
Route::delete('/sales-quotation/{code}', [SalesQuotationController::class, 'destroy'])->name('sales-quotation.destroy');
Route::patch('/sales-quotation/{code}/send', [SalesQuotationController::class, 'updateStatusToSent'])->name('sales-quotation.send');
Route::patch('/sales-quotation/{code}/confirm', [SalesQuotationController::class, 'updateStatusToConfirmed'])->name('sales-quotation.confirm');
Route::get('/sales-quotation/{code}/export', [SalesQuotationController::class, 'exportPDF'])->name('sales-quotation.export');

Route::get('/sales-order', [SalesOrderController::class, 'index'])->name('sales-order');
Route::post('/sales-order-store', [SalesOrderController::class, 'store'])->name('sales-order.store');
Route::delete('/sales-order/{code}', [SalesOrderController::class, 'destroy'])->name('sales-order.destroy');
Route::patch('/sales-order/{code}/accept', [SalesOrderController::class, 'accept'])->name('sales-order.accept');
Route::post('/sales-order/{code}/check-availability', [SalesOrderController::class, 'checkAvailability'])->name('sales-order.check-availability');
Route::patch('/sales-order/{code}/paid', [SalesOrderController::class, 'paid'])->name('sales-order.paid');
Route::get('/sales-order/quotation-products/{code}', [SalesOrderController::class, 'getQuotationProducts'])->name('sales-order.quotation-products');

Route::get('/delivery', [SalesController::class, 'delivery'])->name('delivery');
Route::patch('/delivery/{code}/delivery', [SalesController::class, 'deliver'])->name('delivery.delivery');
Route::get('/validate', [SalesController::class, 'index'])->name('validate');
Route::patch('/validate/{code}/validate', [SalesController::class, 'validateOrder'])->name('validate.validate');


Route::get('/invoice-sales', [InvoiceSalesController::class, 'index'])->name('invoice-sales');
Route::post('/invoice-sales-store', [InvoiceSalesController::class, 'store'])->name('invoice-sales.store');
Route::get('/invoice-purchase', [InvoicePurchaseController::class, 'index'])->name('invoice-purchase');
Route::post('/invoice-purchase-store', [InvoicePurchaseController::class, 'store'])->name('invoice-purchase.store');
Route::get('/invoice-purchase-report/{$id}', [InvoicePurchaseController::class, 'exportPdf'])->name('invoice-purchase.report');

