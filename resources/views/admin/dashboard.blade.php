@extends('layouts.app')
@section('title','Teacher Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-strong text-center">
                <div class="card-body">
                    <h5>My Classes</h5>
                    <h2>{{ $classesCount }}</h2>
                    <a href="{{ route('teacher.classes.index') }}" class="btn btn-primary btn-sm">View Classes</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-strong text-center">
                <div class="card-body">
                    <h5>Exams Created</h5>
                    <h2>{{ $examsCount }}</h2>
                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-success btn-sm">View Exams</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-strong text-center">
                <div class="card-body">
                    <h5>Students</h5>
                    <h2>{{ $studentsCount }}</h2>
                    <a href="{{ route('teacher.classes.index') }}" class="btn btn-info btn-sm">Check Students</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-strong mt-4">
        <div class="card-body">
            <h5>Attendance Overview</h5>
            <canvas id="attendanceChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Present','Absent','Late'],
                datasets: [{
                    data: [{{ $attendanceStats['present'] }}, {{ $attendanceStats['absent'] }}, {{ $attendanceStats['late'] }}],
                    backgroundColor: ['#28a745','#dc3545','#ffc107']
                }]
            }
        });
    </script>
@endpush
