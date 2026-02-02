<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Computer;
use App\Models\Software;
use App\Models\LabBooking;
use App\Models\Lab;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Module;
use App\Models\User;
use App\Models\BookingConfirmationMail;
use App\Models\BookingCompletionMail;
use App\Models\BookingCancelationMail;
use App\Models\Lecturer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendBookingConfirmationMail;
use App\Jobs\SendBookingCompletionMail;
use App\Jobs\SendBookingCancelationMail;
use App\Jobs\SendLecturerBookingStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\PermanentBookingSummary;

class LabBookingController extends Controller
{
    public function index(){
        $currentMonth = Carbon::now()->format('F');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Individual Exams
        $scheduledExamCount = LabBooking::where('description', 'Exam')
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [$startDate, $endDate])
            ->count();

        $completedExamCount = LabBooking::where('description', 'Exam')
            ->where('status', 'Completed')
            ->whereBetween('start', [$startDate, $endDate])
            ->count();

        $completedExamPercentage = $scheduledExamCount > 0
            ? round(($completedExamCount / $scheduledExamCount) * 100, 2)
            : 0;

        // Individual Practicals
        $scheduledPracticalCount = LabBooking::where('description', 'Practical')
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [$startDate, $endDate])
            ->count();

        $completedPracticalCount = LabBooking::where('description', 'Practical')
            ->where('status', 'Completed')
            ->whereBetween('start', [$startDate, $endDate])
            ->count();

        $completedPracticalPercentage = $scheduledPracticalCount > 0
            ? round(($completedPracticalCount / $scheduledPracticalCount) * 100, 2)
            : 0;

        // Batch Exams
        $scheduledBatchExamCount = LabBooking::where('description', 'Batch Exam')
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [$startDate, $endDate])
            ->count();

        $completedBatchExamCount = LabBooking::where('description', 'Batch Exam')
            ->where('status', 'Completed')
            ->whereBetween('start', [$startDate, $endDate])
            ->count();

        $completedBatchExamPercentage = $scheduledBatchExamCount > 0
            ? round(($completedBatchExamCount / $scheduledBatchExamCount) * 100, 2)
            : 0;

        // Batch Practicals
        $scheduledBatchPracticalCount = LabBooking::where('description', 'Batch Practical')
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [$startDate, $endDate])
            ->count();
        $completedBatchPracticalCount = LabBooking::where('description', 'Batch Practical')
            ->where('status', 'Completed')
            ->whereBetween('start', [$startDate, $endDate])
            ->count();
        $completedBatchPracticalPercentage = $scheduledBatchPracticalCount > 0
            ? round(($completedBatchPracticalCount / $scheduledBatchPracticalCount) * 100, 2)
            : 0;

        //Card Counts
        $thisWeekStartDate = Carbon::now()->startOfWeek()->format('m/d');
        $thisWeekEndDate = Carbon::now()->endOfWeek()->format('m/d');

        $thisMonthStartDate = Carbon::now()->startOfMonth()->format('m/d');
        $thisMonthEndDate = Carbon::now()->endOfMonth()->format('m/d');

        $thisWeekExamPracticalCount = LabBooking::where(function ($q) {
                $q->where('description', 'Exam')
                ->orWhere('description', 'Practical');
            })
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $thisWeekBatchExamPracticalCount = LabBooking::where(function ($q) {
                $q->where('description', 'Batch Exam')
                ->orWhere('description', 'Batch Practical');
            })
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->count();

        $thisMonthExamPracticalCount = LabBooking::where(function ($q) {
                $q->where('description', 'Exam')
                ->orWhere('description', 'Practical');
            })
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        $thisMonthBatchExamPracticalCount = LabBooking::where(function ($q) {
                $q->where('description', 'Batch Exam')
                ->orWhere('description', 'Batch Practical');
            })
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
            ->count();

        //Small Card Data
        $TrendingBatch = LabBooking::select('batch')
            ->where(function ($q) {
                $q->where('description', 'Batch Exam')
                ->orWhere('description', 'Batch Practical')
                ->orWhere('description', 'Exam')
                ->orWhere('description', 'Practical');
            })
            ->where(function ($q) {
                $q->where('status', 'Scheduled')
                ->orWhere('status', 'Completed');
            })
            ->whereBetween('start', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('batch')
            ->orderByRaw('COUNT(*) DESC')
            ->first();

        $TrendingStudent = LabBooking::selectRaw("
                SUBSTRING_INDEX(title, ' ', 1) as student_id,
                COUNT(*) as booking_count
            ")
            ->whereIn('description', ['Exam', 'Practical'])
            ->whereIn('status', ['Scheduled', 'Completed'])
            ->whereBetween('start', [Carbon::now()->subDays(30), Carbon::now()])
            ->groupBy('student_id')
            ->orderByDesc('booking_count')
            ->first();

        $busiestDay = LabBooking::selectRaw('DATE(start) as booking_date, COUNT(*) as booking_count')
            ->whereBetween('start', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->whereIn('description', ['Exam', 'Practical'])
            ->whereIn('status', ['Scheduled', 'Completed'])
            ->groupBy('booking_date')
            ->orderByDesc('booking_count')
            ->first();

        $lastMonth = Carbon::now()->subMonth()->format('F');

        return view('index', compact(
                'currentMonth',
                'scheduledExamCount',
                'completedExamCount',
                'completedExamPercentage',
                'scheduledPracticalCount',
                'completedPracticalCount',
                'completedPracticalPercentage',
                'scheduledBatchExamCount',
                'completedBatchExamCount',
                'completedBatchExamPercentage',
                'scheduledBatchPracticalCount',
                'completedBatchPracticalCount',
                'completedBatchPracticalPercentage',
                'thisWeekExamPracticalCount',
                'thisWeekStartDate',
                'thisWeekEndDate',
                'thisWeekBatchExamPracticalCount',
                'thisMonthStartDate',
                'thisMonthEndDate',
                'thisMonthExamPracticalCount',
                'thisMonthBatchExamPracticalCount',
                'TrendingBatch',
                'TrendingStudent',
                'busiestDay',
                'lastMonth'
              ));
    }

    public function getSchedules(){
        return response()->json([
            [
                'title' => 'Robotics Lab Session',
                'start' => '2025-11-09T09:00:00',
                'end'   => '2025-11-09T11:00:00'
            ],
            [
                'title' => 'AI Practical Class',
                'start' => '2025-11-10T13:00:00',
                'end'   => '2025-11-10T16:00:00'
            ]
        ]);
    }

    public function getComputers(){
        // Sample data - in real application, fetch from database
        $computers = Computer::with([
            'software' => function ($query) {
                $query->select('software.id', 'software.name')
                    ->withPivot('availability');
            }
        ])->get();

        //return to calender view with this data
        return view('computers', compact('computers'));
    }   

    public function calendar(){
        $batches = Batch::all();
        $courses = Course::all();
        $labs = Lab::all();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);
        $invigilators = User::where('role', 'invigilator')->get();
        return view('calendar', compact('batches', 'courses', 'labs', 'computers', 'invigilators'));
    }

    public function calendarTaskView(){
        $batches = Batch::all();
        $courses = Course::all();
        $labs = Lab::all();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);
        $invigilators = User::where('role', 'invigilator')->get();
        return view('calendarTaskView', compact('batches', 'courses', 'labs', 'computers', 'invigilators'));
    }

    public function students(){
        $students = LabBooking::where('description', 'Exam')
            ->orWhere('description', 'Practical')
            ->get();
        $batches = Batch::all();
        $courses = Course::all();
        $labs = Lab::all();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);
        return view('students', compact('batches', 'courses', 'labs', 'computers','students'));
    }

    public function people(){
        $users = User::all();
        $lecturers = Lecturer::all();
        return view('people', compact(['users','lecturers']));
    }

    public function holidays(){
        $holidays = LabBooking::where('is_all_day', 1)->where('description','Holiday')->get();
        // dd($holidays);
        return view('holidays', compact('holidays'));
    }

    public function addHoliday(Request $request){
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('Y-m-d');

        // Create holiday for all labs
        $labs = Lab::all();
        foreach ($labs as $lab) {
            LabBooking::create([
                'title' => $request->input('description'),
                'start' => $date . ' 08:00:00',
                'end' => $date . ' 17:30:00',
                'lab_id' => $lab->id,
                'batch' => null,
                'description' => 'Holiday',
                'lecturer' => null,
                'module' => null,
                'color' => '#FBB05C',
                'created_by' => auth()->user()->name,
                'students_count' => 0,
                'notes' => $request->input('description'),
                'is_all_day' => 1,
                'status' => 'Scheduled',
            ]);
        }

        return redirect()->back()->with('success', 'Holiday added successfully!');
    }

    public function deleteHoliday(Request $request){
        $holidayDateRange = $request->input('holiday_date');
        list($startDate, $endDate) = explode(' - ', $holidayDateRange);

        $Holidays = LabBooking::where('start', '>=', $startDate)
            ->where('end', '<=', $endDate)
            ->where('description', 'Holiday')
            ->where('is_all_day', 1)
            ->get();

        if ($Holidays->isEmpty()) {
            return redirect()->back()->with('error', 'Holiday not found!');
        }
        else{
            foreach ($Holidays as $holiday) {$Holidays->each->delete();
                $holiday->delete();
            }

            return redirect()->back()->with('success', 'Holiday deleted successfully!');
        }
    }

    public function eventStore(Request $request){
        // dd($request->all());
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'module' => 'required|max:255',
            'course' => 'required|exists:courses,id',
            'batch' => 'required|exists:batches,id',
            'lab' => 'required',
            'invigilator' => 'required|string|max:255',
            'start' => 'required',
            'end' => 'required',
        ]);
        $selectedDate = Carbon::parse($request->input('date'), 'Asia/Colombo');
        $today = Carbon::now('Asia/Colombo')->startOfDay();

        if ($selectedDate->lt($today)) {
            return redirect()->back()->with(
                'error',
                'Time travel is not supported yet! Please select a valid date.'
            );
        }

        if($request->input('start') == $request->input('end')){
            return redirect()->back()->with('error', 'Start time and end time cannot be the same.');
        }
        else if($request->input('start') > $request->input('end')){
            return redirect()->back()->with('error', 'Time travel is not supported yet! Start time cannot be after end time.');
        }

        $batch = Batch::query()
            ->leftJoin('lecturers', 'batches.lecturer_id', '=', 'lecturers.id')
            ->where('batches.id', $request->input('batch'))
            ->select(
                'batches.*',
                'lecturers.title as lecturer_title',
                'lecturers.name as lecturer_name',
                'lecturers.email as lecturer_email'
            )
            ->first();
        //dd($batch,$request->input('invigilator'));
        $title = $request->input('module') . ' - ' . $batch->batch_number;
        // $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->format('Y-m-d');
        $date = $request->input('date');

        $start = $date . ' ' . $request->input('start') . ':00';
        $end   = $date . ' ' . $request->input('end')   . ':00';

        // Prevent individual bookings if a batch exam or practical exists
        $mainLab = 1;  // Main Lab ID for individual bookings

        $conflictBatch = LabBooking::where('lab_id', $mainLab)
            ->where('status', 'Scheduled')   // ✅ Only active bookings
            ->whereDate('start', $date)
            ->whereIn('description', ['Batch Exam', 'Batch Practical','Holiday'])    // Only block exams + practicals and Holidays
            ->where(function ($query) use ($start, $end) {
                $query->where('start', '<', $end)
                    ->where('end', '>', $start);            // Overlap detection
            })
            ->first();

        if ($conflictBatch) {
            if ($conflictBatch->description == 'Holiday') {
                return redirect()->back()->with('error','Cannot reserve any lab due to a Holiday!');
            }

            return redirect()->back()->with('error',
                'Cannot reserve Main Lab. A ' . $conflictBatch->description .
                ' for batch ' . $conflictBatch->batch .
                ' is already scheduled during this time.');
        }

        if($request->input('invigilator') == 'Other'){
            $invigilatorName = $batch->lecturer_title . '. ' . $batch->lecturer_name;
        } else {
            $invigilatorName = $request->input('invigilator');
        }

        if($request->input('description') == 'Batch Exam'){
            $color = '#961446ff';
        } else if ($request->input('description') == 'Batch Practical'){
            $color = '#1b6898ff';
        } else if ($request->input('description') == 'Holiday'){
            $color = '#eeff00ff';
        }
        else {
            $color = '#686868ff'; // Default color
        }

        $booking = LabBooking::create([
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'lab_id' => $request->input('lab'),
            'batch' => $batch->batch_number,
            'description' => $request->input('description'),
            'lecturer' => $invigilatorName,
            'module' => $request->input('module'),
            'color' => $color,
            'created_by' => auth()->user()->name,
            'students_count' => $batch->student_count,
            'notes' => $request->input('notes'),
            'status' => 'Scheduled',
            // Add other fields as necessary
        ]);

        $confirmation = BookingConfirmationMail::create([
            'email' => $batch->lecturer_email,
            'booking_id' => $booking->id,
            'status' => 'Pending',
            'sent_at' => null,
        ]);
        $thisBooking = LabBooking::with(['lab'])->find($booking->id);

        dispatch(new SendLecturerBookingStatusMail($thisBooking, 'Confirmation', $confirmation->id));

        return redirect()->back()->with('success', 'Event created successfully!');
    }

    public function individualEventStore(Request $request){
        // dd($request->all());
        $request->validate([
            'date' => 'required|date',
            'student_id' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'module' => 'required|max:255',
            'course' => 'required|exists:courses,id',
            'batch' => 'required|exists:batches,id',
            'start' => 'required',
            'end' => 'required',
        ]);
        $selectedDate = Carbon::parse($request->input('date'), 'Asia/Colombo');
        $today = Carbon::now('Asia/Colombo')->startOfDay();

        if ($selectedDate->lt($today)) {
            return redirect()->back()->with(
                'error',
                'Time travel is not supported yet! Please select a valid date.'
            );
        }

        if($request->input('start') == $request->input('end')){
            return redirect()->back()->with('error', 'Start time and end time cannot be the same.');
        }
        else if($request->input('start') > $request->input('end')){
            return redirect()->back()->with('error', 'Time travel is not supported yet! Start time cannot be after end time.');
        }

        $batch = Batch::where('id', $request->input('batch'))->first();
        // dd($batch);
        $title = $request->input('student_id') . ' ' . $request->input('module');
        // $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->format('Y-m-d');
        $date = $request->input('date');

        $start = $date . ' ' . $request->input('start') . ':00';
        $end   = $date . ' ' . $request->input('end')   . ':00';

        // Prevent individual bookings if a batch exam or practical exists
        $mainLab = 1;  // Main Lab ID for individual bookings

        $conflictBatch = LabBooking::where('lab_id', $mainLab)
            ->where('status', 'Scheduled')   // ✅ Only active bookings
            ->whereDate('start', $date)
            ->whereIn('description', ['Batch Exam', 'Batch Practical','Holiday'])    // Only block exams + practicals and Holidays
            ->where(function ($query) use ($start, $end) {
                $query->where('start', '<', $end)
                    ->where('end', '>', $start);            // Overlap detection
            })
            ->first();

        if ($conflictBatch) {
            if ($conflictBatch->description == 'Holiday') {
                return redirect()->back()->with('error','Cannot reserve any lab due to a Holiday!');
            }

            return redirect()->back()->with('error',
                'Cannot reserve Main Lab. A ' . $conflictBatch->description .
                ' for batch ' . $conflictBatch->batch .
                ' is already scheduled during this time.');
        }

        if ($request->input('description') == 'Exam') {

            $color = '#d45284ff';

            // ✅ Get all active computers
            $computers = Computer::where('status', 'active')->get();

            $assignedComputerID = null;

            foreach ($computers as $computer) {

                // Check if this computer has no overlapping bookings
                $conflict = LabBooking::where('computer_id', $computer->id)
                    ->where('status', 'Scheduled')   // ✅ Only active bookings
                    ->whereDate('start', $date)
                    ->where(function ($query) use ($start, $end) {
                        $query->where('start', '<', $end)
                            ->where('end', '>', $start); // Overlap
                    })
                    ->exists();

                if (!$conflict) {
                    // ✅ First free computer found
                    $assignedComputerID = $computer->id;
                    break;
                }
            }

            if (!$assignedComputerID) {
                // ❌ No computers available
                return redirect()->back()
                    ->with('error', 'No computers are available during this time for the exam.');
            }

            $computerID = $assignedComputerID;
        }

        else if ($request->input('description') == 'Practical'){
            $color = '#55ade3ff';

            $computerID = $request->input('computer_id');
    
            if (!$computerID) {
                return redirect()->back()
                    ->with('error', 'Please select a computer for practical sessions.');
            }

            // Check if this computer is already booked at overlapping time
            $computerConflict = LabBooking::where('computer_id', $computerID)
                ->where('status', 'Scheduled')   // ✅ Only active bookings
                ->whereDate('start', $date)  // Same date
                ->where(function ($query) use ($start, $end) {
                    $query->where('start', '<', $end)
                        ->where('end', '>', $start);  // Time overlap
                })
                ->first();
            $computerLabel = Computer::where('id', $computerID)
                ->select('computer_label')
                ->first()
                ->computer_label;

            if ($computerConflict) {
                return redirect()->back()->with('error',
                    'Computer ' . $computerLabel .
                    ' is already reserved from ' . Carbon::parse($computerConflict->start)->format('h:i A') .
                    ' to '   . Carbon::parse($computerConflict->end)->format('h:i A') . '.'
                );
            }
        }
        else {
            $color = '#686868ff'; // Default color
        }

        LabBooking::create([
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'lab_id' => $mainLab, // Default lab for individual bookings
            'batch' => $batch->batch_number,
            'description' => $request->input('description'),
            'lecturer' => 'Any',
            'module' => $request->input('module'),
            'color' => $color,
            'created_by' => auth()->user()->name,
            'students_count' => 1,
            'notes' => $request->input('notes'),
            'computer_id'=> $computerID,
            'status' => 'Scheduled',
            // Add other fields as necessary
        ]);

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

    public function permanentIndividualEventStore(Request $request){
        $request->validate([
            'student_id'  => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'day'         => 'required|string',            // e.g. Monday
            'duration'    => 'required|integer|min:1',     // months
            'start'       => 'required',
            'end'         => 'required',
            'description' => 'required|string|max:255',
            'course_id'   => 'required|exists:courses,id',
            'module'      => 'required|string|max:255',
            'batch_id'    => 'required|exists:batches,id',
            'computer_id' => 'required|exists:computers,id',
        ]);

        $selectedDate = Carbon::parse($request->input('day'), 'Asia/Colombo');
        $today = Carbon::now('Asia/Colombo')->startOfDay();

        if ($selectedDate->lt($today)) {
            return redirect()->back()->with(
                'error',
                'Time travel is not supported yet! Please select a valid date.'
            );
        }

        if ($request->start >= $request->end) {
            return back()->with('error', 'End time must be after start time.');
        }

        $batch = Batch::findOrFail($request->batch_id);

        $dayName   = ucfirst(strtolower($request->day)); // Normalize
        $months    = (int) $request->duration;
        $labId     = 1; // Main Lab
        $today     = Carbon::now('Asia/Colombo')->startOfDay();
        $endDate   = $today->copy()->addMonths($months)->endOfDay();

        if ($request->input('description') == 'Exam') {
            $color = '#d45284ff';
        }
        else if ($request->input('description') == 'Practical'){
            $color = '#55ade3ff';
        }
        else{
            $color = '#686868ff'; // Default color
        }

        $reservedDates = [];
        $skippedDates  = [];

        // Find first matching weekday
        $currentDate = $today->copy();
        while ($currentDate->format('l') !== $dayName) {
            $currentDate->addDay();
        }

        while ($currentDate->lte($endDate)) {

            $date  = $currentDate->format('Y-m-d');
            $start = $date . ' ' . $request->start . ':00';
            $end   = $date . ' ' . $request->end   . ':00';

            // ❌ Block by Batch Exams / Practicals / Holidays
            $labConflict = LabBooking::where('lab_id', $labId)
                ->where('status', 'Scheduled')
                ->whereDate('start', $date)
                ->whereIn('description', ['Batch Exam', 'Batch Practical', 'Holiday'])
                ->where(function ($q) use ($start, $end) {
                    $q->where('start', '<', $end)
                    ->where('end', '>', $start);
                })
                ->exists();

            // ❌ Computer conflict
            $computerConflict = LabBooking::where('computer_id', $request->computer_id)
                ->where('status', 'Scheduled')
                ->whereDate('start', $date)
                ->where(function ($q) use ($start, $end) {
                    $q->where('start', '<', $end)
                    ->where('end', '>', $start);
                })
                ->exists();

            if ($labConflict) {
                $skippedDates[] = [
                    'date'   => $date,
                    'reason' => 'Lab unavailable (Holiday / Batch Exam / Batch Practical)'
                ];
            }
            elseif ($computerConflict) {
                $skippedDates[] = [
                    'date'   => $date,
                    'reason' => 'Selected computer already reserved'
                ];
            }
            else {
                $thisBooking = LabBooking::create([
                    'title'          => $request->student_id . ' ' . $request->module,
                    'start'          => $start,
                    'end'            => $end,
                    'lab_id'         => $labId,
                    'batch'          => $batch->batch_number,
                    'description'    => $request->description,
                    'lecturer'       => 'Any',
                    'notes'          => '# Permanent Reservation',
                    'module'         => $request->module,
                    'color'          => $color,
                    'created_by'     => auth()->user()->name,
                    'students_count' => 1,
                    'computer_id'    => $request->computer_id,
                    'status'         => 'Scheduled',
                ]);

                $confirmation = BookingConfirmationMail::create([
                    'email' => $request->input('email'),
                    'booking_id' => $thisBooking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);

                $reservedDates[] = $date;
            }

            $currentDate->addWeek(); // Next same weekday
        }

        $reservedCount = count($reservedDates);
        $skippedCount  = count($skippedDates);

        $computer = Computer::find($request->computer_id);
        $lab = Lab::find($labId);

        // 📧 Send summary email
        Mail::to($request->email)->send(
            new PermanentBookingSummary(
                $request->student_id,
                $request->module,
                $batch->batch_number,
                $request->start,
                $request->end,
                $computer->computer_label,
                $lab->lab_name,
                $reservedDates,
                $skippedDates
            )
        );

        return back()->with([
            'success' => 'Permanent booking processed successfully. Summary email sent.',
            'booking_summary' => [
                'reserved' => $reservedCount,
                'skipped'  => $skippedCount
            ]
        ]);
    }

    private function weekdayToCarbon(string $day){
        return match (strtolower($day)) {
            'monday'    => Carbon::MONDAY,
            'tuesday'   => Carbon::TUESDAY,
            'wednesday' => Carbon::WEDNESDAY,
            'thursday'  => Carbon::THURSDAY,
            'friday'    => Carbon::FRIDAY,
            'saturday'  => Carbon::SATURDAY,
            'sunday'    => Carbon::SUNDAY,
            default     => null,
        };
    }

    public function externalIndividualEventStore(Request $request){
        // dd($request->all());
        $request->validate([
            'date' => 'required|date',
            'student_id' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'module' => 'required|max:255',
            'course' => 'required|exists:courses,id',
            'batch' => 'required|exists:batches,id',
            'start' => 'required',
            'end' => 'required',
            'email' => 'required|email',
        ]);
        $selectedDate = Carbon::parse($request->input('date'), 'Asia/Colombo');
        $today = Carbon::now('Asia/Colombo')->startOfDay();

        if ($selectedDate->lt($today)) {
            return redirect()->back()->with(
                'error',
                'Time travel is not supported yet! Please select a valid date.'
            );
        }

        if($request->input('start') == $request->input('end')){
            return redirect()->back()->with('error', 'Start time and end time cannot be the same.');
        }
        else if($request->input('start') > $request->input('end')){
            return redirect()->back()->with('error', 'Time travel is not supported yet! Start time cannot be after end time.');
        }

        $batch = Batch::where('id', $request->input('batch'))->first();
        // dd($batch);
        $title = $request->input('student_id') . ' ' . $request->input('module');
        // $date = Carbon::createFromFormat('m/d/Y', $request->input('date'))->format('Y-m-d');
        $date = $request->input('date');

        $start = $date . ' ' . $request->input('start') . ':00';
        $end   = $date . ' ' . $request->input('end')   . ':00';

        // Prevent individual bookings if a batch exam or practical exists
        $mainLab = 1;  // Main Lab ID for individual bookings

        $conflictBatch = LabBooking::where('lab_id', $mainLab)
            ->where('status', 'Scheduled')   // ✅ Only active bookings
            ->whereDate('start', $date)
            ->whereIn('description', ['Batch Exam', 'Batch Practical','Holiday'])    // Only block exams + practicals
            ->where(function ($query) use ($start, $end) {
                $query->where('start', '<', $end)
                    ->where('end', '>', $start);            // Overlap detection
            })
            ->first();

        if ($conflictBatch) {
            if ($conflictBatch->description == 'Holiday') {
                return redirect()->back()->with('error','Cannot reserve any lab due to a Holiday!');
            }

            return redirect()->back()->with('error',
                'Cannot reserve the Main Lab. A ' . $conflictBatch->description .
                ' for a batch is already scheduled during this time. Try again with a different time slot.');
        }

        if ($request->input('description') == 'Exam') {

            $color = '#d45284ff';

            // ✅ Get all active computers
            $computers = Computer::where('status', 'active')->get();

            $assignedComputerID = null;

            foreach ($computers as $computer) {

                // Check if this computer has no overlapping bookings
                $conflict = LabBooking::where('computer_id', $computer->id)
                    ->where('status', 'Scheduled')   // ✅ Only active bookings
                    ->whereDate('start', $date)
                    ->where(function ($query) use ($start, $end) {
                        $query->where('start', '<', $end)
                            ->where('end', '>', $start); // Overlap
                    })
                    ->exists();

                if (!$conflict) {
                    // ✅ First free computer found
                    $assignedComputerID = $computer->id;
                    break;
                }
            }

            if (!$assignedComputerID) {
                // ❌ No computers available
                return redirect()->back()
                    ->with('error', 'No computers are available during this time for the exam.');
            }

            $computerID = $assignedComputerID;
        }

        else if ($request->input('description') == 'Practical'){
            $color = '#55ade3ff';

            $computerID = $request->input('computer_id');
    
            if (!$computerID) {
                return redirect()->back()
                    ->with('error', 'Please select a computer for practical sessions.');
            }

            // Check if this computer is already booked at overlapping time
            $computerConflict = LabBooking::where('computer_id', $computerID)
                ->where('status', 'Scheduled')   // ✅ Only active bookings
                ->whereDate('start', $date)  // Same date
                ->where(function ($query) use ($start, $end) {
                    $query->where('start', '<', $end)
                        ->where('end', '>', $start);  // Time overlap
                })
                ->first();
            $computerLabel = Computer::where('id', $computerID)
                ->select('computer_label')
                ->first()
                ->computer_label;

            if ($computerConflict) {
                return redirect()->back()->with('error',
                    'Computer ' . $computerLabel .
                    ' is already reserved from ' . Carbon::parse($computerConflict->start)->format('h:i A') .
                    ' to '   . Carbon::parse($computerConflict->end)->format('h:i A') . '.'
                );
            }
        }
        else {
            $color = '#686868ff'; // Default color
        }

        $booking = LabBooking::create([
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'lab_id' => $mainLab, // Default lab for individual bookings
            'batch' => $batch->batch_number,
            'description' => $request->input('description'),
            'lecturer' => 'Any',
            'module' => $request->input('module'),
            'color' => $color,
            'created_by' => $request->input('student_id'),
            'students_count' => 1,
            'notes' => $request->input('notes'),
            'computer_id'=> $computerID,
            'status' => 'Scheduled',
        ]);

        $confirmation = BookingConfirmationMail::create([
            'email' => $request->input('email'),
            'booking_id' => $booking->id,
            'status' => 'Pending',
            'sent_at' => null,
        ]);
        $thisBooking = LabBooking::with(['lab', 'computer'])->find($booking->id);

        dispatch(new SendBookingConfirmationMail($thisBooking, $confirmation));

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

    public function bookingComplete(Request $request){
        $Booking = LabBooking::find($request->booking_id);

        if (!$Booking) {
            return redirect()->back()->with('error', 'Booking not found!');
        }

        if($Booking->description == 'Holiday'){
            return redirect()->back()->with('error', 'Holidays cannot be completed. Please contact admin.');
        }
        $isGotConfirmation = BookingConfirmationMail::where('booking_id',$request->booking_id)->first();
        if($isGotConfirmation){
            $isGotConfirmation->status = 'Completed';
            $isGotConfirmation->save();

            //Send Completion Email for Individuals
            if($Booking->description == 'Exam' || $Booking->description == 'Practical'){
                $completion = BookingCompletionMail::create([
                    'email' => $isGotConfirmation->email,
                    'booking_id' => $Booking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);
                $thisBooking = LabBooking::with(['lab', 'computer'])->find($Booking->id);

                dispatch(new SendBookingCompletionMail($thisBooking, $completion));
            }
            
            else{
                //Send Completion Email for Batches
                $completion = BookingCompletionMail::create([
                    'email' => $isGotConfirmation->email,
                    'booking_id' => $Booking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);
                $thisBooking = LabBooking::with(['lab'])->find($Booking->id);

                dispatch(new SendLecturerBookingStatusMail($thisBooking, 'Completion', $completion->id));
            }
            
        }

        $Booking->status = 'Completed';
        $Booking->color = '#28A745';
        $Booking->save();

        return redirect()->back()->with('success', 'Event marked as Completed!');
    }

    public function bookingCancel(Request $request){
        $Booking = LabBooking::find($request->booking_id);

        if (!$Booking) {
            return redirect()->back()->with('error', 'Booking not found!');
        }

        if($Booking->description == 'Holiday'){
            return redirect()->back()->with('error', 'Holidays cannot be cancelled. Please contact admin.');
        }

        $isGotConfirmation = BookingConfirmationMail::where('booking_id',$request->booking_id)->first();
        if($isGotConfirmation){
            $isGotConfirmation->status = 'Cancelled';
            $isGotConfirmation->save();

            //Send Cancelation Email for Individuals
            if($Booking->description == 'Exam' || $Booking->description == 'Practical'){
                 $cancellation = BookingCancelationMail::create([
                    'email' => $isGotConfirmation->email,
                    'booking_id' => $Booking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);
                $thisBooking = LabBooking::with(['lab', 'computer'])->find($Booking->id);

                dispatch(new SendBookingCancelationMail($thisBooking, $cancellation));
            }
            
            else{
                //Send Cancelation Email for Batches
                $cancellation = BookingCancelationMail::create([
                    'email' => $isGotConfirmation->email,
                    'booking_id' => $Booking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);
                $thisBooking = LabBooking::with(['lab'])->find($Booking->id);

                dispatch(new SendLecturerBookingStatusMail($thisBooking, 'Cancellation', $cancellation->id));
            }
        }

        $Booking->status = 'Cancelled';
        $Booking->color = '#E0A800';
        $Booking->save();

        return redirect()->back()->with('success', 'Event marked as Cancelled!');
    }

    public function bookingDelete(Request $request){
        $Booking = LabBooking::find($request->booking_id);

        if (!$Booking) {
            return redirect()->back()->with('error', 'Booking not found!');
        }

        if($Booking->description == 'Holiday'){
            return redirect()->back()->with('error', 'Holidays cannot be deleted. Please contact admin.');
        }

        $isGotConfirmation = BookingConfirmationMail::where('booking_id',$request->booking_id)->first();
        if($isGotConfirmation){
            $isGotConfirmation->status = 'Cancelled';
            $isGotConfirmation->save();

            //Send Cancelation Email for Individuals
            if($Booking->description == 'Exam' || $Booking->description == 'Practical'){
                 $cancellation = BookingCancelationMail::create([
                    'email' => $isGotConfirmation->email,
                    'booking_id' => $Booking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);
                $thisBooking = LabBooking::with(['lab', 'computer'])->find($Booking->id);

                dispatch(new SendBookingCancelationMail($thisBooking, $cancellation));
            }
            
            else{
                //Send Cancelation Email for Batches
                $cancellation = BookingCancelationMail::create([
                    'email' => $isGotConfirmation->email,
                    'booking_id' => $Booking->id,
                    'status' => 'Pending',
                    'sent_at' => null,
                ]);
                $thisBooking = LabBooking::with(['lab'])->find($Booking->id);

                dispatch(new SendLecturerBookingStatusMail($thisBooking, 'Cancellation', $cancellation->id));
            }
        }

        $Booking->status = 'Deleted';
        $Booking->color = '#C82333';
        $Booking->save();

        return redirect()->back()->with('success', 'Event marked as Deleted!');
    }

    public function getEvents(){
        $events = LabBooking::with(['lab', 'computer'])->get()->map(function ($booking) {
            return [
                'id'    => $booking->id,
                'title' => $booking->title,
                'start' => Carbon::parse($booking->start)->format('Y-m-d H:i:s'),
                'end'   => Carbon::parse($booking->end)->format('Y-m-d H:i:s'),
                'color' => $booking->color ?? '#007bff',

                'extendedProps' => [
                    'lab'           => $booking->lab->lab_name ?? 'Unknown',
                    'lecturer'      => $booking->lecturer,
                    'module'        => $booking->module,
                    'batch'         => $booking->batch,
                    'description'   => $booking->description,
                    'student_count' => $booking->students_count,
                    'notes'         => $booking->notes,
                    'computer_id'   => $booking->computer_id,
                    'computer_label' => optional($booking->computer)->computer_label,
                    'created_by'    => $booking->created_by,
                    'status'        => $booking->status,
                ]
            ];
        });

        return response()->json($events);
    }

    public function getBookingTable(Request $request){
        $range = $request->get('range', 'day');

        $query = LabBooking::with(['lab', 'computer']);

        if ($range === 'day') {
            $query->whereDate('start', today());
        }

        if ($range === 'week') {
            $query->whereBetween('start', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        }

        if ($range === 'month') {
            $query->whereMonth('start', now()->month)
                ->whereYear('start', now()->year);
        }

        $bookings = $query->orderBy('start')->get()->map(function ($booking) {

            // ✅ Title logic
            if ($booking->description === 'Holiday') {
                // Keep title exactly as stored
                $title = $booking->title;
            } else {
                // Existing logic
                $title = str_contains($booking->description, 'Batch')
                    ? $booking->batch
                    : explode(' ', $booking->title)[0]; // student id only
            }

            return [
                'id'       => $booking->id,
                'type'     => $booking->description,
                'title'    => $title,
                'module'   => $booking->module,

                'date'     => \Carbon\Carbon::parse($booking->start)->format('Y-m-d'),
                'start'    => \Carbon\Carbon::parse($booking->start)->format('H:i'),
                'end'      => \Carbon\Carbon::parse($booking->end)->format('H:i'),

                'lab'      => $booking->lab->lab_name ?? 'N/A',
                'computer' => optional($booking->computer)->computer_label ?? '—',
                'status'   => $booking->status,

                // keep full object for modal & color usage
                'raw'      => $booking,
            ];
        });

        return response()->json($bookings);
    }

    public function getModules($course_id){
        $modules = Module::where('course_id', $course_id)
                        ->orderBy('module_number', 'asc')
                        ->get(['id', 'module_number', 'name']);

        return response()->json($modules);
    }

    public function getModuleDuration($id){
        $module = Module::findOrFail($id);

        return response()->json([
            'exam_duration' => $module->exam_duration
        ]);
    }

    public function getActiveComputers(){
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);

        return response()->json($computers);
    }

    public function getComputerDetails($id){
        $computer = Computer::with('software')->findOrFail($id);

        // Build response array
        $softwareList = [];

        foreach ($computer->software as $soft) {
            $softwareList[$soft->name] = $soft->pivot->availability;
        }

        return response()->json([
            'label'    => $computer->computer_label,
            'software' => $softwareList
        ]);
    }

    public function studentBooking(){
        $batches = Batch::all();
        $courses = Course::all();
        $labs = Lab::all();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);
        return view('studentBooking', compact('batches', 'courses', 'labs', 'computers'));
    }

    public function getHolidays(){
        $year = now()->year;

        $month = now()->month;

        $response = Http::withHeaders([
                'Accept' => 'application/json',
                'X-API-Key' => 'SLHAPIg3iWAr5ZrB4vUJqfu8tqMG',
            ])
            ->get('https://srilanka-holidays.vercel.app/api/v1/holidays', [
                'year' => $year,
                'month' => $month,
                'format' => 'full'
            ]);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Failed to fetch holidays',
                'status' => $response->status(),
                'body' => $response->body()
            ], 500);
        }

        return response()->json($response->json());
    }

}
