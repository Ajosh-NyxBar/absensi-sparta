<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Role;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers
     */
    public function index()
    {
        $teachers = Teacher::with(['user.role', 'teacherSubjects.subject'])->paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created teacher
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:teachers,nip',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education_level' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:100',
        ]);

        // Create user account
        $teacherRole = Role::where('name', 'Guru')->first();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $teacherRole->id,
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teachers', 'public');
        }

        // Create teacher profile
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'nip' => $validated['nip'],
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'photo' => $photoPath,
            'education_level' => $validated['education_level'] ?? null,
            'position' => $validated['position'] ?? null,
            'status' => 'active',
        ]);
        
        // Send notification
        NotificationService::teacherAdded($teacher->name);

        return redirect()->route('teachers.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Display the specified teacher
     */
    public function show(Teacher $teacher)
    {
        $teacher->load('user', 'teacherSubjects.subject', 'teacherSubjects.classRoom');
        return view('teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing the specified teacher
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:teachers,nip,' . $teacher->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'gender' => 'required|in:L,P',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'education_level' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        // Update user account
        $teacher->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teacher->photo) {
                Storage::disk('public')->delete($teacher->photo);
            }
            $validated['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        // Update teacher profile
        $teacher->update($validated);

        return redirect()->route('teachers.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified teacher
     */
    public function destroy(Teacher $teacher)
    {
        // Delete photo if exists
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }

        // Delete user account (will cascade delete teacher)
        $teacher->user->delete();

        return redirect()->route('teachers.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    /**
     * Display a listing of classes taught by the authenticated teacher.
     */
    public function myClasses()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki profil guru.');
        }

        // Get all teacher subjects with relationships
        $teacherSubjects = $teacher->teacherSubjects()
            ->with(['classRoom.students', 'subject'])
            ->get()
            ->groupBy('class_id');

        return view('teachers.my-classes', compact('teacherSubjects', 'teacher'));
    }

    /**
     * Show the form for editing the authenticated teacher's profile.
     */
    public function editProfile()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki profil guru.');
        }

        return view('teachers.edit-profile', compact('teacher'));
    }

    /**
     * Update the authenticated teacher's profile.
     */
    public function updateProfile(Request $request)
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak memiliki profil guru.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:20|unique:teachers,nip,' . $teacher->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:100',
            'gender' => 'nullable|in:L,P',
            'religion' => 'nullable|string|max:50',
            'education_level' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update teacher data
        $teacher->name = $validated['name'];
        $teacher->nip = $validated['nip'];
        $teacher->phone = $validated['phone'] ?? null;
        $teacher->address = $validated['address'] ?? null;
        $teacher->birth_date = $validated['birth_date'] ?? null;
        $teacher->birth_place = $validated['birth_place'] ?? null;
        $teacher->gender = $validated['gender'] ?? null;
        $teacher->religion = $validated['religion'] ?? null;
        $teacher->education_level = $validated['education_level'] ?? null;
        $teacher->major = $validated['major'] ?? null;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($teacher->photo) {
                Storage::delete('public/' . $teacher->photo);
            }

            $path = $request->file('photo')->store('teachers', 'public');
            $teacher->photo = $path;
        }

        $teacher->save();

        // Update user email and password
        $user = Auth::user();
        $user->email = $validated['email'];
        
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return redirect()->route('teachers.edit-profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
