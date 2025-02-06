<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin/login', [AdminController::class, 'showLogin'])->name('login');

Route::post('admin/login', [AdminController::class, 'login']);

Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->middleware('auth:admin')->name('dashboard');

Route::get('admin/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/enroll', function () {
    return view('enroll');
})->name('enroll');
Route::get('/attendance', function () {
    return view('attendance');
})->name('attendance');

Route::middleware(['auth:admin'])->group(function () {


});

Route::post('/verify-face', [AttendanceController::class, 'verifyFace']);

Route::post('/enroll-face', [AttendanceController::class, 'enrollFace']);

Route::get('/debug-student', [AttendanceController::class, 'debugStudent']);