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
                                                                       
                    <!-- Investment Submission Tab -->
                    @if($employeeData && $employeeData->OpenYN == 'Y')

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
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h4 class="text-center flex-grow-1 mb-0">
                                            Investment Declaration Form {{ $investmentDeclaration->Period ?? $PrdCurr }}
                                        </h4>
                                        <a href="{{ asset('investment_helpfile/Income Tax Declaration Guide FY 2025-26 Ver 2.pdf') }}" target="_blank" class="btn btn-sm btn-outline-secondary ms-3" title="Download Help File">
                                            <i class="bi bi-question-circle"></i> <b>Help File</b>
                                        </a>
                                    </div>
                                    </div>
                                    <div class="card-body" style="padding-top:0px;">
                                        <div class="mfh-machine-profile">
                                        @if(isset($investmentDeclaration->Regime))
                                            @if($investmentDeclaration->Regime == 'old')
                                                <h3>Old Regime</h3>
                                            @elseif($investmentDeclaration->Regime == 'new')
                                                <h3>New Regime</h3>
                                            @endif
                                        @else
                                            <div style="float:left;width:300px;">
                                                <div class="float-start me-3 mt-2">
                                                    <input type="radio" name="Regime" class="me-2 float-start" style="margin-top:-5px;" 
                                                        onclick="showTab('oldregime')"  
                                                        @if(old('Regime', $investmentDeclaration->Regime ?? '') == 'old') checked @endif> 
                                                    Old Regime
                                                </div>
                                                <div class="float-start me-3 mt-2">
                                                    <input type="radio" name="Regime" class="me-2 float-start" style="margin-top:-5px;" 
                                                        onclick="showTab('newregime')"  
                                                        @if(old('Regime', $investmentDeclaration->Regime ?? 'new') == 'new') checked @endif> 
                                                    New Regime
                                                </div>
                                            </div>
                                        @endif

                                            <br><br>
                                            <div class="tab-content splash-content2 mt-3" id="myTabContent2">
                                                
                                                <div 
                                                        id="oldregime" 
                                                        role="tabpanel"
                                                        @class([
                                                            'regim-panel',
                                                            'tab-pane',
                                                            'fade',
                                                            'show active' => optional($investmentDeclaration)->Regime == 'old'
                                                        ])>
                                                        <div id="printable-area">
                                                    <ul class="user-details">
                                                        <li>Employee Code: {{$employeeData->EmpCode ?? ''}}</li>
                                                        <li>Employee Name: {{ $employeeData->Fname ?? '' }}
                                                            {{ $employeeData->Sname ?? '' }}
                                                            {{ $employeeData->Lname ?? '' }}
                                                        </li>
                                                        <li>PAN Number: {{$employeeData->PanNo ?? 'N/A'}}</li>
                                                        <li>Company Name: {{$employeeData->CompanyName ?? 'N/A'}}</li>
                                                    </ul>
                                                    </div>
                                                    <br>
                                                    <p><b>Please remember the following points while filling up the
                                                            form</b></p>
                                                    <ol style="color: #686464;">
                                                       
                                                        <li> You are requested to submit the required proofs up to last
                                                            date of submission, failing which will be assumed that the
                                                            employee does not have any Tax </li>
                                                        <li>Saving and income other than salary, and the Income Tax will
                                                            be recomputed and tax will be deducted accordingly.</li>
                                                        <li>No hard copy required – For Investment Declaration ESS submission is sufficient</li>

                                                    </ol>
                                                    <p><b>(To be used to declare investment for income tax that will be made during the period )</b></p><br>
                                                            <p><b>Deduction under section 10</b></p>
                                                        <button type="button" class="btn btn-secondary" id="print-button"style="float:right;">
                                                            <i class="fa fa-print"></i> <!-- Font Awesome print icon -->
                                                        </button>
                                                    <form id="investment-form" method="POST"  action="{{ route('save.investment.declaration') }}">
                                                    
                                                        @csrf

                                                        <input type="hidden" name="selected_regime" id="selected-regime"
                                                            value="old">
                                                        <input type="hidden" name="period" id="period" value="{{$PrdCurr}}">
                                                        <input type="hidden" name="c_month" id="c_month" value="{{ $employeeData && isset($employeeData->C_Month) ? $employeeData->C_Month : optional($investmentDeclarationlimit)->C_Month }}">
                                                     

                                                        <input type="hidden" name="y_id" id="y_id" value="{{ optional($employeeData)->C_YearId ?? $investmentDeclarationlimit->C_YearId}}">
                                                        
                                                        <input type="hidden" name="empcode" id="empcode" value="{{ optional($employeeData)->EmpCode ?? Auth::user()->EmpCode }}">

 
                                                        <table class="table table-bordered table-striped table-condensed" style="margin-bottom: 20px;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 20%;">Item</th>
                                                                    <th style="width:45%;">Particulars</th>
                                                                    <th style="width: 15%;">Max. Limit</th>
                                                                    <th style="width: 15%;">Declared Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                              <!-- House Rent Section -->
                                                                        <tr>
                                                                            <td>House Rent Sec 10(13A)</td>
                                                                            <td>I am staying in a house and I agree to submit rent receipts<br> when required. The Rent paid is Rs._______ Per Month & the <br>house is located in Non-Metro</td>
                                                                            <td></td>
                                                                            <td>
                                                                                <input type="number"
                                                                                    name="house_rent_declared_amount" readonly
                                                                                    value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}"
                                                                                    @if(isset($investmentDeclaration->HRA)) @endif>
                                                                            </td>
                                                                        </tr>
                                                                        <!-- LTA Section -->
                                                                        <tr>
                                                                            <td>LTA Sec 10(5)</td>
                                                                            <td>I will provide the tickets/ Travel bills in original as per<br> one basic annually the LTA policy or else the company <br>can consider amount as taxable.</td>
                                                                            <td>
                                                                                <b>{{$LTA}}</b><br>
                                                                                <input id="lta-checkbox" name="lta_checkbox"
                                                                                    style="float:left;height: 15px;"
                                                                                    type="checkbox"
                                                                                    @if(isset($investmentDeclaration->LTA) && $investmentDeclaration->LTA != "0.00") checked @endif
                                                                                    @if(isset($investmentDeclaration->LTA)) @endif>
                                                                            </td>

                                                                            <td>
                                                                            <input id="lta-amount"
                                                                                name="lta_declared_amount"
                                                                                type="number"
                                                                                class="form-control"
                                                                                value="{{ isset($investmentDeclaration->LTA) ? $investmentDeclaration->LTA : '' }}"
                                                                                data-lta-value="{{ isset($LTA) ? $LTA : '0' }}"
                                                                                @if(isset($investmentDeclaration->LTA)) disabled @endif>

                                                                            </td>
                                                                        </tr>

                                                                      <!-- CEA Section -->
                                                                        <tr>
                                                                            <td>CEA Sec 10(14)</td>
                                                                            <td>I will provide the copy of tuition fees receipt as per CEA policy<br> or else the company can consider amount as taxable. (Rs.100/- per <br>month per child up to a max of two children)</td>
                                                                            <td><b>2400/-</b>
                                                                                <br><span style="float:left;">Child-1</span>
                                                                                <input id="child1-checkbox"
                                                                                    name="child1_checkbox"
                                                                                    style="float:left;height: 15px;"
                                                                                    type="checkbox"
                                                                                    @if(isset($investmentDeclaration->CEA)) checked @endif
                                                                                    @if(isset($investmentDeclaration->CEA))  @endif>
                                                                                <span style="float:left;margin-left:15px;">Child-2</span>
                                                                                <input id="child2-checkbox"
                                                                                    name="child2_checkbox"
                                                                                    style="float:left;height: 15px;"
                                                                                    type="checkbox"
                                                                                    @if(isset($investmentDeclaration->CEA)) checked @endif
                                                                                    @if(isset($investmentDeclaration->CEA))  @endif>
                                                                            </td>
                                                                            <td>
                                                                                <input id="cea-amount" name="cea_declared_amount" type="number" class="form-control"
                                                                                    value="{{ optional($investmentDeclaration)->CEA ?? '' }}"
                                                                                    @if(isset($investmentDeclaration->CEA))disabled @endif>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="4"><p style="color: #686464;">** If you have opted for the medical
                                                                                reimbursements (being Medical expenses part of your CTC)</p></td>
                                                                        </tr>


                                                                <tr>
                                                                    <td rowspan="5">Deductions Under Chapter <br>VI A</td>
                                                                    <td>Sec.80D - Medical Insurance Premium (If the
                                                                        policy covers a senior <br>Citizen then additional
                                                                        deduction of Rs.5000/- is available & deduction<br>
                                                                        on account of expenditure on preventive<br> Health
                                                                        Check-Up (for Self, <br>Spouse, Dependant Children &
                                                                        Parents) Shall not exceed in the<br> aggregate Rs
                                                                        5000/-.)</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->MIP_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="medical_insurance" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->MIP ?? '' }}">
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    
                                                                    <td>Sec. 80DD - Medical treatment/insurance of
                                                                        Handicapped Dependant <br>A higher deduction of Rs.
                                                                        100,000 is available, where such <br>dependent is
                                                                        with severe disability of > 80%</td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->MTI_Limit,0)}}/-</b></td>
                                                                        <td>
                                                                            <input name="medical_treatment_handicapped" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->MTI ?? '' }}">
                                                                        </td>

                                                                </tr>

                                                                <tr>
                                                                    
                                                                <td>Sec 80DDB - Medical treatment (specified
                                                                            diseases only)
                                                                            <br>(Rs 40,000 if the patient is below <br>
                                                                        60 years of age (else Rs 1 lakh))
                                                                        </td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->MTS_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="medical_treatment_disease" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->MTS ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>Sec 80E - Repayment of Loan for higher education
                                                                        (only interest)</td>
                                                                        <td><b>{{number_format($investmentDeclarationlimit->ROL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="loan_repayment" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->ROL ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    
                                                                    <td>Sec 80U - Handicapped</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->Handi_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                        <input name="handicapped_deduction" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->Handi ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                            
                                                                <tr>
                                                                    <td rowspan="14">Deduction Under Section<br> 80C</td>
                                                                    <td>Sec 80CCC - Contribution to Pension Fund (Jeevan
                                                                        Suraksha)</td>
                                                                    <td rowspan="14"><b>{{number_format($investmentDeclarationlimit->PenFun_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="pension_fund_contribution" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->PenFun ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Life Insurance Premium</td>
                                                                   
                                                                    <td>
                                                                        <input name="life_insurance" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->LIP ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Deferred Annuity</td>
                                                                    
                                                                    <td>
                                                                        <input name="deferred_annuity" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->DA ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Public Provident Fund</td>
                                                                   
                                                                    <td>
                                                                        <input name="ppf" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->PPF ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Time Deposit in Post Office / Bank for 5 year &
                                                                        above</td>
                                                                    
                                                                    <td>
                                                                        <input name="PostOff" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->PostOff ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>ULIP of UTI/LIC</td>
                                                                    
                                                                    <td>
                                                                        <input name="ulip" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->ULIP ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Principal Loan (Housing Loan) Repayment</td>
                                                                    
                                                                    <td>
                                                                        <input name="housing_loan_repayment" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->HL ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Mutual Funds</td>
                                                                    
                                                                    <td>
                                                                    <input name="mutual_funds" type="number" readonly
                                                                        value="{{ optional($investmentDeclaration)->MF ?? '' }}">
                                                                </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Investment in infrastructure Bonds</td>
                                                                    
                                                                    <td>
                                                                            <input name="infrastructure_bonds" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->IB ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Children- Tuitions Fee restricted to max. of 2
                                                                        children</td>
                                                                    
                                                                    <td>
                                                                        <input name="tuition_fee" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->CTF ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Deposit in NHB</td>
                                                                    
                                                                    <td>
                                                                        <input name="deposit_in_nhb" type="number" readonly
                                                                            value="{{ isset($investmentDeclaration->NHB) ? $investmentDeclaration->NHB : '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Deposit In NSC</td>
                                                                    
                                                                    <td>
                                                                        <input name="deposit_in_nsc" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->NSC ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Sukanya Samriddhi</td>
                                                                    
                                                                    <td>
                                                                        <input name="sukanya_samriddhi" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->SukS ?? '' }}">
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Others (please specify) Employee Provident Fund</td>
                                                                    
                                                                    <td>
                                                                        <input name="others_employee_provident_fund" type="number" readonly
                                                                            value="{{ optional($investmentDeclaration)->EPF ?? '' }}">
                                                                    </td>
                                                                </tr>
                                                            
                                                                <tr>
                                                                    <td> Sec. 80CCD(1B)</td>
                                                                    <td>NPS (National Pension Scheme)/ Atal Pension Yojna(APY)</td>
                                                                    <td><b>50,000/-</b></td>
                                                                    <td>
                                                                            <input name="apy" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->NPS ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                            
                                                                <tr>
                                                                    <td> Sec. 80CCD(2)	</td>
                                                                    <td> Corporate NPS Scheme</td>
                                                                    <td><b>10% Of Basic Salary</b>
                                                                <br><b>Note:</b> Total employer contribution to NPS and EPF is tax-exempt up to ₹7.5 lakh/year; any excess is taxable as perquisite under Section 17(2)</td>
                                                                    <td>
                                                                            <input name="cornps" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Previous Employment Salary <br>(Salary earned from <br>01.04.2025 till date of joining)	</td>
                                                                    <td> If yes, Form 16 from previous employer or Form 12 B<br> with tax computation statement</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                            <input name="form16limit" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->Form16 ?? '' }}">
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>Salary paid by the Previous Employer after Sec.10 Exemption	</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->SPE_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="spelimit" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->SPE ?? '' }}">
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>   PROFESSIOAL TAX deducted by the Previous Employer		</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->PT_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="ptlimit" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->PT ?? '' }}">
                                                                        </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td> PROVIDENT FUND deducted by the Previous Employer			</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->PFD_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="pfdlimit" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->PFD ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> </td>
                                                                    <td>   INCOME TAX deducted by the Previous Employer			</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->IT_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="itlimit" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->IT ?? '' }}">
                                                                        </td>
                                                                    

                                                                </tr>
                                                                <tr>
                                                                    <td> Income other then<br> Salary Income	 </td>
                                                                    <td>   If yes, then Form 12C detailing other income is <br>attached(only interest)		</td>
                                                                    <td><b></b></td>
                                                                    <td>
                                                                            <!-- <input name="" type="number" > -->
                                                                        </td>
                                                                    

                                                                </tr>
                                                            
                                                                <tr>
                                                                    <td rowspan="2">Deduction under <br>Section 24	</td>
                                                                    <td> Interest on Housing Loan	</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->IHL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="ihl" type="number" readonly
                                                                                value="{{ optional($investmentDeclaration)->IHL ?? '' }}">
                                                                        </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>Interest if the loan is taken before 01/04/99	</td>
                                                                    <td><b>{{number_format($investmentDeclarationlimit->IL_Limit,0)}}/-</b></td>
                                                                    <td>
                                                                            <input name="il" type="number" readonly
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
                                                                    value="{{ isset($investmentDeclaration->SubmittedDate) ? $investmentDeclaration->SubmittedDate : now()->format('d-m-Y') }}"><br><br>

                                                                <label for="place"><b>Place:</b></label>
                                                                <input type="text" id="place" name="place"
                                                                    value="{{ isset($investmentDeclaration->Place) ? $investmentDeclaration->Place : '' }}"><br><br>
                                                            </div>
                                                            <div class="float-end mt-3">
                                                                <b>Signature</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($investmentDeclarationsetting && $investmentDeclarationsetting->InvestDecl == 'Y'&& empty($investmentDeclaration))
                                                        <div class="form-group text-center">
                                                            <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
                                                            <button type="submit" id="save-btn" class="btn btn-primary d-none">Save</button>
                                                            </div>
                                                    @endif
                                                    @if($investmentDeclarationsetting 
                                                            && $investmentDeclarationsetting->InvestDecl == 'Y' 
                                                            && isset($investmentDeclaration) 
                                                            && $investmentDeclaration->FormSubmit == 'Y')
                                                        <div class="form-group text-center">
                                                            <button type="submit" id="submit-btn" class="btn btn-primary">Final Submit</button>
                                                            <button type="submit" id="save-btn" class="btn btn-primary">Save</button>
                                                            </div>
                                                    @endif
                                                            @if($investmentDeclarationsetting && $investmentDeclarationsetting->InvestDecl == 'Y'
                                                            && isset($investmentDeclaration)&&
                                                            $investmentDeclaration->FormSubmit == 'YY')
                                                        <div class="form-group text-center">
                                                            
                                                            </div>
                                                    @endif

                                                   
                                                    
                                                    </form>
                                                 </div>
                                                
                                                 <div 
                                                    id="newregime" 
                                                    role="tabpanel"
                                                    @class([
                                                        'regim-panel',
                                                        'tab-pane',
                                                        'fade',
                                                        'show active' => old('Regime', $investmentDeclaration->Regime ?? 'new') == 'new'
                                                    ])>
                                                        <div id="printable-area">
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
                                                    </div>

                                                    <br>
                                                    <p style="color:black;"><b>Please remember the following points while filling up the
                                                            form</b></p>
                                                    <ol style="color: #686464;">
                                                
                                                        <li>Regime once selected, changes cannot be made during the financial year</li>
                                                        <li>Saving and income other than salary, and the Income Tax will
                                                            be recomputed and tax will be deducted accordingly.</li>
                                                        <li>No hard copy required – For Investment Declaration ESS submission is sufficient</li>
                                                    </ol>
                                                    <p><b>(To be used to declare investment for income Tax that will be
                                                            made during the period )</b></p><br>
                                                    <p><b>Deduction Under Section 10</b></p>
                                                    <button type="button" class="btn btn-secondary" id="print-button-new"style="float:right;">
                                                            <i class="fa fa-print"></i> <!-- Font Awesome print icon -->
                                                        </button>
                                                    <form id="investment-form-new" method="POST"  action="{{ route('save.investment.declaration') }}">
                                                    
                                                        @csrf

                                                        <input type="hidden" name="selected_regime" id="selected-regime"
                                                            value="new">
                                                        <input type="hidden" name="period" id="period" value="{{$PrdCurr}}">
                                                        <input type="hidden" name="c_month" id="c_month" value="{{ $employeeData && isset($employeeData->C_Month) ? $employeeData->C_Month : optional($investmentDeclarationlimit)->C_Month }}">
                                                     

                                                        <input type="hidden" name="y_id" id="y_id" value="{{ optional($employeeData)->C_YearId ?? $investmentDeclarationlimit->C_YearId}}">
                                                        <input type="hidden" name="empcode" id="empcode" value="{{ optional($employeeData)->EmpCode ?? Auth::user()->EmpCode }}">

 
 
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%;">Item</th>
                                                                <th>Particulars</th>
                                                                <th style="width: 7%;">Max. Limit (Year)</th>
                                                                <th style="width: 14%;">Declared Amount (Year)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Sec. 80CCD(2)</td>
                                                                <td>Corporate NPS Scheme<br>(14% Of Basic Salary)
                                                                 <br>
                                                                 <b>Note:</b> Total employer contribution to NPS and EPF is tax-exempt up to ₹7.5 lakh/year; any excess is taxable as perquisite under Section 17(2)
                                                                </td>
                                                                <td>{{ round(($ctc->BAS_Value * 12) * 0.14) }}</td>


                                                                <td>
                                                            <input name="cornps" type="number" readonly
                                                                value="{{ optional($investmentDeclaration)->Regime == 'new' ? optional($investmentDeclaration)->CorNPS : '0.00' }}">
                                                        </td>
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
                                                                <label for="date"><b>Date:</b></label>
                                                                <input type="date" id="datenew" name="date" 
                                                                            disabled 
                                                                            value="{{ isset($investmentDeclaration->SubmittedDate) ? \Carbon\Carbon::parse($investmentDeclaration->SubmittedDate)->format('Y-m-d') : now()->format('Y-m-d') }}"><br><br>

                                                                <label for="place"><b>Place:</b></label>
                                                                <input type="text" id="place" name="place"
                                                                    value="{{ isset($investmentDeclaration->Place) ? $investmentDeclaration->Place : '' }}"><br><br>
                                                            </div>
                                                            <div class="float-end mt-3">
                                                                <b>Signature</b>
                                                            </div>

                                                          

                                                        </div>
                                                        @if($investmentDeclarationsetting && $investmentDeclarationsetting->InvestDecl == 'Y'&& empty($investmentDeclaration))
                                                        <div class="form-group text-center">
                                                            <button type="button" id="edit-btn-new" class="btn btn-primary">Edit</button>
                                                            <button type="submit" id="save-btn-new" class="btn btn-primary d-none">Save</button>
                                                            </div>
                                                    @endif
                                                    @if($investmentDeclarationsetting 
                                                            && $investmentDeclarationsetting->InvestDecl == 'Y' 
                                                            && isset($investmentDeclaration) 
                                                            && $investmentDeclaration->FormSubmit == 'Y')
                                                        <div class="form-group text-center">
                                                            <button type="submit" id="submit-btn-new" class="btn btn-primary">Final Submit</button>
                                                            <button type="submit" id="save-btn-new" class="btn btn-primary">Save</button>
                                                            </div>
                                                    @endif
                                                            @if($investmentDeclarationsetting && $investmentDeclarationsetting->InvestDecl == 'Y'
                                                            && isset($investmentDeclaration)&&
                                                            $investmentDeclaration->FormSubmit == 'YY')
                                                            
                                                        
                                                        <div style="margin-left:14%;"class="col-8 justify-content-center alert alert-success p-2 text-center alert alert-success" role="alert">
                                                            Form has been submitted
                                                        </div>
                                                    @endif
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                                    <div class="card-header" id="attendance">
                                        <h4 class="text-center">Investment Submission Form {{$investmentDeclaration->Period ?? '$p'}}</h4>
                                    </div>
                                    <div class="card-body" style="padding-top:0px;">
                                        <div class="mfh-machine-profile">
                                        <ul class="nav nav-tabs" id="myTab1" role="tablist" style="display: contents;">
                                    
                                        <div class="row">
                                        @if(!isset($investmentDeclaration->Regime) && !isset($investmentDeclarationsubb->Regime))
                                                <!-- Show radio buttons if no regime is selected -->
                                                <div class="form-group float-start me-3 mt-2" style="padding: 10px;">
                                                    <label>
                                                        <input type="radio" name="regime" class="me-2 float-start" style="margin-top:-5px;" value="old" onclick="toggleRegime('old')" 
                                                            {{ ($investmentDeclaration->Regime ?? $investmentDeclarationsubb->Regime ?? 'old') == 'old' ? 'checked' : '' }}>
                                                        Old Regime
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="regime" value="new" class="me-2 float-start" style="margin-top:-5px;"  onclick="toggleRegime('new')" 
                                                            {{ ($investmentDeclaration->Regime ?? $investmentDeclarationsubb->Regime ?? 'old') == 'new' ? 'checked' : '' }}>
                                                        New Regime
                                                    </label>
                                                </div>
                                              

                                            @endif

                                                @if(($investmentDeclaration->Regime ?? 'old') == 'old' || ($investmentDeclarationsubb->Regime ?? 'old') == 'old')
                                                <!-- Display "Old Regime" Title -->
                                                        <h5 class="ad-title mb-0" style="padding:10px;" id="oldregimelabel">Old Regime</h5>
                                                        <!-- Old Regime Content -->
                                                        <div class="tab-content">
                                                        <div class="tab-pane fade active show" id="oldregimesub" role="tabpanel" aria-labelledby="oldregime-tab1">
                                                        <div class="tab-pane fade active table-responsive show" id="oldregimecontent" role="tabpanel">

                                                        <!-- <ul class="user-details">
                                                            <li>Employee Code: {{$employeeData->EmpCode ?? ''}}</li>
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
                                                    
                                                            <li> You are requested to submit the required proofs up to last
                                                                date of submission, failing which will be assumed that the
                                                                employee does not have any Tax </li>
                                                            <li>Saving and income other than salary, and the Income Tax will
                                                                be recomputed and tax will be deducted accordingly.</li>
                                                        </ol>
                                                        <p><b>(To be used to declare investment for income Tax that will be
                                                                made during the period )</b></p><br>
                                                        <p><b>Deduction Under Section 10</b></p> -->
                                                    
                                                        <div id="printable-area">
                                                            <!-- Employee Details -->
                                                            <ul class="user-details">
                                                            <p><b>Employee Code:</b> {{$employeeData->EmpCode ?? ''}}</p>
                                                                <p><b>Employee Name:</b> {{ $employeeData->Fname ?? '' }} {{ $employeeData->Sname ?? '' }} {{ $employeeData->Lname ?? '' }}</p>
                                                                <p><b>PAN Number:</b> {{$employeeData->PanNo ?? 'N/A'}}</p>
                                                                <p><b>Company Name:</b> {{$employeeData->CompanyName ?? 'N/A'}}</p>
                                                            </ul>

                                                            <br>
                                                            <p><b>Please remember the following points while filling up the form</b></p>
                                                            <ol style="color: #686464;">
                                                                <li>You are requested to submit the required proofs up to the last date of submission, failing which it will be assumed that the employee does not have any tax.</li>
                                                                <li>Saving and income other than salary, and the Income Tax will be recomputed and tax will be deducted accordingly.</li>
                                                            </ol>

                                                            <p><b>(To be used to declare investment for income tax that will be made during the period)</b></p><br>
                                                            <p><b>Deduction Under Section 10</b></p>
                                                        </div>
                                                        
                                                        <button type="button" class="btn btn-secondary" id="print-button-sub"style="float:right;">
                                                                <i class="fa fa-print"></i> <!-- Font Awesome print icon -->
                                                            </button>
                                                        <form id="investment-form-submission" method="POST"
                                                            action="{{ route('save.investment.submission') }}">
                                                            @csrf
                                                            
                                                            <input type="hidden" name="selected_regime" id="selected-regime"
                                                                value="{{$investmentDeclaration->Regime ?? 'old'}}">
                                                            <input type="hidden" name="period_sub" id="period_sub" value="{{$investmentDeclaration->Period?? $PrdCurr}}">
                                                            <input type="hidden" name="c_month" id="c_month" 
                                                                value="{{ $employeeData && isset($employeeData->C_Month) ? $employeeData->C_Month : optional($investmentDeclarationlimit)->C_Month }}">

                                                            <input type="hidden" name="y_id" id="y_id" 
                                                                value="{{ optional($employeeData)->C_YearId ?? $investmentDeclarationlimit->C_YearId}}">

                                                     
                                                        <input type="hidden" name="empcode" id="empcode" value="{{ optional($employeeData)->EmpCode ?? Auth::user()->EmpCode }}">

 
                                                            @if($investmentDeclarationsubb)

                                                            <table class="table table-bordered table-striped" style="margin-bottom:20px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10%;">Item</th>
                                                                        <th style="width: 50%;">Particulars</th>
                                                                        <th style="width: 5%;">Max. <br>Limit</th>
                                                                        <th style="width: 15%;">Declared Amount</th>
                                                                        <th style="width: 15%;">Submitted Amount</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- House Rent Section -->
                                                                    <tr>
                                                                        <td>House Rent Sec 10(13A)</td>
                                                                        <td>I am staying in a house and I agree to submit
                                                                            rent receipts<br> when required. The Rent paid is
                                                                            (Rs._______ Per Month) & <br>the house is located in
                                                                            Non-Metro</td>
                                                                        <td></td>
                                                                        <td>
                                                                            <input type="number" readonly id="hra-readonly" 
                                                                                value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}" reandoly>
                                                                        </td>
                                                                        <td>
                                                                            <!-- Second input -->
                                                                            <input type="number" name="house_rent_declared_amount" id="hra-editable" 
                                                                                value="{{ isset($investmentDeclarationsubb->HRA) ? $investmentDeclarationsubb->HRA : '' }}">
                                                                        </td>
                                                                    </tr>
                                                                    <!-- LTA Section -->
                                                                    <tr>
                                                                        <td>LTA Sec 10(5)</td>
                                                                        <td>
                                                                            I will provide the tickets/Travel bills in original as per<br> one basic annually the LTA
                                                                            policy or else the company<br> can consider amount as taxable.
                                                                        </td>
                                                                        
                                                                        <td>
                                                                                    <b>{{$LTA}}</b><br>
                                                                                    <input id="lta-checkbox" name="lta_checkbox"
                                                                                        style="float:left;height: 15px;"
                                                                                        type="checkbox"
                                                                                        @if(isset($investmentDeclaration->LTA) && $investmentDeclaration->LTA != "0.00") checked @endif
                                                                                        @if(isset($investmentDeclaration->LTA)) disabled @endif>
                                                                                </td>
                                                                        <td>
                                                                            <input id="lta-amount-readonly" type="number" class="form-control" readonly
                                                                                value="{{ isset($investmentDeclaration->LTA) ? $investmentDeclaration->LTA : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input id="lta-amount-editable" name="lta_declared_amount" type="number" class="form-control" 
                                                                                value="{{ isset($investmentDeclarationsubb->LTA) ? $investmentDeclarationsubb->LTA : '' }}">
                                                                        </td>
                                                                    </tr>

                                                                    <!-- CEA Section -->
                                                                    <tr>
                                                                        <td>CEA Sec 10(14)</td>
                                                                        <td>
                                                                            I will provide the copy of tuition fees receipt as per CEA policy<br> or else the company can
                                                                            consider amount as taxable. (Rs.100/- <br>per month per child up to a max of two children)
                                                                        </td>
                                                                        <td><b>2400/-</b>
                                                                            <br>Child-1
                                                                            <input id="child1-checkboxsub" name="child1_checkbox" style="float:right;height: 15px;" type="checkbox" readonly disabled>
                                                                            <br>Child-2
                                                                            <input id="child2-checkboxsub" name="child2_checkbox" style="float:right;height: 15px;" type="checkbox" readonly disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input id="cea-amount-readonly" type="number" class="form-control" readonly
                                                                                value="{{ optional($investmentDeclaration)->CEA ?? '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input id="cea-amount-editable" name="cea_declared_amount" type="number" class="form-control" 
                                                                                value="{{ optional($investmentDeclarationsubb)->CEA ?? '' }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5"><p style="color: #686464;">** If you have opted for the medical
                                                                            reimbursements (being Medical expenses part of your CTC)</p></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td rowspan="5">Deductions Under Chapter VI A</td>
                                                                        <td>Sec.80D - Medical Insurance Premium (If the
                                                                            policy covers <br>a senior Citizen then additional
                                                                            deduction of Rs.5000/- <br>is available & deduction
                                                                            on account of expenditure on preventive<br> Health
                                                                            Check-Up <br>(for Self, Spouse, Dependant Children &
                                                                            Parents) <br>Shall not exceed in the aggregate Rs
                                                                            5000/-.)</td>
                                                                        <td><b>25000/-</b></td>
                                                                        <td>
                                                                            <input type="number" id="medical_insurance_readonly"
                                                                                value="{{ optional($investmentDeclaration)->MIP ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="medical_insurance" id="medical_insurance_edit" type="number"
                                                                                value="{{ optional($investmentDeclarationsubb)->MIP ?? '' }}">
                                                                        </td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td>Sec. 80DD - Medical treatment/insurance of
                                                                            Handicapped <br>Dependant A higher deduction of Rs.
                                                                            100,000 is available,<br> where such dependent is
                                                                            with severe disability of > 80%</td>
                                                                        <td><b>50000/-</b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="medical_treatment_handicapped_readonly"
                                                                                value="{{ optional($investmentDeclaration)->MTI ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="medical_treatment_handicapped"
                                                                                type="number" id="medical_treatment_handicapped_edit" 
                                                                                value="{{ optional($investmentDeclarationsubb)->MTI ?? '' }}">
                                                                        </td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td>Sec 80DDB - Medical treatment (specified
                                                                            diseases only)
                                                                            <br>(Rs 40,000 if the patient is below <br>
                                                                        60 years of age (else Rs 1 lakh))
                                                                        </td>
                                                                        <td><b>40000/-</b></td>
                                                                        <td>
                                                                                <input 
                                                                                    type="number" id="medical_treatment_disease_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->MTS ?? '' }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input name="medical_treatment_disease" id="medical_treatment_disease_edit"
                                                                                    type="number"
                                                                                    value="{{ optional($investmentDeclarationsubb)->MTS ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sec 80E - Repayment of Loan for higher education
                                                                            (only interest)</td>
                                                                        <td>-</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="repay_of_loan_readonly"
                                                                                value="{{ optional($investmentDeclaration)->ROL ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="loan_repayment" id="repay_of_loan_edit"
                                                                                type="number"value="{{ optional($investmentDeclarationsubb)->ROL ?? '' }}">
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sec 80U - Handicapped</td>
                                                                        <td><b>50000/-</b></td>
                                                                        <td>
                                                                            <input  
                                                                                type="number" id="handicapped_deduction_readonly"
                                                                                value="{{ optional($investmentDeclaration)->Handi ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="handicapped_deduction" id="handicapped_deduction_edit"
                                                                                type="number"
                                                                                value="{{ optional($investmentDeclarationsubb)->Handi ?? '' }}">
                                                                        </td>
                                                                    </tr>
                                                            
                                                                    <tr>
                                                                        <td rowspan="14">Deduction Under Section 80C</td>
                                                                        <td>Sec 80CCC - Contribution to Pension Fund (Jeevan
                                                                            Suraksha)</td>
                                                                        <td rowspan="14"><b>1,50,000/-</b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="pension_fund_contribution_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PenFun ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="pension_fund_contribution" id="pension_fund_contribution_edit"
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclarationsubb)->PenFun ?? '' }}" >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Life Insurance Premium</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="life_insurance_readonly"
                                                                                value="{{ optional($investmentDeclaration)->LIP ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="life_insurance" id="life_insurance_edit"
                                                                                type="number"
                                                                                value="{{ optional($investmentDeclarationsubb)->LIP ?? '' }}" >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Deferred Annuity</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="deferred_annuity_readonly"
                                                                                value="{{ optional($investmentDeclaration)->DA ?? '' }}" readonly>
                                                                        </td>
                                                                        <td> 
                                                                            <input name="deferred_annuity" id="deferred_annuity_edit"
                                                                                type="number"
                                                                                value="{{ optional($investmentDeclarationsubb)->DA ?? '' }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Public Provident Fund</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="ppf_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PPF ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="ppf" id="ppf_edit"
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclarationsubb)->PPF ?? '' }}" >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Time Deposit in Post Office / Bank for 5 year &
                                                                            above</td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="PostOff_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PostOff ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="PostOff" id="PostOff_edit"
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclarationsubb)->PostOff ?? '' }}" 
                                                                                >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>ULIP of UTI/LIC</td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="post_off_readonly"
                                                                                value="{{ optional($investmentDeclaration)->ULIP ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="PostOff_ulip" id="post_off_edit"
                                                                                type="number"  readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->ULIP ?? '' }}"  
                                                                                >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Principal Loan (Housing Loan) Repayment</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="housing_loan_readonly"
                                                                                value="{{ optional($investmentDeclaration)->HL ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="housing_loan_repayment" id="housing_loan_edit"
                                                                                type="number"
                                                                                value="{{ optional($investmentDeclarationsubb)->HL ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Mutual Funds</td>
                                                                        <td>
                                                                                <input 
                                                                                    type="number"  id="mutual_funds_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->MF ?? '' }}" 
                                                                                    readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input name="mutual_funds"  id="mutual_funds_edit"
                                                                                    type="number"
                                                                                    value="{{ optional($investmentDeclarationsubb)->MF ?? '' }}" 
                                                                                    >
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Investment in infrastructure Bonds</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="infrastructure_bonds_readonly"
                                                                                value="{{ optional($investmentDeclaration)->IB ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="infrastructure_bonds" id="infrastructure_bonds_edit"
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclarationsubb)->IB ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Children- Tuitions Fee restricted to max. of 2 children</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="tuition_fee_readonly"
                                                                                value="{{ optional($investmentDeclaration)->CTF ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="tuition_fee" id="tuition_fee_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->CTF ?? '' }}" 
                                                                                >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Deposit in NHB</td>
                                                                        <td>
                                                                        <input 
                                                                            type="number" id="deposit_in_nhb_readonly"
                                                                            value="{{ optional($investmentDeclaration)->NHB ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="deposit_in_nhb" id="deposit_in_nhb_edit"
                                                                            type="number" 
                                                                            value="{{ optional($investmentDeclarationsubb)->NHB ?? '' }}" 
                                                                            >
                                                                    </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Deposit In NSC</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="deposit_in_nsc_readonly"
                                                                                value="{{ optional($investmentDeclaration)->NSC ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="deposit_in_nsc" id="deposit_in_nsc_edit"
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclarationsubb)->NSC ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sukanya Samriddhi</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="sukanya_samriddhi_readonly"
                                                                                value="{{ optional($investmentDeclaration)->SukS ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="sukanya_samriddhi" id="sukanya_samriddhi_edit" type="number"
                                                                            value="{{ optional($investmentDeclarationsubb)->SukS ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Others (please specify) Employee Provident Fund </td>
                                                                        
                                                                        <td>
                                                                    <input 
                                                                        type="number" id="others_employee_provident_fund_readonly"
                                                                        value="{{ optional($investmentDeclaration)->EPF ?? '' }}" 
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input name="others_employee_provident_fund" id="others_employee_provident_fund_edit"
                                                                        type="number" value="{{ optional($investmentDeclarationsubb)->EPF ?? '' }}" >
                                                                </td>

                                                                    </tr>
                                                                
                                                                    <tr>
                                                                        <td> Sec. 80CCD(1B)</td>
                                                                        <td>NPS (National Pension Scheme)/ Atal Pension Yojna(APY)</td>
                                                                        <td><b>50000/-</b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="apy_readonly"
                                                                                value="{{ optional($investmentDeclaration)->NPS ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="apy" id="apy_edit" 
                                                                                type="number" 
                                                                                value="{{ optional($investmentDeclarationsubb)->NPS ?? '' }}">
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td> Sec. 80CCD(2)	</td>
                                                                        <td> Corporate NPS Scheme</td>
                                                                        <td><b>14% Of Basic Salary</b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="cornps_readonly"
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="cornps" type="number" id="cornps_edit" 
                                                                                    value="{{ optional($investmentDeclarationsubb)->CorNPS ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                    <td>  Previous Employment Salary <br>(Salary earned from<br> 01.04.2025 till date of joining)	</td>
                                                                        <td> If yes, Form 16 from previous employer or Form 12 B<br> with tax computation statement</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="form16limit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->Form16 ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="form16limit" type="number" id="form16limit_edit"
                                                                                    value="{{ optional($investmentDeclarationsubb)->Form16 ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                    <td> </td>
                                                                        <td>  Salary paid by the Previous Employer after Sec.10 Exemption	</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="spelimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->SPE ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="spelimit" type="number" id="spelimit_edit" 
                                                                                    value="{{ optional($investmentDeclarationsubb)->SPE ?? '' }}"> 
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td> </td>
                                                                        <td>   PROFESSIOAL TAX deducted by the Previous Employer		</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="ptlimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PT ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="ptlimit" type="number" id="ptlimit_edit"
                                                                                    value="{{ optional($investmentDeclarationsubb)->PT ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td> </td>
                                                                        <td> PROVIDENT FUND deducted by the Previous Employer			</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number"  id="pfdlimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PFD ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="pfdlimit" type="number" id="pfdlimit_edit"
                                                                                    value="{{ optional($investmentDeclarationsubb)->PFD ?? '' }}">
                                                                            </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td> </td>
                                                                        <td>   INCOME TAX deducted by the Previous Employer			</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="itlimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->IT ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="itlimit" type="number" id="itlimit_edit" 
                                                                                    value="{{ optional($investmentDeclarationsubb)->IT ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                    <td> Income other then Salary Income	 </td>
                                                                        <td>   If yes, then Form 12C detailing other income is <br>attached(only interest)		</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                                <!-- <input 
                                                                                    type="number" 
                                                                                    
                                                                                    readonly> -->
                                                                            </td>
                                                                            <td>
                                                                                <!-- <input name="" type="number" > -->
                                                                            </td>
                                                                    </tr>
                                                                
                                                                
                                                                    <tr>
                                                                        <td rowspan="2">  Deduction under Section 24	</td>
                                                                        <td> Interest on Housing Loan	</td>
                                                                        <td><b>200000/-</b></td>
                                                                        <td>
                                                                                <input type="number" id="ihl_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->IHL ?? '' }}"readonly>
                                                                            </td>
                                                                        <td>
                                                                                <input name="ihl" type="number" id="ihl_edit"
                                                                                    value="{{ optional($investmentDeclarationsubb)->IHL ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>  Interest if the loan is taken before 01/04/99	</td>
                                                                        <td><b>30000/-</b></td>
                                                                        <td>
                                                                                <input type="number" id="il_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->IL ?? '' }}"readonly>
                                                                            </td>
                                                                        <td>
                                                                                <input name="il" type="number" id="il_edit" 
                                                                                    value="{{ optional($investmentDeclarationsubb)->IL ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                </tbody>
                                                                
                                                                
                                                            </table>

                                                        @else
                                                            <table class="table table-bordered table-striped" style="margin-bottom:20px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 10%;">Item</th>
                                                                        <th>Particulars</th>
                                                                        <th style="width: 7%;">Max. <br>Limit</th>
                                                                        <th style="width: 14%;">Declared Amount</th>
                                                                        <th style="width: 14%;">Submitted Amount</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <!-- House Rent Section -->
                                                                    <tr>
                                                                        <td>House Rent Sec 10(13A)</td>
                                                                        <td>I am staying in a house and I agree to submit
                                                                            rent receipts<br> when required. The Rent paid is
                                                                            (Rs._______ Per Month) &<br> the house is located in
                                                                            Non-Metro</td>
                                                                        <td></td>
                                                                        <td>
                                                                            <input type="number" readonly id="hra-readonly" value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}" reandoly>
                                                                        </td>
                                                                        <td>
                                                                            <!-- Second input -->
                                                                            <input type="number" name="house_rent_declared_amount" id="hra-editable" value="" readonly>
                                                                        </td>
                                                                    </tr>
                                                                    <!-- LTA Section -->
                                                                    
                                                                    <tr>
                                                                        <td>LTA Sec 10(5)</td>
                                                                        <td>
                                                                            I will provide the tickets/ Travel bills in original as per <br>one basic annually the LTA
                                                                            policy or else the company <br>can consider amount as taxable.
                                                                        </td>
                                                                        <td>
                                                                                    <b>{{$LTA}}</b><br>
                                                                                    <input id="lta-checkbox" name="lta_checkbox"
                                                                                        style="float:left;height: 15px;"
                                                                                        type="checkbox"
                                                                                        @if(isset($investmentDeclaration->LTA) && $investmentDeclaration->LTA != "0.00") checked @endif
                                                                                        @if(isset($investmentDeclaration->LTA)) disabled @endif>
                                                                                </td>
                                                                        <td>
                                                                            <input id="lta-amount-readonly" type="number" class="form-control" readonly
                                                                                value="{{ isset($investmentDeclaration->LTA) ? $investmentDeclaration->LTA : '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input id="lta-amount-editable" name="lta_declared_amount" type="number" class="form-control"
                                                                                value="{{$investmentDeclarationsubb->LTA ?? ''}}" readonly>
                                                                        </td>
                                                                    </tr>

                                                                    <!-- CEA Section -->
                                                                    <tr>
                                                                        <td>CEA Sec 10(14)</td>
                                                                        <td>
                                                                            I will provide the copy of tuition fees receipt as per CEA policy <br>or else the company can
                                                                            consider amount as taxable. (Rs.100/- <br>per month per child up to a max of two children)
                                                                        </td>
                                                                        <td><b>2400/-</b>
                                                                            <br>Child-1
                                                                            <input id="child1-checkboxsub" name="child1_checkbox" style="float:right;height: 15px;" type="checkbox" readonly disabled>
                                                                            <br>Child-2
                                                                            <input id="child2-checkboxsub" name="child2_checkbox" style="float:right;height: 15px;" type="checkbox" readonly disabled>
                                                                        </td>
                                                                        <td>
                                                                            <input id="cea-amount-readonly" type="number" class="form-control" readonly
                                                                                value="{{ optional($investmentDeclaration)->CEA ?? '' }}">
                                                                        </td>
                                                                        <td>
                                                                            <input id="cea-amount-editable" name="cea_declared_amount" type="number" class="form-control" readonly
                                                                            value="{{ optional($investmentDeclarationsubb)->CEA ?? '' }}">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5">
                                                                            <p style="color: #686464;">** If you have opted for the medical
                                                                                reimbursements (being Medical expenses part of your CTC)</p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td rowspan="5">Deductions Under Chapter VI A</td>
                                                                        <td>Sec.80D - Medical Insurance Premium (If the
                                                                            policy covers <br>a senior Citizen then additional
                                                                            deduction of Rs.5000/- is <br>available & deduction
                                                                            on account of expenditure on preventive <br>Health
                                                                            Check-Up (for Self, Spouse, Dependant Children &<br>
                                                                            Parents) Shall not exceed in the aggregate Rs
                                                                            5000/-.)</td>
                                                                        <td><b>25000/-</b></td>
                                                                        <td>
                                                                            <input type="number" id="medical_insurance_readonly"
                                                                                value="{{ optional($investmentDeclaration)->MIP ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="medical_insurance" id="medical_insurance_edit" type="number" readonly
                                                                                value="">
                                                                        </td>

                                                                    </tr>

                                                                    <tr>
                                                                        <td>Sec. 80DD - Medical treatment/insurance of
                                                                            Handicapped <br>Dependant A higher deduction of Rs.
                                                                            100,000 is available, <br>where such dependent is
                                                                            with severe disability of > 80%</td>
                                                                        <td><b>50000/-</b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="medical_treatment_handicapped_readonly"
                                                                                value="{{ optional($investmentDeclaration)->MTI ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="medical_treatment_handicapped"
                                                                                type="number" id="medical_treatment_handicapped_edit" readonly
                                                                                value="">
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Sec 80DDB - Medical treatment (specified
                                                                            diseases only)
                                                                            <br>(Rs 40,000 if the patient is below <br>
                                                                        60 years of age (else Rs 1 lakh))
                                                                        </td>
                                                                        <td><b>40000/-</b></td>
                                                                        <td>
                                                                                <input 
                                                                                    type="number" id="medical_treatment_disease_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->MTS ?? '' }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input name="medical_treatment_disease" id="medical_treatment_disease_edit"
                                                                                    type="number" readonly
                                                                                    value="">
                                                                            </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sec 80E - Repayment of Loan for higher education
                                                                            (only interest)</td>
                                                                        <td>-</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="repay_of_loan_readonly"
                                                                                value="{{ optional($investmentDeclaration)->ROL ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="loan_repayment" id="repay_of_loan_edit"
                                                                                type="number" readonly
                                                                                value="">
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sec 80U - Handicapped</td>
                                                                        <td><b>50000/-</b></td>
                                                                        <td>
                                                                            <input  
                                                                                type="number" id="handicapped_deduction_readonly"
                                                                                value="{{ optional($investmentDeclaration)->Handi ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="handicapped_deduction" id="handicapped_deduction_edit"
                                                                                type="number" readonly
                                                                                value="" readonly>
                                                                        </td>
                                                                    </tr>
                                                            
                                                                    <tr>
                                                                        <td rowspan="14">Deduction Under Section 80C</td>
                                                                        <td>Sec 80CCC - Contribution to Pension Fund (Jeevan
                                                                            Suraksha)</td>
                                                                        <td rowspan="14"><b>1,50,000/-</b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="pension_fund_contribution_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PenFun ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="pension_fund_contribution" id="pension_fund_contribution_edit" readonly
                                                                                type="number"  value="{{ optional($investmentDeclarationsubb)->PenFun ?? '' }}" >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Life Insurance Premium</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="life_insurance_readonly"
                                                                                value="{{ optional($investmentDeclaration)->LIP ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="life_insurance" id="life_insurance_edit" readonly
                                                                                type="number" value="{{ optional($investmentDeclarationsubb)->LIP ?? '' }}" >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Deferred Annuity</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="deferred_annuity_readonly"
                                                                                value="{{ optional($investmentDeclaration)->DA ?? '' }}" readonly>
                                                                        </td>
                                                                        <td> 
                                                                            <input name="deferred_annuity" id="deferred_annuity_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->DA ?? '' }}" >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Public Provident Fund</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="ppf_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PPF ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="ppf" id="ppf_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->PPF ?? '' }}">

                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Time Deposit in Post Office / Bank for 5 year & above</td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="PostOff_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PostOff ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="PostOff" id="PostOff_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->PostOff ?? '' }}" readonly
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>ULIP of UTI/LIC</td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="post_off_readonly"
                                                                                value="{{ optional($investmentDeclaration)->ULIP ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="PostOff_ulip" id="post_off_edit" name="ulip"
                                                                                type="number"  readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->ULIP ?? '' }}" 
                                                                                >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Principal Loan (Housing Loan) Repayment</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="housing_loan_readonly"
                                                                                value="{{ optional($investmentDeclaration)->HL ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="housing_loan_repayment" id="housing_loan_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->HL ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Mutual Funds</td>
                                                                        <td>
                                                                                <input 
                                                                                    type="number"  id="mutual_funds_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->MF ?? '' }}" 
                                                                                    readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input name="mutual_funds"  id="mutual_funds_edit"
                                                                                    type="number" readonly
                                                                                    value="{{ optional($investmentDeclarationsubb)->MF ?? '' }}" 
                                                                                    >
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Investment in infrastructure Bonds</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="infrastructure_bonds_readonly"
                                                                                value="{{ optional($investmentDeclaration)->IB ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="infrastructure_bonds" id="infrastructure_bonds_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->IB ?? '' }}" 

                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Children- Tuitions Fee restricted to max. of 2 children</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="tuition_fee_readonly"
                                                                                value="{{ optional($investmentDeclaration)->CTF ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="tuition_fee" id="tuition_fee_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->CTF ?? '' }}" 

                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Deposit in NHB</td>
                                                                        <td>
                                                                        <input 
                                                                            type="number" id="deposit_in_nhb_readonly"
                                                                            value="{{ optional($investmentDeclaration)->NHB ?? '' }}" 
                                                                            readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input name="deposit_in_nhb" id="deposit_in_nhb_edit"
                                                                            type="number"  readonly
                                                                            value="{{ optional($investmentDeclarationsubb)->NHB ?? '' }}" 
                                                                            readonly>
                                                                    </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Deposit In NSC</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="deposit_in_nsc_readonly"
                                                                                value="{{ optional($investmentDeclaration)->NSC ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="deposit_in_nsc" id="deposit_in_nsc_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->NSC ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sukanya Samriddhi</td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="sukanya_samriddhi_readonly"
                                                                                value="{{ optional($investmentDeclaration)->SukS ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="sukanya_samriddhi" id="sukanya_samriddhi_edit"
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->SukS ?? '' }}" 
                                                                                >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>Others (please specify) Employee Provident Fund</td>
                                                                        <td>
                                                                    <input 
                                                                        type="number" id="others_employee_provident_fund_readonly"
                                                                        value="{{ optional($investmentDeclaration)->EPF ?? '' }}" 
                                                                        readonly>
                                                                </td>
                                                                <td>
                                                                    <input name="others_employee_provident_fund" id="others_employee_provident_fund_edit"
                                                                        type="number" readonly
                                                                        value="{{ optional($investmentDeclarationsubb)->EPF ?? '' }}" 
                                                                        >
                                                                </td>

                                                                    </tr>
                                                                
                                                                    <tr>
                                                                        <td> Sec. 80CCD(1B)</td>
                                                                        <td>NPS (National Pension Scheme)/ Atal Pension Yojna(APY)</td>
                                                                        <td><b>50000/-</b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="apy_readonly"
                                                                                value="{{ optional($investmentDeclaration)->NPS ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input name="apy" id="apy_edit" 
                                                                                type="number" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->NPS ?? '' }}" >
                                                                        </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td> Sec. 80CCD(2)	</td>
                                                                        <td> Corporate NPS Scheme</td>
                                                                        <td><b>10% Of <br>Basic Salary</b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="cornps_readonly"
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="cornps" type="number" id="cornps_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->CorNPS ?? '' }}" >
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                    <td>  Previous Employment Salary<br> (Salary earned from <br>01.04.2025 till date of joining)	</td>
                                                                        <td> If yes, Form 16 from previous employer or Form 12 B <br>with tax computation statement</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="form16limit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->Form16 ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="form16limit" type="number" id="form16limit_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->Form16 ?? '' }}" >
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                    <td> </td>
                                                                        <td>  Salary paid by the Previous Employer after Sec.10 Exemption	</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="spelimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->SPE ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="spelimit" type="number" id="spelimit_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->SPE ?? '' }}" >
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td> </td>
                                                                        <td>   PROFESSIOAL TAX deducted by the Previous Employer		</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number" id="ptlimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PT ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="ptlimit" type="number" id="ptlimit_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->PT ?? '' }}" >
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td> </td>
                                                                        <td> PROVIDENT FUND deducted by the Previous Employer</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input
                                                                                type="number"  id="pfdlimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->PFD ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="pfdlimit" type="number" id="pfdlimit_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->PFD ?? '' }}" >
                                                                            </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td> </td>
                                                                        <td>INCOME TAX deducted by the Previous Employer</td>
                                                                        <td><b></b></td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="itlimit_readonly"
                                                                                value="{{ optional($investmentDeclaration)->IT ?? '' }}" 
                                                                                readonly>
                                                                        </td>
                                                                        <td>
                                                                                <input name="itlimit" type="number" id="itlimit_edit" readonly
                                                                                    value="{{ optional($investmentDeclarationsubb)->IT ?? '' }}">
                                                                            </td>
                                                                    </tr>
                                                                    <tr>
                                                                    <td> Income other then Salary Income	 </td>
                                                                        <td>   If yes, then Form 12C detailing other income is <br>attached(only interest)		</td>
                                                                        <td><b></b></td>
                                                                      <td>
                                                                                <!-- <input 
                                                                                    type="number" 
                                                                                    
                                                                                    readonly> -->
                                                                            </td>
                                                                            <td>
                                                                                <!-- <input name="" type="number" > -->
                                                                            </td>
                                                                    </tr>
                                                                
                                                                    <tr>
                                                                        <td rowspan="2">  Deduction under Section 24	</td>
                                                                        <td> Interest on Housing Loan	</td>
                                                                        <td><b>200000/-</b></td>
                                                                        <td>
                                                                                <input type="number" id="ihl_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->IHL ?? '' }}"readonly>
                                                                            </td>
                                                                        <td>
                                                                                <input name="ihl" type="number" id="ihl_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->IHL ?? '' }}">
                                                                            </td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td>  Interest if the loan is taken before 01/04/99	</td>
                                                                        <td><b>30000/-</b></td>
                                                                        <td>
                                                                                <input type="number" id="il_readonly"
                                                                                    value="{{ optional($investmentDeclaration)->IL ?? '' }}"readonly>
                                                                            </td>
                                                                        <td>
                                                                                <input name="il" type="number" id="il_edit" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->IL ?? '' }}">
                                                                                </td>

                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            @endif

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
                                                                        value="{{ isset($investmentDeclarationsubb->SubmittedDate) ? $investmentDeclarationsubb->SubmittedDate : now()->format('d-m-Y') }}"><br><br>

                                                                    <label for="place"><b>Place:</b></label>
                                                                    <input type="text" id="place" name="place"
                                                                        value="{{ isset($investmentDeclarationsubb->Place) ? $investmentDeclarationsubb->Place : '' }}"><br><br>
                                                                </div>
                                                                <div class="float-end mt-3">
                                                                    <b>Signature</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($employeeData && $employeeData->OpenYN == 'Y')

                                                            <!-- submit and Reset Buttons -->
                                                            @if(isset($investmentDeclarationsubb) && $investmentDeclarationsubb->FormSubmit != "YY")
        
                                                            <div class="form-group text-center">
                                                            

                                                                <button type="submit" class="btn btn-secondary" id="submit-button-sub"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Submit
                                                            </button>
                                                            <button type="submit" class="btn btn-secondary" id="save-button-sub"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Save
                                                            </button>

                                                            </div>

                                                            @elseif(isset($investmentDeclarationsubb) && $investmentDeclarationsubb->FormSubmit == "YY")
        
                                                            <div class="form-group text-center">
                                                            
                                                                    <!-- Edit Button -->
                                                                    <button type="button" class="btn btn-primary" id="edit-button-sub" style="display:none;">
                                                                                                                                    Edit
                                                                                                                                </button>
                                                                <button type="submit" class="btn btn-secondary" id="submit-button-sub" style="display:none;"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Submit
                                                            </button>
                                                            <button type="submit" class="btn btn-secondary" id="save-button-sub" style="display:none;"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Save
                                                            </button>

                                                            </div>
                                                            
                                                            @else
                                                            <div class="form-group text-center">
                                                            <!-- Edit Button -->
                                                                <button type="button" class="btn btn-primary" id="edit-button-sub">
                                                                    Edit
                                                                </button>
                                                            <button type="submit" class="btn btn-secondary" id="save-button-sub" style="display:none;"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Save
                                                            </button>

                                                            </div>
                                                            @endif
                                                            @endif

                                
                                                        
                                                        </form>
                                                    </div>                                                      
                                                </div>
                                                        </div>
                                                @endif
                                                    
                                                @if(($investmentDeclaration->Regime ?? 'new') == 'new' || ($investmentDeclarationsubb->Regime ?? 'new') == 'new')
                                                    
                                                        <!-- Display "New Regime" Title -->
                                                        <h5 class="ad-title mb-0" style="padding:10px;" id="newregimelabel">New Regime</h5>

                                                        <!-- New Regime Content -->
                                                        <div class="tab-content">                                                        
                                                        <div class="tab-pane fade show" id="newregimesub" role="tabpanel" aria-labelledby="newregime-tab2">
                                                        <div class="tab-pane fade active table-responsive show" id="newregimesub-content" role="tabpanel">
                                                        <div id="printable-area">
                                                            <!-- Employee Details -->
                                                            <ul class="user-details">
                                                            <p><b>Employee Code:</b> {{$employeeData->EmpCode ?? ''}}</p>
                                                            <p><b>Employee Name:</b> {{ $employeeData->Fname ?? '' }} {{ $employeeData->Sname ?? '' }} {{ $employeeData->Lname ?? '' }}</p>
                                                            <p><b>PAN Number:</b> {{$employeeData->PanNo ?? 'N/A'}}</p>
                                                            <p><b>Company Name:</b> {{$employeeData->CompanyName ?? 'N/A'}}</p>
                                                            </ul>

                                                            <br>
                                                            <p><b>Please remember the following points while filling up the form</b></p>
                                                            <ol style="color: #686464;">
                                                                <li>You are requested to submit the required proofs up to the last date of submission, failing which it will be assumed that the employee does not have any tax.</li>
                                                                <li>Saving and income other than salary, and the Income Tax will be recomputed and tax will be deducted accordingly.</li>
                                                            </ol>

                                                            <p><b>(To be used to declare investment for income tax that will be made during the period)</b></p><br>
                                                            <p><b>Deduction Under Section 10</b></p>
                                                        </div>
                                                        <button type="button" class="btn btn-secondary" id="print-button-sub-new"style="float:right;">
                                                                <i class="fa fa-print"></i> <!-- Font Awesome print icon -->
                                                            </button>
                                                        <form id="investment-form-submission-new" method="POST" action="{{ route('save.investment.submission') }}">
                                                        @csrf
                                                        
                                                        <input type="hidden" name="selected_regime" id="selected-regime"
                                                                value="{{$investmentDeclaration->Regime ?? 'new'}}">
                                                            <input type="hidden" name="period_sub" id="period_sub" value="{{$investmentDeclaration->Period?? $PrdCurr}}">
                                                            <input type="hidden" name="c_month" id="c_month" 
                                                            value="{{ $employeeData && isset($employeeData->C_Month) ? $employeeData->C_Month : optional($investmentDeclarationlimit)->C_Month }}">

                                                            <input type="hidden" name="y_id" id="y_id" value="{{ optional($employeeData)->C_YearId ?? $investmentDeclarationlimit->C_YearId}}">
                                                     
                                                            <input type="hidden" name="empcode" id="empcode" 
                                                                value="{{ isset($employeeData) && isset($employeeData->EmpCode) ? $employeeData->EmpCode : Auth::user()->EmpCode  }}">
                                                                @if($investmentDeclarationsubb)

                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submission Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Sec. 80CCD(2)</td>
                                                                    <td>Corporate NPS Scheme</td>
                                                                    <td>10% Of Basic Salary</td>
                                                                    <td>
                                                                            <input 
                                                                                type="number" id="cornps_readonly_new"
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="cornps_edit_new" name="cornps"
                                                                                value="{{ optional($investmentDeclarationsubb)->CorNPS ?? '' }}">
                                                                        </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        @else
                                                        <table class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width: 10%;">Item</th>
                                                                    <th>Particulars</th>
                                                                    <th style="width: 7%;">Max. Limit</th>
                                                                    <th style="width: 14%;">Declared Amount</th>
                                                                    <th style="width: 14%;">Submission Amount</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Sec. 80CCD(2)</td>
                                                                    <td>Corporate NPS Scheme</td>
                                                                    <td>10% Of Basic Salary</td>
                                                                    <td>
                                                                            <input 
                                                                                type="number" id="cornps_readonly_new"
                                                                                value="{{ optional($investmentDeclaration)->CorNPS ?? '' }}" readonly>
                                                                        </td>
                                                                        <td>
                                                                            <input 
                                                                                type="number" id="cornps_edit_new" name="cornps" readonly
                                                                                value="{{ optional($investmentDeclarationsubb)->CorNPS ?? '' }}">
                                                                        </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        @endif
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
                                                                    <label for="date"><b>Date:</b></label>
                                                                    <input type="date" id="datenew" name="date" 
                                                                        value="{{ isset($investmentDeclarationsubb->SubmittedDate) ? $investmentDeclarationsubb->SubmittedDate : now()->format('d-m-Y') }}"><br><br>

                                                                    <label for="place"><b>Place:</b></label>
                                                                    @if(isset($investmentDeclarationsubb->Place))
                                                                        <input type="text" id="placenew" name="place"
                                                                            value="{{ $investmentDeclarationsubb->Place ?? '' }}"><br><br>
                                                                    @else
                                                                        <input type="text" id="placenew" name="place"
                                                                            value="{{ $investmentDeclaration->Place ?? '' }}"><br><br>
                                                                    @endif

                                                                </div>
                                                                <div class="float-end mt-3">
                                                                    <b>Signature</b>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($employeeData && $employeeData->OpenYN == 'Y')
        
                                                            <!-- submit and Reset Buttons -->
                                                            @if(isset($investmentDeclarationsubb) && $investmentDeclarationsubb->FormSubmit != "YY")
        
                                                            <div class="form-group text-center">
                                                                <button type="submit" class="btn btn-secondary" id="submit-button-sub-new"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Submit
                                                            </button>
                                                            <button type="submit" class="btn btn-secondary" id="save-button-sub-new"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Save
                                                            </button>

                                                            </div>
                                                            @elseif(isset($investmentDeclarationsubb) && $investmentDeclarationsubb->FormSubmit == "YY")
                                                            <div class="form-group text-center">
                                                            <!-- Edit Button -->
                                                                <button type="button" class="btn btn-primary" id="edit-button-sub-new" style="display:none;">
                                                                    Edit
                                                                </button>
                                                                <button type="submit" class="btn btn-secondary" id="submit-button-sub-new" style="display:none;"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Submit
                                                            <button type="submit" class="btn btn-secondary" id="save-button-new" style="display:none;"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Save
                                                            </button>

                                                            </div>
                                                            @else
                                                            <div class="form-group text-center">
                                                            <!-- Edit Button -->
                                                                <button type="button" class="btn btn-primary" id="edit-button-sub-new">
                                                                    Edit
                                                                </button>
                                                            <button type="submit" class="btn btn-secondary" id="save-button-sub-new" style="display:none;"
                                                                    @if($employeeData && $employeeData->OpenYN != 'Y')
                                                                        disabled
                                                                    @endif>
                                                                Save
                                                            </button>

                                                            </div>
                                                            </form>

                                                            @endif
                                                            @endif
                                                </div>
                                                        </div>
                                            @endif

                                        </div>
                                        </ul>
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            // Set default regime on window load based on the server-side value
        document.addEventListener('DOMContentLoaded', function() {
            let defaultRegime = "{{ $investmentDeclaration->Regime ?? $investmentDeclarationsubb->Regime ?? 'old' }}";
            console.log("Default Regime on Load:", defaultRegime.trim()); // Debugging
            toggleRegime(defaultRegime.trim()); // Ensure no extra spaces
        });
        $(document).ready(function () {
    // Enable form fields on Edit button click
    $('#edit-btn').click(function () {
        $('#investment-form input').removeAttr('disabled readonly'); // Remove both attributes
        $('#save-btn').removeClass('d-none'); // Show Save  buttons
    });
  
    $('#edit-btn-new').click(function () {
        $('#investment-form-new input').not('#datenew').removeAttr('disabled readonly'); // Exclude date field
        $('#save-btn-new').removeClass('d-none'); // Show Save & Submit buttons
    });
       // Check Blade condition to remove readonly if needed
    @if ($investmentDeclaration === null || $investmentDeclaration->FormSubmit == "Y")
            $('#investment-form input').removeAttr('readonly');
     @endif
      // Check Blade condition to remove readonly if needed
      @if ($investmentDeclaration === null || $investmentDeclaration->FormSubmit == "Y")
            $('#investment-form-new input').removeAttr('readonly');
        @endif
        @if ($investmentDeclaration === null)
            $('#investment-form input').attr('readonly', 'readonly'); // Correct way to add readonly
            $('#investment-form-new input').attr('readonly', 'readonly');
        @endif
    // Function to handle AJAX submission
    function sendFormData(statusValue) {
        console.log(statusValue);
        $('#lta-amount').prop('disabled', false);
        $('#cea-amount').prop('disabled', false);


        let formData = $('#investment-form').serialize(); // Get all form data
        formData += '&status=' + statusValue; // Append status (Y for Save, YY for Submit)

        // Show loader and disable buttons
        $('#loader').show();
        $.ajax({
            url: "{{ route('save.investment.declaration') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                $('#loader').hide(); // Ensure the loader is hidden regardless of success or failure

                if (response.success) {
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 10000  // Duration for which the toast is visible (in ms)
                            });
                            // Optionally, you can hide the modal and reset the form after a delay
                            setTimeout(function () {
                                location.reload();
                            }, 2000);  // 2000 milliseconds = 2 seconds
                        } else {
                            // Display error toast
                            toastr.error(response.message, 'Error', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            });
                        $('#loader').hide(); 

                            
                        }
              
            },
        });
    }
    
    function sendFormDataNew(statusValue) {
        console.log(statusValue);
        let formData = $('#investment-form-new').serialize(); // Get all form data
        formData += '&status=' + statusValue; // Append status (Y for Save, YY for Submit)

        // Show loader and disable buttons
        $('#loader').show();

        $.ajax({
            url: "{{ route('save.investment.declaration') }}",
            type: "POST",
            data: formData,
            success: function (response) {
                $('#loader').hide(); // Ensure the loader is hidden regardless of success or failure

                if (response.success) {
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 10000  // Duration for which the toast is visible (in ms)
                            });
                            // Optionally, you can hide the modal and reset the form after a delay
                            setTimeout(function () {
                                location.reload();
                            }, 2000);  // 2000 milliseconds = 2 seconds
                        } else {
                            // Display error toast
                            toastr.error(response.message, 'Error', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            });
                        $('#loader').hide(); 

                            
                        }
              
            },
            
        });
    }

    // Save Button Click - Send 'Y'
    $('#save-btn').click(function (e) {
        e.preventDefault(); // Prevent default form submission
        sendFormData('Y');
    });

    // Submit Button Click - Send 'YY'
    $('#submit-btn').click(function (e) {
        e.preventDefault(); // Prevent default form submission
        sendFormData('YY');
    });
    // Save Button Click - Send 'Y'
    $('#save-btn-new').click(function (e) {
        e.preventDefault(); // Prevent default form submission
        sendFormDataNew('Y');
    });

    // Submit Button Click - Send 'YY'
    $('#submit-btn-new').click(function (e) {
        e.preventDefault(); // Prevent default form submission
        sendFormDataNew('YY');
    });
});

            document.getElementById('print-button').addEventListener('click', function () {
    const form = document.getElementById('investment-form');
    const editButton = document.getElementById('edit-btn');
    const submitButton = document.getElementById('submit-btn');
    const saveButton = document.getElementById('save-btn');

    const printableContent = document.getElementById('printable-area').innerHTML;

    // Temporarily hide the buttons
    if (editButton) editButton.style.display = 'none';
    if (submitButton) submitButton.style.display = 'none';
    if (saveButton) saveButton.style.display = 'none';

    // Remove hidden fields (like CSRF token or other hidden inputs) for print preview
    const hiddenFields = form.querySelectorAll('input[type="hidden"]');
    const hiddenFieldsBackup = [];
                
    hiddenFields.forEach(field => {
        hiddenFieldsBackup.push({
            element: field,
            value: field.value, // Store the value of the hidden field
        });
        field.parentElement.removeChild(field); // Remove the hidden input fields from the form
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
                <div>${printableContent}</div>
                ${form.innerHTML.replace(/<input[^>]*>/g, (match) => {
                                                let value = match.match(/value="([^"]*)"/);
                                                if (value) {
                                                    let dateValue = value[1];
                                                    // Check if the value is a date and convert it to dd-mm-yyyy format
                                                    if (dateValue.match(/\d{4}-\d{2}-\d{2}/)) {
                                                        // Convert yyyy-mm-dd to dd-mm-yyyy
                                                        let dateParts = dateValue.split('-');
                                                        dateValue = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                                                    }
                                                    return `<span>${dateValue}</span>`; // Replace the input with the formatted date value
                                                }
                                                return ''; // Default case if there's no value
                                            })}
            </div>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();

    // Restore the hidden fields after printing
    hiddenFieldsBackup.forEach(fieldData => {
        const restoredField = document.createElement('input');
        restoredField.type = 'hidden';
        restoredField.name = fieldData.element.name;
        restoredField.value = fieldData.value; // Restore the original value
        form.appendChild(restoredField); // Add the restored field back to the form
    });

    @if( $investmentDeclaration === null || $investmentDeclaration->FormSubmit !== "YY")
                        if (editButton) editButton.style.display = 'inline-block';
                        if (submitButton) submitButton.style.display = 'inline-block';
                        if (saveButton) saveButton.style.display = 'inline-block';
                
                @endif
            });

            document.getElementById('print-button-new').addEventListener('click', function () {
                const form = document.getElementById('investment-form-new');
                const editButtonNew = document.getElementById('edit-btn-new');
                const submitButtonNew = document.getElementById('submit-btn-new');
                const saveButtonNew = document.getElementById('save-btn-new');

                const printableContent = document.getElementById('printable-area').innerHTML;

                // Temporarily hide the buttons
                if (editButtonNew) editButtonNew.style.display = 'none';
                if (submitButtonNew) submitButtonNew.style.display = 'none';
                if (saveButtonNew) saveButtonNew.style.display = 'none';


                const hiddenFields = form.querySelectorAll('input[type="hidden"]');

                                const hiddenFieldsBackup = [];
                                
                                hiddenFields.forEach(field => {
                                    hiddenFieldsBackup.push({
                                        element: field,
                                        value: field.value, // Store the value of the hidden field
                                    });
                                    field.parentElement.removeChild(field); // Remove the hidden input fields from the form
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
                                        <div>${printableContent}</div>
                            ${form.innerHTML.replace(/<input[^>]*>/g, (match) => {
                                                let value = match.match(/value="([^"]*)"/);
                                                if (value) {
                                                    let dateValue = value[1];
                                                    // Check if the value is a date and convert it to dd-mm-yyyy format
                                                    if (dateValue.match(/\d{4}-\d{2}-\d{2}/)) {
                                                        // Convert yyyy-mm-dd to dd-mm-yyyy
                                                        let dateParts = dateValue.split('-');
                                                        dateValue = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                                                    }
                                                    return `<span>${dateValue}</span>`; // Replace the input with the formatted date value
                                                }
                                                return ''; // Default case if there's no value
                                            })}
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
                printWindow.close();

                  // Restore the hidden fields after printing
                  hiddenFieldsBackup.forEach(fieldData => {
                                    const restoredField = document.createElement('input');
                                    restoredField.type = 'hidden';
                                    restoredField.name = fieldData.element.name;
                                    restoredField.value = fieldData.value; // Restore the original value
                                    form.appendChild(restoredField); // Add the restored field back to the form
                                });

                                @if( $investmentDeclaration === null || $investmentDeclaration->FormSubmit !== "YY")

                                if (editButtonNew) editButtonNew.style.display = 'inline-block';
                                if (submitButtonNew) submitButtonNew.style.display = 'inline-block';
                                if (saveButtonNew) saveButtonNew.style.display = 'inline-block';
                                @endif
            });
            
            
            const printButtonSubNew = document.getElementById('print-button-sub-new');
            if (printButtonSubNew) {
            document.getElementById('print-button-sub-new').addEventListener('click', function () {
                                const form = document.getElementById('investment-form-submission-new');
                                const editButtonsub = document.getElementById('edit-button-sub');
                                const submitButtonsub = document.getElementById('submit-button-sub');
                                const saveButtonsub = document.getElementById('save-button-sub');
                                const editButtonsubnew = document.getElementById('edit-button-sub-new');
                                const saveButtonsubnew = document.getElementById('save-button-sub-new');
                                const submitButtonsubnew = document.getElementById('submit-button-sub-new');
                                const printableContent = document.getElementById('printable-area').innerHTML;

                                // Temporarily hide the buttons
                                if (editButtonsub) editButtonsub.style.display = 'none';
                                if (saveButtonsub) saveButtonsub.style.display = 'none';
                                if (submitButtonsub) submitButtonsub.style.display = 'none';
                                if (editButtonsubnew) editButtonsubnew.style.display = 'none';
                                if (saveButtonsubnew) saveButtonsubnew.style.display = 'none';
                                if (submitButtonsubnew) submitButtonsubnew.style.display = 'none';

                                // Temporarily remove hidden fields for print preview but store them in a variable
                                const hiddenFields = form.querySelectorAll('input[type="hidden"]');
                                const hiddenFieldsBackup = [];
                                
                                hiddenFields.forEach(field => {
                                    hiddenFieldsBackup.push({
                                        element: field,
                                        value: field.value, // Store the value of the hidden field
                                    });
                                    field.parentElement.removeChild(field); // Remove the hidden input fields from the form
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
                                            .print-header {
                                                text-align: center;
                                                font-size: 24px;
                                                margin-bottom: 20px;
                                            }
                                        </style>
                                    </head>
                                    <body>
                                        <!-- Insert the header at the top of the print page -->
                                        <div class="print-header">
                                            <h4 class="text-center">Investment Submission Form ${'{{$investmentDeclaration->Period ?? '2024-2025'}}'}</h4>
                                        </div>
                                        
                                        <div>
                                        <div>${printableContent}</div>

                                            ${form.innerHTML.replace(/<input[^>]*>/g, (match) => {
                                                let value = match.match(/value="([^"]*)"/);
                                                if (value) {
                                                    let dateValue = value[1];
                                                    // Check if the value is a date and convert it to dd-mm-yyyy format
                                                    if (dateValue.match(/\d{4}-\d{2}-\d{2}/)) {
                                                        // Convert yyyy-mm-dd to dd-mm-yyyy
                                                        let dateParts = dateValue.split('-');
                                                        dateValue = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                                                    }
                                                    return `<span>${dateValue}</span>`; // Replace the input with the formatted date value
                                                }
                                                return ''; // Default case if there's no value
                                            })}
                                        </div>
                                    </body>
                                    </html>
                                `);
                                printWindow.document.close();
                                printWindow.focus();
                                printWindow.print();
                                printWindow.close();

                                // Restore the hidden fields after printing
                                hiddenFieldsBackup.forEach(fieldData => {
                                    const restoredField = document.createElement('input');
                                    restoredField.type = 'hidden';
                                    restoredField.name = fieldData.element.name;
                                    restoredField.value = fieldData.value; // Restore the original value
                                    form.appendChild(restoredField); // Add the restored field back to the form
                                });

                                // Restore the buttons after printing
                            @if(isset($investmentDeclarationsubb) && $investmentDeclarationsubb->FormSubmit != "YY")

                                if (editButtonsub) editButtonsub.style.display = 'inline-block';
                                if (submitButtonsub) submitButtonsub.style.display = 'inline-block';
                                if (saveButtonsub) saveButtonsub.style.display = 'inline-block';
                                if (editButtonsubnew) editButtonsubnew.style.display = 'inline-block';
                                if (saveButtonsubnew) saveButtonsubnew.style.display = 'inline-block';
                                if (submitButtonsubnew) submitButtonsubnew.style.display = 'inline-block';
                                @endif
            });
            }

            const printButtonSub= document.getElementById('print-button-sub');
            if (printButtonSub) {
            document.getElementById('print-button-sub').addEventListener('click', function () {
                const form = document.getElementById('investment-form-submission');
                const editButtonsub = document.getElementById('edit-button-sub');
                const submitButtonsub = document.getElementById('submit-button-sub');
                const saveButtonsub = document.getElementById('save-button-sub');
                const editButtonsubnew = document.getElementById('edit-button-sub-new');
                const saveButtonsubnew = document.getElementById('save-button-sub-new');
                const submitButtonsubnew = document.getElementById('submit-button-sub-new');
                const printableContent = document.getElementById('printable-area').innerHTML;

                // Temporarily hide the buttons
                if (editButtonsub) editButtonsub.style.display = 'none';
                if (saveButtonsub) saveButtonsub.style.display = 'none';
                if (submitButtonsub) submitButtonsub.style.display = 'none';
                if (editButtonsubnew) editButtonsubnew.style.display = 'none';
                if (saveButtonsubnew) saveButtonsubnew.style.display = 'none';
                if (submitButtonsubnew) submitButtonsubnew.style.display = 'none';

                // Temporarily remove hidden fields for print preview but store them in a variable
                const hiddenFields = form.querySelectorAll('input[type="hidden"]');
                const hiddenFieldsBackup = [];
                
                hiddenFields.forEach(field => {
                    hiddenFieldsBackup.push({
                        element: field,
                        value: field.value, // Store the value of the hidden field
                    });
                    field.parentElement.removeChild(field); // Remove the hidden input fields from the form
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
                            .print-header {
                                text-align: center;
                                font-size: 24px;
                                margin-bottom: 20px;
                            }
                        </style>
                    </head>
                    <body>
                        <!-- Insert the header at the top of the print page -->
                        <div class="print-header">
                            <h4 class="text-center">Investment Submission Form ${'{{$investmentDeclaration->Period ?? '2024-2025'}}'}</h4>
                                    </div>
                                    
                                    <div>
                                        <div>${printableContent}</div>

                                        ${form.innerHTML.replace(/<input[^>]*>/g, (match) => {
                                            let value = match.match(/value="([^"]*)"/);
                                            if (value) {
                                                let dateValue = value[1];
                                                // Check if the value is a date and convert it to dd-mm-yyyy format
                                                if (dateValue.match(/\d{4}-\d{2}-\d{2}/)) {
                                                    // Convert yyyy-mm-dd to dd-mm-yyyy
                                                    let dateParts = dateValue.split('-');
                                                    dateValue = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                                                }
                                                return `<span>${dateValue}</span>`; // Replace the input with the formatted date value
                                            }
                                            return ''; // Default case if there's no value
                                        })}
                                    </div>
                                </body>
                                </html>
                            `);
                            printWindow.document.close();
                            printWindow.focus();
                            printWindow.print();
                            printWindow.close();

                            // Restore the hidden fields after printing
                            hiddenFieldsBackup.forEach(fieldData => {
                                const restoredField = document.createElement('input');
                                restoredField.type = 'hidden';
                                restoredField.name = fieldData.element.name;
                                restoredField.value = fieldData.value; // Restore the original value
                                form.appendChild(restoredField); // Add the restored field back to the form
                            });
                            @if(isset($investmentDeclarationsubb) && $investmentDeclarationsubb->FormSubmit != "YY")
                                if (editButtonsub) editButtonsub.style.display = 'inline-block';
                                if (submitButtonsub) submitButtonsub.style.display = 'inline-block';
                                if (saveButtonsub) saveButtonsub.style.display = 'inline-block';
                                if (editButtonsubnew) editButtonsubnew.style.display = 'inline-block';
                                if (saveButtonsubnew) saveButtonsubnew.style.display = 'inline-block';
                                if (submitButtonsubnew) submitButtonsubnew.style.display = 'inline-block';
                            @endif
                           
                        });
                    }
            

            const editButtonSub= document.getElementById('edit-button-sub');
            if (editButtonSub) {    
                document.getElementById('edit-button-sub').addEventListener('click', function () {
                    // Get the value of the readonly input
                    const readonlyValue = document.getElementById('hra-readonly').value;
                    const editableInput = document.getElementById('hra-editable');
                    editableInput.value = readonlyValue;
                    editableInput.removeAttribute('readonly');


                    // LTA Section
                    const ltaReadonlyValue = document.getElementById('lta-amount-readonly').value;
                    const ltaEditableInput = document.getElementById('lta-amount-editable');
                    ltaEditableInput.value = ltaReadonlyValue; // Transfer value
                    ltaEditableInput.removeAttribute('readonly');


                    // CEA Section
                    const ceaReadonlyValue = document.getElementById('cea-amount-readonly').value;
                    const ceaEditableInput = document.getElementById('cea-amount-editable');
                    ceaEditableInput.value = ceaReadonlyValue; // Transfer value
                    ceaEditableInput.removeAttribute('readonly');


                    // Enable checkboxes in the CEA section
                    document.getElementById('child1-checkbox').removeAttribute('readonly');
                    document.getElementById('child2-checkbox').removeAttribute('readonly');

                    // LTA Section
                    const medicalInsuranceReadonly = document.getElementById('medical_insurance_readonly').value;
                    const medicalInsuranceEditable = document.getElementById('medical_insurance_edit');
                    medicalInsuranceEditable.value = medicalInsuranceReadonly; // Transfer value
                    medicalInsuranceEditable.removeAttribute('readonly');


                    // Medical Treatment Handicapped Section
                    const medicalTreatmentHandicappedReadonly = document.getElementById('medical_treatment_handicapped_readonly').value;
                    const medicalTreatmentHandicappedEditable = document.getElementById('medical_treatment_handicapped_edit');
                    medicalTreatmentHandicappedEditable.value = medicalTreatmentHandicappedReadonly; // Transfer value
                    medicalTreatmentHandicappedEditable.removeAttribute('readonly');


                    // Medical Treatment Disease Section
                    const medicalTreatmentDiseaseReadonly = document.getElementById('medical_treatment_disease_readonly').value;
                    const medicalTreatmentDiseaseEditable = document.getElementById('medical_treatment_disease_edit');
                    medicalTreatmentDiseaseEditable.value = medicalTreatmentDiseaseReadonly; // Transfer value
                    medicalTreatmentDiseaseEditable.removeAttribute('readonly');


                    // Loan Repayment Section
                    const loanRepaymentReadonly = document.getElementById('repay_of_loan_readonly').value;
                    const loanRepaymentEditable = document.getElementById('repay_of_loan_edit');
                    loanRepaymentEditable.value = loanRepaymentReadonly; // Transfer value
                    loanRepaymentEditable.removeAttribute('readonly');



                    // Handicapped Deduction Section
                    const handicappedDeductionReadonly = document.getElementById('handicapped_deduction_readonly').value;
                    const handicappedDeductionEditable = document.getElementById('handicapped_deduction_edit');
                    handicappedDeductionEditable.value = handicappedDeductionReadonly; // Transfer value
                    handicappedDeductionEditable.removeAttribute('readonly');
                    



        // Pension Fund Contribution
        const pensionFundReadonly = document.getElementById('pension_fund_contribution_readonly').value;
        const pensionFundEditable = document.getElementById('pension_fund_contribution_edit');
        pensionFundEditable.value = pensionFundReadonly;
        pensionFundEditable.removeAttribute('readonly');


        // Life Insurance Section
        const lifeInsuranceReadonly = document.getElementById('life_insurance_readonly').value;
        const lifeInsuranceEditable = document.getElementById('life_insurance_edit');
        lifeInsuranceEditable.value = lifeInsuranceReadonly;
        lifeInsuranceEditable.removeAttribute('readonly');


        // Deferred Annuity Section
        const deferredAnnuityReadonly = document.getElementById('deferred_annuity_readonly').value;
        const deferredAnnuityEditable = document.getElementById('deferred_annuity_edit');
        deferredAnnuityEditable.value = deferredAnnuityReadonly;
        deferredAnnuityEditable.removeAttribute('readonly');


        // PPF Section
        const ppfReadonly = document.getElementById('ppf_readonly').value;
        const ppfEditable = document.getElementById('ppf_edit');
        ppfEditable.value = ppfReadonly;
        ppfEditable.removeAttribute('readonly');


        // Post Office Section
        const postOffReadonly = document.getElementById('PostOff_readonly').value;
        const postOffEditable = document.getElementById('PostOff_edit');
        postOffEditable.value = postOffReadonly;
        postOffEditable.removeAttribute('readonly');



        // ULIP Section
        const ulipReadonly = document.getElementById('post_off_readonly').value;
        const ulipEditable = document.getElementById('post_off_edit');
        ulipEditable.value = ulipReadonly;
        ulipEditable.removeAttribute('readonly');



        // Housing Loan Section
        const housingLoanReadonly = document.getElementById('housing_loan_readonly').value;
        const housingLoanEditable = document.getElementById('housing_loan_edit');
        housingLoanEditable.value = housingLoanReadonly;
        housingLoanEditable.removeAttribute('readonly');


        // Mutual Funds Section
        const mutualFundsReadonly = document.getElementById('mutual_funds_readonly').value;
        const mutualFundsEditable = document.getElementById('mutual_funds_edit');
        mutualFundsEditable.value = mutualFundsReadonly;
        mutualFundsEditable.removeAttribute('readonly');


        // Infrastructure Bonds Section
        const infrastructureBondsReadonly = document.getElementById('infrastructure_bonds_readonly').value;
        const infrastructureBondsEditable = document.getElementById('infrastructure_bonds_edit');
        infrastructureBondsEditable.value = infrastructureBondsReadonly;
        infrastructureBondsEditable.removeAttribute('readonly');


        // Tuition Fee Section
        const tuitionFeeReadonly = document.getElementById('tuition_fee_readonly').value;
        const tuitionFeeEditable = document.getElementById('tuition_fee_edit');
        tuitionFeeEditable.value = tuitionFeeReadonly;
        tuitionFeeEditable.removeAttribute('readonly');


        // Deposit in NHB Section
        const depositInNHBReadonly = document.getElementById('deposit_in_nhb_readonly').value;
        const depositInNHBEditable = document.getElementById('deposit_in_nhb_edit');
        depositInNHBEditable.value = depositInNHBReadonly;
        depositInNHBEditable.removeAttribute('readonly');


        // Deposit in NSC Section
        const depositInNSCReadonly = document.getElementById('deposit_in_nsc_readonly').value;
        const depositInNSCEditable = document.getElementById('deposit_in_nsc_edit');
        depositInNSCEditable.value = depositInNSCReadonly;
        depositInNSCEditable.removeAttribute('readonly');


        // Sukanya Samriddhi Section
        const sukanyaSamriddhiReadonly = document.getElementById('sukanya_samriddhi_readonly').value;
        const sukanyaSamriddhiEditable = document.getElementById('sukanya_samriddhi_edit');
        sukanyaSamriddhiEditable.value = sukanyaSamriddhiReadonly;
        sukanyaSamriddhiEditable.removeAttribute('readonly');


        // Employee Provident Fund Section
        const employeeProvidentFundReadonly = document.getElementById('others_employee_provident_fund_readonly').value;
        const employeeProvidentFundEditable = document.getElementById('others_employee_provident_fund_edit');
        employeeProvidentFundEditable.value = employeeProvidentFundReadonly;
        employeeProvidentFundEditable.removeAttribute('readonly');


        // Sec. 80CCD(1B) - NPS
        const apyReadonly = document.getElementById('apy_readonly').value;
        const apyEditable = document.getElementById('apy_edit');
        apyEditable.value = apyReadonly; // Transfer value
        apyEditable.removeAttribute('readonly');



        // Sec. 80CCD(2) - Corporate NPS Scheme
        const corNpsReadonly = document.getElementById('cornps_readonly').value;
        const corNpsEditable = document.getElementById('cornps_edit');
        corNpsEditable.value = corNpsReadonly; // Transfer value
        corNpsEditable.removeAttribute('readonly');



        // Previous Employment Salary - Form 16
        const form16Readonly = document.getElementById('form16limit_readonly').value;
        const form16Editable = document.getElementById('form16limit_edit');
        form16Editable.value = form16Readonly; // Transfer value
        form16Editable.removeAttribute('readonly');


        // Salary Paid by Previous Employer - Sec. 10 Exemption
        const spelimitReadonly = document.getElementById('spelimit_readonly').value;
        const spelimitEditable = document.getElementById('spelimit_edit');
        spelimitEditable.value = spelimitReadonly; // Transfer value
        spelimitEditable.removeAttribute('readonly');


        // Professional Tax Deducted by Previous Employer
        const ptlimitReadonly = document.getElementById('ptlimit_readonly').value;
        const ptlimitEditable = document.getElementById('ptlimit_edit');
        ptlimitEditable.value = ptlimitReadonly; // Transfer value
        ptlimitEditable.removeAttribute('readonly');


        // Provident Fund Deducted by Previous Employer
        const pfdlimitReadonly = document.getElementById('pfdlimit_readonly').value;
        const pfdlimitEditable = document.getElementById('pfdlimit_edit');
        pfdlimitEditable.value = pfdlimitReadonly; // Transfer value
        pfdlimitEditable.removeAttribute('readonly');


        // Income Tax Deducted by Previous Employer
        const itlimitReadonly = document.getElementById('itlimit_readonly').value;
        const itlimitEditable = document.getElementById('itlimit_edit');
        itlimitEditable.value = itlimitReadonly; // Transfer value
        itlimitEditable.removeAttribute('readonly');


        
        // Deduction under Section 24 - Interest on Housing Loan
        const ihlReadonly = document.getElementById('ihl_readonly').value;
        const ihlEditable = document.getElementById('ihl_edit');
        ihlEditable.value = ihlReadonly; // Transfer value
        ihlEditable.removeAttribute('readonly');


        // Interest if the loan is taken before 01/04/99
        const ilReadonly = document.getElementById('il_readonly').value;
        const ilEditable = document.getElementById('il_edit');
        ilEditable.value = ilReadonly; // Transfer value
        ilEditable.removeAttribute('readonly');


    
                });
                
                document.getElementById('edit-button-sub')?.addEventListener('click', function () {

                    // Show the Save button
                    const saveButton = document.getElementById('save-button-sub');
                    saveButton.style.display = 'inline-block';
                });
            }


            function toggleRegime(selectedRegime) {
    let oldRegimeDiv = document.getElementById('oldregimesub');
    let oldRegimeLabel = document.getElementById('oldregimelabel');

    let newRegimeDiv = document.getElementById('newregimesub');
    let newRegimeLabel = document.getElementById('newregimelabel');

    console.log("Selected Regime:", selectedRegime);
    console.log("Old Regime Div:", oldRegimeDiv);
    console.log("New Regime Div:", newRegimeDiv);

    if (oldRegimeDiv) oldRegimeDiv.style.display = (selectedRegime === 'old') ? 'block' : 'none';
    if (oldRegimeLabel) oldRegimeLabel.style.display = (selectedRegime === 'old') ? 'block' : 'none';

    if (newRegimeDiv) newRegimeDiv.style.display = (selectedRegime === 'new') ? 'block' : 'none';
    if (newRegimeLabel) newRegimeLabel.style.display = (selectedRegime === 'new') ? 'block' : 'none';
}

    const saveButtonnew = document.getElementById('save-button-sub-new');
    const submitButtonnew = document.getElementById('submit-button-sub-new');

    // Function to handle form submission for both regimes
    function handleFormSubmission(e, actionType) {
        e.preventDefault(); // Prevent default form submission

        // Determine which form to use based on the button clicked
        const form = e.target.closest('form'); // Automatically gets the correct form
        console.log('Form Submission for:', actionType);

        // Collect form data
        const formData = new FormData(form);

        // Get selected regime from the hidden field inside the form
        const selectedRegime = form.querySelector('input[name="selected_regime"]').value;

        // Append action type ('submit', 'save', 'submitnew', 'savenew') to the form data
        formData.append(actionType, actionType === 'submit' || actionType === 'submitnew' ? 1 : 0);

        // Add regime information to the form data
        formData.append('regime', selectedRegime);

        // Disable submit button and show loader
        $(form).find('button[type="submit"]').prop('disabled', true);
        $('#loader').show(); // Show the loader while processing

        // Get CSRF token
        const token = $('input[name="_token"]').val();

        // Perform the AJAX request to submit the form data
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => response.json())
        .then(data => {
            $('#loader').hide(); // Hide the loader after receiving the response

            if (data.success) {
                // Show success message using toastr
                toastr.success(data.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 3000
                });

                // Optionally reload the page after a delay
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                // Show error message using toastr
                toastr.error(data.message, 'Error', {
                    "positionClass": "toast-top-right",
                    "timeOut": 3000
                });

                // Re-enable the submit button if there's an error
                $(form).find('button[type="submit"]').prop('disabled', false);
            }
        })
        .catch(error => {
            // Handle errors in the fetch request
            $(form).find('button[type="submit"]').prop('disabled', false);
            $('#loader').hide();
            toastr.error('An error occurred while submitting the form. Please try again.', 'Error', {
                "positionClass": "toast-top-right",
                "timeOut": 3000
            });
            console.error('Error:', error);
        });
    }

    // New Regime Save Button
    saveButtonnew.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent normal form submission
        handleFormSubmission(e, 'savenew');
    });

    // New Regime Submit Button
    submitButtonnew.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent normal form submission
        handleFormSubmission(e, 'submitnew');
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
        </style>
        @include('employee.footer')
        