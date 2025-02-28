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
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="#"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">PMS - HOD </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						
						<ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" role="tablist">
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;"  class="nav-link active"  href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
									<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
									<span class="d-none d-sm-block">PMS Information</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{route('pms')}}" role="tab" aria-selected="true">
									<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
									<span class="d-none d-sm-block">Employee</span>
								</a>
							</li>
							@if($exists_appraisel)
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('appraiser') }}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Appraiser</span>
								</a>
							</li>
							@endif
							@if($exists_reviewer)
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('reviewer')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Reviewer</span>
								</a>
							</li>
							@endif
							@if($exists_hod)
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('hod')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">HOD</span>
								</a>
							</li>
							@endif
							@if($exists_mngmt)
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('management')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Management</span>
								</a>
							</li>
							@endif
							
						</ul>
					</div>
                <!-- Revanue Status Start -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
					<div class="mfh-machine-profile">
						
						<ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;">   
							<li class="nav-item">
								<a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 active" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
							</li>
							<li class="nav-item">
								<a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
							</li>
						</ul>
						<div class="tab-content ad-content2" id="myTabContent2">
							<div class="tab-pane fade active show" id="KraTab" role="tabpanel">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="card">
												<div class="card-header" style="padding:0 !important;">
													<div class="float-end" style="margin-top:-50px;">
														<select>
															<option>Select Department</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select>
															<option>Select State</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select>
															<option>Select Head Quarter</option>
															<option>All</option>
															<option>Sales</option>
														</select>
													</div>
												</div>
												<div class="card-body table-responsive dd-flex align-items-center">
													<table class="table table-pad">
														<thead>
															<tr>
																<th>SN.</th>
																<th>EC</th>
																<th>Name</th>
																<th>Department</th>
																<th>Designation</th>
																<th>HQ</th>
																<th>Emp Status</th>
																<th>Appraiser Status</th>
																<th>Reviewer Status</th>
																<th>HOD</th>
																<th>KRA View</th>
																
															</tr>
														</thead>
														<tbody>
															<tr>
																<td><b>1.</b></td>
																<td>1254</td>
																<td>Kishan Kumar</td>
																<td>IT</td>
																<td>Ex. Software Developer</td>
																<td>Raipur</td>
																<td><span class="success"><b>Submitted</b></span></td>
																<td><span class="success"><b>Submitted</b></span></td>
																<td><span class="success"><b>Submitted</b></span></td>
																<td><span class="danger"><b>Draft</b></span></td>
																<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewKRA"><i class="fas fa-eye mr-2"></i></a></td>
																
															</tr>
														</tbody>
													</table>
												</div>
												
											</div>
										</div>
								</div>
							</div>
							<div class="tab-pane fade" id="teamappraisal" role="tabpanel">
								<div class="row">
									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
										<div class="card">
											<div class="card-header" style="padding:0 !important;">
													<div class="float-end" style="margin-top:-50px;">
														<select>
															<option>Select Department</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select>
															<option>Select State</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select>
															<option>Select Head Quarter</option>
															<option>All</option>
															<option>Sales</option>
														</select>
													</div>
												</div>
											<div class="card-body table-responsive dd-flex align-items-center">
												<table class="table table-pad">
														<thead>
															<tr>
																<th>SN.</th>
																<th>EC</th>
																<th>Name</th>
																<th>Department</th>
																<th>Designation</th>
																<th>HQ</th>
																<th>Emp Status</th>
																<th>Emp Rating</th>
																<th>Appraiser Status</th>
																<th>Appraiser Rating</th>
																<th>Reviewer Status</th>
																<th>Reviewer rating</th>
																<th>HOD</th>
																<th>Uploaded</th>
																<th>History</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td><b>1.</b></td>
																<td>1254</td>
																<td>Kishan Kumar</td>
																<td>IT</td>
																<td>Ex. Software Developer</td>
																<td>Raipur</td>
																<td><span class="success"><b>Submitted</b></span></td>
																<td>4.50</td>
																<td><span class="success"><b>Submitted</b></span></td>
																<td>3.50</td>
																<td><span class="success"><b>Submitted</b></span></td>
																<td>3.04</td>
																<td><span class="danger"><b>Draft</b></span></td>
																<td><a title="Upload" data-bs-toggle="modal" data-bs-target="#viewuploadedfiles"><i class="fas fa-file-upload ml-2 mr-2"></i></a></td>
																<td><a title="History" data-bs-toggle="modal" data-bs-target="#viewHistory"><i class="fas fa-eye mr-2"></i></a></td>
																<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewappraisal"><i class="fas fa-eye mr-2"></i></a> | <a title="Approved" data-bs-toggle="modal" data-bs-target="#Approved"> <i class="fas fa-check ml-2 mr-2"></i></a> | <a title="Revert" data-bs-toggle="modal" data-bs-target="#resubmitKRA"> <i class="fas fa-retweet"></i></a></td>
			
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
				</div>
			</div>
			@include('employee.footerbottom')
        </div>
    </div>
    </div>
<!--View KRA Modal-->
<div class="modal fade show" id="viewKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-header">
	  <h5 class="modal-title" ><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
	  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">×</span>
	  </button>
	  </div>
	  <div class="modal-body table-responsive">
		<div class="card" id="viewkrabox">
					  <div class="card-header">
						  <div style="float:left;width:100%;">
							  <h5 class="float-start"><b>Form - A (KRA)</b></h5>
						  </div>
					  </div>
					  <div class="card-body table-responsive dd-flex align-items-center">
		<table class="table table-pad">
						  <thead>
							  <tr>
								  <th>SN.</th>
								  <th>KRA/Goals</th>
								  <th>Description</th>
								  <th>Measure</th>
								  <th>Unit</th>
								  <th>Weightage</th>
								  <th>Logic</th>
								  <th>Period</th>
								  <th>Target</th>
							  </tr>
						  </thead>
						  <tbody>
							  <tr>
								  <td><i class="fas fa-plus-circle mr-2"></i><b>1.</b></td>
								  <td>test </td>
								  <td>twst</td>
								  <td>Process</td>
								  <td>Days</td>
								  <td>15</td>
								  <td>Logic 01</td>
								  <td>Quarterly</td>
								  <td><button style="padding: 5px 8px;" type="button" class="btn btn-outline-success custom-toggle" data-bs-toggle="modal"
									data-bs-target="#viewTargetDetails">
										<span class="icon-on">100 </span> 
									</button></td>
							  </tr>
							  <tr>
								  <td><i class="fas fa-plus-circle mr-2"></i><b>2.</b></td>
								  <td>test </td>
								  <td>twst</td>
								  <td>Process</td>
								  <td>Days</td>
								  <td>25</td>
								  <td>Logic 01</td>
								  <td>Quarterly</td>
								  <td><button style="padding: 5px 8px;" type="button" class="btn btn-outline-success custom-toggle" data-bs-toggle="modal"
									data-bs-target="#viewTargetDetails">
										<span class="icon-on">100 </span> 
									</button></td>
							  </tr>
							  <tr>
								  <td><i class="fas fa-plus-circle mr-2"></i><b>3.</b></td>
								  <td>test </td>
								  <td>twst</td>
								  <td>Process</td>
								  <td>Days</td>
								  <td>20</td>
								  <td>Logic 01</td>
								  <td>Quarterly</td>
								  <td><button style="padding: 5px 8px;" type="button" class="btn btn-outline-success custom-toggle" data-bs-toggle="modal"
									data-bs-target="#viewTargetDetails">
										<span class="icon-on">100 </span> 
									</button></td>
							  </tr>
							  <tr>
								  <td><i class="fas fa-plus-circle mr-2"></i><b>4.</b></td>
								  <td>test </td>
								  <td>twst</td>
								  <td>Process</td>
								  <td>Days</td>
								  <td>20</td>
								  <td>Logic 01</td>
								  <td>Quarterly</td>
								  <td><button style="padding: 5px 8px;" type="button" class="btn btn-outline-success custom-toggle" data-bs-toggle="modal"
									data-bs-target="#viewTargetDetails">
										<span class="icon-on">100 </span> 
									</button></td>
							  </tr>
							  <tr>
								  <td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
								  <td>test </td>
								  <td>twst</td>
								  <td>Process</td>
								  <td>Days</td>
								  <td>10</td>
								  <td>Logic 01</td>
								  <td>Quarterly</td>
								  <td><button style="padding: 5px 8px;" type="button" class="btn btn-outline-success custom-toggle" data-bs-toggle="modal"
									data-bs-target="#viewTargetDetails">
										<span class="icon-on">100 </span> 
									</button></td>
							  </tr>
							  <tr>
								<td colspan="9" style="text-align: center;"><button type="button"
										class="effect-btn btn btn-success squer-btn sm-btn">Approval</button>
								</td>
							</tr>
						  </tbody>
					  </table>
				  </div>
			  </div>
	  </div>
	  <div class="modal-footer">
		<a class="effect-btn btn btn-light squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
	  </div>
	</div>
	</div>
  </div>

  <!--KRA Target View Details-->
<div class="modal fade show" id="viewTargetDetails" tabindex="-1"
aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">KRA View Details</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body">
			<b>Logic: Logic 01</b><br>
			<b>KRA:</b>There are many variations of passages of Lorem Ipsum available, but the majority have
			suffered.<br>
			<b>Description:</b> twst
			<table class="table table-pad" id="mykraeditbox">
				<thead>
					<tr>
						<th colspan="5"></th>
						<th style="text-align: center;" colspan="3">Employee Achievement Details</th>
						<th style="text-align: center;" colspan="3">Reporting Rating Details</th>
						<th colspan="3"></th>
					</tr>
					<tr>
						<th>SN.</th>
						<th>Quarter</th>
						<th>Weightage</th>
						<th>Target</th>
						<th style="width: 320px;">Activity Performed</th>
						<th>Emp. Rating</th>
						<th>Remarks</th>
						<th>Score</th>
						<th>Rep. Rating</th>
						<th>Remarks</th>
						<th>Score</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>1.</b></td>
						<td style="width:66px;">Quarter 1</td>
						<td>1.25</td>
						<td>25</td>
						<td>Backup</td>
						<td style="background-color: #e7ebed">25</td>
						<td style="background-color: #e7ebed">test</td>
						<td style="background-color: #e7ebed">1.25</td>
                        <td style="background-color: #dcdcdc">25</td>
						<td style="background-color: #dcdcdc">test</td>
						<td style="background-color: #dcdcdc">1.25</td>
						
						
						<td>
							<i class="fas fa-check-circle mr-2 text-success"></i>
						</td>
					</tr>
					<tr>
						<td> <b>2.</b></td>
						<td>Quarter 2</td>
						<td>1.25</td>
						<td>25</td>
						<td>Backup</td>
						<td style="background-color: #e7ebed">24</td>
						<td style="background-color: #e7ebed">test</td>
						<td style="background-color: #e7ebed">1.25</td>
                        <td style="background-color: #dcdcdc">25</td>
						<td style="background-color: #dcdcdc">test</td>
						<td style="background-color: #dcdcdc">1.25</td>
						<td>
							<i class="ri-check-double-line mr-2 text-success"></i>
						</td>
					</tr>
					<tr>
						<td> <b>3.</b></td>
						<td>Quarter 3</td>
						<td>1.25</td>
						<td>25</td>
						<td>Backup</td>
						<td style="background-color: #e7ebed">25</td>
						<td style="background-color: #e7ebed">test</td>
						<td style="background-color: #e7ebed">1.25</td>
                        <td style="background-color: #dcdcdc">25</td>
						<td style="background-color: #dcdcdc">test</td>
						<td style="background-color: #dcdcdc">1.25</td>
						<td>
							<i class="fas fa-check-circle mr-2 text-success"></i>
						</td>
					</tr>
					<tr>
						<td> <b>4.</b></td>
						<td>Quarter 4</td>
						<td>1.25</td>
						<td>25</td>
						<td>Backup</td>
						<td style="background-color: #e7ebed">25</td>
						<td style="background-color: #e7ebed">test</td>
						<td style="background-color: #e7ebed">1.25</td>
                        <td style="background-color: #dcdcdc">25</td>
						<td style="background-color: #dcdcdc">test</td>
						<td style="background-color: #dcdcdc">1.25</td>
						
						<td>
							<i class="fas fa-check-circle mr-2 text-success"></i>
						</td>
					</tr>
					<tr>
						<td colspan="2"><b>Total</b></td>
						<td>5</td>
						<td>100</td>
						<td></td>
						<td>98</td>
						<td></td>
						<td>5</td>
						<td>100</td>
						<td></td>
						<td>5</td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<div class="float-end">
				<i class="fas fa-check-circle mr-2 text-success"></i>Final Submit, <i class="ri-check-double-line mr-1 text-success"></i> Save as Draft
			</div>
			<p><b>Note:</b><br> 1. Please ensure that the achievement is calculated against the "<blink><b>Target Value</b></blink>"
				only.<br>
				2. The achievement is required to be entered on the last day or within few days beyard which
				the KRA will set auto locked.</p>
		</div>
		<div class="modal-footer">
			<button type="button" class="effect-btn btn btn-light squer-btn sm-btn "
				data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
</div>
  
  <!--All achivement and feedback view -->
  <div class="modal fade show" id="viewappraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
	<div class="modal-content">
	  <div class="modal-header">
	  <h5 class="modal-title" ><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
	  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">×</span>
	  </button>
	  </div>
	  <div class="modal-body">
		<div class="splash-Accordion4">
									  <div class="accordion card" id="accordionExample">
										<div class="item">
										   <div class="item-header card-header" id="headingOnej">
											  <h5 class="mb-0">
											  Achievements
												 <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnej" aria-expanded="true" aria-controls="collapseOnej">
												 <i class="fa fa-angle-down"></i>
												 </button>
											  </h5>
										   </div>
										   <div id="collapseOnej" class="collapse show card-body" aria-labelledby="headingOnej" data-bs-parent="#accordionExample">
											   <ol>
		  <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
		  <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
		  <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
		  <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
		  </ol>
										   </div>
										</div>
										<div class="item">
										   <div class="item-header card-header" id="headingTwok">
											  <h5 class="mb-0">
												  Feedback
												 <button class="btn btn-link collapsed float-end" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwok" aria-expanded="false" aria-controls="collapseTwok">
												 <i class="fa fa-angle-down"></i>
												 </button>
											  </h5>
										   </div>
										   <div id="collapseTwok" class="collapse show card-body" aria-labelledby="headingTwok" data-bs-parent="#accordionExample">
											  <ul>
		  <li>1. What is your feedback regarding the existing & new processes that are being followed or needs to be followed in your respective functions?</li>
		  <li><b>Ans.</b> test 123456</li>
		  <li>&nbsp;</li>
		  <li>2. At work, are there any factors that hinder your growth?</li>
		  <li><b>Ans.</b> test 123456</li>
		  <li>&nbsp;</li>
		  <li>3. At work, what are the factors that facilitate your growth?</li>
		  <li><b>Ans.</b> test 123456</li>
		  <li>&nbsp;</li>
		  <li>4. What support you need from the superiors to facilitate your performance?</li>
		  <li><b>Ans.</b> test 123456</li>
		  <li>&nbsp;</li>
		  <li>5. Any other feedback.</li>
		  <li><b>Ans.</b> test 123456</li>
		</ul>
										   </div>
										</div>
									  </div>
								  </div>
								  <div class="card">
									<div class="card-header">
										<div style="float:left;width:100%;">
											<h5 class="float-start"><b>Form - A (KRA)</b></h5>
										</div>
									</div>
									<div class="card-body table-responsive dd-flex align-items-center">
										<table class="table table-pad" id="mykrabox">
												<thead>
													<tr>
														<th>SN.</th>
														<th>KRA/Goals</th>
														<th>Description</th>
														<th>Measure</th>
														<th>Unit</th>
														<th>Weightage</th>
														<th>Logic</th>
														<th>Period</th>
														<th>Target</th>
														<th>Emp Rating</th>
														<th>Emp Remarks</th>
														<th>Appraiser Rating</th>
														<th>Appraiser Score</th>
														<th>Appraiser Remarks</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td><b>1.</b></td>
														<td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
														<td>twst</td>
														<td>Process</td>
														<td>Days</td>
														<td>45.5</td>
														<td>Logic 01</td>
														<td>Quarterly</td>
														<td>100</td>
														<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
													</tr>
													<tr>
														<td><b>2.</b></td>
														<td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
														<td>twst</td>
														<td>Process</td>
														<td>Days</td>
														<td>45.5</td>
														<td>Logic 01</td>
														<td>Quarterly</td>
														<td>100</td>
														<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
													</tr>
													<tr>
														<td><b>3.</b></td>
														<td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
														<td>twst</td>
														<td>Process</td>
														<td>Days</td>
														<td>45.5</td>
														<td>Logic 01</td>
														<td>Quarterly</td>
														<td>100</td>
														<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
													</tr>
													<tr>
														<td><b>4.</b></td>
														<td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
														<td>twst</td>
														<td>Process</td>
														<td>Days</td>
														<td>45.5</td>
														<td>Logic 01</td>
														<td>Quarterly</td>
														<td>100</td>
														<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
													</tr>
													<tr>
														<td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
														<td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
														<td>twst</td>
														<td>Process</td>
														<td>Days</td>
														<td>45.5</td>
														<td>Logic 01</td>
														<td>Quarterly</td>
														<td>100</td>
														<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
													</tr>
													<tr>
														<td colspan="15">
															<table class="table" Style="background-color:#ECECEC;">
																<thead >
																	<tr>
																		<th>SN.</th>
																		<th>Sub KRA/Goals</th>
																		<th>Description</th>
																		<th>Measure</th>
																		<th>Unit</th>
																		<th>Weightage</th>
																		<th>Logic</th>
																		<th>Period</th>
																		<th>Target</th>
																		<th>Emp Rating</th>
														<th>Emp Remarks</th>
														<th>Appraiser Rating</th>
														<th>Appraiser Score</th>
														<th>Appraiser Remarks</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																	<td><b>1.</b></td>
																	<td>test </td>
																	<td>twst</td>
																	<td>Process</td>
																	<td>Days</td>
																	<td>45.5</td>
																	<td>Logic 01</td>
																	<td>Quarterly</td>
																	<td>100</td>
																	<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
																</tr>
																<tr>
																	<td><b>2.</b></td>
																	<td>test </td>
																	<td>twst</td>
																	<td>Process</td>
																	<td>Days</td>
																	<td>45.5</td>
																	<td>Logic 01</td>
																	<td>Quarterly</td>
																	<td>100</td>
																	<td>85</td>
														<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
														<td>67</td>
														<td>20.1</td>
														<td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
																</tr>
																</tbody>
															</table>
														</td>
													</tr>
													<tr style="background-color:#6c8b93;">
														<td colspan="13">Appraiser Final KRA Score</td>
														<td>90.54</td>
														<td></td>
													<tr>
													<tr style="background-color:#6c8b93;">
														<td colspan="13">Reviewer Score</td>
														<td>90</td>
														<td></td>
													<tr>
												</tbody>
											</table>
										</div>
									</div>
								<div class="card">
									<div class="card-header">
										<div style="float:left;width:100%;">
											<h5 class="float-start"><b>PMS Score</b></h5>
										</div>
									</div>
									<div class="card-body table-responsive dd-flex align-items-center">	
<table class="table" style="background-color:#ECECEC;">
											<thead>
												<tr>
													<th>SN.</th>
													<th>KRA form</th>
													<th>% Weightage</th>
													<th>(A) KRA Score</th>
													<th>Behavioral form</th>
													<th>% Weightage</th>
													<th>(B) Behavioral score</th>
													<th>(A + B) PMS Score</th>
													<th>Rating</th>
												</tr>
											</thead>
											<tbody>
												<tr>
												<td>Employee</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>Appraiser</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											<tr>
												<td>Reviewer</td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
<div class="card">
									<div class="card-header">
										<div style="float:left;width:100%;">
											<h5 class="float-start"><b>Designation Upgrade</b></h5>
										</div>
									</div>
<div class="card-body table-responsive dd-flex align-items-center">
<table class="table">
	<thead>
		<tr>
			<th></th>
			<th>Grade</th>
			<th>Designation</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>Current</b></td>
			<td><b>J4.</b></td>
			<td><b>Business manager</b></td>
			<td><b>-</b></td>
		</tr>
		<tr>
			<td><b>Appraiser</b></td>
			<td><b>J4.</b></td>
			<td><b>Zonal Manager</b></td>
			<td><b>-</b></td>
		</tr>
		<tr>
			<td><b>Reviewer</b></td>
			<td><b>J4.</b></td>
			<td><b>Zonal Manager</b></td>
			<td><b>-</b></td>
		</tr>
	</tbody>
</table>
</div>
</div>
								<div class="card">
									<div class="card-header">
										<div style="float:left;width:100%;">
											<h5 class="float-start"><b>Training Requirements by Appraiser</b></h5>
										</div>
									</div>
<div class="card-body table-responsive dd-flex align-items-center">
	<b>A) Soft Skills Training [Based on Behavioral parameter]</b>
	<table class="table">
		<thead>
		<tr>
			<th>Sn</th>
			<th>Category</th>
			<th>Topic</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>1</b></td>
			<td><b>Business Skills</b></td>
			<td>Leadership Skills</td>
			<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
		</tr>
		<tr>
			<td><b>1</b></td>
			<td><b>Business Skills</b></td>
			<td>Leadership Skills</td>
			<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
		</tr>
	</tbody>
	</table>
	
	<b>B) Functional Skills Training [Job related]</b>
	<table class="table">
		<thead>
		<tr>
			<th>Sn</th>
			<th>Topic</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>1</b></td>
			<td><b>Accounting & Budget Training</b></td>
			<td>Managing the company's finances. Budgeting will help project expenditures for given periodicity.</td>
		</tr>
		<tr>
			<td><b>1</b></td>
			<td><b>Customer handling</b></td>
			<td>	Dealing with different kinds of customers, developing persuasive skills, handling complaints, developing listening skills & empathy, taking control and solving problems, mantaining customer relations etc.</td>
		</tr>
	</tbody>
	</table>
	<div class="mt-3">
		<h5>Appraisal Remarks</h5>
		<p>test remarks.</p>
	</div>
</div>
								</div>
<div class="card">
									<div class="card-header">
										<div style="float:left;width:100%;">
											<h5 class="float-start"><b>Training Requirements by Reviewer</b></h5>
										</div>
									</div>
<div class="card-body table-responsive dd-flex align-items-center">
	<b>A) Soft Skills Training [Based on Behavioral parameter]</b>
	<table class="table">
		<thead>
		<tr>
			<th>Sn</th>
			<th>Category</th>
			<th>Topic</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>1</b></td>
			<td><b>Business Skills</b></td>
			<td>Leadership Skills</td>
			<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
		</tr>
		<tr>
			<td><b>1</b></td>
			<td><b>Business Skills</b></td>
			<td>Leadership Skills</td>
			<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
		</tr>
	</tbody>
	</table>
	
	<b>B) Functional Skills Training [Job related]</b>
	<table class="table">
		<thead>
		<tr>
			<th>Sn</th>
			<th>Topic</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><b>1</b></td>
			<td><b>Accounting & Budget Training</b></td>
			<td>Managing the company's finances. Budgeting will help project expenditures for given periodicity.</td>
		</tr>
		<tr>
			<td><b>1</b></td>
			<td><b>Customer handling</b></td>
			<td>	Dealing with different kinds of customers, developing persuasive skills, handling complaints, developing listening skills & empathy, taking control and solving problems, mantaining customer relations etc.</td>
		</tr>
	</tbody>
	</table>
	<div class="mt-3">
		<h5>Reviewer Remarks</h5>
		<p>test remarks.</p>
	</div>
</div>
								</div>												
</div>
<div class="modal-footer">
<a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>

<!-- Revert KRA -->
<div class="modal fade show" id="resubmitKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Revert Note</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body appraisal-view">
<div class="form-group mr-2" id="">
	<label class="col-form-label">Revert Note</label>
	<textarea placeholder="Enter your revert note" class="form-control" ></textarea>
</div>
</div>
<div class="modal-footer">
<a class="effect-btn btn btn-success squer-btn sm-btn">Send</a>
  <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>
<!-- Approved KRA -->
<div class="modal fade show" id="Approved" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" >Approved Note</h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body appraisal-view">
<div class="form-group mr-2" id="">
	<label class="col-form-label">Approved Note</label>
	<textarea placeholder="Enter your Approved note" class="form-control" ></textarea>
</div>
</div>
<div class="modal-footer">
<a class="effect-btn btn btn-success squer-btn sm-btn">Send</a>
  <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>



<!--view upload Modal-->
<div class="modal fade show" id="viewuploadedfiles" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title" ><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
		<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span>
		</button>
	</div>
	<div class="modal-body table-responsive p-0">
		<div class="card">
			<div class="card-header">
				<div style="float:left;width:100%;">
					<h5 class="float-start"><b>Upload Files</b></h5>
				</div>
			</div>
			<div class="card-body table-responsive dd-flex align-items-center">
				<table class="table table-pad">
					<thead>
						<tr>
							<th>SN.</th>
							<th>File Name</th>
							<th>File</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>1.</b></td>
							<td>image 1</td>
							<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewuploadfile"><i class="fas fa-eye mr-2"></i></a></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!--view history Modal-->

<div class="modal fade show" id="viewHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title me-2"  style="font-size:13px;">
		<img src="./images/user.jpg"><br>
		EC: 1254
		</h5>
		<table class="table mb-0">
			<tr>
				<td colspan="3"><b>Kishan Kumar</b></td>
				<td colspan=""><b>DOJ: 07-03-2019</b></td>
			</tr>
			<tr>
				<td><b>Designation:</b></td>
				<td style="color:#DC7937;"><b>Ex. Software Developer</b></td>
				<td><b>Function:</b></td>
				<td style="color:#DC7937;"><b>Business Operations</b></td>
				
			</tr>
			<tr>
				<td><b>VNR Exp.</b></td>
				<td style="color:#DC7937;"><b>5.8 Year</b></td>
				<td><b>Rrev. Exp.</b></td>
				<td style="color:#DC7937;"><b>9.00 Year</b></td>
			</tr>
		</table>
		<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">×</span>
		</button>
	</div>
	<div class="modal-body table-responsive">
	<div class="card">
		<div class="card-header">
			<div style="float:left;width:100%;">
				<h5 class="float-start"><b>Career Progression in VNR</b></h5>
			</div>
		</div>
		<div class="card-body table-responsive align-items-center">
			<table class="table table-pad">
				<thead>
					<tr>
						<th>SN.</th>
						<th>Date</th>
						<th>Designation</th>
						<th>Grade</th>
						<th>Previous Gross</th>
						<th>Monthly Gross</th>
						<th>CTC</th>
						<th>% Increment</th>
						<th>Rating</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>1.</b></td>
						<td>12-06-2024</td>
						<td>Territory Business Manager</td>
						<td>J4</td>
						<td>51474</td>
						<td>57375 </td>
						<td>0 </td>
						<td> </td>
						<td>0.00</td>
					</tr>
					<tr>
						<td><b>2.</b></td>
						<td>12-06-2024</td>
						<td>Territory Business Manager</td>
						<td>J4</td>
						<td>51474</td>
						<td>57375 </td>
						<td>0 </td>
						<td> </td>
						<td>0.00</td>
					</tr>
					<tr>
						<td><b>3.</b></td>
						<td>12-06-2024</td>
						<td>Territory Business Manager</td>
						<td>J4</td>
						<td>51474</td>
						<td>57375 </td>
						<td>0 </td>
						<td> </td>
						<td>0.00</td>
					</tr>
					<tr>
						<td><b>4.</b></td>
						<td>12-06-2024</td>
						<td>Territory Business Manager</td>
						<td>J4</td>
						<td>51474</td>
						<td>57375 </td>
						<td>0 </td>
						<td> </td>
						<td>0.00</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="card">
		<div class="card-header">
			<div style="float:left;width:100%;">
				<h5 class="float-start"><b>Previous Employers</b></h5>
			</div>
		</div>
		<div class="card-body table-responsive align-items-center">
			<table class="table table-pad">
				<thead>
					<tr>
						<th>SN.</th>
						<th>Company</th>
						<th>Designation</th>
						<th>From Date</th>
						<th>To Date</th>
						<th>Duration</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>1.</b></td>
						<td>Nuziveedu seeds limited	</td>
						<td>Senior Officer</td>
						<td>02-01-2018</td>
						<td>28-02-2019</td>
						<td>1.1 year</td>
					</tr>
					<tr>
						<td><b>2.</b></td>
						<td>Nuziveedu seeds limited	</td>
						<td>Senior Officer</td>
						<td>02-01-2018</td>
						<td>28-02-2019</td>
						<td>1.1 year</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="card">
		<div class="card-header">
			<div style="float:left;width:100%;">
				<h5 class="float-start"><b>Developmental Progress</b></h5>
			</div>
		</div>
		<div class="card-body table-responsive align-items-center">
			<h5 class="mb-2">A. Training Programs</h5>
			<table class="table table-pad mb-4">
				<thead>
					<tr>
						<th>SN.</th>
						<th>Subject</th>
						<th>Date</th>
						<th>Duration</th>
						<th>Institute</th>
						<th>Trainer</th>
						<th>Location</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>1.</b></td>
						<td>Effective Farmer Meetings & Handling Complaints</td>
						<td>24-03-2023</td>
						<td>1.0</td>
						<td>S S Technologies</td>
						<td>B Sivaprasad</td>
						<td>Hotel White House INN, Indore</td>
					</tr>
					<tr>
						<td><b>1.</b></td>
						<td>Effective Farmer Meetings & Handling Complaints</td>
						<td>24-03-2023</td>
						<td>1.0</td>
						<td>S S Technologies</td>
						<td>B Sivaprasad</td>
						<td>Hotel White House INN, Indore</td>
					</tr>
				</tbody>
			</table>
			
			<h5 class="mb-2">B. Training Programs</h5>
			<table class="table table-pad">
				<thead>
					<tr>
						<th>SN.</th>
						<th>Title</th>
						<th>Date</th>
						<th>Duration</th>
						<th>Conduct by</th>
						<th>Location</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	</div>
</div>
</div>
</div>
@include('employee.footer')