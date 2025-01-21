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
                                    <li class="breadcrumb-link active">Department NOC Form(IT)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><b>IT NOC Clearance Form</b></h5>
                        </div>
                        <div class="card-body table-responsive">
                            <!-- IT Clearance Table -->
                            <table class="table table-bordered">

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
                                                    @foreach($approvedEmployees as $data)

                                                                <tbody>

                                                                    @php
                                                                        $index = 1;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $index++ }}</td>
                                                                        <td>{{ $data->EmpCode }}</td>

                                                                        <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }} </td>
                                                                        <!-- Employee Name -->
                                                                        <td>{{ $data->department_name }}</td> <!-- Employee Name -->
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
                                                                            @php
                                                                                // Fetch the record from the hrm_employee_separation_nocrep table using EmpSepId
                                                                                $nocRecord = \DB::table('hrm_employee_separation_nocit')->where('EmpSepId', $data->EmpSepId)->first();
                                                                                
                                                                            @endphp

                                                                            @if($nocRecord)
                                                                                @if($nocRecord->draft_submit_it === 'Y')
                                                                                    <span class="text-warning">Drafting</span>
                                                                                @elseif($nocRecord->final_submit_it === 'Y')
                                                                                    <span class="text-danger">Submitted</span>
                                                                                @else
                                                                                    <span class="text-warning">Pending</span>
                                                                                @endif
                                                                            @else
                                                                                <span class="text-warning">Pending</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsIT"
                                                                                data-emp-name="{{ $data->Fname }}  {{ $data->Sname }} {{ $data->Lname }}"
                                                                                data-designation="{{ $data->designation_name }}"
                                                                                data-emp-code="{{ $data->EmpCode }}"
                                                                                data-department="{{ $data->department_name }}"
                                                                                data-emp-sepid="{{ $data->EmpSepId }}">
                                                                                form click
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                @endforeach
                            </table>
                            
                                <!-- Pagination Links -->
                                <div style="text-align: center; margin: 20px 0;">
                                    <div style="float: right; display: inline-block; padding: 10px; border-radius: 5px; background-color: #f9f9f9; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        {{ $approvedEmployees->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>


                <div class="modal fade show" id="clearnsdetailsIT" tabindex="-1"
                    aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form
                                    (IT)</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
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



                                <!-- <form id="itnocform">
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
                                </form> -->
                                <!-- <form id="itnocform">
                            @csrf
                            <input type="hidden" name="EmpSepId">
                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>1. Sim Submitted</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="sim_submitted[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="sim_submitted[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="sim_submitted[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="sim_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="sim_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>2. Company Handset Submitted</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="handset_submitted[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="handset_submitted[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="handset_submitted[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="handset_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="handset_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>3. Laptop / Desktop Handover</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="laptop_handover[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="laptop_handover[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="laptop_handover[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="laptop_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="laptop_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>4. Camera Submitted</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="camera_submitted[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="camera_submitted[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="camera_submitted[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="camera_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="camera_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>5. Datacard Submitted</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="datacard_submitted[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="datacard_submitted[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="datacard_submitted[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="datacard_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="datacard_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">ID's Password</h5>
                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>6. Email Account Blocked</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="email_blocked[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="email_blocked[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="email_blocked[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="email_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="email_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: auto; margin-right: 10px;"><b>7. Mobile No. Disabled/Transferred</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="mobile_disabled[]" value="NA"> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="mobile_disabled[]" value="Yes"> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="mobile_disabled[]" value="No"> No
                                        </label>
                                    </div>
                                </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="mobile_recovery_amount" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="mobile_remarks" placeholder="Enter remarks">
                                </div>
                            </div>

                            <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                    <label style="width: 100%;"><b>Any remarks</b></label>
                                </div>
                                <div>
                                    <input class="form-control" type="text" name="any_remarks" placeholder="If any remarks enter here">
                                </div>
                            </div>
                                </form> -->
                                <form id="itnocform">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">
                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>1. Sim Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="sim_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="sim_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="sim_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="sim_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="sim_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>2. Company Handset Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="handset_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="handset_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="handset_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="handset_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="handset_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>3. Laptop / Desktop Handover</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="laptop_handover[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="laptop_handover[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="laptop_handover[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="laptop_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="laptop_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>4. Camera Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="camera_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="camera_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="camera_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="camera_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="camera_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>5. Datacard Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="datacard_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="datacard_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="datacard_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="datacard_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="datacard_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">ID's Password</h5>
                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>6. Email Account Blocked</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="email_blocked[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="email_blocked[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="email_blocked[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="email_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="email_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>7. Mobile No. Disabled/Transferred</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="mobile_disabled[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="mobile_disabled[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="mobile_disabled[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="mobile_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="mobile_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>
                                            <div id="total-amount-it" style="margin:0px 60px 10px 0px; font-weight: bold;float:inline-end;"></div>


                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: 100%;"><b>Any remarks</b></label>
                                                </div>
                                                <div>
                                                    <input class="form-control" type="text" name="any_remarks" placeholder="If any remarks enter here">
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
                @include('employee.footer')

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const form = document.getElementById('itnocform');
                        const saveDraftButton = document.getElementById('save-draft-btn-it');
                        const submitButton = document.getElementById('final-submit-btn-it');
                        const partiesContainer = document.getElementById('it-parties-container');
                        let partyCount = 1;

                        // Function to handle form submission
                        function handleFormSubmission(buttonId, event) {
                            event.preventDefault();
                            $('#loader').show();

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
                                        $('#loader').hide();

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
                                    $('#loader').hide();

                                }
                            })
                            .catch(error => {
                                // Handle errors from the fetch request itself
                                toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
                                $('#loader').hide();

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
                                } 
                                else {
                                    $('input[name="sim_submitted[]"][value="NA"]').prop('checked', true);
                                } 
                               
                                $('input[name="sim_recovery_amount"]').val(nocData.ItSS_Amt);
                                $('input[name="sim_remarks"]').val(nocData.ItSS_Remark);

                                // 2. Company Handset Submitted
                                if (nocData.ItCHS === 'Y') {
                                    $('input[name="handset_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItCHS === 'N') {
                                    $('input[name="handset_submitted[]"][value="No"]').prop('checked', true);
                                } 
                                else  {
                                    $('input[name="handset_submitted[]"][value="NA"]').prop('checked', true);
                                } 
                                
                                $('input[name="handset_recovery_amount"]').val(nocData.ItCHS_Amt);
                                $('input[name="handset_remarks"]').val(nocData.ItCHS_Remark);

                                // 3. Laptop / Desktop Handover
                                if (nocData.ItLDH === 'Y') {
                                    $('input[name="laptop_handover[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItLDH === 'N') {
                                    $('input[name="laptop_handover[]"][value="No"]').prop('checked', true);
                                }
                                else {
                                    $('input[name="laptop_handover[]"][value="NA"]').prop('checked', true);
                                }
                                
                                $('input[name="laptop_recovery_amount"]').val(nocData.ItLDH_Amt);
                                $('input[name="laptop_remarks"]').val(nocData.ItLDH_Remark);

                                // 4. Camera Submitted
                                if (nocData.ItCS === 'Y') {
                                    $('input[name="camera_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItCS === 'N') {
                                    $('input[name="camera_submitted[]"][value="No"]').prop('checked', true);
                                } 
                                else  {
                                    $('input[name="camera_submitted[]"][value="NA"]').prop('checked', true);
                                } 
                                
                                $('input[name="camera_recovery_amount"]').val(nocData.ItCS_Amt);
                                $('input[name="camera_remarks"]').val(nocData.ItCS_Remark);

                                // 5. Datacard Submitted
                                if (nocData.ItDC === 'Y') {
                                    $('input[name="datacard_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItDC === 'N') {
                                    $('input[name="datacard_submitted[]"][value="No"]').prop('checked', true);
                                } 
                                else  {
                                    $('input[name="datacard_submitted[]"][value="NA"]').prop('checked', true);
                                } 
                                
                                $('input[name="datacard_recovery_amount"]').val(nocData.ItDC_Amt);
                                $('input[name="datacard_remarks"]').val(nocData.ItDC_Remark);

                                // 6. Email Account Blocked
                                if (nocData.ItEAB === 'Y') {
                                    $('input[name="email_blocked[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItEAB === 'N') {
                                    $('input[name="email_blocked[]"][value="No"]').prop('checked', true);
                                } 
                                else {
                                    $('input[name="email_blocked[]"][value="NA"]').prop('checked', true);
                                } 
                                
                                $('input[name="email_recovery_amount"]').val(nocData.ItEAB_Amt);
                                $('input[name="email_remarks"]').val(nocData.ItEAB_Remark);

                                // 7. Mobile No. Disabled/Transferred
                                if (nocData.ItMND === "Y") {
                                    $('input[name="mobile_disabled[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItMND === "N") {
                                    $('input[name="mobile_disabled[]"][value="No"]').prop('checked', true);
                                }
                                else  {
                                    $('input[name="mobile_disabled[]"][value="NA"]').prop('checked', true);
                                }
                                 
                                $('input[name="mobile_recovery_amount"]').val(nocData.ItMND_Amt);
                                $('input[name="mobile_remarks"]').val(nocData.ItMND_Remark);
                                $('input[name="otherremark"]').val(nocData.Oth_Remark);

                                // 8. Any remarks
                                $('input[name="any_remarks"]').val(nocData.ItOth_Remark);
                                console.log(nocData.final_submit_it);
                                // Handle final submit or draft submit
                                if (nocData.final_submit_it === 'Y') {
                                    $('input').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Hide the "Save as Draft" and "Final Submit" buttons
                                    $('.modal-footer #save-draft-btn-it').hide();
                                    $('.modal-footer #final-submit-btn-it').hide();
                                            }
                            }




                        });


                    });

                    document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                        checkbox.addEventListener('change', function () {
                            // Get the name of the group (all checkboxes with the same name)
                            const name = this.name;
                            // Uncheck all checkboxes in the group
                            document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
                                if (otherCheckbox !== checkbox) {
                                    otherCheckbox.checked = false;
                                }
                            });
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