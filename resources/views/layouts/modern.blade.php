<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            width: 4px;
            height: 4px;
        }
        @media (min-width: 768px) {
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        @media (min-width: 768px) {
            .card-hover:hover {
                transform: translateY(-4px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            }
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

        /* Mobile bottom safe area */
        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom, 0);
        }

        /* Touch-friendly tap highlight */
        .tap-highlight {
            -webkit-tap-highlight-color: rgba(102, 126, 234, 0.2);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Better mobile input styling */
        input, select, textarea {
            font-size: 16px !important;
        }

        /* Navigation active indicator */
        .nav-item {
            position: relative;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: white;
            border-radius: 0 4px 4px 0;
        }

        /* Hide scrollbar but keep functionality */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
            overflow-y: auto;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        
        /* Sidebar navigation scroll - MUST WORK */
        .sidebar-nav-scroll {
            max-height: calc(100vh - 200px);
            overflow-y: scroll !important;
            overflow-x: hidden !important;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.4) rgba(255,255,255,0.1);
        }
        .sidebar-nav-scroll::-webkit-scrollbar {
            width: 6px !important;
            display: block !important;
        }
        .sidebar-nav-scroll::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 10px;
        }
        .sidebar-nav-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4) !important;
            border-radius: 10px;
        }
        .sidebar-nav-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.6) !important;
        }
    </style>
</head>
<body class="bg-gray-100 antialiased" x-data="{ sidebarOpen: false }">
    <!-- Desktop Sidebar - Fixed -->
    <aside class="hidden lg:block fixed z-50 w-64 top-4 left-4 bottom-4">
        <div class="h-full flex flex-col animated-gradient rounded-2xl shadow-2xl overflow-hidden">
            <!-- Logo -->
            <div class="h-[72px] px-4 flex items-center flex-shrink-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center mr-3 shadow-lg transform hover:scale-105 transition-transform">
                        <span class="text-2xl font-bold gradient-text">S</span>
                    </div>
                    <div>
                        <h1 class="text-white font-bold text-lg truncate max-w-[140px]">{{ setting('school_name', 'SMPN 4') }}</h1>
                        <p class="text-white/70 text-xs">School Management</p>
                    </div>
                </div>
            </div>

            <!-- Navigation - Scrollable -->
            <div class="flex-1 overflow-hidden">
                <nav class="sidebar-nav-scroll px-3 py-4 space-y-1 h-full">
                    @include('layouts.partials.sidebar-nav')
                </nav>
            </div>

            <!-- User Profile at Bottom -->
            <div class="p-4 bg-black/10 flex-shrink-0">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center overflow-hidden">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <i class="fas fa-user text-white"></i>
                        @endif
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/70 truncate">{{ auth()->user()->role->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-cloak
         class="fixed inset-0 z-50 lg:hidden"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="sidebarOpen = false"></div>
            
            <!-- Sidebar Panel -->
            <div class="fixed inset-y-0 left-0 w-[280px] max-w-[85vw] animated-gradient shadow-2xl safe-bottom sidebar-inner"
                 x-show="sidebarOpen"
                 x-transition:enter="transform transition-transform ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition-transform ease-in duration-200"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full">
                
                <!-- Mobile Header -->
                <div class="h-16 px-4 bg-black/10 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-9 h-9 bg-white rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <span class="text-xl font-bold gradient-text">S</span>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-base truncate max-w-[150px]">{{ setting('school_name', 'SMPN 4') }}</h1>
                            <p class="text-white/70 text-xs">School Management</p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="p-2 text-white/80 hover:text-white rounded-lg hover:bg-white/10 transition-colors tap-highlight">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Mobile Navigation - Scrollable -->
                <nav class="sidebar-nav-scroll px-3 py-4 space-y-1">
                    @include('layouts.partials.sidebar-nav')
                </nav>

                <!-- Mobile User Profile -->
                <div class="p-4 bg-black/10 safe-bottom">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center overflow-hidden">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <i class="fas fa-user text-white"></i>
                            @endif
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/70 truncate">{{ auth()->user()->role->name }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="p-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-colors tap-highlight">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Main Content Area -->
    <div class="lg:pl-72 min-h-screen">
        
        <!-- Top Navbar -->
        <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-lg shadow-sm mx-2 sm:mx-4 mt-2 sm:mt-4 rounded-xl sm:rounded-2xl border border-gray-100/50">
            <div class="flex items-center justify-between h-14 sm:h-16 px-3 sm:px-4">
                
                <!-- Left: Mobile menu button -->
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-1 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors tap-highlight">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>

                <!-- Right: Actions -->
                <div class="flex items-center space-x-1 sm:space-x-3 ml-2">
                    
                    <!-- Semester Switcher -->
                    @php
                        $activeSemester = $activeSemester ?? \App\Models\AcademicYear::where('is_active', true)->first();
                        $allSemesters = $allSemesters ?? \App\Models\AcademicYear::orderByDesc('year')->orderByDesc('semester')->get();
                    @endphp
                    <div class="relative" x-data="{ semesterOpen: false }">
                        <button @click="semesterOpen = !semesterOpen" class="flex items-center space-x-1.5 px-2.5 py-1.5 text-gray-600 hover:text-gray-800 hover:bg-indigo-50 rounded-lg transition-colors tap-highlight border border-gray-200 hover:border-indigo-300">
                            <i class="fas fa-calendar-alt text-indigo-500 text-sm"></i>
                            <span class="hidden sm:inline text-xs font-semibold truncate max-w-[160px]">
                                {{ $activeSemester ? $activeSemester->year . ' ' . $activeSemester->semester : '-' }}
                            </span>
                            <span class="sm:hidden text-xs font-semibold">
                                {{ $activeSemester ? Str::substr($activeSemester->year, 2, 2) . '/' . Str::substr($activeSemester->year, 5, 2) : '-' }}
                            </span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                        </button>

                        <div x-show="semesterOpen" @click.away="semesterOpen = false" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="origin-top-right absolute right-0 mt-2 w-64 rounded-xl shadow-lg bg-white ring-1 ring-black/5 z-50 overflow-hidden">
                            <div class="px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-500">
                                <p class="text-xs font-bold text-white">Semester</p>
                            </div>
                            <div class="max-h-60 overflow-y-auto py-1">
                                @foreach($allSemesters as $sem)
                                <a href="{{ route('semester.switch', $sem->id) }}" 
                                   class="flex items-center justify-between px-4 py-2.5 text-sm {{ $activeSemester && $activeSemester->id === $sem->id ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors tap-highlight">
                                    <div>
                                        <p class="font-medium">{{ $sem->year }} {{ $sem->semester }}</p>
                                        <p class="text-xs {{ $activeSemester && $activeSemester->id === $sem->id ? 'text-indigo-500' : 'text-gray-400' }}">
                                            {{ $sem->start_date ? \Carbon\Carbon::parse($sem->start_date)->format('d M Y') : '' }}
                                            {{ $sem->end_date ? '- ' . \Carbon\Carbon::parse($sem->end_date)->format('d M Y') : '' }}
                                        </p>
                                    </div>
                                    @if($activeSemester && $activeSemester->id === $sem->id)
                                    <i class="fas fa-check text-indigo-600 ml-2"></i>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ langOpen: false }">
                        <button @click="langOpen = !langOpen" class="flex items-center space-x-1 p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors tap-highlight">
                            <span class="text-lg">{{ app()->getLocale() === 'id' ? '🇮🇩' : '🇬🇧' }}</span>
                            <span class="hidden sm:inline text-sm font-medium">{{ app()->getLocale() === 'id' ? 'ID' : 'EN' }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- Language Dropdown -->
                        <div x-show="langOpen" 
                             @click.away="langOpen = false"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="origin-top-right absolute right-0 mt-2 w-40 rounded-xl shadow-lg bg-white ring-1 ring-black/5 z-50 overflow-hidden">
                        <div class="py-1">
                            <a href="{{ route('language.switch', 'id') }}" 
                               class="flex items-center px-4 py-2.5 text-sm {{ app()->getLocale() === 'id' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors tap-highlight">
                                <span class="text-lg mr-3">🇮🇩</span>
                                <div>
                                    <p class="font-medium">Indonesia</p>
                                    <p class="text-xs {{ app()->getLocale() === 'id' ? 'text-indigo-500' : 'text-gray-400' }}">Bahasa Indonesia</p>
                                </div>
                                @if(app()->getLocale() === 'id')
                                <i class="fas fa-check text-indigo-600 ml-auto"></i>
                                @endif
                            </a>
                            <a href="{{ route('language.switch', 'en') }}" 
                               class="flex items-center px-4 py-2.5 text-sm {{ app()->getLocale() === 'en' ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50' }} transition-colors tap-highlight">
                                <span class="text-lg mr-3">🇬🇧</span>
                                <div>
                                    <p class="font-medium">English</p>
                                    <p class="text-xs {{ app()->getLocale() === 'en' ? 'text-indigo-500' : 'text-gray-400' }}">English</p>
                                </div>
                                @if(app()->getLocale() === 'en')
                                <i class="fas fa-check text-indigo-600 ml-auto"></i>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications -->
                <div class="relative" x-data="notificationDropdown()" x-init="fetchNotifications()">
                    <button @click="open = !open" class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors tap-highlight">
                        <i class="fas fa-bell text-lg"></i>
                        <span x-show="unreadCount > 0" 
                              x-text="unreadCount > 9 ? '9+' : unreadCount"
                              class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 text-[10px] font-bold bg-red-500 text-white rounded-full flex items-center justify-center ring-2 ring-white">
                        </span>
                    </button>
                    
                    <!-- Notification Dropdown -->
                    <div x-show="open" 
                         @click.away="open = false"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-80 sm:w-96 rounded-xl shadow-lg bg-white ring-1 ring-black/5 z-50 overflow-hidden">
                                
                                <!-- Header -->
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 flex items-center justify-between">
                                    <h3 class="text-white font-semibold flex items-center gap-2">
                                        <i class="fas fa-bell"></i>
                                        {{ __('notifications.title') }}
                                    </h3>
                                    <button @click="showMarkAllModal = true" 
                                            x-show="unreadCount > 0"
                                            class="text-white/80 hover:text-white text-xs font-medium">
                                        {{ __('notifications.mark_all_read') }}
                                    </button>
                                </div>
                                
                                <!-- Notification List -->
                                <div class="max-h-[350px] overflow-y-auto">
                                    <template x-if="notifications.length === 0">
                                        <div class="px-4 py-8 text-center text-gray-500">
                                            <i class="fas fa-bell-slash text-3xl mb-2 text-gray-300"></i>
                                            <p class="text-sm">{{ __('notifications.no_notifications') }}</p>
                                        </div>
                                    </template>
                                    
                                    <template x-for="notification in notifications" :key="notification.id">
                                        <div :class="notification.is_read ? 'bg-white' : 'bg-indigo-50'" 
                                             class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors cursor-pointer"
                                             @click="handleNotificationClick(notification)">
                                            <div class="flex items-start gap-3">
                                                <div :class="notification.type_color || 'bg-blue-100 text-blue-600'" 
                                                     class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i :class="'fas ' + notification.icon"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900" x-text="notification.title"></p>
                                                    <p class="text-xs text-gray-600 mt-0.5 line-clamp-2" x-text="notification.message"></p>
                                                    <p class="text-xs text-gray-400 mt-1" x-text="formatTime(notification.created_at)"></p>
                                                </div>
                                                <button @click.stop="deleteNotification(notification.id)" 
                                                        class="text-gray-400 hover:text-red-500 p-1">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Footer -->
                                <div class="px-4 py-3 bg-gray-50 border-t border-gray-100">
                                    <a href="{{ route('notifications.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center justify-center gap-1">
                                        {{ __('notifications.view_all') }}
                                        <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Mark All Read Modal -->
                            <div x-show="showMarkAllModal"
                                 x-cloak
                                 class="fixed inset-0 z-[100] overflow-y-auto"
                                 role="dialog"
                                 aria-modal="true">
                                <!-- Backdrop with blur -->
                                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                                     x-show="showMarkAllModal"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     @click="showMarkAllModal = false">
                                </div>
                                
                                <!-- Modal Panel -->
                                <div class="flex min-h-full items-center justify-center p-4">
                                    <div x-show="showMarkAllModal"
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                         class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all w-full max-w-md"
                                         @click.away="showMarkAllModal = false">
                                        
                                        <!-- Modal Header with Gradient -->
                                        <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 px-6 pt-8 pb-6">
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm ring-4 ring-white/30">
                                                <i class="fas fa-check-double text-white text-2xl"></i>
                                            </div>
                                        </div>
                                        
                                        <!-- Modal Body -->
                                        <div class="px-6 py-5 text-center">
                                            <h3 class="text-xl font-bold text-gray-900">
                                                {{ __('notifications.confirm_mark_all_title') }}
                                            </h3>
                                            <p class="mt-2 text-sm text-gray-500">
                                                {{ __('notifications.confirm_mark_all_message') }}
                                            </p>
                                        </div>
                                        
                                        <!-- Modal Footer -->
                                        <div class="px-6 pb-6 flex gap-3">
                                            <button @click="showMarkAllModal = false"
                                                    type="button"
                                                    class="flex-1 rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                                                {{ __('general.cancel') }}
                                            </button>
                                            <button @click="confirmMarkAllAsRead()"
                                                    type="button"
                                                    class="flex-1 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                                                <i class="fas fa-check mr-2"></i>
                                                {{ __('notifications.confirm_button') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-100 transition-colors tap-highlight">
                                @if(auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Profile" class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-100">
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center ring-2 ring-indigo-100">
                                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div class="hidden sm:block text-left">
                                    <p class="text-sm font-medium text-gray-700 truncate max-w-[100px]">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->role->name }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-gray-400 text-xs hidden sm:block"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black/5 divide-y divide-gray-100 z-50">
                                <div class="p-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors tap-highlight">
                                        <i class="fas fa-user w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ __('general.my_profile') }}</span>
                                    </a>
                                    @if(auth()->user()->role->name === 'Admin')
                                    <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors tap-highlight">
                                        <i class="fas fa-cog w-5 text-gray-400"></i>
                                        <span class="ml-2">{{ __('menu.settings') }}</span>
                                    </a>
                                    @endif
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors tap-highlight">
                                            <i class="fas fa-sign-out-alt w-5"></i>
                                            <span class="ml-2">{{ __('general.logout') }}</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

        <!-- Page Content -->
        <main class="px-2 sm:px-4 py-4 sm:py-6 pb-8">
            <!-- Flash Messages -->
            @if(session('success'))
            <div class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-xl p-3 sm:p-4 shadow-sm" 
                 x-data="{ show: true }" 
                 x-show="show"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="ml-3 flex-1 min-w-0">
                        <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="flex-shrink-0 ml-2 p-1 text-green-600 hover:text-green-800 rounded transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 sm:mb-6 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-500 rounded-xl p-3 sm:p-4 shadow-sm"
         x-data="{ show: true }" 
         x-show="show"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-600 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-medium text-red-900">{{ session('error') }}</p>
            </div>
            <button @click="show = false" class="flex-shrink-0 ml-2 p-1 text-red-600 hover:text-red-800 rounded transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="mb-4 sm:mb-6 bg-gradient-to-r from-yellow-50 to-amber-50 border-l-4 border-yellow-500 rounded-xl p-3 sm:p-4 shadow-sm"
         x-data="{ show: true }" 
         x-show="show"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-yellow-600 text-lg sm:text-xl"></i>
            </div>
            <div class="ml-3 flex-1 min-w-0">
                <p class="text-sm font-medium text-yellow-900">{{ session('warning') }}</p>
            </div>
            <button @click="show = false" class="flex-shrink-0 ml-2 p-1 text-yellow-600 hover:text-yellow-800 rounded transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="py-4 px-4 text-center text-xs sm:text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} {{ setting('school_name', 'SMPN 4 Purwakarta') }}. All rights reserved.</p>
        </footer>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Notification Functions -->
    <script>
        function notificationDropdown() {
            return {
                open: false,
                showMarkAllModal: false,
                notifications: [],
                unreadCount: 0,
                
                async fetchNotifications() {
                    try {
                        const response = await fetch('{{ route("notifications.api.index") }}');
                        const data = await response.json();
                        this.notifications = data.notifications;
                        this.unreadCount = data.unread_count;
                    } catch (error) {
                        console.error('Error fetching notifications:', error);
                    }
                },
                
                async markAsRead(id) {
                    try {
                        await fetch(`/api/notifications/${id}/read`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        this.fetchNotifications();
                    } catch (error) {
                        console.error('Error marking as read:', error);
                    }
                },
                
                async markAllAsRead() {
                    try {
                        await fetch('{{ route("notifications.api.mark-all-read") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        this.fetchNotifications();
                    } catch (error) {
                        console.error('Error marking all as read:', error);
                    }
                },
                
                async confirmMarkAllAsRead() {
                    await this.markAllAsRead();
                    this.showMarkAllModal = false;
                },
                
                async deleteNotification(id) {
                    try {
                        await fetch(`/api/notifications/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        this.fetchNotifications();
                    } catch (error) {
                        console.error('Error deleting notification:', error);
                    }
                },
                
                handleNotificationClick(notification) {
                    if (!notification.is_read) {
                        this.markAsRead(notification.id);
                    }
                    if (notification.link) {
                        window.location.href = notification.link;
                    }
                },
                
                formatTime(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diff = Math.floor((now - date) / 1000);
                    
                    if (diff < 60) return '{{ __("notifications.just_now") }}';
                    if (diff < 3600) return Math.floor(diff / 60) + ' {{ __("notifications.minutes_ago") }}';
                    if (diff < 86400) return Math.floor(diff / 3600) + ' {{ __("notifications.hours_ago") }}';
                    if (diff < 604800) return Math.floor(diff / 86400) + ' {{ __("notifications.days_ago") }}';
                    
                    return date.toLocaleDateString('{{ app()->getLocale() === "id" ? "id-ID" : "en-US" }}', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });
                }
            }
        }
        
        // Refresh notifications every 30 seconds
        setInterval(() => {
            const dropdown = document.querySelector('[x-data*="notificationDropdown"]');
            if (dropdown && dropdown.__x) {
                dropdown.__x.$data.fetchNotifications();
            }
        }, 30000);
    </script>

    @stack('scripts')
</body>
</html>
