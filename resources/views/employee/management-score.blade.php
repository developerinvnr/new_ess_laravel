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
						   <div style="margin-top:-40px;float:left;margin-left:660px;">
												<ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
													<li class="mt-1"><a class="active" id="home-tab1"
														href="{{route('managementAppraisal')}}" role="tab"
														aria-controls="home" aria-selected="true">Score <i
															class="fas fa-star mr-2"></i></a></li>
													<li class="mt-1"><a class="" id="Promotion-tab20"
															href="{{route('managementPromotion')}}" role="tab"
															aria-controls="Promotion" aria-selected="false">Promotion
															<i class="fas fa-file-alt mr-2"></i></a>
													</li>
                                     
													<li class="mt-1"><a class="" id="Increment-tab21"
														href="{{route('managementIncrement')}}" role="tab"
														aria-controls="Increment" aria-selected="false">Increment <i class="fas fa-file-invoice mr-2"></i></a></li>
												
                                                    </ul>
											</div>
                              <div class="tab-content splash-content2" id="myTabContent2">
                                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
                                    id="Score" role="tabpanel" >
                                    <div class="card">
                                       <div class="card-header" style="background-color:#A8D0D2;">
                                          <b>Team Score</b>
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
                                          
                                             <!-- <select id="state-filter">
                                                <option value="">All State</option>
                                                @foreach($employeeDetails->unique('city_village_name') as $hq)
                                                <option value="{{ $hq->city_village_name }}">{{ $hq->city_village_name }}</option>
                                                @endforeach
                                             </select> -->
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

											                                 
                                             <!-- <select id="region-filter">
                                                      <option value="">All Region</option>
                                                      @foreach($employeeDetails->unique('region_name') as $reg)
                                                            <option value="{{ $reg->region_name }}">{{ $reg->region_name }}</option>
                                                      @endforeach
                                             </select> -->
                                            
                                             <a title="Logic" data-bs-toggle="modal"
                                                    data-bs-target="#logicpopup">Logic <i
                                                        class="fas fa-tasks mr-2"></i></a>
                                             Export:
                                             <a id="export-link" href="{{ route('score.export', ['employee_id' => Auth::user()->EmployeeID,'pms_year_id' => $PmsYId]) }}">
												<i class="fas fa-file-excel mr-2 ms-2"></i>
                                             </a> |
                                          </div>
                                       </div>
                                       <div id="scorelist" class="card-body table-responsive dd-flex align-items-center p-0" style="max-height: 500px; overflow-y: auto;">
                                          <table class="table table-pad scoresection" id="employeetablemang" >
                                             <thead>
                                                <tr>
                                                   <th rowspan="2" class="text-center" style="border-right:1px solid #fff;">SN.</th>
                                                   <th colspan="4" class="text-center" style="border-right:1px solid #fff;">Employee Information</th>
                                                   <th colspan="8" class="text-center" style="border-right:1px solid #fff;">Score/Rating</th>
                                                   <th rowspan="2" class="text-center">History</th>
                                                   <th rowspan="2" class="text-center">Action</th>
                                                   <th rowspan="2" class="text-center">Form Details</th>

                                                </tr>
                                                <tr>
                                                   <th class="text-center">EC</th>
                                                   <th class="text-center">Name</th>
                                                   <th class="text-center">Department</th>
                                                   <th id="sortGrade" class="text-center" style="cursor: pointer;">Grade ⬍</th>
                                                   <th class="text-center">Last Rating</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;">Appraiser</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;">Reviewer/HOD</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;">Details</th>
                                                   <th colspan="3" class="text-center" style="border-right: 1px solid #fff;">Management</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                @foreach($employeeDetails as $employeedetails)
                                                <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td class="text-center">{{$employeedetails->EmpCode}}</td>
                                                   <td>{{ $employeedetails->Fname }} {{ $employeedetails->Sname }} {{ $employeedetails->Lname }}</td>
                                                   <td class="text-center">{{$employeedetails->department_name}}</td>
                                                   <td class="text-center">{{$employeedetails->grade_name}}</td>
                                                   
                                                   <td class="hidden-state d-none">{{ $employeedetails->city_village_name }}</td>
                                                   <td class="hidden-reg d-none">{{ $employeedetails->region_name }}</td>


                                                   <td class="text-center">{{$employeedetails->FirstRating ?? '-'}}</td>
                                                   <td class="text-center">
														<span class="r-color">{{ $employeedetails->Emp_TotalFinalScore == 0 ? '0' : rtrim(rtrim(number_format($employeedetails->Emp_TotalFinalScore, 2, '.', ''), '0'), '.') }}</span> /
														<span class="p-color">{{ $employeedetails->Emp_TotalFinalRating == 0 ? '0' : rtrim(rtrim(number_format($employeedetails->Emp_TotalFinalRating, 2, '.', ''), '0'), '.') }}</span>
													</td>
													@if($employeedetails->Appraiser_PmsStatus == '2' || $employeedetails->Appraiser_PmsStatus === 2)

													<td class="text-center r-color">
														<span class="r-color">{{ $employeedetails->Appraiser_TotalFinalScore == 0 ? '0' : rtrim(rtrim(number_format($employeedetails->Appraiser_TotalFinalScore, 2, '.', ''), '0'), '.') }}</span> /
														<span class="p-color">{{ $employeedetails->Appraiser_TotalFinalRating == 0 ? '0' : rtrim(rtrim(number_format($employeedetails->Appraiser_TotalFinalRating, 2, '.', ''), '0'), '.') }}</span>
													</td>
													@else
													<td class="text-center r-color">
														<span class="r-color">0</span> /
														<span class="p-color">0</span>
													</td>
													@endif

													@if($employeedetails->Reviewer_PmsStatus == '2' || $employeedetails->Reviewer_PmsStatus === 2)

													<td class="text-center r-color">
														<span class="r-color">{{ $employeedetails->Reviewer_TotalFinalScore == 0 ? '0' : rtrim(rtrim(number_format($employeedetails->Reviewer_TotalFinalScore, 2, '.', ''), '0'), '.') }}</span> /
														<span class="p-color">{{ $employeedetails->Reviewer_TotalFinalRating == 0 ? '0' : rtrim(rtrim(number_format($employeedetails->Reviewer_TotalFinalRating, 2, '.', ''), '0'), '.') }}</span>
													</td>
													@else
													<td class="text-center r-color">
														<span class="r-color">0</span> /
														<span class="p-color">0</span>
													</td>
													@endif

                                                   <td>
                                                      <a href="#" data-bs-toggle="modal" data-bs-target="#viewEmpdetails-{{ $employeedetails->EmployeeID }}">
                                                      <i class="fas fa-eye mr-2"></i>
                                                      </a>
                                                   </td>
												   @php
														$score = $employeedetails->Hod_TotalFinalScore;
														$rating = $employeedetails->Hod_TotalFinalRating;

														$formattedScore = fmod($score, 1) != 0 ? number_format($score, 2) : number_format($score, 0);
														$formattedRating = fmod($rating, 1) != 0 ? number_format($rating, 2) : number_format($rating, 0);
													@endphp
													<td>
														<input class="form-control score-input no-border" data-employeeid="{{ $employeedetails->EmployeeID }}" 
																data-reviewerscore="{{ $employeedetails->Reviewer_TotalFinalScore }}" 
																onkeypress="inpNum(event)" type="number" name="score" 
																style="width:70px;" readonly value="{{ $formattedScore }}" />
														</td>
														<td>
														<input class="form-control no-border" id="rating-input{{ $employeedetails->EmployeeID }}" 
																type="number" style="width:70px;" readonly value="{{ $formattedRating }}" />
														</td>
                                                
                                                   <td><input style="width:114px" class="form-control remarks-input no-border" name="remark" data-employeeid="{{ $employeedetails->EmployeeID }}"
                                                   value="{{$employeedetails->HodRemark}}" maxlength="100" readonly placeholder="Enter your remarks"></input></td>
        
                                                   <td class="text-center"><a title="History" data-bs-toggle="modal" onclick="showEmployeeDetails({{ $employeedetails->EmployeeID }})" 
                                                      data-companyid="{{ $employeedetails->CompanyId }}"  data-PmsYId="{{ $PmsYId }}"  data-mangid="{{ Auth::user()->EmployeeID }}" ><i class="fas fa-eye"></i></a></td>
                                                   <td>
												   @if ($employeedetails->HodSubmit_IncStatus !='2' && ($employeedetails->Reviewer_PmsStatus == '2' || $employeedetails->Rev2_PmsStatus == '2') 
														&& $employeedetails->Reviewer_PmsStatus != '3' 
														&& $employeedetails->Rev2_PmsStatus != '3')
														<a title="Edit" href="#" class="edit-score" data-employeeid="{{ $employeedetails->EmployeeID }}">
															<i class="fas fa-edit"></i>
														</a>
														<a title="Revert" class="revertmanag" data-bs-toggle="modal" data-employeeid="{{ $employeedetails->EmployeeID }}" data-emppmsid="{{ $employeedetails->EmpPmsId }}" data-bs-target="#resubmitKRA">
															<i class="fas fa-retweet"></i>
														</a>
													@endif

												    <a title="Save" href="javascript:void(0);" style="display:none;" class="save-btn" data-employeeid="{{$employeedetails->EmployeeID}}"
                                                      data-pmsid="{{$PmsYId}}" data-companyid="{{$employeedetails->CompanyId}}">
                                                      <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                                      </a>
													  <!-- Revert Button -->
                                                   </td>
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
                  <div class="col-md-12 mt-3" id="careerprev">
                     <h5 ><b>Previous Employers</b></h5>
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
                        <tbody id="experienceTable">
                           <!-- Experience data will be populated here dynamically -->
                        </tbody>
                     </table>
                  </div>
                  <!-- Developmental Progress -->
                  <div class="col-md-12 mt-3" id="careerprev">
                     <h5 class="float-start"><b>Developmental Progress</b></h5>
                     <h5 class="mb-2">A. Training Programs</h5>
                     <table class="table table-pad mb-4">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th>Subject</th>
                              <th>Date</th>
                              <th>Duration</th>
                              <th>Institute</th>
                              <th>Trainer</th>
                              <th>Location</th>
                           </tr>
                        </thead>
                        <tbody id="trainingProgramsTable">
                           <tr>
                              <td colspan="7" class="text-center">Loading...</td>
                           </tr>
                        </tbody>
                     </table>
                     <h5 class="mb-2">B. Conference Attended</h5>
                     <table class="table table-pad">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th>Title</th>
                              <th>Date</th>
                              <th>Duration</th>
                              <th>Conduct by</th>
                              <th>Location</th>
                           </tr>
                        </thead>
                        <tbody id="conferenceTable">
                           <tr>
                              <td colspan="6" class="text-center">Loading...</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!------- emp details for managements ------->
   @foreach ($employeeDetails as $employee)
<div class="modal fade" id="viewEmpdetails-{{ $employee->EmployeeID }}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
               <h5>Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body table-responsive">
               <div class="card">
                  <div class="card-header" style="background-color:#ededed;">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start">
						<b>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</b>
						<br>
						<div class="float-start" style="font-size:12px;">
							<b>Designation: {{ $employee->designation_name }} <br> Department: {{ $employee->department_name }}</b>

						</div>
                        </h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive align-items-center">
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
                              <b>Employee: <span class="p-color">{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</span> </b>
                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Emp_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b> {{ $employee->Emp_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
                              <b>Appraiser: <span class="p-color">{{ $employee->Appraiser_Fname }} {{ $employee->Appraiser_Sname }} {{ $employee->Appraiser_Lname }}</span> </b>
                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Appraiser_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b>{{ $employee->Appraiser_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
                              <b>Reviewer: <span class="p-color">{{ $employee->Reviewer_Fname }} {{ $employee->Reviewer_Sname }} {{ $employee->Reviewer_Lname }}</span> </b>
                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Reviewer_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b>{{ $employee->Reviewer_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
						   <b>HOD: <span class="p-color">{{ $employee->Rev2_Fname }} {{ $employee->Rev2_Sname }} {{ $employee->Rev2_Lname }}</span> </b>

                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Reviewer_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b>{{ $employee->Reviewer_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
             <!--View logic modal-->
             <div class="modal fade show" id="logicpopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" ><b>Logic</b></h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body table-responsive p-0">
					
																					
								<!--All start logics-->
								<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 1</b></h5>
								<p>Higher the achievement, higher the scoring till a limit</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>110</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 2</b></h5>
								<p>Higher the achievement, max scored is 100</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>100</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 2A</b></h5>
								<p>Higher the achievement, higher the scoring till 110 as upper limit</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>110</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>90</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 3</b></h5>
								<p>Either 100 or Zero</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 4</b></h5>
								<p>Lower the actual, zero</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>100</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 5</b></h5>
								<p>Higher the achievement, Max is 100, Below 70% achievement, Zero</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td><70</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>80</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>100</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 6 (For Sale)</b></h5>
								<p>Need to be 150% weightage, and lower zero if>25% return in FC</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Sales Return</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>Return <= 10%</td><td>150</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 10% to 15%</td><td>125</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 15% to 20%</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 20% to 25%</td><td>75</td>
										</tr>
										<tr>
											<td>100</td><td>Return more then 25%</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 6A (For Sale)</b></h5>
								<p>Need to be 100% weightage, and owest is zero if>25% return in FC_HY</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Sales Return</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>Return < 15%</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 15% to 20%</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 20% to 25%</td><td>50</td>
										</tr>
										<tr>
											<td>100</td><td>Return more then 25%</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 6B (For Sales)</b></h5>
								<p>Need to be 100% weightage, and lower zero if>5% return in FC_OP</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>Return < 5%</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>Return between >=5%</td><td>0</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 7 (For Sale)</b></h5>
								<p>Need to be 150% weightage, and lower zero if>10% return in VEG</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Sales Return</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>Return 0%</td><td>150</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 0% to 2%</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 2% to 5%</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 5% to 10%</td><td>75</td>
										</tr>
										<tr>
											<td>100</td><td>Return more then >10%</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 7A (For Sale)</b></h5>
								<p>Need to be 120% weightage, and lowest is zero if>4% return in VEG</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Sales Return</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>Return 0%</td><td>120</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 0% to 2%</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 2% to 3%</td><td>75</td>
										</tr>
										<tr>
											<td>100</td><td>Return between 3% to 4%</td><td>50</td>
										</tr>
										<tr>
											<td>100</td><td>Return more then >4%</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 8 (For Production)</b></h5>
								<p>Higher Achievment on higher Grades, higher the multiple factor</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Sub Logic</th>
											<th>Target</th>
											<th>Achievment</th>
											<th>Achivement Multiple Factor</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Logic 8a</td><td>100</td><td>=, < 100</td><td>115</td>
										</tr>
										<tr>
											<td>Logic 8b</td><td>100</td><td>=, < 100</td><td>100</td>
										</tr>
										<tr>
											<td>Logic 8c</td><td>100</td><td>=, < 100</td><td>70</td>
										</tr>
										<tr>
											<td>Logic 8d</td><td>100</td><td>=, < 100</td><td>-100</td>
										</tr>
										<tr>
											<td>Logic 8e</td><td>100</td><td>=, < 100</td><td>-100</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 9 (For Production)</b></h5>
								<p>Higher Achievment, higher the score till 90%,above 90% - 100%</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievment</th>
											<th>Achivement Multiple Factor</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td><90</td><td><90</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 10 (For Production)</b></h5>
								<p>More than 10% deviation, Score=Zero</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement (Deviation%)</th>
											<th>Score (Mutliple Factor)</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td><90%</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>90%</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>91-93%</td><td>105</td>
										</tr>
										<tr>
											<td>100</td><td>94-97%</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>98-100%</td><td>120</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 11 (Reverse Calculation)</b></h5>
								<p>Higher the Achievment, lower the score</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>111</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>91</td>
										</tr>
										
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 12</b></h5>
								<p>Higher the achievement, Max is 110, Below 90% achievement, Zero</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>100</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td><90</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>90</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>110</td><td>110</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<h5>(For External Vegetable Seed Production)</h5>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 13A Quantity: All Crops [Own Production]</b></h5>
								<p>Score Decreases with achievement deviation on both sides of target</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>,=130-121</td><td>70</td>
										</tr>
										<tr>
											<td>100</td><td>120-111</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td>110-91</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90-81</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td><,=80</td><td>80</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 13B Quantity: All Crops [Seed to Seed]</b></h5>
								<p>Score Decreases upto 70% with achievement deviation on both sides of target</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>140-131</td><td>70</td>
										</tr>
										<tr>
											<td>100</td><td>130-121</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td>120-81</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>80-71</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td><,=70</td><td>70</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 14A Germination: All OP Var, Hy Bhindi, Snake Gourd</b></h5>
								<p>Score decreases to Zero with <,= 75% achievement</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>,=91</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>90-86</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>85-81</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>80-76</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td><,=75</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 14B Germination: Remaining Crops & products</b></h5>
								<p>Score decreases to Zero with = 80 % achievement</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>,=96</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>95-91</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>90-86</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>85-81</td><td>60</td>
										</tr>
										<tr>
											<td>100</td><td><,=80</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 15A Genetic Purity: All OP</b></h5>
								<p>Score decreases to Zero below 95 % achievement</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>,=99</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td><99-98</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td><98-97</td><td>60</td>
										</tr>
										<tr>
											<td>100</td><td><97-96</td><td>50</td>
										</tr>
										<tr>
											<td>100</td><td><96-95</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 15B Genetic Purity: All Hy (except Hy Bhindi)</b></h5>
								<p>Score decreases to Zero below 97 % achievement</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>,=99.5(100)</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>99.5-99</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>99-98</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>98-97</td><td>70</td>
										</tr>
										<tr>
											<td>100</td><td><97</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 15C Genetic Purity: Hy Bhindi</b></h5>
								<p>Score decreases to Zero if < 96 % achievement</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>>,=99</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td><99-98</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td><98-97</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td><97-96</td><td>60</td>
										</tr>
										<tr>
											<td>100</td><td><96</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 16 Seed Cost: All Crops</b></h5>
								<p>Higher the achievement lower the score</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>111-115</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>106-110</td><td>95</td>
										</tr>
										<tr>
											<td>100</td><td>100-105</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>99-95</td><td>105</td>
										</tr>
										<tr>
											<td>100</td><td>94-90</td><td>110</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 17 Seed Delivery: All Crops</b></h5>
								<p>Higher the achievement numbers (DOD-HD), lower the score</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td><15</td><td>100</td>
										</tr>
										<tr>
											<td>100</td><td>16-22</td><td>90</td>
										</tr>
										<tr>
											<td>100</td><td>23-29</td><td>80</td>
										</tr>
										<tr>
											<td>100</td><td>30-36</td><td>75</td>
										</tr>
										<tr>
											<td>100</td><td>37-42</td><td>50</td>
										</tr>
										<tr>
											<td>100</td><td>>42</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 18 For Sales</b></h5>
								<p>Higher the achievement, higher the scoring as per given slabs</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>80-120</td><td>As achievement</td>
										</tr>
										<tr>
											<td>100</td><td>70-79</td><td>50</td>
										</tr>
										<tr>
											<td>100</td><td>60-69</td><td>25</td>
										</tr>
										<tr>
											<td>100</td><td>< 60</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 19 For Sales</b></h5>
								<p>Higher the achievement, max scored is 100</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th>Achievement</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>80-100</td><td>As achievement</td>
										</tr>
										<tr>
											<td>100</td><td>70-80</td><td>50</td>
										</tr>
										<tr>
											<td>100</td><td>< 70</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 20 For Finance</b></h5>
								<p>Delay & Accuracy Measurement: 0 or 110</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th colspan="2">Achievement <br>Enter Days Delayed (no.)  Enter Mistakes (%)</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>0</td><td>0</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>1</td><td>0</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>0</td><td>0</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>0</td><td>2</td><td>0</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 mb-4">
							<div class="card-header" style="background-color: #a5cccd;">
								<h5><b>Logic 21 For Finance</b></h5>
								<p>Delay & Accuracy Measurement: More will lead to zero Achivement</p>
							</div>
							<div class="card-body dd-flex align-items-center" style="border: 1px solid #eee;">
								<table class="table table-pad">
									<thead class="table-light">
										<tr>
											<th>Target</th>
											<th colspan="2">Achievement <br>Enter Days Delayed (no.)  Enter Mistakes (%)</th>
											<th>Score</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>100</td><td>0</td><td>1</td><td>70</td>
										</tr>
										<tr>
											<td>100</td><td>2</td><td>0.3</td><td>63</td>
										</tr>
										<tr>
											<td>100</td><td>4</td><td>0</td><td>0</td>
										</tr>
										<tr>
											<td>100</td><td>0</td><td>0</td><td>110</td>
										</tr>
										<tr>
											<td>100</td><td>1</td><td>0.1</td><td>81</td>
										</tr>
										<tr>
											<td>100</td><td>1</td><td>0</td><td>99</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
            <!--All end logics-->
                                
				</div>
				<div class="modal-footer">
					<a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
				</div>
			</div>
		</div>
    </div>
	   <!-- Revert KRA -->
	   <div class="modal fade show" id="resubmitKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" >Revert Note</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body appraisal-view">
               <div class="form-group mr-2" id="">
                  <label class="col-form-label">Revert Note</label>
                  <textarea id="revertNote" placeholder="Enter your revert note" class="form-control" ></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <a class="effect-btn btn btn-success squer-btn sm-btn" id="submitRevert">Send</a>
               <a class="effect-btn btn btn-light squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
            </div>
         </div>
      </div>
   </div>
   @endforeach
   @include('employee.footer')
   <script>
      $(document).ready(function() {
        // Assuming you have an array of ratings fetched from your Laravel controller and passed to JS
        const ratings = @json($ratings);  // The rating data you passed to JS from the controller
      
        // Event listener for changes in the editable input field
        $('.score-input').on('input', function() {
            let score = parseFloat($(this).val());
      let index = parseFloat($(this).data('employeeid')) || 0; // Get the target value from data attribute        
             console.log(index);
      // Find the rating based on the score
            let rating = getRatingForScore(score, ratings);
               $('#rating-input' + index).val(rating); // Update only the respective row's score cell
      
        });
        
        // Function to get the appropriate rating based on score
        function getRatingForScore(score, ratings) {
            // Loop through all the ratings and check if the score falls between the range
            for (let i = 0; i < ratings.length; i++) {
                if (score >= ratings[i].ScoreFrom && score <= ratings[i].ScoreTo) {
                    return ratings[i].Rating;
                }
            }
            return 'N/A';  // Default if no rating found
        }
      });
      $(document).ready(function () {
		$(".save-btn").on("click", function () {
			$('#loader').show();

			let employeeId = $(this).data("employeeid");
			let pmsid = $(this).data("pmsid");
			let companyid = $(this).data("companyid");

			let scoreInput = $(".score-input[data-employeeid='" + employeeId + "']");
			let originalScore = parseFloat(scoreInput.data("reviewerscore")); // Original score from data-reviewerscore
			let currentScore = parseFloat(scoreInput.val()); // Current entered score

			let rating = $("#rating-input" + employeeId).val();
			let remarksInput = $(".remarks-input[data-employeeid='" + employeeId + "']");
			let remarks = remarksInput.val().trim();

			// Check: if score changed AND remarks are empty
			if (originalScore !== currentScore && remarks === "") {
				remarksInput.css("border", "2px solid red");
				remarksInput.focus();
				$('#loader').hide();
				return;
			} else {
				remarksInput.css("border", ""); // Remove red border
			}

			// Proceed with AJAX if validation passes
			$.ajax({
				url: "/update-employee-score",
				type: "POST",
				data: {
					employeeId: employeeId,
					score: currentScore,
					rating: rating,
					remarks: remarks,
					pmsid: pmsid,
					companyid: companyid,
					_token: $('meta[name="csrf-token"]').attr("content")
				},
				success: function (response) {
					$('#loader').hide();
					toastr.success(response.message, 'Success', {
						"positionClass": "toast-top-right",
						"timeOut": 2000
					});
					scoreInput.prop('disabled', true);
					remarksInput.prop('disabled', true);
					$(".save-btn[data-employeeid='" + employeeId + "']").addClass('d-none');


				},
				error: function (xhr) {
					$('#loader').hide();
					let errorMessage = "An error occurred.";
					if (xhr.responseJSON && xhr.responseJSON.message) {
						errorMessage = xhr.responseJSON.message;
					}
					scoreInput.prop('disabled', false);
					remarksInput.prop('disabled', false);
					$(".save-btn[data-employeeid='" + employeeId + "']").removeClass('d-none');


					toastr.error(errorMessage, 'Error', {
						"positionClass": "toast-top-right",
						"timeOut": 2000
					});
				}
			});
		});

      });
//       $(document).ready(function () {
//         $(".score-input").on("input", function () {
//             let employeeId = $(this).data("employeeid");  
//             let enteredScore = parseFloat($(this).val()) || 0;  // Default to 0 if empty
//             let reviewerScore = parseFloat($(this).data("reviewerscore")) || 0;

//             console.log(reviewerScore);

//             let inputField = $(this);
      
//             let minAllowed = reviewerScore - 10;  
//             let maxAllowed = reviewerScore + 10;
      
//             // Find the error message block or create it
//             let errorBlock = $(this).closest("td").find(".error-message");
// 			let saveBtn = $('.save-btn[data-employeeid="' + employeeId + '"]');

//             if (enteredScore < minAllowed || enteredScore > maxAllowed) {
//                 // Show error message if not already present
//                 if (errorBlock.length === 0) {
// 					saveBtn.addClass('disabled').css('pointer-events', 'none').css('opacity', '0.5');

//                     $(this).closest("td").append('<div class="error-message text-danger">Score must be within ±10 of Reviewer Score! Resetting to 0.00.</div>');
//                 }
           
//             } else {
//                 errorBlock.remove(); // Remove the error if within range
// 				saveBtn.removeClass('disabled').css('pointer-events', '').css('opacity', '');

//             }
//         });
//       });
     
     
      function showEmployeeDetails(employeeId) {
             var companyId = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-companyid');
             var PmsYId = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-PmsYId');
             var mangid = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-mangid');
          
                     $.ajax({
						url: '/employee/details/' + employeeId + '/' + PmsYId + '/' + mangid,
						method: 'GET',
                         success: function(response) {
                             console.log(response);
          
                             if (response.error) {
                                 alert(response.error);
                                 return;
                             }
              				var awsS3BaseUrl = "{{ env('AWS_URL') }}";

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
          
                   if (response.trainings.length > 0) {
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
          
                   if (response.conferences.length > 0) {
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

        rows.forEach((row, index) => {
            row.cells[0].innerText = index + 1; // 🔁 Update SN column
            table.appendChild(row); // 🔄 Reorder the rows
        });
    });
});
$(document).ready(function () {
    function filterTable() {
        var department = $('#department-filter').val().toLowerCase();
        var grade = $('#grade-filter').val().toLowerCase();
        var region = $('#region-filter').val().toLowerCase();
        var zone = $('#Zone-filter').val().toLowerCase();
        var bu = $('#BU-filter').val().toLowerCase();

        var visibleIndex = 1; // Counter for S. No.

        $('#employeetablemang tbody tr').each(function () {
            var rowDepartment = $(this).find('td:nth-child(4)').text().toLowerCase();
            var rowGrade = $(this).find('td:nth-child(5)').text().toLowerCase();
            var rowRegion = $(this).find('td:nth-child(7)').text().toLowerCase();
            var rowZone = $(this).find('td:nth-child(19)').text().toLowerCase();
            var rowBU = $(this).find('td:nth-child(20)').text().toLowerCase();

            if ((department === "" || rowDepartment === department) &&
                (grade === "" || rowGrade === grade) &&
                (region === "" || rowRegion === region) &&
                (zone === "" || rowZone === zone) &&
                (bu === "" || rowBU === bu)
            ) {
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


        var baseUrl = "{!! route('score.export', ['employee_id' => Auth::user()->EmployeeID,'pms_year_id' => $PmsYId]) !!}";
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
            $('#region-filter').val('');
            $('#Zone-filter').hide();
            $('#BU-filter').hide();
            $('#Zone-filter').val('');
            $('#BU-filter').val('');
        }
        filterTable();
    });

    // Filter when these filters change
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
            }
        });
    });

    // Hide region filter initially (you can adjust this as needed)
    $('#region-filter').hide();

    // Initial filter call
    filterTable();
});

//old code

    // $(document).ready(function () {
	// 	function filterTable() {
	// 		var department = $('#department-filter').val().toLowerCase();
	// 		// var state = $('#state-filter').val().toLowerCase();
	// 		var grade = $('#grade-filter').val().toLowerCase();
	// 		var region = $('#region-filter').val().toLowerCase();
	// 		var zone = $('#Zone-filter').val().toLowerCase();
	// 		var bu = $('#BU-filter').val().toLowerCase();
	// 		console.log(region);


	// 		var visibleIndex = 1; // Counter for S. No.

	// 		$('#employeetablemang tbody tr').each(function () {
	// 			var rowDepartment = $(this).find('td:nth-child(4)').text().toLowerCase();
	// 			var rowState = $(this).find('td:nth-child(6)').text().toLowerCase();
	// 			var rowGrade = $(this).find('td:nth-child(5)').text().toLowerCase();
	// 			var rowRegion = $(this).find('td:nth-child(7)').text().toLowerCase();
	// 			var rowZone = $(this).find('td:nth-child(19)').text().toLowerCase();
	// 			var rowBU = $(this).find('td:nth-child(20)').text().toLowerCase();


	// 			if ((department === "" || rowDepartment === department) &&
	// 				(grade === "" || rowGrade === grade) &&
	// 				(region === "" || rowRegion === region)&&
	// 				(zone === "" || rowZone === zone) &&
	// 				(bu === "" || rowBU === bu)
	// 			) {
	// 				$(this).show();
	// 				$(this).find('td:nth-child(1)').text(visibleIndex); // Update S. No.
	// 				visibleIndex++;
	// 			} else {
	// 				$(this).hide();
	// 			}
	// 		});
	// 	}
	// 	function updateExportLink() {
	// 		var department = $('#department-filter').val();
	// 		// var state = $('#state-filter').val();
	// 		var grade = $('#grade-filter').val();
	// 		var region = $('#region-filter').val();
	// 		console.log(department);

	// 		var baseUrl = "{!! route('score.export', ['employee_id' => Auth::user()->EmployeeID,'pms_year_id' => $PmsYId]) !!}";
	// 		var exportUrl = baseUrl +
	// 			'&department=' + encodeURIComponent(department) +
	// 			// '&state=' + encodeURIComponent(state) +
	// 			'&grade=' + encodeURIComponent(grade) +
	// 			'&region=' + encodeURIComponent(region);
	// 			console.log(exportUrl);
	// 		$('#export-link').attr('href', exportUrl);
	// 	}
	// 	// Show/hide the region filter based on department selection
	// 	$('#department-filter').change(function () {
	// 		var selectedDepartment = $(this).val();
	// 		if (selectedDepartment === "Sales") {
	// 			$('#region-filter').show();
	// 			$('#Zone-filter').show();
	// 			$('#BU-filter').show();

	// 		} else {
	// 			$('#region-filter').hide(); 
	// 			$('#region-filter').val('');
	// 			$('#Zone-filter').show();
	// 			$('#BU-filter').show(); 
	// 			$('#Zone-filter').val('');
	// 			$('#BU-filter').val('');
	// 		}
	// 		filterTable();
	// 	});

	// 	// Trigger filtering when any dropdown changes
	// 	$('#department-filter, #grade-filter, #region-filter,#Zone-filter,#BU-filter').change(function () {
	// 		filterTable();
	// 		updateExportLink();

	// 	});
	// 	$('#BU-filter').on('change', function () {
	// 		let buId = $(this).val();

	// 		// Reset zone and region values before loading new ones
	// 		$('#Zone-filter').html('<option value="">Select Zone</option>').val('');
	// 		$('#region-filter').html('<option value="">Select Region</option>').val('');

	// 		if (buId) {
	// 			$.ajax({
	// 				url: '{{ route("get_zone_by_bu") }}',
	// 				type: 'GET',
	// 				data: { bu: buId },
	// 				success: function (data) {
	// 					$('#Zone-filter').empty().append('<option value="">Select Zone</option>');
	// 					$.each(data.zoneList, function (index, zone) {
	// 						$('#Zone-filter').append('<option value="' + zone.zone_id + '">' + zone.zone_name + '</option>');
	// 					});

	// 					// Optional: if you want to auto-filter when zones are loaded
	// 					filterTable();
	// 				}
	// 			});
	// 		} else {
	// 			$('#Zone-filter').html('<option value="">Select Zone</option>');
	// 		}

	// 	});

	// 	$('#Zone-filter').on('change', function () {
	// 		let zoneId = $(this).val();
	// 		$('#region-filter').html('<option value="">Loading...</option>').val('');

	// 		if (zoneId) {
	// 			$.ajax({
	// 				url: '{{ route("get_region_by_zone") }}',
	// 				type: 'GET',
	// 				data: { zone: zoneId },
	// 				success: function (data) {
	// 					$('#region-filter').empty().append('<option value="">Select Region</option>');
	// 					$.each(data.regionList, function (index, region) {
	// 						$('#region-filter').append('<option value="' + region.region_name + '">' + region.region_name + '</option>');
	// 					});

	// 					filterTable(); // Filter after loading regions
	// 				}
	// 			});
	// 		} else {
	// 			$('#region-filter').html('<option value="">Select Region</option>');
	// 		}

	// 	});

   	//  	// Hide region filter initially
    //      $('#region-dropdown').hide();

    //      // Initial filter application
    //      filterTable();
    // });

		document.addEventListener("DOMContentLoaded", function () {
			document.querySelectorAll('.edit-score').forEach(editBtn => {
				editBtn.addEventListener('click', function (e) {
					e.preventDefault();
					
					let employeeId = this.getAttribute("data-employeeid");

					let saveBtn = document.querySelector(`.save-btn[data-employeeid='${employeeId}']`);
					let scoreInput = document.querySelector(`input[data-employeeid='${employeeId}'][name='score']`);
					let remarkInput = document.querySelector(`input[data-employeeid='${employeeId}'][name='remark']`);

					if (scoreInput) {
						scoreInput.removeAttribute("readonly");
						scoreInput.removeAttribute("disabled");
						scoreInput.classList.remove("no-border");
					}

					if (remarkInput) {
						remarkInput.removeAttribute("readonly");
						remarkInput.removeAttribute("disabled");
						remarkInput.classList.remove("no-border");
					}

					if (saveBtn) {
						saveBtn.style.display = "inline-block";
						saveBtn.classList.remove("d-none");  
					}
				});
			});
		});

		function inpNum(e) {
		e = e || window.event;
		let input = e.target;
		let char = String.fromCharCode(e.which || e.keyCode);

		// Allow control keys (like backspace)
		if (e.keyCode === 8 || e.keyCode === 46 || e.keyCode === 37 || e.keyCode === 39) return;

		// Allow digits and only one decimal point
		if (!char.match(/[0-9.]/)) {
			e.preventDefault();
		} else if (char === '.' && input.value.includes('.')) {
			e.preventDefault(); // prevent second decimal
		}
		}

		document.addEventListener("DOMContentLoaded", function () {
			let revertModal = document.getElementById("resubmitKRA");

			revertModal.addEventListener("show.bs.modal", function (event) {
				let button = event.relatedTarget; // Button that triggered the modal
				let empPmsId = button.getAttribute("data-emppmsid");

				// Store the EmpPmsId in the send button for later use
				document.getElementById("submitRevert").setAttribute("data-emppmsid", empPmsId);
			});

			document.getElementById("submitRevert").addEventListener("click", function () {
				$('#loader').show(); // Show loader

				let revertNote = document.getElementById("revertNote").value;
				let empPmsId = this.getAttribute("data-emppmsid");

				if (revertNote.trim() === "") {
					alert("Please enter a revert note before submitting.");
					$('#loader').hide();
					return;
				}

				fetch("/revert-pms-mang", {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						"X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
					},
					body: JSON.stringify({
						empPmsId: empPmsId,
						revertNote: revertNote
					})
				})
				.then(response => response.json())
				.then(data => {
					$('#loader').hide(); // Hide loader after request completion

					if (data.error) {
						// Display error toast
						toastr.error(data.error, 'Error', {
							"positionClass": "toast-top-right",
							"timeOut": 3000
						});
					} else {
						// Display success toast
						toastr.success(data.message, 'Success', {
							"positionClass": "toast-top-right",
							"timeOut": 3000
						});

						// Reload the page after a short delay
						setTimeout(function() {
							location.reload();
						}, 3000);
					}
				})
				.catch(error => {
					$('#loader').hide();

					let errorMessage = "An error occurred.";
					if (error.response && error.response.data && error.response.data.message) {
						errorMessage = error.response.data.message;
					}

					toastr.error(errorMessage, 'Error', {
						"positionClass": "toast-top-right",
						"timeOut": 5000
					});

					// Re-enable the button in case of error
					document.getElementById("submitRevert").disabled = false;
				});
			});
		});
		function OpenViewWindow(encryptedEmpPmsId) {
				let url = `/view-reviewer/${encryptedEmpPmsId}`;
					window.open(url, '_blank', 'width=1350,height=600,scrollbars=yes');
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
			.no-border {
					border: none !important;
					background-color: transparent; /* Optional: looks cleaner */
				}