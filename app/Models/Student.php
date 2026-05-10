<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'full_name', 'email', 'phone', 'batch', 'enrollment_date', 'password', 'department_id', 'semester_id'
    ];

    protected $hidden = ['password'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function login()
    {
        return $this->hasOne(StudentLogin::class);
    }
}
