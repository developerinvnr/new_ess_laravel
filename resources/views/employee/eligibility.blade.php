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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                    <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Eligibility</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')
                <!-- Revenue Status Start -->
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
                                        <span class="value-align-right"><i class="fas fa-rupee-sign"></i>{{$eligibility->Lodging_CategoryA?? 'N/A'}}/-</span>
                                    </li>
                                    <li>
                                        <strong>City Category B:</strong> 
                                        <span><i class="fas fa-rupee-sign"></i>{{$eligibility->Lodging_CategoryB?? 'N/A'}}/-</span>
                                    </li>
                                    <li>
                                        <strong>City Category C:</strong> 
                                        <span><i class="fas fa-rupee-sign"></i>{{$eligibility->Lodging_CategoryC?? 'N/A'}}/-</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Daily Allowances</h4>
                                <p>{{$eligibility->DA_Inside_Hq?? 'N/A'}}</p> 
                            </div>
                            <div class="card-body align-items-center">
                                <ul class="eligibility-list">
                                    <li>DA@HQ:
                                        <span><i class="fas fa-rupee-sign"></i>     {{ $eligibility->DA_Inside_Hq?? 'N/A' > 0 ? $eligibility->DA_Inside_Hq?? 'N/A' : '0.00' }}
                                        /- Per Day</span>
                                    </li>
                                    <li>DA Outside HQ:
                                        <span><i class="fas fa-rupee-sign"></i> {{$eligibility->DA_Outside_Hq?? 'N/A'}}/- Per Day</span>
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
                                        <span><i class="fas fa-rupee-sign"></i> {{$eligibility->Health_Insurance?? 'N/A'}}/-</span>
                                    </li>
                                    <li>
                                        Group Term Life Insurance:
                                        <span><i class="fas fa-rupee-sign"></i> {{$eligibility->Term_Insurance?? 'N/A'}}/-</span>
                                    </li>
                                </ul>
                            </div>
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
                                        <span><i class="fas fa-rupee-sign"></i>{{$eligibility->Mobile_Exp_Rem_Rs?? 'N/A'}} <span style="font-size: 12px;">(Once in 2 yrs)</span></span>
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
                                            <i class="fas fa-rupee-sign"></i>{{$eligibility->Travel_TwoWeeKM?? 'N/A'}}
                                        </span>
                                    </li>
                                    <li>
                                        <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-car"></i> 
                                        <strong>4 Wheeler:</strong> 
                                        <span style="color: #DC7937; float: right; padding-left: 10px;">
                                            <i class="fas fa-rupee-sign"></i>{{$eligibility->Travel_FourWeeKM?? 'N/A'}}
                                        </span>
                                    </li>
                                    <li>
                                        <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-briefcase"></i>
                                        <strong>Mode/Class outside HQ:</strong> 
                                        <span style="color: #DC7937; float: right; padding-left: 10px;">
                                            {{$eligibility->Mode_Travel_Outside_Hq?? 'N/A'}}
                                        </span>
                                    </li>
                                </ul>
                                <p style="color: #686464;">The changed entitlements will be effective from 1st March 2024.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <p><b>Notes</b></p>
                            <ol>
                                <li>The changed entitlements will be effective from 1st March 2024.</li>
                                <li>The expenses claim on 2 wheeler/4 wheeler is subject to the employee having a valid driving license. The photocopy of which shall be provided to HR.</li>
                                <li>The change in insurance coverage slab shall be effective from the next insurance policy renewal date.</li>
                                <li>For those covered in vehicle policy may refer to the HR manual in ESS for further details.</li>
                            </ol>
                        </div>
                    </div>    
                </div>
                
                @include('employee.footerbottom')

            </div>
        </div>
    </div>
    
    @include('employee.footer');  
