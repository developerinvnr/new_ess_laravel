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
                       @include('employee.navbar');
                    </div>
                </div>
            </div>
        </header>
        
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
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Assets</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
						<div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Official Assets</h4> 
                            </div>
							<div class="card-body table-responsive">
								<table class="table">
									<thead class="thead-light" style="background-color:#f1f1f1;">
										<tr>
											<th>Sno.</th>
											<th>Type Of Asset</th>
											<th>Assest ID</th>
											<th>Company</th>
											<th>Model Name</th>
											<th>Serial No</th>
											<th>Details</th>
											<th>Allocated</th>
											<th>Returned</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1.</td>
											<td>Laptop</td>
											<td>DAS0125487</td>
											<td>VSPL</td>
											<td>MOD- 14587SDER</td>
											<td>21300000098877</td>
											<td>test 15-02-2021</td>
											<td>-</td>
											<td>-</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Request Status</h4> 
                            </div>
							<div class="card-body table-responsive">
								<table class="table">
									<thead class="thead-light" style="background-color:#f1f1f1;">
										<tr>
											<th>Sno.</th>
											<th>Request Date</th>
											<th>Type Of Asset</th>
											<th>Balance Amount</th>
											<th>Request Amount</th>
											<th>Approval Amount</th>
											<th>Copy Of Bill</th>
											<th>Copy Asset</th>
											<th>Details</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>1.</td>
											<td>04 Apr 2020</td>
											<td>Laptop</td>
											<td>15,000/-</td>
											<td>35,000/-</td>
											<td>35,000/-</td>
											<td><a href="#" data-bs-toggle="modal" data-bs-target="#billdetails" fdprocessedid="465yuu"><i class="fas fa-eye me-2"></i>Bill</a></td>
											<td><a href="#" data-bs-toggle="modal" data-bs-target="#billdetails" fdprocessedid="465yuu"><i class="fas fa-eye me-2"></i>Asset</a></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</td>
											<td><button type="button" style="padding:6px 13px;font-size: 11px;" class="btn-outline success-outline sm-btn" data-bs-toggle="modal" data-bs-target="#assetdetails" fdprocessedid="465yuu">View</button></td>
										</tr>
										<tr>
											<td>2.</td>
											<td>04 Apr 2024</td>
											<td>Laptop</td>
											<td>20,000/-</td>
											<td>40,000/-</td>
											<td>40,000/-</td>
											<td><a href="#" data-bs-toggle="modal" data-bs-target="#billdetails" fdprocessedid="465yuu"><i class="fas fa-eye me-2"></i>Bill</a></td>
											<td><a href="#" data-bs-toggle="modal" data-bs-target="#billdetails" fdprocessedid="465yuu"><i class="fas fa-eye me-2"></i>Asset</a></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</td>
											<td><button type="button" style="padding:6px 13px;font-size: 11px;" class="btn-outline success-outline sm-btn" data-bs-toggle="modal" data-bs-target="#assetdetails" fdprocessedid="465yuu">View</button></td>
										</tr>
										<tr>
											<td>3.</td>
											<td>04 Apr 2024</td>
											<td>Laptop</td>
											<td>20,000/-</td>
											<td>40,000/-</td>
											<td>40,000/-</td>
											<td><a href="#" data-bs-toggle="modal" data-bs-target="#billdetails" fdprocessedid="465yuu"><i class="fas fa-eye me-2"></i>Bill</a></td>
											<td><a href="#" data-bs-toggle="modal" data-bs-target="#billdetails" fdprocessedid="465yuu"><i class="fas fa-eye me-2"></i>Asset</a></td>
											<td>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</td>
											<td><button type="button" style="padding:6px 13px;font-size: 11px;" class="btn-outline success-outline sm-btn" data-bs-toggle="modal" data-bs-target="#assetdetails" fdprocessedid="465yuu">View</button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title">My Asset Request</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="splash-Accordion4">
										<div class="accordion" id="accordionExample">
										  
										  <div class="item">
											 <div class="item-header" id="headingTwok">
												<h2 class="mb-0 ">
												   <button class="btn btn-link collapsed w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwok" aria-expanded="false" aria-controls="collapseTwok">
												   My Asset Request Form
												   <i class="fa fa-angle-down float-end"></i>
												   </button>
												</h2>
											 </div>
											 <div id="collapseTwok" class="collapse" aria-labelledby="headingTwok" data-bs-parent="#accordionExample">
												<form class="">
													<div class="row">
														<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<p>CC to your reporting manager & HOD</p>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group s-opt">
																<label for="asset" class="col-form-label"><b>Select Asset Name</b></label>
																<select class="select2 form-control select-opt" id="asset" fdprocessedid="7n33b9">
																	  <option value="Laptop">Laptop</option>
																	  <option value="Phone">Phone</option>
																	  <option value="desk">Desktop</option>
																	  <option value="test1">Hard Disk</option>
																	  <option value="tesx2">test2</option>
																	  <option value="test3">test3</option>
																</select>
																<span class="sel_arrow">
																	<i class="fa fa-angle-down "></i>
																</span>
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="maximaum_limit" class="col-form-label"><b>Maximum Limit</b></label>
																<input class="form-control" type="text" placeholder="Enter maximum limit" id="maximaum_limit" fdprocessedid="ffinzs">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="model_name" class="col-form-label"><b>Model Name</b></label>
																<input class="form-control" type="text" placeholder="Enter model name" id="model_name" fdprocessedid="zpsebq">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="model_no" class="col-form-label"><b>Model Number</b></label>
																<input class="form-control" type="text" placeholder="Enter modal number" id="model_no" fdprocessedid="mro7tc">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="company_name" class="col-form-label"><b>Company Name</b></label>
																<input class="form-control" type="text" placeholder="Enter company name" id="company_name" fdprocessedid="glqpk">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="purchase_date" class="col-form-label"><b>Purchase Date</b></label>
																<input class="form-control" type="text" placeholder="Purchase Date" id="purchase_date" fdprocessedid="glqpk">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="dealer_name" class="col-form-label"><b>Dealer Name</b></label>
																<input class="form-control" type="text" placeholder="Enter dealer name" id="dealer_name" fdprocessedid="mro7tc">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="dealer_contact" class="col-form-label"><b>Dealer Contact</b></label>
																<input class="form-control" type="text" placeholder="Enter dealer contact number" id="dealer_contact" fdprocessedid="glqpk">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="price" class="col-form-label"><b>Price</b></label>
																<input class="form-control" type="text" placeholder="Enter price" id="price" fdprocessedid="mro7tc">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="bill_number" class="col-form-label"><b>Bill Number</b></label>
																<input class="form-control" type="text" placeholder="Enter bill number" id="bill_number" fdprocessedid="glqpk">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="request_amount" class="col-form-label"><b>Request Amount</b></label>
																<input class="form-control" type="text" placeholder="Enter request amount" id="request_amount" fdprocessedid="mro7tc">
															</div>
														</div>
														<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="iemi_no" class="col-form-label"><b>IEMI No.:</b></label>
																<input class="form-control" type="text" placeholder="Enter IEMI number" id="iemi_no" fdprocessedid="glqpk">
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="bill_copy" class="col-form-label"><b>Bill Copy</b></label>
																<input class="form-control" id="bill_copy" type="file" />
															</div>
														</div>
														<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="asset_copy" class="col-form-label"><b>Asset Copy</b></label>
																<input class="form-control" id="asset_copy" type="file" />
															</div>
														</div>
														<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
															<div class="form-group">
																<label for="remarks" class="col-form-label"><b>Remarks</b></label>
																<textarea class="form-control" placeholder="Additional Remarks" id="remarks"></textarea>
															</div>
														</div>
														<div class="form-group mb-0">
															<button class="btn btn-primary" type="button" fdprocessedid="yed9j">Reset</button>
															<input class="btn btn-success" type="submit" fdprocessedid="l9oz0g">
														</div>
													</div>
												</form>
											 </div>
										  </div>
										
										</div>
									</div>
                                </div>
                            </div>
                        </div>
					
                            <div class="card chart-card">
                                <div class="card-header">
                                    <h4 class="has-btn">Approval Status</h4>
                                </div>
                                <div class="card-body">
                                    <div class="exp-details-box">
                                        <span style="background-color: #dba62f;margin-top:0px;" class="exp-round">&nbsp;</span>
                                        <div class="exp-line">
                                            <h6 class="mb-2" style="color:#9f9f9f;">Successfully</h6>
                                            <h5>Approved</h5>
                                            <p>05 June 2024</p>
                                            <p>Congratulations</p>
                                        </div>
                                    </div>
									<div class="exp-details-box">
                                        <span style="background-color: #dba62f;margin-top:15px;" class="exp-round">&nbsp;</span>
                                        <div class="exp-line">
                                            <h6 class="mb-2 pt-3" style="color:#9f9f9f;">Level 3</h6>
                                            <h5>Account Section</h5>
                                            <p>04 June 2024</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                                        </div>
                                    </div>
                                    <div class="exp-details-box">
                                        <span class="exp-round">&nbsp;
										<div class="blink-animation" style="right:-3px;bottom:10px;">
											<div class="blink-circle t-present-b"></div>
											<div class="main-circle t-present"></div>
										</div>
										</span>
                                        <div class="exp-line">
                                            <h6 class="mb-2 pt-3" style="color:#9f9f9f;">Level 2</h6>
                                            <h5>IT Section</h5>
                                            <p>28 May 2024</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                                        </div>
                                    </div>
                                    <div class="exp-details-box">
                                        <span class="exp-round">&nbsp;</span>
                                        <div class="exp-line">
                                            <h6 class="mb-2 pt-3" style="color:#9f9f9f;">Level 1</h6>
                                            <h5>HOD/ Reporting</h5>
                                            <p>05 May 2024</p>
											<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    
                </div>
                
				<div class="ad-footer-btm">
					<p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Private Limited India</p>
				</div>
            </div>
        </div>
    </div>
   <!--General message-->
    <div class="modal fade show" id="assetdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle3">Details of Assets</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6 ">
						<p class="mb-2"><b>Request Date:</b> 04 Apr 2024</p>
						<p class="mb-2"><b>Type Of Asset:</b> Laptop</p>
						<p class="mb-2"><b>Balance Amount:</b> 15,000/-</p>
					</div>
					<div class="col-md-6">
						<p class="mb-2"><b>Request Amount:</b> 35,000/-</p>
						<p class="mb-2"><b>Approval Amount:</b> 35,000/-</p>
						
					</div>
					<div class="col-md-12 mb-2"><p style="border:1px solid #ddd;"></p></div>
					<div class="col-md-6">
						<p class="mb-2"><b>Copy Of Bill</b></p>
						<img style="width:250px;" src="./images/excel-invoice.jpg" />
					</div>
					<div class="col-md-6">
						<p class="mb-2"><b>Copy Of Asset</b></p>
						<img style="width:250px;" src="./images/excel-invoice.jpg" />
					</div>
					<div class="col-md-12">			
						<p><b>Details:</b></p> 
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
			
			</div>
		  </div>
		</div>
    </div>
	
	<div class="modal fade show" id="billdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle3">Details of Assets</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<img class="w-100" src="./images/excel-invoice.jpg" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
			</div>
		  </div>
		</div>
    </div>
@include('employee.footer');