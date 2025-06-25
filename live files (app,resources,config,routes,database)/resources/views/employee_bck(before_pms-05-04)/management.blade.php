@include('employee.header')

<body class="mini-sidebar">
    @include('employee.sidebar')
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
                                        <a href="{{ route('dashboard') }}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">PMS - Reviewer </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">PMS Information</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('pms') }}"
                                    role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">Employee</span>
                                </a>
                            </li>
                            @if($exists_appraisel)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link " href="{{ route('appraiser') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Appraiser</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_reviewer)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link " href="{{ route('reviewer') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Reviewer</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_hod)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link "  href="{{ route('hod') }}" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">HOD</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_mngmt)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{ route('management') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Management</span>
                                </a>
                            </li>
                            @endif

                        </ul>
                    </div>

                    <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
                        <div class="mfh-machine-profile">

                        <ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" > 
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
								</li>
								@if ($year_kra->NewY_AllowEntry == 'Y')
								<li class="nav-item">
								<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-new-tab20" data-bs-toggle="tab" href="#KraTabNew" role="tab" aria-controls="KraTabnew" aria-selected="false">My Team KRA New 2025-26</a>
								</li>
                                    @endif
								<!-- <li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li> -->
								
							</ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                                <div class="tab-pane fade " id="KraTab" role="tabpanel">
                                <div class="row">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<div class="card">
													<div class="card-header" style="padding:0 !important;">
														<div class="float-end" style="margin-top:-50px;">
															
															<!-- Department Dropdown -->
															<!-- <select id="departmentDropdown">
																<option value="">Select Department</option>
																@foreach($employeeDetails->unique('department_name') as $employee)
																	<option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
																@endforeach
															</select> -->
															<!-- <select>
																<option>Select State</option>
																<option>All</option>
																<option>Sales</option>
															</select> -->
															 <!-- Headquarter Dropdown -->
															<!-- <select id="hqDropdown">
																<option value="">Select Head Quarter</option>
																@foreach($employeeDetails->unique('city_village_name') as $employee)
																	<option value="{{ $employee->city_village_name }}">{{ $employee->city_village_name }}</option>
																@endforeach
															</select> -->
														</div>
													</div>
													<div class="card-body table-responsive align-items-center">
													<table class="table table-pad" id="mang_table_list_curr">
														<thead>
															<tr>
																<th>SN.</th>
																<th>EC</th>
																<th>Name</th>
																<th>Department</th>
																<th>Designation</th>
																<th>HQ</th>
																<th>Employee</th>
																<th>Appraiser</th>
																<th>Reviewer</th>
																<th>HOD</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody id="employeeTableBody">
														
															@foreach ($employeeDetails as $index => $employee)
															<tr class="employee-row" data-department="{{ $employee->department_name }}" data-hq="{{ $employee->city_village_name }}">
																@php
																	
																		$latestPmsKra = DB::table('hrm_pms_kra as k1')
																		->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy','k1.AppRevertNote','k1.HODRevertNote')
																		->where('k1.EmployeeID', $employee->EmployeeID)  // Only get the record for the current employee
																		->where('k1.YearId', $KraYId)  
																		->orderBy('k1.CreatedDate', 'desc')  // Order by CreatedDate in descending order to get the latest
																		->orderBy('k1.CompanyId', 'asc')  // Add other sorting criteria if needed (e.g., sorting by CompanyId)
																		->orderBy('k1.KRAStatus', 'desc') // Sorting by KRAStatus, you can adjust based on priority
																		->first(); // Get the first matching record


																	@endphp
																	<td><b>{{ $index + 1 }}.</b></td>
																	<td>{{ $employee->EmpCode }}</td>
																	<td>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</td>
																	<td>{{ $employee->department_name }}</td>
																	<td>{{ $employee->designation_name }}</td>
																	<td>{{ $employee->city_village_name }}</td>
																	
																	<td>
																	{{-- Employee Status --}}
																	@if($latestPmsKra)
																		@php
																			// Define the status and class based on EmpStatus
																			$empStatusClass = '';
																			$empStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKra->EmpStatus) {
																				case 'A': // Submitted
																					$empStatusClass = 'success';
																					$empStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$empStatusClass = 'warning';
																					$empStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$empStatusClass = 'info';
																					$empStatusText = 'Pending';
																					break;
																				default: // Fallback for unexpected status values
																					$empStatusClass = 'secondary'; // or another class of your choice
																					$empStatusText = 'Revert';
																			}
																		@endphp
																		<!-- Output the EmpStatus with class and text -->
																		<span class="{{ $empStatusClass }}"><b>{{ $empStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																	</td>

																{{-- Approval Status --}}
																<td>
																	@if($latestPmsKra)
                                                                    @php
																			// Define the status and class based on EmpStatus
																			$appStatusClass = '';
																			$appStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKra->AppStatus) {
																				case 'A': // Submitted
																					$appStatusClass = 'success';
																					$appStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$appStatusClass = 'warning';
																					$appStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$appStatusClass = 'info';
																					$appStatusText = 'Pending';
																					break;
                                                                                case 'R': // Pending (if applicable)
																					$appStatusClass = 'secondary';
																					$appStatusText = 'Revert';
																					break;
																				default: // Fallback for unexpected status values
																					$appStatusClass = 'secondary'; // or another class of your choice
																					$empStatusText = 'Revert';
																			}
																		@endphp
																		
																		<span class="{{ $appStatusClass }}"><b>{{ $appStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>
                                                                <td>
																	@if($latestPmsKra)
																	@php
																			// Define the status and class based on EmpStatus
																			$revStatusClass = '';
																			$revStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKra->RevStatus) {
																				case 'A': // Submitted
																					$revStatusClass = 'success';
																					$revStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$revStatusClass = 'warning';
																					$revStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$revStatusClass = 'info';
																					$revStatusText = 'Pending';
																					break;
																				default: // Fallback for unexpected status values
																					$revStatusClass = 'secondary'; // or another class of your choice
																					$revStatusText = 'Revert';
																			}
																		@endphp
																	
																		<span class="{{ $revStatusClass }}"><b>{{ $revStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>
																<td>
																	@if($latestPmsKra)
																	@php
																			// Define the status and class based on EmpStatus
																			$HODStatusClass = '';
																			$HODStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKra->HODStatus) {
																				case 'A': // Submitted
																					$HODStatusClass = 'success';
																					$HODStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$HODStatusClass = 'warning';
																					$HODStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$HODStatusClass = 'info';
																					$HODStatusText = 'Pending';
																					break;
																				default: // Fallback for unexpected status values
																					$HODStatusClass = 'secondary'; // or another class of your choice
																					$HODStatusText = 'Revert';
																			}
																		@endphp
																	
																		<span class="{{ $HODStatusClass }}"><b>{{ $HODStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>

																{{-- Action Buttons --}}
																<td>
																	{{-- KRA View Button --}}
																	<a title="KRA View" data-bs-toggle="modal" data-bs-target="#viewKRA" class="viewkrabtn"
																				data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $KraYId }}" 
																					data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																					data-empcode="{{ $employee->EmpCode }}"
																					data-designation="{{ $employee->designation_name }}">
																			<i class="fas fa-eye mr-2"></i>
																			</a>

																</td>
																</tr>
															@endforeach
														</tbody>
													</table>

													</div>
												</div>
											</div>
									</div>
                                </div>
                                <div class="tab-pane fade" id="KraTabNew" role="tabpanel">
											<div class="row">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
													<div class="card">
													<div class="card-header" style="padding:0 !important;">
														<div class="float-end" style="margin-top:-50px;">
															
															<!-- Department Dropdown -->
															<!-- <select>
																<option value="">Select Department</option>
																@foreach($employeeDetails->unique('department_name') as $employee)
																	<option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
																@endforeach
															</select> -->
															<!-- <select>
																<option>Select State</option>
																<option>All</option>
																<option>Sales</option>
															</select> -->
															 <!-- Headquarter Dropdown -->
															<!-- <select >
																<option value="">Select Head Quarter</option>
																@foreach($employeeDetails->unique('city_village_name') as $employee)
																	<option value="{{ $employee->city_village_name }}">{{ $employee->city_village_name }}</option>
																@endforeach
															</select> -->
														</div>
													</div>
													<div class="card-body table-responsive align-items-center">
													<table class="table table-pad" id="mang_table_list_new">
														<thead>
															<tr>
																<th>SN.</th>
																<th>EC</th>
																<th>Name</th>
																<th>Department</th>
																<th>Designation</th>
																<th>HQ</th>
																<th>Employee</th>
																<th>Appraiser</th>
																<th>Reviewer</th>
																<th>HOD</th>
																<th>Action</th>
															</tr>
														</thead>
														<tbody>
														
															@foreach ($employeeDetails as $index => $employee)
															<tr>
																@php
																	$latestPmsKranEW = DB::table('hrm_pms_kra as k1')
																		->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy','k1.AppRevertNote','k1.HODRevertNote')
																		->where('k1.EmployeeID', $employee->EmployeeID)  // Only get the record for the current employee
																		->where('k1.YearId', $year_kra->NewY)  // Filtering for YearId = 14
																		->orderBy('k1.CreatedDate', 'desc')  // Order by CreatedDate in descending order to get the latest
																		->orderBy('k1.CompanyId', 'asc')  // Add other sorting criteria if needed (e.g., sorting by CompanyId)
																		->orderBy('k1.KRAStatus', 'desc') // Sorting by KRAStatus, you can adjust based on priority
																		->first(); // Get the first matching record

																	@endphp
																	<td><b>{{ $index + 1 }}.</b></td>
																	<td>{{ $employee->EmpCode }}</td>
																	<td>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</td>
																	<td>{{ $employee->department_name }}</td>
																	<td>{{ $employee->designation_name }}</td>
																	<td>{{ $employee->city_village_name }}</td>
																	<td>
																	{{-- Employee Status --}}
																	@if($latestPmsKranEW)
																		@php
																			// Define the status and class based on EmpStatus
																			$empStatusClass = '';
																			$empStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKranEW->EmpStatus) {
																				case 'A': // Submitted
																					$empStatusClass = 'success';
																					$empStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$empStatusClass = 'warning';
																					$empStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$empStatusClass = 'info';
																					$empStatusText = 'Pending';
																					break;
																				default: // Fallback for unexpected status values
																					$empStatusClass = 'secondary'; // or another class of your choice
																					$empStatusText = 'Revert';
																			}
																		@endphp
																		<!-- Output the EmpStatus with class and text -->
																		<span class="{{ $empStatusClass }}"><b>{{ $empStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																	</td>

																{{-- Approval Status --}}
																<td>
																	@if($latestPmsKranEW)
                                                                    @php
																			// Define the status and class based on EmpStatus
																			$appStatusClass = '';
																			$appStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKranEW->AppStatus) {
																				case 'A': // Submitted
																					$appStatusClass = 'success';
																					$appStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$appStatusClass = 'warning';
																					$appStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$appStatusClass = 'info';
																					$appStatusText = 'Pending';
																					break;
                                                                                case 'R': // Pending (if applicable)
																					$appStatusClass = 'secondary';
																					$appStatusText = 'Revert';
																					break;
																				default: // Fallback for unexpected status values
																					$appStatusClass = 'secondary'; // or another class of your choice
																					$empStatusText = 'Revert';
																			}
																		@endphp
																		
																		<span class="{{ $appStatusClass }}"><b>{{ $appStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>
                                                                <td>
																	@if($latestPmsKranEW)
																	@php
																			// Define the status and class based on EmpStatus
																			$revStatusClass = '';
																			$revStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKranEW->RevStatus) {
																				case 'A': // Submitted
																					$revStatusClass = 'success';
																					$revStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$revStatusClass = 'warning';
																					$revStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$revStatusClass = 'info';
																					$revStatusText = 'Pending';
																					break;
																				default: // Fallback for unexpected status values
																					$revStatusClass = 'secondary'; // or another class of your choice
																					$revStatusText = 'Revert';
																			}
																		@endphp
																	
																		<span class="{{ $revStatusClass }}"><b>{{ $revStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>
																<td>
																	@if($latestPmsKranEW)
																	@php
																			// Define the status and class based on EmpStatus
																			$HODStatusClass = '';
																			$HODStatusText = '';

																			// Check the EmpStatus and set appropriate class and text
																			switch ($latestPmsKranEW->HODStatus) {
																				case 'A': // Submitted
																					$HODStatusClass = 'success';
																					$HODStatusText = 'Submitted';
																					break;
																				case 'D': // Draft
																					$HODStatusClass = 'warning';
																					$HODStatusText = 'Draft';
																					break;
																				case 'P': // Pending (if applicable)
																					$HODStatusClass = 'info';
																					$HODStatusText = 'Pending';
																					break;
																				default: // Fallback for unexpected status values
																					$HODStatusClass = 'secondary'; // or another class of your choice
																					$HODStatusText = 'Revert';
																			}
																		@endphp
																	
																		<span class="{{ $HODStatusClass }}"><b>{{ $HODStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>

																{{-- Action Buttons --}}
																<td>
																	{{-- KRA View Button --}}
																	<a title="KRA View" data-bs-toggle="modal" data-bs-target="#viewKRA" class="viewkrabtn"
																				data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $year_kra->NewY }}" 
																					data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																					data-empcode="{{ $employee->EmpCode }}"
																					data-designation="{{ $employee->designation_name }}">
																			<i class="fas fa-eye mr-2"></i>
																			</a>
																</td>
																</tr>
															@endforeach
														</tbody>
													</table>

													</div>
												</div>
											</div>
									</div>
								</div>
                                <div class="tab-pane fade" id="teamappraisal" role="tabpanel">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card">
                                                <div class="card-header" style="padding:0 !important;">
                                                    <div class="float-end" style="margin-top:-50px;">
                                                        <a class="effect-btn btn btn-secondary squer-btn sm-btn">Rating
                                                            Graph <i class="fas fa-chart-bar mr-1 ml-2"></i></a>
                                                        <a class="effect-btn btn btn-secondary squer-btn sm-btn">Overall
                                                            Rating Graph <i class="fas fa-chart-bar mr-1 ml-2"></i></a>
                                                        <select>
                                                            <option>Select Department</option>
                                                            <option>All</option>
                                                            <option>Sales</option>
                                                        </select>
                                                        <select>
                                                            <option>Select State</option>
                                                            <option>All</option>
                                                            <option>Sales</option>
                                                        </select>
                                                        <select>
                                                            <option>Select Head Quarter</option>
                                                            <option>All</option>
                                                            <option>Sales</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="card-body table-responsive dd-flex align-items-center">
                                                    <table class="table table-pad">
                                                        <thead>
                                                            <tr>
                                                                <th>SN.</th>
                                                                <th>EC</th>
                                                                <th>Name</th>
                                                                <th>Department</th>
                                                                <th>Designation</th>
                                                                <th>HQ</th>
                                                                <th>Employee</th>
                                                                <th>Appraiser</th>
                                                                <th>Reviewer</th>
                                                                <th>Uploaded</th>
                                                                <th>History</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><b>1.</b></td>
                                                                <td>1254</td>
                                                                <td>Kishan Kumar</td>
                                                                <td>IT</td>
                                                                <td>Ex. Software Developer</td>
                                                                <td>Raipur</td>
                                                                <td><span class="success"><b>Submitted</b></span></td>
                                                                <td><span class="success"><b>Submitted</b></span></td>
                                                                <td><span class="danger"><b>Draft</b></span></td>
                                                                <td><a title="Upload" data-bs-toggle="modal"
                                                                        data-bs-target="#viewuploadedfiles"><i
                                                                            class="fas fa-file-upload ml-2 mr-2"></i></a>
                                                                </td>
                                                                <td><a title="History" data-bs-toggle="modal"
                                                                        data-bs-target="#viewHistory"><i
                                                                            class="fas fa-eye mr-2"></i></a></td>
                                                                <td><a title="View" data-bs-toggle="modal"
                                                                        data-bs-target="#viewappraisal"><i
                                                                            class="fas fa-eye mr-2"></i></a>| <a
                                                                        title="Edit" data-bs-toggle="modal"
                                                                        data-bs-target="#editAppraisal"> <i
                                                                            class="fas fa-edit ml-2 mr-2"></i></a> | <a
                                                                        title="Resend" data-bs-toggle="modal"
                                                                        data-bs-target="#resend"> <i
                                                                            class="fas fa-retweet ml-2 mr-2"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('employee.footerbottom')

                </div>
            </div>
        </div>

        <!--View KRA Modal-->
            <div class="modal fade show" id="viewKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" data-bs-backdrop="static" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b id="employeeName">Kishan Kumar</b><br>
                        <small id="employeeDetails">Emp. Code: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small>
                    </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeBtn">
                        <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive p-0">
                        
                        <div class="card mb-0" id="viewkrabox" >
                            <div class="card-header">
                                <div style="float:left;width:100%;">
                                    <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                                </div>
                            </div>
                            <div class="card-body table-responsive dd-flex align-items-center">
                                <table class="table table-pad mb-0"  id="kra-section-view">
                                    <thead>
                                        <tr>
                                            <th>SN.</th>
                                            <th>KRA/Goals</th>
                                            <th>Description</th>
                                            <th>Measure</th>
                                            <th>Unit</th>
                                            <th>Weightage</th>
                                            <th>Logic</th>
                                            <th>Period</th>
                                            <th>Target</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>1.</b></td>
                                            <td><textarea style="min-width: 200px;" class="form-control"></textarea></td>
                                            <td><textarea style="min-width: 300px;" class="form-control"></textarea></td>
                                            <td>
                                                <select>
                                                    <option>Process</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select>
                                                    <option>Days</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input class="form-control"
                                    style="min-width: 60px;" type="text">
                                            </td>
                                            <td>
                                                <select>
                                                    <option>Logic 01</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select>
                                                    <option>Quarterly</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input style="width:50px;font-weight: bold;" type="text" >
                                            </td>
                                        </tr>
                                    
                                        <tr>
                                            <td colspan="10">
                                                <table class="table" style="background-color:#ECECEC;">
                                                    <thead>
                                                        <tr>
                                                            <th>SN.</th>
                                                            <th>Sub KRA/Goals</th>
                                                            <th>Description</th>
                                                            <th>Measure</th>
                                                            <th>Unit</th>
                                                            <th>Weightage</th>
                                                            <th>Logic</th>
                                                            <th>Period</th>
                                                            <th>Target</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><b>1.</b></td>
                                                            <td><textarea style="min-width: 200px;" class="form-control"></textarea> </td>
                                                            <td><textarea style="min-width: 300px;" class="form-control"></textarea></td>
                                                            <td>
                                                                <select>
                                                                    <option>Process</option>
                                                                    <option>1</option>
                                                                    <option>1</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select>
                                                                    <option>Days</option>
                                                                    <option>1</option>
                                                                    <option>1</option>
                                                                </select>
                                                            </td>
                                                            
                                                            <td><input style="width:50px;font-weight: bold;" type="text"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                </table>
                            </div>							
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <a class="effect-btn btn btn-light squer-btn sm-btn " data-bs-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade show" id="editKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" data-bs-backdrop="static" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b id="employeeNameedit">Kishan Kumar</b><br>
				<small id="employeeDetailsedit">Emp. Code: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small>
			</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" id="closeBtn">
                  <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body table-responsive p-0">
                
                <div class="card mb-0" id="editkrabox" >
                    <div class="card-header">
                        <div style="float:left;width:100%;">
                            <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                        </div>
                    </div>
                    <div class="card-body table-responsive dd-flex align-items-center">
                        <table class="table table-pad mb-0"  id="kra-section">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>KRA/Goals</th>
                                    <th>Description</th>
                                    <th>Measure</th>
                                    <th>Unit</th>
                                    <th>Weightage</th>
                                    <th>Logic</th>
                                    <th>Period</th>
                                    <th>Target</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>1.</b></td>
                                    <td><textarea style="min-width: 200px;" class="form-control"></textarea></td>
                                    <td><textarea style="min-width: 300px;" class="form-control"></textarea></td>
                                    <td>
                                        <select>
                                            <option>Process</option>
                                            <option>1</option>
                                            <option>1</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select>
                                            <option>Days</option>
                                            <option>1</option>
                                            <option>1</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input class="form-control"
                            style="min-width: 60px;" type="text">
                                    </td>
                                    <td>
                                        <select>
                                            <option>Logic 01</option>
                                            <option>1</option>
                                            <option>1</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select>
                                            <option>Quarterly</option>
                                            <option>1</option>
                                            <option>1</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input style="width:50px;font-weight: bold;" type="text" >
                                    </td>
                                </tr>
                              
                                <tr>
                                    <td colspan="10">
                                        <table class="table" style="background-color:#ECECEC;">
                                            <thead>
                                                <tr>
                                                    <th>SN.</th>
                                                    <th>Sub KRA/Goals</th>
                                                    <th>Description</th>
                                                    <th>Measure</th>
                                                    <th>Unit</th>
                                                    <th>Weightage</th>
                                                    <th>Logic</th>
                                                    <th>Period</th>
                                                    <th>Target</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><b>1.</b></td>
                                                    <td><textarea style="min-width: 200px;" class="form-control"></textarea> </td>
                                                    <td><textarea style="min-width: 300px;" class="form-control"></textarea></td>
                                                    <td>
                                                        <select>
                                                            <option>Process</option>
                                                            <option>1</option>
                                                            <option>1</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select>
                                                            <option>Days</option>
                                                            <option>1</option>
                                                            <option>1</option>
                                                        </select>
                                                    </td>
                                                    
                                                    <td><input style="width:50px;font-weight: bold;" type="text"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="text-align: center;" colspan="10"><button type="button" class="effect-btn btn btn-success squer-btn sm-btn">Save </button> <button type="button" class="effect-btn btn btn-success squer-btn sm-btn">Approval</button></td>
                                    
                                </tr>								</tbody>
                        </table>
                    </div>							
                </div>
                
            </div>
            <div class="modal-footer">
                <a class="effect-btn btn btn-light squer-btn sm-btn " data-bs-dismiss="modal">Close</a>
            </div>
        </div>
    </div>
        </div>
        
	<!-- revert popup -->
	<div class="modal fade show" id="viewRevertbox" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-md modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><b>Kishan Kumar</b><br><small> Emp. Code: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body table-responsive p-0">
					<div class="card" id="revertbox">
						<div class="card-body table-responsive align-items-center">
							<div class="form-group mr-2">
								<label class="col-form-label"><b>Revert Note</b></label>
								<textarea placeholder="Enter your revert note" class="form-control"></textarea>
							</div>
						</div>
					</div>
				
				</div>
				<div class="modal-footer">
					<a class="effect-btn btn btn-success squer-btn sm-btn" id="sendRevert">Send</a>
					<a class="effect-btn btn btn-light squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
	</div>
     
        <!-- resubmit -->
        <div class="modal fade show" id="resend" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Resend Note</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body appraisal-view">
                        <div class="form-group mr-2" id="">
                            <label class="col-form-label">Resend Note</label>
                            <textarea placeholder="Enter your resubmit note" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="effect-btn btn btn-success squer-btn sm-btn">Send</a>
                        <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>
   

@include('employee.footer')
<script>

		$(document).ready(function() {

		$('.viewkrabtn').on('click', function() {

					var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
					var kraYId = $(this).data('krayid'); // Get KraYId from button
					var employeename = $(this).data('name'); // Get EmployeeID from button
					var empcode = $(this).data('empcode'); // Get KraYId from button
					var designation = $(this).data('designation'); // Get EmployeeID from button
					$('#employeeName').text(employeename);
					$('#employeeDetails').html('Emp. Code: ' + empcode + ', &nbsp;&nbsp;&nbsp;Designation: ' + designation);
				
					$.ajax({
						url: "{{ route('getLogicData') }}", // Define route to fetch logic data
						type: "GET",
						dataType: "json",
						success: function(logicResponse) {
							if (logicResponse.success) {
								var logicData = logicResponse.logicData; // Store logic data globally

								// Now fetch the KRA data
								$.ajax({
									url: "{{ route('getKraDetails') }}", // Route to fetch data
									type: "GET",
									dataType: "json",
									data: {
										employeeId: employeeId,
										kraYId: kraYId,
										_token: $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is included
									},
									success: function(response) {
										if (response.success) {
											var kraData = response.kras;
											var subKraData = response.subKras;
											var modalBody = '';
											
												// Populate the KRA data in modal dynamically
													kraData.forEach((kra, index) => {

														modalBody += `
																<tr>
																	<td><b>${index + 1}.</b></td>
																	<td>${kra.KRA}</td>
																	<td>${kra.KRA_Description}</td>
																	
																		<td>
																			${kra.Measure}
																		</td>
																		<td>
																			${kra.Unit}
																		</td>

																		<td>${kra.Weightage}</td>

																		<td>
																			${kra.Logic}
																		</td>
																		<td>
																			${kra.Period}
																		</td>
																		<td>${kra.Target}</td>
																	</td>
																</tr>
															`;

														// If sub-KRA data exists for the current KRA, populate the sub-KRAs
														if (subKraData[kra.KRAId] && subKraData[kra.KRAId].length > 0) {
															modalBody += `
																<tr class="subkra-row" data-kraid="${kra.KRAId}">
																	<td colspan="10">
																		<table class="table" style="background-color:#ECECEC;">
																			<thead>
																				<tr>
																					<th>SN.</th>
																					<th>Sub KRA/Goals</th>
																					<th>Description</th>
																					<th>Measure</th>
																					<th>Unit</th>
																					<th>Weightage</th>
																					<th>Logic</th>
																					<th>Period</th>
																					<th>Target</th>
																				</tr>
																			</thead>
																			<tbody>`;

															subKraData[kra.KRAId].forEach((subKra, subIndex) => {
																modalBody += `
																	<tr>
																		<td><b>${subIndex + 1}.</b></td>
																		<td>${subKra.KRA}</td>
																		<td>${subKra.KRA_Description}</td>
																		<td>
																			${subKra.Measure}
																		</td>
																		<td>
																			${subKra.Unit}
																		</td>
																		<td>${subKra.Weightage}</td>
																		
																		<td>
																			${subKra.Logic}
																		</td>
																		<td>
																			
																			${subKra.Period}
																		</td>
																		<td>${subKra.Target}</td>
												
																		</tr>`; // Closing subKRA row table
															}); // End subKRA loop

															modalBody += `</tbody></table></td></tr>`; // Close the sub-KRA section
														} // End of subKRA check
													});

												$('#viewkrabox tbody').html(modalBody);
												
										} else {
											alert('No KRA data found.');
										}
									}
								});
							} else {
								alert('Error fetching logic data.');
							}
						}
					});
				});

		});

		$(document).ready(function () {
			// Function to filter the rows based on selected department and HQ
			function filterTable() {
				var departmentFilter = $('#departmentDropdown').val().toLowerCase();
				var hqFilter = $('#hqDropdown').val().toLowerCase();

				// Loop through all rows in the table body
				$('#employeeTableBody tr').each(function () {
					var department = $(this).data('department').toLowerCase();
					var hq = $(this).data('hq').toLowerCase();

					// Show row if it matches the filter or if no filter is applied
					if ((departmentFilter === '' || department.includes(departmentFilter)) && 
						(hqFilter === '' || hq.includes(hqFilter))) {
						$(this).show(); // Show row
					} else {
						$(this).hide(); // Hide row
					}
				});
			}

			// Attach the filterTable function to the change event of the dropdowns
			$('#departmentDropdown, #hqDropdown').on('change', function () {
				filterTable();
			});

			// Initialize table to show all rows by default when the page loads
			filterTable(); // This ensures all rows are shown when the page loads without applying filters.
		});
		

	document.addEventListener("DOMContentLoaded", function () {
		// On page load, check sessionStorage for the stored active tab
		const activeTabId = sessionStorage.getItem("activeTab");

		if (activeTabId) {
			// If a tab is saved in sessionStorage, activate it
			const activeTab = document.getElementById(activeTabId);
			if (activeTab) {
				activeTab.classList.add('active'); // Make the tab active
				const activeContent = document.querySelector(activeTab.getAttribute('href'));
				if (activeContent) {
					activeContent.classList.add('show', 'active'); // Show the corresponding content
				}
			}
		} else {
			// If no tab is stored, activate the first tab by default
			const firstTab = document.querySelector('#myTab1 .nav-link');
			if (firstTab) {
				firstTab.classList.add('active');
				const firstContent = document.querySelector(firstTab.getAttribute('href'));
				if (firstContent) {
					firstContent.classList.add('show', 'active');
				}
			}
		}

		// Add event listeners to tabs to store the active tab ID when clicked
		const tabs = document.querySelectorAll('#myTab1 .nav-link');
		tabs.forEach(tab => {
			tab.addEventListener('click', function () {
				const tabId = this.id;
				sessionStorage.setItem("activeTab", tabId); // Store the active tab ID in sessionStorage
			});
		});
	});
	$(document).ready(function() {
		// Initialize DataTable with pagination and other options
		$('#mang_table_list_curr').DataTable({
			"paging": true,            // Enables pagination
			"lengthChange": true,      // Allows users to change the page length
			"searching": true,         // Allows search functionality
			"ordering": false,          // Allows column sorting
			"info": true,              // Displays information about the table (e.g., "Showing 1 to 10 of 50 entries")
			"autoWidth": false,        // Automatically adjust column width based on content
			"pageLength": 10           // Number of rows per page (default: 10)
		});
	});
	$(document).ready(function() {
		// Initialize DataTable with pagination and other options
		$('#mang_table_list_new').DataTable({
			"paging": true,            // Enables pagination
			"lengthChange": true,      // Allows users to change the page length
			"searching": true,         // Allows search functionality
			"ordering": false,          // Allows column sorting
			"info": true,              // Displays information about the table (e.g., "Showing 1 to 10 of 50 entries")
			"autoWidth": false,        // Automatically adjust column width based on content
			"pageLength": 10           // Number of rows per page (default: 10)
		});
	});

    </script>

<style>
	.delete-kra-btn {
                background: none;
                border: none;
                color: red;
                /* Adjust color as needed */
                font-size: 10px;
                /* Adjust icon size */
                cursor: pointer;
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
                height: 3rem;
            }
			.deleteSubKra {
                background: none;
                border: none;
                color: red;
                /* Adjust color as needed */
                font-size: 10px;
                /* Adjust icon size */
                cursor: pointer;
            }
			.deleteKra  {
                background: none;
                border: none;
                color: red;
                /* Adjust color as needed */
                font-size: 10px;
                /* Adjust icon size */
                cursor: pointer;
            }
			.invalid-field {
					border: 2px solid red;
				}


</style>
