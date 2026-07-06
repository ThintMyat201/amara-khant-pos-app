@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-shopping-bag text-primary"></i> Sale Products
            </h1>
            <div>
                <form action="{{ route('cartView') }}" method="get" class="d-inline">
                    <button type="submit" class="btn btn-primary shadow-sm position-relative">
                        <i class="fa-solid fa-cart-shopping"></i> Cart
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ is_countable($cart) ? count($cart) : 0 }}
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex flex-wrap mb-4" style="gap: 1rem;">
            <button class="btn btn-secondary shadow-sm px-4">
                <i class="fa-solid fa-database"></i>
                Product Count: <span class="badge badge-light ml-1">{{ count($product) }}</span>
            </button>
            <a href="{{ route('saleProductView') }}" class="btn btn-outline-primary shadow-sm px-4">
                <i class="fas fa-list"></i> All Products
            </a>
        </div>

        <!-- Product List Card -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header py-3 bg-gradient-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-boxes"></i> Available Products
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="productTable">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th class="border font-weight-bold text-primary">Image</th>
                                <th class="border font-weight-bold text-primary">Name</th>
                                <th class="border font-weight-bold text-primary">Description</th>
                                <th class="border font-weight-bold text-primary">Stock</th>
                                <th class="border font-weight-bold text-primary">Price</th>
                                <th class="border font-weight-bold text-primary">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $item)
                                <tr>
                                    <td class="border text-center">
                                        <img src="{{ asset('images/' . $item->image) }}"
                                            class="img-thumbnail rounded shadow-sm"
                                            style="width:80px; max-width:100%; height:auto;" alt="{{ $item->name }}">
                                    </td>
                                    <td class="border font-weight-bold">{{ $item->name }}</td>
                                    <td class="border">{{ $item->description }}</td>
                                    <td class="border text-center">
                                        @if ($item->stock == 0)
                                            <span class="badge badge-danger px-3 py-2">
                                                <i class="fas fa-times-circle"></i> Out of Stock
                                            </span>
                                        @else
                                            <span class="badge badge-info px-3 py-2">{{ $item->stock }}</span>
                                            @if ($item->stock <= 3)
                                                <br>
                                                <span class="badge badge-warning mt-1">
                                                    <i class="fas fa-exclamation-triangle"></i> Low Stock
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="border text-center text-primary font-weight-bold">{{ number_format($item->price, 0) }} MMK</td>
                                    <td class="border text-center">
                                        <form action="{{ route('addCart') }}" method='post'>
                                            @csrf
                                            <input type='hidden' name="userid" value="{{ Auth::user()->id }}">
                                            <input type='hidden' name="productid" value="{{ $item->id }}">
                                            <button type='submit'
                                                class="btn btn-sm btn-outline-danger shadow-sm d-inline-flex align-items-center justify-content-center"
                                                title="Add to Cart"
                                                @if($item->stock == 0) disabled @endif>
                                                <i class="fa-solid fa-cart-plus"></i><span class="d-none d-md-inline ml-1">Add to Cart</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-js')
<script>
    $(document).ready(function() {
        // Initialize DataTable with custom settings
        $('#productTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "order": [[ 1, "asc" ]], // Sort by name column ascending
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 5] } // Disable sorting on Image and Action columns
            ],
            "language": {
                "emptyTable": '<div class="py-4 text-center"><i class="fas fa-box-open fa-3x text-gray-300 mb-3 d-block"></i><h5 class="text-muted">There are no products</h5></div>',
                "info": "Showing _START_ to _END_ of _TOTAL_ products",
                "infoEmpty": "Showing 0 to 0 of 0 products",
                "infoFiltered": "(filtered from _MAX_ total products)",
                "lengthMenu": "Show _MENU_ products per page",
                "search": "Search products:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });
    });
</script>
@endsection
