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
                                    <li class="breadcrumb-link active">CTC</li>
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
                            <div class="card-header">
                                <h4 class="has-btn">Monthly Components</h4> 
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Basic</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">1600/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">HRA</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">6500/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Bonus1</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2400/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Special Allowance</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">7000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Gross Salary</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">30,000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Provident Fund</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Net Monthly Salary</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2">28,000/-</b></div>
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
                                            <p>(coverage for Employee, Spouse 2 children)</p></div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                    </li>
                                </ul>
                            </div>
						</div>
					</div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" >
						<div class="card chart-card">
                            <div class="card-header ctc-head-title">
                                <h4 class="has-btn">Annual Components </h4>
                                <p>(Tax saving components which shall be reimbursed on production of documents)</p> 
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Leave Travel Allowance</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">6500/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Children Education Allowance
                                            <p><input style="height: 15px;margin-top: 2px;margin-right:5px;float:left;" type="checkbox" /><span class="float-start me-2">Child 1</span>
                                                <input style="height: 15px;margin-top: 2px;margin-right:5px;float:left;" type="checkbox" /><span class="float-start">Child 2</span></p></div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Annual Gross Salary</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2">3,80,000/-</b></div>
                                    </li>
                                </ul>
                            </div>
						</div>
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title">
                                <h4 class="has-btn">Other Annual Components  </h4>
                                <p>(Statutory Components)</p> 
                            </div>
							<div class="card-body dd-flex align-items-center">
                                <ul class="ctc-section">
                                    <li>
                                        <div class="ctc-title">Estimated Gratuity</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">9500/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Employer's PF Contribution</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">25,000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Insurance Policy Premiums</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">15,000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Fixed CTC</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">4,00,000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title">Performance Pay</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">15,000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2">4,15,000/-</b></div>
                                    </li>
                                </ul>
                            </div>
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