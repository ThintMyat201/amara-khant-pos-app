@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-box text-primary"></i> Product Management
            </h1>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex flex-wrap mb-4" style="gap: 1rem;">
            <button class="btn btn-secondary shadow-sm px-4">
                <i class="fa-solid fa-database"></i>
                Product Count: <span class="badge badge-light ml-1">{{ count($product) }}</span>
            </button>
            <a href="{{ route('productListView') }}" class="btn btn-outline-primary shadow-sm px-4">
                <i class="fas fa-list"></i> All Products
            </a>
            <a href="{{ route('productListView', 'lowAmt') }}" class="btn btn-outline-danger shadow-sm px-4">
                <i class="fas fa-exclamation-triangle"></i> Low Stock List
            </a>
        </div>

        <!-- Product List Card -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header py-3 bg-gradient-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-boxes"></i> Product List
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="productTable">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th class="border font-weight-bold text-primary">Image</th>
                                <th class="border font-weight-bold text-primary">Name</th>
                                <th class="border font-weight-bold text-primary">Price</th>
                                <th class="border font-weight-bold text-primary">Stock</th>
                                <th class="border font-weight-bold text-primary">Category</th>
                                <th class="border font-weight-bold text-primary">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $item)
                                <tr>
                                    <td class="border text-center">
                                        <img src="{{ asset('images/' . $item->image) }}"
                                            class="img-thumbnail rounded shadow-sm" style="width:80px; max-width:100%; height:auto;" alt="{{ $item->name }}">
                                    </td>
                                    <td class="border font-weight-bold">{{ $item->name }}</td>
                                    <td class="border text-center text-primary font-weight-bold">{{ number_format($item->price, 0) }} MMK</td>
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
                                    <td class="border text-center">
                                        <span class="badge badge-secondary px-3 py-2">{{ $item->category_name }}</span>
                                    </td>
                                    <td class="border text-center">
                                        <div class="d-flex justify-content-center" style="gap: 0.5rem;">
                                            <a href="{{ route('productEditView', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button class="btn btn-sm btn-outline-danger shadow-sm" type='button'
                                                onclick="confirmDelete({{ $item->id }})" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
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
                { "orderable": false, "targets": [0, 5] } // Disable sorting on Image and Actions columns
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

@section('sweet-alert')
    <script>
        function confirmDelete($id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                    setInterval(() => {
                        location.href = "/admin/product/delete/" + $id;
                    }, 2000);
                }
            });
        }
    </script>
@endsection
