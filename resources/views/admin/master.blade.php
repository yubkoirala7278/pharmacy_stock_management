<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pharmacy Stock Management') }}</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon-32x32.png') }}" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <!-- Theme CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/header-colors.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/mysticstyle.css') }}">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- FontAwesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('custom.css') }}">
    @yield('header-content')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ asset('img/logo.png') }}" class="logo-slogan" alt="logo icon">
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i></div>
            </div>
            <ul class="metismenu" id="menu">
                <li class="">
                    <a href="{{ route('home') }}">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li class="menu-label">Inventory Management</li>
                <li class="">
                    <a href="{{ route('medicines.index') }}">
                        <div class="parent-icon"><i class="fas fa-pills"></i></div>
                        <div class="menu-title">Medicines</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('categories.index') }}">
                        <div class="parent-icon"><i class="fas fa-folder"></i></div>
                        <div class="menu-title">Categories</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('suppliers.index') }}">
                        <div class="parent-icon"><i class="fas fa-truck"></i></div>
                        <div class="menu-title">Suppliers</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('purchases.index') }}">
                        <div class="parent-icon"><i class="fas fa-shopping-cart"></i></div>
                        <div class="menu-title">Purchases</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('sales.index') }}">
                        <div class="parent-icon"><i class="fas fa-cash-register"></i></div>
                        <div class="menu-title">Sales</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('payments.index') }}">
                        <div class="parent-icon"><i class="fas fa-money-bill"></i></div>
                        <div class="menu-title">Payments</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('stock_adjustments.index') }}">
                        <div class="parent-icon"><i class="fas fa-boxes"></i></div>
                        <div class="menu-title">Stock Adjustments</div>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('users.index') }}">
                        <div class="parent-icon"><i class="fas fa-users"></i></div>
                        <div class="menu-title">Users</div>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item dark-mode d-sm-flex">
                                <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="wallet-holder">
                        <div class="user-box dropdown px-3">
                            @auth
                                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('img/avatars/Asset 20.png') }}" class="user-img" alt="user avatar">
                                    <div class="user-info">
                                        <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                                        <p class="designattion mb-0">{{ ucfirst(Auth::user()->role) }}</p>
                                        <i class="bx bx-chevron-down"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <i class="bx bx-user fs-5"></i><span>Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center text-danger" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="bx bx-log-out-circle"></i><span>Logout</span>
                                        </a>
                                        <form id="logout-form" action="" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <a class="nav-link" href="">Login</a>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- Page Content -->
        {{-- <div class="page-wrapper"> --}}
        @yield('content')
        @yield('modal')
        {{-- </div> --}}
        <!-- Overlay -->
        <div class="overlay toggle-icon"></div>
        <!-- Back to Top -->
        <a href="javascript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!-- Footer -->
        <footer class="page-footer">
            <p class="mb-0">Copyright © {{ date('Y') }}. All rights reserved.</p>
        </footer>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- Plugins -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Setup CSRF for AJAX -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(function() {
            $('[data-bs-toggle="popover"]').popover({
                trigger: "hover focus"
            });
        });
    </script>
    @stack('script')
</body>

</html>
