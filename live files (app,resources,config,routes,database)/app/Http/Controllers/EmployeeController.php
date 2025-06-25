<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeGeneral;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\DepartmentSubject;
use App\Models\Department;
use App\Models\EmployeeReporting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\HrmYear;
use App\Mail\Query\QuerytoEmp;
use App\Mail\Query\QuerytoRep;
use App\Mail\Query\QuerytoHr;
use App\Mail\Query\QuerytoEmpReply;
use App\Mail\Query\Querytoforwarded;
use App\Mail\Query\Querytoqueryowner;

class EmployeeController extends Controller
{
    public function getEmployeeDetails($employeeId)
    {

        $employee = Employee::find($employeeId);
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $employeeGeneral = EmployeeGeneral::find($employeeId);
        if (!$employeeGeneral) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        return response()->json([
            'company_id' => $employee->CompanyId,
            'department_id' => $employeeGeneral->DepartmentId,
        ]);
    }
    public function policy_change_details($empCode)
    {
        $details = DB::table('policy_change_details')
            ->where('EmpCode', $empCode)
            ->first();

        return response()->json(['status' => 'success', 'data' => $details]);
    }

    public function getEmployeeData(Request $request)
    {
        $employeeId = $request->input('employeeId');
        Log::info('getEmployeeData called', ['employeeId' => $employeeId]);

        DB::enableQueryLog();
        $employee = DB::table('hrm_employee')
            ->select('CompanyId', 'EmpCode', 'VCode')
            ->where('EmployeeId', $employeeId)
            ->first();

        Log::info('getEmployeeData query', ['query' => DB::getQueryLog()]);

        if (!$employee) {
            Log::error('Employee not found in getEmployeeData', ['employeeId' => $employeeId]);
            return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
        }
        $hasConfirmedEmployee= DB::table('hrm_employee_ledger_confirmation')
        ->where('EmployeeId', $employeeId)
        ->where('Year', '2024-25')
        ->exists();

        Log::info('Employee data retrieved', ['employee' => (array)$employee]);
        return response()->json([
            'success' => true,
            'companyId' => $employee->CompanyId,
            'empCode' => $employee->EmpCode,
            'vCode' => $employee->VCode,
            'hasConfirmedEmployee'=> $hasConfirmedEmployee
        ]);
    }


    public function viewLedger(Request $request, $companyId, $year, $empCode)
    {
        // Get employeeId from request query parameter
        $employeeId = $request->query('employeeId');
        Log::info('viewLedger called', [
            'employeeId' => $employeeId,
            'companyId' => $companyId,
            'year' => $year,
            'empCode' => $empCode
        ]);

        if (!$employeeId) {
            Log::error('Employee ID missing in viewLedger request');
            return response()->json([
                'success' => false,
                'message' => 'Your ledger is not available right now'
            ], 400);
        }

        // Verify the employee matches the provided employeeId
        $employee = DB::table('hrm_employee')
            ->where('EmployeeId', $employeeId)
            ->where('CompanyId', $companyId)
            ->where(function ($query) use ($empCode) {
                // Match EmpCode exactly if it starts with V
                $query->where('EmpCode', $empCode)
                    // OR match EmpCode after stripping E/V if VCode is empty or E
                    ->orWhere(function ($subQuery) use ($empCode) {
                        $subQuery->whereIn('VCode', ['', 'E'])
                            ->where('EmpCode', str_replace(['E', 'V'], '', $empCode));
                    });
            })
            ->first();

        if (!$employee) {
            Log::error('Unauthorized access to ledger', [
                'employeeId' => $employeeId,
                'companyId' => $companyId,
                'empCode' => $empCode,
                'cleanedEmpCode' => str_replace(['E', 'V'], '', $empCode)
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Your ledger is not available right now'
            ], 403);
        }

        Log::info('Employee validated', ['employee' => (array)$employee]);

        // Construct the file path relative to project root
        $prefix = $employee->VCode === 'V' ? '' : 'E';
        $filePath = base_path("Employee/Emp{$companyId}Lgr/{$year}/{$prefix}{$employee->EmpCode}.pdf");
        Log::info('Constructed file path', ['filePath' => $filePath]);

        // Check if file exists
        if (!file_exists($filePath)) {
            Log::error('Ledger file not found', ['filePath' => $filePath]);
            return response()->json([
                'success' => false,
                'message' => 'Your ledger is not available right now'
            ], 404);
        }

        Log::info('File exists, attempting to stream PDF', ['filePath' => $filePath]);

        try {
            // Stream the PDF without allowing download
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="ledger.pdf"',
                'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
        } catch (\Exception $e) {
            Log::error('Error streaming PDF', ['filePath' => $filePath, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Your ledger is not available right now'
            ], 500);
        }
    }

    public function showDownloadPage($employeeId)
    {
        if (!auth()->check()) {
            Log::error('User not authenticated', ['employeeId' => $employeeId]);
            return redirect()->route('login');
        }

        Log::info('showDownloadPage called', ['employeeId' => $employeeId]);

        // Fetch employee data
        $employee = DB::table('hrm_employee')
            ->select('CompanyId', 'EmpCode', 'VCode')
            ->where('EmployeeId', $employeeId)
            ->first();

        if (!$employee) {
            Log::error('Employee not found in showDownloadPage', ['employeeId' => $employeeId]);
            return redirect()->route('dashboard')->with('error', 'Employee not found');
        }

        Log::info('Employee data for view', ['employee' => (array)$employee]);

        $empCode = $employee->VCode === 'V' ? "V{$employee->EmpCode}" : "E{$employee->EmpCode}";
        return view('employee.downloadledger', [
            'employeeId' => $employeeId,
            'companyId' => $employee->CompanyId,
            'empCode' => $empCode
        ]);
    }

    public function downloadLedger(Request $request, $companyId, $year, $empCode)
    {
        $employeeId = $request->query('employeeId');
        Log::info('downloadLedger called', [
            'employeeId' => $employeeId,
            'companyId' => $companyId,
            'year' => $year,
            'empCode' => $empCode
        ]);

        $employee = DB::table('hrm_employee')
            ->where('EmployeeId', $employeeId)
            ->where('CompanyId', $companyId)
            ->where(function ($query) use ($empCode) {
                $query->where('EmpCode', $empCode)
                    ->orWhere(function ($subQuery) use ($empCode) {
                        $subQuery->whereIn('VCode', ['', 'E'])
                            ->where('EmpCode', str_replace(['E', 'V'], '', $empCode));
                    });
            })
            ->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access or employee not found'
            ], 403);
        }

        // Construct the file path
        $prefix = $employee->VCode === 'V' ? '' : 'E';
        $filePath = base_path("Employee/Emp{$companyId}Lgr/{$year}/{$prefix}{$employee->EmpCode}.pdf");

        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Ledger file not found'
            ], 404);
        }
        

        return response()->download($filePath, "ledger_{$year}_{$prefix}{$employee->EmpCode}.pdf");
    }

    public function checkConfirmation(Request $request)
    {
        $employeeId = $request->input('employeeId');
        $year = $request->input('year');
        // Fetch employee full name
        $employee = DB::table('hrm_employee')
            ->select('Fname', 'Lname', 'Sname')
            ->where('EmployeeId', $employeeId)
            ->first();

        $fullName = $employee
            ? trim("{$employee->Fname} {$employee->Sname} {$employee->Lname}")
            : null;
        // Check for confirmation first
        $confirmation = DB::table('hrm_employee_ledger_confirmation')
            ->where('EmployeeId', $employeeId)
            ->where('Year', $year)
            ->first();

        if ($confirmation) {
            return response()->json([
                'alreadyConfirmed' => true,
                'confirmationDate' => $confirmation->created_at,
                'fullName' => $fullName
            ]);
        }

        // Check for existing ledger query
        $query = DB::table('hrm_employee_queryemp')
            ->where('EmployeeID', $employeeId)
            ->where('QuerySubject', 'Ledger Confirmation')
            ->where('QToDepartmentId', 4) // Ledger department
            ->orderBy('QueryDT', 'desc')
            ->first();

        if ($query) {
            // Prepare query history and check for replies
            $queryHistory = [];
            $hasReply = false;

            // Add initial query
            if ($query->QueryValue) {
                 $statusLabels = [
                    0 => 'Open',
                    1 => 'In Process',
                    2 => 'Replied',
                    3 => 'Closed',
                    4 => 'Escalated'
                ];
                $queryHistory[] = [
                    'text' => $query->QueryValue,
                    'date' => $query->QueryDT,
                    'type' => 'question',
                    'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
                ];
            }
            // Check for replies

            if ($query->QueryReply || $query->Level_1ReplyAns) {
             $statusLabels = [
                    0 => 'Open',
                    1 => 'In Process',
                    2 => 'Replied',
                    3 => 'Closed',
                    4 => 'Escalated'
                ];

                if ($query->QueryReply) {
                    $queryHistory[] = [
                        'text' => $query->QueryReply,
                        'date' => $query->QReply2DT,
                        'type' => 'answer',
                        'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
                    ];
                    $hasReply = true;

                } elseif ($query->Level_1ReplyAns) {
                    $queryHistory[] = [
                        'text' => $query->Level_1ReplyAns,
                        'date' => $query->Level_1DTReplyAns ?? null,
                        'type' => 'answer',
                        'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'
                    ];
                    $hasReply = true;
                }


                $hasReply = true;
            }



            // Add follow-up questions if they exist
            if ($query->Query2Value) {
                $queryHistory[] = [
                    'text' => $query->Query2Value,
                    'date' => $query->Query2DT,
                    'type' => 'question',
                    'status' => $statusLabels[$query->QStatus] ?? 'Unknown'

                ];
                if ($query->Query2Reply || $query->Level_1ReplyAns) {
                    if ($query->Query2Reply) {
                        $queryHistory[] = [
                            'text' => $query->Query2Reply,
                            'date' => $query->QReply2DT,
                            'type' => 'answer',
                            'status' => $statusLabels[$query->QStatus] ?? 'Unknown'
                        ];
                    }

                    // if ($query->Level_1ReplyAns) {
                    //     $queryHistory[] = [
                    //         'text' => $query->Query2Reply ?? '',
                    //         'date' => $query->Level_1DTReplyAns ?? null, // Adjust date field if it exists
                    //         'type' => 'answer',
                    //         'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'

                    //     ];
                    // }

                    $hasReply = true;
                }
            }

            // Continue for Query3Value, Query3Reply, etc. as needed

            return response()->json([
                'hasQuery' => true,
                'queryStatus' => ($query->Level_1QStatus == 2 || $query->QueryStatus_Emp == 2),
                'queryHistory' => $queryHistory,
                'canAddNewQuery' => (
                    in_array($query->Level_1QStatus, [0, 1, 3]) || 
                    in_array($query->QueryStatus_Emp, [0, 1, 3])
                ),
                'hasReply' => $hasReply,
                'latestQueryText' => $query->QueryValue,
                'latestReply' => $query->QueryReply,
                'queryDate' => $query->QueryDT,
                'replyDate' => $query->QReplyDT,
                'fullName' => $fullName,
                'status' => $statusLabels[$query->Level_1QStatus] ?? 'Unknown'

            ]);
        }

        return response()->json([
            'alreadyConfirmed' => false,
            'hasQuery' => false,
            'fullName' => $fullName
        ]);
    }

    public function submitConfirmation(Request $request)
    {
        $employeeId = $request->input('employeeId');
        $companyId = $request->input('companyId');
        $year = $request->input('year');
        $empCode = $request->input('empCode');
        $confirmation = $request->input('confirmation');
        $queryText = $request->input('queryText', '');
        $ipAddress = $request->ip();


        // Validate input
        if (!$employeeId || !$confirmation || !$companyId || !$year || !$empCode) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required parameters'
            ], 400);
        }

        // Verify employee
        $employee = DB::table('hrm_employee')
            ->where('EmployeeId', $employeeId)
            ->where('CompanyId', $companyId)
            ->where(function ($query) use ($empCode) {
                $query->where('EmpCode', $empCode)
                    ->orWhere(function ($subQuery) use ($empCode) {
                        $subQuery->whereIn('VCode', ['', 'E'])
                            ->where('EmpCode', str_replace(['E', 'V'], '', $empCode));
                    });
            })
            ->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Employee not found'
            ], 404);
        }

        if ($confirmation === 'confirm') {
            try {
                // Save IP & fingerprint
                DB::table('hrm_employee_ledger_confirmation')->updateOrInsert(
                    ['EmployeeId' => $employeeId, 'Year' => $year],
                    [
                        'ip_address' => $ipAddress,
                        'ip_details' => json_encode($request->fingerprint),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );

                // Fetch employee
                $employee = DB::table('hrm_employee')
                    ->select('Fname', 'Lname', 'Sname', 'VCode', 'EmpCode')
                    ->where('EmployeeId', $employeeId)
                    ->first();

                if (!$employee) {
                    Log::error("Employee not found for ID: $employeeId");
                    return response()->json([
                        'success' => false,
                        'message' => 'Employee not found.'
                    ], 404);
                }

                $fullName = trim("{$employee->Fname} {$employee->Sname} {$employee->Lname}");

                $prefix = $employee->VCode === 'V' ? '' : 'E';
                $filePath = base_path("Employee/Emp{$companyId}Lgr/{$year}/{$prefix}{$employee->EmpCode}.pdf");

                if (!file_exists($filePath)) {
                    Log::warning("Ledger PDF not found at path: $filePath");
                    return response()->json([
                        'success' => false,
                        'message' => 'Ledger file not found'
                    ], 404);
                }

                // Subject/Department Mapping
                $departmentId = 4;
                $subject = 'Ledger Confirmation';

                $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $subject)
                    ->where('DepartmentId', $departmentId)
                    ->first();

                if (!$departmentQuerySub) {
                    Log::error("Ledger subject mapping not found for dept ID: $departmentId");
                    return response()->json([
                        'success' => false,
                        'message' => 'Ledger confirmation department not configured'
                    ], 404);
                }

                // Calculate financial year
                if (now()->month >= 4) {
                    $fyStart = Carbon::create(now()->year, 4, 1)->toDateString();
                    $fyEnd = Carbon::create(now()->year + 1, 3, 31)->toDateString();
                } else {
                    $fyStart = Carbon::create(now()->year - 1, 4, 1)->toDateString();
                    $fyEnd = Carbon::create(now()->year, 3, 31)->toDateString();
                }

                $currentYearRecord = HrmYear::whereDate('FromDate', $fyStart)
                    ->whereDate('ToDate', $fyEnd)
                    ->first();

                if (!$currentYearRecord) {
                    Log::error("HrmYear not found for range $fyStart to $fyEnd");
                    return response()->json([
                        'success' => false,
                        'message' => 'Financial year configuration missing'
                    ], 404);
                }

                $year_id_current = $currentYearRecord->YearId;

                // Check existing query entry
                $existing = DB::table('hrm_employee_queryemp')
                    ->where('EmployeeID', $employeeId)
                    ->where('QuerySubject', $subject)
                    ->where('QToDepartmentId', $departmentId)
                    ->where('QueryYearId', $year_id_current)
                    ->first();

                if ($existing) {
                    DB::table('hrm_employee_queryemp')
                        ->where('QueryId', $existing->QueryId)
                        ->update([
                            'QueryStatus_Emp' => 3,
                            'Level_1QStatus' => 3
                        ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Thank you! Your confirmation has been submitted successfully.',
                    // 'downloadUrl' => url("/ledger/download/{$companyId}/{$year}/{$prefix}{$employee->EmpCode}?employeeId={$employeeId}"),
                    'downloadUrl' => route('ledger.confirmation.print', ['id' => $employeeId]),
                    'fullName' => $fullName,
                ]);
            } catch (\Exception $e) {
                Log::error("Error during confirmation: " . $e->getMessage(), [
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred during confirmation. Please try again later.'
                ], 500);
            }
        }

        // Handle confirmation
        // if ($confirmation === 'confirm') {
        //     DB::table('hrm_employee_ledger_confirmation')->updateOrInsert(
        //         ['EmployeeId' => $employeeId, 'Year' => $year],
        //         ['ip_address' => $ipAddress,
        //           'ip_details' => json_encode($request->fingerprint),
        //          'created_at' => now(), 'updated_at' => now()]
        //     );
        //     // Fetch employee full name
        //     $employee = DB::table('hrm_employee')
        //         ->select('Fname', 'Lname', 'Sname')
        //         ->where('EmployeeId', $employeeId)
        //         ->first();

        //     $fullName = $employee
        //         ? trim("{$employee->Fname} {$employee->Sname} {$employee->Lname}")
        //         : null;

        //     // Generate the PDF file path
        //     $prefix = $employee->VCode === 'V' ? '' : 'E';
        //     $filePath = base_path("Employee/Emp{$companyId}Lgr/{$year}/{$prefix}{$employee->EmpCode}.pdf");

        //     if (!file_exists($filePath)) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Ledger file not found'
        //         ], 404);
        //     }
        //     $departmentId = 4; // Ledger Confirmation department
        //     $subject = 'Ledger Confirmation';

        //     // Get department subject ID
        //     $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $subject)
        //         ->where('DepartmentId', $departmentId)
        //         ->first();

        //     if (!$departmentQuerySub) {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Ledger confirmation department not configured'
        //         ], 404);
        //     }
        //              // Get financial year
        //     if (Carbon::now()->month >= 4) {
        //         $financialYearStart = Carbon::createFromDate(Carbon::now()->year, 4, 1)->toDateString();
        //         $financialYearEnd = Carbon::createFromDate(Carbon::now()->year + 1, 3, 31)->toDateString();
        //     } else {
        //         $financialYearStart = Carbon::createFromDate(Carbon::now()->year - 1, 4, 1)->toDateString();
        //         $financialYearEnd = Carbon::createFromDate(Carbon::now()->year, 3, 31)->toDateString();
        //     }

        //     $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
        //         ->whereDate('ToDate', '=', $financialYearEnd)
        //         ->first();
        //     $year_id_current = $currentYearRecord->YearId;
        //       $existing = DB::table('hrm_employee_queryemp')
        //         ->where('EmployeeID', $employeeId)
        //         ->where('QuerySubject', $subject)
        //         ->where('QToDepartmentId', $departmentId)
        //         ->where('QueryYearId', $year_id_current)
        //         ->first();
        //     if ($existing) {
        //         $queryData = [
        //             'QueryStatus_Emp' => 3,
        //             'Level_1QStatus' => 3,
        //         ];

        //         DB::table('hrm_employee_queryemp')
        //                 ->where('QueryId', $existing->QueryId)
        //                 ->update($queryData);
        //     }
                

        //     // Return both success message and download URL
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Thank you! Your confirmation has been submitted successfully.',
        //         'downloadUrl' => url("/ledger/download/{$companyId}/{$year}/{$prefix}{$employee->EmpCode}?employeeId={$employeeId}"),
        //         'fullName'=> $fullName ??null
        //     ]);
        // }

        // Handle query with 30/60 day deadlines
        if ($confirmation === 'query') {
            // Validate query text
            if (empty($queryText)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Query text is required'
                ], 400);
            }

            // Fixed department and subject for ledger queries
            $departmentId = 4; // Ledger Confirmation department
            $subject = 'Ledger Confirmation';

            // Get department subject ID
            $departmentQuerySub = DepartmentSubject::where('DeptQSubject', $subject)
                ->where('DepartmentId', $departmentId)
                ->first();

            if (!$departmentQuerySub) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ledger confirmation department not configured'
                ], 404);
            }

            // Get employee reporting
            $employeeReporting = EmployeeReporting::where('EmployeeID', $employeeId)->first();
            if (!$employeeReporting) {
                return response()->json([
                    'success' => false,
                    'message' => 'Employee reporting details not found'
                ], 404);
            }

            // Get assignee reporting
            $assigneeReporting = EmployeeReporting::where('EmployeeID', $departmentQuerySub->AssignEmpId)->first();
            $level_2id = $assigneeReporting?->AppraiserId;
            $level_3id = $assigneeReporting?->ReviewerId;
            $mgnid = $assigneeReporting?->HodId;

            // Calculate dates - using 30 and 60 days
            $currentDate = Carbon::now();

            // Level 2 deadline: 30 days from now
            $level2Deadline = $currentDate->copy()->addDays(30);
            if ($level2Deadline->isSunday()) {
                $level2Deadline->addDay(); // Move to Monday if it's Sunday
            }

            // Level 3 deadline: 60 days from now
            $level3Deadline = $currentDate->copy()->addDays(60);
            if ($level3Deadline->isSunday()) {
                $level3Deadline->addDay(); // Move to Monday if it's Sunday
            }

            // Get financial year
            if (Carbon::now()->month >= 4) {
                $financialYearStart = Carbon::createFromDate(Carbon::now()->year, 4, 1)->toDateString();
                $financialYearEnd = Carbon::createFromDate(Carbon::now()->year + 1, 3, 31)->toDateString();
            } else {
                $financialYearStart = Carbon::createFromDate(Carbon::now()->year - 1, 4, 1)->toDateString();
                $financialYearEnd = Carbon::createFromDate(Carbon::now()->year, 3, 31)->toDateString();
            }

            $currentYearRecord = HrmYear::whereDate('FromDate', '=', $financialYearStart)
                ->whereDate('ToDate', '=', $financialYearEnd)
                ->first();
            $year_id_current = $currentYearRecord->YearId;

            // Prepare query data
            $queryData = [
                'EmployeeID' => $employeeId,
                'RepMgrId' => $employeeReporting->AppraiserId,
                'HodId' => $employeeReporting->HodId,
                'QToDepartmentId' => $departmentId,
                'QSubjectId' => $departmentQuerySub->DeptQSubId,
                'QuerySubject' => $subject,
                'HideYesNo' => 'N', // Default to not hidden
                'QueryDT' => Carbon::now(),
                'QueryValue' => $queryText,
                'QueryNoOfTime' => 1,
                'AssignEmpId' => $departmentQuerySub->AssignEmpId,
                'Level_1ID' => $departmentQuerySub->AssignEmpId,
                'Level_2ID' => $level_2id,
                'Level_3ID' => $level_3id,
                'Mngmt_ID' => $mgnid,
                'Level_1QToDT' => Carbon::now(),
                'Level_2QToDT' => $level2Deadline,
                'Level_3QToDT' => $level3Deadline,
                'Mngmt_QToDT' => $level3Deadline, // Same as Level 3 deadline
                'MailTo_Emp' => 1,
                'MailTo_QueryOwner' => 1,
                'QueryYearId' => $year_id_current,
            ];
            $existing = DB::table('hrm_employee_queryemp')
                ->where('EmployeeID', $employeeId)
                ->where('QuerySubject', $subject)
                ->where('QToDepartmentId', $departmentId)
                ->where('QueryYearId', $year_id_current)
                ->first();

            if ($existing) {
                // Determine which Query field is next available
                $nextQueryField = null;
                for ($i = 2; $i <= 5; $i++) {
                    $field = "Query{$i}Value";
                    if (empty($existing->$field)) {
                        $nextQueryField = $field;
                        break;
                    }
                }

                if (!$nextQueryField) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum number of follow-up queries (5) already submitted.'
                    ], 400);
                }

                // Remove QueryValue from $queryData to avoid overwriting it
                unset($queryData['QueryValue']);
                $queryData[$nextQueryField] = $queryText;
                $queryData['QueryNoOfTime'] = DB::raw('QueryNoOfTime + 1');
                $queryData['QueryDT'] = Carbon::now();
                $queryData['Level_1QStatus'] = 0;
                $queryData['QStatus'] = 0;

                DB::table('hrm_employee_queryemp')
                    ->where('QueryId', $existing->QueryId)
                    ->update($queryData);

                $message = 'Your ledger follow-up query has been updated successfully.';
            } else {
                // Insert new query
                DB::table('hrm_employee_queryemp')->insert($queryData);
                $message = 'Your ledger query has been submitted successfully.';
            }


            try {
                // Send emails
                $employeeGeneral = EmployeeGeneral::where('EmployeeID', $employeeId)->first();
                $queryOwnerGeneral = EmployeeGeneral::where('EmployeeID', $departmentQuerySub->AssignEmpId)->first();
                $employeeDetails = Employee::where('EmployeeID', $employeeId)->first();
                $department = Department::find($departmentId);

                $employeeName = ($employeeDetails->Fname ?? '') . ' ' .
                    ($employeeDetails->Sname ?? '') . ' ' .
                    ($employeeDetails->Lname ?? '');

                $details = [
                    'subject' => 'Ledger Query Request',
                    'EmpName' => $employeeName,
                    'DepartmentName' => $department->department_name,
                    'Subject' => $subject,
                    'site_link' => "vnrseeds.co.in",
                    'deadline_30_days' => $level2Deadline->format('d-m-Y'),
                    'deadline_60_days' => $level3Deadline->format('d-m-Y')
                ];

                Mail::to($employeeGeneral->EmailId_Vnr)->send(new QuerytoEmp($details));
                Mail::to($employeeGeneral->ReportingEmailId)->send(new QuerytoRep($details));
                Mail::to($queryOwnerGeneral->EmailId_Vnr)->send(new Querytoqueryowner($details));
                Mail::to('vspl.hr@vnrseeds.com')->send(new QuerytoHr($details));

                return response()->json([
                    'success' => true,
                    'message' => $message

                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Query submitted but failed to send notifications: ' . $e->getMessage()
                ], 500);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid request'
        ], 400);
    }

    public function submitQueryFollowup(Request $request)
    {
        $employeeId = $request->input('employeeId');
        $companyId = $request->input('companyId');
        $year = $request->input('year');
        $empCode = $request->input('empCode');
        $queryText = $request->input('queryText');

        // Get the latest query
        $query = DB::table('hrm_employee_queryemp')
            ->where('EmployeeID', $employeeId)
            ->where('QuerySubject', 'Ledger Confirmation')
            ->where('QToDepartmentId', 4)
            ->orderBy('QueryDT', 'desc')
            ->first();

        if (!$query) {
            return response()->json([
                'success' => false,
                'message' => 'No existing query found'
            ], 404);
        }

        // Determine which query field to use (Query2Value, Query3Value, etc.)
        $updateData = [];
        $now = now();

        if (empty($query->Query2Value)) {
            $updateData = [
                'Query2Value' => $queryText,
                'Query2DT' => $now,
                'QueryStatus_Emp' => 0, // Reset status to Open
                'updated_at' => $now
            ];
        } elseif (empty($query->Query3Value)) {
            $updateData = [
                'Query3Value' => $queryText,
                'Query3DT' => $now,
                'QueryStatus_Emp' => 0,
                'updated_at' => $now
            ];
        } // Continue for more levels as needed

        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum follow-up queries reached'
            ], 400);
        }

        // Update the query
        DB::table('hrm_employee_queryemp')
            ->where('QueryId', $query->QueryId)
            ->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Follow-up query submitted successfully'
        ]);
    }
}
