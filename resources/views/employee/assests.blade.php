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

					<!-- Success Message -->
					@if(session('success'))
						<div class="alert alert-success alert-dismissible fade show" role="alert">
							{{ session('success') }}
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif

					<!-- Error Message -->
					@if($errors->any())
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							@foreach ($errors->all() as $error)
								<p>{{ $error }}</p>
							@endforeach
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
					@endif

					<div class="mfh-machine-profile">
                     <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="assestTabs" role="tablist">
                        <li class="nav-item">
                           <a style="color: #0e0e0e;" id="assesttab" class="nav-link active"
                              data-bs-toggle="tab" href="#assestFormSection" role="tab"
                              aria-controls="assestFormSection" aria-selected="true">Assets  </a>
                        </li>
						
                        <li class="nav-item">
                           <a style="color: #0e0e0e;" id="assestform" class="nav-link"
                              data-bs-toggle="tab" href="#assestformSections" role="tab"
                              aria-controls="assestformSections" aria-selected="true">Assets Application form</a>
                        </li>
						<li class="nav-item">
                           <a style="color: #0e0e0e;" id="assestvehciledetails" class="nav-link"
                              data-bs-toggle="tab" href="#assestvehcile" role="tab"
                              aria-controls="assestvehcile" aria-selected="true">Vehicle information form</a>
                        </li>
                       

                     </ul>
                     <div class="tab-content">
                          
                        <!-- Query Form Section Tab -->
                        <div class="tab-pane fade show active" id="assestFormSection" role="tabpanel"
                           aria-labelledby="assesttab">
                          @if(Auth::user()->employeeAssetOffice->isNotEmpty())
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
												<th>Model Name</th>
												<th>Serial No</th>
												<th>Allocated</th>
												<th>Returned</th>
											</tr>
										</thead>
										<tbody>
											@foreach(Auth::user()->employeeAssetOffice as $asset)
												<tr>
	
													<td>{{ $loop->index + 1 }}</td>
													<td>{{ $asset->AComName }}</td>
													@php
															// Query to fetch AssetName based on AssetId
															$assetName = \DB::table('hrm_asset_name') // Table name
																			->where('AssetNId', $asset->AssetId) // Column name in hrm_asset_name
																			->value('AssetName'); // Field to retrieve
														@endphp

														<td>{{ $assetName ?? 'N/A' }}</td> <!-- Display AssetName -->
													<td>{{ $asset->AModelName }}</td>
													<td>{{ $asset->ASrn }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif
						@if(Auth::user()->employeeAssetReq->isNotEmpty())
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
											@foreach(Auth::user()->employeeAssetReq as $index => $request)
												<tr>
													<td>{{ $index + 1 }}</td>
													<td>{{ \Carbon\Carbon::parse($request->ReqDate)->format('d M Y') }}
													</td>
													@php
														// Query to fetch AssetName based on AssetId
														$assetName = \DB::table('hrm_asset_name') // Table name
																		->where('AssetNId', $request->AssetId) // Column name in hrm_asset_name
																		->value('AssetName'); // Field to retrieve
																		print_r($assetName);
													@endphp

													<td>{{ $assetName ?? 'N/A' }}</td> <!-- Display AssetName -->
													<td>{{ number_format($request->Price, 2) }}</td>
													<td>{{ number_format($request->ReqAmt, 2) }}</td>
													<td>{{ number_format($request->ApprovalAmt, 2) }}</td>
													<td>
														@if($request->bill_copy)
															<!-- Check if it's a PDF -->
															@if(str_ends_with($request->bill_copy, '.pdf'))
																<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																	data-file-url="{{ asset('storage/' . $request->bill_copy) }}"
																	data-file-type="bill">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																	data-file-url="{{ asset('storage/' . $request->bill_copy) }}"
																	data-file-type="bill">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@endif
														@else
															<span>No Bill</span>
														@endif
													</td>
													<td>
														@if($request->asset_copy)
															<!-- Check if it's a PDF -->
															@if(str_ends_with($request->asset_copy, '.pdf'))
																<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																	data-file-url="{{ asset('storage/' . $request->asset_copy) }}"
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																	data-file-url="{{ asset('storage/' . $request->asset_copy) }}"
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@endif
														@else
															<span>No Asset</span>
														@endif
													</td>

													<td>{{ $request->IdentityRemark }}</td>
													<td>
														<!-- View button to show approval status -->
														<button type="button" style="padding:6px 13px;font-size: 11px;"
																class="btn-outline success-outline sm-btn"
																data-request-id="{{ $request->AssetEmpReqId }}"
																onclick="toggleApprovalView({{ $request->AssetEmpReqId }})">
															View
														</button>
													</td>
													</tr>

																		<tr id="approval-row-{{ $request->AssetEmpReqId }}" style="display:none;">
																			<td colspan="5">
																				<!-- Display approval sections horizontally -->
																				<div class="approval-status" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">

																					<!-- HOD Approval Section -->
																					<div class="approval-item" style="text-align: center; position: relative; width: 30%;">
																						<!-- Circle for HOD -->
																						<span @if($request->HODApprovalStatus == 1)
																								style="background-color: #0d9137;" 
																							@else
																								style="background-color: #dba62f;" 
																							@endif
																							class="exp-round" 
																							style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;"></span>
																						<div class="approval-details" style="padding-top: 10px;">
																							<h6>@if($request->HODApprovalStatus == 1) Level 1 @else Pending HOD Approval @endif</h6>
																							<p>HOD/Reporting Section</p>
																							<p>{{ $request->HODSubDate ?? 'Date Not Available' }}</p>
																							<p>{{ $request->HODRemark ?? 'No Remarks' }}</p>
																						</div>
																						<!-- Connecting Line -->
																						<div class="line" style="position: absolute; top: 50%; left: 100%; width: 50px; height: 2px; background-color: #ccc;"></div>
																					</div>

																					<!-- IT Approval Section -->
																					<div class="approval-item" style="text-align: center; position: relative; width: 30%;">
																						<!-- Circle for IT -->
																						<span @if($request->ITApprovalStatus == 1)
																								style="background-color: #0d9137;" 
																							@else
																								style="background-color: #dba62f;" 
																							@endif
																							class="exp-round" 
																							style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;"></span>
																						<div class="approval-details" style="padding-top: 10px;">
																							<h6>@if($request->ITApprovalStatus == 1) Level 2 @else Pending IT Approval @endif</h6>
																							<p>IT Section</p>
																							<p>{{ $request->ITSubDate ?? 'Date Not Available' }}</p>
																							<p>{{ $request->ITRemark ?? 'No Remarks' }}</p>
																						</div>
																						<!-- Connecting Line -->
																						<div class="line" style="position: absolute; top: 50%; left: 100%; width: 50px; height: 2px; background-color: #ccc;"></div>
																					</div>

																					<!-- Accounts Approval Section -->
																					<div class="approval-item" style="text-align: center; position: relative; width: 30%;">
																						<!-- Circle for Accounts -->
																						<span @if($request->AccPayStatus == 1)
																								style="background-color: #0d9137;" 
																							@else
																								style="background-color: #dba62f;" 
																							@endif
																							class="exp-round" 
																							style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;"></span>
																						<div class="approval-details" style="padding-top: 10px;">
																							<h6>@if($request->AccPayStatus == 1) Level 3 @else Pending Accounts Approval @endif</h6>
																							<p>Accounts Section</p>
																							<p>{{ $request->AccSubDate ?? 'Date Not Available' }}</p>
																							<p>{{ $request->AccRemark ?? 'No Remarks' }}</p>
																						</div>
																					</div>

																				</div>
																			</td>
																		</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif

						@if($assets_request->isNotEmpty())
							<div class="card chart-card">
								<div class="card-header">
									<h4 class="has-btn">Approval Status</h4>
								</div>
								<div class="card-body table-responsive">
									<table class="table">
										<thead class="thead-light" style="background-color:#f1f1f1;">
											<tr>
												<th>No.</th>
												<th>EmployeeID</th>
												<th>Asset ID</th>
												<th>ReqAmt</th>
												<th>Req Date</th>
												<th>ReqAmtPerMonth</th>
												<th>Model Name</th>
												<th>Company Name</th>
												<th>Dealer Number</th>
												<th>Approval Status</th>
												<th>Remark</th>
												<th>Approval Date</th>
												<th>Bill Copy</th>
												<th>Assets Copy</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($assets_request as $index => $request)
												<tr>
													<td>{{ $index + 1 }}</td>
													<td>{{ $request->employee_name }}</td>
													<td>{{ $request->AssetNId }}</td>
													<td>{{ $request->ReqAmt }}</td>
													<td>{{ $request->ReqDate }}</td>
													<td>{{ $request->ReqAmtPerMonth }}</td>
													<td>{{ $request->ModelName }}</td>
													<td>{{ $request->ComName }}</td>
													<td>{{ $request->DealerContNo }}</td>

													<!-- Conditional display based on the authenticated user's role -->
													@if(Auth::user()->EmployeeID == $request->HodId || Auth::user()->EmployeeID == $request->ReportingId)
														<!-- If the authenticated user is the HOD -->
														@if($request->HODApprovalStatus == 1)
															<td>Approved</td>
														@elseif($request->HODApprovalStatus == 0)
															<td>Rejected</td>
														@else
															<td>N/A</td>
														@endif
														<td>{{ $request->HODRemark }}</td>
														<td>{{ $request->HODSubDate }}</td>

													@elseif(Auth::user()->EmployeeID == $request->ITId)
														<!-- If the authenticated user is from IT -->
														@if($request->ITApprovalStatus == 1)
															<td>Approved</td>
														@elseif($request->ITApprovalStatus == 0)
															<td>Rejected</td>
														@else
															<td>N/A</td>
														@endif
														<td>{{ $request->ITRemark }}</td>
														<td>{{ $request->ITSubDate }}</td>

													@elseif(Auth::user()->EmployeeID == $request->AccId)
														<!-- If the authenticated user is from Accounts -->
														@if($request->AccPayStatus == 1)
															<td>Approved</td>
														@elseif($request->AccPayStatus == 0)
															<td>Rejected</td>
														@else
															<td>N/A</td>
														@endif
														<td>{{ $request->AccRemark }}</td>
														<td>{{ $request->AccSubDate }}</td>

													@else
														<!-- In case no match, display default or empty fields -->
														<td>N/A</td>
														<td>N/A</td>
														<td>N/A</td>
													@endif

													<td>
														@if($request->bill_copy)
															<!-- Check if it's a PDF -->
															@if(str_ends_with($request->bill_copy, '.pdf'))
																<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																	data-file-url="{{ asset('storage/' . $request->bill_copy) }}"
																	data-file-type="bill">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																	data-file-url="{{ asset('storage/' . $request->bill_copy) }}"
																	data-file-type="bill">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@endif
														@else
															<span>No Bill</span>
														@endif
													</td>
													<td>
														@if($request->asset_copy)
															<!-- Check if it's a PDF -->
															@if(str_ends_with($request->asset_copy, '.pdf'))
																<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																	data-file-url="{{ asset('storage/' . $request->asset_copy) }}"
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																	data-file-url="{{ asset('storage/' . $request->asset_copy) }}"
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@endif
														@else
															<span>No Asset</span>
														@endif
													</td>

													<td>
														<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
															data-bs-target="#approvalModal"
															data-request-id="{{ $request->AssetEmpReqId }}"
															data-employee-id="{{ $request->EmployeeID }}"
															data-employee-name="{{ $request->employee_name }}"
															data-asset-id="{{ $request->AssetNId }}"
															data-req-amt="{{ $request->ReqAmt }}"
															data-req-date="{{ $request->ReqDate }}"
															data-req-amt-per-month="{{ $request->ReqAmtPerMonth }}"
															data-model-name="{{ $request->ModelName }}"
															data-company-name="{{ $request->ComName }}"
															data-dealer-number="{{ $request->DealerContNo }}">
															Action
														</button>

													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif
						


                        </div>
                        <!-- Employee Specific Query Section Tab -->
                        <div class="tab-pane fade" id="assestformSections" role="tabpanel"
                           aria-labelledby="assestform">
                           

                           <div class="card">
							<div class="card-header pb-0">
								<h4 class="card-title">My Asset Request</h4>
							</div>
							<div class="card-content">
								<div class="card-body">

									<div id="messageDiv"></div>
									<!-- Here the success/error messages will be displayed -->
									<form id="assetRequestForm" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
												<p>CC to your reporting manager & HOD</p>
											</div>

											<!-- Asset Name -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group s-opt">
													<label for="asset" class="col-form-label"><b>Select Asset Name <span
																class="danger">*</span></b></label>
													<select class="select2 form-control select-opt" id="asset"
														name="asset" required>
														<option value="" disabled selected>Select Asset Name</option>
														@foreach ($assets as $asset)
															<option value="{{ $asset->AssetNId }}"
																data-limit="{{ $asset->AssetLimit }}"
																data-type="{{ $asset->AssetName }}">
																{{ $asset->AssetName }}
															</option>
														@endforeach
													</select>
													<span class="sel_arrow">
														<i class="fa fa-angle-down"></i>
													</span>
													<div class="invalid-feedback">Please select an asset name.</div>
												</div>
											</div>

											<!-- Maximum Limit -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="max_limit">
												<div class="form-group">
													<label for="maximum_limit" class="col-form-label"><b>Maximum Limit
															<span class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter maximum limit" id="maximum_limit"
														name="maximum_limit" readonly required>
													<div class="invalid-feedback">Maximum limit is required.</div>
												</div>
											</div>

											<!-- vehcile price -->
											
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehcile_price_id"
												style="display:none;">
												<div class="form-group">
													<label for="vehcile_price" class="col-form-label"><b>Vehicle price
															<span class="danger">*</span></b></label>
													<input class="form-control" type="number"
														placeholder="Enter vehicle brand" id="vehcile_price"
														name="vehcile_price">
													<div class="invalid-feedback">Vehicle brand is required.</div>
												</div>
											</div>

											<!-- Model Name -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="model_name" class="col-form-label"><b>Model Name <span
																class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter model name" id="model_name" name="model_name"
														required>
													<div class="invalid-feedback">Model name is required.</div>
												</div>
											</div>

											<!-- Model Number -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="model_no" class="col-form-label"><b>Model Number <span
																class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter model number" id="model_no" name="model_no"
														required>
													<div class="invalid-feedback">Model number is required.</div>
												</div>
											</div>
											
											<!-- Vehicle Name -->
											<!-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" id="vehicle_name"
												style="display:none;">
												<div class="form-group">
													<label for="vehicle_name" class="col-form-label"><b>Vehicle Brand Name
															<span class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter vehicle name" id="vehicle_name"
														name="vehicle_name">
													<div class="invalid-feedback">Vehicle brand name is required.</div>
												</div>
											</div> -->
											<!-- Vehicle Brand -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_brand"
												style="display:none;">
												<div class="form-group">
													<label for="vehicle_brand" class="col-form-label"><b>Vehicle Brand
															<span class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter vehicle brand" id="vehicle_brand"
														name="vehicle_brand">
													<div class="invalid-feedback">Vehicle brand is required.</div>
												</div>
											</div>

											<!-- Company Name -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="company_name_id">
												<div class="form-group">
													<label for="company_name" class="col-form-label"><b>Company Name
															<span class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter company name" id="company_name"
														name="company_name" required>
													<div class="invalid-feedback">Company name is required.</div>
												</div>
											</div>

											<!-- Purchase Date -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="purchase_date" class="col-form-label"><b>Purchase Date
															<span class="danger">*</span></b></label>
													<input class="form-control" type="date" placeholder="Purchase Date"
														id="purchase_date" name="purchase_date" required>
													<div class="invalid-feedback">Purchase date is required.</div>
												</div>
											</div>

											<!-- Dealer Name -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="dealer_name" class="col-form-label"><b>Dealer Name <span
																class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter dealer name" id="dealer_name"
														name="dealer_name" required>
													<div class="invalid-feedback">Dealer name is required.</div>
												</div>
											</div>

											<!-- Dealer Contact -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="dealer_contact" class="col-form-label"><b>Dealer Contact
															<span class="danger">*</span></b></label>
													<input class="form-control" type="number"
														placeholder="Enter dealer contact number" id="dealer_contact"
														name="dealer_contact" required pattern="^\d{10}$|^\d{12}$"
														title="Please enter a valid 10 or 12 digit phone number."
														oninput="validatePhoneNumber()">
													<small id="phoneError" class="form-text text-danger"
														style="display:none;">Please enter a valid 10 or 12 digit phone
														number.</small>
												</div>
											</div>

											<!-- Price -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="price" class="col-form-label"><b>Price <span
																class="danger">*</span></b></label>
													<input class="form-control" type="number" placeholder="Enter price"
														id="price" name="price" required>
													<div class="invalid-feedback">Price is required.</div>
												</div>
											</div>

											<!-- Bill Number -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="bill_number" class="col-form-label"><b>Bill Number <span
																class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter bill number" id="bill_number"
														name="bill_number" required>
													<div class="invalid-feedback">Bill number is required.</div>
												</div>
											</div>

											<!-- Request Amount -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="request_amont_id">
												<div class="form-group">
													<label for="request_amount" class="col-form-label"><b>Request Amount
															<span class="danger">*</span></b></label>
													<input class="form-control" type="number"
														placeholder="Enter request amount" id="request_amount"
														name="request_amount" required>
													<div class="invalid-feedback">Request amount is required.</div>
												</div>
											</div>

											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="imei_field">
												<div class="form-group">
													<label for="iemi_no" class="col-form-label"><b>IMEI No.: <span
																class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter IMEI number" id="iemi_no" name="iemi_no"
														required>
													<div class="invalid-feedback">IMEI number is required.</div>
												</div>
											</div>


											<!-- Bill Copy -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="bill_copy" class="col-form-label"><b>Bill Copy <span
																class="danger">*</span></b></label>
													<input class="form-control" id="bill_copy" name="bill_copy"
														type="file" required />
													<div class="invalid-feedback">Bill copy is required.</div>
												</div>
											</div>

											<!-- Asset Copy -->
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" id="asset_id">
												<div class="form-group">
													<label for="asset_copy" class="col-form-label"><b>Asset Copy <span
																class="danger">*</span></b></label>
													<input class="form-control" id="asset_copy" name="asset_copy"
														type="file" required />
													<div class="invalid-feedback">Asset copy is required.</div>
												</div>
											</div>
											<!-- Vehicle Photo (hidden by default) -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12"
												id="vehicle_photo_field" style="display:none;">
												<div class="form-group">
													<label for="vehicle_photo" class="col-form-label"><b>Vehicle Photo
															<span class="danger">*</span></b></label>
													<input class="form-control" id="vehicle_photo" name="vehicle_photo"
														type="file" accept="image/*" required>
													<div class="invalid-feedback">Vehicle photo is required.</div>
												</div>
											</div>



											

											<!-- Fuel Type -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_fuel"
												style="display:none;">
												<div class="form-group">
													<label for="fuel_type" class="col-form-label"><b>Fuel Type <span
																class="danger">*</span></b></label>
													<select class="form-control" id="fuel_type" name="fuel_type"
														required>
														<option value="" disabled selected>Select Fuel Type</option>
														<option value="petrol">Petrol</option>
														<option value="diesel">Diesel</option>
														<option value="electric">Electric</option>
														<option value="cng">CNG</option>

													</select>
													<div class="invalid-feedback">Fuel type is required.</div>
												</div>
											</div>

											<!-- Registration Number -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regno"
												style="display:none;">
												<div class="form-group">
													<label for="registration_number"
														class="col-form-label"><b>Registration Number <span
																class="danger">*</span></b></label>
													<input class="form-control" type="text"
														placeholder="Enter registration number" id="registration_number"
														name="registration_number">
													<div class="invalid-feedback">Registration number is required.</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regdate"
												style="display:none;">
												<div class="form-group">
													<label for="registration_date"
														class="col-form-label"><b>Registration Date <span
																class="danger">*</span></b></label>
													<input class="form-control" type="date"
														placeholder="Enter registration number" id="registration_date"
														name="registration_date">
													<div class="invalid-feedback">Registration number is required.</div>
												</div>
											</div>

											<!-- DL Copy -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_dl"
												style="display:none;">
												<div class="form-group">
													<label for="dl_copy" class="col-form-label"><b>DL Copy <span
																class="danger">*</span></b></label>
													<input class="form-control" id="dl_copy" name="dl_copy" type="file"
														required>
													<div class="invalid-feedback">DL copy is required.</div>
												</div>
											</div>

											<!-- RC Copy -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_rl"
												style="display:none;">
												<div class="form-group">
													<label for="rc_copy" class="col-form-label"><b>RC Copy <span
																class="danger">*</span></b></label>
													<input class="form-control" id="rc_copy" name="rc_copy" type="file"
														required>
													<div class="invalid-feedback">RC copy is required.</div>
												</div>
											</div>

											<!-- Insurance Copy -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_ins"
												style="display:none;">
												<div class="form-group">
													<label for="insurance_copy" class="col-form-label"><b>Insurance Copy
															<span class="danger">*</span></b></label>
													<input class="form-control" id="insurance_copy"
														name="insurance_copy" type="file" required>
													<div class="invalid-feedback">Insurance copy is required.</div>
												</div>
											</div>

											<!-- Odometer Reading -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_odo"
												style="display:none;">
												<div class="form-group">
													<label for="odometer_reading" class="col-form-label"><b>1st Odometer
															Reading image <span class="danger">*</span></b></label>
													<input class="form-control" type="file"
														placeholder="Enter odometer reading" id="odometer_reading"
														name="odometer_reading">
													<div class="invalid-feedback">Odometer reading is required.</div>
												</div>
											</div>
											<!-- Odometer Reading current -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_odo_current"
												style="display:none;">
												<div class="form-group">
													<label for="currentodometer_reading" class="col-form-label"><b>Current Odometer
															Reading  <span class="danger">*</span></b></label>
													<input class="form-control" type="number"
														placeholder="Enter odometer reading" id="currentodometer_reading"
														name="currentodometer_reading">
													<div class="invalid-feedback">Odometer reading is required.</div>
												</div>
											</div>

											<!-- Ownership -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_owner"
												style="display:none;">
												<div class="form-group">
													<label for="ownership" class="col-form-label"><b>Ownership <span
																class="danger">*</span></b></label>
													<select class="form-control" id="ownership" name="ownership"
														>
														<option value="" disabled selected>Select Ownership</option>
														<option value="1">1st</option>
														<option value="2">2nd</option>
														<option value="3">3rd</option>
													</select>
													<div class="invalid-feedback">Ownership is required.</div>
												</div>
											</div>

											<!-- Remarks -->
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group">
													<label for="remarks" class="col-form-label"><b>Remarks</b></label>
													<textarea class="form-control" id="remarks" name="remarks" rows="4"
														placeholder="Enter any remarks"></textarea>
													<div class="invalid-feedback">Remarks are optional.</div>
												</div>
											</div>

											<!-- Form Actions -->
											<div class="form-group mb-0">
												<button class="btn btn-primary" type="reset">Reset</button>
												<button class="btn btn-success" type="submit">Submit</button>
											</div>
										</div>
									</form>

								</div>
							</div>
						</div>
                        </div>

						 <!-- Employee Specific Query Section Tab -->
						 <div class="tab-pane fade" id="assestvehcile" role="tabpanel"
                           aria-labelledby="assestvehciledetails">
                           

                           <div class="card">
							<div class="card-header pb-0">
								<h4 class="card-title">My vehcile Details</h4>
							</div>
							<div class="card-content">
								<div class="card-body">

									<div id="messageDiv"></div>
									<!-- Here the success/error messages will be displayed -->
									<form id="assetRequestFormVehcile" method="POST" enctype="multipart/form-data">
										@csrf
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
												<p>CC to your reporting manager & HOD</p>
											</div>

											<!-- Vehicle Type Dropdown -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="vehicle_typenew" class="col-form-label"><b>Select Vehicle Type <span class="danger">*</span></b></label>
													<select class="form-control" id="vehicle_type" name="vehicle_typenew" required>
														<option value="" disabled selected>Select Vehicle Type</option>
														<option value="2-wheeler" data-name="2-Wheeler" data-id="2w">2-Wheeler</option>
														<option value="4-wheeler" data-name="4-Wheeler" data-id="4w">4-Wheeler</option>
													</select>
												</div>
											</div>


											<!-- Model Name -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="model_name" class="col-form-label"><b>Model Name <span class="danger">*</span></b></label>
													<input class="form-control" type="text" placeholder="Enter model name" id="model_name" name="model_name" required>
													<div class="invalid-feedback">Model name is required.</div>
												</div>
											</div>
											
											<!-- Model Name -->
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
												<div class="form-group">
													<label for="model_no" class="col-form-label"><b>Model No <span class="danger">*</span></b></label>
													<input class="form-control" type="text" placeholder="Enter model name" id="model_no" name="model_no" required>
													<div class="invalid-feedback">Model name is required.</div>
												</div>
											</div>
											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																					<div class="form-group">
																						<label for="vehicle_brand" class="col-form-label"><b>Vehicle Brand
																								<span class="danger">*</span></b></label>
																						<input class="form-control" type="text"
																							placeholder="Enter vehicle brand" id="vehicle_brand"
																							name="vehicle_brand">
																						<div class="invalid-feedback">Vehicle brand is required.</div>
																					</div>
																				</div>

											
																				<!-- Dealer Name -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="dealer_name" class="col-form-label"><b>Dealer Name <span
																									class="danger">*</span></b></label>
																						<input class="form-control" type="text"
																							placeholder="Enter dealer name" id="dealer_name"
																							name="dealer_name" required>
																						<div class="invalid-feedback">Dealer name is required.</div>
																					</div>
																				</div>

																				<!-- Dealer Contact -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="dealer_contact" class="col-form-label"><b>Dealer Contact
																								<span class="danger">*</span></b></label>
																						<input class="form-control" type="number"
																							placeholder="Enter dealer contact number" id="dealer_contact"
																							name="dealer_contact" required pattern="^\d{10}$|^\d{12}$"
																							title="Please enter a valid 10 or 12 digit phone number."
																							oninput="validatePhoneNumber()">
																						<small id="phoneError" class="form-text text-danger"
																							style="display:none;">Please enter a valid 10 or 12 digit phone
																							number.</small>
																					</div>
																				</div>
																	<!-- Price -->
																		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="price" class="col-form-label"><b>Price <span
																									class="danger">*</span></b></label>
																						<input class="form-control" type="number" placeholder="Enter price"
																							id="price" name="price" required>
																						<div class="invalid-feedback">Price is required.</div>
																					</div>
																				</div>
																	<!-- Bill Number -->
																			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="bill_number" class="col-form-label"><b>Bill Number <span
																									class="danger">*</span></b></label>
																						<input class="form-control" type="text"
																							placeholder="Enter bill number" id="bill_number"
																							name="bill_number" required>
																						<div class="invalid-feedback">Bill number is required.</div>
																					</div>
																				</div>

																			<!-- Vehicle Brand -->
																			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																				<div class="form-group">
																					<label for="vehicle_brandnew" class="col-form-label"><b>Vehicle Brand <span class="danger">*</span></b></label>
																					<input class="form-control" type="text" placeholder="Enter vehicle brand" id="vehicle_brandnew" name="vehicle_brandnew" required>
																					<div class="invalid-feedback">Vehicle brand is required.</div>
																				</div>
																			</div>
																		<!-- Bill Copy -->
																		<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																											<div class="form-group">
																												<label for="bill_copy" class="col-form-label"><b>Bill Copy <span
																															class="danger">*</span></b></label>
																												<input class="form-control" id="bill_copy" name="bill_copy"
																													type="file" required />
																												<div class="invalid-feedback">Bill copy is required.</div>
																											</div>
																										</div>

																				<!-- Vehicle Photo (hidden by default) -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																					<div class="form-group">
																						<label for="vehicle_photonew" class="col-form-label"><b>Vehicle Photo <span class="danger">*</span></b></label>
																						<input class="form-control" id="vehicle_photo" name="vehicle_photonew" type="file" accept="image/*" required>
																						<div class="invalid-feedback">Vehicle photo is required.</div>
																					</div>
																				</div>

																				<!-- Fuel Type (conditional) -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																					<div class="form-group">
																						<label for="fuel_typenew" class="col-form-label"><b>Fuel Type <span class="danger">*</span></b></label>
																						<select class="form-control" id="fuel_typenew" name="fuel_typenew" required>
																							<option value="" disabled selected>Select Fuel Type</option>
																							<option value="petrol">Petrol</option>
																							<option value="diesel">Diesel</option>
																							<option value="electric">Electric</option>
																							<option value="cng">CNG</option>
																						</select>
																						<div class="invalid-feedback">Fuel type is required.</div>
																					</div>
																				</div>
											
																				<!-- Registration Number -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regno"
																					>
																					<div class="form-group">
																						<label for="registration_number"
																							class="col-form-label"><b>Registration Number <span
																									class="danger">*</span></b></label>
																						<input class="form-control" type="text"
																							placeholder="Enter registration number" id="registration_number"
																							name="registration_number">
																						<div class="invalid-feedback">Registration number is required.</div>
																					</div>
																				</div>
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_regdate"
																					>
																					<div class="form-group">
																						<label for="registration_date"
																							class="col-form-label"><b>Registration Date <span
																									class="danger">*</span></b></label>
																						<input class="form-control" type="date"
																							placeholder="Enter registration number" id="registration_date"
																							name="registration_date">
																						<div class="invalid-feedback">Registration number is required.</div>
																					</div>
																				</div>

																				<!-- DL Copy -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_dl"
																					>
																					<div class="form-group">
																						<label for="dl_copy" class="col-form-label"><b>DL Copy <span
																									class="danger">*</span></b></label>
																						<input class="form-control" id="dl_copy" name="dl_copy" type="file"
																							required>
																						<div class="invalid-feedback">DL copy is required.</div>
																					</div>
																				</div>

																				<!-- RC Copy -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_rl"
																					>
																					<div class="form-group">
																						<label for="rc_copy" class="col-form-label"><b>RC Copy <span
																									class="danger">*</span></b></label>
																						<input class="form-control" id="rc_copy" name="rc_copy" type="file"
																							required>
																						<div class="invalid-feedback">RC copy is required.</div>
																					</div>
																				</div>

																				<!-- Insurance Copy -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_ins"
																					>
																					<div class="form-group">
																						<label for="insurance_copy" class="col-form-label"><b>Insurance Copy
																								<span class="danger">*</span></b></label>
																						<input class="form-control" id="insurance_copy"
																							name="insurance_copy" type="file" required>
																						<div class="invalid-feedback">Insurance copy is required.</div>
																					</div>
																				</div>

																			<!-- Ownership -->
																			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																				<div class="form-group">
																					<label for="ownership" class="col-form-label"><b>Ownership <span class="danger">*</span></b></label>
																					<select class="form-control" id="ownershipnew" name="ownershipnew" required>
																						<option value="" disabled selected>Select Ownership</option>
																						<option value="1">1st</option>
																						<option value="2">2nd</option>
																						<option value="3">3rd</option>
																					</select>
																					<div class="invalid-feedback">Ownership is required.</div>
																				</div>
																			</div>

																			<!-- Remarks -->
																			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
																				<div class="form-group">
																					<label for="remarksnew" class="col-form-label"><b>Remarks</b></label>
																					<textarea class="form-control" id="remarksnew" name="remarksnew" rows="4" placeholder="Enter any remarks"></textarea>
																					<div class="invalid-feedback">Remarks are optional.</div>
																				</div>
																			</div>

																			<!-- Form Actions -->
																			<div class="form-group mb-0">
																				<button class="btn btn-primary" type="reset">Reset</button>
																				<button class="btn btn-success" type="submit">Submit</button>
																			</div>
										</div>
									</form>



								</div>
								@if(Auth::user()->employeeAssetvehcileReq->isNotEmpty())
    <div class="card chart-card">
        <div class="card-header">
            <h4 class="has-btn">Vehcile Details</h4>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead class="thead-light" style="background-color:#f1f1f1;">
                    <tr>
                 
                        <!-- Additional columns for full details -->
						 <th>Sno</th>
                        <th>Brand</th>
                        <th>Model Name</th>
                        <th>Model No</th>
                        <th>Dealer Name</th>
                        <th>Dealer Contact</th>
                        <th>Purchase Date</th>
                        <th>Price</th>
                        <th>Registration No</th>
                        <th>Registration Date</th>
                        <th>Bill No</th>
                        <th>Invoice</th>
                        <th>Fuel Type</th>
                        <th>Ownership</th>
                        <th>Vehicle Image</th>
                        <th>RC File</th>
                        <th>Insurance</th>
                        <th>Remark</th>
                        <th>HR Approval</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach(Auth::user()->employeeAssetvehcileReq as $index => $request)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            
                            <!-- Additional details displayed here -->
                            <td>{{ $request->brand ?? 'N/A' }}</td>
                            <td>{{ $request->model_name ?? 'N/A' }}</td>
                            <td>{{ $request->model_no ?? 'N/A' }}</td>
                            <td>{{ $request->dealer_name ?? 'N/A' }}</td>
                            <td>{{ $request->dealer_contact ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->purchase_date)->format('d M Y') ?? 'N/A' }}</td>
                            <td>{{ number_format($request->price, 2) ?? 'N/A' }}</td>
                            <td>{{ $request->registration_no ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($request->registration_date)->format('d M Y') ?? 'N/A' }}</td>
                            <td>{{ $request->bill_no ?? 'N/A' }}</td>
                            <td>{{ $request->invoice ?? 'N/A' }}</td>
                            <td>{{ $request->fuel_type ?? 'N/A' }}</td>
                            <td>{{ $request->ownership ?? 'N/A' }}</td>
                            <td>
                              
                            </td>
                          

                            <td>{{ $request->current_odo_meter ?? 'N/A' }}</td>
                            <td>{{ $request->odo_meter ?? 'N/A' }}</td>
                            <td>{{ $request->remark ?? 'N/A' }}</td>

													<td>{{ $request->hr_approval ? 'Approved' : 'Pending' }}</td>
													<td>
													<button class="btn btn-primary edit-btn" 
															data-id="{{ $request->AssetEmpReqId }}" 
															data-brand="{{ $request->brand }}" 
															data-model-name="{{ $request->model_name }}" 
															data-model-no="{{ $request->model_no }}" 
															data-dealer-name="{{ $request->dealer_name }}" 
															data-dealer-contact="{{ $request->dealer_contact }}" 
															data-purchase-date="{{ $request->purchase_date }}" 
															data-price="{{ $request->price }}" 
															data-registration-no="{{ $request->registration_no }}" 
															data-registration-date="{{ $request->registration_date }}" 
															data-bill-no="{{ $request->bill_no }}" 
															data-invoice="{{ $request->invoice }}" 
															data-fuel-type="{{ $request->fuel_type }}" 
															data-ownership="{{ $request->ownership }}" 
															data-current-odo="{{ $request->current_odo_meter }}" 
															data-odo="{{ $request->odo_meter }}" 
															data-remark="{{ $request->remark }}">
														Edit
													</button>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						@endif

							</div>
						</div>
                        </div>

                     </div>
                  </div>

					
				</div>
				<!-- Revanue Status Start -->
				@include('employee.footerbottom')
			</div>
		</div>
	</div>
	<!-- assest view modal  -->
	<div class="modal fade show" id="assetdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
		style="display: none;" aria-modal="true" role="dialog">
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
						<div class="col-md-6">
							<p class="mb-2"><b>Request Date:</b> <span id="modalRequestDate"></span></p>
							<p class="mb-2"><b>Type Of Asset:</b> <span id="modalAssetType"></span></p>
							<p class="mb-2"><b>Balance Amount:</b> <span id="modalPrice"></span></p>
						</div>
						<div class="col-md-6">
							<p class="mb-2"><b>Request Amount:</b> <span id="modalReqAmt"></span></p>
							<p class="mb-2"><b>Approval Amount:</b> <span id="modalApprovalAmt"></span></p>
						</div>
						<div class="col-md-12 mb-2">
							<p style="border:1px solid #ddd;"></p>
						</div>
						<!-- <div class="col-md-6">
							<p class="mb-2"><b>Copy Of Bill</b></p>
							<img style="width:250px;" id="modalBillCopy" />
						</div>
						<div class="col-md-6">
							<p class="mb-2"><b>Copy Of Asset</b></p>
							<img style="width:250px;" id="modalAssetCopy" />
						</div> -->
						<div class="col-md-12">
							<p><b>Details:</b> <span id="modalIdentityRemark"></span></p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
						data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- approval modal  -->
	<div class="modal fade" id="approvalModal" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="approvalModalLabel">Approval Status</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div id="approvalMessage" class="alert" style="display: none;"></div>

					<!-- Form to approve or reject -->
					<form action="{{ route('approve.request') }}" method="POST" id="approvalForm">
						@csrf
						<input type="hidden" name="request_id" id="request_id">
						<input type="hidden" name="employee_id" id="employee_id">

						<div class="mb-3">
							<label for="employee_name" class="form-label">Employee Name</label>
							<input type="text" class="form-control" id="employee_name" readonly>
						</div>

						<div class="mb-3">
							<label for="asset_id" class="form-label">Asset ID</label>
							<input type="text" class="form-control" id="asset_id" readonly>
						</div>

						<div class="mb-3">
							<label for="req_amt" class="form-label">Request Amount</label>
							<input type="text" class="form-control" id="req_amt" readonly>
						</div>

						<div class="mb-3">
							<label for="approval_status" class="form-label">Approval Status</label>
							<select class="select2 form-control select-opt" id="approval_status" name="approval_status"
								required>
								<option value="">Select Status</option>
								<option value="1">Approved</option>
								<option value="0">Rejected</option>
							</select>
						</div>

						<div class="mb-3">
							<label for="remark" class="form-label">Remark</label>
							<textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
						</div>
						<div class="mb-3">
							<label for="reg_Date" class="form-label">Reg Date</label>
							<input type="date" class="form-control" id="reg_Date" name="reg_Date" required readonly>
						</div>
						<input type="hidden" id="employeeId" name="employeeId">
						<input type="hidden" id="assestsid" name="assestsid">

						<div class="mb-3">
							<label for="approval_date" class="form-label">Approval Date</label>
							<input type="date" class="form-control" id="approval_date" name="approval_date" required>
						</div>

						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for Editing -->
		<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editModalLabel">Edit Asset Request</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="editForm" method="POST" action="">
							@csrf
							<input type="hidden" name="request_id" id="request_id">

							<!-- Fields for editing -->
							<div class="mb-3">
								<label for="brand" class="form-label">Brand</label>
								<input type="text" class="form-control" id="brand" name="brand">
							</div>

							<div class="mb-3">
								<label for="model_name" class="form-label">Model Name</label>
								<input type="text" class="form-control" id="model_name" name="model_name">
							</div>

							<div class="mb-3">
								<label for="model_no" class="form-label">Model No</label>
								<input type="text" class="form-control" id="model_no" name="model_no">
							</div>

							<div class="mb-3">
								<label for="dealer_name" class="form-label">Dealer Name</label>
								<input type="text" class="form-control" id="dealer_name" name="dealer_name">
							</div>

							<div class="mb-3">
								<label for="dealer_contact" class="form-label">Dealer Contact</label>
								<input type="text" class="form-control" id="dealer_contact" name="dealer_contact">
							</div>

							<div class="mb-3">
								<label for="purchase_date" class="form-label">Purchase Date</label>
								<input type="date" class="form-control" id="purchase_date" name="purchase_date">
							</div>

							<div class="mb-3">
								<label for="price" class="form-label">Price</label>
								<input type="number" class="form-control" id="price" name="price" step="0.01">
							</div>

							<div class="mb-3">
								<label for="registration_no" class="form-label">Registration No</label>
								<input type="text" class="form-control" id="registration_no" name="registration_no">
							</div>

							<div class="mb-3">
								<label for="registration_date" class="form-label">Registration Date</label>
								<input type="date" class="form-control" id="registration_date" name="registration_date">
							</div>

							<div class="mb-3">
								<label for="bill_no" class="form-label">Bill No</label>
								<input type="text" class="form-control" id="bill_no" name="bill_no">
							</div>

							<div class="mb-3">
								<label for="invoice" class="form-label">Invoice</label>
								<input type="text" class="form-control" id="invoice" name="invoice">
							</div>

							<div class="mb-3">
								<label for="fuel_type" class="form-label">Fuel Type</label>
								<input type="text" class="form-control" id="fuel_type" name="fuel_type">
							</div>

							<div class="mb-3">
								<label for="ownership" class="form-label">Ownership</label>
								<input type="text" class="form-control" id="ownership" name="ownership">
							</div>

							<div class="mb-3">
								<label for="current_odo_meter" class="form-label">Current Odometer</label>
								<input type="number" class="form-control" id="current_odo_meter" name="current_odo_meter">
							</div>

							<div class="mb-3">
								<label for="odo_meter" class="form-label">Odometer</label>
								<input type="number" class="form-control" id="odo_meter" name="odo_meter">
							</div>

							<div class="mb-3">
								<label for="remark" class="form-label">Remark</label>
								<input type="text" class="form-control" id="remark" name="remark">
							</div>
							
							<button type="submit" class="btn btn-primary">Save Changes</button>
						</form>
					</div>
				</div>
			</div>
		</div>


	<div class="modal fade show" id="billdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
		style="display: none;" aria-modal="true" role="dialog">
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
					<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
						data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="fileModalLabel">File Preview</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!-- Dynamically load the content here -->
					<div id="filePreviewContainer">
						<!-- File content will be dynamically loaded here (image or other file type) -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal for PDF preview with pagination -->
	<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!-- PDF carousel -->

					<div id="pdfCarousel" class="carousel slide" data-bs-ride="carousel">
						<div class="carousel-inner" id="pdfCarouselContent"></div>

						<!-- Custom Previous Button -->
						<button class="carousel-control-prev" type="button" data-bs-target="#pdfCarousel"
							data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>

						<!-- Custom Next Button -->
						<button class="carousel-control-next" type="button" data-bs-target="#pdfCarousel"
							data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>

				</div>
			</div>
		</div>
	</div>


	@include('employee.footer');
	<script>
		const employeeId = {{ Auth::user()->EmployeeID }};
		const asseststoreUrl = "{{ route('asset.request.store')  }}";

	</script>
	<script>
			// Handle form submission with AJAX
	$('#assetRequestFormVehcile').on('submit', function(e) {
		e.preventDefault(); // Prevent the default form submission

		var formData = new FormData(this); // FormData object to handle file uploads

		// Disable the submit button to prevent multiple submissions
		$('#submitBtn').prop('disabled', true).text('Submitting...');

		$.ajax({
			url: '{{ route('submit.vehicle.request') }}', // URL for the form submission route
			method: 'POST',
			data: formData,
			processData: false,
			contentType: false,
			success: function(response) {
				// Enable the submit button after the form is successfully submitted
				$('#submitBtn').prop('disabled', false).text('Submit');
				// Display success toast
				toastr.success(response.message, 'Success', {
									"positionClass": "toast-top-right",  // Position it at the top right of the screen
									"timeOut": 5000  // Duration for which the toast is visible (in ms)
								});
		
			},
			error: function(xhr, status, error) {
				// Enable the submit button after an error occurs
				$('#submitBtn').prop('disabled', false).text('Submit');

				// Show an error message in the toaster
				if (xhr.responseJSON && xhr.responseJSON.message) {
					toastr.error(xhr.responseJSON.message, 'Error');
				} else {
					toastr.error('An error occurred while submitting the form.', 'Error');
				}
			}
		});
	});
	function toggleApprovalView(requestId) {
        var approvalRow = document.getElementById('approval-row-' + requestId);

        // Toggle visibility of the approval section row
        if (approvalRow.style.display === "none") {
            approvalRow.style.display = "table-row";  // Show the approval details row
        } else {
            approvalRow.style.display = "none";  // Hide the approval details row
        }
    }
    $(document).ready(function() {
        // When the edit button is clicked
        $('.edit-btn').on('click', function() {
            // Get data from the clicked button
            const requestId = $(this).data('id');
            const brand = $(this).data('brand');
            const modelName = $(this).data('model-name');
            const modelNo = $(this).data('model-no');
            const dealerName = $(this).data('dealer-name');
            const dealerContact = $(this).data('dealer-contact');
            const purchaseDate = $(this).data('purchase-date');
            const price = $(this).data('price');
            const registrationNo = $(this).data('registration-no');
            const registrationDate = $(this).data('registration-date');
            const billNo = $(this).data('bill-no');
            const invoice = $(this).data('invoice');
            const fuelType = $(this).data('fuel-type');
            const ownership = $(this).data('ownership');
            const currentOdoMeter = $(this).data('current-odo');
            const odoMeter = $(this).data('odo');
            const remark = $(this).data('remark');

            // Populate modal fields
            $('#request_id').val(requestId);
            $('#brand').val(brand);
            $('#model_name').val(modelName);
            $('#model_no').val(modelNo);
            $('#dealer_name').val(dealerName);
            $('#dealer_contact').val(dealerContact);
            $('#purchase_date').val(purchaseDate);
            $('#price').val(price);
            $('#registration_no').val(registrationNo);
            $('#registration_date').val(registrationDate);
            $('#bill_no').val(billNo);
            $('#invoice').val(invoice);
            $('#fuel_type').val(fuelType);
            $('#ownership').val(ownership);
            $('#current_odo_meter').val(currentOdoMeter);
            $('#odo_meter').val(odoMeter);
            $('#remark').val(remark);

            // Open the modal
            $('#editModal').modal('show');
        });
    });


	</script>
	
	<script src="{{ asset('../js/dynamicjs/assests.js/') }}" defer></script>