@include('employee.head')
@include('employee.header')
@include('employee.sidebar')


<body class="mini-sidebar">
<div id="loader" style="display: none;">
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
                <!-- Loader (hidden by default) -->
                <div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                    <div class="row">
                    <div id="loader" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>

                        </div>
                        <!-- @isset($leaveBalance) -->
                            
                        <!-- Casual Leave (CL) -->
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body dd-flex align-items-center border-bottom-d" style="height:162px;">
                                    <h5 class="mb-2 w-100"><b>Casual Leave (CL) </b></h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="pie-wrapper" style="margin: 0 auto;">
                                            <div style="border-color: #659093;" class="arc" data-value="">
                                                <span></span>
                                            </div>
                                            <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                                data-value="{{ $leaveBalance->BalanceCL * 100 / max(($leaveBalance->OpeningCL + $leaveBalance->AvailedCL), 1) }}">
                                            </div>
                                            <span class="score">{{ $leaveBalance->BalanceCL ?? 0 }} Day</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                        <span class="float-start me-2"><span class="teken-leave">&nbsp;</span>
                                            {{ (int)$leaveBalance->OpeningCL ?? 0 }} Day</span>
                                        <span class="float-start me-2"><span class="upcoming-leave">&nbsp;</span>
                                            {{ (int)$leaveBalance->AvailedCL ?? 0 }} Day</span>
                                        <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                            {{ (int)$leaveBalance->BalanceCL ?? 0 }} Day</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sick Leave (SL) -->

                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                                <div class="card ad-info-card-">
                                    <div class="card-body dd-flex align-items-center border-bottom-d" style="height:162px;">
                                        <h5 class="mb-2 w-100"><b>Sick Leave(SL)</b></h5>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="pie-wrapper" style="margin: 0 auto;">
                                                <div style="border-color: #659093;" class="arc" data-value="">
                                                    <span></span>
                                                </div>
                                                <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                                    data-value="{{ $leaveBalance-> BalanceSL * 100 / max(($leaveBalance->OpeningSL + $leaveBalance->AvailedSL), 1) }}">
                                                </div>
                                                <span class="score">{{ $leaveBalance->BalanceSL ?? 0 }} Day</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <span class="float-start me-2">
                                                <span class="teken-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->OpeningSL ?? '0' }} Day
                                            </span>
                                            <span class="float-start me-2">
                                                <span class="upcoming-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->AvailedSL ?? '0' }} Day
                                            </span>
                                            <span class="float-start">
                                                <span class="availabel-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->BalanceSL ?? '0' }} Day
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            

                            <!-- Privilege Leave (PL) -->
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                                <div class="card ad-info-card-">
                                    <div class="card-body dd-flex align-items-center border-bottom-d" style="height:162px;">
                                        <h5 class="mb-2 w-100"><b>Privilege Leave (PL)</b></h5>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="pie-wrapper" style="margin: 0 auto;">
                                                <div style="border-color: #659093;" class="arc" data-value=""></div>
                                                <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                                    data-value="{{ $leaveBalance->BalancePL * 100 / max(($leaveBalance->OpeningPL + $leaveBalance->AvailedPL), 1) }}">
                                                </div>
                                                <span class="score">{{ $leaveBalance->BalancePL ?? 0 }} Day</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <span class="float-start me-2"><span class="teken-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->OpeningPL ?? 0 }} Day</span>
                                            <span class="float-start me-2"><span class="upcoming-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->AvailedPL ?? 0 }} Day</span>
                                            <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->BalancePL ?? 0 }} Day</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Earned Leave (EL) -->
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                                <div class="card ad-info-card-">
                                    <div class="card-body dd-flex align-items-center border-bottom-d" style="height:162px;">
                                        <h5 class="mb-2 w-100"><b>Earned Leave (EL)</b></h5>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="pie-wrapper" style="margin: 0 auto;">
                                                <div style="border-color: #659093;" class="arc" data-value=""></div>
                                                <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                                    data-value="{{ $leaveBalance->BalanceEL * 100 / max(($leaveBalance->OpeningEL + $leaveBalance->AvailedEL), 1) }}">
                                                </div>
                                                <span class="score">{{ $leaveBalance->BalanceEL ?? 0 }} Day</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <span class="float-start me-1"><span class="teken-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->OpeningEL ?? 0 }} Day</span>
                                            <span class="float-start me-1"><span class="upcoming-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->AvailedEL ?? 0 }} Day</span>
                                            <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                                {{(int)$leaveBalance->BalanceEL ?? 0 }} Day</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Festival Leave (FL) -->
                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                                <div class="card ad-info-card-">
                                    <div class="card-body dd-flex align-items-center border-bottom-d"style="height:162px;">
                                        <h5 class="mb-2 w-100"><b>Festival Leave (FL)</b></h5>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="pie-wrapper" style="margin: 0 auto;">
                                                <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                                    data-value="{{ $leaveBalance->BalanceOL * 100 / max(($leaveBalance->OpeningOL + $leaveBalance->AvailedOL), 1) }}">
                                                </div>
                                                <span class="score">{{ $leaveBalance->BalanceOL ?? 0 }} Day</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                            <span class="float-start me-2"><span class="teken-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->OpeningOL ?? 0 }} Day</span>
                                            <span class="float-start me-2"><span class="upcoming-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->AvailedOL ?? 0 }} Day</span>
                                            <span class="float-start"><span class="availabel-leave">&nbsp;</span>
                                                {{ (int)$leaveBalance->BalanceOL ?? 0 }} Day</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- @endisset -->

                        <!-- Monthly Attendance -->
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body dd-flex align-items-center border-bottom-d" style="height:162px;">
                                    
                                    <h5 class="mb-1 w-100"><b>Month Att.-</b><small id="month-name"></small>
                                    </h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div style="border-color: #659093;margin:6px;" class="arc" data-value=""></div>
                                        <span class="me-4">Leave: <b>{{ (int)$TotalLeaveCount ?? 0 }} Days</b>,</span><br>
                                        <span class="me-4">Holiday: <b>{{ (int)$TotalHoliday ?? 0 }} Days</b>,</span><br>
                                        <span class="me-4">Outdoor Duties: <b>{{ (int)$TotalOnDuties ?? 0 }} Days</b>,</span><br>
                                        <span class="me-4">Present: <b>{{ (int)$TotalPR ?? 0 }} Days</b>,</span><br>
                                        <span class="me-4">Absent/ LWP: <b>{{ (int)$TotalAbsent ?? 0 }} Days</b></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Leave Legend -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body">
                                    <span class="leave-availabel float-start me-4"><span class="teken-leave">&nbsp;</span>Opening Leave</span>
                                    <span class="leave-availabel float-start me-4"><span class="upcoming-leave">&nbsp;</span>Availed Leave</span>
                                    <span class="leave-availabel float-start"><span class="availabel-leave">&nbsp;</span>Balance Leave</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Dashboard End -->

                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">

                        <div class="mfh-machine-profile">
                            <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;">   
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
                                            <div class="float-end form-group s-opt">
                                                <select class="select2 form-control select-opt" id="monthname" fdprocessedid="7n33b9">
                                                    <option value="select">Select Month </option>
                                                </select>
                                                <span class="sel_arrow">
                                                    <i class="fa fa-angle-down"></i>
                                                </span>
                                            </div>
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
                                                    <!-- Leave Type -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                        <label for="leaveType" class="col-form-label">
                                                                    Leave Type <span class="required">*</span>
                                                                </label>

                                                            <select class="select2 form-control form-select select-opt"
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
                                                            <!-- Add a message for "Festival Leave" availability -->
                                                            <small id="festivalLeaveMessage" class="text-danger" style="display:none;">
                                                                No festival leave left for this year.
                                                            </small>
                                                        </div>
                                                    </div>
                                                      
                                                    <!-- General From Date -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="fromDate" class="col-form-label">From
                                                                Date  <span class="required">*</span></label>
                                                            <input class="form-control" type="date" id="fromDate"
                                                                name="fromDate" required min="{{ date('Y-m-d') }}"
                                                                value="{{ date('Y-m-d') }}">
                                                        </div>
                                                        <div id="festivalLeaveMessageoption" style="display: none; color: red; margin-top: 10px;">
                                                            Please select festival leave option first.
                                                        </div>
                                                    </div>

                                                    <!-- General To Date -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="toDate" class="col-form-label">To Date <span class="required">*</span></label>
                                                            <input class="form-control" type="date" id="toDate"
                                                                name="toDate" required min="{{ date('Y-m-d') }}"
                                                                value="{{ date('Y-m-d') }}">
                                                        </div>
                                                         <div id="festivalLeaveMessageoptiontodate" style="display: none; color: red; margin-top: 10px;">
                                                            Please select festival leave option first.
                                                        </div>
                                                    </div>
                                                <!-- Optional Holidays Dropdown -->
                                                    <div class="col-xl-4" id="holidayDropdown" style="display: none;">
                                                        <div class="form-group s-opt">
                                                            <label for="optionalHoliday" class="col-form-label">Select
                                                                Holiday</label>
                                                            <select class="select2 form-control form-select select-opt"
                                                                id="optionalHoliday" name="optionalHoliday">
                                                                <option value="" disabled selected>Select Holiday
                                                                </option> <!-- Default option -->

                                                                @if(isset($optionalHolidays) && $optionalHolidays->isNotEmpty())
                                                                    @foreach ($optionalHolidays as $holiday)
                                                                    <option value="{{ \Carbon\Carbon::parse($holiday->HoOpDate)->toDateString() }}">
                                                                        {{ $holiday->HoOpName }} ({{ \Carbon\Carbon::parse($holiday->HoOpDate)->format('d-m-Y') }})
                                                                    </option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">No optional holidays available</option>
                                                                @endif
                                                            </select>
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

                                                    
                                                 
                                                    <!-- Option -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="option" class="col-form-label">Option</label>
                                                            <select class="select2 form-control form-select select-opt" id="option"
                                                                name="option" required >
                                                                <option value="fullday">Full Day</option>
                                                                <option value="1sthalf">1st Half</option>
                                                                <option value="2ndhalf">2nd Half</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Contact No -->
                                                    <div class="col-xl-4">
                                                            <div class="form-group s-opt">
                                                                <label for="contactNo" class="col-form-label">Contact No.</label>
                                                                <input class="form-control" type="tel" id="contactNo" name="contactNo" 
                                                                    placeholder="Enter contact number" maxlength="12" 
                                                                    oninput="validatePhoneNumber(this)" required>
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

                                                    <div class="card-header-card mb-4 mt-4">
                                                        <h4 class="has-btn"><b>Leave List</b></h4>
                                                    </div>
                                                    <table class="table table-styled mb-0" id="atttableleave">
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
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach(Auth::user()->employeeleave as $index => $leave)
                                                           
                                                           

                                                                <tr class="leave-row">
                                                                    <td>{{ $index + 1 }}.</td>
                                                                    <td style="width:80px;"> {{ \Carbon\Carbon::parse($leave->Apply_Date)->format('d/m/Y') ?? ''}}</td>
                                                                    <td style="width:80px;">{{ \Carbon\Carbon::parse($leave->Apply_FromDate)->format('d/m/Y') ?? ''}}</td>
                                                                    <td style="width:80px;">{{ \Carbon\Carbon::parse($leave->Apply_ToDate)->format('d/m/Y') ?? ''}}</td>

                                                                    <td style="width:70px;">{{ $leave->Apply_TotalDay }}
                                                                        {{ $leave->Apply_TotalDay == 1 ? 'Day' : 'Days' }}
                                                                    </td>
                                                                    <td style="width:80px;">
                                                                     @php
                                                                            $backgroundColor = match($leave->Leave_Type) {
                                                                                'CH', 'SH', 'PL', 'SL', 'CL','EL' => 'rgb(100, 177, 255)', // Light blue for various types
                                                                                'FL' => '#14d6e0', // Cyan
                                                                                default => 'gray', // Default color for unknown types
                                                                            };
                                                                        @endphp

                                                                        <label class="mb-0 badge badge-secondary" 
                                                                            title="" 
                                                                            data-original-title="{{ $leave->Leave_Type }}"
                                                                            style="background-color: {{ $backgroundColor }};">
                                                                            {{ $leave->Leave_Type }}
                                                                        </label>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $leave->LeaveRevReason }}</p>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $leave->Apply_Reason }}</p>
                                                                    </td>
                                                                    <td>
                                                                        @if ($leave->LeaveStatus == 0)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: red;" title="" data-original-title="Draft">Draft</p>
                                                                        @elseif ($leave->LeaveStatus == 1)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: green;" title="" data-original-title="Pending">Approved</p>
                                                                        @elseif ($leave->LeaveStatus == 2)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: green;" title="" data-original-title="Approved">Approved</p>
                                                                        @elseif ($leave->LeaveStatus == 3)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: orange;" title="" data-original-title="Reject">Rejected</p>
                                                                        @elseif ($leave->LeaveStatus == 4)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: red;" title="" data-original-title="Cancelled">Cancelled</p>
                                                                        @endif

                                                                        <!-- Display cancellation status on the same line -->
                                                                        @if ($leave->cancellation_status == 1)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: green; display:inline;" title="" data-original-title="Cancellation Status"> - Cancellation Approved</p>
                                                                        @elseif ($leave->cancellation_status == 0)
                                                                            <p style="padding:6px 13px;font-size: 11px; color: red; display:inline;" title="" data-original-title="Cancellation Status"> - Cancellation Rejected</p>
                                                                        @else
                                                                            <!-- If cancellation status is not set -->
                                                                            <p style="padding:6px 13px;font-size: 11px; color: grey; display:inline;" title="" data-original-title="Cancellation Status"> -</p>
                                                                        @endif
                                                                    </td>



                                                                    <td style="text-align:right;">
                                                                        @if ($leave->LeaveStatus == 3)
                                                                            <!-- Show Delete button if status is Draft -->
                                                                            <button class="sm-btn btn-outline danger-outline" style="font-size: 11px;" title="Delete" data-original-title="Delete" data-leave-id="{{$leave->ApplyLeaveId}}" onclick="deleteLeaveRequest({{$leave->ApplyLeaveId}})">Delete</button>
                                                                        @elseif ($leave->LeaveStatus == 1)
                                                                            <!-- Check if Apply_FromDate is from the current date to the future -->
                                                                            @php
                                                                                $currentDate = \Carbon\Carbon::now(); // Get the current date and time
                                                                                $applyFromDate = \Carbon\Carbon::parse($leave->Apply_FromDate); // Convert Apply_FromDate to Carbon instance
                                                                            @endphp
                                                                            
                                                                            @if ($applyFromDate >= $currentDate->startOfDay()) 
                                                                                <!-- Show Apply Cancellation button if status is Approved or Pending and Apply_FromDate is today or in the future -->
                                                                                @if ($leave->cancellation_status == 1)
                                                                               
                                                                                    <!-- Show "Applied" text and disable button if cancellation is already applied -->
                                                                                    <button 
                                                                                        class="sm-btn btn-outline secondary-outline apply-cancellation-btn" 
                                                                                        style="font-size: 11px;" 
                                                                                            title="Applied" 
                                                                                            disabled
                            
                                                                                    >
                                                                                        Applied
                                                                                    </button>
                                                                                @else
                                                                                    <button 
                                                                                        class="sm-btn btn-outline warning-outline apply-cancellation-btn" 
                                                                                        style="font-size: 11px;" 
                                                                                        title="Apply Cancellation" 
                                                                                        data-original-title="Apply Cancellation"
                                                                                        data-leave-id="{{ $leave->ApplyLeaveId }}"
                                                                                        data-apply-from="{{ $leave->Apply_FromDate }}"
                                                                                        data-apply-to="{{ $leave->Apply_ToDate }}"
                                                                                        data-leave-type="{{ $leave->Leave_Type }}"
                                                                                    >
                                                                                        Apply Cancellation
                                                                                    </button>
                                                                                @endif
                                                                            @endif
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
                                <div class="late-atnd-box">

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
                                        @php
                                            $holidays = collect($holidays); // Convert array to Collection if it's an array
                                        @endphp
                                        @if($holidays->isEmpty())
                                            <p>No holidays available.</p>
                                            <!-- Hide the 'All Holiday List' button if there are no holidays -->
                                            <!-- <button class="btn-outline secondary-outline mr-2 sm-btn mt-2" disabled>No
                                                Holidays Available</button> -->
                                        @else
                                            @foreach ($holidays as $holiday)
                                                <div class="holiday-entry d-flex align-items-center">
                                                    <h6 class="mb-0 me-2">
                                                        <strong
                                                            class="text-bold">{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d M') }}</strong>
                                                    </h6>
                                                    <label class="mb-0 me-2"><strong
                                                            class="text-bold">{{ $holiday->HolidayName }}</strong></label>
                                                    <span class="float-start"><strong
                                                            class="text-bold">{{ $holiday->Day }}</strong></span>
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
                                        @if(isset($optionalHolidays) && $optionalHolidays->isEmpty())
                                            <p>No optional holidays available for this year.</p>
                                        @elseif(isset($optionalHolidays) && $optionalHolidays->isNotEmpty())
                                            @foreach($optionalHolidays as $optionalHoliday)
                                                <div class="fest-leave">
                                                    <label class="mb-0">{{ $optionalHoliday->HoOpName }}</label><br>
                                                    <span
                                                        class="float-start">{{ \Carbon\Carbon::parse($optionalHoliday->HoOpDate)->format('l') }}</span>
                                                    <span class="float-end">
                                                        <label
                                                            class="mb-0 badge badge-success toltiped">{{ \Carbon\Carbon::parse($optionalHoliday->HoOpDate)->format('d M') }}</label>
                                                    </span>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>No optional holidays available for this year.</p>
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

                @include('employee.footerbottom')

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
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#a9cbcd;">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <select name="reasonIn" class="select2 form-control form-select select-opt" id="reasonInDropdown">
                                <option value="">Select Reason</option>

                            </select>
                            <!-- <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                                </span> -->
                        </div>
                        <!-- New Fields for additional data -->
                        <div class="form-group" id="inreasonreqGroup" style="display: none;">
                            <label class="col-form-label">In Reason:</label>
                            <input type="text" name="inreasonreq" class="form-control" id="inreasonreq"
                                placeholder="Enter In Reason Request">
                        </div>


                        <div class="form-group" id="outreasonreqGroup" style="display: none;">
                            <label class="col-form-label">Out Reason:</label>
                            <input type="text" name="outreasonreq" class="form-control" id="outreasonreq"
                                placeholder="Enter Out Reason Request">
                        </div>


                        <div class="form-group" id="reasonreqGroup" style="display: none;">
                            <label class="col-form-label">Other Reason:</label>
                            <input type="text" name="reasonreq" class="form-control form-select" id="reasonreq"
                                placeholder="Enter Other Reason Request">
                        </div>

                        <!-- end of new fields -->
                        <div class="form-group" id="remarkInGroup" style="display: none;">
                            <label class="col-form-label">Remark In:</label>
                            <!--<input type="text" name="remarkIn" class="form-control" id="remarkIn"
                                placeholder="Remark In">-->
                            <textarea name="remarkIn" class="form-control" id="remarkIn"
                                placeholder="Remark In"></textarea>
                        </div>

                        <div class="form-group" id="reasonOutGroup" style="display: none;">
                            <label class="col-form-label">Reason Out:</label>
                            <select name="reasonOut" class="select2 form-control form-select select-opt" id="reasonOutDropdown">
                                <option value="">Select Reason</option>

                            </select>
                            <!-- <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                                </span> -->
                        </div>

                        <div class="form-group" id="remarkOutGroup" style="display: none;">
                            <label class="col-form-label">Remark Out:</label>
                            <!--<input type="text" name="remarkOut" class="form-control" id="remarkOut"
                                placeholder="remark out">-->
                            <textarea name="remarkOut" class="form-control" id="remarkOut"
                                placeholder="remark out"></textarea>
                        </div>
                        <div class="form-group" id="otherReasonGroup" style="display: none;">
                            <label class="col-form-label">Other Reason:</label>
                            <select name="otherReason" class="select2 form-control form-select select-opt" id="otherReasonDropdown">
                                <option value="">Select Reason</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                            <!-- <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                                </span> -->
                        </div>


                        <div class="form-group" id="otherRemarkGroup" style="display: none;">
                            <label class="col-form-label">Other Remark:</label>
                            <!--<input type="text" name="otherRemark" class="form-control" id="otherRemark"
                                placeholder="other remark">-->
                            <textarea name="otherRemark" class="form-control" id="otherRemark"
                                placeholder="other remark"></textarea>
                        </div>
                        <div class="form-group" id="reportingremarkreqGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark:</label>
                            <!--<input type="text" name="reportingremarkreq" class="form-control" id="reportingremarkreq"
                                placeholder="reporting remark req">-->
                            <textarea name="reportingremarkreq" class="form-control" id="reportingremarkreq"
                                placeholder="reporting remark req"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <!-- <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary" id="sendButton">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for Apply Cancellation -->
    <div class="modal fade" id="applyCancellationModal" tabindex="-1" aria-labelledby="applyCancellationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#a9cbcd;">
                    <h5 class="modal-title" id="applyCancellationModalLabel">Apply Cancellation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Leave Request Details -->
                    <div>
                        <strong>Leave Type:</strong> <span id="modalLeaveType"></span><br>
                        <strong>From Date:</strong> <span id="modalFromDate"></span><br>
                        <strong>To Date:</strong> <span id="modalToDate"></span><br>
                    </div>
                    <!-- Remark Input -->
                    <div class="mt-3">
                        <label for="remarkInput" class="form-label">Remark</label>
                        <textarea id="remarkInput" class="form-control" rows="3" placeholder="Enter remark for cancellation"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn btn-primary" id="saveCancellationBtn">Submit</button>
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
        
        const currentMonth = new Date().getMonth(); // getMonth() returns 0 for January, 1 for February, etc.
        document.getElementById("month-name").textContent = monthNames[currentMonth];
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
    // Clear any previous pagination
    pagination.innerHTML = '';

    // Create pagination links based on total pages
    for (let i = 0; i < totalPages; i++) {
        const li = document.createElement('li');
        li.className = 'page-item';
        li.innerHTML = `<a class="page-link" href="#">${i + 1}</a>`;

        // Add click event listener to each pagination link
        li.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent page scroll
            showPage(i);
        });

        pagination.appendChild(li);
    }
}

// Create pagination and display the first page
createPagination();
showPage(0);

            const leaveTypeSelect = document.getElementById('leaveType');
            const holidayDropdown = document.getElementById('holidayDropdown');
            const festivalLeaveMessageoption = document.getElementById('festivalLeaveMessageoption');
            const festivalLeaveMessageoptiontodate = document.getElementById('festivalLeaveMessageoptiontodate');
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
            const balanceFL = {{ isset($leaveBalance) ? $leaveBalance->BalanceOL : 0 }}; // Sick Leave balance
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
                    festivalLeaveMessage.style.display = 'none';
                    holidayDropdown.style.display = 'block';
                    festivalLeaveMessageoption.style.display = 'block';
                    festivalLeaveMessageoptiontodate.style.display='block';

                    optionSelect.value = 'fullday'; // Auto-select Full Day
                    optionSelect.querySelectorAll('option').forEach(option => {
                        option.style.display = (option.value === 'fullday') ? 'block' : 'none'; // Hide others
                    });
                    // Disable the date fields
                    fromDateInput.disabled = true;
                    toDateInput.disabled = true;

                    
                    let isNoHolidayAvailable = false;
                        holidayDropdown.querySelectorAll('option').forEach(option => {
                            if (option.textContent === "No optional holidays available") {
                                isNoHolidayAvailable = true;
                            }
                        });

                        // If "No optional holidays available" is found, disable the date fields and show a message
                        if (isNoHolidayAvailable) {
                            // Clear the date fields first
                            fromDateInput.value = ''; 
                            toDateInput.value = '';   

                            // Disable the date fields
                            fromDateInput.disabled = true;
                            toDateInput.disabled = true;

                            // Set the text color to red
                            fromDateInput.style.color = "red";
                            toDateInput.style.color = "red";
                            festivalLeaveMessage.style.display = 'block';

                        }
                        setDateLimits();

                } 
                else if (this.value === 'EL' || this.value === 'PL') {
                    holidayDropdown.style.display = 'none';
                    optionSelect.value = 'fullday'; // Auto-select Full Day
                    optionSelect.querySelectorAll('option').forEach(option => {
                        option.style.display = (option.value === 'fullday') ? 'block' : 'none'; // Hide others
                    });
                    setDateLimits();
                } 
                else if (this.value === 'CL') {
                        holidayDropdown.style.display = 'none';
                        optionSelect.value = 'fullday'; // Auto-select Full Day
                      // Add event listener for the 'fromDate' and 'toDate' fields after the leave type is selected
                        const fromDateInput = document.querySelector('#fromDate');  // Assuming #fromDate is the id of your 'From' date input
                        const toDateInput = document.querySelector('#toDate');      // Assuming #toDate is the id of your 'To' date input

                        // Ensure to listen for changes on the date fields after selecting leave type
                        fromDateInput.addEventListener('change', checkDateRange);
                        toDateInput.addEventListener('change', checkDateRange);

                        function checkDateRange() {
                            const fromDate = new Date(fromDateInput.value);
                            const toDate = new Date(toDateInput.value);

                            // Check if both 'from' and 'to' dates are valid before proceeding
                            if (!fromDate || !toDate || fromDate > toDate) {
                                console.log("Invalid date range selected.");
                                return; // Exit if the dates are not valid or 'from' is after 'to'
                            }

                            console.log("From Date:", fromDate);
                            console.log("To Date:", toDate);

                            // Calculate the difference in days between 'From' and 'To' dates
                            const dateDiff = Math.ceil((toDate - fromDate) / (1000 * 3600 * 24)) + 1; // Adding 1 to include the start date

                            console.log("Date Difference (days):", dateDiff);

                            // If the date range is more than 1 day, hide half-day options
                            if (dateDiff > 1 ) {
                                optionSelect.querySelectorAll('option').forEach(option => {
                                    if (option.value === '1sthalf' || option.value === '2ndhalf') {
                                        option.style.display = 'none'; // Hide half-day options if the range is more than 1 day
                                    }
                                });
                            } 
                            else if (balanceCL >= 1) {
                                optionSelect.querySelectorAll('option').forEach(option => {
                                        option.style.display = 'block'; // Show all options
                                    });
                                }
                            else {
                                // If the date range is 1 day or less, show half-day options
                                optionSelect.querySelectorAll('option').forEach(option => {
                                    if (option.value === '1sthalf' || option.value === '2ndhalf') {
                                        option.style.display = 'block'; // Show half-day options
                                    }
                                });
                            }
                        }

                        // Initial call to check date range (if the dates are already selected before the leave type is chosen)
                        checkDateRange();
                        // // Determine which options to show based on leave balance
                        // if (balanceCL >= 1) {
                        //     optionSelect.querySelectorAll('option').forEach(option => {
                        //         option.style.display = 'block'; // Show all options
                        //     });
                        // } else {
                        //     optionSelect.querySelectorAll('option').forEach(option => {
                        //         if (option.value === '1sthalf' || option.value === '2ndhalf') {
                        //             option.style.display = 'block'; // Show half-day options
                        //         } else {
                        //             option.style.display = 'none'; // Hide full day option
                        //         }
                        //     });
                        // }
                        setDateLimits();
                    }
                 
                else if (this.value === 'SL') {
                        holidayDropdown.style.display = 'none';
                        optionSelect.value = 'fullday'; // Auto-select Full Day
                      // Add event listener for the 'fromDate' and 'toDate' fields after the leave type is selected
                        const fromDateInput = document.querySelector('#fromDate');  // Assuming #fromDate is the id of your 'From' date input
                        const toDateInput = document.querySelector('#toDate');      // Assuming #toDate is the id of your 'To' date input

                        // Ensure to listen for changes on the date fields after selecting leave type
                        fromDateInput.addEventListener('change', checkDateRange);
                        toDateInput.addEventListener('change', checkDateRange);

                        function checkDateRange() {
                            const fromDate = new Date(fromDateInput.value);
                            const toDate = new Date(toDateInput.value);

                            // Check if both 'from' and 'to' dates are valid before proceeding
                            if (!fromDate || !toDate || fromDate > toDate) {
                                console.log("Invalid date range selected.");
                                return; // Exit if the dates are not valid or 'from' is after 'to'
                            }

                            console.log("From Date:", fromDate);
                            console.log("To Date:", toDate);

                            // Calculate the difference in days between 'From' and 'To' dates
                            const dateDiff = Math.ceil((toDate - fromDate) / (1000 * 3600 * 24)) + 1; // Adding 1 to include the start date

                            console.log("Date Difference (days):", dateDiff);

                            // If the date range is more than 1 day, hide half-day options
                            if (dateDiff > 1 ) {
                                optionSelect.querySelectorAll('option').forEach(option => {
                                    optionSelect.value = 'fullday'; // Auto-select Full Day
                                    if (option.value === '1sthalf' || option.value === '2ndhalf') {
                                        option.style.display = 'none'; // Hide half-day options if the range is more than 1 day
                                    }
                                });
                            } 
                            else if (balanceCL >= 1) {
                                optionSelect.querySelectorAll('option').forEach(option => {
                                        option.style.display = 'block'; // Show all options
                                    });
                                }
                            else {
                                // If the date range is 1 day or less, show half-day options
                                optionSelect.querySelectorAll('option').forEach(option => {
                                    if (option.value === '1sthalf' || option.value === '2ndhalf') {
                                        option.style.display = 'block'; // Show half-day options
                                    }
                                });
                            }
                        }

                        setDateLimits();
                    }
                 
                // else if (this.value === 'SL') {
                //     fromDateInput.parentElement.parentElement.style.display = 'block'; // Show general From Date
                //     toDateInput.parentElement.parentElement.style.display = 'block'; // Show general To Date

                //     // Determine options based on Sick Leave balance
                //     if (balanceSL >= 1) {
                //         optionSelect.querySelectorAll('option').forEach(option => {
                //             option.style.display = 'block'; // Show all options
                //         });
                //     } else {
                //         optionSelect.querySelectorAll('option').forEach(option => {
                //             if (option.value === '1sthalf' || option.value === '2ndhalf') {
                //                 option.style.display = 'block'; // Show half-day options
                //             } else {
                //                 option.style.display = 'none'; // Hide full day option
                //             }
                //         });
                //     }
                //     setDateLimits();
                // }

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
            // document.getElementById('optionalHoliday').addEventListener('change', function () {
            //     const selectedHolidayDate = new Date(this.value); // Get selected holiday date
            //     console.log(selectedHolidayDate);
            //     const year = selectedHolidayDate.getFullYear();
            //     const month = selectedHolidayDate.getMonth(); // Month is zero-indexed

            //     // Get the first and last day of the selected month
            //     const firstDayOfMonth = new Date(year, month, 1); // First day of the month
            //     const lastDayOfMonth = new Date(year, month + 1, 0); // Last day of the month

            //     // Function to format date as yyyy-mm-dd (required by the date input field)
            //     function formatDateForInput(date) {
            //         const day = String(date.getDate()).padStart(2, '0'); // Ensure two digits
            //         const month = String(date.getMonth() + 1).padStart(2, '0'); // Ensure two digits, zero-indexed month
            //         const year = date.getFullYear();
            //         return `${year}-${month}-${day}`; // Return date in yyyy-mm-dd format
            //     }

            //     // Set the fromDateInput and toDateInput values in yyyy-mm-dd format
            //     fromDateInput.value = formatDateForInput(selectedHolidayDate);
            //     toDateInput.value = formatDateForInput(selectedHolidayDate);

            //     // Set min and max for both date inputs (in yyyy-mm-dd format)
            //     fromDateInput.min = formatDateForInput(firstDayOfMonth);
            //     fromDateInput.max = formatDateForInput(lastDayOfMonth);
            //     toDateInput.min = formatDateForInput(firstDayOfMonth);
            //     toDateInput.max = formatDateForInput(lastDayOfMonth);
            // });
            document.getElementById('optionalHoliday').addEventListener('change', function () {
                    console.log(festivalLeaveMessageoptiontodate);
                    festivalLeaveMessageoption.style.display = 'none';
                    festivalLeaveMessageoptiontodate.style.display = 'none';

                    // Enable the date fields
                    fromDateInput.disabled = false;
                    toDateInput.disabled = false;

                    const selectedHolidayDate = new Date(this.value); // Get selected holiday date
                    console.log(selectedHolidayDate);

                    // Set date limits using function to calculate min/max dates
                    setDateLimitsoptional(selectedHolidayDate);
                });

            // Function to set the date limits
            function setDateLimitsoptional(selectedHolidayDate) {
                const currentDate = new Date();

                // Set the minDate as 3 days ago from the current date
                const threeDaysAgo = new Date(currentDate);
                threeDaysAgo.setDate(currentDate.getDate() - 3);
                const minDate = threeDaysAgo.toISOString().split('T')[0]; // Convert to YYYY-MM-DD

                // Set the min and max dates for the from and to date inputs
                fromDateInput.min = minDate; // Allow dates from 3 days ago
                toDateInput.min = minDate; // Allow dates from 3 days ago

                // Clear max to allow selection of any past date
                fromDateInput.max = ""; // No maximum limit
                toDateInput.max = ""; // No maximum limit

                // Pre-select the fromDate and toDate fields as today's date by default
                fromDateInput.value = currentDate.toISOString().split('T')[0]; // Default From Date to today
                toDateInput.value = currentDate.toISOString().split('T')[0]; // Default To Date to today

                // Optional: You can also set the date fields based on the selected holiday if needed:
                // For example, set both fields to the selected holiday date
                fromDateInput.value = selectedHolidayDate.toISOString().split('T')[0]; 
                toDateInput.value = selectedHolidayDate.toISOString().split('T')[0];
            }


            monthDropdown.addEventListener('change', function () {
                const selectedMonth = this.value;
                if (selectedMonth !== "select") {
                    fetchAttendanceData(selectedMonth, currentYear);
                }
            });
            // document.addEventListener('click', function (event) {
            //     if (event.target.closest('.open-modal')) {
            //         event.preventDefault();

            //         const link = event.target.closest('.open-modal');
            //         const employeeId = link.getAttribute('data-employee-id');
            //         const date = link.getAttribute('data-date');
            //         const innTime = link.getAttribute('data-inn');
            //         const outTime = link.getAttribute('data-out');
            //         const II = link.getAttribute('data-II');
            //         const OO = link.getAttribute('data-OO');
            //         const atct = link.getAttribute('data-atct');
            //         const dataexist = link.getAttribute('data-exist');
            //         const status = link.getAttribute('data-status');
            //         const draft = link.getAttribute('data-draft');
            //         // Determine classes based on conditions
            //         const lateClass = (innTime > II) ? 'text-danger' : '';
            //         const earlyClass = (outTime < OO) ? 'text-danger' : '';
            //         // Initialize content for request-date
            //         if (dataexist === 'true') {
            //             // Select the modal footer and hide it
            //             const modalFooter = document.getElementById('modal-footer');
            //             console.log(modalFooter)
            //             if (modalFooter) {
            //                 modalFooter.style.display = 'none';
            //             }
            //         }
            //         console.log(draft);
            //         // Initialize content for request-date
            //         let requestDateContent = `
            //                 <div style="text-align: left;">
            //                     <b>Request Date: ${date}</b>
            //                     <span style="color: ${draft === '3' || draft === null ? 'red' : (status === '1' ? 'green' : 'red')}; float: right; ${draft === '0' ? 'display: none;' : ''}">
            //                         <b style="color: black; font-weight: bold;">Status:</b> 
            //                         ${draft === '3' || draft === null ? 'Draft' : (status === '1' ? 'Approved' : 'Rejected')}
            //                     </span>
            //                 </div>
            //             `;
            //         // Check conditions for In
            //         if (innTime > II) {
            //             requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
            //         } else if (innTime <= II) {
            //             requestDateContent += `In: <span>${innTime}On Time</span><br>`; // Optional: show "On Time" if needed
            //         }

            //         // Check conditions for Out
            //         if (outTime < OO) {
            //             requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
            //         } else if (outTime >= OO) {
            //             requestDateContent += `Out: <span>${outTime}On Time</span>`; // Optional: show "On Time" if needed
            //         }

            //         // Set innerHTML only if there is content to display
            //         document.getElementById('request-date').innerHTML = requestDateContent;

            //         document.getElementById('employeeid').value = employeeId;
            //         document.getElementById('Atct').value = atct;
            //         document.getElementById('requestDate').value = date;

            //         // Clear previous values and hide all groups
            //         document.getElementById('remarkIn').value = '';
            //         document.getElementById('remarkOut').value = '';
            //         // document.getElementById('reasonInDropdown').innerHTML = '';
            //         // document.getElementById('reasonOutDropdown').innerHTML = '';

            //         document.getElementById('reasonInGroup').style.display = 'none';
            //         document.getElementById('remarkInGroup').style.display = 'none';
            //         document.getElementById('reasonOutGroup').style.display = 'none';
            //         document.getElementById('remarkOutGroup').style.display = 'none';

            //         // Fetch company_id and department_id based on employeeId
            //         fetch(`/api/getEmployeeDetails/${employeeId}`)
            //             .then(response => response.json())
            //             .then(data => {
            //                 console.log(data);
            //                 const companyId = data.company_id;
            //                 const departmentId = data.department_id;

            //                 // Fetch reasons based on companyId and departmentId
            //                 return fetch(`/api/getReasons/${companyId}/${departmentId}`);
            //             })
            //             .then(response => response.json())
            //             .then(reasons => {
            //                 // Function to clear existing options in the dropdowns
            //                 function clearDropdown(dropdownId) {
            //                     const dropdown = document.getElementById(dropdownId);
            //                     // Clear all existing options
            //                     dropdown.innerHTML = '';
            //                 }

            //                 // Clear existing options in all dropdowns
            //                 clearDropdown('reasonInDropdown');
            //                 clearDropdown('reasonOutDropdown');
            //                 clearDropdown('otherReasonDropdown');

            //                 // Add default "Select Option" as the first option for each dropdown
            //                 const defaultOption = document.createElement('option');
            //                 defaultOption.value = '';  // empty value for "Select Option"
            //                 defaultOption.textContent = 'Select Option';

            //                 document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonInDropdown'
            //                 document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonOutDropdown'
            //                 document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true)); // For 'otherReasonDropdown'

            //                 // Populate the reason dropdowns with actual options
            //                 reasons.forEach(reason => {
            //                     // Create option elements for each dropdown
            //                     const optionIn = document.createElement('option');
            //                     optionIn.value = reason.ReasonId;
            //                     optionIn.textContent = reason.reason_name;
            //                     document.getElementById('reasonInDropdown').appendChild(optionIn);

            //                     const optionOut = document.createElement('option');
            //                     optionOut.value = reason.ReasonId;
            //                     optionOut.textContent = reason.reason_name;
            //                     document.getElementById('reasonOutDropdown').appendChild(optionOut);

            //                     const optionOther = document.createElement('option');
            //                     optionOther.value = reason.ReasonId;
            //                     optionOther.textContent = reason.reason_name;
            //                     document.getElementById('otherReasonDropdown').appendChild(optionOther);
            //                 });

            //                 // Ensure "Select Option" is selected initially in all dropdowns
            //                 document.getElementById('reasonInDropdown').value = ''; // Select the default option
            //                 document.getElementById('reasonOutDropdown').value = ''; // Select the default option
            //                 document.getElementById('otherReasonDropdown').value = ''; // Select the default option
            //             })


            //             .catch(error => console.error('Error fetching reasons:', error));

            //         let inConditionMet = false;
            //         let outConditionMet = false;
            //         if (innTime === outTime) {
            //             remarkInGroup.style.display = 'none';
            //             reasonInGroup.style.display = 'none';
            //             remarkOutGroup.style.display = 'none';
            //             reasonOutGroup.style.display = 'none';
            //             document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
            //             document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input

            //         }
            //         else {
            //             // Your existing time condition logic...
            //             if (innTime > II) {
            //                 remarkInGroup.style.display = 'block';
            //                 reasonInGroup.style.display = 'block';
            //                 // document.getElementById('remarkIn').value = 'Your remark for late in';
            //                 inConditionMet = true;
            //             }
            //             if (outTime == '00:00') {
            //                 remarkOutGroup.style.display = 'block';
            //                 reasonOutGroup.style.display = 'block';
            //                 // document.getElementById('remarkOut').value = 'Your remark for early out';
            //                 document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
            //                 document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

            //             }

            //             if (outTime < OO) {
            //                 remarkOutGroup.style.display = 'block';
            //                 reasonOutGroup.style.display = 'block';
            //                 // document.getElementById('remarkOut').value = 'Your remark for early out';
            //                 outConditionMet = true;
            //             }

            //             // If both conditions are met, display both groups
            //             if (inConditionMet && outConditionMet) {
            //                 remarkInGroup.style.display = 'block';
            //                 reasonInGroup.style.display = 'block';
            //                 remarkOutGroup.style.display = 'block';
            //                 reasonOutGroup.style.display = 'block';
            //                 document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
            //                 document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

            //             }
            //         }
            //         const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
            //         modal.show();
            //     }
            // });

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
                    // // Initialize content for request-date
                    // if (dataexist === 'true') {
                    //     // Select the modal footer and hide it
                    //     const modalFooter = document.getElementById('modal-footer');
                    //     console.log(modalFooter)
                    //     if (modalFooter) {
                    //         modalFooter.style.display = 'none';
                    //     }
                    // }
                    // Initialize content for request-date
                    // let requestDateContent = `
                    //       <div style="text-align: left;">
                    //                 <b>Request Date: ${date}</b>
                    //                 <span style="float: right;">
                    //                     <b style="color: black; font-weight: bold;">Status:</b> 
                    //                     <!-- Conditional Rendering Based on draft_status -->
                    //                     <span style="color: ${draft == 3 ? 'red' : 
                    //                         (status === 1 && draft === 0 ? 'green' : 'red')}">
                    //                         ${draft == 3 ? 'Draft' : 
                    //                             (draft === 0 ? 
                    //                                 (status === 1 ? 'Approved' : 'Rejected') : '')}
                    //                     </span>
                    //                 </span>
                    //             </div>

                    //     `;
                   
                    // let requestDateContent = `
                    //     <div style="text-align: left;">
                    //         <b>Request Date: ${date}</b>
                    //         <span style="color: ${draft === '3' ? 'red' : (status == 1 ? 'green' : 'red')}; float: right; ${draft === '0' ? 'display: none;' : ''}">
                    //             <b style="color: black; font-weight: bold;">Status:</b> 
                    //             ${draft === '3' ? 'Draft' : (draft === '0' ? (status == 1 ? 'Approved' : 'Rejected') : '')}
                    //         </span>
                    //     </div>
                    // `;
                   // Get current date
                   try {
                         // Get current date
                         const currentDate = new Date();
                        const givenDate = parseDate(date); // Convert string to Date object
                       
                        // Log both dates for debugging
                        console.log("Given Date:", givenDate);
                        console.log("Current Date:", currentDate);

                        // Get the year and month for the current date
                        const currentMonth = currentDate.getMonth(); // 0 = January, 11 = December
                        const currentYear = currentDate.getFullYear();

                        // Get the year and month for the given date
                        const givenMonth = givenDate.getMonth(); 
                        const givenYear = givenDate.getFullYear();

                        // Check if the given date is in the previous month
                        let isPreviousMonth = false;

                        // If the given year is the same as the current year
                        if (givenYear === currentYear) {
                            // Check if the given month is exactly one month before the current month
                            if (givenMonth < currentMonth ) {
                                isPreviousMonth = true;
                            }
                        } 
                        if (givenYear < currentYear || (givenYear === currentYear && givenMonth < currentMonth)) {
                                isPreviousMonthOrEarlier = true;
                            }

                        // Hide the button if it's the previous month
                        if (isPreviousMonth) {
                            document.getElementById("sendButton").style.display = "none";
                        } else {
                            // Otherwise, show the button
                            document.getElementById("sendButton").style.display = "block";
                        } 

                    } catch (error) {
                        // If an error occurs anywhere in the try block, this will catch it
                        console.error("An error occurred:", error);
                        // Optionally, handle specific error cases or just log it to the console.
                    }

                    let requestDateContent = `
                            <div style="text-align: left;">
                                <b>Request Date: ${date}</b>
                                <span style="color: ${
                                    // Condition: If both status = 1 and draft = 3, display "Approved" in green
                                    (status === '1' && draft === '3') 
                                    ? 'green' // Approved in green
                                    : (draft === '3' || draft === null 
                                        ? 'red' // Draft or null draft, color is red
                                        : 'red' // Else Rejected in red
                                    )
                                }; float: right; ${draft === '0' ? 'display: none;' : ''}">
                                    <b style="color: black; font-weight: bold;">Status:</b> 
                                    ${status === '1' && draft === '3' 
                                        ? 'Approved' // If both status and draft are 1 and 3, display "Approved"
                                        : (draft === '3' || draft === null 
                                            ? 'Draft' // If draft is 3 or null, display "Draft"
                                            : 'Rejected' // Else display "Rejected"
                                        )
                                    }
                                </span>
                            </div>
                        `;

                    // Check conditions for In
                    if (innTime > II) {
                        requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
                    } else if (innTime <= II) {
                        requestDateContent += `In: <span>${innTime} On Time</span><br>`; // Optional: show "On Time" if needed
                    }

                    // Check conditions for Out
                    if (outTime < OO) {
                        requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
                    } else if (outTime >= OO) {
                        requestDateContent += `Out: <span>${outTime} On Time</span>`; // Optional: show "On Time" if needed
                    }

                    // Set innerHTML only if there is content to display
                    document.getElementById('request-date').innerHTML = requestDateContent;

                    document.getElementById('employeeid').value = employeeId;
                    document.getElementById('Atct').value = atct;
                    document.getElementById('requestDate').value = date;

                    // Clear previous values and hide all groups

                    //CLOSing problem hence 
                    // document.getElementById('remarkIn').value = '';
                    // document.getElementById('remarkOut').value = '';
                    
                    // document.getElementById('reasonInDropdown').innerHTML = '';
                    // document.getElementById('reasonOutDropdown').innerHTML = '';

                    document.getElementById('reasonInGroup').style.display = 'none';
                    document.getElementById('remarkInGroup').style.display = 'none';
                    document.getElementById('reasonOutGroup').style.display = 'none';
                    document.getElementById('remarkOutGroup').style.display = 'none';
                    document.getElementById('inreasonreqGroup').style.display = 'none';
                    document.getElementById('reportingremarkreqGroup').style.display = 'none';
                    document.getElementById('outreasonreqGroup').style.display = 'none';
                    document.getElementById('reasonreqGroup').style.display = 'none';
                    document.getElementById('otherRemarkGroup').style.display = 'none';
                    document.getElementById('otherReasonGroup').style.display = 'none';


                    const sendButton = document.getElementById('sendButton');
                    sendButton.removeAttribute('disabled'); // Enable the button
                    // Initially, make the 'otherRemark' input editable
                    const otherRemarkInput = document.getElementById('otherRemark');
                    otherRemarkInput.removeAttribute('readonly'); // Make the input editable

                    const remarkOutInput = document.getElementById('remarkOut');
                    remarkOutInput.removeAttribute('readonly'); // Make the input editable

                    const remarkInInput = document.getElementById('remarkIn');
                    remarkInInput.removeAttribute('readonly'); // Make the input editable

                    // Fetch attendance data for this employee and date
                    fetch(`/getAttendanceData?employeeId=${employeeId}&date=${date}`)
                        .then(response => response.json())
                        .then(attendanceData => {
                            // If attendance data is found for the given date
                            if (attendanceData) {
                                // const attDate = new Date(attendanceData.attendance.AttDate); // Parse the date string into a Date object
                                const attDate = new Date(attendanceData?.attendance?.AttDate || ''); // Default to empty string if AttDate is missing

                                // Format the date to day-MonthName-year (e.g., 6-November-2024)
                                const day = attDate.getDate(); // Get the day (6)
                                const month = attDate.toLocaleString('default', { month: 'long' }); // Get the month name (November)
                                const year = attDate.getFullYear(); // Get the year (2024)

                                const formattedDate = `${day}-${month}-${year}`; // Combine them into the desired format

                                // Dynamically set the request date and status section
                                // let requestDateContent = `
                                //         <div style="text-align: left;">
                                //             <b>Request Date: ${formattedDate}</b>
                                //             <span style="color: ${attendanceData.attendance.draft_status === 3 ? 'red' : (attendanceData.attendance.Status === 1 ? 'green' : 'red')}; float: right;">
                                //                 <b style="color: black; font-weight: bold;">Status:</b> 
                                //                 ${attendanceData.attendance.draft_status === 3 ? 'Draft' :
                                //         (attendanceData.attendance.Status === 1 ? 'Approved' : 'Rejected')}
                                //             </span>
                                //         </div>
                                //     `;
                        //         let requestDateContent = `
                        //   <div style="text-align: left;">
                        //             <b>Request Date: ${formattedDate}</b>
                        //             <span style="float: right;">
                        //                 <b style="color: black; font-weight: bold;">Status:</b> 
                        //                 <!-- Conditional Rendering Based on draft_status -->
                        //                 <span style="color: ${attendanceData.attendance.draft_status == 3 ? 'red' : 
                        //                     (attendanceData.attendance.Status == 1 && attendanceData.attendance.draft_status == 0 ? 'green' : 'red')}">
                        //                     ${attendanceData.attendance.draft_status == 3 ? 'Draft' : 
                        //                         (attendanceData.attendance.draft_status == 0 ? 
                        //                             (attendanceData.attendance.Status == 1 ? 'Approved' : 'Rejected') : '')}
                        //                 </span>
                        //             </span>
                        //         </div>

                        // `;
                        //Dynamically set the request date and status section
                        // let requestDateContent = `
                        //     <div style="text-align: left;">
                        //         <b>Request Date: ${formattedDate}</b>
                        //         <span style="color: ${
                        //             // Condition: If both status = 1 and draft_status = 3, display "Approved" in green
                        //             (attendanceData.attendance.Status === 1 && attendanceData.attendance.draft_status === 3) 
                        //             ? 'green' // Approved in green
                        //             : (attendanceData.attendance.draft_status === 3 
                        //                 ? 'red' // Draft in red
                        //                 : (attendanceData.attendance.Status === 1 
                        //                     ? 'green' // Approved in green
                        //                     : 'red') // Rejected in red
                        //             )
                        //         }; float: right;">
                        //             <b style="color: black; font-weight: bold;">Status:</b> 
                        //             ${attendanceData.attendance.Status === 1 && attendanceData.attendance.draft_status === 3 
                        //                 ? 'Approved' // If both status and draft_status are 1 and 3, display "Approved"
                        //                 : (attendanceData.attendance.draft_status === 3 
                        //                     ? 'Draft' // If draft_status is 3, display "Draft"
                        //                     : (attendanceData.attendance.Status === 1 
                        //                         ? 'Approved' // If Status is 1, display "Approved"
                        //                         : 'Rejected') // Else display "Rejected"
                        //                 )
                        //             }
                        //         </span>
                        //     </div>
                        // `;
                         let requestDateContent = `
                            <div style="text-align: left;">
                                <b>Request Date: ${formattedDate}</b>
                                <span style="color: ${
                                    // Condition: If both status = 1 and draft_status = 3, display "Approved" in green
                                    (attendanceData.attendance.Status === 1 && attendanceData.attendance.draft_status === 3) 
                                    ? 'green' // Approved in green
                                    : (attendanceData.attendance.draft_status === 3 
                                        ? 'red' // Draft in red
                                        : (attendanceData.attendance.Status === 1 
                                            ? 'green' // Approved in green
                                            : 'red') // Rejected in red
                                    )
                                }; float: right;">
                                    <b style="color: black; font-weight: bold;">Status:</b> 
                                    ${attendanceData.attendance.Status === 1 && attendanceData.attendance.draft_status === 3 
                                        ? 'Approved' // If both status and draft_status are 1 and 3, display "Approved"
                                        : (attendanceData.attendance.draft_status === 3 
                                            ? 'Draft' // If draft_status is 3, display "Draft"
                                            : (attendanceData.attendance.Status === 1 
                                                ? 'Approved' // If Status is 1, display "Approved"
                                                : 'Rejected') // Else display "Rejected"
                                        )
                                    }
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
                                 // document.getElementById('attendanceMessage').style.display = 'block';
                                // If 'remarkIn' is available in the data, show the value instead of input
                                // If 'remarkIn' is available in the data, show the value instead of input
                                if (attendanceData.attendance.InRemark) {
                                    console.log(attendanceData.attendance.InRemark);
                                    const remarkInInput = document.getElementById('remarkIn');
                                    remarkInInput.value = attendanceData.attendance.InRemark; // Fill in the remark value
                                    remarkInInput.setAttribute('readonly', true); // Make it readonly
                                    // Disable the 'Send' button
                                    const sendButton = document.getElementById('sendButton');
                                    sendButton.setAttribute('disabled', true); // Disable the button
                                }
                                if (attendanceData.attendance.InRemark) {
                                // Get the input field for Remark
                                const remarkInInput = document.getElementById('remarkIn');
                                // Check if the input field exists
                                if (remarkInInput) {
                                    // Set the value of the input field
                                    remarkInInput.value = attendanceData.attendance.InRemark;
                                    
                                    // Make the input field readonly
                                    remarkInInput.setAttribute('readonly', true);
                                    
                                    // Disable the 'Send' button
                                    const sendButton = document.getElementById('sendButton');
                                    sendButton.setAttribute('disabled', true);
                                    // Optionally, you can hide the input field and display the value in a span instead
                                    const remarkSpan = document.createElement('span'); // Create a span element
                                    remarkSpan.textContent = attendanceData.attendance.InRemark; // Set the span text content to the remark value
                                    // Replace the input field with the span
                                    remarkInInput.parentNode.replaceChild(remarkSpan, remarkInInput);
                                }
                            }
                                // // If 'remarkOut' is available in the data, show the value instead of input
                                // if (attendanceData.attendance.OutRemark) {
                                //     const remarkOutInput = document.getElementById('remarkOut');
                                //     remarkOutInput.value = attendanceData.attendance.OutRemark; // Fill in the remark value
                                //     remarkOutInput.setAttribute('readonly', true); // Make it readonly
                                //     // Disable the 'Send' button
                                //     const sendButton = document.getElementById('sendButton');
                                //     sendButton.setAttribute('disabled', true); // Disable the button
                                // }
                                if (attendanceData.attendance.OutRemark) {
                                // Get the input field for Remark
                                const remarkOutInput = document.getElementById('remarkOut');
                                // Check if the input field exists
                                if (remarkOutInput) {
                                    // Set the value of the input field
                                    remarkOutInput.value = attendanceData.attendance.OutRemark;
                                    
                                    // Make the input field readonly
                                    remarkOutInput.setAttribute('readonly', true);
                                    
                                    // Disable the 'Send' button
                                    const sendButton = document.getElementById('sendButton');
                                    sendButton.setAttribute('disabled', true);
                                    // Optionally, you can hide the input field and display the value in a span instead
                                    const remarkSpan = document.createElement('span'); // Create a span element
                                    remarkSpan.textContent = attendanceData.attendance.OutRemark; // Set the span text content to the remark value
                                    // Replace the input field with the span
                                    remarkOutInput.parentNode.replaceChild(remarkSpan, remarkOutInput);
                                }
                            }
                                
                               
                                // If 'remark' is available in the data, show the value instead of input
                                // if (attendanceData.attendance.Remark) {
                                //     const otherRemarkInput = document.getElementById('otherRemark');
                                //     otherRemarkInput.value = attendanceData.attendance.Remark; // Fill in the remark value                                        
                                //     otherRemarkInput.setAttribute('readonly', true); // Make it readonly
                                //     // Disable the 'Send' button
                                //     const sendButton = document.getElementById('sendButton');
                                //     sendButton.setAttribute('disabled', true); // Disable the button
                                // }
                                if (attendanceData.attendance.Remark) {
                                // Get the input field for Remark
                                const otherRemarkInput = document.getElementById('otherRemark');
                                // Check if the input field exists
                                if (otherRemarkInput) {
                                    // Set the value of the input field
                                    otherRemarkInput.value = attendanceData.attendance.Remark;
                                    
                                    // Make the input field readonly
                                    otherRemarkInput.setAttribute('readonly', true);
                                    
                                    // Disable the 'Send' button
                                    const sendButton = document.getElementById('sendButton');
                                    sendButton.setAttribute('disabled', true);
                                    // Optionally, you can hide the input field and display the value in a span instead
                                    const remarkSpan = document.createElement('span'); // Create a span element
                                    remarkSpan.textContent = attendanceData.attendance.Remark; // Set the span text content to the remark value
                                    // Replace the input field with the span
                                    otherRemarkInput.parentNode.replaceChild(remarkSpan, otherRemarkInput);
                                }
                            }
                                
                                // If 'rep remark' is available in the data, show the value instead of input
                                // if (attendanceData.attendance.R_Remark) {
                                //     const reporemarkkInput = document.getElementById('reportingremarkreq');
                                //     reporemarkkInput.value = attendanceData.attendance.R_Remark; // Fill in the remark value                                        
                                //     reporemarkkInput.setAttribute('readonly', true); // Make it readonly
                                //     // Disable the 'Send' button
                                //     const sendButton = document.getElementById('sendButton');
                                //     sendButton.setAttribute('disabled', true); // Disable the button
                                // }
                                if (attendanceData.attendance.R_Remark) {
                                // Get the input field for Reporting Remark
                                const reporemarkkInput = document.getElementById('reportingremarkreq');
                                // Check if the input field exists
                                if (reporemarkkInput) {
                                    // Set the value of the input field
                                    reporemarkkInput.value = attendanceData.attendance.R_Remark;
                                    
                                    // Make the input field readonly
                                    reporemarkkInput.setAttribute('readonly', true);
                                    
                                    // Disable the 'Send' button
                                    const sendButton = document.getElementById('sendButton');
                                    sendButton.setAttribute('disabled', true);
                                    // Optionally, you can hide the input field and display the value in a span instead
                                    const reportRemarkSpan = document.createElement('span'); // Create a span element
                                    reportRemarkSpan.textContent = attendanceData.attendance.R_Remark; // Set the span text content to the reporting remark value
                                    // Replace the input field with the span
                                    reporemarkkInput.parentNode.replaceChild(reportRemarkSpan, reporemarkkInput);
                                }
                                else{
                                    console.log('dzfsdfsdf');
                                }
                            }
                                
                            
                            // If reasons for In/Out exist, show the value directly
                                // if (attendanceData.attendance.InReason) {
                                //     document.getElementById('reasonInGroup').style.display = 'none'; // Hide dropdown
                                //     const reasonInInput = document.getElementById('inreasonreq');
                                //     reasonInInput.value = attendanceData.attendance.InReason; // Fill in the reason value
                                //     reasonInInput.setAttribute('readonly', true); // Make it readonly
                                //     // Disable the 'Send' button
                                //     const sendButton = document.getElementById('sendButton');
                                //     sendButton.setAttribute('disabled', true); // Disable the button
                                // }
                                if (attendanceData.attendance.InReason) {
                                    // Hide the dropdown group (assuming 'reasonInGroup' refers to a dropdown)
                                    document.getElementById('reasonInGroup').style.display = 'none'; 
                                    
                                    // Get the input field for the "In Reason"
                                    const reasonInInput = document.getElementById('inreasonreq');
                                    // Check if the input field exists
                                    if (reasonInInput) {
                                        // Set the value of the input field
                                        reasonInInput.value = attendanceData.attendance.InReason;
                                        
                                        // Make the input field readonly
                                        reasonInInput.setAttribute('readonly', true);
                                        
                                        // Disable the 'Send' button
                                        const sendButton = document.getElementById('sendButton');
                                        sendButton.setAttribute('disabled', true);
                                        // Optionally, you can replace the input field with a span to display the value instead of input
                                        const reasonInSpan = document.createElement('span'); // Create a span element
                                        reasonInSpan.textContent = attendanceData.attendance.InReason; // Set the span text content to the InReason value
                                        // Replace the input field with the span
                                        reasonInInput.parentNode.replaceChild(reasonInSpan, reasonInInput);
                                    }
                                }
                                
                                
                                // if (attendanceData.attendance.OutReason) {
                                //     document.getElementById('reasonOutGroup').style.display = 'none'; // Hide dropdown
                                //     const reasonOutInput = document.getElementById('outreasonreq');
                                //     reasonOutInput.value = attendanceData.attendance.OutReason; // Fill in the reason value
                                //     reasonOutInput.setAttribute('readonly', true); // Make it readonly
                                // }
                                if (attendanceData.attendance.OutReason) {
                                // Hide the dropdown group (assuming 'reasonOutGroup' refers to a dropdown)
                                document.getElementById('reasonOutGroup').style.display = 'none'; 
                                
                                // Get the input field for the "Out Reason"
                                const reasonOutInput = document.getElementById('outreasonreq');
                                // Check if the input field exists
                                if (reasonOutInput) {
                                    // Set the value of the input field
                                    reasonOutInput.value = attendanceData.attendance.OutReason;
                                    
                                    // Make the input field readonly
                                    reasonOutInput.setAttribute('readonly', true);
                                    
                                    // Optionally, you can replace the input field with a span to display the value instead of input
                                    const reasonOutSpan = document.createElement('span'); // Create a span element
                                    reasonOutSpan.textContent = attendanceData.attendance.OutReason; // Set the span text content to the OutReason value
                                    // Replace the input field with the span
                                    reasonOutInput.parentNode.replaceChild(reasonOutSpan, reasonOutInput);
                                }
                            }
                                // If there is an "other" reason, show it instead of the dropdown
                                // if (attendanceData.attendance.Reason) {
                                //     document.getElementById('otherReasonGroup').style.display = 'none'; // Hide dropdown
                                //     const otherReasonInput = document.getElementById('reasonreq');
                                //     otherReasonInput.value = attendanceData.attendance.Reason; // Fill in the reason value
                                //     otherReasonInput.setAttribute('readonly', true); // Make it readonly
                                //     // Disable the 'Send' button
                                //     const sendButton = document.getElementById('sendButton');
                                //     sendButton.setAttribute('disabled', true); // Disable the button
                                // }
                                if (attendanceData.attendance.Reason) {
                                            // Hide the input field by hiding the parent group
                                            document.getElementById('otherReasonGroup').style.display = 'none'; // Hide dropdown group
                                            // Create a span element to display the reason
                                            const reasonSpan = document.createElement('span'); // Create a new span element
                                            reasonSpan.textContent = attendanceData.attendance.Reason; // Set the reason as text content
                                            // Replace the input field with the created span
                                            const otherReasonInput = document.getElementById('reasonreq');
                                            otherReasonInput.parentNode.replaceChild(reasonSpan, otherReasonInput); // Replace the input field with the span
                                            // Disable the 'Send' button
                                            const sendButton = document.getElementById('sendButton');
                                            sendButton.setAttribute('disabled', true); // Disable the button
                                        }
                                // Show additional fields if necessary based on the conditions
                                if (attendanceData.attendance.InReason) {
                                    document.getElementById('inreasonreqGroup').style.display = 'block'; // Show In Reason Request
                                }
                                if (attendanceData.attendance.R_Remark) {
                                    document.getElementById('reportingremarkreqGroup').style.display = 'block'; // Show In Reason Request
                                }
                                if (attendanceData.attendance.OutReason) {
                                    document.getElementById('outreasonreqGroup').style.display = 'block'; // Show Out Reason Request
                                }
                                if (attendanceData.attendance.Reason) {
                                    document.getElementById('reasonreqGroup').style.display = 'block'; // Show Other Reason Request
                                }

                            }

                            // else {

                            //     console.log('else');

                            //     // No attendance data available, show default behavior (dropdowns)
                            //     document.getElementById('remarkInGroup').style.display = 'block';
                            //     document.getElementById('remarkOutGroup').style.display = 'block';
                            //     document.getElementById('reasonInGroup').style.display = 'block';
                            //     document.getElementById('reasonOutGroup').style.display = 'block';
                            //     document.getElementById('otherReasonGroup').style.display = 'block';
                            //     document.getElementById('otherRemarkGroup').style.display = 'block';

                            // }
                        })
                        .catch(error => {
                            console.error('Error fetching attendance data:', error);
                        });

                    // Fetch company_id and department_id based on employeeId
                    fetch(`/api/getEmployeeDetails/${employeeId}`)
                        .then(response => response.json())
                        .then(data => {
                            const companyId = data.company_id;
                            const departmentId = data.department_id;

                            // Fetch reasons based on companyId and departmentId
                            return fetch(`/api/getReasons/${companyId}/${departmentId}`);
                        })
                        .then(response => response.json())
                        .then(reasons => {
                            // Function to clear existing options in the dropdowns
                            function clearDropdown(dropdownId) {
                                const dropdown = document.getElementById(dropdownId);
                                dropdown.innerHTML = '';
                            }

                            // Clear existing options in all dropdowns
                            clearDropdown('reasonInDropdown');
                            clearDropdown('reasonOutDropdown');
                            clearDropdown('otherReasonDropdown');

                            // Add default "Select Option" as the first option for each dropdown
                            const defaultOption = document.createElement('option');
                            defaultOption.value = '';  // empty value for "Select Option"
                            defaultOption.textContent = 'Select Reason';

                            document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true));
                            document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true));
                            document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true));

                            // Populate the reason dropdowns with actual options
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

                            // Ensure "Select Option" is selected initially in all dropdowns
                            document.getElementById('reasonInDropdown').value = '';
                            document.getElementById('reasonOutDropdown').value = '';
                            document.getElementById('otherReasonDropdown').value = '';
                        })
                        .catch(error => console.error('Error fetching reasons:', error));

                    // // Fetch company_id and department_id based on employeeId
                    // fetch(`/api/getEmployeeDetails/${employeeId}`)
                    //     .then(response => response.json())
                    //     .then(data => {
                    //         const companyId = data.company_id;
                    //         const departmentId = data.department_id;

                    //         // Fetch reasons based on companyId and departmentId
                    //         return fetch(`/api/getReasons/${companyId}/${departmentId}`);
                    //     })
                    //     .then(response => response.json())
                    //     .then(reasons => {
                    //         // Function to clear existing options in the dropdowns
                    //         function clearDropdown(dropdownId) {
                    //             const dropdown = document.getElementById(dropdownId);
                    //             // Clear all existing options
                    //             dropdown.innerHTML = '';
                    //         }

                    //         // Clear existing options in all dropdowns
                    //         clearDropdown('reasonInDropdown');
                    //         clearDropdown('reasonOutDropdown');
                    //         clearDropdown('otherReasonDropdown');

                    //         // Add default "Select Option" as the first option for each dropdown
                    //         const defaultOption = document.createElement('option');
                    //         defaultOption.value = '';  // empty value for "Select Option"
                    //         defaultOption.textContent = 'Select Reason';

                    //         document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonInDropdown'
                    //         document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonOutDropdown'
                    //         document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true)); // For 'otherReasonDropdown'

                    //         // Populate the reason dropdowns with actual options
                    //         reasons.forEach(reason => {
                    //             // Create option elements for each dropdown
                    //             const optionIn = document.createElement('option');
                    //             optionIn.value = reason.ReasonId;
                    //             optionIn.textContent = reason.reason_name;
                    //             document.getElementById('reasonInDropdown').appendChild(optionIn);

                    //             const optionOut = document.createElement('option');
                    //             optionOut.value = reason.ReasonId;
                    //             optionOut.textContent = reason.reason_name;
                    //             document.getElementById('reasonOutDropdown').appendChild(optionOut);

                    //             const optionOther = document.createElement('option');
                    //             optionOther.value = reason.ReasonId;
                    //             optionOther.textContent = reason.reason_name;
                    //             document.getElementById('otherReasonDropdown').appendChild(optionOther);
                    //         });

                    //         // Ensure "Select Option" is selected initially in all dropdowns
                    //         document.getElementById('reasonInDropdown').value = ''; // Select the default option
                    //         document.getElementById('reasonOutDropdown').value = ''; // Select the default option
                    //         document.getElementById('otherReasonDropdown').value = ''; // Select the default option
                    //     })

                    //     // .then(reasons => {
                    //     //     // Populate the reason dropdowns
                    //     //     reasons.forEach(reason => {
                    //     //         const optionIn = document.createElement('option');
                    //     //         optionIn.value = reason.ReasonId;
                    //     //         optionIn.textContent = reason.reason_name;
                    //     //         document.getElementById('reasonInDropdown').appendChild(optionIn);

                    //     //         const optionOut = document.createElement('option');
                    //     //         optionOut.value = reason.ReasonId;
                    //     //         optionOut.textContent = reason.reason_name;
                    //     //         document.getElementById('reasonOutDropdown').appendChild(optionOut);

                    //     //         const optionOther = document.createElement('option');
                    //     //         optionOther.value = reason.ReasonId;
                    //     //         optionOther.textContent = reason.reason_name;
                    //     //         document.getElementById('otherReasonDropdown').appendChild(optionOther);
                    //     //     });
                    //     // })
                    //     .catch(error => console.error('Error fetching reasons:', error));

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
                $('#loader').show(); 

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
                        $('#loader').hide(); 
                        const responseMessage = document.getElementById('responseMessage');

                        // Set the message text
                        responseMessage.innerText = data.message;

                        // Show the message box
                        responseMessage.style.display = 'block';

                        if (data.success) {
                            // Display success toast
                            toastr.success(data.message, 'Success', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            });

                            // Optionally, you can hide the modal and reset the form after a delay
                            setTimeout(function () {
                                $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 2 seconds
                                $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form
                            }, 2000);  // 2000 milliseconds = 2 seconds

                        } else {
                            // Display error toast
                            toastr.error(data.message, 'Error', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            });

                            // Optionally, reset the form after a delay
                            setTimeout(function () {
                                $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form
                            }, 2000);  // 2000 milliseconds = 2 seconds
                        }

                    })

                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request.');
                    });
            });
            function parseDate(dateStr) {
                    const [day, monthStr, year] = dateStr.split('-');
                    
                    // Map month string to month index (January is 0, December is 11)
                    const months = [
                        'January', 'February', 'March', 'April', 'May', 'June', 
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ];
                    
                    const month = months.indexOf(monthStr); // Find the month index
                    
                    return new Date(year, month, day); // Construct and return the Date object
                }
            
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
                        const latenessContainer = document.querySelector('.late-atnd-box');
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
                                    // if (attValue === 'P' || attValue === 'HF') {
    // Check for lateness condition: innTime > iiTime OR dayData.Outt < dayData.OO
    if (innTime > iiTime || dayData.Outt < dayData.OO) {
        latenessCount++; // Increment lateness count
        latenessStatus = `L${latenessCount}`; // Set lateness status (L1, L2, etc.)

        // Add "danger" class if lateness condition is met
        const punchInDanger = innTime > iiTime ? 'danger' : '';
        const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';

        // Set the status label and modal link (if needed)
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

                                            // Append lateness data (only for Present and lateness condition)
                                            latenessContainer.innerHTML += `
                                                <div class="late-atnd">
                                                    <div>
                                                        <span class="late-l1">${latenessStatus}</span>
                                                        <h6 class="float-start mt-2">${day} ${monthNames[monthNumber - 1]} ${year}</h6>
                                                        <div class="float-end mt-1">
                                                            <label style="padding:3px 11px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="${statusLabel}">
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
                                    // }
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
                                    // Now you can access RequestStatuses in `data` variable
                                    const requestStatuses = data[0].RequestStatuses; // This will give you the array of RequestStatuses

                                    //if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        if (dayData.Inn > dayData.II || dayData.Outt < dayData.OO || dayData.Inn === dayData.Outt) {
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        }
                                    //}

                                    // Append iconHtml to your cell if needed
                                    if (iconHtml) {
                                        cell.innerHTML += iconHtml;
                                    }
                                    let attenBoxContent = '';
                                    const istoday = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
                                

                                    if (latenessStatus && dayData.Status === 0  && dayData.AttDate !== istoday) {
                                        attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    }
                                    // if (latenessStatus && dayData.Status === 1  && attValue == "P") {
                                    if (latenessStatus && dayData.Status === 1 && dayData.AttDate !== istoday) {

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
                                        case 'HF':
                                            attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                            attenBoxContent += `
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" 
                                            data-employee-id="${employeeId}" data-exist="${dayData.DataExist}"data-status="${dayData.Status}" data-draft="${draft}">
                                                 ${iconHtml}
                                            </a>
                                        `;
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
                                        case 'EL':
                                            attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                            break;
                                        default:
                                        attenBoxContent += `<span class="atte-present"></span>`;

                                           attenBoxContent += `
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" 
                                            data-employee-id="${employeeId}" data-exist="${dayData.DataExist}"data-status="${dayData.Status}" data-draft="${draft}">
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

                                    //if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;

                                    //}
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
            // Check if there's an active tab stored in sessionStorage
            const activeTab = sessionStorage.getItem('activeTab');
            console.log("Stored Active Tab:", activeTab); // Log to verify if the active tab is being stored

            // If there's a stored active tab, activate it after page reload
            if (activeTab) {
                $('#myTab1 a[href="' + activeTab + '"]').tab('show');
            }

            // Event listener for tab clicks (store the active tab href when clicked)
            $('#myTab1 a').on('click', function (e) {
                // Store the href of the clicked tab in sessionStorage
                const activeTab = $(this).attr('href');
                sessionStorage.setItem('activeTab', activeTab);
                console.log("Storing activeTab:", activeTab); // Log the href being stored
            });

            // Handle form submission (AJAX)
            $('#leaveForm').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                // Store the active tab before submitting the form
                const activeTab = $('#myTab1 .nav-link.active').attr('href');
                sessionStorage.setItem('activeTab', activeTab);
                console.log("Storing active tab before submit:", activeTab);
                $('#loader').show();  // Assuming you have a div with the id 'loader' to show loading spinner

                // Form submission logic
                const url = $(this).attr('action');
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(), // Serialize form data
                    success: function (response) {
                        $('#loader').hide();

                        $('#leaveMessage').show(); // Show the message div
                        if (response.success) {
                            $('#leaveMessage').removeClass('alert-danger').addClass('alert-success')
                                .text('Form submitted successfully!').show();
                                $('#leaveForm')[0].reset(); // Resets the form fields to their default values
                                setTimeout(function () {
                                location.reload(); // Reload the page
                            }, 2000);
                        } else {

                            $('#leaveMessage').removeClass('alert-success').addClass('alert-danger')
                                .text(response.message).show();
                                $('#loader').hide();

                        }
                    },
                    error: function (xhr, status, error) {
                        $('#leaveMessage').removeClass('alert-success').addClass('alert-danger')
                            .text('An error occurred: ' + error).show();
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
        function validatePhoneNumber(input) {
        // Ensure only numeric input and limit the input to 12 digits
        input.value = input.value.replace(/[^0-9]/g, '').slice(0, 12);
    }
    function deleteLeaveRequest(leaveId) {
        // Confirm before deleting
        if (confirm('Are you sure you want to delete this leave request?')) {
            // Send AJAX request to delete the leave request
            $.ajax({
                url: '/leave-request/' + leaveId,  // Using ApplyLeaveId in the URL
                type: 'DELETE',  // HTTP method
                data: {
                    "_token": "{{ csrf_token() }}",  // CSRF token for security
                },
                success: function(response) {
                // Show a success toast notification
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
                
                $('#applyCancellationModal').modal('hide'); // Close the modal
            },
            error: function(xhr, status, error) {
                // Show an error toast notification
                toastr.error('An error occurred while processing the cancellation.', 'Error', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
            }
            });
        }
    }

    // Attach event listener to Apply Cancellation button
    // $(document).on('click', '.apply-cancellation-btn', function() {
    //     var leaveId = $(this).data('leave-id'); // Get the leave ID from the button's data-leave-id attribute
        
    //     // Send an AJAX request to reverse the leave acceptance
    //     $.ajax({
    //         url: '/leave/reverse-cancellation/' + leaveId, // URL to hit in your controller
    //         method: 'POST',
    //         data: {
    //             _token: '{{ csrf_token() }}' // CSRF token for security
    //         },
    //         success: function(response) {
    //             // Handle success response
    //             alert(response.message); // Or handle success in a way that updates the UI
    //         },
    //         error: function(xhr, status, error) {
    //             // Handle error
    //             alert('An error occurred while processing the cancellation.');
    //         }
    //     });
    // });
    $(document).on('click', '.apply-cancellation-btn', function() {
        // Get leave data from the button's data attributes
        var leaveId = $(this).data('leave-id');
        var applyFrom = $(this).data('apply-from');
        var applyTo = $(this).data('apply-to');
        var leaveType = $(this).data('leave-type');

        // Set data in the modal
        $('#modalLeaveType').text(leaveType);
        $('#modalFromDate').text(applyFrom);
        $('#modalToDate').text(applyTo);
        
        // Open the modal
        $('#applyCancellationModal').modal('show');

        // Attach the leaveId to the "Save & Close" button
        $('#saveCancellationBtn').data('leave-id', leaveId);
    });

    $(document).on('click', '#saveCancellationBtn', function() {
    var leaveId = $(this).data('leave-id'); // Get the leave ID
    var remark = $('#remarkInput').val(); // Get the remark

    // Show confirmation dialog before proceeding
    var isConfirmed = confirm('Are you sure you want to apply cancellation for this leave?');

    if (isConfirmed) {
        // Proceed with the AJAX request only if the user confirms
        $.ajax({
            url: '/leave/reverse-cancellation-request/' + leaveId, // URL to hit in your controller
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                remark: remark,
                leaveId: leaveId,
            },
            success: function(response) {
                console.log(response);

                // Show a success toast notification
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
                
                $('#applyCancellationModal').modal('hide'); // Close the modal
            },
            error: function(xhr, status, error) {
                // Show an error toast notification
                toastr.error('An error occurred while processing the cancellation.', 'Error', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
            }
        });
    } else {
        // If not confirmed, do nothing (cancellation is aborted)
        console.log('Cancellation aborted');
    }
});
toastr.success(response.message, 'Success', {
    "positionClass": "toast-top-right", 
    "timeOut": 5000, 
    "progressBar": true,  // Show progress bar with toast
    "closeButton": true   // Show close button for the toast
});

$(document).ready(function () {
            $('#AttendenceAuthorisation').on('hidden.bs.modal', function () {
                $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 5 seconds
                $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form (if applicable)
            });
        });
     

      
</script>
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