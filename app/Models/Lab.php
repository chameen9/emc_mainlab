<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{


    protected $fillable = [
        'lab_name',
        'location',
        'total_computers',
    ];

    public function computers()
    {
        return $this->hasMany(Computer::class);
    }

    public function bookings()
    {
        return $this->hasMany(LabBooking::class);
    }
}
