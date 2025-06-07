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
                     @if($exists_appraisel || $exists_appraisel_pms)
                     <li class="nav-item" role="presentation">
                        <a style="color: #0e0e0e;min-width:105px;" class="nav-link " href="{{ route('appraiser') }}"
                           role="tab" aria-selected="false" tabindex="-1">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Appraiser</span>
                        </a>
                     </li>
                     @endif
                     @if($exists_reviewer || $exists_reviewer_pms)
                     <li class="nav-item" role="presentation">
                        <a style="color: #0e0e0e;min-width:105px;" class="nav-link " href="{{ route('reviewer') }}"
                           role="tab" aria-selected="false" tabindex="-1">
                        <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                        <span class="d-none d-sm-block">Reviewer</span>
                        </a>
                     </li>
                     @endif
                     @if($exists_hod || $exists_hod_pms)
                     <li class="nav-item" role="presentation">
                        <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{ route('hod') }}" role="tab"
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
                        @if (
                                        $data['emp']['Appform'] == 'Y')
                                        <li class="nav-item">
                                          <a style="color: #0e0e0e;padding-top:10px !important;" class="nav-link pt-4 " id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
                                       </li>
                                        <!-- @if (
                                            ($rowChe > 0) ||
                                            (
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3
                                            ) ||
                                            (
                                                $rowCh > 0 &&
                                                isset($appraisal_schedule) &&
                                                $appraisal_schedule->AppDateStatus == 'A' &&
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3
                                            ) ||
                                            (
                                                isset($appraisal_schedule) &&
                                                $CuDate >= $appraisal_schedule->RevFromDate &&
                                                $CuDate <= $appraisal_schedule->RevToDate &&
                                                $appraisal_schedule->RevDateStatus == 'A'
                                               
                                            ) ||
                                            (
                                                isset($appraisal_schedule) &&
                                                $CuDate >= $appraisal_schedule->HodFromDate &&
                                                $CuDate <= $appraisal_schedule->HodToDate &&
                                                $appraisal_schedule->HodDateStatus == 'A' &&
                                                $pms_id->Emp_PmsStatus == 1 &&
                                                $pms_id->Appraiser_PmsStatus == 3 &&
                                                $pms_id->Reviewer_PmsStatus == 3 &&
                                                $pms_id->HodSubmit_ScoreStatus == 3
                                            ) ||
                                            ($pms_id->ExtraAllowPMS == 1)
                                        ) -->
                                        
                                        <!-- @endif -->
                                    @endif

                        
                     </ul>
                     <div class="tab-content ad-content2" id="myTabContent2">
                        <div class="tab-pane fade " id="KraTab" role="tabpanel">
                           <div class="row">
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                 <div class="card">
                                    <div class="card-header" style="padding:0 !important;">
                                       <div class="float-end" style="margin-top:-50px;">
                                          <!-- Department Dropdown -->
                                          <select id="departmentDropdown">
                                             <option value="">Select Department</option>
                                             @foreach($employeeDetails->unique('department_name') as $employee)
                                             <option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
                                             @endforeach
                                          </select>
                                          <!-- <select>
                                             <option>Select State</option>
                                             <option>All</option>
                                             <option>Sales</option>
                                             </select> -->
                                          <!-- Headquarter Dropdown -->
                                          <select id="hqDropdown">
                                             <option value="">Select Head Quarter</option>
                                             @foreach($employeeDetails->unique('city_village_name') as $employee)
                                             <option value="{{ $employee->city_village_name }}">{{ $employee->city_village_name }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    <div class="card-body table-responsive align-items-center">
                                       <table class="table table-pad" id="hod_table_list_curr">
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
                                                <th>Revert Note</th>
                                             </tr>
                                          </thead>
                                          <tbody id="employeeTableBody">
                                             @foreach ($employeeDetails as $index => $employee)
                                             <tr class="employee-row" data-department="{{ $employee->department_name }}" data-hq="{{ $employee->city_village_name }}">
                                                @php
                                                $latestPmsKra = DB::table('hrm_pms_kra as k1')
                                                ->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy','k1.AppRevertNote','k1.HODRevertNote')
                                                ->where('k1.EmployeeID', $employee->EmployeeID)  // Only get the record for the current employee
                                                ->where('k1.YearId', $KraYId)  // Filtering for YearId = 14
                                                ->orderBy('k1.CreatedDate', 'desc')  // Order by CreatedDate in descending order to get the latest
                                                ->orderBy('k1.CompanyId', 'asc')  // Add other sorting criteria if needed (e.g., sorting by CompanyId)
                                                ->orderBy('k1.KRAStatus', 'desc') // Sorting by KRAStatus, you can adjust based on priority
                                                ->first(); // Get the first matching record
                                                $kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
                                                ->where('KRASheduleStatus', 'A')
                                                ->where('CompanyId',Auth::user()->CompanyId)
                                                ->where('YearId', '13')
                                                ->where('KRAProcessOwner', 'HOD')  // Only fetch HODs
                                                ->orderBy('KRASche_DateFrom', 'ASC')
                                                ->first();
                                                // Get the current date using Carbon
                                                $currentDate = \Carbon\Carbon::now();
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
                                                   {{-- Edit Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
                                                   @if($latestPmsKra && $latestPmsKra->EmpStatus == 'A' && $latestPmsKra->AppStatus == 'A' && $latestPmsKra->RevStatus == 'A' && $latestPmsKra->HODStatus != 'A' )
                                                   <a title="KRA Edit" data-bs-toggle="modal" data-bs-target="#editKRA" class="editkrabtn" 
                                                      data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $KraYId }}" 
                                                      data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
                                                      data-empcode="{{ $employee->EmpCode }}"
                                                      data-designation="{{ $employee->designation_name }}">
                                                   <i class="fas fa-edit mr-2 ml-2"></i>
                                                   </a>
                                                   @elseif($latestPmsKra && $latestPmsKra->EmpStatus == 'A' && $latestPmsKra->AppStatus == 'A' && $latestPmsKra->RevStatus == 'A' && $latestPmsKra->HODStatus == 'A')
                                                   @elseif($latestPmsKra && $latestPmsKra->EmpStatus == 'A' && $latestPmsKra->AppStatus == 'A' && $latestPmsKra->RevStatus == 'A' && $latestPmsKra->HODStatus == 'A' )
                                                   @else
                                                   @endif
                                                   {{-- Revert Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
                                                   @if($latestPmsKra && $latestPmsKra->EmpStatus == 'A' && $latestPmsKra->AppStatus == 'A' && $latestPmsKra->RevStatus == 'A' && $latestPmsKra->HODStatus != 'A')
                                                   <a title="KRA Revert" data-bs-toggle="modal" data-bs-target="#viewRevertbox" 
                                                      data-employeeid="{{ $employee->EmployeeID }}" data-krayid="{{ $KraYId }}" 
                                                      data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
                                                      data-empcode="{{ $employee->EmpCode }}"
                                                      data-designation="{{ $employee->designation_name }}">
                                                   <i class="fas fa-retweet ml-2 mr-2"></i>
                                                   </a>
                                                   @elseif($latestPmsKra && $latestPmsKra->EmpStatus == 'A' && $latestPmsKra->AppStatus == 'A' && $latestPmsKra->RevStatus == 'A' && $latestPmsKra->HODStatus == 'A' )
                                                   @elseif($latestPmsKra && $latestPmsKra->EmpStatus == 'A' && $latestPmsKra->AppStatus == 'A' && $latestPmsKra->RevStatus == 'A' && $latestPmsKra->HODStatus == 'A')
                                                   @else
                                                   @endif
                                                </td>
                                                <td>{{ $latestPmsKra->HODRevertNote ??'-' }}</td>
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
                                          <select id="departmentDropdownNew">
                                             <option value="">Select Department</option>
                                             @foreach($employeeDetails->unique('department_name') as $employee)
                                             <option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
                                             @endforeach
                                          </select>
                                          <!-- <select>
                                             <option>Select State</option>
                                             <option>All</option>
                                             <option>Sales</option>
                                             </select> -->
                                          <!-- Headquarter Dropdown -->
                                          <select id="hqDropdownNew">
                                             <option value="">Select Head Quarter</option>
                                             @foreach($employeeDetails->unique('city_village_name') as $employee)
                                             <option value="{{ $employee->city_village_name }}">{{ $employee->city_village_name }}</option>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    <div class="card-body table-responsive align-items-center">
                                       <table class="table table-pad" id="hod_table_list_new">
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
                                                <th>Revert Note</th>
                                             </tr>
                                          </thead>
                                          <tbody id="employeeTableBodyNew">
                                             @foreach ($employeeDetails as $index => $employee)
                                             <tr class="employee-row" data-department="{{ $employee->department_name }}" data-hq="{{ $employee->city_village_name }}">
                                                @php
                                                $latestPmsKranEW = DB::table('hrm_pms_kra as k1')
                                                ->select('k1.EmployeeID', 'k1.EmpStatus', 'k1.AppStatus', 'k1.CreatedDate', 'k1.YearId', 'k1.CompanyId', 'k1.KRAStatus', 'k1.UseKRA', 'k1.RevStatus', 'k1.HODStatus', 'k1.CreatedBy','k1.AppRevertNote','k1.HODRevertNote')
                                                ->where('k1.EmployeeID', $employee->EmployeeID)  // Only get the record for the current employee
                                                ->where('k1.YearId', $year_kra->NewY)  // Filtering for YearId = 14
                                                ->orderBy('k1.CreatedDate', 'desc')  // Order by CreatedDate in descending order to get the latest
                                                ->orderBy('k1.CompanyId', 'asc')  // Add other sorting criteria if needed (e.g., sorting by CompanyId)
                                                ->orderBy('k1.KRAStatus', 'desc') // Sorting by KRAStatus, you can adjust based on priority
                                                ->first(); // Get the first matching record
                                                $kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
                                                ->where('KRASheduleStatus', 'A')
                                                ->where('CompanyId',Auth::user()->CompanyId)
                                                ->where('YearId', '14')
                                                ->where('KRAProcessOwner', 'HOD')  // Only fetch team members
                                                ->orderBy('KRASche_DateFrom', 'ASC')
                                                ->first();
                                                // Get the current date using Carbon
                                                $currentDate = \Carbon\Carbon::now();
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
                                                {{-- Approval Status --}}
                                                <td>
                                                   @if($latestPmsKranEW)
                                                   @php
                                                   $appStatusClass = $latestPmsKranEW->AppStatus == 'A' ? 'success' : ($latestPmsKranEW->AppStatus == 'P' ? 'warning' : 'warning');
                                                   $appStatusText = $latestPmsKranEW->AppStatus == 'A' ? 'Submitted' : ($latestPmsKranEW->AppStatus == 'P' ? 'Pending' : 'Draft');
                                                   @endphp
                                                   <span class="{{ $appStatusClass }}"><b>{{ $appStatusText }}</b></span>
                                                   @else
                                                   <span class="info"><b>N/A</b></span>
                                                   @endif
                                                </td>
                                                <td>
                                                   @if($latestPmsKranEW)
                                                   @php
                                                   $revStatusClass = $latestPmsKranEW->RevStatus == 'A' ? 'success' : ($latestPmsKranEW->RevStatus == 'P' ? 'warning' : 'warning');
                                                   $revStatusText = $latestPmsKranEW->RevStatus == 'A' ? 'Submitted' : ($latestPmsKranEW->RevStatus == 'P' ? 'Pending' : 'Draft');
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
                                                   {{-- Edit Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
                                                   @if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A' && $latestPmsKranEW->AppStatus == 'A' && $latestPmsKranEW->RevStatus == 'A')
                                                   {{-- Check if HODStatus is not 'A' to allow editing --}}
                                                   @if($latestPmsKranEW->HODStatus != 'A')
                                                   <a title="KRA Edit" data-bs-toggle="modal" data-bs-target="#editKRA" class="editkrabtn" 
                                                      data-employeeid="{{ $employee->EmployeeID }}" 
                                                      data-krayid="{{ $year_kra->NewY }}" 
                                                      data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
                                                      data-empcode="{{ $employee->EmpCode }}"
                                                      data-designation="{{ $employee->designation_name }}">
                                                   <i class="fas fa-edit mr-2 ml-2"></i>
                                                   </a>
                                                   @else
                                                   {{-- Optionally, you can include code here to show something when HODStatus is 'A', 
                                                   or leave it empty if nothing should be displayed --}}
                                                   @endif
                                                   @else
                                                   {{-- If conditions are not met, nothing will be shown --}}
                                                   @endif
                                                   {{-- Revert Button - only active when EmpStatus is 'A' (Submitted) and AppStatus is not 'A' --}}
                                                   @if($latestPmsKranEW && $latestPmsKranEW->EmpStatus == 'A' && $latestPmsKranEW->AppStatus == 'A' && $latestPmsKranEW->RevStatus == 'A')
                                                   {{-- Check if HODStatus is not 'A' to allow reverting --}}
                                                   @if($latestPmsKranEW->HODStatus != 'A')
                                                   <a title="KRA Revert" data-bs-toggle="modal" data-bs-target="#viewRevertbox" 
                                                      data-employeeid="{{ $employee->EmployeeID }}" 
                                                      data-krayid="{{ $year_kra->NewY }}" 
                                                      data-name="{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}"
                                                      data-empcode="{{ $employee->EmpCode }}"
                                                      data-designation="{{ $employee->designation_name }}">
                                                   <i class="fas fa-retweet ml-2 mr-2"></i>
                                                   </a>
                                                   @else
                                                   {{-- Optionally, you can include code here to show something when HODStatus is 'A', 
                                                   or leave it empty if nothing should be displayed --}}
                                                   @endif
                                                   @else
                                                   {{-- If conditions are not met, nothing will be shown --}}
                                                   @endif
                                                </td>
                                                <td>{{ $latestPmsKranEW->HODRevertNote ??'-' }}</td>
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
                                   
                                    <div class="card-body table-responsive dd-flex align-items-center team-appraisalbox">
                                       <table class="table table-pad" id="employeetable">
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
                                                <th class="text-center" colspan="2" style="border-right: 1px solid #fff;">Reviewer</th>
                                                <th class="text-center" colspan="2" style="border-right: 1px solid #fff;">HOD</th>
                                                <th rowspan="2" style="text-align: center;">Uploaded</th>
                                                @if($data['app']['EHform'] == 'Y')
                                                    <th rowspan="2" style="text-align: center;">History</th>
                                                @else
                                                @endif
                                                <th rowspan="2" style="width:98px;text-align:center">Action</th>
                                                @php
                                                        $AppraisalletterMenu = $essMenus->firstWhere('name', 'Appraisal_letter');
                                                @endphp
                                                @if ($AppraisalletterMenu && $AppraisalletterMenu->is_visible)
                                             <th rowspan="2" class="text-center">Appraisal Letter</th>
                                          
                                             @endif
                                             </tr>
                                             <tr>
                                                <th class="text-center" style="border-left: 1px solid #fff;">Status</th>
                                                <th class="text-center" style="border-right: 1px solid #fff;">Rating</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center" style="border-right: 1px solid #fff;">Rating</th>
                                                <th class="text-center">Status</th>
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
                                                            ->first();
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
                                                                        <span class="{{ $empStatusClass }}"><b>{!! $empStatusText !!}</b></span>
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
                                                                     <td class="text-center">
                                                                        @php
                                                                        // Define the status and class based on EmpStatus
                                                                        $revStatusClass = '';
                                                                        $revStatusText = '';
                                                                        // Check the EmpStatus and set appropriate class and text
                                                                        switch ($employeepms->Reviewer_PmsStatus) {
                                                                        case '2': // Submitted
                                                                        $revStatusClass = 'success';
                                                                        $revStatusText = '<i class="fas fa-check-circle text-success" title="Submitted"></i>';
                                                                        break;
                                                                        case '0': // Draft
                                                                        $revStatusClass = 'primary';
                                                                        $revStatusText = '<i class="ri-file-forbid-line text-danger" title="Draft"></i>';
                                                                        break;
                                                                        case '1': // Pending
                                                                        $revStatusClass = 'warning';
                                                                        $revStatusText = '<i class="fas fa-hourglass-half text-warning" title="Pending"></i>';
                                                                        break;
                                                                        case '3': // Reverted
                                                                        $revStatusClass = 'danger';
                                                                        $revStatusText = '<i class="fas fa-undo text-danger" title="Reverted"></i>';
                                                                        break;
                                                                        default:
                                                                        $revStatusClass = 'secondary';
                                                                        $revStatusText = '<i class="fas fa-question-circle text-secondary" title="Unknown Status"></i>';
                                                                        break;
                                                                        }
                                                                        @endphp
                                                                        <span class="{{ $revStatusClass }}"><b>{!! $revStatusText !!}</b></span>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            {{ 
                                                                                fmod($employeepms->Reviewer_TotalFinalRating, 1) == 0 
                                                                                    ? number_format($employeepms->Reviewer_TotalFinalRating, 0) 
                                                                                    : rtrim(rtrim(number_format($employeepms->Reviewer_TotalFinalRating, 2, '.', ''), '0'), '.')
                                                                            }}
                                                                        </td>
                                                                        {{-- Employee PMS Status --}}
                                                                     <td class="text-center">
                                                                        @php
                                                                        // Define the status and class based on EmpStatus
                                                                        $hodStatusClass = '';
                                                                        $hodStatusText = '';
                                                                        // Check the EmpStatus and set appropriate class and text
                                                                        switch ($employeepms->Rev2_PmsStatus) {
                                                                        case '2': // Submitted
                                                                        $hodStatusClass = 'success';
                                                                        $hodStatusText = '<i class="fas fa-check-circle text-success" title="Submitted"></i>';
                                                                        break;
                                                                        case '0': // Draft
                                                                        $hodStatusClass = 'primary';
                                                                        $hodStatusText = '<i class="ri-file-forbid-line text-danger" title="Draft"></i>';
                                                                        break;
                                                                        case '1': // Pending
                                                                        $hodStatusClass = 'warning';
                                                                        $hodStatusText = '<i class="fas fa-hourglass-half text-warning" title="Pending"></i>';
                                                                        break;
                                                                        case '3': // Reverted
                                                                        $hodStatusClass = 'danger';
                                                                        $hodStatusText = '<i class="fas fa-undo text-danger" title="Reverted"></i>';
                                                                        break;
                                                                        default:
                                                                        $hodStatusClass = 'secondary';
                                                                        $hodStatusText = '<i class="fas fa-question-circle text-secondary" title="Unknown Status"></i>';
                                                                        break;
                                                                        }
                                                                        @endphp
                                                                        <span class="{{ $hodStatusClass }}"><b>{!! $hodStatusText !!}</b></span>
                                                                        </td>
                                                                        @if($employeepms->Rev2_PmsStatus !='2')
                                                                     <td class="text-center">0</td>
                                                                     @else
                                                                     <td class="text-center">
                                                                            {{ 
                                                                                fmod($employeepms->Reviewer_TotalFinalRating, 1) == 0 
                                                                                    ? number_format($employeepms->Reviewer_TotalFinalRating, 0) 
                                                                                    : rtrim(rtrim(number_format($employeepms->Reviewer_TotalFinalRating, 2, '.', ''), '0'), '.')
                                                                            }}
                                                                        </td>
                                                                     @endif

                                                               {{-- Uploaded Status Icon --}}
                                                                        <td class="text-center">
                                                                            @if (!empty($uploadfiles))  
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
                                                                            data-companyid="{{ $employeepms->CompanyId }}" ><i class="fas fa-eye"></i></a></td>
                                                                        @else
                                                                        @endif
													            <td>
                                                    <a href="javascript:void(0);" onclick="OpenEditWindow('{{ encrypt($employeepms->EmpPmsId) }}')">
                                                      <i class="fas fa-eye"></i>
                                                    </a>
                                                    @php
                                                      $statusTitle = '';
                                                      switch($employeepms->Rev2_PmsStatus) {
                                                            case '0': $statusTitle = 'Draft'; break;
                                                            case '1': $statusTitle = 'Pending'; break;
                                                            case '2': $statusTitle = 'Approved '; break;
                                                            case '3': $statusTitle = 'Revert'; break;
                                                            default: $statusTitle = 'Unknown'; break;
                                                      }
                                                   @endphp
                                                    @if($employeepms && $employeepms->Reviewer_PmsStatus == '2' && $employeepms->Rev2_PmsStatus != '2')
                                                    <a title="{{ $statusTitle }}"  data-bs-toggle="modal"  data-reviewer-rating="{{ $employeepms->Reviewer_TotalFinalRating }}"
                                                    data-emppmsid="{{ $employeepms->EmpPmsId }}" data-reviewer-score="{{ $employeepms->Reviewer_TotalFinalScore }}" data-bs-target="#Approved"> <i class="fas fa-check ml-2 mr-2"></i></a> | 
                                                    <a title="Revert" data-bs-toggle="modal" data-emppmsid="{{ $employeepms->EmpPmsId }}" data-bs-target="#resubmitKRA"> <i class="fas fa-retweet"></i></a></td>
			                                          @else
                                                
                                                    @endif
                                                     @php
                                                        $AppraisalletterMenu = $essMenus->firstWhere('name', 'Appraisal_letter');
                                                @endphp
                                                @if ($AppraisalletterMenu && $AppraisalletterMenu->is_visible)
                                                <td>
                                                    <a href="">
                                                        <i class="ri-file-text-line align-middle me-1" style="margin-left:42px;"></i>
                                                    </a>
                                                </td>
                                                @else
                                                <td></td>
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
                                                         <th>{{ number_format($rating, 1) }}</th> {{-- Ensure 1 decimal format --}}
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
                                                  
                                                   <tr>
                                                      <td><b>Reviewer</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingDataEmployeeReviewer[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
                                                   <tr>
                                                      <td><b>HOD</b></td>
                                                      @foreach($ratings as $rating)
                                                         <td>{{ $ratingDataEmployeeHod[number_format($rating, 1)] ?? 0 }}</td>
                                                      @endforeach
                                                   </tr>
                                             </tbody>
                                          </table>

                                          <!-- Graph Section -->
                                          <h3>HOD PMS Rating Graph</h3>
                                          <canvas id="hodChart" width="600" height="400"></canvas>
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
   <!--view history Modal-->
   <!--<div class="modal fade show" id="viewHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
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
                              <th>Previous Gross</th>
                              <th>Monthly Gross</th>
                              <th>CTC</th>
                              <th>% Increment</th>
                              <th>Rating</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><b>1.</b></td>
                              <td>12-06-2024</td>
                              <td>Territory Business Manager</td>
                              <td>J4</td>
                              <td>51474</td>
                              <td>57375 </td>
                              <td>0 </td>
                              <td> </td>
                              <td>0.00</td>
                           </tr>
                           <tr>
                              <td><b>2.</b></td>
                              <td>12-06-2024</td>
                              <td>Territory Business Manager</td>
                              <td>J4</td>
                              <td>51474</td>
                              <td>57375 </td>
                              <td>0 </td>
                              <td> </td>
                              <td>0.00</td>
                           </tr>
                           <tr>
                              <td><b>3.</b></td>
                              <td>12-06-2024</td>
                              <td>Territory Business Manager</td>
                              <td>J4</td>
                              <td>51474</td>
                              <td>57375 </td>
                              <td>0 </td>
                              <td> </td>
                              <td>0.00</td>
                           </tr>
                           <tr>
                              <td><b>4.</b></td>
                              <td>12-06-2024</td>
                              <td>Territory Business Manager</td>
                              <td>J4</td>
                              <td>51474</td>
                              <td>57375 </td>
                              <td>0 </td>
                              <td> </td>
                              <td>0.00</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Previous Employers</b></h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive align-items-center">
                     <table class="table table-pad">
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
                              <td><b>1.</b></td>
                              <td>Nuziveedu seeds limited	</td>
                              <td>Senior Officer</td>
                              <td>02-01-2018</td>
                              <td>28-02-2019</td>
                              <td>1.1 year</td>
                           </tr>
                           <tr>
                              <td><b>2.</b></td>
                              <td>Nuziveedu seeds limited	</td>
                              <td>Senior Officer</td>
                              <td>02-01-2018</td>
                              <td>28-02-2019</td>
                              <td>1.1 year</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="card">
                  <div class="card-header">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start"><b>Developmental Progress</b></h5>
                     </div>
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
                        <tbody>
                           <tr>
                              <td><b>1.</b></td>
                              <td>Effective Farmer Meetings & Handling Complaints</td>
                              <td>24-03-2023</td>
                              <td>1.0</td>
                              <td>S S Technologies</td>
                              <td>B Sivaprasad</td>
                              <td>Hotel White House INN, Indore</td>
                           </tr>
                           <tr>
                              <td><b>1.</b></td>
                              <td>Effective Farmer Meetings & Handling Complaints</td>
                              <td>24-03-2023</td>
                              <td>1.0</td>
                              <td>S S Technologies</td>
                              <td>B Sivaprasad</td>
                              <td>Hotel White House INN, Indore</td>
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
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                           </tr>
                           <tr>
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
            </div>
         </div>
      </div>
   </div>-->
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
   <!-- Approved KRA -->
   <div class="modal fade show" id="Approved" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" >Approved Note</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body appraisal-view">
                <div class="form-group mr-2">
                    <label class="col-form-label">Approved Note</label>
                    <textarea id="approvedNote" placeholder="Enter your Approved note" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a class="effect-btn btn btn-success squer-btn sm-btn" id="submitApproval">Send</a>
                <a class="effect-btn btn btn-light squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
            </div>
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
                   <source src="./public/video/ess-hod-help.mp4" type="video/mp4">
               </video>
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
   @include('employee.footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>  

   <script>
    function OpenEditWindow(encryptedEmpPmsId) {
		let url = `/view-hod/${encryptedEmpPmsId}`;
			window.open(url, '_blank', 'width=1200,height=1200,scrollbars=yes');
	}
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
             url: "{{ route('savehod') }}",  // Route to save KRA data
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
      
         $(document).ready(function () {
             // Function to filter the rows based on selected department and HQ
             function filterTableNew() {
               
                 var departmentFilterNew = $('#departmentDropdownNew').val().toLowerCase();
                 var hqFilterNew= $('#hqDropdownNew').val().toLowerCase();
      
                
                 // Loop through all rows in the table body
                 $('#employeeTableBodyNew tr').each(function () {
                     var department = $(this).data('department').toLowerCase();
                     var hq = $(this).data('hq').toLowerCase();
      
                     // Show row if it matches the filter or if no filter is applied
                     if ((departmentFilterNew === '' || department.includes(departmentFilterNew)) && 
                         (hqFilterNew === '' || hq.includes(hqFilterNew))) {
                         $(this).show(); // Show row
                     } else {
                         $(this).hide(); // Hide row
                     }
                 });
             }
      
             // Attach the filterTable function to the change event of the dropdowns
             $('#departmentDropdownNew, #hqDropdownNew').on('change', function () {
                 filterTableNew();
             });
      
             // Initialize table to show all rows by default when the page loads
             filterTableNew(); // This ensures all rows are shown when the page loads without applying filters.
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
                 url: '{{ route('kra.revert.hod') }}',  // Define the route in your routes/web.php
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

        fetch("/revert-pms", {
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

      
      
      $(document).ready(function () {
         // Initialize DataTable for the table
      		var table = $('#hod_table_list_new').DataTable({
      			paging: true,
      			lengthChange: true,
      			searching: true,
      			ordering: false,
      			info: true,
      			autoWidth: false,
      			pageLength: 10,
      			stateSave: true,
      			processing: true,
      			serverSide: false,
      		});
      
      		// Apply the filter function
      		function applyFilter(table, departmentSelector, hqSelector) {
      			var departmentFilter = $(departmentSelector).val() ? $(departmentSelector).val() : '';
      			var hqFilter = $(hqSelector).val() ? $(hqSelector).val() : '';
      
      			// Debugging - Check if the filters are correctly applied
      			console.log('Department Filter:', departmentFilter);
      			console.log('HQ Filter:', hqFilter);
      
      			// Use DataTable built-in filtering to filter based on the department and HQ
      			table.columns(3).search(departmentFilter, true, false); // Column 3 for department
      			table.columns(5).search(hqFilter, true, false); // Column 5 for HQ
      
      			// Redraw the table with the applied filter
      			table.draw();
      		}
      
      		// Function to update SN after filtering
      	// Function to update SN after filtering
      	function updateSerialNumbers(table) {
      			// Get all visible rows after filtering and pagination
      			$('#hod_table_list_new tbody tr').each(function (index) {
      				var serialNumber = index + 1;  // +1 because index is 0-based
      				$(this).find('td:eq(0)').text(serialNumber); // Update SN in the first column (index 0)
      			});
      		}
      
      		// Event listener for dropdown changes (Department and HQ)
      		$('#departmentDropdownNew, #hqDropdownNew').on('change', function () {
      			console.log('Filter changed. Applying filter...');
      			applyFilter(table, '#departmentDropdownNew', '#hqDropdownNew');
      			updateSerialNumbers(table);  // Update serial numbers after filtering
      		});
      
      		// Event listener for DataTable pagination to update serial numbers after page change
      		table.on('draw', function () {
      			updateSerialNumbers(table);  // Update serial numbers on table redraw (filter, page change)
      		});
      
      		// Initialize filters on page load to show all rows by default
      		applyFilter(table, '#departmentDropdownNew', '#hqDropdownNew'); // Apply filters on page load
      });
      
      $(document).ready(function () {
      	// Initialize DataTable for the table
      	var table = $('#hod_table_list_curr').DataTable({
      		paging: true,
      		lengthChange: true,
      		searching: true,
      		ordering: false,
      		info: true,
      		autoWidth: false,
      		pageLength: 10,
      		stateSave: true,
      		processing: true,
      		serverSide: false,
      	});
      
      	// Apply the filter function
      	function applyFilterCurr(table, departmentSelector, hqSelector) {
      		var departmentFilter = $(departmentSelector).val() ? $(departmentSelector).val() : '';
      		var hqFilter = $(hqSelector).val() ? $(hqSelector).val() : '';
      
      		// Debugging - Check if the filters are correctly applied
      		console.log('Department Filter:', departmentFilter);
      		console.log('HQ Filter:', hqFilter);
      
      		// Use DataTable built-in filtering to filter based on the department and HQ
      		table.columns(3).search(departmentFilter, true, false); // Column 3 for department
      		table.columns(5).search(hqFilter, true, false); // Column 5 for HQ
      
      		// Redraw the table with the applied filter
      		table.draw();
      	}
      
      	// Function to update SN after filtering
      // Function to update SN after filtering
      function updateSerialNumbers(table) {
      		// Get all visible rows after filtering and pagination
      		$('#hod_table_list_curr tbody tr').each(function (index) {
      			var serialNumber = index + 1;  // +1 because index is 0-based
      			$(this).find('td:eq(0)').text(serialNumber); // Update SN in the first column (index 0)
      		});
      	}
      
      	// Event listener for dropdown changes (Department and HQ)
      	$('#departmentDropdown, #hqDropdown').on('change', function () {
      		console.log('Filter changed. Applying filter...');
      		applyFilterCurr(table, '#departmentDropdown', '#hqDropdown');
      		updateSerialNumbers(table);  // Update serial numbers after filtering
      	});
      
      	// Event listener for DataTable pagination to update serial numbers after page change
      	table.on('draw', function () {
      		updateSerialNumbers(table);  // Update serial numbers on table redraw (filter, page change)
      	});
      
      	// Initialize filters on page load to show all rows by default
      	applyFilterCurr(table, '#departmentDropdown', '#hqDropdown'); // Apply filters on page load
      
      });
         
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
    let approvedModal = document.getElementById("Approved");

    approvedModal.addEventListener("show.bs.modal", function (event) {
        let button = event.relatedTarget; // Button that triggered the modal
        let empPmsId = button.getAttribute("data-emppmsid");
        let reviewerscore = button.getAttribute("data-reviewer-score");
        let reviewerrating = button.getAttribute("data-reviewer-rating");

        // Store these values in hidden inputs or directly set them in JavaScript
        let submitButton = document.getElementById("submitApproval");
        submitButton.setAttribute("data-emppmsid", empPmsId);
        submitButton.setAttribute("data-reviewer-score", reviewerscore);
        submitButton.setAttribute("data-reviewer-rating", reviewerrating);
    });

    document.getElementById("submitApproval").addEventListener("click", function () {
        $('#loader').show();  // Show the loader

        let approvedNote = document.getElementById("approvedNote").value;
        let empPmsId = this.getAttribute("data-emppmsid");
        let reviewerscore = this.getAttribute("data-reviewer-score");
        let reviewerrating = this.getAttribute("data-reviewer-rating");

        if (approvedNote.trim() === "") {
            alert("Please enter an approved note before submitting.");
            $('#loader').hide();
            return;
        }

        fetch("/approve-pms", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify({
                empPmsId: empPmsId,
                approvedNote: approvedNote,
                reviewerscore: reviewerscore,
                reviewerrating: reviewerrating
            })
        })
        .then(response => response.json())
        .then(data => {
            $('#loader').hide();  // Hide the loader after the request completes

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

            // Ensure error message is shown properly
            let errorMessage = "An error occurred.";
            if (error.response && error.response.data && error.response.data.message) {
                errorMessage = error.response.data.message;
            }

            toastr.error(errorMessage, 'Error', {
                "positionClass": "toast-top-right",
                "timeOut": 5000
            });

            // Re-enable the button in case of error
            document.getElementById("submitApproval").disabled = false;
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
    const ratingDataEmployeeReviewer = @json($ratingDataEmployeeReviewer); // New dataset
    const ratingDataEmployeeHod = @json($ratingDataEmployeeHod); // New dataset
    const overallrating = @json($overallrating); // New dataset

    const ratings = @json($ratings).map(rating => rating.toFixed(1));

    // Prepare data values for all datasets
    const dataValues = ratings.map(rating => ratingData[rating] ?? null);
    const dataValuesEmployee = ratings.map(rating => ratingDataEmployee[rating] ?? null);
    const dataValuesReviewer = ratings.map(rating => ratingDataEmployeeReviewer[rating] ?? null);
    const dataValuesHod = ratings.map(rating => ratingDataEmployeeHod[rating] ?? null);
    const dataValuesOverall = ratings.map(rating => overallrating[rating] ?? null);

    const ctx = document.getElementById("hodChart").getContext("2d");

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
                    data: dataValues, 
                    borderColor: "#008000", // Dark Green
                    borderWidth: 3,
                    pointRadius: 6, 
                    pointBackgroundColor: "#32CD32", // Lime Green
                    pointBorderColor: "white",
                    pointBorderWidth: 2,
                    fill: false,
                    spanGaps: true,
                    tension: 0.3
                },
                {
                    label: "Number of Employees (Appraised)",
                    data: dataValuesEmployee, 
                    borderColor: "#FF4500", // Orange-Red
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: "#FF6347", // Tomato
                    pointBorderColor: "white",
                    pointBorderWidth: 2,
                    fill: false,
                    spanGaps: true,
                    tension: 0.3
                },
                {
                    label: "Number of Employees (Reviewer)",
                    data: dataValuesReviewer, 
                    borderColor: "#4169E1", // Royal Blue
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: "#1E90FF", // Dodger Blue
                    pointBorderColor: "white",
                    pointBorderWidth: 2,
                    fill: false,
                    spanGaps: true,
                    tension: 0.3
                },
                {
                    label: "Number of Employees (HOD)",
                    data: dataValuesHod, 
                    borderColor: "#8A2BE2", // Bright Purple
                    borderWidth: 3,
                    pointRadius: 6,
                    pointBackgroundColor: "#9400D3", // Dark Violet
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
                    min: 1, max: 20,
                    ticks: { stepSize: 1, color: "black" },
                    grid: { color: "rgba(0, 0, 0, 0.1)" }
                },
            },
        },
    });
});
function OpenEditWindow(encryptedEmpPmsId) {
		let url = `/view-hod/${encryptedEmpPmsId}`;
			window.open(url, '_blank', 'width=900,height=600,scrollbars=yes');
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