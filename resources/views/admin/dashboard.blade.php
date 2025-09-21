@extends('layouts.app')
@section('title','Admin Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card card-strong p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Overview</h5>
                    <div>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createStudentModal">New Student</button>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createTeacherModal">New Teacher</button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h6>Students</h6>
                            <h3>{{ $counts['students'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h6>Teachers</h6>
                            <h3>{{ $counts['teachers'] ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 mb-3">
                            <h6>Classes</h6>
                            <h3>{{ $counts['classes'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <canvas id="adminChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-strong p-3">
                <h6>Recent Activities</h6>
                <ul class="list-group list-group-flush mt-2">
                    @foreach($activities ?? [] as $act)
                        <li class="list-group-item small">{{ $act }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @include('admin.modals.register')
    @include('admin.modals.create_teacher')

@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('adminChart');
        if(ctx){
            new Chart(ctx,{
                type:'bar',
                data:{
                    labels: {!! json_encode(array_keys($chartData ?? [])) !!},
                    datasets:[{label:'Counts',data:{!! json_encode(array_values($chartData ?? [])) !!},tension:0.3}]
                },
                options:{
                    responsive:true,
                    scales:{
                        y:{beginAtZero:true}
                    }
                }
            })
        }
    </script>
@endpush
