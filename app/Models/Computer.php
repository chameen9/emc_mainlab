<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Computer extends Model
{
    protected $fillable = [
        'lab_id',
        'computer_label',
        'status',
        'specs',
        'notes',
    ];

    public function lab()
    {
        return $this->belongsTo(Lab::class);
    }

    public function bookings()
    {
        return $this->hasMany(LabBooking::class);
    }

    public function software()
    {
        return $this->belongsToMany(Software::class, 'computer_software')
                    ->withPivot('availability');
    }
}
