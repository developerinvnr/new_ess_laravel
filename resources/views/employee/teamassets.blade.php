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
                                    <li class="breadcrumb-link active">My Team - Assets & Query</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 @include('employee.menuteam')
                <!-- Revanue Status Start -->
                <div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="row">
							@if($isReviewer)
							<div class="flex-shrink-0" style="float:right;">
								<form method="GET" action="{{ route('teamassets') }}">
									@csrf
									<div class="form-check form-switch form-switch-right form-switch-md">
										<label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2"  style="float:right;">HOD/Reviewer</label>
										<input 
											class="form-check-input" 
											type="checkbox" 
											name="hod_view" 
											id="hod-view" 
											{{ request()->has('hod_view') ? 'checked' : '' }} 
											onchange="this.form.submit();" 
										>
									</div>
								</form>
							</div>
							@endif
							<!-- Asset Approval Status Section -->
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
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
					
								<div class="card chart-card">
									<div class="card-header">
										<h5 style="float:left;"><b>Team: Assets </b></h5>
									</div>
									@if(count($assets_request) > 0)
							

									<div class="card-body table-responsive" id="reportingsection">
									<table class="table">

									<thead class="thead-light" style="background-color:#f1f1f1;">
										<tr>
											<th>No.</th>
											<th>EC</th>
											<th>Employee Name</th>
											<th>Type of Assets</th>
											<th>Req Date</th>
											<th>Balance Amount</th>
											<th>Requested Amount</th>
											<th>Acct. Approval Amount</th>
											<th>Dealer Number</th>
											<th colspan="3" style="text-align: center;">Approval Status</th>  <!-- Main Approval Status Column with Sub-columns -->
											<th>Remark</th>
											<th>Approval Date</th>
											<th>Bill Copy</th>
											<th>Assets Copy</th>
											<th></th>
										</tr>
										<tr>
											<th></th>
											<th></th>
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
									@php
									$indexxx = 1;
									@endphp
									@foreach($assets_request as $index => $requests)
									@foreach($requests as $request)
									<tbody>
											<tr>
												
												<td>{{ $indexxx ++ }}</td>
												<td>{{ $request->EmpCode}}</td>
												<td>{{ $request->Fname }} {{ $request->Sname }} {{ $request->Lname }}</td>
												@php
													$assetName = \DB::table('hrm_asset_name') // Table name
																			->where('AssetNId', $request->AssetNId) // Column name in hrm_asset_name
																			->value('AssetName'); // Field to retrieve
														@endphp

												<td>{{ $assetName ?? 'N/A' }}</td> <!-- Display AssetName -->												<td>{{ \Carbon\Carbon::parse($request->ReqDate)->format('d-m-Y') }}</td>
												<td>
													{{ ($request->MaxLimitAmt - $request->ReqAmt)}}
												</td>
												<td>{{ $request->ReqAmt }}</td>
												<td>{{ $request->ApprovalAmt }}</td>
												<td>{{ $request->DealerContNo }}</td>

												<!-- Approval Status columns for HOD, IT, and Account -->
												<td>
									<!-- Display the approval status for HOD without checking user role -->
									@if($request->HODApprovalStatus == 2)
										Approved
									@elseif($request->HODApprovalStatus == 0)
										Draft
									@elseif($request->HODApprovalStatus == 3)
										Rejected
									@elseif($request->HODApprovalStatus == 1)
										Pending
									@else
										N/A
									@endif
												</td>

												<td>
													<!-- Display the approval status for IT without checking user role -->
													@if($request->ITApprovalStatus == 2)
														Approved
													@elseif($request->ITApprovalStatus == 3)
														Rejected
													@elseif($request->ITApprovalStatus == 1)
														Pending
													@elseif($request->ITApprovalStatus == 0)
														Draft
													@else
														N/A
													@endif
												</td>

												<td>
													<!-- Display the approval status for Accounts without checking user role -->
													@if($request->AccPayStatus == 2)
														Approved
													@elseif($request->AccPayStatus == 3)
														Rejected
													@elseif($request->AccPayStatus == 1)
														Pending
													@elseif($request->AccPayStatus == 0)
														Draft
													@else
														N/A
													@endif
												</td>

												<td>{{ $request->HODRemark }}</td>
												<td>{{ $request->HODSubDate }}</td>

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

												
											</tr>
									</tbody>
									@endforeach
                                    @endforeach
									</table>
									</div>
                                  

									@endif

						    	</div>
							</div>
						</div>
					</div>
				</div>
				@include('employee.footerbottom')
            </div>
        </div>
    </div>
	

	 <!-- Modal for taking action -->
	 <div id="actionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="actionModalLabel">Query Action</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div id="actionMessage" class="alert" style="display: none;">
                  <!-- This will display the message from the server -->
               </div>
               <form id="queryActionForm">
                  @csrf 
                  <!-- Form Fields -->
                  <div class="form-group">
                     <label for="querySubject">Subject</label>
                     <input type="text" id="querySubject" class="form-control" name="querySubject" readonly>
                  </div>
                  <div class="form-group">
                     <label for="querySubjectValue">Subject Details</label>
                     <input type="text" id="querySubjectValue" class="form-control" name="querySubjectValue"
                        readonly>
                  </div>
                  <div class="form-group">
                     <label for="queryName">Employee Name</label>
                     <input type="text" id="queryName" class="form-control" name="queryName" readonly>
                  </div>
                  <div class="form-group">
                     <label for="queryDepartment">Query Department</label>
                     <input type="text" id="queryDepartment" class="form-control" name="queryDepartment"
                        readonly>
                  </div>
                  <div class="form-group s-opt">
                     <label for="status">Status</label>
                     <select id="status" class="select2 form-control select-opt" name="status">
                        <option value="0">Open</option>
                        <option value="1">In Progress</option>
                        <option value="2">Reply</option>
                        <option value="4">Esclose</option>
                        <option value="3">Closed</option>
                     </select>
					 <span class="sel_arrow">
						<i class="fa fa-angle-down"></i>
					</span>
                  </div>
                  <div class="form-group">
                     <label for="reply">Reply</label>
                     <textarea id="reply" class="form-control" name="reply" rows="3"></textarea>
                  </div>
                  <div class="form-group s-opt">
                     <label for="forwardTo">Forward To</label>
                     <select id="forwardTo" class="select2 form-control select-opt" name="forwardTo">
                        <option value="0">Select a Forward To</option>
                        <!-- Default option with value 0 -->
                     </select>
					 <span class="sel_arrow">
						<i class="fa fa-angle-down"></i>
					</span>
                  </div>
                  <div class="form-group">
                     <label for="forwardReason">Forward Reason</label>
                     <textarea id="forwardReason" class="form-control" name="forwardReason" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Save Action</button>
               </form>
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

                    <div class="mb-3">
                        <label for="employee_name" class="form-label">Employee Name:</label>
                        <span id="employee_name_span"></span>  <!-- Display the Employee Name here -->
                        <input type="hidden" class="form-control" id="employee_name" readonly>  <!-- Hidden input to store value -->
                    </div>

                   

                    <div class="mb-3">
                        <label for="req_amt" class="form-label">Request Amount:</label>
                        <span id="req_amt_span"></span>  <!-- Display the Request Amount here -->
                        <input type="hidden" class="form-control" id="req_amt" readonly>  <!-- Hidden input to store value -->
                    </div>
					<div class="mb-3">
                        <label for="reg_Date" class="form-label">Reg Date:</label>
                        <span id="reg_Date_span"></span>  <!-- Display the Reg Date here -->
                        <input type="hidden" class="form-control" id="reg_Date" name="reg_Date" required readonly>  <!-- Hidden input to store value -->
                    </div>

                    <div class="mb-3 form-group s-opt">
                        <label for="approval_status" class="form-label">Approval Status</label>
                        <select class="select2 form-control select-opt" id="approval_status" name="approval_status" required>
                            <option value="">Select Status</option>
                            <option value="1">Approved</option>
                            <option value="0">Rejected</option>
                        </select>
                        <span class="sel_arrow">
                            <i class="fa fa-angle-down"></i>
                        </span>
                    </div>

                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark</label>
                        <textarea class="form-control" id="remark" name="remark" rows="3" required></textarea>
                    </div>

                    

                    <input type="hidden" id="employeeId" name="employeeId">
                    <input type="hidden" id="assestsid" name="assestsid">

                    <div class="mb-3">
                        <label for="approval_date" class="form-label">Approval Date:</label>
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
	const repo_employeeId = {{ Auth::user()->EmployeeID }};
	const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
	const queryactionUrl = "{{ route("employee.query.action") }}";
	const getqueriesUrl = "{{ route("employee.queries.repo") }}";

	$(".code-switcher").click(function() { 
		$("#reportingsection").toggle();
		$("#hodreviwersection").toggle();
	});

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>