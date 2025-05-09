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
											<div style="margin-top:-40px;float:left;margin-left:660px;">
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
											<div class="tab-content splash-content2" id="myTabContent2">
												
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
													id="Increment" role="tabpanel">
													<div class="card increments-section">
														<div class="card-header increments-section-header" style="background-color:#7d9ea1;padding:5px !important;">
															<div class="float-start mr-2" style="margin-top:3px;">
																
																	<select style="height:20px;" name="department" id="department-filter">
																		<option value="">Select Department</option>
																		@foreach(collect($employeeTableData)->unique('Department') as $employee)
																		<option value="{{ $employee['Department'] }}" data-deptid="{{ $employee['depid'] ?? '' }}">
																			{{ $employee['Department'] }}
																		</option>
																		@endforeach
																	</select>
																	@if(Auth::user()->EmployeeID == '51' || Auth::user()->EmployeeID === 51 )
																	<select style="height:20px;" id="Hod-filter">
																		<option value="">All HOD</option>
																		@foreach(collect($employeeTableData)->unique('HodName') as $HodName)
																		<option value="{{ $HodName['HodName'] }}"  data-hodid="{{ $HodName['HodID'] ?? '' }}">{{ $HodName['HodName'] }}</option>
																		@endforeach
																	</select>
																	<select style="height:20px;" id="Rev-filter">
																		<option value="">All Rev</option>
																		@foreach(collect($employeeTableData)->unique('RevName') as $RevName)
																		<option value="{{ $RevName['RevName'] }}">{{ $RevName['RevName'] }}</option>
																		@endforeach
																	</select>
																	@endif
																	
																	
																	<select id="region-filter" style="height:20px; display:none;">
																			<option value="">All Region</option>
																			@foreach(collect($employeeTableData)->unique('region_name') as $reg)
																					<option value="{{ $reg['region_name']}}">{{ $reg['region_name'] }}</option>
																			@endforeach
																	</select>
																	<select style="height:20px;" id="grade-filter">
																		<option value="">All Grade</option>
																		@foreach(collect($employeeTableData)->unique('Grade')->sortBy('GradeId') as $grade)
																			<option value="{{ $grade['GradeId'] }}">{{ $grade['Grade'] }}</option>
																		@endforeach
																	</select>

															</div>
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
															<div class="float-start rating-box-container w-100 mt-1" id="ratingcontainer"style="display: none;"> <!-- Container hidden initially -->
															@foreach ($ratingCounts as $rating => $count)
																	@if ($rating != 0 && $rating != 0.0 && $rating != 0.00)
																		<div class="d-flex align-items-center float-start rating-box me-3 mb-2">
																			<b class="me-2">{{ rtrim(rtrim(number_format((float) $rating, 2, '.', ''), '0'), '.') }}</b>
																			<input type="text" id="customRatingInput" style="text-align: center;" class="form-control form-control-sm rating-input" data-rating="{{ rtrim(rtrim(number_format((float) $rating, 2, '.', ''), '0'), '.') }}" style="text-align:center" value="">
																			<span>%</span>

																		</div>
																	@endif
															@endforeach
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
																		<th rowspan="2" class="text-center" style="width:63px;">DOJ</th>
																		<th rowspan="2" class="text-center" style="width:75px;">Department</th>
																		<th rowspan="2" class="text-center" style="width:95px;">Designation</th>
																		<th rowspan="2" class="text-center">Grade</th>
																		<th rowspan="2" class="text-center">Grade<br>Change<br>Year</th>
																		<th class="text-center" colspan="2">Last<br>Correction</th>
																		<th class="text-center" colspan="1">Previous<br>CTC</th>
																		<th class="text-center" colspan="8">Proposed</th>
																		<th class="text-center" colspan="3">Total Proposed</th>
																		<th rowspan="2" class="text-center" style="width:48px;">Save<br>Sum.</th>
																	</tr>
																	<tr>
																		<th class="text-center">%</th>
																		<th class="text-center" style="width:48px;">Year</th>
																		<th class="text-center">Fixed</th>
																		<th class="text-center">Rating</th>
																		<th class="text-center">Designation</th>
																		<th class="text-center">Grade</th>
																		<th style="width:35px;" class="text-center">Pro.<br>Rata<br>(%)</th>
																		<th class="text-center">Actual<br>(%)</th>
																		<th class="text-center">CTC</th>
																		<th class="text-center">Corr.</th>
																		<th class="text-center">Corr.<br>(%)</th>
																		<th style="width:60px;" class="text-center">Inc</th>
																		<th class="text-center">CTC</th>
																		<th style="width:35px;" class="text-center">Final<br>(%)</th>
																	</tr>
																	<tr class="export-btn-section summary-row" style="background-color: #ed843e;">
																		<th colspan="11">
																		<a class="inc-btns btn btn-sm btn-primary mr-1" href="{{ route('export.increment', ['type' => 'blank', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) }}" id="export-link-blank">Exp. with Blank</a>
																		<a class="inc-btns btn btn-sm btn-primary mr-1" href="{{ route('export.increment', ['type' => 'data', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) }}" id="export-link-data">Exp. with Data</a>

																		<a title="Overall Save" href="javascript:void(0);" class="inc-btns btn overall-save btn-sm btn-success mr-1" style="display:none;" id="saveRatingsBtn" data-action="save">Overall Save</a>
																		<a title="Overall Submit" class="inc-btns btn overall-submit btn-sm btn-success mr-1" style="display:none;" href="javascript:void(0);" id="submitRatingsBtn" data-action="submit">Overall Submit</a>

																		<b style="float:right;margin-top:7px;">Total</b>
																		
																		</th>
																		<th class="text-center"><b id="total-prev-ctc">0</b></th>
																		<th colspan="3"></th>
																		<th class="text-center"><b id="avg-prorata">0.00</b></th>
																		<th class="text-center"><b id="avg-actual">0.00</b></th>
																		<th class="text-center"><b id="total-ctc">0</b></th>
																		<th class="text-center"><b id="total-corr">0</b></th>
																		<th class="text-center"><b id="avg-corr-per">0.00</b></th>
																		<th class="text-center"><b id="total-inc">0</b></th>
																		<th class="text-center"><b id="total-final-ctc">0</b></th>
																		<th class="text-center"><b id="avg-final-per">0.00</b></th>
																		<th></th>
																	</tr>
																</thead>
																<tbody>
																	
																	@foreach($employeeTableData as $index => $row)
																	@php
																	$employeeTableDatanew = DB::table('hrm_pms_appraisal_history')
																	->where('EmpCode', $row['EmpCode'])
																	->where('EmployeeID', $row['EmployeeID'])
																	->where('CompanyId', $row['CompanyID'])
																	->orderBy('SalaryChange_Date', 'desc')
																	->get();
																	
																	@endphp
																	<tr class="employee-data-row">
																		<td class="text-center">{{ $index + 1 }}</td>
																		<td class="text-center">
																			<a title="History" href="#" class="toggle-history" data-empid="{{ $row['EmpCode'] }}">
																				<i class="fa fa-history"></i>
																			</a>
																		</td>
																		<td class="text-center">{{ $row['EmpCode'] }}</td>
																		<td >{{ $row['FullName'] }}</td>
																		<td class="text-center">{{ \Carbon\Carbon::parse($row['DateJoining'])->format('d M y') }}</td>
																		<td class="text-center">{{ $row['Department'] }}</td>
																		<td><input style="border:0px;width:105px;padding:0px;font-weight:400;background-color: transparent;text-align:left;" type="text" value="{{ $row['Designation'] }}" title="{{ $row['Designation'] }}" readonly></td>
																		<td class="text-center">{{ $row['Grade'] }}</td>
																		<td class="text-center" style="background-color: {{ $row['GrChangeBg'] }}">{{ $row['MxGrDate'] }}</td>
																		<td class="text-center">
																		<b>{{ rtrim(rtrim(number_format((float) $row['MxCrPer'], 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="text-center">{{ $row['MxCrDate'] }}</td>
																		<td style="color:#ff6c00;font-weight:500;" class="text-center prev-fixed">
																				<b>{{ rtrim(rtrim(number_format($row['PrevFixed'], 2, '.', ''), '0'), '.') }}</b>
																			</td>
																		<td class="text-center row-rating" data-row-rating="{{ rtrim(rtrim(number_format($row['Rating'], 2, '.', ''), '0'), '.') }}">
																			<b>{{ rtrim(rtrim(number_format($row['Rating'], 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="text-center">
																			@if($row['ProDesignation'] == $row['Designation'])
																				-
																			@else
																				<input 
																					style="border:0px;width:105px;padding:0px;font-weight:500;background-color: transparent;text-align:left;" 
																					type="text" 
																					value="{{ $row['ProDesignation'] }}" 
																					title="{{ $row['ProDesignation'] }}" 
																					readonly>
																			@endif
																		</td>

																		<td class="text-center">
																			@if($row['ProGrade'] == $row['Grade'])
																				-
																			@else
																				{{ $row['ProGrade'] }}
																			@endif
																		</td>

																		<td class="text-center prorata" data-prorata="{{ $row['ProRata'] }}">{{ $row['ProRata'] }}</td>
																		<td>
																		<input type="text" inputmode="decimal" step="0.01" class="form-control actual-input"
    																		value="{{ fmod((float)$row['Actual'], 1) == 0 ? (int)$row['Actual'] : rtrim(rtrim(number_format($row['Actual'], 2, '.', ''), '0'), '.') }}">
																		</td>
																		
																		<td style="color:#ff6c00;font-weight:500;" class="text-center ctc">
																			{{ fmod($row['CTC'], 1) == 0 ? (int)$row['CTC'] : rtrim(rtrim(number_format($row['CTC'], 2, '.', ''), '0'), '.') }}
																		</td>
																		<td><input type="text" step="1" class="form-control corr-input" value="{{ fmod($row['Corr'], 1) == 0 ? (int)$row['Corr'] : rtrim(rtrim(number_format($row['Corr'], 2, '.', ''), '0'), '.') }}"></td>
																		<td class="text-center corr-per">{{ $row['CorrPer'] }}</td>
																		<td class="text-center inc">{{ $row['Inc'] }}</td>
																		<td style="color:#ff6c00;font-weight:500;" class="text-center total-ctc">{{ $row['TotalCTC'] }}</td>
																		<td class="text-center final-inc">{{ $row['TotalCTCPer'] }}</td>
																		<td class="text-center max-ctc d-none">{{ $row['MaxVCtc'] }}</td>
																		@if($row['HodSubmit_IncStatus'] != 2)
																		<td>
																			<a title="Save"
																				class="save-single-employee"
																				data-empid="{{ $row['EmployeeID'] }}" data-emppmsid="{{ $row['EmpPmsId'] }}"
																				style="padding: 2px 3px;font-size:10px;background-color: #3b94b7;color: #fff;margin-right:2px;"
																				href="javascript:void(0);">
																				<i class="las la-save"></i>
																			</a>
																			<a title="Submit" class="submit-single-employee"
																			data-empid="{{ $row['EmployeeID'] }}" data-emppmsid="{{ $row['EmpPmsId'] }}"
																			style="padding: 2px 3px;font-size:10px;background-color: #6fa22f;color: #fff;" href="javascript:void(0);" >
																			<i class="las la-check-circle"></i></a>
																		</td>
																		@else
																		<td></td>
																		@endif
																		<td class="text-center d-none" id="empid{{ $row['EmployeeID'] }}">{{ $row['EmployeeID'] }}</td>
																		<td class="hidden-reg d-none">{{  $row['region_name'] }}</td>
																		<td class="d-none EmpCurrAnnualBasic">{{  $row['EmpCurrAnnualBasic'] }}</td>
																		<td class="d-none">{{  $row['HodName'] }}</td>
																		<td class="d-none">{{  $row['RevName'] }}</td>
																		<td class="d-none totctcnew"></td>


																	</tr>
																	<tr id="historymain-{{ $row['EmpCode'] }}" data-empid="{{ $row['EmployeeID'] }}">
																		<td class="p-0" colspan="24">
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
																									@if($history->Previous_GrossSalaryPM == 0)
																										-
																									@else
																										{{ number_format($history->Previous_GrossSalaryPM, 0) }}/-
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
															<span class="mr-2"><i class="fa fa-history"></i> History </span>
															<span class="mr-2"><span style="padding: 2px 3px;font-size: 10px;background-color: #3b94b7;color: #fff;"><i class="las la-save"></i></span> Save </span>
															<span class="mr-2"><span style="padding: 2px 3px;font-size: 10px;background-color: #6fa22f;color: #fff;"><i class="las la-check-circle"></i></span> Submit</span>
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
		@include('employee.footer')
		<script>
			$(document).ready(function() {
				// Clear filter values on page load
				$('#department-filter').val('');
				$('#grade-filter').val('');
				$('#region-filter').val('');
				$('#Hod-filter').val('');
				$('#Rev-filter').val('');
			});
			function forceBindRatingInputs() {
				document.querySelectorAll('.rating-input, .actual-input, .corr-input').forEach(input => {
					// Clone to remove old listeners
					const clone = input.cloneNode(true);
					input.parentNode.replaceChild(clone, input);

					// Add clean logic
					clone.setAttribute('type', 'text');
					clone.setAttribute('inputmode', 'decimal');

					clone.addEventListener('input', () => {
						let value = clone.value.replace(/[^0-9.]/g, '');
						const parts = value.split('.');
						if (parts.length > 2) value = parts[0] + '.' + parts[1];
						clone.value = value;
					});

					clone.addEventListener('keypress', e => {
						const char = String.fromCharCode(e.which);
						if (!/[0-9.]/.test(char) || (char === '.' && clone.value.includes('.'))) {
							e.preventDefault();
						}
					});

					clone.addEventListener('paste', e => {
						const paste = (e.clipboardData || window.clipboardData).getData('text');
						if (!/^\d*\.?\d*$/.test(paste)) {
							e.preventDefault();
						}
					});
				});
			}

			document.addEventListener('DOMContentLoaded', forceBindRatingInputs);


			$(document).on('click', '.toggle-history', function (e) {
				e.preventDefault();

				let empId = $(this).data("empid");
				let $button = $(this);
				let $mainRow = $button.closest('tr');
				let $historyRow = $("#historymain-" + empId);
				let $historyDiv = $("#history-" + empId); // optional: only if used inside the history row

				// ✅ Skip if the main row is hidden
				if (!$mainRow.is(':visible')) return;

				// ✅ Check if the row has any relevant data (e.g. actual/corr > 0 or non-zero rating)
				let actual = parseFloat($mainRow.find('.actual-input').val()) || 0;
				let corr = parseFloat($mainRow.find('.corr-input').val()) || 0;
				let rating = parseFloat($mainRow.find('.row-rating').data('row-rating')) || 0;
				let month = $mainRow.find('td:nth-child(9)').text().trim();

				const hasMeaningfulData = actual > 0 || corr > 0 || rating > 0 || month !== "";

				if (!hasMeaningfulData) return;

				// ✅ Toggle logic
				if ($historyRow.css('display') === 'none') {
					$historyRow.css('display', 'table-row');
					$historyDiv.css('display', 'block');
					$historyDiv.find("tr").css('display', 'table-row');

					if (!$button.data("loaded")) {
						$.ajax({
							url: '/load-history/' + empId,
							method: 'GET',
							success: function (response) {
								$historyDiv.html(response);
								$button.data("loaded", true);
							}
						});
					}
				} else {
					$historyRow.css('display', 'none');
					$historyDiv.find("tr").css('display', 'none');
					$historyDiv.css('display', 'none');
				}
			});

			
			$(document).ready(function() {
				
				
				document.querySelectorAll('tr.employee-data-row').forEach(row => {
					const doj = row.querySelector('td:nth-child(5)').textContent; // ✅ Now fetched per employee row
					recalculateRow(row, doj, true);  // true means "force update"
					calculateSummary();
				});
				function formatNumber(val) {
					const num = parseFloat(val);
					if (isNaN(num)) return 0;
					return Number.isInteger(num) ? num : num.toFixed(2);
				}
				function formatNumberround(val) {
					return Math.round(val).toString();

				}
				function calculateProrata(row, doj) {
				const actualInput = row.querySelector('.actual-input');
				const prorataEl = row.querySelector('.prorata');
				const actual = parseFloat(actualInput.value) || 0;
				const globalRatingPercentage = parseFloat(row.querySelector('.rating-input')?.value) || 0;

				const dojParts = doj.split('-');
				const dojDate = new Date(`${dojParts[2]}-${dojParts[1]}-${dojParts[0]}`);
				dojDate.setHours(0, 0, 0, 0);

				let prorata = 0;
				const finalActual = actual > 0 ? actual : globalRatingPercentage;
				const threeMonthPortion = (finalActual * 3) / 12;

				// Total working days until 31-Dec-2024
				const workingDays = calculateWorkingDays(dojDate, new Date('2024-12-31'));
               //prorata = (518 / 360 * 12) + 3 ≈ 17.27 + 3 = 20.27 ✅

				if (dojDate <= new Date('2023-06-30')) {
					prorata = finalActual + threeMonthPortion;
				} else if (dojDate >= new Date('2023-07-01') && dojDate <= new Date('2023-12-31')) {
					prorata = ((workingDays / 360) * finalActual) + threeMonthPortion;
				} else if (dojDate >= new Date('2024-01-01') && dojDate <= new Date('2024-09-30')) {
					prorata = ((workingDays / 360) * finalActual) + threeMonthPortion;
				}

				prorataEl.textContent = (Math.floor(parseFloat(prorata) * 10) / 10).toFixed(1);
				return prorata;
				}

				function calculateWorkingDays(startDate, endDate) {
					let count = 0;
					let currentDate = new Date(startDate);

					while (currentDate <= endDate) {
						count += 1;
						currentDate.setDate(currentDate.getDate() + 1);
					}
					return count;
				}

				// function calculateProrata(row, doj) {

				// 	const actualInput = row.querySelector('.actual-input');
				// 	const prorataEl = row.querySelector('.prorata');
				// 	const actual = parseFloat(actualInput.value) || 0;
				// 	const globalRatingPercentage = parseFloat(row.querySelector('.rating-input')?.value) || 0;

				// 	const dojParts = doj.split('-'); 
				// 	const dojDate = new Date(`${dojParts[2]}-${dojParts[1]}-${dojParts[0]}`);

				// 	// Reset the time part to 00:00:00
				// 	dojDate.setHours(0, 0, 0, 0);

				// 	const currentDate = new Date();

				// 	// Reset the time part for the comparison dates
				// 	const endOfJune2023 = new Date('2023-06-30');
				// 	endOfJune2023.setHours(0, 0, 0, 0);

				// 	const startOfJuly2023 = new Date('2023-07-01');
				// 	startOfJuly2023.setHours(0, 0, 0, 0);

				// 	const endOfDecember2023 = new Date('2023-12-31');
				// 	endOfDecember2023.setHours(0, 0, 0, 0);

				// 	const startOf2024 = new Date('2024-01-01');
				// 	startOf2024.setHours(0, 0, 0, 0);

				// 	let prorata = 0;
				// 	const finalActual = actual > 0 ? actual : globalRatingPercentage;
				// 	const threeMonthPortion = (finalActual * 3) / 12;

				// 	if (dojDate <= endOfJune2023) {
				// 		console.log('new');
				// 		prorata = finalActual + threeMonthPortion;
				// 	} else if (dojDate >= startOfJuly2023 && dojDate <= endOfDecember2023) {
				// 		const daysWorked = calculateWorkingDays(dojDate, new Date('2024-12-31'));
				// 		prorata = finalActual + ((daysWorked / 365) * finalActual) + threeMonthPortion;
				// 		console.log('days', daysWorked);
				// 	} else if (dojDate >= startOf2024 && dojDate <= new Date('2024-09-30')) {
				// 		console.log('new2');
				// 		const daysWorked = calculateWorkingDays(dojDate, new Date('2024-12-31'));
				// 		prorata = ((daysWorked / 365) * finalActual) + threeMonthPortion;
				// 	}

				// 	console.log('Prorata:', prorata);


				// 	prorataEl.textContent = formatNumber(prorata);
				// 	return prorata;
				// }

				// function calculateWorkingDays(startDate, endDate) {
				// 	let count = 0;
				// 	let currentDate = new Date(startDate);
				// 	while (currentDate <= endDate) {
				// 		count++;
				// 		currentDate.setDate(currentDate.getDate() + 1);
				// 	}
				// 	console.log(count);
				// 	return count;
				// }
				function recalculateRow(row, doj, forceUpdate = false) {
					console.log('dfgh');
					const prevFixedEl = row.querySelector('.prev-fixed');
					const prorataEl = row.querySelector('.prorata');
					const corrPerEl = row.querySelector('.corr-per');
					let visibleProrata = 0;
					let visibleCorr = 0;
					let finalPercent = 0;

					if (prorataEl && corrPerEl) {
						// Try reading immediately
						visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
						visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

						console.log('🧪 Immediate visibleProrata:', visibleProrata);
						console.log('🧪 Immediate visibleCorr:', visibleCorr);

						// Fallback: Wait for DOM update (if delayed rendering)
						setTimeout(() => {
							// Update the values again after delay (for DOM to settle)
							visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
							visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

							console.log('✅ Delayed visibleProrata:', visibleProrata);
							console.log('✅ Delayed visibleCorr:', visibleCorr);

							// Recalculate finalPercent after DOM updates
							finalPercent = visibleProrata + visibleCorr;
							console.log('🧪 Recalculated finalPercent:', finalPercent);

							// Log finalPercent after delayed update (inside setTimeout)
							console.log('finalPercent after update:', finalPercent);
							const finalPerEl = row.querySelector('.final-inc');
							finalPerEl.textContent = formatNumber(finalPercent);
						}, 50);  // Delay to allow DOM rendering time
					}

					// Continue with the rest of your logic (this will happen immediately after)
					const actualInput = row.querySelector('.actual-input');
					const corrInput = row.querySelector('.corr-input');
					const ctcEl = row.querySelector('.ctc');
					const totalCtcEl = row.querySelector('.total-ctc');
					const maxVCtcEl = row.querySelector('.max-ctc');
					const maxctcannualEl = row.querySelector('.EmpCurrAnnualBasic');

					let prevFixed = parseFloat(prevFixedEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const actual = parseFloat(actualInput?.value) || 0;
					const corr = parseFloat(corrInput?.value) || 0;

					if (prevFixed === 0) return;

					const triggeredByCorr = document.activeElement === corrInput;

					let prorata = !triggeredByCorr ? calculateProrata(row, doj) : parseFloat(prorataEl.textContent.trim()) || 0;

					let baseIncrement = (prevFixed * (Math.floor(parseFloat(prorata) * 10) / 10).toFixed(1)) / 100;
				
					let totalInc = baseIncrement + corr;
					// let totalCTC = prevFixed + totalInc;

					let totalCTC = prevFixed + (prevFixed * visibleProrata / 100);

					let totalCTCInc = prevFixed + totalInc;

					const corrPercent = ((corr / prevFixed) * 100);
					const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const maxctcannual = parseFloat(maxctcannualEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

					let isCapping = false;
					row.querySelector('.totctcnew').textContent = totalCTC.toFixed(2);
					console.log('maxctcannual',maxVCtc);

					if (totalCTC > maxVCtc && maxVCtc > 0 && !triggeredByCorr) {
						console.log('ffffff');
						isCapping = true;
						row.classList.add('highlight-row');

						const roundedProratedValue = parseFloat(prorata.toFixed(2));
						const baseIncrementCap = (maxctcannual * roundedProratedValue) / 100;
						const totalInc = baseIncrementCap + corr;
						const totalCTCcap = prevFixed + baseIncrementCap;
						const totalCTCcapinc = prevFixed + totalInc;
						const actualnewinc = prevFixed + totalInc;

						const proRatanew = ((totalCTCcap - prevFixed) / prevFixed) * 100;

						if (!triggeredByCorr) {
							ctcEl.textContent = formatNumberround(totalCTCcap);
							prorataEl.textContent = parseFloat(proRatanew).toFixed(2);
						}
						console.log('ctc', totalCTCcap);
						row.querySelector('.inc').textContent = formatNumber(totalInc);
						row.querySelector('.final-inc').textContent = formatNumber(finalPercent);
						totalCtcEl.textContent = formatNumberround(totalCTCcapinc);
						if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
						row.classList.add('highlight-row');
					} else {
						console.log('dddelse');
						if (!triggeredByCorr) {
							ctcEl.textContent = formatNumberround(totalCTC);
						}
						console.log(totalInc);
						row.querySelector('.inc').textContent = formatNumber(totalInc);
						totalCtcEl.textContent = formatNumberround(totalCTCInc);
						row.querySelector('.final-inc').textContent = formatNumber(finalPercent);
						if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
					}
				}


				
				// function recalculateRow(row, doj, forceUpdate = false) {					

				// 	const prevFixedEl = row.querySelector('.prev-fixed');
				// 	const prorataEl = row.querySelector('.prorata');
				// 	const corrPerEl = row.querySelector('.corr-per');
				// 	let visibleProrata = 0;
				// 	let visibleCorr = 0;
				// 	let finalPercent = 0;

				// 	if (prorataEl && corrPerEl) {
				// 		// Try reading immediately
				// 		visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
				// 		visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

				// 		console.log('🧪 Immediate visibleProrata:', visibleProrata);
				// 		console.log('🧪 Immediate visibleCorr:', visibleCorr);

				// 		// Fallback: Wait for DOM update (if delayed rendering)
				// 		setTimeout(() => {
				// 			// Update the values again after delay (for DOM to settle)
				// 			visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
				// 			visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

				// 			console.log('✅ Delayed visibleProrata:', visibleProrata);
				// 			console.log('✅ Delayed visibleCorr:', visibleCorr);

				// 			// Recalculate finalPercent after DOM updates
				// 			finalPercent = visibleProrata + visibleCorr;
				// 			console.log('🧪 Recalculated finalPercent:', finalPercent);

				// 			// Log finalPercent after delayed update (inside setTimeout)
				// 			console.log('finalPercent after update:', finalPercent);
				// 		}, 50);  // Delay to allow DOM rendering time
				// 	}

				// 	// Optionally log it immediately (it will still be 0 until the timeout runs)
				// 	console.log('Initial finalPercent:', finalPercent);

				// 	const actualInput = row.querySelector('.actual-input');
				// 	const corrInput = row.querySelector('.corr-input');
				// 	const ctcEl = row.querySelector('.ctc');
				// 	const incEl = row.querySelector('.inc');
				// 	const totalCtcEl = row.querySelector('.total-ctc');
				// 	const finalPerEl = row.querySelector('.final-inc');
				// 	const maxVCtcEl = row.querySelector('.max-ctc');
				// 	const maxctcannualEl = row.querySelector('.EmpCurrAnnualBasic');


				// 	let prevFixed = parseFloat(prevFixedEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
				// 	const actual = parseFloat(actualInput?.value) || 0;
				// 	const corr = parseFloat(corrInput?.value) || 0;

				// 	if (prevFixed === 0) return;

				// 	// 👇 Detect if corr-input triggered the update
				// 	const triggeredByCorr = document.activeElement === corrInput;

				// 	// let prorata;
				// 	if (!triggeredByCorr) {
				// 		prorata = calculateProrata(row, doj);
				// 	} else {
				// 		// Reuse the already displayed value from DOM
				// 		prorata = parseFloat(prorataEl.textContent.trim()) || 0;
				// 	}


				// 	let baseIncrement = Math.round((prevFixed * prorata) / 100);
				// 	let totalInc = baseIncrement + corr;
				// 	let totalCTC = prevFixed + totalInc;
				// 	let totalCTCInc = prevFixed + totalInc;

				// 	// let finalPercent = ((totalInc / prevFixed) * 100);
				//   // Fetch the prorata value from the DOM
				//   let prorataValue = parseFloat(prorataEl?.innerHTML.trim()) || 0;

				// 	let corrPercent = ((corr / prevFixed) * 100);


				// 	const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
				// 	const maxctcannual = parseFloat(maxctcannualEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

				// 	let isCapping = false;
				// 	row.querySelector('.totctcnew').textContent = totalCTC.toFixed(2);

				// 	if (totalCTC > maxVCtc && maxctcannual > 0) {
				// 		isCapping = true;
				// 		row.classList.add('highlight-row');

				// 		const roundedProratedValue = parseFloat(prorata.toFixed(2));
				// 		const baseIncrementCap = (maxctcannual * roundedProratedValue) / 100;
				// 		const totalInc = baseIncrementCap + corr;
				// 		const totalCTCcap = prevFixed + baseIncrementCap;
				// 		const totalCTCcapinc = prevFixed + totalInc;
				// 		const totalIncnew = baseIncrement + corr;
				// 		const corrPercent = ((corr / prevFixed) * 100);

						
				// 		const actualnewinc = prevFixed + totalInc;


				// 		const proRatanew = ((totalCTCcap - prevFixed) / prevFixed) * 100;



				// 		if (!triggeredByCorr) {
				// 			ctcEl.textContent = formatNumberround(totalCTCcap);
				// 			prorataEl.textContent = parseFloat(proRatanew).toFixed(2);

				// 		}
				// 		console.log('finalPercent',finalPercent);
				// 		incEl.textContent = formatNumber(totalInc);
				// 		finalPerEl.textContent = formatNumber(finalPercent);

				// 		totalCtcEl.textContent = formatNumberround(totalCTCcapinc);
				// 		if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
				// 		row.classList.add('highlight-row');

				// 	} else {
				// 		console.log('else');
				// 		if (!triggeredByCorr) {
				// 			ctcEl.textContent = formatNumberround(totalCTC);
				// 		}

				// 		incEl.textContent = formatNumber(totalInc);
				// 		totalCtcEl.textContent = formatNumberround(totalCTCInc);
				// 		finalPerEl.textContent = formatNumber(finalPercent);
				// 		if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
				// 	}
				// }


				function calculateSummary() {
					let totalPrev = 0, totalProposedCTC = 0, totalCorr = 0, totalCorrPercent = 0;
					let totalInc = 0, totalFinalCTC = 0, totalProRata = 0, totalActual = 0, totalFinalPercent = 0;
					let rowCount = 0;

					document.querySelectorAll('tr.employee-data-row').forEach(row => {
						if (row.offsetParent === null) return;

						const prevFixed = parseFloat(row.querySelector('.prev-fixed')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const prorata = parseFloat(row.querySelector('.prorata')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const actual = parseFloat(row.querySelector('.actual-input')?.value) || 0;
						const proposedCtc = parseFloat(row.querySelector('.ctc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const corr = parseFloat(row.querySelector('.corr-input')?.value) || 0;
						const corrPer = parseFloat(row.querySelector('.corr-per')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const inc = parseFloat(row.querySelector('.inc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const finalCtc = parseFloat(row.querySelector('.total-ctc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const finalPer = parseFloat(row.querySelector('.final-inc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

						totalPrev += prevFixed;
						totalProposedCTC += proposedCtc;
						totalCorr += corr;
						totalCorrPercent += corrPer;
						totalInc += inc;
						totalFinalCTC += finalCtc;
						totalProRata += prorata;
						totalActual += actual;
						totalFinalPercent += finalPer;
						rowCount++;
					});

					const avgProRata = (totalProRata / rowCount).toFixed(2);
					const avgActual = ((totalProposedCTC - totalPrev) / (totalPrev * 0.01)).toFixed(2);
					const avgCorrPer = ((totalCorr / totalPrev) * 100).toFixed(2);
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
				}

				function checkForCappingNotification(rating) {
					let cappingExceeded = false;

					document.querySelectorAll('tr.employee-data-row').forEach(row => {
						// Skip the row if it's not visible (display: none)
						if (getComputedStyle(row).display === 'none') return;

						const ratingCell = row.querySelector('td:nth-child(13)');
						if (!ratingCell) return;

						const rowRating = parseFloat(ratingCell.textContent.trim()).toFixed(2);

						// Compare as floats or strings
						if (parseFloat(rowRating) !== parseFloat(rating)) return;
						const ctcEl = row.querySelector('.total-ctc');
						const maxVCtcEl = row.querySelector('.max-ctc');
						const totctcnew = row.querySelector('.totctcnew');

						const totalCTC = parseFloat(ctcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const totctcnewval = parseFloat(totctcnew?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

				
						if (maxVCtc > 0 && (totalCTC > maxVCtc || totctcnewval > maxVCtc)) {
							cappingExceeded = true;
							row.style.backgroundColor = 'rgb(255, 248, 223)';  // Highlight row with capping exceeded
						} else {
							row.style.backgroundColor = '';  // Reset row background
						}
					});


					const notification = document.getElementById('cappingNotification');
					if (cappingExceeded) {
						notification.classList.remove('d-none');
					} else {
						notification.classList.add('d-none');
					}
				}


				document.querySelectorAll('.actual-input, .corr-input').forEach(input => {
					input.addEventListener('input', function () {
						const row = this.closest('tr');
						const doj = row.querySelector('td:nth-child(5)').textContent;
						
						// Get the rating from the current row
						const ratingCell = row.querySelector('td:nth-child(13)'); // Assuming the rating is in the 13th column
						const rating = parseFloat(ratingCell.textContent.trim()).toFixed(2);

						if (row) {
							recalculateRow(row, doj, true);  // true means "force update"
							checkForCappingNotification(rating);  // Pass the rating of the affected row
							calculateSummary();
						}
					});
				});


				document.addEventListener('input', function(event) {
					if (event.target.matches('.rating-input')) {
						const rating = parseFloat(event.target.dataset.rating).toString();
						let inputValue = event.target.value;

						// Allow input as it is, but only format when it's finished
						// Remove invalid characters that are not numbers or a single decimal point
						let value = inputValue.replace(/[^0-9.]/g, '');

						// Ensure only one decimal point is allowed
						const parts = value.split('.');
						if (parts.length > 2) {
							value = parts[0] + '.' + parts[1];  // Keep only the first decimal part
						}

						// Update the value in the input
						event.target.value = value;

						// Skip formatting if ends with dot (user still typing)
						if (value.endsWith('.')) return;

						let percentIncrease = parseFloat(value);
						if (isNaN(percentIncrease)) return;

						// If input has ".0", ".00", etc., preserve it
						if (/^\d+\.0+$/.test(value)) {
							event.target.value = value;
						} else if (percentIncrease % 1 === 0) {
							event.target.value = percentIncrease.toFixed(0); // No decimal if whole number (unless `.0` entered)
						} else if (percentIncrease * 10 % 1 === 0) {
							event.target.value = percentIncrease.toFixed(1);
						} else {
							event.target.value = percentIncrease.toFixed(2);
						}

						// Update related row values
						document.querySelectorAll('tbody tr').forEach(row => {
							const ratingCell = row.querySelector('td:nth-child(13)');
							if (!ratingCell) return;

							const doj = row.querySelector('td:nth-child(5)').textContent;
							const rowRating = ratingCell.textContent.trim();
							if (rowRating !== rating) return;

							const actualInput = row.querySelector('.actual-input');
							if (actualInput) {
								actualInput.value = percentIncrease.toFixed(2);
								recalculateRow(row, doj, true);
								checkForCappingNotification(rating);
								calculateSummary();
							}
						});
					}
				});


				function filterTable() {
					const selectedDept = $('#department-filter').val();
					const selectedGrade = $('#grade-filter').val();
					var selectedRegion = $('#region-filter').val();
					var selectedHod = $('#Hod-filter').val();
					var selectedRev = $('#Rev-filter').val();


					const deptId = $('#department-filter option:selected').data('deptid');
					const hodactualid = $('#Hod-filter option:selected').data('hodid');

					const hodid = {{Auth::user()->EmployeeID}};
					const yearid = {{$PmsYId}};

					let hasNonZeroRating = false;


					if ((selectedDept || selectedHod) && (!selectedGrade && !selectedRev && !selectedRegion)) {
						$('#saveRatingsBtn').removeClass('hide'); // Show save button
						$('#submitRatingsBtn').removeClass('hide'); // Show submit button
						$('#ratingcontainer').css('display', 'block');  // Show the rating container
					} else {
						$('#saveRatingsBtn').addClass('hide');
						$('#submitRatingsBtn').addClass('hide');
						$('#ratingcontainer').css('display', 'none');  // Hide the rating container
					}
									
	
					// Make AJAX request to fetch ratings for the selected department
					$.ajax({
						url: '/get-department-ratings', // Your route to fetch ratings
						method: 'GET',
						data: {
							deptid: deptId,
							hodid: hodid,
							yearid: yearid,
							hodactualid: hodactualid
						},
						success: function(response) {
							if (response.success) {
								if (response.all_submitted) {
										$('.overall-save').show();
										$('.overall-submit').show(); // Or specifically: $('.inc-btns.overall-submit').show();
									} 
									else if (response.allSubmittedsaved ) {
											$('.overall-save').hide();
											$('.submit-single-employee').hide();
											$('.save-single-employee').hide();
											$('.actual-input').prop('disabled', true);
											$('.corr-input').prop('disabled', true);
											$('.save-single-employee').hide();
											$('.overall-submit').hide();
										}
									else if (response.allSubmittedwithsomesaved ) {
											$('.overall-save').show();
											$('.overall-submit').show();
										}
									
									else {
										$('.overall-save').show();
										$('.overall-submit').hide(); // Keep it hidden if not all submitted
									}
								// Define mapping from backend "rat_x" to actual rating values
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
								// Loop and apply values using the map
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


					$('#employeetablemang tbody tr').not('.summary-row').each(function () {
						const department = $(this).find('td:nth-child(6)').text().trim();
						const grade = $(this).find('td:nth-child(8)').text().trim();
						const rowRegion = $(this).find('td:nth-child(27)').text().trim();
						const rowHod = $(this).find('td:nth-child(29)').text().trim();
						const rowRev = $(this).find('td:nth-child(30)').text().trim();

						const matchDept = !selectedDept || department === selectedDept;
						const matchGrade = !selectedGrade || grade === selectedGrade;
						const matchRegion = !selectedRegion || rowRegion === selectedRegion;
						const matchHod = !selectedHod || rowHod === selectedHod;
						const matchRev = !selectedRev || rowRev === selectedRev;

						const actual = $(this).find('.actual-input').val();
						const corr = $(this).find('.corr-input').val();
						const rating = $(this).find('.row-rating').data('row-rating');
						const month = $(this).find('td:nth-child(9)').text().trim();

						const isMeaningful = (actual > 0 || corr > 0 || rating > 0 || month !== '');
						if (!selectedDept) {
							window.location.href = "{{route('managementIncrement')}}"
                            
						}
						// Show/hide row based on filter match and content
						if (matchDept && matchGrade && matchRegion && matchHod && matchRev && isMeaningful) {
							$(this).show();
						} else {
							$(this).hide();
						}
					});

					// Always show the summary row
					$('.summary-row').show();
					updateSN();

					// Update the visible ratings based on the filtered rows
					updateVisibleRatings();
					calculateSummary();

				}
				function formatRating(rating) {
					// Convert the rating to a number and back to a string to remove unnecessary trailing zeros
					return parseFloat(rating).toString();
				}
				

				// function updateVisibleRatings() {
				// 	// console.clear();

				// 	// Clear previous rating boxes (remove all existing)
				// 	$('.rating-box-container').empty().removeAttr('style');

				// 	// Clear previous matchedRatings to ensure it contains only current ratings
				// 	let matchedRatings = new Set();

				// 	// Loop through each visible employee row to build a fresh matchedRatings set
				// 	$('#employeetablemang tbody tr:visible').not('.summary-row').each(function() {
				// 		const rowRatingText = $(this).find('td:nth-child(13)').text().trim();
				// 		const rowRating = formatRating(rowRatingText); // Format the rating before adding


				// 		if (rowRatingText !== '') {
				// 			matchedRatings.add(rowRating); // Add formatted rating to matchedRatings set
				// 		}
				// 	});
				// 	const selectedDept = $('#department-filter').val();
				// 	const selectedGrade = $('#grade-filter').val();
				// 	var selectedRegion = $('#region-filter').val();
				// 	var selectedHod = $('#Hod-filter').val();
				// 	var selectedRev = $('#Rev-filter').val();


				// 	let anyBoxVisible = false;
				// 	const isFilterClean = !selectedGrade && !selectedRev && !selectedRegion;

				// 	// Now, loop through matched ratings and dynamically add new rating boxes for each one
				// 	matchedRatings.forEach(function(rating) {

				// 		// Create the rating box HTML dynamically
				// 		const ratingBoxHtml = `
				// 			<div class="d-flex align-items-center float-start rating-box me-3 mb-2">
				// 				<b class="me-2">${rating}</b>
				// 				<input type="text" id="customRatingInput" class="form-control form-control-sm rating-input" style="text-align: center;" data-rating="${rating}" value="">
				// 			    <span>%</span>

				// 			</div>
				// 		`;
						
				// 		// Append the newly created rating box to the container
				// 		$('.rating-box-container').append(ratingBoxHtml);

				// 		if (isFilterClean) {
				// 			anyBoxVisible = true;
				// 		}
				// 	});

				// 	// Show or hide the container based on whether any box is visible
				// 	if (anyBoxVisible) {
				// 		$('.rating-box-container').show(); // Show container if at least one box is visible
				// 	} else {
				// 		$('.rating-box-container').hide(); // Hide container if no boxes are visible
				// 	}

				// }
				function updateVisibleRatings() {
					// Clear previous rating boxes (remove all existing)
					$('.rating-box-container').empty().removeAttr('style');

					// Clear previous matchedRatings to ensure it contains only current ratings
					let matchedRatings = new Set();

					// Loop through each visible employee row to build a fresh matchedRatings set
					$('#employeetablemang tbody tr:visible').not('.summary-row').each(function() {
						const rowRatingText = $(this).find('td:nth-child(13)').text().trim();
						const rowRating = formatRating(rowRatingText); // Format the rating before adding

						if (rowRatingText !== '') {
							matchedRatings.add(rowRating); // Add formatted rating to matchedRatings set
						}
					});

					const selectedDept = $('#department-filter').val();
					const selectedGrade = $('#grade-filter').val();
					var selectedRegion = $('#region-filter').val();
					var selectedHod = $('#Hod-filter').val();
					var selectedRev = $('#Rev-filter').val();

					let anyBoxVisible = false;
					const isFilterClean = !selectedGrade && !selectedRev && !selectedRegion;

					// Sort ratings in ascending order (by default JavaScript sorts numerically)
					const sortedRatings = Array.from(matchedRatings).sort((a, b) => a - b);

					// Now, loop through sorted ratings and dynamically add new rating boxes for each one
					sortedRatings.forEach(function(rating) {
						// Create the rating box HTML dynamically
						const ratingBoxHtml = `
							<div class="d-flex align-items-center float-start rating-box me-3 mb-2">
								<b class="me-2">${rating}</b>
								<input type="text" id="customRatingInput" class="form-control form-control-sm rating-input" style="text-align: center;" data-rating="${rating}" value="">
								<span>%</span>
							</div>
						`;

						// Append the newly created rating box to the container
						$('.rating-box-container').append(ratingBoxHtml);

						if (isFilterClean) {
							anyBoxVisible = true;
						}
					});

					// Show or hide the container based on whether any box is visible
					if (anyBoxVisible) {
						$('.rating-box-container').show(); // Show container if at least one box is visible
					} else {
						$('.rating-box-container').hide(); // Hide container if no boxes are visible
					}
				}

				function updateSN() {
					let sn = 1;
					$('#employeetablemang tbody tr:visible').not('.summary-row').each(function() {
						$(this).find('td:nth-child(1)').text(sn); // Update SN in the first column
						sn++;

					});
				}
				function updateExportLink() {
						var department = $('#department-filter').val();
						var grade = $('#grade-filter').val();

						var baseUrlBlank = "{!! route('export.increment', ['type' => 'blank', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) !!}";
						var baseUrlData = "{!! route('export.increment', ['type' => 'data', 'employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) !!}";

						// Dynamically build the export URLs with department and grade parameters
						var exportUrlBlank = baseUrlBlank +
							'&department=' + encodeURIComponent(department) +
							'&grade=' + encodeURIComponent(grade);

						var exportUrlData = baseUrlData +
							'&department=' + encodeURIComponent(department) +
							'&grade=' + encodeURIComponent(grade);

						// Update the href attributes of the export links
						$('#export-link-blank').attr('href', exportUrlBlank);
						$('#export-link-data').attr('href', exportUrlData);
					}
				$('#department-filter, #grade-filter ,#region-filter ,#Hod-filter , #Rev-filter').change(function() {
					filterTable();
					updateExportLink();

				});
				
				$('#department-filter').change(function () {
					var selectedDepartment = $(this).val();
					if (selectedDepartment === "Sales") {
						$('#region-filter').show(); // Show region filter
					} else {
						$('#region-filter').hide(); // Hide region filter
						$('#region-filter').val(''); // Reset region selection
					}
					filterTable();
					updateExportLink();
					
				});

				// Initial: hide all rating boxes
				// $('.rating-box').hide();
			});
			document.addEventListener('DOMContentLoaded', function () {
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
					recalculateRow(row, doj, true);  // true means "force update"
					calculateSummary();
				});

				function calculateProrata(row, doj) {

					const actualInput = row.querySelector('.actual-input');
					const prorataEl = row.querySelector('.prorata');
					const actual = parseFloat(actualInput.value) || 0;
					const globalRatingPercentage = parseFloat(row.querySelector('.rating-input')?.value) || 0;

					const dojParts = doj.split('-');
					const dojDate = new Date(`${dojParts[2]}-${dojParts[1]}-${dojParts[0]}`);
					const currentDate = new Date();

					let prorata = 0;
					const finalActual = actual > 0 ? actual : globalRatingPercentage;
					const threeMonthPortion = (finalActual * 3) / 12;

					if (dojDate <= new Date('2023-07-30')) {

						prorata = finalActual + threeMonthPortion;
					} else if (dojDate >= new Date('2023-07-01') && dojDate <= new Date('2023-12-31')) {
						const daysWorked = calculateWorkingDays(dojDate, new Date('2024-12-31'));
						prorata = finalActual + ((daysWorked / 365) * finalActual) + threeMonthPortion;
					} else if (dojDate >= new Date('2024-01-01') && dojDate <= new Date('2024-09-30')) {
						const daysWorked = calculateWorkingDays(dojDate, new Date('2024-12-31'));
						prorata = ((daysWorked / 365) * finalActual) + threeMonthPortion;
					}
					console.log('proratafunction',prorata);
					prorataEl.textContent = parseFloat(prorata).toFixed(1);
					
					return prorata;
				}

				function calculateWorkingDays(startDate, endDate) {
					let count = 0;
					let currentDate = new Date(startDate);
					while (currentDate <= endDate) {
						const dayOfWeek = currentDate.getDay();
						count++;
						currentDate.setDate(currentDate.getDate() + 1);
					}
					return count;
				}

				function recalculateRow(row, doj, forceUpdate = false) {
					const prevFixedEl = row.querySelector('.prev-fixed');
					const prorataEl = row.querySelector('.prorata');
					const corrPerEl = row.querySelector('.corr-per');
					let visibleProrata = 0;
					let visibleCorr = 0;
					let finalPercent = 0;

					if (prorataEl && corrPerEl) {
						// Try reading immediately
						visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
						visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

						console.log('🧪 Immediate visibleProrata:', visibleProrata);
						console.log('🧪 Immediate visibleCorr:', visibleCorr);

						// Fallback: Wait for DOM update (if delayed rendering)
						setTimeout(() => {
							// Update the values again after delay (for DOM to settle)
							visibleProrata = parseFloat(prorataEl.textContent.trim()) || 0;
							visibleCorr = parseFloat(corrPerEl.textContent.trim()) || 0;

							console.log('✅ Delayed visibleProrata:', visibleProrata);
							console.log('✅ Delayed visibleCorr:', visibleCorr);

							// Recalculate finalPercent after DOM updates
							finalPercent = visibleProrata + visibleCorr;
							console.log('🧪 Recalculated finalPercent:', finalPercent);

							// Log finalPercent after delayed update (inside setTimeout)
							console.log('finalPercent after update:', finalPercent);
							const finalPerEl = row.querySelector('.final-inc');
							finalPerEl.textContent = formatNumber(finalPercent);
						}, 50);  // Delay to allow DOM rendering time
					}

					// Continue with the rest of your logic (this will happen immediately after)
					const actualInput = row.querySelector('.actual-input');
					const corrInput = row.querySelector('.corr-input');
					const ctcEl = row.querySelector('.ctc');
					const totalCtcEl = row.querySelector('.total-ctc');
					const maxVCtcEl = row.querySelector('.max-ctc');
					const maxctcannualEl = row.querySelector('.EmpCurrAnnualBasic');

					let prevFixed = parseFloat(prevFixedEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const actual = parseFloat(actualInput?.value) || 0;
					const corr = parseFloat(corrInput?.value) || 0;

					if (prevFixed === 0) return;

					const triggeredByCorr = document.activeElement === corrInput;

					let prorata = !triggeredByCorr ? calculateProrata(row, doj) : parseFloat(prorataEl.textContent.trim()) || 0;

					let baseIncrement = (prevFixed * (Math.floor(parseFloat(prorata) * 10) / 10).toFixed(1)) / 100;
				
					let totalInc = baseIncrement + corr;
					// let totalCTC = prevFixed + totalInc;

					let totalCTC = prevFixed + (prevFixed * visibleProrata / 100);

					let totalCTCInc = prevFixed + totalInc;

					const corrPercent = ((corr / prevFixed) * 100);
					const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const maxctcannual = parseFloat(maxctcannualEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

					let isCapping = false;
					row.querySelector('.totctcnew').textContent = totalCTC.toFixed(2);
					console.log('maxctcannual',maxVCtc);

					if (totalCTC > maxVCtc && maxVCtc > 0 && !triggeredByCorr) {
						console.log('ffffff');
						isCapping = true;
						row.classList.add('highlight-row');

						const roundedProratedValue = parseFloat(prorata.toFixed(2));
						const baseIncrementCap = (maxctcannual * roundedProratedValue) / 100;
						const totalInc = baseIncrementCap + corr;
						const totalCTCcap = prevFixed + baseIncrementCap;
						const totalCTCcapinc = prevFixed + totalInc;
						const actualnewinc = prevFixed + totalInc;

						const proRatanew = ((totalCTCcap - prevFixed) / prevFixed) * 100;

						if (!triggeredByCorr) {
							ctcEl.textContent = formatNumberround(totalCTCcap);
							prorataEl.textContent = parseFloat(proRatanew).toFixed(2);
						}
						console.log('ctc', totalCTCcap);
						row.querySelector('.inc').textContent = formatNumber(totalInc);
						row.querySelector('.final-inc').textContent = formatNumber(finalPercent);
						totalCtcEl.textContent = formatNumberround(totalCTCcapinc);
						if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
						row.classList.add('highlight-row');
					} else {
						console.log('dddelse');
						if (!triggeredByCorr) {
							ctcEl.textContent = formatNumberround(totalCTC);
						}
						console.log(totalInc);
						row.querySelector('.inc').textContent = formatNumber(totalInc);
						totalCtcEl.textContent = formatNumberround(totalCTCInc);
						row.querySelector('.final-inc').textContent = formatNumber(finalPercent);
						if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
					}
				}

				function calculateSummary() {
					let totalPrev = 0, totalProposedCTC = 0, totalCorr = 0, totalCorrPercent = 0;
					let totalInc = 0, totalFinalCTC = 0, totalProRata = 0, totalActual = 0, totalFinalPercent = 0;
					let rowCount = 0;

					document.querySelectorAll('tr.employee-data-row').forEach(row => {
						if (row.offsetParent === null) return;

						const prevFixed = parseFloat(row.querySelector('.prev-fixed')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const prorata = parseFloat(row.querySelector('.prorata')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const actual = parseFloat(row.querySelector('.actual-input')?.value) || 0;
						const proposedCtc = parseFloat(row.querySelector('.ctc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const corr = parseFloat(row.querySelector('.corr-input')?.value) || 0;
						const corrPer = parseFloat(row.querySelector('.corr-per')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const inc = parseFloat(row.querySelector('.inc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const finalCtc = parseFloat(row.querySelector('.total-ctc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const finalPer = parseFloat(row.querySelector('.final-inc')?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
           
						totalPrev += prevFixed;
						totalProposedCTC += proposedCtc;
						totalCorr += corr;
						totalCorrPercent += corrPer;
						totalInc += inc;
						totalFinalCTC += finalCtc;
						totalProRata += prorata;
						totalActual += actual;
						totalFinalPercent += finalPer;
						rowCount++;
					});
       
					const avgProRata = (totalProRata / rowCount).toFixed(2);
					const avgActual = ((totalProposedCTC - totalPrev) / (totalPrev * 0.01)).toFixed(2);
					const avgCorrPer = ((totalCorr / totalPrev) * 100).toFixed(2);
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
				}


				function checkForCappingNotification(rating) {
					let cappingExceeded = false;

					document.querySelectorAll('tr.employee-data-row').forEach(row => {
						// Skip the row if it's not visible (display: none)
						if (getComputedStyle(row).display === 'none') return;

						const ratingCell = row.querySelector('td:nth-child(13)');
						if (!ratingCell) return;

						const rowRating = parseFloat(ratingCell.textContent.trim()).toFixed(2);

						// Compare as floats or strings
						if (parseFloat(rowRating) !== parseFloat(rating)) return;
						const ctcEl = row.querySelector('.total-ctc');
						const maxVCtcEl = row.querySelector('.max-ctc');
						const totctcnew = row.querySelector('.totctcnew');

						const totalCTC = parseFloat(ctcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
						const totctcnewval = parseFloat(totctcnew?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

				
						if (maxVCtc > 0 && (totalCTC > maxVCtc || totctcnewval > maxVCtc)) {
							cappingExceeded = true;
							row.style.backgroundColor = 'rgb(255, 248, 223)';  // Highlight row with capping exceeded
						} else {
							row.style.backgroundColor = '';  // Reset row background
						}
					});


					const notification = document.getElementById('cappingNotification');
					if (cappingExceeded) {
						notification.classList.remove('d-none');
					} else {
						notification.classList.add('d-none');
					}
				}
			document.querySelectorAll('.actual-input, .corr-input').forEach(input => {
				input.addEventListener('input', function () {
					const row = this.closest('tr');
					const doj = row.querySelector('td:nth-child(5)').textContent;
					
					// Get the rating from the current row
					const ratingCell = row.querySelector('td:nth-child(13)'); // Assuming the rating is in the 13th column
					const rating = parseFloat(ratingCell.textContent.trim()).toFixed(2);

					if (row) {
						recalculateRow(row, doj, true);  // true means "force update"
						checkForCappingNotification(rating);  // Pass the rating of the affected row
						calculateSummary();
					}
				});
			});


						document.addEventListener('input', function(event) {
				if (event.target.matches('.rating-input')) {
					const rating = parseFloat(event.target.dataset.rating).toString();
					let inputValue = event.target.value;

					// Allow input as it is, but only format when it's finished
					// Remove invalid characters that are not numbers or a single decimal point
					let value = inputValue.replace(/[^0-9.]/g, '');

					// Ensure only one decimal point is allowed
					const parts = value.split('.');
					if (parts.length > 2) {
						value = parts[0] + '.' + parts[1];  // Keep only the first decimal part
					}

					// Update the value in the input
					event.target.value = value;

					// Skip formatting if ends with dot (user still typing)
					if (value.endsWith('.')) return;

					let percentIncrease = parseFloat(value);
					if (isNaN(percentIncrease)) return;

					// If input has ".0", ".00", etc., preserve it
					if (/^\d+\.0+$/.test(value)) {
						event.target.value = value;
					} else if (percentIncrease % 1 === 0) {
						event.target.value = percentIncrease.toFixed(0); // No decimal if whole number (unless `.0` entered)
					} else if (percentIncrease * 10 % 1 === 0) {
						event.target.value = percentIncrease.toFixed(1);
					} else {
						event.target.value = percentIncrease.toFixed(2);
					}

					// Update related row values
					document.querySelectorAll('tbody tr').forEach(row => {
						const ratingCell = row.querySelector('td:nth-child(13)');
						if (!ratingCell) return;

						const doj = row.querySelector('td:nth-child(5)').textContent;
						const rowRating = ratingCell.textContent.trim();
						if (rowRating !== rating) return;

						const actualInput = row.querySelector('.actual-input');
						if (actualInput) {
							actualInput.value = percentIncrease.toFixed(2);
							recalculateRow(row, doj, true);
							checkForCappingNotification(rating);
							calculateSummary();
						}
					});
				}
			});


			});


				// Click handlers
				$('#saveRatingsBtn, #submitRatingsBtn').on('click', function () {
					let actionType = $(this).data('action'); // 'save' or 'submit'
					handleSavingData(actionType);
				});

				// Core logic in one reusable function
				function handleSavingData(actionType) {
					$('#loader').show();

					let yearId = {{ $PmsYId ?? 'null' }};
					let hoid = {{ Auth::user()->EmployeeID ?? 'null' }};
					let deptId = $('#department-filter option:selected').data('deptid') || '';
					let hodactualid = $('#Hod-filter option:selected').data('hodid');

					// Collect rating distribution
						let ratings = {};
						$('.rating-input').each(function () {
							let rating = $(this).data('rating');
							let value = $(this).val();
							if (value !== '') {
								value = parseFloat(value);
								let ratingKey = `rat_${parseFloat(rating).toString().replace('.', '')}`;
								ratings[ratingKey] = value;
							}
						});

				// Collect detailed employee data
				let employeeData = [];
				$('.employee-data-row:visible').each(function () {
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
						prevfixed:prevfixed,
						finalinc:finalinc
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
					avg_final_per: $('#avg-final-per').text().trim()
				};

				$.ajax({
					url: "{{ route('save.rating.breakdown') }}",
					method: "POST",
					contentType: "application/json",
					data: JSON.stringify({
						_token: "{{ csrf_token() }}",
						pmsYId: yearId,
						hoid: hoid,
						deptid: deptId,
						action_type: actionType,
						ratings: ratings,
						employees: employeeData,
						summaryData: summaryData
					}),
					success: function (response) {
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
										}
										else if (response.allSubmittedwithsomesaved ) {
											$('.overall-save').show();
											$('.overall-submit').show();
										}
										else if (!response.allSubmittedsaved && !response.all_submitted) {
											$('.overall-save').show();

										}
										else {
											$('.overall-save').show();
											$('.overall-submit').hide();
										}

										const ratingMap = {
											'rat_0': '0', 'rat_1': '1', 'rat_2': '2', 'rat_25': '2.5', 'rat_27': '2.7',
											'rat_29': '2.9', 'rat_3': '3', 'rat_32': '3.2', 'rat_34': '3.4', 'rat_35': '3.5',
											'rat_37': '3.7', 'rat_39': '3.9', 'rat_4': '4', 'rat_42': '4.2', 'rat_44': '4.4',
											'rat_45': '4.5', 'rat_47': '4.7', 'rat_49': '4.9', 'rat_5': '5'
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
					error: function (xhr) {
						$('#loader').hide();
						let msg = xhr.responseJSON?.message || 'Error saving data.';
						toastr.error(msg, 'Error');
					}
				});
			}

	

			// Save button handler
			$(document).on('click', '.save-single-employee', function (e) {
				e.preventDefault();
				handleEmployeeAction($(this), 'save');
			});

			// Submit button handler
			$(document).on('click', '.submit-single-employee', function (e) {
				e.preventDefault();
				handleEmployeeAction($(this), 'submit');
			});

			// Common handler function
			function handleEmployeeAction($btn, actionType) {
				$('#loader').show();

				let $row = $btn.closest('.employee-data-row');
				let empId = $btn.data('empid');
				let emppmsid = $btn.data('emppmsid');

				let yearId = {{ $PmsYId ?? 'null' }};

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
					prevfixed : $row.find('.prev-fixed').text().trim().replace(/,/g, ''),
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
							$.post('/get-employee-status', { emp_id: empId, emppmsid: emppmsid, pmsYId: yearId, _token: data.csrf_token }, function(res) {
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
		
		</style>