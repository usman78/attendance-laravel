<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance');

Route::post('/verify-face', [AttendanceController::class, 'verifyFace']);

Route::get('/enroll', function () {
    return view('enroll');
})->name('enroll');

Route::post('/enroll-face', [AttendanceController::class, 'enrollFace']);



Route::get('/debug-student', [AttendanceController::class, 'debugStudent']);