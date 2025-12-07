<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ $schoolName ?? 'SMPN 4 Purwakarta' }}</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-600 via-purple-500 to-indigo-600 animate-gradient relative overflow-hidden">
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-300/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-indigo-300/10 rounded-full blur-3xl animate-float" style="animation-delay: 4s;"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ showPassword: false }">
        <div class="w-full max-w-5xl">
            
            <!-- Login Card -->
            <div class="glass-effect rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden border border-white/20">
                
                <div class="grid md:grid-cols-2 gap-0">
                    
                    <!-- Left Side - Branding & Info -->
                    <div class="bg-gradient-to-br from-purple-600 to-indigo-600 px-6 sm:px-8 lg:px-10 py-8 sm:py-10 lg:py-12 text-center relative overflow-hidden flex flex-col justify-center min-h-[400px] sm:min-h-[500px] md:min-h-[600px]">
                        <div class="absolute inset-0 bg-white/5"></div>
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute -top-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-purple-300/20 rounded-full blur-3xl"></div>
                        </div>
                        
                        <div class="relative z-10">
                            <!-- Logo Sekolah -->
                            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 bg-white/20 rounded-2xl sm:rounded-3xl backdrop-blur-sm mb-4 sm:mb-6 animate-float overflow-hidden">
                                @if($schoolLogo)
                                    <img src="{{ asset('storage/' . $schoolLogo) }}" 
                                         alt="Logo {{ $schoolName ?? 'Sekolah' }}" 
                                         class="w-full h-full object-contain p-2 sm:p-3">
                                @else
                                    <i class="fas fa-school text-white text-3xl sm:text-4xl lg:text-5xl"></i>
                                @endif
                            </div>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2 sm:mb-3">{{ $schoolName ?? 'SMPN 4 Purwakarta' }}</h1>
                            <p class="text-sm sm:text-base text-purple-100 mb-6 sm:mb-8 px-4">{{ $appName ?? 'Sistem Informasi Presensi & Penilaian' }}</p>
                            
                            <div class="space-y-3 sm:space-y-4 mt-8 sm:mt-12">
                                <div class="flex items-center gap-3 sm:gap-4 text-white/90 bg-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-sm">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-chart-line text-lg sm:text-2xl"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-sm sm:text-base">Dashboard Analytics</p>
                                        <p class="text-xs sm:text-sm text-purple-100">Monitoring real-time</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 sm:gap-4 text-white/90 bg-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-sm">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-user-graduate text-lg sm:text-2xl"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-sm sm:text-base">Penilaian Digital</p>
                                        <p class="text-xs sm:text-sm text-purple-100">Sistem SAW terintegrasi</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 sm:gap-4 text-white/90 bg-white/10 rounded-xl p-3 sm:p-4 backdrop-blur-sm">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-shield-alt text-lg sm:text-2xl"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-sm sm:text-base">Keamanan Terjamin</p>
                                        <p class="text-xs sm:text-sm text-purple-100">Enkripsi tingkat tinggi</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Side - Login Form -->
                    <div class="px-6 sm:px-8 lg:px-10 py-8 sm:py-10 lg:py-12 flex flex-col justify-center">
                        
                        <div class="mb-6 sm:mb-8">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">Selamat Datang! 👋</h2>
                            <p class="text-sm sm:text-base text-gray-600">Silakan login untuk melanjutkan</p>
                        </div>
                    
                    @if($errors->any())
                    <div class="mb-4 sm:mb-6 bg-red-50 border border-red-200 rounded-xl p-3 sm:p-4 flex items-start gap-2 sm:gap-3 animate-pulse">
                        <i class="fas fa-exclamation-circle text-red-500 mt-0.5 text-sm sm:text-base"></i>
                        <div class="flex-1">
                            <p class="text-red-800 text-xs sm:text-sm font-medium">{{ $errors->first() }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 text-sm sm:text-base">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif
                    
                    @if(session('success'))
                    <div class="mb-4 sm:mb-6 bg-green-50 border border-green-200 rounded-xl p-3 sm:p-4 flex items-start gap-2 sm:gap-3">
                        <i class="fas fa-check-circle text-green-500 mt-0.5 text-sm sm:text-base"></i>
                        <div class="flex-1">
                            <p class="text-green-800 text-xs sm:text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 text-sm sm:text-base">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endif
                    
                    <form action="{{ route('login') }}" method="POST" class="space-y-4 sm:space-y-5">
                        @csrf
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope text-purple-600 mr-1 sm:mr-2"></i>Email
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" 
                                   placeholder="admin@smpn4purwakarta.sch.id"
                                   required 
                                   autofocus>
                            @error('email')
                                <p class="mt-1 text-xs sm:text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-lock text-purple-600 mr-1 sm:mr-2"></i>Password
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 pr-10 sm:pr-12 text-sm sm:text-base border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                                       placeholder="••••••••"
                                       required>
                                <button type="button" 
                                        @click="showPassword = !showPassword"
                                        class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors text-sm sm:text-base">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs sm:text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" 
                                       id="remember" 
                                       name="remember" 
                                       class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500 cursor-pointer">
                                <span class="ml-2 text-xs sm:text-sm text-gray-700 group-hover:text-purple-600 transition-colors">Ingat Saya</span>
                            </label>
                        </div>
                        
                        <!-- Login Button -->
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-semibold py-2.5 sm:py-3 lg:py-3.5 px-4 sm:px-6 text-sm sm:text-base rounded-xl hover:from-purple-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </button>
                    </form>
                    
                    <!-- Footer -->
                    <div class="mt-6 sm:mt-8 text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500">
                            © {{ date('Y') }} {{ $schoolName ?? 'SMPN 4 Purwakarta' }}. All rights reserved.
                        </p>
                    </div>
                    
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>
