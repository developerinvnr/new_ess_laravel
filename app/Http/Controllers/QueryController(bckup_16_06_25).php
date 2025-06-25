<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\DepartmentSubject;
use App\Models\Department;
use App\Models\EmployeeReporting;
use App\Models\QueryMapEmp;
use App\Models\HrmYear;
use App\Mail\Query\QuerytoEmp;
use App\Mail\Query\QuerytoRep;
use App\Mail\Query\QuerytoHr;
use App\Mail\Query\QuerytoEmpReply;
use App\Mail\Query\Querytoforwarded;
use App\Mail\Query\Querytoqueryowner;
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

        $queries_frwrd = QueryMapEmp::where(function ($query) use ($employeeID) {
            // Level 1 Forwarding check
            $query->where('Level_1QFwd', 'Y')
                ->where(function ($subQuery) use ($employeeID) {
                    // Exclude records where AssignEmpId matches any of the forwarding employee IDs
                    $subQuery->where('AssignEmpId', '=', $employeeID)  // Exclude if assigned to the same employee
                        ->where(function ($subSubQuery) use ($employeeID) {
                            $subSubQuery->where('Level_1QFwdEmpId', '=', $employeeID)
                                ->orWhere('Level_1QFwdEmpId2', '=', $employeeID)
                                ->orWhere('Level_1QFwdEmpId3', '=', $employeeID);
                        });
                });
        })
            ->orWhere(function ($query) use ($employeeID) {
                // Level 2 Forwarding check
                $query->where('Level_2QFwd', 'Y')
                    ->where(function ($subQuery) use ($employeeID) {
                        // Exclude records where AssignEmpId matches any of the forwarding employee IDs
                        $subQuery->where('AssignEmpId', '=', $employeeID)  // Exclude if assigned to the same employee
                            ->where(function ($subSubQuery) use ($employeeID) {
                                $subSubQuery->where('Level_2QFwdEmpId', '=', $employeeID)
                                    ->orWhere('Level_2QFwdEmpId2', '=', $employeeID)
                                    ->orWhere('Level_2QFwdEmpId3', '=', $employeeID);
                            });
                    });
            })
            ->orWhere(function ($query) use ($employeeID) {
                // Level 3 Forwarding check
                $query->where('Level_3QFwd', 'Y')
                    ->where(function ($subQuery) use ($employeeID) {
                        // Exclude records where AssignEmpId matches any of the forwarding employee IDs
                        $subQuery->where('AssignEmpId', '=', $employeeID)  // Exclude if assigned to the same employee
                            ->where(function ($subSubQuery) use ($employeeID): void {
                                $subSubQuery->where('Level_3QFwdEmpId', '=', $employeeID)
                                    ->orWhere('Level_3QFwdEmpId2', '=', $employeeID)
                                    ->orWhere('Level_3QFwdEmpId3', '=', $employeeID);
                            });
                    });
            })
            ->orderBy('QueryDT', 'desc')  // Sort by QueryDT descending
            ->get();  // Fetch the result
        foreach ($queries_frwrd as $query) {
            $forwardFields = [
                'Level_1QFwdEmpId',
                'Level_1QFwdEmpId2',
                'Level_1QFwdEmpId3',
                'Level_2QFwdEmpId',
                'Level_2QFwdEmpId2',
                'Level_2QFwdEmpId3',
                'Level_3QFwdEmpId',
                'Level_3QFwdEmpId2',
                'Level_3QFwdEmpId3',
            ];

            $allForwardIds = collect($forwardFields)->map(fn($f) => $query->$f)->filter()->unique();

            $forwardedEmpMap = \DB::table('hrm_employee as e')
                ->leftJoin('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                ->leftJoin('core_departments as d', 'g.DepartmentId', '=', 'd.id')
                ->whereIn('e.EmployeeID', $allForwardIds)
                ->select(
                    'e.EmployeeID',
                    'e.Fname',
                    'e.Sname',
                    'e.Lname',
                    'd.department_name'
                )
                ->get()
                ->mapWithKeys(function ($emp) {
                    $fullName = trim("{$emp->Fname} {$emp->Sname} {$emp->Lname}");
                    $dept = $emp->department_name ?: 'N/A';
                    return [$emp->EmployeeID => $fullName . ' (' . $dept . ')'];
                });

            foreach ($forwardFields as $field) {
                $empId = $query->$field;
                $query->{$field . '_name'} = $empId && isset($forwardedEmpMap[$empId]) ? $forwardedEmpMap[$empId] : null;
            }
        }
        $employeeIDs = $queries_frwrd->pluck('EmployeeID')
            ->unique();
        // Step 3: Fetch employee details (Fname, Sname, Lname) from hrm_employee table for these EmployeeIDs
        $employees = Employee::whereIn('EmployeeID', $employeeIDs)
            ->get(['EmployeeID', 'Fname', 'Sname', 'Lname', 'EmpCode']); // Adjust the model name as needed

        // Step 4: Map employees to easily access their names by EmployeeID
        $employeeNames = $employees->keyBy('EmployeeID');

        $query_department_list = \DB::table('hrm_deptquerysub')->leftJoin('core_departments', 'core_departments.id', '=', 'hrm_deptquerysub.DepartmentId')->select(['core_departments.id', 'core_departments.department_name'])->groupBy('core_departments.id')->get();

        $departments_sub = \DB::table('hrm_deptquerysub')->get();

        $separationRecord = \DB::table('hrm_employee_separation')
            ->where('EmployeeID', Auth::user()->EmployeeID)
            ->where(function ($query) {
                $query->where('Hod_Approved', '!=', 'C')
                    ->where('Rep_Approved', '!=', 'C')
                    ->where('HR_Approved', '!=', 'C');
            })
            ->first();
        $employee = Employee::findOrFail(Auth::user()->EmployeeID);  // Find employee by ID

        // Paginate the related queryMap entries (10 results per page)
        $queryList = $employee->queryMap()->paginate(5); // Use pagination here
        if ($separationRecord) {
            return view("seperation.query", compact('queryList', 'queries_frwrd', 'employeeNames', 'query_department_list', 'departments_sub'));
        }
        return view("employee.query", compact('queryList', 'queries_frwrd', 'employeeNames', 'query_department_list', 'departments_sub'));
    }

    public function querysubmit(Request $request)
    {

        // Check if the department is null or empty
        if (is_null($request->Department_name) || empty($request->Department_name)) {
            //    return response()->json(['error' => 'Please select department'], 200);
            return response()->json(['success' => false, 'message' => 'Please select department']);
        }

        // Check if the department subject is null or empty
        if (is_null($request->Department_name_sub) || empty($request->Department_name_sub)) {
            return response()->json(['success' => false, 'message' => 'Please select subject']);
        }


        // Check if the remark is null or empty (after trimming any extra spaces)
        if (is_null($request->remarks) || empty(trim($request->remarks))) {
            return response()->json(['success' => false, 'message' => 'Remark is mandatory']);
        }

        $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $request->Department_name_sub)
            ->where('DepartmentId', $request->Department_name)
            ->first();

        $department = Department::where('id', $request->Department_name)
            ->first();


        if (!$departmentQuerySub) {
            return response()->json(['error' => 'Invalid subject or department'], 404);
        }

        // Fetch the employee reporting details
        $employeeReporting = EmployeeReporting::where('EmployeeID', $request->employee_id)->first();

        if (!$employeeReporting) {
            // return response()->json(['error' => 'Employee reporting details not found'], 200);
            return response()->json(['success' => false, 'message' => 'Employee reporting details not found']);
        }
        $assignidreporting = EmployeeReporting::where('EmployeeID', $departmentQuerySub->AssignEmpId)->first();
        $level_2id  = $assignidreporting->AppraiserId;
        $level_3id  = $assignidreporting->ReviewerId;
        $mgnid  = $assignidreporting->HodId;


        $currentDate = Carbon::now();

        // Add 3 days and adjust if it falls on Sunday
        $dateAfter3Days = $currentDate->copy()->addDays(3);
        if ($dateAfter3Days->isSunday()) {
            $dateAfter3Days->addDay(); // Add an extra day if it's Sunday
        }

        // Add 6 days and adjust if it falls on Sunday
        $dateAfter6Days = $currentDate->copy()->addDays(6);
        if ($dateAfter6Days->isSunday()) {
            $dateAfter6Days->addDay(); // Add an extra day if it's Sunday
        }

        // Add 9 days and adjust if it falls on Sunday
        $dateAfter12Days = $currentDate->copy()->addDays(9);
        if ($dateAfter12Days->isSunday()) {
            $dateAfter12Days->addDay(); // Add an extra day if it's Sunday
        }


        // Fetch the employee's email from EmployeeGeneral
        // $employeeGeneral = EmployeeGeneral::where('EmployeeID', $employeeReporting->ReportingId)->first();

        // if (!$employeeGeneral) {
        //     return response()->json(['error' => 'Employee email not found'], 404);
        // }

        if (\Carbon\Carbon::now()->month >= 4) {
            // If the current month is April or later, the financial year starts from the current year
            $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 4, 1)->toDateString();
            $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year + 1, 3, 31)->toDateString();
        } else {
            // If the current month is before April, the financial year started the previous year
            $financialYearStart = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year - 1, 4, 1)->toDateString();
            $financialYearEnd = \Carbon\Carbon::createFromDate(\Carbon\Carbon::now()->year, 3, 31)->toDateString();
        }

        // Fetch the current financial year record
        $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
            ->whereDate('ToDate', '=', $financialYearEnd)
            ->first();
        $year_id_current = $currentYearRecord->YearId;
        $querynooftime = 1;
        $MailTo_Emp = 1;
        $MailTo_QueryOwner = 1;

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
            'QueryNoOfTime' => $querynooftime,
            'AssignEmpId' => $departmentQuerySub->AssignEmpId,
            'Level_1ID' => $departmentQuerySub->AssignEmpId,
            'Level_2ID' => $level_2id,
            'Level_3ID' => $level_3id,
            'Mngmt_ID' => $mgnid,
            'Level_1QToDT' => Carbon::now(),
            'Level_2QToDT' => $dateAfter3Days,
            'Level_3QToDT' => $dateAfter6Days,
            'Mngmt_QToDT' => $dateAfter12Days,
            'MailTo_Emp' => $MailTo_Emp,
            'MailTo_QueryOwner' => $MailTo_QueryOwner,
            'QueryYearId' => $year_id_current,

        ];
        // Insert the data into hrm_employee_queryemp
        // QueryMapEmp::create($queryData);
        \DB::table('hrm_employee_queryemp')->insert($queryData);
        try {
            // Other existing logic to retrieve employee data and prepare for insertion
            $employeegeneral = EmployeeGeneral::where('EmployeeID', $request->employee_id)->first();
            $employeegeneralqueryowner = EmployeeGeneral::where('EmployeeID', $departmentQuerySub->AssignEmpId)->first();

            $employeedetails = Employee::where('EmployeeID', $request->employee_id)->first();

            $employeeEmailId = $employeegeneral->EmailId_Vnr;
            $ReportingEmailId = $employeegeneral->ReportingEmailId;
            $queryDataOwnerEmailid = $employeegeneralqueryowner->EmailId_Vnr;


            $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
            $details = [
                'subject' => 'Query Request',
                'EmpName' => $Empname,
                'DepartmentName' => $department->department_name,
                'Subject' => $request->Department_name_sub,
                'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
            ];

            Mail::to($employeeEmailId)->send(new QuerytoEmp($details));
            Mail::to($ReportingEmailId)->send(new  QuerytoRep($details));
            Mail::to($queryDataOwnerEmailid)->send(new  Querytoqueryowner($details));
            Mail::to('vspl.hr@vnrseeds.com')->send(new QuerytoHr($details));


            // return response()->json(['success' => 'Query submitted successfully!']);
            return response()->json(['success' => true, 'message' => 'Query submitted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }
        // return response()->json(['success' => 'Query submitted successfully!']);
    }

    // public function getQueriesForUser()
    // {
    //     $user = Auth::user(); // Get the logged-in user
    //     $userId = Auth::user()->EmployeeID; // Get the logged-in user

    //     $now = Carbon::now(); // Current date and time

    //     $queries = \DB::table('hrm_employee_queryemp')
    //     ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId')
    //     ->join('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id')
    //     ->select(
    //         'hrm_employee_queryemp.*',
    //         'core_departments.department_name'
    //     )
    //     ->where(function ($query) use ($userId, $now) {
    //         // Level 1 Queries: Assigned to Level_1ID and within the timeframe
    //         $query->where(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Level_1ID', $userId)
    //                      ->where('Level_1QStatus', '!=', 4) // Not escalated
    //                      ->where(function ($innerQuery) {
    //                          // Ensure no forwarding IDs are set (null or 0 for each forwarding field)
    //                          $innerQuery->whereNull('Level_1QFwdEmpId')
    //                                     ->orWhere('Level_1QFwdEmpId', 0)
    //                                     ->whereNull('Level_1QFwdEmpId2')
    //                                     ->orWhere('Level_1QFwdEmpId2', 0)
    //                                     ->whereNull('Level_1QFwdEmpId3')
    //                                     ->orWhere('Level_1QFwdEmpId3', 0);
    //                      });
    //                     //  ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframe
    //         })
    //         // Level 1 Forwarding: If forwarded, ignore the Level 1 ID and check forwarding IDs
    //         ->orWhere(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Level_1QFwdEmpId3', $userId) // Priority: Level 1 forward ID 3
    //                      ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframe
    //         })
    //         ->orWhere(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Level_1QFwdEmpId2', $userId) // Priority: Level 1 forward ID 2
    //                      ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframe
    //         })
    //         ->orWhere(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Level_1QFwdEmpId', $userId) // Default: Level 1 forward ID 1
    //                     // ->where('Level_1QStatus', '=', 4) // Not escalated
    //                      ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframe
    //         })
    //         // Level 2 Queries: Assigned to Level_2ID and within the timeframe
    //         ->orWhere(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Level_2ID', $userId)
    //                         // ->where('Level_1QStatus', '=', 4) // Not escalated
    //                         // ->where('Level_1QFwdEmpId3', '=', 0) // Not escalated
    //                         // ->where('Level_1QFwdEmpId', '=', 0) // Not escalated
    //                         // ->where('Level_1QFwdEmpId2', '=', 0) // Not escalated
    //                         ->whereDate('Level_2QToDT', '<=', $now->toDateString()) // Level 2 date is today or earlier
    //                         ->whereRaw('DATE(Level_2QToDT) < DATE_SUB(Level_3QToDT, INTERVAL 1 DAY)'); // Compare Level_2QToDT with (Level_3QToDT - 1 day)
    //                     })
    //         // Level 3 Queries: Assigned to Level_3ID and within the timeframe
    //         ->orWhere(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Level_3ID', $userId)
    //                     // ->where('Level_2QStatus', '=', 4) // Not escalated
    //                     // ->where('Level_2QFwdEmpId3', '=', 0) // Not escalated
    //                     // ->where('Level_2QFwdEmpId', '=', 0) // Not escalated
    //                     // ->where('Level_2QFwdEmpId2', '=', 0) // Not escalated
    //                     ->whereDate('Level_3QToDT', '<=', $now->toDateString()) // Level 2 date is today or earlier
    //                     ->whereRaw('DATE(Level_3QToDT) < DATE_SUB(Mngmt_QToDT, INTERVAL 1 DAY)'); // Compare Level_2QToDT with (Level_3QToDT - 1 day)

    //         })
    //         ->orWhere(function ($subQuery) use ($userId, $now) {
    //             $subQuery->where('Mngmt_ID', $userId)
    //                      ->whereDate('Mngmt_QToDT', '=', $now->toDateString()); // Only fetch data when Mngmt_QToDT matches today's date
    //         })
    //     })


    //     ->orderBy('hrm_employee_queryemp.QueryDT', 'desc')
    //     ->get();


    //     //wokring code
    //     // $queries = \DB::table('hrm_employee_queryemp')
    //     // ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId') // Join with hrm_employee to fetch employee details
    //     // ->join('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id') // Join with core_departments to fetch department detail
    //     // ->select(
    //     //     'hrm_employee_queryemp.*',
    //     //     'core_departments.department_name'
    //     // )
    //     // ->where(function ($query) use ($user) {
    //     //     $query->where(function ($subQuery) use ($user) {
    //     //         // Level 1: Show data from QueryToDT until QueryToDT + 3 days
    //     //         $subQuery->where('hrm_employee_queryemp.Level_1ID', $user->EmployeeID)
    //     //             ->where('hrm_employee_queryemp.QueryDT', '<=', now())
    //     //             ->where('hrm_employee_queryemp.QueryDT', '>=', now()->subDays(3));
    //     //     })
    //     //     ->orWhere(function ($subQuery) use ($user) {
    //     //         // Level 2: Show data from QueryDT + 3 days until QueryDT + 6 days
    //     //         $subQuery->where('hrm_employee_queryemp.Level_2ID', $user->EmployeeID)
    //     //             ->where('hrm_employee_queryemp.QueryDT', '<=', now()->subDays(3))
    //     //             ->where('hrm_employee_queryemp.QueryDT', '>=', now()->subDays(6));
    //     //     })
    //     //     ->orWhere(function ($subQuery) use ($user) {
    //     //         // Level 3: Show data from QueryDT + 6 days until QueryDT + 9 days
    //     //         $subQuery->where('hrm_employee_queryemp.Level_3ID', $user->EmployeeID)
    //     //             ->where('hrm_employee_queryemp.QueryDT', '<=', now()->subDays(6))
    //     //             ->where('hrm_employee_queryemp.QueryDT', '>=', now()->subDays(9));
    //     //     })
    //     //     ->orWhere(function ($subQuery) use ($user) {
    //     //         // Management: Show data from QueryDT + 9 days onwards
    //     //         $subQuery->where('hrm_employee_queryemp.Mngmt_ID', $user->EmployeeID)
    //     //             ->where('hrm_employee_queryemp.QueryDT', '<=', now()->subDays(9));
    //     //     });
    //     // })
    //     // ->whereNull('deleted_at')
    //     // ->orderBy('hrm_employee_queryemp.created_at', 'desc') // Order by CreatedAt column in descending order
    //     // ->get();



    //     if($queries){
    //         foreach($queries as $query){
    //             $queryid=$query->EmployeeID;

    //             $employeeDetails = \DB::table('hrm_employee')
    //             ->where('EmployeeID', $queryid)  // Match the EmployeeID from the query
    //             ->select('Fname', 'Sname', 'Lname','EmpCode')  // Fetch the first, second, and last name
    //             ->first(); // Use first() to get a single result

    //         // Now you have the employee details for this query's EmployeeID
    //         if ($employeeDetails) {
    //             // Add the details to your query
    //             $query->Fname = $employeeDetails->Fname;
    //             $query->Sname = $employeeDetails->Sname;
    //             $query->Lname = $employeeDetails->Lname;
    //             $query->EmpCode = $employeeDetails->EmpCode;

    //         }

    //         }
    //     }


    //     return response()->json($queries); // Return data as JSON
    // }
    public function getQueriesForUser()
    {
        // $status = $request->input('status'); // Get the selected status filter

        $user = Auth::user(); // Get the logged-in user
        $userId = Auth::user()->EmployeeID; // Get the logged-in user
        $now = Carbon::now(); // Current date and time
        $queries = \DB::table('hrm_employee_queryemp')
            ->join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_queryemp.AssignEmpId')
            ->join('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id')
            ->select(
                'hrm_employee_queryemp.*',
                'core_departments.department_name'
            )
            ->where(function ($query) use ($userId, $now) {
                // Level 1 Queries: Assigned to Level_1ID and within the timeframe
                $query->where(function ($subQuery) use ($userId, $now) {
                    $subQuery->where('Level_1ID', $userId)
                        ->where('Level_1QStatus', '!=', 4) // Not escalated
                        ->where(function ($innerQuery) {
                            // Ensure no forwarding IDs are set (null or 0 for each forwarding field)
                            $innerQuery->whereNull('Level_1QFwdEmpId')
                                ->orWhere('Level_1QFwdEmpId', 0)
                                ->whereNull('Level_1QFwdEmpId2')
                                ->orWhere('Level_1QFwdEmpId2', 0)
                                ->whereNull('Level_1QFwdEmpId3')
                                ->orWhere('Level_1QFwdEmpId3', 0);
                        });
                })
                    // Level 1 Forwarding: If forwarded, ignore the Level 1 ID and check forwarding IDs
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_1QFwdEmpId3', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframe
                    })
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_1QFwdEmpId2', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframeithin Level 1 timeframe
                    })
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_1QFwdEmpId', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Level_2QToDT', '>', $now); // Within Level 1 timeframeithin Level 1 timeframe
                    })
                    // Level 2 Queries: Assigned to Level_2ID and within the timeframe
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_2ID', $userId)
                            ->whereDate('Level_2QToDT', '<=', $now->toDateString()) // Level 2 date is today or earlier
                            ->whereRaw('DATE(Level_2QToDT) < DATE_SUB(Level_3QToDT, INTERVAL 1 DAY)'); // Compare Level_2QToDT with (Level_3QToDT - 1 day)
                    })
                    // Level 1 Forwarding: If forwarded, ignore the Level 1 ID and check forwarding IDs
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_2QFwdEmpId3', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Level_3QToDT', '>', $now); // Within Level 1 timeframe
                    })
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_2QFwdEmpId2', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Level_3QToDT', '>', $now); // Within Level 1 timeframeithin Level 1 timeframe
                    })
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_2QFwdEmpId', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Level_3QToDT', '>', $now); // Within Level 1 timeframeithin Level 1 timeframe
                    })
                    // Level 3 Queries: Assigned to Level_3ID and within the timeframe
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_3ID', $userId)
                            ->whereDate('Level_3QToDT', '<=', $now->toDateString()) // Level 3 date is today or earlier
                            ->whereRaw('DATE(Level_3QToDT) < DATE_SUB(Mngmt_QToDT, INTERVAL 1 DAY)'); // Compare Level_3QToDT with (Mngmt_QToDT - 1 day)
                    })
                    // Level 1 Forwarding: If forwarded, ignore the Level 1 ID and check forwarding IDs
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_3QFwdEmpId3', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Mngmt_QToDT', '>', $now); // Within Level 1 timeframe
                    })
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_3QFwdEmpId2', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Mngmt_QToDT', '>', $now); // Within Level 1 timeframeithin Level 1 timeframe
                    })
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Level_3QFwdEmpId', '=', \DB::raw('AssignEmpId'))
                            ->where('AssignEmpId', '=', $userId) // Priority: Level 1 forward ID 3
                            ->where('Mngmt_QToDT', '>', $now); // Within Level 1 timeframeithin Level 1 timeframe
                    })
                    // Management Queries: Assigned to Mngmt_ID and within the timeframe
                    ->orWhere(function ($subQuery) use ($userId, $now) {
                        $subQuery->where('Mngmt_ID', $userId)
                            ->where(function ($innerSubQuery) use ($now) {
                                // Ensure strict comparison where Mngmt_QToDT is today or in the future, and exclude future dates
                                $innerSubQuery->whereDate('Mngmt_QToDT', '=', $now->toDateString())  // Match exactly today
                                    ->WhereRaw('DATE(Mngmt_QToDT) >= ?', [$now->toDateString()]);  // Fetch only from today onward
                            });
                    });
            })
            ->orderBy('hrm_employee_queryemp.QueryDT', 'desc')
            ->get();

        if ($queries) {
            foreach ($queries as $query) {
                $queryid = $query->EmployeeID;
                $employeeDetails = \DB::table('hrm_employee')
                    ->where('EmployeeID', $queryid)  // Match the EmployeeID from the query
                    ->select('Fname', 'Sname', 'Lname', 'EmpCode')  // Fetch the first, second, and last name
                    ->first(); // Use first() to get a single result

                // Now you have the employee details for this query's EmployeeID
                if ($employeeDetails) {
                    // Add the details to your query
                    $query->Fname = $employeeDetails->Fname;
                    $query->Sname = $employeeDetails->Sname;
                    $query->Lname = $employeeDetails->Lname;
                    $query->EmpCode = $employeeDetails->EmpCode;
                }
                $forwardFields = [
                    'Level_1QFwdEmpId',
                    'Level_1QFwdEmpId2',
                    'Level_1QFwdEmpId3',
                    'Level_2QFwdEmpId',
                    'Level_2QFwdEmpId2',
                    'Level_2QFwdEmpId3',
                    'Level_3QFwdEmpId',
                    'Level_3QFwdEmpId2',
                    'Level_3QFwdEmpId3',
                ];

                // Build a map of EmployeeID => full name for all forward IDs
                $allForwardIds = collect($forwardFields)->map(fn($f) => $query->$f)->filter()->unique();

                $forwardedEmpMap = \DB::table('hrm_employee as e')
                    ->leftJoin('hrm_employee_general as g', 'e.EmployeeID', '=', 'g.EmployeeID')
                    ->leftJoin('core_departments as d', 'g.DepartmentId', '=', 'd.id')
                    ->whereIn('e.EmployeeID', $allForwardIds)
                    ->select(
                        'e.EmployeeID',
                        'e.Fname',
                        'e.Sname',
                        'e.Lname',
                        'd.department_name'
                    )
                    ->get()
                    ->mapWithKeys(function ($emp) {
                        $fullName = trim("{$emp->Fname} {$emp->Sname} {$emp->Lname}");
                        $dept = $emp->department_name ?: 'N/A';
                        return [$emp->EmployeeID => $fullName . ' (' . $dept . ')'];
                    });


                // Now attach each forward name back to the query object in order
                foreach ($forwardFields as $field) {
                    $empId = $query->$field;
                    $query->{$field . '_name'} = $empId && isset($forwardedEmpMap[$empId]) ? $forwardedEmpMap[$empId] : null;
                }
            }
        }

        return response()->json($queries); // Return data as JSON
    }


    public function getDeptQuerySubForDepartment(Request $request)
    {
        $query_id = $request->queryid;
        $employeegeneral = EmployeeGeneral::find(Auth::user()->EmployeeID);
        // Get the DepartmentID of the authenticated user
        $departmentId = $employeegeneral->DepartmentId;

        // Fetch all EmployeeIDs with the same DepartmentID from EmployeeGeneral table
        $employeeIds = EmployeeGeneral::where('DepartmentId', $departmentId)
            ->where('EmployeeID', '!=', Auth::user()->EmployeeID) // Exclude the current user
            ->pluck('EmployeeID');

        // Fetch FirstName, LastName, and Surname for those EmployeeIDs from Employee table
        $employees = Employee::whereIn('EmployeeID', $employeeIds)
            ->where('EmpStatus', 'A')
            ->get(['EmployeeID', 'fname', 'sname', 'lname']);


        // Fetch DeptQSubject and AssignEmpId from hrm_deptquerysub based on the QToDepartmentId from hrm_employee_queryemp
        $deptQuerySub = \DB::table('hrm_employee_queryemp')
            ->join('hrm_deptquerysub', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_deptquerysub.DepartmentId') // Join with hrm_deptquerysub
            ->where('hrm_employee_queryemp.QueryID', $query_id) // Filter based on query ID
            ->select('hrm_deptquerysub.DeptQSubject', 'hrm_deptquerysub.AssignEmpId') // Select only the relevant fields
            ->get();
        return response()->json($employees);
    }

    public function updateQueryAction(Request $request)
    {
        $user_id = Auth::user()->EmployeeID;

        // Retrieve the query record
        $query = \DB::table('hrm_employee_queryemp')->where('QueryID', $request->query_id)->first();

        $department = Department::where('id', $query->QToDepartmentId)
            ->first();
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Query not found']);
        }
        if ($request->forwardTo == "0") {
            $forwardto = 'N';
        }
        if ($request->forwardTo != "0") {
            $forwardto = 'Y';
        }

        // Check if the user is associated with Level 3 (highest priority)
        if (in_array($user_id, [$query->Mngmt_ID, $query->Mngmt_QFwdEmpId, $query->Mngmt_QFwdEmpId2, $query->Mngmt_QFwdEmpId3])) {
            // If the user is associated with Level 3 (either directly or forwarded)
            if ($user_id == $query->Mngmt_ID) {
                // Directly assigned to Level 3
                $level = 'Mngmt_ID';
            } else {
                // Forwarded within Level 3
                if ($user_id == $query->Mngmt_QFwdEmpId) {
                    $level = 'Mngmt_ID'; // First forwarding in Level 3
                } elseif ($user_id == $query->Mngmt_QFwdEmpId2) {
                    $level = 'Mngmt_ID'; // Second forwarding in Level 3
                } elseif ($user_id == $query->Mngmt_QFwdEmpId3) {
                    $level = 'Mngmt_ID'; // Third forwarding in Level 3
                }
            }
        }

        // Check if the user is associated with Level 3 (highest priority)
        if (in_array($user_id, [$query->Level_3ID, $query->Level_3QFwdEmpId, $query->Level_3QFwdEmpId2, $query->Level_3QFwdEmpId3])) {
            // If the user is associated with Level 3 (either directly or forwarded)
            if ($user_id == $query->Level_3ID) {
                // Directly assigned to Level 3
                $level = 'Level_3ID';
            } else {
                // Forwarded within Level 3
                if ($user_id == $query->Level_3QFwdEmpId) {
                    $level = 'Level_3ID'; // First forwarding in Level 3
                } elseif ($user_id == $query->Level_3QFwdEmpId2) {
                    $level = 'Level_3ID'; // Second forwarding in Level 3
                } elseif ($user_id == $query->Level_3QFwdEmpId3) {
                    $level = 'Level_3ID'; // Third forwarding in Level 3
                }
            }
        }

        // If the user is not in Level 3, check for Level 2
        if (in_array($user_id, [$query->Level_2ID, $query->Level_2QFwdEmpId, $query->Level_2QFwdEmpId2, $query->Level_2QFwdEmpId3])) {

            if ($user_id == $query->Level_2ID) {
                // Directly assigned to Level 2
                $level = 'Level_2ID';
            } else {
                // Forwarded within Level 2
                if ($user_id == $query->Level_2QFwdEmpId) {
                    $level = 'Level_2ID'; // First forwarding in Level 2
                } elseif ($user_id == $query->Level_2QFwdEmpId2) {
                    $level = 'Level_2ID'; // Second forwarding in Level 2
                } elseif ($user_id == $query->Level_2QFwdEmpId3) {
                    $level = 'Level_2ID'; // Third forwarding in Level 2
                }
            }
        }

        // If the user is not in Level 2 or Level 3, check for Level 1 (last option)
        if (in_array($user_id, [$query->Level_1ID, $query->Level_1QFwdEmpId, $query->Level_1QFwdEmpId2, $query->Level_1QFwdEmpId3])) {
            // If the user is associated with Level 1 (either directly or forwarded)
            if ($user_id == $query->Level_1ID) {
                // Directly assigned to Level 1
                $level = 'Level_1ID';
            } else {
                // Forwarded within Level 1
                $level = 'Level_1ID'; // Forwarded to Level 1, but we prioritize Level 2 and Level 3
            }
        }


        if ($forwardto == "Y") {
            if ($level == 'Level_1ID') {
                if($request->forwardReason == null || $request->forwardReason == ''){
                    return response()->json(['success' =>false, 'message' => 'Please provide a reason for forwarding the query,']);
                }
                // Check if Level 1 Forward Employee ID is "0"
                if ($query->Level_1QFwdEmpId == "0" || $query->Level_1QFwdEmpId == null || $query->Level_1QFwdEmpId == '') {
                    $Level_1QFwdEmpId = $request->assignEmpId;
                    $Level_1QFwdReason = $request->forwardReason;
                    $Level_1QFwdDT = now();  // Use current date and time
                    $Level_1QFwdNoOfTime = 1;
                    $assign_emp_id = $request->assignEmpId;
                    $Level_2QToDT = $Level_1QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date
                    $Level_3QToDT = $Level_1QFwdDT->copy()->addDays(6); // Add 3 days to Level 1's forward date
                    $Mngmt_QToDT = $Level_1QFwdDT->copy()->addDays(9); // Add 3 days to Level 1's forward date


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
                            'QStatus' => $request->status,
                            'Level_2QToDT' => $Level_2QToDT,
                            'Level_3QToDT' => $Level_3QToDT,
                            'Mngmt_QToDT' => $Mngmt_QToDT,

                        ]);

                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));



                    if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Level_1QFwdEmpId2 == "0" || $query->Level_1QFwdEmpId2 == null || $query->Level_1QFwdEmpId2 == '') {
                    $Level_1QFwdEmpId = $request->assignEmpId;
                    $Level_1QFwdReason = $request->forwardReason;
                    $Level_1QFwdDT = now();  // Use current date and time
                    $Level_1QFwdNoOfTime = $query->Level_1QFwdNoOfTime ? $query->Level_1QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;
                    $Level_2QToDT = $Level_1QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date
                    $Level_3QToDT = $Level_1QFwdDT->copy()->addDays(6); // Add 3 days to Level 1's forward date
                    $Mngmt_QToDT = $Level_1QFwdDT->copy()->addDays(9); // Add 3 days to Level 1's forward date

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
                            'Level_1QFwdEmpId2' => $Level_1QFwdEmpId,
                            'Level_1QFwdEmpId3' => '0',
                            'Level_1QFwdReason2' => $Level_1QFwdReason,
                            'Level_1QFwdReason3' => '',
                            'Level_1QFwdDT2' => $Level_1QFwdDT,
                            'Level_1QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Level_2QToDT' => $Level_2QToDT,
                            'Level_3QToDT' => $Level_3QToDT,
                            'Mngmt_QToDT' => $Mngmt_QToDT,
                        ]);


                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));



                    if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Level_1QFwdEmpId3 == "0" || $query->Level_1QFwdEmpId3 == null || $query->Level_1QFwdEmpId3 == '') {
                    $Level_1QFwdEmpId = $request->assignEmpId;
                    $Level_1QFwdReason = $request->forwardReason;
                    $Level_1QFwdDT = now();  // Use current date and time
                    $Level_1QFwdNoOfTime = $query->Level_1QFwdNoOfTime ? $query->Level_1QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;
                    $Level_2QToDT = $Level_1QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date
                    $Level_3QToDT = $Level_1QFwdDT->copy()->addDays(6); // Add 3 days to Level 1's forward date
                    $Mngmt_QToDT = $Level_1QFwdDT->copy()->addDays(9); // Add 3 days to Level 1's forward date

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
                            'Level_1QFwdEmpId3' => $Level_1QFwdEmpId,
                            'Level_1QFwdReason3' => $Level_1QFwdReason,
                            'Level_1QFwdDT3' => $Level_1QFwdDT,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Level_2QToDT' => $Level_2QToDT,
                            'Level_3QToDT' => $Level_3QToDT,
                            'Mngmt_QToDT' => $Mngmt_QToDT,

                        ]);

                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));




                    if (in_array($Level_1QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
            }
            if ($level == 'Level_2ID') {
                // Check if Level 1 Forward Employee ID is "0"
                if ($query->Level_2QFwdEmpId == "0" || $query->Level_2QFwdEmpId == null || $query->Level_2QFwdEmpId == '') {
                    $Level_2QFwdEmpId = $request->assignEmpId;

                     if($request->forwardReason == null || $request->forwardReason == ''){
                        return response()->json(['success' =>false, 'message' => 'Please provide a reason for forwarding the query,']);
                    }
                    $Level_2QFwdReason = $request->forwardReason;
                    $Level_2QFwdDT = now();  // Use current date and time
                    $Level_2QFwdNoOfTime = 1;
                    $assign_emp_id = $request->assignEmpId;
                    $Level_3QToDT = $Level_2QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date
                    $Mngmt_QToDT = $Level_2QFwdDT->copy()->addDays(6); // Add 3 days to Level 1's forward date


                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_2QStatus' => $request->status,
                            'Level_2ReplyAns' => $request->reply,
                            'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_2QFwd' => $forwardto,
                            'Level_2QFwdNoOfTime' => $Level_2QFwdNoOfTime,
                            'Level_2QFwdEmpId' => $Level_2QFwdEmpId,
                            'Level_2QFwdEmpId2' => '0',
                            'Level_2QFwdEmpId3' => '0',
                            'Level_2QFwdReason' => $Level_2QFwdReason,
                            'Level_2QFwdReason2' => '0',
                            'Level_2QFwdReason3' => '0',
                            'Level_2QFwdDT' => $Level_2QFwdDT,
                            'Level_2QFwdDT2' => NULL,
                            'Level_2QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Level_3QToDT' => $Level_3QToDT,
                            'Mngmt_QToDT' => $Mngmt_QToDT,

                        ]);
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));


                    if (in_array($Level_2QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Level_2QFwdEmpId2 == "0" || $query->Level_2QFwdEmpId2 == null || $query->Level_2QFwdEmpId2 == '') {
                    $Level_2QFwdEmpId = $request->assignEmpId;
                    $Level_2QFwdReason = $request->forwardReason;
                    $Level_2QFwdDT = now();  // Use current date and time
                    $Level_2QFwdNoOfTime = $query->Level_2QFwdNoOfTime ? $query->Level_2QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;
                    $Level_3QToDT = $Level_2QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date
                    $Mngmt_QToDT = $Level_2QFwdDT->copy()->addDays(6); // Add 3 days to Level 1's forward date

                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_2QStatus' => $request->status,
                            'Level_2ReplyAns' => $request->reply,
                            'Level_2QToDT' => now(), // Current datetime
                            'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_2QFwd' => $forwardto,
                            'Level_2QFwdNoOfTime' => $Level_2QFwdNoOfTime,
                            'Level_2QFwdEmpId2' => $Level_2QFwdEmpId,
                            'Level_2QFwdEmpId3' => '0',
                            'Level_2QFwdReason2' => $Level_2QFwdReason,
                            'Level_2QFwdReason3' => '',
                            'Level_2QFwdDT2' => $Level_2QFwdDT,
                            'Level_2QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Level_3QToDT' => $Level_3QToDT,
                            'Mngmt_QToDT' => $Mngmt_QToDT,

                        ]);
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));


                    if (in_array($Level_2QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Level_2QFwdEmpId3 == "0" || $query->Level_2QFwdEmpId3 == null || $query->Level_2QFwdEmpId3 == '') {
                    $Level_2QFwdEmpId = $request->assignEmpId;
                    $Level_2QFwdReason = $request->forwardReason;
                    $Level_2QFwdDT = now();  // Use current date and time
                    $Level_2QFwdNoOfTime = $query->Level_2QFwdNoOfTime ? $query->Level_2QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;
                    $Level_3QToDT = $Level_2QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date
                    $Mngmt_QToDT = $Level_2QFwdDT->copy()->addDays(6); // Add 3 days to Level 1's forward date

                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_2QStatus' => $request->status,
                            'Level_2ReplyAns' => $request->reply,
                            'Level_2QToDT' => now(), // Current datetime
                            'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_2QFwd' => $forwardto,
                            'Level_2QFwdNoOfTime' => $Level_2QFwdNoOfTime,
                            'Level_2QFwdEmpId3' => $Level_2QFwdEmpId,
                            'Level_2QFwdReason3' => $Level_2QFwdReason,
                            'Level_2QFwdDT3' => $Level_2QFwdDT,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Level_3QToDT' => $Level_3QToDT,
                            'Mngmt_QToDT' => $Mngmt_QToDT,

                        ]);


                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));



                    if (in_array($Level_2QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
            }
            if ($level == 'Level_3ID') {
                // Check if Level 1 Forward Employee ID is "0"
                if ($query->Level_3QFwdEmpId == "0" || $query->Level_3QFwdEmpId == null || $query->Level_3QFwdEmpId == '') {
                    $Level_3QFwdEmpId = $request->assignEmpId;
                    if($request->forwardReason == null || $request->forwardReason == ''){
                        return response()->json(['success' =>false, 'message' => 'Please provide a reason for forwarding the query,']);
                    }
                    $Level_3QFwdReason = $request->forwardReason;
                    $Level_3QFwdDT = now();  // Use current date and time
                    $Level_3QFwdNoOfTime = 1;
                    $assign_emp_id = $request->assignEmpId;
                    $Mngmt_QToDT = $Level_3QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date


                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_3QStatus' => $request->status,
                            'Level_3ReplyAns' => $request->reply,
                            'Level_3DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_3QFwd' => $forwardto,
                            'Level_3QFwdNoOfTime' => $Level_3QFwdNoOfTime,
                            'Level_3QFwdEmpId' => $Level_3QFwdEmpId,
                            'Level_3QFwdEmpId2' => '0',
                            'Level_3QFwdEmpId3' => '0',
                            'Level_3QFwdReason' => $Level_3QFwdReason,
                            'Level_3QFwdReason2' => '0',
                            'Level_3QFwdReason3' => '0',
                            'Level_3QFwdDT' => $Level_3QFwdDT,
                            'Level_3QFwdDT2' => NULL,
                            'Level_3QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Mngmt_QToDT' => $Mngmt_QToDT

                        ]);
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));


                    if (in_array($Level_3QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Level_3QFwdEmpId2 == "0" || $query->Level_3QFwdEmpId2 == null || $query->Level_3QFwdEmpId2 == '') {
                    $Level_3QFwdEmpId = $request->assignEmpId;
                    $Level_3QFwdReason = $request->forwardReason;
                    $Level_3QFwdDT = now();  // Use current date and time
                    $Level_3QFwdNoOfTime = $query->Level_3QFwdNoOfTime ? $query->Level_3QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;
                    $Mngmt_QToDT = $Level_3QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date

                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_3QStatus' => $request->status,
                            'Level_3ReplyAns' => $request->reply,
                            'Level_3QToDT' => now(), // Current datetime
                            'Level_3DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_3QFwd' => $forwardto,
                            'Level_3QFwdNoOfTime' => $Level_3QFwdNoOfTime,
                            'Level_3QFwdEmpId2' => $Level_3QFwdEmpId,
                            'Level_3QFwdEmpId3' => '0',
                            'Level_3QFwdReason2' => $Level_3QFwdReason,
                            'Level_3QFwdReason3' => '',
                            'Level_3QFwdDT2' => $Level_3QFwdDT,
                            'Level_3QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Mngmt_QToDT' => $Mngmt_QToDT


                        ]);
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));

                    if (in_array($Level_3QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Level_3QFwdEmpId3 == "0" || $query->Level_3QFwdEmpId3 == null || $query->Level_3QFwdEmpId3 == '') {
                    $Level_3QFwdEmpId = $request->assignEmpId;
                    $Level_3QFwdReason = $request->forwardReason;
                    $Level_3QFwdDT = now();  // Use current date and time
                    $Level_3QFwdNoOfTime = $query->Level_3QFwdNoOfTime ? $query->Level_3QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;
                    $Mngmt_QToDT = $Level_3QFwdDT->copy()->addDays(3); // Add 3 days to Level 1's forward date

                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Level_3QStatus' => $request->status,
                            'Level_3ReplyAns' => $request->reply,
                            'Level_3QToDT' => now(), // Current datetime
                            'Level_3DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Level_3QFwd' => $forwardto,
                            'Level_3QFwdNoOfTime' => $Level_3QFwdNoOfTime,
                            'Level_3QFwdEmpId3' => $Level_3QFwdEmpId,
                            'Level_3QFwdReason3' => $Level_3QFwdReason,
                            'Level_3QFwdDT3' => $Level_3QFwdDT,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,
                            'Mngmt_QToDT' => $Mngmt_QToDT

                        ]);


                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));



                    if (in_array($Level_3QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
            }
            if ($level == 'Mngmt_ID') {
                // Check if Level 1 Forward Employee ID is "0"
                if ($query->Mngmt_QFwdEmpId == "0" || $query->Mngmt_QFwdEmpId == null || $query->Mngmt_QFwdEmpId == '') {
                    $Mngmt_QFwdEmpId = $request->assignEmpId;
                    if($request->forwardReason == null || $request->forwardReason == ''){
                        return response()->json(['success' =>false, 'message' => 'Please provide a reason for forwarding the query,']);
                    }
                    $Mngmt_QFwdReason = $request->forwardReason;
                    $Mngmt_QFwdDT = now();  // Use current date and time
                    $Mngmt_QFwdNoOfTime = 1;
                    $assign_emp_id = $request->assignEmpId;


                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Mngmt_QStatus' => $request->status,
                            'Mngmt_ReplyAns' => $request->reply,
                            'Mngmt_DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Mngmt_QFwd' => $forwardto,
                            'Mngmt_QFwdNoOfTime' => $Mngmt_QFwdNoOfTime,
                            'Mngmt_QFwdEmpId' => $Mngmt_QFwdEmpId,
                            'Mngmt_QFwdEmpId2' => '0',
                            'Mngmt_QFwdEmpId3' => '0',
                            'Mngmt_QFwdReason' => $Mngmt_QFwdReason,
                            'Mngmt_QFwdReason2' => '0',
                            'Mngmt_QFwdReason3' => '0',
                            'Mngmt_QFwdDT' => $Mngmt_QFwdDT,
                            'Level_3QFwdDT2' => NULL,
                            'Level_3QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,

                        ]);
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));


                    if (in_array($Mngmt_QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Mngmt_QFwdEmpId2 == "0" || $query->Mngmt_QFwdEmpId2 == null || $query->Mngmt_QFwdEmpId2 == '') {
                    $Mngmt_QFwdEmpId = $request->assignEmpId;
                    $Mngmt_QFwdReason = $request->forwardReason;
                    $Mngmt_QFwdDT = now();  // Use current date and time
                    $Mngmt_QFwdNoOfTime = $query->Mngmt_QFwdNoOfTime ? $query->Mngmt_QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;

                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Mngmt_QStatus' => $request->status,
                            'Mngmt_QReplyAns' => $request->reply,
                            'Mngmt_QToDT' => now(), // Current datetime
                            'Mngmt_QDTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Mngmt_QFwd' => $forwardto,
                            'Mngmt_QFwdNoOfTime' => $Mngmt_QFwdNoOfTime,
                            'Mngmt_QFwdEmpId2' => $Mngmt_QFwdEmpId,
                            'Mngmt_QFwdEmpId3' => '0',
                            'Mngmt_QFwdReason2' => $Mngmt_QFwdReason,
                            'Mngmt_QFwdReason3' => '',
                            'Mngmt_QFwdDT2' => $Mngmt_QFwdDT,
                            'Mngmt_QFwdDT3' => NULL,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,

                        ]);
                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));


                    if (in_array($Level_3QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
                if ($query->Mngmt_QFwdEmpId3 == "0" || $query->Mngmt_QFwdEmpId3 == null || $query->Mngmt_QFwdEmpId3 == '') {
                    $Mngmt_QFwdEmpId = $request->assignEmpId;
                    $Mngmt_QFwdReason = $request->forwardReason;
                    $Mngmt_QFwdDT = now();  // Use current date and time
                    $Mngmt_QFwdNoOfTime = $query->Mngmt_QFwdNoOfTime ? $query->Mngmt_QFwdNoOfTime + 1 : 1; // Increment if already forwarded before, else set to 1
                    $assign_emp_id = $request->assignEmpId;

                    // Update the query status, reply, and forward_to fields
                    \DB::table('hrm_employee_queryemp')
                        ->where('QueryID', $request->query_id)
                        ->update([
                            'Mngmt_QStatus' => $request->status,
                            'Mngmt_QReplyAns' => $request->reply,
                            'Mngmt_QToDT' => now(), // Current datetime
                            'Mngmt_QDTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                            'Mngmt_QFwd' => $forwardto,
                            'Mngmt_QFwdNoOfTime' => $Mngmt_QFwdNoOfTime,
                            'Mngmt_QFwdEmpId3' => $Mngmt_QFwdEmpId,
                            'Mngmt_QFwdReason3' => $Mngmt_QFwdReason,
                            'Mngmt_QFwdDT3' => $Mngmt_QFwdDT,
                            'QueryStatus_Emp' => '0',
                            'QueryReply' => '',
                            'AssignEmpId' => $assign_emp_id,
                            'QStatus' => $request->status,

                        ]);


                    // Other existing logic to retrieve employee data and prepare for insertion
                    $employeegeneral = EmployeeGeneral::where('EmployeeID', $assign_emp_id)->first();
                    $employeeforwardeddetails = Employee::where('EmployeeID', $assign_emp_id)->first();
                    $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();


                    $forwardedemployeeEmailId = $employeegeneral->EmailId_Vnr;


                    $forEmpname = ($employeeforwardeddetails->Fname ?? 'null') . ' ' . ($employeeforwardeddetails->Sname ?? 'null') . ' ' . ($employeeforwardeddetails->Lname ?? 'null');
                    $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');

                    $details = [
                        'subject' => 'Query Forwarded',
                        'ForwardedName' => $forEmpname,
                        'EmpName' => $Empname,
                        'DepartmentName' => $department->department_name,
                        'Subject' => $query->QuerySubject,
                        'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
                    ];

                    Mail::to($forwardedemployeeEmailId)->send(new Querytoforwarded($details));



                    if (in_array($Level_3QFwdNoOfTime, [1, 2, 3])) {
                        return response()->json(['success' => true, 'message' => 'Query action Forwarded successfully']);
                    }
                }
            }
        }

        if ($forwardto == "N") {
            // $assign_emp_id = $query->AssignEmpId;

            if ($level == 'Level_1ID') {
                // Update the query status, reply, and forward_to fields
                \DB::table('hrm_employee_queryemp')
                    ->where('QueryID', $request->query_id)
                    ->update([
                        'Level_1QStatus' => $request->status,
                        'Level_1ReplyAns' => $request->reply,
                        'Level_1QToDT' => now(), // Current datetime
                        'Level_1DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                        'QueryStatus_Emp' => '0',
                        'QueryReply' => '',
                        // 'AssignEmpId' => $assign_emp_id,
                        'QStatus' => $request->status


                    ]);
            }
            if ($level == 'Level_2ID') {
                \DB::table('hrm_employee_queryemp')
                    ->where('QueryID', $request->query_id)
                    ->update([
                        'Level_2QStatus' => $request->status,
                        'Level_2ReplyAns' => $request->reply,
                        'Level_2DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                        'QueryStatus_Emp' => '0',
                        'QueryReply' => '',
                        'QStatus' => $request->status
                    ]);
            }
            if ($level == 'Level_3ID') {
                \DB::table('hrm_employee_queryemp')
                    ->where('QueryID', $request->query_id)
                    ->update([
                        'Level_3QStatus' => $request->status,
                        'Level_3ReplyAns' => $request->reply,
                        'Level_3DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                        'QueryStatus_Emp' => '0',
                        'QueryReply' => '',
                        'QStatus' => $request->status

                    ]);
            }
            if ($level == 'Mngmt_ID') {
                \DB::table('hrm_employee_queryemp')
                    ->where('QueryID', $request->query_id)
                    ->update([
                        'Mngmt_QStatus' => $request->status,
                        'Mngmt_ReplyAns' => $request->reply,
                        'Mngmt_DTReplyAns' => now()->format('Y-m-d H:i:s'), // Current date with timezone format
                        'QueryStatus_Emp' => '0',
                        'QueryReply' => '',
                        'QStatus' => $request->status

                    ]);
            }


            // Other existing logic to retrieve employee data and prepare for insertion
            $employeegeneral = EmployeeGeneral::where('EmployeeID', $query->EmployeeID)->first();
            $employeedetails = Employee::where('EmployeeID', $query->EmployeeID)->first();

            $employeeEmailId = $employeegeneral->EmailId_Vnr;


            $Empname = ($employeedetails->Fname ?? 'null') . ' ' . ($employeedetails->Sname ?? 'null') . ' ' . ($employeedetails->Lname ?? 'null');
            $details = [
                'subject' => 'Query Replied',
                'EmpName' => $Empname,
                'DepartmentName' => $department->department_name,
                'Subject' => $query->QuerySubject,
                'site_link' => "vnrseeds.co.in"  // Assuming this is provided in $details              
            ];

            Mail::to($employeeEmailId)->send(new QuerytoEmpReply($details));
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
            ->join('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id')  // Join core_departments based on DepartmentId
            ->where('hrm_employee_queryemp.QueryId', $queryId)  // Filter by QueryId
            ->select(
                'hrm_employee_queryemp.*',          // Select all fields from QueryMapEmp
                'core_departments.*'       // Select all fields from core_departments
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
            'EmpQRating' => $request->rating ?? 0,
            'QueryReply' => $request->remark,
            'QStatus' => $request->status,
        ];

        // Initialize the levelUpdate array
        $levelUpdate = [];


        // Check Level 3 (only if Level 1 and Level 2 were not updated)
        if ($query->Mngmt_ID == $query->Mngmt_ID || $query->Mngmt_QFwdEmpId == $query->Mngmt_ID || $query->Mngmt_QFwdEmpId2 == $query->Mngmt_ID || $query->Mngmt_QFwdEmpId3 == $query->Mngmt_ID) {

            $levelUpdate['Mngmt_QStatus'] = $request->status;
            // Update Level 3 status and return immediately
            $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
                ->update(array_merge($data, $levelUpdate));
            if ($affectedRows > 0) {
                return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
            }
        }

        // Check Level 3 (only if Level 1 and Level 2 were not updated)
        if ($query->Level_3ID == $query->Level_3ID || $query->Level_3QFwdEmpId == $query->Level_3ID || $query->Level_3QFwdEmpId2 == $query->Level_3ID || $query->Level_3QFwdEmpId3 == $query->Level_3ID) {

            $levelUpdate['Level_3QStatus'] = $request->status;
            // Update Level 3 status and return immediately
            $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
                ->update(array_merge($data, $levelUpdate));
            if ($affectedRows > 0) {
                return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
            }
        }
        // Check Level 2 (only if Level 1 was not updated)
        if ($query->Level_2ID == $query->Level_2ID || $query->Level_2QFwdEmpId == $query->Level_2ID || $query->Level_2QFwdEmpId2 == $query->Level_2ID || $query->Level_2QFwdEmpId3 == $query->Level_2ID) {

            $levelUpdate['Level_2QStatus'] = $request->status;
            // Update Level 2 status and return immediately to avoid further checks
            $affectedRows = QueryMapEmp::where('QueryId', $request->query_id)
                ->update(array_merge($data, $levelUpdate));
            if ($affectedRows > 0) {
                return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
            }
        }

        // Check Level 1
        if ($query->Level_1ID == $query->Level_1ID || $query->Level_1QFwdEmpId == $query->Level_1ID || $query->Level_1QFwdEmpId2 == $query->Level_1ID || $query->Level_1QFwdEmpId3 == $query->Level_1ID) {
            $levelUpdate['Level_1QStatus'] = $request->status;
            // Update Level 1 status and return immediately to avoid further checks
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

    public function getQueryDetails($queryId)
    {
        // Fetch the query details from the database
        // Fetch the query details including department name and subject name
        $query = \DB::table('hrm_employee_queryemp as qe')
            ->leftjoin('core_departments as d', 'qe.QToDepartmentId', '=', 'd.id') // Join with department table
            ->leftjoin('hrm_deptquerysub as ds', 'qe.QSubjectId', '=', 'ds.DeptQSubId') // Join with subject table
            ->select(
                'qe.*',
                'd.department_name', // Department name from core_departments
                'ds.DeptQSubject as subject_name' // Subject name from hrm_deptquerysub
            )
            ->where('qe.QueryId', $queryId)
            ->first();
        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'Query not found',
            ], 404);
        }
        // Map status codes to labels
        $level1Status = $this->getStatusLabel($query->Level_1QStatus);
        $level2Status = $this->getStatusLabel($query->Level_2QStatus);
        $level3Status = $this->getStatusLabel($query->Level_3QStatus);
        $Mngmt_QStatus = $this->getStatusLabel($query->Mngmt_QStatus);
        $QueryStatus_Emp = $this->getStatusLabel($query->QueryStatus_Emp);

        // Return query details as JSON
        return response()->json([
            'success' => true,
            'data' => [
                'dept' => $query->department_name,   
                'subject' => $query->subject_name,       
                'details' => $query->QueryValue,       
                'raiseDate' => $query->QueryDT,  
                'level1Status' => $level1Status, 
                'level1Date' => $query->Level_1QToDT,     
                'level1Remarks' => $query->Level_1ReplyAns, 
                'level2Status' => $level2Status, 
                'level2Date' => $query->Level_2QToDT,     
                'level2Remarks' => $query->Level_2ReplyAns, 
                'level3Status' => $level3Status, 
                'level3Date' => $query->Level_3QToDT,     
                'level3Remarks' => $query->Level_3ReplyAns, 
                'mangStatus' => $Mngmt_QStatus, 
                'mangDate' => $query->Mngmt_QToDT,     
                'mangRemarks' => $query->Mngmt_ReplyAns, 
                'Rating' => $query->EmpQRating,
                'EmpStatus' => $QueryStatus_Emp,
                'EmpRemarks' => $query->EmpQRating,


                'level1Remarks_for1' => $query->Level_1QFwdReason, 
                'level1Remarks_for2' => $query->Level_1QFwdReason2, 
                'level1Remarks_for3' => $query->Level_1QFwdReason3, 

                'level2Remarks_for1' => $query->Level_2QFwdReason, 
                'level2Remarks_for2' => $query->Level_2QFwdReason2, 
                'level2Remarks_for3' => $query->Level_2QFwdReason3, 

                'level3Remarks_for1' => $query->Level_3QFwdReason, 
                'level3Remarks_for2' => $query->Level_3QFwdReason2, 
                'level3Remarks_for3' => $query->Level_3QFwdReason3, 


            ],
        ]);
    }
    private function getStatusLabel($status)
    {
        $statusMapping = [
            0 => 'Open',
            1 => 'In Progress',
            2 => 'Reply',
            3 => 'Closed',
            4 => 'Forwarded',
        ];

        return $statusMapping[$status] ?? 'Unknown'; // Default to 'Unknown' if status is invalid
    }
}
