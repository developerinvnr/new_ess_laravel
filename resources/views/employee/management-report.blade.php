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
						<a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
						<span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
						<span class="d-none d-sm-block">PMS Information</span>
						</a>
					</li>
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{route('pms')}}" role="tab" aria-selected="true">
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
				@php
            			$ratingsnew = DB::table('hrm_pms_rating')
                        ->select('RatingName', 'Rating')
                        ->where('YearId', $PmsYId)
                        ->where('CompanyId', Auth::user()->CompanyId)
                        ->where('RatingStatus', 'A')
                        ->get();
                        $groupedRatings = $ratingsnew->groupBy('RatingName');

                @endphp
                    <div class="rating-ranges text-success">
                    <b>Rating Ranges:</b>
                    @foreach($groupedRatings as $ratingName => $ratingsneww)
                        @php
                            // Get all rating values for the same RatingName
                            $ratingValues = $ratingsneww->pluck('Rating')->implode(', ');
                        @endphp
                        <span class="rating-range-item- mr-2">
                            <b class="text-danger">{{ $ratingValues }}</b> - {{ $ratingName }}
                        </span>
                    @endforeach
                </div>
                <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
						<div class="mfh-machine-profile">
							
						<ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" >
				  <li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA {{$KraYear}}</a>
								</li>
								@if ($year_kra->NewY_AllowEntry == 'Y')
								<li class="nav-item active">
								<a style="color: #0e0e0e;padding-top:10px !important;border-right:1px solid #ddd;" class="nav-link pt-4" id="profile-new-tab20" data-bs-toggle="tab" href="#KraTabNew" role="tab" aria-controls="KraTabnew" aria-selected="false">My Team KRA New {{$kfnew}}-{{$ktnew}}</a>
								</li>
                                    @endif
									@if ($data['emp']['Appform'] == 'Y')
										@if (
											isset($appraisal_schedule) &&
											$CuDate >= $appraisal_schedule->HodFromDate &&
											$CuDate <= $appraisal_schedule->HodToDate &&
											$appraisal_schedule->HodDateStatus == 'A'
										)
											<li class="nav-item">
												<a style="color: #0e0e0e; padding-top:10px !important; border-right: 1px solid #ddd;" 
												class="nav-link pt-4" 
												id="team_appraisal_tab20"  
												href="{{ route('managementAppraisal') }}" 
												role="tab" 
												aria-controls="teamappraisal" 
												aria-selected="false">
												Team Appraisal
												</a>
											</li>
										@endif
									@endif

								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center active" id="team_report_tab20"  href="{{route('managementReport')}}" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
								</li>
								<li class="nav-item">
									<a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center" id="team_graph_tab20" href="{{route('managementGraph')}}" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
								</li>
                  			</ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								
							<div class="tab-pane fade active show" id="teamreport" role="tabpanel">
									<div class="row">
										<div class="mfh-machine-profile">
										<div style="margin-top:-40px;float:left;margin-left:660px;">
											<ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
												<li class="mt-1"><a class="active" id="pmsreport-tab1"
													data-bs-toggle="tab" href="#PmsReport" role="tab"
													aria-controls="PmsReport" aria-selected="true">PMS Report <i
														class="fas fa-star mr-2"></i></a></li>
												
												<li class="mt-1"><a class="d-none" id="IncrementReport-tab21"
													data-bs-toggle="tab" href="#IncrementReport" role="tab"
													aria-controls="IncrementReport" aria-selected="false">Increment Report 
													<i class="fas fa-file-invoice mr-2"></i></a></li> 
											
												</ul>
										</div>
										<div class="tab-content splash-content2">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
											id="PmsReport" role="tabpanel">
												<div class="card">
													
													<div class="card-header" style="background-color:#A8D0D2;">
														<b>Team PMS Report</b>
														<div class="float-end">
															<select id="department-filter">
																<option value="">All Departments</option>
																@foreach($employees->unique('department_name') as $employee)
																<option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
																@endforeach
															</select>

															<select id="grade-filter">
																<option value="">All Grade</option>
																@foreach($employees->unique('grade_name') as $grade)
																<option value="{{ $grade->grade_name }}">{{ $grade->grade_name }}</option>
																@endforeach
															</select>
														
															<select id="state-filter">
																<option value="">All State</option>
																@foreach($hq->filter(function($item) { return isset($item->city_village_name); })->unique('city_village_name') as $hqItem)
																	<option value="{{ $hqItem->city_village_name }}">{{ $hqItem->city_village_name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center p-0" style="max-height:500px;overflow-y: auto;">
														
													<table class="table table-pad scoresection table-bordered" id="employeetablemang">
													<thead>
														<tr>
															<th rowspan="2">SN.</th>
															<th class="text-center" colspan="8">Employee</th>
															<th colspan="2" class="text-center">Proposed</th>
															<th class="text-center" colspan="4">CTC</th>
															<th class="text-center" colspan="2">Total</th>
															<th rowspan="2" class="text-center">Final <br>CTC</th>
														</tr>
														<tr>
															<th style="text-align:center;">EC</th>
															<th>Employee Name</th>
															<th>Department</th>
															<th>Designation</th>
															<th class="text-center">Grade</th>
															<th class="text-center">State</th>
															<th class="text-center">Score</th>
															<th class="text-center">Rating</th>

															<th class="text-center">Designation</th>
															<th class="text-center">PG</th>

															<th class="text-center">Proposed <br>CTC</th>
															<th class="text-center">% <br>CTC</th>
															<th class="text-center">CTC <br>Correction</th>
															<th class="text-center">% <br>Correction</th>
															<th class="text-center">Total <br>Increment</th>
															<th class="text-center">Total <br>%</th>
														</tr>
														<tr style="background-color: #ed843e;">
																<th colspan="11" class="text-end">All Employees Total:</th>

																<th class="text-center"><b id="proposed-ctc">0</b></th>
																<th class="text-center"><b id="per-ctc"></b></th>
																<th class="text-center"><b id="ctc-corr">0</b></th>
																<th class="text-center"><b id="per-ctc-corr">0.00</b></th>
																<th class="text-center"><b id="total-inc">0</b></th>
																<th class="text-center"><b id="total-per"></b></th>
																<th class="text-center"><b id="final-per">0.00</b></th>
														</tr>
													</thead>

														<tbody>
															@foreach($employees as $key => $employee)
															<tr>
																<td>{{ $key + 1 }}</td>
																<td>{{ $employee->EmpCode }}</td>
																<td>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</td>
																<td>{{ $employee->department_name }}</td>
																<td>{{ $employee->designation_name }}</td>
																<td class="text-center">{{ $employee->grade_name }}</td>
																<td class="text-center">{{ $employee->city_village_name }}</td>
																<td class="text-center r-color">
																	<b>
																		{{ rtrim(rtrim(
																			number_format(
																				($employee->HOD_TotalFinalScore == 0 || $employee->HOD_TotalFinalScore == 0.0 || $employee->HOD_TotalFinalScore == 0.00) 
																				? $employee->Reviewer_TotalFinalScore 
																				: $employee->HOD_TotalFinalScore, 
																			2, '.', ''), '0'), '.') }}
																	</b>
																</td>

																<td class="text-center r-color">
																	<b>
																		{{ rtrim(rtrim(
																			number_format(
																				($employee->Hod_TotalFinalRating == 0 || $employee->Hod_TotalFinalRating == 0.0 || $employee->Hod_TotalFinalRating == 0.00) 
																				? $employee->Reviewer_TotalFinalRating 
																				: $employee->Hod_TotalFinalRating, 
																			2, '.', ''), '0'), '.') }}
																	</b>
																</td>

																<td class="text-center r-color">
																	<b title="{{ $employee->Hod_EmpDesignationName }}" style="cursor: pointer;">
																	{{ \Illuminate\Support\Str::limit($employee->HR_CurrDesigId == $employee->Hod_EmpDesignation) ? '-' : $employee->Hod_EmpDesignationName }}
																	</b>
																</td>
																
																<td class="text-center r-color">
																	<b title="{{ $employee->Hod_EmpDesignationName }}" style="cursor: pointer;">
																	{{ \Illuminate\Support\Str::limit($employee->HR_CurrGradeId == $employee->Hod_EmpGrade) ? '-' : $employee->Hod_EmpGradeName }}
																	</b>
																</td>																
																
																
																<td class="text-right p-color proposed-ctc-main">
																	<b>
																		{{ rtrim(rtrim(number_format($employee->Hod_Proposed_ActualCTC, 2, '.', ''), '0'), '.') }}
																	</b>
																</td>

																	<td class="text-right r-color proposed-ctc-main-per">
																		<b>{{ rtrim(rtrim(number_format($employee->Hod_Percent_ProIncCTC, 2, '.', ''), '0'), '.') }}</b>
																	</td>
																	<td class="text-right r-color ctc-corr-main">
																		<b>{{ rtrim(rtrim(number_format($employee->Hod_ProCorrCTC, 2, '.', ''), '0'), '.') }}</b>
																	</td>
																	<td class="text-right ctc-corr-main-per">
																		<b>{{ rtrim(rtrim(number_format($employee->Hod_Percent_ProCorrCTC, 2, '.', ''), '0'), '.') }}</b>
																	</td>
																	<td class="text-right p-color total-inc-main">
																		<b>{{ rtrim(rtrim(number_format($employee->Hod_IncNetCTC, 2, '.', ''), '0'), '.') }}</b>
																	</td>
																	<td class="text-right r-color total-inc-main-per">
																		<b>{{ rtrim(rtrim(number_format($employee->Hod_Percent_IncNetCTC, 2, '.', ''), '0'), '.') }}</b>
																	</td>
																	<td class="text-right p-color final-ctc-main">
																		<b>{{ rtrim(rtrim(number_format($employee->Hod_Proposed_ActualCTC, 2, '.', ''), '0'), '.') }}</b>
																	</td>
																	<td class="prev-ctc d-none">{{$employee->EmpCurrCtc}}</td>

															
															</tr>
															@endforeach
														</tbody>
													</table>
												</div>
											</div>
										</div>

										<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade d-none"
											id="IncrementReport" role="tabpanel">
												<div class="card">
													<div class="card-header" style="background-color:#A8D0D2;">
														<b>Team Increments Report</b>
														<div class="float-end">
															
																			<select id="department-filter-inc">
																				<option value="">All Departments</option>
																				@foreach($departments->unique('department_name') as $dept)
																					<option value="{{ $dept->department_name }}">{{ $dept->department_name }}</option>
																				@endforeach
																			</select>

																			<select id="grade-filter-inc">
																				<option value="">All Grade</option>
																				@foreach($employees->unique('grade_name') as $grade)
																				<option value="{{ $grade->grade_name }}">{{ $grade->grade_name }}</option>
																				@endforeach
																			</select>
																		
																			<select id="state-filter-inc">
																				<option value="">All State</option>
																				@foreach(collect($hq)->unique('city_village_name') as $hqItem)
																					<option value="{{ $hqItem->city_village_name }}">{{ $hqItem->city_village_name }}</option>
																				@endforeach

																			</select>
																	
															</div>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center">
														<div class="mb-2 w-100 p-1" style="background-color: #8da5a7;" >
															<tr>
																<th colspan="11" class="text-end">All Employees Total:</th>

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
															</tr>
														</div>
														<table class="table table-pad" id="employeetablemanginc">
															<thead>
																<tr>
																	<th rowspan="2">SN.</th>
																	<th class="text-center" colspan="8" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
																	<th colspan="2" class="text-center" style="border-right: 1px solid #fff;">Proposed</th>
																	<th class="text-center" colspan="4" style="border-right: 1px solid #fff;">CTC</th>
																	<th class="text-center" colspan="2" style="border-right: 1px solid #fff;">	Total</th>

																	<th class="text-center" colspan="3">Final</th>
																</tr>
																<tr>
																	<th style="text-align:center;border-left:1px solid #fff;">EC</th>
																	<th>Employee Name</th>
																	<th>Department</th>
																	<th>Designation</th>
																	<th class="text-center">Grade</th>
																	<th class="text-center">State</th>
																	<th class="text-center">Score</th>
																	<th class="text-center" style="border-right:1px solid #fff;">Rating</th>

																	<th class="text-center">Designation</th>
																	<th class="text-center">PG</th>

																	<th class="text-center">Proposed CTC</th>
																	<th class="text-center">% CTC</th>
																	<th class="text-center">CTC Correction</th>
																	<th class="text-center">% Correction</th>
																	<th class="text-center">Total Increment</th>
																	<th class="text-center">Total %</th>

																	<th class="text-center">Final CTC</th>
																</tr>
															</thead>
															<tbody>
																@foreach($employees as $key => $employee)
																<tr>
																	<td>{{ $key + 1 }}</td>
																	<td>{{ $employee->EmpCode }}</td>
																	<td>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</td>
																	<td>{{ $employee->department_name }}</td>
																	<td>{{ $employee->designation_name }}</td>
																	<td class="text-center">{{ $employee->grade_name }}</td>
																	<td class="text-center">{{ $employee->city_village_name }}</td>
																	<td class="text-center r-color">
																		<b>
																			{{ rtrim(rtrim(
																				number_format(
																					($employee->HOD_TotalFinalScore == 0 || $employee->HOD_TotalFinalScore == 0.0 || $employee->HOD_TotalFinalScore == 0.00) 
																					? $employee->Reviewer_TotalFinalScore 
																					: $employee->HOD_TotalFinalScore, 
																				2, '.', ''), '0'), '.') }}
																		</b>
																	</td>

																	<td class="text-center r-color">
																		<b>
																			{{ rtrim(rtrim(
																				number_format(
																					($employee->Hod_TotalFinalRating == 0 || $employee->Hod_TotalFinalRating == 0.0 || $employee->Hod_TotalFinalRating == 0.00) 
																					? $employee->Reviewer_TotalFinalRating 
																					: $employee->Hod_TotalFinalRating, 
																				2, '.', ''), '0'), '.') }}
																		</b>
																	</td>

																	<td class="text-center r-color">
																		<b title="{{ $employee->Hod_EmpDesignationName }}" style="cursor: pointer;">
																			{{ \Illuminate\Support\Str::limit($employee->Hod_EmpDesignationName, 10, '...') }}
																		</b>
																	</td>

																	<td class="text-center r-color"><b>{{ $employee->Hod_EmpGradeName }}</b></td>
																	<td class="p-color">
																		<b>
																			{{ rtrim(rtrim(number_format($employee->Hod_ProIncSalary, 2, '.', ''), '0'), '.') }}
																		</b>
																	</td>

																		<td class="text-center r-color">
																			<b>{{ rtrim(rtrim(number_format($employee->Hod_Percent_ProIncCTC, 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="text-center r-color">
																			<b>{{ rtrim(rtrim(number_format($employee->Hod_ProCorrCTC, 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="text-center">
																			<b>{{ rtrim(rtrim(number_format($employee->Hod_Percent_ProCorrCTC, 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="p-color">
																			<b>{{ rtrim(rtrim(number_format($employee->Hod_IncNetCTC, 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="text-center r-color">
																			<b>{{ rtrim(rtrim(number_format($employee->Hod_Percent_IncNetCTC, 2, '.', ''), '0'), '.') }}</b>
																		</td>
																		<td class="p-color">
																			<b>{{ rtrim(rtrim(number_format($employee->Hod_Proposed_ActualCTC, 2, '.', ''), '0'), '.') }}</b>
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
								</div>
							</div>
							<div class="tab-pane fade" id="teamgraph" role="tabpanel">
								<div class="row">
									<div class="mfh-machine-profile">
										<div style="margin-top:-40px;float:left;margin-left:660px;">
											
											<ul class="kra-btns nav nav-tabs border-0" id="ratingTab1" role="tablist">
												<li class="mt-1"><a class="active" id="ratinggraph-tab1"
													data-bs-toggle="tab" href="#ratinggraph" role="tab"
													aria-controls="ratinggraph" aria-selected="true">Rating Graph <i
														class="fas fa-star mr-2"></i></a></li>
												
												<li class="mt-1"><a class="" id="overallratinggraph-tab21"
													data-bs-toggle="tab" href="#overallratinggraph" role="tab"
													aria-controls="overallratinggraph" aria-selected="false">Overall Rating Graph <i class="fas fa-file-invoice mr-2"></i></a></li>
											</ul>
										</div>
									
										<div class="tab-content splash-content2" >
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
										 role="tabpanel" id="ratinggraph">
												<div class="card">
													<div class="card-header">
														<h5>Rating Graph</h5>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center">
														<table class="table table-pad table-striped" style="font-size:11px;">
															<tbody>
																<tr>
																	<td><b>Rating</b></td>
																	<td>1.0</td>
																	<td>2.0</td>
																	<td>2.5</td>
																	<td>2.7</td>
																	<td>2.9</td>
																	<td>3.0</td>
																	<td>3.2</td>
																	<td>3.4</td>
																	<td>3.5</td>
																	<td>3.7</td>
																	<td>3.9</td>
																	<td>4.0</td>
																	<td>4.2</td>
																	<td>4.4</td>
																	<td>4.5</td>
																	<td>4.7</td>
																	<td>4.9</td>
																	<td>5.0</td>
																</tr>
																<tr>
																	<td><b>Expected</b></td>
																	<td>0</td>
																	<td>0</td>
																	<td>0.09</td>
																	<td>0.15</td>
																	<td>0.21</td>
																	<td>0.24</td>
																	<td>0.3</td>
																	<td>0.39</td>
																	<td>0.42</td>
																	<td>0.36</td>
																	<td>0.27</td>
																	<td>0.21</td>
																	<td>0.15</td>
																	<td>0.12</td>
																	<td>0.09</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																</tr>
																<tr>
																	<td><b>Actual</b></td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>1</td>
																	<td>0</td>
																	<td>2</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>
																	<td>0</td>

																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade"
										 role="tabpanel" id="overallratinggraph">
												<div class="card">
													<div class="card-header">
														<h5>Overall Rating Graph</h5>
													</div>
													<div class="card-body table-responsive dd-flex align-items-center">
														<table class="table table-pad">
															<tbody>
																<tr>
																	<td>Rating</td>
																</tr>
																<tr>
																	<td>Employee</td>
																</tr>
																<tr>
																	<td>Appariser</td>
																</tr>
																<tr>
																	<td>Reviewer</td>
																</tr>
																<tr>
																	<td>HOD</td>
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
        			</div>
				</div>
                @include('employee.footerbottom')

        	</div>
    	</div>
    </div>
@include('employee.footer')

<script>
	$(document).ready(function () {
		function filterTable() {
			var department = $('#department-filter').val().toLowerCase();
			var state = $('#state-filter').val().toLowerCase();
			var grade = $('#grade-filter').val().toLowerCase();
			var visibleIndex = 1; // Counter for S. No.

			$('#employeetablemang tbody tr').each(function () {
				var rowDepartment = $(this).find('td:nth-child(4)').text().toLowerCase();
				var rowState = $(this).find('td:nth-child(7)').text().toLowerCase();
				var rowGrade = $(this).find('td:nth-child(6)').text().toLowerCase();

				if ((department === "" || rowDepartment.localeCompare(department, undefined, { sensitivity: 'base' }) === 0) &&
				(state === "" || rowState.localeCompare(state, undefined, { sensitivity: 'base' }) === 0) &&
				(grade === "" || rowGrade.localeCompare(grade, undefined, { sensitivity: 'base' }) === 0)) {
				$(this).show();
				$(this).find('td:nth-child(1)').text(visibleIndex); // Update S. No.
				visibleIndex++;
			} else {
				$(this).hide();
			}
			});
		}

		// Trigger filtering when any dropdown changes
		$('#department-filter, #state-filter, #grade-filter').change(function () {
			filterTable();
			calculateTotals(); // ← Add this line

		});

         // Initial filter application
         filterTable();
		 calculateTotals(); // ← Add this line

    });
		function calculateTotals() {
			let totalProposedCTC = 0;
			let totalCorr = 0;
			let totalInc = 0;
			let totalFinal = 0;
			let totalPrevCtc = 0;
			let proposedCtcMainPerSum = 0;
			let rowCount = 0;

			// Sum visible rows only
			$('#employeetablemang tbody tr:visible').each(function () {
				let ctcCell = $(this).find('.proposed-ctc-main');
				let ctccorrCell = $(this).find('.ctc-corr-main');
				let totalIncCell = $(this).find('.total-inc-main');
				let finalCell = $(this).find('.final-ctc-main');
				let prevCtcCell = $(this).find('.prev-ctc');
				let proposedctcmainCell = $(this).find('.proposed-ctc-main-per');

				if (ctcCell.length > 0 || ctccorrCell.length > 0) {
					rowCount++;

					let val = parseFloat(ctcCell.text().trim().replace(/,/g, '')) || 0;
					totalProposedCTC += val;

					let valcorr = parseFloat(ctccorrCell.text().trim().replace(/,/g, '')) || 0;
					totalCorr += valcorr;

					let valtotinc = parseFloat(totalIncCell.text().trim().replace(/,/g, '')) || 0;
					totalInc += valtotinc;

					let totfinal = parseFloat(finalCell.text().trim().replace(/,/g, '')) || 0;
					totalFinal += totfinal;

					let prevCtcVal = parseFloat(prevCtcCell.text().trim().replace(/,/g, '')) || 0;
					totalPrevCtc += prevCtcVal;

					let proposedCtcMainPer = parseFloat(proposedctcmainCell.text().trim().replace(/,/g, '')) || 0;
					proposedCtcMainPerSum += proposedCtcMainPer;
				}
			});

			// ✅ Calculate average of .proposed-ctc-main-per column
			const proposedCtcMainPerAvg = rowCount > 0
				? (proposedCtcMainPerSum / rowCount).toFixed(2)
				: '0.00';

			// Update the totals in the header
			$('#proposed-ctc').text(formatINR(totalProposedCTC));
			$('#ctc-corr').text(formatINR(totalCorr));
			$('#total-inc').text(formatINR(totalInc));
			$('#final-per').text(formatINR(totalFinal));
			$('#per-ctc').text(proposedCtcMainPerAvg); // Assuming you have this element in HTML

			// ✅ Delay for DOM updates and calculate correction percentage
			setTimeout(function () {
				let totalCorrFromHeader = parseFloat($('#ctc-corr').text().trim().replace(/,/g, '')) || 0;
				const avgCorrPer = totalPrevCtc !== 0
					? ((totalCorrFromHeader / totalPrevCtc) * 100).toFixed(2)
					: '0.00';

				$('#per-ctc-corr').text(avgCorrPer);
			}, 50);
		}



function formatINR(amount) {
    let decimalPart = +(amount % 1).toFixed(2);
    let roundedAmount = Math.floor(amount);
    let formatted = new Intl.NumberFormat('en-IN').format(roundedAmount);

    if (decimalPart !== 0 && !decimalPart.toFixed(2).endsWith('0')) {

  }

    return formatted;
}


    // Run on page load
    document.addEventListener('DOMContentLoaded', calculateTotals);

</script>
