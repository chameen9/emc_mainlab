<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class PermanentBookingSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $studentId;
    public $module;
    public $batch;
    public $start;
    public $end;
    public $computerLabel;
    public $labName;
    public $reservedDates;
    public $skippedDates;
    public $reservedCount;
    public $skippedCount;

    public function __construct(
        $studentId,
        $module,
        $batch,
        $start,
        $end,
        $computerLabel,
        $labName,
        $reservedDates,
        $skippedDates
    ) {
        $this->studentId     = $studentId;
        $this->module        = $module;
        $this->batch         = $batch;
        $this->start         = $start;
        $this->end           = $end;
        $this->labName       = $labName;
        $this->computerLabel = $computerLabel;
        $this->reservedDates = $reservedDates;
        $this->skippedDates  = $skippedDates;

        // ✅ DEFINE COUNTS HERE
        $this->reservedCount = count($reservedDates);
        $this->skippedCount  = count($skippedDates);
    }

    public function build()
    {
        return $this
            ->subject('Permanent Lab Booking Summary')
            ->markdown('Mails.permanentBookingSummary');
    }
}