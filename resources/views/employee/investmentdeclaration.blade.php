@include('employee.header')


<body class="mini-sidebar">

 <div id="loader" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->


        <!-- Container Start -->
        <div class="page-wrapper">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                               
                            </div>
                        </div>
                    </div>

                <div class="py-5">
                    <div class="container">
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
                                                            <p><b>Even if you are not eligible or do not intend to declare any investments, it is mandatory to submit the declaration form. Please fill the form with zero amounts where applicable to complete the process.</b></p><br>
                                                            
                                                            <p><b>(To be used to declare investment for income tax that will be made during the period )</b></p><br>
                                                                    <p><b>Deduction under section 10</b></p>
                                                        
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
                                                                                        type="number" disabled
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
                                                        
                                                                                        <input id="cea-amount" name="cea_declared_amount" readonly type="number" class="form-control"
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
                                                            </div>
                                                            @if (!isset($investmentDeclaration) || (isset($investmentDeclaration) && $investmentDeclaration->FormSubmit != 'YY'))

                                                                <div class="form-group text-center">
                                                                    <button type="button" id="edit-btn" class="btn btn-primary">Edit</button>
                                                                    <button type="submit" id="submit-btn" class="btn btn-primary d-none">Submit</button>
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
                                                            <p><b>Even if you are not eligible or do not intend to declare any investments, it is mandatory to submit the declaration form. Please fill the form with zero amounts where applicable to complete the process.</b></p><br>
                                                            <p><b>(To be used to declare investment for income Tax that will be
                                                                    made during the period )</b></p><br>
                                                            <p><b>Deduction Under Section 10</b></p>
                                                       
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
                                                                @if (!isset($investmentDeclaration) || (isset($investmentDeclaration) && $investmentDeclaration->FormSubmit != 'YY'))
                                                                <div class="form-group text-center">
                                                                    <button type="button" id="edit-btn-new" class="btn btn-primary">Edit</button>
                                                                    <button type="submit" id="submit-btn-new" class="btn btn-primary d-none">Submit</button>
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
                        </div>
                    </div>
                </div>
        </div>

        
        @include('employee.footer');
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        (function() {
            // Push initial state
            history.pushState({ noBackExitsApp: true }, '', location.href);

            window.addEventListener('popstate', function (event) {
                console.log("Back button clicked");

                // Re-push the same state again to block repeated back presses
                history.pushState({ noBackExitsApp: true }, '', location.href);

                // Optional: Show a message or redirect
                alert("Back navigation is blocked.");
            });
        })();

            // Set default regime on window load based on the server-side value
        document.addEventListener('DOMContentLoaded', function() {
            let defaultRegime = "{{ $investmentDeclaration->Regime ?? $investmentDeclarationsubb->Regime ?? 'old' }}";
            console.log("Default Regime on Load:", defaultRegime.trim()); // Debugging
            toggleRegime(defaultRegime.trim()); // Ensure no extra spaces
        });
        $(document).ready(function () {
            // Enable form fields on Edit button click
       $('#edit-btn').click(function () {
            $('#investment-form input').not('#lta-amount, #cea-amount, #date').removeAttr('disabled readonly');
            $('#submit-btn').removeClass('d-none');

            // Remove old handlers first to avoid duplicate binding
            $('#investment-form input[type=number]').off('input.restrict keypress.restrict');

            // Input event to clean pasted text or programmatic changes
            $('#investment-form input[type=number]').on('input.restrict', function () {
                var val = $(this).val();
                // Keep only digits and dot
                var cleaned = val.replace(/[^0-9.]/g, '');

                // Allow only one dot
                var parts = cleaned.split('.');
                if (parts.length > 2) {
                    cleaned = parts.shift() + '.' + parts.join('');
                }

                if (val !== cleaned) {
                    $(this).val(cleaned);
                }
            });

            // Keypress to block disallowed chars while typing
            $('#investment-form input[type=number]').on('keypress.restrict', function (e) {
                var charCode = e.which || e.keyCode;
                var val = $(this).val();

                // Allow control keys: backspace(8), delete(46), arrow left(37), arrow right(39)
                if ([8, 46, 37, 39].indexOf(charCode) !== -1) {
                    return true;
                }

                // Allow digits (0-9)
                if (charCode >= 48 && charCode <= 57) {
                    return true;
                }

                // Allow one dot (.)
                if (charCode === 46) {
                    if (val.indexOf('.') === -1) {
                        return true;
                    }
                    e.preventDefault();
                    return false;
                }

                // Block everything else (letters, spaces, etc)
                e.preventDefault();
                return false;
            });
        });

        
            $('#edit-btn-new').click(function () {
                $('#investment-form-new input').not('#datenew').removeAttr('disabled readonly'); // Exclude date field
                $('#submit-btn-new').removeClass('d-none'); // Show Save & Submit buttons

                
            // Remove old handlers first to avoid duplicate binding
            $('#investment-form-new input[type=number]').off('input.restrict keypress.restrict');

            // Input event to clean pasted text or programmatic changes
            $('#investment-form-new input[type=number]').on('input.restrict', function () {
                var val = $(this).val();
                // Keep only digits and dot
                var cleaned = val.replace(/[^0-9.]/g, '');

                // Allow only one dot
                var parts = cleaned.split('.');
                if (parts.length > 2) {
                    cleaned = parts.shift() + '.' + parts.join('');
                }

                if (val !== cleaned) {
                    $(this).val(cleaned);
                }
            });

            // Keypress to block disallowed chars while typing
            $('#investment-form-new input[type=number]').on('keypress.restrict', function (e) {
                var charCode = e.which || e.keyCode;
                var val = $(this).val();

                // Allow control keys: backspace(8), delete(46), arrow left(37), arrow right(39)
                if ([8, 46, 37, 39].indexOf(charCode) !== -1) {
                    return true;
                }

                // Allow digits (0-9)
                if (charCode >= 48 && charCode <= 57) {
                    return true;
                }

                // Allow one dot (.)
                if (charCode === 46) {
                    if (val.indexOf('.') === -1) {
                        return true;
                    }
                    e.preventDefault();
                    return false;
                }

                // Block everything else (letters, spaces, etc)
                e.preventDefault();
                return false;
            });
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
                                    window.location.href = "{{ route('dashboard') }}";

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
                                   window.location.href = "{{ route('dashboard') }}";

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
        
     
