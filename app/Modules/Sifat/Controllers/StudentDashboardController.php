<?php

namespace App\Modules\Sifat\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StudentDashboardController extends Controller
{
    public function index(Request $request)
    {
        $studentId = session('student_id');

        $student = Student::with([
            'department',
            'semester',
        ])->findOrFail($studentId);

        $allEnrollments = Enrollment::with(['course', 'semester', 'result'])
            ->where('student_id', $studentId)
            ->get();

        $filteredEnrollments = $this->applyFilters(
            Enrollment::with(['course', 'semester', 'result'])
                ->where('student_id', $studentId),
            $request
        )->get();

        $semesterStats = $this->buildSemesterStats($allEnrollments);
        $overallGpa = $this->calculateGpa($allEnrollments);

        $courses = Course::whereHas('enrollments', fn ($query) => $query->where('student_id', $studentId))
            ->orderBy('course_code')
            ->get();

        $semesters = Semester::whereHas('enrollments', fn ($query) => $query->where('student_id', $studentId))
            ->orderBy('semester_name')
            ->get();

        return view('sifat.dashboard', [
            'student' => $student,
            'enrollments' => $filteredEnrollments,
            'semesterStats' => $semesterStats,
            'overallGpa' => $overallGpa,
            'courses' => $courses,
            'semesters' => $semesters,
            'filters' => $request->only(['course_code', 'semester_id', 'letter_grade']),
        ]);
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->filled('course_code')) {
            $query->whereHas('course', function ($builder) use ($request) {
                $builder->where('course_code', 'like', '%' . $request->course_code . '%');
            });
        }

        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        if ($request->filled('letter_grade')) {
            $query->whereHas('result', function ($builder) use ($request) {
                $builder->where('letter_grade', $request->letter_grade);
            });
        }

        return $query;
    }

    private function buildSemesterStats(Collection $enrollments): Collection
    {
        return $enrollments
            ->groupBy('semester_id')
            ->map(function (Collection $items) {
                $semester = $items->first()?->semester;
                $gpa = $this->calculateGpa($items);

                return [
                    'semester' => $semester,
                    'gpa' => $gpa,
                    'enrollments' => $items,
                ];
            });
    }

    private function calculateGpa(Collection $enrollments): ?float
    {
        $totalCredits = 0;
        $totalPoints = 0.0;

        foreach ($enrollments as $enrollment) {
            if (!$enrollment->course || !$enrollment->result) {
                continue;
            }

            $credits = (int) $enrollment->course->credit_hours;
            $totalCredits += $credits;
            $totalPoints += $enrollment->result->grade_point * $credits;
        }

        if ($totalCredits === 0) {
            return null;
        }

        return round($totalPoints / $totalCredits, 2);
    }
}
