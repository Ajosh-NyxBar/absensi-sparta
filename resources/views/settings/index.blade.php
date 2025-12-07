@extends('layouts.modern')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'school' }">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-cog text-white text-xl"></i>
                    </div>
                    Pengaturan Sistem
                </h1>
                <p class="text-gray-600 mt-2">Kelola konfigurasi dan pengaturan aplikasi</p>
                <div class="mt-2 inline-flex items-center gap-2 px-3 py-1.5 bg-purple-50 border border-purple-200 rounded-lg text-sm">
                    <i class="fas fa-globe text-purple-600"></i>
                    <span class="text-purple-700 font-medium">
                        Bahasa Saat Ini: 
                        <strong>{{ app()->getLocale() === 'id' ? 'Indonesia' : 'English' }}</strong>
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('settings.cache.clear') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-yellow-300 text-yellow-700 font-semibold rounded-xl hover:bg-yellow-50 transition-all duration-200 shadow-sm">
                        <i class="fas fa-broom"></i>
                        <span>Bersihkan Cache</span>
                    </button>
                </form>
                <form action="{{ route('settings.backup') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-cyan-300 text-cyan-700 font-semibold rounded-xl hover:bg-cyan-50 transition-all duration-200 shadow-sm">
                        <i class="fas fa-database"></i>
                        <span>Backup Database</span>
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
            <div class="flex overflow-x-auto scrollbar-hide">
                <button @click="activeTab = 'school'" :class="activeTab === 'school' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-600 hover:text-gray-900'" class="px-6 py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-school"></i>
                    <span>Profil Sekolah</span>
                </button>
                <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-600 hover:text-gray-900'" class="px-6 py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-sliders-h"></i>
                    <span>Umum</span>
                </button>
                <button @click="activeTab = 'appearance'" :class="activeTab === 'appearance' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-600 hover:text-gray-900'" class="px-6 py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-palette"></i>
                    <span>Tampilan</span>
                </button>
                <button @click="activeTab = 'notification'" :class="activeTab === 'notification' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-600 hover:text-gray-900'" class="px-6 py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                </button>
                <button @click="activeTab = 'system'" :class="activeTab === 'system' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-600 hover:text-gray-900'" class="px-6 py-4 font-semibold whitespace-nowrap transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-server"></i>
                    <span>Sistem</span>
                </button>
            </div>
        </div>

        <!-- Tabs Content -->
        <div class="p-8">
            
            <!-- School Profile Tab -->
            <div x-show="activeTab === 'school'" x-transition class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-school text-purple-600"></i>
                    Profil Sekolah
                </h3>
                <form action="{{ route('settings.school.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="school_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_name', $schoolSettings->where('key', 'school_name')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NPSN <span class="text-red-500">*</span></label>
                            <input type="text" name="school_npsn" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_npsn', $schoolSettings->where('key', 'school_npsn')->first()->value ?? '') }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                            <textarea name="school_address" rows="2" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>{{ old('school_address', $schoolSettings->where('key', 'school_address')->first()->value ?? '') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Telepon <span class="text-red-500">*</span></label>
                            <input type="text" name="school_phone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_phone', $schoolSettings->where('key', 'school_phone')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="school_email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_email', $schoolSettings->where('key', 'school_email')->first()->value ?? '') }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Website</label>
                            <input type="url" name="school_website" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('school_website', $schoolSettings->where('key', 'school_website')->first()->value ?? '') }}">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Logo Sekolah</label>
                            <input type="file" name="school_logo" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kepala Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="headmaster_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('headmaster_name', $schoolSettings->where('key', 'headmaster_name')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">NIP Kepala Sekolah <span class="text-red-500">*</span></label>
                            <input type="text" name="headmaster_nip" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('headmaster_nip', $schoolSettings->where('key', 'headmaster_nip')->first()->value ?? '') }}" required>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- General Settings Tab -->
            <div x-show="activeTab === 'general'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-purple-600"></i>
                    Pengaturan Umum
                </h3>
                <form action="{{ route('settings.general.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Aplikasi <span class="text-red-500">*</span></label>
                            <input type="text" name="app_name" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('app_name', $generalSettings->where('key', 'app_name')->first()->value ?? '') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Timezone <span class="text-red-500">*</span></label>
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bahasa <span class="text-red-500">*</span></label>
                            <select name="app_language" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentLang = old('app_language', $generalSettings->where('key', 'app_language')->first()->value ?? 'id');
                                @endphp
                                <option value="id" {{ $currentLang == 'id' ? 'selected' : '' }}>Indonesia</option>
                                <option value="en" {{ $currentLang == 'en' ? 'selected' : '' }}>English</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Format Tanggal <span class="text-red-500">*</span></label>
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Format Waktu <span class="text-red-500">*</span></label>
                            <select name="time_format" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentTimeFormat = old('time_format', $generalSettings->where('key', 'time_format')->first()->value ?? 'H:i');
                                @endphp
                                <option value="H:i" {{ $currentTimeFormat == 'H:i' ? 'selected' : '' }}>24 Jam (HH:MM)</option>
                                <option value="h:i A" {{ $currentTimeFormat == 'h:i A' ? 'selected' : '' }}>12 Jam (hh:mm AM/PM)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Appearance Settings Tab -->
            <div x-show="activeTab === 'appearance'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-palette text-purple-600"></i>
                    Pengaturan Tampilan
                </h3>
                <form action="{{ route('settings.appearance.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Tema <span class="text-red-500">*</span></label>
                            <input type="color" name="theme_color" class="w-full h-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('theme_color', $appearanceSettings->where('key', 'theme_color')->first()->value ?? '#667eea') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Sidebar <span class="text-red-500">*</span></label>
                            <select name="sidebar_color" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentSidebar = old('sidebar_color', $appearanceSettings->where('key', 'sidebar_color')->first()->value ?? 'dark');
                                @endphp
                                <option value="dark" {{ $currentSidebar == 'dark' ? 'selected' : '' }}>Dark</option>
                                <option value="light" {{ $currentSidebar == 'light' ? 'selected' : '' }}>Light</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Item per Halaman <span class="text-red-500">*</span></label>
                            <input type="number" name="items_per_page" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('items_per_page', $appearanceSettings->where('key', 'items_per_page')->first()->value ?? 10) }}" 
                                   min="5" max="100" required>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                        <p class="text-blue-800 text-sm">Perubahan warna tema dan sidebar akan diterapkan setelah halaman dimuat ulang.</p>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Notification Settings Tab -->
            <div x-show="activeTab === 'notification'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-bell text-purple-600"></i>
                    Pengaturan Notifikasi
                </h3>
                <form action="{{ route('settings.notification.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Notifikasi <span class="text-red-500">*</span></label>
                            <input type="email" name="notification_email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('notification_email', $notificationSettings->where('key', 'notification_email')->first()->value ?? '') }}" required>
                            <p class="mt-1 text-sm text-gray-500">Email yang akan menerima notifikasi sistem</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_notifications" class="sr-only peer" {{ old('email_notifications', $notificationSettings->where('key', 'email_notifications')->first()->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                        <span class="ml-3 text-sm font-semibold text-gray-900">Aktifkan Notifikasi Email</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">Kirim notifikasi melalui email</p>
                            </div>

                            <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="sms_notifications" class="sr-only peer" {{ old('sms_notifications', $notificationSettings->where('key', 'sms_notifications')->first()->value ?? 'false') === 'true' ? 'checked' : '' }}>
                                        <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                        <span class="ml-3 text-sm font-semibold text-gray-900">Aktifkan Notifikasi SMS</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">Kirim notifikasi melalui SMS (perlu konfigurasi tambahan)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- System Settings Tab -->
            <div x-show="activeTab === 'system'" x-transition class="space-y-6" style="display: none;">
                <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-server text-purple-600"></i>
                    Pengaturan Sistem
                </h3>
                <form action="{{ route('settings.system.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Jadwal Backup <span class="text-red-500">*</span></label>
                            <select name="backup_schedule" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" required>
                                @php
                                    $currentSchedule = old('backup_schedule', $systemSettings->where('key', 'backup_schedule')->first()->value ?? 'daily');
                                @endphp
                                <option value="daily" {{ $currentSchedule == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ $currentSchedule == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ $currentSchedule == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran Maksimal Upload (KB) <span class="text-red-500">*</span></label>
                            <input type="number" name="max_upload_size" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-200" 
                                   value="{{ old('max_upload_size', $systemSettings->where('key', 'max_upload_size')->first()->value ?? 2048) }}" 
                                   min="1024" max="10240" required>
                            <p class="mt-1 text-sm text-gray-500">Ukuran dalam KB (1024 KB = 1 MB)</p>
                        </div>

                        <div class="md:col-span-2">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="maintenance_mode" class="sr-only peer" {{ old('maintenance_mode', $systemSettings->where('key', 'maintenance_mode')->first()->value ?? 'false') === 'true' ? 'checked' : '' }}>
                                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                                            <span class="ml-3 text-sm font-semibold text-gray-900">Mode Maintenance</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-yellow-800 flex items-start gap-1 mt-2">
                                        <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                        <span>Hanya admin yang bisa akses saat maintenance</span>
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="auto_backup" class="sr-only peer" {{ old('auto_backup', $systemSettings->where('key', 'auto_backup')->first()->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                            <div class="relative w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            <span class="ml-3 text-sm font-semibold text-gray-900">Auto Backup Database</span>
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2">Backup otomatis sesuai jadwal</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-yellow-900">Perhatian:</p>
                            <p class="text-yellow-800 text-sm mt-1">Mode maintenance akan menonaktifkan akses untuk semua pengguna kecuali admin.</p>
                        </div>
                    </div>

                    <div class="flex justify-end pt-6 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
