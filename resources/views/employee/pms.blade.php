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
                                <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('reviewer') }}"
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
                    <div class="tab-content col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                <div class="row pms-emp-details">
                                        <div class="col-md-4"><b>Assessment Year:
                                            @if($data['emp']['Schedule'] == 'Y')
                                                <span>KRA {{$KraYear}}</span></b>
                                                @else
                                                <span>-</span></b>

                                            @endif
                                        
                                            @if($data['emp']['Appform'] == 'Y')
                                            <span>PMS {{$PmsYear}}</span></b>
                                            @else
                                            <span> -</span></b>
                                            @endif
                                        </div>
                                        <div class="col-md-4"><b>EmpCode: <span>{{$employee->EmpCode}}</span></b></div>

                                        <div class="col-md-4"><b>Total VNR Experience: <span>{{$formattedDuration}}</span></b></div>
                                        <div class="col-md-4"><b>Function: <span>{{$functionName}}</span></b></div>
                                        <div class="col-md-4"><b>Designation: <span>{{$employee->designation_name}}</span></b></div>
                                        <div class="col-md-4"><b> Head Quarter : <span>{{$employee->city_village_name}}</span></b></div>
                                        <div class="col-md-4"><b>Grade: <span>{{$employee->grade_name}}</span></b></div>
                                        <div class="col-md-4"><b>DOJ: <span>{{ \Carbon\Carbon::parse($employee->DateJoining)->format('d-M-Y') }}</span></b></div>

                                        <div class="col-md-4">
                                            <b>Appraiser: <span>{{ $reporting->appraiser_fname . ' ' . $reporting->appraiser_sname . ' ' . $reporting->appraiser_lname }}</span></b>
                                        </div>
                                        <div class="col-md-4">
                                            <b>Reviewer: <span>-</span></b>
                                        </div>
                                        <div class="col-md-4">
                                            <b>HOD: <span>{{ $reporting->hod_fname . ' ' . $reporting->hod_sname . ' ' . $reporting->hod_lname }}</span></b>
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
                            $decryptedYearId = null;
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
                                        style="color: #8b8989;padding-top:13px !important;"
                                        href="{{ route('pms', ['year_id' => $encryptedCurrY]) }}">
                                            Current Year KRA - 2024
                                        </a>
                                    </li>

                                    @if ($year_kra->NewY_AllowEntry == 'Y' && $encryptedNewY)
                                        <li class="nav-item">
                                            <a class="nav-link pt-4 {{ $activeTab == $year_kra->NewY ? 'active' : '' }}"
                                            style="color: #8b8989;padding-top:13px !important;"
                                            href="{{ route('pms', ['year_id' => $encryptedNewY]) }}">
                                                New KRA - 2025-26
                                            </a>
                                        </li>
                                    @endif



                                <li class="nav-item">
                                    <a style="color: #8b8989;padding-top:13px !important;" class="nav-link pt-4 "
                                        id="Appraisal-tab20" data-bs-toggle="tab" href="#Appraisal" role="tab"
                                        aria-controls="Appraisal" aria-selected="false">Appraisal 2024</a>
                                </li>

                            </ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                            <!-- <div class="tab-pane fade {{ $decryptedYearId == $year_kra->CurrY ? 'show active' : '' }}" id="KraTab" role="tabpanel"> -->
                            <div class="tab-pane fade {{ $activeTab == $year_kra->CurrY ? 'show active' : '' }}" id="KraTab" role="tabpanel">

                                    <div class="float-end" style="margin-top:-45px;">
                                        <ul class="kra-btns">
                                        @if($kraData->isEmpty() || $kraData->contains(function ($kra) {
                                                return $kra->EmpStatus == 'D' || $kra->EmpStatus == 'P' || $kra->EmpStatus == 'R';
                                            }))
                                                <li class="mt-1"><a class="kraedit" title="Edit">Edit <i class="fas fa-edit mr-2"></i></a></li>
                                                <li><a class="effect-btn btn btn-success squer-btn sm-btn"  style="display: none;" id="saveDraftBtnCurr">Save as Draft</a></li>
                                                <li><a class="effect-btn btn btn-light squer-btn sm-btn"  style="display: none;" id="finalSubmitLi">Final Submit <i class="fas fa-check-circle mr-2"></i></a></li>
                                            @endif

                                            <li class="mt-1"><a title="Logic" data-bs-toggle="modal"
                                                    data-bs-target="#logicpopup">Logic <i
                                                        class="fas fa-tasks mr-2"></i></a></li>
                                          <!-- Button for Old KRA (Current Year) -->
                                          <li class="mt-1" id="oldkraeditli" style="display: none;">
                                                <a title="Old KRA" class="oldkrabtn" id="oldkraedit" onclick="fetchOldKRAData('{{$year_kra->OldY}}')">Old KRA <i class="fas fa-tasks mr-2"></i></a>
                                            </li>
                               
                                      
                                            <li class="mt-1"><a title="Print">Print <i class="fas fa-print mr-2"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        
                                        <!-- Old KRA section for the current year -->
                                        <div class="col-md-12" id="oldkrabox" style="display:none;">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="float-start mt-2"><b>Old KRA {{$old_year}}</b></h5>
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
                                                    </div>
                                                </div>
                                                <div id="viewForm" class="card-body table-responsive align-items-center">
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
                                                                    <td>{{ $item['kra']->Weightage }}</td>
                                                                    @if(count($item['subKras']) == 0)
                                                                        <td>{{ $item['kra']->Logic }}</td>
                                                                        <td>{{ $item['kra']->Period }}</td>
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
                                                                            {{ $item['kra']->Target }}
                                                                        </span>
                                                                        @else
                                                                                <!-- If conditions are not met, display a non-clickable value -->
                                                                                <span>{{ $item['kra']->Target }}</span>
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
                                                                                <tbody>
                                                                                    @foreach($item['subKras'] as $subIndex => $subKra)
                                                                                        <tr style="background-color: #ECECEC;">
                                                                                            <td></td>
                                                                                            <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                            <td>{{ $subKra->KRA }}</td>
                                                                                            <td>{{ $subKra->KRA_Description }}</td>
                                                                                            <td>{{ $subKra->Measure }}</td>
                                                                                            <td>{{ $subKra->Unit }}</td>
                                                                                            <td>{{ $subKra->Weightage }}</td>
                                                                                            <td>{{ $subKra->Logic }}</td>
                                                                                            <td>{{ $subKra->Period }}</td>
                                                                                           <!-- Target Input -->
                                                                                           <td>
                                                                                                            <span id="Tar_a{{ $subKra->KRASubId }}" 
                                                                                                                name="Target_subKRA[{{ $item['kra']->KRAId }}][]" 
                                                                                                                required 
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
                                                                                                                    onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}', {{ $year_kra->NewY }})"
                                                                                                                @else
                                                                                                                    style="cursor: default;" 
                                                                                                                @endif>
                                                                                                                {{ $subKra->Target }}
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
                                                                    <tr>
                                                                    @php
                                                                    $indexing = 1;
                                                                    @endphp
                                                                    
                                                                    <td>{{ $indexing ++ }}</td>
                                                                    <td><textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA"style="width:250px; overflow:hidden; resize:none;min-height:60px;"
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" readonly></textarea></td>
                                                                    <td><textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter description"style="width:300px; overflow:hidden; resize:none;min-height:60px;"
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" readonly></textarea></td>

                                                                    <!-- Measure dropdown -->
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

                                                                    <!-- Unit dropdown -->
                                                                    <td>
                                                                        <select name="Unit[]" disabled class="form-control" style="width:75px;">
                                                                            <option value="" disabled selected>Select Unit</option>
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
                                                                        <select name="Logic[]" disabled class="form-control" style="width:75px;">
                                                                        
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}">
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select name="Period[]" class="form-control" style="width:90px;"  disabled>
                                                                        <option value="" disabled selected>Select Period</option>
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly">Monthly</option>
                                                                        </select>
                                                                    </td>

                                                                    <td><input type="text" name="Target[]" class="Inputa" placeholder="Enter Target"  disabled style="width:60px;"></td>
                                                                </tr>
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
                                                            <tbody>
                                                                @if(count($kraWithSubs) > 0)

                                                                @foreach($kraWithSubs as $index => $item)
                                                                <tr id="kraRow_{{ $item['kra']->KRAId }}">
                                                                   
                                                                    <td><b>{{ $index + 1 }}.</b></td>
                                                                    <input type="hidden" name="kraId[{{ $item['kra']->KRAId }}]" value="{{ $item['kra']->KRAId }}"readonly>

                                                                    <td>
                                                                        <textarea name="kra{{ $item['kra']->KRAId }}" required class="form-control" placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" >{{ $item['kra']->KRA }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="kra_description{{ $item['kra']->KRAId }}" required class="form-control" placeholder="Enter Description"  style="width:300px; overflow:hidden; resize:none; min-height: 60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" >{{ $item['kra']->KRA_Description }}</textarea>
                                                                    </td>
                                                                    

                                                                    <!-- Measure dropdown -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Measure_{{ $item['kra']->KRAId }}" required name="Measure_{{ $item['kra']->KRAId }}" >
                                                                        <option value="" disabled selected>Select Measure</option>
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
                                                                            <option value="" disabled selected>Select Unit</option>
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
                                                                        <option value="" disabled selected>Select Logic</option>
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
                                                                        <option value="" disabled selected>Select Period</option>
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
                                                                        <input id="Tar_kra_{{ $item['kra']->KRAId }}" class="Inputa" required style="width:60px;"
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
                                                                                    readonly
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
                                                                            <tbody>
                                                                                @foreach($item['subKras'] as $subIndex => $subKra)
                                                                                <tr style="background-color: #ECECEC;">
                                                                                    <td></td>
                                                                                    <!-- SN (Sub KRA Number) -->
                                                                                    <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                    <input type="hidden" name="subKraId[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->KRASubId ?? '' }}" >

                                                                                    <td>
                                                                                        <textarea required name="subKraName[{{ $item['kra']->KRAId }}][]" class="form-control" placeholder="Enter sub KRA" rows="2" style="width:250px; overflow:hidden; resize:none;" 
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                        <textarea required name="subKraDesc[{{ $item['kra']->KRAId }}][]" class="form-control" placeholder="Enter description" rows="2" style="width:300px; overflow:hidden; resize:none;"  
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA_Description }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                            <select id="Measure_subKRA_{{ $subKra->KRASubId }}" name="Measure_subKRA[{{ $item['kra']->KRAId }}][]" required>
                                                                                            <option value="" disabled selected>Select Measure</option>
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
                                                                                        <option value="" disabled selected>Select Unit</option>
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
                                                                                        <input type="text" name="Weightage_subKRA[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->Weightage }}" placeholder="Enter weightage" style="width: 69px;" required>
                                                                                    </td>
                                                                                    <!-- Logic Dropdown -->
                                                                                    <td>
                                                                                        <select name="Logic_subKRA[{{ $item['kra']->KRAId }}][]" style="width:75px;" required>
                                                                                        <option value="" disabled selected>Select Logic</option>
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
                                                                                        <option value="" disabled selected>Select Period</option>
                                                                                            <option value="Annual" {{ $subKra->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                                            <option value="1/2 Annual" {{ $subKra->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                                            <option value="Quarter" {{ $subKra->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                                            <option value="Monthly" {{ $subKra->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Target Input -->
                                                                                    <td>
                                                                                            <input id="Tar_a{{ $subKra->KRASubId }}" 
                                                                                                name="Target_subKRA[{{ $item['kra']->KRAId }}][]" 
                                                                                                required 
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
                                                                                                    onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}', {{ $year_kra->NewY }})"
                                                                                                @else
                                                                                                    readonly
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
                                                                <tr>
                                                                    @php
                                                                    $indexing = 1;
                                                                    @endphp
                                                                    
                                                                    <td>{{ $indexing ++ }}</td>
                                                                    <td><textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA"style="width:250px; overflow:hidden; resize:none;min-height:60px;" required
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                                                                    <td><textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter Description"style="width:300px; overflow:hidden; resize:none;min-height:60px;" required
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>

                                                                    <!-- Measure dropdown -->
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

                                                                    <!-- Unit dropdown -->
                                                                    <td>
                                                                        <select name="Unit[]" required>
                                                                            <option value="" disabled selected>Select Unit</option>
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

                                                                    <td><input type="number" name="weightage[]" placeholder="Enter weightage" style="width: 69px;" required></td>

                                                                    <td>
                                                                        <select name="Logic[]" style="width:75px;" required>
                                                                        
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}">
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select name="Period[]" class="Inputa" style="width:90px;" required>
                                                                        <option value="" disabled selected>Select Period</option>
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly">Monthly</option>
                                                                        </select>
                                                                    </td>

                                                                    <td><input type="text" name="Target[]" class="Inputa" placeholder="Enter target"  required style="width:60px;"></td>
                                                                </tr>
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
                                <div class="tab-pane fade {{ $activeTab == $year_kra->NewY ? 'show active' : '' }}" id="KraTabnew" role="tabpanel">
                                    
                                    <div class="float-end" style="margin-top:-45px;">
                                        <ul class="kra-btns">
                                        @if($kraData->isEmpty() || $kraData->contains(function ($kra) {
                                                return $kra->EmpStatus == 'D' || $kra->EmpStatus == 'P' || $kra->EmpStatus == 'R';
                                            }))
                                            <li class="mt-1"><a class="kraeditNew">Edit <i
                                            class="fas fa-edit mr-2"></i></a></li>
                                            <li><a class="effect-btn btn btn-success squer-btn sm-btn" id="saveDraftBtnNew" style="display: none;">Save as Draft</a></li>
                                            </li>
                                            <li><a class="effect-btn btn btn-light squer-btn sm-btn" id="finalSubmitLiNew" style="display: none;">Final Submit <i
                                                        class="fas fa-check-circle mr-2"></i></a></li>
                                            @endif

                                            <li class="mt-1"><a title="View" data-bs-toggle="modal"
                                                    data-bs-target="#logicpopup">Logic <i
                                                        class="fas fa-tasks mr-2"></i></a></li>                                         
                                            <!-- Button for Old KRA (Current Year) -->
                                          <li class="mt-1" id="oldkraeditnewli"style="display: none;">
                                                <a class="oldkrabtnnew" id="oldkraeditNew" onclick="fetchOldKRADataNew('{{$year_kra->CurrY}}')">Old KRA <i class="fas fa-tasks mr-2"></i></a>
                                            </li>
                                      
                                            <li class="mt-1"><a>Print <i class="fas fa-print mr-2"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <!-- Old KRA section for the new year -->
                                        <div class="col-md-12" id="oldkraboxNew" style="display:none;">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="float-start mt-2"><b>Old KRA {{$old_year}}</b></h5>
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
                                                    </div>
                                                </div>
                                                <div id="viewFormNew" class="card-body table-responsive align-items-center">
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
                                                                                
                                                                                <td>{{ $item['kra']->Weightage }}</td>
                                                                                @if(count($item['subKras']) == 0)
                                                                                <td>{{ $item['kra']->Logic }}</td>
                                                                                <td>{{ $item['kra']->Period }}</td>
                                                                                <td>
                                                                    @if(count($item['subKras']) == 0)
                                                                        <span id="Tar_kra_{{ $item['kra']->KRAId }}" class="ClickableValue btn btn-outline-success custom-toggle" style="cursor: pointer; padding:5px 7px;
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
                                                                            {{ $item['kra']->Target }}
                                                                        </span>
                                                                        @else
                                                                                <!-- If conditions are not met, display a non-clickable value -->
                                                                                <span>{{ $item['kra']->Target }}</span>
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
                                                                                        <table class="table" id="subKraTable_New{{ $item['kra']->KRAId }}" style="background-color:#ECECEC; margin-left:20px;">
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
                                                                                                        <td>{{ $subKra->Weightage }}</td>
                                                                                                        <td>{{ $subKra->Logic }}</td>
                                                                                                        <td>{{ $subKra->Period }}</td>
                                                                                                       <!-- Target Input -->
                                                                                                       <td>
                                                                                                            <span id="Tar_a{{ $subKra->KRASubId }}" 
                                                                                                                name="Target_subKRA[{{ $item['kra']->KRAId }}][]" 
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
                                                                                                                {{ $subKra->Target }}
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
                                                                    <tr>
                                                                    @php
                                                                    $indexing = 1;
                                                                    @endphp
                                                                    
                                                                    <td>{{ $indexing ++ }}</td>
                                                                    <td><textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA"style="width:250px; overflow:hidden; resize:none;min-height:60px;"
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" readonly></textarea></td>
                                                                    <td><textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter description"style="width:300px; overflow:hidden; resize:none;min-height:60px;"
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" readonly></textarea></td>

                                                                    <!-- Measure dropdown -->
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

                                                                    <!-- Unit dropdown -->
                                                                    <td>
                                                                        <select name="Unit[]" disabled class="form-control" style="width:75px;">
                                                                            <option value="" disabled selected>Select Unit</option>
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

                                                                    <td><input type="number" name="weightage[]" placeholder="Enter Weightage" style="width: 78px;" readonly></td>

                                                                    <td>
                                                                        <select name="Logic[]" disabled class="form-control" style="width:75px;">
                                                                        
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}">
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select name="Period[]" class="form-control" style="width:90px;"  disabled>
                                                                        <option value="" disabled selected>Select Period</option>
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly">Monthly</option>
                                                                        </select>
                                                                    </td>

                                                                    <td><input type="text" name="Target[]" class="Inputa" placeholder="Enter target"  disabled style="width:60px;"></td>
                                                                </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                       
                                                                        
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                          
                                                        </div>

                                                <div id="editFormNew" class="card-body table-responsive align-items-center" style="display: none;">
                                            
                                                        
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
                                                            <tbody>
                                                                @if(count($kraWithSubs) > 0)

                                                                @foreach($kraWithSubs as $index => $item)
                                                                <tr id="kraRow_New{{ $item['kra']->KRAId }}">
                                                                   
                                                                    <td><b>{{ $index + 1 }}.</b></td>
                                                                    <input type="hidden" name="kraId[{{ $item['kra']->KRAId }}]" value="{{ $item['kra']->KRAId }}"readonly>

                                                                    <td>
                                                                        <textarea name="kra{{ $item['kra']->KRAId }}" class="form-control" placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>{{ $item['kra']->KRA }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="kra_description{{ $item['kra']->KRAId }}" class="form-control" placeholder="Enter description"  style="width:300px; overflow:hidden; resize:none; min-height: 60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>{{ $item['kra']->KRA_Description }}</textarea>
                                                                    </td>
                                                                    

                                                                    <!-- Measure dropdown -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Measure_{{ $item['kra']->KRAId }}" name="Measure_{{ $item['kra']->KRAId }}" required>
                                                                            <option value="" disabled selected>Select Measure</option>
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
                                                                        <option value="" disabled selected>Select Unit</option>
                                                                            
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
                                                                        <option value="" disabled selected>Select Logic</option>
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
                                                                        <option value="" disabled selected>Select Period</option>
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
                                                                        <input id="Tar_kra_{{ $item['kra']->KRAId }}" class="Inputa" required placeholder="Enter target" style="width:60px;"
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
                                                                                readonly
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
                                                                            <tbody>
                                                                                @foreach($item['subKras'] as $subIndex => $subKra)
                                                                                <tr style="background-color: #ECECEC;">
                                                                                    <td></td>
                                                                                    <!-- SN (Sub KRA Number) -->
                                                                                    <td><b>{{ $subIndex + 1 }}.</b></td>
                                                                                    <input type="hidden" name="subKraId[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->KRASubId ?? '' }}" >

                                                                                    <td>
                                                                                        <textarea required name="subKraName[{{ $item['kra']->KRAId }}][]" class="form-control" placeholder="Enter sub KRA" rows="2" style="width:250px; overflow:hidden; resize:none;" 
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                        <textarea name="subKraDesc[{{ $item['kra']->KRAId }}][]" class="form-control" placeholder="Enter sub KRA description" rows="2" style="width:300px; overflow:hidden; resize:none;"  
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>{{ $subKra->KRA_Description }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                        <select id="Measure_subKRA_{{ $subKra->KRASubId }}" name="Measure_subKRA[{{ $item['kra']->KRAId }}][]"required >
                                                                                        <option value="" disabled selected>Select Measure</option>
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
                                                                                            <option value="" disabled selected>Select Unit</option>    
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
                                                                                        <input placeholder="Enter weightage" type="text" name="Weightage_subKRA[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->Weightage }}" style="width: 78px;" required>
                                                                                    </td>
                                                                                    <!-- Logic Dropdown -->
                                                                                    <td>
                                                                                        <select name="Logic_subKRA[{{ $item['kra']->KRAId }}][]" style="width:75px;" required>
                                                                                        <option value="" disabled selected>Select Logic</option>
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
                                                                                        <option value="" disabled selected>Select Period</option>
                                                                                        <option value="Annual" {{ $subKra->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                                            <option value="1/2 Annual" {{ $subKra->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                                            <option value="Quarter" {{ $subKra->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                                            <option value="Monthly" {{ $subKra->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Target Input -->
                                                                                    <td>
                                                                                    <input id="Tar_a{{ $subKra->KRASubId }}" 
                                                                                        name="Target_subKRA[{{ $item['kra']->KRAId }}][]" placeholder="Enter target"
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
                                                                                            readonly
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
                                                                <tr>
                                                                    @php
                                                                    $indexing = 1;
                                                                    @endphp
                                                                    
                                                                    <td>{{ $indexing ++ }}</td>
                                                                    <td><textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA"style="width:250px; overflow:hidden; resize:none;min-height:60px;" required
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                                                                    <td><textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter description"style="width:300px; overflow:hidden; resize:none;min-height:60px;" required
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>

                                                                    <!-- Measure dropdown -->
                                                                    <td>
                                                                        <select name="Measure[]" class="Inputa"  required>
                                                                        <option value="" disabled selected>Select Measure</option>
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

                                                                    <!-- Unit dropdown -->
                                                                    <td>
                                                                        <select name="Unit[]" required>
                                                                        <option value="" disabled selected>Select Unit</option>
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

                                                                    <td><input type="number" name="weightage[]" placeholder="Enter weightage" style="width: 69px;" required></td>

                                                                    <td>
                                                                        <select name="Logic[]" style="width:75px;" required>
                                                                        <option value="" disabled selected>Select Logic</option>
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}">
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select name="Period[]" class="Inputa" style="width:90px;" required>
                                                                        <option value="" disabled selected>Select Period</option>
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly">Monthly</option>
                                                                        </select>
                                                                    </td>

                                                                    <td><input type="text" name="Target[]" class="Inputa" placeholder="Enter Target" required style="width:60px;"></td>
                                                                </tr>
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
                                
                                <div class="tab-pane fade" id="Appraisal" role="tabpanel">
                                    <div class="row">

                                        <div class="mfh-machine-profile">
                                            <div class="float-end" style="margin-top:-45px;">
                                                <ul class="kra-btns nav nav-tabs border-0" id="myTab2" role="tablist">
                                                    <li><a class="effect-btn btn btn-light squer-btn sm-btn">Final Submit <i class="fas fa-check-circle mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="active" id="home-tab1" data-bs-toggle="tab" href="#achievements" role="tab" aria-controls="home" aria-selected="true">Achievements <i class="fas fa-star mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="" id="profile-tab200" data-bs-toggle="tab" href="#formAkra" role="tab" aria-controls="profile" aria-selected="false">Form A(KRA) <i class="fas fa-file-alt mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="" id="profile-tab21" data-bs-toggle="tab" href="#formBskill" role="tab" aria-controls="profile" aria-selected="false">Form B(Skill) <i class="fas fa-file-invoice mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="" id="profile-tab22" data-bs-toggle="tab" href="#feedback" role="tab" aria-controls="profile" aria-selected="false">Feedback <i class="fas fa-file-signature mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="" id="profile-tab22" data-bs-toggle="tab" href="#upload" role="tab" aria-controls="profile" aria-selected="false">Upload <i class="fas fa-file-upload mr-2"></i></a></li>

                                                    <li class="mt-1"><a>Print <i class="fas fa-print mr-2"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="tab-content splash-content2" id="myTabContent2">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show" id="achievements" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Achievements</b>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end">Save as Draft</a>

                                                        </div>
                                                        <div class="card-body table-responsive dd-flex align-items-center">
                                                            <ol class="achievements-list">
                                                                <li><input class="form-control" placeholder="Enter your achievements" style="width:100%;" type="text" /></li>
                                                                <li><input class="form-control" placeholder="Enter your achievements" style="width:100%;" type="text" /></li>
                                                                <li><input class="form-control" placeholder="Enter your achievements" style="width:100%;" type="text" /></li>
                                                                <li><input class="form-control" placeholder="Enter your achievements" style="width:100%;" type="text" /></li>
                                                                <li><input class="form-control" placeholder="Enter your achievements" style="width:100%;" type="text" /></li>
                                                            </ol>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn" data-bs-dismiss="modal">Add &nbsp;<i class="fas fa-plus-circle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade" id="formAkra" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Form A (KRA)</b>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end">Save as Draft</a>
                                                        </div>
                                                        <div class="card-body table-responsive dd-flex align-items-center">
                                                            <table class="table table-pad">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sn.</th>
                                                                        <th>KRA/Goals</th>
                                                                        <th>Description</th>
                                                                        <th>Weightage</th>
                                                                        <th>Logic</th>
                                                                        <th>Period</th>
                                                                        <th>Target</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><b>1.</b></td>
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
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade" id="formBskill" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Form B (Skills)</b>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end">Save as Draft</a>
                                                        </div>
                                                        <div class="card-body table-responsive dd-flex align-items-center">
                                                            <table class="table table-pad">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Sn.</th>
                                                                        <th>KRA/Goals</th>
                                                                        <th>Description</th>
                                                                        <th>Weightage</th>
                                                                        <th>Logic</th>
                                                                        <th>Period</th>
                                                                        <th>Target</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><b>1.</b></td>
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
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade" id="feedback" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Feedback</b>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end">Save as Draft</a>
                                                        </div>
                                                        <div class="card-body table-responsive dd-flex align-items-center">
                                                            <div class="w-100 mb-3"><b>1. What is your feedback regarding the existing & new processes that are being followed or needs to be followed in your respective functions?</b><br>
                                                                <input class="form-control" placeholder="Enter your feedback" style="width:100%;" type="text" />
                                                            </div>
                                                            <div class="w-100 mb-3"><b>2. At work, are there any factors that hinder your growth?</b><br>
                                                                <input class="form-control" placeholder="Enter your feedback" style="width:100%;" type="text" />
                                                            </div>
                                                            <div class="w-100 mb-3"><b>3. At work, what are the factors that facilitate your growth?</b><br>
                                                                <input class="form-control" placeholder="Enter your feedback" style="width:100%;" type="text" />
                                                            </div>
                                                            <div class="w-100 mb-3"><b>4. What support you need from the superiors to facilitate your performance?</b><br>
                                                                <input class="form-control" placeholder="Enter your feedback" style="width:100%;" type="text" />
                                                            </div>
                                                            <div class="w-100 mb-3"><b>5. Any other feedback.</b><br>
                                                                <input class="form-control" placeholder="Enter your feedback" style="width:100%;" type="text" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade" id="upload" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Upload Files</b>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn float-end">Save as Draft</a>
                                                        </div>
                                                        <div class="card-body table-responsive dd-flex align-items-center">
                                                            <div class="form-group mr-2" id="">
                                                                <label class="col-form-label">Name of File</label>
                                                                <input type="text" name="uploadfilename" class="form-control" id="uploadfilename" placeholder="Remark In">
                                                            </div>
                                                            <div class="form-group" id="">
                                                                <label class="col-form-label">Upload Files</label>
                                                                <input type="file" name="uploadfilename" class="form-control">
                                                            </div>
                                                            <a class="effect-btn btn btn-success squer-btn sm-btn mt-3 ml-2">Save</a>
                                                            <br>
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
                                                                        <td><a title="View" data-bs-toggle="modal" data-bs-target="#viewuploadfile"><i class="fas fa-eye mr-2"></i></a></td>
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

                        <div class="ad-footer-btm">
                            <p><a href="">Terms of use</a> | <a href="">Privacy Policy</a> 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
                        </div>
                    </div>

                    @include('employee.footerbottom')
                </div>
            </div>
        </div>
        <!--View KRA Modal-->
        <div class="modal fade show" id="viewKRA" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
        </div>
        <!--view upload Modal-->
        <div class="modal fade show" id="viewuploadedfiles" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
        </div>

        <!--view history Modal-->

        <div class="modal fade show" id="viewHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
        </div>


        <!--All achivement and feedback view -->
        <div class="modal fade show" id="viewappraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
        </div>
        <!-- All achivement and feedback edit -->
        <div class="modal fade show" id="editAppraisal" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
        </div>

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
                                <tr>
                                    <th colspan="5"></th>
                                    <th style="text-align: center;" colspan="4">Employee Achievement Details</th>
                                    <th colspan="2"></th>
                                </tr>
                                <tr>
                                    <th>SN.</th>
                                    <th>Quarter</th>
                                    <th>Weightage</th>
                                    <th>Target</th>
                                    <th style="width: 320px;">Activity Performed</th>
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
                                    <th>Action</th>
                                    <th>Status</th>
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
                                        <a style="border: 1px solid #ddd;padding: 2px 7px;font-size: 11px;" class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i> Submit</a>
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
                                        <a style="border: 1px solid #ddd;padding: 2px 7px;font-size: 11px;" class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i> Submit</a>
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
        @include('employee.footer')
        <script>

            $(document).ready(function() {
                $('#saveDraftBtnCurr').click(function() {
                    let form = $("#kraFormcurrent")['0']; // Get the form element
                    let isValid = true;

                    // Clear any previous error messages
                    $('.error-message').remove();

                    $(form).find('input[required], textarea[required], select[required]').each(function() {
                        if (!$(this).val()) {
                            isValid = false;

                            // Add red border for invalid fields
                            $(this).css({
                                'border': '2px solid red',
                                'height': '35px' 
                            });
                            // Create and display error message below the input field
                            $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                        } else {
                            // Remove the red border and error message if field is filled
                            $(this).css('border', '');
                            $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                        }
                    });

                    if (!isValid) {
                        $('#loader').hide();  // Hide the loader since validation failed
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
                                "timeOut": 5000
                            });
                        }
                    
                    });
                });
                
                $('#finalSubmitLi').click(function() {
                    let form = $("#kraFormcurrent")['0']; // Get the form element
                    let isValid = true;

                    // Clear any previous error messages
                    $('.error-message').remove();

                    $(form).find('input[required], textarea[required], select[required]').each(function() {
                        if (!$(this).val()) {
                            isValid = false;

                            // Add red border for invalid fields
                            $(this).css({
                                'border': '2px solid red',
                                'height': '35px' 
                            });
                            // Create and display error message below the input field
                            $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                        } else {
                            // Remove the red border and error message if field is filled
                            $(this).css('border', '');
                            $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                        }
                    });

                    if (!isValid) {
                        $('#loader').hide();  // Hide the loader since validation failed
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
                                "timeOut": 5000
                            });
                        }
                    });
                });
                
                $('#saveDraftBtnNew').click(function() {
                    let form = $("#kraFormcurrentNew")['0']; // Get the form element
                    let isValid = true;

                        // Clear any previous error messages
                        $('.error-message').remove();

                        $(form).find('input[required], textarea[required], select[required]').each(function() {
                            if (!$(this).val()) {
                                isValid = false;

                                // Add red border for invalid fields
                                $(this).css({
                                    'border': '2px solid red',
                                    'height': '35px' 
                                });
                                // Create and display error message below the input field
                                $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                            } else {
                                // Remove the red border and error message if field is filled
                                $(this).css('border', '');
                                $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                            }
                        });

                        if (!isValid) {
                            $('#loader').hide();  // Hide the loader since validation failed
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
                                "timeOut": 5000
                            });
                        }
                    });
                });
                
                $('#finalSubmitLiNew').click(function() {
                    let form = $("#kraFormcurrentNew")['0']; // Get the form element
                    let isValid = true;

                        // Clear any previous error messages
                        $('.error-message').remove();

                        $(form).find('input[required], textarea[required], select[required]').each(function() {
                            if (!$(this).val()) {
                                isValid = false;

                                // Add red border for invalid fields
                                $(this).css({
                                    'border': '2px solid red',
                                    'height': '35px' 
                                });
                                // Create and display error message below the input field
                                $(this).after('<div class="error-message" style="color: red; font-size: 10px;">This field is required.</div>');
                            } else {
                                // Remove the red border and error message if field is filled
                                $(this).css('border', '');
                                $(this).siblings('.error-message').remove();  // Remove error message if field is valid
                            }
                        });

                        if (!isValid) {
                            $('#loader').hide();  // Hide the loader since validation failed
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
                                "timeOut": 5000
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


                // Get the table body element where rows are added (Assuming your table body has the ID 'kraTable')
                var kraTable = document.getElementById('current_kra');

                // Remove "+" button from previous last row (if exists)
                // var existingButtons = kraTable.querySelectorAll('.addKraDynamicBtn');
                // existingButtons.forEach(btn => btn.remove());

                // Create a new <tr> element for the new row
                var newRow = document.createElement('tr');

                var rowCount = kraTable.rows.length; // Counts existing rows (including header)


                // Add the structure for the new row (with input fields and dropdowns)
                newRow.innerHTML = `
              
                    <td>${rowCount}</td>

                    <td><textarea type="text" required class="form-control" name="kra[]"  placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                    <td><textarea type="text" required class="form-control" name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" placeholder="Enter KRA Description" ></textarea></td>

                    <td>
                    <select name="Measure[]" class="Inputa"  required>
                    <option value="" disabled selected>Select Measure</option>
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
                    <option value="" disabled selected>Select Unit</option>
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

                    <td><input type="text" class="Inputa" name="weightage[]"  required placeholder="Enter weightage" style="width: 69px;" ></td>
                    <td>
                    <select  name="Logic[]" style="width:75px;" required>
                            <option value="" disabled selected>Select Logic</option>
                    @foreach($logicData as $logic)
                                                                                                        <option value="{{ $logic->logicMn }}">
                                                                                                            {{ $logic->logicMn }}
                                                                                                        </option>
                                                                                                        @endforeach

                    </select>
                    </td>
                    <td>
                    <select id="Period[]" name="Period[]" style="width:90px;" required >
                    <option value="" disabled selected>Select Period</option>
                    <option value="Annual">Annually</option>
                    <option value="1/2 Annual">Half Yearly</option>
                    <option value="Quarter">Quarterly</option>
                    <option value="Monthly">Monthly</option>
                    </select>
                    </td>

                    <td><input type="text" class="Inputa" name="Target[]"  placeholder="Enter target"required style="width:60px;"></td>
                    
                        <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtn"></button></td>

                    `;

                // Append the new row to the table
                kraTable.appendChild(newRow);
            }
            function addKRANew() {


            // Get the table body element where rows are added (Assuming your table body has the ID 'kraTable')
            var kraTable = document.getElementById('current_kraNew');

            // Create a new <tr> element for the new row
            var newRow = document.createElement('tr');

            var rowCount = kraTable.rows.length; // Counts existing rows (including header)

            // Add the structure for the new row (with input fields and dropdowns)
            newRow.innerHTML = `

                <td>${rowCount}</td>

                <td><textarea type="text" class="form-control" required name="kra[]"  placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                <td><textarea type="text" class="form-control" required name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" placeholder="Enter KRA Description" ></textarea></td>

                <td>
                <select name="Measure[]" class="Inputa" required >
                <option value="" disabled selected>Select Measure</option>
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
                <select id="Unit[]" name="Unit[]" class="Inputa" style="width:75px;" required >
                <option value="" disabled selected>Select Unit</option>
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

                <td><input type="text" class="Inputa" name="weightage[]"  placeholder="Enter weightage" style="width: 69px;" required></td>
                <td>
                <select  name="Logic[]" style="width:75px;" required>
                        <option value="" disabled selected>Select Logic</option>
                @foreach($logicData as $logic)
                                                                                                    <option value="{{ $logic->logicMn }}">
                                                                                                        {{ $logic->logicMn }}
                                                                                                    </option>
                                                                                                    @endforeach

                </select>
                </td>
                <td>
                <select id="Period[]" name="Period[]" style="width:90px;" required>
                <option value="" disabled selected>Select Period</option>
                <option value="Annual">Annually</option>
                <option value="1/2 Annual">Half Yearly</option>
                <option value="Quarter">Quarterly</option>
                <option value="Monthly">Monthly</option>
                </select>
                </td>

                <td><input type="text" class="Inputa" name="Target[]"  placeholder="Enter target"required style="width:60px;"></td>
                
                    <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtn"></button></td>

                `;

            // Append the new row to the table
            kraTable.appendChild(newRow);
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
                $(this).closest("tr").remove(); // Removes the current row
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
                                contentHtml = `
                        <p><strong>Logic:</strong> ${subKraData.Logic}</p>
                        <p><strong>KRA:</strong> ${subKraData.KRA}</p>
                        <p><strong>KRA Description:</strong> ${subKraData.KRA_Description}</p>
                        <table class="table table-pad" id="mykraeditbox">
                            <thead>
                                <tr>
                                    <th colspan="5"></th>
                                    <th style="text-align: center;" colspan="4">Employee Achievement Details</th>
                                    <th colspan="2"></th>
                                </tr>
                                <tr>
                                    <th>SN.</th>
                                    <th>Quarter</th>
                                    <th>Weightage</th>
                                    <th>Target</th>
                                    <th style="width: 320px;">Activity Performed</th>
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="kraRows">
                                ${generateKraRows(kraData, subKraData,subKraDatamain)}
                            </tbody>
                        </table>
                    `;
                            } else {
                                contentHtml = `
                        <p><strong>Logic:</strong> ${subKraDatamain.Logic}</p>
                        <p><strong>KRA:</strong> ${subKraDatamain.KRA}</p>
                        <p><strong>KRA Description:</strong> ${subKraDatamain.KRA_Description}</p>
                        <table class="table table-pad" id="mykraeditbox">
                            <thead>
                                <tr>
                                    <th colspan="5"></th>
                                    <th style="text-align: center;" colspan="4">Employee Achievement Details</th>
                                    <th colspan="2"></th>
                                </tr>
                                <tr>
                                    <th>SN.</th>
                                    <th>Quarter</th>
                                    <th>Weightage</th>
                                    <th>Target</th>
                                    <th style="width: 320px;">Activity Performed</th>
                                    <th>Self Rating</th>
                                    <th>Remarks</th>
                                    <th>Score</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="kraRows">
                                ${generateKraRows(kraData)}
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

            function generateKraRows(kraData, subKraData = null, subKraDatamain = null) {

                let rows = '';
                kraData.forEach((detail, index) => {
                    rows += `
                        <tr>
                            <td><b>${index + 1}</b></td>
                            <td>${detail.Tital}</td>
                            <td>${detail.Wgt}</td>
                            <td>${detail.Tgt}</td>
                            <td>${detail.Remark}</td>
                            <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="width: 60px;" type="text" placeholder="Enter rating" value="${detail.Ach}" >
                            </td>
                            <td style="background-color: #e7ebed;">
                                        <input class="form-control" style="min-width: 200px;" type="text" placeholder="Enter your remark" value="${detail.Cmnt}" >
                            </td>
                            <td>${detail.Scor}</td>
                                <td>
                                        <a title="Save" href=""><i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i></a> 
                                        <a style="border: 1px solid #ddd;padding: 2px 7px;font-size: 11px;" class="btn btn-outline-success waves-effect waves-light material-shadow-none" title="Submit" href=""><i style="font-size:14px;" class=" ri-check-line"></i> Submit</a>
                                        <!--<button type="button" class="btn btn-success btn-label rounded-pill" style="padding: 3px 7px;font-size: 11px;"><i class="ri-check-line label-icon align-middle rounded-pill fs-16 me-1"></i> Submit</button>-->
                                    </td>
                            <td><i class="fas fa-check-circle mr-2 text-success"></i></td>
                        </tr>
                    `;
                });
                // Add row for Sub-KRA (Total) if available
                if (subKraData && !kraData) {
                    rows += `
                        <tr>
                            <td colspan="2"><b>Total</b></td>
                            <td>${subKraData.Weightage}</td>
                            <td colspan="7"></td>
                        </tr>
                    `;
                }
                if (kraData && !subKraData) {
                    rows += `
                        <tr>
                            <td colspan="2"><b>Total</b></td>
                            <td>${kraData.Weightage}</td>
                            <td colspan="7"></td>
                        </tr>
                    `;
                }
                if (subKraDatamain) {
                    rows += `
                        <tr>
                            <td colspan="2"><b>Total</b></td>
                            <td>${subKraDatamain.Weightage}</td>
                            <td colspan="7"></td>
                        </tr>
                    `;
                }
                return rows;
            }

            function addSubKRA(kraId) {
                let existingTable = document.getElementById(`subKraTable_${kraId}`);
                // If table doesn't exist, create it dynamically
                if (!existingTable) {
                    let kraRow = document.getElementById(`kraRow_${kraId}`); // Find the main KRA row
                    if (!kraRow) {
                        console.error(`KRA Row with ID 'kraRow_${kraId}' not found.`);
                        return;
                    }

                    // Create a new row for the Sub-KRA table
                    let subKraRow = kraRow.insertAdjacentHTML("afterend", `
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
                }

                let tbody = existingTable.querySelector("tbody");
                let rowCount = tbody.rows.length;

                let newRow = tbody.insertRow(rowCount);
                newRow.style.backgroundColor = "#ECECEC";

                newRow.innerHTML = `
                <td></td>

                <td><b>${rowCount + 1}.</b></td>
                <td>
                    <textarea name="subKraName[${kraId}][]" required class="form-control" placeholder="Enter sub KRA" rows="2" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea>
                </td>
                <td>
                    <textarea name="subKraDesc[${kraId}][]" required class="form-control" placeholder="Enter description" rows="2" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea>
                </td>

                <td>
                    <select name="Measure_subKRA[${kraId}][]" required>
                        <option value="" disabled selected>Select Measure</option>
                       <option value="Process">Process</option>
                                                                                            <option value="Acreage" >Acreage</option>
                                                                                            <option value="Event" >Event</option>
                                                                                            <option value="Program" >Program</option>
                                                                                            <option value="Maintenance">Maintenance</option>
                                                                                            <option value="Time" >Time</option>
                                                                                            <option value="Yield" >Yield</option>
                                                                                            <option value="Value" >Value</option>
                                                                                            <option value="Volume" >Volume</option>
                                                                                            <option value="Quantity">Quantity</option>
                                                                                            <option value="Quality" >Quality</option>
                                                                                            <option value="Area" >Area</option>
                                                                                            <option value="Amount" >Amount</option>
                                                                                            <option value="None">None</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="Unit_subKRA[${kraId}][]" style="width:75px;" required>
                                                                            <option value="" disabled selected>Select Unit</option>
                                                                            <option value="%" >%</option>
                                                                            <option value="Acres">Acres</option>
                                                                            <option value="Days" >Days</option>
                                                                            <option value="Month" >Month</option>
                                                                            <option value="Hours" >Hours</option>
                                                                            <option value="Kg">Kg</option>
                                                                            <option value="Ton">Ton</option>
                                                                            <option value="MT">MT</option>
                                                                            <option value="Kg/Acre">Kg/Acre</option>
                                                                            <option value="Number" >Number</option>
                                                                            <option value="Lakhs">Lakhs</option>
                                                                            <option value="Rs." >Rs.</option>
                                                                            <option value="INR" >INR</option>
                                                                            <option value="None">None</option>
                                                                        </select>
                                                                    </td>
                <td><input type="text" name="Weightage_subKRA[${kraId}][]" required class="form-control" placeholder="Enter weightage" style="width: 69px;" ></td>
                <td>
                    <select name="Logic_subKRA[${kraId}][]" style="width:75px;" required>
                            <option value="" disabled selected>Select Logic</option>
                                                                                                                  @foreach($logicData as $logic)
                                                                                            <option value="{{ $logic->logicMn }}"
                                                                                                >
                                                                                                {{ $logic->logicMn }}
                                                                                            </option>
                                                                                            @endforeach
                    </select>
                </td>
                <td>
                    <select name="Period_subKRA[${kraId}][]" style="width:90px;" required>
                                                                        <option value="" disabled selected>Select Period</option>

                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly" selected="">Monthly</option>
                    </select>
                </td>
                <td><input type="text" name="Target_subKRA[${kraId}][]" class="form-control" placeholder="Enter target" required style="width:60px;"></td>
                <td><button type="button" class="ri-close-circle-fill border-0" onclick="removeSubKRA(this)"></button></td>
            `;
            }
            
            
            function addSubKRANew(kraId) {
    // Find the existing Sub-KRA table for the given KRA ID
    let existingTable = document.getElementById(`subKraTable_${kraId}`);

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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </td>
            </tr>
        `);
        // Re-fetch the table after creation
        existingTable = document.getElementById(`subKraTable_${kraId}`);
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
            <textarea required="" name="subKraName[${kraId}][]" class="form-control" placeholder="Enter sub KRA" rows="2" style="width:250px; overflow:hidden; resize:none;" oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"></textarea>
        </td>

        <td>
            <textarea name="subKraDesc[${kraId}][]" class="form-control" placeholder="Enter sub KRA description" rows="2" style="width:300px; overflow:hidden; resize:none;" oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required=""></textarea>
        </td>

        <td>
            <select name="Measure_subKRA[${kraId}][]" required="">
                <option value="" disabled selected>Select Measure</option>
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
                <option value="" disabled selected>Select Unit</option>    
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
                <option value="" disabled selected>Select Logic</option>
                <option value="Logic1">Logic1</option>
                <option value="Logic2">Logic2</option>
                <option value="Logic3">Logic3</option>
                <option value="Logic4">Logic4</option>
                <option value="Logic5">Logic5</option>
                <option value="Logic6">Logic6</option>
            </select>
        </td>

        <td>
            <select name="Period_subKRA[${kraId}][]" style="width:90px;" required="">
                <option value="" disabled selected>Select Period</option>
                <option value="Annual">Annually</option>
                <option value="1/2 Annual">Half Yearly</option>
                <option value="Quarter">Quarterly</option>
                <option value="Monthly">Monthly</option>
            </select>
        </td>

        <td>
            <input type="text" name="Target_subKRA[${kraId}][]" placeholder="Enter target" required="" style="width:60px;">
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
            document.getElementById('oldkraeditli').style.display = 'inline-block';
            document.getElementById('saveDraftBtnCurr').style.display = 'inline-block';
        }
        // Check if the clicked element is the 'kraedit' button
        if (e.target && e.target.matches('.kraeditNew')) {
            e.preventDefault();
            document.getElementById('viewFormNew').style.display = 'none';
            document.getElementById('editFormNew').style.display = 'block';
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
           
            function fetchOldKRAData(yearId) {
                 // Make the AJAX request
    $.ajax({
        url: '{{ route('fetch_old_kra') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            old_year: yearId
        },
        success: function(response) {
            if (response.success) {
                // Show the old KRA box
                $('#oldkrabox').show();

                // Populate the table with the fetched data
                var kraData = response.data;
                var tableBody = $('#kraTableBody');
                tableBody.empty(); // Clear any existing rows

                kraData.forEach(function(kra, index) {
                    var row = '<tr>' +
                        '<td><input type="checkbox" class="kra-checkbox" data-kra="' + kra.KRA + '" data-description="' + kra.KRA_Description + '" data-measure="' + kra.Measure + '" data-unit="' + kra.Unit + '" data-weightage="' + kra.Weightage + '" data-logic="' + kra.Logic + '" data-period="' + kra.Period + '" data-target="' + kra.Target + '"></td>' +
                        '<td><b>' + (index + 1) + '.</b></td>' +
                        '<td>' + kra.KRA + '</td>' +
                        '<td>' + kra.KRA_Description + '</td>' +
                        '<td>' + kra.Measure + '</td>' +
                        '<td>' + kra.Unit + '</td>' +
                        '<td>' + kra.Weightage + '</td>' +
                        '<td>' + kra.Logic + '</td>' +
                        '<td>' + kra.Period + '</td>' +
                        '<td>' + kra.Target + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });

                // Add an event listener for checkbox changes
                $(".kra-checkbox").change(function() {
                    // If checkbox is checked, copy the data into another table
                    if (this.checked) {
                        // Get the table body where the data will be copied
                        var kraTableBody = $('#current_kra tbody');
                         // Remove rows that don't have an id or data-kra-id attribut
                        // Remove any <tr> without an ID
                        kraTableBody.find('tr').each(function() {
                            if (!$(this).attr('id')) {
                                $(this).remove();
                            }
                        });
                        // Extract data from the checkbox using data attributes
                        var kra = $(this).data('kra');
                        var description = $(this).data('description');
                        var measure = $(this).data('measure');
                        var unit = $(this).data('unit');
                        var weightage = $(this).data('weightage');
                        var logic = $(this).data('logic');
                        var period = $(this).data('period');
                        var target = $(this).data('target');

                        // Generate a unique ID for the row
                        var kraId = 'kra_' + Date.now();

                        // Calculate serial number (sno)
                        var sno = kraTableBody.find('tr').length + 1; // Number of rows in the table

                        // Create new row HTML
                        var newRow = `
                            <tr id="${kraId}">
                                <td><b>${sno}</b></td>
                                <td><textarea name="kra[]" class="form-control" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"required>${kra}</textarea></td>
                                <td><textarea name="kra_description[]" class="form-control" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';"required>${description}</textarea></td>
                                <td><select name="Measure[]" class="form-control" required>
                                    <option value="" disabled selected>Select Measure</option>
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
                                    <option value="" disabled selected>Select Unit</option>
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
                                        <option value="" disabled selected>Select Logic</option>
                                    @foreach($logicData as $logic)
                                                                                                    <option value="{{ $logic->logicMn }}">
                                                                                                        {{ $logic->logicMn }}
                                                                                                    </option>
                                                                                                    @endforeach
                                </select></td>
                                <td><select name="Period[]" class="Inputa" style="width:90px;" required>
                                <option value="" disabled selected>Select Period</option>
                                    <option value="Annual" ${period === 'Annual' ? 'selected' : ''}>Annually</option>
                                    <option value="1/2 Annual" ${period === '1/2 Annual' ? 'selected' : ''}>Half Yearly</option>
                                    <option value="Quarter" ${period === 'Quarter' ? 'selected' : ''}>Quarterly</option>
                                    <option value="Monthly" ${period === 'Monthly' ? 'selected' : ''}>Monthly</option>
                                </select></td>
                                <td><input type="text" name="Target[]" class="Inputa" value="${target}" required placeholder="Enter target" style="width:60px;"></td>
                                <td><button type="button" class="fas fa-trash" onclick="removeRow('${kraId}')"></button></td>
                            </tr>
                        `;

                        // Insert the new row at the end of the table
                        kraTableBody.append(newRow);
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

            function fetchOldKRADataNew(yearId) {
    // Make the AJAX request
    $.ajax({
        url: '{{ route('fetch_old_kra') }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}', // CSRF token for security
            old_year: yearId
        },
        success: function(response) {
            if (response.success) {
                // Show the old KRA box
                $('#oldkraboxnew').show();

                // Populate the table with the fetched data
                var kraData = response.data;
                var tableBody = $('#kraTableBodyNew');
                tableBody.empty(); // Clear any existing rows
               
                kraData.forEach(function(kra, index) {
                    var row = '<tr>' +
                        '<td><input type="checkbox" class="kra-checkbox" data-kra="' + kra.KRA + '" data-description="' + kra.KRA_Description + '" data-measure="' + kra.Measure + '" data-unit="' + kra.Unit + '" data-weightage="' + kra.Weightage + '" data-logic="' + kra.Logic + '" data-period="' + kra.Period + '" data-target="' + kra.Target + '"></td>' +
                        '<td><b>' + (index + 1) + '.</b></td>' +
                        '<td>' + kra.KRA + '</td>' +
                        '<td>' + kra.KRA_Description + '</td>' +
                        '<td>' + kra.Measure + '</td>' +
                        '<td>' + kra.Unit + '</td>' +
                        '<td>' + kra.Weightage + '</td>' +
                        '<td>' + kra.Logic + '</td>' +
                        '<td>' + kra.Period + '</td>' +
                        '<td>' + kra.Target + '</td>' +
                        '</tr>';
                    tableBody.append(row);
                });

                // Add an event listener for checkbox changes
                $(".kra-checkbox").change(function() {
                    // If checkbox is checked, copy the data into another table
                    if (this.checked) {
                        // Get the table body where the data will be copied
                        var kraTableBody = $('#current_kraNew tbody');
                        kraTableBody.find('tr').each(function() {
                            if (!$(this).attr('id')) {
                                $(this).remove();
                            }
                        });
                        // Extract data from the checkbox using data attributes
                        var kra = $(this).data('kra');
                        var description = $(this).data('description');
                        var measure = $(this).data('measure');
                        var unit = $(this).data('unit');
                        var weightage = $(this).data('weightage');
                        var logic = $(this).data('logic');
                        var period = $(this).data('period');
                        var target = $(this).data('target');

                        // Generate a unique ID for the row
                        var kraId = 'kra_' + Date.now();

                        // Calculate serial number (sno)
                        var sno = kraTableBody.find('tr').length + 1; // Number of rows in the table

                        // Create new row HTML
                        var newRow = `
                            <tr id="${kraId}">
                                <td><b>${sno}</b></td>
                                <td><textarea name="kra[]" class="form-control" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>${kra}</textarea></td>
                                <td><textarea name="kra_description[]" class="form-control" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" required>${description}</textarea></td>
                                <td><select name="Measure[]" class="form-control" required>
                                    <option value="" disabled selected>Select Measure</option>
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
                                    <option value="" disabled selected>Select Unit</option>
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
                                        <option value="" disabled selected>Select Logic</option>
                                    @foreach($logicData as $logic)
                                                                                                    <option value="{{ $logic->logicMn }}">
                                                                                                        {{ $logic->logicMn }}
                                                                                                    </option>
                                                                                                    @endforeach                                </select></td>
                                <td><select name="Period[]" class="Inputa" style="width:90px;" required>
                                <option value="" disabled selected>Select Period</option>
                                    <option value="Annual" ${period === 'Annual' ? 'selected' : ''}>Annually</option>
                                    <option value="1/2 Annual" ${period === '1/2 Annual' ? 'selected' : ''}>Half Yearly</option>
                                    <option value="Quarter" ${period === 'Quarter' ? 'selected' : ''}>Quarterly</option>
                                    <option value="Monthly" ${period === 'Monthly' ? 'selected' : ''}>Monthly</option>
                                </select></td>
                                <td><input type="text" name="Target[]" class="Inputa" value="${target}" required placeholder="Enter target" style="width:60px;"></td>
                                <td><button type="button" class="fas fa-trash" onclick="removeRow('${kraId}')" ></button></td>
                            </tr>
                        `;

                        // Insert the new row at the end of the table
                        kraTableBody.append(newRow);
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
            <style>