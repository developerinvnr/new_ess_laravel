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
                @if(count($groupedPayslips) > 0)

                    <!-- Loop through each employee and create a separate table -->
                    @foreach ($groupedPayslips as $employeeId => $employeePayslips)
                    @php
                        // Find the employee by EmployeeID in the employeeData collection
                        $employeename = $employeeData->firstWhere('EmployeeID', $employeeId);
                    @endphp
                    <div class="card chart-card" id="salary-details-{{ $employeeId }}">
                        <div class="card-header">
                            <h4 class="has-btn"><b>{{ $employeename->Fname }} {{ $employeename->Sname }} {{ $employeename->Lname }} - Team: Cost Details</b></h4>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="salaryTable-{{ $employeeId }}" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><b>Employee Name</b></th>
                                        <th><b>Payment Head</b></th>
                                        @foreach ($months as $monthNumber => $monthName)
                                            <th><b>{{ $monthName }}</b></th>
                                        @endforeach
                                        <th><b>Total</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentHeads as $headLabel => $headKey)
                                        @if ($headLabel === 'Gross Earning')  <!-- Ensure Gross Earning is visible -->
                                            <tr data-employee="{{ $employeeId }}" class="salary-row gross-earning">
                                                <td>
                                                    <b>{{ $employeename->Fname }} {{ $employeename->Sname }} {{ $employeename->Lname }}</b>
                                                    <span class="toggle-symbol" style="cursor: pointer; padding-left: 10px;">↓</span>
                                                </td>
                                                <td><b>{{ $headLabel }}</b></td>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                @foreach ($months as $monthNumber => $monthName)
                                                    @php
                                                        $monthData = $employeePayslips->firstWhere('Month', $monthNumber);
                                                        $amount = $monthData ? $monthData->$headKey : 0;
                                                        $total += $amount;
                                                    @endphp
                                                    <td>{{ number_format($amount, 2) }}</td>
                                                @endforeach
                                                <td><b>{{ number_format($total, 2) }}</b></td>
                                            </tr>
                                        @else
                                            <!-- Hide all rows except Gross Earning initially -->
                                            <tr data-employee="{{ $employeeId }}" class="salary-row" style="display: none;">
                                                <td></td>  <!-- Empty for non-Gross Earning rows -->
                                                <td><b>{{ $headLabel }}</b></td>
                                                @php
                                                    $total = 0;
                                                @endphp
                                                @foreach ($months as $monthNumber => $monthName)
                                                    @php
                                                        $monthData = $employeePayslips->firstWhere('Month', $monthNumber);
                                                        $amount = $monthData ? $monthData->$headKey : 0;
                                                        $total += $amount;
                                                    @endphp
                                                    <td>{{ number_format($amount, 2) }}</td>
                                                @endforeach
                                                <td><b>{{ number_format($total, 2) }}</b></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                    @else
                        <div class="alert alert-warning text-center">
                            No Team Cost Data found
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('employee.footer');
<script src="{{ asset('../js/dynamicjs/teamcost.js/') }}" defer></script>

