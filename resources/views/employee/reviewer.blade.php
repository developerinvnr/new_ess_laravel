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
                                    <li class="breadcrumb-link active">PMS - Reviewer </li>
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
						<a href="{{route('appraiser')}}" class="mb-0 sm-btn btn pms-btn" title="Appraiser" data-original-title="Appraiser">Appraiser</a>
						<a href="{{route('reviewer')}}" class="mb-0 sm-btn btn pms-btn-active" title="Reviewer" data-original-title="Reviewer">Reviewer</a>
						<a href="{{route('hod')}}" class="mb-0 sm-btn btn pms-btn" title="HOD" data-original-title="HOD">HOD</a>
						<a href="{{route('management')}}" class="mb-0 sm-btn btn pms-btn" title="Management" data-original-title="Management">Management</a>
					   </div>
					</div>
					
                <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
						<div class="mfh-machine-profile">
							
							<ul class="nav nav-tabs" id="myTab1" role="tablist">  
								<li class="nav-item">
									<a style="color: #8b8989;background-color:#D9D9D9;padding-top:10px !important;" class="nav-link pt-4 active" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
								</li>
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade active show" id="KraTab" role="tabpanel">
									<div class="row">
										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
											<div class="card">
												<div class="card-header" style="padding:0 !important;">
													<div class="float-end" style="margin-top:-40px;">
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
															<th>Reviewer</th>
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
															<td><span class="success"><b>Submitted</b></span></td>
															<td><span class="danger"><b>Draft</b></span></td>
															<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewKRA"><i class="fas fa-eye mr-2"></i></a>| <a title="Edit" data-bs-toggle="modal" data-bs-target="#editKRA"> <i class="fas fa-edit ml-2 mr-2"></i></a></td>
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
					</div>
                </div>
                
				<div class="ad-footer-btm">
					<p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
				</div>
        </div>
    </div>
    </div>
    
     <!--View KRA Modal-->
	 <div class="modal fade show" id="viewKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		  <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
		  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		  </div>
		  <div class="modal-body table-responsive">
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
							  </tbody>
						  </table>
		  </div>
		  <div class="modal-footer">
			<a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
		  </div>
		</div>
		</div>
	  </div>
	  <!--Edit KRA Modal-->
	  <div class="modal fade show" id="editKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
		  <div class="modal-header">
		  <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
		  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">×</span>
		  </button>
		  </div>
		  <div class="modal-body table-responsive">
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
															  </tbody>
														  </table>
		  </div>
		  <div class="modal-footer">
			  <a class="effect-btn btn btn-success squer-btn sm-btn">Submit</a>
			  <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
		  </div>
		</div>
		</div>
	  </div>
	
    @include('employee.footer');
