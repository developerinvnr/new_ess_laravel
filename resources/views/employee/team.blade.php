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
										<a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
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
                            @if($isReviewer)
                                <div class="flex-shrink-0" style="float:right;">
                                    <form method="GET" action="{{ route('team') }}">
                                        @csrf
                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                            <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2"  style="float:right;">HOD/Reviewer</label>
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                name="hod_view" 
                                                id="hod-view" 
                                                {{ request()->has('hod_view') ? 'checked' : '' }} 
                                                onchange="toggleLoader(); this.form.submit();" 
                                            >
                                        </div>
                                    </form>
                                </div>
                            @endif
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">   
                                    @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('leaveApplications')->flatten()) > 0)
                                        <div class="card ad-info-card-">
                                            <div class="card-header">
                                                <div class="">
                                                    <h5 style="float:left;"><b>My Team Leave Request</b></h5>
                                                </div>
                                            </div>
                                            <div class="card-body" style="overflow-y: scroll;overflow-x: hidden;">
                                                <table class="table text-center">
                                                    <thead>

                                                        <tr>
                                                            <th>Sn</th>
                                                            <th>Name</th>
                                                            <th>EC</th>
                                                            <th colspan="4" class="text-center">Request</th>
                                                            <th style="text-align: left;">Description</th>
                                                            <th style="text-align: left;">Location</th>
                                                            <th>History</th>
                                                            <th>Status</th>
                                                            <th>Action</th>

                                                            <!-- @if(request()->get('hod_view') != 'on') -->
                                                            <!-- @endif -->
                                                            <!-- @if(request()->get('hod_view') == 'on')
                                                            <th></th>
                                                            @endif -->
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
                                                                    <td>{{ $leave->Fname . ' ' . $leave->Sname . ' ' . $leave->Lname ?? 'N/A' }}</td>
                                                                    <td>{{ $leave->EmpCode ?? 'N/A' }}</td>
                                                                    <td>{{ $leave->Leave_Type ?? 'N/A' }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($leave->Apply_FromDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($leave->Apply_ToDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                                    <td>{{ $leave->Apply_TotalDay ?? 'N/A' }}</td>
                                                                    <td title="{{ $leave->Apply_Reason ?? 'N/A' }}" style="cursor: pointer;text-align:left;">
                                                                        {{ \Str::words($leave->Apply_Reason ?? 'N/A', 5, '...') }}
                                                                        </td>

                                                                   <td style="text-align: left;">{{$leave->Apply_DuringAddress}}</td>
                                                                    <!--<td>{{ $balanceValue }}</td>-->  <!-- Displaying the leave balance -->
                                                                    <!-- <td>
                                                                        <a data-bs-toggle="modal" data-bs-target="#leaveHistory" href="javascript:void(0)"  style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                                                            <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                                                                        <!-- </a>
                                                                    </td>  -->
                                                                    <td>
                                                                        @switch($leave->LeaveStatus)
                                                                            @case(0)
                                                                                Draft
                                                                                @break
                                                                            @case(1)
                                                                                Approved
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
                                                                    @if($leave->direct_reporting)
                                                                    <td>
                                                                        <!-- Action buttons logic based on LeaveStatus -->
                                                                        @if(in_array($leave->LeaveStatus, [0, 3, 4]))
                                                                            <!-- Pending state: show Approval and Reject buttons -->
                                                                            <button class="mb-0 sm-btn mr-1 effect-btn btn btn-success accept-btn" 
                                                                                style="padding: 4px 10px; font-size: 10px;"
                                                                                data-employee="{{ $leave->EmployeeID }}"
                                                                                data-name="{{ $leave->Fname }} {{ $leave->Sname }} {{ $leave->Lname }}"
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
                                                                                data-name="{{ $leave->Fname }} {{ $leave->Sname }} {{ $leave->Lname }}"
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
                                
                                        <h5><b>Team Attendance Authorization</b></h5>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $hasPendingRequests = false;
                                                $indexatt = 1;
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
                                                        <td>{{ $indexatt ++ }}</td>
                                                        <td>{{ $attendanceRequest->Fname . ' ' . $attendanceRequest->Sname . ' ' . $attendanceRequest->Lname ?? 'N/A' }}</td>
                                                        <td>{{ $attendanceRequest->EmpCode ?? 'N/A' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($attendanceRequest->ReqDate)->format('d-m-Y') ?? ''}}</td>
                                                    
                                                        <td>{{ \Carbon\Carbon::parse($attendanceRequest->AttDate)->format('d-m-Y') ?? ''}}</td>
                                                        <!-- <td>
                                                            @if(!empty($attendanceRequest->InRemark))
                                                                {{ $attendanceRequest->InRemark }}
                                                            @elseif(!empty($attendanceRequest->OutRemark))
                                                                {{ $attendanceRequest->OutRemark }}
                                                            @else
                                                                {{ $attendanceRequest->Remark ?? 'N/A' }}
                                                            @endif
                                                        </td>   -->
                                                        <td title="{{ !empty($attendanceRequest->InRemark) ? $attendanceRequest->InRemark : ( !empty($attendanceRequest->OutRemark) ? $attendanceRequest->OutRemark : ($attendanceRequest->Remark ?? 'N/A') ) }}" style="cursor: pointer;">
                                                            {{ \Str::words(!empty($attendanceRequest->InRemark) ? $attendanceRequest->InRemark : ( !empty($attendanceRequest->OutRemark) ? $attendanceRequest->OutRemark : ($attendanceRequest->Remark ?? 'N/A') ), 5, '...') }}
                                                            </td>

                                                            <td>
                                                    @if($attendanceRequest->Status == 3)
                                                        Pending
                                                    @elseif($attendanceRequest->Status == 0 && $attendanceRequest->draft_status == 0)
                                                        Rejected
                                                    @elseif($attendanceRequest->Status == 1 && $attendanceRequest->draft_status == 0)
                                                        Approved
                                                    @elseif($attendanceRequest->Status == 2 && $attendanceRequest->draft_status == 0)
                                                        Rejected
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                        @if($attendanceRequest->direct_reporting)
                                                        <td>
                                                            <!-- Check if the status is pending (0) -->
                                                            @if($attendanceRequest->Status == 3) 
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
                                                                <span class="badge bg-danger">Approved</span>
                                                            @elseif($attendanceRequest->Status == 0) 
                                                                <!-- Draft: show Draft message -->
                                                                <span class="badge bg-warning">Rejected</span>
                                                            @elseif($attendanceRequest->Status == 4) 
                                                                <!-- Cancelled: show Cancelled message -->
                                                                <span class="badge bg-secondary">Cancelled</span>
                                                            @endif
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            @endforeach

                                            <!-- Display the "No Pending Requests" message if there are no pending requests -->
                                            <!-- @if (!$hasPendingRequests)
                                                <tr>
                                                    <td colspan="8" class="text-center">
                                                        <div class="alert alert-secondary animated-alert" role="alert">
                                                            <i class="fas fa-info-circle"></i> No Pending Requests
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
						
						<div class="card ad-info-card-">
                            <div class="card-header">
                                <div class="">
                                    <h5><b>My Team</b></h5>
                                    <!-- @if($isReviewer)
                                        <div class="flex-shrink-0" style="float:right;">
                                            <form method="GET" action="{{ route('team') }}">
                                                @csrf
                                                <div class="form-check form-switch form-switch-right form-switch-md">
                                                    <label for="hod-view" class="form-label text-muted mt-1">HOD/Reviewer</label>
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
                                    @endif -->

                                </div>
                            </div>
                            <div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
                            <table class="table text-center" id="teamtable">
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
                                                <td><a href="javascript:void(0);" onclick="showEmployeeDetails({{ $employee->EmployeeID }})" style="color: #007bff; text-decoration: underline; cursor: pointer;"><i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon --></a></td>

                                                <!-- KRA (Key Responsibility Areas, if available) -->
                                                <td>-</td>

                                                <!-- Eligibility (Eligibility for promotion, benefits, etc.) -->
                                                <!-- Eligibility (Eligibility for promotion, benefits, etc.) -->
                                                <td>
                                                    <a href="javascript:void(0)" onclick="fetchEligibilityData({{ $employee->EmployeeID }})" style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                                    <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                                                    </a>
                                                </td>

                                                <!-- CTC -->
                                                <td>
                                                    <a href="javascript:void(0)" onclick="fetchCtcData({{ $employee->EmployeeID }})" style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                                    <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                                                    </a>
                                                </td>
                                                <td id="row_{{ $employee->EmployeeID }}">
                                                    @if($employee->hasTeam)
                                                        <!-- Menu Icon to fetch team -->
                                                        <a href="javascript:void(0)" onclick="fetchTeam({{ $employee->EmployeeID }})">
                                                            <i class="fas fa-bars"></i> <!-- Font Awesome menu icon -->
                                                        </a>
                                                        <!-- Dropdown placeholder (Will be populated dynamically) -->
                                                        <ul id="dropdown_{{ $employee->EmployeeID }}" class="custom-dropdown">
                                                            <!-- Team members will be dynamically inserted here -->
                                                        </ul>
                                                    @else
                                                        <!-- If no team, show a message or leave it empty -->
                                                        <span>-</span>
                                                    @endif
                                                </td>


   
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


					@if(count($getEmployeeReportingChaind3js ?? []) > 0)
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
													 <!-- Tree or employee data will go here  -->
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
        <div class="modal show" id="leaveHistory" role="dialog"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Leave Balance</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card chart-card">  
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
                                        <h6>Casual Leave(CL)</h6>
                                        <div class="mt-2 mb-3">
                                            <span class="leave-bal-use">05</span>
                                            <span class="leave-bal-bal">01</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
                                        <h6>Sick Leave(SL)</h6>
                                        <div class="mt-2 mb-3">
                                            <span class="leave-bal-use">00</span>
                                            <span class="leave-bal-bal">05</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
                                        <h6>Privilege Leave(PL)</h6>
                                        <div class="mt-2 mb-3">
                                            <span class="leave-bal-use">02</span>
                                            <span class="leave-bal-bal">04</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-center mb-3" style="border-bottom: 1px solid #ddd;">
                                        <h6>Earn Leave(EL)</h6>
                                        <div class="mt-2 mb-3">
                                            <span class="leave-bal-use">05</span>
                                            <span class="leave-bal-bal">25</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <h6>Earn Leave(EL)</h6>
                                        <div class="mt-2 mb-3">
                                            <span class="leave-bal-use">00</span>
                                            <span class="leave-bal-bal">02</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sn</th>
                                                    <th>Date</th>
                                                    <th>Leave</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>15-02-2024 to 15-02-24</td>
                                                    <td>CL</td>
                                                </tr>
                                                <tr>
                                                    <td>2.</td>
                                                    <td>18-06-2024 to 23-06-24</td>
                                                    <td>PL</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

	 <!--Attendence Authorisation modal for reporting-->
     <div class="modal fade" id="AttendenceAuthorisationRequest" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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

                    <p><b><span id="request-date-repo"></span></b></p>
                    <form id="attendance-form" method="POST" action="">
                        <input type="hidden" id="employeeIdInput" name="employeeId">

                        @csrf
                        <div class="form-group mb-0" id="reasonInGroupReq" style="display: none;">
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <input type="text" id="reasonInDisplay" class="form-control" style="border: none; background: none;" readonly>

                        </div>
                        <div class="form-group  mb-0" id="remarkInGroupReq" style="display: none;">
                            <label class="col-form-label"><b>In Remark:</b></label>
                            <input type="text" name="remarkIn" class="form-control" id="remarkInReq" readonly>
                        </div>
                        <div class="form-group s-opt" id="statusGroupIn" style="display: none;">
                            <label class="col-form-label"><b>In Status:</b></label>
                            <select name="inStatus" class="select2 form-control select-opt" id="inStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkInGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting In Remark:</b></label>
                            <textarea name="reportRemarkIn" class="form-control" id="reportRemarkInReq" placeholder="Enter your remarks" maxlength="50"></textarea>
                        </div>
                        
                        <div class="form-group  mb-0" id="reasonOutGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <input type="text" id="reasonOutDisplay" class="form-control"
                                style="border: none; background: none;"></input>
                        </div>

                        <div class="form-group  mb-0" id="remarkOutGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Out Remark:</b></label>
                            <input type="text" name="remarkOut" class="form-control" id="remarkOutReq" readonly>
                        </div>
                        <div class="form-group s-opt" id="statusGroupOut" style="display: none;">
                            <label class="col-form-label"><b>Out Status:</b></label>
                            <select name="outStatus" class="select2 form-control select-opt" id="outStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkOutGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting Out Remark:</b></label>
                            <textarea name="reportRemarkOut" class="form-control" id="reportRemarkOutReq" maxlength="50" placeholder="Enter your remarks"></textarea>
                        </div>

                        

                        <div class="form-group  mb-0" id="reasonOtherGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Reason:</b></label>
                            <input type="text" id="reasonOtherDisplay" class="form-control"
                                style="border: none; background: none;" readonly>
                        </div>

                        <div class="form-group mb-0" id="remarkOtherGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Remark:</b></label>
                            <input type="text" name="remarkOther" class="form-control" id="remarkOtherReq" readonly>
                        </div>
                        <div class="form-group  mb-0 s-opt" id="statusGroupOther" style="display: none;">
                            <label class="col-form-label"><b>Other Status:</b></label>
                            <select name="otherStatus" class="select2 form-control select-opt" id="otherStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkOtherGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting Other Remark:</b></label>
                            <textarea name="reportRemarkOther" class="form-control" id="reportRemarkOtherReq" maxlength="50" placeholder="Enter your remarks"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-primary" id="sendButtonReq">Submit</button>
                </div>
            </div>
        </div>
    </div>

   	<!-- LeaveAuthorization modal  -->
		<div class="modal fade" id="LeaveAuthorisation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        <div class="col-md-12">
                            <div style="border-bottom:1px solid #ddd;float:left;width:100%;">
                                <b style="float:left;margin-top:5px;font-size:13px;"><span id="employeename"></span></b>
                                <div style="float:right;">
                                    <label for="leavetype" class="col-form-label">Leave Type:</label>
                                    <span class="mb-0 badge" style="background-color: rgb(100, 177, 255);" id="leavetype"></span>
                                </div>
                            </div>
                            <div class="float-start" style="width:100%;">
                                <div class="float-start">
                                    <label for="from_date" class="col-form-label"><b>Date:</b></label>
                                    <b><span style="color: #236c74;" class="ml-2 mr-2" id="from_date"></span> To <span style="color: #236c74;" class="ml-2 mr-2" id="to_date"></span></b>
                                </div>
                                <div class="float-end">
                                    <label for="total_days" class="col-form-label"><b>Total Days:</b></label>
                                    <b><span style="color:#d51f1f;font-size:13px;" id="total_days"></span> </b>
                                </div>
                            </div>
                            <div class="float-start" style="width:100%;">
                                <label for="leavetype_day" class="col-form-label"><b>Leave Option:</b></label>
                                <b><span style="text-transform: capitalize;" id="leavetype_day"></span></b>
                            </div>
                            <div class="float-start mt-1" style="width:100%;">
                                <label for="leavereason" class="col-form-label float-start"><b>Leave Reason:</b></label>
                            </div>
                            <span id="leavereason"></span>
                            
                        </div>
                        <div class="col-md-12 mt-3" id="statusGroupIn">
                            <label class="col-form-label"><b>Status:</b></label>
                                <select name="Status" class="select2 form-control form-select select-opt" id="StatusDropdown">
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                        </div>
                        <div class="col-md-12">
                            <label for="remarks" class="col-form-label"><b>Remarks:</b></label>
                            <textarea name="remarks_leave" class="form-control" id="remarks_leave"
                                placeholder="Enter your remarks"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sendButtonleave">Submit</button>
            </div>
        </div>
    </div>
</div>

        <!-- Employee Details Modal -->
        <div class="modal fade" id="empdetails" data-bs-backdrop="static"tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Employee Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row emp-details-sep">
                            <div class="col-md-6">
                                <ul>
                                    <li><b>Name:</b> <span id="employeeName"></span></li>
                                    <li><b>Designation:</b> <span id="designation"></span></li>
                                    <li><b>Department:</b> <span id="department"></span></li>
                                    <li><b>Qualification:</b> <span id="qualification"></span></li>
                                    <li><b>HQ Name:</b> <span id="hqName"></span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul>
                                    <li><b>Employee Code:</b> <span id="employeeCode"></span></li>
                                    <li><b>Date of Joining:</b> <span id="dateJoining"></span></li>
                                    <li><b>Reporting Name:</b> <span id="reportingName"></span></li>
                                    <li><b>Reviewer:</b> <span id="reviewerName"></span></li>
                                    <li><b>Total VNR Experience:</b> <span id="totalExperienceYears"></span></li>
                                </ul>
                            </div>
                            <div class="col-md-12 mt-3">
                                <h5 id="careerh5"><b>Career Progression in VNR</b></h5>
                                <table class="table table-bordered mt-2">
                                    <thead style="background-color:#cfdce1;">
                                        <tr>
                                            <th>SN</th>
                                            <th>Date</th>
                                            <th>Designation</th>
                                            <th>Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody id="careerProgressionTable">
                                        <!-- Career progression data will be populated here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mt-3" id="careerprev">
                                <h5 ><b>Previous Employers</b></h5>
                                <table class="table table-bordered mt-2">
                                    <thead style="background-color:#cfdce1;">
                                        <tr>
                                            <th>SN</th>
                                            <th>Company</th>
                                            <th>Designation</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Duration</th>
                                        </tr>
                                    </thead>
                                    <tbody id="experienceTable">
                                        <!-- Experience data will be populated here dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal to display eligibility details -->
        <div class="modal fade" id="eligibilitydetails" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3">Employee Eligibility Details</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Dynamic data will be inserted here -->
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card chart-card">
                                    <div class="card-header eligibility-head-title">
                                        <h4 class="has-btn">Lodging Entitlements</h4>
                                        <p>(Actual with upper limits per day)</p>
                                    </div>
                                    <div class="card-body align-items-center">
                                        <ul class="eligibility-list">
                                            <li>City Category A:  <span class="p-0">/-</span><span id="lodgingA"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                                            <li>City Category B: <span class="p-0">/-</span><span id="lodgingB"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                                            <li>City Category C: <span class="p-0">/-</span><span id="lodgingC"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card chart-card">
                                    <div class="card-header eligibility-head-title">
                                        <h4 class="has-btn">Daily Allowances</h4>
                                        <p></p>
                                    </div>
                                    <div class="card-body align-items-center">
                                        <ul class="eligibility-list">
                                            <li  id="daHqsection">DA@HQ: <span id="daHq"></span> <span>/- Per Day</span></li>
                                            <li>DA Outside HQ: <span id="daOutsideHq"></span></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- More eligibility sections as needed -->
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card chart-card">
                                    <div class="card-header ctc-head-title">
                                        <h4 class="has-btn">Travel Eligibility</h4>
                                        <p>(For Official Purpose Only)</p>
                                    </div>
                                    <div class="card-body">
                                        <ul class="eligibility-list">
                                            <li><strong>2 Wheeler:</strong> <span class="p-0">/-</span><span id="twheeler"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                                            <li><strong>4 Wheeler:</strong> <span id="fwheeler"></span></li>
                                            <li id="classoutside"><strong>Mode/Class outside HQ:</strong> <span id="outsideHq"></span></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="card chart-card" id="mobileeligibility">
                                    <div class="card-header eligibility-head-title">
                                        <h4 class="has-btn">Mobile Eligibility</h4>
                                        <p>(Subject to submission of bills)</p>
                                    </div>
                                    <div class="card-body">
                                        <ul class="eligibility-list">
                                            <li>Handset: <span id="handset"></span></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- Add more sections like Gratuity / Deduction if needed -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ctc-->
        <div class="modal fade" id="ctcModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ctcModalLabel"> CTC Details - <span id="employeeNamectc"></span></h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                <!-- Monthly Components -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card chart-card">
                    <div class="card-header">
                        <h4 class="has-btn">Monthly Components</h4>
                    </div>
                    <div class="card-body dd-flex align-items-center">
                        <ul class="ctc-section" id="monthly-components">
                        <li>
                            <div class="ctc-title">Basic</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="BAS_Value"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">HRA</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="HRA_Value">12,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Bonus <sup>1</sup></div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Bonus1_Value">5,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Special Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="SpecialAllowance_Value">2,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Gross Monthly Salary</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Gross_Monthly_Salary">55,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Provident Fund</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="PF_Value">1,500</b></div>
                        </li>
                        <li>
                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Net Monthly Salary</div>
                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Net_Monthly_Salary">48,500</b></div>
                        </li>
                        </ul>
                    </div>
                    </div>

                    
                </div>

                <!-- Annual Components -->
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card chart-card">
                    <div class="card-header ctc-head-title">
                        <h4 class="has-btn">Annual Components</h4>
                        <p>(Tax saving components which shall be reimbursed on production of documents)</p>
                    </div>
                    <div class="card-body dd-flex align-items-center">
                        <ul class="ctc-section" id="annual-components">
                        <li>
                            <div class="ctc-title">Leave Travel Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="LTA_Value">12,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Children Education Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="ChildEduAllowance_Value">2,400</b></div>
                        </li>
                        <li>
                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Annual Gross Salary</div>
                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="AnnualGrossSalary_Value">660,000</b></div>
                        </li>
                        </ul>
                    </div>
                    </div>

                    <div class="card chart-card">
                    <div class="card-header ctc-head-title">
                        <h4 class="has-btn">Other Annual Components</h4>
                        <p>(Statutory Components)</p>
                    </div>
                    <div class="card-body dd-flex align-items-center">
                        <ul class="ctc-section" id="other-annual-components">
                        <li>
                            <div class="ctc-title">Estimated Gratuity <sup>2</sup></div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Gratuity_Value">50,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Employer's PF Contribution</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="EmployerPF_Value">5,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Mediclaim Policy Premiums</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="MediclaimPolicy_Value">3,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Fixed CTC</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="FixedCTC_Value">720,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Performance Pay</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="PerformancePay_Value">25,000</b></div>
                        </li>
                        <li>
                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC</div>
                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="TotalCTC_Value">775,000</b></div>
                        </li>
                        </ul>
                    </div>
                    </div>
                    <div class="card chart-card">
                        <div class="card-header">
                            <h4 class="has-btn">Additional Benefit</h4>
                        </div>
                        <div class="card-body dd-flex align-items-center">
                            <ul class="ctc-section" id="additional-benefit">
                            <li>
                                <div class="ctc-title">Insurance Policy Premium</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="InsurancePremium_Value">3,000</b></div>
                            </li>
                            </ul>
                        </div>
                        </div>
                </div>
                </div>

                <!-- Notes Section -->
                <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <p><b>Notes</b></p>
                    <ol id="notes">
                    <li>Bonus shall be paid as per The Code of Wages Act, 2019</li>
                    <li>The Gratuity to be paid as per The Code on Social Security, 2020.</li>
                    <li>Performance Pay</li>
                    </ol>
                    <b>Performance Pay</b>
                    <ol>
                    <li>Performance Pay is an annually paid variable component of CTC, paid in July salary.</li>
                    <li>This amount is indicative of the target variable pay, actual pay-out will vary based on the performance of Company and Individual.</li>
                    <li>It is linked with Company performance (as per fiscal year) and Individual Performance (as per appraisal period for minimum 6 months working, pro-rata basis if < 1 year working).</li>
                    <li>The calculation shall be based on the pre-defined performance measures at both, Company & Individual level.</li>
                    </ol>
                    <p>For more details refer to the Company’s Performance Pay policy.<br><br><b>Important</b><br>This is a confidential page not to be discussed openly with others. You shall be personally responsible for any leakage of information regarding your compensation.</p>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
		@include('employee.footer')
		<script>
            const employeeChainDatatojs = @json($getEmployeeReportingChaind3js);


			const employeeId = {{ Auth::user()->EmployeeID }};
			const repo_employeeId = {{ Auth::user()->EmployeeID }};
			const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
			const queryactionUrl = "{{ route("employee.query.action") }}";
			const getqueriesUrl = "{{ route("employee.queries") }}";
		</script>
		<script>
	function fetchTeam(employeeID) {

        // Send AJAX request to fetch employees reporting to the given employee
        $.ajax({
            url: '/employee/team/' + employeeID,  // Assuming you have the correct route
            method: 'GET',
            success: function(response) {
                let teamMembers = '';

                // If there are team members, create a list
                if (response.team && response.team.length > 0) {
                    response.team.forEach(function(member) {
                        let profileUrl = '/employee/singleprofile/' + member.EmployeeID;

                        // Append the member's name as a clickable link to the dropdown
                        teamMembers += '<li class="dropdown-item"><a href="' + profileUrl + '">' + member.Fname + ' ' + member.Sname + ' ' + member.Lname + '</a></li>';
                        });
                } else {
                    // If no team members, show a message
                    teamMembers = '<li class="no-team-item">No team members found.</li>';
                }

                // Get the dropdown element and populate it with the team members
                let dropdown = $('#dropdown_' + employeeID);
                dropdown.html(teamMembers);

                // Get the position of the menu icon to position the dropdown below it
                let iconPosition = $('a[href="javascript:void(0)"]').offset();
                let tdPosition = $('#row_' + employeeID).offset();  // Get position of the table cell

                // Set the dropdown's position relative to the icon
                dropdown.css({
                    top: tdPosition.top + 25 + 'px', // Position the dropdown 25px below the menu icon
                    left: tdPosition.left + 10 + 'px'  // Align it with the left side of the icon
                });

                // Toggle visibility of the dropdown
                dropdown.toggle(); // Show or hide the dropdown
            },
            error: function(error) {
                alert('Error fetching team data');
            }
        });
    }

    function stripHtml(html) {
            const div = document.createElement('div');
            div.innerHTML = html;
            return div.textContent || div.innerText || '';
        }
        function fetchEligibilityData(employee_id) {
        console.log(employee_id);
        // Make an AJAX call to fetch eligibility data
        fetch(`/employee-eligibility/${employee_id}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Populate the modal with the fetched data


                document.getElementById('lodgingA').innerText = data.Lodging_CategoryA;
                document.getElementById('lodgingB').innerText = data.Lodging_CategoryB;
                document.getElementById('lodgingC').innerText = data.Lodging_CategoryC;
                
                // Check if the 'data.DA_Inside_Hq' exists
                if (data && data.DA_Inside_Hq != '') {
                    // If DA_Inside_Hq exists, display the value
                    document.getElementById('daHq').innerText = data.DA_Inside_Hq;
                } else {

                    // If DA_Inside_Hq doesn't exist, hide the section
                    document.getElementById('daHqsection').style.display = 'none';

                }

                document.getElementById('daOutsideHq').innerText = data.DA_Outside_Hq;

                document.getElementById('twheeler').innerText = data.Travel_TwoWeeKM;
                document.getElementById('fwheeler').innerText = data.Travel_FourWeeKM;
                if (data && data.Mode_Travel_Outside_Hq != '') {
                    // If DA_Inside_Hq exists, display the value
                    document.getElementById('outsideHq').innerText = data.Mode_Travel_Outside_Hq;
                } else {

                    // If DA_Inside_Hq doesn't exist, hide the section
                    document.getElementById('classoutside').style.display = 'none';

                }

                // Check if Mobile_Hand_Elig is "Y" or "N" and update eligibility text
                document.getElementById('handset').innerText = (data.Mobile_Hand_Elig === "Y") ? "Eligible" : "Not Eligible";

                // If Mobile_Hand_Elig is "N", hide the entire "Mobile Eligibility" section
                if (data.Mobile_Hand_Elig === "N") {
                    document.getElementById('mobileeligibility').style.display = 'none';  // Hide the section
                } else {
                    document.getElementById('mobileeligibility').style.display = 'block';  // Show the section
                }            
                // Open the modal
                var myModal = new bootstrap.Modal(document.getElementById('eligibilitydetails'), {
                    keyboard: false
                });
                myModal.show();
            })
            .catch(error => {
                console.error('Error fetching eligibility data:', error);
            });
    }

    function fetchCtcData(EmployeeID) {
        // Make an AJAX call to fetch CTC data
        fetch(`/employee-ctc/${EmployeeID}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.error) {
                    alert(data.error); // If there's an error, show an alert
                    return;
                }

                        // Helper function to format numbers to integers (without decimals)
                        function formatToInteger(value) {
                            // Ensure value is a valid number
                            if (value || value === 0) {
                                // Return the number as an integer, removing any decimals
                                return Math.floor(value).toString();  // Removing decimal part
                            }
                            return 'N/A';  // Return 'N/A' if value is null, undefined, or not a number
                        }
                // Populate the modal with the fetched CTC data

                document.getElementById('employeeNamectc').innerText = data.Fname + ' ' + data.Sname + ' ' + data.Lname;

                document.getElementById('BAS_Value').innerText = formatToInteger(data.BAS_Value);

                document.getElementById('HRA_Value').innerText = formatToInteger(data.HRA_Value);
                document.getElementById('Bonus1_Value').innerText = formatToInteger(data.Bonus_Month);

                document.getElementById('SpecialAllowance_Value').innerText = formatToInteger(data.SPECIAL_ALL_Value);
                document.getElementById('Gross_Monthly_Salary').innerText = formatToInteger(data.Tot_GrossMonth);
                document.getElementById('PF_Value').innerText = formatToInteger(data.PF_Employee_Contri_Value);
                document.getElementById('Net_Monthly_Salary').innerText = formatToInteger(data.NetMonthSalary_Value);

                // Additional benefits
                document.getElementById('ChildEduAllowance_Value').innerText = formatToInteger(data.CHILD_EDU_ALL_Value);

                // Annual Components
                document.getElementById('LTA_Value').innerText = formatToInteger(data.LTA_Value);
                document.getElementById('InsurancePremium_Value').innerText = formatToInteger(data.INC_Value);

                // Add performance-related details
                document.getElementById('AnnualGrossSalary_Value').innerText = formatToInteger(data.Tot_Gross_Annual);

                document.getElementById('Gratuity_Value').innerText = formatToInteger(data.GRATUITY_Value);
                document.getElementById('EmployerPF_Value').innerText = formatToInteger(data.PF_Employer_Contri_Annul);
                document.getElementById('MediclaimPolicy_Value').innerText = formatToInteger(data.Mediclaim_Policy);
                document.getElementById('InsurancePolicy_Value').innerText = formatToInteger(data.INC_Value);

                document.getElementById('FixedCTC_Value').innerText = formatToInteger(data.Tot_CTC);
                document.getElementById('PerformancePay_Value').innerText = formatToInteger(data.VariablePay);
                document.getElementById('TotalCTC_Value').innerText = formatToInteger(data.TotCtc);

                // Open the modal
                var myModal = new bootstrap.Modal(document.getElementById('ctcModal'), {
                    keyboard: false
                });
                myModal.show();
            })
            .catch(error => {
                console.error('Error fetching CTC data:', error);
            });
    }
    
    $(document).ready(function() {
    $('#teamtable').DataTable({
        "paging": true,          // Enable pagination
        "ordering": true,        // Enable column sorting
        "info": true,            // Display table info like "Showing 1 to 10 of 50 entries"
        "lengthChange": false,   // Disable the ability to change the number of rows per page
        "searching": false       // Disable the search functionality
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
           // Show sections based on reason validity
           if (isInReasonValid && isOutReasonValid) {
            console.log('inout');
                    // Show both "In" and "Out" sections
                    document.getElementById('statusGroupIn').style.display = 'block';
                    document.getElementById('reasonInGroupReq').style.display = 'block';
                    document.getElementById('remarkInGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkInGroup').style.display = 'block';
                    
                    if (inReason) {
                        // Display Remark as text
                        document.getElementById('reasonInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <span id="reasonInDisplay" style="border: none; background: none;">${inReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonInDisplay').value = '';
                    }

                    // Handle the "In" Remark
                    let inRemarkValue = button.getAttribute('data-in-remark');
                    if (inRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Remark:</b></label><br>
                            <span id="remarkInReq" style="border: none; background: none;">${inRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkInReq').value = '';
                    }

                    // Show the "Out" sections
                    document.getElementById('statusGroupOut').style.display = 'block';
                    document.getElementById('reasonOutGroupReq').style.display = 'block';
                    document.getElementById('remarkOutGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkOutGroup').style.display = 'block';

                    // Set Reason Out
                    // document.getElementById('reasonOutDisplay').value = `${outReason}`;

                    if (outReason) {
                        // Display Remark as text
                        document.getElementById('reasonOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <span id="reasonOutDisplay" style="border: none; background: none;">${outReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonOutDisplay').value = '';
                    }

                    // Handle the "Out" Remark
                    let outRemarkValue = button.getAttribute('data-out-remark');
                    if (outRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Remark:</b></label><br>
                            <span id="remarkOutReq" style="border: none; background: none;">${outRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkOutReq').value = '';
                    }
                } 
                else if (isInReasonValid) {
                    console.log('in');

                    // Show only "In" section
                    document.getElementById('statusGroupIn').style.display = 'block';
                    document.getElementById('reasonInGroupReq').style.display = 'block';
                    document.getElementById('remarkInGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkInGroup').style.display = 'block';
                    
                    // Set Reason In
                    //document.getElementById('reasonInDisplay').value = `${inReason}`;
                    // Handle the "In" Remark
                    if (inReason) {
                        // Display Remark as text
                        document.getElementById('reasonInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <span id="reasonInDisplay" style="border: none; background: none;">${inReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonInDisplay').value = '';
                    }

                    // Handle the "In" Remark
                    let inRemarkValue = button.getAttribute('data-in-remark');
                    if (inRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Remark:</b></label><br>
                            <span id="remarkInReq" style="border: none; background: none;">${inRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkInReq').value = '';
                    }
                } else if (isOutReasonValid) {
                    // Show only "Out" section
                    document.getElementById('statusGroupOut').style.display = 'block';
                    document.getElementById('reasonOutGroupReq').style.display = 'block';
                    document.getElementById('remarkOutGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkOutGroup').style.display = 'block';

                    // Set Reason Out
                    if (outReason) {
                        // Display Remark as text
                        document.getElementById('reasonOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <span id="reasonOutDisplay" style="border: none; background: none;">${outReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonOutDisplay').value = '';
                    }

                    // Handle the "Out" Remark
                    let outRemarkValue = button.getAttribute('data-out-remark');
                    if (outRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Remark:</b></label><br>
                            <span id="remarkOutReq" style="border: none; background: none;">${outRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkOutReq').value = '';
                    }
                } else if (!isInReasonValid && !isOutReasonValid && isOtherReasonValid) {
                    // Show "Other" section only
                    document.getElementById('statusGroupOther').style.display = 'block';
                    document.getElementById('reasonOtherGroupReq').style.display = 'block';
                    document.getElementById('remarkOtherGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkOtherGroup').style.display = 'block';

                    // Set Other Reason
                    document.getElementById('reasonOtherDisplay').value = `${otherReason}`;

                    if (otherReason) {
                        // Display Remark as text
                        document.getElementById('reasonOtherGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Reason:</b></label>
                            <span id="reasonOtherDisplay" style="border: none; background: none;">${otherReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonOtherDisplay').value = '';
                    }

                    // Handle the "Other" Remark
                    let otherRemarkValue = button.getAttribute('data-other-remark');
                    if (otherRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkOtherGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Remark:</b></label><br>
                            <span  id="remarkOtherReq" style="border: none; background: none;">${otherRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkOtherReq').value = '';
                    }
                }

        
        });
        
        document.getElementById('sendButtonReq').addEventListener('click', function () {
            $('#loader').show(); 

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
                    $('#loader').hide(); 

                    // Log the raw response for debugging
                    return response.text().then(text => {
                            console.log('Raw response:', text); // Log the raw response
                            
                            // Check if the response is OK (status in the range 200-299)
                            if (response.ok) {
                                // Check if the response text is not empty
                                if (text) {
                                    toastr.success(response.message, 'Attendance Updated Successfully', {
                                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                    "timeOut": 3000  // Duration for which the toast is visible (in ms)
                                });
                                    return JSON.parse(text); // Parse JSON if text is not empty
                                } else {
                                    
                                    toastr.error(response.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                    "timeOut": 3000  // Duration for which the toast is visible (in ms)
                                });
                                    throw new Error('Empty response from server');
                                }
                            } else {
                                toastr.error(text, 'Error', {
                                    "positionClass": "toast-top-right",  // Position it at the top-right of the screen
                                    "timeOut": 3000  // Duration for which the toast is visible (in ms)
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
                            setTimeout(() => {
                                $('#LeaveAuthorisation').modal('hide'); // Close modal
                                location.reload(); // Reload the page
                            }, 3000);
                        } else {
                            // Show error toast when the response is unsuccessful
                            // toastr.error('Leave rejected. Please check the details.', 'Error', {
                            //     "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            //     "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            // });
                            toastr.error(response.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                    "timeOut": 3000  // Duration for which the toast is visible (in ms)
                                });
                           $('#loader').hide(); 

                            
                        }
                    },
                    error: function (xhr) {
                        // Handle any errors from the server
                        toastr.error('An error occurred. Please try again.', 'Error', {
                            "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            "timeOut": 5000  // Duration for which the toast is visible (in ms)
                        });
                        $('#loader').hide(); 

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
                // Get the 'data-from_date' and 'data-to_date' attributes
                var fromDate = button.getAttribute('data-from_date');
                var toDate = button.getAttribute('data-to_date');

                // Format the dates using the formatDateDDMMYYYY function
                var formattedFromDate = formatDateddmmyyyy(fromDate);
                var formattedToDate = formatDateddmmyyyy(toDate);

                // Set the formatted dates to the elements
                document.getElementById('from_date').textContent = formattedFromDate;
                document.getElementById('to_date').textContent = formattedToDate;
                document.getElementById('total_days').textContent = button.getAttribute('data-total_days');
                document.getElementById('leavereason').textContent = button.getAttribute('data-reason');
                // document.getElementById('leavetype_day').textContent = button.getAttribute('data-leavetype_day');
                // Get the value of 'data-leavetype_day' from the button's attribute
                    var leaveType = button.getAttribute('data-leavetype_day');

                    // Check the value of leaveType and update the textContent
                    if (leaveType === 'fullday') {
                        document.getElementById('leavetype_day').textContent = 'Full Day';
                    } else if (leaveType === '1sthalf') {
                        document.getElementById('leavetype_day').textContent = '1st Half';
                    } else if (leaveType === '2ndhalf') {
                        document.getElementById('leavetype_day').textContent = '2nd Half';
                    } else {
                        document.getElementById('leavetype_day').textContent = 'Invalid Leave Type'; // Optional, for handling unexpected values
                    }
                $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));
                // Display status as text (Approved or Rejected)
                const statusDropdown = document.getElementById('StatusDropdown');
                statusDropdown.value = status; // Set 'approved' or 'rejected'
            }
            
            function showEmployeeDetails(employeeId) {
    $.ajax({
        url: '/employee/details/' + employeeId,  // Ensure the route matches your Laravel route
        method: 'GET',
        success: function(response) {
            console.log(response);
            if (response.error) {
                alert(response.error);
            } else {
               // Helper function to check if the date is valid or is a default date like "01/01/1970"
                function isInvalidDate(date) {
                    return date === "1970-01-01" || date === "0000-00-00" || date === "";
                }

                // Update modal content dynamically with employee details
                $('#employeeName').text(response.Fname + ' ' + response.Sname + ' ' + response.Lname);
                $('#employeeCode').text(response.EmpCode);
                $('#designation').text(response.DesigName);
                $('#department').text(response.DepartmentName);
                $('#qualification').text(response.Qualification);
                $('#hqName').text(response.HqName);
                $('#dateJoining').text(formatDateddmmyyyy(response.DateJoining));
                $('#reportingName').text(response.ReportingName);
                $('#reviewerName').text(response.ReviewerFname + ' ' + response.ReviewerSname + ' ' + response.ReviewerLname);  // Reviewer Name
                $('#totalExperienceYears').text(response.YearsSinceJoining + ' Years  ' + response.MonthsSinceJoining + ' Month');

                // **Handling Previous Experience Data**
                var companies = response.ExperienceCompanies ? response.ExperienceCompanies.split(',') : [];
                var designations = response.ExperienceDesignations ? response.ExperienceDesignations.split(',') : [];
                var fromDates = response.ExperienceFromDates ? response.ExperienceFromDates.split(',') : [];
                var toDates = response.ExperienceToDates ? response.ExperienceToDates.split(',') : [];
                var years = response.ExperienceYears ? response.ExperienceYears.split(',') : [];

                // Empty the previous employer table before populating
                var experienceTable = $('#experienceTable');
                experienceTable.empty();  // Clear any previous data in the table

                // Check if there's any experience data
                if (companies.length > 0 ) {
                    // Loop through the experience data and populate the table
                    for (var i = 0; i < companies.length; i++) {
                        var fromDate = isInvalidDate(fromDates[i]) ? '-' : formatDateddmmyyyy(fromDates[i]);
                        var toDate = isInvalidDate(toDates[i]) ? '-' : formatDateddmmyyyy(toDates[i]);
                        var experienceYears = isInvalidDate(fromDates[i]) || isInvalidDate(toDates[i]) ? '-' : years[i];

                        var row = `<tr>
                            <td>${i + 1}</td>
                            <td>${companies[i]}</td>
                            <td>${designations[i]}</td>
                            <td>${fromDate}</td>
                            <td>${toDate}</td>
                            <td>${experienceYears}</td>
                        </tr>`;
                        experienceTable.append(row);  // Add the row to the table
                    }

                    // Show the "Previous Employers" section if there is data
                    $('#prevh5').show(); // Show the "Previous Employers" heading
                    $('#careerprev').show(); // Show the "Previous Employers" section
                    $('#experienceTable').closest('table').show(); // Show the table
                }

                else {
                    // Hide the "Previous Employers" section if no data is available
                    $('#prevh5').hide(); // Hide the "Previous Employers" heading
                    $('#careerprev').hide(); // Show the "Previous Employers" section
                    $('#experienceTable').closest('table').hide(); // Hide the table
                }

               
                // new code 
                
                // Split the strings by commas
                var gradesAndDesignationsArray = response.CurrentGradeDesignationPairs.split(',');
                var salaryChangeDatesArray = response.SalaryChangeDates ? response.SalaryChangeDates.split(',') : [];

                // Empty the career progression table before populating
                var careerProgressionTable = $('#careerProgressionTable');
                careerProgressionTable.empty();  // Clear any previous data in the table

                // Check if there's any career progression data
                if (gradesAndDesignationsArray.length > 0 && salaryChangeDatesArray.length > 0) {
                    // Loop through the data and populate the table
                    for (var i = 0; i < gradesAndDesignationsArray.length; i++) {
                        // Get current salary change date
                        var currentSalaryDate = formatDateddmmyyyy(salaryChangeDatesArray[i].split(' - ')[0]);

                        // Get the next salary change date, or empty if none
                        var nextSalaryChangeDate = salaryChangeDatesArray[i + 1] ? formatDateddmmyyyy(salaryChangeDatesArray[i + 1].split(' - ')[0]) : '';

                        // If we have a next salary change date, display the range; otherwise, just the current date
                        var salaryDateRange = nextSalaryChangeDate ? `${currentSalaryDate} <b class="ml-2 mr-2">To</b> ${nextSalaryChangeDate}` : currentSalaryDate;

                        // Split the grade and designation (e.g., "J1-Executive IT" -> ["J1", "Executive IT"])
                        var gradeDesignation = gradesAndDesignationsArray[i].split('-');
                        var grade = gradeDesignation[1];  // First part is the grade
                        var designation = gradeDesignation[0];  // Second part is the designation

                        // Create the row for the table
                        var row = `<tr>
                                <td>${i + 1}</td>
                                <td>${salaryDateRange}</td>
                                <td>${grade.charAt(0).toUpperCase() + grade.slice(1).toLowerCase()}</td>  <!-- Capitalize first letter of Grade -->
                                <td>${designation.charAt(0).toUpperCase() + designation.slice(1).toLowerCase()}</td>  <!-- Capitalize first letter of Designation -->
                            </tr>`;

                        // Append the row to the table
                        careerProgressionTable.append(row);
                    }

                    // Show the Career Progression section if there's data
                    $('#careerh5').show(); // Show the heading
                    $('#careerProgressionTable').closest('table').show(); // Show the table
                }  else {
                    // If no career progression data, hide the section
                    $('#careerh5').hide();
                    $('#careerProgressionTable').closest('table').hide();
                }

                // Show the modal
                $('#empdetails').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX error:', status, error);
            alert('An error occurred while fetching the data.');
        }
    });
}

function formatDateddmmyyyy(date) {
    // Check if the date is valid
    const d = new Date(date);
    if (isNaN(d.getTime())) {
        console.error("Invalid date:", date);  // Log invalid date
        return "";  // Return empty string if the date is invalid
    }

    const day = String(d.getDate()).padStart(2, '0');  // Ensures two digits for day
    const month = String(d.getMonth() + 1).padStart(2, '0');  // Ensures two digits for month
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;  // Format as dd-mm-yyyy
}
function toggleLoader() {
        document.getElementById('loader').style.display = 'block'; // Show the loader
    }

    // Optional: If you want to hide the loader after the page has loaded, 
    // you can use the following code.
    window.addEventListener('load', function() {
        document.getElementById('loader').style.display = 'none'; // Hide the loader after page load
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



		</style>
