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
use App\Http\Controllers\ImpactController;
use App\Http\Controllers\AllcelebrationController;
use App\Http\Controllers\ExitInterviewController;
use App\Http\Controllers\GovtssschemesController;
use App\Http\Controllers\ResignationController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\DailyreportsController;
use App\Http\Controllers\LoggingReportsController;
use App\Http\Controllers\LedgerConfirmationController;
use App\Http\Controllers\Export\LogisticsExportController;
use App\Http\Controllers\Export\AccountExportController;
use App\Http\Controllers\Export\ITExportController;
use App\Http\Controllers\Export\EmployeePromotionController;
use App\Http\Controllers\Export\EmployeeScoreController;
use App\Http\Controllers\Export\IncrementExportController;
use App\Http\Controllers\Export\LedgerExportController;
use App\Http\Controllers\Export\AssetRequestControllerAll;


use App\Http\Middleware\PreventBackHistory;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AttAppController;

use function PHPSTORM_META\registerArgumentsSet;

Route::get('/', function () {
    return view('welcome');
});

//Authentication process
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showforgotpasscode'])->name('forgotpasscode');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');


Route::middleware('auth')->get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/seperation', [AuthController::class, 'seperation'])->name('seperation');

Route::middleware('auth')->get('/profile', [ProfileController::class, 'profile'])->name('profile');

Route::middleware('auth')->get('/change-password', [AuthController::class, 'change_password_view'])->name('change-password');


Route::post('/change-password', [AuthController::class, 'changepassword']);
Route::middleware('auth')->get('/allimpact', [ImpactController::class, 'impact'])->name('impact');
Route::middleware('auth')->get('/allcelebration', [AllcelebrationController::class, 'allcelebration'])->name('allcelebration');

Route::middleware('auth')->get('/team', [TeamController::class, 'team'])->name('team');

Route::middleware('auth')->get('/query', [QueryController::class, 'query'])->name('query');

Route::post('/querysubmit', [QueryController::class, 'querysubmit'])->name('querysubmit');

Route::middleware('auth')->get('/attendance', [AttendanceController::class, 'attendanceView'])->name('attendanceView');
Route::middleware('auth')->get('/attendance-leave', [LeaveController::class, 'attendanceViewleave'])->name('attendanceViewleave');

Route::middleware('auth')->get('/attendance/{year}/{month}/{employeeId}', [AttendanceController::class, 'getAttendance']);
Route::post('/attendance/authorize', [AttendanceController::class, 'authorize'])->name('attendance.authorize');


Route::post('/leave/authorize', [LeaveController::class, 'leaveauthorize'])->name('leave.authorize');


Route::post('/leaveForm', [LeaveController::class, 'applyLeave'])->name('leaveform');
Route::middleware('auth')->get('/fetch-leave-list', [LeaveController::class, 'fetchLeaveList'])->name('fetchLeaveList');



Route::middleware('auth')->get('/salary', [SalaryController::class, 'salary'])->name('salary');
// Route for displaying password modal and handling verification
Route::middleware('auth')->get('/verify-password', [SalaryController::class, 'showPasswordModal'])->name('verify.password');
Route::middleware('auth')->post('/verify-password', [SalaryController::class, 'verifyPassword'])->name('verifyPassword.submit');


Route::middleware('auth')->get('/eligibility', [SalaryController::class, 'eligibility'])->name('eligibility');
Route::middleware('auth')->get('/ctc', [SalaryController::class, 'ctc'])->name('ctc');
Route::middleware('auth')->get('/investment', [SalaryController::class, 'investment'])->name('investment');
Route::middleware('auth')->get('/investmentsub', [SalaryController::class, 'investmentsub'])->name('investmentsub');
Route::middleware('auth')->get('/annualsalary', [SalaryController::class, 'annualsalary'])->name('annualsalary');

Route::middleware('auth')->get('/pmsinfo', [PmsController::class, 'pmsinfo'])->name('pmsinfo');
Route::middleware('auth')->get('/pms', [PmsController::class, 'pms'])->name('pms');
Route::middleware('auth')->get('/appraiser', [PmsController::class, 'appraiser'])->name('appraiser');
Route::get('/reviewer', [PmsController::class, 'reviewer'])->name('reviewer');
Route::get('/hod', [PmsController::class, 'hod'])->name('hod');
Route::get('/management', [PmsController::class, 'management'])->name('management');

Route::middleware('auth')->get('/assests', [AssestsController::class, 'assests'])->name('assests');

Route::middleware('auth')->get('/holidays', [HolidayController::class, 'index'])->name('holidays.index');

Route::get('/getEmployeeDetails/{employeeId}', [EmployeeController::class, 'getEmployeeDetails']);
Route::get('/getReasons/{companyId}/{departmentId}', [ReasonController::class, 'getReasons']);


Route::get('/leave-balance/{employeeId}', [AuthController::class, 'leaveBalance']);
Route::middleware('auth')->get('/leave-requests', [LeaveController::class, 'fetchLeaveRequests']);
Route::middleware('auth')->get('/leave-requests-all', [LeaveController::class, 'fetchLeaveRequestsAll']);


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

Route::middleware('auth')->get('/teamleaveatt', [TeamController::class, 'teamleaveatt'])->name('teamleaveatt');
Route::middleware('auth')->get('/teamassets', [TeamController::class, 'teamassets'])->name('teamassets');
Route::middleware('auth')->get('/teamquery', [TeamController::class, 'teamquery'])->name('teamquery');

Route::middleware('auth')->get('/teameligibility', [TeamController::class, 'teameligibility'])->name('teameligibility');
Route::middleware('auth')->get('/teamtrainingsep', [TeamController::class, 'teamtrainingsep'])->name('teamtrainingsep');
Route::middleware('auth')->get('/teamcost', [TeamController::class, 'teamcost'])->name('teamcost');
Route::middleware('auth')->get('/teamconfirmation', [TeamController::class, 'teamconfirmation'])->name('teamconfirmation');
Route::middleware('auth')->get('/teamseprationclear', [TeamController::class, 'teamseprationclear'])->name('teamseprationclear');
Route::get('/teamclear', [TeamController::class, 'teamclear'])->name('teamclear');

Route::middleware('auth')->get('/exitinterviewform', [ExitInterviewController::class, 'exitinterviewform'])->name('exitinterviewform');
Route::post('/exitinterviewform', [ExitInterviewController::class, 'submit'])->name('exitformsubmit');
Route::get('/get-exit-form-data/{empid}', [ExitInterviewController::class, 'getFormData']);

Route::middleware('auth')->get('/govtssschemes', [GovtssschemesController::class, 'govtssschemes'])->name('govtssschemes');

//soft deletes
Route::delete('/leave-request/{id}', [LeaveController::class, 'softDelete'])->name('leaveRequest.delete');
Route::post('/leave/reverse-cancellation/{applyLeaveId}', [LeaveController::class, 'reverseLeaveAcceptance'])->name('leave.reverse-cancellation');
Route::post('/leave/reverse-cancellation-request/{applyLeaveId}', [LeaveController::class, 'reverseLeaveAcceptancerequest'])->name('leave.reverse-cancellationrequest');
Route::delete('/delete-query/{queryId}', [QueryController::class, 'softDeleteQuery']);

Route::post('/submit-vehicle-request', [AssetRequestController::class, 'storeVehicle'])->name('submit.vehicle.request');
Route::post('/update-vehicle', [AssetRequestController::class, 'updateVehicle'])->name('update.vehicle');


Route::post('/resignation/store', [ResignationController::class, 'store'])->name('resignation.store');
Route::post('/employee/calculate-relieving-date', [ResignationController::class, 'calculateRelievingDate']);


Route::post('/update-rep-relieving-date', [ResignationController::class, 'updateRepRelievingDate']);

Route::post('/submit-noc-clearance', [ResignationController::class, 'submitNocClearance'])->name('submit.noc.clearance');
Route::post('/submit-noc-clearance-hr', [ResignationController::class, 'submitNocClearancehr'])->name('submit.noc.clearance.hr');

Route::post('/submit-noc-clearance-it', [ResignationController::class, 'submitNocClearanceit'])->name('submit.noc.clearance.it');

Route::get('/get-noc-data/{empSepId}/{employeeid}', [ResignationController::class, 'getNocData']);
Route::post('/submit-noc-clearance-logdep', [ResignationController::class, 'submitNocClearancelogdep'])->name('submit.noc.clearance.logdep');

Route::get('/get-exit-repo-data/{empSepId}', [ResignationController::class, 'getExitRepoData']);

Route::get('/get-noc-data-it/{empSepId}', [ResignationController::class, 'getNocDataIt']);
Route::get('/get-noc-data-hr/{empSepId}/{employeeidhr}', [ResignationController::class, 'getNocDataHr']);


// Define routes for each clearance form
Route::middleware('auth')->get('/department-clearance', [ResignationController::class, 'departmentclearance'])->name('department.clearance');
Route::middleware('auth')->get('/it-clearance', [ResignationController::class, 'itClearance'])->name('it.clearance');
Route::middleware('auth')->get('/logistics-clearance', [ResignationController::class, 'logisticsClearance'])->name('logistics.clearance');
Route::middleware('auth')->get('/hr-clearance', [ResignationController::class, 'hrClearance'])->name('hr.clearance');
Route::middleware('auth')->get('/account-clearance', [ResignationController::class, 'accountClearance'])->name('account.clearance');
Route::middleware('auth')->get('/expenses-ledger', [ResignationController::class, 'expensesLedger'])->name('expenses.ledger');
Route::middleware('auth')->get('/get-noc-data-acct/{empSepId}', [ResignationController::class, 'getNocDataAcct']);

Route::get('/employee-eligibility/{employee_id}', [SalaryController::class, 'getEligibilityData']);
Route::get('/employee-ctc/{EmployeeID}', [SalaryController::class, 'getCtcData']);
Route::get('/employee/queries/repo', [TeamController::class, 'getQueriesForUser'])->name('employee.queries.repo');


Route::post('/submit-exit-form', [ResignationController::class, 'submitExitForm'])->name('submit.exit.form');
Route::post('/submit-noc-clearance-acct', [ResignationController::class, 'submitNocClearanceAcct'])->name('submit.noc.clearance.acct');


Route::get('/employee/team/{employeeID}', [TeamController::class, 'getEmployeeTeam']);
Route::get('/employee/details/{employeeId}', [TeamController::class, 'showDetails'])->name('employee.details');


Route::post('/employee/confirmation/store', [ConfirmationController::class, 'store'])->name('employee.confirmation.store');
Route::get('/get-employee-confirmation/{employeeId}', [ConfirmationController::class, 'getEmployeeConfirmationData']);


Route::get('/employee/singleprofile/{id}', [TeamController::class, 'singleprofileemployee'])->name('employee.singleprofile');
Route::get('/attendance-data/{employeeId}/{date}', [AttendanceController::class, 'getAttendanceDatapunch']);

Route::post('/send-email', [ResignationController::class, 'sendEmail'])->name('send.email');

Route::get('ojas_access', [\App\Http\Controllers\OjasExtLoginController::class, 'ojas_access'])->name('ojas_access');

Route::post('/opinion-submit', [GovtssschemesController::class, 'store'])->name('opinion.submit');
Route::get('/get-separation-reason/{empSepId}', [ResignationController::class, 'getReason'])->name('get.separation.reason');

Route::get('/query-details/{queryId}', [QueryController::class, 'getQueryDetails'])->name('query.details');

Route::get('/fetch-assets-history/{employeeId}', [AssestsController::class, 'fetchAssetsHistory']);
Route::get('/fetch-assets-history-it/{employeeId}', [AssestsController::class, 'fetchAssetsHistoryitclearance']);

Route::get('/assets/details/{id}', [AssestsController::class, 'getAssetDetails'])->name('assets.details');


Route::get('/daily-reports', [DailyreportsController::class, 'dailyreports'])->name('dailyreports');
Route::get('/logging-reports', [LoggingReportsController::class, 'locationtracking'])->name('locationtracking');

Route::post('/submit-contact-form', [ProfileController::class, 'submit'])->name('contact.submit');


//export 
Route::get('/export-approved-employees', [LogisticsExportController::class, 'exportApprovedEmployees'])->name('export.approvedEmployees');
Route::get('/export-approved-employees-acct', [AccountExportController::class, 'exportApprovedEmployees'])->name('export.approvedEmployeesacc');

Route::get('/export-approved-employees-it', [ITExportController::class, 'exportApprovedEmployees'])->name('export.approvedEmployeesit');

// Define the route for fetching KRA details
Route::get('/kra/details', [PmsController::class, 'getDetails'])->name('kra.details');
Route::get('/kra/details/formb', [PmsController::class, 'getDetailsformb'])->name('kra.details.formb');
Route::get('/kra/details/formb/employee', [PmsController::class, 'getDetailsformbemployee'])->name('kra.details.formb.employee');



Route::get('Employee/Emp{companyId}Lgr/{encryptedEmpCode}.pdf', [ProfileController::class, 'viewLedger']);
Route::get('/downloadledger', [ProfileController::class, 'downloadLedger'])->name('downloadLedger');

Route::post('/kra/save', [PmsController::class, 'save'])->name('kra.save');

Route::post('/delete-subkra', [PmsController::class, 'deleteSubKra'])->name('delete.subkra');

Route::post('/delete-kra', [PmsController::class, 'deleteKra'])->name('kra.delete');
Route::post('/fetch-old-kra', [PmsController::class, 'fetchOldKRA'])->name('fetch_old_kra');

Route::get('/get-kra-details', [PmsController::class, 'getKraDetails'])->name('getKraDetails');
Route::get('/getLogicData', [PmsController::class, 'getLogicData'])->name('getLogicData');

Route::post('/saveappraiser', [PmsController::class, 'saveappraiser'])->name('saveappraiser');
Route::post('/savereviewer', [PmsController::class, 'savereviewer'])->name('savereviewer');
Route::post('/savehod', [PmsController::class, 'savehod'])->name('savehod');


Route::post('/kra/revert', [PmsController::class, 'revert'])->name('kra.revert');
Route::post('/kra/revert/reviewer', [PmsController::class, 'revertreviewer'])->name('kra.revert.reviewer');
Route::post('/kra/revert/hod', [PmsController::class, 'reverthod'])->name('kra.revert.hod');

Route::post('/save-kra-row', [PmsController::class, 'saveRow'])->name('save.kra.row');
Route::post('/save-pms-row-app', [PmsController::class, 'saveRowPms'])->name('save.pms.row.app');


Route::post('/save-kra-row-formb', [PmsController::class, 'saveRowFormb'])->name('save.kra.row.formb');
Route::post('/save-kra-row-formb-app', [PmsController::class, 'saveRowFormbapp'])->name('save.kra.row.formb.app');


Route::get('/notification/read/{id}', [NotificationController::class, 'markAsRead'])->name('notification.read');

Route::post('/save-achievements', [PmsController::class, 'saveAchievements']);

Route::delete('/delete-achievement/{id}', [PmsController::class, 'deleteAchievement']);

Route::post('/save-feedback', [PmsController::class, 'saveFeedback'])->name('save.feedback');


Route::get('/employee-eligibility', [EmployeeController::class, 'index'])->name('employee.index');
Route::post('/employee-eligibility', [EmployeeController::class, 'checkEligibility'])->name('employee.checkEligibility');


Route::post('/save-kra-form', [PmsController::class, 'saveKraForm'])->name('save.kra.form');
Route::post('/save-kra-formb', [PmsController::class, 'saveKraFormb'])->name('save.kra.formb');


Route::post('/upload/store', [PmsController::class, 'store'])->name('upload.store');
Route::get('/upload/list', [PmsController::class, 'list'])->name('upload.list');
Route::delete('/upload/delete/{id}', [PmsController::class, 'delete'])->name('upload.delete');

Route::post('/final-submit', [PmsController::class, 'finalSubmit'])->name('finalSubmit');
Route::get('/edit-appraisal/{EmpPmsId}', [PmsController::class, 'edit'])->name('editAppraisal');
Route::get('/edit-reviewer/{EmpPmsId}', [PmsController::class, 'editreviewer'])->name('editreviewer');
Route::get('/view-hod/{EmpPmsId}', [PmsController::class, 'viewhod'])->name('viewhod');
Route::get('/view-reviewer/{EmpPmsId}', [PmsController::class, 'viewreviewer'])->name('viewreviewer');
Route::get('/view-appraiser/{EmpPmsId}', [PmsController::class, 'viewappraiser'])->name('viewappraiser');


Route::post('/saveKraData', [PmsController::class, 'saveKraData'])->name('saveKraData');
Route::post('/saveKraDataRev', [PmsController::class, 'saveKraDataRev'])->name('saveKraDataRev');
Route::post('/approve-pms', [PmsController::class, 'approvePms'])->name('approve.pms');

Route::post('/revert-pms', [PmsController::class, 'revertPms'])->name('revert.pms');
Route::post('/revert-pms-mang', [PmsController::class, 'revertPmsMang'])->name('revert.pms.mang');

Route::post('/revert-pms-rev', [PmsController::class, 'revertPmsRev'])->name('revert.pms.rev');
Route::post('/revert-pms-app', [PmsController::class, 'revertPmsApp'])->name('revert.pms.app');


Route::get('/get-uploaded-files', [PmsController::class, 'getUploadedFiles'])->name('get.uploaded.files');
Route::middleware('auth')->get('/management', [PmsController::class, 'management'])->name('management');
Route::middleware('auth')->get('/management-appraisal', [PmsController::class, 'managementAppraisal'])->name('managementAppraisal');
Route::middleware('auth')->get('/management-promotion', [PmsController::class, 'managementPromotion'])->name('managementPromotion');
Route::middleware('auth')->get('/management-increment', [PmsController::class, 'managementIncrement'])->name('managementIncrement');
Route::middleware('auth')->get('/management-increment/bck', [PmsController::class, 'managementIncrementbck'])->name('managementIncrementbck');

Route::middleware('auth')->get('/management-report', [PmsController::class, 'managementReport'])->name('managementReport');
Route::middleware('auth')->get('/management-graph', [PmsController::class, 'managementGraph'])->name('managementGraph');

Route::post('/update-employee-score', [PmsController::class, 'updateEmployeeScore']);
Route::post('/update-employee-promotion', [PmsController::class, 'updateEmployeePromotion']);


Route::get('/promotion-export', [EmployeePromotionController::class, 'exportPromotionData'])->name('promotion.export');
Route::post('/promotion/final-submit', [PmsController::class, 'finalSubmitMangPromotion'])->name('promotion.final.submit');


Route::get('/score-export', [EmployeeScoreController::class, 'exportScoreData'])->name('score.export');
Route::get('/employee/details/{employeeId}/{PmsYId}/{mangid}', [PmsController::class, 'showDetails'])->name('employee.details');
Route::post('/save-rating-breakdown', [PmsController::class, 'saveRatingBreakdown'])->name('save.rating.breakdown');
Route::get('/get-department-ratings', [PmsController::class, 'getDepartmentRatings']);


Route::post('/asset-upload', [AssetRequestController::class, 'upload'])->name('asset.upload');
Route::post('/save-single-employee', [PmsController::class, 'saveSingle'])->name('employee.save.single');
Route::get('/export-increment/{type}', [IncrementExportController::class, 'export'])->name('export.increment');


Route::post('/get-employee-status', [PmsController::class, 'getEmployeeStatus']);
Route::post('/send-employee-info', [PmsController::class, 'search_gross_ctc'])->name('sendemployeeinfo');

Route::get('/policy_change_details/{empId}', [EmployeeController::class, 'policy_change_details']);

Route::middleware(['auth', PreventBackHistory::class])->group(function () {
    Route::get('/change-password-new', [AuthController::class, 'change_password_view_first'])->name('change_password_view_first');
    Route::get('/govtssschemes', [AuthController::class, 'govtssschemes'])->name('govtssschemes');
    Route::get('/investmentdeclaration', [GovtssschemesController::class, 'investmentdeclaration'])->name('investmentdeclaration');
});
Route::post('/send-ach-data', [PmsController::class, 'storeKRAEntries']);
Route::post('/send-ach-data-app', [PmsController::class, 'storeKRAEntriesAppraiser']);

// routes/web.php
Route::post('/save-self-rating', [PmsController::class, 'saveRating']);
Route::post('/submit-self-rating', [PmsController::class, 'submitRating']);


Route::post('/save-self-rating-app', [PmsController::class, 'saveRatingApp']);
Route::post('/submit-self-rating-app', [PmsController::class, 'submitRatingApp']);

Route::get('/fetch-rating-status/{tgtdefid}', [PmsController::class, 'fetchRatingStatus']);
Route::get('/fetch-rating-status-app/{tgtdefid}', [PmsController::class, 'fetchRatingStatusApp']);


Route::middleware('auth')->group(function () {
    Route::post('/ledger/get-employee-data', [EmployeeController::class, 'getEmployeeData'])->name('ledger.getEmployeeData');
    Route::get('/ledger/view/{companyId}/{year}/{empCode}', [EmployeeController::class, 'viewLedger'])->name('ledger.view');
    Route::get('/ledger/download/{companyId}/{year}/{empCode}', [EmployeeController::class, 'downloadLedger'])->name('ledger.download');
    Route::get('/downloadledger/{employeeId}', [EmployeeController::class, 'showDownloadPage'])->name('ledger.downloadpage');
    Route::post('/ledger/check-confirmation', [EmployeeController::class, 'checkConfirmation'])
        ->name('ledger.checkConfirmation');
    // For submitting confirmation (changed to not require parameters)
    Route::post('/ledger/submit-confirmation', [EmployeeController::class, 'submitConfirmation'])
        ->name('ledger.submitConfirmation');
    Route::post('/ledger/submitQueryFollowup', [EmployeeController::class, 'submitQueryFollowup'])
        ->name('ledger.submitQueryFollowup');
});
Route::get('/get-zone-by-bu', [PmsController::class, 'get_zone_by_bu'])->name('get_zone_by_bu');
Route::get('/get-region-by-zone', [PmsController::class, 'get_region_by_zone'])->name('get_region_by_zone');
Route::get('/ledger-confirmation/export/{type}/{format}', [LedgerExportController::class, 'export'])->name('ledger.confirmation.export');
Route::get('/ledger-confirmation/details/{id}', [LedgerConfirmationController::class, 'show'])->name('ledger.confirmation.details');
Route::get('/ledger-confirmation/print/{id}', [LedgerConfirmationController::class, 'printConfirmation'])->name('ledger.confirmation.print');

Route::get('/asset/requests/export', [AssetRequestControllerAll::class, 'export'])->name('asset.requests.export');
Route::post('/ledger/check-confirmation/new', [LedgerConfirmationController::class, 'checkConfirmation'])->name('check.confirmation');

Route::get('/ledger-confirmation/view/{id}', [LedgerConfirmationController::class, 'viewConfirmation'])->name('ledger.confirmation.view');