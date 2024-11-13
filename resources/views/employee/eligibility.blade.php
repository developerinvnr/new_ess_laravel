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
                                    <li class="breadcrumb-link active">Eligibility</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
				<div class="row">
                   
                    <div class="col ">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width: 50px;" src="./images/icons/salary-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">Salary</h5>
                                    <a href="{{route('salary')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Card-->
                    <div class="col ">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/eligibility-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">Eligibility</h5>
                                    <a href="{{route('eligibility')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/ctc-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">CTC</h5>
                                    <a href="{{route('ctc')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

					<!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/annual-salary.png">
                                    <h5 class="ad-title mt-3 mb-3">Annual Salary</h5>
                                    <a href="#annualsalary" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/invetment.png">
                                    <h5 class="ad-title mt-3 mb-3">Invt. Declaration</h5>
                                    <a href="{{route('investment')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/invetment-submit.png">
                                    <h5 class="ad-title mt-3 mb-3">Invt. Submission</h5>
                                    <a href="investment-submission.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="card ad-info-card-">
                            <div class="card-header">
                                <h4 class="has-btn">Ledger</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center border-bottom-d" style="height: 142px;">
                                <table class="table">
                                    <tbody> 	
                                    <tr>
                                    <td >1.</td>
                                    <td ><b>Ledger 2023-24</b></td>
                                    <td><a><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>       
                                </tbody></table>
                            </div>
                        </div>
                    </div>
				</div>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Lodging Entitlements</h4>
                                <p>(Actual with upper limits per day)</p> 
                            </div>
							<div class="card-body align-items-center">
                                <div class="row">
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>City Category <span>A</span></h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 1300/-</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>City Category <span>B</span></h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 1500/-</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>City Category <span>C</span></h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 2400/-</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Daily Allowances</h4>
                                <p>(With Bills)</p> 
                            </div>
							<div class="card-body  align-items-center">
                                <div class="row">
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>DA@HQ</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 500/- Per Day</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>DA Outside HQ</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 1000/- Per Day</h5>
                                        </div>
                                    </div>
                                </div>
                                <p style="color: #686464;">Note: DA@HQ - (On minimum travel of 50 kms/day)</p>
                            </div>
                        </div>

                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Insurance</h4>
                                <p>(Sum Insured) </p> 
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <div class="row">
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>Health Insurance</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 2,00000/-</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>Group Term Life Insurance</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 10,0000/-</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>Min. Age>40yrs</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 4,500/- <span style="font-size: 12px;">once in 2 yrs</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Mobile Eligibility</h4>
                                <p>(Subject to submission of bills)</p> 
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <div class="row">
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>Handset</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 10,000/- <span style="font-size: 12px;">(Once in 2 yrs)</span></h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>Mobile Reimbursement</h4>
                                        <h5><i class="fas fa-rupee-sign"></i> <span style="font-size: 12px;">1,000/- Quarter - Prepaid</span></h5>
                                        <h5><i class="fas fa-rupee-sign"></i> <span style="font-size: 12px;">600/- Month - Postpaid</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card chart-card">
                            <div class="card-header eligibility-head-title">
                                <h4 class="has-btn">Gratuity / Deduction</h4>
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <ul class="gratuity-section">
                                    <li>Gratuity - <span style="float: right;">AS per Law</span></li>
                                    <li>Deduction - <span style="float: right;">AS per Law</span></li>
                                </ul>
                                <p style="color: #686464;">(Provident Fund/ ESIC/ Tax on Employment/ Income Tax/ Any dues to company(if any)/ Advances)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" >
						<div class="card chart-card">
                            <div class="card-header ctc-head-title">
                                <h4 class="has-btn">Travel Eligibility</h4>
                                <p>(For Official Purpose Only)</p> 
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <div class="row mb-2">
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>2 Wheeler <span><i style="color: #000;margin: 0px;" class="fas fa-biking"></i></span></h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 3.5/- KM</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>4 Wheeler <span><i style="color: #000;margin: 0px;" class="fas fa-car"></i></span></h4>
                                        <h5><i class="fas fa-rupee-sign"></i> 14/- KM</h5>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="eligibility-box" >
                                        <h4>Mode/Class outside HQ <span><i style="color: #000;margin: 0px;" class="fas fa-briefcase"></i></span></h4>
                                        <h5>Train/Bus- AC-II /Bus</h5>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <p style="color: #686464;">The changed entitlements will be effective from 1st March 2024.</p>
                                <p style="color: #686464;">The changed entitlements will be effective from 1st March 2024.</p>
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
                
				<div class="ad-footer-btm">
					<p><a href="">Terms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
				</div>
            </div>
        </div>
    </div>
    
    @include('employee.footer');