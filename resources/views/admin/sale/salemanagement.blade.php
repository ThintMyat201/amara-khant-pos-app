@extends('layouts.master')
@section('content')

<div class="container-fluid">
    
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-cash-register text-primary"></i> Sale Management
        </h1>
    </div>

    <!-- Control Panel Card -->
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-header py-3 bg-gradient-primary">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-cogs"></i> Store Control Panel
            </h6>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-12 col-md-7 mb-3 mb-md-0">
                    @if (!$storeOpen)
                        <div class="row g-3 align-items-center">
                            <div class="col-12 col-sm-auto mb-2 mb-sm-0">
                                <form action="{{ route('openStore') }}" method="POST" id="openStoreForm">@csrf
                                    <button type="button" class="btn btn-success shadow-sm w-100 px-4" onclick="confirmOpenStore()">
                                        <i class="fas fa-door-open"></i> Open Store
                                    </button>
                                </form>
                            </div>
                            @if ($sessions->count() > 0 && $sessions->first()->closed_at)
                                <div class="col-12 col-sm-auto">
                                    <a href="{{ route('generateReport') }}" class="btn btn-primary shadow-sm w-100 px-4" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Generate Report
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('closeStore') }}" method="POST" id="closeStoreForm">@csrf
                            <button type="button" class="btn btn-danger shadow-sm px-4" onclick="confirmCloseStore()">
                                <i class="fas fa-door-closed"></i> Close Store
                            </button>
                        </form>
                    @endif
                </div>
                <div class="col-12 col-md-5">
                    <div class="d-flex justify-content-md-end align-items-center">
                        <div class="card border-primary shadow-sm">
                            <div class="card-body py-2 px-3">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Session Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalAmount, 0) }} MMK</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sessions List -->
    @foreach ($sessions as $session)
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header py-3 bg-light border-bottom">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle"></i> Session Information
                        </h6>
                        <small class="text-muted">
                            <i class="far fa-calendar-alt"></i> Opened: {{ $session->opened_at ? $session->opened_at->format('d M Y, h:i A') : 'N/A' }}
                        </small>
                    </div>
                    <div>
                        <span class="badge {{ $session->closed_at ? 'badge-danger' : 'badge-success' }} px-3 py-2">
                            <i class="fas fa-{{ $session->closed_at ? 'lock' : 'lock-open' }}"></i>
                            {{ $session->closed_at ? 'Closed at '.$session->closed_at->format('d M Y, h:i A') : 'Currently Open' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th class="border font-weight-bold text-primary">Product Name</th>
                                <th class="border font-weight-bold text-primary">Price</th>
                                <th class="border font-weight-bold text-primary">Description</th>
                                <th class="border font-weight-bold text-primary">Quantity</th>
                                <th class="border font-weight-bold text-primary">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($session->sales as $item)
                                <tr>
                                    <td class="border font-weight-bold">{{ $item->product->name ?? '-' }}</td>
                                    <td class="border text-center text-primary">{{ number_format($item->product->price ?? 0, 0) }} MMK</td>
                                    <td class="border">{{ $item->description}}</td>
                                    <td class="border text-center">
                                        <span class="badge badge-pill badge-secondary px-3">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="border text-center font-weight-bold text-success">{{ number_format($item->total, 0) }} MMK</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination links -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $session->sales->firstItem() }} to {{ $session->sales->lastItem() }} 
                            of {{ $session->sales->total() }} entries
                        </div>
                        <div>
                            {{ $session->sales->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
@section('script-js')
<script>
    function confirmOpenStore() {
        Swal.fire({
            title: 'Open Store?',
            text: 'Are you sure you want to open the store?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, open it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('openStoreForm').submit();
            }
        });
    }

    function confirmCloseStore() {
        Swal.fire({
            title: 'Close Store?',
            text: 'Are you sure you want to close the store?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, close it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('closeStoreForm').submit();
            }
        });
    }
</script>
@endsection


