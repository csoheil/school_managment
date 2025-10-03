@extends('layouts.app')
@section('title','Grade Details')

@section('content')
<div class="card card-strong">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h4>Grade for {{ $grade->student->name }}</h4>
                <p class="mb-1"><strong>Subject:</strong> {{ $grade->exam->subject->name }}</p>
                <p class="mb-1"><strong>Exam Date:</strong> {{ $grade->exam->date }}</p>
                <p class="mb-1"><strong>Marks:</strong> {{ $grade->marks }} / {{ $grade->exam->max_marks }}</p>
                <p class="text-muted"><strong>Comments:</strong> {{ $grade->comments ?? '-' }}</p>
            </div>
            <div class="text-end">
                <a href="{{ route('teacher.grades.edit',$grade->id) }}" class="btn btn-warning mb-2">Edit</a>
                <form action="{{ route('teacher.grades.destroy',$grade->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Delete this grade?')">Delete</button>
                </form>
            </div>
        </div>

        <hr>

        <h6 class="mt-3">Performance</h6>
        <canvas id="singleGradeChart" height="120"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function(){
    const ctx = document.getElementById('singleGradeChart');
    if(!ctx) return;
    // show marks vs max marks
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Marks Obtained','Remaining'],
            datasets: [{
                data: [{{ $grade->marks }}, {{ max(0, ($grade->exam->max_marks - $grade->marks)) }}],
                borderWidth: 0
            }]
        },
        options: { responsive: true }
    });
})();
</script>
@endpush
