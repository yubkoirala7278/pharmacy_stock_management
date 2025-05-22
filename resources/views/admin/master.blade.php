<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="img//favicon-32x32.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="css/app.css" rel="stylesheet">
    <link href="css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="css/dark-theme.css" />
    <link rel="stylesheet" href="css/semi-dark.css" />
    <link rel="stylesheet" href="css/header-colors.css" />
    <link rel="stylesheet" href="css/mysticstyle.css">
    <title>Pharmacy Stock Management</title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="img//logo.png" class="logo-slogan" alt="logo icon">
                </div>

                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li class="active">
                    <a href="">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                <li class="menu-label">Customers Management
                <li>
                    <a href="">
                        <div class="parent-icon"><i class="bx bx-user-plus"></i></div>
                        <div class="menu-title">Create Customer</div>
                    </a>
                </li>
                <li>
                    <a href="">
                        <div class="parent-icon"><i class="bx bx-badge-check"></i></div>
                        <div class="menu-title">Active Customers</div>
                    </a>
                </li>
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->
        <!--start header -->
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>
                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item dark-mode d-sm-flex">
                                <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="wallet-holder">
                        <div class="user-box dropdown px-3">
                            <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="img/avatars/Asset 20.png" class="user-img" alt="user avatar">
                                <div class="user-info">
                                    <p class="user-name mb-0">Saruta Dahal</p>
                                    <p class="designattion mb-0">Sr. P - Manager</p>
                                    <i class="bx bx-chevron-down"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item d-flex align-items-center"
                                        href="main-manager-profile.html"><i
                                            class="bx bx-user fs-5"></i><span>Profile</span></a>
                                </li>

                                <li><a class="dropdown-item d-flex align-items-center text-danger" href="javascript:;"
                                        data-bs-toggle="modal" data-bs-target="#logoutModal"><i
                                            class="bx bx-log-out-circle"></i><span>Logout</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">
                @yield('content')
                @yield('modal')
            </div>
        </div>
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2022. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->

    <!-- Confirm Logout Modal  -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Logout ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are you sure you want to logout.</div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary px-5 py-2" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger px-5 py-2">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="js/jquery.min.js"></script>
    <!--app JS-->
    <script src="js/app.js"></script>
    <script>
        $(function() {
            $('[data-bs-toggle="popover"]').popover({
                trigger: "hover focus"
            });
        })
    </script>

    {{-- custom js --}}
    @stack('script')
</body>

</html>
