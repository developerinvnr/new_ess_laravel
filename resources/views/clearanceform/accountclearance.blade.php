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
                                    <li class="breadcrumb-link active">My Team - Clearance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Revanue Status Start -->
              

                <div class="row">
                    <div class="mfh-machine-profile">
                        <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link active" id="Hr_tab"
                                    data-bs-toggle="tab" href="#HRTab" role="tab"
                                    aria-controls="HRTab" aria-selected="false">HR Clearance Form</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link " id="logistic_tab"
                                    data-bs-toggle="tab" href="#logisticTab" role="tab"
                                    aria-controls="logisticTab" aria-selected="false">Logistic Clearance Form</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link " id="it_tab"
                                    data-bs-toggle="tab" href="#ITTab" role="tab"
                                    aria-controls="ITTab" aria-selected="false">IT Clearance Form</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link " id="account_tab"
                                    data-bs-toggle="tab" href="#accountTab" role="tab"
                                    aria-controls="accountTab" aria-selected="false">Account Clearance Form</a>
                            </li>
                        </ul>
                        <div class="tab-content ad-content2" id="myTabContent2">
                            <div class="tab-pane fade show active" id="HRTab" role="tabpanel">
                            <div class="card">
                    <div class="card-header">
                        <h5><b>Departmental NOC Clearance Form (HR)</b></h5>
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
                                                             
                                                                            @if($data->EmpSepId && \DB::table('hrm_employee_separation_nochr')->where('EmpSepId', $data->EmpSepId)->exists())
                                                                                <span class="text-success">Actioned</span>

                                                                            @else
                                                                                <span class="text-warning">Pending</span>

                                                                            @endif
                                                            </td>
                                                            <td>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsHR"
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
                            <div class="tab-pane fade show" id="logisticTab" role="tabpanel">
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
                                                        <th>Resignation Approved(Repo.)</th>
                                                        <th>Resignation Approved(HR.)</th>
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
                                                            <span>{{ $data->HR_Approved == 'Y' ? 'Approved' : 'Rejected' }}</span>

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
                            <div class="tab-pane fade " id="ITTab" role="tabpanel">
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

                                                                                    <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td>
                                                                                    <!-- Employee Name -->
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
                            <div class="tab-pane fade " id="accountTab" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><b>Account NOC Clearance Form</b></h5>
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

                                                                                    <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td>
                                                                                    <!-- Employee Name -->
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
                                                                                        @if($data->EmpSepId && \DB::table('hrm_employee_separation_nocacc')->where('EmpSepId', $data->EmpSepId)->exists())
                                                                                            <span class="text-success">Actioned</span>

                                                                                        @else
                                                                                            <span class="text-warning">Pending</span>

                                                                                        @endif
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsAcct"
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
                    </div>
                </div>
				@include('employee.footerbottom')
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

                <form id="hrnocfrom" method="POST">
                     @csrf
                     <input type="hidden" name="EmpSepId">

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

                    <!-- <div class="clformbox">
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
                    </div> -->

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
                            <input class="form-control" type="text" name="company_vehcile_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="company_vehcile_remarks" placeholder="Enter remarks">
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-7 mb-2"><label><b>Worked Days Without Notice Period</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="worked_days_without_notice" placeholder="Enter"></div>

                                <div class="col-md-7 mb-2"><label><b>Served Notice Period (Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="served_notice_period" placeholder="Enter"></div>

                                <div class="col-md-7 mb-2"><label><b>Available EL(Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="available_el_days" placeholder="Enter"></div>

                                <div class="col-md-7 mb-2"><label><b>Total Number of Worked(Salaried Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="total_worked_days" placeholder="Enter"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-7 mb-2"><label><b>Actual Notice Period(Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="actual_notice_period" placeholder="Enter"></div>

                                <div class="col-md-7 mb-2"><label><b>Recoverable Notice Period (Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="recoverable_notice_period" placeholder="Enter"></div>

                                <div class="col-md-7 mb-2"><label><b>Encashable EL(Days)</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="encashable_el_days" placeholder="Enter"></div>

                                <div class="col-md-7 mb-2"><label><b>Partially Amount Paid</b></label></div>
                                <div class="col-md-5 mb-2"><input class="form-control" type="text" name="partially_amount_paid" placeholder="Enter"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Earnings(Rs.)</h5>
                        </div>
                        <div class="row card-body table-responsive">
                            <div class="col-md-6 mb-3">
                                <label for="basicRate" class="form-label"><b>Basic</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="basicRate" name="basic_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="basicAmount" name="basic_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="hraRate" class="form-label"><b>HRA</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="hraRate" name="hra_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="hraAmount" name="hra_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="carAllowanceRate" class="form-label"><b>Car Allowance</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="carAllowanceRate" name="car_allowance_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="carAllowanceAmount" name="car_allowance_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="bonusRate" class="form-label"><b>Bonus</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="bonusRate" name="bonus_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="bonusAmount" name="bonus_amount">
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-md-6 mb-3">
                                <label for="specialAllowRate" class="form-label"><b>Special Allow</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="specialAllowRate" name="special_allow_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="specialAllowAmount" name="special_allow_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="ltaRate" class="form-label"><b>LTA</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="ltaRate" name="lta_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="ltaAmount" name="lta_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="medicalAllowRate" class="form-label"><b>Medical Allow.</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="medicalAllowRate" name="medical_allow_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="medicalAllowAmount" name="medical_allow_amount">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="childEduAllowRate" class="form-label"><b>Child Edu. Allow.</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your rate" id="childEduAllowRate" name="child_edu_allow_rate">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" class="form-control" placeholder="Enter your amount" id="childEduAllowAmount" name="child_edu_allow_amount">
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5>Deduction Amount(Rs.)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="pfAmount" class="form-label"><b>PF Amount</b></label>
                                    <input type="text" class="form-control" placeholder="Enter PF Amount" id="pfAmount" name="pf_amount">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="esic" class="form-label"><b>ESIC</b></label>
                                    <input type="text" class="form-control" placeholder="Enter ESIC Amount" id="esic" name="esic">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="arrearEsic" class="form-label"><b>Arrear For Esic</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Arrear For ESIC" id="arrearEsic" name="arrear_esic">
                                </div>

                                <!-- <div class="mb-3 col-md-6">
                                    <label for="serviceBondRecovery" class="form-label"><b>Recovery Towards Service Bond</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Recovery Towards Service Bond" id="serviceBondRecovery" name="service_bond_recovery">
                                </div> -->

                                <div class="mb-3 col-md-6">
                                    <label for="noticePeriodRecovery" class="form-label"><b>Notice Period Recovery</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Notice Period Recovery" id="noticePeriodRecovery" name="notice_period_recovery">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="noticePeriodAmount" class="form-label"><b>Notice Period Amount</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Notice Period Amount" id="noticePeriodAmount" name="notice_period_amount">
                                </div>

                                <!-- <div class="mb-3 col-md-6">
                                    <label for="voluntaryContribution" class="form-label"><b>Voluntary Contribution</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Voluntary Contribution" id="voluntaryContribution" name="voluntary_contribution">
                                </div> -->

                                <div class="mb-3 col-md-6">
                                    <label for="relocationAllowance" class="form-label"><b>ReLocation Allowance</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Relocation Allowance" id="relocationAllowance" name="relocation_allowance">
                                </div>

                                <!-- <div class="mb-3 col-md-6">
                                    <label for="nrsDeduction" class="form-label"><b>NRS Deduction</b></label>
                                    <input type="text" class="form-control" placeholder="Enter NRS Deduction" id="nrsDeduction" name="nrs_deduction">
                                </div> -->

                                <div class="mb-3 col-md-6">
                                    <label for="totalDeduction" class="form-label"><b>Total Deduction</b></label>
                                    <input type="text" class="form-control" placeholder="Enter Total Deduction" id="totalDeduction" name="total_deduction">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="hrRemarks" class="form-label"><b>HR Remarks</b></label>
                                    <input type="text" class="form-control" placeholder="Enter HR Remarks" id="hrRemarks" name="hr_remarks">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="otheremark" placeholder="if any remarks enter here">
                        </div>
                    </div> -->
                </form>
            </div>
           
            <div class="modal-footer">
                                <button class="btn btn-primary" type="button" id="save-draft-btn-hr">Save as Draft</button>
                                <button class="btn btn-success" type="button" id="final-submit-btn-hr">Final Submit</button>
                            </div>
            
        </div>
    </div>
            </div>
            <div class="modal fade show" id="clearnsdetailsIT" tabindex="-1"
                                aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form
                                                (IT)</h5>
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
                                                        <input class="form-control" type="number" name="sim_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="sim_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>2. Company Handset Submitted</b></label><br>
                                                        <input type="checkbox" name="handset_submitted[]"
                                                            value="NA"><label>NA</label>
                                                        <input type="checkbox" name="handset_submitted[]"
                                                            value="Yes"><label>Yes</label>
                                                        <input type="checkbox" name="handset_submitted[]"
                                                            value="No"><label>No</label>
                                                    </div>
                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="number" name="handset_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="handset_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>3. Laptop / Desktop Handover</b></label><br>
                                                        <input type="checkbox" name="laptop_handover[]" value="NA"><label>NA</label>
                                                        <input type="checkbox" name="laptop_handover[]"
                                                            value="Yes"><label>Yes</label>
                                                        <input type="checkbox" name="laptop_handover[]" value="No"><label>No</label>
                                                    </div>
                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="number" name="laptop_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="laptop_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>4. Camera Submitted</b></label><br>
                                                        <input type="checkbox" name="camera_submitted[]"
                                                            value="NA"><label>NA</label>
                                                        <input type="checkbox" name="camera_submitted[]"
                                                            value="Yes"><label>Yes</label>
                                                        <input type="checkbox" name="camera_submitted[]"
                                                            value="No"><label>No</label>
                                                    </div>
                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="number" name="camera_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="camera_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>5. Datacard Submitted</b></label><br>
                                                        <input type="checkbox" name="datacard_submitted[]"
                                                            value="NA"><label>NA</label>
                                                        <input type="checkbox" name="datacard_submitted[]"
                                                            value="Yes"><label>Yes</label>
                                                        <input type="checkbox" name="datacard_submitted[]"
                                                            value="No"><label>No</label>
                                                    </div>
                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="number" name="datacard_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="datacard_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">ID's Password</h5>
                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>6. Email Account Blocked</b></label><br>
                                                        <input type="checkbox" name="email_blocked[]" value="NA"><label>NA</label>
                                                        <input type="checkbox" name="email_blocked[]" value="Yes"><label>Yes</label>
                                                        <input type="checkbox" name="email_blocked[]" value="No"><label>No</label>
                                                    </div>
                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="number" name="email_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="email_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>7. Mobile No.
                                                                Disabled/Transferred</b></label><br>
                                                        <input type="checkbox" name="mobile_disabled[]" value="NA"><label>NA</label>
                                                        <input type="checkbox" name="mobile_disabled[]"
                                                            value="Yes"><label>Yes</label>
                                                        <input type="checkbox" name="mobile_disabled[]" value="No"><label>No</label>
                                                    </div>
                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="number" name="mobile_recovery_amount"
                                                            placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="mobile_remarks"
                                                            placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>Any remarks</b></label>
                                                    </div>
                                                    <div>
                                                        <input class="form-control" type="text" name="any_remarks"
                                                            placeholder="If any remarks enter here">
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <!-- Submit buttons -->
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="button" id="save-draft-btn-it">Save as
                                                Draft</button>
                                            <button class="btn btn-success" type="button" id="final-submit-btn-it">Final
                                                Submit</button>
                                        </div>

                                    </div>
                                </div>
            </div>
            <div class="modal fade show" id="clearnsdetailsAcct" tabindex="-1"
                                aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form
                                                (IT)</h5>
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


                                            <form id="acctnocform" method="POST">
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
                                        <!-- Submit buttons -->
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" type="button" id="save-draft-btn-acct">Save as
                                                Draft</button>
                                            <button class="btn btn-success" type="button" id="final-submit-btn-acct">Final
                                                Submit</button>
                                        </div>

                                    </div>
                                </div>
            </div>
@include('employee.footer');
<script>
// LOGISTICES START 
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
            if (data.success) {  // Use 'data' instead of 'response'
                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        $('#assetRequestForm')[0].reset();  // Reset the form
                                        location.reload();  // Optionally, reload the page
                                    }, 3000); // Delay before reset and reload to match the toast timeout

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                }
        })
        .catch(error => {
      // Handle errors from the fetch request itself
      toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
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
    // Create the HTML for the new party section
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
            <button type="button" class="btn btn-danger remove-party" style="margin:10px;" data-party-id="party-${partyCount}">-</button>
        </div>
    `;

    // Insert the new party HTML into the container
    const partiesContainer = document.getElementById('parties-container');
    partiesContainer.insertAdjacentHTML('beforeend', partyHTML);

    // Increment party count
    partyCount++;
});

// Event delegation for remove buttons
document.getElementById('parties-container').addEventListener('click', function(event) {
    // Check if the clicked element is a remove button
    if (event.target && event.target.classList.contains('remove-party')) {
        const partyId = event.target.getAttribute('data-party-id');
        const partyElement = document.getElementById(partyId);
        
        // Remove the party section from the DOM
        if (partyElement) {
            partyElement.remove();
        }
    }
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
                $('input[name="otherremark"]').val(nocData.Oth_Remark);

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
                
                }
            },
            error: function() {
                alert('Error fetching NOC data.');
            }
        });
    });
});

        document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                // Get the name of the group (all checkboxes with the same name)
                const name = this.name;
                
                // Uncheck all checkboxes in the group, except the one that was just clicked
                document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
            });
        });
        // Attach a single event listener to a parent container (in this case, 'parties-container')
        document.getElementById('parties-container').addEventListener('change', function(event) {
            // Check if the clicked element is a checkbox
            if (event.target && event.target.type === 'checkbox') {
                const checkbox = event.target;
                const name = checkbox.name;
                
                // Uncheck all checkboxes in the same group, except the one that was just clicked
                document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false;
                    }
                });
            }
        });
// LOGISTICS END 

//HR STARTS #
$('#clearnsdetailsHR').on('show.bs.modal', function (event) {
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
    url: '/get-noc-data-hr/' + empSepId, // Assuming the endpoint is correct
    method: 'GET',
    success: function(response) {
        if (response.success) {
            var nocData = response.data; // Data returned from backend
            console.log(nocData);

          
            if (nocData.BEP === 'Y') {
                    $('input[name="block_ess_passward[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.BEP === 'N') {
                    $('input[name="block_ess_passward[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="block_ess_passward[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }

            if (nocData.BPP === 'Y') {
                    $('input[name="block_paypac_passward[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.BPP === 'N') {
                    $('input[name="block_paypac_passward[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="block_paypac_passward[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }
            
            if (nocData.BExP === 'Y') {
                    $('input[name="block_expro_passward[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.BExP === 'N') {
                    $('input[name="block_expro_passward[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="block_expro_passward[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }

            // nocData.id_card_submitted.forEach(function(value) {
            //     $('input[name="id_card_submitted[]"][value="' + value + '"]').prop('checked', true);
            // });

            if (nocData.AdminVC === 'Y') {
                    $('input[name="visiting_submitted[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.AdminVC === 'N') {
                    $('input[name="visiting_submitted[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="visiting_submitted[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }
            if (nocData.CV === 'Y') {
                    $('input[name="company_vehicle_return[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.CV === 'N') {
                    $('input[name="company_vehicle_return[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="company_vehicle_return[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }

            
            // Filling text inputs
            $('input[name="block_ess_passward_recovery_amount"]').val(nocData.BEP_Amt);
            $('input[name="block_ess_passward_remarks"]').val(nocData.BEP_Remark);
            
            $('input[name="block_paypac_passward_recovery_amount"]').val(nocData.BPP_Amt);
            $('input[name="block_paypac_passward_remarks"]').val(nocData.BPP_Remark);
            
            $('input[name="block_expro_passward_recovery_amount"]').val(nocData.BExP_Amt);
            $('input[name="block_expro_passward_remarks"]').val(nocData.BExP_Remark);
            
            // $('input[name="id_card_recovery_amount"]').val(nocData.id_card_recovery_amount);
            // $('input[name="id_card_remarks"]').val(nocData.id_card_remarks);

            $('input[name="visiting_recovery_amount"]').val(nocData.AdminVC_Amt);
            $('input[name="visiting_remarks"]').val(nocData.AdminVC_Remark);
            
            $('input[name="company_vehcile_recovery_amount"]').val(nocData.CV_Amt);
            $('input[name="company_vehcile_remarks"]').val(nocData.CV_Remark);

            // Filling other fields as well (add all the necessary fields like the worked days, notice period, and earnings)
            $('input[name="worked_days_without_notice"]').val(nocData.WorkDay);
            $('input[name="served_notice_period"]').val(nocData.NoticeDay);
            $('input[name="available_el_days"]').val(nocData.EnCashEL);
            $('input[name="total_worked_days"]').val(nocData.TotWorkDay);
            $('input[name="actual_notice_period"]').val(nocData.ServedDay);
            $('input[name="recoverable_notice_period"]').val(nocData.RecoveryDay);
            $('input[name="encashable_el_days"]').val(nocData.TotEL);
            $('input[name="partially_amount_paid"]').val(nocData.partially_amount_paid);

            // Earnings section
            $('input[name="basic_rate"]').val(nocData.Basic);
            $('input[name="basic_amount"]').val(nocData.Basic);
            
            $('input[name="hra_rate"]').val(nocData.HRA);
            $('input[name="hra_amount"]').val(nocData.HRA);
            
            $('input[name="car_allowance_rate"]').val(nocData.CarAllow);
            $('input[name="car_allowance_amount"]').val(nocData.CarAllow);
            
            $('input[name="bonus_rate"]').val(nocData.Bonus);
            $('input[name="bonus_amount"]').val(nocData.Bonus);
            
            $('input[name="special_allow_rate"]').val(nocData.special_allow_rate);
            $('input[name="special_allow_amount"]').val(nocData.special_allow_amount);

            $('input[name="lta_rate"]').val(nocData.lta_rate);
            $('input[name="lta_amount"]').val(nocData.lta_amount);
            
            $('input[name="medical_allow_rate"]').val(nocData.Mediclaim);
            $('input[name="medical_allow_amount"]').val(nocData.Mediclaim);
            
            $('input[name="child_edu_allow_rate"]').val(nocData.child_edu_allow_rate);
            $('input[name="child_edu_allow_amount"]').val(nocData.child_edu_allow_amount);

            // Deduction section
            $('input[name="pf_amount"]').val(nocData.PF);
            $('input[name="esic"]').val(nocData.ESIC);
            $('input[name="arrear_esic"]').val(nocData.ARR_ESIC);
            $('input[name="service_bond_recovery"]').val(nocData.service_bond_recovery);
            $('input[name="notice_period_recovery"]').val(nocData.NoticePay);
            $('input[name="notice_period_amount"]').val(nocData.NoticePay);
            $('input[name="voluntary_contribution"]').val(nocData.voluntary_contribution);
            $('input[name="relocation_allowance"]').val(nocData.RA_allow);
            $('input[name="nrs_deduction"]').val(nocData.nrs_deduction);
            $('input[name="total_deduction"]').val(nocData.TotDeduct);
            $('input[name="hr_remarks"]').val(nocData.HrRemark);
            if (nocData.final_submit_hr === 'Y') {
                                    $('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Disable Final Submit button
                                }
        }
    },
    error: function() {
        alert('Error fetching NOC data.');
    }
});

});

// Get the form and buttons
const form = document.getElementById('hrnocfrom');
const saveDraftButton = document.getElementById('save-draft-btn-hr');
const submitButton = document.getElementById('final-submit-btn-hr');
// Function to handle form submission
function handleFormSubmission(event, buttonId) {
    // Prevent the form from submitting normally
    event.preventDefault(); 

    // Collect form data
    const formData = new FormData(form);
    const formId = form.id;  // This will be 'departmentnocfrom'
    formData.append('form_id', formId);  // Add the form id to the form data

    // Add the button ID (either 'save-draft-btn' or 'final-submit-btn')
    formData.append('button_id', buttonId);

    // Send data to the controller using fetch
    fetch("{{ route('submit.noc.clearance.hr') }}", {
        method: "POST",  // Use POST method
        body: formData,  // Send form data
    })
    .then(response => response.json())  // Parse the JSON response
    .then(data => {
        // Handle the response here (e.g., show success message)
        if (data.success) {  // Use 'data' instead of 'response'
            // Show a success toast notification with custom settings
            toastr.success(data.message, 'Success', {
                "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
            });

            // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
            setTimeout(function () {
                $('#assetRequestForm')[0].reset();  // Reset the form
                location.reload();  // Optionally, reload the page
            }, 3000); // Delay before reset and reload to match the toast timeout

        } else {
            // Show an error toast notification with custom settings
            toastr.error('Error: ' + data.message, 'Error', {
                "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
            });
        }
    })
    .catch(error => {
        // Handle errors from the fetch request itself
        toastr.error('Error: ' + error.message, 'Error', {
            "positionClass": "toast-top-right",  // Position the toast at the top-right corner
            "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
        });
    });
}

// Event listener for the "Save as Draft" button
saveDraftButton.addEventListener('click', function(event) {
    handleFormSubmission(event, 'save-draft-btn-hr');  // Pass the event and 'save-draft-btn' as the button ID
});

// Event listener for the "Final Submit" button
submitButton.addEventListener('click', function(event) {
    handleFormSubmission(event, 'final-submit-btn-hr');  // Pass the event and 'final-submit-btn' as the button ID
});
//HR END#

// it starts 

document.addEventListener("DOMContentLoaded", function () {
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
                                // Handle the response here (e.g., show success message)
                                if (data.success) {  // Use 'data' instead of 'response'
                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        $('#assetRequestForm')[0].reset();  // Reset the form
                                        location.reload();  // Optionally, reload the page
                                    }, 3000); // Delay before reset and reload to match the toast timeout

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                }
                            })
                            .catch(error => {
                                // Handle errors from the fetch request itself
                                toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
                            });
                            }

                        // Event listener for "Save as Draft" button
                        saveDraftButton.addEventListener('click', function (event) {
                            handleFormSubmission('save-draft-btn-it', event); // Pass 'save-draft-btn' as the button ID
                        });

                        // Event listener for "Final Submit" button
                        submitButton.addEventListener('click', function (event) {
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
                                success: function (response) {
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
                                    }
                                    // } else {
                                    //     alert('No data found for this employee.');
                                    // }
                                },
                                error: function () {
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
                                $('input[name="otherremark"]').val(nocData.Oth_Remark);

                                // 8. Any remarks
                                $('input[name="any_remarks"]').val(nocData.ItOth_Remark);
                               
                            }

                        });


                    });
// it ends


// acct starts 

document.addEventListener("DOMContentLoaded", function () {
                        const form = document.getElementById('acctnocform');
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
                                // Handle the response here (e.g., show success message)
                                if (data.success) {  // Use 'data' instead of 'response'
                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        $('#assetRequestForm')[0].reset();  // Reset the form
                                        location.reload();  // Optionally, reload the page
                                    }, 3000); // Delay before reset and reload to match the toast timeout

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                }
                            })
                            .catch(error => {
                                // Handle errors from the fetch request itself
                                toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
                            });
                            }

                        // Event listener for "Save as Draft" button
                        saveDraftButton.addEventListener('click', function (event) {
                            handleFormSubmission('save-draft-btn-it', event); // Pass 'save-draft-btn' as the button ID
                        });

                        // Event listener for "Final Submit" button
                        submitButton.addEventListener('click', function (event) {
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
                                success: function (response) {
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
                                    }
                                    // } else {
                                    //     alert('No data found for this employee.');
                                    // }
                                },
                                error: function () {
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
                                $('input[name="otherremark"]').val(nocData.Oth_Remark);

                                // 8. Any remarks
                                $('input[name="any_remarks"]').val(nocData.ItOth_Remark);
                               
                            }

                        });


                    });
// acct ends



</script>

