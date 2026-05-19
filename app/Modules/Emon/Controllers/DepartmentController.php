<?php

namespace App\Modules\Emon\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('emon.departments.index', ['departments' => Department::all()]);
    }

    public function create()
    {
        return view('emon.departments.create');
    }

    public function store(Request $request)
    {
        Department::create($request->validate(['department_name' => 'required|string|unique:departments']));
        return redirect()->route('departments.index');
    }

    public function edit(Department $department)
    {
        return view('emon.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $department->update($request->validate(['department_name' => 'required|string|unique:departments,department_name,' . $department->id]));
        return redirect()->route('departments.index');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index');
    }
}
