<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/ingredients', [IngredientsController::class, 'index'])->name('ingredients');
