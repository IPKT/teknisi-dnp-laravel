<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Teknisi DNP</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets') }}/images/Logo-BMKG-square.png" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/fontawesome.css">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style-preset.css">
    <!-- Icons (Bootstrap Icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tambahkan jQuery dari CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/mycostum_css.css">
    {{-- styling table pemeliharaan --}}
    <style>
        @media (max-width: 768px) {

            th.text-wa,
            td.text-wa {
                min-width: 200px;
                /* or 200px if needed */
                /* white-space: nowrap; */

            }

            th.catatan-col,
            td.catatan-col {
                min-width: 150px;
            }

            th.rekomendasi-col {
                min-width: 250px;
            }

            textarea.text-wa {
                font-size: 10px;
            }
        }
    </style>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar @if (!Auth::check()) pc-sidebar-hide @endif">
        <div class="navbar-wrapper">
            <div class="m-header">
                <div class="d-flex justify-content-between align-items-center my-3">
                    <img src="{{ asset('assets') }}/images/Logo-BMKG-square.png" class="img-fluid" alt="logo"
                        width="40px">
                    <h4 class="mt-2 ms-3">TEKNISI DNP</h4>
                </div>
            </div>

            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="{{ route('home') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-home"></i></span>
                            <span class="pc-mtext">HOME</span>
                        </a>
                    </li>
                    {{-- <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"><i
                                    class="ti ti-wave-saw-tool"></i></span><span class="pc-mtext"> Peralatan</span><span
                                class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('peralatan.index') }}">ALL</a></li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('peralatan.jenis', 'Seismometer') }}">Seismometer</a></li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('peralatan.jenis', 'Intensitymeter Realshake') }}">Intensitymeter
                                    Realshake</a></li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('peralatan.jenis', 'Accelero Non Colocated') }}">Accelero Non
                                    Colocated</a></li>
                            <li class="pc-item"><a class="pc-link"  href="{{ route('peralatan.jenis', 'Intensitymeter Reis') }}">Intensitymeter Reis</a></li>
                            <li class="pc-item"><a class="pc-link"  href="{{ route('peralatan.jenis', 'WRS') }}">WRS</a></li>
                        </ul>
                    </li> --}}
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"><i
                                    class="ti ti-wave-saw-tool"></i></span><span class="pc-mtext"> Peralatan</span><span
                                class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        <ul class="pc-submenu">
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('peralatan.index') }}">ALL Aloptama</a>
                            </li>
                            @foreach ($jenisAloptamaMenu as $item)
                                <li class="pc-item">
                                    <a class="pc-link" href="{{ route('peralatan.aloptama', $item->jenis) }}">
                                        {{ $item->jenis }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">Non Aloptama<span class="pc-arrow"><i
                                            data-feather="chevron-right"></i></span></a>
                                <ul class="pc-submenu">
                                    @foreach ($jenisNonAloptamaMenu as $item)
                                        <li class="pc-item">
                                            <a class="pc-link"
                                                href="{{ route('peralatan.non_aloptama', $item->jenis) }}">
                                                {{ $item->jenis }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="pc-item">
          <a href="{{ route('peralatan.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-wave-saw-tool"></i></span>
            <span class="pc-mtext">Peralatan</span>
          </a>
        </li> --}}
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-tool"></i></span>
                            <span class="pc-mtext">Pemeliharaan</span><span class="pc-arrow"><i
                                    data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('pemeliharaan.index') }}">ALL Aloptama</a>
                            </li>
                            @foreach ($jenisAloptamaMenu as $item)
                                <li class="pc-item">
                                    <a class="pc-link" href="{{ route('pemeliharaan.jenis_alat', $item->jenis) }}">
                                        {{ $item->jenis }}
                                    </a>
                                </li>
                            @endforeach
                            <li class="pc-item pc-hasmenu">
                                <a href="#!" class="pc-link">Non Aloptama<span class="pc-arrow"><i
                                            data-feather="chevron-right"></i></span></a>
                                <ul class="pc-submenu">
                                    @foreach ($jenisNonAloptamaMenu as $item)
                                        <li class="pc-item">
                                            <a class="pc-link"
                                                href="{{ route('pemeliharaan.jenis_alat', $item->jenis) }}">
                                                {{ $item->jenis }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="pc-item">
                        <a href="{{ route('hardware.index') }}" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-tool"></i></span>
                            <span class="pc-mtext">Hardware</span>
                        </a>
                    </li> --}}
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link"><span class="pc-micon"><i
                                    class="ti ti ti-building-store"></i></span><span class="pc-mtext"> Suku Cadang
                            </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                        {{-- <a href="#!" class="pc-link">
            <span class="pc-micon"><i class="ti ti-building-store"></i></span>
            <span class="pc-mtext">Suku Cadang Gudang</span><span class="pc-arrow"></span>
          </a> --}}
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('hardware.index') }}">ALL</a>
                            </li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('hardware.status', 'ready') }}">Ready</a></li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('hardware.status', 'terpasang') }}">Terpasang</a></li>
                            <li class="pc-item"><a class="pc-link"
                                    href="{{ route('hardware.status', 'terkirim') }}">Terkirim</a></li>
                            <li class="pc-item pc-hasmenu"><a class="pc-link pc-hasmenu" href="#!">Tahun
                                    Pengadaan</a>
                                <ul class="pc-submenu">
                                    {{-- <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan', 'All') }}">All</a></li> --}}
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan', '2023') }}">2023</a></li>
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan', '2024') }}">2024</a></li>
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan', '2025') }}">2025</a></li>
                                </ul>
                            </li>
                            <li class="pc-item pc-hasmenu"><a class="pc-link pc-hasmenu" href="#!">Rekap
                                    Pengadaan DNP</a>
                                <ul class="pc-submenu">
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan_dnp', 'All') }}">All</a></li>
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan_dnp', '2023') }}">2023</a></li>
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan_dnp', '2024') }}">2024</a></li>
                                    <li class="pc-item"><a class="pc-link"
                                            href="{{ route('hardware.rekap_pengadaan_dnp', '2025') }}">2025</a></li>
                                </ul>
                            </li>


                        </ul>
                    </li>


                    {{-- <li class="pc-item pc-caption">
          <label>UI Components</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="../elements/bc_typography.html" class="pc-link">
            <span class="pc-micon"><i class="ti ti-typography"></i></span>
            <span class="pc-mtext">Typography</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../elements/bc_color.html" class="pc-link">
            <span class="pc-micon"><i class="ti ti-color-swatch"></i></span>
            <span class="pc-mtext">Color</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../elements/icon-tabler.html" class="pc-link">
            <span class="pc-micon"><i class="ti ti-plant-2"></i></span>
            <span class="pc-mtext">Icons</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
          <a href="../pages/login.html" class="pc-link">
            <span class="pc-micon"><i class="ti ti-lock"></i></span>
            <span class="pc-mtext">Login</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="../pages/register.html" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Register</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Other</label>
          <i class="ti ti-brand-chrome"></i>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span class="pc-mtext">Menu
              levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li class="pc-item pc-hasmenu">
              <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
              <ul class="pc-submenu">
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                <li class="pc-item pc-hasmenu">
                  <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                  <ul class="pc-submenu">
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                    <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li class="pc-item">
          <a href="../other/sample-page.html" class="pc-link">
            <span class="pc-micon"><i class="ti ti-brand-chrome"></i></span>
            <span class="pc-mtext">Sample page</span>
          </a>
        </li> --}}
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    @if (Auth::check())
                        <li class="dropdown pc-h-item header-user-profile">
                            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                                aria-expanded="false">
                                <i class="bi bi-person-circle mx-2"></i>
                                <span>{{ Auth::user()->nama_lengkap ?? Auth::user()->user }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                <div class="dropdown-header">
                                    <div class="d-flex mb-1">
                                        <div class="flex-shrink-0">
                                            <img src="{{ asset('assets') }}/images/user/avatar-2.jpg"
                                                alt="user-image" class="user-avtar wid-35">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ Auth::user()->nama_lengkap }}</h6>
                                            <span>{{ Auth::user()->role ?? 'Guest' }}</span>
                                        </div>
                                        {{-- <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a> --}}
                                    </div>
                                </div>
                                <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="drp-t1" data-bs-toggle="tab"
                                            data-bs-target="#drp-tab-1" type="button" role="tab"
                                            aria-controls="drp-tab-1" aria-selected="true"><i class="ti ti-user"></i>
                                            Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="drp-t2" data-bs-toggle="tab"
                                            data-bs-target="#drp-tab-2" type="button" role="tab"
                                            aria-controls="drp-tab-2" aria-selected="false"><i
                                                class="ti ti-settings"></i> Setting</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="mysrpTabContent">
                                    <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel"
                                        aria-labelledby="drp-t1" tabindex="0">
                                        {{-- <a href="#!" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Edit Profile</span>
            </a> --}}
                                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                                            <i class="ti ti-user"></i>
                                            <span>View Profile</span>
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                            <a href="{{ route('register.create') }}" class="dropdown-item">
                                                <i class="ti ti-user-plus"></i>
                                                <span>Tambah User</span>
                                            </a>
                                        @endif
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item">
                                                <i class="ti ti-power"></i>
                                                <span>Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="drp-tab-2" role="tabpanel"
                                        aria-labelledby="drp-t2" tabindex="0">
                                        {{-- <a href="#!" class="dropdown-item">
              <i class="ti ti-help"></i>
              <span>Support</span>
            </a> --}}
                                        <a href="{{ route('profile.akun_setting') }}" class="dropdown-item">
                                            <i class="ti ti-settings"></i>
                                            <span>Account Settings</span>
                                        </a>
                                        @if (auth()->user()->role == 'admin')
                                            <a href="{{ route('manage.user') }}" class="dropdown-item">
                                                <i class="ti ti-user"></i>
                                                <span>Manage Users</span>
                                            </a>
                                             <a href="{{ route('user.activity.recap') }}" class="dropdown-item">
                                                <i class="ti ti-user"></i>
                                                <span>User Activity Recap</span>
                                            </a>
                                        @endif
                                        {{-- <a href="#!" class="dropdown-item">
              <i class="ti ti-lock"></i>
              <span>Privacy Center</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-messages"></i>
              <span>Feedback</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-list"></i>
              <span>History</span>
            </a> --}}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container">
        <div class="pc-content">
            <!-- [ breadcrumb ] start -->
            {{-- <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">{{$title}}</h5>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            @yield('content')

            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                {{-- <div class="col-sm my-1">
          <p class="m-0"
            >Mantis &#9829; crafted by Team <a href="https://themeforest.net/user/codedthemes" target="_blank">Codedthemes</a> Distributed by <a href="https://themewagon.com/">ThemeWagon</a>.</p
          >
        </div>
        <div class="col-auto my-1">
          <ul class="list-inline footer-link mb-0">
            <li class="list-inline-item"><a href="../index.html">Home</a></li>
          </ul>
        </div> --}}
                <p class="text-center"><i class="ti ti-copyright"></i>Stasiun Geofisika Denpasar</p>
            </div>
        </div>
    </footer>
    <!-- Required Js -->
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>
    <!-- Data Table -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        layout_change('light');
    </script>
    <script>
        change_box_container('false');
    </script>
    <script>
        layout_rtl_change('false');
    </script>
    <script>
        preset_change("preset-1");
    </script>
    <script>
        font_change("Public-Sans");
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}



    @yield('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Select ALL table elements on the page
            const allTables = document.querySelectorAll('table');

            // Define the media query for small screens (less than 768px - typically mobile)
            const mediaQuery = window.matchMedia('(max-width: 767.98px)');

            function toggleTableClass(mediaQuery) {
                if (mediaQuery.matches) {
                    // Screen is small: Add your custom "small" class
                    allTables.forEach(table => {
                        table.classList.add('small');
                    });
                    // ...
                } else {
                    // Screen is larger: Remove your custom "small" class
                    allTables.forEach(table => {
                        table.classList.remove('small');
                    });
                    // ...
                }
            }
            // Run the check initially and whenever the screen size changes
            toggleTableClass(mediaQuery);
            mediaQuery.addListener(toggleTableClass);
        });
    </script>
</body>
<!-- [Body] end -->

</html>
