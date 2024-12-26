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
                                    <li class="breadcrumb-link active">CTC</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')

                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Monthly Components</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Basic</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i>
                                            <b class="ml-2">
                                                @if($ctc->BAS ?? 'N/A' == 'Y'){{ $ctc->BAS_Value ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </b>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">HRA</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i>
                                            <b class="ml-2">
                                                @if($ctc->HRA ?? 'N/A' == 'Y'){{ $ctc->HRA_Value ?? 'N/A'}}
                                                @else
                                                    N/A
                                                @endif
                                            </b>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Bonus1</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->Bonus_Month ?? 'N/A'}}</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Special Allowance</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->SPECIAL_ALL_Value ?? 'N/A'}}</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Gross Monthly Salary</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->Tot_GrossMonth ?? 'N/A'}}</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Provident Fund</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->PF_Employee_Contri_Value ?? 'N/A'}}</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Net Monthly
                                            Salary</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->NetMonthSalary_Value ?? 'N/A'}}</b></div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Additional Benefit</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Insurance Policy Premium
                                            <p>(coverage for Employee, Spouse 2 children)</p>
                                        </div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->Mediclaim_Policy ?? 'N/A'}}/-</b></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title">
                                <h4 class="has-btn">Annual Components </h4>
                                <p>(Tax saving components which shall be reimbursed on production of documents)</p>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Leave Travel Allowance</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->LTA_Value ?? 'N/A'}}/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Children Education Allowance
                                            <p>
                                                <input
                                                    style="height: 15px; margin-top: 2px; margin-right: 5px; float: left;"
                                                    type="checkbox" @if(isset($ctc->CHILD_EDU_ALL_Value) && $ctc->CHILD_EDU_ALL_Value >= 1200) checked @endif />
                                                <span class="float-start me-2">Child 1</span>

                                                <input
                                                    style="height: 15px; margin-top: 2px; margin-right: 5px; float: left;"
                                                    type="checkbox" @if(isset($ctc->CHILD_EDU_ALL_Value) && $ctc->CHILD_EDU_ALL_Value == 2400) checked @endif />
                                                <span class="float-start">Child 2</span>
                                            </p>
                                        </div>

                                        <div class="ctc-value">
                                            <i class="fas fa-rupee-sign"></i>
                                            <b class="ml-2">
                                                @if(isset($ctc) && isset($ctc->CHILD_EDU_ALL_Value) && $ctc->CHILD_EDU_ALL_Value > 0)
                                                    {{ number_format($ctc->CHILD_EDU_ALL_Value, 2) }} /-
                                                @else
                                                    0.00 /-
                                                @endif
                                            </b>
                                        </div>


                                    </li>

                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Annual Gross
                                            Salary</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->Tot_Gross_Annual ?? 'N/A'}}/-</b></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title">
                                <h4 class="has-btn">Other Annual Components </h4>
                                <p>(Statutory Components)</p>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Estimated Gratuity</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->GRATUITY_Value ?? 'N/A'}}/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Employer's PF Contribution</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->PF_Employer_Contri_Annul ?? 'N/A'}}/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Insurance Policy Premiums</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->Mediclaim_Policy ?? 'N/A'}}/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Fixed CTC</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{$ctc->Tot_CTC ?? 'N/A'}}/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Performance Pay</div>
                                        <div class="ctc-value">
                                            <i class="fas fa-rupee-sign"></i>
                                            <b class="ml-2">
                                                @if(isset($ctc) && $ctc->VariablePay > 0)
                                                    {{ number_format($ctc->VariablePay, 2) }}
                                                @else
                                                    N/A /-
                                                @endif
                                            </b>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{$ctc->Tot_CTC ?? 'N/A'}}</b></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <p><b>Notes</b></p>
    <ol>
        <li>Bonus shall be paid as per The Code of Wages Act, 2019</li>
    <li>The Gratuity to be paid as per The Code on Social Security, 2020.</li>
    <li>Performance Pay</li>
    </ol>
    <b>Performance Pay</b>
    <ol>
        <li>Performance Pay is an annually paid variable component of CTC, paid in July salary.</li>
    <li>This amount is indicative of the target variable pay, actual pay-out will vary based on the performance of Company and Individual.</li>
    <li>It is linked with Company performance (as per fiscal year) and Individual Performance (as per appraisal period for minimum 6 months working, pro-rata basis if < 1 year working).</li>
    <li>The calculation shall be based on the pre-defined performance measures at both, Company & Individual level.</li>
    </ol>
    <p>For more details refer to the Company’s Performance Pay policy.
    <br><br>
    <b>Important</b>
    <br>This is a confidential page not to be discussed openly with others. You shall be personally responsible for any leakage of information regarding your compensation .<br><br></p>
                        </div>
                    </div>
                </div>

                @include('employee.footerbottom')

            </div>
        </div>
    </div>

    @include('employee.footer');