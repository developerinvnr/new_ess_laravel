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
                                    <li class="breadcrumb-link active">My Team - Exit Interview Form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revanue Status Start -->
                <form method="POST">
                        @csrf
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
                                                            <td><input type="checkbox" name="personal_reasons[]" value="family"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="health"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="business"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="others"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) Health problems</td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="health_problems"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="stress"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="family_issue"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="other_issue"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>c) Own business</td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="own_business"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="freedom"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="opportunity"></td>
                                                            <td><input type="checkbox" name="personal_reasons[]" value="other"></td>
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
                                                            <td><input type="checkbox" name="growth_reasons[]" value="inadequate_training"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="lack_challenge"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="low_promotion"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="other"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) Lack of challenge in the work.</td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="lack_of_challenge"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="repetitive_tasks"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="no_innovation"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="other"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>c) Low promotional opportunities.</td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="low_promotion_opportunity"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="no_growth"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="stagnant_role"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="other"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>d) Job allotted not matching with job aspirations.</td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="mismatch_role"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="career_goals"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="other_issues"></td>
                                                            <td><input type="checkbox" name="growth_reasons[]" value="other"></td>
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
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="policy_clarity"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="policy_communication"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="policy_enforcement"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="other"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) Insecurity and uncertainty in day-to-day working.</td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="job_security"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="work_uncertainty"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="stress"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="other"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>c) Lack of communication.</td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="lack_of_communication"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="unclear_messages"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="poor_management"></td>
                                                            <td><input type="checkbox" name="atmosphere_conditions[]" value="other"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                            <div class="col-md-6">
                                                <!-- PROFESSIONAL WORKING CONDITIONS Table -->
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
                                                            <td><input type="checkbox" name="working_conditions[]" value="unclean_surroundings_4"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="unclean_surroundings_3"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="unclean_surroundings_2"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="unclean_surroundings_1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) Hardship/ Job is too stressful</td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="stressful_job_4"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="stressful_job_3"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="stressful_job_2"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="stressful_job_1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>c) Working hours</td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="working_hours_4"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="working_hours_3"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="working_hours_2"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="working_hours_1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>d) Job involves too much travel</td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="too_much_travel_4"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="too_much_travel_3"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="too_much_travel_2"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="too_much_travel_1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>e) Non-Fulfillment of commitments by the company</td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="non_fulfillment_commitments_4"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="non_fulfillment_commitments_3"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="non_fulfillment_commitments_2"></td>
                                                            <td><input type="checkbox" name="working_conditions[]" value="non_fulfillment_commitments_1"></td>
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
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_pay_4"></td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_pay_3"></td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_pay_2"></td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_pay_1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) Inadequate incentives and bonus</td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_incentives_4"></td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_incentives_3"></td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_incentives_2"></td>
                                                            <td><input type="checkbox" name="compensation[]" value="inadequate_incentives_1"></td>
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
                                                            <td><input type="checkbox" name="role_related[]" value="ambiguous_role_4"></td>
                                                            <td><input type="checkbox" name="role_related[]" value="ambiguous_role_3"></td>
                                                            <td><input type="checkbox" name="role_related[]" value="ambiguous_role_2"></td>
                                                            <td><input type="checkbox" name="role_related[]" value="ambiguous_role_1"></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>b) No clarity in reporting relations</td>
                                                            <td><input type="checkbox" name="role_related[]" value="no_clarity_reporting_4"></td>
                                                            <td><input type="checkbox" name="role_related[]" value="no_clarity_reporting_3"></td>
                                                            <td><input type="checkbox" name="role_related[]" value="no_clarity_reporting_2"></td>
                                                            <td><input type="checkbox" name="role_related[]" value="no_clarity_reporting_1"></td>
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
                                    <br>

                                    <!-- Question 2 -->
                                    <label>2. What did you find most satisfying about your job? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="most_satisfying_about_job">
                                    <br>

                                    <!-- Question 3 -->
                                    <label>3. What did you find most dissatisfying regarding your job? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="most_dissatisfying_about_job">
                                    <br>

                                    <!-- Question 4 -->
                                    <label>4. Were there any company policies or procedures that made your work more difficult? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="company_policies_made_work_difficult">
                                    <br>

                                    <!-- Question 5 -->
                                    <label>5. Is there anything the company could have done to prevent you from leaving? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="prevent_leave_suggestion">
                                    <br>

                                    <!-- Question 6 -->
                                    <label>6. Would you recommend this company to a friend as a good place to work? <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="recommend_to_friend">
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
                                    <br>

                                    <!-- New Location -->
                                    <label>Location <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="new_job_location">
                                    <br>

                                    <!-- New Designation -->
                                    <label>Designation <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="new_job_designation">
                                    <br>

                                    <!-- Compensation Hike -->
                                    <label>% Hike in compensation <span class="danger">*</span></label>
                                    <input class="form-control" type="text" name="hike_in_compensation">
                                    <br>

                                    <!-- Other Benefits -->
                                    <label>Other benefits</label>
                                    <input class="form-control" type="text" name="new_job_benefits">
                                </div>
                                <!-- Submit and Reset Buttons -->
                                <button class="btn btn-primary mt-4" type="reset">Reset</button>
                                <button class="btn btn-success mt-4" type="submit">Submit</button>
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
    document.getElementById("submitBtn").addEventListener("click", function (e) {
    e.preventDefault();  // Prevent default form submission behavior

    // Collect data from the form fields
    const formData = new FormData(document.getElementById("exitForm"));

    // Add checkbox data
    // (you will need to collect data from your tables, this example adds simple checkbox data)
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            formData.append(checkbox.name, checkbox.value);
        }
    });

    // Optionally, you can convert this FormData to a plain object for easier handling
    let plainFormData = {};
    formData.forEach((value, key) => {
        plainFormData[key] = value;
    });

    // Example of sending the data to a controller (adjust the URL as needed)
    fetch('/submit-exit-form', {
        method: 'POST',
        body: JSON.stringify(plainFormData),
        headers: {
            'Content-Type': 'application/json', // Send JSON data
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Form submitted successfully!");
            // Optionally, reset form or redirect
            document.getElementById("exitForm").reset();
        } else {
            alert("There was an error submitting the form. Please try again.");
        }
    })
    .catch(error => {
        console.error("Error submitting form:", error);
        alert("An error occurred. Please try again later.");
    });
});

</script>
