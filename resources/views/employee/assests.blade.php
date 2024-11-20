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
					<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
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
													<td>{{ $asset->AssetId }}</td>
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
													<td>{{ $request->AssetNId == 1 ? 'Laptop' : 'Other' }}</td>
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
																<i class="fas fa-eye me-2"></i> View 
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																data-file-url="{{ asset('storage/' . $request->bill_copy) }}" 
																data-file-type="bill">
																<i class="fas fa-eye me-2"></i> View 
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
																	<i class="fas fa-eye me-2"></i> View 
																	</a>
																@else
																	<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																	data-file-url="{{ asset('storage/' . $request->asset_copy) }}" 
																	data-file-type="asset">
																	<i class="fas fa-eye me-2"></i> View 
																	</a>
																@endif
															@else
																<span>No Asset</span>
															@endif
														</td>

													<td>{{ $request->IdentityRemark }}</td>
													<td>
														<button type="button" style="padding:6px 13px;font-size: 11px;"
															class="btn-outline success-outline sm-btn" data-bs-toggle="modal"
															data-bs-target="#assetdetails"
															data-request-date="{{ \Carbon\Carbon::parse($request->ReqDate)->format('d M Y') }}"
															data-asset-type="{{ $request->AssetNId == 1 ? 'Laptop' : 'Other' }}"
															data-price="{{ number_format($request->Price, 2) }}"
															data-req-amt="{{ number_format($request->ReqAmt, 2) }}"
															data-approval-amt="{{ number_format($request->ApprovalAmt, 2) }}"
															data-bill-copy="{{ asset('storage/' . $request->bill_copy) }}"
															data-asset-copy="{{ asset('storage/' . $request->asset_copy) }}"
															data-identity-remark="{{ $request->IdentityRemark }}">
															View
														</button>
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
														<td>{{ $request->HODApprovalStatus }}</td>
														<td>{{ $request->HODRemark }}</td>
														<td>{{ $request->HODSubDate }}</td>
													@elseif(Auth::user()->EmployeeID == $request->ITId)
														<!-- If the authenticated user is from IT -->
														<td>{{ $request->ITApprovalStatus }}</td>
														<td>{{ $request->ITRemark }}</td>
														<td>{{ $request->ITSubDate }}</td>
													@elseif(Auth::user()->EmployeeID == $request->AccId)
														<!-- If the authenticated user is from Accounts -->
														<td>{{ $request->AccPayStatus }}</td>
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
																<i class="fas fa-eye me-2"></i> View PDF
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																data-file-url="{{ asset('storage/' . $request->bill_copy) }}" 
																data-file-type="bill">
																<i class="fas fa-eye me-2"></i> View Image
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
																<i class="fas fa-eye me-2"></i> View PDF
																</a>
															@else
																<a href="#" data-bs-toggle="modal" data-bs-target="#fileModal"
																data-file-url="{{ asset('storage/' . $request->asset_copy) }}" 
																data-file-type="asset">
																<i class="fas fa-eye me-2"></i> View Image
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
														<button class="btn btn-link collapsed w-100" type="button"
															data-bs-toggle="collapse" data-bs-target="#collapseTwok"
															aria-expanded="false" aria-controls="collapseTwok">
															My Asset Request Form
															<i class="fa fa-angle-down float-end"></i>
														</button>
													</h2>
												</div>
												<div id="collapseTwok" class="collapse" aria-labelledby="headingTwok"
													data-bs-parent="#accordionExample">
													<div id="messageDiv"></div>
													<!-- Here the success/error messages will be displayed -->
													<form id="assetRequestForm" method="POST"
														enctype="multipart/form-data">
														@csrf
														<div class="row">
															<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
																<p>CC to your reporting manager & HOD</p>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group s-opt">
																	<label for="asset" class="col-form-label"><b>Select
																			Asset Name</b></label>

																	<select class="form-control" id="asset"
																		name="asset">
																		<option value="" disabled selected>Select Asset
																			Name</option> <!-- Static first option -->

																		@foreach ($assets as $asset)
																			<option value="{{ $asset->AssetNId }}"
																				data-limit="{{ $asset->AssetLimit }}">
																				{{ $asset->AssetName }}
																			</option>
																		@endforeach
																	</select>
																	<span class="sel_arrow">
																		<i class="fa fa-angle-down "></i>
																	</span>
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="maximum_limit"
																		class="col-form-label"><b>Maximum
																			Limit</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter maximum limit"
																		id="maximum_limit" name="maximum_limit"
																		readonly>
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="model_name"
																		class="col-form-label"><b>Model Name</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter model name" id="model_name"
																		name="model_name" fdprocessedid="zpsebq">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="model_no"
																		class="col-form-label"><b>Model
																			Number</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter modal number" id="model_no"
																		name="model_no" fdprocessedid="mro7tc">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="company_name"
																		class="col-form-label"><b>Company
																			Name</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter company name"
																		id="company_name" name="company_name"
																		fdprocessedid="glqpk">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="purchase_date"
																		class="col-form-label"><b>Purchase
																			Date</b></label>
																	<input class="form-control" type="text"
																		placeholder="Purchase Date" id="purchase_date"
																		name="purchase_date" fdprocessedid="glqpk">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="dealer_name"
																		class="col-form-label"><b>Dealer
																			Name</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter dealer name" id="dealer_name"
																		name="dealer_name" fdprocessedid="mro7tc">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="dealer_contact"
																		class="col-form-label"><b>Dealer
																			Contact</b></label>
																	<input class="form-control" type="number"
																		placeholder="Enter dealer contact number"
																		id="dealer_contact" name="dealer_contact"
																		fdprocessedid="glqpk">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="price"
																		class="col-form-label"><b>Price</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter price" id="price"
																		name="price" fdprocessedid="mro7tc">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="bill_number"
																		class="col-form-label"><b>Bill
																			Number</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter bill number" id="bill_number"
																		name="bill_number" fdprocessedid="glqpk">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="request_amount"
																		class="col-form-label"><b>Request
																			Amount</b></label>
																	<input class="form-control" type="number"
																		placeholder="Enter request amount"
																		id="request_amount" name="request_amount"
																		fdprocessedid="mro7tc">
																</div>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="iemi_no" class="col-form-label"><b>IMEI
																			No.:</b></label>
																	<input class="form-control" type="text"
																		placeholder="Enter IMEI number" id="iemi_no"
																		name="iemi_no" fdprocessedid="glqpk">
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="bill_copy"
																		class="col-form-label"><b>Bill Copy</b></label>
																	<input class="form-control" id="bill_copy"
																		name="bill_copy" type="file" />
																</div>
															</div>
															<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="asset_copy"
																		class="col-form-label"><b>Asset Copy</b></label>
																	<input class="form-control" id="asset_copy"
																		name="asset_copy" type="file" />
																</div>
															</div>
															<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
																<div class="form-group">
																	<label for="remarks"
																		class="col-form-label"><b>Remarks</b></label>
																	<textarea class="form-control"
																		placeholder="Additional Remarks" id="remarks"
																		name="remarks"></textarea>
																</div>
															</div>
															<div class="form-group mb-0">
																<button class="btn btn-primary" type="button"
																	fdprocessedid="yed9j">Reset</button>
																<input class="btn btn-success" type="submit"
																	fdprocessedid="l9oz0g">
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
						@if($AssetRequest->isNotEmpty())
							<div class="card chart-card">
								<div class="card-header">
									<h4 class="has-btn">Approval Status</h4>
								</div>
								<div class="card-body">
									@foreach($AssetRequest as $index => $request)
										<!-- HOD Approval Section -->
										<div class="exp-details-box">
											<span 
												@if($request->HODApprovalStatus == 1) 
													style="background-color: #0d9137;margin-top:15px;" 
												@else 
													style="background-color: #dba62f;margin-top:15px;" 
												@endif
												class="exp-round">&nbsp;</span>
											<div class="exp-line">
												<h6 class="mb-2 pt-3" style="color:#0d9137;">
													@if($request->HODApprovalStatus == 1)
														Level 1
													@else
														Pending HOD Approval
													@endif
												</h6>
												<h5>HOD/Reporting Section</h5>
												<p>{{ $request->HODSubDate ?? 'Date Not Available' }}</p>
												<p>
													@if($request->HODApprovalStatus == 1)
														<P>{{$request->HODRemark}}</P>
													@else
													<P>{{$request->HODRemark}}</P>
													@endif
												</p>
											</div>
										</div>

										<!-- Level 2 (IT Section) -->
										<div class="exp-details-box">
											<span 
												@if($request->ITApprovalStatus == 1) 
													style="background-color: #0d9137;margin-top:15px;" 
												@else 
													style="background-color: #dba62f;margin-top:15px;" 
												@endif
												class="exp-round">&nbsp;</span>
											<div class="exp-line">
												<h6 class="mb-2 pt-3" style="color:#0d9137;">
													@if($request->ITApprovalStatus == 1)
														Level 2
													@else
														Pending IT Approval
													@endif
												</h6>
												<h5>IT Section</h5>
												<p>{{ $request->ITSubDate ?? 'Date Not Available' }}</p>
												<p>
													@if($request->ITApprovalStatus == 1)
													<P>{{$request->ITRemark}}</P>

													@else
													<P>{{$request->ITRemark}}</P>
													@endif
												</p>
											</div>
										</div>

										<!-- Level 3 (Acc Section) -->
										<div class="exp-details-box">
											<span 
												@if($request->AccPayStatus == 1) 
													style="background-color: #0d9137;margin-top:15px;" 
												@else 
													style="background-color: #dba62f;margin-top:15px;" 
												@endif
												class="exp-round">&nbsp;</span>
											<div class="exp-line">
												<h6 class="mb-2 pt-3" style="color:#9f9f9f;">
													@if($request->AccPayStatus == 1)
														Level 3
													@else
														Pending Accounts Approval
													@endif
												</h6>
												<h5>Accounts Section</h5>
												<p>{{ $request->AccSubDate ?? 'Date Not Available' }}</p>
												<p>
													@if($request->AccPayStatus == 1)
														<P>{{$request->AccRemark}}</P>
													@else
														<P>{{$request->AccRemark}}</P>
													@endif
												</p>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						@endif
					</div>
				</div>
				<!-- Revanue Status Start -->
				<div class="row">

				</div>

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
						<select class="select2 form-control select-opt" id="approval_status" name="approval_status" required>
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
				<button class="carousel-control-prev" type="button" data-bs-target="#pdfCarousel" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>

				<!-- Custom Next Button -->
				<button class="carousel-control-next" type="button" data-bs-target="#pdfCarousel" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>

            </div>
        </div>
    </div>
</div>


	@include('employee.footer');
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script>
		$(document).ready(function () {
			// Handle form submission with AJAX
			$('#assetRequestForm').submit(function (e) {
				e.preventDefault(); // Prevent the default form submission

				// Prepare form data (including files)
				var formData = new FormData(this);

				// Show loader (optional, for better UX)
				$('.btn-success').prop('disabled', true).text('Submitting...');

				// Make AJAX request to submit the form
				$.ajax({
					url: '{{ route('asset.request.store') }}', // Your Laravel route to handle the form submission
					type: 'POST',
					data: formData,
					processData: false, // Don't process the data
					contentType: false, // Don't set content type header
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is passed
					},
					success: function (response) {
						// Handle success
						var messageDiv = $('#messageDiv');  // The div where the message will be shown

						if (response.success) {
							// Reset the form
							messageDiv.html('<div class="alert alert-success">' + response.message + '</div>');

							// Optionally, hide the success message after a few seconds (e.g., 3 seconds)
							setTimeout(function () {
								$('#assetRequestForm')[0].reset();
								messageDiv.html(''); // Clear the message div
							}, 5000);

						} else {
							// Error message
							messageDiv.html('<div class="alert alert-danger">Error: ' + response.message + '</div>');
						}

						// Re-enable submit button
						$('.btn-success').prop('disabled', false).text('Submit');
					},
					error: function (xhr, status, error) {
						// Handle error
						alert('An error occurred. Please try again.');

						// Re-enable submit button
						$('.btn-success').prop('disabled', false).text('Submit');
					}
				});
			});
		});
		// When an asset is selected
		$('#asset').on('change', function () {
			// Get the selected option
			var selectedOption = $(this).find('option:selected');

			// Retrieve the asset limit from the data attribute
			var limit = selectedOption.data('limit');

			// Set the maximum limit value to the input field
			$('#maximum_limit').val(limit);
		});
		$('#fileModal').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var fileUrl = button.data('file-url');
			var fileType = button.data('file-type');

			var filePreviewContainer = $('#filePreviewContainer');

			filePreviewContainer.empty();

			if (fileType === 'bill' || fileType === 'asset') {
				var imageElement = $('<img />', {
					src: fileUrl,
					class: 'img-fluid',
					alt: 'File preview',
				});

				filePreviewContainer.append(imageElement);
			} else {
				filePreviewContainer.append('<p>Unsupported file type</p>');
			}
		});
		$('#pdfModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var fileUrl = button.data('file-url'); // Extract file URL (PDF URL)
    
    var pdfCarouselContent = $('#pdfCarouselContent');
    var pdfCarousel = $('#pdfCarousel');
    
    pdfCarouselContent.empty(); // Clear carousel content
    
    // Hide carousel initially
    pdfCarousel.hide();
    
    // Load the PDF
    var loadingTask = pdfjsLib.getDocument(fileUrl);
    
    loadingTask.promise.then(function (pdf) {
        var totalPages = pdf.numPages;
        
        // Render all pages and add to the carousel
        for (var pageNum = 1; pageNum <= totalPages; pageNum++) {
            renderPage(pdf, pageNum);
        }
        
        // Show the carousel after rendering pages
        pdfCarousel.show();
    }).catch(function (error) {
        console.error('Error loading PDF: ' + error);
        pdfCarouselContent.append('<p>Unable to load PDF</p>');
    });
    
    // Render a specific page of the PDF in the carousel
    function renderPage(pdf, pageNum) {
        pdf.getPage(pageNum).then(function (page) {
            // Set a fixed height of 500px for the PDF container
            var fixedHeight = 800;

            // Calculate scale based on fixed height (preserving aspect ratio)
            var scale = fixedHeight / page.getViewport({ scale: 1 }).height;

            var viewport = page.getViewport({ scale: scale });
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render the page
            page.render({ canvasContext: context, viewport: viewport }).promise.then(function () {
                // Add rendered page to carousel
                var isActive = pageNum === 1 ? 'active' : ''; // First page is active
                var slide = $('<div class="carousel-item ' + isActive + '">')
                    .append(canvas);
                
                pdfCarouselContent.append(slide);
            });
        });
    }
});

		// When the modal is shown, populate it with dynamic data
		$('#assetdetails').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget); // Button that triggered the modal

			// Extract data attributes from the button
			var requestDate = button.data('request-date');
			var assetType = button.data('asset-type');
			var price = button.data('price');
			var reqAmt = button.data('req-amt');
			var approvalAmt = button.data('approval-amt');
			var billCopy = button.data('bill-copy');
			var assetCopy = button.data('asset-copy');
			var identityRemark = button.data('identity-remark');

			// Populate the modal with the extracted data
			$('#modalRequestDate').text(requestDate);
			$('#modalAssetType').text(assetType);
			$('#modalPrice').text(price);
			$('#modalReqAmt').text(reqAmt);
			$('#modalApprovalAmt').text(approvalAmt);
			$('#modalIdentityRemark').text(identityRemark);

			// Update the modal image sources
			$('#modalBillCopy').attr('src', billCopy || ''); // if no bill copy, leave empty
			$('#modalAssetCopy').attr('src', assetCopy || ''); // if no asset copy, leave empty
		});
		
		
		// approval js 
		$('#approvalModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var assestsid = button.data('request-id');
        var employeeId = button.data('employee-id');
        var employeeName = button.data('employee-name');
        var assetId = button.data('asset-id');
        var reqAmt = button.data('req-amt');
        var reqDate = button.data('req-date');
        var reqAmtPerMonth = button.data('req-amt-per-month');
        var modelName = button.data('model-name');
        var companyName = button.data('company-name');
        var dealerNumber = button.data('dealer-number');
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0');
		var yyyy = today.getFullYear();
		
		today = yyyy + '-' + mm + '-' + dd;
        var employeeIds = {{ Auth::user()->EmployeeID }};

		
        // Set values in the modal form fields
        $('#assestsid').val(assestsid);
        $('#employee_id').val(employeeId);
        $('#employee_name').val(employeeName); // Display Employee Name
        $('#asset_id').val(assetId);
        $('#req_amt').val(reqAmt);
        $('#approval_status').val('');
        $('#remark').val('');
        $('#reg_Date').val(reqDate);
		$('#approval_date').val(today);  // Set the value of the input
		$('#employeeId').val(employeeIds);  // Set the value of the input

    });

	</script>