<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', 'App\Http\Controllers\AuthController@showLogin')->name('login');
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login.post');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::get('/reserve','App\Http\Controllers\LabBookingController@studentBooking')->name('studentBooking');
Route::post('/externalindividual-event-store', 'App\Http\Controllers\LabBookingController@externalIndividualEventStore')->name('externalIndividualEventStore');
Route::get('/userguide', function () {
    return view('Docs.externalUserGuide');
})->name('externalUserGuide');

Route::middleware(['auth', 'role:invigilator,admin'])->group(function () {

    // Navigations
    Route::get('/', 'App\Http\Controllers\LabBookingController@index')->name('index');
    Route::get('/computers', 'App\Http\Controllers\LabBookingController@getComputers')->name('getComputers');
    Route::get('/calendar', 'App\Http\Controllers\LabBookingController@calendar')->name('calendar');
    Route::get('/calendar-task-view', 'App\Http\Controllers\LabBookingController@calendarTaskView')->name('calendarTaskView');
    Route::get('/students', 'App\Http\Controllers\LabBookingController@students')->name('students');
    Route::get('/user-guide', function () {
        return view('Docs.userGuide');
    })->name('userGuide');

    //Manage Bookings
    Route::post('/event-store', 'App\Http\Controllers\LabBookingController@eventStore')->name('eventStore');
    Route::post('/individual-event-store', 'App\Http\Controllers\LabBookingController@individualEventStore')->name('individualEventStore');
    Route::post('/permanent-individual-event-store', 'App\Http\Controllers\LabBookingController@permanentIndividualEventStore')->name('permanentIndividualEventStore');
    Route::post('/booking-complete', 'App\Http\Controllers\LabBookingController@bookingComplete')->name('bookingComplete');
    Route::post('/booking-cancel', 'App\Http\Controllers\LabBookingController@bookingCancel')->name('bookingCancel');
    Route::post('/booking-delete', 'App\Http\Controllers\LabBookingController@bookingDelete')->name('bookingDelete');

    //Manage Batches
    Route::get('/batches', 'App\Http\Controllers\BatchController@index')->name('batches');

    //Manage Holidays
    Route::get('/holidays', 'App\Http\Controllers\LabBookingController@holidays')->name('holidays');

    //Manage Computers
    Route::put('/computers/{id}', 'App\Http\Controllers\ComputerController@update')->name('updateComputer');

    //Manage Software
    Route::post('/add-software', 'App\Http\Controllers\ComputerController@addSoftware')->name('addSoftware');

    //User Profile
    Route::post('/user-change-password', 'App\Http\Controllers\AuthController@changePassword')->name('changePassword');
    Route::post('/edit-profile', 'App\Http\Controllers\UserController@editProfile')->name('editProfile');

    //Ajax Tables
    Route::get('/bookings/table', 'App\Http\Controllers\LabBookingController@getBookingTable')->name('getBookingTable');

});

Route::middleware(['auth', 'role:admin'])->group(function () {

    //Manage People - Admin Only
    Route::get('/people', 'App\Http\Controllers\LabBookingController@people')->name('people');
    Route::post('/add-user', 'App\Http\Controllers\UserController@addUser')->name('addUser');
    Route::post('/add-lecturer', 'App\Http\Controllers\UserController@addLecturer')->name('addLecturer');
    Route::post('/update-lecturer', 'App\Http\Controllers\UserController@updateLecturer')->name('updateLecturer');

    //Manage Batches - Admin Only
    Route::post('/batch-update', 'App\Http\Controllers\BatchController@update')->name('updateBatch');
    Route::post('/batch-store', 'App\Http\Controllers\BatchController@store')->name('batches.store');

    //Manage Holidays - Admin Only
    Route::post('/add-holiday', 'App\Http\Controllers\LabBookingController@addHoliday')->name('addHoliday');
    Route::post('/delete-holiday', 'App\Http\Controllers\LabBookingController@deleteHoliday')->name('deleteHoliday');

    // Route::get('/register', 'App\Http\Controllers\RegisterController@showRegister')->name('register');
    // Route::post('/register', 'App\Http\Controllers\RegisterController@register')->name('register.post');
});


//ajax routes
Route::get('/calendar-events', 'App\Http\Controllers\LabBookingController@getEvents')->name('getEvents');
Route::get('/get-batches/{course_id}', 'App\Http\Controllers\BatchController@getBatches')->name('getBatches');
Route::get('/batches/filter', 'App\Http\Controllers\BatchController@filterBatches')->name('filterBatches');
Route::get('/get-modules/{course_id}', 'App\Http\Controllers\LabBookingController@getModules')->name('getModules');
Route::get('/module-duration/{id}', 'App\Http\Controllers\LabBookingController@getModuleDuration')->name('getModuleDuration');
Route::get('/get-computers', 'App\Http\Controllers\LabBookingController@getActiveComputers')->name('getActiveComputers');
Route::get('/get-computer-details/{id}', 'App\Http\Controllers\LabBookingController@getComputerDetails')->name('getComputerDetails');
Route::get('/lab-usage-chart-student-weekly', 'App\Http\Controllers\ChartController@weeklyStudentBookingsChart')->name('weeklyStudentBookingsChart');
Route::get('/lab-usage-chart-student-monthly', 'App\Http\Controllers\ChartController@monthlyStudentBookingsChart')->name('monthlyStudentBookingsChart');
Route::get('/get-holidays', 'App\Http\Controllers\LabBookingController@getHolidays')->name('getHolidays');

Route::get('/lab-usage-chart-batch-weekly', 'App\Http\Controllers\ChartController@weeklyBatchBookingsChart')->name('weeklyBatchBookingsChart');
Route::get('/lab-usage-chart-batch-monthly', 'App\Http\Controllers\ChartController@monthlyBatchBookingsChart')->name('monthlyBatchBookingsChart');
Route::get('/comparison-chart', 'App\Http\Controllers\ChartController@comparisonChart')->name('comparisonChart');