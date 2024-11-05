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