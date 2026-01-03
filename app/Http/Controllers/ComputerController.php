<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Computer;
use Illuminate\Support\Facades\Log;
use App\Models\Software;

class ComputerController extends Controller
{

    public function update(Request $request, $id){
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive,slow,too_slow',
                'software' => 'required|array',
                'software.*.id' => 'required|exists:software,id',
                'software.*.availability' => 'required|in:Available,N/A',
            ]);

            //Log::info($request->software);

            DB::beginTransaction();

            $computer = Computer::findOrFail($id);

            $computer->update([
                'status' => $validated['status']
            ]);

            foreach ($validated['software'] as $sw) {
                $computer->software()->updateExistingPivot(
                    $sw['id'],
                    ['availability' => $sw['availability']]
                );
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Computer updated successfully'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Computer update failed', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    public function addSoftware(Request $request){
        DB::transaction(function () use ($request) {

            $software = Software::create([
                'name' => $request->software_name,
            ]);

            // Attach to all existing computers
            $computerIds = Computer::pluck('id');

            foreach ($computerIds as $computerId) {
                DB::table('computer_software')->insert([
                    'computer_id' => $computerId,
                    'software_id' => $software->id,
                    'availability' => 'N/a', // or 0 if boolean
                ]);
            }
        });

        return redirect()->back()->with('success', 'Software added successfully');
    }
}
