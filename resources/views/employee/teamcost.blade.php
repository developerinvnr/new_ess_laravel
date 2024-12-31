@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
<div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
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
            @if($isReviewer)
            <div class="flex-shrink-0" style="float:right;">
                                                    <form method="GET" action="{{ route('teamcost') }}">
                                                        @csrf
                                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                                            <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2"  style="float:right;">HOD/Reviewer</label>
                                                            <input 
                                                                class="form-check-input" 
                                                                type="checkbox" 
                                                                name="hod_view" 
                                                                id="hod-view" 
                                                                {{ request()->has('hod_view') ? 'checked' : '' }} 
                                                                onchange="toggleLoader(); this.form.submit();" 
                                                                >
                                                        </div>
                                                    </form>
                                                </div>
                                                @endif
                <div class="col mb-2">
                    <div class="cost-box">
                    <h4>Total CTC
                        <div class="float-end"><i class="fas fa-rupee-sign"></i> {{ number_format($ctcttotal, 0) }}</div>
                    </h4>
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="cost-box">
                        <h4>Total Paid
                            <div class="float-end">
                                <i class="fas fa-rupee-sign"></i> 
                                <span id="total-paid-amount"></span> <!-- This value will be updated by JS -->
                            </div>
                        </h4>
                    </div>
                </div>
                <div class="col mb-2">
                        <div class="cost-box">
                            <h4>Salary (gross)
                                <div class="float-end">
                                    <i class="fas fa-rupee-sign"></i> 
                                    <span id="salary-gross-amount"></span> <!-- This value will be dynamically updated by JS -->
                                </div>
                            </h4>
                        </div>
                    </div>

                <!-- <div class="col mb-2">
                    <div class="cost-box">
                    <h4>Expense <div class="float-end"><i class="fas fa-rupee-sign"></i> 1,00000/-</div></h4>
                   
                    </div>
                </div>
                <div class="col mb-2">
                    <div class="cost-box">
                    <h4>BCT<div class="float-end"><i class="fas fa-rupee-sign"></i> 1,00000/-</div></h4>
                   
                    </div>
                </div> -->
            </div>
            <div class="row">
                
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <!-- Loop through each employee and create a separate table -->
                    <div class="card chart-card" id="">
                        <div class="card-header">
                            <h5 class="float-start">Salary Details</h5>
                        </div>
                        <div class="card-body table-responsive">
                            @foreach ($employeeData as $employee)
                                <div class="employee-table">
                                    <!-- Employee Name with Arrow -->
                                    <h4 style="margin-bottom:10px;"><b>
                                        {{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}
                                        <span class="float-end toggle-arrow"><i class="fas fa-arrow-circle-down"></i></span>
                                        
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
                                                // Initialize total variables for earnings (excluding Gross Earnings)
                                                $totalEarnings = array_fill(1, 12, 0);
                                                $totalDeductions = array_fill(1, 12, 0);
                                            @endphp

                                            

                                            <!-- Other Payment Heads (Excluding Gross Earnings) -->
                                            @foreach ($filteredPaymentHeads as $label => $column)
                                                @if($label != 'Gross Earning')  <!-- Skip Gross Earning here -->
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
                                                                // Get the value for the payment head, skip Gross Earning
                                                                $value = ($payslip && isset($payslip[$label]) && $label != 'Gross Earning') 
                                                                            ? $payslip[$label] 
                                                                            : 0;
                                                                $total += $value;
                                                                $totalEarnings[$month] += $value;  // Sum to total earnings (excluding Gross Earnings)
                                                            @endphp
                                                            <td>{{ number_format($value, 0) }}</td>
                                                        @endforeach
                                                        <td>{{ number_format($total, 0) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            <!-- Total Earnings Row (Excluding Gross Earnings) -->
                                            <tr class="total-row earnings"style="background-color: #d4edda; color: #155724;">
                                                <td><strong>Total Earning</strong></td>
                                                @foreach ($months as $month => $monthName)
                                                    <td><strong>{{ number_format($totalEarnings[$month], 0) }}</strong></td>
                                                @endforeach
                                                <td><strong class="total-gross-amount">{{ number_format(array_sum($totalEarnings), 0) }}</strong></td>
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
                                                            
                                                            // Skip "Gross Deduction" from total summation
                                                            if ($label != 'Gross Deduction') {
                                                                $total += $value;
                                                                $totalDeductions[$month] += $value; // Summing for each month
                                                            } else {
                                                                // If it's Gross Deduction, we don't add it to the totalDeductions
                                                                $totalDeductions[$month] += 0;
                                                            }
                                                        @endphp
                                                        <td>{{ number_format($value, 0) }}</td>
                                                    @endforeach
                                                    <td>{{ number_format($total, 0) }}</td>
                                                </tr>
                                            @endforeach

                                            <!-- Total Deductions Row (Colored Red) -->
                                            <tr class="total-row deductions" style="background-color: #f8d7da; color: #721c24;">
                                                <td><strong>Total Deduction</strong></td>
                                                @foreach ($months as $month => $monthName)
                                                    <td><strong>{{ number_format($totalDeductions[$month], 0) }}</strong></td>
                                                @endforeach
                                                <td><strong>{{ number_format(array_sum($totalDeductions), 0) }}</strong></td>
                                            </tr>


                                            <!-- Net Amount Row (Colored Yellow) -->
                                            <!-- <tr class="net-amount-row" style="background-color: #fff3cd; color: #856404;">
                                                <td><strong>Net Amount</strong></td>
                                                @foreach ($months as $month => $monthName)
                                                    <td><strong>{{ number_format($totalEarnings[$month] - $totalDeductions[$month], 0) }}</strong></td>
                                                @endforeach
                                                <td><strong>{{ number_format(array_sum($totalEarnings) - array_sum($totalDeductions), 0) }}</strong></td>
                                            </tr> -->
                                            <!-- Net Amount Row (Colored Yellow) -->
                                    <tr class="net-amount-row" style="background-color: #fff3cd; color: #856404;">
                                        <td><strong>Net Amount</strong></td>
                                        @foreach ($months as $month => $monthName)
                                            <td><strong id="net-amount-{{ $month }}">{{ number_format($totalEarnings[$month] - $totalDeductions[$month], 0) }}</strong></td>
                                        @endforeach
                                        <td><strong class="total-net-amount">{{ number_format(array_sum($totalEarnings) - array_sum($totalDeductions), 0) }}</strong></td>
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
        // Find the closest employee table (assuming each arrow is within a table row)
        let employeeTable = arrow.closest('.employee-table');
        
        // Check if the table is already expanded (based on class)
        let isExpanded = employeeTable.classList.contains('expanded');
        
        // Toggle the expanded state by adding/removing the 'expanded' class
        if (isExpanded) {
            // Collapse the table: Remove the 'expanded' class and change the arrow to down
            employeeTable.classList.remove('expanded');
            arrow.querySelector('i').className = 'fas fa-arrow-circle-down'; // Change to down arrow

            // Hide all rows except gross earnings
            employeeTable.querySelectorAll('.earnings-row:not(.gross-earning), .deduction-row, .total-row, .net-amount-row').forEach(function (row) {
                row.style.display = 'none'; // Hide the rows
            });
        } else {
            // Expand the table: Add the 'expanded' class and change the arrow to up
            employeeTable.classList.add('expanded');
            arrow.querySelector('i').className = 'fas fa-arrow-circle-up'; // Change to up arrow

            // Show all rows
            employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row').forEach(function (row) {
                row.style.display = 'table-row'; // Show the rows
            });
        }
    });
});

});
// Initialize variables to sum the gross and net amounts
let totalNet = 0;
let totalGross = 0;

// Loop through each "total-net-amount" element to sum the net amounts
const totalNetAmounts = document.querySelectorAll('.total-net-amount');
totalNetAmounts.forEach(function (totalNetAmount) {
    const netAmount = parseFloat(totalNetAmount.textContent.replace(/,/g, ''));  // Get the total net amount for each employee and convert to float
    if (!isNaN(netAmount)) {  // Ensure the value is a valid number
        totalNet += netAmount;  // Add to the total net sum
    }
});

// Format the total net sum with commas for thousands and display it
document.getElementById('total-paid-amount').textContent = totalNet.toLocaleString();

// Loop through each "total-gross-amount" element to sum the gross amounts
const totalGrossAmounts = document.querySelectorAll('.total-gross-amount');
console.log(totalGrossAmounts);

totalGrossAmounts.forEach(function (totalGrossAmount) {
    const grossAmount = parseFloat(totalGrossAmount.textContent.replace(/,/g, ''));  // Get the total gross amount for each employee and convert to float
    if (!isNaN(grossAmount)) {  // Ensure the value is a valid number
        totalGross += grossAmount;  // Add to the total gross sum
    }
});

// Format the total gross sum with commas for thousands and display it
document.getElementById('salary-gross-amount').textContent = totalGross.toLocaleString();

document.addEventListener("DOMContentLoaded", function() {
    // Select all payment rows (excluding the gross earnings row)
    const paymentRows = document.querySelectorAll('.payment-head-details');

    // Loop through each row
    paymentRows.forEach(function(row) {
        let isRowEmpty = true;  // Flag to check if the row is empty (all months are zero)

        // Select the cells for months (skip the first and last columns)
        const monthCells = row.querySelectorAll('td:not(:first-child):not(:last-child)');

        // Loop through the month cells and check if any value is non-zero
        monthCells.forEach(function(cell) {
            const value = parseFloat(cell.textContent.replace(/,/g, '').trim()); // Convert to number after removing commas

            if (value !== 0) {
                isRowEmpty = false;  // If any cell is non-zero, mark the row as not empty
            }
        });

        // If the row is empty (all months are 0), hide the row
        if (isRowEmpty) {
            row.style.display = 'none';  // Hide the row
        }
    });
});

function toggleLoader() {
        document.getElementById('loader').style.display = 'block'; // Show the loader
    }

    // Optional: If you want to hide the loader after the page has loaded, 
    // you can use the following code.
    window.addEventListener('load', function() {
        document.getElementById('loader').style.display = 'none'; // Hide the loader after page load
    });

            
    </script>
		<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>
		<style>
    #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.spinner-border {
    width: 3rem;
    height: 3rem;
}



    </script>
    <style>
    #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.spinner-border {
    width: 3rem;
    height: 3rem;
}
</style>
    
