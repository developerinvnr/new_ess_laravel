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
                                    <li class="breadcrumb-link active">Salary</li>
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
                                    <a href="salary.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
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
                                    <a href="salary.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
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
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12" >
						<div class="card chart-card">
                            <div class="card-header">
								<div class="float-start form-group s-opt col-md-9 mb-0">
									<h4 class="has-btn float-start">PaySlip 2023</h4><br>
									<p class="card-desc">This is a confidential page not to be discussed openly with others.</p>
								</div>
								<div class="col-md-1 mb-0 float-end">
									<a class="p-2 ml-2 float-start" href=""><i style="font-size:16px;" class="fa fa-print"></i></a>
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
   <td>UAN NO.:</td>
   <td>10002455245</td>
  </tr>
  <tr>
    <td>PAN NO.:</td>
   <td>AISP478PP</td>
    <td>ESIC NO.:</td>
   <td>785496532158</td>
   
   </tr>
  <tr>
    <td>Total Days:</td>
    <td>26</td>
    <td>Paid Days</td>
   <td>26.0</td>
  </tr>
  <tr>
    <td>Payment Mode</td>
    <td>Bank</td>
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
							<b style="color:#B70000;">In Words :</b><b>&nbsp; FOURTY SEVEN THOUSAND EIGHT HUNDRED FOURTY SIX RUPEES ONLY</b>
						</td>
					 </tr>
					 
					</tbody>
				</table>
				
				
						</div>
						</div>
					</div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="card ad-info-card-">
                            <div class="card-header">
                                <h4 class="has-btn">Download Payslip 2024</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center">
                                <table class="table">
                                    <tbody> 	
                                    <tr>
                                    
                                    <tr>
                                        <td >1.</td>
                                        <td >April</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td >2.</td>
                                        <td >May</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td >3.</td>
                                        <td >June</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td >4.</td>
                                        <td >July</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr> 
                                    <tr>
                                        <td >5.</td>
                                        <td >August</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>
                                    <tr>
                                        <td >6.</td>
                                        <td >September</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>  
                                    <tr>
                                        <td >7.</td>
                                        <td >October</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr> 
                                    <tr>
                                        <td >8.</td>
                                        <td >November</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr> 
                                    <tr>
                                        <td >9.</td>
                                        <td >December</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr> 
                                    <td >10.</td>
                                    <td >January</td>
                                    <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>
                                    <tr>
                                    <td >11.</td>
                                    <td >February</td>
                                    <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>  
                                    <tr>
                                        <td >12.</td>
                                        <td >March</td>
                                        <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr> 
                                </tbody></table>
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
						<table class="table table-striped">
<thead>
                            <tr>
<td><b>Payment Head</b></td><td ><b>APR</b></td><td><b>MAY</b></td><td><b>JUN</b></td><td><b>JUL</b></td><td><b>AUG</b></td><td><b>SEP</b></td><td class="All_80H"><b>OCT</b></td><td class="All_80H"><b>NOV</b></td><td class="All_80H"><b>DEC</b></td><td class="All_80H"><b>JAN</b></td><td class="All_80H"><b>FEB</b></td><td class="All_80H"><b>MAR</b></td><td class="All_80H"><b>Total</b></td>
</tr>
 </thead>
<tbody>
<tr>
<td>Basic</td>
<td class="All_80">15050</td><td class="All_80">15050</td><td class="All_80">-</td><td class="All_80">-</td><td class="All_80">-</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>30100</b>&nbsp;</td>
</tr>


<tr>
<td>House Rent Allowance</td>
<td>6020</td><td class="All_80">6020&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td>	
<td><b>12040</b>&nbsp;</td>
</tr>

<tr>
<td class="All_200">&nbsp;Special Allowance</td>
<td class="All_80">8252&nbsp;</td><td class="All_80">8252&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>12504</b>&nbsp;</td>
</tr>

<tr>
<td class="All_200">&nbsp;Bonus</td>
<td class="All_80">3330&nbsp;</td><td class="All_80">3330&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>4660</b>&nbsp;</td>
</tr>

<tr>
<td class="All_200">&nbsp;Gross Earning</td>
<td class="All_80">49652&nbsp;</td><td class="All_80">49652&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>79304</b>&nbsp;</td>
</tr>
<tr>
<td class="All_200">&nbsp;Provident Fund</td>
<td class="All_80">1806&nbsp;</td><td class="All_80">1806&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>4612</b>&nbsp;</td>
</tr>
<tr>
<td class="All_200">&nbsp;Gross Deduction</td>
<td class="All_80">2806&nbsp;</td><td class="All_80">2806&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80">0&nbsp;</td><td class="All_80" bgcolor="#55AAFF"><b>4612</b>&nbsp;</td>
</tr>


<tr style="font-weight:bold;">
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
	
    @include('employee.footer');