<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Models\LabBooking;
use Illuminate\Support\Facades\Log;
use App\Models\BookingConfirmationMail;
use Carbon\Carbon;

class SendBookingConfirmationMail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $booking;
    public $confirmation;

    public function __construct(LabBooking $booking, BookingConfirmationMail $confirmation)
    {
        $this->booking = $booking;
        $this->confirmation = $confirmation;
    }

    public function handle()
    {
        Mail::to($this->confirmation->email)
            ->send(new BookingConfirmation($this->booking));

        //Log::info('Booking confirmation email sent to: ' . $this->confirmation->email);

        $this->confirmation->update([
            'status' => 'Sent',
            'sent_at' => Carbon::now('Asia/Colombo'),
        ]);
    }
}
