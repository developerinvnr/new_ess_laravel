<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetRequest;
use App\Models\AssetName;
use App\Models\Employee;
use App\Models\EmployeeGeneral;
use App\Models\EmployeeReporting;
use App\Mail\Assests\AssestsRepo;
use App\Mail\Assests\AssestsHR;
use App\Mail\Assests\AssestsHOD;
use App\Mail\Assests\AssestsIt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use carbon\Carbon;
use App\Models\HrmYear;
use App\Models\Department;
use App\Models\HrmAssetDeptAccess;
use App\Models\HrmEmployeeVehicle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class AssetRequestController extends Controller
{
    public function store(Request $request)
    {
            // Define validation rules
    
        $requestAmount = $request->request_amount;
        $maximumLimit = $request->maximum_limit;
    
        // Check if the requested amount exceeds the maximum limit
        // if ($requestAmount > $maximumLimit) {

        //     return response()->json(['error' => 'Requested amount cannot exceed the maximum limit.'], 200);

        // } 
           // Step 5: Fetch ExpiryM from hrm_asset_name based on the asset ID from the request
           $assetId = $request->asset; // Asset ID from the request
           $asset = AssetName::where('AssetNId', $assetId)->first();
           // If no asset record is found, return an error
           if (!$asset) {
               return response()->json(['success' => false, 'message' => 'Asset not found.'], 404);
           }
           if ($asset->AssetName != "4 Wheeler" && $asset->AssetName != "2 Wheeler") {
                    if ($request->assetRequestForm === "assetRequestForm") {
                        // Define required fields with their display names
                        $requiredFields = [
                            'model_name' => 'Model Name',
                            'company_name' => 'Company Name',
                            'purchase_date' => 'Purchase Date',
                            'dealer_name' => 'Dealer Name',
                            'price' => 'Price',
                            'bill_number' => 'Bill Number',
                            'request_amount' => 'Request Amount',
                        ];
                    
                        // Check if any required field is null
                        foreach ($requiredFields as $field => $displayName) {
                            if (is_null($request->$field)) {
                                return response()->json([
                                    'success' => false,
                                    'message' => "$displayName is required and cannot be null.",
                                ], 200);
                            }
                        }
                    
                    }
                }
        
        

        $employee_id = Auth::user()->EmployeeID;
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
                    
                    if ($request->file('bill_copy') || $request->hasFile('bill_copy')) {
                        // Get the file extension
                        $extension = $request->file('bill_copy')->getClientOriginalExtension();
                        
                        // Create the custom file name with the employee ID and file extension
                        $fileName = 'employee_bill' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                        
                        // Set the target directory for storing the file
                        $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                        
                        // Ensure the directory exists
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                        }
                    
                        // Move the uploaded file to the target directory
                        $request->file('bill_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                    
                        // Save the filename to use in the database
                        $filenamebill = $fileName;
                        
                    }
                    
                    if ($request->hasFile('asset_copy')) {
                        // Get the file extension
                        $extension = $request->file('asset_copy')->getClientOriginalExtension();
                        
                        // Create the custom file name with the employee ID and file extension
                        $fileName = 'employee_asset' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                        
                        // Set the target directory for storing the file
                        $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                        
                        // Ensure the directory exists
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                        }
                    
                        // Move the uploaded file to the target directory
                        $request->file('asset_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                    
                        // Save the filename to use in the database
                        $filenameassest = $fileName;
                        
                    }
                    
                    
                    
                    if ($request->hasFile('vehicle_photo')) {
                        // Store the uploaded asset copy in the public folder

                          // Get the file extension
                          $extension = $request->file('vehicle_photo')->getClientOriginalExtension();
                        
                          // Create the custom file name with the employee ID and file extension
                          $fileName = 'employee_vehcile' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                          
                          // Set the target directory for storing the file
                          $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                          
                          // Ensure the directory exists
                          if (!file_exists($destinationPath)) {
                              mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                          }
                      
                          // Move the uploaded file to the target directory
                          $request->file('vehicle_photo')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                      
                          // Save the filename to use in the database
                          $vehicle_photopath = $fileName;
                    }
                    if ($request->hasFile('dl_copy')) {
                         // Store the uploaded asset copy in the public folder

                          // Get the file extension
                          $extension = $request->file('dl_copy')->getClientOriginalExtension();
                        
                          // Create the custom file name with the employee ID and file extension
                          $fileName = 'employee_dl' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                          
                          // Set the target directory for storing the file
                          $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                          
                          // Ensure the directory exists
                          if (!file_exists($destinationPath)) {
                              mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                          }
                      
                          // Move the uploaded file to the target directory
                          $request->file('dl_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                      
                          // Save the filename to use in the database
                          $dl_copyPath = $fileName;
                    }if ($request->hasFile('rc_copy')) {
                          // Get the file extension
                          $extension = $request->file('rc_copy')->getClientOriginalExtension();
                        
                          // Create the custom file name with the employee ID and file extension
                          $fileName = 'employee_rc' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                          
                          // Set the target directory for storing the file
                          $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                          
                          // Ensure the directory exists
                          if (!file_exists($destinationPath)) {
                              mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                          }
                      
                          // Move the uploaded file to the target directory
                          $request->file('rc_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                      
                          // Save the filename to use in the database
                          $rc_copyPath = $fileName;
                    }if ($request->hasFile('insurance_copy')) {
                        // Get the file extension
                        $extension = $request->file('insurance_copy')->getClientOriginalExtension();
                        
                        // Create the custom file name with the employee ID and file extension
                        $fileName = 'employee_inc' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                        
                        // Set the target directory for storing the file
                        $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                        
                        // Ensure the directory exists
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                        }
                    
                        // Move the uploaded file to the target directory
                        $request->file('insurance_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                    
                        // Save the filename to use in the database
                        $insurance_copyPath = $fileName;
                    }
                    if ($request->hasFile('odometer_reading')) {
                         // Get the file extension
                         $extension = $request->file('odometer_reading')->getClientOriginalExtension();
                        
                         // Create the custom file name with the employee ID and file extension
                         $fileName = 'employee_odo' . $employee_id . '_' . date('Ymd_His') . '.' . $extension;
                         
                         // Set the target directory for storing the file
                         $destinationPath = base_path('Employee/AssetReqUploadFile'); // This points to the root/Employee directory
                         
                         // Ensure the directory exists
                         if (!file_exists($destinationPath)) {
                             mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
                         }
                     
                         // Move the uploaded file to the target directory
                         $request->file('odometer_reading')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
                     
                         // Save the filename to use in the database
                         $odometer_readingPath = $fileName;
                    }
                    
                   

                    // Get the ExpiryM value from the asset
                    $expiryMonths = $asset->ExpiryM;

                    // Step 6: Add ExpiryM months to the purchase date
                    $purchaseDate = $request->purchase_date; // Assume this is in 'Y-m-d' format
                    $purchaseDateObject = new \DateTime($purchaseDate); // Create a DateTime object
                    $purchaseDateObject->modify("+$expiryMonths months"); // Add the ExpiryM months
                    $expiryDate = $purchaseDateObject->format('Y-m-d'); // Format the new expiry dat
                    
                    // Get the approval amount from the request
                    $approvalAmt = $request->maximum_limit?? $request->vehcile_price ?? 'null';; // Maximum limit (total amount)
                    $RequestedAmt = $request->request_amount; // Maximum limit (total amount)

                
                    // Calculate the amount available per month
                    $monthlyAmount = $RequestedAmt / $expiryMonths;

                    // Round the result to two decimal places (optional)
                    $monthlyAmount = number_format($monthlyAmount, 2);
                    // Create an associative array for the asset request data

                    $employeeReporting = EmployeeReporting::where('EmployeeID', $employee_id)->first();

                        if (!$employeeReporting) {
                            return response()->json(['error' => 'Employee reporting details not found'], 404);
                        }
                    $employee_company = Employee::where('EmployeeID', $employee_id)->first();

                        if (!$employee_company) {
                            return response()->json(['error' => 'Employee details not found'], 404);
                        }
                    $emp_company_id = $employee_company->CompanyId;

                    $departments = Department::whereIn('department_code', ['IT', 'FIN'])
                    ->get(['id', 'department_name']); // Fetching both DepartmentID and DepartmentName
                
                    // If no departments are found, handle gracefully
                    if ($departments->isEmpty()) {
                        // Handle the case where no departments are found (optional)
                        return response()->json(['error' => 'No departments found'], 404);
                    }
                    $departmentIds = $departments->pluck('id'); // This will return a collection of DepartmentID(s)
                    $departmentNames = $departments->pluck('department_name', 'id'); // This will map DepartmentID to DepartmentName

                                        
                    // Step 2: Fetch EmployeeIDs for those DepartmentIDs from the hrm_asset_dept_access table
                    $employeeIds = HrmAssetDeptAccess::whereIn('DepartmentID', $departmentIds)
                        ->pluck( 'EmployeeID');  // This will return a collection of EmployeeIDs
                    // If no employees are found, handle gracefully
                    if ($employeeIds->isEmpty()) {
                        // Handle the case where no employees are found (optional)
                        return response()->json(['error' => 'No employees found'], 404);
                    }
                    $assetName = AssetName::where('AssetNId', $request->asset)
                        ->pluck( 'AssetName');  // This will return a collection of EmployeeIDs
                    // If no employees are found, handle gracefully
                    if ($assetName->isEmpty()) {
                        // Handle the case where no employees are found (optional)
                        return response()->json(['error' => 'No employees found'], 404);
                    }
                    // Set HODApprovalStatus based on the AssetName
                    $hodApprovalStatus = 0; // Default to approval status (1)
                    $assetNamesToCheck = ['Mobile Accessories', 'Mobile Maintenance', 'Mobile Phone'];

                    // Check if the fetched asset name is one of the specified names
                    if ($assetNamesToCheck && $assetNamesToCheck && in_array($assetName->first(), $assetNamesToCheck)) {
                        $hodApprovalStatus = 2; // Set to Draft status (0) if one of the specified names is found
                    }

                    $comName = $request->vehicle_brand?? $request->company_name ?? 'null'; // Fallback to 'Unknown' if neither exists
                    $price = $request->maximum_limit?? $request->vehcile_price ?? 'null'; // Fallback to 'Unknown' if neither exists
                    $assetRequestData = [
                        'EmployeeID' => $employee_id, // Specify Employee ID
                        'AssetNId' => $request->asset, // From "asset"
                        'ReqAmt' => $RequestedAmt, // From "request_amount"
                        'ApprovalAmt' => 0.00, // Set to '' or specify approval amount
                        'ReqDate' => now(), // Format purchase date as YYYY-MM-DD
                        'ReqAmtExpiryNOM' => $expiryMonths, 
                        'ReqAmtExpiryDate' => Carbon::parse($expiryDate)->format('Y-m-d'), // Format purchase date as YYYY-MM-DD
                        'ReqAmtPerMonth' => floatval(str_replace(',', '', $monthlyAmount)), // Removing commas if present
                        'ComName' => $comName, // From "company_name"
                        'Srn' => '', // Set to '' or specify if available
                        'ModelNo' => $request->model_no, // From "model_no"
                        'ModelName' => $request->model_name, // From "model_name"
                        'WarrantyNOY' => 0, 
                        'WarrantyExpiry' => empty($request->warranty_expiry) ? null : $request->warranty_expiry,
                        'PurDate' => Carbon::parse($request->purchase_date)->format('Y-m-d'), // Format purchase date as YYYY-MM-DD
                        'BillNo' => $request->bill_number, // From "bill_number"
                        'Price' => $request->price, // From "price"
                        'Quantity' => 1, // Default quantity, adjust if necessary
                        'EmiNo' => $request->iemi_no, // From "iemi_no"
                        'ExpiryDate' => Carbon::parse($expiryDate)->format('Y-m-d'),
                        'IdentityRemark' => $request->remarks, // From "remarks"
                        'ReportingId' => $employeeReporting->AppraiserId, // Set to '' or specify if available
                        'HodId' => $employeeReporting->HodId, // Set to '' or specify if available
                        'HODApprovalStatus' => $hodApprovalStatus, // Draft status or change based on approval
                        'HODRemark' => '', // Set to '' or specify if available
                        'HODSubDate' => empty($request->HODSubDate) ? null : $request->HODSubDate,
                        'ITId' => isset($employeeIds[1]) ? $employeeIds[1] : 0, // Set to '' or specify if available
                        'ITApprovalStatus' => 0, // Draft status or change based on approval
                        'ITRemark' => '', // Set to '' or specify if available
                        'ITSubDate' => empty($request->ITSubDate) ? null : $request->ITSubDate,
                        'AccId' => isset($employeeIds[0]) ? $employeeIds[0] : 0, // Use null if not available
                        'AccPayStatus' => 0, // Draft status or change based on approval
                        'AccPayAmt' => '0.00', 
                        'AccRemark' => '', // Set to '' or specify if available
                        'AccPayDate' => empty($request->AccPayDate) ? null : $request->AccPayDate,
                        'AccSubDate' => empty($request->AccSubDate) ? null : $request->AccSubDate,
                        'FwdEmpId' => '0', // Set to '' or specify if available
                        'FwdApprovalStatus' => 0, // Draft status or change based on approval
                        'FwdRemark' => '', // Set to '' or specify if available
                        'FwdSubDate' => empty($request->FwdSubDate) ? null : $request->FwdSubDate,
                        'ApprovalStatus' => 0, // Draft status or change based on approval
                        'ApprovalDate' => empty($request->ApprovalDate) ? null : $request->ApprovalDate,
                        'MaxLimitAmt' => $price, // From "maximum_limit"
                        // For the other database columns
                       // For the other database columns
                        'ReqAssestImgExtName' => $filenameassest ?? '', // Check if file is uploaded
                        'ReqAssestImgExt' => $request->hasFile('asset_copy') ? $request->file('asset_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'ReqBillImgExtName' => $filenamebill ?? '',
                        'ReqBillImgExt' => $request->hasFile('bill_copy') ? $request->file('bill_copy')->getClientOriginalExtension() : '', // Check if file is uploaded

                            
                        'DealeName' => $request->dealer_name, // From "dealer_name"
                        'DealerContNo' => $request->dealer_contact, // From "dealer_contact"
                        'DealerAdd' => '', // Set to '' or specify if available
                        'DealerEmail' => '', // Set to '' or specify if available
                        'FuelType' =>  empty($request->fuel_type) ? null : $request->fuel_type, // Set to '' or specify if availabl
                        'ChasNo' => '', // Set to '' or specify if available
                        'EngNo' => '', // Set to '' or specify if available
                        'RegNo' =>empty($request->registration_number) ? null : $request->registration_number,// Set to '' or specify if available
                        'RegDate' => empty( Carbon::parse($request->registration_date)->format('Y-m-d')) ? null :  Carbon::parse($request->registration_date)->format('Y-m-d'), // Set to '' or specify if available
                        'RCNo' => '', // Set to '' or specify if available
                        'RCNo_File' => $request->hasFile('rc_copy') ? $request->file('rc_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'DLNo' => '', // Set to '' or specify if available
                        'DLNo_File' => $request->hasFile('dl_copy') ? $request->file('dl_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'InsuNo' => '', // Set to '' or specify if available
                        'InsuNo_File' => $request->hasFile('insurance_copy') ? $request->file('insurance_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'VehiNo' => '', // Set to '' or specify if available
                        'DLExpTo' => empty($request->DLExpTo) ? null : $request->DLExpTo,
                        'Beg_OdoRead' => empty($request->currentodometer_reading) ? '0.00' : $request->currentodometer_reading, // Set to '' or specify if available
                        'Beg_OdoPhoto' => $request->hasFile('odometer_reading') ? $request->file('odometer_reading')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'Owenship' =>empty($request->ownership) ? null : $request->ownership, // Set to '' or specify if available
                        'BatteryCom' => '', // Set to '' or specify if available
                        'BatteryModel' => '', // Set to '' or specify if available
                        'BatteryExpiry' => empty($request->BatteryExpiry) ? null : $request->BatteryExpiry,
                        'ManualShow' => '', // Set to '' or specify if available
                        'Status' => 0, // Draft status, change as necessary
                        'StatusCngDate' => now(), // Set to current date or specify if available
                        'AnyOtherRemark' => '', // Set to '' or specify if available
                        'CreatedBy' => $employee_id ?? '', // Assuming logged-in user ID
                        'CreatedDate' => now(), // Current date and time
                        'YearId' => $year_id, // Set to '' or specify if available
                        'bill_copy' => $billCopyPath ?? 'null', // Store the path of bill copy file
                        'asset_copy' => $assetCopyPath ?? 'null', // Store the path of asset copy file
                        'vehicle_photo' => $vehicle_photopath ?? 'null', // Store the path of asset copy file
                        'rc_copy' => $rc_copyPath ?? 'null', // Store the path of asset copy file
                        'dl_copy' => $dl_copyPath ?? 'null', // Store the path of asset copy file
                        'ins_copy' => $insurance_copyPath ?? 'null', // Store the path of asset copy file
                        'odo_copy'=> $odometer_readingPath ?? 'null'
                    ];
                
                    // Insert the data into the database
                    \DB::table('hrm_asset_employee_request')->insert($assetRequestData);

                    $reportinggeneral = EmployeeGeneral::where('EmployeeID', $employee_id)->first();
                  $employeedetails = Employee::where('EmployeeID', $employee_id)->first();
  
                  $ReportingName = $reportinggeneral->ReportingName;
                  $ReportingEmailId = $reportinggeneral->ReportingEmailId;
  
                  $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
                  $details = [
                      'ReportingName' => $ReportingName,
                      'subject'=>'Assests Request',
                      'EmpName'=> $Empname,
                      'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];
                   
                            Mail::to($ReportingEmailId)->send(new AssestsRepo($details));
                      

                    return response()->json(['success' => true, 'message' => 'Asset request submitted successfully']);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'message' => 'Error occurred while submitting the request', 'error' => $e->getMessage()]);
                }
    }
    public function approveRequest(Request $request)
    {
        $employeeId = Auth::user()->EmployeeID;
    // Fetch the asset request by AssetEmpReqId
    $assetRequest = AssetRequest::where('AssetEmpReqId', $request->request_id)->first();
    // $assetRequest = AssetRequest::where('AssetEmpReqId', $request->assestsid)->first();

    if (!$assetRequest) {
        return response()->json(['success' => false,'message' => 'Data not found']);
    }
    // Determine which approval fields to update based on the employeeId and role
    $updateFields = null;
    $payAmt = number_format((float)$request->pay_amt, 2, '.', '');  // Ensure it's formatted to 2 decimal places
    // Check which role the employeeId matches and set the appropriate fields for update
    if ($employeeId == $assetRequest->HodId || $employeeId == $assetRequest->ReportingId) {
        $updateFields = [
            'HODApprovalStatus' => $request->approval_status,
            'HODRemark' => $request->remark,
            'HODSubDate' => $request->approval_date
        ];
    } elseif ($employeeId == $assetRequest->ITId) {
        $itgeneral = Employee::Join('hrm_employee_general','hrm_employee_general.EmployeeID','=','hrm_employee.EmployeeID')->where('hrm_employee.EmployeeID',$assetRequest->ITId)->first();
        $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

        $ITname = ($itgeneral->Fname ?? 'null').' ' . ($itgeneral->Sname ?? 'null').' ' . ($itgeneral->Lname ?? 'null');
        $ITEmailId = $itgeneral->EmailId_Vnr;

        $Empname = ($employeedetails->Fname ?? 'null').' ' . ($employeedetails->Sname ?? 'null').' ' . ($employeedetails->Lname ?? 'null');
        $details = [
            'ITname' => $ITname,
            'subject'=>'Assests Request for approval',
            'EmpName'=> $Empname,
            'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
          ];
         
                Mail::to($ITEmailId)->send(new AssestsIt($details));
          
        $updateFields = [
            'ITApprovalStatus' => $request->approval_status,
            'ITRemark' => $request->remark,
            'ITSubDate' => $request->approval_date
        ];
    } 
    elseif ($employeeId == $assetRequest->AccId) {
        if($request->approval_amt ==  null || $request->approval_amt ==  ''){
        return response()->json(['success' => false, 'message' => 'Approval Amount is mandatory']);

        }
        // Update fields directly in the assetRequest
        $assetRequest->AccPayStatus = $request->approval_status;
        $assetRequest->AccRemark = $request->remark;
        $assetRequest->AccSubDate = $request->approval_date;
        $assetRequest->ApprovalAmt = (float)$request->pay_amt;
        $assetRequest->AccPayDate = $request->pay_date;
        $assetRequest->AccPayAmt = (float)$request->pay_amt;
        $assetRequest->save();  // Save the updated asset request
        // Fetch AssetNId from the asset request
        $assetNId = $assetRequest->AssetNId;
        // Fetch the corresponding AssetLimit from hrm_asset_name using AssetNId
        $asset = \DB::table('hrm_asset_name_emp')->where('AssetNId', $assetNId)
        ->where('EmployeeID',$assetRequest->EmployeeID)
        ->first();

        if ($asset) {

            // Ensure the AssetLimit is a float and perform the subtraction
            $newAssetLimit = (float)$asset->AssetELimit - (float)$request->approval_amt;

            // Update the AssetLimit in hrm_asset_name
            \DB::table('hrm_asset_name_emp')
                ->where('AssetNId', $assetNId)
                ->where('EmployeeID',$request->employee_id)
                ->update(['AssetELimit' => number_format($newAssetLimit, 2, '.', '')]);


                \DB::table('hrm_asset_employee_request')
                ->where('AssetEmpReqId', $request->request_id) // Filter by the request ID
                ->where('EmployeeID', $request->employee_id)  // Filter by the employee ID
                ->update([
                    'ApprovalAmt' => $request->approval_amt,   // Set approval amount
                    'AccPayStatus' => $request->approval_status, // Set approval status (approved/rejected)
                    'AccPayAmt' => $request->approval_amt,  // Set the account pay amount
                    'AccRemark' => $request->remark,   // Add the remark
                    'AccPayDate' => $request->pay_date // Set the payment date
                ]);
    
            // Return success response
            return response()->json(['success' => true, 'message' => 'Approval status and AssetLimit updated successfully.']);
        }
         else {
            
            \DB::table('hrm_asset_employee_request')
            ->where('AssetEmpReqId', $request->request_id) // Filter by the request ID
            ->where('EmployeeID', $request->employee_id)  // Filter by the employee ID
            ->update([
                'ApprovalAmt' => $request->approval_amt,   // Set approval amount
                'AccPayStatus' => $request->approval_status, // Set approval status (approved/rejected)
                'AccPayAmt' => $request->approval_amt,  // Set the account pay amount
                'AccRemark' => $request->remark,   // Add the remark
                'AccPayDate' => $request->pay_date // Set the payment date
            ]);

        // Return success response
        return response()->json(['success' => true, 'message' => 'Approval status updated successfully.']);
        }
    }

    // If no valid role is found, return an error
    if (!$updateFields) {
        return back()->withErrors(['error' => 'Unauthorized user or invalid approval status.']);
    }

    // Perform the update with the corresponding fields
    $assetRequest->update($updateFields);
 
        // Check if all required approval statuses are 1 (HOD, IT, and Acc)
        if ($assetRequest->HODApprovalStatus == 1 && $assetRequest->ITApprovalStatus == 1 && $assetRequest->AccPayStatus == 1) {
            // If all are approved, update the overall ApprovalStatus and ApprovalDate
            $assetRequest->ApprovalStatus = 1;
            $assetRequest->ApprovalDate = $request->approval_date; // or use current date if you want the current date
            $assetRequest->save();
        }

        return response()->json(['success' => true, 'message' => 'Approval status updated successfully.']);

        // Return a response (could be redirect or JSON, depending on your needs)
    }
    public function approveRequestFromTeam(Request $request)
    {
        $employeeId = Auth::user()->EmployeeID;
    // Fetch the asset request by AssetEmpReqId
    $assetRequest = AssetRequest::where('AssetEmpReqId', $request->assestsid)->first();

    if (!$assetRequest) {
        return back()->withErrors(['error' => 'Asset request not found.']);
    }

    // Determine which approval fields to update based on the employeeId and role
    $updateFields = null;
    
    // Check which role the employeeId matches and set the appropriate fields for update
    if ($employeeId == $assetRequest->HodId || $employeeId == $assetRequest->ReportingId) {
        $updateFields = [
            'HODApprovalStatus' => $request->approval_status,
            'HODRemark' => $request->remark,
            'HODSubDate' => $request->approval_date
        ];
    } elseif ($employeeId == $assetRequest->ITId) {
        $updateFields = [
            'ITApprovalStatus' => $request->approval_status,
            'ITRemark' => $request->remark,
            'ITSubDate' => $request->approval_date
        ];
    } elseif ($employeeId == $assetRequest->AccId) {
        $updateFields = [
            'AccPayStatus' => $request->approval_status,
            'AccRemark' => $request->remark,
            'AccSubDate' => $request->approval_date,
            'AccPayDate' => $request->approval_date
        ];
    }

    // If no valid role is found, return an error
    if (!$updateFields) {
        return back()->withErrors(['error' => 'Unauthorized user or invalid approval status.']);
    }

    // Perform the update with the corresponding fields
    $assetRequest->update($updateFields);


        // Check if all required approval statuses are 1 (HOD, IT, and Acc)
        if ($assetRequest->HODApprovalStatus == 1 && $assetRequest->ITApprovalStatus == 1 && $assetRequest->AccPayStatus == 1) {
            // If all are approved, update the overall ApprovalStatus and ApprovalDate
            $assetRequest->ApprovalStatus = 1;
            $assetRequest->ApprovalDate = $request->approval_date; // or use current date if you want the current date
            $assetRequest->save();
        }


        // Return a response (could be redirect or JSON, depending on your needs)
        return redirect()->route('team')->with('success', 'Approval updated successfully.');
    }
    public function storeVehicle(Request $request)
    {
        $EmployeeID = Auth::user()->EmployeeID;
        $filenamevehcile = null;
        $filenamerc = null;
        $filenameinc = null;

        // Save vehicle data for two-wheeler (vehicle data)
        if ($request->hasFile('vehicle_photonew')) {
            // Get the file extension
            $extension = $request->file('vehicle_photonew')->getClientOriginalExtension();
            
            // Create the custom file name with the employee ID and file extension
            $fileName = 'employee_vehcile' . $EmployeeID . '_' . date('Ymd_His') . '.' . $extension;
            
            // Set the target directory for storing the file
            $destinationPath = base_path('Employee/VehcileInfo'); // This points to the root/Employee directory
            
            // Ensure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
            }
        
            // Move the uploaded file to the target directory
            $request->file('vehicle_photonew')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
        
            // Save the filename to use in the database
            $filenamevehcile = $fileName;
            
        }
        // Save vehicle data for two-wheeler (vehicle data)
        if ($request->hasFile('rc_copy')) {
            // Get the file extension
            $extension = $request->file('rc_copy')->getClientOriginalExtension();
            
            // Create the custom file name with the employee ID and file extension
            $fileName = 'employee_rc' . $EmployeeID . '_' . date('Ymd_His') . '.' . $extension;
            
            // Set the target directory for storing the file
            $destinationPath = base_path('Employee/VehcileInfo'); // This points to the root/Employee directory
            
            // Ensure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
            }
        
            // Move the uploaded file to the target directory
            $request->file('rc_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
        
            // Save the filename to use in the database
            $filenamerc = $fileName;
            
        }
        if ($request->hasFile('insurance_copy')) {
            // Get the file extension
            $extension = $request->file('insurance_copy')->getClientOriginalExtension();
            
            // Create the custom file name with the employee ID and file extension
            $fileName = 'employee_inc' . $EmployeeID . '_' . date('Ymd_His') . '.' . $extension;
            
            // Set the target directory for storing the file
            $destinationPath = base_path('Employee/VehcileInfo'); // This points to the root/Employee directory
            
            // Ensure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true); // Create the directory if it doesn't exist
            }
        
            // Move the uploaded file to the target directory
            $request->file('insurance_copy')->move($destinationPath, $fileName); // Move file using PHP's move_uploaded_file
        
            // Save the filename to use in the database
            $filenameinc = $fileName;
            
        }
        if ($request->vehicle_typenew == "2-wheeler"){
        $vehicleData = [
            'EmployeeID' => $EmployeeID,
            'EmpCode' => $request->EmpCode,
            'brand'=> $request->vehicle_brand,
            'model_name' => $request->model_name,
            'vehicle_type'=>$request->vehicle_typenew,
            'model_no' => $request->model_no,
            'dealer_name' => $request->dealer_name,
            'dealer_contact' => $request->dealer_contact,
            'purchase_date' => $request->registration_date,
            'price' => $request->price,
            'registration_no' => $request->registration_number,
            'registration_date' => $request->registration_date,
            'bill_no' => $request->bill_number,
            'fuel_type' => $request->fuel_typenew,
            'ownership' => $request->ownershipnew,
            'vehicle_image' => $filenamevehcile,
            'rc_file' => $filenamerc,
            'insurance' => $filenameinc,
            'remark' => $request->remarksnew,
            'CreatedBy' => Auth::id(), // Logged-in user ID
            'CreatedDate' => now(),
            'YearId' => date('Y'),
        ];

        // Save the data to the `hrm_employee_vehicle` table (for two-wheeler)
        HrmEmployeeVehicle::insert($vehicleData);
        }

        // Check if data for four-wheeler is present and save accordingly
        if ($request->vehicle_typenew == "4-wheeler") {
            $fourWheelerData = [
                'EmployeeID' => $request->EmployeeID,
                'EmpCode' => $request->EmpCode,
                'four_brand'=> $request->vehicle_brand,
                'vehicle_type'=>$request->vehicle_typenew,
                'four_model_name' => $request->model_name,
                'four_model_no' => $request->model_no,
                'four_dealer_name' => $request->dealer_name,
                'four_dealer_contact' => $request->dealer_contact,
                'four_purchase_date' => $request->registration_date,
                'four_price' => $request->price,
                'four_registration_no' => $request->registration_number,
                'four_registration_date' => $request->registration_date,
                'four_bill_no' => $request->bill_number,
                'four_fuel_type' => $request->fuel_typenew,
                'four_ownership' => $request->ownershipnew,
                'four_vehicle_image' => $filenamevehcile,
                'four_rc_file' => $filenamerc,
                'four_insurance' => $filenameinc,
                'remark' => $request->remarksnew,
                'CreatedBy' => Auth::id(),
                'CreatedDate' => now(),
                'YearId' => date('Y'),
            ];

            // Save the four-wheeler data if available
            HrmEmployeeVehicle::insert($fourWheelerData);
        }

        // Redirect back or to a success page
        return response()->json(['message' => 'Vehcile details submitted successfully!'], 200);
    }
  public function updateVehicle(Request $request)
{
    $vehicle = DB::table('hrm_employee_vehicle')->where('id', $request->request_id)->first();

    if (!$vehicle) {
        return response()->json(['success' => false, 'message' => 'Vehicle not found.']);
    }

    $filenameVehicle = null;
    $filenameRc = null;
    $filenameInc = null;
    $EmployeeID = $vehicle->EmployeeID;

    // File Upload Handling Function
    function uploadFile($file, $prefix, $EmployeeID)
    {
        if ($file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = "{$prefix}_{$EmployeeID}_" . date('Ymd_His') . ".{$extension}";
            $destinationPath = base_path('Employee/VehcileInfo');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $fileName);
            return $fileName;
        }
        return null;
    }

    // Uploading files
    if ($request->hasFile('vehicle_image')) {
        $filenameVehicle = uploadFile($request->file('vehicle_image'), 'employee_vehicle', $EmployeeID);
    }
    if ($request->hasFile('rc_file')) {
        $filenameRc = uploadFile($request->file('rc_file'), 'employee_rc', $EmployeeID);
    }
    if ($request->hasFile('insurance')) {
        $filenameInc = uploadFile($request->file('insurance'), 'employee_inc', $EmployeeID);
    }

    $updateData = [];

    if ($vehicle->vehicle_type == '2-wheeler') {
        // Data for 2-wheeler
        $updateData = [
            'brand' => $request->vehicle_brand,
            'model_name' => $request->model_name,
            'model_no' => $request->model_no,
            'dealer_name' => $request->dealer_name,
            'dealer_contact' => $request->dealer_contact,
            'purchase_date' => $request->purchase_date,
            'price' => $request->price,
            'registration_no' => $request->registration_number,
            'registration_date' => $request->purchase_date,
            'bill_no' => $request->bill_number,
            'fuel_type' => $request->fuel_type,
            'ownership' => $request->ownership,
            'remark' => $request->remark,
        ];
    } elseif ($vehicle->vehicle_type == '4-wheeler') {
        // Data for 4-wheeler
        $updateData = [
            'four_brand' => $request->four_brand,
            'four_model_name' => $request->four_model_name,
            'four_model_no' => $request->four_model_no,
            'four_dealer_name' => $request->four_dealer_name,
            'four_dealer_contact' => $request->four_dealer_contact,
            'four_purchase_date' => $request->four_purchase_date,
            'four_price' => $request->four_price,
            'four_registration_no' => $request->four_registration_number,
            'four_registration_date' => $request->four_purchase_date,
            'four_bill_no' => $request->four_bill_number,
            'four_fuel_type' => $request->fuel_type,
            'four_ownership' => $request->ownership,
            'remark' => $request->remark,
        ];
    }
    


    // Add uploaded file names if they exist
    if ($filenameVehicle || $filenameVehicle != null) {
        $updateData['vehicle_image'] = $filenameVehicle;
    }
    if ($filenameRc || $filenameRc != null) {
        $updateData['rc_file'] = $filenameRc;
    }
    if ($filenameInc || $filenameInc != null) {
        $updateData['insurance'] = $filenameInc;
    }

    // Update the database using Query Builder
    DB::table('hrm_employee_vehicle')->where('id', $request->request_id)->update($updateData);

    return response()->json(['success' => true, 'message' => 'Vehicle details updated successfully.']);
}

}