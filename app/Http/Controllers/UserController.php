<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\UserCredentials;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function addUser(Request $request)
    {
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
}
