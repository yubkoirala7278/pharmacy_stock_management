<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StockAdjustmentsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home/charts', [HomeController::class, 'getChartData'])->name('home.charts');

// Medicine
Route::get('/medicines', [MedicinesController::class, 'index'])->name('medicines.index');
Route::get('/medicines/data', [MedicinesController::class, 'getMedicines'])->name('medicines.data');
Route::post('/medicines', [MedicinesController::class, 'store'])->name('medicines.store');
Route::get('/medicines/{id}', [MedicinesController::class, 'show'])->name('medicines.show');
Route::put('/medicines/{id}', [MedicinesController::class, 'update'])->name('medicines.update');
Route::delete('/medicines/{id}', [MedicinesController::class, 'destroy'])->name('medicines.destroy');

// Categories
Route::get('categories/data', [CategoryController::class, 'getCategories'])->name('categories.data');
Route::resource('categories', CategoryController::class);

// Suppliers
Route::get('suppliers/data', [SuppliersController::class, 'getSuppliers'])->name('suppliers.data');
Route::resource('suppliers', SuppliersController::class);

// Purchase
Route::get('purchases/data', [PurchasesController::class, 'getPurchases'])->name('purchases.data');
Route::resource('purchases', PurchasesController::class);

// Sales
Route::get('sales/data', [SalesController::class, 'getSales'])->name('sales.data');
Route::post('sales/{id}/payment', [SalesController::class, 'storePayment'])->name('sales.payment');
Route::resource('sales', SalesController::class);

// payments
Route::get('payments/data', [PaymentsController::class, 'getPayments'])->name('payments.data');
Route::resource('payments', PaymentsController::class);

// stock adjustments
Route::get('stock_adjustments/data', [StockAdjustmentsController::class, 'getAdjustments'])->name('stock_adjustments.data');
Route::resource('stock_adjustments', StockAdjustmentsController::class);

// users
Route::get('users/data', [UsersController::class, 'getUsers'])->name('users.data');
Route::resource('users', UsersController::class);

