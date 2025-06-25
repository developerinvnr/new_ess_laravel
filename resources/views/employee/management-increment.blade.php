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
									<li class="breadcrumb-link active">PMS - Management </li>
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
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('pms')}}" role="tab" aria-selected="true">
									<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
									<span class="d-none d-sm-block">Employee</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('appraiser') }}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Appraiser</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('reviewer')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Reviewer</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('hod')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">HOD</span>
								</a>
							</li>
							<li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{route('management')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Management</span>
								</a>
							</li>

							<!-- <li class="nav-item" role="presentation">
								<a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{route('managementIncrementbck')}}" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
									<span class="d-none d-sm-block">Managementbck old</span>
								</a>
							</li> -->
						</ul>
					</div>
					<!-- Revanue Status Start -->
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
						<div class="mfh-machine-profile">
							<ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist">
								<li class="nav-item d-none">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 " id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2025-26</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 active" id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center" id="team_report_tab20" href="{{route('managementReport')}}" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center" id="team_graph_tab20" href="{{route('managementGraph')}}" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
								</li>
							</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade active show" id="teamappraisal" role="tabpanel">
									<div class="row">
										<div class="mfh-machine-profile">
											<div style="margin-top:-40px;float:left;margin-left:556px;">
												<ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
													<li class="mt-1"><a id="home-tab1"
															href="{{route('managementAppraisal')}}" role="tab"
															aria-controls="home" aria-selected="true">Score <i
																class="fas fa-star mr-2"></i></a></li>
													<li class="mt-1"><a class="" id="Promotion-tab20"
															href="{{route('managementPromotion')}}" role="tab"
															aria-controls="Promotion" aria-selected="false">Promotion
															<i class="fas fa-file-alt mr-2"></i></a>
													</li>
													<li class="mt-1"><a class="active" id="Increment-tab21"
															data-bs-toggle="tab" href="#Increment" role="tab"
															aria-controls="Increment" aria-selected="false">Increment <i class="fas fa-file-invoice mr-2"></i></a></li>
												</ul>

											</div>
											<div class="col-md-12 float-start" style="margin-top:-45px;">
												<div class="float-end" style="font-size:11px;margin-top:-4px;margin-left:40px;">
													<span class="mr-2"><i class="ri-arrow-right-up-line me-1 align-middle danger"></i> Proposed </span>
													<span class="mr-2"><i class="ri-arrow-right-line me-1 align-middle success "></i> Current </span>
													<span class="mr-2"><i class="fa fa-history"></i> History </span>
													<span class="mr-2"><span style="padding: 2px 3px;font-size: 10px;background-color: #3b94b7;color: #fff;"><i class="las la-save"></i></span> Save </span>
													<span class="mr-2"><span style="padding: 2px 3px;font-size: 10px;background-color: #6fa22f;color: #fff;"><i class="las la-check-circle"></i></span> Submit</span>
													<span class="mr-2">
														<span style="display: inline-block; width: 12px; height: 14px; background-color: #ffccd9; border: 1px solid #d6336c; vertical-align: middle; margin-right: 3px;"></span>
														Utkarsh Scheme
													</span>

												</div>
											</div>
											<div class="tab-content splash-content2" id="myTabContent2">

												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
													id="Increment" role="tabpanel">
													<div class="card increments-section">
														<div class="card-header increments-section-header" style="background-color:#7d9ea1;padding:5px !important;">

															<div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 5px; margin-top: 3px;">
																<!-- All filters initially on LEFT -->
																<div class="d-flex flex-wrap align-items-center gap-1" id="left-filters">
																	<select style="height:20px;" name="department" id="department-filter">
																		<option value="">Select Department</option>
																		@foreach(collect($employeeTableData)->unique('Department_code') as $employee)
																		<option value="{{ $employee['Department_code'] }}" data-deptid="{{ $employee['depid'] ?? '' }}">
																			{{ $employee['Department_code'] }}
																		</option>
																		@endforeach
																	</select>

																	{{-- HOD, Rev, Grade (initially on left) --}}
																	@if(Auth::user()->EmployeeID == '51' || Auth::user()->EmployeeID === 51)
																	<select style="height:20px;" id="Hod-filter">
																		<option value="">All HOD</option>
																	</select>

																	<select style="height:20px;" id="Rev-filter">
																		<option value="">All Rev</option>
																	</select>
																	@endif

																	<select style="height:20px;" id="grade-filter">
																		<option value="">All Grade</option>
																		@foreach(collect($employeeTableData)->unique('Grade')->sortBy('GradeId') as $grade)
																		<option value="{{ $grade['Grade'] }}">{{ $grade['Grade'] }}</option>
																		@endforeach
																	</select>

																	{{-- BU, Zone, Region (initially hidden) --}}
																	<select id="BU-filter" style="display: none; height:20px;">
																		<option value="">All BU</option>
																		@foreach ($businessUnits as $unit)
																		<option value="{{ $unit->id }}">{{ $unit->business_unit_name }}</option>
																		@endforeach
																	</select>

																	<select id="Zone-filter" style="display: none; height:20px;">
																		<option value="">Select Zone</option>
																	</select>

																	<select id="region-filter" style="display: none; height:20px;">
																		<option value="">Select Region</option>
																	</select>
																</div>

																<!-- Placeholder for moving filters to right when needed -->
																<div class="d-flex flex-wrap align-items-center gap-1" id="right-filters"></div>
															</div>

															<!-- old code  -->
															<!-- <div class="float-start mr-2" style="margin-top:3px;">
																
																	<select style="height:20px;" name="department" id="department-filter">
																		<option value="">Select Department</option>
																		@foreach(collect($employeeTableData)->unique('Department_code') as $employee)
																		<option value="{{ $employee['Department_code'] }}" data-deptid="{{ $employee['depid'] ?? '' }}">
																			{{ $employee['Department_code'] }}
																		</option>
																		@endforeach
																	</select>
																	@if(Auth::user()->EmployeeID == '51' || Auth::user()->EmployeeID === 51)
																		<select style="height:20px;" id="Hod-filter">
																			<option value="">All HOD</option>
																		</select>

																		<select style="height:20px;" id="Rev-filter">
																			<option value="">All Rev</option>
																		</select>
																	@endif

																		<select id="BU-filter" style="display: none; height:20px;">
																			<option value="">All BU</option>
																			@foreach ($businessUnits as $unit)
																				<option value="{{ $unit->id }}">{{ $unit->business_unit_name }}</option>
																			@endforeach
																		</select>

																		<select id="Zone-filter" style="display: none;height:20px;">
																			<option value="">Select Zone</option>
																		</select>

																		<select id="region-filter" style="display: none;height:20px;">
																			<option value="">Select Region</option>
																		</select>
																	
																	

																	<select style="height:20px;" id="grade-filter">
																		<option value="">All Grade</option>
																		@foreach(collect($employeeTableData)->unique('Grade')->sortBy('GradeId') as $grade)
																		<option value="{{ $grade['Grade'] }}">{{ $grade['Grade'] }}</option>
																		@endforeach
																	</select>
															</div> -->
															<div class="float-end text-right">
																<div id="cappingNotification" class="alert alert-warning d-none mb-0 py-0 px-0  mr-1" role="alert"
																	style="font-size: 12px;">
																	⚠ Some employees have exceeded the CTC cap. Please review the highlighted rows.
																</div>
															</div>
															@php
															$ratingCounts = collect($employeeTableData)
															->groupBy('Rating')
															->map(fn($group) => $group->count())
															->sortKeys();
															@endphp
															<div class="float-start rating-box-container w-100 mt-1 d-none" id="ratingcontainer">
																@foreach ($ratingCounts as $rating => $count)
																@if ($rating != 0 && $rating != 0.0 && $rating != 0.00)
																<div class="d-flex align-items-center float-start rating-box me-3 mb-2" data-rating="{{ rtrim(rtrim(number_format((float) $rating, 2, '.', ''), '0'), '.') }}">
																	<b class="me-2">{{ rtrim(rtrim(number_format((float) $rating, 2, '.', ''), '0'), '.') }}</b>
																	<input type="text" style="text-align: center;" class="form-control form-control-sm rating-input" style="text-align:center" value="">
																	<span class="ml-1">%</span>

																</div>
																@endif
																@endforeach
																<!-- Apply All & Refresh Button -->
																<div class="float-left mb-2">
																	<button type="button" id="applyAllRatings" class="inc-btns btn btn-sm btn-success mr-1">
																		Apply All Ratings and Refresh
																	</button>
																</div>
															</div>

														</div>
														<div class="card-body table-container table-responsive dd-flex align-items-center p-0" style="margin-top:-3px;">
															<table class="increments-section-table table table-pad table-bordered inc-table mt-0" style="font-size:11px;" id="employeetablemang">
																<thead>
																	<tr>
																		<th rowspan="2" class="text-center">SN.</th>
																		<th rowspan="2" class="text-center">His.</th>
																		<th rowspan="2" class="text-center">EC</th>
																		<th rowspan="2" style="width:110px;">Name</th>
																		<th rowspan="2" class="text-center" style="width:90px;">DOJ</th>
																		<th rowspan="2" class="text-center" style="width:75px;">Department</th>
																		<th rowspan="2" class="text-center" style="width:95px;">Designation <br>Proposed/Current</th>
																		<th rowspan="2" class="text-center">Grade</th>
																		<th rowspan="2" class="text-center">Grade<br>Change<br>Year</th>
																		<th class="text-center">Last<br>Corr<sup>n</sup></th>
																		<th class="text-center" colspan="1">Previous<br>CTC</th>
																		<th class="text-center" colspan="7">Proposed</th>
																		<th class="text-center" colspan="2">Total Proposed</th>
																		<th class="text-center" colspan="5">Estimated Amount</th>
																		<th rowspan="2" class="text-center" style="width:48px;">Save<br>Sum.</th>
																	</tr>
																	<tr>
																		<th class="text-center">% <br>Year</th>
																		<th class="text-center">Fixed</th>
																		<th class="text-center">Rating</th>
																		<th style="width:35px;" class="text-center">Pro.<br>Rata<br>(%)</th>
																		<th class="text-center">Actual<br>(%)</th>
																		<th class="text-center">CTC</th>
																		<th class="text-center">Corr.</th>
																		<th class="text-center">Corr.<br>(%)</th>
																		<th style="width:60px;" class="text-center">Inc</th>
																		<th class="text-center">CTC</th>
																		<th style="width:35px;" class="text-center">Final<br>(%)</th>
																		<th class="text-center">Variable<br> Pay</th>
																		<th class="text-center">Total<br> CTC</th>
																		<th class="text-center">Car<br>Allowance</th>
																		<th class="text-center">Comm.<br>Allowance</th>
																		<th class="text-center" style="width:70px;">Gross<br> Tot CTC</th>

																	</tr>
																	<tr class="export-btn-section summary-row" style="background-color: #ed843e;">
																		<th colspan="10">
																			<a class="inc-btns btn btn-sm btn-primary mr-1" href="{{ route('export.increment', ['type' => 'blank', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) }}" id="export-link-blank">Exp. with Blank</a>
																			<a class="inc-btns btn btn-sm btn-primary mr-1" href="{{ route('export.increment', ['type' => 'data', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) }}" id="export-link-data">Exp. with Data</a>

																			<a title="Overall Save" href="javascript:void(0);" class="inc-btns btn overall-save btn-sm btn-success mr-1" style="display:none;" id="saveRatingsBtn" data-action="save">Overall Save</a>
																			<a title="Overall Submit" class="inc-btns btn overall-submit btn-sm btn-success mr-1" style="display:none;" href="javascript:void(0);" id="submitRatingsBtn" data-action="submit">Overall Submit</a>

																			<b style="float:right;margin-top:7px;">Total</b>

																		</th>
																		<th class="text-center"><b id="total-prev-ctc">0</b></th>
																		<th></th>
																		<th class="text-center"><b id="avg-prorata">0.00</b></th>
																		<th class="text-center"><b id="avg-actual">0.00</b></th>
																		<th class="text-center"><b id="total-ctc">0</b></th>
																		<th class="text-center"><b id="total-corr">0</b></th>
																		<th class="text-center"><b id="avg-corr-per">0.00</b></th>
																		<th class="text-center"><b id="total-inc">0</b></th>
																		<th class="text-center"><b id="total-final-ctc">0</b></th>

																		<th class="text-center"><b id="avg-final-per">0.00</b></th>
																		<th class="text-center"><b id="avg-totalVarPay">0.00</b></th>
																		<th class="text-center"><b id="avg-totalTotalCtcPay">0.00</b></th>
																		<th class="text-center"><b id="avg-totalCarAllow">0.00</b></th>
																		<th class="text-center"><b id="avg-totalCommAllow">0.00</b></th>
																		<th class="text-center"><b id="avg-totalTotalGross">0.00</b></th>

																		<th></th>
																	</tr>
																</thead>
																<tbody>

																	@foreach($employeeTableData as $index => $row)
																	@php
																	$employeeTableDatanew = DB::table('hrm_pms_appraisal_history')
																	->where('EmpCode', $row['EmpCode'])
																	->where('CompanyId', $row['CompanyID'])
																	->orderBy('SalaryChange_Date', 'desc')
																	->get();

																	@endphp
																	<tr class="employee-data-row" data-empid="{{ $row['EmployeeID'] }}">
																		<td rowspan="2" class="text-center">{{ $index + 1 }}</td>
																		<td rowspan="2" class="text-center">
																			<a title="History" href="#" class="toggle-history" data-empid="{{ $row['EmpCode'] }}">
																				<i class="fa fa-history"></i>
																			</a>
																		</td>
																		<td rowspan="2" class="text-center">{{ $row['EmpCode'] }}</td>
																		<td rowspan="2">{{ $row['FullName'] }}</td>
																		<td rowspan="2" class="text-center">{{ \Carbon\Carbon::parse($row['DateJoining'])->format('d M Y') }}</td>
																		<td rowspan="2" class="text-center dept-row">{{ $row['Department_code'] }}</td>
																		@php
																		$designationChanged = $row['ProDesignation'] != $row['Designation'];
																		$gradeChanged = $row['ProGrade'] != $row['Grade'];
																		$hasProDesignation = !empty($row['ProDesignation']);
																		$hasProGrade = !empty($row['ProGrade']);
																		@endphp

																		<!-- Designation Column -->
																		<td class="text-center">
																			@if(($designationChanged || $gradeChanged) && $hasProDesignation)
																			<i class="ri-arrow-right-up-line me-1 align-middle danger"></i>
																			<input class="up-current-st"
																				style="border:0px;width:70px;padding:0px;font-weight:500;background-color:transparent;text-align:left;"
																				type="text"
																				value="{{ $row['ProDesignation'] }}"
																				title="{{ $row['ProDesignation'] }}"
																				readonly>
																			@else
																			-
																			@endif
																		</td>

																		<!-- Grade Column -->
																		<td class="text-center up-current-st">
																			@if(($designationChanged || $gradeChanged) && $hasProGrade)
																			{{ $row['ProGrade'] }}
																			@else
																			-
																			@endif
																		</td>



																		<td rowspan="2" class="text-center" style="background-color: {{ $row['GrChangeBg'] }}">{{ $row['MxGrDate'] }}</td>
																		<td rowspan="2" class="text-center">
																			<b>{{ rtrim(rtrim(number_format((float) $row['MxCrPer'], 2, '.', ''), '0'), '.') }}</b>
																			<br>{{ $row['MxCrDate'] }}
																		</td>
																		<td rowspan="2" class="text-center prev-fixed p-color">
																			<b>{{ rtrim(rtrim(number_format($row['PrevFixed'], 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td rowspan="2" class="text-center row-rating r-color" data-row-rating="{{ rtrim(rtrim(number_format($row['Rating'], 2, '.', ''), '0'), '.') }}">
																			<b>{{ rtrim(rtrim(number_format($row['Rating'], 2, '.', ''), '0'), '.') }}</b>
																		</td>

																		<td rowspan="2" class="text-center prorata">{{ $row['ProRata'] }}</td>
																		<td rowspan="2">
																			<input type="text" inputmode="decimal" step="0.01" data-actual-empid="{{$row['EmployeeID']}}" class="form-control actual-input"
																				value="{{ fmod((float)$row['Actual'], 1) == 0 ? (int)$row['Actual'] : rtrim(rtrim(number_format($row['Actual'], 2, '.', ''), '0'), '.') }}">
																		</td>

																		<td rowspan="2" class="text-center ctc r-color">
																			{{ fmod($row['CTC'], 1) == 0 ? (int)$row['CTC'] : rtrim(rtrim(number_format($row['CTC'], 2, '.', ''), '0'), '.') }}
																		</td>
																		<td rowspan="2"><input type="text" step="1" data-corr-empid="{{$row['EmployeeID']}}" class="form-control corr-input" value="{{ fmod($row['Corr'], 1) == 0 ? (int)$row['Corr'] : rtrim(rtrim(number_format($row['Corr'], 2, '.', ''), '0'), '.') }}"></td>
																		<td rowspan="2" class="text-center corr-per">{{ $row['CorrPer'] }}</td>
																		<td rowspan="2" class="text-center inc">{{ $row['Inc'] }}</td>
																		<td rowspan="2" class="text-center total-ctc p-color text-right">{{ $row['TotalCTC'] }}</td>

																		<td rowspan="2" class="text-center final-inc">{{ $row['TotalCTCPer'] }}</td>
																		<td rowspan="2" class="text-center variable-pay"></td>
																		<td rowspan="2" class="text-center total-pay-ctc"></td>
																		<td rowspan="2" class="text-center car-allow">
																			{{ isset($row['EmpCurrCarAlw']) 
																				? (floatval($row['EmpCurrCarAlw']) == 0 
																					? '0' 
																					: rtrim(rtrim(number_format((float)$row['EmpCurrCarAlw'], 2, '.', ''), '0'), '.')
																				) 
																				: '' 
																			}}
																		</td>

																		<td rowspan="2" class="text-center comm-allow">
																			{{ isset($row['EmpCurrCommunicationAlw']) 
																				? (floatval($row['EmpCurrCommunicationAlw']) == 0 
																					? '0' 
																					: rtrim(rtrim(number_format((float)$row['EmpCurrCommunicationAlw'], 2, '.', ''), '0'), '.')
																				) 
																				: '' 
																			}}
																		</td>


																		<td rowspan="2" class="text-center total-gross" style="color:#000;font-weight:500;"></td>
																		<td rowspan="2" class="text-center max-ctc d-none">{{ $row['MaxVCtc'] }}</td>
																		@if($row['HodSubmit_IncStatus'] != 2)
																		<td rowspan="2">
																			<a title="Save"
																				class="save-single-employee"
																				data-empid="{{ $row['EmployeeID'] }}" data-emppmsid="{{ $row['EmpPmsId'] }}"
																				style="padding: 2px 3px;font-size:10px;background-color: #3b94b7;color: #fff;margin-right:2px;"
																				href="javascript:void(0);">
																				<i class="las la-save"></i>
																			</a>
																			<a title="Submit" class="submit-single-employee"
																				data-empid="{{ $row['EmployeeID'] }}" data-emppmsid="{{ $row['EmpPmsId'] }}"
																				style="padding: 2px 3px;font-size:10px;background-color: #6fa22f;color: #fff;" href="javascript:void(0);">
																				<i class="las la-check-circle"></i></a>
																		</td>
																		@else
																		<td rowspan="2"></td>
																		@endif
																		<td class="text-center d-none empid" id="empid{{ $row['EmployeeID'] }}">{{ $row['EmployeeID'] }}</td>
																		<td class="hidden-reg d-none">{{ $row['region_name'] }}</td>
																		<td class="d-none EmpCurrAnnualBasic">{{ $row['EmpCurrAnnualBasic'] }}</td>
																		<td class="d-none hodname">{{ $row['HodName'] }}</td>
																		<td class="d-none revname">{{ $row['RevName'] }}</td>
																		<td class="d-none totctcnew"></td>
																		<td class="d-none EmpCurrGrossPM">{{$row['EmpCurrGrossPM']}}</td>
																		<td class="d-none zone">{{$row['zone_id']}}</td>
																		<td class="d-none bu">{{$row['bu_id']}}</td>
																		<td class="d-none utkarshscheme">{{$row['UtkarshScheme']}}</td>



																	</tr>
																	<!--------current grade and desi-------->
																	<tr class="employee-data-row-extra" data-empid="{{ $row['EmployeeID'] }}">
																		<td><i class="ri-arrow-right-line me-1 align-middle success"></i> <input class="current-st" style="border:0px;width:70px;padding:0px;font-weight:400;background-color: transparent;text-align:left;" type="text" value="{{ $row['Designation'] }}" title="{{ $row['Designation'] }}" readonly></td>
																		<td class="text-center current-st-grade">{{ $row['Grade'] }}</td>
																	</tr>
																	<tr id="historymain-{{ $row['EmpCode'] }}" data-empid="{{ $row['EmployeeID'] }}">
																		<td class="p-0" colspan="26">
																			<div class="col-md-12 p-0 employee-history " id="history-{{ $row['EmpCode'] }}" style="display:none;">
																				<table class="table border table-pad mb-1 table-striped history-table table-bordered">
																					<thead style="position:relative;z-index:0;">
																						<tr style="position:relative;z-index:0;top:0;">
																							<th colspan="5" style="text-align:center;">VNR Career History</th>
																							<th colspan="2" style="text-align:center;border-left:1px solid #fff;border-right:1px solid #fff;">Gross Salary Per Month </th>
																							<th colspan="6" style="text-align:center;border-right:1px solid #fff;">CTC</th>
																							<th rowspan="2" style="text-align:center;">Score</th>
																							<th rowspan="2" style="text-align:center;">Rating</th>
																						</tr>
																						<tr>
																							<th style="text-align:center;">Pre. Grade</th>
																							<th style="text-align:center;">Pro. Grade</th>
																							<th style="text-align:center;">Pre. Designation</th>
																							<th style="text-align:center;">Pro. Designation</th>
																							<th style="text-align:center;border-right:1px solid #fff;">Change Date</th>
																							<th style="text-align:center;">Total Proposed</th>
																							<th style="text-align:center;border-right:1px solid #fff;">Total %</th>
																							<th style="text-align:center;">Previous CTC</th>
																							<th style="text-align:center;">Proposed Increments</th>
																							<th style="text-align:center;">Increments %</th>
																							<th style="text-align:center;">CTC Benchmark</th>
																							<th style="text-align:center;">Total Proposed</th>
																							<th style="text-align:center;border-right:1px solid #fff;">Total %</th>
																						</tr>
																					</thead>
																					<tbody>
																						@foreach ($employeeTableDatanew as $history)
																						@php
																						$shouldShowRow =
																						$history->SalaryChange_Date == '2014-01-31' ||
																						$history->Previous_GrossSalaryPM != $history->TotalProp_GSPM ||
																						$history->Current_Designation != $history->Proposed_Designation;
																						@endphp
																						<tr>
																							<td class="text-center a">{{ $history->Current_Grade }}</td>
																							<td class="text-center b">{{ $history->Proposed_Grade }}</td>
																							<td class="c">{{ $history->Current_Designation }}</td>
																							<td class="d">{{ $history->Proposed_Designation }}</td>
																							<td class="text-center e">{{ \Carbon\Carbon::parse($history->SalaryChange_Date)->format('d M y') }}</td>

																							@php
																							$PreviousCTC = floatval($history->Previous_GrossSalaryPM);
																							$ProposedCTC = floatval($history->TotalProp_GSPM) + floatval($history->Incentive);
																							@endphp

																							<td class="text-right g">
																								@php
																								$salaryChangeYear = \Carbon\Carbon::parse($history->SalaryChange_Date)->year;
																								@endphp
																								@if($salaryChangeYear >= 2020)
																								-
																								@elseif($ProposedCTC == 0)
																								-
																								@else
																								{{ number_format($ProposedCTC, 0) }}
																								@endif
																							</td>

																							<td class="text-right g">
																								@if($salaryChangeYear >= 2020)
																								-
																								@elseif($history->TotalProp_PerInc_GSPM == 0)
																								-
																								@else
																								{{ number_format($history->TotalProp_PerInc_GSPM, 0) }}
																								@endif
																							</td>

																							<td class="text-right h">
																								<b>
																									@if($history->Proposed_ActualCTC == 0)
																									-
																									@else
																									{{ number_format($history->Proposed_ActualCTC, 0) }}/-
																									@endif
																								</b>
																							</td>

																							<td class="text-right i">
																								<b>
																									@if($history->ProIncCTC == 0)
																									-
																									@else
																									{{ number_format($history->ProIncCTC, 0) }}/-
																									@endif
																								</b>
																							</td>

																							<td class="j">
																								<b>
																									@if($history->Percent_ProIncCTC == 0)
																									-
																									@else
																									{{ number_format($history->Percent_ProIncCTC, 0) }}
																									@endif
																								</b>
																							</td>


																							<td class="k">
																								@if($history->ProCorrCTC == 0)
																								-
																								@else
																								{{ number_format($history->ProCorrCTC, 0) }}/-
																								@endif
																							</td>

																							<td class="l">
																								@if($history->Proposed_ActualCTC == 0)
																								-
																								@else
																								{{ number_format($history->Proposed_ActualCTC, 0) }}/-
																								@endif
																							</td>

																							@if($shouldShowRow)
																							<td class="m">
																								@if($history->TotalProp_PerInc_GSPM == 0)
																								-
																								@else
																								{{ number_format($history->TotalProp_PerInc_GSPM, 0) }}
																								@endif
																							</td>
																							@else
																							<td></td>
																							@endif

																							<td class="n"><b>{{ $history->Score }}</b></td>
																							<td class="o"><b>{{ $history->Rating }}</b></td>
																						</tr>
																						@endforeach
																					</tbody>
																					<tfoot>
																						<tr>
																							<td style="background-color: #accfd2;" colspan="15"></td>
																						</tr>
																					</tfoot>
																				</table>
																			</div>
																		</td>
																	</tr>
																	@endforeach
																</tbody>
															</table>
														</div>
														<div class="col-md-12 p-2">
															<div class="float-end" style="font-size:11px;">
																<span class="mr-2"><i class="ri-arrow-right-up-line me-1 align-middle danger"></i> Proposed </span>
																<span class="mr-2"><i class="ri-arrow-right-line me-1 align-middle success"></i> Current </span>
																<span class="mr-2"><i class="fa fa-history"></i> History </span>
																<span class="mr-2"><span style="padding: 2px 3px;font-size: 10px;background-color: #3b94b7;color: #fff;"><i class="las la-save"></i></span> Save </span>
																<span class="mr-2"><span style="padding: 2px 3px;font-size: 10px;background-color: #6fa22f;color: #fff;"><i class="las la-check-circle"></i></span> Submit</span>
																<span class="mr-2">
																	<span class="mr-2">
																		<span class="mr-2">
																			<span style="display: inline-block; width: 12px; height: 14px; background-color: #ffccd9; border: 1px solid #d6336c; vertical-align: middle; margin-right: 3px;"></span>
																			Utkarsh Scheme
																		</span>
															</div>
														</div>
													</div>
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
		<!-- Modal -->
		<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="ratingModalLabel">Notification</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						Ratings have been applied and refreshed. Please save the data again.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@include('employee.footer')
		<script>
			$(document).ready(function() {
				// Clear filter values on page load
				$('#department-filter').val('');
				$('#grade-filter').val('');
				$('#region-filter').val('');
				$('#Hod-filter').val('');
				$('#Rev-filter').val('');
				$('#BU-filter').val('');
				$('#Zone-filter').val('');

			});
			document.addEventListener("DOMContentLoaded", function() {
				$('tr.employee-data-row').each(function() {
					var row = $(this);
					var doj = row.find('td:nth-child(5)').text();

					// Check if the row has save or submit button
					var hasSave = row.find('.save-single-employee').length > 0;
					var hasSubmit = row.find('.submit-single-employee').length > 0;

					if (!hasSave && !hasSubmit) {
						// Disable all input fields inside this row
						row.find('.actual-input, .corr-input').prop('disabled', true);
					}

					// Recalculate row
					recalculateRow(row.get(0), doj, true);
				});

				setTimeout(calculateSummary, 500);
			});




			function filterRows() {
				const selectedDepartment = document.getElementById('department-filter').value.trim();
				const selectedGrade = document.getElementById('grade-filter').value.trim();
				const selectedReviewer = document.getElementById('Rev-filter')?.value.trim() || '';
				const selectedHOD = document.getElementById('Hod-filter')?.value.trim() || '';
				const selectedRegion = document.getElementById('region-filter')?.value.trim() || ''; // New region filter
				const selectedZone = document.getElementById('Zone-filter')?.value.trim() || ''; // New zone filter
				const selectedBU = document.getElementById('BU-filter')?.value.trim() || ''; // New BU filter

				const rows = document.querySelectorAll('.employee-data-row'); // Main data rows
				const visibleEmployeeIds = [];
				const regionFilter = document.getElementById('region-filter');
				const zoneFilter = document.getElementById('Zone-filter');
				const buFilter = document.getElementById('BU-filter');

				const summaryRow = document.querySelector('.summary-row'); // Target summary row

				// Show/Hide Region filter based on department selection
				if (regionFilter || zoneFilter || buFilter) {


					const $hod = $('#Hod-filter');
					const $rev = $('#Rev-filter');
					const $grade = $('#grade-filter');

					const $left = $('#left-filters');
					const $right = $('#right-filters');

					if (selectedDepartment.toLowerCase() === 'sls') {
						// Show BU, Zone, Region
						$('#BU-filter').show();
						$('#Zone-filter').show();
						$('#region-filter').show();

						// Move HOD, REV, GRADE to right
						$right.append($hod);
						$right.append($rev);
						$right.append($grade);
					} else {
						// Hide BU, Zone, Region
						$('#BU-filter').hide();
						$('#Zone-filter').hide();
						$('#region-filter').hide();

						// Move HOD, REV, GRADE back to left
						$left.append($hod);
						$left.append($rev);
						$left.append($grade);
					}
					// if (selectedDepartment.toLowerCase() === 'sls') {
					// 	regionFilter.style.display = 'inline';
					// 	zoneFilter.style.display = 'inline';
					// 	buFilter.style.display = 'inline';

					// } else {
					// 	regionFilter.style.display = 'none';
					// 	zoneFilter.style.display = 'none';
					// 	buFilter.style.display = 'none';

					// }

				}

				rows.forEach(function(row) {
					const employeeId = row.getAttribute('data-empid')?.trim(); // Get employeeId
					const extraRow = document.querySelector(`.employee-data-row-extra[data-empid="${employeeId}"]`);
					let grade = '';
					const gradeTd = row.querySelector('td.up-current-st'); // Get the <td>, not the input

					if (gradeTd && gradeTd.textContent.trim() !== '-') {
						grade = gradeTd.textContent.trim(); // Use grade from <td>
					} else {
						grade = extraRow?.querySelector('.current-st-grade')?.textContent.trim() || '';
					}
					const revName = row.querySelector('.revname')?.textContent.trim() || '';
					const HodName = row.querySelector('.hodname')?.textContent.trim() || '';
					const departmentCell = row?.querySelector('.dept-row')?.textContent.trim() || '';
					const regionCell = row?.querySelector('.hidden-reg')?.textContent.trim() || ''; // Region data

					// Match selected filters
					const matchesDepartment = !selectedDepartment || departmentCell.toLowerCase() === selectedDepartment.toLowerCase();
					const matchesGrade = !selectedGrade || grade.toLowerCase() === selectedGrade.toLowerCase();
					const matchesReviewer = !selectedReviewer || revName.toLowerCase() === selectedReviewer.toLowerCase();
					const matchesHOD = !selectedHOD || HodName.toLowerCase() === selectedHOD.toLowerCase();
					const matchesRegion = !selectedRegion || regionCell.toLowerCase() === selectedRegion.toLowerCase();
					const matchesZone = !selectedZone || row.querySelector('.zone')?.textContent.trim().toLowerCase() === selectedZone.toLowerCase();
					const matchesBU = !selectedBU || row.querySelector('.bu')?.textContent.trim().toLowerCase() === selectedBU.toLowerCase();
					console.log(matchesGrade);
					// Show or hide based on filter match
					if (matchesDepartment && matchesGrade && matchesReviewer && matchesHOD && matchesRegion && matchesZone && matchesBU) {
						row.style.display = 'table-row';
						if (extraRow) extraRow.style.display = 'table-row';
						// Check if row has save or submit buttons
						const hasSave = row.querySelector('.save-single-employee') !== null;
						const hasSubmit = row.querySelector('.submit-single-employee') !== null;

						if (!hasSave && !hasSubmit) {
							const actualInput = row.querySelector('.actual-input');
							const corrInput = row.querySelector('.corr-input');
							console.log(corrInput);

							actualInput.setAttribute('readonly', true);
							corrInput.setAttribute('readonly', true);

						}

						visibleEmployeeIds.push(employeeId);
					} else {
						row.style.display = 'none';
						if (extraRow) extraRow.style.display = 'none';
					}
				});

				// Hide all history rows first
				document.querySelectorAll('[id^="historymain-"]').forEach(row => {
					row.style.display = 'none';
				});

				// Show history rows only for visible employees
				visibleEmployeeIds.forEach(empId => {
					const historyRow = document.getElementById(`historymain-${empId}`);
					if (historyRow) {
						historyRow.style.display = 'table-row';
					}
				});
				if (summaryRow) {
					// Get the buttons by their IDs
					const exportLinkBlank = document.getElementById('export-link-blank');
					const exportLinkData = document.getElementById('export-link-data');
					const saveRatingsBtn = document.getElementById('saveRatingsBtn');
					const submitRatingsBtn = document.getElementById('submitRatingsBtn');

					if (visibleEmployeeIds.length > 0) {
						summaryRow.style.display = 'table-row';
						if (exportLinkBlank) exportLinkBlank.style.display = 'inline-block';
						if (exportLinkData) exportLinkData.style.display = 'inline-block';
						if (saveRatingsBtn) saveRatingsBtn.style.display = 'inline-block';
						if (submitRatingsBtn) submitRatingsBtn.style.display = 'inline-block';
					} else {
						if (exportLinkBlank) exportLinkBlank.style.display = 'none';
						if (exportLinkData) exportLinkData.style.display = 'none';
						if (saveRatingsBtn) saveRatingsBtn.style.display = 'none';
						if (submitRatingsBtn) submitRatingsBtn.style.display = 'none';
						// Reset all summary values to 0
						document.getElementById('total-prev-ctc').textContent = '0';
						document.getElementById('avg-prorata').textContent = '0';
						document.getElementById('avg-actual').textContent = '0';
						document.getElementById('total-ctc').textContent = '0';
						document.getElementById('total-corr').textContent = '0';
						document.getElementById('avg-corr-per').textContent = '0';
						document.getElementById('total-inc').textContent = '0';
						document.getElementById('total-final-ctc').textContent = '0';
						document.getElementById('avg-final-per').textContent = '0';
						document.getElementById('avg-totalVarPay').textContent = '0';
						document.getElementById('avg-totalTotalCtcPay').textContent = '0';
						document.getElementById('avg-totalCarAllow').textContent = '0';
						document.getElementById('avg-totalCommAllow').textContent = '0';
						document.getElementById('avg-totalTotalGross').textContent = '0';
					}
				}

				const ratingContainer = document.getElementById('ratingcontainer');

				// Condition: show only if Department or HOD is selected AND others are NOT
				const isDepartmentOrHodSelected = selectedDepartment !== '' || selectedHOD !== '';
				const isOtherFiltersSelected = selectedGrade !== '' || selectedReviewer !== '' || selectedRegion !== '' || selectedZone !== '' || selectedBU !== '';

				if (!isDepartmentOrHodSelected || isOtherFiltersSelected) {
					// Hide rating container and rating boxes
					ratingContainer.classList.add('d-none');
					const saveRatingsBtn = document.getElementById('saveRatingsBtn');
					const submitRatingsBtn = document.getElementById('submitRatingsBtn');
					const exportLinkBlank = document.getElementById('export-link-blank');
					const exportLinkData = document.getElementById('export-link-data');
					if (saveRatingsBtn) saveRatingsBtn.style.display = 'none';
					if (submitRatingsBtn) submitRatingsBtn.style.display = 'none';

					if (exportLinkBlank) exportLinkBlank.style.display = 'none';
					if (exportLinkData) exportLinkData.style.display = 'none';
					document.querySelectorAll('.rating-box').forEach(box => {
						box.classList.add('d-none');
					});
					updateSN();
					updateExportLink();
					setTimeout(calculateSummary, 500);

					return; // Exit early
				}
				const deptId = $('#department-filter option:selected').data('deptid');
				const hodactualid = $('#Hod-filter option:selected').data('hodid');
				const hodid = {{Auth::user()->EmployeeID}};
				const yearid = {{$PmsYId}};
				// Fetch ratings only if Dept or HOD selected and others are not
				if (isDepartmentOrHodSelected && !isOtherFiltersSelected) {
					$.ajax({
						url: '/get-department-ratings',
						method: 'GET',
						data: {
							deptid: deptId,
							hodid: hodid,
							yearid: yearid, // Make sure you have this value set globally or pass it in
							hodactualid: hodactualid // Same here
						},
						success: function(response) {
							if (response.success) {
								// Optional UI state control based on submission status
								if (response.all_submitted) {
									$('.overall-save').show();
									$('.overall-submit').show();
									$('.submit-single-employee, .save-single-employee').show();
									$('.actual-input, .corr-input').prop('disabled', false);
								} else if (response.allSubmittedsaved) {
									$('.overall-save').hide();
									$('.submit-single-employee, .save-single-employee').hide();
									$('.actual-input, .corr-input').prop('disabled', true);
									$('.overall-submit').hide();
								} else if (response.allSubmittedwithsomesaved) {
									$('.overall-save, .overall-submit').show();

								} else {
									$('.overall-save').show();
									$('.overall-submit').hide();
									$('.submit-single-employee, .save-single-employee').show();
									$('.actual-input, .corr-input').prop('disabled', false);

								}

								// Rating map to convert backend keys
								const ratingMap = {
									'rat_0': '0',
									'rat_1': '1',
									'rat_2': '2',
									'rat_25': '2.5',
									'rat_27': '2.7',
									'rat_29': '2.9',
									'rat_3': '3',
									'rat_32': '3.2',
									'rat_34': '3.4',
									'rat_35': '3.5',
									'rat_37': '3.7',
									'rat_39': '3.9',
									'rat_4': '4',
									'rat_42': '4.2',
									'rat_44': '4.4',
									'rat_45': '4.5',
									'rat_47': '4.7',
									'rat_49': '4.9',
									'rat_5': '5'
								};

								// Fill rating boxes only for visible employee IDs
								response.ratings.forEach(function(ratingData) {
									const formattedRating = ratingMap[ratingData.rating]; // e.g., converts '4.50' -> '4.5'
									const mappedRating = parseFloat(formattedRating).toString(); // ensures '4.0' -> '4'
									const value = ratingData.value;

									// Select the correct .rating-box with matching data-rating
									const box = document.querySelector(`.rating-box[data-rating="${mappedRating}"]:not(.d-none)`);
									if (box) {
										const input = box.querySelector('.rating-input');
										if (input) {
											input.value = value;
										}
									}
								});


							} else {
								// Reset if no ratings
								$('.overall-save').show();
								$('.overall-submit').hide();
								$('.rating-input').val('');
							}
						}
					});
				}


				// Show the container if conditions are met
				ratingContainer.classList.remove('d-none');
				document.querySelectorAll('.rating-box').forEach(box => {
					box.classList.remove('d-none');
				});

				const visibleRatings = new Set();

				// 1. Collect ratings from each visible employee row
				visibleEmployeeIds.forEach(empId => {
					const ratingCell = document.querySelector(`tr[data-empid="${empId}"] .row-rating`);
					if (ratingCell) {
						const rating = ratingCell.getAttribute('data-row-rating');
						if (rating) {
							visibleRatings.add(rating);
						}
					}
				});


				// Add this after showing/hiding the individual boxes
				let containerVisible = false;

				document.querySelectorAll('.rating-box').forEach(box => {
					const boxRating = box.getAttribute('data-rating');
					let matched = false;

					visibleRatings.forEach(rowRating => {
						if (boxRating === rowRating) {
							matched = true;
						}
					});

					if (matched) {
						box.classList.remove('d-none'); // Show the box by removing d-none
						containerVisible = true; // Mark that we need to show the container
					} else {
						box.classList.add('d-none'); // Hide the box by adding d-none
					}
				});

				// Show the container only if at least one rating box is visible
				if (containerVisible) {
					ratingContainer.classList.remove('d-none'); // Show the container
				} else {
					ratingContainer.classList.add('d-none'); // Keep the container hidden if no boxes are visible
				}
				// Send employee data for the visible rows
				let allEmployeeData = [];

				rows.forEach((row) => {
					const empid = row.dataset.empid;
					if (!visibleEmployeeIds.includes(empid)) return;

					let department = row.querySelector(".dept-row")?.innerText?.trim() || '';
					let designationInput = row.querySelector('input.up-current-st');
					let designation = designationInput ? designationInput.value.trim() : '';

					if (!designation || designation === '-') {
						let nextRow = row.nextElementSibling;
						let currentDesigInput = nextRow?.querySelector('input.current-st');
						designation = currentDesigInput ? currentDesigInput.value.trim() : '';
					}

					let upCurrentStCells = row.querySelectorAll('td.up-current-st');
					let grade = upCurrentStCells.length > 0 ? upCurrentStCells[0].innerText.trim() : '';

					if (!grade || grade === '-') {
						let nextRow = row.nextElementSibling;
						let currentGradeCell = nextRow?.querySelector('td.current-st-grade');
						grade = currentGradeCell ? currentGradeCell.innerText.trim() : '';
					}

					let empCurrGrossPM = row.querySelector(".EmpCurrGrossPM")?.innerText?.trim() || '';
					let prevFixed = row.querySelector(".prev-fixed")?.innerText?.trim() || '';
					let totalCtc = row.querySelector(".total-ctc")?.innerText?.trim() || '';

					allEmployeeData.push({
						employee_id: empid,
						department_name: department,
						designation_name: designation,
						grade_name: grade,
						old_gross_salary: empCurrGrossPM,
						old_ctc: prevFixed,
						fixed_ctc: totalCtc
					});
				});

				// Send data to server
				fetch("{{ route('sendemployeeinfo') }}", {
						method: "POST",
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
						},
						body: JSON.stringify({
							employees: allEmployeeData,
						})
					})
					.then(response => response.json()) // Parse the JSON response
					.then(data => {
						Object.entries(data).forEach(([empId, values]) => {
							const row = document.querySelector(`tr[data-empid="${empId}"]`);
							if (row) {

								const proposedctcnew = parseFloat(row.querySelector('.total-ctc').textContent) || 0;
								const carallow = parseFloat(row.querySelector('.car-allow').textContent) || 0;
								const commallow = parseFloat(row.querySelector('.comm-allow').textContent) || 0;

								const variablePay = parseFloat(values.variable_pay) || 0;
								const total = variablePay + proposedctcnew;
								const totalgross = commallow + carallow + total;
								row.querySelector('.variable-pay').textContent = values.variable_pay;
								row.querySelector('.total-pay-ctc').textContent = total;
								row.querySelector('.total-gross').textContent = totalgross;


							}
						});
					})
					.catch(error => {
						console.error('Error:', error);
					});

				updateSN();
				updateExportLink();
				setTimeout(calculateSummary, 500);


			}
			$(document).ready(function() {
				// Handle 'Apply All Ratings' button click

				$('#applyAllRatings').on('click', function() {
					$('.rating-box').each(function() {
						const box = $(this);
						const ratingVal = box.data('rating');
						let inputVal = $.trim(box.find('.rating-input').val());

						if (inputVal === '' || inputVal === '0') {
							inputVal = '0';
						}

						$('.employee-data-row').each(function() {
							const row = $(this);
							const rowRating = row.find('.row-rating').data('row-rating');
							const actualInput = row.find('.actual-input');

							const floatRowRating = parseFloat(rowRating).toFixed(2);
							const floatBoxRating = parseFloat(ratingVal).toFixed(2);

							if (floatRowRating === floatBoxRating) {
								const currentActual = $.trim(actualInput.val());

								if (currentActual !== inputVal) {
									actualInput.val(inputVal);
									recalculateRow(row.get(0), row.find('td:nth-child(5)').text(), true);
									setTimeout(calculateSummary, 500);

									// 🔁 FETCH logic directly here
									const empid = row.data('empid');
									if (!empid) return;

									let department = row.find(".dept-row").text().trim() || '';
									let designation = row.find('input.up-current-st').val()?.trim() || '';

									if (!designation || designation === '-') {
										let nextRow = row.next();
										let currentDesigInput = nextRow.find('input.current-st');
										designation = currentDesigInput.val()?.trim() || '';
									}

									let grade = row.find('td.up-current-st').first().text().trim();
									if (!grade || grade === '-') {
										let nextRow = row.next();
										grade = nextRow.find('td.current-st-grade').text().trim() || '';
									}

									let empCurrGrossPM = row.find(".EmpCurrGrossPM").text().trim() || '';
									let prevFixed = row.find(".prev-fixed").text().trim() || '';
									let totalCtc = row.find(".total-ctc").text().trim() || '';

									let singleEmployeeData = {
										employees: [{
											employee_id: empid,
											department_name: department,
											designation_name: designation,
											grade_name: grade,
											old_gross_salary: empCurrGrossPM,
											old_ctc: prevFixed,
											fixed_ctc: totalCtc
										}]
									};

									fetch("{{ route('sendemployeeinfo') }}", {
											method: "POST",
											headers: {
												'Content-Type': 'application/json',
												'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
											},
											body: JSON.stringify(singleEmployeeData)
										})
										.then(response => response.json())
										.then(data => {
											const values = data[empid];
											if (!values) return;

											const proposedctcnew = parseFloat(row.find('.total-ctc').text() || 0);
											const carallow = parseFloat(row.find('.car-allow').text() || 0);
											const commallow = parseFloat(row.find('.comm-allow').text() || 0);
											const variablePay = parseFloat(values.variable_pay) || 0;
											const total = variablePay + proposedctcnew;
											const totalgross = commallow + carallow + total;

											row.find('.variable-pay').text(values.variable_pay);
											row.find('.total-pay-ctc').text(total);
											row.find('.total-gross').text(totalgross);
										})
										.catch(error => console.error('Error:', error));
								}
							}
						});
					});

					$('#ratingModal').modal('show');
				});


			});

			// Bind the function to filter events
			document.getElementById('department-filter').addEventListener('change', filterRows);
			document.getElementById('grade-filter').addEventListener('change', function() {
				resetBUZoneRegion();
				filterRows();
			});

			const revFilter = document.getElementById('Rev-filter');
			if (revFilter) {
				revFilter.addEventListener('change', function() {
					// $('#Hod-filter').val('');
					resetBUZoneRegion();
					filterRows();
				});
			}

			const hodFilter = document.getElementById('Hod-filter');
			if (hodFilter) {
				hodFilter.addEventListener('change', function() {
					// $('#Rev-filter').val('');
					resetBUZoneRegion();
					filterRows();
				});
			}

			$('#BU-filter').on('change', function() {
				resetHodRevGrade();

				let buId = $(this).val();

				// Reset zone and region before loading new ones
				$('#Zone-filter').html('<option value="">Select Zone</option>').val('');
				$('#region-filter').html('<option value="">Select Region</option>').val('');

				if (!buId || buId.toLowerCase() === 'all') {
					filterRows();
				} else {
					$.ajax({
						url: '{{ route("get_zone_by_bu") }}',
						type: 'GET',
						data: {
							bu: buId
						},
						success: function(data) {
							$('#Zone-filter').empty().append('<option value="">Select Zone</option>');
							$.each(data.zoneList, function(index, zone) {
								$('#Zone-filter').append('<option value="' + zone.zone_id + '">' + zone.zone_name + '</option>');
							});
							filterRows();
						}
					});
				}
			});

			// Zone filter change: load regions or reset
			$('#Zone-filter').on('change', function() {
				resetHodRevGrade();

				let zoneId = $(this).val();

				if (!zoneId) {
					$('#region-filter').html('<option value="">Select Region</option>').val('');
					filterTable();
					return;
				}

				$('#region-filter').html('<option value="">Loading...</option>').val('');

				$.ajax({
					url: '{{ route("get_region_by_zone") }}',
					type: 'GET',
					data: {
						zone: zoneId
					},
					success: function(data) {
						$('#region-filter').empty().append('<option value="">Select Region</option>');
						$.each(data.regionList, function(index, region) {
							$('#region-filter').append('<option value="' + region.region_name + '">' + region.region_name + '</option>');
						});
						filterRows();
					}
				});
			});
			const regionFilter = document.getElementById('region-filter');

			if (regionFilter) {
				regionFilter.addEventListener('change', function() {
					resetHodRevGrade();
					filterRows();
				});
			}

			function resetBUZoneRegion() {
				$('#BU-filter').val('');
				$('#Zone-filter').val('');
				$('#region-filter').val('');
			}

			function resetHodRevGrade() {
				$('#Hod-filter').val('');
				$('#Rev-filter').val('');
				$('#grade-filter').val('');
			}

			function updateSN() {
				let sn = 1;
				$('#employeetablemang tbody tr.employee-data-row:visible').each(function() {
					$(this).find('td:nth-child(1)').text(sn++); // Update SN in first column
				});
			}
			$(document).ready(function() {
				// Toggle visibility of employee history when clicking on the history button
				$('.toggle-history').on('click', function(e) {
					e.preventDefault(); // Prevent default link behavior

					// Get the employee code (EmpCode)
					var empId = $(this).data('empid');

					// Ensure the corresponding historymain row is visible (remove display:none)
					$('#historymain-' + empId).css('display', 'table-row');

					// Toggle the visibility of the detailed history row
					$('#history-' + empId).toggle();

					// Change the icon to indicate expanded/collapsed state
					if ($('#history-' + empId).is(':visible')) {
						$(this).find('i').removeClass('fa-history').addClass('fa-times');
					} else {
						$(this).find('i').removeClass('fa-times').addClass('fa-history');
					}
				});
			});

			function formatNumber(val) {
				const num = parseFloat(val);
				if (isNaN(num)) return 0;
				return Number.isInteger(num) ? num : num.toFixed(2);
			}

			function formatNumberround(val) {
				return Math.round(val).toString();

			}

			document.querySelectorAll('tr.employee-data-row').forEach(row => {
				const doj = row.querySelector('td:nth-child(5)').textContent;
				recalculateRow(row, doj, true); // true means "force update"
				setTimeout(calculateSummary, 500);

			});

			// function calculateProrata(row, doj) {

			// 	const actualInput = row.querySelector('.actual-input');

			// 	const prorataEl = row.querySelector('.prorata');
			// 	const utkarshSchemeCell = row.querySelector('.utkarshscheme');
			// 	const isUtkarshYes = utkarshSchemeCell && utkarshSchemeCell.textContent.trim().toLowerCase() === 'yes';
			// 	highlightUtkarshRows();
			// 	// Add 50 in calculation if Utkarsh scheme is yes
			// 	const actual = parseFloat(actualInput.value) || 0;
			// 	const globalRatingPercentage = parseFloat(row.querySelector('.rating-input')?.value) || 0;

			// 	const dojParts = doj.split('-');
			// 	const dojDate = new Date(`${dojParts[2]}-${dojParts[1]}-${dojParts[0]}`);
			// 	const currentDate = new Date();

			// 	let prorata = 0;
			// 	const finalActual = actual > 0 ? actual : globalRatingPercentage;
			// 	const threeMonthPortion = (finalActual * 3) / 12;

			// 		function formatDateToYMDLocal(date) {
			// 			const d = new Date(date);
			// 			const year = d.getFullYear();
			// 			const month = String(d.getMonth() + 1).padStart(2, '0'); // Months are 0-based
			// 			const day = String(d.getDate()).padStart(2, '0');
			// 			return `${year}-${month}-${day}`;
			// 		}

			// 		const dojnew = formatDateToYMDLocal(dojDate);

			// 		if (dojnew <= '2023-06-30') {
			// 			prorata = finalActual + threeMonthPortion;
			// 		} else if (dojnew >= '2023-07-01' && dojnew <= '2023-12-31') {
			// 			const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));
			// 			prorata = ((workingDays / 360) * finalActual) + threeMonthPortion;
			// 		} else if (dojnew >= '2024-01-01' && dojnew <= '2024-09-30') {
			// 			const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));

			// 			prorata = ((workingDays / 360) * finalActual) + threeMonthPortion;
			// 		}
			// 	// prorataEl.textContent = parseFloat(prorata).toFixed(1);

			// 	return prorata;
			// }

			function calculateProrata(row, doj) {
				const actualInput = row.querySelector('.actual-input');
				const prorataEl = row.querySelector('.prorata');
				const utkarshSchemeCell = row.querySelector('.utkarshscheme');
				const isUtkarshYes = utkarshSchemeCell && utkarshSchemeCell.textContent.trim().toLowerCase() === 'yes';

				highlightUtkarshRows();

				const actual = parseFloat(actualInput.value) || 0;
				const globalRatingPercentage = parseFloat(row.querySelector('.rating-input')?.value) || 0;

				const dojParts = doj.split('-');
				const dojDate = new Date(`${dojParts[2]}-${dojParts[1]}-${dojParts[0]}`);

				const finalActual = actual > 0 ? actual : globalRatingPercentage;
				const threeMonthPortion = (finalActual * 3) / 12;

				function formatDateToYMDLocal(date) {
					const d = new Date(date);
					const year = d.getFullYear();
					const month = String(d.getMonth() + 1).padStart(2, '0'); // Months are 0-based
					const day = String(d.getDate()).padStart(2, '0');
					return `${year}-${month}-${day}`;
				}

				const dojnew = formatDateToYMDLocal(dojDate);

				let prorata = 0;

				if (isUtkarshYes && actual > 0) {
					// Utkarsh scheme: add 50 only if actual > 0
					if (dojnew <= '2023-06-30') {
						prorata = 50 + finalActual + threeMonthPortion;
					} else if (dojnew >= '2023-07-01' && dojnew <= '2023-12-31') {
						const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));
						prorata = 50 + ((workingDays / 360) * finalActual) + threeMonthPortion;
					} else if (dojnew >= '2024-01-01' && dojnew <= '2024-09-30') {
						const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));
						prorata = 50 + ((workingDays / 360) * finalActual) + threeMonthPortion;
					}
				} else {
					// Normal calculation (no +50 if actual == 0)
					if (dojnew <= '2023-06-30') {
						prorata = finalActual + threeMonthPortion;
					} else if (dojnew >= '2023-07-01' && dojnew <= '2023-12-31') {
						const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));
						prorata = ((workingDays / 360) * finalActual) + threeMonthPortion;
					} else if (dojnew >= '2024-01-01' && dojnew <= '2024-09-30') {
						const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));
						prorata = ((workingDays / 360) * finalActual) + threeMonthPortion;
					}
				}

				// Optionally update UI
				// prorataEl.textContent = prorata.toFixed(1);

				return prorata;
			}


			function calculateWorkingDays(startDate, endDate) {
				const start = new Date(startDate);
				const end = new Date(endDate);

				// Normalize time
				start.setHours(0, 0, 0, 0);
				end.setHours(0, 0, 0, 0);

				// Step 1: Days in first (joining) month — fixed to max 30 days
				let daysInStartMonth = 30 - (start.getDate() - 1);

				// Step 2: Move start to next full month
				const firstFullMonth = new Date(start.getFullYear(), start.getMonth() + 1, 1);

				// Step 3: Full 30-day months between
				let totalMonths = 0;
				let temp = new Date(firstFullMonth);
				while (temp < end) {
					const next = new Date(temp.getFullYear(), temp.getMonth() + 1, 1);
					if (next <= end) totalMonths++;
					temp = next;
				}

				// Step 4: Days in final partial month — capped to 30 days max
				let extraDays = 0;
				const endMonthStart = new Date(end.getFullYear(), end.getMonth(), 1);
				if (end > endMonthStart) {
					extraDays = Math.min(end.getDate(), 30);
				}

				// Total days: partial start + full 30*months + extra
				return Math.round(daysInStartMonth + (totalMonths * 30) + extraDays);
			}

			function recalculateRow(row, doj, forceUpdate = false) {
				const prevFixedEl = row.querySelector('.prev-fixed');
				const prorataEl = row.querySelector('.prorata');
				const corrPerEl = row.querySelector('.corr-per');
				let visibleProrata = 0;
				let visibleCorr = 0;
				let finalPercent = 0;
				highlightUtkarshRows();

				if (prorataEl && corrPerEl) {
					visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
					visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

					setTimeout(() => {
						visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
						visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;
						finalPercent = visibleProrata + visibleCorr;
						const finalPerEl = row.querySelector('.final-inc');
						finalPerEl.textContent = formatNumber(finalPercent);
					}, 50);
				}

				const finalPerEl = row.querySelector('.final-inc');
				if (finalPerEl) finalPerEl.textContent = formatNumber(finalPercent);

				const actualInput = row.querySelector('.actual-input');
				const corrInput = row.querySelector('.corr-input');
				const ctcEl = row.querySelector('.ctc');
				const totalCtcEl = row.querySelector('.total-ctc');
				const maxVCtcEl = row.querySelector('.max-ctc');
				const maxctcannualEl = row.querySelector('.EmpCurrAnnualBasic');
				const extraRow = row.nextElementSibling;
				const isExtraRow = extraRow?.classList.contains('employee-data-row-extra');

				if (finalPerEl) finalPerEl.textContent = formatNumber(finalPercent);

				const prevFixed = parseFloat(prevFixedEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
				const actual = parseFloat(actualInput?.value) || 0;
				const corr = parseFloat(corrInput?.value) || 0;

				if (prevFixed === 0) return;

				const triggeredByCorr = document.activeElement === corrInput;
				const prorata = !triggeredByCorr ? calculateProrata(row, doj) : visibleProrata;

				const baseIncrement = (prevFixed * parseFloat(prorata).toFixed(1)) / 100;
				let totalInc = baseIncrement + corr;
				let totalCTC = prevFixed + (prevFixed * visibleProrata / 100);
				let totalCTCInc = prevFixed + totalInc;

				const corrPercent = ((corr / prevFixed) * 100);
				const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
				const maxctcannual = parseFloat(maxctcannualEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

				let totalCTCProrata = (prorata / 100) * prevFixed + prevFixed;
				row.querySelector('.totctcnew').textContent = totalCTCProrata.toFixed(2);


				// Delay check to get updated `.total-ctc` value
				setTimeout(() => {
					const totalCtcElForCap = parseFloat(totalCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const accurateProratadelayed = calculateProrata(row, doj);

					const cappingcheckonload = parseFloat((prevFixed + ((accurateProratadelayed / 100) * prevFixed)).toFixed(1));

					if ((cappingcheckonload > maxVCtc || totalCtcElForCap > maxVCtc) && maxVCtc > 0) {
						row.classList.add('highlight-row');
						row.style.setProperty('background-color', '#f8e49d', 'important');
						if (isExtraRow) {
							extraRow.style.setProperty('background-color', '#f8e49d', 'important');
						}
					}
				}, 500);

				// Immediate check for capped prorata
				if (totalCTCProrata > maxVCtc && maxVCtc > 0 && !triggeredByCorr) {
					const accurateProrata = calculateProrata(row, doj);
					const roundedProRataNew = ((accurateProrata * maxctcannual) / 100 + prevFixed - prevFixed) / prevFixed * 100;

					const cappedIncrement = (maxctcannual * prorata) / 100;
					const totalCTCcap = prevFixed + cappedIncrement + corr;

					if (!triggeredByCorr) {
						ctcEl.textContent = (prevFixed + ((roundedProRataNew / 100) * prevFixed)).toFixed(1);
						prorataEl.textContent = roundedProRataNew.toFixed(2);
					}

					row.querySelector('.inc').textContent = formatNumber(totalCTCcap - prevFixed);
					totalCtcEl.textContent = formatNumberround(totalCTCcap);
					if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
					if (finalPerEl) finalPerEl.textContent = formatNumber(finalPercent);
					// Variable pay + gross
					const proposedctcnew = parseFloat(totalCtcEl.textContent) || 0;
					const carallow = parseFloat(row.querySelector('.car-allow')?.textContent) || 0;
					const commallow = parseFloat(row.querySelector('.comm-allow')?.textContent) || 0;
					const variablePay = parseFloat(row.querySelector('.variable-pay')?.textContent) || 0
					const total = variablePay + proposedctcnew;
					const totalgross = commallow + carallow + total;

					row.querySelector('.total-pay-ctc').textContent = total;
					row.querySelector('.total-gross').textContent = totalgross;
				} else {
					// Normal flow without capping
					if (!triggeredByCorr) {
						ctcEl.textContent = (prevFixed + ((prorata / 100) * prevFixed)).toFixed(1);
						prorataEl.textContent = prorata.toFixed(2);
					}

					const totalctcpro = parseFloat(ctcEl.textContent) + corr;
					totalCtcEl.textContent = formatNumberround(totalctcpro);
					row.querySelector('.inc').textContent = formatNumber(totalctcpro - prevFixed);
					if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
					if (finalPerEl) finalPerEl.textContent = formatNumber(finalPercent);

					// Variable pay + gross
					const proposedctcnew = parseFloat(totalCtcEl.textContent) || 0;
					const carallow = parseFloat(row.querySelector('.car-allow')?.textContent) || 0;
					const commallow = parseFloat(row.querySelector('.comm-allow')?.textContent) || 0;
					const variablePay = parseFloat(row.querySelector('.variable-pay')?.textContent) || 0
					const total = variablePay + proposedctcnew;
					const totalgross = commallow + carallow + total;

					row.querySelector('.total-pay-ctc').textContent = total;
					row.querySelector('.total-gross').textContent = totalgross;
				}
			}

			function calculateSummary() {
				let totalPrev = 0,
					totalProposedCTC = 0,
					totalCorr = 0,
					totalCorrPercent = 0,
					totalInc = 0,
					totalFinalCTC = 0,
					totalProRata = 0,
					totalActual = 0,
					totalFinalPercent = 0,
					totalVarPay = 0,
					totalTotalCtcPay = 0,
					totalCarAllow = 0,
					totalCommAllow = 0,
					totalTotalGross = 0;

				let rowCount = 0;

				// Wrap the calculation in a function that will be called after a small delay
				setTimeout(function() {
					document.querySelectorAll('tr.employee-data-row').forEach(row => {
						if (row.offsetParent === null) return;

						const getValue = (selector) => parseFloat(row.querySelector(selector)?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const getInputValue = (selector) => parseFloat(row.querySelector(selector)?.value) || 0;

						const prevFixed = getValue('.prev-fixed');
						const prorata = getValue('.prorata');
						const actual = getInputValue('.actual-input');
						const proposedCtc = getValue('.ctc');
						const corr = getInputValue('.corr-input');
						const corrPer = getValue('.corr-per');
						const inc = getValue('.inc');
						const finalCtc = getValue('.total-ctc');
						const finalPer = getValue('.final-inc');
						const varPay = getValue('.variable-pay');
						const totalCtcPay = getValue('.total-pay-ctc');
						const carAllow = getValue('.car-allow');
						const commAllow = getValue('.comm-allow');
						const totalGross = getValue('.total-gross');

						totalPrev += prevFixed;
						totalProposedCTC += proposedCtc;
						totalCorr += corr;
						totalCorrPercent += corrPer;
						totalInc += inc;
						totalFinalCTC += finalCtc;
						totalProRata += prorata;
						totalActual += actual;
						totalFinalPercent += finalPer;

						totalVarPay += varPay;
						totalTotalCtcPay += totalCtcPay;
						totalCarAllow += carAllow;
						totalCommAllow += commAllow;
						totalTotalGross += totalGross;

						rowCount++;
					});

					if (rowCount === 0) return;

					const avgProRata = (totalProRata / rowCount).toFixed(2);
					const avgActual = totalPrev !== 0 ? (((totalProposedCTC - totalPrev) / totalPrev) * 100).toFixed(2) : '0.00';
					const avgCorrPer = totalPrev !== 0 ? ((totalCorr / totalPrev) * 100).toFixed(2) : '0.00';
					const avgFinalPer = (parseFloat(avgActual) + parseFloat(avgCorrPer)).toFixed(2);

					document.getElementById('total-prev-ctc').textContent = formatNumber(totalPrev);
					document.getElementById('avg-prorata').textContent = avgProRata;
					document.getElementById('avg-actual').textContent = avgActual;
					document.getElementById('total-ctc').textContent = formatNumber(totalProposedCTC);
					document.getElementById('total-corr').textContent = formatNumber(totalCorr);
					document.getElementById('avg-corr-per').textContent = avgCorrPer;
					document.getElementById('total-inc').textContent = formatNumber(totalInc);
					document.getElementById('total-final-ctc').textContent = formatNumber(totalFinalCTC);
					document.getElementById('avg-final-per').textContent = avgFinalPer;

					document.getElementById('avg-totalVarPay').textContent = formatNumber(totalVarPay);
					document.getElementById('avg-totalTotalCtcPay').textContent = formatNumber(totalTotalCtcPay);
					document.getElementById('avg-totalCarAllow').textContent = formatNumber(totalCarAllow);
					document.getElementById('avg-totalCommAllow').textContent = formatNumber(totalCommAllow);
					document.getElementById('avg-totalTotalGross').textContent = formatNumber(totalTotalGross);
				}, 200); // Delay the execution by 200ms to give the page time to load/update
			}

			function checkForCappingNotification(rating) {
				let cappingExceeded = false;

				const mainRows = document.querySelectorAll('tr.employee-data-row');

				mainRows.forEach(row => {
					if (getComputedStyle(row).display === 'none') return;

					const ratingCell = row.querySelector('.row-rating');
					if (!ratingCell) return;

					const rowRating = parseFloat(ratingCell.textContent.trim()).toFixed(2);
					if (parseFloat(rowRating) !== parseFloat(rating)) return;

					const ctcEl = row.querySelector('.total-ctc');
					const maxVCtcEl = row.querySelector('.max-ctc');
					const totalCTC = parseFloat(ctcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

					const extraRow = row.nextElementSibling;
					const isExtraRow = extraRow?.classList.contains('employee-data-row-extra');

					if (maxVCtc > 0 && totalCTC > maxVCtc) {
						cappingExceeded = true;
						row.style.backgroundColor = '#f8e49d';
						if (isExtraRow) {
							extraRow.style.backgroundColor = '#f8e49d';
						}
					} else {
						row.style.backgroundColor = '';
						if (isExtraRow) {
							extraRow.style.backgroundColor = '';
						}
					}
				});

				const notification = document.getElementById('cappingNotification');
				if (cappingExceeded) {
					notification.classList.remove('d-none'); // Show notification
				} else {
					notification.classList.add('d-none'); // Hide notification
				}

			}
			document.querySelectorAll('.actual-input, .corr-input').forEach(input => {
				input.addEventListener('input', function() {
					let value = this.value;

					// Format input
					value = value.replace(/[^0-9.]/g, '');
					let parts = value.split('.');
					if (parts.length > 2) value = parts[0] + '.' + parts.slice(1).join('');
					if (value.replace('.', '').length > 10) {
						value = parts.length === 2 ?
							parts[0].slice(0, 10) + '.' + parts[1] :
							value.slice(0, 10);
					}
					this.value = value === '' ? '' : value;

					// Recalculate UI
					const row = this.closest('tr');
					const doj = row?.querySelector('td:nth-child(5)')?.textContent?.trim() || '';
					const rating = parseFloat(row?.querySelector('.row-rating')?.textContent?.trim() || '0').toFixed(2);
					recalculateRow(row, doj, true);
					checkForCappingNotification(rating);
					setTimeout(calculateSummary, 500);


					// Get employee ID directly from the input
					const empid = this.dataset.corrEmpid || this.dataset.empid || this.dataset.actualEmpid;
					if (!empid) return;

					// Find the row by data attribute (you can unify your tr with data-empid="{{ $row['EmployeeID'] }}")
					const empRow = document.querySelector(`tr[data-empid="${empid}"]`);
					if (!empRow) return;
					let department = empRow.querySelector(".dept-row")?.innerText?.trim() || '';
					let designationInput = empRow.querySelector('input.up-current-st');
					let designation = designationInput?.value.trim() || '';

					if (!designation || designation === '-') {
						let nextRow = empRow.nextElementSibling;
						let currentDesigInput = nextRow?.querySelector('input.current-st');
						designation = currentDesigInput?.value.trim() || '';
					}

					let gradeCell = empRow.querySelectorAll('td.up-current-st');
					let grade = gradeCell.length > 0 ? gradeCell[0].innerText.trim() : '';
					if (!grade || grade === '-') {
						let nextRow = empRow.nextElementSibling;
						let currentGradeCell = nextRow?.querySelector('td.current-st-grade');
						grade = currentGradeCell?.innerText.trim() || '';
					}

					let empCurrGrossPM = empRow.querySelector(".EmpCurrGrossPM")?.innerText?.trim() || '';
					let prevFixed = empRow.querySelector(".prev-fixed")?.innerText?.trim() || '';
					let totalCtc = empRow.querySelector(".total-ctc")?.innerText?.trim() || '';

					let singleEmployeeData = {
						employees: [{
							employee_id: empid,
							department_name: department,
							designation_name: designation,
							grade_name: grade,
							old_gross_salary: empCurrGrossPM,
							old_ctc: prevFixed,
							fixed_ctc: totalCtc
						}]
					};

					// 🔁 Send only this one employee
					fetch("{{ route('sendemployeeinfo') }}", {
							method: "POST",
							headers: {
								'Content-Type': 'application/json',
								'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
							},
							body: JSON.stringify(singleEmployeeData)
						})
						.then(response => response.json())
						.then(data => {
							const values = data[empid];
							if (!values) return;

							const proposedctcnew = parseFloat(empRow.querySelector('.total-ctc')?.textContent || 0);
							const carallow = parseFloat(empRow.querySelector('.car-allow')?.textContent || 0);
							const commallow = parseFloat(empRow.querySelector('.comm-allow')?.textContent || 0);
							const variablePay = parseFloat(values.variable_pay) || 0;
							const total = variablePay + proposedctcnew;
							const totalgross = commallow + carallow + total;

							empRow.querySelector('.variable-pay').textContent = values.variable_pay;
							empRow.querySelector('.total-pay-ctc').textContent = total;
							empRow.querySelector('.total-gross').textContent = totalgross;
						})
						.catch(error => console.error('Error:', error));
				});
			});

			document.addEventListener('input', function(event) {
				if (event.target.matches('.rating-input')) {
					const ratingBox = event.target.closest('.rating-box');
					const rating = ratingBox ? ratingBox.dataset.rating : undefined;
					if (!rating) return;

					let value = event.target.value.replace(/[^0-9.]/g, '');
					const parts = value.split('.');
					if (parts.length > 2) value = parts[0] + '.' + parts[1]; // Keep only first decimal

					if (value === '') {
						event.target.value = '';
						document.querySelectorAll('tr.employee-data-row').forEach(row => {
							if (row.offsetParent === null) return;
							const ratingCell = row.querySelector('.row-rating');
							if (!ratingCell || ratingCell.textContent.trim() !== rating) return;

							const actualInput = row.querySelector('.actual-input');
							const doj = row.querySelector('td:nth-child(5)').textContent;

							if (actualInput && !actualInput.disabled && !actualInput.hasAttribute('readonly')) {
								actualInput.value = '';
								recalculateRow(row, doj, true);
								checkForCappingNotification(rating);
								setTimeout(calculateSummary, 500);

								// ✅ Also send the fetch request even on blank
								const empid = row.dataset.empid;
								if (!empid) return;

								let department = row.querySelector(".dept-row")?.innerText?.trim() || '';
								let designationInput = row.querySelector('input.up-current-st');
								let designation = designationInput?.value.trim() || '';

								if (!designation || designation === '-') {
									let nextRow = row.nextElementSibling;
									let currentDesigInput = nextRow?.querySelector('input.current-st');
									designation = currentDesigInput?.value.trim() || '';
								}

								let gradeCell = row.querySelectorAll('td.up-current-st');
								let grade = gradeCell.length > 0 ? gradeCell[0].innerText.trim() : '';
								if (!grade || grade === '-') {
									let nextRow = row.nextElementSibling;
									let currentGradeCell = nextRow?.querySelector('td.current-st-grade');
									grade = currentGradeCell?.innerText.trim() || '';
								}

								let empCurrGrossPM = row.querySelector(".EmpCurrGrossPM")?.innerText?.trim() || '';
								let prevFixed = row.querySelector(".prev-fixed")?.innerText?.trim() || '';
								let totalCtc = row.querySelector(".total-ctc")?.innerText?.trim() || '';

								let singleEmployeeData = {
									employees: [{
										employee_id: empid,
										department_name: department,
										designation_name: designation,
										grade_name: grade,
										old_gross_salary: empCurrGrossPM,
										old_ctc: prevFixed,
										fixed_ctc: totalCtc
									}]
								};

								fetch("{{ route('sendemployeeinfo') }}", {
										method: "POST",
										headers: {
											'Content-Type': 'application/json',
											'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
										},
										body: JSON.stringify(singleEmployeeData)
									})
									.then(response => response.json())
									.then(data => {
										const values = data[empid];
										if (!values) return;

										const proposedctcnew = parseFloat(row.querySelector('.total-ctc')?.textContent || 0);
										const carallow = parseFloat(row.querySelector('.car-allow')?.textContent || 0);
										const commallow = parseFloat(row.querySelector('.comm-allow')?.textContent || 0);
										const variablePay = parseFloat(values.variable_pay) || 0;
										const total = variablePay + proposedctcnew;
										const totalgross = commallow + carallow + total;

										row.querySelector('.variable-pay').textContent = values.variable_pay;
										row.querySelector('.total-pay-ctc').textContent = total;
										row.querySelector('.total-gross').textContent = totalgross;
									})
									.catch(error => console.error('Error:', error));
							}
						});
						return;
					}


					event.target.value = value;

					if (value.endsWith('.')) return;

					let percentIncrease = parseFloat(value);
					if (isNaN(percentIncrease)) return;

					// Format with precision
					if (/^\d+\.0+$/.test(value)) {
						event.target.value = value;
					} else if (percentIncrease % 1 === 0) {
						event.target.value = percentIncrease.toFixed(0);
					} else if (percentIncrease * 10 % 1 === 0) {
						event.target.value = percentIncrease.toFixed(1);
					} else {
						event.target.value = percentIncrease.toFixed(2);
					}

					// Update related rows and send employee data
					document.querySelectorAll('tr.employee-data-row').forEach(row => {
						if (row.offsetParent === null) return;

						const ratingCell = row.querySelector('.row-rating');
						if (!ratingCell || ratingCell.textContent.trim() !== rating) return;

						const actualInput = row.querySelector('.actual-input');
						const doj = row.querySelector('td:nth-child(5)').textContent;

						if (actualInput && !actualInput.disabled && !actualInput.hasAttribute('readonly')) {
							actualInput.value = percentIncrease.toFixed(2);
							recalculateRow(row, doj, true);
							checkForCappingNotification(rating);
							setTimeout(calculateSummary, 500);

							// 🔁 FETCH: Send individual employee data
							const empid = row.dataset.empid;
							if (!empid) return;

							let department = row.querySelector(".dept-row")?.innerText?.trim() || '';
							let designationInput = row.querySelector('input.up-current-st');
							let designation = designationInput?.value.trim() || '';

							if (!designation || designation === '-') {
								let nextRow = row.nextElementSibling;
								let currentDesigInput = nextRow?.querySelector('input.current-st');
								designation = currentDesigInput?.value.trim() || '';
							}

							let gradeCell = row.querySelectorAll('td.up-current-st');
							let grade = gradeCell.length > 0 ? gradeCell[0].innerText.trim() : '';
							if (!grade || grade === '-') {
								let nextRow = row.nextElementSibling;
								let currentGradeCell = nextRow?.querySelector('td.current-st-grade');
								grade = currentGradeCell?.innerText.trim() || '';
							}

							let empCurrGrossPM = row.querySelector(".EmpCurrGrossPM")?.innerText?.trim() || '';
							let prevFixed = row.querySelector(".prev-fixed")?.innerText?.trim() || '';
							let totalCtc = row.querySelector(".total-ctc")?.innerText?.trim() || '';

							let singleEmployeeData = {
								employees: [{
									employee_id: empid,
									department_name: department,
									designation_name: designation,
									grade_name: grade,
									old_gross_salary: empCurrGrossPM,
									old_ctc: prevFixed,
									fixed_ctc: totalCtc
								}]
							};

							fetch("{{ route('sendemployeeinfo') }}", {
									method: "POST",
									headers: {
										'Content-Type': 'application/json',
										'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
									},
									body: JSON.stringify(singleEmployeeData)
								})
								.then(response => response.json())
								.then(data => {
									const values = data[empid];
									if (!values) return;

									const proposedctcnew = parseFloat(row.querySelector('.total-ctc')?.textContent || 0);
									const carallow = parseFloat(row.querySelector('.car-allow')?.textContent || 0);
									const commallow = parseFloat(row.querySelector('.comm-allow')?.textContent || 0);
									const variablePay = parseFloat(values.variable_pay) || 0;
									const total = variablePay + proposedctcnew;
									const totalgross = commallow + carallow + total;

									row.querySelector('.variable-pay').textContent = values.variable_pay;
									row.querySelector('.total-pay-ctc').textContent = total;
									row.querySelector('.total-gross').textContent = totalgross;
								})
								.catch(error => console.error('Error:', error));
						}
					});
				}
			});

			// Click handlers
			$('#saveRatingsBtn, #submitRatingsBtn').on('click', function() {
				let actionType = $(this).data('action'); // 'save' or 'submit'
				handleSavingData(actionType);
			});

			// Core logic in one reusable function
			function handleSavingData(actionType) {
				$('#loader').show();

				let yearId = {{$PmsYId ?? 'null'}};
				let hoid = {{Auth::user()->EmployeeID ?? 'null'}};
				let deptId = $('#department-filter option:selected').data('deptid') || '';
				let hodactualid = $('#Hod-filter option:selected').data('hodid');

				// Collect rating distribution
				let ratings = {};
				$('.rating-box').each(function() {
					let rating = $(this).data('rating');
					let inputVal = $(this).find('input.rating-input').val();
					if (inputVal !== '') {
						let value = parseFloat(inputVal);
						let ratingKey = `rat_${parseFloat(rating).toString().replace('.', '')}`;
						ratings[ratingKey] = value;
					}
				});


				// Collect detailed employee data
				let employeeData = [];
				$('.employee-data-row:visible').each(function() {
					const $row = $(this);
					const empIdCell = $row[0].querySelector('td[id^="empid"]');
					const empId = empIdCell ? empIdCell.textContent.trim() : null;
					let rating = $row.find('td[data-row-rating]').data('row-rating');
					let prorata = $row.find('.prorata').text().trim();
					let actual = $row.find('.actual-input').val();
					let preCtc = $row.find('.ctc').text().trim().replace(/,/g, '');
					let corr = $row.find('.corr-input').val();
					let corrPer = $row.find('.corr-per').text().trim();
					let inc = $row.find('.inc').text().trim().replace(/,/g, '');
					let totCtc = $row.find('.total-ctc').text().trim().replace(/,/g, '');
					let totCtcPer = $row.find('td:eq(22)').text().trim();
					let maxCtc = $row.find('.max-ctc').text().trim();
					let prevfixed = $row.find('.prev-fixed').text().trim().replace(/,/g, '');
					let finalinc = $row.find('.final-inc').text().trim().replace(/,/g, '');
					let currCarAlw = $row.find('.car-allow').text().trim().replace(/,/g, '');
					let currCommAlw = $row.find('.comm-allow').text().trim().replace(/,/g, '');
					let totgrosswithadding = $row.find('.total-gross').text().trim().replace(/,/g, '');
					let totactctcwithcarpay = $row.find('.total-pay-ctc').text().trim().replace(/,/g, '');
					let variablepay = $row.find('.variable-pay').text().trim().replace(/,/g, '');

					employeeData.push({
						empid: empId,
						rating: rating,
						per_prorata: prorata,
						per_actual: actual,
						pre_ctc: preCtc,
						corr: corr,
						per_corr: corrPer,
						inc: inc,
						tot_ctc: totCtc,
						per_totctc: totCtcPer,
						max_ctc: maxCtc,
						prevfixed: prevfixed,
						finalinc: finalinc,
						currCarAlw: currCarAlw,
						currCommAlw: currCommAlw,
						totgrosswithadding: totgrosswithadding,
						totactctcwithcarpay: totactctcwithcarpay,
						variablepay: variablepay
					});
				});

				// Footer summary data
				let summaryData = {
					total_prev_ctc: $('#total-prev-ctc').text().trim().replace(/,/g, ''),
					avg_prorata: $('#avg-prorata').text().trim(),
					avg_actual: $('#avg-actual').text().trim(),
					total_ctc: $('#total-ctc').text().trim().replace(/,/g, ''),
					total_corr: $('#total-corr').text().trim().replace(/,/g, ''),
					avg_corr_per: $('#avg-corr-per').text().trim(),
					total_inc: $('#total-inc').text().trim().replace(/,/g, ''),
					total_final_ctc: $('#total-final-ctc').text().trim().replace(/,/g, ''),
					avg_final_per: $('#avg-final-per').text().trim(),
					avg_final_per_variavle_pay_est: $('#avg-totalVarPay').text().trim(),
					avg_final_per_total_ctc_est: $('#avg-totalTotalCtcPay').text().trim(),
					avg_final_per_comm_est: $('#avg-totalCommAllow').text().trim(),
					avg_final_per_car_est: $('#avg-totalCarAllow').text().trim(),
					avg_final_per_gross_est: $('#avg-totalTotalGross').text().trim(),

				};

				$.ajax({
					url: "{{ route('save.rating.breakdown') }}",
					method: "POST",
					contentType: "application/json",
					data: JSON.stringify({
						_token: "{{ csrf_token() }}",
						pmsYId: yearId,
						hoid: hoid,
						hodactualid: hodactualid,
						deptid: deptId,
						action_type: actionType,
						ratings: ratings,
						employees: employeeData,
						summaryData: summaryData
					}),
					success: function(response) {
						$('#loader').hide();
						toastr.success(response.message || 'Data saved successfully.', 'Success');

						if (actionType === 'save' || actionType === 'submit') {

							// 🔄 Call your GET route after save
							$.ajax({
								url: '/get-department-ratings',
								method: 'GET',
								data: {
									deptid: deptId,
									hodid: hoid,
									yearid: yearId,
									hodactualid: hodactualid
								},
								success: function(response) {
									if (response.success) {
										if (response.all_submitted) {
											$('.overall-save').show();
											$('.overall-submit').show();
										} else if (response.allSubmittedsaved) {
											$('.overall-save').hide();
											$('.submit-single-employee').hide();
											$('.save-single-employee').hide();
											$('.actual-input').prop('disabled', true);
											$('.corr-input').prop('disabled', true);
											$('.save-single-employee').hide();
											$('.overall-submit').hide();
										} else if (response.allSubmittedwithsomesaved) {
											$('.overall-save').show();
											$('.overall-submit').show();
										} else if (!response.allSubmittedsaved && !response.all_submitted) {
											$('.overall-save').show();

										} else {
											$('.overall-save').show();
											$('.overall-submit').hide();
										}

										const ratingMap = {
											'rat_0': '0',
											'rat_1': '1',
											'rat_2': '2',
											'rat_25': '2.5',
											'rat_27': '2.7',
											'rat_29': '2.9',
											'rat_3': '3',
											'rat_32': '3.2',
											'rat_34': '3.4',
											'rat_35': '3.5',
											'rat_37': '3.7',
											'rat_39': '3.9',
											'rat_4': '4',
											'rat_42': '4.2',
											'rat_44': '4.4',
											'rat_45': '4.5',
											'rat_47': '4.7',
											'rat_49': '4.9',
											'rat_5': '5'
										};

										response.ratings.forEach(function(ratingData) {
											const formattedRating = ratingMap[ratingData.rating];
											const mappedRating = parseFloat(formattedRating).toString();

											const value = ratingData.value;
											if (mappedRating) {
												const ratingInput = $('input[data-rating="' + mappedRating + '"]');
												if (ratingInput.length > 0) {
													ratingInput.val(value);
												}
											}
										});
									} else {
										$('.overall-save').show();
										$('.overall-submit').hide();
										$('.rating-input').val('');
									}
								}
							});
						}
					},
					error: function(xhr) {
						$('#loader').hide();
						let msg = xhr.responseJSON?.message || 'Error saving data.';
						toastr.error(msg, 'Error');
					}
				});
			}
			// Save button handler
			$(document).on('click', '.save-single-employee', function(e) {
				e.preventDefault();
				handleEmployeeAction($(this), 'save');
			});

			// Submit button handler
			$(document).on('click', '.submit-single-employee', function(e) {
				e.preventDefault();
				handleEmployeeAction($(this), 'submit');
			});

			// Common handler function
			function handleEmployeeAction($btn, actionType) {
				$('#loader').show();

				let $row = $btn.closest('.employee-data-row');
				let empId = $btn.data('empid');
				let emppmsid = $btn.data('emppmsid');

				let yearId = {{$PmsYId ?? 'null'}};

				let data = {
					emp_id: empId,
					emppmsid: emppmsid,
					pmsYId: yearId,
					actual: $row.find('.actual-input').val(),
					preCtc: $row.find('.ctc').text().trim().replace(/,/g, ''),
					prevfixed: $row.find('.prev-fixed').text().trim().replace(/,/g, ''),
					corr: $row.find('.corr-input').val(),
					rating: $row.find('[data-row-rating]').data('row-rating'),
					prorata: $row.find('.prorata').text(),
					ctc: $row.find('.ctc').text(),
					corrPer: $row.find('.corr-per').text().trim(),
					total_ctc: $row.find('.total-ctc').text(),
					inc: $row.find('.inc').text().trim().replace(/,/g, ''),
					totCtc: $row.find('.total-ctc').text().trim().replace(/,/g, ''),
					finalinc: $row.find('.final-inc').text().trim().replace(/,/g, ''),
					prevfixed: $row.find('.prev-fixed').text().trim().replace(/,/g, ''),
					currCarAlw: $row.find('.car-allow').text().trim().replace(/,/g, ''),
					currCommAlw: $row.find('.comm-allow').text().trim().replace(/,/g, ''),
					totgrosswithadding: $row.find('.total-gross').text().trim().replace(/,/g, ''),
					totactctcwithcarpay: $row.find('.total-pay-ctc').text().trim().replace(/,/g, ''),
					variablepay: $row.find('.variable-pay').text().trim().replace(/,/g, ''),
					action: actionType,
					csrf_token: $('meta[name="csrf-token"]').attr('content')
				};

				$.ajax({
					url: '/save-single-employee', // or a dynamic route if needed
					method: 'POST',
					data: data,
					headers: {
						'X-CSRF-TOKEN': data.csrf_token
					},
					success: function(response) {
						toastr.success(response.message || (actionType === 'submit' ? 'Submitted' : 'Saved') + ' successfully.', 'Success');

						// After submit, check status again
						if (actionType === 'submit') {
							$.post('/get-employee-status', {
								emp_id: empId,
								emppmsid: emppmsid,
								pmsYId: yearId,
								_token: data.csrf_token
							}, function(res) {
								if (res.status == 2) {
									// Disable inputs and hide buttons for the specific row
									$row.find('input, textarea, select').prop('disabled', true);
									$row.find('.save-single-employee, .submit-single-employee').hide();
								}
							});
						}

						// Disable inputs for rows that do not have the save/submit buttons
						$('.employee-data-row').each(function() {
							if (!$(this).find('.save-single-employee, .submit-single-employee').length) {
								// Disable all inputs in the row
								$(this).find('input, textarea, select').prop('disabled', true);
							}
						});
					},
					error: function(xhr) {
						let msg = xhr.responseJSON?.message || 'Error saving data.';
						toastr.error(msg, 'Error');
					},
					complete: function() {
						$('#loader').hide();
					}
				});
			}

			function updateExportLink() {
				var department = $('#department-filter').val();
				var grade = $('#grade-filter').val();
				var hod = $('#Hod-filter').val();
				var rev = $('#Rev-filter').val();
				var region = $('#region-filter').length && $('#region-filter').is(':visible') ? $('#region-filter').val() : '';
				var zone = $('#Zone-filter').length && $('#Zone-filter').is(':visible') ? $('#Zone-filter').val() : '';
				var bu = $('#BU-filter').length && $('#BU-filter').is(':visible') ? $('#BU-filter').val() : '';
				var baseUrlBlank = "{!! route('export.increment', ['type' => 'blank', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) !!}";
				var baseUrlData = "{!! route('export.increment', ['type' => 'data', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) !!}";

				// Dynamically build the export URLs with department and grade parameters
				var exportUrlBlank = baseUrlBlank +
					'&department=' + encodeURIComponent(department) +
					'&grade=' + encodeURIComponent(grade) +
					'&region=' + encodeURIComponent(region) +
					'&zone=' + encodeURIComponent(zone) +
					'&bu=' + encodeURIComponent(bu) +
					'&hod=' + encodeURIComponent(hod) +
					'&rev=' + encodeURIComponent(rev);

				var exportUrlData = baseUrlData +
					'&department=' + encodeURIComponent(department) +
					'&grade=' + encodeURIComponent(grade) +
					'&region=' + encodeURIComponent(region) +
					'&zone=' + encodeURIComponent(zone) +
					'&bu=' + encodeURIComponent(bu) +
					'&hod=' + encodeURIComponent(hod) +
					'&rev=' + encodeURIComponent(rev);

				// Update the href attributes of the export links
				$('#export-link-blank').attr('href', exportUrlBlank);
				$('#export-link-data').attr('href', exportUrlData);
			}
			document.addEventListener("DOMContentLoaded", function() {
				const rows = document.querySelectorAll("tr.employee-data-row");
				if (!rows.length) return;

				let allEmployeeData = [];

				rows.forEach((row) => {
					let empid = row.dataset.empid;
					let department = row.querySelector(".dept-row")?.innerText?.trim() || '';
					// Get Proposed Designation
					let designationInput = row.querySelector('input.up-current-st');
					let designation = designationInput ? designationInput.value.trim() : '';

					// If Proposed Designation is "-", get Current Designation from next row
					if (!designation || designation === '-') {
						let nextRow = row.nextElementSibling;
						let currentDesigInput = nextRow?.querySelector('input.current-st');
						designation = currentDesigInput ? currentDesigInput.value.trim() : '';
					}

					// Get Proposed Grade
					let upCurrentStCells = row.querySelectorAll('td.up-current-st');
					let grade = upCurrentStCells.length > 0 ? upCurrentStCells[0].innerText.trim() : '';

					// If Proposed Grade is "-", get Current Grade from next row
					if (!grade || grade === '-') {
						let nextRow = row.nextElementSibling;
						let currentGradeCell = nextRow?.querySelector('td.current-st-grade');
						grade = currentGradeCell ? currentGradeCell.innerText.trim() : '';
					}


					let empCurrGrossPM = row.querySelector(".EmpCurrGrossPM")?.innerText?.trim() || '';
					let prevFixed = row.querySelector(".prev-fixed")?.innerText?.trim() || '';
					let totalCtc = row.querySelector(".total-ctc")?.innerText?.trim() || '';

					allEmployeeData.push({
						employee_id: empid,
						department_name: department,
						designation_name: designation,
						grade_name: grade,
						old_gross_salary: empCurrGrossPM,
						old_ctc: prevFixed,
						fixed_ctc: totalCtc
					});
				});

				// Send once
				fetch("{{ route('sendemployeeinfo') }}", {
						method: "POST",
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
						},
						body: JSON.stringify({
							employees: allEmployeeData,
						})
					})
					.then(response => response.json()) // Parse the JSON response
					.then(data => {
						Object.entries(data).forEach(([empId, values]) => {
							const row = document.querySelector(`tr[data-empid="${empId}"]`);
							if (row) {
								const proposedctcnew = parseFloat(row.querySelector('.total-ctc').textContent) || 0;
								const carallow = parseFloat(row.querySelector('.car-allow').textContent) || 0;
								const commallow = parseFloat(row.querySelector('.comm-allow').textContent) || 0;

								const variablePay = parseFloat(values.variable_pay) || 0;
								const total = variablePay + proposedctcnew;
								const totalgross = commallow + carallow + total;

								row.querySelector('.variable-pay').textContent = values.variable_pay;
								row.querySelector('.total-pay-ctc').textContent = total;
								row.querySelector('.total-gross').textContent = totalgross;

							}
						});
					})
					.catch(error => {
						console.error('Error:', error);
					});
			});
			const allEmployees = @json($employeeTableData);

			// On Department Change
			$('#department-filter').on('change', function() {
				const selectedDeptId = $(this).val();

				const filteredByDept = selectedDeptId ?
					allEmployees.filter(emp => emp.Department_code == selectedDeptId) :
					allEmployees;

				// Get unique HODs from filtered data
				const uniqueHods = [...new Map(filteredByDept
					.filter(emp => emp.HodName)
					.map(emp => [emp.HodID, emp])).values()];

				$('#Hod-filter').empty().append('<option value="">All HOD</option>');
				uniqueHods.forEach(emp => {
					$('#Hod-filter').append(`<option value="${emp.HodName}" data-hodid="${emp.HodID}">${emp.HodName}</option>`);
				});

				// Clear Rev filter initially
				$('#Rev-filter').empty().append('<option value="">All Rev</option>');
			});


			// On HOD Change — now depends on both department and selected HOD
			$('#Hod-filter').on('change', function() {
				const selectedDeptId = $('#department-filter').val();
				const selectedHodName = $(this).val();

				const filteredByDept = selectedDeptId ?
					allEmployees.filter(emp => emp.Department_code == selectedDeptId) :
					allEmployees;

				const filteredByHod = selectedHodName ?
					filteredByDept.filter(emp => emp.HodName == selectedHodName) :
					filteredByDept;

				const uniqueRevs = [...new Map(filteredByHod
					.filter(emp => emp.RevName)
					.map(emp => [emp.RevID, emp])).values()];

				$('#Rev-filter').empty().append('<option value="">All Rev</option>');
				uniqueRevs.forEach(emp => {
					$('#Rev-filter').append(`<option value="${emp.RevName}" data-revid="${emp.RevID}">${emp.RevName}</option>`);
				});
			});
			// const allEmployees = @json($employeeTableData);
			// console.log('allEmployees',allEmployees);

			// $('#department-filter').on('change', function () {
			// 	const selectedDeptId = $(this).val();
			// 	console.log(selectedDeptId);


			// 	// Filter employees based on department ID
			// 	const filteredEmployees = allEmployees.filter(emp => emp.Department_code == selectedDeptId);

			// 	// Get unique HODs
			// 	const uniqueHods = [...new Map(filteredEmployees
			// 		.filter(emp => emp.HodName)
			// 		.map(emp => [emp.HodID, emp])).values()];

			// 	// Get unique Reviewers
			// 	const uniqueRevs = [...new Map(filteredEmployees
			// 		.filter(emp => emp.RevName)
			// 		.map(emp => [emp.RevID, emp])).values()];

			// 	// Populate HOD dropdown
			// 	$('#Hod-filter').empty().append('<option value="">All HOD</option>');
			// 	uniqueHods.forEach(emp => {
			// 		$('#Hod-filter').append(`<option value="${emp.HodName}" data-hodid="${emp.HodID}">${emp.HodName}</option>`);
			// 	});

			// 	// Populate Rev dropdown
			// 	$('#Rev-filter').empty().append('<option value="">All Rev</option>');
			// 	uniqueRevs.forEach(emp => {
			// 		$('#Rev-filter').append(`<option value="${emp.RevName}" data-revid="${emp.RevID}">${emp.RevName}</option>`);
			// 	});
			// });

			function highlightUtkarshRows() {
				document.querySelectorAll("tr").forEach(function(row) {
					const utkarshCell = row.querySelector("td.utkarshscheme");

					if (utkarshCell && utkarshCell.textContent.trim().toLowerCase() === "yes") {
						const empIdCell = row.querySelector("td.empid");
						const empId = empIdCell ? empIdCell.textContent.trim() : null;

						// Apply visual style to the main row
						row.style.backgroundColor = "#ffccd9";
						row.style.fontWeight = "bold";
						row.style.transition = "all 0.3s ease-in-out";
						row.style.borderTop = "2px solid #d6336c";
						row.style.borderLeft = "2px solid #d6336c";
						row.style.borderRight = "2px solid #d6336c";
						row.style.borderBottom = "0"; // remove bottom border to merge visually with extra row

						// Highlight extra row seamlessly
						if (empId) {
							const extraRow = document.querySelector(`tr.employee-data-row-extra[data-empid="${empId}"]`);
							if (extraRow) {
								extraRow.style.backgroundColor = "#ffccd9";
								extraRow.style.fontWeight = "bold";
								extraRow.style.transition = "all 0.3s ease-in-out";
								extraRow.style.borderLeft = "2px solid #d6336c";
								extraRow.style.borderRight = "2px solid #d6336c";
								extraRow.style.borderBottom = "2px solid #d6336c";
								extraRow.style.borderTop = "0"; // remove top border to match main row
							}
						}
					}
				});
			}
			// Call once on DOM ready
			document.addEventListener("DOMContentLoaded", function() {
				highlightUtkarshRows();
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

			.hide {
				display: none !important;
			}

			.highlight-row-new {
				background-color: rgb(240, 3, 3);
			}
		</style>