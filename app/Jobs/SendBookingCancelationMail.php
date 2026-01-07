<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelation;
use App\Models\LabBooking;
use Illuminate\Support\Facades\Log;
use App\Models\BookingCancelationMail;
use Carbon\Carbon;

class SendBookingCancelationMail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $booking;
    public $cancellation;

    public function __construct(LabBooking $booking, BookingCancelationMail $cancellation)
    {
        $this->booking = $booking;
        $this->cancellation = $cancellation;
    }

    public function handle()
    {
        Mail::to($this->cancellation->email)
            ->send(new BookingCancelation($this->booking));

        //Log::info('Booking cancelation email sent to: ' . $this->cancellation->email);

        $this->cancellation->update([
            'status' => 'Sent',
            'sent_at' => Carbon::now('Asia/Colombo'),
        ]);
    }
}
