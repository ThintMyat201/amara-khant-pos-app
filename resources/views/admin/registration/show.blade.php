@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Registration Request Details</h1>
        <a href="{{ route('registration.requests.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Information</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $request->name }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $request->email }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Phone:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $request->phone ?? 'Not provided' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Address:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $request->address ?? 'Not provided' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-md-9">
                            @if($request->status === 'pending')
                                <span class="badge badge-warning badge-lg">Pending</span>
                            @elseif($request->status === 'approved')
                                <span class="badge badge-success badge-lg">Approved</span>
                            @elseif($request->status === 'rejected')
                                <span class="badge badge-danger badge-lg">Rejected</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <strong>Requested On:</strong>
                        </div>
                        <div class="col-md-9">
                            {{ $request->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    @if($request->status !== 'pending')
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <strong>Processed By:</strong>
                            </div>
                            <div class="col-md-9">
                                {{ $request->admin ? $request->admin->name : 'N/A' }}
                            </div>
                        </div>

                        @if($request->approved_at)
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <strong>Processed On:</strong>
                                </div>
                                <div class="col-md-9">
                                    {{ $request->approved_at->format('d M Y, h:i A') }}
                                </div>
                            </div>
                        @endif

                        @if($request->admin_note)
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <strong>Admin Note:</strong>
                                </div>
                                <div class="col-md-9">
                                    <div class="alert alert-info">
                                        {{ $request->admin_note }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($request->status === 'pending')
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <button type="button" class="btn btn-success btn-block mb-2" data-toggle="modal" data-target="#approveModal">
                            <i class="fas fa-check"></i> Approve Request
                        </button>
                        <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times"></i> Reject Request
                        </button>
                    </div>
                </div>
            @else
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('registration.requests.destroy', $request->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this request?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-block">
                                <i class="fas fa-trash"></i> Delete Request
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve Registration Request</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('registration.requests.approve', $request->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to approve registration for <strong>{{ $request->name }}</strong>?</p>
                    <p class="text-muted small">This will create a user account with the provided information.</p>
                    <div class="form-group">
                        <label for="admin_note">Note (Optional):</label>
                        <textarea class="form-control" name="admin_note" rows="3" 
                                  placeholder="Add any notes for this approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Registration Request</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('registration.requests.reject', $request->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to reject registration for <strong>{{ $request->name }}</strong>?</p>
                    <div class="form-group">
                        <label for="admin_note">Reason (Required): <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="admin_note" rows="3" required
                                  placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
