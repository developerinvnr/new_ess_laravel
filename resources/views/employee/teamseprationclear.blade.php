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
                    <div class="mfh-machine-profile">
						<ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
							<li class="nav-item">
								<a style="color: #0e0e0e;" class="nav-link active" id="reporting-tab1" data-bs-toggle="tab" href="#reportingtab" role="tab" aria-controls="reporting" aria-selected="true">Reporting</a>
							</li>
							<li class="nav-item">
								<a style="color: #0e0e0e;" class="nav-link" id="reviewer-tab2" data-bs-toggle="tab" href="#reviewer" role="tab" aria-controls="reviewer" aria-selected="false">HOD/Reviewer</a>
							</li>
						</ul>
					
                    <div class="tab-content ad-content2" id="myTabContent2">
                        <div class="tab-pane fade active show" id="reportingtab" role="tabpanel">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><b>Team: Employee Separation Data</b></h5>

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
                                    <th>Releiving Date</th>
                                    <th>Resignation Reason</th>
                                    <th>Employee Details</th>
                                    <th>Separation Detals</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $index = 1;
                            @endphp
                            @forelse($seperationData as $separation)
                                @foreach($separation['seperation'] as $data)
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
                                    <td><a data-bs-toggle="modal" data-bs-target="#empdetails"
                                        href="">Click</a></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No separation data available for any employee.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        </table>
                    </div>
                </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><b>IT Clearance</b></h5>
    
                        </div>
                        <div class="card-body table-responsive">
                            <!-- Table for displaying separation data -->
                            <table class="table table-bordered">
                                                <thead style="background-color:#cfdce1;">
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>ES</th>
                                                        <th>Employee Name</th>
                                                        <th>Department</th>
                                                        <th>Email</th>
                                                        <th>Resignation Date</th>
                                                        <th>Relieving Date</th>
                                                        <th>Resignation Status</th>
                                                        <th>Clearance Status</th>
                                                        <th>History</th>
                                                        <th>Clearance form</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
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
                                                </tbody>
                                            </table>
                        </div>
                    </div>
                    </div>
                        </div>

                        <div class="tab-pane fade " id="reviewer" role="tabpanel">
no data
                        </div>
                    </div>
                </div>
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
                            <li><b> Name: D Chandra Reddy Sekhara</b></li>
                            <li> <b> Designation: Area Sales Coordinator</b></li>
                            <li> <b> Location:	 Jaipur</b></li>
                            <li> <b> Qualification:	 M.Sc</b></li>
                            <li> <b> VNR Exp.:	 4.2 year</b></li>
                            <li> <b> Reporting Mgr:	 Mr. Dinesh Swami</b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: 145</b></li>
                            <li> <b> Department:	 Sales</b></li>
                            <li> <b> DOJ: 01-10-2020</b></li>
                            <li> <b> Age: 31.1 year</b></li>
                            <li> <b> Total Exp.: 10.22 year</b></li>
                            <li> <b> Reviewer: Mr. Dinesh Swami</b></li>
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

@include('employee.footer');
<script>
    const employeeId = {{ Auth::user()->EmployeeID }};
	const repo_employeeId = {{ Auth::user()->EmployeeID }};
	const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
	const queryactionUrl = "{{ route("employee.query.action") }}";
	const getqueriesUrl = "{{ route("employee.queries") }}";

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>