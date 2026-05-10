<?php

namespace App\Modules\Nazmul\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\TeacherLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoordinatorTeacherController extends Controller
{
    public function create()
    {
        return view('nazmul.teachers.create', [
            'departments' => Department::orderBy('department_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id' => 'required|string|unique:teachers,teacher_id',
            'full_name' => 'required|string',
            'email' => 'required|email|unique:teachers,email',
            'designation' => 'required|string',
            'phone' => 'required|string|unique:teachers,phone',
            'department_id' => 'required|exists:departments,id',
            'password' => 'nullable|string|min:6',
        ]);

        $plainPassword = $data['password'] ?: 'password';
        $data['password'] = Hash::make($plainPassword);
        $data['role'] = 'teacher';

        $teacher = Teacher::create($data);

        TeacherLogin::create([
            'teacher_id' => $teacher->id,
            'username' => $teacher->teacher_id,
            'password' => Hash::make($plainPassword),
        ]);

        return redirect()->route('coordinator.dashboard')->with('status', 'Teacher created successfully.');
    }
}
