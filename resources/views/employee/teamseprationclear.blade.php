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
                                    <li class="breadcrumb-link active">My Team - Sepration/Clearance</li>
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
                    <form method="GET" action="{{ route('teamseprationclear') }}">
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
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>Team: Employee Separation Data</b></h5>
                    </div>
                    <div class="card-body table-responsive">
    <!-- Table for displaying separation data -->
    <table class="table table-bordered">
        <thead style="background-color:#cfdce1;">
            <tr>
                <th>SN</th>
                <th>EC</th>
                <th>Employee Name</th>
                <th>Function</th>
                <th>Resignation Date</th>
                <th>Relieving Date</th>
                <th>Resignation Reason</th>
                <th>Reporting Relieving Date</th>
                <th>Reporting Remark</th>
                <th>Employee Details</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @php
            $index = 1;
        @endphp
        @forelse($seperationData as $separation)
            @foreach($separation['seperation'] as $data)
            @php
                // Check if the EmployeeID matches Rep_EmployeeID and both Rep_Approved and HR_Approved are 'Y'
                $exitFormAvailable = \App\Models\EmployeeSeparation::where('Rep_EmployeeID', Auth::user()->EmployeeID)
                    ->where('Rep_Approved', 'Y')
                    ->where('HR_Approved', 'Y')
                    ->where('EmpSepId', $data->EmpSepId)
                    ->exists(); 
            @endphp
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{$data->EmpCode}}</td>
                <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td>
                <td></td>
                <td>{{ $data->Emp_ResignationDate ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y') : '' }}</td>
                <td>{{ $data->Emp_RelievingDate ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y') : '' }}</td>

                <td title="{{ $data->Emp_Reason ?? 'N/A' }}" style="cursor: pointer;">
                                                                        {{ \Str::words($data->Emp_Reason ?? 'N/A', 5, '...') }}
                                                                        </td>
                <td>{{ $data->Rep_RelievingDate ? \Carbon\Carbon::parse($data->Rep_RelievingDate)->format('j F Y') : '' }}</td>
                
                <td title="{{ $data->Rep_Remark ?? 'N/A' }}" style="cursor: pointer;">
                                                                        {{ \Str::words($data->Rep_Remark ?? 'N/A', 5, '...') }}
                                                                        </td>
                <!-- <td><a data-bs-toggle="modal" data-bs-target="#empdetails" href="#">Click</a></td> -->
                <td><a href="javascript:void(0);" onclick="showEmployeeDetails({{ $data->EmployeeID }})"><i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon --></a></td>

                <td>
                    @if($data->Rep_Approved == 'Y')
                        Approved
                    @elseif($data->Rep_Approved == 'N')
                        Reject
                    @else
                        Pending
                    @endif
                </td>
                @if($data->direct_reporting)

                <td>
                                <button type="button" 
                    onclick="showUpdateForm(
                        '{{ $data->Fname }}', 
                        '{{ $data->Lname }}', 
                        '{{ $data->Sname }}', 
                        '{{ $data->EmpSepId }}', 
                        '{{ addslashes($data->Rep_RelievingDate) }}', 
                        '{{ addslashes($data->Rep_Remark) }}', 
                        '{{ $data->Rep_Approved }}', 
                        '{{ addslashes($data->Emp_RelievingDate) }}'
                    )" 
                    style="border: none; background: transparent; padding: 0; color: blue;">
                    Action
                </button>
                  


                </td>
                @endif
            </tr>
            @endforeach
        @empty
            <tr>
                <td colspan="11" class="text-center">No separation data available for any employee.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>


                </div>
                </div>
                @php
    $userEmployeeId = Auth::user()->EmployeeID;
    // Get the department of the currently logged-in user
    $userDepartment = $employeeDepartmentDetails->firstWhere('EmployeeID', $userEmployeeId)->DepartmentCode ?? null;
    @endphp
    @if($approvedEmployees->contains('Rep_EmployeeID', Auth::user()->EmployeeID))
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5><b>Departmental NOC Clearance Form</b></h5>
                </div>
                <div class="card-body table-responsive">
                    <!-- Clearance Table -->
                    <table class="table table-bordered">
                           
                                        <thead style="background-color:#cfdce1;">
                                            <tr>
                                            <th>SN</th>
                                            <th>EC</th>
                                            <th>Employee Name</th>
                                            <th>Department</th>
                                            <th>Email</th>
                                            <th>Resignation Date</th>
                                            <th>Relieving Date</th>
                                            <th>Resignation Approved</th>
                                            <th>Exit interview form</th>

                                            <th>Clearance Status</th>
                                            <th>Clearance form</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = 1;
                                            @endphp
                                           @forelse($seperationData as $separation)
                                            @foreach($separation['seperation'] as $data)
                                            @php
                                                // Check if the EmployeeID matches Rep_EmployeeID and both Rep_Approved and HR_Approved are 'Y'
                                                $exitFormAvailable = \App\Models\EmployeeSeparation::where('Rep_EmployeeID', Auth::user()->EmployeeID)
                                                    ->where('Rep_Approved', 'Y')
                                                    ->where('HR_Approved', 'Y')
                                                    ->where('EmpSepId', $data->EmpSepId)
                                                    ->exists(); 
                                            @endphp
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $data->EmpCode }}</td>

                                                <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td> <!-- Employee Name -->
                                                <td>{{ $data->DepartmentName }}</td> <!-- Employee Name -->
                                                <td>{{ $data->EmailId_Vnr }}</td> <!-- Employee Name -->

                                                <td>{{ 
                                                    $data->Emp_ResignationDate
                                                    ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y')
                                                    : 'Not specified' 
                                                }}</td>
                                                <td>{{ 
                                                    $data->Emp_RelievingDate
                                                    ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y')
                                                    : 'Not specified' 
                                                }}</td>
                                                <td>
                                                <span>{{ $data->Rep_Approved == 'Y' ? 'Approved' : 'Rejected' }}</span>

                                                </td>
                                                @if($exitFormAvailable)
                                                    <td>
                                                    
                                                    @php
                                                        // Fetch the record from the hrm_employee_separation_nocrep table using EmpSepId
                                                        $nocRecordexit = \DB::table('hrm_employee_separation_exitint')->where('EmpSepId', $data->EmpSepId)->first();
                                                    @endphp

                                                    @if($nocRecordexit)
                                                        @if($nocRecordexit->draft_submit_exit_repo === 'Y')
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exitfromreporting"
                                                        data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }} "
                                                        data-designation="{{ $data->DesigName }}"
                                                        data-emp-code="{{ $data->EmpCode }}"
                                                        data-department="{{ $data->DepartmentName }}"
                                                        data-emp-sepid="{{ $data->EmpSepId }}">
                                                        Draft
                                                    </a>
                                                        @elseif($nocRecordexit->final_submit_exit_repo === 'Y')
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exitfromreporting"
                                                        data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}"
                                                        data-designation="{{ $data->DesigName }}"
                                                        data-emp-code="{{ $data->EmpCode }}"
                                                        data-department="{{ $data->DepartmentName }}"
                                                        data-emp-sepid="{{ $data->EmpSepId }}">
                                                        Submitted
                                                    </a>                                                        @else
                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#exitfromreporting"
                                                        data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }} "
                                                        data-designation="{{ $data->DesigName }}"
                                                        data-emp-code="{{ $data->EmpCode }}"
                                                        data-department="{{ $data->DepartmentName }}"
                                                        data-emp-sepid="{{ $data->EmpSepId }}">
                                                        Pending
                                                    </a>
                                                     @endif
                                                    @else
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exitfromreporting"
                                                        data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}"
                                                        data-designation="{{ $data->DesigName }}"
                                                        data-emp-code="{{ $data->EmpCode }}"
                                                        data-department="{{ $data->DepartmentName }}"
                                                        data-emp-sepid="{{ $data->EmpSepId }}">
                                                        Pending
                                                    </a>
                                                    @endif
                                                </td> 
                                                @else
                                                <td></td>
                                                @endif
                                                <td>
                                                    @php
                                                        // Fetch the record from the hrm_employee_separation_nocrep table using EmpSepId
                                                        $nocRecord = \DB::table('hrm_employee_separation_nocrep')->where('EmpSepId', $data->EmpSepId)->first();
                                                    @endphp

                                                    @if($nocRecord)
                                                        @if($nocRecord->draft_submit_dep === 'Y')
                                                            <span class="text-warning">Draft</span>
                                                        @elseif($nocRecord->final_submit_dep === 'Y')
                                                            <span class="text-danger">Submitted</span>
                                                        @else
                                                            <span class="text-warning">Pending</span>
                                                        @endif
                                                    @else
                                                        <span class="text-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsDepartment"
                                                        data-emp-name="{{ $data->Fname }} {{ $data->Sname }}  {{ $data->Lname }}"
                                                        data-designation="{{ $data->DesigName }}"
                                                        data-emp-code="{{ $data->EmpCode }}"
                                                        data-department="{{ $data->DepartmentName }}"
                                                        data-emp-sepid="{{ $data->EmpSepId }}">
                                                        form click
                                                    </a>
                                                </td>                  
                                            </tr>
                                            @endforeach
                                                @empty
                                                    <tr>
                                                        <td colspan="11" class="text-center">No separation data available for any employee.</td>
                                                    </tr>
                                                @endforelse
                                        </tbody>
                                    
                        </table>
                </div>
            </div>
        </div>
    @endif

 
                        </div>
				@include('employee.footerbottom')

            </div>
        </div>
    </div>
   <!-- Modal HTML -->
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
        <div class="modal fade show" id="clearnsdetailsDepartment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span class="emp-name"></span></b></li>
                            <li> <b> Designation: <span class="designation" style="margin-right:77px;"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span class="emp-code" ></span></b></li>
                            <li> <b> Department: <span class="department"  ></span></b></li>
                        </ul>
                    </div>
                </div>

                <form id="departmentnocfrom" method="POST">
                @csrf
                    <input type="hidden" name="EmpSepId">
                    <div class="clformbox">
                        <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                <label style="width: auto; margin-right: 10px;"><b>1. Handover of Data Documents etc</b></label>
                                <div style="display: flex; align-items: center;">
                                    <label style="margin-right: 10px;">
                                        <input type="checkbox" name="DDH[]" value="NA"> NA
                                    </label>
                                    <label style="margin-right: 10px;">
                                        <input type="checkbox" name="DDH[]" value="Yes"> Yes
                                    </label>
                                    <label>
                                        <input type="checkbox" name="DDH[]" value="No"> No
                                    </label>
                                </div>
                            </div>

                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="DDH_Amt" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="DDH_Remark" placeholder="Enter remarks"style="margin:10px;">
                                </div>
                                </div>

                                <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                    <label style="width: auto; margin-right: 10px;"><b>2. Handover of ID Card</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="TID[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="TID[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="TID[]" value="No"> No
                                        </label>
                                    </div>
                                </div>

                                    <div class="clrecoveramt">
                                        <input class="form-control" type="number" name="TID_Amt" placeholder="Enter recovery amount">
                                    </div>
                                    <div class="clreremarksbox">
                                        <input class="form-control" type="text" name="TID_Remark" placeholder="Enter remarks">
                                    </div>
                                </div>

                                <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                    <label style="width: auto; margin-right: 10px;"><b>3. Complete pending task</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="APTC[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="APTC[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="APTC[]" value="No"> No
                                        </label>
                                    </div>
                                </div>

                                    <div class="clrecoveramt">
                                        <input class="form-control" type="number" name="APTC_Amt" placeholder="Enter recovery amount">
                                    </div>
                                    <div class="clreremarksbox">
                                        <input class="form-control" type="text" name="APTC_Remark" placeholder="Enter remarks" style="margin:10px;">
                                    </div>
                                </div>

                                <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                    <label style="width: auto; margin-right: 10px;"><b>4. Handover of Health Card</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="HOAS[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="HOAS[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="HOAS[]" value="No"> No
                                        </label>
                                    </div>
                                </div>

                                    <div class="clrecoveramt">
                                        <input class="form-control" type="number" name="HOAS_Amt" placeholder="Enter recovery amount">
                                    </div>
                                    <div class="clreremarksbox">
                                        <input class="form-control" type="text" name="HOAS_Remark" placeholder="Enter remarks" style="margin:10px;">
                                    </div>
                                </div>
                        <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="otherreamrk" placeholder="if any remarks enter here">
                        </div>
                    </div>

                        <div class="modal-footer">
                                <button class="btn btn-primary" type="button" id="save-draft-btn">Save as Draft</button>
                                <button class="btn btn-success" type="button" id="final-submit-btn">Final Submit</button>
                            </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="exitfromreporting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">EXIT INTERVIEW FORM (To be filled by the interview)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span class="emp-name"></span></b></li>
                            <li> <b> Designation: <span class="designation" style="margin-right:77px;"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span class="emp-code"></span></b></li>
                            <li> <b> Department: <span class="department"></span></b></li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                 
                    <div class="card-body">
                    <form id="exitFormEmployee" method="POST"> 
                        @csrf 
                        <input type="hidden" name="EmpSepId">
               
                        <div class="clformbox">
                                <div class="formlabel">
                                    <label style="width:100%;"><b>1. Eligible for Rehire:</b></label><br>
                                    <input type="radio" name="docdata" value="Yes"><label>Yes</label>
                                    <input type="radio" name="docdata" value="No"><label>No</label>
                                </div>
                            </div>
                            <div class="clformbox">
                                <div class="formlabel">
                                    <label style="width:100%;"><b>2. Last Performance rating (On a scale of 1-5)</b></label><br>
                                </div>
                                <div class="clrecoveramt">
                                <input class="form-control" 
                                        type="number" 
                                        name="last_perform" 
                                        placeholder="Enter rating" 
                                        min="1" max="5" 
                                        maxlength="1" 
                                        required
                                        inputmode="numeric"
                                        oninput="this.value = this.value.slice(0, 1);">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel">
                                    <label style="width:100%;"><b>3. Interviewer's summary of the proceedings:</b></label><br>
                                </div>
                                
                                <div class="clreremarksbox">
                                    <label class="mb-0"><b>Reasons for Leaving</b></label>
                                    <input class="form-control mb-2" type="text" name="reason_leaving" placeholder="Enter remarks">
                                </div>
                                <div class="clreremarksbox">
                                    <label class="mb-0"><b>Executive's feedback on the organizational culture/ policy, job satisfaction, etc.</b></label>
                                    <input class="form-control mb-2" type="text" name="executive_org" placeholder="Enter remarks">
                                </div>
                                <div class="clreremarksbox">
                                    <label class="mb-0"><b>Suggestions given by the executive for improvement, if any.</b></label>
                                    <input class="form-control mb-2" type="text" name="sugg_executive" placeholder="Enter remarks">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="save-draft-exit-repo">Save as Draft</button>
                <button class="btn btn-success" type="submit" id="final-submit-exit-repo">Final Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal for Updating Separation Data -->
<div class="modal fade" id="updateSeparationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateSeparationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateSeparationModalLabel">Action on Employee Resignation:<span id="employeenamesep"></span></h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateSeparationForm">
                <div class="modal-body">
                    <input type="hidden" id="empSepIdField" name="EmpSepId">
                    <div class="row">
                    <div class="mb-3 col-md-6" id="relievingDateContainer">
                        <label for="relievingDateField" class="form-label"><b>Relieving Date by Reporting</b></label>
                        <!-- Initially, this will be input field -->
                        <input type="date" id="relievingDateField" name="Emp_RelievingDate" class="form-control" style="display: none;">
                        <!-- This will be displayed if data is available -->
                        <span id="relievingDateSpan" style="display: none;"></span>
                    </div>
                    <div class="col-md-6 mb-3 " id="statusContainer">
                        <div class="form-group s-opt">
                            <label for="statusField" class="form-label"><b>Status</b></label>
                            <!-- This will be displayed if data is available -->
                            <span id="statusSpan" style="display: none;"></span>
                            <!-- Initially, this will be input field for editing status -->
                            <select id="statusField" name="Rep_Approved" class="select2 form-control select-opt" style="display: none;">
                                <option value="Y">Approved</option>
                                <option value="N">Reject</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3" id="remarkContainer">
                        <label for="remarkField" class="form-label"><b>Reporting Remark</b></label>
                        <!-- Initially, this will be input field -->
                        <!--<input type="text" id="remarkField" name="Rep_Remark" class="form-control" style="display: none;">-->
                        <textarea id="remarkField" name="Rep_Remark" class="form-control" style="display: none;"></textarea>
                        <!-- This will be displayed if data is available -->
                        <span id="remarkSpan" style="display: none;"></span>
                    </div>
                    
            </div>
            <div class="modal-footer">
                <button type="button" id="submitBtn" class="btn btn-primary" onclick="updateSeparationData()">Submit</button>
            </div>
                </form>
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
function showUpdateForm(fname, lname, sname, empSepId, relievingDate, remark, status, emprelievingdate) {
    // Set the Employee Separation ID value
    document.getElementById('empSepIdField').value = empSepId;
    document.getElementById('employeenamesep').textContent = fname + ' ' + lname + ' ' + sname;

    // Handle Reporting Relieving Date field
    if (relievingDate && relievingDate !== '1970-01-01') {
        // If a relieving date is provided, show it in the span and hide the input
        document.getElementById('relievingDateSpan').textContent = relievingDate;
        document.getElementById('relievingDateSpan').style.display = 'inline';  // Show the span with the relieving date
        document.getElementById('relievingDateField').style.display = 'none';  // Hide the input field
    }else if (emprelievingdate) {
        // If no relieving date exists but emprelievingdate is available, show the input with this date
        document.getElementById('relievingDateField').value = emprelievingdate;  // Set the input value
        document.getElementById('relievingDateField').style.display = 'inline';  // Show the input field
        document.getElementById('relievingDateSpan').style.display = 'none';  // Hide the span
    } else {
        // If no relieving date exists and no default is provided, show the input field
        document.getElementById('relievingDateField').style.display = 'inline';  // Show the input field
        document.getElementById('relievingDateSpan').style.display = 'none';  // Hide the span
    }

    // Handle Reporting Remark field
    if (remark) {
        // If remark is provided, show it in the span and hide the input
        document.getElementById('remarkSpan').textContent = remark;
        document.getElementById('remarkSpan').style.display = 'inline';  // Show the span with the remark
        document.getElementById('remarkField').style.display = 'none';  // Hide the input field
    } else {
        // If no remark exists, show the input field
        document.getElementById('remarkField').style.display = 'inline';  // Show the input
        document.getElementById('remarkSpan').style.display = 'none';  // Hide the span
    }

    // Handle Status field
        if (status === 'Y' || status === 'N') {
            // If status is 'Y' (Approved) or 'N' (Reject), show it in the span and hide the dropdown
            document.getElementById('statusSpan').textContent = status === 'Y' ? 'Approved' : 'Reject';
            document.getElementById('statusSpan').style.display = 'inline';  // Show the span with the status text
            document.getElementById('statusField').style.display = 'none';  // Hide the dropdown
        } else {
            // If status is empty or doesn't match 'Y'/'N', show the dropdown for editing status
            document.getElementById('statusField').value = 'Y'; // Set default value to 'Approved'
            document.getElementById('statusField').style.display = 'inline';  // Show the dropdown
            document.getElementById('statusSpan').style.display = 'none';  // Hide the span
        }
          // Handle the Submit button visibility
    if (status === 'Y' || status === 'N') {
        // If status is 'Approved', hide the Submit button
        document.getElementById('submitBtn').style.display = 'none';
    } else {
        // Otherwise, show the Submit button
        document.getElementById('submitBtn').style.display = 'inline-block';
    }

    // Show the modal with the populated or blank data
    new bootstrap.Modal(document.getElementById('updateSeparationModal')).show();
}

$('#exitfromreporting').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var empName = button.data('emp-name');
    var designation = button.data('designation');
    var empCode = button.data('emp-code');
    var department = button.data('department');
    var empSepId = button.data('emp-sepid');

    // Update the modal's content with employee data
    var modal = $(this);
    modal.find('.emp-name').text(empName);
    modal.find('.designation').text(designation);
    modal.find('.emp-code').text(empCode);
    modal.find('.department').text(department);

    // Set the EmpSepId in a hidden input field to send with the form
    modal.find('input[name="EmpSepId"]').val(empSepId);

    // Fetch additional data for this EmpSepId using an AJAX request
    $.ajax({
        url: '/get-exit-repo-data/' + empSepId, // Assuming the endpoint is correct
        method: 'GET',
        success: function(response) {
            if (response.success) {
                var nocData = response.data; // Data returned from the backend
                console.log(nocData);

                // Populate radio buttons for "Eligible for Rehire"
                if (nocData.Rep_EligForReHire === 'Y') {
                    $('input[name="docdata"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.Rep_EligForReHire === 'N') {
                    $('input[name="docdata"][value="No"]').prop('checked', true); // Check 'No'
                }

                // Populate "Last Performance rating" input
                $('input[name="last_perform"]').val(nocData.Rep_Rating);

                // Populate "Reasons for Leaving"
                $('input[name="reason_leaving"]').val(nocData.Rep_ReasonsLeaving);

                // Populate "Executive's feedback on the organizational culture/policy"
                $('input[name="executive_org"]').val(nocData.Rep_CulturePolicy);

                // Populate "Suggestions given by the executive for improvement"
                $('input[name="sugg_executive"]').val(nocData.Rep_SuggImp);

                // Check if the form is finalized
                if (nocData.final_submit_exit_repo === 'Y') {
                    // Disable all form fields if the status is 'Y'
                    $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                    // Hide the "Save as Draft" and "Final Submit" buttons
                    $('.modal-footer #save-draft-exit-repo').hide();
                     $('.modal-footer #final-submit-exit-repo').hide();
                }
            }
        },
        error: function() {
            alert('Error fetching NOC data.');
        }
    });
});

     // Update both Repo. Relieving Date and Status in one request
     function updateSeparationData() {
    // Get data from the modal form
    var empSepId = document.getElementById('empSepIdField').value; // Employee Separation ID
    var relievingDate = document.getElementById('relievingDateField').value; // Reporting Relieving Date
    var remark = document.getElementById('remarkField').value.trim(); // Reporting Remark
    var status = document.getElementById('statusField').value; // Status (Approved or Reject)
    $('#loader').show(); // Show loading spinner

    // Check if necessary data is available
    if (!relievingDate || !remark || !status) {
        toastr.warning('Please fill in all the fields before submitting.', 'Warning', {
            "positionClass": "toast-top-right", 
            "timeOut": 3000 
        });
        $('#loader').hide(); // Show loading spinner

        return; // Stop further execution if any field is missing
    }

    $('#loader').show(); // Show loading spinner

    // Send data to the server using AJAX
    $.ajax({
        url: '/update-rep-relieving-date', // Make sure this route exists in your web.php
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',  // CSRF token for security
            EmpSepId: empSepId,  // Employee Separation ID
            Rep_RelievingDate: relievingDate,  // Reporting Relieving Date
            Rep_Remark: remark,  // Reporting Remark
            Rep_Approved: status,  // Reporting Status
        },
        success: function(response) {
            $('#loader').hide(); // Hide loading spinner
            if (response.success) {
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right", 
                    "timeOut": 3000 
                });
                // Set a timeout to reload the page after 3 seconds
                setTimeout(function() {
                    location.reload(); // Reload the page after 3 seconds
                }, 3000); // 3000 milliseconds = 3 seconds
                $('#updateSeparationModal').modal('hide'); // Close the modal
            } else {
                toastr.error(response.message, 'Error', {
                    "positionClass": "toast-top-right", 
                    "timeOut": 3000 
                });
                // Set a timeout to reload the page after 3 seconds
                setTimeout(function() {
                    location.reload(); // Reload the page after 3 seconds
                }, 3000); // 3000 milliseconds = 3 seconds
            }
    $('#loader').hide(); // Show loading spinner

        },
        error: function(xhr, status, error) {
            $('#loader').hide(); // Hide loading spinner
            toastr.error('An error occurred while processing the request.', 'Error', {
                "positionClass": "toast-top-right", 
                "timeOut": 5000 
            });
    $('#loader').hide(); // Show loading spinner

        }
    });
}

  
    document.addEventListener('DOMContentLoaded', function() {
    // Get the form and buttons
    const form = document.getElementById('exitFormEmployee');
    const saveDraftButton = document.getElementById('save-draft-exit-repo');
    const submitButton = document.getElementById('final-submit-exit-repo');

    // Function to handle form submission
    function handleFormSubmission(buttonId) {
        // Prevent the form from submitting normally
        event.preventDefault();
        $('#loader').show(); // Hide loading spinner

        // Collect form data
        const formData = new FormData(form);

        // Append additional data to the FormData object
        formData.append('button_id', buttonId);  // Add the button ID to identify the action (save-draft or final-submit)

        // Send data to the controller using fetch
        fetch("{{ route('submit.exit.form') }}", {  // Replace with your actual route
            method: "POST",  // Use POST method
            body: formData,  // Send form data
        })
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            $('#loader').hide(); // Hide loading spinner

            // Handle the response here (e.g., show success or error message)
            if (data.success) {  // Assuming your server returns a 'success' field
                // Show a success toast notification
                toastr.success(data.message, 'Success', {
                    "positionClass": "toast-top-right",  // Position at top-right
                    "timeOut": 3000  // 3-second timeout for the toast
                });

                // Optionally, reload the page after a delay
                setTimeout(function() {
                    location.reload();  // Reload the page to reflect any changes
                }, 3000);  // Delay before reload to match toast timeout
            } else {
                // Show an error toast notification
                toastr.error('Error: ' + data.message, 'Error', {
                    "positionClass": "toast-top-right",  // Position at top-right
                    "timeOut": 3000  // 3-second timeout for the toast
                });
    $('#loader').hide(); // Show loading spinner

            }
        })
        .catch(error => {
            // Handle any errors from the fetch request
            toastr.error('Error: ' + error.message, 'Error', {
                "positionClass": "toast-top-right",  // Position at top-right
                "timeOut": 3000  // 3-second timeout for the toast
            });
    $('#loader').hide(); // Show loading spinner

        });
    }

    // Event listener for the "Save as Draft" button
    saveDraftButton.addEventListener('click', function(event) {
        $('#loader').show(); // Hide loading spinner
    handleFormSubmission('save-draft-exit-repo');
});


    // Event listener for the "Final Submit" button
    submitButton.addEventListener('click', function(event) {
        $('#loader').show(); // Hide loading spinner
        handleFormSubmission('final-submit-exit-repo');  // Pass 'final-submit-btn' as the button ID
    });
});


document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
checkbox.addEventListener('change', function () {
    const name = this.name;
    
    // Uncheck all checkboxes in the group, except the one that was just clicked
    document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
        if (otherCheckbox !== checkbox) {
            otherCheckbox.checked = false;
        }
    });
});
});
$('#clearnsdetailsDepartment').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var empName = button.data('emp-name');
    var designation = button.data('designation');
    var empCode = button.data('emp-code');
    var department = button.data('department');
    var empSepId = button.data('emp-sepid');

    // Update the modal's content with employee data
    var modal = $(this);
    modal.find('.emp-name').text(empName);
    modal.find('.designation').text(designation);
    modal.find('.emp-code').text(empCode);
    modal.find('.department').text(department);

    // Set the EmpSepId in a hidden input field to send with the form
    modal.find('input[name="EmpSepId"]').val(empSepId);

    // Fetch additional data for this EmpSepId using an AJAX request
    $.ajax({
        url: '/get-noc-data/' + empSepId, // Assuming the endpoint is correct
        method: 'GET',
        success: function(response) {
            if (response.success) {
                var nocData = response.data; // Data returned from backend

                // Populate checkboxes and input fields with the fetched data
                // 1. Handover of Data Documents etc (DDH)
                if (nocData.DDH === 'Y') {
                    $('input[name="DDH[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.DDH === 'N') {
                    $('input[name="DDH[]"][value="No"]').prop('checked', true); // Check 'No'
                }
                // } else {
                //     $('input[name="DDH[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                // }
                $('input[name="DDH_Amt"]').val(nocData.DDH_Amt);
                $('input[name="DDH_Remark"]').val(nocData.DDH_Remark);

                // 2. Handover of ID Card (TID)
                if (nocData.TID === 'Y') {
                    $('input[name="TID[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.TID === 'N') {
                    $('input[name="TID[]"][value="No"]').prop('checked', true); // Check 'No'
                }
                //  else {
                //     $('input[name="TID[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                // }
                $('input[name="TID_Amt"]').val(nocData.TID_Amt);
                $('input[name="TID_Remark"]').val(nocData.TID_Remark);

                // 3. Complete pending task (APTC)
                if (nocData.APTC === 'Y') {
                    $('input[name="APTC[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.APTC === 'N') {
                    $('input[name="APTC[]"][value="No"]').prop('checked', true); // Check 'No'
                } 
                // else {
                //     $('input[name="APTC[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                // }
                $('input[name="APTC_Amt"]').val(nocData.APTC_Amt);
                $('input[name="APTC_Remark"]').val(nocData.APTC_Remark);

                // 4. Handover of Health Card (HOAS)
                if (nocData.HOAS === 'Y') {
                    $('input[name="HOAS[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.HOAS === 'N') {
                    $('input[name="HOAS[]"][value="No"]').prop('checked', true); // Check 'No'
                } 
                // else {
                //     $('input[name="HOAS[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                // }
                $('input[name="HOAS_Amt"]').val(nocData.HOAS_Amt);
                $('input[name="HOAS_Remark"]').val(nocData.HOAS_Remark);
                $('input[name="otherreamrk"]').val(nocData.Oth_Remark);

                // Check if the final status is 'Y'
                if (nocData.final_submit_dep === 'Y') {
                    // Disable all form fields if the status is 'Y'
                    $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                    $('.modal-footer #save-draft-btn').hide();
                    $('.modal-footer #final-submit-btn').hide();
                }
            }
        },
        error: function() {
            alert('Error fetching NOC data.');
        }
    });
});

// Get the form and buttons
const form = document.getElementById('departmentnocfrom');
const saveDraftButton = document.getElementById('save-draft-btn');
const submitButton = document.getElementById('final-submit-btn');

// Function to handle form submission
function handleFormSubmission(buttonId) {
    // Prevent the form from submitting normally
    event.preventDefault(); 
    $('#loader').show(); // Show loading spinner

    // Collect form data
    const formData = new FormData(form);
    const formId = form.id;  // This will be 'departmentnocfrom'
    formData.append('form_id', formId);  // Add the form id to the form data

    // Add the button ID (either 'save-draft-btn' or 'final-submit-btn')
    formData.append('button_id', buttonId);

    // Send data to the controller using fetch
    fetch("{{ route('submit.noc.clearance') }}", {
        method: "POST",  // Use POST method
        body: formData,  // Send form data
    })
    .then(response => response.json())  // Parse the JSON response
.then(data => {
    
    // Handle the response here (e.g., show success message)
    if (data.success) {  // Use 'data' instead of 'response'
    $('#loader').hide(); // Show loading spinner

        // Show a success toast notification with custom settings
        toastr.success(data.message, 'Success', {
            "positionClass": "toast-top-right",  // Position the toast at the top-right corner
            "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
        });

        // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
        setTimeout(function () {
            location.reload();  // Optionally, reload the page
        }, 3000); // Delay before reset and reload to match the toast timeout

    } else {
        // Show an error toast notification with custom settings
        toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
            "positionClass": "toast-top-right",  // Position the toast at the top-right corner
            "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
        });
    $('#loader').hide(); // Show loading spinner

    }
})
.catch(error => {
    // Handle errors from the fetch request itself
    toastr.error('Error: ' + error.message, 'Error', {
        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
    });
    $('#loader').hide(); // Show loading spinner

});
}

// Event listener for the "Save as Draft" button
saveDraftButton.addEventListener('click', function(event) {
    handleFormSubmission('save-draft-btn');  // Pass 'save-draft-btn' as the button ID
});

// Event listener for the "Final Submit" button
submitButton.addEventListener('click', function(event) {
    handleFormSubmission('final-submit-btn');  // Pass 'final-submit-btn' as the button ID
});
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
function formatDateddmmyyyy(date) {
            const d = new Date(date);
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


