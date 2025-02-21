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
                                            @foreach($payslipData as $payslip)
                                                @php
                                                    // Map the numeric month to the abbreviation (e.g., 1 => 'JAN', 2 => 'FEB')
                                                    $monthAbbreviation = array_search($payslip->Month, $monthMapping) ?? 'Unknown Month'; // Get the month abbreviation

                                                    // If the month is DECM, display DEC
                                                    if ($monthAbbreviation == 'DECM') {
                                                        $monthAbbreviation = 'DEC';
                                                    }
                                                @endphp
                                                <option value="{{ $payslip->MonthlyPaySlipId }}">
                                                    {{ $monthAbbreviation }} - {{ $payslip->Year }}
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
                                <div class="payslip-top-section" style="margin-bottom: 15px;border-bottom: 1px solid #f1ebeb;padding-bottom: 15px;float:left;width:100%;">
                                    <div class="float-start" style="float:left;">
                                        <img style="border-right:3px solid #f7a40c;margin-right: 30px;padding-right: 20px;width:100px;" class="payslip-logo" alt="" src="./images/login-logo.png" />
                                    </div>
                                    <div style="float:left;">
                                        <h4 style="margin-bottom:5px;">{{$salaryData->CompanyName ?? 'N/A'}}</h4>
                                        <P style="margin-top: 0px;">{{$salaryData->AdminOffice_Address ?? 'N/A'}}<br>
                                        <p><span style="margin-right:20px;"><b>Phone No.</b>
                                                {{$salaryData->PhoneNo1?? 'N/A'}}</span> <span><b>Email ID</b> {{$salaryData->EmailId1 ?? 'N/A'}}</span>
                                                <br>
                                                <b>Payslip for the month of <b style="color:red;">[<span id="selectedMonth"></span>]</b></b></p>

                                    </div>
                                </div>
                                <table class="table border payslip-table table-striped" style="border:2px solid #888;">
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;width:20%;">Employee Code:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;width:30%;">{{$salaryData->EmpCode?? 'N/A'}}</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;width:20%;">Name:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;width:30%;">{{ $salaryData->Fname ?? '' }} {{ $salaryData->Sname ?? '' }}
                                                {{ $salaryData->Lname ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #ddd;">Costcenter:</td>
                                            <td style="border:1px solid #ddd;" id="hq"></td>
                                            <td style="border:1px solid #ddd;">Function:</td>
                                            <td style="border:1px solid #ddd;">{{$functionName ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">Grade:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;" id="grade"></td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">Designation:</td>
                                            <!-- <td style="background-color:#eceff2;border:1px solid #ddd;">{{$salaryData->designation_name ?? 'N/A'}}</td> -->
                                            <td style="background-color:#eceff2;border:1px solid #ddd;"id="designation"></td>

                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #ddd;">Headquarter:</td>
                                            <td style="border:1px solid #ddd;" id="headQ"></td>
                                            <td style="border:1px solid #ddd;">Gender:</td>
                                            <td style="border:1px solid #ddd;">{{$salaryData->Gender ?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">Date of Birth:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">
                                                {{ !empty($salaryData->DOB) && \Carbon\Carbon::parse($salaryData->DOB)->isValid() ? \Carbon\Carbon::parse($salaryData->DOB)->format('d-m-Y') : 'N/A' }}
                                            </td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">Date of Joining:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">
                                                {{ !empty($salaryData->DateJoining) && \Carbon\Carbon::parse($salaryData->DateJoining)->isValid() ? \Carbon\Carbon::parse($salaryData->DateJoining)->format('d-m-Y') : 'N/A' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="border:1px solid #ddd;">Bank A/C No.:</td>
                                            <td style="border:1px solid #ddd;">{{$salaryData->AccountNo?? 'N/A'}}</td>
                                            <td style="border:1px solid #ddd;">Bank Name:</td>
                                            <td style="border:1px solid #ddd;">{{$salaryData->BankName?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">PF No.:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">{{$salaryData->PfAccountNo?? 'N/A'}}</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">UAN No.:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">{{$salaryData->PF_UAN?? 'N/A'}}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #ddd;">PAN No.:</td>
                                            <td style="border:1px solid #ddd;">{{$salaryData->PanNo?? 'N/A'}}</td>
                                            @if($salaryData->EsicNo)
                                            <td style="border:1px solid #ddd;">ESIC No.:</td>
                                            <td style="border:1px solid #ddd;">{{$salaryData->EsicNo?? 'N/A'}}</td>
                                            @endif

                                        </tr>

                                        <!-- Default Month Data (e.g., current month) -->
                                        <tr id="totalDaysRow">
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">Total Days:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;" id="totalDays">{{$payslipDataMonth->TotalDay?? 'N/A'}}</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;">Working Days:</td>
                                            <td style="background-color:#eceff2;border:1px solid #ddd;" id="workingdays">26</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #ddd;">Paid days:</td>
                                            <td style="border:1px solid #ddd;" id="paiddays">26</td>
                                        </tr>
                                    </tbody>
                                </table>

                             <!-- Earnings & Deductions Table -->
                             <table class="table border" style="margin-top:15px;border:2px solid #888;">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="width:50%;padding:0px;vertical-align: top;border:1px solid #ddd;">
                                            <table class="table" style="margin-bottom: 0px;border:1px solid #ddd;">
                                                <tbody>
                                                    <tr style="background-color:#c5d3c1; text-align: center;font-weight: bold;padding: 10px;">
                                                        <td style="border:2px solid #888;" colspan="2"><b>Earnings</b></td>
                                                    </tr>
                                                    <tr style="background-color:#f1f1f1;">
                                                        <td style="border:2px solid #888;"><b>Components</b></td>
                                                        <td style="text-align:right;border:2px solid #888;" class="vertical-line"><b>Amount</b></td>
                                                    </tr>
                                                    <tr id="basicRow">
                                                        <td style="border:1px solid #ddd;">BASIC:</td>
                                                        <td id="basicEarnings" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                    <tr id="hraRow">
                                                        <td style="border:1px solid #ddd;">HOUSE RENT ALLOWANCE:</td>
                                                        <td id="hra" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                    <tr id="bonusRow">
                                                        <td style="border:1px solid #ddd;">BONUS:</td>
                                                        <td id="bonus" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                
                                                    <tr id="specialAllowanceRow">
                                                        <td style="border:1px solid #ddd;">SPECIAL ALLOWANCE:</td>
                                                        <td id="specialAllowance" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                    
                                                    <tr id="conveyanceRow">
                                                        <td style="border:1px solid #ddd;">CONVEYANCE ALLOWANCE:</td>
                                                        <td id="conveyanceAllowance" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="transportRow">
                                                        <td style="border:1px solid #ddd;">TRANSPORT ALLOWANCE:</td>
                                                        <td id="transportAllowance" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="daRow">
                                                        <td style="border:1px solid #ddd;">DA:</td>
                                                        <td id="da" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="leaveEncashRow">
                                                        <td style="border:1px solid #ddd;">LEAVE ENCASH:</td>
                                                        <td id="leaveEncash" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearsRow">
                                                        <td style="border:1px solid #ddd;">ARREARS:</td>
                                                        <td id="arrears" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="incentiveRow">
                                                        <td style="border:1px solid #ddd;">INCENTIVE:</td>
                                                        <td id="incentive" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="variableAdjustmentRow">
                                                        <td style="border:1px solid #ddd;">VARIABLE ADJUSTMENT:</td>
                                                        <td id="variableAdjustment" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="performancePayRow">
                                                        <td style="border:1px solid #ddd;">PERFORMANCE PAY:</td>
                                                        <td id="performancePay" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="npsRow">
                                                        <td style="border:1px solid #ddd;">NATIONAL PENSION SCHEME:</td>
                                                        <td id="nps" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="noticePayRow">
                                                        <td style="border:1px solid #ddd;">NOTICE PAY:</td>
                                                        <td id="noticePay" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="performanceIncentiveRow">
                                                        <td style="border:1px solid #ddd;">PERFORMANCE INCENTIVE:</td>
                                                        <td id="performanceIncentive" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="cityCompensatoryAllowanceRow">
                                                        <td style="border:1px solid #ddd;">CITY COMPENSATORY ALLOWANCE:</td>
                                                        <td id="cityCompensatoryAllowance" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="relocationAllowanceRow">
                                                        <td style="border:1px solid #ddd;">RELOCATION ALLOWANCE:</td>
                                                        <td id="relocationAllowance" class="vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="variableReimbursementRow">
                                                        <td style="border:1px solid #ddd;">VARIABLE REIMBURSEMENT:</td>
                                                        <td id="variableReimbursement" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="carAllowanceRow">
                                                        <td style="border:1px solid #ddd;">CAR ALLOWANCE:</td>
                                                        <td id="carAllowance" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearCarAllowanceRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR CAR ALLOWANCE:</td>
                                                        <td id="arrearCarAllowance" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearBasicRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR BASIC:</td>
                                                        <td id="arrearBasic" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearHraRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR HOUSE RENT ALLOWANCE:</td>
                                                        <td id="arrearHra" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearSpecialAllowanceRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR SPECIAL ALLOWANCE:</td>
                                                        <td id="arrearSpecialAllowance" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearConveyanceRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR CONVEYANCE:</td>
                                                        <td id="arrearConveyance" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearBonusRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR BONUS:</td>
                                                        <td id="arrearBonus" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="bonusAdjustmentRow">
                                                        <td style="border:1px solid #ddd;">BONUS ADJUSTMENT:</td>
                                                        <td id="bonusAdjustment" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearLtaReimbursementRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR LTA REIMBU:</td>
                                                        <td id="arrearLtaReimbursement" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearRelocationAllowanceRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR RELOCATION ALLOWANCE:</td>
                                                        <td id="arrearRelocationAllowance" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearPerformancePayRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR PERFORMANCE PAY:</td>
                                                        <td id="arrearPerformancePay" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearLvEncashRow">
                                                        <td style="border:1px solid #ddd;">ARREAR FOR LV-ENCASH:</td>
                                                        <td id="arrearLvEncash" class="text-right vertical-line" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td colspan="2" style="width:50%;vertical-align: baseline;padding:0px;border:1px solid #ddd;">
                                            <table class="table" style="marging-bottom:0px;">
                                                <tbody>
                                                    <tr style="background-color:#c5d3c1; text-align: center;font-weight: bold;padding: 10px;">
                                                        <td style="border:2px solid #888;" colspan="2"><b>Deductions</b></td>
                                                    </tr>
                                                    <tr style="background-color:#f1f1f1;">
                                                        <td style="border:2px solid #888;"><b>Components</b></td>
                                                        <td style="text-align:right;border:2px solid #888;"><b>Amount</b></td>
                                                    </tr>
                                                    <tr id="providentFundRow">
                                                        <td style="border:1px solid #ddd;">PROVIDENT FUND:</td>
                                                        <td id="providentFund" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                    
                                                    <tr id="tdsRow">
                                                        <td style="border:1px solid #ddd;">TDS:</td>
                                                        <td id="tds" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                    <tr id="esicRow">
                                                        <td style="border:1px solid #ddd;">ESIC:</td>
                                                        <td id="esic" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                
                                                    <tr id="npsContributionRow">
                                                        <td style="border:1px solid #ddd;">NPS CONTRIBUTION:</td>
                                                        <td id="npsContribution" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                    
                                                    <tr id="arrearPfRow">
                                                        <td style="border:1px solid #ddd;">ARREAR PF:</td>
                                                        <td id="arrearPf" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="arrearEsicRow">
                                                        <td style="border:1px solid #ddd;">ARREAR ESIC:</td>
                                                        <td id="arrearEsic" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="voluntaryContributionRow">
                                                        <td style="border:1px solid #ddd;">VOLUNTARY CONTRIBUTION:</td>
                                                        <td id="voluntaryContribution" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="deductionAdjustmentRow">
                                                        <td style="border:1px solid #ddd;">DEDUCTION ADJUSTMENT:</td>
                                                         <td id="deductionAdjustment" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="recoveryConveyanceAllowanceRow">
                                                        <td style="border:1px solid #ddd;">RECOVERY CONVEYANCE ALLOWANCE:</td>
                                                        <td id="recoveryConveyanceAllowance" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="relocationAllowanceRecoveryRow">
                                                        <td style="border:1px solid #ddd;">RELOCATION ALLOWANCE RECOVERY:</td>
                                                        <td id="relocationAllowanceRecovery" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                    
                                                    <tr id="recoverySpecialAllowanceRow">
                                                        <td style="border:1px solid #ddd;">RECOVERY SPECIAL ALLOWANCE:</td>
                                                         <td id="recoverySpecialAllowance" class="text-right" style="border:1px solid #ddd;text-align:right;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr style="background-color:#c5d3c1;">
                                        <td style="border:2px solid #888;border-right:2px solid #c6d3c1;"><b>Total Earnings:</b></td>
                                        <td id="totalEarnings" class="vertical-line" style="border:2px solid #888;text-align:right;"><b>{{$payslipDataMonth->Tot_Gross?? 'N/A'}}</b></td>
                                        
                                        <td style="border:2px solid #888;border-right:2px solid #c6d3c1;"><b>Total Deductions:</b></td>
                                        <td id="totalDeductions" style="border:2px solid #888;text-align:right;"><b>{{$payslipDataMonth->Tot_Deduct?? 'N/A'}}</b></td>
                                    </tr>
                                    <tr id="netPayRow">
                                        <td colspan="4" style="border:2px solid #888;"><b style="color:#B70000;">Net Pay:</b> <b>Rs. <span id="netPay">{{$payslipDataMonth->Tot_NetAmount?? 'N/A'}}</span>/-</b></td>
                                    </tr>
                                    <tr id="netPayWordsRow">
                                        <td colspan="4" style="border:2px solid #888;">
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