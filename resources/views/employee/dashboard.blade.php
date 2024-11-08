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
                                    <li><img style="width:26px;" src="images/new.png"><a href="{{route('salary')}}"><small><b> Ledger
                                                    2023-2024</b></small> </a></li>
                                     <li><a data-bs-toggle="modal" data-bs-target="#healthcard" href=""><small><b>E-Health ID Card</b></small></a></li>                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card chart-card">
                            <div class="card-header-card">
                                <h4 class="has-btn">Today <span class="float-end" style="color:#31767a;" id="currentDate"></span></h4>
                            </div>
                            <div class="card-body">
                                <div class="time-sheet-punchin float-start w-100">
                                    <div class="float-start">
                                        <h6>Punch in <span id="punchIn"><b>00:00 AM</b></span></h6>
                                    </div>
                                    <div class="float-end">
                                        <h6>Punch Out <span id="punchOut"><b>00:00 PM</b></span></h6>
                                    </div>
                                </div>
                                <div id="lastUpdated">
                                    <div style="color:#777171; float: left; width: 100%; margin-top:5px;">
                                        <span class="float-start">Last updated in server <span class="success"><b>Not Available</b></span></span>
                                        <!-- <span class="float-end">Full Leave - <label class="mb-0 badge badge-secondary" title="" data-original-title="CL">CL</label></span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card chart-card" id="leaveRequestCard">
                            <div class="card-header" id="cardheaderrequest">
                                <h4 class="has-btn"></h4>
                            </div>
                            <div class="card-body" style="height:88px; overflow-y:auto;">
                            
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
                                                        <h6 class="mt-2 mb-3">Volume - 27</h6>
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
                            <div class="card-header" id="celebration">
                                <h4 class="has-btn"></h4>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div id="birthdayContainer" class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                        <div class="p-3 border">
                                            <h5 class="mt-2 mb-2">Happy Birthday</h5>
                                            <div id="carouselExampleFadeBirthday" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <a class="carousel-control-prev" href="#carouselExampleFadeBirthday" role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFadeBirthday" role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-outline secondary-outline mt-3 mr-2 sm-btn" data-bs-toggle="modal" data-bs-target="#model5">View All</button>
                                    </div>
                                    <div id="marriageContainer" class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                        <div class="p-3 border">
                                            <h5 class="mt-2 mb-2">Marriage Anniversary</h5>
                                            <div id="carouselExampleFadeAnniversary" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <a class="carousel-control-prev" href="#carouselExampleFadeAnniversary" role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFadeAnniversary" role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-outline secondary-outline mt-3 mr-2 sm-btn" data-bs-toggle="modal" data-bs-target="#model5">View All</button>
                                    </div>
                                    <div id="joiningContainer" class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                        <div class="p-3 border">
                                            <h5 class="mt-2 mb-2">Corporate Anniversary</h5>
                                            <div id="carouselExampleFadeJoinning" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                                <div class="carousel-inner"></div>
                                                <a class="carousel-control-prev" href="#carouselExampleFadeJoinning" role="button" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleFadeJoinning" role="button" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-outline secondary-outline mt-3 mr-2 sm-btn" data-bs-toggle="modal" data-bs-target="#model5">View All</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----Right side --->
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">


                        <div class="card ad-info-card-" id="requestcardsattendance">
                            <div class="card-header">
                                    <h5><b>Team:Attendance Approval</b></h5>
                            </div>
                            <div class="card-body" id="requestCards" style="overflow-y: scroll; overflow-x: hidden;">
                          

                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    
                                    
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
                          

                                <div class="card p-3 mb-3" style="border:1px solid #ddd;">
                                    
                                    
                                </div>
                                <div class="tree col-md-12 text-center mt-4">
                                   
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
                                        <p style="color:#999;">CC to your reporting manager & HOD</p>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name" class="col-form-label"><b>Select Department
                                                        Name</b></label>
                                                <select class="select2 form-control select-opt" id="Department_name"
                                                    name="Department_name">
                                                    <option value="" disabled selected>Select Department</option>
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
                                                    <option value="" disabled selected>Select Subject</option>
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
                                                <textarea class="form-control" placeholder="Enter your remarks"
                                                    id="remarks" name="remarks"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="checkbox">
                                                <input id="checkbox3" type="checkbox" name="hide_name">
                                                <label for="checkbox3" style="padding-top:4px;font-size:11px;color:#646262;">Do you want to hide your name from Reporting
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
                                                
                                                <a href="{{ $job['link'] }}" style="border-radius:3px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1 me-2">
                                                    <small><b>Apply</b></small>
                                                </a>
                                            </div>
                                            <p><small>{{ strip_tags($job['description']) }} 
                                            <a href="#" style="border-radius:3px;" class="link btn-link p-0" data-bs-toggle="modal" data-bs-target="#currentOpening" 
                                            data-jpid="{{ $job['jpid'] }}">View more</a>
                                                <!-- <a class="link btn-link p-0">view...</a> -->
                                            </small></p>
                                            <div>
                                            <span class="me-3"><b><small>Dept.- {{ $job['department'] }}</small></b></span>

                                                @php
                                                $locations = $job['location'] ?? 'NULL'; // Get the location string
                                                $locationsArray = explode(',', $locations); // Split into an array
                                                $firstLocation = $locationsArray[0] ?? 'NULL'; // Get the first element or 'NULL' if it doesn't exist
                                                @endphp

                                                <span class='me-3 float-end'><b><small><i class='fas fa-map-marker-alt me-2'></i> {{ $firstLocation }}</small></b></span>
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

    <!-- Modal for Best Wishes -->
    <div class="modal fade" id="wishesModal" tabindex="-1" aria-labelledby="wishesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wishesModalLabel">Send Best Wishes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalEmployeeName"></p>
                    <p id="modalEmployeeDate"></p>
                    <textarea id="modalMessage" class="form-control" rows="3" placeholder="Write your message here..."></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="sendWishBtn" class="btn btn-primary">Send Wishes</button>
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
    <!-- <div class="modal fade show" id="model4" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
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
    </div> -->

   <!-- Birthday Modal -->
   <div class="modal fade" id="model5" tabindex="-1" aria-labelledby="exampleModalCenterTitle" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Birthday Celebration</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center warning">“Your birthday is the first day of another 365-day journey. Enjoy the ride.”</p>
                <div class="row" id="modalBirthdayContainer"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
     <!--Health card popup-->
     <div class="modal fade show" id="healthcard" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                  <td >1.</td>
                  <td >Emp. Name</td>
                  <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
              </tr>
              <tr>
                  <td >2.</td>
                  <td >Emp. wife name</td>
                  <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
              </tr>
              <tr>
                  <td >3.</td>
                  <td >Child 1</td>
                  <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
              </tr>
              <tr>
                  <td >4.</td>
                  <td >Child 2</td>
                  <td><a class="me-2"><i style="font-size:15px;" class="fas fa-eye"></i></a>|<a class="ml-2"><i style="font-size:15px;" class="fas fa-download"></i></a></td>
              </tr>
          </tbody>			
          </table>    
          </div>
          <div class="modal-footer">
          <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
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
                    <p id="responseMessage" class="text-success" style="display: none;"></p>

                    <p>This option is only for missed attendance or late In-time/early out-time attendance and not for
                        leave applications. <span class="text-danger">Do not apply leave here.</span></p>
                    <br>
                    <p><span id="request-date"></span></p>
                    <form id="attendanceForm" method="POST" action="{{ route('attendance.authorize') }}">
                        @csrf
                        <div id="request-date"></div>
                        <input type="hidden" id="employeeid" name="employeeid">
                        <input type="hidden" id="Atct" name="Atct">
                        <input type="hidden" id="requestDate" name="requestDate">

                        <div class="form-group" id="reasonInGroup" style="display: none;">
                            <label class="col-form-label">Reason In:</label>
                            <select name="reasonIn" class="form-control" id="reasonInDropdown" >
                                <option value="">Select Reason</option>

                            </select>
                        </div>

                        <div class="form-group" id="remarkInGroup" style="display: none;">
                            <label class="col-form-label">Remark In:</label> 
                            <input type="text" name="remarkIn" class="form-control" id="remarkIn" placeholder="Enter your remark In">
                        </div>

                        <div class="form-group" id="reasonOutGroup" style="display: none;">
                            <label class="col-form-label">Reason Out:</label>
                            <select name="reasonOut" class="form-control" id="reasonOutDropdown" >
                                <option value="">Select Reason</option>

                            </select>
                        </div>

                        <div class="form-group" id="remarkOutGroup" style="display: none;">
                            <label class="col-form-label">Remark Out:</label>
                            <input type="placeholder" name="remarkOut" class="form-control" id="remarkOut" placeholder="Enter your remark out" >
                        </div>
                        <div class="form-group" id="otherReasonGroup" style="display: none;">
                            <label class="col-form-label">Other Reason:</label>
                            <select name="otherReason" class="form-control" id="otherReasonDropdown" >
                                <option value="">Select Reason</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>


                        <div class="form-group" id="otherRemarkGroup" style="display: none;">
                            <label class="col-form-label">Other Remark:</label>
                            <input type="text" name="otherRemark" class="form-control" id="otherRemark" placeholder="Enter your remark Other" >
                            </div>

                    </form>
                </div>
                <div class="modal-footer" id="modal-footer">
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
                            <input type="text" name="reportRemarkOther" class="form-control" id="reportRemarkOtherReq" >
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
     <!-- LeaveAuthorization modal  -->
    <div class="modal fade" id="LeaveAuthorisation" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
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
                                <input type="text" name="leavetype_day" class="form-control" id="leavetype_day" readonly>
                            </div>
                            <div class="col-md-6" id="statusGroupIn">
                                <label class="col-form-label">Status:</label>
                                <select name="Status" class="form-control" id="StatusDropdown">
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="remarks" class="col-form-label">Remarks:</label>
                                <input type="text" name="remarks_leave" class="form-control" id="remarks_leave" placeholder="Enter your remarks">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendButtonleave">Send</button>
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
            const employeeId = {{ Auth::user()->EmployeeID }};

            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            const monthDropdown = document.getElementById('monthname');
            const cardHeaders = document.querySelectorAll('.card-header h4');
            const cardHeaderRequest = document.querySelector('#cardheaderrequest h4');

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
                // Populate modal with job details
                document.getElementById('modalJobCode').textContent = data[0].jobcode || 'N/A';
                document.getElementById('modalJobDepartment').textContent = data[0].department || 'N/A';
                document.getElementById('modalJobDescription').textContent = stripHtml(data.description) || 'N/A';
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
                    // Determine classes based on conditions
                    const lateClass = (innTime > II) ? 'text-danger' : '';
                    const earlyClass = (outTime < OO) ? 'text-danger' : '';
                    // Initialize content for request-date
                    if (dataexist === 'true') {
                    // Select the modal footer and hide it
                    const modalFooter = document.getElementById('modal-footer');
                        console.log(modalFooter)
                        if (modalFooter) {
                            modalFooter.style.display = 'none';
                        }
                    }
                    console.log(draft);
                // Initialize content for request-date
                let requestDateContent = `
                            <div style="text-align: left;">
                                <b>Request Date: ${date}</b>
                                <span style="color: ${draft === '3' || draft === null ? 'red' : (status === '1' ? 'green' : 'red')}; float: right; ${draft === '0' ? 'display: none;' : ''}">
                                    <b style="color: black; font-weight: bold;">Status:</b> 
                                    ${draft === '3' || draft === null ? 'Draft' : (status === '1' ? 'Approved' : 'Rejected')}
                                </span>
                            </div>
                        `;



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
                    const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
                    modal.show();
                }
            });
            
            

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
                    const leaveRequest = item.leaveRequest;
                    const employeeDetails = item.employeeDetails;

                    if (!leaveRequest || !employeeDetails) return; // Check if data exists

                    const card = document.createElement('div');
                    card.className = 'card p-3 mb-3';
                    card.style.border = '1px solid #ddd';

                    let actionButtons = '';
                    if (leaveRequest.LeaveStatus == '0') {
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
                                data-leavetype_day="${leaveRequest.half_define}">Accept</button>
                            <button class="mb-0 sm-btn effect-btn btn btn-danger reject-btn"  style="padding: 4px 10px; font-size: 10px;"
                                data-employee="${employeeDetails.EmployeeID}" 
                                data-name="${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}" 
                                data-from_date="${leaveRequest.Apply_FromDate}" 
                                data-to_date="${leaveRequest.Apply_ToDate}" 
                                data-reason="${leaveRequest.Apply_Reason}" 
                                data-total_days="${leaveRequest.Apply_TotalDay}" 
                                data-leavetype="${leaveRequest.Leave_Type}"
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
                                <img class="float-start me-2" src="images/${employeeDetails.Image || 'users.png'}">
                                <b>Emp id: ${employeeDetails.EmployeeID}</b>
                                <p>${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}</p>
                            </div>
                            <div class="float-end">
                                ${actionButtons}
                            </div>
                        </div>
                        <div>
                            <label class="mb-0 badge badge-secondary">${leaveRequest.Leave_Type}</label>
                            <span class="me-3 ms-2"><b><small>${leaveRequest.Apply_FromDate}</small></b></span>
                            To <span class="ms-3 me-3"><b><small>${leaveRequest.Apply_ToDate}</small></b></span>
                            <span class="float-end btn-outline primary-outline p-0 pe-1 ps-1">
                                <small><b>${leaveRequest.Apply_TotalDay} Days</b></small>
                            </span>
                        </div>
                        <p><small>${leaveRequest.Apply_Reason} <a data-bs-toggle="modal" data-bs-target="#approvalpopup" href="#" class="link btn-link p-0">..</a></small></p>
                    `;

                    leaveRequestsContainer.appendChild(card);
                });

                // Attach event listeners only after rendering all cards
                attachEventListeners();
            } else {
                leaveRequestsContainer.innerHTML = '<p>No leave requests found for this employee.</p>';
            }
        })
        .catch(error => {
            console.error('Error fetching leave requests:', error);
            leaveRequestsContainer.innerHTML = '<p>Error fetching leave requests.</p>';
        });
}

// Fetch leave requests on page load
fetchLeaveRequests();

function attachEventListeners() {
    const acceptButtons = document.querySelectorAll('.accept-btn');
    const rejectButtons = document.querySelectorAll('.reject-btn');

    acceptButtons.forEach(button => {
        button.addEventListener('click', function() {
            populateModal(this, 'approved');
            $('#LeaveAuthorisation').modal('show');
        });
    });

    rejectButtons.forEach(button => {
        button.addEventListener('click', function() {
            populateModal(this, 'rejected');
            $('#LeaveAuthorisation').modal('show');
        });
    });
}

function populateModal(button, status) {
    document.getElementById('employeename').value = button.getAttribute('data-name');
    document.getElementById('leavetype').value = button.getAttribute('data-leavetype');
    document.getElementById('from_date').value = button.getAttribute('data-from_date');
    document.getElementById('to_date').value = button.getAttribute('data-to_date');
    document.getElementById('total_days').value = button.getAttribute('data-total_days');
    document.getElementById('leavereason').value = button.getAttribute('data-reason');
    document.getElementById('leavetype_day').value = button.getAttribute('data-leavetype_day');
    $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));


    const statusDropdown = document.getElementById('StatusDropdown');
    statusDropdown.value = status; // Set 'approved' or 'rejected'
}

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
                        
                        // Set the message text
                        responseMessage.innerText = data.message;
                        
                        // Show the message box
                        responseMessage.style.display = 'block';

                        if (data.success) {
                            // Apply the success class (green)
                            responseMessage.classList.remove('text-danger'); // Remove danger class if present
                            responseMessage.classList.add('text-success'); // Add success class for green
                        } else {
                            // Apply the danger class (red) for errors
                            responseMessage.classList.remove('text-success'); // Remove success class if present
                            responseMessage.classList.add('text-danger'); // Add danger class for red
                        }
                    })

                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting the request.');
                    });
            });

                    
            // const employeeId = {{ Auth::user()->EmployeeID }}; // Assuming you're using Blade syntax for PHP
            fetchLeaveBalance(employeeId);
            
            const requestCardsContainer = document.getElementById('requestcardsattendance');
            requestCardsContainer.style.display = 'none';

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
                                    <img class="float-start me-2" src="images/users.png">
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
                                    <!-- <a data-bs-toggle="modal" data-bs-target="#approvalpopup" href="#" class="link btn-link p-0">More...</a> -->
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
    const cardContainer = document.querySelector('#leaveRequestCard .card-body');
    cardContainer.innerHTML = ''; // Clear existing content
    leaveRequests.forEach(request => {

        let leaveStatus;
        let statusClass; // Variable to hold the class for styling

        if (request.leaveRequest.LeaveStatus == '1' || request.leaveRequest.LeaveStatus == '2') {
            leaveStatus = 'Approved';
            statusClass = 'success'; // Class for green color
        } else if (request.leaveRequest.LeaveStatus == '0') {
            leaveStatus = 'Pending';
            statusClass = 'danger'; // Class for red color
        } else {
            leaveStatus = 'Unknown';
            statusClass = 'secondary'; // Class for gray color (optional)
        }

        console.log(leaveStatus);


    const cardHtml = `
            <div>
                <label class="mb-0 badge badge-secondary" title="" data-original-title="${request.leaveRequest.Leave_Type}">${request.leaveRequest.Leave_Type}</label>
                <span class="me-3 ms-2"><b><small>${request.leaveRequest.Apply_FromDate}</small></b></span>
                To <span class="ms-3 me-3"><b><small>${request.leaveRequest.Apply_ToDate}</small></b></span>
                
                <span style="padding:4px 8px;font-size: 10px;margin-left: 5px;margin-top: -1px;" class="mb-0 sm-btn effect-btn btn btn-${statusClass} float-end" title="" data-original-title="${leaveStatus}">${leaveStatus}</span>
                <span style="border-radius:3px; margin-left: 5px;" class="float-end btn-outline primary-outline p-0 pe-1 ps-1">
                    <small><b>${request.leaveRequest.Apply_TotalDay} Days</b></small>
                </span>
            </div>
            <p class="my-request-msg">
                <small>${request.leaveRequest.Apply_Reason} <a data-bs-toggle="modal" data-bs-target="#approvalpopup" class="link btn-link p-0">More...</a></small>
            </p>
        `;
        cardContainer.innerHTML += cardHtml; // Append new card HTML
    });

    }


    // Call the function on load
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
                if (celebration) {
                    celebration.textContent = `Celebration's ${selectedMonth} ${year}`;
                }
                if (cardHeaderRequest) {
                    cardHeaderRequest.textContent = `My Request ${selectedMonth} ${year}`;
                }
                fetch(`/attendance/${year}/${monthNumber}/${employeeId}`)
                    .then(response => response.json())
                    .then(data => {
                        const calendar = document.querySelector('.calendar tbody');
                        calendar.innerHTML = '';

                        const daysInMonth = new Date(year, monthNumber, 0).getDate();
                        const firstDayOfMonth = new Date(year, monthNumber - 1, 1).getDay();
                          console.log(data);

                          let punchInTime = '00:00 AM';
                        let punchOutTime = '00:00 PM';
                        let lastUpdatedText = 'Not Available';

                        // Iterate through the attendance data
                        for (const attendance of data) {
                            if (attendance.AttDate === todayString) {
                                punchInTime = attendance.Inn !== '00:00' ? attendance.Inn : '00:00 AM';
                                punchOutTime = attendance.Outt !== '00:00' ? attendance.Outt : '00:00 PM';
                                lastUpdatedText = todayString || 'Not Available';
                                break; // Exit loop once today's record is found
                            }
                        }

                        // Update the HTML elements
                        document.getElementById('punchIn').innerHTML = `<b>${punchInTime}</b>`;
                        document.getElementById('punchOut').innerHTML = `<b>${punchOutTime}</b>`;
                        document.getElementById('lastUpdated').querySelector('b').textContent = lastUpdatedText;
                        document.getElementById('currentDate').textContent = today.toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
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
                                    if (innTime > iiTime || dayData.Outt < dayData.OO) {
                                        latenessCount++;
                                        latenessStatus = `L${latenessCount}`;
                                    }
                                    console.log(dayData);

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
                                    const isCurrentMonth = monthNumber === today.getMonth() + 1;
                                    const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month

                                    if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                        if (dayData.Inn > dayData.II || dayData.Outt < dayData.OO || dayData.Inn === dayData.Outt) {
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        }                                        
                                    }
                                    
                                    let attenBoxContent = '';

                                    if (latenessStatus && dayData.Status === 0) {
                                        attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                    }

                                    if (latenessStatus && dayData.Status === 1) {
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
                                            <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" 
                                            data-employee-id="${employeeId}" data-exist="${dayData.DataExist}"data-status="${dayData.Status}" data-draft="${draft}">
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
                                        case 'SL':
                                        case 'CL':
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


                                    const punchInDanger = dayData.Inn > dayData.II ? 'danger' : '';
                                    const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';

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

                                    if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                            iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                        
                                        
                                    }
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
        $(document).ready(function() {
        $('#sendButtonleave').on('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Gather form data
            var formData = {
                employeename: $('#employeename').val(),
                leavetype: $('#leavetype').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val(),
                total_days: $('#total_days').val(),
                leavereason: $('#leavereason').val(),
                leavetype_day: $('#leavetype_day').val(),
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
                success: function(response) {
                    // Display success or error message based on response
                    if (response.success == true) {
                        if(response.message =="Leave Rejected successfully." || response.message =="Leave already rejected."){
                            $('#responseMessageleave').text(response.message).show().removeClass('text-success').addClass('text-danger');
                        }
                        else{
                        $('#responseMessageleave').text(response.message).show().removeClass('text-danger').addClass('text-success');
                        }
                        // Hide message after 3 seconds
                        setTimeout(() => {
                            $('#responseMessageleave').hide();
                            location.reload(); // Reload the page after hiding the message

                        }, 3000);
                    } else {
                        $('#responseMessageleave').text('Leave rejected. Please check the details.').show().removeClass('text-success').addClass('text-danger');
                        setTimeout(() => {
                            $('#responseMessageleave').hide();
                            location.reload();
                        }, 5000); 
                    
                    }
                },
                error: function(xhr) {
                    // Handle any errors from the server
                    $('#responseMessageleave').text('An error occurred. Please try again.').show().removeClass('text-success').addClass('text-danger');
                    // Do not hide the message until the user closes it
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
                
                for (let index = 0; index < items.length; index += 2) {
                    let carouselItem = '';
                    
                    // Check if it's the first item to be active
                    if (index === 0) {
                        carouselItem = `<div class="carousel-item active"><div class="row">`;
                    } else {
                        carouselItem = `<div class="carousel-item"><div class="row">`;
                    }
                    
                    // Add current item
                    const currentItem = items[index];
                    carouselItem += `
                        <div class="col text-center">
                            <img style="width:150px !important;margin: 0 auto;" class="d-block p-3 w-100" src="${currentItem.image || 'images/users.png'}" alt="">
                            <h6 class="mt-3">${currentItem.Fname} ${currentItem.Sname}</h6>
                            <p>${currentItem.date}</p>
                            <span>
                                <a data-bs-toggle="modal" data-bs-target="#wishesModal" class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1" 
                                   data-employee-id="${currentItem.EmployeeID}" 
                                   data-type="${type}">
                                    <i class="fas fa-birthday-cake mr-1"></i>
                                    <small>Best Wishes</small>
                                </a>
                            </span>
                        </div>
                    `;

                    // Add the next item if it exists
                    if (items[index + 1]) {
                        const nextItem = items[index + 1];
                        carouselItem += `
                            <div class="col text-center">
                                <img style="width:150px !important;margin: 0 auto;" class="d-block p-3 w-100" src="${nextItem.image || 'images/users.png'}" alt="">
                                <h6 class="mt-3">${nextItem.Fname} ${nextItem.Sname}</h6>
                                <p>${nextItem.date}</p>
                                <span>
                                    <a data-bs-toggle="modal" data-bs-target="#wishesModal" class="effect-btn sm-btn btn btn-info mt-2 mr-2 p-1" 
                                       data-employee-id="${nextItem.EmployeeID}" 
                                       data-type="${type}">
                                        <i class="fas fa-birthday-cake mr-1"></i>
                                        <small>Best Wishes</small>
                                    </a>
                                </span>
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
            birthdays.forEach(birthday => {
                        const modalItem = `
                            <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 mt-3 mb-3 text-center">
                                <div class="border p-2">
                                    <img class="d-block w-100 p-2" src="${birthday.image || 'images/users.png'}" alt="">
                                    <h6 class="mt-3">${birthday.Fname} ${birthday.Sname}</h6>
                                    <p>${birthday.date}</p>
                                </div>
                            </div>
                        `;
                        modalBirthdayContainer.innerHTML += modalItem;
                });
            let currentEmployeeData = null;

            // Modal Logic: when "Best Wishes" button is clicked
            const wishesModal = document.getElementById('wishesModal');
            const modalEmployeeName = document.getElementById('modalEmployeeName');
            const modalEmployeeDate = document.getElementById('modalEmployeeDate');
            const modalMessage = document.getElementById('modalMessage');
            const sendWishBtn = document.getElementById('sendWishBtn');

            // When the modal opens, populate the employee's details
            wishesModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; // Button that triggered the modal
                const employeeId = button.getAttribute('data-employee-id');
                const type = button.getAttribute('data-type');
                 console.log(employeeId);
                let employeeData;
                // Find the employee data based on the type (birthday, marriage, joining)
                if (type === 'birthday') {
                    employeeData = birthdays.find(item => item.EmployeeID == employeeId);
                } else if (type === 'marriage') {
                    employeeData = anniversaries.find(item => item.EmployeeID == employeeId);
                } else if (type === 'joining') {
                    employeeData = joinings.find(item => item.EmployeeID == employeeId);
                }

                if (employeeData) {
                    // Store the employee data globally to use later
                    currentEmployeeData = employeeData;

                    modalEmployeeName.textContent = `${employeeData.Fname} ${employeeData.Sname}`;
                    modalEmployeeDate.textContent = `Date: ${employeeData.date}`;
                }
            });

            // Send wishes on "Send Wishes" button click
            sendWishBtn.addEventListener('click', function () {
                const message = modalMessage.value;

                // Ensure the employee data is available before proceeding
                if (!currentEmployeeData) {
                    alert('No employee data found.');
                    return;
                }

                const employeeId = currentEmployeeData.EmployeeID;
                const type = currentEmployeeData.type;  // This can be either 'birthday', 'marriage', 'joining'

                if (message.trim() === '') {
                    alert('Please write a message.');
                    return;
                }

                // Make a POST request to send the wishes
                fetch('/send-wishes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        employee_id: employeeId,
                        type: type,
                        message: message,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Your wishes have been sent!');
                    } else {
                        alert('Failed to send wishes. Please try again later.');
                    }
                })
                .catch(error => {
                    console.error('Error sending wishes:', error);
                    alert('Error sending wishes.');
                });
            });
        })
        .catch(error => console.error('Error fetching birthdays and anniversaries:', error));
});



$(document).ready(function () {
    $('#AttendenceAuthorisation').on('hidden.bs.modal', function () {
        location.reload(); // Reloads the page when the modal is closed
    });
});

</script>