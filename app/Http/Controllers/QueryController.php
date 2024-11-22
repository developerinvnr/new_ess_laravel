<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DepartmentSubject;
use App\Models\EmployeeReporting;
use App\Models\QueryMapEmp;
use App\Models\EmployeeGeneral;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\QuerySubmitted;



class QueryController extends Controller
{
    public function query()
    {
        return view("employee.query");
    }

    public function querysubmit(Request $request)
    {
        $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->Department_name_sub)
            ->where('DepartmentId', $request->Department_name)
            ->first();


        if (!$departmentQuerySub) {
            return response()->json(['error' => 'Invalid subject or department'], 404);
        }

        // Fetch the employee reporting details
        $employeeReporting = EmployeeReporting::where('EmployeeID', $request->employee_id)->first();

        if (!$employeeReporting) {
            return response()->json(['error' => 'Employee reporting details not found'], 404);
        }

        // Fetch the employee's email from EmployeeGeneral
        // $employeeGeneral = EmployeeGeneral::where('EmployeeID', $employeeReporting->ReportingId)->first();

        // if (!$employeeGeneral) {
        //     return response()->json(['error' => 'Employee email not found'], 404);
        // }
        $queryData = [
            'EmployeeID' => $request->employee_id,
            'RepMgrId' => $employeeReporting->AppraiserId,
            'HodId' => $employeeReporting->HodId,
            'QToDepartmentId' => $request->Department_name,
            'QSubjectId' => $departmentQuerySub->DeptQSubId,
            'QuerySubject' => $request->Department_name_sub,
            'HideYesNo' => $request->has('hide_name') ? 'Y' : 'N', // 'Y' if checked, 'N' if unchecked
            'QueryDT' => Carbon::now(),
            'QueryValue' => $request->remarks,
            'AssignEmpId' => $departmentQuerySub->AssignEmpId,
            'Level_1ID' => $departmentQuerySub->AssignEmpId,

        ];
        // Insert the data into hrm_employee_queryemp
        QueryMapEmp::create($queryData);
        try {
            // Pass individual parameters
            // Mail::to($employeeGeneral->EmailId_Vnr)->send(new QuerySubmitted(
            //     $queryData['EmployeeID'],
            //     $queryData['RepMgrId'],
            //     $queryData['HodId'],
            //     $queryData['QueryValue'],
            //     $queryData['QuerySubject']
            // ));

            return response()->json(['success' => 'Query submitted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
        // return response()->json(['success' => 'Query submitted successfully!']);
    }

    public function getQueriesForUser()
    {
        $user = Auth::user(); // Get the logged-in user
        $queries = \DB::table('hrm_employee_queryemp')
            ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId') // Join with hrm_employee to fetch employee details
            ->join('hrm_department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_department.DepartmentID') // Join with hrm_department to fetch department details
            ->where('AssignEmpId', $user->EmployeeID) // Filter queries for the logged-in employee
            ->select(
                'hrm_employee_queryemp.*',
                'hrm_employee.Fname',
                'hrm_employee.Sname',
                'hrm_employee.Lname',
                'hrm_department.DepartmentName'
            )
            ->orderBy('hrm_employee_queryemp.created_at', 'desc') // Order by CreatedAt column in descending order
            ->get();

        return response()->json($queries); // Return data as JSON
    }
    public function getDeptQuerySubForDepartment(Request $request)
    {
        $query_id = $request->queryid;

        // Fetch DeptQSubject and AssignEmpId from hrm_deptquerysub based on the QToDepartmentId from hrm_employee_queryemp
        $deptQuerySub = \DB::table('hrm_employee_queryemp')
            ->join('hrm_deptquerysub', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_deptquerysub.DepartmentId') // Join with hrm_deptquerysub
            ->where('hrm_employee_queryemp.QueryID', $query_id) // Filter based on query ID
            ->select('hrm_deptquerysub.DeptQSubject', 'hrm_deptquerysub.AssignEmpId') // Select only the relevant fields
            ->get();
        return response()->json($deptQuerySub);
    }


    public function updateQueryAction(Request $request)
    {
        $user_id = Auth::user()->EmployeeID;

        // Retrieve the query record
        $query = \DB::table('hrm_employee_queryemp')->where('QueryID', $request->query_id)->first();
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Query not found']);
        }

        // Check which level the user is associated with
        if ($query->Level_1ID == $user_id) {
            // User is associated with Level 1
            $level = 'Level_1ID';
        } elseif ($query->Level_2ID == $user_id) {
            // User is associated with Level 2
            $level = 'Level_2ID';
        } elseif ($query->Level_3ID == $user_id) {
            // User is associated with Level 3
            $level = 'Level_3ID';
        } else {
            // The user is not associated with any of the levels for this query
            return response()->json(['success' => false, 'message' => 'User is not associated with this query']);
        }
        if ($request->forwardTo == "0") {
            $forwardto = 'N';

        }
        if ($request->forwardTo != "0") {
            $forwardto = 'Y';
        }
        if ($forwardto == "Y") {

            // Check if Level 1 Forward Employee ID is "0"
            if ($query->Level_1QFwdEmpId == "0") {
                $Level_1QFwdEmpId = $request->assignEmpId;
                $Level_1QFwdReason = $request->forwardReason;
                $Level_1QFwdDT = now();  // Use current date and time
                $Level_1QFwdNoOfTime = 1;
                $assign_emp_id = $request->assignEmpId;

                if ($level == 'Level_1ID') {
                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_1QStatus' => $request->status,
                            'Level_1ReplyAns' => $request->reply,
                            'Level_1QToDT' => now(), // Current datetime
                            'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_1QFwd' => $forwardto,
                            'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId2' => '0',
                            'Level_1QFwdEmpId3' => '0',
                            'Level_1QFwdReason' => $Level_1QFwdReason,
                            'Level_1QFwdReason2' => '0',
                            'Level_1QFwdReason3' => '0',
                            'Level_1QFwdDT' => $Level_1QFwdDT,
                            'Level_1QFwdDT2' => NULL,
                            'Level_1QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,

                        ]);


                }
                if ($level == 'Level_2ID') {
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_2QStatus' => $request->status,
                            'Level_2ReplyAns' => $request->reply,
                            'Level_2QToDT' => now(), // Current datetime
                            'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_2QFwd' => $forwardto,
                            'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId2' => '0',
                            'Level_1QFwdEmpId3' => '0',
                            'Level_1QFwdReason' => $Level_1QFwdReason,
                            'Level_1QFwdReason2' => '0',
                            'Level_1QFwdReason3' => '0',
                            'Level_1QFwdDT' => $Level_1QFwdDT,
                            'Level_1QFwdDT2' => NULL,
                            'Level_1QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,

                        ]);

                }
                if ($level == 'Level_3ID') {
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_1QStatus' => $request->status,
                            'Level_1ReplyAns' => $request->reply,
                            'Level_1QToDT' => now(), // Current datetime
                            'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_1QFwd' => $forwardto,
                            'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId2' => '0',
                            'Level_1QFwdEmpId3' => '0',
                            'Level_1QFwdReason' => $Level_1QFwdReason,
                            'Level_1QFwdReason2' => '0',
                            'Level_1QFwdReason3' => '0',
                            'Level_1QFwdDT' => $Level_1QFwdDT,
                            'Level_1QFwdDT2' => NULL,
                            'Level_1QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => $request->reply,
                            'AssignEmpId' => $assign_emp_id,
                        ]);

                }

            }


            // Check if Level 1 Forward Employee ID is not "0" and Level 2 Forward Employee ID is "0"
            if ($query->Level_1QFwdEmpId != "0" && $query->Level_2QFwdEmpId == "0") {
                $Level_2QFwdEmpId = $request->assignEmpId;
                $Level_2QFwdReason = $request->forwardReason;
                $Level_2QFwdDT = now();  // Use current date and time
                $Level_1QFwdNoOfTime = 2;
                $assign_emp_id = $request->assignEmpId;
                if ($level == 'Level_1ID') {
                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_1QStatus' => $request->status,
                            'Level_1ReplyAns' => $request->reply,
                            'Level_1QToDT' => now(), // Current datetime
                            'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_1QFwd' => $forwardto,
                            'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                            'Level_1QFwdEmpId3' => '0',
                            'Level_1QFwdReason' => $Level_1QFwdReason,
                            'Level_1QFwdReason2' => $Level_2QFwdReason,
                            'Level_1QFwdReason3' => '0',
                            'Level_1QFwdDT' => $Level_1QFwdDT,
                            'Level_1QFwdDT2' => $Level_2QFwdDT,
                            'Level_1QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => $request->reply,
                            'AssignEmpId' => $assign_emp_id,

                        ]);
                    if ($level == 'Level_2ID') {
                        \DB::table('hrm_employee_queryemp')
                            ->where('QueryID', $request->query_id)
                            ->update([
                                'Level_2QStatus' => $request->status,
                                'Level_2ReplyAns' => $request->reply,
                                'Level_2QToDT' => now(), // Current datetime
                                'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                                'Level_2QFwd' => $forwardto,
                                'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                                'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                                'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                                'Level_1QFwdEmpId3' => '0',
                                'Level_1QFwdReason' => $Level_1QFwdReason,
                                'Level_1QFwdReason2' => $Level_2QFwdReason,
                                'Level_1QFwdReason3' => '0',
                                'Level_1QFwdDT' => $Level_1QFwdDT,
                                'Level_1QFwdDT2' => $Level_2QFwdDT,
                                'Level_1QFwdDT3' => NULL,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,

                            ]);

                    }
                    if ($level == 'Level_3ID') {
                        \DB::table('hrm_employee_queryemp')
                            ->where('QueryID', $request->query_id)
                            ->update([
                                'Level_1QStatus' => $request->status,
                                'Level_1ReplyAns' => $request->reply,
                                'Level_1QToDT' => now(), // Current datetime
                                'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                                'Level_1QFwd' => $forwardto,
                                'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                                'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                                'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                                'Level_1QFwdEmpId3' => '0',
                                'Level_1QFwdReason' => $Level_1QFwdReason,
                                'Level_1QFwdReason2' => $Level_2QFwdReason,
                                'Level_1QFwdReason3' => '0',
                                'Level_1QFwdDT' => $Level_1QFwdDT,
                                'Level_1QFwdDT2' => $Level_2QFwdDT,
                                'Level_1QFwdDT3' => NULL,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,
                            ]);

                    }


                }


            }

            // Check if Level 1 and Level 2 Forward Employee IDs are not "0", and Level 3 Forward Employee ID is "0"
            if ($query->Level_1QFwdEmpId != "0" && $query->Level_2QFwdEmpId != "0" && $query->Level_3QFwdEmpId == "0") {
                dd('sdfsdf');
                $Level_3QFwdEmpId = $request->assignEmpId;
                $Level_3QFwdReason = $request->forwardReason;
                $Level_3QFwdDT = now();  // Use current date and time
                $Level_1QFwdNoOfTime = 3;
                $assign_emp_id = $request->assignEmpId;

                if ($level == 'Level_1ID') {
                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_1QStatus' => $request->status,
                            'Level_1ReplyAns' => $request->reply,
                            'Level_1QToDT' => now(), // Current datetime
                            'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_1QFwd' => $forwardto,
                            'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                            'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
                            'Level_1QFwdReason' => $Level_1QFwdReason,
                            'Level_1QFwdReason2' => $Level_2QFwdReason,
                            'Level_1QFwdReason3' => $Level_3QFwdReason,
                            'Level_1QFwdDT' => $Level_1QFwdDT,
                            'Level_1QFwdDT2' => $Level_2QFwdDT,
                            'Level_1QFwdDT3' => $Level_3QFwdDT,
                            'QueryStatus_Emp' => $request->status,
                            'QueryReply' => $request->reply,
                            'AssignEmpId' => $assign_emp_id,

                        ]);
                    if ($level == 'Level_2ID') {
                        \DB::table('hrm_employee_queryemp')
                            ->where('QueryID', $request->query_id)
                            ->update([
                                'Level_2QStatus' => $request->status,
                                'Level_2ReplyAns' => $request->reply,
                                'Level_2QToDT' => now(), // Current datetime
                                'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                                'Level_2QFwd' => $forwardto,
                                'Level_2QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                                'Level_2QFwdEmpId' => $Level_1QFwdEmpId,
                                'Level_2QFwdEmpId2' => $Level_2QFwdEmpId,
                                'Level_2QFwdEmpId3' => $Level_3QFwdEmpId,
                                'Level_2QFwdReason' => $Level_1QFwdReason,
                                'Level_2QFwdReason2' => $Level_2QFwdReason,
                                'Level_2QFwdReason3' => $Level_3QFwdReason,
                                'Level_2QFwdDT' => $Level_1QFwdDT,
                                'Level_2QFwdDT2' => $Level_2QFwdDT,
                                'Level_2QFwdDT3' => $Level_3QFwdDT,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,

                            ]);

                    }
                    if ($level == 'Level_3ID') {
                        \DB::table('hrm_employee_queryemp')
                            ->where('QueryID', $request->query_id)
                            ->update([
                                'Level_1QStatus' => $request->status,
                                'Level_1ReplyAns' => $request->reply,
                                'Level_1QToDT' => now(), // Current datetime
                                'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                                'Level_1QFwd' => $forwardto,
                                'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                                'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                                'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                                'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
                                'Level_1QFwdReason' => $Level_1QFwdReason,
                                'Level_1QFwdReason2' => $Level_2QFwdReason,
                                'Level_1QFwdReason3' => $Level_3QFwdReason,
                                'Level_1QFwdDT' => $Level_1QFwdDT,
                                'Level_1QFwdDT2' => $Level_2QFwdDT,
                                'Level_1QFwdDT3' => $Level_3QFwdDT,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,
                            ]);

                    }


                }
            }

        }

        if ($forwardto == "N") {
            // Check if Level 1 Forward Employee ID is "0"
            $Level_1QFwdEmpId = 0;
            $Level_1QFwdReason = 0;
            $Level_1QFwdDT = null;  // Use current date and time
            $Level_1QFwdNoOfTime = 0;
            $assign_emp_id = $query->AssignEmpId;

            $Level_2QFwdEmpId = 0;
            $Level_2QFwdReason = 0;
            $Level_2QFwdDT = null;  // Use current date and time
            $Level_1QFwdNoOfTime = 0;
            $assign_emp_id = $query->AssignEmpId;



            $Level_3QFwdEmpId = 0;
            $Level_3QFwdReason = 0;
            $Level_3QFwdDT = null;  // Use current date and time
            $Level_1QFwdNoOfTime = 0;
            $assign_emp_id = $query->AssignEmpId;

            if ($level == 'Level_1ID') {
                // Update the query status, reply, and forward_to fields
                \DB::table('hrm_employee_queryemp')
                    ->where('QueryID', $request->query_id)
                    ->update([
                        'Level_1QStatus' => $request->status,
                        'Level_1ReplyAns' => $request->reply,
                        'Level_1QToDT' => now(), // Current datetime
                        'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                        'Level_1QFwd' => $forwardto,
                        'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                        'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                        'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                        'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
                        'Level_1QFwdReason' => $Level_1QFwdReason,
                        'Level_1QFwdReason2' => $Level_2QFwdReason,
                        'Level_1QFwdReason3' => $Level_3QFwdReason,
                        'Level_1QFwdDT' => $Level_1QFwdDT,
                        'Level_1QFwdDT2' => $Level_2QFwdDT,
                        'Level_1QFwdDT3' => $Level_3QFwdDT,
                        'QueryStatus_Emp' =>'0',
                        'QueryReply' => '',
                        'AssignEmpId' => $assign_emp_id,

                    ]);
                if ($level == 'Level_2ID') {
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_2QStatus' => $request->status,
                            'Level_2ReplyAns' => $request->reply,
                            'Level_2QToDT' => now(), // Current datetime
                            'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_2QFwd' => $forwardto,
                            'Level_2QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_2QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_2QFwdEmpId2' => $Level_2QFwdEmpId,
                            'Level_2QFwdEmpId3' => $Level_3QFwdEmpId,
                            'Level_2QFwdReason' => $Level_1QFwdReason,
                            'Level_2QFwdReason2' => $Level_2QFwdReason,
                            'Level_2QFwdReason3' => $Level_3QFwdReason,
                            'Level_2QFwdDT' => $Level_1QFwdDT,
                            'Level_2QFwdDT2' => $Level_2QFwdDT,
                            'Level_2QFwdDT3' => $Level_3QFwdDT,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,

                        ]);

                }
                if ($level == 'Level_3ID') {
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_1QStatus' => $request->status,
                            'Level_1ReplyAns' => $request->reply,
                            'Level_1QToDT' => now(), // Current datetime
                            'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_1QFwd' => $forwardto,
                            'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                            'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                            'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
                            'Level_1QFwdReason' => $Level_1QFwdReason,
                            'Level_1QFwdReason2' => $Level_2QFwdReason,
                            'Level_1QFwdReason3' => $Level_3QFwdReason,
                            'Level_1QFwdDT' => $Level_1QFwdDT,
                            'Level_1QFwdDT2' => $Level_2QFwdDT,
                            'Level_1QFwdDT3' => $Level_3QFwdDT,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                        ]);

                }


            }

        }
        if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
            return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
        }
        return response()->json(['success' => true, 'message' => 'Query action updated successfully']);
    }

    public function updateQueryRating(Request $request)
    {

        // Use the where method to find the record and update it
        $affectedRows = QueryMapEmp::where('QueryId', $request->queryId)
                               ->update(['EmpQRating' => $request->rating]);

    // Check if the update was successful (affected rows should be > 0)
    if ($affectedRows > 0) {
        return response()->json(['success' => true, 'message' => 'Rating updated successfully!']);
    } else {
        return response()->json(['success' => false, 'message' => 'Query not found or no update made']);
    }
    }

    public function fetchQueryDetails(Request $request)
{
    $queryId = $request->input('query_id');
      // Fetch the query along with the related department data using eager loading
      $query = \DB::table('hrm_employee_queryemp')
      ->join('hrm_Department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_Department.DepartmentId')  // Join hrm_Department based on DepartmentId
      ->where('hrm_employee_queryemp.QueryId', $queryId)  // Filter by QueryId
      ->select(
          'hrm_employee_queryemp.*',          // Select all fields from QueryMapEmp
          'hrm_Department.*'       // Select all fields from hrm_Department
      )
      ->first();  // Get the first matching record

    if ($query) {
        return response()->json($query); // Return data as JSON
    }

     else {
        return response()->json(['error' => 'Query not found'], 404);
    }
}

public function submitAction(Request $request)
{
    // Use the where method to find the record and update it
    $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
        ->update([
            'QueryStatus_Emp' => $request->status,
            'EmpQRating' => $request->rating,
            'QueryReply' => $request->remark,
            'QStatus'=>$request->status,
        ]);

        if ($affectedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Query updated successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Query not found or no update made']);
        }
}





}
