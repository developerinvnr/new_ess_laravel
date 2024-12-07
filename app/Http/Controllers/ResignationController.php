<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeSeparation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\ResignationMail;
use App\Models\HrmYear;
use App\Models\EmployeeReporting;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class ResignationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ResDate' => 'required|date',
            'RelDate' => 'required|date',
            'Reason' => 'required|string',
            'SCopy' => 'required|file|mimes:jpg,jpeg,png,pdf|max:1024', // Max size 1MB
        ], [
            'SCopy.required' => 'Upload Resignation letter',  // Custom error message for the file field
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false, 
                'message' => $validator->errors()->first()  // Get the first validation error message
            ]);
        }

        // Handle the file upload
        if ($request->hasFile('SCopy')) {
            $file = $request->file('SCopy');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path('uploads/resignation_letters');
            $file->move($filePath, $fileName);
        }

        // Other existing logic to retrieve employee data and prepare for insertion
        $reportingDetails = EmployeeReporting::where('EmployeeID',Auth::user()->EmployeeID )->first();
        
        // Fetch CompanyId from hrm_employee and CostCenter from hrm_employeegeneral
        $rEI = \DB::table('hrm_employee')
                ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
                ->select('hrm_employee.CompanyId')
                ->where('hrm_employee.EmployeeID', Auth::user()->EmployeeID) // Specify the EmployeeID you are looking for
                ->first(); // Fetch first record (if exists)

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
        // $idlogactid = \DB::table('hrm_department')
        //             ->whereIn('DepartmentCode', ['LOGISTICS','HR'])
        //             ->where('CompanyId', $rEI->CompanyId)
        //             ->pluck('DepartmentId'); // No need for `get()` here since `pluck` retrieves the value directly.
            
        //     $allemployeeid = \DB::table('hrm_employee_separation_nocdept_emp')
        //     ->whereIn('DepartmentId', $idlogactid)
        //     ->where('Status', '=', 'A')
        //     ->get();
        //             dD($allemployeeid);

        // Default values for optional fields
        $RId = $reportingDetails->AppraiserId ?? 0;
        $HtId = $reportingDetails->HodId ?? 0;
        // Create a new resignation record in the database
        $resignation = new EmployeeSeparation();
        $resignation->EmployeeID = Auth::user()->EmployeeID; // Assuming the logged-in user is the employee
        $resignation->Emp_ResignationDate = $request->ResDate;
        $resignation->Emp_RelievingDate = $request->RelDate;
        $resignation->Emp_Reason = $request->Reason;
        $resignation->SprUploadFile = $fileName; // Store the file name in the DB
        $resignation->Rep_EmployeeID = $RId;
        $resignation->Hod_EmployeeID = $HtId;
        $resignation->Emp_SaveDate = NOW();
        $resignation->YearId = $year_id;

        $resignation->save();

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Your resignation request has been submitted successfully.']);
    }

    private function sendEmails($employee)
    {
        $this->sendEmails($employee);

        $appraiser = $employee->appraiser;
        $hod = $employee->hod;

        // Sending email to appraiser
        if ($appraiser) {
            Mail::to($appraiser->email)->send(new ResignationMail($employee));
        }

        // Sending email to HOD
        if ($hod) {
            Mail::to($hod->email)->send(new ResignationMail($employee));
        }

        // You can add more emails as needed for HR and others
    }
    // This method will return the calculated Relieving Date based on the employee's ID
    // public function calculateRelievingDate(Request $request)
    // {
    //     // Get the EmployeeID passed via the AJAX request
    //     $EmployeeId = $request->EmployeeId;
        
    //     // Fetch employee data
    //     $resEmp = \DB::table('hrm_employee_general as g')
    //         ->join('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
    //         ->where('g.EmployeeID', $EmployeeId)
    //         ->select('e.EmpCode', 'g.DepartmentId', 'g.DateConfirmationYN', 'g.ConfirmHR')
    //         ->first(); 

    //     // Calculate the date offsets using Carbon
    //     $After15Day = Carbon::now()->addDays(15)->format('Y-m-d');
    //     $After30Day = Carbon::now()->addDays(30)->format('Y-m-d');
    //     $After90Day = Carbon::now()->addDays(90)->format('Y-m-d');

    //     // Initialize the RelDate variable
    //     $RelDate = null;

    //     // Determine the RelDate based on conditions
    //     if ($resEmp->DateConfirmationYN == 'N' && $resEmp->ConfirmHR == 'N') {
    //         if ($resEmp->EmpCode >= 711 && in_array($resEmp->DepartmentId, [6, 3, 12])) {
    //             $RelDate = $After30Day;
    //             $relievingDateValue = 30;
    //         } else {
    //             $RelDate = $After15Day;
    //             $relievingDateValue = 15;
    //         }
    //     } else {
    //         if ($resEmp->EmpCode >= 711 && in_array($resEmp->DepartmentId, [6, 3, 12])) {
    //             $RelDate = $After90Day;
    //             $relievingDateValue = 90;
    //         } else {
    //             $RelDate = $After30Day;
    //             $relievingDateValue = 30;
    //         }
    //     }

    //     // Return the calculated date as JSON
    //     return response()->json(['RelDate' => $RelDate]);
    // }
    public function calculateRelievingDate(Request $request)
    {
        $EmployeeId = $request->EmployeeId;
    
        // Fetch employee data
        $resEmp = \DB::table('hrm_employee_general as g')
            ->join('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
            ->where('g.EmployeeID', $EmployeeId)
            ->select('e.EmpCode', 'g.DepartmentId', 'g.DateConfirmationYN', 'g.ConfirmHR')
            ->first();
    
        // Check if the relieving date already exists in the database
        $existingData = \DB::table('hrm_employee_separation')
            ->where('EmployeeID', $EmployeeId)
            ->first(['Emp_ResignationDate', 'Emp_RelievingDate', 'Emp_Reason', 'SprUploadFile']); // Get all relevant fields
    
        if ($existingData) {
            // If data already exists, return it
            return response()->json([
                'Emp_ResignationDate' => $existingData->Emp_ResignationDate,
                'Emp_RelievingDate' => $existingData->Emp_RelievingDate,
                'Emp_Reason' => $existingData->Emp_Reason,
                'SprUploadFile' => $existingData->SprUploadFile
            ]);
        }
    
        // If no existing data, calculate the new relieving date
        $After15Day = Carbon::now()->addDays(15)->format('Y-m-d');
        $After30Day = Carbon::now()->addDays(30)->format('Y-m-d');
        $After90Day = Carbon::now()->addDays(90)->format('Y-m-d');
    
        // Initialize the RelDate variable
        $RelDate = null;
    
        // Determine the RelDate based on conditions
        if ($resEmp->DateConfirmationYN == 'N' && $resEmp->ConfirmHR == 'N') {
            if ($resEmp->EmpCode >= 711 && in_array($resEmp->DepartmentId, [6, 3, 12])) {
                $RelDate = $After30Day;
            } else {
                $RelDate = $After15Day;
            }
        } else {
            if ($resEmp->EmpCode >= 711 && in_array($resEmp->DepartmentId, [6, 3, 12])) {
                $RelDate = $After90Day;
            } else {
                $RelDate = $After30Day;
            }
        }
    
        // Return the calculated date and empty other fields if needed
        return response()->json([
            'Emp_ResignationDate' => null,  // No resignation date yet
            'Emp_RelievingDate' => $RelDate, // Calculated relieving date
            'Emp_Reason' => null,  // No reason yet
            'SprUploadFile' => null  // No file yet
        ]);
    }
    

}
