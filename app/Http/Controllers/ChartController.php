<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Computer;
use App\Models\ComputerSoftware;
use App\Models\Course;
use App\Models\Lab;
use App\Models\LabBooking;
use App\Models\Module;
use App\Models\Software;
use App\Models\User;


class ChartController extends Controller
{
    public function monthlyStudentBookingsChart(Request $request){
        $startDate = now()->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $bookings = LabBooking::where('description', 'Exam')
            ->orWhere('description', 'Practical')
            ->whereBetween('start', [$startDate, $endDate])
            ->selectRaw('DATE(start) as booking_date, COUNT(*) as booking_count')
            ->groupBy('booking_date')
            ->get()
            ->keyBy('booking_date');

        $labels = [];
        $data = [];
        $maxValue = 0;

        $daysInMonth = $startDate->daysInMonth;
        for ($i = 0; $i < $daysInMonth; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->format('d');
            $labels[] = $dateStr;
            $bookingCount = $bookings->get($date->format('Y-m-d'))->booking_count ?? 0;
            $data[] = $bookingCount;

            if ($bookingCount > $maxValue) {
            $maxValue = $bookingCount;
            }
        }

        //For batchs
        $batchBookings = LabBooking::where('description', 'Batch Exam')
            ->orWhere('description', 'Batch Practical')
            ->whereBetween('start', [$startDate, $endDate])
            ->selectRaw('DATE(start) as booking_date, COUNT(*) as booking_count')
            ->groupBy('booking_date')
            ->get()
            ->keyBy('booking_date');

        $batchlabels = [];
        $batchdata = [];

        $daysInMonth = $startDate->daysInMonth;
        for ($i = 0; $i < $daysInMonth; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->format('d');
            $batchlabels[] = $dateStr;
            $bookingCount = $batchBookings->get($date->format('Y-m-d'))->booking_count ?? 0;
            $batchdata[] = $bookingCount;

            if ($bookingCount > $maxValue) {
            $maxValue = $bookingCount;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            //'batch_data' => $batchdata,
            'max_value' => $maxValue,
        ]);
    }

    public function weeklyBatchBookingsChart(Request $request){
        $startDate = now()->startOfWeek();
        $endDate = $startDate->copy()->addDays(6);

        $bookings = LabBooking::where('description', 'Batch Exam')
            ->orWhere('description', 'Batch Practical')
            ->whereBetween('start', [$startDate, $endDate])
            ->selectRaw('DATE(start) as booking_date, COUNT(*) as booking_count')
            ->groupBy('booking_date')
            ->get()
            ->keyBy('booking_date');

        $labels = [];
        $data = [];
        $maxValue = 0; // Initialize max value

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->format('m-d'); // Removed the year value
            $labels[] = $dateStr;
            $bookingCount = $bookings->get($date->format('Y-m-d'))->booking_count ?? 0;
            $data[] = $bookingCount;

            // Update max value
            if ($bookingCount > $maxValue) {
            $maxValue = $bookingCount;
            }
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'max_value' => $maxValue, // Include max value in the response
        ]);
    }

    public function comparisonChart(Request $request){
        $startDate = now()->startOfMonth();
        $endDate   = now()->endOfMonth();

        $counts = LabBooking::whereBetween('start', [$startDate, $endDate])
            ->whereNotIn('description', [
                'Batch Exam',
                'Batch Practical',
                'Holiday'
            ])
            ->selectRaw("
                SUM(status = 'Scheduled') as scheduled,
                SUM(status = 'Completed') as completed,
                SUM(status = 'Cancelled') as cancelled,
                SUM(status = 'Deleted')   as deleted
            ")
            ->first();

        return response()->json([
            'Scheduled' => (int) $counts->scheduled,
            'Completed' => (int) $counts->completed,
            'Cancelled' => (int) $counts->cancelled,
            'Deleted'   => (int) $counts->deleted,
        ]);
    }

}
