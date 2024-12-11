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
use App\Models\Department;
use App\Models\EmployeeGeneral;
use app\Models\EmployeeSeparationNocDeptEmp;
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
    
            // Step 1: Fetch department_id from hrm_department where department_code == 'HR'
            $department = Department::where('DepartmentCode', 'HR')->first();
            if (!$department) {
                return response()->json(['success' => false, 'message' => 'HR Department not found.'], 404);
            }

            // Step 2: Fetch EmployeeIDs from hrm_employee_separation_nocdept_emp for the given department_id
            $employeeIdhr =\DB::select('SELECT EmployeeID FROM hrm_employee_separation_nocdept_emp WHERE DepartmentId = ?', [$department->DepartmentId]);
            $employeeIdhr = $employeeIdhr[0]->EmployeeID;  // 182

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
        $resignation->HR_UserId = $employeeIdhr;
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
            if ($request->has('Rep_RelievingDate') && $request->Rep_RelievingDate) {
                $separation->Rep_RelievingDate = $request->Rep_RelievingDate;
                 // Save the updates if any field was changed
                $separation->save();

                return response()->json(['success' => true, 'message' => 'Reporting Relieving Date has been updated'], 200);
            
            }
            // if ($request->has('HR_Approved') && $request->HR_Approved) {
            //     $separation->HR_Approved = $request->HR_Approved;
            // }
            // if ($request->has('HR_RelievingDate') && $request->HR_RelievingDate) {
            //     $separation->HR_RelievingDate = $request->HR_RelievingDate;
            // }

            // Conditionally update the Approval Status if it's provided
            if ($request->has('Rep_Approved') && $request->Rep_Approved) {
                $separation->Rep_Approved = $request->Rep_Approved;
                $separation->save();
                return response()->json(['success' => true, 'message' => 'Reporting Approval has been updated'], 200);
            
            }

           
        }

        return response()->json(['success' => false, 'message' => 'No separation data found'], 404);
    }
 
    public function submitNocClearance(Request $request)
    {
        // Check if the form_id is logisticsnocform
    if($request->form_id == "logisticsnocform") {
        // For debugging, you can uncomment the dd() line to check the data
        // dd($request->all());
        
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

        // Prepare the data for insertion or update
        $nocClearanceData = [
            'EmpSepId' => $validatedData['EmpSepId'],  // Assuming EmpSepId is sent with the form
            'final_submit_log' => $finalSubmit,
            'draft_submit_log' => $draftSubmit,
            'Oth_Remark'=>$request->otherremark,
            'NocSubmitDate' => now(),
            'Logistic_Noc_Submit_Date' => now(),
            
            // Handling DDH, TID, APTC, and HOAS fields
            'DDH' => isset($validatedData['DDH']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['DDH'])) : null,
            'DDH_Amt' => $request->input('DDH_Amt') ?? null,
            'DDH_Remark' => $request->input('DDH_Remark') ?? null,
            
            'TID' => isset($validatedData['TID']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['TID'])) : null,
            'TID_Amt' => $request->input('TID_Amt') ?? null,
            'TID_Remark' => $request->input('TID_Remark') ?? null,
            
            'APTC' => isset($validatedData['APTC']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
            }, $validatedData['APTC'])) : null,
            'APTC_Amt' => $request->input('APTC_Amt') ?? null,
            'APTC_Remark' => $request->input('APTC_Remark') ?? null,
            
            'HOAS' => isset($validatedData['HOAS']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['HOAS'])) : null,
            'HOAS_Amt' => $request->input('HOAS_Amt') ?? null,
            'HOAS_Remark' => $request->input('HOAS_Remark') ?? null,
        ];

        // Process dynamic party fields
         $partyCount = 1;
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
 
             // Remarks
             $partyRemark = $request->input("Parties_{$partyCount}_Remark");
 
             // Add to nocClearanceData array
             $nocClearanceData["Prtis{$partyCount}"] = $partyName;
             $nocClearanceData["Prtis_{$partyCount}"] = $partyDocDataValue;
             $nocClearanceData["Prtis_{$partyCount}Amt"] = $partyAmount;
             $nocClearanceData["Prtis_{$partyCount}Remark"] = $partyRemark;
 
             $partyCount++;
         }

        // Insert or update the data in the database
        $existingRecord = \DB::table('hrm_employee_separation_nocrep')
            ->where('EmpSepId', $validatedData['EmpSepId'])
            ->first();
 
        if ($existingRecord) {
            // Update the existing record
            $db= \DB::table('hrm_employee_separation_nocrep')
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
        
        if($request->form_id=="departmentnocfrom"){
            // Get the button ID (save-draft-btn or final-submit-btn)
            $buttonId = $request->input('button_id');
            
            // Custom validation to ensure DDH, TID, APTC, HOAS can only have 1 value or be null
            $validatedData = $request->validate([
                'EmpSepId' => 'required|integer',
        
                // Validation for DDH, TID, APTC, HOAS (either null or 1 value)
                'DDH' => 'nullable|array|max:1', // Can be null or have 1 value
                'DDH.*' => 'in:NA,Yes,No',
        
                'TID' => 'nullable|array|max:1', // Can be null or have 1 value
                'TID.*' => 'in:NA,Yes,No',
        
                'APTC' => 'nullable|array|max:1', // Can be null or have 1 value
                'APTC.*' => 'in:NA,Yes,No',
        
                'HOAS' => 'nullable|array|max:1', // Can be null or have 1 value
                'HOAS.*' => 'in:NA,Yes,No',
            ]);
        
            // Initialize variables for final_submit and draft_submit
            $finalSubmit = 'N';
            $draftSubmit = 'N';
        
            // Check which button was clicked
            if ($buttonId == "final-submit-btn") {
                // Set final_submit to 'Y' if final submit was clicked
                $finalSubmit = 'Y';
            } elseif ($buttonId == "save-draft-btn") {
                // Set draft_submit to 'Y' if save draft was clicked
                $draftSubmit = 'Y';
            }
        
            // Prepare the data for insertion or update
            $nocClearanceData = [
                'EmpSepId' => $validatedData['EmpSepId'],
                'final_submit_dep' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
                'draft_submit_dep' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
                'NocSubmitDate' => now(),  // Current date and time
                'DDH' => isset($validatedData['DDH']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['DDH'])) : null,
                'DDH_Amt' => $validatedData['DDH_Amt'] ?? null,
                'DDH_Remark' => $validatedData['DDH_Remark'] ?? null,
        
                'TID' => isset($validatedData['TID']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['TID'])) : null,
                'TID_Amt' => $validatedData['TID_Amt'] ?? null,
                'TID_Remark' => $validatedData['TID_Remark'] ?? null,
        
                'APTC' => isset($validatedData['APTC']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['APTC'])) : null,
                'APTC_Amt' => $validatedData['APTC_Amt'] ?? null,
                'APTC_Remark' => $validatedData['APTC_Remark'] ?? null,
        
                'HOAS' => isset($validatedData['HOAS']) ? implode(',', array_map(function($value) {
                    return $value === 'Yes' ? 'Y' : ($value === 'No' ? 'N' : null);
                }, $validatedData['HOAS'])) : null,
                'HOAS_Amt' => $validatedData['HOAS_Amt'] ?? null,
                'HOAS_Remark' => $validatedData['HOAS_Remark'] ?? null,
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
        
            // Return a success response
            return response()->json([
                'success' => true,
                'message' => 'NOC clearance data processed successfully',
            ]);
        }
    }
    
    
    public function getNocData($empSepId)
    {
        // Fetch the data from the database
        $nocData = \DB::table('hrm_employee_separation_nocrep')
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
    public function getNocDataHr($empSepId)
    {
        // Fetch the data from the database
        $nocData = \DB::table('hrm_employee_separation_nochr')
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

    // Get the button ID (save-draft-btn or final-submit-btn)
    $buttonId = $request->input('button_id');

    // Initialize variables for final_submit and draft_submit
    $finalSubmit = 'N';
    $draftSubmit = 'N';

    // Check which button was clicked
    if ($buttonId == "final-submit-btn-it") {
        // Set final_submit to 'Y' if final submit was clicked
        $finalSubmit = 'Y';
    } elseif ($buttonId == "save-draft-btn-it") {
        // Set draft_submit to 'Y' if save draft was clicked
        $draftSubmit = 'Y';
    }

    // Prepare the data for insertion or update
    $nocClearanceData = [
        'EmpSepId' => $validatedData['EmpSepId'],
        'final_submit_it' => $finalSubmit,  // Set final_submit to 'Y' or 'N'
        'draft_submit_it' => $draftSubmit,  // Set draft_submit to 'Y' or 'N'
        'NocSubmitDate' => now(),  // Current date and time
        'ItSS' => $this->processCheckbox($validatedData['sim_submitted']),
        'ItSS_Amt' => $validatedData['sim_recovery_amount'] ?? null,
        'ItSS_Remark' => $validatedData['sim_remarks'] ?? null,

        'ItCHS' => $this->processCheckbox($validatedData['handset_submitted']),
        'ItCHS_Amt' => $validatedData['handset_recovery_amount'] ?? null,
        'ItCHS_Remark' => $validatedData['handset_remarks'] ?? null,

        'ItLDH' => $this->processCheckbox($validatedData['laptop_handover']),
        'ItLDH_Amt' => $validatedData['laptop_recovery_amount'] ?? null,
        'ItLDH_Remark' => $validatedData['laptop_remarks'] ?? null,

        'ItCS' => $this->processCheckbox($validatedData['camera_submitted']),
        'ItCS_Amt' => $validatedData['camera_recovery_amount'] ?? null,
        'ItCS_Remark' => $validatedData['camera_remarks'] ?? null,

        'ItDC' => $this->processCheckbox($validatedData['datacard_submitted']),
        'ItDC_Amt' => $validatedData['datacard_recovery_amount'] ?? null,
        'ItDC_Remark' => $validatedData['datacard_remarks'] ?? null,

        'ItEAB' => $this->processCheckbox($validatedData['email_blocked']),
        'ItEAB_Amt' => $validatedData['email_recovery_amount'] ?? null,
        'ItEAB_Remark' => $validatedData['email_remarks'] ?? null,

        'ItMND' => $this->processCheckbox($validatedData['mobile_disabled']),
        'ItMND_Amt' => $validatedData['mobile_recovery_amount'] ?? null,
        'ItMND_Remark' => $validatedData['mobile_remarks'] ?? null,

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

    // Return a success response
    return response()->json([
        'success' => true,
        'message' => 'NOC clearance data processed successfully',
    ]);
}


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
        ->join('hrm_company_training as ct', 'ctp.TrainingId', '=', 'ct.TrainingId') // Join with hrm_company_training based on training_id
        ->join('hrm_employee as e', 'ctp.EmployeeID', '=', 'e.EmployeeID') // Join with hrm_employee to get employee details
        ->whereIn('ctp.EmployeeID', $employeeIds) // Filter by EmployeeID(s)
        ->select('ct.*','e.Fname', 'e.Lname', 'e.Sname') // Select relevant fields
        ->get();
        $employeesReportingTo = \DB::table('hrm_employee_general')
        ->where('RepEmployeeID', $EmployeeID)
        ->get(); 
        $seperationData = [];

        foreach ($employeesReportingTo as $employee) {

            $seperation = \DB::table('hrm_employee_separation as es')
            ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee name details
            ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to get employee's department
            ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
            ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch department name
            ->where('es.EmployeeID', $employee->EmployeeID)  // Filter by employee ID
            ->select('es.*', 'e.Fname', 'e.Lname', 'e.Sname', 'e.EmpCode', 'd.DepartmentName','eg.EmailId_Vnr','dg.DesigName')  // Select the required fields
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
    public function itClearance()
        {
             // Get the current month and year
             $currentMonth = Carbon::now()->month;
             $currentYear = Carbon::now()->year;
 
             // Fetching approved employees with additional employee details
                 $approvedEmployees = \DB::table('hrm_employee_separation as es')
                 ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                 ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                 ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
                 ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch designation name
                 ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                 ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                 ->where(function($query) {
                     // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                     $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                         ->orWhere('es.HR_UserId', Auth::user()->EmployeeID);
                 })
                 ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                 ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                 ->select(
                     'es.*',
                     'e.Fname',  // First name
                     'e.Lname',  // Last name
                     'e.Sname',  // Surname
                     'e.EmpCode',  // Employee Code
                     'd.DepartmentName',  // Department name
                     'eg.EmailId_Vnr',  // Email ID from the employee general table
                     'dg.DesigName'  // Designation name
                 )
                 ->get();
            return view('clearanceform.itclearancenoc',compact('approvedEmployees')); // View for IT clearance
    }

    public function logisticsClearance()
    {
         // Get the current month and year
         $currentMonth = Carbon::now()->month;
         $currentYear = Carbon::now()->year;

         // Fetching approved employees with additional employee details
             $approvedEmployees = \DB::table('hrm_employee_separation as es')
             ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
             ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
             ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
             ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch designation name
             ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
             ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
             ->where(function($query) {
                 // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                 $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                     ->orWhere('es.HR_UserId', Auth::user()->EmployeeID);
             })
             ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
             ->whereYear('es.created_at', $currentYear)   // Filter for the current year
             ->select(
                 'es.*',
                 'e.Fname',  // First name
                 'e.Lname',  // Last name
                 'e.Sname',  // Surname
                 'e.EmpCode',  // Employee Code
                 'd.DepartmentName',  // Department name
                 'eg.EmailId_Vnr',  // Email ID from the employee general table
                 'dg.DesigName'  // Designation name
             )
             ->get();
        return view('clearanceform.logisticsclearancenoc',compact('approvedEmployees')); // View for Logistics clearance
    }

    public function hrClearance()
    {
        
             // Get the current month and year
             $currentMonth = Carbon::now()->month;
             $currentYear = Carbon::now()->year;
 
             // Fetching approved employees with additional employee details
                 $approvedEmployees = \DB::table('hrm_employee_separation as es')
                 ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                 ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                 ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
                 ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch designation name
                 ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                 ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                 ->where(function($query) {
                     // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                     $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                         ->orWhere('es.HR_UserId', Auth::user()->EmployeeID);
                 })
                 ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                 ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                 ->select(
                     'es.*',
                     'e.Fname',  // First name
                     'e.Lname',  // Last name
                     'e.Sname',  // Surname
                     'e.EmpCode',  // Employee Code
                     'd.DepartmentName',  // Department name
                     'eg.EmailId_Vnr',  // Email ID from the employee general table
                     'dg.DesigName'  // Designation name
                 )
                 ->get();
        return view('clearanceform.hrclearance',compact('approvedEmployees')); // View for HR clearance
    }

    public function accountClearance()
    {
        return view('clearanceform.accountclearance'); // View for Account clearance
    }
}
