<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmployeeApplyLeave;
use App\Models\EmployeeGeneral;

use App\Models\HrmYear;
use Illuminate\Support\Facades\Auth;


class LeaveController extends Controller
{
    public function applyLeave(Request $request)
    {

        //         $employeeGeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
        //         $emailVnr = $employeeGeneral ? $employeeGeneral->ReportingEmailId : null; // Corrected field name

        // //    print_R($emailVnr);exit;

        $fromDate = new \DateTime($request->fromDate);
        $toDate = new \DateTime($request->toDate);
        $interval = $fromDate->diff($toDate);
        
        // Initialize totalDays
        $totalDays = 0;
    
        // Check the leave option
        if ($request->option === '1sthalf' || $request->option === '2ndhalf') {
            // If it's a half-day option, count each day as 0.5
            $totalDays = ($interval->days + 1) * 0.5; // Add 1 to include both start and end dates
        } else {
            // If it's a full day, count the total days normally
            $totalDays = $interval->days + 1; // Add 1 to include both start and end dates
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
        
    
        $leaveData = [
            'EmployeeID' => $request->employee_id,
            'Apply_Date' => now(),
            'Leave_Type' => $request->leaveType,
            'Apply_FromDate' => $request->fromDate,
            'Apply_ToDate' => $request->toDate,
            'Apply_TotalDay' => $totalDays,
            'Apply_Reason' => $request->reason,
            'Apply_ContactNo' => $request->contactNo,
            'Apply_DuringAddress' => $request->address,  
            'LeaveAppReason'=>'',
            'LeaveAppUpDate'=>now(),
            'LeaveRevReason'=>'',
            'LeaveRevUpDate'=>now(),
            'LeaveHodReason'=>'',
            'LeaveHodUpDate'=>now(),
            'ApplyLeave_UpdatedDate'=>now(),
            'ApplyLeave_UpdatedYearId'=>$year_id,
            'LeaveEmpCancelDate'=>now(),
            'LeaveEmpCancelReason'=>'',
            'PartialComment'=>'',
            'AdminComment'=>''   
        ];

        // Insert the data into hrm_employee_queryemp
        EmployeeApplyLeave::create($leaveData);

        return response()->json(['success' => true]);
    }
    public function fetchLeaveList(Request $request)
    {
        $employeeId = $request->employee_id;

        $leaves = EmployeeApplyLeave::where('EmployeeID', $employeeId)->get(); // Fetch leaves for the specified employee
    
        $leaveHtml = '';
        foreach ($leaves as $index => $leave) {
            $leaveHtml .= '<tr>
                <td>' . ($index + 1) . '.</td>
                <td style="width:80px;">' . $leave->Apply_Date . '</td>
                <td style="width:80px;">' . $leave->Apply_FromDate . '</td>
                <td style="width:80px;">' . $leave->Apply_ToDate . '</td>
                <td style="width:70px;">' . $leave->Apply_TotalDay . ' ' . ($leave->Apply_TotalDay == 1 ? 'Day' : 'Days') . '</td>
                <td style="width:80px;">
                    <label class="mb-0 badge badge-secondary" title="" data-original-title="' . $leave->Leave_Type . '">' . $leave->Leave_Type . '</label>
                </td>
                <td>
                    <p>' . $leave->Apply_Reason . '</p>
                </td>
                <td style="text-align:right;">';
                
            // Leave Status
            if ($leave->LeaveStatus == 0) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline danger-outline" title="" data-original-title="Draft">Draft</label>';
            } elseif ($leave->LeaveStatus == 1) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline warning-outline" title="" data-original-title="Pending">Pending</label>';
            } elseif ($leave->LeaveStatus == 2) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="" data-original-title="Approved">Approved</label>';
            } elseif ($leave->LeaveStatus == 3) {
                $leaveHtml .= '<label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline danger-outline" title="" data-original-title="Disapproved">Disapproved</label>';
            }
    
            $leaveHtml .= '</td></tr>';
        }
    
        return response()->json(['html' => $leaveHtml]);
    }
    
    
}


