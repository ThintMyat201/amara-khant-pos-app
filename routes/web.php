<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\SaleController;
use App\Http\Controllers\admin\DashboardController;




require __DIR__.'/admin.php';

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'adminMiddleware'])
    ->name('dashboard');


Route::get('/saleproduct', [SaleController::class, 'saleProductView'])
    ->middleware(['auth'])
    ->name('sale.products');

Route::get('/images/{filename}', function (string $filename) {
    $safeName = basename($filename);
    $candidates = [
        public_path('images/' . $safeName),
        storage_path('app/public/images/' . $safeName),
        sys_get_temp_dir() . '/amara_images/' . $safeName,
        sys_get_temp_dir() . '/' . $safeName,
    ];

    foreach ($candidates as $path) {
        if (is_file($path)) {
            return response()->file($path);
        }
    }

    $defaultPath = public_path('images/default.png');
    if (is_file($defaultPath)) {
        return response()->file($defaultPath);
    }

    abort(404);
})->where('filename', '.*');

require __DIR__.'/auth.php';
