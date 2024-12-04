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
        <div class="main-content">
            <!-- Page Title Start -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-title-wrapper">
                        <div class="breadcrumb-list">
                            <ul>
                                <li class="breadcrumb-link">
                                    <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                </li>
                                <li class="breadcrumb-link active">My Team - Eligibility & CTC</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Start -->
            @include('employee.menuteam')
            <div class="row">
                <div class="mfh-machine-profile">
                    <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
                        <li class="nav-item">
                            <a style="color: #0e0e0e;" class="nav-link active" id="reporting-tab1" data-bs-toggle="tab" href="#" role="tab" aria-controls="reporting" aria-selected="true">Reporting</a>
                        </li>
                        <li class="nav-item">
                            <a style="color: #0e0e0e;" class="nav-link" id="reviewer-tab2" data-bs-toggle="tab" href="#" role="tab" aria-controls="reviewer" aria-selected="false">HOD/Reviewer</a>
                        </li>
                        
                    </ul>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="card ad-info-card-">
                        <div class="card-header">
                            <div class="">
                            <h5><b>Eligibility/CTC</b></h5>
                            </div>
                        </div>
                        <div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
                            <table class="table text-center">
                                <thead >
                                    <tr>
                                        <th>Sno.</th>
                                        <th>Name</th>
                                        <th>EC</th>
                                        <th>Designation</th>
                                        <th>Grade</th>
                                        <th colspan="5">CTC</th>
                                        <th colspan="4">Eligibility</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Net</th>
                                        <th>Gross</th>
                                        <th>Deduction</th>
                                        <th>Total</th>
                                        <th><a class="links">More</a></th>
                                        <th>DA</th>
                                        <th>Mobile</th>
                                        <th>vehicle</th>
                                        <th><a class="links">More</a></th>
                                    
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><a data-bs-toggle="modal" data-bs-target="#ctcdetails"
                                            href="">Click</a></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><a data-bs-toggle="modal" data-bs-target="#eligibilitydetails"
                                            href="">Click</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    
                </div>

            @if(count($eligibility) > 0)

            <!-- Loop through employee eligibility data -->
            @foreach($eligibility as $index => $eligibilityData)
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 employee-card" data-employeeid="{{ $eligibilityData->EmployeeID }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                    <div class="card chart-card">
                        <div class="card-header eligibility-head-title d-flex align-items-center">
                            <h5 class="mr-3"><b>Employee Eligibility for: {{ $eligibilityData->Fname }} {{ $eligibilityData->Sname }} {{ $eligibilityData->Lname }} (ID: {{ $eligibilityData->EmployeeID }})</b></h5>
                            <!-- Dropdown for selecting employee (Aligned Right) -->
                            <select class="employeeSelect form-control ml-auto" style="max-width: 340px;">
                                <option value="">Select Employee</option>
                                @foreach($eligibility as $employee)
                                    <option value="{{ $employee->EmployeeID }}" data-index="{{ $loop->index }}" {{ $eligibilityData->EmployeeID == $employee->EmployeeID ? 'selected' : '' }}>
                                        {{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }} (ID: {{ $employee->EmployeeID }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="card-body align-items-center">
                            <!-- Lodging Entitlements Table -->
                            <h5>Lodging Entitlements (Actual with upper limits per day)</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>City Category A:</th>
                                        <td>{{$eligibilityData->Lodging_CategoryA ?? 'N/A'}}/-</td>
                                    </tr>
                                    <tr>
                                        <th>City Category B:</th>
                                        <td>{{$eligibilityData->Lodging_CategoryB ?? 'N/A'}}/-</td>
                                    </tr>
                                    <tr>
                                        <th>City Category C:</th>
                                        <td>{{$eligibilityData->Lodging_CategoryC ?? 'N/A'}}/-</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Daily Allowances Table -->
                            <h5>Daily Allowances</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>DA@HQ:</th>
                                        <td>{{ $eligibilityData->DA_Inside_Hq > 0 ? $eligibilityData->DA_Inside_Hq : '0.00' }}/- Per Day</td>
                                    </tr>
                                    <tr>
                                        <th>DA Outside HQ:</th>
                                        <td>{{$eligibilityData->DA_Outside_Hq ?? 'N/A'}}/- Per Day</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5>Insurance (Sum Insured)</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Health Insurance:</th>
                                        <td>{{$eligibilityData->Health_Insurance ?? 'N/A'}}/-</td>
                                    </tr>
                                    <tr>
                                        <th>Group Term Life Insurance:</th>
                                        <td>{{$eligibilityData->Term_Insurance ?? 'N/A'}}/-</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5>Mobile Eligibility (Subject to submission of bills)</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Handset:</th>
                                        <td>{{$eligibilityData->Mobile_Exp_Rem_Rs ?? 'N/A'}} <span style="font-size: 12px;">(Once in 2 yrs)</span></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5>Gratuity / Deduction</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Gratuity:</th>
                                        <td>AS per Law</td>
                                    </tr>
                                    <tr>
                                        <th>Deduction:</th>
                                        <td>AS per Law</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="color: #686464;">(Provident Fund/ ESIC/ Tax on Employment/ Income Tax/ Any dues to company (if any)/ Advances)</p>
                        </div>
                    </div>
                </div>
            @endforeach
            @else
                <div class="alert alert-warning text-center">
                    No Team Eligibility Data found
                </div>
            @endif
        </div>
    </div>
    </div>
    
    <div class="modal fade show" id="ctcdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Ravi Kumar CTC Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
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
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2">{{$ctc->TotCtc ?? 'N/A'}}</b></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade show" id="eligibilitydetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Ravi Kumar Eligibility Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                            <h4 class="has-btn">Lodging Entitlements</h4>
                            <p>(Actual with upper limits per day)</p> 
                        </div>
                        <div class="card-body align-items-center">
                            <ul class="eligibility-list">
                                <li>
                                    City Category A:
                                    <span class="value-align-right"><i class="fas fa-rupee-sign">454654564</i>/-</span>
                                </li>
                                <li>
                                    <strong>City Category B:</strong> 
                                    <span><i class="fas fa-rupee-sign"></i>5556/-</span>
                                </li>
                                <li>
                                    <strong>City Category C:</strong> 
                                    <span><i class="fas fa-rupee-sign"></i>5445/-</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                            <h4 class="has-btn">Daily Allowances</h4>
                            <p>gfhfghh</p> 
                        </div>
                        <div class="card-body align-items-center">
                            <ul class="eligibility-list">
                                <li>DA@HQ:
                                    <span><i class="fas fa-rupee-sign"></i>     657
                                    /- Per Day</span>
                                </li>
                                <li>DA Outside HQ:
                                    <span><i class="fas fa-rupee-sign"></i> 678/- Per Day</span>
                                </li>
                            </ul>
                            <p style="color: #686464;">Note: DA@HQ - (On minimum travel of 50 kms/day)</p>
                        </div>
                    </div>

                    <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                            <h4 class="has-btn">Insurance</h4>
                            <p>(Sum Insured)</p> 
                        </div>
                        <div class="card-body">
                            <ul class="eligibility-list">
                                <li>
                                    Health Insurance:
                                    <span><i class="fas fa-rupee-sign"></i> 567/-</span>
                                </li>
                                <li>
                                    Group Term Life Insurance:
                                    <span><i class="fas fa-rupee-sign"></i> 567/-</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    
                </div>

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card chart-card">
                        <div class="card-header ctc-head-title">
                            <h4 class="has-btn">Travel Eligibility</h4>
                            <p>(For Official Purpose Only)</p> 
                        </div>
                        <div class="card-body">
                            <ul class="eligibility-list" style="list-style-type: none; padding: 0;">
                                <li>
                                    <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-biking"></i> 
                                    <strong>2 Wheeler:</strong> 
                                    <span style="color: #DC7937; float: right; padding-left: 10px;">
                                        <i class="fas fa-rupee-sign"></i>65756756
                                    </span>
                                </li>
                                <li>
                                    <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-car"></i> 
                                    <strong>4 Wheeler:</strong> 
                                    <span style="color: #DC7937; float: right; padding-left: 10px;">
                                        <i class="fas fa-rupee-sign"></i>65767
                                    </span>
                                </li>
                                <li>
                                    <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-briefcase"></i>
                                    <strong>Mode/Class outside HQ:</strong> 
                                    <span style="color: #DC7937; float: right; padding-left: 10px;">
                                       rtyrt
                                    </span>
                                </li>
                            </ul>
                            <p style="color: #686464;">The changed entitlements will be effective from 1st March 2024.</p>
                        </div>
                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Mobile Eligibility</h4>
                                <p>(Subject to submission of bills)</p> 
                            </div>
                            <div class="card-body">
                                <ul class="eligibility-list">
                                    <li>
                                        Handset:
                                        <span><i class="fas fa-rupee-sign"></i>55<span style="font-size: 12px;">(Once in 2 yrs)</span></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
    
                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Gratuity / Deduction</h4>
                            </div>
                            <div class="card-body">
                                <ul class="gratuity-section">
                                    <li>Gratuity - <span style="float: right; color: #DC7937;">AS per Law</span></li>
                                    <li>Deduction - <span style="float: right; color: #DC7937;">AS per Law</span></li>
                                </ul>
                                <p style="color: #686464;">(Provident Fund/ ESIC/ Tax on Employment/ Income Tax/ Any dues to company(if any)/ Advances)</p>
                            </div>
                        </div>
                    </div>
                </div>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</body>

@include('employee.footer')
<script src="{{ asset('../js/dynamicjs/teameligibility.js/') }}" defer></script>

