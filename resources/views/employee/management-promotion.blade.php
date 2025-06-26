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
								<li class="nav-item">
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
												class="nav-link pt-4 active" 
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
                                    <a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center" id="team_report_tab20"  href="{{route('managementReport')}}" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center" id="team_graph_tab20" href="{{route('managementGraph')}}" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
                                </li>
                            </ul>
							<div class="tab-content ad-content2" id="myTabContent2">
								<div class="tab-pane fade active show" id="teamappraisal" role="tabpanel">
									<div class="row">
										<div class="mfh-machine-profile">
                                            <div style="margin-top:-40px;float:left;margin-left:600px;">
												<ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
													<li class="mt-1"><a  id="home-tab1"
														href="{{route('managementAppraisal')}}" role="tab"
														aria-controls="home" aria-selected="true">Score <i
															class="fas fa-star mr-2"></i></a></li>
													<li class="mt-1"><a class="active" id="Promotion-tab20" 
														data-bs-toggle="tab" href="#Promotion" role="tab"
														aria-controls="Promotion" aria-selected="false">Promotion
														<i class="fas fa-file-alt mr-2"></i></a></li>
                                     
													<li class="mt-1"><a class="" id="Increment-tab21"
														href="{{route('managementIncrement')}}" role="tab"
														aria-controls="Increment" aria-selected="false">Increment <i class="fas fa-file-invoice mr-2"></i></a></li>
                                                    <!-- <li class="mt-1"><a class="" data-bs-toggle="modal" data-bs-target="#managementhelpvideo"><b>Help Video</b></a></li> -->
                                                    </ul>
											</div>
											<div class="tab-content splash-content2" id="myTabContent2">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
                                                    id="Promotion" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Team Promotion</b>
                                                            <div class="float-end">

																	<select id="department-filter">
																		<option value="">All Departments</option>
																		@foreach($employeeDetails->unique('department_name') as $employee)
																		<option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
																		@endforeach
																	</select>
																	<select id="grade-filter">
																		<option value="">All Grade</option>
																		@foreach($employeeDetails->unique('grade_name') as $grade)
																		<option value="{{ $grade->grade_name }}">{{ $grade->grade_name }}</option>
																		@endforeach
																	</select>
																
																	<select id="state-filter" style="display: none;">
																		<option value="">All State</option>
																		@foreach($employeeDetails->unique('city_village_name') as $hq)
																		<option value="{{ $hq->city_village_name }}">{{ $hq->city_village_name }}</option>
																		@endforeach
																	</select>
                                                                    <select id="BU-filter" style="display: none;">
                                                                        <option value="">All BU</option>
                                                                        @foreach ($businessUnits as $unit)
                                                                            <option value="{{ $unit->id }}">{{ $unit->business_unit_name }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <select id="Zone-filter" style="display: none;">
                                                                        <option value="">Select Zone</option>
                                                                    </select>

                                                                    <select id="region-filter" style="display: none;">
                                                                        <option value="">Select Region</option>
                                                                    </select>
															
																	<!-- <select id="region-filter" style="display:none;">
																			<option value="">All Region</option>
																			@foreach($employeeDetails->unique('region_name') as $reg)
																					<option value="{{ $reg->region_name }}">{{ $reg->region_name }}</option>
																			@endforeach
																	</select> -->
																	<a id="export-link"  href="{{ route('promotion.export', ['employee_id' => Auth::user()->EmployeeID, 'pms_year_id' => $PmsYId]) }}">
																	<i class="fas fa-file-excel mr-2 ms-2"></i>
																	</a>

																	<!-- <a title="PDF" href=""><i class="fas fa-file-pdf mr-2 ms-2"></i></a> -->
																</div>
															<!-- <a id="finalSubmitBtn" class="effect-btn btn btn-success squer-btn sm-btn float-end">Final Submit <i class="fas fa-check-circle mr-2"></i></a> -->
                                                        </div>
														<div style="max-height: 500px; overflow-y: auto; border: 1px solid #ddd;">
														<table class="table table-pad promotionsection" id="employeetablemang" style="border-collapse: collapse; width: 100%;">
															<thead>
																	<tr>
																		<th rowspan="2" style="text-align:center;">SN.</th>
																		<th class="text-center" colspan="5" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
																		<th class="text-center" colspan="2" style="border-right: 1px solid #fff;">Appraiser <br>[Proposed]</th>
																		<th class="text-center" colspan="2" style="border-right: 1px solid #fff;">Reviewer <br>[Proposed]</th>
																		<th rowspan="2" style="text-align:center;">Promotion<br> Details</th>
																		<th class="text-center" colspan="3" style="border-right: 1px solid #fff;border-left: 1px solid #fff;">Management [Proposed]</th>
																		<th rowspan="2" style="text-align:center;">Action</th>
																		<th rowspan="2" style="text-align:center;">Form Details</th>

																		
																	</tr>
																	<tr>
																		<th class="text-center" style="border-left: 1px solid #fff;">EC</th>
																		<th class="text-center">Name</th>
																		<th class="text-center">Department</th>
                                                                        <th class="text-center">Designation</th>
                                                   						<th id="sortGrade" class="text-center" style="cursor: pointer;">Grade ⬍</th>
                                                                        
																		<th class="text-center">Designation</th>
																		<th class="text-center" style="border-right: 1px solid #fff;">Grade</th>
																		<th class="text-center" style="width:100px;">Designation</th>
																		<th class="text-center" style="border-right: 1px solid #fff;">Grade</th>
																		<th class="text-center" style="width:100px;">Designation</th>
																		<th class="text-center" style="border-right: 1px solid #fff;">Grade</th>
														
																		<th class="text-center" style="border-right: 1px solid #fff;">Remarks</th>
																		
																	</tr>
																</thead>
																
																<tbody>
																	@foreach($employeeDetails as $employeedetails)
																		<tr>
																		<td>{{ $loop->iteration }}</td>
																		<input type="hidden" class="emp-id" value="{{ $employeedetails->EmployeeID }}">
																		<input type="hidden" class="companyid" value="{{ $employeedetails->CompanyId }}">
																		<input type="hidden" class="pmsid" value="{{ $employeedetails->EmpPmsId }}">

																		<td class="text-center">{{$employeedetails->EmpCode}}</td>
																		<td>{{ $employeedetails->Fname }} {{ $employeedetails->Sname }} {{ $employeedetails->Lname }}</td>
																		<td class="text-center">{{$employeedetails->department_name}}</td>
																		<td class="text-center">{{$employeedetails->designation_name}}</td>

																		<td class="text-center">{{$employeedetails->grade_name}}</td>
																		
																		<td class="hidden-state d-none">{{ $employeedetails->city_village_name }}</td>
																		<td class="hidden-reg d-none">{{ $employeedetails->region_name }}</td>

																		
																		<td class="text-center overflow-td" title="{{ $employeedetails->Appraiser_Designation }}">
																			{{ ($employeedetails->HR_Designation == $employeedetails->Appraiser_Designation) ? '-' : $employeedetails->Appraiser_Designation }}
																		</td>
																		<td class="text-center overflow-td" title="{{ $employeedetails->Appraiser_Grade }}">
																			{{ ($employeedetails->HR_Grade == $employeedetails->Appraiser_Grade) ? '-' : $employeedetails->Appraiser_Grade }}
																		</td>
																		<td class="text-center overflow-td" title="{{ $employeedetails->Reviewer_Designation }}">
																			{{ ($employeedetails->HR_Designation == $employeedetails->Reviewer_Designation) ? '-' : $employeedetails->Reviewer_Designation }}
																		</td>
																		<td class="text-center overflow-td" title="{{ $employeedetails->Reviewer_Grade }}">
																			{{ ($employeedetails->HR_Grade == $employeedetails->Reviewer_Grade) ? '-' : $employeedetails->Reviewer_Grade }}
																		</td>
																		<td class="text-center"><a title="History" data-bs-toggle="modal" onclick="showEmployeeDetails({{ $employeedetails->EmployeeID }})" 
                                                                            data-companyid="{{ $employeedetails->CompanyId }}"  data-PmsYId="{{ $PmsYId }}"  data-mangid="{{ Auth::user()->EmployeeID }}" ><i class="fas fa-eye"></i></a></td>
                                                                        

																		    {{-- Designation Dropdown --}}
																			
                                                                            {{-- Designation Dropdown --}}
                                                                            <td>
                                                                                <select style="width:136px;" class="designation-select" disabled>
                                                                                    <option value="">Select Designation</option>
                                                                                    @foreach($employeedetails->Available_Designations as $designation)
                                                                                       <option value="{{ $designation->id }}"
                                                                                            data-departmentid="{{ $designation->DepartmentId }}"
                                                                                            data-gradeids="{{ implode(',', array_filter([
                                                                                                $designation->GradeId,
                                                                                                $designation->GradeId_2,
                                                                                                $designation->GradeId_3,
                                                                                                $designation->GradeId_4,
                                                                                                $designation->GradeId_5
                                                                                            ])) }}"
                                                                                            @if(!empty($employeedetails->HOD_Designation) && 
                                                                                                $employeedetails->HOD_Designation != 0 && 
                                                                                                $designation->designation_name == $employeedetails->HOD_Designation &&
                                                                                                $employeedetails->HR_Designation != $employeedetails->HOD_Designation) 
                                                                                                selected 
                                                                                            @endif>
                                                                                            {{ $designation->designation_name }}
                                                                                        </option>

                                                                                    <!-- <option value="{{ $designation->id }}"
                                                                                            data-departmentid="{{ $designation->DepartmentId }}"
                                                                                            data-gradeids="{{ implode(',', array_filter([
                                                                                                $designation->GradeId,
                                                                                                $designation->GradeId_2,
                                                                                                $designation->GradeId_3,
                                                                                                $designation->GradeId_4,
                                                                                                $designation->GradeId_5
                                                                                            ])) }}"
                                                                                            @if(!empty($employeedetails->HOD_Designation) && $employeedetails->HOD_Designation != 0 && $designation->designation_name == $employeedetails->HOD_Designation) selected @endif>
                                                                                            {{ $designation->designation_name }}
                                                                                        </option> -->
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>

                                                                            {{-- Grade Dropdown --}}
                                                                                <td>
                                                                                    <select style="width:50px;" class="grade-select" disabled>
                                                                                        <option value="">Select Grade</option>

                                                                                        @php
                                                                                            $alreadyAddedGrades = [];
                                                                                        @endphp

                                                                                        {{-- Current Grade --}}
                                                                                        @if(!empty($employeedetails->Current_Grade) && !in_array($employeedetails->Current_Grade, $alreadyAddedGrades))
                                                                                            @php $alreadyAddedGrades[] = $employeedetails->Current_Grade; @endphp
                                                                                            <option value="{{ $employeedetails->Current_Id }}"
                                                                                                data-departmentid="{{ $employeedetails->employeeDetailsGeneral->DepartmentId }}"
                                                                                                data-gradeid="{{ $employeedetails->Current_Id }}"
                                                                                                @if($employeedetails->Current_Grade == $employeedetails->HOD_Grade &&
                                                                                                    $employeedetails->HR_Grade != $employeedetails->HOD_Grade &&
                                                                                                    !empty($employeedetails->HOD_Grade) && $employeedetails->HOD_Grade != 0) selected @endif>
                                                                                                {{ $employeedetails->Current_Grade }}
                                                                                            </option>
                                                                                        @endif

                                                                                        {{-- Next Grades (ensure uniqueness) --}}
                                                                                        @foreach($employeedetails->Next_Grade_Array as $index => $nextGrade)
                                                                                            @if(!in_array($nextGrade, $alreadyAddedGrades))
                                                                                                @php $alreadyAddedGrades[] = $nextGrade; @endphp
                                                                                                <option value="{{ $employeedetails->Next_Id[$index] }}"
                                                                                                    data-departmentid="{{ $employeedetails->employeeDetailsGeneral->DepartmentId }}"
                                                                                                    data-gradeid="{{ $employeedetails->Next_Id[$index] }}"
                                                                                                    @if($nextGrade == $employeedetails->HOD_Grade &&
                                                                                                        $employeedetails->HR_Grade != $employeedetails->HOD_Grade &&
                                                                                                        !empty($employeedetails->HOD_Grade) && $employeedetails->HOD_Grade != 0) selected @endif>
                                                                                                    {{ $nextGrade }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>

                                                                                    <!-- <select style="width:50px;" class="grade-select" disabled>
                                                                                        <option value="">Select Grade</option>

                                                                                        @php
                                                                                            $alreadyAddedGrades = [];
                                                                                        @endphp

                                                                                        {{-- Current Grade --}}
                                                                                        @if(!empty($employeedetails->Current_Grade) && !in_array($employeedetails->Current_Grade, $alreadyAddedGrades))
                                                                                            @php $alreadyAddedGrades[] = $employeedetails->Current_Grade; @endphp
                                                                                            <option value="{{ $employeedetails->Current_Id }}"
                                                                                                data-departmentid="{{ $employeedetails->employeeDetailsGeneral->DepartmentId }}"
                                                                                                data-gradeid="{{ $employeedetails->Current_Id }}"
                                                                                                @if($employeedetails->Current_Grade == $employeedetails->HOD_Grade && !empty($employeedetails->HOD_Grade) && $employeedetails->HOD_Grade != 0) selected @endif>
                                                                                                {{ $employeedetails->Current_Grade }}
                                                                                            </option>
                                                                                        @endif

                                                                                        {{-- Next Grades (ensure uniqueness) --}}
                                                                                        @foreach($employeedetails->Next_Grade_Array as $index => $nextGrade)
                                                                                            @if(!in_array($nextGrade, $alreadyAddedGrades))
                                                                                                @php $alreadyAddedGrades[] = $nextGrade; @endphp
                                                                                                <option value="{{ $employeedetails->Next_Id[$index] }}"
                                                                                                    data-departmentid="{{ $employeedetails->employeeDetailsGeneral->DepartmentId }}"
                                                                                                    data-gradeid="{{ $employeedetails->Next_Id[$index] }}"
                                                                                                    @if($nextGrade == $employeedetails->HOD_Grade && !empty($employeedetails->HOD_Grade) && $employeedetails->HOD_Grade != 0) selected @endif>
                                                                                                    {{ $nextGrade }}
                                                                                                </option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select> -->
                                                                                </td>


																			{{-- Remarks --}}
																			<td>
																				<input class="form-control remarks-input" style="width:130px;" placeholder="Enter your remarks"
																					value="{{ !empty($employeedetails->Hod_Justification) ? $employeedetails->Hod_Justification : '' }}" readonly>
																			</td>
                                                                            @if ($employeedetails->HodSubmit_IncStatus !='2' && ($employeedetails->Reviewer_PmsStatus == '2' || $employeedetails->Rev2_PmsStatus == '2') 
                                                                                && $employeedetails->Reviewer_PmsStatus != '3' 
                                                                                && $employeedetails->Rev2_PmsStatus != '3')
                                                                                <td class="text-center">
                                                                                    <a title="Save" href=""><i style="font-size:14px; display:none;" class="ri-save-3-line text-success mr-2 save-btn-pro"></i></a> 
                                                                                    <a title="Edit" data-bs-toggle="modal" data-bs-target="#"> <i class="fas fa-edit edit-btn"></i></a> 
                                                                                </td>
                                                                            @endif
                                                                        <td class="text-center">
                                                                                    <a href="javascript:void(0);" onclick="OpenViewWindow('{{ encrypt($employeedetails->EmpPmsId) }}')">
                                                                                        <i class="fas fa-eye"></i>
                                                                                    </a>
                                                                        </td>
                                                                        <td class="hidden-zone d-none">{{ $employeedetails->zone_id }}</td>
                                                                        <td class="hidden-bu d-none">{{ $employeedetails->bu_id }}</td>

																		
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
                		</div>
        			</div>
				</div>
                @include('employee.footerbottom')
        	</div>
    	</div>
    </div>

<!--view PromotionHistory Modal-->
<div class="modal fade show" id="PromotionHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title me-2"  style="font-size:13px;">
			<img src="./images/user.jpg"><br>
			EC: 1254
			</h5>
			<table class="table mb-0">
				<tr>
					<td colspan="3"><b>Kishan Kumar</b></td>
					<td colspan=""><b>DOJ: 07-03-2019</b></td>
				</tr>
				<tr>
					<td><b>Designation:</b></td>
					<td style="color:#DC7937;"><b>Ex. Software Developer</b></td>
					<td><b>Function:</b></td>
					<td style="color:#DC7937;"><b>Business Operations</b></td>
					
				</tr>
				<tr>
					<td><b>VNR Exp.</b></td>
					<td style="color:#DC7937;"><b>5.8 Year</b></td>
					<td><b>Rrev. Exp.</b></td>
					<td style="color:#DC7937;"><b>9.00 Year</b></td>
				</tr>
			</table>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body table-responsive">
		<div class="card">
			<div class="card-header">
				<div style="float:left;width:100%;">
					<h5 class="float-start"><b>Career Progression in VNR</b></h5>
				</div>
			</div>
			<div class="card-body table-responsive align-items-center">
				<table class="table table-pad">
					<thead>
						<tr>
							<th>SN.</th>
							<th>Date</th>
							<th>Designation</th>
							<th>Grade</th>
							
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>1.</b></td>
							<td>12-06-2024</td>
							<td>Territory Business Manager</td>
							<td>J4</td>
						</tr>
						<tr>
							<td><b>2.</b></td>
							<td>21-04-2016</td>
							<td>Territory Sales Executive</td>
							<td>J4</td>
						</tr>
						<tr>
							<td><b>3.</b></td>
							<td>12-06-2012</td>
							<td>Sales Executive</td>
							<td>J4</td>
						</tr>
						<tr>
							<td><b>4.</b></td>
							<td>12-06-2010</td>
							<td>Sales Officer</td>
							<td>J4</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
<!-- managementhelpvideo popup -->
<div class="modal fade show" id="managementhelpvideo" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
   <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title"><b>Promotion Help Video</b></h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">×</span>
                 </button>
           </div>
           <div class="modal-body table-responsive p-0 text-center">
               <video width="auto" height="500" controls>
                   <source src="./public/video/ess-managements-promotion-help.mp4" type="video/mp4">
               </video>
           </div>
       </div>
   </div>
</div>
  <!-- Employee Details Modal -->
  <div class="modal fade" id="empdetails" data-bs-backdrop="static"tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <img id="employeeImage" src="" alt="Employee Image" class="rounded-circle me-2" width="40" height="40">
                  <span id="employeeName"></span>
               </h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row emp-details-sep">
               <div class="col-md-6">
                     <ul>
                        <li><b>Employee Code:</b> <span id="employeeCode"></span></li>
                        <li><b>Designation:</b> <span id="designation"></span></li>
                        <li><b>Total VNR Experience:</b> <span id="totalExperienceYears"></span></li>
                     </ul>
                  </div>
                  <div class="col-md-6">
                     <ul>
                        <li><b>Date of Joining:</b> <span id="dateJoining"></span></li>
                        <li><b>Prev Experience:</b> <span id="totalprevExperienceYears"></span></li>
                     </ul>
                  </div>
                  <div class="col-md-12 mt-3">
                     <h5 id="careerh5"><b>Carrier Progression in VNR</b></h5>
                     <table class="table table-bordered mt-2">
                        <thead style="background-color:#cfdce1;">
                           <tr>
                              <th>SN</th>
                              <th>Date</th>
                              <th>Grade</th>
                              <th>Designation</th>
                              <th>Monthly Gross</th>
                              <th>CTC</th>
                              <th>Rating</th>
                           </tr>
                        </thead>
                        <tbody id="careerProgressionTable">
                           <!-- Career progression data will be populated here dynamically -->
                        </tbody>
                     </table>
                  </div>

				  <div id="proposedGradeDesignation"></div>

                 
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
            </div>
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
        var region = $('#region-filter').val().toLowerCase();
        var zone = $('#Zone-filter').val().toLowerCase();
        var bu = $('#BU-filter').val().toLowerCase();
        console.log(department);
        var visibleIndex = 1; // Counter for S. No.

        $('#employeetablemang tbody tr').each(function () {
            var rowDepartment = $(this).find('td:nth-child(7)').text().toLowerCase();
            var rowState = $(this).find('td:nth-child(10)').text().toLowerCase();
            var rowGrade = $(this).find('td:nth-child(9)').text().toLowerCase();
            var rowRegion = $(this).find('td:nth-child(11)').text().toLowerCase();
            var rowZone = $(this).find('td:nth-child(21)').text().toLowerCase();
            var rowBU = $(this).find('td:nth-child(22)').text().toLowerCase();

			if ((department === "" || rowDepartment.localeCompare(department, undefined, { sensitivity: 'base' }) === 0) &&
            (state === "" || rowState.localeCompare(state, undefined, { sensitivity: 'base' }) === 0) &&
            (grade === "" || rowGrade.localeCompare(grade, undefined, { sensitivity: 'base' }) === 0) &&
            (zone === "" || rowZone.localeCompare(zone, undefined, { sensitivity: 'base' }) === 0) &&
            (bu === "" || rowBU.localeCompare(bu, undefined, { sensitivity: 'base' }) === 0) &&
            (region === "" || rowRegion.localeCompare(region, undefined, { sensitivity: 'base' }) === 0)) {
            $(this).show();
            $(this).find('td:nth-child(1)').text(visibleIndex); // Update S. No.
            visibleIndex++;
        } else {
            $(this).hide();
        }
        });
    }
      function updateExportLink() {
        var department = $('#department-filter').val();
        var grade = $('#grade-filter').val();
        var region = $('#region-filter').val();
        var zone = $('#Zone-filter').val();
        var bu = $('#BU-filter').val();


        var baseUrl = "{!! route('promotion.export', ['employee_id' => Auth::user()->EmployeeID,'pms_year_id' => $PmsYId]) !!}";
        var exportUrl = baseUrl +
            '&department=' + encodeURIComponent(department) +
            '&grade=' + encodeURIComponent(grade) +
			'&bu=' + encodeURIComponent(bu) +
			'&zone=' + encodeURIComponent(zone) +
            '&region=' + encodeURIComponent(region);
        $('#export-link').attr('href', exportUrl);
    }

    // Show/hide the region filter based on department selection
    $('#department-filter').change(function () {
        var selectedDepartment = $(this).val();
        if (selectedDepartment === "Sales") {
            $('#region-filter').show();
            $('#Zone-filter').show();
            $('#BU-filter').show();

        } else {
            $('#region-filter').hide();
            $('#Zone-filter').hide();
            $('#BU-filter').hide();
            $('#region-filter').val('');
            $('#Zone-filter').val('');
            $('#BU-filter').val('');
        }
        filterTable();
        updateExportLink();
    });
  
     $('#department-filter, #grade-filter, #region-filter, #Zone-filter, #BU-filter').change(function () {
        filterTable();
        updateExportLink();
    });
 // BU filter change: load zones or reset filters if "all" or empty
    $('#BU-filter').on('change', function () {
        let buId = $(this).val();

        // Reset zone and region before loading new ones
        $('#Zone-filter').html('<option value="">Select Zone</option>').val('');
        $('#region-filter').html('<option value="">Select Region</option>').val('');

        if (!buId || buId.toLowerCase() === 'all') {
            // If no BU or 'all' selected, reset filters and show all data
            filterTable();
            updateExportLink();
        } else {
            $.ajax({
                url: '{{ route("get_zone_by_bu") }}',
                type: 'GET',
                data: { bu: buId },
                success: function (data) {
                    $('#Zone-filter').empty().append('<option value="">Select Zone</option>');
                    $.each(data.zoneList, function (index, zone) {
                        $('#Zone-filter').append('<option value="' + zone.zone_id + '">' + zone.zone_name + '</option>');
                    });
                    filterTable();
                    updateExportLink();

                }
            });
        }
    });

    // Zone filter change: load regions or reset
    $('#Zone-filter').on('change', function () {
        let zoneId = $(this).val();

        if (!zoneId) {
            $('#region-filter').html('<option value="">Select Region</option>').val('');
            filterTable();
            updateExportLink();
            return;
        }

        $('#region-filter').html('<option value="">Loading...</option>').val('');

        $.ajax({
            url: '{{ route("get_region_by_zone") }}',
            type: 'GET',
            data: { zone: zoneId },
            success: function (data) {
                $('#region-filter').empty().append('<option value="">Select Region</option>');
                $.each(data.regionList, function (index, region) {
                    $('#region-filter').append('<option value="' + region.region_name + '">' + region.region_name + '</option>');
                });
                filterTable();
                 updateExportLink();

            }
        });
    });
    // Hide region filter initially
         $('#region-dropdown').hide();

         // Initial filter application
         filterTable();
        updateExportLink();

      });
	  document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("sortGrade").addEventListener("click", function() {
            let table = document.querySelector("table tbody");
            let rows = Array.from(table.querySelectorAll("tr"));
            
            let ascending = this.dataset.order === "asc";
            this.dataset.order = ascending ? "desc" : "asc";

            rows.sort((a, b) => {
                let gradeA = a.cells[4].innerText.trim().toLowerCase();
                let gradeB = b.cells[4].innerText.trim().toLowerCase();

                return ascending ? gradeA.localeCompare(gradeB) : gradeB.localeCompare(gradeA);
            });

            rows.forEach(row => table.appendChild(row)); // Reorder table rows
        });
    });
 
    
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".edit-btn").forEach(function(editBtn) {
        editBtn.addEventListener("click", function(e) {
            e.preventDefault();
            const row = editBtn.closest("tr");

            row.querySelector(".designation-select").disabled = false;
            row.querySelector(".grade-select").disabled = false;
            row.querySelector(".remarks-input").readOnly = false;

            row.querySelector(".save-btn-pro").style.display = "inline-block";
        });
    });

    document.querySelectorAll(".save-btn-pro").forEach(function(saveBtn) {
        saveBtn.addEventListener("click", function(e) {
            e.preventDefault();
            const row = saveBtn.closest("tr");
            $('#loader').show();

			// IDs for backend
			const empid = row.querySelector(".emp-id").value;
			const companyid = row.querySelector(".companyid").value;
			const pmsid = row.querySelector(".pmsid").value;

			// Select elements
			const desigSelect = row.querySelector(".designation-select");
			const gradeSelect = row.querySelector(".grade-select");

			// Compare by NAME (text)
			const selectedDesigName = desigSelect.selectedOptions[0]?.textContent.trim();
			const reviewerDesig = desigSelect.dataset.reviewerDesig;

			const selectedGradeName = gradeSelect.selectedOptions[0]?.textContent.trim();
			const reviewerGrade = gradeSelect.dataset.reviewerGrade;

			const isDesigChanged = selectedDesigName !== reviewerDesig;
			const isGradeChanged = selectedGradeName !== reviewerGrade;

			// Send ID (value)
			const selectedDesigId = desigSelect.value;
			const selectedGradeId = gradeSelect.value;

			// Remarks
			const remarksInput = row.querySelector(".remarks-input");
			const remarks = remarksInput.value.trim();

			remarksInput.classList.remove("border-danger");

			if ((isDesigChanged || isGradeChanged) && remarks === "") {
				remarksInput.classList.add("border-danger");
				remarksInput.focus();
				$('#loader').hide();
				return;
			}
            $.ajax({
                url: "/update-employee-promotion",  // Laravel route
                type: "POST",
                data: {
                    empid: empid,
                    companyid: companyid,
                    pmsid: pmsid,
					designation: selectedDesigId,
					grade: selectedGradeId,
					remarks: remarks,
					_token: $('meta[name="csrf-token"]').attr("content")  // CSRF Token
                },
                success: function(response) {
                    $('#loader').hide();

                    if (response.success === true) {
                        toastr.success(response.message, 'Success', {
                            "positionClass": "toast-top-right",
                            "timeOut": 10000
                        });

                        desigSelect.disabled = true;
                        gradeSelect.disabled = true;
                        remarksInput.readOnly = true;
                    } else {
                        // Handle "logical" errors returned with 200 or 400
                        toastr.error(response.message || 'Something went wrong', 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        desigSelect.disabled = true;
                    gradeSelect.disabled = true;
                    remarksInput.readOnly = true;
                    }
                },

               error: function(xhr) {
                     $('#loader').hide();

                     // Display error message
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
    });
});
        function showEmployeeDetails(employeeId) {
             var companyId = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-companyid');
             var PmsYId = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-PmsYId');
             var mangid = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-mangid');
             var awsS3BaseUrl = "{{ env('AWS_URL') }}";

                     $.ajax({
                        url: '/employee/details/' + employeeId + '/' + PmsYId + '/' + mangid,
                        method: 'GET',
                         success: function(response) {
                             console.log(response);
          
                             if (response.error) {
                                 alert(response.error);
                                 return;
                             }
          
                             // Helper function to check if the date is invalid or is a default date like "01/01/1970"
                             function isInvalidDate(date) {
                                 return date === "1970-01-01" || date === "0000-00-00" || date === "";
                             }
                              var image_url = `${awsS3BaseUrl}/Employee_Image/${companyId}/${response.employeeDetails.EmpCode}.jpg`;

                             // Update modal content dynamically with employee details
                             $('#employeeName').text(response.employeeDetails.Fname + ' ' + response.employeeDetails.Sname + ' ' + response.employeeDetails.Lname);
                             $('#employeeCode').text(response.employeeDetails.EmpCode);
                             $('#designation').text(response.employeeDetails.designation_name);
                             $('#department').text(response.employeeDetails.department_name);
                             $('#dateJoining').text(formatDate(response.employeeDetails.DateJoining));
                             $('#employeeImage').attr('src', image_url);
          
                            
                             $('#totalExperienceYears').text(response.employeeDetails.YearsSinceJoining + ' Years ' +
                                 response.employeeDetails.MonthsSinceJoining + ' Months');
          
                             // **Handling Previous Experience Data**
                             var experienceData = response.previousEmployers || [];
                             console.log(experienceData);
          
                             // Empty the previous employer table before populating
                             var experienceTable = $('#experienceTable');
                             experienceTable.empty(); // Clear any previous data in the table
                             let totalYears = 0, totalMonths = 0;
          
                             experienceData.forEach(function(experience) {
                                 if (experience.DurationYears) {
                                     totalYears += parseInt(experience.DurationYears) || 0;
                                 }
                                 if (experience.DurationMonths) {
                                     totalMonths += parseInt(experience.DurationMonths) || 0;
                                 }
                             });
          
                             // Convert months to years if they exceed 12
                             totalYears += Math.floor(totalMonths / 12);
                             totalMonths = totalMonths % 12;
          
                             $('#totalprevExperienceYears').text(totalYears + ' Years ' + totalMonths + ' Months');
          
                             // Check if there's any previous experience data
                             if (experienceData.some(function(experience) {
                                     // Check if any of the values are not empty or null
                                     return experience.ExpComName.trim() !== '' ||
                                         experience.ExpDesignation.trim() !== '' ||
                                         experience.ExpFromDate !== null ||
                                         experience.ExpToDate !== null ||
                                         experience.DurationYears !== null;
                                 })) {
                                 // If there's any valid data, loop through and display it
                                 experienceData.forEach(function(experience, index) {
                                     // Format dates and duration
                                     var fromDate = isInvalidDate(experience.ExpFromDate) ? '-' : formatDate(
                                         experience.ExpFromDate);
                                     var toDate = isInvalidDate(experience.ExpToDate) ? '-' : formatDate(
                                         experience.ExpToDate);
                                     var duration = experience.DurationYears || '-';
          
                                     // Create the row for the table
                                     var row = `<tr>
                                 <td>${index + 1}</td>
                                 <td>${experience.ExpComName || '-'}</td>
                                 <td>${experience.ExpDesignation || '-'}</td>
                                 <td>${fromDate}</td>
                                 <td>${toDate}</td>
                                 <td>${duration}</td>
                             </tr>`;
          
                                     // Append the row to the table
                                     experienceTable.append(row);
                                 });
          
                                 // Show the "Previous Employers" section if there is valid data
                                 $('#prevh5').show(); // Show the "Previous Employers" heading
                                 $('#careerprev').show(); // Show the "Previous Employers" section
                                 $('#experienceTable').closest('table').show(); // Show the table
                             } else {
                                 // Hide the "Previous Employers" section if no valid data is available
                                 $('#prevh5').hide();
                                 $('#careerprev').hide();
                                 $('#experienceTable').closest('table').hide();
                             }
          
          
                             // **Handling Career Progression Data**
                             var careerProgressionData = response.careerProgression || [];
                             var careerProgressionTable = $('#careerProgressionTable');
                             careerProgressionTable.empty(); // Clear any previous data in the table
                             console.log(careerProgressionData);
                             // Check if there's any career progression data
                             if (Array.isArray(careerProgressionData) && careerProgressionData.length > 0) {
                                 careerProgressionData.forEach(function(progress, index) {
                                     var salaryDateRange = progress.Date|| '-';
                                     var grade = progress.Grade|| '-';
                                     var designation = progress.Designation|| '-';
          
                                     var monthly_gross = progress.Monthly_Gross|| '-';
                                     var ctc = progress.CTC|| '-';
                                     var rating = progress.Rating|| '-';
          
                                     var row = `<tr>
                                         <td>${index + 1}</td>
                                         <td>${salaryDateRange|| '-'}</td>
                                         <td>${grade || '-'}</td>
                                         <td>${designation|| '-'}</td>
                                         <td style="text-align: right;">${monthly_gross|| '-'}</td>
                                         <td style="text-align: right;">${ctc|| '-'}</td>
                                         <td style="text-align: right;">${rating|| '-'}</td>
                                     </tr>`;
          
                                     $('#careerProgressionTable').append(row);
                                 });
          
                                 // Show the Career Progression section if there's data
                                 $('#careerh5').show(); // Show the heading
                                 $('#careerProgressionTable').closest('table').show(); // Show the table
                             } else {
                                 // If no career progression data, hide the section
                                 $('#careerh5').hide();
                                 $('#careerProgressionTable').closest('table').hide();
                             }
          
          // Populate Training Programs Table
          var trainingTable = $('#trainingProgramsTable');
                   trainingTable.empty();
          
                   if (response.trainings) {
                       response.trainings.forEach(function(training, index) {
                           var row = `<tr>
                               <td>${index + 1}</td>
                               <td>${training.TraTitle || '-'}</td>
                               <td>${formatDate(training.TraFrom)}</td>
                               <td>${training.Duration || '-'}</td>
                               <td>${training.Institute || '-'}</td>
                               <td>${training.TrainerName || '-'}</td>
                               <td>${training.Location || '-'}</td>
                           </tr>`;
                           trainingTable.append(row);
                       });
                   } else {
                       trainingTable.append(`<tr><td colspan="7" class="text-center">No training programs found</td></tr>`);
                   }
          
                   // Populate Conferences Table
                   var conferenceTable = $('#conferenceTable');
                   conferenceTable.empty();
          
                   if (response.conferences) {
                       response.conferences.forEach(function(conference, index) {
                           var row = `<tr>
                               <td>${index + 1}</td>
                               <td>${conference.Title || '-'}</td>
                               <td>${formatDate(conference.ConfFrom)}</td>
                               <td>${conference.Duration || '-'}</td>
                               <td>${conference.ConductedBy || '-'}</td>
                               <td>${conference.Location || '-'}</td>
                           </tr>`;
                           conferenceTable.append(row);
                       });
                   } else {
                       conferenceTable.append(`<tr><td colspan="6" class="text-center">No conferences attended</td></tr>`);
                   }
                   if (response.employeeDetailsnew.HR_Grade || response.employeeDetailsnew.HR_Designation) {
                        $('#proposedGradeDesignation').html(`
                            <h5><b>Proposed Grade/Designation</b></h5>
                            <div class="card-body table-responsive align-items-center">
                                
                                <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                                    <div class="float-start">
                                        <h6 class="has-btn" style="margin-top:6px;">
                                            <b>Employee: <span class="p-color">${response.employeeDetailsnew.Fname || ''} ${response.employeeDetailsnew.Sname || ''} ${response.employeeDetailsnew.Lname || ''}</span></b>
                                        </h6>
                                    </div>
                                    
                                    <div class="float-end">
                                        <span class="me-3"><b>Grade:</b><span class="r-color ms-2"><b style="color: black;">${response.employeeDetailsnew.HR_Grade || '-'}</b></span></span>
                                        <span><b>Designation:</b><span class="p-color ms-2 me-2"><b style="color: black;">${response.employeeDetailsnew.HR_Designation || '-'}</b></span></span>
                                    </div>
                                </div>

                                <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                                    <div class="float-start">
                                        <h6 class="has-btn" style="margin-top:6px;">
                                            <b>Appraiser: <span class="p-color">${response.employeeDetailsnew.Appraiser_Fname || ''} ${response.employeeDetailsnew.Appraiser_Sname || ''} ${response.employeeDetailsnew.Appraiser_Lname || ''}</span></b>
                                        </h6>
                                    </div>
                                    <div class="float-end">
                                        <span class="me-3"><b>Grade:</b><span class="r-color ms-2"><b style="color: black;">${response.employeeDetailsnew.Appraiser_Grade || '-'}</b></span></span>
                                        <span><b>Designation:</b><span class="p-color ms-2 me-2"><b style="color: black;">${response.employeeDetailsnew.Appraiser_Designation || '-'}</b></span></span>
                                    </div>
                                </div>

                                <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                                    <div class="float-start">
                                        <h6 class="has-btn" style="margin-top:6px;">
                                            <b>Reviewer: <span class="p-color">${response.employeeDetailsnew.Reviewer_Fname || ''} ${response.employeeDetailsnew.Reviewer_Sname || ''} ${response.employeeDetailsnew.Reviewer_Lname || ''}</span></b>
                                        </h6>
                                    </div>
                                    <div class="float-end">
                                        <span class="me-3"><b>Grade:</b><span class="r-color ms-2"><b style="color: black;">${response.employeeDetailsnew.Reviewer_Grade || '-'}</b></span></span>
                                        <span><b>Designation:</b><span class="p-color ms-2 me-2"><b style="color: black;">${response.employeeDetailsnew.Reviewer_Designation || '-'}</b></span></span>
                                    </div>
                                </div>

                                <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                                    <div class="float-start">
                                        <h6 class="has-btn" style="margin-top:6px;">
                                            <b>HOD: <span class="p-color">${response.employeeDetailsnew.Rev2_Fname || ''} ${response.employeeDetailsnew.Rev2_Sname || ''} ${response.employeeDetailsnew.Rev2_Lname || ''}</span></b>
                                        </h6>
                                    </div>
                                    <div class="float-end">
                                        <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b style="color: black;">${response.employeeDetailsnew.Rev2_Grade || '-'}</b></span></span>
                                        <span><b>Rating:</b><span class="p-color ms-2 me-2"><b style="color: black;">${response.employeeDetailsnew.Rev2_Designation || '-'}</b></span></span>
                                    </div>
                                </div>

                            </div>
                        `);
                    } else {
                        $('#proposedGradeDesignation').empty(); // Clear if no grade/designation
                    }

                             // Show the modal
                             $('#empdetails').modal('show');
                         },
                         error: function(xhr, status, error) {
                             console.log('AJAX error:', status, error);
                             alert('An error occurred while fetching the data.');
                         }
                     });
        }
          function formatDate(dateString) {
             if (!dateString) return '-';
             var date = new Date(dateString);
             var day = ("0" + date.getDate()).slice(-2);
             var month = ("0" + (date.getMonth() + 1)).slice(-2);
             var year = date.getFullYear();
             return day + '-' + month + '-' + year;
          }

// When Grade is selected, filter Designations
$(document).on('change', '.grade-select', function () {
    let $gradeSelect = $(this);
    let selectedGradeId = $gradeSelect.val();
    let $row = $gradeSelect.closest('tr');
    let $desigSelect = $row.find('.designation-select');

    $desigSelect.find('option').each(function () {
        let gradeIds = ($(this).data('gradeids') || '').toString().split(',');
        if (!selectedGradeId || gradeIds.includes(selectedGradeId)) {
            $(this).prop('disabled', false).prop('hidden', false);
        } else {
            $(this).prop('disabled', true).prop('hidden', true);
        }
    });

    // Reset if current selection is no longer valid
    if ($desigSelect.find('option:selected').prop('disabled')) {
        $desigSelect.val('');
    }
});

// When Designation is selected, filter Grades
$(document).on('change', '.designation-select', function () {
    let $desigSelect = $(this);
    let selectedDesig = $desigSelect.find('option:selected');
    let allowedGrades = selectedDesig.data('gradeids') ? selectedDesig.data('gradeids').toString().split(',') : [];

    let $row = $desigSelect.closest('tr');
    let $gradeSelect = $row.find('.grade-select');

    $gradeSelect.find('option').each(function () {
        let gradeId = $(this).val();
        if (!gradeId || allowedGrades.includes(gradeId)) {
            $(this).prop('disabled', false).prop('hidden', false);
        } else {
            $(this).prop('disabled', true).prop('hidden', true);
        }
    });

    if ($gradeSelect.find('option:selected').prop('disabled')) {
        $gradeSelect.val('');
    }
});
function OpenViewWindow(encryptedEmpPmsId) {
		let url = `/view-reviewer/${encryptedEmpPmsId}`;
			window.open(url, '_blank', 'width=1350,height=600,scrollbars=yes');
		}
</script>

<style>
  .overflow-td {
        max-width: 90px; /* Adjust as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
		cursor: pointer; 
    }
	.border-danger {
    border: 2px solid #dc3545 !important; /* Bootstrap red, thicker */
    box-shadow: 0 0 4px rgba(220, 53, 69, 0.5); /* optional glow effect */
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

</style>