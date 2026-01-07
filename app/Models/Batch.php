<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'course_id',
        'batch_number',
        'status',
        'lecturer_id',
        'student_count',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
