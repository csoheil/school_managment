@extends('layouts.app')
@section('title','Mark Attendance')

@section('content')
<div class="card card-strong">
    <div class="card-body">
        <h4>Mark Attendance - {{ $class->name }}</h4>
        <form action="{{ route('teacher.attendance.store',$class->id) }}" method="POST">
            @csrf
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($class->students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>
                                <select name="attendance[{{ $student->id }}]" class="form-select">
                                    <option value="Present">Present</option>
                                    <option value="Absent">Absent</option>
                                    <option value="Late">Late</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Save Attendance</button>
        </form>
    </div>
</div>
@endsection
