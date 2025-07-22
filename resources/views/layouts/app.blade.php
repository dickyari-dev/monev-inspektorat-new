<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>


    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="{{ asset('assets/vendor/perfect-scrollbar.css') }}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/app.rtl.css') }}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{ asset('assets/css/vendor-material-icons.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-material-icons.rtl.css') }}" rel="stylesheet">

    <!-- Font Awesome FREE Icons -->
    <link type="text/css" href="{{ asset('assets/css/vendor-fontawesome-free.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-fontawesome-free.rtl.css') }}" rel="stylesheet">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-133433427-1"></script>
    <!-- Flatpickr -->
    <link type="text/css" href="{{ asset('assets/css/vendor-flatpickr.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-flatpickr.rtl.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-flatpickr-airbnb.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('assets/css/vendor-flatpickr-airbnb.rtl.css') }}" rel="stylesheet">

    <!-- Vector Maps -->
    <link type="text/css" href="{{ asset('assets/vendor/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body class="layout-default">


    <!-- Header Layout -->
    <div class="mdk-header-layout js-mdk-header-layout">

        <div id="header" class="mdk-header js-mdk-header m-0" data-fixed>
            <div class="mdk-header__content">

                <div class="navbar navbar-expand-sm navbar-main navbar-dark bg-dark  pr-0" id="navbar" data-primary>
                    <div class="container-fluid p-0">

                        <!-- Navbar toggler -->

                        <button class="navbar-toggler navbar-toggler-right d-block d-lg-none" type="button"
                            data-toggle="sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Navbar Brand -->
                        <a href="#" class="navbar-brand ">

                            {{-- <img class="navbar-brand-icon" src="{{ asset('assets/images/logo.png') }}" width="100"
                                alt="Stack"> --}}
                            <span>SI Monitoring Desa</span>
                        </a>



                        <ul class="nav navbar-nav d-none d-sm-flex border-left navbar-height align-items-center">
                            <li class="nav-item dropdown">
                                <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                    data-caret="false">
                                    <span class="mr-1 d-flex-inline">
                                        <span class="text-light">{{ Auth::user()->name }}</span>
                                    </span>
                                    <img src="{{ asset('assets/images/avatar.webp') }}" class="rounded-circle"
                                        width="32" alt="Frontted">
                                </a>
                                <div id="account_menu" class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item-text dropdown-item-text--lh">
                                        <div><strong>{{ Auth::user()->name }}</strong></div>
                                        <div class="text-muted">{{ Auth::user()->email }}</div>
                                    </div>
                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" href="{{ route('logout') }}"><i
                                            class="material-icons">exit_to_app</i>
                                        Logout</a>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

            </div>
        </div>

        <!-- // END Header -->

        <!-- Header Layout Content -->
        <div class="mdk-header-layout__content">

            <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px">
                <div class="mdk-drawer-layout__content page">
                    @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @yield('content')

                </div>
                <!-- // END drawer-layout__content -->

                <div class="mdk-drawer  js-mdk-drawer" id="default-drawer" data-align="start">
                    <div class="mdk-drawer__content">
                        @if (Auth::user()->role == 'inspektorat')
                        <div class="sidebar sidebar-light sidebar-left sidebar-p-t" data-perfect-scrollbar>
                            <div class="sidebar-heading">Menu</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{{ route('inspektorat.dashboard') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">home</i>
                                        <span class="sidebar-menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <li
                                    class="sidebar-menu-item @if (Route::current()->getName() == 'inspektorat.struktur-inspektorat') active @endif">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#dashboards_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dvr</i>
                                        <span class="sidebar-menu-text">Data Master</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse show " id="dashboards_menu">
                                        <li
                                            class="sidebar-menu-item @if (Route::current()->getName() == 'inspektorat.struktur-inspektorat') active @endif">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.struktur-inspektorat') }}">
                                                <span class="sidebar-menu-text">Struktur Inspektorat</span>
                                            </a>
                                        </li>
                                        <li
                                            class="sidebar-menu-item @if (Route::current()->getName() == 'inspektorat.struktur-kecamatan') active @endif">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.struktur-kecamatan') }}">
                                                <span class="sidebar-menu-text">Struktur Kecamatan</span>
                                            </a>
                                        </li>
                                        <li
                                            class="sidebar-menu-item  @if (Route::current()->getName() == 'inspektorat.struktur-desa') active @endif">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.struktur-desa') }}">
                                                <span class="sidebar-menu-text">Struktur Desa</span>
                                            </a>
                                        </li>
                                        <li
                                            class="sidebar-menu-item  @if (Route::current()->getName() == 'inspektorat.data-petugas') active @endif">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.data-petugas') }}">
                                                <span class="sidebar-menu-text">Data Petugas</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#apps_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">settings</i>
                                        <span class="sidebar-menu-text">Setting Monev</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="apps_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.setting-laporan') }}">
                                                <span class="sidebar-menu-text">Setting Laporan</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.setting-wilayah') }}">
                                                <span class="sidebar-menu-text">Setting Wilayah</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#pages_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">today</i>
                                        <span class="sidebar-menu-text">Jadwal Monev</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="pages_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.waktu-monev') }}">
                                                <span class="sidebar-menu-text">Waktu Monev</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.jadwal-monev') }}">
                                                <span class="sidebar-menu-text">Jadwal Monev</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#layouts_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">print</i>
                                        <span class="sidebar-menu-text">Laporan Monev</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="layouts_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('inspektorat.monitoring-desa') }}">
                                                <span class="sidebar-menu-text">Laporan Monev Desa</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="#">
                                                <span class="sidebar-menu-text">Grafik Monev</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                        @elseif (Auth::user()->role == 'kecamatan')
                        <div class="sidebar sidebar-light sidebar-left sidebar-p-t" data-perfect-scrollbar>
                            <div class="sidebar-heading">Menu</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{{ route('kecamatan.dashboard') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">home</i>
                                        <span class="sidebar-menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#dashboards_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dvr</i>
                                        <span class="sidebar-menu-text">Data Master</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse " id="dashboards_menu">
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('kecamatan.struktur-kecamatan') }}">
                                                <span class="sidebar-menu-text">Struktur Kecamatan</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('kecamatan.struktur-desa') }}">
                                                <span class="sidebar-menu-text">Struktur Desa</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="{{ route('kecamatan.data-petugas') }}">
                                                <span class="sidebar-menu-text">Data Petugas</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{{ route('kecamatan.waktu-monev') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">today</i>
                                        <span class="sidebar-menu-text">Jadwal Monev</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#layouts_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">print</i>
                                        <span class="sidebar-menu-text">Laporan Monev</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="layouts_menu">
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('kecamatan.monitoring-desa') }}">
                                                <span class="sidebar-menu-text">Laporan Monev Desa</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="fluid-dashboard.html">
                                                <span class="sidebar-menu-text">Grafik Monev</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                        @elseif (Auth::user()->role == 'desa')
                        <div class="sidebar sidebar-light sidebar-left sidebar-p-t" data-perfect-scrollbar>
                            <div class="sidebar-heading">Menu</div>
                            <ul class="sidebar-menu">
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{{ route('desa.dashboard') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">home</i>
                                        <span class="sidebar-menu-text">Dashboard</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#dashboards_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">dvr</i>
                                        <span class="sidebar-menu-text">Data Master</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse " id="dashboards_menu">
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button" href="{{ route('desa.struktur-desa') }}">
                                                <span class="sidebar-menu-text">Struktur Desa</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button" href="{{ route('desa.data-petugas') }}">
                                                <span class="sidebar-menu-text">Data Petugas</span>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" href="{{ route('desa.waktu-monev') }}">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">today</i>
                                        <span class="sidebar-menu-text">Jadwal Monev</span>
                                    </a>
                                </li>
                                <li class="sidebar-menu-item">
                                    <a class="sidebar-menu-button" data-toggle="collapse" href="#layouts_menu">
                                        <i class="sidebar-menu-icon sidebar-menu-icon--left material-icons">print</i>
                                        <span class="sidebar-menu-text">Laporan Monev</span>
                                        <span class="ml-auto sidebar-menu-toggle-icon"></span>
                                    </a>
                                    <ul class="sidebar-submenu collapse" id="layouts_menu">
                                        <li class="sidebar-menu-item active">
                                            <a class="sidebar-menu-button"
                                                href="{{ route('desa.monitoring-desa') }}">
                                                <span class="sidebar-menu-text">Laporan Monev Desa</span>
                                            </a>
                                        </li>
                                        <li class="sidebar-menu-item">
                                            <a class="sidebar-menu-button" href="#">
                                                <span class="sidebar-menu-text">Grafik Monev</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- // END drawer-layout -->

        </div>
        <!-- // END header-layout__content -->

    </div>
    <!-- // END header-layout -->


    <!-- jQuery -->
    <script src="{{ asset('assets/vendor/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap.min.js') }}"></script>

    <!-- Perfect Scrollbar -->
    <script src="{{ asset('assets/vendor/perfect-scrollbar.min.js') }}"></script>

    <!-- DOM Factory -->
    <script src="{{ asset('assets/vendor/dom-factory.js') }}"></script>

    <!-- MDK -->
    <script src="{{ asset('assets/vendor/material-design-kit.js') }}"></script>

    <!-- App -->
    <script src="{{ asset('assets/js/toggle-check-all.js') }}"></script>
    <script src="{{ asset('assets/js/check-selected-row.js') }}"></script>
    <script src="{{ asset('assets/js/dropdown.js') }}"></script>
    <script src="{{ asset('assets/js/sidebar-mini.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- App Settings (safe to remove) -->
    <script src="{{ asset('assets/js/app-settings.js') }}"></script>

    <!-- Flatpickr -->
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>

    <!-- Global Settings -->
    <script src="{{ asset('assets/js/settings.js') }}"></script>

    <!-- Moment.js -->
    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment-range.js') }}"></script>

    <!-- Chart.js -->
    <script src="{{ asset('assets/vendor/Chart.min.js') }}"></script>

    <!-- App Charts JS -->
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/chartjs-rounded-bar.js') }}"></script>

    <!-- Chart Samples -->
    <script src="{{ asset('assets/js/page.dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/progress-charts.js') }}"></script>

    <!-- Vector Maps -->
    <script src="{{ asset('assets/vendor/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('assets/js/vector-maps.js') }}"></script>

    @yield('scripts')
</body>

</html>