@extends('layouts.master')
@section('content')

    <div class="container-fluid">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-users text-primary"></i> User Management
            </h1>
        </div>

        <!-- User List Card -->
        <div class="card shadow-lg border-0 mb-4">
            <div class="card-header py-3 bg-gradient-primary">
                <h6 class="m-0 font-weight-bold text-white">
                    <i class="fas fa-list"></i> User List
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="userTable">
                        <thead class="bg-light">
                            <tr class="text-center">
                                <th class="border font-weight-bold text-primary">ID</th>
                                <th class="border font-weight-bold text-primary">Name</th>
                                <th class="border font-weight-bold text-primary">Email</th>
                                <th class="border font-weight-bold text-primary">Role</th>
                                <th class="border font-weight-bold text-primary">Created Date</th>
                                <th class="border font-weight-bold text-primary">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($userData) != 0)

                                @foreach ($userData as $item)
                                    <tr>
                                        <td class="border text-center">{{ $item->id }}</td>
                                        <td class="border">{{ $item->name }}</td>
                                        <td class="border">{{ $item->email }}</td>
                                        <td class="border text-center">
                                            @if ($item->role === 'Admin')
                                                <span class="badge badge-danger px-3 py-2">
                                                    <i class="fas fa-user-shield"></i> Admin
                                                </span>
                                            @elseif($item->role === 'User')
                                                <span class="badge badge-primary px-3 py-2">
                                                    <i class="fas fa-user"></i> User
                                                </span>
                                            @else
                                                <span class="badge badge-secondary px-3 py-2">{{ $item->role }}</span>
                                            @endif
                                        </td>
                                        <td class="border text-center">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                        <td class="border text-center">
                                            <a href="{{ route('userDetailView', $item->id) }}"
                                                class="btn btn-sm btn-outline-primary shadow-sm">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>

                                @endforeach

                            @else
                                <tr>
                                    <td colspan="6" class="border text-center py-5">
                                        <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                                        <h5 class="text-muted">There is no user</h5>
                                    </td>
                                </tr>
                            @endif
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
        $('#userTable').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "order": [[ 4, "desc" ]], // Sort by created date column descending
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "language": {
                "emptyTable": "No users available",
                "info": "Showing _START_ to _END_ of _TOTAL_ users",
                "infoEmpty": "Showing 0 to 0 of 0 users",
                "infoFiltered": "(filtered from _MAX_ total users)",
                "lengthMenu": "Show _MENU_ users per page",
                "search": "Search users:",
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
