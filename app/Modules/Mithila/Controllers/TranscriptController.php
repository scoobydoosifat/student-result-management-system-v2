<?php

namespace App\Modules\Mithila\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Semester;
use App\Models\Student;
use App\Modules\Mithila\Services\TranscriptPdfService;
use Illuminate\Support\Collection;

class TranscriptController extends Controller
{
    public function download(int $semesterId, TranscriptPdfService $pdf)
    {
        $studentId = session('student_id');
        $student = Student::with('department')->findOrFail($studentId);

        $enrollments = Enrollment::with(['course', 'result', 'semester'])
            ->where('student_id', $studentId)
            ->where('semester_id', $semesterId)
            ->get();

        $semester = $enrollments->first()?->semester ?? Semester::find($semesterId);
        [$gpa, $totalCredits] = $this->calculateGpa($enrollments);

        $rows = $enrollments->map(function (Enrollment $enrollment) {
            return [
                'course_code' => $enrollment->course?->course_code,
                'course_title' => $enrollment->course?->course_title,
                'credit_hours' => $enrollment->course?->credit_hours,
                'total_marks' => $enrollment->result?->total_marks,
                'letter_grade' => $enrollment->result?->letter_grade,
                'grade_point' => $enrollment->result?->grade_point,
            ];
        });

        $data = [
            'student' => $student,
            'semester' => $semester,
            'rows' => $rows,
            'gpa' => $gpa,
            'totalCredits' => $totalCredits,
        ];

        return $pdf->download($data)->download('semester-transcript.pdf');
    }

    private function calculateGpa(Collection $enrollments): array
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
            return [null, 0];
        }

        return [round($totalPoints / $totalCredits, 2), $totalCredits];
    }
}
