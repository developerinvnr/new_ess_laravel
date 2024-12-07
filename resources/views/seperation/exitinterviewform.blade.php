@include('seperation.head')
@include('seperation.header')
@include('seperation.sidebar')

<body class="mini-sidebar">
	<div class="loader" style="display: none;">
	  <div class="spinner" style="display: none;">
		<img src="./SplashDash_files/loader.gif" alt="">
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
                <form>
                <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><b>Exit form</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row exitform">
                            <div class="col-md-6">
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
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>b) Health problems</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>c) Own business</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>b) Lack of challenge in the work.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>c) Low Promotional opportunities.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>d) Job allotted not matching with job aspirations.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>e) Better job/ better prospects</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>f) Higher studies</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table border">
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
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>b) Insecurity and uncertainty in day-to-day working</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>c) Lack of communication.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>d) Delays in decision-making.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>e) Unfair treatment, partiality</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
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
                                            <td>a) Unclean Surroundings </td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>b) Hardship/ Job is too stressful</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>c) Working hours.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>d) Job involves too much of travel.</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>e) Non Fulfillment of commitments by the company</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                            <td>a) Inadequate pay & Increments in relation to the industry </td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>b) Inadequate incentives and bonus</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
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
                                            <td>a) Ambiguous role </td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td>b) No clarity in reporting relations</td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                            <td><input type="checkbox"></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 exitformsec">
                <div class="card">
                    <div class="card-header">
                        <h5><b>Kindly fill in the given questions</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="">
                            <label>1. What are your primary reasons for leaving? <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>2. What did you find most satisfying about your job? <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>3. What did you find most dissatisfying regarding your job? <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>4. Were there any company policies or procedures that made your work more difficult?<span class="danger">*</span></label>
                            <input class="form-control" type="text /">

                            <br>
                            <label>5. Is there anything the company could have done to prevent you from leaving? <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>6. Would you recommend this company to a friend as a good place to work? <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                        </div>
                        
                    </div>
                </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 exitformsec">
                <div class="card">
                    <div class="card-header">
                        <h5><b>About your new job</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="">
                            <label>Name of the Company<span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>Location <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>Designation <span class="danger">*</span></label>
                            <input class="form-control" type="text /">
                            <br>
                            <label>% Hike in compensation<span class="danger">*</span></label>
                            <input class="form-control" type="text /">

                            <br>
                            <label>Other benefits</label>
                            <input class="form-control" type="text /">
                          
                        </div>
                        <button class="btn btn-primary mt-4" type="reset">Reset</button>
                        <button class="btn btn-success mt-4" type="submit">Submit</button>
                    </div>
                    
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
    const employeeId = {{ Auth::user()->EmployeeID }};
	const repo_employeeId = {{ Auth::user()->EmployeeID }};
	const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
	const queryactionUrl = "{{ route("employee.query.action") }}";
	const getqueriesUrl = "{{ route("employee.queries") }}";

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>