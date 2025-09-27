@extends('layouts.app')
@section('title','Grades')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Grades</h4>
    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGradeModal">
            <i class="bi bi-plus-lg"></i> Add Grade
        </button>
        <a href="{{ route('teacher.grades.export') }}" class="btn btn-outline-secondary">Export</a>
    </div>
</div>

<div class="card card-strong mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-8">
                <input id="gradeSearch" class="form-control mb-3" placeholder="Search by student or subject...">
                <div class="table-responsive">
                    <table id="gradesTable" class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th class="sortable">Student</th>
                                <th class="sortable">Subject</th>
                                <th class="sortable">Exam</th>
                                <th>Marks</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $grade->student->name }}</td>
                                    <td>{{ $grade->exam->subject->name }}</td>
                                    <td>{{ $grade->exam->date }}</td>
                                    <td>{{ $grade->marks }} / {{ $grade->exam->max_marks }}</td>
                                    <td>
                                        <a href="{{ route('teacher.grades.show',$grade->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('teacher.grades.edit',$grade->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('teacher.grades.destroy',$grade->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this grade?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $grades->links() }}
            </div>

            <div class="col-md-4">
                <h6 class="mb-2">Grade distribution</h6>
                <canvas id="gradeDistChart" height="250"></canvas>
                <small class="text-muted d-block mt-2">Distribution for selected subject / class (if filtered)</small>
            </div>
        </div>
    </div>
</div>

@include('teacher.modals.add_grade')

@endsection

@push('scripts')
<script>
    // filter table live
    tableFilter('gradeSearch','gradesTable');

    // grade distribution chart
    (function(){
        const ctx = document.getElementById('gradeDistChart');
        if(!ctx) return;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($gradeDistribution['labels'] ?? ['0-20','21-40','41-60','61-80','81-100']) !!},
                datasets: [{
                    label: 'Students',
                    data: {!! json_encode($gradeDistribution['counts'] ?? [0,0,0,0,0]) !!},
                    borderRadius: 6,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });
    })();
</script>
@endpush
