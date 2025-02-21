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
                                    <li class="breadcrumb-link active">Department NOC Form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                 <div class="card">
                    <div class="card-header dflex justify-content-center align-items-center">
                        <h5><b>LOGISTICS Clearance</b></h5>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <!-- Excel Icon on the left -->
                            <a href="{{ route('export.approvedEmployees') }}" style="font-size: 20px; color:black;">
                                <i class="fas fa-file-excel"></i> <!-- Medium size and blue color -->
                            </a>

                            <!-- Filter form with status dropdown on the right -->
                            <form method="GET" action="{{ url()->current() }}" style="margin: 0;">
                                <select id="logicticsFilter" name="log_status" style="float: right;margin:10px;">
                                    <option value="">All</option>
                                    <option value="N" {{ request()->get('log_status', 'N') == 'N' ? 'selected' : '' }}>Pending</option>
                                    <option value="Y" {{ request()->get('log_status') == 'Y' ? 'selected' : '' }}>Submitted</option>
                                </select>
                            </form>
                        </div>

                    </div>

                        <div class="card-body table-responsive">
                            <!-- LOGISTICS Clearance Table -->
                            <table class="table table-bordered" id="logisticstable">
                           
                                <thead style="background-color:#cfdce1;">
                                    <tr>
                                        <th>EC</th>
                                        <th>Employee Name</th>
                                        <th>Department</th>
                                        <th>Email</th>
                                        <th>Resignation Date</th>
                                        <th>Relieving Date</th>
                                        <th>Resignation Approved</th>
                                        <th>Reporting Approved</th>
                                        <th>Clearance Status</th>
                                        <th>Clearance form</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($approvedEmployees as $data)
                                        @php
                                            // Determine leave status and set the status for filtering
                                            $logstatus = $data->Log_NOC;
                                        @endphp
                                        <tr data-status="{{ $logstatus }}">
                                            <td>{{ $data->EmpCode }}</td>
                                            <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td>
                                            <td>{{ $data->department_name }}</td>
                                            <td>{{ $data->EmailId_Vnr }}</td>
                                            <td>{{ $data->Emp_ResignationDate ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y') : 'Not specified' }}</td>
                                            <td>{{ $data->Emp_RelievingDate ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y') : 'Not specified' }}</td>
                                            <td>
                                                    <span style="color: {{ $data->Rep_Approved == 'Y' ? 'green' : 'orange' }}; font-weight: bold;">
                                                        {{ $data->Rep_Approved == 'Y' ? 'Approved' : 'Pending' }}
                                                    </span>
                                                </td> 
                                                <td>
                                                    <span style="color: {{ $data->Rep_NOC == 'Y' ? 'green' : 'orange' }}; font-weight: bold;">
                                                        {{ $data->Rep_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                    </span>
                                                </td> 
                                            <td>
                                                @php
                                                    $nocRecord = \DB::table('hrm_employee_separation_nocrep')->where('EmpSepId', $data->EmpSepId)->first();
                                                @endphp

                                                @if($nocRecord)
                                                @if($nocRecord && $data->Log_NOC == 'Y')
                                                        <span class="text-success">Submitted</span>
                                                    @elseif($nocRecord->draft_submit_log === 'Y')
                                                        <span class="text-warning">Draft</span>
                                                    @elseif($nocRecord->final_submit_log === 'Y')
                                                        <span class="text-success">Submitted</span>
                                                    
                                                    @elseif($data->Log_NOC == 'N')
                                                        <span class="text-warning">Pending</span>
                                                    @endif
                                                @else
                                                    <span class="text-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                            @if($nocRecord && $data->Rep_NOC == 'Y')
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsLOGISTIC"
                                                data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}"
                                                data-designation="{{ $data->designation_name }}"
                                                data-employee-id="{{ $data->EmployeeID }}"
                                                data-emp-code="{{ $data->EmpCode }}"
                                                data-department="{{ $data->department_name }}"
                                                data-emp-sepid="{{ $data->EmpSepId }}">
                                                Form click
                                                </a>
                                            @elseif($nocRecord && ($data->Log_NOC == 'Y' || $nocRecord->final_submit_log == 'Y'))
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsLOGISTIC"
                                                data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}"
                                                data-designation="{{ $data->designation_name }}"
                                                data-employee-id="{{ $data->EmployeeID }}"
                                                data-emp-code="{{ $data->EmpCode }}"
                                                data-department="{{ $data->department_name }}"
                                                data-emp-sepid="{{ $data->EmpSepId }}">
                                                View 
                                                </a>
                                                @else
                                                <span>-</span>
                                            @endif
                                        </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


            </div>

   
            <div class="modal fade show" id="clearnsdetailsLOGISTIC" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
                style="display: none;" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                                            <input type="hidden" name="EmployeeID">


                                    <div class="clformbox">
                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                    <label style="width: auto; margin-right: 10px;"><b>1. Handover of Data Documents etc</b></label>
                                    <div style="display: flex; align-items: center;">
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="DDH[]" value="NA" disabled> NA
                                        </label>
                                        <label style="margin-right: 10px;">
                                            <input type="checkbox" name="DDH[]" value="Yes" disabled> Yes
                                        </label>
                                        <label>
                                            <input type="checkbox" name="DDH[]" value="No" disabled> No
                                        </label>
                                    </div>
                                </div>

                                <div class="clrecoveramt">
                                    <input class="form-control" type="text" name="DDH_Amt" placeholder="Enter recovery amount" disabled>
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="DDH_Remark" placeholder="Enter remarks" style="margin:10px;" disabled>
                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>2. Handover of ID Card</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="TID[]" value="NA" disabled> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="TID[]" value="Yes" disabled> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="TID[]" value="No" disabled> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="text" name="TID_Amt" placeholder="Enter recovery amount" disabled>
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="TID_Remark" placeholder="Enter remarks" disabled>
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>3. Complete pending task</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="APTC[]" value="NA" disabled> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="APTC[]" value="Yes" disabled> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="APTC[]" value="No" disabled> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="text" name="APTC_Amt" placeholder="Enter recovery amount" disabled>
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="APTC_Remark" placeholder="Enter remarks" style="margin:10px;" disabled>
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>4. Handover of Health Card</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="HOAS[]" value="NA" disabled> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="HOAS[]" value="Yes" disabled> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="HOAS[]" value="No" disabled> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="text" name="HOAS_Amt" placeholder="Enter recovery amount" disabled>
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="HOAS_Remark" placeholder="Enter remarks" style="margin:10px;" disabled>
                                                </div>
                                            </div>

                                                <div id="total-amount-log" style="margin:0px 60px 10px 0px; font-weight: bold;float:inline-end;"></div>

                                                <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
                                                Parties Clearance 
                                               
                                            <div id="parties-container">
                                                <!-- Dynamically generated party sections will appear here -->
                                            </div>
                                            <a class="effect-btn btn btn-success squer-btn sm-btn" id="add-more">
                                                    Add <i class="fas fa-plus mr-2"></i>
                                                </a>


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
                                                        <button class="btn btn-success" type="button" id="final-submit-btn-log">Final Submission</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
    
    
@include('employee.footer')
<script>
   
    const form = document.getElementById('logisticsnocform');
    const saveDraftButton = document.getElementById('save-draft-btn-log');
    const submitButton = document.getElementById('final-submit-btn-log');
    const partiesContainer = document.getElementById('parties-container');
    let partyCount = 1;
 
    // Function to handle form submission
    function handleFormSubmission(buttonId, event) {
        event.preventDefault();
        $('#loader').show();

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
                $('#loader').hide();

                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                    
                                if (buttonId === 'save-draft-btn-log') {
                                                var empSepId = $('input[name="EmpSepId"]').val();
                                                var employeeid = $('input[name="EmployeeID"]').val();
                                                refreshModalData(empSepId, employeeid);  // Refresh the modal data after submission
                                            } else if (buttonId === 'final-submit-btn-log') {
                                                // If the Final Submit button was clicked, reload the page
                                                setTimeout(function() {
                                                    location.reload();  // Reload the page after a short delay to match the toast timeout
                                                }, 3000); // Delay before reload to match the toast timeout
                                    }
                                                    

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
    saveDraftButton.addEventListener('click', function(event) {
        handleFormSubmission('save-draft-btn-log', event); // Pass 'save-draft-btn' as the button ID
    });

    // Event listener for "Final Submit" button
    submitButton.addEventListener('click', function(event) {
        handleFormSubmission('final-submit-btn-log', event); // Pass 'final-submit-btn' as the button ID
    });


    document.getElementById('add-more').addEventListener('click', function() {
    // Find the last party section in the container
    const partiesContainer = document.getElementById('parties-container');
    const lastParty = partiesContainer.querySelector('.clformbox:last-of-type');

    // Determine the next party count based on the last party's ID
    let nextPartyCount = 1;
    if (lastParty) {
        const lastPartyId = lastParty.id;  // Get the ID of the last party (e.g., party-1, party-2)
        nextPartyCount = parseInt(lastPartyId.split('-')[1]) + 1;  // Extract the number and increment by 1
    }

    // Create the HTML for the new party section, using the unique nextPartyCount for the name attribute
    const partyHTML = `
        <div class="clformbox" id="party-${nextPartyCount}">
            <div class="formlabel">
                <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${nextPartyCount}" placeholder="Enter your party name"><br>
                <input type="checkbox" name="Parties_${nextPartyCount}_docdata" value="NA"><label>NA</label>
                <input type="checkbox" name="Parties_${nextPartyCount}_docdata" value="Yes" checked><label>Yes</label>
                <input type="checkbox" name="Parties_${nextPartyCount}_docdata" value="No"><label>No</label>
            </div>
            <div class="clrecoveramt">
                <input class="form-control" type="number" name="Parties_${nextPartyCount}_Amt" placeholder="Enter recovery amount" value="0.00">
            </div>
            <div class="clreremarksbox">
                <input class="form-control" type="text" name="Parties_${nextPartyCount}_Remark" placeholder="Enter remarks">
            </div>
            <button type="button" class="btn btn-danger remove-party" style="margin:10px;" data-party-id="party-${nextPartyCount}">-</button>
        </div>
    `;

    // Insert the new party HTML into the container
    partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
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

    // Function to refresh the modal content
    function refreshModalData(empSepId, employeeid) {
    
        // Fetch updated data for the modal
        $.ajax({
            url: '/get-noc-data/' + empSepId + '/' + employeeid,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var nocData = response.data;
                    
                    // Update the modal with employee info
                    modal.find('.emp-name').text(nocData.empName);
                    modal.find('.designation').text(nocData.designation);
                    modal.find('.emp-code').text(nocData.empCode);
                    modal.find('.department').text(nocData.department);
                    modal.find('input[name="EmpSepId"]').val(empSepId);
                    
                    // Reset and populate checkboxes and input fields with the fetched data
                    // Example: DDH
                    if (nocData.DDH === 'Y') {
                        $('input[name="DDH[]"][value="Yes"]').prop('checked', true);
                    } else if (nocData.DDH === 'N') {
                        $('input[name="DDH[]"][value="No"]').prop('checked', true);
                    } else {
                        $('input[name="DDH[]"][value="NA"]').prop('checked', true);
                    }
                    $('input[name="DDH_Amt"]').val(nocData.DDH_Amt);
                    $('input[name="DDH_Remark"]').val(nocData.DDH_Remark);

                    // You can similarly reset other fields like TID, APTC, HOAS, etc.

                    // Refresh party fields
                    let dealerNames = response.dealerNames; 
                    let partyIndex = 1;

                    // Remove previous party data to reset
                    modal.find('.clformbox').remove();

                    while (nocData[`Prtis${partyIndex}`] || dealerNames[partyIndex - 1]) {
                        let partyDocValue = nocData[`Prtis_${partyIndex}`]; // Get the stored value

                        // Default party name from nocData
                        let partyName = nocData[`Prtis${partyIndex}`] || dealerNames[partyIndex - 1]; // If no nocData, use dealer name
                        if (partyDocValue === undefined || partyDocValue === '') {
                            partyDocValue = 'Y';
                        }  
                        console.log(partyDocValue);
                        
                        const partyHTML = `
                            <div class="clformbox" id="party-${partyIndex}">
                                <div class="formlabel">
                            <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyIndex}" value="${partyName}" placeholder="Enter your party name"><br>
                            <input type="checkbox" class="party-docdata" name="Parties_${partyIndex}_docdata" value="NA" ${partyDocValue === 'NA' ? 'checked' : ''}><label>NA</label>
                            <input type="checkbox" class="party-docdata" name="Parties_${partyIndex}_docdata" value="Yes" ${partyDocValue === 'Y' ? 'checked' : ''}><label>Yes</label>
                            <input type="checkbox" class="party-docdata" name="Parties_${partyIndex}_docdata" value="No" ${partyDocValue === 'N' ? 'checked' : ''}><label>No</label>
                        </div>
                                <div class="clrecoveramt">
                                    <input class="form-control" type="number" name="Parties_${partyIndex}_Amt" value="${nocData[`Prtis_${partyIndex}Amt`] || '0.00'}" placeholder="Enter recovery amount">
                                </div>
                                <div class="clreremarksbox">
                                    <input class="form-control" type="text" name="Parties_${partyIndex}_Remark" value="${nocData[`Prtis_${partyIndex}Remark`] || ''}" placeholder="Enter remarks">
                                </div>
                            </div>
                        `;
                        modal.find('.parties-container').append(partyHTML);
                        partyIndex++;
                    }

                    // Handle other final submission logic if necessary
                    if (nocData.Log_NOC == 'Y') {
                        $('input, select').prop('disabled', true);
                        $('.modal-footer #save-draft-btn-log').hide();
                        $('.modal-footer #final-submit-btn-log').hide();
                        $('a#add-more').hide(); // Ensure hiding any anchor tag version
                        $('#add-more').hide();  // Hides the button
                    }

                } else {
                    toastr.error('Error: Failed to fetch updated data.', 'Error', {
                        "positionClass": "toast-top-right",
                        "timeOut": 3000
                    });
                }
            },
            error: function() {
                toastr.error('Error fetching NOC data.', 'Error', {
                    "positionClass": "toast-top-right",
                    "timeOut": 3000
                });
            }
        });
    }


    // Show the modal and populate it with the relevant data
    $('#clearnsdetailsLOGISTIC').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var empSepId = button.data('emp-sepid');
        var employeeid = button.data('employee-id');

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
        modal.find('input[name="EmployeeID"]').val(employeeid);

        // Fetch additional data for this EmpSepId using an AJAX request
        $.ajax({
            url: '/get-noc-data/' + empSepId + '/' + employeeid, // Assuming the endpoint is correct
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

                                       // Assuming the response data looks like this:
            let dealerNames = response.dealerNames; // This will be an array of dealer names
            let partyIndex = 1;

            while (nocData[`Prtis${partyIndex}`] || dealerNames[partyIndex - 1]) {
                let partyDocValue = nocData[`Prtis_${partyIndex}`]; // Get the stored value

                // Default party name from nocData
                let partyName = nocData[`Prtis${partyIndex}`] || dealerNames[partyIndex - 1]; // If no nocData, use dealer name
                if (partyDocValue == undefined || partyDocValue == '') {
                    partyDocValue = 'Y';
                }

                // Dynamically populate party fields
                const partyHTML = `
                    <div class="clformbox" id="party-${partyIndex}">
                        <div class="formlabel">
                            <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyIndex}" value="${partyName}" placeholder="Enter your party name"><br>
                            <input type="checkbox" class="party-docdata" name="Parties_${partyIndex}_docdata" value="NA" ${partyDocValue === 'NA' ? 'checked' : ''}><label>NA</label>
                            <input type="checkbox" class="party-docdata" name="Parties_${partyIndex}_docdata" value="Yes" ${partyDocValue === 'Y' ? 'checked' : ''}><label>Yes</label>
                            <input type="checkbox" class="party-docdata" name="Parties_${partyIndex}_docdata" value="No" ${partyDocValue === 'N' ? 'checked' : ''}><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="number" name="Parties_${partyIndex}_Amt" value="${nocData[`Prtis_${partyIndex}Amt`] || '0.00'}" placeholder="Enter recovery amount">
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
                // if (nocData.final_submit_log === 'Y') {
                //     // Disable all form fields if the status is 'Y'
                //     $('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                //   // Hide the "Save as Draft" and "Final Submit" buttons
                //   $('.modal-footer #save-draft-btn-log').hide();
                //     $('.modal-footer #final-submit-btn-log').hide();
                // }
                const currentYear = new Date().getFullYear();

                // Convert NocSubmitDate and Logistic_Noc_Submit_Date to Date objects
                const nocSubmitDate = new Date(nocData.NocSubmitDate);
                const logisticNocSubmitDate = new Date(nocData.Logistic_Noc_Submit_Date);

                // Check if either date is from the previous year
                const isPreviousYear = (nocSubmitDate.getFullYear() < currentYear || logisticNocSubmitDate.getFullYear() < currentYear);

                

                if (nocData.Log_NOC == 'Y') {
                    $('input,select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                    $('.modal-footer #save-draft-btn-log').hide();
                    $('.modal-footer #final-submit-btn-log').hide();
                    $('#add-more').hide();  // Hides the button

                    }
                }
            },
            error: function() {
                alert('Error fetching NOC data.');
            }
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
// Update the event delegation for checkboxes
document.getElementById('parties-container').addEventListener('change', function(event) {
    // Check if the clicked element is a checkbox
    if (event.target && event.target.type === 'checkbox') {
        const checkbox = event.target;
        const name = checkbox.name;

        // Uncheck all checkboxes in the same group, except the one that was just clicked
        document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
            if (otherCheckbox !== checkbox) {
                otherCheckbox.checked = false; // Uncheck the other checkboxes in the same group
            }
        });
    }
});
// Add click event listener to the close button
$('.close').on('click', function() {
    // Refresh the page when the close button is clicked
    location.reload();
});

    // $(document).ready(function() {
    //     // Apply the filter when the dropdown selection changes
    //     $('#logicticsFilter').change(function() {
    //         var selectedStatus = $(this).val(); // Get the selected status

    //         // Filter the table rows based on the selected status
    //         $('#logisticstable tbody tr').each(function() {
    //             var rowStatus = $(this).data('status'); // Get the status from the data-status attribute

    //             // If no status is selected or if the status matches the selected one, show the row
    //             if (selectedStatus === "" || selectedStatus == rowStatus) {
    //                 $(this).show(); // Show matching rows
    //             } else {
    //                 $(this).hide(); // Hide non-matching rows
    //             }
    //         });
    //     });

    //     // Trigger the change event to apply the default filter when the page loads
    //     $('#logicticsFilter').trigger('change');
    // });

    function initializeTable(tableSelector, filterSelector, columnIndex, defaultFilterValue) {
      
      var table = $(tableSelector).DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      });
      
      
      if (!defaultFilterValue) {
      $(filterSelector).val(''); 
      } else {
      
      $(filterSelector).val(defaultFilterValue);
      var defaultText = defaultFilterValue === 'Y' ? 'Submitted' : defaultFilterValue === 'N' ? 'Pending' : '';
      table.column(columnIndex).search(defaultText).draw();
      }
      
      
      $(filterSelector).on('change', function () {
      var filterValue = $(this).val();
      var filterText = '';
      
      
      if (filterValue === 'N') {
      filterText = 'Pending';
      } else if (filterValue === 'Y') {
      filterText = 'Submitted';
      }
      
      
      table.column(columnIndex).search(filterText).draw();
      });
      }
      
      
      $(document).ready(function () {
            var defaultFilter = '{{ request()->get('log_status', '') }}'; 
            initializeTable('#logisticstable', '#logicticsFilter', 8, defaultFilter);
      });
       $('#logisticstable').css('font-family', 'Roboto, sans-serif');
    $('#logisticstable').find('th, td').css('font-family', 'Roboto, sans-serif');

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
.card-header {
      display: flex; 
      justify-content: center; 
      align-items: center; 
      text-align: center; 
      }
      .dflex {
      display: flex; 
      justify-content: space-between !important; 
      align-items: center; 
      width: 100%; 
      }
      .has-btn {
      margin-right: 10px; 
      }
      .dataTables_wrapper table.dataTable td{
  border: none !important;
  font-family: roboto;
}
</style>