<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    protected $table = 'lecturers';

    protected $fillable = [
        'title',
        'name',
        'email',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $primaryKey = 'id';
}
