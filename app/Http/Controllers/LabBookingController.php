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
use Carbon\Carbon;

class LabBookingController extends Controller
{
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
        return view('calendar', compact('batches', 'courses', 'labs', 'computers'));
    }

    public function batches(){
        $batches = Batch::join('courses', 'batches.course_id', '=', 'courses.id')
            ->select('batches.*', 'courses.course_code as course_code')
            ->get();
        $courses = Course::all();
        $students = LabBooking::where('description', 'Exam')
            ->orWhere('description', 'Practical')
            ->get();
        $labs = Lab::all();
        $statuses = Batch::select('status')->distinct()->get();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);
        return view('batches', compact('batches', 'courses', 'labs', 'computers','students', 'statuses'));
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

    public function getBatches($course_id){
        $batches = Batch::where('course_id', $course_id)
                        ->orderBy('batch_number', 'asc')
                        ->get(['id', 'batch_number']);

        return response()->json($batches);
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
        if($request->input('date') < Carbon::now()->format('m/d/Y')){
            return redirect()->back()->with('error', 'Time travel is not supported yet! Please select a valid date.');
        }

        if($request->input('start') == $request->input('end')){
            return redirect()->back()->with('error', 'Start time and end time cannot be the same.');
        }
        else if($request->input('start') > $request->input('end')){
            return redirect()->back()->with('error', 'Time travel is not supported yet! Start time cannot be after end time.');
        }

        $batch = Batch::where('id', $request->input('batch'))->first();
        // dd($batch);
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
            ->whereIn('description', ['Batch Exam', 'Batch Practical'])    // Only block exams + practicals
            ->where(function ($query) use ($start, $end) {
                $query->where('start', '<', $end)
                    ->where('end', '>', $start);            // Overlap detection
            })
            ->first();

        if ($conflictBatch) {
            return redirect()->back()->with('error',
                'Cannot reserve Main Lab. A ' . $conflictBatch->description .
                ' for batch ' . $conflictBatch->batch .
                ' is already scheduled during this time.');
        }

        if($request->input('invigilator') == 'other'){
            $invigilatorName = $batch->owner;
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

        LabBooking::create([
            'title' => $title,
            'start' => $start,
            'end' => $end,
            'lab_id' => $request->input('lab'),
            'batch' => $batch->batch_number,
            'description' => $request->input('description'),
            'lecturer' => $invigilatorName,
            'module' => $request->input('module'),
            'color' => $color,
            'created_by' => 'Chameen',
            'students_count' => $batch->student_count,
            'notes' => $request->input('notes'),
            'status' => 'Scheduled',
            // Add other fields as necessary
        ]);

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
        if($request->input('date') < Carbon::now()->format('m/d/Y')){
            return redirect()->back()->with('error', 'Time travel is not supported yet! Please select a valid date.');
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
            ->whereIn('description', ['Batch Exam', 'Batch Practical'])    // Only block exams + practicals
            ->where(function ($query) use ($start, $end) {
                $query->where('start', '<', $end)
                    ->where('end', '>', $start);            // Overlap detection
            })
            ->first();

        if ($conflictBatch) {
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
            'created_by' => 'Chameen',
            'students_count' => 1,
            'notes' => $request->input('notes'),
            'computer_id'=> $computerID,
            'status' => 'Scheduled',
            // Add other fields as necessary
        ]);

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

    public function bookingComplete(Request $request){
        $Booking = LabBooking::find($request->booking_id);

        if (!$Booking) {
            return redirect()->back()->with('error', 'Booking not found!');
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
                    'student_count' => $booking->student_count,
                    'notes'         => $booking->notes,
                    'computer_id'   => $booking->computer_id,
                    'computer_label' => optional($booking->computer)->computer_label,
                    'created_by'    => $booking->created_by
                ]
            ];
        });

        return response()->json($events);
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

}
