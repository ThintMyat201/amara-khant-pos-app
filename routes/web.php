<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\SaleController;
use App\Http\Controllers\admin\DashboardController;




require_once __DIR__.'/admin.php';

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'adminMiddleware'])
    ->name('dashboard');


Route::get('/saleproduct', [SaleController::class, 'saleProductView'])
    ->middleware(['auth'])
    ->name('sale.products');

require __DIR__.'/auth.php';
