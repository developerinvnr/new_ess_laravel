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
                                    <li class="breadcrumb-link active">Salary</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">

                    <div class="col ">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d"
                                style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width: 50px;" src="./images/icons/salary-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">Salary</h5>
                                    <a href="{{route('salary')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Card-->
                    <div class="col ">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d"
                                style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/eligibility-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">Eligibility</h5>
                                    <a href="{{route('eligibility')}}"
                                        class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d"
                                style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/ctc-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">CTC</h5>
                                    <a href="{{route('ctc')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d"
                                style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/annual-salary.png">
                                    <h5 class="ad-title mt-3 mb-3">Annual Salary</h5>
                                    <a href="#annualsalary" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d"
                                style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/invetment.png">
                                    <h5 class="ad-title mt-3 mb-3">Invt. Declaration</h5>
                                    <a href="{{route('investment')}}"
                                        class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d"
                                style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/invetment-submit.png">
                                    <h5 class="ad-title mt-3 mb-3">Invt. Submission</h5>
                                    <a href="investment-submission.html"
                                        class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="card ad-info-card-">
                            <div class="card-header">
                                <h4 class="has-btn">Ledger</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center border-bottom-d" style="height: 142px;">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td><b>Ledger 2023-24</b></td>
                                            <td><a><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card chart-card">
                        <div class="card-header">
                            <div class="row w-100">
                                <!-- PaySlip Title on the Left -->
                                <div class="col-md-6 col-lg-7 mb-0">
                                    <h4 class="has-btn float-start">PaySlip <span id="currentYear" style="margin-left: 10px;"></span></h4>
                                    <br>
                                    <p class="card-desc">This is a confidential page not to be discussed openly with others.</p>
                                </div>

                                <!-- Select Month Dropdown in the Center -->
                                <div class="col-md-3 col-lg-2 mb-0 d-flex align-items-center">
                                    <select id="monthSelect" class="form-control w-100" style="display: inline-block;">
                                    <option value="">-- Month --</option>
                                        @foreach($payslipData as $payslip)
                                            @php
                                                $months = [
                                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                                ];
                                                $monthName = $months[$payslip->Month] ?? 'Unknown';
                                            @endphp
                                            <option value="{{ $payslip->MonthlyPaySlipId }}">{{ $monthName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Print Button on the Right -->
                                <div class="col-md-3 col-lg-3 mb-0 d-flex justify-content-end align-items-center">
                                    <a href="javascript:void(0)" onclick="printPayslip()" class="text-dark">
                                        <i style="font-size: 16px;" class="fa fa-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                            <div class="card-body table-responsive">
                                <div class="payslip-top-section">
                                    <div class="float-start">
                                        <img class="payslip-logo" alt="" src="./images/login-logo.png" />
                                    </div>
                                    <div class="">
                                        <h4>{{$salaryData->CompanyName}}</h4>
                                        <P>{{$salaryData->AdminOffice_Address}}</P>
                                        <p><span style="margin-right:20px;"><i class="fa fa-phone-alt mr-2"></i>
                                                {{$salaryData->PhoneNo1}}</span> <span><i
                                                    class="fa fa-envelope mr-2"></i> {{$salaryData->EmailId1}}</span>
                                        </p>
                                    </div>
                                </div>
                                <table class="table border payslip-table table-striped">
                                    <tbody>
                                        <tr>
                                            <td><b>Employee Code:</b></td>
                                            <td>{{$salaryData->EmpCode}}</td>
                                            <td><b>Name:</b></td>
                                            <td>{{ $salaryData->Fname ?? '' }} {{ $salaryData->Sname ?? '' }} {{ $salaryData->Lname ?? '' }}</td>
                                            </tr>
                                        <tr>
                                            <td>Costcenter:</td>
                                            <td>{{$salaryData->StateName}}</td>
                                            <td>Function</td>
                                            <td>{{$salaryData->FunName}}</td>
                                        </tr>
                                        <tr>
                                            <td>Grade:</td>
                                            <td>{{$salaryData->GradeValue}}</td>
                                            <td>Designation</td>
                                            <td>{{$salaryData->DesigName}}</td>
                                        </tr>
                                        <tr>
                                            <td>Headquarter:</td>
                                            <td>{{$salaryData->HqName}}</td>
                                            <td>Gender:</td>
                                            <td>{{$salaryData->Gender}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth:</td>
                                            <td>{{ \Carbon\Carbon::parse($salaryData->DOB)->format('d-m-y') }}</td>
                                            <td>Date of Joining:</td>
                                            <td>{{ \Carbon\Carbon::parse($salaryData->DateJoining)->format('d-m-y') }}</td>

                                        </tr>
                                        <tr>
                                            <td>Bank A/C No.:</td>
                                            <td>{{$salaryData->AccountNo}}</td>
                                            <td>Bank Name:</td>
                                            <td>{{$salaryData->BankName}}</td>
                                        </tr>
                                        <tr>
                                            <td>PF No.:</td>
                                            <td>{{$salaryData->PfAccountNo}}</td>
                                            <td>UAN NO.:</td>
                                            <td>{{$salaryData->PF_UAN}}</td>
                                        </tr>
                                        <tr>
                                            <td>PAN NO.:</td>
                                            <td>{{$salaryData->PanNo}}</td>
                                            <td>ESIC NO.:</td>
                                            <td>{{$salaryData->EsicNo}}</td>

                                        </tr>
                                        
                                        <!-- Default Month Data (e.g., current month) -->
                                        <tr id="totalDaysRow">
                                            <td>Total Days:</td>
                                            <td id="totalDays">{{$payslipDataMonth->TotalDay}}</td>
                                            <td>Paid Days</td>
                                            <td id="paidDays">{{$payslipDataMonth->PaidDay}}</td>
                                        </tr>
                                        <tr id="paymentModeRow">
                                            <!-- <td>Payment Mode:</td>
                                            <td id="paymentMode">Bank</td> -->
                                            <td>Absent</td>
                                            <td id="absentDays">{{$payslipDataMonth->Absent}}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Earnings & Deductions Table -->
                                <table class="table border">
                                    <tbody>
                                        <tr style="background-color:#c5d3c1;">
                                            <td colspan="2"><b>Earnings</b></td>
                                            <td colspan="2"><b>Deductions</b></td>
                                        </tr>
                                        <tr style="background-color:#f1f1f1;">
                                            <td><b>Components</b></td>
                                            <td><b>Amount</b></td>
                                            <td><b>Components</b></td>
                                            <td><b>Amount</b></td>
                                        </tr>
                                        <tr id="basicRow">
                                            <td>BASIC:</td>
                                            <td id="basicEarnings">{{$payslipDataMonth->Basic}}</td>
                                            <td>PROVIDENT FUND</td>
                                            <td id="providentFund">{{$payslipDataMonth->Tot_Pf}}</td>
                                        </tr>
                                        <tr id="hraRow">
                                            <td>HOUSE RENT ALLOWANCE:</td>
                                            <td id="hra">{{$payslipDataMonth->Hra}}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr id="bonusRow">
                                            <td>BONUS:</td>
                                            <td id="bonus">{{$payslipDataMonth->Bonus}}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr id="specialAllowanceRow">
                                            <td>SPECIAL ALLOWANCE:</td>
                                            <td id="specialAllowance">{{$payslipDataMonth->Special}}</td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr style="background-color:#c5d3c1;">
                                            <td><b>Total Earnings:</b></td>
                                            <td id="totalEarnings"><b>{{$payslipDataMonth->Tot_Gross}}</b></td>
                                            <td><b>Total Deductions:</b></td>
                                            <td id="totalDeductions"><b>{{$payslipDataMonth->Tot_Deduct}}</b></td>
                                        </tr>
                                        <tr id="netPayRow">
                                            <td colspan="4"><b style="color:#B70000;">Net Pay:</b> Rs. <span id="netPay">{{$payslipDataMonth->Tot_NetAmount}}</span>/-</td>
                                        </tr>
                                        <tr id="netPayWordsRow">
                                            <td colspan="4">
                                                <b style="color:#B70000;">In Words:</b> 
                                                <span id="netPayWords">Loading...</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                       <!-- Annual Salary Section (Right Side) -->
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
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
                                <td>{{ $label }}</td>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($months as $monthNumber => $monthName)
                                    <td>
                                        @php
                                            // Find the payslip entry for the given month
                                            $monthData = $payslipData->where('Month', $monthNumber)->first();
                                            $amount = $monthData && isset($monthData->$property) ? $monthData->$property : '-';
                                        @endphp
                                        {{ is_numeric($amount) ? number_format($amount, 2) : $amount }}
                                    </td>
                                @endforeach
                                <td><b>{{ number_format($total, 2) }}</b></td>
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