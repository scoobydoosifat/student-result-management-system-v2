<?php

namespace App\Modules\Emon\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        return view('emon.courses.index', [
            'courses' => Course::with(['department', 'teacher'])->orderBy('course_code')->get(),
        ]);
    }

    public function create()
    {
        return view('emon.courses.create', [
            'departments' => Department::orderBy('department_name')->get(),
            'teachers' => Teacher::where('role', 'teacher')->orderBy('teacher_id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_code' => 'required|string|unique:courses,course_code',
            'course_title' => 'required|string',
            'credit_hours' => 'required|integer|min:1|max:6',
            'department_id' => 'required|exists:departments,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        Course::create($data);

        return redirect()->route('courses.index');
    }

    public function edit(Course $course)
    {
        return view('emon.courses.edit', [
            'course' => $course,
            'departments' => Department::orderBy('department_name')->get(),
            'teachers' => Teacher::where('role', 'teacher')->orderBy('teacher_id')->get(),
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'course_code' => 'required|string|unique:courses,course_code,' . $course->id,
            'course_title' => 'required|string',
            'credit_hours' => 'required|integer|min:1|max:6',
            'department_id' => 'required|exists:departments,id',
            'teacher_id' => 'required|exists:teachers,id',
        ]);

        $course->update($data);

        return redirect()->route('courses.index');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index');
    }
}
