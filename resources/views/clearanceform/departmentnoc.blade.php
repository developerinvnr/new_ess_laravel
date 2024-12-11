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
                                        <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Department NOC Form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 @include('employee.menuteam')
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
                $('input[name="otherremark"]').val(nocData.Oth_Remark);

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

// Event listener for the "Save as Draft" button
saveDraftButton.addEventListener('click', function(event) {
    handleFormSubmission('save-draft-btn');  // Pass 'save-draft-btn' as the button ID
});

// Event listener for the "Final Submit" button
submitButton.addEventListener('click', function(event) {
    handleFormSubmission('final-submit-btn');  // Pass 'final-submit-btn' as the button ID
});
document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Get the name of the group (all checkboxes with the same name)
            const name = this.name;
            // Uncheck all checkboxes in the group
            document.querySelectorAll(`input[name="${name}"]`).forEach(function(otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                }
            });
        });
    });
</script>