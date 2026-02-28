{{-- Dashboard --}}
<a href="{{ route('dashboard') }}" 
   class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('dashboard') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
    <i class="fas fa-home w-5 text-center mr-3"></i>
    <span>{{ __('menu.dashboard') }}</span>
</a>

{{-- Data Master Section --}}
<div class="pt-4">
    <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">{{ __('menu.master_data') }}</p>
    
    {{-- Tahun Ajaran --}}
    @if(auth()->user()->role->name === 'Admin')
    <a href="{{ route('academic-years.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('academic-years.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-calendar-alt w-5 text-center mr-3"></i>
        <span>{{ __('menu.academic_year') }}</span>
    </a>
    @endif

    {{-- Kelas --}}
    <a href="{{ route('classes.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('classes.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-school w-5 text-center mr-3"></i>
        <span>{{ __('menu.classes') }}</span>
    </a>

    {{-- Mata Pelajaran --}}
    <a href="{{ route('subjects.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('subjects.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-book w-5 text-center mr-3"></i>
        <span>{{ __('menu.subjects') }}</span>
    </a>
</div>

{{-- Data Pengguna Section --}}
<div class="pt-4">
    <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">{{ __('menu.user_data') }}</p>
    
    {{-- Siswa --}}
    <a href="{{ route('students.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('students.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-user-graduate w-5 text-center mr-3"></i>
        <span>{{ __('menu.students') }}</span>
    </a>

    {{-- Guru --}}
    <a href="{{ route('teachers.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('teachers.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-chalkboard-teacher w-5 text-center mr-3"></i>
        <span>{{ __('menu.teachers') }}</span>
    </a>

    {{-- Users --}}
    @if(auth()->user()->role->name === 'Admin')
    <a href="{{ route('users.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('users.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-users w-5 text-center mr-3"></i>
        <span>{{ __('menu.users') }}</span>
    </a>
    @endif
</div>

{{-- Akademik Section --}}
<div class="pt-4">
    <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">{{ __('menu.academic') }}</p>
    
    {{-- Nilai --}}
    <a href="{{ route('grades.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('grades.*') && !request()->routeIs('grades.report-card') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-chart-line w-5 text-center mr-3"></i>
        <span>{{ __('menu.grades') }}</span>
    </a>

    {{-- Presensi --}}
    <a href="{{ route('attendances.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('attendances.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-clipboard-check w-5 text-center mr-3"></i>
        <span>{{ __('menu.attendance') }}</span>
    </a>

    {{-- Scan Presensi (Guru Only) --}}
    @if(auth()->user()->role->name === 'Guru')
    <a href="{{ route('kiosk.scanner') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('kiosk.scanner') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-qrcode w-5 text-center mr-3"></i>
        <span>Scan Presensi</span>
    </a>
    @endif
</div>

{{-- Penilaian SAW Section --}}
<div class="pt-4">
    <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">{{ __('menu.saw_assessment') }}</p>
    
    {{-- Kriteria Penilaian --}}
    @if(auth()->user()->role->name === 'Admin')
    <a href="{{ route('criteria.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('criteria.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-list-check w-5 text-center mr-3"></i>
        <span>{{ __('menu.criteria') }}</span>
    </a>
    @endif

    {{-- Penilaian Siswa --}}
    @if(in_array(auth()->user()->role->name, ['Admin', 'Kepala Sekolah']))
    <a href="{{ route('saw.students.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('saw.students.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-user-graduate w-5 text-center mr-3"></i>
        <span>{{ __('menu.student_ranking') }}</span>
    </a>
    @endif

    {{-- Penilaian Guru --}}
    @if(in_array(auth()->user()->role->name, ['Admin', 'Kepala Sekolah']))
    <a href="{{ route('saw.teachers.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('saw.teachers.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-chalkboard-teacher w-5 text-center mr-3"></i>
        <span>{{ __('menu.teacher_ranking') }}</span>
    </a>
    @endif
</div>

{{-- Laporan Section --}}
<div class="pt-4">
    <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">{{ __('menu.reports') }}</p>
    
    {{-- Export Data --}}
    @if(auth()->user()->role->name === 'Admin')
    <a href="{{ route('reports.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('reports.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-file-export w-5 text-center mr-3"></i>
        <span>{{ __('menu.export_data') }}</span>
    </a>
    @endif
</div>

{{-- Pengaturan Section --}}
@if(auth()->user()->role->name === 'Admin')
<div class="pt-4 pb-2">
    <p class="px-3 text-xs font-semibold text-white/50 uppercase tracking-wider mb-2">{{ __('menu.settings') }}</p>
    
    <a href="{{ route('settings.index') }}" 
       class="nav-item flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 tap-highlight {{ request()->routeIs('settings.*') ? 'active bg-white/20 text-white shadow-lg' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
        <i class="fas fa-cog w-5 text-center mr-3"></i>
        <span>{{ __('menu.system_settings') }}</span>
    </a>
</div>
@endif
