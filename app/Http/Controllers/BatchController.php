<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;
use App\Models\LabBooking;
use App\Models\Lab;
use App\Models\Computer;

class BatchController extends Controller
{
    public function index(){
        $batches = Batch::join('courses', 'batches.course_id', '=', 'courses.id')
            ->select('batches.*', 'courses.course_code as course_code')
            ->get();
        $courses = Course::all();
        $students = LabBooking::where('description', 'Exam')
            ->orWhere('description', 'Practical')
            ->get();
        $statuses = Batch::select('status')->distinct()->get();
        $computers = Computer::where('status', 'active')
            ->get(['id', 'computer_label', 'lab_id']);
        return view('batches', compact('batches', 'courses', 'computers','students', 'statuses'));
    }

    //Ajax call to get batches based on course id
    public function getBatches($course_id){
        $batches = Batch::where('course_id', $course_id)
            ->whereIn('status', ['Active', 'Scheduled'])
            ->orderBy('batch_number', 'desc')
            ->get([
                'id',
                'batch_number',
                'status',
                'owner',
                'student_count'
            ]);

        return response()->json($batches);
    }

    public function filterBatches(Request $request){
        $query = Batch::join('courses', 'batches.course_id', '=', 'courses.id')
            ->select(
                'batches.*',
                'courses.course_code as course_code'
            );

        // Status filter (default handled on frontend)
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
            'html'  => view('layouts.batchlist', compact('batches'))->render()
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
        $batch->owner = $request->owner;
        $batch->student_count = $request->student_count;
        $batch->save();

        return back()->with('success', 'Batch created successfully.');
    }

    public function update(Request $request, $id){
        Batch::where('id', $id)->update([
            'status' => $request->status,
            'owner' => $request->owner,
            'student_count' => $request->student_count
        ]);

        return response()->json(['success' => true]);
    }
}
