<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabBooking extends Model
{


    protected $fillable = [
        'title',
        'start',
        'end',
        'lab_id',
        'computer_id',
        'batch',
        'lecturer',
        'module',
        'description',
        'students_count',
        'color',
        'created_by',
        'status',
        'notes',
        'is_all_day'
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function computer()
    {
        return $this->belongsTo(Computer::class, 'computer_id');
    }
}
