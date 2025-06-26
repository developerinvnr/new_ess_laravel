<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('getFullName')) {

    /**
     * Get full name by retrieving employee details
     *
     * @param integer|null $employeeId The ID of the employee. Null values return empty strings.
     * @return string The full name of the employee or empty string if no match was found.
     */
    function getFullName($employeeId): string
    {
        // if null, return empty string to avoid unnecessary database query
        if ($employeeId === null) {
            return '';
        }
        // use Laravel's Query Builder to retrieve employee data more efficiently
        $employee = DB::table('hrm_employee')->select('Fname', 'Sname', 'Lname')->where('EmployeeID', $employeeId)->first();

        // if employee data not found, return empty string
        if ($employee === null) {
            return '';
        }
        // combine employee name fields into full name and return properly formatted
        $fullNameParts = array_filter([$employee->Fname, $employee->Sname, $employee->Lname], function ($part) {
            return $part !== null && trim($part) !== "";
        });
        $fullName = ucwords(strtolower(implode(" ", $fullNameParts)));
        return $fullName;
    }
}

if (!function_exists('getEmployeeImage')) {
    /**
     * Get the image URL for an employee.
     *
     * @param int $employeeId
     * @return string|null
     */
    function getEmployeeImage($employeeId) {
        // Retrieve the employee data in a single query
        $employee = DB::table('hrm_employee')
            ->where('EmployeeID', $employeeId)
            ->select('CompanyId', 'EmpCode')
            ->first();

        // Return null if employee not found or data is missing
        if (!$employee || empty($employee->CompanyId) || empty($employee->EmpCode)) {
            return null;
        }

            // Build the S3 path
        $path = "Employee_Image/{$employee->CompanyId}/{$employee->EmpCode}.jpg";

        // Return the public URL from S3 disk
        return Storage::disk('s3')->url($path);

        // Build and return the employee image URL
        // return "https://vnrseeds.co.in/AdminUser/EmpImg{$employee->CompanyId}Emp/{$employee->EmpCode}.jpg";
    }
}
