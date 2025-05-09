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
																		@foreach(collect($employeeTableData)->unique('HodName')->filter(function($item) {
																			return !empty($item['HodName']);
																		}) as $HodName)
																			<option value="{{ $HodName['HodName'] }}" data-hodid="{{ $HodName['HodID'] ?? '' }}">{{ $HodName['HodName'] }}</option>
																		@endforeach
																	</select>

																	<select style="height:20px;" id="Rev-filter">
																		<option value="">All Rev</option>
																		@foreach(collect($employeeTableData)->unique('RevName') as $RevName)
																		<option value="{{ $RevName['RevName'] }}">{{ $RevName['RevName'] }}</option>
																		@endforeach
																	</select>
																	@endif
																	
																	<select id="region-filter" style="height:20px; display:none; margin:0; padding:0; border:1px solid #ccc;">
																		<option value="">All Region</option>
																		@foreach(collect($employeeTableData)->unique('region_name')->filter(fn($region) => !empty($region['region_name'])) as $reg)
																			<option value="{{ $reg['region_name'] }}">{{ $reg['region_name'] }}</option>
																		@endforeach
																	</select>

																	<select style="height:20px;" id="grade-filter">
																		<option value="">All Grade</option>
																		@foreach(collect($employeeTableData)->unique('Grade') as $grade)
																		<option value="{{ $grade['Grade'] }}">{{ $grade['Grade'] }}</option>
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
															<div class="float-start rating-box-container w-100 mt-1 d-none" id="ratingcontainer">
															@foreach ($ratingCounts as $rating => $count)
																	@if ($rating != 0 && $rating != 0.0 && $rating != 0.00)
																		<div class="d-flex align-items-center float-start rating-box me-3 mb-2" data-rating="{{ rtrim(rtrim(number_format((float) $rating, 2, '.', ''), '0'), '.') }}">
																			<b class="me-2">{{ rtrim(rtrim(number_format((float) $rating, 2, '.', ''), '0'), '.') }}</b>
																			<input type="text" style="text-align: center;" class="form-control form-control-sm rating-input"  style="text-align:center" value="">
																			<span class="ml-1">%</span>

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
																		<th rowspan="2" class="text-center" style="width:90px;">DOJ</th>
																		<th rowspan="2" class="text-center" style="width:75px;">Department</th>
																		<th rowspan="2" class="text-center" style="width:95px;">Designation <br>Proposed/Current</th>
																		<th rowspan="2" class="text-center">Grade</th>
																		<th rowspan="2" class="text-center">Grade<br>Change<br>Year</th>
																		<th class="text-center">Last<br>Correction</th>
																		<th class="text-center" colspan="1">Previous<br>CTC</th>
																		<th class="text-center" colspan="6">Proposed</th>
																		<th class="text-center" colspan="3">Total Proposed</th>
																		<th class="text-center" colspan="4">Estimated Amount</th>
																		<th rowspan="2" class="text-center" style="width:48px;">Save<br>Sum.</th>
																	</tr>
																	<tr>
																		<th class="text-center">% / Year</th>
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
																		<th class="text-center">Veriable<br> Pay</th>
																		<th class="text-center">Car<br> Allowance</th>
																		<th class="text-center">Comm.<br> Allowance</th>
																		<th class="text-center" style="width:70px;">Gross<br> CTC</th>
																		
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
																		<th class="text-center"></th>
																		<th class="text-center"></th>
																		<th class="text-center"></th>
																		<th class="text-center"></th>
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
																		<td rowspan="2" >{{ $row['FullName'] }}</td>
																		<td rowspan="2" class="text-center">{{ \Carbon\Carbon::parse($row['DateJoining'])->format('d M y') }}</td>
																		<td rowspan="2" class="text-center dept-row">{{ $row['Department'] }}</td>

																		<td class="text-center"><input class="up-current-st" style="border:0px;width:105px;padding:0px;font-weight:500;background-color: transparent;text-align:left;" type="text" value="{{ $row['ProDesignation'] }}" title="{{ $row['ProDesignation'] }}" readonly></td>
																		<td class="text-center up-current-st">{{ $row['ProGrade'] }}</td>
																		
																		<td rowspan="2" class="text-center" style="background-color: {{ $row['GrChangeBg'] }}">{{ $row['MxGrDate'] }}</td>
																		<td rowspan="2" class="text-center">
																		<b>{{ rtrim(rtrim(number_format((float) $row['MxCrPer'], 2, '.', ''), '0'), '.') }}</b>
																		/<br>{{ $row['MxCrDate'] }}</td>
																		<td rowspan="2" class="text-center prev-fixed p-color">
																				<b>{{ rtrim(rtrim(number_format($row['PrevFixed'], 2, '.', ''), '0'), '.') }}</b>
																			</td>
																		<td rowspan="2" class="text-center row-rating r-color" data-row-rating="{{ rtrim(rtrim(number_format($row['Rating'], 2, '.', ''), '0'), '.') }}">
																			<b>{{ rtrim(rtrim(number_format($row['Rating'], 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		
																		<td rowspan="2" class="text-center prorata">{{ $row['ProRata'] }}</td>
																		<td rowspan="2">
																		<input type="text" inputmode="decimal" step="0.01" class="form-control actual-input"
    																		value="{{ fmod((float)$row['Actual'], 1) == 0 ? (int)$row['Actual'] : rtrim(rtrim(number_format($row['Actual'], 2, '.', ''), '0'), '.') }}">
																		</td>
																		
																		<td rowspan="2" class="text-center ctc r-color">
																			{{ fmod($row['CTC'], 1) == 0 ? (int)$row['CTC'] : rtrim(rtrim(number_format($row['CTC'], 2, '.', ''), '0'), '.') }}
																		</td>
																		<td rowspan="2"><input type="text" step="1" class="form-control corr-input" value="{{ fmod($row['Corr'], 1) == 0 ? (int)$row['Corr'] : rtrim(rtrim(number_format($row['Corr'], 2, '.', ''), '0'), '.') }}"></td>
																		<td rowspan="2" class="text-center corr-per">{{ $row['CorrPer'] }}</td>
																		<td rowspan="2" class="text-center inc">{{ $row['Inc'] }}</td>
																		<td rowspan="2" class="text-center total-ctc p-color text-right">{{ $row['TotalCTC'] }}</td>
																		
																		<td rowspan="2" class="text-center final-inc">{{ $row['TotalCTCPer'] }}</td>
																		<td rowspan="2" class="d-color text-right d"></td>
																		<td rowspan="2" class="d-color text-right e"></td>
																		<td rowspan="2" class="d-color text-right g"></td>
																		<td rowspan="2" class="text-right t" style="color:#000;font-weight:500;"></td>
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
																			style="padding: 2px 3px;font-size:10px;background-color: #6fa22f;color: #fff;" href="javascript:void(0);" >
																			<i class="las la-check-circle"></i></a>
																		</td>
																		@else
																		<td rowspan="2"></td>
																		@endif
																		<td class="text-center d-none empid" id="empid{{ $row['EmployeeID'] }}">{{ $row['EmployeeID'] }}</td>
																		<td class="hidden-reg d-none">{{  $row['region_name'] }}</td>
																		<td class="d-none EmpCurrAnnualBasic">{{  $row['EmpCurrAnnualBasic'] }}</td>
																		<td class="d-none hodname">{{  $row['HodName'] }}</td>
																		<td class="d-none revname">{{  $row['RevName'] }}</td>

																	</tr>
																	<tr class="employee-data-row-extra" data-empid="{{ $row['EmployeeID'] }}">
																		
																		
																		<td><input class="current-st" style="border:0px;width:105px;padding:0px;font-weight:400;background-color: transparent;text-align:left;" type="text" value="{{ $row['Designation'] }}" title="{{ $row['Designation'] }}" readonly></td>
																		<td class="text-center current-st-grade">{{ $row['Grade'] }}</td>
																		
																		
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
																							<td class="text-center">{{ $history->Current_Grade }}</td>
																							<td class="text-center">{{ $history->Proposed_Grade }}</td>
																							<td>{{ $history->Current_Designation }}</td>
																							<td>{{ $history->Proposed_Designation }}</td>
																							<td class="text-center">{{ \Carbon\Carbon::parse($history->SalaryChange_Date)->format('d M y') }}</td>
																							<td class="text-right"><b>{{ number_format($history->TotalProp_GSPM, 0) }}/-</b></td>
																							@php
																							$PreviousCTC = floatval($history->Previous_GrossSalaryPM);
																							$ProposedCTC = floatval($history->TotalProp_GSPM) + floatval($history->Incentive);
																							@endphp
																							<td class="text-right">{{$ProposedCTC}}</td>
																							<td class="text-right"><b>{{ number_format($history->Previous_GrossSalaryPM, 0) }}/-</b></td>
																							<td class="text-right"><b>{{ number_format($history->ProIncCTC, 0) }}/-</b></td>
																							<td ><b>{{ number_format($history->Percent_ProIncCTC, 0) }}</b></td>
																							<td>{{number_format($history->ProCorrCTC,0)}}/-</td>

																							<td>{{number_format($history->Proposed_ActualCTC,0)}}/-</td>
																							
																							@if($shouldShowRow)
																							<td>{{number_format($history->TotalProp_PerInc_GSPM,0)}}</td>
                                                                                            @else
																							<td></td>
																							@endif
																							<td><b>{{$history->Score}}</b></td>
																							<td><b>{{$history->Rating}}</b></td>
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
		function filterRows() {
			const selectedDepartment = document.getElementById('department-filter').value.trim();
			const selectedGrade = document.getElementById('grade-filter').value.trim();
			const selectedReviewer = document.getElementById('Rev-filter')?.value.trim() || '';
			const selectedHOD = document.getElementById('Hod-filter')?.value.trim() || '';
			const selectedRegion = document.getElementById('region-filter')?.value.trim() || ''; // New region filter

			const rows = document.querySelectorAll('.employee-data-row'); // Main data rows
			const visibleEmployeeIds = [];
			const regionFilter = document.getElementById('region-filter');

			// Show/Hide Region filter based on department selection
			if (regionFilter) {
				if (selectedDepartment.toLowerCase() === 'sales') {
					regionFilter.style.display = 'inline'; // Show Region filter if department is "Sales" or "sales"
				} else {
					regionFilter.style.display = 'none'; // Hide Region filter if department is not "Sales"
				}
			}

			rows.forEach(function (row) {
					const employeeId = row.getAttribute('data-empid')?.trim(); // Get employeeId
					const extraRow = document.querySelector(`.employee-data-row-extra[data-empid="${employeeId}"]`);
					const grade = extraRow?.querySelector('.current-st-grade')?.textContent.trim() || '';
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

					// Show or hide based on filter match
					if (matchesDepartment && matchesGrade && matchesReviewer && matchesHOD && matchesRegion) {
						row.style.display = 'table-row';
						if (extraRow) extraRow.style.display = 'table-row';
						visibleEmployeeIds.push(employeeId);
						console.log('Showing Employee:', employeeId);  // ✅ Log shown rows
					} else {
						row.style.display = 'none';
						if (extraRow) extraRow.style.display = 'none';
					}
				});

				console.log('Visible Employee IDs after filter:', visibleEmployeeIds); // ✅ Final summary


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
			const ratingContainer = document.getElementById('ratingcontainer');

			// Condition: show only if Department or HOD is selected AND others are NOT
			const isDepartmentOrHodSelected = selectedDepartment !== '' || selectedHOD !== '';
			const isOtherFiltersSelected = selectedGrade !== '' || selectedReviewer !== '' || selectedRegion !== '';;

			if (!isDepartmentOrHodSelected || isOtherFiltersSelected) {
				// Hide rating container and rating boxes
				ratingContainer.classList.add('d-none');
				document.querySelectorAll('.rating-box').forEach(box => {
					box.classList.add('d-none');
				});
				updateSN();
				updateExportLink();
				calculateSummary();

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
						yearid: yearid,           // Make sure you have this value set globally or pass it in
						hodactualid: hodactualid  // Same here
					},
					success: function(response) {
						if (response.success) {
							// Optional UI state control based on submission status
							if (response.all_submitted) {
								$('.overall-save').show();
								$('.overall-submit').show();
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
							}

							// Rating map to convert backend keys
							const ratingMap = {
								'rat_0': '0', 'rat_1': '1', 'rat_2': '2', 'rat_25': '2.5', 'rat_27': '2.7',
								'rat_29': '2.9', 'rat_3': '3', 'rat_32': '3.2', 'rat_34': '3.4', 'rat_35': '3.5',
								'rat_37': '3.7', 'rat_39': '3.9', 'rat_4': '4', 'rat_42': '4.2', 'rat_44': '4.4',
								'rat_45': '4.5', 'rat_47': '4.7', 'rat_49': '4.9', 'rat_5': '5'
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
						console.log(`🔍 Found rating from row for empId=${empId}: ${rating}`);
						if (rating) {
							visibleRatings.add(rating);
						}
					}
				});

				console.log('✅ All collected ratings from rows:', Array.from(visibleRatings));

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


			updateSN(); 
			updateExportLink();
			calculateSummary();

		}

		// Bind the function to filter events
		document.getElementById('department-filter').addEventListener('change', filterRows);
		document.getElementById('grade-filter').addEventListener('change', filterRows);
		const revFilter = document.getElementById('Rev-filter');
		if (revFilter) {
			revFilter.addEventListener('change', filterRows);
		}
		const hodFilter = document.getElementById('Hod-filter');
		if (hodFilter) {
			hodFilter.addEventListener('change', filterRows);
		}
		const regionFilter = document.getElementById('region-filter');
		if (regionFilter) {
			regionFilter.addEventListener('change', filterRows); // Bind region filter
		}

			function updateSN() {
					let sn = 1;
					$('#employeetablemang tbody tr.employee-data-row:visible').each(function () {
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
						const daysWorked = calculateWorkingDays(dojDate, new Date('2023-12-31'));
						prorata = finalActual + ((daysWorked / 365) * finalActual) + threeMonthPortion;
					} else if (dojDate >= new Date('2024-01-01') && dojDate <= new Date('2024-09-30')) {
						const daysWorked = calculateWorkingDays(dojDate, new Date('2024-09-30'));
						prorata = ((daysWorked / 365) * finalActual) + threeMonthPortion;
					}

					prorataEl.textContent = formatNumber(prorata);
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
					row.classList.remove('highlight-row');
					
					const prevFixedEl = row.querySelector('.prev-fixed');
					const prorataEl = row.querySelector('.prorata');
					const actualInput = row.querySelector('.actual-input');
					const corrInput = row.querySelector('.corr-input');
					const ctcEl = row.querySelector('.ctc');
					const incEl = row.querySelector('.inc');
					const totalCtcEl = row.querySelector('.total-ctc');
					const finalPerEl = row.querySelector('.final-inc');
					const corrPerEl = row.querySelector('.corr-per');
					const maxVCtcEl = row.querySelector('.max-ctc');
					const maxctcannualEl = row.querySelector('.EmpCurrAnnualBasic');

					let prevFixed = parseFloat(prevFixedEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const prorata = calculateProrata(row, doj);
					const actual = parseFloat(actualInput?.value) || 0;
					const corr = parseFloat(corrInput?.value) || 0;

					if (prevFixed === 0) return;

					// 👇 Detect if corr-input triggered the update
					const triggeredByCorr = document.activeElement === corrInput;

					let baseIncrement = Math.round((prevFixed * prorata) / 100);
					let totalInc = baseIncrement + corr;
					let totalCTC = prevFixed + totalInc;
					let totalCTCInc = prevFixed + totalInc;

					let finalPercent = ((totalInc / prevFixed) * 100);
					let corrPercent = ((corr / prevFixed) * 100);

					const maxVCtc = parseFloat(maxVCtcEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;
					const maxctcannual = parseFloat(maxctcannualEl?.textContent.replace(/[^0-9.-]+/g, '')) || 0;

					let isCapping = false;

					if (totalCTC > maxVCtc && maxctcannual > 0) {
						isCapping = true;

						const roundedProratedValue = parseFloat(prorata.toFixed(2));
						const baseIncrementCap = (maxctcannual * roundedProratedValue) / 100;
						const totalInc = baseIncrementCap + corr;
						const totalCTCcap = prevFixed + baseIncrementCap;
						const totalCTCcapinc = prevFixed + totalInc;
						const totalIncnew = baseIncrement + corr;
						const finalPercent = ((totalIncnew / prevFixed) * 100);
						const corrPercent = ((corr / prevFixed) * 100);
						// const actualnew = prevFixed * (actual / 100);


						// const proRatanew = ((actualnew - prevFixed) / prevFixed) * 100;

						// console.log(proRatanew);
						// console.log(actualnew);
						// console.log(prevFixed);


						if (!triggeredByCorr) {
							ctcEl.textContent = formatNumberround(totalCTCcap);
							//prorataEl.textContent = formatNumberround(proRatanew);

						}
						
						incEl.textContent = formatNumber(totalInc);
						totalCtcEl.textContent = formatNumberround(totalCTCcapinc);
						finalPerEl.textContent = formatNumber(finalPercent);
						if (corrPerEl) corrPerEl.textContent = formatNumber(corrPercent);
						row.classList.add('highlight-row');

					} else {
						if (!triggeredByCorr) {
							ctcEl.textContent = formatNumberround(totalCTC);
						}

						incEl.textContent = formatNumber(totalInc);
						totalCtcEl.textContent = formatNumberround(totalCTCInc);
						finalPerEl.textContent = formatNumber(finalPercent);
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

						if (totalCTC > maxVCtc) {
							cappingExceeded = true;
							row.style.backgroundColor = 'rgb(255, 248, 223)';
							if (isExtraRow) {
								extraRow.style.backgroundColor = 'rgb(255, 248, 223)';
							}
						} else {
							row.style.backgroundColor = '';
							if (isExtraRow) {
								extraRow.style.backgroundColor = '';
							}
						}
					});

					const notification = document.getElementById('cappingNotification');
					notification.classList.toggle('d-none', !cappingExceeded);
				}


				document.querySelectorAll('.actual-input, .corr-input').forEach(input => {
					input.addEventListener('input', function () {
						const row = this.closest('tr');
						const doj = row.querySelector('td:nth-child(5)').textContent;
						
						// Get the rating from the current row
						    const ratingCell = row.querySelector('.row-rating'); // Assuming the rating is in the 13th column
						const rating = parseFloat(ratingCell.textContent.trim()).toFixed(2);

						if (row) {
							recalculateRow(row, doj, true);  // true means "force update"
							checkForCappingNotification(rating);  // Pass the rating of the affected row
							calculateSummary();
						}
					});
				});


				document.addEventListener('input', function(event) {
					// Check if the input element inside the rating-box is being edited
					if (event.target.matches('.rating-input')) {
						// Get the parent div of the input field
						const ratingBox = event.target.closest('.rating-box');
						
						// Extract the rating value from the data-rating attribute of the parent div
						const rating = ratingBox ? ratingBox.dataset.rating : undefined;
						console.log('rating from dataset:', rating);

						if (!rating) {
							console.log('data-rating attribute is missing!');
							return; // Stop execution if data-rating is missing
						}

						// Parse the rating value to float
						const parsedRating = parseFloat(rating);
						console.log('parsedRating:', parsedRating);

						if (isNaN(parsedRating)) {
							console.log('Invalid rating value:', rating);
							return; // Stop execution if the rating is not a valid number
						}

						// Get the value from the input field
						let inputValue = event.target.value;
						console.log('Triggered input value:', inputValue);

						// Format the input value to allow decimals
						let value = inputValue.replace(/[^0-9.]/g, '');
						const parts = value.split('.');
						if (parts.length > 2) {
							value = parts[0] + '.' + parts[1]; // Keep only the first decimal part
						}

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
						document.querySelectorAll('tr.employee-data-row').forEach(row => {
							if (row.offsetParent === null) return; // Skip if the row is not visible

							const ratingCell = row.querySelector('.row-rating');
							if (!ratingCell) {
								console.log('No .row-rating found in this row:', row);
								return;
							}

							const doj = row.querySelector('td:nth-child(5)').textContent;

							// Check if the row's rating matches the parsed rating from the data-rating attribute
							if (ratingCell.textContent.trim() !== rating) return;

							const actualInput = row.querySelector('.actual-input');
							if (actualInput) {
								actualInput.value = percentIncrease.toFixed(2); // Update the input value in the row
								recalculateRow(row, doj, true);
								checkForCappingNotification(rating);
								calculateSummary();
							}
						});
					}
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
					$('.rating-box').each(function () {
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
										console.log(response);
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