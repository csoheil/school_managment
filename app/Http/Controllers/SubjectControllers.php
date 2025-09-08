<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * Controller for managing subjects.
 */
class SubjectController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|teacher']);
    }

    /**
     * Display a list of subjects.
     */
    public function index()
    {
        $subjects = auth()->user()->hasRole('admin')
            ? Subject::all()
            : Subject::where('teacher_id', auth()->id())->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form to create a new subject.
     */
    public function create()
    {
        $this->middleware('role:admin');
        return view('subjects.create');
    }

    /**
     * Store a new subject.
     */
    public function store(Request $request)
    {
        $this->middleware('role:admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Subject::create([
            'name' => $request->name,
            'code' => $request->code,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Show the form to edit a subject.
     */
    public function edit($id)
    {
        $this->middleware('role:admin');
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update a subject.
     */
    public function update(Request $request, $id)
    {
        $this->middleware('role:admin');
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:subjects,code,' . $id,
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->name,
            'code' => $request->code,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Delete a subject.
     */
    public function destroy($id)
    {
        $this->middleware('role:admin');
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
