@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
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
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">My Team - Attendance & Leave</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.menuteam')
                
              
                 <!-- Revanue Status Start -->
                 <div class="row">
                 <div class="flex-shrink-0" style="float:right;">
                                
                        @if($isReviewer)
                            <form method="GET" action="{{ route('teamleaveatt') }}">
                                @csrf
                                <div class="form-check form-switch form-switch-right form-switch-md">
                                    <label for="hod-view" class="form-label text-muted mt-1" style="float:right;">HOD/Reviewer</label>
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="hod_view" 
                                        id="hod-view" 
                                        {{ request()->has('hod_view') ? 'checked' : '' }} 
                                        onchange="this.form.submit();" 
                                    >
                                </div>
                                <input type="hidden" name="month" value="{{ request()->input('month', $selectedMonth) }}">

                            </form>
                        @endif
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="card ad-info-card-">
                        @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('leaveApplications')->flatten()) > 0)

						<div class="card-header">
								<div class="">
									<h5><b>Leave Request</b></h5>
								</div>
							</div>
						
						<!-- Check if any employee has leave applications -->
                                <div class="card-body" style="overflow-y: scroll;overflow-x: hidden;">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th>Sn</th>
                                                <th>Name</th>
                                                <th>EC</th>
                                                <th colspan="4" class="text-center">Request</th>
                                                <th>Description</th>
                                                
                                                <th>Status</th>
                                                @if(request()->get('hod_view') != 'on')
                                                            <th>Action</th>
                                                            @endif
                                                            @if(request()->get('hod_view') == 'on')
                                                            <th></th>
                                                            @endif
                                                <th></th>
                                                <th></th>


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
                                            @foreach($attendanceData as $data)
                                                @if(!empty($data['leaveApplications'])) <!-- Only display if leaveApplications is not empty -->
                                                    @foreach($data['leaveApplications'] as $index => $leave)
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
                                                            <td>{{ $leave->Fname . ' ' . $leave->Sname . ' ' . $leave->Lname ?? 'N/A' }}</td>
                                                            <td>{{ $leave->EmpCode ?? 'N/A' }}</td>
                                                            <td>{{ $leave->Leave_Type ?? 'N/A' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($leave->Apply_FromDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($leave->Apply_ToDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                            <td>{{ $leave->Apply_TotalDay ?? 'N/A' }}</td>
                                                            <td>{{ $leave->Apply_Reason ?? 'N/A' }}</td>
                                                            <td>
                                                                @switch($leave->LeaveStatus)
                                                                    @case(0)
                                                                        Reject
                                                                        @break
                                                                    @case(1)
                                                                        Approved
                                                                        @break
                                                                    @case(2)
                                                                        Approved
                                                                        @break
                                                                    @case(3)
                                                                         Pending
                                                                        @break
                                                                    @case(4)
                                                                        Cancelled
                                                                        @break
                                                                    @default
                                                                        N/A
                                                                @endswitch
                                                            </td>
                                                            @if(request()->get('hod_view') != 'on')
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
                                                                                <!-- Pending state: display Pending status and make it non-clickable -->
                                                                                <a href="#" class="mb-0 sm-btn mr-1 effect-btn btn btn-warning accept-btn" style="padding: 4px 10px; font-size: 10px; pointer-events: none; opacity: 0.6;" title="Pending" disabled>Pending</a>

                                                                            @elseif($leave->LeaveStatus == 2)
                                                                                <!-- Approved state: display Approved status and make it non-clickable -->
                                                                                <a href="#" class="mb-0 sm-btn effect-btn btn btn-success reject-btn" style="padding: 4px 10px; font-size: 10px; pointer-events: none; opacity: 0.6;" title="Approved" disabled>Approved</a>

                                                                            @elseif($leave->LeaveStatus == 3)
                                                                                <!-- Rejected state: display Rejected status and make it non-clickable -->
                                                                                <a href="#" class="mb-0 sm-btn effect-btn btn btn-danger reject-btn" style="padding: 4px 10px; font-size: 10px; pointer-events: none; opacity: 0.6;" title="Rejected" disabled>Rejected</a>
                                                                            @endif
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
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
							<div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
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
                                            @if(request()->get('hod_view') != 'on')
                                                            <th>Action</th>
                                                            @endif
                                                            @if(request()->get('hod_view') == 'on')
                                                            <th></th>
                                                            @endif
    										</tr>
									</thead>
									<tbody>
										

										@foreach($attendanceData as $data)
											@foreach($data['attendnacerequest'] as $index => $attendanceRequest)
											
												<tr>
													<td>{{ $index + 1 }}</td>
													<td>{{ $attendanceRequest->Fname . ' ' . $attendanceRequest->Sname . ' ' . $attendanceRequest->Lname ?? 'N/A' }}</td>
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
                                                    @if(request()->get('hod_view') != 'on')

													<td>
														<!-- Check if the status is pending (0) -->
														@if($attendanceRequest->Status == 0) 
															<!-- Pending: show Approval and Reject buttons -->
															<div>
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
																	class="mb-0 sm-btn effect-btn btn btn-danger rejection-btn" 
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
                                                    @endif
												</tr>
											@endforeach
										@endforeach

									</tbody>
								</table>
							</div>
						</div>
                        @endif
                </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="card ad-info-card-">
							<div class="card-header">
								<div class="">
								<h5><b>Attendance/Leave</b></h5>
								</div>
                                <div class="float-end" style="margin-top:-20px; display: flex; align-items: center; gap: 10px;">
                                <form method="GET" action="{{ route('teamleaveatt') }}">
                            <!-- Month Selector -->
                            <select name="month" onchange="this.form.submit()">
                                <option value="">Select Month</option>
                                <option value="1" {{ $selectedMonth == 1 ? 'selected' : '' }}>January</option>
                                <option value="2" {{ $selectedMonth == 2 ? 'selected' : '' }}>February</option>
                                <option value="3" {{ $selectedMonth == 3 ? 'selected' : '' }}>March</option>
                                <option value="4" {{ $selectedMonth == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ $selectedMonth == 5 ? 'selected' : '' }}>May</option>
                                <option value="6" {{ $selectedMonth == 6 ? 'selected' : '' }}>June</option>
                                <option value="7" {{ $selectedMonth == 7 ? 'selected' : '' }}>July</option>
                                <option value="8" {{ $selectedMonth == 8 ? 'selected' : '' }}>August</option>
                                <option value="9" {{ $selectedMonth == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $selectedMonth == 10 ? 'selected' : '' }}>October</option>
                                <option value="11" {{ $selectedMonth == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $selectedMonth == 12 ? 'selected' : '' }}>December</option>
                            </select>
                            <input type="hidden" name="hod_view" value="{{ request()->has('hod_view') ? 'on' : '' }}">

                        </form>

                            <!-- <select>
                                <option>Select Other</option>
                                <option>All</option>
                                <option>Sales</option>
                            </select> -->

                        </div>

							</div>
                            <div class="card-body" style="overflow-y: scroll; overflow-x: scroll;">
                                <table class="table text-center" id="atttable">
                                    <thead>
                                        <tr>
                                            <th>Sn</th>
                                            <th>EC</th>

                                            <th>Name</th>
                                            <th colspan="5">Leave Opening</th>
                                            <th colspan="{{ $daysInMonth }}">Month - {{ now()->format('F') }}</th>  <!-- Dynamic month name -->
                                            <th colspan="3">Total</th>
                                            <th colspan="5">Leave Closing</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>CL</th>
                                            <th>PL</th>
                                            <th>EL</th>
                                            <th>FL</th>
                                            <th>SL</th>

                                            <!-- Loop dynamically through the days (1 to daysInMonth) -->
                                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                                <th>{{ $i }}</th>
                                            @endfor

                                            <th>OD</th>
                                            <th>A</th>
                                            <th>P</th>
                                            <th>CL</th>
                                            <th>PL</th>
                                            <th>EL</th>
                                            <th>FL</th>
                                            <th>SL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $indexxx = 1;?>
                                        @foreach ($empdataleaveattdata as $index => $dataa)
                                        @foreach ($dataa as  $data)

                                            <tr>
                                                <td>{{ $indexxx ++}}</td>
                                                <td>{{ $data->empcode }}</td>  <!-- Employee Code -->

                                                <td style="text-align:left;">{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }} </td> <!-- Full Name -->

                                                <td>{{ number_format($data->OpeningCL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningPL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningEL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningOL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningSL, 0) }}</td>


                                                <!-- Attendance Days (1 to daysInMonth) -->
                                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                                    <td>
                                                        {{-- Display attendance status for each day or blank if no data --}}
                                                        {{ isset($data->{'day_' . $i}) ? $data->{'day_' . $i} : '-' }}
                                                    </td>
                                                @endfor

                                                <!-- Attendance Totals (OD, A, P) -->
                                                <td>{{ $data->total_OD }}</td>
                                                <td>{{ $data->total_A }}</td>
                                                <td>{{ $data->total_P }}</td>

                                                <!-- Leave Closing -->
                                                <td>{{ number_format($data->BalanceCL, 0) }}</td>
                                                <td>{{ number_format($data->BalancePL, 0) }}</td>
                                                <td>{{ number_format($data->BalanceEL, 0) }}</td>
                                                <td>{{ number_format($data->BalanceOL, 0) }}</td>
                                                <td>{{ number_format($data->BalanceSL, 0) }}</td>

                                            </tr>
                                        @endforeach
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

						</div>
    <!-- 						
						<div class="card ad-info-card-">
							<div class="card-header">
								<div class="">
								<h5><b>Request History</b></h5>
								</div>
							</div>
							<div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
								<div class="row">
									<div class="col-md-6">
									<h5>Leave</h5>
								<table class="table text-center">
									<thead >
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th>Description</th>
											<th>Apply Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
								</div>
								<div class="col-md-6">
								<h5>Attendance</h5>
								<table class="table text-center">
									<thead >
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th>Description</th>
											<th>Apply Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										
									</tbody>
								</table>
								</div>
								</div>
                            </div>
						</div> -->
                    </div>



                </div>
             
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						
                        @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('approved_attendnace_status')->flatten()) > 0)

						<div class="card ad-info-card-">
							<div class="card-header">
								<div class="">
									<h5><b>Team approval attendance request</b></h5>
								</div>
							</div>
							<div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
								<table class="table text-center" id="approvalatt">
									<thead>
										<tr>
											<th>Sn</th>
											<th>Name</th>
											<th>EC</th>
											<th>Request Date</th>
											<th>Attendance Date</th>
											<th>Remarks</th>
											<th>Status</th>
                                            
									</thead>
									<tbody>
										

										@foreach($attendanceData as $data)
											@foreach($data['approved_attendnace_status'] as $index => $attendanceRequest)
											
												<tr>
													<td>{{ $index + 1 }}</td>
													<td>{{ $attendanceRequest->Fname . ' ' . $attendanceRequest->Sname . ' ' . $attendanceRequest->Lname ?? 'N/A' }}</td>
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
                                                  
												</tr>
											@endforeach
										@endforeach

									</tbody>
								</table>
							</div>
						</div>
                        @endif
                        <div class="card ad-info-card-">
                        @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('approved_leave_request')->flatten()) > 0)

						<div class="card-header">
								<div class="">
									<h5><b>Leave Request</b></h5>
								</div>
							</div>
						
						<!-- Check if any employee has leave applications -->
                                <div class="card-body" style="overflow-y: scroll;overflow-x: hidden;">
                                    <table class="table text-center" id="approved_leave">
                                        <thead>
                                            <tr>
                                                <th>Sn</th>
                                                <th>Name</th>
                                                <th>EC</th>
                                                <th colspan="4" class="text-center">Request</th>
                                                <th>Description</th>
                                                
                                                <th>Status</th>
                                                <th></th>
                                                <th></th>

                                                <th></th>


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
                                            @foreach($attendanceData as $data)
                                                @if(!empty($data['approved_leave_request'])) <!-- Only display if approved_leave_request is not empty -->
                                                    @foreach($data['approved_leave_request'] as $index => $leave)
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
                                                            <td>{{ $leave->Fname . ' ' . $leave->Sname . ' ' . $leave->Lname ?? 'N/A' }}</td>
                                                            <td>{{ $leave->EmpCode ?? 'N/A' }}</td>
                                                            <td>{{ $leave->Leave_Type ?? 'N/A' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($leave->Apply_FromDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($leave->Apply_ToDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                            <td>{{ $leave->Apply_TotalDay ?? 'N/A' }}</td>
                                                            <td>{{ $leave->Apply_Reason ?? 'N/A' }}</td>
                                                            <td>
                                                                @switch($leave->LeaveStatus)
                                                                    @case(0)
                                                                        Reject
                                                                        @break
                                                                    @case(1)
                                                                        Approved
                                                                        @break
                                                                    @case(2)
                                                                        Approved
                                                                        @break
                                                                    @case(3)
                                                                         Pending
                                                                        @break
                                                                    @case(4)
                                                                        Cancelled
                                                                        @break
                                                                    @default
                                                                        N/A
                                                                @endswitch
                                                            </td>
                                                          
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif



						</div>
                </div>
               

                @include('employee.footerbottom')

            </div>
        </div>
    </div>

    <div class="modal fade show" id="approvalpopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
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
                        <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                            class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;"
                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                    Days</b></small></span>
                    </div>
                    <p>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days.
                        i will resume work from. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                        ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!--Approval Message-->
    <div class="modal fade show" id="querypopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
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
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                        alteration in some form, by injected humour, or randomised words which don't look even</p> <br>
                    <p>Raise Date:15 May 2024</p>
                    <table class="table table-border mt-2">
                        <thead>
                            <tr>
                                <td>Level 1</td>
                                <td>Level 2</td>
                                <td>Level 3</td>
                            </tr>
                        </thead>
                        <tr>
                            <td><b>Done</b></td>
                            <td><b>Open<b></td>
                            <td><b>Pending</b></td>
                        <tr>
                        <tr>
                            <td>16 May</td>
                            <td>19 May</td>
                            <td>Pending</td>
                        <tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!--Attendence Authorisation modal for reporting-->
    <div class="modal fade" id="AttendenceAuthorisationRequest" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
		<div class="modal fade" id="LeaveAuthorisation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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


    @include('employee.footer');
    <script>
        const employeeId = {{ Auth::user()->EmployeeID }};
        const repo_employeeId = {{ Auth::user()->EmployeeID }};
        const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
        const queryactionUrl = "{{ route("employee.query.action") }}";
        const getqueriesUrl = "{{ route("employee.queries") }}";

    </script>
    <script>
			
       
            const modal = document.getElementById('AttendenceAuthorisationRequest');
        let inn_time; // Declare variables in the outer scope
        let out_time;
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const employeeId = button.getAttribute('data-employee-id'); // Get employee ID
            // Determine if the button is for approval or rejection
            const isApproval = button.classList.contains('approval-btn');
            const isReject = button.classList.contains('rejection-btn');
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
                .then(data => {
                    // Handle the JSON data returned from the server
                    if (data.success) {
                        alert('Data sent successfully!');
                        $('#AttendenceAuthorisationRequest').modal('hide');
                    } else {
                        alert(data.message);
                        location.reload();
                    }
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
        
   
        $(document).ready(function () {
            $('#AttendenceAuthorisation').on('hidden.bs.modal', function () {
                $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 5 seconds
                $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form (if applicable)
            });
        });
        attachEventListeners();
            function attachEventListeners() {
                const acceptButtons = document.querySelectorAll('.accept-btn');
                const rejectButtons = document.querySelectorAll('.reject-btn');
                acceptButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        populateModal(this, 'approved');
                        $('#LeaveAuthorisation').modal('show');
                    });
                });
                rejectButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        populateModal(this, 'rejected');
                        $('#LeaveAuthorisation').modal('show');
                    });
                });
            }
            
            function populateModal(button, status) {
                // Update the text content of the span elements
                document.getElementById('employeename').textContent = button.getAttribute('data-name');
                document.getElementById('leavetype').textContent = button.getAttribute('data-leavetype');
                document.getElementById('from_date').textContent = button.getAttribute('data-from_date');
                document.getElementById('to_date').textContent = button.getAttribute('data-to_date');
                document.getElementById('total_days').textContent = button.getAttribute('data-total_days');
                document.getElementById('leavereason').textContent = button.getAttribute('data-reason');
                document.getElementById('leavetype_day').textContent = button.getAttribute('data-leavetype_day');
                $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));
                // Display status as text (Approved or Rejected)
                const statusDropdown = document.getElementById('StatusDropdown');
                statusDropdown.value = status; // Set 'approved' or 'rejected'
            }
            $(document).ready(function() {
        // Initialize DataTable
            $('#atttable').DataTable({
        "paging": true,       // Enable pagination
        "ordering": false,     // Disable column sorting
        "info": true,         // Display information about the table
        "lengthChange": false, // Disable length change (optional)
        "searching": false,   // Disable searching
    });
    $('#approvalatt').DataTable({
        "paging": true,       // Enable pagination
        "ordering": false,     // Disable column sorting
        "info": true,         // Display information about the table
        "lengthChange": false, // Disable length change (optional)
        "searching": false,   // Disable searching
    });
   
    });
         
                    </script>
    <script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>
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