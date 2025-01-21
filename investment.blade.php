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
                                    <li class="breadcrumb-link active">Taxation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')

                <!-- Master Tab Structure -->
                <div class="mfh-machine-profile" style="position: relative;">
                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="investmentTab" role="tablist">
                    <!-- Investment Declaration Tab -->
                    <li class="nav-item">
                        <a style="color: #0e0e0e;" class="nav-link active" id="investmentdeclaration-tab" data-bs-toggle="tab"
                            href="#investmentdeclaration" role="tab" aria-controls="investmentdeclaration"
                            aria-selected="true">Investment Declaration</a>
                    </li>
                    @if($employeeData && $employeeData->OpenYN == 'Y')
                                                                       
                    <!-- Investment Submission Tab -->
                    <li class="nav-item">
                        <a style="color: #0e0e0e;" class="nav-link" id="investmentsubmission-tab" data-bs-toggle="tab"
                            href="#investmentsubmission" role="tab" aria-controls="investmentsubmission"
                            aria-selected="false">Investment Submission</a>
                    </li>
                    @endif
                </ul>

                <div class="tab-content mt-3" id="investmentTabContent">
                    <!-- Investment Declaration Block -->
                    <div class="tab-pane fade active show" id="investmentdeclaration" role="tabpanel">
                        <div class="row">
                        
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
                                <div class="card chart-card ">
                                    <div class="card-header" id="attendance">
                                        <h4 class="text-center" id="investment-title"></h4>
                                    </div>
                                    <div class="card-body" style="padding-top:0px;">
                                        <div class="mfh-machine-profile">
                                            <div style="float:left;width:300px;">
                                            <div class="float-start me-3 mt-2">
                                                    <input type="radio" name="Regime" class="me-2 float-start" style="margin-top:-5px;" onclick="showTab('oldregime')" checked> Old Regime
                                                </div>
                                                <div class="float-start me-3 mt-2">
                                                    <input type="radio" name="Regime" class="me-2 float-start" style="margin-top:-5px;" onclick="showTab('newregime')"> New Regime
                                                </div>

                                        </div><br><br>
                                            <!--<ul class="nav nav-tabs" id="myTab1" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="oldregime-tab1" data-bs-toggle="tab"
                                                        href="#oldregime" role="tab" aria-controls="OldRegime"
                                                        aria-selected="true">Old Regime</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="newregime-tab20" data-bs-toggle="tab"
                                                        href="#newregime" role="tab" aria-controls="newregime"
                                                        aria-selected="false">New Regime</a>
                                                </li>
                                            </ul>-->
                                            <div class="tab-content splash-content2 mt-3" id="myTabContent2">
                                                <div class="regim-panel tab-pane fade active table-responsive show" id="oldregime"
                                                    role="tabpanel">
                                                    <ul class="user-details">
                                                        <li>Employee Code: {{$employeeData->EmpCode ?? ''}}</li>
                                                        <li>Employee Name: {{ $employeeData->Fname ?? '' }}
                                                            {{ $employeeData->Sname ?? '' }}
                                                            {{ $employeeData->Lname ?? '' }}
                                                        </li>
                                                        <li>PAN Number: {{$employeeData->PanNo ?? 'N/A'}}</li>
                                                        <li>Company Name: {{$employeeData->CompanyName ?? 'N/A'}}</li>
                                                    </ul>
                                                    <br>
                                                    <p><b>Please remember the following points while filling up the
                                                            form</b></p>
                                                    <ol style="color: #686464;">
                                                        <li>Do not forget to mention you Employee Code , Name & Pan card .
                                                        </li>
                                                        <li>Only Submission Amount needs to be filled. Do not change the
                                                            figures mentioned in Max. limit Column.</li>
                                                        <li> You are requested to submit the required proofs up to last
                                                            date of submission, failing which will be assumed that the
                                                            employee does not have any Tax </li>
                                                        <li>Saving and income other than salary, and the Income Tax will
                                                            be recomputed and tax will be deducted accordingly.</li>
                                                    </ol>
                                                    <p><b>(To be used to declare investment for income Tax that will be
                                                            made during the period )</b></p><br>
                                                            <p><b>Deduction Under Section 10</b></p>
                                                        <button type="button" class="btn btn-secondary" id="print-button"style="float:right;">
                                                            <i class="fa fa-print"></i> <!-- Font Awesome print icon -->
                                                        </button>
                                                    <form id="investment-form" method="POST"
                                                        action="{{ route('save.investment.declaration') }}">
                                                        @csrf

                                                        <input type="hidden" name="selected_regime" id="selected-regime"
                                                            value="">
                                                        <input type="hidden" name="period" id="period" value="">
                                                        <input type="hidden" name="c_month" id="c_month" value="{{ $employeeData && isset($employeeData->C_Month) ? $employeeData->C_Month : '' }}">

                                                        <input type="hidden" name="y_id" id="y_id" value="{{ optional($employeeData)->C_YearId ?? '' }}">
                                                        <input type="hidden" name="empcode" id="empcode" value="{{ optional($employeeData)->EmpCode ?? '' }}">


                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              <!-- House Rent Section -->
                                                                        <tr>
                                                                            <td>House Rent Sec 10(13A)</td>
                                                                            <td>I am staying in a house and I agree to submit rent receipts when required. The Rent paid is (Rs._______ Per Month) & the house is located in Non-Metro</td>
                                                                            <td></td>
                                                                            <td>
                                                                                <input type="number"
                                                                                    name="house_rent_declared_amount"
                                                                                    value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}"
                                                                                    @if(isset($investmentDeclaration->HRA)) disabled @endif>
                                                                            </td>
                                                                        </tr>

                                                                        <!-- LTA Section -->
                                                                        <tr>
                                                                            <td>LTA Sec 10(5)</td>
                                                                            <td>I will provide the tickets/ Travel bills in original as per one basic annually the LTA policy or else the company can consider amount as taxable.</td>
                                                                            <td><b>{{$LTA}}</b>
                                                                                <input id="lta-checkbox" name="lta_checkbox"
                                                                                    style="float:right;height: 15px;"
                                                                                    type="checkbox"
                                                                                    @if(isset($investmentDeclaration->Curr_LTA)) checked @endif
                                                                                    @if(isset($investmentDeclaration->Curr_LTA)) disabled @endif>
                                                                            </td>
                                                                            <td>
                                                                                <input id="lta-amount"
                                                                                    name="lta_declared_amount" type="number"
                                                                                    class="form-control"
                                                                                    value="{{ isset($investmentDeclaration->Curr_LTA) ? $investmentDeclaration->Curr_LTA : '' }}"
                                                                                    @if(isset($investmentDeclaration->Curr_LTA)) disabled @endif>
                                                                            </td>
                                                                        </tr>

                                                                      <!-- CEA Section -->
                                                                        <tr>
                                                                            <td>CEA Sec 10(14)</td>
                                                                            <td>I will provide the copy of tuition fees receipt as per CEA policy or else the company can consider amount as taxable. (Rs.100/- per month per child up to a max of two children)</td>
                                                                            <td><b>2400/-</b>
                                                                                <br>Child-1
                                                                                <input id="child1-checkbox"
                                                                                    name="child1_checkbox"
                                                                                    style="float:right;height: 15px;"
                                                                                    type="checkbox"
                                                                                    @if(isset($investmentDeclaration->Child1_CEA)) checked @endif
                                                                                    @if(isset($investmentDeclaration->Child1_CEA)) disabled @endif>
                                                                                Child-2
                                                                                <input id="child2-checkbox"
                                                                                    name="child2_checkbox"
                                                                                    style="float:right;height: 15px;"
                                                                                    type="checkbox"
                                                                                    @if(isset($investmentDeclaration->Child2_CEA)) checked @endif
                                                                                    @if(isset($investmentDeclaration->Child2_CEA)) disabled @endif>
                                                                            </td>
                                                                            <td>
                                                                                <input id="cea-amount" name="cea_declared_amount" type="number" class="form-control"
                                                                                    value="{{ optional($investmentDeclaration)->Curr_CEA ?? '' }}"
                                                                                    @if(isset($investmentDeclaration->Curr_CEA)) disabled @endif>
                                                                            </td>
                                                                        </tr>


                                                            </tbody>
                                                        </table>

                                                        <p style="color: #686464;">** If you have opted for the medical
                                                            reimbursements (being Medical expenses part of your CTC)</p>
                                                        <br>

                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Deductions Under Chapter VI A</td>
                                                                    <td>Sec.80D - Medical Insurance Premium (If the
                                                                        policy covers a senior Citizen then additional
                                                                        deduction of Rs.5000/- is available & deduction
                                                                        on account of expenditure on preventive Health
                                                                        Check-Up (for Self, Spouse, Dependant Children &
                                                                        Parents) Shall not exceed in the aggregate Rs
                                                                        5000/-.)</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->MIP_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="medical_insurance" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->MIP ?? '' }}">
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec. 80DD - Medical treatment/insurance of
                                                                        Handicapped Dependant A higher deduction of Rs.
                                                                        100,000 is available, where such dependent is
                                                                        with severe disability of > 80%</td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->MTI_Limit,0)}}/-</b></td>
                                                                        <td>
                                                                            <input name="medical_treatment_handicapped" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->MTI ?? '' }}">
                                                                        </td>

                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec 80DDB - Medical treatment (specified
                                                                        diseases only) (medical treatment in respect of
                                                                        a senior Citizen then additional deduction of
                                                                        Rs.20,000/- is available)</td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->MTS_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="medical_treatment_disease" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->MTS ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec 80E - Repayment of Loan for higher education
                                                                        (only interest)</td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->ROL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="loan_repayment" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ROL ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec 80U - Handicapped</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->Handi_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="handicapped_deduction" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->Handi ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Deduction Under Section 80C</td>
                                                                    <td>Sec 80CCC - Contribution to Pension Fund (Jeevan
                                                                        Suraksha)</td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->PenFun_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="pension_fund_contribution" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->PenFun ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Life Insurance Premium</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->LIP_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="life_insurance" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->LIP ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Deferred Annuity</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input name="deferred_annuity" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->DA ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Public Provident Fund</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->PPF_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="ppf" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->PPF ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Time Deposit in Post Office / Bank for 5 year &
                                                                        above</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->PostOff_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="PostOff" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>ULIP of UTI/LIC</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->ULIP_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="ulip" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Principal Loan (Housing Loan) Repayment</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->HL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="housing_loan_repayment" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->HL ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Mutual Funds</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->MF_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                    <input name="mutual_funds" type="number" 
                                                                        value="{{ optional($investmentDeclaration)->MF ?? '' }}">
                                                                </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Investment in infrastructure Bonds</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->MF_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="infrastructure_bonds" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IB ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Children- Tuitions Fee restricted to max. of 2
                                                                        children</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input name="tuition_fee" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->CTF ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Deposit in NHB</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->NHB_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="deposit_in_nhb" type="number" 
                                                                            value="{{ isset($investmentDeclaration->NHB) ? $investmentDeclaration->NHB : '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Deposit In NSC</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->NSC_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="deposit_in_nsc" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->NSC ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sukanya Samriddhi</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->SukS_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="sukanya_samriddhi" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->SukS ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Others (please specify) Employee Provident Fund
                                                                    </td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->EPF_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="others_employee_provident_fund" type="number" 
                                                                            value="{{ optional($investmentDeclaration)->EPF ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td> Sec. 80CCD(1B)</td>
                                                                    <td>NPS (National Pension Scheme)/ Atal Pension Yojna(APY)</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->EPF_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="apy" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->NPS ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                               
                                                            
                                                            </tbody>
                                                            
                                                                <tr>
                                                                    <td> Sec. 80CCD(2)	</td>
                                                                    <td> Corporate NPS Scheme</td>
                                                                    <td><b>10% Of Basic Salary</b></td>
                                                                    <td>
                                                                            <input name="cornps" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>  Previous Employment Salary (Salary earened from 01/04/12 till date of joining)	</td>
                                                                    <td> If yes, Form 16 from previous employer or Form 12 B with tax computation statement</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                            <input name="form16limit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->Form16 ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>  Salary paid by the Previous Employer after Sec.10 Exemption	</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->SPE_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="spelimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->SPE ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>   PROFESSIOAL TAX deducted by the Previous Employer		</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->PT_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="ptlimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->PT ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td> PROVIDENT FUND deducted by the Previous Employer			</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->PFD_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="pfdlimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->PFD ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>   INCOME TAX deducted by the Previous Employer			</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->IT_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="itlimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IT ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> Income other then Salary Income	 </td>
                                                                    <td>   If yes, then Form 12C detailing other income is attached(only interest)		</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                            <input name="" type="number" >
                                                                        </td>
                                                                    

                                                                </tr>
                                                               
                                                            
                                                        </table>
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>  Deduction under Section 24	</td>
                                                                    <td> Interest on Housing Loan	</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->IHL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="ihl" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IHL ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>  Interest if the loan is taken before 01/04/99	</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->IL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="il" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IL ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                               
                                                            
                                                            </tbody>
                                                            
                                                            
                                                        </table>

                                                        <p><b>Declaration:</b></p>
                                                        <ol>
                                                            <li>I hereby declare that the information given above is
                                                                correct and true in all respects.</li>
                                                            <li>I also undertake to indemnify the company for any
                                                                loss/liability that may arise in the event of the above
                                                                information being incorrect.</li>
                                                        </ol>

                                                        <div class="row">
                                                        <div class="col-md-12 mt-4 mb-3">
                                                            <div class="float-start">
                                                                <label for="date"><b>Date:</b></label>
                                                                <input type="date" id="date" name="date" 
                                                                    value="{{ isset($investmentDeclaration->SubmittedDate) ? $investmentDeclaration->SubmittedDate : now()->format('Y-m-d') }}"><br><br>

                                                                <label for="place"><b>Place:</b></label>
                                                                <input type="text" id="place" name="place"
                                                                    value="{{ isset($investmentDeclaration->Place) ? $investmentDeclaration->Place : '' }}"><br><br>
                                                            </div>
                                                            <div class="float-end mt-3">
                                                                <b>Signature</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="Period" name="Period" value="{{$PrdCurr}}"  readonly/>
                                                    <input type="hidden" id="C_month" name="C_month" value="{{$setting->C_Month}}"  readonly/>



                                                            <!-- Edit and Reset Buttons -->
                                                            <div class="form-group text-center">
                                                                <!-- <button type="submit" class="btn btn-primary" id="submit-button" 
                                                                    @if(empty($employeeData->OpenYN) || $employeeData->OpenYN != 'Y') disabled @endif>
                                                                    Edit
                                                                </button>

                                                                <button type="reset" class="btn btn-secondary" 
                                                                    @if(empty($employeeData->OpenYN) || $employeeData->OpenYN != 'Y') disabled @endif>
                                                                    Reset
                                                                </button> -->
                                                                <button type="button" class="btn btn-primary" id="edit-button">
                                                                   
                                                                Edit
                                                            </button>

                                                            <button type="submit" class="btn btn-secondary" id="submit-button-in"
                                                                @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                    disabled
                                                                @endif>
                                                            Submit
                                                        </button>
                                                            </div>


                                                       <!-- Toast Container -->
                                                            <div id="messageContainer" class="toast-container" style="display: none;">
                                                                <div id="successMessage" class="toast-message"></div>
                                                            </div>


                                                    </form>
                                                </div>
                                                <div class="regim-panel tab-pane  fade" id="newregime" role="tabpanel">
                                                <ul class="user-details">
                                                    <li>Employee Code: {{ optional($employeeData)->EmpCode ?? 'N/A' }}</li>
                                                    <li>Employee Name: 
                                                        {{ optional($employeeData)->Fname ?? '' }} 
                                                        {{ optional($employeeData)->Sname ?? '' }} 
                                                        {{ optional($employeeData)->Lname ?? '' }}
                                                    </li>
                                                    <li>PAN Number: {{ optional($employeeData)->PanNo ?? 'N/A' }}</li>
                                                    <li>Company Name: {{ optional($employeeData)->CompanyName ?? 'N/A' }}</li>
                                                </ul>

                                                    <br>
                                                    <p style="color:black;"><b>Please remember the following points while filling up the
                                                            form</b></p>
                                                    <ol style="color: #686464;">
                                                        <li>Do not forget to mention you Employee Code , Name & Pan card .
                                                        </li>
                                                        <li>Only Submission Amount needs to be filled. Do not change the
                                                            figures mentioned in Max. limit Column.</li>
                                                        <li> You are requested to submit the required proofs up to last
                                                            date of submission, failing which will be assumed that the
                                                            employee does not have any Tax </li>
                                                        <li>Saving and income other than salary, and the Income Tax will
                                                            be recomputed and tax will be deducted accordingly.</li>
                                                    </ol>
                                                    <p><b>(To be used to declare investment for income Tax that will be
                                                            made during the period )</b></p><br>
                                                    <p><b>Deduction Under Section 10</b></p>
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Item</th>
                                                                <th>Particulars</th>
                                                                <th style="width: 7%;">Max. Limit</th>
                                                                <th style="width: 14%;">Declared Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Sec. 80CCD(2)</td>
                                                                <td>Corporate NPS Scheme</td>
                                                                <td>10% Of Basic Salary</td>
                                                                <td><input type="text"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p><b>Declaration:</b></p>
                                                    <ol>
                                                        <li>I hereby declare that the information given above is correct
                                                            and true in all respects.</li>
                                                        <li>I also undertake to indemnify the company for any
                                                            loss/liability that may arise in the event of the above
                                                            information being incorrect.</li>
                                                    </ol>
                                                    <div class="row">
                                                        <div class="col-md-12 mt-4 mb-3">
                                                            <div class="float-start">
                                                                <b>Date:</b> 15 Feb 2024<br> <br><b>Place:</b> Raipur
                                                            </div>
                                                            <div class="float-end mt-3">
                                                                <b>Signature</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('employee.footerbottom')

                        </div>
                    </div>

                    <!-- Investment Submission Block -->
                    <div class="tab-pane fade" id="investmentsubmission" role="tabpanel">
                       
                        <!-- Revanue Status Start -->
                        <div class="row">
                        <div id="messageContainer" style="display: none;">
                                                        <p id="successMessage"></p>
                                                    </div>
                            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10">
                                <div class="card chart-card ">
                                    <!-- <div class="card-header" id="attendance">
                                        <h4 class="text-center" id="investment-title"></h4>
                                    </div> -->
                                    <div class="card-body" style="padding-top:0px;">
                                        <div class="mfh-machine-profile">
                                        <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                        
                                        <div class="row">
                                        @if(($investmentDeclaration->Regime ?? 'old') == 'old')
                                        <!-- Display "Old Regime" Title -->
                                                    <h5 class="ad-title mb-0" style="padding:10px;">Old Regime</h5>
                                                    
                                                    <!-- Old Regime Content -->
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade active show" id="oldregime" role="tabpanel" aria-labelledby="oldregime-tab1">
                                                        <div class="tab-pane fade active table-responsive show" id="oldregime"
                                                    role="tabpanel">
                                                    <ul class="user-details">
                                                        <li>Employee ID: {{$employeeData->EmpCode ?? ''}}</li>
                                                        <li>Employee Name: {{ $employeeData->Fname ?? '' }}
                                                            {{ $employeeData->Sname ?? '' }}
                                                            {{ $employeeData->Lname ?? '' }}
                                                        </li>
                                                        <li>PAN Number: {{$employeeData->PanNo ?? 'N/A'}}</li>
                                                        <li>Company Name:{{$employeeData->CompanyName ?? 'N/A'}}</li>
                                                    </ul>
                                                    <br>
                                                    <p><b>Please remember the following points while filling up the
                                                            form</b></p>
                                                    <ol style="color: #686464;">
                                                        <li>Do not forget to mention you Employee Id , Name & Pan card .
                                                        </li>
                                                        <li>Only Submission Amount needs to be filled. Do not change the
                                                            figures mentioned in Max. limit Column.</li>
                                                        <li> You are requested to submit the required proofs up to last
                                                            date of submission, failing which will be assumed that the
                                                            employee does not have any Tax </li>
                                                        <li>Saving and income other than salary, and the Income Tax will
                                                            be recomputed and tax will be deducted accordingly.</li>
                                                    </ol>
                                                    <p><b>(To be used to declare investment for income Tax that will be
                                                            made during the period )</b></p><br>
                                                    <p><b>Deduction Under Section 10</b></p>

                                                    <form id="investment-form-submission" method="POST"
                                                    
                                                        action="{{ route('save.investment.submission') }}">
                                                        @csrf
                                                        
                                                        <input type="hidden" name="selected_regime" id="selected-regime"
                                                            value="">
                                                        <input type="hidden" name="period_sub" id="period_sub" value="">
                                                        <input type="hidden" name="c_month" id="c_month" 
                                                            value="{{ isset($employeeData) && isset($employeeData->C_Month) ? $employeeData->C_Month : '' }}">

                                                        <input type="hidden" name="y_id" id="y_id" 
                                                            value="{{ isset($employeeData) && isset($employeeData->C_YearId) ? $employeeData->C_YearId : '' }}">

                                                        <input type="hidden" name="empcode" id="empcode" 
                                                            value="{{ isset($employeeData) && isset($employeeData->EmpCode) ? $employeeData->EmpCode : '' }}">

                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submitted Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- House Rent Section -->
                                                                <tr>
                                                                    <td>House Rent Sec 10(13A)</td>
                                                                    <td>I am staying in a house and I agree to submit
                                                                        rent receipts when required. The Rent paid is
                                                                        (Rs._______ Per Month) & the house is located in
                                                                        Non-Metro</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input type="number" readonly
                                                                            value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}" reandoly>
                                                                    </td>
                                                                     <td>
                                                                        <input type="number"
                                                                            name="house_rent_declared_amount"
                                                                            value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}" reandoly>
                                                                    </td>
                                                                </tr>

                                                                <!-- LTA Section -->
                                                                <tr>
                                                                    <td>LTA Sec 10(5)</td>
                                                                    <td>I will provide the tickets/ Travel bills in
                                                                        original as per one basic annually the LTA
                                                                        policy or else the company can consider amount
                                                                        as taxable.</td>
                                                                    <td><b>{{$LTA}}</b>
                                                                        <input id="lta-checkbox" name="lta_checkbox"
                                                                            style="float:right;height: 15px;"
                                                                            type="checkbox" reandoly
                                                                            @if(isset($investmentDeclaration->Curr_LTA))
                                                                            checked @endif>
                                                                    </td>
                                                                    <td>
                                                                        <input id="lta-amount"
                                                                            type="number"
                                                                            class="form-control" reandoly
                                                                            value="{{ isset($investmentDeclaration->Curr_LTA) ? $investmentDeclaration->Curr_LTA : '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input id="lta-amount"
                                                                            name="lta_declared_amount" type="number"
                                                                            class="form-control"
                                                                            value="{{ isset($investmentDeclaration->Curr_LTA) ? $investmentDeclaration->Curr_LTA : '' }}">
                                                                    </td>
                                                                </tr>


                                                                <!-- CEA Section -->
                                                                <tr>
                                                                    <td>CEA Sec 10(14)</td>
                                                                    <td>I will provide the copy of tuition fees receipt
                                                                        as per CEA policy or else the company can
                                                                        consider amount as taxable. (Rs.100/- per month
                                                                        per child up to a max of two children)</td>
                                                                    <td><b>2400/-</b>
                                                                        <br>Child-1
                                                                        <input id="child1-checkbox"
                                                                            name="child1_checkbox"
                                                                            style="float:right;height: 15px;"
                                                                            type="checkbox" reandoly>
                                                                        Child-2
                                                                        <input id="child2-checkbox"
                                                                            name="child2_checkbox"
                                                                            style="float:right;height: 15px;"
                                                                            type="checkbox" reandoly >
                                                                    </td>
                                                                    <td>
                                                                        <input id="cea-amount" type="number"
                                                                            class="form-control" readonly
                                                                            value="{{ optional($investmentDeclaration)->Curr_CEA ?? '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input id="cea-amount"
                                                                            name="cea_declared_amount" type="number"
                                                                            class="form-control"
                                                                            value="{{ optional($investmentDeclaration)->Curr_CEA ?? '' }}">
                                                                    </td>

                                                                </tr>

                                                            </tbody>
                                                        </table>

                                                        <p style="color: #686464;">** If you have opted for the medical
                                                            reimbursements (being Medical expenses part of your CTC)</p>
                                                        <br>

                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submitted Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Deductions Under Chapter VI A</td>
                                                                    <td>Sec.80D - Medical Insurance Premium (If the
                                                                        policy covers a senior Citizen then additional
                                                                        deduction of Rs.5000/- is available & deduction
                                                                        on account of expenditure on preventive Health
                                                                        Check-Up (for Self, Spouse, Dependant Children &
                                                                        Parents) Shall not exceed in the aggregate Rs
                                                                        5000/-.)</td>
                                                                    <td><b>25000/-</b></td>
                                                                    <td>
                                                                        <input type="number"
                                                                            value="{{ optional($investmentDeclaration)->MIP ?? '' }}" readonly>
                                                                    </td>
                                                                     <td>
                                                                        <input name="medical_insurance" type="number"
                                                                            value="{{ optional($investmentDeclaration)->MIP ?? '' }}">
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec. 80DD - Medical treatment/insurance of
                                                                        Handicapped Dependant A higher deduction of Rs.
                                                                        100,000 is available, where such dependent is
                                                                        with severe disability of > 80%</td>
                                                                    <td><b>50000/-</b></td>
                                                                    <td>
                                                                        <input
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->MTI ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="medical_treatment_handicapped"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->MTI ?? '' }}">
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec 80DDB - Medical treatment (specified
                                                                        diseases only) (medical treatment in respect of
                                                                        a senior Citizen then additional deduction of
                                                                        Rs.20,000/- is available)</td>
                                                                    <td><b>40000/-</b></td>
                                                                    <td>
                                                                            <input 
                                                                                type="number"
                                                                                value="{{ optional($investmentDeclaration)->MTS ?? '' }}" readonly>
                                                                        </td>
                                                                         <td>
                                                                            <input name="medical_treatment_disease"
                                                                                type="number"
                                                                                value="{{ optional($investmentDeclaration)->MTS ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec 80E - Repayment of Loan for higher education
                                                                        (only interest)</td>
                                                                    <td>-</td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->ROL ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="loan_repayment"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->ROL ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sec 80U - Handicapped</td>
                                                                    <td><b>50000/-</b></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->Handi ?? '' }}" readonly>
                                                                    </td>
                                                                     <td>
                                                                        <input name="handicapped_deduction"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->Handi ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submitted Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Deduction Under Section 80C</td>
                                                                    <td>Sec 80CCC - Contribution to Pension Fund (Jeevan
                                                                        Suraksha)</td>
                                                                    <td><b>25000/-</b></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->PenFun ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="pension_fund_contribution"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->PenFun ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Life Insurance Premium</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->LIP ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="life_insurance"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->LIP ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Deferred Annuity</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->DA ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="deferred_annuity"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->DA ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Public Provident Fund</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->PPF ?? '' }}" readonly>
                                                                    </td>
                                                                     <td>
                                                                        <input name="ppf"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->PPF ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Time Deposit in Post Office / Bank for 5 year &
                                                                        above</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="PostOff" 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>ULIP of UTI/LIC</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                     <td>
                                                                        <input name="PostOff" 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}" 
                                                                            >
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Principal Loan (Housing Loan) Repayment</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->HL ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="housing_loan_repayment"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->HL ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Mutual Funds</td>
                                                                    <td></td>
                                                                    <td>
                                                                            <input 
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclaration)->MF ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="mutual_funds" 
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclaration)->MF ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Investment in infrastructure Bonds</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->IB ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="infrastructure_bonds" 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->IB ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Children- Tuitions Fee restricted to max. of 2
                                                                        children</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->CTF ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                     <td>
                                                                        <input name="tuition_fee" 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->CTF ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Deposit in NHB</td>
                                                                    <td></td>
                                                                    <td>
                                                                    <input 
                                                                        type="number" 
                                                                        value="{{ optional($investmentDeclaration)->NHB ?? '' }}" 
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input name="deposit_in_nhb" 
                                                                        type="number" 
                                                                        value="{{ optional($investmentDeclaration)->NHB ?? '' }}" 
                                                                        readonly>
                                                                </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Deposit In NSC</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->NSC ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="deposit_in_nsc" 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->NSC ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Sukanya Samriddhi</td>
                                                                    <td></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->SukS ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="sukanya_samriddhi" 
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->SukS ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td>Others (please specify) Employee Provident Fund
                                                                    </td>
                                                                    <td></td>
                                                                    <td>
                                                                <input 
                                                                    type="number" 
                                                                    value="{{ optional($investmentDeclaration)->EPF ?? '' }}" 
                                                                    readonly>
                                                            </td>
                                                             <td>
                                                                <input name="others_employee_provident_fund" 
                                                                    type="number" 
                                                                    value="{{ optional($investmentDeclaration)->EPF ?? '' }}" 
                                                                    >
                                                            </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                        
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submitted Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                     <td> Sec. 80CCD(1B)</td>
                                                                    <td>NPS (National Pension Scheme)/ Atal Pension Yojna(APY)</td>
                                                                    <td><b>50000/-</b></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->NPS ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="apy"
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->NPS ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td> Sec. 80CCD(2)	</td>
                                                                    <td> Corporate NPS Scheme</td>
                                                                    <td><b>10% Of Basic Salary</b></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                            <input name="cornps" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                <td>  Previous Employment Salary (Salary earened from 01/04/12 till date of joining)	</td>
                                                                    <td> If yes, Form 16 from previous employer or Form 12 B with tax computation statement</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->Form16 ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                            <input name="form16limit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->Form16 ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                   <td> </td>
                                                                    <td>  Salary paid by the Previous Employer after Sec.10 Exemption	</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                        <input
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->SPE ?? '' }}" readonly>
                                                                    </td>
                                                                    <td>
                                                                            <input name="spelimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->SPE ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>   PROFESSIOAL TAX deducted by the Previous Employer		</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                        <input
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->PT ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                            <input name="ptlimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->PT ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td> PROVIDENT FUND deducted by the Previous Employer			</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                        <input
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclaration)->PFD ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                            <input name="pfdlimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->PFD ?? '' }}">
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                <td> </td>
                                                                    <td>   INCOME TAX deducted by the Previous Employer			</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                        <input 
                                                                            type="number"
                                                                            value="{{ optional($investmentDeclaration)->IT ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                            <input name="itlimit" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IT ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                <td> Income other then Salary Income	 </td>
                                                                    <td>   If yes, then Form 12C detailing other income is attached(only interest)		</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                            <input 
                                                                                type="number" 
                                                                                 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="" type="number" >
                                                                        </td>

                                                              
                                                            </tbody>
                                                        </table>
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submitted Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>  Deduction under Section 24	</td>
                                                                    <td> Interest on Housing Loan	</td>
                                                                    <td><b>200000/-</b></td>
                                                                    <td>
                                                                            <input type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IHL ?? '' }}"readonly>
                                                                        </td>
                                                                    <td>
                                                                            <input name="ihl" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IHL ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>  Interest if the loan is taken before 01/04/99	</td>
                                                                    <td><b>30000/-</b></td>
                                                                    <td>
                                                                            <input type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IL ?? '' }}"readonly>
                                                                        </td>
                                                                    <td>
                                                                            <input name="il" type="number" 
                                                                                value="{{ optional($investmentDeclaration)->IL ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                               
                                                            
                                                            </tbody>
                                                            
                                                            
                                                        </table>

                                                        <p><b>Declaration:</b></p>
                                                        <ol>
                                                            <li>I hereby declare that the information given above is
                                                                correct and true in all respects.</li>
                                                            <li>I also undertake to indemnify the company for any
                                                                loss/liability that may arise in the event of the above
                                                                information being incorrect.</li>
                                                        </ol>

                                                        <div class="row">
                                                        <div class="col-md-12 mt-4 mb-3">
                                                            <div class="float-start">
                                                                <label for="date"><b>Date:</b></label>
                                                                <input type="date" id="date" name="date" 
                                                                    value="{{ isset($investmentDeclaration->SubmittedDate) ? $investmentDeclaration->SubmittedDate : now()->format('Y-m-d') }}" readonly><br><br>

                                                                <label for="place"><b>Place:</b></label>
                                                                <input type="text" id="place" name="place"
                                                                    value="{{ isset($investmentDeclaration->Place) ? $investmentDeclaration->Place : '' }}" readonly><br><br>
                                                            </div>
                                                            <div class="float-end mt-3">
                                                                <b>Signature</b>
                                                            </div>
                                                        </div>
                                                    </div>

                                                        <!-- submit and Reset Buttons -->
                                                        <div class="form-group text-center">
                                                        <button type="submit" class="btn btn-primary" id="edit-button-sub"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Edit
                                                            </button>

                                                            <button type="reset" class="btn btn-secondary" id="submit-button-sub"
                                                                @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                    disabled
                                                                @endif>
                                                            Submit
                                                        </button>

                                                        </div>
                                                        <div id="messageContainersub" style="display: none;">
                                                        <p id="successMessagesub"></p>
                                                    </div>
                                                    </form>
                                                </div>                                                        </div>
                                                    </div>
                                                
                                                    @elseif($investmentDeclaration->Regime == 'new')
                                                    <!-- Display "New Regime" Title -->
                                                    <h5 class="ad-title mb-0" style="padding:10px;">New Regime</h5>

                                                    <!-- New Regime Content -->
                                                    <div class="tab-content">
                                                        <div class="tab-pane fade active show" id="newregime" role="tabpanel" aria-labelledby="newregime-tab20">
                                                        <div class="tab-pane fade" id="newregime" role="tabpanel">
                                                    <ul class="user-details">
                                                        <li>Employee ID: {{$employeeData->EmpCode}}</li>
                                                        <li>Employee Name: {{ $employeeData->Fname ?? '' }}
                                                            {{ $employeeData->Sname ?? '' }}
                                                            {{ $employeeData->Lname ?? '' }}
                                                        </li>
                                                        <li>PAN Number: {{$employeeData->PanNo ?? 'N/A'}}</li>
                                                        <li>Company Name:{{$employeeData->CompanyName ?? 'N/A'}}</li>
                                                    </ul>
                                                    <br>
                                                    <p><b>Please remember the following points while filling up the
                                                            form</b></p>
                                                    <ol style="color: #686464;">
                                                        <li>Do not forget to mention you Employee Id , Name & Pan card .
                                                        </li>
                                                        <li>Only Submission Amount needs to be filled. Do not change the
                                                            figures mentioned in Max. limit Column.</li>
                                                        <li> You are requested to submit the required proofs up to last
                                                            date of submission, failing which will be assumed that the
                                                            employee does not have any Tax </li>
                                                        <li>Saving and income other than salary, and the Income Tax will
                                                            be recomputed and tax will be deducted accordingly.</li>
                                                    </ol>
                                                    <p><b>(To be used to declare investment for income Tax that will be
                                                            made during the period )</b></p><br>
                                                    <p><b>Deduction Under Section 10</b></p>
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Item</th>
                                                                <th>Particulars</th>
                                                                <th style="width: 7%;">Max. Limit</th>
                                                                <th style="width: 14%;">Declared Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Sec. 80CCD(2)</td>
                                                                <td>Corporate NPS Scheme</td>
                                                                <td>10% Of Basic Salary</td>
                                                                <td><input type="number"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <p><b>Declaration:</b></p>
                                                    <ol>
                                                        <li>I hereby declare that the information given above is correct
                                                            and true in all respects.</li>
                                                        <li>I also undertake to indemnify the company for any
                                                            loss/liability that may arise in the event of the above
                                                            information being incorrect.</li>
                                                    </ol>
                                                    <div class="row">
                                                        <div class="col-md-12 mt-4 mb-3">
                                                            <div class="float-start">
                                                                <b>Date:</b> 15 Feb 2024<br> <br><b>Place:</b> Raipur
                                                            </div>
                                                            <div class="float-end mt-3">
                                                                <b>Signature</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                                        </div>
                                                    </div>
                                                @endif
                                        </div>
                                        </ul>

                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('employee.footerbottom')

                        </div>
                    </div>


                </div>
                </div>
            </div>
        </div>

        @include('employee.footer');
        <script>
            document.getElementById('print-button').addEventListener('click', function () {
                const form = document.getElementById('investment-form');
                const editButton = document.getElementById('edit-button');
                const submitButton = document.getElementById('submit-button-in');

                // Temporarily hide the buttons
                if (editButton) editButton.style.display = 'none';
                if (submitButton) submitButton.style.display = 'none';

                // Remove hidden fields (like CSRF token or other hidden inputs) for print preview
                const hiddenFields = form.querySelectorAll('input[type="hidden"]');
                hiddenFields.forEach(field => {
                    field.parentElement.removeChild(field); // Remove the hidden input fields
                });

                // Create a print-only window
                const printWindow = window.open('', '_blank');
                printWindow.document.open();
                printWindow.document.write(`
                    <html>
                    <head>
                        <title>Print Form</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                            }
                            table, th, td {
                                border: 1px solid black;
                            }
                            th, td {
                                padding: 8px;
                                text-align: left;
                            }
                            /* Hide input fields and display their values */
                            input[type="text"], input[type="number"], input[type="checkbox"] {
                                border: none;
                                background-color: transparent;
                                width: 100%;
                                padding: 0;
                                display: block;
                            }
                            /* Hide input fields inside the table but show their values */
                            td input {
                                display: none;
                            }
                            td {
                                white-space: nowrap;
                            }
                        </style>
                    </head>
                    <body>
                        <div>
                            <!-- Copy the form content and replace input values with text content -->
                            ${form.innerHTML.replace(/<input[^>]*>/g, (match) => {
                                let value = match.match(/value="([^"]*)"/);
                                return value ? `<span>${value[1]}</span>` : ''; // Replace the input with the value
                            })}
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();

                // Restore the buttons after printing
                if (editButton) editButton.style.display = '';
                if (submitButton) submitButton.style.display = '';
            });
        </script>

        <script src="{{ asset('../js/dynamicjs/invst.js/') }}" defer></script>
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