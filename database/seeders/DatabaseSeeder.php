<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Result;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentLogin;
use App\Models\Teacher;
use App\Models\TeacherLogin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $departments = collect(['CSE', 'EEE', 'BBA'])->map(fn ($name) => Department::create(['department_name' => $name]));
        $semesters = collect(['Spring 2025', 'Summer 2025', 'Fall 2025'])->map(fn ($name) => Semester::create(['semester_name' => $name]));

        $teachers = [
            Teacher::create(['teacher_id' => 'T-1001', 'full_name' => 'Md. Rahman', 'email' => 'rahman@uni.edu.bd', 'designation' => 'Professor', 'phone' => '01710000001', 'password' => Hash::make('password'), 'department_id' => $departments[0]->id, 'role' => 'teacher']),
            Teacher::create(['teacher_id' => 'T-1002', 'full_name' => 'Mahmudul Hasan', 'email' => 'mahmudul@uni.edu.bd', 'designation' => 'Lecturer', 'phone' => '01710000002', 'password' => Hash::make('password'), 'department_id' => $departments[0]->id, 'role' => 'teacher']),
            Teacher::create(['teacher_id' => 'T-2001', 'full_name' => 'Farhana Yasmin', 'email' => 'farhana@uni.edu.bd', 'designation' => 'Assistant Professor', 'phone' => '01710000003', 'password' => Hash::make('password'), 'department_id' => $departments[1]->id, 'role' => 'teacher']),
            Teacher::create(['teacher_id' => 'T-3001', 'full_name' => 'Saiful Islam', 'email' => 'saiful@uni.edu.bd', 'designation' => 'Lecturer', 'phone' => '01710000004', 'password' => Hash::make('password'), 'department_id' => $departments[2]->id, 'role' => 'teacher']),
        ];

        $coordinator = Teacher::create([
            'teacher_id' => 'C-9001',
            'full_name' => 'Coordinator Rahman',
            'email' => 'coordinator@uni.edu.bd',
            'designation' => 'Coordinator',
            'phone' => '01719990001',
            'password' => Hash::make('password'),
            'department_id' => $departments[0]->id,
            'role' => 'coordinator',
        ]);

        $courses = [
            Course::create(['course_code' => 'CSE101', 'course_title' => 'Structured Programming', 'credit_hours' => 3, 'department_id' => $departments[0]->id, 'teacher_id' => $teachers[0]->id]),
            Course::create(['course_code' => 'CSE102', 'course_title' => 'Data Structures', 'credit_hours' => 3, 'department_id' => $departments[0]->id, 'teacher_id' => $teachers[1]->id]),
            Course::create(['course_code' => 'CSE201', 'course_title' => 'Database Systems', 'credit_hours' => 3, 'department_id' => $departments[0]->id, 'teacher_id' => $teachers[0]->id]),
            Course::create(['course_code' => 'EEE101', 'course_title' => 'Basic Electronics', 'credit_hours' => 3, 'department_id' => $departments[1]->id, 'teacher_id' => $teachers[2]->id]),
            Course::create(['course_code' => 'BBA101', 'course_title' => 'Principles of Management', 'credit_hours' => 3, 'department_id' => $departments[2]->id, 'teacher_id' => $teachers[3]->id]),
        ];

        $students = [
            Student::create(['student_id' => 'S-24001', 'full_name' => 'Sifat Mazib', 'email' => 'sifat.mazib@uni.edu.bd', 'phone' => '01720000001', 'batch' => '60', 'enrollment_date' => '2025-01-10', 'password' => Hash::make('password'), 'department_id' => $departments[0]->id, 'semester_id' => $semesters[0]->id]),
            Student::create(['student_id' => 'S-24002', 'full_name' => 'Tanvir Ahmed', 'email' => 'tanvir.ahmed@uni.edu.bd', 'phone' => '01720000002', 'batch' => '60', 'enrollment_date' => '2025-01-10', 'password' => Hash::make('password'), 'department_id' => $departments[0]->id, 'semester_id' => $semesters[0]->id]),
            Student::create(['student_id' => 'S-24003', 'full_name' => 'Samiha Rahman', 'email' => 'samiha.rahman@uni.edu.bd', 'phone' => '01720000003', 'batch' => '60', 'enrollment_date' => '2025-01-10', 'password' => Hash::make('password'), 'department_id' => $departments[1]->id, 'semester_id' => $semesters[1]->id]),
            Student::create(['student_id' => 'S-24004', 'full_name' => 'Nusrat Jahan', 'email' => 'nusrat.jahan@uni.edu.bd', 'phone' => '01720000004', 'batch' => '60', 'enrollment_date' => '2025-01-10', 'password' => Hash::make('password'), 'department_id' => $departments[2]->id, 'semester_id' => $semesters[2]->id]),
        ];

        foreach ($students as $student) {
            StudentLogin::create([
                'student_id' => $student->id,
                'username' => $student->student_id,
                'password' => Hash::make('password'),
            ]);
        }

        foreach ($teachers as $teacher) {
            TeacherLogin::create([
                'teacher_id' => $teacher->id,
                'username' => $teacher->teacher_id,
                'password' => Hash::make('password'),
            ]);
        }

        TeacherLogin::create([
            'teacher_id' => $coordinator->id,
            'username' => $coordinator->teacher_id,
            'password' => Hash::make('password'),
        ]);

        $enrollments = [
            Enrollment::create(['student_id' => $students[0]->id, 'course_id' => $courses[0]->id, 'semester_id' => $semesters[0]->id, 'enrollment_date' => '2025-01-15']),
            Enrollment::create(['student_id' => $students[0]->id, 'course_id' => $courses[1]->id, 'semester_id' => $semesters[0]->id, 'enrollment_date' => '2025-01-15']),
            Enrollment::create(['student_id' => $students[1]->id, 'course_id' => $courses[2]->id, 'semester_id' => $semesters[0]->id, 'enrollment_date' => '2025-01-15']),
            Enrollment::create(['student_id' => $students[2]->id, 'course_id' => $courses[3]->id, 'semester_id' => $semesters[1]->id, 'enrollment_date' => '2025-05-12']),
            Enrollment::create(['student_id' => $students[3]->id, 'course_id' => $courses[4]->id, 'semester_id' => $semesters[2]->id, 'enrollment_date' => '2025-09-10']),
        ];

        $gradeFor = function (int $total): array {
            if ($total >= 80) return ['A+', 4.00];
            if ($total >= 75) return ['A', 3.75];
            if ($total >= 70) return ['A-', 3.50];
            if ($total >= 65) return ['B+', 3.25];
            if ($total >= 60) return ['B', 3.00];
            if ($total >= 55) return ['B-', 2.75];
            if ($total >= 50) return ['C+', 2.50];
            if ($total >= 45) return ['C', 2.25];
            if ($total >= 40) return ['D', 2.00];
            return ['F', 0.00];
        };

        $makeResult = function (Enrollment $enrollment, int $mid, int $final, int $assignment, int $attendance) use ($gradeFor) {
            $total = $mid + $final + $assignment + $attendance;
            [$grade, $point] = $gradeFor($total);

            Result::create([
                'enrollment_id' => $enrollment->id,
                'mid_marks' => $mid,
                'final_marks' => $final,
                'assignment_marks' => $assignment,
                'attendance_marks' => $attendance,
                'total_marks' => $total,
                'letter_grade' => $grade,
                'grade_point' => $point,
                'gpa' => $point,
            ]);
        };

        $makeResult($enrollments[0], 25, 42, 8, 9);
        $makeResult($enrollments[1], 22, 38, 7, 9);
        $makeResult($enrollments[2], 20, 35, 8, 8);
        $makeResult($enrollments[3], 18, 30, 7, 7);
        $makeResult($enrollments[4], 24, 40, 8, 9);
    }
}
