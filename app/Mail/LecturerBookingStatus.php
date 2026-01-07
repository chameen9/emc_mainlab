<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\LabBooking;
use Illuminate\Support\Facades\Log;

class LecturerBookingStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(LabBooking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        if ($this->booking->status == 'Scheduled') {
            $subjectPrefix = 'Booking Confirmation';
        } elseif ($this->booking->status == 'Completed') {
            $subjectPrefix = 'Booking Completed';
        } elseif ($this->booking->status == 'Cancelled') {
            $subjectPrefix = 'Booking Cancelled';
        } else {
            $subjectPrefix = 'Lab Booking Deleted';
        }
        //Log::info('Building booking confirmation email for booking ID: ' . $this->booking->id);
        return $this
            ->subject($this->booking->batch . ' - ' . $subjectPrefix)
            ->markdown('Mails.LecturerBookingStatus');
    }
}
