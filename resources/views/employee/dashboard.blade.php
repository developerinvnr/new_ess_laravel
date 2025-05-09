@include('employee.header')

<body class="mini-sidebar">
@include('employee.sidebar')

<div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
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
                                    <li class="breadcrumb-link active">Dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <!-- Revanue Status Start -->
                <div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>

                    <div class="row">
                    <div id="loader" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            
                                <div class="card chart-card">
                                <div class="card-header">
                                <h4 style="width:100%;" class="has-btn float-start mt-1">Notification 
                                @php
                                        $check_policy = \DB::table('policy_change_details')->where('EmpCode', Auth::user()->EmpCode)->where('CompanyId',Auth::user()->CompanyId)->exists();
                                    @endphp
                                    @if($check_policy)
                                        <a href="#" style="font-size:12px;color:#d33838;" title="Vehicle Policy Migration Calculator" 
                                        class="view-policy-btn"
                                        data-id="{{Auth::user()->EmpCode}}"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewVehiclepolicy" ><span class="blink"><b>Vehicle Policy Migration Calculator</b></span></a>
                                        @endif
                                </h4>
                            
                            </div>
                                    <div class="card-body p-3" style="height:82px;overflow-y:auto;">
                                    <ul class="notification">
                                    @php
                                        $baseUrl = url('/'); // Gets the base URL dynamically
                                        $teamConfirmationUrl = rtrim($baseUrl, '/') . '/teamconfirmation'; // Ensure no double slashes
                                    @endphp
                                                @if($isConfirmationDue)
                                                    <li>
                                                    <a target="_blank" href="{{ $teamConfirmationUrl }}">
                                                            <p style="
                                                                color: red; 
                                                                font-weight: bold; 
                                                                font-size: 12px; 
                                                                display: inline-block;
                                                            ">
                                                                Pending Confirmation
                                                            </p>
                                                        </a>
                                                    </li>
                                                @endif
                                       
                                        <li id="warmWelcomeLink" style="display:none;" >
                                            <a target="_blank" href="https://ess.vnrseeds.co.in/WarmWelCome.php">
                                                <p class="float-start" style="color:red;">Warm Welcome</p>
                                                <img class="new-img-pop" src="images/new.png">
                                            </a>
                                        </li>
                                        @php
                                        $investmentDeclarationsetting = \DB::table('hrm_employee_key')
                                                ->where('CompanyId', Auth::user()->CompanyId)
                                                ->first();
                                        $investmentDeclarationsettingdate = \DB::table('hrm_investdecl_setting')
                                                ->where('CompanyId', Auth::user()->CompanyId)
                                                ->first();
                                        $lastDateTime = $investmentDeclarationsettingdate->LastDateTime ?? null;
                                        $isBeforeDeadline = $lastDateTime ? \Carbon\Carbon::now()->lt(\Carbon\Carbon::parse($lastDateTime)) : false;

                                        @endphp                                        
                                        @if(
                                                $investmentDeclarationsetting &&
                                                $investmentDeclarationsetting->InvestDecl == 'Y' &&
                                                empty($investmentDeclaration) &&
                                                $isBeforeDeadline
                                            )
                                        <li>
                                            <a target="_blank" href="https://vnrseeds.co.in/investment" title="Click to declare your investment">
                                                <p style="color:red; font-weight:bold; font-size:14px; margin:0;" class="blink"> Investment Declaration : FY 2025–26</p>
                                            </a>
                                        </li>
                                        @else
                                        @endif

                                
                                        <li>
                                            <a target="_blank" href="https://vnrdev.in/HR_Mannual/">
                                            <p style="color:blue;">HR Policy Manual</p></a>
                                        </li>
                                        <!-- Passport Expiry Notification -->
                                            @php
                                        // Retrieve the passport expiry date if available
                                        $passportExpiry = Auth::user()->personaldetails->Passport_ExpiryDateTo ?? null;

                                        // Only proceed if the passport expiry date exists and is valid
                                        if ($passportExpiry) {
                                            $passportExpiry = \Carbon\Carbon::parse($passportExpiry);
                                            $currentDate = \Carbon\Carbon::now();

                                            // Normalize both dates to the start of the day
                                            $passportExpiry = $passportExpiry->startOfDay();
                                            $currentDate = $currentDate->startOfDay();

                                            // Calculate the difference in days
                                            $daysLeft = $currentDate->diffInDays($passportExpiry, false);

                                            // Check if the expiry is within 180 days and in the future
                                            $showPassportNotification = $daysLeft <= 180 && $passportExpiry->isFuture();
                                        } else {
                                            // No passport expiry date, do not show notification
                                            $showPassportNotification = false;
                                        }
                                    @endphp


                                        @if($showPassportNotification)
                                        <li>
                                            <p class="has-btn float-start" style="color:red;">Passport Expiring Soon</p>
                                        </li>
                                        @endif

                                        @if($showLetter)

                                                            @if($sqlConf->EmpShow === 'Y')
                                                            <!-- HR Policy Manual -->
                                                                    <li>
                                                                        <a target="_blank" href="https://ess.vnrseeds.co.in/Employee/VeiwConfLetter.php?action=Letter&E={{Auth::user()->EmployeeID}}&C={{Auth::user()->CompanyId}}">
                                                                            <p style="color:blue;">E-Confirmation Letter</p>
                                                                        </a>
                                                                    </li>
                                                            @elseif($sqlConf->EmpShow_Trr === 'Y')
                                                                <!-- E-Confirmation Letter -->
                                                                    <li>
                                                                        <a target="_blank" href="https://ess.vnrseeds.co.in/Employee/VeiwConfLetter.php?action=Letter&E={{Auth::user()->EmployeeID}}&C={{Auth::user()->CompanyId}}">
                                                                            <p style="color:blue;">E-Confirmation Letter</p>
                                                                        </a>
                                                                    </li>
                                                            @elseif($sqlConf->EmpShow_Ext === 'Y')
                                                                <!-- HR Policy Manual -->
                                                                    <li>
                                                                        <a target="_blank" href="https://ess.vnrseeds.co.in/Employee/VeiwConfLetter.php?action=Letter&E={{Auth::user()->EmployeeID}}&C={{Auth::user()->CompanyId}}">
                                                                            <p style="color:blue;">E-Confirmation Postponement Letter</p>
                                                                        </a>
                                                                    </li>
                                                            @endif
                                        
                                        @endif
                                        @if($missingDates->isNotEmpty())
                                        <li>
                                            <p class="has-btn float-start" style="color:red;">
                                                Pending Attendance: 
                                                @foreach($missingDates as $missingDate)
                                                    {{ \Carbon\Carbon::parse($missingDate)->format('d-M') }}
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </p>
                                        </li>
                                    @endif
                                        </ul>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="card chart-card">
                                    <div class="card-header">
                                        <h4 class="has-btn" id="dayName"> <span class="float-end" style="color:#31767a;"
                                                id="currentDateFormate"></span></h4>
                                    </div>
                                    <div class="card-body" style="height:87px;">
                                        <div class="time-sheet-punchin float-start w-100">
                                            <div class="float-start">
                                                <h6>Punch in <span id="punchIn"><b></b></span></h6>
                                            </div>
                                            <div class="float-end">
                                                <h6>Punch Out <span id="punchOut"><b></b></span></h6>
                                            </div>
                                        </div>
                                        <div id="lastUpdated">
                                            <div style="color:#777171; float: left; width: 100%; margin-top:5px;">
                                                <!-- <span class="float-start">Last updated in server <span class="success"><b>Not
                                                            Available</b></span></span> -->
                                                <!-- <span class="float-end">Full Leave - <label class="mb-0 badge badge-secondary" title="" data-original-title="CL" id="leaveType"></label></span> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card chart-card">
                            <div class="card-header current-month">
                                <H4 class="has-btn float-start mt-2"></H4>
                                <div class="float-end form-group s-opt">
                                    <select class="select2 form-control select-opt" id="monthname" fdprocessedid="7n33b9">
                                        <option value="select">Select Month </option>
                                    </select>
                                    <span class="sel_arrow">
                                        <i class="fa fa-angle-down"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="calendar">
                                    <thead>
                                        <tr class="weekday">
                                            <th>Sunday</th>
                                            <th>Monday</th>
                                            <th>Tuesday</th>
                                            <th>Wednesday</th>
                                            <th>Thursday</th>
                                            <th>Friday</th>
                                            <th>Saturday</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card chart-card ">
                            <div class="card-header">
                                <h4 class="has-btn float-start mt-1">My Leave</h4>
                                <!-- <span><a href="{{ route('attendanceView', ['employeeId' => Auth::user()->EmployeeID]) }}"
                                        class="btn-outline secondary-outline mr-2 sm-btn float-end"
                                        fdprocessedid="msm7d">View All</a></span> -->
                            </div>

                            <div class="card-body table-p" id="leave-balance-container">
                                <div class="row" id="leave-balances">
                                    <!-- <div class="col">
                                        <div class="row prooduct-details-box p-1 mb-3 leave-bal">
                                            <div class="col-md-12">
                                                <b>Casual Leave(CL)</b>
                                            </div>
                                            <div class="pie-wrapper" style="margin: 5px; auto;">
                                                <div style="border-color: #659093;" class="arc" data-value="20"></div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>01</b></span></p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                                                <p>BL<br><span class="text-success"><b>05</b></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row prooduct-details-box p-1 mb-3 leave-bal">
                                            <div class="col-md-12">
                                                <b>Sick Leave(SL)</b>
                                            </div>
                                            <div class="pie-wrapper" style="margin: 5px; auto;">
                                                <div style="border-color: #659093;" class="arc" data-value="50"></div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>03</b></span></p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                                                <p>BL<br><span class="text-success"><b>03</b></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row prooduct-details-box p-1 mb-3 leave-bal">
                                            <div class="col-md-12">
                                                <b>Privilege Leave(PL)</b>
                                            </div>
                                            <div class="pie-wrapper" style="margin: 5px; auto;">
                                                <div style="border-color: #659093;" class="arc" data-value="60"></div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>04</b></span></p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                                                <p>BL<br><span class="text-success"><b>03</b></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row prooduct-details-box p-1 mb-3 leave-bal">
                                            <div class="col-md-12">
                                                <b>Earn Leave(EL)</b>
                                            </div>
                                            <div class="pie-wrapper" style="margin: 5px; auto;">
                                                <div style="border-color: #659093;" class="arc" data-value="10"></div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>04</b></span></p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                                                <p>BL<br><span class="text-success"><b>20</b></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="row prooduct-details-box p-1 mb-3 leave-bal">
                                            <div class="col-md-12">
                                                <b>Festival Leave(FL)</b>
                                            </div>
                                            <div class="pie-wrapper" style="margin: 5px; auto;">
                                                <div style="border-color: #659093;" class="arc" data-value="0"></div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>00</b></span></p>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                                                <p>BL<br><span class="text-success"><b>02</b></span></p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>


                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">VNR Impact
                                    <span><a href="{{ route('impact') }}"
                                            class="btn-outline secondary-outline mr-2 sm-btn float-end"
                                            fdprocessedid="msm7d">View All</a></span>
                                </h4>
                            </div>
                            <div class="card-body">
                            <div class="">
                                <div class="p-3 border">
                                    <div id="carouselImpact" class="carousel slide carousel-fade text-center" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php

                                            // Fetch data from the database
                                            $impactDocuments = DB::table('hrm_impact_document')
                                                ->orderBy('ImpactId', 'desc')
                                                ->get();

                                            // Group items into chunks of 6 for each carousel item
                                            $chunks = $impactDocuments->chunk(6);
                                            $isActive = true; // Track the active carousel item

                                            foreach ($chunks as $chunk) {
                                                echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . ' row">';
                                                $isActive = false;

                                                foreach ($chunk as $item) {
                                                    echo '
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6 float-start">
                                                        <a title="Volume ' . htmlspecialchars($item->IVal) . '" href="https://vnrseeds.co.in/AdminUser/VnrImpact/' . htmlspecialchars($item->IDocName) . '" target="_blank">
                                                            <img class="d-block w-100 p-3" src="https://vnrseeds.co.in/AdminUser/VnrImpact/' . htmlspecialchars($item->IImg) . '" alt="Volume-' . htmlspecialchars($item->IVal) . '">
                                                        </a>
                                                        <h6 class="mt-2">Volume - ' . htmlspecialchars($item->IVal) . '</h6>
                                                    </div>';
                                                }

                                                echo '</div>';
                                            }
                                            ?>
                                        
                                    </div>
                                        <a class="carousel-control-prev" href="#carouselImpact" role="button" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselImpact" role="button" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        <div class="card chart-card">
                            <div class="card-header" id="celebration">
                                <h4 class="has-btn float-start">
                                </h4>
                                <!-- <span><a href="{{ route('allcelebration') }}"
                                    class="btn-outline secondary-outline mr-2 sm-btn float-end"
                                    fdprocessedid="msm7d">View All</a></span> -->
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div id="birthdayContainer" class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-3">
                                        <div class="p-3 border" style="height:300px;">
                                            <h5 class="p-3" style="background-color: #c4d6d7;">Happy Birthday</h5>
                                            <div id="carouselExampleFadeBirthday" class="carousel slide carousel-fade"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <a class="carousel-control-prev" href="#carouselExampleFadeBirthday"
                                                    role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFadeBirthday"
                                                    role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button id="birthdayViewAllBtn" type="button"
                                            class="btn-outline secondary-outline mt-3 mr-2 sm-btn"
                                            data-bs-toggle="modal" data-bs-target="#model5">View All</button>
                                    </div>
                                    <div id="marriageContainer" class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-3">
                                        <div class="p-3 border" style="height:300px;">
                                            <h5 class="p-3" style="background-color: #c4d6d7;">Marriage Anniversary</h5>
                                            <div id="carouselExampleFadeAnniversary"
                                                class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <a class="carousel-control-prev" href="#carouselExampleFadeAnniversary"
                                                    role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFadeAnniversary"
                                                    role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button id="anniversaryViewAllBtn" type="button"
                                            class="btn-outline secondary-outline mt-3 mr-2 sm-btn"
                                            data-bs-toggle="modal" data-bs-target="#model5">View All </button>
                                    </div>
                                    <div id="joiningContainer" class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mb-3">
                                        <div class="p-3 border" style="height:300px;">
                                            <h5 class="p-3" style="background-color: #c4d6d7;">Corporate Anniversary</h5>
                                            <div id="carouselExampleFadeJoinning" class="carousel slide carousel-fade"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <a class="carousel-control-prev" href="#carouselExampleFadeJoinning"
                                                    role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFadeJoinning"
                                                    role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button id="joiningViewAllBtn" type="button"
                                            class="btn-outline secondary-outline mt-3 mr-2 sm-btn"
                                            data-bs-toggle="modal" data-bs-target="#model5">View All </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <!----Right side --->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                    @php
                            $policyNumbers = [
                                1 => [
                                    'health' => '612332428120000005',
                                    'term' => '00013330',
                                ],
                                3 => [
                                    'health' => '612332428120000006',
                                    'term' => '00013331',
                                ],
                            ];

                            $companyId = Auth::user()->CompanyId;
                        @endphp

                        @if (in_array($companyId, [1, 3]))
                            <div class="card chart-card">
                                <div class="card-header">
                                    <h4 class="has-btn float-start">Policy Number</h4>
                                </div>
                                <div class="card-body">
                                    <h5>
                                        Group Health Insurance Policy No:
                                        <span style="float:right;color:#FF5733;font-weight:bold;">
                                            {{ $policyNumbers[$companyId]['health'] }}
                                        </span>
                                    </h5>
                                    <h5 class="mt-1">
                                        Group Term Insurance Policy No:
                                        <span style="float:right;color:#FF5733;font-weight:bold;">
                                            {{ $policyNumbers[$companyId]['term'] }}
                                        </span>
                                    </h5>
                                </div>
                            </div>
                        @endif
                       @php
                            $leaveRequestCount = count($leaveRequests);
                            $attendanceRequestCount = count($attRequests);
                            $queryRequestCount = count($employeeQueryData);
                        @endphp

                        @if ($leaveRequestCount > 0 || $attendanceRequestCount > 0 || $queryRequestCount > 0)
                            <div class="card chart-card" id="leaveRequestCard">
                                <div class="card-header" id="cardheaderrequest">
                                    <h4 class="has-btn">My Request</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-3" role="tablist">
                                        <li class="nav-item my-req-link" role="presentation" data-leave-count="{{ $leaveRequestCount }}">
                                            <a style="padding:3px 10px;margin-right:2px;" class="nav-link active" data-bs-toggle="tab" href="#LeaveRequestList" role="tab" aria-selected="true">
                                                Leave <sup style="font-size: 0.7rem; padding: 0.2em 0.4em;" class="badge bg-info">{{ $leaveRequestCount }}</sup>
                                            </a>
                                        </li>

                                        <li class="nav-item my-req-link" role="presentation" data-attendance-count="{{ $attendanceRequestCount }}">
                                            <a style="padding:3px 10px;margin-right:2px;" class="nav-link" data-bs-toggle="tab" href="#AttendanceRequestlist" role="tab" aria-selected="false" tabindex="-1">
                                                Attendance <sup style="font-size: 0.7rem; padding: 0.2em 0.4em;" class="badge bg-danger">{{ $attendanceRequestCount }}</sup>
                                            </a>
                                        </li>

                                        <li class="nav-item my-req-link" role="presentation" data-query-count="{{ $queryRequestCount }}">
                                            <a style="padding:3px 10px;margin-right:2px;" class="nav-link" data-bs-toggle="tab" href="#QueryRequestList" role="tab" aria-selected="false" tabindex="-1">
                                                Query <sup style="font-size: 0.7rem; padding: 0.2em 0.4em;" class="badge bg-warning">{{ $queryRequestCount }}</sup>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content text-muted">
                                        <div class="tab-pane active" id="LeaveRequestList" role="tabpanel">
                                            <div class="my-request"></div>
                                        </div>
                                        <div class="tab-pane" id="QueryRequestList" role="tabpanel">
                                            <div class="query-request-box">
                                                @if($employeeQueryData->isEmpty())
                                                    <p>No query requests available for the current month.</p>
                                                @else
                                                    @foreach($employeeQueryData as $query)
                                                        <div class="query-req-section mb-3">
                                                            <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                                                                <span class="float-start"><b>Dept.: {{ $query->DepartmentName }}</b></span>
                                                                <span class="float-start"><b>Sub: {{ $query->SubjectName }}</b></span>
                                                            </div>
                                                            <div class="mb-2">
                                                                <p>{{ $query->QuerySubject }}</p>
                                                            </div>
                                                            <div class="w-100" style="font-size:11px;">
                                                                <span class="me-3"><b>Raise to:</b> {{ \Carbon\Carbon::parse($query->QueryDT)->format('d M Y') }}</span>
                                                                <span><b>Status:</b> 
                                                                    @if($query->QStatus == 0)
                                                                        <span class="warning"><b>Pending</b></span>
                                                                    @elseif($query->QStatus == 1)
                                                                        <span class="success"><b>Approved</b></span>
                                                                    @else
                                                                        <span class="danger"><b>Rejected</b></span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="AttendanceRequestlist" role="tabpanel">
                                            <div class="attendance-request-box">
                                                @if($attRequests->isEmpty())
                                                    <p>No attendance requests available for the current month.</p>
                                                @else

                                                    @foreach($attRequests as $request)
                                                        <div class="atte-req-section mb-3">
                                                            <div style="width:100%;">
                                                                <span class="me-3"><b><small>{{ \Carbon\Carbon::parse($request->RequestAttDate)->format('d/m/Y') }}</small></b></span>
                                                                <span style="padding: 4px 8px; font-size: 10px; margin-left: 5px; margin-top: -1px; cursor: default; pointer-events: none;" 
                                                                    class="mb-0 sm-btn effect-btn btn 
                                                                            @if($request->InStatus == 2 || $request->OutStatus == 2 || $request->SStatus == 2) btn-success 
                                                                            @elseif($request->InStatus == 3 || $request->OutStatus == 3 || $request->SStatus == 3) btn-secondary 
                                                                            @else btn-warning @endif 
                                                                    float-end" 
                                                                    title="{{ ($request->InStatus == 2 || $request->OutStatus == 2 || $request->SStatus == 2) ? 'Approved' : 
                                                                            (($request->InStatus == 3 || $request->OutStatus == 3 || $request->SStatus == 3) ? 'Rejected' : 'Pending') }}">
                                                                    {{ ($request->InStatus == 2 || $request->OutStatus == 2 || $request->SStatus == 2) ? 'Approved' : 
                                                                        (($request->InStatus == 3 || $request->OutStatus == 3 || $request->SStatus == 3) ? 'Rejected' : 'Pending') }}
                                                                </span>

                                                            </div>
                                                            <div style="width:100%;">
                                                                <span class="danger"><small>Punch In: <b>{{ $request->Inn }}</b></small></span>
                                                                <span class="float-end"><small>Punch Out: <b>{{ $request->Outt }}</b></small></span>
                                                            </div>
                                                            <div style="width:100%;">
                                                                <span class="me-3"><small>Reason: <b>{{ $request->ReqRemark ?: 'N/A' }}</b></small></span>
                                                                <span class=""><small>Remarks: {{ $request->ReqInRemark ?: $request->ReqOutRemark ?: 'N/A' }}</small></span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="card ad-info-card-" id="requestcardsattendance">
                            <div class="card-header">
                                <h5><b>Team: Attendance Approval</b></h5>
                            </div>
                            <div class="card-body" id="requestCards" style="overflow-y: scroll; overflow-x: hidden;">
                                <div class="p-3 mb-3" style="border:1px solid #ddd;">
                                </div>
                                <div class="tree col-md-12 text-center mt-4">
                                </div>
                            </div>
                        </div>

                        <div class="card ad-info-card-" id="leavemainrequest">
                            <div class="card-header">
                                <!-- <img style="width:35px;" class="float-start me-3" src="./images/icons/icon3.png"> -->
                                <h5><b>Leave approval for my teams</b></h5>
                            </div>

                            <div class="card-body" id="leaveRequestsContainer" style="overflow-y: scroll; overflow-x: hidden;">
                                <div class="p-3 mb-3" style="border:1px solid #ddd;">
                                </div>
                                <div class="tree col-md-12 text-center mt-4">
                                </div>
                            </div>
                        </div>
                        <div class="card chart-card ">
                            <div class="card-header">
                                <h4 class="has-btn float-start">Query</h4>
                            </div>
                            <div class="card-body" style="height: 300px;overflow-y: auto;">
                                <div id="message" class="alert" style="display: none;"></div>
                                <form id="queryForm" action="{{ route('querysubmit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="employee_id" value="{{ Auth::user()->EmployeeID }}">

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <p style="color:#999;">CC to your reporting manager & HOD</p>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name" class="col-form-label"><b>Select Department
                                                        Name <span class="danger">*</span></b></label>
                                                <select class="select2 form-control select-opt" id="Department_name"
                                                    name="Department_name">
                                                    <option value="" disabled selected>Select Department</option>
                                                    

                                                    @foreach ($query_department_list as $department)
                                                        <option value="{{ $department->id }}">{{
                                                        $department->department_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="sel_arrow">
                                                    <i class="fa fa-angle-down"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name_sub" class="col-form-label"><b>Select
                                                        Subject <span class="danger">*</span></b></label>
                                                <select class="select2 form-control select-opt" id="Department_name_sub"
                                                    name="Department_name_sub">
                                                    <option value="" disabled selected>Select Subject</option>
                                                  

                                                    @foreach ($departments_sub as $department_sub)
                                                        <option value="{{ $department_sub->DeptQSubject }}"
                                                            id-sub_department="{{ $department_sub->DeptQSubId }}"
                                                            data-department="{{ $department_sub->DepartmentId }}">
                                                            {{ $department_sub->DeptQSubject }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="sel_arrow">
                                                    <i class="fa fa-angle-down"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <!-- <label for="remarks" class="col-form-label"><b>Remarks</b></label> -->
                                                <textarea style="min-height:35px;" class="form-control" placeholder="Enter your remarks"
                                                    id="remarks" name="remarks"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="checkbox">
                                                <input id="checkbox3" type="checkbox" name="hide_name">
                                                <label for="checkbox3"
                                                    style="padding-top:4px;font-size:11px;color:#646262;">Do you want to
                                                    hide your name from Reporting
                                                    Manager & HOD?</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button class="btn btn-success" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- current opening block to be added  -->

@php
                            $job_opening_json = file_get_contents('https://hrrec.vnress.in/get_job_opening');
                            
                            $job_opening = json_decode($job_opening_json, true); // Decode as an associative array
                            if ($job_opening === null && json_last_error() !== JSON_ERROR_NONE) {
                                echo "Error decoding JSON: " . json_last_error_msg();
                                return; // Stop further processing if there's an error
                            }
                        @endphp

                        <div class="card ad-info-card-">
                            <div class="card-header">
                                <h5><b>Current Openings</b></h5>
                            </div>
                            <div class="card-body" style="height: 535px; overflow-y: scroll; overflow-x: hidden;">
                                @foreach($job_opening['regular_job'] as $index => $job)
                                                                <div class="card p-3 mb-3 current-opening">
                                                                    <div>
                                                                        <span class="me-3"><b><small>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}.
                                                                                    {{ $job['title'] }}</small></b></span>
                                                                        <a href="#" style="border-radius:3px;" class="link btn-link p-0"
                                                                                    data-bs-toggle="modal" data-bs-target="#currentOpening"
                                                                                    data-jpid="{{ $job['jpid'] }}">View</a>
                                                                        <a target="_blank" href="{{ $job['link'] }}" style="border-radius:3px;"
                                                                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1 me-2">
                                                                            <small><b>Apply</b></small>
                                                                        </a>
                                                                    </div>
                                                                    <p><small class="d-none"> {{ strip_tags($job['description']) }}
                                                                        </small></p>
                                                                    <div>
                                                                        <span class="me-3"><b><small>Dept.- {{ $job['department'] }}</small></b></span>

                                                                        @php
                                                                            $locations = $job['location'] ?? 'NULL'; // Get the location string
                                                                            $locationsArray = explode(',', $locations); // Split into an array
                                                                            $firstLocation = $locationsArray[0] ?? 'NULL'; // Get the first element or 'NULL' if it doesn't exist
                                                                        @endphp

                                                                        <span class='me-3 float-end'><b><small><i
                                                                                        class='fas fa-map-marker-alt me-2'></i>
                                                                                    {{ $firstLocation }}</small></b></span>
                                                                    </div>
                                                                </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- current opening end  -->
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">
                        <div class="row mb-4 mt-4 footer-logo-link">
                            <div class="col">

                            </div>
                            <div class="col" style="border-right:1px solid #ddd;">
                                <a target="_blank" href="https://expense.vnrseeds.co.in/login.php"><img src="images/link/Ellipse-6.png" alt=""></a>
                                <br><span>Xeasy</span>
                            </div>
                            <div class="col" style="border-right:1px solid #ddd;">
                                <a target="_blank" href="https://vnrdev.in/HR_Mannual/"><img src="images/link/hr-policy.png" alt=""></a>
                                <br><span>HR POLICY</span>
                            </div>
                            <div class="col">
                                <a target="_blank" href="https://samadhaan.vnrseeds.in/login"><img src="images/link/Ellipse-9.png" alt=""></a>
                                <br><span>Samadhaan</span>
                            </div>
                             <div class="col">
                                <a target="_blank" href="https://hrrec.vnress.in"><img src="images/link/recruitment.png" alt=""></a>
                                <br><span>Recruitment</span>
                            </div>
                            @if($display_ojas)
                            <div class="col">
                                <a target="_blank" href="{{route('ojas_access')}}"><img src="images/link/ojas.png" alt=""></a>
                                <br><span>Ojas</span>
                            </div>
                            @endif
                            <div class="col">

                            </div>
                        </div>
                    </div>
                </div>

                @include('employee.footerbottom')
            </div>
        </div>
    </div>


   <!--Approval Message-->
<div class="modal fade show" id="approvalpopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Approval Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="mb-0 badge badge-secondary leave-type"></label>
                    <span class="me-3 ms-2 bold date-range"></span>
                    <span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1 total-days"></span>
                </div>
                <p><span class="leave-status"></span></p>
                <p class="leave-reason"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

   <!--Approval Message-->
   <div class="modal fade show" id="approvalpopupdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Leave Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-2">
                    <label class="mb-0 badge badge-secondary leave-type-details"></label>
                    <span class="me-3 ms-2 bold date-range"></span>
                    <span style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1 total-days"></span>
                </div>
                <p><b>Leave Approval Status: </b><span class="leave-status-details"></span></p>
                <p><b>Leave Reason: </b><span class="leave-reason-details"></span></p>
                <p><b>Contact Number: </b><span class="leave-contact-details"></span></p>
                <p><b>Address: </b><span class="leave-address-details"></span></p>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal for Best Wishes -->
    <div class="modal fade" id="wishesModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="wishesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wishesModalLabel">Wishes From Your Side</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeWishesModalBtn"></button>
                    </div>
                <div class="modal-body">
                    <h5 class="mb-2 float-start" style="width:80%;" id="modalEmployeeName"> </h5>
                    <b class="float-end" style="color:#3c6b70;font-size:12px;margin-bottom:5px;" id="modalEmployeeDate"></b>
                    <br>
                    Your Message
                    <textarea id="modalMessage" class="form-control" rows="3"
                        placeholder="Write your message here..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" id="sendWishBtn" class="btn btn-primary">Send Wishes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Structure - with dynamic ID -->
<div class="modal fade" id="approvalpopup-${leaveRequest.LeaveId}" tabindex="-1" aria-labelledby="approvalpopupLabel-${leaveRequest.LeaveId}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalpopupLabel-${leaveRequest.LeaveId}">Leave Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Leave Type:</strong> <span id="modal-leave-type-${leaveRequest.LeaveId}"></span>
                </div>
                <div class="mb-3">
                    <strong>From Date:</strong> <span id="modal-from-date-${leaveRequest.LeaveId}"></span>
                </div>
                <div class="mb-3">
                    <strong>To Date:</strong> <span id="modal-to-date-${leaveRequest.LeaveId}"></span>
                </div>
                <div class="mb-3">
                    <strong>Total Days:</strong> <span id="modal-total-days-${leaveRequest.LeaveId}"></span>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong> <span id="modal-status-${leaveRequest.LeaveId}"></span>
                </div>
                <div class="mb-3">
                    <strong>Reason:</strong> <span id="modal-reason-${leaveRequest.LeaveId}"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



    <!-- Modal for job details -->
    <div class="modal fade" id="currentOpening" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalJobTitle">Job Title</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-sm">
                        <tbody>
                            <tr>
                                <td style="width:200px;">Job Code</td>
                                <td id="modalJobCode"></td>
                            </tr>
                            <tr>
                                <td>Job Category</td>
                                <td id="modalJobDepartment"></td>
                            </tr>
                            <tr>
                                <td>Job Description</td>
                                <td id="modalJobDescription"></td>
                            </tr>
                            <tr>
                                <td>Education Qualification</td>
                                <td id="modalJobEducation"></td>
                            </tr>
                            <tr>
                                <td>Work Experience</td>
                                <td id="modalJobWorkExperience"></td>
                            </tr>
                            <tr>
                                <td>Salary</td>
                                <td id="modalJobSalary"></td>
                            </tr>
                            <tr>
                                <td>Job Location</td>
                                <td id="modalJobLocation"></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <a href="#" id="applyLink" class="btn btn-sm btn-primary">Apply Now</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Birthday Modal -->
    <div class="modal fade" id="model5" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="celebrationTitle"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <p class="text-center warning">“Your birthday is the first day of another 365-day journey. Enjoy the
                        ride.”</p> -->
                    <div class="row" id="modalBirthdayContainer"></div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <!--Health card popup-->
    <div class="modal fade show" id="healthcard" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">E-Health Card</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>

                            <tr>
                                <td>1.</td>
                                <td>Emp. Name</td>
                                <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a
                                        class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Emp. wife name</td>
                                <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a
                                        class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Child 1</td>
                                <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a
                                        class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Child 2</td>
                                <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a
                                        class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--warm welcome --->
    <div class="modal fade show" id="warmwelcome" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Welcome to VNR</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="width:100">
                        <div class="col-md-2 mb-2">
                            <img style="border:1px solid #ddd;padding:5px;" src="images/users.png">
                        </div>
                        <div class="col-md-10 mb-2">
                            <h4>Rajesh Kumar</h4>
                            <p>tesyvdjv dvksdjd nhkjdsvh</p>
                        </div>
<hr>
                        <div class="col-md-2 mb-2">
                            <img style="border:1px solid #ddd;padding:5px;" src="images/users.png">
                        </div>
                        <div class="col-md-10 mb-2">
                            <h4>Rajesh Kumar</h4>
                            <p>tesyvdjv dvksdjd nhkjdsvh</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
     <!--Attendence Authorisation-->
    <!-- resources/views/attendance/authorization.blade.php -->
    <div class="modal fade" id="AttendenceAuthorisation" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        >
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color:#a9cbcd;">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- <p id="attendanceMessage" class="text-warning" style="display: none;">Attendance Already Applied</p> -->

                    <p id="responseMessage" class="text-success" style="display: none;"></p>

                    <p>This option is only for missed attendance or late In-time/early out-time attendance and not for
                        leave applications. <span class="text-danger">Do not apply leave here.</span></p>
                    <br>
                    <p><span id="request-date"></span></p>
                    <form id="attendanceForm" method="POST" action="{{ route('attendance.authorize') }}">
                        @csrf
                        <div class="mt-2" id="request-date"></div>
                        <input type="hidden" id="employeeid" name="employeeid">
                        <input type="hidden" id="Atct" name="Atct">
                        <input type="hidden" id="requestDate" name="requestDate">

                        <!-- New Fields for additional data -->
                        <div class="form-group" id="inreasonreqGroup" style="display: none;">
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <input type="text" name="inreasonreq" class="form-control" id="inreasonreq"
                                placeholder="Enter In Reason Request">
                        </div>


                        <div class="form-group" id="outreasonreqGroup" style="display: none;">
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <input type="text" name="outreasonreq" class="form-control" id="outreasonreq"
                                placeholder="Enter Out Reason Request">
                        </div>


                        <div class="form-group" id="reasonreqGroup" style="display: none;">
                            <label class="col-form-label"><b>Other Reason:</b></label>
                            <input type="text" name="reasonreq" class="form-control" id="reasonreq"
                                placeholder="Enter Other Reason Request">
                        </div>

                        <!-- end of new fields -->

                        <div class="form-group s-opt" id="reasonInGroup" style="display: none;">
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <select name="reasonIn" class="select2 form-control select-opt" id="reasonInDropdown">
                                <!-- <option value="">Select Reason</option> -->

                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>

                        <div class="form-group" id="remarkInGroup" style="display: none;">
                            <label class="col-form-label"><b>In Remark:</b></label>
                            <textarea type="text" name="remarkIn" class="form-control" id="remarkIn"
                                placeholder="Enter your in remark" maxlength="150"></textarea>
                        </div>

                        <div class="form-group s-opt" id="reasonOutGroup" style="display: none;">
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <select name="reasonOut" class="select2 form-control select-opt" id="reasonOutDropdown">
                                <!-- <option value="">Select Reason</option> -->

                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>

                        <div class="form-group" id="remarkOutGroup" style="display: none;">
                            <label class="col-form-label"><b>Out Remark:</b></label>
                            <textarea type="placeholder" name="remarkOut" class="form-control" id="remarkOut"
                                placeholder="Enter your out remark" maxlength="150"></textarea>
                        </div>
                        <div class="form-group s-opt" id="otherReasonGroup" style="display: none;">
                            <label class="col-form-label"><b>Other Reason:</b></label>
                            <select name="otherReason" class="select2 form-control select-opt" id="otherReasonDropdown">
                                <!-- <option value="">Select Reason</option> -->
                                <!-- Options will be populated dynamically -->
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>


                        <div class="form-group" id="otherRemarkGroup" style="display: none;">
                            <label class="col-form-label"><b>Other Remark:</b></label>
                            <textarea  name="otherRemark" class="form-control" id="otherRemark"
                                placeholder="Enter your other remarks" maxlength="150"></textarea>
                        </div>


                        <div class="form-group" id="reportingremarkreqGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting Remark:</b></label>
                            <textarea name="reportingremarkreq" class="form-control" id="reportingremarkreq"
                                placeholder="reporting remark req" maxlength="150"></textarea>
                        </div>

                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">

                    <button type="button" class="btn btn-primary" id="sendButton">Submit</button>
                </div>
            </div>
        </div>
    </div>

     <!--Attendence Authorisation modal for reporting-->
     <div class="modal fade" id="AttendenceAuthorisationRequest" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p><b><span id="request-date-repo"></span></b></p>
                    <form id="attendance-form" method="POST" action="">
                        <input type="hidden" id="employeeIdInput" name="employeeId">

                        @csrf
                        <div class="form-group mb-0" id="reasonInGroupReq" style="display: none;">
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <input type="text" id="reasonInDisplay" class="form-control" style="border: none; background: none;" readonly>

                        </div>
                        <div class="form-group  mb-0" id="remarkInGroupReq" style="display: none;">
                            <label class="col-form-label"><b>In Remark:</b></label>
                            <input type="text" name="remarkIn" class="form-control" id="remarkInReq" readonly>
                        </div>
                        <div class="form-group s-opt" id="statusGroupIn" style="display: none;">
                            <label class="col-form-label"><b>In Status:</b></label>
                            <select name="inStatus" class="select2 form-control select-opt" id="inStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkInGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting In Remark:</b></label>
                            <textarea name="reportRemarkIn" class="form-control" id="reportRemarkInReq" placeholder="Enter your remarks" maxlength="150"></textarea>
                        </div>
                        
                        <div class="form-group  mb-0" id="reasonOutGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <input type="text" id="reasonOutDisplay" class="form-control"
                                style="border: none; background: none;"></input>
                        </div>

                        <div class="form-group  mb-0" id="remarkOutGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Out Remark:</b></label>
                            <input type="text" name="remarkOut" class="form-control" id="remarkOutReq" readonly>
                        </div>
                        <div class="form-group s-opt" id="statusGroupOut" style="display: none;">
                            <label class="col-form-label"><b>Out Status:</b></label>
                            <select name="outStatus" class="select2 form-control select-opt" id="outStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkOutGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting Out Remark:</b></label>
                            <textarea name="reportRemarkOut" class="form-control" id="reportRemarkOutReq" maxlength="150" placeholder="Enter your remarks"></textarea>
                        </div>

                        

                        <div class="form-group  mb-0" id="reasonOtherGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Reason:</b></label>
                            <input type="text" id="reasonOtherDisplay" class="form-control"
                                style="border: none; background: none;" readonly>
                        </div>

                        <div class="form-group mb-0" id="remarkOtherGroupReq" style="display: none;">
                            <label class="col-form-label"><b>Remark:</b></label>
                            <input type="text" name="remarkOther" class="form-control" id="remarkOtherReq" readonly>
                        </div>
                        <div class="form-group  mb-0 s-opt" id="statusGroupOther" style="display: none;">
                            <label class="col-form-label"><b>Other Status:</b></label>
                            <select name="otherStatus" class="select2 form-control select-opt" id="otherStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkOtherGroup" style="display: none;">
                            <label class="col-form-label"><b>Reporting Other Remark:</b></label>
                            <textarea name="reportRemarkOther" class="form-control" id="reportRemarkOtherReq" maxlength="150" placeholder="Enter your remarks"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-primary" id="sendButtonReq">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- narayan sir block  -->
    <!-- <div class="modal fade" id="AttendenceAuthorisationRequest" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><span id="request-date-repo"></span></p>
                    <form id="attendance-form" method="POST" action="">
                        <input type="hidden" id="employeeIdInput" name="employeeId">

                        @csrf
                        
                        <div class="form-group" id="reasonInGroupReq" style="display: none;">
                            <label class="col-form-label">Reason In:</label>
                            <span id="reasonInDisplay" class="form-control"
                                style="border: none; background: none;"></span>
                        </div>
                        <div class="form-group" id="remarkInGroupReq" style="display: none;">
                            <label class="col-form-label">Remark In:</label>
                            <input type="text" name="remarkIn" class="form-control" id="remarkInReq" >
                        </div>
                        <div class="form-group s-opt" id="statusGroupIn" style="display: none;">
                            <label class="col-form-label">In Status:</label>
                            <select name="inStatus" class="select2 form-control select-opt" id="inStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reportRemarkInGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark In:</label>
                            <input type="text" name="reportRemarkIn" class="form-control" id="reportRemarkInReq">
                        </div>
                        <div class="form-group s-opt" id="statusGroupOut" style="display: none;">
                            <label class="col-form-label">Out Status:</label>
                            <select name="outStatus" class="select2 form-control select-opt" id="outStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>
                        <div class="form-group" id="reasonOutGroupReq" style="display: none;">
                            <label class="col-form-label">Reason Out:</label>
                            <span id="reasonOutDisplay" class="form-control"
                                style="border: none; background: none;"></span>
                        </div>

                        <div class="form-group" id="remarkOutGroupReq" style="display: none;">
                            <label class="col-form-label">Remark Out:</label>
                            <input type="text" name="remarkOut" class="form-control" id="remarkOutReq" readonly>
                        </div>
                        <div class="form-group" id="reportRemarkOutGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark Out:</label>
                            <input type="text" name="reportRemarkOut" class="form-control" id="reportRemarkOutReq">
                        </div>
                        <div class="form-group s-opt" id="statusGroupOther" style="display: none;">
                            <label class="col-form-label">Other Status:</label>
                            <select name="otherStatus" class="select2 form-control select-opt" id="otherStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <span class="sel_arrow">
                                <i class="fa fa-angle-down"></i>
                            </span>
                        </div>

                        <div class="form-group" id="reasonOtherGroupReq" style="display: none;">
                            <label class="col-form-label">Reason :</label>
                            <span id="reasonOtherDisplay" class="form-control"
                                style="border: none; background: none;"></span>
                        </div>

                        <div class="form-group" id="remarkOtherGroupReq" style="display: none;">
                            <label class="col-form-label">Remark :</label>
                            <input type="text" name="remarkOther" class="form-control" id="remarkOtherReq" readonly>
                        </div>

                        <div class="form-group" id="reportRemarkOtherGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark Other:</label>
                            <input type="text" name="reportRemarkOther" class="form-control" id="reportRemarkOtherReq">
                        </div>

                        
                    </form>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-primary" id="sendButtonReq">Send</button>
                </div>
            </div>
        </div>
    </div> -->
    <!-- LeaveAuthorization modal  -->
    <!-- <div class="modal fade" id="LeaveAuthorisation" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Leave Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="responseMessageleave" style="display: none;"></p>
                    <form id="leaveAuthorizationForm" method="POST" action="{{ route('leave.authorize') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="employeename" class="col-form-label">Employee Name:</label>
                                <input type="text" name="employeename" class="form-control" id="employeename" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="leavetype" class="col-form-label">Leave Type:</label>
                                <input type="text" name="leavetype" class="form-control" id="leavetype" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="from_date" class="col-form-label">From Date:</label>
                                <input type="text" name="from_date" class="form-control" id="from_date" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="to_date" class="col-form-label">To Date:</label>
                                <input type="text" name="to_date" class="form-control" id="to_date" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="total_days" class="col-form-label">Total Days:</label>
                                <input type="text" name="total_days" class="form-control" id="total_days" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="leavereason" class="col-form-label">Leave Reason:</label>
                                <input type="text" name="leavereason" class="form-control" id="leavereason" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="leavetype_day" class="col-form-label">Leave Option:</label>
                                <input type="text" name="leavetype_day" class="form-control" id="leavetype_day"
                                    readonly>
                            </div>
                            <div class="col-md-6 form-group s-opt" id="statusGroupIn">
                                <label class="col-form-label">Status:</label>
                                <select name="Status" class="select2 form-control select-opt" id="StatusDropdown">
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                <span class="sel_arrow">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="remarks" class="col-form-label">Remarks:</label>
                                <input type="text" name="remarks_leave" class="form-control" id="remarks_leave"
                                    placeholder="Enter your remarks">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendButtonleave">Send</button>
                </div>
            </div>
        </div>
    </div> -->

   	<!-- LeaveAuthorization modal  -->
		<div class="modal fade" id="LeaveAuthorisation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Leave Authorization</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="responseMessageleave" style="display: none;"></p>

                <form id="leaveAuthorizationForm" method="POST" action="{{ route('leave.authorize') }}">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div style="border-bottom:1px solid #ddd;float:left;width:100%;">
                                <span style="float:left;margin-top:5px;font-size:13px;font-weight:600;" id="employeename"></span>
                                <div style="float:right;">
                                    <label for="leavetype" class="col-form-label">Leave Type:</label>
                                    <span class="mb-0 badge" style="background-color: rgb(100, 177, 255);" id="leavetype"></span>
                                </div>
                            </div>
                            <div class="float-start" style="width:100%;">
                                <div class="float-start">
                                    <label for="from_date" class="col-form-label"><b>Date:</b></label>
                                    <span style="color: #236c74;" class="ml-2 mr-2" id="from_date"></span> To <span style="color: #236c74;" class="ml-2 mr-2" id="to_date"></span>
                                </div>
                                <div class="float-end">
                                    <label for="total_days" class="col-form-label"><b>Total Days:</b></label>
                                    <span style="color:#d51f1f;font-size:13px;font-weight:600;" id="total_days"></span> 
                                </div>
                            </div>
                            <div>
                                <label for="leavetype_day" class="col-form-label" id="leavetype_label"><b>Leave Option:</b></label>
                                <span style="text-transform: capitalize;font-weight:600;" id="leavetype_day"></span>
                            </div>
                            <div class="float-start mt-0" style="width:100%;">
                                <label for="leavereason" class="col-form-label float-start"><b>Leave Reason:</b></label>
                            </div>
                            <span style="font-weight:400;" id="leavereason"></span>
                            
                        </div>
                        <div class="col-md-12 mt-3" id="statusGroupIn">
                            <label class="col-form-label"><b>Status:</b></label>
                                <select name="Status" class="select2 form-control form-select select-opt" id="StatusDropdown">
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                        </div>
                        <div class="col-md-12">
                            <label for="remarks" class="col-form-label"><b>Remarks:</b></label>
                            <textarea name="remarks_leave" class="form-control" id="remarks_leave"
                                placeholder="Enter your remarks" maxlength="150"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="sendButtonleave">Submit</button>
            </div>
        </div>
    </div>
</div>
@include('employee.footer')


    <style>
        .chat-widget {
            position: fixed;
            bottom: 0px;
            right: 20px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            z-index: 22;
        }
        .header {
            display: flex;
            align-items: center;
            padding: 10px;
            cursor: pointer;
            background-color: #c2d6d7;
            border-bottom: 1px solid #ddd;
            border-radius: 10px 10px 0 0;
        }
        .header img.avatar {
            border-radius: 50%;
            width: 30px;
            height: 30px;
            margin-right: 10px;
            border: 1px solid #88a4ad;
        }
        .header .expand-collapse {
            margin-left: 155px;
            font-size: 12px;
            color: #777;
        }
        .chatbody {
            display: none;
            padding: 10px;
            border-radius: 0 0 10px 10px;
            height: 350px;
        }
        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 10px;
        }
        .tab-btn {
            flex: 1;
            padding: 5px 10px;
            cursor: pointer;
            background-color: #ccc;
            border: none;
            text-align: center;
        }
        .tabs .active {
            background-color: #90b1b5;
        }
        .tab-btn:hover {
            background-color: #bbb;
        }
       /* .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }*/
        .chat-box {
            border: 1px solid #ddd;
            padding: 10px;
            height: 200px;
            overflow-y: auto;
        }
        .chat-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
    <div id="floatingChat" class="chat-widget d-none">
        <div class="header" onclick="toggleChat()">
            <img src="./images/user.jpg" alt="Avatar" class="avatar">
            <span>Messaging</span>
            <span class="expand-collapse float-end">▲</span>
        </div>

        <div id="chatBody" class="chatbody">
            <div class="tabs">
                <button class="tab-btn active" onclick="openTab('task')">Task</button>
                <button class="tab-btn" onclick="openTab('chat')">Chat</button>
            </div>

            <div id="task" class="tab-content active">
                <h5>Task List</h5>
                <ul>
                    <li>Task 1: Complete Design</li>
                    <li>Task 2: Review Code</li>
                    <li>Task 3: Team Meeting</li>
                </ul>
            </div>

            <div id="chat" class="tab-content">
                <h5>Team Chat</h5>
                <div class="chat-box">
                    <p>John: Let's meet at 3 PM.</p>
                    <p>Jane: Sure!</p>
                    <input type="text" placeholder="Type a message..." class="chat-input">
                </div>
            </div>
        </div>
    </div>
    <!--------Vehicle Policy Migration Calculator-------->
<div class="modal fade show" id="viewVehiclepolicy" tabindex="-1"
aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Vehicle Policy Migration Calculator</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <!-- Section A: General Information -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-info-circle-fill me-2"></i>A. GENERAL INFORMATION
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-secondary" style="width:30%">EMP NAME</td>
                                            <td class="" style="width:20%" id="empName"></td>

                                            <td class="fw-bold text-secondary" style="width:30%">DEPARTMENT</td>
                                            <td class="" style="width:20%" id="department"></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold text-secondary">GRADE</td>
                                            <td id="grade"></td>
                                            <td class="fw-bold text-secondary">POLICY NAME</td>
                                            <td id="policyName"></td>
                                            </tr>


                                        <!-- Section B: Policy Summary -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-file-text-fill me-2"></i>B. POLICY SUMMARY
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="2">Existing Policy</th>
                                            <th class="text-center" colspan="2">Proposed Policy</th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Eligible Vehicle Value</td>
                                            <td class="text-right"id="existingVehicleValue"></td>

                                            <td class="fw-bold">Eligible Vehicle Value</td>
                                            <td class="text-right" id="proposedVehicleValue"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Vehicle Life</td>
                                            <td class="text-right" id="vehcilelife"></td>
                                            <td class="fw-bold">Vehicle Life</td>
                                            <td class="text-right" id="vehcilelifenew"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Monthly Allowed KM</td>
                                            <td class="text-right" id="existingMonthlyKM"></td>
                                            <td class="fw-bold">Monthly Allowed KM</td>
                                            <td class="text-right" id="proposedMonthlyKM"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Yearly Allowed KM</td>
                                            <td class="text-right" id="existingYearlyKM"></td>
                                            <td class="fw-bold">Yearly Allowed KM</td>
                                            <td class="text-right" id="proposedYearlyKM"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Policy Reimbursement Rate</td>
                                            <td class="text-right" id="existingRate"></td>
                                            <td class="fw-bold">Policy Reimbursement Rate</td>
                                            <td class="text-right" id="proposedRate"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Reduced Reimbursement Rate</td>
                                            <td class="text-right" id="existingReducedRate"></td>
                                            <td class="fw-bold">Reduced Reimbursement Rate</td>
                                            <td class="text-right" id="proposedReducedRate"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"></td>
                                            <td class="text-right"></td>
                                            <td class="fw-bold">Monthly Car Allowance (Part of CTC-NI)</td>
                                            <td class="text-right" id="monthlyCarAllowance"></td>
                                        </tr>
                                        <!-- ... Similar formatting for other policy details ... -->

                                        <!-- Section C: Impact Analysis -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-graph-up-arrow me-2"></i>C. Impact Old Vs New (Yearly)
                                                Based on Averaged KM 1st Apr 24 - 31st Jan 25
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="2">Existing Policy</th>
                                            <th class="text-center" colspan="2">Proposed Policy</th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">KM Claimed 01/Apr/24 to 31/Jan/25</td>
                                            <td class="text-right" id="alreadyapril"></td>
                                            <td class="fw-bold">KM Claimed 01/Apr/24 to 31/Jan/25</td>
                                            <td class="text-right" id="runafterapril"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Average KMs for 12 Months</td>
                                            <td class="text-right" id="avg_estimate"></td>
                                            <td class="fw-bold">Average KMs for 12 Months</td>
                                            <td class="text-right" id="avg_estimated"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Policy Reimbursement Rate Claim</td>
                                            <td class="text-right" id="amt_to_be_claimed">
                                                </td>
                                            <td class="fw-bold">Policy Reimbursement Rate Claim</td>
                                            <td class="text-right" id="amount_in_new_policy"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Reduced Reimbursement Rate Claim</td>
                                            <td class="text-right" id="amt_to_be_claimed_ext">
                                            </td>
                                            <td class="fw-bold">Reduced Reimbursement Rate Claim</td>
                                            <td class="text-right" id="amt_to_be_claimed_new"></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold"></td>
                                            <td class="text-right"></td>
                                            <td class="fw-bold">Fixed Component (As Per Grade)</td>
                                            <td class="text-right" id="yearly_car_allowance"></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Total</td>
                                            <td class="text-right" id="total_amount_claimed"></td>
                                            <td class="fw-bold">Total</td>
                                            <td class="text-right" id="total_yearly_claimed_new"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-center" style="font-size:20px;"colspan="4">Impact &emsp;<span class="text-right text-success fw-bold">+</span><span class="text-right text-success fw-bold" id="impact"></span></td>

                                        </tr>
                                        <!-- Section D: Migration Clause -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-arrow-left-right me-2"></i>D. MIGRATION CLAUSE
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                To facilitate a smooth transition from the existing policy to the new
                                                policy, including for those whose vehicle value is lower than the
                                                eligible value in the proposed policy, migration will be based on a
                                                repayment of fixed component calculated over the remaining life of the
                                                vehicle
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Eligible Vehicle Value (a)</td>
                                            <td class="text-right" id="ProposedVehicleValue"></td>
                                            <td class="fw-bold">Actual Vehicle Value (b)</td>
                                            <td class="text-right" id="ActualVehicleValue"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Diff in Vehicle Value (c)=(a)-(b)</td>
                                            <td class="text-right" id="Vechicle_Value_Diff_Proposed_Vs_Actual"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Migration Impact</td>
                                            <td colspan="3">Migration Based on Fixed Component Recovery over
                                                Remaining Life of Vehicle (Refer Below) </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Monthly Fixed Component for Eligible Vehicle Value (d)
                                            </td>
                                            <td class="text-right" id="Monthly_Claim_under_new_Fixed">
                                            </td>
                                            <td class="fw-bold">Remaining Month as on 01.04.2025 (e)</td>
                                            <td class="text-right" id="Remaining_Month"></td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Calculated Monthly Fixed component For Actual Vehicle
                                                value (f)=((d)/(a)*b)</td>
                                            <td class="text-right" id="Calculated_Monthly_Fixed_Component"></td>
                                            <td class="fw-bold">Total Reimbursement on remaining life of Vehicle as per
                                                calculated Monthly Fixed Component (g)=(e)*(f)</td>
                                            <td class="text-right" id="Total_Reimbursement"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-info" colspan="4">Since the monthly fixed
                                                component is reimbursed based on the eligible vehicle value rather than
                                                the actual vehicle value, the remaining period for the monthly fixed
                                                component will be reduced if the actual vehicle value is lower than the
                                                eligible value </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Adjusted Remaining Months to cover Remaining Fixed
                                                portion of actual vehicle value as per the Month fixed rate of Eligible
                                                vehicle value (h)=(g)/(d)</td>
                                            <td class="text-right" id="Adjusted_Remaining_Month"></td>
                                            <td class="fw-bold">Revised Policy validity</td>
                                            <td class="text-right" id="Adj_Remaining_Life_in_Month"></td>
                                        </tr>


                                        <!-- Section E: Vehicle Details -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-car-front-fill me-2"></i>E. Employee Current Vehicle
                                                Details (Check & if Updation Required mail to HR with document)
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Utilized KMs as on 01.04.24</td>
                                            <td class="text-right" id="AlreadyRunBeforeApril24"></td>
                                            <td class="fw-bold">Utilized KMs as on 31.01.24</td>
                                            <td class="text-right" id="AlreadyRunAfterApril24"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Utilized Vehicle Life</td>
                                            <td class="text-right" id="Claimed_Vehicle_Life"></td>
                                            <td class="fw-bold">Policy Coverage Till :</td>
                                            <td class="text-right" id="PolicyCoverageDate"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Model Name :</td>
                                            <td class="text-right"id="Model_Name"></td>
                                            <td class="fw-bold">Price :</td>
                                            <td class="text-right" id="Price"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Purchase Date :</td>
                                            <td class="text-right" id="Purchase_Date"></td>
                                            <td class="fw-bold">Fuel Type :</td>
                                            <td class="text-right" id="Fuel_Type"></td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Regis. No :</td>
                                            <td class="text-right" id="Regis_No"></td>
                                            <td class="fw-bold">Regis. Date :</td>
                                            <td class="text-right" id="Regis_Date"></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="effect-btn btn btn-light squer-btn sm-btn "
                data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<!------------------>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentDate = new Date();
            const currentMonthIndex = currentDate.getMonth(); // 0 = January, 1 = February, etc.
            const currentYear = currentDate.getFullYear();
            const employeeId = {{ Auth::user()->EmployeeID }};
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            
            // Get today's date
            const today = new Date();
            const day = today.getDate(); // Get current day
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate(); // Get last day of the current month
            console.log(lastDay);

            // Check if today is between 15th and the last day of the month
            if (day >= 15 && day <= lastDay) {
                // Show the "Warm Welcome" link
                document.getElementById("warmWelcomeLink").style.display = "block";
            }
            const monthDropdown = document.getElementById('monthname');
            const cardHeaders = document.querySelectorAll('.current-month h4');
            // const cardHeaderRequest = document.querySelector('#cardheaderrequest h4');
            const celebration = document.querySelector('#celebration h4');
            monthDropdown.innerHTML = `<option value="select">Select Month</option>`;
            // Populate the dropdown with the current month and all previous months
            for (let i = currentMonthIndex; i >= 0; i--) {
                const month = monthNames[i];
                monthDropdown.innerHTML += `<option value="${month}">${month}</option>`;
            }
            // Optionally select the current month
            monthDropdown.value = monthNames[currentMonthIndex];
            // Add the previous month option
            const previousMonthIndex = (currentMonthIndex - 1 + 12) % 12;
            const previousMonth = monthNames[previousMonthIndex];
            // monthDropdown.innerHTML += `<option value="${previousMonth}">${previousMonth}</option>`;
            // Fetch attendance data for the current month on page load
            fetchAttendanceData(monthNames[currentMonthIndex], currentYear);
            const modal_currentopening = document.getElementById('currentOpening');
            modal_currentopening.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const jobId = button.getAttribute('data-jpid'); // Extract job ID from data attribute
                // Fetch job details from the API
                fetch(`https://hrrec.vnress.in/job_detail/${jobId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data)
                        // Assuming data[0].description contains HTML as a string
                        let jobDescriptionText = data[0].description.trim();

                        // Use a regular expression to remove all HTML tags
                        jobDescriptionText = jobDescriptionText.replace(/<\/?[^>]+(>|$)/g, "");
                        // Populate modal with job details
                        document.getElementById('modalJobTitle').textContent = data[0].title || 'N/A';
                        document.getElementById('modalJobCode').textContent = data[0].jobcode || 'N/A';
                        document.getElementById('modalJobDepartment').textContent = data[0].department || 'N/A';
                        document.getElementById('modalJobDescription').textContent =jobDescriptionText || 'N/A';
                        document.getElementById('modalJobEducation').textContent = data[0].qualification || 'N/A';
                        document.getElementById('modalJobWorkExperience').textContent = data[0].work_experience || 'N/A';
                        document.getElementById('modalJobSalary').textContent = data[0].salary || 'N/A';
                        document.getElementById('modalJobLocation').textContent = data[0].location || 'N/A';
                        document.getElementById('applyLink').href = `${data[0].link}/${jobId}`; // Assuming location is a base URL
                    })
                    .catch(error => {
                        console.error('Error fetching job details:', error);
                    });
            });
            monthDropdown.addEventListener('change', function () {
                const selectedMonth = this.value;
                if (selectedMonth !== "select") {
                    fetchAttendanceData(selectedMonth, currentYear);
                }
            });
            document.addEventListener('click', function (event) {
                if (event.target.closest('.open-modal')) {
                        event.preventDefault();
                    const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
                    modal.show();   
                     
      
                    const link = event.target.closest('.open-modal');
                    const employeeId = link.getAttribute('data-employee-id');
                    const date = link.getAttribute('data-date');
                    const innTime = link.getAttribute('data-inn');
                    const outTime = link.getAttribute('data-out');
                    const II = link.getAttribute('data-II');
                    const OO = link.getAttribute('data-OO');
                    const atct = link.getAttribute('data-atct');
                    const dataexist = link.getAttribute('data-exist');
                    const status = link.getAttribute('data-status');
                    const draft = link.getAttribute('data-draft');
                    const statusin = link.getAttribute('data-in-status');
                    const statusout = link.getAttribute('data-out-status');
                    const statusother = link.getAttribute('data-s-status');
                    // Determine classes based on conditions
                    const lateClass = (innTime > II) ? 'text-danger' : '';
                    const earlyClass = (outTime < OO) ? 'text-danger' : '';

                        // Get current date
                        const currentDate = new Date();
                        const givenDate = parseDate(date); // Convert string to Date object
                       
                        // Get the year and month for the current date
                        const currentMonth = currentDate.getMonth(); // 0 = January, 11 = December
                        const currentYear = currentDate.getFullYear();

                        // Get the year and month for the given date
                        const givenMonth = givenDate.getMonth(); 
                        const givenYear = givenDate.getFullYear();

                        // Check if the given date is in the previous month
                        let isPreviousMonth = false;

                        // If the given year is the same as the current year
                        if (givenYear === currentYear) {
                            // Check if the given month is exactly one month before the current month
                            if (givenMonth < currentMonth ) {
                                isPreviousMonth = true;
                            }
                        } 
                        if (givenYear < currentYear || (givenYear === currentYear && givenMonth < currentMonth)) {
                                isPreviousMonthOrEarlier = true;
                            }

                        // Hide the button if it's the previous month
                        if (isPreviousMonth) {
                            document.getElementById("sendButton").style.display = "none";
                        } else {
                            // Otherwise, show the button
                            document.getElementById("sendButton").style.display = "block";
                        } 
                        let requestDateContent = `
    <div style="text-align: left;">
        <b>Request Date: ${date}</b>
        <span style="color: ${
                // Determine the color based on status
                (statusin !== '0' || statusout !== '0') 
                    ? 'green'  // If InStatus or OutStatus is not 0, show green
                    : ((statusin === '2' || statusother === '2' || statusout === '2') && draft === '3') 
                        ? 'green'  // Approved in green
                        : (draft === '3' || draft === null) 
                            ? 'red'  // Draft or null draft, color is red
                            : 'red'  // Else rejected, color is red
            }; float: right; ${draft === '0' ? 'display: none;' : ''}">
            <b style="color: black; font-weight: bold;">Status:</b> 
            ${
                // Determine the status text
                (statusin !== '0' || statusout !== '0') 
                    ? `InStatus: ${statusin}, OutStatus: ${statusout}`  // Display InStatus and OutStatus
                    : ((statusin === '2' || statusother === '2' || statusout === '2') && draft === '3') 
                        ? 'Approved'  // If status and draft meet the condition, display "Approved"
                        : (draft === '3' || draft === null) 
                            ? 'Draft'  // If draft is 3 or null, display "Draft"
                            : 'Rejected'  // Else, display "Rejected"
            }
        </span>
    </div>
`;
                        const todaynew = new Date().toLocaleDateString("en-GB", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                            }).replace(/ /g, "-"); // Replace spaces with hyphens
                          
                            if (date === todaynew) {
                                requestDateContent += `In: <span>${innTime}</span><br>`;
                                requestDateContent += `Out: <span>${outTime}</span>`; // Optional: show "On Time" if needed
                            }
                            else{
                            // Check conditions for In
                            if (innTime > II) {
                                requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
                            } else if (innTime <= II) {
                                requestDateContent += `In: <span>${innTime} On Time</span><br>`; // Optional: show "On Time" if needed
                            }
                            // Check conditions for Out
                            if (outTime < OO) {
                                requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
                            } else if (outTime >= OO) {
                                requestDateContent += `Out: <span>${outTime} On Time</span>`; // Optional: show "On Time" if needed
                            }
                            }
                    
                            // Set innerHTML only if there is content to display
                    document.getElementById('request-date').innerHTML = requestDateContent;
                    document.getElementById('employeeid').value = employeeId;
                    document.getElementById('Atct').value = atct;
                    document.getElementById('requestDate').value = date;
                    // Clear previous values and hide all groups
                    //due to error ehil opening          

                    document.getElementById('reasonInGroup').style.display = 'none';
                    document.getElementById('remarkInGroup').style.display = 'none';
                    document.getElementById('reasonOutGroup').style.display = 'none';
                    document.getElementById('remarkOutGroup').style.display = 'none';
                    document.getElementById('inreasonreqGroup').style.display = 'none';
                    document.getElementById('reportingremarkreqGroup').style.display = 'none';
                    document.getElementById('outreasonreqGroup').style.display = 'none';
                    document.getElementById('reasonreqGroup').style.display = 'none';
                    document.getElementById('otherRemarkGroup').style.display = 'none';
                    document.getElementById('otherReasonGroup').style.display = 'none';
                    const sendButton = document.getElementById('sendButton');
                    sendButton.removeAttribute('disabled'); // Enable the button
                    // // Initially, make the 'otherRemark' input editable
                    // const otherRemarkInput = document.getElementById('otherRemark');
                    // otherRemarkInput.removeAttribute('readonly'); // Make the input editable
                    // const remarkOutInput = document.getElementById('remarkOut');
                    // remarkOutInput.removeAttribute('readonly'); // Make the input editable
                    // const remarkInInput = document.getElementById('remarkIn');
                    // remarkInInput.removeAttribute('readonly'); // Make the input editable
                    // // Fetch attendance data for this employee and date

                    // Initially, make the 'otherRemark' input editable
                    // const otherRemarkInput = document.getElementById('otherRemark');
                    // if (otherRemarkInput) {
                    //     otherRemarkInput.value = ''; // Clear Out Remark if no data
                    //     otherRemarkInput.removeAttribute('readonly'); // Make the input editable
                    // }

                    // // Make the 'remarkOut' input editable
                    // const remarkOutInput = document.getElementById('remarkOut');
                    // if (remarkOutInput) {
                    //     cosnole.log('out';)
                    //     remarkOutInput.value = ''; // Clear Out Remark if no data

                    //     remarkOutInput.removeAttribute('readonly'); // Make the input editable
                    // }

                    // // Make the 'remarkIn' input editable
                    // const remarkInInput = document.getElementById('remarkIn');
                    // if (remarkInInput) {
                    //     remarkInInput.value = ''; // Clear Out Remark if no data
                    //     remarkInInput.removeAttribute('readonly'); // Make the input editable
                    // }

                    fetch(`/getAttendanceData?employeeId=${employeeId}&date=${date}`)
                        .then(response => response.json())
                        .then(attendanceData => {
                            console.log(attendanceData.attendance);
                            // If attendance data is found for the given date
                            if (attendanceData && attendanceData.attendance != null) {
                                            const attDate = new Date(attendanceData.attendance.AttDate); // Parse the date string into a Date object
                                        // Format the date to day-MonthName-year (e.g., 6-November-2024)
                                        const day = attDate.getDate(); // Get the day (6)
                                        const month = attDate.toLocaleString('default', { month: 'long' }); // Get the month name (November)
                                        const year = attDate.getFullYear(); // Get the year (2024)
                                        const formattedDate = `${day}-${month}-${year}`; // Combine them into the desired format
                                        console.log(attendanceData.attendance.draft_status);
                                        let requestDateContent = `
    <div style="text-align: left;">
        <b>Request Date: ${formattedDate}</b>
        <span style="color: ${
            // Determine the color based on the conditions
            ((attendanceData.attendance.InStatus == 2 || 
            attendanceData.attendance.OutStatus == 2 || 
            attendanceData.attendance.SStatus == 2) && 
            attendanceData.attendance.draft_status == 3) 
                ? 'green' // Approved in green
                : (attendanceData.attendance.draft_status == 3) 
                    ? 'red' // Draft in red
                    : (attendanceData.attendance.InStatus == 2 || 
                    attendanceData.attendance.OutStatus == 2 || 
                    attendanceData.attendance.SStatus == 2)
                        ? 'green' // Approved in green
                        : 'red' // Rejected in red
        }; float: right;">
        
        <b style="color: black; font-weight: bold;">Status:</b> 

        ${
            // Check for InReason and display InStatus
            (attendanceData.attendance.InReason && attendanceData.attendance.InReason.trim() !== '') 
                ? (attendanceData.attendance.InStatus == 2 
                    ? 'InStatus: Approved' 
                    : (attendanceData.attendance.InStatus == 3) 
                        ? '<span style="color: red;">InStatus: Rejected</span>'  // Rejected in red
                        : '') 
                : '' // If no InReason, don't show InStatus
        }
        
        ${
            // Check for OutReason and display OutStatus
            (attendanceData.attendance.OutReason && attendanceData.attendance.OutReason.trim() !== '') 
                ? (attendanceData.attendance.OutStatus == 2 
                    ? ', OutStatus: Approved' 
                    : (attendanceData.attendance.OutStatus == 3) 
                        ? ', <span style="color: red;">OutStatus: Rejected</span>' // Rejected in red
                        : '') 
                : '' // If no OutReason, don't show OutStatus
        }

        ${
            // Check for Reason and display SStatus
            (attendanceData.attendance.Reason && attendanceData.attendance.Reason.trim() !== '') 
                ? (attendanceData.attendance.SStatus == 2 
                    ? 'Approved' 
                    : (attendanceData.attendance.SStatus == 3) 
                        ? '<span style="color: red;">Rejected</span>' // Rejected in red
                        : '') 
                : '' // If no Reason, don't show SStatus
        }

        </span>
    </div>
`;

                                    const todaynew = new Date().toLocaleDateString("en-GB", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                            }).replace(/ /g, "-"); // Replace spaces with hyphens
                            console.log(`Comparison Result: ${date === today}`); // true if the dates match

                          
                            if (date === todaynew) {
                                requestDateContent += `In: <span>${innTime} Late</span><br>`;
                                requestDateContent += `Out: <span>${outTime} On Time</span>`; // Optional: show "On Time" if needed
                            }else{

                                // Check conditions for In
                                if (innTime > II) {
                                    requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
                                } else if (innTime <= II) {
                                    requestDateContent += `In: <span>${innTime} On Time</span><br>`; // Optional: show "On Time" if needed
                                }
                                    // Check conditions for Out
                                    if (outTime < OO) {
                                        requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
                                    } else if (outTime >= OO) {
                                        requestDateContent += `Out: <span>${outTime} On Time</span>`; // Optional: show "On Time" if needed
                                    }
                                }
                                
                                    // Set innerHTML only if there is content to display
                                    document.getElementById('request-date').innerHTML = requestDateContent;

                                                    // document.getElementById('attendanceMessage').style.display = 'block';
                                    // If 'remarkIn' is available in the data, show the value instead of input
                                    // If 'remarkIn' is available in the data, show the value instead of input
                                    // if (attendanceData.attendance.InRemark) {
                                    //     console.log(attendanceData.attendance.InRemark);
                                    //     const remarkInInput = document.getElementById('remarkIn');
                                    //     remarkInInput.value = attendanceData.attendance.InRemark; // Fill in the remark value
                                    //     remarkInInput.setAttribute('readonly', true); // Make it readonly
                                    //     document.getElementById("sendButton").style.display = "none";

                                    //     // Disable the 'Send' button
                                    //     // const sendButton = document.getElementById('sendButton');
                                    //     // sendButton.setAttribute('disabled', true); // Disable the button
                                    // }
                                    if (attendanceData.attendance.InRemark) {
                                // Get the input field for Remark
                                const remarkInInput = document.getElementById('remarkIn');
                                // Check if the input field exists
                                if (remarkInInput) {
                                    // Set the value of the input field
                                    remarkInInput.value = attendanceData.attendance.InRemark;
                                    
                                    // Make the input field readonly
                                    remarkInInput.setAttribute('readonly', true);
                                    
                                    // Disable the 'Send' button
                                    // const sendButton = document.getElementById('sendButton');
                                    // sendButton.setAttribute('disabled', true);
                                    document.getElementById("sendButton").style.display = "none";

                                    // Optionally, you can hide the input field and display the value in a span instead
                                    const remarkSpan = document.createElement('span'); // Create a span element
                                    remarkSpan.textContent = attendanceData.attendance.InRemark; // Set the span text content to the remark value
                                    // Replace the input field with the span
                                    remarkInInput.parentNode.replaceChild(remarkSpan, remarkInInput);
                                }
                            }
                              
                                    if (attendanceData.attendance.OutRemark) {
                                            console.log('if');
                                        // Get the input field for Remark
                                        const remarkOutInput = document.getElementById('remarkOut');
                                        // Check if the input field exists
                                        if (remarkOutInput) {
                                            // Set the value of the input field
                                            remarkOutInput.value = attendanceData.attendance.OutRemark;
                                            
                                            // Make the input field readonly
                                            remarkOutInput.setAttribute('readonly', true);
                                            
                                            // Disable the 'Send' button
                                            // const sendButton = document.getElementById('sendButton');
                                            // sendButton.setAttribute('disabled', true);
                                            document.getElementById("sendButton").style.display = "none";

                                            // Optionally, you can hide the input field and display the value in a span instead
                                            const remarkSpan = document.createElement('span'); // Create a span element
                                            remarkSpan.textContent = attendanceData.attendance.OutRemark; // Set the span text content to the remark value
                                            // Replace the input field with the span
                                            remarkOutInput.parentNode.replaceChild(remarkSpan, remarkOutInput);
                                        }
                                    }
                                    
                                    // if (!attendanceData.attendance.OutRemark) {
                                    //     console.log('else');
                                    //     const remarkOutInput = document.getElementById('remarkOut');
                                    //     if (remarkOutInput) {
                                    //         remarkOutInput.value = ''; // Clear the value if no data
                                    //     }
                                    // }
                                                    
                                        if (attendanceData.attendance.Remark) {
                                        // Get the input field for Remark
                                        const otherRemarkInput = document.getElementById('otherRemark');
                                        // Check if the input field exists
                                        if (otherRemarkInput) {
                                            // Set the value of the input field
                                            otherRemarkInput.value = attendanceData.attendance.Remark;
                                            
                                            // Make the input field readonly
                                            otherRemarkInput.setAttribute('readonly', true);
                                            
                                            // Disable the 'Send' button
                                            // const sendButton = document.getElementById('sendButton');
                                            // sendButton.setAttribute('disabled', true);
                                            document.getElementById("sendButton").style.display = "none";

                                            // Optionally, you can hide the input field and display the value in a span instead
                                            const remarkSpan = document.createElement('span'); // Create a span element
                                            remarkSpan.textContent = attendanceData.attendance.Remark; // Set the span text content to the remark value
                                            // Replace the input field with the span
                                            otherRemarkInput.parentNode.replaceChild(remarkSpan, otherRemarkInput);
                                        }
                                    }
                                        
                                        if (attendanceData.attendance.R_Remark) {
                                        // Get the input field for Reporting Remark
                                        const reporemarkkInput = document.getElementById('reportingremarkreq');
                                        // Check if the input field exists
                                        if (reporemarkkInput) {
                                            // Set the value of the input field
                                            reporemarkkInput.value = attendanceData.attendance.R_Remark;
                                            
                                            // Make the input field readonly
                                            reporemarkkInput.setAttribute('readonly', true);
                                            
                                            // Disable the 'Send' button
                                            // const sendButton = document.getElementById('sendButton');
                                            // sendButton.setAttribute('disabled', true);
                                            document.getElementById("sendButton").style.display = "none";

                                            // Optionally, you can hide the input field and display the value in a span instead
                                            const reportRemarkSpan = document.createElement('span'); // Create a span element
                                            reportRemarkSpan.textContent = attendanceData.attendance.R_Remark; // Set the span text content to the reporting remark value
                                            // Replace the input field with the span
                                            reporemarkkInput.parentNode.replaceChild(reportRemarkSpan, reporemarkkInput);
                                        }
                                        else{
                                            console.log('dzfsdfsdf');
                                        }
                                    }
                                        
                                    
                                        if (attendanceData.attendance.InReason) {
                                            // Hide the dropdown group (assuming 'reasonInGroup' refers to a dropdown)
                                            document.getElementById('reasonInGroup').style.display = 'none'; 
                                            
                                            // Get the input field for the "In Reason"
                                            const reasonInInput = document.getElementById('inreasonreq');
                                            // Check if the input field exists
                                            if (reasonInInput) {
                                                // Set the value of the input field
                                                reasonInInput.value = attendanceData.attendance.InReason;
                                                
                                                // Make the input field readonly
                                                reasonInInput.setAttribute('readonly', true);
                                                
                                                // Disable the 'Send' button
                                                // const sendButton = document.getElementById('sendButton');
                                                // sendButton.setAttribute('disabled', true);
                                                document.getElementById("sendButton").style.display = "none";

                                                // Optionally, you can replace the input field with a span to display the value instead of input
                                                const reasonInSpan = document.createElement('span'); // Create a span element
                                                reasonInSpan.textContent = attendanceData.attendance.InReason; // Set the span text content to the InReason value
                                                // Replace the input field with the span
                                                reasonInInput.parentNode.replaceChild(reasonInSpan, reasonInInput);
                                            }
                                        }
                                    
                                        if (attendanceData.attendance.OutReason) {
                                        // Hide the dropdown group (assuming 'reasonOutGroup' refers to a dropdown)
                                        document.getElementById('reasonOutGroup').style.display = 'none'; 
                                        
                                        // Get the input field for the "Out Reason"
                                        const reasonOutInput = document.getElementById('outreasonreq');
                                        // Check if the input field exists
                                        if (reasonOutInput) {
                                            // Set the value of the input field
                                            reasonOutInput.value = attendanceData.attendance.OutReason;
                                            
                                            // Make the input field readonly
                                            reasonOutInput.setAttribute('readonly', true);
                                            
                                            // Optionally, you can replace the input field with a span to display the value instead of input
                                            const reasonOutSpan = document.createElement('span'); // Create a span element
                                            reasonOutSpan.textContent = attendanceData.attendance.OutReason; // Set the span text content to the OutReason value
                                            // Replace the input field with the span
                                            reasonOutInput.parentNode.replaceChild(reasonOutSpan, reasonOutInput);
                                        }
                                    }
                                    
                                        if (attendanceData.attendance.Reason) {
                                                    // Hide the input field by hiding the parent group
                                                    document.getElementById('otherReasonGroup').style.display = 'none'; // Hide dropdown group
                                                    // Create a span element to display the reason
                                                    const reasonSpan = document.createElement('span'); // Create a new span element
                                                    reasonSpan.textContent = attendanceData.attendance.Reason; // Set the reason as text content
                                                    // Replace the input field with the created span
                                                    const otherReasonInput = document.getElementById('reasonreq');
                                                    otherReasonInput.parentNode.replaceChild(reasonSpan, otherReasonInput); // Replace the input field with the span
                                                    // Disable the 'Send' button
                                                    // const sendButton = document.getElementById('sendButton');
                                                    // sendButton.setAttribute('disabled', true); // Disable the button
                                                    document.getElementById("sendButton").style.display = "none";

                                                }
                                        // Show additional fields if necessary based on the conditions
                                        if (attendanceData.attendance.InReason) {
                                            document.getElementById('inreasonreqGroup').style.display = 'block'; // Show In Reason Request
                                        }
                                        if (attendanceData.attendance.R_Remark) {
                                            document.getElementById('reportingremarkreqGroup').style.display = 'block'; // Show In Reason Request
                                        }
                                        if (attendanceData.attendance.OutReason) {
                                            document.getElementById('outreasonreqGroup').style.display = 'block'; // Show Out Reason Request
                                        }
                                        if (attendanceData.attendance.Reason) {
                                            document.getElementById('reasonreqGroup').style.display = 'block'; // Show Other Reason Request
                                        }
                            }
                        
                            
                            if (attendanceData.attendance == null) {
                                    // Fetch the remarkOutGroup div
                                    let remarkOutGroup = document.getElementById('remarkOutGroup');
                                    
                                        if(remarkOutGroup){
                                            let remarkOutSpan = remarkOutGroup.querySelector('span');

                                                    // If span exists, replace it with the original input
                                                    if (remarkOutSpan) {
                                                        let input = document.createElement('textarea');
                                                        input.type = "text";
                                                        input.name = "remarkOut";
                                                        input.className = "form-control";
                                                        input.id = "remarkOut";
                                                        input.placeholder = "Enter your out remark";
                                                        
                                                        // Replace the span with the input field
                                                        remarkOutGroup.replaceChild(input, remarkOutSpan);
                                                    }
                                                }
                                    
                                        // For remarkInGroup div
                                        let remarkInGroup = document.getElementById('remarkInGroup');
                                        let remarkInSpan = remarkInGroup.querySelector('span'); // Check if there's a span inside remarkInGroup
                                        if (remarkInSpan) {
                                            let input = document.createElement('textarea');
                                            input.type = "text";
                                            input.name = "remarkIn";
                                            input.className = "form-control";
                                            input.id = "remarkIn";
                                            input.placeholder = "Enter your in remark";
                                            
                                            // Replace the span with the input
                                            remarkInGroup.replaceChild(input, remarkInSpan);
                                        }

                                        // For otherRemarkGroup div
                                        let otherRemarkGroup = document.getElementById('otherRemarkGroup');
                                        let otherRemarkSpan = otherRemarkGroup.querySelector('span'); // Check if there's a span inside otherRemarkGroup
                                        if (otherRemarkSpan) {
                                            let input = document.createElement('textarea');
                                            input.type = "text";
                                            input.name = "otherRemark";
                                            input.className = "form-control";
                                            input.id = "otherRemark";
                                            input.placeholder = "Enter your remark Other";
                                            
                                            // Replace the span with the input
                                            otherRemarkGroup.replaceChild(input, otherRemarkSpan);
                                        }
                                    
                            }
                         
                           
                            
                        })
                        .catch(error => {
                            console.error('Error fetching attendance data:', error);
                        });
                    // Fetch company_id and department_id based on employeeId
                    fetch(`/api/getEmployeeDetails/${employeeId}`)
                        .then(response => response.json())
                        .then(data => {
                            const companyId = data.company_id;
                            const departmentId = data.department_id;
                            // Fetch reasons based on companyId and departmentId
                            return fetch(`/api/getReasons/${companyId}/${departmentId}`);
                        })
                        .then(response => response.json())
                        .then(reasons => {
                            // Function to clear existing options in the dropdowns
                            function clearDropdown(dropdownId) {
                                const dropdown = document.getElementById(dropdownId);
                                dropdown.innerHTML = '';
                            }
                            // Clear existing options in all dropdowns
                            clearDropdown('reasonInDropdown');
                            clearDropdown('reasonOutDropdown');
                            clearDropdown('otherReasonDropdown');
                            // Add default "Select Option" as the first option for each dropdown
                            const defaultOption = document.createElement('option');
                            defaultOption.value = '';  // empty value for "Select Option"
                            defaultOption.textContent = 'Select Reason';
                            document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true));
                            document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true));
                            document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true));
                            // Populate the reason dropdowns with actual options
                            reasons.forEach(reason => {
                             
                                const optionIn = document.createElement('option');
                                optionIn.value = reason.ReasonId;
                                optionIn.textContent = reason.reason_name;
                                document.getElementById('reasonInDropdown').appendChild(optionIn);
                                const optionOut = document.createElement('option');
                                optionOut.value = reason.ReasonId;
                                optionOut.textContent = reason.reason_name;
                                document.getElementById('reasonOutDropdown').appendChild(optionOut);
                                const optionOther = document.createElement('option');
                                optionOther.value = reason.ReasonId;
                                optionOther.textContent = reason.reason_name;
                                document.getElementById('otherReasonDropdown').appendChild(optionOther);
                            });
                            // Ensure "Select Option" is selected initially in all dropdowns
                            document.getElementById('reasonInDropdown').value = '';
                            document.getElementById('reasonOutDropdown').value = '';
                            document.getElementById('otherReasonDropdown').value = '';
                        })
                        .catch(error => console.error('Error fetching reasons:', error));
                        const today = new Date().toLocaleDateString("en-GB", {
                                day: "numeric",
                                month: "long",
                                year: "numeric",
                            }).replace(/ /g, "-"); // Replace spaces with hyphens
                           
                    let inConditionMet = false;
                    let outConditionMet = false;
                    if (date === today) {
                            remarkInGroup.style.display = 'none';
                            reasonInGroup.style.display = 'none';
                            remarkOutGroup.style.display = 'none';
                            reasonOutGroup.style.display = 'none';
                            document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
                            document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input
                            }
                    else{
                            if (innTime === outTime) {
                                remarkInGroup.style.display = 'none';
                                reasonInGroup.style.display = 'none';
                                remarkOutGroup.style.display = 'none';
                                reasonOutGroup.style.display = 'none';
                                document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
                                document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input
                            }
                            else {
                                // Your existing time condition logic...
                                if (innTime > II) {
                                    remarkInGroup.style.display = 'block';
                                    reasonInGroup.style.display = 'block';
                                    // document.getElementById('remarkIn').value = 'Your remark for late in';
                                    inConditionMet = true;
                                }
                                if (outTime == '00:00') {
                                    remarkOutGroup.style.display = 'block';
                                    reasonOutGroup.style.display = 'block';
                                    // document.getElementById('remarkOut').value = 'Your remark for early out';
                                    document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                                    document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input
                                }
                                if (outTime < OO) {
                                    remarkOutGroup.style.display = 'block';
                                    reasonOutGroup.style.display = 'block';
                                    // document.getElementById('remarkOut').value = 'Your remark for early out';
                                    outConditionMet = true;
                                }
                                // If both conditions are met, display both groups
                                if (inConditionMet && outConditionMet) {
                                    remarkInGroup.style.display = 'block';
                                    reasonInGroup.style.display = 'block';
                                    remarkOutGroup.style.display = 'block';
                                    reasonOutGroup.style.display = 'block';
                                    document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                                    document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input
                                }
                            }
                        }
                }
            
            
            });
            
            function parseDate(dateStr) {
                    const [day, monthStr, year] = dateStr.split('-');
                    
                    // Map month string to month index (January is 0, December is 11)
                    const months = [
                        'January', 'February', 'March', 'April', 'May', 'June', 
                        'July', 'August', 'September', 'October', 'November', 'December'
                    ];
                    
                    const month = months.indexOf(monthStr); // Find the month index
                    
                    return new Date(year, month, day); // Construct and return the Date object
                }
            
                function fetchLeaveRequests() {
                const leaveRequestsContainer = document.getElementById('leaveRequestsContainer');
                const mainBodyLeave = document.getElementById('leavemainrequest');
                mainBodyLeave.style.display = 'none';
                fetch(`/leave-requests?employee_id=${employeeId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        leaveRequestsContainer.innerHTML = '';
                        if (data.length > 0) {
                            mainBodyLeave.style.display = 'flex';
                            data.forEach(item => {
                                // Function to limit the text to the first 5 words
                            function limitTextToFiveWords(text) {
                                const words = text.split(' ');  // Split the text into words
                                const firstFiveWords = words.slice(0, 5).join(' ');  // Take the first 5 words and join them
                                return firstFiveWords;
                            }

                            // Use this function to limit the Apply_Reason to 5 words

                                const leaveRequest = item.leaveRequest;
                                console.log(leaveRequest);
                                const employeeDetails = item.employeeDetails;
                                if (!leaveRequest || !employeeDetails) return; // Check if data exists
                                const card = document.createElement('div');
                                card.className = 'card p-3 mb-3';
                                card.style.border = '1px solid #ddd';
                                let actionButtons = '';
                                if (leaveRequest.LeaveStatus == '0' || leaveRequest.LeaveStatus == '3'|| leaveRequest.LeaveStatus == '4') {
                                    // Pending state
                                    actionButtons = `
                            <button class="mb-0 sm-btn mr-1 effect-btn btn btn-success accept-btn" style="padding: 4px 10px; font-size: 10px;"
                                data-employee="${employeeDetails.EmployeeID}" 
                                data-name="${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}" 
                                data-from_date="${leaveRequest.Apply_FromDate}" 
                                data-to_date="${leaveRequest.Apply_ToDate}" 
                                data-reason="${leaveRequest.Apply_Reason}" 
                                data-total_days="${leaveRequest.Apply_TotalDay}" 
                                data-leavetype="${leaveRequest.Leave_Type}"
                                data-leavecancellation="${leaveRequest.LeaveStatus}"
                                data-leavetype_day="${leaveRequest.half_define}">Approval</button>
                            <button class="mb-0 sm-btn effect-btn btn btn-danger reject-btn"  style="padding: 4px 10px; font-size: 10px;"
                                data-employee="${employeeDetails.EmployeeID}" 
                                data-name="${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}" 
                                data-from_date="${leaveRequest.Apply_FromDate}" 
                                data-to_date="${leaveRequest.Apply_ToDate}" 
                                data-reason="${leaveRequest.Apply_Reason}" 
                                data-total_days="${leaveRequest.Apply_TotalDay}" 
                                data-leavetype="${leaveRequest.Leave_Type}"
                                data-leavecancellation="${leaveRequest.LeaveStatus}"
                                data-leavetype_day="${leaveRequest.half_define}"
                                >Reject</button>
                        `;
                                } else if (leaveRequest.LeaveStatus == '1') {
                                    actionButtons = `<a href="#" class="mb-0 sm-btn effect-btn btn btn-success" title="Approved">Approved</a>`;
                                } else if (leaveRequest.LeaveStatus == '2') {
                                    actionButtons = `<a href="#" class="mb-0 sm-btn effect-btn btn btn-danger" title="Rejected">Rejected</a>`;
                                }
                                card.innerHTML = `
                        <div class="img-thumb mb-1" style="border-bottom: 1px solid #ddd;">
                            <div class="float-start emp-request-leave">
                                <img class="float-start me-2" src="https://vnrseeds.co.in/AdminUser/EmpImg${employeeDetails.CompanyId}Emp/${employeeDetails.ECode}.jpg">

                                <b>Emp Code: ${employeeDetails.EmployeeID}</b>
                                <p>${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}</p>
                            </div>
                            <div class="float-end">
                                ${actionButtons}
                            </div>
                        </div>
                        <div>
                            <label class="mb-0 badge" 
                                title="" 
                                data-original-title="${leaveRequest.Leave_Type}"
                                style="background-color: 
                                    ${leaveRequest.Leave_Type === 'CH' ? 'rgb(100, 177, 255)' :
                                    leaveRequest.Leave_Type === 'SH' ? 'rgb(100, 177, 255)' :
                                    leaveRequest.Leave_Type === 'PL' ? 'rgb(100, 177, 255)' :
                                    leaveRequest.Leave_Type === 'SL' ? 'rgb(100, 177, 255)' :
                                    leaveRequest.Leave_Type === 'CL' ? 'rgb(100, 177, 255)' :
                                    leaveRequest.Leave_Type === 'EF' ? 'blue' :
                                    leaveRequest.Leave_Type === 'FL' ? '#14d6e0' :
                                    'gray'};">
                                ${leaveRequest.Leave_Type}
                            </label>
                            <span class="me-3 ms-2"><b><small>${formatDateddmmyyyy(leaveRequest.Apply_FromDate)}</small></b></span>
                            To <span class="ms-3 me-3"><b><small>${formatDateddmmyyyy(leaveRequest.Apply_ToDate)}</small></b></span>
                            <span class="float-end btn-outline primary-outline p-0 pe-1 ps-1">
                                <small><b>${leaveRequest.Apply_TotalDay} Days</b></small>
                            </span>
                        <p class="my-request-msg">
                                <small>${leaveRequest.Apply_Reason} 
                                    <a href="#" class="link btn-link p-0" 
                                    data-bs-toggle="modal" data-bs-target="#approvalpopupdetails" 
                                    data-leave-type="${leaveRequest.Leave_Type}" 
                                    data-from-date="${leaveRequest.Apply_FromDate}"
                                    data-to-date="${leaveRequest.Apply_ToDate}"
                                    data-total-days="${leaveRequest.Apply_TotalDay}"
                                    data-status="${leaveRequest.LeaveStatus}"
                                    data-ApplyContactNo="${leaveRequest.Apply_ContactNo}"
                                    data-ApplyDuringAddress="${leaveRequest.Apply_DuringAddress}"
                                    data-reason="${leaveRequest.Apply_Reason}"style="color: rgb(100, 177, 255);">More...</a>
                                </small>
                            </p>`;
                                leaveRequestsContainer.appendChild(card);
                            });
                            // Attach event listeners only after rendering all cards
                            attachEventListeners();
                            attachEventListenersleave();
                        } else {
                            leaveRequestsContainer.innerHTML = '<div class="alert alert-warning attendancedatanotfound">No leave requests found for this employee.</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching leave requests:', error);
                        leaveRequestsContainer.innerHTML = '<p>Error fetching leave requests.</p>';
                    });
            }
                            // Event listener for "More..." links to populate the modal
                function attachEventListenersleave() {
                    const moreLinks = document.querySelectorAll('.link.btn-link');
                    
                    moreLinks.forEach(link => {
                        link.addEventListener('click', function(event) {
                            // Prevent the default action of the link
                            event.preventDefault();
                            
                            // Get data attributes from the clicked link
                            const leaveType = link.getAttribute('data-leave-type');
                            const fromDate = link.getAttribute('data-from-date');
                            const toDate = link.getAttribute('data-to-date');
                            const totalDays = link.getAttribute('data-total-days');
                            const status = link.getAttribute('data-status');
                            const reason = link.getAttribute('data-reason');
                            const contactno = link.getAttribute('data-ApplyContactNo');
                            const address = link.getAttribute('data-ApplyDuringAddress');

                            
                            // Populate the modal content with the fetched data
                            document.querySelector('#approvalpopupdetails .leave-type-details').textContent = leaveType;
                            document.querySelector('#approvalpopupdetails .date-range').textContent = `${formatDateddmmyyyy(fromDate)} To ${formatDateddmmyyyy(toDate)}`;
                            document.querySelector('#approvalpopupdetails .total-days').textContent = `${totalDays} Days`;
                            document.querySelector('#approvalpopupdetails .leave-status-details').textContent = getLeaveStatus(status);
                            document.querySelector('#approvalpopupdetails .leave-reason-details').textContent = 
                                reason.charAt(0).toUpperCase() + reason.slice(1).toLowerCase();
                            document.querySelector('#approvalpopupdetails .leave-contact-details').textContent = contactno;
                            document.querySelector('#approvalpopupdetails .leave-address-details').textContent = 
                                address.charAt(0).toUpperCase() + address.slice(1).toLowerCase();

                        });
                    });
                }

                // Helper function to translate leave status codes to human-readable text
                function getLeaveStatus(status) {
                    switch (status) {
                        case '0':
                            return 'Draft';
                        case '1':
                            return 'Approved';
                        case '2':
                            return 'Approval';
                        case '3':
                            return 'Reject';
                        case '4':
                            return 'Cancellation';
                        default:
                            return 'Unknown Status';
                    }
                }

                // Helper function to return leave type color
                function getLeaveTypeColor(leaveType) {
                    switch (leaveType) {
                        case 'CH': case 'SH': case 'PL': case 'SL': case 'CL': return 'rgb(100, 177, 255)';
                        case 'EF': return 'blue';
                        case 'FL': return '#14d6e0';
                        default: return 'gray';
                    }
                }
                            // Fetch leave requests on page load
            fetchLeaveRequests();
            function attachEventListeners() {
                const acceptButtons = document.querySelectorAll('.accept-btn');
                const rejectButtons = document.querySelectorAll('.reject-btn');
                acceptButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        populateModal(this, 'approved');
                        $('#LeaveAuthorisation').modal('show');
                    });
                });
                rejectButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        populateModal(this, 'rejected');
                        $('#LeaveAuthorisation').modal('show');
                    });
                });
            }
            // function populateModal(button, status) {
            //     document.getElementById('employeename').value = button.getAttribute('data-name');
            //     document.getElementById('leavetype').value = button.getAttribute('data-leavetype');
            //     document.getElementById('from_date').value = button.getAttribute('data-from_date');
            //     document.getElementById('to_date').value = button.getAttribute('data-to_date');
            //     document.getElementById('total_days').value = button.getAttribute('data-total_days');
            //     document.getElementById('leavereason').value = button.getAttribute('data-reason');
            //     document.getElementById('leavetype_day').value = button.getAttribute('data-leavetype_day');
            //     $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));
            //     const statusDropdown = document.getElementById('StatusDropdown');
            //     statusDropdown.value = status; // Set 'approved' or 'rejected'
            // }
            function populateModal(button, status) {
                // Update the text content of the span elements
                document.getElementById('employeename').textContent = button.getAttribute('data-name');
                document.getElementById('leavetype').textContent = button.getAttribute('data-leavetype');
                // Get the 'data-from_date' and 'data-to_date' attributes
                var fromDate = button.getAttribute('data-from_date');
                var toDate = button.getAttribute('data-to_date');

                // Format the dates using the formatDateDDMMYYYY function
                var formattedFromDate = formatDateddmmyyyy(fromDate);
                var formattedToDate = formatDateddmmyyyy(toDate);

                // Set the formatted dates to the elements
                document.getElementById('from_date').textContent = formattedFromDate;
                document.getElementById('to_date').textContent = formattedToDate;
                document.getElementById('total_days').textContent = button.getAttribute('data-total_days');
                document.getElementById('leavereason').textContent = button.getAttribute('data-reason');
                // document.getElementById('leavetype_day').textContent = button.getAttribute('data-leavetype_day');
                // Get the value of 'data-leavetype_day' from the button's attribute
                    var leaveType = button.getAttribute('data-leavetype_day');

                    // Check the value of leaveType and update the textContent
                    if (leaveType === 'fullday') {
                        document.getElementById('leavetype_day').textContent = 'Full Day';
                    } else if (leaveType === '1sthalf') {
                        document.getElementById('leavetype_day').textContent = '1st Half';
                    } else if (leaveType === '2ndhalf') {
                        document.getElementById('leavetype_day').textContent = '2nd Half';
                    } else {
                        document.getElementById('leavetype_day').style.display = 'none'; // Hide the span if invalid
                        document.getElementById('leavetype_label').style.display = 'none'; // Hide the label if invalid

                    }
                $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));
                // Display status as text (Approved or Rejected)
                const statusDropdown = document.getElementById('StatusDropdown');
                statusDropdown.value = status; // Set 'approved' or 'rejected'
            }
            
            document.getElementById('sendButton').addEventListener('click', function () {
    const form = document.getElementById('attendanceForm');
    
    // Create FormData from the form
    let formData = new FormData();

    // Collect all visible form elements (input, select, textarea)
    let formElements = form.querySelectorAll('input, select, textarea');

    // Loop through form elements to add them to FormData (including visible ones)
    formElements.forEach(function (element) {
        // Only add the element if it is visible (i.e., its closest form group is visible)
        if (element.closest('.form-group') && element.closest('.form-group').style.display !== 'none') {
            formData.append(element.name, element.value);
        }
    });

    // Add hidden fields manually (even if they're not visible)
    const hiddenFields = ['_token', 'employeeid', 'Atct', 'requestDate'];

    hiddenFields.forEach(function(field) {
        const hiddenElement = document.getElementById(field);
        if (hiddenElement) {
            formData.append(field, hiddenElement.value);
        }
    });

    $('#loader').show();

    // Use Fetch API to submit the form
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
        }
    })
                    .then(response => response.json())
                    .then(data => {
                        $('#loader').hide(); 
                        // const responseMessage = document.getElementById('responseMessage');
                        // // Set the message text
                        // responseMessage.innerText = data.message;
                        // // Show the message box
                        // responseMessage.style.display = 'block';
                        if (data.success) {
                            // Display success toast
                            toastr.success(data.message, 'Success', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 10000  // Duration for which the toast is visible (in ms)
                            });
                            // Optionally, you can hide the modal and reset the form after a delay
                            setTimeout(function () {
                                $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 2 seconds
                                $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form
                                location.reload();
                            }, 2000);  // 2000 milliseconds = 2 seconds
                        } else {
                            // Display error toast
                            toastr.error(data.message, 'Error', {
                                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            });
                        $('#loader').hide(); 

                            
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request.');
                        $('#loader').hide(); 

                    });
                    
            });
            
            // const employeeId = {{ Auth::user()->EmployeeID }}; // Assuming you're using Blade syntax for PHP
            fetchLeaveBalance(employeeId);
            const requestCardsContainer = document.getElementById('requestcardsattendance');
            requestCardsContainer.style.display = 'none';
            fetchAttendanceRequests(employeeId);
            function fetchAttendanceRequests(employeeId) {
                const requestCardsContainer = document.getElementById('requestcardsattendance');
                requestCardsContainer.style.display = 'none';
                fetch(`/fetch-attendance-requests?employee_id=${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const requestCardsContainer = document.getElementById('requestcardsattendance');
                        const requestCards = document.getElementById('requestCards');
                        // Clear existing content
                        requestCards.innerHTML = '';
                        if (data && data.message) {
                            // If there's a message in 'data.message', show it in the alert
                            const messageAlert = document.createElement('div');
                            messageAlert.classList.add('alert', 'alert-warning', 'attendancedatanotfound');
                            messageAlert.setAttribute('role', 'alert');
                            messageAlert.textContent = data.message; // Display the message from the data
                            requestCards.appendChild(messageAlert);
                        } else {
                            // Show the section if there are requests
                            requestCardsContainer.style.display = 'flex';
                            data.forEach(request => {
                                console.log(request.request.OutRemark);

                                const requestCard = `
                                <div class="card p-3 mb-3 late-atnd" style="border:1px solid #ddd;">
                                    <div class="img-thumb mb-1" style="border-bottom:1px solid #ddd;">
                                        <div class="float-start emp-request-leave">                                            
                                            <img class="float-start me-2" src="https://vnrseeds.co.in/AdminUser/EmpImg${request.employeeDetails.CompanyId}Emp/${request.employeeDetails.ECode}.jpg">
                                            <b>Emp Code: ${request.employeeDetails.EmpCode}</b>
                                            <p>${request.employeeDetails.Fname} ${request.employeeDetails.Sname} ${request.employeeDetails.Lname}</p>
                                        </div>
                                    <div class="float-end">
                                    <a href="#" 
                                    class="mb-0 sm-btn mr-1 effect-btn btn btn-success approval-btn" 
                                    title="Approval" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#AttendenceAuthorisationRequest"
                                    data-request-date="${new Date(request.request.AttDate).toLocaleDateString('en-GB')}"
                                    data-in-reason="${request.request.InReason || 'N/A'}"
                                    data-in-remark="${request.request.InRemark || 'N/A'}"
                                    data-out-reason="${request.request.OutReason || 'N/A'}"
                                    data-out-remark="${request.request.OutRemark || 'N/A'}"
                                    data-other-reason="${request.request.Reason || 'N/A'}"
                                    data-other-remark="${request.request.Remark || 'N/A'}"
                                    data-inn-time="${request.InTime || 'N/A'}"
                                    data-out-time="${request.OutTime || 'N/A'}"
                                    data-employee-id="${request.employeeDetails.EmployeeID || 'N/A'}"
                                    style="padding: 4px 10px; font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word; cursor: pointer;">
                                        Approval
                                    </a>
                                    <a href="#" 
                                    class="mb-0 sm-btn effect-btn btn btn-danger rejection-btn" 
                                    title="Reject" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#AttendenceAuthorisationRequest"
                                    data-request-date="${new Date(request.request.AttDate).toLocaleDateString('en-GB')}"
                                    data-in-reason="${request.request.InReason || 'N/A'}"
                                    data-in-remark="${request.request.InRemark || 'N/A'}"
                                    data-out-reason="${request.request.OutReason || 'N/A'}"
                                    data-out-remark="${request.request.OutRemark || 'N/A'}"
                                    data-other-reason="${request.request.Reason || 'N/A'}"
                                    data-other-remark="${request.request.Remark || 'N/A'}"
                                    data-inn-time="${request.InTime || 'N/A'}"
                                    data-out-time="${request.OutTime || 'N/A'}"
                                    data-employee-id="${request.employeeDetails.EmployeeID || 'N/A'}"
                                    style="padding: 4px 10px; font-size: 10px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; word-wrap: break-word; cursor: pointer;">
                                        Reject
                                    </a>
                                </div>

                                    </div>
                                    <div style="color:#777171; float: left; width: 100%; margin : 5px 0px 0px 0px;">
                                        <small><b class="float-start mr-2" style="color:#000;">${new Date(request.request.AttDate).toLocaleDateString('en-GB')}</b></small>
                                        <span class="float-start">
                                            Punch in 
                                            <span class="${(request.InTime > request.II || request.InTime == '00:00') ? 'danger' : ''}">
                                                <b>${formatTime(request.InTime) || 'N/A'}</b>

                                            </span>
                                        </span>
                                        <span class="float-end">
                                            Punch Out 
                                            <span class="${(request.OutTime < request.OO) ? 'danger' : ''}">
                                                <b>${formatTime(request.OutTime) || 'N/A'}</b>
                                            </span>
                                        </span>
                                        <br>
                                        <p style="word-break: break-word;">
                                        <small>
                                            ${request.request.InRemark && request.request.OutRemark 
                                                ? `${request.request.InRemark}, ${request.request.OutRemark}` 
                                                : request.request.Remark 
                                                ? request.request.Remark 
                                                : request.request.InRemark 
                                                ? request.request.InRemark 
                                                : request.request.OutRemark 
                                                ? request.request.OutRemark 
                                                : 'No additional information.'}
                                        </small>
                                        </p>
                                    </div>
                                </div>`;
                                document.getElementById('requestCards').insertAdjacentHTML('beforeend', requestCard);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching requests:', error);
                    });
            }
            // Helper function to format time to HH:mm (hours and minutes)
            function formatTime(time) {
                if (!time || time === '00:00') {
                    return 'N/A'; // Return 'N/A' if time is empty or '00:00'
                }
                // Extract hours and minutes (HH:mm)
                const [hours, minutes] = time.split(':');  // Split by colon
                return `${hours}:${minutes}`;  // Return formatted time as HH:mm
            }

        
            function fetchLeaveBalance(employeeId) {
                fetch(`/leave-balance/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const leaveBalancesContainer = document.getElementById('leave-balances');
                        leaveBalancesContainer.innerHTML = ''; // Clear previous data
                        const leaveTypes = [
                            { label: 'Casual Leave(CL)', used: data.casualLeave.used, balance: data.casualLeave.balance, percentage: data.casualLeave.percentage },
                            { label: 'Sick Leave(SL)', used: data.sickLeave.used, balance: data.sickLeave.balance, percentage: data.sickLeave.percentage },
                            { label: 'Privilege Leave(PL)', used: data.privilegeLeave.used, balance: data.privilegeLeave.balance, percentage: data.privilegeLeave.percentage },
                            { label: 'Earn Leave(EL)', used: data.earnedLeave.used, balance: data.earnedLeave.balance, percentage: data.earnedLeave.percentage },
                            { label: 'Festival Leave(FL)', used: data.festivalLeave.used, balance: data.festivalLeave.balance, percentage: data.festivalLeave.percentage }
                        ];
                        leaveTypes.forEach(leave => {

                            const colDiv = document.createElement('div');
                            colDiv.className = 'col';
                            colDiv.innerHTML = `
                    <div class="row prooduct-details-box p-1 mb-3 leave-bal">
                        <div class="col-md-12">
                            <b>${leave.label}</b>
                        </div>
                        <div class="pie-wrapper" style="margin: 5px; auto;">
                            <div style="border-color: #659093;" class="arc" data-value="${leave.percentage}"></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center" style="border-right:1px solid #ddd;">
                            <p>Used<br><span class="text-secondary"><b>${leave.used}</b></span></p>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 text-center">
                            <p>BL<br><span class="text-success"><b>${leave.balance}</b></span></p>
                        </div>
                    </div>
                `;
                            leaveBalancesContainer.appendChild(colDiv);
                        });
                    })
                    .catch(error => console.error('Error fetching leave balance:', error));
            }
            // Call the function when the page loads
            document.addEventListener('DOMContentLoaded', () => {
                const employeeId = {{ Auth::user()->EmployeeID }}; // Replace with your method to get employee ID
                fetchLeaveBalance(employeeId);
            });
            async function fetchLeaveRequests_req() {
                try {
                    const response = await fetch(`/leave-requests-all?employee_id=${employeeId}`);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    const data = await response.json();
                    displayLeaveRequests(data);
                } catch (error) {
                    console.error('Error fetching leave requests:', error);
                }
            }
        
function displayLeaveRequests(leaveRequests) {
    const cardContainer = document.querySelector('#leaveRequestCard .my-request');
    const cardHeader = document.querySelector('#leaveRequestCard');
    const leaveRequestCard = document.querySelector('#leaveRequestCard'); // The entire card element
    // If no leave requests, hide the card
    /*if (leaveRequests.message == "No data") {
        leaveRequestCard.style.display = 'none';  // Hide the entire card
        return;
    }*/

    cardHeader.style.display = 'block';
    cardContainer.innerHTML = '';  // Clear existing content

    leaveRequests.forEach(request => {
        let leaveStatus;
        let statusClass;

        // Determine leave status
        if (request.leaveRequest.LeaveStatus == '1' || request.leaveRequest.LeaveStatus == '2') {
            leaveStatus = 'Approved';
            statusClass = 'success';
        } else if (request.leaveRequest.LeaveStatus == '0') {
            leaveStatus = 'Pending';
            statusClass = 'danger';
        } else if (request.leaveRequest.LeaveStatus == '4') {
            leaveStatus = 'Cancelled';
            statusClass = 'danger';
        } else if (request.leaveRequest.LeaveStatus == '3') {
            leaveStatus = 'Draft';
            statusClass = 'warning';
        } else {
            leaveStatus = 'Unknown';
            statusClass = 'secondary';
        }

        // Create leave request card HTML
        const cardHtml = `
            <div class="leave-request-box">
                <label class="mb-0 badge" style="background-color: ${getLeaveTypeColor(request.leaveRequest.Leave_Type)};">
                    ${request.leaveRequest.Leave_Type}
                </label>
                <span class="me-3 ms-2"><b><small>${formatDateddmmyyyy(request.leaveRequest.Apply_FromDate)}</small></b></span>
                To <span class="ms-3 me-3"><b><small>${formatDateddmmyyyy(request.leaveRequest.Apply_ToDate)}</small></b></span>
               <span style="padding: 4px 8px; font-size: 10px; margin-left: 5px; margin-top: -1px; cursor: default; pointer-events: none;" 
                     class="mb-0 sm-btn effect-btn btn btn-${statusClass} float-end" title="${leaveStatus}" 
                     data-original-title="${leaveStatus}">
                     ${leaveStatus}
                 </span>
                <span class="float-end btn-outline primary-outline p-0 pe-1 ps-1">
                    <small><b>${request.leaveRequest.Apply_TotalDay} Days</b></small>
                </span>
                <p class="my-request-msg">
                    <small>${request.leaveRequest.Apply_Reason}</small>
                </p>
                <!--<div class="attendance-request">
                    <h5>ATTENDANCE REQUEST</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>In</th>
                                <th>Out</th>
                                <th>Other</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${renderAttendanceRows(request.attendanceRequests)}
                        </tbody>
                    </table>
                </div>-->
            </div>
        `;
        cardContainer.innerHTML += cardHtml;  // Append the new card
    });
}

// Function to render attendance request rows with Requested Date, In, Out, Other, and Reason
function renderAttendanceRows(attendanceRequests) {
    return attendanceRequests.map(attRequest => {
        // Render the requested date, In/Out/Other dates, and their reasons in vertical format
        return `
            <tr>
                <td><b>Requested Date:</b> ${formatDateddmmyyyy(attRequest.ReqDate)}</td>
                <td><b>Requested Date:</b> ${formatDateddmmyyyy(attRequest.ReqDate)}</td>
                <td><b>Requested Date:</b> ${formatDateddmmyyyy(attRequest.ReqDate)}</td>
                <td><b>Requested Date:</b> ${attRequest.Status}</td>
            </tr>
            <tr>
                <td><b>In Date:</b> ${formatDateddmmyyyy(attRequest.InDate)}</td>
                <td><b>Out Date:</b> ${formatDateddmmyyyy(attRequest.OutDate)}</td>
                <td><b>Other Date:</b> ${formatDateddmmyyyy(attRequest.OtherDate || '')}</td>
                <td><b>Status:</b> ${attRequest.Status}</td>
            </tr>
            <tr>
                <td><b>In Reason:</b> ${attRequest.InReason}</td>
                <td><b>Out Reason:</b> ${attRequest.OutReason}</td>
                <td><b>Other Reason:</b> ${attRequest.OtherReason || ''}</td>
                <td><b>Status Reason:</b> ${attRequest.StatusReason}</td>
            </tr>
        `;
    }).join('');
}

// Utility function to get leave type color
function getLeaveTypeColor(leaveType) {
    switch (leaveType) {
        case 'CH':
        case 'SH':
        case 'PL':
        case 'SL':
        case 'CL':
        case 'EL':
        case 'FL':
            return 'rgb(100, 177, 255)';
        case 'EF':
            return 'blue';
        default:
            return 'gray';
    }
}

// Utility function to format date in dd/mm/yyyy format
function formatDateddmmyyyy(date) {
    if (!date) return '';
    const d = new Date(date);
    return d.getDate().toString().padStart(2, '0') + '/' + (d.getMonth() + 1).toString().padStart(2, '0') + '/' + d.getFullYear();
}

            // Function to show leave request details in the modal
            function showLeaveRequestDetails(leaveType, fromDate, toDate, totalDays, status, reason) {
                document.querySelector('.leave-type').textContent = leaveType;
            // Apply dynamic background color based on the leave type
            const leaveTypeElement = document.querySelector('.leave-type');
            leaveTypeElement.style.backgroundColor = 
                leaveType === 'CH' || leaveType === 'SH' || leaveType === 'PL' || leaveType === 'SL'||leaveType === 'EL' || leaveType === 'CL' ? 'rgb(100, 177, 255)' :
                leaveType === 'FL' ? '#14d6e0' :
                'gray';  // Default color if no match
                document.querySelector('.date-range').innerHTML = `${formatDateddmmyyyy(fromDate)} <strong class="me-2 ml-2">To</strong> ${formatDateddmmyyyy(toDate)}`;
                document.querySelector('.total-days').textContent = `${totalDays} Days`;
                //document.querySelector('.leave-status').innerHTML = `<strong>Status:</strong> <span class="success">${status}</span>`;
                document.querySelector('.leave-reason').innerHTML = `<strong class="me-2 ml-2">Leave Reason:</strong> ${reason}`;
            }
            
            fetchLeaveRequests_req();
            function fetchAttendanceData(selectedMonth, year) {
                const monthNumber = monthNames.indexOf(selectedMonth) + 1;
                const employeeId = {{ Auth::user()->EmployeeID }};
                const today = new Date();
                const todayString = today.toISOString().split('T')[0]; // '2024-10-02'
                // const monthYearHeader = document.querySelector('.card-header h4');
                // monthYearHeader.textContent = `${selectedMonth} ${year}`;
                cardHeaders.forEach(header => {
                    header.textContent = `${selectedMonth} ${year}`;
                });
                //  if (celebration) {
                //     celebration.textContent = `Celebration's ${selectedMonth} ${year}`;
                // }
                const currentDate = new Date();
                    const currentMonth = currentDate.toLocaleString('en-US', { month: 'long' });
                    const currentYear = currentDate.getFullYear();
                    if (celebration) {
                        celebration.textContent = `Celebration's ${currentMonth} ${currentYear}`;
                    }
                // if (cardHeaderRequest) {
                //     cardHeaderRequest.textContent = `My Request ${selectedMonth} ${year}`;
                // }
                // Get yesterday's date in the required format (dd-mm-yyyy)
                // Function to get yesterday's date (1 day before)
            // Function to get yesterday's date, but if it's Sunday, return the previous Friday
            function getYesterdayDate() {
                const today = new Date();
                const yesterday = new Date(today);

                // Subtract 1 day to get yesterday's date
                yesterday.setDate(today.getDate() - 1);

                // If yesterday is Sunday, return the previous Friday
                if (yesterday.getDay() === 0) {  // Sunday is 0
                    yesterday.setDate(yesterday.getDate() - 1);  // Subtract 2 more days to get Friday
                }

                // Format date as yyyy-mm-dd
                const day = String(yesterday.getDate()).padStart(2, '0');
                const month = String(yesterday.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
                const year = yesterday.getFullYear();

                return `${year}-${month}-${day}`; // Return date in yyyy-mm-dd format
            }


                fetch(`/attendance/${year}/${monthNumber}/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const calendar = document.querySelector('.calendar tbody');
                        calendar.innerHTML = '';
                        const daysInMonth = new Date(year, monthNumber, 0).getDate();
                        const firstDayOfMonth = new Date(year, monthNumber - 1, 1).getDay();
                        const yesterdayString = getYesterdayDate();
                        let punchInTime = '00:00 AM';
                        let punchOutTime = '00:00 PM';
                        let lastUpdatedText = 'Not Available';
                        // Iterate through the attendance data
                        // for (const attendance of data) {
                        //     if (attendance.AttDate === yesterdayString) {
                        //         punchInTime = attendance.Inn !== '00:00' ? attendance.Inn : '00:00 ';
                        //         punchOutTime = attendance.Outt !== '00:00' ? attendance.Outt : '00:00 ';
                        //         // lastUpdatedText = formatDateddmmyyyy("2024-12-09") || 'Not Available';
                        //         break; // Exit loop once today's record is found
                        //     }
                        // }
                        // Update the HTML elements
                        // document.getElementById('punchIn').innerHTML = `<b>${punchInTime}</b>`;
                        // document.getElementById('punchOut').innerHTML = `<b>${punchOutTime}</b>`;
                        // document.getElementById('lastUpdated').querySelector('b').textContent = lastUpdatedText;
                        /*document.getElementById('currentDate').textContent = today.toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });*/
                        let currentRow = document.createElement('tr');
                        let latenessCount = 0;
                        for (let i = 0; i < firstDayOfMonth; i++) {
                            const emptyCell = document.createElement('td');
                            emptyCell.classList.add('day');
                            currentRow.appendChild(emptyCell);
                        }
                        for (let day = 1; day <= daysInMonth; day++) {
                            const dayData = data.find(record => {
                                const recordDate = new Date(record.AttDate);
                                return recordDate.getDate() === day && recordDate.getMonth() + 1 === monthNumber;
                            });
                            const cell = document.createElement('td');
                            cell.classList.add('day');
                            const currentDate = new Date(year, monthNumber - 1, day);
                            if (currentDate.getDay() === 0) { // 0 is Sunday
                                cell.style.backgroundColor = 'rgb(209,243,174)';
                                cell.innerHTML = `<div class="day-num">${day}</div>`; // Just show the day number
                            }
                            else {
                                if (dayData) {
                                    const today = new Date();
                                    const attValue = dayData.AttValue;
                                    const innTime = dayData.Inn;
                                    const iiTime = dayData.II;
                                    let latenessStatus = '';
                                    if (
                                            (dayData.TimeApply == 'Y' && dayData.InnLate == 1 && dayData.InnCnt == 'Y' && dayData.AttValue != 'OD' && dayData.LeaveApplied == 0) ||
                                            (dayData.TimeApply == 'Y' && dayData.OuttLate == 1 && dayData.OuttCnt == 'Y' && dayData.AttValue != 'OD' && dayData.LeaveApplied == 0)
                                        ){
                                        // if (innTime > iiTime || dayData.Outt < dayData.OO) {
                                            latenessCount++;
                                            latenessStatus = `L${latenessCount}`;
                                        // }
                                    }
                                    let Atct = 0; // Initialize Atct
                                    if (dayData['InnLate'] == 1 && dayData['OuttLate'] == 0) {
                                        Atct = 1;
                                    } else if (dayData['InnLate'] == 0 && dayData['OuttLate'] == 1) {
                                        Atct = 2;
                                    } else if (dayData['InnLate'] == 1 && dayData['OuttLate'] == 1) {
                                        Atct = 12;
                                    } else if ((dayData['InnLate'] == 0 || dayData['InnLate'] === '') && (dayData['OuttLate'] == 0 || dayData['OuttLate'] === '')) {
                                        Atct = 3;
                                    }
                                    today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison
                                    let iconHtml = '';
                                    const isCurrentMonth = monthNumber === today.getMonth() + 1;
                                    const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month
                                    //if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        if (dayData.Inn > dayData.II || dayData.Outt < dayData.OO || dayData.Inn === dayData.Outt) {
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        }
                                    //}
                                    let attenBoxContent = '';
                                    const istoday = new Date().toISOString().split('T')[0]; // Get today's date in 'YYYY-MM-DD' format
                                

                                    if (latenessStatus && dayData.Status === 0  && dayData.AttDate !== istoday && attValue == "P") {
                                        attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    }
                                    // if (latenessStatus && dayData.Status === 1  && attValue == "P") {
                                    if (latenessStatus && dayData.Status === 1 && dayData.AttDate !== istoday && attValue == "P") {

                                        // If status is 1 and latenessStatus already shown, do not add it again
                                        if (!attenBoxContent.includes(latenessStatus)) {
                                            attenBoxContent += `<span class="atte-late-status">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                        }
                                    }
                                    draft = (dayData.DraftStatus === null || dayData.DraftStatus === "null" || dayData.DraftStatus === "") ? 0 : Number(dayData.DraftStatus);
                                    switch (attValue) {
                                        case 'P':
                                            attenBoxContent += `<span class="atte-present">P</span>`;
                                            attenBoxContent += `
                                                   <a href="#" 
                                                    class="open-modal" 
                                                    data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                    data-inn="${innTime}" 
                                                    data-out="${dayData.Outt}" 
                                                    data-ii="${dayData.II}" 
                                                    data-oo="${dayData.OO}" 
                                                    data-atct="${Atct}" 
                                                    data-employee-id="${employeeId}" 
                                                    data-exist="${dayData.DataExist}" 
                                                    data-status="${dayData.Status}" 
                                                    data-draft="${draft}" 
                                                    data-in-status="${dayData.RequestDetails && dayData.RequestDetails.InStatus !== undefined ? dayData.RequestDetails.InStatus : ''}" 
                                                    data-out-status="${dayData.RequestDetails && dayData.RequestDetails.OutStatus !== undefined ? dayData.RequestDetails.OutStatus : ''}" 
                                                    data-s-status="${dayData.RequestDetails && dayData.RequestDetails.SStatus !== undefined ? dayData.RequestDetails.SStatus : ''}">
                                                    ${iconHtml}
                                                </a>
                                                `
                                            break;
                                        case 'A':
                                            attenBoxContent += `<span class="atte-absent">A</span>`;
                                            break;
                                            case 'LWP':
                                            attenBoxContent += `<span style="border-radius: 50%;
                                                                background-color: #f3f0F0;
                                                                color: #040404;
                                                                font-weight: 300;
                                                                line-height: 30px;
                                                                width: 30px;
                                                                height: 30px;">LWP</span>`;
                                            break;
                                        case 'HF':
                                            attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                            attenBoxContent += `
                                                    <a href="#" 
                                                    class="open-modal" 
                                                    data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                    data-inn="${innTime}" 
                                                    data-out="${dayData.Outt}" 
                                                    data-ii="${dayData.II}" 
                                                    data-oo="${dayData.OO}" 
                                                    data-atct="${Atct}" 
                                                    data-employee-id="${employeeId}" 
                                                    data-exist="${dayData.DataExist}" 
                                                    data-status="${dayData.Status}" 
                                                    data-draft="${draft}" 
                                                    data-in-status="${dayData.RequestDetails && dayData.RequestDetails.InStatus !== undefined ? dayData.RequestDetails.InStatus : ''}" 
                                                    data-out-status="${dayData.RequestDetails && dayData.RequestDetails.OutStatus !== undefined ? dayData.RequestDetails.OutStatus : ''}" 
                                                    data-s-status="${dayData.RequestDetails && dayData.RequestDetails.SStatus !== undefined ? dayData.RequestDetails.SStatus : ''}">
                                                    ${iconHtml}
                                                </a>
                                                `
                                            break;

                                        case 'HO':
                                            attenBoxContent += `<span class="holiday-cal">${attValue}</span>`;
                                            break;
                                        case 'OD':
                                            attenBoxContent += `<span class="atte-OD">${attValue}</span>`;
                                            attenBoxContent += `
                                                    <a href="#" 
                                                    class="open-modal" 
                                                    data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                    data-inn="${innTime}" 
                                                    data-out="${dayData.Outt}" 
                                                    data-ii="${dayData.II}" 
                                                    data-oo="${dayData.OO}" 
                                                    data-atct="${Atct}" 
                                                    data-employee-id="${employeeId}" 
                                                    data-exist="${dayData.DataExist}" 
                                                    data-status="${dayData.Status}" 
                                                    data-draft="${draft}" 
                                                    data-in-status="${dayData.RequestDetails && dayData.RequestDetails.InStatus !== undefined ? dayData.RequestDetails.InStatus : ''}" 
                                                    data-out-status="${dayData.RequestDetails && dayData.RequestDetails.OutStatus !== undefined ? dayData.RequestDetails.OutStatus : ''}" 
                                                    data-s-status="${dayData.RequestDetails && dayData.RequestDetails.SStatus !== undefined ? dayData.RequestDetails.SStatus : ''}">
                                                    ${iconHtml}
                                                </a>
                                                `
                                            break;
                                        case 'PH':
                                        case 'CH':
                                        case 'SH':
                                        case 'PL':
                                        case 'FL':
                                        case 'SL':
                                        case 'CL':
                                        case 'EL':
                                            attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                            attenBoxContent += `
                                                   <a href="#" 
                                                    class="open-modal" 
                                                    data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                    data-inn="${innTime}" 
                                                    data-out="${dayData.Outt}" 
                                                    data-ii="${dayData.II}" 
                                                    data-oo="${dayData.OO}" 
                                                    data-atct="${Atct}" 
                                                    data-employee-id="${employeeId}" 
                                                    data-exist="${dayData.DataExist}" 
                                                    data-status="${dayData.Status}" 
                                                    data-draft="${draft}" 
                                                    data-in-status="${dayData.RequestDetails && dayData.RequestDetails.InStatus !== undefined ? dayData.RequestDetails.InStatus : ''}" 
                                                    data-out-status="${dayData.RequestDetails && dayData.RequestDetails.OutStatus !== undefined ? dayData.RequestDetails.OutStatus : ''}" 
                                                    data-s-status="${dayData.RequestDetails && dayData.RequestDetails.SStatus !== undefined ? dayData.RequestDetails.SStatus : ''}">
                                                    ${iconHtml}
                                                </a>
                                                `
                                            break;
                                        default:
                                            attenBoxContent += `
                                            <span class="atte-present"></span>
                                                    <a href="#" 
                                                    class="open-modal" 
                                                    data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                    data-inn="${innTime}" 
                                                    data-out="${dayData.Outt}" 
                                                    data-ii="${dayData.II}" 
                                                    data-oo="${dayData.OO}" 
                                                    data-atct="${Atct}" 
                                                    data-employee-id="${employeeId}" 
                                                    data-exist="${dayData.DataExist}" 
                                                    data-status="${dayData.Status}" 
                                                    data-draft="${draft}" 
                                                    data-in-status="${dayData.RequestDetails && dayData.RequestDetails.InStatus !== undefined ? dayData.RequestDetails.InStatus : ''}" 
                                                    data-out-status="${dayData.RequestDetails && dayData.RequestDetails.OutStatus !== undefined ? dayData.RequestDetails.OutStatus : ''}" 
                                                    data-s-status="${dayData.RequestDetails && dayData.RequestDetails.SStatus !== undefined ? dayData.RequestDetails.SStatus : ''}">
                                                    ${iconHtml}
                                                </a>
                                                `
                                            break;
                                    }
                                    
                                    // If the attendance value is 'P', check for lateness but do not repeat it
                                    // if (attValue === 'P' && latenessStatus && !latenessDisplayed) {
                                    //     attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`;
                                    // }
                                    // if (latenessStatus && dayData.Status === 0) {
                                    //     attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    // }
                                    // if (latenessStatus && dayData.Status === 1) {
                                    //     // If status is 1 and latenessStatus already shown, do not add it again
                                    //     if (!attenBoxContent.includes(latenessStatus)) {
                                    //         attenBoxContent += `<span class="atte-late-status">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    //     }
                                    // }
                                    
                                    const punchInDanger = dayData.Inn > dayData.II && !isToday(dayData.AttDate) ? 'danger' : '';  // Add danger only if it's not today
                                    const punchOutDanger = dayData.OO > dayData.Outt && !isToday(dayData.AttDate) ? 'danger' : '';  // Add danger only if it's not today

                                    cell.innerHTML = `
                                        <div class="day-num">${day}</div>
                                        <div class="punch-section">
                                            <span class="${punchInDanger}"><b>In:</b> ${innTime || '00:00'}</span><br>
                                            <span class="${punchOutDanger}"><b>Out:</b> ${dayData.Outt || '00:00'}</span>
                                        </div>
                                        <div class="atten-box">${attenBoxContent}</div>
                                    `;
                                }
                                else {
                                    const today = new Date();
                                    today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison
                                    let iconHtml = '';
                                    const isCurrentMonth = monthNumber === today.getMonth() + 1;
                                    const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month
                                    //if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                    //}
                                    cell.innerHTML = `
                                    <div class="day-num">${day}</div>
                                    <div class="atten-box">
                                        <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="00:00" data-out="00:00" data-ii="00:00" data-oo="00:00" data-atct="3" data-employee-id="${employeeId}" data-draft="0">
                                                 ${iconHtml}
                                        </a></div>`;
                                }
                            }
                            currentRow.appendChild(cell);
                            if ((firstDayOfMonth + day) % 7 === 0) {
                                calendar.appendChild(currentRow);
                                currentRow = document.createElement('tr');
                            }
                        }
                        if (currentRow.childElementCount > 0) {
                            calendar.appendChild(currentRow);
                        }
                    })
                    .catch(error => console.error('Error fetching attendance data:', error));
            }
        });
        $(document).ready(function () {
            $('#queryForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                const url = $(this).attr('action'); // Form action URL
                $('#loader').show(); // Show loader before the request is sent
                $('#queryForm button[type="submit"]').prop('disabled', true);

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Query form submitted', {
                        "positionClass": "toast-top-right",  // Position it at the top right of the screen
                        "timeOut": 1000  // Duration for which the toast is visible (in ms)
                    });
                     window.location.reload();
                } else {
                    toastr.error(response.message, 'Error', {
                        "positionClass": "toast-top-right",  // Position it at the top right of the screen
                        "timeOut": 1000  // Duration for which the toast is visible (in ms)
                    });
                    window.location.reload();
                }
                $('#loader').hide(); // Hide loader after the request is complete
                $('#queryForm button[type="submit"]').prop('disabled', false);

            },
            error: function (xhr, status, error) {
                // Handle any errors from the server here
                let errorMessage = 'An error occurred while submitting the form.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                // toastr.error(errorMessage, 'Error', {
                //     "positionClass": "toast-top-right",  // Position it at the top right of the screen
                //     "timeOut": 5000  // Duration for which the toast is visible (in ms)
                // });

                $('#loader').hide(); // Hide loader after error
                $('#queryForm button[type="submit"]').prop('disabled', false);

            }
                
            });
            });
        });
        
        document.getElementById('Department_name').addEventListener('change', function () {
            var selectedDepartmentId = this.value; // Get selected department ID
            var subjectSelect = document.getElementById('Department_name_sub');
            // Clear current subjects
            subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
            // Loop through all subject options
            var options = @json($departments_sub); // Get subjects as a JSON array
            options.forEach(function (department_sub) {
                if (department_sub.DepartmentId == selectedDepartmentId) {
                    var option = document.createElement('option');
                    option.value = department_sub.DeptQSubject;
                    option.text = department_sub.DeptQSubject;
                    subjectSelect.appendChild(option);
                }
            });
        });
        const modal = document.getElementById('AttendenceAuthorisationRequest');
        let inn_time; // Declare variables in the outer scope
        let out_time;
        modal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const employeeId = button.getAttribute('data-employee-id'); // Get employee ID
            // Determine if the button is for approval or rejection
            const isApproval = button.classList.contains('approval-btn');
            const isReject = button.classList.contains('rejection-btn');
            // Get dropdown elements
            const inStatusDropdown = document.getElementById('inStatusDropdown');
            const outStatusDropdown = document.getElementById('outStatusDropdown');
            const otherStatusDropdown = document.getElementById('otherStatusDropdown');
            // Preselect dropdown values based on the button clicked
            if (isApproval) {
                inStatusDropdown.value = 'approved';
                outStatusDropdown.value = 'approved';
                otherStatusDropdown.value = 'approved';
            } else if (isReject) {
                inStatusDropdown.value = 'rejected';
                outStatusDropdown.value = 'rejected';
                otherStatusDropdown.value = 'rejected';
            }
            // Set employee ID in a hidden input (to be submitted later)
            document.getElementById('employeeIdInput').value = employeeId;
            // Retrieve and display request-related information
            const requestDate = button.getAttribute('data-request-date');
            // Split the input date string to get day, month, and year
            const dateParts = requestDate.split('/');
            // Create a new Date object from the parts (Note: months are 0-based, so subtract 1 from the month)
            const dateObj = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
            // Define an array of month names
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            // Format the date
            const formattedDate = `${dateObj.getDate()}-${monthNames[dateObj.getMonth()]}-${dateObj.getFullYear()}`;
            // Set the formatted date in the textContent
            document.getElementById('request-date-repo').textContent = `Requested Date: ${formattedDate}`;
            // Reset all groups to be hidden initially
            const groups = [
                'statusGroupIn',
                'statusGroupOut',
                'statusGroupOther',
                'reasonInGroupReq',
                'reasonOutGroupReq',
                'reasonOtherGroupReq',
                'remarkInGroupReq',
                'remarkOutGroupReq',
                'remarkOtherGroupReq',
                'reportRemarkInGroup',
                'reportRemarkOutGroup',
                'reportRemarkOtherGroup'
            ];
            groups.forEach(group => {
                document.getElementById(group).style.display = 'none';
            });
            // Validate reasons
            const inReason = button.getAttribute('data-in-reason');
            const outReason = button.getAttribute('data-out-reason');
            const otherReason = button.getAttribute('data-other-reason');
            const isInReasonValid = inReason !== 'N/A';
            const isOutReasonValid = outReason !== 'N/A';
            const isOtherReasonValid = otherReason !== 'N/A';
            // Show sections based on reason validity
           // Show sections based on reason validity
           if (isInReasonValid && isOutReasonValid) {
            console.log('inout');
                    // Show both "In" and "Out" sections
                    document.getElementById('statusGroupIn').style.display = 'block';
                    document.getElementById('reasonInGroupReq').style.display = 'block';
                    document.getElementById('remarkInGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkInGroup').style.display = 'block';
                    
                    if (inReason) {
                        // Display Remark as text
                        document.getElementById('reasonInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <span id="reasonInDisplay" style="border: none; background: none;">${inReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonInDisplay').value = '';
                    }

                    // Handle the "In" Remark
                    let inRemarkValue = button.getAttribute('data-in-remark');
                    if (inRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Remark:</b></label><br>
                            <span id="remarkInReq" style="border: none; background: none;">${inRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkInReq').value = '';
                    }

                    // Show the "Out" sections
                    document.getElementById('statusGroupOut').style.display = 'block';
                    document.getElementById('reasonOutGroupReq').style.display = 'block';
                    document.getElementById('remarkOutGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkOutGroup').style.display = 'block';

                    // Set Reason Out
                    // document.getElementById('reasonOutDisplay').value = `${outReason}`;

                    if (outReason) {
                        // Display Remark as text
                        document.getElementById('reasonOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <span id="reasonOutDisplay" style="border: none; background: none;">${outReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonOutDisplay').value = '';
                    }

                    // Handle the "Out" Remark
                    let outRemarkValue = button.getAttribute('data-out-remark');
                    if (outRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Remark:</b></label><br>
                            <span id="remarkOutReq" style="border: none; background: none;">${outRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkOutReq').value = '';
                    }
                } 
                else if (isInReasonValid) {
                    console.log('in');

                    // Show only "In" section
                    document.getElementById('statusGroupIn').style.display = 'block';
                    document.getElementById('reasonInGroupReq').style.display = 'block';
                    document.getElementById('remarkInGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkInGroup').style.display = 'block';
                    
                    // Set Reason In
                    //document.getElementById('reasonInDisplay').value = `${inReason}`;
                    // Handle the "In" Remark
                    if (inReason) {
                        // Display Remark as text
                        document.getElementById('reasonInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Reason:</b></label>
                            <span id="reasonInDisplay" style="border: none; background: none;">${inReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonInDisplay').value = '';
                    }

                    // Handle the "In" Remark
                    let inRemarkValue = button.getAttribute('data-in-remark');
                    if (inRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkInGroupReq').innerHTML = `
                            <label class="col-form-label"><b>In Remark:</b></label><br>
                            <span id="remarkInReq" style="border: none; background: none;">${inRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkInReq').value = '';
                    }
                } else if (isOutReasonValid) {
                    // Show only "Out" section
                    document.getElementById('statusGroupOut').style.display = 'block';
                    document.getElementById('reasonOutGroupReq').style.display = 'block';
                    document.getElementById('remarkOutGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkOutGroup').style.display = 'block';

                    // Set Reason Out
                    if (outReason) {
                        // Display Remark as text
                        document.getElementById('reasonOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Reason:</b></label>
                            <span id="reasonOutDisplay" style="border: none; background: none;">${outReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonOutDisplay').value = '';
                    }

                    // Handle the "Out" Remark
                    let outRemarkValue = button.getAttribute('data-out-remark');
                    if (outRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkOutGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Out Remark:</b></label><br>
                            <span id="remarkOutReq" style="border: none; background: none;">${outRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkOutReq').value = '';
                    }
                } else if (!isInReasonValid && !isOutReasonValid && isOtherReasonValid) {
                    // Show "Other" section only
                    document.getElementById('statusGroupOther').style.display = 'block';
                    document.getElementById('reasonOtherGroupReq').style.display = 'block';
                    document.getElementById('remarkOtherGroupReq').style.display = 'block';
                    document.getElementById('reportRemarkOtherGroup').style.display = 'block';

                    // Set Other Reason
                    document.getElementById('reasonOtherDisplay').value = `${otherReason}`;

                    if (otherReason) {
                        // Display Remark as text
                        document.getElementById('reasonOtherGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Reason:</b></label>
                            <span id="reasonOtherDisplay" style="border: none; background: none;">${otherReason}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('reasonOtherDisplay').value = '';
                    }

                    // Handle the "Other" Remark
                    let otherRemarkValue = button.getAttribute('data-other-remark');
                    if (otherRemarkValue) {
                        // Display Remark as text
                        document.getElementById('remarkOtherGroupReq').innerHTML = `
                            <label class="col-form-label"><b>Remark:</b></label><br>
                            <span  id="remarkOtherReq" style="border: none; background: none;">${otherRemarkValue}</span>`;
                    } else {
                        // Display input for Remark
                        document.getElementById('remarkOtherReq').value = '';
                    }
                }

        
        });
        
        document.getElementById('sendButtonReq').addEventListener('click', function () {
            $('#loader').show(); 

            const requestDateText = document.getElementById('request-date-repo').textContent;
            const requestDate = requestDateText.replace('Requested Date: ', '').trim();
            const employeeId = document.getElementById('employeeIdInput').value; // Get employee ID from hidden input
            const repo_employeeId = {{ Auth::user()->EmployeeID }};
            // Prepare the data to be sent
            const formData = new FormData();
            formData.append('requestDate', requestDate);
            // Check visibility before appending values
            if (document.getElementById('statusGroupIn').style.display !== 'none') {
                const inStatus = document.getElementById('inStatusDropdown').value;
                const inReason = document.getElementById('reasonInDisplay').textContent;
                const inRemark = document.getElementById('remarkInReq').value;
                const reportRemarkIn = document.getElementById('reportRemarkInReq').value;
                if (inReason && inStatus) { // Append only if reason and status are valid
                    formData.append('inStatus', inStatus);
                    formData.append('inReason', inReason);
                    formData.append('inRemark', inRemark);
                    formData.append('reportRemarkIn', reportRemarkIn);
                }
            }
            if (document.getElementById('statusGroupOut').style.display !== 'none') {
                const outStatus = document.getElementById('outStatusDropdown').value;
                const outReason = document.getElementById('reasonOutDisplay').textContent;
                const outRemark = document.getElementById('remarkOutReq').value;
                const reportRemarkOut = document.getElementById('reportRemarkOutReq').value;
                if (outReason && outStatus) { // Append only if reason and status are valid
                    formData.append('outStatus', outStatus);
                    formData.append('outReason', outReason);
                    formData.append('outRemark', outRemark);
                    formData.append('reportRemarkOut', reportRemarkOut);
                }
            }
            if (document.getElementById('statusGroupOther').style.display !== 'none') {
                const otherStatus = document.getElementById('otherStatusDropdown').value;
                const otherReason = document.getElementById('reasonOtherDisplay').textContent;
                const otherRemark = document.getElementById('remarkOtherReq').value;
                const reportRemarkOther = document.getElementById('reportRemarkOtherReq').value;
                if (otherReason) { // Append only if reason is valid
                    formData.append('otherStatus', otherStatus);
                    formData.append('otherReason', otherReason);
                    formData.append('otherRemark', otherRemark);
                    formData.append('reportRemarkOther', reportRemarkOther);
                }
            }
            formData.append('employeeid', employeeId);
            formData.append('repo_employeeId', repo_employeeId);
            formData.append('inn_time', inn_time);
            formData.append('out_time', out_time);
            formData.append('_token', document.querySelector('input[name="_token"]').value); // CSRF token
               // AJAX request to send data to the controller
            $.ajax({
                url: '{{ route('attendance.updatestatus') }}', // Update with your route
                type: 'POST',
                data: formData,
                processData: false,  // Ensure FormData is not processed
                contentType: false,  // Ensure correct content type is sent
                success: function (response) {
                    if (response.success == true) {
                        $('#loader').hide(); 
                        console.log(response);
                        toastr.success(response.message, 'Success', {
                            "positionClass": "toast-top-right",
                            "timeOut": 5000
                        });

                        setTimeout(() => {
                            location.reload(); // Reload the page
                        }, 3000);
                    } else {
                        toastr.error(response.message, 'Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": 3000
                        });
                        $('#loader').hide(); 
                    }
                },
                error: function (xhr) {
                    // Handle any errors from the server
                    toastr.error('An error occurred. Please try again.', 'Error', {
                        "positionClass": "toast-top-right",  
                        "timeOut": 5000 
                    });
                    $('#loader').hide(); 
                }
            });
      });
       
//         const modal = document.getElementById('AttendenceAuthorisationRequest');
//         let inn_time; // Declare variables in the outer scope
//         let out_time;
//         modal.addEventListener('show.bs.modal', function (event) {
//             const button = event.relatedTarget; // Button that triggered the modal
//             const employeeId = button.getAttribute('data-employee-id'); // Get employee ID
//             // Determine if the button is for approval or rejection
//             const isApproval = button.classList.contains('approval-btn');
//             const isReject = button.classList.contains('reject-btn');
//             // Get dropdown elements
//             const inStatusDropdown = document.getElementById('inStatusDropdown');
//             const outStatusDropdown = document.getElementById('outStatusDropdown');
//             const otherStatusDropdown = document.getElementById('otherStatusDropdown');
//             // Preselect dropdown values based on the button clicked
//             if (isApproval) {
//                 inStatusDropdown.value = 'approved';
//                 outStatusDropdown.value = 'approved';
//                 otherStatusDropdown.value = 'approved';
//             } else if (isReject) {
//                 inStatusDropdown.value = 'rejected';
//                 outStatusDropdown.value = 'rejected';
//                 otherStatusDropdown.value = 'rejected';
//             }
//             // Set employee ID in a hidden input (to be submitted later)
//             document.getElementById('employeeIdInput').value = employeeId;
//             // Retrieve and display request-related information
//             const requestDate = button.getAttribute('data-request-date');
//             // Split the input date string to get day, month, and year
//             const dateParts = requestDate.split('/');
//             // Create a new Date object from the parts (Note: months are 0-based, so subtract 1 from the month)
//             const dateObj = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
//             // Define an array of month names
//             const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
//             // Format the date
//             const formattedDate = `${dateObj.getDate()} ${monthNames[dateObj.getMonth()]} ${dateObj.getFullYear()}`;
//             // Set the formatted date in the textContent
//             document.getElementById('request-date-repo').textContent = `Requested Date: ${formattedDate}`;
//             // Reset all groups to be hidden initially
//             const groups = [
//                 'statusGroupIn',
//                 'statusGroupOut',
//                 'statusGroupOther',
//                 'reasonInGroupReq',
//                 'reasonOutGroupReq',
//                 'reasonOtherGroupReq',
//                 'remarkInGroupReq',
//                 'remarkOutGroupReq',
//                 'remarkOtherGroupReq',
//                 'reportRemarkInGroup',
//                 'reportRemarkOutGroup',
//                 'reportRemarkOtherGroup'
//             ];
//             groups.forEach(group => {
//                 document.getElementById(group).style.display = 'none';
//             });
//             // Validate reasons
//             const inReason = button.getAttribute('data-in-reason');
//             const outReason = button.getAttribute('data-out-reason');
//             const otherReason = button.getAttribute('data-other-reason');
//             const isInReasonValid = inReason !== 'N/A';
//             const isOutReasonValid = outReason !== 'N/A';
//             const isOtherReasonValid = otherReason !== 'N/A';
//             console.log(inReason);
           
//             //new code


//              // Show sections based on reason validity
//              if (isInReasonValid && isOutReasonValid) {
//                     // Show both "In" and "Out" sections
//                     document.getElementById('statusGroupIn').style.display = 'block';
//                     document.getElementById('reasonInGroupReq').style.display = 'block';
//                     document.getElementById('remarkInGroupReq').style.display = 'block';
//                     document.getElementById('reportRemarkInGroup').style.display = 'block';
                    
//                     if (inReason) {
//                         // Display Remark as text
//                         document.getElementById('reasonInGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Reason:</b></label>
//                             <span id='reasonInDisplay" style="border: none; background: none;">${inReason}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('reasonInDisplay').value = '';
//                     }

//                     // Handle the "In" Remark
//                     let inRemarkValue = button.getAttribute('data-in-remark');
//                     if (inRemarkValue) {
//                         // Display Remark as text
//                         document.getElementById('remarkInGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Remark:</b></label><br>
//                             <span id="remarkInReq" style="border: none; background: none;    word-break: break-word;">${inRemarkValue}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('remarkInReq').value = '';
//                     }

//                     // Show the "Out" sections
//                     document.getElementById('statusGroupOut').style.display = 'block';
//                     document.getElementById('reasonOutGroupReq').style.display = 'block';
//                     document.getElementById('remarkOutGroupReq').style.display = 'block';
//                     document.getElementById('reportRemarkOutGroup').style.display = 'block';

//                     // Set Reason Out
//                     // document.getElementById('reasonOutDisplay').value = `${outReason}`;

//                     if (outReason) {
//                         // Display Remark as text
//                         document.getElementById('reasonOutGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Reason:</b></label>
//                             <span id="reasonOutDisplay" style="border: none; background: none;">${outReason}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('reasonOutDisplay').value = '';
//                     }

//                     // Handle the "Out" Remark
//                     let outRemarkValue = button.getAttribute('data-out-remark');
//                     if (outRemarkValue) {
//                         // Display Remark as text
//                         document.getElementById('remarkOutGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Remark:</b></label><br>
//                             <span id="remarkOutReq" style="border: none; background: none;word-break: break-word;">${outRemarkValue}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('remarkOutReq').value = '';
//                     }
//                 } 
//                 else if (isInReasonValid) {
//                     // Show only "In" section
//                     document.getElementById('statusGroupIn').style.display = 'block';
//                     document.getElementById('reasonInGroupReq').style.display = 'block';
//                     document.getElementById('remarkInGroupReq').style.display = 'block';
//                     document.getElementById('reportRemarkInGroup').style.display = 'block';
                    
//                     // Set Reason In
//                     //document.getElementById('reasonInDisplay').value = `${inReason}`;
//                     // Handle the "In" Remark
                    
//                     if (inReason) {
//                         console.log(inReason);

//                         // Display Remark as text
//                         document.getElementById('reasonInGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Reason:</b></label>
//                             <span id="reasonInDisplay" style="border: none; background: none;">${inReason}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('reasonInDisplay').value = '';
//                     }

//                     // Handle the "In" Remark
//                     let inRemarkValue = button.getAttribute('data-in-remark');
//                     if (inRemarkValue) {
//                         // Display Remark as text
//                         document.getElementById('remarkInGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Remark:</b></label><br>
//                             <span id="remarkInReq" style="border: none; background: none;word-break: break-word;">${inRemarkValue}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('remarkInReq').value = '';
//                     }
//                 } else if (isOutReasonValid) {
//                     // Show only "Out" section
//                     document.getElementById('statusGroupOut').style.display = 'block';
//                     document.getElementById('reasonOutGroupReq').style.display = 'block';
//                     document.getElementById('remarkOutGroupReq').style.display = 'block';
//                     document.getElementById('reportRemarkOutGroup').style.display = 'block';

//                     // Set Reason Out
//                     if (outReason) {
//                         // Display Remark as text
//                         document.getElementById('reasonOutGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Reason:</b></label>
//                             <span id="reasonOutDisplay" style="border: none; background: none;">${outReason}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('reasonOutDisplay').value = '';
//                     }

//                     // Handle the "Out" Remark
//                     let outRemarkValue = button.getAttribute('data-out-remark');
//                     if (outRemarkValue) {
//                         // Display Remark as text
//                         document.getElementById('remarkOutGroupReq').innerHTML = `
//                             <label class="col-form-label"><b>Remark:</b></label><br>
//                             <span id="remarkOutReq" style="border: none; background: none;word-break: break-word;">${outRemarkValue}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('remarkOutReq').value = '';
//                     }
//                 } else if (!isInReasonValid && !isOutReasonValid && isOtherReasonValid) {
//                     // Show "Other" section only
//                     document.getElementById('statusGroupOther').style.display = 'block';
//                     document.getElementById('reasonOtherGroupReq').style.display = 'block';
//                     document.getElementById('remarkOtherGroupReq').style.display = 'block';
//                     document.getElementById('reportRemarkOtherGroup').style.display = 'block';

//                     // Set Other Reason
//                     document.getElementById('reasonOtherDisplay').value = `${otherReason}`;

//                     if (otherReason) {
//                         // Display Remark as text
//                         document.getElementById('reasonOtherGroupReq').innerHTML = `
//                             <label class="col-form-label">Reason:</label>
//                             <span id="reasonOtherDisplay" style="border: none; background: none;">${otherReason}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('reasonOtherDisplay').value = '';
//                     }

//                     // Handle the "Other" Remark
//                     let otherRemarkValue = button.getAttribute('data-other-remark');
//                     if (otherRemarkValue) {
//                         // Display Remark as text
//                         document.getElementById('remarkOtherGroupReq').innerHTML = `
//                             <label class="col-form-label">Remark:</label>
//                             <span  id="remarkOtherReq" style="border: none; background: none;word-break: break-word;">${otherRemarkValue}</span>`;
//                     } else {
//                         // Display input for Remark
//                         document.getElementById('remarkOtherReq').value = '';
//                     }
//                 }

        
//         });
//         document.getElementById('sendButtonReq').addEventListener('click', function () {
//     const requestDateText = document.getElementById('request-date-repo').textContent;
//     const requestDate = requestDateText.replace('Requested Date: ', '').trim();
//     const employeeId = document.getElementById('employeeIdInput').value; // Get employee ID from hidden input
//     const repo_employeeId = {{ Auth::user()->EmployeeID }};
    
//     // Prepare the data to be sent
//     const formData = new FormData();
//     formData.append('requestDate', requestDate);

//     $('#loader').show(); // Show loader before the request is sent

//     // Check visibility before appending values
//     if (document.getElementById('statusGroupIn').style.display !== 'none') {
//         const inStatus = document.getElementById('inStatusDropdown').value;
//        const inReason = document.getElementById('reasonInDisplay').textContent;
//        console.log(inReason);
//         const inRemark = document.getElementById('remarkInReq').value;
//         const reportRemarkIn = document.getElementById('reportRemarkInReq').value;
//         if (inReason && inStatus) { // Append only if reason and status are valid
//             formData.append('inStatus', inStatus);
//             formData.append('inReason', inReason);
//             formData.append('inRemark', inRemark);
//             formData.append('reportRemarkIn', reportRemarkIn);
//         }
//     }

//     if (document.getElementById('statusGroupOut').style.display !== 'none') {
//         const outStatus = document.getElementById('outStatusDropdown').value;
//         const outReason = document.getElementById('reasonOutDisplay').textContent;
//         const outRemark = document.getElementById('remarkOutReq').value;
//         const reportRemarkOut = document.getElementById('reportRemarkOutReq').value;
//         if (outReason && outStatus) { // Append only if reason and status are valid
//             formData.append('outStatus', outStatus);
//             formData.append('outReason', outReason);
//             formData.append('outRemark', outRemark);
//             formData.append('reportRemarkOut', reportRemarkOut);
//         }
//     }

//     if (document.getElementById('statusGroupOther').style.display !== 'none') {
//         const otherStatus = document.getElementById('otherStatusDropdown').value;
//         const otherReason = document.getElementById('reasonOtherDisplay').textContent;
//         const otherRemark = document.getElementById('remarkOtherReq').value;
//         const reportRemarkOther = document.getElementById('reportRemarkOtherReq').value;
//         if (otherReason) { // Append only if reason is valid
//             formData.append('otherStatus', otherStatus);
//             formData.append('otherReason', otherReason);
//             formData.append('otherRemark', otherRemark);
//             formData.append('reportRemarkOther', reportRemarkOther);
//         }
//     }

//     // Append additional data
//     formData.append('employeeid', employeeId);
//     formData.append('repo_employeeId', repo_employeeId);
//     formData.append('inn_time', inn_time);
//     formData.append('out_time', out_time);
//     formData.append('_token', document.querySelector('input[name="_token"]').value); // CSRF token

//     // Send the data using fetch
//     fetch(`/attendance/updatestatus`, {
//         method: 'POST',
//         body: formData,
//     })
//     .then(response => response.json()) // Parse JSON response
//     .then(response => {
//         $('#loader').hide(); // Hide loader after the request is complete

//         if (response.success) {
//             // Show a success toast notification with custom settings
//             toastr.success(response.message, 'Success', {
//                 "positionClass": "toast-top-right", // Position the toast at the top-right corner
//                 "timeOut": 3000                    // Duration for which the toast will be visible (3 seconds)
//             });

//             // Optionally, reset the form and reload the page after a few seconds
//             setTimeout(function () {
//                 location.reload(); // Reload the page
//             }, 3000); // Delay before reset and reload to match the toast timeout
//         } else {
//             // Show an error toast notification with custom settings
//             toastr.error('Error: ' + response.message, 'Error', {
//                 "positionClass": "toast-top-right", // Position the toast at the top-right corner
//                 "timeOut": 3000                    // Duration for which the toast will be visible (3 seconds)
//             });
//         }

//         // Re-enable submit button after request completion
//         $('.btn-success').prop('disabled', false).text('Submit');
//     })
//     .catch(error => {
//         $('#loader').hide(); // Hide loader in case of an error

//         // Show an error toast notification
//         toastr.error('An error occurred. Please try again.', 'Error', {
//             "positionClass": "toast-top-right", // Position the toast at the top-right corner
//             "timeOut": 3000                    // Duration for which the toast will be visible (3 seconds)
//         });

//         // Re-enable submit button after error
//         $('.btn-success').prop('disabled', false).text('Submit');
//     });
// });


        // $(document).ready(function () {
        //     $('#sendButtonleave').on('click', function (event) {
        //         event.preventDefault(); // Prevent the default form submission
        //         $('#loader').show(); 
        //         // Gather form data
        //         var formData = {
        //                     employeename: $('#employeename').text(),  // Use .text() for displaying values instead of .val() for inputs
        //                     leavetype: $('#leavetype').text(),
        //                     from_date: $('#from_date').text(),
        //                     to_date: $('#to_date').text(),
        //                     total_days: $('#total_days').text(),
        //                     leavereason: $('#leavereason').text(),
        //                     leavetype_day: $('#leavetype_day').text(),
        //                     Status: $('#StatusDropdown').val(),
        //                     remarks: $('#remarks_leave').val(),
        //                     employeeId: $('#leaveAuthorizationForm').data('employeeId'), // Get employee ID
        //                     _token: '{{ csrf_token() }}' // Include CSRF token for security
        //                 };
        //         // AJAX request to send data to the controller
        //         $.ajax({
        //             url: '{{ route('leave.authorize') }}', // Update with your route
        //             type: 'POST',
        //             data: formData,
        //             success: function (response) {
        //                 if (response.success == true) {
        //                    $('#loader').hide(); 
        //                     console.log(response)
        //                     // if (response.message == "Leave Rejected successfully." || response.message == "Leave already rejected.") {
        //                         // Show toast with error message
        //                         toastr.success(response.message, 'Success', {
        //                             "positionClass": "toast-top-right",  // Position it at the top right of the screen
        //                             "timeOut": 3000  // Duration for which the toast is visible (in ms)
        //                         });
        //                         setTimeout(() => {
        //                         location.reload(); // Reload the page after a delay
        //                     }, 3000);
        //                     // }
        //                     // else {
        //                     //     // Show toast with success message
        //                     //     toastr.success(response.message, 'Success', {
        //                     //         "positionClass": "toast-top-right",  // Position it at the top right of the screen
        //                     //         "timeOut": 5000  // Duration for which the toast is visible (in ms)
        //                     //     });
        //                     // }
        //                     // Optionally close the modal and reload the page after a delay
        //                     // setTimeout(() => {
        //                     //     $('#LeaveAuthorisation').modal('hide'); // Close modal
        //                     //     location.reload(); // Reload the page
        //                     // }, 3000);
        //                 } else {
        //                     // Show error toast when the response is unsuccessful
        //                     // toastr.error('Leave rejected. Please check the details.', 'Error', {
        //                     //     "positionClass": "toast-top-right",  // Position it at the top right of the screen
        //                     //     "timeOut": 5000  // Duration for which the toast is visible (in ms)
        //                     // });
        //                     toastr.error(response.message, 'Error', {
        //                             "positionClass": "toast-top-right",  // Position it at the top right of the screen
        //                             "timeOut": 3000  // Duration for which the toast is visible (in ms)
        //                         });
        //                    $('#loader').hide(); 

        //                 }
        //             },
        //             error: function (xhr) {
        //                 // Handle any errors from the server
        //                 toastr.error('An error occurred. Please try again.', 'Error', {
        //                     "positionClass": "toast-top-right",  // Position it at the top right of the screen
        //                     "timeOut": 3000  // Duration for which the toast is visible (in ms)
        //                 });
        //                 $('#loader').hide(); 
                     

        //             }
        //         });
        //     });
        // });
        $(document).ready(function () {
            $('#sendButtonleave').on('click', function (event) {
                event.preventDefault(); // Prevent the default form submission
                $('#loader').show(); 
                // Gather form data
                var formData = {
                            employeename: $('#employeename').text(),  // Use .text() for displaying values instead of .val() for inputs
                            leavetype: $('#leavetype').text(),
                            from_date: $('#from_date').text(),
                            to_date: $('#to_date').text(),
                            total_days: $('#total_days').text(),
                            leavereason: $('#leavereason').text(),
                            leavetype_day: $('#leavetype_day').text(),
                            Status: $('#StatusDropdown').val(),
                            remarks: $('#remarks_leave').val(),
                            employeeId: $('#leaveAuthorizationForm').data('employeeId'), // Get employee ID
                            _token: '{{ csrf_token() }}' // Include CSRF token for security
                        };
                // AJAX request to send data to the controller
                $.ajax({
                    url: '{{ route('leave.authorize') }}', // Update with your route
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success == true) {
                           $('#loader').hide(); 
                            console.log(response)
                            // if (response.message == "Leave Rejected successfully." || response.message == "Leave already rejected.") {
                                // Show toast with error message
                                toastr.success(response.message, 'Success', {
                                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                                });
                            // }
                            // else {
                            //     // Show toast with success message
                            //     toastr.success(response.message, 'Success', {
                            //         "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            //         "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            //     });
                            // }
                            // Optionally close the modal and reload the page after a delay
                            setTimeout(() => {
                                $('#LeaveAuthorisation').modal('hide'); // Close modal
                                location.reload(); // Reload the page
                            }, 3000);
                        } else {
                            // Show error toast when the response is unsuccessful
                            // toastr.error('Leave rejected. Please check the details.', 'Error', {
                            //     "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            //     "timeOut": 5000  // Duration for which the toast is visible (in ms)
                            // });
                            toastr.error(response.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                                    "timeOut": 3000  // Duration for which the toast is visible (in ms)
                                });
                           $('#loader').hide(); 

                            
                        }
                    },
                    error: function (xhr) {
                        // Handle any errors from the server
                        toastr.error('An error occurred. Please try again.', 'Error', {
                            "positionClass": "toast-top-right",  // Position it at the top right of the screen
                            "timeOut": 5000  // Duration for which the toast is visible (in ms)
                        });
                        $('#loader').hide(); 

                    }
                });
            });
        });
        
        document.addEventListener('DOMContentLoaded', function () {
    const company_id = {{ Auth::user()->CompanyId }};
    fetch(`/birthdays?company_id=${company_id}`)
        .then(response => response.json())
        .then(data => {
            // Access the correct data structure
            const birthdays = Object.values(data.birthdays).flat();
            const anniversaries = Object.values(data.marriages).flat();
            const joinings = Object.values(data.joinings).flat();

            // Get the containers for the carousels
            const birthdayCarouselInner = document.querySelector('#birthdayContainer .carousel-inner');
            const anniversaryCarouselInner = document.querySelector('#marriageContainer .carousel-inner');
            const modalBirthdayContainer = document.getElementById('modalBirthdayContainer');
            const joiningCarouselInner = document.querySelector('#joiningContainer .carousel-inner');

            // Get the blocks that will be conditionally displayed
            const birthdayBlock = document.getElementById('birthdayContainer');
            const anniversaryBlock = document.getElementById('marriageContainer');
            const joiningBlock = document.getElementById('joiningContainer');

            // Function to create carousel items
            function createCarouselItems(items, carouselInner, type) {
                if (items.length === 0) {
                    return; // Skip if there are no items
                }
                for (let index = 0; index < items.length; index++) {
                    let carouselItem = '';
                    // Check if it's the first item to be active
                    if (index === 0) {
                        carouselItem = `<div class="carousel-item active"><div class="row">`;
                    } else {
                        carouselItem = `<div class="carousel-item"><div class="row">`;
                    }
                   // Add current item
                   const currentItem = items[index];
                    
                    // Check if the current item date is today
                    const isTodayDatefirst = isToday(currentItem.date);  // Call isToday function outside of the string

                    
                    carouselItem += `
                    <div class="col text-center">
                        <img style="margin: 0 auto; display: block; border-radius: 50%;width:100px;height:100px;padding:15px;" 
                            class="d-block" 
                            src="https://vnrseeds.co.in/AdminUser/EmpImg{{Auth::user()->CompanyId}}Emp/${currentItem.EmpCode}.jpg" 
                            onerror="this.src='https://eu.ui-avatars.com/api/?name=${currentItem.Fname}&background=A585A3&color=fff&bold=true&length=1&font-size=0.5';" 
                            alt="User Image">
                        <p><b>${formatDateddmm(currentItem.date)}</b></p>
                        <h6>${currentItem.Fname} ${currentItem.Lname}</h6>
                        <h6 class="degination">${currentItem.department_code} (${currentItem.city_village_name})</h6>

                        <div class="wishes-container">
                            ${type === 'joining' ? 
                                `<div class="vnr-exp-box">
                                    <img alt="" style="width: 70px;" src="./images/star-1.png">
                                    <span>
                                        ${currentItem.years_with_company}
                                    </span>
                                </div>` : 
                                `${isTodayDatefirst ? 
                                    `<a data-bs-toggle="modal" data-bs-target="#wishesModal" class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1" 
                                    data-employee-id="${currentItem.EmployeeID}" data-type="${type}">
                                        <i class="fas fa-birthday-cake mr-1"></i>
                                        <small>Best Wishes</small>
                                    </a>`
                                    : ''}`
                            }
                                        
                        </div>
                    </div>
                `;

                    // Add the next item if it exists
                    if (items[index + 1]) {
                        const nextItem = items[index + 1];
                        const isTodayDatenext = isToday(nextItem.date);  // Call isToday function outside of the string
                        carouselItem += `
                        <div class="col text-center">
                            <img style="display: block; border-radius: 50%;width:100px;height:100px;padding:15px;" 
                                class="d-block" 
                                src="https://vnrseeds.co.in/AdminUser/EmpImg{{Auth::user()->CompanyId}}Emp/${nextItem.EmpCode}.jpg" 
                                onerror="this.src='https://eu.ui-avatars.com/api/?name=${nextItem.Fname}&background=A585A3&color=fff&bold=true&length=1&font-size=0.5';" 
                                alt="User Image">
                            <p><b>${formatDateddmm(nextItem.date)}</b></p>
                            <h6>${nextItem.Fname} ${nextItem.Lname}</h6>
                            <h6 class="degination">${nextItem.department_code} (${nextItem.city_village_name})</h6>
                            
                            
                            <div class="wishes-container">
                                ${type === 'joining' ? 
                                    `<div class="vnr-exp-box">
                                        <img alt="" style="width: 70px;" src="./images/star-1.png">
                                        <span>
                                            ${nextItem.years_with_company}
                                        </span>
                                    </div>` : 
                                    `${isTodayDatenext ?  
                                                        `<a data-bs-toggle="modal" data-bs-target="#wishesModal" class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1" 
                                                        data-employee-id="${nextItem.EmployeeID}" data-type="${type}">
                                                            <i class="fas fa-birthday-cake mr-1"></i>
                                                            <small>Best Wishes</small>
                                                        </a>`
                                                        : ''}`
                                                }
                                        </div>
                                    </div>
                                    `;
                                }

                    carouselItem += `</div></div>`; // Close carousel item
                    carouselInner.innerHTML += carouselItem; // Add to carousel
                }
            }

            // Populate the carousels only if there is data
            if (birthdays.length > 0) {
                createCarouselItems(birthdays, birthdayCarouselInner, 'birthday');
                birthdayBlock.style.display = 'block'; // Show birthday block
            } else {
                birthdayBlock.style.display = 'none'; // Hide birthday block if no data
            }
            if (anniversaries.length > 0) {
                createCarouselItems(anniversaries, anniversaryCarouselInner, 'marriage');
                anniversaryBlock.style.display = 'block'; // Show anniversary block
            } else {
                anniversaryBlock.style.display = 'none'; // Hide anniversary block if no data
            }
            if (joinings.length > 0) {
                createCarouselItems(joinings, joiningCarouselInner, 'joining');
                joiningBlock.style.display = 'block'; // Show joining block
            } else {
                joiningBlock.style.display = 'none'; // Hide joining block if no data
            }

            // Populate the modal for birthdays, anniversaries, and joinings
            function populateModalData(items, container, type) {
                container.innerHTML = ''; // Clear the modal container
                // Set the modal title based on the celebration type
                const modalTitle = document.getElementById('celebrationTitle');
                switch (type) {
                    case 'birthday':
                        modalTitle.textContent = 'Birthday Celebrations';
                        break;
                    case 'marriage':
                        modalTitle.textContent = 'Anniversary Celebrations';
                        break;
                    case 'joining':
                        modalTitle.textContent = 'Corporate Anniversary';
                        break;
                    default:
                        modalTitle.textContent = 'Celebration Highlights';
                }

                // Add each item to the modal
                items.forEach(item => {
                    const isTodayDateall= isToday(item.date);  // Call isToday function outside of the string

                    const modalItem = `
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 mt-3 mb-3 text-center">
                            <div class="border p-2 celebration-photo" style="box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);min-height:245px;position:relative;">
                                <!-- Employee Image -->
                                <img 
                                    src="https://vnrseeds.co.in/AdminUser/EmpImg{{Auth::user()->CompanyId}}Emp/${item.EmpCode}.jpg" 
                                    alt="Employee Image" class="cele-img"
                                    onerror="this.src='https://eu.ui-avatars.com/api/?name=${item.Fname}&background=A585A3&color=fff&bold=true&length=1&font-size=0.5';">

                                <!-- Employee Date -->
                                <p class="cele-date">${formatDateddmm(item.date)}</p>
                                
                                <!-- Employee Name -->
                                <h6 class="cele-name">${item.Fname} ${item.Lname}</h6>
                                
                                <!-- Employee Department  and Employee Location -->
                                <h6 class="degination">${item.department_code} (${item.city_village_name})</h6>
                                
                                <!-- Conditionally Add Star Section for Joining Type -->
                                
                                ${type === 'joining' ? 
                                    `<div class="vnr-exp-box" style="margin-top:0;margin-bottom:-8px;">
                                        <img alt="" style="width: 75px;" src="./images/star-1.png">
                                        <span>
                                            ${item.years_with_company}
                                        </span>
                                    </div>` : 
                                  `${isTodayDateall ? 
                                        `<a style="" data-bs-toggle="modal" data-bs-target="#wishesModal" class="modal-best-wish-btn effect-btn sm-btn btn btn-info mt-3 mb-2 p-1" 
                                    data-employee-id="${item.EmployeeID}" data-type="${type}">
                                        <i class="fas fa-birthday-cake mr-1"></i>
                                        <small>Best Wishes</small>
                                    </a>`
                                    : ''}`
                            }
                            </div>
                        </div>
                    `;
                    container.innerHTML += modalItem;
                });

                            }

            // Event listener for "View All" buttons (assuming these buttons are in your HTML)
            document.querySelector('#birthdayViewAllBtn').addEventListener('click', () => {
                populateModalData(birthdays, modalBirthdayContainer, 'birthday');
            });
            document.querySelector('#anniversaryViewAllBtn').addEventListener('click', () => {
                populateModalData(anniversaries, modalBirthdayContainer, 'marriage');
            });
            document.querySelector('#joiningViewAllBtn').addEventListener('click', () => {
                populateModalData(joinings, modalBirthdayContainer, 'joining');
            });
        

                    let currentEmployeeData = null;
                    // Function to close all modals before opening a new one
                    function closeAllModals(excludedModalId) {
                        const excludedModal = document.getElementById(excludedModalId); // Get the modal by its ID
                            if (excludedModal) {
                                excludedModal.style.display = 'none'; // Make sure the excluded modal is visible
                            }
                    }
                    // Modal Logic: when "Best Wishes" button is clicked
                    const wishesModal = document.getElementById('wishesModal');
                    const modalEmployeeName = document.getElementById('modalEmployeeName');
                    const modalEmployeeDate = document.getElementById('modalEmployeeDate');
                    const modalMessage = document.getElementById('modalMessage');
                    const sendWishBtn = document.getElementById('sendWishBtn');
                    const defaultMessages = {
                            birthday: "Happy Birthday! Wishing you a fantastic year ahead.",
                            marriage: "Congratulations on your wedding anniversary! Wishing you a lifetime of love and happiness.",
                        };
                    // When the modal opens, populate the employee's details
                    wishesModal.addEventListener('show.bs.modal', function (event) {
                        const button = event.relatedTarget; // Button that triggered the modal
                        const employeeId = button.getAttribute('data-employee-id');
                        const type = button.getAttribute('data-type');
                        console.log(employeeId);
                        closeAllModals('model5'); // Pass the ID of the wishes modal to exclude it from being closed

                        let employeeData;
                        // Find the employee data based on the type (birthday, marriage, joining)
                        if (type === 'birthday') {
                            employeeData = birthdays.find(item => item.EmployeeID == employeeId);
                            modalMessage.value = defaultMessages.birthday; // Set the default birthday message

                        } else if (type === 'marriage') {
                            
                            employeeData = anniversaries.find(item => item.EmployeeID == employeeId);
                            modalMessage.value = defaultMessages.marriage; // Set the default marriage message

                        } else if (type === 'joining') {
                            employeeData = joinings.find(item => item.EmployeeID == employeeId);
                        }
                        if (employeeData) {
                            // Store the employee data globally to use later
                            currentEmployeeData = employeeData;
                            modalEmployeeName.textContent = `${employeeData.Fname} ${employeeData.Sname} ${employeeData.Lname}`;
                            modalEmployeeDate.textContent = `${formatDateddmm(employeeData.date)}`;
                        }
                    });
                    // Send wishes on "Send Wishes" button click
                    sendWishBtn.addEventListener('click', function () {
                            $('#loader').show(); 

                        const message = modalMessage.value;
                        // Ensure the employee data is available before proceeding
                        if (!currentEmployeeData) {
                            alert('No employee data found.');
                            return;
                        }
                        const employeeId = currentEmployeeData.EmployeeID;
                        const employeeFromID = {{Auth::user()->EmployeeID}};

                        const type = currentEmployeeData.type;  // This can be either 'birthday', 'marriage', 'joining'
                        // if (message.trim() === '') {
                        //     alert('Please write a message.');
                        //     return;
                        // }
                        // Make a POST request to send the wishes
                        fetch('/send-wishes', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                employee_id: employeeId,
                                employeeFromID: employeeFromID,
                                type: type,
                                message: message,
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                // Handle the response here (e.g., show success message)
                                if (data.success) {  // Use 'data' instead of 'response'

                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                    $('#loader').hide();

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        location.reload();  // Optionally, reload the page
                                    }, 3000); // Delay before reset and reload to match the toast timeout

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                    $('#loader').hide();

                                }
                            })
                            .catch(error => {
                                console.error('Error sending wishes:', error);
                                alert('Error sending wishes.');
                                $('#loader').hide();

                            });
                    });
                })
                .catch(error => console.error('Error fetching birthdays and anniversaries:', error));
        });
        $(document).ready(function () {
            $('#AttendenceAuthorisation').on('hidden.bs.modal', function () {
                $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 5 seconds
                $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form (if applicable)
            });
        });
        function formatDate() {
    const today = new Date();  // Get the current date
    const yesterday = new Date(today);  // Create a new Date object for yesterday
    yesterday.setDate(today.getDate() - 1);  // Subtract one day to get yesterday

    // Check if yesterday is Sunday, then set the date to Saturday
    if (yesterday.getDay() === 0) {  // 0 represents Sunday
        yesterday.setDate(yesterday.getDate() - 1);  // Set to Saturday
    }

    // Get the day name
    const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const dayName = dayNames[yesterday.getDay()];  // Get the day name for yesterday
    
    const options = { year: 'numeric', month: 'long', day: 'numeric' }; // Format for date
    const formattedDate = yesterday.toLocaleDateString('en-GB', options);  // Format the full date (yesterday)

    // Return the formatted date with day name
    return `${dayName}, ${formattedDate}`;  // Example: "Saturday, December 14, 2024"
}

        // Set the content of the element with id 'currentDateFormate'
        document.getElementById('currentDateFormate').innerText = formatDate();
        // Function to format the date into "yyyy-mm-dd"
        function formatDateForAPI() {
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);  // Get yesterday's date

            // If yesterday is Sunday, make it Saturday
            if (yesterday.getDay() === 0) {
                yesterday.setDate(yesterday.getDate() - 1); // Set to Saturday
            }

            const year = yesterday.getFullYear();
            const month = String(yesterday.getMonth() + 1).padStart(2, '0'); // Ensure month is two digits
            const day = String(yesterday.getDate()).padStart(2, '0'); // Ensure day is two digits

            return `${year}-${month}-${day}`; // Return in 'yyyy-mm-dd' format
        }

        // Get the current employee's ID from Laravel (use Blade syntax to inject the ID)
        const employeeId = '{{ Auth::user()->EmployeeID }}';  // Get EmployeeID from Laravel
        const formattedDate = formatDateForAPI();  // Format the date for the API


    // Send AJAX request to fetch the data
    fetch(`/attendance-data/${employeeId}/${formattedDate}`)
        .then(response => response.json())
        .then(data => {
            // Update the UI with the fetched data (Punch In, Punch Out times)
            document.getElementById('punchIn').innerHTML = `<b>${data.punchIn} AM</b>`;
            document.getElementById('punchOut').innerHTML = `<b>${data.punchOut} PM</b>`;
            // document.getElementById('leaveType').innerHTML = `<b>${data.attValue}</b>`;

        })
        .catch(error => {
            console.error('Error fetching attendance data:', error);
        });

        function formatDateddmmyyyy(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');  // Ensures two digits for day
            const month = String(d.getMonth() + 1).padStart(2, '0');  // Ensures two digits for month
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;  // Format as dd-mm-yyyy
        }
         // Helper function to check if the date is today
        
         function isToday(date) {
        // Get today's date in UTC
            const today = new Date();
            const currentMonth = today.getUTCMonth(); // Get current month (0-11)
            const currentDay = today.getUTCDate(); // Get current day (1-31)

            // Get the month and day from the item date (ignore the year)
            const dateToCheck = new Date(date);
            const itemMonth = dateToCheck.getUTCMonth(); // Get item month (0-11)
            const itemDay = dateToCheck.getUTCDate(); // Get item day (1-31)

            // Compare month and day only
            return currentMonth === itemMonth && currentDay === itemDay;
        }


        function formatDateddmm(date) {
                const d = new Date(date);

                const day = String(d.getDate()).padStart(2, '0'); // Ensures two digits for day
                const monthIndex = d.getMonth();  // Month index (0-11)
                const year = d.getFullYear();

                // Array of month names
                const monthNames = [
                    "January", "February", "March", "April", "May", "June", 
                    "July", "August", "September", "October", "November", "December"
                ];

                const monthName = monthNames[monthIndex]; // Get month name

                return `${day} ${monthName}`; // Format as dd-MonthName
            }
     
    document.addEventListener('DOMContentLoaded', function () {
        // Event delegation for the "More..." link
        document.querySelectorAll('.my-request-msg .link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Extract data from the clicked link's attributes
                var leaveType = this.getAttribute('data-leave-type');
                var fromDate = this.getAttribute('data-from-date');
                var toDate = this.getAttribute('data-to-date');
                var totalDays = this.getAttribute('data-total-days');
                var status = this.getAttribute('data-status');
                var reason = this.getAttribute('data-reason');
                var leaveId = this.getAttribute('data-leave-id'); // Assuming leaveRequest.LeaveId is passed here

                // Update the modal content dynamically
                document.getElementById('modal-leave-type-' + leaveId).textContent = leaveType;
                document.getElementById('modal-from-date-' + leaveId).textContent = fromDate;
                document.getElementById('modal-to-date-' + leaveId).textContent = toDate;
                document.getElementById('modal-total-days-' + leaveId).textContent = totalDays;
                document.getElementById('modal-status-' + leaveId).textContent = status;
                document.getElementById('modal-reason-' + leaveId).textContent = reason;

                // Optionally, if you have multiple modals, you can open the specific modal based on LeaveId
                var modalElement = document.getElementById('approvalpopup-' + leaveId);
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            });
        });
    });
    // Listen for the close button click
document.getElementById('closeWishesModalBtn').addEventListener('click', function() {
    // Reload the page when the close button is clicked
    location.reload();
});
document.addEventListener('DOMContentLoaded', function () {
        var subjectSelect = document.getElementById('Department_name_sub');
        subjectSelect.innerHTML = '<option value="" disabled selected>Select Subject</option>'; // Default empty state
    });

    // Event listener for Department selection change
    document.getElementById('Department_name').addEventListener('change', function () {
        var selectedDepartmentId = this.value; // Get selected department ID
        var subjectSelect = document.getElementById('Department_name_sub');
        
        // Clear current subjects (and reset the default option)
        subjectSelect.innerHTML = '<option value="" disabled selected>Select  Subject</option>';
        
        // If a department is selected, populate the subjects
        if (selectedDepartmentId) {
            // Get the departments' subjects from the Blade view
            var department_sub = @json($departments_sub);  // Blade variable passed as JSON
            
            // Filter subjects based on selected department
            department_sub.forEach(function (department_sub_item) {
                if (department_sub_item.DepartmentId == selectedDepartmentId) {
                    var option = document.createElement('option');
                    option.value = department_sub_item.DeptQSubject;
                    option.text = department_sub_item.DeptQSubject;
                    subjectSelect.appendChild(option); // Add the subject option to the dropdown
                }
            });
        }
    });
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function () {
            // Display toast notification
            toastr.success("{{ session('success') }}");
        });
    @endif
    $(document).on('click', '.view-policy-btn', function () {
    var empId = $(this).data('id');

    $.ajax({
        url: '/policy_change_details/' + empId,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                let data = response.data;

                // Open the modal
                $('#viewVehiclepolicy').modal('show');

                // Populate modal fields
                $('#empName').text(data.Name);
                $('#department').text(data.Department);
                $('#grade').text(data.Grade);
                $('#policyName').text(data.PolicyName);
                $('#existingVehicleValue').text(data.ExistingVehicleValue);
                $('#proposedVehicleValue').text(data.ProposedVehicleValue);
                $('#vehcilelife').text(data.Policy);
                $('#vehcilelifenew').text(data.Vehicle_Life_New);
                $('#proposedMonthlyKM').text(data.Proposed_Monthly_KM);
          
                $('#proposedYearlyKM').text(data.Proposed_Yearly_KM);

                $('#existingMonthlyKM').text(data.Existing_Monthly_KM);
                $('#existingYearlyKM').text(data.Existing_Yearly_KM);

                $('#existingRate').text(data.Policy_Rate_Existing);
                $('#proposedRate').text(data.Policy_Rate_New);

                $('#existingReducedRate').text(data.Reduced_Rate_Existing);
                $('#proposedReducedRate').text(data.Reduced_Rate_New);

                $('#monthlyCarAllowance').text(data.Monthly_Car_Allowance);

                $('#alreadyapril').text(data.AlreadyRunAfterApril24);
                $('#runafterapril').text(data.AlreadyRunAfterApril24);

                $('#avg_estimate').text(data.Avg_Estimated_Running); 
                $('#avg_estimated').text(data.Avg_Estimated_Running);

                  
                $('#amt_to_be_claimed').text(data.Amount_to_be_Claimed_in_Existing_Policy);
                $('#amount_in_new_policy').text(data.Amount_to_be_Claimed_in_New_Policy);

                $('#amt_to_be_claimed_ext').text(data.Amount_to_be_Claimed_in_Existing_Policy_Reduced_Rate);
                $('#amt_to_be_claimed_new').text(data.Amount_to_be_Claimed_in_New_Policy_Reduced_Rate);

                $('#yearly_car_allowance').text(data.Yearly_Car_Allowance_in_New_Policy);

                $('#total_amount_claimed').text(data.Total_amount_to_be_Claimed_in_Existing_Policy);
                $('#total_yearly_claimed_new').text(data.Total_Yearly_Amount_to_be_Claimed_in_New_Policy);

                $('#impact').text(data.Amt_Old_VS_New_Yearly);

                $('#ProposedVehicleValue').text(data.ProposedVehicleValue);
                $('#ActualVehicleValue').text(data.ActualVehicleValue);

                $('#Vechicle_Value_Diff_Proposed_Vs_Actual').text(data.Vechicle_Value_Diff_Proposed_Vs_Actual);
                $('#Monthly_Claim_under_new_Fixed').text(data.Monthly_Claim_under_new_Fixed);
                $('#Remaining_Month').text(data.Remaining_Month);

                $('#Calculated_Monthly_Fixed_Component').text(data.Calculated_Monthly_Fixed_Component);
                $('#Total_Reimbursement').text(data.Total_Reimbursement);

                $('#Adjusted_Remaining_Month').text(data.Adjusted_Remaining_Month);
                $('#Adj_Remaining_Life_in_Month').text(data.Adj_Remaining_Life_in_Month);
                $('#AlreadyRunBeforeApril24').text(data.AlreadyRunBeforeApril24);
                $('#AlreadyRunAfterApril24').text(data.TotalRun);
                $('#Claimed_Vehicle_Life').text(data.Claimed_Vehicle_Life);
                $('#PolicyCoverageDate').text(data.PolicyCoverageDate);

                $('#Model_Name').text(data.Model_Name);
                $('#Price').text(data.Price);
                $('#Purchase_Date').text(data.Purchase_Date);
                $('#Fuel_Type').text(data.Fuel_Type);
                $('#Regis_No').text(data.Regis_No);
                $('#Regis_Date').text(data.Regis_Date);

            }
        },
        error: function () {
            alert('Failed to fetch policy details. Please try again.');
        }
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

td:not(.fw-bold) {
        color: #900C3F;
    }


