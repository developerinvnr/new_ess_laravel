@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <div class="main-content">
            <!-- Page Title Start -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-title-wrapper">
                        <div class="breadcrumb-list">
                            <ul>
                                <li class="breadcrumb-link">
                                    <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                </li>
                                <li class="breadcrumb-link active">My Team</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Start -->
            @include('employee.menuteam')
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <!-- Loop through each employee and create a separate table -->
                    <div class="card chart-card" id="">
                        <div class="card-header">
                        </div>
                        <div class="card-body table-responsive">
                            @foreach ($employeeData as $employee)
                                <div class="employee-table">
                                    <!-- Employee Name with Arrow -->
                                    <h4 style="margin-bottom:10px;"><b>
                                        {{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}
                                        <b><span class="toggle-arrow" style="cursor: pointer;"> ↓ </b></span></b>
                                    </h4>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Payment Head</th>
                                                @foreach ($months as $month => $monthName)
                                                    <th>{{ $monthName }}</th>
                                                @endforeach
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                // Initialize total variables
                                                $totalEarnings = array_fill(1, 12, 0);
                                                $totalDeductions = array_fill(1, 12, 0);
                                            @endphp

                                            <!-- Gross Earning Row -->
                                            @foreach ($filteredPaymentHeads as $label => $column)
                                                @if($label == 'Gross Earning')
                                                    <tr class="payment-head-details gross-earning earnings-row" data-payment-head="{{ $label }}">
                                                        <td>{{ $label }} </td>
                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @foreach ($months as $month => $monthName)
                                                            @php
                                                                $payslip = isset($groupedPayslips[$employee->EmployeeID]) 
                                                                            ? $groupedPayslips[$employee->EmployeeID]->firstWhere('Month', $monthName) 
                                                                            : null;
                                                                $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;
                                                                $total += $value;
                                                                $totalEarnings[$month] += $value;
                                                            @endphp
                                                            <td>{{ number_format($value, 2) }}</td>
                                                        @endforeach
                                                        <td>{{ number_format($total, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            <!-- Other Payment Heads -->
                                            @foreach ($filteredPaymentHeads as $label => $column)
                                                @if($label != 'Gross Earning')
                                                    <tr class="payment-head-details other-payment-head earnings-row" data-payment-head="{{ $label }}">
                                                        <td>{{ $label }}</td>
                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @foreach ($months as $month => $monthName)
                                                            @php
                                                                $payslip = isset($groupedPayslips[$employee->EmployeeID]) 
                                                                            ? $groupedPayslips[$employee->EmployeeID]->firstWhere('Month', $monthName) 
                                                                            : null;
                                                                $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;
                                                                $total += $value;
                                                                $totalEarnings[$month] += $value;
                                                            @endphp
                                                            <td>{{ number_format($value, 2) }}</td>
                                                        @endforeach
                                                        <td>{{ number_format($total, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            <!-- Total Earnings Row (Colored Green) -->
                                            <tr class="total-row earnings" style="background-color: #d4edda; color: #155724;">
                                                <td><strong>Total Earning</strong></td>
                                                @foreach ($months as $month => $monthName)
                                                    <td><strong>{{ number_format($totalEarnings[$month], 2) }}</strong></td>
                                                @endforeach
                                                <td><strong>{{ number_format(array_sum($totalEarnings), 2) }}</strong></td>
                                            </tr>

                                            <!-- Deduction Heads Rows -->
                                            @foreach ($filteredDeductionHeads as $label => $column)
                                                <tr class="deduction-head-details deduction-row">
                                                    <td>{{ $label }}</td>
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach ($months as $month => $monthName)
                                                        @php
                                                            $payslip = isset($groupedPayslips[$employee->EmployeeID]) 
                                                                        ? $groupedPayslips[$employee->EmployeeID]->firstWhere('Month', $monthName) 
                                                                        : null;
                                                            $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;
                                                            $total += $value;
                                                            $totalDeductions[$month] += $value;
                                                        @endphp
                                                        <td>{{ number_format($value, 2) }}</td>
                                                    @endforeach
                                                    <td>{{ number_format($total, 2) }}</td>
                                                </tr>
                                            @endforeach

                                            <!-- Total Deductions Row (Colored Red) -->
                                            <tr class="total-row deductions" style="background-color: #f8d7da; color: #721c24;">
                                                <td><strong>Total Deduction</strong></td>
                                                @foreach ($months as $month => $monthName)
                                                    <td><strong>{{ number_format($totalDeductions[$month], 2) }}</strong></td>
                                                @endforeach
                                                <td><strong>{{ number_format(array_sum($totalDeductions), 2) }}</strong></td>
                                            </tr>

                                            <!-- Net Amount Row (Colored Yellow) -->
                                            <tr class="net-amount-row" style="background-color: #fff3cd; color: #856404;">
                                                <td><strong>Net Amount</strong></td>
                                                @foreach ($months as $month => $monthName)
                                                    <td><strong>{{ number_format($totalEarnings[$month] - $totalDeductions[$month], 2) }}</strong></td>
                                                @endforeach
                                                <td><strong>{{ number_format(array_sum($totalEarnings) - array_sum($totalDeductions), 2) }}</strong></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('employee.footer')

    <script>
//      document.addEventListener('DOMContentLoaded', function () {
//         document.addEventListener('DOMContentLoaded', function () {
//     function hideEmptyRows() {
//         // Loop through all employee tables
//         document.querySelectorAll('.employee-table').forEach(function (employeeTable) {
//             // Loop through all payment rows (earnings, deductions, etc.)
//             employeeTable.querySelectorAll('.payment-head-details').forEach(function (paymentRow) {
//                 let isEmpty = true;

//                 // Loop through the month cells (ignoring the first cell which is the payment head label)
//                 let monthCells = paymentRow.querySelectorAll('td:nth-child(n+2):nth-child(-n+13)'); // Select cells for months

//                 monthCells.forEach(function (cell) {
//                     let value = parseFloat(cell.innerText.replace(',', '').trim()); // Convert value to float
//                     if (value > 0) {
//                         isEmpty = false; // Found a non-zero value, mark the row as not empty
//                     }
//                 });

//                 // Hide the row if all values are zero
//                 if (isEmpty) {
//                     paymentRow.style.display = 'none';
//                 } else {
//                     paymentRow.style.display = 'table-row'; // Ensure it is visible if it has non-zero values
//                 }
//             });
//         });
//     }

//     // Call the function to hide rows with all zero values
//     hideEmptyRows();
// });


//     // Initially hide all rows except Gross Earning
//     document.querySelectorAll('.employee-table').forEach(function (employeeTable) {
//         let rows = employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row');

//         rows.forEach(function (row) {
//             if (!row.classList.contains('gross-earning')) {
//                 row.style.display = 'none'; // Hide rows except Gross Earning
//             }
//         });
//     });

//     // Handle row expansion on arrow click
//     document.querySelectorAll('.toggle-arrow').forEach(function (arrow) {
//         arrow.addEventListener('click', function () {
//             let employeeTable = arrow.closest('.employee-table');
//             let isExpanded = employeeTable.classList.contains('expanded');

//             // Toggle the expanded state
//             if (isExpanded) {
//                 employeeTable.classList.remove('expanded');
//                 arrow.innerHTML = ' ↓ '; // Down arrow

//                 // Hide all rows except the gross earnings row
//                 employeeTable.querySelectorAll('.earnings-row:not(.gross-earning), .deduction-row, .total-row, .net-amount-row').forEach(function (detailRow) {
//                     detailRow.style.display = 'none';
//                 });
//             } else {
//                 employeeTable.classList.add('expanded');
//                 arrow.innerHTML = ' ↑ '; // Up arrow

//                 // Show all rows
//                 employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row').forEach(function (detailRow) {
//                     detailRow.style.display = 'table-row';
//                 });
//             }
//         });
//     });
// });

      document.addEventListener('DOMContentLoaded', function () {
        function hideEmptyRows() {
        // Loop through all employee tables
        document.querySelectorAll('.employee-table').forEach(function (employeeTable) {
            // Loop through all payment rows (earnings, deductions, etc.)
            employeeTable.querySelectorAll('.payment-head-details').forEach(function (paymentRow) {
                let isEmpty = true;

                // Check each month cell in the row (skip the first cell which is the label)
                let monthCells = paymentRow.querySelectorAll('td:nth-child(n+2):nth-child(-n+13)');
                
                monthCells.forEach(function (cell) {
                    let value = parseFloat(cell.innerText.replace(',', '').trim()); // Convert value to float
                    if (value > 0) {
                        isEmpty = false; // Found a non-zero value
                    }
                });

                // Hide the row if all values are zero
                if (isEmpty) {
                    paymentRow.style.display = 'none';
                } else {
                    paymentRow.style.display = 'table-row'; // Ensure it is visible if it has non-zero values
                }
            });
        });
    }

    // Initially hide rows with all zero values
    hideEmptyRows();

    // Initially hide all rows except Gross Earning
    document.querySelectorAll('.employee-table').forEach(function (employeeTable) {
        let rows = employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row');
        
        rows.forEach(function (row) {
            if (!row.classList.contains('gross-earning')) {
                row.style.display = 'none'; // Hide rows except Gross Earning
            }
        });
        
    });

    // Handle row expansion on arrow click
    document.querySelectorAll('.toggle-arrow').forEach(function (arrow) {
        arrow.addEventListener('click', function () {
            let employeeTable = arrow.closest('.employee-table');
            let isExpanded = employeeTable.classList.contains('expanded');
            
            // Toggle the expanded state
            if (isExpanded) {
                employeeTable.classList.remove('expanded');
                arrow.innerHTML = ' ↓ '; // Down arrow

                // Hide all rows except the gross earnings row
                employeeTable.querySelectorAll('.earnings-row:not(.gross-earning), .deduction-row, .total-row, .net-amount-row').forEach(function (detailRow) {
                    detailRow.style.display = 'none';
                });
            } else {
                employeeTable.classList.add('expanded');
                arrow.innerHTML = ' ↑ '; // Up arrow

                // Show all rows
                employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row').forEach(function (detailRow) {
                    detailRow.style.display = 'table-row';
                });
            }
        });
    });
});

    </script>
