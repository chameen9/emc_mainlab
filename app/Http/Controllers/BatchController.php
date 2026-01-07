<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;
use App\Models\LabBooking;
use App\Models\Lab;
use App\Models\Computer;
use App\Models\Lecturer;

class BatchController extends Controller
{
    public function index(){
        $batches = Batch::join('courses', 'batches.course_id', '=', 'courses.id')
            ->leftJoin('lecturers', 'batches.lecturer_id', '=', 'lecturers.id')
            ->select(
                'batches.*',
                'courses.course_code as course_code',
                'lecturers.title as lecturer_title',
                'lecturers.name as lecturer_name'
            )
            ->get();
        $courses = Course::all();
        $students = LabBooking::where('description', 'Exam')
            ->orWhere('description', 'Practical')
            ->get();
        $statuses = Batch::select('status')->distinct()->get();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);

        $lecturers = Lecturer::where('status', 'active')->get();

        return view('batches', compact('batches', 'courses', 'computers','students', 'statuses', 'lecturers'));
    }

    // Ajax call to get batches based on course id
    public function getBatches($course_id){
        $batches = Batch::query()
            ->join('courses', 'batches.course_id', '=', 'courses.id')
            ->leftJoin('lecturers', 'batches.lecturer_id', '=', 'lecturers.id')
            ->where('batches.course_id', $course_id)
            ->whereIn('batches.status', ['Active', 'Scheduled'])
            ->select(
                'batches.*',
                'courses.course_code as course_code',
                'lecturers.title as lecturer_title',
                'lecturers.name as lecturer_name',
                'lecturers.id as lec_id',
            )
            ->orderBy('batches.batch_number', 'desc')
            ->get();

        return response()->json($batches);
    }

    public function filterBatches(Request $request){
        $query = Batch::query()
            ->join('courses', 'batches.course_id', '=', 'courses.id')
            ->leftJoin('lecturers', 'batches.lecturer_id', '=', 'lecturers.id')
            ->select(
                'batches.*',
                'courses.course_code as course_code',
                'lecturers.title as lecturer_title',
                'lecturers.id as lecturer_id',
                'lecturers.name as lecturer_name',
            );

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('batches.status', $request->status);
        }

        // Course filter
        if ($request->filled('course') && $request->course !== 'all') {
            $query->where('batches.course_id', $request->course);
        }

        $batches = $query
            ->orderBy('batches.batch_number', 'desc')
            ->get();

        return response()->json([
            'count' => $batches->count(),
            'html'  => view('Partials.Batch.batchlist', compact('batches'))->render()
        ]);
    }

    public function store(Request $request){
        //dd($request->all());
        $existingBatch = Batch::where('batch_number', $request->batch_number)->first();
        if ($existingBatch) {
            return back()->with('error', 'Batch already exists.');
        }
        $batch = new Batch();
        $batch->course_id = $request->course_id;
        $batch->batch_number = $request->batch_number;
        $batch->status = $request->status;
        $batch->lecturer_id = $request->lecturer_id;
        $batch->student_count = $request->student_count;
        $batch->save();

        return back()->with('success', 'Batch created successfully.');
    }

    public function update(Request $request){
        //dd($request->all());
        $request->validate([
            'status'        => 'required|string',
            'lecturer_id'   => 'nullable|exists:lecturers,id',
            'student_count' => 'required|integer|min:0'
        ]);

        $batch = Batch::findOrFail($request->batch_id);

        $batch->update([
            'status'        => $request->status,
            'lecturer_id'   => $request->lecturer_id,
            'student_count' => $request->student_count
        ]);
        //dd($request->all());

        return back()->with('success', 'Batch updated successfully.');
    }

}
