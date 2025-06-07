<?php

use App\Http\Controllers\Manage\BasicController;
use App\Http\Controllers\Manage\SettingController;
use App\Http\Controllers\Manage\BusinessOrg\BUController;
use App\Http\Controllers\Manage\BusinessOrg\RegionController;
use App\Http\Controllers\Manage\BusinessOrg\TerritoryController;
use App\Http\Controllers\Manage\BusinessOrg\ZoneController;
use App\Http\Controllers\Manage\CoreAPIController;
use App\Http\Controllers\Manage\CorporateOrg\DepartmentController;
use App\Http\Controllers\Manage\CorporateOrg\FunctionController;
use App\Http\Controllers\Manage\CorporateOrg\SectionController;
use App\Http\Controllers\Manage\CorporateOrg\SubDepartmentController;
use App\Http\Controllers\Manage\CorporateOrg\VerticalController;
use App\Http\Controllers\Manage\PoliticalLocation\BlockController;
use App\Http\Controllers\Manage\PoliticalLocation\CityVillageController;
use App\Http\Controllers\Manage\PoliticalLocation\CountryController;
use App\Http\Controllers\Manage\PoliticalLocation\DistrictController;
use App\Http\Controllers\Manage\PoliticalLocation\StateController;
use App\Http\Controllers\Manage\EmployeeManagement\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\RolePermissionController;
use App\Http\Controllers\Manage\EssMenuController;
use App\Http\Controllers\Manage\CommunicationMasterController;
use App\Http\Controllers\Manage\HrOperationsController;
use App\Http\Controllers\Manage\WorkflowController;
use App\Http\Controllers\Manage\ActivityController;
use App\Http\Controllers\Manage\EventController;
use App\Http\Controllers\Manage\ReasonController;
use App\Http\Controllers\Manage\NotificationController;

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('manage.dashboard');
    })->name('manage/dashboard');

    Route::get('basic', [BasicController::class, 'index'])->name('manage/basic');
    Route::get('basic_master', [BasicController::class, 'basic_master'])->name('manage/basic_master');
    Route::get('workflow_master', [BasicController::class, 'workflow_master'])->name('manage/workflow_master');


    Route::get('basicsetting', [SettingController::class, 'index'])->name('manage/basicsetting');
    Route::get('basicsetting_master', [SettingController::class, 'basicsetting_master'])->name('manage/basicsetting_master');

    //=================================Core APIS==============================
    Route::get('get_core_apis', [CoreAPIController::class, 'get_core_apis'])->name('manage/get_core_apis');
    Route::get('core_api_sync', [CoreAPIController::class, 'sync'])->name('core_api_sync');
    Route::post('importAPISData', [CoreAPIController::class, 'importAPISData'])->name('importAPISData');

    //=================================Political Location==============================
    Route::get('country', [CountryController::class, 'index'])->name('manage/country');
    Route::get('state', [StateController::class, 'index'])->name('manage/state');
    Route::get('district', [DistrictController::class, 'index'])->name('manage/district');
    Route::get('block', [BlockController::class, 'index'])->name('manage/block');
    Route::get('city_village', [CityVillageController::class, 'index'])->name('manage/city_village');

    //=================================Corporate Organogram==============================
    Route::get('function', [FunctionController::class, 'index'])->name('manage/function');
    Route::get('vertical', [VerticalController::class, 'index'])->name('manage/vertical');
    Route::get('department', [DepartmentController::class, 'index'])->name('manage/department');
    Route::get('sub_department', [SubDepartmentController::class, 'index'])->name('manage/sub_department');
    Route::get('section', [SectionController::class, 'index'])->name('manage/section');

    //=================================Business Organogram==============================
    Route::get('business_unit', [BUController::class, 'index'])->name('manage/business_unit');
    Route::get('zone', [ZoneController::class, 'index'])->name('manage/zone');
    Route::get('region', [RegionController::class, 'index'])->name('manage/region');
    Route::get('territory', [TerritoryController::class, 'index'])->name('manage/territory');

    // =================================Master Employee=================================
    Route::get('master_employee', [EmployeeController::class, 'index'])->name('manage/employee');
    Route::get('fetch_employees', [EmployeeController::class, 'fetchEmployees'])->name('manage/fetch_employees');
    Route::get('manage/employee/{id}/{tab?}', [EmployeeController::class, 'showEmployeeDetails'])->name('employee.details');
    Route::get('/manage/rolespermission', [EmployeeController::class, 'manageRolesPermissions'])->name('manage/rolespermission');

    Route::get('manage/transaction', [EmployeeController::class, 'showEmployeeDetails'])->name('manage/transaction');
    Route::get('/manage/roles-permissions', [RolePermissionController::class, 'index'])->name('roles.permissions.index');

    Route::post('/manage/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RolePermissionController::class, 'update'])->name('roles.update');
    Route::delete('/manage/roles/{role}', [RolePermissionController::class, 'destroy'])->name('roles.destroy');
    Route::get('/permissions', [RolePermissionController::class, 'index'])->name('permissions.index');
    Route::post('/assign-role-bulk', [EmployeeController::class, 'assignRoleBulk'])->name('assign.role.bulk');


    Route::get('/user/{id}/permissions/edit', [EmployeeController::class, 'editPermissions'])->name('user.permission.edit');
    Route::post('/user/{id}/permissions/update', [EmployeeController::class, 'updatePermissions'])->name('user.permission.update');
    Route::get('manage/menumasteremployee', [EssMenuController::class, 'index'])->name('manage/menumasteremployee');

    Route::post('manage/menumasteremployee/store', [EssMenuController::class, 'store'])->name('menumasteremployee.store');
    Route::post('menumasteremployee/update', [EssMenuController::class, 'update'])->name('menumasteremployee/update');
    Route::post('menumasteremployee/delete', [EssMenuController::class, 'destroy'])->name('menumasteremployee/delete');

    Route::post('/menu-names', [EssMenuController::class, 'storeMenuList'])->name('menu-names.store');


    Route::get('/manage/communicationmaster', [CommunicationMasterController::class, 'index'])->name('manage/communicationmaster');
    Route::post('/communication-control/store', [CommunicationMasterController::class, 'store'])->name('communication.store');
    Route::post('/communication/toggle-status', [CommunicationMasterController::class, 'toggleStatus'])->name('communication.toggleStatus');
    Route::post('communicationmaster/delete', [CommunicationMasterController::class, 'destroy'])->name('communicationmaster/delete');
    Route::post('communicationmaster/update', [CommunicationMasterController::class, 'update'])->name('communication.update');


    Route::get('hroperations', [HrOperationsController::class, 'index'])->name('manage/hroperations');
    Route::get('hroperations_master', [HrOperationsController::class, 'hroperations_master'])->name('manage/hroperations_master');
    Route::get('hroperationsworkflow_master', [HrOperationsController::class, 'hroperationsworkflow_master'])->name('manage/hroperationsworkflow_master');
    Route::get('manage/transactions', [HrOperationsController::class, 'transactions'])->name('manage/transactions');

    Route::get('manage/activity', [HrOperationsController::class, 'activity'])->name('manage/activity');
    Route::get('manage/events', [HrOperationsController::class, 'events'])->name('manage/events');
    Route::get('manage/reason', [HrOperationsController::class, 'reason'])->name('manage/reason');
    Route::get('manage/notification', [HrOperationsController::class, 'notification'])->name('manage/notification');
    Route::get('manage/reports', [HrOperationsController::class, 'reports'])->name('manage/reports');
    Route::get('manage/policy', [HrOperationsController::class, 'policy'])->name('manage/policy');

    //transaction master(hr operation)
    Route::post('/transactions/store', [HrOperationsController::class, 'store'])->name('transactions.store');
    Route::post('/transactions/update/{id}', [HrOperationsController::class, 'update'])->name('transactions.update');
    Route::get('/get-latest-parent-options', [HrOperationsController::class, 'getParentOptions'])->name('parent.options');
    Route::delete('/transactions/{id}', [HrOperationsController::class, 'destroy'])->name('transactions.destroy');
    Route::get('/transactions/options', [HrOperationsController::class, 'parentOptions'])->name('parent.options.modal');

   
    Route::get('/workflow/new-joining', [WorkflowController::class, 'newJoining'])->name('workflow.new.joining');
    Route::get('/workflow/transfer', [WorkflowController::class, 'transfer'])->name('workflow.transfer');
    Route::get('/workflow/deputation', [WorkflowController::class, 'deputation'])->name('workflow.deputation');
    Route::get('/workflow/confirmation', [WorkflowController::class, 'confirmation'])->name('workflow.confirmation');
    Route::get('/workflow/transfer/location', [WorkflowController::class, 'transferlocation'])->name('workflow.transfer.location');
    Route::get('/workflow/transfer/department', [WorkflowController::class, 'transferdepartment'])->name('workflow.transfer.department');

    //activity master(hr operation)

    Route::post('/activities', [ActivityController::class, 'store'])->name('activity.store');
    Route::post('/activities/update/{id}', [ActivityController::class, 'update'])->name('activity.update');
    Route::get('/activities/{id}', [ActivityController::class, 'show'])->name('activities.show');
    Route::delete('/activities/{id}', [ActivityController::class, 'destroy'])->name('activities.destroy');
    
    //events master(hr operation)
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');


    //=================================Reason Master (HR Operation)==============================

    Route::post('/reasons/store', [ReasonController::class, 'store'])->name('reasons.store');
    Route::put('/reasons/{reasons}', [ReasonController::class, 'update'])->name('reasons.update');
    Route::delete('/reasons/{id}', [ReasonController::class, 'destroy'])->name('reasons.destroy');


    //=================================Notification Master (HR Operation)==============================

    Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications/update/{id}', [NotificationController::class, 'update'])->name('notifications.update');


});

