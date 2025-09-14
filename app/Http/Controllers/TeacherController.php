<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Subject;
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
        $classes = ClassModel::where('teacher_id', auth()->id())->get();
        return view('teacher.dashboard', compact('classes'));
    }

    /**
     * View classes assigned to the teacher.
     */
    public function viewClasses()
    {
        $classes = ClassModel::where('teacher_id', auth()->id())->get();
        return view('teacher.classes', compact('classes'));
    }

    /**
     * View weekly schedule for teacher's classes.
     */
    public function viewSchedule()
    {
        $schedules = Schedule::whereIn('class_id', auth()->user()->taughtClasses->pluck('id'))->get();
        return view('teacher.schedule', compact('schedules'));
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
     * Create a new exam.
     */
    public function createExam(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'due_date' => 'required|date|after:now',
        ]);

        Exam::create([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'teacher_id' => auth()->id(),
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('teacher.dashboard')->with('success', 'Exam created successfully.');
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

    /**
     * Manage subjects assigned to the teacher.
     */
    public function manageSubjects()
    {
        $subjects = Subject::where('teacher_id', auth()->id())->get();
        return view('teacher.subjects', compact('subjects'));
    }
}
