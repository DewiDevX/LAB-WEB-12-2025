<?php
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

// Route untuk dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Resource routes
Route::resource('categories', CategoryController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('products', ProductController::class);

// Stock routes
Route::get('/stocks', [StockController::class, 'index'])->name('stocks.index');
Route::get('/stocks/transfer', [StockController::class, 'transfer'])->name('stocks.transfer');
Route::post('/stocks/transfer', [StockController::class, 'processTransfer'])->name('stocks.process-transfer');