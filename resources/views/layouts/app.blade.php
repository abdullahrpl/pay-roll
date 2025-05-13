<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Penggajian Karyawan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3b7ddd;
            --sidebar-bg: #222e3c;
            --sidebar-text: #e9ecef;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fb;
            color: #495057;
        }

        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            position: fixed;
            width: 250px;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s;
            box-shadow: 0 0 15px rgba(0, 0, 0, .1);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-link {
            display: block;
            padding: 0.75rem 1.25rem;
            color: rgba(255, 255, 255, .7);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            color: white;
            background-color: rgba(255, 255, 255, .1);
            border-left-color: var(--primary-color);
        }

        .content {
            margin-left: 250px;
            transition: all 0.3s;
            padding: 2rem;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .05);
        }

        .card {
            box-shadow: 0 0 10px rgba(0, 0, 0, .05);
            border-radius: 0.5rem;
            border: none;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .table {
            --bs-table-striped-bg: rgba(0, 0, 0, .02);
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .profile-image {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-menu {
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            border: none;
        }

        .alert {
            margin-bottom: 1.5rem;
        }

        .stats-card {
            border-left: 4px solid var(--primary-color);
            transition: transform .3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card i {
            font-size: 2rem;
            color: var(--primary-color);
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .content {
                margin-left: 0;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .content.active {
                margin-left: 250px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    @auth
        <div class="wrapper">
            <!-- Sidebar -->
            <nav id="sidebar" class="sidebar">
                <div class="sidebar-header">
                    <a href="#" class="sidebar-brand">
                        <i class="fas fa-money-bill-wave mr-2"></i> SiGajian
                    </a>
                </div>

                <div class="sidebar-nav">
                    @if (auth()->user()->role === 'admin')
                        <!-- Admin Menu -->
                        <a href="{{ route('admin.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="{{ route('employees.index') }}"
                            class="sidebar-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Karyawan
                        </a>
                        <a href="{{ route('attendances.index') }}"
                            class="sidebar-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-check"></i> Absensi
                        </a>
                        <a href="{{ route('salaries.index') }}"
                            class="sidebar-link {{ request()->routeIs('salaries.*') ? 'active' : '' }}">
                            <i class="fas fa-money-check-alt"></i> Penggajian
                        </a>
                    @else
                        <!-- Employee Menu -->
                        <a href="{{ route('employee.dashboard') }}"
                            class="sidebar-link {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="{{ route('employee.attendance.history') }}"
                            class="sidebar-link {{ request()->routeIs('employee.attendance.*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list"></i> Riwayat Absensi
                        </a>
                        <a href="{{ route('employee.salary.history') }}"
                            class="sidebar-link {{ request()->routeIs('employee.salary.*') ? 'active' : '' }}">
                            <i class="fas fa-receipt"></i> Slip Gaji
                        </a>
                    @endif
                </div>
            </nav>

            <!-- Content -->
            <div class="content">
                <nav class="navbar navbar-expand navbar-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-sm btn-primary d-md-none">
                            <i class="fas fa-bars"></i>
                        </button>

                        <div class="ms-auto d-flex align-items-center">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                        alt="Profile" class="profile-image me-2">
                                    <span>{{ auth()->user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Flash Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </div>
        </div>
    @else
        <div>
            @yield('content')
        </div>
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.toggle('active');
                    document.querySelector('.content').classList.toggle('active');
                });
            }

            // Auto-close alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
