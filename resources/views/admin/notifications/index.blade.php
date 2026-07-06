@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
        <form action="{{ route('notifications.markAllAsRead') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-check-double"></i> Mark All as Read
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Notifications</h6>
        </div>
        <div class="card-body">
            <div class="list-group">
                @forelse($notifications as $notification)
                    <div class="list-group-item list-group-item-action {{ $notification->is_read ? '' : 'bg-light' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">
                                @if($notification->type === 'registration_request')
                                    <i class="fas fa-user-plus text-info"></i> Registration Request
                                @else
                                    <i class="fas fa-bell text-primary"></i> Notification
                                @endif
                                @if(!$notification->is_read)
                                    <span class="badge badge-primary ml-2">New</span>
                                @endif
                            </h6>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">{{ $notification->message }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div>
                                @if($notification->registration_request_id)
                                    <a href="{{ route('registration.requests.show', $notification->registration_request_id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View Request
                                    </a>
                                @endif
                            </div>
                            <div>
                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" 
                                          method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-check"></i> Mark as Read
                                        </button>
                                    </form>
                                @endif
                                <small class="text-muted ml-2">
                                    {{ $notification->created_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No notifications</h5>
                        <p class="text-muted">You're all caught up!</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
