<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\LecturerBookingStatus;
use App\Models\LabBooking;
use Illuminate\Support\Facades\Log;
use App\Models\BookingConfirmationMail;
use App\Models\BookingCancelationMail;
use App\Models\BookingCompletionMail;
use Carbon\Carbon;

class SendLecturerBookingStatusMail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $booking;
    public $status;
    public $id;

    public function __construct(LabBooking $booking, string $status, int $id)
    {
        $this->booking = $booking;
        $this->status = $status;
        $this->id = $id;
    }

    public function handle()
    {
        //Log::info('Booking confirmation email sent to: ' . $this->confirmation->email);

        if ($this->status == 'Confirmation') {
            $this->confirmation = BookingConfirmationMail::find($this->id);
        }
        elseif ($this->status == 'Cancellation') {
            $this->confirmation = BookingCancelationMail::find($this->id);
        }
        elseif ($this->status == 'Deleted') {
            $this->confirmation = BookingCancelationMail::find($this->id);
        }
        elseif ($this->status == 'Completion') {
            $this->confirmation = BookingCompletionMail::find($this->id);
        }

        Mail::to($this->confirmation->email)
            ->send(new LecturerBookingStatus($this->booking));

        $this->confirmation->update([
            'status' => 'Sent',
            'sent_at' => Carbon::now('Asia/Colombo'),
        ]);
    }
}
