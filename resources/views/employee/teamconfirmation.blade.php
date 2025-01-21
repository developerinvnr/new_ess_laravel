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
                                    <li class="breadcrumb-link active">My Team - Confirmation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 @include('employee.menuteam')
                <div class="row">
                @if($isReviewer)
                <div class="flex-shrink-0" style="float:right;">
                                                    <form method="GET" action="{{ route('teamconfirmation') }}">
                                                        @csrf
                                                        <div class="form-check form-switch form-switch-right form-switch-md">
                                                            <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2"  style="float:right;">HOD/Reviewer</label>
                                                            <input 
                                                                class="form-check-input" 
                                                                type="checkbox" 
                                                                name="hod_view" 
                                                                id="hod-view" 
                                                                {{ request()->has('hod_view') ? 'checked' : '' }} 
                                                                onchange="this.form.submit();" 
                                                            >
                                                        </div>
                                                    </form>
                                                </div>
                                                @endif
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>Confirmation</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>Sn</th>
                                <th>EC</th>
                                <th style="text-align:left;">Name</th>
                                <th>Designation</th>
                                <th>Grade</th>
                                <th>Vertical</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Confirm Date</th>
                                @if(request()->get('hod_view') != 'on')
                                                            <th>Action</th>
                                                            @endif
                                                            @if(request()->get('hod_view') == 'on')
                                                            <th></th>
                                                            @endif
    										</tr>
                            </tr>
                        </thead>
                        <tbody>
    @forelse ($employeeDataConfirmation as $index => $employee)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $employee->EmpCode }}</td>
            <td style="text-align:left;">{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</td>
            <td>{{ $employee->designation_name }}</td>
            <td>{{ $employee->grade_name }}</td>
            <td>{{ $employee->vertical_name ?? 'N/A' }}</td> <!-- If VerticalName is null, show 'N/A' -->
            <td>{{ $employee->department_code }}</td>
                <td>
        @php
            // Fetch the record from the hrm_employee_confletter table using EmployeeID
            $nocRecord = \DB::table('hrm_employee_confletter')->where('EmployeeID', $employee->EmployeeID)->first();
        @endphp

        @if($nocRecord)
            @if($nocRecord->draft_submit === 'Y' && $nocRecord)
                <span class="text-warning">Draft</span>
            @elseif($nocRecord->final_submit === 'Y' && $nocRecord)
                <span class="text-danger">Submitted</span>
            @elseif($nocRecord->SubmitStatus =='Y')
                <span class="text-success">Approved</span>
            @endif
        @else
            <span class="text-warning">Pending</span>
        @endif
    </td>
    <td>
    @if($employee->DateConfirmation && $employee->DateConfirmation !== '0000-00-00')
        {{ \Carbon\Carbon::parse($employee->DateConfirmation)->format('d-m-Y') }}
    @else
        -  <!-- If it's an invalid or default date, show '-' -->
    @endif
</td>
    @if($employee->direct_reporting == 'true')
        <td>
            @if($employee->isRecentlyConfirmed)
            <a data-bs-toggle="modal" data-bs-target="#confirmdetails" 
                href="javascript:void(0);" 
                onclick="populateConfirmationModal('{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}', '{{ $employee->EmpCode }}', '{{ $employee->designation_name }}', '{{ $employee->grade_name }}', '{{ $employee->DateJoining }}', '{{ $employee->DateConfirmation }}', '{{ $employee->city_village_name }}', '{{ $employee->department_code }}','{{ $employee->EmployeeID}}')">
                Confirm Form
            </a>
            @endif
        </td>
        @endif
        
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No data found</td>
        </tr>
    @endforelse
</tbody>

                    </table>
                    </div>
                </div>
                </div>
                </div>
                
				@include('employee.footerbottom')

            </div>
        </div>
    </div>
	
    <div class="modal fade show" id="confirmdetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3"><span id="employeeNamee"></span> Confirmation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                <div class="col-md-6">
                        <ul>
                            <li><b>Name: <span id="employeeName"></span></b></li>
                            <li><b>Headquater: <span id="hqName"></span></b></li>
                            <li><b>Grade: <span id="employeeGrade"></span></b></li>
                            <li><b>Date of joining: <span id="joiningDate"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b>Employee Code: <span id="empCode"></span></b></li>
                            <li><b>Department: <span id="employeeDept"></span></b></li>
                            <li><b>Designation: <span id="employeeDesignation"></span></b></li>
                            <li><b>Date of Confirmation: <span id="confirmationDate"></span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-12 mt-3 mb-2">
                        <h4>GUIDLINES</h4>
                        <p> 1. The objective of this appraisal is to evaluate the suitablility of an employee for confirmation in employment.</p>
                        <p> 2. This appraisal form is to be filled in by the employee&#39;s immediate superior and the same shall be reviewed
                        by the Departmental Head.</p>
                        <p><b>Following are the Organizational, job and Personality factors applicable to employee. The defination and the
                            rating scale for A, B, C, D for each factor is clearly detailed below:</b></p>
                    </div>
                </div>
                
                
                <div class="row">
                <form id="employeeconfirmationForm">
                    @csrf
                    <input type="hidden" id="employeeId" name="employeeId">
                    <input type="hidden" id="confirmationdate" name="confirmationdate">


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">Communication</h4>
                                <p><b>1. Clarity of thought and expression; skills and desire of sharing relevant information with all concerned (upward, lateral, downward).</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="communication_clarity" onclick="updateScore()" type="radio" value="40"> A. Excellent clarity of thought and expression; Uses all channels and shares relevant information.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="communication_clarity" onclick="updateScore()" type="radio" value="30"> B. Good in expression shares information with all concerned.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="communication_clarity" onclick="updateScore()" type="radio" value="20"> C. Has desire to share information, but lacks skills to do so.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="communication_clarity" onclick="updateScore()" type="radio" value="10"> D. Keeps things to him. Lacks desire and skills to share information.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">JOB KNOWLEDGE:</h4>
                                <p><b>2. Knowledge needed to perform the job (s); ability to grasp concepts and issues; assimilation of varied information.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="job_knowledge" type="radio" onclick="updateScore()" value="80"> A. Has thorough knowledge of primary and related jobs; quick in assimilation of varied information, concepts, and issues.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="job_knowledge" type="radio" onclick="updateScore()" value="60"> B. Has knowledge of various aspects of the jobs; good in assimilation of concepts, issues.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="job_knowledge" type="radio" onclick="updateScore()" value="40"> C. Fair knowledge of the job, but requires more training and experience, fair assimilation of information.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="job_knowledge" type="radio" onclick="updateScore()" value="20"> D. Needs frequent instructions; poor ability to grasp concepts and issues.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">OUTPUT:</h4>
                                <p><b>3. Quantity of work based on recognized standards consistency &amp; regularity of work; Result orientation.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="output" type="radio" onclick="updateScore()" value="80"> A. Exceptionally high output; Consistent, regular, and highly result-oriented.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="output" type="radio" onclick="updateScore()" value="60"> B. Always gives good/high output; Consistently result-oriented.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="output" type="radio" onclick="updateScore()" value="40"> C. Regularly meets recognized standards of output; Mostly consistent producer.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="output" type="radio" onclick="updateScore()" value="20"> D. Generally low output; Below recognized standards; Inconsistent. Not regular.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">INITIATIVE:</h4>
                                <p><b>4. Takes the first step. Proactive. Creates and is alert to opportunities.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="initiative" type="radio" onclick="updateScore()" value="40"> A. Always takes the first step. Is proactive and creates opportunities.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="initiative" type="radio" onclick="updateScore()" value="30"> B. Alert to opportunities. Takes the first step most of the times.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="initiative" type="radio" onclick="updateScore()" value="20"> C. Works on his own. Takes the first step when confident.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="initiative" type="radio" onclick="updateScore()" value="10"> D. Does not look for opportunities. Routine worker. Needs goading/persuasion.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">INTERPERSONAL SKILLS:</h4>
                                <p><b>5. Degree of co-operation with team members; Ability to interact effectively with superiors, peers and subordinates.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="interpersonal_skills" type="radio" onclick="updateScore()" value="40"> A. Very effective team member, co-operative; Respected and liked by superiors, peers, and subordinates. High interactive ability at all levels.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="interpersonal_skills" type="radio" onclick="updateScore()" value="30"> B. Co-operative; Respected. Has good relations with subordinates, peers, and superiors.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="interpersonal_skills" type="radio" onclick="updateScore()" value="20"> C. Generally accepted as a team member. Occasionally abrasive in dealing with superior, peer, and subordinate.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="interpersonal_skills" type="radio" onclick="updateScore()" value="10"> D. A loner. Has difficulty in a group/team.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">PROBLEM SOLVING:</h4>
                                <p><b>6. Ability to go to the core of the problem. Makes a correct diagnosis with relevant.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="problem_solving" onclick="updateScore()" type="radio" value="40"> A. Quickly goes to the core of the problem and makes a correct diagnosis, with relevant available data in all situations.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="problem_solving" onclick="updateScore()" type="radio" value="30"> B. In most situations, goes to the core of the problem and makes a correct diagnosis available with limited data.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="problem_solving" onclick="updateScore()" type="radio" value="20"> C. Has ability to solve problems of routine nature; Requires assistance in solving problems.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="problem_solving" onclick="updateScore()" type="radio" value="10"> D. Requires help to diagnose even problems of routine nature.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">ATTITUDE TOWARDS ORGANIZATION/WORK/AUTHORITY:</h4>
                                <p><b>7. Attitudinal pre-disposition. Approach to work sensitivity and temperament.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attitude" onclick="updateScore()" type="radio" value="40"> A. Always positive in outlook towards organization/work/authority. Respects authority.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attitude" onclick="updateScore()" type="radio" value="30"> B. Mostly positive in outlook towards organization/work/authority.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attitude" onclick="updateScore()" type="radio" value="20"> C. Generally positive in outlook towards work/subordinates.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attitude" onclick="updateScore()" type="radio" value="10"> D. Does not have a positive outlook/approach to organization/work. Indifferent to authority.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card chart-card">
                            <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                <h4 class="has-btn mb-2">ATTENDANCE & PUNCTUALITY REGULARITY OF ATTENDANCE</h4>
                                <p><b>8. Punctuality related to work place and work/ assigned tasks.</b></p>
                            </div>
                            <div class="card-body dd-flex align-items-center confirmation-box">
                                <div class="row">
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attendance_punctuality" onclick="updateScore()" type="radio" value="40"> A. Highly regular in attendance and punctuality. Highly work/assignment-oriented.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attendance_punctuality" onclick="updateScore()" type="radio" value="30"> B. Mostly regular in attendance. Reports on time. Conscientious to assignments.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attendance_punctuality" onclick="updateScore()" type="radio" value="20"> C. Generally regular in attendance and quite punctual in meeting work norms.
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <input name="attendance_punctuality" onclick="updateScore()" type="radio" value="10"> D. Poor attendance and punctuality. Casual attitude to work.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">Employee&#39;s Strength /Improvement:</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><b>Strength:</b> <textarea name="strength" class="form-control"></textarea></div>
                                        <div class="col-md-6 mt-2 mb-2"><b>Improvement:</b> <textarea  name="improvement" class="form-control"></textarea></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Overall Rating Section -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="overall-rating">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">OVERALL RATING</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="1" id="rating1"><b>1</b> Unsatisfactory
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="2" id="rating2"><b>2</b> Needs Improvement
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="2.5" id="rating2.5"><b>2.5</b> Satisfactory
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="3" id="rating3"><b>3</b> Competent
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="3.5" id="rating3.5"><b>3.5</b> Commendable
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="4" id="rating4"><b>4</b> Extraordinary
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="4.5" id="rating4.5"><b>4.5</b> Outstanding
                                        </div>
                                        <div class="col-md-3 mt-2 mb-2">
                                            <input name="overallRating" type="radio" value="5" id="rating5"><b>5</b> Exemplary
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recommendations Section -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" id="recommendations" style="display:none;">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">RECOMMENDATIONS:</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row" style="width:100%;">
                                        <div class="col-md-6 mt-2 mb-2" id="confirmedOnDate">
                                            <input name="recommendation" type="radio" id="confirmedOnDateRadio" value="1"><b>Confirmed on date</b>
                                        </div>
                                        <div class="col-md-6 mt-2 mb-2" id="extendProbation">
                                            <input name="recommendation" type="radio" id="extendProbationRadio" value="2"><b>Extend probation</b>
                                        </div>
                                        <div class="col-md-6 mt-2 mb-2" id="probationReason" style="display:none;">
                                            <b>If probation to be extended, mention reason:</b>
                                            <textarea class="form-control" name="probationReason"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </form>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit" id="save-draft">Save as Draft</button>
                <button class="btn btn-success" type="submit" id="save-final">Final Submit</button>
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
        function populateConfirmationModal(name, empCode, designation, grade, joiningDate, confirmationDate, hqName, deptCode,employeeId) {
        // Populate modal fields with the selected employee's data
        document.getElementById('employeeName').innerText = name;
        document.getElementById('employeeNamee').innerText = name;
        document.getElementById('employeeId').value = employeeId; // Set the value of hidden input field
        document.getElementById('confirmationdate').value = confirmationDate; // Set the value of hidden input field
        document.getElementById('empCode').innerText = empCode;
        document.getElementById('employeeDesignation').innerText = designation;
        document.getElementById('employeeGrade').innerText = grade;
        document.getElementById('joiningDate').innerText = formatDate(joiningDate);
        document.getElementById('confirmationDate').innerText = formatDate(confirmationDate);
        document.getElementById('hqName').innerText = hqName;
        document.getElementById('employeeDept').innerText = deptCode;


         
    // Fetch employee-specific data (e.g., from a backend)
    fetch(`/get-employee-confirmation/${employeeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Populate form fields
                populateForm(data.data);
            } 
            // else {
            //     alert('No data found for this employee');
            // }
        })
        .catch(error => console.error('Error:', error));
    }

// Function to populate the form with the data fetched from the backend
function populateForm(data) {
    console.log(data);

   // 1. Populate communication clarity radio buttons based on the backend data
   const communicationClarityValue = data.Communi;  // 'B' in this case (from the backend)
   const jobknowValue = data.JobKnowl;  // 'B' in this case (from the backend)
   const outputValue = data.OutPut;  // 'B' in this case (from the backend)
   const initiativeValue = data.Initiative;  // 'B' in this case (from the backend)
   const InterSkillValue = data.InterSkill;  // 'B' in this case (from the backend)
   const ProblemSolveValue = data.ProblemSolve;  // 'B' in this case (from the backend)
   const AttitudeValue = data.Attitude;  // 'B' in this case (from the backend)
   const AttendanceValue = data.Attendance;  // 'B' in this case (from the backend)

    // Create a mapping of the communication clarity values to their corresponding radio button values
    const communicationClarityMap = {
        'A': '40',   // A = 40
        'B': '30',   // B = 30
        'C': '20',   // C = 20
        'D': '10'    // D = 10
    };
    const jobknowledgemap = {
        'A': '80',   // A = 40
        'B': '60',   // B = 30
        'C': '40',   // C = 20
        'D': '20'    // D = 10
    };
    const outputmap = {
        'A': '80',   // A = 40
        'B': '60',   // B = 30
        'C': '40',   // C = 20
        'D': '20'    // D = 10
    };
    const initiativeClarityMap = {
        
        'A': '40',   // A = 40
        'B': '30',   // B = 30
        'C': '20',   // C = 20
        'D': '10'    // D = 10
    };
    const InterSkillClarityMap = {
        'A': '40',   // A = 40
        'B': '30',   // B = 30
        'C': '20',   // C = 20
        'D': '10'    // D = 10
    };
    const ProblemSolveMap = {
        'A': '40',   // A = 40
        'B': '30',   // B = 30
        'C': '20',   // C = 20
        'D': '10'    // D = 10
    };
    const AttitudeSolveMap = {
        'A': '40',   // A = 40
        'B': '30',   // B = 30
        'C': '20',   // C = 20
        'D': '10'    // D = 10
    };
    const AttendanceMap = {
        'A': '40',   // A = 40
        'B': '30',   // B = 30
        'C': '20',   // C = 20
        'D': '10'    // D = 10
    };
    // If data.Commi is available, select the corresponding radio button
    if (communicationClarityValue && communicationClarityMap[communicationClarityValue]) {
        const selectedValue = communicationClarityMap[communicationClarityValue];
        const radioButton = document.querySelector(`input[name="communication_clarity"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
      // If data.Commi is available, select the corresponding radio button
      if (jobknowValue && jobknowledgemap[jobknowValue]) {
        const selectedValue = jobknowledgemap[jobknowValue];
        const radioButton = document.querySelector(`input[name="job_knowledge"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
      // If data.Commi is available, select the corresponding radio button
      if (outputValue && outputmap[outputValue]) {
        const selectedValue = outputmap[outputValue];
        const radioButton = document.querySelector(`input[name="output"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
     // If data.Commi is available, select the corresponding radio button
     if (initiativeValue && initiativeClarityMap[initiativeValue]) {
        const selectedValue = initiativeClarityMap[initiativeValue];
        const radioButton = document.querySelector(`input[name="initiative"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
     // If data.Commi is available, select the corresponding radio button
     if (InterSkillValue && InterSkillClarityMap[InterSkillValue]) {
        const selectedValue = InterSkillClarityMap[InterSkillValue];
        const radioButton = document.querySelector(`input[name="interpersonal_skills"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
     // If data.Commi is available, select the corresponding radio button
     if (ProblemSolveValue && ProblemSolveMap[ProblemSolveValue]) {
        const selectedValue = ProblemSolveMap[ProblemSolveValue];
        const radioButton = document.querySelector(`input[name="problem_solving"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
     // If data.Commi is available, select the corresponding radio button
     if (AttitudeValue && AttitudeSolveMap[AttitudeValue]) {
        const selectedValue = AttitudeSolveMap[AttitudeValue];
        const radioButton = document.querySelector(`input[name="attitude"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
      // If data.Commi is available, select the corresponding radio button
      if (AttendanceValue && AttendanceMap[AttendanceValue]) {
        const selectedValue = AttendanceMap[AttendanceValue];
        const radioButton = document.querySelector(`input[name="attendance_punctuality"][value="${selectedValue}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
    }
    // Populate textareas if available
    document.querySelector('textarea[name="strength"]').value = data.EmpStrenght || '';
    document.querySelector('textarea[name="improvement"]').value = data.AreaImprovement || '';
    console.log(data.Rating);
    
// Assuming 'data' object contains the 'Rating' field
if (data.Rating) {
    const ratingValue = parseFloat(data.Rating);  // Converts "3.0" to 3.0

    // Display the rating section (if it's hidden)
    document.getElementById('overall-rating').style.display = 'block';

    // Dynamically select the radio button based on the Rating value
    const ratingRadioButton = document.querySelector(`input[name="overallRating"][value="${ratingValue}"]`);
    
    // If the radio button exists, mark it as checked
    if (ratingRadioButton) {
        ratingRadioButton.checked = true;

    }
    // Optionally, you can disable all radio buttons after selection
    disableAllRadios('overallRating');  // This disables the radio buttons in the 'overallRating' group
}
    // Handle recommendations (if applicable)
    handleRecommendations(data.Recommendation,data.Reason);

    // Set confirmation date (if available)
    // document.getElementById('confirmationdate').value = data.ConfDate || '';
     // Handle final submit or draft submit
     if (data.final_submit === 'Y') {
                                    $('input,textarea').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Hide the "Save as Draft" and "Final Submit" buttons
                                    $('.modal-footer #save-draft').hide();
                                                        $('.modal-footer #save-final').hide();
                                            }
}

// Function to handle recommendations
function handleRecommendations(recommendation,reason) {
    console.log(recommendation);
       // Get the recommendations section
       let recommendations = document.getElementById('recommendations');
    recommendations.style.display = 'block';  // Ensure recommendations section is displayed
    if (recommendation == '1') {
        document.getElementById('confirmedOnDateRadio').checked = true;
        document.getElementById('extendProbation').checked = false;
        document.getElementById('extendProbation').style.display = 'none';
        document.getElementById('probationReason').style.display = 'none';
        disableAllRadios('confirmedOnDateRadio');  // This disables the radio buttons in the 'overallRating' group
    } 
    else if (recommendation == '2') {
        document.getElementById('extendProbationRadio').checked = true;
        document.getElementById('confirmedOnDateRadio').checked = false;
        document.getElementById('confirmedOnDate').style.display = 'none';
        document.getElementById('probationReason').style.display = 'block';
        document.querySelector('textarea[name="probationReason"]').value = reason || '';
        document.querySelector('textarea[name="probationReason"]').value = reason || ''; // Ensure reason is populated
        disableAllRadios('extendProbationRadio');  // This disables the radio buttons in the 'overallRating' group

    }
     else {
        document.getElementById('confirmedOnDateRadio').checked = false;
        document.getElementById('extendProbation').checked = false;
        document.getElementById('probationReason').style.display = 'none';
    }
}

    function formatDate(dateString) {
    // Create a new Date object from the provided date string
    const date = new Date(dateString);
    
    // Get the day, month, and year
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Month is zero-based, so add 1
    const year = String(date.getFullYear()).slice(-2); // Get last 2 digits of the year

    // Return formatted date as 'dd-mm-yy'
    return `${day}-${month}-${year}`;
}
// Function to update the total score when a radio button is selected
function updateScore() {
    let totalScore = 0;

    // Calculate the score based on selected values for various categories
    let communication_clarity = document.querySelector('input[name="communication_clarity"]:checked');
    if (communication_clarity) totalScore += parseInt(communication_clarity.value);

    let jobKnowledge = document.querySelector('input[name="job_knowledge"]:checked');
    if (jobKnowledge) totalScore += parseInt(jobKnowledge.value);

    let output = document.querySelector('input[name="output"]:checked');
    if (output) totalScore += parseInt(output.value);

    let initiative = document.querySelector('input[name="initiative"]:checked');
    if (initiative) totalScore += parseInt(initiative.value);

    let interpersonalSkills = document.querySelector('input[name="interpersonal_skills"]:checked');
    if (interpersonalSkills) totalScore += parseInt(interpersonalSkills.value);

    let problemSolving = document.querySelector('input[name="problem_solving"]:checked');
    if (problemSolving) totalScore += parseInt(problemSolving.value);

    let attitude = document.querySelector('input[name="attitude"]:checked');
    if (attitude) totalScore += parseInt(attitude.value);

    let attendancePunctuality = document.querySelector('input[name="attendance_punctuality"]:checked');
    if (attendancePunctuality) totalScore += parseInt(attendancePunctuality.value);

    // Log the total score (for testing)
    console.log("Total Score: ", totalScore);

    // Now select the appropriate radio button in the "Overall Rating" section based on totalScore
    selectRatingBasedOnScore(totalScore);
}

// Function to select rating based on totalScore
function selectRatingBasedOnScore(score) {
    // Show the overall rating section (unhide it)
    document.getElementById('overall-rating').style.display = 'block';

    // Reset all radio buttons for communication
    let radios = document.querySelectorAll('input[name="overallRating"]');
    radios.forEach(function (radio) {
        radio.checked = false; // Uncheck all radios initially
        radio.disabled = false; // Enable all radios initially
    });

    // Select and disable the appropriate radio button based on score
    if (score <= 150) {
        document.getElementById('rating1').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(true);  // Show "Extend probation" option
    } else if (score >= 151 && score <= 180) {
        document.getElementById('rating2').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(true);  // Show "Extend probation" option
    } else if (score >= 181 && score <= 220) {
        document.getElementById('rating2.5').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(true);  // Show "Extend probation" option
    } else if (score >= 221 && score <= 270) {
        document.getElementById('rating3').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(false);  // Show "Confirmed on date" option
    } else if (score >= 271 && score <= 310) {
        document.getElementById('rating3.5').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(false);  // Show "Confirmed on date" option
    } else if (score >= 311 && score <= 350) {
        document.getElementById('rating4').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(false);  // Show "Confirmed on date" option
    }
    else if (score >= 351 && score <= 380) {
        document.getElementById('rating5').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(false);  // Show "Confirmed on date" option
    }
    
    else if (score >= 381) {
        document.getElementById('rating5').checked = true;
        disableAllRadios('overallRating');
        showRecommendations(false);  // Show "Confirmed on date" option
    }
}

// Function to disable all radio buttons
function disableAllRadios(radioGroupName) {
    let radios = document.querySelectorAll('input[name="' + radioGroupName + '"]');
    radios.forEach(function (radio) {
        radio.disabled = true; // Disable each radio button
    });
}

function showRecommendations(showExtendProbation) {
    // Get the recommendations section
    let recommendations = document.getElementById('recommendations');
    recommendations.style.display = 'block';  // Ensure recommendations section is displayed

    // Show/hide the specific recommendation options and enable/disable radio buttons
    if (showExtendProbation) {
        // Hide "Confirmed on date" and show "Extend probation"
        document.getElementById('confirmedOnDate').style.display = 'none';  // Hide "Confirmed on date"
        document.getElementById('extendProbation').style.display = 'block'; // Show "Extend probation"
        document.getElementById('probationReason').style.display = 'block'; // Show textarea for reason
        
        // Enable and auto-select the "Extend probation" radio button
        let extendRadio = document.querySelector('#extendProbation input');
        extendRadio.checked = true;  // Auto-select the radio button
        extendRadio.disabled = true;  // Disable it so it can't be changed

        // Disable the "Confirmed on date" radio button
        let confirmedRadio = document.querySelector('#confirmedOnDate input');
        confirmedRadio.disabled = true;  // Disable it so it can't be selected
    } else {
        // Show "Confirmed on date" and hide "Extend probation"
        document.getElementById('confirmedOnDate').style.display = 'block';  // Show "Confirmed on date"
        document.getElementById('extendProbation').style.display = 'none';  // Hide "Extend probation"
        document.getElementById('probationReason').style.display = 'none'; // Hide the textarea for reason

        // Enable and auto-select the "Confirmed on date" radio button
        let confirmedRadio = document.querySelector('#confirmedOnDate input');
        confirmedRadio.checked = true;  // Auto-select the radio button
        confirmedRadio.disabled = true;  // Disable it so it can't be changed

        // Disable the "Extend probation" radio button
        let extendRadio = document.querySelector('#extendProbation input');
        extendRadio.disabled = true;  // Disable it so it can't be selected
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Get the form and the hidden employeeId input
    const form = document.getElementById('employeeconfirmationForm');
    
    // Attach event listeners to the buttons
    const saveDraftButton = document.getElementById('save-draft');
    const saveFinalButton = document.getElementById('save-final');

    saveDraftButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        handleSubmit('draft');
    });

    saveFinalButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission
        handleSubmit('final');
    });

    // Function to handle form submission based on button clicked (Draft or Final)
    function handleSubmit(type) {
        // Create a FormData object
        let formData = new FormData(form);
        $('#loader').show(); 

        // Add additional hidden fields for 'Save as Draft' or 'Final Submit'
        formData.append('submit_type', type);

        // Capture the selected radio button for each section and append to the FormData
        captureRadioButtonData('communication_clarity', formData);
        captureRadioButtonData('job_knowledge', formData);
        captureRadioButtonData('output', formData);
        captureRadioButtonData('initiative', formData);
        captureRadioButtonData('interpersonal_skills', formData);
        captureRadioButtonData('problem_solving', formData);
        captureRadioButtonData('attitude', formData);
        captureRadioButtonData('attendance_punctuality', formData);
        captureRadioButtonData('overallRating', formData);

        // Handle recommendation section
        handleRecommendation(formData);

        // Use Fetch API or Ajax to submit the form data to the controller
        fetch('/employee/confirmation/store', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                            // Display success toast
                            toastr.success(data.message, 'Success', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 10000  // Duration for which the toast is visible (in ms)
                            });
                            // Optionally, you can hide the modal and reset the form after a delay
                            setTimeout(function () {
                                location.reload();
                            }, 2000);  // 2000 milliseconds = 2 seconds
                        } else {
                            // Display error toast
                            toastr.error(data.message, 'Error', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            });
                            $('#loader').hide(); 

                             // Optionally, you can hide the modal and reset the form after a delay
                            
                        }
        })
        .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request.');
                    });
    }

    // Function to capture the selected radio button value (A, B, C, D) and append it to FormData
    function captureRadioButtonData(name, formData) {
        const radios = document.getElementsByName(name);
        for (let i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                const value = radios[i].value; // Get the value (e.g., 40, 30, 20, 10)
                const label = getLabelFromValue(name, value); // Convert value to A, B, C, D based on the section
                formData.append(name + '_option', label); // Append the label (A, B, C, D)
                formData.append(name, value); // Append the numeric value (40, 30, etc.)
                break;
            }
        }
    }

    // Map numeric values to letter labels
    // function getLabelFromValue(value) {
    //     switch (value) {
    //         case '40':
    //             return 'A';
    //         case '30':
    //             return 'B';
    //         case '20':
    //             return 'C';
    //         case '10':
    //             return 'D';
    //         case '80':
    //             return 'A'; // job_knowledge specific
    //         case '60':
    //             return 'B'; // job_knowledge specific
    //         case '40':
    //             return 'C'; // job_knowledge specific
    //         case '20':
    //             return 'D'; // job_knowledge specific
    //         default:
    //             return '';
    //     }
    // }
    function getLabelFromValue(name, value) {
    if (name === 'job_knowledge') {
        switch (value) {
            case '80': return 'A'; // job_knowledge specific
            case '60': return 'B'; // job_knowledge specific
            case '40': return 'C'; // job_knowledge specific
            case '20': return 'D'; // job_knowledge specific
            default: return '';
        }
    } else if (name === 'output') {
        switch (value) {
            case '80': return 'A'; // output specific
            case '60': return 'B'; // output specific
            case '40': return 'C'; // output specific
            case '20': return 'D'; // output specific
            default: return '';
        }
    } else {
        // Default case for other fields
        switch (value) {
            case '40': return 'A';
            case '30': return 'B';
            case '20': return 'C';
            case '10': return 'D';
            default: return '';
        }
    }
}
    // Handle the recommendation section (e.g., confirmed on date or extend probation)
    function handleRecommendation(formData) {
        const recommendationRadios = document.getElementsByName('recommendation');
        for (let i = 0; i < recommendationRadios.length; i++) {
            if (recommendationRadios[i].checked) {
                formData.append('recommendation', recommendationRadios[i].id); // Store the recommendation selected
                break;
            }
        }

        // If "Extend probation" is selected, get the reason
        const probationReasonField = document.querySelector('#probationReason textarea');
        if (document.getElementById('extendProbationRadio').checked && probationReasonField) {
            const probationReason = probationReasonField.value;
            formData.append('probation_reason', probationReason);
        }
    }
});
document.addEventListener("DOMContentLoaded", function() {
    // Iterate through each row and check the status
    const statusLabels = document.querySelectorAll('.status-label');
    
    statusLabels.forEach(function(label) {
        const nocRecordStatus = label.getAttribute('data-noc-record');
        const status = label.getAttribute('data-status');
        
        const confirmLink = label.closest('td').querySelector('.confirm-form-link');
        
        // If no nocRecord or status is Approved, hide the "Confirm Form" link
        if (nocRecordStatus === 'none' || status === 'Approved') {
            if (confirmLink) {
                confirmLink.style.display = 'none';
            }
        } else {
            // Otherwise, show the "Confirm Form" link
            if (confirmLink) {
                confirmLink.style.display = 'inline-block';
                confirmLink.setAttribute('onclick', `populateConfirmationModal('${label.closest('tr').querySelector('.employee-name').innerText}', '${label.closest('tr').querySelector('.employee-code').innerText}')`);
            }
        }
    });
});



</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>
<style>
    #overall-rating, #recommendations {
    display: none;
}
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
}
    
