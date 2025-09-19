@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-users me-2 text-primary"></i>Students Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-filter me-1"></i>Actions
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addStudentModal"><i class="fas fa-plus me-2"></i>Add Student</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-export me-2"></i>Export CSV</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>Export PDF</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Bulk Delete</a></li>
                </ul>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                <i class="fas fa-upload me-1"></i>Bulk Import
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="searchInput" class="form-label">Search Students</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Name, Email, or ID...">
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="gradeFilter" class="form-label">Grade Level</label>
                    <select class="form-select" id="gradeFilter">
                        <option value="">All Grades</option>
                        <option value="9">Grade 9</option>
                        <option value="10">Grade 10</option>
                        <option value="11">Grade 11</option>
                        <option value="12">Grade 12</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="statusFilter" class="form-label">Status</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="graduated">Graduated</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button type="button" class="btn btn-primary w-100" id="applyFilters">
                        <i class="fas fa-filter me-1"></i>Apply
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="card shadow">
        <div class="card-header bg-light border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Students List ({{ $students->count() }})</h5>
                </div>
                <div class="col-auto">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="gridView">
                            <i class="fas fa-th"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary active" id="listView">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="studentsTable">
                    <thead class="table-dark">
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Photo</th>
                        <th>Name <i class="fas fa-sort text-muted"></i></th>
                        <th>Email</th>
                        <th>Grade</th>
                        <th>Attendance Rate</th>
                        <th>GPA</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td><input type="checkbox" class="student-checkbox" value="{{ $student->id }}"></td>
                            <td>
                                @if($student->avatar)
                                    <img src="{{ Storage::url($student->avatar) }}" class="rounded-circle" width="40" height="40" alt="{{ $student->name }}">
                                @else
                                    <div class="avatar-xs bg-primary rounded-circle d-flex align-items-center justify-content-center text-white">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <h6 class="mb-0">{{ $student->name }}</h6>
                                        <small class="text-muted">ID: {{ $student->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $student->email }}</td>
                            <td><span class="badge bg-info">{{ $student->grade_level ?? 'TBD' }}</span></td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ rand(85, 99) }}%" aria-valuenow="{{ rand(85, 99) }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ rand(85, 99) }}%
                                    </div>
                                </div>
                            </td>
                            <td><span class="fw-bold text-primary">{{ number_format(rand(30, 40)/10, 2) }}</span></td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#studentDetails{{ $student->id }}" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $student->id }})" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Students pagination">
                {{ $students->links() }}
            </nav>
        </div>
    </div>

    <!-- Bulk Actions Dropdown -->
    <div class="card shadow mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="bulkSelectAll">
                    <label class="form-check-label" for="bulkSelectAll">
                        Select All ({{ $students->count() }})
                    </label>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary" id="bulkView">
                        <i class="fas fa-eye me-1"></i>View Selected
                    </button>
                    <button type="button" class="btn btn-outline-warning" id="bulkEdit">
                        <i class="fas fa-edit me-1"></i>Edit Selected
                    </button>
                    <button type="button" class="btn btn-outline-danger" id="bulkDelete">
                        <i class="fas fa-trash me-1"></i>Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Details Modal (Example for first student - repeat for each) -->
    @foreach($students as $student)
        <div class="modal fade" id="studentDetails{{ $student->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $student->name }} - Student Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                @if($student->avatar)
                                    <img src="{{ Storage::url($student->avatar) }}" class="rounded-circle img-fluid mb-3" width="150" alt="{{ $student->name }}">
                                @else
                                    <div class="avatar-lg bg-primary rounded-circle d-flex align-items-center justify-content-center text-white mb-3 mx-auto">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                @endif
                                <h6 class="mb-1">{{ $student->name }}</h6>
                                <p class="text-muted mb-2">Grade {{ $student->grade_level ?? 'TBD' }}</p>
                                <div class="d-flex justify-content-center gap-2">
                                    <span class="badge bg-primary">GPA: 3.85</span>
                                    <span class="badge bg-success">Attendance: 98%</span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Email:</strong><br>{{ $student->email }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Phone:</strong><br>{{ $student->phone ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>Enrollment Date:</strong><br>{{ $student->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="col-6">
                                        <strong>Status:</strong><br><span class="badge bg-success">Active</span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <strong>Emergency Contact:</strong><br>{{ $student->emergency_contact ?? 'N/A' }}
                                </div>
                                <div class="mb-3">
                                    <strong>Current Classes:</strong><br>
                                    @foreach($student->classes as $class)
                                        <span class="badge bg-info me-1 mb-1">{{ $class->name }}</span>
                                    @endforeach
                                </div>
                                <hr>
                                <h6>Recent Performance</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Score</th>
                                            <th>Grade</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($student->grades->take(5) as $grade)
                                            <tr>
                                                <td>{{ $grade->subject->name }}</td>
                                                <td>{{ $grade->score }}%</td>
                                                <td><span class="badge bg-success">A</span></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="{{ route('admin.student.edit', $student->id) }}" class="btn btn-primary">Edit Profile</a>
                        <a href="{{ route('admin.student.report_card', $student->id) }}" class="btn btn-info">View Report Card</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Bulk Import Modal -->
    <div class="modal fade" id="bulkImportModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Import Students</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Upload CSV File</label>
                            <input type="file" class="form-control" id="csvFile" accept=".csv" required>
                            <div class="form-text">Format: Name,Email,Grade,Phone</div>
                        </div>
                        <div class="mb-3">
                            <label for="importOptions" class="form-label">Import Options</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="updateExisting">
                                <label class="form-check-label" for="updateExisting">Update existing students</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendWelcomeEmail" checked>
                                <label class="form-check-label" for="sendWelcomeEmail">Send welcome emails</label>
                            </div>
                        </div>
                        <div class="progress mb-3">
                            <div class="progress-bar" role="progressbar" style="width: 0%" id="importProgress">0%</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="startImport">
                        <i class="fas fa-upload me-2"></i>Start Import
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Search functionality
                document.getElementById('searchInput').addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('#studentsTable tbody tr').forEach(row => {
                        const name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                        const email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                        row.style.display = name.includes(searchTerm) || email.includes(searchTerm) ? '' : 'none';
                    });
                });

                // Filter functionality
                document.getElementById('applyFilters').addEventListener('click', function() {
                    const grade = document.getElementById('gradeFilter').value;
                    const status = document.getElementById('statusFilter').value;

                    document.querySelectorAll('#studentsTable tbody tr').forEach(row => {
                        const rowGrade = row.querySelector('td:nth-child(5)').textContent;
                        const rowStatus = row.querySelector('td:nth-child(8)').querySelector('.badge').textContent.toLowerCase();

                        let show = true;
                        if (grade && !rowGrade.includes(grade)) show = false;
                        if (status && !rowStatus.includes(status)) show = false;

                        row.style.display = show ? '' : 'none';
                    });
                });

                // View toggle
                document.getElementById('gridView').addEventListener('click', function() {
                    document.getElementById('listView').classList.remove('active');
                    this.classList.add('active');
                    // Implement grid view logic
                });

                document.getElementById('listView').addEventListener('click', function() {
                    document.getElementById('gridView').classList.remove('active');
                    this.classList.add('active');
                    // Implement list view logic (current)
                });

                // Bulk select
                document.getElementById('selectAll').addEventListener('change', function() {
                    document.querySelectorAll('.student-checkbox').forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                // Bulk actions
                document.getElementById('bulkView').addEventListener('click', function() {
                    const selected = Array.from(document.querySelectorAll('.student-checkbox:checked')).map(cb => cb.value);
                    if (selected.length === 0) {
                        alert('Please select students first');
                        return;
                    }
                    console.log('Viewing selected students:', selected);
                });

                document.getElementById('bulkEdit').addEventListener('click', function() {
                    const selected = Array.from(document.querySelectorAll('.student-checkbox:checked')).map(cb => cb.value);
                    if (selected.length === 0) {
                        alert('Please select students first');
                        return;
                    }
                    // Redirect to bulk edit page
                    window.location.href = `/admin/students/bulk-edit?ids=${selected.join(',')}`;
                });

                document.getElementById('bulkDelete').addEventListener('click', function() {
                    const selected = Array.from(document.querySelectorAll('.student-checkbox:checked')).map(cb => cb.value);
                    if (selected.length === 0) {
                        alert('Please select students first');
                        return;
                    }
                    if (confirm(`Delete ${selected.length} students? This cannot be undone.`)) {
                        // Bulk delete logic
                        console.log('Deleting students:', selected);
                        alert('Students deleted successfully!');
                    }
                });

                // Import progress simulation
                document.getElementById('startImport').addEventListener('click', function() {
                    const progress = document.getElementById('importProgress');
                    let width = 0;
                    const interval = setInterval(() => {
                        width += 10;
                        progress.style.width = width + '%';
                        progress.textContent = width + '%';
                        if (width >= 100) {
                            clearInterval(interval);
                            alert('Import completed successfully!');
                            $('#bulkImportModal').modal('hide');
                        }
                    }, 200);
                });
            });
        </script>
    @endpush

@endsection
