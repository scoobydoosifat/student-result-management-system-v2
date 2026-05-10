<?php

namespace App\Modules\Nazmul\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class TeacherStudentDropController extends Controller
{
    public function index()
    {
        $teacherId = session('teacher_id');

        return view('nazmul.students.index', [
            'enrollments' => Enrollment::with(['student.department', 'semester', 'course'])
                ->whereHas('course', fn ($query) => $query->where('teacher_id', $teacherId))
                ->orderByDesc('id')
                ->get(),
        ]);
    }

    public function destroy(Enrollment $enrollment)
    {
        $teacherId = session('teacher_id');

        if ($enrollment->course?->teacher_id !== $teacherId) {
            return redirect()->route('teacher.enrollments.index')->with('status', 'Not allowed to drop this enrollment.');
        }

        $enrollment->delete();

        return redirect()->route('teacher.enrollments.index')->with('status', 'Student dropped from your course.');
    }
}
