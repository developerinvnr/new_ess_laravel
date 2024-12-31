<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Qualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
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
            if ($employeeDetails->ProfileCertify == 'N') {
                return redirect()->route('another.view'); // Replace with the actual route
            }

            if ($employeeDetails->ChangePwd == 'N') {
                return view('auth.changepasswordview'); // Replace with the actual view
            }

            $hasHrmOpinionData = \DB::table('hrm_opinion')->where('EmployeeID', $employee->EmployeeID)->exists();

            if ($employeeDetails->ProfileCertify == 'Y') {
                if ($hasHrmOpinionData) {
                    return redirect('/dashboard');
                } else {
                    return redirect()->route('another.view'); // Replace with the actual route
                }
            }
        }

        // Show error message if authentication fails
        return back()->withErrors([
            'employeeid' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Decrypts the given encrypted password using the custom PHP logic provided.
     *
     * @param string $encryptedText
     * @return string
     */
    private function decrypt($encryptedText)
    {
        $strcode = [
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

        // Splits the encrypted text into chunks
        $chunks = str_split($encryptedText, 3);

        $output = '';
        foreach ($chunks as $chunk) {
            $output .= $this->derandomized($chunk, $strcode);
        }

        return $output;
    }

    /**
     * Derandomizes a chunk of encrypted text and retrieves the original value.
     *
     * @param string $chunk
     * @param array $strcode
     * @return string
     */
    private function derandomized($chunk, $strcode)
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

    /**
     * Splits a string into chunks of the specified size.
     *
     * @param string $text
     * @param int $size
     * @return array
     */
    private function strsplt($text, $size = 1)
    {
        $chunks = [];
        $length = strlen($text);

        for ($i = 0; $i < $length; $i += $size) {
            $chunks[] = substr($text, $i, $size);
        }

        return $chunks;
    }

    /**
     * Locates the key of a value in the strcode array.
     *
     * @param string $code
     * @param array $strcode
     * @return int
     */
    private function key_locator($code, $strcode)
    {
        foreach ($strcode as $key => $val) {
            if ($val === $code) {
                return $key;
            }
        }

        return 0;
    }

    public function dashboard()
    {

        return view('employee.dashboard'); // Adjust the view name as needed
    }
    public function seperation()
    {

        return view('seperation.dashboard'); // Adjust the view name as needed
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
        // Validate the input
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Ensure the new password is not the same as the current password
        if ($request->current_password === $request->password) {
            return redirect()->back()->withErrors(['password' => 'Current password and new password cannot be the same.']);
        }

        // Decrypt the stored password and compare with the provided current password
        $storedPassword = $this->decrypt(auth()->user()->EmpPass);
        if ($storedPassword === $request->current_password) {
            $employee = Employee::findOrFail(Auth::user()->EmployeeID);

            // Encrypt the new password and update the EmpPass field
            $encryptedPassword = $this->encrypt($request->password);

            // Update the password in the database
            $employee->update([
                'EmpPass' => $encryptedPassword,
                // Uncomment the line below to update the ChangePwd flag if needed
                //'ChangePwd' => 'Y', 
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
