@include('employee.header')
<body class="mini-sidebar">
@include('employee.sidebar')

    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
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
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
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
                                                @if($ctc->BAS ?? 'N/A' == 'Y'){{ formatToIndianRupees($ctc->BAS_Value, 0) ?? 'N/A' }}
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
                                                @if($ctc->HRA ?? 'N/A' == 'Y'){{ formatToIndianRupees($ctc->HRA_Value,0) ?? 'N/A'}}
                                                @else
                                                    N/A
                                                @endif
                                            </b>
                                        </div>
                                    </li>
                                    @if(!empty($ctc) && !empty($ctc->Bonus_Month) && $ctc->Bonus_Month != "0.00")
                                    <li>
                                        <div class="ctc-title">Bonus1</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{formatToIndianRupees($ctc->Bonus_Month,0) ?? 'N/A'}}</b></div>
                                    </li>
                                    @endif
                                    @if(!empty($ctc->SPECIAL_ALL_Value) && $ctc->SPECIAL_ALL_Value !="0.00")

                                    <li>
                                        <div class="ctc-title">Special Allowance</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{formatToIndianRupees($ctc->SPECIAL_ALL_Value,0)?? 'N/A'}}</b></div>
                                    </li>
                                    @endif
                                    @if(!empty($ctc->Tot_GrossMonth) && $ctc->Tot_GrossMonth !="0.00")

                                    <li>
                                        <div class="ctc-title">Gross Monthly Salary</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{formatToIndianRupees($ctc->Tot_GrossMonth,0) ?? 'N/A'}}</b></div>
                                    </li>
                                    @endif
                                    @if(!empty($ctc->PF_Employee_Contri_Value) && $ctc->PF_Employee_Contri_Value !="0.00")
                                    <li>
                                        <div class="ctc-title">Provident Fund</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{formatToIndianRupees($ctc->PF_Employee_Contri_Value,0)?? 'N/A'}}</b></div>
                                    </li>
                                    @endif
                                    @if(!empty($ctc->NetMonthSalary_Value) && $ctc->NetMonthSalary_Value !="0.00")

                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Net Monthly
                                            Salary</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                class="fas fa-rupee-sign"></i> <b
                                                class="ml-2">{{formatToIndianRupees($ctc->NetMonthSalary_Value,0) ?? 'N/A'}}</b></div>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                      

                    </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title">
                                    <h4 class="has-btn">Annual Components </h4>
                                    <p>(Tax saving components which shall be reimbursed on production of documents)</p>
                                </div>
                                <div class="card-body dd-flex align-items-center">
                                    <ul class="ctc-section">
                                    @if(!empty($ctc->LTA_Value) && $ctc->LTA_Value !="0.00")
                                    <li>
                                            <div class="ctc-title">Leave Travel Allowance</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b
                                                    class="ml-2">{{formatToIndianRupees($ctc->LTA_Value,0) ?? 'N/A'}}</b></div>
                                        </li>
                                        @endif
                                        <li>
                                            <div class="ctc-title">Children Education Allowance
                                            <p>
                                                <input
                                                    style="height: 15px; margin-top: 2px; margin-right: 5px; float: left;"
                                                    type="checkbox" disabled
                                                    @if(isset($ctc->CHILD_EDU_ALL_Value) && $ctc->CHILD_EDU_ALL_Value >= 1200) checked @endif
                                                    />
                                                <span class="float-start me-2">Child 1</span>

                                                <input
                                                    style="height: 15px; margin-top: 2px; margin-right: 5px; float: left;"
                                                    type="checkbox" disabled
                                                    @if(isset($ctc->CHILD_EDU_ALL_Value) && $ctc->CHILD_EDU_ALL_Value == 2400) checked @endif
                                                    />
                                                <span class="float-start">Child 2</span>
                                            </p>

                                            </div>

                                            <div class="ctc-value">
                                                <i class="fas fa-rupee-sign"></i>
                                                <b class="ml-2">
                                                    @if(isset($ctc) && isset($ctc->CHILD_EDU_ALL_Value) && $ctc->CHILD_EDU_ALL_Value > 0)
                                                        {{ formatToIndianRupees($ctc->CHILD_EDU_ALL_Value, 0) }} 
                                                    @else
                                                        0.00 
                                                    @endif
                                                </b>
                                            </div>


                                        </li>
                                    @if(!empty($ctc->Tot_Gross_Annual))
                                        <li>
                                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Annual Gross
                                                Salary</div>
                                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                    class="fas fa-rupee-sign"></i> <b
                                                    class="ml-2">{{formatToIndianRupees($ctc->Tot_Gross_Annual,0) ?? 'N/A'}}</b></div>
                                        </li>
                                        @endif
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
        @if(isset($ctc->GRATUITY_Value))
        <li>
            <div class="ctc-title">Estimated Gratuity</div>
            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{ formatToIndianRupees($ctc->GRATUITY_Value, 0) }}</b></div>
        </li>
        @endif

        @if(isset($ctc->PF_Employer_Contri_Annul))
        <li>
            <div class="ctc-title">Employer's PF Contribution</div>
            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{ formatToIndianRupees($ctc->PF_Employer_Contri_Annul, 0) }}</b></div>
        </li>
        @endif

        @if(isset($ctc->Mediclaim_Policy))
        <li>
            <div class="ctc-title">Mediclaim Policy Premiums</div>
            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{ formatToIndianRupees($ctc->Mediclaim_Policy, 0) }}</b></div>
        </li>
        @endif

        @if(isset($ctc->Tot_CTC))
        <li>
            <div class="ctc-title">Fixed CTC</div>
            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{ formatToIndianRupees($ctc->Tot_CTC, 0) }}</b></div>
        </li>
        @endif

        <li>
            <div class="ctc-title">Performance Pay</div>
            <div class="ctc-value">
                <i class="fas fa-rupee-sign"></i>
                <b class="ml-2">
                    @if(isset($ctc->VariablePay) && $ctc->VariablePay > 0)
                        {{ formatToIndianRupees($ctc->VariablePay, 0) }}
                    @else
                        N/A 
                    @endif
                </b>
            </div>
        </li>

<<<<<<< HEAD
                @if(isset($ctc->TotCtc))
                <li>
                    <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC</div>
                    <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                        <i class="fas fa-rupee-sign"></i> 
                        <b class="ml-2">{{ formatToIndianRupees($ctc->TotCtc, 0) }}</b>
                    </div>
                </li>
                @endif
               
            </ul>
=======
        @if(isset($ctc->TotCtc))
            <li>
                <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC</div>
                <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                    <i class="fas fa-rupee-sign"></i> 
                    <b class="ml-2">{{ formatToIndianRupees($ctc->TotCtc, 0) }}</b>
                </div>
            </li>
        @endif

        @if(isset($carAllowance) && $carAllowance > 0)
            <li>
                <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Car Allowance</div>
                <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                    <i class="fas fa-rupee-sign"></i> 
                    <b class="ml-2">{{ formatToIndianRupees($carAllowance, 0) }}</b>
                </div>
            </li>
        @endif

        @if(isset($Car_Entitlement) && $Car_Entitlement > 0)
            <li>
                <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Car Loan</div>
                <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                    <i class="fas fa-rupee-sign"></i> 
                    <b class="ml-2">{{ formatToIndianRupees($Car_Entitlement, 0) }}</b>
                </div>
            </li>
        @endif

        @if(($carAllowance > 0) || ($Car_Entitlement > 0)) 
            <li>
                <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total Gross Salary</div>
                <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                    <i class="fas fa-rupee-sign"></i> 
                    <b class="ml-2">{{ formatToIndianRupees($totGrossSalary, 0) }}</b>
                </div>
            </li>
        @endif


    </ul>
>>>>>>> 5b0a2123eab6d243003c8f1ba2a16751b432c0e9

                                </div>
                            </div>
                        </div>
                    </div>

                
                  @if((isset($carAllowance) && $carAllowance > 0) || (isset($Communication_Allowance) && $Communication_Allowance > 0))
                      <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header">
                            <h4 class="has-btn"> Perk's</h4>
                            
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                               
                                @if(isset($carAllowance) && $carAllowance > 0)
                                <li>
                                    <div class="ctc-title">Car Allowance</div>
                                    <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                                        <i class="fas fa-rupee-sign"></i> 
                                        <b class="ml-2">{{ formatToIndianRupees($carAllowance, 0) }}</b>
                                    </div>
                                </li>
                            @endif

                            @if(isset($Communication_Allowance) && $Communication_Allowance > 0)
                                <li>
                                    <div class="ctc-title">Communication Allowance</div>
                                    <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                                        <i class="fas fa-rupee-sign"></i> 
                                        <b class="ml-2">{{ formatToIndianRupees($Communication_Allowance, 0) }}</b>
                                    </div>
                                </li>
                            @endif

                            @if(($carAllowance > 0) || ($Communication_Allowance > 0)) 
                                <li>
                                    <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total Gross CTC</div>
                                    <div class="ctc-value" style="font-weight: 600;font-size: 17px;">
                                        <i class="fas fa-rupee-sign"></i> 
                                        <b class="ml-2">{{ formatToIndianRupees($totGrossSalary, 0) }}</b>
                                    </div>
                                </li>
                            @endif
                             
                                </ul>
                            </div>
                        </div>
                        </div>
                        </div>
                        @endif

                    @if(!empty($ctc->EmpAddBenifit_MediInsu) && $ctc->EmpAddBenifit_MediInsu_value !="0.00")
                        @if($ctc->EmpAddBenifit_MediInsu == 'Y')
                        <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn"> Benefits</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                               
                                    <li>
                                        <div class="ctc-title">Mediclaim Insurance Coverage
                                            <p>(coverage for Employee, Spouse, and 2 children)</p>
                                        </div>
                                        @if($ctc->EmpAddBenifit_MediInsu_value != null)
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{ formatToIndianRupees($ctc->EmpAddBenifit_MediInsu_value, 0) }}</b></div>
                                        @endif
                                
                                    </li>
                             
                                </ul>
                            </div>
                        </div>
                        </div>
                        </div>
                        @endif
                        @endif
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
                <!-- </div> -->

                @include('employee.footerbottom')

            </div>
        </div>
    </div>

    @include('employee.footer');
    <?php
function formatToIndianRupees($number) {
    // Remove decimals
    $number = round($number);

    // Convert the number to string
    $numberStr = (string)$number;

    // Handle case when the number is less than 1000 (no commas needed)
    if (strlen($numberStr) <= 3) {
        return $numberStr;
    }

    // Break the number into two parts: the last 3 digits and the rest
    $lastThreeDigits = substr($numberStr, -3);
    $remainingDigits = substr($numberStr, 0, strlen($numberStr) - 3);

    // Add commas every two digits in the remaining part
    $remainingDigits = strrev(implode(',', str_split(strrev($remainingDigits), 2)));

    // Combine the two parts and return
    return $remainingDigits . ',' . $lastThreeDigits;
}

// Example usage
$ctc_value = 388200; // Replace with actual value, e.g., $ctc->BAS_Value
echo formatToIndianRupees($ctc_value); // Output: 3,88,200
?>