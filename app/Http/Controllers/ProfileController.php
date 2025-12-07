<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Handle photo removal
        if ($request->input('remove_photo') == '1') {
            if ($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo))) {
                unlink(public_path('storage/' . $user->profile_photo));
            }
            $validated['profile_photo'] = null;
        }
        // Handle photo upload
        elseif ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo))) {
                unlink(public_path('storage/' . $user->profile_photo));
            }

            // Store new photo
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $validated['profile_photo'] = $photoPath;
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password berhasil diperbarui!');
    }
}
