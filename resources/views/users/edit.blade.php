@extends('layouts.modern')

@section('title', __('users.edit_user'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-indigo-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                        {{ __('users.edit_user') }}
                    </h1>
                    <p class="text-gray-600 flex items-center gap-2">
                        <i class="fas fa-user-edit"></i>
                        {{ __('users.edit_subtitle') }} - {{ $user->name }}
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('users.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-sm border border-gray-200">
                        <i class="fas fa-arrow-left"></i>
                        <span>{{ __('general.back') }}</span>
                    </a>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-circle text-2xl"></i>
                    <h3 class="font-bold">{{ __('general.error_occurred') }}</h3>
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
                            <span>{{ __('users.account_info') }}</span>
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('users.full_name') }} <span class="text-red-500">*</span>
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
                                    {{ __('general.email') }} <span class="text-red-500">*</span>
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
                                    {{ __('users.role') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="role_id" 
                                        name="role_id"
                                        required
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('role_id') border-red-500 @enderror">
                                    <option value="">{{ __('users.select_role_option') }}</option>
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
                            <span>{{ __('users.change_password') }}</span>
                        </h2>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800 font-medium flex items-center gap-2">
                                <i class="fas fa-info-circle"></i>
                                {{ __('users.password_optional_note') }}
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('users.password') }}
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       placeholder="{{ __('users.min_characters', ['count' => 6]) }}"
                                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    {{ __('users.confirm_password') }}
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="{{ __('users.repeat_password') }}"
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
                            <span>{{ __('users.tips_info') }}</span>
                        </h3>
                        <div class="space-y-2 text-sm text-indigo-700">
                            <div class="flex items-start gap-2">
                                <i class="fas fa-calendar text-indigo-600 mt-0.5"></i>
                                <div>
                                    <strong>{{ __('general.created_at') }}:</strong><br>
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <i class="fas fa-clock text-indigo-600 mt-0.5"></i>
                                <div>
                                    <strong>{{ __('general.updated_at') }}:</strong><br>
                                    {{ $user->updated_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl shadow-lg p-6 border border-purple-200">
                        <h3 class="font-bold text-purple-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-lightbulb"></i>
                            <span>{{ __('users.tips_title') }}</span>
                        </h3>
                        <ul class="space-y-2 text-sm text-purple-700">
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>{{ __('users.tips.use_valid_email') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>{{ __('users.tips.choose_role_wisely') }}</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <i class="fas fa-check-circle text-purple-600 mt-0.5"></i>
                                <span>{{ __('users.tips.secure_password') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-indigo-100 space-y-3">
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl font-medium">
                            <i class="fas fa-save"></i>
                            <span>{{ __('users.update_user') }}</span>
                        </button>
                        
                        <a href="{{ route('users.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition-all duration-200 shadow-md border border-gray-200 font-medium">
                            <i class="fas fa-times"></i>
                            <span>{{ __('users.cancel') }}</span>
                        </a>
                    </div>

                </div>
            </div>
        </form>

    </div>
</div>
@endsection
