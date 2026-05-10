<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'enrollment_id', 'mid_marks', 'final_marks', 'assignment_marks', 'attendance_marks',
        'total_marks', 'letter_grade', 'grade_point', 'gpa'
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function histories()
    {
        return $this->hasMany(ResultHistory::class);
    }
}
