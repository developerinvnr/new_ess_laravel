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
									<a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>

                                    </li>
                                    <li class="breadcrumb-link active">PMS - Management </li>
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
								<a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
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
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('appraiser') }}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Appraiser</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('reviewer')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Reviewer</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('hod')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">HOD</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{route('management')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Management</span>
								</a>
							</li>
							
						</ul>
					</div>
					
                <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
						<div class="mfh-machine-profile">
							
							<ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" >   
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 " id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA New 2025-26</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="team_appraisal_tab20" href="{{route('managementAppraisal')}}" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center active" id="team_report_tab20" data-bs-toggle="tab" href="#teamreport" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center" id="team_graph_tab20" href="{{route('managementGraph')}}" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
								</li>
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								
							<div class="tab-pane fade active show" id="teamreport" role="tabpanel">
									<div class="row">
										<div class="mfh-machine-profile">
										<div style="margin-top:-40px;float:left;margin-left:660px;">
											<ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
												<li class="mt-1"><a class="active" id="pmsreport-tab1"
													data-bs-toggle="tab" href="#PmsReport" role="tab"
													aria-controls="PmsReport" aria-selected="true">PMS Report <i
														class="fas fa-star mr-2"></i></a></li>
												
												<li class="mt-1"><a class="" id="IncrementReport-tab21"
													data-bs-toggle="tab" href="#IncrementReport" role="tab"
													aria-controls="IncrementReport" aria-selected="false">Increment Report <i class="fas fa-file-invoice mr-2"></i></a></li>
											</ul>
										</div>
										<div class="tab-content splash-content2">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
										id="PmsReport" role="tabpanel">
											<div class="card">
												
												<div class="card-header" style="background-color:#A8D0D2;">
													<b>Team PMS Report</b>
													<div class="float-end">
														<select class="mr-2 ms-2">
															<option>Sorting</option>
															<option>Department</option>
															<option>Grade</option>
														</select>
														<select class="mr-2">
															<option>Select Department</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select class="mr-2">
															<option>Select State</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select class="mr-2">
															<option>Select Grade</option>
															<option>All</option>
															<option>J1</option>
														</select>
														<select class="mr-2">
															<option>Select Region</option>
															<option>All</option>
															<option>J1</option>
														</select>	
													</div>
												</div>
												<div class="card-body table-responsive dd-flex align-items-center">
													<table class="table table-pad">
														<thead>
															<tr>
																<th rowspan="2">SN.</th>
																<th class="text-center" colspan="8" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
																<th rowspan="2">Proposed Description</th>
																<th rowspan="2">PG</th>

																<th class="text-center" colspan="3" style="border-right: 1px solid #fff;border-left:1px solid #fff;">CTC</th>
																<th class="text-center" colspan="4" style="border-right: 1px solid #fff;">Total</th>
																
																
																<th  rowspan="2" class="text-center">Action</th>
															</tr>
															<tr>
																<th style="text-align:center;border-left:1px solid #fff;">EC</th>
																<th >Employee Name</th>
																<th >Department</th>
																<th >Designation</th>
																<th style="text-align:center;">Grade</th>
																<th class="text-center">State</th>
																<th style="text-align:center;">Score</th>
																<th style="text-align:center;border-right:1px solid #fff;">Rating</th>
																<th style="text-align:center;border-left:1px solid #fff;">Proposed</th>
																<th style="text-align:center;">%</th>
																<th style="text-align:center;border-right:1px solid #fff;">Correction</th>
																<th style="text-align:center;">% Correction</th>
																<th style="text-align:center;">Increment</th>
																<th style="text-align:center;">% </th>
																<th style="text-align:center;border-right:1px solid #fff;">Proposed</th>
															</tr>
															
														</thead>
															<tbody>
																<tr>
																	<td>01</td>
																	<td>130</td>
																	<td>Manohar Verma</td>
																	<td>Sales</td>
																	<td>Area Sales Coordinator</td>
																	<td class="text-center">M1</td>
																	<td class="text-center">Mp</td>
																	<td class="text-center r-color"><b>88.55</b></td>
																	<td class="text-center r-color"><b>3.40</b></td>
																	<td>-</td>
																	<td>-</td>
																	<td class="p-color"><b>1196078/-</b></td>
																	<td class="text-center r-color"><b>9.50</b></td>
																	<td class="text-center r-color"><b>0</b></td>
																	<td class="text-center"><b>0.00</b></td>
																	<td class="p-color"><b>103769/-</b></td>
																	<td class="text-center r-color"><b>9.50</b></td>
																	<td class="p-color"><b>1196078/-</b></td>
																</tr>
															</tbody>
														</table>
											</div>
										</div>
									</div>

									<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade"
										id="IncrementReport" role="tabpanel">
											<div class="card">
												<div class="card-header" style="background-color:#A8D0D2;">
													<b>Team Increments Report</b>
													<div class="float-end">
														<select class="mr-2 ms-2">
															<option>Sorting</option>
															<option>Department</option>
															<option>Grade</option>
														</select>
														<select class="mr-2">
															<option>Select Department</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select class="mr-2">
															<option>Select State</option>
															<option>All</option>
															<option>Sales</option>
														</select>
														<select class="mr-2">
															<option>Select Grade</option>
															<option>All</option>
															<option>J1</option>
														</select>
														<select class="mr-2">
															<option>Select Region</option>
															<option>All</option>
															<option>J1</option>
														</select>	
													</div>
												</div>
												<div class="card-body table-responsive dd-flex align-items-center">
													<div class="mb-2 w-100 p-1" style="background-color: #8da5a7;" >
														<b class="me-3">All Employee: </b> <b>Total Proposed CTC:</b> <input style="width:100px;" class="me-4 bold" type="text" value="215487" /> 
														<b>Total Increments:</b> <input style="width:100px;" class="me-2 bold" type="text" value="302564"> <input style="width:60px;" class="me-2 bold" type="text" value="9.20"><b>%</b> 
														<b class="ms-4">SC:</b> <input style="width:60px;" class="me-2 bold" type="text" value="0.44"><b>%</b>
													</div>
													<table class="table table-pad">
														<thead>
															<tr>
																<th rowspan="2">SN.</th>
																<th class="text-center" colspan="8" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
																<th rowspan="2">Proposed Description</th>
																<th rowspan="2">PG</th>

																<th class="text-center" colspan="3" style="border-right: 1px solid #fff;border-left:1px solid #fff;">CTC</th>
																<th class="text-center" colspan="4" style="border-right: 1px solid #fff;">Total</th>
																
																
																<th  rowspan="2" class="text-center">Action</th>
															</tr>
															<tr>
																<th style="text-align:center;border-left:1px solid #fff;">EC</th>
																<th >Employee Name</th>
																<th >Department</th>
																<th >Designation</th>
																<th style="text-align:center;">Grade</th>
																<th class="text-center">State</th>
																<th style="text-align:center;">Score</th>
																<th style="text-align:center;border-right:1px solid #fff;">Rating</th>
																<th style="text-align:center;border-left:1px solid #fff;">Proposed</th>
																<th style="text-align:center;">%</th>
																<th style="text-align:center;border-right:1px solid #fff;">Correction</th>
																<th style="text-align:center;">% Correction</th>
																<th style="text-align:center;">Increment</th>
																<th style="text-align:center;">% </th>
																<th style="text-align:center;border-right:1px solid #fff;">Proposed</th>
															</tr>
															
														</thead>
															<tbody>
																<tr>
																	<td>01</td>
																	<td>130</td>
																	<td>Manohar Verma</td>
																	<td>Sales</td>
																	<td>Area Sales Coordinator</td>
																	<td class="text-center">M1</td>
																	<td class="text-center">Mp</td>
																	<td class="text-center r-color"><b>88.55</b></td>
																	<td class="text-center r-color"><b>3.40</b></td>
																	<td>-</td>
																	<td>-</td>
																	<td class="p-color"><b>1196078/-</b></td>
																	<td class="text-center r-color"><b>9.50</b></td>
																	<td class="text-center r-color"><b>0</b></td>
																	<td class="text-center"><b>0.00</b></td>
																	<td class="p-color"><b>103769/-</b></td>
																	<td class="text-center"><b>9.50</b></td>
																	<td class="p-color"><b>1196078/-</b></td>
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
							<div class="tab-pane fade" id="teamgraph" role="tabpanel">
								<div class="row">
									<div class="mfh-machine-profile">
										<div style="margin-top:-40px;float:left;margin-left:660px;">
											
											<ul class="kra-btns nav nav-tabs border-0" id="ratingTab1" role="tablist">
												<li class="mt-1"><a class="active" id="ratinggraph-tab1"
													data-bs-toggle="tab" href="#ratinggraph" role="tab"
													aria-controls="ratinggraph" aria-selected="true">Rating Graph <i
														class="fas fa-star mr-2"></i></a></li>
												
												<li class="mt-1"><a class="" id="overallratinggraph-tab21"
													data-bs-toggle="tab" href="#overallratinggraph" role="tab"
													aria-controls="overallratinggraph" aria-selected="false">Overall Rating Graph <i class="fas fa-file-invoice mr-2"></i></a></li>
											</ul>
										</div>
									
										<div class="tab-content splash-content2" >
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
										 role="tabpanel" id="ratinggraph">
												<div class="card">
													<div class="card-header">
														<h5>Rating Graph</h5>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center">
														<table class="table table-pad table-striped" style="font-size:11px;">
															<tbody>
																<tr>
																	<td><b>Rating</b></td>
																	<td>1.0</td>
																	<td>2.0</td>
																	<td>2.5</td>
																	<td>2.7</td>
																	<td>2.9</td>
																	<td>3.0</td>
																	<td>3.2</td>
																	<td>3.4</td>
																	<td>3.5</td>
																	<td>3.7</td>
																	<td>3.9</td>
																	<td>4.0</td>
																	<td>4.2</td>
																	<td>4.4</td>
																	<td>4.5</td>
																	<td>4.7</td>
																	<td>4.9</td>
																	<td>5.0</td>
																</tr>
																<tr>
																	<td><b>Expected</b></td>
																	<td>0</td>
																	<td>0</td>
																	<td>0.09</td>
																	<td>0.15</td>
																	<td>0.21</td>
																	<td>0.24</td>
																	<td>0.3</td>
																	<td>0.39</td>
																	<td>0.42</td>
																	<td>0.36</td>
																	<td>0.27</td>
																	<td>0.21</td>
																	<td>0.15</td>
																	<td>0.12</td>
																	<td>0.09</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																</tr>
																<tr>
																	<td><b>Actual</b></td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>0</td>
																	<td>2</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>

																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade"
										 role="tabpanel" id="overallratinggraph">
												<div class="card">
													<div class="card-header">
														<h5>Overall Rating Graph</h5>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center">
														<table class="table table-pad">
															<tbody>
																<tr>
																	<td>Rating</td>
																</tr>
																<tr>
																	<td>Employee</td>
																</tr>
																<tr>
																	<td>Appariser</td>
																</tr>
																<tr>
																	<td>Reviewer</td>
																</tr>
																<tr>
																	<td>HOD</td>
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
        			</div>
				</div>
                @include('employee.footerbottom')

        	</div>
    	</div>
    </div>
@include('employee.footer')
