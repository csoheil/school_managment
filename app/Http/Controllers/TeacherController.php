<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Attendance;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:teacher']);
    }

    public function markAttendance(Request $request, ClassModel $class)
    {
        $request->validate([
            'attendances.*.status' => 'required|in:present,absent,late'
        ]);

        foreach ($request->attendances as $studentId => $data) {
            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'class_id' => $class->id, 'date' => now()->format('Y-m-d')],
                ['status' => $data['status']]
            );
        }

        return back()->with('success', 'Attendance saved!');
    }
}
