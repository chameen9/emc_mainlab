<?php

namespace App\Mail;

use App\Models\LabBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public LabBooking $booking;

    public function __construct(LabBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this
            ->subject('⏰ Lab Booking Reminder – Tomorrow')
            ->markdown('Mails.BookingReminder')
            ->with([
                'booking' => $this->booking,
            ]);
    }
}