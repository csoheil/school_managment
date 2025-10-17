<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    /**
     * Display a listing of the students.
     */
    public function indexStudents(Request $request)
    {
        $query = User::role('student')->with(['classes', 'grades']);

        // Apply filters
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('grade')) {
            $query->whereHas('classes', function ($q) use ($request) {
                $q->where('grade_level', $request->grade);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->paginate(10)->appends($request->query());

        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function createStudent()
    {
        $classes = \App\Models\ClassModel::all();
        return view('admin.students.create', compact('classes'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function storeStudent(StoreStudentRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $student = User::create($data);
        $student->assignRole('student');
        $student->classes()->sync($request->input('classes', []));

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function showStudent(User $student)
    {
        $student->load(['classes', 'grades', 'attendances']);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function editStudent(User $student)
    {
        $classes = \App\Models\ClassModel::all();
        return view('admin.students.edit', compact('student', 'classes'));
    }

    /**
     * Update the specified student in storage.
     */
    public function updateStudent(UpdateStudentRequest $request, User $student)
    {
        $data = $request->validated();
        
        if ($request->hasFile('avatar')) {
            if ($student->avatar) {
                Storage::disk('public')->delete($student->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $student->update($data);
        $student->classes()->sync($request->input('classes', []));

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroyStudent(User $student)
    {
        if ($student->avatar) {
            Storage::disk('public')->delete($student->avatar);
        }
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}