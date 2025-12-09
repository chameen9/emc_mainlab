<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'module_number',
        'name',
        'course_id',
        'exam_duration',
    ];

    /**
     * A module belongs to one course.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Optional - If bookings reference a module
     * This allows: $module->bookings
     */
    public function bookings()
    {
        return $this->hasMany(LabBooking::class, 'module_id');
    }
}
