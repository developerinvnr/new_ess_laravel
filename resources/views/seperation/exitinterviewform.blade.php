@include('seperation.head')
@include('seperation.header')
@include('seperation.sidebar')

<body class="mini-sidebar">
<div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
    <!-- Main Body -->
    <div class="page-wrapper">
 	<!-- Header Start -->
	 @include('seperation.head')
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
                                    <li class="breadcrumb-link active">My Team - Exit Interview Form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Revanue Status Start -->
                <form id="exitForm" method="POST">
                        @csrf
                        <input type="hidden" name="EmpSepId" value="{{ $empid }}">

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5><b>Exit form</b></h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <div class="row exitform">
                                            <div class="col-md-6">
                                                <!-- PERSONAL Table -->
                                            <table class="table border mb-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width:35px">1.</th>
                                                        <th><b>PERSONAL</b></th>
                                                        <th style="width:35px">4</th>
                                                        <th style="width:35px">3</th>
                                                        <th style="width:35px">2</th>
                                                        <th style="width:35px">1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>a) Family related issues</td>
                                                        <td><input type="radio" name="personal_reasons_1" value="4"></td>
                                                        <td><input type="radio" name="personal_reasons_1" value="3"></td>
                                                        <td><input type="radio" name="personal_reasons_1" value="2"></td>
                                                        <td><input type="radio" name="personal_reasons_1" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>b) Health problems</td>
                                                        <td><input type="radio" name="personal_reasons_2" value="4"></td>
                                                        <td><input type="radio" name="personal_reasons_2" value="3"></td>
                                                        <td><input type="radio" name="personal_reasons_2" value="2"></td>
                                                        <td><input type="radio" name="personal_reasons_2" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>c) Own business</td>
                                                        <td><input type="radio" name="personal_reasons_3" value="4"></td>
                                                        <td><input type="radio" name="personal_reasons_3" value="3"></td>
                                                        <td><input type="radio" name="personal_reasons_3" value="2"></td>
                                                        <td><input type="radio" name="personal_reasons_3" value="1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                             <!-- PROFESSIONAL GROWTH RELATED Table -->
                                            <table class="table border mb-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width:35px">2.</th>
                                                        <th><b>PROFESSIONAL GROWTH RELATED</b></th>
                                                        <th style="width:35px">4</th>
                                                        <th style="width:35px">3</th>
                                                        <th style="width:35px">2</th>
                                                        <th style="width:35px">1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>a) Inadequate training and development activities.</td>
                                                        <td><input type="radio" name="growth_reasons_1" value="4"></td>
                                                        <td><input type="radio" name="growth_reasons_1" value="3"></td>
                                                        <td><input type="radio" name="growth_reasons_1" value="2"></td>
                                                        <td><input type="radio" name="growth_reasons_1" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>b) Lack of challenge in the work.</td>
                                                        <td><input type="radio" name="growth_reasons_2" value="4"></td>
                                                        <td><input type="radio" name="growth_reasons_2" value="3"></td>
                                                        <td><input type="radio" name="growth_reasons_2" value="2"></td>
                                                        <td><input type="radio" name="growth_reasons_2" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>c) Low promotional opportunities.</td>
                                                        <td><input type="radio" name="growth_reasons_3" value="4"></td>
                                                        <td><input type="radio" name="growth_reasons_3" value="3"></td>
                                                        <td><input type="radio" name="growth_reasons_3" value="2"></td>
                                                        <td><input type="radio" name="growth_reasons_3" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>d) Job allotted not matching with job aspirations.</td>
                                                        <td><input type="radio" name="growth_reasons_4" value="4"></td>
                                                        <td><input type="radio" name="growth_reasons_4" value="3"></td>
                                                        <td><input type="radio" name="growth_reasons_4" value="2"></td>
                                                        <td><input type="radio" name="growth_reasons_4" value="1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <!-- PROFESSIONAL ATMOSPHERE CONDITIONS Table -->
                                            <table class="table border mb-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width:35px">3.</th>
                                                        <th><b>PROFESSIONAL ATMOSPHERE CONDITIONS</b></th>
                                                        <th style="width:35px">4</th>
                                                        <th style="width:35px">3</th>
                                                        <th style="width:35px">2</th>
                                                        <th style="width:35px">1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>a) Lack of clarity on policies.</td>
                                                        <td><input type="radio" name="atmosphere_conditions_1" value="4"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_1" value="3"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_1" value="2"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_1" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>b) Insecurity and uncertainty in day-to-day working.</td>
                                                        <td><input type="radio" name="atmosphere_conditions_2" value="4"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_2" value="3"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_2" value="2"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_2" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>c) Lack of communication.</td>
                                                        <td><input type="radio" name="atmosphere_conditions_3" value="4"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_3" value="3"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_3" value="2"></td>
                                                        <td><input type="radio" name="atmosphere_conditions_3" value="1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            </div>

                                            <div class="col-md-6">
                                            <!-- PROFESSIONAL WORKING CONDITIONS Table -->
                                            <table class="table border mb-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width:35px">4.</th>
                                                        <th><b>PROFESSIONAL WORKING CONDITIONS</b></th>
                                                        <th style="width:35px">4</th>
                                                        <th style="width:35px">3</th>
                                                        <th style="width:35px">2</th>
                                                        <th style="width:35px">1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>a) Unclean Surroundings</td>
                                                        <td><input type="radio" name="working_conditions_unclean_surroundings" value="4"></td>
                                                        <td><input type="radio" name="working_conditions_unclean_surroundings" value="3"></td>
                                                        <td><input type="radio" name="working_conditions_unclean_surroundings" value="2"></td>
                                                        <td><input type="radio" name="working_conditions_unclean_surroundings" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>b) Hardship/ Job is too stressful</td>
                                                        <td><input type="radio" name="working_conditions_stressful_job" value="4"></td>
                                                        <td><input type="radio" name="working_conditions_stressful_job" value="3"></td>
                                                        <td><input type="radio" name="working_conditions_stressful_job" value="2"></td>
                                                        <td><input type="radio" name="working_conditions_stressful_job" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>c) Working hours</td>
                                                        <td><input type="radio" name="working_conditions_working_hours" value="4"></td>
                                                        <td><input type="radio" name="working_conditions_working_hours" value="3"></td>
                                                        <td><input type="radio" name="working_conditions_working_hours" value="2"></td>
                                                        <td><input type="radio" name="working_conditions_working_hours" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>d) Job involves too much travel</td>
                                                        <td><input type="radio" name="working_conditions_too_much_travel" value="4"></td>
                                                        <td><input type="radio" name="working_conditions_too_much_travel" value="3"></td>
                                                        <td><input type="radio" name="working_conditions_too_much_travel" value="2"></td>
                                                        <td><input type="radio" name="working_conditions_too_much_travel" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>e) Non-Fulfillment of commitments by the company</td>
                                                        <td><input type="radio" name="working_conditions_non_fulfillment_commitments" value="4"></td>
                                                        <td><input type="radio" name="working_conditions_non_fulfillment_commitments" value="3"></td>
                                                        <td><input type="radio" name="working_conditions_non_fulfillment_commitments" value="2"></td>
                                                        <td><input type="radio" name="working_conditions_non_fulfillment_commitments" value="1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>


                                             <!-- PROFESSIONAL COMPENSATION RELATED Table -->
                                            <table class="table border mb-3">
                                                <thead>
                                                    <tr>
                                                        <th style="width:35px">5.</th>
                                                        <th><b>PROFESSIONAL COMPENSATION RELATED</b></th>
                                                        <th style="width:35px">4</th>
                                                        <th style="width:35px">3</th>
                                                        <th style="width:35px">2</th>
                                                        <th style="width:35px">1</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td></td>
                                                        <td>a) Inadequate pay & Increments in relation to the industry</td>
                                                        <td><input type="radio" name="compensation_inadequate_pay" value="4"></td>
                                                        <td><input type="radio" name="compensation_inadequate_pay" value="3"></td>
                                                        <td><input type="radio" name="compensation_inadequate_pay" value="2"></td>
                                                        <td><input type="radio" name="compensation_inadequate_pay" value="1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td>b) Inadequate incentives and bonus</td>
                                                        <td><input type="radio" name="compensation_inadequate_incentives" value="4"></td>
                                                        <td><input type="radio" name="compensation_inadequate_incentives" value="3"></td>
                                                        <td><input type="radio" name="compensation_inadequate_incentives" value="2"></td>
                                                        <td><input type="radio" name="compensation_inadequate_incentives" value="1"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                                <!-- PROFESSIONAL ROLE RELATED Table -->
                                                <table class="table border mb-3">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:35px">6.</th>
                                                            <th><b>PROFESSIONAL ROLE RELATED</b></th>
                                                            <th style="width:35px">4</th>
                                                            <th style="width:35px">3</th>
                                                            <th style="width:35px">2</th>
                                                            <th style="width:35px">1</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td>a) Ambiguous role</td>
                                                            <td><input type="radio" name="role_related_ambiguous_role" value="4"></td>
                                                            <td><input type="radio" name="role_related_ambiguous_role" value="3"></td>
                                                            <td><input type="radio" name="role_related_ambiguous_role" value="2"></td>
                                                            <td><input type="radio" name="role_related_ambiguous_role" value="1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) No clarity in reporting relations</td>
                                                            <td><input type="radio" name="role_related_no_clarity_reporting" value="4"></td>
                                                            <td><input type="radio" name="role_related_no_clarity_reporting" value="3"></td>
                                                            <td><input type="radio" name="role_related_no_clarity_reporting" value="2"></td>
                                                            <td><input type="radio" name="role_related_no_clarity_reporting" value="1"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Other personal input sections like text inputs for "What are your primary reasons for leaving?" -->
                  <!-- Section 1: Exit Form Questions -->
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 exitformsec">
                        <div class="card">
                            <div class="card-header">
                                <h5><b>Kindly fill in the given questions</b></h5>
                            </div>
                            <div class="card-body table-responsive">
                                <div class="">
                                    <!-- Question 1 -->
                                    <label>1. What are your primary reasons for leaving? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="primary_reasons_for_leaving">
                                    <span id="primary_reasons_for_leaving_span"  style="display:none;"></span>
                                    <br>

                                    <!-- Question 2 -->
                                    <label>2. What did you find most satisfying about your job? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="most_satisfying_about_job">
                                    <span id="most_satisfying_about_job_span"  style="display:none;"></span>
                                    <br>

                                    <!-- Question 3 -->
                                    <label>3. What did you find most dissatisfying regarding your job? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="most_dissatisfying_about_job">
                                    <span id="most_dissatisfying_about_job_span"  style="display:none;"></span>
                                    <br>

                                    <!-- Question 4 -->
                                    <label>4. Were there any company policies or procedures that made your work more difficult? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="company_policies_made_work_difficult">
                                    <span id="company_policies_made_work_difficult_span"  style="display:none;"></span>
                                    <br>

                                    <!-- Question 5 -->
                                    <label>5. Is there anything the company could have done to prevent you from leaving? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="prevent_leave_suggestion">
                                    <span id="prevent_leave_suggestion_span" style="display:none;"></span>
                                    <br>

                                    <!-- Question 6 -->
                                    <label>6. Would you recommend this company to a friend as a good place to work? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="recommend_to_friend">
                                    <span id="recommend_to_friend_span"  style="display:none;"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: About Your New Job -->
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 exitformsec">
                            <div class="card">
                                <div class="card-header">
                                    <h5><b>About your new job</b></h5>
                                </div>
                                <div class="card-body table-responsive">
                                    <div class="">
                                        <!-- New Company Name -->
                                        <label>Name of the Company <span class="danger">*</span></label>
                                        <input class="form-control" type="text" name="new_company_name">
                                        <span id="new_company_name_span" style="display:none;"></span>
                                        <br>

                                        <!-- New Location -->
                                        <label>Location <span class="danger">*</span></label>
                                        <input class="form-control" type="text" name="new_job_location">
                                        <span id="new_job_location_span"  style="display:none;"></span>
                                        <br>

                                        <!-- New Designation -->
                                        <label>Designation <span class="danger">*</span></label>
                                        <input class="form-control" type="text" name="new_job_designation">
                                        <span id="new_job_designation_span"  style="display:none;"></span>
                                        <br>

                                                <!-- Compensation Hike -->
                                                <label>% Hike in compensation <span class="danger">*</span></label>
                                                <input class="form-control" type="text" name="hike_in_compensation">
                                                <span id="hike_in_compensation_span" style="display:none;"></span>
                                                <br>

                                                <!-- Other Benefits -->
                                                <label>Other benefits</label>
                                                <input class="form-control" type="text" name="new_job_benefits">
                                                <span id="new_job_benefits_span" style="display:none;"></span>
                                            </div>
                                            <!-- Submit and Reset Buttons -->
                                            <button class="btn btn-primary mt-4" type="reset" id="reset">Reset</button>
                                            <button class="btn btn-success mt-4" type="submit" id="finalsubmitexitemp">Submit</button>
                                        </div>
                                    </div>
                    </div>

                </form> 
				@include('employee.footerbottom')

            </div>
        </div>
    </div>
@include('employee.footer');
<script>
  
  document.addEventListener('DOMContentLoaded', function() {
    // Get the form and buttons
    const form = document.getElementById('exitForm');
    const submitButton = document.getElementById('finalsubmitexitemp');

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
        fetch("{{ route('exitformsubmit') }}", {  // Replace with your actual route
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
            }
        })
        .catch(error => {
            // Handle any errors from the fetch request
            toastr.error('Error: ' + error.message, 'Error', {
                "positionClass": "toast-top-right",  // Position at top-right
                "timeOut": 3000  // 3-second timeout for the toast
            });
        });
    }


    // Event listener for the "Final Submit" button
    submitButton.addEventListener('click', function(event) {
        $('#loader').show(); // Hide loading spinner
        handleFormSubmission('finalsubmitexitemp');  // Pass 'final-submit-btn' as the button ID
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
document.addEventListener("DOMContentLoaded", function() {
    const empid = document.querySelector('input[name="EmpSepId"]').value; // Get the EmpSepId from the form

    // Fetch data from backend using EmpSepId
    fetch(`/get-exit-form-data/${empid}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);            // Populate the radio buttons based on the data
              // Personal Reasons
            if (data.FRI) { // Family related issues
                const radioBtn = document.querySelector(`input[name="personal_reasons_1"][value="${data.FRI}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.HP) { // Health problems
                const radioBtn = document.querySelector(`input[name="personal_reasons_2"][value="${data.HP}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.OB) { // Own business
                const radioBtn = document.querySelector(`input[name="personal_reasons_3"][value="${data.OB}"]`);
                if (radioBtn) radioBtn.checked = true;
            }

            // Professional Growth Related
            if (data.PGR) {
                const radioBtn = document.querySelector(`input[name="growth_reasons_1"][value="${data.PGR}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.LOC) {
                const radioBtn = document.querySelector(`input[name="growth_reasons_2"][value="${data.LOC}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.LPO) {
                const radioBtn = document.querySelector(`input[name="growth_reasons_3"][value="${data.LPO}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.JANM) {
                const radioBtn = document.querySelector(`input[name="growth_reasons_4"][value="${data.JANM}"]`);
                if (radioBtn) radioBtn.checked = true;
            }

            // Professional Atmosphere Conditions
            if (data.LOCOP) {
                const radioBtn = document.querySelector(`input[name="atmosphere_conditions_1"][value="${data.LOCOP}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.IAU) {
                const radioBtn = document.querySelector(`input[name="atmosphere_conditions_2"][value="${data.IAU}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.LOCOM) {
                const radioBtn = document.querySelector(`input[name="atmosphere_conditions_3"][value="${data.LOCOM}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            // Professional Working Conditions
            if (data.US) {
                const radioBtn = document.querySelector(`input[name="working_conditions_unclean_surroundings"][value="${data.US}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.HJ) {
                const radioBtn = document.querySelector(`input[name="working_conditions_stressful_job"][value="${data.HJ}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.WH) {
                const radioBtn = document.querySelector(`input[name="working_conditions_working_hours"][value="${data.WH}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.JITM) {
                const radioBtn = document.querySelector(`input[name="working_conditions_too_much_travel"][value="${data.JITM}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.NFOC) {
                const radioBtn = document.querySelector(`input[name="working_conditions_non_fulfillment_commitments"][value="${data.NFOC}"]`);
                if (radioBtn) radioBtn.checked = true;
            }

            // Professional Compensation Related
            if (data.IPI) {
                const radioBtn = document.querySelector(`input[name="compensation_inadequate_pay"][value="${data.IPI}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.IIAB) {
                const radioBtn = document.querySelector(`input[name="compensation_inadequate_incentives"][value="${data.IIAB}"]`);
                if (radioBtn) radioBtn.checked = true;
            }

            // Professional Role Related
            if (data.AR) {
                const radioBtn = document.querySelector(`input[name="role_related_ambiguous_role"][value="${data.AR}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
            if (data.NCIR) {
                const radioBtn = document.querySelector(`input[name="role_related_no_clarity_reporting"][value="${data.NCIR}"]`);
                if (radioBtn) radioBtn.checked = true;
            }
   // Section 1: Exit Form Questions
   if (data.Q1_1) {
        document.querySelector('input[name="primary_reasons_for_leaving"]').style.display = 'none';
        document.querySelector('#primary_reasons_for_leaving_span').style.display = 'block';
        document.querySelector('#primary_reasons_for_leaving_span').textContent = data.Q1_1;
    }
    if (data.Q2_1) {
        document.querySelector('input[name="most_satisfying_about_job"]').style.display = 'none';
        document.querySelector('#most_satisfying_about_job_span').style.display = 'block';
        document.querySelector('#most_satisfying_about_job_span').textContent = data.Q2_1;
    }
    if (data.Q3_1) {
        document.querySelector('input[name="most_dissatisfying_about_job"]').style.display = 'none';
        document.querySelector('#most_dissatisfying_about_job_span').style.display = 'block';
        document.querySelector('#most_dissatisfying_about_job_span').textContent = data.Q3_1;
    }
    if (data.Q4_1) {
        document.querySelector('input[name="company_policies_made_work_difficult"]').style.display = 'none';
        document.querySelector('#company_policies_made_work_difficult_span').style.display = 'block';
        document.querySelector('#company_policies_made_work_difficult_span').textContent = data.Q4_1;
    }
    if (data.Q5_1) {
        document.querySelector('input[name="prevent_leave_suggestion"]').style.display = 'none';
        document.querySelector('#prevent_leave_suggestion_span').style.display = 'block';
        document.querySelector('#prevent_leave_suggestion_span').textContent = data.Q5_1;
    }
    if (data.Q6) {
        document.querySelector('input[name="recommend_to_friend"]').style.display = 'none';
        document.querySelector('#recommend_to_friend_span').style.display = 'block';
        document.querySelector('#recommend_to_friend_span').textContent = data.Q6;
    }

    // Section 2: About Your New Job
    if (data.ComName) {
        document.querySelector('input[name="new_company_name"]').style.display = 'none';
        document.querySelector('#new_company_name_span').style.display = 'block';
        document.querySelector('#new_company_name_span').textContent = data.ComName;
    }
    if (data.Location) {
        document.querySelector('input[name="new_job_location"]').style.display = 'none';
        document.querySelector('#new_job_location_span').style.display = 'block';
        document.querySelector('#new_job_location_span').textContent = data.Location;
    }
    if (data.Designation) {
        document.querySelector('input[name="new_job_designation"]').style.display = 'none';
        document.querySelector('#new_job_designation_span').style.display = 'block';
        document.querySelector('#new_job_designation_span').textContent = data.Designation;
    }
    if (data.hike) {
        document.querySelector('input[name="hike_in_compensation"]').style.display = 'none';
        document.querySelector('#hike_in_compensation_span').style.display = 'block';
        document.querySelector('#hike_in_compensation_span').textContent = data.hike;
    }
    if (data.OthBefit) {
        document.querySelector('input[name="new_job_benefits"]').style.display = 'none';
        document.querySelector('#new_job_benefits_span').style.display = 'block';
        document.querySelector('#new_job_benefits_span').textContent = data.OthBefit;
    }   
    if (data.final_submit_exit_emp === 'Y') {
                                    $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Hide the "Save as Draft" and "Final Submit" buttons
                                    $('#finalsubmitexitemp').hide();
                                    $('#reset').hide();
                                }         

        })
        .catch(error => {
            console.error("Error fetching data:", error);
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