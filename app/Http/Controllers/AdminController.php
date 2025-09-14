<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for admin-related actions.
 */
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'students' => User::role('student')->count(),
            'teachers' => User::role('teacher')->count(),
            'classes' => ClassModel::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Register a new student or teacher.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'avatar' => $request->file('avatar') ? $request->file('avatar')->store('avatars', 'public') : null,
        ]);

        $user->assignRole($request->role);
        return redirect()->route('admin.dashboard')->with('success', 'User registered successfully.');
    }

    /**
     * Create a new class.
     */
    public function createClass(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        ClassModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Class created successfully.');
    }

    /**
     * Create a weekly schedule.
     */
    public function createSchedule(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        Schedule::create([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Schedule created successfully.');
    }

    /**
     * Generate a report card for a student.
     */
    public function generateReportCard($studentId)
    {
        $grades = Grade::where('user_id', $studentId)->with('subject')->get();
        return view('admin.report_card', compact('grades'));
    }
}
