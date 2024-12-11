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
                  
					
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>Team: Employee Separation Data</b></h5>
                        <div class="flex-shrink-0" style="float:right;">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="base-class" class="form-label text-muted mt-1">HOD/Reviewer</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="base-class">
                            </div>
                        </div>
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
            <th>Employee Details</th>
            <th>Separation Details</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    @php
        $index = 1;
    @endphp
    @forelse($seperationData as $separation)
        @foreach($separation['seperation'] as $data)
        <tr>
            <td>{{ $index++ }}</td>
            <td></td>
            <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
            <td></td>
            <td>
                {{ 
                    $data->Emp_ResignationDate
                    ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y')
                    : 'Not specified' 
                }}
            </td> 
            <td>
                {{ 
                    $data->Emp_RelievingDate
                    ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y')
                    : 'Not specified' 
                }}
            </td> 
            <td>{{ $data->Emp_Reason ?? 'Not specified' }}</td> <!-- Separation Reason -->
            <td>
            @if($data->Rep_Approved == 'Y')
                {{ $data->Emp_RelievingDate 
                                ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y') 
                                : 'Not specified' }}
                    
            @else
                <!-- If Rep_Approved is not Y, allow editing the Emp_RelievingDate -->
                <input type="date" 
                    name="Emp_RelievingDate[{{ $data->EmpSepId }}]" 
                    class="form-control Emp_RelievingDate" 
                    value="{{ $data->Emp_RelievingDate 
                                ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('Y-m-d') 
                                : '' }}" 
                    data-id="{{ $data->EmpSepId }}" 
                    onchange="updateSeparationData(this)">
            @endif
        </td>



            <td><a data-bs-toggle="modal" data-bs-target="#empdetails" href="">Click</a></td>
            <td><a data-bs-toggle="modal" data-bs-target="#exitfromreporting" href="">Click</a></td>
            <td>
                @if($data->Rep_Approved == 'Y')
                    <!-- If Rep_Approved is Y, display the status as read-only (non-editable dropdown) -->
                    <select class="form-control" 
                            disabled>
                        <option value="Y" {{ $data->Rep_Approved == 'Y' ? 'selected' : '' }}>Y - Approved</option>
                        <option value="N" {{ $data->Rep_Approved == 'N' ? 'selected' : '' }}>N - Reject</option>
                        <option value="C" {{ $data->Rep_Approved == 'C' ? 'selected' : '' }}>C - Cancel</option>
                        <option value="P" {{ $data->Rep_Approved == 'P' ? 'selected' : '' }}>P - Pending</option>
                    </select>
                @else
                    <!-- If Rep_Approved is not Y, allow editing -->
                    <select class="form-control status-dropdown" 
                            name="status[{{ $data->EmpSepId }}]" 
                            id="status-{{ $data->EmpSepId }}" 
                            data-id="{{ $data->EmpSepId }}" 
                            onchange="updateSeparationData(this)">
                        <option value="Y" {{ $data->Rep_Approved == 'Y' ? 'selected' : '' }}>Y - Approved</option>
                        <option value="N" {{ $data->Rep_Approved == 'N' ? 'selected' : '' }}>N - Reject</option>
                        <option value="C" {{ $data->Rep_Approved == 'C' ? 'selected' : '' }}>C - Cancel</option>
                        <option value="P" {{ $data->Rep_Approved == 'P' ? 'selected' : '' }}>P - Pending</option>
                    </select>
                @endif
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
                            @foreach($seperationData as $separation)
                                @foreach($separation['seperation'] as $data)
                                    <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
                                    @if(Auth::user()->EmployeeID == $data->Rep_EmployeeID)
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
                                            <th>Clearance Status</th>
                                            <th>Clearance form</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $index = 1;
                                            @endphp
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $data->EmpCode }}</td>

                                                <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
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
                                                <td>
                                                @if($data->EmpSepId && \DB::table('hrm_employee_separation_nocrep')->where('EmpSepId', $data->EmpSepId)->exists())
                                                <span class="text-success">Actioned</span>

                                                @else
                                                <span class="text-warning">Pending</span>

                                                @endif
                                                <td>
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsDepartment"
                                                        data-emp-name="{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}"
                                                        data-designation="{{ $data->DesigName }}"
                                                        data-emp-code="{{ $data->EmpCode }}"
                                                        data-department="{{ $data->DepartmentName }}"
                                                        data-emp-sepid="{{ $data->EmpSepId }}">
                                                        form click
                                                    </a>
                                                </td>                  
                                            </tr>
                                        </tbody>
                                    @endif
                                @endforeach
                            @endforeach
                        </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Departmnetal NOC Clearance Card -->
    @if($userDepartment === 'IT')
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h5><b>IT NOC Clearance Form</b></h5>
                </div>
                <div class="card-body table-responsive">
                    <!-- IT Clearance Table -->
                    <table class="table table-bordered">

@foreach($approvedEmployees as $data)
        <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
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
                <th>Clearance Status</th>
                <th>Clearance form</th>
                </tr>
            </thead>
            <tbody>

                @php
                    $index = 1;
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $data->EmpCode }}</td>

                    <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
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
                    <td>
                                                @if($data->EmpSepId && \DB::table('hrm_employee_separation_nocit')->where('EmpSepId', $data->EmpSepId)->exists())
                                                <span class="text-success">Actioned</span>

                                                @else
                                                <span class="text-warning">Pending</span>

                                                @endif
                </td>
                        <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsIT"
                            data-emp-name="{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}"
                            data-designation="{{ $data->DesigName }}"
                            data-emp-code="{{ $data->EmpCode }}"
                            data-department="{{ $data->DepartmentName }}"
                            data-emp-sepid="{{ $data->EmpSepId }}">
                            form click
                        </a>
                    </td>                  
                </tr>
            </tbody>
    @endforeach
</table>

                </div>
            </div>
        </div>
    @endif

        <!-- LOGISTICS Clearance Card -->
        @if($userDepartment === 'LOGISTICS')
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><b>LOGISTICS Clearance</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- LOGISTICS Clearance Table -->
                        <table class="table table-bordered">

                                    @foreach($approvedEmployees as $data)
                                            <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
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
                                                    <th>Clearance Status</th>
                                                    <th>Clearance form</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php
                                                        $index = 1;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $data->EmpCode }}</td>

                                                        <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
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
                                                        <td>
                                                                @if($data->EmpSepId && \DB::table('hrm_employee_separation_nocrep')->where('EmpSepId', $data->EmpSepId)->exists())
                                                                    @php
                                                                        // Get the draft_submit_log value for the EmpSepId
                                                                        $submitLogStatus = \DB::table('hrm_employee_separation_nocrep')
                                                                            ->where('EmpSepId', $data->EmpSepId)
                                                                            ->value('draft_submit_log');
                                                                    @endphp
                                                                    @if(is_null($submitLogStatus) || $submitLogStatus === 'N' || $submitLogStatus == 0)
                                                                        <span class="text-warning">Pending</span>
                                                                    @else
                                                                        <span class="text-success">Actioned</span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-warning">Pending</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsLOGISTIC"
                                                                data-emp-name="{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}"
                                                                data-designation="{{ $data->DesigName }}"
                                                                data-emp-code="{{ $data->EmpCode }}"
                                                                data-department="{{ $data->DepartmentName }}"
                                                                data-emp-sepid="{{ $data->EmpSepId }}">
                                                                form click
                                                            </a>
                                                        </td>                  
                                                    </tr>
                                                </tbody>
                                        @endforeach
                                </table>
                    
                    </div>
                </div>
            </div>
        @endif

        <!-- HR Clearance Card -->
        @if($userDepartment === 'HR')
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><b>HR Clearance</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- HR Clearance Table -->
                        <table class="table table-bordered">

@foreach($approvedEmployees as $data)
        <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
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
                <th>Clearance Status</th>
                <th>Clearance form</th>
                </tr>
            </thead>
            <tbody>

                @php
                    $index = 1;
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $data->EmpCode }}</td>

                    <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
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
                    <td>
                            @if($data->EmpSepId && \DB::table('hrm_employee_separation_nocrep')->where('EmpSepId', $data->EmpSepId)->exists())
                                @php
                                    // Get the draft_submit_log value for the EmpSepId
                                    $submitLogStatus = \DB::table('hrm_employee_separation_nocrep')
                                        ->where('EmpSepId', $data->EmpSepId)
                                        ->value('draft_submit_log');
                                @endphp
                                @if(is_null($submitLogStatus) || $submitLogStatus === 'N' || $submitLogStatus == 0)
                                    <span class="text-warning">Pending</span>
                                @else
                                    <span class="text-success">Actioned</span>
                                @endif
                            @else
                                <span class="text-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsLOGISTIC"
                            data-emp-name="{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}"
                            data-designation="{{ $data->DesigName }}"
                            data-emp-code="{{ $data->EmpCode }}"
                            data-department="{{ $data->DepartmentName }}"
                            data-emp-sepid="{{ $data->EmpSepId }}">
                            form click
                        </a>
                    </td>                  
                </tr>
            </tbody>
    @endforeach
</table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Account Clearance Card -->
        @if($userDepartment === 'FINANCE')
            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><b>Account Clearance</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- Account Clearance Table -->
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
                                    <th>Clearance Status</th>
                                    <th>History</th>
                                    <th>Clearance form</th>
                                </tr>
                            </thead>
                            <tbody>
                            
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
    <div class="modal fade show" id="empdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">D Chandra Reddy Sekhara Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Designation: <span>Area Sales Coordinator</span></b></li>
                            <li> <b> Location:	 <span>Jaipur</span></b></li>
                            <li> <b> Qualification:	 <span>M.Sc</span></b></li>
                            <li> <b> VNR Exp.:	<span> 4.2 year</span></b></li>
                            <li> <b> Reporting Mgr:	 <span>Mr. Dinesh Swami</span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                            <li> <b> DOJ: <span>01-10-2020</span></b></li>
                            <li> <b> Age: <span>31.1 year</span></b></li>
                            <li> <b> Total Exp.: <span>10.22 year</span></b></li>
                            <li> <b> Reviewer: <span>Mr. Dinesh Swami</span></b></li>
                        </ul>
                    </div>
                </div>

                <h5>Career Progression in VNR</h5>
                <table class="table table-bordered mt-2">
                    <thead style="background-color:#cfdce1;">
                        <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Designation</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                        </tr>
                    </tbody>
                </table>

                <h5>Previous Employers</h5>
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
                    <tbody>
                        <tr>
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
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="exitfromreporting" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Designation: <span>Area Sales Coordinator</span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                        </ul>
                    </div>
                </div>
                <div class="card">
                 
                    <div class="card-body">
                        <form>
                            <div class="clformbox">
                                <div class="formlabel">
                                    <label style="width:100%;"><b>1. Eligible for Rehire:</b></label><br>
                                    <input type="radio" name="docdata"><label>Yes</label>
                                    <input type="radio" name="docdata"><label>No</label>
                                </div>
                            </div>
                            <div class="clformbox">
                                <div class="formlabel">
                                    <label style="width:100%;"><b>2. Last Performance rating (On a scale of 1-5)</b></label><br>
                                </div>
                                <div class="clrecoveramt">
                                <input class="form-control" type="text" name="" placeholder="Enter rating">
                                </div>
                                
                            </div>
                            <div class="clformbox">
                                <div class="formlabel">
                                    <label style="width:100%;"><b>3. Interviewer's summary of the proceedings:</b></label><br>
                                </div>
                                
                                <div class="clreremarksbox">
                                    <label class="mb-0"><b>Reasons for Leaving</b></label>
                                    <input class="form-control mb-2" type="text" name="" placeholder="Enter remarks">
                                </div>
                                <div class="clreremarksbox">
                                    <label class="mb-0"><b>Executive's feedback on the organizational culture/ policy, job satisfaction, etc.</b></label>
                                    <input class="form-control mb-2" type="text" name="" placeholder="Enter remarks">
                                </div>
                                <div class="clreremarksbox">
                                    <label class="mb-0"><b>Suggestions given by the executive for improvement, if any.</b></label>
                                    <input class="form-control mb-2" type="text" name="" placeholder="Enter remarks">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="save-draft-btn">Save as Draft</button>
                <button class="btn btn-success" type="button" id="final-submit-btn">Final Submit</button>
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
     // Update both Repo. Relieving Date and Status in one request
     function updateSeparationData(element) {
        var empSepId = $(element).data('id');  // Get Employee Separation ID from the data-id attribute
        var relievingDate = $(element).closest('tr').find('input[name="Rep_RelievingDate"]').val();  // Get relieving date
        var status = $(element).closest('tr').find('.status-dropdown').val();  // Get the selected Rep_Approved status
        var hrStatus = $(element).closest('tr').find('.status-dropdown[data-id]').val();  // Get the selected HR_Approved status
        var hrRelievingDate = $(element).closest('tr').find('input[name="HR_RelievingDate"]').val();  // HR Relieving Date (if needed)

        // Send the updated data to the server
        $.ajax({
            url: '/update-rep-relieving-date',  // Define the URL in your routes
            type: 'POST',
            data: {
            _token: '{{ csrf_token() }}',
            EmpSepId: empSepId,  // Employee Separation ID
            Rep_RelievingDate: relievingDate,  // Rep Relieving Date
            Rep_Approved: status,  // Rep_Approved status
            HR_Approved: hrStatus,  // HR_Approved status (new addition)
            HR_RelievingDate: hrRelievingDate  // HR Relieving Date (new addition)
        },
            success: function (response) {
            if (response.success) {
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right", // Position the toast at the top right
                    "timeOut": 3000 // Duration for which the toast is visible (in ms)
                });
                // // Optionally reload or do something else after success
                // setTimeout(function () {
                //     location.reload(); // Reload the page
                // }, 1000);
            }
            // If the response contains an error message
            else if (response.error) {
                // toastr.error(response.message, 'Error', {
                //     "positionClass": "toast-top-right", // Position the toast at the top right
                //     "timeOut": 5000 // Duration for which the toast is visible (in ms)
                // });
            }
        },
        error: function (xhr, status, error) {

            toastr.error('An error occurred while processing', 'Error', {
                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                "timeOut": 5000  // Duration for which the toast is visible (in ms)
            });
            // setTimeout(function () {
            //     location.reload(); // Reload the page
            // }, 1000);
        }
        });
    }
    
</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>