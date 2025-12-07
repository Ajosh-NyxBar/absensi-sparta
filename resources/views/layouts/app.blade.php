<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Presensi dan Penilaian') - SMPN 4 Purwakarta</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 4px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        
        .navbar {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .card {
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.08);
            border-radius: 10px;
        }
        
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }
        
        /* Hide the text-based navigation (Previous/Next links at top) */
        nav[role="navigation"] > div:first-child {
            display: none !important;
        }
        
        .pagination .page-link {
            border-radius: 8px;
            margin: 0;
            border: none;
            color: #667eea;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            min-width: 40px;
            text-align: center;
            line-height: 1.5;
            transition: all 0.3s ease;
            background: #f8f9fa;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        /* Hide SVG icons in pagination */
        .pagination .page-link svg,
        .pagination svg,
        nav svg {
            display: none !important;
            visibility: hidden !important;
            width: 0 !important;
            height: 0 !important;
        }
        
        .pagination .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            transform: scale(1.05);
        }
        
        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #e9ecef;
            cursor: not-allowed;
            box-shadow: none;
        }
        
        .pagination .page-item.disabled .page-link:hover {
            transform: none;
            background-color: #e9ecef;
        }
        
        /* First and Last page styling */
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            font-weight: 600;
            background: white;
            border: 2px solid #667eea;
        }
        
        .pagination .page-item:first-child .page-link:hover,
        .pagination .page-item:last-child .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar px-0">
                <div class="p-4 text-white">
                    <h5 class="mb-0"><i class="fas fa-school me-2"></i>SMPN 4 Purwakarta</h5>
                    <small>Sistem Presensi & Penilaian</small>
                </div>
                
                <nav class="nav flex-column px-3">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                    
                    @if(Auth::user()->isAdmin())
                        <div class="mt-3 px-3">
                            <small class="text-white-50">DATA MASTER</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="fas fa-users me-2"></i> Manajemen User
                        </a>
                        <a class="nav-link {{ request()->routeIs('teachers.*') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
                            <i class="fas fa-chalkboard-teacher me-2"></i> Data Guru
                        </a>
                        <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                            <i class="fas fa-user-graduate me-2"></i> Data Siswa
                        </a>
                        <a class="nav-link {{ request()->routeIs('subjects.*') ? 'active' : '' }}" href="{{ route('subjects.index') }}">
                            <i class="fas fa-book me-2"></i> Mata Pelajaran
                        </a>
                        <a class="nav-link {{ request()->routeIs('classes.*') ? 'active' : '' }}" href="{{ route('classes.index') }}">
                            <i class="fas fa-door-open me-2"></i> Data Kelas
                        </a>
                        <a class="nav-link {{ request()->routeIs('academic-years.*') ? 'active' : '' }}" href="{{ route('academic-years.index') }}">
                            <i class="fas fa-calendar-alt me-2"></i> Tahun Ajaran
                        </a>
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            <i class="fas fa-file-download me-2"></i> Laporan & Export
                        </a>
                        <a class="nav-link {{ request()->routeIs('criteria.*') ? 'active' : '' }}" href="{{ route('criteria.index') }}">
                            <i class="fas fa-tasks me-2"></i> Kriteria SAW
                        </a>
                        <a class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}" href="{{ route('settings.index') }}">
                            <i class="fas fa-cog me-2"></i> Pengaturan Sistem
                        </a>
                    @endif
                    
                    <div class="mt-3 px-3">
                        <small class="text-white-50">PRESENSI</small>
                    </div>
                    <a class="nav-link {{ request()->routeIs('attendances.*') ? 'active' : '' }}" href="{{ route('attendances.index') }}">
                        <i class="fas fa-clipboard-check me-2"></i> Daftar Presensi
                    </a>
                    
                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <div class="mt-3 px-3">
                            <small class="text-white-50">PENILAIAN</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('grades.*') ? 'active' : '' }}" href="{{ route('grades.index') }}">
                            <i class="fas fa-chart-line me-2"></i> Input Nilai
                        </a>
                    @endif
                    
                    @if(Auth::user()->isAdmin() || Auth::user()->isHeadmaster())
                        <div class="mt-3 px-3">
                            <small class="text-white-50">LAPORAN SAW</small>
                        </div>
                        <a class="nav-link {{ request()->routeIs('saw.students.*') ? 'active' : '' }}" href="{{ route('saw.students.index') }}">
                            <i class="fas fa-trophy me-2"></i> Prestasi Siswa
                        </a>
                        <a class="nav-link {{ request()->routeIs('saw.teachers.*') ? 'active' : '' }}" href="{{ route('saw.teachers.index') }}">
                            <i class="fas fa-award me-2"></i> Prestasi Guru
                        </a>
                    @endif
                </nav>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-10 px-0">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav align-items-center">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle fa-lg me-2"></i>
                                        {{ Auth::user()->name }}
                                        <small class="text-muted d-block">{{ Auth::user()->role->name ?? 'User' }}</small>
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
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <!-- Page Content -->
                <div class="p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#667eea',
            confirmButtonText: '<i class="fas fa-check me-2"></i>OK',
            customClass: {
                confirmButton: 'btn btn-lg px-4'
            },
            buttonsStyling: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    @endif
    
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545',
            confirmButtonText: '<i class="fas fa-times me-2"></i>OK',
            customClass: {
                confirmButton: 'btn btn-lg px-4'
            },
            buttonsStyling: false
        });
    </script>
    @endif
    
    @stack('scripts')
</body>
</html>
