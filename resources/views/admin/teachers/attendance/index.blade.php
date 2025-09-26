@extends('layouts.app')
@section('title','Attendance')

@section('content')
<div class="card card-strong">
    <div class="card-body">
        <h4>Attendance</h4>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->class->name }}</td>
                            <td>{{ $attendance->date }}</td>
                            <td>
                                <span class="badge bg-{{ $attendance->status == 'Present' ? 'success' : ($attendance->status == 'Absent' ? 'danger' : 'warning') }}">
                                    {{ $attendance->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('teacher.attendance.mark',$attendance->class_id) }}" class="btn btn-sm btn-primary">Mark</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $attendances->links() }}
    </div>
</div>
@endsection
