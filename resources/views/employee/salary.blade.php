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
        <!-- Header Start -->
        @include('employee.head')
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
                                    <li class="breadcrumb-link active">Salary</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')
                <div class="row">
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <div class="row w-100">
                                    <!-- PaySlip Title on the Left -->
                                    <div class="col-md-9 col-lg-9 mb-0">
                                        <!-- <h4 class="has-btn float-start">PaySlip <span id="currentYear"
                                                style="margin-left: 10px;"></span></h4>
                                        <br> -->
                                      
                                    </div>
                                    <!-- Select Month Dropdown in the Center -->
                                    <div class="col-md-3 col-lg-2 mb-0 d-flex align-items-center">
                                    <select id="monthSelect" class="form-control form-select w-100" style="display: inline-block;">
                                        <option value="">-- Month --</option>

                                        @php
                                            // Define the months array to map month numbers to month names
                                            $months = [
                                                1 => 'January',
                                                2 => 'February',
                                                3 => 'March',
                                                4 => 'April',
                                                5 => 'May',
                                                6 => 'June',
                                                7 => 'July',
                                                8 => 'August',
                                                9 => 'September',
                                                10 => 'October',
                                                11 => 'November',
                                                12 => 'December'
                                            ];

                                            // Create an array to track available months based on the payslip data
                                            $availableMonths = [];

                                            // Loop through the payslipData and collect months with available data
                                            foreach($payslipData as $payslip) {
                                                $availableMonths[$payslip->Month] = $payslip->MonthlyPaySlipId;
                                            }
                                        @endphp

                                        @foreach($months as $monthNumber => $monthName)
                                            @php
                                                // Check if the month is available in payslip data
                                                $monthlyPaySlipId = $availableMonths[$monthNumber] ?? 0;
                                                $year = isset($payslipData[0]->Year) ? $payslipData[0]->Year : 'Unknown Year'; // Assuming you have a Year in payslipData
                                            @endphp
                                            
                                            <!-- Display months from January to December, even if data is not available -->
                                            <option value="{{ $monthlyPaySlipId }}" 
                                                    @if ($monthlyPaySlipId != 0) 
                                                        data-status="available"
                                                    @else 
                                                        data-status="no-data"
                                                    @endif
                                            >
                                                {{ $monthName }} - {{ $year }}
                                                @if ($monthlyPaySlipId == 0) 
                                                   
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>

                                    </div>

                                    <!-- Print Button on the Right -->
                                    <div class="col-md-1 col-lg-1 mb-0 d-flex justify-content-end align-items-center">
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
                                        <h4>{{$salaryData->CompanyName ?? 'N/A'}}</h4>
                                        <P>{{$salaryData->AdminOffice_Address ?? 'N/A'}}</P>
                                        <p><span style="margin-right:20px;"><i class="fa fa-phone-alt mr-2"></i>
                                                {{$salaryData->PhoneNo1?? 'N/A'}}</span> <span><i
                                                    class="fa fa-envelope mr-2"></i> {{$salaryData->EmailId1 ?? 'N/A'}}</span>
                                        </p>
                                        <p>Payslip for the month of <b style="color:red;">[<span id="selectedMonth"></span>]</b style="color:red;"></p>

                                    </div>
                                </div>
                                <table class="table border payslip-table table-striped">
                                    <tbody>
                                        <tr>
                                            <td><b>Employee Code:</b></td>
                                            <td>{{$salaryData->EmpCode?? 'N/A'}}</td>
                                            <td><b>Name:</b></td>
                                            <td>{{ $salaryData->Fname ?? '' }} {{ $salaryData->Sname ?? '' }}
                                                {{ $salaryData->Lname ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Costcenter:</td>
                                            <td>{{$salaryData->city_village_name ?? 'N/A'}}</td>
                                            <td>Function</td>
                                            <td>{{$functionName ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Grade:</td>
                                            <td>{{$salaryData->grade_name ?? 'N/A'}}</td>
                                            <td>Designation</td>
                                            <td>{{$salaryData->designation_name ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Headquarter:</td>
                                            <td>{{$salaryData->city_village_name ?? 'N/A'}}</td>
                                            <td>Gender:</td>
                                            <td>{{$salaryData->Gender ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Date of Birth:</td>
                                            <td>
                                                {{ !empty($salaryData->DOB) && \Carbon\Carbon::parse($salaryData->DOB)->isValid() ? \Carbon\Carbon::parse($salaryData->DOB)->format('d-m-Y') : 'N/A' }}
                                            </td>
                                            <td>Date of Joining:</td>
                                            <td>
                                                {{ !empty($salaryData->DateJoining) && \Carbon\Carbon::parse($salaryData->DateJoining)->isValid() ? \Carbon\Carbon::parse($salaryData->DateJoining)->format('d-m-Y') : 'N/A' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Bank A/C No.:</td>
                                            <td>{{$salaryData->AccountNo?? 'N/A'}}</td>
                                            <td>Bank Name:</td>
                                            <td>{{$salaryData->BankName?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>PF No.:</td>
                                            <td>{{$salaryData->PfAccountNo?? 'N/A'}}</td>
                                            <td>UAN NO.:</td>
                                            <td>{{$salaryData->PF_UAN?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td>PAN NO.:</td>
                                            <td>{{$salaryData->PanNo?? 'N/A'}}</td>
                                            @if($salaryData->EsicNo)
                                            <td>ESIC NO.:</td>
                                            <td>{{$salaryData->EsicNo?? 'N/A'}}</td>
                                            @endif

                                        </tr>

                                        <!-- Default Month Data (e.g., current month) -->
                                        <tr id="totalDaysRow">
                                            <td>Total Days:</td>
                                            <td id="totalDays">{{$payslipDataMonth->TotalDay?? 'N/A'}}</td>
                                            <td>Working Days</td>
                                            <td id="workingdays">26</td>
                                        </tr>
                                        <tr>
                                            <td>Paid days:</td>
                                            <td id="paiddays">26</td>

                                            
                                        </tr>
                                        
                                    </tbody>
                                </table>

                             <!-- Earnings & Deductions Table -->
                             <table class="table border">
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="width:50%;padding:0px;vertical-align: top;">
                                            <table class="table" style="margin-bottom: 0px;">
                                                <tbody>
                                                    <tr style="background-color:#c5d3c1; text-align: center;font-weight: bold;padding: 10px;">
                                                        <td colspan="3"><b>Earnings</b></td>
                                                    </tr>
                                                    <tr style="background-color:#f1f1f1;">
                                                        <td><b>Components</b></td>
                                                        <td style="text-align:right;"><b>Amount</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr id="basicRow">
                                                        <td>BASIC:</td>
                                                        <td id="basicEarnings" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                                                    <tr id="hraRow">
                                                        <td>HOUSE RENT ALLOWANCE:</td>
                                                        <td id="hra" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                                                    <tr id="bonusRow">
                                                        <td>BONUS:</td>
                                                        <td id="bonus" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                                                
                                                    <tr id="specialAllowanceRow">
                                                        <td>SPECIAL ALLOWANCE:</td>
                                                        <td id="specialAllowance" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                                                    
                                                    <tr id="conveyanceRow">
                                                        <td>CONVEYANCE ALLOWANCE:</td>
                                                        <td id="conveyanceAllowance" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="transportRow">
                                                        <td>TRANSPORT ALLOWANCE:</td>
                                                        <td id="transportAllowance" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="daRow">
                                                        <td>DA:</td>
                                                        <td id="da" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="leaveEncashRow">
                                                        <td>LEAVE ENCASH:</td>
                                                        <td id="leaveEncash" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearsRow">
                                                        <td>ARREARS:</td>
                                                        <td id="arrears"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="incentiveRow">
                                                        <td>INCENTIVE:</td>
                                                        <td id="incentive" class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="variableAdjustmentRow">
                                                        <td>VARIABLE ADJUSTMENT:</td>
                                                        <td id="variableAdjustment"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="performancePayRow">
                                                        <td>PERFORMANCE PAY:</td>
                                                        <td id="performancePay"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="npsRow">
                                                        <td>NATIONAL PENSION SCHEME:</td>
                                                        <td id="nps"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="noticePayRow">
                                                        <td>NOTICE PAY:</td>
                                                        <td id="noticePay"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="performanceIncentiveRow">
                                                        <td>PERFORMANCE INCENTIVE:</td>
                                                        <td id="performanceIncentive"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="cityCompensatoryAllowanceRow">
                                                        <td>CITY COMPENSATORY ALLOWANCE:</td>
                                                        <td id="cityCompensatoryAllowance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="relocationAllowanceRow">
                                                        <td>RELOCATION ALLOWANCE:</td>
                                                        <td id="relocationAllowance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="variableReimbursementRow">
                                                        <td>VARIABLE REIMBURSEMENT:</td>
                                                        <td id="variableReimbursement"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="carAllowanceRow">
                                                        <td>CAR ALLOWANCE:</td>
                                                        <td id="carAllowance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearCarAllowanceRow">
                                                        <td>ARREAR FOR CAR ALLOWANCE:</td>
                                                        <td id="arrearCarAllowance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearBasicRow">
                                                        <td>ARREAR FOR BASIC:</td>
                                                        <td id="arrearBasic"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearHraRow">
                                                        <td>ARREAR FOR HOUSE RENT ALLOWANCE:</td>
                                                        <td id="arrearHra"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearSpecialAllowanceRow">
                                                        <td>ARREAR FOR SPECIAL ALLOWANCE:</td>
                                                        <td id="arrearSpecialAllowance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearConveyanceRow">
                                                        <td>ARREAR FOR CONVEYANCE:</td>
                                                        <td id="arrearConveyance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearBonusRow">
                                                        <td>ARREAR FOR BONUS:</td>
                                                        <td id="arrearBonus"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="bonusAdjustmentRow">
                                                        <td>BONUS ADJUSTMENT:</td>
                                                        <td id="bonusAdjustment"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearLtaReimbursementRow">
                                                        <td>ARREAR FOR LTA REIMBU:</td>
                                                        <td id="arrearLtaReimbursement"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearRelocationAllowanceRow">
                                                        <td>ARREAR FOR RELOCATION ALLOWANCE:</td>
                                                        <td id="arrearRelocationAllowance"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearPerformancePayRow">
                                                        <td>ARREAR FOR PERFORMANCE PAY:</td>
                                                        <td id="arrearPerformancePay"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                    
                                                    <tr id="arrearLvEncashRow">
                                                        <td>ARREAR FOR LV-ENCASH:</td>
                                                        <td id="arrearLvEncash"class="text-right"></td>
                                                        <td class="vertical-line"></td>  <!-- This is the vertical line column -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td colspan="2" style="width:50%;vertical-align: baseline;padding:0px;">
                                            <table class="table" style="marging-bottom:0px;">
                                                <tbody>
                                                    <tr style="background-color:#c5d3c1; text-align: center;font-weight: bold;padding: 10px;">
                                                        <td colspan="2"><b>Deductions</b></td>
                                                    </tr>
                                                    <tr style="background-color:#f1f1f1;">
                                                        <td><b>Components</b></td>
                                                        <td style="text-align:right;"><b>Amount</b></td>
                                                    </tr>
                                                    <tr id="providentFundRow">
                                                        <td>PROVIDENT FUND:</td>
                                                        <td id="providentFund"class="text-right"></td>
                                                    </tr>
                                                    
                                                    <tr id="tdsRow">
                                                        <td>TDS:</td>
                                                        <td id="tds"class="text-right"></td>
                                                    </tr>
                                                    <tr id="esicRow">
                                                        <td>ESIC:</td>
                                                        <td id="esic"class="text-right"></td>
                                                    </tr>
                                                
                                                    <tr id="npsContributionRow">
                                                        <td>NPS CONTRIBUTION:</td>
                                                        <td id="npsContribution"class="text-right"></td>
                                                    </tr>
                                                    
                                                    <tr id="arrearPfRow">
                                                        <td>ARREAR PF:</td>
                                                        <td id="arrearPf"class="text-right"></td>
                                                    </tr>
                    
                                                    <tr id="arrearEsicRow">
                                                        <td>ARREAR ESIC:</td>
                                                        <td id="arrearEsic"class="text-right"></td>
                                                    </tr>
                    
                                                    <tr id="voluntaryContributionRow">
                                                        <td>VOLUNTARY CONTRIBUTION:</td>
                                                        <td id="voluntaryContribution"class="text-right"></td>
                                                    </tr>
                    
                                                    <tr id="deductionAdjustmentRow">
                                                        <td>DEDUCTION ADJUSTMENT:</td>
                                                         <td id="deductionAdjustment"class="text-right"></td>
                                                    </tr>
                    
                                                    <tr id="recoveryConveyanceAllowanceRow">
                                                        <td>RECOVERY CONVEYANCE ALLOWANCE:</td>
                                                        <td id="recoveryConveyanceAllowance"class="text-right"></td>
                                                    </tr>
                    
                                                    <tr id="relocationAllowanceRecoveryRow">
                                                        <td>RELOCATION ALLOWANCE RECOVERY:</td>
                                                        <td id="relocationAllowanceRecovery"class="text-right"></td>
                                                    </tr>
                    
                                                    <tr id="recoverySpecialAllowanceRow">
                                                        <td>RECOVERY SPECIAL ALLOWANCE:</td>
                                                         <td id="recoverySpecialAllowance"class="text-right"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr style="background-color:#c5d3c1;">
                                        <td><b>Total Earnings:</b></td>
                                        <td id="totalEarnings" class="text-right"><b>{{$payslipDataMonth->Tot_Gross?? 'N/A'}}</b></td>
                                        <td class="vertical-line" style="width:3%;"></td>  <!-- This is the vertical line column -->
                                        <td><b>Total Deductions:</b></td>
                                        <td id="totalDeductions" class="text-right"><b>{{$payslipDataMonth->Tot_Deduct?? 'N/A'}}</b></td>
                                    </tr>
                                    <tr id="netPayRow">
                                        <td colspan="5"><b style="color:#B70000;">Net Pay:</b> <b>Rs. <span id="netPay">{{$payslipDataMonth->Tot_NetAmount?? 'N/A'}}</span>/-</b></td>
                                    </tr>
                                    <tr id="netPayWordsRow">
                                        <td colspan="5">
                                            <b style="color:#B70000;">In Words:</b>
                                            <b><span id="netPayWords"></span></b>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                  
                        <p class="card-desc"><b>Strictly Confidential:
                                    </b>Sharing with others may lead to consequences for breaching confidentiality.</p>

                            </div>
                           
                        </div>
                       
                    </div>

                </div>
          

                @include('employee.footerbottom')
            </div>
        </div>
    </div>
    

        <!-- Password Verification Modal -->
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordModalLabel">Password Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="passwordForm">
                            @csrf
                            <div class="form-group">
                                <label for="password">Enter your login password:</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="submitPassword">Submit</button>
                        <button type="button" class="btn btn-secondary btn-close-down"  data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="modal-backdrop fade show"></div> -->


    @include('employee.footer')
    <script>
        window.payslipData = @json($payslipData);
    </script>
    
    
    <script src="{{ asset('../js/dynamicjs/salary.js/') }}" defer></script>