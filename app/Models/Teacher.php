<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'full_name', 'email', 'designation', 'phone', 'password', 'department_id', 'role'];

    protected $hidden = ['password'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function login()
    {
        return $this->hasOne(TeacherLogin::class);
    }
}
