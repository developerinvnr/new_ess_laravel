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
                                    <th>Releiving Date</th>
                                    <th>Resignation Reason</th>
                                    <th>Employee Details</th>
                                    <th>Separation Detals</th>
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
                                    <td><a data-bs-toggle="modal" data-bs-target="#empdetails"
                                        href="">Click</a></td>
                                    <td><a data-bs-toggle="modal" data-bs-target="#exitfromreporting"
                                        href="">Click</a></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No separation data available for any employee.</td>
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

<div class="modal fade show" id="clearnsdetailsDepartment" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                            <li> <b> Designation: <span class="designation"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span class="emp-code"></span></b></li>
                            <li> <b> Department: <span class="department"></span></b></li>
                        </ul>
                    </div>
                </div>

                <form id="departmentnocfrom" method="POST">
                @csrf
                    <input type="hidden" name="EmpSepId">
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Handover of Data Documents etc</b></label><br>
                            <input type="checkbox" name="DDH[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="DDH[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="DDH[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="DDH_Amt" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="DDH_Remark" placeholder="Enter remarks">
                        </div>
                        </div>

                        <div class="clformbox">
                            <div class="formlabel">
                                <label style="width:100%;"><b>2. Handover of ID Card</b></label><br>
                                <input type="checkbox" name="TID[]" value="NA"><label>NA</label>
                                <input type="checkbox" name="TID[]" value="Yes"><label>Yes</label>
                                <input type="checkbox" name="TID[]" value="No"><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="text" name="TID_Amt" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="TID_Remark" placeholder="Enter remarks">
                            </div>
                        </div>

                        <div class="clformbox">
                            <div class="formlabel">
                                <label style="width:100%;"><b>3. Complete pending task</b></label><br>
                                <input type="checkbox" name="APTC[]" value="NA"><label>NA</label>
                                <input type="checkbox" name="APTC[]" value="Yes"><label>Yes</label>
                                <input type="checkbox" name="APTC[]" value="No"><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="text" name="APTC_Amt" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="APTC_Remark" placeholder="Enter remarks">
                            </div>
                        </div>

                        <div class="clformbox">
                            <div class="formlabel">
                                <label style="width:100%;"><b>4. Handover of Health Card</b></label><br>
                                <input type="checkbox" name="HOAS[]" value="NA"><label>NA</label>
                                <input type="checkbox" name="HOAS[]" value="Yes"><label>Yes</label>
                                <input type="checkbox" name="HOAS[]" value="No"><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="text" name="HOAS_Amt" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="HOAS_Remark" placeholder="Enter remarks">
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

<div class="modal fade show" id="clearnsdetailsLOGISTIC" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (Logistic)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span class="emp-name"></span></b></li>
                            <li> <b> Designation: <span class="designation"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span class="emp-code"></span></b></li>
                            <li> <b> Department: <span class="department"></span></b></li>
                        </ul>
                    </div>
                </div>
                               
                <form id="logisticsnocform">
                    @csrf
                    <input type="hidden" name="EmpSepId">

                <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Handover of Data Documents etc</b></label><br>
                            <input type="checkbox" name="DDH[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="DDH[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="DDH[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="DDH_Amt" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="DDH_Remark" placeholder="Enter remarks">
                        </div>
                        </div>

                        <div class="clformbox">
                            <div class="formlabel">
                                <label style="width:100%;"><b>2. Handover of ID Card</b></label><br>
                                <input type="checkbox" name="TID[]" value="NA"><label>NA</label>
                                <input type="checkbox" name="TID[]" value="Yes"><label>Yes</label>
                                <input type="checkbox" name="TID[]" value="No"><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="text" name="TID_Amt" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="TID_Remark" placeholder="Enter remarks">
                            </div>
                        </div>

                        <div class="clformbox">
                            <div class="formlabel">
                                <label style="width:100%;"><b>3. Complete pending task</b></label><br>
                                <input type="checkbox" name="APTC[]" value="NA"><label>NA</label>
                                <input type="checkbox" name="APTC[]" value="Yes"><label>Yes</label>
                                <input type="checkbox" name="APTC[]" value="No"><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="text" name="APTC_Amt" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="APTC_Remark" placeholder="Enter remarks">
                            </div>
                        </div>

                        <div class="clformbox">
                            <div class="formlabel">
                                <label style="width:100%;"><b>4. Handover of Health Card</b></label><br>
                                <input type="checkbox" name="HOAS[]" value="NA"><label>NA</label>
                                <input type="checkbox" name="HOAS[]" value="Yes"><label>Yes</label>
                                <input type="checkbox" name="HOAS[]" value="No"><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="text" name="HOAS_Amt" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="HOAS_Remark" placeholder="Enter remarks">
                            </div>
                        </div>
                        <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
                        Parties Clearance 
                        <a class="effect-btn btn btn-success squer-btn sm-btn" id="add-more">
                            Add <i class="fas fa-plus mr-2"></i>
                        </a>
                    <div id="parties-container">
                        <!-- Dynamically generated party sections will appear here -->
                    </div>


                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="otherremark" placeholder="if any remarks enter here">
                        </div>
                    </div>
                
                </form>
            </div>
            <div class="modal-footer">
                                <button class="btn btn-primary" type="button" id="save-draft-btn-log">Save as Draft</button>
                                <button class="btn btn-success" type="button" id="final-submit-btn-log">Final Submit</button>
                            </div>
            
        </div>
    </div>
</div>
    

<div class="modal fade show" id="clearnsdetailsIT" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (IT)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span class="emp-name"></span></b></li>
                            <li> <b> Designation: <span class="designation"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span class="emp-code"></span></b></li>
                            <li> <b> Department: <span class="department"></span></b></li>
                        </ul>
                    </div>
                </div>

                
                       
                <form id="itnocform">
                                    @csrf
                                    <input type="hidden" name="EmpSepId">
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Sim Submitted</b></label><br>
                            <input type="checkbox" name="sim_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="sim_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="sim_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="sim_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="sim_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>2. Company Handset Submitted</b></label><br>
                            <input type="checkbox" name="handset_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="handset_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="handset_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="handset_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="handset_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>3. Laptop / Desktop Handover</b></label><br>
                            <input type="checkbox" name="laptop_handover[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="laptop_handover[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="laptop_handover[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="laptop_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="laptop_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>4. Camera Submitted</b></label><br>
                            <input type="checkbox" name="camera_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="camera_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="camera_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="camera_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="camera_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>5. Datacard Submitted</b></label><br>
                            <input type="checkbox" name="datacard_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="datacard_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="datacard_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="datacard_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="datacard_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">ID's Password</h5>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>6. Email Account Blocked</b></label><br>
                            <input type="checkbox" name="email_blocked[]"  value="NA"><label>NA</label>
                            <input type="checkbox" name="email_blocked[]"  value="Yes"><label>Yes</label>
                            <input type="checkbox" name="email_blocked[]"  value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="email_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="email_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>7. Mobile No. Disabled/Transferred</b></label><br>
                            <input type="checkbox" name="mobile_disabled[]"  value="NA"><label>NA</label>
                            <input type="checkbox" name="mobile_disabled[]"  value="Yes"><label>Yes</label>
                            <input type="checkbox" name="mobile_disabled[]"  value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="mobile_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="mobile_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="any_remarks" placeholder="If any remarks enter here">
                        </div>
                    </div>
                </form>

            </div>
            <!-- Submit buttons -->
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id="save-draft-btn-it">Save as Draft</button>
                <button class="btn btn-success" type="button" id="final-submit-btn-it">Final Submit</button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade show" id="clearnsdetailsAccount" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (Account)</h5>
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

                
                               
                <form>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>1. Expences Claim Pending</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>2. Investment Proofs Submited</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                        
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>3. Advance Amount Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>4. Salary Advance Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>5. White Goods Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                  
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>6. Service Bond</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>7. TDS Adjustments</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>8. Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <input style="width:100%;" class="form-control mb-2" type="text"  placeholder="Enter your parties name"><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <a class="effect-btn btn btn-success squer-btn sm-btn">Add <i class="fas fa-plus mr-2"></i></a>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="" placeholder="if any remarks enter here">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-success" type="submit">Final Submit</button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade show" id="clearnsdetailsHR" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (HR)</h5>
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

                <form>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Block ESS Passward</b></label><br>
                            <input type="checkbox" name="block_ess_passward[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="block_ess_passward[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="block_ess_passward[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="block_ess_passward_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="block_ess_passward_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>2. Block Paypac Passward</b></label><br>
                            <input type="checkbox" name="block_paypac_passward[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="block_paypac_passward[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="block_paypac_passward[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="block_paypac_passward_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="block_paypac_passward_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>3. Block Expro Passward</b></label><br>
                            <input type="checkbox" name="block_expro_passward[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="block_expro_passward[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="block_expro_passward[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="block_expro_passward_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="block_expro_passward_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>4. ID Card Submitted</b></label><br>
                            <input type="checkbox" name="id_card_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="id_card_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="id_card_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="id_card_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="id_card_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>5. Visiting Card Submitted</b></label><br>
                            <input type="checkbox" name="visiting_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="visiting_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="visiting_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="visiting_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="visiting_remarks" placeholder="Enter remarks">
                        </div>
                    </div> 

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>5. Company Vehicle Return</b></label><br>
                            <input type="checkbox" name="company_vehicle_return[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="company_vehicle_return[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="company_vehicle_return[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="datacard_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="datacard_remarks" placeholder="Enter remarks">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-7 mb-2"><label class=""><b>Worked Days Without Notice Period</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                                <div class="col-md-7 mb-2"><label class=""><b>Served Notice Period (Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                                <div class="col-md-7 mb-2"><label class=""><b>Available EL(Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                                <div class="col-md-7 mb-2"><label class=""><b>Total Number of Worked(Salaried Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                            </div>
                           
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-7 mb-2"><label class=""><b>Actual Notice Period(Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                                <div class="col-md-7 mb-2"><label class=""><b>Recoverable Notice Period (Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                                <div class="col-md-7 mb-2"><label class=""><b>Encashable EL(Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                                <div class="col-md-7 mb-2"><label class=""><b>Partially Amount Paid</b></label></div>
                                <div class="col-md-5 mb-2"><input class=" form-control" type="text" name="" placeholder="Enter"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5>Earnings(Rs.)</h5>
                        </div>
                        <div class="row card-body table-responsive">
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>Basic</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>HRA</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>Car Allowance</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>Bonus</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>Special Allow</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>LTA</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>Medical Allow.</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstNameinput" class="form-label"><b>Child Edu. Allow.</b></label>
                        <div class="row">
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                            </div>
                            <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                                                    <div class="card-header">
                                                    <h5>Deduction Amount(Rs.)</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>PF Amount</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>ESIC</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>Arrear For Esic</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>Recovery Towards Service Bond</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>Notice Period Recovery</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>Notice Period Amount</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>Voluntary Contribution</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>ReLocation Allowance</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>NRS Deduction</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                next feild in pendding
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>Total Deduction</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label for="firstNameinput" class="form-label"><b>HR Remarks</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                            </div>
                                            </div></div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="" placeholder="if any remarks enter here">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-success" type="submit">Final Submit</button>
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
                } else {
                    $('input[name="DDH[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="DDH_Amt"]').val(nocData.DDH_Amt);
                $('input[name="DDH_Remark"]').val(nocData.DDH_Remark);

                // 2. Handover of ID Card (TID)
                if (nocData.TID === 'Y') {
                    $('input[name="TID[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.TID === 'N') {
                    $('input[name="TID[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="TID[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="TID_Amt"]').val(nocData.TID_Amt);
                $('input[name="TID_Remark"]').val(nocData.TID_Remark);

                // 3. Complete pending task (APTC)
                if (nocData.APTC === 'Y') {
                    $('input[name="APTC[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.APTC === 'N') {
                    $('input[name="APTC[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="APTC[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="APTC_Amt"]').val(nocData.APTC_Amt);
                $('input[name="APTC_Remark"]').val(nocData.APTC_Remark);

                // 4. Handover of Health Card (HOAS)
                if (nocData.HOAS === 'Y') {
                    $('input[name="HOAS[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.HOAS === 'N') {
                    $('input[name="HOAS[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="HOAS[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="HOAS_Amt"]').val(nocData.HOAS_Amt);
                $('input[name="HOAS_Remark"]').val(nocData.HOAS_Remark);

                // Check if the final status is 'Y'
                if (nocData.final_submit_dep === 'Y') {
                    // Disable all form fields if the status is 'Y'
                    $('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
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
        if (data.success) {
            alert("Form submitted successfully");
            // Optionally reset the form or redirect the user
            form.reset();
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the form.');
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
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('logisticsnocform');
    const saveDraftButton = document.getElementById('save-draft-btn-log');
    const submitButton = document.getElementById('final-submit-btn-log');
    const partiesContainer = document.getElementById('parties-container');
    let partyCount = 1;

    // Function to handle form submission
    function handleFormSubmission(buttonId, event) {
        event.preventDefault();

        const formData = new FormData(form);
        const formId = form.id;
        formData.append('form_id', formId);
        formData.append('button_id', buttonId);

        // Send form data to the Laravel controller using fetch
        fetch("{{ route('submit.noc.clearance') }}", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Form submitted successfully");
                form.reset(); // Reset form after submission
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the form.');
        });
    }

    // Event listener for "Save as Draft" button
    saveDraftButton.addEventListener('click', function(event) {
        handleFormSubmission('save-draft-btn-log', event); // Pass 'save-draft-btn' as the button ID
    });

    // Event listener for "Final Submit" button
    submitButton.addEventListener('click', function(event) {
        handleFormSubmission('final-submit-btn-log', event); // Pass 'final-submit-btn' as the button ID
    });

    // Function to add more dynamic party fields
    document.getElementById('add-more').addEventListener('click', function() {
        const partyHTML = `
        <div class="clformbox" id="party-${partyCount}">
            <div class="formlabel">
                <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyCount}" placeholder="Enter your party name"><br>
                <input type="checkbox" name="Parties_${partyCount}_docdata" value="NA"><label>NA</label>
                <input type="checkbox" name="Parties_${partyCount}_docdata" value="Yes"><label>Yes</label>
                <input type="checkbox" name="Parties_${partyCount}_docdata" value="No"><label>No</label>
            </div>
            <div class="clrecoveramt">
                <input class="form-control" type="number" name="Parties_${partyCount}_Amt" placeholder="Enter recovery amount">
            </div>
            <div class="clreremarksbox">
                <input class="form-control" type="text" name="Parties_${partyCount}_Remark" placeholder="Enter remarks">
            </div>
        </div>
    `;

        partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
        partyCount++;
    });

    // Show the modal and populate it with the relevant data
    $('#clearnsdetailsLOGISTIC').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var empSepId = button.data('emp-sepid');
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
                    var nocData = response.data;
                    console.log(nocData);  // Log the data to verify it contains party info

                    // Update the modal with employee info
                    var modal = $(this);
                    modal.find('.emp-name').text(nocData.empName);
                    modal.find('.designation').text(nocData.designation);
                    modal.find('.emp-code').text(nocData.empCode);
                    modal.find('.department').text(nocData.department);
                    modal.find('input[name="EmpSepId"]').val(empSepId);

                    // Populate Handover of Data Documents etc (DDH)
                    if (nocData.DDH === 'Y') {
                        $('input[name="DDH[]"][value="Yes"]').prop('checked', true);
                    } else if (nocData.DDH === 'N') {
                        $('input[name="DDH[]"][value="No"]').prop('checked', true);
                    } else {
                        $('input[name="DDH[]"][value="NA"]').prop('checked', true);
                    }
                    $('input[name="DDH_Amt"]').val(nocData.DDH_Amt);
                    $('input[name="DDH_Remark"]').val(nocData.DDH_Remark);

                    // Repeat the same for other fields (TID, APTC, HOAS) ...

                    // Populate party fields dynamically
                    let partyIndex = 1;
                    while (nocData[`Prtis${partyIndex}`]) {
                        // Dynamically populate party fields
                        const partyHTML = `
                        <div class="clformbox" id="party-${partyIndex}">
                            <div class="formlabel">
                                <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyIndex}" value="${nocData[`Prtis${partyIndex}`]}" placeholder="Enter your party name"><br>
                                <input type="checkbox" name="Parties_${partyIndex}_docdata" value="NA" ${nocData[`Prtis_${partyIndex}`] === 'NA' ? 'checked' : ''}><label>NA</label>
                                <input type="checkbox" name="Parties_${partyIndex}_docdata" value="Yes" ${nocData[`Prtis_${partyIndex}`] === 'Y' ? 'checked' : ''}><label>Yes</label>
                                <input type="checkbox" name="Parties_${partyIndex}_docdata" value="No" ${nocData[`Prtis_${partyIndex}`] === 'N' ? 'checked' : ''}><label>No</label>
                            </div>
                            <div class="clrecoveramt">
                                <input class="form-control" type="number" name="Parties_${partyIndex}_Amt" value="${nocData[`Prtis_${partyIndex}Amt`] || ''}" placeholder="Enter recovery amount">
                            </div>
                            <div class="clreremarksbox">
                                <input class="form-control" type="text" name="Parties_${partyIndex}_Remark" value="${nocData[`Prtis_${partyIndex}Remark`] || ''}" placeholder="Enter remarks">
                            </div>
                        </div>
                        `;
                        partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
                        partyIndex++;
                    }
                    // Check if the final status is 'Y'
                if (nocData.final_submit_log === 'Y') {
                    // Disable all form fields if the status is 'Y'
                    $('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                }
                }
            },
            error: function() {
                alert('Error fetching NOC data.');
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('itnocform');
    const saveDraftButton = document.getElementById('save-draft-btn-it');
    const submitButton = document.getElementById('final-submit-btn-it');
    const partiesContainer = document.getElementById('it-parties-container');
    let partyCount = 1;

    // Function to handle form submission
    function handleFormSubmission(buttonId, event) {
        event.preventDefault();

        const formData = new FormData(form);
        formData.append('button_id', buttonId); // Add button id to track submission type

        // Send form data to the Laravel controller using fetch
        fetch("{{ route('submit.noc.clearance.it') }}", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Form submitted successfully");
                form.reset(); // Reset form after submission
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the form.');
        });
    }

    // Event listener for "Save as Draft" button
    saveDraftButton.addEventListener('click', function(event) {
        handleFormSubmission('save-draft-btn-it', event); // Pass 'save-draft-btn' as the button ID
    });

    // Event listener for "Final Submit" button
    submitButton.addEventListener('click', function(event) {
        handleFormSubmission('final-submit-btn-it', event); // Pass 'final-submit-btn' as the button ID
    });

    $('#clearnsdetailsIT').on('show.bs.modal', function (event) {
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
        url: '/get-noc-data-it/' + empSepId,  // Endpoint to get the NOC data
        method: 'GET',
        success: function(response) {
            if (response.success) {
                var nocData = response.data; // Data returned from backend

                // Populate the modal fields with fetched data

                // Set Employee Info
                $('.emp-name').text(nocData.emp_name);
                $('.designation').text(nocData.designation);
                $('.emp-code').text(nocData.emp_code);
                $('.department').text(nocData.department);

                // Set NOC form values for the checkboxes and recovery amounts
                populateFormFields(nocData);

                // Show the modal
                $('#clearnsdetailsIT').modal('show');
            } else {
                alert('No data found for this employee.');
            }
        },
        error: function() {
            alert('Error fetching NOC data.');
        }
    });

    // Function to populate the form fields in the modal
    function populateFormFields(nocData) {
        console.log(nocData);
        // 1. Sim Submitted
        if (nocData.ItSS === 'Y') {
            $('input[name="sim_submitted[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItSS === 'N') {
            $('input[name="sim_submitted[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="sim_submitted[]"][value="NA"]').prop('checked', true);
        }
        $('input[name="sim_recovery_amount"]').val(nocData.ItSS_Amt);
        $('input[name="sim_remarks"]').val(nocData.ItSS_Remark);

        // 2. Company Handset Submitted
        if (nocData.ItCHS === 'Y') {
            $('input[name="handset_submitted[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItCHS === 'N') {
            $('input[name="handset_submitted[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="handset_submitted[]"][value="NA"]').prop('checked', true);
        }
        $('input[name="handset_recovery_amount"]').val(nocData.ItCHS_Amt);
        $('input[name="handset_remarks"]').val(nocData.ItCHS_Remark);

        // 3. Laptop / Desktop Handover
        if (nocData.ItLDH === 'Y') {
            $('input[name="laptop_handover[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItLDH === 'N') {
            $('input[name="laptop_handover[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="laptop_handover[]"][value="NA"]').prop('checked', true);
        }
        $('input[name="laptop_recovery_amount"]').val(nocData.ItLDH_Amt);
        $('input[name="laptop_remarks"]').val(nocData.ItLDH_Remark);

        // 4. Camera Submitted
        if (nocData.ItCS === 'Y') {
            $('input[name="camera_submitted[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItCS === 'N') {
            $('input[name="camera_submitted[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="camera_submitted[]"][value="NA"]').prop('checked', true);
        }
        $('input[name="camera_recovery_amount"]').val(nocData.ItCS_Amt);
        $('input[name="camera_remarks"]').val(nocData.ItCS_Remark);

        // 5. Datacard Submitted
        if (nocData.ItDC === 'Y') {
            $('input[name="datacard_submitted[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItDC === 'N') {
            $('input[name="datacard_submitted[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="datacard_submitted[]"][value="NA"]').prop('checked', true);
        }
        $('input[name="datacard_recovery_amount"]').val(nocData.ItDC_Amt);
        $('input[name="datacard_remarks"]').val(nocData.ItDC_Remark);

        // 6. Email Account Blocked
        if (nocData.ItEAB === 'Y') {
            $('input[name="email_blocked[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItEAB === 'N') {
            $('input[name="email_blocked[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="email_blocked[]"][value="NA"]').prop('checked', true);
        }
        $('input[name="email_recovery_amount"]').val(nocData.ItEAB_Amt);
        $('input[name="email_remarks"]').val(nocData.ItEAB_Remark);

        // 7. Mobile No. Disabled/Transferred
        if (nocData.ItMND === "Y") {
        $('input[name="mobile_disabled[]"][value="Yes"]').prop('checked', true);
        } else if (nocData.ItMND === "N") {
            $('input[name="mobile_disabled[]"][value="No"]').prop('checked', true);
        } else {
            $('input[name="mobile_disabled[]"][value="NA"]').prop('checked', true); // Default to NA if no value
        }
        $('input[name="mobile_recovery_amount"]').val(nocData.ItMND_Amt);
        $('input[name="mobile_remarks"]').val(nocData.ItMND_Remark);

        // 8. Any remarks
        $('input[name="any_remarks"]').val(nocData.ItOth_Remark);

        // Handle final submit or draft submit
        if (nocData.final_submit_it === 'Y') {
            $('#save-draft-btn-it').prop('disabled', true);  // Disable Save Draft button
            $('#final-submit-btn-it').prop('disabled', true);  // Disable Final Submit button
        }
    }




});


});


</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>