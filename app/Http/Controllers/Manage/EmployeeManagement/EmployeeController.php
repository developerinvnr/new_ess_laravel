<?php

namespace App\Http\Controllers\Manage\EmployeeManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\EmployeeManagement\EmployeeModel;
use App\Models\Backend\CorporateOrg\Department as DepartmentModel;
use App\Models\Backend\CorporateOrg\FunctionModel as FunctionModel;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Employee;


class EmployeeController extends Controller
{
    // public function index()
    // {
    //     $departments = DepartmentModel::active()->get();
    //     $functions = FunctionModel::active()->get();
    //     $roles = Role::all();

    //     return view('manage.basic.employee.employee', compact('departments', 'functions','roles'));
    // }
    

    public function index()
    {
        $departments = DepartmentModel::active()->get();
        $functions = FunctionModel::active()->get();
        $roles = Role::all();

        // Prepare mapping of role => employee IDs who already have all its permissions
      $roleWiseCheckedEmployees = [];

        foreach ($roles as $role) {
            $rolePermissionIds = DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->pluck('permission_id')
                ->toArray();

            // Get employees with any of these permissions (at least one)
            if (!empty($rolePermissionIds)) {
                $employeeIdsWithPermission = DB::table('model_has_permissions')
                    ->where('model_type', Employee::class)
                    ->whereIn('permission_id', $rolePermissionIds)
                    ->pluck('model_id')
                    ->unique()
                    ->toArray();
            } else {
                $employeeIdsWithPermission = [];
            }

            // Get employees who have this role assigned directly
            $employeeIdsWithRole = DB::table('model_has_roles')
                ->where('model_type', Employee::class)
                ->where('role_id', $role->id)
                ->pluck('model_id')
                ->toArray();

            // Combine both arrays and unique
            $combinedEmployeeIds = array_unique(array_merge($employeeIdsWithRole, $employeeIdsWithPermission));

            // Now filter $combinedEmployeeIds to keep only those present in model_has_permissions table (any permission)
            $validEmployeeIds = DB::table('model_has_permissions')
                ->where('model_type', Employee::class)
                ->whereIn('model_id', $combinedEmployeeIds)
                ->distinct()
                ->pluck('model_id')
                ->toArray();

            // Assign filtered array to result
            $roleWiseCheckedEmployees[$role->name] = $validEmployeeIds;
        }



        return view('manage.basic.employee.employee', compact(
            'departments',
            'functions',
            'roles',
            'roleWiseCheckedEmployees'
        ));
    }
public function fetchEmployees(Request $request)
{
    $employeeModel = new EmployeeModel();
    $filters = ['function' => $request->function, 'department' => $request->department, 'status' => $request->status, 'vcode' => $request->vcode];
    $employees = $employeeModel->getEmployeeList($filters);

    // Add roles info for each employee
    foreach ($employees as &$employee) {
        // Fetch roles assigned to this employee by model_has_roles join with roles table
        $roles = DB::table('model_has_roles')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('model_has_roles.model_type', Employee::class)
            ->where('model_has_roles.model_id', $employee->EmployeeID) // or the proper PK
            ->pluck('roles.name')
            ->toArray();

        // Add roles as array or comma-separated string
        $employee->roles = $roles;  // or implode(', ', $roles) if you want string
    }

    return response()->json(['success' => true, 'data' => $employees]);
}

    // public function fetchEmployees(Request $request)
    // {
    //     $employeeModel = new EmployeeModel();
    //     $filters = ['function' => $request->function, 'department' => $request->department, 'status' => $request->status, 'vcode' => $request->vcode];
    //     $employees = $employeeModel->getEmployeeList($filters);
    //     return response()->json(['success' => true, 'data' => $employees,]);
    // }
    public function showEmployeeDetails($id)
    {
        
        $employee = $this->getEmployeeDetails($id);
        $generalInfo = $this->getGeneralInfo($id);
        $contactDetails = $this->getContactDetails($id);
        $educationDetails = $this->getEducationDetails($id);
        $familyDetails = $this->getFamilyDetails($id);
        $languageDetails = $this->getLanguageDetails($id);
        $trainingDetails = $this->getTrainingDetails($id);
        $experienceDetails = $this->getExperienceDetails($id);
        $ctcDetails = $this->getCTCDetails($id);
        $assetsDetails = $this->getAssetsDetails($id);
        $assetsRequestDetails = $this->getAssetsRequestDetails($id);
        $allData = ['id' => $id, 'employee' => $employee, 'generalInfo' => $generalInfo, 'contactDetails' => $contactDetails, 'educationDetails' => $educationDetails, 'familyDetails' => $familyDetails, 'languageDetails' => $languageDetails, 'trainingDetails' => $trainingDetails, 'experienceDetails' => $experienceDetails, 'ctcDetails' => $ctcDetails, 'assetsDetails' => $assetsDetails, 'assetsRequestDetails' => $assetsRequestDetails,];
        return view('manage.basic.employee.employee_view', $allData);
    }
    private function getEmployeeDetails($id)
    {
      
        $columns = ['eg.EmployeeID', 'e.EmpCode', DB::raw("CONCAT(e.Fname, ' ', e.Sname, ' ', e.Lname) AS employee_name"), 'ecd.designation_name', 'eg.DateJoining', 'eg.EmailId_Vnr', 'cf.function_name as function', 'cv.vertical_name as vertical', 'd.department_name as department', 'g.GradeValue', DB::raw("
                CASE 
                    WHEN eg.TerrId > 0 THEN ct.territory_name 
                    ELSE ccvs.city_village_name 
                END AS headquarter
            "), 'cr.region_name', 'cz.zone_name'];
        return DB::table('hrm_employee_general as eg')->select($columns)->leftJoin('hrm_employee as e', 'eg.EmployeeID', '=', 'e.EmployeeID')->leftJoin('hrm_grade as g', 'eg.GradeId', '=', 'g.GradeId')->leftJoin('core_designation as ecd', 'eg.DesigId', '=', 'ecd.id')->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')->leftJoin('core_verticals as cv', 'eg.EmpVertical', '=', 'cv.id')->leftJoin('core_functions as cf', 'eg.EmpFunction', '=', 'cf.id')->leftJoin('core_regions as cr', 'eg.RegionId', '=', 'cr.id')->leftJoin('core_zones as cz', 'eg.ZoneId', '=', 'cz.id')->leftJoin('core_city_village_by_state as ccvs', 'eg.HqId', '=', 'ccvs.id')->leftJoin('core_territory as ct', 'eg.TerrId', '=', 'ct.id')->where('eg.EmployeeID', $id)->first();
    }
    private function getGeneralInfo($id)
    {
        $columns = ['eg.EmployeeID', 'e.EmpCode', DB::raw("CONCAT(e.Fname, ' ', e.Sname, ' ', e.Lname) AS employee_name"), 'eg.DOB', 'ep.Gender', 'ep.BloodGroup', 'ep.Married', 'ep.MarriageDate', 'ep.MobileNo', 'ep.EmailId_Self', 'ep.PanNo', 'ep.DrivingLicNo', 'eg.InsuCardNo', 'eg.BankName', 'eg.AccountNo', 'eg.BranchName', 'eg.PfAccountNo', 'eg.PF_UAN', DB::raw("CONCAT(rep.Fname, ' ', rep.Sname, ' ', rep.Lname) AS reporting_name"), 'cd.designation_name as reporting_designation', 'eg.ReportingContactNo', 'eg.ReportingEmailId',];
        return DB::table('hrm_employee_general as eg')->select($columns)->leftJoin('hrm_employee as e', 'eg.EmployeeID', '=', 'e.EmployeeID')->leftJoin('hrm_employee_personal as ep', 'eg.EmployeeID', '=', 'ep.EmployeeID')->leftJoin('hrm_employee_reporting as er', 'eg.EmployeeID', '=', 'er.EmployeeID')->leftJoin('hrm_employee as rep', 'er.AppraiserId', '=', 'rep.EmployeeID')->leftJoin('core_designation as cd', 'eg.ReportingDesigId', '=', 'cd.id')->where('eg.EmployeeID', $id)->first();
    }
    private function getContactDetails($id)
    {
        $columns = ['ec.CurrAdd', 'ec.ParAdd', 'ec.Emg_Contact1', 'ec.Emg_Person1', 'ec.Emp_Relation1', 'ec.Emg_Contact2', 'ec.Emg_Person2', 'ec.Emp_Relation2', 'ec.ParAdd_PinNo', 'ec.CurrAdd_PinNo', 'cs.state_name as curr_state_name', 'pcs.state_name as par_state_name', 'hcc.CityName as curr_city', 'hpc.CityName as par_city',];
        return DB::table('hrm_employee_general as eg')->leftJoin('hrm_employee_contact as ec', 'eg.EmployeeID', '=', 'ec.EmployeeID')->leftJoin('core_states as cs', 'ec.CurrAdd_State', '=', 'cs.id')->leftJoin('core_states as pcs', 'ec.ParAdd_State', '=', 'pcs.id')->leftJoin('hrm_city as hcc', 'ec.CurrAdd_City', '=', 'hcc.CityId')->leftJoin('hrm_city as hpc', 'ec.ParAdd_City', '=', 'hpc.CityId')->select($columns)->where('eg.EmployeeID', $id)->first();
    }
    private function getEducationDetails($id)
    {
        $columns = ['eq.Qualification', 'eq.Specialization', 'eq.Institute', 'eq.Subject', 'eq.Grade_Per', 'eq.PassOut'];
        return DB::table('hrm_employee_qualification as eq')->where('eq.EmployeeId', $id)->select($columns)->get();
    }
    private function getFamilyDetails($id)
    {
        $commonColumns = ['FamilyRelation', 'Prefix', 'FamilyName', 'FamilyDOB', 'FamilyQualification', 'FamilyOccupation'];
        $fatherColumns = [DB::raw("'Father' as FamilyRelation"), 'Fa_SN as Prefix', 'FatherName as FamilyName', 'FatherDOB as FamilyDOB', 'FatherQuali as FamilyQualification', 'FatherOccupation as FamilyOccupation'];
        $motherColumns = [DB::raw("'Mother' as FamilyRelation"), 'Mo_SN as Prefix', 'MotherName as FamilyName', 'MotherDOB as FamilyDOB', 'MotherQuali as FamilyQualification', 'MotherOccupation as FamilyOccupation'];
        $spouseColumns = [DB::raw("'Spouse' as FamilyRelation"), 'HW_SN as Prefix', 'HusWifeName as FamilyName', 'HusWifeDOB as FamilyDOB', 'HusWifeQuali as FamilyQualification', 'HusWifeOccupation as FamilyOccupation'];
        $otherFamilyColumns = ['FamilyRelation', 'Fa2_SN as Prefix', 'FamilyName', 'FamilyDOB', 'FamilyQualification', 'FamilyOccupation'];
        $fatherDetails = DB::table('hrm_employee_family')->where('EmployeeID', $id)->whereNotIn('FatherDOB', ['1970-01-01', '0000-00-00'])->select($fatherColumns);
        $motherDetails = DB::table('hrm_employee_family')->where('EmployeeID', $id)->whereNotIn('MotherDOB', ['1970-01-01', '0000-00-00'])->select($motherColumns);
        $spouseDetails = DB::table('hrm_employee_family')->where('EmployeeID', $id)->whereNotIn('HusWifeDOB', ['1970-01-01', '0000-00-00'])->select($spouseColumns);
        $otherFamilyDetails = DB::table('hrm_employee_family2')->where('EmployeeID', $id)->whereNotIn('FamilyDOB', ['1970-01-01', '0000-00-00'])->select($otherFamilyColumns);
        return $fatherDetails->union($motherDetails)->union($spouseDetails)->union($otherFamilyDetails)->get()->map(function ($item) use ($commonColumns) {
            return array_combine($commonColumns, [$item->FamilyRelation, $item->Prefix, $item->FamilyName, $item->FamilyDOB, $item->FamilyQualification, $item->FamilyOccupation]);
        });
    }
    private function getLanguageDetails($id)
    {
        $columns = ['Language', 'LangCheck', 'Write_lang', 'Read_lang', 'Speak_lang'];
        return DB::table('hrm_employee_langproficiency')->select($columns)->where('EmployeeId', $id)->get();
    }
    private function getTrainingDetails($id)
    {
        $columns = ['TraName', 'TraDate', 'FromDate', 'ToDate', 'TraDuration', 'Location', 'Institute', 'TrainerName'];
        return DB::table('hrm_employee_training')->select($columns)->where('EmployeeId', $id)->get();
    }
    private function getExperienceDetails($id)
    {
        $columns = ['ExpFromDate', 'ExpToDate', 'ExpComName', 'ExpDesignation', 'ExpTotalYear'];
        return DB::table('hrm_employee_experience')->select($columns)->where('EmployeeID', $id)->get();
    }
    private function getCTCDetails($id)
    {
        $columns = ['BAS_Value', 'HRA_Value', 'SPECIAL_ALL_Value', 'Tot_GrossMonth', 'PF_Employee_Contri_Value', 'NetMonthSalary_Value', 'GrossSalary_PostAnualComponent_Value', 'GRATUITY_Value', 'PF_Employer_Contri_Value', 'Mediclaim_Policy', 'PerformancePay_value', 'Tot_CTC', 'TotCtc', 'EmpAddBenifit_MediInsu_value'];
        return DB::table('hrm_employee_ctc')->select($columns)->where('EmployeeID', $id)->first();
    }
    private function getEligibilityDetails($id) {}
    private function getDocumentsDetails($id) {}
    private function getInvestmentDetails($id) {}
    private function getSeparationDetails($id) {}
    private function getQueryDetails($id) {}
    private function getAssetsDetails($id)
    {
        $columns = ['ase.AssetEmpId', 'an.AssetName', 'ase.AComName', 'ase.AModelName', 'ase.AAllocate', 'ase.ADeAllocate'];
        return DB::table('hrm_asset_employee as ase')->select($columns)->leftJoin('hrm_asset_name as an', 'ase.AssetNId', '=', 'an.AssetNId')->where('ase.EmployeeID', 169)->where('ase.Status', 1)->get();
    }
    private function getAssetsRequestDetails($id)
    {
        $columns = ['ase.AssetEmpReqId', 'an.AssetName', 'ase.ComName', 'ase.ModelName', 'ase.ReqDate'];
        return DB::table('hrm_asset_employee_request as ase')->leftJoin('hrm_asset_name as an', 'ase.AssetNId', '=', 'an.AssetNId')->select($columns)->where('ase.EmployeeID', 169)->where('ase.Status', 1)->get();
    }
    public function manageRolesPermissions()
    {
        $roles = Role::where('id', '!=', 1)->orderBy('id', 'DESC')->get();
        // Define custom module order
        $moduleOrder = ['Employee', 'Admin'];

        // Retrieve, organize, and sort permissions
        $permissions = Permission::orderBy('group_name')
            ->get()
            ->groupBy('module')
            ->sortBy(
                fn($_, $module) =>
                array_search($module, $moduleOrder) !== false ? array_search($module, $moduleOrder) : PHP_INT_MAX
            )
            ->map(
                fn($moduleItems) =>
                $moduleItems->groupBy('group_name')->map(
                    fn($groupItems) =>
                    $groupItems->map(fn($item) => [
                        'name' => $item->name,
                        'id' => $item->id,
                    ])->toArray()
                )->toArray()
            )->toArray();
        return view('manage.basic.employee.roles', compact('roles', 'permissions'));

    }



public function assignRoleBulk(Request $request)
{
    $request->validate([
        'employee_ids' => 'required|array',
        'role' => 'required|string', // this is role name
    ]);

    $role = Role::where('name', $request->role)->first();

    if (!$role) {
        return response()->json(['success' => false, 'message' => 'Role not found.'], 404);
    }

    // Fetch all permissions linked to the role
    $permissionIds = DB::table('role_has_permissions')
        ->where('role_id', $role->id)
        ->pluck('permission_id');

    if ($permissionIds->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'No permissions assigned to this role.'], 404);
    }

    foreach ($request->employee_ids as $empId) {
        $user = Employee::find($empId);
        if (!$user) continue;

        // Optionally update role if needed
        $user->syncRoles([$role->name]);

        // Assign each permission to model_has_permissions
        foreach ($permissionIds as $permId) {
            $alreadyExists = DB::table('model_has_permissions')->where([
                ['permission_id', '=', $permId],
                ['model_type', '=', Employee::class],
                ['model_id', '=', $empId],
            ])->exists();

            if (!$alreadyExists) {
                DB::table('model_has_permissions')->insert([
                    'permission_id' => $permId,
                    'model_type' => Employee::class,
                    'model_id' => $empId,
                ]);
            }
        }
    }

    return response()->json(['success' => true, 'message' => 'Role and permissions assigned to selected employees.']);
}
    public function editPermissions($id)
    {
        $user = Employee::findOrFail($id);

        $allPermissions = Permission::all();

        $userPermissions = $user->getDirectPermissions()->pluck('name')->toArray();   
        $user->load('roles');

        return view('manage.basic.employee.editpermission', compact('user', 'allPermissions', 'userPermissions'));
    }
   public function updatePermissions(Request $request, $id)
{
    $user = Employee::findOrFail($id);

    // Get requested permissions (from JS)
    $permissions = $request->input('permissions', []);

    // Extract only permission names that are checked
    $permissionNames = collect($permissions)
        ->filter(fn($perm) => isset($perm['checked']) && $perm['checked'])
        ->pluck('permission')
        ->toArray();

    // Convert permission names to IDs
    $permissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();

    // Get currently assigned permission IDs for this user
    $existingPermissionIds = \DB::table('model_has_permissions')
        ->where('model_type', get_class($user))
        ->where('model_id', $user->EmployeeID)
        ->pluck('permission_id')
        ->toArray();

    // Add new
    $newPermissionIds = array_diff($permissionIds, $existingPermissionIds);

    foreach ($newPermissionIds as $permId) {
        \DB::table('model_has_permissions')->insert([
            'permission_id' => $permId,
            'model_type' => get_class($user),
            'model_id' => $user->EmployeeID,
        ]);
    }

    // Remove unchecked ones
    $removePermissionIds = array_diff($existingPermissionIds, $permissionIds);

    \DB::table('model_has_permissions')
        ->where('model_type', get_class($user))
        ->where('model_id', $user->EmployeeID)
        ->whereIn('permission_id', $removePermissionIds)
        ->delete();

    return response()->json([
        'message' => 'Permissions updated successfully.',
    ]);
}




}
