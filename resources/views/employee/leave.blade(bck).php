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
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Attendance/Leave</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                        <!-- Start Card-->
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Sick Leave(SL)</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="pie-wrapper" style="margin: 0 auto;">
                                        <div style="border-color: #659093;" class="arc" data-value=""></div>
                                        <span class="score"> Day</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <span class="float-start me-2">
                                        <span class="teken-leave">&nbsp;</span>
                                        {{ (isset($leaveBalance) && $leaveBalance->OpeningSL !== null && $leaveBalance->CreditedSL !== null)
    ? $leaveBalance->OpeningSL + $leaveBalance->CreditedSL
    : '0' }} Day
                                    </span>
                                    <span class="float-start me-2">
                                        <span class="upcoming-leave">&nbsp;</span>
                                        {{ isset($leaveBalance) && $leaveBalance->AvailedSL !== null
    ? $leaveBalance->AvailedSL
    : '0' }} Day
                                    </span>
                                    <span class="float-start">
                                        <span class="availabel-leave">&nbsp;</span>
                                        {{ isset($leaveBalance) && $leaveBalance->BalanceSL !== null
    ? $leaveBalance->BalanceSL
    : '0' }} Day
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    @isset($leaveBalance)
                    <!-- Casual Leave -->
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Casual Leave (CL)</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="pie-wrapper" style="margin: 0 auto;">
                                        <div style="border-color: #659093;" class="arc" data-value="">
                                            <span></span>
                                        </div>
                                        <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                            data-value="{{ $leaveBalance->AvailedCL * 100 / max(($leaveBalance->OpeningCL + $leaveBalance->CreditedCL), 1) }}">
                                        </div>
                                        <span class="score">{{ $leaveBalance->AvailedCL ?? 0 }} Day</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <span class="float-start me-2"><span class="teken-leave">&nbsp;</span>
                                        {{ ($leaveBalance->OpeningCL + $leaveBalance->CreditedCL) ?? 0 }} Day</span>
                                    <span class="float-start me-2"><span class="upcoming-leave">&nbsp;</span>
                                        {{ $leaveBalance->AvailedCL ?? 0 }} Day</span>
                                    <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                        {{ $leaveBalance->BalanceCL ?? 0 }} Day</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Privilege Leave -->
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Privilege Leave (PL)</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="pie-wrapper" style="margin: 0 auto;">
                                        <div style="border-color: #659093;" class="arc" data-value=""></div>
                                        <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                            data-value="{{ $leaveBalance->AvailedPL * 100 / max(($leaveBalance->OpeningPL + $leaveBalance->CreditedPL), 1) }}">
                                        </div>
                                        <span class="score">{{ $leaveBalance->AvailedPL ?? 0 }} Day</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <span class="float-start me-2"><span class="teken-leave">&nbsp;</span>
                                        {{ ($leaveBalance->OpeningPL + $leaveBalance->CreditedPL) ?? 0 }} Day</span>
                                    <span class="float-start me-2"><span class="upcoming-leave">&nbsp;</span>
                                        {{ $leaveBalance->AvailedPL ?? 0 }} Day</span>
                                    <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                        {{ $leaveBalance->BalancePL ?? 0 }} Day</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earned Leave -->
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Earned Leave (EL)</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="pie-wrapper" style="margin: 0 auto;">
                                        <div style="border-color: #659093;" class="arc" data-value=""></div>
                                        <span class="score">{{ $leaveBalance->AvailedEL ?? 0 }} Day</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <span class="float-start me-1"><span class="teken-leave">&nbsp;</span>
                                        {{ ($leaveBalance->OpeningEL + $leaveBalance->CreditedEL) ?? 0 }} Day</span>
                                    <span class="float-start me-1"><span class="upcoming-leave">&nbsp;</span>
                                        {{ $leaveBalance->AvailedEL ?? 0 }} Day</span>
                                    <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                        {{ $leaveBalance->BalanceEL ?? 0 }} Day</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Festival Leave -->
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Festival Leave (FL)</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="pie-wrapper" style="margin: 0 auto;">
                                        <div style="border-color: #659093;" class="arc" data-value=""></div>
                                        <span class="score">{{ $leaveBalance->AvailedOL ?? 0 }} Day</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <span class="float-start me-2"><span class="teken-leave">&nbsp;</span>
                                        {{ ($leaveBalance->OpeningOL + $leaveBalance->CreditedOL) ?? 0 }} Day</span>
                                    <span class="float-start me-2"><span class="upcoming-leave">&nbsp;</span>
                                        {{ $leaveBalance->AvailedOL ?? 0 }} Day</span>
                                    <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                        {{ $leaveBalance->BalanceOL ?? 0 }} Day</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Monthly Attendance</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div style="border-color: #659093;margin:6px;" class="arc" data-value=""></div>
                                    <span class="me-4">Leave: <b>{{ $TotalLeaveCount ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Holiday: <b>{{ $TotalHoliday ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Outdoor Duties: <b>{{ $TotalOnDuties ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Present: <b>{{ $TotalPR ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Absent/ LWP: <b>{{ $TotalAbsent ?? 0 }} Days</b></span>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                        <div class="card ad-info-card-" style="height:143px;">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Monthly Attendance</b></h5>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p style="font-size:10px;">
                                            <span class="me-4">Leave: <b>{{ $TotalLeaveCount ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Holiday: <b>{{ $TotalHoliday ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Outdoor Duties: <b>{{ $TotalOnDuties ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Present: <b>{{ $TotalPR ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Absent/ LWP: <b>{{ $TotalAbsent ?? 0 }} Days</b></span><br>
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div> -->

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body">
                                <span class="leave-availabel float-start me-4"><span
                                        class="teken-leave">&nbsp;</span>Used Leave</span>
                                <span class="leave-availabel float-start me-4"><span
                                        class="upcoming-leave">&nbsp;</span>Plan Leave</span>
                                <span class="leave-availabel float-start"><span
                                        class="availabel-leave">&nbsp;</span>Balance Leave</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">

                        <div class="mfh-machine-profile">
                            <ul class="nav nav-tabs" id="myTab1" role="tablist"
                                style="background-color:#a5cccd;border-radius: 10px 10px 0px 0px;">
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link active" data-bs-toggle="tab"
                                        href="#LeaveStatistics" role="tab" aria-controls="LeaveStatistics"
                                        aria-selected="true">Attendance</a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link" data-bs-toggle="tab" href="#ApplyLeave"
                                        role="tab" aria-controls="ApplyLeave" aria-selected="false">Apply Leave</a>
                                </li>
                            </ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                                <div class="tab-pane fade active show" id="LeaveStatistics" role="tabpanel">
                                    <div class="card chart-card">
                                        <div class="card-header">
                                            <h4 class="has-btn float-start mt-2"></H4>
                                            <span class="float-end">
                                                <select class="select2 form-control select-opt" id="monthname"
                                                    fdprocessedid="7n33b9">
                                                    <option value="select">Select Month </option>
                                                </select>
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <table class="calendar">
                                                <thead>
                                                    <tr class="weekday">
                                                        <th>Sunday</th>
                                                        <th>Monday</th>
                                                        <th>Tuesday</th>
                                                        <th>Wednesday</th>
                                                        <th>Thursday</th>
                                                        <th>Friday</th>
                                                        <th>Saturday</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                    </tr>

                                                </tbody>
                                            </table>
                                            <!-------------------------end----------------------->
                                        </div>
                                    </div>
                                    <!--<div class="card chart-card">
												<img class="w-100-" src="./images/Group 61.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 62.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 66.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 72.png">
											</div>
											<h5>Multi date leave</h5>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 67.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 68.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 69.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 73.png">
											</div> -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card ad-info-card-">
                                            <div class="card-body">
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-present">&nbsp;</span>Present(P)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-absent">&nbsp;</span>Absent(A)</span>
                                                <span class="leave-availabel float-start me-4">
                                                    <span class="repre-ch">&nbsp;</span>Half day CL(CH)</span>
                                                <span class="leave-availabel float-start me-4">
                                                    <span class="repre-sh">&nbsp;</span>Half day SL(SH)</span>
                                                <span class="leave-availabel float-start me-4">
                                                    <span class="repre-ph">&nbsp;</span>Half day PL(PH)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-ho">&nbsp;</span>Holiday(HO)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-od">&nbsp;</span>Outdoor Duties(OD)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-fl">&nbsp;</span>Festival Leaves(FL)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-tl">&nbsp;</span>Transfer Leave(TL)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-wfh">&nbsp;</span>Work from home(WFH)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="ApplyLeave" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="alert alert-danger" id="leaveMessage" style="display: none;">
                                            </div>

                                            <form id="leaveForm" action="{{ route('leaveform') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="employee_id"
                                                    value="{{ Auth::user()->EmployeeID }}">

                                                <div class="row">
                                                    <!-- General From Date -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="fromDate" class="col-form-label">From
                                                                Date</label>
                                                            <input class="form-control" type="date" id="fromDate"
                                                                name="fromDate" required min="{{ date('Y-m-d') }}"
                                                                value="{{ date('Y-m-d') }}">
                                                        </div>
                                                    </div>

                                                    <!-- General To Date -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="toDate" class="col-form-label">To Date</label>
                                                            <input class="form-control" type="date" id="toDate"
                                                                name="toDate" required min="{{ date('Y-m-d') }}"
                                                                value="{{ date('Y-m-d') }}">
                                                        </div>
                                                    </div>

                                                    <!-- New HTML Structure for SL -->
                                                    <!-- <div class="col-xl-4" id="slDateSectionFrom" style="display:none;">
                                                        <div class="form-group s-opt">
                                                            <label for="fromDateSL" class="col-form-label">From Date
                                                                (SL)</label>
                                                            <input class="form-control" type="date" id="fromDateSL"
                                                                name="fromDateSL" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4" id="slDateSectionTo" style="display:none;">
                                                        <div class="form-group s-opt">
                                                            <label for="toDateSL" class="col-form-label">To Date
                                                                (SL)</label>
                                                            <input class="form-control" type="date" id="toDateSL"
                                                                name="toDateSL" required>
                                                        </div>
                                                    </div> -->

                                                    <!-- Leave Type -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="leaveType" class="col-form-label">Leave
                                                                Type</label>
                                                            <select class="select2 form-control select-opt"
                                                                id="leaveType" name="leaveType" required>
                                                                <option value="" disabled selected>Select Leave Type
                                                                </option> <!-- Default option -->

                                                                @isset ($leaveBalance)
                                                                    @if ($leaveBalance->BalanceCL > 0)
                                                                        <option value="CL">Casual Leave (Available:
                                                                            {{ $leaveBalance->BalanceCL }})
                                                                        </option>
                                                                    @endif
                                                                    @if ($leaveBalance->BalanceSL > 0)
                                                                        <option value="SL">Sick Leave (Available:
                                                                            {{ $leaveBalance->BalanceSL }})
                                                                        </option>
                                                                    @endif
                                                                    @if ($leaveBalance->BalancePL > 0)
                                                                        <option value="PL">Privilege Leave (Available:
                                                                            {{ $leaveBalance->BalancePL }})
                                                                        </option>
                                                                    @endif
                                                                    @if ($leaveBalance->BalanceEL > 0)
                                                                        <option value="EL">Earned Leave (Available:
                                                                            {{ $leaveBalance->BalanceEL }})
                                                                        </option>
                                                                    @endif
                                                                    @if ($leaveBalance->BalanceOL > 0)
                                                                        <option value="OL">Festival Leave(Available:
                                                                            {{ $leaveBalance->BalanceOL }})
                                                                        </option>
                                                                    @endif
                                                                @else
                                                                <option value="">No leave types available</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Optional Holidays Dropdown -->
                                                    <div class="col-xl-4" id="holidayDropdown" style="display: none;">
                                                        <div class="form-group s-opt">
                                                            <label for="optionalHoliday" class="col-form-label">Select
                                                                Holiday</label>
                                                            <select class="select2 form-control select-opt"
                                                                id="optionalHoliday" name="optionalHoliday">
                                                                <option value="" disabled selected>Select Holiday
                                                                </option> <!-- Default option -->

                                                                @if(isset($optionalHolidays) && $optionalHolidays->isNotEmpty())
                                                                    @foreach ($optionalHolidays as $holiday)
                                                                        <option value="{{ $holiday->HoOpDate }}">
                                                                            {{ $holiday->HoOpName }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No optional holidays available</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Option -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="option" class="col-form-label">Option</label>
                                                            <select class="select2 form-control select-opt" id="option"
                                                                name="option" required>
                                                                <option value="fullday">Full Day</option>
                                                                <option value="1sthalf">1st Half</option>
                                                                <option value="2ndhalf">2nd Half</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Contact No -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="contactNo" class="col-form-label">Contact
                                                                No.</label>
                                                            <input class="form-control" type="text" id="contactNo"
                                                                name="contactNo" placeholder="Enter contact number"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <!-- Address -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="address" class="col-form-label">Address</label>
                                                            <input class="form-control" type="text" id="address"
                                                                name="address" placeholder="Enter address" required>
                                                        </div>
                                                    </div>
                                                    <!-- Reason for Leave -->
                                                    <div class="form-group">
                                                        <label for="reason" class="col-form-label">Reason for
                                                            Leave</label>
                                                        <textarea class="form-control" id="reason" name="reason"
                                                            placeholder="Enter reason" required></textarea>
                                                    </div>
                                                    <!-- Submit Button -->
                                                    <div class="form-group mb-0">
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">

                                                    <div class="card-header mb-4 mt-4">
                                                        <h4 class="has-btn">Leave List</h4>
                                                    </div>
                                                    <table class="table table-styled mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Apply Date</th>
                                                                <th>From Date</th>
                                                                <th>To Date</th>
                                                                <th>Total</th>
                                                                <th>Leave Type</th>
                                                                <th>Reporting Reason</th>

                                                                <th>Leave Reason</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach(Auth::user()->employeeleave as $index => $leave)

                                                                <tr class="leave-row">
                                                                    <td>{{ $index + 1 }}.</td>
                                                                    <td style="width:80px;">{{ $leave->Apply_Date }}</td>
                                                                    <td style="width:80px;">{{ $leave->Apply_FromDate }}
                                                                    </td>
                                                                    <td style="width:80px;">{{ $leave->Apply_ToDate }}</td>
                                                                    <td style="width:70px;">{{ $leave->Apply_TotalDay }}
                                                                        {{ $leave->Apply_TotalDay == 1 ? 'Day' : 'Days' }}
                                                                    </td>
                                                                    <td style="width:80px;">
                                                                        <label class="mb-0 badge badge-secondary" title=""
                                                                            data-original-title="{{ $leave->Leave_Type }}">{{ $leave->Leave_Type }}</label>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $leave->LeaveRevReason }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $leave->Apply_Reason }}</p>
                                                                    </td>
                                                                    <td style="text-align:right;">
                                                                        @if ($leave->LeaveStatus == 0)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline danger-outline"
                                                                                title=""
                                                                                data-original-title="Draft">Reject/Draft</label>
                                                                        @elseif ($leave->LeaveStatus == 1)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline success-outline"
                                                                                title=""
                                                                                data-original-title="Pending">Approved</label>
                                                                        @elseif ($leave->LeaveStatus == 2)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline success-outline"
                                                                                title=""
                                                                                data-original-title="Approved">Approved</label>
                                                                        @elseif ($leave->LeaveStatus == 3)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline danger-outline"
                                                                                title=""
                                                                                data-original-title="Disapproved">Disapproved</label>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="text-right pt-2">
                                                        <nav>
                                                            <ul class="pagination" id="pagination"></ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                        <div class="card chart-card" id="late_card">
                            <div class="card-header" id="late_card_header">
                                <h4 class="has-btn"></h4>
                            </div>
                            <div class="card-body">
                                <div class="late-atnd">

                                </div>

                            </div>
                        </div>



                        <div class="card chart-card">
                            <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link active" data-bs-toggle="tab"
                                        href="#MonthHoliday" role="tab" aria-controls="MonthHoliday"
                                        aria-selected="true">Holiday</a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link" data-bs-toggle="tab"
                                        href="#FestivalLeave" role="tab" aria-controls="FestivalLeave"
                                        aria-selected="false">Festival Leave (Optional)</a>
                                </li>
                            </ul>

                            <div class="tab-content ad-content2" id="myTabContent2">
                                <!-- Holiday Section -->
                                <div class="tab-pane fade active show" id="MonthHoliday" role="tabpanel">
                                    <div class="card-body" style="height:450px;overflow-y:auto;">
                                        @if($holidays->isEmpty())
                                            <p>No holidays available.</p>
                                            <!-- Hide the 'All Holiday List' button if there are no holidays -->
                                            <button class="btn-outline secondary-outline mr-2 sm-btn mt-2" disabled>No Holidays Available</button>
                                        @else
                                            @foreach ($holidays as $holiday)
                                                <div class="holiday-entry d-flex align-items-center">
                                                    <h6 class="mb-0 me-2">
                                                        <strong class="text-bold">{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d M') }}</strong>
                                                    </h6>
                                                    <label class="mb-0 me-2"><strong class="text-bold">{{ $holiday->HolidayName }}</strong></label>
                                                    <span class="float-start"><strong class="text-bold">{{ $holiday->Day }}</strong></span>
                                                </div>
                                                @if(!empty($holiday->fes_image_path))
                                                    <img class="mb-2"
                                                        src="{{ asset('images/holiday_fes_image/' . $holiday->fes_image_path) }}"
                                                        alt="{{ $holiday->HolidayName }}" /><br>
                                                @endif
                                            @endforeach
                                            <!-- Show the 'All Holiday List' button only if holidays exist -->
                                            <a class="btn-outline secondary-outline mr-2 sm-btn mt-2" href=""
                                            data-bs-toggle="modal" data-bs-target="#model3">All Holiday List</a>
                                        @endif
                                    </div>
                                </div>

                                <!-- Festival Leave Section -->
                                <div class="tab-pane fade" id="FestivalLeave" role="tabpanel">
                                    <div class="card-body" style="height:450px;overflow-y:auto;">
                                        @if($optionalHolidays->isEmpty())
                                            <p>No optional holidays available for this year.</p>
                                        @else
                                            @foreach($optionalHolidays as $optionalHoliday)
                                                <div class="fest-leave">
                                                    <label class="mb-0">{{ $optionalHoliday->HoOpName }}</label><br>
                                                    <span class="float-start">{{ \Carbon\Carbon::parse($optionalHoliday->HoOpDate)->format('l') }}</span>
                                                    <span class="float-end">
                                                        <label class="mb-0 badge badge-success toltiped">{{ \Carbon\Carbon::parse($optionalHoliday->HoOpDate)->format('d M') }}</label>
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card chart-card d-none">
                            <div class="card-header">
                                <h4 class="has-btn">Leave Suggestion</h4>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2">August - 2 Days </h6>
                                <table class="table table-styled mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">15 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0 ">Independence Day Holiday</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">16 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">PL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">17 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">PL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">18 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Sunday</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">19 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Raksha Bandhan Holiday</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>Do you want apply this leave</p>
                                <a class="btn-outline secondary-outline mr-2 sm-btn mt-2 float-end" href="">Yes</a>
                                <br>
                                <hr>
                                <br>
                                <h6 class="mb-2">Ocotober - 3 Days </h6>
                                <table class="table table-styled mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">2 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Gandhi jayanti Holiday</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">3 October</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">EL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">4 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">EL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">5 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">EL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">6 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Sunday</label>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <p>Do you want apply this leave</p>
                                <a class="btn-outline secondary-outline mr-2 sm-btn mt-2 float-end" href="">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ad-footer-btm">
                    <p><a href="">Terms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd
                        India All Rights Reserved.</p>
                </div>
            </div>
                                </div>
                        </div>
                            <!--Holiday list modal-->
                            <div class="modal fade show" id="model3" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
                                style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle3">
                                                {{ isset($currentYear) ? $currentYear : 'Current Year' }} - Holiday List
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-styled mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Holiday Name</th>
                                                        <th>Date</th>
                                                        <th>Day</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($all_holidays) && $all_holidays->isEmpty())
                                                        <tr>
                                                            <td colspan="4" class="text-center">No holidays available for this year.</td>
                                                        </tr>
                                                    @elseif(isset($all_holidays))
                                                        @foreach($all_holidays as $index => $holiday)
                                                            <tr>
                                                                <td>{{ $index + 1 }}.</td>
                                                                <td>
                                                                    @if(!empty($holiday->fes_image_path))
                                                                        <img style="width: 110px;"
                                                                            src="{{ asset('images/holiday_fes_image/' . $holiday->fes_image_path) }}"
                                                                            alt="{{ $holiday->HolidayName }}" />
                                                                    @endif
                                                                    <span class="img-thumb">
                                                                        <span class="ml-2">{{ $holiday->HolidayName }}</span>
                                                                    </span>
                                                                </td>
                                                                <td>{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d/m/Y') }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('l') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="4" class="text-center">Holidays data not found.</td>
                                                        </tr>
                                                    @endif
                                                </tbody>


                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


    <!--Attendence Authorisation-->
    <div class="modal fade" id="AttendenceAuthorisation" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="responseMessage" class="text-success" style="display: none;"></p>

                    <p>This option is only for missed attendance or late In-time/early out-time attendance and not for
                        leave applications. <span class="text-danger">Do not apply leave here.</span></p>
                    <br>
                    <p><b></b><span id="request-date"></span></p>
                    <form id="attendanceForm" method="POST" action="{{ route('attendance.authorize') }}">
                        @csrf
                        <div id="request-date"></div>
                        <input type="hidden" id="employeeid" name="employeeid">
                        <input type="hidden" id="Atct" name="Atct">
                        <input type="hidden" id="requestDate" name="requestDate">

                        <div class="form-group" id="reasonInGroup" style="display: none;">
                            <label class="col-form-label">Reason In:</label>
                            <select name="reasonIn" class="form-control" id="reasonInDropdown">
                                <option value="">Select Reason</option>

                            </select>
                        </div>

                        <div class="form-group" id="remarkInGroup" style="display: none;">
                            <label class="col-form-label">Remark In:</label>
                            <input type="text" name="remarkIn" class="form-control" id="remarkIn"
                                placeholder="Remark In">
                        </div>

                        <div class="form-group" id="reasonOutGroup" style="display: none;">
                            <label class="col-form-label">Reason Out:</label>
                            <select name="reasonOut" class="form-control" id="reasonOutDropdown">
                                <option value="">Select Reason</option>

                            </select>
                        </div>

                        <div class="form-group" id="remarkOutGroup" style="display: none;">
                            <label class="col-form-label">Remark Out:</label>
                            <input type="text" name="remarkOut" class="form-control" id="remarkOut"
                                placeholder="remark out">
                        </div>
                        <div class="form-group" id="otherReasonGroup" style="display: none;">
                            <label class="col-form-label">Other Reason:</label>
                            <select name="otherReason" class="form-control" id="otherReasonDropdown">
                                <option value="">Select Reason</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>


                        <div class="form-group" id="otherRemarkGroup" style="display: none;">
                            <label class="col-form-label">Other Remark:</label>
                            <input type="text" name="otherRemark" class="form-control" id="otherRemark"
                                placeholder="other remark">
                        </div>

                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendButton">Send</button>
                </div>
            </div>
        </div>
    </div>

    @include('employee.footer');
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentDate = new Date();
            const currentMonthIndex = currentDate.getMonth(); // 0 = January, 1 = February, etc.
            const currentYear = currentDate.getFullYear();

            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const monthDropdown = document.getElementById('monthname');
            const cardHeaders = document.querySelectorAll('.card-header h4');
            const late_card_header = document.querySelector('#late_card_header h4');


            monthDropdown.innerHTML = `<option value="select">Select Month</option>`;

            // Populate the dropdown with all months
            for (let i = currentMonthIndex; i >= 0; i--) {
                const month = monthNames[i];
                monthDropdown.innerHTML += `<option value="${month}">${month}</option>`;
            }
            // Optionally select the current month
            // monthDropdown.value = monthNames[currentMonthIndex];

            // Add the previous month option
            const previousMonthIndex = (currentMonthIndex - 1 + 12) % 12;
            const previousMonth = monthNames[previousMonthIndex];
            // monthDropdown.innerHTML += `<option value="${previousMonth}">${previousMonth}</option>`;

            // Fetch attendance data for the current month on page load
            fetchAttendanceData(monthNames[currentMonthIndex], currentYear);
            const rowsPerPage = 5; // Number of records per page
            const rows = document.querySelectorAll('.leave-row'); // Get all leave rows
            const pagination = document.getElementById('pagination');
            const totalPages = Math.ceil(rows.length / rowsPerPage);

            function showPage(page) {
                // Hide all rows
                rows.forEach((row, index) => {
                    row.style.display = (Math.floor(index / rowsPerPage) === page) ? '' : 'none';
                });
            }

            function createPagination() {

                for (let i = 0; i < totalPages; i++) {
                    const li = document.createElement('li');

                    li.className = 'page-item';
                    li.innerHTML = `<a class="page-link" href="#">${i + 1}</a>`;

                    li.addEventListener('click', function () {
                        showPage(i);
                    });
                    pagination.appendChild(li);
                }
            }

            createPagination();
            showPage(0);

            const leaveTypeSelect = document.getElementById('leaveType');
            const holidayDropdown = document.getElementById('holidayDropdown');
            const optionSelect = document.getElementById('option');
            const fromDateInput = document.getElementById('fromDate');
            const toDateInput = document.getElementById('toDate');
            const slDateSectionFrom = document.getElementById('slDateSectionFrom');
            const slDateSectionTo = document.getElementById('slDateSectionTo');
            const fromDateSLInput = document.getElementById('fromDateSL');
            const toDateSLInput = document.getElementById('toDateSL');

            // Leave balances
            const balanceCL = {{ isset($leaveBalance) ? $leaveBalance->BalanceCL : 0 }}; // Casual Leave balance
            const balanceSL = {{ isset($leaveBalance) ? $leaveBalance->BalanceSL : 0 }}; // Sick Leave balance

            leaveTypeSelect.addEventListener('change', function () {
                console.log(this.value);

                // Reset the option selection
                optionSelect.selectedIndex = 0; // Reset to the first option
                holidayDropdown.style.display = 'none'; // Hide holiday dropdown by default
                optionSelect.querySelectorAll('option').forEach(option => {
                    option.style.display = 'block'; // Reset to show all options
                });

                // Show general date fields
                fromDateInput.parentElement.parentElement.style.display = 'block'; // Show general From Date
                toDateInput.parentElement.parentElement.style.display = 'block'; // Show general To Date



                if (this.value === 'OL') {
                    holidayDropdown.style.display = 'block';
                    optionSelect.value = 'fullday'; // Auto-select Full Day
                    optionSelect.querySelectorAll('option').forEach(option => {
                        option.style.display = (option.value === 'fullday') ? 'block' : 'none'; // Hide others
                    });

                } else if (this.value === 'EL' || this.value === 'PL') {
                    holidayDropdown.style.display = 'none';
                    optionSelect.value = 'fullday'; // Auto-select Full Day
                    optionSelect.querySelectorAll('option').forEach(option => {
                        option.style.display = (option.value === 'fullday') ? 'block' : 'none'; // Hide others
                    });
                    setDateLimits();
                } else if (this.value === 'CL') {
                    holidayDropdown.style.display = 'none';
                    optionSelect.value = 'fullday'; // Auto-select Full Day

                    // Determine which options to show based on leave balance
                    if (balanceCL >= 1) {
                        optionSelect.querySelectorAll('option').forEach(option => {
                            option.style.display = 'block'; // Show all options
                        });
                    } else {
                        optionSelect.querySelectorAll('option').forEach(option => {
                            if (option.value === '1sthalf' || option.value === '2ndhalf') {
                                option.style.display = 'block'; // Show half-day options
                            } else {
                                option.style.display = 'none'; // Hide full day option
                            }
                        });
                    }
                    setDateLimits();
                } else if (this.value === 'SL') {
                    fromDateInput.parentElement.parentElement.style.display = 'block'; // Show general From Date
                    toDateInput.parentElement.parentElement.style.display = 'block'; // Show general To Date

                    // Determine options based on Sick Leave balance
                    if (balanceSL >= 1) {
                        optionSelect.querySelectorAll('option').forEach(option => {
                            option.style.display = 'block'; // Show all options
                        });
                    } else {
                        optionSelect.querySelectorAll('option').forEach(option => {
                            if (option.value === '1sthalf' || option.value === '2ndhalf') {
                                option.style.display = 'block'; // Show half-day options
                            } else {
                                option.style.display = 'none'; // Hide full day option
                            }
                        });
                    }
                    setDateLimits();
                }

                function setDateLimits() {
                    // Reset date inputs min and max when changing leave type
                    const currentDate = new Date();
                    const threeDaysAgo = new Date(currentDate);
                    threeDaysAgo.setDate(currentDate.getDate() - 3);
                    const minDate = threeDaysAgo.toISOString().split('T')[0]; // Three days ago

                    // Set min dates for the general inputs
                    fromDateInput.min = minDate; // Allow dates from 3 days ago
                    toDateInput.min = minDate; // Allow dates from 3 days ago

                    // Clear max to allow selection of any past date
                    fromDateInput.max = ""; // No maximum limit
                    toDateInput.max = ""; // No maximum limit

                    // Default to today's date
                    fromDateInput.value = currentDate.toISOString().split('T')[0]; // Default From Date to today
                    toDateInput.value = currentDate.toISOString().split('T')[0]; // Default To Date to today
                }
            });

            // Automatically set from and to dates when a holiday is selected
            document.getElementById('optionalHoliday').addEventListener('change', function () {
                const selectedHolidayDate = this.value; // Get selected holiday date
                fromDateInput.value = selectedHolidayDate; // Set From Date to the holiday date
                toDateInput.value = selectedHolidayDate;   // Set To Date to the holiday date

                // Set min and max for both date inputs
                fromDateInput.min = selectedHolidayDate;
                fromDateInput.max = selectedHolidayDate;
                toDateInput.min = selectedHolidayDate;
                toDateInput.max = selectedHolidayDate;
            });




            monthDropdown.addEventListener('change', function () {
                const selectedMonth = this.value;
                if (selectedMonth !== "select") {
                    fetchAttendanceData(selectedMonth, currentYear);
                }
            });
            document.addEventListener('click', function (event) {
                if (event.target.closest('.open-modal')) {
                    event.preventDefault();

                    const link = event.target.closest('.open-modal');
                    const employeeId = link.getAttribute('data-employee-id');
                    const date = link.getAttribute('data-date');
                    const innTime = link.getAttribute('data-inn');
                    const outTime = link.getAttribute('data-out');
                    const II = link.getAttribute('data-II');
                    const OO = link.getAttribute('data-OO');
                    const atct = link.getAttribute('data-atct');
                    const dataexist = link.getAttribute('data-exist');
                    const status = link.getAttribute('data-status');
                    const draft = link.getAttribute('data-draft');
                    // Determine classes based on conditions
                    const lateClass = (innTime > II) ? 'text-danger' : '';
                    const earlyClass = (outTime < OO) ? 'text-danger' : '';
                    // Initialize content for request-date
                    if (dataexist === 'true') {
                        // Select the modal footer and hide it
                        const modalFooter = document.getElementById('modal-footer');
                        console.log(modalFooter)
                        if (modalFooter) {
                            modalFooter.style.display = 'none';
                        }
                    }
                    console.log(draft);
                    // Initialize content for request-date
                    let requestDateContent = `
                            <div style="text-align: left;">
                                <b>Request Date: ${date}</b>
                                <span style="color: ${draft === '3' || draft === null ? 'red' : (status === '1' ? 'green' : 'red')}; float: right; ${draft === '0' ? 'display: none;' : ''}">
                                    <b style="color: black; font-weight: bold;">Status:</b> 
                                    ${draft === '3' || draft === null ? 'Draft' : (status === '1' ? 'Approved' : 'Rejected')}
                                </span>
                            </div>
                        `;
                    // Check conditions for In
                    if (innTime > II) {
                        requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
                    } else if (innTime <= II) {
                        requestDateContent += `In: <span>${innTime}On Time</span><br>`; // Optional: show "On Time" if needed
                    }

                    // Check conditions for Out
                    if (outTime < OO) {
                        requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
                    } else if (outTime >= OO) {
                        requestDateContent += `Out: <span>${outTime}On Time</span>`; // Optional: show "On Time" if needed
                    }

                    // Set innerHTML only if there is content to display
                    document.getElementById('request-date').innerHTML = requestDateContent;

                    document.getElementById('employeeid').value = employeeId;
                    document.getElementById('Atct').value = atct;
                    document.getElementById('requestDate').value = date;

                    // Clear previous values and hide all groups
                    document.getElementById('remarkIn').value = '';
                    document.getElementById('remarkOut').value = '';
                    // document.getElementById('reasonInDropdown').innerHTML = '';
                    // document.getElementById('reasonOutDropdown').innerHTML = '';

                    document.getElementById('reasonInGroup').style.display = 'none';
                    document.getElementById('remarkInGroup').style.display = 'none';
                    document.getElementById('reasonOutGroup').style.display = 'none';
                    document.getElementById('remarkOutGroup').style.display = 'none';

                    // Fetch company_id and department_id based on employeeId
                    fetch(`/api/getEmployeeDetails/${employeeId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            const companyId = data.company_id;
                            const departmentId = data.department_id;

                            // Fetch reasons based on companyId and departmentId
                            return fetch(`/api/getReasons/${companyId}/${departmentId}`);
                        })
                        .then(response => response.json())
                        .then(reasons => {
                            // Populate the reason dropdowns
                            reasons.forEach(reason => {
                                const optionIn = document.createElement('option');
                                optionIn.value = reason.ReasonId;
                                optionIn.textContent = reason.reason_name;
                                document.getElementById('reasonInDropdown').appendChild(optionIn);

                                const optionOut = document.createElement('option');
                                optionOut.value = reason.ReasonId;
                                optionOut.textContent = reason.reason_name;
                                document.getElementById('reasonOutDropdown').appendChild(optionOut);

                                const optionOther = document.createElement('option');
                                optionOther.value = reason.ReasonId;
                                optionOther.textContent = reason.reason_name;
                                document.getElementById('otherReasonDropdown').appendChild(optionOther);
                            });
                        })
                        .catch(error => console.error('Error fetching reasons:', error));

                    let inConditionMet = false;
                    let outConditionMet = false;
                    if (innTime === outTime) {
                        remarkInGroup.style.display = 'none';
                        reasonInGroup.style.display = 'none';
                        remarkOutGroup.style.display = 'none';
                        reasonOutGroup.style.display = 'none';
                        document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
                        document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input

                    }
                    else {
                        // Your existing time condition logic...
                        if (innTime > II) {
                            remarkInGroup.style.display = 'block';
                            reasonInGroup.style.display = 'block';
                            // document.getElementById('remarkIn').value = 'Your remark for late in';
                            inConditionMet = true;
                        }
                        if (outTime == '00:00') {
                            remarkOutGroup.style.display = 'block';
                            reasonOutGroup.style.display = 'block';
                            // document.getElementById('remarkOut').value = 'Your remark for early out';
                            document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                            document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

                        }

                        if (outTime < OO) {
                            remarkOutGroup.style.display = 'block';
                            reasonOutGroup.style.display = 'block';
                            // document.getElementById('remarkOut').value = 'Your remark for early out';
                            outConditionMet = true;
                        }

                        // If both conditions are met, display both groups
                        if (inConditionMet && outConditionMet) {
                            remarkInGroup.style.display = 'block';
                            reasonInGroup.style.display = 'block';
                            remarkOutGroup.style.display = 'block';
                            reasonOutGroup.style.display = 'block';
                            document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                            document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

                        }
                    }
                    const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
                    modal.show();
                }
            });



            document.getElementById('reasonInDropdown').addEventListener('change', function () {
                const selectedIn = this.value;
                const selectedOut = document.getElementById('reasonOutDropdown').value;

                // If an "In" reason is selected, check if an "Out" reason is selected
                if (selectedIn && selectedOut) {
                    // You could choose to prevent changing or notify the user here if needed
                    console.log('Both reasons are selected, no changes made.');
                }
            });

            document.getElementById('reasonOutDropdown').addEventListener('change', function () {
                const selectedOut = this.value;
                const selectedIn = document.getElementById('reasonInDropdown').value;

                // If an "Out" reason is selected, check if an "In" reason is selected
                if (selectedIn && selectedOut) {
                    // You could choose to prevent changing or notify the user here if needed
                    console.log('Both reasons are selected, no changes made.');
                }
            });

            document.getElementById('sendButton').addEventListener('click', function () {
                const form = document.getElementById('attendanceForm');

                // Use Fetch API to submit the form
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        const responseMessage = document.getElementById('responseMessage');

                        // Set the message text
                        responseMessage.innerText = data.message;

                        // Show the message box
                        responseMessage.style.display = 'block';

                        if (data.success) {
                            // Apply the success class (green)
                            responseMessage.classList.remove('text-danger'); // Remove danger class if present
                            responseMessage.classList.add('text-success'); // Add success class for green
                        } else {
                            // Apply the danger class (red) for errors
                            responseMessage.classList.remove('text-success'); // Remove success class if present
                            responseMessage.classList.add('text-danger'); // Add danger class for red
                        }
                    })

                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request.');
                    });
            });

            function fetchAttendanceData(selectedMonth, year) {
                const monthNumber = monthNames.indexOf(selectedMonth) + 1;
                const employeeId = {{ Auth::user()->EmployeeID }};

                cardHeaders.forEach(header => {
                    header.textContent = `${selectedMonth} ${year}`;
                });
                if (late_card_header) {
                    late_card_header.textContent = `Late List ${selectedMonth} ${year}`;
                }

                fetch(`/attendance/${year}/${monthNumber}/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const calendar = document.querySelector('.calendar tbody');
                        calendar.innerHTML = '';

                        const daysInMonth = new Date(year, monthNumber, 0).getDate();
                        const firstDayOfMonth = new Date(year, monthNumber - 1, 1).getDay();

                        let currentRow = document.createElement('tr');
                        let latenessCount = 0;


                        // Get the lateness container
                        const latenessContainer = document.querySelector('.late-atnd');
                        latenessContainer.innerHTML = ''; // Clear previous lateness data

                        // Fill empty cells for the first week
                        for (let i = 0; i < firstDayOfMonth; i++) {
                            const emptyCell = document.createElement('td');
                            emptyCell.classList.add('day');
                            currentRow.appendChild(emptyCell);
                        }

                        for (let day = 1; day <= daysInMonth; day++) {
                            const dayData = data.find(record => {
                                const recordDate = new Date(record.AttDate);
                                return recordDate.getDate() === day && recordDate.getMonth() + 1 === monthNumber;
                            });

                            const cell = document.createElement('td');
                            cell.classList.add('day');
                            const today = new Date();
                            today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison
                            // Determine if the day is a Sunday
                            const currentDate = new Date(year, monthNumber - 1, day);
                            if (currentDate.getDay() === 0) { // 0 is Sunday
                                cell.style.backgroundColor = 'rgb(209,243,174)';
                                cell.innerHTML = `<div class="day-num">${day}</div>`; // Just show the day number
                            }
                            else {
                                if (dayData) {
                                    const attValue = dayData.AttValue;
                                    const innTime = dayData.Inn;
                                    const iiTime = dayData.II;
                                    console.log(dayData);

                                    let Atct = 0; // Initialize Atct
                                    if (dayData.InnLate == 1 && dayData.OuttLate == 0) {
                                        Atct = 1;
                                    } else if (dayData.InnLate == 0 && dayData.OuttLate == 1) {
                                        Atct = 2;
                                    } else if (dayData.InnLate == 1 && dayData.OuttLate == 1) {
                                        Atct = 12;
                                    } else if ((dayData.InnLate == 0 || dayData.InnLate === '') && (dayData.OuttLate == 0 || dayData['OuttLate'] === '')) {
                                        Atct = 3;
                                    }
                                    let latenessStatus = '';

                                    // Assuming this logic is part of a loop or multiple data checks
                                    // Check if there's lateness data to append
                                    if (innTime > iiTime || dayData.Outt < dayData.OO) {
                                        latenessCount++;
                                        latenessStatus = `L${latenessCount}`;

                                        // Determine if we need to add the "danger" class
                                        const punchInDanger = innTime > iiTime ? 'danger' : '';
                                        const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';

                                        // Determine the status label and set up the modal link if needed
                                        let statusLabel = '';
                                        let modalLink = '';

                                        if (dayData.Status === 0) {
                                            statusLabel = 'Request';
                                            modalLink = `
                                                <a href="#" class="open-modal" 
                                                data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                data-inn="${innTime}" 
                                                data-out="${dayData.Outt}" 
                                                data-ii="${dayData.II}" 
                                                data-oo="${dayData.OO}" 
                                                data-atct="${Atct}" 
                                                data-status="${dayData.Status}" 
                                                data-employee-id="${employeeId}">
                                                    ${statusLabel}
                                                </a>`;
                                        } else if (dayData.Status === 1) {
                                            statusLabel = 'Approved';
                                        }

                                        // Append the lateness data as usual
                                        latenessContainer.innerHTML += `
                                                <div class="late-atnd">
                                                    <div>
                                                        <span class="late-l1">${latenessStatus}</span>
                                                        <h6 class="float-start mt-2">${day} ${monthNames[monthNumber - 1]} ${year}</h6>
                                                        <div class="float-end mt-1">
                                                            <label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="${statusLabel}">
                                                                ${dayData.Status === 0 ? modalLink : statusLabel}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div style="color:#777171; float: left; width: 100%; margin-top:5px;">
                                                        <span class="float-start">Punch in <span class="${punchInDanger}"><b>${innTime}</b></span></span>
                                                        <span class="float-end">Punch Out <span class="${punchOutDanger}"><b>${dayData.Outt || '00:00'}</b></span></span>
                                                    </div>
                                                </div>
                                                `;
                                    }

                                    // If no lateness data was added, show the "No Late Data" message
                                    if (latenessContainer.innerHTML.trim() === '') {
                                        latenessContainer.innerHTML = `<b class="float-start mt-2 no-late-data">No Late Data</b>`;
                                    } else {
                                        // Add a class to hide the "No Late Data" message when data is present
                                        const noLateDataMessage = document.querySelector('.no-late-data');
                                        if (noLateDataMessage) {
                                            noLateDataMessage.style.display = 'none';
                                        }
                                    }


                                    // Icon logic
                                    let iconHtml = '';
                                    const today = new Date();
                                    const isCurrentMonth = monthNumber === today.getMonth() + 1;
                                    const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month

                                    if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        if (dayData.Inn > dayData.II || dayData.Outt < dayData.OO || dayData.Inn === dayData.Outt) {
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        }
                                    }

                                    // Append iconHtml to your cell if needed
                                    if (iconHtml) {
                                        cell.innerHTML += iconHtml;
                                    }
                                    let attenBoxContent = '';
                                    if (latenessStatus && dayData.Status === 0) {
                                        attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    }

                                    if (latenessStatus && dayData.Status === 1) {
                                        // If status is 1 and latenessStatus already shown, do not add it again
                                        if (!attenBoxContent.includes(latenessStatus)) {
                                            attenBoxContent += `<span class="atte-late-status">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                        }
                                    }
                                    draft = (dayData.DraftStatus === null || dayData.DraftStatus === "null" || dayData.DraftStatus === "") ? 0 : Number(dayData.DraftStatus);


                                    switch (attValue) {
                                        case 'P':
                                            attenBoxContent += `<span class="atte-present">P</span>`;
                                            attenBoxContent += `
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" 
                                            data-employee-id="${employeeId}" data-exist="${dayData.DataExist}"data-status="${dayData.Status}" data-draft="${draft}">
                                                 ${iconHtml}
                                            </a>
                                        `;
                                            break;
                                        case 'A':
                                            attenBoxContent += `<span class="atte-absent">A</span>`;
                                            break;
                                        case 'HO':
                                            attenBoxContent += `<span class="holiday-cal">${attValue}</span>`;
                                            break;
                                        case 'OD':
                                            attenBoxContent += `<span class="atte-OD">${attValue}</span>`;
                                            break;
                                        case 'PH':
                                        case 'CH':
                                        case 'SH':
                                        case 'PL':
                                        case 'FL':
                                        case 'SL':
                                        case 'CL':
                                            attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                            break;
                                        default:
                                            attenBoxContent += `
                                            <span class="atte-present"></span>
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" data-employee-id="${employeeId}">
                                                 ${iconHtml}
                                            </a>
                                        `;
                                            break;
                                    }


                                    const punchInDanger = dayData.Inn > dayData.II ? 'danger' : '';
                                    const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';

                                    cell.innerHTML = `
                                        <div class="day-num">${day}</div>
                                        <div class="punch-section">
                                            <span class="${punchInDanger}"><b>In:</b> ${innTime || '00:00'}</span><br>
                                            <span class="${punchOutDanger}"><b>Out:</b> ${dayData.Outt || '00:00'}</span>
                                        </div>
                                        <div class="atten-box">${attenBoxContent}</div>
                                    `;
                                }
                                else {
                                    const today = new Date();
                                    today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

                                    let iconHtml = '';
                                    const isCurrentMonth = monthNumber === today.getMonth() + 1;
                                    const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month

                                    if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;


                                    }
                                    cell.innerHTML = `
                                    <div class="day-num">${day}</div>
                                    <div class="atten-box">
                                        <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="00:00" data-out="00:00" data-ii="00:00" data-oo="00:00" data-atct="3" data-employee-id="${employeeId}"data-draft="0">
                                                 ${iconHtml}
                                        </a></div>`;

                                }
                            }

                            currentRow.appendChild(cell);

                            if ((firstDayOfMonth + day) % 7 === 0) {
                                calendar.appendChild(currentRow);
                                currentRow = document.createElement('tr');
                            }
                        }

                        if (currentRow.childElementCount > 0) {
                            calendar.appendChild(currentRow);
                        }
                    })
                    .catch(error => console.error('Error fetching attendance data:', error));
            }

        });

        $(document).ready(function () {
            $('#leaveForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                const url = $(this).attr('action'); // Form action URL
                const employeeId = {{ Auth::user()->EmployeeID }};
                $.ajax({
                    url: url, // Form action URL
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#leaveMessage').show(); // Show the message div
                        if (response.success) {
                            $('#leaveMessage').removeClass('alert-danger').addClass('alert-success')
                                .text('Form submitted successfully!').show();
                            // Fetch the updated leave list
                            fetchLeaveList(employeeId);
                        } else {
                            $('#leaveMessage').removeClass('alert-success').addClass('alert-danger')
                                .text(response.message).show();
                        }
                    },
                    error: function (xhr, status, error) {
                        $('#leaveMessage').removeClass('alert-success').addClass('alert-danger')
                            .text('An error occurred: ' + error).show();
                    }
                });
            });

            function fetchLeaveList(employeeId) {
                $.ajax({
                    url: '{{ route('fetchLeaveList') }}', // Update with your actual route
                    type: 'GET',
                    data: { employee_id: employeeId }, // Pass employee ID
                    success: function (data) {
                        // Assuming 'data' contains the HTML for the leave list
                        $('tbody').html(data.html);
                    },
                    error: function (xhr, status, error) {
                        alert('Could not fetch leave list: ' + error);
                    }
                });
            }

        });
        $(document).ready(function () {
            $('#AttendenceAuthorisation').on('hidden.bs.modal', function () {
                location.reload(); // Reloads the page when the modal is closed
            });
        });


    </script>