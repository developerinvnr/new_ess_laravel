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
                                    <td></td>
                                    
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
	
	

@include('employee.footer');
<script>
    const employeeId = {{ Auth::user()->EmployeeID }};
	const repo_employeeId = {{ Auth::user()->EmployeeID }};
	const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
	const queryactionUrl = "{{ route("employee.query.action") }}";
	const getqueriesUrl = "{{ route("employee.queries") }}";

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>