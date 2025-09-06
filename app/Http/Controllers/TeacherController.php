<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Class;
use Illuminate\Http\Request;

/**
 * Controller for teacher-related actions.
 */
class TeacherController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher']);
    }

    /**
     * Display the teacher dashboard with assigned classes.
     */
    public function index()
    {
        $classes = Class::where('teacher_id', auth()->id())->get();
        return view('teacher.dashboard', compact('classes'));
    }

    /**
     * Mark attendance for a student in a class.
     */
    public function markAttendance(Request $request, $classId)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:present,absent,late',
            'date' => 'required|date',
        ]);

        Attendance::create([
            'user_id' => $request->student_id,
            'class_id' => $classId,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Attendance marked successfully.');
    }

    /**
     * Add grade for a student in a subject.
     */
    public function addGrade(Request $request, $classId)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'required|numeric|min:0|max:100',
            'comments' => 'nullable|string|max:500',
        ]);

        Grade::create([
            'user_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'score' => $request->score,
            'comments' => $request->comments,
        ]);

        return redirect()->back()->with('success', 'Grade added successfully.');
    }
}
