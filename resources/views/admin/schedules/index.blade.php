@extends('layouts.app')
@section('title','Schedules')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Schedules</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createScheduleModal">
            <i class="bi bi-plus-lg"></i> Add Schedule
        </button>
    </div>

    <div class="card card-strong">
        <div class="card-body">
            <input id="scheduleSearch" class="form-control mb-3" placeholder="Search schedules...">

            <div class="table-responsive">
                <table id="schedulesTable" class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th class="sortable">Class</th>
                        <th class="sortable">Subject</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->class->name }}</td>
                            <td>{{ $schedule->subject->name }}</td>
                            <td>{{ $schedule->day_of_week }}</td>
                            <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                            <td>
                                <a href="{{ route('admin.schedules.show',$schedule->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.schedules.edit',$schedule->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.schedules.destroy',$schedule->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this schedule?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $schedules->links() }}
        </div>
    </div>

    @include('admin.modals.create_schedule')
@endsection

@push('scripts')
    <script>
        tableFilter('scheduleSearch','schedulesTable');
    </script>
@endpush
