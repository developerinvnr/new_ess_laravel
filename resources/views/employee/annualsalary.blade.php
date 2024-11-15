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
        <!-- Header Start -->
        @include('employee.head')
        <!-- Sidebar Start -->
        @include('employee.sidebar')
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
                                        <a href="#"><i class="fas fa-home mr-2"></i>Home</a>
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
                            <div class="card-header">
                                <h4 class="has-btn">Annual Salary</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <table id="salaryTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <td><b>Payment Head</b></td>
                                            @foreach ($months as $monthNumber => $monthName)
                                                <td><b>{{ $monthName }}</b></td>
                                            @endforeach
                                            <td><b>Total</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentHeads as $label => $property)
                                            <tr>
                                                <td><b>{{ $label }}</b></td>
                                                @php
                                                    $total = 0; // Initialize the total for each row
                                                @endphp
                                                @foreach ($months as $monthNumber => $monthName)
                                                    <td>
                                                        @php
                                                            // Find the payslip entry for the given month
                                                            $monthData = $payslipData->where('Month', $monthNumber)->first();
                                                            $amount = $monthData && isset($monthData->$property) ? $monthData->$property : '-';

                                                            // If the amount is numeric, accumulate the total
                                                            if (is_numeric($amount)) {
                                                                $total += $amount; // Accumulate the amount to total
                                                            }
                                                        @endphp
                                                        {{ is_numeric($amount) ? number_format($amount, 2) : $amount }}
                                                    </td>
                                                @endforeach
                                                <td><b>{{ number_format($total, 2) }}</b></td> <!-- Display the total -->
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
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
    <script>
        window.payslipData = @json($payslipData);
    </script>
    <script src="{{ asset('../js/dynamicjs/salary.js/') }}" defer></script>