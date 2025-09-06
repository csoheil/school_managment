<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for student-related actions.
 */
class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:student']);
    }

    /**
     * Display the student dashboard with grades and attendance.
     */
    public function index()
    {
        $grades = Grade::where('user_id', auth()->id())->with('subject')->get();
        $attendances = Attendance::where('user_id', auth()->id())->with('class')->get();
        return view('student.dashboard', compact('grades', 'attendances'));
    }

    /**
     * Update student's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return redirect()->back()->with('success', 'Avatar updated successfully.');
    }
}
