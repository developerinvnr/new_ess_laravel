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
                    @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('leaveApplications')->flatten()) > 0)

						<div class="card ad-info-card-">
							<div class="card-header">
								
								<div class="">
								<h5 style="float:left;"><b>My Team Leave</b></h5>
								<div class="flex-shrink-0" style="float:right;">
									<div class="form-check form-switch form-switch-right form-switch-md">
										<!-- <label for="base-class" class="form-label text-muted mt-1">HOD/Reviewer</label> -->
										<!-- <input class="form-check-input code-switcher" type="checkbox" id="base-class"> -->
									</div>
								</div>
								</div>
							</div>
							<!-- <div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
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
                            </div> -->
							<div class="card-body table-responsive">
								<table class="table text-center">
									<thead>
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
											<th>Leave Type</th>
											<th>From Date</th>
											<th>To Date</th>
											<th class="text-center">Total Days</th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@php
											$hasPendingRequests = false;
										@endphp

										@foreach($attendanceData as $data)
											@foreach($data['leaveApplications'] as $index => $leave)
												@php
													$hasPendingRequests = true; // Set to true if there's at least one leave application
												@endphp
												@php
													// Find the matching balance for the current employee and leave type
													$balance = collect($data['leaveBalances'])->firstWhere('EmployeeID', $leave->EmployeeID);
													$balanceValue = null;

													// Determine balance based on Leave_Type
													if ($leave->Leave_Type == 'CL') {
														$balanceValue = $balance->BalanceCL ?? 'N/A';
													} elseif ($leave->Leave_Type == 'SL') {
														$balanceValue = $balance->BalanceSL ?? 'N/A';
													} elseif ($leave->Leave_Type == 'PL') {
														$balanceValue = $balance->BalancePL ?? 'N/A';
													} elseif ($leave->Leave_Type == 'EL') {
														$balanceValue = $balance->BalanceEL ?? 'N/A';
													}
												@endphp
												<tr>
													<td>{{ $index + 1 }}</td>
													<!-- Concatenate First Name and Last Name -->
													<td>{{ $leave->Fname . ' ' . $leave->Sname ?? 'N/A' }}</td>
													<td>{{ $leave->EmpCode ?? 'N/A' }}</td>
													<td>{{ $leave->Leave_Type ?? 'N/A' }}</td>
													<td>{{ $leave->Apply_FromDate ?? 'N/A' }}</td>
													<td>{{ $leave->Apply_ToDate ?? 'N/A' }}</td>
													<td>{{ $leave->Apply_TotalDay ?? 'N/A' }}</td>
													<td>{{ $leave->Apply_Reason ?? 'N/A' }}</td>
													<td>-</td>
													<td>{{ $balanceValue }}</td> <!-- Displaying the leave balance -->
													<td>
														@switch($leave->LeaveStatus)
															@case(0)
																Draft
																@break
															@case(1)
																Pending
																@break
															@case(2)
																Approved
																@break
															@case(3)
																Reject
																@break
															@case(4)
																Cancelled
																@break
															@default
																N/A
														@endswitch
													</td>
													<td>
														<!-- Action buttons logic based on LeaveStatus -->
														@if(in_array($leave->LeaveStatus, [0, 3, 4]))
															<!-- Pending state: show Approval and Reject buttons -->
															<button class="mb-0 sm-btn mr-1 effect-btn btn btn-success accept-btn" 
																style="padding: 4px 10px; font-size: 10px;"
																data-employee="{{ $leave->EmployeeID }}"
																data-name="{{ $leave->Fname }} {{ $leave->Sname }}"
																data-from_date="{{ $leave->Apply_FromDate }}"
																data-to_date="{{ $leave->Apply_ToDate }}"
																data-reason="{{ $leave->Apply_Reason }}"
																data-total_days="{{ $leave->Apply_TotalDay }}"
																data-leavetype="{{ $leave->Leave_Type }}"
																data-leavecancellation="{{ $leave->LeaveStatus }}"
																data-leavetype_day="{{ $leave->half_define }}">
																Approval
															</button>
															<button class="mb-0 sm-btn effect-btn btn btn-danger reject-btn"
																style="padding: 4px 10px; font-size: 10px;"
																data-employee="{{ $leave->EmployeeID }}"
																data-name="{{ $leave->Fname }} {{ $leave->Sname }}"
																data-from_date="{{ $leave->Apply_FromDate }}"
																data-to_date="{{ $leave->Apply_ToDate }}"
																data-reason="{{ $leave->Apply_Reason }}"
																data-total_days="{{ $leave->Apply_TotalDay }}"
																data-leavetype="{{ $leave->Leave_Type }}"
																data-leavecancellation="{{ $leave->LeaveStatus }}"
																data-leavetype_day="{{ $leave->half_define }}">
																Reject
															</button>
														@elseif($leave->LeaveStatus == 1)
															<!-- Approved state: display Approved status -->
															<a href="#" class="mb-0 sm-btn mr-1 effect-btn btn btn-warning accept-btn" style="padding: 4px 10px; font-size: 10px;" title="Pending">Pending</a>
														@elseif($leave->LeaveStatus == 2)
															<!-- Rejected state: display Rejected status -->
															<a href="#" class="mb-0 sm-btn effect-btn btn btn-success reject-btn"style="padding: 4px 10px; font-size: 10px;" title="Approved">Approved</a>
                                                            @elseif($leave->LeaveStatus == 3)
															<!-- Rejected state: display Rejected status -->
															<a href="#" class="mb-0 sm-btn effect-btn btn btn-danger reject-btn"style="padding: 4px 10px; font-size: 10px;" title="Rejected">Rejected</a>
														
                                                            @endif
													</td>
												</tr>
											@endforeach
										@endforeach

										<!-- Display the "No Pending Requests" message if there are no pending requests -->
										@if (!$hasPendingRequests)
											<tr>
												<td colspan="12" class="text-center">
													<div class="alert alert-secondary animated-alert" role="alert">
														<i class="fas fa-info-circle"></i> No Pending Requests
													</div>
												</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
                            @endif


						</div>
                        @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('attendnacerequest')->flatten()) > 0)
						<div class="card ad-info-card-">
							<div class="card-header">
								<div class="">
									<h5><b>Team Attendance</b></h5>
								</div>
							</div>
							<div class="card-body table-responsive">
								<table class="table text-center">
									<thead>
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th>Request Date</th>
											<th>Attendance Date</th>
											<th>Remarks</th>
											<th>Status</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@php
											$hasPendingRequests = false;
										@endphp

										@foreach($attendanceData as $data)
											@foreach($data['attendnacerequest'] as $index => $attendanceRequest)
												@php
													// Check if there is at least one pending request
													if ($attendanceRequest->Status == 0) {
														$hasPendingRequests = true;
													}
												@endphp
												<tr>
													<td>{{ $index + 1 }}</td>
													<td>{{ $attendanceRequest->Fname . ' ' . $attendanceRequest->Sname ?? 'N/A' }}</td>
													<td>{{ $attendanceRequest->EmpCode ?? 'N/A' }}</td>
													<td>{{ $attendanceRequest->created_at ?? 'N/A' }}</td>
													<td>{{ $attendanceRequest->AttDate ?? 'N/A' }}</td>
													<td>
														@if(!empty($attendanceRequest->InRemark))
															{{ $attendanceRequest->InRemark }}
														@elseif(!empty($attendanceRequest->OutRemark))
															{{ $attendanceRequest->OutRemark }}
														@else
															{{ $attendanceRequest->Remark ?? 'N/A' }}
														@endif
													</td>  
													<td>
														@switch($attendanceRequest->Status)
															@case(0)
																Pending
																@break
															@case(1)
																Approved
																@break
															@case(2)
																Rejected
																@break
															@case(3)
																Draft
																@break
															@case(4)
																Cancelled
																@break
															@default
																N/A
														@endswitch
													</td>
													<td>
														<!-- Check if the status is pending (0) -->
														@if($attendanceRequest->Status == 0) 
															<!-- Pending: show Approval and Reject buttons -->
															<div class="float-end">
																<a href="#" 
																	style="padding: 4px 10px; font-size: 10px;" 
																	class="mb-0 sm-btn mr-1 effect-btn btn btn-success approval-btn" 
																	title="Approval" 
																	data-bs-toggle="modal" 
																	data-bs-target="#AttendenceAuthorisationRequest"
																	data-request-date="{{ \Carbon\Carbon::parse($attendanceRequest->AttDate)->format('d/m/Y') }}"
																	data-in-reason="{{ empty($attendanceRequest->InReason) ? 'N/A' : $attendanceRequest->InReason }}"
																	data-in-remark="{{ empty($attendanceRequest->InRemark) ? 'N/A' : $attendanceRequest->InRemark }}"
																	data-out-reason="{{ empty($attendanceRequest->OutReason) ? 'N/A' : $attendanceRequest->OutReason }}"
																	data-out-remark="{{ empty($attendanceRequest->OutRemark) ? 'N/A' : $attendanceRequest->OutRemark }}"
																	data-other-reason="{{ empty($attendanceRequest->Reason) ? 'N/A' : $attendanceRequest->Reason }}"
																	data-other-remark="{{ empty($attendanceRequest->Remark) ? 'N/A' : $attendanceRequest->Remark }}"
																	data-inn-time="{{ empty($attendanceRequest->InTime) ? 'N/A' : $attendanceRequest->InTime }}"
																	data-out-time="{{ empty($attendanceRequest->OutTime) ? 'N/A' : $attendanceRequest->OutTime }}"
																	data-employee-id="{{ $attendanceRequest->EmployeeID ?? 'N/A' }}">
																	Approval
																</a>

																<a href="#" 
																	style="padding: 4px 10px; font-size: 10px;" 
																	class="mb-0 sm-btn effect-btn btn btn-danger reject-btn" 
																	title="Reject" 
																	data-bs-toggle="modal" 
																	data-bs-target="#AttendenceAuthorisationRequest"
																	data-request-date="{{ \Carbon\Carbon::parse($attendanceRequest->AttDate)->format('d/m/Y') }}"
																	data-in-reason="{{ empty($attendanceRequest->InReason) ? 'N/A' : $attendanceRequest->InReason }}"
																	data-in-remark="{{ empty($attendanceRequest->InRemark) ? 'N/A' : $attendanceRequest->InRemark }}"
																	data-out-reason="{{ empty($attendanceRequest->OutReason) ? 'N/A' : $attendanceRequest->OutReason }}"
																	data-out-remark="{{ empty($attendanceRequest->OutRemark) ? 'N/A' : $attendanceRequest->OutRemark }}"
																	data-other-reason="{{ empty($attendanceRequest->Reason) ? 'N/A' : $attendanceRequest->Reason }}"
																	data-other-remark="{{ empty($attendanceRequest->Remark) ? 'N/A' : $attendanceRequest->Remark }}"
																	data-inn-time="{{ empty($attendanceRequest->InTime) ? 'N/A' : $attendanceRequest->InTime }}"
																	data-out-time="{{ empty($attendanceRequest->OutTime) ? 'N/A' : $attendanceRequest->OutTime }}"
																	data-employee-id="{{ $attendanceRequest->EmployeeID ?? 'N/A' }}">
																	Reject
																</a>
															</div>
														@elseif($attendanceRequest->Status == 1) 
															<!-- Approved: show Approved message -->
															<span class="badge bg-success">Approved</span>
														@elseif($attendanceRequest->Status == 2) 
															<!-- Rejected: show Rejected message -->
															<span class="badge bg-danger">Rejected</span>
														@elseif($attendanceRequest->Status == 3) 
															<!-- Draft: show Draft message -->
															<span class="badge bg-warning">Draft</span>
														@elseif($attendanceRequest->Status == 4) 
															<!-- Cancelled: show Cancelled message -->
															<span class="badge bg-secondary">Cancelled</span>
														@endif
													</td>
												</tr>
											@endforeach
										@endforeach

										<!-- Display the "No Pending Requests" message if there are no pending requests -->
										@if (!$hasPendingRequests)
											<tr>
												<td colspan="8" class="text-center">
													<div class="alert alert-secondary animated-alert" role="alert">
														<i class="fas fa-info-circle"></i> No Pending Requests
													</div>
												</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
						</div>
                        @endif


						
						<div class="card ad-info-card-">
                            <div class="card-header">
                                <div class="">
                                    <h5><b>My Team</b></h5>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>EC</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Grade</th>
                                            <th>Function</th>
                                            <th>Vertical</th>
                                            <th>Departments</th>
                                            <!-- <th>Sub Departments</th> -->
                                            <!-- <th>Location</th> -->
                                            <th>History</th>
                                            <th>KRA</th>
                                            <th>Eligibility</th>
                                            <th>CTC</th>
                                            <th>Team</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    @if(count($employeeData) > 0)
                                    @php
                                        $indexX =1;
                                        @endphp
                                     @foreach($employeeData as $index => $employeeE)
                                     @foreach($employeeE as  $employee)

                                            <tr>
                                                <td>{{ $indexX ++ }}</td> <!-- Serial number -->
                                                
                                                <!-- Employee EC -->
                                                <td>{{ $employee->EmpCode ?? 'N/A' }}</td>
                                                <!-- Employee Name -->
                                                <td style="text-align:left;">{{ ($employee->Fname ?? 'N/A') . ' ' . ($employee->Sname ?? 'N/A') . ' ' . ($employee->Lname ?? 'N/A') }}</td>

                                                

                                                <!-- Designation -->
                                                <td style="text-align:left;">{{ $employee->DesigCode ?? 'N/A' }}</td>

                                                <!-- Grade -->
                                                <td>{{ $employee->GradeValue ?? 'N/A' }}</td>

                                                <!-- Function (could be another field, or leave it blank) -->
                                                <td>-</td>

                                                <!-- Vertical -->
                                                <td>{{ $employee->VerticalName ?? 'N/A' }}</td>

                                                <!-- Departments -->
                                                <td>{{ $employee->DepartmentCode ?? 'N/A' }}</td>

                                                <!-- Sub Departments (you might need to fetch or display another field here) -->
                                                <!-- <td>-</td> -->


                                                <!-- History (Example: could be a date or status change) -->
                                                <td>-</td>

                                                <!-- KRA (Key Responsibility Areas, if available) -->
                                                <td>-</td>

                                                <!-- Eligibility (Eligibility for promotion, benefits, etc.) -->
                                                <td>
                                                    <a href="{{ route('teameligibility') }}" style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                                        Click
                                                    </a>
                                                </td>

                                                <!-- CTC -->
                                                <!-- <td>{{ $employee->CTC ?? 'N/A' }}</td> -->
                                                <td>-</td>
                                                <td>-</td>

   
                                            </tr>
                                            @endforeach
                                            @endforeach

                                        @else
                                            <!-- Display message if no data -->
                                            <tr>
                                                <td colspan="17" class="text-center">
                                                    <div class="alert alert-secondary" role="alert">
                                                        <i class="fas fa-info-circle"></i> No Team Members Found
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>



<!-- 
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
								</ul> -->
								<!-- You can also dump $employeeChain to check if it is null or not -->
								
								<!-- <div class="tab-content ad-content2" id="myTabContent2">
									<div class="tab-pane fade active show" id="MyteamTab" role="MyteamTab">
										<div class="card chart-card">
											<div class="card-body table-responsive">
												<div>
													<label for="levelSelect">Select Level:</label>
													<select id="levelSelect"> -->
														<!-- Dynamic Options will be added here -->
													<!-- </select>
												</div> -->
												<!-- <div id="employeeTreeContainer"> -->
													<!-- Tree or employee data will go here -->
												<!-- </div>
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
		</div> -->

		

		  <!--Attendence Authorisation modal for reporting-->
		  <div class="modal fade" id="AttendenceAuthorisationRequest" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>This option is only for missed attendance or late In-time/early out-time attendance and not for
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
                            <select name="otherStatus" class="select2 form-control select-opt" id="otherStatusDropdown">
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
                            <input type="text" name="reportRemarkOther" class="form-control" id="reportRemarkOtherReq">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-primary" id="sendButtonReq">Send</button>
                </div>
            </div>
        </div>
    </div>

		<!-- LeaveAuthorization modal  -->
		<div class="modal fade" id="LeaveAuthorisation" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#76a0a3;" >
                <h5 class="modal-title">Leave Authorization</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="responseMessageleave" style="display: none;"></p>

                <form id="leaveAuthorizationForm" method="POST" action="{{ route('leave.authorize') }}">
                    @csrf

                    <!-- Employee Name -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="employeename" class="col-form-label">Employee Name:</label>
                            <span id="employeename"></span> <!-- Show the Employee Name here -->
                        </div>
                    </div>

                    <!-- Leave Type -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="leavetype" class="col-form-label">Leave Type:</label>
                            <span id="leavetype"></span> <!-- Show the Leave Type here -->
                        </div>
                    </div>

                    <!-- From Date -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="from_date" class="col-form-label">From Date:</label>
                            <span id="from_date"></span> <!-- Show the From Date here -->
                        </div>
                    </div>

                    <!-- To Date -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="to_date" class="col-form-label">To Date:</label>
                            <span id="to_date"></span> <!-- Show the To Date here -->
                        </div>
                    </div>

                    <!-- Total Days -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="total_days" class="col-form-label">Total Days:</label>
                            <span id="total_days"></span> <!-- Show the Total Days here -->
                        </div>
                    </div>

                    <!-- Leave Reason -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="leavereason" class="col-form-label">Leave Reason:</label>
                            <span id="leavereason"></span> <!-- Show the Leave Reason here -->
                        </div>
                    </div>

                    <!-- Leave Option -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="leavetype_day" class="col-form-label">Leave Option:</label>
                            <span id="leavetype_day"></span> <!-- Show the Leave Option here -->
                        </div>
                    </div>

                    <!-- Status -->

                    <div class="row mb-3" id="statusGroupIn">
                                <label class="col-form-label">Status:</label>
                                <select name="Status" class="select2 form-control form-select select-opt" id="StatusDropdown">
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>

                            </div>
                    <!-- Remarks -->
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
		<script>
			

$(document).ready(function () {
    $('#sendButtonleave').on('click', function (event) {
        event.preventDefault(); // Prevent the default form submission
        $('#loader').show(); 
        // Gather form data
        var formData = {
                    employeename: $('#employeename').text(),  // Use .text() for displaying values instead of .val() for inputs
                    leavetype: $('#leavetype').text(),
                    from_date: $('#from_date').text(),
                    to_date: $('#to_date').text(),
                    total_days: $('#total_days').text(),
                    leavereason: $('#leavereason').text(),
                    leavetype_day: $('#leavetype_day').text(),
                    Status: $('#StatusDropdown').val(),
                    remarks: $('#remarks_leave').val(),
                    employeeId: $('#leaveAuthorizationForm').data('employeeId'), // Get employee ID
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                };
        // AJAX request to send data to the controller
        $.ajax({
            url: '{{ route('leave.authorize') }}', // Update with your route
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success == true) {
                   $('#loader').hide(); 
                    console.log(response)
                    // if (response.message == "Leave Rejected successfully." || response.message == "Leave already rejected.") {
                        // Show toast with error message
                        toastr.success(response.message, 'Success', {
                            "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            "timeOut": 5000  // Duration for which the toast is visible (in ms)
                        });
                    // }
                    // else {
                    //     // Show toast with success message
                    //     toastr.success(response.message, 'Success', {
                    //         "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    //         "timeOut": 5000  // Duration for which the toast is visible (in ms)
                    //     });
                    // }
                    // Optionally close the modal and reload the page after a delay
                    // setTimeout(() => {
                    //     $('#LeaveAuthorisation').modal('hide'); // Close modal
                    //     location.reload(); // Reload the page
                    // }, 3000);
                } else {
                    // Show error toast when the response is unsuccessful
                    // toastr.error('Leave rejected. Please check the details.', 'Error', {
                    //     "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    //     "timeOut": 5000  // Duration for which the toast is visible (in ms)
                    // });
                    toastr.error(response.message, 'Error', {
                            "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            "timeOut": 5000  // Duration for which the toast is visible (in ms)
                        });
                    // setTimeout(() => {
                    //     location.reload(); // Reload the page after a delay
                    // }, 5000);
                }
            },
            error: function (xhr) {
                // Handle any errors from the server
                toastr.error('An error occurred. Please try again.', 'Error', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
            }
        });
    });
});
const modal = document.getElementById('AttendenceAuthorisationRequest');
        let inn_time; // Declare variables in the outer scope
        let out_time;
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const employeeId = button.getAttribute('data-employee-id'); // Get employee ID
            // Determine if the button is for approval or rejection
            const isApproval = button.classList.contains('approval-btn');
            const isReject = button.classList.contains('reject-btn');
            // Get dropdown elements
            const inStatusDropdown = document.getElementById('inStatusDropdown');
            const outStatusDropdown = document.getElementById('outStatusDropdown');
            const otherStatusDropdown = document.getElementById('otherStatusDropdown');
            // Preselect dropdown values based on the button clicked
            if (isApproval) {
                inStatusDropdown.value = 'approved';
                outStatusDropdown.value = 'approved';
                otherStatusDropdown.value = 'approved';
            } else if (isReject) {
                inStatusDropdown.value = 'rejected';
                outStatusDropdown.value = 'rejected';
                otherStatusDropdown.value = 'rejected';
            }
            // Set employee ID in a hidden input (to be submitted later)
            document.getElementById('employeeIdInput').value = employeeId;
            // Retrieve and display request-related information
            const requestDate = button.getAttribute('data-request-date');
            // Split the input date string to get day, month, and year
            const dateParts = requestDate.split('/');
            // Create a new Date object from the parts (Note: months are 0-based, so subtract 1 from the month)
            const dateObj = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
            // Define an array of month names
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            // Format the date
            const formattedDate = `${dateObj.getDate()}-${monthNames[dateObj.getMonth()]}-${dateObj.getFullYear()}`;
            // Set the formatted date in the textContent
            document.getElementById('request-date-repo').textContent = `Requested Date: ${formattedDate}`;
            // Reset all groups to be hidden initially
            const groups = [
                'statusGroupIn',
                'statusGroupOut',
                'statusGroupOther',
                'reasonInGroupReq',
                'reasonOutGroupReq',
                'reasonOtherGroupReq',
                'remarkInGroupReq',
                'remarkOutGroupReq',
                'remarkOtherGroupReq',
                'reportRemarkInGroup',
                'reportRemarkOutGroup',
                'reportRemarkOtherGroup'
            ];
            groups.forEach(group => {
                document.getElementById(group).style.display = 'none';
            });
            // Validate reasons
            const inReason = button.getAttribute('data-in-reason');
            const outReason = button.getAttribute('data-out-reason');
            const otherReason = button.getAttribute('data-other-reason');
            const isInReasonValid = inReason !== 'N/A';
            const isOutReasonValid = outReason !== 'N/A';
            const isOtherReasonValid = otherReason !== 'N/A';
            // Show sections based on reason validity
            if (isInReasonValid && isOutReasonValid) {
                // Show both "In" and "Out" sections
                document.getElementById('statusGroupIn').style.display = 'block';
                document.getElementById('reasonInGroupReq').style.display = 'block';
                document.getElementById('remarkInGroupReq').style.display = 'block';
                document.getElementById('reportRemarkInGroup').style.display = 'block';
                document.getElementById('reasonInDisplay').textContent = inReason;
                document.getElementById('remarkInReq').value = button.getAttribute('data-in-remark');
                document.getElementById('statusGroupOut').style.display = 'block';
                document.getElementById('reasonOutGroupReq').style.display = 'block';
                document.getElementById('remarkOutGroupReq').style.display = 'block';
                document.getElementById('reportRemarkOutGroup').style.display = 'block';
                document.getElementById('reasonOutDisplay').textContent = outReason;
                document.getElementById('remarkOutReq').value = button.getAttribute('data-out-remark');
            } else if (isInReasonValid) {
                // Show only "In" section
                document.getElementById('statusGroupIn').style.display = 'block';
                document.getElementById('reasonInGroupReq').style.display = 'block';
                document.getElementById('remarkInGroupReq').style.display = 'block';
                document.getElementById('reportRemarkInGroup').style.display = 'block';
                document.getElementById('reasonInDisplay').textContent = inReason;
                document.getElementById('remarkInReq').value = button.getAttribute('data-in-remark');
            } else if (isOutReasonValid) {
                // Show only "Out" section
                document.getElementById('statusGroupOut').style.display = 'block';
                document.getElementById('reasonOutGroupReq').style.display = 'block';
                document.getElementById('remarkOutGroupReq').style.display = 'block';
                document.getElementById('reportRemarkOutGroup').style.display = 'block';
                document.getElementById('reasonOutDisplay').textContent = outReason;
                document.getElementById('remarkOutReq').value = button.getAttribute('data-out-remark');
            } else if (!isInReasonValid && !isOutReasonValid && isOtherReasonValid) {
                // Show "Other" section only
                document.getElementById('statusGroupOther').style.display = 'block';
                document.getElementById('reasonOtherGroupReq').style.display = 'block';
                document.getElementById('remarkOtherGroupReq').style.display = 'block';
                document.getElementById('reportRemarkOtherGroup').style.display = 'block';
                document.getElementById('reasonOtherDisplay').textContent = otherReason;
                document.getElementById('remarkOtherReq').value = button.getAttribute('data-other-remark');
            }
        });
        document.getElementById('sendButtonReq').addEventListener('click', function () {
            const requestDateText = document.getElementById('request-date-repo').textContent;
            const requestDate = requestDateText.replace('Requested Date: ', '').trim();
            const employeeId = document.getElementById('employeeIdInput').value; // Get employee ID from hidden input
            const repo_employeeId = {{ Auth::user()->EmployeeID }};
            // Prepare the data to be sent
            const formData = new FormData();
            formData.append('requestDate', requestDate);
            // Check visibility before appending values
            if (document.getElementById('statusGroupIn').style.display !== 'none') {
                const inStatus = document.getElementById('inStatusDropdown').value;
                const inReason = document.getElementById('reasonInDisplay').textContent;
                const inRemark = document.getElementById('remarkInReq').value;
                const reportRemarkIn = document.getElementById('reportRemarkInReq').value;
                if (inReason && inStatus) { // Append only if reason and status are valid
                    formData.append('inStatus', inStatus);
                    formData.append('inReason', inReason);
                    formData.append('inRemark', inRemark);
                    formData.append('reportRemarkIn', reportRemarkIn);
                }
            }
            if (document.getElementById('statusGroupOut').style.display !== 'none') {
                const outStatus = document.getElementById('outStatusDropdown').value;
                const outReason = document.getElementById('reasonOutDisplay').textContent;
                const outRemark = document.getElementById('remarkOutReq').value;
                const reportRemarkOut = document.getElementById('reportRemarkOutReq').value;
                if (outReason && outStatus) { // Append only if reason and status are valid
                    formData.append('outStatus', outStatus);
                    formData.append('outReason', outReason);
                    formData.append('outRemark', outRemark);
                    formData.append('reportRemarkOut', reportRemarkOut);
                }
            }
            if (document.getElementById('statusGroupOther').style.display !== 'none') {
                const otherStatus = document.getElementById('otherStatusDropdown').value;
                const otherReason = document.getElementById('reasonOtherDisplay').textContent;
                const otherRemark = document.getElementById('remarkOtherReq').value;
                const reportRemarkOther = document.getElementById('reportRemarkOtherReq').value;
                if (otherReason) { // Append only if reason is valid
                    formData.append('otherStatus', otherStatus);
                    formData.append('otherReason', otherReason);
                    formData.append('otherRemark', otherRemark);
                    formData.append('reportRemarkOther', reportRemarkOther);
                }
            }
            formData.append('employeeid', employeeId);
            formData.append('repo_employeeId', repo_employeeId);
            formData.append('inn_time', inn_time);
            formData.append('out_time', out_time);
            formData.append('_token', document.querySelector('input[name="_token"]').value); // CSRF token
            // Send the data using fetch
            fetch(`/attendance/updatestatus`, {
                method: 'POST',
                body: formData,
            })
                .then(response => {
                    // Log the raw response for debugging
                    return response.text().then(text => {
                            console.log('Raw response:', text); // Log the raw response
                            
                            // Check if the response is OK (status in the range 200-299)
                            if (response.ok) {
                                // Check if the response text is not empty
                                if (text) {
                                    toastr.success('Data Update Successfully!', 'Success', {
                                        "positionClass": "toast-top-right",  // Position it at the top-right of the screen
                                        "timeOut": 5000  // Duration for which the toast is visible (in ms)
                                    });
                                    return JSON.parse(text); // Parse JSON if text is not empty
                                } else {
                                    toastr.error('Empty response from server.', 'Error', {
                                        "positionClass": "toast-top-right",  // Position it at the top-right of the screen
                                        "timeOut": 5000  // Duration for which the toast is visible (in ms)
                                    });
                                    throw new Error('Empty response from server');
                                }
                            } else {
                                toastr.error(text, 'Error', {
                                    "positionClass": "toast-top-right",  // Position it at the top-right of the screen
                                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                                });
                                throw new Error(text); // Reject with the raw text if not OK
                            }
                        });
                })
                
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Error:', error);
                    alert('There was a problem with your fetch operation: ' + error.message);
                });
        });
        function stripHtml(html) {
            const div = document.createElement('div');
            div.innerHTML = html;
            return div.textContent || div.innerText || '';
        }
		</script>
		<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>
		<style>
			/* Ensure the "animated-alert" class is added to your custom alert div */
.animated-alert {
    font-size: 15;
    font-weight: bold;
    color: black;
    background-color: #a9cbcd; /* Info Blue */
    border-radius: 8px;
    padding: 2px;
    margin-top: 10px;
    animation: fadeInUp 1s ease-out;
    display: inline-block;
    width: 100%;
    text-align: center;
    margin: 20px auto;
}

/* Add animation effect for the fade-in and slide-up */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Icon style next to the message */
.animated-alert i {
    margin-right: 10px;
    font-size: 24px;
    vertical-align: middle;
}

/* Hover effect on the message */
.animated-alert:hover {
    transform: scale(1.05);
    cursor: pointer;
    transition: transform 0.3s ease;
}

		</style>