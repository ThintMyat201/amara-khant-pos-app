@extends('layouts.master')
@section('content')
    <style>
        .profile-card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .profile-card-header {
            background: var(--amara-primary, #0B5EA8);
            padding: 1.5rem;
            border: none;
        }
        
        .profile-img-wrapper {
            width: 140px;
            height: 140px;
            margin: 0 auto;
        }
        
        .profile-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
        }
        
        .info-row {
            padding: 0.85rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-value {
            font-size: 1rem;
            color: #2d3748;
            font-weight: 500;
        }
        
        .role-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .role-admin {
            background: var(--amara-primary, #0B5EA8);
            color: white;
        }
        
        .role-user {
            background: var(--amara-secondary, #2691D7);
            color: white;
        }
        
        .icon-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--amara-primary, #0B5EA8);
            color: white;
            font-size: 0.8rem;
        }
        
        .btn-profile {
            padding: 0.6rem 1.25rem;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .btn-edit-profile {
            background: var(--amara-primary, #0B5EA8);
            color: white;
        }
        
        .btn-edit-profile:hover {
            background: var(--amara-primary-dark, #094a85);
            color: white;
        }
        
        .btn-delete-profile {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete-profile:hover {
            background: #c82333;
            color: white;
        }

        @media (max-width: 576px) {
            .btn-profile span {
                display: none;
            }
            .btn-profile {
                min-width: 42px;
                min-height: 42px;
                justify-content: center;
                padding: 0.5rem;
            }
        }
    </style>

    <div class="container-fluid py-4">
        <div class="profile-card">
            <div class="profile-card-header">
                <h4 class="m-0 font-weight-bold text-white text-center">
                    <i class="fa-solid fa-user-circle me-2"></i>My Account Profile
                </h4>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <!-- Profile Image Section -->
                    <div class="col-12 col-md-4 col-lg-3 mb-4 mb-md-0">
                        <div class="profile-img-wrapper">
                            <img class="profile-img" id="output"
                                src="{{ $profileData->image == null ? asset('images/default.png') : asset('images/' . $profileData->image) }}"
                                alt="User Image">
                        </div>
                    </div>
                    
                    <!-- User Information Section -->
                    <div class="col-12 col-md-8 col-lg-9">
                        <div class="px-3">
                            <!-- Name -->
                            <div class="info-row">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-4 col-lg-3">
                                        <div class="info-label">
                                            <div class="icon-wrapper">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                            <span>Name</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-9 mt-2 mt-sm-0">
                                        <div class="info-value">{{ $profileData->name }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="info-row">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-4 col-lg-3">
                                        <div class="info-label">
                                            <div class="icon-wrapper">
                                                <i class="fa-solid fa-envelope"></i>
                                            </div>
                                            <span>Email</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-9 mt-2 mt-sm-0">
                                        <div class="info-value">{{ $profileData->email }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Phone -->
                            <div class="info-row">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-4 col-lg-3">
                                        <div class="info-label">
                                            <div class="icon-wrapper">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                            <span>Phone</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-9 mt-2 mt-sm-0">
                                        <div class="info-value">{{ $profileData->phone }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Address -->
                            <div class="info-row">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-4 col-lg-3">
                                        <div class="info-label">
                                            <div class="icon-wrapper">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                            <span>Address</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-9 mt-2 mt-sm-0">
                                        <div class="info-value">{{ $profileData->address }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Role -->
                            <div class="info-row">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-4 col-lg-3">
                                        <div class="info-label">
                                            <div class="icon-wrapper">
                                                <i class="fa-solid fa-shield-halved"></i>
                                            </div>
                                            <span>Role</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-8 col-lg-9 mt-2 mt-sm-0">
                                        @if ($profileData->role === 'Admin')
                                            <span class="role-badge role-admin">
                                                <i class="fa-solid fa-crown me-1"></i>{{ $profileData->role }}
                                            </span>
                                        @elseif($profileData->role === 'User')
                                            <span class="role-badge role-user">
                                                <i class="fa-solid fa-user-check me-1"></i>{{ $profileData->role }}
                                            </span>
                                        @else
                                            <span class="role-badge role-admin">
                                                <i class="fa-solid fa-user-shield me-1"></i>{{ $profileData->role }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-4 d-flex flex-row flex-wrap" style="gap: 0.75rem;">
                                <a href="{{ route('profileEditView') }}" class="btn-profile btn-edit-profile">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit Profile</span>
                                </a>
                                <button class="btn-profile btn-delete-profile" type='button' onclick="confirmDelete()">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete Account</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
@section('sweet-alert')
    <script>
        function confirmDelete(){
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
                    setInterval(()=>{
                        location.href = "{{ route('deleteProfile') }}";
                    },1000);
                }
            });
        }
    </script>
@endsection

