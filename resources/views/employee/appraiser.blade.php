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
						<a href="{{route('appraiser')}}" class="mb-0 sm-btn btn pms-btn-active" title="Appraiser" data-original-title="Appraiser">Appraiser</a>
						<a href="{{route('reviewer')}}" class="mb-0 sm-btn btn pms-btn" title="Reviewer" data-original-title="Reviewer">Reviewer</a>
						<a href="{{route('hod')}}" class="mb-0 sm-btn btn pms-btn" title="HOD" data-original-title="HOD">HOD</a>
						<a href="{{route('management')}}" class="mb-0 sm-btn btn pms-btn" title="Management" data-original-title="Management">Management</a>
					   </div>
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
																	<th>Employee</th>
																	<th>Appraiser</th>
																	<th>KRA Edit & View</th>
																	
																	<th>Assessment</th>
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
																	<td><span class="danger"><b>Draft</b></span></td>
																	<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewKRA"><i class="fas fa-eye mr-2"></i></a></td>
																	
																	<td></td>
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
															<a class="effect-btn btn btn-secondary squer-btn sm-btn">Rating Graph <i class="fas fa-chart-bar mr-1 ml-2"></i></a>
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
																	<th>Employee</th>
																	<th>Appraiser</th>
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
																	<td><span class="danger"><b>Draft</b></span></td>
																	<td><a title="Upload" data-bs-toggle="modal" data-bs-target="#viewuploadedfiles"><i class="fas fa-file-upload ml-2 mr-2"></i></a></td>
																	<td><a title="History" data-bs-toggle="modal" data-bs-target="#viewHistory"><i class="fas fa-eye mr-2"></i></a></td>
																	<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewappraisal"><i class="fas fa-eye mr-2"></i></a>| <a title="Edit" data-bs-toggle="modal" data-bs-target="#editAppraisal"> <i class="fas fa-edit ml-2 mr-2"></i></a> | <a title="Resend" data-bs-toggle="modal" data-bs-target="#resend"> <i class="fas fa-retweet ml-2 mr-2"></i></a></td>
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
					<h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body table-responsive p-0">
					<div class="card" id="viewkrabox">
						<div class="card-header">
							<div style="float:left;width:100%;">
								<h5 class="float-start"><b>Form - A (KRA)</b></h5>
							</div>
						</div>
						<div class="card-body table-responsive dd-flex align-items-center">
							<table  class="table table-pad">
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
										<td>45.5</td>
										<td>Logic 01</td>
										<td>Quarterly</td>
										<td>100</td>
									</tr>
									<tr>
										<td><i class="fas fa-plus-circle mr-2"></i><b>2.</b></td>
										<td>test </td>
										<td>twst</td>
										<td>Process</td>
										<td>Days</td>
										<td>45.5</td>
										<td>Logic 01</td>
										<td>Quarterly</td>
										<td>100</td>
									</tr>
									<tr>
										<td><i class="fas fa-plus-circle mr-2"></i><b>3.</b></td>
										<td>test </td>
										<td>twst</td>
										<td>Process</td>
										<td>Days</td>
										<td>45.5</td>
										<td>Logic 01</td>
										<td>Quarterly</td>
										<td>100</td>
									</tr>
									<tr>
										<td><i class="fas fa-plus-circle mr-2"></i><b>4.</b></td>
										<td>test </td>
										<td>twst</td>
										<td>Process</td>
										<td>Days</td>
										<td>45.5</td>
										<td>Logic 01</td>
										<td>Quarterly</td>
										<td>100</td>
									</tr>
									<tr>
										<td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
										<td>test </td>
										<td>twst</td>
										<td>Process</td>
										<td>Days</td>
										<td>45.5</td>
										<td>Logic 01</td>
										<td>Quarterly</td>
										<td>100</td>
									</tr>
									<tr><td><a class="effect-btn btn btn-success squer-btn sm-btn">Approval</a></td></tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card" id="editkrabox" style="display:none;">
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
										<td><b>1.</b></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td>
											<select>
												<option>Process</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Days</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>45.5</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Logic 01</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Quarterly</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<input style="width:50px;font-weight: bold;" type="text" >
										</td>
									</tr>
									<tr>
										<td><b>2.</b></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td>
											<select>
												<option>Process</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Days</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>45.5</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Logic 01</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Quarterly</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<input style="width:50px;font-weight: bold;" type="text" >
										</td>
									</tr>
									<tr>
										<td><b>3.</b></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td>
											<select>
												<option>Process</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Days</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>45.5</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Logic 01</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Quarterly</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<input style="width:50px;font-weight: bold;" type="text" >
										</td>
									</tr>
									<tr>
										<td><b>4.</b></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td>
											<select>
												<option>Process</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Days</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>45.5</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Logic 01</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Quarterly</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<input style="width:50px;font-weight: bold;" type="text" >
										</td>
									</tr>
									<tr>
										<td><b>5.</b></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td><input style="min-width: 300px;" type="text" ></td>
										<td>
											<select>
												<option>Process</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Days</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>45.5</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Logic 01</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<select>
												<option>Quarterly</option>
												<option>1</option>
												<option>1</option>
											</select>
										</td>
										<td>
											<input style="width:50px;font-weight: bold;" type="text" >
										</td>
									</tr>
									<tr><td><a class="effect-btn btn btn-success squer-btn sm-btn">Approval</a></td></tr>
								</tbody>
							</table>
						</div>							
					</div>
					<div class="card" id="revertbox" style="display:none;">
						<div class="card-header">
							<div style="float:left;width:100%;">
								<h5 class="float-start"><b>Revert</b></h5>
							</div>
						</div>
						<div class="card-body table-responsive align-items-center">
							<div class="form-group mr-2" >
								<label class="col-form-label">Revert Note</label>
								<textarea placeholder="Enter your revert note" class="form-control" ></textarea>
								<a class="effect-btn btn btn-success squer-btn sm-btn mt-2">Send</a>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a class="viewkrabtn">View<i class="fas fa-eye ml-2 mr-2"></i></a>
					<a class="editkrabtn">Edit<i class="fas fa-edit ml-2 mr-2"></i></a>
					<a class="revertkrabtn">Revert<i class="fas fa-retweet ml-2 mr-2"></i></a>
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
					<h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
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
					<h5 class="modal-title me-2" id="exampleModalCenterTitle3" style="font-size:13px;">
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
		
	
	<!--All achivement and feedback view -->
	<div class="modal fade show" id="viewappraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
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
															<th>Appraisar Rating</th>
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
		</tbody>
  </table>
  </div>
  </div>
									<div class="card">
										<div class="card-header">
											<div style="float:left;width:100%;">
												<h5 class="float-start"><b>Training Requirements</b></h5>
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
</div>
<div class="modal-footer">
	<a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>
<!-- All achivement and feedback edit -->
<div class="modal fade show" id="editAppraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">
  <div class="card">
										<div class="card-header">
											<div style="float:left;width:100%;">
												<h5 class="float-start"><b>Achievements</b></h5>
											</div>
										</div>
										<div class="card-body table-responsive align-items-center appraisal-view">
  <ol>
	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
	<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
	</ol>
	</div>
</div>
<div class="card">
 <div class="card-header">
											<div style="float:left;width:100%;">
												<h5 class="float-start"><b>Feedback</b></h5>
											</div>
										</div>
   <div class="card-body table-responsive align-items-center">
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
															<th>self Rating</th>
															<th>self Remarks</th>
															<th>App Rating</th>
															<th>App Score</th>
															<th>App Remarks</th>
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
															<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
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
															<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
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
															<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
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
															<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
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
															<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
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
																			<th>self Rating</th>
															<th>self Remarks</th>
															<th>App Rating</th>
															<th>App Score</th>
															<th>App Remarks</th>
														</tr>
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
																		<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
																		
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
																		<td> <a style="color:blue;" class="link" title="Click to target" data-bs-toggle="modal" data-bs-target="#targetbox" >100 Click</a></td>
															<td>85</td>
															<td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
															<td><input class="form-control" type="text" value="67"></td>
															<td>20.1</td>
															<td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
																	</tr>
																	</tbody>
																</table>
															</td>
														</tr>
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
												</tbody>
											</table>
										</div>
									</div>
	<div class="card">
										<div class="card-header">
											<div style="float:left;width:100%;">
												<h5 class="float-start"><b>Promotion Recommendation </b></h5>
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
				<td><select>
						<option>J4</option>
						<option>J5</option>
						<option>J6</option>
					</select></td>
				<td><select>
						<option>Business manager</option>
						<option>Zonal Manager</option>
						<option>1</option>
					</select></td>
				<td><input style="min-width: 300px;" type="text" ></td>
			</tr>
		</tbody>
  </table>
  </div>
  </div>
 <br>
 
   <div class="card">
										<div class="card-header">
											<div style="float:left;width:100%;">
												<h5 class="float-start"><b>Training Requirements </b></h5><br>
												<b>A) Soft Skills Training [Based on Behavioral parameter]</b>
											</div>
										</div>
  <div class="card-body table-responsive dd-flex align-items-center">
		
		<div class=" mr-2" id="">
			<label class="col-form-label"><b>Name of Training</b></label><br>
			<select class="">
						<option>Business Training</option>
						<option>Soft Skill</option>
						<option>1</option>
					</select>
		</div>
		<div class="">
			<label class="col-form-label"><b>Description</b></label>
			<input type="text" name="" style="width:300px;" class="form-control">
		</div>
		<a class="effect-btn btn btn-success squer-btn sm-btn mt-4 ml-2">Submit</a><br>
		<table class="table mt-2">
			<thead>
			<tr>
				<th>Sn</th>
				<th>Category</th>
				<th>Topic</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><b>1</b></td>
				<td><b>Business Skills</b></td>
				<td>Leadership Skills</td>
				<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
				<td><i class="fas fa-trash ml-2 mr-2"></i></td>
			</tr>
			<tr>
				<td><b>1</b></td>
				<td><b>Business Skills</b></td>
				<td>Leadership Skills</td>
				<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
				<td><i class="fas fa-trash ml-2 mr-2"></i></td>
			</tr>
		</tbody>
		</table>
	</div>
	</div>
	<div class="card">
										<div class="card-header">
											<div style="float:left;width:100%;">
												<b>B) Functional Skills [Job related]</b>
											</div>
										</div>
  <div class="card-body table-responsive dd-flex align-items-center">
		
		<div class=" mr-2" id="">
			<label class="col-form-label"><b>Name of Training</b></label><br>
			<select class="">
						<option>Business Training</option>
						<option>Soft Skill</option>
						<option>1</option>
					</select>
		</div>
		<div class="">
			<label class="col-form-label"><b>Description</b></label>
			<input type="text" name="" style="width:300px;" class="form-control">
		</div>
		<a class="effect-btn btn btn-success squer-btn sm-btn mt-4 ml-2">Submit</a><br>
		<table class="table mt-2">
			<thead>
			<tr>
				<th>Sn</th>
				<th>Category</th>
				<th>Topic</th>
				<th>Description</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><b>1</b></td>
				<td><b>Business Skills</b></td>
				<td>Leadership Skills</td>
				<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
				<td><i class="fas fa-trash ml-2 mr-2"></i></td>
			</tr>
			<tr>
				<td><b>1</b></td>
				<td><b>Business Skills</b></td>
				<td>Leadership Skills</td>
				<td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
				<td><i class="fas fa-trash ml-2 mr-2"></i></td>
			</tr>
		</tbody>
		</table>
	</div>
	</div>
	<div class="card">
		<div class="card-header">
			<div style="float:left;width:100%;">
				<b>Remaks</b>
			</div>
		</div>
		<div class="card-body table-responsive dd-flex align-items-center">
		<input class="form-control" Type="text" />
		</div>
	</div>
	
</div>
<div class="modal-footer">
<a class="effect-btn btn btn-success squer-btn sm-btn">Save as Draft</a>
<a class="effect-btn btn btn-success squer-btn sm-btn">Final Submit</a>
	<a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>

<!-- resubmit -->
<div class="modal fade show" id="resend" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
<div class="modal-content">
  <div class="modal-header">
  <h5 class="modal-title" id="exampleModalCenterTitle3">Resend Note</h5>
  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	<span aria-hidden="true">×</span>
  </button>
  </div>
  <div class="modal-body appraisal-view">
	<div class="form-group mr-2" id="">
		<label class="col-form-label">Resend Note</label>
		<textarea placeholder="Enter your resubmit note" class="form-control" ></textarea>
	</div>
  </div>
  <div class="modal-footer">
  <a class="effect-btn btn btn-success squer-btn sm-btn">Send</a>
	  <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
  </div>
</div>
</div>
</div>
<!-- target box popup  -->
<div class="modal fade show" id="targetbox" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5><br>
<p><b>Logic</b>: Logic 1 <b>KRA</b>: </p><br>
<p><b>Description</b>: There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</p>
<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body appraisal-view">
  <table class="table table-pad" id="mykrabox">
													<thead>
														<tr>
															<th>SN.</th>
															<th>Quarter</th>
															<th>Weightage</th>
															<th>Target</th>
															<th>Comments</th>
															<th>Self rating</th>
															<th>Rating details</th>
															<th>Score</th>
															<th>Reporting rating</th>
															<th>Reporting remarks</th>
															<th>Reporting score</th>
															<th>Action</th>
															
														</tr>
													</thead>
													<tbody>
														<tr>
															<td><b>1.</b></td>
															<td>Quarter 1</td>
															<td>7.5</td>
															<td>25</td>
															<td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
															
															<td>21</td>
															<td>test</td>
															<td>6.30</td>
															<td><input class="form-control" type="text" value="20"></td>
															<td><input class="form-control" style="min-width: 300px;" type="text" value="test for reporting"></td>
															<td><input class="form-control" type="text" value="6" ></td>
															<td> <a class="btn btn-success">Save</a></td>
														</tr>
														<tr>
															<td><b>1.</b></td>
															<td>Quarter 1</td>
															<td>7.5</td>
															<td>25</td>
															<td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
															
															<td>21</td>
															<td>test</td>
															<td>6.30</td>
															<td><input class="form-control" type="text" value="20"></td>
															<td><input class="form-control" style="min-width: 300px;" type="text" value="test for reporting"></td>
															<td><input class="form-control" type="text" value="6" ></td>
															<td><a class="btn btn-success">Save</a></td>
														</tr>
														<tr>
															<td><b>1.</b></td>
															<td>Quarter 1</td>
															<td>7.5</td>
															<td>25</td>
															<td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
															
															<td>21</td>
															<td>test</td>
															<td>6.30</td>
															<td><input class="form-control" type="text" value="20"></td>
															<td><input class="form-control" style="min-width: 300px;" type="text" value="test for reporting"></td>
															<td><input class="form-control" type="text" value="6" ></td>
															<td><a class="btn btn-success">Save</a></td>
														</tr>
														<tr>
															<td><b>1.</b></td>
															<td>Quarter 1</td>
															<td>7.5</td>
															<td>25</td>
															<td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
															
															<td>21</td>
															<td>test</td>
															<td>6.30</td>
															<td><input class="form-control" type="text" value="20"></td>
															<td><input class="form-control" style="min-width: 300px;" type="text" value="test for reporting"></td>
															<td><input class="form-control" type="text" value="6" ></td>
															<td><a class="btn btn-success">Save</a></td>
														</tr>
														<tr style="background-color:#f1f1f1;">
															<td></td>
															<td><b>Total</b></td>
															<td><b>30</b></td>
															<td><b>100</b></td>
															<td></td>
															<td><b>95.5</b></td>
															<td></td>
															<td><b>28.5</b></td>
															<td><b>90</b></td>
															<td></td>
															<td><b>27</b></td>
															<td></td>
															<td></td>
														</tr>
													</tbody>
												</table>
</div>
<div class="modal-footer">
<a class="effect-btn btn btn-success squer-btn sm-btn">Submit</a>
	<a class="effect-btn btn btn-success squer-btn sm-btn">Save</a>
	<a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
</div>
</div>
</div>
</div>
@include('employee.footer');
<script>
$(document).ready(function() {
	$('.editkrabtn').click(function() {
		$('#editkrabox').show();
		$('#viewkrabox').hide();
		$('#revertbox').hide();
	});
	$('.revertkrabtn').click(function() {
		$('#editkrabox').hide();
		$('#viewkrabox').hide();
		$('#revertbox').show();
	});
	$('.viewkrabtn').click(function() {
		$('#viewkrabox').show();
		$('#editkrabox').hide();
		$('#revertbox').hide();
	});
});
</script>