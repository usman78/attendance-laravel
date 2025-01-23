<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/verify-face', [AttendanceController::class, 'verifyFace']);

Route::get('/attendance', function () {
    return view('attendance');
});

