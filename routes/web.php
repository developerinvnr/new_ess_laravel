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
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ReasonController;

Route::get('/', function () {
    return view('welcome');
});

//Authentication process
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

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
Route::post('/attendance/authorize', [AttendanceController::class, 'authorize'])->name('attendance.authorize');


Route::post('/leave/authorize', [LeaveController::class, 'leaveauthorize'])->name('leave.authorize');


Route::post('/leaveForm', [LeaveController::class, 'applyLeave'])->name('leaveform');
Route::get('/fetch-leave-list', [LeaveController::class, 'fetchLeaveList'])->name('fetchLeaveList');


Route::get('/salary', [SalaryController::class, 'salary'])->name('salary');

Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');

Route::get('/api/getEmployeeDetails/{employeeId}', [EmployeeController::class, 'getEmployeeDetails']);
Route::get('/api/getReasons/{companyId}/{departmentId}', [ReasonController::class, 'getReasons']);


Route::get('/leave-balance/{employeeId}', [AuthController::class, 'leaveBalance']);
Route::get('/leave-requests', [LeaveController::class, 'fetchLeaveRequests']);


Route::get('/fetch-attendance-requests', [AttendanceController::class, 'fetchAttendanceRequests']);
Route::post('/attendance/updatestatus', [AttendanceController::class, 'authorizeRequestUpdateStatus'])->name('attendance.updatestatus');


Route::get('/birthdays', [LeaveController::class, 'getBirthdays']);

// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

