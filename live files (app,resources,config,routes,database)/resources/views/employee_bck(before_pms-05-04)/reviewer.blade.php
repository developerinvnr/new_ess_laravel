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
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{ route('reviewer') }}"
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

                        <ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" > 
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA {{$KraYear}}</a>
								</li>
								@if ($year_kra->NewY_AllowEntry == 'Y')
								<li class="nav-item">
								<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-new-tab20" data-bs-toggle="tab" href="#KraTabNew" role="tab" aria-controls="KraTabnew" aria-selected="false">My Team KRA New {{$kfnew}}-{{$ktnew}}</a>
								</li>
                                    @endif
                                    <!---
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li>
								-->
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
													<table class="table table-pad" id="reviewer_table_list_curr">
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
																<th>Action</th>
																<th>HOD Revert Note</th>
															</tr>
														</thead>
														<tbody id="employeeTableBody">
														
														@foreach ($employeeDetails as $index => $employee)
																<tr class="employee-row" data-department="{{ $employee->department_name }}" data-hq="{{ $employee->city_village_name }}">
																	@php
																		// Fetch the latest KRA record for the employee
																		$latestPmsKranEW = DB::table('hrm_pms_kra as k1')
																			->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy', 'k1.AppRevertNote', 'k1.RevRevertNote', 'k1.HODRevertNote')
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
																			->where('YearId', '13')
																			->where('KRAProcessOwner', 'Reviewer')  // Only fetch Reviewers
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

																	{{-- Approval Status --}}
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
																					case 'R': // Reverted
																						$appStatusClass = 'secondary';
																						$appStatusText = 'Revert';
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

																	<td>
																		@if($latestPmsKranEW)
																			@php
																				// Define the status and class based on RevStatus
																				$revStatusClass = '';
																				$revStatusText = '';

																				// Check the RevStatus and set appropriate class and text
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
																					case 'R': // Reverted
																						$revStatusClass = 'secondary';
																						$revStatusText = 'Revert';
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

																	{{-- Action Buttons --}}
																	<td>
																		{{-- KRA View Button --}}
																		<a title="KRA View" data-bs-toggle="modal" data-bs-target="#viewKRA" class="viewkrabtn"
																		data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $KraYId }}" 
																		data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																		data-empcode="{{ $employee->EmpCode }}"
																		data-designation="{{ $employee->designation_name }}"
																		data-reviewerstatus="{{ $latestPmsKranEW->HODStatus ?? '' }}">
																			<i class="fas fa-eye mr-2"></i>
																		</a>

																		{{-- Edit Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																		@if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A' && $latestPmsKranEW->AppStatus == 'A' && $latestPmsKranEW->RevStatus != 'A')
																			<a title="KRA Edit" data-bs-toggle="modal" data-bs-target="#editKRA" class="editkrabtn" 
																			data-employeeid="{{ $employee->EmployeeID }}" 
																			data-krayid="{{ $KraYId }}" 
																			data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																			data-empcode="{{ $employee->EmpCode }}"
																			data-designation="{{ $employee->designation_name }}">
																				<i class="fas fa-edit mr-2 ml-2"></i>
																			</a>
																		@endif

																		{{-- Revert Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																		@if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A' && $latestPmsKranEW->AppStatus == 'A' && $latestPmsKranEW->RevStatus != 'A')
																			<a title="KRA Revert" data-bs-toggle="modal" data-bs-target="#viewRevertbox" 
																			data-employeeid="{{ $employee->EmployeeID }}" 
																			data-krayid="{{ $KraYId }}" 
																			data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																			data-empcode="{{ $employee->EmpCode }}"
																			data-designation="{{ $employee->designation_name }}">
																				<i class="fas fa-retweet ml-2 mr-2"></i>
																			</a>
																		@endif
																	</td>

																	<td>{{ $latestPmsKranEW->HODRevertNote ?? '-' }}</td>
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
													<table class="table table-pad" id="reviewer_table_list_new">
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
																<th>Action</th>
																<th>HOD Revert Note</th>
															</tr>
														</thead>
														<tbody>
														
														@foreach ($employeeDetails as $index => $employee)
															<tr>
																@php
																	// Fetch the latest KRA record for the employee
																	$latestPmsKranEW = DB::table('hrm_pms_kra as k1')
																		->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy', 'k1.AppRevertNote', 'k1.RevRevertNote', 'k1.HODRevertNote')
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
																		->where('YearId', '14')
																		->where('KRAProcessOwner', 'Reviewer')  // Only fetch team members
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

																{{-- Approval Status --}}
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
																				case 'R': // Reverted
																					$appStatusClass = 'secondary';
																					$appStatusText = 'Revert';
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

																<td>
																	@if($latestPmsKranEW)
																		@php
																			// Define the status and class based on RevStatus
																			$revStatusClass = '';
																			$revStatusText = '';

																			// Check the RevStatus and set appropriate class and text
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
																				case 'R': // Reverted
																					$revStatusClass = 'secondary';
																					$revStatusText = 'Revert';
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

																{{-- Action Buttons --}}
																<td>
																	{{-- KRA View Button --}}
																	<a title="KRA View" data-bs-toggle="modal" data-bs-target="#viewKRA" class="viewkrabtn"
																	data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $KraYId }}" 
																	data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																	data-empcode="{{ $employee->EmpCode }}"
																	data-designation="{{ $employee->designation_name }}"
																	data-reviewerstatus="{{ $latestPmsKranEW->HODStatus ?? '' }}">
																		<i class="fas fa-eye mr-2"></i>
																	</a>

																	{{-- Edit Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																	@if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A' && $latestPmsKranEW->AppStatus == 'A' && $latestPmsKranEW->RevStatus != 'A')
																		<a title="KRA Edit" data-bs-toggle="modal" data-bs-target="#editKRA" class="editkrabtn" 
																		data-employeeid="{{ $employee->EmployeeID }}" 
																		data-krayid="{{ $year_kra->NewY }}" 
																		data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																		data-empcode="{{ $employee->EmpCode }}"
																		data-designation="{{ $employee->designation_name }}">
																			<i class="fas fa-edit mr-2 ml-2"></i>
																		</a>
																	@endif

																	{{-- Revert Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
																	@if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A' && $latestPmsKranEW->AppStatus == 'A' && $latestPmsKranEW->RevStatus != 'A')
																		<a title="KRA Revert" data-bs-toggle="modal" data-bs-target="#viewRevertbox" 
																		data-employeeid="{{ $employee->EmployeeID }}" 
																		data-krayid="{{ $year_kra->NewY }}" 
																		data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
																		data-empcode="{{ $employee->EmpCode }}"
																		data-designation="{{ $employee->designation_name }}">
																			<i class="fas fa-retweet ml-2 mr-2"></i>
																		</a>
																	@endif
																</td>

																<td>{{ $latestPmsKranEW->HODRevertNote ?? '-' }}</td> 
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

                                            modalBody += `
                                                <tr>
                                                    <td style="text-align: center;" colspan="10">
                                                        <button type="button" class="effect-btn btn btn-success squer-btn sm-btn approval-btn" approval-btn data-employeeid="${employeeId}" 
                                                        data-krayid="${kraYId}">Approval</button>
                                                    </td>
                                                </tr>
                                                `;
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

	$(document).on('click', '.approval-btn', function() {
    var employeeId = $(this).data('employeeid'); // Get EmployeeID from button
    var kraYId = $(this).data('krayid'); // Get KraYId from button
    var buttonClass = $(this).attr('id'); 

    var kraFormData = {
        kraData: []  // Array to hold the KRA data
    };

    // Prevent multiple submissions by disabling the save button
    var $approvalButton = $(this);
	$('#loader').show();  // Hide the loader since validation failed
    $approvalButton.prop('disabled', true);  // Disable the button

    // Send the collected data via AJAX to the server for saving
    $.ajax({
        url: "{{ route('savereviewer') }}",  // Route to save KRA data
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
				}, 3000); // Adjust the time (5000ms = 5 seconds) to match your `timeOut` setting for the toast

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
            $approvalButton.prop('disabled', false);  // Disable the button
        }
    });
});

	// Function to fetch the updated data from the server
	function fetchUpdatedData(employeeId,kraYId) {
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
															<td><textarea style="min-width: 200px;" name="KRA[${kra.KRAId}]" required class="form-control" data-kraid="${kra.KRAId}">${kra.KRA}</textarea></td>
															<td><textarea style="min-width: 300px;" name="KRA_Description[${kra.KRAId}]" required class="form-control">${kra.KRA_Description}</textarea></td>
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

															<td><input name="Weightage[${kra.KRAId}]" required class="form-control" style="min-width: 60px;" type="text" value="${kra.Weightage}"></td>

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
																<td><input name="Target[${kra.KRAId}]" required style="width:50px;font-weight: bold;" type="number" value="${kra.Target}"></td>
															` : `<td colspan="3"></td>`}

															<td>
																<button type="button" class="fas fa-plus-circle mr-2  border-0" id="addSubKraBtn" data-kra-id="${kra.KRAId}" style="background-color: unset;">
																</button>
															</td>
															<td>
																			<button title="Delete KRA" class="deleteKra me-2" data-kra-id="${kra.KRAId}">
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
																		</tr>
																	</thead>
																	<tbody>`;

													subKraData[kra.KRAId].forEach((subKra, subIndex) => {
														modalBody += `
															<tr>
																<td><b>${subIndex + 1}.</b></td>
																<td><textarea style="min-width: 200px;" name="SubKRA[${kra.KRAId}][]" required class="form-control" data-subkraid="${subKra.KRASubId}">${subKra.KRA}</textarea></td>
																<td><textarea style="min-width: 300px;" name="SubKRA_Description[${kra.KRAId}][]" required class="form-control">${subKra.KRA_Description}</textarea></td>
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
																<td><input name="SubWeightage[${kra.KRAId}][]" class="form-control" required style="min-width: 60px;" type="text" value="${subKra.Weightage}"></td>
																
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
																<td><input name="SubTarget[${kra.KRAId}][]" required style="width:50px;font-weight: bold;" type="text" value="${subKra.Target}"></td>
															<td>
																							<button class="deleteSubKra" data-subkra-id="${subKra.KRASubId}" data-employeeid="${employeeId}" data-yearid="${kraYId}">
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
													<button type="button" class="effect-btn btn btn-success squer-btn sm-btn approval-btn" id="approval-btn">Approval</button>
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
            url: '{{ route('kra.revert.reviewer') }}',  // Define the route in your routes/web.php
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
                    "timeOut": 5000
                });

                // Reload the page if needed
                setTimeout(function() {
                    location.reload();
                }, 5000);
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
    $('#reviewer_table_list_curr').DataTable({
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
    $('#reviewer_table_list_new').DataTable({
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
