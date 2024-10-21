@include('employee.header');
@include('employee.sidebar');


<body class="mini-sidebar">
    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        <header class="header-wrapper main-header">
            <div class="header-inner-wrapper">
                <div class="header-right">
                    <div class="serch-wrapper">
                        <form>
                            <input type="text" placeholder="Search Here...">
                        </form>
                        <a class="search-close" href="javascript:void(0);"><span class="icofont-close-line"></span></a>
                    </div>
                    <div class="header-left">
                        <div class="header-links d-none">
                            <a href="javascript:void(0);" class="toggle-btn">
                                <span></span>
                            </a>
                        </div>
                        <div class="header-links search-link">
                            <a class="search-toggle" href="javascript:void(0);">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                                    xml:space="preserve">
                                    <path d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23
                                    s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92
                                    c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17
                                    s-17-7.626-17-17S14.61,6,23.984,6z"></path>
                                </svg>
                            </a>
                        </div>
                        <div class="d-none d-md-block d-lg-block">
                            <h4>VNR Seeds Private Limited India</h4>
                        </div>
                    </div>
                    <div class="header-controls">
                        <div class="setting-wrapper header-links d-none">
                            <a href="javascript:void(0);" class="setting-info">
                                <span class="header-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path
                                            d="M18.777,12.289 L17.557,12.493 C17.439,12.854 17.287,13.220 17.105,13.585 L17.825,14.599 C18.236,15.178 18.170,15.964 17.668,16.467 L16.454,17.683 C15.960,18.177 15.139,18.238 14.588,17.838 L13.583,17.119 C13.234,17.294 12.869,17.446 12.491,17.571 L12.284,18.795 C12.167,19.497 11.566,20.006 10.855,20.006 L9.137,20.006 C8.426,20.006 7.825,19.497 7.708,18.794 L7.504,17.571 C7.138,17.450 6.786,17.305 6.455,17.139 L5.431,17.869 C4.875,18.268 4.060,18.202 3.570,17.712 L2.356,16.496 C1.853,15.995 1.787,15.209 2.200,14.627 L2.915,13.630 C2.735,13.279 2.581,12.913 2.456,12.540 L1.218,12.329 C0.518,12.212 0.009,11.609 0.009,10.898 L0.009,9.180 C0.009,8.468 0.518,7.865 1.219,7.748 L2.422,7.545 C2.545,7.164 2.694,6.797 2.867,6.447 L2.139,5.421 C1.727,4.842 1.793,4.057 2.295,3.553 L3.513,2.337 C3.991,1.846 4.818,1.777 5.380,2.181 L6.376,2.901 C6.725,2.721 7.091,2.566 7.464,2.441 L7.675,1.200 C7.793,0.498 8.394,-0.011 9.104,-0.011 L10.818,-0.011 C11.528,-0.011 12.130,0.498 12.247,1.201 L12.451,2.407 C12.833,2.530 13.214,2.687 13.591,2.877 L14.602,2.155 C15.157,1.757 15.973,1.822 16.463,2.313 L17.676,3.528 C18.180,4.028 18.246,4.814 17.833,5.396 L17.112,6.405 C17.288,6.754 17.440,7.121 17.564,7.500 L18.786,7.707 C19.492,7.825 19.997,8.429 19.986,9.143 L19.986,10.856 C19.986,11.569 19.478,12.172 18.777,12.289 ZM16.815,8.984 C16.507,8.935 16.256,8.705 16.180,8.397 C16.030,7.816 15.800,7.262 15.498,6.755 C15.339,6.480 15.353,6.140 15.536,5.887 L16.472,4.568 L15.421,3.514 L14.111,4.458 C13.855,4.640 13.515,4.654 13.248,4.495 C12.722,4.184 12.157,3.952 11.566,3.803 C11.261,3.727 11.030,3.475 10.977,3.162 L10.711,1.574 L9.227,1.574 L8.953,3.187 C8.902,3.490 8.675,3.739 8.375,3.822 C7.801,3.971 7.251,4.203 6.735,4.513 C6.463,4.675 6.124,4.660 5.866,4.481 L4.555,3.543 L3.503,4.595 L4.451,5.930 C4.632,6.183 4.648,6.521 4.491,6.790 C4.193,7.297 3.967,7.852 3.819,8.439 C3.744,8.743 3.494,8.975 3.181,9.028 L1.596,9.295 L1.596,10.782 L3.205,11.057 C3.508,11.108 3.758,11.336 3.839,11.636 C3.987,12.210 4.219,12.762 4.530,13.280 C4.690,13.552 4.676,13.893 4.496,14.150 L3.561,15.465 L4.612,16.518 L5.943,15.569 C6.170,15.399 6.533,15.375 6.799,15.528 C7.309,15.822 7.851,16.044 8.408,16.189 C8.708,16.265 8.937,16.514 8.990,16.825 L9.257,18.425 L10.740,18.425 L11.010,16.825 C11.057,16.516 11.287,16.265 11.594,16.189 C12.176,16.037 12.729,15.807 13.234,15.505 C13.509,15.344 13.850,15.360 14.101,15.542 L15.418,16.482 L16.469,15.428 L15.530,14.102 C15.348,13.843 15.334,13.512 15.494,13.239 C15.797,12.728 16.027,12.174 16.176,11.591 C16.253,11.289 16.503,11.060 16.811,11.007 L18.408,10.740 L18.413,9.255 L16.815,8.984 ZM10.000,14.453 C7.547,14.453 5.550,12.454 5.550,9.996 C5.550,7.537 7.547,5.537 10.000,5.537 C12.454,5.537 14.449,7.537 14.449,9.996 C14.449,12.454 12.454,14.453 10.000,14.453 ZM10.000,7.127 C8.422,7.127 7.137,8.413 7.137,9.996 C7.137,11.577 8.422,12.864 10.000,12.864 C11.579,12.864 12.863,11.577 12.863,9.996 C12.863,8.413 11.579,7.127 10.000,7.127 Z"
                                            class="cls-1"></path>
                                    </svg>
                                </span>
                            </a>
                        </div>


                        <div class="notification-wrapper header-links">
                            <a href="javascript:void(0);" class="notification-info">
                                <span class="header-icon">
                                    <svg enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="m450.201 407.453c-1.505-.977-12.832-8.912-24.174-32.917-20.829-44.082-25.201-106.18-25.201-150.511 0-.193-.004-.384-.011-.576-.227-58.589-35.31-109.095-85.514-131.756v-34.657c0-31.45-25.544-57.036-56.942-57.036h-4.719c-31.398 0-56.942 25.586-56.942 57.036v34.655c-50.372 22.734-85.525 73.498-85.525 132.334 0 44.331-4.372 106.428-25.201 150.511-11.341 24.004-22.668 31.939-24.174 32.917-6.342 2.935-9.469 9.715-8.01 16.586 1.473 6.939 7.959 11.723 15.042 11.723h109.947c.614 42.141 35.008 76.238 77.223 76.238s76.609-34.097 77.223-76.238h109.947c7.082 0 13.569-4.784 15.042-11.723 1.457-6.871-1.669-13.652-8.011-16.586zm-223.502-350.417c0-14.881 12.086-26.987 26.942-26.987h4.719c14.856 0 26.942 12.106 26.942 26.987v24.917c-9.468-1.957-19.269-2.987-29.306-2.987-10.034 0-19.832 1.029-29.296 2.984v-24.914zm29.301 424.915c-25.673 0-46.614-20.617-47.223-46.188h94.445c-.608 25.57-21.549 46.188-47.222 46.188zm60.4-76.239c-.003 0-213.385 0-213.385 0 2.595-4.044 5.236-8.623 7.861-13.798 20.104-39.643 30.298-96.129 30.298-167.889 0-63.417 51.509-115.01 114.821-115.01s114.821 51.593 114.821 115.06c0 .185.003.369.01.553.057 71.472 10.25 127.755 30.298 167.286 2.625 5.176 5.267 9.754 7.861 13.798z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="count-notification"></span>
                            </a>
                            <div class="recent-notification">
                                <div class="drop-down-header">
                                    <h4>All Notification</h4>
                                    <p>You have 6 new notifications</p>
                                </div>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h5><i class="fas fa-exclamation-circle mr-2"></i>Storage Full</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h5><i class="far fa-envelope mr-2"></i>New Membership</h5>
                                            <p>Lorem ipsum dolor sit amet, consectetuer.</p>
                                        </a>
                                    </li>
                                </ul>
                                <div class="drop-down-footer">
                                    <a href="javascript:void(0);" class="btn sm-btn">
                                        View All
                                    </a>
                                </div>
                            </div>
                        </div>
                        @include('employee.navbar');
                    </div>
                </div>
            </div>
        </header>
        <!-- Sidebar Start -->

        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Attendance/Leave</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->

                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                        <!-- Start Card-->

                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Sick Leave(SL)</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="pie-wrapper" style="margin: 0 auto;">
                                        <div style="border-color: #659093;" class="arc" data-value=""></div>
                                        <span class="score"> Day</span>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                    <span class="float-start me-2"><span
                                            class="teken-leave">&nbsp;</span>{{$leaveBalance->OpeningSL + $leaveBalance->CreditedSL}}
                                        Day</span>
                                    <span class="float-start me-2"><span
                                            class="upcoming-leave">&nbsp;</span>{{$leaveBalance->AvailedSL}}
                                        Day</span>
                                    <span class="float-start"><span
                                            class="availabel-leave">&nbsp;</span>{{$leaveBalance->BalanceSL}} Day</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    @if($leaveBalance)
                        <!-- Casual Leave -->
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body dd-flex align-items-center border-bottom-d">
                                    <h5 class="mb-2 w-100"><b>Casual Leave (CL)</b></h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="pie-wrapper" style="margin: 0 auto;">
                                            <div style="border-color: #659093;" class="arc" data-value="">
                                                <span></span>
                                            </div>
                                            <div style="border-color: #f1d6d6; z-index: 1;" class="arc"
                                                data-value="{{ $leaveBalance->AvailedCL * 100 / ($leaveBalance->OpeningCL + $leaveBalance->CreditedCL) }}">
                                            </div>
                                            <span class="score">{{ $leaveBalance->AvailedCL }} Day</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                        <span class="float-start me-2"><span
                                                class="teken-leave">&nbsp;</span>{{ $leaveBalance->OpeningCL + $leaveBalance->CreditedCL }}
                                            Day</span>
                                        <span class="float-start me-2"><span
                                                class="upcoming-leave">&nbsp;</span>{{ $leaveBalance->AvailedCL }}
                                            Day</span>
                                        <span class="float-start"><span
                                                class="availabel-leave">&nbsp;</span>{{ $leaveBalance->BalanceCL }}
                                            Day</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Privilege Leave -->
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body dd-flex align-items-center border-bottom-d">
                                    <h5 class="mb-2 w-100"><b>Privilege Leave (PL)</b></h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="pie-wrapper" style="margin: 0 auto;">
                                            <div style="border-color: #659093;" class="arc" data-value=""></div>
                                            <div style="border-color: #f1d6d6; z-index: 1;" class="arc" data-value=""></div>
                                            <span class="score">{{ $leaveBalance->AvailedPL }} Day</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                        <span class="float-start me-2"><span
                                                class="teken-leave">&nbsp;</span>{{ $leaveBalance->OpeningPL + $leaveBalance->CreditedPL }}
                                            Day</span>
                                        <span class="float-start me-2"><span
                                                class="upcoming-leave">&nbsp;</span>{{ $leaveBalance->AvailedPL }}
                                            Day</span>
                                        <span class="float-start"><span
                                                class="availabel-leave">&nbsp;</span>{{ $leaveBalance->BalancePL }}
                                            Day</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earned Leave -->
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body dd-flex align-items-center border-bottom-d">
                                    <h5 class="mb-2 w-100"><b>Earned Leave (EL)</b></h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="pie-wrapper" style="margin: 0 auto;">
                                            <div style="border-color: #659093;" class="arc" data-value=""></div>
                                            <span class="score">{{ $leaveBalance->AvailedEL }} Day</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                        <span class="float-start me-1"><span
                                                class="teken-leave">&nbsp;</span>{{ $leaveBalance->OpeningEL + $leaveBalance->CreditedEL }}
                                            Day</span>
                                        <span class="float-start me-1"><span
                                                class="upcoming-leave">&nbsp;</span>{{ $leaveBalance->AvailedEL }}
                                            Day</span>
                                        <span class="float-start"><span
                                                class="availabel-leave">&nbsp;</span>{{ $leaveBalance->BalanceEL }}
                                            Day</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Festival Leave -->
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                            <div class="card ad-info-card-">
                                <div class="card-body dd-flex align-items-center border-bottom-d">
                                    <h5 class="mb-2 w-100"><b>Festival Leave (FL)</b></h5>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="pie-wrapper" style="margin: 0 auto;">
                                            <div style="border-color: #659093;" class="arc" data-value=""></div>
                                            <span class="score">{{ $leaveBalance->AvailedOL }} Day</span>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mt-2">
                                        <span class="float-start me-2"><span
                                                class="teken-leave">&nbsp;</span>{{ $leaveBalance->OpeningOL + $leaveBalance->CreditedOL }}
                                            Day</span>
                                        <span class="float-start me-2"><span
                                                class="upcoming-leave">&nbsp;</span>{{ $leaveBalance->AvailedOL }}
                                            Day</span>
                                        <span class="float-start"><span
                                                class="availabel-leave">&nbsp;</span>{{ $leaveBalance->BalanceOL }}
                                            Day</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Monthly Attendance</b></h5>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div style="border-color: #659093;margin:6px;" class="arc" data-value=""></div>
                                    <span class="me-4">Leave: <b>{{ $TotalLeaveCount ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Holiday: <b>{{ $TotalHoliday ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Outdoor Duties: <b>{{ $TotalOnDuties ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Present: <b>{{ $TotalPR ?? 0 }} Days</b>,</span><br>
                                    <span class="me-4">Absent/ LWP: <b>{{ $TotalAbsent ?? 0 }} Days</b></span>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 col-12">
                        <div class="card ad-info-card-" style="height:143px;">
                            <div class="card-body dd-flex align-items-center border-bottom-d">
                                <h5 class="mb-2 w-100"><b>Monthly Attendance</b></h5>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                    <p style="font-size:10px;">
                                            <span class="me-4">Leave: <b>{{ $TotalLeaveCount ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Holiday: <b>{{ $TotalHoliday ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Outdoor Duties: <b>{{ $TotalOnDuties ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Present: <b>{{ $TotalPR ?? 0 }} Days</b>,</span><br>
                                            <span class="me-4">Absent/ LWP: <b>{{ $TotalAbsent ?? 0 }} Days</b></span><br>
                                    </p>

                                </div>

                            </div>
                        </div>
                    </div> -->



                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card ad-info-card-">
                            <div class="card-body">
                                <span class="leave-availabel float-start me-4"><span
                                        class="teken-leave">&nbsp;</span>Used Leave</span>
                                <span class="leave-availabel float-start me-4"><span
                                        class="upcoming-leave">&nbsp;</span>Plan Leave</span>
                                <span class="leave-availabel float-start"><span
                                        class="availabel-leave">&nbsp;</span>Balance Leave</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">

                        <div class="mfh-machine-profile">
                            <ul class="nav nav-tabs" id="myTab1" role="tablist"
                                style="background-color:#a5cccd;border-radius: 10px 10px 0px 0px;">
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link active" data-bs-toggle="tab"
                                        href="#LeaveStatistics" role="tab" aria-controls="LeaveStatistics"
                                        aria-selected="true">Attendance</a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link" data-bs-toggle="tab" href="#ApplyLeave"
                                        role="tab" aria-controls="ApplyLeave" aria-selected="false">Apply Leave</a>
                                </li>
                            </ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                                <div class="tab-pane fade active show" id="LeaveStatistics" role="tabpanel">
                                    <div class="card chart-card">
                                        <div class="card-header">
                                            <h4 class="has-btn float-start mt-2"></H4>
                                            <span class="float-end">
                                                <select class="select2 form-control select-opt" id="monthname"
                                                    fdprocessedid="7n33b9">
                                                    <option value="select">Select Month </option>
                                                    <!-- <option value="January">January</option>
															  <option value="February">February</option>
															  <option value="March">March</option>
															  <option value="April">April</option>
															  <option value="May">May</option>
															  <option value="June">June</option>
															  <option value="July">July</option>
															  <option value="August">August</option>
															  <option value="September">September</option> -->
                                                </select>
                                            </span>
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
                                            <!-------------------------end----------------------->
                                        </div>
                                    </div>
                                    <!--<div class="card chart-card">
												<img class="w-100-" src="./images/Group 61.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 62.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 66.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 72.png">
											</div>
											<h5>Multi date leave</h5>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 67.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 68.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 69.png">
											</div>
											<div class="card chart-card">
												<img class="w-100-" src="./images/Group 73.png">
											</div> -->
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                        <div class="card ad-info-card-">
                                            <div class="card-body">
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-present">&nbsp;</span>Present(P)</span>
                                                <span class="leave-availabel float-start me-4"><span
                                                        class="repre-absent">&nbsp;</span>Absent(A)</span>
                                                <span class="leave-availabel float-start me-4">
                                                <span
                                                        class="repre-ch">&nbsp;</span>Half day CL(CH)</span>
                                                <span class="leave-availabel float-start me-4">
                                                <span
                                                        class="repre-sh">&nbsp;</span>Half day SL(SH)</span>
                                                <span class="leave-availabel float-start me-4">
                                                <span
                                                        class="repre-ph">&nbsp;</span>Half day PL(PH)</span>
                                                <span
                                                    class="leave-availabel float-start me-4"><span
                                                        class="repre-ho">&nbsp;</span>Holiday(HO)</span>
                                                <span
                                                    class="leave-availabel float-start me-4"><span
                                                        class="repre-od">&nbsp;</span>Outdoor Duties(OD)</span>
                                                <span
                                                     class="leave-availabel float-start me-4"><span
                                                        class="repre-fl">&nbsp;</span>Festival Leaves(FL)</span>
                                                <span
                                                    class="leave-availabel float-start me-4"><span
                                                        class="repre-tl">&nbsp;</span>Transfer Leave(TL)</span>
                                                <span
                                                    class="leave-availabel float-start me-4"><span
                                                        class="repre-wfh">&nbsp;</span>Work from home(WFH)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="ApplyLeave" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <form id="leaveForm" action="{{ route('leaveform') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="employee_id"
                                                    value="{{ Auth::user()->EmployeeID }}">

                                                <div class="row">
                                                    <!-- From Date -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="fromDate" class="col-form-label">From
                                                                Date</label>
                                                            <input class="form-control" type="date" id="fromDate"
                                                                name="fromDate" required>
                                                        </div>
                                                    </div>
                                                    <!-- To Date -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="toDate" class="col-form-label">To Date</label>
                                                            <input class="form-control" type="date" id="toDate"
                                                                name="toDate" required>
                                                        </div>
                                                    </div>
                                                    <!-- Leave Type -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="leaveType" class="col-form-label">Leave
                                                                Type</label>
                                                            <select class="select2 form-control select-opt"
                                                                id="leaveType" name="leaveType" required>
                                                                <option value="CL">CL</option>
                                                                <option value="SL">SL</option>
                                                                <option value="PL">PL</option>
                                                                <option value="EL">EL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Option -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="option" class="col-form-label">Option</label>
                                                            <select class="select2 form-control select-opt" id="option"
                                                                name="option" required>
                                                                <option value="fullday">Full Day</option>
                                                                <option value="1sthalf">1st Half</option>
                                                                <option value="2ndhalf">2nd Half</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!-- Contact No -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="contactNo" class="col-form-label">Contact
                                                                No.</label>
                                                            <input class="form-control" type="text" id="contactNo"
                                                                name="contactNo" placeholder="Enter contact number"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <!-- Address -->
                                                    <div class="col-xl-4">
                                                        <div class="form-group s-opt">
                                                            <label for="address" class="col-form-label">Address</label>
                                                            <input class="form-control" type="text" id="address"
                                                                name="address" placeholder="Enter address" required>
                                                        </div>
                                                    </div>
                                                    <!-- Reason for Leave -->
                                                    <div class="form-group">
                                                        <label for="reason" class="col-form-label">Reason for
                                                            Leave</label>
                                                        <textarea class="form-control" id="reason" name="reason"
                                                            placeholder="Enter reason" required></textarea>
                                                    </div>
                                                    <!-- Submit Button -->
                                                    <div class="form-group mb-0">
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">

                                                    <div class="card-header mb-4 mt-4">
                                                        <h4 class="has-btn">Leave List</h4>
                                                    </div>
                                                    <table class="table table-styled mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Apply Date</th>
                                                                <th>From Date</th>
                                                                <th>To Date</th>
                                                                <th>Total</th>
                                                                <th>Leave Type</th>
                                                                <th>Reason</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach(Auth::user()->employeeleave as $index => $leave)

                                                                <tr>
                                                                    <td>{{ $index + 1 }}.</td>
                                                                    <td style="width:80px;">{{ $leave->Apply_Date }}</td>
                                                                    <td style="width:80px;">{{ $leave->Apply_FromDate }}
                                                                    </td>
                                                                    <td style="width:80px;">{{ $leave->Apply_ToDate }}</td>
                                                                    <td style="width:70px;">{{ $leave->Apply_TotalDay }}
                                                                        {{ $leave->Apply_TotalDay == 1 ? 'Day' : 'Days' }}
                                                                    </td>
                                                                    <td style="width:80px;">
                                                                        <label class="mb-0 badge badge-secondary" title=""
                                                                            data-original-title="{{ $leave->Leave_Type }}">{{ $leave->Leave_Type }}</label>
                                                                    </td>
                                                                    <td>
                                                                        <p>{{ $leave->Apply_Reason }}</p>
                                                                    </td>
                                                                    <td style="text-align:right;">
                                                                        @if ($leave->LeaveStatus == 0)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline danger-outline"
                                                                                title=""
                                                                                data-original-title="Draft">Draft</label>
                                                                        @elseif ($leave->LeaveStatus == 1)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline warning-outline"
                                                                                title=""
                                                                                data-original-title="Pending">Pending</label>
                                                                        @elseif ($leave->LeaveStatus == 2)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline success-outline"
                                                                                title=""
                                                                                data-original-title="Approved">Approved</label>
                                                                        @elseif ($leave->LeaveStatus == 3)
                                                                            <label style="padding:6px 13px;font-size: 11px;"
                                                                                class="mb-0 sm-btn btn-outline danger-outline"
                                                                                title=""
                                                                                data-original-title="Disapproved">Disapproved</label>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <div class="text-right pt-2">
                                                        <nav class="d-inline-block">
                                                            <ul class="pagination mb-0 ">
                                                                <li class="page-item disabled">
                                                                    <a class="page-link" href="javascript:void(0);"
                                                                        tabindex="-1"><i
                                                                            class="fas fa-chevron-left"></i></a>
                                                                </li>
                                                                <li class="page-item active "><a class="page-link "
                                                                        href="javascript:void(0); ">1</a></li>
                                                                <li class="page-item ">
                                                                    <a class="page-link "
                                                                        href="javascript:void(0); ">2</a>
                                                                </li>
                                                                <li class="page-item "><a class="page-link "
                                                                        href="javascript:void(0); ">3</a></li>
                                                                <li class="page-item ">
                                                                    <a class="page-link " href="javascript:void(0); "><i
                                                                            class="fas fa-chevron-right "></i></a>
                                                                </li>
                                                            </ul>
                                                        </nav>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn"></h4>
                            </div>
                            <div class="card-body">
                                <div class="late-atnd">

                                </div>

                            </div>
                        </div>



                        <div class="card chart-card">
                            <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link active" data-bs-toggle="tab"
                                        href="#MonthHoliday" role="tab" aria-controls="MonthHoliday"
                                        aria-selected="true">Holiday</a>
                                </li>
                                <li class="nav-item">
                                    <a style="color: #0e0e0e;" class="nav-link" data-bs-toggle="tab"
                                        href="#FestivalLeave" role="tab" aria-controls="FestivalLeave"
                                        aria-selected="false">Festival Leave(Optional)</a>
                                </li>
                            </ul>
                            <div class="tab-content ad-content2" id="myTabContent2">
                                <div class="tab-pane fade active show" id="MonthHoliday" role="tabpanel">
                                    <div class="card-body" style="height:450px;overflow-y:auto;">
                                        @if($holidays->isEmpty())
                                            <p>No holidays available for this year.</p>
                                        @else
                                            @foreach($holidays as $holiday)
                                                <!-- <h6 class="mb-2">
                                                    {{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d M') }}</h6>
                                                <div class="holiday-entry">
                                                    <label class="mb-0">{{ $holiday->HolidayName }}</label><br>
                                                    <span class="float-start">{{ $holiday->Day }}</span>
                                                    <span class="float-end">
                                                        <label
                                                            class="mb-0 badge badge-success toltiped">{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d M') }}</label>
                                                    </span> 
                                                </div> -->

                                                <div class="holiday-entry d-flex align-items-center">
                                                    <h6 class="mb-0 me-2">
                                                        <strong class="text-bold">{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d M') }}</strong>
                                                    </h6>
                                                    <label class="mb-0 me-2"><strong class="text-bold">{{ $holiday->HolidayName }}</strong></label>
                                                    <span class="float-start"><strong class="text-bold">{{ $holiday->Day }}</strong></span>
                                                </div>
                                                @if(!empty($holiday->fes_image_path))
                                                    <img class="mb-2"
                                                        src="{{ asset('images/holiday_fes_image/' . $holiday->fes_image_path) }}"
                                                        alt="{{ $holiday->HolidayName }}" /><br>
                                                @endif
                                            @endforeach
                                        @endif
                                        <a class="btn-outline secondary-outline mr-2 sm-btn mt-2" href=""
                                            data-bs-toggle="modal" data-bs-target="#model3">All Holiday List</a>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="FestivalLeave" role="tabpanel">
                                    <div class="card-body" style="height:450px;overflow-y:auto;">
                                        @if($optionalHolidays->isEmpty())
                                            <p>No optional holidays available for this year.</p>
                                        @else
                                            @foreach($optionalHolidays as $optionalHoliday)
                                                <div class="fest-leave">
                                                    <label class="mb-0">{{ $optionalHoliday->HoOpName }}</label><br>
                                                    <span
                                                        class="float-start">{{ \Carbon\Carbon::parse($optionalHoliday->HoOpDate)->format('l') }}</span>
                                                    <span class="float-end">
                                                        <label
                                                            class="mb-0 badge badge-success toltiped">{{ \Carbon\Carbon::parse($optionalHoliday->HoOpDate)->format('d M') }}</label>
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card chart-card d-none">
                            <div class="card-header">
                                <h4 class="has-btn">Leave Suggestion</h4>
                            </div>
                            <div class="card-body">
                                <h6 class="mb-2">August - 2 Days </h6>
                                <table class="table table-styled mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">15 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0 ">Independence Day Holiday</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">16 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">PL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">17 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">PL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">18 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Sunday</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">19 August</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Raksha Bandhan Holiday</label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>Do you want apply this leave</p>
                                <a class="btn-outline secondary-outline mr-2 sm-btn mt-2 float-end" href="">Yes</a>
                                <br>
                                <hr>
                                <br>
                                <h6 class="mb-2">Ocotober - 3 Days </h6>
                                <table class="table table-styled mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">2 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Gandhi jayanti Holiday</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">3 October</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">EL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">4 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">EL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-info toltiped">5 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">EL</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label class="mb-0 badge badge-success toltiped">6 Ocotober</label>
                                            </td>
                                            <td>
                                                <label class="mb-0">Sunday</label>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                                <p>Do you want apply this leave</p>
                                <a class="btn-outline secondary-outline mr-2 sm-btn mt-2 float-end" href="">Yes</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-none">
                        <h5 class="mt-2 mb-4">Leave Request Status</h5>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                <div class="card chart-card">
                                    <div class="card-body">
                                        <h5 class="text-center p-3 mb-3" style="background-color: #f1f1f1;">Pending</h5>
                                        <span><b>Sick Leave</b></span>
                                        <span class="float-end apply-date">Apply Date: 12-01-2023</span><br>
                                        <div class="mt-5 mb-4 text-center">
                                            <div class="float-start"><b>Jan</b>&nbsp;&nbsp;<b
                                                    class="singal-date">14</b>&nbsp;&nbsp;<b>Mon</b></div>
                                            <span style="color: #ff3c41;"><b>1 Days</b></span>
                                            <div class="float-end"><b>Jan</b>&nbsp;&nbsp;<b
                                                    class="singal-date">14</b>&nbsp;&nbsp;<b>Mon</b></div>
                                        </div>
                                        <div class="progress mt-5 mb-2">
                                            <div class="progress-bar bg-secondary col-5" role="progressbar"
                                                aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="text-center">8 Sick Leave Available</p>
                                        <div class="">
                                            <h6 class="mt-3 mb-2">Reason</h6>
                                            <p class="border p-3">I have to attend to a medical emergency of a close
                                                relative. I will have to be away from 2 days. i will resume work from.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                <div class="card chart-card">
                                    <div class="card-body">
                                        <h5 class="text-center p-3 mb-3" style="background-color: #c4e9cd;">Approval
                                        </h5>
                                        <span><b>Privilege Leave</b></span>
                                        <span class="float-end apply-date">Apply Date: 12-01-2023</span><br>

                                        <div class="mt-5 mb-4 text-center">
                                            <div class="float-start"><b>Jan</b>&nbsp;&nbsp;<b
                                                    class="singal-date">24</b>&nbsp;&nbsp;<b>Mon</b></div>
                                            <span style="color: #ff3c41;"><b>2 Days</b></span>
                                            <div class="float-end"><b>Jan</b>&nbsp;&nbsp;<b
                                                    class="singal-date">25</b>&nbsp;&nbsp;<b>Thus</b></div>
                                        </div>

                                        <div class="progress mt-5 mb-2">
                                            <div class="progress-bar bg-secondary col-5" role="progressbar"
                                                aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="text-center">4 Privilege Leave Available</p>
                                        <div class="">
                                            <h6 class="mt-3 mb-2">Reason</h6>
                                            <p class="border p-3">I have to attend to a medical emergency of a close
                                                relative. I will have to be away from 2 days. i will resume work from.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                <div class="card chart-card">
                                    <div class="card-body">
                                        <h5 class="text-center p-3 mb-3" style="background-color: #c5e1e9;">Request</h5>
                                        <span><b>Casual Leave</b></span>
                                        <span class="float-end apply-date">Apply Date: 12-01-2023</span><br>

                                        <div class="mt-5 mb-4 text-center">
                                            <div class="float-start"><b>Jan</b>&nbsp;&nbsp;<b
                                                    class="singal-date">08</b>&nbsp;&nbsp;<b>Mon</b></div>
                                            <span style="color: #ff3c41;"><b>3 Days</b></span>
                                            <div class="float-end"><b>Jan</b>&nbsp;&nbsp;<b
                                                    class="singal-date">10</b>&nbsp;&nbsp;<b>Wed</b></div>
                                        </div>

                                        <div class="progress mt-5 mb-2">
                                            <div class="progress-bar bg-secondary col-5" role="progressbar"
                                                aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="text-center">8 Casual Leave Available</p>
                                        <div class="">
                                            <h6 class="mt-3 mb-2">Reason</h6>
                                            <p class="border p-3">I have to attend to a medical emergency of a close
                                                relative. I will have to be away from 2 days. i will resume work from.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ad-footer-btm">
                    <p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd
                        India All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </div>
    <!--Holiday list modal-->
    <div class="modal fade show" id="model3" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">{{ $currentYear }} - Holiday List</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-styled mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Holiday Name</th>
                                <th>Date</th>
                                <th>Day</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($all_holidays->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No holidays available for this year.</td>
                                </tr>
                            @else
                                @foreach($all_holidays as $index => $holiday)
                                    <tr>
                                        <td>{{ $index + 1 }}.</td>
                                        <td>
                                            @if(!empty($holiday->fes_image_path))
                                                <img style="width:110px;"
                                                    src="{{ asset('images/holiday_fes_image/' . $holiday->fes_image_path) }}"
                                                    alt="{{ $holiday->HolidayName }}" />
                                            @endif
                                            <span class="img-thumb">
                                                <span class="ml-2">{{ $holiday->HolidayName }}</span>
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($holiday->HolidayDate)->format('l') }}</td>
                                    </tr>
                                @endforeach
                            @endif
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


    <!--Attendence Authorisation-->
    <div class="modal fade" id="AttendenceAuthorisation" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="responseMessage" class="text-success" style="display: none;"></p>

                    <p>This option is only for missed attendance or late In-time/early out-time attendance and not for
                        leave applications. <span class="text-danger">Do not apply leave here.</span></p>
                    <br>
                    <p><b>Request Date: </b><span id="request-date"></span></p>
                    <form id="attendanceForm" method="POST" action="{{ route('attendance.authorize') }}">
                    @csrf
                    <div id="request-date"></div>
                    <input type="hidden" id="employeeid" name="employeeid">
                    <input type="hidden" id="Atct" name="Atct">
                    <input type="hidden" id="requestDate" name="requestDate">

                    <div class="form-group" id="reasonInGroup" style="display: none;">
                        <label class="col-form-label">Reason In:</label>
                        <select name="reasonIn" class="form-control" id="reasonInDropdown">
                        <option value="">Select Reason</option>

                        </select>
                    </div>

                    <div class="form-group" id="remarkInGroup" style="display: none;">
                        <label class="col-form-label">Remark In:</label>
                        <input type="text" name="remarkIn" class="form-control" id="remarkIn">
                    </div>

                    <div class="form-group" id="reasonOutGroup" style="display: none;">
                        <label class="col-form-label">Reason Out:</label>
                        <select name="reasonOut" class="form-control" id="reasonOutDropdown">
                        <option value="">Select Reason</option>

                        </select>
                    </div>

                    <div class="form-group" id="remarkOutGroup" style="display: none;">
                        <label class="col-form-label">Remark Out:</label>
                        <input type="text" name="remarkOut" class="form-control" id="remarkOut">
                    </div>
                    <div class="form-group" id="otherReasonGroup" style="display: none;">
                        <label class="col-form-label">Other Reason:</label>
                        <select name="otherReason" class="form-control" id="otherReasonDropdown">
                            <option value="">Select Reason</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>


                    <div class="form-group" id="otherRemarkGroup" style="display: none;">
                        <label class="col-form-label">Other Remark:</label>
                        <input type="text" name="otherRemark" class="form-control" id="otherRemark">
                    </div>

                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendButton">Send</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Preview Setting Box -->
    <div class="slide-setting-box">
        <div class="slide-setting-holder">
            <div class="setting-box-head">
                <h4>Dashboard Demo</h4>
                <a href="javascript:void(0);" class="close-btn">Close</a>
            </div>
            <div class="setting-box-body">
                <div class="sd-light-vs">
                    <a href="">
                        Light Version
                        <img src="./SplashDash_files/light.png" alt="">
                    </a>
                </div>
                <div class="sd-light-vs">
                    <a href="">
                        dark Version
                        <img src="./SplashDash_files/dark.png" alt="">
                    </a>
                </div>
            </div>
            <div class="sd-color-op">
                <h5>color option</h5>
                <div id="style-switcher">
                    <div>
                        <ul class="colors">
                            <li>
                                <p class="colorchange" id="color">
                                </p>
                            </li>
                            <li>
                                <p class="colorchange" id="color2">
                                </p>
                            </li>
                            <li>
                                <p class="colorchange" id="color3">
                                </p>
                            </li>
                            <li>
                                <p class="colorchange" id="color4">
                                </p>
                            </li>
                            <li>
                                <p class="colorchange" id="color5">
                                </p>
                            </li>
                            <li>
                                <p class="colorchange" id="style">
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Preview Setting -->

    @include('employee.footer');
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const currentDate = new Date();
            const currentMonthIndex = currentDate.getMonth(); // 0 = January, 1 = February, etc.
            const currentYear = currentDate.getFullYear();

            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const monthDropdown = document.getElementById('monthname');
            const cardHeaders = document.querySelectorAll('.card-header h4');

            // Clear existing options
            monthDropdown.innerHTML = '';

            // Add "Select Month" /
            monthDropdown.innerHTML += `<option value="select">Select Month</option>`;

            // Populate with previous and current month
            const previousMonthIndex = (currentMonthIndex - 1 + 12) % 12;
            const previousMonth = monthNames[previousMonthIndex];
            const currentMonth = monthNames[currentMonthIndex];

            // Add options for the current and previous months
            monthDropdown.innerHTML += `<option value="${previousMonth}">${previousMonth}</option>`;
            monthDropdown.innerHTML += `<option value="${currentMonth}" selected>${currentMonth}</option>`;

            // Fetch attendance data for the current month on page load
            fetchAttendanceData(currentMonth, currentYear);

            monthDropdown.addEventListener('change', function () {
                const selectedMonth = this.value;
                if (selectedMonth !== "select") {
                    fetchAttendanceData(selectedMonth, currentYear);
                }
            });
            document.addEventListener('click', function (event) {
                if (event.target.closest('.open-modal')) {
                    event.preventDefault();

                    const link = event.target.closest('.open-modal');
                    const employeeId = link.getAttribute('data-employee-id');
                    const date = link.getAttribute('data-date');
                    const innTime = link.getAttribute('data-inn');
                    const outTime = link.getAttribute('data-out');
                    const II = link.getAttribute('data-II');
                    const OO = link.getAttribute('data-OO');
                    const atct = link.getAttribute('data-atct');
                    // Determine classes based on conditions
                    const lateClass = (innTime > II) ? 'text-danger' : '';
                    const earlyClass = (outTime < OO) ? 'text-danger' : '';

                    // Initialize content for request-date
                    let requestDateContent = `<b>Request Date: ${date}</b><br>`;

                    // Check conditions for In
                    if (innTime > II) {
                        requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
                    } else if (innTime <= II) {
                        requestDateContent += `In: <span>${innTime}On Time</span><br>`; // Optional: show "On Time" if needed
                    }

                    // Check conditions for Out
                    if (outTime < OO) {
                        requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
                    } else if (outTime >= OO) {
                        requestDateContent += `Out: <span>${outTime}On Time</span>`; // Optional: show "On Time" if needed
                    }

                    // Set innerHTML only if there is content to display
                    document.getElementById('request-date').innerHTML = requestDateContent;

                    document.getElementById('employeeid').value = employeeId;
                    document.getElementById('Atct').value = atct;
                    document.getElementById('requestDate').value = date;

                    // Clear previous values and hide all groups
                    document.getElementById('remarkIn').value = '';
                    document.getElementById('remarkOut').value = '';
                    // document.getElementById('reasonInDropdown').innerHTML = '';
                    // document.getElementById('reasonOutDropdown').innerHTML = '';

                    document.getElementById('reasonInGroup').style.display = 'none';
                    document.getElementById('remarkInGroup').style.display = 'none';
                    document.getElementById('reasonOutGroup').style.display = 'none';
                    document.getElementById('remarkOutGroup').style.display = 'none';

                    // Fetch company_id and department_id based on employeeId
                    fetch(`/api/getEmployeeDetails/${employeeId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            const companyId = data.company_id;
                            const departmentId = data.department_id;

                            // Fetch reasons based on companyId and departmentId
                            return fetch(`/api/getReasons/${companyId}/${departmentId}`);
                        })
                        .then(response => response.json())
                        .then(reasons => {
                            // Populate the reason dropdowns
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
                        })
                        .catch(error => console.error('Error fetching reasons:', error));

                    let inConditionMet = false;
                    let outConditionMet = false;
                    if (innTime === outTime) {
                        remarkInGroup.style.display = 'none';
                            reasonInGroup.style.display = 'none';
                            remarkOutGroup.style.display = 'none';
                            reasonOutGroup.style.display = 'none';
                            document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
                            document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input
                        
                        }
                        else{
                        // Your existing time condition logic...
                        if (innTime > II) {
                            remarkInGroup.style.display = 'block';
                            reasonInGroup.style.display = 'block';
                            document.getElementById('remarkIn').value = 'Your remark for late in';
                            inConditionMet = true;
                        }
                        if (outTime == '00:00') {
                            remarkOutGroup.style.display = 'block';
                            reasonOutGroup.style.display = 'block';
                            document.getElementById('remarkOut').value = 'Your remark for early out';
                            document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                            document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input
                        
                        }

                        if (outTime < OO) {
                            remarkOutGroup.style.display = 'block';
                            reasonOutGroup.style.display = 'block';
                            document.getElementById('remarkOut').value = 'Your remark for early out';
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
                    const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
                    modal.show();
                }
            });
            document.getElementById('reasonInDropdown').addEventListener('change', function () {
                const selectedIn = this.value;
                const selectedOut = document.getElementById('reasonOutDropdown').value;

                // If an "In" reason is selected, check if an "Out" reason is selected
                if (selectedIn && selectedOut) {
                    // You could choose to prevent changing or notify the user here if needed
                    console.log('Both reasons are selected, no changes made.');
                }
            });

            document.getElementById('reasonOutDropdown').addEventListener('change', function () {
                const selectedOut = this.value;
                const selectedIn = document.getElementById('reasonInDropdown').value;

                // If an "Out" reason is selected, check if an "In" reason is selected
                if (selectedIn && selectedOut) {
                    // You could choose to prevent changing or notify the user here if needed
                    console.log('Both reasons are selected, no changes made.');
                }
            });

            document.getElementById('sendButton').addEventListener('click', function () {
                const form = document.getElementById('attendanceForm');

                // Use Fetch API to submit the form
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        const responseMessage = document.getElementById('responseMessage');
                        if (data.success) {
                            responseMessage.innerText = data.message;
                            responseMessage.style.display = 'block'; // Show the message
                            $('#AttendenceAuthorisation').modal('hide'); // Optionally hide the modal
                        } else {
                            responseMessage.innerText = 'Failed to submit attendance request.';
                            responseMessage.classList.remove('text-success');
                            responseMessage.classList.add('text-danger');
                            responseMessage.style.display = 'block'; // Show the message
                        }
                    })

                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request.');
                    });
            });

            function fetchAttendanceData(selectedMonth, year) {
                const monthNumber = monthNames.indexOf(selectedMonth) + 1;
                const employeeId = {{ Auth::user()->EmployeeID }};

                cardHeaders.forEach(header => {
                    header.textContent = `${selectedMonth} ${year}`;
                });

                fetch(`/attendance/${year}/${monthNumber}/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const calendar = document.querySelector('.calendar tbody');
                        calendar.innerHTML = '';

                        const daysInMonth = new Date(year, monthNumber, 0).getDate();
                        const firstDayOfMonth = new Date(year, monthNumber - 1, 1).getDay();

                        let currentRow = document.createElement('tr');
                        let latenessCount = 0;


                        // Get the lateness container
                        const latenessContainer = document.querySelector('.late-atnd');
                        latenessContainer.innerHTML = ''; // Clear previous lateness data

                        // Fill empty cells for the first week
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
                            const today = new Date();
                            today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison
                            // Determine if the day is a Sunday
                            const currentDate = new Date(year, monthNumber - 1, day);
                            if (currentDate.getDay() === 0) { // 0 is Sunday
                                cell.style.backgroundColor = 'rgb(209,243,174)';
                                cell.innerHTML = `<div class="day-num">${day}</div>`; // Just show the day number
                            }
                            else {
                                if (dayData) {
                                    const attValue = dayData.AttValue;
                                    const innTime = dayData.Inn;
                                    const iiTime = dayData.II;
                                    console.log(dayData);

                                    let Atct = 0; // Initialize Atct
                                    if (dayData.InnLate == 1 && dayData.OuttLate == 0) {
                                        Atct = 1;
                                    } else if (dayData.InnLate == 0 && dayData.OuttLate == 1) {
                                        Atct = 2;
                                    } else if (dayData.InnLate == 1 && dayData.OuttLate == 1) {
                                        Atct = 12;
                                    } else if ((dayData.InnLate == 0 || dayData.InnLate === '') && (dayData.OuttLate == 0 || dayData['OuttLate'] === '')) {
                                        Atct = 3;
                                    }
                                    let latenessStatus = '';
                                    if (innTime > iiTime || dayData.Outt < dayData.OO) {
                                        latenessCount++;
                                        latenessStatus = `L${latenessCount}`;

                                        // Determine if we need to add the "danger" class
                                        const punchInDanger = innTime > iiTime ? 'danger' : '';
                                        const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';
                                        // Determine the status label and set up the modal link if needed
                                            let statusLabel = '';
                                            let modalLink = '';

                                            if (dayData.Status === 0) {
                                                statusLabel = 'Request';
                                                modalLink = `
                                                    <a href="#" class="open-modal" 
                                                    data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                                    data-inn="${innTime}" 
                                                    data-out="${dayData.Outt}" 
                                                    data-ii="${dayData.II}" 
                                                    data-oo="${dayData.OO}" 
                                                    data-atct="${Atct}" 
                                                    data-status="${dayData.Status}" 
                                                    data-employee-id="${employeeId}">
                                                        ${statusLabel}
                                                    </a>`;
                                            } 
                                            // else if (dayData.Status === 1) {
                                            //     statusLabel = 'Pending';
                                            // } 
                                            else if (dayData.Status === 1) {
                                                statusLabel = 'Approved';
                                            }
                                            latenessContainer.innerHTML += `
                                        <div class="late-atnd">
                                            <div>
                                                <span class="late-l1">${latenessStatus}</span>
                                                <h6 class="float-start mt-2">${day} ${monthNames[monthNumber - 1]} ${year}</h6>
                                                <div class="float-end mt-1">
                                                    <label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="${statusLabel}">
                                                        ${dayData.Status === 0 ? modalLink : statusLabel}
                                                    </label>
                                                </div>
                                            </div>
                                            <div style="color:#777171; float: left; width: 100%; margin-top:5px;">
                                                <span class="float-start">Punch in <span class="${punchInDanger}"><b>${innTime}</b></span></span>
                                                <span class="float-end">Punch Out <span class="${punchOutDanger}"><b>${dayData.Outt || '00:00'}</b></span></span>
                                            </div>
                                        </div>
                                        `;
                                    }

                                            // Icon logic
                                        let iconHtml = '';
                                        const today = new Date();
                                        const isCurrentMonth = monthNumber === today.getMonth() + 1;
                                        const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month

                                        if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                            if (dayData.Inn > dayData.II || dayData.Outt < dayData.OO || dayData.Inn === dayData.Outt) {
                                                iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                            }
                                        }

                                        // Append iconHtml to your cell if needed
                                        if (iconHtml) {
                                            cell.innerHTML += iconHtml;
                                        }
                                    let attenBoxContent = '';
                                    if (latenessStatus) {
                                        attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    }
                            
                                    switch (attValue) {
                                        case 'P':
                                            attenBoxContent += `<span class="atte-present">P</span>`;
                                            attenBoxContent += `
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" data-employee-id="${employeeId}">
                                                 ${iconHtml}
                                            </a>
                                        `;
                                            break;
                                        case 'A':
                                            attenBoxContent += `<span class="atte-absent">A</span>`;
                                            break;
                                        case 'HO':
                                            attenBoxContent += `<span class="holiday-cal">${attValue}</span>`;
                                            break;
                                        case 'OD':
                                            attenBoxContent += `<span class="atte-OD">${attValue}</span>`;
                                            break;
                                        case 'PH':
                                        case 'CH':
                                        case 'SH':
                                        case 'PL':
                                        case 'FL':
                                            attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                            break;
                                        default:
                                            attenBoxContent += `
                                            <span class="atte-present"></span>
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" data-employee-id="${employeeId}">
                                                 ${iconHtml}
                                            </a>
                                        `;
                                            break;
                                    }


                                            cell.innerHTML = `
                                        <div class="day-num">${day}</div>
                                        <div class="punch-section">
                                            <span><b>In:</b> ${innTime || '00:00'}</span><br>
                                            <span><b>Out:</b> ${dayData.Outt || '00:00'}</span>
                                        </div>
                                        <div class="atten-box">${attenBoxContent}</div>
                                    `;
                                        } 
                                        else {
                                            cell.innerHTML = `
                                        <div class="day-num">${day}</div>
                                        <div class="punch-section">
                                            <span><b>In:</b> 00:00</span><br>
                                            <span><b>Out:</b> 00:00</span>
                                        </div>
                                    `;
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

            // function fetchAttendanceData(selectedMonth, year) {
            //     const monthNumber = monthNames.indexOf(selectedMonth) + 1;
            //     const employeeId = {{ Auth::user()->EmployeeID }};
            //     cardHeaders.forEach(header => {
            //         header.textContent = `${selectedMonth} ${year}`;
            //     });
            //     fetch(`/attendance/${year}/${monthNumber}/${employeeId}`)
            //         .then(response => response.json())
            //         .then(data => {
            //             const calendar = document.querySelector('.calendar tbody');
            //             calendar.innerHTML = '';

            //             const daysInMonth = new Date(year, monthNumber, 0).getDate();
            //             const firstDayOfMonth = new Date(year, monthNumber - 1, 1).getDay();

            //             let currentRow = document.createElement('tr');
            //             let latenessCount = 0;

            //             // Get the lateness container
            //             const latenessContainer = document.querySelector('.late-atnd');
            //             latenessContainer.innerHTML = ''; // Clear previous lateness data

            //             for (let i = 0; i < firstDayOfMonth; i++) {
            //                 const emptyCell = document.createElement('td');
            //                 emptyCell.classList.add('day');
            //                 currentRow.appendChild(emptyCell);
            //             }

            //             for (let day = 1; day <= daysInMonth; day++) {
            //                 const dayData = data.find(record => {
            //                     const recordDate = new Date(record.AttDate);
            //                     return recordDate.getDate() === day && recordDate.getMonth() + 1 === monthNumber;
            //                 });

            //                 const cell = document.createElement('td');
            //                 cell.classList.add('day');
            //                 if (dayData) {
            //                     const attValue = dayData.AttValue;
            //                     const innTime = dayData.Inn;
            //                     const iiTime = dayData.II;

            //                     let latenessStatus = '';
            //                     if (innTime > iiTime) {
            //                         latenessCount++;
            //                         latenessStatus = `L${latenessCount}`;

            //                         // Append lateness info to the lateness container
            //                         latenessContainer.innerHTML += `
            //                             <div class="late-atnd">
            //                                 <div class="">
            //                                     <span class="late-l1">${latenessStatus}</span>
            //                                     <h6 class="float-start mt-2">${day} ${monthNames[monthNumber - 1]} ${year}</h6>
            //                                     <div class="float-end mt-1">
            //                                         <label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="Approval">Approval</label>
            //                                     </div>
            //                                 </div>
            //                                 <div style="color:#777171; float: left; width: 100%; margin-top:5px;">
            //                                     <span class="float-start">Punch in <span class="danger"><b>${innTime}</b></span></span>
            //                                     <span class="float-end">Punch Out ${dayData.Outt || '00:00:00'}</span>
            //                                 </div>
            //                             </div>
            //                         `;
            //                     }

            //                     let attenBoxContent = '';
            //                     if (latenessStatus) {
            //                         attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
            //                     }
            //                     let Atct = 0; // Initialize Atct
            //                     if (dayData['InnLate'] == 1 && dayData['OuttLate'] == 0) {
            //                         Atct = 1;
            //                     } else if (dayData['InnLate'] == 0 && dayData['OuttLate'] == 1) {
            //                         Atct = 2;
            //                     } else if (dayData['InnLate'] == 1 && dayData['OuttLate'] == 1) {
            //                         Atct = 12;
            //                     } else if ((dayData['InnLate'] == 0 || dayData['InnLate'] === '') && (dayData['OuttLate'] == 0 || dayData['OuttLate'] === '')) {
            //                         Atct = 3;
            //                     }

            //                     switch (attValue) {
            //                         case 'P':
            //                             attenBoxContent += `
            //                                 <i class="fas fa-check-circle success"></i>
            //                                 <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}"data-oo="${dayData.OO}" data-atct="${Atct}" data-employee-id="${employeeId}">

            //                                     <i class="fas fa-plus-circle primary"></i>
            //                                 </a>
            //                             `;
            //                             break;
            //                         case 'A':
            //                             attenBoxContent += `<span class="atte-absent">A</span>`;
            //                             break;
            //                         case 'HO':
            //                         case 'PH':
            //                         case 'CH':
            //                         case 'SH':
            //                         case 'OD':
            //                             attenBoxContent += `<span class="holiday-cal">${attValue}</span>`;
            //                             break;
            //                         default:
            //                             attenBoxContent += `
            //                                 <i class="fas fa-check-circle success"></i>
            //                                 <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}"data-oo="${dayData.OO}" data-atct="${Atct}" data-employee-id="${employeeId}">
            //                                     <i class="fas fa-plus-circle primary"></i>
            //                                 </a>
            //                             `;
            //                             break;
            //                     }

            //                     cell.innerHTML = `
            //                         <div class="day-num">${day}</div>
            //                         <div class="punch-section">
            //                             <span><b>In:</b> ${innTime || '00:00:00'}</span><br>
            //                             <span><b>Out:</b> ${dayData.Outt || '00:00:00'}</span>
            //                         </div>
            //                         <div class="atten-box">${attenBoxContent}</div>
            //                     `;
            //                 } else {
            //                     cell.innerHTML = `
            //                         <div class="day-num">${day}</div>
            //                         <div class="punch-section">
            //                             <span><b>In:</b> 00:00:00</span><br>
            //                             <span><b>Out:</b> 00:00:00</span>
            //                         </div>
            //                     `;
            //                 }

            //                 currentRow.appendChild(cell);

            //                 if ((firstDayOfMonth + day) % 7 === 0) {
            //                     calendar.appendChild(currentRow);
            //                     currentRow = document.createElement('tr');
            //                 }
            //             }

            //             if (currentRow.childElementCount > 0) {
            //                 calendar.appendChild(currentRow);
            //             }
            //         })
            //         .catch(error => console.error('Error fetching attendance data:', error));
            // }
        });

        $(document).ready(function () {
            $('#leaveForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                const url = $(this).attr('action'); // Form action URL
                const employeeId = {{ Auth::user()->EmployeeID }};
                $.ajax({
                    url: url, // Form action URL
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        alert('Form submitted successfully!');
                        // Fetch the updated leave list
                        fetchLeaveList(employeeId);
                    },
                    error: function (xhr, status, error) {
                        // Handle error response
                        alert('An error occurred: ' + error);
                    }
                });
            });

            function fetchLeaveList(employeeId) {
                $.ajax({
                    url: '{{ route('fetchLeaveList') }}', // Update with your actual route
                    type: 'GET',
                    data: { employee_id: employeeId }, // Pass employee ID
                    success: function (data) {
                        // Assuming 'data' contains the HTML for the leave list
                        $('tbody').html(data.html);
                    },
                    error: function (xhr, status, error) {
                        alert('Could not fetch leave list: ' + error);
                    }
                });
            }
        });

    </script>