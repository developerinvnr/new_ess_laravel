<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetName;
use App\Models\AssetsEmployeeCondition;
use App\Models\AssetRequest;
use Illuminate\Support\Facades\Auth;

class AssestsController extends Controller
{
    public function assests()
{
    // Get the authenticated user's EmployeeID
    $employeeId = Auth::user()->EmployeeID;

    // Fetch all asset names from the 'AssetName' table
    $assets = \DB::table('hrm_asset_name_emp')
    ->leftJoin('hrm_asset_name', 'hrm_asset_name_emp.AssetNId', '=', 'hrm_asset_name.AssetNId')
    ->where('hrm_asset_name_emp.EmployeeID', $employeeId)
    ->whereNotIn ('hrm_asset_name_emp.AssetNId', [11, 12, 18]) // Filter for specific AssetNId values
    ->select('hrm_asset_name_emp.*', 'hrm_asset_name.*')  // Select all columns from both tables
    ->get();


    $mobileeligibility = \DB::table('hrm_employee_eligibility')
        ->select('Mobile_Hand_Elig','Mobile_Hand_Elig_Rs','GPSSet')
        ->where('EmployeeID',$employeeId)
        ->where('Status','A')
        ->first();
    $AssetRequest = AssetRequest::where('EmployeeID', $employeeId)->get(); // Fetches all records where EmployeeID matches
    
    $assets_requestss = \DB::table('hrm_asset_employee_request')
    ->leftjoin('hrm_asset_name', 'hrm_asset_employee_request.AssetNId', '=', 'hrm_asset_name.AssetNId')
    ->leftJoin('hrm_employee', 'hrm_asset_employee_request.EmployeeID', '=', 'hrm_employee.EmployeeID')
    ->where(function ($query) use ($employeeId) {
        $query->where('ReportingId', $employeeId)
              ->orWhere('HodId', $employeeId);
    })
    ->when(true, function ($query) use ($employeeId) {
        $query->orWhere(function ($subQuery) use ($employeeId) {
            $subQuery->where('ITId', $employeeId)
                     ->where('HODApprovalStatus', 2);
        });
    })
    ->when(true, function ($query) use ($employeeId) {
        $query->orWhere(function ($subQuery) use ($employeeId) {
            $subQuery->where('AccId', $employeeId)
                     ->where('HODApprovalStatus', 2)
                     ->where('ITApprovalStatus', 2);
        });
    })
    ->where(function ($query) {
        $query->where('hrm_employee.EmpStatus', 'A');
            //   ->orWhereNull('hrm_employee.EmpStatus');
    })
    
    ->select('hrm_asset_employee_request.*', 'hrm_asset_name.AssetName', 'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.Lname','hrm_employee.EmpCode')
    ->orderBy('hrm_asset_employee_request.ReqDate', 'desc') // Sort by ReqDate in descending order to get the most recent request
    ->get();

    // Fetch the most recent request for the employee with AssetNId in [11, 12, 18]
    $assets_request_mobile = \DB::table('hrm_asset_employee_request')
    ->select('hrm_asset_employee_request.AssetNId', 'hrm_asset_employee_request.ReqDate', 'hrm_asset_employee_request.ReqAmt')
    ->whereIn('hrm_asset_employee_request.AssetNId', [11, 12, 18])  // Filter for specific AssetNId values
    ->where('EmployeeID', $employeeId)
    ->orderBy('ReqDate', 'desc') // Sort by ReqDate in descending order to get the most recent request
    ->first(); // Get only the most recent record
    $mobileeliprice = null;


        if ($mobileeligibility && ($mobileeligibility->GPSSet === 'N' || $mobileeligibility->GPSSet === '')) {
            if ($assets_request_mobile) {
                // Check if the asset ID is in the list [11, 12, 18]
                if (in_array($assets_request_mobile->AssetNId, [11, 12, 18])) {
                    
                    // Get the current date and calculate the date 2 years ago
                    $currentDate = now();
                    $twoYearsAgo = $currentDate->subYears(2);
        
                    // Ensure ReqAmt and Mobile_Hand_Elig_Rs are numeric before subtraction
                    $eligibilityAmount = floatval($mobileeligibility->Mobile_Hand_Elig_Rs);
                    $requestedAmount = floatval($assets_request_mobile->ReqAmt);
        
                    // Check if ReqDate is within the last 2 years
                    if ($assets_request_mobile->ReqDate >= $twoYearsAgo) {
                        $mobileeliprice = $eligibilityAmount;
                    } else {
                        $mobileeliprice = $eligibilityAmount - $requestedAmount;
                    }
                }
            }
        }
        
        if ($mobileeligibility && ($mobileeligibility->GPSSet === 'Y' || $mobileeligibility->GPSSet === '')) {
            if ($assets_request_mobile) {
                if (in_array($assets_request_mobile->AssetNId, [11, 12, 18])) {
                    
                    $currentDate = now();
                    $twoYearsAgo = $currentDate->subYears(3);
        
                    $eligibilityAmount = floatval($mobileeligibility->Mobile_Hand_Elig_Rs);
                    $requestedAmount = floatval($assets_request_mobile->ReqAmt);
        
                    if ($assets_request_mobile->ReqDate >= $twoYearsAgo) {
                        $mobileeliprice = $eligibilityAmount;
                    } else {
                        $mobileeliprice = $eligibilityAmount - $requestedAmount;
                    }
                }
            }
        } else {
            $mobileeliprice = floatval($mobileeligibility->Mobile_Hand_Elig_Rs);
        }
        


        // Check if there is an active employee with the given EmployeeID
            $exists = \DB::table('hrm_employee')
            ->join('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID') // join using RepEmployeeID in the general table
            ->where('hrm_employee.EmployeeID', $employeeId)  // match the EmployeeID from hrm_employee table
            ->where('hrm_employee.EmpStatus', 'A')  // Ensure the employee is active
            ->whereNotNull('hrm_employee_general.RepEmployeeID')  // Ensure RepEmployeeID is not null in the general table
            ->exists();  // Check if such a record exists
    // Pass assets_request and assets to the view

    return view('employee.assests', compact('assets', 'assets_requestss','AssetRequest','exists','mobileeligibility','mobileeliprice'));
    }
        public function fetchAssetsHistory($employeeId)
            {
                    // Fetch data from the table
                    $requests = \DB::table('hrm_asset_employee_request')
                    ->leftJoin('hrm_asset_name', 'hrm_asset_employee_request.AssetNId', '=', 'hrm_asset_name.AssetNId')
                    ->leftJoin('hrm_employee', 'hrm_asset_employee_request.EmployeeID', '=', 'hrm_employee.EmployeeID')
                    ->select(
                        'hrm_asset_employee_request.*',
                        'hrm_employee.Fname',
                        'hrm_employee.Lname',
                        'hrm_employee.Sname',
                        'hrm_employee.EmpCode',
                        \DB::raw("CASE 
                            WHEN hrm_asset_employee_request.AssetNId = 11 THEN 'Mobile Phone' 
                            WHEN hrm_asset_employee_request.AssetNId = 12 THEN 'Mobile Accessories' 
                            WHEN hrm_asset_employee_request.AssetNId = 18 THEN 'Mobile Maintenance' 
                            ELSE hrm_asset_name.AssetName 
                        END AS AssetName")
                    )
                    ->where('hrm_asset_employee_request.EmployeeID', $employeeId)
                    ->get();
                

                // Return JSON response
                return response()->json($requests);
            }
            public function fetchAssetsHistoryitclearance($employeeId)
        {
            // Fetch data for normal assets
            $requests = \DB::table('hrm_asset_employee_request')
                ->leftJoin('hrm_asset_name', 'hrm_asset_employee_request.AssetNId', '=', 'hrm_asset_name.AssetNId')
                ->leftJoin('hrm_employee', 'hrm_asset_employee_request.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->select(
                    'hrm_asset_employee_request.*',
                    'hrm_employee.Fname',
                    'hrm_employee.Lname',
                    'hrm_employee.Sname',
                    'hrm_employee.EmpCode',
                    \DB::raw("CASE 
                        WHEN hrm_asset_employee_request.AssetNId = 11 THEN 'Mobile Phone' 
                        WHEN hrm_asset_employee_request.AssetNId = 12 THEN 'Mobile Accessories' 
                        WHEN hrm_asset_employee_request.AssetNId = 18 THEN 'Mobile Maintenance' 
                        ELSE hrm_asset_name.AssetName 
                    END AS AssetName")
                )
                ->where('hrm_asset_employee_request.EmployeeID', $employeeId)
                ->get();

            // Fetch data for official assets from the 'official_asset' table
            $officialAssets = \DB::table('hrm_asset_employee')
                ->leftJoin('hrm_employee', 'hrm_asset_employee.EmployeeID', '=', 'hrm_employee.EmployeeID')
                ->leftJoin('hrm_asset_name', 'hrm_asset_employee.AssetNId', '=', 'hrm_asset_name.AssetNId')
                ->select(
                    'hrm_asset_employee.*',
                    'hrm_employee.Fname',
                    'hrm_employee.Lname',
                    'hrm_employee.Sname',
                    'hrm_employee.EmpCode',
                    'hrm_asset_name.AssetName'
                )
                ->where('hrm_asset_employee.EmployeeID', $employeeId)
                ->get();

            // Return JSON response with both normal assets and official assets
            return response()->json([
                'assets' => $requests, // Normal assets
                'official_assets' => $officialAssets // Official assets
            ]);
    }

    public function getAssetDetails($id) {
        $asset = \DB::table('hrm_asset_employee_request')->select(
            'hrm_asset_employee_request.AssetNId',
            'hrm_asset_employee_request.MaxLimitAmt',
            'hrm_asset_employee_request.ModelName',
            'hrm_asset_employee_request.ModelNo',
            'hrm_asset_employee_request.ComName AS VehicleBrand',
            'hrm_asset_employee_request.ComName AS CompanyName',
            'hrm_asset_employee_request.PurDate AS PurchaseDate',
            'hrm_asset_employee_request.DealeName AS DealerName',
            'hrm_asset_employee_request.DealerContNo AS DealerContact',
            'hrm_asset_employee_request.Price',
            'hrm_asset_employee_request.BillNo',
            'hrm_asset_employee_request.ReqAmt AS RequestAmount',
            'hrm_asset_employee_request.EmiNo AS IEMINo',
            'hrm_asset_employee_request.ReqAssestImgExtName AS BillCopy',
            'hrm_asset_employee_request.ReqBillImgExtName AS AssetCopy',
            'hrm_asset_employee_request.FuelType',
            'hrm_asset_employee_request.RegNo AS RegistrationNumber',
            'hrm_asset_employee_request.RegDate AS RegistrationDate',
            'hrm_asset_employee_request.DLNo_File AS DLCopy',
            'hrm_asset_employee_request.RCNo_File AS RCCopy',
            'hrm_asset_employee_request.InsuNo_File AS InsuranceCopy',
            'hrm_asset_employee_request.odo_copy AS OdometerReading',
            'hrm_asset_employee_request.Beg_OdoPhoto AS CurrentOdometerReading',
            'hrm_asset_employee_request.Owenship AS Ownership',
            'hrm_asset_employee_request.IdentityRemark AS Remarks',
            'hrm_asset_employee_request.HodId',
            'hrm_asset_employee_request.HODApprovalStatus',
            'hrm_asset_employee_request.HODRemark',
            'hrm_asset_employee_request.HODSubDate',
            'hrm_asset_employee_request.ITId',
            'hrm_asset_employee_request.ITApprovalStatus',
            'hrm_asset_employee_request.ITRemark',
            'hrm_asset_employee_request.ITSubDate',
            'hrm_asset_employee_request.AccId',
            'hrm_asset_employee_request.AccPayStatus',
            'hrm_asset_employee_request.AccRemark',
            'hrm_asset_employee_request.AccSubDate',
            'hrm_asset_name.AssetName AS AssetName',
            )->leftJoin('hrm_asset_name', 'hrm_asset_employee_request.AssetNId', '=', 'hrm_asset_name.AssetNId')->where('hrm_asset_employee_request.AssetEmpReqId', $id)->first();
        if ($asset) {
            return response()->json(['status' => 'success', 'data' => $asset, ]);
        }
        return response()->json(['status' => 'error', 'message' => 'Asset not found!', ], 404);
    }
    






}
