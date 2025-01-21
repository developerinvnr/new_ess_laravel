@include('employee.header')

<body class="mini-sidebar">
	@include('employee.sidebar')
	<div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
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

					<div class="mfh-machine-profile" style="position: relative;">
                     <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="assestTabs" role="tablist">
                        <li class="nav-item">
                           <a style="color: #0e0e0e;" id="assesttab" class="nav-link active"
                              data-bs-toggle="tab" href="#assestFormSection" role="tab"
                              aria-controls="assestFormSection" aria-selected="true">Assets</a>
                        </li>
						
                        <li class="nav-item">
                           <a style="color: #0e0e0e;" id="assestform" class="nav-link"
                              data-bs-toggle="tab" href="#assestformSections" role="tab"
                              aria-controls="assestformSections" aria-selected="true">Assets Application Form</a>
                        </li>
						<li class="nav-item">
                           <a style="color: #0e0e0e;" id="assestvehciledetails" class="nav-link"
                              data-bs-toggle="tab" href="#assestvehcile" role="tab"
                              aria-controls="assestvehcile" aria-selected="true">Vehicle Information Form</a>
                        </li>
                     </ul>
					 <div class="assets-help-doc"><a href=""><b> <i class="fas fa-info-circle"></i> Help Documents</b></a></div>
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
												<th>Sn</th>
												<th>Type of Asset</th>
												<th>Company</th>
												<th>Model Name</th>
												<th>Allocated Date</th>
												<th>Returned Date</th>
												<td>Details</td>
											</tr>
										</thead>
										<tbody>
											@foreach(Auth::user()->employeeAssetOffice as $asset)
												<tr>
	
													<td>{{ $loop->index + 1 }}</td>
													@php
														// Query to fetch AssetName based on AssetId
														$assetName = \DB::table('hrm_asset_name') // Table name
															->where('AssetNId', $asset->AssetNId) // Column name in hrm_asset_name
															->value('AssetName'); // Get the value of AssetName directly

													@endphp
													<td>{{ $assetName ?? '-' }}</td>
													<td>{{ $asset->AComName ?? '-' }}</td>
													<td>{{ $asset->AModelName ?? '-' }}</td>

													<td>
														@if($asset->AAllocate && $asset->AAllocate != '0000-00-00' && $asset->AAllocate != '1970-01-01')
															{{ \Carbon\Carbon::parse($asset->AAllocate)->format('d-m-Y') }}
														@else
															-
														@endif
													</td>
													<td>
														@if($asset->ADeAllocate && $asset->ADeAllocate != '0000-00-00' && $asset->ADeAllocate != '1970-01-01')
															{{ \Carbon\Carbon::parse($asset->ADeAllocate)->format('d-m-Y') }}
														@else
															- 
														@endif
													</td>


													<!--<td> <a href="#" data-bs-toggle="modal" data-bs-target="#viewOfficialAssetsModal" class="viewofficialassets"><i class="fas fa-eye"></i></a></td>-->
													
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
												<th>Sn</th>
												<th>Request Date</th>
												<th>Type of Asset</th>
												<!--<th>Balance Amount</th>-->
												<th>Request Amount</th>
												<th>Acct. Approval Amount</th>
												<th>Bill Copy</th>
												<th>Asset Copy</th>
												<th>Reporting Remarks</th>
												<th>Details</th>
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
																		->where('AssetNId', $request->AssetNId) // Column name in hrm_asset_name
																		->value('AssetName'); // Field to retrieve
													@endphp

													<td>{{ $assetName ?? 'N/A' }}</td> <!-- Display AssetName -->
													<!--<td>-->
													<!--	<b>{{ ($request->MaxLimitAmt - $request->ApprovalAmt)}}/-</b>-->
													<!--</td>-->
													<td><b>{{ number_format($request->ReqAmt) }}/-</b></td>
													<td><b>{{ number_format($request->ApprovalAmt) }}/-</b></td>
													<td>
														@if($request->ReqBillImgExtName != '')

															<!-- Check if it's a PDF -->
															@if(str_ends_with($request->ReqBillImgExtName, '.pdf'))
																<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																data-file-url="{{ url('Employee/AssetReqUploadFile/' . $request->ReqBillImgExtName) }}"
																data-file-type="bill">
																<i class="fas fa-eye me-2"></i>
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																data-file-url="{{ url('Employee/AssetReqUploadFile/' . $request->ReqBillImgExtName) }}"
																data-file-type="bill">
																<i class="fas fa-eye me-2"></i>
																</a>
															@endif

														@else
															<span>No Bill</span>
														@endif
													</td>
													<td>
														@if($request->ReqAssestImgExtName)
															<!-- Check if it's a PDF -->
															@if(str_ends_with($request->ReqAssestImgExtName, '.pdf'))
																<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																	data-file-url="{{ url('Employee/AssetReqUploadFile/' . $request->ReqAssestImgExtName) }}"
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																	data-file-url="{{ url('Employee/AssetReqUploadFile/' . $request->ReqAssestImgExtName) }}"
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i>
																</a>
															@endif
														@else
															<span>No Asset</span>
														@endif
													</td>

													<td>{{ $request->HODRemark }}</td>
													<td>
														<!-- View button to show approval status -->
														<button type="button" style="padding:3px 11px;font-size: 11px;"
																class="btn-outline success-outline sm-btn"
																data-request-id="{{ $request->AssetEmpReqId }}"
																onclick="toggleApprovalView({{ $request->AssetEmpReqId }})">
															Status
														</button>
														<a href="#" data-bs-toggle="modal" data-bs-target="#viewassetsModal" class="viewassets"><i class="fas fa-eye"></i></a>
													</td>
													
												</tr>

												<tr id="approval-row-{{ $request->AssetEmpReqId }}" style="display:none;">
													<td colspan="5">
														<!-- Display approval sections horizontally -->
														<div class="approval-status" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0;">

															<!-- HOD Approval Section -->
															<div class="approval-item" style="text-align: center; position: relative; width: 30%;">
																<!-- Circle for HOD -->
																<span @if($request->HODApprovalStatus == 2)
																		style="background-color: #0d9137;margin-top:25px;" 
																	@else
																		style="background-color: #dba62f;margin-top:25px;" 
																	@endif
																	class="exp-round" 
																	style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;margin-top:25px;"></span>
																<div class="approval-details" style="padding-top: 10px;padding-left:15px;">
																	<h6>@if($request->HODApprovalStatus == 2) Level 1 @else Pending HOD Approval @endif</h6>
																	<p>HOD/Reporting Section</p>
																	<p>{{ \Carbon\Carbon::parse($request->HODSubDate)->format('d M Y')?? 'Date Not Available' }}</p>
																	<p>{{ $request->HODRemark ?? 'No Remarks' }}</p>
																</div>
																<!-- Connecting Line -->
																<div class="line" style="position: absolute; top: 50%; left: 100%; width: 50px; height: 2px; background-color: #ccc;"></div>
															</div>

															<!-- IT Approval Section -->
															<div class="approval-item" style="text-align: center; position: relative; width: 30%;">
																<!-- Circle for IT -->
																<span @if($request->ITApprovalStatus == 2)
																		style="background-color: #0d9137;margin-top:34px;" 
																	@else
																		style="background-color: #dba62f;margin-top:34px;" 
																	@endif
																	class="exp-round" 
																	style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;margin-top:34px;"></span>
																<div class="approval-details" style="padding-top: 10px;margin-left:20px;">
																	<h6>@if($request->ITApprovalStatus == 2) Level 2 @else Pending IT Approval @endif</h6>
																	<p>IT Section</p>
																	<p>{{\Carbon\Carbon::parse($request->ITSubDate)->format('d M Y')?? 'Date Not Available' }}</p>
																	<p>{{ $request->ITRemark ?? 'No Remarks' }}</p>
																</div>
																<!-- Connecting Line -->
																<div class="line" style="position: absolute; top: 50%; left: 100%; width: 50px; height: 2px; background-color: #ccc;"></div>
															</div>

															<!-- Accounts Approval Section -->
															<div class="approval-item" style="text-align: center; position: relative; width: 30%;">
																<!-- Circle for Accounts -->
																<span @if($request->AccPayStatus == 2)
																		style="background-color: #0d9137;margin-top:34px;" 
																	@else
																		style="background-color: #dba62f;margin-top:34px;" 
																	@endif
																	class="exp-round" 
																	style="border-radius: 50%; width: 30px; height: 30px; display: inline-block; margin-bottom: 10px;margin-top:34px;"></span>
																<div class="approval-details" style="padding-top: 10px;margin-left:20px;">
																	<h6>@if($request->AccPayStatus == 2) Level 3 @else Pending Accounts Approval @endif</h6>
																	<p>Accounts Section</p>
																	<p>{{ \Carbon\Carbon::parse($request->AccSubDate)->format('d M Y') ?? 'Date Not Available' }}</p>
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
											@if($assets_requestss->isNotEmpty())
												<div class="card chart-card">
													<div class="card-header">
														<h4 class="has-btn">Approval Status</h4>
														<form method="GET" action="{{ url()->current() }}">
																<select id="acctStatusFilter" name="acct_status" style="float:right;">
																	<option value="">All</option>
																	<option value="0" {{ request()->get('acct_status', '0') == '0' ? 'selected' : '' }}>Draft</option>
																	<option value="2" {{ request()->get('acct_status') == '2' ? 'selected' : '' }}>Approved</option>
																	<option value="3" {{ request()->get('acct_status') == '3' ? 'selected' : '' }}>Rejected</option>

																</select>
															</form>
													</div>
													<div class="card-body table-responsive">
														<table class="table" id="assestapprovaltable">
																							<thead class="thead-light" style="background-color:#f1f1f1;">
																				<tr>
																				
																				<th>EC</th>
																				<th>Employee Name</th>
																				<th>Type of Assets</th>
																				<th>Req Date</th>
																				<th>Balance Amount</th>
																				<th>Requested Amount</th>
																				<th>Acct. Approval Amount</th>
																				<th colspan="3" style="text-align: center;">Approval Status</th>  <!-- Main Approval Status Column with Sub-columns -->
																				<th>Reporting Remark</th>
																				<th>Approval Date</th>
																				<th>Bill Copy</th>
																				<th>Assets Copy</th>
																				<th>Action</th>
																			</tr>
																			<tr>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th style="text-align: center;">HOD</th>
																				<th style="text-align: center;">IT</th>
																				<th style="text-align: center;">Account</th>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th></th>
																				<th></th>

																			</tr>
																		</thead>
																		<tbody>
																			@foreach($assets_requestss as $index => $request)
																			@php
																					// Determine leave status and set the status for filtering
																					$acctStatus = $request->AccPayStatus;
																					
																				@endphp
																				<tr data-status="{{ $acctStatus }}">
																					<td>{{ $request->EmpCode }}</td>

																					<td>{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}</td>
																					<td>{{ $request->AssetName}}</td>
																					<td>{{ \Carbon\Carbon::parse($request->ReqDate)->format('d-m-Y') }}</td>
																					<td>
																						<b>{{ number_format((float)$request->MaxLimitAmt, 0) }}/-</b>

																					</td>
																					
																					<td><b>{{ number_format($request->ReqAmt) }}/-</b></td>
																					<td><b>{{ number_format($request->ApprovalAmt) }}/-</b></td>
																					

																					<td>
																					<!-- Display the approval status for HOD without checking user role -->
																					@if($request->HODApprovalStatus == 2)
																						<span class="success"><b>Approved</b></span>
																					@elseif($request->HODApprovalStatus == 0)
																						<span class="warning"><b>Draft</b></span>
																					@elseif($request->HODApprovalStatus == 3)
																						<span class="danger"><b>Rejected</b></span>
																					@else
																						N/A
																					@endif
																					</td>

																			<td>
																				<!-- Display the approval status for IT without checking user role -->
																				@if($request->ITApprovalStatus == 2)
																				<span class="success"><b>Approved</b></span>
																				@elseif($request->ITApprovalStatus == 0)
																				<span class="warning"><b>Draft</b></span>
																				@elseif($request->ITApprovalStatus == 3)
																				<span class="danger"><b>Rejected</b></span>
																			
																				@else
																					N/A
																				@endif
																			</td>

																			<td>
																				<!-- Display the approval status for Accounts without checking user role -->
																				@if($request->AccPayStatus == 2)
																				<span class="success"><b>Approved</b></span>
																				@elseif($request->AccPayStatus == 3)
																				<span class="danger"><b>Rejected</b></span>
																				@elseif($request->AccPayStatus == 0)
																				<span class="warning"><b>Draft</b></span>
																				
																				@else
																					N/A
																				@endif
																			</td>

																					<td>{{ $request->HODRemark }}</td>
																					<td>{{ $request->HODSubDate ? \Carbon\Carbon::parse($request->HODSubDate)->format('d-m-Y') : '' }}
																			</td>

																					<td>
																						@if($request->ReqBillImgExtName)
																							<!-- Check if it's a PDF -->
																							@if(str_ends_with($request->ReqBillImgExtName, '.pdf'))
																								<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																								data-file-url="{{ url('Employee/AssetReqUploadFile/' .  $request->ReqBillImgExtName) }}"
																								data-file-type="bill">
																									<i class="fas fa-eye me-2"></i>
																								</a>
																							@else
																								<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																								data-file-url="{{ url('Employee/AssetReqUploadFile/' .  $request->ReqBillImgExtName) }}"
																								data-file-type="bill">
																									<i class="fas fa-eye me-2"></i>
																								</a>
																							@endif
																						@else
																							<span>No Bill</span>
																						@endif
																					</td>
																					<td>
																						@if($request->ReqAssestImgExtName)
																							<!-- Check if it's a PDF -->
																							@if(str_ends_with($request->ReqAssestImgExtName, '.pdf'))
																								<a href="#" data-bs-toggle="modal" data-bs-target="#pdfModal"
																								data-file-url="{{ url('Employee/AssetReqUploadFile/' .  $request->ReqAssestImgExtName) }}"
																								data-file-type="asset">
																									<i class="fas fa-eye me-2"></i>
																								</a>
																							@else
																								<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																								data-file-url="{{ url('Employee/AssetReqUploadFile/' .  $request->ReqAssestImgExtName) }}"
																								data-file-type="asset">
																									<i class="fas fa-eye me-2"></i>
																								</a>
																							@endif
																						@else
																							<span>No Asset</span>
																						@endif
																					</td>
																						<td>
																						<button type="button" class="mb-0 sm-btn mr-1 effect-btn btn btn-success accept-btn" data-bs-toggle="modal"
																							data-bs-target="#approvalModal"
																							data-employee-id-acct="{{ $request->AccId }}"
																							data-employee-id-it="{{ $request->ITId }}"
																							data-ApprovalAmt="{{ $request->ApprovalAmt }}"
																							data-employee-id-rep="{{ $request->ReportingId }}"
																							data-employee-id-hod="{{ $request->HodId }}"
																							data-request-id="{{ $request->AssetEmpReqId }}"
																							data-employee-id="{{ $request->EmployeeID }}"
																							data-employee-name="{{ $request->Fname . ' ' . $request->Sname . ' ' . $request->Lname }}"
																							data-asset-id="{{ $request->AssetNId }}"
																							data-req-amt="{{ $request->ReqAmt }}"
																							data-req-date="{{ $request->ReqDate }}"
																							data-req-amt-per-month="{{ $request->ReqAmtPerMonth }}"
																							data-model-name="{{ $request->ModelName }}"
																							data-company-name="{{ $request->ComName }}"
																							data-pay-amt="{{ $request->AccPayAmt }}"
																							data-pay-date="{{ $request->AccPayDate }}"
																							data-approval-status-hod="{{ $request->HODApprovalStatus }}"
																							data-approval-status-acct="{{ $request->AccPayStatus }}"
																							data-approval-status-it="{{ $request->ITApprovalStatus }}"
																							data-dealer-number="{{ $request->DealerContNo }}"
																							@if(($request->AccPayStatus === 2 && Auth::user()->EmployeeID == $request->AccId) || 
																								($request->ITApprovalStatus === 2 && Auth::user()->EmployeeID == $request->ITId) || 
																								($request->HODApprovalStatus === 2 && Auth::user()->EmployeeID == $request->HodId))
																								disabled
																							@endif>
																							@if(($request->AccPayStatus === 2 && Auth::user()->EmployeeID == $request->AccId) || 
																								($request->ITApprovalStatus === 2 && Auth::user()->EmployeeID == $request->ITId) || 
																								($request->HODApprovalStatus === 2 && Auth::user()->EmployeeID == $request->HodId))
																								Actioned
																							@else
																								Action
																							@endif
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
																									<select class="select2 form-control select-opt" id="asset" name="asset">
																											<option value="" disabled selected>Select Asset Name</option>

																											@if ($mobileeligibility->Mobile_Hand_Elig === 'Y')
																												<!-- Additional options for mobile eligibility -->
																												<option value="11" data-limit="{{$mobileeliprice}}" data-type="Mobile Phone">Mobile Phone</option>
																												<option value="12" data-limit="{{$mobileeliprice}}" data-type="Mobile Accessories">Mobile Accessories</option>
																												<option value="18" data-limit="{{$mobileeliprice}}" data-type="Mobile Maintenance">Mobile Maintenance</option>
																											@endif
																										
																											<!-- Dynamically populate options from $assets -->
																											@foreach ($assets as $asset)
																												<option value="{{ $asset->AssetNId }}" data-limit="{{ $asset->AssetELimit }}" data-type="{{ $asset->AssetName }}">
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
																							name="maximum_limit" readonly >
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
																							placeholder="Enter model name"
																							id="model_name" name="model_name">
																						<div class="invalid-feedback">Model name is required.</div>
																					</div>
																				</div>

																			<!-- Model Number -->
																			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																			<div class="form-group">
																				<label for="model_no" class="col-form-label"><b>Model Number <span class="danger">*</span></b></label>
																				<input class="form-control" type="text" placeholder="Enter model number" id="model_no" name="model_no"
																				maxlength="20">
																				<div class="invalid-feedback">Model number is required and can only contain letters, numbers, and spaces.</div>
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
																							name="company_name" >
																						<div class="invalid-feedback">Company name is required.</div>
																					</div>
																				</div>

																				<!-- Purchase Date -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="purchase_date" class="col-form-label"><b>Purchase Date
																							<span class="danger">*</span></b></label>
																						<input class="form-control" type="date" placeholder="Purchase Date"
																							id="purchase_date" name="purchase_date" 
																							max="{{ date('Y-m-d') }}">
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
																							name="dealer_name" >
																						<div class="invalid-feedback">Dealer name is required.</div>
																					</div>
																				</div>

																				<!-- Dealer Contact -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="dealer_contact" class="col-form-label"><b>Dealer Contact
																								</b></label>
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
																							id="price" name="price" >
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
																							name="bill_number" >
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
																							name="request_amount" >
																						<div class="invalid-feedback">Request amount is required.</div>
																					</div>
																				</div>

																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="imei_field">
																					<div class="form-group">
																						<label for="iemi_no" class="col-form-label"><b>IMEI No.: <span
																									class="danger">*</span></b></label>
																						<input class="form-control" type="text"
																							placeholder="Enter IMEI number" id="iemi_no" name="iemi_no"
																							>
																						<div class="invalid-feedback">IMEI number is required.</div>
																					</div>
																				</div>


																				<!-- Bill Copy -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="bill_copy" class="col-form-label"><b>Bill Copy <span
																									class="danger">*</span></b></label>
																						<input class="form-control" id="bill_copy" name="bill_copy"
																							type="file"  />
																						<div class="invalid-feedback">Bill copy is required.</div>
																					</div>
																				</div>

																				<!-- Asset Copy -->
																				<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12" id="asset_id">
																					<div class="form-group">
																						<label for="asset_copy" class="col-form-label"><b>Asset Copy <span
																									class="danger">*</span></b></label>
																						<input class="form-control" id="asset_copy" name="asset_copy"
																							type="file"  />
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
																							type="file" accept="image/*" >
																						<div class="invalid-feedback">Vehicle photo is required.</div>
																					</div>
																				</div>



																				

																				<!-- Fuel Type -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" id="vehicle_fuel"
																					style="display:none;">
																					<div class="form-group s-opt">
																						<label for="fuel_type" class="col-form-label"><b>Fuel Type <span
																									class="danger">*</span></b></label>
																						<select class="select2 form-control select-opt" id="fuel_type" name="fuel_type">
																							<option value="" disabled selected>Select Fuel Type</option>
																							<option value="petrol">Petrol</option>
																							<option value="diesel">Diesel</option>
																							<option value="electric">Electric</option>
																							<option value="cng">CNG</option>
																						</select>
																						<span class="sel_arrow">
																							<i class="fa fa-angle-down"></i>
																						</span>
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
																							>
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
																							>
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
																							name="insurance_copy" type="file" >
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
																					<div class="form-group s-opt">
																						<label for="ownership" class="col-form-label"><b>Ownership <span
																									class="danger">*</span></b></label>
																						<select class="select2 form-control select-opt" id="ownership" name="ownership"
																							>
																							<option value="" disabled selected>Select Ownership</option>
																							<option value="1">1st</option>
																							<option value="2">2nd</option>
																							<option value="3">3rd</option>
																						</select>
																						<span class="sel_arrow">
																							<i class="fa fa-angle-down"></i>
																						</span>
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
																				<input type="hidden" id="employeeid" name="EmployeeID" value="{{Auth::user()->EmployeeID}}">
																				<input type="hidden" id="empcode" name="EmpCode" value="{{Auth::user()->EmpCode}}">

																				<!-- Vehicle Type Dropdown -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group s-opt">
																						<label for="vehicle_typenew" class="col-form-label"><b>Select Vehicle Type <span class="danger">*</span></b></label>
																						<select class="select2 form-control select-opt" id="vehicle_type" name="vehicle_typenew" >
																							<option value="" disabled selected>Select Vehicle Type</option>
																							<option value="2-wheeler" data-name="2-Wheeler" data-id="2w">2 Wheeler</option>
																							<option value="4-wheeler" data-name="4-Wheeler" data-id="4w">4 Wheeler</option>
																						</select>	
																						<span class="sel_arrow">
																							<i class="fa fa-angle-down"></i>
																						</span>
																					</div>
																				</div>


																				<!-- Model Name -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="model_name" class="col-form-label"><b>Model Name <span class="danger">*</span></b></label>
																						<input class="form-control" type="text" placeholder="Enter model name" id="model_name" name="model_name" >
																						<div class="invalid-feedback">Model name is required.</div>
																					</div>
																				</div>
																				
																				<!-- Model Name -->
																				<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																					<div class="form-group">
																						<label for="model_no" class="col-form-label"><b>Model Number <span class="danger">*</span></b></label>
																						<input class="form-control" type="text" placeholder="Enter model name" id="model_no" name="model_no" >
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
																																name="dealer_name" >
																															<div class="invalid-feedback">Dealer name is required.</div>
																														</div>
																													</div>

																													<!-- Dealer Contact -->
																													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																														<div class="form-group">
																															<label for="dealer_contact" class="col-form-label"><b>Dealer Contact
																																	</b></label>
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
																																id="price" name="price" >
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
																																name="bill_number" >
																															<div class="invalid-feedback">Bill number is required.</div>
																														</div>
																													</div>

																												<!-- Vehicle Brand -->
																												<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																													<div class="form-group">
																														<label for="vehicle_brandnew" class="col-form-label"><b>Vehicle Brand <span class="danger">*</span></b></label>
																														<input class="form-control" type="text" placeholder="Enter vehicle brand" id="vehicle_brandnew" name="vehicle_brandnew" >
																														<div class="invalid-feedback">Vehicle brand is required.</div>
																													</div>
																												</div>
																											<!-- Bill Copy -->
																											<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
																																				<div class="form-group">
																																					<label for="bill_copy" class="col-form-label"><b>Bill Copy <span
																																								class="danger">*</span></b></label>
																																					<input class="form-control" id="bill_copy" name="bill_copy"
																																						type="file"  />
																																					<div class="invalid-feedback">Bill copy is required.</div>
																																				</div>
																																			</div>

																													<!-- Vehicle Photo (hidden by default) -->
																													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																														<div class="form-group">
																															<label for="vehicle_photonew" class="col-form-label"><b>Vehicle Photo <span class="danger">*</span></b></label>
																															<input class="form-control" id="vehicle_photo" name="vehicle_photonew" type="file" accept="image/*" >
																															<div class="invalid-feedback">Vehicle photo is required.</div>
																														</div>
																													</div>

																													<!-- Fuel Type (conditional) -->
																													<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																														<div class="form-group s-opt">
																															<label for="fuel_typenew" class="col-form-label"><b>Fuel Type <span class="danger">*</span></b></label>
																															<select class="select2 form-control select-opt" id="fuel_typenew" name="fuel_typenew" >
																																<option value="" disabled selected>Select Fuel Type</option>
																																<option value="petrol">Petrol</option>
																																<option value="diesel">Diesel</option>
																																<option value="electric">Electric</option>
																																<option value="cng">CNG</option>
																															</select>
																															<span class="sel_arrow">
																																<i class="fa fa-angle-down"></i>
																															</span>
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
																																>
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
																																>
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
																																name="insurance_copy" type="file" >
																															<div class="invalid-feedback">Insurance copy is required.</div>
																														</div>
																													</div>

																												<!-- Ownership -->
																												<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12" >
																													<div class="form-group s-opt">
																														<label for="ownership" class="col-form-label"><b>Ownership <span class="danger">*</span></b></label>
																														<select class="select2 form-control select-opt" id="ownershipnew" name="ownershipnew" >
																															<option value="" disabled selected>Select Ownership</option>
																															<option value="1">1st</option>
																															<option value="2">2nd</option>
																															<option value="3">3rd</option>
																														</select>
																														<span class="sel_arrow">
																															<i class="fa fa-angle-down"></i>
																														</span>
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
																							data-id="{{ $request->id }}" 
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
																							@if($request->hr_approval == 1) disabled @endif>
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
																<p class="mb-2"><b>Bill Copy</b></p>
																<img style="width:250px;" id="modalBillCopy" />
															</div>
															<div class="col-md-6">
																<p class="mb-2"><b>Asset Copy</b></p>
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
													<form action="{{ route('approve.request.team.assest') }}" method="POST" id="approvalForm">
														@csrf
														<input type="hidden" name="request_id" id="request_id">
														<input type="hidden" name="employee_id" id="employee_id">

														<div class="">
															<label for="employee_name" class="form-label"><b>Name:</b></label>
															<span id="employee_name_span"></span>  <!-- Display the Employee Name here -->
															<input type="hidden" class="form-control" id="employee_name" readonly>  <!-- Hidden input to store value -->
														</div>

														

														<div class="row">
															<div class="col-md-6 mb-3">
																<label for="req_amt" class="form-label"><b>Request Amount:</b></label>
																<span style="color:#3e757a;font-weight:600;" id="req_amt_span"></span>  <!-- Display the Request Amount here -->
																<input type="hidden" class="form-control" id="req_amt" readonly>  <!-- Hidden input to store value -->
															</div>
															<div class="col-md-6 mb-3">
																<label for="reg_Date" class="form-label"><b>Request Date:</b></label>
																<span id="reg_Date_span"></span>  <!-- Display the Reg Date here -->
																<input type="hidden" class="form-control" id="reg_Date" name="reg_Date" required readonly>  <!-- Hidden input to store value -->
															</div>
														<div class="col-md-6 mb-3 form-group s-opt">
															<label for="approval_status" class="form-label"><b>Approval Status</b></label>
															<select class="select2 form-control select-opt" id="approval_status" name="approval_status" required>
																<option value="">Select Status</option>
																<option value="2">Approved</option>
																<option value="3">Rejected</option>
															</select>
															<span class="sel_arrow" style="right:25px;">
																<i class="fa fa-angle-down"></i>
															</span>
															<span id="approval_status_display" style="display: none; font-weight: 600;"></span>


														</div>
														<div class="col-md-6 mb-3">
															<label for="approval_date" class="form-label"><b>Approval Date</b></label>
															<input type="date" class="form-control" id="approval_date" name="approval_date" value="" required readonly>
														</div>
														</div>
														<!-- Approval Amount field will appear conditionally -->
														<div class="mb-3" id="approval_amount_div" style="display: none;">
															<label for="approval_amt" class="form-label"><b>Approval Amount:</b></label>
															<input type="number" class="form-control" id="approval_amt" name="approval_amt">
															<span id="approval_amt_display" style="display: none; font-weight: 600;"></span>

														</div>

														<div class="mb-3">
															<label for="remark" class="form-label"><b>Remark</b></label>
															<textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
														</div>

														<input type="hidden" id="employeeId" name="employeeId">
														<input type="hidden" id="assestsid" name="assestsid">

														

														<button type="submit" class="btn btn-primary" id="submit_button">Submit</button>
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
					<form id="editForm" method="POST">
						@csrf
						<input type="hidden" name="request_id" id="modal_request_id">

						<!-- Fields for editing -->
						<div class="mb-3">
							<label for="modal_brand" class="form-label">Brand</label>
							<input type="text" class="form-control" id="modal_brand" name="modal_brand">
						</div>

						<div class="mb-3">
							<label for="modal_model_name" class="form-label">Model Name</label>
							<input type="text" class="form-control" id="modal_model_name" name="modal_model_name">
						</div>

						<div class="mb-3">
							<label for="modal_model_no" class="form-label">Model No</label>
							<input type="text" class="form-control" id="modal_model_no" name="modal_model_no">
						</div>

						<div class="mb-3">
							<label for="modal_dealer_name" class="form-label">Dealer Name</label>
							<input type="text" class="form-control" id="modal_dealer_name" name="modal_dealer_name">
						</div>

						<div class="mb-3">
							<label for="modal_dealer_contact" class="form-label">Dealer Contact</label>
							<input type="text" class="form-control" id="modal_dealer_contact" name="modal_dealer_contact">
						</div>

						<div class="mb-3">
							<label for="modal_purchase_date" class="form-label">Purchase Date</label>
							<input type="date" class="form-control" id="modal_purchase_date" name="modal_purchase_date">
						</div>

						<div class="mb-3">
							<label for="modal_price" class="form-label">Price</label>
							<input type="number" class="form-control" id="modal_price" name="modal_price" step="0.01">
						</div>

						<div class="mb-3">
							<label for="modal_registration_no" class="form-label">Registration No</label>
							<input type="text" class="form-control" id="modal_registration_no" name="modal_registration_no">
						</div>

						<div class="mb-3">
							<label for="modal_registration_date" class="form-label">Registration Date</label>
							<input type="date" class="form-control" id="modal_registration_date" name="modal_registration_date">
						</div>

						<div class="mb-3">
							<label for="modal_bill_no" class="form-label">Bill No</label>
							<input type="text" class="form-control" id="modal_bill_no" name="modal_bill_no">
						</div>

						<div class="mb-3">
							<label for="modal_fuel_type" class="form-label">Fuel Type</label>
							<input type="text" class="form-control" id="modal_fuel_type" name="modal_fuel_type">
						</div>

						<div class="mb-3">
							<label for="modal_ownership" class="form-label">Ownership</label>
							<input type="text" class="form-control" id="modal_ownership" name="modal_ownership">
						</div>

						<button type="submit" class="btn btn-primary">Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h5 class="modal-title" id="fileModalLabel">File Preview</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload();"></button>
				</div>

				<div class="modal-body">
					<!-- Dynamically load the content here -->
					<div id="filePreviewContainer">
						<!-- File content will be dynamically loaded here (image or other file type) -->
					</div>
				</div>
				    <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printFilePreviewBtn">Print</button>
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
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload();"></button>
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
				<div class="modal-footer">
                <button type="button" class="btn btn-primary" id="printPdfPreviewBtn">Print PDF</button>
            </div>
			</div>
		</div>
	</div>
	
<!-- Modal official assets details -->
<div id="viewOfficialAssetsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewOfficialAssetsModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-md modal-dialog-centered" role="document">
   <div class="modal-content">
	  <div class="modal-header">
		 <h5 class="modal-title" id="viewqueryModalLabel">Official Assets Details</h5>
		 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
		 <span aria-hidden="true">×</span>
		 </button>
	  </div>
	  <div class="modal-body">
		<div class="row assets-details-popup">
			<!----------- Official Assets -------------->
			<div class="col-md-6 mb-2">
				<b>Type of Asset:</b>
				<span>-</span>
			</div>
			<div class="col-md-6 mb-2">
				<b>Assest ID:</b>
				<span>-</span>
			</div>
			<div class="col-md-6 mb-2">
				<b>Company:</b>
				<span>HP</span>
			</div>
			<div class="col-md-6 mb-2">
				<b>Model Name:</b>
				<span>-</span>
			</div>
			<div class="col-md-6 mb-2">
				<b>Serial Number:</b>
				<span>-</span>
			</div>
			<div class="col-md-6 mb-2">
				<b>Allocated:</b>
				<span>-</span>
			</div>
			<div class="col-md-6 mb-2">
				<b>Returned:</b>
				<span>-</span>
			</div>
		</div>
	  </div>
   </div>
</div>
</div>

<!-- Modal assets details -->
<div id="viewassetsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewassetsModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-md modal-dialog-centered" role="document">
   <div class="modal-content">
	  <div class="modal-header">
		 <h5 class="modal-title" id="viewqueryModalLabel">Assets Details</h5>
		 <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
		 <span aria-hidden="true">×</span>
		 </button>
	  </div>
	  <div class="modal-body">
		<div class="row assets-details-popup">
			<div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
				<h6 class="float-start"><b>Asset Name: Desktop</b></h6>
			 </div>
			 <div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
				<h6 class="float-start"><b>Vehicle Type: 2 Wheeler</b></h6>
			 </div>
			<!----------- Assets request/ vehcile Details -------------->
			<div class="col-md-6">
				<b>Limit:</b>
				<span>2500/-</span>
			</div>
			<div class="col-md-6">
				<b>Model Name:</b>
				<span>2500/-</span>
			</div>
			<div class="col-md-6">
				<b>Model Number:</b>
				<span>2500/-</span>
			</div>
			<div class="col-md-6">
				<b>Vehicle Brand:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Company Name:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Purchase Date:</b>
				<span>15-02-2024</span>
			</div>
			<div class="col-md-6">
				<b>Dealer Name:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Dealer Contact:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Price:</b>
				<span>2540/-</span>
			</div>
			<div class="col-md-6">
				<b>Bill Number:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Vehicle Brand:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Request Amount:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>IMEI No.:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Fuel Type:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Registration Number:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Registration Date:</b>
				<span>-</span>
			</div>
			<div class="col-md-6">
				<b>Ownership:</b>
				<span>-</span>
			</div>
			
			<!------------------------>
			<div class="col-md-12 mb-2"><p style="border:1px solid #ddd;"></p></div>
			<!----------- Assets Application Form  bill copy-------------->
			<div class="col-md-12 bill-show mb-2">
				<ul class="p-0 ml-3">
				<li><b>Bill Copy</b><a href="./images/excel-invoice.jpg"><i class="fas fa-file-pdf"></i> </a></li>
				<li><b>Assets Copy</b><a href="./images/excel-invoice.jpg"><i class="fas fa-file-image"></i> </a></li>
				<li><b>Vehicle Photo</b><a href="./images/excel-invoice.jpg"><i class="fas fa-file-image"></i> </a></li>
				<li><b>DL Copy</b><a href="./images/excel-invoice.jpg"><i class="fas fa-file-image"></i> </a></li>
				<li><b>DL Copy</b><a href="./images/excel-invoice.jpg"><i class="fas fa-file-image"></i> </a></li>
				<li><b>RC Copy</b><a href="./images/excel-invoice.jpg"><i class="fas fa-file-image"></i> </a></li>
				<li><b>Insurance Copy</b><a href=""><i class="fas fa-file-pdf"></i>  </a></li>
				
				</ul>
			</div>
			<div class="col-md-12">
				<b>Remarks:</b>
				<span>-</span>
			</div>
			
		</div>
	  </div>
   </div>
</div>
</div>

	@include('employee.footer')
	<script>
		const employeeId = {{ Auth::user()->EmployeeID }};
		const asseststoreUrl = "{{ route('asset.request.store')  }}";

			// Handle form submission with AJAX
	$('#assetRequestFormVehcile').on('submit', function(e) {
		e.preventDefault(); // Prevent the default form submission
		$('#loader').show();

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
				$('#loader').hide();

				// Enable the submit button after the form is successfully submitted
				$('#submitBtn').prop('disabled', false).text('Submit');
				// Display success toast
				toastr.success(response.message, 'Success', {
									"positionClass": "toast-top-right",  // Position it at the top right of the screen
									"timeOut": 5000  // Duration for which the toast is visible (in ms)
								});
								setTimeout(function () {
                        location.reload();  // Optionally, reload the page
                    }, 3000); // Delay before reset and reload to match the toast timeout
		
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
				$('#loader').hide();

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
        // Get data from the clicked button using data-* attributes
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
        const fuelType = $(this).data('fuel-type');
        const ownership = $(this).data('ownership');

        // Populate modal fields with the data
        $('#modal_request_id').val(requestId);
        $('#modal_brand').val(brand);
        $('#modal_model_name').val(modelName);
        $('#modal_model_no').val(modelNo);
        $('#modal_dealer_name').val(dealerName);
        $('#modal_dealer_contact').val(dealerContact);
        $('#modal_purchase_date').val(purchaseDate);
        $('#modal_price').val(price);
        $('#modal_registration_no').val(registrationNo);
        $('#modal_registration_date').val(registrationDate);
        $('#modal_bill_no').val(billNo);
        $('#modal_fuel_type').val(fuelType);
        $('#modal_ownership').val(ownership);

        // Open the modal
        $('#editModal').modal('show');
    });

    // When the form is submitted (after editing)
    $('#editForm').on('submit', function(e) {
		
        e.preventDefault();  // Prevent form from submitting normally

        // Gather data from the modal form fields
        const formData = {
            request_id: $('#modal_request_id').val(),
            brand: $('#modal_brand').val(),
            model_name: $('#modal_model_name').val(),
            model_no: $('#modal_model_no').val(),
            dealer_name: $('#modal_dealer_name').val(),
            dealer_contact: $('#modal_dealer_contact').val(),
            purchase_date: $('#modal_purchase_date').val(),
            price: $('#modal_price').val(),
            registration_no: $('#modal_registration_no').val(),
            registration_date: $('#modal_registration_date').val(),
            bill_no: $('#modal_bill_no').val(),
            fuel_type: $('#modal_fuel_type').val(),
            ownership: $('#modal_ownership').val()
        };
        const token = $('input[name="_token"]').val();

        // Send the data via AJAX to update the record in the database
        $.ajax({
            url: '/update-vehicle',  // Update with your endpoint URL
            type: 'POST',
            data: formData,
			headers: {
                'X-CSRF-TOKEN': token // Send CSRF token in the request header
            },
            success: function(response) {
               // Handle success
			   if (response.success) {
                    // Show a success toast notification with custom settings
                    toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                    });
            
                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        $('#assetRequestForm')[0].reset();  // Reset the form
                        location.reload();  // Optionally, reload the page
                    }, 3000); // Delay before reset and reload to match the toast timeout
            
                } else {
                    // Show an error toast notification with custom settings
                    toastr.error('Error: ' + response.message, 'Error', {
                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                    });
                }
            },
			error: function (xhr, status, error) {
                // Handle error
                toastr.error('An error occurred. Please try again.', 'Error', {
                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                });
            
                // Re-enable submit button
                $('.btn-success').prop('disabled', false).text('Submit');
            }
        });
    });
	});


// Handle form submission with AJAX
document.getElementById('approvalForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission
       $('#loader').show();

    var form = new FormData(this); // Collect form data
    var url = '{{ route('approve.request') }}'; // The route to send the request

    fetch(url, {
        method: 'POST',
        body: form,
    })
    .then(response => response.json()) // Parse the JSON response
    .then(response => {
        // Handle success
        if (response.success) {
		    $('#loader').hide();

            // Show a success toast notification with custom settings
            toastr.success(response.message, 'Success', {
                "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
            });

            // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
            setTimeout(function () {
                $('#approvalForm')[0].reset();  // Reset the form
                location.reload();  // Optionally, reload the page
            }, 3000); // Delay before reset and reload to match the toast timeout

        } else {
            // Show an error toast notification with custom settings
            toastr.error('Error: ' + response.message, 'Error', {
                "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
            });
			    $('#loader').hide();

        }

        // Re-enable submit button
        $('.btn-success').prop('disabled', false).text('Submit');
    })
    .catch(error => {
        // Handle error
        toastr.error('An error occurred. Please try again.', 'Error', {
            "positionClass": "toast-top-right",  // Position the toast at the top-right corner
            "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
        });

    $('#loader').hide();

        // Re-enable submit button
        $('.btn-success').prop('disabled', false).text('Submit');
    });
});

$('#approvalModal').on('show.bs.modal', function (event) {

	function formatDateddmmyyyy(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');  // Ensures two digits for day
            const month = String(d.getMonth() + 1).padStart(2, '0');  // Ensures two digits for month
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;  // Format as dd-mm-yyyy
        }
    var button = $(event.relatedTarget); // Button that triggered the modal
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
	today = yyyy + '-' + mm + '-' + dd;

    // Extract data attributes from the button
    var requestId = button.data('request-id');
    var emplyeeid = button.data('employee-id');

    var employeeName = button.data('employee-name');
    var reqAmt = button.data('req-amt');
    var reqDate = button.data('req-date');
    var approvalStatusHOD = button.data('approval-status-hod');
    var approvalStatusIT = button.data('approval-status-it');
    var approvalStatusAcct = button.data('approval-status-acct');
    var approvalStatusRep = button.data('approval-status-hod');
    var employeeIdHOD = button.data('employee-id-hod');
    var employeeIdIT = button.data('employee-id-it');
    var employeeIdAcct = button.data('employee-id-acct');
    var employeeIdRep = button.data('employee-id-rep');
    var acctamountapproval = button.data('approvalamt');
	console.log(acctamountapproval);

	var reqspan = formatDateddmmyyyy(reqDate);
	console.log(reqspan);

    // Populate modal fields
    $('#request_id').val(requestId);
    $('#employee_id').val(emplyeeid);
    $('#employee_name').val(employeeName);
    $('#employee_name_span').text(employeeName);
    $('#req_amt').val(reqAmt);
    $('#req_amt_span').text(reqAmt);
    $('#reg_Date').val(reqspan);
	$('#approval_date').val(today);
    $('#reg_Date_span').text(reqspan);
    $('#acctamountapproval').text(acctamountapproval);
   console.log(acctamountapproval);

    // Employee ID from auth
    var EmployeeID = {{ Auth::user()->EmployeeID }};
	if(EmployeeID ==  employeeIdAcct){
		$('#approval_amount_div').show(); // Set the hidden input value

	}
	else{
		$('#approval_amount_div').hide(); // Set the hidden input value

	}
    // Function to handle status display for specific roles
    function displayApprovalStatus(employeeRoleId,approvalStatus) {
        if (EmployeeID == employeeRoleId && approvalStatus == 2) {
            var statusText = approvalStatus == 2 ? "Approved" : approvalStatus == 3 ? "Rejected" : "Pending";
            $('#approval_status').hide(); // Hide the dropdown
            $('#approval_amt').hide(); // Hide the dropdown
            $('#approval_status').prop('required', false); // Remove required attribute
            $('#approval_status_hidden').val(approvalStatus); // Set the hidden input value

            $('#approval_status_display').text(`${statusText}`).show(); // Display status text
            $('#approval_amt_display').text(`${acctamountapproval}`).show(); // Display status text

			$('.sel_arrow').hide();
			$('#submit_button').hide();


        }
		else {
            // Show the dropdown and the arrow if no role-specific status applies
            $('#approval_status').show();
            $('#approval_status').prop('required', true);
            $('#approval_status_display').hide();
            $('.sel_arrow').show();
			$('#submit_button').show();

        }
    }
	

    // Logic for roles
    displayApprovalStatus(employeeIdHOD, approvalStatusHOD);
    displayApprovalStatus(employeeIdIT, approvalStatusIT);
    displayApprovalStatus(employeeIdAcct, approvalStatusAcct);
    displayApprovalStatus(employeeIdRep, approvalStatusRep);
});

$(document).ready(function () {
    // Handle form submission with AJAX
    $('#assetRequestForm').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission
		$('#assetRequestForm button[type="submit"]').prop('disabled', true);

        $('#loader').show();

        // Prepare form data (including files)
       // Prepare form data (including files)
var formData = new FormData(this);

// Loop through all the form data entries
for (var pair of formData.entries()) {
    // Check if the value is a File object (to exclude files from logging)
    if (pair[1] instanceof File) {
        // Skip file fields
        continue;
    }

    // Check if the 'maximum_limit' field is in the form data and the parent div is hidden
    if (pair[0] === 'maximum_limit') {
        // Check if the parent div of 'maximum_limit' (which is '#max_limit') is hidden
        if ($('#max_limit').is(':hidden')) {
            // Skip adding the 'maximum_limit' field to the FormData
            formData.delete(pair[0]); // Delete it from formData
            continue;

        }
    }

    // Log only the non-file data (text inputs, etc.)
    console.log(pair[0] + ': ' + pair[1]);
}
console.log(formData);


        // Make AJAX request to submit the form
        $.ajax({
            url: asseststoreUrl, // Your Laravel route to handle the form submission
            type: 'POST',
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type header
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is passed
            },
            success: function (response) {
                // Handle success
                if (response.success) {
                    $('#loader').hide();
					$('#assetRequestForm button[type="submit"]').prop('disabled', false);

                    // Show a success toast notification with custom settings
                    toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                    });
            
                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        $('#assetRequestForm')[0].reset();  // Reset the form
                        location.reload();  // Optionally, reload the page
                    }, 3000); // Delay before reset and reload to match the toast timeout
            
                } else {
                    // Show an error toast notification with custom settings
                    toastr.error('Error: ' + response.message, 'Error', {
                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                    });
                    $('#loader').hide();
					$('#assetRequestForm button[type="submit"]').prop('disabled', false);


                }
            
            },
            error: function (xhr, status, error) {
                // Handle error
                toastr.error('An error occurred. Please try again.', 'Error', {
                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                });
                $('#loader').hide();

            
                // Re-enable submit button
					$('#assetRequestForm button[type="submit"]').prop('disabled', false);
            }
            
        });
    });
});
// JavaScript to filter table rows based on selected leave status
$('#acctStatusFilter').change(function() {
    var selectedStatus = $(this).val(); // Get the selected leave status

    // Filter the table rows based on the selected status
    $('#assestapprovaltable tbody tr').each(function() {
        var rowStatus = $(this).data('status'); // Get the status from the data-status attribute

        // If no status is selected or if the status matches the selected one, show the row
        if (selectedStatus === "" || selectedStatus == rowStatus) {
            $(this).show(); // Show matching rows
        } else {
            $(this).hide(); // Hide non-matching rows
        }
    });
});

// Trigger the change event to apply the default filter (Pending) when the page loads
$(document).ready(function() {
    $('#acctStatusFilter').trigger('change'); // Trigger the change to apply default "Pending" filter
});
$('#assestapprovaltable').DataTable({
    "paging": true, // Enable pagination
    "lengthChange": true, // Enable the option to change the number of records per page (dropdown for page size)
    "searching": true, // Enable searching
    "ordering": false, // Enable column ordering
    "info": false, // Show table information
    "autoWidth": false, // Disable auto width calculation
    "pageLength": 10, // Set number of rows per page (default)
    "lengthMenu": [10, 25, 50, 100], // Options for page size dropdown
    "order": [[5, 'desc']] // Sort by resignation date descending
});
	</script>
	
	<script src="{{ asset('../js/dynamicjs/assests.js/') }}" defer></script>
	    <style>
    #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.spinner-border {
    width: 3rem;
    height: 3rem;
}
</style>