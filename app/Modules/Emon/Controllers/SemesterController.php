<?php

namespace App\Modules\Emon\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        return view('emon.semesters.index', ['semesters' => Semester::all()]);
    }

    public function create()
    {
        return view('emon.semesters.create');
    }

    public function store(Request $request)
    {
        Semester::create($request->validate(['semester_name' => 'required|string|unique:semesters']));
        return redirect()->route('semesters.index');
    }

    public function edit(Semester $semester)
    {
        return view('emon.semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $semester->update($request->validate(['semester_name' => 'required|string|unique:semesters,semester_name,' . $semester->id]));
        return redirect()->route('semesters.index');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semesters.index');
    }
}
