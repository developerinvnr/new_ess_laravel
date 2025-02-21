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
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">PMS Information</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link active" href="{{ route('pms') }}"
                                    role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                                    <span class="d-none d-sm-block">Employee</span>
                                </a>
                            </li>
                            @if($exists_appraisel)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link " href="{{ route('appraiser') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Appraiser</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_reviewer)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('reviewer') }}"
                                    role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">Reviewer</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_hod)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('hod') }}" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                                    <span class="d-none d-sm-block">HOD</span>
                                </a>
                            </li>
                            @endif
                            @if($exists_mngmt)
                            <li class="nav-item" role="presentation">
                                <a style="color: #0e0e0e;" class="nav-link" href="{{ route('management') }}"
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
                                            @endif
                                            @if($data['emp']['Appform'] == 'Y')
                                            <span>PMS {{$PmsYear}}</span></b>
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
                                <li class="nav-item">
                                    <a style="color: #8b8989;padding-top:13px !important;" class="nav-link pt-4 active"
                                        id="profile-tab20" data-bs-toggle="tab" href="#KraTab" role="tab"
                                        aria-controls="KraTab" aria-selected="false">Current Year KRA - 2024 </a>
                                </li>

                                <li class="nav-item">
                                    <a style="color: #8b8989;padding-top:13px !important;" class="nav-link pt-4"
                                        id="KraTabnew-tab20" data-bs-toggle="tab" href="#KraTabnew" role="tab"
                                        aria-controls="KraTabnew" aria-selected="false">New KRA - 2025-26 </a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #8b8989;padding-top:13px !important;" class="nav-link pt-4 "
                                        id="Appraisal-tab20" data-bs-toggle="tab" href="#Appraisal" role="tab"
                                        aria-controls="Appraisal" aria-selected="false">Appraisal 2024</a>
                                </li>

                            </ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                                <div class="tab-pane fade active show" id="KraTab" role="tabpanel">
                                    <div class="float-end" style="margin-top:-45px;">
                                        <ul class="kra-btns">
                                        @if(count($kraWithSubs) > 0)
                                            <li class="mt-1"><a class="kraedit">Edit <i
                                            class="fas fa-edit mr-2"></i></a></li>
                                            @endif
                                            <li><a class="effect-btn btn btn-success squer-btn sm-btn" id="saveDraftBtnCurr" style="display: none;">Save as Draft</a></li>
                                            </li>
                                            <li><a class="effect-btn btn btn-light squer-btn sm-btn" id="finalSubmitLi" style="display: none;">Final Submit <i
                                                        class="fas fa-check-circle mr-2"></i></a></li>
                                            <li class="mt-1"><a title="View" data-bs-toggle="modal"
                                                    data-bs-target="#logicpopup">Logic <i
                                                        class="fas fa-tasks mr-2"></i></a></li>
                                            <li class="mt-1"><a class="oldkrabtn" id="oldkraedit" style="display: none;">Old KRA <i
                                                        class="fas fa-tasks mr-2"></i></a></li>
                                      
                                            <li class="mt-1"><a>Print <i class="fas fa-print mr-2"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="oldkrabox" style="display:none;">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="float-start mt-2"><b>Old KRA {{$old_year}}</b></h5>
                                                    <!-- <div class="float-end"><a
                                                            class="effect-btn btn btn-success squer-btn sm-btn">Copy to
                                                            Current Year Assessment</a>
                                                        <a
                                                            class="effect-btn btn btn-secondary squer-btn sm-btn oldkraclose">Cancel</a>
                                                    </div> -->
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
                                                        <tbody>
                                                            @foreach($kraListold as $index => $kra)
                                                            <tr style="background-color: {{ $index % 2 == 0 ? '#f2f2f2' : '#ffffff' }};">
                                                                <!-- Checkbox for selection -->
                                                                <td>
                                                                    <input type="checkbox" class="kra-checkbox"
                                                                        data-kra="{{ $kra->KRA }}"
                                                                        data-description="{{ $kra->KRA_Description }}"
                                                                        data-measure="{{ $kra->Measure }}"
                                                                        data-unit="{{ $kra->Unit }}"
                                                                        data-weightage="{{ $kra->Weightage }}"
                                                                        data-logic="{{ $kra->Logic }}"
                                                                        data-period="{{ $kra->Period }}"
                                                                        data-target="{{ $kra->Target }}">
                                                                </td>
                                                                <td><b>{{ $index + 1 }}.</b></td>
                                                                <td>{{ $kra->KRA }}</td>
                                                                <td>{{ $kra->KRA_Description }}</td>
                                                                <td>{{ $kra->Measure }}</td>
                                                                <td>{{ $kra->Unit }}</td>
                                                                <td>{{ $kra->Weightage }}</td>
                                                                <td>{{ $kra->Logic }}</td>
                                                                <td>{{ $kra->Period }}</td>
                                                                <td>{{ $kra->Target }}</td>
                                                            </tr>
                                                            @endforeach
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
                                                                    @if(count($kraWithSubs) > 0)
                                                                        @foreach($kraWithSubs as $index => $item)
                                                                            <tr>
                                                                                <td><b>{{ $index + 1 }}.</b></td>
                                                                                <td>{{ $item['kra']->KRA }}</td>
                                                                                <td>{{ $item['kra']->KRA_Description }}</td>
                                                                                <td>{{ $item['kra']->KRA_Description }}</td>
                                                                                <td>{{ $item['kra']->Measure }}</td>
                                                                                <td>{{ $item['kra']->Unit }}</td>
                                                                                <td>{{ $item['kra']->Weightage }}</td>
                                                                                <td>{{ $item['kra']->Logic }}</td>
                                                                                <td>{{ $item['kra']->Period }}</td>
                                                                                <td>{{ $item['kra']->Target }}</td>
                                                                            </tr>

                                                                            @if(count($item['subKras']) > 0)
                                                                                <tr>
                                                                                    <td colspan="10">
                                                                                        <!-- Sub-KRA Table -->
                                                                                        <table class="table" id="subKraTable_{{ $item['kra']->KRAId }}" style="background-color:#ECECEC; margin-left:20px;">
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
                                                                                                    </tr>
                                                                                                @endforeach
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <!-- Show empty input fields if no data -->
                                                                        <tr>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                            
                                                            <!-- Add KRA Button -->
                                                            <button id="addKraBtnedit" class="btn btn-primary mt-3">Add KRA</button>
                                                        </div>

                                                <div id="editForm" class="card-body table-responsive align-items-center" style="display: none;">
                                            
                                                        
                                                    <form id="kraFormcurrent"  method="POST">
                                                        @csrf

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

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if(count($kraWithSubs) > 0)

                                                                @foreach($kraWithSubs as $index => $item)
                                                                <tr id="kraRow_{{ $item['kra']->KRAId }}">
                                                                   
                                                                    <td><b>{{ $index + 1 }}.</b></td>
                                                                    <input type="hidden" name="kraId[{{ $item['kra']->KRAId }}]" value="{{ $item['kra']->KRAId }}"readonly>

                                                                    <td>
                                                                        <textarea name="kra{{ $item['kra']->KRAId }}" class="form-control" placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" >{{ $item['kra']->KRA }}</textarea>
                                                                    </td>
                                                                    <td>
                                                                        <textarea name="kra_description{{ $item['kra']->KRAId }}" class="form-control" placeholder="Enter Description"  style="width:300px; overflow:hidden; resize:none; min-height: 60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" >{{ $item['kra']->KRA_Description }}</textarea>
                                                                    </td>
                                                                    

                                                                    <!-- Measure dropdown -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Measure_{{ $item['kra']->KRAId }}" name="Measure_{{ $item['kra']->KRAId }}" >
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
                                                                        <select id="Unit_{{ $item['kra']->KRAId }}" name="Unit_{{ $item['kra']->KRAId }}" >
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
                                                                    <td><input type="number" name="weightage{{ $item['kra']->KRAId }}"  placeholder="Enter Weightage" style="width:69px;" value="{{$item['kra']->Weightage }}" ></td>

                                                                    <!-- Logic -->
                                                                    <td>
                                                                        @if(count($item['subKras']) == 0)
                                                                        <select id="Logic_{{ $item['kra']->KRAId }}" name="Logic_{{ $item['kra']->KRAId }}" >
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}">
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
                                                                        <select id="Period_{{ $item['kra']->KRAId }}" name="Period_{{ $item['kra']->KRAId }}" >
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
                                                                        <input id="Tar_kra_{{ $item['kra']->KRAId }}" class="Inputa" 
                                                                            value="{{ $item['kra']->Target }}" name="Target_{{ $item['kra']->KRAId }}"
                                                                            style="cursor: pointer; width:100%; text-align:center; 
                                                                        @if($item['kra']->Period != 'Annual' && $item['kra']->Period != '') 
                                                                            text-decoration: underline; color: #000099;
                                                                        @else
                                                                            text-decoration: none; color: black;
                                                                        @endif"
                                                                            maxlength="8"
                                                                            @if($item['kra']->Period != 'Annual' && $item['kra']->Period != '')
                                                                        onClick="showKraDetails('{{ $item['kra']->KRAId }}', '{{ $item['kra']->Period }}','{{ $item['kra']->Target }}', '{{ intval($item['kra']->Weightage) }}', '{{ $item['kra']->Logic }}',13)"
                                                                        @endif
                                                                        />
                                                                        @else
                                                                        @endif
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
                                                                        <table class="table" id="subKraTable_{{ $item['kra']->KRAId }}" style="background-color:#ECECEC; margin-left:20px;">
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
                                                                                        <textarea name="subKraName[{{ $item['kra']->KRAId }}][]" class="form-control" placeholder="Sub KRA Name" rows="2"style="width:250px; overflow:hidden; resize:none;" 
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                        <textarea name="subKraDesc[{{ $item['kra']->KRAId }}][]" class="form-control" placeholder="Sub KRA Description" rows="2"style="width:300px; overflow:hidden; resize:none;"  
                                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">{{ $subKra->KRA_Description }}</textarea>
                                                                                    </td>

                                                                                    <td>
                                                                                        <select id="Measure_subKRA_{{ $subKra->KRASubId }}" name="Measure_subKRA[{{ $item['kra']->KRAId }}][]" >
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
                                                                                        <select id="Unit_subKRA_{{ $subKra->KRASubId }}" name="Unit_subKRA[{{ $item['kra']->KRAId }}][]" >
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
                                                                                        <input type="text" name="Weightage_subKRA[{{ $item['kra']->KRAId }}][]" value="{{ $subKra->Weightage }}" style="width: 69px;" >
                                                                                    </td>
                                                                                    <!-- Logic Dropdown -->
                                                                                    <td>
                                                                                        <select name="Logic_subKRA[{{ $item['kra']->KRAId }}][]" >
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
                                                                                        <select id="Period_subKRA_{{ $subKra->KRASubId }}" name="Period_subKRA[{{ $item['kra']->KRAId }}][]" >
                                                                                            <option value="Annual" {{ $subKra->Period == 'Annual' ? 'selected' : '' }}>Annually</option>
                                                                                            <option value="1/2 Annual" {{ $subKra->Period == '1/2 Annual' ? 'selected' : '' }}>Half Yearly</option>
                                                                                            <option value="Quarter" {{ $subKra->Period == 'Quarter' ? 'selected' : '' }}>Quarterly</option>
                                                                                            <option value="Monthly" {{ $subKra->Period == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                                                                        </select>
                                                                                    </td>

                                                                                    <!-- Target Input -->
                                                                                    <td>
                                                                                        <input id="Tar_a{{ $subKra->KRASubId }}" class="Inputa" name="Target_subKRA[{{ $item['kra']->KRAId }}][]" 
                                                                                            value="{{ $subKra->Target }}"
                                                                                            style="cursor: {{ $subKra->Period != 'Annual' && $subKra->Period != '' ? 'pointer' : 'default' }}; width:100%; text-align:center; text-decoration: {{ $subKra->Period != 'Annual' && $subKra->Period != '' ? 'underline' : 'none' }}; color: {{ $subKra->Period != 'Annual' && $subKra->Period != '' ? '#000099' : '#000' }};"
                                                                                            maxlength="8"
                                                                                            @if($subKra->Period != 'Annual' && $subKra->Period != '')
                                                                                        onClick="showKraDetails({{ $subKra->KRASubId }}, '{{ $subKra->Period }}', {{ $subKra->Target }}, {{ intval($subKra->Weightage) }}, '{{ $subKra->Logic }}',13)"
                                                                                        @endif
                                                                                        />
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
                                                                <!-- Show empty input fields if no data -->
                                                                <tr>
                                                                    @php
                                                                    $indexing = 1;
                                                                    @endphp
                                                                    
                                                                    <td>{{ $indexing ++ }}</td>
                                                                    <td><textarea type="text" name="kra[]" class="form-control" placeholder="Enter KRA"style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                                                                    <td><textarea type="text" name="kra_description[]" class="form-control" placeholder="Enter Description"style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>

                                                                    <!-- Measure dropdown -->
                                                                    <td>
                                                                        <select name="Measure[]" class="Inputa" style="width:100%; height:20px;" >
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
                                                                        <select name="Unit[]" >
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

                                                                    <td><input type="number" name="weightage[]" placeholder="Enter Weightage" style="width: 69px;" ></td>

                                                                    <td>
                                                                        <select name="Logic[]" >
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{ $logic->logicMn }}">
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select name="Period[]" class="Inputa" style="width:100%; height:20px;" >
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly">Monthly</option>
                                                                        </select>
                                                                    </td>

                                                                    <td><input type="text" name="Target[]" class="Inputa" placeholder="Enter Target" style="width:100%; text-align:center;" ></td>
                                                                </tr>
                                                                @endif
                                                            </tbody>

                                                        </table>
                                                    <!-- <button type="button" class="btn btn-success" id="addKraBtn">Add Kra</button> -->
                                                    <button type="button" class="btn btn-success" id="addKraBtn">
                                                            Add Kra <i class="fas fa-plus-circle"></i>
                                                        </button>

                                                    </form>

                                                    <table class="table table-pad" id="mykraeditbox"
                                                        style="display:none;">
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
                                                                <td><a class="subkrabtn"><i
                                                                            class="fas fa-plus-circle mr-2"></i></a><b>1.</b>
                                                                </td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select Logic </option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select </option>
                                                                        <option>Quarterly</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control"
                                                                        style="width:50px;font-weight: bold;"
                                                                        type="text">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><a class="subkrabtn"><i
                                                                            class="fas fa-plus-circle mr-2"></i></a>
                                                                    <b>2.</b>
                                                                </td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select Logic </option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select </option>
                                                                        <option>Quarterly</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control"
                                                                        style="width:50px;font-weight: bold;"
                                                                        type="text">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td> <a class="subkrabtn"><i
                                                                            class="fas fa-plus-circle mr-2"></i></a>
                                                                    <b>3.</b>
                                                                </td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select Logic </option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select </option>
                                                                        <option>Quarterly</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control"
                                                                        style="width:50px;font-weight: bold;"
                                                                        type="text">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><a class="subkrabtn"><i
                                                                            class="fas fa-plus-circle mr-2"></i></a>
                                                                    <b>4.</b>
                                                                </td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select Logic </option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select </option>
                                                                        <option>Quarterly</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control"
                                                                        style="width:50px;font-weight: bold;"
                                                                        type="text">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td><a class="subkrabtn"><i
                                                                            class="fas fa-plus-circle mr-2"></i></a>
                                                                    <b>5.</b>
                                                                </td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td><input class="form-control"
                                                                        style="min-width: 300px;" type="text"></td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select</option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select Logic </option>
                                                                        <option>1</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select>
                                                                        <option>Select </option>
                                                                        <option>Quarterly</option>
                                                                        <option>1</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control"
                                                                        style="width:50px;font-weight: bold;"
                                                                        type="text">
                                                                </td>
                                                            </tr>
                                                            <tr style="display:none;" id="subkrabtnbox">
                                                                <td colspan="10">
                                                                    <table class="table"
                                                                        Style="background-color:#ECECEC;">
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
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select Logic </option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select </option>
                                                                                        <option>Quarterly</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input class="form-control"
                                                                                        style="width:50px;font-weight: bold;"
                                                                                        type="text">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><b>2.</b></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select Logic </option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select </option>
                                                                                        <option>Quarterly</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input class="form-control"
                                                                                        style="width:50px;font-weight: bold;"
                                                                                        type="text">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><b>3.</b></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select Logic </option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select </option>
                                                                                        <option>Quarterly</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input class="form-control"
                                                                                        style="width:50px;font-weight: bold;"
                                                                                        type="text">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><b>4.</b></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select Logic </option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select </option>
                                                                                        <option>Quarterly</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input class="form-control"
                                                                                        style="width:50px;font-weight: bold;"
                                                                                        type="text">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><b>5.</b></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td><input class="form-control"
                                                                                        style="min-width: 300px;"
                                                                                        type="text"></td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select</option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select Logic </option>
                                                                                        <option>1</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <select>
                                                                                        <option>Select </option>
                                                                                        <option>Quarterly</option>
                                                                                        <option>1</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td>
                                                                                    <input class="form-control"
                                                                                        style="width:50px;font-weight: bold;"
                                                                                        type="text">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <a class="effect-btn btn btn-success squer-btn sm-btn"
                                                                        data-bs-dismiss="modal">Add&nbsp;<i
                                                                            class="fas fa-plus-circle"></i></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane " id="KraTabnew" role="tabpanel">
                                    <div class="float-end" style="margin-top:-45px;">
                                        <ul class="kra-btns">
                                            <li><a class="effect-btn btn btn-success squer-btn sm-btn" id="saveDraftBtnNew">Save as Draft</a></li>
                                            <li><a class="effect-btn btn btn-light squer-btn sm-btn">Final Submit <i class="fas fa-check-circle mr-2"></i></a></li>
                                            <li class="mt-1"><a title="View" data-bs-toggle="modal" data-bs-target="#logicpopup">Logic <i class="fas fa-tasks mr-2"></i></a></li>
                                            <li class="mt-1"><a class="oldkrabtnnew">Old KRA <i class="fas fa-tasks mr-2"></i></a></li>
                                            <li class="mt-1"><a class="mykraedit">Edit <i class="fas fa-edit mr-2"></i></a></li>
                                            <li class="mt-1"><a class="mykra">View <i class="fas fa-eye mr-2"></i></a></li>
                                            <li class="mt-1"><a>Print <i class="fas fa-print mr-2"></i></a></li>
                                        </ul>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" id="oldkraboxnew" style="display:none;">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="float-start mt-2"><b>Old KRA {{$old_year}}</b></h5>
                                                    <!-- <div class="float-end"><a
                                                                    class="effect-btn btn btn-success squer-btn sm-btn">Copy to
                                                                    Current Year Assessment</a>
                                                                <a
                                                                    class="effect-btn btn btn-secondary squer-btn sm-btn oldkraclose">Cancel</a>
                                                            </div> -->
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
                                                            @foreach($kraListold as $index => $kra)
                                                            <tr style="background-color: {{ $index % 2 == 0 ? '#f2f2f2' : '#ffffff' }};">

                                                                <!-- <td><input type="checkbox" /></td> -->
                                                                <td><b>{{ $index + 1 }}.</b></td>
                                                                <td>{{ $kra->KRA }}</td>
                                                                <td>{{ $kra->KRA_Description }}</td>
                                                                <td>{{ $kra->Measure }}</td>
                                                                <td>{{ $kra->Unit }}</td>
                                                                <td>{{ $kra->Weightage }}</td>
                                                                <td>{{ $kra->Logic }}</td>
                                                                <td>{{ $kra->Period }}</td>
                                                                <td>{{ $kra->Target }}</td>
                                                            </tr>
                                                            @endforeach
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
                                                <div class="card-body table-responsive dd-flex align-items-center">

                                                    <form id="kraForm" method="POST">
                                                        @csrf
                                                        <table class="table table-pad" id="kraTable">
                                                            <thead>
                                                                <tr>
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
                                                                <!-- Initial Row -->
                                                                <tr class="kraRow">
                                                                    <td><textarea class="form-control" type="text" name="kra[]" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                                                                    <td><textarea class="form-control" type="text" name="description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                    oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                                                                    <td>
                                                                        <select  name="measure[]" style="width:100%;" >
                                                                            <option value="None">None</option>
                                                                            <option value="Acreage">Acreage</option>
                                                                            <option value="Event">Event</option>
                                                                            <option value="Program">Program</option>
                                                                            <option value="Process">Process</option>
                                                                            <option value="Maintenance">Maintenance</option>
                                                                            <option value="Time">Time</option>
                                                                            <option value="Yield">Yield</option>
                                                                            <option value="Value">Value</option>
                                                                            <option value="Volume">Volume</option>
                                                                            <option value="Quantity">Quantity</option>
                                                                            <option value="Quality">Quality</option>
                                                                            <option value="Area">Area</option>
                                                                            <option value="Amount">Amount</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="unit[]" style="width:100%;" >
                                                                            <option value="%">%</option>
                                                                            <option value="Acres">Acres</option>
                                                                            <option value="Days">Days</option>
                                                                            <option value="Month">Month</option>
                                                                            <option value="Hours">Hours</option>
                                                                            <option value="Days/Hours">Days/Hours</option>
                                                                            <option value="Kg">Kg</option>
                                                                            <option value="Ton">Ton</option>
                                                                            <option value="MT">MT</option>
                                                                            <option value="Kg/Acre">Kg/Acre</option>
                                                                            <option value="Number">Number</option>
                                                                            <option value="Lakhs">Lakhs</option>
                                                                            <option value="Rs.">Rs.</option>
                                                                            <option value="MT">MT</option>
                                                                            <option value="INR">INR</option>
                                                                            <option value="None">None</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input class="form-control" type="number" name="weightage[]" style="width: 69px;" ></td>
                                                                    <td>
                                                                        <select name="logic[]" >
                                                                            @foreach($logicData as $logic)
                                                                            <option value="{{$logic->logicMn}}">
                                                                                {{ $logic->logicMn }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                        <select  name="period[]" style="width:100%;" >
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly">Monthly</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input class="form-control" type="number" name="target[]" ></td>
                                                                    <td><button type="button" class="btn btn-danger deleteRowBtn"> <i class="ri-close-circle-fill mr-2" ></i></button></td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <button type="button" class="btn btn-success" id="addRowBtn">Add Row</button>

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
                                                <ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
                                                    <li><a class="effect-btn btn btn-light squer-btn sm-btn">Final Submit <i class="fas fa-check-circle mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="active" id="home-tab1" data-bs-toggle="tab" href="#achievements" role="tab" aria-controls="home" aria-selected="true">Achievements <i class="fas fa-star mr-2"></i></a></li>
                                                    <li class="mt-1"><a class="" id="profile-tab20" data-bs-toggle="tab" href="#formAkra" role="tab" aria-controls="profile" aria-selected="false">Form A(KRA) <i class="fas fa-file-alt mr-2"></i></a></li>
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
                            <p><a href="">Terms of use</a> | <a href="">Privacy Policy</a> Copyright
                                2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
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
                                        <input class="form-control" style="width: 50px;" type="text" placeholder="Enter rating">
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
                                        <input class="form-control" style="width: 50px;" type="text" placeholder="Enter rating">
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
                                        <input class="form-control" style="width: 50px;" type="text" placeholder="Enter rating">
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
                                        <input class="form-control" style="width: 50px;" type="text" placeholder="Enter rating">
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
        @include('employee.footer');
        <script>
            $(document).ready(function() {

                $('.oldkrabtn').click(function() {
                    console.log('dddd');
                    $('#oldkrabox').toggle();
                });
                $('.oldkraclose').click(function() {
                    $('#oldkrabox').toggle();
                });
                $('.oldkrabtnnew').click(function() {
                    console.log('dddd');
                    $('#oldkraboxnew').toggle();
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
            $(document).ready(function() {
                $('#saveDraftBtnNew').click(function() {
                    $('#loader').show();

                    var formData = $('#kraForm').serialize(); // Serialize form data

                    $.ajax({
                        url: "{{ route('kra.saveDraft') }}", // Laravel route
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            $('#loader').hide();
                            // Display success toast
                            toastr.success(response.message, 'Success', {
                                "positionClass": "toast-top-right", // Position it at the top right of the screen
                                "timeOut": 10000 // Duration for which the toast is visible (in ms)
                            });
                            // Optionally, you can hide the modal and reset the form after a delay
                            setTimeout(function() {
                                location.reload();
                            }, 2000); // 2000 milliseconds = 2 seconds
                        },
                        error: function(xhr, status, error) {
                            // Display error toast
                            toastr.error(data.message, 'Error', {
                                "positionClass": "toast-top-right", // Position it at the top right of the screen
                                "timeOut": 5000 // Duration for which the toast is visible (in ms)
                            });
                            $('#loader').hide();
                        }
                    });
                });
            });

            document.getElementById('addRowBtn').addEventListener('click', function() {
                let tableBody = document.querySelector('#kraTable tbody');
                let newRow = document.querySelector('.kraRow').cloneNode(true);

                // Reset input values for the new row
                const inputs = newRow.querySelectorAll('input, select');
                inputs.forEach(input => input.value = '');

                // Ensure that each dynamic row has unique name/id attributes
                const measureSelect = newRow.querySelector('[name="measure[]"]');
                const unitSelect = newRow.querySelector('[name="unit[]"]');
                const periodSelect = newRow.querySelector('[name="period[]"]');
                const weightageInput = newRow.querySelector('[name="weightage[]"]');
                const targetInput = newRow.querySelector('[name="target[]"]');
                const deleteBtn = newRow.querySelector('.deleteRowBtn');

                // Instead of measure_1, unit_1, etc., use measure[], unit[], etc.
                measureSelect.name = 'measure[]';
                unitSelect.name = 'unit[]';
                periodSelect.name = 'period[]';
                weightageInput.name = 'weightage[]';
                targetInput.name = 'target[]';

                // Add delete button functionality
                deleteBtn.addEventListener('click', function() {
                    newRow.remove();
                });

                // Append the new row to the table
                tableBody.appendChild(newRow);
            });

            $(document).ready(function() {
                $('#saveDraftBtnCurr').click(function() {
                    let form = $("#kraFormcurrent")['0']; // Get the form element
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
                $("#addKraBtn").click(function() {
                    addKRA(); // Call function to add new KRA fields dynamically
                });
                $("#addKraBtnn").click(function() {
                    addKRA(); // Call function to add new KRA fields dynamically
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

                    <td><textarea type="text" class="form-control" name="kra[]"  placeholder="Enter KRA" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea></td>
                    <td><textarea type="text" class="form-control" name="kra_description[]" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" placeholder="Enter KRA Description" ></textarea></td>

                    <td>
                    <select name="Measure[]" class="Inputa" style="width:100%; text-align:center;" >
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
                    <select id="Unit[]" name="Unit[]" class="Inputa" style="width:100%; text-align:center;" >
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

                    <td><input type="text" class="Inputa" name="weightage[]" style="width:100%; text-align:center;" placeholder="Enter Weightage" style="width: 69px;" ></td>
                    <td>
                    <select  name="Logic[]" >
                    @foreach($logicData as $logic)
                                                                                                        <option value="{{ $logic->logicMn }}">
                                                                                                            {{ $logic->logicMn }}
                                                                                                        </option>
                                                                                                        @endforeach

                    </select>
                    </td>
                    <td>
                    <select id="Period[]" name="Period[]"  style="width:100%; text-align:center;" >
                    <option value="Annual">Annually</option>
                    <option value="1/2 Annual">Half Yearly</option>
                    <option value="Quarter">Quarterly</option>
                    <option value="Monthly">Monthly</option>
                    </select>
                    </td>

                    <td><input type="text" class="Inputa" name="Target[]" style="width:100%; text-align:center;" placeholder="Enter Target" ></td>
                    
                        <td><button type="button" class="ri-close-circle-fill mr-2 border-0 background-color:unset removeKraBtn"></button></td>

                    `;

                // Append the new row to the table
                kraTable.appendChild(newRow);
            }

            // Remove KRA field when the remove button is clicked
            // $(document).on("click", ".addKraDynamicBtn", function() {
            //     addKRA(); // Calls the function to add a new row dynamically
            // });
            // Remove KRA field when the remove button is clicked
            document.addEventListener("click", function(event) {
                if (event.target.classList.contains("addSubKraBtn")) {
                    let kraId = event.target.getAttribute("data-kra-id");
                    addSubKRA(kraId);
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
                                        <input class="form-control" style="width: 90px;" type="text" placeholder="Enter rating" value="${detail.Ach}" >
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
                            <table class="table" id="subKraTable_${kraId}" style="background-color:#ECECEC; margin-left:20px;">
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
                    <textarea name="subKraName[${kraId}][]" class="form-control" placeholder="Sub KRA Name" rows="2"style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea>
                </td>
                <td>
                    <textarea name="subKraDesc[${kraId}][]" class="form-control" placeholder="Description" rows="2"style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';" ></textarea>
                </td>

                <td>
                    <select name="Measure_subKRA[${kraId}][]" >
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
                    <select name="Unit_subKRA[${kraId}][]" >
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
                <td><input type="text" name="Weightage_subKRA[${kraId}][]" class="form-control" placeholder="Weightage" style="width: 69px;" ></td>
                <td>
                    <select name="Logic_subKRA[${kraId}][]" >
                                                                                                                  @foreach($logicData as $logic)
                                                                                            <option value="{{ $logic->logicMn }}"
                                                                                                >
                                                                                                {{ $logic->logicMn }}
                                                                                            </option>
                                                                                            @endforeach
                    </select>
                </td>
                <td>
                    <select name="Period_subKRA[${kraId}][]"  >
                                                                            <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly" selected="">Monthly</option>
                    </select>
                </td>
                <td><input type="text" name="Target_subKRA[${kraId}][]" class="form-control" placeholder="Target" ></td>
                <td><button type="button" class="ri-close-circle-fill border-0" onclick="removeSubKRA(this)"></button></td>
            `;
            }

            function removeSubKRA(button) {
                let row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);
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

            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('.kra-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            let kraTableBody = document.querySelector("#current_kra tbody"); // Adjust the table ID accordingly

                            // Extract data from the checkbox
                            let kra = this.dataset.kra;
                            let description = this.dataset.description;
                            let measure = this.dataset.measure;
                            let unit = this.dataset.unit;
                            let weightage = this.dataset.weightage;
                            let logic = this.dataset.logic;
                            let period = this.dataset.period;
                            let target = this.dataset.target;

                            // Generate unique ID for KRA
                            let kraId = 'kra_' + Date.now();

                            // Create new row for main KRA table (not sub-KRA)
                            let newRow = `
                        <tr id="${kraId}">
                            <td><b>New</b></td>
                            <td><textarea name="kra[]" class="form-control" style="width:250px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">${kra}</textarea></td>
                            <td><textarea name="kra_description[]" class="form-control" style="width:300px; overflow:hidden; resize:none;min-height:60px;" 
                                                                        oninput="this.style.height='auto'; this.style.height=this.scrollHeight+'px';">${description}</textarea></td>
                            <td><select name="Measure[]" class="form-control">
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
                            </select></td>
                            <td><select name="Unit[]" class="Inputa">
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
                            </select></td>
                            <td><input type="number" name="weightage[]" class="Inputa" value="${weightage}"style="width: 69px;"></td>
                            <td><select name="Logic[]" class="Inputa">
                                @foreach($logicData as $logic)
                                                                                            <option value="{{ $logic->logicMn }}"
                                                                                                >
                                                                                                {{ $logic->logicMn }}
                                                                                            </option>
                                                                                            @endforeach
                            </select></td>
                            <td><select name="Period[]" class="Inputa">
                               <option value="Annual">Annually</option>
                                                                            <option value="1/2 Annual">Half Yearly</option>
                                                                            <option value="Quarter">Quarterly</option>
                                                                            <option value="Monthly" selected="">Monthly</option>
                            </select></td>
                            <td><input type="text" name="Target[]" class="Inputa" value="${target}"></td>
                            <td><button type="button" class="fas fa-trash" onclick="removeRow('${kraId}')"></button></td>
                        </tr>
                    `;

                            kraTableBody.insertAdjacentHTML('beforeend', newRow);
                        }
                    });
                });
            });

            // Function to remove a KRA row
            function removeRow(kraId) {
                document.getElementById(kraId).remove();
            }
            document.querySelector('.kraedit').addEventListener('click', function(e) {
                e.preventDefault();
                // Hide the view form and show the edit form
                document.getElementById('viewForm').style.display = 'none';
                document.getElementById('editForm').style.display = 'block';
                document.getElementById('finalSubmitLi').style.display = 'inline-block'; 
               document.getElementById('oldkraedit').style.display = 'inline-block';
                document.getElementById('saveDraftBtnCurr').style.display = 'inline-block';

            });
            document.querySelector('.addKraBtnedit').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('editForm').style.display = 'block';
                document.getElementById('finalSubmitLi').style.display = 'inline-block'; 
               document.getElementById('oldkraedit').style.display = 'inline-block';
                document.getElementById('saveDraftBtnCurr').style.display = 'inline-block';

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

            .deleteSubKra:hover {
                color: darkred;
                /* Change color on hover */
            }