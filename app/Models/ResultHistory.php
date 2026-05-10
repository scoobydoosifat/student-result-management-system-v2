<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultHistory extends Model
{
    use HasFactory;

    public const UPDATED_AT = 'updated_at';

    protected $fillable = ['result_id', 'old_total_marks', 'old_grade'];

    public function result()
    {
        return $this->belongsTo(Result::class);
    }
}
