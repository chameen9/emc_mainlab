<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', 'App\Http\Controllers\AuthController@showLogin')->name('login');
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login.post');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::get('/student-booking','App\Http\Controllers\LabBookingController@studentBooking')->name('studentBooking');
Route::post('/externalindividual-event-store', 'App\Http\Controllers\LabBookingController@externalIndividualEventStore')->name('externalIndividualEventStore');

Route::middleware(['auth', 'role:invigilator,admin'])->group(function () {

    // Navigations
    Route::get('/', function () {return view('index');})->name('index');
    Route::get('/computers', 'App\Http\Controllers\LabBookingController@getComputers')->name('getComputers');
    Route::get('/calendar', 'App\Http\Controllers\LabBookingController@calendar')->name('calendar');
    Route::get('/students', 'App\Http\Controllers\LabBookingController@students')->name('students');
    Route::get('/batches', 'App\Http\Controllers\LabBookingController@batches')->name('batches');

    //Manage Bookings
    Route::post('/event-store', 'App\Http\Controllers\LabBookingController@eventStore')->name('eventStore');
    Route::post('/individual-event-store', 'App\Http\Controllers\LabBookingController@individualEventStore')->name('individualEventStore');
    Route::post('/booking-complete', 'App\Http\Controllers\LabBookingController@bookingComplete')->name('bookingComplete');
    Route::post('/booking-cancel', 'App\Http\Controllers\LabBookingController@bookingCancel')->name('bookingCancel');
    Route::post('/booking-delete', 'App\Http\Controllers\LabBookingController@bookingDelete')->name('bookingDelete');

    //User Profile
    Route::post('/user-change-password', 'App\Http\Controllers\AuthController@changePassword')->name('changePassword');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    //Manage Users
    Route::get('/users', 'App\Http\Controllers\LabBookingController@users')->name('users');
    Route::post('/add-user', 'App\Http\Controllers\UserController@addUser')->name('addUser');

    //Manage Holidays
    Route::get('/holidays', 'App\Http\Controllers\LabBookingController@holidays')->name('holidays');
    Route::post('/add-holiday', 'App\Http\Controllers\LabBookingController@addHoliday')->name('addHoliday');
    Route::post('/delete-holiday', 'App\Http\Controllers\LabBookingController@deleteHoliday')->name('deleteHoliday');

    // Route::get('/register', 'App\Http\Controllers\RegisterController@showRegister')->name('register');
    // Route::post('/register', 'App\Http\Controllers\RegisterController@register')->name('register.post');
});


//ajax routes
Route::get('/calendar-events', 'App\Http\Controllers\LabBookingController@getEvents')->name('getEvents');
Route::get('/get-batches/{course_id}', 'App\Http\Controllers\LabBookingController@getBatches')->name('getBatches');
Route::get('/get-modules/{course_id}', 'App\Http\Controllers\LabBookingController@getModules')->name('getModules');
Route::get('/module-duration/{id}', 'App\Http\Controllers\LabBookingController@getModuleDuration')->name('getModuleDuration');
Route::get('/get-computers', 'App\Http\Controllers\LabBookingController@getActiveComputers')->name('getActiveComputers');
Route::get('/get-computer-details/{id}', 'App\Http\Controllers\LabBookingController@getComputerDetails')->name('getComputerDetails');