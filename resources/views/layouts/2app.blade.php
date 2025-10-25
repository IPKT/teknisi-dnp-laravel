<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Teknisi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons (Bootstrap Icons) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: #adb5bd;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .navbar {
            margin-left: 250px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center mb-4"><i class="bi bi-gear"></i> Teknisi</h4>
        <a href="{{ route('peralatan.index') }}"><i class="bi bi-tools me-2"></i> Data Peralatan</a>
        <a href="{{ route('pemeliharaan.index') }}"><i class="bi bi-map me-2"></i> Pemeliharaan</a>
        <a href="#"><i class="bi bi-person-lines-fill me-2"></i> PIC</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <span class="navbar-brand ms-3">Dashboard Teknisi</span>
            <div class="d-flex align-items-center me-3">
                @auth
                    <div class="dropdown me-2">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->nama_lengkap ?? Auth::user()->user }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="bi bi-person"></i> Profil</a></li>
                            @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('register.create') }}"><i class="bi bi-person-plus"></i> Tambah User</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth

                <button class="btn btn-outline-secondary btn-sm" onclick="location.reload()">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </button>
            </div>
        </div>
    </nav>



    <!-- Main Content -->
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
