@extends('layouts.master')
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Category List</h1>
        </div>

        <div class="">
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body shadow">
                            <form action="{{ route('categoryCreateButton') }}" method="post" class="p-3 rounded">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="categoryName" value=""
                                        class="form-control @error('categoryName') is-invalid @enderror"
                                        placeholder="Category Name...">
                                    @error('categoryName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-outline-primary mt-3 w-100">Create</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-hover shadow-sm rounded overflow-hidden">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                     <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categorylist as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                        <td>
                                                <button class="btn btn-sm btn-outline-danger btn-sm me-1" type='button'
                                                    onclick="confirmDelete({{ $item->id }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $categorylist->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        location.href = "/admin/category/delete/" + $id;
                    }, 1000);
                }
            });
        }
    </script>
@endsection
