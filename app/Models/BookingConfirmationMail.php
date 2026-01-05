<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingConfirmationMail extends Model
{
    protected $table = 'lab_booking_confirmation_mails';

    protected $fillable = [
        'email',
        'booking_id',
        'status',
        'sent_at'
    ];

    protected $primaryKey = 'id';

    protected $defaultTimestamps = false;
}