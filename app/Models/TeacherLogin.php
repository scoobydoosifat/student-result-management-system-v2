<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLogin extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'username', 'password'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
