<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/logout', function () {
    return view('logout');
});

Route::get('/schedule', function () {
    return view('schedule');
});

Route::get('/addschedule', function () {
    return view('addschedule');
});

Route::get('/employees', function () {
    return view('employees');
});

Route::get('/addemployees', function () {
    return view('addemployees');
});

Route::get('/attendancelogin', function () {
    return view('attendancelogin');
});

Route::get('/attendance', function () {
    return view('attendance');
});

Route::get('/late', function () {
    return view('late');
});

Route::get('/edit2', function () {
    return view('edit2');
});

Route::get('/editemployee', function () {
    return view('editemployee');
});

Route::get('/editemployee2', function () {
    return view('editemployee2');
});


Route::post('/', [Controller::class, 'login']);
Route::post('/logout', [Controller::class, 'logout']);
Route::post('/addschedule', [Controller::class, 'newSchedule']);
Route::get('/schedule', [Controller::class, 'showSchedule']);
Route::post('/edit', [Controller::class, 'edit']);
Route::post('/edit2', [Controller::class, 'edit2']);
Route::post('/delete', [Controller::class, 'delete']);
Route::post('/editemployee', [Controller::class, 'editEmployee']);
Route::post('/editemployee2', [Controller::class, 'editEmployee2']);
Route::post('/addemployees', [Controller::class, 'newEmployees']);
Route::get('/addemployees', [Controller::class, 'getTImes']);
Route::get('/employees', [Controller::class, 'showEmployees']);
Route::post('/employees', [Controller::class, 'deleteEmployees']);
Route::post('/attendancelogin', [Controller::class, 'attendanceLogin']);
Route::get('/dashboard', [Controller::class, 'showGraph']);
Route::get('/attendance', [Controller::class, 'showAttendance']);
Route::get('/late', [Controller::class, 'showLate']);
