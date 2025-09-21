<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'School Management')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root{--primary:#007bff;--muted:#6c757d}
        body{background:linear-gradient(180deg,#f8f9fa, #ffffff);}
        .sidebar{min-height:100vh;background:linear-gradient(180deg,rgba(0,123,255,0.06),transparent);}
        .card-strong{box-shadow:0 6px 18px rgba(13,110,253,0.08);border:none}
        .brand{font-weight:700;color:var(--primary)}
        .nav-link.active{background:rgba(0,123,255,0.08);border-radius:8px}
        .avatar-sm{width:38px;height:38px;border-radius:50%;object-fit:cover}
        .table thead th{cursor:pointer}
        .search-input{max-width:360px}
        @media (max-width: 991px) {
            aside.sidebar { display:none; }
        }
    </style>

    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand brand" href="#">SchoolMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @role('admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a></li>
                @endrole
                @role('teacher')
                <li class="nav-item"><a class="nav-link" href="{{ route('teacher.dashboard') }}">Teacher</a></li>
                @endrole
                @role('student')
                <li class="nav-item"><a class="nav-link" href="{{ route('student.dashboard') }}">Student</a></li>
                @endrole
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-2">
                    <form action="{{ route('search') }}" method="GET" class="d-flex">
                        <input class="form-control form-control-sm search-input" name="q" placeholder="Search...">
                    </form>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" class="avatar-sm me-2">
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar p-3">
            <div class="mb-4">
                <h5 class="mb-0 brand">SchoolMS</h5>
                <small class="text-muted">{{ auth()->user()->email }}</small>
            </div>

            <ul class="nav flex-column">
                @role('admin')
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.students.index') }}">Students</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.teachers.index') }}">Teachers</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.classes.index') }}">Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.schedules.index') }}">Schedules</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.exams.index') }}">Exams</a></li>
                @endrole

                @role('teacher')
                <li class="nav-item"><a class="nav-link" href="{{ route('teacher.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('teacher.classes') }}">My Classes</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('teacher.attendance') }}">Attendance</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('teacher.exams.index') }}">Exams</a></li>
                @endrole

                @role('student')
                <li class="nav-item"><a class="nav-link" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('student.schedules') }}">Schedules</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('student.report') }}">Report Card</a></li>
                @endrole
            </ul>
        </aside>

        <main class="col-md-10 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Table sorting
    document.addEventListener('click', function(e){
        if(e.target.matches('th.sortable')){
            const th = e.target;
            const table = th.closest('table');
            const idx = Array.from(th.parentNode.children).indexOf(th);
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const asc = !th.classList.contains('asc');
            rows.sort((a,b)=>{
                const aText = a.children[idx].innerText.trim();
                const bText = b.children[idx].innerText.trim();
                return asc ? aText.localeCompare(bText, undefined, {numeric:true}) : bText.localeCompare(aText, undefined, {numeric:true});
            });
            th.classList.toggle('asc', asc);
            rows.forEach(r=>tbody.appendChild(r));
        }
    });

    // Simple table filter
    function tableFilter(inputId, tableId){
        const q = document.getElementById(inputId);
        q && q.addEventListener('input', ()=>{
            const filter = q.value.toLowerCase();
            const rows = document.querySelectorAll(`#${tableId} tbody tr`);
            rows.forEach(r=>{r.style.display = Array.from(r.children).some(td=>td.innerText.toLowerCase().includes(filter)) ? '' : 'none'})
        });
    }
</script>

@stack('scripts')
</body>
</html>
