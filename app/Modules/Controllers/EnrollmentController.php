<?php

namespace App\Modules\Oishy\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        return view('oishy.enrollments.index', ['enrollments' => Enrollment::with(['student', 'course', 'semester'])->get()]);
    }

    public function create()
    {
        return view('oishy.enrollments.create', [
            'students' => Student::orderBy('student_id')->get(),
            'courses' => Course::orderBy('course_code')->get(),
            'semesters' => Semester::orderBy('semester_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Enrollment::create($request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'semester_id' => 'required|exists:semesters,id',
            'enrollment_date' => 'required|date',
        ]));

        return redirect()->route('enrollments.index');
    }

    public function edit(Enrollment $enrollment)
    {
        return view('oishy.enrollments.edit', [
            'enrollment' => $enrollment,
            'students' => Student::orderBy('student_id')->get(),
            'courses' => Course::orderBy('course_code')->get(),
            'semesters' => Semester::orderBy('semester_name')->get(),
        ]);
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $enrollment->update($request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id' => 'required|exists:courses,id',
            'semester_id' => 'required|exists:semesters,id',
            'enrollment_date' => 'required|date',
        ]));

        return redirect()->route('enrollments.index');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index');
    }
}
