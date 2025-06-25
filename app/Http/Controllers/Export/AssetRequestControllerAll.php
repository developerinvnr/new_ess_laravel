<?php

namespace App\Http\Controllers\Export;

use App\Exports\AssetRequestAllExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Correct import for Controller

class AssetRequestControllerAll extends Controller // Extending the correct base controller
{
    public function export(Request $request)
    {
        
        $acct_status = $request->input('acct_status');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $empcode = $request->input('empcode');


        return Excel::download(
            new AssetRequestAllExport($acct_status,$from_date,$to_date,$empcode),
            'all_employees_assests_details_account.xlsx'
        );
    }
}