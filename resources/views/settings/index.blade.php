@extends('layouts.modern')

@section('title', __('settings.page_title'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8" x-data="{ activeTab: 'school' }">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cog text-white text-lg sm:text-xl"></i>
                    </div>
                    {{ __('settings.page_title') }}
                </h1>
                <p class="text-gray-600 mt-2">{{ __('settings.subtitle') }}</p>
                <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 bg-purple-50 border border-purple-200 rounded-lg text-sm">
                    <i class="fas fa-globe text-purple-600"></i>
                    <span class="text-purple-700 font-medium">
                        {{ __('settings.current_language') }}: 
                        <strong>{{ app()->getLocale() === 'id' ? __('general.indonesian') : __('general.english') }}</strong>
                    </span>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <form action="{{ route('settings.cache.clear') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-yellow-300 text-yellow-700 font-semibold rounded-xl hover:bg-yellow-50 transition-all duration-200 shadow-sm">
                        <i class="fas fa-broom"></i>
                        <span>{{ __('settings.clear_cache') }}</span>
                    </button>
                </form>
                <form action="{{ route('settings.backup') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-cyan-300 text-cyan-700 font-semibold rounded-xl hover:bg-cyan-50 transition-all duration-200 shadow-sm">
                        <i class="fas fa-database"></i>
                        <span>{{ __('settings.backup_database') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
        <p class="text-green-800 flex-1">{{ session('success') }}</p>
        <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-exclamation-circle text-red-600 mt-0.5"></i>
        <p class="text-red-800 flex-1">{{ session('error') }}</p>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Settings Card with Tabs -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        <!-- Tabs Header -->
        <div class="border-b border-gray-200 bg-gray-50">
            <div class="flex overflow-x-auto scrollbar-hide -mb-px">
                <button @click="activeTab = 'school'" :class="activeTab === 'school' ? 'border-b-2 border-purple-600 text-purple-600 bg-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'" class="px-4 sm:px-6 py-3 sm:py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-school"></i>
                    <span class="hidden sm:inline">{{ __('settings.school_profile') }}</span>
                    <span class="sm:hidden">Profil</span>
                </button>
                <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'border-b-2 border-purple-600 text-purple-600 bg-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'" class="px-4 sm:px-6 py-3 sm:py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-sliders-h"></i>
                    <span>{{ __('settings.general') }}</span>
                </button>
                <button @click="activeTab = 'appearance'" :class="activeTab === 'appearance' ? 'border-b-2 border-purple-600 text-purple-600 bg-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'" class="px-4 sm:px-6 py-3 sm:py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-palette"></i>
                    <span>{{ __('settings.appearance') }}</span>
                </button>
                <button @click="activeTab = 'notification'" :class="activeTab === 'notification' ? 'border-b-2 border-purple-600 text-purple-600 bg-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'" class="px-4 sm:px-6 py-3 sm:py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-bell"></i>
                    <span class="hidden sm:inline">{{ __('settings.notifications') }}</span>
                    <span class="sm:hidden">Notif</span>
                </button>
                <button @click="activeTab = 'system'" :class="activeTab === 'system' ? 'border-b-2 border-purple-600 text-purple-600 bg-white' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'" class="px-4 sm:px-6 py-3 sm:py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-server"></i>
                    <span>{{ __('settings.system') }}</span>
                </button>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="p-4 sm:p-6 lg:p-8">
            
            <!-- School Profile Tab -->
            <div x-show="activeTab === 'school'" x-transition class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-school text-purple-600"></i>
                    {{ __('settings.school_profile') }}
                </h3>
                <form action="{{ route('settings.school.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="school_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_name', $schoolSettings->where('key', 'school_name')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_npsn') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="school_npsn" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_npsn', $schoolSettings->where('key', 'school_npsn')->first()->value ?? '') }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_address') }} <span class="text-red-500">*</span></label>
                            <textarea name="school_address" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>{{ old('school_address', $schoolSettings->where('key', 'school_address')->first()->value ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_phone') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="school_phone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_phone', $schoolSettings->where('key', 'school_phone')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_email') }} <span class="text-red-500">*</span></label>
                            <input type="email" name="school_email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_email', $schoolSettings->where('key', 'school_email')->first()->value ?? '') }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_website') }}</label>
                            <input type="url" name="school_website" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_website', $schoolSettings->where('key', 'school_website')->first()->value ?? '') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.school_logo') }}</label>
                            <input type="file" name="school_logo" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">{{ __('settings.logo_format') }}</p>
                            @php
                                $logo = $schoolSettings->where('key', 'school_logo')->first()->value ?? null;
                            @endphp
                            @if($logo)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-24 rounded-xl border-2 border-gray-200 shadow-sm">
                            </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.principal_name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="headmaster_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('headmaster_name', $schoolSettings->where('key', 'headmaster_name')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.principal_nip') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="headmaster_nip" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('headmaster_nip', $schoolSettings->where('key', 'headmaster_nip')->first()->value ?? '') }}" required>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>{{ __('settings.save_changes') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- General Settings Tab -->
            <div x-show="activeTab === 'general'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-purple-600"></i>
                    {{ __('settings.general_settings') }}
                </h3>
                <form action="{{ route('settings.general.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.app_name') }} <span class="text-red-500">*</span></label>
                            <input type="text" name="app_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('app_name', $generalSettings->where('key', 'app_name')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.timezone') }} <span class="text-red-500">*</span></label>
                            <select name="app_timezone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentTimezone = old('app_timezone', $generalSettings->where('key', 'app_timezone')->first()->value ?? 'Asia/Jakarta');
                                @endphp
                                <option value="Asia/Jakarta" {{ $currentTimezone == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar" {{ $currentTimezone == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura" {{ $currentTimezone == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.language') }} <span class="text-red-500">*</span></label>
                            <select name="app_language" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentLang = old('app_language', $generalSettings->where('key', 'app_language')->first()->value ?? 'id');
                                @endphp
                                <option value="id" {{ $currentLang == 'id' ? 'selected' : '' }}>Indonesia</option>
                                <option value="en" {{ $currentLang == 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.date_format') }} <span class="text-red-500">*</span></label>
                            <select name="date_format" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentDateFormat = old('date_format', $generalSettings->where('key', 'date_format')->first()->value ?? 'd/m/Y');
                                @endphp
                                <option value="d/m/Y" {{ $currentDateFormat == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="m/d/Y" {{ $currentDateFormat == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="Y-m-d" {{ $currentDateFormat == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.time_format') }} <span class="text-red-500">*</span></label>
                            <select name="time_format" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentTimeFormat = old('time_format', $generalSettings->where('key', 'time_format')->first()->value ?? 'H:i');
                                @endphp
                                <option value="H:i" {{ $currentTimeFormat == 'H:i' ? 'selected' : '' }}>{{ __('settings.24_hour') }}</option>
                                <option value="h:i A" {{ $currentTimeFormat == 'h:i A' ? 'selected' : '' }}>{{ __('settings.12_hour') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>{{ __('settings.save_changes') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Appearance Settings Tab -->
            <div x-show="activeTab === 'appearance'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-palette text-purple-600"></i>
                    {{ __('settings.appearance_settings') }}
                </h3>
                <form action="{{ route('settings.appearance.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.theme_color') }} <span class="text-red-500">*</span></label>
                            <input type="color" name="theme_color" class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('theme_color', $appearanceSettings->where('key', 'theme_color')->first()->value ?? '#667eea') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.sidebar_color') }} <span class="text-red-500">*</span></label>
                            <select name="sidebar_color" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentSidebar = old('sidebar_color', $appearanceSettings->where('key', 'sidebar_color')->first()->value ?? 'dark');
                                @endphp
                                <option value="dark" {{ $currentSidebar == 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="light" {{ $currentSidebar == 'light' ? 'selected' : '' }}>Light</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.items_per_page') }} <span class="text-red-500">*</span></label>
                            <input type="number" name="items_per_page" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('items_per_page', $appearanceSettings->where('key', 'items_per_page')->first()->value ?? 10) }}" 
                                   min="5" max="100" required>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                        <p class="text-blue-800 text-sm">{{ __('settings.appearance_note') }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>{{ __('settings.save_changes') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notification Settings Tab -->
            <div x-show="activeTab === 'notification'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-bell text-purple-600"></i>
                    {{ __('settings.notification_settings') }}
                </h3>
                <form action="{{ route('settings.notification.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.notification_email') }} <span class="text-red-500">*</span></label>
                            <input type="email" name="notification_email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('notification_email', $notificationSettings->where('key', 'notification_email')->first()->value ?? '') }}" required>
                            <p class="mt-1 text-sm text-gray-500">{{ __('settings.notification_email_desc') }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_notifications" class="sr-only peer" {{ old('email_notifications', $notificationSettings->where('key', 'email_notifications')->first()->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                        <span class="ml-3 text-sm font-semibold text-gray-900">{{ __('settings.enable_email_notifications') }}</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">{{ __('settings.send_email_notifications') }}</p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="sms_notifications" class="sr-only peer" {{ old('sms_notifications', $notificationSettings->where('key', 'sms_notifications')->first()->value ?? 'false') === 'true' ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                        <span class="ml-3 text-sm font-semibold text-gray-900">{{ __('settings.enable_sms_notifications') }}</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">{{ __('settings.send_sms_notifications') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>{{ __('settings.save_changes') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- System Settings Tab -->
            <div x-show="activeTab === 'system'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-server text-purple-600"></i>
                    {{ __('settings.system_settings') }}
                </h3>
                <form action="{{ route('settings.system.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.backup_schedule') }} <span class="text-red-500">*</span></label>
                            <select name="backup_schedule" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentSchedule = old('backup_schedule', $systemSettings->where('key', 'backup_schedule')->first()->value ?? 'daily');
                                @endphp
                                <option value="daily" {{ $currentSchedule == 'daily' ? 'selected' : '' }}>{{ __('settings.daily') }}</option>
                                <option value="weekly" {{ $currentSchedule == 'weekly' ? 'selected' : '' }}>{{ __('settings.weekly') }}</option>
                                <option value="monthly" {{ $currentSchedule == 'monthly' ? 'selected' : '' }}>{{ __('settings.monthly') }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('settings.max_upload_size') }} <span class="text-red-500">*</span></label>
                            <input type="number" name="max_upload_size" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('max_upload_size', $systemSettings->where('key', 'max_upload_size')->first()->value ?? 2048) }}" 
                                   min="1024" max="10240" required>
                            <p class="mt-1 text-sm text-gray-500">{{ __('settings.upload_size_desc') }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="maintenance_mode" class="sr-only peer" {{ old('maintenance_mode', $systemSettings->where('key', 'maintenance_mode')->first()->value ?? 'false') === 'true' ? 'checked' : '' }}>
                                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                                            <span class="ml-3 text-sm font-semibold text-gray-900">{{ __('settings.maintenance_mode') }}</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-yellow-800 flex items-start gap-1 mt-2">
                                        <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                        <span>{{ __('settings.maintenance_warning') }}</span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="auto_backup" class="sr-only peer" {{ old('auto_backup', $systemSettings->where('key', 'auto_backup')->first()->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-sm font-semibold text-gray-900">{{ __('settings.auto_backup') }}</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2">{{ __('settings.auto_backup_desc') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-yellow-900">{{ __('settings.attention') }}</p>
                            <p class="text-yellow-800 text-sm mt-1">{{ __('settings.maintenance_note') }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200 mt-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>{{ __('settings.save_changes') }}</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
