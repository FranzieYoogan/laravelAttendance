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

Route::post('/', [Controller::class, 'login']);
Route::post('/logout', [Controller::class, 'logout']);
Route::post('/addschedule', [Controller::class, 'newSchedule']);
Route::get('/schedule', [Controller::class, 'showSchedule']);
Route::post('/addemployees', [Controller::class, 'newEmployees']);
Route::get('/addemployees', [Controller::class, 'getTImes']);
Route::get('/employees', [Controller::class, 'showEmployees']);
Route::post('/attendancelogin', [Controller::class, 'attendanceLogin']);
Route::get('/dashboard', [Controller::class, 'showGraph']);