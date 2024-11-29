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
use App\Http\Controllers\PmsController;
use App\Http\Controllers\AssestsController;
use App\Http\Controllers\CronManagement\CronLeaveController;
use App\Http\Controllers\CronManagement\CronQueryController;
use App\Http\Controllers\AssetRequestController;


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
Route::get('/eligibility', [SalaryController::class, 'eligibility'])->name('eligibility');
Route::get('/ctc', [SalaryController::class, 'ctc'])->name('ctc');
Route::get('/investment', [SalaryController::class, 'investment'])->name('investment');
Route::get('/investmentsub', [SalaryController::class, 'investmentsub'])->name('investmentsub');
Route::get('/annualsalary', [SalaryController::class, 'annualsalary'])->name('annualsalary');

Route::get('/pms', [PmsController::class, 'pms'])->name('pms');
Route::get('/appraiser', [PmsController::class, 'appraiser'])->name('appraiser');
Route::get('/reviewer', [PmsController::class, 'reviewer'])->name('reviewer');
Route::get('/hod', [PmsController::class, 'hod'])->name('hod');
Route::get('/management', [PmsController::class, 'management'])->name('management');

Route::get('/assests', [AssestsController::class, 'assests'])->name('assests');

Route::get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');

Route::get('/api/getEmployeeDetails/{employeeId}', [EmployeeController::class, 'getEmployeeDetails']);
Route::get('/api/getReasons/{companyId}/{departmentId}', [ReasonController::class, 'getReasons']);


Route::get('/leave-balance/{employeeId}', [AuthController::class, 'leaveBalance']);
Route::get('/leave-requests', [LeaveController::class, 'fetchLeaveRequests']);
Route::get('/leave-requests-all', [LeaveController::class, 'fetchLeaveRequestsAll']);


Route::get('/fetch-attendance-requests', [AttendanceController::class, 'fetchAttendanceRequests']);
Route::post('/attendance/updatestatus', [AttendanceController::class, 'authorizeRequestUpdateStatus'])->name('attendance.updatestatus');
Route::get('/check-backdated-leaves', [CronLeaveController::class, 'checkBackdatedLeaves']);
Route::get('/getAttendanceData', [AttendanceController::class, 'getAttendanceData']);


Route::get('/birthdays', [LeaveController::class, 'getBirthdays']);
Route::post('/send-wishes', [LeaveController::class, 'sendWishes']);


Route::get('/employee/queries', [QueryController::class, 'getQueriesForUser'])->name('employee.queries');
Route::post('/employee/query/action', [QueryController::class, 'updateQueryAction'])->name('employee.query.action');
Route::get('/employee/department/employees', [QueryController::class, 'getEmployeesForDepartment'])->name('employee.department.employees');
Route::get('/employee/deptqueriesub', [QueryController::class, 'getDeptQuerySubForDepartment'])->name('employee.deptqueriesub');
Route::get('/fetchQueryDetails', [QueryController::class, 'fetchQueryDetails'])->name('fetchQueryDetails');
Route::post('/submitAction', [QueryController::class, 'submitAction'])->name('submitAction');

//cron files
Route::get('/check-backdated-leaves', [CronLeaveController::class, 'checkBackdatedLeaves']);
Route::get('/forward-query-to-levels', [CronQueryController::class, 'queryforwardtolevels']);


Route::post('/asset-request', [AssetRequestController::class, 'store'])->name('asset.request.store');
Route::post('/approve/request', [AssetRequestController::class, 'approveRequest'])->name('approve.request');
Route::post('/approve/request/team', [AssetRequestController::class, 'approveRequestFromTeam'])->name('approve.request.team');
Route::post('/approve/request/teamassest', [AssetRequestController::class, 'approveRequestFromTeamAssest'])->name('approve.request.team.assest');

Route::post('/update-query-rating', [QueryController::class, 'updateQueryRating']);
Route::post('/save-investment-declaration', [SalaryController::class, 'saveInvestmentDeclaration'])->name('save.investment.declaration');
Route::post('/save-investment-submission', [SalaryController::class, 'saveInvestmentSubmission'])->name('save.investment.submission');

Route::get('/teamleaveatt', [TeamController::class, 'teamleaveatt'])->name('teamleaveatt');
Route::get('/teamassetsquery', [TeamController::class, 'teamassetsquery'])->name('teamassetsquery');
Route::get('/teameligibility', [TeamController::class, 'teameligibility'])->name('teameligibility');
Route::get('/teamtrainingsep', [TeamController::class, 'teamtrainingsep'])->name('teamtrainingsep');
Route::get('/teamcost', [TeamController::class, 'teamcost'])->name('teamcost');

//soft deletes
Route::delete('/leave-request/{id}', [LeaveController::class, 'softDelete'])->name('leaveRequest.delete');

// Route::middleware('guest')->group(function () {
//     Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

