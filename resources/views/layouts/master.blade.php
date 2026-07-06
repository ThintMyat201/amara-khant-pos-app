<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sale Admin - Dashboard</title>

    {{-- font awesome link --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/amara-khant-theme.css')}}" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

    <style>
        /* Modern Notification Badge */
        .badge-counter {
            position: absolute;
            top: -5px;
            right: -5px;
            min-width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.4);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        /* Modern Notification Icon */
        .notification-icon {
            position: relative;
            display: inline-block;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            background: rgba(11, 94, 168, 0.05);
        }
        
        .notification-icon:hover {
            background: rgba(11, 94, 168, 0.15);
            transform: scale(1.05);
        }
        
        .notification-icon .fa-bell {
            font-size: 1.2rem;
            color: #0B5EA8;
            transition: all 0.3s ease;
        }
        
        .notification-icon:hover .fa-bell {
            animation: ring 0.5s ease;
        }
        
        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            10%, 30% { transform: rotate(-10deg); }
            20%, 40% { transform: rotate(10deg); }
        }
        
        /* Modern Profile Section */
        .user-profile-wrapper {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: linear-gradient(135deg, rgba(11, 94, 168, 0.05) 0%, rgba(11, 94, 168, 0.1) 100%);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .user-profile-wrapper:hover {
            background: linear-gradient(135deg, rgba(11, 94, 168, 0.1) 0%, rgba(11, 94, 168, 0.15) 100%);
            box-shadow: 0 4px 12px rgba(11, 94, 168, 0.15);
            transform: translateY(-2px);
        }
        
        .user-name-text {
            font-weight: 600;
            color: #2c3e50;
            margin-right: 0.75rem;
            font-size: 0.9rem;
        }
        
        .img-profile {
            width: 40px;
            height: 40px;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .user-profile-wrapper:hover .img-profile {
            border-color: #0B5EA8;
            box-shadow: 0 4px 12px rgba(11, 94, 168, 0.3);
        }
        
        .icon-circle {
            height: 2.5rem;
            width: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .dropdown-list {
            width: 22rem !important;
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            overflow: hidden;
        }

        .dropdown-list .dropdown-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 1rem;
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }
        
        .dropdown-list .dropdown-item {
            padding: 0.85rem 1.25rem;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .dropdown-list .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            transform: translateX(5px);
        }
        
        .dropdown-list .dropdown-item.bg-light {
            background: #f8f9fc;
            border-left: 4px solid #667eea;
        }
        
        /* User Dropdown Menu */
        .dropdown-menu.user-menu {
            border: none;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-radius: 12px;
            overflow: hidden;
            min-width: 200px;
        }
        
        .dropdown-menu.user-menu .dropdown-item {
            padding: 0.75rem 1.25rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .dropdown-menu.user-menu .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(11, 94, 168, 0.1) 0%, rgba(11, 94, 168, 0.15) 100%);
            transform: translateX(5px);
        }
        
        .dropdown-menu.user-menu .dropdown-item i {
            width: 20px;
            transition: all 0.2s ease;
        }
        
        .dropdown-menu.user-menu .dropdown-item:hover i {
            transform: scale(1.2);
            color: #0B5EA8 !important;
        }
        
        .topbar-divider {
            width: 0;
            border-right: 1px solid rgba(0,0,0,.1);
            height: 2.5rem;
            margin: auto 1rem;
        }
            padding-bottom: .75rem;
            color: #fff;
        }

        .dropdown-list .dropdown-item {
            white-space: normal;
            padding-top: .5rem;
            padding-bottom: .5rem;
            border-left: 1px solid #e3e6f0;
            border-right: 1px solid #e3e6f0;
            border-bottom: 1px solid #e3e6f0;
        }

        .dropdown-list .dropdown-item:hover {
            background-color: #f8f9fc;
        }

        .dropdown-list .dropdown-item:active {
            background-color: #eaecf4;
            color: #3a3b45;
        }
        
        /* ===== SIMPLE SIDEBAR STYLES ===== */
        
        /* Sidebar background */
        .sidebar {
            background: var(--amara-primary) !important;
        }
        
        /* Sidebar brand */
        .sidebar-brand {
            height: 5rem;
            background: rgba(0,0,0,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-brand-icon img {
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        
        /* Sidebar divider */
        .sidebar-divider {
            border-top: 1px solid rgba(255,255,255,0.15);
            margin: 0.5rem 0;
        }
        
        /* Nav items */
        .sidebar .nav-item .nav-link {
            padding: 0.85rem 1rem;
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .sidebar .nav-item .nav-link:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-item.active .nav-link {
            color: #ffffff;
            background: rgba(255,255,255,0.15);
            font-weight: 600;
        }
        
        /* Nav link icons */
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 1.25rem;
            text-align: center;
        }
        
        /* Badge styling */
        .sidebar .badge-counter {
            background: #dc3545;
            color: white;
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
        }
        
        /* Collapse submenu */
        .sidebar .collapse-inner {
            background: #fff !important;
            border-radius: 6px;
            margin: 0 0.75rem 0.5rem 0.75rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            padding: 0.5rem 0 !important;
        }
        
        .sidebar .collapse-header {
            color: var(--amara-primary);
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem;
            margin: 0;
        }
        
        .sidebar .collapse-item {
            padding: 0.5rem 1rem;
            color: #3a3b45;
            font-weight: 500;
        }
        
        .sidebar .collapse-item:hover {
            background: #f0f7ff;
            color: var(--amara-primary);
        }
        
        /* Sidebar toggle button */
        #sidebarToggle {
            width: 2.5rem;
            height: 2.5rem;
            background: rgba(255,255,255,0.15);
        }
        
        #sidebarToggle::after {
            color: white !important;
        }
        
        #sidebarToggle:hover {
            background: rgba(255,255,255,0.25);
        }
        
        /* Toggled sidebar */
        .sidebar.toggled {
            width: 6.5rem;
        }
        
        .sidebar.toggled .nav-item .nav-link span {
            display: none;
        }
        
        .sidebar.toggled .sidebar-brand-text {
            display: none;
        }
        
        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(0,0,0,0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2);
            border-radius: 3px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @if(Auth::check() && (Auth::user()->role == 'Admin' || Auth::user()->role == 'admin'))
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('saleProductView') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('images/Amara_Khant_logo.png') }}" alt="Amara Khant Logo" class="img-fluid" style="max-height: 50px; width: auto; object-fit: contain;">
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            @if(Auth::user()->role == 'Admin')
                <!-- Nav Item - Dashboard -->
                <li class="nav-item {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            @endif

            @if(Auth::user()->role == 'Admin')
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ Request::routeIs('productListView', 'productCreateView', 'categoryCreateView') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-solid fa-layer-group"></i>
                    <span>Product</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Product Management:</h6>
                        <a class="collapse-item" href="{{ route('productListView')}}">Product List</a>
                        <a class="collapse-item" href="{{ route('productCreateView')}}">Add Product</a>
                        <a class="collapse-item" href="{{ route('categoryCreateView')}}">Category</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item {{ Request::routeIs('userListView', 'userCreateView') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUser"
                    aria-expanded="true" aria-controls="collapseUser">
                    <i class="fa-solid fa-user"></i>
                    <span>User</span>
                </a>
                <div id="collapseUser" class="collapse" aria-labelledby="headingUser"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">User Management:</h6>
                        <a class="collapse-item" href="{{ route('userListView')}}">User List</a>
                        <a class="collapse-item" href="{{ route('userCreateView')}}">Add User</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Registration Requests -->
            <li class="nav-item {{ Request::routeIs('registration.requests.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('registration.requests.index') }}">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Register</span>
                    @php
                        $pendingCount = \App\Models\RegistrationRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge badge-danger badge-counter ml-2">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>

            <!-- Nav Item - Sale Management Table -->
            <li class="nav-item {{ Request::routeIs('saleManagementView') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('saleManagementView') }}">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Store</span></a>
            </li>
            @endif


            <!-- Nav Item - Sale -->
            <li class="nav-item {{ Request::routeIs('saleProductView') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('saleProductView') }}">
                    <i class="fa-solid fa-shop"></i>
                    <span>Sales</span></a>
            </li>

            <!-- Nav Item - Tracking -->
            @if(Auth::user()->role == 'Admin')
            <li class="nav-item {{ Request::routeIs('saleListView') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('saleListView') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tracking</span></a>
            </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
        @else
        <style>
            #wrapper #content-wrapper {
                width: 100% !important;
                margin-left: 0 !important;
                padding-left: 0 !important;
                padding-bottom: 0 !important;
            }
            #content {
                width: 100% !important;
            }
        </style>
        @endif

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    @if(Auth::check() && (Auth::user()->role == 'Admin' || Auth::user()->role == 'admin'))
                    <!-- Sidebar Toggle (Topbar) - hidden on mobile, bottom nav used instead -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    @endif

                    <!-- Logo - visible at top on mobile/tablet (when bottom nav is active) or always if sidebar is hidden -->
                    <a class="sidebar-brand-mobile {{ (Auth::check() && (Auth::user()->role == 'Admin' || Auth::user()->role == 'admin')) ? 'd-lg-none' : '' }} d-flex align-items-center mr-auto" href="{{ route('saleProductView') }}">
                        <img src="{{ asset('images/Amara_Khant_logo.png') }}" alt="Amara Khant" class="img-fluid" style="max-height: 36px; width: auto; object-fit: contain;">
                    </a>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        
                        @if(Auth::user()->role == 'Admin')
                        <!-- Nav Item - Notifications -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link p-0" href="#" id="notificationsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="notification-icon">
                                    <i class="fas fa-bell fa-fw"></i>
                                    <!-- Counter - Notifications -->
                                    @php
                                        $unreadCount = \App\Models\AdminNotification::where('is_read', false)->count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="badge-counter">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                                    @endif
                                </div>
                            </a>
                            <!-- Dropdown - Notifications -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow-lg animated--grow-in"
                                aria-labelledby="notificationsDropdown">
                                <h6 class="dropdown-header">
                                    <i class="fas fa-bell mr-2"></i>Notifications Center
                                </h6>
                                @php
                                    $recentNotifications = \App\Models\AdminNotification::with('registrationRequest')
                                        ->orderBy('created_at', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                @forelse($recentNotifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center {{ $notification->is_read ? '' : 'bg-light' }}" 
                                       href="{{ $notification->registration_request_id ? route('registration.requests.show', $notification->registration_request_id) : route('notifications.index') }}">
                                        <div class="mr-3">
                                            <div class="icon-circle">
                                                <i class="fas fa-user-plus text-white"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="small text-muted mb-1">
                                                <i class="far fa-clock mr-1"></i>{{ $notification->created_at->diffForHumans() }}
                                            </div>
                                            <span class="{{ $notification->is_read ? 'text-muted' : 'font-weight-bold text-dark' }}">
                                                {{ Str::limit($notification->message, 50) }}
                                            </span>
                                        </div>
                                    </a>
                                @empty
                                    <a class="dropdown-item text-center small text-gray-500" href="#">
                                        <i class="fas fa-inbox mr-2"></i>No notifications
                                    </a>
                                @endforelse
                                <a class="dropdown-item text-center small font-weight-bold text-primary" href="{{ route('notifications.index') }}">
                                    <i class="fas fa-arrow-right mr-2"></i>Show All Notifications
                                </a>
                            </div>
                        </li>
                        @endif

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link p-0" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="user-profile-wrapper">
                                    <span class="user-name-text d-none d-lg-inline">{{ Auth::user()->name }}</span>
                                    <img class="img-profile rounded-circle"
                                        src="{{ Auth::user()->image==null ?  asset('images/default.png') : asset('images/'.Auth::user()->image) }}"
                                        alt="{{ Auth::user()->name }}">
                                </div>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow-lg animated--grow-in user-menu"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('adminProfile')}}">
                                    <i class="fas fa-user fa-fw mr-3 text-gray-400"></i>
                                    <span>Profile</span>
                                </a>

                                <a class="dropdown-item" href="{{ route('changePasswordView')}}">
                                    <i class="fas fa-key fa-fw mr-3 text-gray-400"></i>
                                    <span>Change Password</span>
                                </a>

                                <div class="dropdown-divider"></div>
                                
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-fw mr-3 text-danger"></i>
                                    <span class="text-danger">Logout</span>
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white py-2 shadow-sm ">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Click "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>

    @yield('sweet-alert')
    @include('sweetalert::alert')
    <script>
        function loadFile(event){
            var reader=new FileReader();
            reader.onload=function(){
                var output=document.getElementById('output');
                output.src=reader.result
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    @yield('script-js')
</html>
