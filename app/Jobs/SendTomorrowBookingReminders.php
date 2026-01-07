<?php

namespace App\Jobs;

use App\Models\LabBooking;
use App\Models\BookingConfirmationMail;
use App\Mail\BookingReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendTomorrowBookingReminders implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $tomorrow = Carbon::tomorrow('Asia/Colombo')->toDateString();

        // Get bookings scheduled for tomorrow
        $bookings = LabBooking::with(['lab', 'computer'])
            ->whereDate('start', $tomorrow)
            ->where('status', 'Scheduled')
            ->get();

        foreach ($bookings as $booking) {

            // Get email(s) from BookingConfirmationMail
            $confirmations = BookingConfirmationMail::where('booking_id', $booking->id)
                 ->whereIn('status', ['Sent', 'Pending'])
                ->whereNotNull('email')
                ->get();

            foreach ($confirmations as $confirmation) {
                Mail::to($confirmation->email)
                    ->send(new BookingReminderMail($booking));
            }
        }
    }
}