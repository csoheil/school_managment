<?php



use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/admin/class', [AdminController::class, 'createClass'])->name('admin.create_class');
    Route::post('/admin/schedule', [AdminController::class, 'createSchedule'])->name('admin.create_schedule');
    Route::get('/admin/report-card/{studentId}', [AdminController::class, 'generateReportCard'])->name('admin.report_card');
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');
    Route::get('/teacher/classes', [TeacherController::class, 'viewClasses'])->name('teacher.classes');
    Route::get('/teacher/schedule', [TeacherController::class, 'viewSchedule'])->name('teacher.schedule');
    Route::post('/teacher/attendance/{classId}', [TeacherController::class, 'markAttendance'])->name('teacher.attendance');
    Route::post('/teacher/exam', [TeacherController::class, 'createExam'])->name('teacher.create_exam');
    Route::post('/teacher/grade/{classId}', [TeacherController::class, 'addGrade'])->name('teacher.grade');
    Route::get('/teacher/subjects', [TeacherController::class, 'manageSubjects'])->name('teacher.subjects');
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::get('/student/classes', [StudentController::class, 'viewClasses'])->name('student.classes');
    Route::get('/student/schedule', [StudentController::class, 'viewSchedule'])->name('student.schedule');
    Route::get('/student/report-card', [StudentController::class, 'viewReportCard'])->name('student.report_card');
    Route::get('/student/attendance', [StudentController::class, 'viewAttendance'])->name('student.attendance');
    Route::post('/student/avatar', [StudentController::class, 'updateAvatar'])->name('student.avatar');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::post('/classes/{class}/attendance', [TeacherController::class, 'markAttendance'])->name('attendance.store');
});
