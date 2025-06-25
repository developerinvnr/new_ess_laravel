<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\EmployeeGeneral;
use App\Models\Qualification;
use App\Models\EmployeeApplyLeave;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class AuthController extends Controller
{
    protected $strcode;
    public function __construct()
    {
        $this->strcode = [
            '',
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            'a',
            'A',
            'b',
            'B',
            'c',
            'C',
            'd',
            'D',
            'e',
            'E',
            'f',
            'F',
            'g',
            'G',
            'h',
            'H',
            'i',
            'I',
            'j',
            'J',
            'k',
            'K',
            'l',
            'L',
            'm',
            'M',
            'n',
            'N',
            'o',
            'O',
            'p',
            'P',
            'q',
            'Q',
            'r',
            'R',
            's',
            'S',
            't',
            'T',
            'u',
            'U',
            'v',
            'V',
            'w',
            'W',
            'x',
            'X',
            'y',
            'Y',
            'z',
            'Z',
            '#',
            '@',
            '$',
            '%',
            '^',
            '&',
            '*',
            '_',
            '!',
            '?',
            ' '
        ];
    }


    // Handle Authentication 
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the input for employeeid (UI) and password
        $request->validate([
            'employeeid' => 'required',
            'password' => 'required',
        ]);

        // Retrieve the employee record using the EmpCode_New column (mapped from employeeid)
        $employee = Employee::where('EmpCode_New', $request->employeeid)->first();

        // Custom decryption and password verification
        if ($employee && $this->decrypt($employee->EmpPass) === $request->password) {
            // Log the user in
            Auth::login($employee, $request->has('remember'));

            // Fetch additional employee details using EmployeeID
            $employeeDetails = Employee::with(
                'stateDetails',
                'designation',
                'employeeGeneral',
                'department',
                'departments',
                'departmentsWithQueries',
                'grade',
                'personaldetails',
                'reportingdesignation',
                'contactDetails',
                'cityDetails',
                'parcityDetails',
                'parstateDetails',
                'familydata',
                'qualificationsdata',
                'languageData',
                'companyTrainingTitles',
                'employeeExperience',
                'employeephoto',
                'attendancedata',
                'queryMap',
                'employeeAttendance',
                'employeeleave',
                'employeePaySlip',
                'employeeAttendanceRequest',
                'employeeAssetReq',
                'employeeAssetOffice',
                'employeeAssetvehcileReq'
            )->where('EmployeeID', $employee->EmployeeID)->first();

            // Redirect based on ProfileCertify and other conditions
            // if ($employeeDetails->ProfileCertify == 'N') {
            //     return redirect()->route('another.view'); // Replace with the actual route
            // }
            $hasHrmOpinionData = \DB::table('hrm_opinion')->where('EmployeeID', $employee->EmployeeID)->exists();


            if ($employeeDetails->ChangePwd == 'N') {
                return view('auth.changepasswordatfirst'); // Replace with the actual view
            }
            
            if($employee->ChangePwd == 'Y'){            

                // if ($employeeDetails->ProfileCertify == 'Y') {
                    if ($hasHrmOpinionData) {
                    return redirect('/dashboard');
                    } else {
                        return view("employee.govtssschemes");
                    }
            }
            if($hasHrmOpinionData){   
                if($employee->ChangePwd == 'N'){               
                return view('auth.changepasswordatfirst'); // Replace with the actual view
                }
            }

            // }
        }

        // Show error message if authentication fails
        return back()->withErrors([
            'employeeid' => 'The provided credentials do not match our records.',
        ]);
    }

    //  for withoutpassword 

    // public function login(Request $request)
    // {
    //     // Validate the input for employeeid (UI) and password
    //     $request->validate([
    //         'employeeid' => 'required',
    //         // 'password' => 'required',
    //     ]);

    //     // Retrieve the employee record using the EmpCode_New column (mapped from employeeid)
    //     $employee = Employee::where('EmpCode_New', $request->employeeid)->first();

    //     // Custom decryption and password verification
    //     // if ($employee && $this->decrypt($employee->EmpPass) === $request->password) {
    //         if ($employee) {

    //         // Log the user in
    //         // Auth::login($employee, $request->has('remember'));
    //         Auth::login($employee);

    //         // Fetch additional employee details using EmployeeID
    //         $employeeDetails = Employee::with(
    //             'stateDetails',
    //             'designation',
    //             'employeeGeneral',
    //             'department',
    //             'departments',
    //             'departmentsWithQueries',
    //             'grade',
    //             'personaldetails',
    //             'reportingdesignation',
    //             'contactDetails',
    //             'cityDetails',
    //             'parcityDetails',
    //             'parstateDetails',
    //             'familydata',
    //             'qualificationsdata',
    //             'languageData',
    //             'companyTrainingTitles',
    //             'employeeExperience',
    //             'employeephoto',
    //             'attendancedata',
    //             'queryMap',
    //             'employeeAttendance',
    //             'employeeleave',
    //             'employeePaySlip',
    //             'employeeAttendanceRequest',
    //             'employeeAssetReq',
    //             'employeeAssetOffice',
    //             'employeeAssetvehcileReq'
    //         )->where('EmployeeID', $employee->EmployeeID)->first();

    //         // Redirect based on ProfileCertify and other conditions
    //         // if ($employeeDetails->ProfileCertify == 'N') {
    //         //     return redirect()->route('another.view'); // Replace with the actual route
    //         // }
    //         $hasHrmOpinionData = \DB::table('hrm_opinion')->where('EmployeeID', $employee->EmployeeID)->exists();


    //         if ($employeeDetails->ChangePwd == 'N') {
    //             return view('auth.changepasswordatfirst'); // Replace with the actual view
    //         }
            
    //         if($employee->ChangePwd == 'Y'){            

    //             // if ($employeeDetails->ProfileCertify == 'Y') {
    //                 if ($hasHrmOpinionData) {
    //                 return redirect('/dashboard');
    //                 } else {
    //                     return view("employee.govtssschemes");
    //                 }
    //         }
    //         if($hasHrmOpinionData){   
    //             if($employee->ChangePwd == 'N'){               
    //             return view('auth.changepasswordatfirst'); // Replace with the actual view
    //             }
    //         }

    //         // }
    //     }

    //     // Show error message if authentication fails
    //     return back()->withErrors([
    //         'employeeid' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    /**
     * Decrypts the given encrypted password using the custom PHP logic provided.
     *
     * @param string $encryptedText
     * @return string
     */
    public function decrypt($encryptedText)
    {

        // Splits the encrypted text into chunks
        $chunks = str_split($encryptedText, 3);

        $output = '';
        foreach ($chunks as $chunk) {
            $output .= $this->derandomized($chunk, $this->strcode);
        }

        return $output;
    }
    /**
     * Splits a string into chunks of the specified size.
     *
     * @param string $text
     * @param int $size
     * @return array
     */
    public function strsplt($text, $size = 1)
    {
        $chunks = [];
        $length = strlen($text);

        for ($i = 0; $i < $length; $i += $size) {
            $chunks[] = substr($text, $i, $size);
        }

        return $chunks;
    }

    /**
     * Derandomizes a chunk of encrypted text and retrieves the original value.
     *
     * @param string $chunk
     * @param array $strcode
     * @return string
     */



    /**
     * Derandomizes a chunk of text using the provided code.
     * 
     * @param string $chunk
     * @param array $strcode
     * @return string
     */
    public function derandomized($chunk, $strcode)
    {
        $arr = $this->strsplt($chunk, strlen($chunk) - 1);
        $output = '';

        for ($x = 0; $x < strlen($chunk) - 1; $x++) {
            $s = $this->key_locator(substr($arr[0], $x, 1), $strcode);
            $t = $this->key_locator($arr[1], $strcode);
            $newcode = $s - $t;

            if ($newcode < 0) {
                $newcode += count($strcode) - 1;
            }

            if ($newcode == 0 && $s != 0) {
                $newcode = count($strcode) - 1;
            }

            $output .= $strcode[$newcode];
        }

        return $output;
    }

    function convert_keyto_value($thetext)
    {
        $output = '';
        $a = $this->add_random_key($thetext);
        while (in_array(count($this->strcode) - 1, $a) == true) {
            $a = $this->add_random_key($thetext);
        }
        for ($i = 0; $i < strlen($thetext) + 1; $i++) {
            $output .= $this->strcode[$a[$i]];
        }
        return $output;
    }

    /**
     * Adds a random key to the given text.
     * 
     * @param string $thetext
     * @param array $strcode
     * @return array
     */
    function add_random_key($thetext)
    {

        $newcode = array();
        $rnd = rand(1, intval(count($this->strcode)) - 2);
        for ($i = 0; $i < strlen($thetext); $i++) {
            $x = $this->key_locator(substr($thetext, $i, 1), $this->strcode);
            $temp = $x + $rnd;
            if ($temp > intval(count($this->strcode) - 1)) {
                $temp = $temp - intval(count($this->strcode) - 1);
            }
            $newcode[] = $temp;
            $temp = "";
        }
        $newcode[] = $rnd;
        return $newcode;
    }

    /**
     * Encrypts the given text using a custom encryption algorithm.
     * 
     * @param string $thetext
     * @param array $strcode
     * @return string
     */


    public function encrypt($thetext)
    {
        $output = '';
        $nstr = $this->strsplt($thetext, 2);
        for ($i = 0; $i < count($nstr); $i++) {
            $output .= $this->convert_keyto_value($nstr[$i]);
        }
        return $output;
    }

    /**
     * Locates the key of a value in the strcode array.
     * 
     * @param string $code
     * @param array $strcode
     * @return int
     */
    public function key_locator($code, $strcode)
    {
        return array_search($code, $strcode) ?: 0; // Returns 0 if not found
    }


    public function dashboard()
    {

        // Retrieve confirmation letter data
        $sqlConf = \DB::table('hrm_employee_confletter')
            ->where(function ($query) {
                $query->where('EmpShow', 'Y')
                    ->orWhere('EmpShow_Trr', 'Y')
                    ->orWhere('EmpShow_Ext', 'Y');
            })
            ->where('EmployeeID', Auth::user()->EmployeeID) // Replace $EmployeeId with the actual employee ID variable
            ->where('Status', 'A')
            ->first();

        $lockDate = \Carbon\Carbon::now()->toDateString();

        if ($sqlConf) {
            // Parse the confirmation date and add a month
            $confDate = \Carbon\Carbon::parse($sqlConf->ConfDate);
            $lockDate = $confDate->addMonth()->toDateString();

            // Determine whether to show the confirmation letter
            $showLetter = (Auth::user()->CompanyId != 4)
                && $lockDate >= \Carbon\Carbon::now()->toDateString()
                && (
                    $sqlConf->EmpShow === 'Y' ||
                    $sqlConf->EmpShow_Trr === 'Y' ||
                    $sqlConf->EmpShow_Ext === 'Y'
                );
        } else {
            $showLetter = false; // Default if no record exists
        }

        // Get the current date and start of the month
        $currentDate = \Carbon\Carbon::now()->toDateString();
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();

        // Generate all dates from the start of the month to the current date
        $allDates = collect();
        $datePointer = \Carbon\Carbon::now()->subDay(); // Start from yesterday to exclude the current date
        // Fetch the HQ name for the employee
        $hq_name = \DB::table('hrm_employee_general')
            ->leftJoin('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')
            ->where('hrm_employee_general.EmployeeID', Auth::user()->EmployeeID)
            ->value('core_city_village_by_state.city_village_name');

        // Define the current date
        $currentDate = date('Y-m-d');  // Assuming $Y is the year and $m is the month
        $cc = \DB::table('hrm_employee_general')
            ->where('EmployeeID', Auth::user()->EmployeeID)
            ->value('CostCenter');

        // Initialize the holidays list
        $all_holidays = collect();
        // Fetch all holidays
        $Y = now()->year;
        $m = now()->month;
        // Determine the holiday condition based on the HQ name
        if ($hq_name == "Bandamailaram") {
            // Holidays for Bandamailaram HQ
            $all_holidays = \DB::table('hrm_holiday')
                ->where('State_3', 1)
                ->where('Year', $Y)
                ->where('HolidayDate', '=', $m)
                ->where('status', 'A')
                ->pluck('HolidayDate')
                ->toArray();
        } else {
            // Fetch holidays for other HQs
            $all_holidays_list = \DB::table('hrm_holiday')
                ->where('Year', $Y)
                ->whereMonth('HolidayDate', '=', $m)
                ->where('status', 'A')
                ->get();

            // Filter holidays based on cost center (State_2 or State_1)
            if ($all_holidays_list->isNotEmpty()) {
                $state_2_details = $all_holidays_list->pluck('State_2_details')->toArray();

                if (in_array($cc, $state_2_details)) {
                    $all_holidays = \DB::table('hrm_holiday')
                        ->where('State_2', 1)
                        ->where('Year', $Y)
                        ->whereMonth('HolidayDate', '=', $m)
                        ->where('status', 'A')
                        ->pluck('HolidayDate')
                        ->toArray();
                } else {
                    $all_holidays = \DB::table('hrm_holiday')
                        ->where('State_1', 1)
                        ->where('Year', $Y)
                        ->whereMonth('HolidayDate', '=', $m)
                        ->where('status', 'A')
                        ->pluck('HolidayDate')
                        ->toArray();
                }
            }
        }
      
        
        while ($datePointer >= \Carbon\Carbon::now()->startOfMonth()) {
            // Ensure $all_holidays is always an array, even if it's null or some other type
            $all_holidays_array = is_array($all_holidays) ? $all_holidays : ($all_holidays ? $all_holidays->toArray() : []);

            // Exclude Sundays (dayOfWeek 0) and holidays in $all_holidays
            if ($datePointer->dayOfWeek !== 0 && !in_array($datePointer->toDateString(), $all_holidays_array)) {
                $allDates->push($datePointer->toDateString());
            }

            $datePointer->subDay();
        }


        // Fetch existing attendance records for this range
        $existingAttendanceDates = \DB::table('hrm_employee_attendance')
            ->where('EmployeeID', Auth::user()->EmployeeID)
            ->whereBetween('AttDate', [$startOfMonth, $currentDate])
            ->whereNotIn('AttDate', $all_holidays) // Exclude holidays
            ->pluck('AttDate')
            ->toArray();

        // Filter out Sundays (day 0 in Carbon, Sunday = 0)
        $existingAttendanceDates = array_filter($existingAttendanceDates, function ($date) {
            return \Carbon\Carbon::parse($date)->dayOfWeek !== 0; // Exclude Sunday
        });

        // Re-index the array if needed (optional)
        $existingAttendanceDates = array_values($existingAttendanceDates);

        // Find missing dates
        $missingDates = $allDates->diff(collect($existingAttendanceDates));

        $separationRecord = \DB::table('hrm_employee_separation')
            ->where('EmployeeID', Auth::user()->EmployeeID)
            ->where(function($query) {
                $query->where('Hod_Approved', '!=', 'C')
                    ->where('Rep_Approved', '!=', 'C')
                    ->where('HR_Approved', '!=', 'C');
            })
            ->first();
        if ($separationRecord) {
            return redirect('/seperation');  // Redirect to the separation page
        }
        $currentYearMonth =  \Carbon\Carbon::now()->format('Y-m'); // e.g., "2024-12"
        
        $attRequests = \DB::table('hrm_employee_attendance_req')
        ->join('hrm_employee_attendance', function ($join) {
            $join->on('hrm_employee_attendance_req.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')
                 ->on('hrm_employee_attendance_req.AttDate', '=', 'hrm_employee_attendance.AttDate'); // Match specific attendance date
        })
        ->where('hrm_employee_attendance_req.EmployeeID', Auth::user()->EmployeeID)
        ->where('hrm_employee_attendance_req.ReqDate', 'LIKE', $currentYearMonth . '%') // Match current month
        ->select(
            'hrm_employee_attendance_req.AttDate as RequestAttDate',
            \DB::raw('COALESCE(hrm_employee_attendance.AttDate, "N/A") as AttendanceDate'),
            \DB::raw('COALESCE(hrm_employee_attendance.Inn, "00:00") as Inn'),
            \DB::raw('COALESCE(hrm_employee_attendance.Outt, "00:00") as Outt'),
            'hrm_employee_attendance_req.Status',
            'hrm_employee_attendance_req.InStatus',
            'hrm_employee_attendance_req.OutStatus',
            'hrm_employee_attendance_req.SStatus',
            'hrm_employee_attendance_req.Remark as ReqRemark',
            'hrm_employee_attendance_req.OutRemark as ReqOutRemark',
            'hrm_employee_attendance_req.InRemark as ReqInRemark'
        )
        ->get();
        $employeeQueryData = \DB::table('hrm_employee_queryemp')
                            ->leftJoin('hrm_deptquerysub', 'hrm_employee_queryemp.QSubjectId', '=', 'hrm_deptquerysub.DeptQSubId') // Join subject table
                            ->leftJoin('core_departments', 'hrm_employee_queryemp.QToDepartmentId', '=', 'core_departments.id') // Join department table
                            ->where('hrm_employee_queryemp.EmployeeID', Auth::user()->EmployeeID)
                            ->where('hrm_employee_queryemp.QueryDT', 'LIKE', $currentYearMonth . '%') // Match current month
                            ->select(
                                'hrm_employee_queryemp.QuerySubject',
                                'hrm_employee_queryemp.QStatus',
                                'hrm_employee_queryemp.QueryDT',
                                'hrm_deptquerysub.DeptQSubject as SubjectName', // Fetch subject name
                                'core_departments.department_name as DepartmentName' // Fetch department name
                            )
                            ->get();
                            
                     
        $leaveRequests = EmployeeApplyLeave::where('EmployeeID', Auth::user()->EmployeeID)
        ->where('Apply_Date', 'LIKE', $currentYearMonth . '%')  // Match "YYYY-MM%" pattern in Apply_Date
        ->whereIn('LeaveStatus', [0, 4, 3])  // Correctly use whereIn for LeaveStatus
        ->get();
        
       $display_ojas = \DB::table('hrm_employee')
        ->where('EmployeeId', Auth::user()->EmployeeID)
        ->where('is_ojas_user', '1')
        ->exists();
    $query_department_list = \DB::table('hrm_deptquerysub')->leftJoin('core_departments','core_departments.id','=','hrm_deptquerysub.DepartmentId')->select(['core_departments.id','core_departments.department_name'])->groupBy('core_departments.id')->get();
    
    $departments_sub = \DB::table('hrm_deptquerysub')->get();

    $today = Carbon::today()->format('Y-m-d'); // Format as YYYY-MM-DD
    $thresholdDate = Carbon::today()->addDays(15)->format('Y-m-d'); // 15 days ahead

    $employees = EmployeeGeneral::join('hrm_employee', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.EmployeeID')
                ->where('RepEmployeeID', Auth::user()->EmployeeID) // Filter by RepEmployeeID
                ->where('DateConfirmationYN', 'N')
                ->where('EmpStatus', 'A')
                ->where(function($query) use ($today, $thresholdDate) {
                    $query->whereBetween('DateConfirmation', [$today, $thresholdDate]) // Check within 15 days
                        ->orWhere('DateConfirmation', '<', $today); // Include those with past confirmation date
                })
                ->pluck('hrm_employee.EmployeeID');

    $isConfirmationDue = $employees->isNotEmpty();
        return view('employee.dashboard',compact('sqlConf','showLetter','missingDates','attRequests','isConfirmationDue','employeeQueryData','leaveRequests','display_ojas','query_department_list','departments_sub')); // Adjust the view name as needed
    }
    public function seperation()
    {

                                    // Retrieve confirmation letter data
                                    $sqlConf = \DB::table('hrm_employee_confletter')
                                        ->where(function ($query) {
                                            $query->where('EmpShow', 'Y')
                                                ->orWhere('EmpShow_Trr', 'Y')
                                                ->orWhere('EmpShow_Ext', 'Y');
                                        })
                                        ->where('EmployeeID', Auth::user()->EmployeeID) // Replace $EmployeeId with the actual employee ID variable
                                        ->where('Status', 'A')
                                        ->first();

                                    $lockDate = \Carbon\Carbon::now()->toDateString();

                                    if ($sqlConf) {
                                        // Parse the confirmation date and add a month
                                        $confDate = \Carbon\Carbon::parse($sqlConf->ConfDate);
                                        $lockDate = $confDate->addMonth()->toDateString();
                                    
                                        // Determine whether to show the confirmation letter
                                        $showLetter = (Auth::user()->CompanyId != 4)
                                            && $lockDate >= \Carbon\Carbon::now()->toDateString()
                                            && (
                                                $sqlConf->EmpShow === 'Y' ||
                                                $sqlConf->EmpShow_Trr === 'Y' ||
                                                $sqlConf->EmpShow_Ext === 'Y'
                                            );
                                    } else {
                                        $showLetter = false; // Default if no record exists
                                    }
                                    
                                                        // Get the current date and start of the month
                        $currentDate = \Carbon\Carbon::now()->toDateString();
                        $startOfMonth = \Carbon\Carbon::now()->startOfMonth()->toDateString();

                        // Generate all dates from the start of the month to the current date
                        $allDates = collect();
                        $datePointer = \Carbon\Carbon::now()->subDay(); // Start from yesterday to exclude the current date
                    // Fetch the HQ name for the employee
                    $hq_name = \DB::table('hrm_employee_general')
                        ->join('core_city_village_by_state', 'hrm_employee_general.HqId', '=', 'core_city_village_by_state.id')
                        ->where('hrm_employee_general.EmployeeID', Auth::user()->EmployeeID)
                        ->value('core_city_village_by_state.city_village_name');

                    // Define the current date
                    $currentDate = date('Y-m-d');  // Assuming $Y is the year and $m is the month
                    $cc = \DB::table('hrm_employee_general')
                    ->where('EmployeeID', Auth::user()->EmployeeID)
                    ->value('CostCenter');
        
                    // Initialize the holidays list
                    $all_holidays = collect();
                    // Fetch all holidays
                    $Y= now()->year;
                    $m = now()->month;
                    // Determine the holiday condition based on the HQ name
                    if ($hq_name == "Bandamailaram") {
                        // Holidays for Bandamailaram HQ
                        $all_holidays = \DB::table('hrm_holiday')
                            ->where('State_3', 1)
                            ->where('Year', $Y)
                            ->where('HolidayDate', '=', $m)
                            ->where('status', 'A')
                            ->pluck('HolidayDate')
                            ->toArray();
                    } else {
                        // Fetch holidays for other HQs
                        $all_holidays_list = \DB::table('hrm_holiday')
                            ->where('Year', $Y)
                            ->whereMonth('HolidayDate', '=', $m)
                            ->where('status', 'A')
                            ->get();
                        
                        // Filter holidays based on cost center (State_2 or State_1)
                        if ($all_holidays_list->isNotEmpty()) {
                            $state_2_details = $all_holidays_list->pluck('State_2_details')->toArray();
                            
                            if (in_array($cc, $state_2_details)) {
                                $all_holidays = \DB::table('hrm_holiday')
                                    ->where('State_2', 1)
                                    ->where('Year', $Y)
                                    ->whereMonth('HolidayDate', '=', $m)
                                    ->where('status', 'A')
                                    ->pluck('HolidayDate')
                                    ->toArray();
                            } else {
                                $all_holidays = \DB::table('hrm_holiday')
                                    ->where('State_1', 1)
                                    ->where('Year', $Y)
                                    ->whereMonth('HolidayDate', '=', $m)
                                    ->where('status', 'A')
                                    ->pluck('HolidayDate')
                                    ->toArray();
                            }
                        }
                    }
                            // while ($datePointer >= \Carbon\Carbon::now()->startOfMonth()) {
                            //     // Exclude Sundays (dayOfWeek 0) and holidays in $all_holidays
                            //     if ($datePointer->dayOfWeek !== 0 && !in_array($datePointer->toDateString(), $all_holidays)) {
                            //         $allDates->push($datePointer->toDateString());
                            //     }
                            //     $datePointer->subDay();
                            // }

                            // while ($datePointer >= \Carbon\Carbon::now()->startOfMonth()) {
                            //     // Exclude Sundays (dayOfWeek 0) and holidays in $all_holidays
                            //     if ($datePointer->dayOfWeek !== 0 && !in_array($datePointer->toDateString(), $all_holidays->toArray())) {
                            //         $allDates->push($datePointer->toDateString());
                            //     }
                            //     $datePointer->subDay();
                            // }
                            
while ($datePointer >= \Carbon\Carbon::now()->startOfMonth()) {
    // Ensure $all_holidays is always an array, even if it's null or some other type
    $all_holidays_array = is_array($all_holidays) ? $all_holidays : ($all_holidays ? $all_holidays->toArray() : []);

    // Exclude Sundays (dayOfWeek 0) and holidays in $all_holidays
    if ($datePointer->dayOfWeek !== 0 && !in_array($datePointer->toDateString(), $all_holidays_array)) {
        $allDates->push($datePointer->toDateString());
    }

    $datePointer->subDay();
}


                       // Fetch existing attendance records for this range
                        $existingAttendanceDates = \DB::table('hrm_employee_attendance')
                            ->where('EmployeeID', Auth::user()->EmployeeID)
                            ->whereBetween('AttDate', [$startOfMonth, $currentDate])
                            ->whereNotIn('AttDate', $all_holidays) // Exclude holidays
                            ->pluck('AttDate')
                            ->toArray();

                        // Filter out Sundays (day 0 in Carbon, Sunday = 0)
                        $existingAttendanceDates = array_filter($existingAttendanceDates, function($date) {
                            return \Carbon\Carbon::parse($date)->dayOfWeek !== 0; // Exclude Sunday
                        });


                        // Re-index the array if needed (optional)
                        $existingAttendanceDates = array_values($existingAttendanceDates);
                        
                        // Find missing dates
                        $missingDates = $allDates->diff(collect($existingAttendanceDates));
                        $currentYearMonth =  \Carbon\Carbon::now()->format('Y-m'); // e.g., "2024-12"

                    
                        // Step 3: Fetch Query Data
                        $employeeQueryData = \DB::table('hrm_employee_queryemp')
                            ->join('hrm_deptquerysub', 'hrm_employee_queryemp.QSubjectId', '=', 'hrm_deptquerysub.DeptQSubId') // Join subject table
                            ->join('hrm_department', 'hrm_employee_queryemp.QToDepartmentId', '=', 'hrm_department.DepartmentID') // Join department table
                            ->where('hrm_employee_queryemp.EmployeeID', Auth::user()->EmployeeID)
                            ->where('hrm_employee_queryemp.QueryDT', 'LIKE', $currentYearMonth . '%') // Match current month
                            ->select(
                                'hrm_employee_queryemp.QuerySubject',
                                'hrm_employee_queryemp.QStatus',
                                'hrm_deptquerysub.DeptQSubject as SubjectName', // Fetch subject name
                                'hrm_department.DepartmentName as DepartmentName' // Fetch department name
                            )
                            ->get();
                    
                            $attRequests = \DB::table('hrm_employee_attendance_req')
                            ->join('hrm_employee_attendance', function ($join) {
                                $join->on('hrm_employee_attendance_req.EmployeeID', '=', 'hrm_employee_attendance.EmployeeID')
                                     ->on('hrm_employee_attendance_req.AttDate', '=', 'hrm_employee_attendance.AttDate'); // Match specific attendance date
                            })
                            ->where('hrm_employee_attendance_req.EmployeeID', Auth::user()->EmployeeID)
                            ->where('hrm_employee_attendance_req.ReqDate', 'LIKE', $currentYearMonth . '%') // Match current month
                            ->select(
                                'hrm_employee_attendance_req.AttDate as RequestAttDate',
                                \DB::raw('COALESCE(hrm_employee_attendance.AttDate, "N/A") as AttendanceDate'),
                                \DB::raw('COALESCE(hrm_employee_attendance.Inn, "00:00") as Inn'),
                                \DB::raw('COALESCE(hrm_employee_attendance.Outt, "00:00") as Outt'),
                                'hrm_employee_attendance_req.Status',
                                    'hrm_employee_attendance_req.InStatus',
                                    'hrm_employee_attendance_req.OutStatus',
                                    'hrm_employee_attendance_req.SStatus',

                                'hrm_employee_attendance_req.Remark as ReqRemark',
                                'hrm_employee_attendance_req.OutRemark as ReqOutRemark',
                                'hrm_employee_attendance_req.InRemark as ReqInRemark'
                            )
                            ->get();
                            $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
                            $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
                            $leaveRequests = EmployeeApplyLeave::where('EmployeeID', Auth::user()->EmployeeID)
                            ->where('Apply_Date', 'LIKE', $currentYearMonth . '%')  // Match "YYYY-MM%" pattern in Apply_Date
                            ->whereIn('LeaveStatus', [0, 4, 3])  // Correctly use whereIn for LeaveStatus
                            ->get();
                            $display_ojas = \DB::table('hrm_employee')
                            ->where('EmployeeId', Auth::user()->EmployeeID)
                            ->where('is_ojas_user', '1')
                            ->exists();
    $departments_sub = \DB::table('hrm_deptquerysub')->get();
    $query_department_list = \DB::table('hrm_deptquerysub')->leftJoin('core_departments','core_departments.id','=','hrm_deptquerysub.DepartmentId')->select(['core_departments.id','core_departments.department_name'])->groupBy('core_departments.id')->get();

        return view('seperation.dashboard',compact('sqlConf','query_department_list','display_ojas','showLetter','missingDates','attRequests','employeeQueryData','leaveRequests','departments_sub')); // Adjust the view name as needed

    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        Cache::flush();
        return redirect('/');
    }
    public function showforgotpasscode()
    {
        return view('auth.forgotpassword');
    }

    public function change_password_view()
    {
        return view('auth.changepasswordview');
    }

    public function changePassword(Request $request)
    {
        $employeechange = Auth::user()->EmployeeID;
        $employee = Employee::findOrFail(Auth::user()->EmployeeID);
        if($employee->ChangePwd == 'N'){
         
            // Encrypt the new password using the provided encryption method
            $encryptedPassword = $this->encrypt($request->password, $this->strcode);

            // Use query builder to update the password in the database
            DB::table('hrm_employee')
                ->where('EmployeeID', Auth::user()->EmployeeID)
                ->update([
                    'EmpPass' => $encryptedPassword,
                    'ChangePwd'=>'Y'

                ]);

                $hasHrmOpinionData = \DB::table('hrm_opinion')->where('EmployeeID', $employee->EmployeeID)->exists();
                if ($hasHrmOpinionData) {
                    return redirect('/dashboard')->with('success', 'Password Changed Successfully');
                } else {
                        return view("employee.govtssschemes");
                    }
             

            }
         

        // Validate the input
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
        ]);

        // Decrypt the stored password and compare with the provided current password
        $storedPassword = $this->decrypt(Auth::user()->EmpPass);

        if ($storedPassword === $request->current_password) {
            $employee = Employee::findOrFail(Auth::user()->EmployeeID);
            // Encrypt the new password using the provided encryption method
            $encryptedPassword = $this->encrypt($request->password, $this->strcode);

            // Check the encrypted password

            // Use query builder to update the password in the database
            DB::table('hrm_employee')
                ->where('EmployeeID', Auth::user()->EmployeeID)
                ->update([
                    'EmpPass' => $encryptedPassword,

                ]);

            return redirect()->back()->with('message', 'Password Updated Successfully');
        } else {
            return redirect()->back()->withErrors(['current_password' => 'Current Password does not match with Old Password']);
        }
    }

    public function leaveBalance($employeeId)
    {
        // $monthName = now()->format('F');

        $leaveBalance = \DB::table('hrm_employee_monthlyleave_balance as leave')
            ->join('hrm_month as month', 'leave.Month', '=', 'month.MonthId')
            ->select('leave.*', 'month.*') // Select all columns from both tables
            ->where('leave.EmployeeID', $employeeId)
            ->where('leave.Month', now()->month) // Match with the month name
            ->where('leave.Year', now()->year) // Current year
            ->first();
        // Check if leaveBalance exists
        if ($leaveBalance) {
            return response()->json([
                'casualLeave' => [
                    'used' => $leaveBalance->AvailedCL,
                    'balance' => $leaveBalance->BalanceCL,
                    'percentage' => $leaveBalance->BalanceCL * 100 / max(($leaveBalance->OpeningCL + $leaveBalance->AvailedCL), 1),
                ],
                'sickLeave' => [
                    'used' => $leaveBalance->AvailedSL,
                    'balance' => $leaveBalance->BalanceSL,
                    'percentage' => $leaveBalance->BalanceSL * 100 / max(($leaveBalance->OpeningSL + $leaveBalance->AvailedSL), 1),
                ],
                'privilegeLeave' => [
                    'used' => $leaveBalance->AvailedPL,
                    'balance' => $leaveBalance->BalancePL,
                    'percentage' => $leaveBalance->BalancePL * 100 / max(($leaveBalance->OpeningPL + $leaveBalance->AvailedPL), 1),
                ],
                'earnedLeave' => [
                    'used' => $leaveBalance->AvailedEL,
                    'balance' => $leaveBalance->BalanceEL,
                    'percentage' => $leaveBalance->BalanceEL * 100 / max(($leaveBalance->OpeningEL + $leaveBalance->AvailedEL), 1),
                ],
                'festivalLeave' => [
                    'used' => $leaveBalance->AvailedOL, // Assuming OpeningOL is used for festival leave
                    'balance' => $leaveBalance->BalanceOL,
                    'percentage' => $leaveBalance->BalanceOL * 100 / max(($leaveBalance->OpeningOL + $leaveBalance->AvailedOL), 1),
                ],
            ]);
        } else {
            // Handle case where no leave balance data is found
            return response()->json(['error' => 'No leave balance data found'], 404);
        }
    }
}
