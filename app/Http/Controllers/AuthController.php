<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Setting;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        
        // Get school settings for login page
        $schoolName = Setting::get('school_name', 'SMPN 4 Purwakarta');
        $schoolLogo = Setting::get('school_logo');
        $appName = Setting::get('app_name', 'Sistem Informasi Presensi & Penilaian');
        
        return view('auth.login', compact('schoolName', 'schoolLogo', 'appName'));
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang, ' . Auth::user()->name);
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Show dashboard based on user role
     */
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return app(DashboardController::class)->admin();
        } elseif ($user->isHeadmaster()) {
            return app(DashboardController::class)->headmaster();
        } elseif ($user->isTeacher()) {
            return app(DashboardController::class)->teacher();
        }

        return redirect()->route('login');
    }
}
