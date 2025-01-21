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
                                    <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2" style="float:right;">HOD/Reviewer</label>
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="hod_view" 
                                        id="hod-view" 
                                        {{ request()->has('hod_view') ? 'checked' : '' }} 
                                        onchange="toggleLoader(); this.form.submit();" 
                                        >
                                </div>
                                <input type="hidden" name="month" value="{{ request()->input('month', $selectedMonth) }}">

                            </form>
                        @endif
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
						
                        @if(count($attendanceData) > 0 && count(collect($attendanceData)->pluck('leaveApplications')->flatten()) > 0)
                        <div class="card ad-info-card-">
						<div class="card-header">
                            <h5 class="float-start mt-1"><b>My Team Leave Request</b></h5>
                                <!-- Filter Form for Leave Status -->
                            <div class="float-end">
                                <form method="GET" action="{{ url()->current() }}">
                                    <select id="leaveStatusFilter" name="leave_status" style="float:right;">
                                        <option value="">All</option>
                                        <option value="0" {{ request()->get('leave_status', '0') == '0' ? 'selected' : '' }}>Pending</option>
                                        <option value="2" {{ request()->get('leave_status') == '2' ? 'selected' : '' }}>Approved</option>
                                        <option value="3" {{ request()->get('leave_status') == '3' ? 'selected' : '' }}>Rejected</option>

                                    </select>
                                </form>
                            </div>
                        </div>
						
						<!-- Check if any employee has leave applications -->
                            <div class="card-body" style="overflow-y: scroll;overflow-x: hidden;">
                                <table class="table text-center" id="leavetable">
                                    <thead>
                                        <tr>
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
                                                        <td>{{ $leave->Fname . ' ' . $leave->Sname . ' ' . $leave->Lname ?? 'N/A' }}</td>
                                                        <td>{{ $leave->EmpCode ?? 'N/A' }}</td>
                                                        <td>{{ $leave->Leave_Type ?? 'N/A' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($leave->Apply_FromDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($leave->Apply_ToDate)->format('d-m-Y') ?? 'N/A' }}</td>
                                                        <td>{{ $leave->Apply_TotalDay ?? 'N/A' }}</td>
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
                                        <!-- Filter Form -->
                                    <div class="float-end ">
                                        <form method="GET" action="{{ url()->current() }}">
                                            <select id="statusFilter" name="status" style="float:right;">
                                                <option value="">All</option>
                                                <option value="0" {{ request()->get('status', '0') == '0' ? 'selected' : '' }}>Pending</option>
                                                <option value="1" {{ request()->get('status') == '1' ? 'selected' : '' }}>Approved</option>
                                                <option value="2" {{ request()->get('status') == '2' ? 'selected' : '' }}>Rejected</option>

                                            </select>
                                        </form>
                                    </div>
							</div>
							<div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
                            <!-- Table -->
                            <table id="attendanceTable" class="table text-center">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>EC</th>
                                        <th>Request Date</th>
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
                                                <td>{{ $attendanceRequest->Fname . ' ' . $attendanceRequest->Sname . ' ' . $attendanceRequest->Lname ?? 'N/A' }}</td>
                                                <td>{{ $attendanceRequest->EmpCode ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendanceRequest->ReqDate)->format('d/m/Y') ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendanceRequest->AttDate)->format('d/m/Y') ?? 'N/A' }}</td>
                                                <!-- <td>
                                                    @if(!empty($attendanceRequest->InRemark))
                                                        {{ $attendanceRequest->InRemark }}
                                                    @elseif(!empty($attendanceRequest->OutRemark))
                                                        {{ $attendanceRequest->OutRemark }}
                                                    @else
                                                        {{ $attendanceRequest->Remark ?? 'N/A' }}
                                                    @endif
                                                </td> -->
                                                <td  title="{{ !empty($attendanceRequest->InRemark) ? $attendanceRequest->InRemark : ( !empty($attendanceRequest->OutRemark) ? $attendanceRequest->OutRemark : ($attendanceRequest->Remark ?? 'N/A') ) }}" style="cursor: pointer;text-align:left;">
                                                            {{ \Str::words(!empty($attendanceRequest->InRemark) ? $attendanceRequest->InRemark : ( !empty($attendanceRequest->OutRemark) ? $attendanceRequest->OutRemark : ($attendanceRequest->Remark ?? 'N/A') ), 5, '...') }}
                                                            </td>
                                                            <td>
                                                    @if($attendanceRequest->Status == 0)
                                                        Pending
                                                    @elseif($attendanceRequest->Status == 2)
                                                        Rejected
                                                    @elseif($attendanceRequest->Status == 1)
                                                        Approved
                                                 
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
                                                        @elseif($attendanceRequest->Status == 1)
                                                            <span class="badge bg-success">Approved</span>
                                                        @elseif($attendanceRequest->Status == 2)
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @elseif($attendanceRequest->Status == 0)
                                                            <span class="badge bg-warning">Draft</span>
                                                        <!-- @elseif($attendanceRequest->Status == 4)
                                                            <span class="badge bg-secondary">Cancelled</span> -->
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
                        <style>
                            th, td { white-space: nowrap; }
                            .datatable .dataTables_wrapper {
                               width: auto;
                               margin: 0 auto;
                           }
                           .dtfc-fixed-start{
                               background-color: #d0dce1 !important;
                           }
                           th.dtfc-fixed-left{
                            background-color: #d0dce1 !important;
                           }
                       </style>
							</div>
                            <div class="card-body datatable dataTables_wrapper">
                                <table class="table text-center table-bordered" id="atttable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="sorting_disabled dtfc-fixed-left" colspan="3" style="left:0;position: sticky;">Details</th>
                                            <th class="sorting_disabled dtfc-fixed-left" colspan="5" style="left:237.672px;position:sticky;">Leave Opening</th>
                                            
                                            <th colspan="{{ $daysInMonth }}">Month</th>

                                            <th colspan="3">Total</th>
                                            <th colspan="5">Leave Closing</th>
                                        </tr>
                                        <tr>
                                            <th>Sn</th>
                                            <th>EC</th>
                                            <th>Name</th>
                                            <th class="tb4">CL</th>
                                            <th class="tb5">PL</th>
                                            <th class="tb6">EL</th>
                                            <th class="tb7">FL</th>
                                            <th class="tb8">SL</th>

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
                                        $indexxxatt = 1;?>
                                        @foreach ($empdataleaveattdata as $index => $dataa)
                                        @foreach ($dataa as  $data)

                                            <tr>
                                                <td>{{ $indexxxatt ++}}</td>
                                                <td>{{ $data->empcode }}</td>  <!-- Employee Code -->

                                                <td style="text-align:left;">{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }} </td> <!-- Full Name -->

                                                <td>{{ number_format($data->OpeningCL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningPL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningEL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningOL, 0) }}</td>
                                                <td>{{ number_format($data->OpeningSL, 0) }}</td>


                                                @for ($i = 1; $i <= $daysInMonth; $i++)
                                                    <td>
                                                        {{-- Display attendance status for each day or blank if no data --}}
                                                        @php
                                                            $dayStatus = isset($data->{'day_' . $i}) ? $data->{'day_' . $i} : '-';
                                                            $innTime = isset($data->{'Inn_' . $i}) ? $data->{'Inn_' . $i} : '-';
                                                            $outtTime = isset($data->{'Outt_' . $i}) ? $data->{'Outt_' . $i} : '-';

                                                            // Format Inn and Outt times to show only hour and minute (HH:MM)
                                                            if ($innTime != '-') {
                                                                $innTime = date('H:i', strtotime($innTime));
                                                            }

                                                            if ($outtTime != '-') {
                                                                $outtTime = date('H:i', strtotime($outtTime));
                                                            }
                                                        @endphp

                                                        {{-- Display the attendance status and Inn/Outt times --}}
                                                        <div>
                                                    <!-- <span class="teamleaveatt">{{ $dayStatus }}</span><br> -->
                                                    <span class="teamleaveatt 
                                                                @if ($dayStatus == 'P') status-present
                                                                @elseif ($dayStatus == 'OD') status-od
                                                                @elseif ($dayStatus == 'A') status-absent
                                                                @elseif ($dayStatus == 'HO') status-holiday
                                                                @else status-other
                                                                @endif">
                                                                {{ $dayStatus }}
                                                            </span><br>
                                                    @if ($dayStatus != '-' && $innTime != '-' && $outtTime != '-')
                                                        <span class="teampunchtime">In: {{ $innTime }}  Out: {{ $outtTime }}</span>
                                                    @endif
                                                </div>
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
                        <div class="form-group mb-0" id="remarkInGroupReq" style="display: none;">
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
                            <textarea name="reportRemarkIn" class="form-control" id="reportRemarkInReq" maxlength="50" placeholder="Enter your remarks"></textarea>
                        </div>
                        
                        <div class="form-group mb-0" id="reasonOutGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <input type="text" id="reasonOutDisplay" class="form-control"
                                style="border: none; background: none;"></input>
                        </div>

                        <div class="form-group" id="remarkOutGroupReq" style="display: none;">
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
                        

                        <div class="form-group" id="reasonOtherGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Reason:</b></label>
                            <input type="text" id="reasonOtherDisplay" class="form-control"
                                style="border: none; background: none;" readonly>
                        </div>

                        <div class="form-group" id="remarkOtherGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Remark:</b></label>
                            <input type="text" name="remarkOther" class="form-control" id="remarkOtherReq" readonly>
                        </div>
                        <div class="form-group s-opt" id="statusGroupOther" style="display: none;">
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
                            <label for="queryName">Name</label>
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
           // Show sections based on reason validity
           if (isInReasonValid && isOutReasonValid) {
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
                                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                                });
                           $('#loader').hide(); 

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
                        document.getElementById('leavetype_day').style.display = 'none'; // Hide the span if invalid
                        document.getElementById('leavetype_label').style.display = 'none'; // Hide the span if invalid

                    }
                $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));
                // Display status as text (Approved or Rejected)
                const statusDropdown = document.getElementById('StatusDropdown');
                statusDropdown.value = status; // Set 'approved' or 'rejected'
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
            
            $(document).ready(function() {
        
                
    $('#approvalatt').DataTable({
        "paging": true,       // Enable pagination
        "ordering": false,     // Disable column sorting
        "info": true,         // Display information about the table
        "lengthChange": false, // Disable length change (optional)
        "searching": false,   // Disable searching
    });
   
    });
// JavaScript to filter table rows based on selected status
$('#statusFilter').change(function() {
    var selectedStatus = $(this).val(); // Get the selected status

    // Filter the table rows based on the selected status
    $('#attendanceTable tbody tr').each(function() {
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
    $('#statusFilter').trigger('change');
});
// JavaScript to filter table rows based on selected leave status
$('#leaveStatusFilter').change(function() {
    var selectedStatus = $(this).val(); // Get the selected leave status

    // Filter the table rows based on the selected status
    $('#leavetable tbody tr').each(function() {
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
    $('#leaveStatusFilter').trigger('change'); // Trigger the change to apply default "Pending" filter
});
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
/* Additional color classes for each status */
.status-present {
    background-color: #f3f0F0; /* Green for Present (P) */
    color: black;
}

.status-od {
    background-color: #FF80FF; /* Blue for On Duty (OD) */
    color: black;
}

.status-absent {
    background-color: #ff0000; /* Red for Absent (A) */
    color: black;
}

.status-holiday {
    background-color: #3cb82c; /* Orange for Holiday (HO) */
    color: black;
}

.status-other {
    background-color: rgb(100, 177, 255); /* Gray for Other (undefined status) */
    color: black;
}

/* Optional: Styles for the times section */
.teampunchtime {
    font-size: 0.8em;
    color: #555;
}
