<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\LabBooking;
use App\Models\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\BookingReminderMail;
use Illuminate\Support\Facades\Log;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'bookings:send-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Send reminder emails for bookings scheduled for tomorrow';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $tomorrow = Carbon::tomorrow('Asia/Colombo')->toDateString();

        Log::info('Booking reminder job started for date: '.$tomorrow);

        $confirmations = BookingConfirmationMail::whereHas('booking', function ($q) use ($tomorrow) {
                $q->whereDate('start', $tomorrow)
                  ->where('status', 'Scheduled');
            })
            ->where(function ($q) {
                $q->whereNull('status')
                  ->orWhere('status', '!=', 'Cancelled');
            })
            ->with('booking.lab', 'booking.computer')
            ->get();

        if ($confirmations->isEmpty()) {
            Log::info('No booking reminders to send.');
            $this->info('No reminders found.');
            return Command::SUCCESS;
        }

        foreach ($confirmations as $confirmation) {

            try {
                Mail::to($confirmation->email)
                    ->send(new BookingReminderMail($confirmation->booking));

                $confirmation->update([
                    'status'  => 'Sent',
                    'sent_at'=> Carbon::now('Asia/Colombo')
                ]);

                Log::info('Reminder sent to '.$confirmation->email.' for booking ID '.$confirmation->booking_id);

            } catch (\Exception $e) {
                Log::error('Reminder mail failed', [
                    'email' => $confirmation->email,
                    'booking_id' => $confirmation->booking_id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->info('Booking reminders sent successfully.');

        return Command::SUCCESS;
    }
}
