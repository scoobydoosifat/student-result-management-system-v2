<?php

namespace App\Modules\Oishy\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Result;
use App\Models\ResultHistory;
use App\Modules\Oishy\Services\GradeCalculator;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $teacherId = $this->currentTeacherId();
        $resultsQuery = Result::with('enrollment.student', 'enrollment.course', 'enrollment.semester');

        if ($teacherId) {
            $resultsQuery->whereHas('enrollment.course', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            });
        }

        return view('oishy.results.index', [
            'results' => $resultsQuery->get(),
        ]);
    }

    public function create()
    {
        $teacherId = $this->currentTeacherId();
        $enrollmentsQuery = Enrollment::with(['student', 'course', 'semester'])
            ->whereDoesntHave('result');

        if ($teacherId) {
            $enrollmentsQuery->whereHas('course', function ($query) use ($teacherId) {
                $query->where('teacher_id', $teacherId);
            });
        }

        return view('oishy.results.create', [
            'enrollments' => $enrollmentsQuery->get(),
        ]);
    }

    public function store(Request $request, GradeCalculator $calculator)
    {
        $data = $request->validate([
            'enrollment_id' => 'required|exists:enrollments,id',
            'mid_marks' => 'required|integer|min:0|max:30',
            'final_marks' => 'required|integer|min:0|max:50',
            'assignment_marks' => 'required|integer|min:0|max:10',
            'attendance_marks' => 'required|integer|min:0|max:10',
        ]);

        [$grade, $point] = $calculator->calculate($data['mid_marks'], $data['final_marks'], $data['assignment_marks'], $data['attendance_marks']);
        $data['total_marks'] = array_sum([$data['mid_marks'], $data['final_marks'], $data['assignment_marks'], $data['attendance_marks']]);
        $data['letter_grade'] = $grade;
        $data['grade_point'] = $point;
        $data['gpa'] = $point;

        $teacherId = $this->currentTeacherId();
        if ($teacherId) {
            $hasAccess = Enrollment::where('id', $data['enrollment_id'])
                ->whereHas('course', function ($query) use ($teacherId) {
                    $query->where('teacher_id', $teacherId);
                })
                ->exists();

            if (!$hasAccess) {
                return back()
                    ->withErrors(['enrollment_id' => 'This enrollment is not assigned to you.'])
                    ->withInput();
            }
        }

        Result::create($data);

        return redirect()->route('results.index');
    }

    public function edit(Result $result)
    {
        $this->ensureTeacherOwnsResult($this->currentTeacherId(), $result);
        return view('oishy.results.edit', [
            'result' => $result->load('enrollment.student', 'enrollment.course', 'enrollment.semester'),
        ]);
    }

    public function update(Request $request, Result $result, GradeCalculator $calculator)
    {
        $this->ensureTeacherOwnsResult($this->currentTeacherId(), $result);
        $data = $request->validate([
            'mid_marks' => 'required|integer|min:0|max:30',
            'final_marks' => 'required|integer|min:0|max:50',
            'assignment_marks' => 'required|integer|min:0|max:10',
            'attendance_marks' => 'required|integer|min:0|max:10',
        ]);

        ResultHistory::create([
            'result_id' => $result->id,
            'old_total_marks' => $result->total_marks,
            'old_grade' => $result->letter_grade,
        ]);

        [$grade, $point] = $calculator->calculate($data['mid_marks'], $data['final_marks'], $data['assignment_marks'], $data['attendance_marks']);
        $data['total_marks'] = array_sum([$data['mid_marks'], $data['final_marks'], $data['assignment_marks'], $data['attendance_marks']]);
        $data['letter_grade'] = $grade;
        $data['grade_point'] = $point;
        $data['gpa'] = $point;

        $result->update($data);

        return redirect()->route('results.index');
    }

    public function destroy(Result $result)
    {
        $this->ensureTeacherOwnsResult($this->currentTeacherId(), $result);
        $result->delete();
        return redirect()->route('results.index');
    }

    private function currentTeacherId(): ?int
    {
        return session('teacher_id');
    }

    private function ensureTeacherOwnsResult(?int $teacherId, Result $result): void
    {
        if (!$teacherId) {
            return;
        }

        $result->loadMissing('enrollment.course');
        $courseTeacherId = optional(optional($result->enrollment)->course)->teacher_id;

        if ($courseTeacherId !== $teacherId) {
            abort(403);
        }
    }
}
