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
        <header class="header-wrapper main-header">
            <div class="header-inner-wrapper">
                <div class="header-right">
                    <div class="serch-wrapper">
                        <form>
                            <input type="text" placeholder="Search Here...">
                        </form>
                        <a class="search-close" href="javascript:void(0);"><span class="icofont-close-line"></span></a>
                    </div>
                    <div class="header-left ">
                        <div class="header-links d-lg-none">
                            <a href="javascript:void(0);" class="toggle-btn">
                                <span></span>
                            </a>
                        </div>
                        <div class="header-links search-link">
                            <a class="search-toggle" href="javascript:void(0);">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;" xml:space="preserve">
                                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23
                                    s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92
                                    c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17
                                    s-17-7.626-17-17S14.61,6,23.984,6z"></path>
                                </svg>
                            </a>
                        </div>
						<div class="d-none d-md-block d-lg-block"><h4>VNR Seeds Private Limited India</h4></div>
                    </div>
                    <div class="header-controls">
                        <div class="setting-wrapper header-links d-none">
                            <a href="javascript:void(0);" class="setting-info">
                                <span class="header-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
									  <path d="M18.777,12.289 L17.557,12.493 C17.439,12.854 17.287,13.220 17.105,13.585 L17.825,14.599 C18.236,15.178 18.170,15.964 17.668,16.467 L16.454,17.683 C15.960,18.177 15.139,18.238 14.588,17.838 L13.583,17.119 C13.234,17.294 12.869,17.446 12.491,17.571 L12.284,18.795 C12.167,19.497 11.566,20.006 10.855,20.006 L9.137,20.006 C8.426,20.006 7.825,19.497 7.708,18.794 L7.504,17.571 C7.138,17.450 6.786,17.305 6.455,17.139 L5.431,17.869 C4.875,18.268 4.060,18.202 3.570,17.712 L2.356,16.496 C1.853,15.995 1.787,15.209 2.200,14.627 L2.915,13.630 C2.735,13.279 2.581,12.913 2.456,12.540 L1.218,12.329 C0.518,12.212 0.009,11.609 0.009,10.898 L0.009,9.180 C0.009,8.468 0.518,7.865 1.219,7.748 L2.422,7.545 C2.545,7.164 2.694,6.797 2.867,6.447 L2.139,5.421 C1.727,4.842 1.793,4.057 2.295,3.553 L3.513,2.337 C3.991,1.846 4.818,1.777 5.380,2.181 L6.376,2.901 C6.725,2.721 7.091,2.566 7.464,2.441 L7.675,1.200 C7.793,0.498 8.394,-0.011 9.104,-0.011 L10.818,-0.011 C11.528,-0.011 12.130,0.498 12.247,1.201 L12.451,2.407 C12.833,2.530 13.214,2.687 13.591,2.877 L14.602,2.155 C15.157,1.757 15.973,1.822 16.463,2.313 L17.676,3.528 C18.180,4.028 18.246,4.814 17.833,5.396 L17.112,6.405 C17.288,6.754 17.440,7.121 17.564,7.500 L18.786,7.707 C19.492,7.825 19.997,8.429 19.986,9.143 L19.986,10.856 C19.986,11.569 19.478,12.172 18.777,12.289 ZM16.815,8.984 C16.507,8.935 16.256,8.705 16.180,8.397 C16.030,7.816 15.800,7.262 15.498,6.755 C15.339,6.480 15.353,6.140 15.536,5.887 L16.472,4.568 L15.421,3.514 L14.111,4.458 C13.855,4.640 13.515,4.654 13.248,4.495 C12.722,4.184 12.157,3.952 11.566,3.803 C11.261,3.727 11.030,3.475 10.977,3.162 L10.711,1.574 L9.227,1.574 L8.953,3.187 C8.902,3.490 8.675,3.739 8.375,3.822 C7.801,3.971 7.251,4.203 6.735,4.513 C6.463,4.675 6.124,4.660 5.866,4.481 L4.555,3.543 L3.503,4.595 L4.451,5.930 C4.632,6.183 4.648,6.521 4.491,6.790 C4.193,7.297 3.967,7.852 3.819,8.439 C3.744,8.743 3.494,8.975 3.181,9.028 L1.596,9.295 L1.596,10.782 L3.205,11.057 C3.508,11.108 3.758,11.336 3.839,11.636 C3.987,12.210 4.219,12.762 4.530,13.280 C4.690,13.552 4.676,13.893 4.496,14.150 L3.561,15.465 L4.612,16.518 L5.943,15.569 C6.170,15.399 6.533,15.375 6.799,15.528 C7.309,15.822 7.851,16.044 8.408,16.189 C8.708,16.265 8.937,16.514 8.990,16.825 L9.257,18.425 L10.740,18.425 L11.010,16.825 C11.057,16.516 11.287,16.265 11.594,16.189 C12.176,16.037 12.729,15.807 13.234,15.505 C13.509,15.344 13.850,15.360 14.101,15.542 L15.418,16.482 L16.469,15.428 L15.530,14.102 C15.348,13.843 15.334,13.512 15.494,13.239 C15.797,12.728 16.027,12.174 16.176,11.591 C16.253,11.289 16.503,11.060 16.811,11.007 L18.408,10.740 L18.413,9.255 L16.815,8.984 ZM10.000,14.453 C7.547,14.453 5.550,12.454 5.550,9.996 C5.550,7.537 7.547,5.537 10.000,5.537 C12.454,5.537 14.449,7.537 14.449,9.996 C14.449,12.454 12.454,14.453 10.000,14.453 ZM10.000,7.127 C8.422,7.127 7.137,8.413 7.137,9.996 C7.137,11.577 8.422,12.864 10.000,12.864 C11.579,12.864 12.863,11.577 12.863,9.996 C12.863,8.413 11.579,7.127 10.000,7.127 Z" class="cls-1"></path>
									</svg>
                                </span>
                            </a>
                        </div>
                       

                        <div class="notification-wrapper header-links">
                            <a href="javascript:void(0);" class="notification-info">
                                <span class="header-icon">
                                    <svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m450.201 407.453c-1.505-.977-12.832-8.912-24.174-32.917-20.829-44.082-25.201-106.18-25.201-150.511 0-.193-.004-.384-.011-.576-.227-58.589-35.31-109.095-85.514-131.756v-34.657c0-31.45-25.544-57.036-56.942-57.036h-4.719c-31.398 0-56.942 25.586-56.942 57.036v34.655c-50.372 22.734-85.525 73.498-85.525 132.334 0 44.331-4.372 106.428-25.201 150.511-11.341 24.004-22.668 31.939-24.174 32.917-6.342 2.935-9.469 9.715-8.01 16.586 1.473 6.939 7.959 11.723 15.042 11.723h109.947c.614 42.141 35.008 76.238 77.223 76.238s76.609-34.097 77.223-76.238h109.947c7.082 0 13.569-4.784 15.042-11.723 1.457-6.871-1.669-13.652-8.011-16.586zm-223.502-350.417c0-14.881 12.086-26.987 26.942-26.987h4.719c14.856 0 26.942 12.106 26.942 26.987v24.917c-9.468-1.957-19.269-2.987-29.306-2.987-10.034 0-19.832 1.029-29.296 2.984v-24.914zm29.301 424.915c-25.673 0-46.614-20.617-47.223-46.188h94.445c-.608 25.57-21.549 46.188-47.222 46.188zm60.4-76.239c-.003 0-213.385 0-213.385 0 2.595-4.044 5.236-8.623 7.861-13.798 20.104-39.643 30.298-96.129 30.298-167.889 0-63.417 51.509-115.01 114.821-115.01s114.821 51.593 114.821 115.06c0 .185.003.369.01.553.057 71.472 10.25 127.755 30.298 167.286 2.625 5.176 5.267 9.754 7.861 13.798z"></path></svg>
                                </span>
                                <span class="count-notification"></span>
                            </a>
                            <div class="recent-notification">
                                <div class="drop-down-header">
                                    <h4>All Notification</h4>
                                    <p>You have 6 new notifications</p>
                                </div>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h5><i class="fas fa-exclamation-circle mr-2"></i>Storage Full</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h5><i class="far fa-envelope mr-2"></i>New Membership</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="drop-down-footer">
                                    <a href="javascript:void(0);" class="btn sm-btn">
                                        View All
                                    </a>
                                </div>
                            </div>
                        </div> 
                        <div class="user-info-wrapper header-links">
                            <a href="javascript:void(0);" class="user-info">
                                <img src="./images/user.jpg" alt="" class="user-img">
                                <div class="blink-animation">
                                    <span class="blink-circle t-present-b"></span>
                                    <span class="main-circle t-present"></span>
                                </div>
                            </a>
                            <div class="user-info-box">
                                <div class="drop-down-header">
                                    <h4>Rohit Kumar</h4>
                                    <p>Executive IT</p>
									<p>Emp. Code - 1254</p>
                                </div>
                                <ul>
                                    <li>
                                        <a href="profile-1.html">
                                            <i class="far fa-user"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fas fa-cog"></i> Change Passward
                                        </a>
                                    </li>
                                    <li>
                                        <a href="login.html">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
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
                                    <li class="breadcrumb-link active">Salary</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
				<div class="row">
                   
                    <!-- Start Card-->
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center text-center border-bottom-d">
                                <div class="icon-info-text-n">
                                    <img src="./images/icons/icon6.png">
                                    <h5 class="ad-title mt-3 mb-3">Eligibility</h5>
                                    <a href="team.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<!-- Start Card-->
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center text-center border-bottom-d">
                                <div class="icon-info-text-n">
                                    <img src="./images/icons/icon6.png">
                                    <h5 class="ad-title mt-3 mb-3">Annual Salary</h5>
                                    <a href="team.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Start Card-->
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center text-center border-bottom-d">
                                <div class="icon-info-text-n">
                                    <img src="./images/icons/icon6.png">
                                    <h5 class="ad-title mt-3 mb-3">Investment Declaration</h5>
                                    <a href="team.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Start Card-->
                    <div class="col-xl-2 col-lg-2 col-md-2">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center text-center border-bottom-d">
                                <div class="icon-info-text-n">
                                    <img src="./images/icons/icon6.png">
                                    <h5 class="ad-title mt-3 mb-3">Investment Submission</h5>
                                    <a href="team.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					
				</div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
						<div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Current CTC Sheet</h4> 
                            </div>
							<div class="card-body table-responsive">
								<table class="table">
									<tbody>
										<tr><td colspan="2" style="background-color:#f1f1f1;"><b>[A] Monthly Components</b></td></tr>
										<tr>
											<td>Basic:</td>
											<td>Rs. 15050.00</td>
										</tr>
										<tr>
											<td>HRA:</td>
											<td>Rs. 6020.00</td>
										</tr>
										<tr>
											<td>Bonus<sup>1</sup>:</td>
											<td>Rs. 2330.00</td>
										</tr>
										<tr>
											<td>Special Allowance:</td>
											<td>Rs. 35652.00</td>
										</tr>
										<tr>
											<td>Gross Monthly Salary:</td>
											<td>Rs. 6020.00</td>
										</tr>
										<tr>
											<td>Provident Fund:</td>
											<td>Rs. 1806.00</td>
										</tr>
										<tr>
											<td>Net Monthly Salary:</td>
											<td><b>Rs. 35846.00</b></td>
										</tr>
										<tr>
											<td style="background-color:#f1f1f1;" colspan="2"><b>[B] Annual Components (Tax saving components which shall be reimbursed on production of documents)</b></td>
										</tr>
										<tr>
											<td>Leave Travel Allowance:</td>
											<td>Rs. 0.00</td>
										</tr>

										<tr>
										  <td>Children Education Allow.:<br>
												<label class="float-start">Child1:</label><input class="float-start ml-2 mr-2" style="height:22px;" type="checkbox" name="CheckC1" disabled="">&nbsp;
                                                <label class="float-start">Child2:</label><input class="float-start ml-2 mr-2" style="height:22px;" type="checkbox" name="CheckC2" disabled=""></td>
										  </td>                                                  
										  <td>Rs. 0</td>
										</tr>
										<tr>
											<td>Annual Gross Salary:</td>
											<td><b>Rs. 405824.00</b></td>
										</tr>
										<tr>
											<td style="background-color:#f1f1f1;" colspan="2">&nbsp;<b>[C] Other Annual Components (Statutory components)</b></td>
										</tr>
										<tr>
											<td>Estimated Gratuity:</td>
											<td>Rs. 8683.00</td>
										</tr>
										<tr>
											<td>Employer's PF Contribustion:</td>
											<td>Rs. 21672.00</td>
										</tr>
										<tr>
											<td>Insurance Policy Premiums:</td>
											<td>Rs. 15000.00</td>
										</tr>
										<tr>
											<td>Fixed CTC:</td>
											<td>Rs. 601179.00</td>
										</tr>
										<tr>
											<td>Performance Pay:</td>
											<td>Rs. 17791.00</td>
										</tr>
										<tr>
											<td>Total CTC:</td>
											<td><b>Rs. 618970.00</b></td>
										</tr>

										<tr>
											<td style="background-color:#f1f1f1;" colspan="2"><b>Additional Benefit</b></td>
										</tr>
										<tr>
										  <td>Insurance Policy Premium (coverage for Employee, Spouse 2 children):</td>
										  <td>Rs. 200000</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" >
						<div class="card chart-card">
                            <div class="card-header">
								<div class="float-start form-group s-opt col-md-7 mb-0">
									<h4 class="has-btn float-start">PaySlip 2023</h4><br>
									<p class="card-desc">This is a confidential page not to be discussed openly with others.</p>
								</div>
								<div class="col-md-4 mb-0 float-end">
									<div class=" form-group s-opt float-start mb-0" style="width:150px;">
										<select class="select2 form-control select-opt">
											<option>Jan</option>
											<option>Feb</option>
											<option>Mar</option>
											<option>Apr</option>
										</select>
										<span class="sel_arrow">
											<i class="fa fa-angle-down "></i>
										</span>
									</div>
									<a class="p-2 ml-2 mt-2 float-start" href=""><i style="font-size:16px;" class="fa fa-print"></i></a>
								</div>
                            </div>
							<div class="card-body table-responsive" >
								<div class="payslip-top-section">
									<div class="float-start">
										<img class="payslip-logo" alt="" src="./images/login-logo.png" />
									</div>
									<div class="">
										<h4>VNR SEEDS PVT. LTD.</h4>
										<P>Corporate Centre Canal Road Crossing, <br>Ring Road No.1, Raipur 492006 Chhattisgarh</P>
										<p><span style="margin-right:20px;"><i class="fa fa-phone-alt mr-2"></i> 0771-4350005-10</span> <span><i class="fa fa-envelope mr-2"></i> info@vnrseeds.com</span></p>
									</div>
								</div>
								<table class="table border payslip-table table-striped">
  <tbody><tr>
   <td><b>Employee Code:</b></td>
   <td>1222</td>
   <td><b>Name:</b></td>
   <td>Mr. Narayan Kumar Yadav</td>
  </tr>
   <tr>
   <td>Costcenter:</td>
   <td>Chhattisgarh</td>
   <td>Function</td>
   <td>Support Services</td>
  </tr>
  <tr>
   <td>Grade:</td>
   <td>J1</td>
   <td>Designation</td>
   <td>EXECUTIVE IT</td>
  </tr>
  <tr>
   <td>Headquarter:</td>
   <td>Raipur</td>
   <td>Gender:</td>
   <td>Male</td>
  </tr>
  <tr>
   <td>Date of Birth:</td>
   <td>21-11-1987</td>
   <td>Date of Joining:</td>
   <td>01-03-2022</td>
   
  </tr>
  <tr>
   <td>Bank A/C No.:</td>
   <td>10087827560</td>
   <td>Bank Name:</td>
   <td>State Bank of India</td>
  </tr>
  <tr>
	<td>PF No.:</td>
   <td>CG0018650</td>
   <td>PAN NO.:</td>
   <td>AISPY6207D</td>
  </tr>
  <tr>
   <td>Total Days:</td>
   <td>26</td>
   </tr>
  <tr>
   <td>Paid Days</td>
   <td>26.0</td>
   <td>Absent</td>
   <td>0.0</td>
  </tr>
  </tbody>
  </table>
  
				<table class="table border">
					 <tbody>
					 <tr style="background-color:#c5d3c1;">
					  <td colspan="2"><b>Earnings</b></td>
					  <td colspan="2"><b>Deductions</b></td>
					 </tr>
					 <tr style="background-color:#f1f1f1;">
					  <td><b>Components</b></td>
					  <td><b>Amount</b></td>
					  <td><b>Components</b></td>
					  <td><b>Amount</b></td>
					 </tr>
					<tr>
					  <td>BASIC:</td>
					  <td>15050.00</td>
					  <td>PROVIDENT FUND</td>
					  <td>1806</td>
					 </tr>
					<tr>
					  <td>HOUSE RENT ALLOWANCE:</td>
					  <td>6020.00</td>
					  <td colspan="2"></td>
					 </tr>
						 <tr>
					  <td>BONUS:</td>
					  <td>2330.00</td>
					  <td colspan="2"></td>
					 </tr>
						 <tr>
					  <td>SPECIAL ALLOWANCE:</td>
					  <td>6252.00</td>
					  <td colspan="2"></td>
					 </tr>
					 <tr  style="background-color:#c5d3c1;">
					  <td><b>Total Earnings:</b></td>
					  <td><b>40652.00</b></td>
					  <td><b>Total Deductions:</b></td>
					  <td><b>2806.00</b></td>
					 </tr>
					 <tr>
						<td colspan="4"><b style="color:#B70000;">Net Pay :</b><b>&nbsp;Rs. 47846/-</b></td>
					 </tr>
					 <tr>
						<td colspan="4">
							<b style="color:#B70000;">In Words :</b><b>&nbsp; FOR SEVEN THOUSAND EIGHT HUNDRED &amp; FOURTY SIX    RUPEES ONLY</b>
						</td>
					 </tr>
					 
					</tbody>
				</table>
				
				
						</div>
						</div>
					</div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Annual Salary</h4> 
                            </div>
							<div class="card-body table-responsive">
						<table>
<tbody><tr bgcolor="#7a6189">
<td class="All_200H"><b>Payment Head</b></td><td class="All_80H"><b>APR</b></td><td class="All_80H"><b>MAY</b></td><td class="All_80H"><b>JUN</b></td><td class="All_80H"><b>JUL</b></td><td class="All_80H"><b>AUG</b></td><td class="All_80H"><b>SEP</b></td><td class="All_80H"><b>OCT</b></td><td class="All_80H"><b>NOV</b></td><td class="All_80H"><b>DEC</b></td><td class="All_80H"><b>JAN</b></td><td class="All_80H"><b>FEB</b></td><td class="All_80H"><b>MAR</b></td><td class="All_80H"><b>Total</b></td>
</tr>
 

<tr bgcolor="#FFFFFF">
<td class="All_200">&nbsp;Basic</td>
<td class="All_80">15050</td><td class="All_80">15050</td><td class="All_80">-</td><td class="All_80">-</td><td class="All_80">-</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>30100</b>&nbsp;</td>
</tr>


<tr bgcolor="#FFFFFF">
<td class="All_200">&nbsp;House Rent Allowance</td>
<td class="All_80">6020&nbsp;</td><td class="All_80">6020&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td>	
<td class="All_80" bgcolor="#55AAFF"><b>12040</b>&nbsp;</td>
</tr>

<tr bgcolor="#FFFFFF">
<td class="All_200">&nbsp;Special Allowance</td>
<td class="All_80">8252&nbsp;</td><td class="All_80">8252&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>12504</b>&nbsp;</td>
</tr>

<tr bgcolor="#FFFFFF">
<td class="All_200">&nbsp;Bonus</td>
<td class="All_80">3330&nbsp;</td><td class="All_80">3330&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>4660</b>&nbsp;</td>
</tr>

<tr bgcolor="#D5FFD5" style="font-weight:bold;">
<td class="All_200">&nbsp;Gross Earning</td>
<td class="All_80">49652&nbsp;</td><td class="All_80">49652&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>79304</b>&nbsp;</td>
</tr>
<tr bgcolor="#FFFFFF">
<td class="All_200">&nbsp;Provident Fund</td>
<td class="All_80">1806&nbsp;</td><td class="All_80">1806&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>4612</b>&nbsp;</td>
</tr>
<tr bgcolor="#FFD2D2" style="font-weight:bold;">
<td class="All_200">&nbsp;Gross Deduction</td>
<td class="All_80">2806&nbsp;</td><td class="All_80">2806&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>4612</b>&nbsp;</td>
</tr>


<tr bgcolor="#BFFF80" style="font-weight:bold;">
<td class="All_200">&nbsp;Net Amount</td>
<td class="All_80">47846&nbsp;</td><td class="All_80">47846&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>75692</b>&nbsp;</td>
</tr>
   </tbody></table>
   </div>
   </div>
					</div>
                </div>
                
				<div class="ad-footer-btm">
					<p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
				</div>
            </div>
        </div>
    </div>
    
    <!--General message-->
    <div class="modal fade show" id="model4" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">General Message</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
          <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        
        </div>
      </div>
      </div>
    </div>


    <!-- Preview Setting Box -->
	<div class="slide-setting-box">
        <div class="slide-setting-holder">
            <div class="setting-box-head">
                <h4>Dashboard Demo</h4>
                <a href="javascript:void(0);" class="close-btn">Close</a>
            </div>
            <div class="setting-box-body">
				<div class="sd-light-vs"> 
					<a href="">
						Light Version
						<img src="./SplashDash_files/light.png" alt="">
					</a>
				</div>
				<div class="sd-light-vs"> 
                        <a href="">
						dark Version
						<img src="./SplashDash_files/dark.png" alt="">
					</a>
				</div>
            </div>
			<div class="sd-color-op">
				<h5>color option</h5> 
				<div id="style-switcher">
					<div>
						<ul class="colors">
							<li>
								<p class="colorchange" id="color">
								</p>
							</li>
							<li>
								<p class="colorchange" id="color2">
								</p>
							</li>
							<li>
								<p class="colorchange" id="color3">
								</p>
							</li>
							<li>
								<p class="colorchange" id="color4">
								</p>
							</li>
							<li>
								<p class="colorchange" id="color5">
								</p>
							</li>
							<li>
								<p class="colorchange" id="style">
								</p>
							</li>
						</ul>
					</div>
				</div>
			</div>
        </div>
    </div>
    <!-- Preview Setting -->
	
    @include('employee.footer');
