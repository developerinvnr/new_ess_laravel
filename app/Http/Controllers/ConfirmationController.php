<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;
use App\Mail\Confirmation\Confirmation;
use Validator;
use Carbon\Carbon;
use App\Models\HrmYear;


class ConfirmationController extends Controller
{
   
        public function store(Request $request)
        { 
            if ($request->submit_type == 'draft') {
            
                    // Check if all assessment options are empty
                    $assessmentFields = [
                        'communication_clarity_option',
                        'job_knowledge_option',
                        'output_option',
                        'initiative_option',
                        'interpersonal_skills_option',
                        'problem_solving_option',
                        'attitude_option',
                        'attendance_punctuality_option'
                    ];
                
                    // Flag to check if all fields are empty
                    $allEmpty = true;
                
                    // Loop through each assessment field
                    foreach ($assessmentFields as $field) {
                        if (!empty($request->$field)) {
                            $allEmpty = false;  // If any field has a value, set flag to false
                            break;  // No need to continue checking if one field already has a value
                        }
                    }
                
                    // If all fields are empty, return an error
                    if ($allEmpty) {
                        return response()->json(['success' => false, 'message' => 'At least one assessment field must be filled'], 200);
                    }
                
            }

            if ($request->submit_type == 'final') {
                if (empty($request->strength) || empty($request->improvement)) {
                    return response()->json(['success' => false, 'message' => 'All Fields are mandatory'], 200);
                }
                 // Check if any of the assessment options are empty
                $assessmentFields = [
                    'communication_clarity_option',
                    'job_knowledge_option',
                    'output_option',
                    'initiative_option',
                    'interpersonal_skills_option',
                    'problem_solving_option',
                    'attitude_option',
                    'attendance_punctuality_option'
                ];

                foreach ($assessmentFields as $field) {
                    if (empty($request->$field)) {
                        return response()->json(['success' => false, 'message' => ucfirst(str_replace('_', ' ', $field)) . ' is mandatory'], 200);
                    }
                }
                if($request->recommendation == "extendProbationRadio")   {
                    if(empty($request->probationReason)){
                        return response()->json(['success' => false, 'message' => 'Probation Reason is mandatory '], 200);
                    }
                    $recom = '2';
                    $status = 'D';

    
                }
                if($request->recommendation == "confirmedOnDateRadio")   {
                    $recom = '1';
                    $status = 'A';

                }
            
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeedetails = Employee::where('EmployeeID', $request->employeeId)->first();
                    $empcode = $employeedetails->EmpCode;
    
                    $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'subject'=>'Employee Confirmation',
                        'EmpName'=> $Empname,
                        'EmpCode'=>$empcode,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details
                
                      ];
                    //   Mail::to('vspl.hr@vnrseeds.com')->send(new Confirmation($details));
            }
            
            if($request->submit_type == "draft")   {
                // Validation rules to make sure all required fields are provided
                if($request->recommendation == "confirmedOnDateRadio")   {
                    $recom = '1';
                    $status = 'A';

                }
                if($request->recommendation == "extendProbationRadio")   {
                    $recom = '2';
                    $status = 'D';

                }
                $draft = 'Y';
                $submitstatus='N';

            } 
            
            if($request->submit_type == "final")   {
                $final = 'Y';
                $submitstatus='Y';
            }
           
            $currentYear = date('Y');
            $nextYear = $currentYear + 1;

            // Retrieve the year record from the hrm_year table
            $yearRecord = HrmYear::where('FromDate', 'like', "$currentYear-%")
                ->where('ToDate', 'like', "$nextYear-%")
                ->first();
            if (!$yearRecord) {
                return response()->json(['success' => false, 'message' => 'Year record not found for the interval.'], 404);
            }
            $year_id = $yearRecord->YearId;

            try {
                // Prepare data to insert
                $data = [
                    'EmployeeID' => $request->employeeId,
                    'Communi' => $request->communication_clarity_option,
                    'JobKnowl' => $request->job_knowledge_option,
                    'OutPut' => $request->output_option,
                    'Initiative' => $request->initiative_option,
                    'InterSkill' => $request->interpersonal_skills_option,
                    'ProblemSolve' => $request->problem_solving_option,
                    'Attitude' => $request->attitude_option,
                    'Attendance' => $request->attendance_punctuality_option,
                    'Rating' => $request->overallRating,
                    'Recommendation' => $recom,
                    'Reason' => $request->probation_reason,
                    'draft_submit'=> $draft??NULL,
                    'ConfDate'=> $request->confirmationdate,
                    'SubmitStatus'=>$submitstatus,
                    'Status'=>$status,
                    'CreatedDate' => now(), // Ensure to add created_at timestamp
                    'updated_at' => now() , // Ensure to add updated_at timestamp
                    'Rep_Fill_Date'=>now(),
                    'YearId'=>$year_id,
                    'EmpStrenght'=>$request->strength,
                    'AreaImprovement'=>$request->improvement,
                    'CreatedBy'=>Auth::user()->EmployeeID

                ];
                    // Check if the record exists for the given employee_id
        $existingRecord = \DB::table('hrm_employee_confletter')->where('EmployeeID', $request->employeeId)->first();

        if ($existingRecord) {
            // If record exists, update the existing one
            \DB::table('hrm_employee_confletter')
                ->where('EmployeeID', $request->employeeId)
                ->update($data);
        } else {
            // If no record exists, insert a new one
            \DB::table('hrm_employee_confletter')->insert($data);
        }

        // Return success response
        return response()->json(['success' => true,'message' => 'Data updated successfully']);
            
            } catch (\Exception $e) {
                // Handle any errors and return error response
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        public function getEmployeeConfirmationData(Request $request)
{
    $employeeId = $request->employeeId;

    // Fetch data from your database
    $data = \DB::table('hrm_employee_confletter') // assuming your table name is 'employee_confirmations'
    ->where('EmployeeID', $employeeId)
    ->where('Status','A')
    ->first();
    if ($data) {
        return response()->json(['success' => true, 'data' => $data]);
    } else {
        return response()->json(['success' => false, 'message' => 'No data found for this employee.']);
    }
}
    }
    
