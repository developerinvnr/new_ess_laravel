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
									<li class="breadcrumb-link active">My Team - Details</li>
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
						<div class="card ad-info-card-">
							<div class="card-header">
								
								<div class="">
								<h5 style="float:left;"><b>My Team Leave</b></h5>
								<div class="flex-shrink-0" style="float:right;">
									<div class="form-check form-switch form-switch-right form-switch-md">
										<label for="base-class" class="form-label text-muted mt-1">HOD/Reviewer</label>
										<input class="form-check-input code-switcher" type="checkbox" id="base-class">
									</div>
								</div>
								</div>
							</div>
							<div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
								<table class="table text-center">
									<thead >
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th colspan="4" class="text-center">Request</th>
											<th>Description</th>
											<th>Location</th>
											<th>Balance</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
										<tr>
											<th></th>
											<th></th>
											<th></th>
											<th>leave</th>
											<th>From Date</th>
											<th>To Date</th>
											<th class="text-center">Total Day</th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
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
						
						<div class="card ad-info-card-">
							<div class="card-header">
								
								<div class="">
								<h5><b>Team Attendance</b></h5>
								
								</div>
							</div>
							<div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
								<table class="table text-center">
									<thead>
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th>Request Date</th>
											<th>Attendance Date</th>
											<th>Remarks</th>
											<th>Balance</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
                            </div>
						</div>
						
						<div class="card ad-info-card-">
							<div class="card-header">
								<div class="">
								<h5><b>My Team</b></h5>
								</div>
							</div>
							<div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
								<table class="table text-center">
									<thead >
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th>Designation</th>
											<th>Grade</th>
											<th>Function</th>
											<th>Vertical</th>
											<th>Depatments</th>
											<th>Sub Departments</th>
											<th>Status</th>
											<th>Location</th>
											<th>History</th>
											<th>KRA</th>
											<th>Eligibility</th>
											<th>CTC</th>
											<th>Team</th>
											<th>Action</th>
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
											<td></td>
											<td></td>
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







					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6">
								<div class="card ad-info-card-" id="requestcardsattendance">
									<div class="card-header">
										<h5><b>Team:  Attendance Approval</b></h5>
									</div>
									<div class="card-body" id="requestCards"
										style="height:300px;overflow-y:auto;overflow-x:hidden;">
										<div class="card p-3 mb-3" style="border:1px solid #ddd;">
										</div>
										<div class="tree col-md-12 text-center mt-4">
										</div>
										<p id="attendancedatanotfound" style="display: none;">No queries
											found for this employee.
										</p>

									</div>
								</div>
							</div>

							<div class="col-xl-6 col-lg-6 col-md-6">
								<div class="card ad-info-card-" id="leavemainrequest">
									<div class="card-header">
										<!-- <img style="width:35px;" class="float-start me-3" src="./images/icons/icon3.png"> -->
										<h5><b>Team: Leave approval</b></h5>
									</div>

									<div class="card-body" id="leaveRequestsContainer"
										style="height:300px;overflow-y:auto;overflow-x:hidden;">
										<div class="card p-3 mb-3" style="border:1px solid #ddd;">
										</div>
										<div class="tree col-md-12 text-center mt-4">
										</div>
										<p id="noEmployeeLeaveMessage" style="display: none;">No Leave
											found for Team.
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>

					@if(count($employeeChain ?? []) > 0)
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="mfh-machine-profile">
								<ul class="nav nav-tabs" id="myTab1" role="tablist" style="background-color:#a5cccd;border-radius: 10px 10px 0px 0px;">
									<li class="nav-item">
										<a style="color: #0e0e0e;" class="nav-link active" id="myteam" data-bs-toggle="tab" href="#MyteamTab" role="tab" aria-controls="MyteamTab" aria-selected="false">My team</a>
									</li>
									<li class="nav-item d-none">
										<a style="color: #0e0e0e;" class="nav-link" id="attendance" data-bs-toggle="tab" href="#AttendanceTab" role="tab" aria-controls="AttendanceTab" aria-selected="false">Attendance</a>
									</li>
								</ul>
								<!-- You can also dump $employeeChain to check if it is null or not -->
								
								<div class="tab-content ad-content2" id="myTabContent2">
									<div class="tab-pane fade active show" id="MyteamTab" role="MyteamTab">
										<div class="card chart-card">
											<div class="card-body table-responsive">
												<div>
													<label for="levelSelect">Select Level:</label>
													<select id="levelSelect">
														<!-- Dynamic Options will be added here -->
													</select>
												</div>
												<div id="employeeTreeContainer">
													<!-- Tree or employee data will go here -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif


					@include('employee.footerbottom')

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

		<!-- LeaveAuthorization modal  -->
		<div class="modal fade" id="LeaveAuthorisation" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
			aria-hidden="true">
			<div class="modal-dialog modal-md modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Leave Authorization</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<p id="responseMessageleave" style="display: none;"></p>

						<form id="leaveAuthorizationForm" method="POST" action="{{ route('leave.authorize') }}">
							@csrf

							<div class="row mb-3">
								<div class="col-md-6">
									<label for="employeename" class="col-form-label">Employee Name:</label>
									<input type="text" name="employeename" class="form-control" id="employeename"
										readonly>
								</div>
								<div class="col-md-6">
									<label for="leavetype" class="col-form-label">Leave Type:</label>
									<input type="text" name="leavetype" class="form-control" id="leavetype" readonly>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-6">
									<label for="from_date" class="col-form-label">From Date:</label>
									<input type="text" name="from_date" class="form-control" id="from_date" readonly>
								</div>
								<div class="col-md-6">
									<label for="to_date" class="col-form-label">To Date:</label>
									<input type="text" name="to_date" class="form-control" id="to_date" readonly>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-6">
									<label for="total_days" class="col-form-label">Total Days:</label>
									<input type="text" name="total_days" class="form-control" id="total_days" readonly>
								</div>
								<div class="col-md-6">
									<label for="leavereason" class="col-form-label">Leave Reason:</label>
									<input type="text" name="leavereason" class="form-control" id="leavereason"
										readonly>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-6">
									<label for="leavetype_day" class="col-form-label">Leave Option:</label>
									<input type="text" name="leavetype_day" class="form-control" id="leavetype_day"
										readonly>
								</div>
								<div class="col-md-6 form-group s-opt" id="statusGroupIn">
									<label class="col-form-label">Status:</label>
									<select name="Status" class="select2 form-control select-opt" id="StatusDropdown">
										<option value="approved">Approved</option>
										<option value="rejected">Rejected</option>
									</select>
									<span class="sel_arrow">
										<i class="fa fa-angle-down"></i>
									</span>
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-md-12">
									<label for="remarks" class="col-form-label">Remarks:</label>
									<input type="text" name="remarks_leave" class="form-control" id="remarks_leave"
										placeholder="Enter your remarks">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
							data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="sendButtonleave">Send</button>
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
                  <div class="form-group">
                     <label for="status">Status</label>
                     <select id="status" class="form-control" name="status">
                        <option value="0">Open</option>
                        <option value="1">In Progress</option>
                        <option value="2">Reply</option>
                        <option value="4">Esclose</option>
                        <option value="3">Closed</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="reply">Reply</label>
                     <textarea id="reply" class="form-control" name="reply" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                     <label for="forwardTo">Forward To</label>
                     <select id="forwardTo" class="form-control" name="forwardTo">
                        <option value="0">Select a Forward To</option>
                        <!-- Default option with value 0 -->
                     </select>
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
					<form action="{{ route('approve.request.team') }}" method="POST" id="approvalForm">
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
			var employeeChainDatatojs = @json($employeeChain); // Pass the PHP variable to JS


		</script>
		<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>