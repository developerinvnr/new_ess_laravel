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
                                    <li class="breadcrumb-link active">My Team - Confirmation</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 @include('employee.menuteam')
                <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>Confirmation</b></h5>
                        <div class="flex-shrink-0" style="float:right;">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="base-class" class="form-label text-muted mt-1">HOD/Reviewer</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="base-class">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table text-center">
                            <thead >
                                <tr>
                                    <th>Sn</th>
                                    <th>Name</th>
                                    <th>EC</th>
                                    <th>Designation</th>
                                    <th>Grade</th>
                                    <th>Function</th>
                                    <th>Vertical</th>
                                    <th>Depatments</th>
                                    <th>Sub Departments</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Action</th>
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
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><a data-bs-toggle="modal" data-bs-target="#confirmdetails"
                                        href="">Confirm Form</a></td>
                                    
                                </tr>
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
	
    <div class="modal fade show" id="confirmdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Ravi Kumar Confirmation</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Location:	 <span>Jaipur</span></b></li>
                            <li> <b> Grade:	 <span>J4</span></b></li>
                            <li> <b> Date of joining:	<span> 02-08-2024</span></b></li>
                           
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                            <li> <b> Designation:: <span>Area Business Manager</span></b></li>
                            <li> <b> Date Of Confirmation:: <span>02-01-2025</span></b></li>
                        </ul>
                    </div>
                    <div class="mt-2 mb-2">
                        <h4>GUIDLINES</h4>
<p> 1. The objective of this appraisal is to evaluate the suitablility of an employee for confirmation in employment.</p>
<p> 2. This appraisal form is to be filled in by the employee&#39;s immediate superior and the same shall be reviewed
by the Departmental Head.</p>
<p><b>Following are the Organizational, job and Personality factors applicable to employee. The defination and the
    rating scale for A, B, C, D for each factor is clearly detailed below:</b></p>
                    </div>
                </div>
                
                
                <div class="row">
                    <form>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">Communication</h4>
                                    <p><b>1. Clarity of thought and expression; skills and desire of sharing relevant
                                        information with all concerned (upward, lateral, downward).</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Excellent clarity of thought and expression; Uses
                                        all channels and shares relevant information.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Good in expression shares information with all
                                            concerned.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C Has desire to share information, but lacks skills to
                                            do so.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D Keep things to him. Lacks desire and skills to
                                            share information.</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">JOB KNOWLEDGE:</h4>
                                    <p><b>2. Knowledge needed to perform the job (s); ability to grasp concepts and issues;
                                        assimilation of varied information.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Has thorough know ledge of primary and related
                                            jobs; quick in assimilation of varied information, concepts and issues.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Has know ledge of various aspects of the jobs
                                            good in assimilation of concepts, issues.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Fair knowledge of the job, but requires more
                                            training and experience, fair assimilation of
                                            information.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. Needs frequents instructions; poor ability to grasp
                                            concepts and Issues.</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">OUTPUT:</h4>
                                    <p><b>3. Quantity of work based on recognized standards consistency &amp; regularity of work; Result
                                        orientation.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Exceptionally high output Consistent, regular and
                                            highly result oriented.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Always gives good I high output. Consistently
                                            result oriented.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Regularly meets recognized standards of output
                                            Mostly consistent producer.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. Generally low output. Below recognized standards
                                            Inconsistent. Not regular.</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">INITIATIVE:</h4>
                                    <p><b>4. Takes the first step. Proactive. Creates and is alert to opportunities.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Always takes the first step. Is proactive and creates
                                            opportunities.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Alert to opportunities. Takes the first step most of
                                            the times.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Works on his own. Takes the first step when
                                            confident.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. Does not look for opportunities. Routine worker.
                                            Needs goading/persuasion.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">INTERPERSONAL SKILLS:</h4>
                                    <p><b>5. Degree of co-operation with team members; Ability to interact effectively
                                        with superiors, peers and subordinates.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Very effective team member, co-operative;
                                            Respected and liked by superiors, peers and subordinates. High interactive ability at all levels.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Co-operative ; Respected. Has good relations with
                                            subordinate, peers and superiors.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Generally accepted as a team member.
                                            Occasionally abrasive in dealing with superior, peer and subordinate.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. A loner, Has difficulty in a group/team.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">PROBLEM SOLVING:</h4>
                                    <p><b>6. Ability to go to the core of the problem. Makes a correct diagnosis with
                                        relevant.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Quickly goes to the core of the problem and makes
                                            a correct diagnosis, with relevant available data in all situations.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. In most situations, goes to the core of the problem
                                            and makes a correct diagnosis available with limited data.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Has ability to solve problem of routine nature
                                            Requires assistance in solving problem.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. Requires help to diagnose even problems of
                                            routine nature.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">ATTITUDE TOWARDS ORGANIZATION/WORK/AUTHORITY:</h4>
                                    <p><b>7. Attitudinal pre-disposition. Approach to work sensitivity and temperament.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Always positive in outlook towards
                                            organization/work/authority. Respects authority.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Mostly positive in outlook towards
                                            organization/work/authority.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Generally positive in outlook towards
                                            work/subordinates.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. Does not have a positive outlook/ approach to
                                            organization/work. Indifferent to authority.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">ATTENDANCE &amp; PUNCTUALITY REGULARITY OF ATTENDANCE</h4>
                                    <p><b>8. Punctuality related to work place and work/ assigned tasks.</b></p>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >A. Highly regular in attendance and punctuality.
                                            Highly work/ assignment oriented.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >B. Mostly regular in attendance. Reports on time
                                            Conscientious to assignments.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >C. Generally regular in attendance and quite punctual
                                            in meeting work norms.</div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" >D. Poor attendance and punctuality. Casual attitude to
                                            work.</div>
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
                                        <div class="col-md-6 mt-2 mb-2"><b>Strength:</b> <textarea class="form-control"></textarea></div>
                                        <div class="col-md-6 mt-2 mb-2"><b>Improvement:</b> <textarea class="form-control"></textarea></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">OVERALL RATING</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row">
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>1</b> Unsatisfactory</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>2</b> Needs Improvement</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>2.5</b> Satisfactory</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>3</b> Competent</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>3.5</b> Commendable</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>4</b> Extraordinary</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>4.5</b> Outstanding</div>
                                        <div class="col-md-3 mt-2 mb-2"><input name="communication" type="radio" ><b>5</b> Exemplary</div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title" style="background-color:#ddd;">
                                    <h4 class="has-btn">RECOMMENDATIONS:</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center confirmation-box">
                                    <div class="row" style="width:100%;">
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" ><b>Confirmed on date</b></div>
                                        <div class="col-md-6 mt-2 mb-2"><input name="communication" type="radio" ><b>Extend probation</b></div>
                                        <div class="col-md-6 mt-2 mb-2"><b>If probation to be extended, mention reason:</b> <textarea class="form-control"></textarea></div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                    data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-success" type="submit">Final Submit</button>
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
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>