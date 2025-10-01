<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Class as SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controller for managing assignments.
 */
class AssignmentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:teacher|student']);
    }

    /**
     * Display a list of assignments.
     */
    public function index()
    {
        if (auth()->user()->hasRole('teacher')) {
            $assignments = Assignment::where('teacher_id', auth()->id())->get();
        } else {
            $assignments = Assignment::whereIn('class_id', auth()->user()->classes->pluck('id'))->get();
        }
        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form to create a new assignment.
     */
    public function create()
    {
        $this->middleware('role:teacher');
        $classes = SchoolClass::where('teacher_id', auth()->id())->get();
        return view('assignments.create', compact('classes'));
    }

    /**
     * Store a new assignment.
     */
    public function store(Request $request)
    {
        $this->middleware('role:teacher');
        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10000', // Max 10MB
            'due_date' => 'required|date|after:now',
        ]);

        $filePath = $request->file('file')->store('assignments', 'public');

        Assignment::create([
            'title' => $request->title,
            'class_id' => $request->class_id,
            'teacher_id' => auth()->id(),
            'file_path' => $filePath,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Download an assignment file.
     */
    public function download($id)
    {
        $assignment = Assignment::findOrFail($id);
        return Storage::disk('public')->download($assignment->file_path);
    }
}
