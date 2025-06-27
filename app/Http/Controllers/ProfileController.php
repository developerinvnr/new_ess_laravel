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
use Illuminate\Support\Facades\Storage;

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
        ->select('hrm_employee_general.DateJoining')
        ->select('hrm_employee_general.DateJoining', 
        'core_city_village_by_state.city_village_name',
        'hrm_employee_general.DepartmentId','hrm_employee_general.TerrId',
        'hrm_employee_general.ZoneId','hrm_employee_general.RegionId',
        'hrm_employee_general.BUId') 
        ->first();
        $territoryData = null;
        $zoneData = null;
        $buData = null;
        $regionData = null;


        if ($employeeData) {
            // Fetch the territory_name from core_territory table
            $territoryData = \DB::table('core_territory')
                ->select('territory_name') // Fetch the territory_name
                ->where('id', $employeeData->TerrId) // Match the TerrId
                ->first();

             $zoneData = \DB::table('core_zones')
                ->select('zone_name') // Fetch the territory_name
                ->where('id', $employeeData->ZoneId) // Match the TerrId
                ->first();

             $buData = \DB::table('core_business_unit')
                ->select('business_unit_name') // Fetch the territory_name
                ->where('id', $employeeData->BUId) // Match the TerrId
                ->first();

             $regionData = \DB::table('core_regions')
                ->select('region_name') // Fetch the territory_name
                ->where('id', $employeeData->RegionId) // Match the TerrId
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
        // $tdsFileA = base_path("/Employee/ImgTds{$companyId}232024/{$panNo}_2024-25.pdf");
        // $tdsFileB = base_path("/Employee/ImgTds{$companyId}232024/{$panNo}_PARTB_2024-25.pdf");
        $tdsFileA = "Employee_TDS/2024-25/{$panNo}_2025-26.pdf";
        $tdsFileB= "Employee_TDS/2024-25/{$panNo}_PARTB_2025-26.pdf";
        $exitstdsA = Storage::disk('s3')->exists($tdsFileA);
        $exitstdsB = Storage::disk('s3')->exists($tdsFileB);




        $tdsFileAUrl = Storage::disk('s3')->url($tdsFileA);
        $tdsFileBUrl = Storage::disk('s3')->url($tdsFileB);
    

        // $ledgerFile = base_path("/Employee/Emp{$companyId}Lgr/E{$empCode}.pdf");
        // $ledgerFilename = "E{$empCode}.pdf";
        // $ledgerFile = "Employee_Ledger/{$companyId}/2024-25/{$ledgerFilename}";
        // $ledgerUrl = Storage::disk('s3')->url($ledgerFile);
        $ledgerFilename = "E{$empCode}.pdf";
        $ledgerFile = "Employee_Ledger/{$companyId}/2024-25/{$ledgerFilename}";
        $exitsledger = Storage::disk('s3')->exists($ledgerFile);

        // Check if file exists on S3
        if ($exitsledger) {
            $ledgerUrl = Storage::disk('s3')->url($ledgerFile);
        } else {
            $ledgerUrl = null; // or a placeholder/fallback value
        }
        // $healthCard = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_A.pdf");

        // // Set file paths
        // $healthCardA = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_A.pdf");
        // $healthCardB = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_B.pdf");
        // $healthCardC = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_C.pdf");
        // $healthCardD = base_path("/Employee/HealthIDCard/{$companyId}/{$empCode}/{$empCode}_D.pdf");
        $healthCardAPath = "Employee_HealthID/{$companyId}/{$empCode}/{$empCode}_A.pdf";
        $healthCardBPath = "Employee_HealthID/{$companyId}/{$empCode}/{$empCode}_B.pdf";
        $healthCardCPath = "Employee_HealthID/{$companyId}/{$empCode}/{$empCode}_C.pdf";
        $healthCardDPath = "Employee_HealthID/{$companyId}/{$empCode}/{$empCode}_D.pdf";

        $healthCardAUrl = Storage::disk('s3')->exists($healthCardAPath) ? Storage::disk('s3')->url($healthCardAPath) : null;
        $healthCardBUrl = Storage::disk('s3')->exists($healthCardBPath) ? Storage::disk('s3')->url($healthCardBPath) : null;
        $healthCardCUrl = Storage::disk('s3')->exists($healthCardCPath) ? Storage::disk('s3')->url($healthCardCPath) : null;
        $healthCardDUrl = Storage::disk('s3')->exists($healthCardDPath) ? Storage::disk('s3')->url($healthCardDPath) : null;


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
            return view('seperation.profile', compact('employeeData','territoryData','designationName',
            'employeeDataDuration', 'finalResult','functionName','years','experience',
             'totalYears', 'roundedYears','allFamilyData','repEmployeeDataprofile','employee', 
             'companyId', 'empCode', 'tdsFileA', 'tdsFileB', 'ledgerFile','regionData',
             'buData','zoneData','ledgerUrl','exitstdsA','exitstdsB',
              'esicCard'));

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

        return view('employee.profile', compact('employeeData','conferences','territoryData',
        'designationName','employeeDataDuration', 'finalResult','functionName','years',
        'experience', 'totalYears', 'roundedYears','allFamilyData','repEmployeeDataprofile',
        'employee', 'companyId', 'empCode', 'tdsFileA', 'tdsFileB', 'encryptedEmpCode', 'regionData',
        'buData','zoneData','tdsFileBUrl','tdsFileAUrl','ledgerFile','ledgerUrl','ledgerUrl','exitsledger',
        'esicCard'));
    }


    public function submit(Request $request)
    {
        $attachments = [];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $user = Auth::user();
            $companyId = $user->CompanyId;
            $employeeId = $user->EmployeeID;

            $currentDate = now()->format('Y-m-d');
            $filename = $employeeId . "_" . $currentDate . "." . $file->getClientOriginalExtension();

            // S3 folder path
            $s3Path = "Employee_Change_Request/{$companyId}/{$filename}";

            // Upload to S3
            Storage::disk('s3')->put($s3Path, file_get_contents($file), 'public');

            // Generate the full S3 URL
            $attachments[] = $s3Path;  // just the relative path inside the bucket
        }

        // Fetch Employee Info
        $employeedetails = Employee::where('EmployeeID', Auth::user()->EmployeeID)->first();


        $Empname = ($employeedetails->Fname ?? 'null') . ' ' .
                ($employeedetails->Sname ?? 'null') . ' ' .
                ($employeedetails->Lname ?? 'null');

        // Email Data
        $details = [
            'subject' => 'Document Change Request',
            'EmpName' => $Empname,
            'Message' => $request->message,
            'Subject' => $request->subject,
            'EC' => $employeedetails->EmpCode,
            'attachments' => $attachments,
            'site_link' => "https://vnrseeds.co.in"
        ];

        // Send email
        Mail::to('vspl.hr@vnrseeds.com')->send(new ChangeRequest($details));

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
