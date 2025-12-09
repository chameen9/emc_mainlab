<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{


    protected $fillable = [
        'name'
    ];

    public function computers()
    {
        return $this->belongsToMany(Computer::class, 'computer_software')
            ->withPivot('availability')
            ->withTimestamps();
    }
}
