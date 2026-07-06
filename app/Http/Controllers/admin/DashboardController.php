<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Daily earnings for today
        $dailyEarnings = Sale::whereDate('created_at', now()->toDateString())->sum('total');
        
        // Monthly earnings for current year (up to current month)
        // Optimized: 1 single aggregated query instead of 12 queries in a loop
        // Compatible with both MySQL (production) and SQLite (testing)
        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite' ? "CAST(strftime('%m', created_at) AS INTEGER)" : "MONTH(created_at)";
        
        $monthlyData = Sale::whereYear('created_at', now()->year)
            ->selectRaw("{$monthExpr} as month, SUM(total) as total")
            ->groupBy('month')
            ->pluck('total', 'month');
            
        $monthlyEarnings = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyEarnings[] = (float) $monthlyData->get($i, 0);
        }
        
        // Only current year and future projections
        $yearlyData = [];
        $yearlyLabels = [];
        $currentYear = now()->year;
        
        // Just show current year's data
        $yearlyLabels[] = (string) $currentYear;
        $yearlyData[] = Sale::whereYear('created_at', $currentYear)->sum('total');
        
        // Add future year projections
        for ($i = 1; $i <= 2; $i++) {
            $yearlyLabels[] = (string) ($currentYear + $i);
            $yearlyData[] = 0; // Future projections set to 0
        }
        
        $annualEarnings = $yearlyData[0];

        $totalUsers = User::count();
        
        return view('admin.home.dashboard', compact(
            'dailyEarnings', 
            'monthlyEarnings', 
            'annualEarnings',
            'yearlyData',
            'yearlyLabels',
            'totalUsers'
        ));
    }
}
