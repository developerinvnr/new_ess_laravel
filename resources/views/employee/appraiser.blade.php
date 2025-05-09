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
                  @if($exists_appraisel || $exists_appraisel_pms)
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{ route('appraiser') }}"
                        role="tab" aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">Appraiser</span>
                     </a>
                  </li>
                  @endif
                  @if($exists_reviewer || $exists_reviewer_pms)
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('reviewer') }}"
                        role="tab" aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">Reviewer</span>
                     </a>
                  </li>
                  @endif
                  @if($exists_hod || $exists_hod_pms)
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('hod') }}" role="tab"
                        aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">HOD</span>
                     </a>
                  </li>
                  @endif
                  @if($exists_mngmt || $exists_mngmt_pms)
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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-1">
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
                     @php
                        $appraiserPmsStatus3 = DB::table('hrm_employee_pms')
                            ->where('Appraiser_EmployeeID', Auth::user()->EmployeeID)
                            ->where('AssessmentYear', $PmsYId)
                            ->where('CompanyId', Auth::user()->CompanyId)
                            ->where('Appraiser_PmsStatus', 3)
                            ->exists();
                        $appraiserPmsStatus1 = DB::table('hrm_employee_pms')
                            ->where('Appraiser_EmployeeID', Auth::user()->EmployeeID)
                            ->where('AssessmentYear', $PmsYId)
                            ->where('CompanyId', Auth::user()->CompanyId)
                            ->where('Appraiser_PmsStatus', 1)
                            ->exists();
                    @endphp
                     @if ($data['emp']['Appform'] == 'Y' || $pms_id->ExtraAllowPMS == 1)
                     <li class="nav-item">
                            <a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
                        </li>
                    @endif

                    <!-- @if (($rowChe > 0) ||($rowCh > 0)||
                        (isset($appraisal_schedule) && $CuDate >= $appraisal_schedule->AppFromDate && 
                        $CuDate <= $appraisal_schedule->AppToDate && $appraisal_schedule->AppDateStatus == 'A') ||
                        ($rowCh > 0 && isset($appraisal_schedule) 
                        && $appraisal_schedule->AppDateStatus == 'A' 
                        && $pms_id->Emp_PmsStatus == 1 && 
                        $pms_id->Appraiser_PmsStatus == 3) ||
                        (isset($appraisal_schedule) && 

                        $CuDate >= $appraisal_schedule->RevFromDate && 
                        $CuDate <= $appraisal_schedule->RevToDate &&
                        $appraisal_schedule->RevDateStatus == 'A' &&
                        $pms_id->Emp_PmsStatus == 1 && 
                        
                        $pms_id->Appraiser_PmsStatus == 3 && 
                        $pms_id->Reviewer_PmsStatus == 3) ||
                        (isset($appraisal_schedule) && 
                        $CuDate >= $appraisal_schedule->HodFromDate &&
                        $CuDate <= $appraisal_schedule->HodToDate &&
                        $appraisal_schedule->HodDateStatus == 'A' &&
                        $pms_id->Emp_PmsStatus == 1 && 
                        $pms_id->Appraiser_PmsStatus == 3 && 
                        $pms_id->Reviewer_PmsStatus == 3 &&
                        $pms_id->HodSubmit_ScoreStatus == 3) ||
                        $appraiserPmsStatus1 ||
                        ($pms_id->ExtraAllowPMS == 1)||($appraiserPmsStatus3)
                    ) -->
                        
                    <!-- @endif -->

                     
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
                                             ->where('YearId',$KraYIdCurr)
                                             ->where('KRAProcessOwner', 'Appraiser')
                                             ->orderBy('KRASche_DateFrom', 'ASC')
                                             ->first();
                                             // Get the current date using Carbon
                                             $currentDate = \Carbon\Carbon::now();
                                             // Initialize the variable
                                             $isWithinDateRange = false; // Default value
                                             // If we have a result, check the conditions
                                             if ($kra_schedule_data_employee) {
                                             // Convert KRASche_DateFrom and KRASche_DateTo to Carbon instances for comparison
                                             $dateFrom = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateFrom);
                                             $dateTo = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateTo);
                                             // Check if current date is between KRASche_DateFrom and KRASche_DateTo
                                             $isWithinDateRange = $currentDate->between($dateFrom, $dateTo);
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
                                                   data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $KraYId }}" 
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
                                                   data-krayid="{{ $KraYId }}" 
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
                                                   data-krayid="{{ $KraYId }}" 
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
                                             // Get the current date using Carbon
                                             $currentDate = \Carbon\Carbon::now();
                                             // Initialize the variable
                                             $isWithinDateRange = false; // Default value
                                             // If we have a result, check the conditions
                                             if ($kra_schedule_data_employee) {
                                             // Convert KRASche_DateFrom and KRASche_DateTo to Carbon instances for comparison
                                             $dateFrom = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateFrom);
                                             $dateTo = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateTo);
                                             // Check if current date is between KRASche_DateFrom and KRASche_DateTo
                                             $isWithinDateRange = $currentDate->between($dateFrom, $dateTo);
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
                                    <div style="float:left;margin-top:-36px;margin-left:295px;">
                                       <a class="rating-graph"><b>Rating Graph <i class="fas fa-chart-bar mr-1 ml-2"></i></b></a>
                                       <a class="float-end ml-2" data-bs-toggle="modal" data-bs-target="#pmshelpvideo" ><b>Help Video</b></a>
                                       
                                    </div>	
                                    <div class="float-end" style="margin-top:-50px;">
                                       <!-- Department Dropdown -->
                                       <select id="department-filter">
                                          <option value="">Select Department</option>
                                          @foreach($employeedetailsforpms->unique('department_name') as $employee)
                                          <option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
                                          @endforeach
                                       </select>
                                       <select id="state-filter">
                                          <option value="">Select State</option>
                                          @foreach($employeedetailsforpms->unique('state_name') as $employee)
                                          <option value="{{ $employee->state_name }}">{{ $employee->state_name }}</option>
                                          @endforeach
                                       </select>
                                       <select id="hq-filter">
                                          <option value="">Select Head Quarter</option>
                                          @foreach($employeedetailsforpms->unique('city_village_name') as $employee)
                                          <option value="{{ $employee->city_village_name }}">{{ $employee->city_village_name }}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                                 @if (isset($kraDatalastrevertpms))

                                    @if ($kraDatalastrevertpms->Reviewer_PmsStatus == '3')
                                            <span class="float-end blinking-text" style="margin-left: 10px;" title="{{ $kraDatalastrevertpms->Rev_Reason }}" data-bs-tooltip="{{ $kraDatalastrevertpms->Rev_Reason }}">
                                                <strong style="color: #4d5bff; font-size:14px;">Your KRA has been reverted</strong>
                                            </span>
                                        @else

                                    @endif
                                    @endif

                                    <div>
                                        <b class="text-danger" style="float: right; margin-top: 10px; margin-right: 23px;">
                                            Appraisal filling period: {{ \Carbon\Carbon::parse($appraisal_schedule->AppFromDate)->format('d-m-y') }}
                                            to {{ \Carbon\Carbon::parse($appraisal_schedule->AppToDate)->format('d-m-y') }}
                                        </b>
                                    </div>



                                 <div class="card-body table-responsive dd-flex align-items-center team-appraisalbox">
                                 
                                     <table id="employeetable" class="table table-pad">
                                       <thead>
                                          <tr>
                                             <th rowspan="2">SN.</th>
                                             <th rowspan="2">EC</th>
                                             <th rowspan="2">Name</th>
                                             <th rowspan="2">Department</th>
                                             <th rowspan="2">Designation</th>
                                             <th rowspan="2">State</th>
                                             <th rowspan="2">HQ</th>
                                             <th class="text-center" colspan="2" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
                                             <th class="text-center" colspan="2" style="border-right: 1px solid #fff;">Appraiser</th>
                                             <th rowspan="2" class="text-center">Uploaded</th>
                                             @if($data['app']['EHform'] == 'Y')
                                             <th rowspan="2" class="text-center">History</th>
                                             @else
                                             @endif
                                             <th rowspan="2" class="text-center">Action</th>
                                             <th rowspan="2" class="text-center">Reverted Note</th>
                                          </tr>
                                          <tr>
                                             <th class="text-center" style="border-left: 1px solid #fff;">Status</th>
                                             <th class="text-center" style="border-right: 1px solid #fff;">Rating</th>
                                             <th class="text-center">Status</th>
                                             <th class="text-center" style="border-right: 1px solid #fff;">Rating</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          @foreach ($employeedetailsforpms as $index => $employeepms)
                                          <tr>
                                             @php
                                             $uploadfiles = DB::table('hrm_employee_pms_uploadfile')
                                             ->where('EmpPmsId', $employeepms->EmpPmsId)
                                             ->where('EmployeeID', $employeepms->EmployeeID)
                                             ->where('YearId', $PmsYId)
                                             ->get();
                                             @endphp
                                             <td><b>{{ $index + 1 }}.</b></td>
                                             <td>{{ $employeepms->EmpCode }}</td>
                                             <td>{{ $employeepms->Fname }} {{ $employeepms->Sname }} {{ $employeepms->Lname }}</td>
                                             <td>{{ $employeepms->department_name }}</td>
                                             <td>{{ $employeepms->designation_name }}</td>
                                             <td>{{ $employeepms->state_name }}</td>
                                             <td>{{ $employeepms->city_village_name }}</td>
                                             {{-- Employee PMS Status --}}
                                             <td class="text-center">
                                                @php
                                                // Define the status and class based on EmpStatus
                                                $empStatusClass = '';
                                                $empStatusText = '';
                                                // Check the EmpStatus and set appropriate class and text
                                                switch ($employeepms->Emp_PmsStatus) {
                                                case '2': // Submitted
                                                $empStatusClass = 'success';
                                                $empStatusText = '<i class="fas fa-check-circle text-success" title="Submitted"></i>';
                                                break;
                                                case '0': // Draft
                                                $empStatusClass = 'primary';
                                                $empStatusText = '<i class="ri-file-forbid-line text-danger" title="Draft"></i>';
                                                break;
                                                case '1': // Pending
                                                $empStatusClass = 'warning';
                                                $empStatusText = '<i class="fas fa-hourglass-half text-warning" title="Pending"></i>';
                                                break;
                                                case '3': // Reverted
                                                $empStatusClass = 'danger';
                                                $empStatusText = '<i class="fas fa-undo text-danger" title="Reverted"></i>';
                                                break;
                                                default:
                                                $empStatusClass = 'secondary';
                                                $empStatusText = '<i class="fas fa-question-circle text-secondary" title="Unknown Status"></i>';
                                                break;
                                                }
                                                @endphp
                                                <span class="{{ $empStatusClass }}" style="text-align:center;"><b>{!! $empStatusText !!}</b></span>
                                             </td>
                                             <td class="text-center">
                                                {{ 
                                                    fmod($employeepms->Emp_TotalFinalRating, 1) == 0 
                                                        ? number_format($employeepms->Emp_TotalFinalRating, 0) 
                                                        : rtrim(rtrim(number_format($employeepms->Emp_TotalFinalRating, 2, '.', ''), '0'), '.')
                                                }}
                                            </td>

                                             {{-- Appraiser PMS Status --}}
                                             <td class="text-center">
                                                @php
                                                // Define the status and class based on EmpStatus
                                                $appStatusClass = '';
                                                $appStatusText = '';
                                                // Check the EmpStatus and set appropriate class and text
                                                switch ($employeepms->Appraiser_PmsStatus) {
                                                case '2': // Submitted
                                                $appStatusClass = 'success';
                                                $appStatusText = '<i class="fas fa-check-circle text-success" title="Submitted"></i>';
                                                break;
                                                case '0': // Draft
                                                $appStatusClass = 'primary';
                                                $appStatusText = '<i class="ri-file-forbid-line text-danger" title="Draft"></i>';
                                                break;
                                                case '1': // Pending
                                                $appStatusClass = 'warning';
                                                $appStatusText = '<i class="fas fa-hourglass-half text-warning" title="Pending"></i>';
                                                break;
                                                case '3': // Reverted
                                                $appStatusClass = 'danger';
                                                $appStatusText = '<i class="fas fa-undo text-danger" title="Reverted"></i>';
                                                break;
                                                default:
                                                $appStatusClass = 'secondary';
                                                $appStatusText = '<i class="fas fa-question-circle text-secondary" title="Unknown Status"></i>';
                                                break;
                                                }
                                                @endphp
                                                <span class="{{ $appStatusClass }}"><b>{!! $appStatusText !!}</b></span>
                                                </td>
                                                <td class="text-center">
                                                    {{ 
                                                        fmod($employeepms->Appraiser_TotalFinalRating, 1) == 0 
                                                            ? number_format($employeepms->Appraiser_TotalFinalRating, 0) 
                                                            : rtrim(rtrim(number_format($employeepms->Appraiser_TotalFinalRating, 2, '.', ''), '0'), '.')
                                                    }}
                                                </td>

                                             {{-- Uploaded Status Icon --}}
                                             <td class="text-center">
                                                @if (!empty($uploadfiles) && $uploadfiles->count() > 0)  
                                                <a href="javascript:void(0)" onclick="showUploadedFiles({{ $employeepms->EmpPmsId }})">
                                                <i class="fas fa-file-upload text-success"></i>  {{-- Normal Upload Icon when files exist --}}
                                                </a>
                                                @else
                                                <span>
                                                <i class="fas fa-ban text-danger"></i>
                                                </span>
                                                @endif
                                             </td>
                                             @if($data['app']['EHform'] == 'Y')
                                                <td class="text-center"><a title="History" data-bs-toggle="modal" onclick="showEmployeeDetails({{ $employeepms->EmployeeID }})" 
                                                data-companyid="{{ $employeepms->CompanyId }}" data-PmsYId="{{ $PmsYId }}" data-mangid="{{ Auth::user()->EmployeeID }}" ><i class="fas fa-eye"></i></a></td>
                                            @else
                                            @endif
                                             {{-- Actions: View, Edit, Revert --}}
                                             <td class="text-center">
                                                <a title="View" data-bs-toggle="modal" onclick="OpenViewWindow('{{ encrypt($employeepms->EmpPmsId) }}')">
                                                <i class="fas fa-eye"></i>
                                                </a>
                                                @if($employeepms && $employeepms->Emp_PmsStatus == '2' && $employeepms->Appraiser_PmsStatus != '2')
                                                |
                                                <a href="javascript:void(0);" onclick="OpenEditWindow('{{ encrypt($employeepms->EmpPmsId) }}')">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                                |
                                                <a title="Revert" data-bs-toggle="modal" 
                                                   data-emppmsid="{{ $employeepms->EmpPmsId }}" data-bs-target="#resubmitKRA"> <i class="fas fa-retweet"></i></a>
                                             </td>
                                             @else
                                             @endif
                                             </td>
                                             @if($employeepms->Appraiser_PmsStatus == '3')
                                             <td>{{$employeepms->Rev_Reason}}</td>
                                             @else
                                             <td>-</td>
                                             @endif
                                          </tr>
                                          @endforeach
                                       </tbody>                                    
                                    </table>
                                    <div style="width:100%;text-align:right;font-size:12px;">
                                        <strong class="me-3">Status Legend:</strong>
                                        <span class="text-success me-3"><i class="fas fa-check-circle"></i> Submitted</span>
                                        <span class="text-warning me-3"><i class="fas fa-hourglass-half"></i> Pending</span>
                                        <span class="text-danger me-3"><i class="ri-file-forbid-line"></i> Draft</span>
                                        <span class="text-danger me-3"><i class="fas fa-undo"></i> Reverted</span>
                                        <span class="text-secondary"><i class="fas fa-question-circle"></i> Unknown</span>
                                    </div>
                                 </div>
                                 <div class="card-body table-responsive rating-graphshow" style="display:none;">
                                    <table class="table table-bordered">
                                       <thead>
                                          <tr>
                                             <th colspan="{{ count($ratings) + 1 }}"><b>Total Employees: {{ $totalemployee }}</b></th>
                                          </tr>
                                          <tr>
                                             <th>Rating</th>
                                             @foreach($ratings as $rating)
                                             <th>{{ number_format($rating, 1) }}</th>
                                             {{-- Ensure 1 decimal format --}}
                                             @endforeach
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td><b>Appraised</b></td>
                                             @foreach($ratings as $rating)
                                             <td>{{ $ratingDataEmployee[number_format($rating, 1)] ?? 0 }}</td>
                                             @endforeach
                                          </tr>
                                          <tr>
                                             <td><b>Appraiser</b></td>
                                             @foreach($ratings as $rating)
                                             <td>{{ $ratingData[number_format($rating, 1)] ?? 0 }}</td>
                                             @endforeach
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- Graph Section -->
                                    <h3>Appraiser PMS Rating Graph</h3>
                                    <canvas id="appraiserChart" width="600" height="400"></canvas>
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
               <h5 class="modal-title" id="employeenameview"><b>Kishan Kumar</b><br>
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
   <!--view history Modal-->
   <div class="modal fade" id="viewHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title me-2" style="font-size:13px;">
                  <img src="./images/user.jpg"><br>
                  EC: <span>Loading...</span>
               </h5>
               <table class="table mb-0">
                  <tr>
                     <td colspan="3"><b><span>Loading...</span></b></td>
                     <td colspan=""><b>DOJ: <span id="employeeDOJ">Loading...</span></b></td>
                  </tr>
                  <tr>
                     <td><b>Designation:</b></td>
                     <td style="color:#DC7937;"><b><span id="employeeDesignation">Loading...</span></b></td>
                     <td><b>Function:</b></td>
                     <td style="color:#DC7937;"><b><span id="employeeFunction">Loading...</span></b></td>
                  </tr>
                  <tr>
                     <td><b>VNR Exp.</b></td>
                     <td style="color:#DC7937;"><b><span id="employeeVNRExp">Loading...</span></b></td>
                     <td><b>Prev. Exp.</b></td>
                     <td style="color:#DC7937;"><b><span id="employeePrevExp">Loading...</span></b></td>
                  </tr>
               </table>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body table-responsive">
               <!-- Career Progression -->
               <div class="card">
                  <div class="card-header">
                     <h5><b>Career Progression in VNR</b></h5>
                  </div>
                  <div class="card-body">
                     <table class="table table-pad">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th>Date</th>
                              <th>Designation</th>
                              <th>Grade</th>
                              <th>Monthly Gross</th>
                              <th>CTC</th>
                              <th>Rating</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td colspan="7" class="text-center">No data available</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <h5><b>Previous Employers</b></h5>
                  </div>
                  <div class="card-body">
                     <table class="table table-pad" id="previousEmployersTable">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th>Company</th>
                              <th>Designation</th>
                              <th>From Date</th>
                              <th>To Date</th>
                              <th>Duration</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td colspan="6" class="text-center">No data available</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <!-- Developmental Progress -->
               <div class="card">
                  <div class="card-header">
                     <h5 class="float-start"><b>Developmental Progress</b></h5>
                  </div>
                  <div class="card-body table-responsive align-items-center">
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
                        <tbody >
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
                        <tbody>
                           <tr>
                              <td colspan="6" class="text-center">Loading...</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!--All achivement and feedback view -->
   <!--<div class="modal fade show" id="viewappraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="splash-Accordion4">
                  <div class="accordion card" id="accordionExample">
                     <div class="item">
                        <div class="item-header card-header" id="headingOnej">
                           <h5 class="mb-0">
                              Achievements
                              <button class="btn btn-link float-end" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOnej" aria-expanded="true" aria-controls="collapseOnej">
                              <i class="fa fa-angle-down"></i>
                              </button>
                           </h5>
                        </div>
                        <div id="collapseOnej" class="collapse show card-body" aria-labelledby="headingOnej" data-bs-parent="#accordionExample">
                           <ol>
                              <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                              <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                              <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                              <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                           </ol>
                        </div>
                     </div>
                     <div class="item">
                        <div class="item-header card-header" id="headingTwok">
                           <h5 class="mb-0">
                              Feedback
                              <button class="btn btn-link collapsed float-end" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwok" aria-expanded="false" aria-controls="collapseTwok">
                              <i class="fa fa-angle-down"></i>
                              </button>
                           </h5>
                        </div>
                        <div id="collapseTwok" class="collapse show card-body" aria-labelledby="headingTwok" data-bs-parent="#accordionExample">
                           <ul>
                              <li>1. What is your feedback regarding the existing & new processes that are being followed or needs to be followed in your respective functions?</li>
                              <li><b>Ans.</b> test 123456</li>
                              <li>&nbsp;</li>
                              <li>2. At work, are there any factors that hinder your growth?</li>
                              <li><b>Ans.</b> test 123456</li>
                              <li>&nbsp;</li>
                              <li>3. At work, what are the factors that facilitate your growth?</li>
                              <li><b>Ans.</b> test 123456</li>
                              <li>&nbsp;</li>
                              <li>4. What support you need from the superiors to facilitate your performance?</li>
                              <li><b>Ans.</b> test 123456</li>
                              <li>&nbsp;</li>
                              <li>5. Any other feedback.</li>
                              <li><b>Ans.</b> test 123456</li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center p-0">
                     <table class="table table-pad ">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th style="width:215px;">KRA/Goals</th>
                              <th style="width:300px;">Description</th>
                              <th>Measure</th>
                              <th>Unit</th>
                              <th>Weightage</th>
                              <th>Logic</th>
                              <th>Period</th>
                              <th>Target</th>
                              <th>Emp Rating</th>
                              <th style="width:215px;">Emp Remarks</th>
                              <th>Appraisar Rating</th>
                              <th>Appraiser Score</th>
                              <th>Appraiser Remarks</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1.</b></td>
                              <td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                              <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                           </tr>
                           <tr>
                              <td><b>2.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                              <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                           </tr>
                           <tr>
                              <td><b>3.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                              <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                           </tr>
                           <tr>
                              <td><b>4.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                              <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                           </tr>
                           <tr>
                              <td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                              <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                           </tr>
                           <tr>
                              <td colspan="15">
                                 <table class="table" Style="background-color:#ECECEC;">
                                    <thead >
                                       <tr>
                                          <th>SN.</th>
                                          <th style="width:215px;">Sub KRA/Goals</th>
                                          <th style="width:300px;">Description</th>
                                          <th>Measure</th>
                                          <th>Unit</th>
                                          <th>Weightage</th>
                                          <th>Logic</th>
                                          <th>Period</th>
                                          <th>Target</th>
                                          <th>Emp Rating</th>
                                          <th style="width:215px;">Emp Remarks</th>
                                          <th>Appraiser Rating</th>
                                          <th >Appraiser Score</th>
                                          <th>Appraiser Remarks</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td><b>1.</b></td>
                                          <td>test </td>
                                          <td>twst</td>
                                          <td>Process</td>
                                          <td>Days</td>
                                          <td>25</td>
                                          <td>Logic 01</td>
                                          <td>Quarterly</td>
                                          <td>100</td>
                                          <td>85</td>
                                          <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                                          <td>67</td>
                                          <td>20.1</td>
                                          <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                       </tr>
                                       <tr>
                                          <td><b>2.</b></td>
                                          <td>test </td>
                                          <td>twst</td>
                                          <td>Process</td>
                                          <td>Days</td>
                                          <td>25</td>
                                          <td>Logic 01</td>
                                          <td>Quarterly</td>
                                          <td>100</td>
                                          <td>85</td>
                                          <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                                          <td>67</td>
                                          <td>20.1</td>
                                          <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Form - B (Skills)</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center p-0">
                     <table class="table table-pad ">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th style="width:215px;">Skill</th>
                              <th style="width:300px;">Skill Comment</th>
                              <th>Weightage</th>
                              <th>Logic</th>
                              <th>Period</th>
                              <th>Target</th>
                              <th>Emp Ass.</th>
                              <th style="width:215px;">Emp Remarks</th>
                              <th>Appraisar Ass.</th>
                              <th>Appraiser Score</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1.</b></td>
                              <td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>2.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>3.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>4.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>5.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td>67</td>
                              <td>20.1</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>PMS Score</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center ">
                     <table class="table" style="background-color:#ECECEC;">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th>KRA form</th>
                              <th>% Weightage</th>
                              <th>(A) KRA Score</th>
                              <th>Behavioral form</th>
                              <th>% Weightage</th>
                              <th>(B) Behavioral score</th>
                              <th>(A + B) PMS Score</th>
                              <th>Rating</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>Employee</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                           </tr>
                           <tr>
                              <td>Appraiser</td>
                              <td></td>
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
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Designation Upgrade</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <table class="table">
                        <thead>
                           <tr>
                              <th></th>
                              <th>Grade</th>
                              <th>Designation</th>
                              <th>Description</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>Current</b></td>
                              <td><b>J4.</b></td>
                              <td><b>Business manager</b></td>
                              <td><b>-</b></td>
                           </tr>
                           <tr>
                              <td><b>Appraiser</b></td>
                              <td><b>J4.</b></td>
                              <td><b>Zonal Manager</b></td>
                              <td><b>-</b></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Training Requirements</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <b>A) Soft Skills Training [Based on Behavioral parameter]</b>
                     <table class="table">
                        <thead>
                           <tr>
                              <th>Sn</th>
                              <th>Category</th>
                              <th>Topic</th>
                              <th>Description</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Business Skills</b></td>
                              <td>Leadership Skills</td>
                              <td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
                           </tr>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Business Skills</b></td>
                              <td>Leadership Skills</td>
                              <td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
                           </tr>
                        </tbody>
                     </table>
                     <b>B) Functional Skills Training [Job related]</b>
                     <table class="table">
                        <thead>
                           <tr>
                              <th>Sn</th>
                              <th>Topic</th>
                              <th>Description</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Accounting & Budget Training</b></td>
                              <td>Managing the company's finances. Budgeting will help project expenditures for given periodicity.</td>
                           </tr>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Customer handling</b></td>
                              <td>	Dealing with different kinds of customers, developing persuasive skills, handling complaints, developing listening skills & empathy, taking control and solving problems, mantaining customer relations etc.</td>
                           </tr>
                        </tbody>
                     </table>
                     <div class="mt-3">
                        <h5>Appraisal Remarks</h5>
                        <p>test remarks.</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <a class="effect-btn btn btn-light squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
            </div>
         </div>
      </div>
   </div>-->
   <!-- All achivement and feedback edit -->
   <!--<div class="modal fade show" id="editAppraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title"><b>Kishan Kumar</b><br><small> Emp. ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Achievements</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive align-items-center appraisal-view">
                     <ol>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                     </ol>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Feedback</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive align-items-center">
                     <ul>
                        <li>1. What is your feedback regarding the existing & new processes that are being followed or needs to be followed in your respective functions?</li>
                        <li><b>Ans.</b> test 123456</li>
                        <li>&nbsp;</li>
                        <li>2. At work, are there any factors that hinder your growth?</li>
                        <li><b>Ans.</b> test 123456</li>
                        <li>&nbsp;</li>
                        <li>3. At work, what are the factors that facilitate your growth?</li>
                        <li><b>Ans.</b> test 123456</li>
                        <li>&nbsp;</li>
                        <li>4. What support you need from the superiors to facilitate your performance?</li>
                        <li><b>Ans.</b> test 123456</li>
                        <li>&nbsp;</li>
                        <li>5. Any other feedback.</li>
                        <li><b>Ans.</b> test 123456</li>
                     </ul>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <table class="table table-pad" id="mykrabox">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th style="width:215px;">KRA/Goals</th>
                              <th style="width:300px;">Description</th>
                              <th>Measure</th>
                              <th>Unit</th>
                              <th>Weightage</th>
                              <th>Logic</th>
                              <th>Period</th>
                              <th>Target</th>
                              <th>Self Rating</th>
                              <th style="width:215px;">Self Remarks</th>
                              <th>App Rating</th>
                              <th>App Score</th>
                              <th>App Remarks</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1.</b></td>
                              <td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td> 
                                 <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                 <span class="icon-on">100 </span> 
                                 </button>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                              <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                           </tr>
                           <tr>
                              <td><b>2.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td> 
                                 <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                 <span class="icon-on">100 </span> 
                                 </button>
                              </td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                              <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                           </tr>
                           <tr>
                              <td><b>3.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td> 
                                 <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                 <span class="icon-on">100 </span> 
                                 </button>
                              </td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                              <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                           </tr>
                           <tr>
                              <td><b>4.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td> 
                                 <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                 <span class="icon-on">100 </span> 
                                 </button>
                              </td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                              <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                           </tr>
                           <tr>
                              <td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>Process</td>
                              <td>Days</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td> 
                                 <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                 <span class="icon-on">100 </span> 
                                 </button>
                              </td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                              <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                           </tr>
                           <tr>
                              <td colspan="15">
                                 <table class="table" Style="background-color:#ECECEC;">
                                    <thead >
                                       <tr>
                                          <th>SN.</th>
                                          <th style="width:215px;">Sub KRA/Goals</th>
                                          <th style="width:300px;">Description</th>
                                          <th>Measure</th>
                                          <th>Unit</th>
                                          <th>Weightage</th>
                                          <th>Logic</th>
                                          <th>Period</th>
                                          <th>Target</th>
                                          <th>Self Rating</th>
                                          <th style="width:215px;">Self Remarks</th>
                                          <th>App Rating</th>
                                          <th>App Score</th>
                                          <th>App Remarks</th>
                                       </tr>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <tr>
                                          <td><b>1.</b></td>
                                          <td>test </td>
                                          <td>twst</td>
                                          <td>Process</td>
                                          <td>Days</td>
                                          <td>25</td>
                                          <td>Logic 01</td>
                                          <td>Quarterly</td>
                                          <td> <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                             <span class="icon-on">100 </span> 
                                             </button>
                                          </td>
                                          <td>85</td>
                                          <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                                          <td><input class="form-control" type="text" value="67"></td>
                                          <td>20.1</td>
                                          <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                                       </tr>
                                       <tr>
                                          <td><b>2.</b></td>
                                          <td>test </td>
                                          <td>twst</td>
                                          <td>Process</td>
                                          <td>Days</td>
                                          <td>25</td>
                                          <td>Logic 01</td>
                                          <td>Quarterly</td>
                                          <td> 
                                             <button title="Click to target" style="padding: 5px 8px;border:0px;" type="button" class="btn btn-success custom-toggle" data-bs-toggle="modal" data-bs-target="#targetbox">
                                             <span class="icon-on">100 </span> 
                                             </button>
                                          </td>
                                          <td>85</td>
                                          <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                                          <td><input class="form-control" type="text" value="67"></td>
                                          <td>20.1</td>
                                          <td><textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea></td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Form - B (Skills)</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center p-0">
                     <table class="table table-pad ">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th style="width:215px;">Skill</th>
                              <th style="width:300px;">Skill Comment</th>
                              <th>Weightage</th>
                              <th>Logic</th>
                              <th>Period</th>
                              <th>Target</th>
                              <th>Emp Ass.</th>
                              <th style="width:215px;">Emp Remarks</th>
                              <th>Appraisar Ass.</th>
                              <th>Appraiser Score</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1.</b></td>
                              <td> There are many variations of passages of Lorem Ipsum available, but the majority have suffered.</td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>2.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>3.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>4.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                           </tr>
                           <tr>
                              <td><b>5.</b></td>
                              <td>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. </td>
                              <td>twst</td>
                              <td>25</td>
                              <td>Logic 01</td>
                              <td>Quarterly</td>
                              <td>100</td>
                              <td>85</td>
                              <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot - 129.15 achievement against on target 216.36 Lakh</td>
                              <td><input class="form-control" type="text" value="67"></td>
                              <td>20.1</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>PMS Score</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <table class="table" style="background-color:#ECECEC;">
                        <thead>
                           <tr>
                              <th>SN.</th>
                              <th>KRA form</th>
                              <th>% Weightage</th>
                              <th>(A) KRA Score</th>
                              <th>Behavioral form</th>
                              <th>% Weightage</th>
                              <th>(B) Behavioral score</th>
                              <th>(A + B) PMS Score</th>
                              <th>Rating</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>Employee</td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                           </tr>
                           <tr>
                              <td>Appraiser</td>
                              <td></td>
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
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Promotion Recommendation </b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <table class="table">
                        <thead>
                           <tr>
                              <th></th>
                              <th>Grade</th>
                              <th>Designation</th>
                              <th>Description</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>Current</b></td>
                              <td><b>J4.</b></td>
                              <td><b>Business manager</b></td>
                              <td><b>-</b></td>
                           </tr>
                           <tr>
                              <td><b>Appraiser</b></td>
                              <td>
                                 <select>
                                    <option>J4</option>
                                    <option>J5</option>
                                    <option>J6</option>
                                 </select>
                              </td>
                              <td>
                                 <select>
                                    <option>Business manager</option>
                                    <option>Zonal Manager</option>
                                    <option>1</option>
                                 </select>
                              </td>
                              <td><input style="min-width: 300px;" type="text" ></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <br>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Training Requirements </b></h5>
                        <br>
                        <b>A) Soft Skills Training [Based on Behavioral parameter]</b>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <div class=" mr-2">
                        <label class="col-form-label"><b>Name of Training</b></label><br>
                        <select class="">
                           <option>Business Training</option>
                           <option>Soft Skill</option>
                           <option>1</option>
                        </select>
                     </div>
                     <div class="">
                        <label class="col-form-label"><b>Description</b></label>
                        <input type="text" name="" style="width:300px;" class="form-control">
                     </div>
                     <a style="border: 1px solid #ddd;padding: 2px 7px;font-size: 11px;" class="mt-4 ms-3 btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i> Submit</a><br>
                     <table class="table mt-2">
                        <thead>
                           <tr>
                              <th>Sn</th>
                              <th>Category</th>
                              <th>Topic</th>
                              <th>Description</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Business Skills</b></td>
                              <td>Leadership Skills</td>
                              <td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
                              <td><a href=""><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                           </tr>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Business Skills</b></td>
                              <td>Leadership Skills</td>
                              <td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
                              <td><a href=""><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <b>B) Functional Skills [Job related]</b>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <div class=" mr-2" >
                        <label class="col-form-label"><b>Name of Training</b></label><br>
                        <select class="">
                           <option>Business Training</option>
                           <option>Soft Skill</option>
                           <option>1</option>
                        </select>
                     </div>
                     <div class="">
                        <label class="col-form-label"><b>Description</b></label>
                        <input type="text" name="" style="width:300px;" class="form-control">
                     </div>
                     <a style="border: 1px solid #ddd;padding: 2px 7px;font-size: 11px;" class="mt-4 ms-3 btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i> Submit</a>
                     <br>
                     <table class="table mt-2">
                        <thead>
                           <tr>
                              <th>Sn</th>
                              <th>Category</th>
                              <th>Topic</th>
                              <th>Description</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1</b></td>
                              <td><b>Business Skills</b></td>
                              <td>Leadership Skills</td>
                              <td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
                              <td><a href=""><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                           </tr>
                           <tr>
                              <td><b>2</b></td>
                              <td><b>Business Skills</b></td>
                              <td>Leadership Skills</td>
                              <td>To develop effective Leadership skills.. Self motivated and capable to inspire others and take charge, developing empathy, communication, etc.</td>
                              <td><a href=""><i class="fas fa-trash ml-2 mr-2"></i></a></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <b>Remaks</b>
                     </div>
                  </div>
                  <div class="card-body table-responsive dd-flex align-items-center">
                     <input class="form-control" Type="text" />
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <a class="effect-btn btn btn-success squer-btn sm-btn">Save as Draft</a>
               <a class="effect-btn btn btn-success squer-btn sm-btn">Final Submit</a>
               <a class="effect-btn btn btn-light squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
            </div>
         </div>
      </div>
   </div>-->
   <!--KRA View Details-->
   <div class="modal fade show" id="viewdetailskra" tabindex="-1"
      aria-labelledby="exampleModalCenterTitle" style="display: none;" data-bs-backdrop="static" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle3">KRA view details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <b>Logic: Logic 01</b><br>
               <b>KRA:</b>There are many variations of passages of Lorem Ipsum available, but the majority have
               suffered.<br>
               <b>Description:</b> twst
               <table class="table table-pad" id="mykraeditbox">
               </table>
            </div>
            <div class="modal-footer">
               <button type="button" class="effect-btn btn btn-light squer-btn sm-btn "
                  data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Revert KRA -->
   <div class="modal fade show" id="resubmitKRA" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
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
   <!-- uploaded files to show  -->
   <div class="modal fade" id="uploadedFilesModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
               <h5 class="modal-title">
                  <i class="fas fa-folder-open"></i> Uploaded Files
               </h5>
               <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="table-responsive">
                  <table class="table table-hover align-middle">
                     <thead class="thead-dark">
                        <tr>
                           <th style="width: 60%">File Name</th>
                           <th class="text-center" style="width: 20%">Type</th>
                           <th class="text-center" style="width: 20%">Action</th>
                        </tr>
                     </thead>
                     <tbody id="fileList">
                        <tr>
                           <td colspan="3" class="text-center text-muted">No files available.</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- pmshelpvideo popup -->
<div class="modal fade show" id="pmshelpvideo" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title"><b>PMS Help Video</b></h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				  </button>
			</div>
			<div class="modal-body table-responsive p-0 text-center">
				<video width="auto" height="500" controls>
					<source src="./public/video/ess-reporting-appraisal-help.mp4" type="video/mp4">
				</video>
			</div>
		</div>
	</div>
</div>
   @include('employee.footer');
   <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
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
      
                 console.log(name);
      
      		$('#employeenameview').text(employeename);
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
                                                 console.log(kra.Period);
                                                 const hasSubKras = subKraData[kra.KRAId] && subKraData[kra.KRAId].length > 0;
      
      										modalBody += `
      											<tr>
      												<td><b>${index + 1}.</b></td>
      												<td>${kra.KRA}</td>
      												<td>${kra.KRA_Description}</td>
      												<td>${kra.Measure}</td>
      												<td>${kra.Unit}</td>
      												<td>${kra.Weightage}</td>
      												<td>${kra.Logic}</td>
      												<td>${kra.Period}</td>
      												<td>`;
      
                                                         if (!hasSubKras && kra.Period !== 'Annual') {
                                                             modalBody += `
                                                                 <button id="Tar_kra_${kra.KRAId}" 
                                                                     style="padding: 5px 8px;" 
                                                                     type="button" 
                                                                     class="btn btn-outline-success custom-toggle" 
                                                                     data-bs-toggle="modal"
                                                                     onClick="showKraDetailsappraisal('${kra.KRAId}', '${kra.Period}', '${kra.Target}', '${kra.Weightage}', '${kra.Logic}', '${kraYId}')">
                                                                     <span class="icon-on">${kra.Target}</span>
                                                                 </button>`;
                                                         } else {
                                                             modalBody += `<span class="icon-on"></span>`; // Empty if Period is 'Annual' or if KRA has sub-KRAs
                                                         }
      
      										
      										modalBody += `</td></tr>`;
      
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
      														<td>${subKra.Measure}</td>
      														<td>${subKra.Unit}</td>
      														<td>${subKra.Weightage}</td>
      														<td>${subKra.Logic}</td>
      														<td>${subKra.Period}</td>
      														<td>`;
      
      												// Check if sub-KRA Period is not 'Annual' and show button accordingly
      												if (subKra.Period !== 'Annual') {
      													modalBody += `
      														<button id="Tar_a${subKra.KRASubId}"
      															style="padding: 5px 8px;" 
      															type="button" 
      															class="btn btn-outline-success custom-toggle" 
      															data-bs-toggle="modal"
      															onClick="showKraDetailsappraisal('sub_${subKra.KRASubId}', '${subKra.Period}', '${subKra.Target}', '${subKra.Weightage}', '${subKra.Logic}', '${kraYId}')">
      															<span class="icon-on">${subKra.Target}</span>
      														</button>`;
      												} else {
      													modalBody += `<span class="icon-on">${subKra.Target}</span>`;
      												}
      
      												modalBody += `</td></tr>`; // Closing subKRA row table
      											}); // End subKRA loop
      
      											modalBody += `</tbody></table></td></tr>`; // Close the sub-KRA section
      										} // End of sub-KRA check
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
      function showKraDetailsappraisal(id, period, target, weightage, logic, year_id) {
                 let isSubKra = id.startsWith("sub_"); // Check if it's a Sub-KRA
           
                 let requestData = {
                     kraId: isSubKra ? null : id,  
                     subKraId: isSubKra ? id.replace("sub_", "") : null,  // Remove "sub_" to get only the numeric ID
                     year_id: year_id
                 };
           
                 // Show modal with loader before fetching data
                 $("#viewdetailskra .modal-body").html(`
                         <div id="kraLoader" class="text-center py-5">
                             <div class="spinner-border text-primary" role="status"></div>
                             <p>Fetching details, please wait...</p>
                         </div>
                         <div id="kraContent" style="display:none;"></div> <!-- Hidden Content -->
                     `);
                 $("#viewdetailskra").modal("show"); // Show modal immediately
           
                 // Fetch data in the background
                 $.ajax({
                     url: "{{ route('kra.details') }}",
                     type: "GET",
                     data: requestData,
                     success: function(response) {
                         if (response.success) {
                             let kraData = response.kraData;
                             let subKraData = response.subKraData;
                             let subKraDatamain = response.subKraDatamain;
                             let pmsData = response.pmsData;
           
                             console.log(kraData);
           
                             let contentHtml = ""; // Placeholder for final content
           
                             if (subKraData) {
                                 const logic = subKraData.Logic ;
                                 console.log(logic);
           
                                 contentHtml = `
                         <p><strong>Logic:</strong> ${subKraData.Logic}</p>
                         <p><strong>KRA:</strong> ${subKraData.KRA}</p>
                         <p><strong>KRA Description:</strong> ${subKraData.KRA_Description}</p>
                         <table class="table table-pad" id="mykraeditbox">
                             <thead>
                                 <tr style="text-align:center;">
                                                     <th></th>
                                                     <th>SN.</th>
           					<th>Quarter</th>
           					<th>Weightage</th>
           					<th>Target</th>
           					<th style="width:215px;">Comments</th>
           					<th>Self rating</th>
           					<th style="width:300px;">Rating details</th>
           					<th>Score</th>
           					<th>Reporting rating</th>
           					<th>Reporting remarks</th>
           					<th>Reporting score</th>
           					<th>Action</th>
                                                             <th></th>
           
                                 </tr>
                                
                             </thead>
                             <tbody id="kraRows">
                                 ${generateKraRowsAppraisal(kraData, subKraData,subKraDatamain,logic,pmsData,period)}
                             </tbody>
                         </table>
                     `;
                             } else {
                                 const logic = subKraDatamain.Logic ;
                                 console.log(logic);
           
                                 contentHtml = `
                         <p><strong>Logic:</strong> ${subKraDatamain.Logic}</p>
                         <p><strong>KRA:</strong> ${subKraDatamain.KRA}</p>
                         <p><strong>KRA Description:</strong> ${subKraDatamain.KRA_Description}</p>
                         <table class="table table-pad" id="mykraeditbox">
                             <thead>
                                 <tr style="text-align:center;">
                                                         <th></th>
                                                             <th>SN.</th>
           					<th>Quarter</th>
           					<th>Weightage</th>
           					<th>Target</th>
           					<th style="width:215px;">Comments</th>
           					<th>Self rating</th>
           					<th style="width:300px;">Rating details</th>
           					<th>Score</th>
           					<th>Reporting rating</th>
           					<th>Reporting remarks</th>
           					<th>Reporting score</th>
           					<th>Action</th>
                                                             <th></th>
                                 </tr>
                                 
                             </thead>
                             <tbody id="kraRows">
                                 ${generateKraRowsAppraisal(kraData, null, subKraDatamain, logic,pmsData,period)}
                             </tbody>
                         </table>
                     `;
                             }
           
                             contentHtml += `
                     <div class="float-end">
                         <i class="fas fa-check-circle mr-2 text-success"></i> Final Submit, 
                         <i class="ri-check-double-line mr-1 text-success"></i> Save as Draft
                     </div>
                     <p><b>Note:</b><br> 
                         1. Please ensure that the achievement is calculated against the "<b>Target Value</b>" only.<br>
                         2. The achievement is required to be entered on the last day or within a few days, beyond which the KRA will be auto-locked.
                     </p>
                 `;
           
                             // Insert content but keep loader
                             $("#kraContent").html(contentHtml);
           
                             // Wait until generateKraRows is done, then show content & hide loader
                             setTimeout(() => {
                                 $("#kraLoader").hide(); // Hide loader
                                 $("#kraContent").fadeIn(); // Show content
                             }, 300); // Small delay to ensure rows are ready
                         } else {
                             $("#viewdetailskra .modal-body").html(`<p class="text-center text-danger">No data found!</p>`);
                         }
                     },
                     error: function() {
                         $("#viewdetailskra .modal-body").html(`<p class="text-center text-danger">An error occurred while fetching KRA details.</p>`);
                     }
                 });
             }
           
           
             function generateKraRowsAppraisal(kraData, subKraData = null, subKraDatamain = null,logic,pmsData,period) {
                 
                 let rows = '';
                 let totalWeight = 0;
                 let totalscremp= 0;
           
                     const currentDate = new Date(); // Get the current date
                     const currentYear = currentDate.getFullYear();
                     const currentMonth = currentDate.getMonth() + 1; // JS months are 0-based, so +1
                     let Mnt_cal = 13 - currentMonth; // Equivalent of PHP's `$Mnt_cal`
           
                 kraData.forEach((detail, index) => {
                 totalWeight += parseFloat(detail.Wgt) || 0; // Use parseFloat to ensure it's a number
                 totalscremp += parseFloat(detail.Scor) || 0; // Use parseFloat to ensure it's a number
           
                 totalWeight = parseFloat(totalWeight.toFixed(2));
                 totalscremp = parseFloat(totalscremp.toFixed(2));
           
           
                 let lDate = new Date(detail.Ldate);
           
                     // Check if Ldate is within the current date range
                     let isWithinDateRange = lDate >= currentDate;
                     let next10Day = new Date(lDate);
                         next10Day.setDate(lDate.getDate() + 10); // Add 10 days to Ldate
                         
                         let next14Day = new Date(lDate);
                         next14Day.setDate(lDate.getDate() + 14); // Add 14 days to Ldate
           
                     let weight = detail.Wgt; // Get weight from the detail object
                     let savestatus =detail.save_status;
                     let submitstatus =detail.submit_status;
           
                     let lockk = detail.lockk;
           
                         let Applockk  = detail.Applockk;
                         let appRevert = detail.AppRevert;
                         let AppCmnt = detail.AppCmnt;
                         let AppAch = detail.AppAch;
           
                         let tgtDefId = detail.TgtDefId;
           
                             // Calculate PerM value
                         let PerM = 0;
           
                         if (period === 'Monthly') {
                             let lm = index + 1;
                             PerM = Mnt_cal >= (13 - lm) ? 1 : 0;
                         } 
                         else if (period === 'Quarter') {
                             let quarterMappings = [
                                 { name: 'Quarter 1', endMonth: 3, startRange: [10, 12] },
                                 { name: 'Quarter 2', endMonth: 6, startRange: [7, 12] },
                                 { name: 'Quarter 3', endMonth: 9, startRange: [4, 12] },
                                 { name: 'Quarter 4', endMonth: 12, startRange: [1, 12] }
                             ];
                             let quarter = quarterMappings.find(q => currentMonth <= q.endMonth);
                             PerM = (quarter && Mnt_cal >= quarter.startRange[0] && Mnt_cal <= quarter.startRange[1]) ? 1 : 0;
                         } 
                         else if (period === '1/2 Annual') {
                             let halfYearMappings = [
                                 { name: 'Half Year 1', endMonth: 6, startRange: [7, 12] },
                                 { name: 'Half Year 2', endMonth: 12, startRange: [1, 12] }
                             ];
                             let halfYear = halfYearMappings.find(h => currentMonth <= h.endMonth);
                             PerM = (halfYear && Mnt_cal >= halfYear.startRange[0] && Mnt_cal <= halfYear.startRange[1]) ? 1 : 0;
                         }
                         
           
                         let showEdit = (parseInt(PerM) === 1 && 
                                     ((parseInt(Applockk) === 0 && currentDate <= next14Day) ||
                                     (parseInt(AppAch) === 0 && parseInt(AppAch) === '')|| AppCmnt === ''));
             
                         let allowEdit = showEdit && submitstatus !== 1;
           
           
                         // Define readonly or editable mode based on date range
                         let isReadonly = !isWithinDateRange;
           
                                 rows += `
                                     <tr>
                                         <td id="applogscore${index}" style="display:none">${detail.AppLogScr}<td>
                                         <input type="hidden" class="tgt-id" value="${detail.TgtDefId }" id="tgt-id-${index}">
           
                                         <td><b>${index + 1}</b></td>
                                         <td>${detail.Tital}</td>
                                         <td style="text-align:center;">${weight}</td>
                                         <td style="text-align:center;">100</td>
                                         <td>${detail.Remark}</td>
                                         <td>${detail.Ach}</td>
                                         <td>${detail.Cmnt}
                                         </td>
                                         <td id="score${index}">${detail.Scor}</td>
                                         <td style="background-color: #e7ebed;">
                                                 <input class="form-control self-rating-app" style="width: 60px;" type="number" placeholder="Enter rating"  id="appselfrating${index}"
                                             value="${detail.AppAch}" data-target="${detail.Tgt}" data-index="${index}"data-logic="${logic}" 
                                             data-weight="${detail.Wgt}"
                                                 readonly>
                                         </td>
                                         <td style="background-color: #e7ebed;">
                                             <textarea class="form-control self-remark-app" required style="min-width: 200px;min-height:70px;" data-index="${index}"
                                             placeholder="Enter your remark" id="appselfremark${index}"	readonly>${detail.AppCmnt}</textarea>
           
                                         </td>
                                         <td id="appscore${index}" style="background-color: #e7ebed;text-align:center;">${detail.AppScor}</td>
                                             <td>
                                                 ${allowEdit ? 
                                                 `<a title="Edit" class="fas fa-edit text-info mr-2" onclick="enableEditMode(this, ${index})"></a>` 
                                                 : ''
                                                 }
                                                 
                                             <span class="edit-buttons" style="display: none;">
                                         <a title="Save" href="javascript:void(0);" onclick="saveRowData(${index}, '${tgtDefId}','save')">
                                             <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                         </a>
                                         <a href="javascript:void(0);" style="padding: 2px 7px;font-size: 11px;" onclick="saveRowData(${index}, '${tgtDefId}','submit')"
                                             class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit">
                                             <i style="font-size:14px;" class="ri-check-line"></i>
                                         </a>
                                     </span>
                             </td>
                                 <td>${savestatus === 1 ? 
                                     `<a title="save" href=""><i style="font-size:14px;" class="ri-check-double-line mr-2 text-success"></i></a>` 
                                     : ''}
           
                                 ${submitstatus === 1 ? 
                                     `<a title="Submit"><i style="font-size:14px;" class="fas fa-check-circle mr-2 text-success"></i></a>` 
                                     : ''}
                                 </td>
                                 `;
                             });
                             // Add row for Sub-KRA (Total) if available
                             if (subKraData && !kraData) {
                                 rows += `
                                     <tr>
                                         <td></td>
                                         <td colspan="2"><b>Total</b></td>
                                         <td style="text-align:center;">${totalWeight}</td>
                                         <td colspan="4"></td>
                                         <td style="text-align:center;">${totalscremp}</td>
                                         <td colspan="7"></td>
                                     </tr>
                                 `;
                             }
                             if (kraData && !subKraData) {
           
                                 rows += `
                                     <tr>
                                         <td></td>
                                         <td colspan="2"><b>Total</b></td>
                                         <td style="text-align:center;">${totalWeight}</td>
                                         <td colspan="4"></td>
                                         <td style="text-align:center;">${totalscremp}</td>
                                         <td colspan="7"></td>
                                     </tr>
                                 `;
                             }
                             if (subKraDatamain && !kraData) {
           
                                 rows += `
                                     <tr>
                                         <td></td>
                                         <td colspan="2"><b>Total</b></td>
                                         <td style="text-align:center;">${totalWeight}</td>
                                         <td colspan="4"></td>
                                         <td style="text-align:center;">${totalscremp}</td>
                                         <td colspan="7"></td>
                                     </tr>
                                 `;
                             }
                             if (!subKraDatamain && kraData) {
           
                             rows += `
                                 <tr>
                                         <td></td>
                                     <td colspan="2"><b>Total</b></td>
                                     <td style="text-align:center;">${totalWeight}</td>
                                         <td colspan="4"></td>
                                         <td style="text-align:center;">${totalscremp}</td>
                                     <td colspan="7"></td>
                                 </tr>
                             `;
                             }
                             return rows;
             }
             function enableEditMode(editLink, index) {
                     // Get the row of the clicked edit link
                     const row = editLink.closest('tr');
           
                     // Find the input and textarea elements in the row
                     const inputField = row.querySelector('input[type="number"]');
                     const textareaField = row.querySelector('textarea');
                     const editButtons = row.querySelector('.edit-buttons');
           
                     // Toggle the readonly attribute
                     if (inputField && textareaField) {
                     const isReadonly = inputField.hasAttribute('readonly');
                     if (isReadonly) {
                         inputField.removeAttribute('readonly');
                         textareaField.removeAttribute('readonly');
                         editButtons.style.display = 'inline'; // Show Save and Submit buttons
                         editLink.style.display = 'none'; // Hide Edit button
                     } else {
                         inputField.setAttribute('readonly', true);
                         textareaField.setAttribute('readonly', true);
                         editButtons.style.display = 'none'; // Hide Save and Submit buttons
                         editLink.style.display = 'inline'; // Show Edit button
                     }
                     }
                 }
                 $(document).on('input', '.self-remark-app', function() {
                     let selfremark =$(this).val()|| ''; // Get the self-rating value, default to 0 if empty
                     console.log(selfremark);
                     let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
           
                     $('#appselfremark' + index).text(selfremark); // Update only the respective row's score cell
                 });
                 // Real-time calculation function for score
                 $(document).on('input', '.self-rating-app', function() {
                     let selfRating = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                     let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                     let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                     let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                     let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                     var ach=Math.round(((target*selfRating)/100)*100)/100; //var ach=parseFloat(v);  
                     $('#appselfrating' + index).text(selfRating); // Update only the respective row's score cell
           
                     if (logic === 'Logic1') {
                             // Calculate Per50, Per150, and the final EScore based on the provided logic
                             var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                             var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                             if (ach <= Per150) {
                                 var EScore = ach;
                                 $('#applogscore' + index).text(ach); // Update only the respective row's score cell
      
                             } else {
                                 var EScore = Per150;
                                 $('#applogscore' + index).text(Per150); // Update only the respective row's score cell
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                             
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         } 
                         else if (logic === 'Logic2') {
                             let EScore;
                             if (ach <= target) {
                                 EScore = ach;
                                 $('#applogscore' + index).text(ach); // Update only the respective row's score cell
      
                             } else {
                                 EScore = target;
                                 $('#applogscore' + index).text(target); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
      
                         }
                         else if (logic === 'Logic2a') {
                             let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             let Per110 = Math.round((target + Per10) * 100) / 100;
                             let EScore;
                             if (ach >= Per110) {
                                 EScore = Per110;
                                 $('#applogscore' + index).text(Per110); // Update only the respective row's score cell
      
                             } else {
                                 EScore = ach;
                                 $('#applogscore' + index).text(ach); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic3') {
                             let EScore;
                                 if (ach === target) {
                                     EScore = ach;
                                     $('#applogscore' + index).text(ach); // Update only the respective row's score cell
      
                                 } else {
                                     EScore = 0;
                                     $('#applogscore' + index).text('0'); // Update only the respective row's score cell
      
                                 }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                     
                         if (logic === 'Logic4') {
                             // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                             let EScore;
                             if (ach >= target) {
                                 EScore = target;
                                 $('#applogscore' + index).text(target); // Update only the respective row's score cell
      
                             } else {
                                 EScore = 0;
                                 $('#applogscore' + index).text('0'); // Update only the respective row's score cell
      
                             }
      
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic5') {
                             let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             let Per70 = Math.round((target - Per30) * 100) / 100;
                             let EScore = 0;
                             if (ach >= Per70 && ach < target) {
                                 EScore = ach;
                                 $('#applogscore' + index).text(ach); // Update only the respective row's score cell
      
                             } else if (ach >= target) {
                                 EScore = target;
                                 $('#applogscore' + index).text(target); // Update only the respective row's score cell
      
                             }
                             else{
                                 $('#applogscore' + index).text('0'); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         if (logic === 'Logic6a') {
                             // Logic6a Logic
                                 if (target == 8.33) {
                                     ach = ach * 12;
                                 } else if (target == 25) {
                                     ach = ach * 4;
                                 } else if (target == 50) {
                                     ach = ach * 2;
                                 }
                                 else{
                                     ach=ach;
                                 }
                                 
                                 let Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                                 let Per50 = Math.round(((target * 50) / 100) * 100) / 100;
      
                                 if (ach <= 15) {
                                     EScore = target;
                                     $('#applogscore' + index).text(target); // Update only the respective row's score cell
      
                                 } else if (ach > 15 && ach <= 20) {
                                     EScore = Per80;
                                     $('#applogscore' + index).text(Per80); // Update only the respective row's score cell
      
                                 } else if (ach > 20 && ach <= 25) {
                                     EScore = Per50;
                                     $('#applogscore' + index).text(Per50); // Update only the respective row's score cell
      
                                 } else {
                                     EScore = 0;
                                     $('#applogscore' + index).text('0'); // Update only the respective row's score cell
                                 }
                                 MScore = Math.round(((EScore / target) * weight) * 100) / 100;
      
                                 $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic6b') {
                             // Logic6B Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
                             else{
                                 ach=ach;
                             }
      
                             if (ach < 5) {
                                 EScore = target;
                                 $('#applogscore' + index).text(target); // Update only the respective row's score cell
      
                             } else {
                                 EScore = 0;
                                 $('#applogscore' + index).text('0'); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
      
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic6') {
                             // Logic6 Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
                             else{
                                 ach=ach;
                             }
      
                             let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                             let Per125 = Math.round(((target * 125) / 100) * 100) / 100;
                             let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                             let Per85 = Math.round(((target * 85) / 100) * 100) / 100;
                             let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                             let PerAct = Math.round(((target * ach) / 100) * 100) / 100;
                             let ScoAct = Math.round((target - PerAct) * 100) / 100;
      
                             if (ach <= 10) {
                                 MScore = Per150;
                                 $('#applogscore' + index).text(Per150);
      
                             } else if (ach > 10 && ach <= 15) {
                                 MScore = Per125;
                                 $('#applogscore' + index).text(Per125);
      
                             } else if (ach > 15 && ach <= 20) {
                                 MScore = Per100;
                                 $('#applogscore' + index).text(Per100);
      
                             } else if (ach > 20 && ach <= 25) {
                                 MScore = Per85;
                                 $('#applogscore' + index).text(Per85);
      
                             } else if (ach > 25 && ach <= 30) {
                                 MScore = Per75;
                                 $('#applogscore' + index).text(Per75);
      
                             } 
                             else {
                                 MScore = 0;
                                 $('#applogscore' + index).text('0');
                             }
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic7') {
                             // Logic7 Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
      
                             let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                             let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                             let Per90 = Math.round(((target * 90) / 100) * 100) / 100;
                             let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
      
                             if (ach == 0) {
                                 MScore = Per150;
                                 $('#applogscore' + index).text(Per150);
      
                             } else if (ach > 0 && ach <= 2) {
                                 MScore = Per100;
                                 $('#applogscore' + index).text(Per100);
      
                             } else if (ach > 2 && ach <= 5) {
                                 MScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach > 5 && ach <= 10) {
                                 MScore = Per75;
                                 $('#applogscore' + index).text(Per75);
      
                             } else {
                                 MScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic8a' || logic === 'Logic8b' || logic === 'Logic8c' || logic === 'Logic8d' || logic === 'Logic8e') {
                             // Logic8 variations
                             let Percent = 0;
                             if (logic === 'Logic8a') {
                                 Percent = ((ach / target) * 115) / 100;
                             } else if (logic === 'Logic8b') {
                                 Percent = ((ach / target) * 100) / 100;
                             } else if (logic === 'Logic8c') {
                                 Percent = ((ach / target) * 90) / 100;
                             } else if (logic === 'Logic8d') {
                                 Percent = ((ach / target) * 65) / 100;
                             } else if (logic === 'Logic8e') {
                                 Percent = ((ach / target) * (-100)) / 100;
                             }
      
                             MScore = Math.round((Percent * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         // Logic9
                         else if (logic === 'Logic9') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             if (ach < Per90) {
                                 var EScore = ach;
                                 $('#applogscore' + index).text(ach);
      
                             } else if (ach >= Per90) {
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else {
                                 var EScore = applogscore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         // Logic10
                         else if (logic === 'Logic10') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100; 
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100; 
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100; 
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                             var Per6 = Math.round(((target * 6) / 100) * 100) / 100; 
                             var Per7 = Math.round(((target * 7) / 100) * 100) / 100; 
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100; 
                             var Per91 = Math.round((Per90 + Per1) * 100) / 100;
                             var Per93 = Math.round((Per90 + Per3) * 100) / 100; 
                             var Per94 = Math.round((target - Per6) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100; 
                             var Per98 = Math.round((target - Per2) * 100) / 100; 
                             var Per105 = Math.round((target + Per5) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per120 = Math.round((target + Per20) * 100) / 100;
      
                             if (ach < Per90) {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             } else if (ach == Per90) {
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach > Per90 && ach <= Per93) {
                                 var EScore = Per105;
                                 $('#applogscore' + index).text(Per105);
      
                             } else if (ach > Per93 && ach <= Per97) {
                                 var EScore = Per110;
                                 $('#applogscore' + index).text(Per110);
      
                             } else if (ach > Per97) {
                                 var EScore = Per120;
                                 $('#applogscore' + index).text(Per120);
      
                             } else {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         // Logic11
                         else if (logic === 'Logic11') {
                             var EScore = ach;
                             $('#applogscore' + index).text(ach);
      
                             var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         // Logic12
                         else if (logic === 'Logic12') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             if (ach < Per90) {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             } else if (ach >= Per90) {
                                 var EScore = ach;
                                 $('#applogscore' + index).text(ach);
      
                             } else {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         // Logic13a
                         else if (logic === 'Logic13a') {
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                             var Per130 = Math.round((target + Per30) * 100) / 100;
                             var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                             var Per121 = Math.round((target + Per21) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per11 = Math.round(((target * 11) / 100) * 100) / 100; 
                             var Per111 = Math.round((target + Per11) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100;   
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per80 = Math.round((target - Per20) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100;  
      
                             if (ach <= Per80) {
                                 var EScore = Per80;
                                 $('#applogscore' + index).text(Per80);
      
                             } else if (ach >= Per81 && ach <= Per90) {
                                 var EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach >= Per91 && ach <= Per110) {
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach >= Per111 && ach <= Per120) {
                                 var EScore = Per80;
                                 $('#applogscore' + index).text(Per80);
      
                             } else if (ach >= Per121) {
                                 var EScore = Per70;
                                 $('#applogscore' + index).text(Per70);
      
                             } else {
                                 var EScore = applogscore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         // Logic13b
                         else if (logic === 'Logic13b') {
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                             var Per140 = Math.round((target + Per40) * 100) / 100;
                             var Per31 = Math.round(((target * 31) / 100) * 100) / 100; 
                             var Per131 = Math.round((target + Per31) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                             var Per130 = Math.round((target + Per30) * 100) / 100;
                             var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                             var Per121 = Math.round((target + Per21) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per29 = Math.round(((target * 29) / 100) * 100) / 100; 
                             var Per71 = Math.round((target - Per29) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;  
      
                             if (ach <= Per70) {
                                 var EScore = Per70;
                                 $('#applogscore' + index).text(Per70);
      
                             } else if (ach >= Per71 && ach <= Per80) {
                                 var EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach >= Per81 && ach <= Per120) {
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach >= Per121 && ach <= Per130) {
                                 var EScore = Per80;
                                 $('#applogscore' + index).text(Per80);
      
                             } else if (ach >= Per131) {
                                 var EScore = Per70;
                                 $('#applogscore' + index).text(Per70);
      
                             } else {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         // Logic14a
                         else if (logic === 'Logic14a') {
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                             var Per86 = Math.round((target - Per14) * 100) / 100;
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                             var Per85 = Math.round((target - Per15) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per24 = Math.round(((target * 24) / 100) * 100) / 100; 
                             var Per76 = Math.round((target - Per24) * 100) / 100;
                             var Per25 = Math.round(((target * 25) / 100) * 100) / 100; 
                             var Per75 = Math.round((target - Per25) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
      
                             if (ach <= Per75) {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
                             } else if (ach >= Per76 && ach <= Per80) {
                                 var EScore = Per80;
                                 $('#applogscore' + index).text(Per80);
      
                             } else if (ach >= Per81 && ach <= Per85) {
                                 var EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach >= Per86 && ach <= Per90) {
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach >= Per91) {
                                 var EScore = Per110;
                                 $('#applogscore' + index).text(Per110);
      
                             } else {
                                 var EScore = applogscore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
      
                         else if (logic === 'Logic14b') {
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100; 
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                             var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                             var Per86 = Math.round((target - Per14) * 100) / 100;
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                             var Per85 = Math.round((target - Per15) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                             var Per60 = Math.round((target - Per40) * 100) / 100;
      
                             if (ach <= Per80) {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             } else if (ach >= Per81 && ach <= Per85) {
                                 var EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach >= Per86 && ach <= Per90) {
                                 var EScore = Per110;
                                 $('#applogscore' + index).text(Per110);
      
                             } else if (ach >= Per91 && ach <= Per95) {
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach >= Per96) {
                                 var EScore = Per60;
                                 $('#applogscore' + index).text(Per60);
      
                             } else {
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
      
                         }
                         else if (logic === 'Logic15a') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100;
                             var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per60 = Math.round((target - Per40) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per96) {
                                 EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             } else if (ach >= Per96 && ach < Per97) {
                                 EScore = Per50;
                                 $('#applogscore' + index).text(Per50);
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per60;
                                 $('#applogscore' + index).text(Per60);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach >= Per99) {
                                 EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2));
      
                         } 
                         else if (logic === 'Logic15b') {
                             var Per05 = Math.round(((target * 0.5) / 100) * 100) / 100;
                             var Per995 = Math.round((target - Per05) * 100) / 100;
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per97) {
                                 EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per70;
                                 $('#applogscore' + index).text(Per70);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                             } else if (ach >= Per99 && ach < Per995) {
                                 EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach >= Per995) {
                                 EScore = Per110;
                                 $('#applogscore' + index).text(Per110);
      
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2));
      
                         }    
                         else if (logic === 'Logic15c') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100;
                             var Per60 = Math.round((target - Per40) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per96) {
                                 EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                             } else if (ach >= Per96 && ach < Per97) {
                                 EScore = Per60;
                                 $('#applogscore' + index).text(Per60);
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per80;
                                 $('#applogscore' + index).text(Per80);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = target;
                                 $('#applogscore' + index).text(target);
      
                             } else if (ach >= Per99) {
                                 EScore = Per110;
                                 $('#applogscore' + index).text(Per110);
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2));
                         }
                         else if (logic === 'Logic16') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per6 = Math.round(((target * 6) / 100) * 100) / 100; var Per94 = Math.round((target - Per6) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100; var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per105 = Math.round((target + Per5) * 100) / 100; var Per106 = Math.round((target + Per6) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100; var Per111 = Math.round((target + Per10 + Per1) * 100) / 100;
                             var Per115 = Math.round((target + Per10 + Per5) * 100) / 100;
      
                             if (ach >= Per90 && ach <= Per94) { 
                                 var EScore = Per110; 
                                 $('#applogscore' + index).text(Per110);
      
                             }
                             else if (ach >= Per95 && ach <= Per99) { 
                                 var EScore = Per105; 
                                 $('#applogscore' + index).text(Per105);
      
                             }
                             else if (ach >= target && ach <= Per105) { 
                                 var EScore = target; 
                                 $('#applogscore' + index).text(target);
      
                             }
                             else if (ach >= Per106 && ach <= Per110) {
                                 var EScore = Per95; 
                                 $('#applogscore' + index).text(Per95);
      
                             }
                             else if (ach >= Per111) { 
                                 var EScore = Per90; 
                                 $('#applogscore' + index).text(Per90);
      
                             }
                             else {
                                  var EScore = 0; 
                                  $('#applogscore' + index).text('0');
      
                                 }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic17') {
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100;
                             var Per16 = Math.round(((target * 16) / 100) * 100) / 100;
                             var Per22 = Math.round(((target * 22) / 100) * 100) / 100;
                             var Per23 = Math.round(((target * 23) / 100) * 100) / 100;
                             var Per29 = Math.round(((target * 29) / 100) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             var Per36 = Math.round(((target * 36) / 100) * 100) / 100;
                             var Per37 = Math.round(((target * 37) / 100) * 100) / 100;
                             var Per42 = Math.round(((target * 42) / 100) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per90 = Math.round(((target * 90) / 100) * 100) / 100;
      
                             if (ach <= Per15) { 
                                 var EScore = target; 
                                 $('#applogscore' + index).text(target);
      
                             }
                             else if (ach > Per15 && ach <= Per22) {
                                  var EScore = Per90;
                                 $('#applogscore' + index).text(Per90);
      
                                  }
                             else if (ach > Per22 && ach <= Per29) { 
                                 var EScore = Per80; 
                                 $('#applogscore' + index).text(Per80);
      
                             }
                             else if (ach > Per29 && ach <= Per36) {
                                  var EScore = Per75; 
                                  $('#applogscore' + index).text(Per75);
      
                                 }
                             else if (ach > Per36 && ach <= Per42) { 
                                 var EScore = Per50; 
      
                             }
                             else if (ach > Per42) { 
                                 var EScore = 0; 
                                 $('#applogscore' + index).text('0');
      
                             }
                             else { var EScore = 0; 
                                 $('#applogscore' + index).text('0');
      
                             }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic18') {
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per60 = Math.round(((target * 60) / 100) * 100) / 100;
                             var Per69 = Math.round(((target * 69) / 100) * 100) / 100;
                             var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                             var Per79 = Math.round(((target * 79) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per25 = Math.round(((target * 25) / 100) * 100) / 100;
                             var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
      
                             if (ach < Per60) { 
                                 var EScore = 0;
                              }
                             else if (ach >= Per60 && ach <= Per69) { 
                                 var EScore = Per25; 
                                 $('#applogscore' + index).text(Per25);
      
                             }
                             else if (ach >= Per70 && ach <= Per79) { 
                                 var EScore = Per50;
                                 $('#applogscore' + index).text(Per50);
      
                              }
                             else if (ach >= Per80 && ach <= Per120) { 
                                 var EScore = target;
                                 $('#applogscore' + index).text(target);
      
                              }
                             else { 
                                 var EScore = 0; 
                                 $('#applogscore' + index).text('0');
      
                             }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic19') {
                             var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
      
                             if (ach < Per70) { 
                                 var EScore = 0;
                              }
                             else if (ach >= Per70 && ach <= Per80) { 
                                 var EScore = Per50; 
                                 $('#applogscore' + index).text(Per50);
      
                             }
                             else if (ach >= Per80 && ach <= target) { 
                                 var EScore = target; 
                                 $('#applogscore' + index).text(target);
      
                             }
                             else { 
                                 var EScore = 0;
                                 $('#applogscore' + index).text('0');
      
                              }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#appscore' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                 
                 });
                 function saveRowData(index, tgtId, saveType) {
                         $('#loader').show(); // Show loader while saving
                         let selfRemark = $('#appselfremark' + index).val();
                         
                         // Check if selfRemark is empty
                         if (!selfRemark) {
                             // Add red border to indicate it's mandatory
                             $('#appselfremark' + index).css('border', '2px solid red');
                                                         
                             // Hide the loader and return early
                             $('#loader').hide();
                             return;
                         } else {
                             // Remove red border if it was previously added
                             $('#appselfremark' + index).css('border', '');
                         }
           
                         // Collect data from the row
                         let requestData = {
                             logscore: $('#applogscore' + index).text(),
                             tgtDefId: $('#tgt-id-' + index).val(),
                             selfRating: $('#appselfrating' + index).val(),
                             selfRemark: $('#appselfremark' + index).val(),
                             score: $('#appscore' + index).text(),
                             saveType: saveType,
                             _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                         };
           
                         console.log("Saving data:", requestData); // Debugging
           
                         $.ajax({
                             url: '/save-pms-row-app', // Laravel route
                             type: 'POST',
                             data: requestData,
                             dataType: 'json', // Ensure response is parsed as JSON
                             success: function(response) {
                                 $('#loader').hide(); // Hide loader on success
                                 if (response.success) {
                                     if (saveType === 'save') {
                                         toastr.success(response.message, 'Success', {
                                             positionClass: "toast-top-right",
                                             timeOut: 3000
                                         });
                                     } else if (saveType === 'submit') {
                                         toastr.success(response.message, 'Success', {
                                             positionClass: "toast-top-right",
                                             timeOut: 3000
                                         });
           
                                         setTimeout(function () {
                                             location.reload();
                                         }, 3000); // Reload after 3 seconds to allow the user to see the message
                                     }
           
                                 } else {
                                     toastr.error(response.message, 'Error', {
                                         positionClass: "toast-top-right",
                                         timeOut: 3000
                                     });
                                 }
                             },
                             error: function(xhr) {
                                 $('#loader').hide(); // Hide loader on error
                                 console.error("Save failed:", xhr.responseText);
           
                                 // Display error toast
                                 toastr.error('Failed to save data. Please try again.', 'Error', {
                                     positionClass: "toast-top-right",
                                     timeOut: 3000
                                 });
                             }
                         });
                 }
                   //annual rating appraisal
                 $(document).on('input', '.annual-rating-kra', function() {
                     let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                     let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                     let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                     let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                     var ach=Math.round(((target*annualratingkra)/100)*100)/100; //var ach=parseFloat(v);  
                     let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
           
                     if (logic === 'Logic1') {
                             // Calculate Per50, Per150, and the final EScore based on the provided logic
                             var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                             var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                             if (ach <= Per150) {
                                 var EScore = ach;
                                 $('#logScorekra' + index).text(ach); // Update only the respective row's score cell
      
                             } else {
                                 var EScore = Per150;
                                 $('#logScorekra' + index).text(Per150); // Update only the respective row's score cell
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                             
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
      
      
                         } 
                         else if (logic === 'Logic2') {
                             let EScore;
                             if (ach <= target) {
                                 EScore = ach;
                                 $('#logScorekra' + index).text(ach); // Update only the respective row's score cell
      
                             } else {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
      
      
      
                         }
                         else if (logic === 'Logic2a') {
                             let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             let Per110 = Math.round((target + Per10) * 100) / 100;
                             let EScore;
                             if (ach >= Per110) {
                                 EScore = Per110;
                                 $('#logScorekra' + index).text(Per110); // Update only the respective row's score cell
      
                             } else {
                                 EScore = ach;
                                 $('#logScorekra' + index).text(ach); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
      
      
                         }
                         else if (logic === 'Logic3') {
                             let EScore;
                                 if (ach === target) {
                                     EScore = ach;
                                     $('#logScorekra' + index).text(ach); // Update only the respective row's score cell
      
                                 } else {
                                     EScore = 0;
                                     $('#logScorekra' + index).text('0'); // Update only the respective row's score cell
      
                                 }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
                             
      
                         }
                     
                         if (logic === 'Logic4') {
                             // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                             let EScore;
                             if (ach >= target) {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target); // Update only the respective row's score cell
      
                             } else {
                                 EScore = 0;
                                 $('#logScorekra' + index).text('0'); // Update only the respective row's score cell
      
                             }
      
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell\
                             updategrandscore();
      
      
                         }
                         else if (logic === 'Logic5') {
                             let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             let Per70 = Math.round((target - Per30) * 100) / 100;
                             let EScore = 0;
                             if (ach >= Per70 && ach < target) {
                                 EScore = ach;
                                 $('#logScorekra' + index).text(ach); // Update only the respective row's score cell
      
                             } else if (ach >= target) {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target); // Update only the respective row's score cell
      
                             }
                             else{
                                 $('#logScorekra' + index).text('0'); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         if (logic === 'Logic6a') {
                             // Logic6a Logic
                                 if (target == 8.33) {
                                     ach = ach * 12;
                                 } else if (target == 25) {
                                     ach = ach * 4;
                                 } else if (target == 50) {
                                     ach = ach * 2;
                                 }
                                 else{
                                     ach=ach;
                                 }
                                 
                                 let Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                                 let Per50 = Math.round(((target * 50) / 100) * 100) / 100;
      
                                 if (ach <= 15) {
                                     EScore = target;
                                     $('#logScorekra' + index).text(target); // Update only the respective row's score cell
      
                                 } else if (ach > 15 && ach <= 20) {
                                     EScore = Per80;
                                     $('#logScorekra' + index).text(Per80); // Update only the respective row's score cell
      
                                 } else if (ach > 20 && ach <= 25) {
                                     EScore = Per50;
                                     $('#logScorekra' + index).text(Per50); // Update only the respective row's score cell
      
                                 } else {
                                     EScore = 0;
                                     $('#logScorekra' + index).text('0'); // Update only the respective row's score cell
                                 }
                                 MScore = Math.round(((EScore / target) * weight) * 100) / 100;
      
                                 $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                         updategrandscore();
      
      
                         }
                         else if (logic === 'Logic6b') {
                             // Logic6B Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
                             else{
                                 ach=ach;
                             }
      
                             if (ach < 5) {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target); // Update only the respective row's score cell
      
                             } else {
                                 EScore = 0;
                                 $('#logScorekra' + index).text('0'); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
      
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic6') {
                             // Logic6 Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
                             else{
                                 ach=ach;
                             }
      
                             let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                             let Per125 = Math.round(((target * 125) / 100) * 100) / 100;
                             let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                             let Per85 = Math.round(((target * 85) / 100) * 100) / 100;
                             let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                             let PerAct = Math.round(((target * ach) / 100) * 100) / 100;
                             let ScoAct = Math.round((target - PerAct) * 100) / 100;
      
                             if (ach <= 10) {
                                 MScore = Per150;
                                 $('#logScorekra' + index).text(Per150);
      
                             } else if (ach > 10 && ach <= 15) {
                                 MScore = Per125;
                                 $('#logScorekra' + index).text(Per125);
      
                             } else if (ach > 15 && ach <= 20) {
                                 MScore = Per100;
                                 $('#logScorekra' + index).text(Per100);
      
                             } else if (ach > 20 && ach <= 25) {
                                 MScore = Per85;
                                 $('#logScorekra' + index).text(Per85);
      
                             } else if (ach > 25 && ach <= 30) {
                                 MScore = Per75;
                                 $('#logScorekra' + index).text(Per75);
      
                             } 
                             else {
                                 MScore = 0;
                                 $('#logScorekra' + index).text('0');
                             }
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic7') {
                             // Logic7 Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
      
                             let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                             let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                             let Per90 = Math.round(((target * 90) / 100) * 100) / 100;
                             let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
      
                             if (ach == 0) {
                                 MScore = Per150;
                                 $('#logScorekra' + index).text(Per150);
      
                             } else if (ach > 0 && ach <= 2) {
                                 MScore = Per100;
                                 $('#logScorekra' + index).text(Per100);
      
                             } else if (ach > 2 && ach <= 5) {
                                 MScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach > 5 && ach <= 10) {
                                 MScore = Per75;
                                 $('#logScorekra' + index).text(Per75);
      
                             } else {
                                 MScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic8a' || logic === 'Logic8b' || logic === 'Logic8c' || logic === 'Logic8d' || logic === 'Logic8e') {
                             // Logic8 variations
                             let Percent = 0;
                             if (logic === 'Logic8a') {
                                 Percent = ((ach / target) * 115) / 100;
                             } else if (logic === 'Logic8b') {
                                 Percent = ((ach / target) * 100) / 100;
                             } else if (logic === 'Logic8c') {
                                 Percent = ((ach / target) * 90) / 100;
                             } else if (logic === 'Logic8d') {
                                 Percent = ((ach / target) * 65) / 100;
                             } else if (logic === 'Logic8e') {
                                 Percent = ((ach / target) * (-100)) / 100;
                             }
      
                             MScore = Math.round((Percent * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         // Logic9
                         else if (logic === 'Logic9') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             if (ach < Per90) {
                                 var EScore = ach;
                                 $('#logScorekra' + index).text(ach);
      
                             } else if (ach >= Per90) {
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else {
                                 var EScore = logScorekra = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic10
                         else if (logic === 'Logic10') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100; 
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100; 
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100; 
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                             var Per6 = Math.round(((target * 6) / 100) * 100) / 100; 
                             var Per7 = Math.round(((target * 7) / 100) * 100) / 100; 
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100; 
                             var Per91 = Math.round((Per90 + Per1) * 100) / 100;
                             var Per93 = Math.round((Per90 + Per3) * 100) / 100; 
                             var Per94 = Math.round((target - Per6) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100; 
                             var Per98 = Math.round((target - Per2) * 100) / 100; 
                             var Per105 = Math.round((target + Per5) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per120 = Math.round((target + Per20) * 100) / 100;
      
                             if (ach < Per90) {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             } else if (ach == Per90) {
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach > Per90 && ach <= Per93) {
                                 var EScore = Per105;
                                 $('#logScorekra' + index).text(Per105);
      
                             } else if (ach > Per93 && ach <= Per97) {
                                 var EScore = Per110;
                                 $('#logScorekra' + index).text(Per110);
      
                             } else if (ach > Per97) {
                                 var EScore = Per120;
                                 $('#logScorekra' + index).text(Per120);
      
                             } else {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic11
                         else if (logic === 'Logic11') {
                             var EScore = ach;
                             $('#logScorekra' + index).text(ach);
      
                             var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic12
                         else if (logic === 'Logic12') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             if (ach < Per90) {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             } else if (ach >= Per90) {
                                 var EScore = ach;
                                 $('#logScorekra' + index).text(ach);
      
                             } else {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic13a
                         else if (logic === 'Logic13a') {
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                             var Per130 = Math.round((target + Per30) * 100) / 100;
                             var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                             var Per121 = Math.round((target + Per21) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per11 = Math.round(((target * 11) / 100) * 100) / 100; 
                             var Per111 = Math.round((target + Per11) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100;   
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per80 = Math.round((target - Per20) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100;  
      
                             if (ach <= Per80) {
                                 var EScore = Per80;
                                 $('#logScorekra' + index).text(Per80);
      
                             } else if (ach >= Per81 && ach <= Per90) {
                                 var EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach >= Per91 && ach <= Per110) {
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach >= Per111 && ach <= Per120) {
                                 var EScore = Per80;
                                 $('#logScorekra' + index).text(Per80);
      
                             } else if (ach >= Per121) {
                                 var EScore = Per70;
                                 $('#logScorekra' + index).text(Per70);
      
                             } else {
                                 var EScore = logScorekra = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic13b
                         else if (logic === 'Logic13b') {
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                             var Per140 = Math.round((target + Per40) * 100) / 100;
                             var Per31 = Math.round(((target * 31) / 100) * 100) / 100; 
                             var Per131 = Math.round((target + Per31) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                             var Per130 = Math.round((target + Per30) * 100) / 100;
                             var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                             var Per121 = Math.round((target + Per21) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per29 = Math.round(((target * 29) / 100) * 100) / 100; 
                             var Per71 = Math.round((target - Per29) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;  
      
                             if (ach <= Per70) {
                                 var EScore = Per70;
                                 $('#logScorekra' + index).text(Per70);
      
                             } else if (ach >= Per71 && ach <= Per80) {
                                 var EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach >= Per81 && ach <= Per120) {
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach >= Per121 && ach <= Per130) {
                                 var EScore = Per80;
                                 $('#logScorekra' + index).text(Per80);
      
                             } else if (ach >= Per131) {
                                 var EScore = Per70;
                                 $('#logScorekra' + index).text(Per70);
      
                             } else {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic14a
                         else if (logic === 'Logic14a') {
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                             var Per86 = Math.round((target - Per14) * 100) / 100;
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                             var Per85 = Math.round((target - Per15) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per24 = Math.round(((target * 24) / 100) * 100) / 100; 
                             var Per76 = Math.round((target - Per24) * 100) / 100;
                             var Per25 = Math.round(((target * 25) / 100) * 100) / 100; 
                             var Per75 = Math.round((target - Per25) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
      
                             if (ach <= Per75) {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
                             } else if (ach >= Per76 && ach <= Per80) {
                                 var EScore = Per80;
                                 $('#logScorekra' + index).text(Per80);
      
                             } else if (ach >= Per81 && ach <= Per85) {
                                 var EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach >= Per86 && ach <= Per90) {
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach >= Per91) {
                                 var EScore = Per110;
                                 $('#logScorekra' + index).text(Per110);
      
                             } else {
                                 var EScore = logScorekra = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         else if (logic === 'Logic14b') {
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100; 
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                             var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                             var Per86 = Math.round((target - Per14) * 100) / 100;
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                             var Per85 = Math.round((target - Per15) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                             var Per60 = Math.round((target - Per40) * 100) / 100;
      
                             if (ach <= Per80) {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             } else if (ach >= Per81 && ach <= Per85) {
                                 var EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach >= Per86 && ach <= Per90) {
                                 var EScore = Per110;
                                 $('#logScorekra' + index).text(Per110);
      
                             } else if (ach >= Per91 && ach <= Per95) {
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach >= Per96) {
                                 var EScore = Per60;
                                 $('#logScorekra' + index).text(Per60);
      
                             } else {
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic15a') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100;
                             var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per60 = Math.round((target - Per40) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per96) {
                                 EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             } else if (ach >= Per96 && ach < Per97) {
                                 EScore = Per50;
                                 $('#logScorekra' + index).text(Per50);
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per60;
                                 $('#logScorekra' + index).text(Per60);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach >= Per99) {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2));
      
                         } 
                         else if (logic === 'Logic15b') {
                             var Per05 = Math.round(((target * 0.5) / 100) * 100) / 100;
                             var Per995 = Math.round((target - Per05) * 100) / 100;
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per97) {
                                 EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per70;
                                 $('#logScorekra' + index).text(Per70);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                             } else if (ach >= Per99 && ach < Per995) {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach >= Per995) {
                                 EScore = Per110;
                                 $('#logScorekra' + index).text(Per110);
      
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2));
      
                         }    
                         else if (logic === 'Logic15c') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100;
                             var Per60 = Math.round((target - Per40) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per96) {
                                 EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                             } else if (ach >= Per96 && ach < Per97) {
                                 EScore = Per60;
                                 $('#logScorekra' + index).text(Per60);
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per80;
                                 $('#logScorekra' + index).text(Per80);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                             } else if (ach >= Per99) {
                                 EScore = Per110;
                                 $('#logScorekra' + index).text(Per110);
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2));
                         }
                         else if (logic === 'Logic16') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per6 = Math.round(((target * 6) / 100) * 100) / 100; var Per94 = Math.round((target - Per6) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100; var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per105 = Math.round((target + Per5) * 100) / 100; var Per106 = Math.round((target + Per6) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100; var Per111 = Math.round((target + Per10 + Per1) * 100) / 100;
                             var Per115 = Math.round((target + Per10 + Per5) * 100) / 100;
      
                             if (ach >= Per90 && ach <= Per94) { 
                                 var EScore = Per110; 
                                 $('#logScorekra' + index).text(Per110);
      
                             }
                             else if (ach >= Per95 && ach <= Per99) { 
                                 var EScore = Per105; 
                                 $('#logScorekra' + index).text(Per105);
      
                             }
                             else if (ach >= target && ach <= Per105) { 
                                 var EScore = target; 
                                 $('#logScorekra' + index).text(target);
      
                             }
                             else if (ach >= Per106 && ach <= Per110) {
                                 var EScore = Per95; 
                                 $('#logScorekra' + index).text(Per95);
      
                             }
                             else if (ach >= Per111) { 
                                 var EScore = Per90; 
                                 $('#logScorekra' + index).text(Per90);
      
                             }
                             else {
                                  var EScore = 0; 
                                  $('#logScorekra' + index).text('0');
      
                                 }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic17') {
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100;
                             var Per16 = Math.round(((target * 16) / 100) * 100) / 100;
                             var Per22 = Math.round(((target * 22) / 100) * 100) / 100;
                             var Per23 = Math.round(((target * 23) / 100) * 100) / 100;
                             var Per29 = Math.round(((target * 29) / 100) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             var Per36 = Math.round(((target * 36) / 100) * 100) / 100;
                             var Per37 = Math.round(((target * 37) / 100) * 100) / 100;
                             var Per42 = Math.round(((target * 42) / 100) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per90 = Math.round(((target * 90) / 100) * 100) / 100;
      
                             if (ach <= Per15) { 
                                 var EScore = target; 
                                 $('#logScorekra' + index).text(target);
      
                             }
                             else if (ach > Per15 && ach <= Per22) {
                                  var EScore = Per90;
                                 $('#logScorekra' + index).text(Per90);
      
                                  }
                             else if (ach > Per22 && ach <= Per29) { 
                                 var EScore = Per80; 
                                 $('#logScorekra' + index).text(Per80);
      
                             }
                             else if (ach > Per29 && ach <= Per36) {
                                  var EScore = Per75; 
                                  $('#logScorekra' + index).text(Per75);
      
                                 }
                             else if (ach > Per36 && ach <= Per42) { 
                                 var EScore = Per50; 
      
                             }
                             else if (ach > Per42) { 
                                 var EScore = 0; 
                                 $('#logScorekra' + index).text('0');
      
                             }
                             else { var EScore = 0; 
                                 $('#logScorekra' + index).text('0');
      
                             }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic18') {
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per60 = Math.round(((target * 60) / 100) * 100) / 100;
                             var Per69 = Math.round(((target * 69) / 100) * 100) / 100;
                             var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                             var Per79 = Math.round(((target * 79) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per25 = Math.round(((target * 25) / 100) * 100) / 100;
                             var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
      
                             if (ach < Per60) { 
                                 var EScore = 0;
                              }
                             else if (ach >= Per60 && ach <= Per69) { 
                                 var EScore = Per25; 
                                 $('#logScorekra' + index).text(Per25);
      
                             }
                             else if (ach >= Per70 && ach <= Per79) { 
                                 var EScore = Per50;
                                 $('#logScorekra' + index).text(Per50);
      
                              }
                             else if (ach >= Per80 && ach <= Per120) { 
                                 var EScore = target;
                                 $('#logScorekra' + index).text(target);
      
                              }
                             else { 
                                 var EScore = 0; 
                                 $('#logScorekra' + index).text('0');
      
                             }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic19') {
                             var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
      
                             if (ach < Per70) { 
                                 var EScore = 0;
                              }
                             else if (ach >= Per70 && ach <= Per80) { 
                                 var EScore = Per50; 
                                 $('#logScorekra' + index).text(Per50);
      
                             }
                             else if (ach >= Per80 && ach <= target) { 
                                 var EScore = target; 
                                 $('#logScorekra' + index).text(target);
      
                             }
                             else { 
                                 var EScore = 0;
                                 $('#logScorekra' + index).text('0');
      
                              }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#krascorespan' + index).text(MScore.toFixed(2)); // Update the score for this row
                             updategrandscore();
                         }
                 
                 });
                 //subkraannual appraisal
                 $(document).on('input', '.annual-rating-subkra', function() {
                     let annualratingsubkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                     let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                     let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                     let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                     var ach=Math.round(((target*annualratingsubkra)/100)*100)/100; //var ach=parseFloat(v);  
                     let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
           
                     if (logic === 'Logic1') {
                             // Calculate Per50, Per150, and the final EScore based on the provided logic
                             var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                             var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                             if (ach <= Per150) {
                                 var EScore = ach;
                                 $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell
      
                             } else {
                                 var EScore = Per150;
                                 $('#logscoresubkra' + index).text(Per150); // Update only the respective row's score cell
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                             
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
      
      
                         } 
                         else if (logic === 'Logic2') {
                             let EScore;
                             if (ach <= target) {
                                 EScore = ach;
                                 $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell
      
                             } else {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
      
      
      
                         }
                         else if (logic === 'Logic2a') {
                             let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             let Per110 = Math.round((target + Per10) * 100) / 100;
                             let EScore;
                             if (ach >= Per110) {
                                 EScore = Per110;
                                 $('#logscoresubkra' + index).text(Per110); // Update only the respective row's score cell
      
                             } else {
                                 EScore = ach;
                                 $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
      
      
                         }
                         else if (logic === 'Logic3') {
                             let EScore;
                                 if (ach === target) {
                                     EScore = ach;
                                     $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell
      
                                 } else {
                                     EScore = 0;
                                     $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell
      
                                 }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                             updategrandscore();
                             
      
                         }
                     
                         if (logic === 'Logic4') {
                             // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                             let EScore;
                             if (ach >= target) {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell
      
                             } else {
                                 EScore = 0;
                                 $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell
      
                             }
      
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell\
                             updategrandscore();
      
      
                         }
                         else if (logic === 'Logic5') {
                             let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             let Per70 = Math.round((target - Per30) * 100) / 100;
                             let EScore = 0;
                             if (ach >= Per70 && ach < target) {
                                 EScore = ach;
                                 $('#logscoresubkra' + index).text(ach); // Update only the respective row's score cell
      
                             } else if (ach >= target) {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell
      
                             }
                             else{
                                 $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         if (logic === 'Logic6a') {
                             // Logic6a Logic
                                 if (target == 8.33) {
                                     ach = ach * 12;
                                 } else if (target == 25) {
                                     ach = ach * 4;
                                 } else if (target == 50) {
                                     ach = ach * 2;
                                 }
                                 else{
                                     ach=ach;
                                 }
                                 
                                 let Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                                 let Per50 = Math.round(((target * 50) / 100) * 100) / 100;
      
                                 if (ach <= 15) {
                                     EScore = target;
                                     $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell
      
                                 } else if (ach > 15 && ach <= 20) {
                                     EScore = Per80;
                                     $('#logscoresubkra' + index).text(Per80); // Update only the respective row's score cell
      
                                 } else if (ach > 20 && ach <= 25) {
                                     EScore = Per50;
                                     $('#logscoresubkra' + index).text(Per50); // Update only the respective row's score cell
      
                                 } else {
                                     EScore = 0;
                                     $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell
                                 }
                                 MScore = Math.round(((EScore / target) * weight) * 100) / 100;
      
                                 $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                         updategrandscore();
      
      
                         }
                         else if (logic === 'Logic6b') {
                             // Logic6B Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
                             else{
                                 ach=ach;
                             }
      
                             if (ach < 5) {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target); // Update only the respective row's score cell
      
                             } else {
                                 EScore = 0;
                                 $('#logscoresubkra' + index).text('0'); // Update only the respective row's score cell
      
                             }
                             MScore = Math.round(((EScore / target) * weight) * 100) / 100;
      
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic6') {
                             // Logic6 Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
                             else{
                                 ach=ach;
                             }
      
                             let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                             let Per125 = Math.round(((target * 125) / 100) * 100) / 100;
                             let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                             let Per85 = Math.round(((target * 85) / 100) * 100) / 100;
                             let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                             let PerAct = Math.round(((target * ach) / 100) * 100) / 100;
                             let ScoAct = Math.round((target - PerAct) * 100) / 100;
      
                             if (ach <= 10) {
                                 MScore = Per150;
                                 $('#logscoresubkra' + index).text(Per150);
      
                             } else if (ach > 10 && ach <= 15) {
                                 MScore = Per125;
                                 $('#logscoresubkra' + index).text(Per125);
      
                             } else if (ach > 15 && ach <= 20) {
                                 MScore = Per100;
                                 $('#logscoresubkra' + index).text(Per100);
      
                             } else if (ach > 20 && ach <= 25) {
                                 MScore = Per85;
                                 $('#logscoresubkra' + index).text(Per85);
      
                             } else if (ach > 25 && ach <= 30) {
                                 MScore = Per75;
                                 $('#logscoresubkra' + index).text(Per75);
      
                             } 
                             else {
                                 MScore = 0;
                                 $('#logscoresubkra' + index).text('0');
                             }
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic7') {
                             // Logic7 Logic
                             if (target == 8.33) {
                                 ach = ach * 12;
                             } else if (target == 25) {
                                 ach = ach * 4;
                             } else if (target == 50) {
                                 ach = ach * 2;
                             }
      
                             let Per150 = Math.round(((target * 150) / 100) * 100) / 100;
                             let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                             let Per90 = Math.round(((target * 90) / 100) * 100) / 100;
                             let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
      
                             if (ach == 0) {
                                 MScore = Per150;
                                 $('#logscoresubkra' + index).text(Per150);
      
                             } else if (ach > 0 && ach <= 2) {
                                 MScore = Per100;
                                 $('#logscoresubkra' + index).text(Per100);
      
                             } else if (ach > 2 && ach <= 5) {
                                 MScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach > 5 && ach <= 10) {
                                 MScore = Per75;
                                 $('#logscoresubkra' + index).text(Per75);
      
                             } else {
                                 MScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic8a' || logic === 'Logic8b' || logic === 'Logic8c' || logic === 'Logic8d' || logic === 'Logic8e') {
                             // Logic8 variations
                             let Percent = 0;
                             if (logic === 'Logic8a') {
                                 Percent = ((ach / target) * 115) / 100;
                             } else if (logic === 'Logic8b') {
                                 Percent = ((ach / target) * 100) / 100;
                             } else if (logic === 'Logic8c') {
                                 Percent = ((ach / target) * 90) / 100;
                             } else if (logic === 'Logic8d') {
                                 Percent = ((ach / target) * 65) / 100;
                             } else if (logic === 'Logic8e') {
                                 Percent = ((ach / target) * (-100)) / 100;
                             }
      
                             MScore = Math.round((Percent * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         // Logic9
                         else if (logic === 'Logic9') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             if (ach < Per90) {
                                 var EScore = ach;
                                 $('#logscoresubkra' + index).text(ach);
      
                             } else if (ach >= Per90) {
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else {
                                 var EScore = logscoresubkra = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic10
                         else if (logic === 'Logic10') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100; 
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100; 
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100; 
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                             var Per6 = Math.round(((target * 6) / 100) * 100) / 100; 
                             var Per7 = Math.round(((target * 7) / 100) * 100) / 100; 
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100; 
                             var Per91 = Math.round((Per90 + Per1) * 100) / 100;
                             var Per93 = Math.round((Per90 + Per3) * 100) / 100; 
                             var Per94 = Math.round((target - Per6) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100; 
                             var Per98 = Math.round((target - Per2) * 100) / 100; 
                             var Per105 = Math.round((target + Per5) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per120 = Math.round((target + Per20) * 100) / 100;
      
                             if (ach < Per90) {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             } else if (ach == Per90) {
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach > Per90 && ach <= Per93) {
                                 var EScore = Per105;
                                 $('#logscoresubkra' + index).text(Per105);
      
                             } else if (ach > Per93 && ach <= Per97) {
                                 var EScore = Per110;
                                 $('#logscoresubkra' + index).text(Per110);
      
                             } else if (ach > Per97) {
                                 var EScore = Per120;
                                 $('#logscoresubkra' + index).text(Per120);
      
                             } else {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic11
                         else if (logic === 'Logic11') {
                             var EScore = ach;
                             $('#logscoresubkra' + index).text(ach);
      
                             var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic12
                         else if (logic === 'Logic12') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             if (ach < Per90) {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             } else if (ach >= Per90) {
                                 var EScore = ach;
                                 $('#logscoresubkra' + index).text(ach);
      
                             } else {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic13a
                         else if (logic === 'Logic13a') {
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                             var Per130 = Math.round((target + Per30) * 100) / 100;
                             var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                             var Per121 = Math.round((target + Per21) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per11 = Math.round(((target * 11) / 100) * 100) / 100; 
                             var Per111 = Math.round((target + Per11) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100;   
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per80 = Math.round((target - Per20) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100;  
      
                             if (ach <= Per80) {
                                 var EScore = Per80;
                                 $('#logscoresubkra' + index).text(Per80);
      
                             } else if (ach >= Per81 && ach <= Per90) {
                                 var EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach >= Per91 && ach <= Per110) {
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach >= Per111 && ach <= Per120) {
                                 var EScore = Per80;
                                 $('#logscoresubkra' + index).text(Per80);
      
                             } else if (ach >= Per121) {
                                 var EScore = Per70;
                                 $('#logscoresubkra' + index).text(Per70);
      
                             } else {
                                 var EScore = logscoresubkra = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic13b
                         else if (logic === 'Logic13b') {
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                             var Per140 = Math.round((target + Per40) * 100) / 100;
                             var Per31 = Math.round(((target * 31) / 100) * 100) / 100; 
                             var Per131 = Math.round((target + Per31) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100; 
                             var Per130 = Math.round((target + Per30) * 100) / 100;
                             var Per21 = Math.round(((target * 21) / 100) * 100) / 100; 
                             var Per121 = Math.round((target + Per21) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per29 = Math.round(((target * 29) / 100) * 100) / 100; 
                             var Per71 = Math.round((target - Per29) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;  
      
                             if (ach <= Per70) {
                                 var EScore = Per70;
                                 $('#logscoresubkra' + index).text(Per70);
      
                             } else if (ach >= Per71 && ach <= Per80) {
                                 var EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach >= Per81 && ach <= Per120) {
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach >= Per121 && ach <= Per130) {
                                 var EScore = Per80;
                                 $('#logscoresubkra' + index).text(Per80);
      
                             } else if (ach >= Per131) {
                                 var EScore = Per70;
                                 $('#logscoresubkra' + index).text(Per70);
      
                             } else {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         // Logic14a
                         else if (logic === 'Logic14a') {
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                             var Per86 = Math.round((target - Per14) * 100) / 100;
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                             var Per85 = Math.round((target - Per15) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per24 = Math.round(((target * 24) / 100) * 100) / 100; 
                             var Per76 = Math.round((target - Per24) * 100) / 100;
                             var Per25 = Math.round(((target * 25) / 100) * 100) / 100; 
                             var Per75 = Math.round((target - Per25) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
      
                             if (ach <= Per75) {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
                             } else if (ach >= Per76 && ach <= Per80) {
                                 var EScore = Per80;
                                 $('#logscoresubkra' + index).text(Per80);
      
                             } else if (ach >= Per81 && ach <= Per85) {
                                 var EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach >= Per86 && ach <= Per90) {
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach >= Per91) {
                                 var EScore = Per110;
                                 $('#logscoresubkra' + index).text(Per110);
      
                             } else {
                                 var EScore = logscoresubkra = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
      
                         else if (logic === 'Logic14b') {
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100; 
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; 
                             var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per9 = Math.round(((target * 9) / 100) * 100) / 100; 
                             var Per91 = Math.round((target - Per9) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per14 = Math.round(((target * 14) / 100) * 100) / 100; 
                             var Per86 = Math.round((target - Per14) * 100) / 100;
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100; 
                             var Per85 = Math.round((target - Per15) * 100) / 100;
                             var Per19 = Math.round(((target * 19) / 100) * 100) / 100; 
                             var Per81 = Math.round((target - Per19) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100; 
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100; 
                             var Per60 = Math.round((target - Per40) * 100) / 100;
      
                             if (ach <= Per80) {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             } else if (ach >= Per81 && ach <= Per85) {
                                 var EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach >= Per86 && ach <= Per90) {
                                 var EScore = Per110;
                                 $('#logscoresubkra' + index).text(Per110);
      
                             } else if (ach >= Per91 && ach <= Per95) {
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach >= Per96) {
                                 var EScore = Per60;
                                 $('#logscoresubkra' + index).text(Per60);
      
                             } else {
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                                                     updategrandscore();
      
      
                         }
                         else if (logic === 'Logic15a') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100;
                             var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per60 = Math.round((target - Per40) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per96) {
                                 EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             } else if (ach >= Per96 && ach < Per97) {
                                 EScore = Per50;
                                 $('#logscoresubkra' + index).text(Per50);
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per60;
                                 $('#logscoresubkra' + index).text(Per60);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach >= Per99) {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2));
      
                         } 
                         else if (logic === 'Logic15b') {
                             var Per05 = Math.round(((target * 0.5) / 100) * 100) / 100;
                             var Per995 = Math.round((target - Per05) * 100) / 100;
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             var Per70 = Math.round((target - Per30) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per97) {
                                 EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per70;
                                 $('#logscoresubkra' + index).text(Per70);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                             } else if (ach >= Per99 && ach < Per995) {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach >= Per995) {
                                 EScore = Per110;
                                 $('#logscoresubkra' + index).text(Per110);
      
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2));
      
                         }    
                         else if (logic === 'Logic15c') {
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100;
                             var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per2 = Math.round(((target * 2) / 100) * 100) / 100;
                             var Per98 = Math.round((target - Per2) * 100) / 100;
                             var Per3 = Math.round(((target * 3) / 100) * 100) / 100;
                             var Per97 = Math.round((target - Per3) * 100) / 100;
                             var Per4 = Math.round(((target * 4) / 100) * 100) / 100;
                             var Per96 = Math.round((target - Per4) * 100) / 100;
                             var Per40 = Math.round(((target * 40) / 100) * 100) / 100;
                             var Per60 = Math.round((target - Per40) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per80 = Math.round((target - Per20) * 100) / 100;
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100;
                             
                             var EScore = 0;
                             if (ach < Per96) {
                                 EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                             } else if (ach >= Per96 && ach < Per97) {
                                 EScore = Per60;
                                 $('#logscoresubkra' + index).text(Per60);
      
                             } else if (ach >= Per97 && ach < Per98) {
                                 EScore = Per80;
                                 $('#logscoresubkra' + index).text(Per80);
      
                             } else if (ach >= Per98 && ach < Per99) {
                                 EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                             } else if (ach >= Per99) {
                                 EScore = Per110;
                                 $('#logscoresubkra' + index).text(Per110);
                             }
                             
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2));
                         }
                         else if (logic === 'Logic16') {
                             var Per10 = Math.round(((target * 10) / 100) * 100) / 100; var Per90 = Math.round((target - Per10) * 100) / 100;
                             var Per6 = Math.round(((target * 6) / 100) * 100) / 100; var Per94 = Math.round((target - Per6) * 100) / 100;
                             var Per5 = Math.round(((target * 5) / 100) * 100) / 100; var Per95 = Math.round((target - Per5) * 100) / 100;
                             var Per1 = Math.round(((target * 1) / 100) * 100) / 100; var Per99 = Math.round((target - Per1) * 100) / 100;
                             var Per105 = Math.round((target + Per5) * 100) / 100; var Per106 = Math.round((target + Per6) * 100) / 100;
                             var Per110 = Math.round((target + Per10) * 100) / 100; var Per111 = Math.round((target + Per10 + Per1) * 100) / 100;
                             var Per115 = Math.round((target + Per10 + Per5) * 100) / 100;
      
                             if (ach >= Per90 && ach <= Per94) { 
                                 var EScore = Per110; 
                                 $('#logscoresubkra' + index).text(Per110);
      
                             }
                             else if (ach >= Per95 && ach <= Per99) { 
                                 var EScore = Per105; 
                                 $('#logscoresubkra' + index).text(Per105);
      
                             }
                             else if (ach >= target && ach <= Per105) { 
                                 var EScore = target; 
                                 $('#logscoresubkra' + index).text(target);
      
                             }
                             else if (ach >= Per106 && ach <= Per110) {
                                 var EScore = Per95; 
                                 $('#logscoresubkra' + index).text(Per95);
      
                             }
                             else if (ach >= Per111) { 
                                 var EScore = Per90; 
                                 $('#logscoresubkra' + index).text(Per90);
      
                             }
                             else {
                                  var EScore = 0; 
                                  $('#logscoresubkra' + index).text('0');
      
                                 }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic17') {
                             var Per15 = Math.round(((target * 15) / 100) * 100) / 100;
                             var Per16 = Math.round(((target * 16) / 100) * 100) / 100;
                             var Per22 = Math.round(((target * 22) / 100) * 100) / 100;
                             var Per23 = Math.round(((target * 23) / 100) * 100) / 100;
                             var Per29 = Math.round(((target * 29) / 100) * 100) / 100;
                             var Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                             var Per36 = Math.round(((target * 36) / 100) * 100) / 100;
                             var Per37 = Math.round(((target * 37) / 100) * 100) / 100;
                             var Per42 = Math.round(((target * 42) / 100) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per90 = Math.round(((target * 90) / 100) * 100) / 100;
      
                             if (ach <= Per15) { 
                                 var EScore = target; 
                                 $('#logscoresubkra' + index).text(target);
      
                             }
                             else if (ach > Per15 && ach <= Per22) {
                                  var EScore = Per90;
                                 $('#logscoresubkra' + index).text(Per90);
      
                                  }
                             else if (ach > Per22 && ach <= Per29) { 
                                 var EScore = Per80; 
                                 $('#logscoresubkra' + index).text(Per80);
      
                             }
                             else if (ach > Per29 && ach <= Per36) {
                                  var EScore = Per75; 
                                  $('#logscoresubkra' + index).text(Per75);
      
                                 }
                             else if (ach > Per36 && ach <= Per42) { 
                                 var EScore = Per50; 
      
                             }
                             else if (ach > Per42) { 
                                 var EScore = 0; 
                                 $('#logscoresubkra' + index).text('0');
      
                             }
                             else { var EScore = 0; 
                                 $('#logscoresubkra' + index).text('0');
      
                             }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic18') {
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
                             var Per60 = Math.round(((target * 60) / 100) * 100) / 100;
                             var Per69 = Math.round(((target * 69) / 100) * 100) / 100;
                             var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                             var Per79 = Math.round(((target * 79) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per20 = Math.round(((target * 20) / 100) * 100) / 100;
                             var Per120 = Math.round((target + Per20) * 100) / 100;
                             var Per25 = Math.round(((target * 25) / 100) * 100) / 100;
                             var Per75 = Math.round(((target * 75) / 100) * 100) / 100;
      
                             if (ach < Per60) { 
                                 var EScore = 0;
                              }
                             else if (ach >= Per60 && ach <= Per69) { 
                                 var EScore = Per25; 
                                 $('#logscoresubkra' + index).text(Per25);
      
                             }
                             else if (ach >= Per70 && ach <= Per79) { 
                                 var EScore = Per50;
                                 $('#logscoresubkra' + index).text(Per50);
      
                              }
                             else if (ach >= Per80 && ach <= Per120) { 
                                 var EScore = target;
                                 $('#logscoresubkra' + index).text(target);
      
                              }
                             else { 
                                 var EScore = 0; 
                                 $('#logscoresubkra' + index).text('0');
      
                             }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                         }
                         else if (logic === 'Logic19') {
                             var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                             var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                             var Per50 = Math.round(((target * 50) / 100) * 100) / 100;
      
                             if (ach < Per70) { 
                                 var EScore = 0;
                              }
                             else if (ach >= Per70 && ach <= Per80) { 
                                 var EScore = Per50; 
                                 $('#logscoresubkra' + index).text(Per50);
      
                             }
                             else if (ach >= Per80 && ach <= target) { 
                                 var EScore = target; 
                                 $('#logscoresubkra' + index).text(target);
      
                             }
                             else { 
                                 var EScore = 0;
                                 $('#logscoresubkra' + index).text('0');
      
                              }
      
                             var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                             $('#subkrascoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                             updategrandscore();
                         }
           
                 });
           
                 function updategrandscore() {
                 let total = 0;
                 let lastTotal = parseFloat($("#grandtotalfinalemp").text()) || 0;
           
                 console.log("updategrandscore() called");
           
                 $('[id^="krascorespan"], [id^="subkrascoreforma"]').each(function () {
                     let elementId = $(this).attr('id'); // Get full element ID
           
                     let value = $(this).is("span") ? $(this).text().trim() : $(this).text().trim();
                     let numericValue = parseFloat(value);
           
                     // ✅ If value is 0, check text content
                     if (numericValue === 0) {
                         let textValue = $(this).text().trim();
                         let textNumeric = parseFloat(textValue);
                         if (!isNaN(textNumeric)) {
                             numericValue = textNumeric; // Use text if valid
                         }
                     }
           
                     numericValue = isNaN(numericValue) ? 0 : numericValue; // Ensure valid number
           
                     console.log(`Processing ID: ${elementId}, Used Value: ${numericValue}`);
           
                     total += numericValue; // ✅ SUM all valid values
                 });
           
                 // ✅ Only update UI if total changed
                 if (lastTotal !== total.toFixed(2)) {
                     console.log("Final Grand Total:", total);
                     $("#grandtotalfinalemp").text(total.toFixed(2));
                     $("#pmsscoreforma").text(total.toFixed(2)); 
           
                     var pmsscoreforma = parseFloat($("#pmsscoreforma").text()) || 0; 
                     var formawgt = parseFloat($("#formawgt").text()) || 0; 
           
                     var formaperwgt = (pmsscoreforma * formawgt) / 100;
           
                     $("#formasperwgt").text(formaperwgt.toFixed(2));
           
                     $("#totaladdb").text(
                         (parseFloat($("#formasperwgt").text()) || 0) + (parseFloat($("#pmsscoreformbasperwgt").text()) || 0)
                     ).toFixed(2); // Set the grand total value with 2 decimal points
           
           
           
                 } else {
                     console.log("No change in total, skipping UI update.");
                 }
             }
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
      
      // $(document).ready(function () {
         //     // Function to filter the rows based on selected department and HQ
         //     function filterTable() {
         //         var departmentFilter = $('#departmentDropdown').val().toLowerCase();
         //         var hqFilter = $('#hqDropdown').val().toLowerCase();
      
         //         // Loop through all rows in the table body
         //         $('#employeeTableBody tr').each(function () {
         //             var department = $(this).data('department').toLowerCase();
         //             var hq = $(this).data('hq').toLowerCase();
      
         //             // Show row if it matches the filter or if no filter is applied
         //             if ((departmentFilter === '' || department.includes(departmentFilter)) && 
         //                 (hqFilter === '' || hq.includes(hqFilter))) {
         //                 $(this).show(); // Show row
         //             } else {
         //                 $(this).hide(); // Hide row
         //             }
         //         });
         //     }
      
         //     // Attach the filterTable function to the change event of the dropdowns
         //     $('#departmentDropdown, #hqDropdown').on('change', function () {
         //         filterTable();
         //     });
      
         //     // Initialize table to show all rows by default when the page loads
         //     filterTable(); // This ensures all rows are shown when the page loads without applying filters.
         // });
      
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
      function OpenEditWindow(encryptedEmpPmsId) {
                let url = `/edit-appraisal/${encryptedEmpPmsId}`;
                let win = window.open(url, '_blank', 'width=1350,height=600,scrollbars=yes');

                // Check every second if the popup is closed
                let timer = setInterval(function () {
                    if (win.closed) {
                        clearInterval(timer);
                        location.reload(); // Refresh parent window
                    }
                }, 1000);
            }

        function OpenViewWindow(encryptedEmpPmsId) {
      	    let url = `/view-appraiser/${encryptedEmpPmsId}`;
      		window.open(url, '_blank', 'width=1350,height=600,scrollbars=yes');
      	}
      
      	$(document).ready(function() {
         // Function to filter the table based on selected filters
         function filterTable() {
             var department = $('#department-filter').val().toLowerCase();
             var state = $('#state-filter').val().toLowerCase();
             var hq = $('#hq-filter').val().toLowerCase();
      
             // Iterate over each table row and apply filters
             $('#employeetable tbody tr').each(function() {
                 var rowDepartment = $(this).find('td:nth-child(4)').text().toLowerCase();
                 var rowState = $(this).find('td:nth-child(6)').text().toLowerCase();
                 var rowHQ = $(this).find('td:nth-child(7)').text().toLowerCase();
      
                 // Check if the row matches all selected filters
                 if ((department === "" || rowDepartment.indexOf(department) !== -1) &&
                     (state === "" || rowState.indexOf(state) !== -1) &&
                     (hq === "" || rowHQ.indexOf(hq) !== -1)) {
                     $(this).show();  // Show row if it matches the filters
                 } else {
                     $(this).hide();  // Hide row if it doesn't match
                 }
             });
         }
      
         // Trigger the filter function when any dropdown value changes
         $('#department-filter, #state-filter, #hq-filter').change(function() {
             filterTable();
         });
      
         // Initial filter application in case any filter is pre-selected
         filterTable();
      });
      document.addEventListener("DOMContentLoaded", function () {
         let revertModal = document.getElementById("resubmitKRA");
      
         revertModal.addEventListener("show.bs.modal", function (event) {
             let button = event.relatedTarget; // Button that triggered the modal
             let empPmsId = button.getAttribute("data-emppmsid");
             $('#revertNote').val(''); // Also clear when opened
      
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
      
             fetch("/revert-pms-app", {
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
      $('.rating-graph').click(function() {
      	$('.rating-graphshow').show();
      	$('.team-appraisalbox').hide();
      });
      $('#team_appraisal_tab20').click(function() {
      	$('.rating-graphshow').hide();
      	$('.team-appraisalbox').show();
      });
         document.addEventListener("DOMContentLoaded", function () {
         const ratingData = @json($ratingData); // Original dataset
         const ratingDataEmployee = @json($ratingDataEmployee); // New dataset
         const overallrating = @json($overallrating); // New dataset

      
         const ratings = @json($ratings).map(rating => rating.toFixed(1));
      
         // Prepare data values for both datasets
         const dataValues = ratings.map(rating => ratingData[rating] ?? null);
         const dataValuesEmployee = ratings.map(rating => ratingDataEmployee[rating] ?? null);
         const dataValuesOverall = ratings.map(rating => overallrating[rating] ?? null);
      
         const ctx = document.getElementById("appraiserChart").getContext("2d");
      
         new Chart(ctx, {
             type: "line",
             data: {
                 labels: ratings, // X-axis → Ratings
                 datasets: [
                    {
                        label: "Overall Rating",
                        data: overallrating, // Y-axis → Employee count (Original)
                        borderColor: "rgba(0, 123, 255, 0.9)", // New color (e.g., blue with opacity)
                        borderWidth: 4,
                        pointRadius: 7, // Bigger points
                        pointBackgroundColor: "blue", // New point color (e.g., blue)
                        pointBorderColor: "white", // White outline
                        pointBorderWidth: 2,
                        fill: false,
                        spanGaps: true,
                        tension: 0.3
                    },
                     {
                         label: "Number of Employees (Appraiser)",
                         data: dataValues, // Y-axis → Employee count (Original)
                         borderColor: "rgba(0, 150, 0, 0.9)", // Deep green with opacity
                         borderWidth: 4,
                         pointRadius: 7, // Bigger points
                         pointBackgroundColor: "limegreen", // Bright green points
                         pointBorderColor: "white", // White outline
                         pointBorderWidth: 2,
                         fill: false,
                         spanGaps: true,
                         tension: 0.3
                     },
                     {
                         label: "Number of Employees (Appraised)",
                         data: dataValuesEmployee, // Y-axis → Employee count (New dataset)
                         borderColor: "rgba(255, 99, 132, 0.9)", // Reddish pink color
                         borderWidth: 4,
                         pointRadius: 7,
                         pointBackgroundColor: "red",
                         pointBorderColor: "white",
                         pointBorderWidth: 2,
                         fill: false,
                         spanGaps: true,
                         tension: 0.3
                     }
                 ],
             },
             options: {
                 responsive: false,
                 maintainAspectRatio: false,
                 plugins: {
                     legend: {
                         labels: {
                             color: "black",
                             font: { size: 14, weight: "bold" }
                         }
                     }
                 },
                 scales: {
                     x: { 
                         title: { display: true, text: "Ratings", color: "black", font: { size: 16, weight: "bold" } },
                         grid: { display: false }
                     },
                     y: { 
                         title: { display: true, text: "Total Employees", color: "black", font: { size: 16, weight: "bold" } },
                         min: 1, max:{{ $totalemployee }},
                         ticks: { stepSize: 1, color: "black" },
                         grid: { color: "rgba(0, 0, 0, 0.1)" }
                     },
                 },
             },
         });
      });
      
      
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
          
                             // Helper function to check if the date is invalid or is a default date like "01/01/1970"
                             function isInvalidDate(date) {
                                 return date === "1970-01-01" || date === "0000-00-00" || date === "";
                             }
                             var image_url = `https://vnrseeds.co.in/AdminUser/EmpImg${companyId}Emp/${response.employeeDetails.EmpCode}.jpg`;
          
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
      
          function showUploadedFiles(empPmsId) {
         let fileList = $("#fileList");
         fileList.html('<tr><td colspan="3" class="text-center text-muted">Loading...</td></tr>');
      
         $.ajax({
             url: "{{ route('get.uploaded.files') }}",
             type: "GET",
             data: { EmpPmsId: empPmsId },
             success: function (response) {
                 fileList.empty();
      
                 if (response.files.length > 0) {
                     response.files.forEach(file => {
                         let fileIcon = getFileIcon(file.FileName); // Function to get the right icon
      
                         fileList.append(`
                             <tr>
                                 <td>
                                     <i class="${fileIcon} text-primary"></i> ${file.FileName}
                                 </td>
                                 <td class="text-center">
                                     ${file.FileName.split('.').pop().toUpperCase()}
                                 </td>
                                 <td class="text-center">
                                     <a href="/Employee/AppUploadFile/${file.FileName}" class="download-btn" download>
                                         <i class="fas fa-download"></i>
                                     </a>
                                 </td>
                             </tr>
                         `);
                     });
                 } else {
                     fileList.append('<tr><td colspan="3" class="text-center text-muted">No files available.</td></tr>');
                 }
      
                 $("#uploadedFilesModal").modal("show");
             }
         });
      }
      
      // Function to get file icon based on extension
      function getFileIcon(fileName) {
         let ext = fileName.split('.').pop().toLowerCase();
         let icons = {
             pdf: "fas fa-file-pdf",
             doc: "fas fa-file-word",
             docx: "fas fa-file-word",
             xls: "fas fa-file-excel",
             xlsx: "fas fa-file-excel",
             ppt: "fas fa-file-powerpoint",
             pptx: "fas fa-file-powerpoint",
             jpg: "fas fa-file-image",
             jpeg: "fas fa-file-image",
             png: "fas fa-file-image",
             txt: "fas fa-file-alt",
             zip: "fas fa-file-archive",
             rar: "fas fa-file-archive",
             default: "fas fa-file"
         };
         return icons[ext] || icons["default"];
      }
      
      
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
      /* Smooth hover effect for the download button */
      .download-btn {
      transition: all 0.3s ease-in-out;
      position: relative;
      overflow: hidden;
      }
      /* Slight scaling effect on hover */
      .download-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 4px 10px rgba(0, 255, 0, 0.4); /* Green glow effect */
      }
      /* Animated download icon */
      .download-btn i {
      transition: transform 0.3s ease-in-out;
      }
      /* Bouncy effect on hover */
      .download-btn:hover i {
      transform: translateY(3px);
      }
      .blinking-text strong {
        animation: blink-animation 1s steps(2, start) infinite;
        -webkit-animation: blink-animation 1s steps(2, start) infinite;
    }

    @keyframes blink-animation {
        to {
            visibility: hidden;
        }
    }

    @-webkit-keyframes blink-animation {
        to {
            visibility: hidden;
        }
    }
    .rating-ranges {
    font-family: Arial, sans-serif;
    display: flex;
    flex-wrap: wrap; /* Allow wrapping */
    gap: 10px;  /* Space between items */
    max-width: 100%; /* Ensure it takes full width available */
}

.rating-ranges b {
    font-size: 10px;  /* Small font for the label */
    color: #333;
    display: inline-block;
}

/* Rating item styling */
.rating-range-item {
    display: inline-block;
    width: calc(25% - 10px);  /* 4 items per row (25% width with gap adjustment) */
    padding: 8px;
    background-color: #c4d9db;
    border-radius: 5px;
    text-align: center;
    font-size: 12px;  /* Smaller font */
    color: #333;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    opacity: 0;
    transform: translateY(20px); /* Starting position for animation */
    animation: fadeInUp 0.6s ease-out forwards;
}

/* Animation keyframes for fade-in effect */
@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Limit container height to ensure only two lines */
.rating-ranges {
    max-height: 160px;  /* Maximum height for 2 lines */
    overflow: hidden;  /* Hide overflow */
    display: flex;
    flex-wrap: wrap;
}

/* Make sure it doesn't break more than 2 lines */
.rating-ranges::after {
    content: '';
    flex-basis: 100%;
    height: 0;
}

/* Responsive behavior for smaller screens */
@media (max-width: 768px) {
    .rating-range-item {
        font-size: 10px;  /* Smaller font */
        padding: 6px;  /* Smaller padding */
        width: calc(33.33% - 10px);  /* 3 items per row */
    }
}

@media (max-width: 480px) {
    .rating-range-item {
        font-size: 8px;  /* Even smaller font */
        padding: 4px;  /* Less padding */
        width: calc(50% - 10px);  /* 2 items per row */
    }
}

   </style>