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
            <th>Reporting Remark</th>
            <th>Employee Details</th>
            <th>Exit Interview Form</th>
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
            $exitFormAvailable = \App\Models\EmployeeSeparation::where('Rep_EmployeeID', Auth::user()->EmployeeID) // Match EmployeeID with Rep_EmployeeID
                ->where('Rep_Approved', 'Y') // Check Rep_Approved status
                ->where('HR_Approved', 'Y') // Check HR_Approved status
                ->where('EmpSepId', $data->EmpSepId) // Check for the specific EmpSepId
                ->exists(); // Check if such a record exists
        @endphp
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
        <td>
            @if($data->Rep_Remark && $data->Rep_Remark !== 'NA')
                <!-- If Rep_Remark exists and is not 'NA', display it -->
                {{ $data->Rep_Remark }}
            @else
                <!-- If Rep_Remark is 'NA' or NULL, show an input field for it -->
                <input type="text" 
                    name="Rep_Remark[{{ $data->EmpSepId }}]" 
                    class="form-control Rep_Remark" 
                    value="{{ old('Rep_Remark.' . $data->EmpSepId, '') }}" 
                    data-id="{{ $data->EmpSepId }}" 
                    onchange="updateSeparationData(this)">
            @endif
        </td>
            <td><a data-bs-toggle="modal" data-bs-target="#empdetails" href="">Click</a></td>
                @if($exitFormAvailable)
                    <td><a data-bs-toggle="modal" data-bs-target="#exitfromreporting" href="">Click</a></td>

                @else
                <td></td>
                @endif
                <td>
                    @if($data->Rep_Approved == 'Y')
                        Approved
                    @elseif($data->Rep_Approved == 'N')
                        Reject
                    @else
                        Pending  <!-- You can also handle other possible statuses if needed -->
                    @endif
                </td>

            <td>
                @if($data->Rep_Approved == 'Y')
                    <!-- If Rep_Approved is Y, display the status as read-only (non-editable dropdown) -->
                    <select class="form-control" 
                            disabled>
                        <option value="Y" {{ $data->Rep_Approved == 'Y' ? 'selected' : '' }}>Approved</option>
                        <option value="N" {{ $data->Rep_Approved == 'N' ? 'selected' : '' }}>Reject</option>
                    </select>
                @else
                    <!-- If Rep_Approved is not Y, allow editing -->
                    <select class="form-control status-dropdown" 
                            name="status[{{ $data->EmpSepId }}]" 
                            id="status-{{ $data->EmpSepId }}" 
                            data-id="{{ $data->EmpSepId }}" 
                            onchange="updateSeparationData(this)">
                        <option value="Y" {{ $data->Rep_Approved == 'Y' ? 'selected' : '' }}>Approved</option>
                        <option value="N" {{ $data->Rep_Approved == 'N' ? 'selected' : '' }}>Reject</option>
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
        var remarkField = document.querySelector('input[name="Rep_Remark[' + empSepId + ']"]');

        if ((status === 'Y' || status === 'N') && (remarkField.value.trim() === '' || remarkField.value.trim() === 'NA')) {
         // If the remark is empty or 'NA', show a toastr warning and prevent the status change
            toastr.warning('Please enter a remark before selecting the status.', 'Warning', {
                "positionClass": "toast-top-right", // Position the toast at the top-right
                "timeOut": 3000 // Duration for which the toast is visible (in ms)
            });
            selectElement.value = ''; // Reset the select field if no remark is provided
            remarkField.focus(); // Focus on the remark field for the user to fill it
        }
        $('#loader').show(); 

        // Send the updated data to the server
        $.ajax({
            url: '/update-rep-relieving-date',  // Define the URL in your routes
            type: 'POST',
            data: {
            _token: '{{ csrf_token() }}',
            EmpSepId: empSepId,  // Employee Separation ID
            Rep_RelievingDate: relievingDate,  // Rep Relieving Date
            Rep_Approved: status,  // Rep_Approved status
            Rep_Remark: remarkField.value.trim(),  // Pass the remark value here
            HR_Approved: hrStatus,  // HR_Approved status (new addition)
            HR_RelievingDate: hrRelievingDate  // HR Relieving Date (new addition)
        },
            success: function (response) {
            if (response.success) {
                // $('#loader').hide(); 

                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right", // Position the toast at the top right
                    "timeOut": 3000 // Duration for which the toast is visible (in ms)
                });
                // // Optionally reload or do something else after success
                // setTimeout(function () {
                //     location.reload(); // Reload the page
                // }, 3000);
            }
            // If the response contains an error message
            else if (response.error) {
                // toastr.error(response.message, 'Error', {
                //     "positionClass": "toast-top-right", // Position the toast at the top right
                //     "timeOut": 3000 // Duration for which the toast is visible (in ms)
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
            // }, 3000);
        }
        });
    }
             
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
</style>