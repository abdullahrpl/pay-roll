<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - Sistem Penggajian Karyawan</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/207e8fe02f.js" crossorigin="anonymous"></script>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }

        :root {
            --primary-color: #3b7ddd;
            --sidebar-bg: #2f3b47;
            --sidebar-text: #f4f5f7;
            --navbar-bg: #ffffff;
            --hover-bg: #4e5d6a;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f5f7;
            color: #495057;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 100;
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            font-size: 1.25rem;
            font-weight: bold;
            color: var(--sidebar-text);
            text-decoration: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-link {
            display: block;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar-link i {
            margin-right: 0.5rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background-color: var(--hover-bg);
            color: #fff;
            border-left-color: var(--primary-color);
        }

        /* Content */
        .content {
            margin-left: 250px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        /* Navbar */
        .navbar {
            background-color: var(--navbar-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 0.8rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 110;
        }

        .navbar .navbar-brand {
            font-size: 1.25rem;
            color: #333;
        }

        .navbar .navbar-toggler {
            border: none;
            background-color: var(--primary-color);
        }

        .navbar .navbar-toggler-icon {
            background-color: white;
        }

        .navbar .dropdown-menu {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .profile-image {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
        }

        .stats-card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }

        /* Sidebar hover color */
        .sidebar-link:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .content {
                margin-left: 0;
                padding: 1rem;
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
        <div class="wrapper min-vh-100 d-flex flex-column">
            <!-- Navbar -->
            <nav class="navbar navbar-expand navbar-light fixed-top">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-sm btn-primary d-md-none">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&size=128"
                                    alt="Profile" class="profile-image me-2" />
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

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Main Layout -->
            <div class="d-flex flex-grow-1 pt-5">
                <!-- Sidebar -->
                @include('layouts.sidebar')

                <!-- Page Content -->
                <main class="content flex-fill">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <main>
            @yield('content')
        </main>
    @endauth

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle for mobile
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function () {
                    document.getElementById('sidebar').classList.toggle('active');
                    document.querySelector('.content').classList.toggle('active');
                });
            }

            // Auto close alerts after 5 seconds
            document.querySelectorAll('.alert').forEach(alert => {
                setTimeout(() => {
                    const bsAlert = bootstrap.Alert.getInstance(alert) || new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

    @yield('scripts')
</body>

</html>
