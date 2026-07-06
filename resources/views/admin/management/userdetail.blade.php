@extends('layouts.master')
@section('content')
    <style>
        .modern-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .modern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-header-modern {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border: none;
        }
        
        .profile-img-wrapper {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto;
        }
        
        .profile-img-modern {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid #fff;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }
        
        .profile-img-modern:hover {
            transform: scale(1.05);
        }
        
        .info-row {
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }
        
        .info-row:hover {
            background-color: #f8f9fe;
            border-radius: 8px;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .info-value {
            font-size: 1.05rem;
            color: #2d3748;
            font-weight: 500;
        }
        
        .role-badge {
            display: inline-block;
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        .role-admin {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .role-user {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        
        .modern-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-size: 0.95rem;
        }
        
        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        /* Mobile responsive buttons */
        @media (max-width: 768px) {
            .modern-btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                gap: 0.4rem;
            }
            
            .modern-btn i {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 576px) {
            .modern-btn {
                padding: 0.65rem 0.65rem;
                font-size: 1rem;
                border-radius: 10px;
                min-width: 45px;
                min-height: 45px;
                justify-content: center;
            }
            
            .modern-btn span {
                display: none;
            }
            
            .modern-btn i {
                font-size: 1.1rem;
                margin: 0;
            }
            
            .action-buttons-wrapper {
                gap: 0.6rem !important;
            }
        }
        
        .btn-edit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        
        .btn-back {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
            color: white;
        }
        
        .icon-wrapper {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 0.9rem;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="modern-card">
            <div class="card-header-modern">
                <h4 class="m-0 font-weight-bold text-white text-center">
                    <i class="fa-solid fa-user-circle me-2"></i>User Account Details
                </h4>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <!-- Profile Image Section -->
                    <div class="col-12 col-md-4 col-lg-3 mb-4 mb-md-0">
                        <div class="profile-img-wrapper">
                            <img class="profile-img-modern" id="output"
                                src="{{ $userData->image == null ? asset('images/default.png') : asset('images/' . $userData->image) }}"
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
                                        <div class="info-value">{{ $userData->name }}</div>
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
                                        <div class="info-value">{{ $userData->email }}</div>
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
                                        <div class="info-value">{{ $userData->phone }}</div>
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
                                        <div class="info-value">{{ $userData->address }}</div>
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
                                        @if ($userData->role === 'Admin')
                                            <span class="role-badge role-admin">
                                                <i class="fa-solid fa-crown me-1"></i>{{ $userData->role }}
                                            </span>
                                        @elseif($userData->role === 'User')
                                            <span class="role-badge role-user">
                                                <i class="fa-solid fa-user-check me-1"></i>{{ $userData->role }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="mt-5 d-flex flex-row flex-wrap action-buttons-wrapper" style="gap: 1rem;">
                                <a href="{{ route('userEditView', $userData->id) }}" class="modern-btn btn-edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit Profile</span>
                                </a>
                                <button class="modern-btn btn-delete" type='button' onclick="confirmDelete({{$userData->id}})">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete User</span>
                                </button>
                                <a href="{{ route('userListView') }}" class="modern-btn btn-back">
                                    <i class="fa-solid fa-arrow-left"></i>
                                    <span>Back to List</span>
                                </a>
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
        function confirmDelete($id){
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
                           location.href="/admin/usermanagement/delete/"+$id;
                        },1000);
                    }
                    });
        }
    </script>
@endsection
