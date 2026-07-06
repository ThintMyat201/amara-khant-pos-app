<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StoreSession;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function generateReport()
    {
        // Get the latest closed session
        $session = StoreSession::where('closed_at', '!=', null)
                         ->latest('closed_at')
                         ->with(['sales.product'])
                         ->first();

        if (!$session) {
            return back()->with('error', 'No closed session found');
        }

        if (!$session->closed_at) {
            return back()->with('error', 'Cannot generate report for an active session');
        }

        // Calculate totals
        $totalSales = $session->sales->sum('total');
        $totalItems = $session->sales->sum('quantity');

        // Generate PDF
        $pdf = Pdf::loadView('admin.reports.sales_report', [
            'session' => $session,
            'totalSales' => $totalSales,
            'totalItems' => $totalItems
        ]);

        // Return the PDF for download
        return $pdf->download('sales_report_' . $session->closed_at->format('Y-m-d') . '.pdf');
    }
}
