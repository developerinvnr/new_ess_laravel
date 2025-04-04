<?php

use App\Http\Controllers\Manage\BasicController;
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

Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('manage.dashboard');
    })->name('manage/dashboard');

    Route::get('basic', [BasicController::class, 'index'])->name('manage/basic');
    Route::get('basic_master', [BasicController::class, 'basic_master'])->name('manage/basic_master');

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

});
