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
                                    <li class="breadcrumb-link active">PMS - Employee PMS </li>
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
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{ route('pms') }}"
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
                    <div class="tab-content col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                <div class="row pms-emp-details">
                                        <div class="col-md-4"><b>Assessment Year:
                                        @if($data['emp']['Schedule'] == 'Y')
                                                <!-- <span>KRA {{$KraYear}}</span></b> -->
                                                <span>KRA {{$KraYear}}</span></b>
                                            @elseif($data['emp']['Schedule'] == 'N')
                                                <span>KRA {{kfnew}} {{ktnew}}
                                                </span></b>
                                                @else
                                                <span></span></b>

                                            @endif
                                        
                                            @if($data['emp']['Appform'] == 'Y')
                                            <span>  PMS {{$PmsYear}}</span></b>
                                            @else
                                            <span></span></b>
                                            @endif
                                        </div>
                                        <!--<div class="col-md-4"><b>EmpCode: <span>{{$employee->EmpCode}}</span></b></div>-->

                                        <div class="col-md-4"><b>Total VNR Experience: <span>{{$formattedDuration}}</span></b></div>
                                        <div class="col-md-4"><b>Function: <span>{{$functionName}}</span></b></div>
                                        <!--<div class="col-md-4"><b>Designation: <span>{{$employee->designation_name}}</span></b></div>
                                        <div class="col-md-4"><b> Head Quarter : <span>{{$employee->city_village_name}}</span></b></div>
                                        <div class="col-md-4"><b>Grade: <span>{{$employee->grade_name}}</span></b></div>
                                        <div class="col-md-4"><b>DOJ: <span>{{ \Carbon\Carbon::parse($employee->DateJoining)->format('d-M-Y') }}</span></b></div>-->

                                        <div class="col-md-4">
                                            <b>Appraiser: <span>
                                                            {{ trim(($reporting->appraiser_fname ?? '') . ' ' . ($reporting->appraiser_sname ?? '') . ' ' . ($reporting->appraiser_lname ?? '')) ?: '-' }}

                                                </span></b>
                                        </div>
                                        <div class="col-md-4">
                                        <b>Reviewer: <span>{{ trim(($reporting->rev_fname ?? '') . ' ' . ($reporting->rev_sname ?? '') . ' ' . ($reporting->rev_lname ?? '')) ?: '-' }}
                                            </span></b>
                                        </div>
                                        <div class="col-md-4">
                                            @if($reporting && ($reporting->hod_fname || $reporting->mang_fname))
                                        <b>
                                                {{ $reporting->hod_fname ? 'HOD:' : 'Management:' }} 
                                                <span>
                                                {{ !empty($reporting->hod_fname) 
                                                        ? trim(($reporting->hod_fname ?? '') . ' ' . ($reporting->hod_sname ?? '') . ' ' . ($reporting->hod_lname ?? ''))
                                                        : trim(($reporting->mang_fname ?? '') . ' ' . ($reporting->mang_sname ?? '') . ' ' . ($reporting->mang_lname ?? '')) 
                                                    }}
                                                </span>
                                            </b>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="mfh-machine-profile">
                            <ul class="nav nav-tabs" id="myTab1" role="tablist">
                            @php
                            // Decrypt the year_id from the request
                            $decryptedYearId = $year_kra->NewY;
                            if (request()->has('year_id')) {
                                try {
                                    $decryptedYearId = Crypt::decryptString(request('year_id'));
                                } catch (\Exception $e) {
                                    $decryptedYearId = null; // Handle invalid decryption
                                }
                            }

                            // Encrypt values for links
                            $encryptedCurrY = Crypt::encryptString($year_kra->CurrY);
                            $encryptedNewY = isset($year_kra->NewY) ? Crypt::encryptString($year_kra->NewY) : null;

                            // Default active tab
                            $activeTab = $decryptedYearId ?? $year_kra->CurrY;
                                @endphp

                                <!-- Tabs Navigation -->
                                    <li class="nav-item">
                                        <a class="nav-link pt-4 {{ $activeTab == $year_kra->CurrY ? 'active' : '' }}"
                                        style="color: #8b8989;padding-top:13px !important;border-right:1px solid #ddd;"
                                        href="{{ route('pms', ['year_id' => $encryptedCurrY]) }}">
                                        Current Year KRA - {{$KraYear}}
                                        </a>
                                    </li>

                                    @if ($year_kra->NewY_AllowEntry == 'Y' && $encryptedNewY)
                                        <li class="nav-item">
                                            <a class="nav-link pt-4 {{ $activeTab == $year_kra->NewY ? 'active' : '' }}"
                                            style="color: #8b8989;padding-top:13px !important;border-right:1px solid #ddd;"
                                            href="{{ route('pms', ['year_id' => $encryptedNewY]) }}">
                                            New KRA - {{$kfnew}}-{{$ktnew}}
                                            </a>
                                        </li>
                                    @endif



                                    @if ($data['emp']['Appform'] == 'Y' && $formattedDOJ <= $apra_allowdoj)
                                        @if (
                                            (isset($appraisal_schedule) && $CuDate >= $appraisal_schedule->EmpFromDate && $CuDate <= $appraisal_schedule->EmpToDate && $appraisal_schedule->EmpDateStatus == 'A') || 
                                            ($rowChe > 0) 
                                            ||Auth::user()->employeegeneral->DepartmentId =='7'||
                                            (isset($appraisal_schedule) && $CuDate >= $appraisal_schedule->AppFromDate && $CuDate <= $appraisal_schedule->AppToDate && $appraisal_schedule->AppDateStatus == 'A' &&
                                            $pms_id->Emp_PmsStatus == 1 && $pms_id->Appraiser_PmsStatus == 3) ||
                                            ($rowCh > 0 && isset($appraisal_schedule) && $appraisal_schedule->AppDateStatus == 'A' && $pms_id->Emp_PmsStatus == 1 && $pms_id->Appraiser_PmsStatus == 3) ||
                                            (isset($appraisal_schedule) && $CuDate >= $appraisal_schedule->RevFromDate && $CuDate <= $appraisal_schedule->RevToDate && $appraisal_schedule->RevDateStatus == 'A' &&
                                            $pms_id->Emp_PmsStatus == 1 && $pms_id->Appraiser_PmsStatus == 3 && $pms_id->Reviewer_PmsStatus == 3) ||
                                            (isset($appraisal_schedule) && $CuDate >= $appraisal_schedule->HodFromDate && $CuDate <= $appraisal_schedule->HodToDate && $appraisal_schedule->HodDateStatus == 'A' &&
                                            $pms_id->Emp_PmsStatus == 1 && $pms_id->Appraiser_PmsStatus == 3 && $pms_id->Reviewer_PmsStatus == 3 &&
                                            $pms_id->HodSubmit_ScoreStatus == 3) ||
                                            ($pms_id->ExtraAllowPMS == 1)
                                        )
                                            <li class="nav-item">
                                                <a style="color: #8b8989; padding-top:13px !important;" 
                                                    class="nav-link pt-4 {{ request('year_id') == Crypt::encryptString($yearPms) ? 'active' : '' }}" 
                                                    id="Appraisal-tab{{$yearPms}}" 
                                                    data-bs-toggle="tab" 
                                                    href="#Appraisal{{$yearPms}}" 
                                                    role="tab" 
                                                    aria-controls="Appraisal{{$yearPms}}" 
                                                    aria-selected="false"
                                                    onclick="updateURLWithTab('Appraisal{{$yearPms}}')">
                                                        Appraisal {{$yearPms}}
                                                </a>
                                            </li>
                                        @endif
                                    @endif



                            </ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                            <!-- <div class="tab-pane fade {{ $decryptedYearId == $year_kra->CurrY ? 'show active' : '' }}" id="KraTab" role="tabpanel"> -->
                            <div class="tab-pane fade {{ $activeTab == $year_kra->CurrY ? 'show active' : '' }}" id="KraTab" role="tabpanel">

                                    <div class="float-end" style="margin-top:-45px;">
                                        <ul class="kra-btns">

										@php
											// Fetch the first KRA schedule data for the team member
											$kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
												->where('KRASheduleStatus', 'A')
												->where('CompanyId',Auth::user()->CompanyId)
												->where('YearId', $KraYIdCurr)
												->where('KRAProcessOwner', 'Team Member')
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

											// Check if any entry in kraData has EmpStatus as 'A'
											$isEmpStatusA = $kraData->every(function ($kra) {
												return $kra->EmpStatus == 'A';
											});
       

											// Check if any entry in kraData has EmpStatus as 'D', 'P', or 'R'
											$isEmpStatusValid = $kraData->contains(function ($kra) {
												return in_array($kra->EmpStatus, ['D', 'P', 'R']);
											});
                                            $formattedDOJnew = \Carbon\Carbon::parse($formattedDOJ); 
                                            $currentDatenew = \Carbon\Carbon::parse($CuDate); 

                                            // Calculate the difference in days
                                            $daysDifference = $formattedDOJnew->diffInDays($currentDatenew);

										@endphp

                                        @if($isWithinDateRange && ($kraData->isEmpty() || ($kra_schedule_data_employee && !$isEmpStatusA)) || $daysDifference <= 30)
                                        <li class="mt-1">
											<a class="kraedit" title="Edit" id="EditBtnCurr">
												Edit <i class="fas fa-edit mr-2"></i>
											</a>
											</li>
											<li>
											<a class="effect-btn btn btn-success squer-btn sm-btn" style="display: none;" id="saveDraftBtnCurr">Save as Draft</a>
											</li>
											<li>
											<a class="effect-btn btn btn-light squer-btn sm-btn" style="display: none;" id="finalSubmitLi">Final Submit <i class="fas fa-check-circle mr-2"></i></a>
											</li>
                                            @elseif (!$isWithinDateRange && $kra_schedule_data_employee && !$isEmpStatusA)
                                                <!-- New Condition: If NOT in date range but EmpStatus is NOT 'A', show Edit -->
                                                <li class="mt-1">
                                                    <a class="kraedit" title="Edit" id="EditBtnCurr">
                                                        Edit <i class="fas fa-edit mr-2"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="effect-btn btn btn-success squer-btn sm-btn" style="display: none;" id="saveDraftBtnCurr">Save as Draft</a>
                                                </li>
                                                <li>
                                                    <a class="effect-btn btn btn-light squer-btn sm-btn" style="display: none;" id="finalSubmitLi">Final Submit <i class="fas fa-check-circle mr-2"></i></a>
                                                </li>
                                            @endif

                                            <li class="mt-1"><a title="Logic" data-bs-toggle="modal"
                                                    data-bs-target="#logicpopup">Logic <i
                                                        class="fas fa-tasks mr-2"></i></a></li>
                                          <!-- Button for Old KRA (Current Year) -->
                                          <li class="mt-1" id="oldkraeditli" style="display: none;">
                                                <a title="Old KRA" class="oldkrabtn" id="oldkraedit" onclick="fetchOldKRAData('{{$year_kra->OldY}}')">Old KRA <i class="fas fa-tasks mr-2"></i></a>
                                            </li>
                               
                                          
                                            @if($kraData->every(function ($kra) {
								    return $kra->EmpStatus == 'A';
								}))
								    <li class="mt-1">
									<a href="javascript:void(0)" onclick="printViewKraCurr()">
									    Print <i class="fas fa-print mr-2"></i>
									</a>
								    </li>
								@endif
                                        
                                        </ul>
                                    </div>
                                    <div class="row">
                                        
                                        <!-- Old KRA section for the current year -->
                                        <div class="col-md-12" id="oldkrabox" style="display:none;">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="float-start mt-2"><b>Old KRA </b></h5>
                                                </div>
                                                <div class="card-body table-responsive dd-flex align-items-center">
                                                    <table class="table table-pad">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
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
                                                        <tbody id="kraTableBody">
                                                            <!-- Data will be populated here via AJAX -->
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div style="float:left;width:100%;">
                                                        <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                                                        @if (isset($kraDatalastrevert))

                                                        @if ($kraDatalastrevert->AppStatus == 'R')
                                                                <span class="float-end" style="margin-left: 10px;" title="{{ $kraDatalastrevert->AppRevertNote }}" data-bs-tooltip="{{ $kraDatalastrevert->AppRevertNote }}">
                                                                    <strong style="color: #ff4d4d;">Your KRA has been reverted</strong>
                                                                </span>
                                                            @else
                                                           
                                                        @endif
                                                    @endif

                                                    </div>
                                                </div>
                                                <div id="viewForm" class="card-body table-responsive align-items-center printviewkraCurr">
                                                @if(count($kraWithSubs) > 0)
                                                    <table class="table table-pad">
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
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($kraWithSubs as $index => $item)
                                                                <tr>
                                                                    <td><b>{{ $index + 1 }}.</b></td>
                                                                    <td>{{ $item['kra']->KRA }}</td>
                                                                    <td>{{ $item['kra']->KRA_Description }}</td>
                                                                    @if(count($item['subKras']) == 0)
                                                                        <td>{{ $item['kra']->Measure }}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                    @if(count($item['subKras']) == 0)
                                                                        <td>{{ $item['kra']->Unit }}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                    <td>{{ $item['kra']->Weightage == intval($item['kra']->Weightage) ? intval($item['kra']->Weightage) : number_format($item['kra']->Weightage, 2) }}</td>
                                                                    @if(count($item['subKras']) == 0)
                                                                        <td>{{ $item['kra']->Logic }}</td>
                                                                         <td>
                                                                                    @if($item['kra']->Period === '1/2 Annual')
                                                                                        Half Yearly
                                                                                    @else
                                                                                        {{ $item['kra']->Period }}
                                                                                    @endif
                                                                        </td>
                                                                        <td>
                                                                    @if(count($item['subKras']) == 0)
                                                                        <span id="Tar_kra_{{ $item['kra']->KRAId }}" class="ClickableValue btn btn-outline-success custom-toggle" style="cursor: pointer; padding:4px 7px;
                                                                            @if($item['kra']->EmpStatus == 'A' && $item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                                                
                                                                            @else 
                                                                                color: black; 
                                                                            @endif
                                                                            transition: all 0.3s ease;"
                                                                            @if($item['kra']->EmpStatus == 'A' && $item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                                                onClick="showKraDetails('{{ $item['kra']->KRAId }}', '{{ $item['kra']->Period }}', '{{ $item['kra']->Target }}', '{{ intval($item['kra']->Weightage) }}', '{{ $item['kra']->Logic }}', {{ $year_kra->CurrY }})"
                                                                            @else
                                                                                style="cursor: default;" 
                                                                            @endif
                                                                        >
                                                                            {{ $item['kra']->Target == intval($item['kra']->Target) ? intval($item['kra']->Target) : number_format($item['kra']->Target, 2) }}
                                                                        </span>
                                                                        @else
                                                                                <!-- If conditions are not met, display a non-clickable value -->
                                                                                <span>{{ $item['kra']->Target == intval($item['kra']->Target) ? intval($item['kra']->Target) : number_format($item['kra']->Target, 2) }}</span>
                                                                            @endif
                                                                        </td>  
                                                            
                                                                    @else
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                    @endif
                                                                </tr>

                                                                @if(count($item['subKras']) > 0)
                                                                    <tr>
                                                                        <td colspan="10">
                                                                            <!-- Sub-KRA Table -->
                                                                            <table class="table" style="background-color:#ECECEC; margin-left:7px;">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th></th>
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
                                                                                    @foreach($item['subKras'] as $subIndex => $subKra)
                                                                                        <tr style="background-color: #ECECEC;">
                                                                                            <td></td>
                                                                                            <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                            <td>{{ $subKra->KRA }}</td>
                                                                                            <td>{{ $subKra->KRA_Description }}</td>
                                                                                            <td>{{ $subKra->Measure }}</td>
                                                                                            <td>{{ $subKra->Unit }}</td>
                                                                                            <td>{{ $subKra->Weightage == intval($subKra->Weightage) ? intval($subKra->Weightage) : number_format($subKra->Weightage, 2) }}</td>
                                                                                            <td>{{ $subKra->Weightage }}</td>
                                                                                            <td>{{ $subKra->Logic }}</td>
                                                                                            <td>
                                                                                                        @if($subKra->Period === '1/2 Annual')
                                                                                                            Half Yearly
                                                                                                        @else
                                                                                                            {{ $subKra->Period }}
                                                                                                        @endif
                                                                                            </td>
                                                                                           <!-- Target Input -->
                                                                                           <td>
                                                                                                            <span id="Tar_a{{ $subKra->KRASubId }}" 
                                                                                                                name="Target_subKRA[{{ $item['kra']->KRAId }}][]" 
                                                                                                                required  value="100"
                                                                                                                class=" 
                                                                                                                        @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                                                                            btn btn-outline-success custom-toggle
                                                                                                                        @endif
                                                                                                                        "
                                                                                                                        style="
                                                                                                                        
                                                                                                                            @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '') 
                                                                                                                                padding:4px 7px;
                                                                                                                            @else
                                                                                                                                padding:4px 7px;    
                                                                                                                                cursor: default;
                                                                                                                                color: black;
                                                                                                                            @endif"
                                                                                                                        value="{{ $subKra->Target }}"
                                                                                                                @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                                                                    onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}', {{ $year_kra->CurrY }})"
                                                                                                                @else
                                                                                                                    style="cursor: default;" 
                                                                                                                @endif>
                                                                                                                {{ $subKra->Target == intval($subKra->Target) ? intval($subKra->Target) : number_format($subKra->Target, 2) }}

                                                                                                            </span>
                                                                                                        </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @else
                                                    <!-- Add an empty row if no KRA data exists -->
                                                    <table class="table table-pad">
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
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <tr>
                                                                        <td>{{ $i }}</td>
                                                                        <td>
                                                                            <textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none; min-height:60px;" readonly
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea>
                                                                        </td>
                                                                        <td>
                                                                            <textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter description" style="width:300px; overflow:hidden; resize:none; min-height:60px;" readonly
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600"></textarea>
                                                                        </td>
                                                                        <td>
                                                                            <select name="Measure[]" class="form-control" style="width:95px;" disabled>
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
                                                                            <select name="Unit[]" class="form-control" style="width:75px;" disabled>
                                                                                
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
                                                                        <td><input type="number" name="weightage[]" placeholder="Enter weightage" style="width: 69px;" readonly></td>
                                                                        <td>
                                                                            <select name="Logic[]" class="form-control" style="width:75px;" disabled>
                                                                                @foreach($logicData as $logic)
                                                                                    <option value="{{ $logic->logicMn }}">{{ $logic->logicMn }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="Period[]" class="form-control" style="width:90px;" disabled>
                                                                                
                                                                                <option value="Annual">Annually</option>
                                                                                <option value="1/2 Annual">Half Yearly</option>
                                                                                <option value="Quarter">Quarterly</option>
                                                                                <option value="Monthly">Monthly</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="number" name="Target[]" value="100"  class="Inputa" placeholder="Enter Target" style="width:75px;" readonly></td>
                                                                    </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>

                                                                       
                                                                        
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                          
                                                        </div>

                                                <div id="editForm" class="card-body table-responsive align-items-center" style="display: none;">
                                            
                                                        
                                                    <form id="kraFormcurrent"  method="POST">
                                                        @csrf
                                                        <input type="hidden" name="KraYId" value="{{ $year_kra->CurrY}}">

                                                        <table class="table table-pad" id="current_kra">
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
                                                                    <th></th>
                                                                    <th></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody id="mainKraBody">
                                                                @if(count($kraWithSubs) > 0)

                                                                @foreach($kraWithSubs as $index => $item)
                                                                <tr id="kraRow_{{ $item['kra']->KRAId }}">
                                                                   
                                                                    <td><b>{{ $index + 1 }}.</b></td>
                                                                    <input type="hidden" name="kraId[{{ $item['kra']->KRAId }}]" value="{{ $item['kra']->KRAId }}"readonly>

                                                                    <td>
                                                                        <textarea name="kra{{ $item['kra']->KRAId }}" required class="form-control" placeholder="Enter KRA" maxlength="350" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" >{{ $item['kra']->KRA }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="kra_description{{ $item['kra']->KRAId }}" required class="form-control" maxlength="600" placeholder="Enter description"  style="width:300px; overflow:hidden; resize:none; min-height: 60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" >{{ $item['kra']->KRA_Description }}</textarea>
                                                                    </td>
                                                                    

                                                                    <!-- Measure dropdown -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Measure_{{ $item['kra']->KRAId }}" required name="Measure_{{ $item['kra']->KRAId }}" >
                                                                        
                                                                            <option value="Process" {{ $item['kra']->Measure == 'Process' ? 'selected' : '' }}>Process</option>
                                                                            <option value="Acreage" {{ $item['kra']->Measure == 'Acreage' ? 'selected' : '' }}>Acreage</option>
                                                                            <option value="Event" {{ $item['kra']->Measure == 'Event' ? 'selected' : '' }}>Event</option>
                                                                            <option value="Program" {{ $item['kra']->Measure == 'Program' ? 'selected' : '' }}>Program</option>
                                                                            <option value="Maintenance" {{ $item['kra']->Measure == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                                            <option value="Time" {{ $item['kra']->Measure == 'Time' ? 'selected' : '' }}>Time</option>
                                                                            <option value="Yield" {{ $item['kra']->Measure == 'Yield' ? 'selected' : '' }}>Yield</option>
                                                                            <option value="Value" {{ $item['kra']->Measure == 'Value' ? 'selected' : '' }}>Value</option>
                                                                            <option value="Volume" {{ $item['kra']->Measure == 'Volume' ? 'selected' : '' }}>Volume</option>
                                                                            <option value="Quantity" {{ $item['kra']->Measure == 'Quantity' ? 'selected' : '' }}>Quantity</option>
                                                                            <option value="Quality" {{ $item['kra']->Measure == 'Quality' ? 'selected' : '' }}>Quality</option>
                                                                            <option value="Area" {{ $item['kra']->Measure == 'Area' ? 'selected' : '' }}>Area</option>
                                                                            <option value="Amount" {{ $item['kra']->Measure == 'Amount' ? 'selected' : '' }}>Amount</option>
                                                                            <option value="None" {{ $item['kra']->Measure == 'None' ? 'selected' : '' }}>None</option>
                                                                        </select>
                                                                        @else
                                                                        @endif
                                                                    </td>

                                                                    <!-- Unit dropdown -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Unit_{{ $item['kra']->KRAId }}" required name="Unit_{{ $item['kra']->KRAId }}" style="width:75px;">
                                                                            
                                                                            <option value="%" {{ $item['kra']->Unit == '%' ? 'selected' : '' }}>%</option>
                                                                            <option value="Acres" {{ $item['kra']->Unit == 'Acres' ? 'selected' : '' }}>Acres</option>
                                                                            <option value="Days" {{ $item['kra']->Unit == 'Days' ? 'selected' : '' }}>Days</option>
                                                                            <option value="Month" {{ $item['kra']->Unit == 'Month' ? 'selected' : '' }}>Month</option>
                                                                            <option value="Hours" {{ $item['kra']->Unit == 'Hours' ? 'selected' : '' }}>Hours</option>
                                                                            <option value="Kg" {{ $item['kra']->Unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                                                                            <option value="Ton" {{ $item['kra']->Unit == 'Ton' ? 'selected' : '' }}>Ton</option>
                                                                            <option value="MT" {{ $item['kra']->Unit == 'MT' ? 'selected' : '' }}>MT</option>
                                                                            <option value="Kg/Acre" {{ $item['kra']->Unit == 'Kg/Acre' ? 'selected' : '' }}>Kg/Acre</option>
                                                                            <option value="Number" {{ $item['kra']->Unit == 'Number' ? 'selected' : '' }}>Number</option>
                                                                            <option value="Lakhs" {{ $item['kra']->Unit == 'Lakhs' ? 'selected' : '' }}>Lakhs</option>
                                                                            <option value="Rs." {{ $item['kra']->Unit == 'Rs.' ? 'selected' : '' }}>Rs.</option>
                                                                            <option value="INR" {{ $item['kra']->Unit == 'INR' ? 'selected' : '' }}>INR</option>
                                                                            <option value="None" {{ $item['kra']->Unit == 'None' ? 'selected' : '' }}>None</option>
                                                                        </select>
                                                                        @else
                                                                        @endif
                                                                    </td>

                                                                    <!-- Weightage -->
                                                                    <td><input type="number" required name="weightage{{ $item['kra']->KRAId }}"  placeholder="Enter Weightage" style="width:69px;" value="{{$item['kra']->Weightage }}" ></td>

                                                                    <!-- Logic -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Logic_{{ $item['kra']->KRAId }}" required name="Logic_{{ $item['kra']->KRAId }}" style="width:75px;" required>
                                                                        
                                                                        @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}" 
                                                                                {{ $item['kra']->Logic == $logic->logicMn ? 'selected' : '' }}>
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                        @endforeach
                                                                        </select>
                                                                        @else
                                                                        @endif
                                                                    </td>
                                                                    <!-- Period dropdown -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Period_{{ $item['kra']->KRAId }}" name="Period_{{ $item['kra']->KRAId }}" style="width:90px;" required>
                                                                        
                                                                            <option value="Annual" {{ $item['kra']->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                            <option value="1/2 Annual" {{ $item['kra']->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                            <option value="Quarter" {{ $item['kra']->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                            <option value="Monthly" {{ $item['kra']->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                        </select>
                                                                        @else
                                                                        @endif
                                                                    </td>

                                                                    <!-- Target KRA -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <input id="Tar_kra_{{ $item['kra']->KRAId }}" class="Inputa" required style="width:75px;"type="number"
                                                                            value="{{ $item['kra']->Target }}" name="Target_{{ $item['kra']->KRAId }}"
                                                                            style="cursor: pointer;  
                                                                        @if($item['kra']->Period != 'Annual' && $item['kra']->Period != '') 
                                                                            text-decoration: underline; color: #000099;
                                                                        @else
                                                                            text-decoration: none; color: black;
                                                                        @endif"
                                                                            maxlength="8"
                                                                            @if($item['kra']->EmpStatus == 'A' && $item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                                                    onClick="showKraDetails('{{ $item['kra']->KRAId }}', '{{ $item['kra']->Period }}', '{{ $item['kra']->Target }}', '{{ intval($item['kra']->Weightage) }}', '{{ $item['kra']->Logic }}', {{ $year_kra->CurrY }})"
                                                                                @else
                                                                                    
                                                                                @endif
                                                                        />
                                                                        @else
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <button class="deleteKra" data-kra-id="{{ $item['kra']->KRAId }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </td>

                                                                    @if(count($kraWithSubs) > 0)

                                                                    <td>
                                                                        <button type="button" class="fas fa-plus-circle mr-2 addSubKraBtn border-0 background-color:unset;" data-kra-id="{{ $item['kra']->KRAId }}"></button>
                                                                    </td>
                                                                    @endif

                                                                </tr>


                                                                @if(count($item['subKras']) > 0)
                                                                <tr>
                                                                    <td colspan="10">
                                                                        <!-- Sub-KRA Table -->
                                                                        <table class="table" id="subKraTable_{{ $item['kra']->KRAId }}" style="background-color:#ECECEC; margin-left:7px;">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th></th>
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
                                                                            <tbody id="subKraBody_{{ $item['kra']->KRAId }}"> <!-- Unique ID for sub-KRA table tbody -->
                                                                            @foreach($item['subKras'] as $subIndex => $subKra)
                                                                                <tr style="background-color: #ECECEC;">
                                                                                    <td></td>
                                                                                    <!-- SN (Sub KRA Number) -->
                                                                                    <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                    <input type="hidden" name="subKraId[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->KRASubId ?? '' }}" >

                                                                                    <td>
                                                                                        <textarea required name="subKraName[{{ $item['kra']->KRAId }}][]" class="form-control" maxlength="350" placeholder="Enter sub KRA" rows="2" style="width:250px;min-height:70px; overflow:hidden; resize:none;" 
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                        <textarea required name="subKraDesc[{{ $item['kra']->KRAId }}][]" class="form-control" maxlength="600"placeholder="Enter description" rows="2" style="width:300px; overflow:hidden; resize:none;"  
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA_Description }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                            <select id="Measure_subKRA_{{ $subKra->KRASubId }}" name="Measure_subKRA[{{ $item['kra']->KRAId }}][]" required>
                                                                                            
                                                                                            <option value="Process" {{ $subKra->Measure == 'Process' ? 'selected' : '' }}>Process</option>
                                                                                            <option value="Acreage" {{ $subKra->Measure == 'Acreage' ? 'selected' : '' }}>Acreage</option>
                                                                                            <option value="Event" {{ $subKra->Measure == 'Event' ? 'selected' : '' }}>Event</option>
                                                                                            <option value="Program" {{ $subKra->Measure == 'Program' ? 'selected' : '' }}>Program</option>
                                                                                            <option value="Maintenance" {{ $subKra->Measure == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                                                            <option value="Time" {{ $subKra->Measure == 'Time' ? 'selected' : '' }}>Time</option>
                                                                                            <option value="Yield" {{ $subKra->Measure == 'Yield' ? 'selected' : '' }}>Yield</option>
                                                                                            <option value="Value" {{ $subKra->Measure == 'Value' ? 'selected' : '' }}>Value</option>
                                                                                            <option value="Volume" {{ $subKra->Measure == 'Volume' ? 'selected' : '' }}>Volume</option>
                                                                                            <option value="Quantity" {{ $subKra->Measure == 'Quantity' ? 'selected' : '' }}>Quantity</option>
                                                                                            <option value="Quality" {{ $subKra->Measure == 'Quality' ? 'selected' : '' }}>Quality</option>
                                                                                            <option value="Area" {{ $subKra->Measure == 'Area' ? 'selected' : '' }}>Area</option>
                                                                                            <option value="Amount" {{ $subKra->Measure == 'Amount' ? 'selected' : '' }}>Amount</option>
                                                                                            <option value="None" {{ $subKra->Measure == 'None' ? 'selected' : '' }}>None</option>
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Unit Dropdown -->
                                                                                    <td>
                                                                                        <select id="Unit_subKRA_{{ $subKra->KRASubId }}" name="Unit_subKRA[{{ $item['kra']->KRAId }}][]" required style="width:75px;">
                                                                                        
                                                                                        <option value="%" {{ $subKra->Unit == '%' ? 'selected' : '' }}>%</option>
                                                                                            <option value="Acres" {{ $subKra->Unit == 'Acres' ? 'selected' : '' }}>Acres</option>
                                                                                            <option value="Days" {{ $subKra->Unit == 'Days' ? 'selected' : '' }}>Days</option>
                                                                                            <option value="Month" {{ $subKra->Unit == 'Month' ? 'selected' : '' }}>Month</option>
                                                                                            <option value="Hours" {{ $subKra->Unit == 'Hours' ? 'selected' : '' }}>Hours</option>
                                                                                            <option value="Kg" {{ $subKra->Unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                                                                                            <option value="Ton" {{ $subKra->Unit == 'Ton' ? 'selected' : '' }}>Ton</option>
                                                                                            <option value="MT" {{ $subKra->Unit == 'MT' ? 'selected' : '' }}>MT</option>
                                                                                            <option value="Kg/Acre" {{ $subKra->Unit == 'Kg/Acre' ? 'selected' : '' }}>Kg/Acre</option>
                                                                                            <option value="Number" {{ $subKra->Unit == 'Number' ? 'selected' : '' }}>Number</option>
                                                                                            <option value="Lakhs" {{ $subKra->Unit == 'Lakhs' ? 'selected' : '' }}>Lakhs</option>
                                                                                            <option value="Rs." {{ $subKra->Unit == 'Rs.' ? 'selected' : '' }}>Rs.</option>
                                                                                            <option value="INR" {{ $subKra->Unit == 'INR' ? 'selected' : '' }}>INR</option>
                                                                                            <option value="None" {{ $subKra->Unit == 'None' ? 'selected' : '' }}>None</option>
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Weightage -->
                                                                                    <td>
                                                                                        <input type="number" name="Weightage_subKRA[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->Weightage }}" placeholder="Enter weightage" style="width: 69px;" required>
                                                                                    </td>
                                                                                    <!-- Logic Dropdown -->
                                                                                    <td>
                                                                                        <select name="Logic_subKRA[{{ $item['kra']->KRAId }}][]" style="width:75px;" required>
                                                                                        
                                                                                        @foreach($logicData as $logic)
                                                                                            <option value="{{ $logic->logicMn }}"
                                                                                                {{ $subKra->Logic == $logic->logicMn ? 'selected' : '' }}>
                                                                                                {{ $logic->logicMn }}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Period Dropdown -->
                                                                                    <td>
                                                                                        <select id="Period_subKRA_{{ $subKra->KRASubId }}" name="Period_subKRA[{{ $item['kra']->KRAId }}][]" style="width:90px;" required>
                                                                                        
                                                                                            <option value="Annual" {{ $subKra->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                                            <option value="1/2 Annual" {{ $subKra->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                                            <option value="Quarter" {{ $subKra->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                                            <option value="Monthly" {{ $subKra->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Target Input -->
                                                                                    <td>
                                                                                            <input id="Tar_a{{ $subKra->KRASubId }}" type="number" min="0"
                                                                                                name="Target_subKRA[{{ $item['kra']->KRAId }}][]" 
                                                                                                required value="100"
                                                                                                class="
                                                                                                @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                                                        btn btn-outline-success custom-toggle
                                                                                                    @endif
                                                                                                "
                                                                                                style="
                                                                                                    width: 70px; /* Adjusted width */
                                                                                                    height: 30px; /* Adjusted height */
                                                                                                    @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '') 
                                                                                                        cursor: pointer;
                                                                                                        color: green !important;
                                                                                                    @else
                                                                                                        cursor: default;
                                                                                                        color: black;
                                                                                                    @endif"
                                                                                                value="{{ $subKra->Target }}"
                                                                                                maxlength="8"
                                                                                                @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                                                    onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}', {{ $year_kra->CurrY }})"
                                                                                                @else
                                                                                                @endif>
                                                                                        </td>



                                                                                    
                                                                                    <td>
                                                                                        <button class="deleteSubKra" data-subkra-id="{{ $subKra->KRASubId }}">
                                                                                            <i class="fas fa-trash"></i>
                                                                                        </button>

                                                                                    </td>

                                                                                </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                @endif

                                                                @endforeach
                                                                @else
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                <tr id="kraRow_{{ $i }}">
                                                                <td><b>{{ $i }}.</b></td>
                                                                        <td>
                                                                            <textarea type="text" name="kra[]"placeholder="Enter KRA" class="form-control" style="width:250px; overflow:hidden; resize:none; min-height:60px;" required
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea>
                                                                        </td>
                                                                        <td>
                                                                            <textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter description" style="width:300px; overflow:hidden; resize:none; min-height:60px;" required
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600"></textarea>
                                                                        </td>
                                                                        <td>
                                                                            <select name="Measure[]" style="width:95px;" required>
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
                                                                            <select name="Unit[]" style="width:75px;"required >
                                                                                
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
                                                                        <td><input type="number" name="weightage[]" placeholder="Enter weightage" style="width: 69px;"required ></td>
                                                                        <td>
                                                                            <select name="Logic[]" style="width:75px;" required>
                                                                                @foreach($logicData as $logic)
                                                                                    <option value="{{ $logic->logicMn }}">{{ $logic->logicMn }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="Period[]" style="width:90px;" required>
                                                                                
                                                                                <option value="Annual">Annually</option>
                                                                                <option value="1/2 Annual">Half Yearly</option>
                                                                                <option value="Quarter">Quarterly</option>
                                                                                <option value="Monthly">Monthly</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="number" name="Target[]" required value="100" class="Inputa" placeholder="Enter Target" style="width:75px;" ></td>
                                                                        <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtn"></button></td>

                                                                    </tr>
                                                                @endfor
                                                                @endif
                                                            </tbody>

                                                        </table>
                                                    <!-- <button type="button" class="btn btn-success" id="addKraBtn">Add Kra</button> -->
                                                    <button type="button" class="btn btn-success" id="addKraBtn">
                                                            Add Kra <i class="fas fa-plus-circle"></i>
                                                        </button>

                                                    </form>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                
                                @if ($year_kra->NewY_AllowEntry == 'Y')

                                <div class="tab-pane fade {{ $activeTab == $year_kra->NewY ? 'show active' : '' }}" id="KraTabnew" role="tabpanel">
                                    <div class="float-end" style="margin-top:-45px;">
                                        <ul class="kra-btns">
                                            @php
                                            // Fetch the first KRA schedule data for the team member
                                            $kra_schedule_data_employee = DB::table('hrm_pms_kra_schedule')
                                            ->where('KRASheduleStatus', 'A')
                                            ->where('CompanyId',Auth::user()->CompanyId)
                                            ->where('YearId', $KraYId)
                                            ->where('KRAProcessOwner', 'Team Member')
                                            ->orderBy('KRASche_DateFrom', 'ASC')
                                            ->first();
                                            // Get the current date using Carbon
                                            $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                                            // If we have a result, check the conditions
                                            if ($kra_schedule_data_employee) {
                                            // Convert KRASche_DateFrom and KRASche_DateTo to Carbon instances for comparison
                                            $dateFrom = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateFrom)->format('Y-m-d');
                                            $dateTo = \Carbon\Carbon::parse($kra_schedule_data_employee->KRASche_DateTo)->format('Y-m-d');
                                            // Check if current date is between KRASche_DateFrom and KRASche_DateTo
                                            $isWithinDateRange = ($currentDate >= $dateFrom && $currentDate <= $dateTo);
                                            }
                                            // Check if any entry in kraData has EmpStatus as 'A'
                                            $isEmpStatusA = $kraData->every(function ($kra) {
                                            return $kra->EmpStatus == 'A';
                                            });
                                            // Check if any entry in kraData has EmpStatus as 'D', 'P', or 'R'
                                            $isEmpStatusValid = $kraData->contains(function ($kra) {
                                            return in_array($kra->EmpStatus, ['D', 'P', 'R']);
                                            });
                                            $formattedDOJnew = \Carbon\Carbon::parse($formattedDOJ); 
                                            $currentDatenew = \Carbon\Carbon::parse($CuDate); 
                                            // Calculate the difference in days
                                            $daysDifference = $formattedDOJnew->diffInDays($currentDatenew);
                                            @endphp
                                            <!-- Display the edit button if the date range is valid and EmpStatus is not 'A' -->
                                            @if($isWithinDateRange && ($kraData->isEmpty() || ($kra_schedule_data_employee && !$isEmpStatusA)) || $daysDifference <= 30)
                                            <li class="mt-1">
                                                <a class="kraeditNew" title="Edit" id="EditBtnCurrNew">
                                                Edit <i class="fas fa-edit mr-2"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="effect-btn btn btn-success squer-btn sm-btn" style="display: none;" id="saveDraftBtnNew">Save as Draft</a>
                                            </li>
                                            <li>
                                                <a class="effect-btn btn btn-light squer-btn sm-btn" style="display: none;" id="finalSubmitLiNew">Final Submit <i class="fas fa-check-circle mr-2"></i></a>
                                            </li>
                                            @elseif (!$isWithinDateRange && $kra_schedule_data_employee && !$isEmpStatusA)
                                            <!-- New Condition: If NOT in date range but EmpStatus is NOT 'A', show Edit -->
                                            <li class="mt-1">
                                                <a class="kraeditNew" title="Edit" id="EditBtnCurrNew">
                                                Edit <i class="fas fa-edit mr-2"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="effect-btn btn btn-success squer-btn sm-btn" style="display: none;" id="saveDraftBtnNew">Save as Draft</a>
                                            </li>
                                            <li>
                                                <a class="effect-btn btn btn-light squer-btn sm-btn" style="display: none;" id="finalSubmitLiNew">Final Submit <i class="fas fa-check-circle mr-2"></i></a>
                                            </li>
                                            @endif
                                            <li class="mt-1"><a title="View" data-bs-toggle="modal"
                                                data-bs-target="#logicpopup">Logic<i
                                                class="fas fa-tasks mr-2"></i></a></li>
                                            <!-- Button for Old KRA (Current Year) -->
                                            <li class="mt-1" id="oldkraeditnewli"style="display: none;">
                                                <a class="oldkrabtnnew" id="oldkraeditNew" onclick="fetchOldKRADataNew('{{$year_kra->CurrY}}')">Old KRA <i class="fas fa-tasks mr-2"></i></a>
                                            </li>
                                            @if($kraData->every(function ($kra) {
                                            return $kra->EmpStatus == 'A';
                                            }))
                                            <li class="mt-1">
                                                <a href="javascript:void(0)" onclick="printViewKraNew()">
                                                Print <i class="fas fa-print mr-2"></i>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <!-- Old KRA section for the new year -->
                                        <div class="col-md-12" id="oldkraboxNew" style="display:none;">
                                            <div class="card">
                                                <div class="card-header">
                                                <h5 class="float-start mt-2"><b>Old KRA</b></h5>
                                                </div>
                                                <div class="card-body table-responsive dd-flex align-items-center">
                                                <table class="table table-pad">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
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
                                                    <tbody id="kraTableBodyNew">
                                                        <!-- Data will be populated here via AJAX -->
                                                    </tbody>
                                                </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                <div style="float:left;width:100%;">
                                                    <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                                                    @if (isset($kraDatalastrevert))
                                                    @if ($kraDatalastrevert->AppStatus == 'R')
                                                    <span class="float-end" style="margin-left: 10px;" title="{{ $kraDatalastrevert->AppRevertNote }}" data-bs-tooltip="{{ $kraDatalastrevert->AppRevertNote }}">
                                                    <strong style="color: #ff4d4d;">Your KRA has been reverted</strong>
                                                    </span>
                                                    @else
                                                    @endif
                                                    @endif
                                                </div>
                                                </div>
                                                <div id="viewFormNew" class="card-body table-responsive align-items-center printviewkraNew" >
                                                @if(count($kraWithSubs) > 0)
                                                <table class="table table-pad">
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
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($kraWithSubs as $index => $item)
                                                        <tr>
                                                            <td><b>{{ $index + 1 }}.</b></td>
                                                            <td>{{ $item['kra']->KRA }}</td>
                                                            <td>{{ $item['kra']->KRA_Description }}</td>
                                                            @if(count($item['subKras']) == 0)
                                                            <td>{{ $item['kra']->Measure }}</td>
                                                            @else
                                                            <td></td>
                                                            @endif
                                                            @if(count($item['subKras']) == 0)
                                                            <td>{{ $item['kra']->Unit }}</td>
                                                            @else
                                                            <td></td>
                                                            @endif
                                                            <td>{{ $item['kra']->Weightage == intval($item['kra']->Weightage) ? intval($item['kra']->Weightage) : number_format($item['kra']->Weightage, 2) }}</td>
                                                            @if(count($item['subKras']) == 0)
                                                            <td>{{ $item['kra']->Logic }}</td>
                                                            <td>
                                                            @if($item['kra']->Period === '1/2 Annual')
                                                            Half Yearly
                                                            @else
                                                            {{ $item['kra']->Period }}
                                                            @endif
                                                            </td>
                                                            <td>
                                                            @if(count($item['subKras']) == 0)
                                                            <span id="Tar_kra_{{ $item['kra']->KRAId }}" class="ClickableValue btn btn-outline-success custom-toggle" style="cursor: pointer; padding:5px 7px;
                                                            @if($item['kra']->EmpStatus == 'A' && $item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                            @else 
                                                            color: black; 
                                                            @endif
                                                            transition: all 0.3s ease;"
                                                            @if($item['kra']->EmpStatus == 'A' && $item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                            onClick="showKraDetails('{{ $item['kra']->KRAId }}', '{{ $item['kra']->Period }}', '{{ $item['kra']->Target }}', '{{ intval($item['kra']->Weightage) }}', '{{ $item['kra']->Logic }}', {{ $year_kra->NewY }})"
                                                            @else
                                                            style="cursor: default;" 
                                                            @endif
                                                            >
                                                            {{ $item['kra']->Target == intval($item['kra']->Target) ? intval($item['kra']->Target) : number_format($item['kra']->Target, 2) }}
                                                            </span>
                                                            @else
                                                            <!-- If conditions are not met, display a non-clickable value -->
                                                            <span>{{ $item['kra']->Target == intval($item['kra']->Target) ? intval($item['kra']->Target) : number_format($item['kra']->Target, 2) }}</span>
                                                            @endif
                                                            </td>
                                                            @else
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            @endif
                                                        </tr>
                                                        @if(count($item['subKras']) > 0)
                                                        <tr>
                                                            <td colspan="10">
                                                            <!-- Sub-KRA Table -->
                                                            <table class="table" style="background-color:#ECECEC; margin-left:20px;">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
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
                                                                    @foreach($item['subKras'] as $subIndex => $subKra)
                                                                    <tr style="background-color: #ECECEC;">
                                                                        <td></td>
                                                                        <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                        <td>{{ $subKra->KRA }}</td>
                                                                        <td>{{ $subKra->KRA_Description }}</td>
                                                                        <td>{{ $subKra->Measure }}</td>
                                                                        <td>{{ $subKra->Unit }}</td>
                                                                        <td>{{ $subKra->Weightage == intval($subKra->Weightage) ? intval($subKra->Weightage) : number_format($subKra->Weightage, 2) }}</td>
                                                                        <td>{{ $subKra->Logic }}</td>
                                                                        <td>
                                                                        @if($subKra->Period === '1/2 Annual')
                                                                        Half Yearly
                                                                        @else
                                                                        {{ $subKra->Period}}
                                                                        @endif
                                                                        </td>
                                                                        <!-- Target Input -->
                                                                        <td>
                                                                        <span id="Tar_a{{ $subKra->KRASubId }}" type="number"
                                                                        name="Target_subKRA[{{ $item['kra']->KRAId }}][]"  value="100"
                                                                        required 
                                                                        class=" 
                                                                        @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                        btn btn-outline-success custom-toggle
                                                                        @endif
                                                                        "
                                                                        style="
                                                                        @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '') 
                                                                        cursor: pointer;
                                                                        color: green !important;
                                                                        @else
                                                                        cursor: default;
                                                                        color: black;
                                                                        @endif"
                                                                        value="{{ $subKra->Target }}"
                                                                        @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                        onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}', {{ $year_kra->NewY }})"
                                                                        @else
                                                                        style="cursor: default;" 
                                                                        @endif>
                                                                        {{ $subKra->Target == intval($subKra->Target) ? intval($subKra->Target) : number_format($subKra->Target, 2) }}
                                                                        </span>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                        <!-- Add an empty row if no KRA data exists -->
                                                        <table class="table table-pad">
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
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                            <tr>
                                                                <td>{{ $i }}</td>
                                                                <td>
                                                                    <textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none; min-height:60px;" readonly
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter description" style="width:300px; overflow:hidden; resize:none; min-height:60px;" readonly
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600"></textarea>
                                                                </td>
                                                                <td>
                                                                    <select name="Measure[]" class="form-control" style="width:95px;" disabled>
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
                                                                    <select name="Unit[]" class="form-control" style="width:75px;" disabled>
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
                                                                <td><input type="number" name="weightage[]" placeholder="Enter weightage" style="width: 69px;" readonly></td>
                                                                <td>
                                                                    <select name="Logic[]" class="form-control" style="width:75px;" disabled>
                                                                        @foreach($logicData as $logic)
                                                                        <option value="{{ $logic->logicMn }}">{{ $logic->logicMn }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="Period[]" class="form-control" style="width:90px;" disabled>
                                                                        <option value="Annual">Annually</option>
                                                                        <option value="1/2 Annual">Half Yearly</option>
                                                                        <option value="Quarter">Quarterly</option>
                                                                        <option value="Monthly">Monthly</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" name="Target[]" value="100"  class="Inputa" placeholder="Enter Target" style="width:75px;" readonly></td>
                                                            </tr>
                                                            @endfor
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                </div>
                                                <div id="editFormNew" class="card-body table-responsive align-items-center" style="display: none;" >
                                                <form id="kraFormcurrentNew"  method="POST">
                                                    @csrf
                                                    <input type="hidden" name="KraYId" value="{{ $year_kra->NewY }}">
                                                    <table class="table table-pad" id="current_kraNew">
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
                                                            <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="mainKraBodyNew">
                                                            @if(count($kraWithSubs) > 0)
                                                            @foreach($kraWithSubs as $index => $item)
                                                            <tr id="kraRow_New{{ $item['kra']->KRAId }}">
                                                            <td><b>{{ $index + 1 }}.</b></td>
                                                            <input type="hidden" name="kraId[{{ $item['kra']->KRAId }}]" value="{{ $item['kra']->KRAId }}"readonly>
                                                            <td>
                                                                <textarea name="kra{{ $item['kra']->KRAId }}" class="form-control" maxlength="350" placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>{{ $item['kra']->KRA }}</textarea>
                                                            </td>
                                                            <td>
                                                                <textarea name="kra_description{{ $item['kra']->KRAId }}" class="form-control" maxlength="600" placeholder="Enter description"  style="width:300px; overflow:hidden; resize:none; min-height: 60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>{{ $item['kra']->KRA_Description }}</textarea>
                                                            </td>
                                                            <!-- Measure dropdown -->
                                                            <td>
                                                                @if(count($item['subKras']) == 0)
                                                                <select id="Measure_{{ $item['kra']->KRAId }}" name="Measure_{{ $item['kra']->KRAId }}" required>
                                                                <option value="Process" {{ $item['kra']->Measure == 'Process' ? 'selected' : '' }}>Process</option>
                                                                <option value="Acreage" {{ $item['kra']->Measure == 'Acreage' ? 'selected' : '' }}>Acreage</option>
                                                                <option value="Event" {{ $item['kra']->Measure == 'Event' ? 'selected' : '' }}>Event</option>
                                                                <option value="Program" {{ $item['kra']->Measure == 'Program' ? 'selected' : '' }}>Program</option>
                                                                <option value="Maintenance" {{ $item['kra']->Measure == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                                <option value="Time" {{ $item['kra']->Measure == 'Time' ? 'selected' : '' }}>Time</option>
                                                                <option value="Yield" {{ $item['kra']->Measure == 'Yield' ? 'selected' : '' }}>Yield</option>
                                                                <option value="Value" {{ $item['kra']->Measure == 'Value' ? 'selected' : '' }}>Value</option>
                                                                <option value="Volume" {{ $item['kra']->Measure == 'Volume' ? 'selected' : '' }}>Volume</option>
                                                                <option value="Quantity" {{ $item['kra']->Measure == 'Quantity' ? 'selected' : '' }}>Quantity</option>
                                                                <option value="Quality" {{ $item['kra']->Measure == 'Quality' ? 'selected' : '' }}>Quality</option>
                                                                <option value="Area" {{ $item['kra']->Measure == 'Area' ? 'selected' : '' }}>Area</option>
                                                                <option value="Amount" {{ $item['kra']->Measure == 'Amount' ? 'selected' : '' }}>Amount</option>
                                                                <option value="None" {{ $item['kra']->Measure == 'None' ? 'selected' : '' }}>None</option>
                                                                </select>
                                                                @else
                                                                @endif
                                                            </td>
                                                            <!-- Unit dropdown -->
                                                            <td>
                                                                @if(count($item['subKras']) == 0)
                                                                <select id="Unit_{{ $item['kra']->KRAId }}" name="Unit_{{ $item['kra']->KRAId }}" style="width:75px;" required>
                                                                <option value="%" {{ $item['kra']->Unit == '%' ? 'selected' : '' }}>%</option>
                                                                <option value="Acres" {{ $item['kra']->Unit == 'Acres' ? 'selected' : '' }}>Acres</option>
                                                                <option value="Days" {{ $item['kra']->Unit == 'Days' ? 'selected' : '' }}>Days</option>
                                                                <option value="Month" {{ $item['kra']->Unit == 'Month' ? 'selected' : '' }}>Month</option>
                                                                <option value="Hours" {{ $item['kra']->Unit == 'Hours' ? 'selected' : '' }}>Hours</option>
                                                                <option value="Kg" {{ $item['kra']->Unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                                                                <option value="Ton" {{ $item['kra']->Unit == 'Ton' ? 'selected' : '' }}>Ton</option>
                                                                <option value="MT" {{ $item['kra']->Unit == 'MT' ? 'selected' : '' }}>MT</option>
                                                                <option value="Kg/Acre" {{ $item['kra']->Unit == 'Kg/Acre' ? 'selected' : '' }}>Kg/Acre</option>
                                                                <option value="Number" {{ $item['kra']->Unit == 'Number' ? 'selected' : '' }}>Number</option>
                                                                <option value="Lakhs" {{ $item['kra']->Unit == 'Lakhs' ? 'selected' : '' }}>Lakhs</option>
                                                                <option value="Rs." {{ $item['kra']->Unit == 'Rs.' ? 'selected' : '' }}>Rs.</option>
                                                                <option value="INR" {{ $item['kra']->Unit == 'INR' ? 'selected' : '' }}>INR</option>
                                                                <option value="None" {{ $item['kra']->Unit == 'None' ? 'selected' : '' }}>None</option>
                                                                </select>
                                                                @else
                                                                @endif
                                                            </td>
                                                            <!-- Weightage -->
                                                            <td><input type="number" name="weightage{{ $item['kra']->KRAId }}"  placeholder="Enter weightage" style="width:78px;" value="{{$item['kra']->Weightage }}"required ></td>
                                                            <!-- Logic -->
                                                            <td>
                                                                @if(count($item['subKras']) == 0)
                                                                <select id="Logic_{{ $item['kra']->KRAId }}" name="Logic_{{ $item['kra']->KRAId }}" style="width:75px;" required >
                                                                @foreach($logicData as $logic)
                                                                <option value="{{ $logic->logicMn }}" 
                                                                {{ $item['kra']->Logic == $logic->logicMn ? 'selected' : '' }}>
                                                                {{ $logic->logicMn }}
                                                                </option>
                                                                @endforeach
                                                                </select>
                                                                @else
                                                                @endif
                                                            </td>
                                                            <!-- Period dropdown -->
                                                            <td>
                                                                @if(count($item['subKras']) == 0)
                                                                <select id="Period_{{ $item['kra']->KRAId }}" name="Period_{{ $item['kra']->KRAId }}" style="width:90px;" required >
                                                                <option value="Annual" {{ $item['kra']->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                <option value="1/2 Annual" {{ $item['kra']->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                <option value="Quarter" {{ $item['kra']->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                <option value="Monthly" {{ $item['kra']->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                </select>
                                                                @else
                                                                @endif
                                                            </td>
                                                            <!-- Target KRA -->
                                                            <td>
                                                                @if(count($item['subKras']) == 0)
                                                                <input id="Tar_kra_{{ $item['kra']->KRAId }}" type="number" class="Inputa" required placeholder="Enter target" style="width:75px;" min="0"
                                                                value="{{ $item['kra']->Target }}" name="Target_{{ $item['kra']->KRAId }}"
                                                                style="cursor: pointer;  
                                                                @if($item['kra']->Period != 'Annual' && $item['kra']->Period != '') 
                                                                text-decoration: underline; color: #000099;
                                                                @else
                                                                text-decoration: none; color: black;
                                                                @endif"
                                                                maxlength="8"
                                                                @if($item['kra']->EmpStatus == 'A' && $item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                                onClick="showKraDetails('{{ $item['kra']->KRAId }}', '{{ $item['kra']->Period }}', '{{ $item['kra']->Target }}', '{{ intval($item['kra']->Weightage) }}', '{{ $item['kra']->Logic }}', {{ $year_kra->CurrY }})"
                                                                @else
                                                                @endif
                                                                />
                                                                @else
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <button title="Delete KRA" class="deleteKra me-2" data-kra-id="{{ $item['kra']->KRAId }}">
                                                                <i class="fas fa-trash"></i>
                                                                </button>
                                                                @if(count($kraWithSubs) > 0)
                                                                <button title="Add Sub KRA" type="button" class="fas fa-plus-circle mr-2 addSubKraBtnNew border-0 background-color:unset;" data-kra-id-new="{{ $item['kra']->KRAId }}"></button>
                                                                @endif
                                                            </td>
                                                            </tr>
                                                            @if(count($item['subKras']) > 0)
                                                            <tr>
                                                            <td colspan="10">
                                                                <!-- Sub-KRA Table -->
                                                                <table class="table" id="subKraTable_New{{ $item['kra']->KRAId }}" style="background-color:#ECECEC; margin-left:7px;">
                                                                    <thead>
                                                                        <tr>
                                                                        <th></th>
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
                                                                    <tbody id="subKraTable_New{{ $item['kra']->KRAId }}">
                                                                        @foreach($item['subKras'] as $subIndex => $subKra)
                                                                        <tr style="background-color: #ECECEC;">
                                                                        <td></td>
                                                                        <!-- SN (Sub KRA Number) -->
                                                                        <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                        <input type="hidden" name="subKraId[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->KRASubId ?? '' }}" >
                                                                        <td>
                                                                            <textarea required name="subKraName[{{ $item['kra']->KRAId }}][]" maxlength="350" class="form-control" placeholder="Enter sub KRA" rows="2" style="width:250px;min-height:70px; overflow:hidden; resize:none;" 
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA }}</textarea>
                                                                        </td>
                                                                        <td>
                                                                            <textarea  name="subKraDesc[{{ $item['kra']->KRAId }}][]" maxlength="600" class="form-control" placeholder="Enter sub KRA description" rows="2" style="width:300px;min-height:70px; overflow:hidden; resize:none;"  
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>{{ $subKra->KRA_Description }}</textarea>
                                                                        </td>
                                                                        <td>
                                                                            <select id="Measure_subKRA_{{ $subKra->KRASubId }}" name="Measure_subKRA[{{ $item['kra']->KRAId }}][]"required >
                                                                            <option value="Process" {{ $subKra->Measure == 'Process' ? 'selected' : '' }}>Process</option>
                                                                            <option value="Acreage" {{ $subKra->Measure == 'Acreage' ? 'selected' : '' }}>Acreage</option>
                                                                            <option value="Event" {{ $subKra->Measure == 'Event' ? 'selected' : '' }}>Event</option>
                                                                            <option value="Program" {{ $subKra->Measure == 'Program' ? 'selected' : '' }}>Program</option>
                                                                            <option value="Maintenance" {{ $subKra->Measure == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                                            <option value="Time" {{ $subKra->Measure == 'Time' ? 'selected' : '' }}>Time</option>
                                                                            <option value="Yield" {{ $subKra->Measure == 'Yield' ? 'selected' : '' }}>Yield</option>
                                                                            <option value="Value" {{ $subKra->Measure == 'Value' ? 'selected' : '' }}>Value</option>
                                                                            <option value="Volume" {{ $subKra->Measure == 'Volume' ? 'selected' : '' }}>Volume</option>
                                                                            <option value="Quantity" {{ $subKra->Measure == 'Quantity' ? 'selected' : '' }}>Quantity</option>
                                                                            <option value="Quality" {{ $subKra->Measure == 'Quality' ? 'selected' : '' }}>Quality</option>
                                                                            <option value="Area" {{ $subKra->Measure == 'Area' ? 'selected' : '' }}>Area</option>
                                                                            <option value="Amount" {{ $subKra->Measure == 'Amount' ? 'selected' : '' }}>Amount</option>
                                                                            <option value="None" {{ $subKra->Measure == 'None' ? 'selected' : '' }}>None</option>
                                                                            </select>
                                                                        </td>
                                                                        <!-- Unit Dropdown -->
                                                                        <td>
                                                                            <select id="Unit_subKRA_{{ $subKra->KRASubId }}" name="Unit_subKRA[{{ $item['kra']->KRAId }}][]" style="width:75px;" required>
                                                                            <option value="%" {{ $subKra->Unit == '%' ? 'selected' : '' }}>%</option>
                                                                            <option value="Acres" {{ $subKra->Unit == 'Acres' ? 'selected' : '' }}>Acres</option>
                                                                            <option value="Days" {{ $subKra->Unit == 'Days' ? 'selected' : '' }}>Days</option>
                                                                            <option value="Month" {{ $subKra->Unit == 'Month' ? 'selected' : '' }}>Month</option>
                                                                            <option value="Hours" {{ $subKra->Unit == 'Hours' ? 'selected' : '' }}>Hours</option>
                                                                            <option value="Kg" {{ $subKra->Unit == 'Kg' ? 'selected' : '' }}>Kg</option>
                                                                            <option value="Ton" {{ $subKra->Unit == 'Ton' ? 'selected' : '' }}>Ton</option>
                                                                            <option value="MT" {{ $subKra->Unit == 'MT' ? 'selected' : '' }}>MT</option>
                                                                            <option value="Kg/Acre" {{ $subKra->Unit == 'Kg/Acre' ? 'selected' : '' }}>Kg/Acre</option>
                                                                            <option value="Number" {{ $subKra->Unit == 'Number' ? 'selected' : '' }}>Number</option>
                                                                            <option value="Lakhs" {{ $subKra->Unit == 'Lakhs' ? 'selected' : '' }}>Lakhs</option>
                                                                            <option value="Rs." {{ $subKra->Unit == 'Rs.' ? 'selected' : '' }}>Rs.</option>
                                                                            <option value="INR" {{ $subKra->Unit == 'INR' ? 'selected' : '' }}>INR</option>
                                                                            <option value="None" {{ $subKra->Unit == 'None' ? 'selected' : '' }}>None</option>
                                                                            </select>
                                                                        </td>
                                                                        <!-- Weightage -->
                                                                        <td>
                                                                            <input placeholder="Enter weightage" type="number" name="Weightage_subKRA[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->Weightage }}" style="width: 78px;" required>
                                                                        </td>
                                                                        <!-- Logic Dropdown -->
                                                                        <td>
                                                                            <select name="Logic_subKRA[{{ $item['kra']->KRAId }}][]" style="width:75px;" required>
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}"
                                                                            {{ $subKra->Logic == $logic->logicMn ? 'selected' : '' }}>
                                                                            {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <!-- Period Dropdown -->
                                                                        <td>
                                                                            <select id="Period_subKRA_{{ $subKra->KRASubId }}" name="Period_subKRA[{{ $item['kra']->KRAId }}][]" style="width:90px;" required>
                                                                            <option value="Annual" {{ $subKra->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                            <option value="1/2 Annual" {{ $subKra->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                            <option value="Quarter" {{ $subKra->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                            <option value="Monthly" {{ $subKra->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                            </select>
                                                                        </td>
                                                                        <!-- Target Input -->
                                                                        <td>
                                                                            <input id="Tar_a{{ $subKra->KRASubId }}" type="number" min="0"
                                                                            name="Target_subKRA[{{ $item['kra']->KRAId }}][]" placeholder="Enter target" value="100"
                                                                            required 
                                                                            class=" 
                                                                            @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                            btn btn-outline-success custom-toggle
                                                                            @endif
                                                                            "
                                                                            style="width:60px; 
                                                                            @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '') 
                                                                            cursor: pointer;
                                                                            color: #000099;
                                                                            @else
                                                                            cursor: default;
                                                                            color: black;
                                                                            @endif"
                                                                            value="{{ $subKra->Target }}"
                                                                            maxlength="8"
                                                                            @if($item['kra']->EmpStatus == 'A' && $subKra->Period != 'Annual' && $subKra->Period != '')
                                                                            onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}', {{ $year_kra->NewY }})"
                                                                            @else
                                                                            @endif>
                                                                        </td>
                                                                        <td>
                                                                            <button class="deleteSubKra" data-subkra-id="{{ $subKra->KRASubId }}">
                                                                            <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            </tr>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            @for ($i = 1; $i <= 5; $i++)
                                                            <tr id="kraRow_New{{ $i }}">
                                                            <td><b>{{ $i }}.</b></td>
                                                            <td>
                                                                <textarea type="text" name="kra[]" class="form-control"placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none; min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required maxlength="350"></textarea>
                                                            </td>
                                                            <td>
                                                                <textarea type="text" name="kra_description[]" class="form-control"placeholder="Enter description" required style="width:300px; overflow:hidden; resize:none; min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600"></textarea>
                                                            </td>
                                                            <td>
                                                                <select name="Measure[]" style="width:95px;"required>
                                                                    <option value=""></option>
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
                                                                <select name="Unit[]" style="width:75px;" required>
                                                                    <option value=""></option>
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
                                                            <td><input type="number" name="weightage[]" required placeholder="Enter weightage" style="width: 69px;" ></td>
                                                            <td>
                                                                <select name="Logic[]" style="width:75px;" required>
                                                                    <option value=""></option>
                                                                    @foreach($logicData as $logic)
                                                                    <option value="{{ $logic->logicMn }}">{{ $logic->logicMn }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="Period[]" style="width:90px;" required >
                                                                    <option value=""></option>
                                                                    <option value="Annual">Annually</option>
                                                                    <option value="1/2 Annual">Half Yearly</option>
                                                                    <option value="Quarter">Quarterly</option>
                                                                    <option value="Monthly">Monthly</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="number" name="Target[]" value="100" required class="Inputa" placeholder="Enter Target" style="width:75px;" ></td>
                                                            <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtnNew"></button></td>
                                                            </tr>
                                                            @endfor
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                    <!-- <button type="button" class="btn btn-success" id="addKraBtn">Add Kra</button> -->
                                                    <button type="button" class="effect-btn btn btn-success squer-btn sm-btn" id="addKraBtnNew">
                                                    Add Kra <i class="fas fa-plus-circle"></i>
                                                    </button>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div class="tab-pane fade" id="Appraisal{{$yearPms}}" role="tabpanel">
                                    <div class="row">

                                        <div class="mfh-machine-profile">
                                            <div style="margin-top: -31px;float:left;margin-left: 295px;">
                                                <ul class="kra-btns nav nav-tabs border-0" id="myTab2" role="tablist">
                                                <li>
                                                        @isset($pms_id->Emp_AchivementSave, $pms_id->Emp_KRASave, $pms_id->Emp_SkillSave, $pms_id->Emp_FeedBackSave)
                                                                @if (
                                                                    $pms_id->Emp_AchivementSave === 'Y' &&
                                                                    $pms_id->Emp_KRASave === 'Y' &&
                                                                    $pms_id->Emp_SkillSave === 'Y' &&
                                                                    $pms_id->Emp_FeedBackSave === 'Y' && 
                                                                    $pms_id->Emp_PmsStatus != 2

                                                                )
                                                                    <a class="effect-btn btn btn-light squer-btn sm-btn" id="finalSubmitBtn">
                                                                        Final Submit
                                                                        <i class="fas fa-check-circle mr-2"></i>
                                                                    </a>
                                                                @endif
                                                            @endisset
                                                    </li>

                                                 
                                                    <li class="mt-1">
                                                    <a class="active" id="home-tab1" data-bs-toggle="tab" 
                                                        href="#achievements" role="tab"
                                                        aria-controls="home" aria-selected="true"
                                                        onclick="updateSubTabURL('achievements')">
                                                            Achievements <i class="fas fa-star mr-2"></i>
                                                        </a>
                                                    </li>
                                                    <li class="mt-1">
                                                    <a class="" id="profile-tab20" data-bs-toggle="tab" 
                                                        href="#formAkra" role="tab"
                                                        aria-controls="profile" aria-selected="false"
                                                        onclick="updateSubTabURL('formAkra')">
                                                            Form A(KRA) <i class="fas fa-file-alt mr-2"></i>
                                                        </a>
                                                </li>
                                                        
                                                <li class="mt-1">
                                                <a class="" id="profile-tab21" data-bs-toggle="tab" 
                                                            href="#formBskill" role="tab"
                                                            aria-controls="profile" aria-selected="false"
                                                            onclick="updateSubTabURL('formBskill')">
                                                                Form B(Skill) <i class="fas fa-file-invoice mr-2"></i>
                                                            </a>
                                                    </li>
                                                    <li class="mt-1">
                                                    <a class="" id="profile-tab22" data-bs-toggle="tab" 
                                                        href="#feedback" role="tab"
                                                        aria-controls="profile" aria-selected="false"
                                                        onclick="updateSubTabURL('feedback')">
                                                            Feedback <i class="fas fa-file-signature mr-2"></i>
                                                        </a>
                                                </li>
                                                @isset($pms_id->Emp_AchivementSave, $pms_id->Emp_KRASave, $pms_id->Emp_SkillSave, $pms_id->Emp_FeedBackSave)
                                                                @if (
                                                                    $pms_id->Emp_PmsStatus != 2
                                                                )
                                                                <li class="mt-1">
                                                                <a class="" id="profile-tab23" data-bs-toggle="tab" 
                                                                    href="#upload" role="tab"
                                                                    aria-controls="profile" aria-selected="false"
                                                                    onclick="updateSubTabURL('upload')">
                                                                        Upload <i class="fas fa-file-upload mr-2"></i>
                                                                    </a>
                                                            </li>
                                                            @else
                                                            @endif
                                                            @endisset
                                                 

                                                <li class="mt-1">
                                                    <a href="javascript:void(0)" onclick="printViewAppraisal()">Print <i class="fas fa-print mr-2"></i></a>
                                                </li>
                                                <li class="mt-1"><a class="float-end" data-bs-toggle="modal" data-bs-target="#pmshelpvideo" >PMS Help Video</a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-content splash-content2" id="myTabContent2">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show {{ request('active_subtab') == 'achievements' ? 'show active' : '' }}" id="achievements" role="tabpanel">
                                                    <div class="card ViewAppraisalContent" >
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Achievements</b>
                                                            @if (isset($kraDatalastrevertpms))

                                                                @if ($kraDatalastrevertpms->Emp_PmsStatus == '3')
                                                                        <span class="float-end blinking-text" style="margin-left: 10px;" title="{{ $kraDatalastrevertpms->App_Reason }}" data-bs-tooltip="{{ $kraDatalastrevertpms->App_Reason }}">
                                                                            <strong style="color: #4d5bff; font-size:14px;">Your KRA has been reverted</strong>
                                                                        </span>
                                                                    @else
                                                                
                                                                @endif
                                                            @endif
                                                            @isset($pms_id->Emp_AchivementSave, $pms_id->Emp_KRASave, $pms_id->Emp_SkillSave, $pms_id->Emp_FeedBackSave)
                                                                @if (
                                                                    $pms_id->Emp_PmsStatus != 2
                                                                )
                                                            <!-- Button logic -->
                                                            @if($pms_achievement_data->isEmpty())
                                                                    <a id="saveDraft" class="effect-btn btn btn-success squer-btn sm-btn float-end">Save as Draft</a>
                                                                @else
                                                                    <a id="editAchievements" class="effect-btn btn btn-primary squer-btn sm-btn float-end">Edit</a>
                                                                    <a id="saveDraft" class="effect-btn btn btn-success squer-btn sm-btn float-end d-none">Save as Draft</a>
                                                            @endif
                                                            @endif
                                                            @endisset

                                                        </div>
                                                        <div class="card-body table-responsive">
                                                            <ol class="achievements-list" id="achievementsList">
                                                                @if($pms_achievement_data->isEmpty())
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <li class="d-flex align-items-center mb-2">
                                                                            <span class="sno me-2">{{ $i }}.</span>
                                                                            <textarea class="form-control me-2 achievement-input" placeholder="Enter your achievement {{ $i }}" style="width: 85%;" type="text" ></textarea>
                                                                            <button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeAchievement {{ $i == 1 ? 'd-none' : '' }}"></button>
                                                                        </li>
                                                                    @endfor
                                                                @else
                                                                    @foreach($pms_achievement_data as $index => $achievement)
                                                                        <li class="d-flex align-items-center mb-2" data-id="{{ $achievement->AchivementId }}">
                                                                            <span class="sno me-2">{{ $index + 1 }}.</span>
                                                                            <textarea class="form-control me-2 achievement-input" placeholder="Enter your achievement" value="{{ $achievement->Achivement }}" style="width: 85%;" type="text" readonly >{{ $achievement->Achivement }}</textarea>
                                                                            <button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeDeleteachievemnet d-none {{ $index == 0 ? 'd-none' : '' }}" data-achid="{{ $achievement->AchivementId }}"></button>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ol>

                                                        <!-- "Add Achievement" Button: Only Visible When No Data Exists -->
                                                        <a class="effect-btn btn btn-success squer-btn sm-btn {{ $pms_achievement_data->isEmpty() ? '' : 'd-none' }}" id="addAchievement">
                                                                Add &nbsp;<i class="fas fa-plus-circle"></i>
                                                            </a>          
                                                      </div>

                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade {{ request('active_subtab') == 'formAkra' ? 'show active' : '' }}" id="formAkra" role="tabpanel">
                                                    <div class="card ViewAppraisalContent">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Form A (KRA)</b>
                                                            @if (isset($kraDatalastrevertpms))

                                                                @if ($kraDatalastrevertpms->Emp_PmsStatus == '3')
                                                                        <span class="float-end blinking-text" style="margin-left: 10px;" title="{{ $kraDatalastrevertpms->App_Reason }}" data-bs-tooltip="{{ $kraDatalastrevertpms->App_Reason }}">
                                                                            <strong style="color: #4d5bff; font-size:14px;">Your KRA has been reverted</strong>
                                                                        </span>
                                                                    @else

                                                                @endif
                                                            @endif
                                                            @isset($pms_id->Emp_AchivementSave, $pms_id->Emp_KRASave, $pms_id->Emp_SkillSave, $pms_id->Emp_FeedBackSave)
                                                                @if (
                                                                    $pms_id->Emp_PmsStatus != 2
                                                                )
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end" id="editforma">Edit</a>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end" id="saveforma" style="display: none;">Save as Draft</a>
                                                            @endif
                                                            @endisset
                                                        </div>
                                                        <div class="card-body table-responsive ViewAppraisalContentforma">
                                                            <table class="table table-pad">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN.</th>
                                                                        <th style="width: 215px;">KRA/Goals</th>
                                                                        <th style="width: 300px;">Description</th>
                                                                        <th>Measure</th>
                                                                        <th>Unit</th>
                                                                        <th>Weightage</th>
                                                                        <th>Logic</th>
                                                                        <th>Period</th>
                                                                        <th>Target</th>
                                                                        <th>Self Rating</th>
                                                                        <th>Remarks</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        // Initialize grand total
                                                                        $grandTotalScore = 0;
                                                                    @endphp
                                                                    @foreach ($employeePmsKraforma as $index => $kraforma)
                                                                        <tr>
                                                                            <td><b>{{ $index + 1 }}.</b></td>
                                                                            <td style="width: 215px;">{{ optional($kraforma->kra->first())->KRA ?? 'N/A' }}</td>
                                                                            <td style="width: 300px;">{{ optional($kraforma->kra->first())->KRA_Description ?? 'N/A' }}</td>
                                                                            <td>{{ optional($kraforma->kra->first())->Measure ?? 'N/A' }}</td>
                                                                            <td>{{ optional($kraforma->kra->first())->Unit ?? 'N/A' }}</td>
                                                                            <td>{{ fmod($kraforma->Weightage, 1) == 0.0 ? number_format($kraforma->Weightage, 0) : number_format($kraforma->Weightage, 2) }}</td>
                                                                            <td>{{ $kraforma->Logic ?? 'N/A' }}</td>
                                                                            <td>{{ $kraforma->Period ?? 'N/A' }}</td>
                                                                            @if ($kraforma->submr->isEmpty())

                                                                            <td>
                                                                                @if ($kraforma->Period !== 'Annual')
                                                                                          
                                                                                    <button
                                                                                    id="Tar_kra_{{ $kraforma->KRAId }}"
                                                                                        style="padding: 5px 8px;" 
                                                                                        type="button" 
                                                                                        class="btn btn-outline-success custom-toggle" 
                                                                                        data-bs-toggle="modal"
                                                                                        onClick="showKraDetailsappraisal('{{ $kraforma->KRAId }}', '{{ $kraforma->Period }}', '{{ $kraforma->Target }}', '{{ $kraforma->Weightage }}', '{{ $kraforma->Logic }}', '{{ $year_pms->CurrY }}')">
                                                                                        <span class="icon-on">{{ fmod($kraforma->Target, 1) == 0.0 ? number_format($kraforma->Target, 0) : number_format($kraforma->Target, 2) }}</span>

                                                                                    </button>
                                                                                @else
                                                                                <span class="icon-on">{{ fmod($kraforma->Target, 1) == 0.0 ? number_format($kraforma->Target, 0) : number_format($kraforma->Target, 2) }}</span>
                                                                                @endif
                                                                            </td>

                                                                            @php
                                                                            $kraAchSum = DB::table('hrm_pms_kra_tgtdefin')
                                                                                                            ->where('KRAId', $kraforma->KRAId)
                                                                                                            ->sum('ach');
                                                                                                          

                                                                                                            if ($kraforma->Period === 'Annual') {
                                                                                                                    $adjustedAch = $kraforma->SelfRating;
                                                                                                                }
                                                                                                                else{
                                                                                                                    $adjustedAch = DB::table('hrm_pms_kra_tgtdefin')
                                                                                                                                        ->where('KRAId', $kraforma->KRAId)
                                                                                                                                        ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                                        ->sum('LogScr');
                                                                                                                }
                                                                                                                if ($kraforma->Period === 'Annual') {
                                                                                                                    $krascoreSum = DB::table('hrm_employee_pms_kraforma')
                                                                                                                    ->where('KRAFormAId', $kraforma->KRAFormAId)
                                                                                                                    ->sum('SelfKRAScore');
                                                                                                                }
                                                                                                                else{
                                                                                                                    $krascoreSum = DB::table('hrm_pms_kra_tgtdefin')
                                                                                                                        ->where('KRAId', $kraforma->KRAId)
                                                                                                                        ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                        ->sum('Scor');
                                                                                                                }
                                                                                                           
                                                                                                            if ($kraforma->Period === 'Annual') {
                                                                                                                $adjustedAch = $kraforma->SelfRating;
                                                                                                            }
                                                                                                            $kralogSum = DB::table('hrm_employee_pms_kraforma')->where('KRAFormAId', $kraforma->KRAFormAId)->sum('SelfKRALogic');                                                                                  

                                                                                                            // Add to grand total
                                                                                                          
                                                                                        @endphp
                                                                                        <td>
                                                                                        @if ($kraforma->Period != 'Annual')
                                                                                            <span class="display-value">{{ round($adjustedAch, 2) }}</span>
                                                                                        @else
                                                                                            <input
                                                                                                type="number" readonly
                                                                                                class="form-control annual-rating-kra"
                                                                                                style="width:62px;"
                                                                                                value="{{ round($adjustedAch, 2) }}"
                                                                                                placeholder="Enter rating"
                                                                                                data-target="{{ $kraforma->Target }}"
                                                                                                data-logic="{{ $kraforma->Logic }}"
                                                                                                data-index="{{ $kraforma->KRAId }}"
                                                                                                data-weight="{{ $kraforma->Weightage }}"
                                                                                            >
                                                                                        @endif
                                                                                    </td>

                                                                                        <td>
                                                                                                <!-- Display the remark in a span initially -->
                                                                                                <span class="display-remark">{{ $kraforma->AchivementRemark }}</span>
                                                                                                
                                                                                                <!-- Textarea, hidden by default -->
                                                                                                <textarea
                                                                                                    style="min-height:50px; min-width:170px; overflow:hidden; resize:none; display:none;"
                                                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                                                                                                    class="form-control"
                                                                                                    id="kraremark{{ $kraforma->KRAId }}"
                                                                                                    placeholder="Enter your remarks">{{ $kraforma->AchivementRemark }}</textarea>
                                                                                            </td>
                                                                                                                                                                                
                                                                                    <td>
                                                                                        <input type="hidden" id="krascore{{$kraforma->KRAId}}" value="{{$krascoreSum,2}}" class="form-control " >
                                                                                    </td>
                                                                                    <td>
                                                                                        <span id="logScorekra{{$kraforma->KRAId}}" class="d-none">{{$kralogSum,2}}</span>
                                                                                    </td>
                                                                                    
                                                                                @endif
                                                                        </tr>

                                                                        <!-- Display Sub-KRA Data -->
                                                                        @if ($kraforma->submr->isNotEmpty())
                                                                            <tr>
                                                                                <td colspan="12">
                                                                                    <table class="table" style="background-color:#ECECEC;">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>SN.</th>
                                                                                                <th style="width: 215px;">Sub KRA/Goals</th>
                                                                                                <th style="width: 300px;">Description</th>
                                                                                                <th>Measure</th>
                                                                                                <th>Unit</th>
                                                                                                <th>Weightage</th>
                                                                                                <th>Logic</th>
                                                                                                <th>Period</th>
                                                                                                <th>Target</th>
                                                                                                <th>Self Rating</th>
                                                                                                <th>Remarks</th>
                                                                                                <th></th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($kraforma->submr as $subIndex => $subkra)
                                                                                                <tr>
                                                                                                    <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                                    <td>{{ $subkra->KRA ?? '' }}</td>
                                                                                                    <td>{{ $subkra->KRA_Description ?? '' }}</td>
                                                                                                    <td>{{ $subkra->Measure ?? '' }}</td> <!-- From KRA -->
                                                                                                    <td>{{ $subkra->Unit ?? '' }}</td> <!-- From KRA -->
                                                                                                    <td>{{ fmod($subkra->Weightage, 1) == 0.0 ? number_format($subkra->Weightage, 0) : number_format($subkra->Weightage, 2) }}</td>

                                                                                                    <td>{{ $subkra->Logic ?? '' }}</td>
                                                                                                    <td>{{ $subkra->Period ?? '' }}</td>                                                                                                   

                                                                                                    <td>
                                                                                                        @if ($subkra->Period !== 'Annual')
                                                                                                       
                                                                                                            <button
                                                                                                            id="Tar_a{{ $subkra->KRASubId }}"
                                                                                                                style="padding: 5px 8px;" 
                                                                                                                type="button" 
                                                                                                                class="btn btn-outline-success custom-toggle" 
                                                                                                                data-bs-toggle="modal"
                                                                                                                
                                                                                                                onClick="showKraDetailsappraisal('sub_{{ $subkra->KRASubId }}', '{{ $subkra->Period }}', '{{ $subkra->Target }}', '{{ $subkra->Weightage }}', '{{ $subkra->Logic }}', '{{ $year_pms->CurrY }}')">
                                                                                                                <span class="icon-on">{{fmod($subkra->Target, 1) == 0.0 ? number_format($subkra->Target, 0) : number_format($subkra->Target, 2) }}</span>

                                                                                                            </button>
                                                                                                        @else
                                                                                                        <span class="icon-on">{{fmod($subkra->Target, 1) == 0.0 ? number_format($subkra->Target, 0) : number_format($subkra->Target, 2) }}</span>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    @php
                                                                                                            $subKraAchSum = DB::table('hrm_pms_kra_tgtdefin')
                                                                                                                                    ->where('KRASubId', $subkra->KRASubId)
                                                                                                                                    ->sum('ach');
                                                                                                              
                                                                                                            if ($subkra->Period === 'Annual') {
                                                                                                                    $adjustedAchsub = $subkra->SelfRating;
                                                                                                                }
                                                                                                                else{
                                                                                                                    $adjustedAchsub = DB::table('hrm_pms_kra_tgtdefin')
                                                                                                                                        ->where('KRASubId', $subkra->KRASubId)
                                                                                                                                        ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                                        ->sum('LogScr');
                                                                                                                }
                                                                                                                if ($subkra->Period === 'Annual') {
                                                                                                                    $subKraScrSum = $subkra->SelfKRAScore;
                                                                                                                }
                                                                                                                else{
                                                                                                                    $subKraScrSum = DB::table('hrm_pms_kra_tgtdefin')
                                                                                                                                    ->where('KRASubId', $subkra->KRASubId)
                                                                                                                                    ->sum('Scor');
                                                                                                                }

                                                                                                           

                                                                                                            if ($subkra->Period === 'Annual') {
                                                                                                            $subKralogSum = $subkra->SelfKRALogic;
                                                                                                            }
                                                                                                            else{
                                                                                                                $subKralogSum = DB::table('hrm_pms_kra_tgtdefin')->where('KRASubId', $subkra->KRASubId)->sum('LogScr');
                                                                                                            }
                                                                                                                                                                                                                           
                                                                                                            @endphp
                                                                                                            @if ($subkra->Period != 'Annual') 

                                                                                                                    <span id="display-rating-{{ $subkra->KRASubId }}"
                                                                                                                                data-index="{{ $subkra->KRASubId }}"
                                                                                                                                    data-target="{{ $subkra->Target }}" 
                                                                                                                                    data-logic="{{ $subkra->Logic }}" 
                                                                                                                                    data-weight="{{ $subkra->Weightage }}"
                                                                                                                    >{{ $adjustedAchsub ?? 0 }}</span>
                                                                                                            @else
                                                                                                                    <input
                                                                                                                        id="input-rating-{{ $subkra->KRASubId }}"
                                                                                                                        style="width:62px;" readonly
                                                                                                                        type="number" 
                                                                                                                        value="{{ $adjustedAchsub ?? 0 }}"
                                                                                                                        class="form-control annual-rating-subkra"
                                                                                                                        placeholder="Enter rating" 
                                                                                                                        data-index="{{ $subkra->KRASubId }}"
                                                                                                                        data-target="{{ $subkra->Target }}" 
                                                                                                                        data-logic="{{ $subkra->Logic }}" 
                                                                                                                        data-weight="{{ $subkra->Weightage }}">
                                                                                                                @endif
                                                                                                                </td>

                                                                                                                <td>
                                                                                                                    <!-- Display the remark as plain text -->
                                                                                                                    <span id="display-remark-{{ $subkra->KRASubId }}">{{ $subkra->AchivementRemark }}</span>
                                                                                                                    
                                                                                                                    <!-- Textarea, hidden by default -->
                                                                                                                    <textarea
                                                                                                                        id="textarea-remark-{{ $subkra->KRASubId }}"
                                                                                                                        style="min-height:50px; min-width:170px; overflow:hidden; resize:none; display:none;"
                                                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                                                                                                                        class="form-control"
                                                                                                                        placeholder="Enter your remarks">{{ $subkra->AchivementRemark }}</textarea>
                                                                                                                </td>

                                                                                                    <td>
                                                                                                        <input type="hidden" id="subkrascore{{$subkra->KRASubId}}" value="{{$subKraScrSum,2}}"
                                                                                                                class="form-control" >
                                                                                                       
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <span id="logScoresubkra{{$subkra->KRASubId}}" class="d-none">{{$subKralogSum,2}}</span>
                                                                                                        
                                                                                                        </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                    @php 
                                                                        $grandtotalscorepms  = DB::table('hrm_employee_pms')->where('EmployeeID', Auth::user()->EmployeeID)
                                                                                        ->where('AssessmentYear',$PmsYId)
                                                                                        ->where('CompanyId',Auth::user()->CompanyId)
                                                                                        ->first();

                                                                    @endphp
                                                                    <!-- Display Grand Total -->
                                                                <tr class="d-none">
                                                                    <td colspan="10">Grand Total Score (KRA + Sub-KRA):</td>
                                                                    <td name="grandtotalfinalemp" id="grandtotalfinalemp">
                                                                            {{ $grandtotalscorepms->EmpFormAScore !== null ? round($grandtotalscorepms->EmpFormAScore, 2) : '0.00' }}
                                                                        </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade {{ request('active_subtab') == 'formBskill' ? 'show active' : '' }}"  id="formBskill" role="tabpanel">
                                                    <div class="card ViewAppraisalContent">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Form B (Skills)</b>
                                                            @if (isset($kraDatalastrevertpms))

                                                                @if ($kraDatalastrevertpms->Emp_PmsStatus == '3')
                                                                        <span class="float-end blinking-text" style="margin-left: 10px;" title="{{ $kraDatalastrevertpms->App_Reason }}" data-bs-tooltip="{{ $kraDatalastrevertpms->App_Reason }}">
                                                                            <strong style="color: #4d5bff; font-size:14px;">Your KRA has been reverted</strong>
                                                                        </span>
                                                                    @else

                                                                @endif
                                                            @endif
                                                            @isset($pms_id->Emp_AchivementSave, $pms_id->Emp_KRASave, $pms_id->Emp_SkillSave, $pms_id->Emp_FeedBackSave)
                                                                @if (
                                                                    $pms_id->Emp_PmsStatus != 2
                                                                )
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end" id="editformb">Edit</a>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end" id="saveformb" style="display: none;">Save as Draft</a>
                                                            @endif
                                                        @endisset
                                                        </div>

                                                        <div class="card-body table-responsive dd-flex align-items-center ViewAppraisalContent" >
                                                        <table class="table table-pad">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>SN.</th>
                                                                            <th style="width:215px;">Behavioral/Skills</th>
                                                                            <th style="width:300px;">Description</th>
                                                                            <th>Weightage</th>
                                                                            <th>Logic</th>
                                                                            <th>Period</th>
                                                                            <th>Target</th>
                                                                            <th>Self Rating</th>
                                                                            <th>Remarks</th>
                                                                        </tr>
                                                                    </thead>
                                                                   
                                                                    <tbody>
                                                                     @php
                                                                        // Initialize grand total
                                                                        $grandTotalScore = 0;
                                                                    @endphp
                                                                        @foreach($behavioralForms as $index => $form)
                                                                        @php 

                                                                        $subForms = $behavioralFormssub->where('FormBId', $form->FormBId);
                                                                        @endphp
                                                                            <tr>
                                                                                <td><b>{{ $index + 1 }}.</b></td>
                                                                                <td style="width:215px;">{{ $form->Skill }}</td>
                                                                                <td style="width:300px;">{{ $form->SkillComment }}</td>
                                                                           
                                                                                    @if($subForms->isEmpty())  <!-- Only show these columns if there are no subforms -->
                                                                                        <td>{{ fmod($form->Weightage, 1) == 0.0 ? number_format($form->Weightage, 0) : number_format($form->Weightage, 2) }}</td>

                                                                                        <td>{{ $form->Logic }}</td>
                                                                                        <td>{{ $form->Period }}</td>
                                                                                        <td>
                                                                                            @if ($form->Period != 'Annual' && $form->Period != '')
                                                                                                <button
                                                                                                        style="padding: 5px 8px;" 
                                                                                                        type="button" 
                                                                                                        class="btn btn-outline-success custom-toggle" 
                                                                                                        data-bs-toggle="modal"
                                                                                                        onclick="FunFormBTgt(
                                                                                                            '{{ $form->FormBId }}',
                                                                                                            '{{ $form->Period }}',
                                                                                                            {{ intval($form->Target) }},
                                                                                                            {{ intval($form->Weightage) }},
                                                                                                            '{{ $form->Logic }}',
                                                                                                            {{ $PmsYId }})">

                                                                                                    <span class="icon-on">{{ fmod($form->Target, 1) == 0.0 ? number_format($form->Target, 0) : number_format($form->Target, 2) }}</span> 
                                                                                                </button>
                                                                                            @else
                                                                                            <span class="icon-on">{{ fmod($form->Target, 1) == 0.0 ? number_format($form->Target, 0) : number_format($form->Target, 2) }}</span> 
                                                                                            @endif
                                                                                        </td>
                                                                                        @php
                                                                                            $kraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                            ->where('FormBId', $form->FormBId)
                                                                                                            ->where('EmployeeID', Auth::user()->EmployeeID)
                                                                                                            ->where('YearId', $PmsYId)
                                                                                                            ->sum('ach');
                                                                                            
                                                                                            
                                                                                                if ($form->Period === 'Annual') {
                                                                                                    $adjustedAch = $form->SelfRating;
                                                                                                }
                                                                                                else{
                                                                                                    $adjustedAch = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                            ->where('FormBId', $form->FormBId)
                                                                                                                            ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                            ->sum('LogScr');
                                                                                                }
                                                                                                if ($form->Period === 'Annual') {
                                                                                                                $logscore = $form->SelfFormBLogic;
                                                                                                            }
                                                                                                            else{
                                                                                                                $logscore = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                            ->where('FormBId', $form->FormBId)
                                                                                                                            ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                            ->sum('LogScr');
                                                                                                            }
                                                                                                
                                                                                                            if ($form->Period != 'Annual') {

                                                                                                                $krascoreSum = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                ->where('FormBId', $form->FormBId)
                                                                                                                ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                                        ->where('YearId',$PmsYId)
                                                                                                                                        ->sum('Scor');

                                                                                                                                    
                                                                                                                }
                                                                                                                else{
                                                                                                                    $krascoreSum = DB::table('hrm_employee_pms_behavioralformb')
                                                                                                                                    ->where('BehavioralFormBId', $form->BehavioralFormBId)
                                                                                                                                    ->sum('SelfFormBScore');
                                                                                                                }
                                                                                              
                                                                                                 
                                                                                          // Add to grand total
                                                                                            $grandTotalScore += $krascoreSum;
                                                                                        @endphp
                                                                                        <td>


                                                                                        <span id="display-rating-formb-{{ $form->BehavioralFormBId }}">{{ round($adjustedAch, 2) }}</span>
                                                                                        
                                                                                        <!-- Input field, hidden by default -->
                                                                                        <input
                                                                                            id="input-rating-formb-{{ $form->BehavioralFormBId }}"
                                                                                            style="width:70px; display:none;" 
                                                                                            type="number"
                                                                                            maxlength="12"
                                                                                            value="{{ round($adjustedAch, 2) }}"
                                                                                            class="form-control annual-rating-formb"
                                                                                            placeholder="Enter rating"
                                                                                            data-period="{{ $form->Period }}"
                                                                                            data-target="{{ $form->Target }}"
                                                                                            data-logic="{{ $form->Logic }}"
                                                                                            data-index="{{ $form->BehavioralFormBId }}"
                                                                                            data-weight="{{ $form->Weightage }}"
                                                                                        >
                                                                                        
                                                                                    </td>

                                                                                    <td>
                                                                                        <!-- Display the remarks as plain text -->
                                                                                        <input id="display-remark-formb-{{ $form->BehavioralFormBId }}" type="text" value="{{ $form->Comments_Example }}" readonly>
                                                                                        
                                                                                        <!-- Textarea, hidden by default -->
                                                                                        <textarea
                                                                                            id="textarea-remark-formb-{{ $form->BehavioralFormBId }}"
                                                                                            style="min-height:50px; min-width:170px; overflow:hidden; resize:none; display:none;"
                                                                                            oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                                                                                            class="form-control"
                                                                                            placeholder="Enter your remarks">{{ $form->Comments_Example }}</textarea>
                                                                                    </td>
                                                                                    <input type="hidden" class="logscore" value="{{$logscore,2}}" id="logScorekraformb{{$form->BehavioralFormBId}}">

                                                                                    @endif
                                                                                                    
                                                                                    <td>
                                                                                        <input  type="hidden" id="krascoreformb{{$form->BehavioralFormBId}}" value="{{$krascoreSum,2}}" class="form-control" >
                                                                                    </td>

                                                                            </tr>
                                                                           
                                                                            @if($subForms->isNotEmpty())
                                                                                <tr>
                                                                                    <td colspan="9">
                                                                                        <table class="table" style="background-color:#ECECEC;">
                                                                                            <thead>
                                                                                                <tr>
                                                                                                    <th>SN.</th>
                                                                                                    <th style="width:215px;">Sub Behavioral/Skills</th>
                                                                                                    <th style="width:300px;"> Sub Behavioral Description</th>
                                                                                                    <th>Weightage</th>
                                                                                                    <th>Logic</th>
                                                                                                    <th>Period</th>
                                                                                                    <th>Target</th>
                                                                                                    <th>Self Rating</th>
                                                                                                    <th>Remarks</th>
                                                                                                </tr>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                @foreach($subForms as $subIndex => $subForm)
                                                                                                    <tr>
                                                                                                        <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                                        <td>{{ $subForm->Skill }}</td>
                                                                                                        <td>{{ $subForm->SkillComment }}</td>
                                                                                                        <td>{{ fmod($subForm->Weightage, 1) == 0.0 ? number_format($subForm->Weightage, 0) : number_format($subForm->Weightage, 2) }}</td>

                                                                                                        <td>{{ $subForm->Logic }}</td>
                                                                                                        <td>{{ $subForm->Period }}</td>
                                                                                                       
                                                                                                                <td>
                                                                                            @if ($subForm->Period != 'Annual' && $subForm->Period != '')
                                                                                                       
                                                                                                            <button
                                                                                                               style="padding: 5px 8px;" 
                                                                                                                type="button" 
                                                                                                                class="btn btn-outline-success custom-toggle" 
                                                                                                                data-bs-toggle="modal"
                                                                                                                onclick="FunFormBTgt(
                                                                                                                    'sub_{{ $subForm->FormBSubId }}',
                                                                                                                    '{{ $subForm->Period }}',
                                                                                                                    {{ intval($subForm->Target) }},
                                                                                                                    {{ intval($subForm->Weightage) }},
                                                                                                                    '{{ $subForm->Logic }}',
                                                                                                                    {{ $PmsYId }})">
                                                                                                                
                                                                                                                <span class="icon-on">{{ fmod($subForm->Target, 1) == 0.0 ? number_format($subForm->Target, 0) : number_format($subForm->Target, 2) }}</span> 

                                                                                                            </button>
                                                                                                        @else
                                                                                                        <span class="icon-on">{{ fmod($subForm->Target, 1) == 0.0 ? number_format($subForm->Target, 0) : number_format($subForm->Target, 2) }}</span> 
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td>
                                                                                                    @php
                                                                                                    if ($subForm->Period === 'Annual') {
                                                                                                                $subKraAchSum = $subForm->SelfRating;
                                                                                                            }
                                                                                                            else{
                                                                                                                $subKraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                                        ->where('FormBSubId', $subForm->FormBSubId)
                                                                                                                                        ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                                        ->where('YearId',$PmsYId)
                                                                                                                                        ->sum('ach');
                                                                                                               
                                                                                                            }
                                                                                                            if ($subForm->Period === 'Annual') {

                                                                                                            $adjustedAchsub = $subForm->SelfRating;
                                                                                                            }
                                                                                                            else{
                                                                                                                $adjustedAchsub = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                                ->where('FormBSubId', $subForm->FormBSubId)
                                                                                                                                ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                                ->where('YearId',$PmsYId)
                                                                                                                                ->sum('LogScr'); 
                                                                                                            }
                                                                                                            if ($subForm->Period === 'Annual') {
                                                                                                                $sublogscore = $subForm->SelfFormBLogic;
                                                                                                            }
                                                                                                            else{
                                                                                                                $sublogscore = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                            ->where('FormBSubId', $subForm->FormBSubId)
                                                                                                                            ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                            ->sum('LogScr');
                                                                                                            }
                                                                                                            if ($subForm->Period != 'Annual') {

                                                                                                                $subKraAchSum = DB::table('hrm_pms_formb_tgtdefin')
                                                                                                                                        ->where('FormBSubId', $subForm->FormBSubId)
                                                                                                                                        ->where('EmployeeID',Auth::user()->EmployeeID)
                                                                                                                                        ->where('YearId',$PmsYId)
                                                                                                                                        ->sum('Scor');
                                                                                                            }
                                                                                                            else{
                                                                                                                $subKraAchSum = $subForm->SelfFormBScore;
                                                                                                            }

                                                                                                                    
                                                                                                        $grandTotalScore += $subKraAchSum;
                                                                                                       
                                                                                                            @endphp
                                                                                                        <!-- Display the rating as plain text -->
                                                                                                        <span id="display-rating-subformb-{{ $subForm->FormBSubId }}">{{ round($adjustedAchsub,2)}}</span>
                                                                                                        
                                                                                                        <!-- Input field, hidden by default -->
                                                                                                        <input
                                                                                                            id="input-rating-subformb-{{ $subForm->FormBSubId }}"
                                                                                                            style="width:70px; display:none;" 
                                                                                                            type="number"
                                                                                                            value="{{ $adjustedAchsub ?? 0 }}"
                                                                                                            maxlength="12"
                                                                                                            class="form-control annual-rating-formb-subkra"
                                                                                                            placeholder="Enter rating"
                                                                                                            data-period="{{ $subForm->Period }}"
                                                                                                            data-index="{{ $subForm->FormBSubId }}"
                                                                                                            data-target="{{ $subForm->Target }}"
                                                                                                            data-logic="{{ $subForm->Logic }}"
                                                                                                            data-weight="{{ $subForm->Weightage }}"
                                                                                                        >
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        <!-- Display the remarks as plain text -->
                                                                                                        <span id="display-remark-subformb-{{ $subForm->FormBSubId }}">{{ $subForm->AchivementRemark }}</span>
                                                                                                        
                                                                                                        <!-- Textarea, hidden by default -->
                                                                                                        <textarea
                                                                                                            id="textarea-remark-subformb-{{ $subForm->FormBSubId }}"
                                                                                                            style="min-height:50px; min-width:170px; overflow:hidden; resize:none; display:none;"
                                                                                                            oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"
                                                                                                            class="form-control"
                                                                                                            placeholder="Enter your remarks">{{ $subForm->AchivementRemark }}</textarea>
                                                                                                    </td>

                                                                                                    <td>
                                                                                                        <input  type="hidden" id="subkrascoreformb{{$subForm->FormBSubId}}" value="{{$subKraAchSum,2}}"
                                                                                                                class="form-control" >
                                                                                                       
                                                                                                    </td>

                                                                                                    <input type="hidden" class="logscore" value="{{$sublogscore,2}}" id="logScoresubkraformb{{$subForm->FormBSubId}}">

                                                                                                    </tr>
                                                                                                    
                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                        <tr class="d-none">
                                                                            <td colspan="10">Grand Total Score (KRA + Sub-KRA):</td>
                                                                            <td name ="grandtotalfinalempFormb" id="grandtotalfinalempFormb">{{ round($grandTotalScore, 2) }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade {{ request('active_subtab') == 'feedback' ? 'show active' : '' }}" id="feedback" role="tabpanel">
                                                    <div class="card ViewAppraisalContent">
                                                    <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Feedback</b>
                                                            @if (isset($kraDatalastrevertpms))

                                                            @if ($kraDatalastrevertpms->Emp_PmsStatus == '3')
                                                                    <span class="float-end blinking-text" style="margin-left: 10px;" title="{{ $kraDatalastrevertpms->App_Reason }}" data-bs-tooltip="{{ $kraDatalastrevertpms->App_Reason }}">
                                                                        <strong style="color: #4d5bff; font-size:14px;">Your KRA has been reverted</strong>
                                                                    </span>
                                                                @else

                                                            @endif
                                                            @endif
                                                             @isset($pms_id->Emp_AchivementSave, $pms_id->Emp_KRASave, $pms_id->Emp_SkillSave, $pms_id->Emp_FeedBackSave)
                                                             @php
                                                                        $hasAnswerData = collect($feedback_que)->some(fn($feedback) => !empty($feedbackAnswers[trim($feedback->Environment)]));
                                                                    @endphp
                                                             @if ($pms_id->Emp_PmsStatus != 2)
                                                                   

                                                                    <button id="editButtonfeedback" class="btn btn-primary float-end {{ $hasAnswerData ? '' : 'd-none' }}" onclick="toggleEdit()">Edit</button>
                                                                    <button id="saveButtonfeedback" class="btn btn-success float-end {{ $hasAnswerData ? 'd-none' : '' }}" onclick="saveDraftfeedback({{ $pms_id->EmpPmsId }})">Save as Draft</button>
                                                                @endif
                                                            @endisset
                                                        </div>
                                                        <div class="card-body table-responsive dd-flex align-items-center">

                                                        @foreach($feedback_que as $index => $feedback)
                                                                    @php
                                                                        $envKey = trim($feedback->Environment); // Ensure key is trimmed
                                                                        $answer = $feedbackAnswers[$envKey] ?? ''; // Get answer if exists
                                                                    @endphp
                                                                    <div class="w-100 mb-3">
                                                                        <b>{{ $index + 1 }}. {{ $envKey }}</b><br>
                                                                        <textarea class="form-control" 
                                                                            id="feedback-{{ $feedback->WorkEnvId }}" 
                                                                            name="answers[{{ $feedback->WorkEnvId }}]" 
                                                                            data-question="{{ $envKey }}" 
                                                                            placeholder="Enter your feedback" 
                                                                            style="width:100%;" 
                                                                            type="text"
                                                                            {{ $hasAnswerData ? 'readonly' : '' }}>{{ trim($answer) }}</textarea>
                                                                    </div>
                                                                @endforeach

                                                                </div>

                                                    </div>
                                                </div>

                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade {{ request('active_subtab') == 'upload' ? 'show active' : '' }}"  id="upload" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Upload Files</b>
                                                        </div>
                                                        <form id="uploadForm">
                                                            @csrf
                                                            <input type="hidden" name="pmsid" class="form-control" value="{{$pms_id->EmpPmsId }}">
                                                            <input type="hidden" name="pmsyrid" class="form-control" value="{{$PmsYId }}">

                                                        <div class="card-body table-responsive dd-flex align-items-center">
                                                            <div class="form-group mr-2" id="">
                                                                <label class="col-form-label">Name of File</label>
                                                                <input type="text" name="uploadfilename" required class="form-control" id="uploadfilename" placeholder="Remark In">
                                                            </div>
                                                            <div class="form-group" id="">
                                                                <label class="col-form-label">Upload Files</label>
                                                                <input type="file" name="uploadfile" required class="form-control">
                                                            </div>
                                                            <button type="submit" class="effect-btn btn btn-success squer-btn sm-btn mt-3">Upload</button>
                                                            <br>
                                                            <table class="table table-pad">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SN.</th>
                                                                        <th>File Name</th>
                                                                        <th>File</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="fileTableBody">
                                                                    <!-- Files will be loaded here dynamically -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ad-footer-btm">
                            <p><a href="">Terms of use</a> | <a href="">Privacy Policy</a> 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
                        </div>
                    </div>

                    @include('employee.footerbottom')
                </div>
            </div>
        </div>
        <!--View KRA Modal-->
        <!--<div class="modal fade show" id="viewKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID:
                                1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive p-0">
                        <div class="card" id="viewkrabox">
                            <div class="card-header">
                                <div style="float:left;width:100%;">
                                    <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                                </div>
                            </div>
                            <div class="card-body table-responsive dd-flex align-items-center">
                                <table class="table table-pad">
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
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>1.</b></td>
                                            <td>test </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>2.</b></td>
                                            <td>test </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>3.</b></td>
                                            <td>test </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>4.</b></td>
                                            <td>test </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
                                            <td>test </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td><a class="effect-btn btn btn-success squer-btn sm-btn">Approval</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card" id="editkrabox" style="display:none;">
                            <div class="card-header">
                                <div style="float:left;width:100%;">
                                    <h5 class="float-start"><b>Form - A (KRA)</b></h5>
                                </div>
                            </div>
                            <div class="card-body table-responsive dd-flex align-items-center">
                                <table class="table table-pad">
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
                                            <td><input style="min-width: 300px;" type="text"></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
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
                                                <select>
                                                    <option>45.5</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
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
                                                <input style="width:50px;font-weight: bold;" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>2.</b></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
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
                                                <select>
                                                    <option>45.5</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
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
                                                <input style="width:50px;font-weight: bold;" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>3.</b></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
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
                                                <select>
                                                    <option>45.5</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
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
                                                <input style="width:50px;font-weight: bold;" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>4.</b></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
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
                                                <select>
                                                    <option>45.5</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
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
                                                <input style="width:50px;font-weight: bold;" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>5.</b></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
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
                                                <select>
                                                    <option>45.5</option>
                                                    <option>1</option>
                                                    <option>1</option>
                                                </select>
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
                                                <input style="width:50px;font-weight: bold;" type="text">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a class="effect-btn btn btn-success squer-btn sm-btn">Approval</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card" id="revertbox" style="display:none;">
                            <div class="card-header">
                                <div style="float:left;width:100%;">
                                    <h5 class="float-start"><b>Revert</b></h5>
                                </div>
                            </div>
                            <div class="card-body table-responsive align-items-center">
                                <div class="form-group mr-2">
                                    <label class="col-form-label">Revert Note</label>
                                    <textarea placeholder="Enter your revert note" class="form-control"></textarea>
                                    <a class="effect-btn btn btn-success squer-btn sm-btn mt-2">Send</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="viewkrabtn">View<i class="fas fa-eye ml-2 mr-2"></i></a>
                        <a class="editkrabtn">Edit<i class="fas fa-edit ml-2 mr-2"></i></a>
                        <a class="revertkrabtn">Revert<i class="fas fa-retweet ml-2 mr-2"></i></a>
                        <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>-->
        <!--view upload Modal-->
        <!--<div class="modal fade show" id="viewuploadedfiles" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID:
                                1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body table-responsive p-0">
                        <div class="card">
                            <div class="card-header">
                                <div style="float:left;width:100%;">
                                    <h5 class="float-start"><b>Upload Files</b></h5>
                                </div>
                            </div>
                            <div class="card-body table-responsive dd-flex align-items-center">
                                <table class="table table-pad">
                                    <thead>
                                        <tr>
                                            <th>SN.</th>
                                            <th>File Name</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>1.</b></td>
                                            <td>image 1</td>
                                            <td><a title="View" data-bs-toggle="modal"
                                                    data-bs-target="#viewuploadfile"><i
                                                        class="fas fa-eye mr-2"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->

        <!--view history Modal-->

        <!--<div class="modal fade show" id="viewHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title me-2" id="exampleModalCenterTitle3" style="font-size:13px;">
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
                                            <td>Nuziveedu seeds limited </td>
                                            <td>Senior Officer</td>
                                            <td>02-01-2018</td>
                                            <td>28-02-2019</td>
                                            <td>1.1 year</td>
                                        </tr>
                                        <tr>
                                            <td><b>2.</b></td>
                                            <td>Nuziveedu seeds limited </td>
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

                                <h5 class="mb-2">B. Training Programs</h5>
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


        <!--All achivement and feedback view -->
        <!--<div class="modal fade show" id="viewappraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID:
                                1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
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
                                            <button class="btn btn-link float-end" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseOnej"
                                                aria-expanded="true" aria-controls="collapseOnej">
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOnej" class="collapse show card-body"
                                        aria-labelledby="headingOnej" data-bs-parent="#accordionExample">
                                        <ol>
                                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                veniam</li>
                                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                veniam</li>
                                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                veniam</li>
                                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                veniam</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="item-header card-header" id="headingTwok">
                                        <h5 class="mb-0">
                                            Feedback
                                            <button class="btn btn-link collapsed float-end" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwok"
                                                aria-expanded="false" aria-controls="collapseTwok">
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseTwok" class="collapse show card-body"
                                        aria-labelledby="headingTwok" data-bs-parent="#accordionExample">
                                        <ul>
                                            <li>1. What is your feedback regarding the existing & new processes that are
                                                being followed or needs to be followed in your respective functions?
                                            </li>
                                            <li><b>Ans.</b> test 123456</li>
                                            <li>&nbsp;</li>
                                            <li>2. At work, are there any factors that hinder your growth?</li>
                                            <li><b>Ans.</b> test 123456</li>
                                            <li>&nbsp;</li>
                                            <li>3. At work, what are the factors that facilitate your growth?</li>
                                            <li><b>Ans.</b> test 123456</li>
                                            <li>&nbsp;</li>
                                            <li>4. What support you need from the superiors to facilitate your
                                                performance?</li>
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
                            <div class="card-body table-responsive dd-flex align-items-center">
                                <table class="table table-pad" id="mykrabox">
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
                                            <th>Emp Rating</th>
                                            <th>Emp Remarks</th>
                                            <th>Appraisar Rating</th>
                                            <th>Appraiser Score</th>
                                            <th>Appraiser Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>1.</b></td>
                                            <td> There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered.</td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td>67</td>
                                            <td>20.1</td>
                                            <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                        </tr>
                                        <tr>
                                            <td><b>2.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td>67</td>
                                            <td>20.1</td>
                                            <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                        </tr>
                                        <tr>
                                            <td><b>3.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td>67</td>
                                            <td>20.1</td>
                                            <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                        </tr>
                                        <tr>
                                            <td><b>4.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td>67</td>
                                            <td>20.1</td>
                                            <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td>100</td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td>67</td>
                                            <td>20.1</td>
                                            <td>Junagadh & Rajkot Tgt 429Lakh ach 290lakh</td>
                                        </tr>
                                        <tr>
                                            <td colspan="15">
                                                <table class="table" Style="background-color:#ECECEC;">
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
                                                            <th>Emp Rating</th>
                                                            <th>Emp Remarks</th>
                                                            <th>Appraiser Rating</th>
                                                            <th>Appraiser Score</th>
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
                                                            <td>45.5</td>
                                                            <td>Logic 01</td>
                                                            <td>Quarterly</td>
                                                            <td>100</td>
                                                            <td>85</td>
                                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement
                                                                317.16 Lakh, Rajkot - 129.15 achievement against on
                                                                target 216.36 Lakh</td>
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
                                                            <td>45.5</td>
                                                            <td>Logic 01</td>
                                                            <td>Quarterly</td>
                                                            <td>100</td>
                                                            <td>85</td>
                                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement
                                                                317.16 Lakh, Rajkot - 129.15 achievement against on
                                                                target 216.36 Lakh</td>
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
                                            <td>To develop effective Leadership skills.. Self motivated and capable to
                                                inspire others and take charge, developing empathy, communication, etc.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>1</b></td>
                                            <td><b>Business Skills</b></td>
                                            <td>Leadership Skills</td>
                                            <td>To develop effective Leadership skills.. Self motivated and capable to
                                                inspire others and take charge, developing empathy, communication, etc.
                                            </td>
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
                                            <td>Managing the company's finances. Budgeting will help project
                                                expenditures for given periodicity.</td>
                                        </tr>
                                        <tr>
                                            <td><b>1</b></td>
                                            <td><b>Customer handling</b></td>
                                            <td> Dealing with different kinds of customers, developing persuasive
                                                skills, handling complaints, developing listening skills & empathy,
                                                taking control and solving problems, mantaining customer relations etc.
                                            </td>
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
                        <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- All achivement and feedback edit -->
        <!--<div class="modal fade show" id="editAppraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp. ID:
                                1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5>
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
                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
                                    <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</li>
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
                                    <li>1. What is your feedback regarding the existing & new processes that are being
                                        followed or needs to be followed in your respective functions?</li>
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
                                            <th>KRA/Goals</th>
                                            <th>Description</th>
                                            <th>Measure</th>
                                            <th>Unit</th>
                                            <th>Weightage</th>
                                            <th>Logic</th>
                                            <th>Period</th>
                                            <th>Target</th>
                                            <th>self Rating</th>
                                            <th>self Remarks</th>
                                            <th>App Rating</th>
                                            <th>App Score</th>
                                            <th>App Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>1.</b></td>
                                            <td> There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered.</td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>2.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>3.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>4.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="fas fa-plus-circle mr-2"></i><b>5.</b></td>
                                            <td>There are many variations of passages of Lorem Ipsum available, but the
                                                majority have suffered. </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="15">
                                                <table class="table" Style="background-color:#ECECEC;">
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
                                                            <th>self Rating</th>
                                                            <th>self Remarks</th>
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
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td><b>2.</b></td>
                                            <td>test </td>
                                            <td>twst</td>
                                            <td>Process</td>
                                            <td>Days</td>
                                            <td>45.5</td>
                                            <td>Logic 01</td>
                                            <td>Quarterly</td>
                                            <td> <a style="color:blue;" class="link" title="Click to target"
                                                    data-bs-toggle="modal" data-bs-target="#targetbox">100 Click</a>
                                            </td>
                                            <td>85</td>
                                            <td>Target Rajkot+Junagadh Target 479.8 Lakh achievement 317.16 Lakh, Rajkot
                                                - 129.15 achievement against on target 216.36 Lakh</td>
                                            <td><input class="form-control" type="text" value="67"></td>
                                            <td>20.1</td>
                                            <td>
                                                <textarea style="width:150px;" class="form-control">Junagadh & Rajkot Tgt 429Lakh ach 290lakh</textarea>
                                            </td>
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
                                            <td><select>
                                                    <option>J4</option>
                                                    <option>J5</option>
                                                    <option>J6</option>
                                                </select></td>
                                            <td><select>
                                                    <option>Business manager</option>
                                                    <option>Zonal Manager</option>
                                                    <option>1</option>
                                                </select></td>
                                            <td><input style="min-width: 300px;" type="text"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>

                        <div class="card">
                            <div class="card-header">
                                <div style="float:left;width:100%;">
                                    <h5 class="float-start"><b>Training Requirements </b></h5><br>
                                    <b>A) Soft Skills Training [Based on Behavioral parameter]</b>
                                </div>
                            </div>
                            <div class="card-body table-responsive dd-flex align-items-center">

                                <div class=" mr-2" id="">
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
                                <a class="effect-btn btn btn-success squer-btn sm-btn mt-4 ml-2">Submit</a><br>
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
                                            <td>To develop effective Leadership skills.. Self motivated and capable to
                                                inspire others and take charge, developing empathy, communication, etc.
                                            </td>
                                            <td><i class="fas fa-trash ml-2 mr-2"></i></td>
                                        </tr>
                                        <tr>
                                            <td><b>1</b></td>
                                            <td><b>Business Skills</b></td>
                                            <td>Leadership Skills</td>
                                            <td>To develop effective Leadership skills.. Self motivated and capable to
                                                inspire others and take charge, developing empathy, communication, etc.
                                            </td>
                                            <td><i class="fas fa-trash ml-2 mr-2"></i></td>
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

                                <div class=" mr-2" id="">
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
                                <a class="effect-btn btn btn-success squer-btn sm-btn mt-4 ml-2">Submit</a><br>
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
                                            <td>To develop effective Leadership skills.. Self motivated and capable to
                                                inspire others and take charge, developing empathy, communication, etc.
                                            </td>
                                            <td><i class="fas fa-trash ml-2 mr-2"></i></td>
                                        </tr>
                                        <tr>
                                            <td><b>1</b></td>
                                            <td><b>Business Skills</b></td>
                                            <td>Leadership Skills</td>
                                            <td>To develop effective Leadership skills.. Self motivated and capable to
                                                inspire others and take charge, developing empathy, communication, etc.
                                            </td>
                                            <td><i class="fas fa-trash ml-2 mr-2"></i></td>
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
                        <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
                    </div>
                </div>
            </div>
        </div>-->

        <!-- resubmit -->
        <div class="modal fade show" id="resend" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3">Resend Note</h5>
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
                            <thead>
                                <tr style="text-align: center;">
                                    <th rowspan="2">SN.</th>
                                    <th rowspan="2">Quarter</th>
                                    <th rowspan="2">Weightage</th>
                                    <th rowspan="2">Target</th>
                                    <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                    <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                    <th rowspan="2">Action</th>
                                    <th rowspan="2">Status</th>
                                </tr>
                                <tr style="text-align: center;">
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>1.</b></td>
                                    <td>Quarter 1</td>
                                    <td>1.25</td>
                                    <td>100</td>
                                    <td>Backup</td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="width: 60px;" type="text" placeholder="Enter rating">
                                    </td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="min-width: 200px;" type="text" placeholder="Enter your remark">
                                    </td>
                                    <td>
                                        97
                                    </td>
                                    <td>
                                        <a title="Save" href=""><i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i></a>
                                        <a style="padding: 2px 7px;font-size: 11px;" class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i></a>
                                        <!--<button type="button" class="btn btn-success btn-label rounded-pill" style="padding: 3px 7px;font-size: 11px;"><i class="ri-check-line label-icon align-middle rounded-pill fs-16 me-1"></i> Submit</button>-->
                                    </td>
                                    <td>
                                        <i class="fas fa-check-circle mr-2 text-success"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b>2.</b></td>
                                    <td>Quarter 2</td>
                                    <td>1.25</td>
                                    <td>100</td>
                                    <td>Backup</td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="width: 60px;" type="text" placeholder="Enter rating">
                                    </td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="min-width: 200px;" type="text" placeholder="Enter your remark">
                                    </td>
                                    <td>
                                        97
                                    </td>
                                    <td><a title="Edit" href=""><i class="fas fa-edit text-info mr-2"></i></a></td>
                                    <td>
                                        <i class="ri-check-double-line mr-2 text-success"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b>3.</b></td>
                                    <td>Quarter 3</td>
                                    <td>1.25</td>
                                    <td>100</td>
                                    <td>Backup</td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="width: 60px;" type="text" placeholder="Enter rating">
                                    </td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="min-width: 200px;" type="text" placeholder="Enter your remark">
                                    </td>
                                    <td>
                                        97
                                    </td>
                                    <td><a title="Lock" href=""><i style="font-size:14px;" class="ri-lock-2-line text-danger mr-2"></i></a></td>
                                    <td>
                                        <i class="fas fa-check-circle mr-2 text-success"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b>4.</b></td>
                                    <td>Quarter 4</td>
                                    <td>1.25</td>
                                    <td>100</td>
                                    <td>Backup</td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="width: 60px;" type="text" placeholder="Enter rating">
                                    </td>
                                    <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="min-width: 200px;" type="text" placeholder="Enter your remark">
                                    </td>
                                    <td>
                                        97
                                    </td>
                                    <td><a title="Save" href=""><i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i></a>
                                        <a style="padding: 2px 7px;font-size: 11px;" class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i></a>
                                    </td>
                                    <td>
                                        <i class="fas fa-check-circle mr-2 text-success"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>Total</b></td>
                                    <td>5</td>
                                    <td colspan="7"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="float-end">
                            <i class="fas fa-check-circle mr-2 text-success"></i>Final Submit, <i class="ri-check-double-line mr-1 text-success"></i> Save as Draft
                        </div>
                        <p><b>Note:</b><br> 1. Please ensure that the achievement is calculated against the "<blink><b>Target Value</b></blink>"
                            only.<br>
                            2. The achievement is required to be entered on the last day or within few days beyard which
                            the KRA will set auto locked.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="effect-btn btn btn-light squer-btn sm-btn "
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- target box popup  -->
        <div class="modal fade show" id="targetbox" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3"><b>Kishan Kumar</b><br><small> Emp.
                                ID: 1254, &nbsp;&nbsp;&nbsp;Designation: Ex. Software Developer</small></h5><br>
                        <p><b>Logic</b>: Logic 1 <b>KRA</b>: </p><br>
                        <p><b>Description</b>: There are many variations of passages of Lorem Ipsum available, but the
                            majority have suffered.</p>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body appraisal-view">
                        <table class="table table-pad" id="mykrabox">
                            <thead>
                                <tr>
                                    <th>SN.</th>
                                    <th>Quarter</th>
                                    <th>Weightage</th>
                                    <th>Target</th>
                                    <th>Comments</th>
                                    <th>Self rating</th>
                                    <th>Rating details</th>
                                    <th>Score</th>
                                    <th>Reporting rating</th>
                                    <th>Reporting remarks</th>
                                    <th>Reporting score</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>1.</b></td>
                                    <td>Quarter 1</td>
                                    <td>7.5</td>
                                    <td>25</td>
                                    <td> There are many variations of passages of Lorem Ipsum available, but the
                                        majority have suffered.</td>

                                    <td>21</td>
                                    <td>test</td>
                                    <td>6.30</td>
                                    <td><input class="form-control" type="text" value="20"></td>
                                    <td><input class="form-control" style="min-width: 300px;" type="text"
                                            value="test for reporting"></td>
                                    <td><input class="form-control" type="text" value="6"></td>
                                    <td> <a class="btn btn-success">Save</a></td>
                                </tr>
                                <tr>
                                    <td><b>1.</b></td>
                                    <td>Quarter 1</td>
                                    <td>7.5</td>
                                    <td>25</td>
                                    <td> There are many variations of passages of Lorem Ipsum available, but the
                                        majority have suffered.</td>

                                    <td>21</td>
                                    <td>test</td>
                                    <td>6.30</td>
                                    <td><input class="form-control" type="text" value="20"></td>
                                    <td><input class="form-control" style="min-width: 300px;" type="text"
                                            value="test for reporting"></td>
                                    <td><input class="form-control" type="text" value="6"></td>
                                    <td><a class="btn btn-success">Save</a></td>
                                </tr>
                                <tr>
                                    <td><b>1.</b></td>
                                    <td>Quarter 1</td>
                                    <td>7.5</td>
                                    <td>25</td>
                                    <td> There are many variations of passages of Lorem Ipsum available, but the
                                        majority have suffered.</td>

                                    <td>21</td>
                                    <td>test</td>
                                    <td>6.30</td>
                                    <td><input class="form-control" type="text" value="20"></td>
                                    <td><input class="form-control" style="min-width: 300px;" type="text"
                                            value="test for reporting"></td>
                                    <td><input class="form-control" type="text" value="6"></td>
                                    <td><a class="btn btn-success">Save</a></td>
                                </tr>
                                <tr>
                                    <td><b>1.</b></td>
                                    <td>Quarter 1</td>
                                    <td>7.5</td>
                                    <td>25</td>
                                    <td> There are many variations of passages of Lorem Ipsum available, but the
                                        majority have suffered.</td>

                                    <td>21</td>
                                    <td>test</td>
                                    <td>6.30</td>
                                    <td><input class="form-control" type="text" value="20"></td>
                                    <td><input class="form-control" style="min-width: 300px;" type="text"
                                            value="test for reporting"></td>
                                    <td><input class="form-control" type="text" value="6"></td>
                                    <td><a class="btn btn-success">Save</a></td>
                                </tr>
                                <tr style="background-color:#f1f1f1;">
                                    <td></td>
                                    <td><b>Total</b></td>
                                    <td><b>30</b></td>
                                    <td><b>100</b></td>
                                    <td></td>
                                    <td><b>95.5</b></td>
                                    <td></td>
                                    <td><b>28.5</b></td>
                                    <td><b>90</b></td>
                                    <td></td>
                                    <td><b>27</b></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <a class="effect-btn btn btn-success squer-btn sm-btn">Submit</a>
                        <a class="effect-btn btn btn-success squer-btn sm-btn">Save</a>
                        <a class="effect-btn btn btn-secondary squer-btn sm-btn" data-bs-dismiss="modal">Close</a>
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
											<td>Logic 8c</td><td>100</td><td>=, < 100</td><td>90</td>
										</tr>
										<tr>
											<td>Logic 8d</td><td>100</td><td>=, < 100</td><td>65</td>
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
						<source src="./public/video/ess-emp-appraisal-help.mp4" type="video/mp4">
					</video>
				</div>
			</div>
		</div>
	</div>
        @include('employee.footer')
        <script>

            $(document).ready(function() {
                $('#saveDraftBtnCurr').click(function() {
                    let form = $("#kraFormcurrent")['0']; // Get the form element
                    let isValid = true;
                    let firstInvalidField = null; // Variable to store the first invalid field

                    // Clear any previous error messages
                    $('.error-message').remove();

                    $(form).find('input[required], textarea[required], select[required]').each(function() {
                            let inputVal = $(this).val();
                            
                            // Check if the field is a number and contains a non-positive value (<= 0)
                            if ($(this).attr('type') === 'number') {
                                let numValue = parseFloat(inputVal);

                                // Check for negative or zero values
                                if (numValue <= 0 || numValue > 999999) {
                                    isValid = false;
                                    if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field

                                    // Add red border for invalid fields
                                    $(this).css({
                                        'border': '2px solid red',
                                        'height': '35px'
                                    });

                                    // Create and display error message below the input field
                                    $(this).after('<div class="error-message" style="color: red; font-size: 10px;">Please enter a valid number</div>');
                                }
                            }
                            // Check if the field is required and empty
                            else if (!inputVal) {
                                isValid = false;
                                if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field

                                // Add red border for invalid fields
                                $(this).css({
                                    'border': '2px solid red',
                                    'height': '35px'
                                });

                                // Create and display error message below the input field
                                $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                            } else {
                                // Remove the red border and error message if field is valid
                                $(this).css('border', '');
                                $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                            }
                        });

                        // If form is invalid, scroll to the first invalid field and prevent submission
                        if (!isValid) {
                            $('#loader').hide();  // Hide the loader since validation failed
                            if (firstInvalidField) {
                                // Scroll to the first invalid field
                                $('html, body').animate({
                                    scrollTop: firstInvalidField.offset().top - 100 // Adjust the offset as needed
                                }, 500); // Smooth scroll duration
                            }
                            return;  // Prevent AJAX submission if validation fails
                        }
                    
                        $('#loader').show();

                    let formData = new FormData(form); // Collect form data

                    $.ajax({
                        url: "{{ route('kra.save') }}", // Replace with the correct route
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF token for Laravel
                        },
                        success: function(response) {
                            $('#loader').hide();
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right",
                                "timeOut": 10000
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr) {
                            $('#loader').hide();

                            // ✅ Ensure error message is shown properly
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
                
                $('#finalSubmitLi').click(function() {
                    let form = $("#kraFormcurrent")['0']; // Get the form element
                    let isValid = true;
                    let firstInvalidField = null; // Variable to store the first invalid field


                    // Clear any previous error messages
                    $('.error-message').remove();

                    $(form).find('input[required], textarea[required], select[required]').each(function() {
                            let inputVal = $(this).val();
                            
                            // Check if the field is a number and contains a non-positive value (<= 0)
                            if ($(this).attr('type') === 'number') {
                                let numValue = parseFloat(inputVal);

                                // Check for negative or zero values
                                if (numValue <= 0 || numValue > 999999) {
                                    isValid = false;
                                    if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field

                                    // Add red border for invalid fields
                                    $(this).css({
                                        'border': '2px solid red',
                                        'height': '35px'
                                    });

                                    // Create and display error message below the input field
                                    $(this).after('<div class="error-message" style="color: red; font-size: 10px;">Please enter a valid number</div>');
                                }
                            }
                            // Check if the field is required and empty
                            else if (!inputVal) {
                                isValid = false;
                                if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field

                                // Add red border for invalid fields
                                $(this).css({
                                    'border': '2px solid red',
                                    'height': '35px'
                                });

                                // Create and display error message below the input field
                                $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                            } else {
                                // Remove the red border and error message if field is valid
                                $(this).css('border', '');
                                $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                            }
                        });

                    // If form is invalid, scroll to the first invalid field and prevent submission
                    if (!isValid) {
                            $('#loader').hide();  // Hide the loader since validation failed
                            if (firstInvalidField) {
                                // Scroll to the first invalid field
                                $('html, body').animate({
                                    scrollTop: firstInvalidField.offset().top - 100 // Adjust the offset as needed
                                }, 500); // Smooth scroll duration
                            }
                            return;  // Prevent AJAX submission if validation fails
                    }
                    

                    $('#loader').show();

                    let formData = new FormData(form); // Collect form data
                    formData.append('submit_type', 'final_submit');  // Add your custom identifier here

                    $.ajax({
                        url: "{{ route('kra.save') }}", // Replace with the correct route
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF token for Laravel
                        },
                        success: function(response) {
                            $('#loader').hide();
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right",
                                "timeOut": 10000
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr) {
                            $('#loader').hide();

                            // ✅ Ensure error message is shown properly
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
                
                $('#saveDraftBtnNew').click(function() {
                    let form = $("#kraFormcurrentNew")['0']; // Get the form element
                    let isValid = true;
                    let firstInvalidField = null; // Variable to store the first invalid field

                        // Clear any previous error messages
                        // $('.error-message').remove();

                        /*$(form).find('input[required], textarea[required], select[required]').each(function() {
                        let inputVal = $(this).val();
                        
                        // Check if the field is a number and contains a negative value
                        /*if ($(this).attr('type') === 'number' && parseFloat(inputVal) <=0) {
                            isValid = false;
                            if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field
                            
                            // Add red border for invalid fields
                            $(this).css({
                                'border': '2px solid red',
                                'height': '35px'
                            });

                            // Create and display error message below the input field
                            $(this).after('<div class="error-message" style="color: red; font-size: 10px;">Please enter a valid number.</div>');
                        }*/
                        // Check if the field is required and empty
                        /*else if (!inputVal) {
                            isValid = false;
                            if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field
                            
                            // Add red border for invalid fields
                            $(this).css({
                                'border': '2px solid red',
                                'height': '35px'
                            });

                            // Create and display error message below the input field
                            $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                        } else {
                            // Remove the red border and error message if field is valid
                            $(this).css('border', '');
                            $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                        }*/
                    // });
                    
                        /*if (!isValid) {
                                $('#loader').hide();  // Hide the loader since validation failed
                                if (firstInvalidField) {
                                        // Scroll to the first invalid field
                                        $('html, body').animate({
                                            scrollTop: firstInvalidField.offset().top - 100 // Adjust the offset as needed
                                        }, 500); // Smooth scroll duration
                                    }
                                return;  // Prevent AJAX submission if validation fails
                        }*/

                        $('#loader').show();

                    let formData = new FormData(form); // Collect form data
                    console.log(formData);
                    $.ajax({
                        url: "{{ route('kra.save') }}", // Replace with the correct route
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF token for Laravel
                        },
                        success: function(response) {
                            $('#loader').hide();
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right",
                                "timeOut": 10000
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr) {
                            $('#loader').hide();

                            // ✅ Ensure error message is shown properly
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
                
                $('#finalSubmitLiNew').click(function() {
                    let form = $("#kraFormcurrentNew")['0']; // Get the form element
                    let isValid = true;
                    let firstInvalidField = null; // Variable to store the first invalid field

                        // Clear any previous error messages
                        $('.error-message').remove();

                        $(form).find('input[required], textarea[required], select[required]').each(function() {
                            let inputVal = $(this).val();
                            
                            // Check if the field is a number and contains a non-positive value (<= 0)
                            if ($(this).attr('type') === 'number') {
                                let numValue = parseFloat(inputVal);

                                // Check for negative or zero values
                                if (numValue <= 0 || numValue > 999999 || numValue === ''|| numValue == '') {
                                    isValid = false;
                                    if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field

                                    // Add red border for invalid fields
                                    $(this).css({
                                        'border': '2px solid red',
                                        'height': '35px'
                                    });

                                    // Create and display error message below the input field
                                    $(this).after('<div class="error-message" style="color: red; font-size: 10px;">Please enter a valid number</div>');
                                }
                            }
                            // Check if the field is required and empty
                            else if (!inputVal) {
                                isValid = false;
                                if (!firstInvalidField) firstInvalidField = $(this); // Save the first invalid field

                                // Add red border for invalid fields
                                $(this).css({
                                    'border': '2px solid red',
                                    'height': '35px'
                                });

                                // Create and display error message below the input field
                                $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                            } else {
                                // Remove the red border and error message if field is valid
                                $(this).css('border', '');
                                $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                            }
                        });

                        // If form is invalid, scroll to the first invalid field and prevent submission
                        if (!isValid) {
                                $('#loader').hide();  // Hide the loader since validation failed
                                if (firstInvalidField) {
                                    // Scroll to the first invalid field
                                    $('html, body').animate({
                                        scrollTop: firstInvalidField.offset().top - 100 // Adjust the offset as needed
                                    }, 500); // Smooth scroll duration
                                }
                                return;  // Prevent AJAX submission if validation fails
                        }
                        
                    $('#loader').show();

                    let formData = new FormData(form); // Collect form data
                    formData.append('submit_type', 'final_submit');  // Add your custom identifier here

                    $.ajax({
                        url: "{{ route('kra.save') }}", // Replace with the correct route
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // CSRF token for Laravel
                        },
                        success: function(response) {
                            $('#loader').hide();
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right",
                                "timeOut": 10000
                            });

                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        },
                        error: function(xhr) {
                            $('#loader').hide();

                            // ✅ Ensure error message is shown properly
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
                
                $("#addKraBtn").click(function() {
                    addKRA(); // Call function to add new KRA fields dynamically
                });
                $("#addKraBtnNew").click(function() {
                    console.log('dddd');
                    addKRANew(); // Call function to add new KRA fields dynamically
                });


            });

            function addKRA() {

            // Get the table body element where rows are added
            var kraTable = document.getElementById('current_kra');

            // Get the body where the rows are dynamically added
            var kraTablebody = document.getElementById('mainKraBody');

            // Count existing rows that have an id starting with kraRow_
            var rowCount = $('#mainKraBody tr[id^="kraRow_"]').length + 1; // Count rows and get the next serial number

            // Create a new <tr> element for the new row
            var newRow = document.createElement('tr');

            // Set the id for the new row as kraRow_<rowCount>
            var newRowId = 'kraRow_' + rowCount;
            newRow.setAttribute('id', newRowId);

            // Add the structure for the new row (with input fields and dropdowns)
            newRow.innerHTML = `
                <td><b>${rowCount}</b></td> <!-- Serial Number -->
                <td><textarea type="text" required class="form-control" name="kra[]"  placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea></td>
                <td><textarea type="text" required class="form-control" name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600" placeholder="Enter KRA Description" ></textarea></td>
                <td>
                    <select name="Measure[]" class="Inputa"  required>

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
                    <select id="Unit[]" name="Unit[]" class="Inputa" style="width:75px;" required>
                        
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
                <td><input type="number" class="Inputa" name="weightage[]"  required placeholder="Enter weightage" style="width: 69px;" ></td>
                <td>
                    <select  name="Logic[]" style="width:75px;" required>
                        
                        @foreach($logicData as $logic)
                            <option value="{{ $logic->logicMn }}">
                                {{ $logic->logicMn }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select id="Period[]" name="Period[]" style="width:90px;" required >
                        
                        <option value="Annual">Annually</option>
                        <option value="1/2 Annual">Half Yearly</option>
                        <option value="Quarter">Quarterly</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                </td>
                <td><input type="number" class="Inputa" name="Target[]" value="100" placeholder="Enter target" required style="width:60px;"></td>
                <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtn"></button></td>
            `;

            // Append the new row to the table
            $('#mainKraBody').append(newRow);
            }

         
            function addKRANew() {

            // Get the table body element where rows are added
            var kraTable = document.getElementById('current_kraNew');

            // Get the body where the rows are dynamically added
            var kraTablebody = document.getElementById('mainKraBodyNew');

            // Count existing rows that have an id starting with kraRow_
            var rowCount = $('#mainKraBodyNew tr[id^="kraRow_New"]').length + 1; // Count rows and get the next serial number

            // Create a new <tr> element for the new row
            var newRow = document.createElement('tr');

            // Set the id for the new row as kraRow_New<rowCount>
            var newRowId = 'kraRow_New' + rowCount;
            newRow.setAttribute('id', newRowId);

            // Add the structure for the new row (with input fields and dropdowns)
            newRow.innerHTML = `
                <td><b>${rowCount}</b></td> <!-- Serial Number -->
                <td><textarea type="text" required class="form-control" name="kra[]"  placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea></td>
                <td><textarea type="text" required class="form-control" name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600" placeholder="Enter KRA Description" ></textarea></td>
                <td>
                    <select name="Measure[]" class="Inputa"  required>
                        
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
                    <select id="Unit[]" name="Unit[]" class="Inputa" style="width:75px;" required>
                        
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
                <td><input type="number" class="Inputa" name="weightage[]"  required placeholder="Enter weightage" style="width: 69px;" ></td>
                <td>
                    <select  name="Logic[]" style="width:75px;" required>
                        
                        @foreach($logicData as $logic)
                            <option value="{{ $logic->logicMn }}">
                                {{ $logic->logicMn }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select id="Period[]" name="Period[]" style="width:90px;" required >
                        
                        <option value="Annual">Annually</option>
                        <option value="1/2 Annual">Half Yearly</option>
                        <option value="Quarter">Quarterly</option>
                        <option value="Monthly">Monthly</option>
                    </select>
                </td>
                <td><input type="number" class="Inputa" name="Target[]" value="100" placeholder="Enter target" required style="width:60px;"></td>
                <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtnNew"></button></td>
            `;

            // Append the new row to the table
            $('#mainKraBodyNew').append(newRow);
            }


            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("addSubKraBtn")) {
                    let kraId = event.target.getAttribute("data-kra-id");
                    addSubKRA(kraId);
                }
                if (event.target.classList.contains("addSubKraBtnNew")) {
                    let kraId = event.target.getAttribute("data-kra-id-new");
                    addSubKRANew(kraId);
                }
            
            });


            $(document).on("click", ".removeKraBtn", function() {
                var row = $(this).closest("tr"); // Get the parent row of the remove button
                        row.remove(); // Remove the current row

                        // Count the number of remaining rows with id starting with kraRow_
                        $("#mainKraBody tr[id^='kraRow_']").each(function(index) {
                            // Update the serial number (Sno) in the first column
                            $(this).find("td:first b").text(index + 1); // The serial number starts from 1
                        });
            });
            $(document).on("click", ".removeKraBtnNew", function() {
                var row = $(this).closest("tr"); // Get the parent row of the remove button
                        row.remove(); // Remove the current row

                        // Count the number of remaining rows with id starting with kraRow_
                        $("#mainKraBodyNew tr[id^='kraRow_New']").each(function(index) {
                            // Update the serial number (Sno) in the first column
                            $(this).find("td:first b").text(index + 1); // The serial number starts from 1
                        });
            });
            

            function showKraDetails(id, period, target, weightage, logic, year_id) {
                let elementId = event.target.id;
                let isSubKra = elementId.startsWith("Tar_a"); // Detect if it's a Sub-KRA

                let requestData = {
                    kraId: isSubKra ? null : id,
                    subKraId: isSubKra ? id : null,
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
                                    <th rowspan="2">SN.</th>
                                    <th rowspan="2">Period</th>
                                    <th rowspan="2">Weightage</th>
                                    <th rowspan="2">Target</th>
                                    <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                    <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                    <th rowspan="2">Action</th>
                                    <th rowspan="2">Status</th>
                                </tr>
                                <tr>
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="kraRows">
                                ${generateKraRows(kraData, subKraData,subKraDatamain,logic)}
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
                                    <th rowspan="2"></th>
                                    <th rowspan="2">SN.</th>
                                    <th rowspan="2">Period</th>
                                    <th rowspan="2">Weightage</th>
                                    <th rowspan="2">Target</th>
                                    <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                    <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                    <th rowspan="2">Action</th>
                                    <th rowspan="2">Status</th>
                                </tr>
                                <tr style="text-align:center;">
                                    
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody id="kraRows">
                                ${generateKraRows(kraData, null, subKraDatamain, logic)}
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
                                    <th rowspan="2"></th>
                                    <th rowspan="2">SN.</th>
                                    <th rowspan="2">Period</th>
                                    <th rowspan="2">Weightage</th>
                                    <th rowspan="2">Target</th>
                                    <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                    <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                    <th rowspan="2">Action</th>
                                    <th rowspan="2">Status</th>
                                </tr>
                                <tr>
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
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
                                    <th rowspan="2"></th>
                                    <th rowspan="2">SN.</th>
                                    <th rowspan="2">Period</th>
                                    <th rowspan="2">Weightage</th>
                                    <th rowspan="2">Target</th>
                                    <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                    <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                    <th rowspan="2">Action</th>
                                    <th rowspan="2">Status</th>
                                </tr>
                                <tr style="text-align:center;">
                                    
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
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
                console.log('fffff');
                let rows = '';
                let totalWeight = 0;
                    const currentDate = new Date(); // Get the current date
                    const currentYear = currentDate.getFullYear();
                    const currentMonth = currentDate.getMonth() + 1; // JS months are 0-based, so +1
                    let Mnt_cal = 13 - currentMonth; // Equivalent of PHP's `$Mnt_cal`

                kraData.forEach((detail, index) => {
                totalWeight += parseFloat(detail.Wgt) || 0; // Use parseFloat to ensure it's a number
                totalWeight = parseFloat(totalWeight.toFixed(2));

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

                        let applockk = detail.Applockk;
                        let appRevert = detail.AppRevert;
                        let cmnt = detail.Cmnt;
                        let ach = detail.Ach;
                        let tgtDefId = detail.TgtDefId;
                        let unLckKRA = pmsData.UnLckKRA || 0; // Ensure safe handling

                            // Calculate PerM value
                        let PerM = 0;

                        // if (period === 'Monthly') {
                        //     let lm = index + 1;
                        //     PerM = Mnt_cal >= (13 - lm) ? 1 : 0;
                        // } 
                        // else if (period === 'Quarter') {
                        //     let quarterMappings = [
                        //         { name: 'Quarter 1', endMonth: 3, startRange: [10, 12] },
                        //         { name: 'Quarter 2', endMonth: 6, startRange: [7, 12] },
                        //         { name: 'Quarter 3', endMonth: 9, startRange: [4, 12] },
                        //         { name: 'Quarter 4', endMonth: 12, startRange: [1, 12] }
                        //     ];
                        //     let quarter = quarterMappings.find(q => currentMonth <= q.endMonth);
                        //     PerM = (quarter && Mnt_cal >= quarter.startRange[0] && Mnt_cal <= quarter.startRange[1]) ? 1 : 0;
                        // } 
                        // else if (period === '1/2 Annual') {
                        //     let halfYearMappings = [
                        //         { name: 'Half Year 1', endMonth: 6, startRange: [7, 12] },
                        //         { name: 'Half Year 2', endMonth: 12, startRange: [1, 12] }
                        //     ];
                        //     let halfYear = halfYearMappings.find(h => currentMonth <= h.endMonth);
                        //     PerM = (halfYear && Mnt_cal >= halfYear.startRange[0] && Mnt_cal <= halfYear.startRange[1]) ? 1 : 0;
                        // }
                        
                   
                        if (period === 'Monthly') {
                            const lm = index + 1;
                            if (Mnt_cal === 12 && index === 0) PerM = 1; // Jan
                            else if ([11, 12].includes(Mnt_cal) && index === 1) PerM = 1; // Feb
                            else if ([10, 11, 12].includes(Mnt_cal) && index === 2) PerM = 1; // Mar
                            else if ([9, 10, 11, 12].includes(Mnt_cal) && index === 3) PerM = 1; // Apr
                            else if ([8, 9, 10, 11, 12].includes(Mnt_cal) && index === 4) PerM = 1; // May
                            else if ([7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 5) PerM = 1; // June
                            else if ([6, 7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 6) PerM = 1; // July
                            else if ([5, 6, 7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 7) PerM = 1; // Aug
                            else if ([4, 5, 6, 7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 8) PerM = 1; // Sep
                            else if ([3, 4, 5, 6, 7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 9) PerM = 1; // Oct
                            else if ([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 10) PerM = 1; // Nov
                            else if ([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12].includes(Mnt_cal) && index === 11) PerM = 1; // Dec
                        }
                        else if (period === 'Quarter') {

                            let quarterMappings;
                            
                                quarterMappings = [
                                    { name: 'Quarter 1', months: [10, 11, 12], endMonth: 3 },
                                    { name: 'Quarter 2', months: [7, 8, 9], endMonth: 6 },
                                    { name: 'Quarter 3', months: [4, 5, 6], endMonth: 9 },
                                    { name: 'Quarter 4', months: [1, 2, 3], endMonth: 12 }
                                ];
                            

                            const q = quarterMappings[index];
                            PerM = q && q.months.includes(Mnt_cal) ? 1 : 0;
                        }
                        else if (period === '1/2 Annual') {
                            if (index === 0 && Mnt_cal >= 7 && Mnt_cal <= 12) { // Half Year 1
                                PerM = 1;
                            } else if (index === 1 && Mnt_cal >= 1 && Mnt_cal <= 12) { // Half Year 2
                                PerM = 1;
                            }
                        }
                        console.log("index:", index, "Mnt_cal:", Mnt_cal, "PerM:", PerM);
                        let allowEdit = (
                                // parseInt(PerM) === 1 &&
                                (
                                    (parseInt(lockk) === 0 && currentDate <= next10Day) ||
                                    (parseInt(lockk) === 2 && currentDate <= next14Day) ||
                                    (parseInt(lockk) === 0 && parseInt(unLckKRA) === 1) ||
                                    (parseInt(lockk) === 0 && parseInt(applockk) === 0 && appRevert === 'Y' && currentDate <= next14Day) ||
                                    (
                                        cmnt === '' &&
                                        (ach === '' || parseInt(ach) === 0 || parseFloat(ach) === 0.00) &&
                                        weight !== '' &&
                                        parseInt(weight) !== 0
                                    )
                                    ||
                                    submitstatus !== 1
                                )
                            );

                        // let allowEdit = showEdit && submitstatus !== 1;


                        // Define readonly or editable mode based on date range
                        let isReadonly = !isWithinDateRange;

                                rows += `
                                    <tr>
                                        <td id="logscoreforma${index}" style="display:none">${detail.LogScr}<td>
                                        <input type="hidden" class="tgt-id" value="${detail.TgtDefId }" id="tgt-id-${index}">

                                        <td><b>${index + 1}</b></td>
                                        <td>${detail.Tital}</td>
                                        <td style="text-align:center;">${weight}</td>
                                        <td style="text-align:center;">100</td>
                                        <td>${detail.Remark}</td>
                                        <td style="background-color: #e7ebed;">
                                    <input class="form-control self-rating-forma" style="width: 60px;" type="number" placeholder="Enter rating"  id="selfratingforma${index}"
                                value="${detail.Ach}" data-target="${detail.Tgt}" data-index="${index}"data-logic="${logic}" 
                                data-weight="${detail.Wgt}"
                                    readonly>
                                    </td>
                                        <td style="background-color: #e7ebed;">
                                            <textarea class="form-control self-remark-forma" required style="min-width: 200px;min-height:70px;" data-index="${index}"
                                            placeholder="Enter your remark" id="selfremarkforma${index}"readonly>${detail.Cmnt}</textarea>

                                        </td>
                                        <td id="scoreforma${index}" style="background-color: #e7ebed;text-align:center;">${detail.Scor}</td>
                                            <td>
                                               ${allowEdit && detail.Wgt != "0.00" 
                                                ? `<a title="Edit" class="fas fa-edit text-info mr-2" onclick="enableEditMode(this, ${index})"></a>` 
                                                : ''
                                            }

                                                
                                            <span class="edit-buttons" style="display: none;">
                                        <a title="Save" href="javascript:void(0);" onclick="saveRowDataforma(${index}, '${tgtDefId}','save')">
                                            <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                        </a>
                                        <a href="javascript:void(0);" style="padding: 2px 7px;font-size: 11px;" onclick="saveRowDataforma(${index}, '${tgtDefId}','submit')"
                                            class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit">
                                            <i style="font-size:14px;" class="ri-check-line"></i>
                                        </a>
                                    </span>
                            </td>
                                <td>${savestatus === 1 ? 
                                    `<a title="save" href=""><i style="font-size:14px;" class="ri-check-double-line mr-2 text-success"></i></a>` 
                                    : ''}

                                ${submitstatus === 1 ? 
                                    `<a title="submit" href=""><i style="font-size:14px;" class="fas fa-check-circle mr-2 text-success"></i></a>` 
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
                                    <td colspan="7"></td>
                                </tr>
                            `;
                            }
                            return rows;
            }

                function FunFormBTgt(id, period, target, weightage, logic, year_id) {
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
                                    url: "{{ route('kra.details.formb.employee') }}",
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
                                                            contentHtml = `
                                                    <p><strong>Logic:</strong> ${subKraData.Logic}</p>
                                                    <p><strong>Skill:</strong> ${subKraData.Skill}</p>
                                                    <p><strong>Description:</strong> ${subKraData.SkillComment}</p>
                                                    <table class="table table-pad" id="mykraeditbox">
                                                        <thead>
                                                            <tr style="text-align:center;">
                                                                <th rowspan="2"></th>
                                                                <th rowspan="2">SN.</th>
                                                                <th rowspan="2">Period</th>
                                                                <th rowspan="2">Weightage</th>
                                                                <th rowspan="2">Target</th>
                                                                <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                                                <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                                                <th rowspan="2">Action</th>
                                                                <th rowspan="2">Status</th>
                                                            </tr>
                                                            <tr>
                                                                <th>Self Rating</th>
                                                                <th>Remarks</th>
                                                                <th>Score</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="kraRows">
                                                            ${generateKraRowsAppraisalfromb(kraData, subKraData,subKraDatamain,logic,pmsData,period)}
                                                        </tbody>
                                                    </table>
                                                `;
                                            } else {
                                                const logic = subKraDatamain.Logic ;
                                                console.log(logic);

                                                contentHtml = `
                                        <p><strong>Logic:</strong> ${subKraDatamain.Logic}</p>
                                        <p><strong>Skill:</strong> ${subKraDatamain.Skill}</p>
                                        <p><strong>Description:</strong> ${subKraDatamain.SkillComment}</p>
                                        <table class="table table-pad" id="mykraeditbox">
                                            <thead>
                                                <tr style="text-align:center;">
                                                    <th rowspan="2"></th>
                                                    <th rowspan="2">SN.</th>
                                                    <th rowspan="2">Period</th>
                                                    <th rowspan="2">Weightage</th>
                                                    <th rowspan="2">Target</th>
                                                    <th style="width: 320px;" rowspan="2">Activity Performed</th>
                                                    <th style="text-align: center;" colspan="3">Employee Achievement Details</th>
                                                    <th rowspan="2">Action</th>
                                                    <th rowspan="2">Status</th>
                                                </tr>
                                                <tr style="text-align:center;">
                                                    
                                                    <th>Self Rating</th>
                                                    <th>Remarks</th>
                                                    <th>Score</th>
                                                </tr>
                                            </thead>
                                            <tbody id="kraRows">
                                                ${generateKraRowsAppraisalfromb(kraData, null, subKraDatamain, logic,pmsData,period)}
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


                function generateKraRowsAppraisalfromb(kraData, subKraData = null, subKraDatamain = null,logic) {
                                
                                let rows = '';
                                let totalWeight = 0;
                                const currentDate = new Date(); // Get the current date

                                kraData.forEach((detail, index) => {
                                console.log(detail);
                                totalWeight += parseFloat(detail.Wgt) || 0; // Use parseFloat to ensure it's a number
                                totalWeight = parseFloat(totalWeight.toFixed(2));

                                let lDate = new Date(detail.Ldate);

                            // Check if Ldate is within the current date range
                            let isWithinDateRange = lDate >= currentDate;
                            let weight = detail.Wgt; // Get weight from the detail object
                            let savestatus =detail.save_status;
                            let submitstatus =detail.submit_status;

                            // Check if the weight is a whole number or a decimal

                            // Define readonly or editable mode based on date range
                            let isReadonly = !isWithinDateRange;

                                    rows += `
                                        <tr>
                                            <td id="logscoreformb${index}" style="display:none">${detail.LogScr}<td>
                                            <input type="hidden" class="tgt-id-formb" value="${detail.TgtFbDefId }" id="tgt-id-formb-${index}">

                                            <td><b>${index + 1}</b></td>
                                            <td>${detail.Tital}</td>
                                            <td style="text-align:center;">${weight}</td>
                                            <td style="text-align:center;">100</td>
                                            <td>${detail.Remark}</td>
                                            <td style="background-color: #e7ebed;">
                                                <input class="form-control self-rating-formb" style="width: 60px;" type="number" placeholder="Enter rating"  id="self-rating-formb${index}"
                                                value="${detail.Ach}" data-target="${detail.Tgt}" data-index="${index}"data-logic="${logic}" 
                                                data-weight="${detail.Wgt}"
                                                readonly>
                                            </td>
                                            <td style="background-color: #e7ebed;">
                                                <textarea class="form-control self-remark-formb" required style="min-width: 200px;min-height:70px;" data-index="${index}"
                                                placeholder="Enter your remark" id="selfremarkformb${index}" readonly>${detail.Cmnt}</textarea>

                                            </td>
                                            <td id="score-formb${index}" style="background-color: #e7ebed;text-align:center;">${detail.Scor}</td>
                                                <td>
                                                ${isWithinDateRange && submitstatus === 0 && detail.Wgt != "0.00" ? 
                                                    `<a title="Edit" class="fas fa-edit text-info mr-2" onclick="enableEditMode(this, ${index})"></a>`
                                                    : ''
                                                }
                                                ${isWithinDateRange && submitstatus === 1? 
                                                ''
                                                    : ''
                                                }
                                                ${lDate < currentDate ? 
                                                    `<a title="Lock"><i style="font-size:14px;" class="ri-lock-2-line text-danger mr-2"></i></a>`
                                                    : ''
                                                    }

                                                <span class="edit-buttons" style="display: none;">
                                                <a title="Save" href="javascript:void(0);" onclick="saveRowDataFormb(${index}, '${detail.TgtFbDefId}','save')">
                                                    <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                                </a>
                                                <a href="javascript:void(0);" style="padding: 2px 7px;font-size: 11px;" onclick="saveRowDataFormb(${index}, '${detail.TgtFbDefId}','submit')"
                                                class="btn btn-outline-success waves-effect waves-light material-shadow-none" 
                                                title="Submit"><i style="font-size:14px;" class="ri-check-line"></i></a>
                                                </span>
                                </td>
                                <td>${savestatus === 1 ? 
                                        `<a title="Lock" href=""><i style="font-size:14px;" class="ri-check-double-line mr-2 text-success"></i></a>` 
                                        : ''}

                                    ${submitstatus === 1 ? 
                                        `<a title="Lock" href=""><i style="font-size:14px;" class="fas fa-check-circle mr-2 text-success"></i></a>` 
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
                                        <td colspan="7"></td>
                                    </tr>
                                `;
                                }
                                return rows;
                }

                function generateKraRows(kraData, subKraData = null, subKraDatamain = null,logic) {
                
                    let rows = '';
                    let totalWeight = 0;
                    const currentDate = new Date(); // Get the current date

                    kraData.forEach((detail, index) => {
                    console.log(detail);
                    totalWeight += parseFloat(detail.Wgt) || 0; // Use parseFloat to ensure it's a number
                    totalWeight = parseFloat(totalWeight.toFixed(2));

                    let lDate = new Date(detail.Ldate);

                    // Check if Ldate is within the current date range
                    let isWithinDateRange = lDate >= currentDate;
                    let weight = detail.Wgt; // Get weight from the detail object
                    let savestatus =detail.save_status;
                    let submitstatus =detail.submit_status;

                    // Check if the weight is a whole number or a decimal

                    // Define readonly or editable mode based on date range
                    let isReadonly = !isWithinDateRange;

                            rows += `
                                <tr>
                                    <td id="logscore${index}" style="display:none">${detail.LogScr}<td>
                                    <input type="hidden" class="tgt-id" value="${detail.TgtDefId }" id="tgt-id-${index}">

                                    <td><b>${index + 1}</b></td>
                                    <td>${detail.Tital}</td>
                                    <td style="text-align:center;">${weight}</td>
                                    <td style="text-align:center;">100</td>
                                    <td>${detail.Remark}</td>
                                    <td style="background-color: #e7ebed;">
                            <input class="form-control self-rating" style="width: 60px;" type="number" placeholder="Enter rating"  id="selfrating${index}"
                            value="${detail.Ach}" data-target="${detail.Tgt}" data-index="${index}"data-logic="${logic}" 
                            data-weight="${detail.Wgt}"
                            readonly>
                            </td>
                                    <td style="background-color: #e7ebed;">
                                        <textarea class="form-control self-remark" required style="min-width: 200px;min-height:70px;" data-index="${index}"
                                        placeholder="Enter your remark" id="selfremark${index}"	readonly>${detail.Cmnt}</textarea>

                                    </td>
                                    <td id="score${index}" style="background-color: #e7ebed;text-align:center;">${detail.Scor}</td>
                                        <td>
                                        ${isWithinDateRange && submitstatus === 0 && detail.Wgt != "0.00" ? 
                                            `<a title="Edit" class="fas fa-edit text-info mr-2" onclick="enableEditMode(this, ${index})"></a>`
                                            : ''
                                        }
                                        ${isWithinDateRange && submitstatus === 1? 
                                        ''
                                            : ''
                                        }
                                        ${lDate < currentDate ? 
                                            `<a title="Lock"><i style="font-size:14px;" class="ri-lock-2-line text-danger mr-2"></i></a>`
                                            : ''
                                            }

                                        <span class="edit-buttons" style="display: none;">
                                        <a title="Save" href="javascript:void(0);" onclick="saveRowData(${index}, '${detail.TgtDefId}','save')">
                                            <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
                                        </a>
                                        <a href="javascript:void(0);" style="padding: 2px 7px;font-size: 11px;" onclick="saveRowData(${index}, '${detail.TgtDefId}','submit')"
                                        class="btn btn-outline-success waves-effect waves-light material-shadow-none" 
                                        title="Submit"><i style="font-size:14px;" class="ri-check-line"></i></a>
                                        </span>
                        </td>
                        <td>${savestatus === 1 ? 
                                `<a title="Lock" href=""><i style="font-size:14px;" class="ri-check-double-line mr-2 text-success"></i></a>` 
                                : ''}

                            ${submitstatus === 1 ? 
                                `<a title="Lock" href=""><i style="font-size:14px;" class="fas fa-check-circle mr-2 text-success"></i></a>` 
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

                $(document).on('input', '.self-remark', function() {
                    let selfremark =$(this).val()|| ''; // Get the self-rating value, default to 0 if empty
                    console.log(selfremark);
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute

                    $('#selfremark' + index).text(selfremark); // Update only the respective row's score cell
                });
                // Real-time calculation function for score
                $(document).on('input', '.self-rating', function() {
                    let selfRating = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                    let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                    let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                    let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    var ach=Math.round(((target*selfRating)/100)*100)/100; //var ach=parseFloat(v);  
                    $('#selfrating' + index).text(selfRating); // Update only the respective row's score cell

                    // Calculate the logscore: selfRating * target / 100
                    // let logScore = (ach * target) / 100;

                    // Round the score if needed (optional, but common practice)
                    // logScore = ach;
                    //$('#logscore' + index).text(logScore); // Update only the respective row's score cell

                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logscore' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logscore' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logscore' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logscore' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell


                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logscore' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logscore' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logscore' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscore' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logscore' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscore' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logscore' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logscore' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logscore' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                                $('#logscore' + index).text(target); // Update only the respective row's score cell

                            } else if (ach > 15 && ach <= 20) {
                                EScore = Per80;
                                $('#logscore' + index).text(Per80); // Update only the respective row's score cell

                            } else if (ach > 20 && ach <= 25) {
                                EScore = Per50;
                                $('#logscore' + index).text(Per50); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscore' + index).text('0'); // Update only the respective row's score cell
                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscore' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscore' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            EScore = Per150;
                            $('#logscore' + index).text(Per150);

                        } else if (ach > 10 && ach <= 15) {
                            EScore = Per125;
                            $('#logscore' + index).text(Per125);

                        } else if (ach > 15 && ach <= 20) {
                            EScore = Per100;
                            $('#logscore' + index).text(Per100);

                        } else if (ach > 20 && ach <= 25) {
                            EScore = Per85;
                            $('#logscore' + index).text(Per85);

                        } else if (ach > 25 && ach <= 30) {
                            EScore = Per75;
                            $('#logscore' + index).text(Per75);

                        } 
                        else {
                            EScore = 0;
                            $('#logscore' + index).text('0');
                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            EScore = Per150;
                            $('#logscore' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logscore' + index).text(Per100);

                        } else if (ach > 2 && ach <= 5) {
                            EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach > 5 && ach <= 10) {
                            EScore = Per75;
                            $('#logscore' + index).text(Per75);

                        } else {
                            EScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    else if (logic === 'Logic7a') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per120;
                            $('#logscore' + index).text(Per120);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logscore' + index).text(Per100);

                        } else if (ach > 2 && ach <= 3) {
                            EScore = Per75;
                            $('#logscore' + index).text(Per75);

                        } else if (ach > 3 && ach <= 4) {
                            EScore = Per50;
                            $('#logscore' + index).text(Per50);

                        } else {
                            EScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    // Logic9
                    else if (logic === 'Logic9') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        if (ach < Per90) {
                            var EScore = ach;
                            $('#logscore' + index).text(ach);

                        } else if (ach >= Per90) {
                            var EScore = target;
                            $('#logscore' + index).text(target);

                        } else {
                            var EScore = logScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscore' + index).text('0');

                        } else if (ach == Per90) {
                            var EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach > Per90 && ach <= Per93) {
                            var EScore = Per105;
                            $('#logscore' + index).text(Per105);

                        } else if (ach > Per93 && ach <= Per97) {
                            var EScore = Per110;
                            $('#logscore' + index).text(Per110);

                        } else if (ach > Per97) {
                            var EScore = Per120;
                            $('#logscore' + index).text(Per120);

                        } else {
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }

                    // Logic11
                    else if (logic === 'Logic11') {
                        var EScore = ach;
                        $('#logscore' + index).text(ach);

                        var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }

                    // Logic12
                    else if (logic === 'Logic12') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                        } else if (ach >= Per90 && ach<=Per110) {
                            var EScore = ach;
                            $('#logscore' + index).text(ach);

                        } 
                        else if (ach > Per110) {
                            var EScore = Per110;
                            $('#logscore' + index).text(Per110);
                        }
                        else {
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscore' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach >= Per90 && ach <= Per110) {
                            var EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach >= Per110 && ach <= Per120) {
                            var EScore = Per80;
                            $('#logscore' + index).text(Per80);

                        } else if (ach >= Per120) {
                            var EScore = Per70;
                            $('#logscore' + index).text(Per70);

                        } else {
                            var EScore = logScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscore' + index).text(Per70);

                        } else if (ach >= Per70 && ach <= Per80) {
                            var EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach >= Per80 && ach <= Per120) {
                            var EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach >= Per120 && ach <= Per130) {
                            var EScore = Per80;
                            $('#logscore' + index).text(Per80);

                        } else if (ach >= Per130) {
                            var EScore = Per70;
                            $('#logscore' + index).text(Per70);

                        } else {
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscore' + index).text('0');
                        } else if (ach >= Per75 && ach <= Per80) {
                            var EScore = Per80;
                            $('#logscore' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per85) {
                            var EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach >= Per85 && ach <= Per90) {
                            var EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach >= 5) {
                            var EScore = Per110;
                            $('#logscore' + index).text(Per110);

                        } else {
                            var EScore = logScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscore' + index).text('0');

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#logscore' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#logscore' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                        var Per40=Math.round(((target*40)/100)*100)/100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#logscore' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per50;
                            $('#logscore' + index).text(Per50);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per60;
                            $('#logscore' + index).text(Per60);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach >= Per99) {
                            EScore = target;
                            $('#logscore' + index).text(target);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2));

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
                            $('#logscore' + index).text('0');

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per70;
                            $('#logscore' + index).text(Per70);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logscore' + index).text(Per90);

                        } else if (ach >= Per99 && ach < Per995) {
                            EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach >= Per995) {
                            EScore = Per110;
                            $('#logscore' + index).text(Per110);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2));

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
                            $('#logscore' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per60;
                            $('#logscore' + index).text(Per60);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per80;
                            $('#logscore' + index).text(Per80);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = target;
                            $('#logscore' + index).text(target);

                        } else if (ach >= Per99) {
                            EScore = Per110;
                            $('#logscore' + index).text(Per110);
                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2));
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
                            $('#logscore' + index).text(Per110);

                        }
                        else if (ach > Per94 && ach <= Per99) { 
                            var EScore = Per105; 
                            $('#logscore' + index).text(Per105);

                        }
                        
                        else if (ach > Per99 && ach <= Per105) { 
                            var EScore = target; 
                            $('#logscore' + index).text(target);

                        }
                        else if (ach > Per105 && ach <= Per110) {
                            var EScore = Per95; 
                            $('#logscore' + index).text(Per95);

                        }
                        else if (ach > Per110) { 
                            var EScore = Per90; 
                            $('#logscore' + index).text(Per90);

                        }
                        else {
                             var EScore = 0; 
                             $('#logscore' + index).text('0');

                            }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update the score for this row
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
                            $('#logscore' + index).text(target);

                        }
                        else if (ach > Per15 && ach <= Per22) {
                             var EScore = Per90;
                            $('#logscore' + index).text(Per90);

                             }
                        else if (ach > Per22 && ach <= Per29) { 
                            var EScore = Per80; 
                            $('#logscore' + index).text(Per80);

                        }
                        else if (ach > Per29 && ach <= Per36) {
                             var EScore = Per75; 
                             $('#logscore' + index).text(Per75);

                            }
                        else if (ach > Per36 && ach <= Per42) { 
                            var EScore = Per50; 
                            $('#logscore' + index).text(Per50);

                        }
                        else if (ach > Per42) { 
                            var EScore = 0; 
                            $('#logscore' + index).text('0');

                        }
                        else { var EScore = 0; 
                            $('#logscore' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update the score for this row
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
                            $('#logscore' + index).text('0');

                         }
                        else if (ach >= Per60 && ach <= Per69) { 
                            var EScore = Per25; 
                            $('#logscore' + index).text(Per25);

                        }
                        else if (ach > Per69 && ach <= Per79) { 
                            var EScore = Per50;
                            $('#logscore' + index).text(Per50);

                         }
                        else if (ach > Per79 && ach <= Per120) { 
                            var EScore = target;
                            $('#logscore' + index).text(target);

                         }
                        else { 
                            var EScore = 0; 
                            $('#logscore' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic19') {
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach < Per70) { 
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                         }
                        else if (ach >= Per70 && ach <= Per80) { 
                            var EScore = Per50; 
                            $('#logscore' + index).text(Per50);

                        }
                        else if (ach > Per80 && ach <= target) { 
                            var EScore = target; 
                            $('#logscore' + index).text(target);

                        }
                        else { 
                            var EScore = 0;
                            $('#logscore' + index).text('0');

                         }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                
                });
                $(document).on('input', '.self-remark-forma', function() {
                    let selfremark =$(this).val()|| ''; // Get the self-rating value, default to 0 if empty
                    console.log(selfremark);
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute

                    $('#selfremarkforma' + index).text(selfremark); // Update only the respective row's score cell
                });
                // Real-time calculation function for score
                $(document).on('input', '.self-rating-forma', function() {
                    let selfRating = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                    let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                    let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                    let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    var ach=Math.round(((target*selfRating)/100)*100)/100; //var ach=parseFloat(v);  
                    $('#selfratingforma' + index).text(selfRating); // Update only the respective row's score cell

                    // Calculate the logscore: selfRating * target / 100
                    // let logScore = (ach * target) / 100;

                    // Round the score if needed (optional, but common practice)
                    // logScore = ach;
                    // $('#logscoreforma' + index).text(logScore); // Update only the respective row's score cell

                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target

                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logscoreforma' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logscoreforma' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logscoreforma' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logscoreforma' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell


                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logscoreforma' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logscoreforma' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logscoreforma' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscoreforma' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logscoreforma' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscoreforma' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logscoreforma' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logscoreforma' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore=0;
                            $('#logscoreforma' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                                $('#logscoreforma' + index).text(target); // Update only the respective row's score cell

                            } else if (ach > 15 && ach <= 20) {
                                EScore = Per80;
                                $('#logscoreforma' + index).text(Per80); // Update only the respective row's score cell

                            } else if (ach > 20 && ach <= 25) {
                                EScore = Per50;
                                $('#logscoreforma' + index).text(Per50); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscoreforma' + index).text('0'); // Update only the respective row's score cell
                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscoreforma' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscoreforma' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            EScore = Per150;
                            $('#logscoreforma' + index).text(Per150);

                        } else if (ach > 10 && ach <= 15) {
                            EScore = Per125;
                            $('#logscoreforma' + index).text(Per125);

                        } else if (ach > 15 && ach <= 20) {
                            EScore = Per100;
                            $('#logscoreforma' + index).text(Per100);

                        } else if (ach > 20 && ach <= 25) {
                            EScore = Per85;
                            $('#logscoreforma' + index).text(Per85);

                        } else if (ach > 25 && ach <= 30) {
                            EScore = Per75;
                            $('#logscoreforma' + index).text(Per75);

                        } 
                        else {
                            EScore = 0;
                            $('#logscoreforma' + index).text('0');
                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            EScore = Per150;
                            $('#logscoreforma' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logscoreforma' + index).text(Per100);

                        } else if (ach > 2 && ach <= 5) {
                            EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach > 5 && ach <= 10) {
                            EScore = Per75;
                            $('#logscoreforma' + index).text(Per75);

                        } else {
                            EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    else if (logic === 'Logic7a') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per120;
                            $('#logscoreforma' + index).text(Per120);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logscoreforma' + index).text(Per100);

                        } else if (ach > 2 && ach <= 3) {
                            EScore = Per75;
                            $('#logscoreforma' + index).text(Per75);

                        } else if (ach > 3 && ach <= 4) {
                            EScore = Per50;
                            $('#logscoreforma' + index).text(Per50);

                        } else {
                            EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }
                    // Logic9
                    else if (logic === 'Logic9') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        if (ach < Per90) {
                            var EScore = ach;
                            $('#logscoreforma' + index).text(ach);

                        } else if (ach >= Per90) {
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else {
                            var EScore = logScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscoreforma' + index).text('0');

                        } else if (ach == Per90) {
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach > Per90 && ach <= Per93) {
                            var EScore = Per105;
                            $('#logscoreforma' + index).text(Per105);

                        } else if (ach > Per93 && ach <= Per97) {
                            var EScore = Per110;
                            $('#logscoreforma' + index).text(Per110);

                        } else if (ach > Per97) {
                            var EScore = Per120;
                            $('#logscoreforma' + index).text(Per120);

                        } else {
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }

                    // Logic11
                    else if (logic === 'Logic11') {
                        var EScore = ach;
                        $('#logscoreforma' + index).text(ach);

                        var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

                    }

                    // Logic12
                    else if (logic === 'Logic12') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }  else if (ach >= Per90 && ach<=Per110) {
                            var EScore = ach;
                            $('#logscoreforma' + index).text(ach);

                        } 
                        else if (ach > Per110) {
                            var EScore = Per110;
                            $('#logscoreforma' + index).text(Per110);
                        }
                        else {
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscoreforma' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach >= Per90 && ach <= Per110) {
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach >= Per110 && ach <= Per120) {
                            var EScore = Per80;
                            $('#logscoreforma' + index).text(Per80);

                        } else if (ach >= Per120) {
                            var EScore = Per70;
                            $('#logscoreforma' + index).text(Per70);

                        } else {
                            var EScore = logScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscoreforma' + index).text(Per70);

                        } else if (ach >= Per70 && ach <= Per80) {
                            var EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach >= Per80 && ach <= Per120) {
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach >= Per120 && ach <= Per130) {
                            var EScore = Per80;
                            $('#logscoreforma' + index).text(Per80);

                        } else if (ach >= Per130) {
                            var EScore = Per70;
                            $('#logscoreforma' + index).text(Per70);

                        } else {
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscoreforma' + index).text('0');
                        } else if (ach >= Per75 && ach <= Per80) {
                            var EScore = Per80;
                            $('#logscoreforma' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per85) {
                            var EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach >= Per85 && ach <= Per90) {
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach >= Per90) {
                            var EScore = Per110;
                            $('#logscoreforma' + index).text(Per110);

                        } else {
                            var EScore = logScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                            $('#logscoreforma' + index).text('0');

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#logscoreforma' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#logscoreforma' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell

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
                        var Per40=Math.round(((target*40)/100)*100)/100; 
                        var Per60 = Math.round((target - Per40) * 100) / 100;
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        
                        var EScore = 0;
                        if (ach < Per96) {
                            EScore = 0;
                            $('#logscoreforma' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per50;
                            $('#logscoreforma' + index).text(Per50);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per60;
                            $('#logscoreforma' + index).text(Per60);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach >= Per99) {
                            EScore = target;
                            $('#logscoreforma' + index).text(target);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2));

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
                            $('#logscoreforma' + index).text('0');

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per70;
                            $('#logscoreforma' + index).text(Per70);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                        } else if (ach >= Per99 && ach < Per995) {
                            EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach >= Per995) {
                            EScore = Per110;
                            $('#logscoreforma' + index).text(Per110);

                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2));

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
                            $('#logscoreforma' + index).text('0');

                        } else if (ach >= Per96 && ach < Per97) {
                            EScore = Per60;
                            $('#logscoreforma' + index).text(Per60);

                        } else if (ach >= Per97 && ach < Per98) {
                            EScore = Per80;
                            $('#logscoreforma' + index).text(Per80);

                        } else if (ach >= Per98 && ach < Per99) {
                            EScore = target;
                            $('#logscoreforma' + index).text(target);

                        } else if (ach >= Per99) {
                            EScore = Per110;
                            $('#logscoreforma' + index).text(Per110);
                        }
                        
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2));
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
                            $('#logscoreforma' + index).text(Per110);

                        }
                        else if (ach > Per94 && ach <= Per99) { 
                            var EScore = Per105; 
                            $('#logscoreforma' + index).text(Per105);

                        }
                    
                        else if (ach > Per99 && ach <= Per105) { 
                            var EScore = target; 
                            $('#logscoreforma' + index).text(target);

                        }
                        else if (ach > Per105 && ach <= Per110) {
                            var EScore = Per95; 
                            $('#logscoreforma' + index).text(Per95);

                        }
                        else if (ach > Per110) { 
                            var EScore = Per90; 
                            $('#logscoreforma' + index).text(Per90);

                        }
                        else {
                             var EScore = 0; 
                             $('#logscoreforma' + index).text('0');

                            }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
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
                            $('#logscoreforma' + index).text(target);

                        }
                        else if (ach > Per15 && ach <= Per22) {
                             var EScore = Per90;
                            $('#logscoreforma' + index).text(Per90);

                             }
                        else if (ach > Per22 && ach <= Per29) { 
                            var EScore = Per80; 
                            $('#logscoreforma' + index).text(Per80);

                        }
                        else if (ach > Per29 && ach <= Per36) {
                             var EScore = Per75; 
                             $('#logscoreforma' + index).text(Per75);

                            }
                        else if (ach > Per36 && ach <= Per42) { 
                            var EScore = Per50; 
                            $('#logscoreforma' + index).text(Per50);


                        }
                        else if (ach > Per42) { 
                            var EScore = 0; 
                            $('#logscoreforma' + index).text('0');

                        }
                        else { var EScore = 0; 
                            $('#logscoreforma' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
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
                            $('#logscoreforma' + index).text('0');

                         }
                        else if (ach >= Per60 && ach <= Per69) { 
                            var EScore = Per25; 
                            $('#logscoreforma' + index).text(Per25);

                        }
                        else if (ach > Per69 && ach <= Per79) { 
                            var EScore = Per50;
                            $('#logscoreforma' + index).text(Per50);

                         }
                        else if (ach > Per79 && ach <= Per120) { 
                            var EScore = target;
                            $('#logscoreforma' + index).text(target);

                         }
                        else { 
                            var EScore = 0; 
                            $('#logscoreforma' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                    else if (logic === 'Logic19') {
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach < Per70) { 
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                         }
                        else if (ach >= Per70 && ach <= Per80) { 
                            var EScore = Per50; 
                            $('#logscoreforma' + index).text(Per50);

                        }
                        else if (ach > Per80 && ach <= target) { 
                            var EScore = target; 
                            $('#logscoreforma' + index).text(target);

                        }
                        else { 
                            var EScore = 0;
                            $('#logscoreforma' + index).text('0');

                         }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#scoreforma' + index).text(MScore.toFixed(2)); // Update the score for this row
                    }
                
                });

                //annual rating appraisal
                $(document).on('input', '.annual-rating-kra', function() {
                    let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                    let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                    let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                    let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute

                    var ach=annualratingkra;

                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute

                    // Calculate the logscore: selfRating * target / 100
                    // let logScorekra = (ach * target) / 100;

                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        console.log(target);
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logScorekra' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logScorekra' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                            EScore = 0;
                            $('#logScorekra' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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

                            $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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

                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                            EScore = Per150;
                            $('#logScorekra' + index).text(Per150);

                        } else if (ach > 10 && ach <= 15) {
                            EScore = Per125;
                            $('#logScorekra' + index).text(Per125);

                        } else if (ach > 15 && ach <= 20) {
                            EScore = Per100;
                            $('#logScorekra' + index).text(Per100);

                        } else if (ach > 20 && ach <= 25) {
                            EScore = Per85;
                            $('#logScorekra' + index).text(Per85);

                        } else if (ach > 25 && ach <= 30) {
                            EScore = Per75;
                            $('#logScorekra' + index).text(Per75);

                        } 
                        else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');
                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                            EScore = Per150;
                            $('#logScorekra' + index).text(Per150);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logScorekra' + index).text(Per100);

                        } else if (ach > 2 && ach <= 5) {
                            EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach > 5 && ach <= 10) {
                            EScore = Per75;
                            $('#logScorekra' + index).text(Per75);

                        } else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();

                    }
                    else if (logic === 'Logic7a') {
                        // Logic7 Logic
                        if (target == 8.33) {
                            ach = ach * 12;
                        } else if (target == 25) {
                            ach = ach * 4;
                        } else if (target == 50) {
                            ach = ach * 2;
                        }

                        let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                        let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                        let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                        let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach == 0) {
                            EScore = Per120;
                            $('#logScorekra' + index).text(Per120);

                        } else if (ach > 0 && ach <= 2) {
                            EScore = Per100;
                            $('#logScorekra' + index).text(Per100);

                        } else if (ach > 2 && ach <= 3) {
                            EScore = Per75;
                            $('#logScorekra' + index).text(Per75);

                        } else if (ach > 3 && ach <= 4) {
                            EScore = Per50;
                            $('#logScorekra' + index).text(Per50);

                        } else {
                            EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                            var EScore = logScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();

                    }

                    // Logic11
                    else if (logic === 'Logic11') {
                        var EScore = ach;
                        $('#logScorekra' + index).text(ach);

                        var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updategrandscore();

                    }

                    // Logic12
                    else if (logic === 'Logic12') {
                        var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                        var Per90 = Math.round((target - Per10) * 100) / 100;
                        var Per110 = Math.round((target + Per10) * 100) / 100;

                        if (ach < Per90) {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }  else if (ach >= Per90 && ach<=Per110) {
                            var EScore = ach;
                            $('#logScorekra' + index).text(ach);

                        }  else if (ach > Per110) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);
                        }
                        else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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

                        } else if (ach >= Per80 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per90 && ach <= Per110) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per110 && ach <= Per120) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per120) {
                            var EScore = Per70;
                            $('#logScorekra' + index).text(Per70);

                        } else {
                            var EScore = logScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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

                        } else if (ach >= Per70 && ach <= Per80) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per80 && ach <= Per120) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per120 && ach <= Per130) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per130) {
                            var EScore = Per70;
                            $('#logScorekra' + index).text(Per70);

                        } else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        } else if (ach >= Per75 && ach <= Per80) {
                            var EScore = Per80;
                            $('#logScorekra' + index).text(Per80);

                        } else if (ach >= Per80 && ach <= Per85) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach >= Per85 && ach <= Per90) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per90) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);

                        } else {
                            var EScore = logScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#logScorekra' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logScorekra' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#logScorekra' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
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
                        var Per40=Math.round(((target*40)/100)*100)/100; 
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
                        $('#krascore' + index).val(MScore.toFixed(2));
                        updategrandscore();

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
                        $('#krascore' + index).val(MScore.toFixed(2));
                        updategrandscore();

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
                        $('#krascore' + index).val(MScore.toFixed(2));
                        updategrandscore();

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
                        else if (ach > Per94 && ach <= Per99) { 
                            var EScore = Per105; 
                            $('#logScorekra' + index).text(Per105);

                        }
                      
                        else if (ach > Per99 && ach <= Per105) { 
                            var EScore = target; 
                            $('#logScorekra' + index).text(target);

                        }
                        else if (ach > Per105 && ach <= Per110) {
                            var EScore = Per95; 
                            $('#logScorekra' + index).text(Per95);

                        }
                        else if (ach > Per110) { 
                            var EScore = Per90; 
                            $('#logScorekra' + index).text(Per90);

                        }
                        else {
                             var EScore = 0; 
                             $('#logScorekra' + index).text('0');

                            }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update the score for this row
                                                updategrandscore();

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
                            $('#logScorekra' + index).text(Per50);


                        }
                        else if (ach > Per42) { 
                            var EScore = 0; 
                            $('#logScorekra' + index).text('0');

                        }
                        else { var EScore = 0; 
                            $('#logScorekra' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update the score for this row
                                                updategrandscore();

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
                            $('#logScorekra' + index).text('0');

                         }
                        else if (ach >= Per60 && ach <= Per69) { 
                            var EScore = Per25; 
                            $('#logScorekra' + index).text(Per25);

                        }
                        else if (ach > Per69 && ach <= Per79) { 
                            var EScore = Per50;
                            $('#logScorekra' + index).text(Per50);

                         }
                        else if (ach > Per79 && ach <= Per120) { 
                            var EScore = target;
                            $('#logScorekra' + index).text(target);

                         }
                        else { 
                            var EScore = 0; 
                            $('#logScorekra' + index).text('0');

                        }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update the score for this row
                                                updategrandscore();

                    }
                    else if (logic === 'Logic19') {
                        var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                        var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                        var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                        if (ach < Per70) { 
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                         }
                        else if (ach >= Per70 && ach <= Per80) { 
                            var EScore = Per50; 
                            $('#logScorekra' + index).text(Per50);

                        }
                        else if (ach > Per80 && ach <= target) { 
                            var EScore = target; 
                            $('#logScorekra' + index).text(target);

                        }
                        else { 
                            var EScore = 0;
                            $('#logScorekra' + index).text('0');

                         }

                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascore' + index).val(MScore.toFixed(2)); // Update the score for this row
                                                updategrandscore();

                    }
                });


                //annual rating appraisal form b
                $(document).on('input', '.annual-rating-formb', function() {
                    let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                    let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                    let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                    let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                    var ach=annualratingkra;
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    // Calculate the logscore: selfRating * target / 100
                    // let logScorekra = (ach * target) / 100;

                    // Round the score if needed (optional, but common practice)
                    // logScorekra = logScorekra.toFixed(2);
                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logScorekraformb' + index).val(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logScorekraformb' + index).val(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#krascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();

                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logScorekraformb' + index).val(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logScorekraformb' + index).val(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logScorekraformb' + index).val(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logScorekraformb' + index).val(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();

                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logScorekraformb' + index).val(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScorekraformb' + index).val('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logScorekraformb' + index).val(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logScorekraformb' + index).val('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#krascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();

                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logScorekraformb' + index).val(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logScorekraformb' + index).val(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logScorekraformb' + index).val('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#krascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();

                    }

                    
                });

                function updateGrandTotal() {
                    let total = 0;

                    // Iterate over all input fields with IDs starting with "krascoreformb"
                            // Iterate over all input fields with IDs starting with "krascoreformb"
                    $('[id^="krascoreformb"]').each(function() {
                            // Get the value of the current input field
                            let value = $(this).val();

                            // Ensure the value is a valid number
                            if (!isNaN(value) && value.trim() !== "") {
                                total += parseFloat(value); // Add the value to the total
                            }
                        });

                        // Iterate over all input fields with IDs starting with "subkrascoreformb"
                        $('[id^="subkrascoreformb"]').each(function() {
                            // Get the value of the current input field
                            let value = $(this).val();

                            // Ensure the value is a valid number
                            if (!isNaN(value) && value.trim() !== "") {
                                total += parseFloat(value); // Add the value to the total
                            }
                        });
                        console.log(total);

                        // Update the grand total field
                        $("#grandtotalfinalempFormb").text(total.toFixed(2)); // Set the grand total value with 2 decimal points
                }
                function updategrandscore() {
                let total = 0;
                let lastTotal = parseFloat($("#grandtotalfinalemp").text()) || 0;

                console.log("updategrandscore() called");

                $('[id^="krascore"], [id^="subkrascore"]').each(function () {
                    let elementId = $(this).attr('id'); // Get full element ID

                    // ✅ Exclude `formb` entries
                    if (elementId.includes("formb")) {
                        console.log(`Skipping formb ID: ${elementId}`);
                        return;
                    }

                    let value = $(this).is("input") ? $(this).val().trim() : $(this).text().trim();
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
                } else {
                    console.log("No change in total, skipping UI update.");
                }
            }

             
                //subkraannual appraisal form b
                $(document).on('input', '.annual-rating-formb-subkra', function() {
                let annualratingkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                var ach=annualratingkra;
                let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute

                if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logScoresubkraformb' + index).val(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#subkrascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logScoresubkraformb' + index).val(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();



                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logScoresubkraformb' + index).val(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScoresubkraformb' + index).val('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logScoresubkraformb' + index).val(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logScoresubkraformb' + index).val('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#subkrascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();


                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logScoresubkraformb' + index).val(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logScoresubkraformb' + index).val(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logScoresubkraformb' + index).val('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#subkrascoreformb' + index).val(MScore.toFixed(2)); // Update only the respective row's score cell
                        updateGrandTotal();

                    }

            });

                //subkraannual appraisal
                $(document).on('input', '.annual-rating-subkra', function() {
                    let annualratingsubkra = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                    let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                    let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                    let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                    var ach=annualratingsubkra;
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    if (logic === 'Logic1') {
                            // Calculate Per50, Per150, and the final EScore based on the provided logic
                            var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                            var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                            if (ach <= Per150) {
                                var EScore = ach;
                                $('#logScoresubkra' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                var EScore = Per150;
                                $('#logScoresubkra' + index).text(Per150); // Update only the respective row's score cell
                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                            
                            $('#subkrascore' + index).val(MScore.toFixed(2));
                            updategrandscore(); 

                        } 
                        else if (logic === 'Logic2') {
                            let EScore;
                            if (ach <= target) {
                                EScore = ach;
                                $('#logScoresubkra' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = target;
                                $('#logScoresubkra' + index).text(target); // Update only the respective row's score cell

                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                        



                        }
                        else if (logic === 'Logic2a') {
                            let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                            let Per110 = Math.round((target + Per10) * 100) / 100;
                            let EScore;
                            if (ach >= Per110) {
                                EScore = Per110;
                                $('#logScoresubkra' + index).text(Per110); // Update only the respective row's score cell

                            } else {
                                EScore = ach;
                                $('#logScoresubkra' + index).text(ach); // Update only the respective row's score cell

                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                        


                        }
                        else if (logic === 'Logic3') {
                            let EScore;
                                if (ach === target) {
                                    EScore = ach;
                                    $('#logScoresubkra' + index).text(ach); // Update only the respective row's score cell

                                } else {
                                    EScore = 0;
                                    $('#logScoresubkra' + index).text('0'); // Update only the respective row's score cell

                                }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                        
                            

                        }
                    
                        if (logic === 'Logic4') {
                            // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                            let EScore;
                            if (ach >= target) {
                                EScore = target;
                                $('#logScoresubkra' + index).text(target); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0'); // Update only the respective row's score cell

                            }

                            MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell\
                        


                        }
                        else if (logic === 'Logic5') {
                            let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                            let Per70 = Math.round((target - Per30) * 100) / 100;
                            let EScore = 0;
                            if (ach >= Per70 && ach < target) {
                                EScore = ach;
                                $('#logScoresubkra' + index).text(ach); // Update only the respective row's score cell

                            } else if (ach >= target) {
                                EScore = target;
                                $('#logScoresubkra' + index).text(target); // Update only the respective row's score cell

                            }
                            else{
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0'); // Update only the respective row's score cell

                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                    $('#logScoresubkra' + index).text(target); // Update only the respective row's score cell

                                } else if (ach > 15 && ach <= 20) {
                                    EScore = Per80;
                                    $('#logScoresubkra' + index).text(Per80); // Update only the respective row's score cell

                                } else if (ach > 20 && ach <= 25) {
                                    EScore = Per50;
                                    $('#logScoresubkra' + index).text(Per50); // Update only the respective row's score cell

                                } else {
                                    EScore = 0;
                                    $('#logScoresubkra' + index).text('0'); // Update only the respective row's score cell
                                }
                                MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                                $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                    


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
                                $('#logScoresubkra' + index).text(target); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0'); // Update only the respective row's score cell

                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                EScore = Per150;
                                $('#logScoresubkra' + index).text(Per150);

                            } else if (ach > 10 && ach <= 15) {
                                EScore = Per125;
                                $('#logScoresubkra' + index).text(Per125);

                            } else if (ach > 15 && ach <= 20) {
                                EScore = Per100;
                                $('#logScoresubkra' + index).text(Per100);

                            } else if (ach > 20 && ach <= 25) {
                                EScore = Per85;
                                $('#logScoresubkra' + index).text(Per85);

                            } else if (ach > 25 && ach <= 30) {
                                EScore = Per75;
                                $('#logScoresubkra' + index).text(Per75);

                            } 
                            else {
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0');
                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                EScore = Per150;
                                $('#logScoresubkra' + index).text(Per150);

                            } else if (ach > 0 && ach <= 2) {
                                EScore = Per100;
                                $('#logScoresubkra' + index).text(Per100);

                            } else if (ach > 2 && ach <= 5) {
                                EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                            } else if (ach > 5 && ach <= 10) {
                                EScore = Per75;
                                $('#logScoresubkra' + index).text(Per75);

                            } else {
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


                        }
                        else if (logic === 'Logic7a') {
                            // Logic7 Logic
                            if (target == 8.33) {
                                ach = ach * 12;
                            } else if (target == 25) {
                                ach = ach * 4;
                            } else if (target == 50) {
                                ach = ach * 2;
                            }

                            let Per120 = Math.round(((target * 120) / 100) * 100) / 100;
                            let Per100 = Math.round(((target * 100) / 100) * 100) / 100;
                            let Per75 = Math.round(((target * 75) / 100) * 100) / 100;
                            let Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                            if (ach == 0) {
                                EScore = Per120;
                                $('#logScoresubkra' + index).text(Per120);

                            } else if (ach > 0 && ach <= 2) {
                                EScore = Per100;
                                $('#logScoresubkra' + index).text(Per100);

                            } else if (ach > 2 && ach <= 3) {
                                EScore = Per75;
                                $('#logScoresubkra' + index).text(Per75);

                            } else if (ach > 3 && ach <= 4) {
                                EScore = Per50;
                                $('#logScoresubkra' + index).text(Per50);

                            } else {
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            MScore = Math.round(((EScore / target) * weight) * 100) / 100;

                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


                        }
                        // Logic9
                        else if (logic === 'Logic9') {
                            var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                            var Per90 = Math.round((target - Per10) * 100) / 100;
                            if (ach < Per90) {
                                var EScore = ach;
                                $('#logScoresubkra' + index).text(ach);

                            } else if (ach >= Per90) {
                                var EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else {
                                var EScore = logScoresubkra = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                $('#logScoresubkra' + index).text('0');

                            } else if (ach == Per90) {
                                var EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else if (ach > Per90 && ach <= Per93) {
                                var EScore = Per105;
                                $('#logScoresubkra' + index).text(Per105);

                            } else if (ach > Per93 && ach <= Per97) {
                                var EScore = Per110;
                                $('#logScoresubkra' + index).text(Per110);

                            } else if (ach > Per97) {
                                var EScore = Per120;
                                $('#logScoresubkra' + index).text(Per120);

                            } else {
                                var EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


                        }

                        // Logic11
                        else if (logic === 'Logic11') {
                            var EScore = ach;
                            $('#logScoresubkra' + index).text(ach);

                            var MScore = Math.round(((target / EScore) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


                        }

                        // Logic12
                        else if (logic === 'Logic12') {
                            var Per10 = Math.round(((target * 10) / 100) * 100) / 100; 
                            var Per90 = Math.round((target - Per10) * 100) / 100;
                            var Per110 = Math.round((target + Per10) * 100) / 100;

                            if (ach < Per90) {
                                var EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }  else if (ach >= Per90 && ach<=Per110) {
                                var EScore = ach;
                                $('#logScoresubkra' + index).text(ach);

                            }  else if (ach > Per110) {
                            var EScore = Per110;
                            $('#logScoresubkra' + index).text(Per110);
                            }
                            else {
                                var EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                $('#logScoresubkra' + index).text(Per80);

                            } else if (ach >= Per80 && ach <= Per90) {
                                var EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                            } else if (ach >= Per90 && ach <= Per110) {
                                var EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else if (ach >= Per110 && ach <= Per120) {
                                var EScore = Per80;
                                $('#logScoresubkra' + index).text(Per80);

                            } else if (ach >= Per120) {
                                var EScore = Per70;
                                $('#logScoresubkra' + index).text(Per70);

                            } else {
                                var EScore = logScoresubkra = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;  
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                $('#logScoresubkra' + index).text(Per70);

                            } else if (ach >= Per70 && ach <= Per80) {
                                var EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                            } else if (ach >= Per80 && ach <= Per120) {
                                var EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else if (ach >= Per120 && ach <= Per130) {
                                var EScore = Per80;
                                $('#logScoresubkra' + index).text(Per80);

                            } else if (ach >= Per130) {
                                var EScore = Per70;
                                $('#logScoresubkra' + index).text(Per70);

                            } else {
                                var EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                                $('#logScoresubkra' + index).text('0');
                            } else if (ach >= Per75 && ach <= Per80) {
                                var EScore = Per80;
                                $('#logScoresubkra' + index).text(Per80);

                            } else if (ach >= Per80 && ach <= Per85) {
                                var EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                            } else if (ach >= Per85 && ach <= Per90) {
                                var EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else if (ach >= Per90) {
                                var EScore = Per110;
                                $('#logScoresubkra' + index).text(Per110);

                            } else {
                                var EScore = logScoresubkra = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                            $('#logScoresubkra' + index).text('0');

                        } else if (ach > Per80 && ach <= Per85) {
                            var EScore = Per60;
                            $('#logScoresubkra' + index).text(Per60);

                        } else if (ach > Per85 && ach <= Per90) {
                            var EScore = Per90;
                            $('#logScoresubkra' + index).text(Per90);

                        } else if (ach > Per90 && ach <= Per95) {
                            var EScore = target;
                            $('#logScoresubkra' + index).text(target);

                        } else if (ach >= Per96) {
                            var EScore = Per110;
                            $('#logScoresubkra' + index).text(Per110);

                        } else {
                            var EScore = 0;
                            $('#logScoresubkra' + index).text('0');

                        }
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update only the respective row's score cell
                                                


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
                            var Per40=Math.round(((target*40)/100)*100)/100; 
                            var Per60 = Math.round((target - Per40) * 100) / 100;
                            var Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                            var Per90 = Math.round((target - Per10) * 100) / 100;
                            
                            var EScore = 0;
                            if (ach < Per96) {
                                EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            } else if (ach >= Per96 && ach < Per97) {
                                EScore = Per50;
                                $('#logScoresubkra' + index).text(Per50);

                            } else if (ach >= Per97 && ach < Per98) {
                                EScore = Per60;
                                $('#logScoresubkra' + index).text(Per60);

                            } else if (ach >= Per98 && ach < Per99) {
                                EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                            } else if (ach >= Per99) {
                                EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            }
                            
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore();

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
                                $('#logScoresubkra' + index).text('0');

                            } else if (ach >= Per97 && ach < Per98) {
                                EScore = Per70;
                                $('#logScoresubkra' + index).text(Per70);

                            } else if (ach >= Per98 && ach < Per99) {
                                EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                            } else if (ach >= Per99 && ach < Per995) {
                                EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else if (ach >= Per995) {
                                EScore = Per110;
                                $('#logScoresubkra' + index).text(Per110);

                            }
                            
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore();

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
                                $('#logScoresubkra' + index).text('0');

                            } else if (ach >= Per96 && ach < Per97) {
                                EScore = Per60;
                                $('#logScoresubkra' + index).text(Per60);

                            } else if (ach >= Per97 && ach < Per98) {
                                EScore = Per80;
                                $('#logScoresubkra' + index).text(Per80);

                            } else if (ach >= Per98 && ach < Per99) {
                                EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            } else if (ach >= Per99) {
                                EScore = Per110;
                                $('#logScoresubkra' + index).text(Per110);
                            }
                            
                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore();
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
                                $('#logScoresubkra' + index).text(Per110);

                            }
                            else if (ach > Per94 && ach <= Per99) { 
                                var EScore = Per105; 
                                $('#logScoresubkra' + index).text(Per105);

                            }
                        
                            else if (ach > Per99 && ach <= Per105) { 
                                var EScore = target; 
                                $('#logScoresubkra' + index).text(target);

                            }
                            else if (ach > Per105 && ach <= Per110) {
                                var EScore = Per95; 
                                $('#logScoresubkra' + index).text(Per95);

                            }
                            else if (ach > Per110) { 
                                var EScore = Per90; 
                                $('#logScoresubkra' + index).text(Per90);

                            }
                            else {
                                var EScore = 0; 
                                $('#logScoresubkra' + index).text('0');

                                }

                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update the score for this row
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
                                $('#logScoresubkra' + index).text(target);

                            }
                            else if (ach > Per15 && ach <= Per22) {
                                var EScore = Per90;
                                $('#logScoresubkra' + index).text(Per90);

                                }
                            else if (ach > Per22 && ach <= Per29) { 
                                var EScore = Per80; 
                                $('#logScoresubkra' + index).text(Per80);

                            }
                            else if (ach > Per29 && ach <= Per36) {
                                var EScore = Per75; 
                                $('#logScoresubkra' + index).text(Per75);

                                }
                            else if (ach > Per36 && ach <= Per42) { 
                                var EScore = Per50; 
                                $('#logScoresubkra' + index).text(Per50);


                            }
                            else if (ach > Per42) { 
                                var EScore = 0; 
                                $('#logScoresubkra' + index).text('0');

                            }
                            else { var EScore = 0; 
                                $('#logScoresubkra' + index).text('0');

                            }

                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update the score for this row
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
                                $('#logScoresubkra' + index).text('0');

                            }
                            else if (ach >= Per60 && ach <= Per69) { 
                                var EScore = Per25; 
                                $('#logScoresubkra' + index).text(Per25);

                            }
                            else if (ach > Per69 && ach <= Per79) { 
                                var EScore = Per50;
                                $('#logScoresubkra' + index).text(Per50);

                            }
                            else if (ach > Per79 && ach <= Per120) { 
                                var EScore = target;
                                $('#logScoresubkra' + index).text(target);

                            }
                            else { 
                                var EScore = 0; 
                                $('#logScoresubkra' + index).text('0');

                            }

                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update the score for this row
                        }
                        else if (logic === 'Logic19') {
                            var Per70 = Math.round(((target * 70) / 100) * 100) / 100;
                            var Per80 = Math.round(((target * 80) / 100) * 100) / 100;
                            var Per50 = Math.round(((target * 50) / 100) * 100) / 100;

                            if (ach < Per70) { 
                                var EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }
                            else if (ach >= Per70 && ach <= Per80) { 
                                var EScore = Per50; 
                                $('#logScoresubkra' + index).text(Per50);

                            }
                            else if (ach > Per80 && ach <= target) { 
                                var EScore = target; 
                                $('#logScoresubkra' + index).text(target);

                            }
                            else { 
                                var EScore = 0;
                                $('#logScoresubkra' + index).text('0');

                            }

                            var MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                            $('#subkrascore' + index).val(MScore.toFixed(2));updategrandscore(); // Update the score for this row
                        
                        }

                });
                //formb 
                $(document).on('input', '.self-remark-formb', function() {
                    let selfremark =$(this).val()|| ''; // Get the self-rating value, default to 0 if empty
                    console.log(selfremark);
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute

                    $('#self-remark-formb' + index).text(selfremark); // Update only the respective row's score cell
                });
                // Real-time calculation function for score
                $(document).on('input', '.self-rating-formb', function() {
                    let selfRating = parseFloat($(this).val()) || 0; // Get the self-rating value, default to 0 if empty
                    let target = parseFloat($(this).data('target')) || 0; // Get the target value from data attribute
                    let logic = $(this).data('logic') || ''; // Get the target value from data attribute
                    let weight = parseFloat($(this).data('weight')) || 0; // Get the target value from data attribute
                    let index = parseFloat($(this).data('index')) || 0; // Get the target value from data attribute
                    var ach=Math.round(((target*selfRating)/100)*100)/100; //var ach=parseFloat(v);  
                    $('#self-rating-formb' + index).text(selfRating); // Update only the respective row's score cell

                    if (logic === 'Logic1') {
                        // Calculate Per50, Per150, and the final EScore based on the provided logic
                        var Per50 = Math.round(((target * 20) / 100) * 100) / 100; // 20% of the target
                        var Per150 = Math.round((target + Per50) * 100) / 100; // target + 20% of target
                        if (ach <= Per150) {
                            var EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            var EScore = Per150;
                            $('#logscoreformb' + index).text(Per150); // Update only the respective row's score cell
                        }
                        var MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore based on EScore, target, and weight
                        
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    } 
                    else if (logic === 'Logic2') {
                        let EScore;
                        if (ach <= target) {
                            EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        } else {
                            EScore = target;
                            $('#logscoreformb' + index).text(target); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        


                    }
                    else if (logic === 'Logic2a') {
                        let Per10 = Math.round(((target * 10) / 100) * 100) / 100;
                        let Per110 = Math.round((target + Per10) * 100) / 100;
                        let EScore;
                        if (ach >= Per110) {
                            EScore = Per110;
                            $('#logscoreformb' + index).text(Per110); // Update only the respective row's score cell

                        } else {
                            EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic3') {
                        let EScore;
                            if (ach === target) {
                                EScore = ach;
                                $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                            } else {
                                EScore = 0;
                                $('#logscoreformb' + index).text('0'); // Update only the respective row's score cell

                            }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                
                    if (logic === 'Logic4') {
                        // Logic4: If achievement is >= target, score is the target. If achievement < target, score is 0
                        let EScore;
                        if (ach >= target) {
                            EScore = target;
                            $('#logscoreformb' + index).text(target); // Update only the respective row's score cell

                        } else {
                            EScore = 0;
                            $('#logscoreformb' + index).text('0'); // Update only the respective row's score cell

                        }

                        MScore = Math.round(((EScore / target) * weight) * 100) / 100; // Calculate MScore using EScore
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }
                    else if (logic === 'Logic5') {
                        let Per30 = Math.round(((target * 30) / 100) * 100) / 100;
                        let Per70 = Math.round((target - Per30) * 100) / 100;
                        let EScore = 0;
                        if (ach >= Per70 && ach < target) {
                            EScore = ach;
                            $('#logscoreformb' + index).text(ach); // Update only the respective row's score cell

                        } else if (ach >= target) {
                            EScore = target;
                            $('#logscoreformb' + index).text(target); // Update only the respective row's score cell

                        }
                        else{
                            EScore = 0;
                            $('#logscoreformb' + index).text('0'); // Update only the respective row's score cell

                        }
                        MScore = Math.round(((EScore / target) * weight) * 100) / 100;
                        $('#score-formb' + index).text(MScore.toFixed(2)); // Update only the respective row's score cell
                        

                    }

               
                });
                function saveRowData(index, tgtId, saveType) {
                        $('#loader').show(); // Show loader while saving
                        let selfRemark = $('#selfremark' + index).val();
                        
                        // Check if selfRemark is empty
                        if (!selfRemark) {
                            // Add red border to indicate it's mandatory
                            $('#selfremark' + index).css('border', '2px solid red');
                                                        
                            // Hide the loader and return early
                            $('#loader').hide();
                            return;
                        } else {
                            // Remove red border if it was previously added
                            $('#selfremark' + index).css('border', '');
                        }

                        // Collect data from the row
                        let requestData = {
                            logscore: $('#logscore' + index).text(),
                            tgtDefId: $('#tgt-id-' + index).val(),
                            selfRating: $('#selfrating' + index).val(),
                            selfRemark: $('#selfremark' + index).val(),
                            score: $('#score' + index).text(),
                            saveType: saveType,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                        };

                        console.log("Saving data:", requestData); // Debugging

                        $.ajax({
                            url: '/save-kra-row', // Laravel route
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
                function saveRowDataforma(index, tgtId, saveType) {
                        $('#loader').show(); // Show loader while saving
                        let selfRemark = $('#selfremarkforma' + index).val();
                        
                        // Check if selfRemark is empty
                        if (!selfRemark) {
                            // Add red border to indicate it's mandatory
                            $('#selfremarkforma' + index).css('border', '2px solid red');
                                                        
                            // Hide the loader and return early
                            $('#loader').hide();
                            return;
                        } else {
                            // Remove red border if it was previously added
                            $('#selfremarkforma' + index).css('border', '');
                        }

                        // Collect data from the row
                        let requestData = {
                            logscore: $('#logscoreforma' + index).text(),
                            tgtDefId: $('#tgt-id-' + index).val(),
                            selfRating: $('#selfratingforma' + index).val(),
                            selfRemark: $('#selfremarkforma' + index).val(),
                            score: $('#scoreforma' + index).text(),
                            saveType: saveType,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                        };

                        console.log("Saving data:", requestData); // Debugging

                        $.ajax({
                            url: '/save-kra-row', // Laravel route
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

                function saveRowDataFormb(index, tgtId, saveType) {
                        $('#loader').show(); // Show loader while saving
                        let selfRemark = $('#selfremarkformb' + index).val();
    
                        // Check if selfRemark is empty
                        if (!selfRemark) {
                            // Add red border to indicate it's mandatory
                            $('#selfremarkformb' + index).css('border', '2px solid red');
                                                        
                            // Hide the loader and return early
                            $('#loader').hide();
                            return;
                        } else {
                            // Remove red border if it was previously added
                            $('#selfremarkformb' + index).css('border', '');
                        }

                        // Collect data from the row
                        let requestData = {
                            logscore: $('#logscoreformb' + index).text(),
                            tgtDefId: $('#tgt-id-formb-' + index).val(),
                            selfRating: $('#self-rating-formb' + index).val(),
                            selfRemark: $('#selfremarkformb' + index).val(),
                            score: $('#score-formb' + index).text(),
                            saveType: saveType,
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token for Laravel
                        };

                        console.log("Saving data:", requestData); // Debugging

                        $.ajax({
                            url: '/save-kra-row-formb', // Laravel route
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
                                        setTimeout(function () {
                                            location.reload();
                                        }, 3000); // Reload after 3 seconds to allow the user to see the message
                                    }
                                    
                                    else if (saveType === 'submit') {
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

                    function addSubKRA(kraId) {
                        let existingTable = document.getElementById(`subKraTable_${kraId}`);
                        
                        // Debugging: Check if table already exists
                        console.log("Checking if table exists:", existingTable);
                        
                        // If table doesn't exist, create it dynamically
                        if (!existingTable) {
                            let kraRow = document.getElementById(`kraRow_${kraId}`); // Find the main KRA row
                            
                            // Debugging: Check if main KRA row exists
                            if (!kraRow) {
                                console.error(`KRA Row with ID 'kraRow_${kraId}' not found.`);
                                return;
                            }
                            
                            // Debugging: Indicate that a new table is being created
                            console.log("Creating new subKRA table for KRA ID:", kraId);

                            // Create a new row for the Sub-KRA table
                            kraRow.insertAdjacentHTML("afterend", `
                                <tr id="subKraRow_${kraId}">
                                    <td colspan="10">
                                        <table class="table" id="subKraTable_${kraId}" style="background-color:#ECECEC; margin-left:7px;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>SN.</th>
                                                    <th>Sub KRA/Goals</th>
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
                                            <tbody></tbody>
                                        </table>
                                    </td>
                                </tr>
                            `);

                            existingTable = document.getElementById(`subKraTable_${kraId}`);
                            
                            // Debugging: Confirm that the new table has been created
                            console.log("New table created:", existingTable);
                        }

                        let tbody = existingTable.querySelector("tbody");
                        let rowCount = tbody.rows.length;
                    // Create a new row element
                    let newRow = document.createElement('tr');
                    newRow.style.backgroundColor = "#ECECEC";

                    newRow.innerHTML = `
                        <td></td>
                        <td id="snotohide"><b>${rowCount + 1}.</b></td>
                        <td>
                            <textarea name="subKraName[${kraId}][]" required class="form-control" placeholder="Enter sub KRA" rows="2" style="width:250px;min-height:70px; overflow:hidden; resize:none;min-height:60px;" 
                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea>
                        </td>
                        <td>
                            <textarea name="subKraDesc[${kraId}][]" required class="form-control" placeholder="Enter description" rows="2" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="600"></textarea>
                        </td>
                        <td>
                            <select name="Measure_subKRA[${kraId}][]" required>
                                
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
                            <select name="Unit_subKRA[${kraId}][]" style="width:75px;" required>
                                
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
                        <td><input type="number" name="Weightage_subKRA[${kraId}][]" required class="form-control" placeholder="Enter weightage" style="width: 69px;" ></td>
                        <td>
                            <select name="Logic_subKRA[${kraId}][]" style="width:75px;" required>
                                
                                        @foreach($logicData as $logic)
                                    <option value="{{ $logic->logicMn }}">
                                        {{ $logic->logicMn }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="Period_subKRA[${kraId}][]" style="width:90px;" required>
                                
                                <option value="Annual">Annually</option>
                                <option value="1/2 Annual">Half Yearly</option>
                                <option value="Quarter">Quarterly</option>
                                <option value="Monthly" selected>Monthly</option>
                            </select>
                        </td>
                        <td><input type="number" name="Target_subKRA[${kraId}][]" value="100" class="form-control" placeholder="Enter target" required style="width:60px;" min="0"></td>
                        <td><button type="button" class="ri-close-circle-fill border-0" onclick="removeSubKRA(this)"></button></td>
                    `;

                    // Append the row to the tbody
                    tbody.appendChild(newRow);

                    // Debugging: Log new row added
                    console.log("New row added:", newRow);
                    }

                function addSubKRANew(kraId) {
                    // Find the existing Sub-KRA table for the given KRA ID
                    let existingTable = document.getElementById(`subKraTable_New${kraId}`);

                    // If the Sub-KRA table doesn't exist, create it
                    if (!existingTable) {
                        let kraRow = document.getElementById(`kraRow_New${kraId}`);
                        if (!kraRow) {
                            console.error(`KRA Row with ID 'kraRow_New${kraId}' not found.`);
                            return;
                        }

                        // Create the Sub-KRA table structure and append it below the KRA row
                        kraRow.insertAdjacentHTML("afterend", `
                            <tr>
                                <td colspan="10">
                                    <table class="table" id="subKraTable_New${kraId}" style="background-color:#ECECEC; margin-left:7px;">
                                        <thead>
                                            <tr>
                                                <th></th>
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
                                        <tbody></tbody>
                                    </table>
                                </td>
                            </tr>
                        `);
                        // Re-fetch the table after creation
                        existingTable = document.getElementById(`subKraTable_New${kraId}`);
                    }

                    // Now insert the new row in the existing Sub-KRA table
                    let tbody = existingTable.querySelector("tbody");
                    let rowCount = tbody.rows.length;  // Get the current row count for Sub-KRAs

                    // Insert the new row for the Sub-KRA
                    let newRow = tbody.insertRow();
                    newRow.style.backgroundColor = "#ECECEC";

                    // Populate the new row
                    newRow.innerHTML = `
                        <td></td>
                        <td><b>${rowCount + 1}.</b></td>
                        <input type="hidden" name="subKraId[${kraId}][]" value="newSubKraId">
                        
                        <td>
                            <textarea required="" name="subKraName[${kraId}][]" class="form-control" placeholder="Enter sub KRA" rows="2" maxlength="350" style="width:250px;min-height:70px; overflow:hidden; resize:none;" oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" maxlength="350"></textarea>
                        </td>

                        <td>
                            <textarea name="subKraDesc[${kraId}][]" class="form-control" placeholder="Enter sub KRA description" rows="2" maxlength="600" style="width:300px; overflow:hidden; resize:none;" oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required="" maxlength="600"></textarea>
                        </td>

                        <td>
                            <select name="Measure_subKRA[${kraId}][]" required="">
                                
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
                            <select name="Unit_subKRA[${kraId}][]" style="width:75px;" required="">
                                    
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

                        <td>
                            <input type="number" name="Weightage_subKRA[${kraId}][]" placeholder="Enter weightage" style="width:78px;" required="">
                        </td>

                        <td>
                            <select name="Logic_subKRA[${kraId}][]" style="width:75px;" required="">
                                
                            @foreach($logicData as $logic)
                                    <option value="{{ $logic->logicMn }}">
                                        {{ $logic->logicMn }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td>
                            <select name="Period_subKRA[${kraId}][]" style="width:90px;" required="">
                                
                                <option value="Annual">Annually</option>
                                <option value="1/2 Annual">Half Yearly</option>
                                <option value="Quarter">Quarterly</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" name="Target_subKRA[${kraId}][]" placeholder="Enter target" required="" value="100" style="width:60px;" min="0">
                        </td>

                        <td>
                            <button type="button" class="ri-close-circle-fill border-0" onclick="removeSubKRA(this)"></button>
                        </td>
                    `;
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
                        let snohide = row.querySelector('td#snotohide'); // Find the td with id="snotohide"
            
                        if (snohide) {
                            snohide.style.display = 'none'; // Hide the td with id="snotohide"
                        }
                        let serialCell = row.querySelector('td:first-child'); // Assuming the serial number is in the first cell
                        if (serialCell) {
                            serialCell.textContent = index + 1; // Update serial number (index + 1 for 1-based index)
                        }
                    });
                }

                $(document).on('click', '.deleteSubKra', function(event) {
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
                                location.reload(); // Refresh the page after deletion
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

            
                document.addEventListener('DOMContentLoaded', function() {
                    document.body.addEventListener('click', function(e) {
                                // Check if the clicked element is the 'addKraBtnedit' button
                                if (e.target && e.target.id === 'addKraBtnedit') {
                                    e.preventDefault();
                                    document.getElementById('editForm').style.display = 'block';
                                    document.getElementById('oldkraedit').style.display = 'inline-block';
                                    document.getElementById('addKraBtnedit').style.display = 'none';

                                }
                                if (e.target && e.target.id === 'addKraBtneditNew') {
                                    e.preventDefault();
                                    document.getElementById('viewFormNew').style.display = 'none';
                                    document.getElementById('editFormNew').style.display = 'block';
                                    document.getElementById('addKraBtneditNew').style.display = 'none';


                                }


                        // Check if the clicked element is the 'kraedit' button
                        if (e.target && e.target.matches('.kraedit')) {
                            e.preventDefault();
                            document.getElementById('viewForm').style.display = 'none';
                            document.getElementById('editForm').style.display = 'block';
                            document.getElementById('finalSubmitLi').style.display = 'inline-block'; 
                            document.getElementById('EditBtnCurr').style.display = 'none'; 
                            document.getElementById('oldkraeditli').style.display = 'inline-block';
                            document.getElementById('saveDraftBtnCurr').style.display = 'inline-block';
                        }
                        // Check if the clicked element is the 'kraedit' button
                        if (e.target && e.target.matches('.kraeditNew')) {
                            e.preventDefault();
                            document.getElementById('viewFormNew').style.display = 'none';
                            document.getElementById('editFormNew').style.display = 'block';
                            document.getElementById('EditBtnCurrNew').style.display = 'none'; 
                            document.getElementById('finalSubmitLiNew').style.display = 'inline-block'; 
                            document.getElementById('oldkraeditnewli').style.display = 'inline-block';
                            document.getElementById('saveDraftBtnNew').style.display = 'inline-block';
                        }
                    });
                });


                // Function to remove the row
                function removeRow(kraId) {
                    document.getElementById(kraId).remove();
                }

                $(document).on('click', '.deleteKra', function(event) {
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
                                            location.reload(); // Refresh the page after deletion
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
                        // Function to fetch old KRA data and populate the table

                        function fetchOldKRAData(yearId) {
                            $.ajax({
                                url: '{{ route('fetch_old_kra') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    old_year: yearId
                                },
                                success: function(response) {
                                    if (response.success) {
                                        console.log(response);
                                        // Show the old KRA box
                                        $('#oldkrabox').show();

                                        var kraData = response.data;
                                                    var subkraData = response.sub_kradata;

                                                    console.log(kraData);
                                                    var tableBody = $('#kraTableBody');
                                                    tableBody.empty(); // Clear any existing rows

                                                    kraData.forEach(function (kra, index) {
                                                    var kraId = kra.KRAId; // Unique ID for KRA
                                                    var row = `
                                                        <tr id="kraRow_${kraId}">
                                                            <td><input type="checkbox" class="kra-checkbox" 
                                                                data-kra="${kra.KRA}" data-description="${kra.KRA_Description}" 
                                                                data-measure="${kra.Measure}" data-unit="${kra.Unit}" 
                                                                data-weightage="${kra.Weightage}" data-logic="${kra.Logic}" 
                                                                data-period="${kra.Period}" data-target="${kra.Target}" 
                                                                data-row-id="${kraId}">
                                                            </td>
                                                            <td><b>${index + 1}.</b></td>
                                                            <td>${kra.KRA}</td>
                                                            <td>${kra.KRA_Description}</td>
                                                            <td>${kra.Measure}</td>
                                                            <td>${kra.Unit}</td>
                                                            <td>${kra.Weightage}</td>
                                                            <td>${kra.Logic}</td>
                                                            <td>${kra.Period}</td>
                                                            <td>${kra.Target}</td>
                                                        </tr>`;

                                                    tableBody.append(row);

                                                    // Find and display corresponding Sub-KRAs
                                                    var subKras = subkraData.filter(sub => sub.KRAId === kraId);
                                                    subKras.forEach((sub, subIndex) => {
                                                        var subRow = `
                                                            <tr class="subKraRow" data-parent="${kraId}" style="background-color: #f8f9fa;">
                                                                <td></td> <!-- Empty to align under KRA -->
                                                                <td>${subIndex + 1}</td>
                                                                <td>${sub.KRA}</td>
                                                                <td>${sub.KRA_Description}</td>
                                                                <td>${sub.Measure}</td>
                                                                <td>${sub.Unit}</td>
                                                                <td>${sub.Weightage}</td>
                                                                <td>${sub.Logic}</td>
                                                                <td>${sub.Period}</td>
                                                                <td>${sub.Target}</td>
                                                            </tr>`;
                                                        tableBody.append(subRow);
                                                    });
                                        });
                                        $('.kra-checkbox').change(function() {
                                            var row = $(this).closest('tr'); // Get the parent row of the checkbox
                                            
                                            // Get necessary data
                                            var kraId = $(this).data('row-id'); // Use the custom data attribute for the row ID
                                            var kra = $(this).data('kra');
                                            var description = $(this).data('description');
                                            var measure = $(this).data('measure');
                                            var unit = $(this).data('unit');
                                            var weightage = $(this).data('weightage');
                                            var logic = $(this).data('logic');
                                            var period = $(this).data('period');
                                            var target = $(this).data('target');
                                            
                                            var rowCount = $('#mainKraBody tr[id^="kraRow_"]').length + 1; // Count existing rows and get the next serial number

                                            // Find the first empty row to populate
                                            var emptyRow = $('#mainKraBody tr[id^="kraRow_"]').filter(function() {
                                                return $(this).find('textarea').toArray().every(function(input) {
                                                    return $(input).val() === ""; // Check if all form elements are empty
                                                });
                                            }).first(); // Get the first empty row (if exists)
                                            
                                            // If checkbox is checked, create and append a new row
                                            if ($(this).is(':checked')) {
                                                if (emptyRow.length > 0) {
                                                    // If an empty row exists, populate the empty row with the data
                                                    emptyRow.find('textarea[name="kra[]"]').val(kra);
                                                    emptyRow.find('textarea[name="kra_description[]"]').val(description);
                                                    emptyRow.find('select[name="Measure[]"]').val(measure);
                                                    emptyRow.find('select[name="Unit[]"]').val(unit);
                                                    emptyRow.find('input[name="weightage[]"]').val(weightage);
                                                    emptyRow.find('select[name="Logic[]"]').val(logic);
                                                    emptyRow.find('select[name="Period[]"]').val(period);
                                                    emptyRow.find('input[name="Target[]"]').val(target);
                                                    emptyRow.attr('id', `kraRow_${kraId}`);

                                                    $("#mainKraBody tr[id^='kraRow_']").each(function(index) {
                                                        $(this).find("td:first b").text(index + 1); // The serial number starts from 1
                                                    });
                                                }
                                                else {
                                                    var newRow = `
                                                        <tr id="kraRow_${kraId}">
                                                            <td><b>${rowCount}.</b></td>
                                                            <td><textarea name="kra[]" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required maxlength="350">${kra}</textarea></td>
                                                            <td><textarea name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required maxlength="600">${description}</textarea></td>
                                                            <td><select name="Measure[]" required>
                                                                <option value="Process" ${measure === 'Process' ? 'selected' : ''}>Process</option>
                                                                <option value="Acreage" ${measure === 'Acreage' ? 'selected' : ''}>Acreage</option>
                                                                <option value="Event" ${measure === 'Event' ? 'selected' : ''}>Event</option>
                                                                <option value="Program" ${measure === 'Program' ? 'selected' : ''}>Program</option>
                                                                <option value="Maintenance" ${measure === 'Maintenance' ? 'selected' : ''}>Maintenance</option>
                                                                <option value="Time" ${measure === 'Time' ? 'selected' : ''}>Time</option>
                                                                <option value="Yield" ${measure === 'Yield' ? 'selected' : ''}>Yield</option>
                                                                <option value="Value" ${measure === 'Value' ? 'selected' : ''}>Value</option>
                                                                <option value="Volume" ${measure === 'Volume' ? 'selected' : ''}>Volume</option>
                                                                <option value="Quantity" ${measure === 'Quantity' ? 'selected' : ''}>Quantity</option>
                                                                <option value="Quality" ${measure === 'Quality' ? 'selected' : ''}>Quality</option>
                                                                <option value="Area" ${measure === 'Area' ? 'selected' : ''}>Area</option>
                                                                <option value="Amount" ${measure === 'Amount' ? 'selected' : ''}>Amount</option>
                                                                <option value="None" ${measure === 'None' ? 'selected' : ''}>None</option>
                                                            </select></td>
                                                            <td><select name="Unit[]" class="Inputa" style="width:75px;" required>
                                                                <option value="%" ${unit === '%' ? 'selected' : ''}>%</option>
                                                                <option value="Acres" ${unit === 'Acres' ? 'selected' : ''}>Acres</option>
                                                                <option value="Days" ${unit === 'Days' ? 'selected' : ''}>Days</option>
                                                                <option value="Month" ${unit === 'Month' ? 'selected' : ''}>Month</option>
                                                                <option value="Hours" ${unit === 'Hours' ? 'selected' : ''}>Hours</option>
                                                                <option value="Kg" ${unit === 'Kg' ? 'selected' : ''}>Kg</option>
                                                                <option value="Ton" ${unit === 'Ton' ? 'selected' : ''}>Ton</option>
                                                                <option value="MT" ${unit === 'MT' ? 'selected' : ''}>MT</option>
                                                                <option value="Kg/Acre" ${unit === 'Kg/Acre' ? 'selected' : ''}>Kg/Acre</option>
                                                                <option value="Number" ${unit === 'Number' ? 'selected' : ''}>Number</option>
                                                                <option value="Lakhs" ${unit === 'Lakhs' ? 'selected' : ''}>Lakhs</option>
                                                                <option value="Rs." ${unit === 'Rs.' ? 'selected' : ''}>Rs.</option>
                                                                <option value="INR" ${unit === 'INR' ? 'selected' : ''}>INR</option>
                                                                <option value="None" ${unit === 'None' ? 'selected' : ''}>None</option>
                                                            </select></td>
                                                            <td><input type="number" name="weightage[]" class="Inputa" value="${weightage}" placeholder="Enter weightage" style="width: 69px;" required></td>
                                                            <td><select name="Logic[]" class="Inputa" style="width:75px;" required>
                                                                @foreach($logicData as $logic)
                                                                    <option value="{{ $logic->logicMn }}">
                                                                        {{ $logic->logicMn }}
                                                                    </option>
                                                                @endforeach
                                                            </select></td>
                                                            <td><select name="Period[]" class="Inputa" style="width:90px;" required>
                                                                <option value="Annual" ${period === 'Annual' ? 'selected' : ''}>Annually</option>
                                                                <option value="1/2 Annual" ${period === '1/2 Annual' ? 'selected' : ''}>Half Yearly</option>
                                                                <option value="Quarter" ${period === 'Quarter' ? 'selected' : ''}>Quarterly</option>
                                                                <option value="Monthly" ${period === 'Monthly' ? 'selected' : ''}>Monthly</option>
                                                            </select></td>
                                                            <td><input type="number" value="100" name="Target[]" class="Inputa" value="${target}" required placeholder="Enter target" style="width:60px;"></td>
                                                            <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtnOldkracopy"></button></td>
                                                        </tr>
                                                    `;
                                                    
                                                    // Append the new row to the table body
                                                    $('#mainKraBody').append(newRow);
                                                }

                                                $(document).on("click", ".removeKraBtnOldkracopy", function() {
                                                    var row = $(this).closest("tr"); // Get the parent row of the remove button
                                                    row.remove(); // Remove the current row

                                                    // Count the number of remaining rows with id starting with kraRow_
                                                    $("#mainKraBody tr[id^='kraRow_']").each(function(index) {
                                                        $(this).find("td:first b").text(index + 1); // The serial number starts from 1
                                                    });
                                                });
                                            }
                                            else {
                                                // Unchecked: Find and clear the row where both KRA and KRA_Description match
                                                var matchingRow = $('#mainKraBody tr').filter(function() {
                                                    // Check if the KRA and KRA Description match
                                                    var kraValue = $(this).find('textarea[name="kra[]"]').val();
                                                    var descriptionValue = $(this).find('textarea[name="kra_description[]"]').val();
                                                    return kraValue === kra && descriptionValue === description;
                                                });

                                                // If matching row found, clear the input fields
                                                matchingRow.find('textarea, select, input').val('');
                                            }
                                        });

                                    

                                    } else {
                                        alert('Error: ' + response.message);
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                    alert('There was an error fetching the data.');
                                }
                            });
                        }


                        // Function to fetch old KRA data and populate the table
                        
                        function fetchOldKRADataNew(yearId) {
                                        $.ajax({
                                            url: '{{ route('fetch_old_kra') }}',
                                            method: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                old_year: yearId
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    console.log(response);
                                                    // Show the old KRA box
                                                    $('#oldkrabox').show();

                                                    // Populate the table with the fetched data
                                                    var kraData = response.data;
                                                    var subkraData = response.sub_kradata;

                                                    console.log(kraData); // Debugging: Log the received data

                                                    var tableBody = $('#kraTableBodyNew');
                                                    tableBody.empty(); // Clear any existing rows before appending new ones

                                                    kraData.forEach(function (kra, index) {
                                                        var kraId = kra.KRAId; // Unique ID for KRA
                                                        
                                                        // Find the related Sub-KRAs from `subkraData`
                                                        var subKras = subkraData.filter(sub => sub.KRAId === kraId);

                                                        // Convert Sub-KRAs to a JSON string and store in data attribute
                                                        var subKraJson = JSON.stringify(subKras);

                                                        var row = `
                                                            <tr id="kraRow_${kraId}">
                                                                <td>
                                                                    <input type="checkbox" class="kra-checkbox" 
                                                                        data-kra="${kra.KRA}" data-description="${kra.KRA_Description}" 
                                                                        data-measure="${kra.Measure}" data-unit="${kra.Unit}" 
                                                                        data-weightage="${kra.Weightage}" data-logic="${kra.Logic}" 
                                                                        data-period="${kra.Period}" data-target="${kra.Target}" 
                                                                        data-row-id="${kraId}" data-subkra='${subKraJson}'> 
                                                                </td>
                                                                <td><b>${index + 1}.</b></td>
                                                                <td>${kra.KRA}</td>
                                                                <td>${kra.KRA_Description}</td>
                                                                <td>${kra.Measure}</td>
                                                                <td>${kra.Unit}</td>
                                                                <td>${kra.Weightage}</td>
                                                                <td>${kra.Logic}</td>
                                                                <td>${kra.Period}</td>
                                                                <td>${kra.Target}</td>
                                                            </tr>
                                                        `;

                                                        tableBody.append(row);

                                                        // Append Sub-KRAs directly after their corresponding KRA row
                                                        subKras.forEach((sub, subIndex) => {
                                                            var subRow = `
                                                                <tr class="subKraRow" data-parent="${kraId}" style="background-color: #f8f9fa;">
                                                                    <td></td> <!-- Empty cell to align under KRA -->
                                                                    <td>${subIndex + 1}</td>
                                                                    <td>${sub.KRA}</td>
                                                                    <td>${sub.KRA_Description}</td>
                                                                    <td>${sub.Measure}</td>
                                                                    <td>${sub.Unit}</td>
                                                                    <td>${sub.Weightage}</td>
                                                                    <td>${sub.Logic}</td>
                                                                    <td>${sub.Period}</td>
                                                                    <td>${sub.Target}</td>
                                                                </tr>
                                                            `;
                                                            tableBody.append(subRow);
                                                    });
                                                });


                                                    $('.kra-checkbox').change(function() {
                                                            var row = $(this).closest('tr'); // Get the parent row of the checkbox
                                                            
                                                            // Get necessary data
                                                            var kraId = $(this).data('row-id'); // Use the custom data attribute for the row ID
                                                            var kra = $(this).data('kra');
                                                            var description = $(this).data('description');
                                                            var measure = $(this).data('measure');
                                                            var unit = $(this).data('unit');
                                                            var weightage = $(this).data('weightage');
                                                            var logic = $(this).data('logic');
                                                            var period = $(this).data('period');
                                                            var target = $(this).data('target');
                                                            
                                                            var rowCount = $('#mainKraBodyNew tr[id^="kraRow_New"]').length + 1; // Count existing rows and get the next serial number

                                                            // Find the first empty row to populate
                                                            var emptyRow = $('#mainKraBodyNew tr[id^="kraRow_New"]').filter(function() {
                                                                return $(this).find('textarea').toArray().every(function(input) {
                                                                    return $(input).val() === ""; // Check if all form elements are empty
                                                                });
                                                            }).first(); // Get the first empty row (if exists)
                                                            
                                                            // If checkbox is checked, create and append a new row
                                                            if ($(this).is(':checked')) {
                                                                if (emptyRow.length > 0) {
                                                                    // If an empty row exists, populate the empty row with the data
                                                                    emptyRow.find('textarea[name="kra[]"]').val(kra);
                                                                    emptyRow.find('textarea[name="kra_description[]"]').val(description);
                                                                    emptyRow.find('select[name="Measure[]"]').val(measure);
                                                                    emptyRow.find('select[name="Unit[]"]').val(unit);
                                                                    emptyRow.find('input[name="weightage[]"]').val(weightage);
                                                                    emptyRow.find('select[name="Logic[]"]').val(logic);
                                                                    emptyRow.find('select[name="Period[]"]').val(period);
                                                                    emptyRow.find('input[name="Target[]"]').val(target);
                                                                    emptyRow.attr('id', `kraRow_New${kraId}`);

                                                                    $("#mainKraBodyNew tr[id^='kraRow_New']").each(function(index) {
                                                                        $(this).find("td:first b").text(index + 1); // The serial number starts from 1
                                                                    });
                                                                }
                                                                else {
                                                                    var newRow = `
                                                                        <tr id="kraRow_New${kraId}">
                                                                            <td><b>${rowCount}.</b></td>
                                                                            <td><textarea name="kra[]" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required maxlength="350">${kra}</textarea></td>
                                                                            <td><textarea name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                                oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required maxlength="600">${description}</textarea></td>
                                                                            <td><select name="Measure[]" required>
                                                                                <option value="Process" ${measure === 'Process' ? 'selected' : ''}>Process</option>
                                                                                <option value="Acreage" ${measure === 'Acreage' ? 'selected' : ''}>Acreage</option>
                                                                                <option value="Event" ${measure === 'Event' ? 'selected' : ''}>Event</option>
                                                                                <option value="Program" ${measure === 'Program' ? 'selected' : ''}>Program</option>
                                                                                <option value="Maintenance" ${measure === 'Maintenance' ? 'selected' : ''}>Maintenance</option>
                                                                                <option value="Time" ${measure === 'Time' ? 'selected' : ''}>Time</option>
                                                                                <option value="Yield" ${measure === 'Yield' ? 'selected' : ''}>Yield</option>
                                                                                <option value="Value" ${measure === 'Value' ? 'selected' : ''}>Value</option>
                                                                                <option value="Volume" ${measure === 'Volume' ? 'selected' : ''}>Volume</option>
                                                                                <option value="Quantity" ${measure === 'Quantity' ? 'selected' : ''}>Quantity</option>
                                                                                <option value="Quality" ${measure === 'Quality' ? 'selected' : ''}>Quality</option>
                                                                                <option value="Area" ${measure === 'Area' ? 'selected' : ''}>Area</option>
                                                                                <option value="Amount" ${measure === 'Amount' ? 'selected' : ''}>Amount</option>
                                                                                <option value="None" ${measure === 'None' ? 'selected' : ''}>None</option>
                                                                            </select></td>
                                                                            <td><select name="Unit[]" class="Inputa" style="width:75px;" required>
                                                                                <option value="%" ${unit === '%' ? 'selected' : ''}>%</option>
                                                                                <option value="Acres" ${unit === 'Acres' ? 'selected' : ''}>Acres</option>
                                                                                <option value="Days" ${unit === 'Days' ? 'selected' : ''}>Days</option>
                                                                                <option value="Month" ${unit === 'Month' ? 'selected' : ''}>Month</option>
                                                                                <option value="Hours" ${unit === 'Hours' ? 'selected' : ''}>Hours</option>
                                                                                <option value="Kg" ${unit === 'Kg' ? 'selected' : ''}>Kg</option>
                                                                                <option value="Ton" ${unit === 'Ton' ? 'selected' : ''}>Ton</option>
                                                                                <option value="MT" ${unit === 'MT' ? 'selected' : ''}>MT</option>
                                                                                <option value="Kg/Acre" ${unit === 'Kg/Acre' ? 'selected' : ''}>Kg/Acre</option>
                                                                                <option value="Number" ${unit === 'Number' ? 'selected' : ''}>Number</option>
                                                                                <option value="Lakhs" ${unit === 'Lakhs' ? 'selected' : ''}>Lakhs</option>
                                                                                <option value="Rs." ${unit === 'Rs.' ? 'selected' : ''}>Rs.</option>
                                                                                <option value="INR" ${unit === 'INR' ? 'selected' : ''}>INR</option>
                                                                                <option value="None" ${unit === 'None' ? 'selected' : ''}>None</option>
                                                                            </select></td>
                                                                            <td><input type="number" name="weightage[]" class="Inputa" value="${weightage}" placeholder="Enter weightage" style="width: 69px;" required></td>
                                                                            <td><select name="Logic[]" class="Inputa" style="width:75px;" required>
                                                                            @foreach($logicData as $logic)
                                                                                    <option value="{{ $logic->logicMn }}">
                                                                                        {{ $logic->logicMn }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select></td>
                                                                            <td><select name="Period[]" class="Inputa" style="width:90px;" required>
                                                                                <option value="Annual" ${period === 'Annual' ? 'selected' : ''}>Annually</option>
                                                                                <option value="1/2 Annual" ${period === '1/2 Annual' ? 'selected' : ''}>Half Yearly</option>
                                                                                <option value="Quarter" ${period === 'Quarter' ? 'selected' : ''}>Quarterly</option>
                                                                                <option value="Monthly" ${period === 'Monthly' ? 'selected' : ''}>Monthly</option>
                                                                            </select></td>
                                                                            <td><input type="number" value="100" name="Target[]" class="Inputa" value="${target}" required placeholder="Enter target" style="width:60px;"></td>
                                                                            <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtnOldkracopy"></button></td>
                                                                        </tr>
                                                                    `;
                                                                    
                                                                    // Append the new row to the table body
                                                                    $('#mainKraBodyNew').append(newRow);
                                                                }

                                                                $(document).on("click", ".removeKraBtnOldkracopy", function() {
                                                                    var row = $(this).closest("tr"); // Get the parent row of the remove button
                                                                    row.remove(); // Remove the current row

                                                                    // Count the number of remaining rows with id starting with kraRow_New
                                                                    $("#mainKraBodyNew tr[id^='kraRow_New']").each(function(index) {
                                                                        $(this).find("td:first b").text(index + 1); // The serial number starts from 1
                                                                    });
                                                                });
                                                            }
                                                            else {
                                                                // Unchecked: Find and clear the row where both KRA and KRA_Description match
                                                                var matchingRow = $('#mainKraBodyNew tr').filter(function() {
                                                                    // Check if the KRA and KRA Description match
                                                                    var kraValue = $(this).find('textarea[name="kra[]"]').val();
                                                                    var descriptionValue = $(this).find('textarea[name="kra_description[]"]').val();
                                                                    return kraValue === kra && descriptionValue === description;
                                                                });

                                                                // If matching row found, clear the input fields
                                                                matchingRow.find('textarea, select, input').val('');
                                                            }
                                                        });

                                                
                                                    } else {
                                                    alert('Error: ' + response.message);
                                                }
                                            },
                                            error: function(error) {
                                                console.log(error);
                                                alert('There was an error fetching the data.');
                                            }
                                        });
                                    }

                $(document).ready(function() {

                    $('.oldkrabtn').click(function() {
                    $('#oldkrabox').toggle();
                    });
                    $('.oldkrabtnnew').click(function() {
                    $('#oldkraboxNew').toggle();
                    });
                    $('.oldkraclose').click(function() {
                    $('#oldkrabox').toggle();
                    });
                    $('.mykra').click(function() {
                    $('#mykrabox').show();
                    $('#mykraeditbox').hide();
                    });
                    $('.mykraedit').click(function() {
                    $('#mykraeditbox').show();
                    $('#mykrabox').hide();
                    });
                    $('.subkrabtn').click(function() {
                    $('#subkrabtnbox').show();
                    });

                    $('.editkrabtn').click(function() {
                        $('#editkrabox').show();
                        $('#viewkrabox').hide();
                        $('#revertbox').hide();
                    });
                    $('.revertkrabtn').click(function() {
                        $('#editkrabox').hide();
                        $('#viewkrabox').hide();
                        $('#revertbox').show();
                    });
                    $('.viewkrabtn').click(function() {
                        $('#viewkrabox').show();
                        $('#editkrabox').hide();
                        $('#revertbox').hide();
                    });
                });

                document.addEventListener('DOMContentLoaded', function() {
            // Add event listener for all number input fields
            document.querySelectorAll('input[type="number"]').forEach(function(inputField) {
                inputField.addEventListener('input', function(e) {
                    let value = e.target.value;

                    if (parseFloat(value) < 0) {
                        // If negative, set custom validity message
                        e.target.setCustomValidity('Please enter a valid number.');
                    } else {
                        // If valid, reset custom validity
                        e.target.setCustomValidity('');
                    }
                });
            });
        });

    function printViewKraCurr() { 
    // Get the ViewKra content
    var ViewKraContent = document.querySelector('.printviewkraCurr').innerHTML;

    // Get the user's details dynamically (from your backend, assumed to be available as JavaScript variables)
    var firstName = '{{ Auth::user()->Fname }}'; // User's first name
    var surname = '{{ Auth::user()->Sname }}'; // User's surname
    var lastName = '{{ Auth::user()->Lname }}'; // User's last name
    var empCode = '{{ Auth::user()->EmpCode }}'; // User's employee code

    // Get today's date in dd-mm-yyyy format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so add 1
    var yyyy = today.getFullYear();
    var formattedDate = dd + '-' + mm + '-' + yyyy;

    // Open a new window for printing
    var printWindow = window.open('', '', 'height=500,width=800');

    printWindow.document.write('<html><head><title>KRA 2024-25</title>');

    // Add CSS for printing inside the head tag
    printWindow.document.write(`
        <style>
            body { font-family: Arial, sans-serif; }
            .table { border-collapse: collapse; width: 100%; }
            .table th, .table td { padding: 8px; border: 1px solid #000; text-align: left; }
            .table th { background-color: #f2f2f2; }
            .ViewKra-logo { width: 100px; }
            @media print {
                .fa-print { display: none; } /* Hide the print button */
                body { font-size: 12px; }
                .header, .footer, .sidebar { display: none; }
            }
        </style>
    `);

    printWindow.document.write('</head><body>');

    // Write the ViewKra content into the new window with the dynamic user info and date
    printWindow.document.write('<h2>Assessment Year 2024-25 <b style="float:right;">' + formattedDate + '</b></h2>');
    printWindow.document.write('<h2>Emp. Name: ' + firstName + ' ' + surname + ' ' + lastName + ', <b>Emp. Code: ' + empCode + '</b></h2>');
    printWindow.document.write(ViewKraContent);  // Add the ViewKra content here

    printWindow.document.write('</body></html>');

    // Close the document to trigger rendering
    printWindow.document.close();

    // Wait for the content to load and then print
    printWindow.onload = function () {
        printWindow.print();
    };
}
function printViewKraNew() { 
    // Get the ViewKra content
    var ViewKraContent = document.querySelector('.printviewkraNew').innerHTML;

    // Get the user's details dynamically (from your backend, assumed to be available as JavaScript variables)
    var firstName = '{{ Auth::user()->Fname }}'; // User's first name
    var surname = '{{ Auth::user()->Sname }}'; // User's surname
    var lastName = '{{ Auth::user()->Lname }}'; // User's last name
    var empCode = '{{ Auth::user()->EmpCode }}'; // User's employee code

    // Get today's date in dd-mm-yyyy format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so add 1
    var yyyy = today.getFullYear();
    var formattedDate = dd + '-' + mm + '-' + yyyy;

    // Open a new window for printing
    var printWindow = window.open('', '', 'height=500,width=800');

    printWindow.document.write('<html><head><title>KRA 2024-25</title>');

    // Add CSS for printing inside the head tag
    printWindow.document.write(`
        <style>
            body { font-family: Arial, sans-serif; }
            .table { border-collapse: collapse; width: 100%; }
            .table th, .table td { padding: 8px; border: 1px solid #000; text-align: left; }
            .table th { background-color: #f2f2f2; }
            .ViewKra-logo { width: 100px; }
            @media print {
                .fa-print { display: none; } /* Hide the print button */
                body { font-size: 12px; }
                .header, .footer, .sidebar { display: none; }
            }
        </style>
    `);

    printWindow.document.write('</head><body>');

    // Write the ViewKra content into the new window with the dynamic user info and date
    printWindow.document.write('<h2>Assessment Year 2025-26 <b style="float:right;">' + formattedDate + '</b></h2>');
    printWindow.document.write('<h2>Emp. Name: ' + firstName + ' ' + surname + ' ' + lastName + ', <b>Emp. Code: ' + empCode + '</b></h2>');
    printWindow.document.write(ViewKraContent);  // Add the ViewKra content here

    printWindow.document.write('</body></html>');

    // Close the document to trigger rendering
    printWindow.document.close();

    // Wait for the content to load and then print
    printWindow.onload = function () {
        printWindow.print();
    };
}
$(document).ready(function() {
    let list = $("#achievementsList");
    let pms_id = "{{ $pms_id->EmpPmsId }}";

    // Edit button click event
    $("#editAchievements").click(function() {
     
        $(".achievement-input").prop("readonly", false);
        $(".removeAchievement").removeClass("d-none");


        $(".removeDeleteachievemnet").each(function(index) {
        if (index > 0) {
            $(this).removeClass("d-none");
        }
    });
            $("#addAchievement").removeClass("d-none");
        $(this).addClass("d-none");
        $("#saveDraft").removeClass("d-none");
    });

    // Save as Draft click event
    $("#saveDraft").click(function() {
        let achievements = [];
        $(".achievement-input").each(function() {
            achievements.push($(this).val().trim());
        });

        // Ajax request to save data
        $.ajax({
            url: "/save-achievements",  // Laravel route
            type: "POST",
            data: {
                pms_id: pms_id,
                achievements: achievements,
                _token: "{{ csrf_token() }}"  // Include CSRF token
            },
            success: function(response) {
                $('#loader').hide();
                // Display success toast
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 10000
                });

                setTimeout(function() {
                    location.reload();
                }, 2000);
            },
            error: function(xhr) {
                $('#loader').hide();

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

    function addRow() {
        let count = list.children("li").length + 1;
        let newRow = `<li class="d-flex align-items-center mb-2">
                        <span class="sno me-2">${count}.</span>
                        <textarea class="form-control me-2 achievement-input" placeholder="Enter your achievement ${count}" style="width: 85%;" type="text" ></textarea>
                        <button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeAchievement"></button>
                    </li>`;
        list.append(newRow);
        updateNumbers();
    }

    $("#addAchievement").click(function() {
        addRow();
    });

    $(document).on("click", ".removeAchievement", function() {
        $(this).parent().remove();
        updateNumbers();
    });
    $(document).on("click", ".removeDeleteachievemnet", function(event) {
        $('#loader').show();

    event.preventDefault(); // Prevents form submission or page reload

    let row = $(this).closest("li"); // Get the parent <li> to remove after deletion
    let achievementId = $(this).data("achid"); // Get achievement ID

    if (!achievementId) {
        toastr.error("Invalid Achievement ID.");
        return;
    }

    if (!confirm("Are you sure you want to delete this Achievement?")) {
        $('#loader').hide();

        return;
    }

    $.ajax({
        url: "/delete-achievement/" + achievementId,
        type: "DELETE",
        data: {
            _token: "{{ csrf_token() }}" // CSRF protection
        },
        success: function(response) {
            if (response.success) {
                $('#loader').hide();

                row.remove();
                updateNumbers();
                toastr.success(response.message, 'Deleted');
            } else {
                toastr.error('Error deleting achievement.');
            }
        },
        error: function() {
            $('#loader').hide();

            toastr.error('Failed to delete achievement.');
        }
    });
});

        // Function to update numbering after removal
        function updateNumbers() {
            $("#achievementsList").children("li").each(function(index) {
                $(this).find(".sno").text((index + 1) + ".");
                $(this).find("input").attr("placeholder", "Enter your achievement " + (index + 1));
                console.log(index);

                // Ensure first row's delete button remains hidden
                if (index === 0) {
                    $(this).find(".removeDeleteachievemnet").addClass("d-none");
                } else {
                    $(this).find(".removeDeleteachievemnet").removeClass("d-none");
                }
            });
        }

});


function toggleEdit() {
    const inputs = document.querySelectorAll('#feedback textarea.form-control');
    const editButton = document.getElementById('editButtonfeedback');
    const saveButton = document.getElementById('saveButtonfeedback');

    inputs.forEach(input => {
        input.toggleAttribute('readonly');
    });

    editButton.classList.toggle('d-none');
    saveButton.classList.toggle('d-none');
}


function saveDraftfeedback(pmsid) {
    const inputs = document.querySelectorAll('#feedback textarea.form-control');
    const feedbackData = [];
    $('#loader').show();
    
    inputs.forEach(input => {
        const questionId = input.name.match(/\d+/)[0]; // Extract WorkEnvId
        const questionText = input.getAttribute("data-question"); // Get question text
        const answer = input.value; // Get answer

        feedbackData.push({
            id: questionId,
            question: questionText,
            answer: answer
        });
    });
    $.ajax({
        url: "/save-feedback",  // Laravel route
        type: "POST",
        data: {
            pmsId: pmsid,
            feedback: feedbackData,
            _token: "{{ csrf_token() }}"  // Include CSRF token
        },
        success: function(response) {
            $('#loader').hide();

            // Display success message
            toastr.success(response.message, 'Success', {
                "positionClass": "toast-top-right",
                "timeOut": 10000
            });

            // Optional: Reload the page or perform other actions
            setTimeout(function() {
                location.reload();
            }, 2000);
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
}
document.addEventListener("DOMContentLoaded", function () {
    var url = new URL(window.location.href);
    var mainTab = url.hash.split('/')[0]; // Extract main tab
    var subTab = url.hash.split('/')[1]; // Extract sub-tab if exists

    // Activate main tab
    if (mainTab) {
        var mainTabTrigger = document.querySelector('a[href="' + mainTab + '"]');
        if (mainTabTrigger) {
            var tab = new bootstrap.Tab(mainTabTrigger);
            tab.show();
        }
    }

    // Activate sub-tab
    if (subTab) {
        var subTabTrigger = document.querySelector('a[href="#' + subTab + '"]');
        if (subTabTrigger) {
            var tab = new bootstrap.Tab(subTabTrigger);
            tab.show();
        }
    }
});

// Function to update URL with Main Tab
function updateURLWithTab(tabId) {
    var currentUrl = new URL(window.location.href);
    currentUrl.hash = tabId;
    history.pushState(null, null, currentUrl.toString());
}

// Function to update URL with Sub-tab
function updateSubTabURL(subTabId) {
    var currentUrl = new URL(window.location.href);
    var mainTab = currentUrl.hash.split('/')[0]; // Keep main tab
    currentUrl.hash = mainTab + '/' + subTabId;
    history.pushState(null, null, currentUrl.toString());
}

    $(document).ready(function () {
        // Initially, keep the "Save as Draft" button hidden
        $('#saveforma').hide();
       // $('button.custom-toggle').prop('disabled', true); 
        let pms_id = "{{ $pms_id->EmpPmsId }}";
        let year_id = "{{ $PmsYId}}";
        let employeeid = "{{ Auth::user()->EmployeeID }}";
        let CompanyId = "{{ Auth::user()->CompanyId }}";



        // Click event for Edit button
        $('#editforma').on('click', function () {
    // Only affect elements inside Form A
    const formASection = $('.ViewAppraisalContentforma');

    formASection.find('input.annual-rating-kra').show();
    formASection.find('span.display-remark').hide();
    formASection.find('textarea.form-control').show();

    formASection.find('span[id^="display-remark-"]').hide();
    formASection.find('input[id^="input-rating-"], textarea[id^="textarea-remark-"]').show();

    // Enable all Form A input fields and textareas
    formASection.find('input.form-control, textarea').removeAttr('readonly');
    formASection.find('button.custom-toggle').prop('disabled', false); 

    // Show "Save as Draft" button & hide "Edit" button
    $('#saveforma').show();
    $(this).hide();
});


        //current code

        $('#editformb').on('click', function () {
    // Hide all display spans first
    $('span[id^="display-rating-formb-"], input[id^="display-remark-formb-"]').hide();
    $('span[id^="display-rating-subformb-"], span[id^="display-remark-subformb-"]').hide();

    // Show remark inputs
    $('textarea[id^="textarea-remark-formb-"], textarea[id^="textarea-remark-subformb-"]').show().prop('readonly', false);

    // Enable buttons
    $('button.custom-toggle').prop('disabled', false);

    // Handle formb ratings
    $('.annual-rating-formb').each(function () {
        if ($(this).data('period') === 'Annual') {
            $(this).show().prop('readonly', false);  // Show input if Annual
        } else {
            $(this).hide();  // Hide input
            $(this).siblings('span[id^="display-rating-formb-"]').show();  // Show span instead
        }
    });

    // Handle subformb ratings
    $('.annual-rating-formb-subkra').each(function () {
        if ($(this).data('period') === 'Annual') {
            $(this).show().prop('readonly', false);  // Show input if Annual
        } else {
            $(this).hide();  // Hide input
            $(this).siblings('span[id^="display-rating-subformb-"]').show();  // Show span instead
        }
    });

    // Show "Save as Draft", hide "Edit"
    $('#saveformb').show();
    $(this).hide();
});


        //prev code

        // $('#editformb').on('click', function () {

            
        //     $('span[id^="display-rating-formb-"], span[id^="display-remark-formb-"]').hide();
        //     $('input[id^="input-rating-formb-"], textarea[id^="textarea-remark-formb-"]').show();

        //     $('span[id^="display-rating-subformb-"], span[id^="display-remark-subformb-"]').hide();
        //     $('input[id^="input-rating-subformb-"], textarea[id^="textarea-remark-subformb-"]').show();
        
        //     $('.annual-rating-formb').attr('readonly', true);
        //     $('.annual-rating-formb-subkra').attr('readonly', true);


        //     // Enable all input fields and textareas
        //     $('textarea').removeAttr('readonly');
        //     $('button.custom-toggle').prop('disabled', false); 
        //     $('.annual-rating-formb').each(function() {
        //         if ($(this).data('period') === 'Annual') {
        //             $(this).removeAttr('readonly');
        //         }
        //     });
        //     $('.annual-rating-formb-subkra').each(function() {
        //         if ($(this).data('period') === 'Annual') {
        //             $(this).removeAttr('readonly');
        //         }
        //     });
        //     // Show "Save as Draft" button & hide "Edit" button
        //     $('#saveformb').show();
        //     $(this).hide();
        // });

        $("#saveforma").click(function () {
            $('#loader').show();

            let data = {
                kra: [],
                subkra: [],
                grandTotal: $("#grandtotalfinalemp").text().trim(),
                pms_id : pms_id,
                year_id: year_id,
                employeeid: employeeid,
                CompanyId: CompanyId
            
            };

            // Collect KRA Data (including hidden fields)
            $(".annual-rating-kra").each(function () {
                    let kraId = $(this).data("index");
                    let remarkValue = $("#kraremark" + kraId).val(); 

                    let scoreValue = $("#krascore" + kraId).val(); // Get the value from input
                    let scoreText = $("#krascore" + kraId).text().trim(); // Get the text content

                    // If value is 0 or empty, fallback to text content
                    let finalScore = (scoreValue !== "0" && scoreValue !== "" && scoreValue !== null) ? scoreValue : "0.00";
                    var KralogScore = $('#logScorekra' + kraId).text().trim();
                    console.log(KralogScore);

                    data.kra.push({
                        id: kraId,
                        rating: $(this).val(),
                        weight: $(this).data("weight"),
                        logic: $(this).data("logic"),
                        target: $(this).data("target"),
                        KralogScore: KralogScore,
                        score: finalScore, 
                        remark: remarkValue ? remarkValue.trim() : "",

                    });
                });


            // Collect Sub-KRA Data (including hidden fields)
            $(".annual-rating-subkra").each(function () {
                let subkraId = $(this).data("index");
                    let remarkValue = $("#textarea-remark-" + subkraId).val(); 

                    let scoreValue = $("#subkrascore" + subkraId).val(); 
                    let scoreText = $("#subkrascore" + subkraId).text().trim(); 

                    // If value is 0 or empty, fallback to text content
                    let finalScore = (scoreValue !== "0" && scoreValue !== "" && scoreValue !== null) ? scoreValue : "0.00";
                    var SubKralogScore = $('#logScoresubkra' + subkraId).text().trim();

                    data.subkra.push({
                        id: subkraId,
                        rating: $(this).val(),
                        weight: $(this).data("weight"),
                        logic: $(this).data("logic"),
                        target: $(this).data("target"),
                        subkralog:SubKralogScore,
                        score: finalScore,
                        remark: remarkValue ? remarkValue.trim() : "",

                    });
                });
                $(" [id^='display-rating-']").each(function () {
                let subkraId = $(this).data("index");
                    let remarkValue = $("#textarea-remark-" + subkraId).val(); 
                    let rating = $("#display-rating-" + subkraId).text(); 


                    let scoreValue = $("#subkrascore" + subkraId).val(); 
                    let scoreText = $("#subkrascore" + subkraId).text().trim(); 

                    // If value is 0 or empty, fallback to text content
                    let finalScore = (scoreValue !== "0" && scoreValue !== "" && scoreValue !== null) ? scoreValue : "0.00";
                    var SubKralogScore = $('#logScoresubkra' + subkraId).text().trim();

                    data.subkra.push({
                        id: subkraId,
                        rating: rating,
                        weight: $(this).data("weight"),
                        logic: $(this).data("logic"),
                        target: $(this).data("target"),
                        subkralog:SubKralogScore,
                        score: finalScore,
                        remark: remarkValue ? remarkValue.trim() : "",

                    });
                });



            // Send AJAX Request
            $.ajax({
                url: "{{ route('save.kra.form') }}",
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    $('#loader').hide();

                // Display success message
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 10000
                });

                // Optional: Reload the page or perform other actions
                setTimeout(function() {
                    location.reload();
                }, 2000);
                },
                error: function(xhr) {
                        // Display error message
                        let errorMessage = "An error occurred.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        toastr.error(errorMessage, 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        $('#loader').hide();

                    }
            });
        });
        $("#saveformb").click(function () {
            $('#loader').show();
            let isValid = true; // Flag to check if form is valid

            let data = {
                kra: [],
                subkra: [],
                grandTotal: $("#grandtotalfinalempFormb").text().trim(),
                pms_id : pms_id,
                year_id : year_id,
                employeeid : employeeid,
                CompanyId: CompanyId

            };

            // Collect KRA Data (including hidden fields)
            $(".annual-rating-formb").each(function () {
                    let kraId = $(this).data("index");
                    let remarkValue = $("#textarea-remark-formb-" + kraId).val(); 
                    console.log(remarkValue);

                    let scoreValue = $("#krascoreformb" + kraId).val(); // Get the value from input
                    let scoreText = $("#krascoreformb" + kraId).text().trim(); // Get the text content
                    let logicscore = $("#logScorekraformb" + kraId).val(); 

                    // If value is 0 or empty, fallback to text content
                    let finalScore = (scoreValue !== "0" && scoreValue !== "" && scoreValue !== null) ? scoreValue : "0.00";


                    data.kra.push({
                        id: kraId,
                        rating: $(this).val(),
                        weight: $(this).data("weight"),
                        logic: $(this).data("logic"),
                        target: $(this).data("target"),
                        score: finalScore,
                        logicscore:logicscore, 
                        remark: remarkValue ? remarkValue.trim() : "",

                    });
                });


            // Collect Sub-KRA Data (including hidden fields)
            $(".annual-rating-formb-subkra").each(function () {
                    let subkraId = $(this).data("index");
                    let remarkValue = $("#textarea-remark-subformb-" + subkraId).val(); 
              
                    let scoreValue = $("#subkrascoreformb" + subkraId).val(); 
                    let scoreText = $("#subkrascoreformb" + subkraId).text().trim(); 
                    let logicscore = $("#logScoresubkraformb" + subkraId).val(); 

                    // If value is 0 or empty, fallback to text content
                    let finalScore = (scoreValue !== "0" && scoreValue !== "" && scoreValue !== null) ? scoreValue : "0.00";

                    data.subkra.push({
                        id: subkraId,
                        rating: $(this).val(),
                        weight: $(this).data("weight"),
                        logic: $(this).data("logic"),
                        target: $(this).data("target"),
                        score: finalScore,
                        logicscore:logicscore,
                        remark: remarkValue ? remarkValue.trim() : "",

                    });
                });


            // Send AJAX Request
            $.ajax({
                url: "{{ route('save.kra.formb') }}",
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                success: function(response) {
                    $('#loader').hide();

                // Display success message
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 10000
                });

                // Optional: Reload the page or perform other actions
                setTimeout(function() {
                    location.reload();
                }, 2000);
                },
                error: function(xhr) {
                        // Display error message
                        let errorMessage = "An error occurred.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        toastr.error(errorMessage, 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        $('#loader').hide();

                    }
            });
        });
        $('#finalSubmitBtn').on('click', function () {
            $('#loader').show();
        if (confirm('Are you sure you want to finalize your submission?')) {
            $.ajax({
                url: '/final-submit', // Adjust the URL as needed
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    employeeId: employeeid,
                    pmsId: pms_id,
                    year_id : year_id,
                    employeeid : employeeid,
                    CompanyId: CompanyId
                },
                success: function(response) {
                    $('#loader').hide();

                // Display success message
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 10000
                });

                // Optional: Reload the page or perform other actions
                setTimeout(function() {
                    location.reload();
                }, 2000);
                },
                error: function(xhr) {
                        // Display error message
                        let errorMessage = "An error occurred.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        toastr.error(errorMessage, 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        $('#loader').hide();

                    }
            });
        }
    });

    });
        
    $(document).ready(function() {
    loadFiles(); // Load files on page load

    // Handle File Upload
    $("#uploadForm").submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('#loader').show();
        $.ajax({
            url: "{{ route('upload.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                    $('#loader').hide();

                // Display success message
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",
                    "timeOut": 10000
                });

                // Optional: Reload the page or perform other actions
                setTimeout(function() {
                    location.reload();
                }, 2000);
                },
                error: function(xhr) {
                        // Display error message
                        let errorMessage = "An error occurred.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        toastr.error(errorMessage, 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        $('#loader').hide();

                    }
        });
    });

    // Function to Load Files
    function loadFiles() {
    
        let pmsyrid = {{$PmsYId }};
        let pmsid = {{$pms_id->EmpPmsId }};
        $.ajax({
            url: "{{ route('upload.list') }}",
            data: { pmsyrid: pmsyrid, pmsid: pmsid },
            type: "GET",
            success: function(response) {
                let tableBody = $("#fileTableBody");
                tableBody.empty();
                
                // Check if response.FileName exists and has data
                if (response.FileName && response.FileName.length > 0) {
                    response.FileName.forEach((file, index) => {
                        let row = `<tr>
                            <td><b>${index + 1}.</b></td>
                            <td>${file.FileName}</td>
                            <td>
                                <a href="{{ url('Employee/AppUploadFile') }}/${file.FileName}" download>
                                    <i class="fas fa-download mr-2"></i>
                                </a>
                                <a href="#" onclick="deleteFile(${file.FileId})" class="text-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>`;
                        tableBody.append(row);
                    });
                } else {
                    tableBody.append("<tr><td colspan='3' class='text-center'>No files uploaded</td></tr>");
                }
            }

        });
    }

    // Function to Delete File
    window.deleteFile = function(fileId) {
        if (confirm("Are you sure you want to delete this file?")) {
            $.ajax({
                url: "{{ url('/upload/delete') }}/" + fileId,
                type: "DELETE",
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                                
 success: function(response) {
    $('#loader').hide();

// Display success message
toastr.success(response.message, 'Success', {
    "positionClass": "toast-top-right",
    "timeOut": 10000
});
loadFiles();

},
error: function(xhr) {
        // Display error message
        let errorMessage = "An error occurred.";
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }

        toastr.error(errorMessage, 'Error', {
            "positionClass": "toast-top-right",
            "timeOut": 3000
        });
        $('#loader').hide();

    }
            });
        }
    }
});
function printViewAppraisal() {
    const contents = document.querySelectorAll('.ViewAppraisalContent');
    let combinedContent = '';
    const handled = new Set();

    contents.forEach(section => {
        if (handled.has(section)) return;

        const cloned = section.cloneNode(true);

        cloned.querySelectorAll('span.display-remark').forEach(span => {
                const value = span.textContent.trim();
                const newSpan = document.createElement('span');
                newSpan.innerText = value;
                span.parentNode.replaceChild(newSpan, span);
            });

            
        cloned.querySelectorAll('span[id^="display-rating-formb-"]').forEach(span => {
                const td = span.closest('td');
                td.innerHTML = `<span>${span.textContent.trim()}</span>`;
            });


            cloned.querySelectorAll('input[id^="display-remark-formb-"]').forEach(input => {
                const value = input.value.trim();
                const span = document.createElement('span');
                span.innerText = value;
                input.parentNode.replaceChild(span, input);
            });



        // Replace self-rating inputs with span (skip hidden, avoid duplicates)
        cloned.querySelectorAll('input[type="number"]:not([type="hidden"])').forEach(input => {
            const parent = input.closest('td, .some-block'); // Adjust if structure is different
            if (!parent || parent.querySelector('span.self-rating-span')) return;

            const span = document.createElement('span');
            span.innerText = input.value.trim();
            span.classList.add('self-rating-span');
            input.parentNode.replaceChild(span, input);
        });

        // Remove all hidden inputs
        cloned.querySelectorAll('input[type="hidden"]').forEach(hidden => hidden.remove());
        cloned.querySelectorAll('a#editformb,a#saveformb,a#saveforma,a#editforma,a#editAchievements,a#saveDraft,a#saveButtonfeedback,a#editButtonfeedback').forEach(el => el.remove());

        // Replace buttons with their icon text (or fallback)
        cloned.querySelectorAll('button').forEach(button => {
            const icon = button.querySelector('.icon-on');
            const span = document.createElement('span');
            span.innerText = icon ? icon.innerText : '';
            button.parentNode.replaceChild(span, button);
        });
        // Replace all feedback textareas with their text content only
        cloned.querySelectorAll('textarea[id^="feedback-"]').forEach(textarea => {
            const value = textarea.value.trim();
            const container = textarea.parentNode;

            const span = document.createElement('span');
            span.innerText = value;

            // Remove the textarea, keep the question (which is in the parent <div>)
            textarea.remove();
            
            // Append the span under the question
            container.appendChild(span);
        });
        // Replace achievement textareas inside <li> with a span
        cloned.querySelectorAll('li textarea.achievement-input').forEach(textarea => {
            const span = document.createElement('span');
            span.innerText = textarea.value.trim();
            textarea.parentNode.replaceChild(span, textarea);
        });




        // Remove all elements that should not be printed
        cloned.querySelectorAll('.d-none, .removeAchievement, .removeDeleteachievemnet').forEach(el => el.remove());

        combinedContent += cloned.innerHTML;
        handled.add(section);
    });

    // Create print window
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Print KRA Appraisal - {{ Auth::user()->EmpCode }}</title>
                <style>
                table {
                width: 100%;
                border-collapse: collapse;
                table-layout: auto;
                }

                th, td {
                border: 1px solid black;
                padding: 6px;
                text-align: left;
                vertical-align: top;
                }

                /* Prevent header duplication and broken rows during printing */
                @media print {
                table {
                    page-break-inside: auto;
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }

                thead {
                    display: table-header-group;
                }

                tfoot {
                    display: table-footer-group;
                }
                }
                </style>

            </head>
            <body>
                <h3>Appraisal 2024</h3>
                <p><strong>Employee:</strong> {{ Auth::user()->Fname }} {{ Auth::user()->Sname }} {{ Auth::user()->Lname }} ({{ Auth::user()->EmpCode }})</p>
                <hr />
                ${combinedContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
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

            .deleteSubKra {
                background: none;
                border: none;
                color: red;
                /* Adjust color as needed */
                font-size: 10px;
                /* Adjust icon size */
                cursor: pointer;
            }
            .deleteKra {
                background: none;
                border: none;
                color: red;
                /* Adjust color as needed */
                font-size: 10px;
                /* Adjust icon size */
                cursor: pointer;
            }
            .removeDeleteachievemnet {
                background: none;
                border: none;
                color: red;
                /* Adjust color as needed */
                font-size: 10px;
                /* Adjust icon size */
                cursor: pointer;
            }

            .deleteSubKra:hover {
                color: darkred;
                /* Change color on hover */
            }
            .deleteKra:hover {
                color: darkred;
                /* Change color on hover */
            }
            select {
                height: 30px;
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