<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\UserCredentials;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class UserController extends Controller
{
    public function addUser(Request $request){
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:student,invigilator,lecturer,admin',
        ]);

        $password = Str::random(12);
        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
        ]);

        // Send email with credentials
        Mail::to($user->email)->send(new UserCredentials($user, $password));
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'User created successfully!');
    }

    public function editProfile(Request $request){
        $user = auth()->user();

        //dd($request->all());
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user details
        $user->name = $request->name;

        // Handle profile image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $imageName = time().'.'.$extension;

            if (app()->environment('local')) {
                $folderPath = public_path('img/profiles/');
            } else {
                $folderPath = base_path('/img/profiles/');
            }

            if (!file_exists($folderPath)) mkdir($folderPath, 0777, true);
            $fullImagePath = $folderPath . $imageName;

            $image->move($folderPath, $imageName);

            // $image->move(public_path('img/profiles'), $imageName);
            $user->image = $imageName;
        }

        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function addLecturer(Request $request){
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:lecturers',
        ]);

        // Create a new lecturer
        $lecturer = Lecturer::create([
            'title' => $request->title,
            'name' => $request->name,
            'email' => $request->email,
            'status' => 'Active',
            'created_at' => Carbon::now('Asia/Colombo'),
            'updated_at' => Carbon::now('Asia/Colombo'),
        ]);
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'Lecturer created successfully!');
    }

    public function updateLecturer(Request $request){
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'status' => 'required|string',
        ]);

        // Create a new lecturer
        $lecturer = Lecturer::find($request->input('lecturer_id'));

        $lecturer->title = $request->input('title');
        $lecturer->name = $request->input('name');
        $lecturer->email = $request->input('email');
        $lecturer->status = $request->input('status');
        $lecturer->updated_at = Carbon::now('Asia/Colombo');
        $lecturer->save();
        
        // Redirect back with success message
        return redirect()->back()->with('success', 'Lecturer updated successfully!');
    }
}
