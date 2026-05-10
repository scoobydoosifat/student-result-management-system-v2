<?php

namespace App\Modules\Nazmul\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacherId = session('teacher_id');

        $teacher = Teacher::with([
            'department',
            'courses.enrollments.student',
            'courses.enrollments.result',
            'courses.enrollments.semester',
        ])->findOrFail($teacherId);

        $courseStats = $teacher->courses->map(function ($course) {
            $enrollments = $course->enrollments;

            return [
                'course' => $course,
                'enrollment_count' => $enrollments->count(),
                'results_published' => $enrollments->whereNotNull('result')->count(),
            ];
        });

        return view('nazmul.dashboard', [
            'teacher' => $teacher,
            'courseStats' => $courseStats,
        ]);
    }

    public function teacherIndex()
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::with('department')->findOrFail($teacherId);
        $courses = $teacher->courses()->with('department')->orderBy('course_code')->get();

        return view('nazmul.teacher-dashboard', [
            'teacher' => $teacher,
            'courses' => $courses,
        ]);
    }
}
