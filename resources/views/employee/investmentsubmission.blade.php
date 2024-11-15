@include('employee.head')
@include('employee.header');
@include('employee.sidebar');

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
        @include('employee.sidebar');
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
                                    <li class="breadcrumb-link active">Investment Declaration</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')
                
                <!-- Revanue Status Start -->
                <div class="row">     
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10" >
                        <div class="card chart-card ">
                            <div class="card-header" id="attendance">
                                <h4 class="text-center"id="investment-title"></h4>
                            </div>
                            <div class="card-body" style="padding-top:0px;">
                                <div class="mfh-machine-profile">
                                <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="oldregime-tab1" data-bs-toggle="tab" href="#oldregime" role="tab" aria-controls="OldRegime" aria-selected="true">Old Regime</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="newregime-tab20" data-bs-toggle="tab" href="#newregime" role="tab" aria-controls="newregime" aria-selected="false">New Regime</a>
                                    </li>
                                </ul>
                                <div class="tab-content splash-content2 mt-3" id="myTabContent2">
                                    <div class="tab-pane fade active table-responsive show" id="oldregime" role="tabpanel">
                                        <ul class="user-details">
                                            <li>Employee ID: {{$employeeData->EmpCode??''}}</li>
                                            <li>Employee Name: {{ $employeeData->Fname ?? '' }} {{ $employeeData->Sname ?? '' }}
                                            {{ $employeeData->Lname ?? '' }}</li>
                                            <li>PAN Number: {{$employeeData->PanNo ??'N/A'}}</li>
                                            <li>Company Name:{{$employeeData->CompanyName ??'N/A'}}</li>
                                        </ul>
                                        <br>
                                        <p><b>Please remember the following points while filling up the form</b></p>
                                        <ol style="color: #686464;">
                                            <li>Do not forget to mention you Employee Id , Name & Pan card .</li>
                                            <li>Only Submission Amount needs to be filled. Do not change the figures mentioned in Max. limit Column.</li>
                                            <li> You are requested to submit the required proofs up to last date of submission, failing which will be assumed that the employee does not have any Tax </li>
                                            <li>Saving and income other than salary, and the Income Tax will be recomputed and tax will be deducted accordingly.</li>
                                        </ol>
                                        <p><b>(To be used to declare investment for income Tax that will be made during the period )</b></p><br>
                                        <p><b>Deduction Under Section 10</b></p>
                                        <div id="message-container" style="display: none; margin-bottom: 20px;">
                                        <div id="success-message" style="color: green;"></div>
                                        <div id="error-message" style="color: red;"></div>
                                    </div>
                                        <form id="investment-form-submission" method="POST" action="{{ route('save.investment.submission') }}">
                                            @csrf
                                            <input type="hidden" name="selected_regime" id="selected-regime" value="">
                                            <input type="hidden" name="period" id="period" value="">
                                            <input type="hidden" name="c_month" id="c_month" value="{{$employeeData->C_Month}}">
                                            <input type="hidden" name="y_id" id="y_id" value="{{$employeeData->C_YearId}}">
                                            <input type="hidden" name="empcode" id="empcode" value="{{$employeeData->EmpCode}}">

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
                                                                <input type="number" name="house_rent_declared_amount" 
                                                                    value="{{ isset($investmentDeclaration->HRA) ? $investmentDeclaration->HRA : '' }}" >
                                                            </td>  
                                                         </tr>

                                                        <!-- LTA Section -->
                                                        <tr>
                                                        <td>LTA Sec 10(5)</td>
                                                        <td>I will provide the tickets/ Travel bills in original as per one basic annually the LTA policy or else the company can consider amount as taxable.</td>
                                                        <td><b>16000/-</b> 
                                                            <input id="lta-checkbox" name="lta_checkbox" style="float:right;height: 15px;" type="checkbox" 
                                                            @if(isset($investmentDeclaration->Curr_LTA)) checked @endif>
                                                        </td>
                                                        <td>
                                                            <input id="lta-amount" name="lta_declared_amount" type="text" class="form-control" 
                                                            value="{{ isset($investmentDeclaration->Curr_LTA) ? $investmentDeclaration->Curr_LTA : '' }}" >
                                                        </td>
                                                    </tr>


                                                        <!-- CEA Section -->
                                                        <tr>
                                                        <td>CEA Sec 10(14)</td>
                                                        <td>I will provide the copy of tuition fees receipt as per CEA policy or else the company can consider amount as taxable. (Rs.100/- per month per child up to a max of two children)</td>
                                                        <td><b>2400/-</b> 
                                                            <br>Child-1 
                                                            <input id="child1-checkbox" name="child1_checkbox" style="float:right;height: 15px;" type="checkbox">
                                                            Child-2 
                                                            <input id="child2-checkbox" name="child2_checkbox" style="float:right;height: 15px;" type="checkbox">
                                                        </td>
                                                        <td>
                                                            @if($investmentDeclaration->Curr_CEA)
                                                                <input id="cea-amount" name="cea_declared_amount" type="text" class="form-control" value="{{ $investmentDeclaration->Curr_CEA }}">
                                                            @else
                                                                <input id="cea-amount" name="cea_declared_amount" type="text" class="form-control">
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>

                                                <p style="color: #686464;">** If you have opted for the medical reimbursements (being Medical expenses part of your CTC)</p>
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
                                                        <td>Sec.80D - Medical Insurance Premium (If the policy covers a senior Citizen then additional deduction of Rs.5000/- is available & deduction on account of expenditure on preventive Health Check-Up (for Self, Spouse, Dependant Children & Parents) Shall not exceed in the aggregate Rs 5000/-.)</td>
                                                        <td><b>25000/-</b></td>
                                                        <td>
                                                            @if($investmentDeclaration->MIP)
                                                            
                                                                <input name="medical_insurance" type="number" value="{{ $investmentDeclaration->MIP }}" >

                                                            @else
                                                                <input name="medical_insurance" type="number">
                                                            @endif
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td></td>
                                                        <td>Sec. 80DD - Medical treatment/insurance of Handicapped Dependant A higher deduction of Rs. 100,000 is available, where such dependent is with severe disability of > 80%</td>
                                                        <td><b>50000/-</b></td>
                                                        <td>
                                                            @if($investmentDeclaration->MTI)
                                                                <input name="medical_treatment_handicapped" type="number" value="{{ $investmentDeclaration->MTI }}">

                                                            @else
                                                                <input name="medical_treatment_handicapped" type="number">
                                                            @endif
                                                        </td>
                                                    </tr>

                                                        <tr>
                                                            <td></td>
                                                            <td>Sec 80DDB - Medical treatment (specified diseases only) (medical treatment in respect of a senior Citizen then additional deduction of Rs.20,000/- is available)</td>
                                                            <td><b>40000/-</b></td>
                                                            <td>
                                                            @if($investmentDeclaration->MTS)
                                                                <input name="medical_treatment_disease" type="number" value="{{ $investmentDeclaration->MTS }}">
                                                            @else
                                                                <input name="medical_treatment_disease" type="number">
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Sec 80E - Repayment of Loan for higher education (only interest)</td>
                                                            <td>-</td>
                                                            <td>
                                                            @if($investmentDeclaration->ROL)
                                                                <input name="loan_repayment" type="number" value="{{ $investmentDeclaration->ROL }}">
                                                            @else
                                                            <input name="loan_repayment" type="number">
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Sec 80U - Handicapped</td>
                                                            <td><b>50000/-</b></td>
                                                            <td>
                                                            @if($investmentDeclaration->Handi)
                                                                <input name="handicapped_deduction" type="number" value="{{ $investmentDeclaration->Handi }}">
                                                            @else
                                                            <input name="handicapped_deduction" type="number">
                                                            @endif
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
                                                            <td>Sec 80CCC - Contribution to Pension Fund (Jeevan Suraksha)</td>
                                                            <td><b>25000/-</b></td>
                                                            <td>
                                                            @if($investmentDeclaration->PenFun)
                                                                <input name="pension_fund_contribution" type="number" value="{{ $investmentDeclaration->PenFun }}">
                                                            @else
                                                            <td><input name="pension_fund_contribution" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Life Insurance Premium</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->LIP)
                                                                <input name="life_insurance" type="number" value="{{ $investmentDeclaration->LIP }}">
                                                            @else
                                                            <td><input name="life_insurance" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Deferred Annuity</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->DA)
                                                                <input name="deferred_annuity" type="number" value="{{ $investmentDeclaration->DA }}">
                                                            @else
                                                            <td><input name="deferred_annuity" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Public Provident Fund</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->PPF)
                                                                <input name="ppf" type="number" value="{{ $investmentDeclaration->PPF }}">
                                                            @else
                                                            <td><input name="ppf" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Time Deposit in Post Office / Bank for 5 year & above</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->ULIP)
                                                                <input name="PostOff" type="number" value="{{ $investmentDeclaration->PPF }}">
                                                            @else
                                                            <td><input name="time_deposit" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>ULIP of UTI/LIC</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->ULIP)
                                                                <input name="ulip" type="number" value="{{ $investmentDeclaration->ULIP }}">
                                                            @else
                                                            <td><input name="ulip" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Principal Loan (Housing Loan) Repayment</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->HL)
                                                                <input name="housing_loan_repayment" type="number" value="{{ $investmentDeclaration->HL }}">
                                                            @else
                                                            <td><input name="housing_loan_repayment" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Mutual Funds</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->MF)
                                                                <input name="mutual_funds" type="number" value="{{ $investmentDeclaration->MF }}">
                                                            @else
                                                            <td><input name="mutual_funds" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Investment in infrastructure Bonds</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->IB)
                                                                <input name="infrastructure_bonds" type="number" value="{{ $investmentDeclaration->IB }}">
                                                            @else
                                                            <td><input name="infrastructure_bonds" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Children- Tuitions Fee restricted to max. of 2 children</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->CTF)
                                                                <input name="tuition_fee" type="number" value="{{ $investmentDeclaration->CTF }}">
                                                            @else
                                                            <td><input name="tuition_fee" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Deposit in NHB</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->NHB)
                                                                <input name="deposit_in_nhb" type="number" value="{{ $investmentDeclaration->NHB }}">
                                                            @else
                                                            <td><input name="deposit_in_nhb" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Deposit In NSC</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->NSC)
                                                                <input name="deposit_in_nsc" type="number" value="{{ $investmentDeclaration->NSC }}">
                                                            @else
                                                            <td><input name="deposit_in_nsc" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Sukanya Samriddhi</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->SukS)
                                                                <input name="sukanya_samriddhi" type="number" value="{{ $investmentDeclaration->SukS }}">
                                                            @else
                                                            <td><input name="sukanya_samriddhi" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Others (please specify) Employee Provident Fund</td>
                                                            <td></td>
                                                            <td>
                                                            @if($investmentDeclaration->EPF)
                                                                <input name="others_employee_provident_fund" type="number" value="{{ $investmentDeclaration->EPF }}">
                                                            @else
                                                            <td><input name="others_employee_provident_fund" type="number"></td>
                                                            @endif
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <p><b>Declaration:</b></p>
                                                <ol>
                                                    <li>I hereby declare that the information given above is correct and true in all respects.</li>
                                                    <li>I also undertake to indemnify the company for any loss/liability that may arise in the event of the above information being incorrect.</li>
                                                </ol>

                                                <div class="row">
                                                    <div class="col-md-12 mt-4 mb-3">
                                                        <div class="float-start">
                                                        <label for="date"><b>Date:</b></label>
                                                        <input type="date" id="date" name="date" value="2024-02-15"><br><br>

                                                        <label for="place"><b>Place:</b></label>
                                                        <input type="text" id="place" name="place" value="Raipur"><br><br>                                                        </div>
                                                        <div class="float-end mt-3">
                                                            <b>Signature</b>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Edit and Reset Buttons -->
                                                <div class="form-group text-center">
                                                    <button type="submit" class="btn btn-primary" id="submit-button-sub"
                                                        @if($employeeData->OpenYN != 'Y') disabled @endif>
                                                        Submit
                                                    </button>

                                                    <button type="reset" class="btn btn-secondary" 
                                                        @if($employeeData->OpenYN != 'Y') disabled @endif>
                                                        Reset
                                                    </button>
                                                </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="newregime" role="tabpanel">
                                    <ul class="user-details">
                                            <li>Employee ID: {{$employeeData->EmpCode}}</li>
                                            <li>Employee Name: {{ $employeeData->Fname ?? '' }} {{ $employeeData->Sname ?? '' }}
                                            {{ $employeeData->Lname ?? '' }}</li>
                                            <li>PAN Number: {{$employeeData->PanNo ??'N/A'}}</li>
                                            <li>Company Name:{{$employeeData->CompanyName ??'N/A'}}</li>
                                        </ul>
                                        <br>
                                        <p><b>Please remember the following points while filling up the form</b></p>
                                            <ol style="color: #686464;">
                                                <li>Do not forget to mention you Employee Id , Name & Pan card .</li>
                                                <li>Only Submission Amount needs to be filled. Do not change the figures mentioned in Max. limit Column.</li>
                                                <li> You are requested to submit the required proofs up to last date of submission, failing which will be assumed that the employee does not have any Tax </li>
                                                <li>Saving and income other than salary, and the Income Tax will be recomputed and tax will be deducted accordingly.</li>
                                            </ol>
                                            <p><b>(To be used to declare investment for income Tax that will be made during the period )</b></p><br>
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
                                            <ol><li>I hereby declare that the information given above is correct and true in all respects.</li>
                                            <li>I also undertake to indemnify the company for any loss/liability that may arise in the event of the above information being incorrect.</li>
                                            </ol>
                                        <div class="row">
                                            <div class="col-md-12 mt-4 mb-3">   
                                            <div class="float-start">
                                                <b>Date:</b>  15 Feb 2024<br> <br><b>Place:</b>  Raipur
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
                
            @include('employee.footerbottom')

            </div>
        </div>
    </div>
    
    @include('employee.footer');
    <script src="{{ asset('../js/dynamicjs/invst.js/') }}" defer></script>