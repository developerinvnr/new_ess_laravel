<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetRequest;
use App\Models\AssetName;
use App\Models\Employee;
use App\Models\EmployeeReporting;
use Illuminate\Support\Facades\Auth;
use carbon\Carbon;
use App\Models\HrmYear;
use App\Models\Department;
use App\Models\HrmAssetDeptAccess;
use App\Models\HrmEmployeeVehicle;
use Illuminate\Support\Facades\Validator;



class AssetRequestController extends Controller
{
    public function store(Request $request)
    {
            // Define validation rules
    
        $requestAmount = $request->request_amount;
        $maximumLimit = $request->maximum_limit;
    
        // Check if the requested amount exceeds the maximum limit
        if ($requestAmount > $maximumLimit) {

            return response()->json(['success' => false, 'message' => 'Requested amount cannot exceed the maximum limit.'], 200);

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
                    // Check if all required fields are present in the request
                    // $requiredFields = [
                    //     'asset', 'request_amount', 'company_name', 'model_no', 'model_name', 'purchase_date',
                    //     'bill_number', 'price', 'maximum_limit', 'dealer_name', 
                    //     'dealer_contact'
                    // ];
                    
                    // // Map the field names to their human-readable labels
                    // $fieldLabels = [
                    //     'asset' => 'Asset',
                    //     'request_amount' => 'Request Amount',
                    //     'company_name' => 'Company Name',
                    //     'model_no' => 'Model No',
                    //     'model_name' => 'Model Name',
                    //     'purchase_date' => 'Purchase Date',
                    //     'bill_number' => 'Bill Number',
                    //     'price' => 'Price',
                    //     'maximum_limit' => 'Maximum Limit',
                    //     'dealer_name' => 'Dealer Name',
                    //     'dealer_contact' => 'Dealer Contact',
                    // ];
                    
                    // foreach ($requiredFields as $field) {
                    //     if (!$request->has($field) || empty($request->input($field))) {
                    //         // Use the human-readable label instead of the raw field name
                    //         $fieldLabel = $fieldLabels[$field] ?? ucfirst(str_replace('_', ' ', $field)); // Fallback to field name if no label is found
                    //         return response()->json(['success' => false, 'message' => "The field '$fieldLabel' is required."]);
                    //     }
                    // }
                    try {
                    // Handle file uploads if they exist
                    if ($request->hasFile('bill_copy')) {
                        // Store the uploaded bill copy in the public folder
                        $billCopyPath = $request->file('bill_copy')->store('bill_copies', 'public');
                    }
                    
                    if ($request->hasFile('asset_copy')) {
                        // Store the uploaded asset copy in the public folder
                        $assetCopyPath = $request->file('asset_copy')->store('asset_copies', 'public');
                    }
                    if ($request->hasFile('vehicle_photo')) {
                        // Store the uploaded asset copy in the public folder
                        $vehicle_photopath = $request->file('vehicle_photo')->store('vehicle_photo', 'public');
                    }
                    if ($request->hasFile('dl_copy')) {
                        // Store the uploaded asset copy in the public folder
                        $dl_copyPath = $request->file('dl_copy')->store('dl_copy', 'public');
                    }if ($request->hasFile('rc_copy')) {
                        // Store the uploaded asset copy in the public folder
                        $rc_copyPath = $request->file('rc_copy')->store('rc_copy', 'public');
                    }if ($request->hasFile('insurance_copy')) {
                        // Store the uploaded asset copy in the public folder
                        $insurance_copyPath = $request->file('insurance_copy')->store('insurance_copy', 'public');
                    }
                    if ($request->hasFile('odometer_reading')) {
                        // Store the uploaded asset copy in the public folder
                        $odometer_readingPath = $request->file('odometer_reading')->store('odometer_reading', 'public');
                    }
                    
                      // Step 5: Fetch ExpiryM from hrm_asset_name based on the asset ID from the request
                    $assetId = $request->asset; // Asset ID from the request
                    $asset = AssetName::where('AssetNId', $assetId)->first();
                    // If no asset record is found, return an error
                    if (!$asset) {
                        return response()->json(['success' => false, 'message' => 'Asset not found.'], 404);
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

                    $departments = Department::whereIn('DepartmentCode', ['IT', 'FINANCE'])
                    ->where('CompanyId', $emp_company_id)
                    ->get(['DepartmentID', 'DepartmentName']); // Fetching both DepartmentID and DepartmentName
                
                    // If no departments are found, handle gracefully
                    if ($departments->isEmpty()) {
                        // Handle the case where no departments are found (optional)
                        return response()->json(['error' => 'No departments found'], 404);
                    }
                    $departmentIds = $departments->pluck('DepartmentID'); // This will return a collection of DepartmentID(s)
                    $departmentNames = $departments->pluck('DepartmentName', 'DepartmentID'); // This will map DepartmentID to DepartmentName

                                        
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
                        'ReqDate' => Carbon::parse($purchaseDate)->format('Y-m-d'), // Format purchase date as YYYY-MM-DD
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
                        'ITId' => isset($employeeIds[0]) ? $employeeIds[0] : 0, // Set to '' or specify if available
                        'ITApprovalStatus' => 0, // Draft status or change based on approval
                        'ITRemark' => '', // Set to '' or specify if available
                        'ITSubDate' => empty($request->ITSubDate) ? null : $request->ITSubDate,
                        'AccId' => isset($employeeIds[1]) ? $employeeIds[1] : 0, // Use null if not available
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
                        'ReqAssestImgExtName' => $request->hasFile('asset_copy') ? $request->file('asset_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'ReqAssestImgExt' => $request->hasFile('asset_copy') ? $request->file('asset_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
                        'ReqBillImgExtName' => $request->hasFile('bill_copy') ? $request->file('bill_copy')->getClientOriginalExtension() : '', // Check if file is uploaded
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
                    \DB::table(table: 'hrm_asset_employee_request')->insert($assetRequestData);

                
                    return response()->json(['success' => true, 'message' => 'Asset request submitted successfully']);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'message' => 'Error occurred while submitting the request', 'error' => $e->getMessage()]);
                }
    }
    public function approveRequest(Request $request)
    {
        // dD($request->all());
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
        $updateFields = [
            'ITApprovalStatus' => $request->approval_status,
            'ITRemark' => $request->remark,
            'ITSubDate' => $request->approval_date
        ];
    } 
elseif ($employeeId == $assetRequest->AccId) {
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
    $asset = \DB::table('hrm_asset_name')->where('AssetNId', $assetNId)->first();

    if ($asset) {
        // Ensure the AssetLimit is a float and perform the subtraction
        $newAssetLimit = (float)$asset->AssetLimit - (float)$request->pay_amt;

        // Update the AssetLimit in hrm_asset_name
        \DB::table('hrm_asset_name')
            ->where('AssetNId', $assetNId)
            ->update(['AssetLimit' => number_format($newAssetLimit, 2, '.', '')]);

        // Return success response
        return response()->json(['success' => true, 'message' => 'Approval status and AssetLimit updated successfully.']);
    } else {
        return back()->withErrors(['error' => 'Asset not found in hrm_asset_name.']);
    }
}

    // If no valid role is found, return an error
    if (!$updateFields) {
        return back()->withErrors(['error' => 'Unauthorized user or invalid approval status.']);
    }

    // Perform the update with the corresponding fields
    $assetRequest->update($updateFields);
 
        // Check if all required approval statuses are 1 (HOD, IT, and Acc)
        if ($assetRequest->HODApprovalStatus == 2 && $assetRequest->ITApprovalStatus == 2 && $assetRequest->AccPayStatus == 2) {
            // If all are approved, update the overall ApprovalStatus and ApprovalDate
            $assetRequest->ApprovalStatus = 2;
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
            'AccSubDate' => $request->approval_date
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
        // Save vehicle data for two-wheeler (vehicle data)
        $vehicleData = [
            'EmployeeID' => $EmployeeID,
            'model_name' => $request->model_name,
            'model_no' => $request->model_no,
            'brand'=>$request->vehicle_brand,
            'dealer_name' => $request->dealer_name,
            'dealer_contact' => $request->dealer_contact,
            'purchase_date' => $request->registration_date,
            'price' => $request->price,
            'registration_no' => $request->registration_number,
            'registration_date' => $request->registration_date,
            'bill_no' => $request->bill_number,
            'fuel_type' => $request->fuel_typenew,
            'ownership' => $request->ownershipnew,
            'vehicle_image' => $request->file('vehicle_photonew')->store('vehicle_photonews'),
            'rc_file' => $request->file('rc_copy')->store('rc_copys'),
            'insurance' => $request->file('insurance_copy')->store('insurance_copy_files'),
            'remark' => $request->remark,
            'CreatedBy' => Auth::id(), // Logged-in user ID
            'CreatedDate' => now(),
            'YearId' => date('Y'),
        ];

        // Save the data to the `hrm_employee_vehicle` table (for two-wheeler)
        $vehicle = HrmEmployeeVehicle::create($vehicleData);

        // Check if data for four-wheeler is present and save accordingly
        if ($request->vehicle_typenew == "4-wheeler") {
            $fourWheelerData = [
                'EmployeeID' => $request->EmployeeID,
                'EmpCode' => $request->EmpCode,
                'model_name' => $request->model_name,
                'model_no' => $request->model_no,
                'brand'=>$request->vehicle_brand,
                'dealer_name' => $request->dealer_name,
                'dealer_contact' => $request->dealer_contact,
                'purchase_date' => $request->registration_date,
                'price' => $request->price,
                'registration_no' => $request->registration_number,
                'registration_date' => $request->registration_date,
                'four_model_name' => $request->model_name,
                'four_model_no' => $request->model_no,
                'four_dealer_name' => $request->dealer_name,
                'four_dealer_contact' => $request->dealer_contact,
                'four_purchase_date' => $request->purchase_date,
                'four_price' => $request->price,
                'four_registration_no' => $request->registration_no,
                'four_registration_date' => $request->registration_date,
                'four_bill_no' => $request->bill_no,
                'four_fuel_type' => $request->fuel_type,
                'four_ownership' => $request->ownership,
                'four_vehicle_image' => $request->file('vehicle_image')->store('vehicle_images'),
                'four_rc_file' => $request->file('rc_file')->store('rc_files'),
                'four_insurance' => $request->file('insurance')->store('insurance_files'),
                'remark' => $request->remark,
                'CreatedBy' => Auth::id(),
                'CreatedDate' => now(),
                'YearId' => date('Y'),
            ];

            // Save the four-wheeler data if available
            HrmEmployeeVehicle::create($fourWheelerData);
        }

        // Redirect back or to a success page
        return response()->json(['message' => 'Vehcile details submitted successfully!'], 200);
    }
    public function updateVehicle(Request $request)
    {

        // Find the vehicle by ID and update it
        $vehicle = HrmEmployeeVehicle::find($request->request_id);

        if ($vehicle) {
            $vehicle->update([
                'brand' => $request->brand,
                'model_name' => $request->model_name,
                'model_no' => $request->model_no,
                'dealer_name' => $request->dealer_name,
                'dealer_contact' => $request->dealer_contact,
                'purchase_date' => $request->purchase_date,
                'price' => $request->price,
                'registration_no' => $request->registration_no,
                'registration_date' => $request->registration_date,
                'bill_no' => $request->bill_no,
                'fuel_type' => $request->fuel_type,
                'ownership' => $request->ownership,
            ]);

            return response()->json(['success' => true, 'message' => 'Vehicle details updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Vehicle not found.'], 404);
    }

}