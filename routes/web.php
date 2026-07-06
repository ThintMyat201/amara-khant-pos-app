<?php


use App\Models\sale;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\SaleController;




require_once __DIR__.'/admin.php';

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/dashboard', function () {
    // Daily earnings
        // Assuming 'created_at' is a timestamp field in the 'sales' table
        // Adjust the timezone if necessary
    date_default_timezone_set('Asia/Yangon');
        
        // Daily earnings for today
    $dailyEarnings = sale::whereDate('created_at', now()->toDateString())->sum('total');
    
    
    // Monthly earnings for current year (up to current month)
    $monthlyEarnings = [];
    $currentMonth = now()->month;
    for ($i = 1; $i <= $currentMonth; $i++) {
        $monthlyEarnings[] = sale::whereMonth('created_at', $i)
            ->whereYear('created_at', now()->year)
            ->sum('total');
    }
    
    // Fill remaining months with 0
    while (count($monthlyEarnings) < 12) {
        $monthlyEarnings[] = 0;
    }
    
    // Only current year and future projections
    $yearlyData = [];
    $yearlyLabels = [];
    $currentYear = now()->year; // 2025
    
    // Just show current year's data
    $yearlyLabels[] = (string)$currentYear;
    $yearlyData[] = sale::whereYear('created_at', $currentYear)->sum('total');
    
    // Add future year projections
    for ($i = 1; $i <= 2; $i++) {
        $yearlyLabels[] = (string)($currentYear + $i);
        $yearlyData[] = 0; // Future projections set to 0
    }
    
    $annualEarnings = sale::whereYear('created_at', now()->year)->sum('total');

    $totalUsers = \App\Models\User::count(); // Assuming you have a User model
    
    return view('admin.home.dashboard', compact(
        'dailyEarnings', 
        'monthlyEarnings', 
        'annualEarnings',
        'yearlyData',
        'yearlyLabels',
        'totalUsers'
    ));
})->middleware(['auth', 'verified', 'adminMiddleware'])->name('dashboard');


Route::get('/saleproduct', [SaleController::class, 'saleProductView'])
    ->middleware(['auth'])
    ->name('sale.products');

require __DIR__.'/auth.php';
