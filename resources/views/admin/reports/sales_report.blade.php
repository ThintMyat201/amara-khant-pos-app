<?php
use Barryvdh\DomPDF\Facade\Pdf;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #2d3748;
            line-height: 1.5;
            padding: 20px;
            font-size: 11px;
        }
        
        .header {
            background: #0B5EA8;
            color: white;
            padding: 24px;
            margin-bottom: 24px;
            border-radius: 4px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
            letter-spacing: 1.5px;
        }
        
        .header p {
            font-size: 11px;
            margin: 0;
        }
        
        .info-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0B5EA8;
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 4px;
        }
        
        .info-section h3 {
            color: #0B5EA8;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: 600;
            color: #4a5568;
            padding: 6px 16px 6px 0;
            width: 28%;
        }
        
        .info-value {
            display: table-cell;
            color: #2d3748;
            padding: 6px 0;
        }
        
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #0B5EA8;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #0B5EA8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            background: white;
            border: 1px solid #e2e8f0;
        }
        
        table thead {
            background: #0B5EA8;
            color: white;
        }
        
        table thead th {
            padding: 12px 10px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table tbody td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .product-name {
            font-weight: 600;
            color: #2d3748;
        }
        
        .qty-badge {
            background: #0B5EA8;
            color: white;
            padding: 2px 8px;
            border-radius: 2px;
            font-size: 10px;
            font-weight: 600;
        }
        
        .total-price {
            font-weight: bold;
            color: #0B5EA8;
        }
        
        .summary-section {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: table;
            width: 100%;
            border-spacing: 12px 0;
        }
        
        .summary-card {
            display: table-cell;
            width: 48%;
            padding: 8px 12px;
            border-radius: 4px;
            color: white;
            font-size: 10px;
            vertical-align: middle;
        }
        
        .summary-card.primary {
            background: #0B5EA8;
        }
        
        .summary-card.secondary {
            background: #094a85;
        }
        
        .summary-inline {
            white-space: nowrap;
        }
        
        .summary-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
        }
        
        .summary-value {
            font-size: 13px;
            font-weight: bold;
        }
        
        .summary-unit {
            font-size: 9px;
        }
        
        .footer {
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        
        .footer p {
            margin: 4px 0;
            font-size: 10px;
            color: #64748b;
        }
        
        .footer .badge {
            background: #0B5EA8;
            color: white;
            padding: 6px 16px;
            border-radius: 2px;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 12px;
        }
        
        .empty-state {
            text-align: center;
            padding: 32px 20px;
            color: #64748b;
            background: #f8fafc;
        }
    </style>
</head>
<body>
    
    <!-- Header -->
    <div class="header">
        <h1>SALES REPORT</h1>
        <p>Comprehensive Transaction Summary & Analytics</p>
    </div>

    <!-- Session Information -->
    <div class="info-section">
        <h3>Session Information</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Session Opened:</div>
                <div class="info-value">{{ $session->opened_at->format('d M Y') }} at {{ $session->opened_at->format('h:i A') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Session Closed:</div>
                <div class="info-value">{{ $session->closed_at->format('d M Y') }} at {{ $session->closed_at->format('h:i A') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Duration:</div>
                <div class="info-value">{{ $session->opened_at->diffForHumans($session->closed_at, true) }}</div>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
    <h2 class="section-title">Transaction Details</h2>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 28%;">Product Name</th>
                <th style="width: 18%;">Description</th>
                <th style="width: 14%;" class="text-right">Price (MMK)</th>
                <th style="width: 8%;" class="text-center">Qty</th>
                <th style="width: 15%;" class="text-right">Total (MMK)</th>
            </tr>
        </thead>
        <tbody>
            @if($session->sales->count() > 0)
                @foreach($session->sales as $index => $sale)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="product-name">{{ $sale->product->name ?? '-' }}</td>
                    <td style="color: #666;">{{ $sale->description ?? '-' }}</td>
                    <td class="text-right">{{ number_format($sale->product->price ?? 0, 0) }}</td>
                    <td class="text-center">
                        <span class="qty-badge">{{ $sale->quantity }}</span>
                    </td>
                    <td class="text-right total-price">{{ number_format($sale->total, 0) }}</td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="empty-state">
                        <p>No sales recorded in this session</p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Summary Cards -->
    <div class="summary-section">
        <div class="summary-row">
            <div class="summary-card primary">
                <span class="summary-inline"><span class="summary-label">TOTAL ITEMS SOLD:</span> <span class="summary-value">{{ number_format($totalItems) }}</span> <span class="summary-unit">Items</span></span>
            </div>
            <div class="summary-card secondary">
                <span class="summary-inline"><span class="summary-label">TOTAL SALES REVENUE:</span> <span class="summary-value">{{ number_format($totalSales, 0) }}</span> <span class="summary-unit">MMK</span></span>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Report Generated:</strong> {{ now()->format('l, d F Y \a\t h:i A') }}</p>
        <p>This is a computer-generated document. No signature is required for validation.</p>
        <div class="badge">OFFICIAL SALES REPORT</div>
    </div>

</body>
</html>
