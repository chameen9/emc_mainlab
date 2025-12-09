<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComputerSoftware extends Model
{


    protected $table = 'computer_software';

    protected $fillable = [
        'computer_id',
        'software_id',
        'availability',
    ];

    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }

    public function software()
    {
        return $this->belongsTo(Software::class);
    }
}
