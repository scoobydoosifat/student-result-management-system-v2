<?php

namespace App\Modules\Nazmul\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherDashboardController extends Controller
{
    public function profile()
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::with('department')->findOrFail($teacherId);
        return view('nazmul.teacher-profile', compact('teacher'));
    }

    public function updateProfile(Request $request)
    {
        $teacherId = session('teacher_id');
        $teacher = Teacher::findOrFail($teacherId);

        $data = $request->validate([
            'full_name' => 'required|string',
            'email' => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone' => 'required|string|unique:teachers,phone,' . $teacher->id,
        ]);

        $teacher->update($data);
        return back()->with('status', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $teacherId = session('teacher_id');
        $teacherLogin = \App\Models\TeacherLogin::where('teacher_id', $teacherId)->first();

        $data = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $teacherLogin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $teacherLogin->update(['password' => Hash::make($data['new_password'])]);
        return back()->with('status', 'Password changed successfully!');
    }

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
