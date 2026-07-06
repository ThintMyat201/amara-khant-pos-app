@extends('layouts.master')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-chart-line text-primary"></i> <span class="d-none d-md-inline">Sales Overview</span><span class="d-md-none">Sales</span>
        </h1>
        <!-- Toggle Filter Button -->
        <button class="btn btn-sm btn-primary d-flex align-items-center" type="button" onclick="toggleFilter()" style="white-space: nowrap;">
            <i class="fas fa-filter"></i>
            <span class="ml-1 d-none d-sm-inline" id="filterBtnText">Show Filters</span>
            <i class="fas fa-chevron-down ml-1" id="filterIcon"></i>
        </button>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-lg border-0 mb-4" id="filterSection" style="display: none;">
        <div class="card-header py-3 bg-gradient-primary">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-filter"></i> Filter Sales Data
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('saleListView') }}" id="filterForm">
                <div class="row">
                    <!-- Quick Filter Buttons -->
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Quick Filters:</label>
                        <div class="btn-group" role="group" style="gap: 0.5rem;">
                            <button type="button" class="btn btn-sm {{ request('filter') == 'today' ? 'btn-primary' : 'btn-outline-primary' }} shadow-sm" onclick="setFilter('today')">
                                <i class="fas fa-calendar-day"></i> Today
                            </button>
                            <button type="button" class="btn btn-sm {{ request('filter') == 'month' ? 'btn-primary' : 'btn-outline-primary' }} shadow-sm" onclick="setFilter('month')">
                                <i class="fas fa-calendar-alt"></i> This Month
                            </button>
                            <button type="button" class="btn btn-sm {{ request('filter') == 'year' ? 'btn-primary' : 'btn-outline-primary' }} shadow-sm" onclick="setFilter('year')">
                                <i class="fas fa-calendar"></i> This Year
                            </button>
                            <button type="button" class="btn btn-sm {{ !request('filter') && !request('start_date') ? 'btn-primary' : 'btn-outline-primary' }} shadow-sm" onclick="setFilter('all')">
                                <i class="fas fa-list"></i> All
                            </button>
                        </div>
                    </div>
                    
                    <!-- Date Range Filter -->
                    <div class="col-md-4">
                        <label class="font-weight-bold">Start Date:</label>
                        <input type="date" name="start_date" class="form-control shadow-sm" 
                               value="{{ request('start_date') }}" 
                               onchange="document.getElementById('filterForm').submit()">
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold">End Date:</label>
                        <input type="date" name="end_date" class="form-control shadow-sm" 
                               value="{{ request('end_date') }}" 
                               onchange="document.getElementById('filterForm').submit()">
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-success shadow-sm mr-2">
                            <i class="fas fa-filter"></i> Apply Filter
                        </button>
                        <a href="{{ route('saleListView') }}" class="btn btn-secondary shadow-sm">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
                <input type="hidden" name="filter" id="filterInput" value="{{ request('filter') }}">
            </form>
        </div>
    </div>

    <!-- Sales Summary Cards -->
    @if($totalSales > 0)
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Sales Revenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalSales, 0) }} MMK
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Items Sold
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($totalQuantity) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Number of Transactions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ number_format($transactionCount) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Sales Data Table -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-header py-3 bg-gradient-primary">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-table"></i> Sales Transaction Details
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="salesTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr class="text-center">
                            <th class="border font-weight-bold text-primary">Product Name</th>
                            <th class="border font-weight-bold text-primary">Description</th>
                            <th class="border font-weight-bold text-primary">Price</th>
                            <th class="border font-weight-bold text-primary">Quantity</th>
                            <th class="border font-weight-bold text-primary">Total</th>
                            <th class="border font-weight-bold text-primary">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $item)
                        <tr>
                            <td class="border font-weight-bold">{{ $item->product_name }}</td>
                            <td class="border">{{ $item->description }}</td>
                            <td class="border text-center text-primary font-weight-bold">{{ number_format($item->price, 0) }} MMK</td>
                            <td class="border text-center">
                                <span class="badge badge-pill badge-secondary px-3 py-1">{{ $item->quantity }}</span>
                            </td>
                            <td class="border text-center text-success font-weight-bold">{{ number_format($item->total, 0) }} MMK</td>
                            <td class="border text-center">
                                @if($item->created_at->isToday())
                                    <span class="badge badge-success px-3 py-1">
                                        <i class="fas fa-calendar-day"></i> Today
                                    </span>
                                @else
                                    <span class="badge badge-light px-3 py-1">{{ $item->created_at->format('Y-m-d') }}</span>
                                @endif
                                <br>
                                <small class="text-muted"><i class="far fa-clock"></i> {{ $item->created_at->format('h:i A') }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection

@section('script-js')
<script>
    $(document).ready(function() {
        // Initialize DataTable with custom settings
        $('#salesTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "order": [[ 5, "desc" ]], // Sort by date column descending
            "pageLength": 7,
            "lengthMenu": [[7, 10, 25, 50, -1], [7, 10, 25, 50, "All"]],
            "language": {
                "emptyTable": "No sales data available",
                "info": "Showing _START_ to _END_ of _TOTAL_ transactions",
                "infoEmpty": "Showing 0 to 0 of 0 transactions",
                "infoFiltered": "(filtered from _MAX_ total transactions)",
                "lengthMenu": "Show _MENU_ transactions per page",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    });

    function toggleFilter() {
        const filterSection = document.getElementById('filterSection');
        const filterBtnText = document.getElementById('filterBtnText');
        const filterIcon = document.getElementById('filterIcon');
        
        if (filterSection.style.display === 'none') {
            filterSection.style.display = 'block';
            filterBtnText.textContent = 'Hide Filters';
            filterIcon.classList.remove('fa-chevron-down');
            filterIcon.classList.add('fa-chevron-up');
        } else {
            filterSection.style.display = 'none';
            filterBtnText.textContent = 'Show Filters';
            filterIcon.classList.remove('fa-chevron-up');
            filterIcon.classList.add('fa-chevron-down');
        }
    }

    function setFilter(filterType) {
        const form = document.getElementById('filterForm');
        const filterInput = document.getElementById('filterInput');
        
        // Clear date inputs when using quick filters
        if (filterType !== 'all') {
            document.querySelector('input[name="start_date"]').value = '';
            document.querySelector('input[name="end_date"]').value = '';
            filterInput.value = filterType;
        } else {
            filterInput.value = '';
        }
        
        form.submit();
    }
</script>
@endsection

