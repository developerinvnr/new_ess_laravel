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
                                    @if($eligibility->DA_Inside_Hq)
                                    <li>DA@HQ:
                                        <span><i class="fas fa-rupee-sign"></i>     {{ $eligibility->DA_Inside_Hq?? 'N/A' > 0 ? $eligibility->DA_Inside_Hq?? 'N/A' : '0.00' }}
                                        /- Per Day</span>
                                    </li>
                                    @endif
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
                                    @if($eligibility->HelthCheck == 'Y')
                                    <li>
                                        Executive Health Check-up:({{$eligibility->HelthCheck_Rmk}})
                                        <span><i class="fas fa-rupee-sign"></i> {{$eligibility->HelthCheck_Amt?? 'N/A'}}/-</span>
                                    </li>
                                    @endif
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
                                            <i class="fas fa-rupee-sign"></i>{{$eligibility->Travel_TwoWeeKM?? 'N/A' }}/Km (Approval based for official use)
                                        </span>
                                    </li>

                                    @if(!empty($eligibility) && $eligibility->Travel_FourWeeKM !== "NA" && $eligibility->Travel_FourWeeKM !== '')
                                        <li>
                                            <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-car"></i> 
                                            <strong>4 Wheeler:</strong> 
                                            <span style="color: #DC7937; float: right; padding-left: 10px;">
                                                <i class="fas fa-rupee-sign"></i>{{ $eligibility->Travel_FourWeeKM }}/Km
                                            </span>
                                        </li>
                                    @endif
                                   
                                    @if(!empty($policyDetails) && count($policyDetails) > 0)
                                        <ul>
                                            @foreach($policyDetails as $policy)
                                                <li>
                                                    <strong>{{ $policy['FiledName'] }}:</strong>
                                                    <span>{{ $policy['Value'] ?? 'N/A' }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                               
                                    @endif
                                    @if(!in_array($eligibility->CostOfVehicle, ['NA', '', null]))
                                        <li>
                                            <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-car"></i> 
                                            <strong>Vehicle Entitlement value:</strong> 
                                            <span style="color: #DC7937; float: right; padding-left: 10px;">
                                                <i class="fas fa-rupee-sign"></i>{{ $eligibility->CostOfVehicle }}
                                            </span>
                                        </li>
                                    @endif

                                    <li>
                                    <div class="trv-eligi-left">
                                        <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-briefcase"></i>
                                        <strong>Mode/Class outside HQ:</strong> 
                                        </div>
                                    @if($eligibility->Flight_Allow =="Y")

                                        <div class="trv-eligi-right">

                                        <span style="color: #DC7937; float: right; padding-left: 10px;">
                                        <b>Flight - </b>{{ $eligibility->Flight_Class . ' /' . ($eligibility->Flight_Rmk ?? 'N/A') }}
                                        <br>
                                        
                                        </span>
                                        </div>
                                    @endif
                                    @if($eligibility->Train_Allow =="Y")
                                    <div class="trv-eligi-right">

                                        <i style="color: #000;margin: 0px;color: #DC7937;" class="fas fa-briefcase"></i>
                                        <span style="color: #DC7937; float: right; padding-left: 10px;">
                                        <b>Train/Bus - </b>{{ $eligibility->Train_Class . ' ' . ($eligibility->Train_Rmk ?? 'N/A') }}
                                        </span>
                                        </div>

                                    @endif
                                    </li>

                                    

                                </ul>
                                <p style="color: #686464;">The changed entitlements will be effective from 1st March 2024.</p>
                            </div>
                        </div>

                        @if($eligibility->Mobile_Hand_Elig =='Y' || $eligibility->Mobile_Exp_Rem == 'Y' )
                        <div class="card chart-card">
                             @if($eligibility->Mobile_Hand_Elig =='Y')
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Mobile Eligibility</h4>
                                <p>(Subject to submission of bills)</p> 
                            </div>
                            @endif
                            <div class="card-body">
                                <ul class="eligibility-list">
                                     @if($eligibility->Mobile_Hand_Elig =='Y')
                                    <li>
                                    Mobile Handset Eligibility:
                                        <span><i class="fas fa-rupee-sign"></i>{{$eligibility->Mobile_Hand_Elig_Rs?? 'N/A'}} <span style="font-size: 12px;">{{$eligibility->Mobile_Hand_Elig_Rmk}}</span></span>
                                    </li>
                                    @endif
                                    @if($eligibility->Mobile_Exp_Rem == 'Y' && !empty($eligibility->Mobile_Exp_Rem_Rs) && $eligibility->Mobile_Exp_Rem_Rs != 'NA' && !empty($eligibility->Prd))
                                        <li>
                                            <strong>Mobile expenses Reimbursement :</strong>
                                            <span>
                                                <b>Prepaid:</b>
                                                Rs. {{ $eligibility->Mobile_Exp_Rem_Rs }}
                                                @if($eligibility->Prd == 'Mnt')
                                                    /Month.
                                                @elseif($eligibility->Prd == 'Qtr')
                                                    /Quarter.
                                                @elseif($eligibility->Prd == '1/2 Yearly')
                                                    /Half Yearly.
                                                @elseif($eligibility->Prd == 'Yearly')
                                                    /Year.
                                                @endif
                                                @if(!empty($eligibility->Mobile_Exp_Rem_Rmk))
                                                    {{ $eligibility->Mobile_Exp_Rem_Rmk }}
                                                @endif
                                                <br>
                                            </span>
                                        </li>
                                    @endif

                                    @if(!empty($eligibility->Mobile_Exp_RemPost_Rs) && $eligibility->Mobile_Exp_RemPost_Rs != 'NA' && !empty($eligibility->PrdPost))
                                        <li>
                                            <span>
                                                <b>Postpaid:</b>
                                                Rs. {{ $eligibility->Mobile_Exp_RemPost_Rs }}
                                                @if($eligibility->PrdPost == 'Mnt')
                                                    /Month.
                                                @elseif($eligibility->PrdPost == 'Qtr')
                                                    /Quarter.
                                                @elseif($eligibility->PrdPost == '1/2 Yearly')
                                                    /Half Yearly.
                                                @elseif($eligibility->PrdPost == 'Yearly')
                                                    /Year.
                                                @endif
                                                @if(!empty($eligibility->Mobile_Exp_RemPost_Rmk))
                                                    {{ $eligibility->Mobile_Exp_RemPost_Rmk }}
                                                @endif
                                            </span>
                                        </li>
                                    @endif

                                 
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <p><b>Notes</b></p>
                            <ol>
                                <li>The changed entitlements will be effective from 1st March 2024.</li>
                                <li>The expenses claim on 2 wheeler/4 wheeler is subject to company policy</li>
                                <li>The change in insurance coverage slab shall be effective from the next insurance policy renewal date.</li>
                                <li>Refer to the HR manual in ESS for further details.</li>
                            </ol>
                        </div>
                    </div>    
                </div>
                
                @include('employee.footerbottom')

            </div>
        </div>
    </div>
    
    @include('employee.footer');  
