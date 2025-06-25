@include('employee.header')

<body class="mini-sidebar">
    @include('employee.sidebar')

    <div id="loader" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        @include('employee.head')

        <div class="main-content">
            <!-- Page Title Start -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-title-wrapper">
                        <div class="breadcrumb-list">
                            <ul>
                                <li class="breadcrumb-link">
                                    <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                </li>
                                <li class="breadcrumb-link active">My Team</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Start -->
            @include('employee.menuteam')

            <div class="mfh-machine-profile" style="position: relative;">
                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="queryTabs" role="tablist">
                    <li class="nav-item">
                        <a style="color: #0e0e0e;" id="salaryTab" class="nav-link active"
                            data-bs-toggle="tab" href="#salarySection" role="tab"
                            aria-controls="salarySection" aria-selected="true">Total with Salary</a>
                    </li>
                    <li class="nav-item">
                        <a style="color: #0e0e0e;" id="grossTab" class="nav-link"
                            data-bs-toggle="tab" href="#grossSection" role="tab"
                            aria-controls="grossSection" aria-selected="true">Total with Gross Salary
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="salarySection" role="tabpanel"
                        aria-labelledby="salaryTab">
                        <div class="row">
                            @if($isReviewer)
                            <div class="flex-shrink-0" style="float:right;">
                                <form method="GET" action="{{ route('teamcost') }}">
                                    @csrf
                                    <div class="form-check form-switch form-switch-right form-switch-md">
                                        <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2" style="float:right;">HOD/Reviewer</label>
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="hod_view"
                                            id="hod-view"
                                            {{ request()->has('hod_view') ? 'checked' : '' }}
                                            onchange="toggleLoader(); this.form.submit();">
                                    </div>
                                </form>
                            </div>
                            @endif
                            <div class="col mb-2">
                                <div class="cost-box">
                                    <h4>Total CTC
                                        <div class="float-end"><i class="fas fa-rupee-sign"></i> {{ formatToIndianRupees($ctcttotal, 0) }}</div>
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
                                            <h4 style="margin-bottom:10px;">
                                                {{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}
                                                <span class="float-end toggle-arrow"><i class="fas fa-arrow-circle-down"></i></span>
                                            </h4>

                                            <table class="table table-bordered">
                                                <thead style="display: none;"> <!-- Initially hidden -->
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

                                                    <!-- Gross Earnings Row -->
                                                    @php
                                                    $rowTotal = 0;
                                                    $rowValues = []; // Store row values for rendering
                                                    @endphp

                                                    @foreach ($months as $month => $monthName)
                                                    @php
                                                    $payslip = isset($groupedPayslips[$employee->EmployeeID])
                                                    ? $groupedPayslips[$employee->EmployeeID]->firstWhere('Month', $monthName)
                                                    : null;
                                                    $value = ($payslip && isset($payslip['Gross Earning'])) ? $payslip['Gross Earning'] : 0;

                                                    $rowTotal += $value;
                                                    $rowValues[] = $value; // Store value for the month
                                                    $totalEarnings[$month] += $value; // Accumulate totals for each month
                                                    @endphp
                                                    @endforeach

                                                    <!-- Render the Gross Earnings row -->
                                                    @if ($rowTotal > 0)
                                                    <tr class="payment-head-details gross-earning-row">
                                                        <td><strong>Gross Earning</strong></td>
                                                        @foreach ($rowValues as $value)
                                                        <td class="text-right">{{ formatToIndianRupees($value, 0) }}</td>
                                                        @endforeach
                                                        <td class="text-right"><strong>{{ formatToIndianRupees($rowTotal, 0) }}</strong></td>
                                                    </tr>
                                                    @endif

                                                    <!-- Other Payment Heads (Excluding Gross Earnings) -->
                                                    @foreach ($filteredPaymentHeads as $label => $column)
                                                    @if ($label != 'Gross Earning') <!-- Skip Gross Earning here -->
                                                    @php
                                                    $rowTotal = 0;
                                                    $rowValues = []; // Store row values for rendering
                                                    @endphp

                                                    @foreach ($months as $month => $monthName)
                                                    @php
                                                    $payslip = isset($groupedPayslips[$employee->EmployeeID])
                                                    ? $groupedPayslips[$employee->EmployeeID]->firstWhere('Month', $monthName)
                                                    : null;
                                                    $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;

                                                    $rowTotal += $value;
                                                    $rowValues[] = $value; // Store value for the month
                                                    $totalEarnings[$month] += $value; // Accumulate totals for each month
                                                    @endphp
                                                    @endforeach

                                                    <!-- Only render the row if the total for the row is greater than 0 -->
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

                                                    <!-- Total Earnings Row (Including Gross Earnings) -->
                                                    <tr class="total-row earnings" style="background-color: #d4edda; color: #155724;">
                                                        <td><strong>Total Earning</strong></td>
                                                        @foreach ($months as $month => $monthName)
                                                        <td class="text-right"><strong>{{ formatToIndianRupees($totalEarnings[$month], 0) }}</strong></td>
                                                        @endforeach
                                                        <td class="text-right"><strong class="total-gross-amount">{{ formatToIndianRupees(array_sum($totalEarnings), 0) }}</strong></td>
                                                    </tr>

                                                    <!-- Deduction Heads Rows -->
                                                    @foreach ($filteredDeductionHeads as $label => $column)
                                                    @php
                                                    $rowTotal = 0;
                                                    $rowValues = []; // Store row values for rendering
                                                    @endphp

                                                    @foreach ($months as $month => $monthName)
                                                    @php
                                                    $payslip = isset($groupedPayslips[$employee->EmployeeID])
                                                    ? $groupedPayslips[$employee->EmployeeID]->firstWhere('Month', $monthName)
                                                    : null;
                                                    $value = ($payslip && isset($payslip[$label])) ? $payslip[$label] : 0;

                                                    $rowTotal += $value;
                                                    $rowValues[] = $value; // Store value for the month
                                                    $totalDeductions[$month] += ($label != 'Gross Deduction') ? $value : 0; // Exclude "Gross Deduction" from summation
                                                    @endphp
                                                    @endforeach

                                                    <!-- Only render the row if the total for the row is greater than 0 -->
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

                                                    <!-- Total Deductions Row (Colored Red) -->
                                                    <tr class="total-row deductions" style="background-color: #f8d7da; color: #721c24;">
                                                        <td><strong>Total Deduction</strong></td>
                                                        @foreach ($months as $month => $monthName)
                                                        <td class="text-right"><strong>{{ formatToIndianRupees($totalDeductions[$month], 0) }}</strong></td>
                                                        @endforeach
                                                        <td class="text-right"><strong>{{ formatToIndianRupees(array_sum($totalDeductions), 0) }}</strong></td>
                                                    </tr>

                                                    <!-- Net Amount Row (Colored Yellow) -->
                                                    <tr class="net-amount-row" style="background-color: #fff3cd; color: #856404;">
                                                        <td><strong>Net Amount</strong></td>
                                                        @foreach ($months as $month => $monthName)
                                                        <td class="text-right"><strong id="net-amount-{{ $month }}">{{ formatToIndianRupees($totalEarnings[$month] - $totalDeductions[$month], 0) }}</strong></td>
                                                        @endforeach
                                                        <td class="text-right"><strong class="total-net-amount">{{ formatToIndianRupees(array_sum($totalEarnings) - array_sum($totalDeductions), 0) }}</strong></td>
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
                    <!-- Gross Section Tab -->
                    <div class="tab-pane fade" id="grossSection" role="tabpanel"
                        aria-labelledby="grossTab">
                        <div id="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('employee.footer')
    <?php
    function formatToIndianRupees($number)
    {
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
        document.addEventListener('DOMContentLoaded', function() {
            function hideEmptyRows() {
                // Loop through all employee tables
                document.querySelectorAll('.employee-table').forEach(function(employeeTable) {
                    // Loop through all payment rows (earnings, deductions, etc.)
                    employeeTable.querySelectorAll('.payment-head-details').forEach(function(paymentRow) {
                        let isEmpty = true;

                        // Check each month cell in the row (skip the first cell which is the label)
                        let monthCells = paymentRow.querySelectorAll('td:nth-child(n+2):nth-child(-n+13)');

                        monthCells.forEach(function(cell) {
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
            document.querySelectorAll('.employee-table').forEach(function(employeeTable) {
                let rows = employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row');

                rows.forEach(function(row) {
                    if (!row.classList.contains('gross-earning')) {
                        row.style.display = 'none'; // Hide rows except Gross Earning
                    }
                });

            });
            // Handle row expansion on arrow click
            document.querySelectorAll('.toggle-arrow').forEach(function(arrow) {
                arrow.addEventListener('click', function() {
                    // Find the closest employee table (assuming each arrow is within a table row)
                    let employeeTable = arrow.closest('.employee-table');

                    // Check if the table is already expanded (based on class)
                    let isExpanded = employeeTable.classList.contains('expanded');
                    let thead = employeeTable.querySelector('thead');

                    // Toggle the expanded state by adding/removing the 'expanded' class
                    if (isExpanded) {
                        // Collapse the table: Remove the 'expanded' class and change the arrow to down
                        employeeTable.classList.remove('expanded');
                        arrow.querySelector('i').className = 'fas fa-arrow-circle-down'; // Change to down arrow
                        thead.style.display = 'none'; // Hide thead


                        // Hide all rows except gross earnings
                        employeeTable.querySelectorAll('.earnings-row:not(.gross-earning), .deduction-row, .total-row, .net-amount-row').forEach(function(row) {
                            row.style.display = 'none'; // Hide the rows
                        });
                    } else {
                        // Expand the table: Add the 'expanded' class and change the arrow to up
                        employeeTable.classList.add('expanded');
                        arrow.querySelector('i').className = 'fas fa-arrow-circle-up'; // Change to up arrow
                        thead.style.display = 'table-header-group'; // Show thead

                        // Show all rows
                        employeeTable.querySelectorAll('.earnings-row, .deduction-row, .total-row, .net-amount-row').forEach(function(row) {
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
        totalNetAmounts.forEach(function(totalNetAmount) {
            const netAmount = parseFloat(totalNetAmount.textContent.replace(/,/g, '')); // Get the total net amount for each employee and convert to float
            if (!isNaN(netAmount)) { // Ensure the value is a valid number
                totalNet += netAmount; // Add to the total net sum
            }
        });

        // Format the total net sum with commas for thousands and display it
        document.getElementById('total-paid-amount').textContent = totalNet.toLocaleString();

        // Loop through each "total-gross-amount" element to sum the gross amounts
        const totalGrossAmounts = document.querySelectorAll('.total-gross-amount');
        console.log(totalGrossAmounts);

        totalGrossAmounts.forEach(function(totalGrossAmount) {
            const grossAmount = parseFloat(totalGrossAmount.textContent.replace(/,/g, '')); // Get the total gross amount for each employee and convert to float
            if (!isNaN(grossAmount)) { // Ensure the value is a valid number
                totalGross += grossAmount; // Add to the total gross sum
            }
        });

        // Format the total gross sum with commas for thousands and display it
        document.getElementById('salary-gross-amount').textContent = totalGross.toLocaleString();

        document.addEventListener("DOMContentLoaded", function() {
            // Select all payment rows (excluding the gross earnings row)
            const paymentRows = document.querySelectorAll('.payment-head-details');

            // Loop through each row
            paymentRows.forEach(function(row) {
                let isRowEmpty = true; // Flag to check if the row is empty (all months are zero)

                // Select the cells for months (skip the first and last columns)
                const monthCells = row.querySelectorAll('td:not(:first-child):not(:last-child)');

                // Loop through the month cells and check if any value is non-zero
                monthCells.forEach(function(cell) {
                    const value = parseFloat(cell.textContent.replace(/,/g, '').trim()); // Convert to number after removing commas

                    if (value !== 0) {
                        isRowEmpty = false; // If any cell is non-zero, mark the row as not empty
                    }
                });

                // If the row is empty (all months are 0), hide the row
                if (isRowEmpty) {
                    row.style.display = 'none'; // Hide the row
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

        document.addEventListener("DOMContentLoaded", () => {
            const data = @json($formattedTree);
            $('#chart-container').orgchart({
                data: data,
                nodeContent: 'desc', // will show team CTC under name by default
                direction: 't2b',
                pan: true,
                zoom: true,
                toggle: true,
                exportFilename: 'Team_Structure',
                visibleLevel: 2,
                depth: 2,
                createNode: function($node, data) {
                    // Inject self and team CTC manually into the node
                    const selfCtc = parseFloat((data.title ?? '0').replace(/[^0-9.]/g, '')).toLocaleString();
                    const teamCtc = parseFloat((data.desc ?? '0').replace(/[^0-9.]/g, '')).toLocaleString();

                    const hasChildren = data.children && data.children.length > 0;
                    // $node.find('.title').html(`${data.name}`);
                    const imageHtml = data.image ?
                        `<div class="node-img"><img src="${data.image}" alt="${data.name}" /></div>` :
                        '';
                    let contentHtml = `
                        ${imageHtml}
                        <div class="ctc-details"><strong>CTC: ₹<span style="color:#DC7937;"> ${selfCtc}</span></strong></div><br>
                        `;
                    if (hasChildren) {
                        contentHtml += `<div class="team-details"><strong>Team CTC: ₹<span style="color:#DC7937;"> ${teamCtc}</span></strong></div>`;
                    }
                    // Inject into .content
                    $node.find('.content').html(`
                        <div class="custom-ctc">${contentHtml}</div>
                        `);
                }
            });
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



        </script><style>#loader {
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

        #chart-container {
            display: flex;
            justify-content: center;
            overflow-x: auto;
            margin-top: 30px;
        }

        .orgchart {
            background: #fff;
            border: none;
        }

        .orgchart .node {
            width: 200px !important;
            /* Increased width */
        }

        .orgchart .node .title {
            font-size: 13px;
            font-weight: 500;
            background-color: #3c8c91;
            color: white;
            padding: 3px 10px;
            border-radius: 6px 6px 0 0;
            height: 25px !important;
        }

        .orgchart .node .content {
            font-size: 12px;
            background-color: #fdfdfd;
            border:1px solid #95bbbd;
            border-top: none;
            padding: 8px 5px;
            border-radius: 0 0 6px 6px;
            line-height: 1.4;
            height: 57px !important;
        }

        .orgchart .node .content div {
            margin-bottom: 4px;
        }

        .orgchart .custom-ctc {
            font-size: 12px;
            line-height: 1.4;
            padding: 4px 0;
            text-align: center;
        }

        .orgchart .custom-ctc .node-img {
            margin-bottom: 6px;
        }

        .orgchart .custom-ctc .node-img img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #87aaad;
        }
        .orgchart .lines .downLine{
background-color: rgb(73 139 144);
}

.orgchart .lines .topLine {
    border-top: 2px solid rgb(73 139 144);
}
.orgchart .lines .rightLine {
    border-right: 1px solid rgb(73 139 144);}
	
.orgchart .lines .leftLine {
    border-left: 1px solid rgb(73 139 144);}
.custom-ctc{
    width: 100%;float:left;
}
.custom-ctc .node-img{
    float: left;
}
.ctc-details{float:left;text-align: left;margin-left:5px;width:130px;font-size:11px;}
.team-details{float: left;text-align: left;margin-left:5px;width:130px;font-size:11px;}
    </style>