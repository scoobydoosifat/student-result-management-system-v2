<?php

namespace App\Modules\Emon\Controllers;

use App\Http\Controllers\Controller; #Use Laravel’s base Controller class.
use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use Illuminate\Http\Request; #Handle user input.

class CourseController extends Controller # Inherits the deafult laravels controller.
{
    public function index() # Fetch all coursses with department and teacher id.
    {
        return view('emon.courses.index', [
            'courses' => Course::with(['department', 'teacher'])->orderBy('course_code')->get(),
        ]);
    }

    public function create() #Show the page where a user can add a new course.
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

    public function edit(Course $course) #Show edit page
    {
        return view('emon.courses.edit', [
            'course' => $course,
            'departments' => Department::orderBy('department_name')->get(),
            'teachers' => Teacher::where('role', 'teacher')->orderBy('teacher_id')->get(),
        ]);
    }

    public function update(Request $request, Course $course) #Save edited course
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

    public function destroy(Course $course) # Delete a Course
    {
        $course->delete();

        return redirect()->route('courses.index');
    }
}
