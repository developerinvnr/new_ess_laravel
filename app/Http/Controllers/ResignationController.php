<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeSeparation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\Separation\SeparationMail;
use App\Mail\Separation\SeparationMailExit;
use App\Mail\Separation\SeparationMailExitRepo;
use App\Mail\Separation\SeparationMailRepo;
use App\Mail\Separation\SeparationMailLog;
use App\Mail\Separation\SeparationMailAccountClr;
use App\Mail\Separation\SeparationMailClearRepo;
use App\Models\HrmYear;
use App\Models\EmployeeReporting;
use App\Mail\RevertBackSep\RevertBackMail;
use App\Models\Department;
use App\Models\EmployeeGeneral;
use app\Models\EmployeeSeparationNocDeptEmp;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ResignationController extends Controller
{
    public function store(Request $request)
    {
        $employeegrade = Auth::user()->employeegeneral->GradeId;

        $grade = DB::table('core_grades')
        ->select('grade_name', 'id')
        ->where('id', $employeegrade)
        ->where('company_id', '1')
        ->where('is_active', '1')
        ->first(); // Fetch a single row as an object
    
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
            // $filePath = public_path('uploads/resignation_letters');
            $filePath = base_path('Employee/SprUploadFile');
            $file->move($filePath, $fileName);
        }
        
        // Other existing logic to retrieve employee data and prepare for insertion
        $reportingDetails = EmployeeReporting::where('EmployeeID',Auth::user()->EmployeeID )->first();
        $appraid = $reportingDetails->AppraiserId;
            $revirid = $reportingDetails->ReviewerId;
            $hodid = $reportingDetails->HodId;
       
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
    
            // Step 1: Fetch department_id from core_departments where department_code == 'HR'
            $department = Department::where('department_code', 'HR')->first();
            if (!$department) {
                return response()->json(['success' => false, 'message' => 'HR Department not found.'], 404);
            }

            // Step 2: Fetch EmployeeIDs from hrm_employee_separation_nocdept_emp for the given department_id
            $employeeIdhr =\DB::select('SELECT EmployeeID FROM hrm_employee_separation_nocdept_emp WHERE DepartmentId = 5');
            $employeeIdhr = $employeeIdhr[0]->EmployeeID;  // 182

            $log_id =\DB::select('SELECT EmployeeID FROM hrm_employee_separation_nocdept_emp WHERE DepartmentId = 9');
            $log_id = $log_id[0]->EmployeeID;  // 182

        // Default values for optional fields
        $RId = $reportingDetails->AppraiserId ?? 0;
        $HtId = $reportingDetails->HodId ?? 0;
        $currentDate = Carbon::now();

        $dateAfter3Days = $currentDate->copy()->addDays(3);
        if ($dateAfter3Days->isSunday()) {
            $dateAfter3Days->addDay(); // Add an extra day if it's Sunday
        }
        // Create a new resignation record in the database
        $resignation = new EmployeeSeparation();
        $resignation->EmployeeID = Auth::user()->EmployeeID; // Assuming the logged-in user is the employee
        $resignation->Emp_ResignationDate = $request->ResDate;
        $resignation->Emp_RelievingDate = $request->RelDate;
        $resignation->Emp_Reason = $request->Reason;
        $resignation->SprUploadFile = $fileName; // Store the file name in the DB
        $resignation->Rep_EmployeeID = $RId;
        $resignation->Rep_Approved = 'P';
        $resignation->HR_UserId=$employeeIdhr;
        $resignation->Hod_EmployeeID = $HtId;
        $resignation->HOD_Date = $dateAfter3Days;
        $resignation->Log_EmployeeID = $log_id ?? '';
        $resignation->Emp_SaveDate = NOW();
        $resignation->YearId = $year_id;

    // Attempt to save the resignation
    if ($resignation->save()) {
        // Fetch Employee General and Employee Information
        $reportinggeneral = EmployeeGeneral::where('EmployeeID', Auth::user()->EmployeeID)->first();
        $reportinggeneralappraiser = EmployeeGeneral::where('EmployeeID',$appraid)->first();
        $reportinggeneralreviwer = EmployeeGeneral::where('EmployeeID', $revirid)->first();
        $reportinggeneralhoid = EmployeeGeneral::where('EmployeeID', $hodid)->first();

        $employeedetails = Employee::where('EmployeeID', Auth::user()->EmployeeID)->first();

                $ReportingEmailId = $reportinggeneral->ReportingEmailId ?? null;
                $ReportingEmailIdapp = $reportinggeneralappraiser?->EmailId_Vnr;
                $ReportingEmailIdrev = $reportinggeneralreviwer?->EmailId_Vnr;
                $ReportingEmailIdhoid = $reportinggeneralhoid?->EmailId_Vnr;
                

                // Join tables to get employee's department and designation details
                $employeeDetailsdep = \DB::table('hrm_employee as e')
                    ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                    ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
                    ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
                    ->where('e.EmployeeID', Auth::user()->EmployeeID)
                    ->select(
                        'e.EmployeeID',
                        'e.Fname',
                        'e.Lname',
                        'e.Sname',
                        'e.EmpCode',
                        'd.department_name',
                        'dg.designation_name'
                    )
                    ->first();

                // Prepare Employee Full Name
                $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');

                // Prepare Email Details
                $details = [
                    'subject' => 'Separation Request',
                    'EmpName' => $Empname,
                    'DepartmentName' => $employeeDetailsdep->department_name,
                    'DesigName' => $employeeDetailsdep->designation_name,
                    'site_link' => "https://vnrseeds.co.in"  // Assuming the site link is fixed
                ];

               // Collect all emails in an array
                    $emails = [
                        $ReportingEmailId, 
                        $ReportingEmailIdapp, 
                        $ReportingEmailIdrev, 
                        $ReportingEmailIdhoid
                    ];

                   
                // Send email only once to unique recipients
                if ($grade && $grade->id >= 67) {
                    // Remove duplicates and null values
                    $uniqueEmails = array_values(array_filter(array_unique($emails)));

                    // Always send only **one mail per unique email**
                    foreach ($uniqueEmails as $email) {
                        Mail::to($email)->send(new SeparationMail($details));
                    }
                    // Always send to these fixed HR emails separately
                    $hrEmails = ['fd@vnrseeds.com', 'vspl.hr@vnrseeds.com'];
                    Mail::to($hrEmails)->send(new SeparationMail($details));
                } else {
                    $uniqueEmails = array_values(array_filter(array_unique($emails)));
                    // Always send only **one mail per unique email**
                    foreach ($uniqueEmails as $email) {
                            Mail::to($email)->send(new SeparationMail($details));
                    }
                        // Always send to these fixed HR emails separately
                        $hrEmails = ['vspl.hr@vnrseeds.com'];
                        Mail::to($hrEmails)->send(new SeparationMail($details));
                }
                
                // Return a success response to the user
                return response()->json(['success' => true, 'message' => 'Your resignation request has been submitted successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'There was an error processing your resignation. Please try again.']);
            }

    }

    public function sendEmail(Request $request)
    {
        $resEmp = \DB::table('hrm_employee_separation')
        ->where('EmpSepId', $request->EmpSepId)
        ->select('EmployeeID')
        ->first();
        $employeedetails = Employee::where('EmployeeID', $resEmp->EmployeeID)->first();

    
                    $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                    
                    $details = [
                        'subject'=>'Separation revert back ',
                        'Hrname'=>'Hr Team',
                        'EmployeeName'=> $Empname,
                        'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
                
                      ];
                    //   $mail =  Mail::to('vspl.hr@vnrseeds.com')->send(new RevertBackMail($details));
                     //$mail =  Mail::to('preetinanda.vspl@gmail.com')->send(new RevertBackMail($details));

                     if($mail){
                        return response()->json(['success' => true, 'message' => 'Mail sent '], 200);

                     }
                     else{
                        return response()->json(['success' => false, 'message' => 'Mail sent fail'], 200);

                     }
    }

    public function calculateRelievingDate(Request $request)
    {
        $EmployeeId = $request->EmployeeId;
    
        // Fetch employee data
        $resEmp = \DB::table('hrm_employee_general as g')
            ->leftJoin('hrm_employee as e', 'g.EmployeeID', '=', 'e.EmployeeID')
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
    
    // SeparationController.php (Method)
    public function updateRepRelievingDate(Request $request)
    {
        $request->validate([
            'EmpSepId' => 'required|integer|exists:hrm_employee_separation,EmpSepId',  // Ensuring EmpSepId exists in the table
            // 'Rep_RelievingDate' => 'nullable|date',  // Ensure date format is correct
            // 'Rep_Approved' => 'required|in:Y,N',  // Ensure status is either 'Y' or 'N'
            // 'HR_Approved' => 'required|in:Y,N',  // Ensure status is either 'Y' or 'N'
            // 'HR_RelievingDate' => 'nullable|date',  // Ensure date format is correct
        ]);

        // Find the separation record by ID
        $separation = EmployeeSeparation::find($request->EmpSepId);

        if ($separation) {
            // Conditionally update the Repo. Relieving Date if it's provided
            // if ($request->has('Rep_RelievingDate') && $request->Rep_RelievingDate) {

            $userEmployeeId = Auth::user()->EmployeeID; // Get the logged-in user's Employee ID

            // Check if the authenticated user is either the Rep_Id or Hod_Id
            if ($userEmployeeId == $separation->Rep_EmployeeID ) {
                $separation->Rep_RelievingDate = $request->Rep_RelievingDate;
                $separation->Rep_Approved = $request->Rep_Approved;
                $separation->Rep_Remark = $request->Rep_Remark;
                 // Save the updates if any field was changed
                $separation->save();
            }

            if ($userEmployeeId == $separation->Hod_EmployeeID ) {
                
                $separation->Hod_RelievingDate = $request->Rep_RelievingDate;
                $separation->Hod_Approved = $request->Rep_Approved;
                $separation->Hod_Remark = $request->Rep_Remark;
                 // Save the updates if any field was changed
                $separation->save();
            }
        

        $employeeDetailsdep = \DB::table('hrm_employee as e')
        ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
        ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
        ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
        ->where('e.EmployeeID', $separation->EmployeeID)
        ->select(
            'e.EmployeeID',
            'e.Fname',
            'e.Lname',
            'e.Sname',
            'e.EmpCode',
            'd.department_name',
            'dg.designation_name'
        )
        ->first();
        if($request->Rep_Approved == 'Y'){
            $status = 'Approved';
        }
        elseif($request->Rep_Approved == 'N'){
            $status = 'Pending';
        }
        else{
            $status = 'Pending';
        }

             
                $Empname = ($employeeDetailsdep->Fname ?? 'null').' ' . ($employeeDetailsdep->Sname ?? 'null').' ' . ($employeeDetailsdep->Lname ?? 'null');
                $details = [
                    'subject'=>'Separation Approval Status ',
                    'EmpName'=> $Empname,
                    'Action'=>$status,
                    'DepartmentName'=> $employeeDetailsdep->department_name??'-',
                    'DesigName'=> $employeeDetailsdep->designation_name?? '-',
                    'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
            
                ];

                //  Mail::to('vspl.hr@vnrseeds.com')->send(new SeparationMailRepo($details));
                // Mail::to('preetinanda.vspl@gmail.com')->send(new SeparationMailRepo($details));

            

                return response()->json(['success' => true, 'message' => 'Reporting/HOD status has been updated'], 200);
            
            }
            // if ($request->has('HR_Approved') && $request->HR_Approved) {
            //     $separation->HR_Approved = $request->HR_Approved;
            // }
            // if ($request->has('HR_RelievingDate') && $request->HR_RelievingDate) {
            //     $separation->HR_RelievingDate = $request->HR_RelievingDate;
            // }

            // Conditionally update the Approval Status if it's provided
            // if ($request->has('Rep_Approved') && $request->Rep_Approved) {
            //     $separation->Rep_Approved = $request->Rep_Approved;
            //     $separation->Rep_Remark = $request->Rep_Remark;

            //     $separation->save();
            //     return response()->json(['success' => true, 'message' => 'Reporting Approval has been updated'], 200);
            
            // }
        
            return response()->json(['success' => false, 'message' => 'No separation data found'], 404);

           
    }
    public function submitNocClearanceit(Request $request)
        {
            // Validate incoming request data
            $validatedData = $request->validate([
                'EmpSepId' => 'required',
                'sim_submitted' => 'nullable|array',
                'sim_recovery_amount' => 'nullable|numeric',
                'sim_remarks' => 'nullable|string',
                'handset_submitted' => 'nullable|array',
                'handset_recovery_amount' => 'nullable|numeric',
                'handset_remarks' => 'nullable|string',
                'laptop_handover' => 'nullable|array',
                'laptop_recovery_amount' => 'nullable|numeric',
                'laptop_remarks' => 'nullable|string',
                'camera_submitted' => 'nullable|array',
                'camera_recovery_amount' => 'nullable|numeric',
                'camera_remarks' => 'nullable|string',
                'datacard_submitted' => 'nullable|array',
                'datacard_recovery_amount' => 'nullable|numeric',
                'datacard_remarks' => 'nullable|string',
                'email_blocked' => 'nullable|array',
                'email_recovery_amount' => 'nullable|numeric',
                'email_remarks' => 'nullable|string',
                'mobile_disabled' => 'nullable|array',
                'mobile_recovery_amount' => 'nullable|numeric',
                'mobile_remarks' => 'nullable|string',
                'any_remarks' => 'nullable|string',
                'button_id' => 'required|string',
            ]);
            $buttonId = $request->input('button_id');

            // // Assuming $request and $buttonId are already available
            // if ($buttonId == "final-submit-btn-it") {
            //     // Custom validation to ensure all fields are filled
            //     if (
            //         empty($request->sim_submitted) || empty($request->sim_recovery_amount) ||
            //         empty($request->handset_submitted) || empty($request->handset_recovery_amount) ||
            //         empty($request->laptop_handover) || empty($request->laptop_recovery_amount) ||
            //         empty($request->camera_submitted) || empty($request->camera_recovery_amount) ||
            //         empty($request->datacard_submitted) || empty($request->datacard_recovery_amount) ||
            //         empty($request->email_blocked) || empty($request->email_recovery_amount) ||
            //         empty($request->mobile_disabled) || empty($request->mobile_recovery_amount)
            //     ) {
            //         return response()->json([
            //             'success' => false,
            //             'message' => 'All fields are mandatory',
            //         ], 422);
            //     }
            // }
            
           if ($buttonId == "save-draft-btn-it") {

                if (
                    empty($request->sim_submitted) && empty($request->sim_recovery_amount) &&
                    empty($request->handset_submitted) && empty($request->handset_recovery_amount) &&
                    empty($request->laptop_handover) && empty($request->laptop_recovery_amount) &&
                    empty($request->camera_submitted) && empty($request->camera_recovery_amount) &&
                    empty($request->datacard_submitted) && empty($request->datacard_recovery_amount) &&
                    empty($request->email_blocked) && empty($request->email_recovery_amount) &&
                    empty($request->mobile_disabled) && empty($request->mobile_recovery_amount)
                ) {
                   
                
                    return response()->json([
                       'success' => false,
                       'message' => 'At least one of the fields should have a value.',
                   ], 422);
               }
           }
           if ($buttonId == "final-submit-btn-it") {

            if (
                empty($request->sim_submitted) || empty($request->sim_recovery_amount) ||
                empty($request->handset_submitted) || empty($request->handset_recovery_amount) ||
                empty($request->laptop_handover) || empty($request->laptop_recovery_amount) ||
                empty($request->camera_submitted) || empty($request->camera_recovery_amount) ||
                empty($request->datacard_submitted) || empty($request->datacard_recovery_amount) ||
                empty($request->email_blocked) || empty($request->email_recovery_amount) ||
                empty($request->mobile_disabled) || empty($request->mobile_recovery_amount)
            ) {
               
            
                return response()->json([
                   'success' => false,
                   'message' => 'All fields are mandatory',
               ], 422);
           }
       }
        
            // Get the button ID (save-draft-btn or final-submit-btn)
        
            // Initialize variables for final_submit and draft_submit
            $finalSubmit = 'N';
            $draftSubmit = 'N';
        
            // Check which button was clicked
            if ($buttonId == "final-submit-btn-it") {
                // Set final_submit to 'Y' if final submit was clicked
                $finalSubmit = 'Y';
                $ITsubmit = 'Y';
            } elseif ($buttonId == "save-draft-btn-it") {
                // Set draft_submit to 'Y' if save draft was clicked
                $draftSubmit = 'Y';
                $ITsubmit = 'N';
             }

        // Check if any of the fields have a value of "Yes"
        if (
            in_array("Yes", (array) $request->sim_submitted) || 
            in_array("Yes", (array) $request->handset_submitted) || 
            in_array("Yes", (array) $request->laptop_handover) || 
            in_array("Yes", (array) $request->camera_submitted) || 
            in_array("Yes", (array) $request->email_blocked) || 
            in_array("Yes", (array) $request->mobile_disabled) || 
            in_array("Yes", (array) $request->datacard_submitted)
        ) {
            $yesdata = "Y";  // Set to "Y" if any field has "Yes"
        }

        // Check if any of the fields have a value of "No" and make sure "Yes" hasn't been set
        if (
            in_array("No", (array) $request->sim_submitted) || 
            in_array("No", (array) $request->handset_submitted) || 
            in_array("No", (array) $request->laptop_handover) || 
            in_array("No", (array) $request->camera_submitted) || 
            in_array("No", (array) $request->email_blocked) || 
            in_array("No", (array) $request->mobile_disabled) || 
            in_array("No", (array) $request->datacard_submitted)
        ) {
            $yesdata = "N";  // Set to "N" if any field has "No"
        }

        // SIM Submitted
        $simSubmitted = null;
        if (in_array("Yes", (array) $request->sim_submitted)) {
            $simSubmitted = "Y";
        } elseif (in_array("No", (array) $request->sim_submitted)) {
            $simSubmitted = "N";
        }

        // Handset Submitted
        $handsetSubmitted = null;
        if (in_array("Yes", (array) $request->handset_submitted)) {
            $handsetSubmitted = "Y";
        } elseif (in_array("No", (array) $request->handset_submitted)) {
            $handsetSubmitted = "N";
        }

        // Laptop Handover
        $laptopHandover = null;
        if (in_array("Yes", (array) $request->laptop_handover)) {
            $laptopHandover = "Y";
        } elseif (in_array("No", (array) $request->laptop_handover)) {
            $laptopHandover = "N";
        }

        // Camera Submitted
        $cameraSubmitted = null;
        if (in_array("Yes", (array) $request->camera_submitted)) {
            $cameraSubmitted = "Y";
        } elseif (in_array("No", (array) $request->camera_submitted)) {
            $cameraSubmitted = "N";
        }

        // Email Blocked
        $emailBlocked = null;
        if (in_array("Yes", (array) $request->email_blocked)) {
            $emailBlocked = "Y";
        } elseif (in_array("No", (array) $request->email_blocked)) {
            $emailBlocked = "N";
        }

        // Mobile Disabled
        $mobileDisabled = null;
        if (in_array("Yes", (array) $request->mobile_disabled)) {
            $mobileDisabled = "Y";
        } elseif (in_array("No", (array) $request->mobile_disabled)) {
            $mobileDisabled = "N";
        }

        // Datacard Submitted
        $datacardSubmitted = null;
        if (in_array("Yes", (array) $request->datacard_submitted)) {
            $datacardSubmitted = "Y";
        } elseif (in_array("No", (array) $request->datacard_submitted)) {
            $datacardSubmitted = "N";
        }
            // Calculate the total recovery amount
            $totalAmount = 0;

            // Helper function to safely add amounts
            function addAmount($amount) {
                return is_numeric($amount) ? floatval($amount) : 0;
            }

            // Add all recovery amounts
            $totalAmount += addAmount($validatedData['sim_recovery_amount'] ?? 0);
            $totalAmount += addAmount($validatedData['handset_recovery_amount'] ?? 0);
            $totalAmount += addAmount($validatedData['laptop_recovery_amount'] ?? 0);
            $totalAmount += addAmount($validatedData['camera_recovery_amount'] ?? 0);
            $totalAmount += addAmount($validatedData['datacard_recovery_amount'] ?? 0);
            $totalAmount += addAmount($validatedData['email_recovery_amount'] ?? 0);
            $totalAmount += addAmount($validatedData['mobile_recovery_amount'] ?? 0);

           
        
            // Prepare the data for insertion or update
            $nocClearanceData = [
                'EmpSepId' => $validatedData['EmpSepId'],
                'final_submit_it' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
                'draft_submit_it' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
                'NocSubmitDate' => now(),  // Current date and time
                'ItSS' => $simSubmitted,
                'ItSS_Amt' => $validatedData['sim_recovery_amount'] ?? null,
                'ItSS_Remark' => $validatedData['sim_remarks'] ?? null,
        
                'ItCHS' => $handsetSubmitted,
                'ItCHS_Amt' => $validatedData['handset_recovery_amount'] ?? null,
                'ItCHS_Remark' => $validatedData['handset_remarks'] ?? null,
        
                'ItLDH' => $laptopHandover,
                'ItLDH_Amt' => $validatedData['laptop_recovery_amount'] ?? null,
                'ItLDH_Remark' => $validatedData['laptop_remarks'] ?? null,
        
                'ItCS' => $cameraSubmitted,
                'ItCS_Amt' => $validatedData['camera_recovery_amount'] ?? null,
                'ItCS_Remark' => $validatedData['camera_remarks'] ?? null,
        
                'ItDC' => $datacardSubmitted,
                'ItDC_Amt' => $validatedData['datacard_recovery_amount'] ?? null,
                'ItDC_Remark' => $validatedData['datacard_remarks'] ?? null,
        
                'ItEAB' => $emailBlocked,
                'ItEAB_Amt' => $validatedData['email_recovery_amount'] ?? null,
                'ItEAB_Remark' => $validatedData['email_remarks'] ?? null,
        
                'ItMND' => $mobileDisabled,
                'ItMND_Amt' => $validatedData['mobile_recovery_amount'] ?? null,
                'ItMND_Remark' => $validatedData['mobile_remarks'] ?? null,
                'TotItAmt'=>$totalAmount ??null,
        
                'ItOth_Remark' => $validatedData['any_remarks'] ?? null,
            ];
        
            // Try to find an existing record by EmpSepId and update it, or insert if it doesn't exist
            $existingRecord = \DB::table('hrm_employee_separation_nocit')
                ->where('EmpSepId', $validatedData['EmpSepId'])
                ->first();
        
            if ($existingRecord) {
                // Update the existing record
                \DB::table('hrm_employee_separation_nocit')
                    ->where('EmpSepId', $validatedData['EmpSepId'])
                    ->update($nocClearanceData);
            } else {
                // Insert new record
                \DB::table('hrm_employee_separation_nocit')->insert($nocClearanceData);
            }
            $existingRecordsep = \DB::table('hrm_employee_separation')
                ->where('EmpSepId', $request->EmpSepId)
                ->first();
                $nocClearanceitnoc = [
                    'IT_NOC' => $ITsubmit
                ];
            if ($existingRecordsep) {
                // Update the existing record
                \DB::table('hrm_employee_separation')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->update($nocClearanceitnoc);
            } 
            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'NOC clearance data processed successfully',
            ]);
    }
        
    public function submitNocClearance(Request $request)
    {
        // Check if the form_id is logisticsnocform
    if($request->form_id == "logisticsnocform") {
     
        // For debugging, you can uncomment the dd() line to check the data
        
        // Initialize the variables
        $buttonId = $request->input('button_id');
        
        // Custom validation
        $validatedData = $request->validate([
            'EmpSepId' => 'required|integer',
            // Custom validations as per your data structure
            'DDH' => 'nullable|array|max:1',
            'DDH.*' => 'in:NA,Yes,No',
            'TID' => 'nullable|array|max:1',
            'TID.*' => 'in:NA,Yes,No',
            'APTC' => 'nullable|array|max:1',
            'APTC.*' => 'in:NA,Yes,No',
            'HOAS' => 'nullable|array|max:1',
            'HOAS.*' => 'in:NA,Yes,No',
        ]);

        // Initialize submission flags
        $finalSubmit = 'N';
        $draftSubmit = 'N';

        // Check which button was clicked
        if ($buttonId == "final-submit-btn-log") {
            $finalSubmit = 'Y';
            $logsubmit = 'Y';

            $nocClearanceData = []; // This is where you will store the party data

            // Prepare the data for insertion or update
            $nocClearanceData = [
                'EmpSepId' => $validatedData['EmpSepId'],  // Assuming EmpSepId is sent with the form
                // 'final_submit_log' => $finalSubmit,
                // 'draft_submit_log' => $draftSubmit,
                'Logistic_Noc_Submit_Date' => now(),
                'Oth_Remark' => $request->otherremark ?? null,

                
            ];
    
            $partyCount = 1;
            $errors = []; // To collect any errors for missing fields
            $totalRecoveryAmount = 0;
            
            while ($request->has("Parties_{$partyCount}")) {
                // Party Name
                $partyName = $request->input("Parties_{$partyCount}");
                
                // Document Data (Y or N)
                $partyDocData = $request->input("Parties_{$partyCount}_docdata");
                $partyDocDataValue = null;
                if ($partyDocData == 'Yes') {
                    $partyDocDataValue = 'Y';
                } elseif ($partyDocData == 'No') {
                    $partyDocDataValue = 'N';
                }
                elseif ($partyDocData == 'NA') {
                    $partyDocDataValue = 'NA';
                }
                
                // Recovery Amount
                $partyAmount = $request->input("Parties_{$partyCount}_Amt");
                $totalRecoveryAmount += $partyAmount; // Summing up the amounts correctly
    
                // Remarks (optional)
                $partyRemark = $request->input("Parties_{$partyCount}_Remark");
            
                // Check if the party is present and if the required fields for that party are filled
                if (empty($partyName) || empty($partyDocDataValue) || empty($partyAmount)) {
                    // If any required field is missing, add a single error message for this party
                    $errors[] = "All fields for Party {$partyCount} (Name, Document Data, and Recovery Amount) must be filled.";
                } else {
                    // All required fields are provided, add to nocClearanceData array
                    $nocClearanceData["Prtis{$partyCount}"] = $partyName;
                    $nocClearanceData["Prtis_{$partyCount}"] = $partyDocDataValue;
                    $nocClearanceData["Prtis_{$partyCount}Amt"] = $partyAmount;
                    $nocClearanceData["Prtis_{$partyCount}Remark"] = $partyRemark; // Remarks is optional, so include even if empty
                }
            
                $partyCount++;
            }
            
            // Insert or update the data in the database
            $existingRecord = \DB::table('hrm_employee_separation_nocrep')
                ->where('EmpSepId', $validatedData['EmpSepId'])
                ->first();
                $existingRecordsepa = \DB::table('hrm_employee_separation')
                ->where('EmpSepId', $validatedData['EmpSepId'])
                ->first();

     
            if ($existingRecord) {
                $totalRecoveryAmount += (float) $existingRecord->DDH_Amt;
                $totalRecoveryAmount += (float) $existingRecord->TID_Amt;
                $totalRecoveryAmount += (float) $existingRecord->APTC_Amt;
                $totalRecoveryAmount += (float) $existingRecord->HOAS_Amt;
                    // // Loop through up to 40 parties and add their amounts
                    // for ($i = 1; $i <= 40; $i++) {
                    //     $partyAmountKey = "Prtis_{$i}Amt";
                    //     if (isset($existingRecord->$partyAmountKey)) {
                    //         $totalRecoveryAmount += (float) $existingRecord->$partyAmountKey;
                    //     }
                    // }
                    while ($request->has("Parties_{$partyCount}")) {
                        $partyAmount = $request->input("Parties_{$partyCount}_Amt");
                        $totalRecoveryAmount += $partyAmount;  // Summing up the new party amounts correctly
                    
                        // Additional logic for each party...
                        // Add party details to $nocClearanceData
                        $partyCount++;
                    }
                $nocClearanceData['TotRepAmt'] = $totalRecoveryAmount;
    
                        // Update the existing record
                        \DB::table('hrm_employee_separation_nocrep')
                            ->where('EmpSepId', $request->EmpSepId)
                            ->update($nocClearanceData);
                            
                    $existingRecordsep = \DB::table('hrm_employee_separation')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->first();
                    $nocClearancelognoc = [
                        'Log_NOC' => $logsubmit
                    ];
                    if ($existingRecordsep) {
                        // Update the existing record
                        \DB::table('hrm_employee_separation')
                            ->where('EmpSepId', $request->EmpSepId)
                            ->update($nocClearancelognoc);
                    } 
    
                              // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $existingRecordsepa->EmployeeID)->first();
                    $employeedetails = Employee::where('EmployeeID', $existingRecordsepa->EmployeeID)->first();
    
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;
    
                    $ReportingName = $reportinggeneral->ReportingName;
                    $employeeDetailsdep = \DB::table('hrm_employee as e')
                    ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                    ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
                    ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
                    ->where('e.EmployeeID', Auth::user()->EmployeeID)
                    ->select(
                        'e.EmployeeID',
                        'e.Fname',
                        'e.Lname',
                        'e.Sname',
                        'e.EmpCode',
                        'd.department_name',
                        'dg.designation_name'
                    )
                    ->first();
                   
                    $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'subject'=>'Separation Logistics NOC form Clearance',
                        'EmpName'=> $Empname,
                        'ReportingName' =>$ReportingName,
                        'Action'=>$request->Rep_Approved,
                        'DepartmentName'=> $employeeDetailsdep->department_name,
                        'DesigName'=> $employeeDetailsdep->designation_name,
                        'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
                    ];
    
                    //  Mail::to(['vspl.hr@vnrseeds.com',$ReportingEmailId])->send(new SeparationMailLog($details));
                    //Mail::to('preetinanda.vspl@gmail.com')->send(new SeparationMailLog($details));
    
                     // Return success response
                    return response()->json([
                        'success' => true,
                        'message' => 'NOC clearance data processed successfully',
                       
            ]);
            } 
           
        } 
        
        elseif ($buttonId == "save-draft-btn-log") {
            $logsubmit = 'N';

            $draftSubmit = 'Y';
            $nocClearanceData = []; // This is where you will store the party data

            // Prepare the data for insertion or update
            $nocClearanceData = [
                'EmpSepId' => $validatedData['EmpSepId'],  // Assuming EmpSepId is sent with the form
                'final_submit_log' => $finalSubmit,
                'draft_submit_log' => $draftSubmit,
                'Logistic_Noc_Submit_Date' => now(),
                'Oth_Remark' => $request->otherremark ?? null,

            ];
    
            $partyCount = 1;
            $errors = []; // To collect any errors for missing fields
            $totalRecoveryAmount = 0;
            $partyCount = 1;
            $errors = []; // To collect any errors for missing fields
            $totalRecoveryAmount = 0;
    
            // while ($request->has("Parties_{$partyCount}")) {
            //     // Party Name
            //     $partyName = $request->input("Parties_{$partyCount}");
                
            //     // Document Data (Y or N)
            //     $partyDocData = $request->input("Parties_{$partyCount}_docdata");
            //     $partyDocDataValue = null;
            //     if ($partyDocData == 'Yes') {
            //         $partyDocDataValue = 'Y';
            //     } elseif ($partyDocData == 'No') {
            //         $partyDocDataValue = 'N';
            //     }
            //     elseif ($partyDocData === 'NA') {
    
            //         $partyDocDataValue = '';
            //     }
            
            //     // Recovery Amount
            //     $partyAmount = $request->input("Parties_{$partyCount}_Amt");
            //     $totalRecoveryAmount += $partyAmount; // Summing up the amounts correctly
    
            //     // Remarks (optional)
            //     $partyRemark = $request->input("Parties_{$partyCount}_Remark");
            
            //     // Check if the party is present and if the required fields for that party are filled
            //     if (empty($partyName) || empty($partyDocDataValue) || empty($partyAmount)) {
            //         // If any required field is missing, add a single error message for this party
            //         $errors[] = "All fields for Party {$partyCount} (Name, Document Data, and Recovery Amount) must be filled.";
            //     } else {
            //         // All required fields are provided, add to nocClearanceData array
            //         $nocClearanceData["Prtis{$partyCount}"] = $partyName;
            //         $nocClearanceData["Prtis_{$partyCount}"] = $partyDocDataValue;
            //         $nocClearanceData["Prtis_{$partyCount}Amt"] = $partyAmount;
            //         $nocClearanceData["Prtis_{$partyCount}Remark"] = $partyRemark; // Remarks is optional, so include even if empty
            //     }
            
            //     $partyCount++;
            // }
            
            // // If there are any errors, return them as a response
            // if (count($errors) > 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => implode(' ', $errors) // Combine error messages into one string
            //     ]);
            // }
            
            $existingRecordsep = \DB::table('hrm_employee_separation')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();
            $nocClearancelognoc = [
                'Log_NOC' => $logsubmit
            ];
            if ($existingRecordsep) {
                // Update the existing record
                \DB::table('hrm_employee_separation')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->update($nocClearancelognoc);
            } 
            // Insert or update the data in the database
            $existingRecord = \DB::table('hrm_employee_separation_nocrep')
                ->where('EmpSepId', $validatedData['EmpSepId'])
                ->first();
     
            if ($existingRecord) {
                $totalRecoveryAmount += (float) $existingRecord->DDH_Amt;
                $totalRecoveryAmount += (float) $existingRecord->TID_Amt;
                $totalRecoveryAmount += (float) $existingRecord->APTC_Amt;
                $totalRecoveryAmount += (float) $existingRecord->HOAS_Amt;
                    // // Loop through up to 40 parties and add their amounts
                    // for ($i = 1; $i <= 40; $i++) {
                    //     $partyAmountKey = "Prtis_{$i}Amt";
                    //     if (isset($existingRecord->$partyAmountKey)) {
                    //         $totalRecoveryAmount += (float) $existingRecord->$partyAmountKey;
                    //     }
                    // }
                    // while ($request->has("Parties_{$partyCount}")) {
                    //     $partyAmount = $request->input("Parties_{$partyCount}_Amt");
                    //     $totalRecoveryAmount += $partyAmount;  // Summing up the new party amounts correctly
                    
                    //     // Additional logic for each party...
                    //     // Add party details to $nocClearanceData
                    //     $partyCount++;
                    // }
                    
            while ($request->has("Parties_{$partyCount}")) {
                // Party Name
                $partyName = $request->input("Parties_{$partyCount}");
                
                // Document Data (Y or N)
                $partyDocData = $request->input("Parties_{$partyCount}_docdata");
                $partyDocDataValue = null;
                if ($partyDocData == 'Yes') {
                    $partyDocDataValue = 'Y';
                } elseif ($partyDocData == 'No') {
                    $partyDocDataValue = 'N';
                }
                elseif ($partyDocData == 'NA') {
                    $partyDocDataValue = 'NA';
                }
                
                
                // Recovery Amount
                $partyAmount = $request->input("Parties_{$partyCount}_Amt");
                $totalRecoveryAmount += $partyAmount; // Summing up the amounts correctly
    
                // Remarks (optional)
                $partyRemark = $request->input("Parties_{$partyCount}_Remark");
            
                // Check if the party is present and if the required fields for that party are filled
                if (empty($partyName) || ($partyDocDataValue === null && $partyDocData !== 'NA') || empty($partyAmount)) {
                    // If any required field is missing, add a single error message for this party
                    $errors[] = "All fields for Party {$partyCount} (Name, Document Data, and Recovery Amount) must be filled.";
                } else {
                    // All required fields are provided, add to nocClearanceData array
                    $nocClearanceData["Prtis{$partyCount}"] = $partyName;
                    $nocClearanceData["Prtis_{$partyCount}"] = $partyDocDataValue;
                    $nocClearanceData["Prtis_{$partyCount}Amt"] = $partyAmount;
                    $nocClearanceData["Prtis_{$partyCount}Remark"] = $partyRemark; // Remarks is optional, so include even if empty
                }
            
                $partyCount++;
            }
                $nocClearanceData['TotRepAmt'] = $totalRecoveryAmount;
                // Update the existing record
                \DB::table('hrm_employee_separation_nocrep')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->update($nocClearanceData);
          
    
                     // Return success response
                    return response()->json([
                        'success' => true,
                        'message' => 'NOC clearance data processed successfully',
                       
            ]);
            } 
        
        }
          
    }
        
        if($request->form_id=="departmentnocfrom"){
            // Get the button ID (save-draft-btn or final-submit-btn)
            $buttonId = $request->input('button_id');
            
            // Custom validation to ensure DDH, TID, APTC, HOAS can only have 1 value or be null
            $validatedData = $request->validate([
                'EmpSepId' => 'required|integer',
                // Custom validations as per your data structure
                'DDH' => 'nullable|array|max:1',
                'DDH.*' => 'in:NA,Yes,No',
                'TID' => 'nullable|array|max:1',
                'TID.*' => 'in:NA,Yes,No',
                'APTC' => 'nullable|array|max:1',
                'APTC.*' => 'in:NA,Yes,No',
                'HOAS' => 'nullable|array|max:1',
                'HOAS.*' => 'in:NA,Yes,No',
            ]);
            // Assuming $request and $buttonId are already available
            if ($buttonId == "final-submit-btn") {
                 // Custom validation to ensure at least one of the fields has a value
                 if (empty($request->DDH) || empty($request->TID) || empty($request->APTC) || empty($request->HOAS)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'All field is mandatory',
                    ], 422);
                }
            } elseif ($buttonId == "save-draft-btn") {

                // Custom validation to ensure at least one of the fields has a value
                if (empty($request->DDH) && empty($request->TID) && empty($request->APTC) && empty($request->HOAS)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'At least one of the fields (DDH, TID, APTC, HOAS) should have a value.',
                    ], 422);
                }
            }

            // Initialize variables for final_submit and draft_submit
            $finalSubmit = 'N';
            $draftSubmit = 'N';
        
            // Check which button was clicked
            if ($buttonId == "final-submit-btn") {
                $finalSubmit = 'Y';
                $existingRecordsep = \DB::table('hrm_employee_separation')
                ->where('EmpSepId', $request->EmpSepId)
                ->first();
                // Prepare the data for insertion or update
            $nocClearanceData = [
                'EmpSepId' => $validatedData['EmpSepId'],
                'final_submit_dep' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
                'draft_submit_dep' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
                'NocSubmitDate' => now(),  // Current date and time
                'DDH' => isset($validatedData['DDH']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['DDH'])) : null,
                'DDH_Amt' => $request->DDH_Amt ?? null,
                'DDH_Remark' => $request->DDH_Remark ?? null,
        
                'TID' => isset($validatedData['TID']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['TID'])) : null,
                'TID_Amt' => $request->TID_Amt ?? null,
                'TID_Remark' => $request->TID_Remark ?? null,
        
                'APTC' => isset($validatedData['APTC']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['APTC'])) : null,
                'APTC_Amt' =>$request->APTC_Amt ?? null,
                'APTC_Remark' =>$request->APTC_Remark ?? null,
        
                'HOAS' => isset($validatedData['HOAS']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['HOAS'])) : null,
                'HOAS_Amt' => $request->HOAS_Amt ?? null,
                'HOAS_Remark' => $request->HOAS_Remark ?? null,
                'Oth_Remark' => $request->otherreamrk ?? null,
            ];
        
            // Try to find an existing record by EmpSepId and update it, or insert if it doesn't exist
            $existingRecord = \DB::table('hrm_employee_separation_nocrep')
                ->where('EmpSepId', $validatedData['EmpSepId'])
                ->first();
        
            if ($existingRecord) {
                // Update the existing record
                \DB::table('hrm_employee_separation_nocrep')
                    ->where('EmpSepId', $validatedData['EmpSepId'])
                    ->update($nocClearanceData);
            } else {
                // Insert new record
                \DB::table('hrm_employee_separation_nocrep')->insert($nocClearanceData);
            }
            $existingRecordsep = \DB::table('hrm_employee_separation')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();
            $nocClearancedepnoc = [
                'Rep_NOC' => 'Y',
                'Department_NOC' => 'Y'

            ];
            if ($existingRecordsep) {
                // Update the existing record
                \DB::table('hrm_employee_separation')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->update($nocClearancedepnoc);
            } 
         
        $employeeDetailsdep = \DB::table('hrm_employee as e')
        ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
        ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
        ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
        ->where('e.EmployeeID', $existingRecordsep->EmployeeID)
        ->select(
            'e.EmployeeID',
            'e.Fname',
            'e.Lname',
            'e.Sname',
            'e.EmpCode',
            'd.department_name',
            'dg.designation_name'
        )
        ->first();
              // Step 2: Fetch EmployeeIDs from hrm_employee_separation_nocdept_emp for the given department_id
             
                $Empname = ($employeeDetailsdep->Fname ?? 'null').' ' . ($employeeDetailsdep->Sname ?? 'null').' ' . ($employeeDetailsdep->Lname ?? 'null');
                
                $details = [
                    'subject'=>'Department Clearance Form',
                    'EmpName'=> $Empname,
                    'Action'=>$request->Rep_Approved,
                    'DepartmentName'=> $employeeDetailsdep->department_name,
                    'DesigName'=> $employeeDetailsdep->designation_name,
                    'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
            
                ];

                //  Mail::to('vspl.hr@vnrseeds.com')->send(new SeparationMailClearRepo($details));
                //Mail::to('preetinanda.vspl@gmail.com')->send(new SeparationMailClearRepo($details));

            } 
            elseif ($buttonId == "save-draft-btn") {
                $draftSubmit = 'Y';
                // Prepare the data for insertion or update
            $nocClearanceData = [
                'EmpSepId' => $validatedData['EmpSepId'],
                'final_submit_dep' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
                'draft_submit_dep' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
                'NocSubmitDate' => now(),  // Current date and time
                'DDH' => isset($validatedData['DDH']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['DDH'])) : null,
                'DDH_Amt' => $request->DDH_Amt ?? null,
                'DDH_Remark' => $request->DDH_Remark ?? null,
        
                'TID' => isset($validatedData['TID']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['TID'])) : null,
                'TID_Amt' => $request->TID_Amt ?? null,
                'TID_Remark' => $request->TID_Remark ?? null,
        
                'APTC' => isset($validatedData['APTC']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['APTC'])) : null,
                'APTC_Amt' =>$request->APTC_Amt ?? null,
                'APTC_Remark' =>$request->APTC_Remark ?? null,
        
                'HOAS' => isset($validatedData['HOAS']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['HOAS'])) : null,
                'HOAS_Amt' => $request->HOAS_Amt ?? null,
                'HOAS_Remark' => $request->HOAS_Remark ?? null,
                'Oth_Remark' => $request->otherreamrk ?? null,
            ];
            $existingRecordsep = \DB::table('hrm_employee_separation')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();
            $nocClearancedepnoc = [
                'Rep_NOC' => 'N',
            ];
            if ($existingRecordsep) {
                // Update the existing record
                \DB::table('hrm_employee_separation')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->update($nocClearancedepnoc);
            } 
            // Try to find an existing record by EmpSepId and update it, or insert if it doesn't exist
            $existingRecord = \DB::table('hrm_employee_separation_nocrep')
                ->where('EmpSepId',$request->EmpSepId)
                ->first();
        
            if ($existingRecord) {
                // Update the existing record
                \DB::table('hrm_employee_separation_nocrep')
                    ->where('EmpSepId',$request->EmpSepId)
                    ->update($nocClearanceData);
            } else {
                // Insert new record
                \DB::table('hrm_employee_separation_nocrep')->insert($nocClearanceData);
            }
            
            }
            

            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'NOC clearance data processed successfully',
            ]);
        }
    }
    public function getNocData($empSepId,$employeeid)
    {
        // $nocData = \DB::table('hrm_employee_separation')
        //             ->leftjoin('hrm_employee_separation_nocrep', 'hrm_employee_separation.EmpSepId', '=', 'hrm_employee_separation_nocrep.EmpSepId')
        //             ->select('hrm_employee_separation.*', 'hrm_employee_separation_nocrep.*')
        //             ->where('hrm_employee_separation.EmpSepId', $empSepId)
        //             ->get();

                    $nocData = \DB::table('hrm_employee_separation_nocrep as nocrep')
                    ->leftJoin('hrm_employee_separation as sep', 'nocrep.EmpSepId', '=', 'sep.EmpSepId')
                    ->where('nocrep.EmpSepId', $empSepId)
                    ->select('sep.*', 'nocrep.*')
                    ->first();
                    // $datadealer = \DB::table('hrm_sales_dealer')
                    // ->where('Terr_vc', $employeeid)
                    // ->orWhere('Terr_fc', $employeeid)
                    // ->get();
                    $datadealer = \DB::table('core_distributors')
                    ->where('vc_emp', $employeeid)
                    ->orWhere('fc_emp', $employeeid)
                    ->select('name','city')
                    ->get(); 
    
                // Pluck DealerName and corresponding DealerCity into an associative array
                $datadealerArray = $datadealer->pluck('city', 'name')->toArray();                
                // If data exists, return it
                if ($nocData) {
                    return response()->json([
                        'success' => true,
                        'data' => $nocData,
                        'dealerNames' => $datadealerArray // Add dealer names to the response
                    ]);
                }


        // Return an error if no data found
        return response()->json([
            'success' => false,
            'message' => 'No data found for this EmpSepId'
        ]);
    }
    // SeparationController.php

    public function getReason($empSepId)
    {
        $employeeSeparation = \DB::table('hrm_employee_separation')
                            ->where('EmpSepId', $empSepId)
                            ->first();

        $employee = \DB::table('hrm_employee')
                            ->where('EmployeeID', $employeeSeparation->EmployeeID)
                            ->select('Fname','Lname','Sname')
                            ->first();   

        if ($employeeSeparation) {
            return response()->json([
                'success' => true,
                'data' => $employeeSeparation,
                'employee' => $employee

            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Employee separation data not found'
            ]);
        }
    }
    public function getExitRepoData($empSepId)
    {
        // Fetch the data from the database
        $nocData = \DB::table('hrm_employee_separation_exitint')
                    ->where('EmpSepId', $empSepId)
                    ->first();

        // If data exists, return it
        if ($nocData) {
            return response()->json([
                'success' => true,
                'data' => $nocData
            ]);
        }

        // Return an error if no data found
        return response()->json([
            'success' => false,
            'message' => 'No data found for this EmpSepId'
        ]);
    }
    public function getNocDataIt($empSepId)
    {
        // Fetch the data from the database
        $nocData = \DB::table('hrm_employee_separation_nocit')
                    ->where('EmpSepId', $empSepId)
                    ->first();

        // If data exists, return it
        if ($nocData) {
            return response()->json([
                'success' => true,
                'data' => $nocData
            ]);
        }

        // Return an error if no data found
        return response()->json([
            'success' => false,
            'message' => 'No data found for this EmpSepId'
        ]);
    }
    public function getNocDataAcct($empSepId)
    {
        $nocData = \DB::table('hrm_employee_separation_nocacc as nocacc')
        ->leftJoin('hrm_employee_separation as sep', 'nocacc.EmpSepId', '=', 'sep.EmpSepId')
        ->where('nocacc.EmpSepId', $empSepId)
        ->select(
            'nocacc.*', // Select all columns from the 'hrm_employee_separation_nocacc' table
            'sep.IT_Earn',
            'sep.IT_Deduct',
            'sep.Rep_Earn',
            'sep.Rep_Deduct',
            'sep.Acc_Earn',
            'sep.Acc_Deduct',
            'sep.Total_Deduct',
            'sep.Acc_NOC',
            'sep.Total_Earn'
        )
        ->first();
                

                    if ($nocData) {
                        // Adding the second table data to the $nocData array
                    
                        return response()->json([
                            'success' => true,
                            'data' => $nocData
                        ]);
                    }
        // Return an error if no data found
        return response()->json([
            'success' => false,
            'message' => 'No data found for this EmpSepId'
        ]);
    }
    public function getNocDataHr($empSepId,$employeeidhr)
    {
        // Fetch the data from the database
        $nocData = \DB::table('hrm_employee_separation_nochr')
                    ->where('EmpSepId', $empSepId)
                    ->first();
        $nocCTC = \DB::table('hrm_employee_ctc')
                    ->where('EmployeeID',$employeeidhr)
                    ->where('Status','A')->first();

        // If data exists, return it
        if ($nocData) {
            return response()->json([
                'success' => true,
                'data' => $nocData,
                'ctc'=>$nocCTC
            ]);
        }

        // Return an error if no data found
        return response()->json([
            'success' => false,
            'message' => 'No data found for this EmpSepId'
        ]);
    }
    public function submitNocClearanceAcct(Request $request)
    {
        
        // Get the button ID (save-draft-btn or final-submit-btn)
        $buttonId = $request->input('button_id');

        // Initialize variables for final_submit and draft_submit
        $finalSubmit = 'N';
        $draftSubmit = 'N';

        // Check which button was clicked
        if ($buttonId == "final-submit-btn-acct") {
            // Set final_submit to 'Y' if final submit was clicked
            $finalSubmit = 'Y';
            $accnoc = 'Y';
             // Prepare the data for insertion or update
        $nocClearanceData = [
            'EmpSepId' => $request->EmpSepId,
            // 'NocAccId' => $request->NocAccId,
            'final_submit_acct' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
            'draft_submit_acct' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
            'NocSubmAccDate' => now(),  // Current date and time

            // Handle the account-related fields
            'AccECP' => $request->AccECP,
            'AccECP_Amt' => $request->AccECP_Amt ?? null,
            'AccECP_Amt2' => $request->AccECP_Amt2 ?? null,
            'AccECP_Remark' => $request->AccECP_Remark ?? null,

            'AccIPS' => $request->AccIPS,
            'AccIPS_Amt' => $request->AccIPS_Amt ?? null,
            'AccIPS_Amt2' => $request->AccIPS_Amt2 ?? null,
            'AccIPS_Remark' => $request->AccIPS_Remark ?? null,

            'AccAMS' => $request->AccAMS,
            'AccAMS_Amt' => $request->AccAMS_Amt ?? null,
            'AccAMS_Amt2' => $request->AccAMS_Amt2 ?? null,
            'AccAMS_Remark' => $request->AccAMS_Remark ?? null,

            'AccSAR' => $request->AccSAR,
            'AccSAR_Amt' => $request->AccSAR_Amt ?? null,
            'AccSAR_Amt2' => $request->AccSAR_Amt2 ?? null,
            'AccSAR_Remark' => $request->AccSAR_Remark ?? null,

            'AccWGR' => $request->AccWGR,
            'AccWGR_Amt' => $request->AccWGR_Amt ?? null,
            'AccWGR_Amt2' => $request->AccWGR_Amt2 ?? null,
            'AccWGR_Remark' => $request->AccWGR_Remark ?? null,

            'AccSB' => $request->AccSB,
            'AccSB_Amt' => $request->AccSB_Amt ?? null,
            'AccSB_Amt2' => $request->AccSB_Amt2 ?? null,
            'AccSB_Remark' => $request->AccSB_Remark ?? null,

            'AccTDSA' => $request->AccTDSA,
            'AccTDSA_Amt' => $request->AccTDSA_Amt ?? null,
            'AccTDSA_Amt2' => $request->AccTDSA_Amt2 ?? null,
            'AccTDSA_Remark' => $request->AccTDSA_Remark ?? null,

            'AccRecy' => $request->AccRecy,
            'AccRecy_Amt' => $request->AccRecy_Amt ?? null,
            'AccRecy_Amt2' => $request->AccRecy_Amt2 ?? null,
            'AccRecy_Remark' => $request->AccRecy_Remark ?? null,
            'AccOth_Remark' => $request->AccRecy_Remark ?? null,
        
            // 'TotAmt'=> $request->total_earnings ?? null,
            // 'TotAmt2'=> $request->total_deductions ?? null,
            'TotAmt'=> $request->accountearnings ?? null,
            'TotAmt2'=> $request->accountdeductions ?? null,
            'TotAccAmt' => ($request->accountearnings ?? 0) + ($request->accountdeductions ?? 0),
        ];

        // Try to find an existing record by EmpSepId and NocAccId, then update it or insert if it doesn't exist
        $existingRecord = \DB::table('hrm_employee_separation_nocacc')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();
            $existingRecordsepa = \DB::table('hrm_employee_separation')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();

        if ($existingRecord) {
            // Update the existing record
            \DB::table('hrm_employee_separation_nocacc')
                ->where('EmpSepId', $request->EmpSepId)
                // ->where('NocAccId', $request->NocAccId)
                ->update($nocClearanceData);
        } 
        else {
            // Insert new record
            \DB::table('hrm_employee_separation_nocacc')->insert($nocClearanceData);
        }

        // if($request->itearnings || $request->itdeductions){
            $existingRecordsep = \DB::table('hrm_employee_separation')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();

            $nocClearanceDataearn = [
                'IT_Earn' => $request->itearnings??'0.00',
                'IT_Deduct' => $request->itdeductions??'0.00',
                'Rep_Earn' => $request->logisticsearnings??'0.00',  // Set final_submit to 'Y' or 'N'
                'Rep_Deduct' => $request->logisticsdeductions??'0.00',  // Set draft_submit to 'Y' or 'N'
                'Acc_Earn' =>$request->accountearnings ?? '0.00',  // Current date and time
                'Acc_Deduct' =>$request->accountdeductions ?? '0.00',  // Current date and time
                'Total_Deduct' =>$request->total_deductions ?? '0.00',  // Current date and time
                'Total_Earn' =>$request->total_earnings ?? '0.00',  // Current date and time
                'Acc_NOC' => $accnoc
            ];
            // dd($nocClearanceDataearn);
                if ($existingRecordsep) {
                    // Update the existing record
                    \DB::table('hrm_employee_separation')
                        ->where('EmpSepId', $request->EmpSepId)
                        ->update($nocClearanceDataearn);
                } 
            // }
                
       
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $existingRecordsepa->EmployeeID)->first();
                    $employeedetails = Employee::where('EmployeeID', $existingRecordsepa->EmployeeID)->first();
    
                    $ReportingEmailId = $reportinggeneral->ReportingEmailId;
    
                    $employeeDetailsdep = \DB::table('hrm_employee as e')
                    ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                    ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
                    ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
                    ->where('e.EmployeeID', $existingRecordsepa->EmployeeID)
                    ->select(
                        'e.EmployeeID',
                        'e.Fname',
                        'e.Lname',
                        'e.Sname',
                        'e.EmpCode',
                        'd.department_name',
                        'dg.designation_name'
                    )
                    ->first();
                 
                    $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                    $details = [
                        'subject'=>'Separation Account Clearance',
                        'EmpName'=> $Empname,
                        'DepartmentName'=> $employeeDetailsdep->department_name,
                        'DesigName'=> $employeeDetailsdep->designation_name,
                        'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
                    ];
    
                    //  Mail::to('vspl.hr@vnrseeds.com')->send(new SeparationMailAccountClr($details));
                    //Mail::to('preetinanda.vspl@gmail.com')->send(new SeparationMailAccountClr($details));

                     // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'NOC clearance account data processed successfully',
            ]);
        } 
        elseif ($buttonId == "save-draft-btn-acct") {
            // Set draft_submit to 'Y' if save draft was clicked
            $draftSubmit = 'Y';
            $accnoc = 'N';
            $nocClearanceData = [
                'EmpSepId' => $request->EmpSepId,
                // 'NocAccId' => $request->NocAccId,
                'final_submit_acct' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
                'draft_submit_acct' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
                'NocSubmAccDate' => now(),  // Current date and time
    
                // Handle the account-related fields
                'AccECP' => $request->AccECP,
                'AccECP_Amt' => $request->AccECP_Amt ?? null,
                'AccECP_Amt2' => $request->AccECP_Amt2 ?? null,
                'AccECP_Remark' => $request->AccECP_Remark ?? null,
    
                'AccIPS' => $request->AccIPS,
                'AccIPS_Amt' => $request->AccIPS_Amt ?? null,
                'AccIPS_Amt2' => $request->AccIPS_Amt2 ?? null,
                'AccIPS_Remark' => $request->AccIPS_Remark ?? null,
    
                'AccAMS' => $request->AccAMS,
                'AccAMS_Amt' => $request->AccAMS_Amt ?? null,
                'AccAMS_Amt2' => $request->AccAMS_Amt2 ?? null,
                'AccAMS_Remark' => $request->AccAMS_Remark ?? null,
    
                'AccSAR' => $request->AccSAR,
                'AccSAR_Amt' => $request->AccSAR_Amt ?? null,
                'AccSAR_Amt2' => $request->AccSAR_Amt2 ?? null,
                'AccSAR_Remark' => $request->AccSAR_Remark ?? null,
    
                'AccWGR' => $request->AccWGR,
                'AccWGR_Amt' => $request->AccWGR_Amt ?? null,
                'AccWGR_Amt2' => $request->AccWGR_Amt2 ?? null,
                'AccWGR_Remark' => $request->AccWGR_Remark ?? null,
    
                'AccSB' => $request->AccSB,
                'AccSB_Amt' => $request->AccSB_Amt ?? null,
                'AccSB_Amt2' => $request->AccSB_Amt2 ?? null,
                'AccSB_Remark' => $request->AccSB_Remark ?? null,
    
                'AccTDSA' => $request->AccTDSA,
                'AccTDSA_Amt' => $request->AccTDSA_Amt ?? null,
                'AccTDSA_Amt2' => $request->AccTDSA_Amt2 ?? null,
                'AccTDSA_Remark' => $request->AccTDSA_Remark ?? null,
    
                'AccRecy' => $request->AccRecy,
                'AccRecy_Amt' => $request->AccRecy_Amt ?? null,
                'AccRecy_Amt2' => $request->AccRecy_Amt2 ?? null,
                'AccRecy_Remark' => $request->AccRecy_Remark ?? null,
                'AccOth_Remark' => $request->AccRecy_Remark ?? null,

                'TotAmt'=> $request->accountearnings ?? null,
                'TotAmt2'=> $request->accountdeductions ?? null,
                'TotAccAmt' => ($request->accountearnings ?? 0) + ($request->accountdeductions ?? 0),
    
            ];
    
            // Try to find an existing record by EmpSepId and NocAccId, then update it or insert if it doesn't exist
            $existingRecord = \DB::table('hrm_employee_separation_nocacc')
                ->where('EmpSepId', $request->EmpSepId)
                ->first();
    
            if ($existingRecord) {
                // Update the existing record
                \DB::table('hrm_employee_separation_nocacc')
                    ->where('EmpSepId', $request->EmpSepId)
                    // ->where('NocAccId', $request->NocAccId)
                    ->update($nocClearanceData);
            } 
            else {
                // Insert new record
                \DB::table('hrm_employee_separation_nocacc')->insert($nocClearanceData);
            }
    
     
                $existingRecordsep = \DB::table('hrm_employee_separation')
                ->where('EmpSepId', $request->EmpSepId)
                ->first();
                $nocClearanceDataearn = [
                    'IT_Earn' => $request->itearnings??'0.00',
                    'IT_Deduct' => $request->itdeductions??'0.00',
                    'Rep_Earn' => $request->logisticsearnings??'0.00',  // Set final_submit to 'Y' or 'N'
                    'Rep_Deduct' => $request->logisticsdeductions??'0.00',  // Set draft_submit to 'Y' or 'N'
                    'Acc_Earn' =>$request->accountearnings ?? '0.00',  // Current date and time
                    'Acc_Deduct' =>$request->accountdeductions ?? '0.00',  // Current date and time
                    'Total_Deduct' =>$request->total_deductions ?? '0.00',  // Current date and time
                    'Total_Earn' =>$request->total_earnings ?? '0.00',  // Current date and time
                    'Acc_NOC' => $accnoc
                ];
                    if ($existingRecordsep) {
                        // Update the existing record
                        \DB::table('hrm_employee_separation')
                            ->where('EmpSepId', $request->EmpSepId)
                            ->update($nocClearanceDataearn);
                    } 
                
                return response()->json([
                    'success' => true,
                    'message' => 'NOC clearance account data processed successfully',
                ]);
        }
     

       
    }
    // public function submitNocClearanceAcct(Request $request)
    // {
        
    //     // Get the button ID (save-draft-btn or final-submit-btn)
    //     $buttonId = $request->input('button_id');

    //     // Initialize variables for final_submit and draft_submit
    //     $finalSubmit = 'N';
    //     $draftSubmit = 'N';

    //     // Check which button was clicked
    //     if ($buttonId == "final-submit-btn-acct") {
    //         // Set final_submit to 'Y' if final submit was clicked
    //         $finalSubmit = 'Y';$accnoc = 'Y';
            
    //                 // Other existing logic to retrieve employee data and prepare for insertion
    //                 $reportinggeneral = EmployeeGeneral::where('EmployeeID', Auth::user()->EmployeeID)->first();
    //                 $employeedetails = Employee::where('EmployeeID', Auth::user()->EmployeeID)->first();
    
    //                 $ReportingEmailId = $reportinggeneral->ReportingEmailId;
    
    //                 $employeeDetailsdep = \DB::table('hrm_employee as e')
    //                 ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
    //                 ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
    //                 ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
    //                 ->where('e.EmployeeID', Auth::user()->EmployeeID)
    //                 ->select(
    //                     'e.EmployeeID',
    //                     'e.Fname',
    //                     'e.Lname',
    //                     'e.Sname',
    //                     'e.EmpCode',
    //                     'd.department_name',
    //                     'dg.designation_name'
    //                 )
    //                 ->first();
                 
    //                 $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
    //                 $details = [
    //                     'subject'=>'Separation Exit Interview form Filled Status',
    //                     'EmpName'=> $Empname,
    //                     'DepartmentName'=> $employeeDetailsdep->department_name,
    //                     'DesigName'=> $employeeDetailsdep->designation_name,
    //                     'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
    //                 ];
    
    //                 Mail::to('vspl.hr@vnrseeds.com')->send(new SeparationMailAccountClr($details));
    //     } elseif ($buttonId == "save-draft-btn-acct") {
    //         // Set draft_submit to 'Y' if save draft was clicked
    //         $draftSubmit = 'Y';
    //         $accnoc = 'N';
    //     }
     

    //     // Prepare the data for insertion or update
    //     $nocClearanceData = [
    //         'EmpSepId' => $request->EmpSepId,
    //         // 'NocAccId' => $request->NocAccId,
    //         'final_submit_acct' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
    //         'draft_submit_acct' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
    //         'NocSubmAccDate' => now(),  // Current date and time

    //         // Handle the account-related fields
    //         'AccECP' => $request->AccECP,
    //         'AccECP_Amt' => $request->AccECP_Amt ?? null,
    //         'AccECP_Amt2' => $request->AccECP_Amt2 ?? null,
    //         'AccECP_Remark' => $request->AccECP_Remark ?? null,

    //         'AccIPS' => $request->AccIPS,
    //         'AccIPS_Amt' => $request->AccIPS_Amt ?? null,
    //         'AccIPS_Amt2' => $request->AccIPS_Amt2 ?? null,
    //         'AccIPS_Remark' => $request->AccIPS_Remark ?? null,

    //         'AccAMS' => $request->AccAMS,
    //         'AccAMS_Amt' => $request->AccAMS_Amt ?? null,
    //         'AccAMS_Amt2' => $request->AccAMS_Amt2 ?? null,
    //         'AccAMS_Remark' => $request->AccAMS_Remark ?? null,

    //         'AccSAR' => $request->AccSAR,
    //         'AccSAR_Amt' => $request->AccSAR_Amt ?? null,
    //         'AccSAR_Amt2' => $request->AccSAR_Amt2 ?? null,
    //         'AccSAR_Remark' => $request->AccSAR_Remark ?? null,

    //         'AccWGR' => $request->AccWGR,
    //         'AccWGR_Amt' => $request->AccWGR_Amt ?? null,
    //         'AccWGR_Amt2' => $request->AccWGR_Amt2 ?? null,
    //         'AccWGR_Remark' => $request->AccWGR_Remark ?? null,

    //         'AccSB' => $request->AccSB,
    //         'AccSB_Amt' => $request->AccSB_Amt ?? null,
    //         'AccSB_Amt2' => $request->AccSB_Amt2 ?? null,
    //         'AccSB_Remark' => $request->AccSB_Remark ?? null,

    //         'AccTDSA' => $request->AccTDSA,
    //         'AccTDSA_Amt' => $request->AccTDSA_Amt ?? null,
    //         'AccTDSA_Amt2' => $request->AccTDSA_Amt2 ?? null,
    //         'AccTDSA_Remark' => $request->AccTDSA_Remark ?? null,

    //         'AccRecy' => $request->AccRecy,
    //         'AccRecy_Amt' => $request->AccRecy_Amt ?? null,
    //         'AccRecy_Amt2' => $request->AccRecy_Amt2 ?? null,
    //         'AccRecy_Remark' => $request->AccRecy_Remark ?? null,
    //         'AccOth_Remark' => $request->AccRecy_Remark ?? null,
    //     ];

    //     // Try to find an existing record by EmpSepId and NocAccId, then update it or insert if it doesn't exist
    //     $existingRecord = \DB::table('hrm_employee_separation_nocacc')
    //         ->where('EmpSepId', $request->EmpSepId)
    //         ->first();

    //     if ($existingRecord) {
    //         // Update the existing record
    //         \DB::table('hrm_employee_separation_nocacc')
    //             ->where('EmpSepId', $request->EmpSepId)
    //             // ->where('NocAccId', $request->NocAccId)
    //             ->update($nocClearanceData);
    //     } 
    //     else {
    //         // Insert new record
    //         \DB::table('hrm_employee_separation_nocacc')->insert($nocClearanceData);
    //     }

    //     if($request->itearnings || $request->itdeductions){
    //         $existingRecordsep = \DB::table('hrm_employee_separation')
    //         ->where('EmpSepId', $request->EmpSepId)
    //         ->first();
    //         $nocClearanceDataearn = [
    //             'IT_Earn' => $request->itearnings,
    //             'IT_Deduct' => $request->itdeductions,
    //             'Rep_Earn' => $request->logisticsearnings,  // Set final_submit to 'Y' or 'N'
    //             'Rep_Deduct' => $request->logisticsdeductions,  // Set draft_submit to 'Y' or 'N'
    //             'Acc_Earn' =>$request->accountearnings ?? '0.00',  // Current date and time
    //             'Acc_Deduct' =>$request->accountdeductions ?? '0.00',  // Current date and time
    //             'Total_Deduct' =>$request->total_deductions ?? '0.00',  // Current date and time
    //             'Total_Earn' =>$request->total_earnings ?? '0.00',  // Current date and time
    //             'Acc_NOC' => $accnoc
    //         ];
    //     if ($existingRecordsep) {
    //         // Update the existing record
    //         \DB::table('hrm_employee_separation')
    //             ->where('EmpSepId', $request->EmpSepId)
    //             ->update($nocClearanceDataearn);
    //     } 
    //     }
                
    //     // Return a success response
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'NOC clearance account data processed successfully',
    //     ]);
    // }

    public function submitNocClearancehr(Request $request)
    {
          

        // Get the button ID (save-draft-btn-hr or final-submit-btn)
        $buttonId = $request->input('button_id');
        
        // Initialize variables for final_submit and draft_submit
        $finalSubmit = 'N';
        $draftSubmit = 'N';

        if ($buttonId == "final-submit-btn-hr") {
            $finalSubmit = 'Y'; // Set final_submit to 'Y' if final submit was clicked
        } elseif ($buttonId == "save-draft-btn-hr") {
            $draftSubmit = 'Y'; // Set draft_submit to 'Y' if save draft was clicked
        }

        // Prepare the data for insertion or update
        $nocClearanceData = [
            'EmpSepId' => $request->EmpSepId,
            'final_submit_hr' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
            'draft_submit_hr' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
            'NocSubmitDate' => now(),  // Current date and time
            'BEP' => $this->processCheckboxyes($request->block_ess_passward) ?? null,
            'BEP_Amt' => $request->block_ess_passward_recovery_amount ?? null,
            'BEP_Remark' => $request->block_ess_passward_remarks ?? null,

            'BPP' => $this->processCheckboxyes($request->block_paypac_passward)?? null,
            'BPP_Amt' => $request->block_paypac_passward_recovery_amount?? null,
            'BPP_Remark' => $request->block_paypac_passward_remarks ?? null,

            'BExP' => $this->processCheckboxyes($request->block_expro_passward) ?? null,
            'BExP_Amt' => $request->block_expro_passward_recovery_amount ?? null,
            'BExP_Remark' => $request->block_expro_passward_remarks ?? null,

            'AdminIC' => $request->AdminIC ?? null,
            'AdminIC_Amt' => $request->AdminIC_Amt ?? null,
            'AdminIC_Remark' => $request->AdminIC_Remark ?? null,

            'AdminVC' => $this->processCheckboxyes($request->visiting_submitted) ?? null,
            'AdminVC_Amt' => $request->visiting_recovery_amount ?? null,
            'AdminVC_Remark' => $request->visiting_remarks ?? null,

            'CV' => $this->processCheckboxyes($request->company_vehicle_return) ?? null,
            'CV_Amt' => $request->company_vehcile_recovery_amount ?? null,
            'CV_Remark' => $request->company_vehcile_remarks ?? null,

            'WorkDay' => $request->worked_days_without_notice ?? null,
            'NoticeDay' => $request->served_notice_period ?? null,
            'TotWorkDay' => $request->total_worked_days ?? null,
            'ServedDay' => $request->served_notice_period ?? null,
            'RecoveryDay' => $request->recoverable_notice_period ?? null,
            'TotEL' => $request->encashable_el_days?? null,
            'EnCashEL' =>  $request->encashable_el_days?? null,
            'Basic' => $request->basic_amount ?? null,
            'HRA' => $request->hra_amount?? null,
            'CarAllow' => $request->car_allowance_amount ?? null,
            'CA' => $request->CA  ?? null,
            'Bonus_Month' => $request->bonus_amount ?? null,
            'SA' => $request->special_allow_amount ?? null,
            'DA' => $request->special_allow_amount ?? null,
            'Arrear' => $request->arrear_esic ?? null,
            'Incen' => $validatedData['Incen'] ?? null,
            'PP' => $request->partially_amount_paid ?? null,
            'VA' => null,
            'TA' =>  null,
            'CCA' =>  null,
            'RA' =>  null,
            'Gross' => null,
            'LTA' => null,
            'MA' => null,
            'CEA' =>  null,
            'LE' => null,
            'Bonus' => $request->bonus_amount?? null,
            'Bonus_Adjustment' => $request->bonus_rate ?? null,
            'Exgredia' => null,
            'Gratuity' => null,
            'Mediclaim' => $vrequest->medical_allow_amount ?? null,
            'RTSB' =>  null,
            'NPS_Ded' => null,
            'NoticePay' => $request->notice_period_amount ?? null,
            'TotEar' =>  null,
            'PF' => $request->pf_amount ?? null,
            'NPR' =>   null,
            'NPR_Actual' => null,
            'PAP' => null,
            'ESIC' => $request->esic?? null,
            'ARR_ESIC' => $request->arrear_esic ?? null,
            'VolC' => null,
            'RA_allow' => $request->relocationAllowance??null,
            'HrRemark' => $request->hrRemarks ?? null,
            'TotDeduct'=>0,
            ];
                $existingRecordsep = \DB::table('hrm_employee_separation')
                ->where('EmpSepId', $request->EmpSepId)
                ->first();
                $nocClearancehrnoc = [
                    'HR_NOC' => 'Y'
                ];
            if ($existingRecordsep) {
                // Update the existing record
                \DB::table('hrm_employee_separation')
                    ->where('EmpSepId', $request->EmpSepId)
                    ->update($nocClearancehrnoc);
            } 
            

        // Try to find an existing record by EmpSepId and update it, or insert if it doesn't exist
        $existingRecord = \DB::table('hrm_employee_separation_nochr')
            ->where('EmpSepId',  $request->EmpSepId)
            ->first();

        if ($existingRecord) {
            // Update the existing record
            \DB::table('hrm_employee_separation_nochr')
                ->where('EmpSepId',  $request->EmpSepId)
                ->update($nocClearanceData);
        } else {
            // Insert new record
            \DB::table('hrm_employee_separation_nochr')->insert($nocClearanceData);
        }

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'NOC clearance data processed successfully for HR.',
        ]);
    }

// Helper function to process checkbox input (convert 'on' to 'Y' or 'N')
private function processCheckbox($checkbox)
{
    if (is_array($checkbox) && in_array('on', $checkbox)) {
        return 'Y'; // If checkbox is checked, return 'Y'
    }
    return 'N'; // If checkbox is not checked, return 'N'
}
private function processCheckboxyes($checkbox)
{
    if (is_array($checkbox) && in_array('Yes', $checkbox)) {
        return 'Y'; // If checkbox is checked, return 'Y'
    }
    return 'N'; // If checkbox is not checked, return 'N'
}
public function departmentclearance()
    {
        $EmployeeID =Auth::user()->EmployeeID;

        $employeeIds = EmployeeGeneral::where('RepEmployeeID', $EmployeeID)->pluck('EmployeeID');
        $trainingData = \DB::table('hrm_company_training_participant as ctp')
        ->leftJoin('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId') // leftJoin with hrm_company_training based on training_id
        ->leftJoin('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID') // leftJoin with hrm_employee to get employee details
        ->whereIn('ctp.EmployeeID', $employeeIds) // Filter by EmployeeID(s)
        ->select('ct.*','e.Fname', 'e.Lname', 'e.Sname') // Select relevant fields
        ->get();
        $employeesReportingTo = \DB::table('hrm_employee_general')
        ->where('RepEmployeeID', $EmployeeID)
        ->get(); 
        $seperationData = [];

        foreach ($employeesReportingTo as $employee) {

            $seperation = \DB::table('hrm_employee_separation as es')
            ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // leftJoin to fetch employee name details
            ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // leftJoin to get employee's department
            ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // leftJoin to fetch department name
            ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // leftJoin to fetch department name
            ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
            ->where('e.EmpStatus', '=','A')  // Filter by employee ID
            ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'd.department_name','eg.EmailId_Vnr','dg.designation_name')  // Select the required fields
            ->get();
            if ($seperation->isNotEmpty()) {
                $seperationData[] = [
                    'employee_id' => $employee->EmployeeID,  // Store the employee ID for referencing
                    'seperation' => $seperation
                ];
            }
        }   

        return view('clearanceform.departmentnoc' ,compact('seperationData')); // View for IT clearance
    }
    
    public function submitNocClearancelogdep(Request $request)
    {
    
        // For debugging, you can uncomment the dd() line to check the data
        // Initialize the variables
        $buttonId = $request->input('button_id');
        
        // Custom validation
        $validatedData = $request->validate([
            'EmpSepId' => 'required|integer',
            // Custom validations as per your data structure
            'DDH' => 'nullable|array|max:1',
            'DDH.*' => 'in:NA,Yes,No',
            'TID' => 'nullable|array|max:1',
            'TID.*' => 'in:NA,Yes,No',
            'APTC' => 'nullable|array|max:1',
            'APTC.*' => 'in:NA,Yes,No',
            'HOAS' => 'nullable|array|max:1',
            'HOAS.*' => 'in:NA,Yes,No',
        ]);

        // Initialize submission flags
        $finalSubmit = 'N';
        $draftSubmit = 'N';

        // Check which button was clicked
        if ($buttonId == "final-submit-btn-log") {
            $finalSubmit = 'Y';
        } elseif ($buttonId == "save-draft-btn-log") {
            $draftSubmit = 'Y';
        }
        $nocClearanceData = []; // This is where you will store the party data

        // Prepare the data for insertion or update
        $nocClearanceData = [
            'EmpSepId' => $validatedData['EmpSepId'],  // Assuming EmpSepId is sent with the form
            'final_submit_log' => $finalSubmit,
            'draft_submit_log' => $draftSubmit,
            'Logistic_Noc_Submit_Date' => now(),
            'NocSubmitDate' => now(),  // Current date and time
                'DDH' => isset($validatedData['DDH']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['DDH'])) : null,
                'DDH_Amt' => $request->DDH_Amt ?? null,
                'DDH_Remark' => $request->DDH_Remark ?? null,
        
                'TID' => isset($validatedData['TID']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['TID'])) : null,
                'TID_Amt' => $request->TID_Amt ?? null,
                'TID_Remark' => $request->TID_Remark ?? null,
        
                'APTC' => isset($validatedData['APTC']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['APTC'])) : null,
                'APTC_Amt' =>$request->APTC_Amt ?? null,
                'APTC_Remark' =>$request->APTC_Remark ?? null,
        
                'HOAS' => isset($validatedData['HOAS']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['HOAS'])) : null,
                'HOAS_Amt' => $request->HOAS_Amt ?? null,
                'HOAS_Remark' => $request->HOAS_Remark ?? null,
            
        ];

        $partyCount = 1;
        $errors = []; // To collect any errors for missing fields
        $totalRecoveryAmount = 0;

        while ($request->has("Parties_{$partyCount}")) {
            // Party Name
            $partyName = $request->input("Parties_{$partyCount}");
            
            // Document Data (Y or N)
            $partyDocData = $request->input("Parties_{$partyCount}_docdata");
            $partyDocDataValue = null;
            if ($partyDocData == 'Yes') {
                $partyDocDataValue = 'Y';
            } elseif ($partyDocData == 'No') {
                $partyDocDataValue = 'N';
            }
           
        
            // Recovery Amount
            $partyAmount = $request->input("Parties_{$partyCount}_Amt");
            $totalRecoveryAmount += $partyAmount; // Summing up the amounts correctly

            // Remarks (optional)
            $partyRemark = $request->input("Parties_{$partyCount}_Remark");
        
            // Check if the party is present and if the required fields for that party are filled
            if (empty($partyName) || empty($partyAmount)) {
                // If any required field is missing, add a single error message for this party
                $errors[] = "All fields for Party {$partyCount} (Name, Document Data, and Recovery Amount) must be filled.";
            } else {
                // All required fields are provided, add to nocClearanceData array
                $nocClearanceData["Prtis{$partyCount}"] = $partyName;
                $nocClearanceData["Prtis_{$partyCount}"] = $partyDocDataValue;
                $nocClearanceData["Prtis_{$partyCount}Amt"] = $partyAmount;
                $nocClearanceData["Prtis_{$partyCount}Remark"] = $partyRemark; // Remarks is optional, so include even if empty
            }
        
            $partyCount++;
        }
        
        // If there are any errors, return them as a response
        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'message' => implode(' ', $errors) // Combine error messages into one string
            ]);
        }
        
    
        // Insert or update the data in the database
        $existingRecord = \DB::table('hrm_employee_separation_nocrep')
            ->where('EmpSepId', $validatedData['EmpSepId'])
            ->first();
 
        if ($existingRecord) {
            $totalRecoveryAmount += (float) $existingRecord->DDH_Amt;
            $totalRecoveryAmount += (float) $existingRecord->TID_Amt;
            $totalRecoveryAmount += (float) $existingRecord->APTC_Amt;
            $totalRecoveryAmount += (float) $existingRecord->HOAS_Amt;
                // // Loop through up to 40 parties and add their amounts
                // for ($i = 1; $i <= 40; $i++) {
                //     $partyAmountKey = "Prtis_{$i}Amt";
                //     if (isset($existingRecord->$partyAmountKey)) {
                //         $totalRecoveryAmount += (float) $existingRecord->$partyAmountKey;
                //     }
                // }
        

            $nocClearanceData['TotRepAmt'] = $totalRecoveryAmount;
            // Update the existing record
            \DB::table('hrm_employee_separation_nocrep')
                ->where('EmpSepId', $validatedData['EmpSepId'])
                ->update($nocClearanceData);

                 // Return success response
                return response()->json([
                    'success' => true,
                    'message' => 'NOC clearance data processed successfully',
                   
        ]);
        } else {
            // Insert new record
            
            \DB::table('hrm_employee_separation_nocrep')->insert($nocClearanceData);
             // Return success response
            return response()->json([
                'success' => true,
                'message' => 'NOC clearance data processed successfully',
            ]);
        }

       
    }

    public function itClearance()
        {
             // Get the current month and year
             $currentMonth = Carbon::now()->month;
             $currentYear = Carbon::now()->year;
 
             // Fetching approved employees with additional employee details
                 $approvedEmployees = \DB::table('hrm_employee_separation as es')
                 ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // leftJoin to fetch employee details
                 ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // leftJoin to fetch general employee details
                 ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // leftJoin to fetch department name
                 ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // leftJoin to fetch designation name
                //  ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                //  ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                
                //  ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                //  ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                 ->select(
                     'es.*',
                     'e.Fname',  // First name
                     'e.Lname',  // Last name
                     'e.Sname',  // Surname
                     'e.EmpCode',  // Employee Code
                     'd.department_name',  // Department name
                     'eg.EmailId_Vnr',  // Email ID from the employee general table
                     'dg.designation_name'  // Designation name
                 )
                 ->orderBy('Emp_ResignationDate', 'desc')
                 ->get(); // Paginate the results

            return view('clearanceform.itclearancenoc',compact('approvedEmployees')); // View for IT clearance
    }
    
    public function logisticsClearance()
    {
         // Get the current month and year
         $currentMonth = Carbon::now()->month;
         $currentYear = Carbon::now()->year;

         // Fetching approved employees with additional employee details
         $approvedEmployees = \DB::table('hrm_employee_separation as es')
         ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
         ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
         ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // Join to fetch department name
         ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
        //  ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
        //  ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
        //  ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
        //  ->whereYear('es.created_at', $currentYear)   // Filter for the current year
        ->where('d.id', '15')
        ->where('Log_EmployeeID', Auth::user()->EmployeeID)
         ->select(
             'es.*',
             'e.Fname',  // First name
             'e.Lname',  // Last name
             'e.Sname',  // Surname
             'e.EmpCode',  // Employee Code
             'd.department_name',  // Department name
             'eg.EmailId_Vnr',  // Email ID from the employee general table
             'dg.designation_name'  // Designation name
         )
         ->orderBy('Emp_ResignationDate', 'desc')
         ->get(); // Paginate the results


          
        return view('clearanceform.logisticsclearancenoc',compact('approvedEmployees')); // View for Logistics clearance
    }

    
    public function hrClearance()
    {
        
             // Get the current month and year
             $currentMonth = Carbon::now()->month;
             $currentYear = Carbon::now()->year;
 
             // Fetching approved employees with additional employee details
                 $approvedEmployees = \DB::table('hrm_employee_separation as es')
                 ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // leftJoin to fetch employee details
                 ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // leftJoin to fetch general employee details
                 ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // leftJoin to fetch department name
                 ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
                //  ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                //  ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
               
                //  ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                //  ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                 ->select(
                     'es.*',
                     'e.Fname',  // First name
                     'e.Lname',  // Last name
                     'e.Sname',  // Surname
                     'e.EmpCode',  // Employee Code
                     'd.department_name',  // Department name
                     'eg.EmailId_Vnr',  // Email ID from the employee general table
                     'dg.designation_name'  // Designation name
                 )
                 ->order('Emp_ResignationDate','desc')
                 ->paginate(10); // Paginate the results
                return view('clearanceform.hrclearance',compact('approvedEmployees')); // View for HR clearance
    }

    public function accountClearance()
    {
           // Get the current month and year
           $currentMonth = Carbon::now()->month;
           $currentYear = Carbon::now()->year;

           // Fetching approved employees with additional employee details
               $approvedEmployees = \DB::table('hrm_employee_separation as es')
               ->leftJoin('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // join to fetch employee details
               ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // join to fetch general employee details
               ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // join to fetch department name
               ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
               ->orderBy('es.Emp_ResignationDate', 'desc')
               ->select(
                   'es.*',
                   'e.Fname',  // First name
                   'e.Lname',  // Last name
                   'e.Sname',  // Surname
                   'e.EmpCode',  // Employee Code
                   'd.department_name',  // Department name
                   'eg.EmailId_Vnr',  // Email ID from the employee general table
                   'dg.designation_name'  // Designation name
               )
               ->get(); // Paginate the results
               return view('clearanceform.accountclearance',compact('approvedEmployees')); // View for Account clearance
    }
    public function submitExitForm(Request $request)
    {
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'EmpSepId' => 'required|integer',
            'docdata' => 'nullable|string',
            'last_perform' => 'nullable|string',
            'reason_leaving' => 'nullable|string',
            'executive_org' => 'nullable|string',
            'sugg_executive' => 'nullable|string',
            'button_id' => 'required|string',
            'Q1_1' => 'nullable|string',
            'Q1_2' => 'nullable|string',
            'Q2_1' => 'nullable|string',
            'Q2_2' => 'nullable|string',
            'Q3_1' => 'nullable|string',
            'Q3_2' => 'nullable|string',
            'Q4_1' => 'nullable|string',
            'Q4_2' => 'nullable|string',
            'Q5_1' => 'nullable|string',
            'Q5_2' => 'nullable|string',
            'Q6' => 'nullable|string',
            'Q7' => 'nullable|string',
            'ComName' => 'nullable|string',
            'Location' => 'nullable|string',
            'Designation' => 'nullable|string',
            'hike' => 'nullable|numeric',
            'OthBefit' => 'nullable|string',
            'Rep_EligForReHire' => 'nullable|string',
            'Rep_Rating' => 'nullable|string',
            'Rep_ReasonsLeaving' => 'nullable|string',
            'Rep_ReasonsLeaving_2' => 'nullable|string',
            'Rep_CulturePolicy' => 'nullable|string',
            'Rep_CulturePolicy_2' => 'nullable|string',
            'Rep_SuggImp' => 'nullable|string',
            'Rep_SuggImp_2' => 'nullable|string',
            'RepExitIntStatus' => 'nullable|string',
            'RepExtSubmit' => 'nullable|string',
            'draft_submit_exit_repo' => 'nullable|string',
            'final_submit_exit_repo' => 'nullable|string',
            'draft_submit_exit_emp' => 'nullable|string',
            'final_submit_exit_emp' => 'nullable|string',
        ]);
        if($request->last_perform > 5 || $request->last_perform == 0){
            return response()->json([
                'success' => false,
                'message' => 'Rating Should be 1-5',
            ]);
        }
        if ($request->button_id == "save-draft-exit-repo") {
            // Check if all fields are empty or null
            if (
                empty($request->docdata) && empty($request->last_perform) && empty($request->reason_leaving) && 
                empty($request->sugg_executive) && empty($request->executive_org)
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'At least one field should be filled.',
                ]);
            }
        }
        if ($request->button_id == "final-submit-exit-repo") {
            // Check if any field is empty or null
            if (
                empty($request->docdata) || empty($request->last_perform) || empty($request->reason_leaving) || 
                empty($request->sugg_executive) || empty($request->executive_org)
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'All fields are required when submitting the final exit report.',
                ]);
            }
        }
        

     
        // Get the button ID (save-draft-btn or final-submit-btn)
        $buttonId = $request->input('button_id');
    
        // Initialize variables for final_submit and draft_submit
        $finalSubmit = 'N';
        $draftSubmit = 'N';
    
        // Check which button was clicked
        if ($buttonId == "final-submit-exit-repo") {
            // Set final_submit to 'Y' if final submit was clicked
            
            $finalSubmit = 'Y';
            $existingRecordsep = \DB::table('hrm_employee_separation')
        ->where('EmpSepId', $request->EmpSepId)
        ->first();
       
        $nocClearancedepnoc = [
            'Rep_ExitIntForm' => 'Y',
        ];
        if ($existingRecordsep) {
            // Update the existing record
            \DB::table('hrm_employee_separation')
                ->where('EmpSepId', $request->EmpSepId)
                ->update($nocClearancedepnoc);
        } 
        $employeeDetailsdep = \DB::table('hrm_employee as e')
        ->leftJoin('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
        ->leftJoin('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
        ->leftJoin('core_designation as dg', 'eg.DesigId', '=', 'dg.id')
        ->where('e.EmployeeID',$existingRecordsep->EmployeeID)
        ->select(
            'e.EmployeeID',
            'e.Fname',
            'e.Lname',
            'e.Sname',
            'e.EmpCode',
            'd.department_name',
            'dg.designation_name'
        )
        ->first();
           
        $Empname = ($employeeDetailsdep->Fname ?? 'null').' ' . ($employeeDetailsdep->Sname ?? 'null').' ' . ($employeeDetailsdep->Lname ?? 'null');
        $details = [
            'subject'=>'Separation Exit Interview form Filled Status',
            'EmpName'=> $Empname,
            'DepartmentName'=> $employeeDetailsdep->department_name,
            'DesigName'=> $employeeDetailsdep->designation_name,
            'site_link' => "https://vnrseeds.co.in"  // Assuming this is provided in $details
    
          ];

           Mail::to('vspl.hr@vnrseeds.com')->send(new SeparationMailExitRepo($details));

        } elseif ($buttonId == "save-draft-exit-repo") {
            // Set draft_submit to 'Y' if save draft was clicked
            $draftSubmit = 'Y';
            
        }
        if($request->docdata == "Yes"){
            $doc = 'Y';
    
        }
        if($request->docdata == "No"){
            $doc = 'N';
        }        
    
        // Prepare the data for insertion or update
        $exitFormData = [
            'EmpSepId' => $validatedData['EmpSepId'],
            'FormSubmitDate'=>now(),
            'final_submit_exit_repo' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
            'draft_submit_exit_repo' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
            'Rep_Rating' => $validatedData['last_perform']?? null,
            'Rep_ReasonsLeaving' => $validatedData['reason_leaving'] ?? null,
            'Rep_CulturePolicy' => $validatedData['executive_org'] ?? null,
            'Rep_SuggImp' => $validatedData['sugg_executive'] ?? null,
            'Rep_EligForReHire' =>  $doc??null,
            'Q1_1' => $validatedData['Q1_1'] ?? null,
            'Q1_2' => $validatedData['Q1_2'] ?? null,
            'Q2_1' => $validatedData['Q2_1'] ?? null,
            'Q2_2' => $validatedData['Q2_2'] ?? null,
            'Q3_1' => $validatedData['Q3_1'] ?? null,
            'Q3_2' => $validatedData['Q3_2'] ?? null,
            'Q4_1' => $validatedData['Q4_1'] ?? null,
            'Q4_2' => $validatedData['Q4_2'] ?? null,
            'Q5_1' => $validatedData['Q5_1'] ?? null,
            'Q5_2' => $validatedData['Q5_2'] ?? null,
            'Q6' => $validatedData['Q6'] ?? null,
            'Q7' => $validatedData['Q7'] ?? null,
            'ComName' => $validatedData['ComName'] ?? null,
            'Location' => $validatedData['Location'] ?? null,
            'Designation' => $validatedData['Designation'] ?? null,
            'hike' => $validatedData['hike'] ?? null,
            'OthBefit' => $validatedData['OthBefit'] ?? null,
            'draft_submit_exit_emp' => $validatedData['draft_submit_exit_emp'] ?? null,
            'final_submit_exit_emp' => $validatedData['final_submit_exit_emp'] ?? null,
        ];
       
    
        // Try to find an existing record by EmpSepId and update it, or insert if it doesn't exist
        $existingRecord = \DB::table('hrm_employee_separation_exitint')
            ->where('EmpSepId', $request->EmpSepId)
            ->first();
    
        if ($existingRecord) {
            // Update the existing record
            \DB::table('hrm_employee_separation_exitint')
                ->where('EmpSepId', $request->EmpSepId)
                ->update($exitFormData);
        } else {
            // Insert new record
            \DB::table('hrm_employee_separation_exitint')->insert($exitFormData);
        }
   
        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Exit form data processed successfully',
        ]);
    }
    public function saveappraiser(Request $request){
        $request->all();
    }

    
}
