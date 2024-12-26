<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExitInterviewController extends Controller
{
    public function exitinterviewform(){
        
        $separationRecord = \DB::table('hrm_employee_separation')->where('EmployeeID', Auth::user()->EmployeeID)->first();
        $empid = $separationRecord->EmpSepId;

        if ($separationRecord) {
            return view("seperation.exitinterviewform",compact('empid'));
        }
        return view("employee.exitinterviewform");
    }

    public function submit(Request $request)
    {
        if($request->button_id == 'finalsubmitexitemp'){
           $button = 'Y';
        }
        // Step 2: Gather the input data from the request
        $data = [
            'EmpSepId' => $request->EmpSepId,
            'FRI' => $request->personal_reasons_1,
            'HP' => $request->personal_reasons_2,
            'OB' => $request->personal_reasons_3,
            'PGR' => $request->growth_reasons_1,
            'LOC' => $request->growth_reasons_2,
            'LPO' => $request->growth_reasons_3,
            'JANM' => $request->growth_reasons_4,
            'LOCOP' => $request->atmosphere_conditions_1,
            'IAU' => $request->atmosphere_conditions_2,
            'LOCOM' => $request->atmosphere_conditions_3,
            'US' => $request->working_conditions_unclean_surroundings,
            'HJ' => $request->working_conditions_stressful_job,
            'WH' => $request->working_conditions_working_hours,
            'JITM' => $request->working_conditions_too_much_travel,
            'NFOC' => $request->working_conditions_non_fulfillment_commitments,
            'IPI' => $request->compensation_inadequate_pay,
            'IIAB' => $request->compensation_inadequate_incentives,
            'AR' => $request->role_related_ambiguous_role,
            'NCIR' => $request->role_related_no_clarity_reporting,
            'Q1_1' => $request->primary_reasons_for_leaving,
            'Q2_1' => $request->most_satisfying_about_job,
            'Q3_1' => $request->most_dissatisfying_about_job,
            'Q4_1' => $request->company_policies_made_work_difficult,
            'Q5_1' => $request->prevent_leave_suggestion,
            'Q6' => $request->recommend_to_friend,
            'ComName' => $request->new_company_name,
            'Location' => $request->new_job_location,
            'Designation' => $request->new_job_designation,
            'hike' => $request->hike_in_compensation,
            'OthBefit' => $request->new_job_benefits,
            'final_submit_exit_emp'=>$button,
        ];

        // Step 3: Check if a record exists for the given EmpSepId (using Query Builder)
        $existingRecord = \DB::table('hrm_employee_separation_exitint')->where('EmpSepId', $data['EmpSepId'])->first();

        if ($existingRecord) {
            // Step 4: If the record exists, update the data
            \DB::table('hrm_employee_separation_exitint')
                ->where('EmpSepId', $data['EmpSepId'])
                ->update($data);
        } else {
            // Step 5: If the record does not exist, insert a new record
            \DB::table('hrm_employee_separation_exitint')->insert($data);
        }

        // Return success response
        return response()->json([
            'success' => true,
            'message' => 'Exit form data processed successfully',
        ]);
    }
    public function getFormData($empid)
    {
        $data = \DB::table('hrm_employee_separation_exitint')->where('EmpSepId', $empid)->first();

        // Return the data in JSON format
        return response()->json($data);
    }

}
