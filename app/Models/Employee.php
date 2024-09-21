<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{

        protected $table = 'hrm_employee';
        protected $primaryKey = 'EmployeeID';
        public $incrementing = false;

        // Defined to relationship with EmployeeGeneral model
        public function employeeGeneral()
        {
                return $this->hasOne(EmployeeGeneral::class, 'EmployeeID', 'EmployeeID');
        }

        // Define the relationship with Designation model
        public function designation()
        {
                return $this->hasOneThrough(Designation::class, EmployeeGeneral::class, 'EmployeeID', 'DesigId', 'EmployeeID', 'DesigId');
        }
        public function reportingdesignation()
        {
                return $this->hasOneThrough(Designation::class, EmployeeGeneral::class, 'EmployeeID', 'DesigId', 'EmployeeID', 'ReportingDesigId');
        }

        // Define the relationship with Department model

        public function department()
        {
                return $this->hasOneThrough(Department::class, EmployeeGeneral::class, 'EmployeeID', 'DepartmentId', 'EmployeeID', 'DepartmentId');
        }

        // Define the relationship with Grade model
        public function grade()
        {
                return $this->hasOneThrough(Grade::class, EmployeeGeneral::class, 'EmployeeID', 'GradeId', 'EmployeeID', 'GradeId');
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


        //Define the relationship with Family model

        public function familydata()
        {
                return $this->hasOne(Family::class, 'EmployeeID', 'EmployeeID');
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

}
