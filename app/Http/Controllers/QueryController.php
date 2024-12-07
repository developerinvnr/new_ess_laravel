<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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
        $employeeID = Auth::user()->EmployeeID; // Get authenticated user's employee ID
        // Fetch data based on the given conditions
        $queries_frwrd = QueryMapEmp::where('AssignEmpId', '!=', $employeeID)
                        ->where(function($query) {
                            $query->where('Level_1QFwd', 'Y')
                                ->orWhere('Level_2QFwd', 'Y')
                                ->orWhere('Level_3QFwd', 'Y');
                        })
                        ->where(function($query) use ($employeeID) {
                            $query->where('Level_1ID', $employeeID)
                                  ->orWhere('Level_1QFwdEmpId', $employeeID)
                                  ->orWhere('Level_1QFwdEmpId2', $employeeID)
                                  ->orWhere('Level_1QFwdEmpId3', $employeeID)
                                  ->orWhere('Level_2QFwdEmpId', $employeeID)
                                  ->orWhere('Level_2QFwdEmpId2', $employeeID)
                                  ->orWhere('Level_2QFwdEmpId3', $employeeID)
                                  ->orWhere('Level_3QFwdEmpId', $employeeID)
                                  ->orWhere('Level_3QFwdEmpId2', $employeeID)
                                  ->orWhere('Level_3QFwdEmpId3', $employeeID)
                                  ->orWhere('Level_3ID', $employeeID)
                                  ->orWhere('Level_2ID', $employeeID);

                        })
                        ->get(); // Get the result from database
                        $employeeIDs = $queries_frwrd->pluck('EmployeeID')
                        ->unique();
                // Step 3: Fetch employee details (Fname, Sname, Lname) from hrm_employee table for these EmployeeIDs
                $employees = Employee::whereIn('EmployeeID', $employeeIDs)
                    ->get(['EmployeeID', 'Fname', 'Sname', 'Lname']); // Adjust the model name as needed
          
                // Step 4: Map employees to easily access their names by EmployeeID
                $employeeNames = $employees->keyBy('EmployeeID');
                $separationRecord = \DB::table('hrm_employee_separation')->where('EmployeeID', $employeeID)->first();
                if ($separationRecord) {
                    return view("seperation.query", compact('queries_frwrd', 'employeeNames'));
                }
    
                return view("employee.query", compact('queries_frwrd', 'employeeNames'));
    }

    public function querysubmit(Request $request)
    {
                     // Log the incoming request data to help with debugging

       // Check if the department is null or empty
       if (is_null($request->Department_name) || empty($request->Department_name)) {
           return response()->json(['error' => 'Please select department'], 200);
       }
       
       // Check if the department subject is null or empty
       if (is_null($request->Department_name_sub) || empty($request->Department_name_sub)) {
           return response()->json(['error' => 'Please select department subject'], 200);
       }
       
       
       // Check if the remark is null or empty (after trimming any extra spaces)
       if (is_null($request->remarks) || empty(trim($request->remarks))) {
           return response()->json(['error' => 'Remark is mandatory'], 200);
       }
                
        $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->Department_name_sub)
            ->where('DepartmentId', $request->Department_name)
            ->first();


        if (!$departmentQuerySub) {
            return response()->json(['error' => 'Invalid subject or department'], 404);
        }

        // Fetch the employee reporting details
        $employeeReporting = EmployeeReporting::where('EmployeeID', $request->employee_id)->first();

        if (!$employeeReporting) {
            return response()->json(['error' => 'Employee reporting details not found'], 200);
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
        ->join('hrm_department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_department.DepartmentID') // Join with hrm_department to fetch department detail
        ->select(
            'hrm_employee_queryemp.*',
            'hrm_department.DepartmentName'
        )
        ->where(function ($query) use ($user) {
            $query->where('hrm_employee_queryemp.AssignEmpId', $user->EmployeeID)
                  ->orWhere('hrm_employee_queryemp.RepMgrId', $user->EmployeeID)
                  ->orWhere('hrm_employee_queryemp.HodId', $user->EmployeeID);

        })
        ->whereNull('deleted_at')
        ->orderBy('hrm_employee_queryemp.created_at', 'desc') // Order by CreatedAt column in descending order
        ->get(); // Modify this to paginate, 10 queries per page for example

        // $queries = \DB::table('hrm_employee_queryemp')
        // ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId') // Join with hrm_employee to fetch employee details
        // ->join('hrm_department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_department.DepartmentID') // Join with hrm_department to fetch department details
        // ->where('hrm_employee_queryemp.AssignEmpId', $user->EmployeeID) // Filter queries for the logged-in employee
        // ->orWhere('hrm_employee_queryemp.Level_1QFwdEmpId', $user->EmployeeID) // Check if the logged-in user is assigned in Level 1 fields
        // ->orWhere('hrm_employee_queryemp.Level_1QFwdEmpId2', $user->EmployeeID) // Check if the logged-in user is assigned in Level 1 field 2
        // ->orWhere('hrm_employee_queryemp.Level_1QFwdEmpId3', $user->EmployeeID) // Check if the logged-in user is assigned in Level 1 field 3
        // ->orWhere('hrm_employee_queryemp.Level_2QFwdEmpId', $user->EmployeeID) // Check if the logged-in user is assigned in Level 2 fields
        // ->orWhere('hrm_employee_queryemp.Level_2QFwdEmpId2', $user->EmployeeID) // Check if the logged-in user is assigned in Level 2 field 2
        // ->orWhere('hrm_employee_queryemp.Level_2QFwdEmpId3', $user->EmployeeID) // Check if the logged-in user is assigned in Level 2 field 3
        // ->orWhere('hrm_employee_queryemp.Level_3QFwdEmpId', $user->EmployeeID) // Check if the logged-in user is assigned in Level 3 fields
        // ->orWhere('hrm_employee_queryemp.Level_3QFwdEmpId2', $user->EmployeeID) // Check if the logged-in user is assigned in Level 3 field 2
        // ->orWhere('hrm_employee_queryemp.Level_3QFwdEmpId3', $user->EmployeeID) // Check if the logged-in user is assigned in Level 3 field 3
        // ->orWhere('hrm_employee_queryemp.Mngmt_QFwdEmpId', $user->EmployeeID) // Check if the logged-in user is assigned in Management field
        // ->orWhere('hrm_employee_queryemp.Mngmt_QFwdEmpId2', $user->EmployeeID) // Check if the logged-in user is assigned in Management field 2
        // ->orWhere('hrm_employee_queryemp.Mngmt_QFwdEmpId3', $user->EmployeeID) // Check if the logged-in user is assigned in Management field 3
        // ->select(
        //     'hrm_employee_queryemp.*',
        //     'hrm_department.DepartmentName'
        // )
        // ->orderBy('hrm_employee_queryemp.created_at', 'desc') // Order by CreatedAt column in descending order
        // ->get();
        if($queries){
            foreach($queries as $query){
                $queryid=$query->EmployeeID;

                $employeeDetails = \DB::table('hrm_employee')
                ->where('EmployeeID', $queryid)  // Match the EmployeeID from the query
                ->select('Fname', 'Sname', 'Lname')  // Fetch the first, second, and last name
                ->first(); // Use first() to get a single result
    
            // Now you have the employee details for this query's EmployeeID
            if ($employeeDetails) {
                // Add the details to your query
                $query->Fname = $employeeDetails->Fname;
                $query->Sname = $employeeDetails->Sname;
                $query->Lname = $employeeDetails->Lname;
            }
           
            }
        }
        

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


    // public function updateQueryAction(Request $request)
    // {
    //     $user_id = Auth::user()->EmployeeID;

    //     // Retrieve the query record
    //     $query = \DB::table('hrm_employee_queryemp')->where('QueryID', $request->query_id)->first();
    //     if (!$query) {
    //         return response()->json(['success' => false, 'message' => 'Query not found']);
    //     }

    //     // Check which level the user is associated with
    //     if ($query->Level_1ID == $user_id) {
    //         // User is associated with Level 1
    //         $level = 'Level_1ID';
    //     } elseif ($query->Level_2ID == $user_id) {
    //         // User is associated with Level 2
    //         $level = 'Level_2ID';
    //     } elseif ($query->Level_3ID == $user_id) {
    //         // User is associated with Level 3
    //         $level = 'Level_3ID';
    //     } else {
    //         // The user is not associated with any of the levels for this query
    //         return response()->json(['success' => false, 'message' => 'User is not associated with this query']);
    //     }
    //     if ($request->forwardTo == "0") {
    //         $forwardto = 'N';

    //     }
    //     if ($request->forwardTo != "0") {
    //         $forwardto = 'Y';
    //     }
    //     if ($forwardto == "Y") {

    //         // Check if Level 1 Forward Employee ID is "0"
    //         if ($query->Level_1QFwdEmpId == "0") {
    //             $Level_1QFwdEmpId = $request->assignEmpId;
    //             $Level_1QFwdReason = $request->forwardReason;
    //             $Level_1QFwdDT = now();  // Use current date and time
    //             $Level_1QFwdNoOfTime = 1;
    //             $assign_emp_id = $request->assignEmpId;

    //             if ($level == 'Level_1ID') {
    //                 // Update the query status, reply, and forward_to fields
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_1QStatus' => $request->status,
    //                         'Level_1ReplyAns' => $request->reply,
    //                         'Level_1QToDT' => now(), // Current datetime
    //                         'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_1QFwd' => $forwardto,
    //                         'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_1QFwdEmpId2' => '0',
    //                         'Level_1QFwdEmpId3' => '0',
    //                         'Level_1QFwdReason' => $Level_1QFwdReason,
    //                         'Level_1QFwdReason2' => '0',
    //                         'Level_1QFwdReason3' => '0',
    //                         'Level_1QFwdDT' => $Level_1QFwdDT,
    //                         'Level_1QFwdDT2' => NULL,
    //                         'Level_1QFwdDT3' => NULL,
    //                         'QueryStatus_Emp' => '0',
    //                         'QueryReply' => '',
    //                         'AssignEmpId' => $assign_emp_id,

    //                     ]);


    //             }
    //             if ($level == 'Level_2ID') {
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_2QStatus' => $request->status,
    //                         'Level_2ReplyAns' => $request->reply,
    //                         'Level_2QToDT' => now(), // Current datetime
    //                         'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_2QFwd' => $forwardto,
    //                         'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_1QFwdEmpId2' => '0',
    //                         'Level_1QFwdEmpId3' => '0',
    //                         'Level_1QFwdReason' => $Level_1QFwdReason,
    //                         'Level_1QFwdReason2' => '0',
    //                         'Level_1QFwdReason3' => '0',
    //                         'Level_1QFwdDT' => $Level_1QFwdDT,
    //                         'Level_1QFwdDT2' => NULL,
    //                         'Level_1QFwdDT3' => NULL,
    //                         'QueryStatus_Emp' => '0',
    //                         'QueryReply' => '',
    //                         'AssignEmpId' => $assign_emp_id,

    //                     ]);

    //             }
    //             if ($level == 'Level_3ID') {
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_1QStatus' => $request->status,
    //                         'Level_1ReplyAns' => $request->reply,
    //                         'Level_1QToDT' => now(), // Current datetime
    //                         'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_1QFwd' => $forwardto,
    //                         'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_1QFwdEmpId2' => '0',
    //                         'Level_1QFwdEmpId3' => '0',
    //                         'Level_1QFwdReason' => $Level_1QFwdReason,
    //                         'Level_1QFwdReason2' => '0',
    //                         'Level_1QFwdReason3' => '0',
    //                         'Level_1QFwdDT' => $Level_1QFwdDT,
    //                         'Level_1QFwdDT2' => NULL,
    //                         'Level_1QFwdDT3' => NULL,
    //                         'QueryStatus_Emp' => '0',
    //                         'QueryReply' => $request->reply,
    //                         'AssignEmpId' => $assign_emp_id,
    //                     ]);

    //             }

    //         }


    //         // Check if Level 1 Forward Employee ID is not "0" and Level 2 Forward Employee ID is "0"
    //         if ($query->Level_1QFwdEmpId != "0" && $query->Level_2QFwdEmpId == "0") {
    //             $Level_2QFwdEmpId = $request->assignEmpId;
    //             $Level_2QFwdReason = $request->forwardReason;
    //             $Level_2QFwdDT = now();  // Use current date and time
    //             $Level_1QFwdNoOfTime = 2;
    //             $assign_emp_id = $request->assignEmpId;
    //             if ($level == 'Level_1ID') {
    //                 // Update the query status, reply, and forward_to fields
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_1QStatus' => $request->status,
    //                         'Level_1ReplyAns' => $request->reply,
    //                         'Level_1QToDT' => now(), // Current datetime
    //                         'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_1QFwd' => $forwardto,
    //                         'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                         'Level_1QFwdEmpId3' => '0',
    //                         'Level_1QFwdReason' => $Level_1QFwdReason,
    //                         'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                         'Level_1QFwdReason3' => '0',
    //                         'Level_1QFwdDT' => $Level_1QFwdDT,
    //                         'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                         'Level_1QFwdDT3' => NULL,
    //                         'QueryStatus_Emp' => '0',
    //                         'QueryReply' => $request->reply,
    //                         'AssignEmpId' => $assign_emp_id,

    //                     ]);
    //                 if ($level == 'Level_2ID') {
    //                     \DB::table('hrm_employee_queryemp')
    //                         ->where('QueryID', $request->query_id)
    //                         ->update([
    //                             'Level_2QStatus' => $request->status,
    //                             'Level_2ReplyAns' => $request->reply,
    //                             'Level_2QToDT' => now(), // Current datetime
    //                             'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                             'Level_2QFwd' => $forwardto,
    //                             'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                             'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                             'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                             'Level_1QFwdEmpId3' => '0',
    //                             'Level_1QFwdReason' => $Level_1QFwdReason,
    //                             'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                             'Level_1QFwdReason3' => '0',
    //                             'Level_1QFwdDT' => $Level_1QFwdDT,
    //                             'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                             'Level_1QFwdDT3' => NULL,
    //                             'QueryStatus_Emp' => '0',
    //                             'QueryReply' => '',
    //                             'AssignEmpId' => $assign_emp_id,

    //                         ]);

    //                 }
    //                 if ($level == 'Level_3ID') {
    //                     \DB::table('hrm_employee_queryemp')
    //                         ->where('QueryID', $request->query_id)
    //                         ->update([
    //                             'Level_1QStatus' => $request->status,
    //                             'Level_1ReplyAns' => $request->reply,
    //                             'Level_1QToDT' => now(), // Current datetime
    //                             'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                             'Level_1QFwd' => $forwardto,
    //                             'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                             'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                             'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                             'Level_1QFwdEmpId3' => '0',
    //                             'Level_1QFwdReason' => $Level_1QFwdReason,
    //                             'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                             'Level_1QFwdReason3' => '0',
    //                             'Level_1QFwdDT' => $Level_1QFwdDT,
    //                             'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                             'Level_1QFwdDT3' => NULL,
    //                             'QueryStatus_Emp' => '0',
    //                             'QueryReply' => '',
    //                             'AssignEmpId' => $assign_emp_id,
    //                         ]);

    //                 }


    //             }


    //         }

    //         // Check if Level 1 and Level 2 Forward Employee IDs are not "0", and Level 3 Forward Employee ID is "0"
    //         if ($query->Level_1QFwdEmpId != "0" && $query->Level_2QFwdEmpId != "0" && $query->Level_3QFwdEmpId == "0") {
    //             dd('sdfsdf');
    //             $Level_3QFwdEmpId = $request->assignEmpId;
    //             $Level_3QFwdReason = $request->forwardReason;
    //             $Level_3QFwdDT = now();  // Use current date and time
    //             $Level_1QFwdNoOfTime = 3;
    //             $assign_emp_id = $request->assignEmpId;

    //             if ($level == 'Level_1ID') {
    //                 // Update the query status, reply, and forward_to fields
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_1QStatus' => $request->status,
    //                         'Level_1ReplyAns' => $request->reply,
    //                         'Level_1QToDT' => now(), // Current datetime
    //                         'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_1QFwd' => $forwardto,
    //                         'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                         'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
    //                         'Level_1QFwdReason' => $Level_1QFwdReason,
    //                         'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                         'Level_1QFwdReason3' => $Level_3QFwdReason,
    //                         'Level_1QFwdDT' => $Level_1QFwdDT,
    //                         'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                         'Level_1QFwdDT3' => $Level_3QFwdDT,
    //                         'QueryStatus_Emp' => $request->status,
    //                         'QueryReply' => $request->reply,
    //                         'AssignEmpId' => $assign_emp_id,

    //                     ]);
    //                 if ($level == 'Level_2ID') {
    //                     \DB::table('hrm_employee_queryemp')
    //                         ->where('QueryID', $request->query_id)
    //                         ->update([
    //                             'Level_2QStatus' => $request->status,
    //                             'Level_2ReplyAns' => $request->reply,
    //                             'Level_2QToDT' => now(), // Current datetime
    //                             'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                             'Level_2QFwd' => $forwardto,
    //                             'Level_2QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                             'Level_2QFwdEmpId' => $Level_1QFwdEmpId,
    //                             'Level_2QFwdEmpId2' => $Level_2QFwdEmpId,
    //                             'Level_2QFwdEmpId3' => $Level_3QFwdEmpId,
    //                             'Level_2QFwdReason' => $Level_1QFwdReason,
    //                             'Level_2QFwdReason2' => $Level_2QFwdReason,
    //                             'Level_2QFwdReason3' => $Level_3QFwdReason,
    //                             'Level_2QFwdDT' => $Level_1QFwdDT,
    //                             'Level_2QFwdDT2' => $Level_2QFwdDT,
    //                             'Level_2QFwdDT3' => $Level_3QFwdDT,
    //                             'QueryStatus_Emp' => '0',
    //                             'QueryReply' => '',
    //                             'AssignEmpId' => $assign_emp_id,

    //                         ]);

    //                 }
    //                 if ($level == 'Level_3ID') {
    //                     \DB::table('hrm_employee_queryemp')
    //                         ->where('QueryID', $request->query_id)
    //                         ->update([
    //                             'Level_1QStatus' => $request->status,
    //                             'Level_1ReplyAns' => $request->reply,
    //                             'Level_1QToDT' => now(), // Current datetime
    //                             'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                             'Level_1QFwd' => $forwardto,
    //                             'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                             'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                             'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                             'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
    //                             'Level_1QFwdReason' => $Level_1QFwdReason,
    //                             'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                             'Level_1QFwdReason3' => $Level_3QFwdReason,
    //                             'Level_1QFwdDT' => $Level_1QFwdDT,
    //                             'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                             'Level_1QFwdDT3' => $Level_3QFwdDT,
    //                             'QueryStatus_Emp' => '0',
    //                             'QueryReply' => '',
    //                             'AssignEmpId' => $assign_emp_id,
    //                         ]);

    //                 }


    //             }
    //         }

    //     }

    //     if ($forwardto == "N") {
    //         // Check if Level 1 Forward Employee ID is "0"
    //         $Level_1QFwdEmpId = 0;
    //         $Level_1QFwdReason = 0;
    //         $Level_1QFwdDT = null;  // Use current date and time
    //         $Level_1QFwdNoOfTime = 0;
    //         $assign_emp_id = $query->AssignEmpId;

    //         $Level_2QFwdEmpId = 0;
    //         $Level_2QFwdReason = 0;
    //         $Level_2QFwdDT = null;  // Use current date and time
    //         $Level_1QFwdNoOfTime = 0;
    //         $assign_emp_id = $query->AssignEmpId;



    //         $Level_3QFwdEmpId = 0;
    //         $Level_3QFwdReason = 0;
    //         $Level_3QFwdDT = null;  // Use current date and time
    //         $Level_1QFwdNoOfTime = 0;
    //         $assign_emp_id = $query->AssignEmpId;

    //         if ($level == 'Level_1ID') {
    //             // Update the query status, reply, and forward_to fields
    //             \DB::table('hrm_employee_queryemp')
    //                 ->where('QueryID', $request->query_id)
    //                 ->update([
    //                     'Level_1QStatus' => $request->status,
    //                     'Level_1ReplyAns' => $request->reply,
    //                     'Level_1QToDT' => now(), // Current datetime
    //                     'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                     'Level_1QFwd' => $forwardto,
    //                     'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                     'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                     'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                     'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
    //                     'Level_1QFwdReason' => $Level_1QFwdReason,
    //                     'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                     'Level_1QFwdReason3' => $Level_3QFwdReason,
    //                     'Level_1QFwdDT' => $Level_1QFwdDT,
    //                     'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                     'Level_1QFwdDT3' => $Level_3QFwdDT,
    //                     'QueryStatus_Emp' => '0',
    //                     'QueryReply' => '',
    //                     'AssignEmpId' => $assign_emp_id,

    //                 ]);
    //             if ($level == 'Level_2ID') {
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_2QStatus' => $request->status,
    //                         'Level_2ReplyAns' => $request->reply,
    //                         'Level_2QToDT' => now(), // Current datetime
    //                         'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_2QFwd' => $forwardto,
    //                         'Level_2QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_2QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_2QFwdEmpId2' => $Level_2QFwdEmpId,
    //                         'Level_2QFwdEmpId3' => $Level_3QFwdEmpId,
    //                         'Level_2QFwdReason' => $Level_1QFwdReason,
    //                         'Level_2QFwdReason2' => $Level_2QFwdReason,
    //                         'Level_2QFwdReason3' => $Level_3QFwdReason,
    //                         'Level_2QFwdDT' => $Level_1QFwdDT,
    //                         'Level_2QFwdDT2' => $Level_2QFwdDT,
    //                         'Level_2QFwdDT3' => $Level_3QFwdDT,
    //                         'QueryStatus_Emp' => '0',
    //                         'QueryReply' => '',
    //                         'AssignEmpId' => $assign_emp_id,

    //                     ]);

    //             }
    //             if ($level == 'Level_3ID') {
    //                 \DB::table('hrm_employee_queryemp')
    //                     ->where('QueryID', $request->query_id)
    //                     ->update([
    //                         'Level_1QStatus' => $request->status,
    //                         'Level_1ReplyAns' => $request->reply,
    //                         'Level_1QToDT' => now(), // Current datetime
    //                         'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
    //                         'Level_1QFwd' => $forwardto,
    //                         'Level_1QFwdNoOfTime' => $Level_1QFwdNoOfTime,
    //                         'Level_1QFwdEmpId' => $Level_1QFwdEmpId,
    //                         'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
    //                         'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
    //                         'Level_1QFwdReason' => $Level_1QFwdReason,
    //                         'Level_1QFwdReason2' => $Level_2QFwdReason,
    //                         'Level_1QFwdReason3' => $Level_3QFwdReason,
    //                         'Level_1QFwdDT' => $Level_1QFwdDT,
    //                         'Level_1QFwdDT2' => $Level_2QFwdDT,
    //                         'Level_1QFwdDT3' => $Level_3QFwdDT,
    //                         'QueryStatus_Emp' => '0',
    //                         'QueryReply' => '',
    //                         'AssignEmpId' => $assign_emp_id,
    //                     ]);

    //             }


    //         }

    //     }
    //     if (in_array($Level_1QFwdNoOfTime, [1, 2, 3, 4])) {
    //         return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
    //     }
    //     return response()->json(['success' => true, 'message' => 'Query action updated successfully']);
    // }
    public function updateQueryAction(Request $request)
    {
        $user_id = Auth::user()->EmployeeID;

        // Retrieve the query record
        $query = \DB::table('hrm_employee_queryemp')->where('QueryID', $request->query_id)->first();
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Query not found']);
        }
        if ($request->forwardTo == "0") {
            $forwardto = 'N';

        }
        if ($request->forwardTo != "0") {
            $forwardto = 'Y';
        }

        if (in_array($user_id, [$query->Level_1ID, $query->Level_1QFwdEmpId, $query->Level_1QFwdEmpId2, $query->Level_1QFwdEmpId3])) {
            // User is associated with Level 1
            $level = 'Level_1ID';
        } elseif (in_array($user_id, [$query->Level_2ID, $query->Level_2QFwdEmpId, $query->Level_2QFwdEmpId2, $query->Level_2QFwdEmpId3])) {
            // User is associated with Level 2
            $level = 'Level_2ID';
        } elseif (in_array($user_id, [$query->Level_3ID, $query->Level_3QFwdEmpId, $query->Level_3QFwdEmpId2, $query->Level_3QFwdEmpId3])) {
            // User is associated with Level 3
            $level = 'Level_3ID';
        } else {
            // The user is not associated with any of the levels for this query
            return response()->json(['success' => false, 'message' => 'User is not associated with this query']);
        }
        
        
        if ($forwardto == "Y") {
         
            // Check if Level 1 Forward Employee ID is "0"
            if ($query->Level_1QFwdEmpId == "0" || $query->Level_1QFwdEmpId == null || $query->Level_1QFwdEmpId == '') {
                $Level_1QFwdEmpId = $request->assignEmpId;
                $Level_1QFwdReason = $request->forwardReason;
                $Level_1QFwdDT = now();  // Use current date and time
                $Level_1QFwdNoOfTime = 1;
                $assign_emp_id = $request->assignEmpId;
                $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->deptQSubject)
                ->first();
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
                            'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                            'QuerySubject'=>$request->deptQSubject
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
                            'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                            'QuerySubject'=>$request->deptQSubject

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
                            'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                            'QuerySubject'=>$request->deptQSubject

                        ]);
                        
                }
                if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
                                    return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                                }
            }


            // Check if Level 1 Forward Employee ID is not "0" and Level 2 Forward Employee ID is "0"
            if ($query->Level_1QFwdEmpId != "0" && $query->Level_2QFwdEmpId == "0"
                    ||$query->Level_1QFwdNoOfTime == "1"||$query->Level_2QFwdNoOfTime == "1"||$query->Level_3QFwdNoOfTime == "1") {
                $Level_2QFwdEmpId = $request->assignEmpId;
                $Level_2QFwdReason = $request->forwardReason;
                $Level_2QFwdDT = now();  // Use current date and time
                $Level_1QFwdNoOfTime = 2;
                $assign_emp_id = $request->assignEmpId;
                $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->deptQSubject)
                ->first();
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
                            'Level_1QFwdEmpId2' => $Level_2QFwdEmpId,
                            'Level_1QFwdEmpId3' => '0',
                            'Level_1QFwdReason2' => $Level_2QFwdReason,
                            'Level_1QFwdReason3' => '0',
                            'Level_1QFwdDT2' => $Level_2QFwdDT,
                            'Level_1QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => $request->reply,
                            'AssignEmpId' => $assign_emp_id,
                            'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                            'QuerySubject'=>$request->deptQSubject

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
                                'Level_2QFwdEmpId3' => '0',
                                'Level_2QFwdReason' => $Level_1QFwdReason,
                                'Level_2QFwdReason2' => $Level_2QFwdReason,
                                'Level_2QFwdReason3' => '0',
                                'Level_2QFwdDT' => $Level_1QFwdDT,
                                'Level_2QFwdDT2' => $Level_2QFwdDT,
                                'Level_2QFwdDT3' => NULL,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,
                                'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                                'QuerySubject'=>$request->deptQSubject

                            ]);
                            

                    }
                    if ($level == 'Level_3ID') {
                        \DB::table('hrm_employee_queryemp')
                            ->where('QueryID', $request->query_id)
                            ->update([
                                'Level_3QStatus' => $request->status,
                                'Level_3ReplyAns' => $request->reply,
                                'Level_3QToDT' => now(), // Current datetime
                                'Level_3DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                                'Level_3QFwd' => $forwardto,
                                'Level_3QFwdNoOfTime' => $Level_1QFwdNoOfTime,
                                'Level_3QFwdEmpId' => $Level_1QFwdEmpId,
                                'Level_3QFwdEmpId2' => $Level_2QFwdEmpId,
                                'Level_3QFwdEmpId3' => '0',
                                'Level_3QFwdReason' => $Level_1QFwdReason,
                                'Level_3QFwdReason2' => $Level_2QFwdReason,
                                'Level_3QFwdReason3' => '0',
                                'Level_3QFwdDT' => $Level_1QFwdDT,
                                'Level_3QFwdDT2' => $Level_2QFwdDT,
                                'Level_3QFwdDT3' => NULL,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,
                                'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                                'QuerySubject'=>$request->deptQSubject
                            ]);
                            

                    }


                }

                if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
                                    return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                                }
            
            }

            // Check if Level 1 and Level 2 Forward Employee IDs are not "0", and Level 3 Forward Employee ID is "0"
            // if ($query->Level_1QFwdEmpId != "0" && $query->Level_2QFwdEmpId != "0" && $query->Level_3QFwdEmpId == "0"
            //         ||$query->Level_1QFwdEmpId2 !=''||$query->Level_2QFwdEmpId2 !=''||$query->Level_3QFwdEmpId2 !=''||
            //         $query->Level_1QFwdNoOfTime == "2"||$query->Level_2QFwdNoOfTime == "2"||$query->Level_3QFwdNoOfTime == "2") {
                
            if($query->Level_1QFwdNoOfTime == "2"||$query->Level_2QFwdNoOfTime == "2"||$query->Level_3QFwdNoOfTime == "2"){
                $Level_3QFwdEmpId = $request->assignEmpId;
                $Level_3QFwdReason = $request->forwardReason;
                $Level_3QFwdDT = now();  // Use current date and time
                $Level_1QFwdNoOfTime = 3;
                $assign_emp_id = $request->assignEmpId;
                $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->deptQSubject)
                ->first();
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
                            'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
                            'Level_1QFwdReason3' => $Level_3QFwdReason,
                            'Level_1QFwdDT3' => $Level_3QFwdDT,
                            'QueryStatus_Emp' => $request->status,
                            'QueryReply' => $request->reply,
                            'AssignEmpId' => $assign_emp_id,
                            'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                            'QuerySubject'=>$request->deptQSubject


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
                                'Level_2QFwdEmpId3' => $Level_3QFwdEmpId,
                                'Level_2QFwdReason3' => $Level_3QFwdReason,
                                'Level_2QFwdDT3' => $Level_3QFwdDT,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,
                                'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                                'QuerySubject'=>$request->deptQSubject


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
                                'Level_1QFwdEmpId3' => $Level_3QFwdEmpId,
                                'Level_1QFwdReason3' => $Level_3QFwdReason,
                                'Level_1QFwdDT3' => $Level_3QFwdDT,
                                'QueryStatus_Emp' => '0',
                                'QueryReply' =>'',
                                'AssignEmpId' => $assign_emp_id,
                                'QSubjectId'=>$departmentQuerySub->DeptQSubId,
                                'QuerySubject'=>$request->deptQSubject
                            ]);
                            

                    }


                }
                 if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
                    return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                }
            }

        }

        if ($forwardto == "N") {
            // Check if Level 1 Forward Employee ID is "0"
            // $Level_1QFwdEmpId = 0;
            // $Level_1QFwdReason = 0;
            // $Level_1QFwdDT = null;  // Use current date and time
            // $Level_1QFwdNoOfTime = 0;
            $assign_emp_id = $query->AssignEmpId;

            // $Level_2QFwdEmpId = 0;
            // $Level_2QFwdReason = 0;
            // $Level_2QFwdDT = null;  // Use current date and time
            // $Level_1QFwdNoOfTime = 0;
            $assign_emp_id = $query->AssignEmpId;



            // $Level_3QFwdEmpId = 0;
            // $Level_3QFwdReason = 0;
            // $Level_3QFwdDT = null;  // Use current date and time
            // $Level_1QFwdNoOfTime = 0;
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
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                        ]);

                }
               
                }
               
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
        } else {
            return response()->json(['error' => 'Query not found'], 404);
        }
    }

    public function submitAction(Request $request)
{
    // Check if the query exists
    $query = QueryMapEmp::where('QueryId', $request->query_id)->first();

    if (!$query) {
        return response()->json(['success' => false, 'message' => 'Query not found']);
    }

    // Prepare the data for updating
    $data = [
        'QueryStatus_Emp' => $request->status,
        'EmpQRating' => $request->rating,
        'QueryReply' => $request->remark,
        'QStatus' => $request->status,
    ];

    // Initialize the levelUpdate array
    $levelUpdate = [];

    // Check Level 1
    if ($query->AssignEmpId == $query->Level_1ID || $query->Level_1QFwdEmpId == $query->Level_1ID || $query->Level_1QFwdEmpId2 == $query->Level_1ID || $query->Level_1QFwdEmpId3 == $query->Level_1ID) {
        $levelUpdate['Level_1QStatus'] = $request->status;
        // Update Level 1 status and return immediately to avoid further checks
        $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
            ->update(array_merge($data, $levelUpdate));
        if ($affectedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }
    }

    // Check Level 2 (only if Level 1 was not updated)
    if ($query->AssignEmpId == $query->Level_2ID || $query->Level_2QFwdEmpId == $query->Level_2ID || $query->Level_2QFwdEmpId2 == $query->Level_2ID || $query->Level_2QFwdEmpId3 == $query->Level_2ID) {
        $levelUpdate['Level_2QStatus'] = $request->status;
        // Update Level 2 status and return immediately to avoid further checks
        $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
            ->update(array_merge($data, $levelUpdate));
        if ($affectedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }
    }

    // Check Level 3 (only if Level 1 and Level 2 were not updated)
    if ($query->AssignEmpId == $query->Level_3ID || $query->Level_3QFwdEmpId == $query->Level_3ID || $query->Level_3QFwdEmpId2 == $query->Level_3ID || $query->Level_3QFwdEmpId3 == $query->Level_3ID) {
        $levelUpdate['Level_3QStatus'] = $request->status;
        // Update Level 3 status and return immediately
        $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
            ->update(array_merge($data, $levelUpdate));
        if ($affectedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }
    }

    // If no levels matched for update
    return response()->json(['success' => false, 'message' => 'No update made']);
}

    
    public function softDeleteQuery($queryId)
            {
            // Find the leave request by ApplyLeaveId
            $QueryId = QueryMapEmp::where('QueryId', $queryId)->first();

            // Check if the leave request exists
            if (!$QueryId) {
                return response()->json(['message' => 'Query request not found.'], 404);
            }
            // Soft delete the leave request
            $QueryId->delete();

            // Return a success response
            return response()->json(['message' => 'Query deleted successfully.']);
            }
}


