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
                                    <li class="breadcrumb-link active">Team Salary</li>
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
                                    <a href="eligibility.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
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
                                    <a href="ctc.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
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
                                    <a href="investment-declaration.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
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
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12" >
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title">
                                <div class="col-md-9 mb-0 float-start">
                                    <h4 class="has-btn">Team Salary </h4>
                                    <p>(All team members salary only)</p> 
                                </div>
                                <div class="col-md-3 mb-0 float-end">
                                    <div class="form-group s-opt">
                                        <select class="select2 form-control select-opt" id="yearname" fdprocessedid="7n33b9">
                                            <option value="select">Select name </option>
                                            <option value="2023-24">Kishan</option>
                                            <option value="2022-23">rakesh</option>
                                            <option value="2021-22">Mahesh </option>
                                            <option value="2020-21">Murli</option>
                                        </select>
                                        <span class="sel_arrow">
                                            <i class="fa fa-angle-down "></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <ul class="team-cost-section">
                                    <li>
                                        <div class="team-name team-cost-btn"><i class="fas fa-angle-down"></i> Kishan Kumar</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">4,50000/-</b></div>
                                        <div style="display:none;" class="team-cost-wrapper">
                                            <table class="table table-bordered mb-2 mt-1 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Apr</th><th>May</th><th>Jun</th> <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Jan</th><th>Feb</th><th>Mar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i> Rakesh</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                        <div style="display:none;" class="team-cost-wrapper">
                                            <table class="table table-bordered mb-0 mt-1 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Apr</th><th>May</th><th>Jun</th> <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Jan</th><th>Feb</th><th>Mar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="with-team">
                                                <h6>Rakesh's Teams</h6>
                                                <ul>
                                                    <li>
                                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Divyakant</div>
                                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                                    </li>
                                                    <li>
                                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Divya</div>
                                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                                    </li>
                                                    <li>
                                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Kant</div>
                                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Mahesh</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Suresh</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i> Murli</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                        <div style="display:none;" class="team-cost-wrapper">
                                            <table class="table table-bordered mb-0 mt-1 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Apr</th><th>May</th><th>Jun</th> <th>Jul</th><th>Aug</th><th>Sep</th><th>Oct</th><th>Nov</th><th>Dec</th><th>Jan</th><th>Feb</th><th>Mar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td><td>15000/-</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="with-team">
                                                <h6>Murli's Teams</h6>
                                                <ul>
                                                    <li>
                                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Divyakant</div>
                                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                                    </li>
                                                    <li>
                                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Divya</div>
                                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                                    </li>
                                                    <li>
                                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Kant</div>
                                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="team-name team-cost-btn"> <i class="fas fa-angle-down"></i>Trisha</div>
                                        <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2">2,00000/-</b></div>
                                    </li>
                                    <li>
                                        <div class="team-name" style="font-weight: 600;font-size: 16px;">Total Cost</div>
                                        <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2">14,80,000/-</b></div>
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
    
    
	<script>
        $(document).ready(function() {
            $('.team-cost-btn').click(function() {
                $('.team-cost-wrapper').toggle();
            });
        });
    </script>
    @include('employee.footer');