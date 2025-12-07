<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ setting('app_name', 'SIM SMPN 4') }}</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Modern Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #5568d3;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Card hover effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        /* Animated gradient background */
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animated-gradient {
            background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #667eea);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
    </style>
</head>
<body class="h-full bg-gray-100" x-data="{ sidebarOpen: false, userMenuOpen: false }">
    <div class="flex h-full p-2 sm:p-4">
        
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-4 lg:left-4 animated-gradient rounded-2xl shadow-2xl">
            <div class="flex flex-col flex-1 min-h-0">
                <!-- Logo -->
                <div class="flex items-center h-16 flex-shrink-0 px-4 mt-2">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <span class="text-2xl font-bold gradient-text">S</span>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-lg">{{ setting('school_name', 'SMPN 4') }}</h1>
                            <p class="text-white/70 text-xs">School Management</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-home w-5"></i>
                        <span class="ml-3">Dashboard</span>
                    </a>

                    @if(auth()->user()->role->name === 'Admin')
                    <!-- Admin Section -->
                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider">Management</p>
                    </div>

                    <a href="{{ route('users.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('users.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-users w-5"></i>
                        <span class="ml-3">Users</span>
                    </a>

                    <a href="{{ route('teachers.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('teachers.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-chalkboard-teacher w-5"></i>
                        <span class="ml-3">Teachers</span>
                    </a>

                    <a href="{{ route('students.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('students.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-user-graduate w-5"></i>
                        <span class="ml-3">Students</span>
                    </a>

                    <a href="{{ route('subjects.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('subjects.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-book w-5"></i>
                        <span class="ml-3">Subjects</span>
                    </a>

                    <a href="{{ route('classes.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('classes.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-door-open w-5"></i>
                        <span class="ml-3">Classes</span>
                    </a>

                    <a href="{{ route('academic-years.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('academic-years.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span class="ml-3">Academic Years</span>
                    </a>

                    <a href="{{ route('reports.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all {{ request()->routeIs('reports.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-file-download w-5"></i>
                        <span class="ml-3">Reports & Export</span>
                    </a>

                    <a href="{{ route('criteria.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('criteria.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-tasks w-5"></i>
                        <span class="ml-3">SAW Criteria</span>
                    </a>

                    <a href="{{ route('settings.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('settings.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-cog w-5"></i>
                        <span class="ml-3">Settings</span>
                    </a>
                    @endif

                    <!-- Attendance Section -->
                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider">Attendance</p>
                    </div>

                    <a href="{{ route('attendances.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('attendances.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-qrcode w-5"></i>
                        <span class="ml-3">My Attendance</span>
                    </a>

                    @if(auth()->user()->role->name === 'Admin' || auth()->user()->role->name === 'Guru')
                    <!-- Grades Section -->
                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider">Academic</p>
                    </div>

                    <a href="{{ route('grades.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('grades.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-chart-line w-5"></i>
                        <span class="ml-3">Grades</span>
                    </a>
                    @endif

                    @if(auth()->user()->role->name === 'Admin' || auth()->user()->role->name === 'Kepala Sekolah')
                    <!-- SAW Section -->
                    <div class="pt-4">
                        <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider">Assessment</p>
                    </div>

                    <a href="{{ route('saw.students.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('saw.students.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-trophy w-5"></i>
                        <span class="ml-3">Student Ranking</span>
                    </a>

                    <a href="{{ route('saw.teachers.index') }}" 
                       class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all {{ request()->routeIs('saw.teachers.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-award w-5"></i>
                        <span class="ml-3">Teacher Ranking</span>
                    </a>
                    @endif
                </nav>

                <!-- User Profile at Bottom -->
                <div class="flex-shrink-0 p-4 bg-white/10">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/70">{{ auth()->user()->role->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:pl-72 flex flex-col flex-1">
            <!-- Top navbar -->
            <div class="sticky top-0 z-40 flex h-14 sm:h-16 bg-white shadow-sm rounded-xl sm:rounded-2xl mb-2 sm:mb-4 ml-2 mr-2 sm:ml-4 sm:mr-4 mt-2 sm:mt-4">
                <button @click="sidebarOpen = true" class="px-3 sm:px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden">
                    <i class="fas fa-bars text-lg sm:text-xl"></i>
                </button>

                <div class="flex-1 px-2 sm:px-4 flex justify-between items-center">
                    <!-- Search -->
                    <div class="flex-1 flex">
                        <div class="w-full flex md:ml-0">
                            <div class="relative w-full max-w-md">
                                <div class="absolute inset-y-0 left-0 pl-2 sm:pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 text-xs sm:text-sm"></i>
                                </div>
                                <input type="text" 
                                       class="block w-full pl-7 sm:pl-10 pr-2 sm:pr-3 py-1.5 sm:py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-xs sm:text-sm" 
                                       placeholder="Search...">
                            </div>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="ml-2 sm:ml-4 flex items-center space-x-2 sm:space-x-4">
                        <!-- Notifications -->
                        <button class="p-1.5 sm:p-2 text-gray-400 hover:text-gray-500 relative">
                            <i class="fas fa-bell text-base sm:text-xl"></i>
                            <span class="absolute top-0 right-0 block h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-red-400 ring-2 ring-white"></span>
                        </button>

                        <!-- Profile dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 sm:space-x-3 p-1.5 sm:p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                         alt="Profile" 
                                         class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover border-2 border-indigo-200">
                                @else
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-xs sm:text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="hidden md:block text-left">
                                    <p class="text-xs sm:text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
                                    <p class="text-[10px] sm:text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs sm:text-sm hidden sm:block"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-cloak
                                 class="origin-top-right absolute right-0 mt-2 w-44 sm:w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50">
                                <div class="py-1">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user w-4 sm:w-5"></i>
                                        <span class="ml-2 sm:ml-3">Your Profile</span>
                                    </a>
                                    @if(auth()->user()->role->name === 'Admin')
                                    <a href="{{ route('settings.index') }}" class="flex items-center px-3 sm:px-4 py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-cog w-4 sm:w-5"></i>
                                        <span class="ml-2 sm:ml-3">Settings</span>
                                    </a>
                                    @endif
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-3 sm:px-4 py-2 text-xs sm:text-sm text-red-700 hover:bg-red-50">
                                            <i class="fas fa-sign-out-alt w-4 sm:w-5"></i>
                                            <span class="ml-2 sm:ml-3">Sign out</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto bg-transparent">
                <div class="py-0 px-2 sm:px-4 lg:px-0">
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-4 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-3">
                                <i class="fas fa-times text-green-600 hover:text-green-800"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl p-4 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-red-900">{{ session('error') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-3">
                                <i class="fas fa-times text-red-600 hover:text-red-800"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @if(session('warning'))
                    <div class="mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 rounded-xl p-4 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-600 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-yellow-900">{{ session('warning') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-3">
                                <i class="fas fa-times text-yellow-600 hover:text-yellow-800"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @if(session('info'))
                    <div class="mb-6 bg-gradient-to-r from-blue-50 to-cyan-50 border-l-4 border-blue-500 rounded-xl p-4 shadow-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-blue-900">{{ session('info') }}</p>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-3">
                                <i class="fas fa-times text-blue-600 hover:text-blue-800"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-cloak
         class="fixed inset-0 flex z-40 lg:hidden">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
        <div class="relative flex-1 flex flex-col max-w-xs w-full animated-gradient">
            <!-- Close button -->
            <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <i class="fas fa-times text-white text-xl"></i>
                </button>
            </div>
            <!-- Mobile nav content (same as desktop) -->
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
