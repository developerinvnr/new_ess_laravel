<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class LoggingReportsController extends Controller
{
    // public function locationtracking(Request $request)
    // {

    //         $startDate = $request->start_date;
    //         $endDate = $request->end_date;
    //         $status = $request->status;
            
           
    //         $EmployeeID = Auth::user()->EmployeeID;
        
    //         // Get all employees reporting to the logged-in user (RepEmployeeID) along with their EmpStatus
    //         $employeesReportingTo = DB::table('hrm_employee_general')
    //             ->join('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
    //             ->where('hrm_employee_general.RepEmployeeID', $EmployeeID)
    //             ->select('hrm_employee_general.EmployeeID', 'hrm_employee.EmpStatus','hrm_employee.Fname','hrm_employee.Sname','hrm_employee.Lname')
    //             ->get();
        
    //         // Initialize an array to hold all location tracking data
    //         $allLocationTracking = [];
        
    //         // Iterate over each employee to fetch their location tracking data
    //         foreach ($employeesReportingTo as $employee) {
    //             $locationTracking = DB::connection('mysql2')
    //                 ->table('data_geolocation')
    //                 ->where('EmpId', $employee->EmployeeID)
    //                 ->whereBetween('DTime', [$startDate, $endDate])
    //                 ->orderBy('DTime', 'asc')
    //                 ->get();
        
    //             // Add the EmpStatus to each item in the location tracking collection
    //             $locationTrackingWithStatus = $locationTracking->map(function ($location) use ($employee) {
    //                 $location->EmpStatus = $employee->EmpStatus;
    //                 $location->Fname = $employee->Fname;
    //                 $location->Sname = $employee->Sname;
    //                 $location->Lname = $employee->Lname;
    //                 return $location;
    //             });
        
    //             // Add the location tracking data with EmpStatus to the array
    //             $allLocationTracking[$employee->EmployeeID] = $locationTrackingWithStatus;
    //         }
    //         dd($allLocationTracking);
        
    //         return view('employee.loggingreports', ['allLocationTracking' => $allLocationTracking]);

    //     }


    public function locationtracking(Request $request)
    {
        // Retrieve start date, end date, and encrypted employee ID from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $encryptedEmployeeId = $request->input('employee_id');
        $employeeId = '';

        // Decrypt the employee ID
        if($encryptedEmployeeId){
        try {
            $employeeId = Crypt::decrypt($encryptedEmployeeId);
        } catch (DecryptException $e) {
            
        }}
    
        $EmployeeID = Auth::user()->EmployeeID;
    
        // Fetch employees reporting to the logged-in user
        $employeesReportingTo = DB::table('hrm_employee_general')
            ->join('hrm_employee', 'hrm_employee_general.EmployeeID', '=', 'hrm_employee.EmployeeID')
            ->where('hrm_employee_general.RepEmployeeID', $EmployeeID)
            ->select('hrm_employee_general.EmployeeID', 'hrm_employee.EmpStatus', 'hrm_employee.Fname', 'hrm_employee.Sname', 'hrm_employee.Lname')
            ->get();
    
        // Filter employees based on the selected employee ID
        $filteredEmployees = $employeesReportingTo->filter(function ($employee) use ($employeeId) {
            return $employee->EmployeeID == $employeeId;
        });
    
        // Initialize an array to hold all location tracking data
        $allLocationTracking = [];
      if($startDate && $endDate && $employeeId != ''){

        // Iterate over each filtered employee to fetch their location tracking data
        foreach ($filteredEmployees as $employee) {
            // Create the base query to get location data
            $locationTracking = DB::connection('mysql2')
                ->table('data_geolocation')
                ->where('EmpId', $employee->EmployeeID)
                ->whereBetween('DTime', [
                    Carbon::parse($startDate)->startOfDay()->toDateTimeString(), // 2025-01-01 00:00:00
                    Carbon::parse($endDate)->endOfDay()->toDateTimeString()      // 2025-02-28 23:59:59
                ])
                ->orderBy('DTime', 'asc')
                ->get();
                // Variable to hold total distance
                $totalDistance = 0;

                
                // Initialize an array to hold location tracking data with distances
                $locationTrackingWithDistances = [];

                for ($i = 0; $i < count($locationTracking); $i++) {
                    $start = $locationTracking[$i];
                
                    // Check if there is a next location to calculate distance
                    if ($i < count($locationTracking) - 1) {
                        $end = $locationTracking[$i + 1];
                
                        if ($start->DLat && $start->DLong && $end->DLat && $end->DLong) {
                            $distance = $this->getDistance($start->DLat, $start->DLong, $end->DLat, $end->DLong, 'kilometers');
                            $start->distance = round($distance, 2);
                            $totalDistance += $distance;
                        } else {
                            $start->distance = 0;
                        }
                    } else {
                        // Last entry: No next point to calculate distance
                        $start->distance = 0;
                    }
                
                    // Get the address for this location (only if latitude and longitude are available)
                    if ($start->DLat && $start->DLong) {
                        $start->address = $this->getAddress($start->DLat, $start->DLong);
                    } else {
                        $start->address = 'Address not available';
                    }
                
                    // Add the start point with its distance to the array
                    $locationTrackingWithDistances[] = $start;
                }
                
            
            // Merge employee info with the location tracking data
            $locationTrackingWithStatus = collect($locationTrackingWithDistances)->map(function ($location) use ($employee) {
                $location->EmpStatus = $employee->EmpStatus;
                $location->Fname = $employee->Fname;
                $location->Sname = $employee->Sname;
                $location->Lname = $employee->Lname;
                return $location;
            });
            
            // Store the merged data by EmployeeID
            $allLocationTracking[$employee->EmployeeID] = $locationTrackingWithStatus;
            $totalDistances[$employee->EmployeeID] = round($totalDistance, 2);

        }}
        else{
        $allLocationTracking = [];
        $totalDistances= [];


        }
        return view('employee.loggingreports', [
            'allLocationTracking' => $allLocationTracking,
            'totalDistances' => $totalDistances,
            'selectedEmployeeId'  => $employeeId,  // New variable for the view

        ]);
    
    }
    private function getDistance($latitude1, $longitude1, $latitude2, $longitude2, $unit)
{
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;

    switch ($unit) {
        case 'miles':
            break;
        case 'kilometers':
            $distance = $distance * 1.609344;
            break;
    }

    return $distance;
}
private function getAddress($latitude, $longitude)
{
    $apiKey = 'AIzaSyCX-IBGudyr19-E7zrx1PTGqy0PEVwX5wQ';
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&sensor=false&key={$apiKey}";

    $response = Http::get($url);
    $data = $response->json();

    if ($data['status'] == 'OK') {
        return $data['results'][0]['formatted_address'];
    } else {
        return 'Data not found, Try Again';
    }
}
}
