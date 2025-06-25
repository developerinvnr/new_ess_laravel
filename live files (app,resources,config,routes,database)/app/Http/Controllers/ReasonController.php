<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reason;
use App\Models\ReasonMaster;


class ReasonController extends Controller
{
    public function getReasons($companyId, $departmentId)
    {
        // $reasonIds = Reason::where('CompanyId', $companyId)
        // ->where('DEpartmentId', $departmentId)
        // ->pluck('ReasonId');

        
        // // Check if $reasonIds is not empty before executing the next query
        // if ($reasonIds->isNotEmpty()) {
        //     // Fetch reason names based on ReasonIds
        //     $reasons = ReasonMaster::whereIn('id', $reasonIds)
        //                            ->get(['id as ReasonId', 'reason_name']);
        // } else {
        //     $reasons = collect(); // Return an empty collection if no ReasonIds found
        // }
        $reasons = [
            ['ReasonId' => 1, 'reason_name' => 'OD'],
            ['ReasonId' => 2, 'reason_name' => 'Tour'],
            ['ReasonId' => 3, 'reason_name' => 'Meetings'],
            ['ReasonId' => 4, 'reason_name' => 'Other']
        ];
    
        return response()->json($reasons);
    }
}
