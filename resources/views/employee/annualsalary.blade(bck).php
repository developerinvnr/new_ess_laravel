@include('employee.header')
<body class="mini-sidebar">
@include('employee.sidebar')

    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('employee.head')
        <!-- Sidebar Start -->
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                    <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Annual Salary</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')

                <div class="row">

                       <!-- Annual Salary Section (Right Side) -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card" id="annualsalary">
                        <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="has-btn mb-0">Annual Salary</h4>
                       

                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="yearFilter" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                                use Illuminate\Support\Facades\Crypt;

                                $currentMonth = date('n'); // 1 = Jan, 12 = Dec
                                $currentYear = date('Y');

                                // Determine financial year based on current month
                                if ($currentMonth >= 4) {
                                    // April or later => current financial year is X-Y where X = currentYear, Y = currentYear + 1
                                    $financialYearStart = $currentYear;
                                    $financialYearEnd = $currentYear + 1;
                                } else {
                                    // Jan, Feb, Mar => financial year is (previous)
                                    $financialYearStart = $currentYear - 1;
                                    $financialYearEnd = $currentYear;
                                }

                                $financialYearCurrent = "$financialYearStart-$financialYearEnd"; // e.g., 2025-2026
                                $financialYearPrevious = ($financialYearStart - 1) . '-' . $financialYearStart; // e.g., 2024-2025

                                // Encrypt the END year part for query string
                                $encryptedCurrentYear = Crypt::encryptString($financialYearEnd); // 2026
                                $encryptedPreviousYear = Crypt::encryptString($financialYearStart); // 2025

                                // Decrypt selected year from request if present
                                $selectedYear = null;
                                $displayFinancialYear = $financialYearCurrent;
                                if(request()->has('year')) {
                                    try {
                                        $selectedYear = Crypt::decryptString(request()->get('year'));
                                        $displayFinancialYear = ($selectedYear - 1) . '-' . $selectedYear;
                                    } catch (Exception $e) {
                                        // fallback in case of invalid decryption
                                        $selectedYear = null;
                                        $displayFinancialYear = $financialYearCurrent;
                                    }
                                }
                            @endphp


                                <!-- Display the selected year financial year -->
                                @if(request()->has('year'))
                                    @php
                                        // Decrypt the selected year
                                        $selectedYear = Crypt::decryptString(request()->get('year'));
                                        // Determine the financial year based on the decrypted year
                                        $displayFinancialYear = ($selectedYear - 1) . '-' . $selectedYear;
                                    @endphp
                                    {{ $displayFinancialYear }}
                                @else
                                    <!-- Default to current financial year -->
                                    {{ $financialYearCurrent }}
                                @endif
                            </button>
                               
                                <ul class="dropdown-menu" aria-labelledby="yearFilter">
                                    <li><a class="dropdown-item" href="?year={{ $encryptedPreviousYear }}">Previous Year ({{ $financialYearPrevious }})</a></li>
                                    <li><a class="dropdown-item" href="?year={{ $encryptedCurrentYear }}">Current Year ({{ $financialYearCurrent }})</a></li>
                                </ul>

                            
                        <!-- Hidden print header (Only for print) -->
                                    <div id="printHeaderText" class="d-none">
                                        <h4 class="text-center">
                                            Annual Salary [{{ $displayFinancialYear }}]
                                            {{ Auth::user()->EmpCode }} - {{ Auth::user()->Fname }} {{ Auth::user()->Sname }} {{ Auth::user()->Lname }}
                                        </h4>
                                    </div>

                                    <!-- Print Button -->
                                    <div class="d-inline-block ms-2">
                                    <button class="btn btn-primary" onclick="printContent('{{ $displayFinancialYear }}')">Print</button>
                                    </div>


                        </div>
                            
                            </div>

                            <div class="card-body table-responsive">
                            <div id="printArea">

                            <table class="table table-bordered">
                                <thead >
                                    <tr>
                                        <th>Payment Head</th>
                                        @foreach ($months as $month => $monthName)
                                            <th class="text-center">{{ $monthName }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalEarnings = array_fill(1, 12, 0);
                                        $totalDeductions = array_fill(1, 12, 0);
                                    @endphp

                                    {{-- Loop through the groupedPayslips --}}
                                    @foreach ($groupedPayslips as $employeeID => $payslips)
                                        @php
                                            // Initialize variables for the row calculations
                                            $rowTotal = 0;
                                            $rowValues = [];
                                        @endphp

                                        {{-- Loop through each month --}}
                                        @foreach ($months as $month => $monthName)
                                            @php
                                                // Find the payslip for the specific month
                                                $payslip = $payslips->firstWhere('Month', $monthName);
                                                // Get the value for "Gross Earning"
                                                $value = ($payslip && isset($payslip['Gross Earning'])) ? $payslip['Gross Earning'] : 0;

                                                // Accumulate the total for the row and month
                                                $rowTotal += $value;
                                                $rowValues[] = $value;
                                                $totalEarnings[$month] += $value;
                                            @endphp
                                        @endforeach

                                        {{-- Render Gross Earnings row --}}
                                        @if ($rowTotal > 0)
                                            <tr class="payment-head-details gross-earning-row">
                                                <td><strong>Gross Earning (Employee ID: {{ $employeeID }})</strong></td>
                                                @foreach ($rowValues as $value)
                                                    <td class="text-right">{{ formatToIndianRupees($value, 0) }}</td>
                                                @endforeach
                                                <td><strong>{{ formatToIndianRupees($rowTotal, 0) }}</strong></td>
                                            </tr>
                                        @endif

                                        {{-- Render Other Payment Heads --}}
                                        @foreach ($filteredPaymentHeads as $label => $column)
                                            @if ($label != 'Gross Earning') <!-- Skip the Gross Earning row here -->
                                                @php
                                                    $rowTotal = 0;
                                                    $rowValues = [];
                                                @endphp

                                                @foreach ($months as $month => $monthName)
                                                    @php
                                                        $payslip = $payslips->firstWhere('Month', $monthName);
                                                        $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;

                                                        $rowTotal += $value;
                                                        $rowValues[] = $value;
                                                        $totalEarnings[$month] += $value;
                                                    @endphp
                                                @endforeach

                                                @if ($rowTotal > 0)
                                                    <tr class="payment-head-details other-payment-head earnings-row" data-payment-head="{{ $label }}">
                                                        <td>{{ $label }}</td>
                                                        @foreach ($rowValues as $value)
                                                            <td class="text-right">{{ formatToIndianRupees($value, 0) }}</td>
                                                        @endforeach
                                                        <td class="text-right">{{ formatToIndianRupees($rowTotal, 0) }}</td>
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach

                                        {{-- Render Total Earnings --}}
                                        <tr class="total-row earnings">
                                            <td><strong>Total Earning</strong></td>
                                            @foreach ($months as $month => $monthName)
                                                <td class="text-right"><strong>{{ formatToIndianRupees($totalEarnings[$month], 0) }}</strong></td>
                                            @endforeach
                                            <td class="text-right"><strong class="total-gross-amount">{{ formatToIndianRupees(array_sum($totalEarnings), 0) }}</strong></td>
                                        </tr>

                                        {{-- Render Deduction Heads --}}
                                        @foreach ($filteredDeductionHeads as $label => $column)
                                            @php
                                                $rowTotal = 0;
                                                $rowValues = [];
                                            @endphp

                                            @foreach ($months as $month => $monthName)
                                                @php
                                                    $payslip = $payslips->firstWhere('Month', $monthName);
                                                    $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;

                                                    $rowTotal += $value;
                                                    $rowValues[] = $value;
                                                    $totalDeductions[$month] += ($label != 'Gross Deduction') ? $value : 0; // Exclude Gross Deduction from total
                                                @endphp
                                            @endforeach

                                            @if ($rowTotal > 0)
                                                <tr class="deduction-head-details deduction-row">
                                                    <td>{{ $label }}</td>
                                                    @foreach ($rowValues as $value)
                                                        <td class="text-right">{{ formatToIndianRupees($value, 0) }}</td>
                                                    @endforeach
                                                    <td class="text-right">{{ formatToIndianRupees($rowTotal, 0) }}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                        {{-- Render Total Deductions --}}
                                        <tr class="total-row deductions">
                                            <td><strong>Total Deduction</strong></td>
                                            @foreach ($months as $month => $monthName)
                                                <td class="text-right"><strong>{{ formatToIndianRupees($totalDeductions[$month], 0) }}</strong></td>
                                            @endforeach
                                            <td class="text-right"><strong>{{ formatToIndianRupees(array_sum($totalDeductions), 0) }}</strong></td>
                                        </tr>

                                        {{-- Render Net Amount --}}
                                        <tr class="net-amount-row">
                                            <td><strong>Net Amount</strong></td>
                                            @foreach ($months as $month => $monthName)
                                                <td class="text-right"><strong id="net-amount-{{ $month }}">{{ formatToIndianRupees($totalEarnings[$month] - $totalDeductions[$month], 0) }}</strong></td>
                                            @endforeach
                                            <td class="text-right"><strong class="total-net-amount">{{ formatToIndianRupees(array_sum($totalEarnings) - array_sum($totalDeductions), 0) }}</strong></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                @include('employee.footerbottom')
            </div>
        </div>
    </div>

    <!--General message-->
    <div class="modal fade show" id="model4" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">General Message</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    @include('employee.footer');
<?php
function formatToIndianRupees($number) {
    // Remove decimals
    $number = round($number);

    // Convert the number to string
    $numberStr = (string)$number;

    // Handle case when the number is less than 1000 (no commas needed)
    if (strlen($numberStr) <= 3) {
        return $numberStr;
    }

    // Break the number into two parts: the last 3 digits and the rest
    $lastThreeDigits = substr($numberStr, -3);
    $remainingDigits = substr($numberStr, 0, strlen($numberStr) - 3);

    // Add commas every two digits in the remaining part
    $remainingDigits = strrev(implode(',', str_split(strrev($remainingDigits), 2)));

    // Combine the two parts and return
    return $remainingDigits . ',' . $lastThreeDigits;
}

?>
    <script>
    function printContent(financialYear) {
    // Get employee information
    const empCode = "{{ Auth::user()->EmpCode }}";
    const fName = "{{ Auth::user()->Fname }}";
    const sName = "{{ Auth::user()->Sname }}";
    const lName = "{{ Auth::user()->Lname }}";

    // Set the financial year passed from Blade
    const selectedFinancialYear = financialYear || new Date().getFullYear() - 1 + '-' + new Date().getFullYear();

    // Update the print header text dynamically
    document.getElementById('printHeaderText').innerHTML = `
        <h4 class="text-center">
            Annual Salary [${selectedFinancialYear}] ${empCode} - ${fName} ${sName} ${lName}
        </h4>
    `;

    // Get the table content
    const tableContent = document.getElementById('printArea').innerHTML;

    if (!tableContent) {
        console.error("Table content not found. Ensure the element with id 'printArea' exists.");
        return;
    }

    // Create a new window for printing
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Print - Annual Salary</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    h4 {
                        text-align: center;
                        margin-bottom: 20px;
                        font-size: 18px;
                        font-weight: bold;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid black;
                        text-align: center;
                    }
                    th, td {
                        padding: 8px;
                    }
                    th {
                        background-color: #f2f2f2;
                    }
                </style>
            </head>
            <body>
                ${document.getElementById('printHeaderText').innerHTML} <!-- Add dynamic header -->
                ${tableContent} <!-- Add table content -->
            </body>
        </html>
    `);

    // Trigger the print dialog
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();

    // Close the print window after printing
    printWindow.close();
}
</script>


<style>
    /* CSS to alternate row colors */
table tbody tr:nth-child(even) {
    background-color: #f2f2f2;  /* Light grey for even rows */
}

table tbody tr:nth-child(odd) {
    background-color: #ffffff;  /* White for odd rows */
}

</style>