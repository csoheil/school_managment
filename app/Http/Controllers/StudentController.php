<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Attendance;
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
     * Display the student dashboard.
     */
    public function index()
    {
        $classes = auth()->user()->classes;
        return view('student.dashboard', compact('classes'));
    }

    /**
     * View classes enrolled by the student.
     */
    public function viewClasses()
    {
        $classes = auth()->user()->classes;
        return view('student.classes', compact('classes'));
    }

    /**
     * View weekly schedule for student's classes.
     */
    public function viewSchedule()
    {
        $schedules = Schedule::whereIn('class_id', auth()->user()->classes->pluck('id'))->get();
        return view('student.schedule', compact('schedules'));
    }

    /**
     * View student's report card.
     */
    public function viewReportCard()
    {
        $grades = Grade::where('user_id', auth()->id())->with('subject')->get();
        return view('student.report_card', compact('grades'));
    }

    /**
     * View student's attendance.
     */
    public function viewAttendance()
    {
        $attendances = Attendance::where('user_id', auth()->id())->with('class')->get();
        return view('student.attendance', compact('attendances'));
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
