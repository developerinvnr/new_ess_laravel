<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;

class GovtssschemesController extends Controller
{
    public function govtssschemes(){
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
                return redirect('/dashboard')->with('success', 'Password Changed Successfully');

            }
        return view("employee.govtssschemes");
    }
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'Cast' => 'required',
            'CastOther' => 'nullable|string|max:255',
            'Scheme1' => 'nullable|string',
            'Scheme2' => 'nullable|string',
            'Scheme3' => 'nullable|string',
            'Scheme4' => 'nullable|string',
        ]);

        // Insert data into the hrm_opinion table
        \DB::table('hrm_opinion')->insert([
            'EmployeeID' => Auth::user()->EmployeeID, // Current employee ID
            'OpenionName' => 'jsy', // Replace with a specific opinion value if needed
            'OpenionDate' => now()->format('Y-m-d'), // Current date
            'CrDate' => now()->format('Y-m-d'), // Creation date
            'Cast' => $request->Cast,
            'CastOther' => $request->CastOther,
            'Scheme1' => $request->Scheme1 ?? null,
            'Scheme2' => $request->Scheme2 ?? null,
            'Scheme3' => $request->Scheme3 ?? null,
            'Scheme4' => $request->Scheme4 ?? null,
        ]);

        // Redirect back with a success message
        return redirect('/dashboard')->with('success', 'Gov Scheme saved Successfully');
    }
}
