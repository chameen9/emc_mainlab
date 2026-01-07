<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCompletion;
use App\Models\LabBooking;
use Illuminate\Support\Facades\Log;
use App\Models\BookingCompletionMail;
use Carbon\Carbon;

class SendBookingCompletionMail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $booking;
    public $completion;

    public function __construct(LabBooking $booking, BookingCompletionMail $completion)
    {
        $this->booking = $booking;
        $this->completion = $completion;
    }

    public function handle()
    {
        Mail::to($this->completion->email)
            ->send(new BookingCompletion($this->booking));

        //Log::info('Booking completion email sent to: ' . $this->completion->email);

        $this->completion->update([
            'status' => 'Sent',
            'sent_at' => Carbon::now('Asia/Colombo'),
        ]);
    }
}
