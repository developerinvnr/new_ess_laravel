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
                                        <a href="#"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">PMS - Appraiser </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class=" pms-bpx">
						<a href="{{route('pms')}}" class="mb-0 sm-btn btn pms-btn" title="Employee" data-original-title="My KRA">Employee</a>
						<a href="{{route('appraisal')}}" class="mb-0 sm-btn btn pms-btn-active" title="Appraiser" data-original-title="Appraiser">Appraiser</a>
						<a href="{{route('reviewer')}}" class="mb-0 sm-btn btn pms-btn" title="Reviewer" data-original-title="Reviewer">Reviewer</a>
						<a href="" class="mb-0 sm-btn btn pms-btn" title="HOD" data-original-title="HOD">HOD</a>
						<a href="" class="mb-0 sm-btn btn pms-btn" title="Management" data-original-title="Management">Management</a>
					   </div>
					</div>
					
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="mfh-machine-profile">
							<div class="float-end mt-3">
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
							<ul class="nav nav-tabs" id="myTab1" role="tablist">
								<li class="nav-item"> 
									<a style="color: #8b8989;" class="nav-link pt-4 " id="oldKra-tab20" data-bs-toggle="tab" href="#OldKraTab" role="tab" aria-controls="OldKraTab" aria-selected="false">My Team</a>
								</li>   
								<li class="nav-item">
									<a style="color: #8b8989;" class="nav-link pt-4 active" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA</a>
								</li>
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade active show" id="KraTab" role="tabpanel">
											<div class="row">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<div class="card">
													<div class="card-header">
														<h5><b>My Team KRA Status</b></h5>
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
																	<th>Employee</th>
																	<th>Appraiser</th>
																	<th>KRA</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td><b>1.</b></td>
																	<td></td>
																	<td></td>
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
											</div>
									</div>
								</div>
								<div class="tab-pane fade" id="OldKraTab" role="tabpanel">
									<div class="card">
										<div class="card-body table-responsive align-items-center">
											
														<table class="table table-pad">
															<thead>
																<tr>
																	<th>Sn.</th>
																	<th>EC</th>
																	<th>Name</th>
																	<th>Department</th>
																	<th>Designation</th>
																	<th>Grade</th>
																	<th>HQ</th>
																	<th>State</th>
																	<th>KRA</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td><b>1.</b></td>
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
                
				<div class="ad-footer-btm">
					<p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
				</div>
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

    <!-- Script Start -->
	<script src="./js/jquery.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
	<script src="./js/swiper.min.js"></script>
    <script src="./js/apexcharts.min.js"></script>
    <script src="./js/control-chart-apexcharts.js"></script>
	<!-- Page Specific -->
    <script src="./js/nice-select.min.js"></script>
    <!-- Custom Script -->
    <script src="./js/custom.js"></script>
</body></html>