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
                    <div class="header-left ">
                        <div class="header-links d-lg-none">
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

                        @include('employee.navbar');

                    </div>
                </div>
            </div>
        </header>
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
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card chart-card">
                            <div class="card-body p-3" style="height:125px;overflow-y:auto;">
                                <ul>
                                    <li><small><b>TDS Cert. 2023-2024: <a href="">Form-A</a> <a
                                                    href="">Form-B</a></b></small></li>
                                    <li><img style="width:26px;" src="images/new.png"><a href=""><small><b> Ledger
                                                    2023-2024</b></small> </a></li>
                                    <li><a href=""><small><b>E-Health ID Card</b></small></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Today <span class="float-end" style="color:#31767a;">14 August
                                        2024</span></h4>
                            </div>
                            <div class="card-body">
                                <div class="time-sheet-punchin float-start w-100">
                                    <div class="float-start">
                                        <h6>Punch in <span><b>00:00 AM</b></span></h6>
                                    </div>
                                    <div class="float-end">
                                        <h6>Punch Out <span><b>00:00 PM</b></span></h6>
                                    </div>
                                </div>
                                <div class="">
                                    <div style="color:#777171;float: left;width: 100%;margin-top:5px;">
                                        <span class="float-start">Last updated in sever <span class="success"><b>13 Aug,
                                                    11:00 AM </b></span></span>
                                        <span class="float-end">Full Leave - <label class="mb-0 badge badge-secondary"
                                                title="" data-original-title="CL">CL</label></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">My Request</h4>
                            </div>
                            <div class="card-body" style="height:88px;overflow-y:auto;">
                                <div>
                                    <label class="mb-0 badge badge-secondary" title=""
                                        data-original-title="CL">CL</label>
                                    <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                                        class="ms-3 me-3"><b><small>15-05-2024</small></b></span>

                                    <span style="padding:4px 8px;font-size: 10px;margin-left: 5px;margin-top: -1px;"
                                        class="mb-0 sm-btn effect-btn btn btn-primary float-end" title=""
                                        data-original-title="Pending">Pending</span>
                                    <span style="border-radius:3px;"
                                        class="float-end btn-outline primary-outline p-0 pe-1 ps-1">
                                        <small><b>3 Days</b></small>
                                    </span>
                                </div>
                                <p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical emergency
                                        of a close relative. I will have to be away from 2 days. i will resume work
                                        from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"
                                            class="link btn-link p-0">More...</a></small></p>

                            </div>
                        </div>

                        <div class="card p-3 mb-3 d-none" style="border:1px solid #ddd; height:125px;overflow-y:auto;">
                            <div>
                                <label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label>
                                <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                                    class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span
                                    style="border-radius:3px;"
                                    class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                            Days</b></small></span>
                            </div>
                            <p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical emergency of a
                                    close relative. I will have to be away from 2 days. i will resume work from. <a
                                        data-bs-toggle="modal" data-bs-target="#approvalpopup"
                                        class="link btn-link p-0">More...</a></small></p>

                            <div class="mt-2">
                                <span style="padding:6px 13px;font-size: 11px;"
                                    class="mb-0 sm-btn mr-2 effect-btn btn btn-primary" title=""
                                    data-original-title="Pending">Pending</span>
                            </div>
                        </div>

                        <div class="card chart-card d-none">
                            <div class="card-body p-3" style="height:125px;overflow-y:auto;">
                                <div class="row">
                                    <div class="col-md-4 text-center" style="position:relative;">
                                        <a href="">
                                            <img style="width:60px;" src="images/hr-logo.png" /><br>
                                            <small>Hr Policy</small>
                                        </a>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <img style="width:89px;" src="images/Aarohan-final200x200.png" /><br>
                                        <small>Congratulations on R&R</small>
                                    </div>
                                    <div class="col-md-4 text-center float-end">
                                        <a href="">
                                            <img style="width:47px;" src="images/welcome.png" /><br>
                                            <small>Warm Welcome</small>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                        <div class="card chart-card">
                            <div class="card-header">
                                <H4 class="has-btn float-start mt-2"></H4>
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
                            </div>
                        </div>
                        <div class="card chart-card ">
                            <div class="card-header">
                                <h4 class="has-btn float-start mt-1">My Leave</h4>
                                <span><a href="{{ route('attendanceView', ['employeeId' => Auth::user()->EmployeeID]) }}"
                                        class="btn-outline secondary-outline mr-2 sm-btn float-end"
                                        fdprocessedid="msm7d">View All</a></span>
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
                                            <div class="col-md-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>01</b></span></p>
                                            </div>
                                            <div class="col-md-6 text-center">
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
                                            <div class="col-md-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>03</b></span></p>
                                            </div>
                                            <div class="col-md-6 text-center">
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
                                            <div class="col-md-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>04</b></span></p>
                                            </div>
                                            <div class="col-md-6 text-center">
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
                                            <div class="col-md-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>04</b></span></p>
                                            </div>
                                            <div class="col-md-6 text-center">
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
                                            <div class="col-md-6 text-center" style="border-right:1px solid #ddd;">
                                                <p>Used<br><span class="text-secondary"><b>00</b></span></p>
                                            </div>
                                            <div class="col-md-6 text-center">
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
                                    <span><a href="impact.html"
                                            class="btn-outline secondary-outline mr-2 sm-btn float-end"
                                            fdprocessedid="msm7d">View All</a></span>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div class="p-3 border">
                                        <div id="carouselImpact" class="carousel slide carousel-fade text-center"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active row">
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 36" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol36.png" alt="Volume-36"></a>
                                                        <h6 class="mt-2">Volume - 36</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 35" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol35.png" alt="Volume-35"></a>
                                                        <h6 class="mt-2">Volume - 35</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 34" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol34.png" alt="Volume-34"></a>
                                                        <h6 class="mt-2">Volume - 34</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 33" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol33.png" alt="Volume-33"></a>
                                                        <h6 class="mt-2">Volume - 33</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 32" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol32.png" alt="Volume-32"></a>
                                                        <h6 class="mt-2">Volume - 32</h6>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 31" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol31.png" alt="Volume-31"></a>
                                                        <h6 class="mt-2">Volume - 31</h6>
                                                    </div>
                                                </div>

                                                <div class="carousel-item row">
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 30" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol30.png" alt="Volume-30"></a>
                                                        <h6 class="mt-2">Volume - 30</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 29" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol29.png" alt="Volume-29"></a>
                                                        <h6 class="mt-2">Volume - 29</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 28" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol28.png" alt="Volume-28"></a>
                                                        <h6 class="mt-2">Volume - 28</h6>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 27" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol27.png" alt="Volume-27"></a>
                                                        <h6 class="mt-2">Volume - 27</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 26" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol26.png" alt="Volume-26"></a>
                                                        <h6 class="mt-2">Volume - 26</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 25" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol25.png" alt="Volume-25"></a>
                                                        <h6 class="mt-2">Volume - 25</h6>
                                                    </div>
                                                </div>

                                                <div class="carousel-item row">
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 24" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol24.png" alt="Volume-24"></a>
                                                        <h6 class="mt-2">Volume - 24</h6>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 23" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol23.png" alt="Volume-23"></a>
                                                        <h6 class="mt-2">Volume - 23</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 22" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol22.png" alt="Volume-22"></a>
                                                        <h6 class="mt-2">Volume - 22</h6>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 21" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol21.png" alt="Volume-21"></a>
                                                        <h6 class="mt-2">Volume - 21</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 20" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol20.png" alt="Volume-20"></a>
                                                        <h6 class="mt-2">Volume - 20</h6>
                                                    </div>

                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 float-start">
                                                        <a title="Volume 19" href=""><img class="d-block w-100 p-3"
                                                                src="images/impact/Vol19.png" alt="Volume-19"></a>
                                                        <h6 class="mt-2">Volume - 19</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselImpact" role="button"
                                                data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselImpact" role="button"
                                                data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card chart-card">
                            <div class="card-header">
                                <h4 class="has-btn">Todays Celebration</h4>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="p-3 border">
                                            <h5 class="mt-2 mb-2">Happy Birthday</h5>
                                            <div id="carouselExampleFade" class="carousel slide carousel-fade"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/1.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Akash Khandelwal</h6>
                                                                <p>Sale (HQ- Ratlam)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/1.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Akash Khandelwal</h6>
                                                                <p>Sale (HQ- Ratlam)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/3.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mrs. Roshani Das</h6>
                                                                <p>PD (HQ- Raipur)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/3.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mrs. Roshani Das</h6>
                                                                <p>PD (HQ- Raipur)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/4.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/4.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleFade"
                                                    role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFade"
                                                    role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-outline secondary-outline mt-3 mr-2 sm-btn"
                                            data-bs-toggle="modal" data-bs-target="#model5" fdprocessedid="465yuu">View
                                            All</button>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 ">
                                        <div class="p-3 border">
                                            <h5 class="mt-2 mb-2">Happy Marriage Anniversary</h5>
                                            <div id="carouselExampleIndicators" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/4.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/4.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item active">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/3.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/3.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/7.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block p-3 w-100" src="images/7.jpg"
                                                                    alt="">
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a data-bs-toggle="modal"
                                                                        data-bs-target="#bdaypopup"
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i>
                                                                        <small>Best Wishes</small></a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleIndicators"
                                                    role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleIndicators"
                                                    role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-outline secondary-outline mt-3 mr-2 sm-btn"
                                            fdprocessedid="msm7d">View All</button>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                        <div class="p-3 border">
                                            <h5 class="mt-2 mb-2">Congratulations on VNR</h5>
                                            <div id="carouselExampleControls" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active carousel-item-start">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block w-100 p-3" src="images/1.jpg"
                                                                    alt="First slide">
                                                                <span class="vnr-star"><span>1</span></span>
                                                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                                                <p>R&D (HQ- Raipur)</p>
                                                                <span><a
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i><small>Best
                                                                            Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block w-100 p-3" src="images/1.jpg"
                                                                    alt="First slide">
                                                                <span class="vnr-star"><span>1</span></span>
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i><small>Best
                                                                            Wishes</small></a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item carousel-item-next carousel-item-start">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block w-100 p-3" src="images/7.jpg"
                                                                    alt="Second slide">
                                                                <span class="vnr-star"><span>3</span></span>
                                                                <h6 class="mt-3">Mr. Akash</h6>
                                                                <p>Sale (HQ- Ratlam)</p>
                                                                <span><a
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i><small>Best
                                                                            Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block w-100 p-3" src="images/7.jpg"
                                                                    alt="Second slide">
                                                                <span class="vnr-star"><span>3</span></span>
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i><small>Best
                                                                            Wishes</small></a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <div class="row">
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block w-100 p-3" src="images/4.jpg"
                                                                    alt="Third slide">
                                                                <span class="vnr-star"><span>7</span></span>
                                                                <h6 class="mt-3">Mr. Kausal Kumar</h6>
                                                                <p>R&D (HQ- Hyderabad)</p>
                                                                <span><a
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i><small>Best
                                                                            Wishes</small></a></span>
                                                            </div>
                                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                                <img class="d-block w-100 p-3" src="images/4.jpg"
                                                                    alt="Third slide">
                                                                <span class="vnr-star"><span>7</span></span>
                                                                <h6 class="mt-3">Mr. Kunal kumar</h6>
                                                                <p>Sale (HQ- Ratlam)</p>
                                                                <span><a
                                                                        class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1"><i
                                                                            class="fas fa-birthday-cake mr-1"></i><small>Best
                                                                            Wishes</small></a></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleControls"
                                                    role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleControls"
                                                    role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-outline secondary-outline mt-3 mr-2 sm-btn"
                                            fdprocessedid="msm7d">View All</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!----Right side --->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">


                        <div class="card ad-info-card-" id="requestcardsattendance">
                            <div class="card-header">
                                    <h5><b>Attendance Approval</b></h5>
                            </div>
                            <div class="card-body" id="requestCards" style="overflow-y: scroll; overflow-x: hidden;">
                          

                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    
                                    
                                </div>
                                <div class="tree col-md-12 text-center mt-4">
                                   
                                </div>
                            </div>

                        </div>

                        <div class="card ad-info-card-">
                            <div class="card-header">
                                <img style="width:50px;" class="float-start me-3" src="./images/icons/icon3.png">
                                <div class="">
                                    <h5><b>Leave approval for my teams</b></h5>
                                </div>
                            </div>
                            <div class="card-body" style="height: 450px;overflow-y: scroll;overflow-x: hidden;">
                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    <div>
                                        <label class="mb-0 badge badge-secondary" title=""
                                            data-original-title="CL">CL</label>
                                        <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                                            class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span
                                            style="border-radius:3px;"
                                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                                    Days</b></small></span>
                                    </div>
                                    <p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical
                                            emergency of a close relative. I will have to be away from 2 days. i will
                                            resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"
                                                class="link btn-link p-0">More...</a></small></p>



                                    <div class="mt-2">
                                        <a href="" style="padding:6px 13px;font-size: 11px;"
                                            class="mb-0 sm-btn mr-2 effect-btn btn btn-primary" title=""
                                            data-original-title="Pending">Pending</a>
                                    </div>
                                </div>

                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    <div>
                                        <label class="mb-0 badge badge-secondary" title=""
                                            data-original-title="CL">CL</label>
                                        <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                                            class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span
                                            style="border-radius:3px;"
                                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                                    Days</b></small></span>
                                    </div>
                                    <p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical
                                            emergency of a close relative. I will have to be away from 2 days. i will
                                            resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"
                                                href="" class="link btn-link p-0">More...</a></small></p>

                                    <div class="mt-2">
                                        <a href="" style="padding:6px 13px;font-size: 11px;"
                                            class="mb-0 sm-btn mr-2 effect-btn btn btn-success" title=""
                                            data-original-title="Approval">Approved</a>
                                    </div>
                                </div>

                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    <div>
                                        <label class="mb-0 badge badge-secondary" title=""
                                            data-original-title="CL">SL</label>
                                        <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                                            class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span
                                            style="border-radius:3px;"
                                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                                    Days</b></small></span>
                                    </div>
                                    <p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical
                                            emergency of a close relative. I will have to be away from 2 days. i will
                                            resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"
                                                href="" class="link btn-link p-0">More...</a></small></p>

                                    <div class="mt-2">
                                        <a href="" style="padding:6px 13px;font-size: 11px;"
                                            class="mb-0 sm-btn mr-2 effect-btn btn btn-danger" title=""
                                            data-original-title="Approval">Rejected</a>
                                    </div>
                                </div>

                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    <div>
                                        <label class="mb-0 badge badge-secondary" title=""
                                            data-original-title="CL">PL</label>
                                        <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                                            class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span
                                            style="border-radius:3px;"
                                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                                    Days</b></small></span>
                                    </div>
                                    <p style="border-bottom:1px solid #ddd;"><small>I have to attend to a medical
                                            emergency of a close relative. I will have to be away from 2 days. i will
                                            resume work from. <a data-bs-toggle="modal" data-bs-target="#approvalpopup"
                                                href="" class="link btn-link p-0">More...</a></small></p>

                                    <div class="mt-2">
                                        <a href="" style="padding:6px 13px;font-size: 11px;"
                                            class="mb-0 sm-btn mr-2 effect-btn btn btn-success" title=""
                                            data-original-title="Approval">Approval</a>
                                        <a href="" style="padding:6px 13px;font-size: 11px;"
                                            class="mb-0 sm-btn mr-2 effect-btn btn btn-danger" title=""
                                            data-original-title="Approval">Reject</a>
                                    </div>
                                </div>
                                <div class="tree col-md-12 text-center mt-4">
                                    <a href="leave.html" class="btn-outline secondary-outline mr-2 sm-btn"
                                        fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>

                        </div>
                        <div class="card chart-card ">
                            <div class="card-header">
                                <h4 class="has-btn float-start">Query</h4>
                            </div>
                            <div class="card-body" style="height: 275px;overflow-y: auto;">
                                <div id="message" class="alert" style="display: none;"></div>
                                <form id="queryForm" action="{{ route('querysubmit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="employee_id" value="{{ Auth::user()->EmployeeID }}">

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <p>CC to your reporting manager & HOD</p>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name" class="col-form-label"><b>Select Department
                                                        Name</b></label>
                                                <select class="select2 form-control select-opt" id="Department_name"
                                                    name="Department_name">
                                                    <option value="" disabled selected>Select a department</option>
                                                    @php
                                                    $departments = Auth::user()->departments;
                                                    @endphp

                                                    @foreach ($departments as $department)
                                                    <option value="{{ $department->DepartmentId }}">{{
                                                        $department->DepartmentName }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="sel_arrow">
                                                    <i class="fa fa-angle-down"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name_sub" class="col-form-label"><b>Select
                                                        Subject</b></label>
                                                <select class="select2 form-control select-opt" id="Department_name_sub"
                                                    name="Department_name_sub">
                                                    <option value="" disabled selected>Select a Subject</option>
                                                    @php
                                                    $departments_sub = Auth::user()->departmentsWithQueries;
                                                    @endphp

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
                                                <label for="remarks" class="col-form-label"><b>Remarks</b></label>
                                                <textarea class="form-control" placeholder="Additional Remarks"
                                                    id="remarks" name="remarks"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="checkbox">
                                                <input id="checkbox3" type="checkbox" name="hide_name">
                                                <label for="checkbox3">Do you want to hide your name from Reporting
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
                                                <span class="me-3"><b><small>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}. {{ $job['title'] }}</small></b></span>
                                                <a href="#" style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1" 
                                                data-bs-toggle="modal" data-bs-target="#currentOpening" 
                                                data-jpid="{{ $job['jpid'] }}">
                                                    <small><b>View</b></small>
                                                </a>
                                                <a href="{{ $job['link'] }}" style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1 me-2">
                                                    <small><b>Apply</b></small>
                                                </a>
                                            </div>
                                            <p><small>{{ strip_tags($job['description']) }} 
                                                <!-- <a class="link btn-link p-0">view...</a> -->
                                            </small></p>
                                            <div>
                                                <span class="me-3"><b><small> Dept.- {{ $job['department'] }}</small></b></span>
                                                <span class="me-3 float-end"><b><small> <i class="fas fa-map-marker-alt me-2"></i> {{ $job['location']['location'] }}</small></b></span>
                                            </div>
                                        </div>
                                    @endforeach
                            </div>
                            </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center">
                        <div class="row mb-4 mt-4 footer-logo-link">
                            <div class="col">

                            </div>
                            <div class="col" style="border-right:1px solid #ddd;">
                                <a href=""><img src="images/link/Ellipse-6.png" alt=""></a>
                                <br><span>Xeasy</span>
                            </div>
                            <div class="col" style="border-right:1px solid #ddd;">
                                <a href=""><img src="images/link/Ellipse-8.png" alt=""></a>
                                <br><span>Seed Track</span>
                            </div>
                            <div class="col">
                                <a href=""><img src="images/link/Ellipse-9.png" alt=""></a>
                                <br><span>Samadhaan</span>
                            </div>
                            <div class="col">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="ad-footer-btm">
                    <p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> © Copyright 2023 VNR Seeds Private
                        Limited India.</p>
                </div>
            </div>
        </div>
    </div>

    <!--Approval Message-->
    <div class="modal fade show" id="approvalpopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Approval Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label>
                        <span class="me-3 ms-2"><b><small>13-05-2024</small></b></span> To <span
                            class="ms-3 me-3"><b><small>15-05-2024</small></b></span><span style="border-radius:3px;"
                            class="float-end btn-outline primary-outline p-0 pe-1 ps-1"><small><b>3
                                    Days</b></small></span>
                    </div>
                    <p>I have to attend to a medical emergency of a close relative. I will have to be away from 2 days.
                        i will resume work from. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                        ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                        esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                        sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    <!--Birthday Message Send Popup-->
    <div class="modal fade show" id="bdaypopup" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Birthday Wishes</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="mb-2">Akash Khadelwal</h5>
                    <div>
                        <div class="form-group">
                            <label for="additional-msg" class="col-form-label">Your Message</label>
                            <textarea class="form-control" placeholder="Enter your wishes"
                                id="additional-msg"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="effect-btn btn btn-success sm-btn mt-2 mr-2">Send</button>
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal for job details -->
    <div class="modal fade" id="currentOpening" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

    <!--General message-->
    <div class="modal fade show" id="model4" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">General Message</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--birthday modal-->
    <div class="modal fade show" id="model5" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle3">Today Birthday Celebration</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center warning">“Your birthday is the first day of another 365-day journey. Be the
                        shining thread in the beautiful tapestry of the world to make this year the best ever. Enjoy the
                        ride.”</p>
                    <div class="row">
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center ">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center ">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center ">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center ">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center ">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mt-3 mb-3 text-center ">
                            <div class="border p-2">
                                <img class="d-block w-100 p-2" src="images/1.jpg" alt="">
                                <h6 class="mt-3">Mr. Nihal Kumar</h6>
                                <h6 class="degination">R&D (HQ- Raipur)<br>Manager</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <a class="btn-outline secondary-outline mt-2 mr-2 sm-btn" href="all-celebration.html"><i
                            class="fas fa-calendar-alt"></i>&nbsp;&nbsp; View All</a>
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--Attendence Authorisation-->
    <!-- resources/views/attendance/authorization.blade.php -->
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
                            <select name="reasonIn" class="form-control" id="reasonInDropdown"></select>
                        </div>

                        <div class="form-group" id="remarkInGroup" style="display: none;">
                            <label class="col-form-label">Remark In:</label>
                            <input type="text" name="remarkIn" class="form-control" id="remarkIn">
                        </div>

                        <div class="form-group" id="reasonOutGroup" style="display: none;">
                            <label class="col-form-label">Reason Out:</label>
                            <select name="reasonOut" class="form-control" id="reasonOutDropdown"></select>
                        </div>

                        <div class="form-group" id="remarkOutGroup" style="display: none;">
                            <label class="col-form-label">Remark Out:</label>
                            <input type="text" name="remarkOut" class="form-control" id="remarkOut">
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

     <!--Attendence Authorisation modal for reporting-->
    <div class="modal fade" id="AttendenceAuthorisationRequest" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Attendance Authorization</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <p>This option is only for missed attendance or late In-time/early out-time attendance and not for leave applications. <span class="text-danger">Do not apply leave here.</span></p>
                    <br>
                    <p><b>Request Date: </b><span id="request-date"></span></p>
                    <form id="attendance-form" method="POST" action="">
                    <input type="hidden" id="employeeIdInput" name="employeeId">

                        @csrf
                        <div class="form-group" id="statusGroupIn" style="display: none;">
                            <label class="col-form-label">In Status:</label>
                            <select name="inStatus" class="form-control" id="inStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group" id="reasonInGroupReq" style="display: none;">
                            <label class="col-form-label">Reason In:</label>
                            <span id="reasonInDisplay" class="form-control" style="border: none; background: none;"></span>
                        </div>
                        <div class="form-group" id="remarkInGroupReq" style="display: none;">
                            <label class="col-form-label">Remark In:</label>
                            <input type="text" name="remarkIn" class="form-control" id="remarkInReq">
                        </div>
                        <div class="form-group" id="reportRemarkInGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark In:</label>
                            <input type="text" name="reportRemarkIn" class="form-control" id="reportRemarkInReq">
                        </div>
                        <div class="form-group" id="statusGroupOut" style="display: none;">
                            <label class="col-form-label">Out Status:</label>
                            <select name="outStatus" class="form-control" id="outStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group" id="reasonOutGroupReq" style="display: none;">
                            <label class="col-form-label">Reason Out:</label>
                            <span id="reasonOutDisplay" class="form-control" style="border: none; background: none;"></span>
                        </div>

                        <div class="form-group" id="remarkOutGroupReq" style="display: none;">
                            <label class="col-form-label">Remark Out:</label>
                            <input type="text" name="remarkOut" class="form-control" id="remarkOutReq">
                        </div>
                        <div class="form-group" id="reportRemarkOutGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark Out:</label>
                            <input type="text" name="reportRemarkOut" class="form-control" id="reportRemarkOutReq">
                        </div>
                        <div class="form-group" id="statusGroupOther" style="display: none;">
                            <label class="col-form-label">Other Status:</label>
                            <select name="otherStatus" class="form-control" id="otherStatusDropdown">
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="form-group" id="reasonOtherGroupReq" style="display: none;">
                            <label class="col-form-label">Reason :</label>
                            <span id="reasonOtherDisplay" class="form-control" style="border: none; background: none;"></span>
                        </div>

                        <div class="form-group" id="remarkOtherGroupReq" style="display: none;">
                            <label class="col-form-label">Remark :</label>
                            <input type="text" name="remarkOther" class="form-control" id="remarkOtherReq">
                        </div>

                        <div class="form-group" id="reportRemarkOtherGroup" style="display: none;">
                            <label class="col-form-label">Reporting Remark Other:</label>
                            <input type="text" name="reportRemarkOther" class="form-control" id="reportRemarkOtherReq">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendButtonReq">Send</button>
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

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

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
    <div id="floatingChat" class="chat-widget">
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

            monthDropdown.innerHTML = `<option value="select">Select Month</option>`;

            // Populate the dropdown with all months
            for (let i = 0; i < monthNames.length; i++) {
                const month = monthNames[i];
                monthDropdown.innerHTML += `<option value="${month}">${month}</option>`;
            }
            // Optionally select the current month
            monthDropdown.value = monthNames[currentMonthIndex];

            // Add the previous month option
            const previousMonthIndex = (currentMonthIndex - 1 + 12) % 12;
            const previousMonth = monthNames[previousMonthIndex];
            monthDropdown.innerHTML += `<option value="${previousMonth}">${previousMonth}</option>`;

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
                // Populate modal with job details
                document.getElementById('modalJobCode').textContent = data[0].jobcode || 'N/A';
                document.getElementById('modalJobDepartment').textContent = data[0].department || 'N/A';
                document.getElementById('modalJobDescription').textContent = stripHtml(data.description) || 'N/A';
                document.getElementById('modalJobEducation').textContent = data[0].qualification || 'N/A';
                document.getElementById('modalJobWorkExperience').textContent = data[0].work_experience || 'N/A';
                document.getElementById('modalJobSalary').textContent = data[0].salary || 'N/A';
                document.getElementById('modalJobLocation').textContent = data[0].location.location || 'N/A';
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
            document.addEventListener('click', function(event) {
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
                document.getElementById('reasonInDropdown').innerHTML = '';
                document.getElementById('reasonOutDropdown').innerHTML = '';

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
                            });
                        })
                        .catch(error => console.error('Error fetching reasons:', error));

                    let inConditionMet = false;
                    let outConditionMet = false;

                    // Your existing time condition logic...
                    if (innTime > II) {
                        remarkInGroup.style.display = 'block';
                        reasonInGroup.style.display = 'block';
                        document.getElementById('remarkIn').value = 'Your remark for late in';
                        inConditionMet = true;
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
                    }

                    const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
                    modal.show();
            }
            });
            document.getElementById('reasonInDropdown').addEventListener('change', function() {
            const selectedIn = this.value;
            const selectedOut = document.getElementById('reasonOutDropdown').value;

            // If an "In" reason is selected, check if an "Out" reason is selected
            if (selectedIn && selectedOut) {
                // You could choose to prevent changing or notify the user here if needed
                console.log('Both reasons are selected, no changes made.');
            }
        });

        document.getElementById('reasonOutDropdown').addEventListener('change', function() {
            const selectedOut = this.value;
            const selectedIn = document.getElementById('reasonInDropdown').value;

            // If an "Out" reason is selected, check if an "In" reason is selected
            if (selectedIn && selectedOut) {
                // You could choose to prevent changing or notify the user here if needed
                console.log('Both reasons are selected, no changes made.');
            }
        });

        document.getElementById('sendButton').addEventListener('click', function() {
            document.getElementById('attendanceForm').submit();
        });
                    
            const employeeId = {{ Auth::user()->EmployeeID }}; // Assuming you're using Blade syntax for PHP
            fetchLeaveBalance(employeeId);


            fetch(`/fetch-attendance-requests?employee_id=${employeeId}`)
            .then(response => response.json())
            .then(data => {
                const requestCardsContainer = document.getElementById('requestcardsattendance');
                const requestCards = document.getElementById('requestCards');

                // Clear existing content
                requestCards.innerHTML = '';

                if (data.message) {
                    // If there's a message indicating no requests, show a specific card and hide the section
                    requestCardsContainer.style.display = 'none'; // Hide the entire section
                    const noRequestsCard = `
                        <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                            <p>${data.message}</p>
                        </div>
                    `;
                    requestCards.insertAdjacentHTML('beforeend', noRequestsCard);
                } else {
                // Show the section if there are requests
                requestCardsContainer.style.display = 'flex';

                data.forEach(request => {
                    console.log(request);
                    const requestCard = `
                        <div class="late-atnd">
                            <div class="img-thumb mb-1">
                                <div class="float-start emp-request-leave">
                                    <img class="float-start me-2" src="images/7.jpg">
                                    <b>Emp id: ${request.employeeDetails.EmployeeID}</b>
                                    <p>${request.employeeDetails.Fname} ${request.employeeDetails.Sname} ${request.employeeDetails.Lname}</p>
                                </div>
                                <div class="float-end">
                                    <a href="#" 
                                    style="padding: 4px 10px; font-size: 10px;" 
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
                                    data-employee-id="${request.employeeDetails.EmployeeID || 'N/A'}">
                                        Approval
                                    </a>
                                    <a href="#" 
                                    style="padding: 4px 10px; font-size: 10px;" 
                                    class="mb-0 sm-btn effect-btn btn btn-danger reject-btn" 
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
                                    data-employee-id="${request.employeeDetails.EmployeeID || 'N/A'}">
                                        Reject
                                    </a>
                                </div>
                            </div>
                            <div style="color:#777171; float: left; width: 100%; margin-top: 5px;">
                                <b class="float-start mr-2">${new Date(request.request.AttDate).toLocaleDateString('en-GB')}</b>
                                <span class="float-start">
                                    Punch in 
                                    <span class="${(request.InTime > request.II || request.InTime =='00:00:00') ? 'danger' : ''}">
                                        <b>${request.InTime || 'N/A'}</b>
                                    </span>
                                </span>
                                <span class="float-end">
                                    Punch Out 
                                    <span class="${(request.OutTime < request.OO) ? 'danger' : ''}">
                                        <b>${request.OutTime || 'N/A'}</b>
                                    </span>
                                </span>
                                <br>
                               <p>
                                <small>
                                    ${request.request.Remark ? request.request.Remark : request.request.InRemark ? request.request.InRemark : 'No additional information.'}
                                    <a data-bs-toggle="modal" data-bs-target="#approvalpopup" href="#" class="link btn-link p-0">More...</a>
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
                        <div class="col-md-6 text-center" style="border-right:1px solid #ddd;">
                            <p>Used<br><span class="text-secondary"><b>${leave.used}</b></span></p>
                        </div>
                        <div class="col-md-6 text-center">
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

        function fetchAttendanceData(selectedMonth, year) {
                const monthNumber = monthNames.indexOf(selectedMonth) + 1;
                const employeeId = {{ Auth::user()->EmployeeID }};
                // const monthYearHeader = document.querySelector('.card-header h4');
                // monthYearHeader.textContent = `${selectedMonth} ${year}`;
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
                                    const attValue = dayData.AttValue;
                                    const innTime = dayData.Inn;
                                    const iiTime = dayData.II;

                                    let latenessStatus = '';
                                    if (innTime > iiTime) {
                                        latenessCount++;
                                        latenessStatus = `L${latenessCount}`;
                                    }

                                    let attenBoxContent = '';
                                    let latenessDisplayed = false; // Flag to track if lateness has already been displayed
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
                                    const today = new Date();
                                    today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

                                    let iconHtml = '';
                                    if (latenessStatus || currentDate >= today) {
                                        // Check conditions for Inn and Outt
                                        if (!(dayData.Inn === dayData.II || dayData.Inn < dayData.II)) {
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        }
                                        if (!(dayData.Outt === dayData.OO || dayData.Outt > dayData.OO)) {
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        }
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


                                    // If the attendance value is 'P', check for lateness but do not repeat it
                                    if (attValue === 'P' && latenessStatus && !latenessDisplayed) {
                                        attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`;
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
        });
        $(document).ready(function () {
            $('#queryForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission
                const url = $(this).attr('action'); // Form action URL

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    type: 'POST',
                    data: $(this).serialize(),

                    success: function (response) {
                        $('#message').removeClass('alert-danger').addClass('alert-success').text('Form submitted successfully!').show();
                        $('#queryForm')[0].reset();
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 3000);
                    },
                    error: function (xhr, status, error) {
                        $('#message').removeClass('alert-success').addClass('alert-danger').text('An error occurred: ' + error).show();
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
            const isReject = button.classList.contains('reject-btn');

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
            document.getElementById('request-date').textContent = requestDate;

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
            if (isInReasonValid && isOutReasonValid) {
                // Show both "In" and "Out" sections
                document.getElementById('statusGroupIn').style.display = 'block';
                document.getElementById('reasonInGroupReq').style.display = 'block';
                document.getElementById('remarkInGroupReq').style.display = 'block';
                document.getElementById('reportRemarkInGroup').style.display = 'block';
                document.getElementById('reasonInDisplay').textContent = inReason; 
                document.getElementById('remarkInReq').value = button.getAttribute('data-in-remark');

                document.getElementById('statusGroupOut').style.display = 'block';
                document.getElementById('reasonOutGroupReq').style.display = 'block';
                document.getElementById('remarkOutGroupReq').style.display = 'block';
                document.getElementById('reportRemarkOutGroup').style.display = 'block';
                document.getElementById('reasonOutDisplay').textContent = outReason; 
                document.getElementById('remarkOutReq').value = button.getAttribute('data-out-remark');
            } else if (isInReasonValid) {
                // Show only "In" section
                document.getElementById('statusGroupIn').style.display = 'block';
                document.getElementById('reasonInGroupReq').style.display = 'block';
                document.getElementById('remarkInGroupReq').style.display = 'block';
                document.getElementById('reportRemarkInGroup').style.display = 'block';
                document.getElementById('reasonInDisplay').textContent = inReason; 
                document.getElementById('remarkInReq').value = button.getAttribute('data-in-remark');
            } else if (isOutReasonValid) {
                // Show only "Out" section
                document.getElementById('statusGroupOut').style.display = 'block';
                document.getElementById('reasonOutGroupReq').style.display = 'block';
                document.getElementById('remarkOutGroupReq').style.display = 'block';
                document.getElementById('reportRemarkOutGroup').style.display = 'block';
                document.getElementById('reasonOutDisplay').textContent = outReason; 
                document.getElementById('remarkOutReq').value = button.getAttribute('data-out-remark');
            } else if (!isInReasonValid && !isOutReasonValid && isOtherReasonValid) {
                // Show "Other" section only
                document.getElementById('statusGroupOther').style.display = 'block';
                document.getElementById('reasonOtherGroupReq').style.display = 'block';
                document.getElementById('remarkOtherGroupReq').style.display = 'block';
                document.getElementById('reportRemarkOtherGroup').style.display = 'block';
                document.getElementById('reasonOtherDisplay').textContent = otherReason; 
                document.getElementById('remarkOtherReq').value = button.getAttribute('data-other-remark');
            }
        });

                

        document.getElementById('sendButtonReq').addEventListener('click', function () {
    const requestDate = document.getElementById('request-date').textContent;
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

    // Send the data using fetch
    fetch(`/attendance/updatestatus`, { 
        method: 'POST',
        body: formData,
    })
    .then(response => {
        // Log the raw response for debugging
        return response.text().then(text => {
            console.log('Raw response:', text); // Log the raw response
            // Check if the response is OK (status in the range 200-299)
            if (response.ok) {
                // Check if the response text is not empty
                if (text) {
                    return JSON.parse(text); // Parse JSON if text is not empty
                } else {
                    throw new Error('Empty response from server');
                }
            } else {
                throw new Error(text); // Reject with the raw text if not OK
            }
        });
    })
    .then(data => {
        // Handle the JSON data returned from the server
        if (data.success) {
            alert('Data sent successfully!');
            $('#AttendenceAuthorisationRequest').modal('hide');
        } else {
            alert( data.message);
            location.reload();
        }
    })
    .catch(error => {
            // Handle any errors that occurred during the fetch
            console.error('Error:', error);
            alert('There was a problem with your fetch operation: ' + error.message);
        });

        });
    
        function stripHtml(html) {
    const div = document.createElement('div');
    div.innerHTML = html;
    return div.textContent || div.innerText || '';
}
    </script>