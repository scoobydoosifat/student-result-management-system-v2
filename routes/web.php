<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Sifat\Controllers\StudentAuthController;
use App\Modules\Sifat\Controllers\StudentDashboardController;
use App\Modules\Nazmul\Controllers\TeacherAuthController;
use App\Modules\Nazmul\Controllers\TeacherDashboardController;
use App\Modules\Nazmul\Controllers\CoordinatorTeacherController;
use App\Modules\Nazmul\Controllers\TeacherStudentDropController;
use App\Modules\Nazmul\Controllers\TeacherStudentController;
use App\Modules\Emon\Controllers\DepartmentController;
use App\Modules\Emon\Controllers\CourseController;
use App\Modules\Emon\Controllers\SemesterController;
use App\Modules\Oishy\Controllers\EnrollmentController;
use App\Modules\Oishy\Controllers\ResultController;
use App\Modules\Mithila\Controllers\TranscriptController;
use App\Modules\Mithila\Controllers\ResultHistoryController;

Route::get('/', function () {
    if (session('student_id')) {
        return redirect()->route('student.dashboard');
    }

    if (session('teacher_id') && session('teacher_role') === 'coordinator') {
        return redirect()->route('coordinator.dashboard');
    }

    if (session('teacher_id') && session('teacher_role') === 'teacher') {
        return redirect()->route('teacher.dashboard');
    }

    return view('welcome');
});

Route::get('/student/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentAuthController::class, 'login'])->name('student.login.submit');

Route::get('/coordinator/login', [TeacherAuthController::class, 'showCoordinatorLoginForm'])->name('coordinator.login');
Route::post('/coordinator/login', [TeacherAuthController::class, 'loginCoordinator'])->name('coordinator.login.submit');

Route::get('/teacher/login', [TeacherAuthController::class, 'showTeacherLoginForm'])->name('teacher.login');
Route::post('/teacher/login', [TeacherAuthController::class, 'loginTeacher'])->name('teacher.login.submit');

Route::middleware('student')->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/student/transcript/{semesterId}', [TranscriptController::class, 'download'])->name('student.transcript');
    Route::post('/student/logout', [StudentAuthController::class, 'logout'])->name('student.logout');
});

Route::middleware('coordinator')->group(function () {
    Route::get('/coordinator/dashboard', [TeacherDashboardController::class, 'index'])->name('coordinator.dashboard');
    Route::post('/coordinator/logout', [TeacherAuthController::class, 'logout'])->name('coordinator.logout');
    Route::get('/coordinator/students/create', [TeacherStudentController::class, 'create'])->name('teacher.students.create');
    Route::post('/coordinator/students', [TeacherStudentController::class, 'store'])->name('teacher.students.store');
    Route::get('/coordinator/teachers/create', [CoordinatorTeacherController::class, 'create'])->name('coordinator.teachers.create');
    Route::post('/coordinator/teachers', [CoordinatorTeacherController::class, 'store'])->name('coordinator.teachers.store');

    Route::resource('/departments', DepartmentController::class)->except(['show']);
    Route::resource('/semesters', SemesterController::class)->except(['show']);
    Route::resource('/courses', CourseController::class)->except(['show']);
    Route::resource('/enrollments', EnrollmentController::class)->except(['show']);
});

Route::middleware('teacher')->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'teacherIndex'])->name('teacher.dashboard');
    Route::post('/teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');

    Route::resource('/results', ResultController::class)->except(['show']);
    Route::get('/result-histories', [ResultHistoryController::class, 'index'])->name('result-histories.index');

    Route::get('/teacher/enrollments', [TeacherStudentDropController::class, 'index'])->name('teacher.enrollments.index');
    Route::delete('/teacher/enrollments/{enrollment}', [TeacherStudentDropController::class, 'destroy'])->name('teacher.enrollments.destroy');
});
