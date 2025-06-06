<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use App\Mail\Profile\ChangeRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public function profile()
    {
        $employeeId = Auth::user()->EmployeeID; // The EmployeeID you're fetching data for

        // Fetch employee data for the profile
        $employeeDataDuration = \DB::table('hrm_employee_general as eg')
            ->join('hrm_employee as e', 'e.EmployeeID', '=', 'eg.EmployeeID')
            ->join('core_departments as d', 'eg.DepartmentId', '=', 'd.id')
            ->join('hrm_company_basic as cb', 'e.CompanyId', '=', 'cb.CompanyId')
            ->leftJoin('core_verticals as v', 'eg.EmpVertical', '=', 'v.id')  // Left Join to fetch VerticalName, ignore if 0 or no match
            ->select('e.EmployeeID', 'eg.DateJoining', 'e.DateOfSepration', 'eg.DepartmentId', 'd.department_name','v.vertical_name','eg.RepEmployeeID',
            'e.CompanyID', 'cb.CompanyName')
            ->where('e.EmployeeID', $employeeId)
            ->first();
            // Step 1: Get the RepEmployeeID and its corresponding designation_id from hrm_employee_general table
            $repEmployeeData = \DB::table('hrm_employee_general as eg')
                ->select('eg.DesigId') // Fetch RepEmployeeID and DesignationID
                ->where('eg.EmployeeID', $employeeDataDuration->RepEmployeeID) // Filter by the employeeId
                ->first();
                $designationName = "";  // Set a default value

            // Check if RepEmployeeData exists
            if ($repEmployeeData) {
                $designationID = $repEmployeeData->DesigId;

                    // Step 2: Fetch the designation_name from the core_designation table based on the DesignationID
                    $designation = \DB::table('core_designation')
                        ->select('designation_name') // Get the designation_name
                        ->where('id', $designationID) // Filter by the DesignationID
                        ->first();

                    // Check if the designation is found
                    if ($designation) {
                        $designationName = $designation->designation_name;

                    } 
                } 
                
                $repEmployeeDataprofile = \DB::table('hrm_employee as e')
                ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')
                ->join('core_designation as d', 'eg.DesigId', '=', 'd.id')
                ->select(
                    'e.EmployeeID',
                    'e.fname',
                    'e.sname',
                    'e.lname',
                    'd.designation_name',
                    'eg.MobileNo_Vnr as MobileNo',
                    'eg.EmailId_Vnr'
                )
                ->where('e.EmployeeID', $employeeDataDuration->RepEmployeeID) // Use the RepEmployeeID
                ->first();
                    

        // Format the dates as 'M Y' (e.g., Jan 2020)
        $employeeDataDuration->DateJoining = \Carbon\Carbon::parse($employeeDataDuration->DateJoining)->format('M Y');
        $employeeDataDuration->DateOfSepration = \Carbon\Carbon::parse($employeeDataDuration->DateOfSepration)->format('M Y');
            // Fetch the DateJoining of the employee
            // $employeeData = \DB::table('hrm_employee_general')
            // ->where('EmployeeID', $employeeId)
            // ->select('DateJoining',)
            // ->first();

            $employeeData = \DB::table('hrm_employee_general')
        ->leftjoin('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')  // Join with the hrm_headquater table
        ->where('hrm_employee_general.EmployeeID', $employeeId)
        ->select('hrm_employee_general.DateJoining')  // Select DateJoining and HqName
        ->select('hrm_employee_general.DateJoining', 'core_city_village_by_state.city_village_name','hrm_employee_general.DepartmentId','hrm_employee_general.TerrId')  // Select DateJoining and HqName
        ->first();
        $territoryData = null; // Declare the variable outside the block for wider scope

        if ($employeeData && $employeeData->TerrId != 0) {
            // Fetch the territory_name from core_territory table
            $territoryData = \DB::table('core_territory')
                ->select('territory_name') // Fetch the territory_name
                ->where('id', $employeeData->TerrId) // Match the TerrId
                ->first();
        }
    
        if ($employeeData) {
            // Parse the DateJoining
            $dateJoined = \Carbon\Carbon::parse($employeeData->DateJoining);
            $currentDate = \Carbon\Carbon::now();
        
            // Get the difference in years and months
            $diff = $dateJoined->diff($currentDate);
        
            // Extract years and months
            $years = $diff->y;  // Years
            $months = $diff->m;  // Months
        
            // You can format this as needed
            $experience = "{$years} years {$months} months";
        
            // Optional: If you want the total as a float (years and months as a decimal, like 4.777)
            $totalYears = $years + ($months / 12);  // Convert months to fraction of a year
        
            // Round the total years if needed (e.g., 4.777)
            $roundedYears = round($totalYears, 2);
        
            // Debugging
            
        }
    
        // Fetch the appraisal history of the employee
        $appraisalHistory = DB::table('hrm_pms_appraisal_history')
            ->where('EmployeeID', $employeeId)
            ->orderBy('SalaryChange_Date', 'desc') // Order by the salary change date
            ->get();

        // Group by grade, treating '0' as valid and part of its group
        $groupedData = collect($appraisalHistory)->groupBy(function ($item) {
            return $item->Proposed_Grade; // Include '0' in the normal grouping
        });

        $finalResult = [];

        // Process each group of grades
        foreach ($groupedData as $grade => $items) {
            $startDate = null;
            $endDate = null;

            // Sort items by SalaryChange_Date in ascending order
            $items = $items->sortBy('SalaryChange_Date');

            foreach ($items as $index => $item) {
                if ($startDate === null) {
                    // Set start date for the first record in the group
                    $startDate = $item->SalaryChange_Date;
                }

                // Continuously update the end date with the current item's SalaryChange_Date
                $endDate = $item->SalaryChange_Date;
            }

            // Treat grade '0' like normal, setting it as the first data if it exists
            $currentGrade = $items->first()->Proposed_Grade == 0 ? '0' : $items->first()->Proposed_Grade;

            // Push the result for this group to $finalResult
            $finalResult[] = [
                'Current_Grade' => $currentGrade,
                'Current_Designation' => $items->first()->Proposed_Designation,
                'SalaryChange_Date' => \Carbon\Carbon::parse($startDate)->format('d-m-Y') // Format as dd-mm-yyyy
            ];
        }


    // Fetch data from `hrm_employee_family` table
        $familyData1 = DB::table('hrm_employee_family')
        ->where('EmployeeID', $employeeId)
        ->whereNotIn('FatherDOB', ['1970-01-01', '0000-00-00'])
        ->select(
            DB::raw("'Father' as FamilyRelation"),
            'Fa_SN as Prefix',
            'FatherName as FamilyName',
            'FatherDOB as FamilyDOB',
            'FatherQuali as FamilyQualification',
            'FatherOccupation as FamilyOccupation'
        )
        ->union(
            DB::table('hrm_employee_family')
                ->where('EmployeeID', $employeeId)
                ->whereNotIn('MotherDOB', ['1970-01-01', '0000-00-00'])
                ->select(
                    DB::raw("'Mother' as FamilyRelation"),
                    'Mo_SN as Prefix',
                    'MotherName as FamilyName',
                    'MotherDOB as FamilyDOB',
                    'MotherQuali as FamilyQualification',
                    'MotherOccupation as FamilyOccupation'
                )
        )
        ->union(
            DB::table('hrm_employee_family')
                ->where('EmployeeID', $employeeId)
                ->whereNotIn('HusWifeDOB', ['1970-01-01', '0000-00-00'])
                ->select(
                    DB::raw("'Spouse' as FamilyRelation"),
                    'HW_SN as Prefix',
                    'HusWifeName as FamilyName',
                    'HusWifeDOB as FamilyDOB',
                    'HusWifeQuali as FamilyQualification',
                    'HusWifeOccupation as FamilyOccupation'
                )
        )
        ->get();

        // Fetch data from `hrm_employee_family2` table
        $familyData2 = DB::table('hrm_employee_family2')
        ->where('EmployeeID', $employeeId)
        ->whereNotIn('FamilyDOB', ['1970-01-01', '0000-00-00'])
        ->select(
            'FamilyRelation',
            'Fa2_SN as Prefix',
            'FamilyName',
            'FamilyDOB',
            'FamilyQualification',
            'FamilyOccupation'
        )
        ->get();
        $employee =Auth::user()->EmployeeID; // Assuming authentication is used
        $companyId = Auth::user()->CompanyId;
        $empCode = Auth::user()->EmpCode;
        $panNo = Auth::user()->personaldetails->PanNo;
        
        // File paths
        $tdsFileA = base_path("/Employee/ImgTds{$companyId}232024/{$panNo}_2024-25.pdf");
        $tdsFileB = base_path("/Employee/ImgTds{$companyId}232024/{$panNo}_PARTB_2024-25.pdf");

        $ledgerFile = base_path("/Employee/Emp{$companyId}Lgr/E{$empCode}.pdf");

        $healthCard = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_A.pdf");

        // Set file paths
        $healthCardA = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_A.pdf");
        $healthCardB = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_B.pdf");
        $healthCardC = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_C.pdf");
        $healthCardD = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_D.pdf");

        $esicCard = base_path("/Employee/ESIC_Card/{$empCode}.pdf");
        // Merge the results
        $allFamilyData = $familyData1->merge($familyData2);
        $results = DB::table('core_departments as d')
        ->select('d.department_name as DepartmentName', 'cf.function_name as FunName')
        ->leftJoin('core_vertical_department_mapping as cvdm', 'd.id', '=', 'cvdm.department_id')
        ->leftJoin('core_vertical_function_mapping as cvfm', 'cvdm.function_vertical_id', '=', 'cvfm.id')
        ->leftJoin('core_functions as cf', 'cvfm.org_function_id', '=', 'cf.id')
        ->leftJoin('core_verticals as v', 'v.id', '=', 'cvfm.vertical_id')
        ->where('d.id', '=', $employeeData->DepartmentId)
        ->first();
        $functionName = $results->FunName ?? null;

        $separationRecord = \DB::table('hrm_employee_separation')
        ->where('EmployeeID', Auth::user()->EmployeeID)
        ->where(function($query) {
            $query->where('Hod_Approved', '!=', 'C')
                ->where('Rep_Approved', '!=', 'C')
                ->where('HR_Approved', '!=', 'C');
        })
        ->first();
        if ($separationRecord) {
            return view('seperation.profile', compact('employeeData','territoryData','designationName','employeeDataDuration', 'finalResult','functionName','years','experience', 'totalYears', 'roundedYears','allFamilyData','repEmployeeDataprofile','employee', 'companyId', 'empCode', 'tdsFileA', 'tdsFileB', 'ledgerFile', 'healthCardA', 'esicCard'));

        }  
        $encryptedEmpCode =  null;
        if (file_exists($ledgerFile)) {
            $encryptedEmpCode = Crypt::encryptString($empCode);
        } 
        $conferences = DB::table('hrm_company_conference_participant as cp')
        ->join('hrm_company_conference as c', 'cp.ConferenceId', '=', 'c.ConferenceId')
        ->where('cp.EmployeeID', Auth::user()->EmployeeID)
        ->orderBy('c.ConfFrom', 'DESC')
        ->select('c.*')
        ->get();

        return view('employee.profile', compact('employeeData','conferences','territoryData','designationName','employeeDataDuration', 'finalResult','functionName','years','experience', 'totalYears', 'roundedYears','allFamilyData','repEmployeeDataprofile','employee', 'companyId', 'empCode', 'tdsFileA', 'tdsFileB', 'encryptedEmpCode', 'healthCardA', 'esicCard','healthCardB','healthCardC','healthCardD'));
    }

    public function submit(Request $request)
{
    
    // Process the file upload (if any)
    $attachments = [];
    if ($request->hasFile('attachment')) {
        $file = $request->file('attachment');
        
        // Define the destination path using base_path
        $destinationPath = base_path('Employee/Changerequest');
        
        // Ensure the destination directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $currentDate = now()->format('Y-m-d');

        // Generate a filename for the uploaded file to avoid overwriting existing files
        $filename = Auth::user()->EmployeeID . "_" . $currentDate . "." . $file->getClientOriginalExtension();
        
        // Move the file to the desired directory
        $file->move($destinationPath, $filename);
    
        // Add the full path of the file to the attachments array
        $attachments[] = $destinationPath . '/' . $filename; // Store the full path
    }

    // Fetch Employee General and Employee Information
    $employeedetails = Employee::where('EmployeeID', Auth::user()->EmployeeID)->first();

    // Prepare Employee Full Name
    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

    // Prepare Email Details
    $details = [
        'subject' => 'Document Change Request',
        'EmpName' => $Empname,
        'Message'=>$request->message,
        'Subject'=>$request->subject,
        'EC'=>$employeedetails->EmpCode,
        'attachments' => $attachments, // Attachments included in the details array
        'site_link' => "https://vnrseeds.co.in"  // Assuming the site link is fixed
    ];

    // Send the email to HR
    Mail::to('vspl.hr@vnrseeds.com')->send(new ChangeRequest($details)); // No need to pass $attachments separately
    //Mail::to('preetinanda.vspl@gmail.com')->send(new ChangeRequest($details)); // No need to pass $attachments separately

    
    return response()->json(['success' => true, 'message' => 'Your Change request has been sent successfully.']);
}
public function viewLedger($companyId, $encryptedEmpCode)
{
    try {
        // Decrypt the empCode from the URL
        $empCode = Crypt::decryptString($encryptedEmpCode);

        // Construct the actual file path using the decrypted empCode
        $ledgerFile = base_path("/Employee/Emp{$companyId}Lgr/E{$empCode}.pdf");

        // Check if the file exists
        if (file_exists($ledgerFile)) {
            // Open the file in the browser
            return response()->file($ledgerFile);
        } else {
            // Handle file not found
            return redirect()->back()->with('error', 'Ledger file not found.');
        }
    } catch (\Exception $e) {
        // Handle decryption errors
        return redirect()->back()->with('error', 'Error in decryption or file retrieval.');
    }
}



    
}
