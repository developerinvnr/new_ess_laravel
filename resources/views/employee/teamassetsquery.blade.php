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
                    <div class="mfh-machine-profile">
						<ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
							<li class="nav-item">
								<a style="color: #0e0e0e;" class="nav-link active" id="reporting-tab1" data-bs-toggle="tab" href="#reportingtab" role="tab" aria-controls="reporting" aria-selected="true">Reporting</a>
							</li>
							<li class="nav-item">
								<a style="color: #0e0e0e;" class="nav-link" id="reviewer-tab2" data-bs-toggle="tab" href="#reviewer" role="tab" aria-controls="reviewer" aria-selected="false">HOD/Reviewer</a>
							</li>
						</ul>
					
					<div class="tab-content ad-content2" id="myTabContent2">
                        <div class="tab-pane fade active show" id="reportingtab" role="tabpanel">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="row">
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
									<h5><b>Team: Assets </b></h5>
								</div>
								<div class="card-body table-responsive">
									<table class="table">
										<thead class="thead-light" style="background-color:#f1f1f1;">
											<tr>
												<th>SN</th>
												<th>EmployeeID</th>
												<th>Asset ID</th>
												<th>Req Amt</th>
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
											@if($assets_request->isEmpty())
											<!-- If there are no records, display a message -->
											<tr>
												<td colspan="16" class="text-center no-record-found" style="
												background-color: #fff3cd;
												color: #664d03;
												padding: 2px;
												font-size: 12px
												font-weight: bold;
												border-radius: 4px;
												border: 1px solid #ffecb5;
												text-align: center;
												margin-top: 10px;">No Asset's Request found</td>
											</tr>
											@else
											<!-- If there are records, display them -->
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
															data-request-id="{{ $request->AssetEmpReqId }}"
															data-employee-id="{{ $request->EmployeeID }}"
															data-employee-name="{{ $request->employee_name }}"
															data-asset-id="{{ $request->AssetNId }}"
															data-req-amt="{{ $request->ReqAmt }}"
															data-req-date="{{ $request->ReqDate }}"
															data-req-amt-per-month="{{ $request->ReqAmtPerMonth }}"
															data-model-name="{{ $request->ModelName }}"
															data-company-name="{{ $request->ComName }}"
															data-dealer-number="{{ $request->DealerContNo }}"

															@if(Auth::user()->EmployeeID == $request->HodId || Auth::user()->EmployeeID == $request->ReportingId)
															data-hod-approval-status="{{ $request->HODApprovalStatus }}"
															data-hod-remark="{{ $request->HODRemark }}"
															data-hod-subdate="{{ $request->HODSubDate }}"
															@elseif(Auth::user()->EmployeeID == $request->ITId)
															data-it-approval-status="{{ $request->ITApprovalStatus }}"
															data-it-remark="{{ $request->ITRemark }}"
															data-it-subdate="{{ $request->ITSubDate }}"
															@elseif(Auth::user()->EmployeeID == $request->AccId)
															data-acc-approval-status="{{ $request->AccPayStatus }}"
															data-acc-remark="{{ $request->AccRemark }}"
															data-acc-subdate="{{ $request->AccSubDate }}"
															@endif
													>
														Action
													</button>
												</td>
											</tr>
											@endforeach
																	@endif
																</tbody>
															</table>
														</div>
													</div>
					</div>
					
					
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-header pb-0">
										<h5><b>Team: Queries</b></h5>

									</div>
									<div class="card-body table-responsive">
										<table class="table" id="employeeQueryListTable">
											<thead class="thead-light" style="background-color:#f1f1f1;">
												<tr style="background-color:#ddd;">
													<th>SN</th>
													<th>Employee Details</th>
													<th>Query Details</th>
													<th>Emp Status</th>
													<th>Level 1 Status</th>
													<th>Level 2 Status</th>
													<th>Level 3 Status</th>

													<th>Management Action</th>
													<th>Take Action</th>
												</tr>
											</thead>
											<tbody id="employeeQueryTableBody">
												<!-- Dynamic content for employee-specific queries will be inserted here -->
											</tbody>
										</table>
										<p id="noEmployeeQueriesMessage" class="text-center no-record-found" style="display: none;">No queries found for this employee.</p>

										<!-- Message to show if no queries -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade " id="reviewer" role="tabpanel">
					no data
											</div>
			</div>
		</div>
                </div>
                
				@include('employee.footerbottom')

            </div>
        </div>
    </div>
	
	<div class="modal fade show" id="approvalpopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">Approval Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
		<div class="mb-4">
			<label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label>
			<span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3 Days</b></small></span>
		</div>
		<p>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days. i will resume work from. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>            
        </div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        
        </div>
      </div>
      </div>
    </div>
		<!--Attendence Authorisation modal for reporting-->
		<div class="modal fade" id="AttendenceAuthorisationRequest" tabindex="-1"
			aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-md modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Attendance Authorization</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">

						<p>This option is only for missed attendance or late In-time/early out-time attendance and not
							for
							leave applications. <span class="text-danger">Do not apply leave here.</span></p>
						<br>
						<p><span id="request-date-repo"></span></p>
						<form id="attendance-form" method="POST" action="">
							<input type="hidden" id="employeeIdInput" name="employeeId">

							@csrf
							<div class="form-group s-opt" id="statusGroupIn" style="display: none;">
								<label class="col-form-label">In Status:</label>
								<select name="inStatus" class="select2 form-control select-opt" id="inStatusDropdown">
									<option value="approved">Approved</option>
									<option value="rejected">Rejected</option>
								</select>
								<span class="sel_arrow">
									<i class="fa fa-angle-down"></i>
								</span>
							</div>
							<div class="form-group" id="reasonInGroupReq" style="display: none;">
								<label class="col-form-label">Reason In:</label>
								<span id="reasonInDisplay" class="form-control"
									style="border: none; background: none;"></span>
							</div>
							<div class="form-group" id="remarkInGroupReq" style="display: none;">
								<label class="col-form-label">Remark In:</label>
								<input type="text" name="remarkIn" class="form-control" id="remarkInReq" readonly>
							</div>
							<div class="form-group" id="reportRemarkInGroup" style="display: none;">
								<label class="col-form-label">Reporting Remark In:</label>
								<input type="text" name="reportRemarkIn" class="form-control" id="reportRemarkInReq">
							</div>
							<div class="form-group s-opt" id="statusGroupOut" style="display: none;">
								<label class="col-form-label">Out Status:</label>
								<select name="outStatus" class="select2 form-control select-opt" id="outStatusDropdown">
									<option value="approved">Approved</option>
									<option value="rejected">Rejected</option>
								</select>
								<span class="sel_arrow">
									<i class="fa fa-angle-down"></i>
								</span>
							</div>
							<div class="form-group" id="reasonOutGroupReq" style="display: none;">
								<label class="col-form-label">Reason Out:</label>
								<span id="reasonOutDisplay" class="form-control"
									style="border: none; background: none;"></span>
							</div>

							<div class="form-group" id="remarkOutGroupReq" style="display: none;">
								<label class="col-form-label">Remark Out:</label>
								<input type="text" name="remarkOut" class="form-control" id="remarkOutReq" readonly>
							</div>
							<div class="form-group" id="reportRemarkOutGroup" style="display: none;">
								<label class="col-form-label">Reporting Remark Out:</label>
								<input type="text" name="reportRemarkOut" class="form-control" id="reportRemarkOutReq">
							</div>
							<div class="form-group s-opt" id="statusGroupOther" style="display: none;">
								<label class="col-form-label">Other Status:</label>
								<select name="otherStatus" class="select2 form-control select-opt"
									id="otherStatusDropdown">
									<option value="approved">Approved</option>
									<option value="rejected">Rejected</option>
								</select>
								<span class="sel_arrow">
									<i class="fa fa-angle-down"></i>
								</span>
							</div>

							<div class="form-group" id="reasonOtherGroupReq" style="display: none;">
								<label class="col-form-label">Reason :</label>
								<span id="reasonOtherDisplay" class="form-control"
									style="border: none; background: none;"></span>
							</div>

							<div class="form-group" id="remarkOtherGroupReq" style="display: none;">
								<label class="col-form-label">Remark :</label>
								<input type="text" name="remarkOther" class="form-control" id="remarkOtherReq" readonly>
							</div>

							<div class="form-group" id="reportRemarkOtherGroup" style="display: none;">
								<label class="col-form-label">Reporting Remark Other:</label>
								<input type="text" name="reportRemarkOther" class="form-control"
									id="reportRemarkOtherReq">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
							data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="sendButtonReq">Send</button>
					</div>
				</div>
			</div>
		</div>

	<!--Approval Message-->
    <div class="modal fade show" id="querypopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle3">Query Details</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
		<p><b>Department - Admin</b></p>
		<p><b>Subject - ----</b></p>
		<p>
		<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even</p> <br>
		<p>Raise Date:15 May 2024</p>
			<table class="table table-border mt-2">
				<thead>
					<tr><td>Level 1</td><td>Level 2</td><td>Level 3</td></tr>
				</thead>
				<tr>
					<td><b>Done</b></td><td><b>Open<b></td><td><b>Pending</b></td>
				<tr>
				<tr>
					<td>16 May</td><td>19 May</td><td>Pending</td>
				<tr>
			</table>
			</div>
        <div class="modal-footer">
        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        
        </div>
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

						<div class="mb-3 form-group s-opt">
							<label for="approval_status" class="form-label">Approval Status</label>
							<select class="select2 form-control select-opt" id="approval_status" name="approval_status"
								required>
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
	const getqueriesUrl = "{{ route("employee.queries") }}";

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>