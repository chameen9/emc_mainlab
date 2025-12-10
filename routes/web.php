<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/student-booking','App\Http\Controllers\LabBookingController@studentBooking')->name('studentBooking');
// Route::get('/calendar', function () {
//     return view('calendar');
// })->name('calendar');


// Route::get('/lab-schedules', [App\Http\Controllers\LabBookingController::class, 'getSchedules']);
// Route::get('/calendar-events','App\Http\Controllers\LabBookingController@getSchedules')->name('about');
Route::get('/computers','App\Http\Controllers\LabBookingController@getComputers')->name('getComputers');
Route::get('/calendar','App\Http\Controllers\LabBookingController@calendar')->name('calendar');
Route::get('/students','App\Http\Controllers\LabBookingController@students')->name('students');
Route::get('/batches','App\Http\Controllers\LabBookingController@batches')->name('batches');
Route::post('/event-store', 'App\Http\Controllers\LabBookingController@eventStore')->name('eventStore');
Route::post('/individual-event-store', 'App\Http\Controllers\LabBookingController@individualEventStore')->name('individualEventStore');
Route::post('/booking-complete', 'App\Http\Controllers\LabBookingController@bookingComplete')->name('bookingComplete');
Route::post('/booking-cancel', 'App\Http\Controllers\LabBookingController@bookingCancel')->name('bookingCancel');
Route::post('/booking-delete', 'App\Http\Controllers\LabBookingController@bookingDelete')->name('bookingDelete');



//ajax
Route::get('/calendar-events', 'App\Http\Controllers\LabBookingController@getEvents')->name('getEvents');
Route::get('/get-batches/{course_id}', 'App\Http\Controllers\LabBookingController@getBatches')->name('getBatches');
Route::get('/get-modules/{course_id}', 'App\Http\Controllers\LabBookingController@getModules')->name('getModules');
Route::get('/module-duration/{id}', 'App\Http\Controllers\LabBookingController@getModuleDuration')->name('getModuleDuration');
Route::get('/get-computers', 'App\Http\Controllers\LabBookingController@getActiveComputers')->name('getActiveComputers');
Route::get('/get-computer-details/{id}', 'App\Http\Controllers\LabBookingController@getComputerDetails')->name('getComputerDetails');
