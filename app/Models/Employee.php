<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Employee extends Authenticatable
{

        protected $table = 'hrm_employee';
        protected $primaryKey = 'EmployeeID';
        public $incrementing = false;
        protected $fillable = ['EmpPass','ChangePwd'];
       
        public function employee()
        {
            return $this->belongsTo(Employee::class, 'EmployeeID', 'EmployeeID');
        }
        // Defined to relationship with EmployeeGeneral model
        public function employeeGeneral()
        {
                return $this->hasOne(EmployeeGeneral::class, 'EmployeeID', 'EmployeeID');
        }

        // Define the relationship with Designation model
        public function designation()
        {
                return $this->hasOneThrough(Designation::class, EmployeeGeneral::class, 'EmployeeID', 'id', 'EmployeeID', 'DesigId');
        }
        public function reportingdesignation()
        {
                return $this->hasOneThrough(Designation::class, EmployeeGeneral::class, 'EmployeeID', 'id', 'EmployeeID', 'ReportingDesigId');
        }

        // Define the relationship with Department model

        public function department()
        {
                return $this->hasOneThrough(Department::class, EmployeeGeneral::class, 'EmployeeID', 'id', 'EmployeeID', 'DepartmentId');
        }

        // Define the relationship with Grade model
        public function grade()
        {
                return $this->hasOneThrough(Grade::class, EmployeeGeneral::class, 'EmployeeID', 'id', 'EmployeeID', 'GradeId');
        }

        // Define the relationship with Personal model
        public function personaldetails()
        {
                return $this->hasOne(Personaldetails::class, 'EmployeeID', 'EmployeeID');
        }

        //Define the relationship with Contact model 
        public function contactDetails()
        {
                return $this->hasOne(Contact::class, 'EmployeeID', 'EmployeeID');
        }

        //Define the relationship with City & State model 
        public function cityDetails()
        {
                return $this->hasOneThrough(City::class, Contact::class, 'EmployeeID', 'CityId', 'EmployeeID', 'CurrAdd_City');
        }
        public function parcityDetails()
        {
                return $this->hasOneThrough(City::class, Contact::class, 'EmployeeID', 'CityId', 'EmployeeID', 'ParAdd_City');
        }
        public function stateDetails()
        {
                return $this->hasOneThrough(State::class, Contact::class, 'EmployeeID', 'StateId', 'EmployeeID', 'CurrAdd_State');
        }
        public function parstateDetails()
        {
                return $this->hasOneThrough(State::class, Contact::class, 'EmployeeID', 'StateId', 'EmployeeID', 'ParAdd_State');
        }

        //Define the relationship with Qualification model

        public function qualificationsdata()
        {
                return $this->hasMany(Qualification::class, 'EmployeeID', 'EmployeeID');
        }
        public function attendancedata()
        {
                return $this->hasMany(Attendance::class, 'EmployeeID', 'EmployeeID');
        }


        //Define the relationship with Family model

        public function familydata()
        {
                return $this->hasOne(Family::class, 'EmployeeID', 'EmployeeID');
        }
        public function familydataanother()
        {
                return $this->hasOne(Familyanother::class, 'EmployeeID', 'EmployeeID');
        }


        //Define the relationship with Family model

        public function languageData()
        {
                return $this->hasMany(LanguageProficiency::class, 'EmployeeID', 'EmployeeID');
        }

        public function companyTrainingTitles()
        {
                return $this->hasManyThrough(CompanyTraining::class,CompanyTrainingParticipate::class,'EmployeeID', 'TrainingId','EmployeeID','TrainingId');
        }

        public function employeeExperience()
        {
                return $this->hasMany(EmployeeExperience::class, 'EmployeeID', 'EmployeeID');
        }
        public function employeephoto()
        {
                return $this->hasOne(Employeephoto::class, 'EmployeeID', 'EmployeeID');
        }

        //tree of reporting employee

        public function reportingEmployees()
        {
            return $this->hasMany(EmployeeGeneral::class, 'RepEmployeeID', 'EmployeeID');
        }
        public function getReportingHierarchy($employeeId)
        {
        // Fetch the employee with the given ID
        $employee = EmployeeGeneral::find($employeeId);
        if (!$employee) {
                return null; 
        }

        $hrmemployee = \DB::table('hrm_employee')
        ->where('EmployeeID', $employee->EmployeeID)
        ->first();

        $firstName = $hrmemployee->Fname ?? '';
        $secondName = $hrmemployee->Sname ?? '';
        $lastName = $hrmemployee->Lname ?? '';

        $full_name = trim("{$firstName} {$secondName} {$lastName}");


        $hierarchy = [
                'EmployeeID' => $employee->EmployeeID,
                'Name' => $full_name,
                'reports' => []
        ];

        // Fetch all employees that report to the current employee
        $reports = EmployeeGeneral::where('RepEmployeeID', $employeeId)->get();

        foreach ($reports as $report) {
                // Recursively build the hierarchy for each reporting employee
                $hierarchy['reports'][] = $this->getReportingHierarchy($report->EmployeeID);
        }

        return $hierarchy;
        }
        // public function departments()
        // {
        //         return $this->hasMany(Department::class, 'CompanyId', 'CompanyId')
        //         ->where('is_active', 'A')
        //         ->whereHas('subjects', function ($query) {
        //                 // Ensure that the department has at least one related entry in hrm_deptquerysub
        //                 $query->whereNotNull('DeptQSubject'); // You can modify this condition as per your requirement
        //             })
        //         ->orderBy('DepartmentCode', 'ASC');
        // }
        public function departments()
        {
                return $this->hasMany(Department::class, 'id', 'DepartmentId')
                ->where('is_active', 'A')
                ->whereHas('subjects', function ($query) {
                        $query->whereNotNull('DeptQSubject'); 
                    })
                ->orderBy('department_code', 'ASC');
        }

    public function departmentsWithQueries()
    {
        return $this->hasManyThrough(
            DepartmentSubject::class, // Final model
            Department::class,        // Intermediate model
            'id',              // Foreign key on departments table
            'DepartmentId',           // Foreign key on department subjects table
            'id',              // Local key on hrm_employee table
            'id'            // Local key on departments table
        );
    }

    public function queryMap()
    {
        return $this->hasMany(QueryMapEmp::class, 'EmployeeID', 'EmployeeID')->orderBy('QueryDT', 'desc'); // Order by QueryDT in descending order

    }

    public function employeeAttendance()
    {
        return $this->hasMany(Attendance::class, 'EmployeeID', 'EmployeeID');
    }
//     public function employeeleave()
//     {
//         return $this->hasMany(EmployeeApplyLeave::class, 'EmployeeID', 'EmployeeID')->orderBy('created_at', 'desc');
// }
        public function employeeleave()
        {
        $currentYear = Carbon::now()->year; // Get the current year

        return $this->hasMany(EmployeeApplyLeave::class, 'EmployeeID', 'EmployeeID')
                        ->whereYear('Apply_FromDate', $currentYear) // Filter by the current year
                        ->orderBy('created_at', 'desc'); // Order by created_at in descending order
        }
    public function employeePaySlip()
    {
        return $this->hasMany(PaySlip::class, 'EmployeeID', 'EmployeeID');
    }
    public function employeeAttendanceRequest()
    {
        return $this->hasMany(AttendanceRequest::class, 'EmployeeID', 'EmployeeID');
    }
    public function employeeAssetReq()
    {
        return $this->hasMany(AssetRequest::class, 'EmployeeID', 'EmployeeID');
    }
    public function employeeAssetvehcileReq()
    {
        return $this->hasMany(HrmEmployeeVehicle::class, 'EmployeeID', 'EmployeeID');
    }
    public function employeeAssetOffice()
    {
        return $this->hasMany(EmployeeAssests::class, 'EmployeeID', 'EmployeeID');
    }
 
 

}
