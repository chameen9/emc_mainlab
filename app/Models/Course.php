<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_code',
        'name',
    ];

    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}
