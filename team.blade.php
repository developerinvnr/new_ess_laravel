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
                                        <h5 class="float-start mt-1"><b>My Team Leave Request</b></h5>
                                            <!-- Filter Form for Leave Status -->
                                        <!-- <div class="float-end">
                                            <form method="GET" action="{{ url()->current() }}">
                                                <select id="leaveStatusFilter" name="leave_status" style="float:right;">
                                                    <option value="">All</option>
                                                    <option value="0" {{ request()->get('status', '0') == '0' ? 'selected' : '' }}>Pending</option>
                                                    <option value="1" {{ request()->get('leave_status') == '1' ? 'selected' : '' }}>Approved</option>
                                                    <option value="3" {{ request()->get('leave_status') == '3' ? 'selected' : '' }}>Rejected</option>
                                                </select>
                                            </form>
                                        </div> -->
                                    </div>
                                    
                                    <!-- Check if any employee has leave applications -->
                                        <div class="card-body" style="overflow-y: scroll;overflow-x: hidden;">
                                            <table class="table text-center" id="leavetable">
                                                <thead>
                                                    <tr>
                                                        <th>Sn</th>
                                                        <th>Name</th>
                                                        <th>EC</th>
                                                        <th colspan="4" class="text-center">Request</th>
                                                        <th style="text-align:left;">Description</th>
                                                        <th style="text-align:left;">Location</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
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
                                                        <th></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($attendanceData as $data)
                                                        @if(!empty($data['leaveApplications'])) <!-- Only display if leaveApplications is not empty -->
                                                            @foreach($data['leaveApplications'] as $index => $leave)
                                                                @php
                                                                    // Determine leave status and set the status for filtering
                                                                    $leaveStatus = $leave->LeaveStatus;
                                                                @endphp
                                                                <tr data-status="{{ $leaveStatus }}">
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $leave->Fname . ' ' . $leave->Sname . ' ' . $leave->Lname ?? 'N/A' }}</td>
                                                                    <td>{{ $leave->EmpCode ?? 'N/A' }}</td>
                                                                    <td>{{ $leave->Leave_Type ?? 'N/A' }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($leave->Apply_FromDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($leave->Apply_ToDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                                    <td>
                                                                    @if($leave->half_define == '1sthalf' || $leave->half_define == '2ndhalf')
                                                                    {{ $leave->Apply_TotalDay ?? 'N/A' }} ({{ $leave->half_define }})
                                                                    @else
                                                                        {{ $leave->Apply_TotalDay ?? 'N/A' }}
                                                                    @endif
                                                                    </td>
                                                                    <td title="{{ $leave->Apply_Reason ?? 'N/A' }}" style="cursor: pointer;text-align:left;">
                                                                                    {{ \Str::words($leave->Apply_Reason ?? 'N/A', 5, '...') }}
                                                                    </td>                                                       
                                                                    <td title="{{ $leave->Apply_DuringAddress ?? 'N/A' }}" style="cursor: pointer;text-align:left;">
                                                                        {{ \Str::words($leave->Apply_DuringAddress ?? 'N/A', 5, '...') }}
                                                                    </td>
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
                                                                        <!-- Action buttons logic (same as existing code) -->
                                                                        @if(in_array($leave->LeaveStatus, [0,4]))
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
                                                                            <a href="#" class="mb-0 sm-btn mr-1 effect-btn btn btn-warning accept-btn" 
                                                                            style="padding: 4px 10px; font-size: 10px; pointer-events: none; opacity: 0.6;" 
                                                                            title="Pending" disabled>Approved</a>
                                                                        @elseif($leave->LeaveStatus == 2)
                                                                            <a href="#" class="mb-0 sm-btn effect-btn btn btn-success reject-btn" 
                                                                            style="padding: 4px 10px; font-size: 10px; pointer-events: none; opacity: 0.6;" 
                                                                            title="Approved" disabled>Approved</a>
                                                                        @elseif($leave->LeaveStatus == 3)
                                                                            <a href="#" class="mb-0 sm-btn effect-btn btn btn-danger reject-btn" 
                                                                            style="padding: 4px 10px; font-size: 10px; pointer-events: none; opacity: 0.6;" 
                                                                            title="Rejected" disabled>Rejected</a>
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
                                    </div>
                                        @endif

                                        @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('attendnacerequest')->flatten()) > 0)

                                        <div class="card ad-info-card-">
                                            <div class="card-header">
                                                    <h5 class="float-start mt-1"><b>Team Attendance Authorization</b></h5>
                                                   
                                            </div>
                                            <div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
                                            <!-- Table -->
                                            <table id="attendanceTable" class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Sn</th>
                                                        <th>Name</th>
                                                        <th>EC</th>
                                                        <th>Attendance Date</th>
                                                        <th style="text-align:left;">Remarks</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($attendanceData as $data)
                                                        @foreach($data['attendnacerequest'] as $index => $attendanceRequest)
                                                            <tr data-status="{{ $attendanceRequest->Status }}">
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $attendanceRequest->Fname . ' ' . $attendanceRequest->Sname . ' ' . $attendanceRequest->Lname ?? 'N/A' }}</td>
                                                                <td>{{ $attendanceRequest->EmpCode ?? 'N/A' }}</td>
                                                                <!-- <td>{{ $attendanceRequest->created_at ?? 'N/A' }}</td> -->
                                                                <td>{{ \Carbon\Carbon::parse($attendanceRequest->AttDate)->format('d/m/Y') ?? 'N/A' }}</td>
                                                               
                                                                <td  title="{{ !empty($attendanceRequest->InRemark) ? $attendanceRequest->InRemark : ( !empty($attendanceRequest->OutRemark) ? $attendanceRequest->OutRemark : ($attendanceRequest->Remark ?? 'N/A') ) }}" style="cursor: pointer;text-align:left;">
                                                                            {{ \Str::words(!empty($attendanceRequest->InRemark) ? $attendanceRequest->InRemark : ( !empty($attendanceRequest->OutRemark) ? $attendanceRequest->OutRemark : ($attendanceRequest->Remark ?? 'N/A') ), 5, '...') }}
                                                                            </td>
                                                                            <td>
                                                                    @if($attendanceRequest->Status == 0)
                                                                        Pending
                                                               
                                                                    @elseif($attendanceRequest->Status == 1)
                                                                        Approved
                                                                    @elseif($attendanceRequest->Status == 2)
                                                                        Rejected
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </td>
                                                                @if($attendanceRequest->direct_reporting)
                                                                <td>
                                                                        @if($attendanceRequest->Status == 0) 
                                                                            <div>
                                                                                <a href="#" class="btn btn-success" 
                                                                                style="padding: 4px 10px; font-size: 10px;" 
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

                                                                                <a href="#" class="btn btn-danger" 
                                                                                style="padding: 4px 10px; font-size: 10px;" 
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
                          
						<div calss="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						<div class="card ad-info-card-">
                          <div class="card-header current-month">
                                <h4 class="has-btn float-start mt-2">My Team</h4>
                                <div class="float-end form-group s-opt">
                                @if(Auth::user()->MoveRep == 'Y')
            @php
                // Initialize $eet to an empty string or null to avoid the undefined variable error
                $eet = '';

                // Fetch the report data
                $rpt = DB::select("SELECT r.EmployeeID FROM hrm_employee_reporting r 
                                   LEFT JOIN hrm_employee e ON r.EmployeeID = e.EmployeeID 
                                   WHERE e.EmpStatus = 'A' AND e.CompanyId = ? 
                                   AND (r.AppraiserId = ? OR r.ReviewerId = ? OR r.HodId = ?)", 
                                   [Auth::user()->CompanyId, Auth::user()->EmployeeID, Auth::user()->EmployeeID, Auth::user()->EmployeeID]);
                
                $array_et = array();

                if(count($rpt) > 0) {
                    foreach($rpt as $rpvt) {
                        $array_et[] = $rpvt->EmployeeID;
                    }
                    $eet = implode(',', $array_et); // Create the comma-separated string
                    // dd($eet); // Debugging, you can remove this later
                }

                // Fetch the employee data for MoveRep
                $svs = DB::select("SELECT * FROM hrm_employee WHERE EmployeeID = ?", [Auth::user()->EmployeeID]);
                $resv = $svs[0];

                // Determine Employee ID to use
                if ($resv->MoveRep == 'Y') {
                    if ($resv->Ref_ID != '' && $resv->Ref_ID != NULL) {
                        $EId = $resv->Ref_ID;
                    } else {
                        $EId = $resv->EmployeeID;
                    }
                }
            @endphp

            @if ($resv->MoveRep == 'Y')
                <h5>
                    <a href="https://www.vnress.in/Employee/RepIndxHome.php?ID={{ $EId }}&eet={{ $eet }}" target="_blank" style="color:blue">Other Team Group</a>
                </h5>
            @endif
        @endif

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
                                                <td style="text-align:left;">{{ $employee->designation_name ?? 'N/A' }}</td>

                                                <!-- Grade -->
                                                <td>{{ $employee->grade_name ?? 'N/A' }}</td>

                                                <!-- Function (could be another field, or leave it blank) -->
                                                <td>-</td>

                                                <!-- Vertical -->
                                                <td>{{ $employee->vertical_name ?? 'N/A' }}</td>

                                                <!-- Departments -->
                                                <td>{{ $employee->department_code ?? 'N/A' }}</td>

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
                                            <div class="tab-pane fade active show" id="MyteamTab" role="MyteamTab">
										<div class="card chart-card">
											<div class="card-body table-responsive">

                                                <div id="chart-container"></div>

											</div>
										</div>
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
                                <label for="leavetype_day" class="col-form-label" id="leavetype_label"><b>Leave Option:</b></label>
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
                                <h5 id="careerh5"><b>Carrier Progression in VNR</b></h5>
                                <table class="table table-bordered mt-2">
                                    <thead style="background-color:#cfdce1;">
                                        <tr>
                                            <th>SN</th>
                                            <th>Date</th>
                                            <th>Grade</th>
                                            <th>Designation</th>
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
                                        <h4 class="has-btn">Insurance</h4>
                                        <p>(Sum Insured)</p> 
                                    </div>
                                    <div class="card-body">
                                        <ul class="eligibility-list">
                                            <li><strong>Health Insurance:</strong><span id="health_ins"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                                            
                                            <li><strong>Group Term Life Insurance:</strong><span id="group_term"></span><span><i class="fas fa-rupee-sign"></i></span></li>
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
                                        <li id="twheelerSection">
                                                <strong>2 Wheeler:</strong> 
                                                <!-- <span class="p-0">/-</span> -->
                                                <span id="twheeler"><p></p></span>
                                                
                                                <!-- <span><i class="fas fa-rupee-sign"></i></span> -->
                                            </li>
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
                                            <li>Mobile Handset Eligibility: <span id="handset"></span></li>
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
                            <div class="ctc-title">DA</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="DA"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrears</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arreares"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Leave Encash</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="LeaveEncash"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Car Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Car_Allowance"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Incentive</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Incentive"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Variable Reimbursement</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="VarRemburmnt"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Variable Adjustment</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="VariableAdjustment"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">City Compensatory Allowance (CCA)</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="CCA"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Relocation Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="RA"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Basic</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Basic"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear HRA</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Hra"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Special Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Spl"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Conveyance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Conv"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">CEA</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="YCea"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">MR</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="YMr"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">LTA</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="YLta"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Car Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Car_Allowance_Arr"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Leave Encash</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_LvEnCash"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Bonus</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Bonus"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear LTA Reimbursement</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_LTARemb"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Relocation Allowance</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_RA"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Arrear Performance Pay</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_PP"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Bonus Adjustment</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Bonus_Adjustment"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Performance Incentive</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="PP_Inc"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">National Pension Scheme</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="NPS"></b></div>
                        </li>
                        <li>
                            <div class="ctc-title">Provident Fund</div>
                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Tot_Pf_Employee"></b></div>
                        </li>
                            <li>
                                <div class="ctc-title">TDS</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="TDS"></b></div>
                            </li>
                        
                            <li>
                                <div class="ctc-title">ESIC</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="ESCI_Employee"></b></div>
                            </li>
                            <li>
                                <div class="ctc-title">NPS Contribution</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="NPS_Value"></b></div>
                            </li>
                            <li>
                                <div class="ctc-title">Arrear PF</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Pf"></b></div>
                            </li>
                            <li>
                                <div class="ctc-title">Arrear ESIC</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Esic"></b></div>
                            </li>
                            <li>
                                <div class="ctc-title">Voluntary Contribution</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="VolContrib"></b></div>
                            </li>
                            <li>
                                <div class="ctc-title">Deduct Adjustment</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="DeductAdjmt"></b></div>
                            </li>
                            <li>
                                <div class="ctc-title">Recovery Special Allowance</div>
                                <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="RecSplAllow"></b></div>
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

                  // Function to update or hide sections based on data
            function updateRowOrHide(rowId, value) {
                const row = document.getElementById(rowId);
                const section = row ? row.closest('li') : null;
                if (!value || value === "0" || value === "0.00" || value === "" || value === "NA") {
                    if (section) section.style.display = 'none'; // Hide the row if no valid data
                } else {
                    if (row) row.innerText = value; // Show and update the row if data exists
                    if (section) section.style.display = ''; // Ensure row is visible
                }
            }
            // Manually add 'twheeler' value with specific formatting
        function updateTwheeler(value) {
            console.log(value);
            const twheelerElement = document.getElementById('twheeler');
            const section = twheelerElement ? twheelerElement.closest('li') : null;

            if (value && value !== "0" && value !== "0.00" && value !== "" && value !== "NA") {
                const pContent = twheelerElement.querySelector('p') ? twheelerElement.querySelector('p').innerText : ''; // Preserve the <p> content
                twheelerElement.innerHTML = `<p>${value} /Km (Approval based for official use)</p>`;  // Append the new value

                if (section) section.style.display = ''; // Show the section if the value is valid
            } else {
                if (section) section.style.display = 'none'; // Hide the section if value is invalid
            }
        }

        function updatefourwheeler(value) {
            console.log(value);
            const fourwheeler = document.getElementById('fwheeler');
            const section = fourwheeler ? fourwheeler.closest('li') : null;

            if (value && value !== "0" && value !== "0.00" && value !== "" && value !== "NA") {
                const pContent = fourwheeler.querySelector('p') ? fourwheeler.querySelector('p').innerText : ''; // Preserve the <p> content
                fourwheeler.innerHTML = `<p>${value} /Km (Approval based for official use)</p>`;  // Append the new value

                if (section) section.style.display = ''; // Show the section if the value is valid
            } else {
                if (section) section.style.display = 'none'; // Hide the section if value is invalid
            }
        }

            // Populate fields using updateRowOrHide
            updateRowOrHide('lodgingA', data.Lodging_CategoryA);
            updateRowOrHide('lodgingB', data.Lodging_CategoryB);
            updateRowOrHide('lodgingC', data.Lodging_CategoryC);
            
            // Check DA_Inside_Hq and hide section if not available
            updateRowOrHide('daHq', data.DA_Inside_Hq);
            document.getElementById('daHqsection').style.display = data.DA_Inside_Hq ? '' : 'none';

            // Other fields
            updateRowOrHide('daOutsideHq', data.DA_Outside_Hq);
            updateTwheeler( data.Travel_TwoWeeKM);
            updatefourwheeler(data.Travel_FourWeeKM);
            updateRowOrHide('group_term', data.Health_Insurance);
            updateRowOrHide('health_ins', data.Term_Insurance);

            // Check Mode_Travel_Outside_Hq and hide section if not available
            updateRowOrHide('outsideHq', data.Mode_Travel_Outside_Hq);
            document.getElementById('classoutside').style.display = data.Mode_Travel_Outside_Hq ? '' : 'none';

            // Handle Mobile Eligibility
            if (data.Mobile_Hand_Elig === "N") {
                document.getElementById('mobileeligibility').style.display = 'none'; // Hide section
            } else {
                document.getElementById('mobileeligibility').style.display = 'block'; // Show section
                document.getElementById('handset').innerText = (data.Mobile_Hand_Elig === "Y") ? "Eligible" : "Not Eligible";
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
                        // Helper function to update or hide a row
                        function updateRowOrHide(rowId, value) {
                                const row = document.getElementById(rowId);
                                
                                // Check if the element exists
                                if (!row) {
                                    console.warn(`Element with ID '${rowId}' not found.`);
                                    return; // Skip if the element is missing
                                }

                        const listItem = row.closest('li'); // Find the <li> element containing this row
                        if (value === null || value === undefined || value === "" || value === 0 || value === "0.00") {
                            listItem.style.display = "none"; // Hide the entire <li> element if there's no valid value
                        } else {
                            row.innerText = formatToInteger(value); // Format and update the value
                            listItem.style.display = ""; // Show the <li> element if there's a valid value
                        }
                    }

                    // Populate the modal with the fetched CTC data
                    document.getElementById('employeeNamectc').innerText = 
                        `${data?.Fname ?? ''} ${data?.Sname ?? ''} ${data?.Lname ?? ''}`.trim();

                    // Monthly Components
                    updateRowOrHide('BAS_Value', data?.BAS_Value);
                    updateRowOrHide('HRA_Value', data?.HRA_Value);
                    updateRowOrHide('Bonus1_Value', data?.Bonus_Month);
                    updateRowOrHide('SpecialAllowance_Value', data?.SPECIAL_ALL_Value);
                    updateRowOrHide('Gross_Monthly_Salary', data?.Tot_GrossMonth);
                    updateRowOrHide('PF_Value', data?.PF_Employee_Contri_Value);
                    updateRowOrHide('Net_Monthly_Salary', data?.NetMonthSalary_Value);

                    // Additional Benefits
                    updateRowOrHide('ChildEduAllowance_Value', data?.CHILD_EDU_ALL_Value);

                    // Annual Components
                    updateRowOrHide('LTA_Value', data?.LTA_Value);
                    updateRowOrHide('InsurancePremium_Value', data?.EmpAddBenifit_MediInsu_value);

                    // Performance-related Details
                    updateRowOrHide('AnnualGrossSalary_Value', data?.Tot_Gross_Annual);
                    updateRowOrHide('Gratuity_Value', data?.GRATUITY_Value);
                    updateRowOrHide('EmployerPF_Value', data?.PF_Employer_Contri_Annul);
                    updateRowOrHide('MediclaimPolicy_Value', data?.Mediclaim_Policy);
                    updateRowOrHide('FixedCTC_Value', data?.Tot_CTC);
                    updateRowOrHide('PerformancePay_Value', data?.VariablePay);
                    updateRowOrHide('TotalCTC_Value', data?.TotCtc);

                    // Additional Fields
                    updateRowOrHide('DA', data?.DA_Value);
                    updateRowOrHide('Arreares', data?.Arrear);
                    updateRowOrHide('LeaveEncash', data?.LeaveEncash);
                    updateRowOrHide('Car_Allowance', data?.Car_Allowance);
                    updateRowOrHide('Incentive', data?.INCENTIVE_Value);
                    updateRowOrHide('VarRemburmnt', data?.VAR_ALL_Value);
                    updateRowOrHide('VariableAdjustment', data?.VariableAdjustment);
                    updateRowOrHide('CCA', data?.CCA);
                    updateRowOrHide('RA', data?.RA);
                    updateRowOrHide('Arr_Basic', data?.Arr_Basic);
                    updateRowOrHide('Arr_Hra', data?.Arr_Hra);
                    updateRowOrHide('Arr_Spl', data?.Arr_Spl);
                    updateRowOrHide('Arr_Conv', data?.Arr_Conv);
                    updateRowOrHide('YCea', data?.CHILD_EDU_ALL_Value);
                    updateRowOrHide('YMr', data?.MED_REM_Value);
                    updateRowOrHide('YLta', data?.LTA_Value);
                    updateRowOrHide('Car_Allowance_Arr', data?.Car_Allowance_Arr);
                    updateRowOrHide('Arr_LvEnCash', data?.Arr_LvEnCash);
                    updateRowOrHide('Arr_Bonus', data?.Arr_Bonus);
                    updateRowOrHide('Arr_LTARemb', data?.Arr_LTARemb);
                    updateRowOrHide('Arr_RA', data?.Arr_RA);
                    updateRowOrHide('Arr_PP', data?.Arr_PP);
                    updateRowOrHide('Bonus_Adjustment', data?.Bonus_Adjustment);
                    updateRowOrHide('PP_Inc', data?.PP_Inc);
                    updateRowOrHide('NPS', data?.NPS);


                    // Deduction Fields
                    updateRowOrHide('Tot_Pf_Employee', data?.PF_Employee_Contri_Value);
                    updateRowOrHide('NPS_Value', data?.NPS_Value);
                    updateRowOrHide('TDS', data?.TDS_Value);
                    updateRowOrHide('ESCI_Employee', data?.ESCI);
                    updateRowOrHide('Arr_Pf', data?.Arr_Pf);
                    updateRowOrHide('Arr_Esic', data?.Arr_Esic);
                    updateRowOrHide('VolContrib', data?.VolContrib);
                    updateRowOrHide('DeductAdjmt', data?.DeductAdjmt);
                    updateRowOrHide('RecSplAllow', data?.RecSplAllow);



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
            $.ajax({
                url: '{{ route('attendance.updatestatus') }}', // Update with your route
                type: 'POST',
                data: formData,
                processData: false,  // Ensure FormData is not processed
                contentType: false,  // Ensure correct content type is sent
                success: function (response) {
                    if (response.success == true) {
                        $('#loader').hide(); 
                        console.log(response);
                        toastr.success(response.message, 'Success', {
                            "positionClass": "toast-top-right",
                            "timeOut": 5000
                        });

                        setTimeout(() => {
                            location.reload(); // Reload the page
                        }, 3000);
                    } else {
                        toastr.error(response.message, 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        $('#loader').hide(); 
                    }
                },
                error: function (xhr) {
                    // Handle any errors from the server
                    toastr.error('An error occurred. Please try again.', 'Error', {
                        "positionClass": "toast-top-right",  
                        "timeOut": 5000 
                    });
                    $('#loader').hide(); 
                }
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
                    }else {
                        document.getElementById('leavetype_day').style.display = 'none'; // Hide the span if invalid
                        document.getElementById('leavetype_label').style.display = 'none'; // Hide the span if invalid

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
                return;
            }

            // Helper function to check if the date is invalid or is a default date like "01/01/1970"
            function isInvalidDate(date) {
                return date === "1970-01-01" || date === "0000-00-00" || date === "";
            }

            // Update modal content dynamically with employee details
            $('#employeeName').text(response.employeeDetails.Fname + ' ' + response.employeeDetails.Sname + ' ' + response.employeeDetails.Lname);
            $('#employeeCode').text(response.employeeDetails.EmpCode);
            $('#designation').text(response.employeeDetails.designation_name);
            $('#department').text(response.employeeDetails.department_name);
            $('#qualification').text(response.employeeDetails.Qualification);
            $('#hqName').text(response.employeeDetails.city_village_name);
            $('#dateJoining').text(formatDate(response.employeeDetails.DateJoining));
            $('#reportingName').text(response.employeeDetails.ReportingName);
            $('#reviewerName').text(response.employeeDetails.ReviewerFname + ' ' + response.employeeDetails.ReviewerSname + ' ' + response.employeeDetails.ReviewerLname);
            $('#totalExperienceYears').text(response.employeeDetails.YearsSinceJoining + ' Years ' + response.employeeDetails.MonthsSinceJoining + ' Months');

            // **Handling Previous Experience Data**
            var experienceData = response.previousEmployers || [];
            console.log(experienceData);

            // Empty the previous employer table before populating
            var experienceTable = $('#experienceTable');
            experienceTable.empty();  // Clear any previous data in the table

            // Check if there's any previous experience data
            if (experienceData.some(function(experience) {
    // Check if any of the values are not empty or null
    return experience.ExpComName.trim() !== '' || 
           experience.ExpDesignation.trim() !== '' || 
           experience.ExpFromDate !== null || 
           experience.ExpToDate !== null || 
           experience.DurationYears !== null;
})) {
                // If there's any valid data, loop through and display it
                experienceData.forEach(function(experience, index) {
                    // Format dates and duration
                    var fromDate = isInvalidDate(experience.ExpFromDate) ? '-' : formatDate(experience.ExpFromDate);
                    var toDate = isInvalidDate(experience.ExpToDate) ? '-' : formatDate(experience.ExpToDate);
                    var duration = experience.DurationYears || '-';

                    // Create the row for the table
                    var row = `<tr>
                        <td>${index + 1}</td>
                        <td>${experience.ExpComName || '-'}</td>
                        <td>${experience.ExpDesignation || '-'}</td>
                        <td>${fromDate}</td>
                        <td>${toDate}</td>
                        <td>${duration}</td>
                    </tr>`;

                    // Append the row to the table
                    experienceTable.append(row);
                });

                // Show the "Previous Employers" section if there is valid data
                $('#prevh5').show();  // Show the "Previous Employers" heading
                $('#careerprev').show();  // Show the "Previous Employers" section
                $('#experienceTable').closest('table').show();  // Show the table
            } else {
                // Hide the "Previous Employers" section if no valid data is available
                $('#prevh5').hide();
                $('#careerprev').hide();
                $('#experienceTable').closest('table').hide();
            }


            // **Handling Career Progression Data**
            var careerProgressionData = response.careerProgression || [];
            var careerProgressionTable = $('#careerProgressionTable');
            careerProgressionTable.empty();  // Clear any previous data in the table
            console.log(careerProgressionData);
            // Check if there's any career progression data
            if (careerProgressionData.length > 0) {
                careerProgressionData.forEach(function(progress, index) {
                    var salaryDateRange = progress.SalaryChange_Date ? progress.SalaryChange_Date : '-';
                    var grade = progress.Current_Grade || '-';
                    var designation = progress.Current_Designation || '-';

                    var row = `<tr>
                        <td>${index + 1}</td>
                        <td>${salaryDateRange}</td>
                        <td>${grade}</td>
                        <td>${designation}</td>
                    </tr>`;

                    careerProgressionTable.append(row);
                });

                // Show the Career Progression section if there's data
                $('#careerh5').show();  // Show the heading
                $('#careerProgressionTable').closest('table').show();  // Show the table
            } else {
                // If no career progression data, hide the section
                $('#careerh5').hide();
                $('#careerProgressionTable').closest('table').hide();
            }

            // Show the modal
            $('#empdetails').modal('show');
        },
        error: function(xhr, status, error) {
            console.log('AJAX error:', status, error);
            alert('An error occurred while fetching the data.');
        }
    });
}

function formatDate(dateString) {
    if (!dateString) return '-';
    var date = new Date(dateString);
    var day = ("0" + date.getDate()).slice(-2);
    var month = ("0" + (date.getMonth() + 1)).slice(-2);
    var year = date.getFullYear();
    return day + '-' + month + '-' + year;
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
    $(document).ready(function () {
            // Convert the PHP data into a format suitable for orgchart.js
            var data = @json($getEmployeeReportingChaind3js);

            // Initialize the org chart with the limited data
            $('#chart-container').orgchart({
                'data': data,
                'nodeContent': 'title',  // This will display the title (designation) in the nodes
                'depth': 2,              // Allow for 2 levels to be visible initially
                'toggle': true,          // Allow for expanding/collapsing nodes
                'pan': true,             // Allow panning if the chart overflows
                'visibleLevel': 2,       // Ensure only the first two levels are visible
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
#chart-container {
  font-family: Arial;
  height: 420px;
  border: 1px solid #aaa;
  overflow: auto;
  text-align: center;
}
.orgchart {
    background-image: none !important;
}
.orgchart {
    background-image: none !important;
}
.orgchart .node .title {
    background-color: #76a0a3;
}

</style>
