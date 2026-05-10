<?php

namespace App\Modules\Nazmul\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherStudentController extends Controller
{
    public function create()
    {
        return view('nazmul.students.create', [
            'departments' => Department::orderBy('department_name')->get(),
            'semesters' => Semester::orderBy('semester_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|string|unique:students,student_id',
            'full_name' => 'required|string',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|unique:students,phone',
            'batch' => 'required|string',
            'enrollment_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'semester_id' => 'required|exists:semesters,id',
            'password' => 'nullable|string|min:6',
        ]);

        $plainPassword = $data['password'] ?: 'password';
        $data['password'] = Hash::make($plainPassword);

        $student = Student::create($data);

        StudentLogin::create([
            'student_id' => $student->id,
            'username' => $student->student_id,
            'password' => Hash::make($plainPassword),
        ]);

        return redirect()->route('coordinator.dashboard')->with('status', 'Student created successfully.');
    }
}
