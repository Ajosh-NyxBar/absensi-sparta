@extends('layouts.modern')

@section('title', __('users.add_user'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-user-plus text-white text-xl"></i>
                    </div>
                    {{ __('users.add_user') }}
                </h1>
                <p class="text-gray-600 mt-2">{{ __('users.create_subtitle') }}</p>
            </div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200 shadow-sm">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('general.back') }}</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-edit text-green-600"></i>
                        {{ __('users.add_form_title') }}
                    </h2>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('users.full_name') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('name') border-red-500 @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="{{ __('users.enter_full_name') }}"
                                       required>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('general.email') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('email') border-red-500 @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="user@example.com"
                                       required>
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Role -->
                        <div>
                            <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('users.role') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tag text-gray-400"></i>
                                </div>
                                <select class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('role_id') border-red-500 @enderror appearance-none" 
                                        id="role_id" 
                                        name="role_id" 
                                        required>
                                    <option value="">{{ __('users.select_role_option') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                            @error('role_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('users.password') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="{{ __('users.min_characters', ['count' => 6]) }}"
                                       required>
                            </div>
                            <p class="mt-2 text-sm text-gray-600 flex items-center gap-1">
                                <i class="fas fa-info-circle"></i>
                                {{ __('users.min_characters', ['count' => 6]) }}
                            </p>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ __('users.confirm_password') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" 
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="{{ __('users.repeat_password') }}"
                                       required>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save"></i>
                                <span>{{ __('users.save_user') }}</span>
                            </button>
                            <a href="{{ route('users.index') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition-all duration-200">
                                <i class="fas fa-times"></i>
                                <span>{{ __('users.cancel') }}</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white sticky top-24">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold">{{ __('users.tips_info') }}</h3>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <p class="font-semibold mb-2">{{ __('users.role') }}:</p>
                        <ul class="space-y-2">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-white/80 mt-1"></i>
                                <span><strong>Admin:</strong> {{ __('users.role_info.admin') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-white/80 mt-1"></i>
                                <span><strong>{{ __('users.principal') }}:</strong> {{ __('users.role_info.principal') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-white/80 mt-1"></i>
                                <span><strong>{{ __('users.teacher') }}:</strong> {{ __('users.role_info.teacher') }}</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="pt-4 border-t border-white/20">
                        <p class="font-semibold mb-2">{{ __('users.tips_title') }}:</p>
                        <ul class="space-y-2 text-sm text-white/90">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-lightbulb text-yellow-300 mt-0.5"></i>
                                <span>{{ __('users.tips.use_valid_email') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-lightbulb text-yellow-300 mt-0.5"></i>
                                <span>{{ __('users.tips.secure_password') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-lightbulb text-yellow-300 mt-0.5"></i>
                                <span>{{ __('users.tips.choose_role_wisely') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
