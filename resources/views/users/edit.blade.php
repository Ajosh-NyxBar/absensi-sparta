@extends('layouts.modern')

@section('title', 'Edit User')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-indigo-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        Edit User
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-user-edit"></i>
                        Edit data user {{ $user->name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                    <h3 class="font-bold">Terjadi Kesalahan!</h3>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 ml-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Main Form Section -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Account Information -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-indigo-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span>Informasi Akun</span>
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select id="role_id" 
                                        name="role_id"
                                        required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('role_id') border-red-500 @enderror">
                                    <option value="">Pilih Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-indigo-100">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white">
                                <i class="fas fa-key text-sm"></i>
                            </div>
                            <span>Ubah Password (Opsional)</span>
                        </h2>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800 font-medium flex items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                Kosongkan jika tidak ingin mengubah password
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Minimal 6 karakter"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password baru"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Section -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Info Card -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl shadow-lg p-6 border border-indigo-200">
                        <h3 class="font-bold text-indigo-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            <span>Informasi User</span>
                        </h3>
                        <div class="space-y-2 text-sm text-indigo-700">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-calendar text-indigo-600 mt-0.5"></i>
                                <div>
                                    <strong>Dibuat:</strong><br>
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-clock text-indigo-600 mt-0.5"></i>
                                <div>
                                    <strong>Update Terakhir:</strong><br>
                                    {{ $user->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl shadow-lg p-6 border border-purple-200">
                        <h3 class="font-bold text-purple-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            <span>Tips</span>
                        </h3>
                        <ul class="space-y-2 text-sm text-purple-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Email harus unik untuk setiap user</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Role menentukan akses menu dan fitur</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>Password minimal 6 karakter</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-indigo-100 space-y-3">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                            <i class="fas fa-save"></i>
                            <span>Update User</span>
                        </button>
                        
                        <a href="{{ route('users.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-md border border-gray-200 font-medium">
                            <i class="fas fa-times"></i>
                            <span>Batal</span>
                        </a>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>
@endsection
