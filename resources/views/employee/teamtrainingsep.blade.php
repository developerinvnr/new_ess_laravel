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
                                    <li class="breadcrumb-link active">My Team - Training</li>
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
                                                    <form method="GET" action="{{ route('teamtrainingsep') }}">
                                                        @csrf
                                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                                            <label for="hod-view" class="form-label text-muted mt-1"  style="float:right;">HOD/Reviewer</label>
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
                    
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>Team: Employee Training Data</b></h5>
                        <div class="flex-shrink-0" style="float:right;">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <!-- <label for="base-class" class="form-label text-muted mt-1">HOD/Reviewer</label> -->
                                <!-- <input class="form-check-input code-switcher" type="checkbox" id="base-class"> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- Table for displaying separation data -->
                        <table class="table table-bordered">
        <thead style="background-color:#cfdce1;">
            <tr>
                <th colspan="9">Employee Name</th>
            </tr>
        </thead>
        <tbody>
            @php
                $index = 1;
            @endphp
            @forelse ($groupedTrainingData as $employeeName => $trainingDetails)
                <!-- Employee Name Row (click to expand/collapse) -->
                <tr data-toggle="collapse" data-target="#collapse-{{ Str::slug($employeeName) }}" aria-expanded="false" aria-controls="collapse-{{ Str::slug($employeeName) }}" style="cursor: pointer; background-color:#e9ecef;">
                    <td colspan="9">{{ $employeeName }}</td>
                </tr>

                <!-- Training Data Rows (hidden by default) -->
                <tr class="collapse" id="collapse-{{ Str::slug($employeeName) }}">
                    <td colspan="9">
                        <table class="table table-bordered">
                            <thead style="background-color:#f8f9fa;">
                                <tr>
                                    <th>SN</th>
                                    <th>Training Title</th>
                                    <th>Year</th>
                                    <th>Date From</th>
                                    <th>Date To</th>
                                    <th>Location</th>
                                    <th>Institute</th>
                                    <th>Trainer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trainingDetails as $index => $training)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $training->TraTitle ?? 'Not specified' }}</td>
                                        <td>{{ $training->TraYear ?? 'Not specified' }}</td>
                                        <td>{{ 
                                            $training->TraFrom
                                        ? \Carbon\Carbon::parse($training->TraFrom)->format('j F Y')
                                        : 'Not specified' 
                                        }}</td>
                                        <td>{{ 
                                            $training->TraTo
                                        ? \Carbon\Carbon::parse($training->TraTo)->format('j F Y')
                                        : 'Not specified' 
                                        }}</td>
                                        <td>{{ $training->Location ?? 'Not specified' }}</td>
                                        <td>{{ $training->Institute ?? 'Not specified' }}</td>
                                        <td>{{ $training->TrainerName ?? 'Not specified' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No training data available for any employee.</td>
                </tr>
            @endforelse
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
                                <input type="text" name="employeename" class="form-control" id="employeename" readonly>
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
                                <input type="text" name="leavereason" class="form-control" id="leavereason" readonly>
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


@include('employee.footer');
<script>
    const employeeId = {{ Auth::user()->EmployeeID }};
	const repo_employeeId = {{ Auth::user()->EmployeeID }};
	const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
	const queryactionUrl = "{{ route("employee.query.action") }}";
	const getqueriesUrl = "{{ route("employee.queries") }}";

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>