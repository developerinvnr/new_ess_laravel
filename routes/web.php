<?php

use App\Http\Controllers\JobOpening;
use App\Http\Controllers\SalaryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;



Route::get('/', function () {
    return view('welcome');
});

//Authentication process
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showforgotpasscode'])->name('forgotpasscode');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');


Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

Route::get('/change-password', [AuthController::class, 'change_password_view'])->name('change-password');
Route::post('/change-password', [AuthController::class, 'changepassword']);


Route::get('/team', [TeamController::class, 'team'])->name('team');

Route::get('/query', [QueryController::class, 'query'])->name('query');

Route::post('/querysubmit', [QueryController::class, 'querysubmit'])->name('querysubmit');

Route::get('/attendance', [AttendanceController::class, 'attendanceView'])->name('attendanceView');
Route::get('/attendance/{year}/{month}/{employeeId}', [AttendanceController::class, 'getAttendance']);


Route::post('/leaveForm', [LeaveController::class, 'applyLeave'])->name('leaveform');
Route::get('/fetch-leave-list', [LeaveController::class, 'fetchLeaveList'])->name('fetchLeaveList');


Route::get('/salary', [SalaryController::class, 'salary'])->name('salary');

// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

