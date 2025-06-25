@include('employee.header')
<body class="mini-sidebar">
	@include('employee.sidebar')
	<div id="loader" style="display: none;">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
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
                                    <li class="breadcrumb-link active">PMS - Appraiser </li>
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
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{ route('appraiser') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Appraiser</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_reviewer)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('reviewer') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Reviewer</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_hod)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('hod') }}" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">HOD</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_mngmt)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('management') }}"
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
							
							<ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist"> 
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA {{$KraYear}}</a>
								</li>
								@if ($year_kra->NewY_AllowEntry == 'Y')
								<li class="nav-item">
								<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-new-tab20" data-bs-toggle="tab" href="#KraTabNew" role="tab" aria-controls="KraTabnew" aria-selected="false">My Team KRA New {{$kfnew-$ktnew}}</a>
								</li>
                                    @endif
                                    
                                    <!--
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li> -->
								
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade" id="KraTab" role="tabpanel">
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
													<table class="table table-pad" id="current_kra_appraisal">
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
																<th>Action</th>
																<th>Reviewer Revert Note</th>
															</tr>
														</thead>
														<tbody id="employeeTableBody">
														
															@foreach ($employeeDetails as $index => $employee)
															<tr class="employee-row" data-department="{{ $employee->department_name }}" data-hq="{{ $employee->city_village_name }}">
															@php
																	// Fetch the latest KRA record for the employee
																	$latestPmsKra = DB::table('hrm_pms_kra as k1')
																		->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy', 'k1.AppRevertNote', 'k1.RevRevertNote')
																		->where('k1.EmployeeID', $employee->EmployeeID)
																		->where('k1.YearId', $KraYId)
																		->orderBy('k1.CreatedDate', 'desc')
																		->orderBy('k1.CompanyId', 'asc')
																		->orderBy('k1.KRAStatus', 'desc')
																		->first();

																	// Fetch the KRA schedule data
																	$kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
																		->where('KRASheduleStatus', 'A')
																		->where('CompanyId', Auth::user()->CompanyId)
																		->where('YearId', $KraYIdCurr)
																		->where('KRAProcessOwner', 'Appraiser')
																		->orderBy('KRASche_DateFrom', 'ASC')
																		->first();

																	// Initialize the variable
																	$isWithinDateRange = false; // Default value

																	// Get the current date using Carbon
																	$currentDate = \Carbon\Carbon::now()->format('Y-m-d');

																	// If we have a result, check the conditions
																	if ($kra_schedule_data_employee) {
																		// Convert KRASche_DateFrom and KRASche_DateTo to Carbon instances for comparison
																		$dateFrom = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateFrom)->format('Y-m-d');
																			$dateTo = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateTo)->format('Y-m-d');

																			// Check if current date is within range (including boundaries)
																			$isWithinDateRange = ($currentDate >= $dateFrom && $currentDate <= $dateTo);

																	}
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
																			// Define the status and class based on AppStatus
																			$appStatusClass = '';
																			$appStatusText = '';

																			// Check the AppStatus and set appropriate class and text
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
																				default: // Fallback for unexpected status values
																					$appStatusClass = 'secondary'; // or another class of your choice
																					$appStatusText = 'Revert';
																			}
																		@endphp
																		<span class="{{ $appStatusClass }}"><b>{{ $appStatusText }}</b></span>
																	@else
																		<span class="info"><b>N/A</b></span>
																	@endif
																</td>

																{{-- Action Buttons --}}
																<td>
																	{{-- KRA View Button --}}
																	<a title="KRA View" data-bs-toggle="modal" data-bs-target="#viewKRA" class="viewkrabtn"
																	data-employeeid="{{ $employee->EmployeeID }}" data-krayid={{$KraYId}} 
																	data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																	data-empcode="{{ $employee->EmpCode }}"
																	data-designation="{{ $employee->designation_name }}"
																	data-RevRevertNote="{{ $latestPmsKra->RevRevertNote ?? '-' }}"
																	data-reviewerstatus="{{ $latestPmsKra->RevStatus ?? '-' }}">
																		<i class="fas fa-eye mr-2"></i>
																	</a>

																	{{-- Edit Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																	@if($latestPmsKra && $latestPmsKra->EmpStatus == 'A')
																		@if($latestPmsKra->AppStatus != 'A' && $isWithinDateRange)
																			<a title="KRA Edit" data-bs-toggle="modal" data-bs-target="#editKRA" class="editkrabtn" 
																			data-employeeid="{{ $employee->EmployeeID }}" 
																			data-krayid={{$KraYId}} 
																			data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																			data-empcode="{{ $employee->EmpCode }}"
																			data-designation="{{ $employee->designation_name }}">
																				<i class="fas fa-edit mr-2 ml-2"></i>
																			</a>
																		@elseif($latestPmsKra->AppStatus == 'A' && !$isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@elseif($latestPmsKra->AppStatus == 'A' && $isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@endif
																	@endif

																	{{-- Revert Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																	@if($latestPmsKra && $latestPmsKra->EmpStatus == 'A')
																		@if($latestPmsKra->AppStatus != 'A' && $isWithinDateRange)
																			<a title="KRA Revert" data-bs-toggle="modal" data-bs-target="#viewRevertbox" 
																			data-employeeid="{{ $employee->EmployeeID }}" 
																			data-krayid={{$KraYId}} 
																			data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																			data-empcode="{{ $employee->EmpCode }}"
																			data-designation="{{ $employee->designation_name }}">
																				<i class="fas fa-retweet ml-2 mr-2"></i>
																			</a>
																		@elseif($latestPmsKra->AppStatus == 'A' && !$isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@elseif($latestPmsKra->AppStatus == 'A' && $isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@endif
																	@endif
																</td>

																<td>{{ $latestPmsKra->RevRevertNote??'-' }}</td> 
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
													<table class="table table-pad" id="new_kra_appraisal">
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
																<th>Action</th>
																<th>Reviewer Revert Note</th>
															</tr>
														</thead>
														<tbody>
														
														@foreach ($employeeDetails as $index => $employee)
															<tr>
																@php
																	// Fetch the latest KRA record for the employee
																	$latestPmsKranEW = DB::table('hrm_pms_kra as k1')
																		->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy', 'k1.AppRevertNote', 'k1.RevRevertNote')
																		->where('k1.EmployeeID', $employee->EmployeeID)
																		->where('k1.YearId', $year_kra->NewY)
																		->orderBy('k1.CreatedDate', 'desc')
																		->orderBy('k1.CompanyId', 'asc')
																		->orderBy('k1.KRAStatus', 'desc')
																		->first();

																	// Fetch the KRA schedule data
																	$kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
																		->where('KRASheduleStatus', 'A')
																		->where('CompanyId', Auth::user()->CompanyId)
																		->where('YearId', $KraYId)
																		->where('KRAProcessOwner', 'Appraiser')
																		->orderBy('KRASche_DateFrom', 'ASC')
																		->first();

																	// Initialize the variable
																	$isWithinDateRange = false; // Default value

																	// Get the current date using Carbon
																	$currentDate = \Carbon\Carbon::now()->format('Y-m-d');

																	// If we have a result, check the conditions
																	if ($kra_schedule_data_employee) {
																		// Convert KRASche_DateFrom and KRASche_DateTo to Carbon instances for comparison
																		$dateFrom = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateFrom)->format('Y-m-d');
																			$dateTo = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateTo)->format('Y-m-d');

																			// Check if current date is within range (including boundaries)
																			$isWithinDateRange = ($currentDate >= $dateFrom && $currentDate <= $dateTo);

																	}
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

																<td>
																	@if($latestPmsKranEW)
																		@php
																			// Define the status and class based on AppStatus
																			$appStatusClass = '';
																			$appStatusText = '';

																			// Check the AppStatus and set appropriate class and text
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
																				default: // Fallback for unexpected status values
																					$appStatusClass = 'secondary'; // or another class of your choice
																					$appStatusText = 'Revert';
																			}
																		@endphp
																		<span class="{{ $appStatusClass }}"><b>{{ $appStatusText }}</b></span>
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
																	data-designation="{{ $employee->designation_name }}"
																	data-RevRevertNote="{{ $latestPmsKranEW->RevRevertNote ?? '' }}"
																	data-reviewerstatus="{{ $latestPmsKranEW->RevStatus ?? '' }}">
																		<i class="fas fa-eye mr-2"></i>
																	</a>

																	{{-- Edit Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																	@if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A')
																		@if($latestPmsKranEW->AppStatus != 'A' && $isWithinDateRange)
																			<a title="KRA Edit" data-bs-toggle="modal" data-bs-target="#editKRA" class="editkrabtn" 
																			data-employeeid="{{ $employee->EmployeeID }}" 
																			data-krayid="{{ $year_kra->NewY }}" 
																			data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																			data-empcode="{{ $employee->EmpCode }}"
																			data-designation="{{ $employee->designation_name }}">
																				<i class="fas fa-edit mr-2 ml-2"></i>
																			</a>
																		@elseif($latestPmsKranEW->AppStatus == 'A' && !$isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@elseif($latestPmsKranEW->AppStatus == 'A' && $isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@endif
																	@endif

																	{{-- Revert Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																	@if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A')
																		@if($latestPmsKranEW->AppStatus != 'A' && $isWithinDateRange)
																			<a title="KRA Revert" data-bs-toggle="modal" data-bs-target="#viewRevertbox" 
																			data-employeeid="{{ $employee->EmployeeID }}" 
																			data-krayid="{{ $year_kra->NewY }}" 
																			data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																			data-empcode="{{ $employee->EmpCode }}"
																			data-designation="{{ $employee->designation_name }}">
																				<i class="fas fa-retweet ml-2 mr-2"></i>
																			</a>
																		@elseif($latestPmsKranEW->AppStatus == 'A' && !$isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@elseif($latestPmsKranEW->AppStatus == 'A' && $isWithinDateRange)
																			{{-- Optionally, you can add a message or a different action here --}}
																		@endif
																	@endif
																</td>

																<td>{{ $latestPmsKranEW->RevRevertNote ?? '-' }}</td> 
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
															<a class="effect-btn btn btn-secondary squer-btn sm-btn">Rating Graph <i class="fas fa-chart-bar mr-1 ml-2"></i></a>
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
																	<td><span class="danger"><b>Draft</b></span></td>
																	<td><a title="Upload" data-bs-toggle="modal" data-bs-target="#viewuploadedfiles"><i class="fas fa-file-upload ml-2 mr-2"></i></a></td>
																	<td><a title="History" data-bs-toggle="modal" data-bs-target="#viewHistory"><i class="fas fa-eye mr-2"></i></a></td>
																	<td><a title="View" data-bs-toggle="modal" data-bs-target="#viewappraisal"><i class="fas fa-eye mr-2"></i></a>| <a title="Edit" data-bs-toggle="modal" data-bs-target="#editAppraisal"> <i class="fas fa-edit ml-2 mr-2"></i></a> | <a title="Resend" data-bs-toggle="modal" data-bs-target="#resend"> <i class="fas fa-retweet ml-2 mr-2"></i></a></td>
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
				<small id="employeeDetails">Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small>
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
                                        <input class="form-control" placeholder="Enter weightage"
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

	<!--edit KRA Modal-->
	<div class="modal fade show" id="editKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" data-bs-backdrop="static" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><b id="employeeNameedit">Kishan Kumar</b><br>
					<small id="employeeDetailsedit">Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small>
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
										<th>Action</th>
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
											<input class="form-control" placeholder="Enter weightage"
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

@include('employee.footer');
<script>
	$(document).ready(function() {

	$('.editkrabtn').on('click', function() {

				var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
				var kraYId = $(this).data('krayid'); // Get KraYId from button
				var employeename = $(this).data('name'); // Get EmployeeID from button
				var empcode = $(this).data('empcode'); // Get KraYId from button
				var designation = $(this).data('designation'); // Get EmployeeID from button
				$('#employeeNameedit').text(employeename);
				$('#employeeDetailsedit').html('Emp. Code: ' + empcode + ', &nbsp;&nbsp;&nbsp;Designation: ' + designation);
			
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
													var hasSubKra = subKraData[kra.KRAId] && subKraData[kra.KRAId].length > 0;

													modalBody += `
															<tr class="kra-row" data-kraid="${kra.KRAId}">
																<td><b>${index + 1}.</b></td>
																<td><textarea style="min-width: 200px;min-height:70px;" placeholder="Enter sub KRA" name="KRA[${kra.KRAId}]" class="form-control" data-kraid="${kra.KRAId}">${kra.KRA}</textarea></td>
																<td><textarea style="min-width: 300px;min-height:70px;" placeholder="Enter description" name="KRA_Description[${kra.KRAId}]" class="form-control">${kra.KRA_Description}</textarea></td>
																${!hasSubKra ? `
																	<td>
																		<select name="Measure[${kra.KRAId}]" class="Inputa" required="">
																			<option value="" disabled ${kra.Measure === "" ? "selected" : ""}>Select Measure</option>
																			<option value="Process" ${kra.Measure === "Process" ? "selected" : ""}>Process</option>
																			<option value="Acreage" ${kra.Measure === "Acreage" ? "selected" : ""}>Acreage</option>
																			<option value="Event" ${kra.Measure === "Event" ? "selected" : ""}>Event</option>
																			<option value="Program" ${kra.Measure === "Program" ? "selected" : ""}>Program</option>
																			<option value="Maintenance" ${kra.Measure === "Maintenance" ? "selected" : ""}>Maintenance</option>
																			<option value="Time" ${kra.Measure === "Time" ? "selected" : ""}>Time</option>
																			<option value="Yield" ${kra.Measure === "Yield" ? "selected" : ""}>Yield</option>
																			<option value="Value" ${kra.Measure === "Value" ? "selected" : ""}>Value</option>
																			<option value="Volume" ${kra.Measure === "Volume" ? "selected" : ""}>Volume</option>
																			<option value="Quantity" ${kra.Measure === "Quantity" ? "selected" : ""}>Quantity</option>
																			<option value="Quality" ${kra.Measure === "Quality" ? "selected" : ""}>Quality</option>
																			<option value="Area" ${kra.Measure === "Area" ? "selected" : ""}>Area</option>
																			<option value="Amount" ${kra.Measure === "Amount" ? "selected" : ""}>Amount</option>
																			<option value="None" ${kra.Measure === "None" ? "selected" : ""}>None</option>
																		</select>
																	</td>
																	<td>
																		<select name="Unit[${kra.KRAId}]" class="Inputa" required="">
																			<option value="" disabled ${kra.Unit === "" ? "selected" : ""}>Select Unit</option>
																			<option value="%" ${kra.Unit === "%" ? "selected" : ""}>%</option>
																			<option value="Acres" ${kra.Unit === "Acres" ? "selected" : ""}>Acres</option>
																			<option value="Days" ${kra.Unit === "Days" ? "selected" : ""}>Days</option>
																			<option value="Month" ${kra.Unit === "Month" ? "selected" : ""}>Month</option>
																			<option value="Hours" ${kra.Unit === "Hours" ? "selected" : ""}>Hours</option>
																			<option value="Kg" ${kra.Unit === "Kg" ? "selected" : ""}>Kg</option>
																			<option value="Ton" ${kra.Unit === "Ton" ? "selected" : ""}>Ton</option>
																			<option value="MT" ${kra.Unit === "MT" ? "selected" : ""}>MT</option>
																			<option value="Kg/Acre" ${kra.Unit === "Kg/Acre" ? "selected" : ""}>Kg/Acre</option>
																			<option value="Number" ${kra.Unit === "Number" ? "selected" : ""}>Number</option>
																			<option value="Lakhs" ${kra.Unit === "Lakhs" ? "selected" : ""}>Lakhs</option>
																			<option value="Rs." ${kra.Unit === "Rs." ? "selected" : ""}>Rs.</option>
																			<option value="INR" ${kra.Unit === "INR" ? "selected" : ""}>INR</option>
																			<option value="None" ${kra.Unit === "None" ? "selected" : ""}>None</option>
																		</select>
																	</td>
																` : `<td colspan="2"></td>`}

																<td><input name="Weightage[${kra.KRAId}]" class="form-control" placeholder="Enter weightage" style="min-width: 60px;" type="number" value="${kra.Weightage}"></td>

																${!hasSubKra ? `
																	<td>
																		<select name="Logic[${kra.KRAId}]" required>
																			<option value="" disabled selected>Select Logic</option>
																			${logicData.map(logic => `
																				<option value="${logic.logicMn}" ${kra.Logic === logic.logicMn ? "selected" : ""}>
																					${logic.logicMn}
																				</option>
																			`).join('')}
																		</select>
																	</td>
																	<td>
																		<select name="Period[${kra.KRAId}]" class="Inputa" required="">
																			<option value="" disabled ${kra.Period === "" ? "selected" : ""}>Select Period</option>
																			<option value="Annual" ${kra.Period === "Annual" ? "selected" : ""}>Annually</option>
																			<option value="1/2 Annual" ${kra.Period === "1/2 Annual" ? "selected" : ""}>Half Yearly</option>
																			<option value="Quarter" ${kra.Period === "Quarter" ? "selected" : ""}>Quarterly</option>
																			<option value="Monthly" ${kra.Period === "Monthly" ? "selected" : ""}>Monthly</option>
																		</select>
																	</td>
																	<td><input placeholder="Enter target" name="Target[${kra.KRAId}]" style="width:75px;font-weight: bold;" type="number" value="${kra.Target}"></td>
																` : `<td colspan="3"></td>`}

																<td>
																	<button type="button" title="Add" class="mr-2 border-0 success" id="addSubKraBtn" data-kra-id="${kra.KRAId}" style="background-color: unset;">
																		<i class="fas fa-plus-circle"></i>
																	</button>
																	<button type="button" title="Delete KRA" class="deleteKra me-2 border-0" data-kra-id="${kra.KRAId}" data-employeeid="${employeeId}" data-yearid="${kraYId}">
																		<i class="fas fa-trash"></i>
																	</button>
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
																				<th></th>
																			</tr>
																		</thead>
																		<tbody>`;

														subKraData[kra.KRAId].forEach((subKra, subIndex) => {
															modalBody += `
																<tr>
																	<td><b>${subIndex + 1}.</b></td>
																	<td><textarea style="min-width: 200px;min-height:70px;" placeholder="Enter sub KRA" name="SubKRA[${kra.KRAId}][]" class="form-control" data-subkraid="${subKra.KRASubId}">${subKra.KRA}</textarea></td>
																	<td><textarea style="min-width: 300px;min-height:70px;" placeholder="Enter description" name="SubKRA_Description[${kra.KRAId}][]" class="form-control">${subKra.KRA_Description}</textarea></td>
																	<td>
																		<select name="SubMeasure[${kra.KRAId}][]" class="Inputa" required="">
																			<option value="" disabled ${subKra.Measure === "" ? "selected" : ""}>Select Measure</option>
																			<option value="Process" ${subKra.Measure === "Process" ? "selected" : ""}>Process</option>
																			<option value="Acreage" ${subKra.Measure === "Acreage" ? "selected" : ""}>Acreage</option>
																			<option value="Event" ${subKra.Measure === "Event" ? "selected" : ""}>Event</option>
																			<option value="Program" ${subKra.Measure === "Program" ? "selected" : ""}>Program</option>
																			<option value="Maintenance" ${subKra.Measure === "Maintenance" ? "selected" : ""}>Maintenance</option>
																			<option value="Time" ${subKra.Measure === "Time" ? "selected" : ""}>Time</option>
																			<option value="Yield" ${subKra.Measure === "Yield" ? "selected" : ""}>Yield</option>
																			<option value="Value" ${subKra.Measure === "Value" ? "selected" : ""}>Value</option>
																			<option value="Volume" ${subKra.Measure === "Volume" ? "selected" : ""}>Volume</option>
																			<option value="Quantity" ${subKra.Measure === "Quantity" ? "selected" : ""}>Quantity</option>
																			<option value="Quality" ${subKra.Measure === "Quality" ? "selected" : ""}>Quality</option>
																			<option value="Area" ${subKra.Measure === "Area" ? "selected" : ""}>Area</option>
																			<option value="Amount" ${subKra.Measure === "Amount" ? "selected" : ""}>Amount</option>
																			<option value="None" ${subKra.Measure === "None" ? "selected" : ""}>None</option>
																		</select>
																	</td>
																	<td>
																		<select name="SubUnit[${kra.KRAId}][]" class="Inputa" required="">
																			<option value="" disabled ${subKra.Unit === "" ? "selected" : ""}>Select Unit</option>
																			<option value="%" ${subKra.Unit === "%" ? "selected" : ""}>%</option>
																			<option value="Acres" ${subKra.Unit === "Acres" ? "selected" : ""}>Acres</option>
																			<option value="Days" ${subKra.Unit === "Days" ? "selected" : ""}>Days</option>
																			<option value="Month" ${subKra.Unit === "Month" ? "selected" : ""}>Month</option>
																			<option value="Hours" ${subKra.Unit === "Hours" ? "selected" : ""}>Hours</option>
																			<option value="Kg" ${subKra.Unit === "Kg" ? "selected" : ""}>Kg</option>
																			<option value="Ton" ${subKra.Unit === "Ton" ? "selected" : ""}>Ton</option>
																			<option value="MT" ${subKra.Unit === "MT" ? "selected" : ""}>MT</option>
																			<option value="Kg/Acre" ${subKra.Unit === "Kg/Acre" ? "selected" : ""}>Kg/Acre</option>
																			<option value="Number" ${subKra.Unit === "Number" ? "selected" : ""}>Number</option>
																			<option value="Lakhs" ${subKra.Unit === "Lakhs" ? "selected" : ""}>Lakhs</option>
																			<option value="Rs." ${subKra.Unit === "Rs." ? "selected" : ""}>Rs.</option>
																			<option value="INR" ${subKra.Unit === "INR" ? "selected" : ""}>INR</option>
																			<option value="None" ${subKra.Unit === "None" ? "selected" : ""}>None</option>
																		</select>
																	</td>
																	<td><input name="SubWeightage[${kra.KRAId}][]" class="form-control" placeholder="Enter weightage" style="min-width: 60px;" type="number" value="${subKra.Weightage}"></td>
																	
																	<td>
																		<select name="SubLogic[${kra.KRAId}][]" required>
																			<option value="" disabled selected>Select Logic</option>
																			${logicData.map(logic => `
																				<option value="${logic.logicMn}" ${subKra.Logic === logic.logicMn ? "selected" : ""}>
																					${logic.logicMn}
																				</option>
																			`).join('')}
																		</select>
																	</td>
																	<td>
																		<select name="SubPeriod[${kra.KRAId}][]" class="Inputa" required="">
																			<option value="" disabled ${subKra.Period === "" ? "selected" : ""}>Select Period</option>
																			<option value="Annual" ${subKra.Period === "Annual" ? "selected" : ""}>Annually</option>
																			<option value="1/2 Annual" ${subKra.Period === "1/2 Annual" ? "selected" : ""}>Half Yearly</option>
																			<option value="Quarter" ${subKra.Period === "Quarter" ? "selected" : ""}>Quarterly</option>
																			<option value="Monthly" ${subKra.Period === "Monthly" ? "selected" : ""}>Monthly</option>
																		</select>
																	</td>
																	<td><input name="SubTarget[${kra.KRAId}][]" style="width:75px;font-weight: bold;" type="number" value="${subKra.Target}"></td>
																<td>
																	<button style="font-size:15px;" type="button" title="Delete Sub KRA" class="deleteSubKra border-0" data-subkra-id="${subKra.KRASubId}" data-employeeid="${employeeId}" data-yearid="${kraYId}">
																		<i class="fas fa-trash"></i>
																	</button>
																</td>
																	</tr>`; // Closing subKRA row table
														}); // End subKRA loop

														modalBody += `</tbody></table></td></tr>`; // Close the sub-KRA section
													} // End of subKRA check
												}); // End KRA loop
											
												modalBody += `
												<tr>
													<td style="text-align: center;" colspan="10">
														<button type="button" class="effect-btn btn btn-success squer-btn sm-btn save-btn" data-employeeid="${employeeId}" 
																						data-krayid="${kraYId}">Save</button>
														<button type="button" class="effect-btn btn btn-success squer-btn sm-btn approval-btn"data-employeeid="${employeeId}" 
																						data-krayid="${kraYId}" id="approval-btn">Approval</button>
													</td>
												</tr><tr>
													<td colspan="10" style="text-align: left;">
														<button type="button" class="effect-btn btn btn-success squer-btn sm-btn" id="add-kra-btn">Add KRA <i class="fas fa-plus-circle"></i></button>
													</td>
												</tr>`;



											// Event listener for 'Add KRA' button
											$(document).on('click', '#add-kra-btn', function() {
													// Create a new KRA row dynamically
													const newKraRow = document.createElement('tr');
													newKraRow.classList.add('kra-row'); // Add the class to your new row
													newKraRow.setAttribute('data-kraid', 'new'); // Use 'new' for the new KRA

													// Calculate the number for the new KRA based on the existing rows
													const existingRows = document.querySelectorAll('.kra-row');
													const rowCount = existingRows.length + 1; // Count the existing rows and add 1 for the new row

													// Define the HTML content for the new KRA row
													newKraRow.innerHTML = `
														<td><b>${rowCount}.</b></td>
													<td><textarea style="min-width: 200px;min-height:70px;" placeholder="Enter KRA" name="KRA[new]" class="form-control" data-kraid="new"></textarea></td>
													<td><textarea style="min-width: 300px;min-height:70px;" placeholder="Enter description" name="KRA_Description[new]" class="form-control"></textarea></td>
													<td>
														<select name="Measure[new]" class="Inputa" required="">
															<option value="" disabled>Select Measure</option>
															<option value="Process">Process</option>
															<option value="Acreage">Acreage</option>
															<option value="Event">Event</option>
															<option value="Program">Program</option>
															<option value="Maintenance">Maintenance</option>
															<option value="Time">Time</option>
															<option value="Yield">Yield</option>
															<option value="Value">Value</option>
															<option value="Volume">Volume</option>
															<option value="Quantity">Quantity</option>
															<option value="Quality">Quality</option>
															<option value="Area">Area</option>
															<option value="Amount">Amount</option>
															<option value="None">None</option>
														</select>
													</td>
													<td>
														<select name="Unit[new]" class="Inputa" required="">
															<option value="" disabled>Select Unit</option>
															<option value="%">%</option>
															<option value="Acres">Acres</option>
															<option value="Days">Days</option>
															<option value="Month">Month</option>
															<option value="Hours">Hours</option>
															<option value="Kg">Kg</option>
															<option value="Ton">Ton</option>
															<option value="MT">MT</option>
															<option value="Kg/Acre">Kg/Acre</option>
															<option value="Number">Number</option>
															<option value="Lakhs">Lakhs</option>
															<option value="Rs.">Rs.</option>
															<option value="INR">INR</option>
															<option value="None">None</option>
														</select>
													</td>
													<td><input name="Weightage[new]" class="form-control" placeholder="Enter weightage" style="min-width: 60px;" type="number" value=""></td>
													<td>
														<select name="Logic[new]" required>
															<option value="" disabled selected>Select Logic</option>
															${logicData.map(logic => `
																<option value="${logic.logicMn}">${logic.logicMn}</option>`).join('')}
														</select>
													</td>
													<td>
														<select name="Period[new]" class="Inputa" required="">
															<option value="" disabled>Select Period</option>
															<option value="Annual">Annually</option>
															<option value="1/2 Annual">Half Yearly</option>
															<option value="Quarter">Quarterly</option>
															<option value="Monthly">Monthly</option>
														</select>
													</td>
													<td><input placeholder="Enter target" name="Target[new]" style="width:75px;font-weight: bold;" type="number" value=""></td>
													<td>
													<button style="font-size:15px;" type="button" title="Remove KRA" class=" mr-2 border-0 background-color:unset delete-kra-btn " data-kraid="new">
														<i class="ri-close-circle-fill"></i>
													</button>
													</td>

												`;

													const kraSection = document.getElementById('kra-section');

													// Find the "Add KRA" button row
													const addKraButtonRow = kraSection.querySelector('#add-kra-btn').closest('tr');

													// Find the row with the "Save" button (you can use a similar method for the "Approval" button)
													const saveButtonRow = kraSection.querySelector('.save-btn').closest('tr');
													const approvalButtonRow = kraSection.querySelector('.approval-btn').closest('tr');
													const buttonRow = saveButtonRow; // Or you can use `approvalButtonRow` if you want to target a specific one.

													// Insert the new KRA row before the button row
													kraSection.querySelector('tbody').insertBefore(newKraRow, buttonRow);

												});

											$(document).on('click', '#addSubKraBtn', function() {
												const kraId = $(this).data('kra-id');  // Get the KRA ID from the button's data attribute

												// Find the corresponding KRA row to append the new sub-KRA row
												const kraRow = $(`.kra-row[data-kraid="${kraId}"]`);

												// Make sure the KRA exists before proceeding
												if (kraRow.length === 0) {
													console.error("KRA row not found!");
													return; // Exit if no KRA is found with the given ID
												}

												// Find the corresponding sub-KRA section for this KRA (if it exists)
												let subKraSection = kraRow.next('.subkra-row');

												// If sub-KRA section doesn't exist, create it
												if (subKraSection.length === 0) {
													subKraSection = $('<tr class="subkra-row" data-kraid="' + kraId + '"></tr>');
													subKraSection.html(`
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
																		<th></th>
																	</tr>
																</thead>
																<tbody>
																</tbody>
															</table>
														</td>
													`);
													kraRow.after(subKraSection);  // Append the sub-KRA section after the KRA row
												}

												// Now add a new sub-KRA row inside the sub-KRA section (whether it exists or not)
												const subKraTableBody = subKraSection.find('table tbody');  // Find the tbody inside the sub-KRA table

												// If there are already sub-KRA rows, calculate the next SN (Serial Number) for sub-KRA
												const nextSN = subKraTableBody.children().length + 1; // This gives the next available SN (incremental)

												console.log('Next SN:', nextSN);

												// Create the new sub-KRA row
												const newSubKraRow = `
													<tr>
														<td><b>${nextSN}.</b></td>
														<td><textarea style="min-width: 200px;min-height:70px;" placeholder="Enter sub KRA" name="SubKRA[${kraId}][]" class="form-control"></textarea></td>
														<td><textarea style="min-width: 300px;min-height:70px;" placeholder="Enter description" name="SubKRA_Description[${kraId}][]" class="form-control"></textarea></td>
														<td>
															<select name="SubMeasure[${kraId}][]" class="Inputa">
																<option value="" disabled>Select Measure</option>
																<option value="Process">Process</option>
																<option value="Acreage">Acreage</option>
																<option value="Event">Event</option>
																<option value="Program">Program</option>
																<option value="Maintenance">Maintenance</option>
																<option value="Time">Time</option>
																<option value="Yield">Yield</option>
																<option value="Value">Value</option>
																<option value="Volume">Volume</option>
																<option value="Quantity">Quantity</option>
																<option value="Quality">Quality</option>
																<option value="Area">Area</option>
																<option value="Amount">Amount</option>
																<option value="None">None</option>
															</select>
														</td>
														<td>
															<select name="SubUnit[${kraId}][]" class="Inputa">
																<option value="" disabled>Select Unit</option>
																<option value="%">%</option>
																<option value="Acres">Acres</option>
																<option value="Days">Days</option>
																<option value="Month">Month</option>
																<option value="Hours">Hours</option>
																<option value="Kg">Kg</option>
																<option value="Ton">Ton</option>
																<option value="MT">MT</option>
																<option value="Kg/Acre">Kg/Acre</option>
																<option value="Number">Number</option>
																<option value="Lakhs">Lakhs</option>
																<option value="Rs.">Rs.</option>
																<option value="INR">INR</option>
																<option value="None">None</option>
															</select>
														</td>
														<td><input name="SubWeightage[${kraId}][]" class="form-control" placeholder="Enter weightage" style="min-width: 60px;" type="number"></td>
														<td>
																		<select name="SubLogic[${kraId}][]" required>
																			<option value="" disabled selected>Select Logic</option>
																			${logicData.map(logic => `
																				<option value="${logic.logicMn}">
																					${logic.logicMn}
																				</option>
																			`).join('')}
																		</select>
																	</td>
														<td>
															<select name="SubPeriod[${kraId}][]" class="Inputa">
																<option value="" disabled>Select Period</option>
																<option value="Annual">Annually</option>
																<option value="1/2 Annual">Half Yearly</option>
																<option value="Quarter">Quarterly</option>
																<option value="Monthly">Monthly</option>
															</select>
														</td>
														<td><input name="SubTarget[${kraId}][]" style="width:75px;font-weight: bold;" type="number" placeholder="Enter target"></td>
														<td><button style="font-size:15px;" title="Remove Sub KRA" type="button" class="danger border-0" onclick="removeSubKRA(this)">
															<i class="ri-close-circle-fill"></i>
															</button></td>

														</tr>
												`;

												// Append the new sub-KRA row to the sub-KRA section's table body
												subKraTableBody.append(newSubKraRow);

												// Debugging to check the number of rows after appending
												console.log('Rows after appending: ', subKraTableBody.children().length);
											});
											
											// When the modal is shown, ensure to reset the serial number (SN) to 1
												$(document).on('show.bs.modal', '#editkrabox', function() {
													// Reset the serial number to 1 every time the modal is opened
													const rows = $('#editkrabox tbody tr');
													rows.each(function(index) {
														// Reset SN to be the index + 1
														$(this).find('td:first-child').html(`<b>${index + 1}.</b>`);
													});
												});

												// Optional: Clear all dynamically added rows when closing the modal
												$(document).on('hidden.bs.modal', '#editkrabox', function() {
													$('#editkrabox tbody').empty(); // Clear the table body when the modal is closed
												});
											$('#editkrabox tbody').html(modalBody);
											
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
	$(document).ready(function() {

		$('.viewkrabtn').on('click', function() {

			var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
			var kraYId = $(this).data('krayid'); // Get KraYId from button
			var employeename = $(this).data('name'); // Get EmployeeID from button
			var empcode = $(this).data('empcode'); // Get KraYId from button
			var designation = $(this).data('designation'); // Get EmployeeID from button
			var revStatus = $(this).data('reviewerstatus'); // Get Reviewer Status from button
    			var revRevertNote = $(this).data('revrevertnote'); // Get Revert Note from button

			$('#employeeName').text(employeename);
			$('#employeeDetails').html('Emp. Code: ' + empcode + ', &nbsp;&nbsp;&nbsp;Designation: ' + designation);
		 	
		 	// Check if RevStatus is 'R' and display the revert message
			    if (revStatus === 'R') {
				$('#employeeDetails').append('<br><span class="text-danger">Your KRA has been reverted</span>');
			    }
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

	function removeSubKRA(button) {
    let table = button.closest('table'); // Get the closest table
    let thead = table.querySelector('thead'); // Get the <thead> of the table
    let row = button.parentNode.parentNode; // Get the row (tr) that contains the button
    
    // Remove both the row and <thead>
    if (thead) {
        thead.parentNode.removeChild(thead); // Remove <thead>
    }
    if (row) {
        row.parentNode.removeChild(row); // Remove the specific row
    }

    // Adjust serial numbers in the remaining rows
    let rows = table.querySelectorAll('tbody tr'); // Get all remaining rows in the table body
    rows.forEach((row, index) => {
        let serialCell = row.querySelector('td:first-child'); // Assuming the serial number is in the first cell
        if (serialCell) {
            serialCell.textContent = index + 1; // Update serial number (index + 1 for 1-based index)
        }
    });
}

$(document).on('click', '.save-btn', function() {
    var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
    var kraYId = $(this).data('krayid'); // Get KraYId from button

    var kraFormData = {
        kraData: []  // Array to hold the KRA data
    };

    // Prevent multiple submissions by disabling the save button
    var $saveButton = $(this);
    $('#loader').show();  // Show the loader
    var isValid = true;  // Flag to track if the form is valid

    // Clear previous validation (if any)
    $('.invalid-field').removeClass('invalid-field');
    $('.error-message').remove();  // Remove previous error messages

    // Iterate over each KRA row
    $('.kra-row').each(function() {
        var kraId = $(this).data('kraid');  // Get the current KRAId

        var kra = {
            KRAId: kraId,
            KRA: $(`textarea[name="KRA[${kraId}]"]`).val(),
            KRA_Description: $(`textarea[name="KRA_Description[${kraId}]"]`).val(),
            Measure: $(`select[name="Measure[${kraId}]"]`).val(),
            Unit: $(`select[name="Unit[${kraId}]"]`).val(),
            Weightage: $(`input[name="Weightage[${kraId}]"]`).val(),
            Logic: $(`select[name="Logic[${kraId}]"]`).val(),
            Period: $(`select[name="Period[${kraId}]"]`).val(),
            Target: $(`input[name="Target[${kraId}]"]`).val(),
            subKraData: []  // Initialize the array for sub-KRAs
        };

        var isRowValid = true;

        // Check if any required field is empty
        // if (!kra.KRA || !kra.KRA_Description || !kra.Measure || !kra.Unit || 
        //     !kra.Weightage || !kra.Logic || !kra.Period || !kra.Target) {
            
        //     // Mark the row as invalid
        //     isRowValid = false;

        //     // Highlight the invalid row (optional)
        //     $(this).addClass('invalid');

        //     // Add red border around the invalid fields
        //     if (!kra.KRA) {
        //         $(`textarea[name="KRA[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.KRA_Description) {
        //         $(`textarea[name="KRA_Description[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.Measure) {
        //         $(`select[name="Measure[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.Unit) {
        //         $(`select[name="Unit[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.Weightage) {
        //         $(`input[name="Weightage[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.Logic) {
        //         $(`select[name="Logic[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.Period) {
        //         $(`select[name="Period[${kraId}]"]`).addClass('invalid-field');
        //     }
        //     if (!kra.Target) {
        //         $(`input[name="Target[${kraId}]"]`).addClass('invalid-field');
        //     }

        //     // Set the overall form validity to false
        //     isValid = false;
        // }

        if (isRowValid) {
            // If the row is valid, add the KRA to the kraData array
            kraFormData.kraData.push(kra);
        }

        // Find sub-KRA rows within the current KRA row (nested table)
        $(this).next('.subkra-row').find('table tbody tr').each(function() {
            var subKraId = $(this).find('textarea[name^="SubKRA[' + kraId + '][]"]').data('subkraid');  // Correctly get the sub-KRA ID

            var subKra = {
                SubKRAId: subKraId,
                KRA: $(this).find(`textarea[name="SubKRA[${kraId}][]"]`).val(),
                KRA_Description: $(this).find(`textarea[name="SubKRA_Description[${kraId}][]"]`).val(),
                Measure: $(this).find(`select[name="SubMeasure[${kraId}][]"]`).val(),
                Unit: $(this).find(`select[name="SubUnit[${kraId}][]"]`).val(),
                Weightage: $(this).find(`input[name="SubWeightage[${kraId}][]"]`).val(),
                Logic: $(this).find(`select[name="SubLogic[${kraId}][]"]`).val(),
                Period: $(this).find(`select[name="SubPeriod[${kraId}][]"]`).val(),
                Target: $(this).find(`input[name="SubTarget[${kraId}][]"]`).val()
            };

            // Check if any sub-KRA field is empty
            if (!subKra.KRA || !subKra.KRA_Description || !subKra.Measure || !subKra.Unit || 
                !subKra.Weightage || !subKra.Logic || !subKra.Period || !subKra.Target) {
                isValid = false;  // Set validation flag to false if any field is empty

                // Add red border to the invalid sub-KRA fields
                if (!subKra.KRA) {
                    $(this).find(`textarea[name="SubKRA[${kraId}][]"]`).addClass('invalid-field');
                }
                if (!subKra.KRA_Description) {
                    $(this).find(`textarea[name="SubKRA_Description[${kraId}][]"]`).addClass('invalid-field');
                }
                if (!subKra.Measure) {
                    $(this).find(`select[name="SubMeasure[${kraId}][]"]`).addClass('invalid-field');
                }
                if (!subKra.Unit) {
                    $(this).find(`select[name="SubUnit[${kraId}][]"]`).addClass('invalid-field');
                }
				if (!subKra.Weightage) {
                    $(this).find(`input[name="SubWeightage[${kraId}][]"]`).addClass('invalid-field');
				
                }
				
                if (!subKra.Logic) {
                    $(this).find(`select[name="SubLogic[${kraId}][]"]`).addClass('invalid-field');
                }
                if (!subKra.Period) {
                    $(this).find(`select[name="SubPeriod[${kraId}][]"]`).addClass('invalid-field');
                }
				if (!subKra.Target) {
                    $(this).find(`input[name="SubTarget[${kraId}][]"]`).addClass('invalid-field');
                }
				
				
            }
			 // Validation for number fields like Weightage and Target
			 if (subKra.Weightage <= 0 || subKra.Weightage >= 99999) {
					isValid = false;
					$(this).find(`input[name="SubWeightage[${kraId}][]"]`).addClass('invalid-field');
				}

				if (subKra.Target <= 0 || subKra.Target >= 99999) {
					isValid = false;
					$(this).find(`input[name="SubTarget[${kraId}][]"]`).addClass('invalid-field');
				}
            kra.subKraData.push(subKra);  // Add sub-KRA to the KRA's subKraData array
        });
    });
	// If the form is not valid, stop the submission (return early)
		if (!isValid) {
			$('#loader').hide();  // Hide the loader
			toastr.error('Please fill all required fields/ Enter valid number.', 'Error', {
				"positionClass": "toast-top-right",
				"timeOut": 5000
			});

			// Re-enable the save button in case of error
			$saveButton.prop('disabled', false);
			return;  // Stop further execution (do not submit the form)
		}
		if ($(this).attr('type') === 'number') {
                                let numValue = parseFloat(inputVal);

                                // Check for negative or zero values
                                if (numValue <= 0 || numValue > 999999) {
									$('#loader').hide();  // Hide the loader
									toastr.error('Please fill all required fields/ Enter valid number.', 'Error', {
										"positionClass": "toast-top-right",
										"timeOut": 5000
									});

									// Re-enable the save button in case of error
									$saveButton.prop('disabled', false);
									return;  // Stop further execution (do not submit the form)
								}
            }



    // Proceed with the AJAX request if the form is valid
    $.ajax({
        url: "{{ route('saveappraiser') }}",  // Route to save KRA data
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF Token for protection
            kraData: kraFormData.kraData,
            employeeId: employeeId,
            kraYId: kraYId
        },
        success: function(response) {
            $('#loader').hide();  // Hide the loader

            // Handle success response
            if (response.error) {
                toastr.error(response.error, 'Error', {
                    "positionClass": "toast-top-right",
                    "timeOut": 5000
                });
            } else {
                // Display success toast
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 10000
                });
                fetchUpdatedData(employeeId, kraYId); // Function to fetch and update the KRA data

                // Re-enable the save button after success
                $saveButton.prop('disabled', false);
            }
        },
        error: function(xhr) {
            $('#loader').hide();

            // Ensure error message is shown properly
            let errorMessage = "An error occurred.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            toastr.error(errorMessage, 'Error', {
                "positionClass": "toast-top-right",
                "timeOut": 5000
            });

            // Re-enable the save button in case of error
            $saveButton.prop('disabled', false);
        }
    });
});

	$(document).on('click', '.approval-btn', function() {
    var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
    var kraYId = $(this).data('krayid'); // Get KraYId from button
    var buttonClass = $(this).attr('id'); 

    var kraFormData = {
        kraData: []  // Array to hold the KRA data
    };

    // Prevent multiple submissions by disabling the save button
	$('#loader').show();  // Hide the loader since validation failed

    // Iterate over each KRA row
    $('.kra-row').each(function() {
        var kraId = $(this).data('kraid');  // Get the current KRAId

        var kra = {
            KRAId: kraId,
            KRA: $(`textarea[name="KRA[${kraId}]"]`).val(),
            KRA_Description: $(`textarea[name="KRA_Description[${kraId}]"]`).val(),
            Measure: $(`select[name="Measure[${kraId}]"]`).val(),
            Unit: $(`select[name="Unit[${kraId}]"]`).val(),
            Weightage: $(`input[name="Weightage[${kraId}]"]`).val(),
            Logic: $(`select[name="Logic[${kraId}]"]`).val(),
            Period: $(`select[name="Period[${kraId}]"]`).val(),
            Target: $(`input[name="Target[${kraId}]"]`).val(),
            subKraData: []  // Initialize the array for sub-KRAs
        };

        // Find sub-KRA rows within the current KRA row (nested table)
        $(this).next('.subkra-row').find('table tbody tr').each(function() {
            var subKraId = $(this).find('textarea[name^="SubKRA[' + kraId + '][]"]').data('subkraid');  // Correctly get the sub-KRA ID

            var subKra = {
                SubKRAId: subKraId,
                KRA: $(this).find(`textarea[name="SubKRA[${kraId}][]"]`).val(),
                KRA_Description: $(this).find(`textarea[name="SubKRA_Description[${kraId}][]"]`).val(),
                Measure: $(this).find(`select[name="SubMeasure[${kraId}][]"]`).val(),
                Unit: $(this).find(`select[name="SubUnit[${kraId}][]"]`).val(),
                Weightage: $(this).find(`input[name="SubWeightage[${kraId}][]"]`).val(),
                Logic: $(this).find(`select[name="SubLogic[${kraId}][]"]`).val(),
                Period: $(this).find(`select[name="SubPeriod[${kraId}][]"]`).val(),
                Target: $(this).find(`input[name="SubTarget[${kraId}][]"]`).val()
            };

            kra.subKraData.push(subKra);  // Add sub-KRA to the KRA's subKraData array
        });

        // Check for duplicate KRA data (based on KRAId)
        var isDuplicate = kraFormData.kraData.some(function(existingKRA) {
            return existingKRA.KRAId === kra.KRAId;
        });

        // If not duplicate, add to the main kraData array
        if (!isDuplicate) {
            kraFormData.kraData.push(kra);  // Add the KRA data to the main data
        } else {
            console.log('Skipping duplicate KRA:', kra);  // Log if duplicate
        }
    });
	var $approvalButton = $(this);
    $approvalButton.prop('disabled', true);  // Disable the button
    // Send the collected data via AJAX to the server for saving
    $.ajax({
        url: "{{ route('saveappraiser') }}",  // Route to save KRA data
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF Token for protection
            kraData: kraFormData.kraData,
            employeeId: employeeId,
            kraYId: kraYId,
			buttonClass: buttonClass
        },
        success: function(response) {
			$('#loader').hide();  // Hide the loader since validation failed

            // Handle success response
            if (response.error) {
                toastr.error(response.error, 'Error', {
                    "positionClass": "toast-top-right",
                    "timeOut": 3000
                });
				$approvalButton.prop('disabled', false);  // Disable the button


            } else {
               // Display success toast
				toastr.success(response.message, 'Success', {
					"positionClass": "toast-top-right",
					"timeOut": 3000
				});

				// Reload the page after a short delay (to give time for the toast to appear)
				setTimeout(function() {
					location.reload(); // Reload the page
				}, 300); // Adjust the time (5000ms = 5 seconds) to match your `timeOut` setting for the toast

            }
        },
        error: function(xhr) {
            $('#loader').hide();
			$approvalButton.prop('disabled', false);  // Disable the button

            // Ensure error message is shown properly
            let errorMessage = "An error occurred.";
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }

            toastr.error(errorMessage, 'Error', {
                "positionClass": "toast-top-right",
                "timeOut": 3000
            });
        }
    });
});

		// Delete KRA button functionality
	$(document).on('click', '.delete-kra-btn', function() {
			var kraId = $(this).data('kraid');
			$(this).closest('tr').remove();
	});

	
	$(document).on('click', '.deleteSubKra', function(event) {
		var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
				var kraYId = $(this).data('yearid'); // Get KraYId from button
			
                event.preventDefault(); // Prevents form submission or page reload

                let subKraId = $(this).data('subkra-id');

                if (!subKraId) {
                    toastr.error("Invalid Sub-KRA ID.");
                    return;
                }

                if (!confirm("Are you sure you want to delete this Sub-KRA?")) {
                    return;
                }

                console.log("AJAX Request Sent for Sub-KRA ID:", subKraId);

                $.ajax({
                    url: "{{ route('delete.subkra') }}",
                    type: "POST",
                    data: {
                        subKraId: subKraId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log("Server Response:", response);
                        if (response.success) {
                            toastr.success(response.message);
							fetchUpdatedData(employeeId,kraYId); // Function to fetch and update the KRA data

                        } else {
                            toastr.error(response.message);
                        }

                    },
                    error: function(xhr) {
                        console.log("AJAX Error:", xhr);
                        let errorMsg = xhr.responseJSON?.message || "An error occurred.";
                        toastr.error(errorMsg);
                    }
                });
            });

	$(document).on('click', '.deleteKra', function(event) {
				var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
				var kraYId = $(this).data('yearid'); // Get KraYId from button
			
			event.preventDefault(); // Prevents form submission or page reload

    let kraId = $(this).data("kra-id");
    let kraRow = $("#kraRow_" + kraId);

    if (!confirm("Are you sure you want to delete this KRA? This action cannot be undone.")) {
        return;
    }

    $.ajax({
        url: "{{ route('kra.delete') }}",
        type: "POST",
        data: {
            kraId: kraId,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            console.log("Server Response:", response);
            if (response.success) {
                toastr.success(response.message);
                
                // Optional: Remove the row visually from the table
                kraRow.remove(); // Remove the row from the table
                fetchUpdatedData(employeeId,kraYId); // Function to fetch and update the KRA data
            } else {
                toastr.error(response.message);
            }
        },
        error: function(xhr) {
            console.log("AJAX Error:", xhr);
            let errorMsg = xhr.responseJSON?.message || "An error occurred.";
            toastr.error(errorMsg);
        }
    });
});

	// Function to fetch the updated data from the server
	function fetchUpdatedData(employeeId,kraYId) {
		console.log('dddddd');
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
												var hasSubKra = subKraData[kra.KRAId] && subKraData[kra.KRAId].length > 0;

												modalBody += `
														<tr class="kra-row" data-kraid="${kra.KRAId}">
															<td><b>${index + 1}.</b></td>
															<td><textarea style="min-width: 200px;min-height:70px;" placeholder="Enter sub KRA" name="KRA[${kra.KRAId}]" required class="form-control" data-kraid="${kra.KRAId}">${kra.KRA}</textarea></td>
															<td><textarea style="min-width: 300px;min-height:70px;" placeholder="Enter description" name="KRA_Description[${kra.KRAId}]" required class="form-control">${kra.KRA_Description}</textarea></td>
															${!hasSubKra ? `
																<td>
																	<select name="Measure[${kra.KRAId}]" class="Inputa" required>
																		<option value="" disabled ${kra.Measure === "" ? "selected" : ""}>Select Measure</option>
																		<option value="Process" ${kra.Measure === "Process" ? "selected" : ""}>Process</option>
																		<option value="Acreage" ${kra.Measure === "Acreage" ? "selected" : ""}>Acreage</option>
																		<option value="Event" ${kra.Measure === "Event" ? "selected" : ""}>Event</option>
																		<option value="Program" ${kra.Measure === "Program" ? "selected" : ""}>Program</option>
																		<option value="Maintenance" ${kra.Measure === "Maintenance" ? "selected" : ""}>Maintenance</option>
																		<option value="Time" ${kra.Measure === "Time" ? "selected" : ""}>Time</option>
																		<option value="Yield" ${kra.Measure === "Yield" ? "selected" : ""}>Yield</option>
																		<option value="Value" ${kra.Measure === "Value" ? "selected" : ""}>Value</option>
																		<option value="Volume" ${kra.Measure === "Volume" ? "selected" : ""}>Volume</option>
																		<option value="Quantity" ${kra.Measure === "Quantity" ? "selected" : ""}>Quantity</option>
																		<option value="Quality" ${kra.Measure === "Quality" ? "selected" : ""}>Quality</option>
																		<option value="Area" ${kra.Measure === "Area" ? "selected" : ""}>Area</option>
																		<option value="Amount" ${kra.Measure === "Amount" ? "selected" : ""}>Amount</option>
																		<option value="None" ${kra.Measure === "None" ? "selected" : ""}>None</option>
																	</select>
																</td>
																<td>
																	<select name="Unit[${kra.KRAId}]" class="Inputa" required>
																		<option value="" disabled ${kra.Unit === "" ? "selected" : ""}>Select Unit</option>
																		<option value="%" ${kra.Unit === "%" ? "selected" : ""}>%</option>
																		<option value="Acres" ${kra.Unit === "Acres" ? "selected" : ""}>Acres</option>
																		<option value="Days" ${kra.Unit === "Days" ? "selected" : ""}>Days</option>
																		<option value="Month" ${kra.Unit === "Month" ? "selected" : ""}>Month</option>
																		<option value="Hours" ${kra.Unit === "Hours" ? "selected" : ""}>Hours</option>
																		<option value="Kg" ${kra.Unit === "Kg" ? "selected" : ""}>Kg</option>
																		<option value="Ton" ${kra.Unit === "Ton" ? "selected" : ""}>Ton</option>
																		<option value="MT" ${kra.Unit === "MT" ? "selected" : ""}>MT</option>
																		<option value="Kg/Acre" ${kra.Unit === "Kg/Acre" ? "selected" : ""}>Kg/Acre</option>
																		<option value="Number" ${kra.Unit === "Number" ? "selected" : ""}>Number</option>
																		<option value="Lakhs" ${kra.Unit === "Lakhs" ? "selected" : ""}>Lakhs</option>
																		<option value="Rs." ${kra.Unit === "Rs." ? "selected" : ""}>Rs.</option>
																		<option value="INR" ${kra.Unit === "INR" ? "selected" : ""}>INR</option>
																		<option value="None" ${kra.Unit === "None" ? "selected" : ""}>None</option>
																	</select>
																</td>
															` : `<td colspan="2"></td>`}

															<td><input name="Weightage[${kra.KRAId}]" required class="form-control" placeholder="Enter weightage" style="min-width: 60px;" type="number" value="${kra.Weightage}"></td>

															${!hasSubKra ? `
																<td>
																	<select name="Logic[${kra.KRAId}]" required>
																		<option value="" disabled selected>Select Logic</option>
																		${logicData.map(logic => `
																			<option value="${logic.logicMn}" ${kra.Logic === logic.logicMn ? "selected" : ""}>
																				${logic.logicMn}
																			</option>
																		`).join('')}
																	</select>
																</td>
																<td>
																	<select name="Period[${kra.KRAId}]" class="Inputa" required>
																		<option value="" disabled ${kra.Period === "" ? "selected" : ""}>Select Period</option>
																		<option value="Annual" ${kra.Period === "Annual" ? "selected" : ""}>Annually</option>
																		<option value="1/2 Annual" ${kra.Period === "1/2 Annual" ? "selected" : ""}>Half Yearly</option>
																		<option value="Quarter" ${kra.Period === "Quarter" ? "selected" : ""}>Quarterly</option>
																		<option value="Monthly" ${kra.Period === "Monthly" ? "selected" : ""}>Monthly</option>
																	</select>
																</td>
																<td><input name="Target[${kra.KRAId}]" required style="width:75px;font-weight: bold;" type="number" placeholder="Enter target" value="${kra.Target}"></td>
															` : `<td colspan="3"></td>`}

															<td>
																<button type="button" title="Add" class="mr-2 border-0 success" id="addSubKraBtn" data-kra-id="${kra.KRAId}" style="background-color: unset;">
																	<i class="fas fa-plus-circle"></i>
																</button>
																<button type="button" title="Delete KRA" class="deleteKra border-0" data-kra-id="${kra.KRAId}">
																	<i class="fas fa-trash"></i>
																</button>
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
																			<th></th>
																		</tr>
																	</thead>
																	<tbody>`;

													subKraData[kra.KRAId].forEach((subKra, subIndex) => {
														modalBody += `
															<tr>
																<td><b>${subIndex + 1}.</b></td>
																<td><textarea style="min-width: 200px;min-height:70px;" placeholder="Enter sub KRA" name="SubKRA[${kra.KRAId}][]" required class="form-control" data-subkraid="${subKra.KRASubId}">${subKra.KRA}</textarea></td>
																<td><textarea style="min-width: 300px;min-height:70px;" placeholder="Enter description" name="SubKRA_Description[${kra.KRAId}][]" required class="form-control">${subKra.KRA_Description}</textarea></td>
																<td>
																	<select name="SubMeasure[${kra.KRAId}][]" class="Inputa" required>
																		<option value="" disabled ${subKra.Measure === "" ? "selected" : ""}>Select Measure</option>
																		<option value="Process" ${subKra.Measure === "Process" ? "selected" : ""}>Process</option>
																		<option value="Acreage" ${subKra.Measure === "Acreage" ? "selected" : ""}>Acreage</option>
																		<option value="Event" ${subKra.Measure === "Event" ? "selected" : ""}>Event</option>
																		<option value="Program" ${subKra.Measure === "Program" ? "selected" : ""}>Program</option>
																		<option value="Maintenance" ${subKra.Measure === "Maintenance" ? "selected" : ""}>Maintenance</option>
																		<option value="Time" ${subKra.Measure === "Time" ? "selected" : ""}>Time</option>
																		<option value="Yield" ${subKra.Measure === "Yield" ? "selected" : ""}>Yield</option>
																		<option value="Value" ${subKra.Measure === "Value" ? "selected" : ""}>Value</option>
																		<option value="Volume" ${subKra.Measure === "Volume" ? "selected" : ""}>Volume</option>
																		<option value="Quantity" ${subKra.Measure === "Quantity" ? "selected" : ""}>Quantity</option>
																		<option value="Quality" ${subKra.Measure === "Quality" ? "selected" : ""}>Quality</option>
																		<option value="Area" ${subKra.Measure === "Area" ? "selected" : ""}>Area</option>
																		<option value="Amount" ${subKra.Measure === "Amount" ? "selected" : ""}>Amount</option>
																		<option value="None" ${subKra.Measure === "None" ? "selected" : ""}>None</option>
																	</select>
																</td>
																<td>
																	<select name="SubUnit[${kra.KRAId}][]" class="Inputa" required>
																		<option value="" disabled ${subKra.Unit === "" ? "selected" : ""}>Select Unit</option>
																		<option value="%" ${subKra.Unit === "%" ? "selected" : ""}>%</option>
																		<option value="Acres" ${subKra.Unit === "Acres" ? "selected" : ""}>Acres</option>
																		<option value="Days" ${subKra.Unit === "Days" ? "selected" : ""}>Days</option>
																		<option value="Month" ${subKra.Unit === "Month" ? "selected" : ""}>Month</option>
																		<option value="Hours" ${subKra.Unit === "Hours" ? "selected" : ""}>Hours</option>
																		<option value="Kg" ${subKra.Unit === "Kg" ? "selected" : ""}>Kg</option>
																		<option value="Ton" ${subKra.Unit === "Ton" ? "selected" : ""}>Ton</option>
																		<option value="MT" ${subKra.Unit === "MT" ? "selected" : ""}>MT</option>
																		<option value="Kg/Acre" ${subKra.Unit === "Kg/Acre" ? "selected" : ""}>Kg/Acre</option>
																		<option value="Number" ${subKra.Unit === "Number" ? "selected" : ""}>Number</option>
																		<option value="Lakhs" ${subKra.Unit === "Lakhs" ? "selected" : ""}>Lakhs</option>
																		<option value="Rs." ${subKra.Unit === "Rs." ? "selected" : ""}>Rs.</option>
																		<option value="INR" ${subKra.Unit === "INR" ? "selected" : ""}>INR</option>
																		<option value="None" ${subKra.Unit === "None" ? "selected" : ""}>None</option>
																	</select>
																</td>
																<td><input name="SubWeightage[${kra.KRAId}][]" class="form-control" placeholder="Enter weightage" required style="min-width: 60px;" type="number" value="${subKra.Weightage}"></td>
																
																<td>
																	<select name="SubLogic[${kra.KRAId}][]" required>
																		<option value="" disabled selected>Select Logic</option>
																		${logicData.map(logic => `
																			<option value="${logic.logicMn}" ${subKra.Logic === logic.logicMn ? "selected" : ""}>
																				${logic.logicMn}
																			</option>
																		`).join('')}
																	</select>
																</td>
																<td>
																	<select name="SubPeriod[${kra.KRAId}][]" class="Inputa" required>
																		<option value="" disabled ${subKra.Period === "" ? "selected" : ""}>Select Period</option>
																		<option value="Annual" ${subKra.Period === "Annual" ? "selected" : ""}>Annually</option>
																		<option value="1/2 Annual" ${subKra.Period === "1/2 Annual" ? "selected" : ""}>Half Yearly</option>
																		<option value="Quarter" ${subKra.Period === "Quarter" ? "selected" : ""}>Quarterly</option>
																		<option value="Monthly" ${subKra.Period === "Monthly" ? "selected" : ""}>Monthly</option>
																	</select>
																</td>
																<td><input name="SubTarget[${kra.KRAId}][]" required style="width:75px;font-weight: bold;" type="number" value="${subKra.Target}"></td>
															<td>
																							<button type="button" title="Delete Sub KRA" class="deleteSubKra border-0" data-subkra-id="${subKra.KRASubId}" data-employeeid="${employeeId}" data-yearid="${kraYId}">
																								<i class="fas fa-trash"></i>
																							</button>

																						</td>
																</tr>`; // Closing subKRA row table
													}); // End subKRA loop

													modalBody += `</tbody></table></td></tr>`; // Close the sub-KRA section
												} // End of subKRA check
											}); // End KRA loop
										
											modalBody += `
											<tr>
												<td style="text-align: center;" colspan="10">
													<button type="button" class="effect-btn btn btn-success squer-btn sm-btn save-btn" data-employeeid="${employeeId}" 
																					data-krayid="${kraYId}">Save</button>
													<button type="button" class="effect-btn btn btn-success squer-btn sm-btn approval-btn" data-employeeid="${employeeId}" 
																						data-krayid="${kraYId}" id="approval-btn">Approval</button>
												</td>
											</tr>
											<tr>
												<td colspan="10" style="text-align: center;">
													<button type="button" class="btn btn-primary" id="add-kra-btn">Add KRA</button>
												</td>
											</tr>`;


										$('#editkrabox tbody').html(modalBody);
								
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
		}
	
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
	
	$(document).ready(function() {
    // Variables to store the data
    var employeeId, yearId, employeeName, empCode, designation;

    // When the modal is shown, capture the data from the clicked <a> element
    $('#viewRevertbox').on('shown.bs.modal', function(event) {
        // Get the clicked element that triggered the modal
        var button = $(event.relatedTarget);  // Button that triggered the modal
        employeeId = button.data('employeeid');
        yearId = button.data('krayid');
        employeeName = button.data('name');
        empCode = button.data('empcode');
        designation = button.data('designation');

        // Update the modal title with the captured data
        $(this).find('.modal-title').html('<b>' + employeeName + '</b><br><small>Emp. Code: ' + empCode + ', Designation: ' + designation + '</small>');
    });

    // When the "Send" button is clicked inside the modal
    $('#sendRevert').on('click', function() {
		$('#loader').show();

        var revertNote = $('#viewRevertbox').find('textarea').val();  // Get the value from the textarea
        // Validate revert note
        if (revertNote === '') {
            toastr.error('Please enter a revert note.', 'Error');
            return;
        }

        // Send the AJAX request
        $.ajax({
            url: '{{ route('kra.revert') }}',  // Define the route in your routes/web.php
            method: 'POST',
            data: {
                employeeId: employeeId,  // Use the captured data
                yearId: yearId,  // Use the yearId
                revertNote: revertNote,  // Use the revert note
                _token: '{{ csrf_token() }}'  // CSRF token for Laravel
            },
            success: function(response) {
				$('#loader').hide();

                // Display success toast
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 3000
                });

                // Optionally, close the modal

                // Reload the page if needed
                setTimeout(function() {
                    location.reload();
                }, 3000);
            },
            error: function(xhr, status, error) {
				$('#loader').hide();

                toastr.error('An error occurred. Please try again.', 'Error');
            }
        });
    });
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
    $('#current_kra_appraisal').DataTable({
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
    $('#new_kra_appraisal').DataTable({
        "paging": true,            // Enables pagination
        "lengthChange": true,      // Allows users to change the page length
        "searching": true,         // Allows search functionality
        "ordering": false,          // Allows column sorting
        "info": true,              // Displays information about the table (e.g., "Showing 1 to 10 of 50 entries")
        "autoWidth": false,        // Automatically adjust column width based on content
        "pageLength": 10         // Number of rows per page (default: 10)
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
